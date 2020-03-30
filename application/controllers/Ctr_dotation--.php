<?php defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/Master.php';

class Ctr_dotation extends Master
{

function __construct() {
        parent::__construct();

      $this->load->library('form_validation');
      $this->load->model('Iav_personel_model', 'personnel');
      $this->load->model('Iav_annee_budget_model','annee_budget');
      $this->load->model('Iav_mission_model', 'mission');
      $this->load->model('Iav_chauffeur_model','chauffeur');
      $this->load->model('Iav_vehicule_model','vehicule');
      $this->load->model('Iav_dotation_mission_model','dotation');
      $this->load->model('Iav_type_budget_model','typeBudget');
      $this->load->model('Iav_type_budget__annee_montant','budgetAnneeMontant');
      $this->load->model('Iav_tranche_budget_model','tranche');
  }


  public function index($data = '')
  {

     $this->display($data);
    /* $this->set_breadcrumb(array("" => ''));*/
    $this->template->set_partial('container', 'dotation_view', array('data' => $data));
     $this->template->title('dd','ee')
                    ->build('body');
  }

/*
===================gestion du transport =========
*/

/********************* Carburant Open **************************/
public function carburantOpen($data = '',$idDotation=''){

   $this->display($data);

              switch($data){

               case 'demand':
 $this->template->set_partial('container', 'dotation/demand_dotationOpen_carburant_view', array('data' => $data));
  $this->template->title('dd','ee')
                    ->build('body');

               break;

              case 'gerer':
 $this->template->set_partial('container', 'dotation/gerer_dotationOpen_carburant_view', array('data' => $data));
  $this->template->title('dd','ee')
                    ->build('body');

               break;

              case 'del':
              case 'supprimer':
$errors = false;
$IDDotation = $this->input->post('IDDotation');
$MNTBudget = $this->input->post('MNTBudget');
$IDTRanche= $this->input->post('IDTranche');
 $option=array(
 'deleted_dotation_mission' => 'O',
 );

   $idDot = $this->dotation->update($option,array('id_dotation_mission' => $IDDotation),'udate_dotation_mission');

   $listDotation = $this->tranche->read('*',array('id_tranche_budget' => $IDTRanche));



   if(isset($listDotation) && !empty($listDotation)){

 $MNTTRANCHE =   $listDotation['0']->montant_execute;

 $MNTTRANCHE = floatval($MNTTRANCHE) + floatval($MNTBudget);

 $optionTranche = array('montant_execute' =>$MNTTRANCHE);

 $idTranche = $this->tranche->update($optionTranche,array('id_tranche_budget' =>$IDTRanche ),'udate_tranche_budget');


   echo json_encode(array('status' => '1','url' => 'etablissement','message' => "la ligne selectionnee a ete supprimee avec succees ",'contenu' => '','location' => 'dotation/carburant/def'));


   }else{
$errors = true;
   }



        if ($errors !== false)

       echo json_encode(array(
                                  'status' => '1',
                                  'location' => 'url',
                                  'message' => 'erreur de traitement'));


   //$this->tranche->update();



               break;

               case 'edit':
               case 'modifier':


$this->template->set_partial('container', 'dotation/demand_dotation_carburant_view', array('data' => $data));
  $this->template->title('dd','ee')
                    ->build('body');

               //break;


               default:
 $this->template->set_partial('container', 'gerer_dotation_carburant_view', array('data' => $data));
  $this->template->title('dd','ee')->build('body');
                    break;

              }



   }
/********************* Carburant **************************/

/********************* Carburant **************************/

