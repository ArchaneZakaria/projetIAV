<script src="<?=base_url('assets/js')?>/mainjs.js" ></script>
<style>
   input[type=email], input[type=url], input[type=search],
   input[type=tel], input[type=color],input[type=text],
   input[type=password], input[type=datetime], input[type=datetime-local],
   input[type=date], input[type=month], input[type=time], input[type=week],
   input[type=number], textarea {
    border-radius: 10px!important;
    }
    .leftmenu{
         margin-left:10%;
     }

     .modal-backdrop {
       z-index: -1 !important;
     }

     .del_elm{
       color:#CC0000;
     }
     .item-v{
       color:#5bc0de;
     }

</style>
<link rel="stylesheet" type="text/css" href="<?=base_url('assets') ?>/js/datatables.min.css"/>
<script src="<?=base_url('assets') ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?=base_url('assets') ?>/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?=base_url('assets') ?>/js/dataTables.bootstrap.min.js"></script>




                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">Accueil</a></li>
                </ul>
                <!-- END BREADCRUMB -->




                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">


<!-- Liste des retraités de l'année courante après 3 mois d'avance -->


<?php //echo $date = date("Y-m-d", strtotime('2012-01-01'." +2 years"));
 $access_f = $this->session->user['id_role'];
 ?>
<div class="row">
     <div class="col-sm-12 col-md-12 col-xs-12">
       <!--ici-->
       <div class="x_panel">
         <!-- <div class="x_title">
         <a href="#" type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#exampleModal" >Ajouter retraite <i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i></a>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
          </ul>
          <div class="clearfix"></div>
        </div> -->


         <div class="x_content" style="display: block;">

