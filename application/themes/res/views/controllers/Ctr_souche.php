<?php defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/Master.php';

class Ctr_souche extends Master
{
  private $CI;
  function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Iav_chauffeur_model','chauffeur');
        $this->load->model('Iav_vehicule_model','vehicule');
        $this->load->model('Iav_souche_model','souche');
        $this->load->model('Iav_reglement_model','reglement');
        $this->load->model('Iav_personel_model','personel');
        $this->load->library('session');
        $this->CI = &get_instance();
    }

  public function index($data = '')
  {
    $this->display($data);
     $souches = $this->souche->getSouches1();
     $user_souche = $this->personel->getAllPersonel();
     $chauffeurs = $this->chauffeur->read("*",array('deleted_chauffeur' => 'N'));
     $matricules = $this->vehicule->read("*",array('deleted_vehicule'=>'N'));
     $souche     = $this->souche->read("*",array('deleted_souche'=>'N'));
     $model = $this->template->load_view('../views/modals/admin/op_modall');
     $this->template->set_partial('container', 'souche/gestion_souche_view1', array('data' => $data,'souches'=>$souches->result(),
     'model'=>$model,'chauffeurs'=>$chauffeurs,'matricules'=>$matricules,'souche'=>$souche,'user_souche'=>$user_souche->result()));
    $this->template->title('dd','ee')->build('body');
  }

  public function souche($data='',$id = ''){
    $chauffeurs = $this->chauffeur->read("*",array('deleted_chauffeur' => 'N'));
    $matricules = $this->vehicule->read("*",array('deleted_vehicule'=>'N'));

     $this->display($data);
      switch($data){
       case  'ajouter':
       $this->set_breadcrumb(array("Ajouter Souche" => ''));
       $this->template->set_partial('container', 'souche/add_souche_view1',
       array('data' => $data,'chauffeurs'=>$chauffeurs,'matricules'=>$matricules));
       break;
       case 'gestion':
       $souches = $this->souche->getSouches();
       $user_souche = $this->personel->read("*",array('deleted_personel'=>'N'));
       $souche     = $this->souche->read("*",array('deleted_souche'=>'N'));
       $this->set_breadcrumb(array("Gestion Souches" => ''));
       $model = $this->template->load_view('../views/modals/admin/op_modall');
       $this->template->set_partial('container', 'souche/gestion_souche_view', array('data' => $data,'souches'=>$souches->result(),'model'=>$model,'chauffeurs'=>$chauffeurs,'matricules'=>$matricules,'souche'=>$souche,'user_souche'=>$souches->result()));
       break;
       // case 'modifier':
       // $souches = $this->souche->getSouches($id);
       // $reglement = $this->reglement->read("*",array('iav_souche'=>$id,'deleted_reglement'=>'N'));
       // $this->set_breadcrumb(array("Modifier Souche" => ''));
       // $this->template->set_partial('container', 'souche/edit_souche_view1', array('data' => $data,'chauffeurs'=>$chauffeurs,'matricules'=>$matricules,'reglement'=>$reglement,'souches'=>$souches->result()));
       // break;

       case 'modifier':
       $souches = $this->souche->getSouches($id);
       $reglement = $this->reglement->read("*",array('iav_souche'=>$id,'deleted_reglement'=>'N'));
       $this->set_breadcrumb(array("Modifier Souche" => ''));
       $this->template->set_partial('container', 'souche/edit_souche_view1', array('data' => $data,'chauffeurs'=>$chauffeurs,'matricules'=>$matricules,'souches'=>$souches->result()));
       break;
       }
       $this->template->title('IAV HASSAN II','Souche')->build('body');
  }
  public function getsoucheSearch()
  {
    $id_chf           = $this->input->post('id_chf');
    $id_vcl           = $this->input->post('id_vcl');
    $num_souche       = $this->input->post('num_souche');
    $date_d           =  $this->input->post('date_d');
    $date_f           =  $this->input->post('date_f');
    $user             = $this->input->post('user');
    $result_search    = $this->souche->getSouches(NULL,$id_chf,$id_vcl,$num_souche,$date_d,$date_f,$user);
    $tab = $this->template->load_view('souche/tab_serch_view.php',array('souches'=> $result_search->result()));
    echo $tab;
  }

  public function getTableaudesignation()
  {
    $compt_actricle    =  $this->input->post('cmpt_atricle');
    $articles          =  $this->input->post('articles');
    $articles_tab      = explode(":",$articles);
    echo  $this->template->load_view('souche/result_tab_design',
                           array('compt_actricle'=> $compt_actricle,'articles_tab' => $articles_tab));
  }
  public function delete_souche()
  {
     $id      = $this->input->post('id');
     $result  = $this->souche->update(array('deleted_souche'=>'O'),array('id_souche'=>$id),'udate_souche');
     $message = "vos informations ont été supprimées avec success";
     echo json_encode(array('status'               => '1',
                            'location'             => 'url',
                            'message'              => $message
                           ));
  }
  public function modifierSouche()
  {
    $this->form_validation->set_rules('conducteur', 'conducteur est obligatoire', 'callback_validation_check');
    $this->form_validation->set_rules('matricule', 'matricule  est obligatoire', 'callback_validation_check');
    $this->form_validation->set_rules('num_souche', 'num_souche est obligatoire', 'required|trim',
                                 array('required' => 'Le champs numero de la souche est obligatoire'));
    $this->form_validation->set_rules('date_s', 'date_s est obligatoire', 'required|trim',
                                array('required' => 'Le champs date est obligatoire'));
    $this->form_validation->set_rules('ville_s', 'ville_s est obligatoire', 'required|trim',
                               array('required' => 'Le champs ville est obligatoire'));
    $this->form_validation->set_rules('Kilometrage', 'Kilometrage est obligatoire', 'required|trim',
                              array('required' => 'Le champs Kilometrage est obligatoire'));
    $this->form_validation->set_rules('fournisseur', 'fournisseur est obligatoire', 'required|trim',
                              array('required' => 'Le champs fournisseur est obligatoire'));
   if ($this->form_validation->run()){
     $id                   = $this->input->post('id');
     $conducteur           = $this->input->post('conducteur');
     $matricule            = $this->input->post('matricule');
     $num_souche           =  $this->input->post('num_souche');
     $date_s               =  $this->input->post('date_s');
     $ville_s              = $this->input->post('ville_s');
     $Kilometrage          =  $this->input->post('Kilometrage');
     $fournisseur          =  $this->input->post('fournisseur');
     $opntions_sche        = array(
        'num_souche'          =>  $num_souche,
        'fournisseur_souche'  => $fournisseur,
        'ville_souche'        => $ville_s,
        'kilometrage_souche'  => $Kilometrage,
        'id_chauffeur'        => $conducteur,
        'iav_vehicule'        => $matricule,
        'date_souche'        => $date_s,
        'uby_souche'         => $this->session->user['id_user']
     );
     $result = $this->souche->update($opntions_sche,array('id_chauffeur'=>$id),'udate_souche');
     $message = "vos informations ont été modifiees avec success";
     echo json_encode(array('status'               => '1',
                            'location'             => 'url',
                            'message'              => $message
                           ));
   }else {
     $errors = validation_errors();
     echo json_encode(array('status' => '0',
                            'location' => 'url',
                            'message' => $errors));
   }

  }

  /**** le  nuveau souche ****/

  public function modifierSouche1()
  {
    $this->form_validation->set_rules('conducteur', 'conducteur est obligatoire', 'callback_validation_check');
    $this->form_validation->set_rules('matricule', 'matricule  est obligatoire', 'callback_validation_check');
    $this->form_validation->set_rules('num_souche', 'num_souche est obligatoire', 'required|trim',
                                 array('required' => 'Le champs numero de la souche est obligatoire'));
    $this->form_validation->set_rules('date_s', 'date_s est obligatoire', 'required|trim',
                                array('required' => 'Le champs date est obligatoire'));
    $this->form_validation->set_rules('Kilometrage', 'Kilometrage est obligatoire', 'required|trim',
                              array('required' => 'Le champs Kilometrage est obligatoire'));
   if ($this->form_validation->run()){
     $id                   = $this->input->post('id');
     $conducteur           = $this->input->post('conducteur');
     $matricule            = $this->input->post('matricule');
     $num_souche           =  $this->input->post('num_souche');
     $date_s               =  $this->input->post('date_s');
     $Kilometrage          =  $this->input->post('Kilometrage');
     $opntions_sche        = array(
        'num_souche'          =>  $num_souche,
        'kilometrage_souche'  => $Kilometrage,
        'id_chauffeur'        => $conducteur,
        'iav_vehicule'        => $matricule,
        'date_souche'        => $date_s,
        'uby_souche'         => $this->session->user['id_user']
     );
     $result = $this->souche->update($opntions_sche,array('id_souche'=>$id),'udate_souche');
     $message = "vos informations ont été modifiees avec success";
     echo json_encode(array('status'               => '1',
                            'location'             => 'url',
                            'message'              => $message . ' ' . $Kilometrage
                           ));
   }else {
     $errors = validation_errors();
     echo json_encode(array('status' => '0',
                            'location' => 'url',
                            'message' => $errors));
   }

  }
  public function ajoutersouche1()
  {
    $this->form_validation->set_rules('conducteur', 'conducteur est obligatoire', 'callback_validation_check');
    $this->form_validation->set_rules('matricule', 'matricule  est obligatoire', 'callback_validation_check');
    $this->form_validation->set_rules('num_souche', 'num_souche est obligatoire', 'required|trim',
                                 array('required' => 'Le champs numero de la souche est obligatoire'));
    $this->form_validation->set_rules('date_s', 'date_s est obligatoire', 'required|trim',
                                array('required' => 'Le champs date est obligatoire'));

    $this->form_validation->set_rules('Kilometrage', 'Kilometrage est obligatoire', 'required|trim',
                              array('required' => 'Le champs Kilometrage est obligatoire'));

   if ($this->form_validation->run()){
     $conducteur           = $this->input->post('conducteur');
     $matricule            = $this->input->post('matricule');
     $articles             = $this->input->post('articles');
     $num_souche           =  $this->input->post('num_souche');
     $date_s               =  $this->input->post('date_s');
     $Kilometrage          =  $this->input->post('Kilometrage');

     $articles_tab         = explode(":",$articles);
     $opntions_sche        = array(
        'num_souche'          =>  $num_souche,
        'kilometrage_souche'  => $Kilometrage,
        'id_chauffeur'        => $conducteur,
        'iav_vehicule'        => $matricule,
        'date_souche'        => $date_s,
        'cby_souche'         => $this->session->user['id_user']
     );
     $verf_existe             = $this->souche->read("*",array('num_souche'=>$num_souche));
     if(count($verf_existe) > 0){
       $message = "N souche existe , essayez un autre N souche";
       echo json_encode(array('status'               => '0',
                              'location'             => 'url',
                              'message'              => $message
                             ));
          return;
     }
     $id_souche               = $this->souche->create($opntions_sche,'cdate_souche');
     if($id_souche != null){
       // foreach ($articles_tab as $key => $value) {
       //    if($value != ''){
       //      $value_tab = explode(",",$value);
       //      $options = array (
       //                    'designation_reglement'  => $value_tab[0],
       //                    'qte_reglement'          => $value_tab[1],
       //                    'pu_reglement'           => $value_tab[2],
       //                    'mtvignette_reglement'   => $value_tab[4],
       //                     'iav_souche'            => $id_souche,
       //                     'cby_reglement'         => $this->CI->session->user['id_user']
       //                    );
       //    $result = $this->reglement->create($options,'cdate_reglement');
       // }
       // }
       $message = "vos informations ont été enregistrées avec success";
       echo json_encode(array('status'               => '1',
                              'location'             => 'url',
                              'message'              => $message
                             ));
     }

   }else {
     $errors = validation_errors();
     echo json_encode(array('status' => '0',
                            'location' => 'url',
                            'message' => $errors));
   }

  }
  /** le nouveau souche ****/
  public function ajoutersouche()
  {
    $this->form_validation->set_rules('conducteur', 'conducteur est obligatoire', 'callback_validation_check');
    $this->form_validation->set_rules('matricule', 'matricule  est obligatoire', 'callback_validation_check');
    $this->form_validation->set_rules('articles', 'articles  est obligatoire', 'callback_validation_article_check');
    $this->form_validation->set_rules('num_souche', 'num_souche est obligatoire', 'required|trim',
                                 array('required' => 'Le champs numero de la souche est obligatoire'));
    $this->form_validation->set_rules('date_s', 'date_s est obligatoire', 'required|trim',
                                array('required' => 'Le champs date est obligatoire'));
    $this->form_validation->set_rules('ville_s', 'ville_s est obligatoire', 'required|trim',
                               array('required' => 'Le champs ville est obligatoire'));
    $this->form_validation->set_rules('Kilometrage', 'Kilometrage est obligatoire', 'required|trim',
                              array('required' => 'Le champs Kilometrage est obligatoire'));
    $this->form_validation->set_rules('fournisseur', 'fournisseur est obligatoire', 'required|trim',
                              array('required' => 'Le champs fournisseur est obligatoire'));
   if ($this->form_validation->run()){
     $conducteur           = $this->input->post('conducteur');
     $matricule            = $this->input->post('matricule');
     $articles             = $this->input->post('articles');
     $num_souche           =  $this->input->post('num_souche');
     $date_s               =  $this->input->post('date_s');
     $ville_s              = $this->input->post('ville_s');
     $Kilometrage          =  $this->input->post('Kilometrage');
     $fournisseur          =  $this->input->post('fournisseur');
     $articles_tab         = explode(":",$articles);
     $opntions_sche        = array(
        'num_souche'          =>  $num_souche,
        'fournisseur_souche'  => $fournisseur,
        'ville_souche'        => $ville_s,
        'kilometrage_souche'  => $Kilometrage,
        'id_chauffeur'        => $conducteur,
        'iav_vehicule'        => $matricule,
        'date_souche'        => $date_s,
        'cby_souche'         => $this->session->user['id_user']
     );
     $verf_existe             = $this->souche->read("*",array('num_souche'=>$num_souche));
     if(count($verf_existe) > 0){
       $message = "N souche existe , essayez un autre N souche";
       echo json_encode(array('status'               => '0',
                              'location'             => 'url',
                              'message'              => $message
                             ));
          return;
     }
     $id_souche               = $this->souche->create($opntions_sche,'cdate_souche');
     if($id_souche != null){
       foreach ($articles_tab as $key => $value) {
          if($value != ''){
            $value_tab = explode(",",$value);
            $options = array (
                          'designation_reglement'  => $value_tab[0],
                          'qte_reglement'          => $value_tab[1],
                          'pu_reglement'           => $value_tab[2],
                          'mtvignette_reglement'   => $value_tab[4],
                           'iav_souche'            => $id_souche,
                           'cby_reglement'         => $this->CI->session->user['id_user']
                          );
          $result = $this->reglement->create($options,'cdate_reglement');
       }
       }
       $message = "vos informations ont été enregistrées avec success";
       echo json_encode(array('status'               => '1',
                              'location'             => 'url',
                              'message'              => $message
                             ));
     }

   }else {
     $errors = validation_errors();
     echo json_encode(array('status' => '0',
                            'location' => 'url',
                            'message' => $errors));
   }

  }
  public function modifierReglement()
  {
    $this->form_validation->set_rules('designiation', 'designiation est obligatoire', 'required|trim',
                                 array('required' => 'Le champs designiation  est obligatoire'));
    $this->form_validation->set_rules('vegn', 'vegn est obligatoire', 'required|trim',
                              array('required' => 'Le champs Mt vignettes est obligatoire'));
       if ($this->form_validation->run()){

         $id           = $this->input->post('id');
         $designiation           = $this->input->post('designiation');
         $vegn                   = $this->input->post('vegn');
         $qn                     = $this->input->post('qn');
         $pu                     =  $this->input->post('pu');
         $tp                     =  $this->input->post('tp');
         $opntion                = array(
           'designation_reglement' => $designiation,
           'qte_reglement'         => $qn,
           'mtvignette_reglement'  => $vegn,
           'pu_reglement'          => $pu,
           'cby_reglement'         => $this->CI->session->user['id_user']
         );
         $result = $this->reglement->update($opntion,array('id_regement'=>$id),'udate_reglement');
         $message = "vos informations ont été modifiées avec success";
         echo json_encode(array('status'               => '1',
                                'location'             => 'url',
                                'message'              => $message
                               ));
       }else {
         $errors = validation_errors();
         echo json_encode(array('status' => '0',
                                'location' => 'url',
                                'message' => $errors));

       }
  }

  public function supprimerReglement()
  {
       $id  = $this->input->post('id');
       $resutl = $this->reglement->update(array('deleted_reglement'=>'O'),array('id_regement'=>$id),'udate_reglement');
       $message = "vos informations ont été supprimées avec success";
       echo json_encode(array('status'               => '1',
                              'location'             => 'url',
                              'message'              => $message
                             ));

  }
  public function validation_check($str){
  if ($str == "0"){
    $this->form_validation->set_message('validation_check', ' Le champs  {field} est obligatoire  ');
    return FALSE;
  }else{
    return TRUE;
  }
}
public function validation_article_check($str){
  if ($str == ""){
  $this->form_validation->set_message('validation_article_check','Vous devez avoir aumoins un Article');
  return FALSE;
  }else{
  return TRUE;
}
}
}
?>
