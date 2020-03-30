<?php defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/Master.php';

class Ctr_prolongation extends Master
{

    function __construct()
    {
        parent::__construct();

     $this->load->model('prolongation_model', 'prolongation');
    }

    public function index($data = '')
    {
             $this->display($data);
             /** verifier l'ouverture de session */
            $op_modal = $this->load->view('modals/admin/op_modall', '', true);
            $this->template->set_partial('container', 'prolongation_view',array('op_modal' => $op_modal ));
            $this->template->build('body');
    }




    public function prolongation($data = '',$id = NULL){


            $this->display($data);

            switch($data){

           //   case 'add':
           //
           // $this->set_breadcrumb(array("Ajouter une établissement" => 'mission/add'));
           // $this->template->set_partial('container', 'add_etablissement_view', array('data' => $data));
           // $this->template->title('dd','ee')
           //        ->build('body');
           //   break;

            case 'del':

           $etat_delete = '';
           $conditions = $this->input->post('id');

          /*  if (!is_array($conditions) && intval($conditions))
          $conditions = array('id_etablissement' => intval($conditions));

        $etat_delete = $this->db->delete('etablissement', $conditions);*/
         $etat_delete = $this->prolongation->delete($conditions,'0');

      if($etat_delete){
        echo json_encode(array('status' => '1',
                                        'url' => 'prolongation',
                                        'message' => 'la prolongation a été annulé avec succes'));
       }else{

        echo json_encode(array('status' => '0',
                               'url' => 'prolongation',
                               'message' => 'Erreur de traitement' ));
       }

             break;

              //  case 'edit':
              //
              // if (($id = intval($id)) && !empty($id) && ($etablissement = $this->etablissement->read("*",array('id_etablissement' => $id)))) {
              //   $hidden = array('id_etablissement' => $id);
              //
              //  $this->template->set_partial('container', 'add_etablissement_view', array('data' => $data,'etablissement' => (array) $etablissement[0],'hidden' => $hidden,'op_btn_value' => 'Modifier'));
              //  }else{
              // redirect(base_url('etablissement'));
              //  }

                  //$this->template->set_partial('container', 'add_etablissement_view', array('data' => $data));
                  // $this->template->title('dd','ee')
                  // ->build('body');
                  //  break;

             default:
    $op_modal = $this->load->view('modals/admin/op_modall', '', true);

   $this->template->set_partial('container', 'prolongation_view', array('data' => $data,'op_modal' => $op_modal));
   $this->template->title('dd','ee')
                  ->build('body');
            break;
            }




  }





    public function verifyUser()	{
		$this->load->view('vue');
	}


// This function call from AJAX
public function user_data_submit() {
$data = array(
'username' => $this->input->post('name'),
'pwd'=>$this->input->post('pwd')
);

//Either you can print value or you can send value to database
echo json_encode($data);
}


public function error(){

 $this->load->view('view_404');
}


}
/* End of file home.php */
/* Location: ./application/controllers/home.php */
