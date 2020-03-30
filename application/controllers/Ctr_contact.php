<?php defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/Master.php';
class Ctr_contact extends Master
{
  private $depart_srvs;
  private $CI;
  function __construct() {
    parent::__construct();
    $this->load->model('Iav_chauffeur_model', 'chauffeur');
    $this->load->model('Iav_departement_model');
    $this->load->model('Iav_personel_model');
    $this->load->model('Iav_typepersonnel_model');
    $this->load->model('Iav_personel_type_departement','ptd');
    $this->load->library('session');
     $this->CI = &get_instance();
    $this->depart_srvs = $this->Iav_departement_model->getDepartementService();

  }
 // page index pour les contacts est une page contient les contacs enseignant & Administratifs
  public function index($data = ''){

    $this->display($data);
    $this->set_breadcrumb(array("List tous les contacts" => ''));
    $all_personels=$this->Iav_personel_model->getAllPersonel(NULL);
    $this->template->set_partial('container', 'contacts/contact_view', array('data' => $data,'all_personels'=>$all_personels));
     $this->template->title('Contact IAV','IAV HASSAN II')->build('body');

  }
 // action du chauffeurs
  public function chauffeur($data = '',$id = NULL)
  {
     $this->display($data);
          switch($data){
              case 'add':
              case 'ajouter':
                    // faire passer le parameter depart_serrs (les departements)
                    // pour remplir la select departements
                    $this->set_breadcrumb(array("Ajouter chauffeur" => ''));
                    $depart_srvs=$this->Iav_departement_model->getDepartementService();
                    $this->template->set_partial('container', 'contacts/add_chauffeur_view', array('data' => $data,'depart_srvs' => $depart_srvs,'prefix' => "chauffeur"));
              break;
              case 'edit':

                   $depart_srvs=$this->Iav_departement_model->getDepartementService();
                   //get chauffeur par id , et passer ces informations a la page edit
                   $this->set_breadcrumb(array("Modifier chauffeur" => ''));
                   $chauff = $this->chauffeur->getById($id);
                   $this->template->set_partial('container', 'contacts/edit_chauffeur_view', array('data' => $data,'depart_srvs' => $depart_srvs,'prefix' => "chauffeur",
                   'chauffeur' => $chauff));
              break;
              default:
               // la liste des chauffeurs
                $queryDetail = $this->chauffeur->listeChauffeurs();
                $this->set_breadcrumb(array("List des Chauffeurs" => ''));
                $this->template->set_partial('container', 'contacts/list_chauffeur_view', array('data' => $data,'queryDetail' => $queryDetail));
              }
            $this->template->title('contact','chauffeurs')->build('body');
    }
  // actions enseignant
   public function enseignant($data = '',$id= NULL)
  {
    // charger model Iav_personel_model

   //get tout les enseignant de la table personels une table qui contient tout les types personel
   $ensgn=$this->Iav_personel_model->getPersonel("Enseignant");
   $this->display($data);
  switch($data){
    case 'add':
    case    'ajouter':
    $this->set_breadcrumb(array("Ajouter Enseignant" => ''));
    $this->template->set_partial('container', 'contacts/add_personel_view', array('data' => $data,'prefix'=>"enseignant",'depart_srvs'=>$this->depart_srvs));       break;
    break;
    case 'edit':
      //get les departements et les services et les filieres de la table iav_departement
      $depart_srvs=$this->Iav_departement_model->getDepartementService();
      //get personel par son id
      $this->set_breadcrumb(array("Modifier Enseignant" => ''));
      $perso=$this->Iav_personel_model->getById($id);
      $this->template->set_partial('container', 'contacts/edit_personnel_view', array('data' => $data,'depart_srvs' => $depart_srvs,'prefix' => "enseignant",
      'personnel' => $perso));
     default:
     $this->set_breadcrumb(array("List des Enseignant" => ''));
      $this->template->set_partial('container', 'contacts/list_enseignant_view', array('data' => $data,'ensgn'=>$ensgn));
    }
    $this->template->title('contact','Enseignants')->build('body');
  }

