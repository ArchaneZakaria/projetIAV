<?php defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/Master.php';

class Ctr_entite extends Master
{


  /**
   * Index Page for this controller.
   *
   * Maps to the following URL
   *    http://example.com/index.php/welcome
   *  - or -
   *    http://example.com/index.php/welcome/index
   *  - or -
   * Since this controller is set as the default controller in
   * config/routes.php, it's displayed at http://example.com/
   *
   * So any other public methods not prefixed with an underscore will
   * map to /index.php/welcome/<method_name>
   * @see https://codeigniter.com/user_guide/general/urls.html
   */
  public function index($data = '')
  {

     $this->display($data);
    $this->set_breadcrumb(array('Liste des entitées' =>''));
    $this->template->set_partial('container', 'entite', array('data' => $data));
     $this->template->title('dd','ee')
                    ->build('body');
  }

/*  public function addEntite($data = '')
  {

      $this->display($data);
      $this->set_breadcrumb(array('Ajouter Entitées' =>''));
      $this->template->set_partial('container', 'add_entite', array('data' => $data));
      $this->template->title('dd','ee')
                    ->build('body');
  }
*/

   public function entite($data = ''){


              $this->display($data);

              switch($data){

               case 'add':
  $this->set_breadcrumb(array('Ajouter Entitées' =>''));
 $this->template->set_partial('container', 'add_entite_view', array('data' => $data));

               break;

              case 'del':
 $this->template->set_partial('container', 'gerer_dotation_reaparation_view', array('data' => $data));

               break;

                 case 'edit':
 $this->template->set_partial('container', 'utilisateur_view', array('data' => $data));



              }

 $this->template->title('dd','ee')
                    ->build('body');


   }

