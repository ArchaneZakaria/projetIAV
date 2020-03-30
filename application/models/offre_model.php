<?php defined('BASEPATH') or exit('No direct script access allowed');

class Offre_model extends MY_Model {

    private $color;
    function __construct() {
        parent::__construct();
        $this->table = 'offre';
        $this->table_id = 'id_offre';
        $this->color = array('1'=>"#ff6699",'2'=>'#ffcc00','3'=>"#66ff33",'4'=>"#003300",'5'=>"#ff0000",
                            '6'=>'#0000ff','7'=>'#669999','8'=>'#cc9900','9'=>'#6600cc','10'=>'#996633');
    }

    /*public function GetMarcheTravaux()
    {
      $sql = "select ofr.N_AO,ofr.objet,ofr.estimation,ofr.id_type_budgetM,ofr.date_ouverture_plis,
      ofr.no_marche,ofr.montant_marche,ofr.date_engagement,ofr.date_caution_definitive,ofr.date_ordre_service,ofr.date_achevement_prestation,ofr.autres_informations from offre as frn,iav_domaineactivite as dmn
      where frn.id_domaineactivite = dmn.id_domaineactivite AND frn.deleted_fournisseur='N' AND module ='BM' ";
      $query = $this->db->query($sql);
      return $query;
    }
    //fonction DeleteByupdate est une fonction d'update utilise pour la suppr
    public function DeleteByupdate($conditions)
    {
        $date = date_create('now')->format('Y-m-d H:i:s');
      	$options = array('deleted_fournisseur' => 'O' , 'ddate_fournisseur' => $date);
        $this->db->where($this->table_id,$conditions['id']);
        return $this->db->update($this->table, $options);
    }*/
    public function create ($options,$cdate_marche_travaux = 'cdate_offre ') {
        return parent::create($options,$cdate_marche_travaux );
    }
}
