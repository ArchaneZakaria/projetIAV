<?php defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/Master.php';

class Ctr_statistique extends Master
{

  function __construct() {
     parent::__construct();
    $this->load->model('Iav_vehicule_model','vehicule');
    $this->load->model('Iav_dotation_mission_model', 'dotation');
    $this->load->model('Iav_type_budget_model', 'typebudget');
    $this->load->model('Iav_mission_model', 'mission');
    $this->load->model('Iav_chauffeur_model', 'chauffeur');
	$this->load->model('Iav_reparation_model', 'reparation');


      $this->load->model('Iav_type_budget__annee_montant', 'typeannemontant');
      $this->load->model('Iav_annee_budget_model', 'annee');
      $this->load->model('Iav_tranche_budget_model', 'tranche');
      $this->load->model('Iav_departement_model', 'departement');
  }
  public function index($data = ''){
    $this->display($data);
    global $data_vehicules;
    $data_vehicules = array();
    $sql_date      = "select * from iav_annee_budget where valide_annee = 'E' and deleted_annee= 'N' ";
    $query         = $this->db->query($sql_date);
    $anne_valider  = '';
    $anne_valider_sql  = $query->result();
    if(count($anne_valider_sql) != 0){
      $anne_valider = $anne_valider_sql[0]->libelle_annee;
    }else {
    $sql_date        = "select * from iav_annee_budget where libelle_annee = '".date("Y")."' and deleted_annee= 'N' ";
    $query           = $this->db->query($sql_date);
    $anne_valider_t = $query->result();
	$anne_valider = $anne_valider_t[0]->libelle_annee;
    }
    $this->set_breadcrumb(array("Statistique vehicule" => ''));
    $idcarburant_t               = $this->typebudget->read('*',array('libelle_type_budget' => "CARBURANT",'deleted_type_budget' => "N"));
	$idcarburant               = $idcarburant_t[0]->id_type_budget;
    $idreparation_t              = $this->typebudget->read('*',array('libelle_type_budget' => "REPARATION",'deleted_type_budget' => "N"));
	$idreparation = $idreparation_t[0]->id_type_budget;
    //vehicule
    $som             = 0;
    $vehicules       = $this->vehicule->read("*",array('deleted_vehicule' => 'N'));
    foreach ($vehicules as $key => $value) {
    $data_vehicules[$value->id_vehicule]['data'] = $value;
    //kilometrage
    $temp = $this->mission->read("sum(km_mission) as kms",array('id_vehicule'=>$value->id_vehicule,'deleted_mission'=>'N','etat_mission'=>'V'));
    if(count($temp) > 0){
      $data_vehicules[$value->id_vehicule]['km'] = $temp[0]->kms;
    }
     $nbMiss = $this->mission->read("count('*') as nbMiss",array('id_vehicule'=>$value->id_vehicule,'deleted_mission'=>'N','etat_mission'=>'V'));

   if(intval($nbMiss) > 0){
      $data_vehicules[$value->id_vehicule]['nbMiss'] = $nbMiss;
   }else{
 $data_vehicules[$value->id_vehicule]['nbMiss'] = $nbMiss;
   }
      $data_vehicules[$value->id_vehicule]['carburant'] = 0;
      $data_vehicules[$value->id_vehicule]['reparation']= 0;
      $temp_1 = $this->mission->read("*",array('id_vehicule'=>$value->id_vehicule,'deleted_mission'=>'N','etat_mission'=>'V'));
      if(count($temp_1) >0){
        //carburant
        foreach ($temp_1 as $key => $value_1) {
          $temp = $this->dotation->read("sum(montant_dotation_mission) as somm",array('id_type_budget' => $idcarburant ,
          'mission_id_mission' => $value_1->id_mission,'deleted_dotation_mission'=> 'N','YEAR(date_dotation)' => $anne_valider));
          if(count($temp) > 0){
             $som = $temp[0]->somm;
             $data_vehicules[$value->id_vehicule]['carburant'] = $data_vehicules[$value->id_vehicule]['carburant'] + $som;
          }
        }

      }




        //reparation
          $temp = $this->reparation->read("sum(Mt_Total_reparation) as somm",array('iav_vehicule_id_vehicule'=>$value->id_vehicule,'deleted_operation'=>'N'));
          if(count($temp) > 0){
              $data_vehicules[$value->id_vehicule]['reparation'] = $temp[0]->somm;
          }

       $som = 0;
    }
    $this->template->set_partial('container', 'statistique/statistiques_global', array('data' => $data,'data_vehicules'=>$data_vehicules));
    $this->template->title('Statistiques','IAV')->build('body');
    }
    public function chauffeur($data = '')
    {
      $this->display($data);
      $this->set_breadcrumb(array("Statistique chauffeur" => ''));
      //date exerice
      $sql_date      = "select * from iav_annee_budget where valide_annee = 'E' and deleted_annee= 'N' ";
      $query         = $this->db->query($sql_date);
      $id_anne_valider  = '';
      $anne_valider_sql  = $query->result();

      if(count($anne_valider_sql) != 0){

      $anne_valider = $anne_valider_sql[0]->libelle_annee;

      }else {


      $sql_date        = "select * from iav_annee_budget where libelle_annee = '".date("Y")."' and deleted_annee= 'N' ";
      $query           = $this->db->query($sql_date);
        $anne_valider_t = $query->result();
    	$anne_valider = $anne_valider_t[0]->libelle_annee;


      }
      //end date exerice
		$idcarburant_t               = $this->typebudget->read('*',array('libelle_type_budget' => "CARBURANT",'deleted_type_budget' => "N"));
		$idcarburant               = $idcarburant_t[0]->id_type_budget;
		$idreparation_t              = $this->typebudget->read('*',array('libelle_type_budget' => "REPARATION",'deleted_type_budget' => "N"));
		$idreparation = $idreparation_t[0]->id_type_budget;
     //chauffeur
     $data_chuaffeur  = array();
     $som             = 0;
     $chauffeur       = $this->chauffeur->read("*",array('deleted_chauffeur' => 'N'));

     foreach ($chauffeur as $key => $value) {
       $data_chuaffeur[$value->id_chauffeur]['data'] = $value;
       //kilometrage
       $temp = $this->mission->read("sum(km_mission) as kms",array('id_chauffeur'=>$value->id_chauffeur,'deleted_mission'=>'N','etat_mission'=>'V'));
       if($temp[0]->kms != null){
         $data_chuaffeur[$value->id_chauffeur]['km'] = $temp[0]->kms;
       }else {
          $data_chuaffeur[$value->id_chauffeur]['km'] = 0;
       }

       //inistialiser carburant , reparation chauffeur
       $data_chuaffeur[$value->id_chauffeur]['carburant'] = 0;
       $data_chuaffeur[$value->id_chauffeur]['reparation']= 0;


       $temp_1 = $this->mission->read("*",array('id_chauffeur'=>$value->id_chauffeur,'deleted_mission'=>'N','etat_mission'=>'V'));
       if(count($temp_1) >0){
         //carburant
         foreach ($temp_1 as $key => $value_1) {
           $temp = $this->dotation->read("sum(montant_dotation_mission) as somm",array('id_type_budget' => $idcarburant ,
           'mission_id_mission' => $value_1->id_mission,'deleted_dotation_mission'=> 'N','YEAR(date_dotation)' => $anne_valider));
           if(count($temp) > 0){
              $som = $temp[0]->somm;
              $data_chuaffeur[$value->id_chauffeur]['carburant'] = $data_chuaffeur[$value->id_chauffeur]['carburant'] + $som;
           }
         }
	   }
       //reparation

       $temp = $this->reparation->read("sum(Mt_Total_reparation) as somm",array('	iav_chauffeur_id_chauffeur'=>$value->id_chauffeur,'deleted_operation'=>'N'));
          if(count($temp) > 0){
              $data_vehicules[$value->id_chauffeur]['reparation'] = $temp[0]->somm;
          }
		 $som = 0;
     }

      $this->template->set_partial('container', 'statistique/statistiques_chauffeur', array('data' => $data,'data_chuaffeur'=>$data_chuaffeur));
      $this->template->title('Statistiques','IAV')->build('body');
    }
    public function getstatistiquebyvehicule()
    {
      $id_vcl               =$this->input->post('id_vcl');
      $Consommation_carb    = $this->input->post('Consommation_carb');
      $reparat              = $this->input->post('reparat');
      if($reparat == null){
        $reparat = 0;
      }
      if($Consommation_carb == null){
        $Consommation_carb = 0;
      }
      global $data_vehicules;
      $data_vehicules = array();
      $sql_date      = "select * from iav_annee_budget where valide_annee = 'E' and deleted_annee= 'N' ";
      $query         = $this->db->query($sql_date);
      $id_anne_valider  = '';
      $anne_valider_sql  = $query->result();
      if(count($anne_valider_sql) != 0){
        $anne_valider = $anne_valider_sql[0]->libelle_annee;
      }else {
        $sql_date        = "select * from iav_annee_budget where libelle_annee = '".date("Y")."' and deleted_annee= 'N' ";
        $query           = $this->db->query($sql_date);
         $anne_valider_t = $query->result();
    	$anne_valider = $anne_valider_t[0]->libelle_annee;
      }
      $this->set_breadcrumb(array("Statistique vehicule" => ''));
      $idcarburant_t               = $this->typebudget->read('*',array('libelle_type_budget' => "CARBURANT",'deleted_type_budget' => "N"));
	$idcarburant               = $idcarburant_t[0]->id_type_budget;
    $idreparation_t              = $this->typebudget->read('*',array('libelle_type_budget' => "REPARATION",'deleted_type_budget' => "N"));
	$idreparation = $idreparation_t[0]->id_type_budget;
      //vehicule
      $som             = 0;
      if($id_vcl != 0){
          $vehicules       = $this->vehicule->read("*",array('deleted_vehicule' => 'N','id_vehicule'=>$id_vcl));
      }else {
         $vehicules       = $this->vehicule->read("*",array('deleted_vehicule' => 'N'));
      }

      foreach ($vehicules as $key => $value) {

            $data_vehicules[$value->id_vehicule]['data'] = $value;
            //kilometrage
            $temp = $this->mission->read("sum(km_mission) as kms",array('id_vehicule'=>$value->id_vehicule,'deleted_mission'=>'N','etat_mission'=>'V'));
            if(count($temp) > 0){
              $data_vehicules[$value->id_vehicule]['km'] = $temp[0]->kms;
            }

          $data_vehicules[$value->id_vehicule]['carburant'] = 0;
          $data_vehicules[$value->id_vehicule]['reparation']= 0;
          $temp_1 = $this->mission->read("*",array('id_vehicule'=>$value->id_vehicule,'deleted_mission'=>'N','etat_mission'=>'V'));
          if(count($temp_1) >0){

            //carburant
            foreach ($temp_1 as $key => $value_1) {
              $temp = $this->dotation->read("sum(montant_dotation_mission) as somm",array('id_type_budget' => $idcarburant ,
              'mission_id_mission' => $value_1->id_mission,'deleted_dotation_mission'=> 'N','YEAR(date_dotation)' => $anne_valider));
              if(count($temp) > 0){
                 $som = $temp[0]->somm;
                 $data_vehicules[$value->id_vehicule]['carburant'] = $data_vehicules[$value->id_vehicule]['carburant'] + $som;
              }
            }

		  }
		   //reparation
          $temp = $this->reparation->read("sum(Mt_Total_reparation) as somm",array('iav_vehicule_id_vehicule'=>$value->id_vehicule,'deleted_operation'=>'N'));
          if(count($temp) > 0){
              $data_vehicules[$value->id_vehicule]['reparation'] = $temp[0]->somm;
          }

       $som = 0;

	  }
      $tab = $this->template->load_view('statistique/tab_serch_statis_view.php',array('data_vehicules'=> $data_vehicules,'reparat'=>$reparat,'Consommation_carb'=>$Consommation_carb));
      echo $tab;

    }

