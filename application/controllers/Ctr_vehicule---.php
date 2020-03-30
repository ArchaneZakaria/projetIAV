<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/Master.php';
class Ctr_vehicule extends Master
{
  function __construct() {
      parent::__construct();
        $this->load->model('iav_marque_model', 'marque');
        $this->load->model('iav_model_model', 'model');
        $this->load->model('iav_affectation_model', 'affectation');
        $this->load->model('Iav_departement_model', 'departement');
        $this->load->model('Iav_chauffeur_model','chauffeur');
        $this->load->model('iav_vehicule_model','vehicule');
        $this->load->library('form_validation');
  }
  public function index($data = '')
  {
    $this->display($data);
      $this->set_breadcrumb(array("List vehicule" => ''));
    $this->template->set_partial('container', 'vehicule/list_vehicule_view', array('data' => $data));
    $this->template->title('IAV','List des Vehicules')->build('body');
  }
  public function vehicule($data = '',$id = null){
     $this->display($data);
     $marques      = $this->marque->read("*");
     $modeles      = $this->model->read("*");
     $affectations = $this->affectation->read("*");
     $departements = $this->departement->getDepartementServiceWithEtablissement();
     $Chauffeurs   = $this->chauffeur->listeChauffeurs();
     $queryDetail = $this->vehicule->GetVehicule_Alldata();
    /* $this->set_breadcrumb(array("" => ''));*/
              switch($data){
              case 'add':
              case    'ajouter':
              $this->set_breadcrumb(array("Ajouter vehicule" => ''));
              $this->template->set_partial('container', 'vehicule/add_update_vehicule_view',
                                            array('data'         => $data,'prefix'=>'vehicule','marques' => $marques,
                                                  'modeles'      => $modeles,'affectations'   =>$affectations,
                                                  'departements' => $departements,'chauffeurs'=>$Chauffeurs));
              break;
              case 'edit':
              case    'modifier':
              $this->set_breadcrumb(array("Modifier vehicule" => ''));
              $vehicule = $this->vehicule->GetVehicule_Alldata($id);
              $this->template->set_partial('container', 'vehicule/edit_vehicule_view',
                                            array('data'         => $data,'prefix'=>'vehicule','marques' => $marques,
                                                  'modeles'      => $modeles,'affectations'   =>$affectations,
                                                  'departements' => $departements,'chauffeurs'=>$Chauffeurs,
                                                    'vehicule'=>$vehicule));
              break;
              case 'del':
              case  'supprimer':
              //$this->template->set_partial('container', 'del_vehicule_view', array('data' => $data));
               break;
               default:
              $this->set_breadcrumb(array("List vehicule" => ''));
              $this->template->set_partial('container', 'vehicule/list_vehicule_view', array('data' => $data,
                                            'queryDetail'=>$queryDetail));
              }
              $this->template->title('IAV',' Gestion des Vehicules')
                    ->build('body');
   }

