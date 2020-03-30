<?php defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/Master.php';

class Ctr_prestataire extends Master
{
private $CI;
public function __construct(){
    parent::__construct();
    $this->load->library('session');
    $this->CI = &get_instance();
  }
  // action index : une page home pour les prestataires : fournisseurs contient la liste des fournisseurs
  public function index($data = '')
  {
     $this->display($data);
     $this->set_breadcrumb(array("List des prestataires" => ''));
    $this->template->set_partial('container', 'prestataire/list_prestataire_view', array('data' => $data));
     $this->template->title('dd','ee')
                    ->build('body');
  }


public function add($data = '')
  {
     $this->display($data);
    /* $this->set_breadcrumb(array("" => ''));*/
    $this->set_breadcrumb(array("Ajouter prestataire" => ''));
    $this->template->set_partial('container', 'prestataire/add_prestataire_view', array('data' => $data));
     $this->template->title('dd','ee')
                    ->build('body');
  }

   //action prestataire
   public function prestataire($data = '',$id = NULL)
  {
     $this->display($data);
     //charger les models
     $this->load->model('Iav_fournisseur_model');
     $this->load->model('Iav_domaine_actv_model');
     $domaines = $this->Iav_domaine_actv_model->GetAllDomaineM();
    /* $this->set_breadcrumb(array("" => ''));*/
    switch($data){
      case 'add':
      case    'ajouter':
      $this->set_breadcrumb(array("Ajouter prestataire" => ''));
      $this->template->set_partial('container', 'prestataire/add_update_prestataire_view',
                       array('data' => $data,'domaines' =>$domaines,'prefix'=>'fournisseur'));
      break;
      case 'edit':
      case 'modifier':
        //get id et le met dans un array pour le passer en parameter
        $conditions  = array('id_fournisseur' => $id );
        //utilisation d'une fonction parent ::My_model read
        //selection du fournisseru de l' id = x
        $this->set_breadcrumb(array("Modifier prestataire" => ''));
        $fournisseur = $this->Iav_fournisseur_model->read("*",$conditions);
        $this->template->set_partial('container', 'prestataire/edit_prestataire_view',
        array('data' => $data,'fournisseur'=>$fournisseur,'prefix'=>'fournisseur',
               'domaines'=>$domaines));

      break;
      case 'del':
      case   'supprimer':
      break;
     default:
     // get les fournisserus qui ont le paramter deleted = N
     $this->set_breadcrumb(array("List des prestataires" => ''));
     $op_modal = $this->load->view('modals/admin/op_modal_del', '', true);
      $fournisseurs = $this->Iav_fournisseur_model->Getfournisseurs();
      $this->template->set_partial('container', 'prestataire/list_prestataire_view',
      array('data' => $data,'fournisseurs'=>$fournisseurs,'op_modal' => $op_modal));
     }
     $this->template->title('List fournisseurs','IAV')
                    ->build('body');
     }

