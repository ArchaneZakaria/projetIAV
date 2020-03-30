<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/Master_user.php';

class Ctr_application extends Master_user
{

 private $CI;
 function __construct() {
      parent::__construct();
/*        if (!$this->user_is_connected(USER_TYPE_STUDENT))*/
            /*$this->set_public_message("Vous n'êtes pas connecté, merci de se connecter.", 'info', 'connexion/etudiants');*/
			$this->load->library('session');
			$this->CI = &get_instance();
			$this->load->model('Iav_application_model', 'application');

    }

  public function index($data = '')
  {

      $this->display($data);
      $this->set_breadcrumb(array("List des application" => ''));
      $this->template->set_partial('container', 'list_application_view', array('data' => $data));
      $this->template->title('dd','ee')->build('body');
  }



  public function app($data = '',$id = NULL){

        $this->display($data);
        $by = 1;
        $date = date('Y-m-d H:i:s');
        switch($data){
          case 'add':
            $this->template->set_partial('container', 'add_application_view', array('data' => $data));
            $this->template->title('Gestion de parc-auto','auto')->build('body');
            break;

          case 'del':
            $etat_delete = '';
            $conditions = $this->input->post('id');

            /*  if (!is_array($conditions) && intval($conditions))
            $conditions = array('id_etablissement' => intval($conditions));

            $etat_delete = $this->db->delete('etablissement', $conditions);*/
            $Etat = "O";
            $etat_delete = $this->db->set('deleted_application', $Etat);
            $etat_delete = $this->db->set('dby_application', $by);
            $etat_delete = $this->db->set('ddate_application', $date);
            $etat_delete = $this->db->where('id_application', $conditions);
            $etat_delete = $this->db->update('iav_application');

            //$etat_delete = $this->application->delete($conditions);
            if($etat_delete){
              echo json_encode(array('status' => '1',
                                  'url' => 'app',
                                  'message' => "l'enregistrement a été supprimé avec succees"));
            }else{
              echo json_encode(array('status' => '0',
                                  'url' => 'app',
                                  'message' => 'Erreur de traitement' ));
            }
            break;

          case 'edit':
            if (($id = intval($id)) && !empty($id) && ($id_app = $this->application->read("*",array('id_application' => $id)))) {
              $hidden = array('id_application' => $id);
              $this->template->set_partial('container', 'add_application_view', array('data' => $data,'application' => (array) $id_app[0],'hidden' => $hidden,'op_btn_value' => 'Modifier'));
            }else{
              redirect(base_url('app'));
            }

           //$this->template->set_partial('container', 'add_etablissement_view', array('data' => $data));
           $this->template->title('dd','ee')->build('body');
          break;
          default:
            $op_modal = $this->load->view('modals/admin/op_modall', '', true);

            $this->template->set_partial('container', 'list_application_view', array('data' => $data,'op_modal' => $op_modal));
            $this->template->title('dd','ee')->build('body');
          break;
        }




   }

    /**** Ajax **/
    public function aj_test(){

       echo json_encode(array('status' => '1',
                                      'location' => 'url',
                                      'message' => 'test'));

    }

    public function aj_ajouter_modif(){
        $message="";
        $result="";
        $this->load->library('form_validation');
        $prefix = 'app';
        $by = $this->CI->session->user['id_user'];
        $date = date('Y-m-d H:i:s');

        $this->form_validation->set_rules('Nom', 'Nom Application', 'required|trim',array('required' => 'Champs Nom Application est obligatoire'));
        $this->form_validation->set_rules('Url', 'Url Application', 'required|trim',array('required' => 'Champs Url Application est obligatoire'));


        $errors = false;
        if ($this->form_validation->run()) {
          $Libeller = $this->input->post('Nom');
          $Url = $this->input->post('Url');


          if(($id = $this->input->post('id')) ){
            $this->db->set('nom_application', $Libeller);
            $this->db->set('url_application', $Url);
            $this->db->set('uby_application', $by);
            $this->db->set('udate_application', $date);
            $this->db->where('id_application', $id);
            $this->db->update('iav_application');
           /*$result=$this->application->update(array('nom_application'   => $Libeller,
                                                    'url_application'   => $Url,
                                                    'uby_application'   => $by,
                                                    'udate_application' => $date),$id);*/

            $message = "Vos informations ont été modifiées avec succès.";

          }else{

            $options=array('nom_application' => $Libeller,
                           'url_application' => $Url,
                           'cby_application' => $by,
                           'cdate_application' => $date);

            $result = $this->application->create($options);
            $message = "Vos informations ont été ajouté avec succès.";
          }
          //$this->set_public_message($message, 'success');


          echo json_encode(array('status' => '1',
                                  'location' => 'app',
                                  'message' => $message));

        }else{

          $errors = validation_errors();
          if ($errors !== false)

            echo json_encode(array(
                                  'status' => '0',
                                  'location' => 'url',
                                  'message' => $errors));
        }
    }
   /**** Ajax ***/


   public function testaj(){

     $message="";
        $result="";
        $this->load->library('form_validation');
        $prefix = 'menu';
        $this->form_validation->set_rules('Libeller', 'Libeller Menu', 'required|trim',array('required' => 'Champs Libeller Menu est obligatoire'));
        $this->form_validation->set_rules('Url', 'Url Menu', 'required|trim',array('required' => 'Champs Url Menu est obligatoire'));
        $this->form_validation->set_rules('Icone', 'Icone Menu', 'required|trim',array('required' => 'Champs Icone Menu est obligatoire'));


        $errors = false;
        if ($this->form_validation->run()) {

          $Libeller = $this->input->post('Libeller');
          $Url = $this->input->post('Url');
          $Icone = $this->input->post('Icone');



      if(($id = $this->input->post('id'))){
           // $result=$this->menu->update(array('libeller_menu' => $Libeller,'url_menu' => $Url,'icon_menu' => $Icone),$id);

            $message = "Vos informations ont été modifiées avec succès.";

          }else{

           $options=array(
            'libeller_menu' => $Libeller,
            'url_menu' => $Url,
            'icon_menu' => $Icone,
            'id_application' => '266',
          );

           //$result = $this->menu->create($options);
            $message = "Vos informations ont été ajouté avec succès.";
          }


           $message = "Vos informations ont été ajouté avec succès.";

           echo json_encode(array('status' => '1',
                                  'location' => 'url',
                                  'message' => $message));


        }else{

           $errors = validation_errors();
          if ($errors !== false)

            echo json_encode(array(
                                  'status' => '0',
                                  'location' => 'url',
                                  'message' => $errors));
        }



   }




   }  //CLASS
?>
