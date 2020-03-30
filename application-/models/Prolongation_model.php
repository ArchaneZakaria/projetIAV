<?php defined('BASEPATH') or exit('No direct script access allowed');

class Prolongation_model extends MY_Model {

    // par ce parameter CI nous pouvons utiliser des models
    private $CI;

    function __construct() {
        parent::__construct();
        $this->table = 'prolongation';
        $this->table_id = 'id_prolongation';
        //charger CI
        $this->CI =& get_instance();
        // on utilisant CI on charge d'autre models
        $this->CI->load->model('retraite_model');
    }



    public function create ($options, $created_on_field = 'cdate_pronlogation') {
          return parent::create($options, $created_on_field);
      }

    public function update ($options, $conditions = array(), $modified_on_field = 'udate_pronlogation') {
          return parent::updateiav($options, $conditions, $modified_on_field,'id_pronlogation');
      }






    //annuler une prolongation
    public function delete($conditions,$id_pr=null)
    {
    $nbr_prol=0;
    $date_retraite=0;
    $date_retraite_notif=0;
    $result = $this->CI->retraite_model->read('*',array('deleted_retraite' => 'N','id_retraite' => $conditions));
    if(is_array($result) && !empty($result)){
          $nbr_prol = $result['0']->nbr_prolongation*2 ;
          $date_retraite = $result['0']->date_depart_retraite ;
          $date_retraite_notif = $result['0']->date_notif_retraite ;
      }

    $date_retraiteE = date("Y-m-d", strtotime($date_retraite ."-". $nbr_prol ."years"));
    $date_retraite_notifE = date("Y-m-d", strtotime($date_retraite_notif ."-". $nbr_prol ."years"));
    //echo $date_retraiteE . ' ' . $date_retraite_notifE; die;
    $Etat = "O";
    $by = 1;
    $date = date('Y-m-d H:i:s');
    //$this->db->set('deleted_retraite', $Etat);
    $this->db->set('dby_retraite', $by);
    $this->db->set('ddate_retraite', $date);
    $this->db->set('id_prolongation', $id_pr);
    $this->db->set('nbr_prolongation', '0');
    $this->db->set('status_prolongation', 'N');
    $this->db->set('date_depart_retraite', $date_retraiteE);
    $this->db->set('date_notif_retraite', $date_retraite_notifE);
    $this->db->where('id_retraite', $conditions);
    $etat_delete = $this->db->update('retraite');
    return $etat_delete;
    }


}