     public function edit_prestataire()
     {
       $this->load->model('Iav_fournisseur_model');
       $this->load->model('Iav_domaine_actv_model');
       $id = $this->input->post('id');
       $conditions  = array('id_fournisseur' => $id );
       $fournisseur = $this->Iav_fournisseur_model->read("*",$conditions);

     echo json_encode(array( 'status' => '1',
                                      'location' => 'url',
                                    'prefix'=>'fournisseur',
                                    'fournisseur'=>$fournisseur,
                                      ));
     }
     //prestataire


//action domaine activite
     public function Domaine_Acticite($data = '',$id = null)
    {
       $this->display($data);
       $this->load->model('Iav_domaine_actv_model');
       $domaines = $this->Iav_domaine_actv_model->GetAllDomaineM();
      /* $this->set_breadcrumb(array("" => ''));*/
      switch($data){
        case 'add':
        case    'ajouter':
        //$this->template->set_partial('container', 'add_domaineAcct_view', array('data' => $data));
        break;
        case 'edit':
        case 'modifier':
        $this->set_breadcrumb(array("Domaine d'activite" => ''));
        $domaine_modf = $this->Iav_domaine_actv_model->GetDomaineById($id);
        $this->template->set_partial('container', 'prestataire/List_domaineActivite_view', array('data' => $data,
                                     'prefix'=>'Domaine_Acticite','domaines' => $domaines,
                                      'domaine_modf' => $domaine_modf));
        //$this->template->set_partial('container', 'add_update_prestataire_view', array('data' => $data));
        break;
        case 'del':
        case   'supprimer':
        //$this->template->set_partial('container', 'del_prestataire_view', array('data' => $data));
        break;
        default:
       $this->set_breadcrumb(array("Domaine d'activite" => '/SuiviMarcheT/prestataire/domaineActivite/1'));
       $op_modal = $this->load->view('modals/admin/op_modal_del', '', true);
       $this->template->set_partial('container', 'prestataire/List_domaineActivite_view', array('data' => $data,
                                    'prefix'=>'Domaine_Acticite','domaines' => $domaines,'op_modal' => $op_modal));
       }
       $this->template->title('Domaine d activite','IAV')
                      ->build('body');
       }
       //ajax functions
       //ajouter un domaine d'activite
       public function ajouter_domaine()
       {
        $this->load->model('Iav_domaine_actv_model');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('domaine', 'Nom du domaine est obligatoire', 'required|trim',
                                array('required' => 'Nom du domaine est obligatoire'));
           if ($this->form_validation->run()) {
               $domaine       = $this->input->post('domaine');
               $options = array(
                 'libelle_domaineactivite'      => $domaine,
                  'module'      => 'bm'
               );
            $result          = $this->Iav_domaine_actv_model->create($options);
            $message = "Vos informations ont été ajoutées avec succès.";
            echo json_encode(array( 'status' => '1',
                                    'location' => 'url',
                                    'message' => $message));
            }else {
              $errors = validation_errors();
              echo json_encode(array( 'status' => '0',
                                      'location' => 'url',
                                      'message' => $errors));
            }
        }
    //suprimer un domaine
        public function delete_domaine()
        {
          $this->load->model('Iav_domaine_actv_model');
          $id        = $this->input->post('id');
          $result    =  $this->Iav_domaine_actv_model->delete($id);
          if($result){
            $message = "Vos informations ont été supprimées avec succès.";
            echo json_encode(array( 'status' => '1',
                                    'location' => 'url',
                                    'message' => $message));
          }else {
            $message = "Erreur de Traitement.";
            echo json_encode(array( 'status' => '0',
                                    'location' => 'url',
                                    'message' => $message));
          }
        }
        //ajouter un prestataire apres le passage de la validations
       public function Ajouter_prestataire()
       {
         $this->load->library('form_validation');
         $this->load->model('Iav_fournisseur_model');
         $this->form_validation->set_rules('nom', 'Le champs Nom du prestataire est obligatoire', 'required|trim',
                                 array('required' => 'Le champs Nom du prestataire est obligatoire'));
         $this->form_validation->set_rules('tel', 'Le champs Tel  est obligatoire', 'required|trim',
                                 array('required' => ' Le champs Tel est obligatoire'));
         $this->form_validation->set_rules('domaine', 'Le champs Domaine d \'activite  est obligatoire', 'required|trim',
                                 array('required' => ' Le champs  Domaine d \'activite est obligatoire'));
         $this->form_validation->set_rules('email', 'Email  est obligatoire', 'required|trim|valid_email',
                                 array('required' => 'Le champs email  est obligatoire',
                                 'valid_email'=>'L\'Email  n\'est pas valide'));
           if ($this->form_validation->run()) {

                   $id          = $this->input->post('id');
                   $nom         = $this->input->post('nom');
                   $email       = $this->input->post('email');
                   $tel         = $this->input->post('tel');
                   $ville       = $this->input->post('ville');
                   $domaine     = $this->input->post('domaine');
                   $code_frnss  = $nom.rand()."_fourssr";
                   $options     = array (
                                          'nom_fournisseur'   => $nom,
                                          'email_fournisseur' => $email,
                                          'ville_fournisseur' => $ville,
                                          'tel_fournisseur'   => $tel,
                                         'id_domaineactivite' =>$domaine,
                                          'code_fournisseur'  =>$code_frnss
                                         );
             if(isset($id)){
                $date                         = date_create('now')->format('Y-m-d H:i:s');
                $options['udate_fournisseur'] = $date;
                $options['uby_fournisseur'] =   $this->CI->session->user['id_user'];
                $conditions                   = array('id_fournisseur' => $id);
                $result  = $this->Iav_fournisseur_model->update($options,$conditions);
                echo json_encode(array( 'status' => '1',
                                          'location' => 'url',
                                          'message' => "vos informations ont éte modifiées avec succés"));
             }else{
               $options['cby_fournisseur'] =   $this->CI->session->user['id_user'];
               $result      = $this->Iav_fournisseur_model->create($options);
               $message = "Vos informations ont été ajoutées avec succès.";
               echo json_encode(array( 'status' => '1',
                                       'location' => 'url',
                                       'message' => $message));
             }
           }else {
               $errors = validation_errors();
               echo json_encode(array( 'status' => '0',
                                       'location' => 'url',
                                       'message' => $errors));
             }

       }

