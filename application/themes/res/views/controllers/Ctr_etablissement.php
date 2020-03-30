<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/Master_user.php';

class Ctr_etablissement extends Master_user
{

 function __construct() {
        parent::__construct();
/*        if (!$this->user_is_connected(USER_TYPE_STUDENT))*/
            /*$this->set_public_message("Vous n'êtes pas connecté, merci de se connecter.", 'info', 'connexion/etudiants');*/

      $this->load->model('Etablissement_model', 'etablissement');

    }

  public function index($data = '')
  {

     $this->display($data);
    $this->set_breadcrumb(array("List des établissements" => ''));
    $this->template->set_partial('container', 'list_etablissement_view', array('data' => $data));
     $this->template->title('dd','ee')
                    ->build('body');
  }



      public function etablissement($data = '',$id = NULL){


              $this->display($data);

              switch($data){

               case 'add':

             $this->set_breadcrumb(array("Ajouter une établissement" => 'mission/add'));
             $this->template->set_partial('container', 'add_etablissement_view', array('data' => $data));
             $this->template->title('dd','ee')
                    ->build('body');
               break;

              case 'del':

             $etat_delete = '';
             $conditions = $this->input->post('id');

            /*  if (!is_array($conditions) && intval($conditions))
            $conditions = array('id_etablissement' => intval($conditions));

          $etat_delete = $this->db->delete('etablissement', $conditions);*/
          $etat_delete = $this->etablissement->delete($conditions);
          if($etat_delete){
          echo json_encode(array('status' => '1',
                                          'url' => 'etablissement',
                                          'message' => "l'enregistrement a été supprimé avec succees"));
         }else{

           echo json_encode(array('status' => '0',
                                  'url' => 'etablissement',
                                  'message' => 'Erreur de traitement' ));
          }

               break;

                 case 'edit':

                if (($id = intval($id)) && !empty($id) && ($etablissement = $this->etablissement->read("*",array('id_etablissement' => $id)))) {
                  $hidden = array('id_etablissement' => $id);

                 $this->template->set_partial('container', 'add_etablissement_view', array('data' => $data,'etablissement' => (array) $etablissement[0],'hidden' => $hidden,'op_btn_value' => 'Modifier'));
                 }else{
                redirect(base_url('etablissement'));
                 }

                    //$this->template->set_partial('container', 'add_etablissement_view', array('data' => $data));
                    $this->template->title('dd','ee')
                    ->build('body');
                     break;

               default:
      $op_modal = $this->load->view('modals/admin/op_modall', '', true);

     $this->template->set_partial('container', 'list_etablissement_view', array('data' => $data,'op_modal' => $op_modal));
     $this->template->title('dd','ee')
                    ->build('body');
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
         $prefix = 'etablissement';
           $this->form_validation->set_rules('name', 'Nom de l\'etablissement', 'required|trim',array('required' => 'Champs Nom de l\'etablissement est obligatoire'));
           $this->form_validation->set_rules('designation', 'Designation de l\'etablissement', 'required|trim',array('required' => 'Champs Designation de l\'etablissement est obligatoire'));
           $this->form_validation->set_rules('ville', 'Ville de l\'etablissement', 'required|trim',array('required' => 'Champs Ville de l\'etablissement est obligatoire'));


        $errors = false;
      if ($this->form_validation->run()) {
      $name = $this->input->post('name');
      $designation = $this->input->post('designation');
       $ville = $this->input->post('ville');

      if(($id = $this->input->post('id')) ){
      $result=$this->etablissement->update(array(
      'libelle_etablissement' => $this->input->post('name'),
      'designation_etablissement' => $this->input->post('designation'),
      'ville_etablissement' => $this->input->post('ville'),
      ),$id);

     $message = "Vos informations ont été modifiées avec succès.";

      }else{

      $options=array(
      'libelle_etablissement' => $name,
      'designation_etablissement' => $designation,
      'ville_etablissement' => $ville,
      );

      $result = $this->etablissement->create($options);
       $message = "Vos informations ont été ajouté avec succès.";
}
      //$this->set_public_message($message, 'success');


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
   /**** Ajax ***/




   }  //CLASS
?>
