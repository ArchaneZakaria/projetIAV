<?php defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/Master.php';

class Ctr_commande extends Master
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
            $this->template->set_partial('container', 'bncommande/list_bncommande_view',array('op_modal' => $op_modal ));
            $this->template->build('body');
    }

    public function commande($data = '',$id = NULL){
            $this->display($data);
            switch($data){

             case 'add':

           $this->set_breadcrumb(array("lancer un bon de commande" => 'mission/add'));
           $this->template->set_partial('container', 'bncommande/add_update_bncommande_view', array('data' => $data));
           $this->template->title('SuivibM','Bon de commande,marche')
                  ->build('body');
             break;

                                      //liste des bon de commande en cours
             case 'listbcec':
              $this->set_breadcrumb(array("liste des bons de commandes en cours" => 'mission/listbcec'));
           $this->template->set_partial('container', 'bncommande/list_bncommande_encours_view', array('data' => $data));
           $this->template->title('SuivibM','Bon de commande,marche')
                  ->build('body');
             break;

                                      //liste des bon de commande en validé
             case 'listbcv':
              $this->set_breadcrumb(array("liste des bons de commandes validés" => 'mission/listbcv'));
           $this->template->set_partial('container', 'bncommande/list_bncommande_valide_view', array('data' => $data));
           $this->template->title('SuivibM','Bon de commande,marche')
                  ->build('body');
             break;

                                      //liste des bon de commande receptionnés
             case 'listbcr':
              $this->set_breadcrumb(array("liste des bons de commandes réceptionnés" => 'mission/listbcr'));
           $this->template->set_partial('container', 'bncommande/list_bncommande_receptionne_view', array('data' => $data));
           $this->template->title('SuivibM','Bon de commande,marche')
                  ->build('body');
             break;

                                      //liste des bon de commande annulés
             case 'listbca':
              $this->set_breadcrumb(array("liste des bons de commandes annulés" => 'mission/listbca'));
           $this->template->set_partial('container', 'bncommande/list_bncommande_annule_view', array('data' => $data));
           $this->template->title('SuivibM','Bon de commande,marche')
                  ->build('body');
             break;
            case 'up':
              
           $etat_update= '';
          $conditions = $this->input->post('id');

          /*  if (!is_array($conditions) && intval($conditions))
          $conditions = array('id_etablissement' => intval($conditions));

        $etat_delete = $this->db->delete('etablissement', $conditions);*/
         $this->retraite->update(array('status_prolongation'=>'V'),$conditions);

           echo json_encode(array('status' => '200',
                                  'url' => 'prolongation',
                               'message' => 'la prolongation a été annulé avec succes'));
             break;

             case 'ret':

            $etat_update= '';
           $conditions = $this->input->post('id');

           /*  if (!is_array($conditions) && intval($conditions))
           $conditions = array('id_etablissement' => intval($conditions));

         $etat_delete = $this->db->delete('etablissement', $conditions);*/
          $this->retraite->update(array('notif_retraite'=>'V'),$conditions);

            echo json_encode(array('status' => '200',
                                   'url' => 'accueil/encours',
                                'message' => 'la retraite est en cours de traitement' ));
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
