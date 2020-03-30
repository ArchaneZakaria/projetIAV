<?php defined('BASEPATH') or exit('No direct script access allowed');

class Iav_mission_model extends MY_Model {

    private $color;
    function __construct() {
        parent::__construct();
        $this->table = 'iav_mission';
        $this->table_id = 'id_mission';
        $this->color = array('1'=>"#ff6699",'2'=>'#ffcc00','3'=>"#66ff33",'4'=>"#003300",'5'=>"#ff0000",
                            '6'=>'#0000ff','7'=>'#669999','8'=>'#cc9900','9'=>'#6600cc','10'=>'#996633');
    }


    public function create ($options,  $created_on_field = 'cdate_mission') {
      $idPer = parent::create($options, $created_on_field);
      return $idPer;
    }

    public function update ($options, $conditions = array(), $modified_on_field = 'udate_mission') {
        return parent::updateiav($options, $conditions, $modified_on_field,'id_mission');
    }

/*** editer la liste des missions encours **/

public function getMission_encours_valid($idMiss=''){

$queryDetail = $this->db->query("SELECT * FROM iav_mission inner join iav_personnel_mission on (iav_mission.id_mission = iav_personnel_mission.iav_mission_id_mission) inner join iav_personel on (iav_personnel_mission.iav_personel_id_personel = iav_personel.id_personel) inner join iav_mission_imputes on ( iav_mission_imputes.id_mission_imputes = iav_mission.id_mission_imputes) where iav_mission.etat_mission ='E' and iav_mission.id_mission ='" . $idMiss."' and iav_mission.deleted_mission='N'");

return $queryDetail->row();

}

/*** editer la liste des missions encours **/

/*** association personnel mission **/
    public function insert_mission_personnel($idPer='',$idMiss=''){

$post_data = array('iav_personel_id_personel'=> $idPer,'iav_mission_id_mission'=>$idMiss);
$this->db->insert('iav_personnel_mission',$post_data);
return $this->db->insert_id();

    }

    public function GetMissionsByVeichule($idvcl = null)
    {
      $sql = "select vcl.matricule_vehicule,mdl.libeller_model,chfr.nom_chauffeur,chfr.prenom_chauffeur,
      mission.date_debut,mission.date_fin,mission.id_mission,chfr.id_chauffeur
      from iav_mission as mission,iav_vehicule as vcl , iav_model as mdl , iav_chauffeur as chfr
      where mission.id_vehicule   = vcl.id_vehicule   AND
      mission.id_chauffeur       = chfr.id_chauffeur AND
      mdl.id_model               = vcl.id_model ";
      if(isset($idvcl)){
        $sql .= " and vcl.id_vehicule = '".$idvcl."'";
      }
      $query = $this->db->query($sql);
      return $query->result();

    }

    public function GetMissionBymonthYear($mois,$annee,$id_mission)
    {
      $date_inpt = $annee."-".$mois."-%";
      $sql       = "select id_mission, date_debut,date_fin from iav_mission where (date_debut like '".$date_inpt."'
                   or date_fin like '".$date_inpt."') AND id_mission = '".$id_mission."' ";
     $query      = $this->db->query($sql);
     return $query->result();
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