   public function carburant($data = '',$idDotation=''){

   $this->display($data);

              switch($data){

               case 'demand':
 $this->template->set_partial('container', 'dotation/carburant/demand_dotation_carburant_view', array('data' => $data));
 $this->template->title('dd','ee')
                    ->build('body');

               break;

              case 'gerer':
 $this->template->set_partial('container', 'dotation/carburant/gerer_dotation_carburant_view', array('data' => $data));
  $this->template->title('dd','ee')
                    ->build('body');

               break;

              case 'del':
              case 'supprimer':
$errors = false;
$IDDotation = $this->input->post('IDDotation');
$MNTBudget = $this->input->post('MNTBudget');
$IDTRanche= $this->input->post('IDTranche');
 $option=array(
 'deleted_dotation_mission' => 'O',
 );

   $idDot = $this->dotation->update($option,array('id_dotation_mission' => $IDDotation),'udate_dotation_mission');

   $listDotation = $this->tranche->read('*',array('id_tranche_budget' => $IDTRanche));



   if(isset($listDotation) && !empty($listDotation)){

 $MNTTRANCHE =   $listDotation['0']->montant_execute;

 $MNTTRANCHE = floatval($MNTTRANCHE) + floatval($MNTBudget);

 $optionTranche = array('montant_execute' =>$MNTTRANCHE);

 $idTranche = $this->tranche->update($optionTranche,array('id_tranche_budget' =>$IDTRanche ),'udate_tranche_budget');


   echo json_encode(array('status' => '1','url' => 'etablissement','message' => "la ligne selectionnee a ete supprimee avec succees ",'contenu' => '','location' => 'dotation/carburant/gerer'));


   }else{
$errors = true;
   }

        if ($errors !== false)

       echo json_encode(array(
                                  'status' => '1',
                                  'location' => 'url',
                                  'message' => 'erreur de traitement'));


   //$this->tranche->update();



               break;

               case 'edit':
               case 'modifier':


if(($idDotation = intval($idDotation)) && !empty($idDotation) && ($dotation = $this->dotation->modifDotation($idDotation)) ) {
  $hidden = array('id_dotation_mission' => $idDotation);

  $this->template->set_partial('container','dotation/carburant/demand_dotation_carburant_view', array('data' => $data,'dotation' => (array) $dotation[0],'hidden' => $hidden,'op_btn_value' => 'Modifier'));
  $this->template->title('dd','ee')->build('body');

}else{

 redirect(base_url('dotation/carburant/gerer'));
}
               break;


                default:
 $this->template->set_partial('container', 'gerer_dotation_carburant_view', array('data' => $data));
  $this->template->title('dd','ee')->build('body');
                    break;

              }



   }

/********************* Carburant **************************/



/*============================== GET MISSION BY MATRICULE================*/
 public function getMissionByMatriule($data = ''){

  $idMatricule = $this->input->post('idMatricule');
  //$idMatricule='ee';
 $idmission = $this->dotation->GetMissonsByMPatricue($idMatricule);
if(isset($idmission) && !empty($idmission)){

 $html='';

          $html.='<option value="0">Choisir type mission</option>
                  ';

                            $queryDetail = $this->db->query('select * from iav_mission   where (deleted_mission="N" AND etat_mission="V")');
                            foreach($queryDetail->result() as $rowDetail ){

                            $html.='<option value="' . $rowDetail->id_mission  .'">';
                    $html.=$rowDetail->id_mission .'/18</option>';
                    }

  echo json_encode(array('status' => '1',
                                          'url' => 'etablissement',
                                          'message' => "Missions trouvés",
                                          'contenu' => $html));

   }
}

/*============================== GET MISSION BY MATRICULE================*/

/***** Get chauffeur By mission *****/

public function getChauffeurByMission(){
 $idMission = $this->input->post('idMission');
 $mission = $this->dotation->getChauffeurByMission($idMission);
if(isset($mission) && !empty($mission)){

  echo json_encode(array('status' => '1',
                                          'url' => 'etablissement',
                                          'message' => "Chauffeur trouvés",
                                          'contenu' => $mission));

   }
}


/******** get chauffeur By mission *****/


public function ajouterDotation(){


        $message="";
        $result="";
         $this->load->library('form_validation');
         $prefix = 'ordreMission';


$this->form_validation->set_rules('dateDotation', 'Date de creation de la dotation', 'required|trim',array('required' => 'Champs Date de creation de la dotation est obligatoire'));
$this->form_validation->set_rules('idMatricule', 'Matricue vehicule', 'required|trim',array('required' => 'Champs  Matricue vehicule est obligatoire'));
$this->form_validation->set_rules('typeMission', 'La mission', 'required|trim',array('required' => 'Champs Matricue vehicule est obligatoire'));
$this->form_validation->set_rules('montantVignette', 'montant Vignette', 'required|trim',array('required' => 'Champs  montant Vignette est obligatoire'));




        $errors = false;
      if ($this->form_validation->run()) {

$dateDotation  = $this->input->post('dateDotation');
$idMatricule   = $this->input->post('idMatricule');
$typeMission   = $this->input->post('typeMission');
$montantVignette   = $this->input->post('montantVignette');
$idChauffeurs = $this->input->post('idChauffeurs');





if(isset($idChauffeurs) && $idChauffeurs == '0'){
echo json_encode(array('status' => '0',
                                          'url' => 'etablissement',
                                          'message' => "Veuillez choisir un chauffeur",
                                          ));
}

if(isset($idMatricule) && $idMatricule == '0'){
echo json_encode(array('status' => '0',
                                          'url' => 'etablissement',
                                          'message' => "Veuillez choisir une matricule",
                                          ));
}



  $trancheBudget =  $this->dotation->getDotationTranche('carburant','2018');
  $typeBudget =  $this->typeBudget->read('*',array('libelle_type_budget'=> 'CARBURANT'));
  $idTranche=0;

   echo json_encode(array('status' => '1',
                                          'url' => 'etablissement',
                                          'message' => "Dotation est ajoutée avec succée",
                                           'contenu' => $typeBudget));


  /*
  if(isset($trancheBudget) && ($trancheBudget['0']->id_tranche_budget) > 0 ){
   $idTranche = $trancheBudget['0']->id_tranche_budget;

   $this->dotation->create(array(

   'id_doration_parent' => '0',
   'id_type_budget' => $typeBudget['0']->id_type_budget,
   'id_tranche_budget' => $idTranche,
   'cby_dotation_mission' => '1',
   'montant_dotation_mission' => $montantVignette ,
   'montant_dotation_mission' => $montantVignette ,
   'mission_id_mission' =>$typeMission,
   'cdate_dotation_mission'=>date(DATE_TIME_FORMAT)

    ));

  }else{
  echo json_encode(array('status' => '0',
                                          'url' => 'etablissement',
                                          'message' => "Probleme de gestion de a tranche",
                                          ));
  }



  echo json_encode(array('status' => '1',
                                          'url' => 'etablissement',
                                          'message' => "Dotation est ajoutée avec succée",
                                          'contenu' => $trancheBudget['0']->id_tranche_budget));



}else{
 $errors = validation_errors();
        if ($errors !== false)

       echo json_encode(array(
                                  'status' => '0',
                                  'location' => 'url',
                                 'message' => $errors));

                                } */
}
   }
/************* Ajouter une dotation ********/


/*
======================gestion de transport=============
*/
 public function transport($data = '',$id = null){
    $this->display($data);
    $Idtypebudget_Transport =  $this->typeBudget->read("*",array('libelle_type_budget' => 'TRANSPORT '))[0]->id_type_budget;
    switch($data){
    case 'demande':
    $this->set_breadcrumb(array("Demande dotation transport" => ''));
    $this->template->set_partial('container', 'dotation/transport/demand_dotation_transport_view', array('data' => $data));
    break;
    case 'gestion':
    $this->set_breadcrumb(array("Gestion dotation transport" => ''));
    $model = $this->template->load_view('../views/modals/admin/op_modall');
    $dotations_Transport = $this->dotation->getdotationsTransport(null,$Idtypebudget_Transport);
    $this->template->set_partial('container', 'dotation/transport/gerer_dotation_transport_view',
                                  array('data' => $data,'prefix'=>'dotationTransport','dotations_Transport' => $dotations_Transport,'model'=>$model));
    break;
    case 'modifier':
    $this->set_breadcrumb(array("Modifier dotation transport" => ''));
    $dotation_trn_mdf = $this->dotation->getdotationsTransport($id,$Idtypebudget_Transport);
    $this->template->set_partial('container', 'dotation/transport/edit_dotation_transport_view', array('data' => $data,'dotation_trn_mdf'=>$dotation_trn_mdf));
    break ;

    case 'dotation_transpo_impr':
    $this->set_breadcrumb(array("Gestion dotation transport" => 'dotation/transport/gestion'));
    $dotation = $this->dotation->getdotationsTransport($id,$Idtypebudget_Transport);
    $this->template->set_partial('container', 'dotation/transport/dotation_transpo_impr', array('data' => $data,'dotation' => $dotation));
    break ;

    }
    $this->template->title('Iav','Transport')->build('body');
   }

