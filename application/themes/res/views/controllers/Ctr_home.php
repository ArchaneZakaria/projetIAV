<?php defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/Master.php';

class Ctr_home extends Master
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

  function __construct() {
      parent::__construct();
      $this->load->model('Iav_mission_model', 'mission');
      $this->load->model('Iav_type_budget_model', 'typebudget');
      $this->load->model('Iav_type_budget__annee_montant', 'typeannemontant');
      $this->load->model('Iav_annee_budget_model', 'annee');
      $this->load->model('Iav_tranche_budget_model', 'tranche');
      $this->load->model('Iav_departement_model', 'departement');
      $this->load->model('Iav_dotation_mission_model', 'dotation');
      $this->load->model('Iav_mission_model', 'mission');
      $this->load->model('Iav_chauffeur_model', 'chauffeur');
	  $this->load->model('Iav_vehicule_model', 'vehicule');

       date_default_timezone_set('Africa/Casablanca');
  }


  public function uploadFile($data = ''){

    $this->display($data);
    $this->template->title('IAV','Acceuil')->build('upload');

  }

  public function statetest($data = ''){

    $this->display($data);
    $this->template->title('IAV','Acceuil')->build('statetest');
      $this->template->set_partial('container', 'home_view',array());

  }

  public function index($data = ''){
    $this->display($data);

    $last_missions = $this->mission->getLastMissionsPageHome();
	//echo '<pre>';print_r($last_missions);die;

    //carburant start
    $sql_date      = "select * from iav_annee_budget where valide_annee = 'E' and deleted_annee= 'N' ";
    $query         = $this->db->query($sql_date);
    $id_anne_valider  = '';
    $anne_valider_sql  = $query->result();
    if(count($anne_valider_sql) != 0){
      $id_anne_valider = $anne_valider_sql[0]->id_annee_budget;

    }else {
      $sql_date        = "select * from iav_annee_budget where libelle_annee = '".date("Y")."' and deleted_annee= 'N' ";
      $query           = $this->db->query($sql_date);
      $id_anne_valider_t = $query->result();
	  $id_anne_valider = $id_anne_valider_t[0]->id_annee_budget;
    }

    $idcarburant_t              = $this->typebudget->read('*',array('code_budget' => "CARBURANT",'deleted_type_budget' => "N"));
	$idcarburant = $idcarburant_t[0]->id_type_budget;
    $typeAnneMont_carburant_tab= $this->typeannemontant->read("*",array("id_type_budget" => $idcarburant,"id_annee_budget" => $id_anne_valider,'deleted_type_budget__Annee_montantcol'=>'N'));
    if(count($typeAnneMont_carburant_tab) != 0){
      $typeAnneMont_carburant = $typeAnneMont_carburant_tab[0];
      $reste_carburant           = $this->tranche->getResultcompareBudgetAnnulWithSumMontTranche($typeAnneMont_carburant->id_type_budget__Annee_montant);
      $consomation_carburant     = $typeAnneMont_carburant->montant_budget - $reste_carburant;
      $pourcentage_carburant     = ($reste_carburant/$typeAnneMont_carburant->montant_budget)*100;
      $last_tranche_carburant    = $this->tranche->getLastTrancheByIdbudgetAnnee($typeAnneMont_carburant->id_type_budget__Annee_montant);
      if($last_tranche_carburant == null){
        $mont_comul_carburant    = 0;
      }else {
        $mont_comul_carburant_t    = explode(",",$last_tranche_carburant);
		$mont_comul_carburant = $mont_comul_carburant_t[2];
      }
    }else {
      $consomation_carburant = 0;
      $mont_comul_carburant   = 0;
      $pourcentage_carburant  = 0;
    }
    //carburant end
    //reparation start
    $idreparation_t               = $this->typebudget->read('*',array('code_budget' => "REPARATION",'deleted_type_budget' => "N"));
	$idreparation = $idreparation_t[0]->id_type_budget;
    $typeAnneMont_reparation_tab= $this->typeannemontant->read("*",array("id_type_budget" => $idreparation,"id_annee_budget" => $id_anne_valider,'deleted_type_budget__Annee_montantcol'=>'N'));
    if(count($typeAnneMont_reparation_tab) != 0){
      $typeAnneMont_reparation    = $typeAnneMont_reparation_tab[0];
      $reste_reparation           = $this->tranche->getResultcompareBudgetAnnulWithSumMontTranche($typeAnneMont_reparation->id_type_budget__Annee_montant);
      $consomation_reparation     = $typeAnneMont_reparation->montant_budget - $reste_reparation;
      $pourcentage_reparation     = ($reste_reparation/$typeAnneMont_reparation->montant_budget)*100;
      $last_tranche_reparation    = $this->tranche->getLastTrancheByIdbudgetAnnee($typeAnneMont_reparation->id_type_budget__Annee_montant);
      if($last_tranche_reparation == null){
        $mont_comul_reparation    = 0;
      }else {
        $mont_comul_reparation_t    = explode(",",$last_tranche_reparation);
		$mont_comul_reparation = $mont_comul_reparation_t[2];
      }
    }else {
      $consomation_reparation = 0;
      $mont_comul_reparation  = 0;
      $pourcentage_reparation  = 0;
    }
    //reparatin end
    //transport start
    $idtransport_t               = $this->typebudget->read('*',array('code_budget' => "TRANSPORT",'deleted_type_budget' => "N"));
	  $idtransport = $idtransport_t[0]->id_type_budget;
    $typeAnneMont_transport_tab    = $this->typeannemontant->read("*",array("id_type_budget" => $idtransport,"id_annee_budget" => $id_anne_valider,'deleted_type_budget__Annee_montantcol'=>'N'));
     if(count($typeAnneMont_transport_tab) != 0){
       $typeAnneMont_transport    = $typeAnneMont_transport_tab[0];
       $reste_transport           = $this->tranche->getResultcompareBudgetAnnulWithSumMontTranche($typeAnneMont_transport->id_type_budget__Annee_montant);
       $consomation_transport     = $typeAnneMont_transport->montant_budget - $reste_transport;
       $pourcentage_transport     = ($reste_transport/$typeAnneMont_transport->montant_budget)*100;
       $last_tranche_transport    = $this->tranche->getLastTrancheByIdbudgetAnnee($typeAnneMont_transport->id_type_budget__Annee_montant);
       if($last_tranche_transport == null){
         $mont_comul_transport    = 0;
       }else {
         $mont_comul_transport_t    = explode(",",$last_tranche_transport);
		 $mont_comul_transport = $mont_comul_transport_t[2];
       }
     }else {
       $consomation_transport = 0;
       $mont_comul_transport  = 0;
       $pourcentage_transport = 0;
     }

    //transport end
    //requisition start
    $idrequisition_t               = $this->typebudget->read('*',array('code_budget' => "REQUISITION",'deleted_type_budget' => "N"));
	$idrequisition = $idrequisition_t[0]->id_type_budget;
    $typeAnneMont_requisition_tab    = $this->typeannemontant->read("*",array("id_type_budget" => $idrequisition,"id_annee_budget" => $id_anne_valider,'deleted_type_budget__Annee_montantcol'=>'N'));
    if(count($typeAnneMont_requisition_tab) != 0){
      $typeAnneMont_requisition    = $typeAnneMont_requisition_tab[0];
      $reste_requisition           = $this->tranche->getResultcompareBudgetAnnulWithSumMontTranche($typeAnneMont_requisition->id_type_budget__Annee_montant);
      $consomation_requisition     = $typeAnneMont_requisition->montant_budget - $reste_requisition;
      $pourcentage_requisition     = ($reste_requisition/$typeAnneMont_requisition->montant_budget)*100;
      $last_tranche_requisition    = $this->tranche->getLastTrancheByIdbudgetAnnee($typeAnneMont_requisition->id_type_budget__Annee_montant);
      if($last_tranche_requisition == null){
        $mont_comul_requisition    = 0;
      }else {
        $mont_comul_requisition_t    = explode(",",$last_tranche_requisition);
		$mont_comul_requisition    = $mont_comul_requisition_t[2];

      }
    }else {
      $consomation_requisition = 0;
      $mont_comul_requisition  = 0;
      $pourcentage_requisition = 0;
    }

    //requisition end
    $sql_date      = "select libelle_annee from iav_annee_budget where valide_annee = 'E' and deleted_annee= 'N' ";
    $query         = $this->db->query($sql_date);
    $anne_valider  = date('Y');
    $anne_valider_sql  = $query->result();
    if(count($anne_valider_sql) != 0){
      $anne_valider = $anne_valider_sql[0]->libelle_annee;
    }
    //calendrier
		$resultVehicules       = $this->vehicule->GetVehiculesMissionsPlanning();
		$missions              = $this->mission->getMissions($this->mission->GetMissionsByVeichule());
		$chauffeurs            = $this->chauffeur->listeChauffeurs();
		//$vehiculesALL          = $this->vehicule->GetVehicules();
		$vcls_all              = $this->vehicule->GetVehicules();
	//end calendrier

    //zdaecho '<pre>';print_r($resultVehicules);die();
    $this->template->set_partial('container', 'home_view',
     array('data'               => $data,
      'lastMissions'            => $last_missions,
      'consomation_carburant'   => $consomation_carburant,
      'mont_comul_carburant'    => $mont_comul_carburant,
      'pourcentage_carburant'   => intval($pourcentage_carburant),
      'consomation_reparation'  => $consomation_reparation,
      'mont_comul_reparation'   => $mont_comul_reparation,
      'pourcentage_reparation'  => intval($pourcentage_reparation),
      'consomation_transport'   => $consomation_transport,
      'mont_comul_transport'    => $mont_comul_transport,
      'pourcentage_transport'   => intval($pourcentage_transport),
      'consomation_requisition' => $consomation_requisition,
      'mont_comul_requisition'  => $mont_comul_requisition,
      'pourcentage_requisition' => intval($pourcentage_requisition),
  	  'Missions'   => $missions,
  	  'chauffeurs' => $chauffeurs,
  	  'vehicules'  =>$resultVehicules,
      'vcls_all' => $vcls_all
   ));
    $this->template->title('IAV','Acceuil')->build('body');
  }
  public function error(){

   $this->load->view('view_404');
  }

}
