<?php defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/Master.php';

class Ctr_home extends Master
{

    function __construct()
    {
        parent::__construct();

     /*$this->load->model('Retraite_model', 'retraite');
     $this->load->model('Piece_jointe_retraite_model', 'validation');*/
      date_default_timezone_set('Africa/Casablanca');
    }

    public function index($lang = '')
    {
            $this->display($lang);
             /** verifier l'ouverture de session */

              $this->set_breadcrumb(array());
            $op_modal = $this->load->view('modals/admin/op_modall', '', true);
            $this->template->set_partial('container', 'home_view',array('op_modal' => $op_modal ));
            $this->template->build('body');
    }

    public function stateTest($lang = ''){
     $this->display($lang);
      $this->template->set_partial('container', 'stateTest_view',array());
      $this->template->build('body');
    }


/*** upload file **/

public function uploaderFile($lang = ''){
  $this->display($lang);
  /** verifier l'ouverture de session */
 $op_modal = $this->load->view('modals/admin/op_modall', '', true);
 $this->template->set_partial('container', 'upload_view',array('op_modal' => $op_modal ));
 $this->template->build('body');
}


function do_upload(){

  $ID           =  $this->input->post('IdRetraite');
  $TypeDoc      = $this->input->post('TypeDocument');
  $FileBlob     = $this->input->post('FileBlob');

       $config['upload_path']="./assets/images";
         $config['allowed_types']='gif|jpg|png|pdf';
       $config['encrypt_name'] = TRUE;
        //
       $this->load->library('upload',$config);
       if($this->upload->do_upload("file-simple")){
            $data = $this->upload->data();

            //Resize and Compress Image
            $config['image_library']='gd2';
            $config['source_image']='./assets/images/'.$data['file_name'];
            $config['create_thumb']= FALSE;
            $config['maintain_ratio']= FALSE;
            $config['quality']= '60%';
            $config['width']= 600000;
            $config['height']= 4000000;
            $config['new_image']= './assets/images/'.$data['file_name'];
            // $this->load->library('image_lib', $config);
            // $this->image_lib->resize();

            $title= $this->input->post('title');
            $image= $data['file_name'];


            // $result= $this->upload_model->save_upload($title,$image);
            // echo json_decode($result);


            $Status           = 'V';

            $options=array(/*'file_typedocument_retraite'                 => $FileBlob,*/
                        'id_retraite'               => $ID,
                        'id_typedocument'               => $TypeDoc,
                      'file_document_retraite' => $image);
            $SQLretraite = $this->db->query("select * from retraite where retraite.id_retraite ='". $ID ."'");
            $REGime = $SQLretraite->row();
            $IDRegime = $REGime->id_regime;

            $this->db->insert('typedocument_retraite', $options);



            $SqlValidationRetraite = $this->db->query(" SELECT COUNT(typedocument.id_typedocument) AS TotalTypeDocument,
                                                               COUNT(typedocument_retraite.id_typedocument) AS DocTypeDocument
                                                        FROM typedocument
                                                        LEFT JOIN typedocument_retraite ON (typedocument_retraite.id_typedocument = typedocument.id_typedocument AND
                                                                                            typedocument_retraite.id_retraite = ".$ID." AND
                                                                                            typedocument_retraite.deleted_typedocument_retraite = 'N')
                                                        WHERE typedocument.deleted_typedocument = 'N'");
            $RowValidationRetraite = $SqlValidationRetraite->result();
            $TotalTypeDoc = $RowValidationRetraite[0]->TotalTypeDocument;
            $DocTypeDoc   = $RowValidationRetraite[0]->DocTypeDocument;

            if($IDRegime == '1'){
              $UpdateRetraite = $this->db->set('status_retraite', $Status);
              $this->db->where('id_retraite', $ID);
              $UpdateRetraite = $this->db->update('retraite');
            }elseif($TotalTypeDoc == $DocTypeDoc){
                $UpdateRetraite = $this->db->set('status_retraite', $Status);
                $this->db->where('id_retraite', $ID);
                $UpdateRetraite = $this->db->update('retraite');
            }


        echo "1";





      }else{
          echo "0";
      }



}

/*** upload file **/


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
              $this->retraite->update(array('notif_retraite'=>'V'),$conditions);

                echo json_encode(array('status' => '200',
                                       'url' => 'accueil/encours',
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
           public function ValiderPrologation($nb=NULL,$nbM=NULL){

             $etat_update= '';
             $nbrMoisR ='0';
             $nbAnnR = '0';
            $conditions = $this->input->post('id');
            $nbmR= $this->input->post('nbm');
            $cadre= $this->input->post('id_cadre');
            $datenotif= $this->input->post('notif');
            $departr= $this->input->post('departr');
            $queryResult =  $this->db->query("select * from prolongation where id_cadre ='" . $cadre . "'");
            $queryResultRet =  $this->db->query("select * from retraite where id_retraite ='" . $conditions . "'");
            $id_pr = $queryResult->row()->id_prolongation;
            $nb_annee_Ancien = $queryResultRet->row()->nbr_prolongation;
            $nb_mois_Ancien = $queryResultRet->row()->nb_ms_prolongation;
            $nb_pr_mx = $queryResult->row()->nbf_annee_prolongation;

            $nbrMoisR = $nbM + $nb_mois_Ancien;
            $nbAnnR = $nb + $nb_annee_Ancien;
            /*  if (!is_array($conditions) && intval($conditions))
            $conditions = array('id_etablissement' => intval($conditions));

          $etat_delete = $this->db->delete('etablissement', $conditions);*/
          $sqlDepartR = "select DATE_ADD('" . $departr ."',INTERVAL ". $nbmR ." YEAR_MONTH) as dateDep";
          $resultDepartR = $this->db->query($sqlDepartR);


        $departrv = date_format(date_create($resultDepartR->row()->dateDep), 'Y-m-d');


         /** calculer date de notification **/
        $sqlDepartRNotif  = "select DATE_ADD('" . $departrv ."',INTERVAL -1 YEAR) as dateNotif";
        $resultDepartRNotif = $this->db->query($sqlDepartRNotif);
        $datenotifv  = date_format(date_create($resultDepartRNotif->row()->dateNotif), 'Y-m-d');

        /** ancien code **/
        // $datenotifv1 = date("Y-m-d", strtotime($departr ."+". $nb * 2 ."years" . "+". $nbM ."Month" ."-". 1 ."years" ));
        // $departrv1 = date("Y-m-d", strtotime($departr ."+". $nb * 2 ."years" . "+". $nbM ."Month"));

        /*** ancie code **/
      //  echo $departrv.' dateRee ' . $departr ."+". $nb * 2 ."years" . "+". $nbM ."Months";

// /  echo $nb. ' ' .$nb_pr_mx;die;
        if($nb_pr_mx >= $nb){
         $etat_up =   $this->retraite->update(array('nbr_prolongation'=>$nbAnnR,'nb_ms_prolongation'=>$nbrMoisR,'id_prolongation' => $id_pr,'status_retraite'=>'N','status_prolongation'=>'E','date_notif_retraite' =>$datenotifv,'date_depart_retraite'=>$departrv),$conditions);
         echo json_encode(array('status' => '200',
                                  'url' => 'accueil',
                                  'message' => 'la validation de prologation a été effectuée avec succes= '.$departrv));
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

      $op_modal = $this->load->view('modals/admin/op_modall', '', true);
         $this->template->set_partial('container', 'retraite_view',array('op_modal' => $op_modal));
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
    $TypeDoc = $this->input->post('TypeDoc');
    $QueryValidation = $this->db->query("SELECT validation.id_validation,
                                                    typedocument_validation.id_validation AS InsertValidation,
                                                    validation.libelle_validation
                                             FROM validation
                                             LEFt JOIN typedocument_validation ON (validation.id_validation = typedocument_validation.id_validation AND
                                                                                        typedocument_validation.deleted_typedocument_validation = 'N'  AND
                                                                                        typedocument_validation.id_typedocument = ".$TypeDoc." AND
                                                                                        typedocument_validation.id_retraite = ".$ID.")
                                             WHERE validation.deleted_validation = 'N' ");


        $NumberRow = $this->db->affected_rows();
        $NbrRowsAff = 0;
        foreach($QueryValidation->result() as $rowValidation ){
            if($rowValidation->InsertValidation == $rowValidation->id_validation){
                $NbrRowsAff+=1;
            }
            $QueryTyepDocument = $this->db->query("select typedocument.nb_coche as nb_coche from typedocument where typedocument.deleted_typedocument ='N' and typedocument.id_typedocument = $TypeDoc");
            $NumberTyepDocument= $QueryTyepDocument->row()->nb_coche;
              // echo $NumberTyepDocument;


        ?>
            <div class="form-group">
                <div class="col-md-12">
                    <label class="checkbox">
                        <label>

                          <?php
                     if($rowValidation->id_validation != '3' ){
                    ?>
                                <input type="checkbox" style="margin-top:10px;" <?php if($rowValidation->InsertValidation == $rowValidation->id_validation){ echo "disabled"; echo " checked"; } ?> name="Check_<?= $rowValidation->id_validation ?>" value="Check_<?= $rowValidation->id_validation ?>" id="Check_<?= $rowValidation->id_validation ?>">
                                <h5><?= $rowValidation->libelle_validation ?></h5>
                     <?php }
                      if($rowValidation->id_validation == '3' && $NumberTyepDocument == '3'){ ?>
                       <input type="checkbox" style="margin-top:10px;" <?php if($rowValidation->InsertValidation == $rowValidation->id_validation){ echo "disabled"; echo " checked"; } ?> name="Check_<?= $rowValidation->id_validation ?>" value="Check_<?= $rowValidation->id_validation ?>" id="Check_<?= $rowValidation->id_validation ?>">
                          <h5><?= $rowValidation->libelle_validation ?></h5>
                     <?php }  ?>
                       <?php    if($rowValidation->id_validation == '3' && $NumberTyepDocument == '2'){ ?>
                         <input  type="checkbox" style="margin-top:10px;display:none;" <?php if($rowValidation->InsertValidation == $rowValidation->id_validation){ echo "disabled"; echo " checked"; } ?> name="Check_<?= $rowValidation->id_validation ?>" value="Check_<?= $rowValidation->id_validation ?>" id="Check_<?= $rowValidation->id_validation ?>">
                       <?php }  ?>
                        </label>
                    </label>
                </div>
            </div>



    <?php

        }

        $acces_f = $this->session->user['id_role'];





        if($NbrRowsAff >= $NumberTyepDocument){
            if($acces_f == 1){
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
                            <i class="glyphicon glyphicon-folder-open"></i> &nbsp;Telecharger Fichier <input type="file"  id="file-simple" name="file-simple">
                        </div>
        </span>
                    </div>
                </div>
            <?php
          }
        }
}

/**
 * Inserer les validation  pour chaque retraiter
 * Hachim Samir
 */
public function insertValidation(){
    $ID           = $this->input->post('ID');
    $TypeDoc           = $this->input->post('TypeDoc');
    $listCheck    = $this->input->post('listCheck');


    parse_str($listCheck, $output);

    $QueryValidation = $this->db->query("SELECT validation.id_validation,
                                        typedocument_validation.id_validation AS InsertValidation,
                                        validation.libelle_validation
                                        FROM validation
                                        LEFt JOIN typedocument_validation ON (validation.id_validation = typedocument_validation.id_validation AND
                                                        typedocument_validation.deleted_typedocument_validation = 'N'  AND
                                                        typedocument_validation.id_typedocument = ".$TypeDoc." AND
                                                        typedocument_validation.id_retraite = ".$ID.")
WHERE validation.deleted_validation = 'N'  ");
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
                           'id_typedocument'               => $TypeDoc);


                $this->db->insert('typedocument_validation', $options);


            }




        }
    }
  echo 1;
}

/**
 * Inserer les validation  pour chaque retraiter
 * Hachim Samir
 */
public function retraiteValidation(){
    $ID           = $this->input->post('ID');
    $TypeDoc      = $this->input->post('TypeDoc');
    $FileBlob     = $this->input->post('FileBlob');

    $Status           = 'V';

    $options=array('file_typedocument_retraite'                 => $FileBlob,
                'id_retraite'               => $ID,
                'id_typedocument'               => $TypeDoc);
    $SQLretraite = $this->db->query("select * from retraite where retraite.id_retraite ='". $ID ."'");
    $REGime = $SQLretraite->row();
    $IDRegime = $REGime->id_regime;

    $this->db->insert('typedocument_retraite', $options);



    $SqlValidationRetraite = $this->db->query(" SELECT COUNT(typedocument.id_typedocument) AS TotalTypeDocument,
                                                       COUNT(typedocument_retraite.id_typedocument) AS DocTypeDocument
                                                FROM typedocument
                                                LEFT JOIN typedocument_retraite ON (typedocument_retraite.id_typedocument = typedocument.id_typedocument AND
                                                                                    typedocument_retraite.id_retraite = ".$ID." AND
                                                                                    typedocument_retraite.deleted_typedocument_retraite = 'N')
                                                WHERE typedocument.deleted_typedocument = 'N'");
    $RowValidationRetraite = $SqlValidationRetraite->result();
    $TotalTypeDoc = $RowValidationRetraite[0]->TotalTypeDocument;
    $DocTypeDoc   = $RowValidationRetraite[0]->DocTypeDocument;

    if($IDRegime == '1'){
      $UpdateRetraite = $this->db->set('status_retraite', $Status);
      $this->db->where('id_retraite', $ID);
      $UpdateRetraite = $this->db->update('retraite');
    }elseif($TotalTypeDoc == $DocTypeDoc){
        $UpdateRetraite = $this->db->set('status_retraite', $Status);
        $this->db->where('id_retraite', $ID);
        $UpdateRetraite = $this->db->update('retraite');
    }

echo "1";



}

/**
 * Inserer les validation  pour chaque retraiter
 * Hachim Samir
 */


/*** khalid benabbes  **/
public function blob($file = NULL){
//header("contant-type : image/jpeg");
$this->load->helper('download');
$fichier = $this->input->post('FileBlob');
$file = 'uploads/'.$fichier;
//download file from directory
// force_download($fichier, NULL);
// echo "<pre>" . $file . "<pre>";

$contenuFichier = $fichier;
$nomFichier = 'file.jpg';

$tailleFichier = strlen($contenuFichier);

$nomFichier = str_replace('"', '\\"', $nomFichier);

header('Content-Type: application/pdf');
//header('Content-Type: application/octet-stream');
//header("Content-Length: $tailleFichier");
header("Content-Disposition: attachment; filename=\"$nomFichier\"");
//att
//echo json_encode(array('status' => '1',
                              //  'url' => 'prolongation',
                              //  'message' => 'la prolongation a été annulé avec succes'));



echo $contenuFichier;


//die;
}

function export($lang = '')
{

        $this->display($lang);
         /** verifier l'ouverture de session */
        $this->template->set_partial('container', 'export_view',array());
        $this->template->build('body');

}

function excel($name="")
{
     $filename =  "excel_report.csv";
     $fp = fopen('php://output', 'w');
     header('Content-Type: text/csv; charset=utf-8');
     header('Content-type: application/csv');
     header('Content-Disposition: attachment; filename='.$filename );

    $data_table=$this->input->post('tes');

    if($data_table!=null)
    {
        foreach ($data_table as $data)
        {
            $exceldata = array(
                    $data['1'],   // dummy column name here
                    $data['2'],
                    $data['3'],
                    $data['4'],
                    $data['5'],
                    $data['6'],
                    $data['7'],
                    );
            fputcsv($fp, $exceldata );
        }

    }
 die();

}
/*** khalid benabbes  **/

}
/* End of file home.php */
/* Location: ./application/controllers/home.php */