   //action get data mission par id mission pour form add dotation transport
   public function getchauffeurmission(){
       $id        = $this->input->post('id_mission');
       $chauffeur = $this->mission->getdataMissionByIdMission($id);
       echo  $this->template->load_view('dotation/transport/result_chauffeur_view',
                              array('chauffeur'=> $chauffeur));
   }
   public function getmissionvehicules()
   {
      $id_vehicule   =  $this->input->post('id_vehicule');
      $getmissions   = $this->mission->GetMissionsByVeichule($id_vehicule);
      echo  $this->template->load_view('dotation/transport/result_missions_view',
                             array('queryDetail'=> $getmissions));
   }
   //action ajouter dotation transport
   public function ajouterDotationTransport(){
     $this->form_validation->set_rules('mission', 'mission est obligatoire', 'callback_validation_check');
     $this->form_validation->set_rules('matricule', 'matricue est obligatoire', 'callback_validation_check');
     $this->form_validation->set_rules('chauffeur', 'chauffeur  est obligatoire', 'callback_validation_check');
     $this->form_validation->set_rules('montant', 'montant est obligatoire', 'required|trim',
                                  array('required' => 'Le champs Montant vignette  est obligatoire'));
    $this->form_validation->set_rules('date', 'date est obligatoire', 'required|trim',
                                 array('required' => 'Le Champs date dotation est obligatoire'));
    if ($this->form_validation->run()) {

      $mission                =  $this->input->post('mission');
      $matricule              =  $this->input->post('matricue');
      $chauffeur              =  $this->input->post('chauffeur');
      $montant                =  $this->input->post('montant');
      $date                   =  $this->input->post('date');
      $Idtypebudget_Transport =  $this->typeBudget->read("*",array('libelle_type_budget' => 'TRANSPORT '))[0]->id_type_budget;
      $annee_courante         = date("Y");
      $id_Annee_courante      = $this->annee_budget->read("*",array('libelle_annee'=> $annee_courante))[0]->id_annee_budget;
      $t_typeAnneeBudget      = $this->budgetAnneeMontant->read("*",array('id_type_budget'=> $Idtypebudget_Transport,'id_annee_budget' => $id_Annee_courante,
       'deleted_type_budget__Annee_montantcol' => 'N'));
       if(count($t_typeAnneeBudget) == 0){
         $message = "Erreur Aucun  budget Annuel du type transport";
         echo json_encode(array('status' => '0',
                                'location' => 'url',
                                'message' => $message));
        return;
       }
       $id_typeAnneeBudget = $t_typeAnneeBudget[0]->id_type_budget__Annee_montant;

      $tranches             = $this->tranche->read("*",array('id_type_budget_Annee_montant' => $id_typeAnneeBudget,'deleted_tranche_budget' =>'N' ));
      if(count($tranches) == 0){
        $message = "Erreur  Aucune tranche existe pour le budget Annuel";
        echo json_encode(array('status' => '0',
                               'location' => 'url',
                               'message' => $message));
       return;
      }
      $last_tranche          = array_slice($tranches,count($tranches)-1)[0];
      $id_last_tranche       = $last_tranche->id_tranche_budget;
      if($last_tranche->montant_execute >= $montant){
        $options               = array(
                 'mission_id_mission'       => $mission,
                 'id_type_budget'           => $Idtypebudget_Transport,
                 'montant_dotation_mission' => $montant,
                 'id_tranche_budget'        => $id_last_tranche,
                 'date_dotation'            => $date
        );
        $reslt = $this->dotation->create($options,'cdate_dotation_mission');
        if($reslt){
          $rslt_trnch = $this->tranche->update(array('montant_execute' => $last_tranche->montant_execute - $montant),array('id_tranche_budget' => $id_last_tranche ),'udate_tranche_budget');
          if($rslt_trnch){
            $message = "vos informations ont éte enregistrées avec succée";
            echo json_encode(array('status' => '1',
                                   'location' => 'url',
                                   'message' => $message,
                                  'id_last_add_dotation'=>$reslt));
          }else {
            $message = "Erreur de traitement";
            echo json_encode(array('status' => '0',
                                   'location' => 'url',
                                   'message' => $message));
          }
        }else {
          $message = "Erreur de traitement";
          echo json_encode(array('status' => '0',
                                 'location' => 'url',
                                 'message' => $message));
        }
      }else {
        $message = " Le Montant cumulatif est insuffisant";
        echo json_encode(array('status' => '0',
                               'location' => 'url',
                               'message' => $message));
      }
   }else {
     $errors = validation_errors();
     echo json_encode(array('status' => '0',
                            'location' => 'url',
                            'message' => $errors));
   }
   }