   public function vehiculeAjaxSet($data = null) {
       switch($data){
         case 'add':
         case 'edit':
         $this->form_validation->set_rules('tautconsom', 'Taux de consommation est obligatoire', 'required|trim',
                                 array('required' => 'Le champs Taux de consommation est obligatoire'));
         $this->form_validation->set_rules('Puissance', 'Puissance  est obligatoire', 'required|trim',
                                 array('required' => 'Le champs Puissance est obligatoire'));
         $this->form_validation->set_rules('matricule', 'matricule  est obligatoire', 'required|trim',
                                 array('required' => 'Le champs matricule est obligatoire'));
         $this->form_validation->set_rules('dateMisEnCirc', 'dateMisEnCirc  est obligatoire', 'required|trim',
                                 array('required' => 'Le champs date Mise En circulation est obligatoire'));

        if ($this->form_validation->run()) {
          $matricule         = $this->input->post('matricule');
          $Designation       = $this->input->post('Designation');
          $dateMisEnCirc     = $this->input->post('dateMisEnCirc');
          $date_MisEnRef     = $this->input->post('date_MisEnRef');
          $typeVehicle       = $this->input->post('typeVehicle');
          $marque            = $this->input->post('marque');
          $model             = $this->input->post('model');
          $tautconsom        = $this->input->post('tautconsom');
          $Puissance         = $this->input->post('Puissance');
          $affectation       = $this->input->post('affectation');
          $departement       = $this->input->post('departement');
          $chauffeur         = $this->input->post('chauffeur');
          $images            = $this->input->post('images');

          $dateMisEnCirc    =  strtr($dateMisEnCirc, '/', '-');
          $newDate_encirc   =  date("Y-m-d", strtotime($dateMisEnCirc));

          $options = array(
            'matricule_vehicule'              => $matricule,
            'designation_vehicule'            => $Designation,
            'datemisecurculation_vehicule'    => $newDate_encirc,
            'type_vehicule'                   => $typeVehicle,
            'id_model'                        => $model,
            'tauxconsom_vehicule'             => $tautconsom,
            'puissance_vehicule'              => $Puissance,
            'id_departement'                  => $departement,
            'id_chauffeur'                    => $chauffeur
          );
          if($date_MisEnRef != " "){
            $date_MisEnRef               =  strtr($date_MisEnRef, '/', '-');
            $newDate_enreform            =  date("Y-m-d", strtotime($date_MisEnRef));
            $options['reforme_vehicule'] = $newDate_enreform;
          }
          $date_MisEnRef    =  strtr($date_MisEnRef, '/', '-');
          $newDate_enreform =  date("Y-m-d", strtotime($date_MisEnRef));
          $options['id_affectation'] = $affectation;
          $condition_matrcl     = array('matricule_vehicule' => $matricule );
          $rlst_exist_matricule = $this->vehicule->read("*",$condition_matrcl);
          $count_matrcl         = COUNT($rlst_exist_matricule);
          if($count_matrcl == 0 || $data == 'edit'){
            if($options['reforme_vehicule']<$options['datemisecurculation_vehicule'] && $options['reforme_vehicule'] != " " ){
              $message = "Date reforme vehicule doit étre superieure  à la date circulation de vehicule";
              echo json_encode(array( 'status' => '0',
                                      'location' => 'url',
                                      'message' => $message));
            }else {
              if($data == 'add'){

                 $names      = explode('\\',$images);
                $name       = $names[sizeof($names)-1];
                $options['img_vehicule'] = $name;
                $url = $images;
             /*   $path = pathinfo($url);
                $extension = isset($path['extension']) ? strtolower($path['extension']) : null;*/
               // if(in_array($extension, array('jpg','jpeg','png','gif')))
                //{
               /* $dossier = "C:/wamp64/www/ivh-parc-auto/uploads/vehicule/";
                $nouveau_nom = $name;
                $current = file_get_contents($url);
                file_put_contents($dossier.$nouveau_nom, $current);*/
                //}




              if (!empty($_FILES['file_txt']['name'])) {
                $config = array();
                $config['upload_path'] = UPLOADS_PROFILE_VCL_PATH;
                $config['allowed_types'] = UPLOADS_IMG_ALLOWED_TYPES;
                //                $config['max_size'] = UPLOADS_IMG_MAX_SIZE;
                //                $config['max_width'] = UPLOADS_IMG_MAX_WIDTH;
                //                $config['max_height'] = UPLOADS_IMG_MAX_HEIGHT;
                $config['encrypt_name'] = true;
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload($prefix . '_img'))
                    $errors = $this->upload->display_errors();
                else
                    $file_image_data = $this->upload->data();
            }



                $reslt   = $this->vehicule->create($options,'cdate_vehicule');
                if($reslt){
                 $message = "Vos informations ont été ajoutées avec succès";
                 echo json_encode(array( 'status' => '1',
                                         'location' => 'url',
                                         'message' => $message
                                         ));
                }else {
                  $message = "Erreur De Traitement";
                  echo json_encode(array( 'status' => '0',
                                          'location' => 'url',
                                          'message' => $message));
                }
              }else if($this->input->post('id_vehicule') != null ){
                $id_veh = $this->input->post('id_vehicule');
                if($images != ""){
                      $names      = explode('\\',$images);
                      $name       = $names[sizeof($names)-1];
                      $options['img_vehicule'] = $name;
                      $url = $images;
                      $path = pathinfo($url);
                      $extension = isset($path['extension']) ? strtolower($path['extension']) : null;
                   /*   if(in_array($extension, array('jpg','jpeg','png','gif')))
                      {
                    	$dossier = "C:\wamp1\www\ivh-parc-auto\uploads";
                    	$nouveau_nom = $name;
                    	$current = file_get_contents($url);
                    	file_put_contents($dossier.$nouveau_nom, $current);
                      }*/

                }
                $reslt  = $this->vehicule->update($options,array('id_vehicule' =>$id_veh),'udate_vehicule');
                if($reslt){
                  $message = "Vos informations ont été modifiées avec succès";
                  echo json_encode(array( 'status' => '1',
                                          'location' => 'url',
                                          'message' => $message,
                                          'image' => $_FILES['file_txt']['name']));
                }else {
                  $message = "Erreur De traitement";
                  echo json_encode(array( 'status' => '0',
                                          'location' => 'url',
                                          'message' => $message));
                }
              }
            }

          }else if($count_matrcl != 0){
            $message = "Le Matricule est un champs Unique, veuillez essayer un autre Matricule ";
            echo json_encode(array( 'status' => '0',
                                    'location' => 'url',
                                    'message' => $message));
          }
        }else {
          $errors = validation_errors();
          echo json_encode(array('status' => '0',
                                 'location' => 'url',
                                 'message' => $errors));
        }
         break;
         case 'delete':
         case  'supprimer':
         $id            = $this->input->post('id');
         $options = array();
         $options['deleted_vehicule']='O';
         $result  = $this->vehicule->update($options,array('id_vehicule'=>$id),'ddate_vehicule');
         if($result){
           $message = "vos informations ont éte supprimées avec succès";
           echo json_encode(array( 'status' => '1',
                                   'location' => 'url',
                                   'message' => $message));
         }else {
           $message = "Erreur De Traitement";
           echo json_encode(array( 'status' => '0',
                                   'location' => 'url',
                                   'message' => $message));
         }
         break;
       }
   }
}
?>
