<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-sidebar">
  <?php  $acces_f = $this->session->user['id_role']; ?>
    <!-- START X-NAVIGATION -->
    <ul class="x-navigation">
        <li class="xn-logo">
            <a href="<?=base_url()?>">Retraite</a>
            <a href="#" class="x-navigation-control"></a>
        </li>
        <li class="xn-profile">
            <a href="#" class="profile-mini">
                <img src="<?=base_url('assets') ?>/img/users/avatar.jpg" alt="BENABBES Khalid"/>
            </a>
            <div class="profile">
                <div class="profile-image">
                    <img src="<?=base_url('assets') ?>/img/users/avatar.jpg" alt="BENABBES Khalid"/>
                </div>
                <div class="profile-data">
                    <div class="profile-data-name"><?= $this->session->user['data_user'][0]->nom_user;  ?> <?= $this->session->user['data_user'][0]->prenom_user;  ?></div>
                    <div class="profile-data-title"><?= $this->session->user['data_user'][0]->grade_user;  ?></div>
                </div>
                <div class="profile-controls">
                    <a href="#" class="profile-control-left"><span class="fa fa-info"></span></a>
                    <a href="pages-messages.html" class="profile-control-right"><span class="fa fa-envelope"></span></a>
                </div>
            </div>
        </li>
        <li class="xn-title">Navigation</li>



        <li class="active">
            <a href="<?= base_url()?>"><span class="fa fa-desktop"></span> <span class="xn-text">Accueil</span></a>
        </li>

        <?php  $acces_f = 1; if($acces_f == '1' || $acces_f == '2' || $acces_f == '3'){ ?>
        <li class="xn-openable">
            <a href="<?= base_url() ?>pages/page/ressources-humaines"><span class="fa fa-files-o"></span> <span class="xn-text">Retraite</span></a>
            <ul>
               <li>
                  <a href="#"><span class="fa fa-arrows"></span> Ajouter </a>
               </li>
                <li>
                  <a href="<?= base_url('accueil/encours')?>"><span class="fa fa-arrows"></span>  Encours de validation </a>
                  <a href="<?= base_url('accueil/valider')?>"><span class="fa fa-arrows"></span>  Retraité </a>
                </li>
              </ul>
          </li>


          <li>
              <a href="<?= base_url() ?>pages/page/ressources-humaines"><span class="fa fa-pencil fa-fw"></span> Retraite Validée </a>
          </li>

          <li>
              <a href="<?= base_url('prolongation') ?>"><span class="fa fa-pencil fa-fw"></span> Prolongation </a>
          </li>
<?php }  ?>
<?php  if($acces_f == '1'){ ?>
          <li>
              <a href="<?= base_url() ?>pages/page/ressources-humaines"><span class="fa fa-list"></span> Statistique </a>
          </li>
<?php  }   ?>

</ul>

    <!-- END X-NAVIGATION -->
</div>
<!-- END PAGE SIDEBAR -->
