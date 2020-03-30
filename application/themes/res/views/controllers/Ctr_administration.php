<?php defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/Master.php';

class Ctr_administration extends Master
{


   function __construct() {
        parent::__construct();
      $this->load->model('Iav_personnel_model', 'etablissement');
    }

  public function index($data = '')
  {

     $this->display($data);
    /* $this->set_breadcrumb(array("" => ''));*/
    $this->template->set_partial('container', 'affectcationDroit_view', array('data' => $data));
     $this->template->title('dd','ee')
                    ->build('body');
  }

/*
===================gestion du transport =========
*/

   public function typeUtilisateur($data = ''){

  $this->display($data);

              switch($data){

               case 'add':
 $this->template->set_partial('container', 'add_type_utilisateurs_view', array('data' => $data));

               break;

               case 'del':
 $this->template->set_partial('container', 'demand_dotation_carburant_view', array('data' => $data));

               break;

              case 'edit':
 $this->template->set_partial('container', 'gerer_dotation_carburant_view', array('data' => $data));

               break;

               default:


              }

 $this->template->title('dd','ee')
                    ->build('body');

   }


/*
======================gestion du transport=============
*/
 public function utilisateur($data = ''){


              $this->display($data);

              switch($data){

               case 'add':
 $this->template->set_partial('container', 'add_utilisateur_view', array('data' => $data));

               break;

              case 'del':
 $this->template->set_partial('container', 'gerer_dotation_reaparation_view', array('data' => $data));

               break;

                 case 'edit':
 $this->template->set_partial('container', 'utilisateur_view', array('data' => $data));

               break;

               default:
 $this->template->set_partial('container', 'utilisateur_view', array('data' => $data));

              }

 $this->template->title('dd','ee')
                    ->build('body');


   }





}
?>