    public function getMissions($missions) {

      $missionResult = array();
      foreach ($missions as $key => $mission) {
        $dateDebut = DateTime::createFromFormat('Y-m-d H:m:s', $mission->date_debut);
        $dateFin = DateTime::createFromFormat('Y-m-d H:m:s', $mission->date_fin);
        $dateTemp = $dateDebut;
        $resultJourPrises = array();

        while($dateTemp <= $dateFin) {
            $mois = intval($dateTemp->format('m'));
            $jour = intval($dateTemp->format('d'));
            $resultJourPrises[$mois][$jour] = $jour;
            $dateTemp->add(new DateInterval('P1D'));
        }
        $missions[$key]->jours_prises = $resultJourPrises;
      }
      return $missions;
    }
    public function GeMissionsPlanning($idChauffeur)
      {
        $missons = $this->GetMissonsByChauffeur($idChauffeur);
        $resultVehicules = array();
        foreach($missons as $veh) {

          $dates_chf = array('debut'=>$veh->date_debut,'fin'=>$veh->date_fin,
          'id_chauffeur'=>$veh->id_chauffeur,'nom'=>$veh->nom_chauffeur,
          'prenom'=>$veh->prenom_chauffeur,'id_vehicule'=>$veh->id_vehicule,
          'matricule_vehicule'=>$veh->matricule_vehicule,'color'=>$this->color[intval(rand(1,10))]);

          $resultVehicules[$veh->id_chauffeur]['data'] = $veh;
          $resultVehicules[$veh->id_chauffeur]['missions'][$veh->id_mission] =$dates_chf;

        }

        $missionResult = array();
        foreach ($resultVehicules as $id_veh => $veh) {
            foreach ($veh['missions'] as $id_mis => $mission) {
              $dateDebut  = DateTime::createFromFormat(DATE_TIME_FORMAT, $mission['debut']);
              $dateFin    = DateTime::createFromFormat(DATE_TIME_FORMAT, $mission['fin']);
              $dateTemp   = $dateDebut;
              $resultJourPrises = array();

              while($dateTemp <= $dateFin) {
                  $mois = intval($dateTemp->format('m'));
                  $jour = intval($dateTemp->format('d'));
                  $resultJourPrises[$mois][$jour] = $jour;
                  $dateTemp->add(new DateInterval('P1D'));
              }
              $resultVehicules[$id_veh]['missions'][$id_mis]['jours_prises'] = $resultJourPrises;
            }
        }
    //echo '<pre>';print_r($resultVehicules);die;
        return $resultVehicules;
      }


    /***** mahfoud : afficher les missions de chauffeur precis (id)***/
       public function GetMissonsByChauffeur($idchfr)
    {
      $sql = "select mission.id_mission,chf.id_chauffeur,chf.nom_chauffeur,chf.prenom_chauffeur,
      vcl.matricule_vehicule,mission.date_debut,mission.date_fin,mission.id_vehicule from iav_mission as mission ,iav_vehicule as vcl, iav_chauffeur as chf
       where mission.id_chauffeur = chf.id_chauffeur and mission.id_vehicule = vcl.id_vehicule  and mission.etat_mission = 'V' ";
       if($idchfr != null){
         $sql .= " and mission.id_chauffeur = '".$idchfr."'";
       }
        $query      = $this->db->query($sql);
        return $query->result();
    }

    /***** mahfoud  ***/


   public function getLastMissionsPageHome($numberElement)
   {
     $sql ="select  mission.libeller_mission,mission.date_debut,pers.nom_personel,pers.prenom_personel,chf.prenom_chauffeur,
      depart.libeller_departement,chf.nom_chauffeur,chf.prenom_chauffeur,vcl.matricule_vehicule
      from iav_mission as mission , iav_personel as pers ,iav_vehicule as vcl,iav_departement as depart,
      iav_chauffeur as chf,iav_personel_type_departement as ptd where
      mission.id_chauffeur = chf.id_chauffeur AND
      mission.id_vehicule  = vcl.id_vehicule  AND
      mission.cby_mission  = pers.id_personel AND
      pers.id_personel     = ptd.id_personel AND
      depart.id_departement= ptd.id_departement";
      $query            = $this->db->query($sql);
      $tab_all_missions =  $query->result();
      return array_slice($tab_all_missions,count($tab_all_missions)-$numberElement);
   }

   /***** mahfoud  ***/


   /***** mahfoud  ***/
   // Gestion transport dotation start
    public function getdataMissionByIdMission($idMission)
    {
     $sql    = "select vcl.id_vehicule , vcl.matricule_vehicule , chf.id_chauffeur , chf.nom_chauffeur , chf.prenom_chauffeur
             from iav_mission as mission , iav_vehicule as vcl ,iav_chauffeur as chf where
             mission.id_vehicule = vcl.id_vehicule AND
             mission.id_chauffeur= chf.id_chauffeur AND mission.id_mission = '".$idMission."'";
     $query  = $this->db->query($sql);
     return $query->result();
    }
    public function mission_valid()
    {
      $sql ="select * from iav_mission inner join iav_personnel_mission on  iav_personnel_mission.iav_mission_id_mission = iav_mission.id_mission inner join iav_personel on iav_personel.id_personel = iav_personnel_mission.iav_personel_id_personel";
      $query  = $this->db->query($sql);
      return $query->result();
    }

   // Gestion transport dotation end


}
