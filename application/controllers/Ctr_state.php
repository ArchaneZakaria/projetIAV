<?php defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/Master.php';

class Ctr_state extends Master
{

    function __construct()
    {
        parent::__construct();

     $this->load->model('Retraite_model', 'retraite');
     $this->load->model('Piece_jointe_retraite_model', 'validation');
      date_default_timezone_set('Africa/Casablanca');
    }

    public function index($lang = '')
    {
            $this->display($lang);
             /** verifier l'ouverture de session */
            $op_modal = $this->load->view('modals/admin/op_modall', '', true);
            $this->template->set_partial('container', 'state_view',array('op_modal' => $op_modal ));
            $this->template->build('body');
    }






}
/* End of file home.php */
/* Location: ./application/controllers/home.php */