   public function getOrdreMission()
   {
     $id                    =  $this->input->post('id');
     $missionid             =  $this->dotation->read("mission_id_mission",array('id_dotation_mission'=>$id))[0]->mission_id_mission;
     $vue                   = $this->template->load_view('ordre_mission/imprimer_addordre_mission_encours_view',array('idmission' => $missionid));
     echo $vue;
   }
   public function delete_dotation()
   {
        $id_dotation    =  $this->input->post('id');
        $reslt          = $this->dotation->update(array('deleted_dotation_mission' =>'O'),array('id_dotation_mission'=>$id_dotation),'ddate_dotation_mission');
        if($reslt){
          $dotation      = $this->dotation->read("*",array('id_dotation_mission' => $id_dotation))[0];
          $getidtranche  =  $dotation->id_tranche_budget;
          $mont_ex_old_tranche  = $this->tranche->read("*",array('id_tranche_budget' => $getidtranche))[0]->montant_execute;
          $reslt_tr = $this->tranche->update(array('montant_execute' => $mont_ex_old_tranche + $dotation->montant_dotation_mission),array('id_tranche_budget'=>$getidtranche),'udate_tranche_budget');
          if($reslt_tr){
            $message = "vos informations ont été supprimées avec succée";
            echo json_encode(array('status' => '1',
                                   'location' => 'url',
                                   'message' => $message));
          }else {
            $message = "Erreur de traitement T";
            echo json_encode(array('status' => '0',
                                   'location' => 'url',
                                   'message' => $message));
          }
        }else {
          $message = "Erreur de traitement D";
          echo json_encode(array('status' => '0',
                                 'location' => 'url',
                                 'message' => $message));
        }

   }