  //action etudiant
  public function etudiant($data = '',$id = null)
  {
     //charger le model Iav_personel_model

     //get la liste des etudiant qui existent sur la table personel
     $etud=$this->ptd->GetAllEtudient();
     $filiere = $this->Iav_departement_model->GetDepartementParent();
     $this->display($data);
            switch($data){
       case 'add':
       case    'ajouter':
       $this->set_breadcrumb(array("Ajouter niveau" => ''));
       $this->template->set_partial('container', 'contacts/add_etudient_view',
       array('data' => $data,'prefix' => "etudiant",'filiere' =>$filiere));
       break;
       case 'edit':
       case 'modifier':
      //get etudiant (niveau ) par son id
       $etud   = $this->ptd->getById($id);
       //get tout les niveau
       $this->set_breadcrumb(array("Modifier niveau" => ''));
       $niveau = $this->Iav_personel_model->GetAllNiveau();
       $this->template->set_partial('container', 'contacts/edit_etudiant_view',
                        array('data' => $data,'filiere' => $filiere,'etud'=>$etud,'prefix'=>"etudiant",'niveau'=>$niveau));
       break;
       default:
       //get les departements parent autrement get  les filieres
       $filiere = $this->Iav_departement_model->GetDepartementParent();
       $this->set_breadcrumb(array("List des niveaux" => ''));
       $this->template->set_partial('container', 'contacts/list_etudiant_view',
       array('data' => $data,'etud'=>$etud,'filiere'=>$filiere));
      }
       $this->template->title('contact','Etudiants')->build('body');
  }
  //action personel
  public function personnel($data = '',$id = NULL,$idTyp = NULL)
  {   //get les Administratif autrement les personels de la table iav_personel
      $personels	= $this->Iav_personel_model->getPersonel("Administratif");
      $this->display($data);
      switch($data){
      case 'add':
      case 'ajouter':
            $this->set_breadcrumb(array("Ajouter administratif" => ''));
            $this->template->set_partial('container', 'contacts/add_personel_view', array('data' => $data,'prefix'=>"personnel",'depart_srvs'=>$this->depart_srvs));
      break;
      case 'edit':
      case 'modifier':
        //get les departement , les services et les filieres
        $depart_srvs=$this->Iav_departement_model->getDepartementService();
        //get personel par son id
        $this->set_breadcrumb(array("Modifier administratif" => ''));
        $perso=$this->Iav_personel_model->getById($id);
        $this->template->set_partial('container', 'contacts/edit_personnel_view', array('data' => $data,'depart_srvs' => $depart_srvs,'prefix' => "personnel",
        'personnel' => $perso,'typeP' => $idTyp));
      break;
      default:
            $this->set_breadcrumb(array("List des administratif" => ''));
            $this->template->set_partial('container', 'contacts/list_personnel_view', array('data' => $data,'personels'=>$personels));
    }
    $this->template->title('contact','Administratifs')->build('body');
  }
 // ajax functions
      // la foction ajouter_modif pour les chauffeurs cette fonction traite add/edit au meme temps
      // ça depent de id if isset ou not
  public function ajouter_modif()
  {    //charger lib de validation
      $this->load->library('form_validation');
      $this->form_validation->set_rules('nom', 'Nom du chauffeur est obligatoire', 'required|trim',
                              array('required' => 'Le champs nom du chauffeur est obligatoire'));
      $this->form_validation->set_rules('prenom', 'Prenom du chauffeur est obligatoire', 'required|trim',
                              array('required' => 'Le champs prenom du chauffeur est obligatoire'));
      $this->form_validation->set_rules('grade', 'Grade du chauffeur est obligatoire', 'required|trim',
                              array('required' => 'Le champs Grade du chauffeur est obligatoire'));
      $this->form_validation->set_rules('code', 'code du chauffeur est obligatoire', 'required|trim',
                              array('required' => 'Le champs Matricule du chauffeur est obligatoire'));
      $this->form_validation->set_rules('dep', 'Département est obligatoire', 'required|trim',
                              array('required' => 'Le champs Département  est obligatoire'));
      $this->form_validation->set_rules('echel', 'echel est obligatoire', 'required|trim',
                              array('required' => 'Le champs Echel est obligatoire'));

      if ($this->form_validation->run()) {
        $id       =$this->input->post('id_chauffeur');
        $echel    = $this->input->post('echel');
        $nom      = $this->input->post('nom');
        $prenom   = $this->input->post('prenom');
        $grade    = $this->input->post('grade');
        $date_r   = $this->input->post('date_r');
        $tel      = $this->input->post('tel');
        $code     = $this->input->post('code');
        $dep      = $this->input->post('dep');

        $options = array(
          'nom_chauffeur'      => $nom,
          'prenom_chauffeur'   => $prenom,
          'grade_chauffeur'    => $grade,
          'date_retraite'      => $date_r,
          'tel'                => $tel,
          'code_chauffeur'     => $code,
          'id_departement'     => $dep,
          'Echel'              => $echel,
          'id_chauffeur'       => $id
        );
        $condition_matrcl     = array('code_chauffeur' => $code );
        $rlst_exist_matricule = $this->chauffeur->read("*",$condition_matrcl);
        $count_matrcl         = COUNT($rlst_exist_matricule);
        if(isset($id)){
          $options['uby_chauffeur'] = $this->CI->session->user['id_user'];
          $result = $this->chauffeur->modifier($options);
          $message = "Vos informations ont été modifiées avec succès.";
          echo json_encode(array( 'status' => '1',
                                  'location' => 'url',
                                  'message' => $message));
        }else if( $count_matrcl == 0 ){
          $options['cby_chauffeur'] = $this->CI->session->user['id_user'];
          $this->chauffeur->create($options);
          $message = "Vos informations ont été ajoutées avec succès.";
          echo json_encode(array( 'status' => '1',
                                  'location' => 'url',
                                  'message' => $message));
        }else if($count_matrcl != 0 ) {
          $message = "Le champs Matricule doit étre unique , essayez un autre Matricule.";
          echo json_encode(array( 'status' => '0',
                                  'location' => 'url',
                                  'message' => $message));
        }
      } else {
        $errors = validation_errors();
        echo json_encode(array('status' => '0',
                               'location' => 'url',
                               'message' => $errors));
      }
   }

