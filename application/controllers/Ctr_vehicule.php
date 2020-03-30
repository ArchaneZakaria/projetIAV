<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/Master.php';
class Ctr_vehicule extends Master
{ private $CI;
  function __construct() {
      parent::__construct();
        $this->load->model('Iav_marque_model', 'marque');
        $this->load->model('Iav_model_model', 'model');
        $this->load->model('Iav_affectation_model', 'affectation');
        $this->load->model('Iav_departement_model', 'departement');
        $this->load->model('Iav_chauffeur_model','chauffeur');
        $this->load->model('Iav_vehicule_model','vehicule');
        $this->load->library('form_validation');
        $this->load->library('session');
         $this->CI = &get_instance();
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
     $modeles      = $this->model->read("*",array('deleted_model'=>'N'));
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
                                                    'vehicule'=>$vehicule->result()));
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

	   $this->form_validation->set_rules('vehicule_carburant', 'vehicule_carburant', 'callback_validation_check');
	   $this->form_validation->set_rules('vehicule_clssgenre', 'vehicule_clssgenre', 'callback_validation_check');
       $this->form_validation->set_rules('vehicule_typeVehicle', 'vehicule_typeVehicle', 'callback_validation_check');
       $this->form_validation->set_rules('vehicule_model', 'vehicule_model', 'callback_validation_check');
       $this->form_validation->set_rules('vehicule_marque', 'vehicule_marque', 'callback_validation_check');
       $this->form_validation->set_rules('vehicule_departement', 'vehicule_departement', 'callback_validation_check');
       $this->form_validation->set_rules('vehicule_chauffeur', 'vehicule_chauffeur', 'callback_validation_check');
       $this->form_validation->set_rules('vehicule_tauxComnsom', 'Taux de consommation est obligatoire', 'required|trim',
                               array('required' => 'Le champs Taux de consommation est obligatoire'));

       $this->form_validation->set_rules('vehicule_matricule', 'matricule  est obligatoire', 'required|trim',
                               array('required' => 'Le champs matricule est obligatoire'));
       $this->form_validation->set_rules('vehicule_dateMisEnCirc', 'dateMisEnCirc  est obligatoire', 'required|trim',
                               array('required' => 'Le champs date Mise En circulation est obligatoire'));
	   $this->form_validation->set_rules('vehicule_typeVehicule', 'vehicule_typeVehicule  est obligatoire', 'required|trim',
	   array('required' => 'Le champs type de véhicule est obligatoire'));
		$this->form_validation->set_rules('vehicule_ptc', 'vehicule_ptc  est obligatoire', 'required|trim',
	   array('required' => 'Le champs ptc est obligatoire'));
	   $this->form_validation->set_rules('vehicule_nbr_place', 'vehicule_nbr_place  est obligatoire', 'required|trim',
	   array('required' => 'Le champs nombre de place est obligatoire'));
	    $this->form_validation->set_rules('vehicule_puissancefiscale', 'vehicule_puissancefiscale  est obligatoire', 'required|trim',
	   array('required' => 'Le champs puissance fiscale est obligatoire'));
	    $this->form_validation->set_rules('vehicule_nbrCylindre', 'vehicule_nbrCylindre  est obligatoire', 'required|trim',
	   array('required' => 'Le champs nombre de cylindre est obligatoire'));
	    $this->form_validation->set_rules('vehicule_vin', 'vehicule_vin  est obligatoire', 'required|trim',
	   array('required' => 'Le champs Numero Vin est obligatoire'));


      if ($this->form_validation->run()) {

        $matricule         = $this->input->post('vehicule_matricule');
        $Designation       = $this->input->post('vehicule_desgn');
        $dateMisEnCirc     = $this->input->post('vehicule_dateMisEnCirc');
        $date_MisEnRef     = $this->input->post('vehicule_date_MisEnRef');

		$marque            = $this->input->post('vehicule_marque');
        $typeVehicle       = $this->input->post('vehicule_typeVehicule');
		$clssgenre         = $this->input->post('vehicule_clssgenre');
		$ptc               = $this->input->post('vehicule_ptc');
		$nbr_place         = $this->input->post('vehicule_nbr_place');
		$puissancefiscale  = $this->input->post('vehicule_puissancefiscale');
		$nbrCylindre       = $this->input->post('vehicule_nbrCylindre');
		$carburant         = $this->input->post('vehicule_carburant');
		$vin              = $this->input->post('vehicule_vin');

		$tautconsom        = $this->input->post('vehicule_tauxComnsom');
		$affectation       = $this->input->post('vehicule_affectation');
        $model             = $this->input->post('vehicule_model');
        $departement      = $this->input->post('vehicule_departement');
        $chauffeur         = $this->input->post('vehicule_chauffeur');




         /*** gestion de date de mise en circulation**/
              $dayM_t   =   explode("/",$dateMisEnCirc);
			  $dayM = $dayM_t['0'];
              $monthM_t = explode("/",$dateMisEnCirc);
			  $monthM = $monthM_t['1'];
              $yearM_t = explode("/",$dateMisEnCirc);
			  $yearM = $yearM_t['2'];
           /*** gestion de date de mise en circulation**/
        $dateMisEnCirc = $dayM.'-'.$monthM.'-'.$yearM;


         /*** gestion de date de mise en reforme**/
		 if($date_MisEnRef != null){
			$dayM_t   =   explode("/",$date_MisEnRef);
			  $dayM = $dayM_t['0'];
              $monthM_t = explode("/",$date_MisEnRef);
			  $monthM = $monthM_t['1'];
              $yearM_t = explode("/",$date_MisEnRef);
			  $yearM = $yearM_t['2'];

           /*** gestion de date de mise en circulation**/
          $date_MisEnRef = $dayM.'-'.$monthM.'-'.$yearM;
		 }
        $newDate_encirc   =  date("Y-m-d", strtotime($dateMisEnCirc));
        $options = array(
          'matricule_vehicule'              => $matricule,
          'designation_vehicule'            => $Designation,
          'datemisecurculation_vehicule'    => $newDate_encirc,
		  'id_marque'                       => $marque,
          'type_vehicule'                   => $typeVehicle,
		  'classe_genre'                    => $clssgenre,
		  'PTC'                             => $ptc ,
		  'nombre_place'                    => $nbr_place ,
		  'puissance_vehicule'              => $puissancefiscale,
		  'nombre_cylindre'                 => $nbrCylindre,
          'id_model'                        => $model,
          'tauxconsom_vehicule'             => $tautconsom,
          'carburant'                       => $carburant,
		  'vin_vehicule'                    => $vin,
          'id_departement'                  => $departement,
          'id_chauffeur'                    => $chauffeur
        );

        $options['id_affectation'] = $affectation;
        $condition_matrcl     = array('matricule_vehicule' => $matricule );
        $rlst_exist_matricule = $this->vehicule->read("*",$condition_matrcl);
        $count_matrcl         = COUNT($rlst_exist_matricule);
        if($count_matrcl == 0 || $data == 'edit'){

          if($date_MisEnRef != null){

              $newDate_enreform            =  date("Y-m-d", strtotime($date_MisEnRef));
              if(strtotime($newDate_encirc) < strtotime($newDate_enreform)){

                $message = "Date fabrication vehicule doit étre superieure  à la date circulation de vehicule";
                echo json_encode(array( 'status' => '0',
                                        'location' => 'url',
                                        'message' => $message));
               return false;
             }
             $options['reforme_vehicule'] = $newDate_enreform;
          }else {
             $options['reforme_vehicule'] = '';
          }
            if($data == 'add'){

            $options['cby_vehicule']  = $this->CI->session->user['id_user'];
            $idvcl        = $this->vehicule->create($options,'cdate_vehicule');
            if($idvcl){
            $sourcePath = $_FILES['file_txt']['tmp_name'];
            $targetPath = UPLOADS_vcl_PATH.'/'.$idvcl.'_'.$_FILES['file_txt']['name'];
            move_uploaded_file($sourcePath,$targetPath) ;
            $options = array('img_vehicule'=>$idvcl.'_'.$_FILES['file_txt']['name']);
            $this->vehicule->update($options,array('id_vehicule' =>$idvcl),'udate_vehicule');
            $message = "Vos informations ont été ajoutées avec succès";
             echo json_encode(array( 'status' => '1',
                                     'location' => 'url',
                                     'message' => $message));
            }else {
              $message = "Erreur De Traitement";
              echo json_encode(array( 'status' => '0',
                                      'location' => 'url',
                                      'message' => $message));
            }
            }else if($this->input->post('id_vehicule') != null ){

              if(isset($newDate_enreform)){
                  $options['reforme_vehicule'] = $newDate_enreform;
              }
              $id_veh    = $this->input->post('id_vehicule');
              $reslt     = $this->vehicule->update($options,array('id_vehicule' =>$id_veh),'udate_vehicule');
              $nom_image = $this->vehicule->read("img_vehicule",array('id_vehicule'=>$id_veh));

          if($reslt){
            if($_FILES['file_txt']['name'] != null){
              $list_img = scandir(UPLOADS_vcl_PATH);
              if(in_array($nom_image[0]->img_vehicule, $list_img)){
                  unlink(UPLOADS_vcl_PATH.'/'.$nom_image[0]->img_vehicule);
              }
              $sourcePath = $_FILES['file_txt']['tmp_name'];
              $targetPath = UPLOADS_vcl_PATH.'/'.$id_veh.'_'.$_FILES['file_txt']['name'];
              move_uploaded_file($sourcePath,$targetPath) ;
              $options = array('img_vehicule'=>$id_veh.'_'.$_FILES['file_txt']['name']);
                $options['uby_vehicule']  = $this->CI->session->user['id_user'];
              $this->vehicule->update($options,array('id_vehicule' =>$id_veh),'udate_vehicule');
            }
            $message = "Vos informations ont été modifiées avec succès";
            echo json_encode(array( 'status' => '1',
                                    'location' => 'url',
                                    'message' => $message));
          }else {
            $message = "Erreur De traitemddddent";
            echo json_encode(array( 'status' => '0',
                                    'location' => 'url',
                                    'message' => $message));
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
       case 'etab':
       $id            = $this->input->post('id');
          $options = array();
          $departement = $this->departement->read("*",array('id_etablissement' => $id,'deleted_departement' => 'N'));
		   $departs = $this->template->load_view('vehicule/etablissement_view',array('departements' => $departement,'prefix' => 'vehicule'));

          //echo json_encode(array('status' => '1','dep' =>$departement['0']->id_etablissement,'message' => 'test'));
		   echo $departs;
       break;
     }
   }

   public function validation_check($str){
     if ($str == "0"){
             $this->form_validation->set_message('validation_check', ' Le champs  {field} est obligatoire  ');
             return FALSE;
     }
     else{
             return TRUE;
     }
   }
}

?>
