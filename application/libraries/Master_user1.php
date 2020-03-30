<?php defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/Master.php';

class Master_user extends Master {

    protected $user_id = NULL;
    protected $user_login = NULL;
    protected $user_type = NULL;

    function __construct() {
        parent::__construct();
        if (($token_ch = $this->session->userdata('token_ch')) && !empty($token_ch)) {
//            $token_ch = $this->encrypt->decode($token_ch);
            $args = explode(TOKEN_CHANNEL_SEPARATOR, $token_ch);
            if (count($args) == 3) {
                $this->user_login = $args[0];
                $this->user_id = $args[1];
                $this->user_type = $args[2];
            }
        }
    }

    protected function set_session_token($args = array()) {
        if (empty($args) || !isset($args['user_id']) || !isset($args['user_login']) || !isset($args['user_type']))
            return false;
        $this->user_id = $args['user_id'];
        $this->user_login = $args['user_login'];
        $this->user_type = $args['user_type'];
        $token_ch = str_replace(array(TOKEN_PATTERN_USER_LOGIN, TOKEN_PATTERN_USER_ID, TOKEN_PATTERN_USER_TYPE), array($args['user_login'], $args['user_id'], $args['user_type']), TOKEN_CHANNEL_FORMAT);
//        $token_ch = implode(TOKEN_CHANNEL_SEPARATOR, $token_ch);
        $this->session->set_userdata('token_ch', $token_ch);
        $this->session->set_userdata('typeloging', $args['user_type']);
    }

    public function logout($as) {
        if ($this->user_is_connected($as))
            $this->session->sess_destroy();
        redirect(site_url('connexion/logout_info/' . $as));
    } 

    public function logout_info($as) {
       $lange= $this->session->userdata('langue');
        if (!$this->user_is_connected($as))
            $this->set_public_message("Vous êtes déconnecté correctement.");
        /** verifier l'ouverture de session */
         $langue=$this->session->userdata('langue');
         echo $langue;
          if(empty($langue)){
            $langue=$this->session->set_userdata('langue','french');
          }
       /** verifier l'ouverture de session */
        redirect(site_url(), 'refresh');
    }

    protected function user_is_connected($as,$lang='') {
        $is_connected = (bool) (!empty($this->user_id) && !empty($this->user_login) && !empty($this->user_type));
        if ($is_connected && $this->user_type === $as)
            return true;
        return false;
    }

    protected function etudiant ($id = NULL, $is_parent = false,$is_student= false,$lang='') {
        if (!($this->user_is_connected(USER_TYPE_STUDENT) || $this->user_is_connected(USER_TYPE_PARENT)))
            redirect();
        $this->load->model('YearCalendar_model', 'yearCalendar');
        $this->load->model('rel_branchs_levels_model', 'rel_branchs_levels');
        $this->load->model('level_model', 'level');
        if (!($user_info = $this->student->read('*', array('id' => $id, 'studentIsActive' => '1'))) || empty($user_info)) {
            $this->set_public_message("404, page introuvable!", 'danger', 'home');
        }

        $data = $this->internaionalis($lang);

       /***login***/

        $this->template->prepend_metadata('<link rel="stylesheet" type="text/css" href="' . base_url('assets/css') . '/dataTables.bootstrap.css">');
        $this->template->append_metadata('<link href="' . base_url('assets') . '/css/profile.css" rel="stylesheet">');
        $user_info = $user_info[0];
        $annees = array();
        $anneesC = $this->yearCalendar->read('*', array('student_id' => $user_info->id), 'id desc');



        foreach ($anneesC as $value)
            $annees[$value->yearcalendarName] = $value->yearcalendarName;
        $options = array('student_id' => $user_info->id);
        $year_selected = '0';
        if (!empty($anneesC)) {
            $options['year'] = $anneesC[0]->yearcalendarName;
            $year_selected = $anneesC[0]->yearcalendarName;
        }




          /***login***/
        if( Master_user::user_is_connected(USER_TYPE_STUDENT)){
        $this->session->set_userdata('usertype','student');
      }
        $this->display($lang, $data);

        $data = array();
        $data['notes_arr'] = $this->note->get_notes_by_joining($options);
        $data['is_parent'] = $is_parent;
        $data['is_student'] = $is_student;
        $hidden = array('student_id' => $id);



        $code = $this->load->view('list_notes_view', $data, true);
        $this->template->title($user_info->studentFirstName . ' ' . $user_info->studentLastName, 'Profile etudiant', $this->template_page_title);
        if ($is_parent === true) {
            $home = 'parents/index';
            $view = 'parent_admin/student_profile_view';
            $this->load->model('Parent_model', 'parents');
            $parent = $this->parents->read('*', array('id' => $user_info->parent_id));
            $this->set_breadcrumb(array("Liste de vos étudiants" => $home, $user_info->studentFirstName . ' ' . $user_info->studentLastName => ''));
        } else {
            $home = 'etudiant/index';
            $view = 'student_admin/student_profile_view';
			$this->set_breadcrumb(array("Profile" => $home, $user_info->studentFirstName . ' ' . $user_info->studentLastName => ''));
           // $this->set_breadcrumb(array("Profile" => $home, $user_info->studentFirstName . ' ' . $user_info->studentLastName => ''));
        }
        $parent = isset($parent[0]) ? $parent[0] : array();
        $this->template->set_partial('container', $view, array('user_info' => $user_info, 'code' => $code, 'annees' => $annees, 'year_selected' => $year_selected, 'hidden' => $hidden, 'parent' => $parent));
        $this->template->build('body');
    }

}