     // la foction ajouter_modif pour les personel cette fonction traite add/edit au meme temps
     // ça depent de id if isset ou not
    public function ajouter_modif_personel()
   {

     $this->load->library('form_validation');
     if($this->input->post('from') != 'edit'){
       $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[3]|max_length[15]',
                                     array('required'      => 'Le champs mot de passe  est obligatoire',
                                           'min_length'    => 'Le champs mot de passe doit contenir 3 characters au minimum' ,
                                           'max_length'    =>  'Le champs mot de passe doit contenir au maximum 15 characters'));
       $this->form_validation->set_rules('rpassword', 'Password Confirmation', 'required|matches[password]',
                                    array('required' => 'Le champs confirmation de mot de passe du chauffeur est obligatoire',
                                          'matches'=>'Les mots passes ne sont pas identiques'));
     }
     $this->form_validation->set_rules('nom', 'Nom est obligatoire', 'required|trim',
                                  array('required' => 'Le champs nom  est obligatoire'));
     $this->form_validation->set_rules('prenom', 'Prenom  est obligatoire', 'required|trim',
                                  array('required' => 'Le champs prenom  est obligatoire'));
     $this->form_validation->set_rules('fonction', 'fonction  est obligatoire', 'required|trim',
                                  array('required' => 'Le champs fonction  est obligatoire'));
    $this->form_validation->set_rules('code', 'Code  est obligatoire', 'required|trim',
                                 array('required' => 'Le champs Code  est obligatoire'));
     $this->form_validation->set_rules('email', 'Email  est obligatoire', 'trim|valid_email',
                                   array('valid_email' => 'La forme d email est incorrect'));


