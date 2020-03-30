<?php defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/Master.php';

class Ctr_home extends Master
{


  /**
   * Index Page for this controller.
   *
   * Maps to the following URL
   *    http://example.com/index.php/welcome
   *  - or -
   *    http://example.com/index.php/welcome/index
   *  - or -
   * Since this controller is set as the default controller in
   * config/routes.php, it's displayed at http://example.com/
   *
   * So any other public methods not prefixed with an underscore will
   * map to /index.php/welcome/<method_name>
   * @see https://codeigniter.com/user_guide/general/urls.html
   */

  function __construct() {
      parent::__construct();
    //   $this->load->model('Iav_mission_model', 'mission');
    //   $this->load->model('Iav_type_budget_model', 'typebudget');
    //   $this->load->model('Iav_type_budget__annee_montant', 'typeannemontant');
    //   $this->load->model('Iav_annee_budget_model', 'annee');
    //   $this->load->model('Iav_tranche_budget_model', 'tranche');
    //   $this->load->model('Iav_departement_model', 'departement');
    //   $this->load->model('Iav_dotation_mission_model', 'dotation');
    //   $this->load->model('Iav_mission_model', 'mission');
    //   $this->load->model('Iav_chauffeur_model', 'chauffeur');
	  // $this->load->model('Iav_vehicule_model', 'vehicule');

       date_default_timezone_set('Africa/Casablanca');
  }


  public function index($data = ''){
    //$this->display($data);

	//end calendrier

    //zdaecho '<pre>';print_r($resultVehicules);die();
    $this->template->set_partial('container', 'home_view',array('data'               => $data));
   $this->template->title('IAV','Acceuil')->build('body');
  }
  public function error(){

   $this->load->view('view_404');
  }

}
