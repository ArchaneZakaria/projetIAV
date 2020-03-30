<?php defined('BASEPATH') or exit('No direct script access allowed');

class Phase_typeoffre_model extends MY_Model {

    private $color;
    function __construct() {
        parent::__construct();
        $this->table = 'phase_typeoffre';
        $this->table_id = 'id_phase_typeoffre';
        $this->color = array('1'=>"#ff6699",'2'=>'#ffcc00','3'=>"#66ff33",'4'=>"#003300",'5'=>"#ff0000",
                            '6'=>'#0000ff','7'=>'#669999','8'=>'#cc9900','9'=>'#6600cc','10'=>'#996633');
    }



}
