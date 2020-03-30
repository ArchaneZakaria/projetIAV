<?php defined('BASEPATH') or exit('No direct script access allowed');

class  Iav_article_reparation_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'iav_article_reparation';
        $this->table_id = 'id_article_reparation';
    }
}
