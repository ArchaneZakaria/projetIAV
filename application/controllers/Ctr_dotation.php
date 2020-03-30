<?php defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/Master.php';

class Ctr_dotation extends Master
{
  private $CI;
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
      $this->load->library('session');
      $this->CI = &get_instance();
  }
  public function index($data = ''){
     $this->display($data);
     $this->template->set_partial('container', 'dotation_view', array('data' => $data));
     $this->template->title('dd','ee')->build('body');
  }

  /*
  ====================== start (mahfoud moulim) gestion de carburat=============
  */
  public function carburant($data = '',$id = null){
     $this->display($data);
     $Idtypebudget_carburant_t =  $this->typeBudget->read("*",array('code_budget' => 'CARBURANT ','deleted_type_budget' => "N"));
	 $Idtypebudget_carburant = $Idtypebudget_carburant_t[0]->id_type_budget;
     switch($data){
     case 'demande':
     $this->set_breadcrumb(array("Demande dotation carburant" => ''));
     $this->template->set_partial('container', 'dotation/carburant/demand_dotation_carburant_view', array('data' => $data));
     break;
     case 'gestion':
     $this->set_breadcrumb(array("Gestion dotation carburant" => ''));
     $model = $this->template->load_view('../views/modals/admin/op_modall');
     $dotations_Transport = $this->dotation->getdotationsTransport(null,$Idtypebudget_carburant);
     $this->template->set_partial('container', 'dotation/carburant/gerer_dotation_carburant_view',
                                   array('data' => $data,'prefix'=>'dotationTransport','dotations_Transport' => $dotations_Transport,'model'=>$model));
     break;
     case 'modifier':
       $this->set_breadcrumb(array("Modifier dotation carburant" => ''));
       $dotation_trn_mdf = $this->dotation->getdotationsTransport($id,$Idtypebudget_carburant);
       $this->template->set_partial('container', 'dotation/carburant/edit_dotation_carburant_view', array('data' => $data,'dotation_trn_mdf'=>$dotation_trn_mdf));
     break ;
     case 'dotation_carburant_impr':
     $this->set_breadcrumb(array("Gestion dotation carburant" => 'dotation/carburant/gestion'));
     $dotation = $this->dotation->getdotationsTransport($id,$Idtypebudget_carburant);
     $this->template->set_partial('container', 'dotation/carburant/dotation_carburant_impr', array('data' => $data,'dotation' => $dotation));
     break;

     }
     $this->template->title('Iav','Transport')->build('body');
    }

    public function ajouterDotationCarburant(){
      $this->form_validation->set_rules('mission', 'mission est obligatoire', 'callback_validation_check');
      $this->form_validation->set_rules('chauffeur', 'chauffeur  est obligatoire', 'callback_validation_check');
      $this->form_validation->set_rules('matricule', 'matricule  est obligatoire', 'callback_validation_check');
      $this->form_validation->set_rules('montant', 'montant est obligatoire', 'required|trim',
                                   array('required' => 'Le champs Montant vignette  est obligatoire'));
     $this->form_validation->set_rules('date', 'date est obligatoire', 'required|trim',
                                  array('required' => 'Le Champs date dotation est obligatoire'));
                                  $this->form_validation->set_rules('kilometrage', 'date est obligatoire', 'required|trim',
                                                               array('required' => 'Le Champs date dotation est obligatoire'));
     if ($this->form_validation->run()) {

       $mission                =  $this->input->post('mission');
       $matricule              =  $this->input->post('matricule');
       $chauffeur              =  $this->input->post('chauffeur');
       $montant                =  $this->input->post('montant');
       $date                   =  $this->input->post('date');
      $kilometrage             =  $this->input->post('kilometrage');
       $Idtypebudget_Transport_t =  $this->typeBudget->read("*",array('libelle_type_budget' => 'CARBURANT '));
	   $Idtypebudget_Transport = $Idtypebudget_Transport_t[0]->id_type_budget;
       $annee_courante         = date("Y");
       $id_Annee_courante_t      = $this->annee_budget->read("*",array('libelle_annee'=> $annee_courante));
	   $id_Annee_courante  = $id_Annee_courante_t[0]->id_annee_budget;
       $t_typeAnneeBudget      = $this->budgetAnneeMontant->read("*",array('id_type_budget'=> $Idtypebudget_Transport,'id_annee_budget' => $id_Annee_courante,
        'deleted_type_budget__Annee_montantcol' => 'N'));
        if(count($t_typeAnneeBudget) == 0){
          $message = "Erreur Aucun  budget Annuel du type carburant";
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
       $last_tranche_t         = array_slice($tranches,count($tranches)-1);
	   $last_tranche = $last_tranche_t[0];
       $id_last_tranche       = $last_tranche->id_tranche_budget;
       if($last_tranche->montant_execute >= $montant){
         $options               = array(
                  'mission_id_mission'       => $mission,
                  'id_type_budget'           => $Idtypebudget_Transport,
                  'montant_dotation_mission' => $montant,
                  'id_tranche_budget'        => $id_last_tranche,
                  'date_dotation'            => $date,
                  'cby_dotation_mission'     => $this->CI->session->user['id_user'],
                  'km_vehicule'              => $kilometrage
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
    public function modifierDotationCarburant()
    {
      $this->form_validation->set_rules('montant', 'montant est obligatoire', 'required|trim',
                                   array('required' => 'Le champs Montant vignette  est obligatoire'));
       $this->form_validation->set_rules('date', 'date est obligatoire', 'required|trim',
                                    array('required' => 'Le champs date dotation est obligatoire'));
        $this->form_validation->set_rules('kilometrage', 'kilometrage est obligatoire', 'required|trim',
                                                                 array('required' => 'Le champs kilometrage vehicule est obligatoire'));
    if ($this->form_validation->run()) {
      $mission                =  $this->input->post('mission');
      $matricule              =  $this->input->post('matricue');
      $chauffeur              =  $this->input->post('chauffeur');
      $montant                =  $this->input->post('montant');
      $date                   =  $this->input->post('date');
      $id_dotation_miss       =  $this->input->post('id_dot_miss');
      $kilometrage            =  $this->input->post('kilometrage');


      $Idtypebudget_Transport_t =  $this->typeBudget->read("*",array('libelle_type_budget' => 'CARBURANT'));
	  $Idtypebudget_Transport = $Idtypebudget_Transport_t[0]->id_type_budget;

        $options               = array(
                 'mission_id_mission'       => $mission,
                 'id_type_budget'           => $Idtypebudget_Transport,
                 'montant_dotation_mission' => $montant,
                 'date_dotation'            => $date,
                 'uby_dotation_mission'     => $this->CI->session->user['id_user'],
                 'km_vehicule'              => $kilometrage
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
             echo json_encode(array('status'   => '1',
                                    'location' => 'url',
                                    'message'  => $message));
           }else {
             $message = "Erreur de traitement T";
             echo json_encode(array('status'   => '0',
                                    'location' => 'url',
                                    'message'  => $message));
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
  ====================== end (mahfoud moulim) gestion de carburant =============
  */

/*
====================== (mahfoud moulim) gestion de transport=============
*/
 public function transport($data = '',$id = null){
    $this->display($data);
    $Idtypebudget_Transport_t =  $this->typeBudget->read("*",array('code_budget' => 'TRANSPORT','deleted_type_budget' => 'N'));
	 $Idtypebudget_Transport = $Idtypebudget_Transport_t[0]->id_type_budget;
    switch($data){
    case 'demande':
    $this->set_breadcrumb(array("Demande dotation VTT" => ''));
    $this->template->set_partial('container', 'dotation/transport/demand_dotation_transport_view', array('data' => $data));
    break;
    case 'gestion':
    $this->set_breadcrumb(array("Gestion dotation VTT" => ''));
    $model = $this->template->load_view('../views/modals/admin/op_modall');
    $dotations_Transport = $this->dotation->getdotationsTransport(null,$Idtypebudget_Transport);
    $this->template->set_partial('container', 'dotation/transport/gerer_dotation_transport_view',
                                  array('data' => $data,'prefix'=>'dotationTransport','dotations_Transport' => $dotations_Transport,'model'=>$model));
    break;
    case 'modifier':
    $this->set_breadcrumb(array("Modifier dotation VTT" => ''));
    $dotation_trn_mdf = $this->dotation->getdotationsTransport($id,$Idtypebudget_Transport);
    $this->template->set_partial('container', 'dotation/transport/edit_dotation_transport_view', array('data' => $data,'dotation_trn_mdf'=>$dotation_trn_mdf));
    break ;

    case 'dotation_transpo_impr':
    $this->set_breadcrumb(array("Gestion dotation VTT" => 'dotation/transport/gestion'));
    $dotation = $this->dotation->getdotationsTransport($id,$Idtypebudget_Transport);
    $this->template->set_partial('container', 'dotation/transport/dotation_transpo_impr', array('data' => $data,'dotation' => $dotation));
    break ;
    }
    $this->template->title('Iav','VTT')->build('body');
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
      $Idtypebudget_Transport_t =  $this->typeBudget->read("*",array('code_budget' => 'TRANSPORT','deleted_type_budget' => 'N'));
	  $Idtypebudget_Transport = $Idtypebudget_Transport_t[0]->id_type_budget;
      $annee_courante         = date("Y");
      $id_Annee_courante_t      = $this->annee_budget->read("*",array('libelle_annee'=> $annee_courante));
	  $id_Annee_courante = $id_Annee_courante_t[0]->id_annee_budget;
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
      $last_tranche_t          = array_slice($tranches,count($tranches)-1);
	  $last_tranche  = $last_tranche_t[0];
      $id_last_tranche       = $last_tranche->id_tranche_budget;
      if($last_tranche->montant_execute >= $montant){
        $options               = array(
                 'mission_id_mission'       => $mission,
                 'id_type_budget'           => $Idtypebudget_Transport,
                 'montant_dotation_mission' => $montant,
                 'id_tranche_budget'        => $id_last_tranche,
                 'date_dotation'            => $date,
                 'cby_dotation_mission'     => $this->CI->session->user['id_user']
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
   public function getOrdreMission(){
     $id                    =  $this->input->post('id');
     $missionid_t             =  $this->dotation->read("mission_id_mission",array('id_dotation_mission'=>$id));
	 $missionid             = $missionid_t[0]->mission_id_mission;
     $vue                   = $this->template->load_view('ordre_mission/imprimer_addordre_mission_encours_view',array('idmission' => $missionid));
     echo $vue;
   }
   public function delete_dotation(){
        $id_dotation    =  $this->input->post('id');
        $reslt          = $this->dotation->update(array('deleted_dotation_mission' =>'O'),array('id_dotation_mission'=>$id_dotation),'ddate_dotation_mission');
        if($reslt){
          $dotation_t      = $this->dotation->read("*",array('id_dotation_mission' => $id_dotation));
		  $dotation = $dotation_t[0];
          $getidtranche  =  $dotation->id_tranche_budget;
          $mont_ex_old_tranche_t  = $this->tranche->read("*",array('id_tranche_budget' => $getidtranche));
		  $mont_ex_old_tranche = $mont_ex_old_tranche_t[0]->montant_execute;
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

   public function modifierDotationTransport(){
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
     $Idtypebudget_Transport_t =  $this->typeBudget->read("*",array('code_budget' => 'TRANSPORT '));
      $Idtypebudget_Transport = $Idtypebudget_Transport_t[0]->id_type_budget;
       $options               = array(
                'mission_id_mission'       => $mission,
                'id_type_budget'           => $Idtypebudget_Transport,
                'montant_dotation_mission' => $montant,
                'date_dotation'            => $date,
                'uby_dotation_mission'     => $this->CI->session->user['id_user']
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

/******************************** start (mahfoud moulim) gestion requisition ****/
public function requisition($data = '',$id = null){
   $this->display($data);
   $Idtypebudget_requisit_t =  $this->typeBudget->read("*",array('libelle_type_budget' => 'REQUISITION '));
   $Idtypebudget_requisit = $Idtypebudget_requisit_t[0]->id_type_budget;
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
     $Idtypebudget_requisit_t  =  $this->typeBudget->read("*",array('libelle_type_budget' => 'REQUISITION '));
	 $Idtypebudget_requisit = $Idtypebudget_requisit_t[0]->id_type_budget;
     $annee_courante         = date("Y");
     $id_Annee_courante_t      = $this->annee_budget->read("*",array('libelle_annee'=> $annee_courante));
	 $id_Annee_courante = $id_Annee_courante_t[0]->id_annee_budget;

     $id_typeAnneeBudget_t     = $this->budgetAnneeMontant->read("*",array('id_type_budget'=> $Idtypebudget_requisit,'id_annee_budget' => $id_Annee_courante,'deleted_type_budget__Annee_montantcol'=>'N'));
	 if(count($id_typeAnneeBudget_t) == 0)
	 {
		  echo json_encode(array('status' => '0',
                              'location' => 'url',
                              'message' => "Aucun budget Annuel"));
							  return;
	 }
	 $id_typeAnneeBudget = $id_typeAnneeBudget_t[0]->id_type_budget__Annee_montant;
     $tranches               = $this->tranche->read("*",array('id_type_budget_Annee_montant' => $id_typeAnneeBudget,'deleted_tranche_budget' =>'N' ));
     if(count($tranches) == 0){
       $message = "Erreur  Aucune tranche existe pour le budget Annuel";
       echo json_encode(array('status' => '0',
                              'location' => 'url',
                              'message' => $message));
      return;
     }
     $last_tranche_t          = array_slice($tranches,count($tranches)-1);
	 $last_tranche          = $last_tranche_t[0];
     $id_last_tranche       = $last_tranche->id_tranche_budget;
     if($last_tranche->montant_execute >= $montant){
       $options               = array(
                'mission_id_mission'       => $mission,
                'id_type_budget'           => $Idtypebudget_requisit,
                'montant_dotation_mission' => $montant,
                'id_tranche_budget'        => $id_last_tranche,
                'date_dotation'            => $date,
                'cby_dotation_mission'     => $this->CI->session->user['id_user']
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

  public function modifierDotationrequsition(){
    $this->form_validation->set_rules('montant', 'montant est obligatoire', 'required|trim',
                                 array('required' => 'Le champs Montant vignette  est obligatoire'));
   $this->form_validation->set_rules('date', 'date est obligatoire', 'required|trim',
                                array('required' => 'Le champs date dotation  est obligatoire'));
  if ($this->form_validation->run()) {
    $mission                =  $this->input->post('mission');
    $montant                =  $this->input->post('montant');
    $date                   =  $this->input->post('date');
    $id_dotation_miss       =  $this->input->post('id_dot_miss');
    $Idtypebudget_requisit_t =  $this->typeBudget->read("*",array('code_budget' => 'REQUISITION '));
	$Idtypebudget_requisit = $Idtypebudget_requisit_t[0]->id_type_budget;

      $options               = array(
               'mission_id_mission'       => $mission,
               'id_type_budget'           => $Idtypebudget_requisit,
               'montant_dotation_mission' => $montant,
               'date_dotation'            => $date,
                'uby_dotation_mission'     => $this->CI->session->user['id_user']
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

/**************** end gestion requisition (moulim mahfoude) *******************/

/** Avion**/
 
    public function ajouterDotationAvion(){
       $this->form_validation->set_rules('mission', 'mission est obligatoire', 'callback_validation_check');
       $this->form_validation->set_rules('montant', 'montant est obligatoire', 'required|trim',
                                    array('required' => 'Le champs Montant vignette  est obligatoire'));
        $this->form_validation->set_rules('date', 'date est obligatoire', 'required|trim',
                                     array('required' => 'Le champs date dotation  est obligatoire'));
      if ($this->form_validation->run()) {

        $mission                =  $this->input->post('mission');
        $montant                =  $this->input->post('montant');
        $date                   =  $this->input->post('date');
        $Idtypebudget_requisit_t  =  $this->typeBudget->read("*",array('libelle_type_budget' => 'BILLET_AVION'));
     $Idtypebudget_requisit = $Idtypebudget_requisit_t[0]->id_type_budget;
        $annee_courante         = date("Y");
        $id_Annee_courante_t      = $this->annee_budget->read("*",array('libelle_annee'=> $annee_courante));
     $id_Annee_courante = $id_Annee_courante_t[0]->id_annee_budget;

        $id_typeAnneeBudget_t     = $this->budgetAnneeMontant->read("*",array('id_type_budget'=> $Idtypebudget_requisit,'id_annee_budget' => $id_Annee_courante,'deleted_type_budget__Annee_montantcol'=>'N'));
     if(count($id_typeAnneeBudget_t) == 0)
     {
        echo json_encode(array('status' => '0',
                                 'location' => 'url',
                                 'message' => "Aucun budget Annuel"));
                  return;
     }
     $id_typeAnneeBudget = $id_typeAnneeBudget_t[0]->id_type_budget__Annee_montant;
        $tranches               = $this->tranche->read("*",array('id_type_budget_Annee_montant' => $id_typeAnneeBudget,'deleted_tranche_budget' =>'N' ));
        if(count($tranches) == 0){
          $message = "Erreur  Aucune tranche existe pour le budget Annuel";
          echo json_encode(array('status' => '0',
                                 'location' => 'url',
                                 'message' => $message));
         return;
        }
        $last_tranche_t          = array_slice($tranches,count($tranches)-1);
     $last_tranche          = $last_tranche_t[0];
        $id_last_tranche       = $last_tranche->id_tranche_budget;
        if($last_tranche->montant_execute >= $montant){
          $options               = array(
                   'mission_id_mission'       => $mission,
                   'id_type_budget'           => $Idtypebudget_requisit,
                   'montant_dotation_mission' => $montant,
                   'id_tranche_budget'        => $id_last_tranche,
                   'date_dotation'            => $date,
                   'cby_dotation_mission'     => $this->CI->session->user['id_user']
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

     public function avion($data = '',$id = null){
        $this->display($data);
        $Idtypebudget_requisit_t =  $this->typeBudget->read("*",array('libelle_type_budget' => 'BILLET_AVION'));
        $Idtypebudget_requisit = $Idtypebudget_requisit_t[0]->id_type_budget;
        switch($data){
        case 'demande':
        $this->set_breadcrumb(array("Demande dotation Avion" => ''));
        $this->template->set_partial('container', 'dotation/avion/demand_dotation_avion_view', array('data' => $data));
        break;
        case 'gestion':
        $this->set_breadcrumb(array("Gestion dotation avion" => ''));
        $model = $this->template->load_view('../views/modals/admin/op_modall');
        $dotations_Requsisiton = $this->dotation->getdotationsTransport(null,$Idtypebudget_requisit);
        $this->template->set_partial('container', 'dotation/avion/gerer_dotation_avion_view',
                                      array('data' => $data,'prefix'=>'dotationAvion','dotations_Requsisiton' => $dotations_Requsisiton,'model'=>$model));
        break;
        case 'modifier':
        $this->set_breadcrumb(array("Modifier dotation avion" => ''));
        $dotation_trn_mdf = $this->dotation->getdotationsTransport($id,$Idtypebudget_requisit);
        $this->template->set_partial('container', 'dotation/avion/edit_dotation_avion_view', array('data' => $data,'dotation_trn_mdf'=>$dotation_trn_mdf));
        break;
        case 'dotationAvionImpr':
        $this->set_breadcrumb(array("Gestion dotation avion" => 'dotation/avion/gestion'));
        $dotation = $this->dotation->getdotationsTransport($id,$Idtypebudget_requisit);
        $this->template->set_partial('container', 'dotation/avion/dotation_avion_impr', array('data' => $data,'dotation' => $dotation));
        break ;
        }
        $this->template->title('Iav','Avion')->build('body');
  }
  public function modifierDotationAvion(){
      $this->form_validation->set_rules('montant', 'montant est obligatoire', 'required|trim',
                                   array('required' => 'Le champs Montant vignette  est obligatoire'));
     $this->form_validation->set_rules('date', 'date est obligatoire', 'required|trim',
                                  array('required' => 'Le champs date dotation  est obligatoire'));
    if ($this->form_validation->run()) {
      $mission                =  $this->input->post('mission');
      $montant                =  $this->input->post('montant');
      $date                   =  $this->input->post('date');
      $id_dotation_miss       =  $this->input->post('id_dot_miss');
      $Idtypebudget_requisit_t =  $this->typeBudget->read("*",array('code_budget' => 'AVION'));
    $Idtypebudget_requisit = $Idtypebudget_requisit_t[0]->id_type_budget;

        $options               = array(
                 'mission_id_mission'       => $mission,
                 'id_type_budget'           => $Idtypebudget_requisit,
                 'montant_dotation_mission' => $montant,
                 'date_dotation'            => $date,
                  'uby_dotation_mission'     => $this->CI->session->user['id_user']
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


/** Avion**/
}
?>
