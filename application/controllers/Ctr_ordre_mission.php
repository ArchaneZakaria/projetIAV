<?php defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/Master.php';

class Ctr_ordre_mission extends Master
{
 private $CI;
  function __construct() {
        parent::__construct();


      $this->load->model('Iav_personel_model', 'personnel');
      $this->load->model('Iav_mission_model', 'mission');
      $this->load->model('Iav_chauffeur_model');
      $this->load->model('Iav_vehicule_model');
      $this->load->model('Iav_departement_model','departement');
      $this->load->library('form_validation','fr');
      $this->CI = &get_instance();
  }


  public function index($data = '')
  {

 $this->display($data);
    /* $this->set_breadcrumb(array("" => ''));*/
  $this->template->set_partial('container', 'ordre_mission_encours_view', array('data' => $data));
  $this->template->title('Ordre de mission','IAV')
                    ->build('body');
  }

public function mission($data = '',$id='',$idEnti='')
  {

     $this->display($data);
  /* $this->set_breadcrumb(array("" => ''));*/
   switch($data){

     case 'add' :
     $administratifs =  $this->personnel->getPersonelMiss('Administratif',$idEnti);
     $ensg           =  $this->personnel->getPersonelMiss('enseignant',$idEnti);
     $ensgTs           =  $this->personnel->getPersonelMissTota();
     $departmt       =  $this->departement->read("*",array('id_departement' => $idEnti));
     //les descendants de departement
     $desn           =  $this->departement->getDsnByDepart($this->CI->session->user['departement'],$temp = array());
     $iDfiliereD     =  $this->departement->getFiliereByDep($this->CI->session->user['id_user']);

     $desn[$this->CI->session->user['departement']] = $this->CI->session->user['departement'];
     $this->template->set_partial('container', 'add_ordre_mission_view', array('data' => $data,'desn'=>$desn,'administratif'=>$administratifs,'ensg'=>$ensg,'departm'=>$departmt,'iDfiliereD' => $iDfiliereD,'ensgTs' => $ensgTs));

      break;
      case 'edit' :
      case 'modifier' :
            $desn           =  $this->departement->getDsnByDepart($this->CI->session->user['departement'],$temp = array());
             $administratifs =  $this->personnel->getPersonelMiss('Administratif',$idEnti);
             $ensgTs           =  $this->personnel->getPersonelMissTota();
             $ensg           =  $this->personnel->getPersonelMiss('enseignant',$idEnti);
            $departmt       =  $this->departement->read("*",array('id_departement' => $idEnti));
            $desn[$this->CI->session->user['departement']] = $this->CI->session->user['departement'];
            if (($id = intval($id)) && !empty($id) && ($mission = $this->mission->read("*",array('id_mission' => $id)))) {

                  $hidden = array('id_mission' => $id);
                 $this->template->set_partial('container', 'add_ordre_mission_view', array('data' => $data,'desn'=>$desn,'mission' => (array) $mission[0],'hidden' => $hidden,'op_btn_value' => 'Modifier','administratif'=>$administratifs,'ensg'=>$ensg,'departm'=>$departmt,'ensgTs' => $ensgTs));
                 }else{
                redirect(base_url('mission/add'));
                 }

            break;
            case 'encours' :
            $this->template->set_partial('container', 'ordre_mission_encours_view', array('data' => $data));

            break;

            case 'valid' :
             $this->template->set_partial('container', 'ordre_mission_valide_view', array('data' => $data));
            break;
            case 'suivi' :
             $this->template->set_partial('container', 'ordre_mission_suivi_view', array('data' => $data));
            break;

            /*case 'edit' :
             $this->template->set_partial('container', 'edit_ordre_mission_view', array('data' => $data));
            break;*/

            default:
            break;


   }


     $this->template->title('Parc-auto','Iav-hassanII')
                    ->build('body');




  }

public function editOrdreM($data = '')
  {

     $this->display($data);
    /* $this->set_breadcrumb(array("" => ''));*/
    $this->template->set_partial('container', 'edit_ordre_mission_view', array('data' => $data));
     $this->template->title('dd','ee')
                    ->build('body');
  }