   public function modifierDotationTransport()
   {
     $this->form_validation->set_rules('montant', 'montant est obligatoire', 'required|trim',
                                  array('required' => 'Le champs Montant vignette  est obligatoire'));
      $this->form_validation->set_rules('date', 'date est obligatoire', 'required|trim',
                                   array('required' => 'Le champs date dotation est obligatoire'));
   if ($this->form_validation->run()) {
     $mission                =  $this->input->post('mission');
     $matricule              =  $this->input->post('matricue');
     $chauffeur              =  $this->input->post('chauffeur');
     $montant                =  $this->input->post('montant');
     $date                   =  $this->input->post('date');
     $id_dotation_miss       =  $this->input->post('id_dot_miss');
     $Idtypebudget_Transport =  $this->typeBudget->read("*",array('libelle_type_budget' => 'TRANSPORT '))[0]->id_type_budget;

       $options               = array(
                'mission_id_mission'       => $mission,
                'id_type_budget'           => $Idtypebudget_Transport,
                'montant_dotation_mission' => $montant,
                'date_dotation'            => $date
       );
    $old_dotation_trans    = $this->dotation->read("*",array('id_dotation_mission' => $id_dotation_miss));
    $old_tranche           = $this->tranche->read("*",array('id_tranche_budget' => $old_dotation_trans[0]->id_tranche_budget));
    $newMont_tr            = $old_tranche[0]->montant_execute + $old_dotation_trans[0]->montant_dotation_mission;
      if($montant <= $old_tranche[0]->montant_execute + $old_dotation_trans[0]->montant_dotation_mission){
        $reslt = $this->dotation->update($options,array('id_dotation_mission' => $id_dotation_miss),'udate_dotation_mission');
        if($reslt){
          $reslt_tr = $this->tranche->update(array('montant_execute' => $newMont_tr - $montant),
                                                    array('id_tranche_budget'=>$old_tranche[0]->id_tranche_budget),'udate_tranche_budget');
          if($reslt_tr){
            $message = "vos informations ont été modifiées avec succée";
            echo json_encode(array('status' => '1',
                                   'location' => 'url',
                                   'message' => $message));
          }else {
            $message = "Erreur de traitement T";
            echo json_encode(array('status' => '0',
                                   'location' => 'url',
                                   'message' => $message));
          }
        }else {
          $message = "Erreur de traitement D";
          echo json_encode(array('status' => '0',
                                 'location' => 'url',
                                 'message' => $message));
        }
      }else {
        $message = "Le Montant cumulatif est insuffisant";
        echo json_encode(array('status' => '0',
                               'location' => 'url',
                               'message' => $message));
      }
   }else {
     $errors = validation_errors();
     echo json_encode(array('status' => '0',
                            'location' => 'url',
                            'message' => $errors));
   }
   }


/*
======================gestion de transport=============
*/



/****************** Ajax ************/

/************ Ajouter une dotation ********/
public function ajouterDotationCarbs($op=''){

switch($op){

  case 'demand':
  case 'add':

         $message="";
         $result="";
         $this->load->library('form_validation');
         $prefix = 'dotation';


$this->form_validation->set_rules('dateDotation', 'Date de creation de la dotation', 'required|trim',array('required' => 'Champs Date de creation de la dotation est obligatoire'));
$this->form_validation->set_rules('idMatricule', 'Matricule vehicule', 'required|trim',array('required' => 'Champs  Matricule vehicule est obligatoire'));
$this->form_validation->set_rules('typeMission', 'La mission', 'required|trim',array('required' => 'Champs typeMission  est obligatoire'));
$this->form_validation->set_rules('montantVignette', 'montant Vignette', 'required|trim',array('required' => 'Champs  montant Vignette est obligatoire'));





        $errors = false;
      if ($this->form_validation->run()) {

      $dateDotation  = $this->input->post('dateDotation');
      $idMatricule   = $this->input->post('idMatricule');
      $typeMission   = $this->input->post('typeMission');
      $montantVignette   = $this->input->post('montantVignette');

if(isset($idMatricule) && $idMatricule == '0'){
echo json_encode(array('status' => '0',
                                          'url' => 'etablissement',
                                          'message' => "Veuillez choisir une matricule",
                                          ));
}else{


  $trancheBudget =  $this->dotation->getDotationTranche('CARBURANT','2018');
  $typeBudget =  $this->typeBudget->read('*',array('libelle_type_budget'=> 'CARBURANT'));
  $idTranche=0;
  $montantExecuse = $trancheBudget->montant_execute;
  /* $trancheBudget['0']->id_tranche_budge*/

  $option = array(
   'mission_id_mission' => $typeMission,
   'cby_dotation_mission' =>'1',
   'id_type_budget' =>$typeBudget['0']->id_type_budget,
   'id_tranche_budget' => $trancheBudget->id_tranche_budget,
    'montant_dotation_mission' => $montantVignette ,

  );

 $montant_execute = $trancheBudget->montant_execute;
if($montant_execute >= $montantVignette){
if( ($trancheBudget->montant_execute > 0) && ($montantVignette > 0) && ($montant_execute >= $montantVignette ) ){



 if(($id = $this->input->post('id')) ){
/*

      $idDotationM = $this->dotation->updateDotation($id);
     $montant_execute = ($idDotationM[0]->id_tranche_budget + $idDotationM[0]->id_dotation_mission) - $montantVignette;

    $this->dotation->update(
                array('montant_dotation_mission' => $montantVignette,
                     'udate_dotation_mission' => date(DATE_TIME_FORMAT),
                     ),array('id_dotation_mission'=> $id ));


        $this->tranche->update(
                array('montant_execute' => $montant_execute,
                     'udate_tranche_budget' => date(DATE_TIME_FORMAT),
                     ),array('id_tranche_budget'=> $trancheBudget->id_tranche_budget ));
*/
     $message = "Vos informations ont été modifiées avec succès.";

     echo json_encode(array('status' => '1',
                                          'url' => 'etablissement',
                                          'message' => $message,
                                           'contenu' => $trancheBudget->montant_execute));



      }else{





   $idDotation = $this->dotation->create($option);
   $montant_execute =  $montant_execute - $montantVignette;
   $this->tranche->update(
                array('montant_execute' => $montant_execute,
                     'udate_tranche_budget' => date(DATE_TIME_FORMAT),
                     ),array('id_tranche_budget'=> $trancheBudget->id_tranche_budget ));


    echo json_encode(array('status' => '1',
                                          'url' => 'etablissement',
                                          'message' => "Dotation est ajoutée avec succée",
                                           'contenu' => $trancheBudget->montant_execute));


}


 }else{

echo json_encode(array('status' => '0',
                                          'url' => 'etablissement',
                                          'message' => "Problème du montant de la dotation ou de  la tranche ",
                                           'contenu' => $trancheBudget->montant_execute));
      }
}else{



  // erreur de montant


}
     //$this->tranche->update(array('montant_execute' => ))
   echo json_encode(array('status' => '1',
                                          'url' => 'etablissement',
                                          'message' => "Dotation est ajoutée avec succée",
                                           'contenu' => $trancheBudget->montant_execute));



}





}else{


    $errors = validation_errors();
    echo json_encode(array('status' => '0',
                        'location' => 'url',
                        'message' => $errors));

         /*echo json_encode(array('status' => '0',
                                          'url' => 'etablissement',
                                          'message' => "Veuillez choisir un chauffeur",
              ));*/
}

  break;

  case 'del':
  case 'supprimer':
  echo json_encode(

  array('status' => '1',
                                          'url' => 'etablissement',
                                          'message' => "la ligne de dotation et supprimée",
                                           'contenu' => $trancheBudget->montant_execute)

                                           );
  break;

  case 'edit':
  case 'modifier':
  echo json_encode(

  array('status' => '1',
                                          'url' => 'etablissement',
                                          'message' => "la ligne de dotation a été modifié",
                                           'contenu' => $trancheBudget->montant_execute)

                                           );
  break;

  default:

  break;
}

}


/*********** Ajax ******************/

/******************************** start (mahfoud) gestion requisition ****/
public function requisition($data = '',$id = null){
   $this->display($data);
   $Idtypebudget_requisit =  $this->typeBudget->read("*",array('libelle_type_budget' => 'REQUISITION '))[0]->id_type_budget;
   switch($data){
   case 'demande':
   $this->set_breadcrumb(array("Demande dotation requisition" => ''));
   $this->template->set_partial('container', 'dotation/requisition/demand_dotation_requisition_view', array('data' => $data));
   break;
   case 'gestion':
   $this->set_breadcrumb(array("Gestion dotation requisition" => ''));
   $model = $this->template->load_view('../views/modals/admin/op_modall');
   $dotations_Requsisiton = $this->dotation->getdotationsTransport(null,$Idtypebudget_requisit);
   $this->template->set_partial('container', 'dotation/requisition/gerer_dotation_requisition_view',
                                 array('data' => $data,'prefix'=>'dotationRequisition','dotations_Requsisiton' => $dotations_Requsisiton,'model'=>$model));
   break;
   case 'modifier':
   $this->set_breadcrumb(array("Modifier dotation requisition" => ''));
   $dotation_trn_mdf = $this->dotation->getdotationsTransport($id,$Idtypebudget_requisit);
   $this->template->set_partial('container', 'dotation/requisition/edit_dotation_requisition_view', array('data' => $data,'dotation_trn_mdf'=>$dotation_trn_mdf));
   break;
   case 'dotationRequisitionImpr':
   $this->set_breadcrumb(array("Gestion dotation requisition" => 'dotation/requisition/gestion'));
   $dotation = $this->dotation->getdotationsTransport($id,$Idtypebudget_requisit);
   $this->template->set_partial('container', 'dotation/requisition/dotation_requisition_impr', array('data' => $data,'dotation' => $dotation));
   break ;
   }
   $this->template->title('Iav','Requisition')->build('body');
  }

