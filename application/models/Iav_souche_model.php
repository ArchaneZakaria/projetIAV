<?php defined('BASEPATH') or exit('No direct script access allowed');

class Iav_souche_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'iav_souche';
        $this->table_id = 'id_souche';
    }

    public function getSouches($id = null,$id_chf = 0,$id_vcl = 0,$num_souche = "tt",$date_d = null,$date_f = null,$user = 0)
    {
      $sql ="select * from iav_souche,iav_vehicule,iav_chauffeur,iav_personel where
        iav_souche.id_chauffeur = iav_chauffeur.id_chauffeur and iav_souche.iav_vehicule = iav_vehicule.id_vehicule and
        iav_souche.cby_souche = iav_personel.id_personel and iav_souche.deleted_souche = 'N'";
        if($id != null){
          $sql = $sql." and iav_souche.id_souche = '".$id."'";
        }
        if($id_chf != 0){
          $sql = $sql." and iav_souche.id_chauffeur ='".$id_chf."'";
        }
        if($id_vcl != 0){
          $sql = $sql." and iav_souche.iav_vehicule = '".$id_vcl."'";
        }
        if($num_souche != 'tt'){
          $sql = $sql." and iav_souche.num_souche = '".$num_souche."'";
        }
        if($date_d != null){
          $sql = $sql." and iav_souche.date_souche >= '".$date_d."'";
        }
        if($date_f != null){
          $sql = $sql." and iav_souche.date_souche <= '".$date_f."'";
        }
        if($user != 0){
          $sql = $sql." and iav_souche.cby_souche = '".$user."'";
        }
        $query = $this->db->query($sql);
        return $query;
    }

    public function getSouches1($id = null,$id_chf = 0,$id_vcl = 0,$num_souche = "tt",$date_d = null,$date_f = null,$user = 0)
    {
      $sql ="select * from iav_souche,iav_vehicule,iav_chauffeur,iav_personel where
        iav_souche.id_chauffeur = iav_chauffeur.id_chauffeur and iav_souche.iav_vehicule = iav_vehicule.id_vehicule and
        iav_souche.cby_souche = iav_personel.id_personel and iav_souche.deleted_souche = 'N'";
        if($id != null){
          $sql = $sql." and iav_souche.id_souche = '".$id."'";
        }
        if($id_chf != 0){
          $sql = $sql." and iav_souche.id_chauffeur ='".$id_chf."'";
        }
        if($id_vcl != 0){
          $sql = $sql." and iav_souche.iav_vehicule = '".$id_vcl."'";
        }
        if($num_souche != 'tt'){
          $sql = $sql." and iav_souche.num_souche = '".$num_souche."'";
        }
        if($date_d != null){
          $sql = $sql." and iav_souche.date_souche >= '".$date_d."'";
        }
        if($date_f != null){
          $sql = $sql." and iav_souche.date_souche <= '".$date_f."'";
        }
        if($user != 0){
          $sql = $sql." and iav_souche.cby_souche = '".$user."'";
        }
        $query = $this->db->query($sql);
        return $query;
    }

}
