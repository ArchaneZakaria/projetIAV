<?php defined('BASEPATH') or exit('No direct script access allowed');

class Iav_model_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'iav_model';
        $this->table_id = 'id_model';
    }

}
