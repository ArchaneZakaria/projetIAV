<?php defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/Master_user.php';

class Ctr_Connexion extends Master_user
{
      private $CI;
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        $this->CI = &get_instance();
        $this->load->model('User_model','conn');
    }
    public function index(){
       $this->load->view("connexion_m/login.php");
    }
    public function login()
    {
          $this->form_validation->set_rules('username', 'username', 'required',
                       array('required' => 'Le champs E-mail est obligatoire'));
          $this->form_validation->set_rules('password', 'password', 'required',
                       array('required' => 'Le champs Mot de passe est obligatoire'));


              if($this->form_validation->run()){
                $username                = $this->input->post('username');
                $password                = $this->input->post('password');
                $user                    = $this->conn->connexion($username,$password);

               
                if(count($user['data']) != 0){

                  //$applic_user  = $this->conn->getApplicationsByUser($user['data'][0]->id_personel);
                  $this->session->set_userdata('user', array('login'=>$username,'id_user' => $user['data'][0]->id_user,'id_role'=>$user['data'][0]->id_role,'data_user'=>$user['data']));

                  //Arreter le problème de session
                //  $this->session->userdata['user']['access_app'] = 1;

                  //$this->CI->session->user
                  echo json_encode(array(
                                        'status' => '1',
                                        'location' => 'accueil',
                                        'message' => 'Connexion'
                                      ));
                }else {
                  echo json_encode(array(
                                        'status' => '0',
                                        'location' => 'url',
                                        'message' => 'E-mail & Mot de passe sont incorrect: Echec de  connexion'
                                      ));
                }
               }else {
                  $errors = validation_errors();
                  echo json_encode(array(
                                        'status' => '0',
                                        'location' => 'url',
                                        'message' => $errors
                                      ));
               }
    }
    public function deconnect(){
       $this->session->sess_destroy();
     redirect('login');
   }



}
