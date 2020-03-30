<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-sidebar">
  <?php  //$acces_f = $this->session->user['id_role']; ?>
    <!-- START X-NAVIGATION -->



    <style>
    .logo{
      font-size:20px;
      color:#FFF;
    }

    .menu{
      color:#999;
    }

    .menu:hover{
      color:#FFF;
    }


    .dropdown-submenu {
      position: relative;
    }

    .dropdown-submenu .dropdown-menu {
      top: 0;
      left: 100%;
      margin-top: -1px;
    }
    </style>

<!--Header-part-->
<div id="header" >

<h2 class="logo" style="padding-top:5px;"><a href="<?=  base_url('accueil') ?>" style="color:#23b256;margin-left:5px; "><i class=" icon-group" aria-hidden="true"></i>
SuiviMB</a></h2>
</div>
<!--close-Header-part-->


    <!--top-Header-menu-->
    <!--top-Header-menu-->
    <div id="user-nav">
      <ul class="nav row">
<div id="MystyleMenu" style="left: 150px !important">
        <li  class="dropdown" id="profile-phase"  ><a title="phase" href="#" data-toggle="dropdown" data-target="#profile-profile-phase" class="dropdown-toggle"><i class="icon icon-user"></i>  <span class="text">Phase</span><b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="<?= base_url('phase/add') ?>"><i class="icon-user"></i> Creation</a></li>
            <li class="divider"></li>

            <li class="dropdown-submenu">
           <a class="test" tabindex="-1" href="#"><i class="icon-check"></i>Liste</a>
           <ul class="dropdown-menu">
             <li><a tabindex="-1" href="<?= base_url('phase/lbncommande') ?>">Bon de comande</a></li>
             <li><a tabindex="-1" href="<?= base_url('phase/lmarchetravaux') ?>">Marché travaux</a></li>
             <li><a tabindex="-1" href="<?=  base_url('phase/lmarchefouriture') ?>">Marché fourniture</a></li>
           </ul>
         </li>

          </ul>
        </li>

        <li  class="dropdown" id="profile-messages" ><a title="Bon de commande" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle"><i class="icon icon-user"></i>  <span class="text">Bon de commande</span><b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="<?= base_url('bncom/add/0') ?>"><i class="icon-user"></i> création</a></li>
            <li class="divider"></li>
            <li><a href="<?= base_url('bncom/listbcec/0') ?>"><i class="icon-check"></i> Bons de commande en cours </a></li>
            <li class="divider"></li>
            <li><a href="<?= base_url('bncom/listbcv/0') ?>"><i class="icon-key"></i> Bons de commande  validés</a></li>
            <li><a href="<?= base_url('bncom/listbcr/0') ?>"><i class="icon-key"></i> Bons de commande réceptionnés</a></li>
            <li><a href="<?= base_url('bncom/listbca/0') ?>"><i class="icon-key"></i> Bons de commande annulés</a></li>
          </ul>
        </li>

        <li  class="dropdown" id="profile-marche" ><a title="" href="#" data-toggle="dropdown" data-target="#profile-marche" class="dropdown-toggle"><i class="icon icon-user"></i>  <span class="text">Marché</span><b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li class="dropdown-submenu">
                    <a class="test" tabindex="-1" href="#"><i class="icon-check"></i>Marché travaux</a>
                    <ul class="dropdown-menu">
                        <li><a href="<?= base_url('marcheTr/etab/add') ?>"><i class="icon-user"></i> créer</a></li>
                        <li class="divider"></li>
                        <li><a href="<?= base_url('marcheTr/etab/marchetravauxec') ?>"><i class="icon-check"></i> Marché travaux en cours </a></li>
                        <li class="divider"></li>
                        <li><a href="<?= base_url('marcheTr/etab/marchetravauxva') ?>"><i class="icon-key"></i> Marché travaux  validés</a></li>
                        <li><a href="<?= base_url('marcheTr/etab/marchetravauxre') ?>"><i class="icon-key"></i> Marché travaux réceptionnés</a></li>
                        <li><a href="<?= base_url('marcheTr/etab/marchetravauxan') ?>"><i class="icon-key"></i> Marché travaux annulés</a></li>
                    </ul>
                </li>
                <li class="divider"></li>
                <li class="dropdown-submenu">
                    <a class="test" tabindex="-1" href="#"><i class="icon-check"></i>Marché fourniture</a>
                    <ul class="dropdown-menu">
                    <li><a href="<?= base_url('marcheFr/etab//etab/add') ?>"><i class="icon-user"></i> créer</a></li>
                    <li class="divider"></li>
                    <li><a href="<?= base_url('marcheFr/etab/marchefournitureec') ?>"><i class="icon-check"></i> Marché fourniture en cours </a></li>
                    <li class="divider"></li>
                    <li><a href="<?= base_url('marcheFr/etab/marchefournitureva') ?>"><i class="icon-key"></i> Marché fourniture  validés</a></li>
                    <li><a href="<?= base_url('marcheFr/etab/marchefourniturere') ?>"><i class="icon-key"></i> Marché fourniture réceptionnés</a></li>
                    <li><a href="<?= base_url('marcheFr/etab/marchefourniturean') ?>"><i class="icon-key"></i> Marché fourniture annulés</a></li>
                   </ul>
                </li>
                <li class="divider"></li>
            </ul>
        </li>



      <li class="dropdown" id="menu-fournisseur"><a href="#" data-toggle="dropdown" data-target="#menu-fournisseur" class="dropdown-toggle"><i class="icon icon-envelope"></i> <span class="text">Prestataire</span> <span class="label label-important">5</span> <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li><a class="sAdd" title="" href="<?= base_url('prestataire/domaineActivite/1') ?>"><i class="icon-plus"></i> Domaine d'activité</a></li>
          <li class="divider"></li>
          <li><a class="sInbox" title="" href="<?=base_url('prestataire/add')?>"><i class="icon-envelope"></i> Création préstataire</a></li>
          <li class="divider"></li>
          <li><a class="sOutbox" title="" href="<?=base_url('prestataire/list')?>"><i class="icon-arrow-up"></i> Liste préstataire</a></li>
          <li class="divider"></li>
        </ul>
      </li>

      <li class=""><a title="" href="#"><i class="icon-bar-chart"></i> <span class="text">Statistique</span></a></li>
     <li class=""><a title="" href="<?= base_url('exercice')?>"><i class="icon icon-cog"></i> <span class="text">Exercice</span></a></li>



        <li style="margin-left:100px;" class="dropdown" id="menu-messages"><a href="#" data-toggle="dropdown" data-target="#menu-messages" class="dropdown-toggle"><i class="icon icon-envelope"></i> <span class="text">Messages</span> <span class="label label-important">5</span> <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a class="sAdd" title="" href="#"><i class="icon-plus"></i> new message</a></li>
            <li class="divider"></li>
            <li><a class="sInbox" title="" href="#"><i class="icon-envelope"></i> inbox</a></li>
            <li class="divider"></li>
            <li><a class="sOutbox" title="" href="#"><i class="icon-arrow-up"></i> outbox</a></li>
            <li class="divider"></li>
            <li><a class="sTrash" title="" href="#"><i class="icon-trash"></i> trash</a></li>
          </ul>
        </li>


        <li class="dropdown" id="menu-alertes"><a href="#" data-toggle="dropdown" data-target="#menu-alertes" class="dropdown-toggle"><i class=" icon-bell"></i> <span class="text">Alertes</span> <span class="label label-important">5</span> <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a class="sAdd" title="" href="#"><i class="icon-plus"></i> Alertes </a></li>
            <li class="divider"></li>

            <li class="divider"></li>
            <li><a class="sTrash" title="" href="#"><i class="icon-trash"></i> Tous les alertes</a></li>
          </ul>
        </li>

        <li><a title="" href="login.html"><i class="icon icon-share-alt"></i> <span class="text"></span></a></li>
    </div>
      </ul>
  </div>
    <!--close-top-Header-menu-->
    <!--start-top-serch-->
    <div id="search">
      <input type="text" placeholder="Search here..."/>
      <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
    </div>
<!--close-top-serch-->
    <!-- END X-NAVIGATION -->
</div>
<!-- END PAGE SIDEBAR -->
