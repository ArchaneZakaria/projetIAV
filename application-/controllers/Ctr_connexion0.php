<?php defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/Master_user.php';

class Ctr_Connexion extends Master_user
{
      private $CI;
    public function __construct(){
        parent::__construct();
        $this->load->model('Iav_application_model','application');
        $this->load->model('Iav_personel_model','conn');
        $this->load->library('form_validation','fr');
        $this->load->library('session');
        $this->CI = &get_instance();
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

                  $applic_user  = $this->conn->getApplicationsByUser($user['data'][0]->id_personel);
                  $this->session->set_userdata('user', array('login'=>$username,'id_user' => $user['data'][0]->id_personel,'departement'=>$user['data'][0]->id_departement,'data_user'=>$user['data'],'nbr_appl_usr'=>count($applic_user)));

                  //Arreter le problème de session
                  $this->session->userdata['user']['access_app'] = 1;

                  //$this->CI->session->user
                  echo json_encode(array(
                                        'status' => '1',
                                        'location' => 'home_global',
                                        'message' => 'Connexion'
                                      ));
                }else {
                  echo json_encode(array(
                                        'status' => '0',
                                        'location' => 'url',
                                        'message' => 'Email & Mot de passe sont incorrect: Echec connexion'
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
     redirect('login');
   }

   public function home()
   {

        $applic_user  = $this->conn->getApplicationsByUser($this->CI->session->user['id_user']);

		    $this->session->userdata['user']['application_user'] = $applic_user ;
        $applications = $this->application->read("*",array('deleted_application'=>'N'));
        $this->session->userdata['user']['applications_user'] = $applications;
        $this->load->view("connexion_m/global_view.php",array('applications'=>$applications,'appli_user' => $applic_user,'departement'=>$this->CI->session->user['departement']));
   }


   public function setApplicationId()
   {
      // id applcation
      $id     = $this->input->post('id');
      $this->session->userdata['user']['id_app'] = $id;
	  // acces
		$sql_access='select * from droits_acces inner join iav_personel_type_departement on (  droits_acces.iav_personel_type_departement = iav_personel_type_departement.id_personel_type_departement)
		where deleted_droits_acces ="N" AND  droits_acces.iav_application_id_application ="'. $id . '" AND iav_personel_type_departement.id_personel ="'. $this->CI->session->user['id_user'] .'"';
		$queryacces         =  $this->db->query($sql_access);
		$queryacces_result  = $queryacces->result();
		$acces_f = $queryacces_result['0']->acces;
    $this->session->userdata['user']['access_app'] = $acces_f;
	  // end access
      //$this->session->userdata['user']['acces'] = $id;
	  $url_app = $this->application->read("*",array('id_application'=>$id));
	  echo $url_app[0]->url_application;

   }

   public function changerMotPass()
   {
       $this->load->view("connexion_m/forgetpassword.php");
   }
   public function modifier_motdepass()
   {
        $this->form_validation->set_rules('username', 'username', 'required',
                  array('required' => 'Le champs Email est obligatoire'));

        if($this->form_validation->run()){
          $username    = $this->input->post('username');
          $user_select = $this->conn->read("*",array('email_personel'=>$username,'deleted_personel'=> 'N'));

           if(count($user_select) > 0){
             $temp_user   = explode("@",$username);
             $password    = $temp_user[0].$user_select[0]->id_personel;
             $resurlt     = $this->conn->update(array('password' => md5($password)),array('email_personel'=>$username));
              $this->conn->envoie_email($username,$password);
              echo json_encode(array(
                                   'status' => '1',
                                   'location' => 'url',
                                   'message' => "vos informations ont éte modofiees avec success"
                                 ));
           }else {
             echo json_encode(array(
                                   'status' => '0',
                                   'location' => 'url',
                                   'message' => "vos informations sont Incorrectes  "
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

}
