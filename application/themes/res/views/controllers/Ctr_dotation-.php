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

   public function carburant($data = '',$idDotation=''){

   $this->display($data);

              switch($data){

               case 'demand':
 $this->template->set_partial('container', 'dotation/demand_dotation_carburant_view', array('data' => $data));
  $this->template->title('dd','ee')
                    ->build('body');

               break;

              case 'gerer':
 $this->template->set_partial('container', 'gerer_dotation_carburant_view', array('data' => $data));
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





/*============================== GET MISSION BY MATRICULE================*/
 public function getMissionByMatriule($data = ''){

  $idMatricule = $this->input->post('idMatricule');
  //$idMatricule='ee';
 $idmission = $this->dotation->GetMissonsByMPatricue($idMatricule);
if(isset($idmission) && !empty($idmission)){

 $html='';

          $html.='<option value="0">Choisir type mission</option>';

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
/************ Ajouter une dotation carburant********/

public function ajouterDotationCarbs(){


  echo json_encode(array('status' => '1',
                                          'url' => 'etablissement',
                                          'message' => "Veuillez choisir une matricule",
                                          ));


}

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
    if ($this->form_validation->run()) {

      $mission                =  $this->input->post('mission');
      $matricule              =  $this->input->post('matricue');
      $chauffeur              =  $this->input->post('chauffeur');
      $montant                =  $this->input->post('montant');
      $Idtypebudget_Transport =  $this->typeBudget->read("*",array('libelle_type_budget' => 'TRANSPORT '))[0]->id_type_budget;
      $annee_courante         = date("Y");
      //***
      $Annee_courante_all    = $this->annee_budget->read("*",array('libelle_annee'=> $annee_courante));

      if(count($Annee_courante_all) != 0){
        $id_Annee_courante = $Annee_courante_all[0]->id_annee_budget;
      }else{
         $message = "Erreur Aucune Annee";
        echo json_encode(array('status' => '0',
                               'location' => 'url',
                               'message' => $message));
        return;
      }
    //*******
      $typeAnneeBudget_all     = $this->budgetAnneeMontant->read("*",array('id_type_budget'=> $Idtypebudget_Transport,'id_annee_budget' => $id_Annee_courante));

          if(count($typeAnneeBudget_all) != 0){
        $id_typeAnneeBudget = $typeAnneeBudget_all[0]->id_type_budget__Annee_montant;
      }else{
         $message = "Erreur Aucun budget Annuel";
        echo json_encode(array('status' => '0',
                               'location' => 'url',
                               'message' => $message));
        return;
      }

     //*****

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
                 'id_type_budget'           => $Idtypebudget_Transport,
                 'montant_dotation_mission' => $montant,
                 'id_tranche_budget'        => $id_last_tranche
        );
        $reslt = $this->dotation->create($options,'cdate_dotation_mission');
        if($reslt){
          $rslt_trnch = $this->tranche->update(array('montant_execute' => $last_tranche->montant_execute - $montant),array('id_tranche_budget' => $id_last_tranche ),'udate_tranche_budget');
          if($rslt_trnch){
            $message = "vos informations ont éte enregistrées avec succée";
            echo json_encode(array('status' => '1',
                                   'location' => 'url',
                                   'message' => $message));
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
   if ($this->form_validation->run()) {
     $mission                =  $this->input->post('mission');
     $matricule              =  $this->input->post('matricue');
     $chauffeur              =  $this->input->post('chauffeur');
     $montant                =  $this->input->post('montant');
     $id_dotation_miss       =  $this->input->post('id_dot_miss');
     $Idtypebudget_Transport =  $this->typeBudget->read("*",array('libelle_type_budget' => 'TRANSPORT '))[0]->id_type_budget;

       $options               = array(
                'mission_id_mission'       => $mission,
                'id_type_budget'           => $Idtypebudget_Transport,
                'montant_dotation_mission' => $montant,
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
/*
======================gestion de transport=============
*/


}
?>
