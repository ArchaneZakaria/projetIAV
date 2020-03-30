<?php defined('BASEPATH') or exit('No direct script access allowed');

class  Iav_type_budget__annee_montant extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'iav_type_budget__annee_montant';
        $this->table_id = 'id_type_budget__Annee_montant';
    }

    public function Get_budgetAnneMantantById($id)
    {
      $req = " select tbam.id_type_budget__Annee_montant,tbam.montant_budget,tb.id_type_budget,tb.libelle_type_budget,ab.id_annee_budget,ab.libelle_annee from
        iav_type_budget__annee_montant as tbam,iav_type_budget as tb,iav_annee_budget as ab
        where tbam.id_type_budget = tb.id_type_budget and tbam.id_annee_budget = ab.id_annee_budget and tbam.id_type_budget__Annee_montant = '".$id."'";
        return $this->db->query($req);
    }

  }
