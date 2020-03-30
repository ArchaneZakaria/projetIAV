<?php defined('BASEPATH') or exit('No direct script access allowed');

class Iav_reparation_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'iav_reparation';
        $this->table_id = 'id_reparation';
    }
    public function GetReparationEnCours($id = null,$id_chauffeur = null,$id_vcl = null,$id_entr = null,$date_d = null,$date_f = null)
    {
      $sql_date      = "select libelle_annee from iav_annee_budget where valide_annee = 'E' and deleted_annee= 'N'";
      $query         = $this->db->query($sql_date);
      $anne_valider  = date('Y');
      $anne_valider_sql  = $query->result();
      if(count($anne_valider_sql) != 0){
        $anne_valider = $anne_valider_sql[0]->libelle_annee;
      }
      $sql ="select rep.id_reparation,rep.cdate_reparation,vcl.matricule_vehicule,typerep.libelle_type_reparation,rep.status_reparation,
             chf.nom_chauffeur,chf.prenom_chauffeur,chf.id_chauffeur,vcl.id_vehicule,rep.kilometrage_vehicule,typerep.id_type_reparation
       from iav_reparation rep ,iav_vehicule as vcl ,iav_chauffeur as chf,iav_type_reparation as typerep  where
       rep.id_type_reparation = typerep.id_type_reparation and
       rep.iav_vehicule_id_vehicule = vcl.id_vehicule and
       rep.iav_chauffeur_id_chauffeur = chf.id_chauffeur and rep.status_reparation NOT IN('XX','EX') and YEAR(rep.cdate_reparation) = '".$anne_valider."' and rep.deleted_operation = 'N' ";
       if($id != null){
         $sql = $sql." and rep.id_reparation = '".$id."'";
       }
       if($id_chauffeur != 0){
          $sql = $sql." and chf.id_chauffeur = '".$id_chauffeur."'";
       }
       if($id_vcl != 0){
         $sql = $sql." and vcl.id_vehicule = '".$id_vcl."'";
       }
       if($id_entr != 0){
         $sql = $sql." and typerep.id_type_reparation = '".$id_entr."'";
       }
       if($date_d != null){
         $sql = $sql." and rep.cdate_reparation >= '".$date_d."'";
       }
       if($date_f != null){
         $sql = $sql." and rep.cdate_reparation <= '".$date_f."'";
       }
       $sql = $sql." ORDER BY id_reparation DESC ";
       $query = $this->db->query($sql);
       return $query;
    }

    public function GetReparationEnCoursExecution($id = null,$id_chauffeur = null,$id_vcl = null,$id_entr = null,$date_d = null,$date_f = null){
      $sql_date      = "select libelle_annee from iav_annee_budget where valide_annee = 'E' and deleted_annee= 'N'";
      $query         = $this->db->query($sql_date);
      $anne_valider  = date('Y');
      $anne_valider_sql  = $query->result();
      if(count($anne_valider_sql) != 0){
        $anne_valider = $anne_valider_sql[0]->libelle_annee;
      }

      $sql ="select rep.id_reparation,rep.cdate_reparation,vcl.matricule_vehicule,typerep.libelle_type_reparation,rep.status_reparation,rep.prix_AM_reparation,rep.prix_PR_reparation
      ,rep.Mt_Total_reparation,chf.nom_chauffeur,chf.prenom_chauffeur,chf.id_chauffeur,vcl.id_vehicule,rep.kilometrage_vehicule,typerep.id_type_reparation,frnss.nom_fournisseur
       from iav_reparation rep ,iav_vehicule as vcl ,iav_chauffeur as chf,iav_type_reparation as typerep,iav_fournisseur as frnss  where 
       rep.id_type_reparation = typerep.id_type_reparation and
       rep.iav_vehicule_id_vehicule = vcl.id_vehicule and rep.id_fournisseur = frnss.id_fournisseur and
       rep.iav_chauffeur_id_chauffeur = chf.id_chauffeur and rep.status_reparation  IN('XX','EX')  and YEAR(rep.cdate_reparation) = '".$anne_valider."' and rep.deleted_operation = 'N' ";
       if($id != null){
         $sql = $sql." and rep.id_reparation = '".$id."'";
       }
       if($id_chauffeur != 0){
          $sql = $sql." and chf.id_chauffeur = '".$id_chauffeur."'";
       }
       if($id_vcl != 0){
         $sql = $sql." and vcl.id_vehicule = '".$id_vcl."'";
       }
       if($id_entr != 0){
         $sql = $sql." and typerep.id_type_reparation = '".$id_entr."'";
       }
       if($date_d != null){
         $sql = $sql." and rep.cdate_reparation >= '".$date_d."'";
       }
       if($date_f != null){
         $sql = $sql." and rep.cdate_reparation <= '".$date_f."'";
       }
       $sql = $sql." ORDER BY id_reparation DESC ";
       $query = $this->db->query($sql);
       return $query;
    }
/*
    public function create ($options) {
        return parent::create($options);
    }

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

public function delete_all_data_reparation($id_budget){
	$sql = "update iav_reparation set deleted_operation = 'O' where id_tranche_budget in (select id_tranche_budget from iav_tranche_budget where id_type_budget_Annee_montant = '".$id_budget."')";
      $query    = $this->db->query($sql);
}




}
