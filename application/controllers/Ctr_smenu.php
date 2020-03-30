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

  public function affect($data = '')
  {
      $this->display($data);
      $this->set_breadcrumb(array("Affectation droit d'accées" => ''));
      $this->template->set_partial('container', 'affectcationDroit_view', array('data' => $data));
      $this->template->title('dd','ee')->build('body');
  }

  public function updateaff($IdDepartement, $IdType, $IdPersonel, $IDAccess, $data = '')
  {
      $Affectation = array('IdDepartement' => $IdDepartement,
                           'IdType'        => $IdType,
                           'IdPersonel'    => $IdPersonel,
                           'IDAccess'      => $IDAccess);
      $this->display($data);
      $this->set_breadcrumb(array("Affectation droit d'accées" => ''));
      $this->template->set_partial('container', 'affectcationDroit_view', array('data' => $data,'Params' => $Affectation));
      //$this->template->set_partial('container', 'add_sousmenu_view', array('data' => $data,'smenu' => (array) $smenu[0],'hidden' => $hidden,'op_btn_value' => 'Modifier'));
      $this->template->title('dd','ee')->build('body');
  }

  public function updateaffTD($IdDepartement, $IdType,  $data = '')
  {
      $Affectation = array('IdDepartement' => $IdDepartement,
                           'IdType'        => $IdType);
      $this->display($data);
      $this->set_breadcrumb(array("Affectation droit d'accées" => ''));
      $this->template->set_partial('container', 'affectcationDroit_view', array('data' => $data,'Params' => $Affectation));
      //$this->template->set_partial('container', 'add_sousmenu_view', array('data' => $data,'smenu' => (array) $smenu[0],'hidden' => $hidden,'op_btn_value' => 'Modifier'));
      $this->template->title('dd','ee')->build('body');
  }

  public function list_affect($data = '')
  {
      $this->display($data);
      $this->set_breadcrumb(array("Liste des Affectation droit d'accées" => ''));
      $this->template->set_partial('container', 'list_affectcationDroit_view', array('data' => $data));
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

  public function list_aff_droit(){
     $IDEtablissement = $this->input->post('IDEtablissement');
     $IDtypePersonel  = $this->input->post('IDtypePersonel');
     $IDUtilisateur     = $this->input->post('IDUtilisateur');


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
        $NbrRow = $this->db->affected_rows();

        foreach($queryDetail->result() as $rowDetail ){
          $Html .= '<option value="'.$rowDetail->id_personel.'"';
          if($rowDetail->id_personel == $IDUtilisateur){
             $Html .= 'selected=selected';
          }
          $Html .= '>'.$rowDetail->nom_personel." ".$rowDetail->prenom_personel.'</option>';
        }

      }

      $TableHtml = "";

      if($IDtypePersonel != '' && $IDEtablissement != '' && $NbrRow > 0){
        $ConditionsTable     = "";
        $ConditionsTableHtml = "";

        if($IDUtilisateur != ""){
          $ConditionsTable     .= " AND iav_personel.id_personel = ".$IDUtilisateur;
        }

        if($IDtypePersonel != ""){
          $ConditionsTable .= " AND iav_typepersonel.id_typepersonel = ".$IDtypePersonel;
        }

        if($IDEtablissement != ""){
          $ConditionsTable .= " AND iav_departement.id_departement = ".$IDEtablissement;
        }

        $queryDetailTable = $this->db->query('SELECT iav_personel.id_personel,
                                                     iav_personel.nom_personel,
                                                     iav_personel.prenom_personel,
                                                     iav_typepersonel.libeller_typepersonel,
                                                     iav_departement.id_departement,
                                                     iav_typepersonel.id_typepersonel,
                                                     droits_acces.acces
                                              FROM iav_personel
                                              JOIN iav_personel_type_departement ON (iav_personel_type_departement.id_personel = iav_personel.id_personel)
                                              JOIN droits_acces ON (droits_acces.iav_personel_type_departement = iav_personel_type_departement.id_personel_type_departement AND
                                                droits_acces.deleted_droits_acces = "N")
                                              JOIN iav_departement ON (iav_departement.id_departement = iav_personel_type_departement.id_departement AND
                                                                iav_departement.deleted_departement = "N" AND
                                                                iav_departement.id_departement = '.$IDEtablissement.')
                                              JOIN etablissement ON (etablissement.id_etablissement = iav_departement.id_etablissement AND
                                                                etablissement.deleted_etablissement = "N")
                                              JOIN iav_typepersonel ON (iav_typepersonel.id_typepersonel = iav_personel_type_departement.id_typepersonel AND
                                                                   iav_typepersonel.deleted_typepersonel = "N")
                                              WHERE iav_personel.deleted_personel = "N"'.$ConditionsTable.'
                                              GROUP BY iav_personel.id_personel');

        $TableHtml = '<table id="TableApp" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable_info"><thead><tr role="row"><th class="sorting_asc" style="text-align: center;" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 5%;"></th><th class="sorting_asc" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 30%;">Nom</th><th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 30%;">Prénom</th><th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 25%;">Type</th><th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label=Option: activate to sort column ascending" style="width: 10%;">Option</th></tr></thead><tbody>';

        foreach($queryDetailTable->result() as $rowDetailTable ){
          if($IDUtilisateur != ""){
            $ConditionsTableHtml = " AND iav_personel_type_departement.id_personel = ".$IDUtilisateur;
          }else if($IDUtilisateur == "" && $rowDetailTable->id_personel != ""){
            $ConditionsTableHtml = " AND iav_personel_type_departement.id_personel = ".$rowDetailTable->id_personel;
          }

          $TableHtml .= '<tr role="row" class="odd"> <td class="sorting_1 center-element vertical-center-element"></td><td class="center-element vertical-center-element">'.$rowDetailTable->nom_personel.'</td><td class="center-element vertical-center-element">'.$rowDetailTable->prenom_personel.'</td><td class="center-element vertical-center-element">'.$rowDetailTable->libeller_typepersonel.'</td><td class="center-element vertical-center-element"><a class="item-del red UP" id="'.$rowDetailTable->id_personel.'"  name="'.$rowDetailTable->id_personel.'"><i class="ace-icon fa fa-angle-double-down bigger-130"></i></a>&nbsp;<a class="item-edit green" href="'.base_url('affecter/updaffect/upd/'.$rowDetailTable->id_departement."/".$rowDetailTable->id_typepersonel."/".$rowDetailTable->id_personel."/".$rowDetailTable->acces).'"><i class="ace-icon fa fa-edit bigger-130"></i></a></td></tr>';

           $QueryPersonelMenu = $this->db->query('SELECT iav_application.id_application,
                                                        iav_application.nom_application,
                                                        iav_application.url_application,
                                                        iav_personel_type_departement.id_personel,
                                                        CASE
                                                            WHEN droits_acces.acces = 1 THEN "Administrateur"
                                                            WHEN droits_acces.acces = 2 THEN "Consultation et Insertion"
                                                            WHEN droits_acces.acces = 3 THEN "Lancer la Demande et Impression"
                                                            WHEN droits_acces.acces = 4 THEN "Aucune Droit"
                                                            ELSE "Aucune Droit"
                                                        END AS DroitAccess
                                                 FROM iav_application
                                                 JOIN droits_acces ON (droits_acces.iav_application_id_application = iav_application.id_application)
                                                 JOIN iav_personel_type_departement ON (iav_personel_type_departement.id_personel_type_departement = droits_acces.iav_personel_type_departement AND droits_acces.deleted_droits_acces = "N")
                                                 WHERE droits_acces.deleted_droits_acces = "N" '.$ConditionsTableHtml.'
                                                 GROUP BY iav_application.id_application');

          $NbrRowTR = $this->db->affected_rows();
          $TableHtml .= '<tr role="row" class="odd" id="TR_'.$rowDetailTable->id_personel.'" style="display:none;"><td class="sorting_1 center-element vertical-center-element" colspan="5"><div>';

          if($NbrRowTR > 0){
            $TableHtml .= '<table id="TableAppRow" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable_info"><thead><tr role="row"><th class="sorting_asc" style="text-align: center;" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-sort="ascending"  style="width: 10%;"></th><th class="sorting_asc" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-sort="ascending" style="width: 30%;">Application</th><th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 30%;">Url</th><th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 30%;">Droit</th><th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label=Option: activate to sort column ascending" style="width: 10%;">Option</th></tr></thead><tbody>';
            foreach ($QueryPersonelMenu->result()  as $RowQueryPersonelMenu ) {
              $TableHtml .= '<tr role="row" class="odd"> <td class="sorting_1 center-element vertical-center-element"></td><td class="center-element vertical-center-element">'.$RowQueryPersonelMenu->nom_application.'</td><td class="center-element vertical-center-element">'.$RowQueryPersonelMenu->url_application.'</td><td class="center-element vertical-center-element">'.$RowQueryPersonelMenu->DroitAccess.'</td><td class="center-element vertical-center-element"><a class="item-del red" data="'.$RowQueryPersonelMenu->id_application.'" id="'.$RowQueryPersonelMenu->id_personel.'"  name="'.$RowQueryPersonelMenu->id_application.'"><i class="ace-icon fa fa-search bigger-130"></i></a></td></tr>';
            }

            $TableHtml .= '</tbody></table>';
          }

          $TableHtml .= '</div></td></tr>';
        }

        $TableHtml .= "</tbody></table>";
      }

       echo json_encode(array('status' => '1',
                              'location' => 'url',
                              'message' => 'test',
                              'Contenu' => $Html,
                              'TableContenu' => $TableHtml));
  }


  public function createMenu(){
      /*ApplicationID   = $this->input->post('ApplicationID');
      $PersonalID      = $this->input->post('PersonalID');

      $QueryPersonelMenu = $this->db->query('SELECT iav_menu.id_menu,
                                                    iav_menu.libeller_menu,
                                                    iav_menu.icon_menu,
                                                    iav_menu.url_menu,
                                                    iav_sousmenu.id_sousmenu,
                                                    iav_sousmenu.libeller_sousmenu,
                                                    iav_sousmenu.url_sousmenu
                                            FROM iav_application
                                            JOIN iav_menu ON (iav_menu.id_application = iav_application.id_application AND
                                                                   iav_menu.deleted_menu = "N")
                                            JOIN iav_sousmenu ON (iav_sousmenu.id_menu = iav_menu.id_menu)
                                            JOIN iav_sousmenu_personel ON (iav_sousmenu_personel.iav_sousmenu_id_sousmenu = iav_sousmenu.id_sousmenu
                                                                                AND iav_sousmenu_personel.deleted_sousmenu_personel = "N")
                                            WHERE iav_sousmenu.deleted_sousmenu = "N" AND
                                                       iav_sousmenu_personel.iav_personel_id_personel = '.$PersonalID.' AND
                                                       iav_application.id_application = '.$ApplicationID.'
                                            GROUP BY iav_menu.id_menu');
      $IDMenu = "";
      $CountQueryPersonelMenu = $this->db->affected_rows();
      $TabHtml = "";
      if($CountQueryPersonelMenu > 0){
        $TabHtml .= '<div class="left_col scroll-view"><div class="main_menu_side hidden-print main_menu"><div id="sidebar-menu" class="main_menu_side hidden-print main_menu"><div class="menu_section"><ul class="nav side-menu">';
        foreach($QueryPersonelMenu->result() as $rowQueryPersonelMenu ){

          $TabHtml .= '<li><a href="'.base_url($rowQueryPersonelMenu->url_menu).'"><i class="fa '.$rowQueryPersonelMenu->icon_menu.'"></i>'.$rowQueryPersonelMenu->libeller_menu.'  <span class="fa fa-chevron-down"></span></a><ul class="nav child_menu" style="display: block;">';

          $QueryPersonelSousMenu = $this->db->query('SELECT iav_menu.id_menu,
                                                            iav_menu.libeller_menu,
                                                            iav_menu.icon_menu,
                                                            iav_menu.url_menu,
                                                            iav_sousmenu.id_sousmenu,
                                                            iav_sousmenu.libeller_sousmenu,
                                                            iav_sousmenu.url_sousmenu
                                                     FROM iav_application
                                                     JOIN iav_menu ON (iav_menu.id_application = iav_application.id_application AND
                                                                   iav_menu.deleted_menu = "N")
                                                     JOIN iav_sousmenu ON (iav_sousmenu.id_menu = iav_menu.id_menu)
                                                     JOIN iav_sousmenu_personel ON (iav_sousmenu_personel.iav_sousmenu_id_sousmenu = iav_sousmenu.id_sousmenu
                                                                                AND iav_sousmenu_personel.deleted_sousmenu_personel = "N")
                                                     WHERE iav_sousmenu.deleted_sousmenu = "N" AND
                                                       iav_sousmenu_personel.iav_personel_id_personel = '.$PersonalID.' AND
                                                       iav_application.id_application = '.$ApplicationID.' AND
                                                       iav_menu.id_menu = '.$rowQueryPersonelMenu->id_menu);


          foreach($QueryPersonelSousMenu->result() as $rowQueryPersonelSousMenu ){

            $TabHtml .= '<li><a href="'.base_url($rowQueryPersonelSousMenu->url_sousmenu).'">'.$rowQueryPersonelSousMenu->libeller_sousmenu.'</a></li>';

          }
            $TabHtml .= '</ul></li>';
        }
        $TabHtml .= '</ul></div></div></div></div>';
      }

      echo json_encode(array('status' => '1',
                           'url' => 'smenu',
                           'message' => "ok",
                           'Table' => $TabHtml));  */

  }

  public function insert_affectation(){
    $IDDepartement   = $this->input->post('IDDepartement');
    $IDTypePersonel  = $this->input->post('IDTypePersonel');
    $IDUtilisateur   = $this->input->post('IDUtilisateur');
    $IDApplication   = $this->input->post('IDApplication');
    $Updated         = $this->input->post('Updated');
    $IdDroit         = $this->input->post('IdDroit');
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
    $queryDetail = $this->db->query('SELECT iav_personel.id_personel, iav_personel_type_departement.id_personel_type_departement
                                      FROM iav_personel
                                      JOIN iav_personel_type_departement ON (iav_personel_type_departement.id_personel = iav_personel.id_personel)
                                      JOIN iav_typepersonel ON (iav_typepersonel.id_typepersonel = iav_personel_type_departement.id_typepersonel AND
                                                                iav_typepersonel.deleted_typepersonel = "N")
                                      JOIN iav_departement ON (iav_departement.id_departement = iav_personel_type_departement.id_departement AND
                                                                iav_departement.deleted_departement = "N")
                                      JOIN etablissement ON (etablissement.id_etablissement = iav_departement.id_etablissement AND
                                                                   etablissement.deleted_etablissement = "N")
                                      WHERE iav_personel.deleted_personel = "N" '.$ConditionsDb);
    $NbrRowAffeced = $this->db->affected_rows();
    $CountRow = 0;
    $Etat = 'O';
    foreach($queryDetail->result() as $rowDetail ){
      $IDUtilisateur = $rowDetail->id_personel;
      $IDPersonelTypeDepartement = $rowDetail->id_personel_type_departement;
      $CountRow++;
      if($Updated == 'Non'){
        if($CountRow == $NbrRowAffeced){
          $Updated = 'Oui';
        }
        $etat_delete = $this->db->set('deleted_droits_acces', $Etat);
        $etat_delete = $this->db->where('iav_personel_type_departement', $IDPersonelTypeDepartement);
        $etat_delete = $this->db->update('droits_acces');
      }
      $data = array(
          'iav_application_id_application' => $IDApplication,
          'iav_personel_type_departement' => $IDPersonelTypeDepartement,
          'acces' => $IdDroit,
          'cby_droits_acces'    => $by,
          'cdate_droits_acces'  => $date
      );
      $this->db->insert('droits_acces', $data);  
    }

    echo json_encode(array('status' => '1',
                           'url' => 'smenu',
                           'message' => "ok",
                           'Updated' => $Updated));
    $UserChanged = $IDUtilisateur;
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
              $this->template->set_partial('container', 'add_sousmenu_view', array('data' => $data,'affectsousmenu' => (array) $smenu[0],'hidden' => $hidden,'op_btn_value' => 'Modifier'));
            }else{
              redirect(base_url('smenu'));
            }

           //$this->template->set_partial('container', 'add_etablissement_view', array('data' => $data));
           $this->template->title('dd','ee')->build('body');
          break;

          case 'upd':
            if (($id = intval($id)) && !empty($id) && ($smenu = $this->smenu->read("*",array('id_sousmenu' => $id)))) {
              $hidden = array('id_sousmenu' => $id);
              $this->template->set_partial('container', 'affectcationDroit_view', array('data' => $data,'smenu' => (array) $smenu[0],'hidden' => $hidden,'op_btn_value' => 'Modifier'));
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
