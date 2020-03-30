<?php defined('BASEPATH') or exit('No direct script access allowed');

class Iav_personel_model extends MY_Model {

    private $CI;

    function __construct() {
        parent::__construct();
        $this->table = 'iav_personel';
        $this->table_id = 'id_personel';
        $this->CI =& get_instance();
        $this->CI->load->model('iav_personel_type_departement');
        $this->CI->load->model('iav_typepersonnel_model');
    }

    public function create ($options,  $created_on_field = 'cdate_personel') {
      $idDep = $options['id_departement'];
      $type_personel=$options['typepersonel'];

      unset($options['id_departement']);
      unset($options['typepersonel']);
      $idPer = parent::create($options, $created_on_field);
      if($type_personel=="personnel"){
        $type_personel="Administratif";
      }
      $id_typepersonel = $this->CI->iav_typepersonnel_model->Get_id_pr_type($type_personel);
      $options_per_tp_dp  = array(
         'id_personel'    => $idPer,
         'id_typepersonel'=> $id_typepersonel[0]->id_typepersonel,
         'id_departement' => $idDep
      );
      $this->CI->iav_personel_type_departement->create($options_per_tp_dp,NULL);
    }
    public function delete($id_pers)
    {
      $reslt = $this->CI->iav_personel_type_departement->delete($id_pers);
      if($reslt){
        $this->db->where('id_personel',$id_pers);
  	    $result= $this->db->delete($this->table);
        return $result;
      }else {
        return false;
      }
    }
    public function getById($idPer)
    {
      $sql="select pr.nom_personel, chf.nom_chauffeur,chf.prenom_chauffeur,chf.tel,
       chf.grade_chauffeur,chf.date_retraite,chf.code_chauffeur,dpt.libeller_departement as depart
       from iav_personel as pr,iav_departement as dpt
       where chf.id_departement=dpt.id_departement AND id_chauffeur ='".$id."'";
      $query = $this->db->query($sql);
      return $query;
    }
/*
    public function update ($options, $conditions = array()) {
        return parent::update($options, $conditions);
    }

    public function get_search ($match) {
        if (!isset($match) || empty($match))
            return array();
        $this->db->where('newsIsPublished', '1');
        $this->db->like('newsTitle', $match);
        $this->db->or_like('newsDescriptionBrut',$match);
        return $this->db->get($this->table)->result();
    }


	public function get_archive ($datearchive) {
        if (!isset($datearchive) || empty($datearchive))
            return array();

        $this->db->where('newsIsPublished', '1');
		//$match='2016-01-%';
		$this->db->like('newsCreatedOn',"$datearchive");
        //$this->db->like('newsCreatedOn','%2016-04-14%' );
        return $this->db->get($this->table)->result();
    }
*/

// ajouter etudiant
    public function ajouter_etudient($options)
    {
      $idDep         = $options['filiere'];
      $type_personel =$options['typepersonel'];
      unset($options['filiere']);
      unset($options['typepersonel']);
      $cdate = 'cdate_personel';
      if($this->IfExisteNiveau($options['nom_personel'])){
        $idPer = parent::create($options, $cdate);
        if(isset($idPer)){
          $id_typepersonel         = $this->CI->iav_typepersonnel_model->get_id_pr_type($type_personel);
          $cdate_personnel_depart  =  date_create('now')->format('Y-m-d H:i:s');
          $options_per_tp_dp       = array(
                 'id_personel'     => $idPer,
                 'id_typepersonel' => $id_typepersonel[0]->id_typepersonel,
                 'id_departement'  => $idDep,
                 'cdate_personel_type_departement ' => $cdate_personnel_depart
          );
          $this->CI->iav_personel_type_departement->create($options_per_tp_dp,NULL);
        }
        return true;
      }
      return false;

    }
    // tester si un niveau existe ou pas sur la table
    public function IfExisteNiveau($niveau)
    {
      $sql = "select id_personel from iav_personel where nom_personel='".$niveau."'";
      $query = $this->db->query($sql);
          foreach($query->result() as $rowDetail ){
            if(isset($rowDetail->id_personel)){
              return false;
            }
          }
          return true;
    }
    //modifier un personel
    public function modifier($options)
    {
      $id_per  = $options['id_personel'];
      $id_depr = $options['id_departement'];
      unset($options['typepersonel']);
      unset($options['id_personel']);
      unset($options['id_departement']);

      $date = date_create('now')->format('Y-m-d H:i:s');
      $options['udate_personel'] = $date;
      $this->db->where($this->table_id,$id_per);
      $this->db->update($this->table, $options);
      $result = $this->CI->iav_personel_type_departement->updateByPersonel($id_per,$id_depr);

    }

