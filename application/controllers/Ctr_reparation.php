<?php defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/Master.php';

class Ctr_reparation extends Master
{
  private $CI;
  function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Iav_type_budget_model','typeBudget');
        $this->load->model('Iav_annee_budget_model','annee_budget');
        $this->load->model('Iav_type_budget__annee_montant','budgetAnneeMontant');
        $this->load->model('Iav_tranche_budget_model','tranche');
        $this->load->model('Iav_reparation_model','reparation');
        $this->load->model('Iav_article_reparation_model','article');
        $this->load->model('Iav_chauffeur_model','chauffeur');
        $this->load->model('Iav_departement_model','departement');
        $this->load->model('Iav_vehicule_model','vehicule');
        $this->load->model('Iav_fournisseur_model','prestataire');
        $this->load->model('Iav_consulation_model','consultation');
        $this->load->library('session');
        $this->CI = &get_instance();
    }
  public function index($data = ''){
    $this->display($data);
    $this->template->set_partial('container', 'demande_encours_reparation_view', array('data' => $data));
    $this->template->title('dd','ee')->build('body');
  }
  public function reparation($data = '',$id = null){
     $this->display($data);
     switch($data){
     case 'demand':
     case  'ajouter':
     $this->set_breadcrumb(array("Demande réparation" => ''));
     $this->template->set_partial('container', 'reparation/add_update_reparation_view', array('data' => $data));
     break;
     case 'encours':
     $reparations_encours = $this->reparation->GetReparationEnCours();
     $model = $this->template->load_view('../views/modals/admin/op_modall');
     $this->template->set_partial('container', 'reparation/reparation_encours_view', array(
                                                                        'data'             => $data,
                                                                        'reparat_encr'     => $reparations_encours->result(),
                                                                        'model'            => $model
                                    ));
     break;
     case 'valid':
     $this->template->set_partial('container', 'reparation_valid_view', array('data' => $data));
     break;
     case 'ecnoursexecution':
     $reparation_enc_ex = $this->reparation->GetReparationEnCoursExecution();
     $model = $this->template->load_view('../views/modals/admin/op_modall');
     $this->template->set_partial('container', 'reparation/reparation_ecnoursexecut_view', array(
                                                                        'data'             => $data,
                                                                        'reparat_encr_ex'     => $reparation_enc_ex->result(),
                                                                        'model'            => $model
                                    ));
     break;
     case 'reparation_impr':
     $this->set_breadcrumb(array("Gestion Demandes en cours" => 'reparation/op/encours',"Gestion reparations executées" => 'reparation/op/ecnoursexecution'));
     $reparation = $this->reparation->read("*",array('id_reparation' => $id));
     $actiles_r  = $this->article->read("*",array('iav_reparation_id_reparation' => $id,'deleted_article_reparation' => 'N'));
     $conducteur = $this->chauffeur->read("*",array('id_chauffeur' => $reparation[0]->iav_chauffeur_id_chauffeur));
     $entite     = $this->departement->read("*",array('id_responsable_departement' => $reparation[0]->cby_reparation,'deleted_departement' => 'N'));
	 $matricule  = $this->vehicule->GetVehicule_Alldata($reparation[0]->iav_vehicule_id_vehicule);
     $this->template->set_partial('container', 'reparation/reparation_impr', array('data'       => $data,
                                                                                   'reparation' => $reparation,
                                                                                    'actiles_r' => $actiles_r,
                                                                                    'conducteur'=> $conducteur,
                                                                                    'entite'   =>  $entite,
                                                                                    'vehicule' => $matricule->result()
                                                                                   ));
     break;
     case 'modifier':
     $reparation = $this->reparation->GetReparationEnCours($id);
     $articles   = $this->article->read("*",array('iav_reparation_id_reparation' => $id,'deleted_article_reparation' => 'N' ));
     $this->template->set_partial('container', 'reparation/reparation_edit_view', array('data'        => $data,
                                                                                         'reparation' => $reparation->result(),
                                                                                         'articles'   => $articles
                                                                                   ));
     break;
     }
      $this->template->title('Iav','réparation')->build('body');
     }
     public function validerReparation()
     {
       $id_rep = $this->input->post('id_rep');
       $result = $this->reparation->update(array('status_reparation' => 'VP','uby_operation'=>$this->CI->session->user['id_user']),array('id_reparation' => $id_rep),'udate_reparation');
       if($result){
         $message = "La reparation a été valider avec success";
         echo json_encode(array('status' => '1',
                                'location' => 'url',
                                'message' => $message));
       }else {
         $message = "Erreur  de Traitement";
         echo json_encode(array('status' => '0',
                                'location' => 'url',
                                'message' => $message));
       }
     }
     public function getreparationBychaufeur_2()
     {
       $id_chf    = $this->input->post('id_chf');
       $id_vcl    = $this->input->post('id_vcl');
       $id_entr   = $this->input->post('id_entr');
       $date_d    = $this->input->post('date_d');
       $date_f    = $this->input->post('date_f');
       $reparations_encours = $this->reparation->GetReparationEnCoursExecution(null,$id_chf,$id_vcl,$id_entr,$date_d,$date_f);
       $tab = $this->template->load_view('reparation/tab_serch_view_encoursexc.php',array('reparat_encr_ex'=> $reparations_encours->result()));
       echo $tab;
     }
     public function exectution_final_reparation()
     {
       $id      = $this->input->post('id');
       $etat    = $this->input->post('etat');
       $status  = '';
       if($etat == "true"){
         $status = 'XX';
       }else if($etat == "false"){
          $status = 'EX';
       }
       $result = $this->reparation->update(array('status_reparation'=>$status,'uby_operation'=>$this->CI->session->user['id_user']),array('id_reparation' => $id),'udate_reparation');
      if($result){
        echo $etat;
      }

     }
     public function getreparationBychaufeur()
     {
       $id_chf    = $this->input->post('id_chf');
       $id_vcl    = $this->input->post('id_vcl');
       $id_entr   = $this->input->post('id_entr');
       $date_d    = $this->input->post('date_d');
       $date_f    = $this->input->post('date_f');
       $reparations_encours = $this->reparation->GetReparationEnCours(null,$id_chf,$id_vcl,$id_entr,$date_d,$date_f);
       $tab = $this->template->load_view('reparation/tab_serch_view.php',array('reparations_encours'=>$reparations_encours));
       echo $tab;

     }
     public function getformExecte(){
        $prestataire = $this->prestataire->read("*",array('deleted_fournisseur'=>'N'));
        $id    = $this->input->post('id');
        $reparation      =  $this->reparation->read("*",array('id_reparation' => $id));
        $type_reparation = $reparation[0]->id_type_reparation;      
        echo $this->template->load_view('reparation/formExecteReparation_view.php',array('prestataire'=>$prestataire,'id'=>$id));
     }

     public function getfournisseurByreparationview(){
         $id    = $this->input->post('id');
         $prestataires = $this->consultation->getconsulations($id);
         echo $this->template->load_view('reparation/model_prestataire_reparation_view.php',array('prest'=>$prestataires->result()));
     }
     public function execute_reparation_2()
     {
		$etat_1          = 0;
		$etat_2          = 0;
		$id              =  $this->input->post('id');
        $mnt_pr          =  $this->input->post('mnt_pr');
        $fournisseur     =  $this->input->post('fournisseur');

        $fournisseur_1     =  $this->input->post('fournisseur_1');
        $fournisseur_2     =  $this->input->post('fournisseur_2');
        $fournisseur_3     =  $this->input->post('fournisseur_3');

        $mnt_pr_1          =  $this->input->post('mnt_pr_1');
        $mnt_pr_2          =  $this->input->post('mnt_pr_2');
        $mnt_pr_3          =  $this->input->post('mnt_pr_3');
		
		if($mnt_pr == null || $fournisseur == 0){
	   $etat_1 = 1;
	   $this->form_validation->set_rules('fournisseur_1', 'fournisseur  est obligatoire', 'callback_validation_check');
       $this->form_validation->set_rules('fournisseur_2', 'fournisseur  est obligatoire', 'callback_validation_check');
       $this->form_validation->set_rules('fournisseur_3', 'fournisseur  est obligatoire', 'callback_validation_check');
       $this->form_validation->set_rules('mnt_pr_1', 'Montant AR est obligatoire', 'required|trim',
                                    array('required' => 'Le champs Montant AR Pour le 1ere fournisseur est obligatoire'));
        $this->form_validation->set_rules('mnt_pr_2', 'Montant AR est obligatoire', 'required|trim',
                                   array('required' => 'Le champs Montant AR Pour le 2éme fournisseur est obligatoire'));
        $this->form_validation->set_rules('mnt_pr_3', 'Montant AR  est obligatoire', 'required|trim',
                                    array('required' => 'Le champs Montant AR Pour le 3éme fournisseur est obligatoire'));	
		}
		if($mnt_pr_1 == null || $mnt_pr_2 == null || $mnt_pr_3 == null || $fournisseur_1 == 0  || $fournisseur_2 == 0 || $fournisseur_3 == 0){
			   $etat_2 = 1;
		       $this->form_validation->set_rules('mnt_pr', 'Montant PR est obligatoire', 'required|trim',
                                    array('required' => 'Le champs Montant PR est obligatoire'));
               $this->form_validation->set_rules('fournisseur', 'fournisseur  est obligatoire', 'callback_validation_check');	
		}
      if($this->form_validation->run() || ($etat_1 == 0 && $etat_2 == 0 && $this->form_validation->run() == false)){
		if($etat_2 == 0){
		$mnt_ar          =  min($mnt_pr_1,$mnt_pr_2,$mnt_pr_3);	
		}else{
		$mnt_ar          =  0;
		}
		
        $reparation      =  $this->reparation->read("*",array('id_reparation' => $id));
        $type_reparation = $reparation[0]->id_type_reparation;

          $Idtypebudget_Transport_t =  $this->typeBudget->read("*",array('libelle_type_budget' => 'REPARATION'));
		  $Idtypebudget_Transport   = $Idtypebudget_Transport_t[0]->id_type_budget;
          $annee_courante           = date("Y");
          $id_Annee_courante_t      = $this->annee_budget->read("*",array('libelle_annee'=> $annee_courante));
		  $id_Annee_courante = $id_Annee_courante_t[0]->id_annee_budget;
          $t_typeAnneeBudget      = $this->budgetAnneeMontant->read("*",array('id_type_budget'=> $Idtypebudget_Transport,'id_annee_budget' => $id_Annee_courante,
           'deleted_type_budget__Annee_montantcol' => 'N'));
           if(count($t_typeAnneeBudget) == 0){
             $message = "Erreur Aucun  budget Annuel du type reparation";
             echo json_encode(array('status' => '0',
                                    'location' => 'url',
                                    'message' => $message));
            return;
           }
           $id_typeAnneeBudget   = $t_typeAnneeBudget[0]->id_type_budget__Annee_montant;
           $tranches             = $this->tranche->read("*",array('id_type_budget_Annee_montant' => $id_typeAnneeBudget,'deleted_tranche_budget' =>'N' ));
          if(count($tranches)   == 0){
            $message = "Erreur  Aucune tranche existe pour le budget Annuel";
            echo json_encode(array('status' => '0',
                                   'location' => 'url',
                                   'message' => $message));
           return;
          }
          $last_tranche_t          = array_slice($tranches,count($tranches)-1);
		  $last_tranche            = $last_tranche_t[0];
          $id_last_tranche         = $last_tranche->id_tranche_budget;

          $options = array(
            'status_reparation' => 'EX',
            'prix_PR_reparation'=> $mnt_pr,
            'prix_AM_reparation'=> $mnt_ar,
            'Mt_Total_reparation'=>$mnt_pr+$mnt_ar,
             'id_fournisseur'    => $fournisseur,
             'id_tranche_budget' => $id_last_tranche,
             'uby_operation'     =>$this->CI->session->user['id_user']
          );
         $result = $this->reparation->update($options,array('id_reparation' => $id),'udate_reparation');
         if($result){
           $id_tranche = $reparation[0]->id_tranche_budget;
           $tranche    = $this->tranche->read("*",array('id_tranche_budget' => $id_tranche));
           if($tranche[0]->montant_execute >= $mnt_pr+$mnt_ar){
             $opt = array(
              'montant_execute' => $tranche[0]->montant_execute - ($mnt_pr+$mnt_ar)
             );
             $reslt          = $this->tranche->update($opt,array('id_tranche_budget' => $id_tranche),'udate_tranche_budget');
             if($etat_2 == 0 ){
				 $opt_historique_1 = array(
                         'iav_fournisseur_id_fournisseur' => $fournisseur_1,
                         'montant_consutation'            => $mnt_pr_1,
                          'id_reparation'                 => $id
             );
             $opt_historique_2 = array(
                         'iav_fournisseur_id_fournisseur' => $fournisseur_2,
                         'montant_consutation'            => $mnt_pr_2,
                          'id_reparation'                 => $id
             );
             $opt_historique_3 = array(
                         'iav_fournisseur_id_fournisseur' => $fournisseur_3,
                         'montant_consutation'            => $mnt_pr_3,
                          'id_reparation'                 => $id
             );
             $historique_1     = $this->consultation->create($opt_historique_1,'cdate_consultation');
             $historique_2     = $this->consultation->create($opt_historique_2,'cdate_consultation');
             $historique_3     = $this->consultation->create($opt_historique_3,'cdate_consultation');
			 }
             $message        = "La reparation est En cours d'execution";
             echo json_encode(array('status'               => '1',
                                    'location'             => 'url',
                                    'message'              => $message,
                                   ));
           }else {
             $message = "Le montant cumulatif est insuffisant";
             echo json_encode(array('status'               => '0',
                                    'location'             => 'url',
                                    'message'              => $message,
                                   ));
           }
         }
      }else {
        $errors = validation_errors();
        echo json_encode(array('status' => '0',
                               'location' => 'url',
                               'message' => $errors));
      }

     }
     public function execute_reparation()
     {
       $this->form_validation->set_rules('mnt_pr', 'Montant PR est obligatoire', 'required|trim',
                                    array('required' => 'Le champs Montant PR est obligatoire'));
       $this->form_validation->set_rules('fournisseur', 'fournisseur  est obligatoire', 'callback_validation_check');
       if($this->form_validation->run()){
         $id              =  $this->input->post('id');
         $mnt_pr          =  $this->input->post('mnt_pr');
         $fournisseur     =  $this->input->post('fournisseur');
         $reparation      =  $this->reparation->read("*",array('id_reparation' => $id));
         $type_reparation = $reparation[0]->id_type_reparation;
         if($type_reparation == 1){

           $Idtypebudget_Transport_t =  $this->typeBudget->read("*",array('libelle_type_budget' => 'REPARATION '));
		   $Idtypebudget_Transport = $Idtypebudget_Transport_t[0]->id_type_budget;
           $annee_courante         = date("Y");
           $id_Annee_courante_t      = $this->annee_budget->read("*",array('libelle_annee'=> $annee_courante));
		   $id_Annee_courante       = $id_Annee_courante_t[0]->id_annee_budget;
           $t_typeAnneeBudget      = $this->budgetAnneeMontant->read("*",array('id_type_budget'=> $Idtypebudget_Transport,'id_annee_budget' => $id_Annee_courante,
            'deleted_type_budget__Annee_montantcol' => 'N'));
            if(count($t_typeAnneeBudget) == 0){
              $message = "Erreur Aucun  budget Annuel du type reparation";
              echo json_encode(array('status' => '0',
                                     'location' => 'url',
                                     'message' => $message));
             return;
            }
            $id_typeAnneeBudget  = $t_typeAnneeBudget[0]->id_type_budget__Annee_montant;
           $tranches             = $this->tranche->read("*",array('id_type_budget_Annee_montant' => $id_typeAnneeBudget,'deleted_tranche_budget' =>'N' ));
           if(count($tranches)   == 0){
             $message = "Erreur  Aucune tranche existe pour le budget Annuel";
             echo json_encode(array('status' => '0',
                                    'location' => 'url',
                                    'message' => $message));
            return;
           }
           $last_tranche_t          = array_slice($tranches,count($tranches)-1);
		   $last_tranche = $last_tranche_t[0];
           $id_last_tranche       = $last_tranche->id_tranche_budget;
           $options = array(
             'status_reparation' => 'EX',
             'prix_PR_reparation'=> $mnt_pr,
             'prix_AM_reparation'=> 0,
             'Mt_Total_reparation'=>$mnt_pr,
             'id_fournisseur'    => $fournisseur,
             'id_tranche_budget' => $id_last_tranche,
              'uby_operation'     =>$this->CI->session->user['id_user']
           );
          $result = $this->reparation->update($options,array('id_reparation' => $id),'udate_reparation');
          if($result){
            $id_tranche = $reparation[0]->id_tranche_budget;
            $tranche    = $this->tranche->read("*",array('id_tranche_budget' => $id_tranche));
            if($tranche[0]->montant_execute >= $mnt_pr){
              $opt = array(
               'montant_execute' => $tranche[0]->montant_execute-$mnt_pr
              );
              $reslt   = $this->tranche->update($opt,array('id_tranche_budget' => $id_tranche),'udate_tranche_budget');
              $message = "La reparation est En cours d'execution";
              echo json_encode(array('status'               => '1',
                                     'location'             => 'url',
                                     'message'              => $message,
                                    ));
            }else {
              $message = "Le montant cumulatif est insuffisant";
              echo json_encode(array('status'               => '0',
                                     'location'             => 'url',
                                     'message'              => $message,
                                    ));
            }
          }
        }
       }else {
         $errors = validation_errors();
         echo json_encode(array('status' => '0',
                                'location' => 'url',
                                'message' => $errors));
       }

     }
  public function getTableauArticle(){
      $compt_actricle    =  $this->input->post('cmpt_atricle');
      $articles          =  $this->input->post('articles');
      $articles_tab      = explode(":",$articles);
      echo  $this->template->load_view('reparation/result_tabArticle_view',
                             array('compt_actricle'=> $compt_actricle,'articles_tab' => $articles_tab));
  }
  public function ajouterReparationArticle(){
    $this->form_validation->set_rules('conducteur', 'conducteur est obligatoire', 'callback_validation_check');
    $this->form_validation->set_rules('vehicule', 'vehicule  est obligatoire', 'callback_validation_check');
    $this->form_validation->set_rules('type_Entretiens', 'type_Entretiens  est obligatoire', 'callback_validation_check');
    $this->form_validation->set_rules('articles', 'articles  est obligatoire', 'callback_validation_article_check');
    $this->form_validation->set_rules('compteur', 'compteur est obligatoire', 'required|trim',
                                 array('required' => 'Le champs compteur est obligatoire'));
     if ($this->form_validation->run()) {
       $conducteur           = $this->input->post('conducteur');
       $vehicule             = $this->input->post('vehicule');
       $type_Entretiens      = $this->input->post('type_Entretiens');
       $compteur             =  $this->input->post('compteur');
       $articles             =  $this->input->post('articles');
       $articles_tab         = explode(":",$articles);

       $Idtypebudget_Transport_t =  $this->typeBudget->read("*",array('libelle_type_budget' => 'REPARATION'));
	   $Idtypebudget_Transport = $Idtypebudget_Transport_t[0]->id_type_budget;
       $annee_courante         = date("Y");
       $id_Annee_courante_t      = $this->annee_budget->read("*",array('libelle_annee'=> $annee_courante));
	   $id_Annee_courante = $id_Annee_courante_t[0]->id_annee_budget;
       $t_typeAnneeBudget      = $this->budgetAnneeMontant->read("*",array('id_type_budget'=> $Idtypebudget_Transport,'id_annee_budget' => $id_Annee_courante,
        'deleted_type_budget__Annee_montantcol' => 'N'));
        if(count($t_typeAnneeBudget) == 0){
          $message = "Erreur Aucun  budget Annuel du type reparation";
          echo json_encode(array('status' => '0',
                                 'location' => 'url',
                                 'message' => $message));
         return;
        }
        $id_typeAnneeBudget  = $t_typeAnneeBudget[0]->id_type_budget__Annee_montant;
       $tranches             = $this->tranche->read("*",array('id_type_budget_Annee_montant' => $id_typeAnneeBudget,'deleted_tranche_budget' =>'N' ));
       if(count($tranches)   == 0){
         $message = "Erreur  Aucune tranche existe pour le budget Annuel";
         echo json_encode(array('status' => '0',
                                'location' => 'url',
                                'message' => $message));
        return;
       }
       $last_tranche_t          = array_slice($tranches,count($tranches)-1);
	   $last_tranche = $last_tranche_t[0];
       $id_last_tranche       = $last_tranche->id_tranche_budget;
       $reparation_op         = array(
                                     'iav_chauffeur_id_chauffeur' => $conducteur,
                                     'iav_vehicule_id_vehicule'   => $vehicule,
                                     'kilometrage_vehicule'       => $compteur,
                                     'id_type_reparation'         => $type_Entretiens,
                                     'status_reparation'          => 'EN',
                                      'id_tranche_budget'        => $id_last_tranche,
                                       'cby_reparation'     =>$this->CI->session->user['id_user']
                                     );
      $id_reparat_aj          = $this->reparation->create($reparation_op,'cdate_reparation');
      if($id_reparat_aj != null){
        foreach ($articles_tab as $key => $value) {
           if($value != ''){
             $value_tab = explode(",",$value);
             $options = array (
                           'article_reparation'           => $value_tab[0],
                           'unite_article_reparation'     => $value_tab[1],
                           'qte_article_reparation'       => $value_tab[2],
                           'iav_reparation_id_reparation' => $id_reparat_aj
                           );
           $result = $this->article->create($options,'cdate_article_reparation');
        }
        }
        $message = "vos informations ont été enregistrées avec success";
        echo json_encode(array('status'               => '1',
                               'location'             => 'url',
                               'message'              => $message,
                               'id_last_add_dotation' => $id_reparat_aj
                              ));
     }
     }else {
       $errors = validation_errors();
       echo json_encode(array('status' => '0',
                              'location' => 'url',
                              'message' => $errors));
     }
  }
  public function modifierReparation(){
    $this->form_validation->set_rules('conducteur', 'conducteur est obligatoire', 'callback_validation_check');
    $this->form_validation->set_rules('vehicule', 'vehicule  est obligatoire', 'callback_validation_check');
    $this->form_validation->set_rules('type_Entretiens', 'type_Entretiens  est obligatoire', 'callback_validation_check');
    $this->form_validation->set_rules('compteur', 'compteur est obligatoire', 'required|trim',
                                 array('required' => 'Le champs compteur est obligatoire'));
     if ($this->form_validation->run()) {
       $id           = $this->input->post('id');
       $conducteur           = $this->input->post('conducteur');
       $vehicule             = $this->input->post('vehicule');
       $type_Entretiens      = $this->input->post('type_Entretiens');
       $compteur             =  $this->input->post('compteur');
       $status               = $this->input->post('status');
       $Idtypebudget_Transport_t =  $this->typeBudget->read("*",array('libelle_type_budget' => 'REPARATION '));
	   $Idtypebudget_Transport = $Idtypebudget_Transport_t[0]->id_type_budget;
       $annee_courante         = date("Y");
       $id_Annee_courante_t      = $this->annee_budget->read("*",array('libelle_annee'=> $annee_courante));
	   $id_Annee_courante      = $id_Annee_courante_t[0]->id_annee_budget;
       $t_typeAnneeBudget      = $this->budgetAnneeMontant->read("*",array('id_type_budget'=> $Idtypebudget_Transport,'id_annee_budget' => $id_Annee_courante,
        'deleted_type_budget__Annee_montantcol' => 'N'));
        if(count($t_typeAnneeBudget) == 0){
          $message = "Erreur Aucun  budget Annuel du type reparation";
          echo json_encode(array('status' => '0',
                                 'location' => 'url',
                                 'message' => $message));
         return;
        }
       $id_typeAnneeBudget  = $t_typeAnneeBudget[0]->id_type_budget__Annee_montant;
       $tranches             = $this->tranche->read("*",array('id_type_budget_Annee_montant' => $id_typeAnneeBudget,'deleted_tranche_budget' =>'N' ));
       if(count($tranches)   == 0){
         $message = "Erreur  Aucune tranche existe pour le budget Annuel";
         echo json_encode(array('status' => '0',
                                'location' => 'url',
                                'message' => $message));
        return;
       }
       $last_tranche_t          = array_slice($tranches,count($tranches)-1);
	   $last_tranche  = $last_tranche_t[0];
       $id_last_tranche       = $last_tranche->id_tranche_budget;
       $reparation_op         = array(
                                     'iav_chauffeur_id_chauffeur' => $conducteur,
                                     'iav_vehicule_id_vehicule'   => $vehicule,
                                     'kilometrage_vehicule'       => $compteur,
                                     'id_type_reparation'         => $type_Entretiens,
                                     'status_reparation'          => $status,
                                      'id_tranche_budget'         => $id_last_tranche,
                                     'uby_operation'              =>$this->CI->session->user['id_user']
                                     );
      $result          = $this->reparation->update($reparation_op,array('id_reparation' => $id),'udate_reparation');
      if($result){
        $message = "vos informations ont été modifieés avec success";
        echo json_encode(array('status'               => '1',
                               'location'             => 'url',
                               'message'              => $message,
                               'id_last_add_dotation' => $id
                              ));
     }
     }else {
       $errors = validation_errors();
       echo json_encode(array('status' => '0',
                              'location' => 'url',
                              'message' => $errors));
     }
  }
  public function delete_reparation()
  {
    $id = $this->input->post('id');
    $result = $this->reparation->update(array('deleted_operation' => 'O','status_reparation' => 'RJ'),array('id_reparation' => $id),'ddate_reparation');
    if($result){
      $message = "La reparation a été regetée avec success";
      echo json_encode(array('status'               => '1',
                             'location'             => 'url',
                             'message'              => $message,
                            ));
    }else {
      $message = "Erreur de Traitement";
      echo json_encode(array('status'               => '0',
                             'location'             => 'url',
                             'message'              => $message,
                            ));
    }
  }

  public function deleteArticle()
  {
      $id              = $this->input->post('id');
      $id_reparat_arcl_t = $this->article->read("iav_reparation_id_reparation",array('id_article_reparation' => $id));
      $id_reparat_arcl = $id_reparat_arcl_t[0]->iav_reparation_id_reparation;
      $result = $this->article->update(array('deleted_article_reparation' => 'O'),array('id_article_reparation' => $id));
      if($result){
        $message = "L'article a été supprimées avec success |  ";
        $articles   = $this->article->read("*",array('iav_reparation_id_reparation' => $id_reparat_arcl,'deleted_article_reparation' => 'N'));
        if(COUNT($articles) == 0){
          $result = $this->reparation->update(array('deleted_operation' => 'O','status_reparation' => 'RJ'),array('id_reparation' => $id_reparat_arcl),'ddate_reparation');
          if($result){
            $message = $message."Aucun Article, d'ou la suppression Automatique du reparation";
            echo json_encode(array('status'               => '1',
                                   'location'             => 'url',
                                   'to'                   => '0',
                                   'message'              => $message,
                                   'id_last_add_dotation' => $id_reparat_arcl
                               ));
        }
        }else {
          echo json_encode(array('status'               => '1',
                                 'location'             => 'url',
                                 'to'                   => '1',
                                 'message'              => $message,
                                 'id_last_add_dotation' => $id_reparat_arcl
                             ));
      }
     }else {
      $message = "Erreur de traitement ";
      echo json_encode(array('status'               => '0',
                             'location'             => 'url',
                             'message'              => $message
                            ));
     }
  }

    public function modifierArticle()
    {
      $this->form_validation->set_rules('article', 'article est obligatoire', 'required|trim',
                                   array('required' => 'Le champs article est obligatoire'));
      $this->form_validation->set_rules('unite', 'Unite est obligatoire', 'required|trim',
                                    array('required' => 'Le champs Unite est obligatoire'));
      $this->form_validation->set_rules('qn', 'article est obligatoire', 'required|trim',
                                   array('required' => 'Le champs Quantité est obligatoire'));
      if ($this->form_validation->run()) {
        $id                = $this->input->post('id');
        $article           = $this->input->post('article');
        $unite             = $this->input->post('unite');
        $qn                = $this->input->post('qn');
        $options           = array(
           'article_reparation'       => $article,
           'unite_article_reparation' => $unite,
           'qte_article_reparation'   => $qn
        );
        $result = $this->article->update($options,array('id_article_reparation' => $id),'udate_article_reparation');
        if($result){
          $message = "L'article a éte modifiees avec success";
          echo json_encode(array('status'               => '1',
                                 'location'             => 'url',
                                 'message'              => $message
                                ));
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
    }else{
      return TRUE;
    }
  }
  public function validation_article_check($str){
    if ($str == ""){
    $this->form_validation->set_message('validation_article_check','Vous devez avoir aumoins un Article');
    return FALSE;
    }else{
    return TRUE;
  }
  }


}
?>
