<?php defined('BASEPATH') or exit('No direct script access allowed');

class Iav_dotation_mission_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'iav_dotation_mission';
        $this->table_id = 'id_dotation_mission';
    }


    public function create ($options, $created_on_field = 'cdate_dotation_mission') {
        return parent::create($options, $created_on_field);
        }

      /*public function update ($options, $conditions = array(), $modified_on_field = 'udate_dotation_mission') {
        return parent::updateiav($options, $conditions, $modified_on_field,'id_dotation_mission');
    }*/

/*
    public function update ($options, $conditions = array()) {
        return parent::update($options, $conditions);
    }

    public function get_search ($match) {
        if (!isset($match) || empty($match))
            return array();
        $this->db->where('newsIsPublished', '1');
        $this->db->like('newsTitle', $match);
        $this->db->or_like('newsDescriptionBrut',$match);
        return $this->db->get($this->table)->result();
    }


	public function get_archive ($datearchive) {
        if (!isset($datearchive) || empty($datearchive))
            return array();

        $this->db->where('newsIsPublished', '1');
		//$match='2016-01-%';
		$this->db->like('newsCreatedOn',"$datearchive");
        //$this->db->like('newsCreatedOn','%2016-04-14%' );
        return $this->db->get($this->table)->result();
    }
*/


/**** update dotation ,tranche budget,=> del,aj   ***/

public function DelAJDoation($op='',$options,$mntDotation){

switch($op){

 case 'add':
 case 'ajouter':



 break;

 case 'edit':
 case 'modifier':

 break;

 case 'del':
 case 'supprimer':

 $idDotation = parent::updateiav($options, $conditions, $modified_on_field = 'udate_dotation_mission','id_dotation_mission');

 return $idDotation;

 break;
 default:
 break;

 }
}

/**** update dotation ,tranche budget,=> del,aj   ***/



/***** Lister les missions par matricule ****/
       public function GetMissonsByMPatricue($idMatr)
    {
      $sql = 'SELECT * FROM `iav_mission` inner join iav_typemission on (iav_mission.id_typemission =  iav_typemission.id_typemission) inner join iav_vehicule on (iav_vehicule.id_vehicule = iav_mission.id_vehicule ) where iav_vehicule.id_vehicule = "' . $idMatr . '" ORDER BY iav_mission.id_mission DESC';

        $query      = $this->db->query($sql);
        return $query->result();
    }

     /***** Lister les missions par matricule ****/

      /************* Get chauffeur By mission ***************/

     public function getChauffeurByMission($idMatr)
    {
      $sql = 'SELECT * FROM `iav_mission` inner join iav_chauffeur on (iav_mission.id_chauffeur =  iav_chauffeur.id_chauffeur)  where iav_mission.id_mission = "' . $idMatr . '" AND iav_mission.deleted_mission="N"';

        $query      = $this->db->query($sql);
        return $query->row();
    }
      /************* Get chauffeur By mission ***************/


      /****** Get dotation Tranche ***/


     public function getDotationTranche($typeBudget='',$annee=''){


$sql = "select * from iav_tranche_budget inner join iav_type_budget__annee_montant on
(iav_tranche_budget.id_type_budget_Annee_montant = iav_type_budget__annee_montant.id_type_budget__Annee_montant)
inner join iav_type_budget on (iav_type_budget.id_type_budget = iav_type_budget__annee_montant.id_type_budget)
inner join iav_annee_budget on (iav_annee_budget.id_annee_budget = iav_type_budget__annee_montant.id_annee_budget)
where iav_type_budget.libelle_type_budget ='" . $typeBudget ."' and iav_annee_budget.libelle_annee ='" . $annee . "' ORDER BY iav_tranche_budget.id_tranche_budget DESC
limit 1";

 $query      = $this->db->query($sql);
        return $query->row();

     }

      /**** et dotation Tranche **/

       //*** gestion dotation transport
       public function getdotationsTransport($id = null,$idtypebudget)
          {
             $sql_date      = "select libelle_annee from iav_annee_budget where valide_annee = 'E' and deleted_annee= 'N' ";
             $query         = $this->db->query($sql_date);
             $anne_valider  = date('Y');
             $anne_valider_sql  = $query->result();
             if(count($anne_valider_sql) != 0){
               $anne_valider = $anne_valider_sql[0]->libelle_annee;
             }
             $sql = "select  dotMiss.km_vehicule,dotMiss.id_dotation_mission,dotMiss.date_dotation,dotMiss.montant_dotation_mission,tb.libelle_type_budget,miss.itineraire_mission,miss.numero_ordre_mission,
             vcl.matricule_vehicule,chf.nom_chauffeur,chf.prenom_chauffeur,miss.id_mission,vcl.id_vehicule,chf.id_chauffeur,miss.list_mission_enseignant,miss.list_mission_externes
              from iav_dotation_mission as dotMiss ,  iav_mission as miss , iav_type_budget as tb, iav_chauffeur as chf , iav_vehicule as vcl where
             dotMiss.mission_id_mission = miss.id_mission AND
             dotMiss.id_type_budget     = tb.id_type_budget AND
             miss.id_chauffeur          = chf.id_chauffeur AND
             miss.id_vehicule           = vcl.id_vehicule AND dotMiss.deleted_dotation_mission = 'N' AND dotMiss.id_type_budget = '".$idtypebudget."'  and YEAR(dotMiss.date_dotation) = '".$anne_valider."'  ";
             if($id != null){
               $sql = $sql." AND dotMiss.id_dotation_mission = '".$id."'";
             }
             $query      = $this->db->query($sql);
            return $query->result();

            // print_r($query->result());
            // die();
          }
     // end gestion dotation transport


/***** dotation carbutant khalid ***/
       public function modifDotation($id=null){
        $sql="select * from iav_dotation_mission inner join iav_mission on ( iav_dotation_mission.mission_id_mission = iav_mission.id_mission)
inner join iav_vehicule on ( iav_vehicule.id_vehicule = iav_mission.id_vehicule)
where iav_dotation_mission.id_dotation_mission ='" .$id . "'";



$query    = $this->db->query($sql);
return $query->result();


       }



   /** update ****/

   public function updateDotation($id=null){
$sql="select * from iav_dotation_mission inner join iav_tranche_budget on (iav_dotation_mission.id_tranche_budget = iav_tranche_budget.id_tranche_budget)
where iav_dotation_mission.id_dotation_mission'". $id ."'";


$query    = $this->db->query($sql);
return $query->result();

   }

   /**** update ***/

       /******* dotation carburant ***/
   // *** mahfoude function last ****
  public function delete_all_data_budget($id_budgetAnnul){
	  $sql = "update iav_dotation_mission set deleted_dotation_mission = 'O' where id_tranche_budget in (select id_tranche_budget from iav_tranche_budget where id_type_budget_Annee_montant = '".$id_budgetAnnul."')";
      $query    = $this->db->query($sql);
  }
   // **** end mahfoude function last **
}
