<?php defined('BASEPATH') or exit('No direct script access allowed');

class Iav_annee_budget_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'iav_annee_budget';
        $this->table_id = 'id_annee_budget';
    }
    public function modifierAllexercice($id)
    {
      $slq = "update iav_annee_budget set valide_annee = 'NE' where id_annee_budget != ".$id." ";
      $query      = $this->db->query($slq);
      return $query->result();
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
/*une fonction qui nous donne l'id de l'année budgetaire actuelle*/
public function GetIdAnneeNow(){
    $sql = "select id_annee_budget from iav_annee_budget where libelle_annee=2020";
    $query = $this->db->query($sql);
    return $query;
}



}
