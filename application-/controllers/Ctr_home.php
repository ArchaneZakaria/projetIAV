<?php defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/Master.php';

class Ctr_home extends Master
{

    function __construct()
    {
        parent::__construct();

     $this->load->model('Retraite_model', 'retraite');
     $this->load->model('Piece_jointe_retraite_model', 'validation');
      date_default_timezone_set('Africa/Casablanca');
    }

    public function index($lang = '')
    {
             $this->display($lang);
             /** verifier l'ouverture de session */
            $op_modal = $this->load->view('modals/admin/op_modall', '', true);
            $this->template->set_partial('container', 'home_view',array('op_modal' => $op_modal ));
            $this->template->build('body');
    }





        public function notify($data = '',$id = NULL){
                $this->display($data);
                switch($data){

               //   case 'add':
               //
               // $this->set_breadcrumb(array("Ajouter une établissement" => 'mission/add'));
               // $this->template->set_partial('container', 'add_etablissement_view', array('data' => $data));
               // $this->template->title('dd','ee')
               //        ->build('body');
               //   break;

                case 'up':

               $etat_update= '';
              $conditions = $this->input->post('id');

              /*  if (!is_array($conditions) && intval($conditions))
              $conditions = array('id_etablissement' => intval($conditions));

            $etat_delete = $this->db->delete('etablissement', $conditions);*/
             $this->retraite->update(array('status_prolongation'=>'V'),$conditions);

               echo json_encode(array('status' => '200',
                                      'url' => 'prolongation',
                                   'message' => 'la prolongation a été annulé avec succes'));
                 break;

                 case 'ret':

                $etat_update= '';
               $conditions = $this->input->post('id');

               /*  if (!is_array($conditions) && intval($conditions))
               $conditions = array('id_etablissement' => intval($conditions));

             $etat_delete = $this->db->delete('etablissement', $conditions);*/
              $this->retraite->update(array('status_retraite'=>'E'),$conditions);

                echo json_encode(array('status' => '200',
                                       'url' => 'accueil',
                                    'message' => 'la retraite est en cours de traitement' ));
                  break;

                  //  case 'edit':
                  //
                  // if (($id = intval($id)) && !empty($id) && ($etablissement = $this->etablissement->read("*",array('id_etablissement' => $id)))) {
                  //   $hidden = array('id_etablissement' => $id);
                  //
                  //  $this->template->set_partial('container', 'add_etablissement_view', array('data' => $data,'etablissement' => (array) $etablissement[0],'hidden' => $hidden,'op_btn_value' => 'Modifier'));
                  //  }else{
                  // redirect(base_url('etablissement'));
                  //  }

                      //$this->template->set_partial('container', 'add_etablissement_view', array('data' => $data));
                      // $this->template->title('dd','ee')
                      // ->build('body');
                      //  break;

                 default:
        $op_modal = $this->load->view('modals/admin/op_modall', '', true);

       $this->template->set_partial('container', 'prolongation_view', array('data' => $data,'op_modal' => $op_modal));
       $this->template->title('dd','ee')
                      ->build('body');
                break;
                }




      }

public function retraite($data=''){

  $this->display($data);
  switch($data){

 //   case 'add':
 //
 // $this->set_breadcrumb(array("Ajouter une établissement" => 'mission/add'));
 // $this->template->set_partial('container', 'add_etablissement_view', array('data' => $data));
 // $this->template->title('dd','ee')
 //        ->build('body');
 //   break;

  case 'del':

 $etat_update= '';
$conditions = $this->input->post('id');

/*  if (!is_array($conditions) && intval($conditions))
$conditions = array('id_etablissement' => intval($conditions));

$etat_delete = $this->db->delete('etablissement', $conditions);*/
$this->retraite->update(array('deleted_retraite'=>'O'),$conditions);

 echo json_encode(array('status' => '200',
                        'url' => 'accueil',
                     'message' => 'la retraite a été supprimé avec succes'));
   break;


   case 'edit':

 $etat_update= '';
 $conditions = $this->input->post('id');
 $nom_prn = $this->input->post('nom_prn');
 $daten = $this->input->post('daten');
 /*  if (!is_array($conditions) && intval($conditions))
 $conditions = array('id_etablissement' => intval($conditions));

 $etat_delete = $this->db->delete('etablissement', $conditions);*/
 $etat_update = $this->retraite->update(array('nom_retraite'=>$nom_prn,'date_naissance_retraite'=>$daten),$conditions);
  if($etat_update){
  echo json_encode(array('status' => '200',
                         'url' => 'accueil',
                        'message' => $nom_prn));
      }else{

        echo json_encode(array('status' => '200',
                               'url' => 'accueil',
                            'message' => 'Erreur de traitement'));
                    }
    break;

   default:
$op_modal = $this->load->view('modals/admin/op_modall', '', true);

$this->template->set_partial('container', 'home_view', array('data' => $data,'op_modal' => $op_modal));
$this->template->title('dd','ee')
        ->build('body');
  break;

}
  }
   //modifier prologation
          public function modifierPrologation($nb=NULL){

            $etat_update= '';
           $conditions = $this->input->post('id');

           /*  if (!is_array($conditions) && intval($conditions))
           $conditions = array('id_etablissement' => intval($conditions));

          $etat_delete = $this->db->delete('etablissement', $conditions);*/
          $date_retraite='';
          $date_retraite_notif='';
          $cadreR='1';
          $result = $this->retraite->read('*',array('deleted_retraite' => 'N','id_retraite' => $conditions));
          if(is_array($result) && !empty($result)){
                $nbr_prol = $result['0']->nbr_prolongation*2 ;
                $date_retraite = $result['0']->date_depart_retraite ;
                $date_retraite_notif = $result['0']->date_notif_retraite ;
                $cadreR = $result['0']->id_cadre ;
            }



          $date_retraiteE = date("Y-m-d", strtotime($date_retraite ."-". $nbr_prol ."years"));
          $date_retraite_notifE = date("Y-m-d", strtotime($date_retraite_notif ."-". $nbr_prol ."years"));
          // modifier nb de prolongation

          $date_retraiteEN = date("Y-m-d", strtotime($date_retraiteE ."+". $nb*2 ."years"));
          $date_retraite_notifEN = date("Y-m-d", strtotime($date_retraite_notifE ."+". $nb*2 ."years"));


        // nbr de prolongation max
        $cadre = $cadreR;
        $queryResult =  $this->db->query("select * from prolongation where id_cadre ='" . $cadre . "'");
        $nb_pr_mx = $queryResult->row()->nbf_annee_prolongation;

        // /  echo $nb. ' ' .$nb_pr_mx;die;
                if($nb_pr_mx >= $nb){
        $etat_up =   $this->retraite->update(array('nbr_prolongation'=>$nb,'date_depart_retraite' =>$date_retraiteEN,'date_notif_retraite' =>$date_retraite_notifEN),$conditions);

          echo json_encode(array('status' => '200',
                                   'url' => 'prolongation',
                                   'message' => 'la modification a été effectuée avec succes' ));

                      }else{

                        echo json_encode(array('status' => '0',
                                                 'url' => 'accueil',
                                                 'message' => 'veuillez saisir un  nombre valide de prolongation'));
                      }


          }
    //modifier prologation



