<?php defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/Master.php';
class Ctr_contact extends Master
{
  private $depart_srvs;
  function __construct() {
    parent::__construct();
    $this->load->model('Iav_chauffeur_model', 'chauffeur');
    $this->load->model('Iav_departement_model');
    $this->load->model('Iav_personel_model');
    $this->load->model('Iav_personel_type_departement','ptd');
    //la liste des departements / services / filieres
    $this->depart_srvs = $this->Iav_departement_model->getDepartementService();

  }
 // page index pour les contacts est une page contient les contacs enseignant & Administratifs
  public function index($data = ''){
    $this->load->model('Iav_personel_model');
    $this->display($data);
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
                    $depart_srvs=$this->Iav_departement_model->getDepartementService();
                    $this->template->set_partial('container', 'contacts/add_chauffeur_view', array('data' => $data,'depart_srvs' => $depart_srvs,'prefix' => "chauffeur"));
              break;
              case 'edit':

                   $depart_srvs=$this->Iav_departement_model->getDepartementService();
                   //get chauffeur par id , et passer ces informations a la page edit
                   $chauff = $this->chauffeur->getById($id);
                   $this->template->set_partial('container', 'contacts/edit_chauffeur_view', array('data' => $data,'depart_srvs' => $depart_srvs,'prefix' => "chauffeur",
                   'chauffeur' => $chauff));
              break;
              default:
               // la liste des chauffeurs
                $queryDetail = $this->chauffeur->listeChauffeurs();
                $this->template->set_partial('container', 'contacts/list_chauffeur_view', array('data' => $data,'queryDetail' => $queryDetail));
              }
            $this->template->title('contact','chauffeurs')->build('body');
    }
  // actions enseignant
   public function enseignant($data = '',$id= NULL)
  {
    // charger model Iav_personel_model
   $this->load->model('Iav_personel_model');
   //get tout les enseignant de la table personels une table qui contient tout les types personel
   $ensgn=$this->Iav_personel_model->getPersonel("Enseignant");
   $this->display($data);
  switch($data){
    case 'add':
    case    'ajouter':
    $this->template->set_partial('container', 'contacts/add_personel_view', array('data' => $data,'prefix'=>"enseignant",'depart_srvs'=>$this->depart_srvs));       break;
    break;
    case 'edit':
      //get les departements et les services et les filieres de la table iav_departement
      $depart_srvs=$this->Iav_departement_model->getDepartementService();
      //get personel par son id
      $perso=$this->Iav_personel_model->getById($id);
      $this->template->set_partial('container', 'contacts/edit_personnel_view', array('data' => $data,'depart_srvs' => $depart_srvs,'prefix' => "enseignant",
      'personnel' => $perso));
     default:
      $this->template->set_partial('container', 'contacts/list_enseignant_view', array('data' => $data,'ensgn'=>$ensgn));
    }
    $this->template->title('contact','Enseignants')->build('body');
  }

  //action etudiant
  public function etudiant($data = '',$id = null)
  {
     //charger le model Iav_personel_model
     $this->load->model('Iav_personel_model');
     //get la liste des etudiant qui existent sur la table personel
     $etud=$this->ptd->GetAllEtudient();
     $filiere = $this->Iav_departement_model->GetDepartementParent();
     $this->display($data);
            switch($data){
       case 'add':
       case    'ajouter':
       $this->template->set_partial('container', 'contacts/add_etudient_view',
       array('data' => $data,'prefix' => "etudiant",'filiere' =>$filiere));
       break;
       case 'edit':
       case 'modifier':
      //get etudiant (niveau ) par son id
       $etud   = $this->ptd->getById($id);
       //get tout les niveau
       $niveau = $this->Iav_personel_model->GetAllNiveau();
       $this->template->set_partial('container', 'contacts/edit_etudiant_view',
                        array('data' => $data,'filiere' => $filiere,'etud'=>$etud,'prefix'=>"etudiant",'niveau'=>$niveau));
       break;
       default:
       //get les departements parent autrement get  les filieres
       $filiere = $this->Iav_departement_model->GetDepartementParent();
       $this->template->set_partial('container', 'contacts/list_etudiant_view',
       array('data' => $data,'etud'=>$etud,'filiere'=>$filiere));
      }
       $this->template->title('contact','Etudiants')->build('body');
  }
  //action personel
  public function personnel($data = '',$id = NULL)
  {   //get les Administratif autrement les personels de la table iav_personel
      $personels	= $this->Iav_personel_model->getPersonel("Administratif");
      $this->display($data);
      switch($data){
      case 'add':
      case 'ajouter':
            $this->template->set_partial('container', 'contacts/add_personel_view', array('data' => $data,'prefix'=>"personnel",'depart_srvs'=>$this->depart_srvs));
      break;
      case 'edit':
      case 'modifier':
        //get les departement , les services et les filieres
        $depart_srvs=$this->Iav_departement_model->getDepartementService();
        //get personel par son id
        $perso=$this->Iav_personel_model->getById($id);
        $this->template->set_partial('container', 'contacts/edit_personnel_view', array('data' => $data,'depart_srvs' => $depart_srvs,'prefix' => "personnel",
        'personnel' => $perso));
      break;
      default:
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
      $this->form_validation->set_rules('tel', 'Téléphone du chauffeur est obligatoire', 'required|trim',
                              array('required' => 'Le champs Téléphone du chauffeur est obligatoire'));
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
          'grade_chauffeur'    =>$grade,
          'date_retraite'      =>$date_r,
          'tel'                =>$tel,
          'code_chauffeur'     =>$code,
          'id_departement'     => $dep,
          'Echel'              => $echel,
          'id_chauffeur'       => $id
        );

        if(isset($id)){
          $result = $this->chauffeur->modifier($options);
          $message = "Vos informations ont été modifiées avec succès.";
          echo json_encode(array( 'status' => '1',
                                  'location' => 'url',
                                  'message' => $message));
        } else {
          $this->chauffeur->create($options);
          $message = "Vos informations ont été ajoutées avec succès.";
          echo json_encode(array( 'status' => '1',
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
     $this->form_validation->set_rules('nom', 'Nom est obligatoire', 'required|trim',
                                  array('required' => 'Le champs nom  est obligatoire'));
     $this->form_validation->set_rules('prenom', 'Prenom  est obligatoire', 'required|trim',
                                  array('required' => 'Le champs prenom  est obligatoire'));
     $this->form_validation->set_rules('tel', 'Téléphone  est obligatoire', 'required|trim',
                                  array('required' => 'Le champs Téléphone  est obligatoire'));
     $this->form_validation->set_rules('email', 'Email  est obligatoire', 'required|trim|valid_email',
                                   array('required' => 'Le champs email  est obligatoire',
                                         'valid_email'=>'L\'Email  n\'est pas valide'));
    $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[3]|max_length[15]',
                                  array('required'      => 'Le champs mot de passe  est obligatoire',
                                        'min_length'    => 'Le champs mot de passe doit contenir 3 characters au minimum' ,
                                        'max_length'    =>  'Le champs mot de passe doit contenir au maximum 15 characters'));
    $this->form_validation->set_rules('rpassword', 'Password Confirmation', 'required|matches[password]',
                                 array('required' => 'Le champs confirmation de mot de passe du chauffeur est obligatoire',
                           'matches'=>'Les mots passes ne sont pas identiques'));
      $password       = $this->input->post('password');
      if ($this->form_validation->run()){
        if(ctype_alnum($password)){
          echo json_encode(array( 'status' => '0',
                                  'location' => 'url',
                                  'message' => "Le mot de passe n'est pas fort"));

        }else{
          $id            = $this->input->post('id_personel');
          $nom           = $this->input->post('nom');
          $prenom        = $this->input->post('prenom');
          $tel           = $this->input->post('tel');
          $email         = $this->input->post('email');
          $dep           = $this->input->post('dep');
          $password       = $this->input->post('password');
          $rpassword     = $this->input->post('rpassword');
          $typepersonel  = $this->input->post('typepersonel');
          $grade         = $this->input->post('grade');
          $fonction      = $this->input->post('fonction');
          $date_r        = $this->input->post('date_r');
          $code          = $this->input->post('code');
          $echel         = $this->input->post('echel');
          $options = array(
            'nom_personel'             => $nom,
            'prenom_personel'          => $prenom,
            'tel_personel'             => $tel,
            'email_personel'           => $email,
            'id_departement'           =>$dep,
            'password'                 =>$password,
            'niveau_grade_personel'    =>$grade,
            'fonction_personel'        =>$fonction,
            'date_retraite_personel'   =>$date_r,
            'code_personel'            =>$code,
             'Echel'                   =>$echel,
             'id_personel'             =>$id,
             'typepersonel'            =>$typepersonel
          );
          if(($id == $this->input->post('id_personel')) ){
            $message = "Vos informations ont été modifiées avec succès.";
            $this->Iav_personel_model->modifier($options);
             echo json_encode(array( 'status' => '1',
                                     'location' => 'url',
                                     'message' => $message));
          }else{
            $this->Iav_personel_model->create($options);
            $message = "Vos informations ont été ajoutées avec succès.";
            echo json_encode(array( 'status' => '1',
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
     $etat_delete = $this->Iav_personel_model->delete($id);
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
