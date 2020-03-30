<?php defined('BASEPATH') or exit('No direct script access allowed');

class Iav_vehicule_model extends MY_Model {

    private $color;
    function __construct() {
        parent::__construct();
        $this->table = 'iav_vehicule';
        $this->table_id = 'id_vehicule';
        $this->color = array('1'=>"#ff6699",'2'=>'#ffcc00','3'=>"#66ff33",'4'=>"#003300",'5'=>"#ff0000",
                            '6'=>'#0000ff','7'=>'#669999','8'=>'#cc9900','9'=>'#6600cc','10'=>'#996633');
    }
  public function GetVehicules()
  {
    $sql = "select vcl.id_vehicule,vcl.matricule_vehicule , mdl.libeller_model,chf.nom_chauffeur,vcl.id_affectation,affect.code_affectation,
	        chf.prenom_chauffeur,vcl.id_chauffeur,depart.code_departement,affect.libelle_affectation,affect.couleur_affectation
            from iav_vehicule as vcl,iav_affectation as affect,iav_departement as depart
            ,iav_model as mdl,iav_chauffeur as chf
            where mdl.id_model = vcl.id_model and affect.id_affectation = vcl.id_affectation and depart.id_departement = vcl.id_departement
            and vcl.id_chauffeur = chf.id_chauffeur and vcl.deleted_vehicule = 'N' ";
    $query = $this->db->query($sql);

    return $query->result();
  }

  public function GetVehiculesMissions($idVeh = null)
  {
    $sql = "select vcl.id_vehicule,vcl.matricule_vehicule,vcl.id_affectation,affect.code_affectation,
            mdl.libeller_model,chf.nom_chauffeur,chf.prenom_chauffeur,affect.libelle_affectation,affect.couleur_affectation,
            mis.date_debut,mis.date_fin,depart.code_departement,
            mis.id_mission,chf.id_chauffeur,mis.km_mission
            from iav_vehicule as vcl, iav_affectation as affect,iav_departement as depart
            ,iav_model as mdl,iav_chauffeur as chf,iav_mission as mis
            where mdl.id_model = vcl.id_model
            and vcl.id_chauffeur = chf.id_chauffeur
            and mis.id_vehicule = vcl.id_vehicule
            and mis.etat_mission = 'V' and affect.id_affectation = vcl.id_affectation and depart.id_departement = vcl.id_departement
            and mis.deleted_mission = 'N' AND vcl.deleted_vehicule = 'N' ";
    if(isset($idVeh)) {
      $sql .= " and vcl.id_vehicule = {$idVeh} ";
    }
	$sql = $sql." ORDER BY vcl.id_affectation ASC";
    $query = $this->db->query($sql);
    return $query->result();
  }


  public function GetVehiculesMissionsPlanning($idVeh = null) {

    $vehicules       = $this->GetVehiculesMissions($idVeh);

    $resultVehicules = array();
    foreach($vehicules as $veh) {
      $dates_chf = array('debut'=>$veh->date_debut,'fin'=>$veh->date_fin,
      'id_chauffeur'=>$veh->id_chauffeur,'nom'=>$veh->nom_chauffeur,
      'prenom'=>$veh->prenom_chauffeur,'id_vehicule'=>$veh->id_vehicule,
      'matricule_vehicule'=>$veh->matricule_vehicule,'color'=>$this->color[intval(rand(1,10))]);
      $resultVehicules[$veh->id_vehicule]['data'] = $veh;
      $resultVehicules[$veh->id_vehicule]['missions'][$veh->id_mission] =$dates_chf;
    }
//echo '<pre>';print_r($resultVehicules);die();
    $missionResult = array();
    foreach ($resultVehicules as $id_veh => $veh) {
        foreach ($veh['missions'] as $id_mis => $mission) {
          $dateDebut  = DateTime::createFromFormat('Y-m-d H:i:s', $mission['debut']);
          $dateFin    = DateTime::createFromFormat('Y-m-d H:i:s', $mission['fin']);
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

  // dimance 18/03/2018
  public function GetVehicule_Alldata($idVeh = null)
  {
    $sql = "select * from iav_vehicule as vcl , iav_model as model , iav_marque as marque,
     iav_departement as depart , iav_chauffeur as chf,iav_affectation as affct
     where  vcl.id_departement = depart.id_departement AND vcl.deleted_vehicule = 'N'   AND
            vcl.id_chauffeur   = chf.id_chauffeur       AND
            vcl.id_marque    = marque.id_marque       AND affct.id_affectation = vcl.id_affectation AND
            vcl.id_model       = model.id_model ";
    if($idVeh != null){
      $sql .= "AND vcl.id_vehicule='".$idVeh."'";
    }
     $query = $this->db->query($sql);
     return $query;
  }
  //

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




}
