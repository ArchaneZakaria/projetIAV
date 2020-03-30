<?php defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/Master.php';

class Gestion extends Master
{

function __construct()
    {
        parent::__construct();
    }



    public function index($lang = '')
    {


             /** verifier l'ouverture de session */
      $this->display('');
        $this->template->set_partial('container', 'home_view',array());
        $this->template->build('body');



    }




}

?>
