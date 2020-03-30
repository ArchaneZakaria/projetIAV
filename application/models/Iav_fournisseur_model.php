<?php defined('BASEPATH') or exit('No direct script access allowed');

class Iav_fournisseur_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'iav_fournisseur';
        $this->table_id = 'id_fournisseur';
    }
    //creation d'un fournisseur avec l'appel d'une fonction parent
    public function create ($options,$cdate_fournisseur = 'cdate_fournisseur') {
        return parent::create($options,$cdate_fournisseur);
    }
    //get tout les fournisseurs non deleted
    public function Getfournisseurs()
    {
      $sql = "select frn.id_fournisseur,frn.nom_fournisseur,frn.ville_fournisseur,frn.tel_fournisseur,
      frn.email_fournisseur,dmn.libelle_domaineactivite	from iav_fournisseur as frn,iav_domaineactivite as dmn
      where frn.id_domaineactivite = dmn.id_domaineactivite AND frn.deleted_fournisseur='N' AND module ='BM' ";
      $query = $this->db->query($sql);
      return $query;
    }
    //fonction DeleteByupdate est une fonction d'update utilise pour la suppr
    public function DeleteByupdate($conditions)
    {
        $date = date_create('now')->format('Y-m-d H:i:s');
      	$options = array('deleted_fournisseur' => 'O' , 'ddate_fournisseur' => $date);
        $this->db->where($this->table_id,$conditions['id']);
        return $this->db->update($this->table, $options);
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
