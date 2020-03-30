<?php defined('BASEPATH') or exit('No direct script access allowed');

class Iav_personel_model extends MY_Model {

    // par ce parameter CI nous pouvons utiliser des models
    private $CI;

    function __construct() {
        parent::__construct();
        $this->table = 'iav_personel';
        $this->table_id = 'id_personel';
        //charger CI
        $this->CI =& get_instance();
        // on utilisant CI on charge d'autre models
        $this->CI->load->model('iav_personel_type_departement');
        $this->CI->load->model('iav_typepersonnel_model');
    }

    //creer personel et ajouter la date de creation et faire l'appell avec une fonction parent ::MY_Model

    public function ajouter_personel($options,  $created_on_field = 'cdate_personel') {
      $idDep = $options['id_departement'];
      $type_personel=$options['typepersonel'];

      unset($options['id_departement']);
      unset($options['typepersonel']);
      $idPer = parent::create($options, $created_on_field);
      if($type_personel=="personnel"){
        $type_personel="Administratif";
      }
      $id_typepersonel = $this->CI->iav_typepersonnel_model->get_id_pr_type($type_personel);
      $options_per_tp_dp  = array(
         'id_personel'    => $idPer,
         'id_typepersonel'=> $id_typepersonel[0]->id_typepersonel,
         'id_departement' => $idDep
      );
      $this->CI->iav_personel_type_departement->create($options_per_tp_dp,'cdate_personel_type_departement');
    }
    //delete etudiant par son id
    public function delete($id_pers)
    {
      $result = $this->CI->iav_personel_type_departement->DeletePersonnelById($id_pers);
      return $this->db->delete($this->table, array($this->table_id => $id_pers));
    }
    //get personel by id
    public function getById($idPer)
    {
      $sql="select etab.libelle_etablissement as libelle_etablissement,pr.id_personel,pr.nom_personel,pr.prenom_personel,pr.email_personel,
       pr.password,pr.tel_personel,pr.niveau_grade_personel,pr.date_retraite_personel,pr.code_personel,
       pr.Echel ,pr.fonction_personel,dpt.id_departement,dpt.libeller_departement
       from iav_personel as pr,iav_departement as dpt,iav_personel_type_departement as ptd,etablissement etab
       where pr.id_personel = ptd.id_personel AND
       dpt.id_departement = ptd.id_departement AND
       etab.id_etablissement =dpt.id_etablissement AND
       pr.id_personel ='".$idPer."' and pr.deleted_personel ='N'";
      $query = $this->db->query($sql);
      return $query;
    }
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
                 'cdate_personel_type_departement	' => $cdate_personnel_depart
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
      $id_cadre = $options['id_cadre'];
      unset($options['typepersonel']);
      unset($options['id_personel']);
      unset($options['id_departement']);
      unset($options['id_cadre']);
      $date = date_create('now')->format('Y-m-d H:i:s');
      $options['udate_personel'] = $date;
      $this->db->where($this->table_id,$id_per);
      $this->db->update($this->table, $options);

      $result = $this->CI->iav_personel_type_departement->updateByPersonel($id_per,$id_depr,$id_cadre);

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
  $sql="select etab.libelle_etablissement,per.id_personel,per.nom_personel as nom,per.prenom_personel as prenom,per.code_personel,
     per.fonction_personel as fontion,per.Echel,per.email_personel as email,per.tel_personel as tel,
     tpe.libeller_typepersonel as typepersonel,dep.libeller_departement as departement
     from iav_personel as per,iav_departement as dep,
     iav_personel_type_departement ptd,iav_typepersonel tpe,etablissement etab
     where per.id_personel=ptd.id_personel AND
      dep.id_departement=ptd.id_departement AND
        tpe.id_typepersonel=ptd.id_typepersonel and
        etab.id_etablissement = dep.id_etablissement and
        per.deleted_personel = 'N' ";
  if(isset($type_personel)){
    $sql = $sql." AND tpe.libeller_typepersonel='".$type_personel."'";
  }
	$query = $this->db->query($sql);
	return $query;
}
public function getAllPersonel()
{
  $sql="select etab.libelle_etablissement,per.id_personel,per.nom_personel as nom,per.prenom_personel as prenom,code_personel,
     per.fonction_personel as fontion,per.email_personel as email,per.tel_personel as tel,
     tpe.libeller_typepersonel as typepersonel,dep.libeller_departement as departement
     from iav_personel as per,iav_departement as dep,
     iav_personel_type_departement ptd,iav_typepersonel tpe,etablissement    etab
     where per.id_personel=ptd.id_personel AND
      dep.id_departement = ptd.id_departement AND
      tpe.id_typepersonel = ptd.id_typepersonel AND
      etab.id_etablissement = dep.id_etablissement AND
      tpe.libeller_typepersonel <> 'etudiant' and per.deleted_personel = 'N' ";
        $query = $this->db->query($sql);
      	return $query;
}


