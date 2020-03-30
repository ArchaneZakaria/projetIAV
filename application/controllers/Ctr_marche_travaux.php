<?php defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/Master.php';

class Ctr_marche_travaux extends Master
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
            $this->load->model('iav_type_budget_model');
            
            $typeBudget= $this->iav_type_budget_model->GetAllTypeBudget();
            
            switch($data){
                                          //creer un marché travaux
             case 'add':

           $this->set_breadcrumb(array("Créer un marché travaux" => 'mission/add'));
           $this->template->set_partial('container', 'marche/creermarchetravaux_view', array('data' => $data,'typeBudget' =>$typeBudget,'prefix'=>'MarcheTravaux'));
           $this->template->title('SuivibM','Bon de commande,marche')
                  ->build('body');
             break;

                                           //liste des marchés travaux en cours
             case 'marchetravauxec':

                $this->set_breadcrumb(array("Marché travaux en cours" => 'mission/marchetravauxec'));
                $this->template->set_partial('container', 'marche/marchetravauxencours_view', array('data' => $data));
                $this->template->title('SuivibM','Bon de commande,marche')
                       ->build('body');
                  break;

                                             //liste des marchés travaux validés
                  case 'marchetravauxva':

                $this->set_breadcrumb(array("Marché travaux validés" => 'mission/marchetravauxva'));
                $this->template->set_partial('container', 'marche/marchetravauxvalide_view', array('data' => $data));
                $this->template->title('SuivibM','Bon de commande,marche')
                        ->build('body');
                    break;
                                               //liste des marchés travaux récéptionnés
                    case 'marchetravauxre':

                $this->set_breadcrumb(array("Marché travaux récéptionnés" => 'mission/marchetravauxre'));
                $this->template->set_partial('container', 'marche/marchetravauxreceptionnes_view', array('data' => $data));
                $this->template->title('SuivibM','Bon de commande,marche')
                        ->build('body');
                    break;
                                                   //liste des marchés travaux annulés
                    case 'marchetravauxan':

                        $this->set_breadcrumb(array("Marché travaux annulés" => 'mission/marchetravauxan'));
                        $this->template->set_partial('container', 'marche/marchetravauxannules_view', array('data' => $data));
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


  public function Ajouter_marche_travaux()
  {
    
    $this->load->model('iav_annee_budget_model');
    $idAnnee=$this->iav_annee_budget_model->GetIdAnneeNow();
    $this->load->library('form_validation');
    $this->load->model('offre_model');
    $this->form_validation->set_rules('NumeroAppelOffre', 'Le numéro d\'appel d\'offre est obligatoire', 'required|trim',
                                 array('required' => 'Le numéro d\'appel d\'offre est obligatoire'));
    $this->form_validation->set_rules('Estimation', 'L\'estimation est obligatoire', 'required|trim',
    array('required' => 'L\'estimation obligatoire'));
    $this->form_validation->set_rules('Objet', 'L\'objet est obligatoire', 'required|trim',
    array('required' => 'L\'objet obligatoire'));
    $this->form_validation->set_rules('NumeroMarche', 'Le numéro du marché est obligatoire', 'required|trim',
    array('required' => 'Le numéro du marché est obligatoire'));
    $this->form_validation->set_rules('DateOuverturePlis', 'La date d\'ouverture du plis est obligatoire', 'required|trim',
    array('required' => 'La date d\'ouverture du plis est obligatoire'));
      if ($this->form_validation->run()) {

              $numAO          = $this->input->post('NumeroAppelOffre');
              $objet       = $this->input->post('Objet');
              $estimation       = $this->input->post('Estimation');
              $budget          =$this->input->post('Budget');
              $DateOuverturePlis       = $this->input->post('DateOuverturePlis');
              $NumeroMarche        = $this->input->post('NumeroMarche');
              $MontantMarche       = $this->input->post('MontantMarche');
              $DateEngagement     = $this->input->post('DateEngagement');
              $DateCautionDefinitive     = $this->input->post('DateCautionDefinitive');
              $DateOrdreService       = $this->input->post('DateOrdreService');
              $DateAchevementPrestation     = $this->input->post('DateAchevementPrestation');
              $AutresInformations     = $this->input->post('AutresInformations');
              $PiecesJointes     = $this->input->post('PiecesJointes');
              $idTypeOffre=2;
              $id_annee_budget=9;
              $options     = array (
                                     'N_AO'   => $numAO,
                                     'objet' => $objet,
                                     'estimation' => $estimation,
                                     'id_type_budgetM'   => $budget,
                                    'date_ouverture_plis' =>$DateOuverturePlis,
                                    'no_marche' =>$NumeroMarche,
                                    'montant_marche' =>$MontantMarche,
                                    'date_engagement' =>$DateEngagement,
                                    'date_caution_definitive' =>$DateCautionDefinitive,
                                    'date_ordre_service' =>$DateOrdreService,
                                    'date_achevement_prestation' =>$DateAchevementPrestation,
                                    'autres_informations' =>$AutresInformations,
                                    'id_type_offre' =>$idTypeOffre,
                                    'id_annee_budget'=>$id_annee_budget
                                    );
        
          $result      = $this->offre_model->create($options);
          $message = "Vos informations ont été ajoutées avec succès.";
          echo json_encode(array( 'status' => '1',
                                  'location' => 'url',
                                  'message' => $message));
        $this->do_upload();
      }else {
          $errors = validation_errors();
          echo json_encode(array( 'status' => '0',
                                  'location' => 'url',
                                  'message' => $errors));
        }

  }
  public function do_upload()
  {
          $config['upload_path']          = './uploads/';
          $config['allowed_types']        = 'gif|jpg|png';
          $config['max_size']             = 100;
          $config['max_width']            = 1024;
          $config['max_height']           = 768;

          $this->load->library('upload', $config);

         $this->upload->do_upload('userfile');
  }
}
/* Endn  of file home.php */
/* Location: ./application/controllers/home.php */
