<?php defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/Master.php';

class Ctr_phase extends Master
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

    public function phase($data = '',$id = NULL){
            $this->display($data);
            switch($data){

             case 'add':

           $this->set_breadcrumb(array("créer une phase" => 'mission/add'));
           $this->template->set_partial('container', 'phase/add_update_phase_view', array('data' => $data));
           $this->template->title('SuivibM','Bon de commande,marche')
                  ->build('body');
             break;


             case 'lbncommande':


             $etat_update= '';
             $conditions = $this->input->post('id');

             $op_modal = $this->load->view('modals/admin/op_modall', '', true);
             $this->set_breadcrumb(array("liste des phases des bons de commande" => 'mission/lmarchetravaux'));
            $this->template->set_partial('container', 'phase/list_phase_bncommade_view', array('data' => $data,'op_modal' => $op_modal));
            $this->template->title('dd','ee')
                           ->build('body');
         //
         //    $etat_update= '';
         //   $conditions = $this->input->post('id');
         //
         //   /*  if (!is_array($conditions) && intval($conditions))
         //   $conditions = array('id_etablissement' => intval($conditions));
         //
         // $etat_delete = $this->db->delete('etablissement', $conditions);*/
         //  $this->retraite->update(array('notif_retraite'=>'V'),$conditions);
         //
         //    echo json_encode(array('status' => '200',
         //                           'url' => 'accueil/encours',
         //                        'message' => 'la retraite est en cours de traitement' ));
              break;

              case 'lmarchetravaux':

            $etat_update= '';
            $conditions = $this->input->post('id');

            $op_modal = $this->load->view('modals/admin/op_modall', '', true);
            $this->set_breadcrumb(array("liste des phases des marché travaux" => 'mission/lmarchetravaux'));
           $this->template->set_partial('container', 'phase/list_phase_marchetravaux_view', array('data' => $data,'op_modal' => $op_modal));
           $this->template->title('dd','ee')
                          ->build('body');
               break;


               case 'lmarchefouriture':
               $etat_update= '';
               $conditions = $this->input->post('id');

               $op_modal = $this->load->view('modals/admin/op_modall', '', true);
               $this->set_breadcrumb(array("liste des phases des marché fourniture" => 'mission/lmarchetravaux'));
              $this->template->set_partial('container', 'phase/list_phase_marchefourniture_view', array('data' => $data,'op_modal' => $op_modal));
              $this->template->title('dd','ee')
                             ->build('body');
                break;

              //  case 'edit':
              //
              // if (($id = intval($id)) && !empty($id) && ($etablissement = $this->etablissement->read("*",array('id_etablissement' => $id)))) {
              //   $hidden = array('id_etablissement' => $id);
              //
              //  $this->template->set_partial('container', 'add_etablissement_view', array('data' => $data,'etablissement' => (array) $etablissement[0],'hidden' => $hidden,'op_btn_value' => 'Modifier'));
              //  }else{
              // redirect(base_url('etablissement'));
              //  }

                  //$this->template->set_partial('container', 'add_etablissement_view', array('data' => $data));
                  // $this->template->title('dd','ee')
                  // ->build('body');
                  //  break;

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