/**** demander un ordre de mission ***/

/**** demander un ordre de mission ***/

public function getPersonelMiss($type_personel = null,$id_departement = null)
{
  $sql="select *
     from iav_personel as per,iav_departement as dep,
     iav_personel_type_departement ptd,iav_typepersonel tpe
     where per.id_personel=ptd.id_personel AND
      dep.id_departement=ptd.id_departement AND
        tpe.id_typepersonel=ptd.id_typepersonel";
if($type_personel != null){
  $sql = $sql." AND tpe.libeller_typepersonel='".$type_personel."' ";
}
if($id_departement){
  $sql = $sql."AND dep.id_departement='".$id_departement."' ";
}

$query = $this->db->query($sql);
return $query->result();
}

public function  getPersonelMissTota(){

  $sql="select *
     from iav_personel as per,iav_departement as dep,
     iav_personel_type_departement ptd,iav_typepersonel tpe
     where per.id_personel=ptd.id_personel AND
      dep.id_departement=ptd.id_departement AND
        tpe.id_typepersonel=ptd.id_typepersonel";



$query = $this->db->query($sql);
return $query->result();

}


//connexion start

public function connexion($email,$password)
{
    $data_user = array();
    $sql ="select * from iav_personel as per,iav_departement as deprt,iav_personel_type_departement as perDepart,iav_typepersonel as typeper
    where per.id_personel = perDepart.id_personel and deprt.id_departement = perDepart.id_departement and perDepart.id_typepersonel = typeper.id_typepersonel
    and per.email_personel = '".$email."' and per.password = md5('".$password."') and per.deleted_personel = 'N'";
    $query = $this->db->query($sql);
    if(count($query->result()) == 1){
      $data_user['etat_connexion'] = "connecte";
    }else {
        $data_user['etat_connexion'] = "non connecte";
    }
    $data_user['data'] = array();
    $data_user['data'] = $query->result();
    return $data_user;
}


public function getApplicationsByUser($id_user)
{
  $appli_user = array();
  $sql ="SELECT *
FROM droits_acces
INNER JOIN iav_personel_type_departement ON ( droits_acces.iav_personel_type_departement = iav_personel_type_departement.id_personel_type_departement )
INNER JOIN iav_application ON ( iav_application.id_application = droits_acces.iav_application_id_application )
WHERE deleted_droits_acces =  'N'
AND iav_personel_type_departement.id_personel =  '". $id_user . "'";


  $query = $this->db->query($sql);
  foreach ($query->result() as $key => $value) {
    $appli_user[$value->iav_application_id_application] = $value->url_application;
  }

  return $appli_user;
}
public function envoie_email($to,$password)
{
  //envoi email to client

$subject  = 'ParcAuto :Modification du mot de passe de votre compte parc-auto';
$message  = '
<div style="font-style:oblique;font-size:15px">
 <B>Cher / Chere</B><br><br>
 Votre mot de passe a été modifié avec succés , vous trouvez ci-dessous votre nouveau Mot de passe <br><br>
<B>Mot de passe : '.$password.'</B>
</div>';
$headers  = 'From: benabbeskhalid@gmail.com' . "\r\n" .
           'MIME-Version: 1.0' . "\r\n" .
           'Content-type: text/html; charset=utf-8';
mail($to, $subject, $message, $headers);
//end envoi email to client
}
//connexion end

}
