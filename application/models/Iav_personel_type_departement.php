<?php defined('BASEPATH') or exit('No direct script access allowed');

class Iav_personel_type_departement extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'iav_personel_type_departement';
        $this->table_id = 'id_personel_type_departement';
    }
    public function create ($options,  $created_on_field = null) {
      parent::create($options, $created_on_field);
    }
    public function delete($id){

	    return $this->db->delete($this->table, array($this->table_id => $id));
    }
    public function DeletePersonnelById($idPerson)
    {
      $sql = "delete from iav_personel_type_departement where id_personel = '".$idPerson."'";
      $query = $this->db->query($sql);
      return $query;

    }
    public function GetAllEtudient(){
      $sql = "select dtp.id_personel_type_departement as id ,dtp.id_personel as idpersn,
        pr.nom_personel as niveau , dprt.libeller_departement as dprt from iav_personel as pr , iav_personel_type_departement as dtp,
      iav_departement as dprt where pr.id_personel = dtp.id_personel AND
        dprt.id_departement = dtp.id_departement
        AND  dtp.id_typepersonel = 1";
        $query = $this->db->query($sql);
        return $query;
    }
    public function GetEtudientByPersonel($id_pers)
    {
      $sql = "select dtp.id_personel_type_departement as id ,
        pr.nom_personel as niveau , dprt.libeller_departement as dprt from iav_personel as pr , iav_personel_type_departement as dtp,
        iav_departement as dprt where pr.id_personel = dtp.id_personel AND
        dprt.id_departement = dtp.id_departement
        AND  dtp.id_typepersonel = 1 AND dtp.id_personel = '".$id_pers."'";
        $query = $this->db->query($sql);
        return $query;
    }
    public function Count_IdPersonnel($idpers)
    {
        $sql = " select * from iav_personel_type_departement where id_personel='".$idpers."'";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
    public function GetEtudientByFlre($filiere){
      $sql = "select dtp.id_personel_type_departement as id ,
        pr.nom_personel as niveau , dprt.libeller_departement as dprt from iav_personel as pr , iav_personel_type_departement as dtp,
        iav_departement as dprt where pr.id_personel = dtp.id_personel AND
        dprt.id_departement = dtp.id_departement
        AND  dtp.id_typepersonel = 1 AND dtp.id_departement = '".$filiere."'";
        $query = $this->db->query($sql);
        return $query;
    }
    public function GetEtudientByPersonel_Filiere($pres,$filiere) {
      $sql = "select dtp.id_personel_type_departement as id ,
        pr.nom_personel as niveau , dprt.libeller_departement as dprt from iav_personel as pr , iav_personel_type_departement as dtp,
        iav_departement as dprt where pr.id_personel = dtp.id_personel AND
        dprt.id_departement = dtp.id_departement
        AND  dtp.id_typepersonel = 1 AND dtp.id_personel = '".$pres."' AND
        dtp.id_departement = '".$filiere."'";
        $query = $this->db->query($sql);
        return $query;
    }
    public function Affecter_per_fielre($options){
        return $this->CI->iav_personel_type_departement->create($options,NULL);
    }
    public function updateByPersonel($idPer,$idDep,$idCadre){
       $sql="update iav_personel_type_departement set id_departement = '".$idDep."' , id_typepersonel ='". $idCadre . "'
              where id_personel = '".$idPer."' ";
      $query = $this->db->query($sql);
      return $query;
    }
    public function getById($id)
    {
      $sql = "select dprt.id_departement as iddeprt, ptd.id_personel_type_departement as id,pr.id_personel as id_pr, pr.nom_personel niveau,
      dprt.libeller_departement as filiere from iav_personel as pr , iav_departement as dprt , iav_personel_type_departement as ptd
      where pr.id_personel = ptd.id_personel AND dprt.id_departement = ptd.id_departement
       AND ptd.id_personel_type_departement = '".$id."'";
       $query = $this->db->query($sql);
       return $query;

    }
    public function modifier_etudiant_flr($options)
    {
      $id                                = $options['id'];
      $udate_personnel_depart            = date_create('now')->format('Y-m-d H:i:s');
      unset($options['id']);
      $options['udate_personel_type_departement'] = $udate_personnel_depart;
      $this->db->where($this->table_id,$id);
      $this->db->update($this->table, $options);

    }

}
