<?php defined('BASEPATH') or exit('No direct script access allowed');

class Piece_jointe_retraite_model extends MY_Model {

    // par ce parameter CI nous pouvons utiliser des models
    private $CI;

    function __construct() {
        parent::__construct();
        $this->table = 'piece_jointe_retraite';
        $this->table_id = 'id_piece_jointe_retraite';
        //charger CI
        $this->CI =& get_instance();
        // on utilisant CI on charge d'autre models
        $this->CI->load->model('piece_jointe_retraite_model');
    }



}
