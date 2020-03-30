<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/Master.php';
class Ajax extends Master {

    public function __construct() {
        parent::__construct();
        if (!$this->input->is_ajax_request())
            redirect(site_url());
    }

    public function contact () {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Nom', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('subject', 'Sujet', 'required|trim');
        $this->form_validation->set_rules('message', 'Message', 'required|trim');
       //$this->form_validation->set_rules('captcha', 'Captcha', 'required|trim|exact_length['.CAPTCHA_COUNT.']|callback_captcha_check['.$this->config->item('captcha_page_contact').']');
        $errors = false;
        if ($this->form_validation->run()) {
            $message = 'Email: '.$this->input->post('email').' | ';
            $message .= 'Message: '.$this->input->post('message').'.';
            $this->load->helper('email');
          //  send_email(ADMIN_CONTACT_EMAIL, 'Formulaire contact (iav): '.$this->input->post('subject'), $message) && 
            if (send_email(ING_CONTACT_EMAIL, 'Formulaire contact (iav): '.$this->input->post('subject'), $message) ) {
                echo json_encode(array('status' => '1', 'message' => 'Votre message a été correctement envoyé. Nous vous répondrons le plutôt possible. Merci.'));
            } else
                $errors = "Une erreur interne s\'est produite. Veuillez nous excuser, merci de choisir un moyen de contact alternatif tel que le téléphone.";
        }
        else
            $errors = validation_errors();
        if ($errors !== false) {
            $captcha = $this->__generate_captcha($this->config->item('captcha_page_contact'));
            echo json_encode(array('status' => '0', 'errors' => $errors, 'captcha_img' => $captcha['image']));
        }

    }

}