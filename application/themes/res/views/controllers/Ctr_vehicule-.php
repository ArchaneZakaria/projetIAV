<?php defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/Master.php';

class Ctr_vehicule extends Master
{

  public function index($data = '')
  {

     $this->display($data);
    /* $this->set_breadcrumb(array("" => ''));*/
    $this->template->set_partial('container', 'list_vehicule_view', array('data' => $data));
     $this->template->title('dd','ee')
                    ->build('body');
  }


  public function vehicule($data = '')
  {

     $this->display($data);
    /* $this->set_breadcrumb(array("" => ''));*/


                    switch($data){


               case 'add':
                case    'ajouter':
$this->template->set_partial('container', 'add_update_vehicule_view', array('data' => $data));

               break;

               case 'edit':
               case    'modifier':
 $this->template->set_partial('container', 'add_update_vehicule_view', array('data' => $data));

               break;

              case 'del':
              case  'supprimer':
 $this->template->set_partial('container', 'del_vehicule_view', array('data' => $data));

               break;

               default:
$this->template->set_partial('container', 'list_vehicule_view', array('data' => $data));

              }

    $this->template->title('dd','ee')
          ->build('body');

  }




}
?>
