<?php defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/Master.php';

 class Administration extends Master
{

public function __construct()
    {
        parent::__construct();

        $this->template->prepend_metadata('<link rel="stylesheet" type="text/css" href="' . base_url('assets/css') . '/dataTables.bootstrap.css">');
        $this->load->model('Role_model', 'role');
        $this->load->model('Site_model', 'site');
        $this->load->model('Salle_model','salle');
        $this->load->model('User_model','user');
        $this->load->model('Reservation_model','reservation');

    }




    public function index($lang = '')
    {


             /** verifier l'ouverture de session */
        $this->display('');
        $this->template->set_partial('container', 'administration/dashboard_view',array());
        $this->template->build('body');



    }


  /*  reservation*/

  public function reservation($opt='',$id=NULL){
switch ($opt) {
      case 'all':
      case 'ts':
$this->display('');
$this->template->title('Tous les réservations', 'console d\'administration' ,$this->template_page_title);
$this->set_breadcrumb(array("Console d'administration" => 'administration/reservation', 'Gestion des réservations' => ''));
 $reservation_arr = $this->reservation->read('*', '', 'idreservation desc');
 $op_modal = $this->load->view('modals/admin/op_modal', '', true);
 $this->template->set_partial('container','administration/reservation/ts_reservation_view',array('reservation_arr'=>$reservation_arr,'op_modal'=> $op_modal));
 $this->template->build('body');

        break;
    case 'ms':

       break;
  case 'create':
  case 'ajouter':
     $this->display('');
     $op_modal = $this->load->view('modals/admin/op_modal', '', true);
     $this->template->set_partial('container','administration/reservation/create_reservation_view',array(
    'op_modal'=> $op_modal));
     $this->template->build('body');


       break;


    default:
        # code...
     $this->display('');
     $this->template->title('Tous les réservations', 'console d\'administration' ,$this->template_page_title);
     $this->set_breadcrumb(array("Console d'administration" => 'administration/reservation', 'Gestion des réservations' => ''));
     $reservation_arr = $this->reservation->read('*', '', 'idreservation desc');
     $op_modal = $this->load->view('modals/admin/op_modal', '', true);
     $this->template->set_partial('container','administration/reservation/ts_reservation_view',array('reservation_arr'=>$reservation_arr,'op_modal'=> $op_modal));
     $this->template->build('body');
}
  }

public function calender($opt=''){

switch ($opt) {
  case 'da':
    $this->load->view('calender/datafeed.php');
    break;

  default:
    # code...
    break;
   }
}

