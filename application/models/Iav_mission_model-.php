<?php defined('BASEPATH') or exit('No direct script access allowed');

class Iav_mission_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'iav_mission';
        $this->table_id = 'id_mission';
    }

    public function create ($options,  $created_on_field = 'cdate_mission') {
      $idPer = parent::create($options, $created_on_field);
      return $idPer;
    }


/*** association personnel mission **/
    public function insert_mission_personnel($idPer='',$idMiss=''){

$post_data = array('iav_personel_id_personel'=> $idPer,'iav_mission_id_mission'=>$idMiss);
$this->db->insert('iav_personnel_mission',$post_data);
return $this->db->insert_id();

    }
/*** association personnel mission **/

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
