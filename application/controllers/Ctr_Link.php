<?php

class Ctr_link extends Master
{
  function __construct() {
       parent::__construct();
     //chargement du lib et les models
     $this->load->library('form_validation');
     $this->load->model('Iav_type_budget_model','typebudget');
     $this->load->model('Iav_annee_budget_model','budgetAnnuel');
     $this->load->model('Iav_type_budget__annee_montant','budgetAnneeMontant');
     $this->load->model('Iav_tranche_budget_model','tranche');
   }
   //l'action par defaut ver la liste du budget annuel , nous envoyons avec les types budget et les annees pour (la recherche par typebudget/annee)
   public function index($data = ''){


   }


?>