    /*  reservation*/

/*** gestion des groupes ***/

public function groupe($opt=''){

switch ($opt) {
    case 'add':
    case 'create':
    case 'ajouter':

        break;
    case 'up':
    case 'update':
    case 'modifier':

       break;

    default:
     $this->display('');
     $this->template->title('Gestion des groupes', 'console d\'administration' ,$this->template_page_title);
     $this->set_breadcrumb(array("Console d'administration" => 'administration/groupe', 'Gestion des groupes' => ''));
     $group_arr = $this->role->read('*', '', 'idrole desc');
     $op_modal = $this->load->view('modals/admin/op_modal', '', true);
     $this->template->set_partial('container','administration/groupe/groupe_view',array('groupe_arr'=>$group_arr,'op_modal'=> $op_modal));
     $this->template->build('body');

}

}
/*** gestion des groupes ***/

/*** gestion des utilisateurs ***/

public function utilisateur($opt='',$id=NULL){
  $this->display('');
    switch ($opt) {
    case 'add':
    case 'create':
    case 'ajouter':
        $this->template->title('Ajouter un utilisateur', 'Gestion des salles', 'Console d\'administration', $this->template_page_title);
       $this->set_breadcrumb(array("Console d'administration" => 'administration/index', 'Gestion des utilisateurs' => 'administration/utilisateur', 'Ajouter un nouveau utilisateur' => ''));
       $this->template->set_partial('container', 'administration/utilisateur/add_update_user_view', array('op_title' => 'Ajouter un utilisateur:', 'op_btn_value' => 'Ajouter', 'user_exist'=>'non'));
       $this->template->build('body');
        break;

    case 'up':
    case 'update':
    case 'modifier':

   $this->template->title('Modifier salle', 'Gestion des utilisateurs', 'Console d\'administration', $this->template_page_title);
    $this->set_breadcrumb(array("Console d'administration" => 'administration/index', 'Gestion des utilisateurs' => 'administration/utilisateur', 'Modifier un utilisateur' => ''));
   if (($id = intval($id)) && !empty($id) && ($users = $this->user->read('*', array('iduser' => $id)))) {
        $hidden=array('user_id'=>$users[0]->iduser,'op'=>'update');


   $this->template->set_partial('container', 'administration/utilisateur/add_update_user_view', array('op_title' => 'Modifier un utilisateur:', 'op_btn_value' => 'Modifier','user_info'=>(array)$users[0],'hidden'=>$hidden));

   $this->template->build('body');

}

       break;

    default:
     $this->template->title('Gestion des sites', 'console d\'administration' ,$this->template_page_title);
     $this->set_breadcrumb(array("Console d'administration" => 'administration/index', 'Gestion des utilisateurs' => ''));
     $user_arr = $this->user->read('*', '', 'iduser desc');
     $op_modal = $this->load->view('modals/admin/op_modal', '', true);
     $this->template->set_partial('container','administration/utilisateur/utilisateur_view',array('user_arr'=>$user_arr,'op_modal'=> $op_modal));
     $this->template->build('body');
}

}

/*** gestion des utilisateurs ***/


/*** gestion des salles ***/

public function salle($opt='',$id=NULL){

   $this->display('');
    switch ($opt) {
    case 'add':
    case 'create':
    case 'ajouter':
      $this->template->title('Ajouter un site', 'Gestion des salles', 'Console d\'administration', $this->template_page_title);
      $this->set_breadcrumb(array("Console d'administration" => 'administration/index', 'Gestion des salles' => 'administration/salle', 'Ajouter une nouvelle salle' => ''));
      $this->template->set_partial('container', 'administration/salle/add_update_salle_view', array('op_title' => 'Ajouter un site:', 'op_btn_value' => 'Ajouter', 'salle_exist'=>'non'));
      $this->template->build('body');
    case 'up':
    case 'update':
    case 'modifier':

    $this->template->title('Modifier salle', 'Gestion des salles', 'Console d\'administration', $this->template_page_title);
    $this->set_breadcrumb(array("Console d'administration" => 'administration/index', 'Gestion des salles' => 'administration/salle', 'Modifier une salle' => ''));
   if (($id = intval($id)) && !empty($id) && ($salles = $this->salle->read('*', array('idsalle' => $id)))) {
        $hidden=array('salle_id'=>$salles[0]->idsalle,'op'=>'update');


   $this->template->set_partial('container', 'administration/salle/add_update_salle_view', array('op_title' => 'Modifier un site:', 'op_btn_value' => 'Modifier','salle_info'=>(array)$salles[0],'hidden'=>$hidden));

   $this->template->build('body');
}
   break;

   default:
     $this->template->title('Gestion des sites', 'console d\'administration' ,$this->template_page_title);
     $this->set_breadcrumb(array("Console d'administration" => 'administration/index', 'Gestion des salles' => ''));
     $salle_arr = $this->salle->read('*', '', 'idsalle desc');
     $op_modal = $this->load->view('modals/admin/op_modal', '', true);
     $this->template->set_partial('container','administration/salle/salle_view',array('salle_arr'=>$salle_arr,'op_modal'=> $op_modal));
     $this->template->build('body');


  }

 }

/*** gestion des salles ***/

/*** gestion des sites ***/

public function site($opt='',$id=NULL){

   $this->display('');
    switch ($opt) {
    case 'add':
    case 'create':
    case 'ajouter':
      $this->template->title('Ajouter un site', 'Gestion des sites', 'Console d\'administration', $this->template_page_title);
      $this->set_breadcrumb(array("Console d'administration" => 'administration/index', 'Gestion des sites' => 'administration/site', 'Ajouter un nouveau site' => ''));
      $this->template->set_partial('container', 'administration/site/add_update_site_view', array('op_title' => 'Ajouter un site:', 'op_btn_value' => 'Ajouter', 'site_exist'=>'oui'));
      $this->template->build('body');
        break;
    case 'up':
    case 'update':
    case 'modifier':

     $this->template->title('Modifier site', 'Gestion des sites', 'Console d\'administration', $this->template_page_title);
     $this->set_breadcrumb(array("Console d'administration" => 'administration/index', 'Gestion des site' => 'administration/site', 'Modifier un site' => ''));

      if (($id = intval($id)) && !empty($id) && ($sites = $this->site->read('*', array('idsite' => $id)))) {
        $hidden=array('sites_id'=>$sites[0]->idsite,'op'=>'update');

      $this->template->set_partial('container', 'administration/site/add_update_site_view', array('op_title' => 'Modifier un site:', 'op_btn_value' => 'Modifier','site_info'=>(array)$sites[0],'hidden'=>$hidden));

        $this->template->build('body');
}



/*
      if (($id = intval($id)) && !empty($id) && ($sites = $this->site->read('*', array('idsite' => $id)))) {
        $hidden = array('sites_id' => $sites[0]->idsite, 'op' => 'update');
        $this->template->set_partial('container', 'administration/site/update_view', array('op_title' => 'Modifier un site:', 'op_btn_value' => 'Modifier', 'site' => (array) $sites[0], 'hidden' => $hidden));

        $this->template->build('body');
            } else {
                redirect(base_url('administration/site'));
            }
*/
  break;
    default:


     $this->template->title('Gestion des sites', 'console d\'administration' ,$this->template_page_title);
     $this->set_breadcrumb(array("Console d'administration" => 'administration/index', 'Gestion des sites' => ''));
     $site_arr = $this->site->read('*', '', 'idsite desc');
     $op_modal = $this->load->view('modals/admin/op_modal', '', true);
     $this->template->set_partial('container','administration/site/site_view',array('site_arr'=>$site_arr,'op_modal'=> $op_modal));
     $this->template->build('body');
}

}
/*** gestion des sites ***/






}

?>
