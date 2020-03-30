<?php defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/Master.php';

class Ctr_marche_fourniture extends Master
{

    function __construct()
    {
        parent::__construct();

     // $this->load->model('Retraite_model', 'retraite');
     // $this->load->model('Piece_jointe_retraite_model', 'validation');
      date_default_timezone_set('Africa/Casablanca');
    }



    public function index($lang = '')
  {
            $this->display($lang);
             /** verifier l'ouverture de session */
            $op_modal = $this->load->view('modals/admin/op_modall', '', true);
            $this->template->set_partial('container', 'phase/list_phase_bncommade_view',array('op_modal' => $op_modal ));
            $this->template->build('body');
    }

    public function marche($data = '',$id = NULL){
            $this->display($data);
            switch($data){
                                                //creer un marché fourniture
             case 'add':

           $this->set_breadcrumb(array("Créer un marché fourniture" => 'mission/add'));
           $this->template->set_partial('container', 'marche/creermarchefourniture_view', array('data' => $data));
           $this->template->title('SuivibM','Bon de commande,marche')
                  ->build('body');
             break;
                                            //liste des marché fourniture en cours

             case 'marchefournitureec':

                $this->set_breadcrumb(array("Marché fourniture en cours" => 'mission/marchefournitureec'));
                $this->template->set_partial('container', 'marche/marchefournitureencours_view', array('data' => $data));
                $this->template->title('SuivibM','Bon de commande,marche')
                       ->build('body');
                  break;
                                            //liste des marché fourniture validés
                  case 'marchefournitureva':

                $this->set_breadcrumb(array("Marché fourniture validés" => 'mission/marchefournitureva'));
                $this->template->set_partial('container', 'marche/marchefourniturevalide_view', array('data' => $data));
                $this->template->title('SuivibM','Bon de commande,marche')
                        ->build('body');
                    break;
                                                //liste des marché fourniture récéptionnés
                    case 'marchefourniturere':

                $this->set_breadcrumb(array("Marché fourniture récéptionnés" => 'mission/marchefourniturere'));
                $this->template->set_partial('container', 'marche/marchefourniturereceptionnes_view', array('data' => $data));
                $this->template->title('SuivibM','Bon de commande,marche')
                        ->build('body');
                    break;
                                                    //liste des marché fourniture annulés
                    case 'marchefourniturean':

                        $this->set_breadcrumb(array("Marché fourniture annulés" => 'mission/marchefourniturean'));
                        $this->template->set_partial('container', 'marche/marchefournitureannules_view', array('data' => $data));
                        $this->template->title('SuivibM','Bon de commande,marche')
                                ->build('body');
                            break;
                    
             

             default:
    $op_modal = $this->load->view('modals/admin/op_modall', '', true);

   $this->template->set_partial('container', 'prolongation_view', array('data' => $data,'op_modal' => $op_modal));
   $this->template->title('dd','ee')
                  ->build('body');
            break;
            }




  }




}
/* End of file home.php */
/* Location: ./application/controllers/home.php */
