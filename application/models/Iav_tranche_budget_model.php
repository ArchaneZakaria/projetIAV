<?php defined('BASEPATH') or exit('No direct script access allowed');

class Iav_tranche_budget_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'iav_tranche_budget';
        $this->table_id = '	id_tranche_budget';
    }






    //get le dernier tranche d'un budget Annuel connai par son id
    public function getLastTrancheByIdbudgetAnnee($idBudgetAnnul){
      $result = '';
      $tranches_by_id_type_budget_Annee_montant = $this->read("*",array('id_type_budget_Annee_montant' => $idBudgetAnnul,'deleted_tranche_budget' =>'N' ));
      if(COUNT($tranches_by_id_type_budget_Annee_montant)>0){
        $tab_reslt = $tranches_by_id_type_budget_Annee_montant[count($tranches_by_id_type_budget_Annee_montant)-1];
        $result = $tab_reslt->libelle_tranche_budget.",".$tab_reslt->montant.",".$tab_reslt->montant_execute.",".$tab_reslt->cdate_tranche_budget;
      }
      return $result;
    }
    //get le reste du budget annul
    public function getResultcompareBudgetAnnulWithSumMontTranche($idBudgetAnnul)
    {
      $sql           = "select 	montant_budget from iav_type_budget__annee_montant where 	id_type_budget__Annee_montant ='".$idBudgetAnnul."'";
      $reslt         = $this->db->query($sql);
      $montant_ann_t   = $reslt->result();
	  $montant_ann  = $montant_ann_t[0]->montant_budget;
      $sum_mnt_trnch = 0;
      $rslt          = $this->read("*",array('id_type_budget_Annee_montant' => $idBudgetAnnul ,'deleted_tranche_budget' => 'N'));
      foreach($rslt as $rowDetail_tr){
        $sum_mnt_trnch = $sum_mnt_trnch + $rowDetail_tr->montant;
      }
        return $montant_ann - $sum_mnt_trnch;
    }

  }