      if ($this->form_validation->run()){
        $password             = $this->input->post('password');
        $id_cadre            = $this->input->post('cadre');
        if(ctype_alnum($password)){
          echo json_encode(array( 'status' => '0',
                                  'location' => 'url',
                                  'message' => "Le mot de passe n'est pas fort"));

        }elseif($id_cadre == '0'){
          echo json_encode(array( 'status' => '0',
                                  'location' => 'url',
                                  'message' => "veuillez choisir un cadre"));

        }else{

          $nom           = $this->input->post('nom');
          $prenom        = $this->input->post('prenom');
          $tel           = $this->input->post('tel');
          $email         = $this->input->post('email');
          $dep           = $this->input->post('dep');
          $password      = $this->input->post('password');
          $rpassword     = $this->input->post('rpassword');
          $typepersonel  = $this->input->post('typepersonel');
          $grade         = $this->input->post('grade');
          $fonction      = $this->input->post('fonction');
          $date_r        = $this->input->post('date_r');
          $code          = $this->input->post('code');
          $echel         = $this->input->post('echel');
          $id_cadre         = $this->input->post('cadre');




          $options = array(
            'nom_personel'             => $nom,
            'prenom_personel'          => $prenom,
            'tel_personel'             => $tel,
            'email_personel'           => $email,
            'id_departement'           =>$dep,
            'niveau_grade_personel'    =>$grade,
            'fonction_personel'        =>$fonction,
            'date_retraite_personel'   =>$date_r,
            'code_personel'            =>$code,
             'Echel'                   =>$echel,
             'typepersonel'            =>$typepersonel,
              'id_cadre'               =>$id_cadre
          );

          $optionsAD = array(
            'nom_personel'             => $nom,
            'prenom_personel'          => $prenom,
            'tel_personel'             => $tel,
            'email_personel'           => $email,
            'niveau_grade_personel'    =>$grade,
            'fonction_personel'        =>$fonction,
            'date_retraite_personel'   =>$date_r,
            'code_personel'            =>$code,
             'Echel'                   =>$echel,

          );



          if($password != ''){
            $options['password'] = md5($password);
          }
          $condition_matrcl     = array('code_personel' => $code );
          $rlst_exist_matricule = $this->Iav_personel_model->read("*",$condition_matrcl);
          $count_matrcl         = COUNT($rlst_exist_matricule);

          if($this->input->post('id_personel') != ''){
            $id            = $this->input->post('id_personel');
            $options['id_personel'] = $id;
            $message = "Vos informations ont été modifiées avec succès.";
            $options['uby_personel'] = $this->CI->session->user['id_user'];
            $this->Iav_personel_model->modifier($options);
             echo json_encode(array( 'status' => '1',
                                     'location' => 'url',
                                     'message' => $message));

          }else if($count_matrcl == 0){
            //$this->Iav_personel_model->ajouter_personel($options);

            $idDep         = $options['id_departement'];
            $type_personel = $options['typepersonel'];
            unset($options['id_departement']);
            unset($options['typepersonel']);
            $options['cby_personel'] = $this->CI->session->user['id_user'];
            $idPer = $this->Iav_personel_model->create($optionsAD,'cdate_personel');

            if($type_personel=="personnel"){
              $type_personel="Administratif";
            }
            $id_typepersonel = $this->iav_typepersonnel_model->get_id_pr_type($type_personel);
            $options_per_tp_dp  = array(
               'id_personel'    => $idPer,
               'id_typepersonel'=> $id_typepersonel[0]->id_typepersonel,
               'id_departement' => $idDep
            );
            $result  = $this->ptd->create($options_per_tp_dp,'cdate_personel_type_departement');
            $message = "Vos informations ont été ajoutées avec succès.";
            echo json_encode(array( 'status' => '1',
                                    'location' => 'url',
                                    'message' => $message));
          }else if($count_matrcl != 0) {
            $message = "Le champs Matricule doit étre unique , essayez un autre Matricule.";
            echo json_encode(array( 'status' => '0',
                                    'location' => 'url',
                                    'message' => $message));
          }
        }
     } else {
       $errors = validation_errors();
       echo json_encode(array('status' => '0',
                              'location' => 'url',
                              'message' => $errors));
     }
   }
   // fonction ajax pour supprimer un chauffeur et rendre un result json
   public function delete_aj_chauff()
   {
     $id_chaufr = $this->input->post('id');
     $etat_delete = $this->chauffeur->delete($id_chaufr);
     if($etat_delete){
     $message = "Vos informations ont été supprimées avec succès.";
     echo json_encode(array( 'status' => '1',
                             'location' => 'url',
                             'message' => $message));
     }else {
       $message = "Erreur de Traitement.";
       echo json_encode(array( 'status' => '0',
                               'location' => 'url',
                               'message' => $message));
     }
   }
   // fonction delete_aj_personnel pour supprimer un chauffeur et rendre un result json
   public function delete_aj_personnel()
   {
     $id = $this->input->post('id');
     $etat_delete = $this->Iav_personel_model->update(array('deleted_personel' => 'O'),array('id_personel'=>$id),'ddate_personel');
     if($etat_delete){
     $message = "Vos informations ont été supprimées avec succès.";
     echo json_encode(array( 'status' => '1',
                             'location' => 'url',
                             'message' => $message));
     }else {
       $message = "Erreur de Traitement.";
       echo json_encode(array( 'status' => '0',
                               'location' => 'url',
                               'message' => $message));
     }
   }
   // delete un niveau ou bien un etudiant
   public function delete_aj_etudiant()
   {
     $id            = $this->input->post('id');
     $idpers        = $this->input->post('idPers');
     $nb_row        = $this->ptd->Count_IdPersonnel($idpers);

     $etat_delete   = $this->ptd->delete($id);
     if($nb_row == 1 && $etat_delete==true ){
     $relt          =  $this->Iav_personel_model->delete($idpers);
     }
     if($etat_delete){
     $message = "Vos informations ont été supprimées avec succès.";
     echo json_encode(array( 'status' => '1',
                             'location' => 'url',
                             'message' => $message));
     }else {
       $message = "Erreur de Traitement.";
       echo json_encode(array( 'status' => '0',
                               'location' => 'url',
                               'message' => $message));
     }
   }
 // fonction ajax a un but d'ajouter des etudiants apres un passage de la validation
   public function ajouter_etudient()
   {
     $this->load->library('form_validation');
     $this->form_validation->set_rules('niveau', 'Niveau du chauffeur est obligatoire', 'required|trim',
                                  array('required' => 'Le champs Niveau est obligatoire'));
     $this->form_validation->set_rules('depart', 'Féliere  est obligatoire', 'required|trim',
                                  array('required' => 'Le champs prenom du chauffeur est obligatoire'));
      if ($this->form_validation->run()){
       $niveau            = $this->input->post('niveau');
       $filiere           = $this->input->post('depart');
       $typepersonel      = $this->input->post('typepersonel');
       $code_niveau       = $niveau.rand()."_ANNE";

       $options  = array(
         'nom_personel'            => $niveau,
          'filiere'                => $filiere,
          'typepersonel'           => $typepersonel,
          'code_personel'          => $code_niveau,
       );

       $result = $this->Iav_personel_model->ajouter_etudient($options);
       if($result){
         $message = "Vos informations ont été ajoutées avec succès.";
       }else {
         $message = "Le Niveau existe , Essaiyez de lui affecter une Filiére .";
       }
       echo json_encode(array( 'status' => '1',
                               'location' => 'url',
                               'message' => $message  ));

     }else {
       $errors = validation_errors(); ;
       echo json_encode(array( 'status' => '0',
                               'location' => 'url',
                               'message' => $errors));
     }
   }
   //une fonction qui modifier les parameters de l'etudiant qui retourne un message json
   public function modifier_etudiant($value='')
   {
     $niveau            = $this->input->post('niveau');
     $filiere           = $this->input->post('depart');
     $id                = $this->input->post('id');

     $options = array(
        'id_personel'     => $niveau,
        'id_typepersonel' =>1,
        'id_departement'  =>$filiere,
        'id'              =>$id
     );
      $this->ptd->modifier_etudiant_flr($options);
      $message = "Vos informations ont été modifiées avec succès.";
      echo json_encode(array( 'status' => '1',
                              'location' => 'url',
                              'message' => $message));
   }
// affecter_pers_filiere est une fonction responsable de l'affectation d'un niveau a une filiere
   public function affecter_pers_filiere()
   {
     $this->load->library('form_validation');
     $this->form_validation->set_rules('id_personel', 'Niveau  est obligatoire', 'required|trim',
                                  array('required' => 'Le champs Niveau est obligatoire'));
     $this->form_validation->set_rules('id_departement', 'Féliere  est obligatoire', 'required|trim',
                                  array('required' => 'Le champs Féliere est obligatoire'));
     if ($this->form_validation->run()){
       $id_personel       = $this->input->post('id_personel');
       $id_dept           = $this->input->post('id_departement');
       $options           = array(
         'id_personel'    => $id_personel,
         'id_departement' => $id_dept,
         'id_typepersonel'=>1
       );
       $result = $this->ptd->create($options);
       $message = "L'affectation du Niveau a éte faite avec success.";
       echo json_encode(array( 'status' => '1',
                                'location' => 'url',
                                'message' => $message));
       }else{
         $errors = validation_errors(); ;
         echo json_encode(array( 'status' => '0',
                                 'location' => 'url',
                                 'message' => $errors));
       }
     }



}
