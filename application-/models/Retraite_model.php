<?php defined('BASEPATH') or exit('No direct script access allowed');

class Retraite_model extends MY_Model {

    // par ce parameter CI nous pouvons utiliser des models
    private $CI;

    function __construct() {
        parent::__construct();
        $this->table = 'retraite';
        $this->table_id = 'id_retraite';
        //charger CI
        $this->CI =& get_instance();
        // on utilisant CI on charge d'autre models
      //  $this->CI->load->model('piece_jointe_retraite_model');
        
    }


    public function create ($options, $created_on_field = 'cdate_retraite') {
          return parent::create($options, $created_on_field);
      }

    public function update ($options, $conditions = array(), $modified_on_field = 'udate_retraite') {
          return parent::updateiav($options, $conditions, $modified_on_field,'id_retraite');
      }




}
