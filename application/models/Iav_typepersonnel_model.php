<?php defined('BASEPATH') or exit('No direct script access allowed');

class Iav_typepersonnel_model extends MY_Model {

    private $CI;

    function __construct() {
        parent::__construct();
        $this->table = 'iav_typepersonel';
        $this->table_id = 'id_typepersonel';
    }

    public function Get_id_pr_type($type)
    {
      $sql="select id_typepersonel from iav_typepersonel where 	libeller_typepersonel='".$type."'";
      $query = $this->db->query($sql);
      return $query->result();
    }
  }
