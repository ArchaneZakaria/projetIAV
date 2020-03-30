<?php defined('BASEPATH') or exit('No direct script access allowed');

class Iav_reglement_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'iav_reglement';
        $this->table_id = 'id_souche';
    }
}