     //   public function modifier_prestataire($value='')
     //   {
     //     $this->load->model('Iav_domaine_actv_model');
     //     $this->load->library('form_validation');
     //     $this->form_validation->set_rules('nom', 'Nom du prestataire est obligatoire', 'required|trim',
     //                             array('required' => 'Nom du prestataire est obligatoire pour la modification'));
     //
     //
     //
     // if ($this->form_validation->run()) {
     //     $nom   = $this->input->post('nom_fournisseur');
     //     $id    = $this->input->post('id');
     //     $ville = $this->input->post('ville');
     //     $email  = $this->input->post('email');
     //     $id_domaine= $this->input->post('id_domaineactivite');
     //     $udate  = date_create('now')->format('Y-m-d H:i:s');
     //     $options = array(
     //       'id_domaineactivite'       => $id_domaine,
     //       'nom_fournisseur'         => $udate,
     //       'ville_fournisseur'         => $udate,
     //       'tel_fournisseur'         => $udate,
     //       'email_fournisseur'         => $udate,
     //       'udate_fournisseur' =>$udate
     //
     //     );
     //  $conditions      = array('id_fournisseur' => $id);
     //  $result          = $this->Iav_domaine_actv_model->update($options,$conditions);
     //  $message = "Vos informations ont été modifiées avec succès.";
     //  echo json_encode(array( 'status' => '1',
     //                          'location' => 'url',
     //                          'message' => $message));
     //  }else {
     //    $errors = validation_errors();
     //    echo json_encode(array( 'status' => '0',
     //                            'location' => 'url',
     //                            'message' => $errors));
     //  }
     //
     //
     //   }




       public function Delete_fournisseur()
       {
         $this->load->model('Iav_fournisseur_model');
         $id        = $this->input->post('id');
         $conditions = array('id' => $id );
         $result    =  $this->Iav_fournisseur_model->DeleteByupdate($conditions);
         if($result){
           $message = "Vos informations ont été supprimées avec succès.";
           echo json_encode(array( 'status' => '1',
                                   'location' => 'url',
                                   'message' => $message));
         }else {
           $message = "Erreur de Traitement.";
           echo json_encode(array( 'status' => '0',
                                   'location' => 'url',
                                   'message' => $message));
         }
       }
       public function modifier_domaine($value='')
       {
         $this->load->model('Iav_domaine_actv_model');
         $this->load->library('form_validation');
         $this->form_validation->set_rules('domaine', 'Nom du domaine est obligatoire', 'required|trim',
                                 array('required' => 'Nom du domaine est obligatoire pour la modification'));
     if ($this->form_validation->run()) {
         $domaine       = $this->input->post('domaine');
         $id            = $this->input->post('id');
         $udate         = date_create('now')->format('Y-m-d H:i:s');
         $options = array(
           'libelle_domaineactivite'       => $domaine,
           'udate_domaineactivite'         => $udate
         );
      $conditions      = array('id_domaineactivite' => $id);
      $result          = $this->Iav_domaine_actv_model->update($options,$conditions);
      $message = "Vos informations ont été modifiées avec succès.";
      echo json_encode(array( 'status' => '1',
                              'location' => 'url',
                              'message' => $message));
      }else {
        $errors = validation_errors();
        echo json_encode(array( 'status' => '0',
                                'location' => 'url',
                                'message' => $errors));
      }


       }

}
?>
