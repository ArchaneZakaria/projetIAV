<?php defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/Master.php';

class Ctr_exercice extends Master
{
  function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Iav_annee_budget_model');

    }
  public function index($data = ''){
    $this->display($data);
     $this->set_breadcrumb(array("Ajouter une année" => ''));
    $annee = $this->Iav_annee_budget_model->read("*",array('deleted_annee'=>'N'));
    $this->template->set_partial('container', 'exercice/validation_exercice_view', array('data' => $data,'prefix'=>'exerice','annee'=>$annee));
    $this->template->title('Iav','validation Exerice')->build('body');
  }

  public function exercice($data = '',$id = null)
 {
    $this->display($data);
    $annee = $this->Iav_annee_budget_model->read("*",array('deleted_annee' => 'N'));
   /* $this->set_breadcrumb(array("" => ''));*/
   switch($data){
     case 'add':
     case    'ajouter':
     //$this->template->set_partial('container', 'add_domaineAcct_view', array('data' => $data));
     break;
     case 'edit':
     case 'modifier':
    // $this->set_breadcrumb(array("Modifier Année" => ''));
    $this->set_breadcrumb(array("Modifier Année" => ''));
    $annee_mdf = $this->Iav_annee_budget_model->read("*",array('id_annee_budget'=> $id));

    $this->template->set_partial('container', 'exercice/validation_exercice_view', array('data' => $data,
                                 'prefix'=>'exerice','annee' => $annee,
                                  'annee_mdf' => $annee_mdf));
     //$this->template->set_partial('container', 'add_update_prestataire_view', array('data' => $data));
     break;
     case 'del':
     case   'supprimer':
     //$this->template->set_partial('container', 'del_prestataire_view', array('data' => $data));
     break;
     default:
    $this->set_breadcrumb(array("Domaine d'activite" => ''));
    $this->template->set_partial('container', 'exercice/validation_exercice_view', array('data' => $data,'prefix'=>'exerice','annee'=>$annee));
    }
    $this->template->title('Exercice','IAV')
                   ->build('body');
    }

   public function addAnnee()
   {
     $this->form_validation->set_rules('annee', 'annee est obligatoire', 'required|trim',
                             array('required' => 'Le champs annee est obligatoire'));
        if ($this->form_validation->run()) {
            $annee       = $this->input->post('annee');
            $options = array(
              'libelle_annee'      => $annee
            );
         $result          = $this->Iav_annee_budget_model->read("*",array('libelle_annee'=>$annee,'deleted_annee'=>'N'));
         if(count($result) == 0){
              $result          = $this->Iav_annee_budget_model->create($options,'cdate_annee');
              $message = "Vos informations ont été ajoutées avec succès.";
              echo json_encode(array( 'status' => '1',
                                      'location' => 'url',
                                      'message' => $message));
         }else {
           $message = "L'année que vous avez saisie existe , verifiez vos informations.";
           echo json_encode(array( 'status' => '0',
                                   'location' => 'url',
                                   'message' => $message));

         }

         }else {
           $errors = validation_errors();
           echo json_encode(array( 'status' => '0',
                                   'location' => 'url',
                                   'message' => $errors));
         }
   }

   public function modifier_annee()
   {
     $this->form_validation->set_rules('annee', 'annee est obligatoire', 'required|trim',
                             array('required' => 'Le champs annee est obligatoire'));
        if ($this->form_validation->run()) {
              $annee       = $this->input->post('annee');
              $id          = $this->input->post('id');

              $result      = $this->Iav_annee_budget_model->update(array('libelle_annee' => $annee),array('id_annee_budget'=>$id),'udate_annee');
              $message = "Vos informations ont été modifiées avec succès.";
              echo json_encode(array( 'status' => '1',
                                      'location' => 'url',
                                      'message' => $message));
        }else {
          $errors = validation_errors();
          echo json_encode(array( 'status' => '0',
                                  'location' => 'url',
                                  'message' => $errors));
        }
   }
   public function delete_annee()
   {
     $id          = $this->input->post('id');
     $result      = $this->Iav_annee_budget_model->update(array('deleted_annee' => "O"),array('id_annee_budget'=>$id),'ddate_annee');
     $message = "Vos informations ont été supprimées avec succès.";
     echo json_encode(array( 'status' => '1',
                             'location' => 'url',
                             'message' => $message));
   }

   public function exectution_exercice()
   {
     $id    = $this->input->post('id');
     $etat  = $this->input->post('etat');
	 $sql   = "update iav_annee_budget set valide_annee = 'NE' ";
	 $query = $this->db->query($sql);
     $status  = '';
     if($etat == "true"){
       $status = 'E';
	    
     }else if($etat == "false"){
        $status = 'NE';
     }
     $result = $this->Iav_annee_budget_model->update(array('valide_annee'=>$status),array('id_annee_budget' => $id),'udate_annee');
    if($result){
      echo $status;
    }
   }

}
?>