    public function getstatistiquebychauffeur()
    {

      $id_chf               =$this->input->post('id_chf');
      $Consommation_carb    = $this->input->post('Consommation_carb');
      $reparat              = $this->input->post('reparat');
      if($reparat == null){
        $reparat = 0;
      }
      if($Consommation_carb == null){
        $Consommation_carb = 0;
      }
      $sql_date      = "select * from iav_annee_budget where valide_annee = 'E' and deleted_annee= 'N' ";
      $query         = $this->db->query($sql_date);
      $id_anne_valider  = '';
      $anne_valider_sql  = $query->result();
      if(count($anne_valider_sql) != 0){
        $anne_valider = $anne_valider_sql[0]->libelle_annee;
      }else {
        $sql_date        = "select * from iav_annee_budget where libelle_annee = '".date("Y")."' and deleted_annee= 'N' ";
        $query           = $this->db->query($sql_date);
       $anne_valider_t = $query->result();
    	$anne_valider = $anne_valider_t[0]->libelle_annee;
      }
      $idcarburant_t               = $this->typebudget->read('*',array('libelle_type_budget' => "CARBURANT",'deleted_type_budget' => "N"));
	$idcarburant               = $idcarburant_t[0]->id_type_budget;
    $idreparation_t              = $this->typebudget->read('*',array('libelle_type_budget' => "REPARATION",'deleted_type_budget' => "N"));
	$idreparation = $idreparation_t[0]->id_type_budget;
     //chauffeur
     $data_chuaffeur  = array();
     $som             = 0;
     if($id_chf != 0){
      $chauffeur       = $this->chauffeur->read("*",array('deleted_chauffeur' => 'N','id_chauffeur'=>$id_chf));
     }else {
       $chauffeur       = $this->chauffeur->read("*",array('deleted_chauffeur' => 'N'));
     }

     foreach ($chauffeur as $key => $value) {
       $data_chuaffeur[$value->id_chauffeur]['data'] = $value;
       //kilometrage
       $temp = $this->mission->read("sum(km_mission) as kms",array('id_chauffeur'=>$value->id_chauffeur,'deleted_mission'=>'N','etat_mission'=>'V'));
       if($temp[0]->kms != null){
         $data_chuaffeur[$value->id_chauffeur]['km'] = $temp[0]->kms;
       }else {
          $data_chuaffeur[$value->id_chauffeur]['km'] = 0;
       }


       $data_chuaffeur[$value->id_chauffeur]['carburant'] = 0;
       $data_chuaffeur[$value->id_chauffeur]['reparation']= 0;
       $temp_1 = $this->mission->read("*",array('id_chauffeur'=>$value->id_chauffeur,'deleted_mission'=>'N','etat_mission'=>'V'));
       if(count($temp_1) >0){
         //carburant
         foreach ($temp_1 as $key => $value_1) {
           $temp = $this->dotation->read("sum(montant_dotation_mission) as somm",array('id_type_budget' => $idcarburant ,
           'mission_id_mission' => $value_1->id_mission,'deleted_dotation_mission'=> 'N','YEAR(date_dotation)' => $anne_valider));
           if(count($temp) > 0){
              $som = $temp[0]->somm;
              $data_chuaffeur[$value->id_chauffeur]['carburant'] = $data_chuaffeur[$value->id_chauffeur]['carburant'] + $som;
           }
         }
	   }

       //reparation
        $temp = $this->reparation->read("sum(Mt_Total_reparation) as somm",array('	iav_chauffeur_id_chauffeur'=>$value->id_chauffeur,'deleted_operation'=>'N'));
          if(count($temp) > 0){
              $data_vehicules[$value->id_chauffeur]['reparation'] = $temp[0]->somm;
          }
           $som = 0;


     }
     $tab = $this->template->load_view('statistique/tab_serch_statis_chf_view.php',array('data_chuaffeur'=> $data_chuaffeur,'reparat'=>$reparat,'Consommation_carb'=>$Consommation_carb));
     echo $tab;
    }



