<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/Master_user.php';

class Ctr_smenu extends Master_user
{

 function __construct() {
      parent::__construct();
/*        if (!$this->user_is_connected(USER_TYPE_STUDENT))*/
            /*$this->set_public_message("Vous n'êtes pas connecté, merci de se connecter.", 'info', 'connexion/etudiants');*/

      $this->load->model('Iav_sousmenu_model', 'smenu');

    }

  public function index($data = '')
  {

      $this->display($data);
      $this->set_breadcrumb(array("List des menu" => ''));
      $this->template->set_partial('container', 'list_smenu_view', array('data' => $data));
      $this->template->title('dd','ee')->build('body');
  }

  public function affect($data='')
  {
      $this->display($data);
      $this->set_breadcrumb(array("Affectation droit d'accées" => ''));
      $this->template->set_partial('container', 'affectcationDroit_view', array('data' => $data));
      $this->template->title('dd','ee')->build('body');
  }

  public function ajax_select_etab_typep(){
     $IDEtablissement = $this->input->post('IDEtablissement');
     $IDtypePersonel  = $this->input->post('IDtypePersonel');


      $Html = '<option value="" >Selectionnez</option>';

      if($IDtypePersonel != '' && $IDEtablissement != ''){

        $queryDetail = $this->db->query('SELECT iav_personel.*
                                         FROM iav_personel
                                         JOIN iav_personel_type_departement ON (iav_personel_type_departement.id_personel = iav_personel.id_personel)
                                         JOIN iav_departement ON (iav_departement.id_departement = iav_personel_type_departement.id_departement AND
                                                                iav_departement.deleted_departement = "N" AND
                                                                iav_departement.id_departement = '.$IDEtablissement.')
                                         JOIN etablissement ON (etablissement.id_etablissement = iav_departement.id_etablissement AND
                                                                etablissement.deleted_etablissement = "N")
                                         JOIN iav_typepersonel ON (iav_typepersonel.id_typepersonel = iav_personel_type_departement.id_typepersonel AND
                                                                   iav_typepersonel.deleted_typepersonel = "N" AND
                                                                   iav_typepersonel.id_typepersonel = '.$IDtypePersonel.')
                                         WHERE iav_personel.deleted_personel = "N"');

        foreach($queryDetail->result() as $rowDetail ){
          $Html .= '<option value="'.$rowDetail->id_personel.'">'.$rowDetail->nom_personel." ".$rowDetail->prenom_personel.'</option>';
        }

      }

       echo json_encode(array('status' => '1',
                              'location' => 'url',
                              'message' => 'test',
                              'Contenu' => $Html      ));
  }

  public function insert_affectation(){
    $IDDepartement   = $this->input->post('IDDepartement');
    $IDTypePersonel  = $this->input->post('IDTypePersonel');
    $IDUtilisateur   = $this->input->post('IDUtilisateur');
    $IDApplication   = $this->input->post('IDApplication');

    $by = 1;
    $date = date('Y-m-d H:i:s');

    $ConditionsDb = "";

    if($IDDepartement != ""){
      $ConditionsDb .= " AND iav_departement.id_departement = ".$IDDepartement." ";
    }

    if($IDTypePersonel != ""){
      $ConditionsDb .= " AND iav_typepersonel.id_typepersonel = ".$IDTypePersonel." ";
    }

    if($IDUtilisateur != ""){
      $ConditionsDb .= " AND iav_personel.id_personel = ".$IDUtilisateur." ";
    }

    $queryDetail = $this->db->query('SELECT iav_personel.id_personel
                                      FROM iav_personel
                                      JOIN iav_personel_type_departement ON (iav_personel_type_departement.id_personel = iav_personel.id_personel)
                                      JOIN iav_typepersonel ON (iav_typepersonel.id_typepersonel = iav_personel_type_departement.id_typepersonel AND
                                                                iav_typepersonel.deleted_typepersonel = "N")
                                      JOIN iav_departement ON (iav_departement.id_departement = iav_personel_type_departement.id_departement AND
                                                                iav_departement.deleted_departement = "N")
                                      JOIN etablissement ON (etablissement.id_etablissement = iav_departement.id_etablissement AND
                                                                   etablissement.deleted_etablissement = "N")
                                      WHERE iav_personel.deleted_personel = "N" '.$ConditionsDb);

    foreach($queryDetail->result() as $rowDetail ){
      $IDUtilisateur = $rowDetail->id_personel;

      $Etat = "O";
      $etat_delete = $this->db->set('deleted_sousmenu_personel', $Etat);
      $etat_delete = $this->db->set('dby_sousmenu_personel', $by);
      $etat_delete = $this->db->set('ddate_sousmenu_personel', $date);
      $etat_delete = $this->db->where('iav_personel_id_personel', $IDUtilisateur);
      $etat_delete = $this->db->update('iav_sousmenu_personel');

      $data = array(
          'iav_sousmenu_id_sousmenu' => $IDApplication,
          'iav_personel_id_personel' => $IDUtilisateur,
          'cby_sousmenu_personel'    => $by,
          'cdate_sousmenu_personel'  => $date
      );

      $this->db->insert('iav_sousmenu_personel', $data);

    }

    echo json_encode(array('status' => '1',
                           'url' => 'smenu',
                           'message' => "ok"));
  }

  public function smenu($data = '',$id = NULL){

        $this->display($data);
        $by = 1;
        $date = date('Y-m-d H:i:s');

        switch($data){
          case 'add':
            $this->template->set_partial('container', 'add_sousmenu_view', array('data' => $data));
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
            $etat_delete = $this->db->set('deleted_sousmenu', $Etat);
            $etat_delete = $this->db->set('dby_sousmenu', $by);
            $etat_delete = $this->db->set('ddate_sousmenu', $date);
            $etat_delete = $this->db->where('id_sousmenu', $conditions);
            $etat_delete = $this->db->update('iav_sousmenu');

            if($etat_delete){
              echo json_encode(array('status' => '1',
                                  'url' => 'smenu',
                                  'message' => "l'enregistrement a été supprimé avec succees"));
            }else{
              echo json_encode(array('status' => '0',
                                  'url' => 'smenu',
                                  'message' => 'Erreur de traitement' ));
            }
            break;

          case 'edit':
            if (($id = intval($id)) && !empty($id) && ($smenu = $this->smenu->read("*",array('id_sousmenu' => $id)))) {
              $hidden = array('id_sousmenu' => $id);
              $this->template->set_partial('container', 'add_sousmenu_view', array('data' => $data,'smenu' => (array) $smenu[0],'hidden' => $hidden,'op_btn_value' => 'Modifier'));
            }else{
              redirect(base_url('smenu'));
            }

           //$this->template->set_partial('container', 'add_etablissement_view', array('data' => $data));
           $this->template->title('dd','ee')->build('body');
          break;
          default:
            $op_modal = $this->load->view('modals/admin/op_modall', '', true);

            $this->template->set_partial('container', 'list_smenu_view', array('data' => $data,'op_modal' => $op_modal));
            $this->template->title('dd','ee')->build('body');
          break;
        }




   }

    public function ajax_select(){
      $Id_App = $this->input->post('Application');

      $queryDetail = $this->db->query('SELECT *
                                         FROM iav_menu
                                         WHERE iav_menu.deleted_menu = "N" AND
                                               iav_menu.id_application = "'.$Id_App.'"');
      $Html = '<option value="" >Selectionnez</option>';

      foreach($queryDetail->result() as $rowDetail ){
        $Html .= '<option value="'.$rowDetail->id_menu.'">'.$rowDetail->libeller_menu.'</option>';
      }

       echo json_encode(array('status' => '1',
                              'location' => 'url',
                              'message' => 'test',
                              'Contenu' => $Html      ));
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
        $prefix = 'smenu';
        $this->form_validation->set_rules('Application', 'Application', 'required|trim',array('required' => 'Veuillez Selectionnez le champ Application Menu'));
        $this->form_validation->set_rules('Menu', 'Menu', 'required|trim',array('required' => 'Veuillez Selectionnez le champ Menu'));
        $this->form_validation->set_rules('Libeller', 'Libeller Menu', 'required|trim',array('required' => 'Champs Libeller Menu est obligatoire'));
        $this->form_validation->set_rules('Url', 'Url Menu', 'required|trim',array('required' => 'Champs Url Menu est obligatoire'));


        $errors = false;
        if ($this->form_validation->run()) {
          $Application = $this->input->post('Application');
          $Libeller = $this->input->post('Libeller');
          $Url = $this->input->post('Url');
          $Menu = $this->input->post('Menu');


          if(($id = $this->input->post('id')) ){
            $this->db->set('libeller_sousmenu', $Libeller);
            $this->db->set('url_sousmenu', $Url);
            $this->db->set('id_menu', $Menu);
            $this->db->set('uby_sousmenu', $by);
            $this->db->set('udate_sousmenu', $date);
            $this->db->where('id_sousmenu', $id);
            $this->db->update('iav_sousmenu');
           // $result=$this->menu->update(array('libeller_menu' => $Libeller,'url_menu' => $Url,'icon_menu' => $Icone),$id);

            $message = "Vos informations ont été modifiées avec succès.";

          }else{

            $options=array('id_menu' => $Menu,
                           'libeller_sousmenu' => $Libeller,
                           'url_sousmenu' => $Url,
                           'cby_sousmenu' => $by,
                           'cdate_sousmenu' => $date);

            $result = $this->smenu->create($options);
            $message = "Vos informations ont été ajouté avec succès.";
          }
          //$this->set_public_message($message, 'success');


          echo json_encode(array('status' => '1',
                                  'location' => 'smenu',
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
