<?php defined('BASEPATH') or exit('No direct script access allowed');

class Etablissement_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'etablissement';
        $this->table_id = 'id_etablissement';
    }

  public function create ($options, $created_on_field = 'cdate_etablissement') {
        return parent::create($options, $created_on_field);
    }

  public function update ($options, $conditions = array(), $modified_on_field = 'udate_etablissement') {
        return parent::updateiav($options, $conditions, $modified_on_field,'id_etablissement');
    }

  public function delete($id = null){
    return  parent::deleteiav($id,'id_etablissement');
  }


 }