  public function listeDSD(){
    $IdDepartement = $this->input->post('IdDepartement');
    $IDService     = $this->input->post('IDService');


      $ConditionsTableHtml = "";
      $ConditionsTable     = "";
      $AndCondition        = "";

      if($IdDepartement != ""){
        $ConditionsTableHtml = "iav_departement.id_departement IN (";
      }else if($IDService != ""){
        $ConditionsTableHtml = "iav_departement.id_departement IN (";
      }

      if($IdDepartement != ""){
        $ConditionsTable     .= $IdDepartement.",";
      }

      if($IDService != ""){
        $ConditionsTable     .= $IDService.",";
      }


      $Lenght = strlen($ConditionsTable);
      $ConditionsTable = substr($ConditionsTable, 0, ($Lenght - 1));

      if($IdDepartement != ""){
        $AndCondition = " AND ";
        $ConditionsTableHtml .= $ConditionsTable.")";
      }else if($IDService != ""){
        $AndCondition = " AND ";
        $ConditionsTableHtml .= $ConditionsTable.")";
      }


      $queryDetail = $this->db->query('SELECT iav_departement.id_departement,
                                              iav_departement.libeller_departement,
                                              iav_departement.code_departement,
                                              iav_typedepart.libeller_typedepart,
                                              iav_typedepart.id_typedepart
                                         FROM iav_departement
                                         JOIN iav_typedepart ON (iav_typedepart.id_typedepart = iav_departement.id_typedepart AND
                                                                 iav_typedepart.deleted_typedepart = "N")
                                         WHERE iav_departement.deleted_departement = "N" AND (iav_departement.id_parent IS NULL OR iav_departement.id_parent = 0) '.$AndCondition.$ConditionsTableHtml);
      $NbrRow = $this->db->affected_rows();

      if($NbrRow){
        $TableHtml = '<table id="TableApp" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable_info"><thead><tr role="row"><th></th><th style="width: 30%;">Libeller</th><th style="width: 30%;">Code</th><th style="width: 25%;">Type</th><th style="width: 10%;">Option</th></tr></thead><tbody>';
        foreach($queryDetail->result() as $rowDetail ){
          $TableHtml .= '<tr><td></td><td>'.$rowDetail->libeller_departement.'</td><td>'.$rowDetail->code_departement.'</td><td>'.$rowDetail->libeller_typedepart.'</td><td><a class="show-detail red UP" id="'.$rowDetail->id_departement.'"  name="'.$rowDetail->id_departement.'"><i class="ace-icon fa fa-angle-double-down bigger-130"></i></a>&nbsp;<a class="show-detail green" href="'.base_url('ajaxInsert/UpdateD/upd/'.$rowDetail->id_departement."/".$rowDetail->id_typedepart).'"><i class="ace-icon fa fa-edit bigger-130"></i></a>&nbsp;<a class="item-del red" href="#" id="'.$rowDetail->id_departement.'" name="'.$rowDetail->id_typedepart.'"><i class="ace-icon fa fa-trash-o bigger-130"></i></a></td></tr>';

          $ConditionParent        = "";

          $ConditionParent = " AND iav_departement.id_parent = ".$rowDetail->id_departement;

          $QueryPersonelMenu = $this->db->query('SELECT iav_departement.id_departement,
                                                      iav_departement.libeller_departement,
                                                      iav_departement.code_departement,
                                                      iav_typedepart.libeller_typedepart,
                                                      iav_typedepart.id_typedepart
                                                 FROM iav_departement
                                                 JOIN iav_typedepart ON (iav_typedepart.id_typedepart = iav_departement.id_typedepart AND
                                                                         iav_typedepart.deleted_typedepart = "N")
                                                 WHERE iav_departement.deleted_departement = "N" '.$ConditionParent);

          $NbrRowTR = $this->db->affected_rows();

          $TableHtml .= '<tr role="row" class="odd" id="TR_'.$rowDetail->id_departement.'" style="display:none;"><td class="sorting_1 center-element vertical-center-element" colspan="5"><div>';

          if($NbrRowTR > 0){
            $TableHtml .= '<table id="TableAppRow" class="table table-striped table-bordered dataTable no-footer"><thead><tr><th style="width: 40%;">Libeller</th><th style="width: 40%;">Code</th><th style="width: 40%;">Type</th><th style="width: 10%;">Option</th></tr></thead><tbody>';
            foreach ($QueryPersonelMenu->result()  as $RowQueryPersonelMenu ) {
              $TableHtml .= '<tr><td>'.$RowQueryPersonelMenu->libeller_departement.'</td><td>'.$RowQueryPersonelMenu->code_departement.'</td><td>'.$RowQueryPersonelMenu->libeller_typedepart.'</td><td><a class="show-detail red UPS" id="'.$RowQueryPersonelMenu->id_departement.'"  name="'.$RowQueryPersonelMenu->id_departement.'"><i class="ace-icon fa fa-angle-double-down bigger-130"></i></a>&nbsp;<a class="item-edit green" href="'.base_url('ajaxInsert/UpdateD/upd/'.$RowQueryPersonelMenu->id_departement."/".$RowQueryPersonelMenu->id_typedepart).'"><i class="ace-icon fa fa-edit bigger-130"></i></a>&nbsp;<a class="item-del red" href="#" id="'.$RowQueryPersonelMenu->id_departement.'" name="'.$RowQueryPersonelMenu->id_typedepart.'"><i class="ace-icon fa fa-trash-o bigger-130"></i></a></td></tr>';

              $ConditionParentParent        = "";

              $ConditionParentParent = " AND iav_departement.id_parent = ".$RowQueryPersonelMenu->id_departement;

              $QueryParentDep = $this->db->query('SELECT iav_departement.id_departement,
                                                          iav_departement.libeller_departement,
                                                          iav_departement.code_departement,
                                                          iav_typedepart.libeller_typedepart,
                                                          iav_typedepart.id_typedepart
                                                     FROM iav_departement
                                                     JOIN iav_typedepart ON (iav_typedepart.id_typedepart = iav_departement.id_typedepart AND
                                                                             iav_typedepart.deleted_typedepart = "N")
                                                     WHERE iav_departement.deleted_departement = "N" '.$ConditionParentParent);

              $NbrRowTRParent = $this->db->affected_rows();

               $TableHtml .= '<tr role="row" class="odd" id="STR_'.$RowQueryPersonelMenu->id_departement.'" style="display:none;"><td class="sorting_1 center-element vertical-center-element" colspan="4"><div>';
               if($NbrRowTRParent > 0){
                $TableHtml .= '<table id="TableAppRowParent" class="table table-striped table-bordered dataTable no-footer"><thead><tr><th style="width: 40%;">Libeller</th><th style="width: 40%;">Code</th><th style="width: 40%;">Type</th><th style="width: 10%;">Option</th></tr></thead><tbody>';

                foreach ($QueryParentDep->result()  as $RowQueryParentDep ) {
                   $TableHtml .= '<tr><td>'.$RowQueryParentDep->libeller_departement.'</td><td>'.$RowQueryParentDep->code_departement.'</td><td>'.$RowQueryParentDep->libeller_typedepart.'</td><td>&nbsp;<a class="item-edit green" href="'.base_url('ajaxInsert/UpdateD/upd/'.$RowQueryParentDep->id_departement."/".$RowQueryParentDep->id_typedepart).'"><i class="ace-icon fa fa-edit bigger-130"></i></a>&nbsp;<a class="item-del red" href="#" id="'.$RowQueryParentDep->id_departement.'" name="'.$RowQueryParentDep->id_typedepart.'"><i class="ace-icon fa fa-trash-o bigger-130"></i></a></td></tr>';
                }
                $TableHtml .= '</tbody></table>';
              }

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
                              'TableContenu' => $TableHtml));


  }


  public function listeTypeD(){
    $IDTypePersonel = $this->input->post('IDTypePersonel');

    $HTMLRsponsable       = "";
    $HTMLParentDep        = "";
    $ShowParent           = false;
    $ConditionParent      = "";
    $ConditionResponsable = "";
    $ShowResponsable      = false;
    $CodeTypeDepart       = "";

    if($IDTypePersonel != ""){
      switch($IDTypePersonel){
        case 1 : $CodeTypeDepart = "S";
        break;
        case 2 : $CodeTypeDepart = "D";
        break;
        case 3 : $CodeTypeDepart = "F";
        break;
        case 4 : $CodeTypeDepart = "U";
        break;

      }
      if($CodeTypeDepart == "F"){
        $ConditionParent      = " AND (iav_departement.id_parent IS NULL OR iav_departement.id_parent = 0) AND iav_typedepart.code_typedepart = 'T'";
        $ConditionResponsable = "AND iav_typedepart.code_typedepart = 'F'";
      }else if($CodeTypeDepart == "D"){
        $ConditionParent = " AND (iav_departement.id_parent IS NULL OR iav_departement.id_parent = 0) AND iav_typedepart.code_typedepart = 'F'";
        $ConditionResponsable = "AND iav_typedepart.code_typedepart = 'D'";
      }else if($CodeTypeDepart == "U"){
        $ConditionParent = " AND iav_typedepart.code_typedepart = 'D'";
        $ConditionResponsable = "AND iav_typedepart.code_typedepart = 'U'";
      }else if($CodeTypeDepart == "S"){
        $ConditionParent = " AND (iav_departement.id_parent IS NULL OR iav_departement.id_parent = 0) AND iav_typedepart.code_typedepart = 'S'";
        $ConditionResponsable = "AND iav_typedepart.code_typedepart = 'S'";
      }

      $QueryParentDep = $this->db->query('SELECT iav_departement.id_departement,
                                                 iav_departement.libeller_departement
                                          FROM iav_departement
                                          JOIN iav_typedepart ON (iav_typedepart.id_typedepart = iav_departement.id_typedepart AND
                                                                  iav_typedepart.deleted_typedepart = "N")
                                          WHERE iav_departement.deleted_departement = "N" '.$ConditionParent);

      $HTMLParentDep    = '<option value="" >Selectionnez</option>';
      $NbrRowParentDep  = $this->db->affected_rows();
      if($NbrRowParentDep > 0){
        $ShowParent = true;
        foreach($QueryParentDep->result() as $rowParentDep ){
          $HTMLParentDep .= '<option value="'.$rowParentDep->id_departement.'">'.$rowParentDep->libeller_departement.'</option>';
        }
      }

      $QueryResponsableDep = $this->db->query('SELECT iav_personel.id_personel,
                                                      CONCAT_WS(" ",iav_personel.nom_personel, iav_personel.prenom_personel) AS NOMPERSONEL
                                               FROM iav_personel
                                               JOIN iav_personel_type_departement ON (iav_personel_type_departement.id_personel = iav_personel.id_personel)
                                               JOIN iav_typepersonel ON (iav_typepersonel.id_typepersonel = iav_personel_type_departement.id_typepersonel AND iav_typepersonel.deleted_typepersonel = "N" AND iav_typepersonel.id_typepersonel = 2)
                                               JOIN iav_departement ON (iav_personel_type_departement.id_departement = iav_departement.id_departement AND
                                                                        iav_departement.deleted_departement = "N")
                                               JOIN iav_typedepart ON (iav_typedepart.id_typedepart = iav_departement.id_typedepart AND
                                                                  iav_typedepart.deleted_typedepart = "N")
                                               WHERE iav_personel.deleted_personel = "N" ');


      $HTMLRsponsable    = '<option value="" >Selectionnez</option>';
      $NbrRowResponsableDep  = $this->db->affected_rows();
      if($NbrRowResponsableDep > 0){
        $ShowResponsable = true;
        foreach($QueryResponsableDep->result() as $rowResponsableDep ){
          $HTMLRsponsable .= '<option value="'.$rowResponsableDep->id_personel.'">'.$rowResponsableDep->NOMPERSONEL.'</option>';
        }
      }
    }

    echo json_encode(array('status' => '1',
                           'location' => 'url',
                           'message' => 'test',
                           'ShowParent' => $ShowParent,
                           'ContenuParent' => $HTMLParentDep  ,
                           'ShowResponsable' => $ShowResponsable,
                           'ContenuResponsable' => $HTMLRsponsable    ));
  }

  public function insertD(){
    $IDDepartemnt          = $this->input->post('IDDepartemnt');
    $EtatDepartement       = $this->input->post('EtatDepartement');
    date_default_timezone_set('Africa/Casablanca');
    $by      = 1;
    $date    = date('Y-m-d H:i:s');
    $Message = "";
    $Url     = "url";
    $Etat    = "O";

    if($EtatDepartement == "ADD"){
      $CodeDepartement       = $this->input->post('CodeDepartement');
      $IDTypePersonel        = $this->input->post('IDTypePersonel');
      $IDParentDepartement   = $this->input->post('IDParentDepartement');
      $IDResponsable         = $this->input->post('IDResponsable');
      $IDEtablissement       = 1;
      $IDDepart              = $this->input->post('IDDepart');

      $data = array(
          'libeller_departement'        => $IDDepartemnt,
          'code_departement'            => $CodeDepartement,
          'id_parent'                   => $IDParentDepartement,
          'id_typedepart'               => $IDTypePersonel,
          'id_responsable_departement'  => $IDResponsable,
          'cby_departement'             => $by,
          'cdate_departement'           => $date,
          'id_etablissement'           => $IDEtablissement
      );

      $this->db->insert('iav_departement', $data);

      $Message = "Ajout effectué avec succes!!";
    }else if($EtatDepartement == "UPD"){
      $CodeDepartement       = $this->input->post('CodeDepartement');
      $IDTypePersonel        = $this->input->post('IDTypePersonel');
      $IDParentDepartement   = $this->input->post('IDParentDepartement');
      $IDResponsable         = $this->input->post('IDResponsable');
      $IDEtablissement       = 1;
      $IDDepart              = $this->input->post('IDDepart');

      $etat_delete = $this->db->set('udate_departement', $date);
      $etat_delete = $this->db->set('uby_departement', $by);
      $etat_delete = $this->db->set('id_responsable_departement', $IDResponsable);
      $etat_delete = $this->db->set('id_typedepart', $IDTypePersonel);
      $etat_delete = $this->db->set('id_parent', $IDParentDepartement);
      $etat_delete = $this->db->set('code_departement', $CodeDepartement);
      $etat_delete = $this->db->set('libeller_departement', $IDDepartemnt);
      $etat_delete = $this->db->where('id_departement', $IDDepart);
      $etat_delete = $this->db->update('iav_departement');

      $Message = "Modification effectué avec succes!!";
      $Url     = "entite";
    }else if($EtatDepartement == "DEL"){
      $etat_delete = $this->db->set('ddate_departement', $date);
      $etat_delete = $this->db->set('dby_departement', $by);
      $etat_delete = $this->db->set('deleted_departement', $Etat);
      $etat_delete = $this->db->where('id_departement', $IDDepartemnt);
      $etat_delete = $this->db->update('iav_departement');

      $Message = "Suppression effectué avec succes!!";
      $Url     = "entite";
    }



      echo json_encode(array('status' => '1',
                             'location' => $Url,
                             'etat' => $EtatDepartement,
                             'message' => $Message ));
  }

  public function updateD($IdDepartement, $IdType, $data = '')
  {
      $Affectation = array('IdDepartement' => $IdDepartement,
                           'IdType'        => $IdType);
      $this->display($data);
      $this->set_breadcrumb(array("Affectation droit d'accées" => ''));
      $this->template->set_partial('container', 'add_entite_view', array('data' => $data,'Params' => $Affectation));
      //$this->template->set_partial('container', 'add_sousmenu_view', array('data' => $data,'smenu' => (array) $smenu[0],'hidden' => $hidden,'op_btn_value' => 'Modifier'));
      $this->template->title('dd','ee')->build('body');
  }
}
