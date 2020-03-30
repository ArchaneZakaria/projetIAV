<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/Master_user.php';

class Ajax_user extends Master_user
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->input->is_ajax_request())
            redirect(site_url());
        $this->load->model('Event_model', 'event');
        $this->load->model('News_model', 'news');
        $this->load->model('Page_model', 'page');
        $this->load->model('Ad_model', 'ad');
        $this->load->model('Association_model', 'association');
        $this->load->model('Publication_model', 'publication');
        $this->load->model('Student_model', 'student');
        $this->load->model('Parent_model', 'parent');
        $this->load->model('Professor_model', 'professor');
        $this->load->model('branch_model', 'branch');
        $this->load->model('module_model', 'module');
        $this->load->model('YearCalendar_model', 'yearCalendar');
        $this->load->model('Attestation_model', 'attestation');
        $this->load->model('note_model', 'note');
        $this->load->model('level_model', 'level');
        $this->load->model('rel_branchs_levels_model', 'rel_branchs_levels');
        $this->load->model('annonce_model', 'annonce');


    }

    public function login($type = USER_TYPE_ADMIN)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('login', '<b>Identifiant</b>',
            'required|trim|max_length[40]');
        $this->form_validation->set_rules('password', '<b>Mot de passe</b>',
            'required|trim|min_length[6]|max_length[20]');
        $errors = false;
        if ($this->form_validation->run()) {
            $user = null;
            switch ($type) {
                case USER_TYPE_ADMIN:
                    $this->load->model('User_model', 'user');
                    $user = $this->user->read('id,userLogin', array(
                        'userLogin' => $this->input->post('login'),
                        'userPassword' => sha1($this->input->post('password')),
                        'userAdminRole' => 'admin_global',
                        'userIsActive' => '1'));
                    if (!empty($user)) {
                        $user = $user[0];
                        $this->user->set_last_login($user->id);
                        $this->set_session_token(array(
                            'user_id' => $user->id,
                            'user_login' => $user->userLogin,
                            'user_type' => USER_TYPE_ADMIN));
                        echo json_encode(array(
                            'status' => '1',
                            'location' => 'administration/index',
                            'message' => 'bienvenue <strong>' . $user->userLogin . '</strong> !'));
                    }
                    break;
                case USER_TYPE_ADMIN_PARTIAL:
                    $this->load->model('User_model', 'user');
                    $user = $this->user->read('id,userLogin', array(
                        'userLogin' => $this->input->post('login'),
                        'userPassword' => sha1($this->input->post('password')),
                        'userAdminRole' => 'admin_partial',
                        'userIsActive' => '1'));
                    if (!empty($user)) {
                        $user = $user[0];
                        $this->user->set_last_login($user->id);
                        $this->set_session_token(array(
                            'user_id' => $user->id,
                            'user_login' => $user->userLogin,
                            'user_type' => USER_TYPE_ADMIN_PARTIAL));
                        echo json_encode(array(
                            'status' => '1',
                            'location' => 'admin/index',
                            'message' => 'bienvenue <strong>' . $user->userLogin . '</strong> !'));
                    }
                    break;
                case USER_TYPE_PROF:
                    $this->load->model('Professor_model', 'professor');
                    $user = $this->professor->read('id,professorLogin', array(
                        'professorLogin' => $this->input->post('login'),
                        'professorPassword' => sha1($this->input->post('password')),
                        'professorIsActive' => '1'));
                    if (!empty($user)) {
                        $user = $user[0];
                        $this->professor->set_last_login($user->id);
                        $this->set_session_token(array(
                            'user_id' => $user->id,
                            'user_login' => $user->professorLogin,
                            'user_type' => USER_TYPE_PROF));
                        echo json_encode(array(
                            'status' => '1',
                            'location' => 'enseignant/index',
                            'message' => 'bienvenue <strong>' . $user->professorLogin . '</strong> !'));
                    }
                    break;
                case USER_TYPE_STUDENT:
                    $this->load->model('student_model', 'student');
                    $user = $this->student->read('id,studentLogin', array(
                        'studentLogin' => $this->input->post('login'),
                        'studentPassword' => sha1($this->input->post('password')),
                        'studentIsActive' => '1'));
                    if (!empty($user)) {
                        $user = $user[0];
                        $this->student->set_last_login($user->id);
                        $this->set_session_token(array(
                            'user_id' => $user->id,
                            'user_login' => $user->studentLogin,
                            'user_type' => USER_TYPE_STUDENT));
                        echo json_encode(array(
                            'status' => '1',
                            'location' => 'etudiant/index',
                            'message' => 'bienvenue <strong>' . $user->studentLogin . '</strong> !'));
                    }
                    break;
                case USER_TYPE_PARENT:
                    $this->load->model('parent_model', 'parent');
                    $user = $this->parent->read('id,parentLogin', array(
                        'parentLogin' => $this->input->post('login'),
                        'parentPassword' => sha1($this->input->post('password')),
                        'parentIsActive' => '1'));
                    if (!empty($user)) {
                        $user = $user[0];
                        $this->parent->set_last_login($user->id);
                        $this->set_session_token(array(
                            'user_id' => $user->id,
                            'user_login' => $user->parentLogin,
                            'user_type' => USER_TYPE_PARENT));
                        echo json_encode(array(
                            'status' => '1',
                            'location' => 'parents/index',
                            'message' => 'bienvenue <strong>' . $user->parentLogin . '</strong> !'));
                    }
                    break;
                    //                default :
                    //                    $errors = 'Une erreur système grave est détectée !';
            }
            if (empty($user))
                $errors = "Le login ou le mot de passe saisi est incorrect!";
        } else
            $errors = validation_errors();
        if ($errors !== false)
            echo json_encode(array('status' => '0', 'errors' => $errors));
    }

    public function op_professor_admin()
    {
        if (!$this->user_is_connected(USER_TYPE_ADMIN))
            $this->set_public_message("Vous n'êtes pas connecté, merci de se connecter.",
                'info', 'connexion/administration');

        $this->load->library('form_validation');
        $prefix = 'prof';
        $this->form_validation->set_rules($prefix . '_id', 'ID', 'required|trim');
        $this->form_validation->set_rules($prefix . '_title', 'Titre professionel',
            'required|trim|max_length[255]');
        $this->form_validation->set_rules($prefix . '_l_name', 'Nom',
            'required|trim|max_length[80]');
        $this->form_validation->set_rules($prefix . '_f_name', 'Prénom',
            'required|trim|max_length[80]');
        $this->form_validation->set_rules($prefix . '_email', 'Email',
            'required|trim|valid_email|max_length[100]');
        $this->form_validation->set_rules($prefix . '_address', 'Adresse',
            'required|trim|max_length[255]');
        $this->form_validation->set_rules($prefix . '_function', 'Fonction',
            'required|trim');
        $this->form_validation->set_rules($prefix . '_presentation', 'Présentation',
            'required|trim');
        $this->form_validation->set_rules($prefix . '_biography', 'Biographie',
            'required|trim');
        $this->form_validation->set_rules($prefix . '_graduate', 'Diplômes', 'trim');
        $this->form_validation->set_rules($prefix . '_expertise_domains', 'Domaines d\'expertise',
            'trim');
        $this->form_validation->set_rules($prefix . '_research_activities',
            'Activités de recherche', 'trim');
        $this->form_validation->set_rules($prefix . '_teaching_activities', 'Activités d\'enseignement',
            'trim');
        $this->form_validation->set_rules($prefix . '_tel', 'Téléphone',
            'trim|max_length[20]');
        $this->form_validation->set_rules($prefix . '_fax', 'Fax', 'trim|max_length[20]');
        $this->form_validation->set_rules($prefix . '_ws', 'Siteweb',
            'trim|prep_url|callback_valid_url|max_length[255]');
        $errors = false;
        if ($this->form_validation->run()) {
            if (!empty($_FILES[$prefix . '_img']['name'])) {
                $config = array();
                $config['upload_path'] = UPLOADS_PROFILE_IMG_PATH;
                $config['allowed_types'] = UPLOADS_IMG_ALLOWED_TYPES;
                //                $config['max_size'] = UPLOADS_IMG_MAX_SIZE;
                //                $config['max_width'] = UPLOADS_IMG_MAX_WIDTH;
                //                $config['max_height'] = UPLOADS_IMG_MAX_HEIGHT;
                $config['encrypt_name'] = true;
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload($prefix . '_img'))
                    $errors = $this->upload->display_errors();
                else
                    $file_image_data = $this->upload->data();
            }
            if ($errors === false) {
                $this->load->model('Professor_model', 'professor');
                //$message = "Vos informations ont été correctement modifiées.";
                $options = array(
                    'professorTitle' => $this->input->post($prefix . '_title'),
                    'professorFirstName' => $this->input->post($prefix . '_f_name'),
                    'professorLastName' => $this->input->post($prefix . '_l_name'),
                    'professorLogin' => $this->input->post($prefix . '_login'),
                    'professorPassword' => sha1($this->input->post($prefix . '_password')),
                    'professorEmail' => $this->input->post($prefix . '_email'),
                    'professorAddress' => $this->input->post($prefix . '_address'),
                    'professorFunction' => $this->input->post($prefix . '_function'),
                    'professorPresentation' => $this->input->post($prefix . '_presentation'),
                    'professorBiography' => $this->input->post($prefix . '_biography'),
                    'professorGraduate' => $this->input->post($prefix . '_graduate'),
                    'professorExpertiseDomains' => $this->input->post($prefix . '_expertise_domains'),
                    'professorResearchActivities' => $this->input->post($prefix .
                        '_research_activities'),
                    'professorTeachingActivities' => $this->input->post($prefix .
                        '_teaching_activities'),
                    'professorPhone' => $this->input->post($prefix . '_tel'),
                    'professorFax' => $this->input->post($prefix . '_fax'),
                    'professorWebsite' => $this->input->post($prefix . '_ws'),
                    'user_id' => $this->user_id);
                if (isset($file_image_data['file_name']))
                    $options['professorImg'] = $file_image_data['file_name'];


                if (($id = $this->input->post($prefix . '_id'))) {
                    $message = "Vos informations ont été correctement modifiées..";
                    $this->professor->update($options, $id);
                } else {
                    $message = "Vos informations ont été ajouté avec succès.";
                    $result = $this->professor->create($options);
                }
                $this->set_public_message($message, 'success');
                echo json_encode(array(
                    'status' => '1',
                    'url' => 'administration/professors',
                    'message' => $message));

                /*
                if ($this->professor->update($options, $this->input->post($prefix . '_id'))) {
                $this->set_public_message($message, 'success');
                echo json_encode(array('status' => '1', 'url' => 'enseignant/index', 'message' => $message));
                } else if ($errors === false)
                $errors = "Une erreur est survenue lors du traitement, merci de réessayer.";
                */
            }
        } else
            $errors = validation_errors();
        if ($errors !== false)
            echo json_encode(array('status' => '0', 'errors' => $errors));
    }

	public function etud_img(){
		if ($this->form_validation->run()) {
            if (!empty($_FILES['student_img']['name'])) {
                $config = array();
                $config['upload_path'] = UPLOADS_PROFILE_IMG_PATH;
                $config['allowed_types'] = UPLOADS_IMG_ALLOWED_TYPES;
                //                $config['max_size'] = UPLOADS_IMG_MAX_SIZE;
                //                $config['max_width'] = UPLOADS_IMG_MAX_WIDTH;
                //                $config['max_height'] = UPLOADS_IMG_MAX_HEIGHT;
                $config['encrypt_name'] = true;
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('student_img'))
                    $errors = $this->upload->display_errors();
                else
                    $file_image_data = $this->upload->data();
            }
		}else
            $errors = validation_errors();
        if ($errors !== false)
            echo json_encode(array('status' => '0', 'errors' => $errors));

		$message="votre photo est enregistré avec succées";
		$this->set_public_message($message,'success');
				   echo json_encode(array(
                        'status' => '1',
                        'url' => 'enseignant/index',
                        'message' => $message));

	}
    public function op_professor()
    {
        if (!$this->user_is_connected(USER_TYPE_PROF))
            $this->set_public_message("Vous n'êtes pas connecté, merci de se connecter.",
                'info', USER_TYPE_PROF_HOME);
        $this->load->library('form_validation');
        $prefix = 'prof';
        $this->form_validation->set_rules($prefix . '_id', 'ID', 'required|trim');
        $this->form_validation->set_rules($prefix . '_title', 'Titre professionel',
            'required|trim|max_length[255]');
        $this->form_validation->set_rules($prefix . '_l_name', 'Nom',
            'required|trim|max_length[80]');
        $this->form_validation->set_rules($prefix . '_f_name', 'Prénom',
            'required|trim|max_length[80]');
        $this->form_validation->set_rules($prefix . '_email', 'Email',
            'required|trim|valid_email|max_length[100]');
        $this->form_validation->set_rules($prefix . '_address', 'Adresse',
            'required|trim|max_length[255]');
        $this->form_validation->set_rules($prefix . '_function', 'Fonction',
            'required|trim');
        $this->form_validation->set_rules($prefix . '_presentation', 'Présentation',
            'required|trim');
        $this->form_validation->set_rules($prefix . '_biography', 'Biographie',
            'required|trim');
        $this->form_validation->set_rules($prefix . '_graduate', 'Diplômes', 'trim');
        $this->form_validation->set_rules($prefix . '_expertise_domains', 'Domaines d\'expertise',
            'trim');
        $this->form_validation->set_rules($prefix . '_research_activities',
            'Activités de recherche', 'trim');
        $this->form_validation->set_rules($prefix . '_teaching_activities', 'Activités d\'enseignement',
            'trim');
        $this->form_validation->set_rules($prefix . '_tel', 'Téléphone',
            'trim|max_length[20]');
        $this->form_validation->set_rules($prefix . '_fax', 'Fax', 'trim|max_length[20]');
        $this->form_validation->set_rules($prefix . '_ws', 'Siteweb',
            'trim|prep_url|callback_valid_url|max_length[255]');
		$this->form_validation->set_rules($prefix . '_departement', 'Departement',
            'trim');

        $errors = false;

        if ($this->form_validation->run()) {

            if (!empty($_FILES[$prefix . '_img']['name'])) {
                $config = array();
                $config['upload_path'] = UPLOADS_PROFILE_IMG_PATH;
                $config['allowed_types'] = UPLOADS_IMG_ALLOWED_TYPES;
                //                $config['max_size'] = UPLOADS_IMG_MAX_SIZE;
                //                $config['max_width'] = UPLOADS_IMG_MAX_WIDTH;
                //                $config['max_height'] = UPLOADS_IMG_MAX_HEIGHT;
                $config['encrypt_name'] = true;
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload($prefix . '_img'))
                    $errors = $this->upload->display_errors();
                else
                    $file_image_data = $this->upload->data();
            }

			   if (!empty($_FILES[$prefix . '_cv']['name'])) {
                $configcv = array();
                $configcv['upload_path'] = UPLOADS_PROFILE_CV_PATH;
                $configcv['allowed_types'] = UPLOADS_CV_ALLOWED_TYPES;
                //                $config['max_size'] = UPLOADS_IMG_MAX_SIZE;
                //                $config['max_width'] = UPLOADS_IMG_MAX_WIDTH;
                //                $config['max_height'] = UPLOADS_IMG_MAX_HEIGHT;
                $configcv['encrypt_name'] = true;
                $this->load->library('upload', $configcv);
                if (!$this->upload->do_upload($prefix . '_cv'))
                    $errors = $this->upload->display_errors();
                else
                    $file_cv_data = $this->upload->data();
            }

		 if ($errors === false) {

		       $this->load->model('Professor_model', 'professor');
                $this->load->model('Publication_model', 'publication');
                $message = "Vos informations ont été correctement modifiées..";


			        $options = array(
                    'professorTitle' => $this->input->post($prefix . '_title'),
                    'professorFirstName' => $this->input->post($prefix . '_f_name'),
                    'professorLastName' => $this->input->post($prefix . '_l_name'),
                    'professorEmail' => $this->input->post($prefix . '_email'),
                    'professorAddress' => $this->input->post($prefix . '_address'),
                    'professorFunction' => $this->input->post($prefix . '_function'),
                    'professorPresentation' => $this->input->post($prefix . '_presentation'),
                    'professorBiography' => $this->input->post($prefix . '_biography'),
                    'professorGraduate' => $this->input->post($prefix . '_graduate'),
                    'professorExpertiseDomains' => $this->input->post($prefix . '_expertise_domains'),
                    'professorResearchActivities' => $this->input->post($prefix .
                        '_research_activities'),

                    'professorPhone' => $this->input->post($prefix . '_tel'),
                    'professorFax' => $this->input->post($prefix . '_fax'),
                    'professorWebsite' => $this->input->post($prefix . '_ws'),
					'professorTeachingActivities' => $this->input->post($prefix .
                        '_teaching_activities'),
						'dept_id' => $this->input->post($prefix . '_departement')
                    //'user_id' => $this->user_id
					);


			 if (isset($file_image_data['file_name']))
                    $options['professorImg'] = $file_image_data['file_name'];

			if (isset($file_cv_data['file_name']))
                    $options['linkfile'] = $file_cv_data['file_name'];

              if ($this->professor->update($options, $this->input->post($prefix . '_id'))) {


				// $optiont=array(
				// 'professorTitle' => $this->input->post($prefix . '_title'),
                    // 'professorFirstName' => $this->input->post($prefix . '_f_name'),
                    // 'professorLastName' => $this->input->post($prefix . '_l_name'),
                    // 'professorEmail' => $this->input->post($prefix . '_email'),
                    // 'professorAddress' => $this->input->post($prefix . '_address'),
                    // 'professorFunction' => $this->input->post($prefix . '_function'),
					    // 'professorPresentation' => $this->input->post($prefix . '_presentation'),
                    // 'professorBiography' => $this->input->post($prefix . '_biography'),
                    // 'professorGraduate' => $this->input->post($prefix . '_graduate'),
					// 'professorExpertiseDomains' => $this->input->post($prefix . '_expertise_domains'),
					  // 'professorResearchActivities' => $this->input->post($prefix .
                        // '_research_activities'),
					 // 'professorPhone' => $this->input->post($prefix . '_tel'),
                    // 'professorFax' => $this->input->post($prefix . '_fax'),



				// );
			    // if($this->professor->update($options,$this->input->post($prefix . '_id')))

		       // $this->set_public_message($message.'professorTitle='.$this->input->post($prefix . '_title').'professorFirstName='.$this->input->post($prefix . '_f_name'). 'professorLastName='.$this->input->post($prefix . '_l_name').'professorEmail='.$this->input->post($prefix . '_email').'professorAddress='.$this->input->post($prefix . '_address').'professorFunction='.$this->input->post($prefix . '_function').'professorFunction='.$this->input->post($prefix . '_function').'professorPresentation='.$this->input->post($prefix . '_presentation').'professorBiography='.$this->input->post($prefix . '_biography'). 'professorGraduate='.$this->input->post($prefix . '_graduate').'professorExpertiseDomains='.$this->input->post($prefix . '_expertise_domains'). 'professorResearchActivities='.$this->input->post($prefix .'_research_activities').'professorPhone='.$this->input->post($prefix . '_tel').'professorFax='.$this->input->post($prefix . '_fax'). 'professorPhone='.$this->input->post($prefix . '_tel').'professorFax='.$this->input->post($prefix . '_fax').'professorWebsite='.$this->input->post($prefix . '_ws').'user_id='.$this->user_id, 'success');



                    $errorst=false;
                    $publications_index_arr = array_unique(explode(',', $this->input->post('pub_number')));
                    $new_pubs = array();

                    foreach ($publications_index_arr as $i) {
                        $publicationTitle = $this->input->post($prefix . '_pub_title-' . $i);
                        $publicationLink = $this->input->post($prefix . '_pub_link-' . $i);
                        if (empty($publicationTitle) || empty($publicationLink)){
                            continue;
							$errorst=true;
						}
                      $this->form_validation->set_rules($prefix . '_pub_title-' . $i, 'Titre de publication', 'trim|max_length[255]');
                      $this->form_validation->set_rules($prefix . '_pub_link-' . $i,'Lien de publication', 'trim|prep_url|callback_valid_url|max_length[255]');
                        if ($this->form_validation->run()) {
                            $publicationLink = $this->input->post($prefix . '_pub_link-' . $i);

							if(isset($publicationTitle) && !empty($publicationTitle) && isset($publicationLink) && !empty($publicationLink)){
                            $new_pubs[] = $this->publication->create(array(
                                'professor_id' => $this->input->post($prefix . '_id'),
                                'publicationTitle' => $publicationTitle,
                                'publicationLink' => $publicationLink));
							}

                        } else {
                            echo json_encode(array('status' => '0', 'errors' => validation_errors()));
                            return;
                        }
                    }

		if($errorst){
			 echo json_encode(array('status' => '0', 'errors' => validation_errors()));
                            return;
		}


              if(!empty($new_pubs) && isset($new_pubs)){

				  $this->publication->delete('professor_id = ' . $this->input->post($prefix . '_id') .
                   ' AND ID NOT IN (' . implode(',', $new_pubs) . ')');

			 }




				 $this->set_public_message($message,'success');
				   echo json_encode(array(
                        'status' => '1',
                        'url' => 'enseignant/index',
                        'message' => $message));



              }else{
                    if ($errors === false)
                        $errors = "Une erreur est survenue lors du traitement, merci de réessayer.";
				$error="erreur de tratiement des données";
               echo json_encode(array(
                        'status' => '1',
                        'url' => 'enseignant/index',
                        'errors' => $error));

			  }


					// 'professorTitle='.$this->input->post($prefix . '_title').
                    // 'professorFirstName='.$this->input->post($prefix . '_f_name').
                    // 'professorLastName='.$this->input->post($prefix . '_l_name').
                    // 'professorEmail='.$this->input->post($prefix . '_email').
                    // 'professorAddress='.$this->input->post($prefix . '_address').
                    // 'professorFunction='.$this->input->post($prefix . '_function').
                    // 'professorPresentation='.$this->input->post($prefix . '_presentation'.
                    // 'professorBiography='.$this->input->post($prefix . '_biography').
                    // 'professorGraduate='.$this->input->post($prefix . '_graduate').
                    // 'professorExpertiseDomains='.$this->input->post($prefix . '_expertise_domains').
                    // 'professorResearchActivities='.$this->input->post($prefix .
                        // '_research_activities').
                    // 'professorTeachingActivities'=.$this->input->post($prefix .'_teaching_activities').
                    // 'professorPhone='.$this->input->post($prefix . '_tel').
                    // 'professorFax='.$this->input->post($prefix . '_fax').
                    // 'professorWebsite='.$this->input->post($prefix . '_ws').
                    // 'user_id='.$this->user_id

					//===========
		            //'professorTeachingActivities'=.$this->input->post($prefix .'_teaching_activities')
		 //===============================================






		 }







        } else
            $errors = validation_errors();
        if ($errors !== false)
            echo json_encode(array('status' => '0', 'errors' => $errors));
    }

    public function del_prof_publication($id = null)
    {
        if (!$this->user_is_connected(USER_TYPE_PROF))
            $this->set_public_message("Vous n'êtes pas connecté, merci de se connecter.",
                'info', USER_TYPE_PROF_HOME);
        if (($id = intval($id))) {
            $this->load->model('Publication_model', 'publication');
            if ($this->publication->delete($id)) {
                echo json_encode(array('status' => '1'));
            } else
                echo json_encode(array('status' => '0', 'errors' =>
                        "Une erreur est survenue lors de traitement de votre demande. Merci de réessayer plus tard."));
        } else {
            echo json_encode(array('status' => '0', 'errors' =>
                    "Aucune publication sélectionnée à supprimer!"));
        }
    }


    public function del_annonce($id= null){

            $error=false;

            $idannonce = $this->input->post('idannonce');
            if($idannonce){

              $delstatus = $this->annonce->delete_annonce($idannonce);

              if($delstatus){
            $idpage=$this->page->getIdPageAnnonce($idannonce);
              if(isset($idpage) && !empty($idpage)){
                $idel=$this->page->deletePage($idpage);
              if($idel){
               $data = array(
                'status' => '1',
                'url' => 'administration/emploifiliere#bc');

            //Either you can print value or you can send value to database
            echo json_encode($data);
                 }else{
                    $error=true;
                 }
         }else{
                $error=true;
              }
            }else{
                 $error=true;
            }
        }else{
            $error=true;
        }

        if($error) {
            $errors = "Probleme d'insertion ";
             echo json_encode(array('status' => '0', 'errors' => $errors));
        }
    }

    public function op_emploi()
    {

        $this->load->library('form_validation');
        //

   $this->form_validation->set_rules('title', 'Titre','required|trim|max_length[255]');
   $this->form_validation->set_rules('branch_id', 'Branch','required|trim');
   $this->form_validation->set_rules('level_id', 'Niveau','required|trim');
   $this->form_validation->set_rules('year', 'Annee','required|trim');
   $this->form_validation->set_rules('group_id', 'Groupe','required|trim');

    //description

 //        $errors = false;

        if ($this->form_validation->run()) {
          //  $result = false;
            $message = "l'emploi du temps est ajouté avec succés";
            $this->set_public_message($message, 'success');

            // json_encode(array('username' => '1', 'pwd' => 'administration/pages#bc'));
            $permanent_link = $this->input->post('permanent_link');
            $group_id = $this->input->post('group_id');
            $title = $this->input->post('title');
            $level = $this->input->post('level_id');
            $year = $this->input->post('year');
            //$description = $this->input->post('description');
            $branch = $this->input->post('branch_id');
//

               /***** ajout ****/
            // $branch_id= $this->annonce->branchByName($branch);
            // echo $branch_id[0]->id;

                //$level_id=$this->annonce->levelByNum($level);
                //echo $level_id[0]->id;
                //$rel=$this->annonce->rel_branchs_levelsbyid($level_id[0]->id,$branch_id[0]->id);

                //echo $rel[0]->id;
               //$level_id[0]->id,$branch_id[0]->id,


               $addEmploit=$this->annonce->ajoutEmploit('emploiA',$year,$level,$branch,$group_id,$title,$permanent_link,'');
               if($addEmploit == false){

                $errors = "Probleme d'insertion ";
                echo json_encode(array('status' => '0', 'errors' => $errors));
               }

               $data=array(
               'pageLinkPermanent' =>$permanent_link,
               'pageTitle' => $title,
               'annonce_id'  => $addEmploit,
               );
              $addEmploitPag=$this->page->create($data);
               if($addEmploitPag == false){

                $errors = "Probleme d'insertion ";
                echo json_encode(array('status' => '0', 'errors' => $errors));
               }
               //echo $addEmploit;
                   /***** ajout ****/




            $data = array(
             //   'permanent_link' => $permanent_link,
//                'group_id' => $group_id,
//                'title' => $title,
//                'level' => $level,
//                'year' => $year,
//                'description' => $description,
//                'branch' => $branch,
                'status' => '1',
                'url' => 'administration/pages#bc');

            //Either you can print value or you can send value to database
            echo json_encode($data);
        }else{
             $errors = "Probleme de validation de formulaire";
             echo json_encode(array('status' => '0', 'errors' => $errors));
        }
        //json_encode(array('status' => '1', 'url' => 'administration/pages#bc'));
        //        $this->annonce->branchByName('Argonomie');


    }

    public function op_page()
    {
        if (!$this->user_is_connected(USER_TYPE_ADMIN))
            $this->set_public_message("Vous n'êtes pas connecté, merci de se connecter.",
                'info', USER_TYPE_ADMIN_HOME);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('id', 'ID', 'required|trim');
        $this->form_validation->set_rules('title', 'Titre',
            'required|trim|max_length[255]');
        $this->form_validation->set_rules('description', 'Description', 'required|trim');
        $this->form_validation->set_rules('permanent_link', 'Lien permanent',
            'required|trim|alpha_dash');
        $errors = false;
        if ($this->form_validation->run()) {
            $permanent_link = convert_accented_characters(strtolower($this->input->post('permanent_link')));
            $result = false;

            if ($this->page->read('*', "pageLinkPermanent LIKE '" . $this->input->post('permanent_link') .
                "' AND id <> " . $this->input->post('id'))) {
                   $errors = 'Le champ <strong>Lien permanent</strong> est une clé unique, une page statique existe déjà avec le lien: <i>' .
                    $this->input->post('permanent_link') . '</i>.';
            } else {
                if (($id = $this->input->post('id'))) {
                    $message = "La page statique a été modifié avec succès.";
                    $result = $this->page->update(array(
                        'pageTitle' => $this->input->post('title'),
                        'pageDescription' => $this->input->post('description'),
                        'pageDescriptionBrut' => trim_str($this->input->post('description')),
                        'pageLinkPermanent' => $permanent_link,
                        'user_id' => $this->user_id), $id);
                } else {
                    $message = "La page statique a été ajouté avec succès.";
                    $result = $this->page->create(array(
                        'pageTitle' => $this->input->post('title'),
                        'pageDescription' => $this->input->post('description'),
                        'pageDescriptionBrut' => trim_str($this->input->post('description')),
                        'pageLinkPermanent' => $permanent_link,
                        'user_id' => $this->user_id));
                }
                if ($result) {
                    $this->set_public_message($message, 'success');
                    echo json_encode(array('status' => '1', 'url' => 'administration/pages#bc'));
                } else
                    if ($errors === false)
                        $errors = "Une erreur est survenue lors du traitement, merci de réessayer.";
            }
        } else
            $errors = validation_errors();
        if ($errors !== false)
            echo json_encode(array('status' => '0', 'errors' => $errors));
    }

    public function op_association()
    {
        if (!$this->user_is_connected(USER_TYPE_ADMIN))
            $this->set_public_message("Vous n'êtes pas connecté, merci de se connecter.",
                'info', USER_TYPE_ADMIN_HOME);
        $this->load->helper('text');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('id', 'ID', 'required|trim');
        $this->form_validation->set_rules('title', 'Titre',
            'required|trim|max_length[255]');
        $this->form_validation->set_rules('description', 'Description', 'required|trim');
        $this->form_validation->set_rules('permanent_link', 'Lien permanent',
            'required|trim|alpha_dash');
        $errors = false;
        if ($this->form_validation->run()) {
            $this->form_validation->set_rules('permanent_link', 'Lien permanent',
                'is_unique[associations.associationLinkPermanent]');
            $this->form_validation->set_message('is_unique',
                'Le champ <strong>%s</strong> est une clé unique, une association existe déjà avec le lien: <i>' .
                $this->input->post('permanent_link') . '</i>.');
            $permanent_link = convert_accented_characters(strtolower($this->input->post('permanent_link')));

            $result = false;
			$typeetd=$this->input->post('typeass');

		/****************************************************************/
			     if (!empty($_FILES['association_img']['name'])) {
                    $config = array();
                    $config['upload_path'] = UPLOADS_IMG_PATH;
                    $config['allowed_types'] = UPLOADS_IMG_ALLOWED_TYPES;
                    //                $config['max_size'] = UPLOADS_IMG_MAX_SIZE;
                    //                $config['max_width'] = UPLOADS_IMG_MAX_WIDTH;
                    //                $config['max_height'] = UPLOADS_IMG_MAX_HEIGHT;
                    $config['encrypt_name'] = true;
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('association_img'))
                        $errors = $this->upload->display_errors();
                    else
                        $file_image_data = $this->upload->data();
                }

		/****************************************************************/
            if (($id = $this->input->post('id'))) {
                $message = "L'association a été modifié avec succès.";

				$result=array(
                    'associationTitle' => $this->input->post('title'),
                    'associationDescription' => $this->input->post('description'),
                    'associationDescriptionBrut' => trim_str($this->input->post('description')),
                    'associationLinkPermanent' => $permanent_link,
                    'type' =>$typeetd,
                    'user_id' => $this->user_id);


					 if (isset($file_image_data['file_name']))
                       $result['logo'] = $file_image_data['file_name'];
				   $resulte = $this->association->update($result, $id);

            } else {
                if ($this->form_validation->run()) {
                    $message = "L'association a été ajouté avec succès.";
					$result =array(
                        'associationTitle' => $this->input->post('title'),
                        'associationDescription' => $this->input->post('description'),
                        'associationDescriptionBrut' => trim_str($this->input->post('description')),
                        'associationLinkPermanent' => $permanent_link,
						'type' =>$typeetd,
                        'user_id' => $this->user_id);

					if (isset($file_image_data['file_name']))
                      $result['logo'] = $file_image_data['file_name'];
				   $resulte = $this->association->create($result);

                } else
                    $errors = validation_errors();
            }
            if ($result) {
                $this->set_public_message($message, 'success');
                echo json_encode(array('status' => '1', 'url' =>
                        'administration/associations#bc'));
            } else
                if ($errors === false)
                    $errors = "Une erreur est survenue lors du traitement, merci de réessayer.";
        } else
            $errors = validation_errors();
        if ($errors !== false)
            echo json_encode(array('status' => '0', 'errors' => $errors));
    }

    public function op_annonce()
    {
        if (!$this->user_is_connected(USER_TYPE_ADMIN))
            $this->set_public_message("Vous n'êtes pas connecté, merci de se connecter.",
                'info', USER_TYPE_ADMIN_HOME);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('id', 'ID', 'required|trim');
        $this->form_validation->set_rules('title', 'Titre',
            'required|trim|max_length[255]');
        $this->form_validation->set_rules('description', 'Description', 'trim');
        $this->form_validation->set_rules('is_published', 'Publication', 'required|trim');
        $this->form_validation->set_rules('link', 'Lien', 'required|trim');
        $errors = false;
        if ($this->form_validation->run()) {
            $result = false;
            if (($id = $this->input->post('id'))) {
                $message = "L'annonce a été modifiée avec succès.";
                $result = $this->ad->update(array(
                    'adTitle' => $this->input->post('title'),
                    'adDescription' => $this->input->post('description'),
                    'adIsPublished' => $this->input->post('is_published') == '1' ? '1' : '0',
                    'adLink' => $this->input->post('link'),
                    'user_id' => $this->user_id), $id);
            } else {
                $message = "L'annonce a été ajoutée avec succès.";
                $result = $this->ad->create(array(
                    'adTitle' => $this->input->post('title'),
                    'adDescription' => $this->input->post('description'),
                    'adIsPublished' => $this->input->post('is_published') == '1' ? '1' : '0',
                    'adLink' => $this->input->post('link'),
                    'user_id' => $this->user_id));
            }
            if ($result) {
                $this->set_public_message($message, 'success');
                echo json_encode(array('status' => '1', 'url' => 'administration/annonces#bc'));
            } else
                if ($errors === false)
                    $errors = "Une erreur est survenue lors du traitement, merci de réessayer.";
        } else
            $errors = validation_errors();
        if ($errors !== false)
            echo json_encode(array('status' => '0', 'errors' => $errors));
    }

    public function delete_elm($type = '')
    {
        $del = false;
        switch ($type) {
            case 'news':
                $del = $this->user_is_connected(USER_TYPE_ADMIN) ? true : false;
                $model = $this->news;
                break;
            case 'events':
            case 'event':
                $del = $this->user_is_connected(USER_TYPE_ADMIN) ? true : false;
                $model = $this->event;
                break;
            case 'page':
            case 'pages':
                $del = $this->user_is_connected(USER_TYPE_ADMIN) ? true : false;
                $model = $this->page;
                break;
            case 'ad':
            case 'ads':
            case 'annonce':
            case 'annonces':
                $del = $this->user_is_connected(USER_TYPE_ADMIN) ? true : false;
                $model = $this->ad;
                break;
            case 'association':
            case 'associations':
                $del = $this->user_is_connected(USER_TYPE_ADMIN) ? true : false;
                $model = $this->association;
                break;
            case 'professors':
                $del = $this->user_is_connected(USER_TYPE_ADMIN) ? true : false;
                $model = $this->professor;
                break;
            case 'pub':
            case 'publication':
                $del = $this->user_is_connected(USER_TYPE_PROF) ? true : false;
                $model = $this->publication;
                break;
            case 'student':
            case 'students':
                $del = $this->user_is_connected(USER_TYPE_ADMIN) ? true : false;
                $model = $this->student;
                break;
            case 'parent':
            case 'parents':
                $del = $this->user_is_connected(USER_TYPE_ADMIN) ? true : false;
                $model = $this->parent;
                break;
            case 'subject':
            case 'subjects':
            case 'module':
            case 'modules':
                $del = $this->user_is_connected(USER_TYPE_ADMIN) ? true : false;
                $model = $this->module;
                break;
            case 'branch':
            case 'branchs':
                $del = $this->user_is_connected(USER_TYPE_ADMIN) ? true : false;
                $model = $this->branch;
                break;
            case 'yearcalendars':
            case 'yearcalendar':
                $del = $this->user_is_connected(USER_TYPE_ADMIN) ? true : false;
                $model = $this->yearCalendar;
                break;
            case 'notes':
            case 'note':
                $del = $this->user_is_connected(USER_TYPE_ADMIN_PARTIAL) ? true : false;
                $model = $this->note;
                break;
            case 'attestations--attestation_salaire':
            case 'attestations--attestation_travail':
            case 'attestations--attestation_scolaire':
            case 'attestations--attestation_conge':
            case 'attestations--ordre_mission':
                $del = $this->user_is_connected(USER_TYPE_ADMIN_PARTIAL) ? true : false;
                $model = $this->attestation;
                break;
        }
        if ($del === true) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('id', 'élément', 'required|trim');
            $errors = false;
            if ($this->form_validation->run()) {
                if ($model->delete('id IN (' . $this->input->post('id') . ')')) {
                    $this->set_public_message('Votre requête de suppression a été correctement traitée.',
                        'success');
                    echo json_encode(array('status' => '1'));
                } else
                    if ($this->input->post('id') == '0') {
                        echo json_encode(array('status' => '1'));
                    } else
                        $errors = "Une erreur est survenue lors de traitement de votre demande. Merci de réessayer plus tard.";
            } else
                $errors = validation_errors();
            if ($errors !== false)
                echo json_encode(array('status' => '0', 'errors' => $errors));
        } else
            redirect(base_url());
    }

    public function publish_elm($type = '')
    {
        $del = false;
        switch ($type) {
            case 'news':
                $del = $this->user_is_connected(USER_TYPE_ADMIN) ? true : false;
                $model = $this->news;
                $options = array('newsIsPublished' => '1');
                break;
            case 'events':
            case 'event':
                $del = $this->user_is_connected(USER_TYPE_ADMIN) ? true : false;
                $model = $this->event;
                $options = array('eventIsPublished' => '1');
                break;
            case 'ad':
            case 'ads':
            case 'annonce':
            case 'annonces':
                $del = $this->user_is_connected(USER_TYPE_ADMIN) ? true : false;
                $model = $this->ad;
                $options = array('adIsPublished' => '1');
                break;
        }
        if ($del === true) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('id', 'élément', 'required|trim');
            $errors = false;
            if ($this->form_validation->run()) {
                if ($model->update($options, 'id IN (' . $this->input->post('id') . ')')) {
                    $this->set_public_message('Votre élément a été correctement publié.', 'success');
                    echo json_encode(array('status' => '1'));
                } else {
                    $errors = "Une erreur est survenue lors de traitement de votre demande. Merci de réessayer plus tard.";
                }
            } else
                $errors = validation_errors();
            if ($errors !== false)
                echo json_encode(array('status' => '0', 'errors' => $errors));
        } else
            redirect(base_url());
    }

    public function blur_elm($type = '')
    {
        $del = false;
        switch ($type) {
            case 'news':
                $del = $this->user_is_connected(USER_TYPE_ADMIN) ? true : false;
                $model = $this->news;
                $options = array('newsIsPublished' => '0');
                break;
            case 'events':
            case 'event':
                $del = $this->user_is_connected(USER_TYPE_ADMIN) ? true : false;
                $model = $this->event;
                $options = array('eventIsPublished' => '0');
                break;
            case 'ad':
            case 'ads':
            case 'annonce':
            case 'annonces':
                $del = $this->user_is_connected(USER_TYPE_ADMIN) ? true : false;
                $model = $this->ad;
                $options = array('adIsPublished' => '0');
                break;
        }
        if ($del === true) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('id', 'élément', 'required|trim');
            $errors = false;
            if ($this->form_validation->run()) {
                if ($model->update($options, 'id IN (' . $this->input->post('id') . ')')) {
                    $this->set_public_message('Votre élément a été correctement mis en brouillon.',
                        'success');
                    echo json_encode(array('status' => '1'));
                } else {
                    $errors = "Une erreur est survenue lors de traitement de votre demande. Merci de réessayer plus tard.";
                }
            } else
                $errors = validation_errors();
            if ($errors !== false)
                echo json_encode(array('status' => '0', 'errors' => $errors));
        } else
            redirect(base_url());
    }

    public function op_news()
    {
        if (!$this->user_is_connected(USER_TYPE_ADMIN))
            $this->set_public_message("Vous n'êtes pas connecté, merci de se connecter.",
                'info', USER_TYPE_ADMIN_HOME);
        $prefix = 'news';
        $this->load->library('form_validation');
        $this->form_validation->set_rules($prefix . '_id', 'ID', 'trim');
        $this->form_validation->set_rules($prefix . '_title', 'Titre',
            'required|trim|max_length[255]');
        $this->form_validation->set_rules($prefix . '_description', 'Description',
            'required|trim');
        $this->form_validation->set_rules($prefix . '_video_link', 'Lien vidéo', 'trim');
        $this->form_validation->set_rules($prefix . '_is_published',
            'Publier cet élément', 'required|trim');
        $errors = false;
        if ($this->form_validation->run()) {
            $output = array();
            $youtube_link = $this->input->post($prefix . '_video_link') ? $this->input->
                post($prefix . '_video_link') : '';
            if (!empty($youtube_link) && !preg_match('#youtube\.com/(watch\?v|\?v)=([0-9a-z_\-]+)#i',
                $youtube_link, $output)) {
                $errors = 'Le lien vidéo est invalide! veuillez insérer un lien Youtube valide.';
            } else
                if (isset($output[2])) {
                    $youtube_link = $output[2];
                } else {
                    $youtube_link = '';
                }
                if (!empty($_FILES[$prefix . '_img']['name'])) {
                    $config = array();
                    $config['upload_path'] = UPLOADS_IMG_PATH;
                    $config['allowed_types'] = UPLOADS_IMG_ALLOWED_TYPES;
                    //                $config['max_size'] = UPLOADS_IMG_MAX_SIZE;
                    //                $config['max_width'] = UPLOADS_IMG_MAX_WIDTH;
                    //                $config['max_height'] = UPLOADS_IMG_MAX_HEIGHT;
                    $config['encrypt_name'] = true;
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload($prefix . '_img'))
                        $errors = $this->upload->display_errors();
                    else
                        $file_image_data = $this->upload->data();
                }
            if ($errors === false) {
                if (($news_id = $this->input->post($prefix . '_id'))) {
                    $message = "L'actualité a été modifié avec succès.";
                    $options = array(
                        'newsTitle' => htmlspecialchars($this->input->post($prefix . '_title')),
                        'newsDescription' => $this->input->post($prefix . '_description'),
                        'newsDescriptionBrut' => trim_str($this->input->post($prefix . '_description')),
                        //                            'newsPermanentLink' => $link,
                        'newsVideo' => $youtube_link,
                        'newsIsPublished' => $this->input->post($prefix . '_is_published') == '1' ? '1' :
                            '0',
                        'user_id' => $this->user_id);
                    if (isset($file_image_data['file_name']))
                        $options['newsImg'] = $file_image_data['file_name'];
                    $result = $this->news->update($options, $news_id);
                } else {
                    $message = "L'actualité a été ajouté avec succès.";
                    $options = array(
                        'newsTitle' => htmlspecialchars($this->input->post($prefix . '_title')),
                        'newsDescription' => $this->input->post($prefix . '_description'),
                        'newsDescriptionBrut' => trim_str($this->input->post($prefix . '_description')),
                        //                    'newsPermanentLink' => $link,
                        'newsVideo' => $youtube_link,
                        'newsIsPublished' => $this->input->post($prefix . '_is_published') == '1' ? '1' :
                            '0',
                        'user_id' => $this->user_id);
                    if (isset($file_image_data['file_name']))
                        $options['newsImg'] = $file_image_data['file_name'];
                    $result = $this->news->create($options);
                }
                if ($result) {
                    $this->set_public_message($message, 'success');
                    echo json_encode(array('status' => '1', 'url' => 'administration/news'));
                } else
                    $errors = "Une erreur est survenue lors du traitement, merci de réessayer.";
            }
        } else
            $errors = validation_errors();
        if ($errors !== false)
            echo json_encode(array('status' => '0', 'errors' => $errors));
    }

    public function op_event()
    {
        if (!$this->user_is_connected(USER_TYPE_ADMIN))
            $this->set_public_message("Vous n'êtes pas connecté, merci de se connecter.",
                'info', USER_TYPE_ADMIN_HOME);
        $prefix = 'event';
        $this->load->library('form_validation');
        $this->form_validation->set_rules($prefix . '_id', 'ID', 'trim');
        $this->form_validation->set_rules($prefix . '_title', 'Titre',
            'required|trim|max_length[255]');
        $this->form_validation->set_rules($prefix . '_description', 'Description',
            'required|trim');
        $this->form_validation->set_rules($prefix . '_start_date', 'Date de début',
            'required|trim');
        $this->form_validation->set_rules($prefix . '_end_date', 'Date de fin',
            'required|trim');
        $this->form_validation->set_rules($prefix . '_is_published',
            'Publier cet élément', 'required|trim');
        $errors = false;
        if ($this->form_validation->run()) {
            $start_on = $this->input->post($prefix . '_start_date');
            $end_on = $this->input->post($prefix . '_end_date');
            if (strtotime($start_on) > strtotime($end_on)) {
                $errors = "La date de début de l'événement ne peut pas être suppérieur à la date de fin!";
            } else
                if (!empty($_FILES[$prefix . '_img']['name'])) {
                    $config = array();
                    $config['upload_path'] = UPLOADS_IMG_PATH;
                    $config['allowed_types'] = UPLOADS_IMG_ALLOWED_TYPES;
                    //                $config['max_size'] = UPLOADS_IMG_MAX_SIZE;
                    //                $config['max_width'] = UPLOADS_IMG_MAX_WIDTH;
                    //                $config['max_height'] = UPLOADS_IMG_MAX_HEIGHT;
                    $config['encrypt_name'] = true;
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload($prefix . '_img'))
                        $errors = $this->upload->display_errors();
                    else
                        $file_image_data = $this->upload->data();
                }
            if ($errors === false) {
                if (($event_id = $this->input->post($prefix . '_id'))) {
                    $message = "L'événement a été modifié avec succès.";
                    $options = array(
                        'eventTitle' => $this->input->post($prefix . '_title'),
                        'eventDescription' => $this->input->post($prefix . '_description'),
                        'eventDescriptionBrut' => trim_str($this->input->post($prefix . '_description')),
                        //                            'eventPermanentLink' => $link,
                        'eventStartDate' => $this->input->post($prefix . '_start_date'),
                        'eventEndDate' => $this->input->post($prefix . '_end_date'),
                        'eventIsPublished' => $this->input->post($prefix . '_is_published') == '1' ? '1' :
                            '0',
                        'user_id' => $this->user_id);
                    if (isset($file_image_data['file_name']))
                        $options['eventImg'] = $file_image_data['file_name'];
                    $result = $this->event->update($options, $event_id);
                } else {
                    $message = "L'actualité a été ajouté avec succès.";
                    $options = array(
                        'eventTitle' => $this->input->post($prefix . '_title'),
                        'eventDescription' => $this->input->post($prefix . '_description'),
                        'eventDescriptionBrut' => trim_str($this->input->post($prefix . '_description')),
                        //                    'eventPermanentLink' => $link,
                        'eventStartDate' => $this->input->post($prefix . '_start_date'),
                        'eventEndDate' => $this->input->post($prefix . '_end_date'),
                        'eventIsPublished' => $this->input->post($prefix . '_is_published') == '1' ? '1' :
                            '0',
                        'user_id' => $this->user_id);
                    if (isset($file_image_data['file_name']))
                        $options['eventImg'] = $file_image_data['file_name'];
                    $result = $this->event->create($options);
                }
                if ($result) {
                    $this->set_public_message($message, 'success');
                    echo json_encode(array('status' => '1', 'url' => 'administration/events'));
                } else
                    $errors = "Une erreur est survenue lors du traitement, merci de réessayer.";
            }
        } else
            $errors = validation_errors();
        if ($errors !== false)
            echo json_encode(array('status' => '0', 'errors' => $errors));
    }

    public function op_student()
    {
        if (!$this->user_is_connected(USER_TYPE_ADMIN))
            $this->set_public_message("Vous n'êtes pas connecté, merci de se connecter.",
                'info', USER_TYPE_ADMIN_HOME);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('id', 'ID', 'required|trim');
        $this->form_validation->set_rules('NumStudent', 'Numero d\'étudiant',
            'required|trim|max_length[255]');
        $this->form_validation->set_rules('l_name', 'Nom',
            'required|trim|max_length[80]');
        $this->form_validation->set_rules('f_name', 'Prénom',
            'required|trim|max_length[80]');
        $this->form_validation->set_rules('CIN', 'CIN', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('parent_id', 'Parent',
            'required|trim|is_natural_no_zero');
        $this->form_validation->set_rules('birthDay', 'date de naissance',
            'required|trim');
        $this->form_validation->set_rules('login', 'Login',
            'required|trim|max_length[20]');
        $this->form_validation->set_rules('password', 'Mot de passe',
            'required|trim|max_length[20]|min_length[6]');
        $this->form_validation->set_message('is_natural_no_zero',
            'Le champ %s doit contenir une valeur valide.');
        $errors = false;
        $this->load->model('student_model', 'student');
        if ($this->form_validation->run()) {
            $result = false;
            $options = array(
                'studentNumber' => $this->input->post('NumStudent'),
                'studentFirstName' => $this->input->post('f_name'),
                'studentLastName' => $this->input->post('l_name'),
                'studentCin' => $this->input->post('CIN'),
                'studentDateOfBirth' => $this->input->post('birthDay'),
                'studentLogin' => $this->input->post('login'),
                'studentPassword' => sha1($this->input->post('password')),
                'parent_id' => $this->input->post('parent_id'),
                'user_id' => $this->user_id);
            if ($this->student->read('*', "studentLogin LIKE '" . $this->input->post('login') .
                "' && id <> " . $this->input->post('id'))) {
                $errors = "Ce login existe déjà! Merci de choisir un autre.";
            } else {
                if (($id = $this->input->post('id'))) {
                    $message = "Vos informations ont été correctement modifiées..";
                    $result = $this->student->update($options, $id);
                } else {
                    $message = "Vos informations ont été ajouté avec succès.";
                    $result = $this->student->create($options);
                }
                //                var_dump($this->db->last_query());
                if ($result) {
                    $this->set_public_message($message, 'success');
                    echo json_encode(array('status' => '1', 'url' => 'administration/students#bc'));
                } else
                    if ($errors === false)
                        $errors = "Une erreur est survenue lors du traitement, merci de réessayer.";
            }
        } else
            $errors = validation_errors();
        if ($errors !== false)
            echo json_encode(array('status' => '0', 'errors' => $errors));
    }

    public function op_parent()
    {
        if (!$this->user_is_connected(USER_TYPE_ADMIN))
            $this->set_public_message("Vous n'êtes pas connecté, merci de se connecter.",
                'info', USER_TYPE_ADMIN_HOME);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('id', 'ID', 'required|trim');
        $this->form_validation->set_rules('l_name', 'Nom',
            'required|trim|max_length[80]');
        $this->form_validation->set_rules('f_name', 'Prénom',
            'required|trim|max_length[80]');
        $this->form_validation->set_rules('login', 'Login',
            'required|trim|max_length[20]');
        $this->form_validation->set_rules('password', 'Mot de passe',
            'required|trim|max_length[20]');
        $this->form_validation->set_rules('message', 'Message au parent', 'trim');
        $errors = false;
        $this->load->model('parent_model', 'parent');
        if ($this->form_validation->run()) {
            $result = false;
            $options = array(
                'parentFirstName' => $this->input->post('f_name'),
                'parentLastName' => $this->input->post('l_name'),
                'parentLogin' => $this->input->post('login'),
                'parentPassword' => sha1($this->input->post('password')),
                'user_id' => $this->user_id);
            if ($this->input->post('message')) {
                $options['parentMessage'] = $this->input->post('message');
                $options['parentMessageDate'] = date(DATE_FORMAT);
            } else {
                $options['parentMessage'] = '';
                $options['parentMessageDate'] = null;
            }
            if ($this->parent->read('*', "parentLogin LIKE '" . $this->input->post('login') .
                "' && id <> " . $this->input->post('id'))) {
                $errors = "Ce login existe déjà! Merci de choisir un autre.";
            } else {
                if (($id = $this->input->post('id'))) {
                    $message = "Vos informations ont été correctement modifiées..";
                    $result = $this->parent->update($options, $id);
                } else {
                    $message = "Vos informations ont été ajouté avec succès.";
                    $result = $this->parent->create($options);
                }
                if ($result) {
                    $this->set_public_message($message, 'success');
                    echo json_encode(array('status' => '1', 'url' => 'administration/parents#bc'));
                } else
                    if ($errors === false)
                        $errors = "Une erreur est survenue lors du traitement, merci de réessayer.";
            }
        } else
            $errors = validation_errors();
        if ($errors !== false)
            echo json_encode(array('status' => '0', 'errors' => $errors));
    }

    public function op_subject()
    {
        if (!$this->user_is_connected(USER_TYPE_ADMIN))
            $this->set_public_message("Vous n'êtes pas connecté, merci de se connecter.",
                'info', USER_TYPE_ADMIN_HOME);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('id', 'ID', 'trim');
        $this->form_validation->set_rules('name', 'Nom', 'required|trim|max_length[255]');
        $this->form_validation->set_rules('module', 'Module',
            'required|trim|is_natural_no_zero|max_length[255]');
        $this->form_validation->set_message('is_natural_no_zero',
            'Le champ %s doit contenir une valeur valide.');
        $errors = false;
        $this->load->model('Module_model', 'module');
        if ($this->form_validation->run()) {
            $result = false;
            $options = array('moduleName' => $this->input->post('name'), 'parent_id' => $this->
                    input->post('module'));
            if (($id = $this->input->post('id'))) {
                $message = "Vos informations ont été correctement modifiées..";
                $result = $this->module->update($options, $id);
            } else {
                $message = "Vos informations ont été ajouté avec succès.";
                $result = $this->module->create($options);
            }
            if ($result) {
                $this->set_public_message($message, 'success');
                echo json_encode(array('status' => '1', 'url' => 'administration/subjects#bc'));
            } else
                if ($errors === false)
                    $errors = "Une erreur est survenue lors du traitement, merci de réessayer.";
        } else
            $errors = validation_errors();
        if ($errors !== false)
            echo json_encode(array('status' => '0', 'errors' => $errors));
    }

    public function op_module()
    {
        if (!$this->user_is_connected(USER_TYPE_ADMIN))
            $this->set_public_message("Vous n'êtes pas connecté, merci de se connecter.",
                'info', USER_TYPE_ADMIN_HOME);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('id', 'ID', 'trim');
        $this->form_validation->set_rules('name', 'Nom', 'required|trim|max_length[255]');
        $this->form_validation->set_rules('branch_id', 'Filière',
            'required|trim|is_natural_no_zero');
        $this->form_validation->set_rules('level_id', 'Niveau',
            'required|trim|is_natural_no_zero');
        $this->form_validation->set_message('is_natural_no_zero',
            'Le champ %s doit contenir une valeur valide.');
        $errors = false;
        if ($this->form_validation->run()) {
            $result = false;
            $branch_id = intval($this->input->post('branch_id'));
            $level_id = intval($this->input->post('level_id'));
            if ($branch_id && $level_id && ($branch_level_id = $this->rel_branchs_levels->
                read('id', array('branch_id' => $branch_id, 'level_id' => $level_id))) && isset
                ($branch_level_id[0]->id)) {
                $options = array('moduleName' => $this->input->post('name'), 'branchLevel_id' =>
                        $branch_level_id[0]->id);
                if (($id = $this->input->post('id'))) {
                    $message = "Vos informations ont été correctement modifiées..";
                    $result = $this->module->update($options, $id);
                } else {
                    $message = "Vos informations ont été ajouté avec succès.";
                    $result = $this->module->create($options);
                }
            }
            if ($result) {
                $this->set_public_message($message, 'success');
                echo json_encode(array('status' => '1', 'url' => 'administration/modules#bc'));
            } else
                if ($errors === false)
                    $errors = "Une erreur est survenue lors du traitement, merci de réessayer.";
        } else
            $errors = validation_errors();
        if ($errors !== false)
            echo json_encode(array('status' => '0', 'errors' => $errors));
    }

    public function op_branch()
    {
        if (!$this->user_is_connected(USER_TYPE_ADMIN))
            $this->set_public_message("Vous n'êtes pas connecté, merci de se connecter.",
                'info', USER_TYPE_ADMIN_HOME);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('id', 'ID', 'trim');
        $this->form_validation->set_rules('name', 'Nom', 'required|trim|max_length[255]');
        $errors = false;
        $id_branch = null;
        $this->load->model('Branch_model', 'branch');
        if ($this->form_validation->run()) {
            $result = false;
            $options = array('branchName' => $this->input->post('name'), 'user_id' => $this->
                    user_id);
            if (($id = $this->input->post('id'))) {
                $id_branch = $this->input->post('id');
                $message = "Vos informations ont été correctement modifiées.";
                $result = $this->branch->update($options, $id);
            } else {
                $message = "Vos informations ont été ajouté avec succès.";
                if (($result = $this->branch->create($options))) {
                    $levels = $this->level->read('*');
                    foreach ($levels as $value)
                        $this->rel_branchs_levels->create(array('level_id' => $value->id, 'branch_id' =>
                                $result));
                }
            }
            if ($result) {
                $this->set_public_message($message, 'success');
                echo json_encode(array('status' => '1', 'url' => 'administration/branchs'));
            } else
                if ($errors === false)
                    $errors = "Une erreur est survenue lors du traitement, merci de réessayer.";
        } else
            $errors = validation_errors();
        if ($errors !== false)
            echo json_encode(array('status' => '0', 'errors' => $errors));
    }

    public function op_anneeCalendar($student_id = null, $op = 'group')
    {
        if (!$this->user_is_connected(USER_TYPE_ADMIN))
            $this->set_public_message("Vous n'êtes pas connecté, merci de se connecter.",
                'info', USER_TYPE_ADMIN_HOME);
        if (!empty($student_id)) {
            $this->load->library('form_validation');
            $this->load->model('YearCalendar_model', 'yearCalendar');
            $this->form_validation->set_rules('id', 'ID', 'trim');
            $op_is_valide = false;
            switch ($op) {
                case 'group':
                    $this->form_validation->set_rules('group', 'Groupe', 'required|trim');
                    $op_is_valide = true;
                    $key = 'yearcalendarGroupe';
                    $value = $this->input->post('group');
                    break;
                case 'status':
                    $this->form_validation->set_rules('status', 'Status', 'required|trim');
                    $op_is_valide = true;
                    $key = 'yearCalendarStatus';
                    $value = $this->input->post('status');
                    break;
            }
            $errors = false;
            if ($this->form_validation->run() && $op_is_valide) {
                if (($id = $this->input->post('id'))) {
                    if ($this->yearCalendar->update(array($key => $value), array('id' => $id))) {
                        $message = "Le group a été modifié avec succès.";
                        $this->set_public_message($message, 'success');
                        echo json_encode(array('status' => '1', 'url' =>
                                'administration/students/modifier/' . $student_id));
                    } else
                        if ($errors === false)
                            $errors = "Une erreur est survenue lors du traitement, merci de réessayer.";
                } else {
                    $this->form_validation->set_rules('level_id', 'Année [niveau]',
                        'required|trim|is_natural_no_zero');
                    $this->form_validation->set_rules('branch_id', 'Filiere',
                        'required|trim|is_natural_no_zero');
                    $this->form_validation->set_rules('calendar_year', 'Année scolaire',
                        'required|trim|numeric|min_length[4]|max_length[4]');
                    $this->form_validation->set_rules('group', 'Groupe', 'trim');
                    $this->form_validation->set_message('is_natural_no_zero',
                        'Le champ %s doit contenir une valeur valide.');
                    if ($this->form_validation->run()) {
                        $branchLevel_id = $this->rel_branchs_levels->read('id', array('branch_id' => $this->
                                input->post('branch_id'), 'level_id' => $this->input->post('level_id')));
                        if (empty($branchLevel_id)) {
                            $errors = "Une erreur système est survenue lors du traitement, merci de réessayer.";
                        } else {
                            $options = array(
                                'yearcalendarGroupe' => $this->input->post('group'),
                                'branchLevel_id' => $branchLevel_id[0]->id,
                                'student_id' => $student_id,
                                'yearcalendarName' => $this->input->post('calendar_year'),
                                'user_id' => $this->user_id);
                            if (($year_arr = $this->yearCalendar->read('*', array('student_id' => $student_id,
                                    'yearcalendarName' => $this->input->post('calendar_year')))) && !empty($year_arr)) {
                                $errors = "Cet étudiant est déjà associé à l'année scolaire: <b>" . $this->
                                    input->post('calendar_year') . "</b>.";
                            } else {
                                if ($this->yearCalendar->create($options)) {
                                    $message = "Vos informations ont été ajoutées avec succès.";
                                    $this->set_public_message($message, 'success');
                                    echo json_encode(array('status' => '1', 'url' =>
                                            'administration/students/modifier/' . $student_id));
                                } else
                                    if ($errors === false)
                                        $errors = "Une erreur est survenue lors du traitement, merci de réessayer.";
                            }
                        }
                    } else
                        $errors = validation_errors();
                }
            } else
                $errors = validation_errors();
        } else
            $errors = "L'id de l'étudiant est un paramètre obligatoire!";
        if ($errors !== false)
            echo json_encode(array('status' => '0', 'errors' => $errors));
    }

    public function op_note()
    {
        if (!$this->user_is_connected(USER_TYPE_ADMIN_PARTIAL))
            $this->set_public_message("Vous n'êtes pas connecté, merci de se connecter.",
                'info', USER_TYPE_ADMIN_PARTIAL_HOME);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('id', 'ID', 'trim');
        $this->form_validation->set_rules('note', 'Note',
            'required|trim|numeric|greater_than[-0.99]|less_than[20.01]');
        $this->form_validation->set_rules('remarque', 'Remarques', 'trim');
        $errors = $message = false;
        if ($this->form_validation->run()) {
            $result = false;
            if (($id = $this->input->post('id'))) {
                $message = "La note a été modifiée avec succès.";
                $result = $this->note->update(array(
                    'noteScore' => number_format($this->input->post('note'), 2),
                    'noteRemarques' => $this->input->post('remarque'),
                    'user_id' => $this->user_id), $id);
            } else {
                $this->form_validation->set_rules('calendar_year', 'Année scolaire',
                    'required|trim|is_natural_no_zero');
                $this->form_validation->set_rules('student_id', 'Étudiant',
                    'required|trim|is_natural_no_zero');
                $this->form_validation->set_rules('subject_id', 'Matière',
                    'required|trim|is_natural_no_zero');
                $this->form_validation->set_message('is_natural_no_zero',
                    'Le champ %s doit contenir une valeur valide.');
                if ($this->form_validation->run()) {
                    $year = $this->input->post('calendar_year');
                    $student_id = $this->input->post('student_id');
                    $calendar_year_id = $this->yearCalendar->read('id', array('yearcalendarName' =>
                            $year, 'student_id' => $student_id));
                    if (empty($calendar_year_id)) {
                        $errors = "Une erreur est survenue lors du traitement, merci de contacter l'administrateur du site.";
                    } else {
                        $message = "La note a été ajoutée avec succès.";
                        $result = $this->note->create(array(
                            'subject_id' => $this->input->post('subject_id'),
                            'calendarYear_id' => $calendar_year_id[0]->id,
                            'noteScore' => number_format($this->input->post('note'), 2),
                            'noteRemarques' => $this->input->post('remarque'),
                            'user_id' => $this->user_id));
                    }
                } else
                    $errors = validation_errors();
            }
            if ($result) {
                if ($message)
                    $this->set_public_message($message, 'success');
                echo json_encode(array('status' => '1', 'url' => 'admin/notes'));
            } else
                if ($errors === false)
                    $errors = "Une erreur est survenue lors du traitement, merci de réessayer.";
        } else
            $errors = validation_errors();
        if ($errors !== false)
            echo json_encode(array('status' => '0', 'errors' => $errors));

    }

    public function get_notes()
    {
        if (!$this->user_is_connected(USER_TYPE_ADMIN_PARTIAL))
            $this->set_public_message("Vous n'êtes pas connecté, merci de se connecter.",
                'info', USER_TYPE_ADMIN_PARTIAL_HOME);
        $this->load->library('form_validation');

        $this->form_validation->set_message('is_natural_no_zero',
            'Le champ %s scolaire doit être sélectionné.');

        $this->form_validation->set_rules('year_calendar', 'Année scolaire',
            'trim|is_natural_no_zero');
        $this->form_validation->set_rules('student_id', 'Étudiant', 'trim');
        $this->form_validation->set_rules('branch_id', 'Filiére',
            'trim|is_natural_no_zero');
        $this->form_validation->set_rules('level_id', 'Niveau',
            'trim|is_natural_no_zero');
        $this->form_validation->set_rules('subject_id', 'Matière', 'trim');
        $errors = false;
        if ($this->form_validation->run()) {
            $data = array();
            $options = array(
                'year' => $this->input->post('year_calendar') ? $this->input->post('year_calendar') : null,
                'student_id' => $this->input->post('student_id') ? $this->input->post('student_id') : null,
                'subject_id' => $this->input->post('subject_id') ? $this->input->post('subject_id') : null);
            $data['notes_arr'] = $this->note->get_notes_by_joining($options);
            $code = $this->load->view('list_notes_view', $data, true);
            echo json_encode(array('status' => '1', 'code' => $code));
        } else
            $errors = validation_errors();
        if ($errors !== false)
            echo json_encode(array('status' => '0', 'errors' => $errors));
    }

    public function get_notes2()
    {
        if (!$this->user_is_connected(USER_TYPE_ADMIN_PARTIAL))
            $this->set_public_message("Vous n'êtes pas connecté, merci de se connecter.",
                'info', USER_TYPE_ADMIN_PARTIAL_HOME);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('year_calendar', 'Année scolaire', 'trim');
        $this->form_validation->set_rules('student_id', 'Étudiant', 'trim');
        $this->form_validation->set_rules('branch_id', 'Filiére',
            'trim|is_natural_no_zero');
        $this->form_validation->set_rules('level_id', 'Niveau',
            'trim|is_natural_no_zero');
        $this->form_validation->set_rules('group_id', 'Groupe',
            'trim|is_natural_no_zero');
        $this->form_validation->set_rules('subject_id', 'Matière', 'trim');
        $errors = false;
        if ($this->form_validation->run()) {
            $data = array();
            $options = array(
                'year' => $this->input->post('year_calendar') ? $this->input->post('year_calendar') : null,
                'student_id' => $this->input->post('student_id') ? $this->input->post('student_id') : null,
                'subject_id' => $this->input->post('subject_id') ? $this->input->post('subject_id') : null);
            $data['notes_arr'] = $this->note->get_notes_by_joining($options);
            $code = $this->load->view('list_notes_view', $data, true);
            echo json_encode(array('status' => '1', 'code' => $code));
        } else
            $errors = validation_errors();
        if ($errors !== false)
            echo json_encode(array('status' => '0', 'errors' => $errors));
    }

    //
    public function get_dropdowns($expression = '')
    {
        if (!$this->user_is_connected(USER_TYPE_ADMIN_PARTIAL))
            $this->set_public_message("Vous n'êtes pas connecté, merci de se connecter.",
                'info', USER_TYPE_ADMIN_PARTIAL_HOME);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('type', 'Type', 'required|trim');
        $this->form_validation->set_rules('value', 'Valeur', 'required|trim');
        $this->form_validation->set_rules('year_calendar', 'Année scolaire', 'trim');
        $this->form_validation->set_rules('student_id', 'Étudiant', 'trim');
        $this->form_validation->set_rules('subject_id', 'Matière', 'trim');
        $errors = false;
        if ($this->form_validation->run()) {
            $result = false;
            $data = array('status' => '1');
            $type = $this->input->post('type');
            switch ($type) {
                case 'calendar':
                case 'student':
                    $student_id = $this->input->post('student_id') ? $this->input->post('student_id') :
                        '0';
                    $result = true;
                    $data['type'] = $type;
                    $data['students_dropdown'] = '';
                    $data['subjects_dropdown'] = '';
                    if (($y = $this->input->post('year_calendar'))) {
                        $b = $this->input->post('branch');
                        $g = $this->input->post('group');
                        $l = $this->input->post('level');
                        $arr = ($expression == '') ? array('Tous les étudiants') : array('-- Choisissez un étudiant');
                        if (($results = $this->student->get_students_by_years_calendar($y, $l, $b, $g))) {
                            $data['query'] = $result;
                            //unset($result['query']);
                            foreach ($results as $v)
                                $arr[$v->student_id] = $v->studentFirstName . " " . $v->studentLastName;
                        }
                        $student_id = $type == 'calendar' ? '0' : $student_id;
                        if ($student_id == '0')
                            $student_id = $this->input->post('student_id') ? $this->input->post('student_id') :
                                '0';

                        $data['students_dropdown'] = form_dropdown('student_id', $arr, $student_id,
                            'id="student_id" class="form-control dropdown_evt"');
                    }
                    if ($student_id != '0' && $type == 'student') {
                        $arr2 = ($expression == '') ? array('Toutes les matières') : array('-- Choisissez une matière');
                        if ($this->input->post('action') == 'add') {
                            $branch_id = $this->input->post('branch');
                            $results = $this->module->get_subjects_from_branch($branch_id);
                            foreach ($results as $v) {
                                $arr2[$v->matiere_id] = $v->subjectName;
                            }
                        } else
                            if (($results = $this->module->get_subjects_from_level_branch_id($student_id, $y))) {
                                foreach ($results as $v) {
                                    $arr2[$v->matiere_id] = $v->subjectName;
                                }
                            }
                        $subject_id = $this->input->post('subject_id') ? $this->input->post('subject_id') :
                            '0';
                        $data['subjects_dropdown'] = form_dropdown('subject_id', $arr2, $subject_id,
                            'id="subject_id" class="form-control"');
                    }
                    break;
            }
            if ($result) {
                echo json_encode($data);
            } else
                if ($errors === false)
                    $errors = "Une erreur est survenue lors du traitement, merci de réessayer.";
        } else
            $errors = validation_errors();
        if ($errors !== false)
            echo json_encode(array('status' => '0', 'errors' => $errors));
    }

    public function get_dropdowns2($expression = '')
    {
        if (!$this->user_is_connected(USER_TYPE_ADMIN_PARTIAL))
            $this->set_public_message("Vous n'êtes pas connecté, merci de se connecter.",
                'info', USER_TYPE_ADMIN_PARTIAL_HOME);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('type', 'Type', 'required|trim');
        $this->form_validation->set_rules('value', 'Valeur', 'required|trim');
        $this->form_validation->set_rules('year_calendar', 'Année scolaire', 'trim');
        $this->form_validation->set_rules('student_id', 'Étudiant', 'trim');
        $this->form_validation->set_rules('subject_id', 'Matière', 'trim');
        $errors = false;
        if ($this->form_validation->run()) {
            $result = false;
            $data = array('status' => '1');
            $type = $this->input->post('type');
            switch ($type) {
                case 'calendar':
                case 'student':
                    $student_id = $this->input->post('student_id') ? $this->input->post('student_id') :
                        '0';
                    $result = true;
                    $data['type'] = $type;
                    $data['students_dropdown'] = '';
                    $data['subjects_dropdown'] = '';
                    if (($y = $this->input->post('year_calendar'))) {
                        $b = $this->input->post('branch');
                        $g = $this->input->post('group');
                        $l = $this->input->post('level');
                        $arr = ($expression == '') ? array('Tous les étudiants') : array('-- Choisissez un étudiant');
                        if (($results = $this->student->get_students_by_years_calendar($y, $l, $b, $g))) {
                            $data['query'] = $result;
                            //unset($result['query']);
                            foreach ($results as $v)
                                $arr[$v->student_id] = $v->studentFirstName . " " . $v->studentLastName;
                        }
                        $student_id = $type == 'calendar' ? '0' : $student_id;
                        if ($student_id == '0')
                            $student_id = $this->input->post('student_id') ? $this->input->post('student_id') :
                                '0';

                        $data['students_dropdown'] = form_dropdown('student_id', $arr, $student_id,
                            'id="student_id" class="form-control dropdown_evt"');
                    }
                    if ($student_id != '0' && $type == 'student') {
                        $where = $y ? array('yearcalendarName' => $y) : array();
                        $where['student_id'] = $student_id;
                        $rel_branchs_levels_id = $this->yearCalendar->read('branchLevel_id', $where);
                        $tmp = array();
                        foreach ($rel_branchs_levels_id as $v)
                            $tmp[] = $v->branchLevel_id;
                        $rel_branchs_levels_id = $tmp;
                        //                        var_dump($rel_branchs_levels_id);
                        $tmp = array();
                        $subjects_id = array();
                        if (($results = $this->module->get_subjects_from_level_branch_id($rel_branchs_levels_id))) {
                            foreach ($results as $v)
                                $tmp[] = $v->matiere_id;
                            $subjects_id = $tmp;
                        }
                        //                        var_dump($results);
                        $arr2 = ($expression == '') ? array('Toutes les matières') : array('-- Choisissez une matière');
                        if (!empty($subjects_id) && ($results = $this->module->get_subjects_details($subjects_id)))
                            foreach ($results as $v) {
                                //$arr2[$v->matiere_id] = $v->subjectName." [Module: $v->moduleName - Filière: $v->branchName (Niveau: $v->levelName)]";
                                $arr2[$v->matiere_id] = $v->subjectName;
                            }

                        $subject_id = $this->input->post('subject_id') ? $this->input->post('subject_id') :
                            '0';
                        $data['subjects_dropdown'] = form_dropdown('subject_id', $arr2, $subject_id,
                            'id="subject_id" class="form-control"');
                    }
                    break;
            }
            if ($result) {
                echo json_encode($data);
            } else
                if ($errors === false)
                    $errors = "Une erreur est survenue lors du traitement, merci de réessayer.";
        } else
            $errors = validation_errors();
        if ($errors !== false)
            echo json_encode(array('status' => '0', 'errors' => $errors));
    }

	/**** archive event ********************/


	public function op_archivevent()
	{
		$datat=array(
	   'archive_id' => $this->input->post('archive_id'));
	   $data=array();
	   $this->load->model('news_model', 'news');

	   $result= '';
	     $archivedate = $this->input->post('archive_id');




		 if(!empty($archivedate) && isset($archivedate)){

			$data=$this->event->get_archive($archivedate);
			  //$data = $this->news->read('*', array( 'newsIsPublished' => '1'));

		 }


/*******************************/




 foreach ($data AS $event) {
           $html_table = '<div class="row iav_agenda_item">
                <div class="col-xs-2 iav_agenda_item_poster" style="word-wrap: break-word;">
                    <a href="#">';

                         if ($event->eventStartDate != $event->eventEndDate) {
            $html_table .='Du ';
			$html_table .= date('d/m/Y', strtotime($event->eventStartDate));
			$html_table .=' au<br/>';
			$html_table .=date('d/m/Y', strtotime($event->eventEndDate));
                        } else {
            $html_table .='Le';
			$html_table .=date('d/m/Y', strtotime($event->eventEndDate));
                        }
             $html_table .='</a>
                </div>
                <div class="col-xs-10">';

                    $html_table .='<div class="iav_agenda_item_description">';
                    $html_table .=trim_str($event->eventDescription);
                    $html_table .='</div>
                </div>
            </div>';
        }













	  $arr = array(1, 2, 3, 4);

	  $val=array(
	      'data' => $html_table,
	   );
	   /***********************************/

		echo json_encode($val);

	}
	/*******archive event*******************/

		//archive_news

	public function op_archivenews()
    {
		$datat=array(
	   'archive_id' => $this->input->post('archive_id'));
	   $data=array();
	   $this->load->model('news_model', 'news');

	   $result= '';
	     $archivedate = $this->input->post('archive_id');




		 if(!empty($archivedate) && isset($archivedate)){

			$data=$this->news->get_archive($archivedate);
			  //$data = $this->news->read('*', array( 'newsIsPublished' => '1'));

		 }



	  $arr = array(1, 2, 3, 4);
	   /*******************************/
	    $html_table = '<table class="table table-bordered table-hover table-striped text-center table_contents" id="data-table" ><thead>
			</thead>
			<tbody>';



foreach($data as $news)
{


    $html_table .=  '<tr class="tr_line" ></td><div class="row iav_page_item">
                    <div class="col-md-2 iav_page_item_poster">';

				    if (!empty($news->newsImg)) {
					$html_table.= '<img alt="" title="';
					$html_table.=  $news->newsTitle;
					$html_table.= '" class="img-responsive center-block img-thumbnail" src="';
					$html_table.=  base_url(UPLOADS_IMG_CALLBACK)."/".$news->newsImg;
					$html_table.= '" >';
					}else{

					}
					$html_table.='</div>';

					$html_table.='<div class="col-md-10">';
  					$html_table.='<div class="iav_page_item_title">';
					$html_table.=  character_limiter($news->newsTitle, NEWS_TITLE_MAX_CHARS);
					$html_table.='</div>';
					$html_table.='<div class="datenews">';
					$html_table.='date ac:    ';

					$html_table.=  date('d/m/Y', strtotime($news->newsCreatedOn));
					$html_table.='</div>';
					$html_table.='<div class="iav_page_item_description">';
					$html_table.=character_limiter(trim_str($news->newsDescription), NEWS_DESCRIPTION_MAX_CHARS);
					$html_table.='</div>';

				    $html_table.='<a href="';
					$html_table.=base_url();
					$html_table.='actualites/';
					$html_table.=url_rewrite($news->newsTitle, $news->id);
					$html_table.='"';
					$html_table.='class="btn btn-success btn-sm pull-right iav_page_item_btn_more">';
				     $html_table.='<i class="glyphicon glyphicon-expand"></i>';
					$html_table.='Lire la suite';
                    $html_table.='</a>';
					$html_table .='</td></tr>';



	                  $html_table.='</div>';
			 $html_table.='</div>';
}

$html_table .= '</tbody></table>';


	 /*
	  $tabl= "<table class='table table-bordered table-hover table-striped text-center table_contents" id="data-table' >
			<thead>
			</thead>
			<tbody>
             foreach ($data AS $new) {
			<tr class='tr_line'>
			<td>
                <div class='row iav_page_item'>
                    <div class='col-md-2 iav_page_item_poster'>
                        <?php if (!empty($new->newsImg)) {
                        <img alt="" title='"<?=$new->newsTitle?>"' class="img-responsive center-block img-thumbnail" src='"<?=base_url(UPLOADS_IMG_CALLBACK).'/'.$new->newsImg?>'">
                        else {

                        }

                    <div class='col-md-10'>
                        <div class="iav_page_item_title'>
                            echo character_limiter($new->newsTitle, NEWS_TITLE_MAX_CHARS);
                        </div>
                        <div class='iav_page_item_description'>
                            echo character_limiter(trim_str($new->newsDescription), NEWS_DESCRIPTION_MAX_CHARS);
                        </div>
                        <a href='"<?=base_url('actualites').'/'.url_rewrite($new->newsTitle, $new->id)?>"' class='btn btn-success btn-sm pull-right iav_page_item_btn_more'>
                            <i class='glyphicon glyphicon-expand'></i>  echo "$data[Lirelasuite]";
                        </a>
                    </div>
                </div>
				</td>
			</tr>

             }
			</tbody>
			</table>";
	*/
	   $val=array(
	      'data' => $html_table,
	   );
	   /***********************************/

		echo json_encode($val);




	}




    public function op_attestation()
    {

            //redirect();

        $this->load->library('form_validation');
        $this->form_validation->set_rules('message', "Plus d'informations", 'trim');
        $this->form_validation->set_rules('type', 'Type', 'required|trim');
        $errors = false;
        if ($this->form_validation->run()) {
            $this->load->model('Attestation_model', 'attestation');
            $message = "Votre demande a été envoyée avec succès.";
            $result = $this->attestation->create(array(
                'caller_id' => $this->user_id,
                'type_user' => $this->user_type,
                'attestationType' => $this->input->post('type'),
                'attestationInfo' => $this->input->post('message')));
            if ($result && !empty($this->user_type)) {


                $type_dmd = $this->get_type_dmd($this->input->post('type'));
                $subject_m = "Une demande d'attestation : " . $type_dmd;
                $data_m = $this->get_userinfo($this->user_type, $this->user_id);
                $data_m['type_dmd'] = $type_dmd;
                $data_m['message'] = $this->input->post('message');
                $message_m = $this->load->view('tools/email_view', $data_m, true);
               // $this->send_mail($subject_m, $message_m);


                if ($this->user_type == 'user_student')
                    $url = 'etudiant/index';
                else
                    $url = 'enseignant/index';
                $this->set_public_message($message, 'success');
                echo json_encode(array('status' => '1', 'url' => $url));
            } else
                if ($errors === false)
                    $errors = "Une erreur est survenue lors du traitement, merci de réessayer.";
        } else
            $errors = validation_errors();
        if ($errors !== false)
            echo json_encode(array('status' => '0', 'errors' => $errors));
    }

    function get_userinfo($type, $id)
    {
        $data = array();
        if ($type == 'user_prof') {
            $this->load->model('professor_model', 'prof');
            $prof = $this->prof->read('professorLastName , professorFirstName', array('id' =>
                    $id));
            $prof = $prof[0];
            $data['user_name'] = "$prof->professorLastName $prof->professorFirstName";
            $data['type'] = "Enseignant";
        } else
            if ($type == 'user_student') {
                $this->load->model('student_model', 'stud');
                $etudiant = $this->stud->read('studentLastName , studentFirstName', array('id' =>
                        $id));
                $etudiant = $etudiant[0];
                $data['user_name'] = "$etudiant->studentFirstName $etudiant->studentLastName";
                $data['type'] = "Etudiant";
            }
        return $data;
    }

    function get_type_dmd($type)
    {
        $type_full = "";
        switch ($type) {
            case 'attestation_scolaire':
                $type_full = "Attestation de scolarité";
                break;
            case 'attestation_salaire':
                $type_full = "Attestation de salaire";
                break;
            case 'ordre_mission':
                $type_full = "Ordre de mission";
                break;
            case 'attestation_conge':
                $type_full = "Demande de congé";
                break;
            case 'attestation_travail':
                $type_full = "Attestation de travail";
                break;
            default:
                $type_full = $type;
                break;
        }
        return $type_full;
    }

    function send_mail($subject, $message, $cc = null)
    {
        $this->load->library('email');
        $this->email->mailtype = 'html';
        $this->email->from('si@iav.ac.ma', 'IAV SI');
		//ADMIN_CONTACT_EMAIL
      $list = array('benabbeskhalid@gmail.com', ING_CONTACT_EMAIL);
        $this->email->to($list);
        if ($cc != null)
            $this->email->cc($cc);
        $this->email->subject($subject);
        $this->email->message($message);
        return $this->email->send();
    }

    // updated
    public function get_student_notes($student_id, $year = null)
    {
        if (!($this->user_is_connected(USER_TYPE_STUDENT) || $this->user_is_connected(USER_TYPE_PARENT)))
            redirect();
        $errors = false;
        if ($year) {
            $options = array('year' => $year, 'student_id' => $student_id);
            $data = array();
            $data['notes_arr'] = $this->note->get_notes_by_joining($options);

            $data['is_student'] = $this->user_type === USER_TYPE_STUDENT ? true : false;
            $data['is_parent'] = $this->user_type === USER_TYPE_PARENT ? true : false;
            $code = $this->load->view('list_notes_view', $data, true);
            echo json_encode(array('status' => '1', 'code' => $code));
        } else
            $errors = 'Param id required!';
        if ($errors !== false)
            echo json_encode(array('status' => '0', 'errors' => $errors));
    }

	  public function changerPassword(){
		//var $type=$this->input->post('type');
		//if($type == 'pass_etud'){
			//var $passe=$this->input->post('passe');

            //redirect();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('passe', "Plus d'informations", 'trim');
        $this->form_validation->set_rules('type', 'Type', 'required|trim');

        if ($this->form_validation->run()) {

		   $message = "Votre demande a été envoyée avec succès.";






		   // if($this->student->update($options,$this->user_id)){
			// $this->set_public_message($message, 'success');
		   // }

    if($this->input->post('type') == 'pass_prof'){

		     $optionspf=array(
		   'professorPasstemp' => $this->input->post('passe'),
		   'professorPassword' => SHA1($this->input->post('passe'))
		   );

		      $location =  'enseignant/index';
			  if($this->professor->update($optionspf,$this->user_id)){
				  echo json_encode(array('status' => '1', 'location' => $location));
			  }else{
				   echo json_encode(array('status' => '0', 'erreur' => 'erreur de modification de mot de passe'));
			  }



	}else if($this->input->post('type') == 'pass_etud'){


		    $options=array(
		   'studentPasswordtmp' => $this->input->post('passe'),
		   'studentPassword' => SHA1($this->input->post('passe'))
		   );

		     $location =  'etudiant/index';
			  if($this->student->update($options,$this->user_id)){
				  echo json_encode(array('status' => '1', 'location' => $location));
			  }else{
				   echo json_encode(array('status' => '0', 'erreur' => 'erreur de modification de mot de passe'));
			  }
	}



		}
		//}
	}



}
