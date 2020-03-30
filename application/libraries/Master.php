<?php defined('BASEPATH') or exit('No direct script access allowed');

class Master extends CI_Controller {

    protected $template_page_title = '';


    function __construct () {
        parent::__construct();

        $this->template_page_title = 'Retraite';

        if (($message_info = $this->session->userdata('message_info')) && !empty($message_info)) {
            $message_info_type = $this->session->userdata('message_info_type');
            $this->template->inject_partial('message_info', '<div id="message_info_bloc" class="alert alert-'.$message_info_type.'"><button type="button" class="close close_by_js">&times;</button>'.$message_info.'</div>');
            $this->session->unset_userdata(array('message_info' => '', 'message_info_type' => ''));
        }


    }

    protected function display ($data='') {

        $this->template->title($this->template_page_title);
        // $header_nav_1 = navigation($this->config->item('header_nav_1'));
        // $header_nav_2 = navigation($this->config->item('header_nav_2'));
        // $header_nav_3 = navigation($this->config->item('header_nav_3'));
        //  $header_nav_4 = navigation($this->config->item('header_nav_4'));
        $connct ="";
        $sess=$this->session->userdata('user');
          /***login***/

      /* if(isset($sess) && is_array($sess) && !empty($sess)){
             $connct = "connected";
       }else{
         $connct = "notconnected";
         redirect(site_url('connexion/deconnect/'));
       }*/

       /***login***/

       $this->template->set_partial('header', 'inc/header', array('data' => $data,'connected'=>$connct));
        $this->template->set_partial('footer', 'inc/footer',array('data' => $data));
        $this->template->set_partial('notify', 'inc/notify',array('data' => $data));

    }

    protected function set_breadcrumb ($links = array()) {
        $this->template->set_partial('notify', 'inc/notify', array('links' => $links));
    }


    protected function set_side_bar ($data=array()) {
        if (SIDE_BAR_MAX_ELEMENTS > 0) {
            $this->load->model('news_model','news');
            $news = $this->news->read('*', array('newsIsPublished' => '1'), 'id DESC', SIDE_BAR_MAX_ELEMENTS);
            if (!empty($news))
                $this->template->set_partial('side_bar', 'side_bar_view', array('recent_news' => $news,
            'data' => $data));
        }
    }

	protected function set_event_side_bar () {
        if (SIDE_BAR_MAX_ELEMENTS > 0) {
            $this->load->model('news_model','news');
            $news = $this->news->read('*', array('newsIsPublished' => '1'), 'id DESC', SIDE_BAR_MAX_ELEMENTS);
            if (!empty($news))
                $this->template->set_partial('side_bar', 'side_bar_view', array('recent_news' => $news));
        }
    }

    protected function set_public_message ($message, $type = 'info', $redirect_url = '') {
        $this->session->set_userdata(array('message_info' => $message, 'message_info_type' => $type));
        if (!empty($redirect_url))
            redirect(base_url($redirect_url));
    }

    public function valid_url($url) {
        $this->load->library('form_validation');
        $pattern = "/(http:\/\/|https:\/\/)?(([a-zA-Z0-9-]){2,}\.){1,4}([a-zA-Z]){2,6}(\/([a-zA-Z-_\/\.0-9#:?=&;,]*)?)?/i";
        $result = (bool) preg_match($pattern, $url);
        if (empty($result)) {
            $this->form_validation->set_message('valid_url', "<b>$url</b> n'est pas valide, le champ <b>%s</b> doit contenir une URL valide.");
            return false;
        }
        return $result;
    }

    public function captcha_check($captcha, $page = NULL) {
        $this->load->model('Captcha_model','captcha');
        $expiration = time() - 7200;
        $result = $this->captcha->read('', array(
            'captchaWord' => $captcha,
            'captchaTime >' => $expiration,
            'captchaPage' => $page,
            'captchaIpAddress' => $this->input->ip_address(),
        ));
        if (empty($result)) {
            $this->form_validation->set_message('captcha_check', '%s ' . 'est invalide');
            return false;
        }
        $this->__flush_captcha_db('db_captcha_id', $result[0]->id);
        return true;
    }

    public function captcha_ajax() {
        if ($this->input->post('ajax') == '1') {
            $page = $this->input->post('page');
            $captcha = $this->__generate_captcha($page);
            echo json_encode(array('status' => '1', 'captcha_img' => $captcha['image']));
        } else
            redirect(site_url());
    }

    protected function __generate_captcha($page = NULL) {
        if (!empty($page))
            $this->__flush_captcha_db('ip+page', $this->input->ip_address() . STR_SEPARATOR . $page);
        else
            $this->__flush_captcha_db('ip', $this->input->ip_address());
        $this->load->helper('captcha');
        $config = array(
            'img_path' => FCPATH . 'uploads/captcha/',
            'img_url' => base_url('uploads/captcha') . '/',
            'img_height' => 35,
//            'img_width' => 100
        );
        $captcha = create_captcha($config);
        $captcha_word = $captcha['word'];
        $this->__flush_captcha_db();
        $data = array(
            'captchaTime' => $captcha['time'],
            'captchaIpAddress' => $this->input->ip_address(),
            'captchaPage' => $page,
            'captchaWord' => $captcha_word
        );
        $this->load->model('Captcha_model','captcha');
        $this->captcha->create($data);
        return $captcha;
    }

    protected function __flush_captcha_db($by = 'expiration', $value = 7200) {
        $where = array();
        switch ($by) {
            case 'db_captcha_id' :
                $where = array('id' => $value);
                break;
            case 'ip+page' :
                $value = explode(STR_SEPARATOR, $value);
                if (is_array($value) && count($value) == 2)
                    $where = array('captchaIpAddress' => $value[0], 'captchaPage' => $value[1]);
                break;
            case 'ip' :
                $where = array('captchaIpAddress' => $value);
                break;
            default:
            case 'expiration' :
                $where = array('captchaTime <' => time() - $value); // Two hour limit
        }
        if (!empty($where)) {
            $this->load->model('Captcha_model','captcha');
            $this->captcha->delete($where);
        }
    }

}