    public function GetAllNiveau()
    {
      $niveau = $this->db->query("select DISTINCT pr.code_personel,  pr.nom_personel,pr.id_personel from iav_personel_type_departement as ptd,
      iav_personel as pr where  pr.id_personel = ptd.id_personel AND ptd.id_typepersonel = 1 ");
      return $niveau;
    }
/*
    public function update ($options, $conditions = array()) {
        return parent::update($options, $conditions);
    }

    public function get_search ($match) {
        if (!isset($match) || empty($match))
            return array();
        $this->db->where('newsIsPublished', '1');
        $this->db->like('newsTitle', $match);
        $this->db->or_like('newsDescriptionBrut',$match);
        return $this->db->get($this->table)->result();
    }


  public function get_archive ($datearchive) {
        if (!isset($datearchive) || empty($datearchive))
            return array();

        $this->db->where('newsIsPublished', '1');
    //$match='2016-01-%';
    $this->db->like('newsCreatedOn',"$datearchive");
        //$this->db->like('newsCreatedOn','%2016-04-14%' );
        return $this->db->get($this->table)->result();
    }
*/
// get personel par un type personel soit : Administratif,etudiant,enseignant
public function getPersonel($type_personel)
{
  $sql="select per.id_personel,per.nom_personel as nom,per.prenom_personel as prenom,
     per.fonction_personel as fontion,per.Echel,per.email_personel as email,per.tel_personel as tel,
     tpe.libeller_typepersonel as typepersonel,dep.libeller_departement as departement
     from iav_personel as per,iav_departement as dep,
     iav_personel_type_departement ptd,iav_typepersonel tpe
     where per.id_personel=ptd.id_personel AND
      dep.id_departement=ptd.id_departement AND
        tpe.id_typepersonel=ptd.id_typepersonel ";
  if(isset($type_personel)){
    $sql = $sql." AND tpe.libeller_typepersonel='".$type_personel."'";
  }
  $query = $this->db->query($sql);
  return $query;
}
public function getAllPersonel()
{
  $sql="select per.id_personel,per.nom_personel as nom,per.prenom_personel as prenom,
     per.fonction_personel as fontion,per.email_personel as email,per.tel_personel as tel,
     tpe.libeller_typepersonel as typepersonel,dep.libeller_departement as departement
     from iav_personel as per,iav_departement as dep,
     iav_personel_type_departement ptd,iav_typepersonel tpe
     where per.id_personel=ptd.id_personel AND
      dep.id_departement=ptd.id_departement AND
        tpe.id_typepersonel=ptd.id_typepersonel AND tpe.libeller_typepersonel <> 'etudiant' ";
        $query = $this->db->query($sql);
        return $query;
}

















/**** demander un ordre de mission ***/

public function getPersonelMiss($type_personel,$id_departement)
{
  $sql="select *
     from iav_personel as per,iav_departement as dep,
     iav_personel_type_departement ptd,iav_typepersonel tpe
     where per.id_personel=ptd.id_personel AND
      dep.id_departement=ptd.id_departement AND
        tpe.id_typepersonel=ptd.id_typepersonel";

if(isset($type_personel) and isset($id_departement)){
    $sql = $sql." AND tpe.libeller_typepersonel='".$type_personel."' AND dep.id_departement='" . $id_departement . "'";
  }
    $query = $this->db->query($sql);
    return $query->result();
}

}
