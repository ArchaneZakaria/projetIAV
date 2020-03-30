<?php defined('BASEPATH') or exit('No direct script access allowed');

class Iav_chauffeur_model extends MY_Model {


    function __construct() {
        parent::__construct();
        $this->table = 'iav_chauffeur';
        $this->table_id = 'id_chauffeur';
    }

    public function create ($options,  $created_on_field = 'cdate_chauffeur') {
      $idDep = $options['id_departement'];
      $idPer = parent::create($options, $created_on_field);
    }
    public function listeChauffeurs(){
      $sql="select chf.id_chauffeur,chf.nom_chauffeur as nom ,chf.prenom_chauffeur as prenom,
      chf.grade_chauffeur as grade,chf.code_chauffeur as code,chf.Echel,chf.tel as tel,
      dpt.libeller_departement from iav_chauffeur as chf,
      iav_departement as dpt where dpt.id_departement=chf.id_departement and deleted_chauffeur = 'N'
       ";
      $query = $this->db->query($sql);
      return $query;
    }
    public function delete($idChauffeur)
    {
        $result = $this->update(array('deleted_chauffeur'=>'O'),array('id_chauffeur'=>$idChauffeur),'ddate_chauffeur');
	    return $result;
    }
    public function getById($id){
      $sql="select etab.libelle_etablissement,chf.id_chauffeur ,chf.Echel,chf.nom_chauffeur,chf.prenom_chauffeur,chf.tel,
       chf.grade_chauffeur,chf.date_retraite,chf.code_chauffeur,dpt.libeller_departement as depart,
       dpt.id_departement as id_deprt from iav_chauffeur as chf,iav_departement as dpt,etablissement etab
       where chf.id_departement=dpt.id_departement AND
             etab.id_etablissement = dpt.id_etablissement AND
       chf.id_chauffeur ='".$id."'";
      $query = $this->db->query($sql);
      return $query;
    }
    public function modifier($options) {
      $id_ch = $options['id_chauffeur'];
      unset($options['id_chauffeur']);
      $date = date_create('now')->format('Y-m-d H:i:s');
      $options['udate_chauffeur'] = $date;
      $this->db->where($this->table_id,$id_ch);
      $this->db->update($this->table, $options);
    }
/*
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