   // action edite M.moulim
  public function edit($id='',$data = ''){

      $this->display($data);
      $resultVehicules       = $this->Iav_vehicule_model->GetVehiculesMissionsPlanning();
	  //echo '<pre>';print_r($resultVehicules);die;
      $missions              = $this->mission->getMissions($this->mission->GetMissionsByVeichule());
      $chauffeurs            = $this->Iav_chauffeur_model->listeChauffeurs();
      $vehiculesALL          = $this->Iav_vehicule_model->GetVehicules();
      $vcls_all              = $this->Iav_vehicule_model->GetVehicules();


		//echo '<pre>';print_r($resultVehicules);die;

      if(($id = intval($id)) && !empty($id) && ($mission = $this->mission->getMission_encours_valid($id)) ){
      $hidden = array('id_mission' => $id);
      $this->template->set_partial('container', 'ordre_mission/edit_ordre_mission_view',
                  array('data' => $data,'Missions'=> $missions,
                  'chauffeurs' => $chauffeurs,'vehicules'=>$resultVehicules,'hidden' => $hidden,'op_btn_value' => 'Modifier','vehiculesALL'=>$vehiculesALL,'vcls_all' => $vcls_all,
                   'mission'=>(array)$mission));
     $this->template->title('Modifier la Mission','Iav Hassan ||')->build('body');
    }else{
    redirect('ordre_mission/mission/encours');
    }
  }


  //functions Ajax M.moulim , Get les missions  par mois / annne
  public function GetMissions_Aj()
  {
    $this->load->model('Iav_vehicule_model');
    $mois            = $this->input->post('monthIndex');
    $annee           = $this->input->post('year');
    $id_vehicule     = $this->input->post('id_vehicule');
    $resultVehicules = $this->Iav_vehicule_model->GetVehiculesMissionsPlanning($id_vehicule);
    $missions = isset($resultVehicules[$id_vehicule]['missions'] ) ? $resultVehicules[$id_vehicule]['missions'] : array();
     echo  $this->template->load_view('ordre_mission/mission_jour_pris',
                            array('missions'=>$missions,
                            'mois'=>intval($mois)));
    exit;
  }
  // action chercher id vcl ajax
  public function GetVclSearch()
  {
    $id_vcl                = $this->input->post('id_vcl');
    if($id_vcl=="all"){
        $id_vcl = null;
    }
    $vcls_all              = $this->Iav_vehicule_model->GetVehicules();
    $resultVehicules       = $this->Iav_vehicule_model->GetVehiculesMissionsPlanning($id_vcl);
    $missions              = $this->mission->getMissions($this->mission->GetMissionsByVeichule($id_vcl));
    $chaufeurs             = $this->Iav_chauffeur_model->listeChauffeurs();
	//echo '<pre>';print_r($resultVehicules);die;
    echo  $this->template->load_view('ordre_mission/search_vcl_view',
                           array('Missions'=> $missions,'vcls_all'=>$vcls_all,
                           'chauffeurs' => $chaufeurs,'vehicules'=>$resultVehicules,'id_vcl_tst'=>$id_vcl));
  }
  // action chercher id chfr ajax
  // action chercher id chfr ajax
  public function GetchfrSearch()
  {
    $id_chr              = $this->input->post('id_chr');
    if($id_chr=="all"){
        $id_chr = null;
    }
    $chauffeurs            = $this->Iav_chauffeur_model->listeChauffeurs();
    $resultChauffeurs      = $this->mission->GeMissionsPlanning($id_chr);

    echo  $this->template->load_view('ordre_mission/search_chr_view',
                           array('chaufeurs'=> $resultChauffeurs,'chfrs'=>$chauffeurs,'id_chf_tst'=>$id_chr));
  }


