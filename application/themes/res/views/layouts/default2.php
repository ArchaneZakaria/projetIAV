<!DOCTYPE html>
<html lang="en">
<head>
<title>Matrix Admin</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap-responsive.min.css') ?>" >
        <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>" >
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= base_url('assets/css/uniform.css')?>" >
        <link rel="stylesheet" href="<?= base_url('assets/css/select2.css') ?>" >
        <link rel="stylesheet" href="<?= base_url('assets/css/matrix-style.css') ?>" >
        <link rel="stylesheet" href="<?= base_url('assets/css/matrix-media.css') ?>" >
        <link rel="stylesheet" href="<?= base_url('assets/css/datepicker.css') ?>" >
        <link href="<?= base_url('assets/font-awesome/css/font-awesome.css') ?>" rel="stylesheet" />
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


<script>
            var base_url = '<?= base_url() ?>';
            var site_url = '<?= site_url() ?>';
</script>

 <?php if (isset($template['metadata'])) echo $template['metadata']; ?>
</head>
<body style="margin-top: -20px;">
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
  <h2 class="logo" style="padding-top:5px;"><a href="dashboard.html" style="color:#23b256;"><i class=" icon-group" aria-hidden="true"></i>
  SuiviMB</a></h2>
  </div>
  <!--close-Header-part-->


      <!--top-Header-menu-->
      <!--top-Header-menu-->
      <div id="user-nav" style="margin-top:0px;">
        <ul class="nav">

          <li  class="dropdown" id="profile-phase" ><a title="" href="#" data-toggle="dropdown" data-target="#profile-profile-phase" class="dropdown-toggle"><i class="icon icon-user"></i>  <span class="text">Phase</span><b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="creerphase.html"><i class="icon-user"></i> Creation</a></li>
              <li class="divider"></li>

              <li class="dropdown-submenu">
             <a class="test" tabindex="-1" href="#"><i class="icon-check"></i>Liste</a>
             <ul class="dropdown-menu">
               <li><a tabindex="-1" href="listephasebc.html">Bon de comande</a></li>
               <li><a tabindex="-1" href="listephasemt.html">Marché travaux</a></li>
               <li><a tabindex="-1" href="listephasemf.html">Marché fourniture</a></li>
             </ul>
           </li>

            </ul>
          </li>

          <li  class="dropdown" id="profile-messages" ><a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle"><i class="icon icon-user"></i>  <span class="text">Bon de commande</span><b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="creerboncommande.html"><i class="icon-user"></i> créer</a></li>
              <li class="divider"></li>
              <li><a href="bondecommandeencours.html"><i class="icon-check"></i> Bons de commande en cours </a></li>
              <li class="divider"></li>
              <li><a href="Bonsdecommandevalides.html"><i class="icon-key"></i> Bons de commande  validés</a></li>
              <li><a href="Bonsdecommandereceptionnes.html"><i class="icon-key"></i> Bons de commande réceptionnés</a></li>
              <li><a href="bondecommandeannules.html"><i class="icon-key"></i> Bons de commande annulés</a></li>
            </ul>
          </li>

          <li  class="dropdown" id="profile-marche" ><a title="" href="#" data-toggle="dropdown" data-target="#profile-marche" class="dropdown-toggle"><i class="icon icon-user"></i>  <span class="text">Marché</span><b class="caret"></b></a>
              <ul class="dropdown-menu">
                  <li class="dropdown-submenu">
                      <a class="test" tabindex="-1" href="#"><i class="icon-check"></i>Marché travaux</a>
                      <ul class="dropdown-menu">
                          <li><a href="creermarchetravaux.html"><i class="icon-user"></i> créer</a></li>
                          <li class="divider"></li>
                          <li><a href="MarcheTravauxEncours.html"><i class="icon-check"></i> Marché travaux en cours </a></li>
                          <li class="divider"></li>
                          <li><a href="MarcheTravauxValides.html"><i class="icon-key"></i> Marché travaux  validés</a></li>
                          <li><a href="MarcheTravauxReceptionnes.html"><i class="icon-key"></i> Marché travaux réceptionnés</a></li>
                          <li><a href="MarcheTravauxAnnules.html"><i class="icon-key"></i> Marché travaux annulés</a></li>
                      </ul>
                  </li>
                  <li class="divider"></li>
                  <li class="dropdown-submenu">
                      <a class="test" tabindex="-1" href="#"><i class="icon-check"></i>Marché fourniture</a>
                      <ul class="dropdown-menu">
                      <li><a href="creermarchefourniture.html"><i class="icon-user"></i> créer</a></li>
                      <li class="divider"></li>
                      <li><a href="MarcheFournitureEncours.html"><i class="icon-check"></i> Marché fourniture en cours </a></li>
                      <li class="divider"></li>
                      <li><a href="MarcheFournitureValides.html"><i class="icon-key"></i> Marché fourniture  validés</a></li>
                      <li><a href="MarcheFournitureReceptionnes.html"><i class="icon-key"></i> Marché fourniture réceptionnés</a></li>
                      <li><a href="MarcheFournitureAnnules.html"><i class="icon-key"></i> Marché fourniture annulés</a></li>
                     </ul>
                  </li>
                  <li class="divider"></li>
              </ul>
          </li>


        <li class="dropdown" id="menu-fournisseur"><a href="#" data-toggle="dropdown" data-target="#menu-fournisseur" class="dropdown-toggle"><i class="icon icon-envelope"></i> <span class="text">Prestataire</span> <span class="label label-important">5</span> <b class="caret"></b></a>
          <ul class="dropdown-menu">
              <li><a class="sAdd" title="" href="DomaineActiviter.html"><i class="icon-plus"></i> Domaine d'activité</a></li>
            <li class="divider"></li>
            <li><a class="sInbox" title="" href="CreationPrestataire.html"><i class="icon-envelope"></i> Création préstataire</a></li>
            <li class="divider"></li>
            <li><a class="sOutbox" title="" href="listeprestataire.html"><i class="icon-arrow-up"></i> Liste préstataire</a></li>
            <li class="divider"></li>
          </ul>
        </li>

        <li class=""><a title="" href="#"><i class="icon-bar-chart"></i> <span class="text">Statistique</span></a></li>
        <li class=""><a title="" href="Exercice.html"><i class="icon icon-cog"></i> <span class="text">Exercice</span></a></li>


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
        </ul>
      </div>
      <!--close-top-Header-menu-->
      <!--start-top-serch-->
      <div id="search">
        <input type="text" placeholder="Search here..."/>
        <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
      </div>
  <!--close-top-serch-->
  <!--sidebar-menu-->
  <!-- <div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
    <ul>
      <li class="active"><a href="index.html"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
      <li> <a href="charts.html"><i class="icon icon-signal"></i> <span>Charts &amp; graphs</span></a> </li>
      <li> <a href="widgets.html"><i class="icon icon-inbox"></i> <span>Widgets</span></a> </li>
      <li><a href="tables.html"><i class="icon icon-th"></i> <span>Tables</span></a></li>
      <li><a href="grid.html"><i class="icon icon-fullscreen"></i> <span>Full width</span></a></li>
      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Forms</span> <span class="label label-important">3</span></a>
        <ul>
          <li><a href="form-common.html">Basic Form</a></li>
          <li><a href="form-validation.html">Form with Validation</a></li>
          <li><a href="form-wizard.html">Form with Wizard</a></li>
        </ul>
      </li>
      <li><a href="buttons.html"><i class="icon icon-tint"></i> <span>Buttons &amp; icons</span></a></li>
      <li><a href="interface.html"><i class="icon icon-pencil"></i> <span>Eelements</span></a></li>
      <li class="submenu"> <a href="#"><i class="icon icon-file"></i> <span>Addons</span> <span class="label label-important">5</span></a>
        <ul>
          <li><a href="index2.html">Dashboard2</a></li>
          <li><a href="gallery.html">Gallery</a></li>
          <li><a href="calendar.html">Calendar</a></li>
          <li><a href="invoice.html">Invoice</a></li>
          <li><a href="chat.html">Chat option</a></li>
        </ul>
      </li>
      <li class="submenu"> <a href="#"><i class="icon icon-info-sign"></i> <span>Error</span> <span class="label label-important">4</span></a>
        <ul>
          <li><a href="error403.html">Error 403</a></li>
          <li><a href="error404.html">Error 404</a></li>
          <li><a href="error405.html">Error 405</a></li>
          <li><a href="error500.html">Error 500</a></li>
        </ul>
      </li>
      <li class="content"> <span>Monthly Bandwidth Transfer</span>
        <div class="progress progress-mini progress-danger active progress-striped">
          <div style="width: 77%;" class="bar"></div>
        </div>
        <span class="percent">77%</span>
        <div class="stat">21419.94 / 14000 MB</div>
      </li>
      <li class="content"> <span>Disk Space Usage</span>
        <div class="progress progress-mini active progress-striped">
          <div style="width: 87%;" class="bar"></div>
        </div>
        <span class="percent">87%</span>
        <div class="stat">604.44 / 4000 MB</div>
      </li>
    </ul>
  </div> -->
  <!--sidebar-menu-->

  <!--main-container-part-->
  <div id="content" style="margin-left:0;">
  <!--breadcrumbs-->
    <div id="content-header">
      <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a></div>
    </div>
  <!--End-breadcrumbs-->

  <!--Action boxes-->
    <div class="container-fluid">
      <div class="quick-actions_homepage">
        <ul class="quick-actions">
          <li class="bg_lb"> <a href="index.html"> <i class="icon-dashboard"></i> <span class="label label-important">20</span> Marché en cours </a> </li>
          <li class="bg_lg span3"> <a href="charts.html"> <i class=" icon-bolt"></i>Marché validé</a> </li>
          <li class="bg_ly"> <a href="widgets.html"> <i class="icon-warning-sign"></i><span class="label label-success">101</span>Marché annulé</a> </li>
          <li class="bg_lo"> <a href="tables.html"> <i class="icon-truck"></i>  Marché infractueux </a> </li>
          <li class="bg_ls"> <a href="grid.html"> <i class=" icon-leaf"></i>  Marché réceptionné</a> </li>


        </ul>
      </div>


  <!--End-Action boxes-->

  <!--Chart-box-->
      <div class="row-fluid">
        <div class="widget-box">
          <div class="widget-title bg_lg"><span class="icon"><i class="icon-signal"></i></span>
            <h5>Site Analytics</h5>
          </div>
          <div class="widget-content" >
            <div class="row-fluid">
              <div class="span9">
                <div class="chart"></div>
              </div>
              <div class="span3">
                <ul class="site-stats">
                  <li class="bg_lh"><i class="icon-user"></i> <strong>2540</strong> <small>Total Users</small></li>
                  <li class="bg_lh"><i class="icon-plus"></i> <strong>120</strong> <small>New Users </small></li>
                  <li class="bg_lh"><i class="icon-shopping-cart"></i> <strong>656</strong> <small>Total Shop</small></li>
                  <li class="bg_lh"><i class="icon-tag"></i> <strong>9540</strong> <small>Total Orders</small></li>
                  <li class="bg_lh"><i class="icon-repeat"></i> <strong>10</strong> <small>Pending Orders</small></li>
                  <li class="bg_lh"><i class="icon-globe"></i> <strong>8540</strong> <small>Online Orders</small></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>





          <div class="row-fluid">
            <div class="span6">
              <div class="widget-box">
                <div class="widget-title"><span class="icon"><i class="icon-file"></i></span>
                  <h5>Derniers offres de marché </h5>
                </div>
                <div class="widget-content nopadding">
                  <ul class="recent-posts">
                    <li>
                      <div class="user-thumb"> <img width="40" height="40" alt="User" src="img/demo/av1.jpg"> </div>
                      <div class="article-post"> <span class="user-info"> By: john Deo / Date: 2 Aug 2012 / Time:09:27 AM </span>
                        <p><a href="#">This is a much longer one that will go on for a few lines.It has multiple paragraphs and is full of waffle to pad out the comment.</a> </p>
                      </div>
                    </li>
                    <li>
                      <div class="user-thumb"> <img width="40" height="40" alt="User" src="img/demo/av2.jpg"> </div>
                      <div class="article-post"> <span class="user-info"> By: john Deo / Date: 2 Aug 2012 / Time:09:27 AM </span>
                        <p><a href="#">This is a much longer one that will go on for a few lines.It has multiple paragraphs and is full of waffle to pad out the comment.</a> </p>
                      </div>
                    </li>
                    <li>
                      <div class="user-thumb"> <img width="40" height="40" alt="User" src="img/demo/av4.jpg"> </div>
                      <div class="article-post"> <span class="user-info"> By: john Deo / Date: 2 Aug 2012 / Time:09:27 AM </span>
                        <p><a href="#">This is a much longer one that will go on for a few lines.Itaffle to pad out the comment.</a> </p>
                      </div>
                    <li>
                      <button class="btn btn-warning btn-mini">View All</button>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="span6">
              <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-refresh"></i> </span>
                  <h5>Derniers offres de bon de commande</h5>
                </div>
                <div class="widget-content nopadding updates">
                  <div class="new-update clearfix"><i class="icon-ok-sign"></i>
                    <div class="update-done"><a title="" href="#"><strong>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</strong></a> <span>dolor sit amet, consectetur adipiscing eli</span> </div>
                    <div class="update-date"><span class="update-day">20</span>jan</div>
                  </div>
                  <div class="new-update clearfix"> <i class="icon-gift"></i> <span class="update-notice"> <a title="" href="#"><strong>Congratulation Maruti, Happy Birthday </strong></a> <span>many many happy returns of the day</span> </span> <span class="update-date"><span class="update-day">11</span>jan</span> </div>
                  <div class="new-update clearfix"> <i class="icon-move"></i> <span class="update-alert"> <a title="" href="#"><strong>Maruti is a Responsive Admin theme</strong></a> <span>But already everything was solved. It will ...</span> </span> <span class="update-date"><span class="update-day">07</span>Jan</span> </div>
                  <div class="new-update clearfix"> <i class="icon-leaf"></i> <span class="update-done"> <a title="" href="#"><strong>Envato approved Maruti Admin template</strong></a> <span>i am very happy to approved by TF</span> </span> <span class="update-date"><span class="update-day">05</span>jan</span> </div>
                  <div class="new-update clearfix"> <i class="icon-question-sign"></i> <span class="update-notice"> <a title="" href="#"><strong>I am alwayse here if you have any question</strong></a> <span>we glad that you choose our template</span> </span> <span class="update-date"><span class="update-day">01</span>jan</span> </div>
                </div>
              </div>
            </div>
          </div>
          <hr>


  <!--End-Chart-box-->
  </div>
  </div>

  <!--end-main-container-part-->

  <!--Footer-part-->

  <div class="row-fluid">
    <div id="footer" class="span12"> 2020 &copy; Tous droits réservés <a href="http://themedesigner.in"> IAV HASSAN II </a> </div>
  </div>

  <!--end-Footer-part-->


