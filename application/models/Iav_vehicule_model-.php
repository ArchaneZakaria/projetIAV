<?php defined('BASEPATH') or exit('No direct script access allowed');

class Iav_vehicule_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'iav_vehicule';
        $this->table_id = 'id_vehicule';
    }
  public function GetVehicules()
  {
    $sql = "select vcl.id_vehicule,vcl.matricule_vehicule , mdl.libeller_model,chf.nom_chauffeur,chf.prenom_chauffeur
            from iav_vehicule as vcl
            ,iav_model as mdl,Iav_chauffeur as chf
            where mdl.id_model = vcl.id_vehicule
            and vcl.id_chauffeur = chf.id_chauffeur";
    $query = $this->db->query($sql);

    return $query->result();
  }

  public function GetVehiculesMissions($idVeh = null)
  {
    $sql = "select vcl.id_vehicule,vcl.matricule_vehicule,
            mdl.libeller_model,chf.nom_chauffeur,chf.prenom_chauffeur,
            mis.date_debut,mis.date_fin,
            mis.id_mission,chf.id_chauffeur
            from iav_vehicule as vcl
            ,iav_model as mdl,Iav_chauffeur as chf,iav_mission as mis
            where mdl.id_model = vcl.id_vehicule
            and vcl.id_chauffeur = chf.id_chauffeur
            and mis.id_vehicule = vcl.id_vehicule
            and mis.etat_mission = 'V'";
    if(isset($idVeh)) {
      $sql .= " and vcl.id_vehicule = {$idVeh} ";
    }
    $query = $this->db->query($sql);

    return $query->result();
  }


  public function GetVehiculesMissionsPlanning($idVeh = null) {

    $vehicules = $this->GetVehiculesMissions($idVeh);
    $resultVehicules = array();
    foreach($vehicules as $veh) {
      $dates_chf = array('debut'=>$veh->date_debut,'fin'=>$veh->date_fin,
      'id_chauffeur'=>$veh->id_chauffeur,'nom'=>$veh->nom_chauffeur,
      'prenom'=>$veh->prenom_chauffeur,'id_vehicule'=>$veh->id_vehicule,'matricule_vehicule'=>$veh->matricule_vehicule);
      $resultVehicules[$veh->id_vehicule]['data'] = $veh;
      $resultVehicules[$veh->id_vehicule]['missions'][$veh->id_mission] =$dates_chf;
    }

    $missionResult = array();
    foreach ($resultVehicules as $id_veh => $veh) {
        foreach ($veh['missions'] as $id_mis => $mission) {
          $dateDebut  = DateTime::createFromFormat('Y-m-d', $mission['debut']);
          $dateFin    = DateTime::createFromFormat('Y-m-d', $mission['fin']);
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

/******khalid****/



/***** khalid **/



}