    //modifier prologation
           public function ValiderPrologation($nb=NULL){

             $etat_update= '';
            $conditions = $this->input->post('id');
            $cadre= $this->input->post('id_cadre');
            $datenotif= $this->input->post('notif');
            $departr= $this->input->post('departr');
            $queryResult =  $this->db->query("select * from prolongation where id_cadre ='" . $cadre . "'");
            $id_pr = $queryResult->row()->id_prolongation;
             $nb_pr_mx = $queryResult->row()->nbf_annee_prolongation;
            /*  if (!is_array($conditions) && intval($conditions))
            $conditions = array('id_etablissement' => intval($conditions));

          $etat_delete = $this->db->delete('etablissement', $conditions);*/
        $datenotifv = date("Y-m-d", strtotime($datenotif ."+". $nb * 2 ."years"));
        $departrv = date("Y-m-d", strtotime($departr ."+". $nb * 2 ."years"));
// /  echo $nb. ' ' .$nb_pr_mx;die;
        if($nb_pr_mx >= $nb){
         $etat_up =   $this->retraite->update(array('nbr_prolongation'=>$nb,'id_prolongation' => $id_pr,'status_prolongation'=>'E','date_notif_retraite' =>$datenotifv,'date_depart_retraite'=>$departrv),$conditions);
         echo json_encode(array('status' => '200',
                                  'url' => 'accueil',
                                  'message' => 'la validation de prologation a été effectuée avec succes'));
  }else{
           echo json_encode(array('status' => '0',
                                    'url' => 'accueil',
                                    'message' => 'veuillez saisir un  nombre valide de prolongation'));
    }
           }
     //modifier prologation

public function verifyUser()	{
		$this->load->view('vue');
	}


// This function call from AJAX
public function user_data_submit() {
$data = array(
'username' => $this->input->post('name'),
'pwd'=>$this->input->post('pwd')
);

//Either you can print value or you can send value to database
echo json_encode($data);
}


public function error(){

 $this->load->view('view_404');
}


/**
 * Route vers l table des retraiter en cours
 * Hachim Samir
 */
public function encours($lang = '')
{

         $this->display($lang);
         /** verifier l'ouverture de session */
        $this->template->set_partial('container', 'retraite_view',array());
        $this->template->build('body');



}


/**
 * Route vers l table des retraiter en cours
 * Hachim Samir
 */
public function valider($lang = '')
{

         $this->display($lang);
         /** verifier l'ouverture de session */
        $this->template->set_partial('container', 'vretraite_view',array());
        $this->template->build('body');



}

