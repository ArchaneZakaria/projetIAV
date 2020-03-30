<?php defined('BASEPATH') or exit('No direct script access allowed');

class Iav_domaine_actv_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table    = 'iav_domaineactivite';
        $this->table_id = 'id_domaineactivite';
    }

    public function create ($options,$cdate = 'cdate_domaineactivite') {
        return parent::create($options,$cdate);
    }

    /** domainde  d'activité marche bon de commande **/
    public function GetAllDomaineM()
    {
      $sql = "select * from iav_domaineactivite where module ='bm' and deleted_domaineactivite='0'";
      $query = $this->db->query($sql);
      return $query;
    }
        /** domainde  d'activité marche bon de commande **/
    public function GetAllDomaine()
    {
      $sql = "select * from iav_domaineactivite";
      $query = $this->db->query($sql);
      return $query;
    }
    public function delete($idDomaine)
    {
      $this->db->where($this->table_id,$idDomaine);
	    $result= $this->db->delete($this->table);
	    return $result;
    }
    public function GetDomaineById($id)
    {
      $sql = "select id_domaineactivite,libelle_domaineactivite from iav_domaineactivite
             where id_domaineactivite = '".$id."'";
     $query = $this->db->query($sql);
     return $query;
    }
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




}