  // get les chaufeur pour action recherche chauffeur ajax
  public function GetChauffeurSearch_Aj()
  {

    $mois                = $this->input->post('monthIndex');
    $annee               = $this->input->post('year');
    $id_chr              = $this->input->post('id_chauffeur');
    $resultChauffeurs    = $this->mission->GeMissionsPlanning($id_chr);
    $missions = array();
    if(count($resultChauffeurs) != 0){
      $missions = $resultChauffeurs[$id_chr]['missions'];
    }
    echo  $this->template->load_view('ordre_mission/mission_jour_pris',
                           array('missions'=> $missions,
                                   'mois'=>intval($mois)));
  }
// get les missons par une action ajax pour la date global
  public function GetMissions_Aj_global(){

    $mois                  = $this->input->post('monthIndex');
    $annee                 = $this->input->post('year');
    $vcls_all              = $this->Iav_vehicule_model->GetVehicules();
    $resultVehicules       = $this->Iav_vehicule_model->GetVehiculesMissionsPlanning();
    $missions              = $this->mission->getMissions($this->mission->GetMissionsByVeichule());
    $chaufeurs             = $this->Iav_chauffeur_model->listeChauffeurs();
    echo  $this->template->load_view('ordre_mission/Missons_DateGlobal_view',
                           array('vehicules'=> $resultVehicules,'actualMonth'=>$mois,'vcls_all'=>$vcls_all,'date_monthPk'=>$mois."/".$annee));
  exit;
  }


/***** functions Ajax M.moulim ***/


/*** Demander ordre de mission Impression ***/

public function addImprimer($id ='',$data=''){

 $this->display($data);
    /* $this->set_breadcrumb(array("" => ''));*/
    $this->template->set_partial('container', 'ordre_mission/imprimer_addordre_mission', array('data' => $data,'idmission' => $id));
     $this->template->build('body');


}

public function addImprimernew($id ='',$data=''){

 $this->display($data);
    /* $this->set_breadcrumb(array("" => ''));*/
    $this->template->set_partial('container', 'ordre_mission/imprimer_addordre_mission1', array('data' => $data,'idmission' => $id));

     $this->template->build('body');


}


public function addImprimerchauffeur($id ='',$data=''){

 $this->display($data);
    /* $this->set_breadcrumb(array("" => ''));*/

    if (($id = intval($id)) && !empty($id) && ($mission = $this->mission->read("*",array('id_mission' => $id)))) {

          $hidden = array('id_mission' => $id);

         $this->template->set_partial('container', 'ordre_mission/imprimer_addordre_missionchf', array('data' => $data,'idmission' => $id,'mission' => (array) $mission[0]));

         }else{
        redirect(base_url('mission/add'));
         }


     $this->template->build('body');


}

/*** ordre de mission de chauffeur après la periode  sortie **/
public function addImprimerchauffeurapres($id ='',$data=''){

 $this->display($data);
    /* $this->set_breadcrumb(array("" => ''));*/

    if (($id = intval($id)) && !empty($id) && ($mission = $this->mission->read("*",array('id_mission' => $id)))) {

          $hidden = array('id_mission' => $id);

         $this->template->set_partial('container', 'ordre_mission/imprimer_addordre_missionchfapres', array('data' => $data,'idmission' => $id,'mission' => (array) $mission[0]));

         }else{
        redirect(base_url('mission/add'));
         }


     $this->template->build('body');


}

/**** Impression ecours d'ordre de mission **/
/*imprimer_addordre_mission_encours_view*/
public function EditEncoursImprimer($id ='',$data=''){

 $this->display($data);
    /* $this->set_breadcrumb(array("" => ''));*/
    $this->template->set_partial('container', 'ordre_mission/imprimer_addordre_mission_encours_view', array('data' => $data,'idmission' => $id));
     $this->template->build('body');


}
/*imprimer_addordre_mission_encours_view*/

public function demandeOrdreMiss($data=''){
/*
ObjetMission:ObjetMission,entite:entite,administratifs:administratifs,ens:ens,
          Etud:Etud,Externes:Externes,Itinéraire:Itinéraire,dateDeb:dateDeb,dateRet_text:dateRet_text,kilometrage:kilometrage,imputes:imputes,Nombre_place:Nombre_place,autres_inf:autres_inf*/

        $message="";
        $result="";
         $this->load->library('form_validation');
         $prefix = 'ordreMission';


/*$this->form_validation->set_rules('ObjetMission', 'Objet de mission', 'required|trim',array('required' => 'Champs Objet de mission est obligatoire'));*/
$this->form_validation->set_rules('fresponsable_txt', 'fresponsable_txt', 'required|trim',array('required' => 'Champs  responsable de mission est obligatoire'));
$this->form_validation->set_rules('entite', 'Entite', 'required|trim',array('required' => 'Champs  Entite est obligatoire'));
$this->form_validation->set_rules('ens[]', 'Enseignant', 'trim',array('required' => 'Champs Enseignant est obligatoire'));

$this->form_validation->set_rules('Etud[]', 'Etudiant', 'trim',array('required' => 'Champs Etudiant est obligatoire'));

//$this->form_validation->set_rules('Externes', 'Externes', 'required|trim',array('required' => 'Champs Externes est obligatoire'));

$this->form_validation->set_rules('Itineraire', 'Itineraire', 'required|trim',array('required' => 'Champs Itineraire est obligatoire'));

$this->form_validation->set_rules('dateDeb', 'Date debut de mission', 'required|trim',array('required' => 'Champs Date debut de mission est obligatoire'));

$this->form_validation->set_rules('dateRet_text', 'Date de retour', 'required|trim',array('required' => 'Champs date de retour est obligatoire'));

$this->form_validation->set_rules('kilometrage', 'kilometrage', 'required|trim',array('required' => 'Champs kilometrage est obligatoire'));


$this->form_validation->set_rules('imputes', 'Frais de mission imputés', 'required|trim',array('required' => 'Champs Ville de l\'etablissement est obligatoire'));


$this->form_validation->set_rules('Nombre_place', 'Nombre de pace', 'required|trim',array('required' => 'Champs Nombre de place est obligatoire'));

$this->form_validation->set_rules('typeMission', 'typeMission  est obligatoire', 'callback_validation_check');


$this->form_validation->set_rules('moyenTransport', 'moyen de Transport est obligatoire', 'callback_validation_check');
$this->form_validation->set_rules('responsable_txt', 'responsable de mission est obligatoire', 'callback_validation_check');

        $errors = false;
      if ($this->form_validation->run()) {

$ObjetMission=  $this->input->post('ObjetMission');
$entite=  $this->input->post('entite');
$administratifs=  $this->input->post('administratifs');
$ens=  $this->input->post('ens');
$autrEens=  $this->input->post('autreens_txt');
$Etud=  $this->input->post('etud');
$externes=  $this->input->post('Externes');
$Itinéraire=  $this->input->post('Itineraire');
$dateDeb=  $this->input->post('dateDeb');
$dateRet_text=  $this->input->post('dateRet_text');
$typeMission=  $this->input->post('typeMission');
// $timeRet_text=  $this->input->post('timeRet_text');
// $timeDeb_text=  $this->input->post('timeDeb_text');
$kilometrage=  $this->input->post('kilometrage');
$imputes=  $this->input->post('imputes');
$Nombre_place=  $this->input->post('Nombre_place');
$autres_inf=  $this->input->post('autres_inf');
$id_moyenTransport =  $this->input->post('moyenTransport');
$projets_txt =  $this->input->post('projets_txt');
$responsable_txt =  $this->input->post('responsable_txt');
$fresponsable_txt =  $this->input->post('fresponsable_txt');

/** time debut **/
// $varrdebutTime = explode(':',$timeDeb_text);
// $heuredebut =  $varrdebutTime['0'];
// $minuteDebut = $varrdebutTime['1'];
/** time debut **/

/** time retour **/
// $varrRetTime = explode(':',$timeRet_text);
// $heureRet =  $varrRetTime['0'];
// $minuteRet = $varrRetTime['1'];
/** time retour **/

/** date debut **/
// $varr = explode('/',$dateDeb);
// $jours = $varr['0'];
// $mois = $varr['1'];
// $annee = $varr['2'];
// $debut=mktime($heuredebut, $minuteDebut, 0, $mois, $jours, $annee);
/** date debut **/

/*** date fin ****/
// $varrRet = explode('/',$dateRet_text);
// $jours = $varr['0'];
// $mois = $varr['1'];
// $annee = $varr['2'];
// $retour=mktime($heureRet,$minuteRet, 0, $mois, $jours, $annee);
/*** Date fin **/

/*** administratifs **/
$administratifss ="";
    if(gettype($administratifs) == 'array'){
    $administratifss = implode(",", $administratifs);
    }elseif(gettype($administratifs) == 'string'){
    $administratifss=$administratifs;
}
/**** administratifs **/

/*** Enseignant **/
$enseignants ="";
if(gettype($ens) == 'array'){
    $enseignants = implode(",", $ens);
    }elseif(gettype($ens) == 'string'){
    $enseignants=$ens;
}

$responsables =$responsable_txt;
$fresponsables =$fresponsable_txt;
// if(gettype($ens) == 'array'){
//     $responsables = implode(",", $responsable_txt);
//     }elseif(gettype($responsable_txt) == 'string'){
//     $responsables=$responsable_txt;
// }

 if($fresponsables == '0'){
   echo json_encode(array('status' => '22',
                                   'location' => 'url',
                                    'pers' =>$id_mission ,
                                    'erreur' => 'Veuillez selectionner un responsable de mission',

                                   ));
 }

$Autresenseignants ="";
if(gettype($autrEens) == 'array'){
    $Autresenseignants = implode(",", $autrEens);
    }elseif(gettype($autrEens) == 'string'){
    $Autresenseignants=$autrEens;
}

/**** Enseignant **/


/*** Administratifss **/
$administratifss ="";
if(gettype($administratifs) == 'array'){
$administratifss = implode(",", $administratifs);
}elseif(gettype($administratifs) == 'string'){
$administratifss=$administratifs;
}
/**** Administratifss **/

/**** Niveau **/
$Etudiants ="";
if(gettype($Etud) == 'array'){
$Etudiants = implode(",", $Etud);
}elseif(gettype($Etud) == 'string'){
$Etudiants=$Etud;
}

/**** Niveau **/

$option =array(
'date_debut' => $dateDeb,
'date_fin' => $dateRet_text,
'km_mission' =>$kilometrage,
'nb_personne_mission'=>$Nombre_place,
'etat_mission' =>'E' ,
'cby_mission' => $this->CI->session->user['id_user'],
'itineraire_mission' =>$Itinéraire,
'id_mission_imputes' =>$imputes,
'id_vehicule' =>'1',
'id_chauffeur'=>'55',
'id_moyen_transport' => $id_moyenTransport,
/*'id_typemission'=>'1',*/
'libeller_mission'=>$ObjetMission,
'id_typemission'=>$typeMission,
'list_mission_personnel'=>$administratifss,
'list_mission_enseignant'=>$enseignants,
'list_mission_Autresenseignant'=>$Autresenseignants,
'list_mission_etudiant'=>$Etudiants,
'list_mission_externes'=>$externes,
'projet_mission'=>$projets_txt,
'responsable_mission' => $responsables,
'fonction_resp_mission' => $fresponsables,
/*'list_mission_personnel'=>$administratifs,
*/
/*'list_mission_etudiant'=>$Etud,*/

  );
$id_mission = $this->input->post('id_mission');
$id_missions='0';

if(strtotime($dateRet_text) < strtotime($dateDeb) ){
  echo json_encode(array('status' => '0',
                                   'location' => 'url',
                                    'pers' =>$id_mission ,
                                    'message' => 'Date de retour est inférieur de la date de départ',

                                   ));
}else{

if(isset($id_mission) && !empty($id_mission)){
$id_missions =$id_mission;
$this->mission->update($option,$id_mission);

 echo json_encode(array('status' => '1',
                                  'location' => 'url',
                                   'pers' =>$id_mission,

                                  ));

}else{



$idMiss = $this->mission->create($option);
$result = $this->mission->insert_mission_personnel('1510',$idMiss);
//strtotime("$jours/$mois/$annee")
 echo json_encode(array('status' => '1',
                                  'location' => 'url',
                                  'pers' =>$idMiss,
                                  ));

}

// print_r($autrEens);
// die();
               }//date de depart et retour
}else{

   $errors = validation_errors();
        if ($errors !== false)

       echo json_encode(array(
                                  'status' => '0',
                                  'location' => 'url',
                                  'message' => $errors));

}
/*}else{

 echo json_encode(array('status' => '0',
                                  'location' => 'url',
                                  'pers' =>'Erreur de traitement',
                                  ));

    }*/
}

/**** Demander ordre de mission **/