<!--Footer-part-->


<!--end-Footer-part-->

<script src="<?=base_url('assets/js/excanvas.min.js') ?>"></script>
<script src="<?=base_url('assets/js/jquery.min.js') ?>"></script>
<script src="<?=base_url('assets/js/jquery.ui.custom.js') ?>"></script>
<script src="<?=base_url('assets/js/bootstrap.min.js') ?>"></script>
<script src="<?=base_url('assets/js/jquery.flot.min.js') ?>"></script>
<script src="<?=base_url('assets/js/jquery.flot.resize.min.js') ?>"></script>
<script src="<?=base_url('assets/js/jquery.peity.min.js') ?>"></script>
<script src="<?=base_url('assets/js/fullcalendar.min.js') ?>"></script>
<script src="<?=base_url('assets/js/matrix.js') ?>"></script>
<script src="<?=base_url('assets/js/matrix.dashboard.js') ?>"></script>
<script src="<?=base_url('assets/js/jquery.gritter.min.js') ?>"></script>
<script src="<?=base_url('assets/js/matrix.interface.js') ?>"></script>
<script src="<?=base_url('assets/js/matrix.chat.js') ?>"></script>
<script src="<?=base_url('assets/js/jquery.validate.js') ?>"></script>
<script src="<?=base_url('assets/js/matrix.form_validation.js') ?>"></script>
<script src="<?=base_url('assets/js/jquery.wizard.js') ?>"></script>
<script src="<?=base_url('assets/js/jquery.uniform.js') ?>"></script>
<script src="<?=base_url('assets/js/select2.min.js') ?>"></script>
<script src="<?=base_url('assets/js/matrix.popover.js') ?>"></script>
<script src="<?=base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?=base_url('assets/js/matrix.tables.js') ?>"></script>

<script type="text/javascript">
  // This function is called from the pop-up menus to transfer to
  // a different page. Ignore if the value returned is a null string:
  function goPage (newURL) {

      // if url is empty, skip the menu dividers and reset the menu selection to default
      if (newURL != "") {

          // if url is "-", it is this page -- reset the menu:
          if (newURL == "-" ) {
              resetMenu();
          }
          // else, send page to designated URL
          else {
            document.location.href = newURL;
          }
      }
  }

// resets the menu selection upon entry to this page:
function resetMenu() {
   document.gomenu.selector.selectedIndex = 2;
}



/*** sous menu **/
$(document).ready(function(){
  $('.dropdown-submenu a.test').on("click", function(e){
    $(this).next('ul').toggle();
    e.stopPropagation();
    e.preventDefault();
  });
});

/*** sous menu **/
</script>







</body>
</html>
