<?php defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/Master.php';

class Ctr_profile extends Master
{
  private $CI;
  function __construct() {
    parent::__construct();
      $this->load->library('form_validation');
      $this->load->library('session');
      $this->load->model('Iav_personel_model','personel');
      $this->CI = &get_instance();
  }
  public function index($data = '')
  {
    $this->display($data);
    $this->template->set_partial('container', 'profile_view', array('data' => $data));
    $this->template->title('PArc-auto','IAV HASSAN II')->build('body');
  }

  public function modifier_profiles()
  {
    $this->form_validation->set_rules('nom', 'Nom  est obligatoire', 'required|trim',
                            array('required' => 'Le champs nom  est obligatoire'));
    $this->form_validation->set_rules('prenom', 'Prenom  est obligatoire', 'required|trim',
                            array('required' => 'Le champs prenom est obligatoire'));
    $this->form_validation->set_rules('email', 'email est obligatoire', 'required|trim',
                            array('required' => 'Le champs email  est obligatoire'));
    $this->form_validation->set_rules('tel', 'tel est obligatoire', 'required|trim',
                            array('required' => 'Le champs tel  est obligatoire'));
    $this->form_validation->set_rules('date_naissance', 'date_naissance est obligatoire', 'required|trim',
                            array('required' => 'Le champs date naissance  est obligatoire'));

    if($this->form_validation->run()){
      $nom           = $this->input->post('nom');
      $prenom        = $this->input->post('prenom');
      $tel           = $this->input->post('tel');
      $email         = $this->input->post('email');
      $data_naiss    = $this->input->post('date_naissance');
      $password      = $this->input->post('password');
      $rpassword     = $this->input->post('rpassword');
      $options       = array(
        'nom_personel'             => $nom,
        'prenom_personel'          => $prenom,
        'tel_personel'             => $tel,
        'email_personel'           => $email,
        'date_naissance_personel'  => $data_naiss,
        'uby_personel'             => $this->CI->session->user['id_user']
      );

      if($password != null){
        if($rpassword == null){
          echo json_encode(array('status' => '0',
                                 'location' => 'url',
                                 'message' => 'Les champs confirmation mot de passe est obligatoire pour la modification du mot de passe'));
                                 return;
        }else {
          if($password != $rpassword){
            echo json_encode(array('status' => '0',
                                   'location' => 'url',
                                   'message' => 'Les champs mot de passe , confirmation mot de passe sont pas identiques'));
                                   return;
          }else {
            $options['password'] = md5($password);
          }
        }

      }
      $result = $this->personel->update($options,array('id_personel'=>$this->CI->session->user['id_user']),'udate_personel');
      if(isset($options['password'])){
        $this->personel->envoie_email($this->CI->session->user['login'],$password);
      }
      echo json_encode(array('status' => '1',
                             'location' => 'url',
                             'message' => 'vos informations ont éte modifiees avec success'));

    }else {
      $errors = validation_errors();
      echo json_encode(array('status' => '0',
                             'location' => 'url',
                             'message' => $errors));
    }

  }
}
?>