<!-- Table -->
           <div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
             <div class="row">

            </div>
           <div class="row">
             <div class="col-sm-12">
               <table id="IDexample" class="display responsive nowrap table-bordered" cellspacing="0" width="100%">

                      <tfoot>
                          <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                          </tr>
                      </tfoot>
                      <thead id="data-table">
                        <tr role="row">


                        <th class="sorting_asc" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 187px;">Num de somme</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 307px;">Nom/Prenom</th>
                        <th class="sorting_asc" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 187px;"> Date naissance retraite  </th>
                        <th class="sorting_asc" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 187px;">Date depart retraite</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 307px;">Cadre</th>
                        <th class="sorting_asc" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 187px;"> Regime  </th>

                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 307px;">Position</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 307px;">Nb_mois</th>


                      <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Option: activate to sort column ascending" style="width: 74px;">Option</th>
                        </tr>
                      </thead>
                      <tbody>

                      <?php
                       $queryDetail = $this->db->query("select * from retraite inner join cadre on (retraite.id_cadre = cadre.id_cadre) inner join regime on (retraite.id_regime = regime.id_regime)
                           inner join retraite.position on (retraite.id_position = position.id_position)
                           inner join prolongation on (retraite.id_prolongation = prolongation.id_prolongation)
                           where retraite.deleted_retraite ='N' and retraite.id_prolongation !='0' ");
                       foreach($queryDetail->result() as $rowDetail ){
                        ?>

                      <tr role="row" class="odd">

                          <td class="sorting_1" id="elm_num-<?= $rowDetail->id_retraite ?>"><?= $rowDetail->num_somme_retraite ?></td>
                          <td class="elm_title" id="elm_title-<?= $rowDetail->id_retraite ?>"><?= $rowDetail->nom_retraite ?></td>
                          <td><?= $rowDetail->date_naissance_retraite ?></td>
                          <td><?= $rowDetail->date_depart_retraite ?></td>
                          <td><?= $rowDetail->libelle_cadre ?></td>
                          <td><?= $rowDetail->libelle_regime ?></td>
                          <td><?= $rowDetail->libelle_position ?></td>
                            <td><?= $rowDetail->nbr_prolongation * 2 * 12 + $rowDetail->nb_ms_prolongation ?></td>
                          <td>
<?php if($access_f == '1'){ ?>
                                <i class="fa fa-reply-all fa-fw del_elm" id="del-<?= $rowDetail->id_retraite ?>" rel="tooltip" title="Annuler" data="<?= $rowDetail->id_retraite ?>" data-original-title="Supprimer"></i>
                                <!-- <a class="item-edit green " href="#" data="<?= $rowDetail->id_retraite ?>" dat="benabbes@gmail.com" cadre="<?= $rowDetail->id_cadre ?>"  regime="<?= $rowDetail->id_regime ?>" nbf="<?= $rowDetail->nbf_annee_prolongation ?>" nb="<?= $rowDetail->nbr_prolongation ?>">
                                   <i class="ace-icon fa fa-edit bigger-130"></i>
                                </a> -->

                                <!-- <i class="fa fa-pencil-square-o bigger-130 item-edit green" id="pr-<?= $rowDetail->id_retraite ?>" title="modofier la prolongation" data="<?= $rowDetail->id_retraite ?>"  cadre="<?= $rowDetail->id_cadre ?>"  nums="<?= $rowDetail->num_somme_retraite ?>"  regime="<?= $rowDetail->id_regime ?>" notif="<?= $rowDetail->date_notif_retraite ?>" departr="<?= $rowDetail->date_depart_retraite ?>" ></i> -->

<?php } ?>
                          </td>
                       </tr>
                     <?php } ?>
                        </tbody>
                  </table>
         </div>
       </div>
      </div>
         </div>
       </div>
        <!--ici-->
     </div>
</div>
<!-- page content row -->


<?php if (isset($op_modal)) echo $op_modal; ?>


<!-- Liste des retraités de l'année courante après 3 mois d'avance -->


<script type="text/javascript">
  $(document).ready(function() {
    $('#IDexample').DataTable();
} );
</script>

                </div>
                <!-- END PAGE CONTENT WRAPPER -->


<script>

var base_url = "<?= base_url() ?>";
var prolog = 'prolongation';
$('.item-edit').on('click',function(){
     id = $(this).attr('data');
     cadre = $(this).attr('cadre');
     regime = $(this).attr('regime');
     nums   = $(this).attr('nums');
     notif   = $(this).attr('notif');
     departr   = $(this).attr('departr');
   if(cadre != '1'){
     $('#modaldel-id').find('.nb_ms').hide();
   }
    $('#modaldel-id').find('.nb_ms').val('0');
   $('#modaldel-id').find('.nb_pr').val('0');
     //alert(id +' '+'cadre = ' + cadre + 'regime = ' +  regime  +'nums= ' + nums);
     $('#modaldel-id').find('.modal-title').text('Êtes-vous sûr de vouloir modifier la prologation de la retraite !!:');

     $('#modaldel-id').find('.op_modal_message').html('Nom/prenom: ' + $("#elm_title-"+ $(this).attr('data')).html() + ' <br/> numero de somme: ' + nums);

   //  $('#modaldel-id').find('.nb_pr').attr('value',nbE);

     $('#modaldel-id').modal('show');

     $("#op_modal_close").click(function(){
        window.location.href = base_url;
     });

    $("#op_modal_submit").click(function(){
    var nbv = $('#modaldel-id').find('.nb_pr').val();
    var nbmois = $('#modaldel-id').find('.nb_ms').val();
    var nbm = parseInt(nbv*12)+parseInt(nbmois)
    //alert(nbm);
    var base_url = '<?php echo base_url(); ?>';
    var results_handlerd = $('#results_handler');

        $.ajax({
                type: 'POST',
                 url: base_url + 'accueil/ValiderPrologation/' + nbv + '/' + nbmois ,
                 data: {id:id,id_cadre:cadre,notif:notif,departr:departr},
                 dataType: "JSON",
                 cache:false,
                 success: function(msg){
                   //alert(nbv);
                  if(msg.status == '200'){

                //form_btn_loadingjs($('#op_modal_submit'));
                form_show_resultst(results_handlerd, 'info', msg.message, 'true');
                //showAllUtilisateur();
                setTimeout(function() {$('#modaldel-id').modal('hide');}, 4000);
                window.location.href=base_url + '/prolongation';
                }else{
                   form_show_resultst(results_handlerd, 'dangers', msg.message, true);
                    //window.location.href=base_url + msg.url;
                    }
                  },
                 error: function(error){
        //form_show_resultst(results_handlerd, 'danger', 'Erreur de traitement', true);
                 alert('0');
                 }
           });

   });

 });
 //modifier prolongation
//supprimer retraite

    $('.del_elm').on('click',function(){
         //you have to load the "url_helper" to use this function ?>';
     var id = $(this).attr('data');
     $('#modaldel-id').find('.modal-title').text('Êtes-vous sûr de vouloir annuler la prolongation !!:');

     $('#modaldel-id').find('.op_modal_message').html('Nom/prenom: ' + $("#elm_title-"+ $(this).attr('data')).html() + ' <br/> numero de somme: ' + $("#elm_num-"+ $(this).attr('data')).html() );

     $('#modaldel-id').find('.nb_pr').hide();
     $('#modaldel-id').find('.nb_ms').hide();
     $('#modaldel-id').modal('show');
     //window.location.href = base_url;

     $("#op_modal_close").click(function(){
        window.location.href = base_url + prolog;
     });

     id = $(this).attr('data');
     $("#op_modal_submit").click(function(){
     var base_url = '<?php echo base_url(); ?>';
     var results_handlerd = $('#results_handler');

         $.ajax({
                 type: 'POST',
                  url: base_url + 'prolongation/del',
                  data: {id:id},
                  dataType: "JSON",
                  cache:false,
                  success: function(msg){
                    //alert(id);
                   if(msg.status == '1'){

                 //form_btn_loadingjs($('#op_modal_submit'));
                 form_show_resultst(results_handlerd, 'info', msg.message, 'true');
                 //showAllUtilisateur();


                 setTimeout(function() {$('#modaldel-id').modal('hide');}, 4000);
                 window.location.href=base_url + msg.url;
                 }else{
                    form_show_resultst(results_handlerd, 'danger', msg.message, true);
                     }
                   },
                  error: function(error){
         //form_show_resultst(results_handlerd, 'danger', 'Erreur de traitement', true);
                  alert('0');
                  }
            });
            });
            });
  //supprimer retraite

  // modifier prolongations

 $('.item-edit').on('click',function(){
      id = $(this).attr('data');
      cadre = $(this).attr('cadre');
      regime = $(this).attr('regime');
      nbf = $(this).attr('nbf');
      nbE= $(this).attr('nb');

      if(cadre != '1'){
        $('#modaldel-id').find('.nb_ms').hide();
      }
    //  alert(id + 'cadre = ' + cadre + 'regime = ' +  regime + 'nbf= ' + nbf + 'nbE= ' + nbE);
      $('#modaldel-id').find('.modal-title').text('Êtes-vous sûr de vouloir modifier la prolongation:');

      $('#modaldel-id').find('.op_modal_message').html('Nom/prenom: ' + $("#elm_title-"+ $(this).attr('data')).html() + ' <br/> numero de somme: ' + $("#elm_num-"+ $(this).attr('data')).html() );

      $('#modaldel-id').find('.nb_pr').attr('value',nbE);
      $('#modaldel-id').modal('show');


      $("#op_modal_close").click(function(){
         window.location.href = base_url + prolog;
      });

  $("#op_modal_submit").click(function(){
     var nbv = $('#modaldel-id').find('.nb_pr').val();

     var base_url = '<?php echo base_url(); ?>';
     var results_handlerd = $('#results_handler');

         $.ajax({
                 type: 'POST',
                  url: base_url + 'accueil/modifierPrologation/' + nbv,
                  data: {id:id},
                  dataType: "JSON",
                  cache:false,
                  success: function(msg){
                    //alert(nbv);
                   if(msg.status == '200'){

                 //form_btn_loadingjs($('#op_modal_submit'));
                 form_show_resultst(results_handlerd, 'info', msg.message, 'true');
                 //showAllUtilisateur();
                 setTimeout(function() {$('#modaldel-id').modal('hide');}, 4000);
                 window.location.href=base_url + msg.url;
                 }else{
                    form_show_resultst(results_handlerd, 'dangers', msg.message, true);
                     //window.location.href=base_url + msg.url;
                     }
                   },
                  error: function(error){
         //form_show_resultst(results_handlerd, 'danger', 'Erreur de traitement', true);
                  alert('0');
                  }
            });

    });

  });
  //modifier prolongation
</script>