  /**** Ajax **/


// mahfoude 02/05/2028
public function SearchAdminisAndEnsByDepartement()
{
  $idDep = $this->input->post('idDep');
  $administratifs =  $this->personnel->getPersonelMiss('Administratif',$idDep);
  $ensg           =  $this->personnel->getPersonelMiss('enseignant',$idDep);
  $vue_search     = $this->template->load_view('ordre_mission/select_multipl_MH.php',array('administratif'=>$administratifs,'ensg'=>$ensg));
  echo $vue_search;
}
public function enseignant(){

 $idDep = $this->input->post('idDep');
 $arrayPers = $this->personnel->getPersonelMiss('enseignant',$idDep);
   echo json_encode(array('status' => '1',
                                  'location' => 'url',
                                  'message' => 'Traitement effectué avec succés',
                                  'pers' => $arrayPers));
}

public function etudiant(){

   echo json_encode(array('status' => '1',
                                  'location' => 'url',
                                  'message' => 'test'));
}

public function imprimerOrdreMission(){

  echo json_encode(array('status' => '1',
                                  'location' => 'url',
                                  'message' => 'test'));
}

/*public function aj_ajouter_modif(){
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
}*/



/***vehicule ordre de mission khalid**/

  public function vehiculeOrdreMiss(){
$IdVehicule = $this->input->post('IdVehicule');
 echo json_encode(array(
                                  'status' => '1',
                                  'location' => 'url',
                                  'message' => 'test'));
        }

/*** Valider mission encours khalid**/

public function validerOrdreMission_Encours(){

  $this->form_validation->set_rules('dateDebR', 'dateDebR est obligatoire', 'required|trim',
                                 array('required' => 'Le champs date debut est obligatoire'));
	$this->form_validation->set_rules('dateRetR', 'dateRetR est obligatoire', 'required|trim',
		                         array('required' => 'Le champs date fin est obligatoire'));
	$this->form_validation->set_rules('chauffeur', 'chauffeur  est obligatoire', 'callback_validation_check');
	$this->form_validation->set_rules('matricule', 'matricule  est obligatoire', 'callback_validation_check');
   if ($this->form_validation->run()) {
	$dateDebR=  $this->input->post('dateDebR');
$dateRetR=  $this->input->post('dateRetR');

$imputes=  $this->input->post('imputes');
$Idchauffeur=  $this->input->post('chauffeur');
$Idvehicule=  $this->input->post('matricule');

$nbj_avant=  $this->input->post('nbj_avant_txt');
$nbj_avant=strtotime($nbj_avant);
$nbj_avant= date('Y-m-d H:i',$nbj_avant);




$nbj_apres=  $this->input->post('nbj_apres_txt');
$nbj_apres=strtotime($nbj_apres);
$nbj_apres= date('Y-m-d H:i',$nbj_apres);


$nbj_avant2=  $this->input->post('nbj_avant_txt2');
$nbj_avant2=strtotime($nbj_avant2);
$nbj_avant2= date('Y-m-d H:i',$nbj_avant2);




$nbj_apres2=  $this->input->post('nbj_apres_txt2');
$nbj_apres2=strtotime($nbj_apres2);
$nbj_apres2= date('Y-m-d H:i',$nbj_apres2);

//traitement mahfoude.m
$sql = "select max(numero_ordre_mission) as cnt_miss_v from iav_mission where etat_mission = 'V' and deleted_mission = 'N'";
$result = $this->db->query($sql);
$reslt_t = $result->result();

//end traitement mahfoude.m

 $option =array(
 'numero_ordre_mission' => $reslt_t[0]->cnt_miss_v+1,
'date_debut' => $dateDebR,
'date_fin' => $dateRetR,
'etat_mission' =>'V' ,
'id_mission_imputes' =>$imputes,
'id_vehicule' =>$Idvehicule,
'id_chauffeur'=>$Idchauffeur,
'nbjavant_chauffeur' =>$nbj_avant,
'nbjapres_chauffeur' =>$nbj_apres,
'nbjavant_chauffeur2' => $nbj_avant2,
'nbjapres_chauffeur2' => $nbj_apres2,
/*'uby_mission' =>'1',
'udate_mission' =>date('Y-m-d H:i:s'),
'id_mission_imputes' =>$imputes,
'id_vehicule' =>$Idvehicule,
'id_chauffeur'=>$Idchauffeur,*/

);


  /*);*/


  if( strtotime($dateRetR) < strtotime($dateDebR)){
     echo json_encode(array(
                                      'status' => '0',
                                      'location' => 'url',
                                      'message' => 'la Date de retour doit être supérieur de la date de départ',
                                      'pers' => '1'));
   }else{

$IdMission = $this->input->post('id_mission');
$id_missions='0';
if(isset($IdMission) && !empty($IdMission)){
$id_missions =$IdMission;

$result = $this->mission->update($option,$IdMission);
if($result){
	echo json_encode(array(
                                  'status' => '1',
                                  'location' => 'url',
                                  'message' => 'Modification a été effectuée avec succées',
                                  'pers' => $id_missions));
}else{
 echo json_encode(array(
                                  'status' => '0',
                                  'location' => 'url',
                                  'message' => 'Erreur de traitement',
                                  'pers' => '1'));

  }
     }
         }

   }else{
	     $errors = validation_errors();
       echo json_encode(array('status' => '0',
                              'location' => 'url',
                              'message' => $errors));
   }


} /*fin function*/

/*** Valider mission encours khalid**/


/**** Mission ToEncours ****/


public function ValiderToEncours(){
  $id = $this->input->post('id');

   $this->mission->update(array(

   'etat_mission' => 'E',

    ),$id);
   echo json_encode(array(
                                  'status' => '1',
                                  'location' => 'url',
                                  'message' => 'la conversion à la mission en cours a été effectuée avec succées' . $id,
                                  'pers' => '1'));


}

/**** Delete mission ***/
public function deleted_mission(){
  $id = $this->input->post('id');
  $Motif_rejet = $this->input->post('motif_rejet');
   $this->mission->update(array(

   //'deleted_mission' => 'O',
   'motif_mission' => $Motif_rejet,
   'etat_mission' => 'R'

    ),$id);
   echo json_encode(array(
                                  'status' => '1',
                                  'location' => 'url',
                                  'message' => "l'annulation de la mission en cours a été effectuée avec succées" . $id,
                                  'pers' => '1'));


}

/**** Delete mission ***/
public function deleted_mission_suivi(){
  $id = $this->input->post('id');
  //$Motif_rejet = $this->input->post('motif_rejet');
   $this->mission->update(array(

   //'deleted_mission' => 'O',
   //'motif_mission' => $Motif_rejet,
   'deleted_mission' => 'O'

    ),$id);
   echo json_encode(array(
                                  'status' => '1',
                                  'location' => 'url',
                                  'message' => "l'annulation de la mission en cours a été effectuée avec succées",
                                  'pers' => '1'));


}
public function validation_check($str){
if ($str == "0"){
  $this->form_validation->set_message('validation_check', ' Le champs  {field}');
  return FALSE;
}else{
  return TRUE;
 }
}

/**** Delete mission ***/
   /**** Ajax ***/


}
?>
