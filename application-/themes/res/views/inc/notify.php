<!-- START X-NAVIGATION VERTICAL -->
<style>
.notify{
  font-size:11px;
}
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/ju/dt-1.10.15/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>

<ul class="x-navigation x-navigation-horizontal x-navigation-panel">
    <!-- TOGGLE NAVIGATION -->
    <li class="xn-icon-button">
        <a href="#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
    </li>
    <!-- END TOGGLE NAVIGATION -->
    <!-- SEARCH -->
    <li class="xn-search">
        <form role="form">
            <input type="text" name="search" placeholder="Chercher..."/>
        </form>
    </li>
    <!-- END SEARCH -->
    <!-- SIGN OUT -->
    <li class="xn-icon-button pull-right">
        <a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span></a>
    </li>
    <!-- END SIGN OUT -->
    <!-- MESSAGES -->

    <?php
    $queryDetailRetrait = $this->db->query("select * from retraite inner join cadre on (retraite.id_cadre = cadre.id_cadre)
inner join regime on (retraite.id_regime = regime.id_regime)
inner join position on (retraite.id_position = position.id_position)
where retraite.deleted_retraite ='N' and DATEDIFF(NOW(),retraite.date_notif_retraite) >= 0 and retraite.status_retraite='N' ");

     $queryDetailRetraits = $this->db->query("select count(*) as nb_ret from retraite where deleted_retraite ='N' and DATEDIFF(NOW(),date_notif_retraite) >= 0 and status_retraite='N' "); ?>
    <li class="xn-icon-button pull-right">
        <a href="#"><span class="fa fa-comments"></span></a>
        <div class="informer informer-danger"><?= $queryDetailRetraits->row()->nb_ret ?></div>
        <div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging">
            <div class="panel-heading">
                <h3 class="panel-title"><span class="fa fa-comments"></span> Retraite en cours</h3>
                <div class="pull-right">
                    <span class="label label-danger"><?= $queryDetailRetraits->row()->nb_ret ?> Active </span>
                </div>
            </div>




            <div class="panel-body list-group list-group-contacts scroll" style="height: 200px;">
<?php    foreach($queryDetailRetrait->result() as $rowDetailre){ ?>
              <a class="list-group-item item-ret" href="#" data="<?php echo $rowDetailre->id_retraite;  ?>">
                  <strong class="notify">Numero de somme:</strong>&nbsp;&nbsp;
                  <span style="font-weight:bold;color:#33FF66;" class="notify"><?php echo $rowDetailre->num_somme_retraite;  ?></span>&nbsp;
                  <strong class="notify">Nom/prenom:</strong>&nbsp;&nbsp;
                  <span style="font-weight:bold;color:#33FF66;" class="notify"><?php echo $rowDetailre->nom_retraite;  ?> </span>
                  <!-- <small class="text-muted"></small> -->
              </a>
  <?php  } ?>
            </div>
            <div class="panel-footer text-center">
                <a href="pages-messages.html">Afficher toutes les retraites en cours</a>
            </div>
        </div>
    </li>
    <!-- END MESSAGES -->
    <!-- TASKS -->
    <?php
     $queryDetail = $this->db->query("select count(*) as 'nb_prol' from retraite inner join prolongation on (retraite.id_prolongation = prolongation.id_prolongation) where retraite.status_prolongation ='E' and retraite.deleted_retraite ='N' ");
     $queryDetails = $this->db->query("select * from retraite inner join prolongation on (retraite.id_prolongation = prolongation.id_prolongation) where retraite.status_prolongation ='E' and retraite.deleted_retraite ='N' ");

      ?>
    <li class="xn-icon-button pull-right">
        <a href="#" title="en cours de prologation"><span class="fa fa-tasks"></span></a>
        <div class="informer informer-warning"><?php echo $queryDetail->row()->nb_prol;  ?></div>
        <div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging">
            <div class="panel-heading">
                <h3 class="panel-title" title="en cours de prologation"><span class="fa fa-tasks"></span> Prologation en cours</h3>
                <div class="pull-right">
                  <!-- select * from retraite inner join prolongation on (retraite.id_prolongation = prolongation.id_prolongation) where retraite.status_prolongation ='E' and retraite.deleted_retraite ='N'; -->

                    <span class="label label-warning">

<!-- select * from retraite inner join prolongation on (retraite.id_prolongation = prolongation.id_prolongation) where retraite.status_prolongation ='E' and retraite.deleted_retraite ='N'; -->
                 <?php  echo $queryDetail->row()->nb_prol;  ?>
              Active
                  </span>
                </div>
            </div>
            <div class="panel-body list-group scroll" style="height: 200px;">
                   <?php
                   foreach($queryDetails->result() as $rowDetails){ ?>
                <a class="list-group-item item-prol" href="#" data="<?php echo $rowDetails->id_retraite;  ?>">
                    <strong class="notify">Numero de somme:</strong>&nbsp;&nbsp;
                    <span style="font-weight:bold;color:#33FF66;" class="notify"><?php echo $rowDetails->num_somme_retraite;  ?></span>&nbsp;
                    <strong class="notify">Nom/prenom:</strong>&nbsp;&nbsp;
                    <span style="font-weight:bold;color:#33FF66;" class="notify"><?php echo $rowDetails->nom_retraite;  ?> </span>
                    <!-- <small class="text-muted"></small> -->
                </a>


              <?php }  ?>

            </div>
            <div class="panel-footer text-center">
                <a href="<?=base_url('prolongation')?>">Afficher tous les prolongations en cours</a>
            </div>
        </div>
    </li>
    <!-- END TASKS -->
</ul>

<!-- END X-NAVIGATION VERTICAL -->



      <!-- MESSAGE BOX-->
      <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
          <div class="mb-container">
              <div class="mb-middle">
                  <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
                  <div class="mb-content">
                      <p>Vous êtes sûr à se deconnecter?</p>
                      <p>Veuillez cliquer appuyer sur Non si vous voulez reculer.</p>
                  </div>
                  <div class="mb-footer">
                      <div class="pull-right">
                          <a href='<?=base_url("connexion/deconnect")?>' class="btn btn-success btn-lg">Oui</a>
                          <button class="btn btn-default btn-lg mb-control-close">Non</button>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <!-- END MESSAGE BOX-->


      <script>
         $(".item-prol").on( "click", function() {

            var base_url = '<?php echo base_url(); ?>';
            var id = $(this).attr('data');
            $.ajax({
                    type: 'POST',
                     url: base_url + 'accueil/notify/up',
                     data: {id:id},
                     dataType: "JSON",
                     cache:false,
                     success: function(msg){

                      if(msg.status == '200'){
                    //form_btn_loadingjs($('#op_modal_submit'));
                  //  alert('1');
                    //showAllUtilisateur();
             window.location.href=base_url + msg.url;
                    }else{
                      alert('00');
                        }
                      },
                     error: function(error){
            //form_show_resultst(results_handlerd, 'danger', 'Erreur de traitement', true);
                     window.location.href=base_url + 'prolongation';
                     }
               });


          });

          $('.item-ret').on( "click", function() {

             var base_url = '<?php echo base_url(); ?>';
             var id = $(this).attr('data');
             $.ajax({
                     type: 'POST',
                      url: base_url + 'accueil/notify/ret',
                      data: {id:id},
                      dataType: "JSON",
                      cache:false,
                      success: function(msg){

                       if(msg.status == '200'){
                     //form_btn_loadingjs($('#op_modal_submit'));
                   //  alert('1');
                     //showAllUtilisateur();
              window.location.href=base_url + msg.url;
                     }else{
                       alert('00');
                         }
                       },
                      error: function(error){
             //form_show_resultst(results_handlerd, 'danger', 'Erreur de traitement', true);
                      window.location.href=base_url + 'accueil';
                      }
                });


           });
      </script>