    public function statistiquePer($data = ''){

      $this->display($data);
        $this->set_breadcrumb(array("Statistique Globale des personnels" => ''));
        $this->template->set_partial('container', 'statistique/statistiquepro','');
      $this->template->title('IAV','Statistique')->build('body');

      }




	public function statistiqueGlobale($data = ''){
		$this->display($data);
		$this->set_breadcrumb(array("Statistique Globale Par Exercice" => ''));
		$sql_date      = "select libelle_annee from iav_annee_budget where valide_annee = 'E' and deleted_annee= 'N' ";
		$query         = $this->db->query($sql_date);
		$anne_valider  = date('Y');
		$anne_valider_sql  = $query->result();
		if(count($anne_valider_sql) != 0){
		$anne_valider = $anne_valider_sql[0]->libelle_annee;
		}
		//consomation carburant par departement

    $departement_parent = $this->departement->read("*",array('id_parent' => "0",'deleted_departement' => 'N'));
    $tab_consom_carb_Departements = array();
	$idcarburant_t              = $this->typebudget->read('*',array('code_budget' => "CARBURANT",'deleted_type_budget' => "N"));
	$idcarburant = $idcarburant_t[0]->id_type_budget;
    foreach ($departement_parent as $key => $value) {
      $temp = $this->dotation->read("sum(montant_dotation_mission) as count_carbDepart",array('id_type_budget' => $idcarburant ,
      'cby_dotation_mission' => $value->id_responsable_departement,'deleted_dotation_mission'=> 'N','YEAR(date_dotation)' => $anne_valider));
      $tab_consom_carb_Departements[$value->code_departement] = $temp[0]->count_carbDepart;
    }
    $respo_dcpd_t     = $this->departement->read("*",array('code_departement' => 'DCPD' ));
	$respo_dcpd       = $respo_dcpd_t[0]->id_responsable_departement;
    $temp_dcpd_carb   =  $this->dotation->read("sum(montant_dotation_mission) as count_carbDcpd",array('id_type_budget' => $idcarburant ,'cby_dotation_mission' => $respo_dcpd,'deleted_dotation_mission'=> 'N','YEAR(date_dotation)' => $anne_valider));
    $tab_consom_carb_Departements['DCPD'] = $temp_dcpd_carb[0]->count_carbDcpd;

    $respo_SG_t       = $this->departement->read("*",array('code_departement' => 'SG' ));
	$respo_SG         = $respo_SG_t[0]->id_responsable_departement;
    $temp_SG_carb     =  $this->dotation->read("sum(montant_dotation_mission) as count_carbSG",array('id_type_budget' => $idcarburant ,'cby_dotation_mission' => $respo_SG ,'deleted_dotation_mission'=> 'N','YEAR(date_dotation)' => $anne_valider));
    $tab_consom_carb_Departements['SG'] = $temp_SG_carb[0]->count_carbSG;

    $respo_DEAA_t       =  $this->departement->read("*",array('code_departement' => 'DEAA' ));
	$respo_DEAA         = $respo_DEAA_t[0]->id_responsable_departement;
    $temp_DEAA_carb     =  $this->dotation->read("sum(montant_dotation_mission) as count_carbDEAA",array('id_type_budget' => $idcarburant ,'cby_dotation_mission' => $respo_DEAA ,'deleted_dotation_mission'=> 'N','YEAR(date_dotation)' => $anne_valider));
    $tab_consom_carb_Departements['DEAA'] = $temp_DEAA_carb[0]->count_carbDEAA;

    //end consomation carburant par departement
    //nbr ordre mission par departement
    $tab_nbr_ordre_mission_Departements = array();
    foreach ($departement_parent as $key => $value) {
      $temp = $this->mission->read("count(*) as count_ordreMDepart",array('cby_mission' => $value->id_responsable_departement,'deleted_mission' => 'N','YEAR(cdate_mission)' => $anne_valider));
      $tab_nbr_ordre_mission_Departements[$value->code_departement] = $temp[0]->count_ordreMDepart;
    }

    $temp = $this->mission->read("count(*) as count_ordreMDepart",array('cby_mission' => $respo_dcpd,'deleted_mission' => 'N','YEAR(cdate_mission)' => $anne_valider));
    $tab_nbr_ordre_mission_Departements['DCPD'] = $temp[0]->count_ordreMDepart;

    $temp = $this->mission->read("count(*) as count_ordreMDepart",array('cby_mission' => $respo_SG ,'deleted_mission' => 'N','YEAR(cdate_mission)' => $anne_valider));
    $tab_nbr_ordre_mission_Departements['SG'] = $temp[0]->count_ordreMDepart;

    $temp = $this->mission->read("count(*) as count_ordreMDepart",array('cby_mission' => $respo_DEAA,'deleted_mission' => 'N','YEAR(cdate_mission)' => $anne_valider));
    $tab_nbr_ordre_mission_Departements['DEAA'] = $temp[0]->count_ordreMDepart;
    // end nbr ordre mission  par departement
    //km  par departement
    $tab_km_Departements = array();
    foreach ($departement_parent as $key => $value) {
      $temp = $this->mission->read("SUM(km_mission) as kmDepart",array('cby_mission' => $value->id_responsable_departement,'deleted_mission' => 'N','YEAR(cdate_mission)' => $anne_valider));
      $tab_km_Departements[$value->code_departement] = $temp[0]->kmDepart;
    }
    $temp = $this->mission->read("SUM(km_mission) as kmDepart",array('cby_mission' => $respo_dcpd,'deleted_mission' => 'N','YEAR(cdate_mission)' => $anne_valider));
    $tab_km_Departements['DCPD'] = $temp[0]->kmDepart;

    $temp = $this->mission->read("SUM(km_mission) as kmDepart",array('cby_mission' => $respo_SG,'deleted_mission' => 'N','YEAR(cdate_mission)' => $anne_valider));
    $tab_km_Departements['SG'] = $temp[0]->kmDepart;

    $temp = $this->mission->read("SUM(km_mission) as kmDepart",array('cby_mission' => $respo_DEAA,'deleted_mission' => 'N','YEAR(cdate_mission)' => $anne_valider));
    $tab_km_Departements['DEAA'] = $temp[0]->kmDepart;
    //end km par departement
    //km  par chauffeur
    $chauffeur        = $this->chauffeur->read("*",array('deleted_chauffeur'=> 'N'));
    $tab_km_chauffeur = array();
    foreach ($chauffeur as $key => $value) {
      $temp = $this->mission->read("SUM(km_mission) as kmchf",array('id_chauffeur' => $value->id_chauffeur,'deleted_mission' => 'N','YEAR(cdate_mission)' => $anne_valider));
      $tab_km_chauffeur[$value->nom_chauffeur." "."$value->prenom_chauffeur"] = $temp[0]->kmchf;
    }
    //end km par chauffeur

	//echo '<pre>';print_r($tab_consom_carb_Departements);die;
	$this->template->set_partial('container', 'statistique/statistiqueGlb',array(
	  'tab_consom_carb_Departements'        => $tab_consom_carb_Departements,
      'tab_nbr_ordre_mission_Departements'  => $tab_nbr_ordre_mission_Departements,
      'tab_km_Departements'                 =>  $tab_km_Departements,
      'tab_km_chauffeur'                    =>  $tab_km_chauffeur
	));
      $this->template->title('IAV','Statistique')->build('body');
	}



}
?>