 /**
 * Verifier les validation a ajouter pour chaque retraiter
 * Hachim Samir
 */
public function verifierValidation()
{
    $ID = $this->input->post('ID');
        $QueryValidation = $this->db->query("SELECT validation.id_validation,
                                                validation.libelle_validation,
                                                piece_jointe_retraite.id_validation AS InsertValidation
                                        FROM validation
                                        LEFT JOIN piece_jointe_retraite ON (piece_jointe_retraite.id_validation = validation.id_validation AND
                                                                            piece_jointe_retraite.deleted_piece_jointe_retraite = 'N' AND
                                                                            piece_jointe_retraite.id_retraite = '".$ID."')
                                        WHERE validation.deleted_validation = 'N' ");


        $NumberRow = $this->db->affected_rows();
        $NbrRowsAff = 0;
        foreach($QueryValidation->result() as $rowValidation ){
            if($rowValidation->InsertValidation == $rowValidation->id_validation){
                $NbrRowsAff+=1;
            }
        ?>
            <div class="form-group">
                <div class="col-md-12">
                    <label class="checkbox">
                        <label>
                                <input type="checkbox" style="margin-top:10px;" <?php if($rowValidation->InsertValidation == $rowValidation->id_validation){ echo "disabled"; echo " checked"; } ?> name="Check_<?= $rowValidation->id_validation ?>" value="Check_<?= $rowValidation->id_validation ?>" id="Check_<?= $rowValidation->id_validation ?>">
                                <h5><?= $rowValidation->libelle_validation ?></h5>
                        </label>
                    </label>
                </div>
            </div>
        <?php

        }

        if($NumberRow == $NbrRowsAff){
            ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label></label><br>
                        <span class="file-input file-input-new"><div class="file-preview ">
                            <div class="close fileinput-remove text-right" id="removepreview-thumb" style="display:block">×</div>
                            <div class="file-preview-thumbnails" id="preview-thumb"> <img id="preview-picture" src="" alt="" style="width:80px; height:80px"></div>
                            <div class="clearfix"></div>
                            <div class="file-preview-status text-center text-success">

                            </div>
                        </div>

                        <div class="btn btn-danger btn-file">
                            <i class="glyphicon glyphicon-folder-open"></i> &nbsp;Telecharger Fichier <input type="file" accept="image/*" id="file-simple">
                        </div>
        </span>
                    </div>
                </div>
            <?php
        }
}

/**
 * Inserer les validation  pour chaque retraiter
 * Hachim Samir
 */
public function insertValidation(){
    $ID           = $this->input->post('ID');
    $listCheck    = $this->input->post('listCheck');


    parse_str($listCheck, $output);

    $QueryValidation = $this->db->query("SELECT validation.id_validation,
                                                validation.libelle_validation,
                                                piece_jointe_retraite.id_validation AS InsertValidation
                                        FROM validation
                                        LEFT JOIN piece_jointe_retraite ON (piece_jointe_retraite.id_validation = validation.id_validation AND
                                                                            piece_jointe_retraite.deleted_piece_jointe_retraite = 'N' AND
                                                                            piece_jointe_retraite.id_retraite = '".$ID."')
                                        WHERE validation.deleted_validation = 'N' ");
    $NumberRow = $this->db->affected_rows();
    $NbrRowsAff = 0;
    $by = 1;
    $date = date('Y-m-d H:i:s');

    foreach($QueryValidation->result() as $rowValidation ){
        $IdValidation = $rowValidation->id_validation;
        if($rowValidation->InsertValidation == $rowValidation->id_validation){

        }else if($rowValidation->InsertValidation != $rowValidation->id_validation){

                $ValueId = $output['Check_'.$IdValidation];

            if($ValueId == 1){
                $options=array('id_retraite'                 => $ID,
                           'id_validation'               => $IdValidation,
                           'cby_piece_jointe_retraite'   => $by,
                           'cdate_piece_jointe_retraite' => $date);


                $this->db->insert('piece_jointe_retraite', $options);

                echo 1;
            }




        }
    }

}

/**
 * Inserer les validation  pour chaque retraiter
 * Hachim Samir
 */
public function retraiteValidation(){
    $ID           = $this->input->post('ID');
    $FileBlob     = $this->input->post('FileBlob');

    $Status           = 'V';

    $UpdateRetraite = $this->db->set('file_upload_retraite', $FileBlob);
    $UpdateRetraite = $this->db->set('status_retraite'     , $Status);
    $UpdateRetraite = $this->db->where('id_retraite'       , $ID);
    $UpdateRetraite = $this->db->update('retraite');

    echo 1;

}

/**
 * Inserer les validation  pour chaque retraiter
 * Hachim Samir
 */


}
/* End of file home.php */
/* Location: ./application/controllers/home.php */
