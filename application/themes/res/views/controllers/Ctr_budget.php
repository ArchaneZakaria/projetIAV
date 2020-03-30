<?php defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/Master.php';

class Ctr_budget extends Master
{
  function __construct() {
       parent::__construct();
     //chargement du lib et les models
     $this->load->library('form_validation');
     $this->load->model('Iav_type_budget_model','typebudget');
     $this->load->model('Iav_annee_budget_model','budgetAnnuel');
     $this->load->model('Iav_type_budget__annee_montant','budgetAnneeMontant');
     $this->load->model('Iav_tranche_budget_model','tranche');
	 $this->load->model('Iav_dotation_mission_model','dotation');
	 $this->load->model('Iav_reparation_model','reparation');
	 
   }
   //l'action par defaut ver la liste du budget annuel , nous envoyons avec les types budget et les annees pour (la recherche par typebudget/annee)
   public function index($data = ''){
      $this->display($data);
     $typebudget = $this->typebudget->read("*",array('deleted_type_budget'=>'N'));
     $annes      = $this->budgetAnnuel->read("*",array('deleted_annee' => 'N'));

     $this->set_breadcrumb(array("Budget annuel" => ''));
     $this->template->set_partial('container', 'budget/list_budgetAnnuel_view', array('data' => $data,
                                  'prefix'=>'budgetAnnuel','typebudget' => $typebudget,'annee_budget'=> $annes));
     $this->template->title('Gestion type budget','IAV')->build('body');
   }
   // l'action qui englob la gestion type budget add/edit/delete
   public function gestionTypeBudget($data = '',$id = null){
     $this->display($data);
     $typebudget = $this->typebudget->read("*",array('deleted_type_budget'=>'N'));
    /* $this->set_breadcrumb(array("" => ''));*/
    switch($data){
      case 'add':
      case    'ajouter':
      //$this->template->set_partial('container', 'add_domaineAcct_view', array('data' => $data));
      break;
      case 'edit':
      case 'modifier':
     $this->set_breadcrumb(array("Modifier type budget" => ''));
     $typebudf_modf = $this->typebudget->read("*",array('id_type_budget' => $id));
     $this->template->set_partial('container', 'budget/list_typeBudget_view', array('data' => $data,
                                  'prefix'=>'typebudget','typebudget' => $typebudget,
                                   'typebudf_modf' => $typebudf_modf));
      //$this->template->set_partial('container', 'add_update_prestataire_view', array('data' => $data));
      break;
      case 'del':
      case   'supprimer':
      //$this->template->set_partial('container', 'del_prestataire_view', array('data' => $data));
      break;
      default:
      $this->set_breadcrumb(array("Type Budget" => ''));
      $this->template->set_partial('container', 'budget/list_typeBudget_view', array('data' => $data,
                                   'prefix'=>'typebudget','typebudget' => $typebudget));
     }

     $this->template->title('Gestion type budget','IAV')
                    ->build('body');
   }
   //l'action gestion budget annuel
   public function  gestionBudgetAnnul($data = '',$id = null){
     $this->display($data);
     $typebudget = $this->typebudget->read("*",array('deleted_type_budget'=>'N'));
     $annes      = $this->budgetAnnuel->read("*",array('deleted_annee' => 'N'));
    /* $this->set_breadcrumb(array("" => ''));*/
      switch($data){
      case 'add':
      case 'ajouter':
      $this->set_breadcrumb(array("Ajouter budget annuel" => ''));
      $this->template->set_partial('container', 'budget/add_budgetAnnuel_view', array('data' => $data,
                                   'prefix'=>'budgetAnnuel','typebudget' => $typebudget,'annee_budget'=> $annes));
      break;
      case 'edit':
      case 'modifier':
      $bud_ann_mdf = $this->budgetAnneeMontant->Get_budgetAnneMantantById($id);
      $this->template->set_partial('container', 'budget/edit_budgetAnnuel_view', array('data' => $data,'typebudget' => $typebudget,'annee_budget'=> $annes,'prefix'=>'budgetAnnuel','bud_ann_mdf'=>$bud_ann_mdf->result()));
      break;
      case 'del':
      case 'supprimer':
      //$this->template->set_partial('container', 'del_prestataire_view', array('data' => $data));
      break;
      default:

      $this->set_breadcrumb(array("Budget annuel" => ''));
      $this->template->set_partial('container', 'budget/list_budgetAnnuel_view', array('data' => $data,
                                   'prefix'=>'budgetAnnuel','typebudget' => $typebudget,'annee_budget'=> $annes));
     }

     $this->template->title('Gestion type budget','IAV')->build('body');
   }
   //action editer une tranche qui a comme parameter id de la  tranche et $data
   public function editTranche($data = '',$id = null){
      $this->display($data);
      $tranche_mdf = $this->tranche->read("*",array('id_tranche_budget' => $id));
      $this->template->set_partial('container', 'budget/edit_tranche_view', array('data' => $data,
                                   'prefix'=>'trancheBudget','tranche_mdf' => $tranche_mdf));
      $this->template->title('Modifier tranche budget','IAV')->build('body');

   }
   //action ajouter une tranche ajax
   public function ajouter_tranche()
   {
     $this->form_validation->set_rules('tre_trnch', 'Le champs tre_trnch  est obligatoire', 'required|trim',
                               array('required' => 'Le champs Titre du tranche  est obligatoire'));
     $this->form_validation->set_rules('montant', 'Le champs montant est obligatoire', 'required|trim',
                             array('required' => 'Le champs montant est obligatoire'));
    if($this->form_validation->run()){
      $id     = $this->input->post('id');
      $titretranche     = $this->input->post('tre_trnch');
      $montant          = $this->input->post('montant');
      //get le rest du montant annul par son id
      $rest_mntAnn      = $this->tranche->getResultcompareBudgetAnnulWithSumMontTranche($id);
      //apres on fait le tester si le reste du montant >= le montant on passe a l'action ajouter tranche sinn message Erreur ..
      if($rest_mntAnn - $montant >= 0){
        $montant_ext      = 0;
        $tranches_by_id_type_budget_Annee_montant = $this->tranche->read("*",array('id_type_budget_Annee_montant' => $id,'deleted_tranche_budget' =>'N' ));
       if(count($tranches_by_id_type_budget_Annee_montant)> 0){
       $montant_ext = $tranches_by_id_type_budget_Annee_montant[count($tranches_by_id_type_budget_Annee_montant)-1]->montant_execute;
       }
        $options = array(
          'libelle_tranche_budget' => $titretranche,
          'montant'                => $montant,
          'montant_execute'        => $montant_ext+$montant,
          'deleted_tranche_budget' => 'N',
           'id_type_budget_Annee_montant' => $id
        );
        $teste_existe_tranche = $this->tranche->read("*",$options);
        if(count($teste_existe_tranche) == 0){
          $reslt                = $this->tranche->create($options,'cdate_tranche_budget');
        }
        if($reslt){
          $message = "vos informations ont éte ajoutées avec succès.";
          echo json_encode(array( 'status' => '1',
                                  'location' => 'url',
                                  'message' => $message));
        }else {
          $message = "Erreur de traitement.";
          echo json_encode(array( 'status' => '0',
                                  'location' => 'url',
                                  'message' => $message));
      }
      }else {
        $message = "Le montant de la tranche doit étre inferieure au reste du budget Annuel.";
        echo json_encode(array( 'status' => '0',
                                'location' => 'url',
                                'message' => $message));
      }
    }else {
      $errors = validation_errors();
      echo json_encode(array( 'status' => '0',
                              'location' => 'url',
                              'message' => $errors));
    }
   }
   //action modifier la tranche ajax + validation
   public function modifier_tranche()
   {
     $this->form_validation->set_rules('titretranche', 'Le champs titretranche  est obligatoire', 'required|trim',
                               array('required' => 'Le champs Titre du tranche  est obligatoire'));
     $this->form_validation->set_rules('montant', 'Le champs montant est obligatoire', 'required|trim',
                             array('required' => 'Le champs montant est obligatoire'));
     $this->form_validation->set_rules('resteMontant', 'Le champs reste Montant est obligatoire', 'required|trim',
                             array('required' => 'Le champs reste du Montant est obligatoire'));
    if($this->form_validation->run()){
        $id               = $this->input->post('id');
        $titretranche     = $this->input->post('titretranche');
        $montant          = $this->input->post('montant');
        $resteMontant     = $this->input->post('resteMontant');

        $options = array(
          'libelle_tranche_budget' => $titretranche,
          'montant'                => $montant,
          'montant_execute'        => $resteMontant
        );
        $reslt = $this->tranche->update($options,array('id_tranche_budget' => $id),'udate_tranche_budget');
        if($reslt){
          $message = "Vos informations ont été modifiées avec succès.";
          echo json_encode(array( 'status' => '1',
                                  'location' => 'url',
                                  'message' => $message));
        }else {
          $message = "Erreur de traitement.";
          echo json_encode(array( 'status' => '0',
                                  'location' => 'url',
                                  'message' => $message));
        }
    }else {
      $errors = validation_errors();
      echo json_encode(array( 'status' => '0',
                              'location' => 'url',
                              'message' => $errors));
    }
   }
   //action ajouter un type de budget ajax
   public function ajouter_typebudget()
   {
     $this->form_validation->set_rules('typebudget', 'Le champs type budget est obligatoire', 'required|trim',
                             array('required' => 'Le champs type budget  est obligatoire'));
     if($this->form_validation->run()){
      $typebudget     = $this->input->post('typebudget');
      $options = array(
        'libelle_type_budget'      => $typebudget
      );
      $result    = $this->typebudget->create($options,'cdate_type_budget');
      if($result){
        $message = "Vos informations ont été ajoutées avec succès.";
        echo json_encode(array( 'status' => '1',
                                'location' => 'url',
                                'message' => $message));
      }
     }else {
       $errors = validation_errors();
       echo json_encode(array( 'status' => '0',
                               'location' => 'url',
                               'message' => $errors));
     }
   }
   //Action modifier un type de budget ajax
   public function modifier_typebudget(){
      $this->form_validation->set_rules('typebudget_modf', 'Le champs type budget est obligatoire', 'required|trim',
                             array('required' => 'Le champs type budget  est obligatoire'));
      if($this->form_validation->run()){
        $typebudget_modf     = $this->input->post('typebudget_modf');
        $id                  = $this->input->post('id');
        $result              = $this->typebudget->update(array('libelle_type_budget' => $typebudget_modf),
                                                  array('id_type_budget' => $id ),'udate_type_budget');
      if($result){
        $message = "Vos informations ont été modifiées avec succès.";
        echo json_encode(array( 'status' => '1',
                                'location' => 'url',
                                'message' => $message));
      }else {
        $message = "Erreur de traitement.";
        echo json_encode(array( 'status' => '0',
                                'location' => 'url',
                                'message' => $message));
      }
      }else {
        $errors = validation_errors();
        echo json_encode(array( 'status' => '0',
                                'location' => 'url',
                                'message' => $errors));
      }
   }
   //action delete une tranche ajax
   public function delete_tranche()
   {
     $id          = $this->input->post('id');
     $date_delete =   date_create('now')->format('Y-m-d H:i:s');
     $result      =  $this->tranche->update(array('deleted_tranche_budget' => 'O',
                     'ddate_tranche_budget' => $date_delete),array('id_tranche_budget'=> $id ));
     if($result){
		 //traitement m.mahfoude 
		   $message = '';
		   $sql = $this->dotation->update(array('deleted_dotation_mission'=>'O'),array('id_tranche_budget'=> $id,'deleted_dotation_mission'=>'N'),'deleted_dotation_mission');
		   if($sql){
			   $message = $message."Les dotations liées à la tranche supprimés ont été supprimées , ";
		   }
		   $sql = $this->reparation->update(array('deleted_operation'=> 'O'),array('id_tranche_budget'=> $id,'deleted_operation'=>'N'),'ddate_reparation');
		   if($sql){
			   $message = $message."les reparations liées a la tranche supprimées ont été supprimées , ";
		   }
		 //end traitement m.mahfoude
       $message = $message."Vos informations ont été supprimées avec succès.";
       echo json_encode(array( 'status' => '1',
                               'location' => 'url',
                               'message' => $message));
     }else {
       $message = "Erreur de Traitement.";
       echo json_encode(array( 'status' => '0',
                               'location' => 'url',
                               'message' => $message));
     }
   }
   //action supprimer un type de budget ajax
   public function delete_typebudget(){
     $id          = $this->input->post('id');
     $date_delete =   date_create('now')->format('Y-m-d H:i:s');
     $result      =  $this->typebudget->update(array('deleted_type_budget' => 'O',
                     'ddate_type_budget'=> $date_delete),array('id_type_budget'=>$id));
     if($result){
       $message = "Vos informations ont été supprimées avec succès.";
       echo json_encode(array( 'status' => '1',
                               'location' => 'url',
                               'message' => $message));
     }else {
       $message = "Erreur de Traitement.";
       echo json_encode(array( 'status' => '0',
                               'location' => 'url',
                               'message' => $message));
     }
   }
   //action modifier un budget annuel ajax
   public function modifier_budgetannuel(){
     $this->form_validation->set_rules('type_budget', 'type_budget', 'callback_validation_check');
     $this->form_validation->set_rules('Annee', 'Annee', 'callback_validation_check');
     $this->form_validation->set_rules('montant', 'montant', 'required|trim',
                             array('required' => 'Le champs montant  est obligatoire'));

     if($this->form_validation->run()){
        $id                  = $this->input->post('id');
        $typebudget          = $this->input->post('type_budget');
        $Annee               = $this->input->post('Annee');
        $montant             = $this->input->post('montant');
        $options             = array(
                                      'id_type_budget'  => $typebudget,
                                      'id_annee_budget' => $Annee,
                                      'montant_budget'  => $montant
                            );
	  //traitement mahfoude.m 
	  $sql    = "select count(*) as cpt from iav_tranche_budget where 	id_type_budget_Annee_montant = '".$id."' and deleted_tranche_budget = 'N'";
	  $result = $this->db->query($sql);
	  $result_t = $result->result();
	  //var_dump( $result_t[0]->cpt);die;
	  if( count($result_t) > 0){
		  if($result_t[0]->cpt != 0){
			$message = "Vous ne pouvez pas modifier le budget Car le budget contient des tranches .";
			echo json_encode(array( 'status' => '0',
							'location' => 'url',
							'message' => $message));
							return;
		  }
	  }
	  //end traitement mahfoude.m 
      $rslt =  $this->budgetAnneeMontant->update($options,array('id_type_budget__Annee_montant' => $id),'udate_type_budget__Annee_montant');
      if($rslt){
        $message = "Vos informations ont été modifiées avec succèst.";
        echo json_encode(array( 'status' => '1',
                                'location' => 'url',
                                'message' => $message));
      }else {
        $message = "Erreur de Traitement.";
        echo json_encode(array( 'status' => '0',
                                'location' => 'url',
                                'message' => $message));
      }

     }else {
       $errors = validation_errors();
       echo json_encode(array( 'status' => '0',
                               'location' => 'url',
                               'message' => $errors));
     }
   }
   //Action ajouter un budget annuel
   public function ajouter_budgetAnnuel(){
     $this->form_validation->set_rules('type_budget', 'type_budget', 'callback_validation_check');
     $this->form_validation->set_rules('Annee', 'Annee', 'callback_validation_check');
     $this->form_validation->set_rules('montant', 'montant', 'required|trim',
                             array('required' => 'Le champs montant  est obligatoire'));

     if($this->form_validation->run()){
        $typebudget          = $this->input->post('type_budget');
        $Annee               = $this->input->post('Annee');
        $montant             = $this->input->post('montant');
        $options             = array(
                                      'id_type_budget'  => $typebudget,
                                      'id_annee_budget' => $Annee,
                                      'montant_budget'  => $montant
                            );
      $rslt =  $this->budgetAnneeMontant->create($options,'cdate_type_budget__Annee_montant');
      if($rslt){
        $message = "Vos informations ont été ajoutées avec succèst.";
        echo json_encode(array( 'status' => '1',
                                'location' => 'url',
                                'message' => $message));
      }else {
        $message = "Erreur de Traitement.";
        echo json_encode(array( 'status' => '0',
                                'location' => 'url',
                                'message' => $message));
      }

     }else {
       $errors = validation_errors();
       echo json_encode(array( 'status' => '0',
                               'location' => 'url',
                               'message' => $errors));
     }
   }
   //************ list ***********************
 // l'action qui liste les elements du tableau , un tableau contient la liste des budget annuel et les tranches de chaque budget
   public function listeDSD(){

     $type_budget = $this->input->post('type_budget');
     $annee     = $this->input->post('annee');

       $ConditionsTableHtml = "";
       $ConditionsTable     = "";
       $AndCondition        = "";
       $requette            = "select tbam.id_type_budget__Annee_montant,tbam.montant_budget,tbam.id_type_budget,tbam.id_annee_budget,tp.id_type_budget,tp.libelle_type_budget,ab.id_annee_budget,ab.libelle_annee from 	iav_type_budget__annee_montant as tbam ,iav_type_budget as tp ,iav_annee_budget as ab where tbam.id_type_budget = tp.id_type_budget and tbam.id_annee_budget = ab.id_annee_budget and tbam.deleted_type_budget__Annee_montantcol	= 'N' ";

      if($type_budget != '0'){
        $requette  = $requette." and tbam.id_type_budget = '".$type_budget."'";
      }
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
        $requette  = $requette." and tbam.id_annee_budget = '".$id_anne_valider."' ";

       $queryDetail = $this->db->query($requette);
       $NbrRow = $this->db->affected_rows();
       $TableHtml = '<table id="TableApp" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable_info"><thead><tr role="row"><th style="width: 10%;">Année</th><th style="width: 30%;">Type budget</th><th style="width: 25%;"><i class="fa fa-dollar" style="color:red;"></i> Montant Annuel</th><th style="width: 10%;">Restant</th><th style="width: 10%;">Options</th></tr></thead><tbody>';

       if($NbrRow){
         foreach($queryDetail->result() as $rowDetail ){
           $data_last_tranche        = $this->tranche->getLastTrancheByIdbudgetAnnee($rowDetail->id_type_budget__Annee_montant);
           $resteBudgetAnnuel        = $this->tranche->getResultcompareBudgetAnnulWithSumMontTranche($rowDetail->id_type_budget__Annee_montant);
           $data_last_tranche_plusId = $rowDetail->id_type_budget__Annee_montant.",".$data_last_tranche.",".$resteBudgetAnnuel;
           $TableHtml .= '<tr id="'.$rowDetail->id_type_budget__Annee_montant.'"><td id="elm_anne'.$rowDetail->id_type_budget__Annee_montant.'">'.$rowDetail->libelle_annee.'</td><td id="elm_typebudget'.$rowDetail->id_type_budget__Annee_montant.'" >'.$rowDetail->libelle_type_budget.'</td><td id="elm_montant'.$rowDetail->id_type_budget__Annee_montant.'">'.$rowDetail->montant_budget.'</td><td>'.$resteBudgetAnnuel.'</td>
           <td>
           <a class="red UP" id="'.$rowDetail->id_type_budget__Annee_montant.'"  name="'.$rowDetail->id_type_budget__Annee_montant.'"><i class="ace-icon fa fa-angle-double-down bigger-130"></i></a>
           <a class="item-edit  green" href="'.base_url('gestionBudgetAnnul/rch/edit/'.$rowDetail->id_type_budget__Annee_montant).'" data="" dat="benabbes@gmail.com">
              <i class="ace-icon fa fa-edit bigger-130"></i>
           </a>
           <a class="item-del budgetAnn red" href="#"  data="'.$rowDetail->id_type_budget__Annee_montant.'" dat="benabbes@gmail.com">
              <i class="ace-icon fa fa-trash-o bigger-130"></i>
           </a>
           <a href="#" class="add-tranche_cl"  data-toggle="tooltip" data-placement="top"  title="Lancer une nouvelle tranche!" data="'.$data_last_tranche_plusId.'">
           <span class="glyphicon glyphicon-plus"></span>
           </a>
           </td>
           </tr>';
           $QueryPersonelMenu = $this->db->query('select id_tranche_budget,libelle_tranche_budget,montant,montant_execute,cdate_tranche_budget from iav_tranche_budget where id_type_budget_Annee_montant='.$rowDetail->id_type_budget__Annee_montant.' and 	deleted_tranche_budget = "N" ');
               $NbrRowTR = $this->db->affected_rows();
               $TableHtml .= '<tr role="row" class="odd" id="TR_'.$rowDetail->id_type_budget__Annee_montant.'" style="display:none;"><td class="sorting_1 center-element vertical-center-element" colspan="5"><div>';
               $TableHtml .= '<table id="TableAppRow" class="table table-striped table-bordered dataTable no-footer"><thead><tr><th style="width: 20%;">Date debut</th><th style="width: 20%;">Nom de la tranche</th><th style="width: 40%;"><i class="fa fa-dollar" style="color:red;"></i> Montant</th><th style="width: 40%;"><i class="fa fa-dollar" style="color:red;"></i>  Montant cumulatif</th><th style="width: 10%;">Options</th></tr></thead><tbody>';

               if($NbrRowTR > 0){
               foreach($QueryPersonelMenu->result() as $rowDetail_tr){
               $TableHtml .= '<tr><td id="elm_cdatetranch'.$rowDetail_tr->id_tranche_budget.'">'.$rowDetail_tr->cdate_tranche_budget.'</td><td id="elm_titretranc'.$rowDetail_tr->id_tranche_budget.'">'.$rowDetail_tr->libelle_tranche_budget.'</td><td id="elm_mont'.$rowDetail_tr->id_tranche_budget.'" >'.$rowDetail_tr->montant.'</td><td id="elm_restemont'.$rowDetail_tr->id_tranche_budget.'">'.$rowDetail_tr->montant_execute.'</td>
               <td>
               <a class="item-edit green" href="'.base_url('gestionBudgetAnnul/trch/edit/'.$rowDetail_tr->id_tranche_budget).'" data="" dat="benabbes@gmail.com">
                  <i class="ace-icon fa fa-edit bigger-130"></i>
               </a>
               <a class="item-del tranche red" href="#"  data="'.$rowDetail_tr->id_tranche_budget.'" dat="benabbes@gmail.com">
                  <i class="ace-icon fa fa-trash-o bigger-130"></i>
               </a>
               </td></tr>';
             }
         }
           $TableHtml .= '</tbody></table>';
           $TableHtml .= '</div></td></tr>';
         }

       }
        $TableHtml .= "</tbody></table>";
       echo json_encode(array('status' => '1',
                               'location' => 'url',
                               'message' => 'test',
                               'TableContenu' => $TableHtml));
   }

   //****************************************
  //action delete budgeAnnuel ajax
  public function delete_budgetAnnuel()
  {
      $id          = $this->input->post('id');
      $reslt       = $this->budgetAnneeMontant->update(array('deleted_type_budget__Annee_montantcol' => 'O'),array('id_type_budget__Annee_montant'=>$id));
      if($reslt){
		 
		$this->dotation->delete_all_data_budget($id);
		$this->reparation->delete_all_data_reparation($id);
        $message = "Vos informations ont été supprimées avec succèst.";
        echo json_encode(array( 'status' => '1',
                                'location' => 'url',
                                'message' => $message));
      }else {
        $message = "Erreur de traitement.";
        echo json_encode(array( 'status' => '0',
                                'location' => 'url',
                                'message' => $message));
      }
  }
  //une action de validation , qui teste si une variable equal 0 ou pas pour tester value du champs input
   public function validation_check($str){
     if ($str == "0"){
             $this->form_validation->set_message('validation_check', ' Le champs  {field} est obligatoire  ');
             return FALSE;
     }
     else{
             return TRUE;
     }
   }
}
