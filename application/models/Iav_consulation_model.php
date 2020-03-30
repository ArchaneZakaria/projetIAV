<?php defined('BASEPATH') or exit('No direct script access allowed');

class Iav_consulation_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'iav_consultation';
        $this->table_id = 'id_consultation';
    }
    public function getconsulations($id = null)
    {
      $sql = "select 	frnss.nom_fournisseur,frnss.ville_fournisseur,frnss.tel_fournisseur,frnss.email_fournisseur,cnslt.montant_consutation  from iav_consultation as cnslt,iav_fournisseur as frnss where
             cnslt.iav_fournisseur_id_fournisseur = frnss.id_fournisseur ";
             if($id != null){
               $sql = $sql." and cnslt.id_reparation = '".$id."'";
             }
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




}
