<?php defined('BASEPATH') or exit('No direct script access allowed');

class Iav_departement_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'iav_departement';
        $this->table_id = 'id_departement';
    }

    public function GetDepartementParent()
    {
      $sql = "select * from iav_departement where id_parent = 0";
      $query = $this->db->query($sql);
      return $query;
    }

     public function getDepartementServiceWithEtablissement()
    {
      $sql ="select deprt.id_departement,deprt.libeller_departement,etb.libelle_etablissement
            from iav_departement as deprt,etablissement as etb where deprt.id_etablissement = etb.id_etablissement";
      $query = $this->db->query($sql);
      return $query;
    }
/*
    public function create ($options) {
        return parent::create($options);
    }

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

public function getDepartementService()
{
  $sql="select * from iav_departement inner join etablissement on ( iav_departement.id_etablissement = etablissement.id_etablissement)
   where  iav_departement.deleted_departement='N' ";
  $query = $this->db->query($sql);
	return $query;
}


public function getFiliereByDep($idP){
$sql ="select * from iav_departement inner join iav_personel_type_departement on (iav_departement.id_departement = iav_personel_type_departement.id_departement) inner join iav_personel on (iav_personel.id_personel = iav_personel_type_departement.id_personel)
inner join iav_typedepart on (iav_typedepart.id_typedepart = iav_departement.id_typedepart)
where iav_personel.id_personel ='". $idP ."'";
$query = $this->db->query($sql);
if(count($query->result()) == 0){
    return;
  }

 $resultat = $query->result();
 $tab = array();
 $tab1 = array();

if($resultat['0']->code_typedepart == 'D'){
   /*$tab1 = $this->getDsnByDepart($resultat['0']->id_departement,$tab);
   return $tab1;*/

   foreach ($query->result() as $key => $value) {
    $array_ids[$value->id_departement] = $value->libeller_departement;
    return $this->getSUpByDepart($value->id_departement,$array_ids);
  }
}else if($resultat['0']->code_typedepart == 'F'){
   return $resultat['0']->id_departement ;
}else{
   return 'S';
  }
   return;
}
//connexion

//recuprer filiere SUP
public function getSUpByDepart($id_depart,$array_ids)
{
  $sql = "select * from iav_departement where id_departement = '".$id_depart."' ";
  $query = $this->db->query($sql);
  if(count($query->result()) == 0){
    return;
  }

  foreach ($query->result() as $key => $value) {

   $sqlf = "
select iav_departement.id_departement from iav_departement inner join iav_typedepart on (iav_typedepart.id_typedepart = iav_departement.id_typedepart)
where iav_typedepart.code_typedepart = 'F' AND iav_departement.id_departement ='" . $value->id_parent . "'";
  $queryf = $this->db->query($sqlf);
  $idParentv='';
 if($queryf->result()){
 $idParentv = $value->id_parent;
    }

  }
   return $idParentv;
}

public function getDsnByDepart($id_depart,$array_ids)
{
  $sql = "select * from iav_departement inner join iav_typedepart on (iav_departement.id_typedepart = iav_departement.id_typedepart )  where id_parent = '".$id_depart."' ";
  $query = $this->db->query($sql);
  if(count($query->result()) == 0){
    return;
  }
  foreach ($query->result() as $key => $value) {
    $array_ids[$value->id_departement] = $value->libeller_departement;
   // $array_ids['typeDep'.$value->id_departement] = $value->code_typedepart;
    $this->getDsnByDepart($value->id_departement,$array_ids);
  }
   return $array_ids;
}
//end connexion

}