  public function ajouterDotationRequisition(){
    $this->form_validation->set_rules('mission', 'mission est obligatoire', 'callback_validation_check');
    $this->form_validation->set_rules('montant', 'montant est obligatoire', 'required|trim',
                                 array('required' => 'Le champs Montant vignette  est obligatoire'));
     $this->form_validation->set_rules('date', 'date est obligatoire', 'required|trim',
                                  array('required' => 'Le champs date dotation  est obligatoire'));
   if ($this->form_validation->run()) {

     $mission                =  $this->input->post('mission');
     $montant                =  $this->input->post('montant');
     $date                   =  $this->input->post('date');
     $Idtypebudget_requisit  =  $this->typeBudget->read("*",array('libelle_type_budget' => 'REQUISITION '))[0]->id_type_budget;
     $annee_courante         = date("Y");
     $id_Annee_courante      = $this->annee_budget->read("*",array('libelle_annee'=> $annee_courante))[0]->id_annee_budget;
     $id_typeAnneeBudget     = $this->budgetAnneeMontant->read("*",array('id_type_budget'=> $Idtypebudget_requisit,'id_annee_budget' => $id_Annee_courante))[0]->id_type_budget__Annee_montant;
     $tranches               = $this->tranche->read("*",array('id_type_budget_Annee_montant' => $id_typeAnneeBudget,'deleted_tranche_budget' =>'N' ));
     if(count($tranches) == 0){
       $message = "Erreur Erreur Aucune tranche existe pour le budget Annuel";
       echo json_encode(array('status' => '0',
                              'location' => 'url',
                              'message' => $message));
      return;
     }
     $last_tranche          = array_slice($tranches,count($tranches)-1)[0];
     $id_last_tranche       = $last_tranche->id_tranche_budget;
     if($last_tranche->montant_execute >= $montant){
       $options               = array(
                'mission_id_mission'       => $mission,
                'id_type_budget'           => $Idtypebudget_requisit,
                'montant_dotation_mission' => $montant,
                'id_tranche_budget'        => $id_last_tranche,
                'date_dotation'            => $date
       );
       $reslt = $this->dotation->create($options,'cdate_dotation_mission');
       if($reslt){
         $rslt_trnch = $this->tranche->update(array('montant_execute' => $last_tranche->montant_execute - $montant),array('id_tranche_budget' => $id_last_tranche ),'udate_tranche_budget');
         if($rslt_trnch){
           $message = "vos informations ont éte enregistrées avec succée";
           echo json_encode(array('status' => '1',
                                  'location' => 'url',
                                  'message' => $message,
                                  'id_last_add_dotation' => $reslt
                                ));
         }else {
           $message = "Erreur de traitement";
           echo json_encode(array('status' => '0',
                                  'location' => 'url',
                                  'message' => $message));
   }
   }else {
         $message = "Erreur de traitement";
         echo json_encode(array('status' => '0',
                                'location' => 'url',
                                'message' => $message));
   }
   }else {
   $message = " Le Montant cumulatif est insuffisant";
   echo json_encode(array('status' => '0',
                              'location' => 'url',
                              'message' => $message));
  }
  }else {
    $errors = validation_errors();
    echo json_encode(array('status' => '0',
                           'location' => 'url',
                           'message' => $errors));
  }
  }
  public function modifierDotationrequsition()
  {
    $this->form_validation->set_rules('montant', 'montant est obligatoire', 'required|trim',
                                 array('required' => 'Le champs Montant vignette  est obligatoire'));
   $this->form_validation->set_rules('date', 'date est obligatoire', 'required|trim',
                                array('required' => 'Le champs date dotation  est obligatoire'));
  if ($this->form_validation->run()) {
    $mission                =  $this->input->post('mission');
    $montant                =  $this->input->post('montant');
    $date                   =  $this->input->post('date');
    $id_dotation_miss       =  $this->input->post('id_dot_miss');
    $Idtypebudget_requisit =  $this->typeBudget->read("*",array('libelle_type_budget' => 'REQUISITION '))[0]->id_type_budget;

      $options               = array(
               'mission_id_mission'       => $mission,
               'id_type_budget'           => $Idtypebudget_requisit,
               'montant_dotation_mission' => $montant,
               'date_dotation'            => $date
      );
   $old_dotation_trans    = $this->dotation->read("*",array('id_dotation_mission' => $id_dotation_miss));
   $old_tranche           = $this->tranche->read("*",array('id_tranche_budget' => $old_dotation_trans[0]->id_tranche_budget));
   $newMont_tr            = $old_tranche[0]->montant_execute + $old_dotation_trans[0]->montant_dotation_mission;
     if($montant <= $old_tranche[0]->montant_execute + $old_dotation_trans[0]->montant_dotation_mission){
       $reslt = $this->dotation->update($options,array('id_dotation_mission' => $id_dotation_miss),'udate_dotation_mission');
       if($reslt){
         $reslt_tr = $this->tranche->update(array('montant_execute' => $newMont_tr - $montant),
                                                   array('id_tranche_budget'=>$old_tranche[0]->id_tranche_budget),'udate_tranche_budget');
         if($reslt_tr){
           $message = "vos informations ont été modifiées avec succée";
           echo json_encode(array('status' => '1',
                                  'location' => 'url',
                                  'message' => $message));
         }else {
           $message = "Erreur de traitement T";
           echo json_encode(array('status' => '0',
                                  'location' => 'url',
                                  'message' => $message));
         }
       }else {
         $message = "Erreur de traitement D";
         echo json_encode(array('status' => '0',
                                'location' => 'url',
                                'message' => $message));
       }
     }else {
       $message = "Le Montant cumulatif est insuffisant";
       echo json_encode(array('status' => '0',
                              'location' => 'url',
                              'message' => $message));
     }
  }else {
    $errors = validation_errors();
    echo json_encode(array('status' => '0',
                           'location' => 'url',
                           'message' => $errors));
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

/**************** end gestion requisition *******************/


}
?>
