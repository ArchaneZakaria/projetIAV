<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/Master_user.php';

class Ctr_menu extends Master_user
{

 function __construct() {
      parent::__construct();
/*        if (!$this->user_is_connected(USER_TYPE_STUDENT))*/
            /*$this->set_public_message("Vous n'êtes pas connecté, merci de se connecter.", 'info', 'connexion/etudiants');*/

      $this->load->model('Iav_menu_model', 'menu');

    }

  public function index($data = '')
  {

      $this->display($data);
      $this->set_breadcrumb(array("List des menu" => ''));
      $this->template->set_partial('container', 'list_menu_view', array('data' => $data));
      $this->template->title('dd','ee')->build('body');
  }



  public function menu($data='',$id = NULL){

        $this->display($data);
        $by = 1;
        $date = date('Y-m-d H:i:s');

        switch($data){
          case 'add':
            $this->template->set_partial('container', 'add_menu_view', array('data' => $data));
            $this->template->title('dd','ee')->build('body');
            break;

          case 'del':
            $etat_delete = '';
            $conditions = $this->input->post('id');

            /*  if (!is_array($conditions) && intval($conditions))
            $conditions = array('id_etablissement' => intval($conditions));

            $etat_delete = $this->db->delete('etablissement', $conditions);*/
            //$etat_delete = $this->menu->delete($conditions);
            $Etat = "O";
            $etat_delete = $this->db->set('deleted_menu', $Etat);
            $etat_delete = $this->db->set('dby_menu', $by);
            $etat_delete = $this->db->set('ddate_menu', $date);
            $etat_delete = $this->db->where('id_menu', $conditions);
            $etat_delete = $this->db->update('iav_menu');

            if($etat_delete){
              echo json_encode(array('status' => '1',
                                  'url' => 'menu',
                                  'message' => "l'enregistrement a été supprimé avec succees"));
            }else{
              echo json_encode(array('status' => '0',
                                  'url' => 'menu',
                                  'message' => 'Erreur de traitement' ));
            }
            break;

          case 'edit':
            if (($id = intval($id)) && !empty($id) && ($menu = $this->menu->read("*",array('id_menu' => $id)))) {
              $hidden = array('id_menu' => $id);
              $this->template->set_partial('container', 'add_menu_view', array('data' => $data,'menu' => (array) $menu[0],'hidden' => $hidden,'op_btn_value' => 'Modifier'));
            }else{
              redirect(base_url('menu'));
            }

           //$this->template->set_partial('container', 'add_etablissement_view', array('data' => $data));
           $this->template->title('dd','ee')->build('body');
          break;
          default:
            $op_modal = $this->load->view('modals/admin/op_modall', '', true);

            $this->template->set_partial('container', 'list_menu_view', array('data' => $data,'op_modal' => $op_modal));
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
        $by = 1;
        $date = date('Y-m-d H:i:s');

        $this->load->library('form_validation');
        $prefix = 'menu';
        $this->form_validation->set_rules('Application', 'Application Menu', 'required|trim',array('required' => 'Veuillez Selectionnez le champ Application Menu'));
        $this->form_validation->set_rules('Libeller', 'Libeller Menu', 'required|trim',array('required' => 'Champs Libeller Menu est obligatoire'));
        $this->form_validation->set_rules('Url', 'Url Menu', 'required|trim',array('required' => 'Champs Url Menu est obligatoire'));
        $this->form_validation->set_rules('Icone', 'Icone Menu', 'required|trim',array('required' => 'Champs Icone Menu est obligatoire'));


        $errors = false;
        if ($this->form_validation->run()) {
          $Application = $this->input->post('Application');
          $Libeller = $this->input->post('Libeller');
          $Url = $this->input->post('Url');
          $Icone = $this->input->post('Icone');


          if(($id = $this->input->post('id')) ){
            $this->db->set('libeller_menu', $Libeller);
            $this->db->set('url_menu', $Url);
            $this->db->set('icon_menu', $Icone);
            $this->db->set('id_application', $Application);
            $this->db->set('uby_menu', $by);
            $this->db->set('udate_menu', $date);
            $this->db->where('id_menu', $id);
            $this->db->update('iav_menu');
           // $result=$this->menu->update(array('libeller_menu' => $Libeller,'url_menu' => $Url,'icon_menu' => $Icone),$id);

            $message = "Vos informations ont été modifiées avec succès.";

          }else{

            $options=array('id_application' => $Application,
                           'libeller_menu' => $Libeller,
                           'url_menu' => $Url,
                           'icon_menu' => $Icone,
                           'cby_menu' => $by,
                           'cdate_menu' => $date);

            $result = $this->menu->create($options);
            $message = "Vos informations ont été ajouté avec succès.";
          }
          //$this->set_public_message($message, 'success');


          echo json_encode(array('status' => '1',
                                  'location' => 'menu',
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
