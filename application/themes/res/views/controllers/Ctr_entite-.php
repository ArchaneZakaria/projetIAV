<?php defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/Master.php';

class Ctr_entite extends Master
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
  public function index($data = '')
  {

     $this->display($data);
    $this->set_breadcrumb(array('Liste des entitées' =>''));
    $this->template->set_partial('container', 'entite', array('data' => $data));
     $this->template->title('dd','ee')
                    ->build('body');
  }

/*  public function addEntite($data = '')
  {

      $this->display($data);
      $this->set_breadcrumb(array('Ajouter Entitées' =>''));
      $this->template->set_partial('container', 'add_entite', array('data' => $data));
      $this->template->title('dd','ee')
                    ->build('body');
  }
*/

   public function entite($data = ''){


              $this->display($data);

              switch($data){

               case 'add':
  $this->set_breadcrumb(array('Ajouter Entitées' =>''));
 $this->template->set_partial('container', 'add_entite_view', array('data' => $data));

               break;

              case 'del':
 $this->template->set_partial('container', 'gerer_dotation_reaparation_view', array('data' => $data));

               break;

                 case 'edit':
 $this->template->set_partial('container', 'utilisateur_view', array('data' => $data));

               break;

               default:
 $this->template->set_partial('container', 'list_entite_view', array('data' => $data));

              }

 $this->template->title('dd','ee')
                    ->build('body');


   }



}
