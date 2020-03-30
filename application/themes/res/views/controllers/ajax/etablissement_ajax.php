<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/Master_user.php';

class Etablissement_ajax extends Master_user
{

    public function __construct()
    {
        parent::__construct();
     /* if (!$this->input->is_ajax_request())
            redirect(site_url());*/
      $this->load->model('Etablissement_model', 'etablissement');

    }


    public function ajouter(){

/*$searchvalue = $this->input->post('searchvalue');*/

echo json_encode(array(
                            'status' => '1',
                            'location' => 'url',
                            'message' => 'bienvenue <strong>' . 'test' . '</strong> !'));

    }




}
