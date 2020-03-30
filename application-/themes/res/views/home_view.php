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

<?php //echo $date = date("Y-m-d", strtotime('2012-01-01'." +2 years"));  ?>
<?php
$SelectRetrait = $this->db->query("SELECT retraite.id_retraite,
                                          DATEDIFF(CURRENT_DATE, retraite.date_naissance_retraite)/365 AS AgeCalcule,
                                          DATE_ADD(retraite.date_naissance_retraite,INTERVAL (parametre.age_retraite_parametre) YEAR) AS DateRetraite,
                                          DATE_SUB( DATE_ADD(retraite.date_naissance_retraite,INTERVAL (parametre.age_retraite_parametre) YEAR),INTERVAL 3 MONTH) AS DateNotification
                                  FROM retraite
                                  JOIN regime ON (regime.id_regime = retraite.id_regime AND regime.deleted_regime = 'N')
                                  JOIN parametre ON (regime.id_regime = parametre.regime AND
                                                     (YEAR(retraite.date_naissance_retraite) BETWEEN SUBSTRING(parametre.condition_parametre,1,4) AND SUBSTRING(parametre.condition_parametre,6,4)) AND
                                                     ((DATEDIFF(CURRENT_DATE, retraite.date_naissance_retraite)/365) >= parametre.age_retraite_parametre))
                                  WHERE retraite.deleted_retraite = 'N' AND
                                        retraite.status_retraite = 'N'");
foreach($SelectRetrait->result() as $rowSelectRetrait){
    $DateRetraite     = $rowSelectRetrait->DateRetraite;
    $Status           = 'E';
    $DateNotification = $rowSelectRetrait->DateNotification;
    $IdRetraite       = $rowSelectRetrait->id_retraite;

    $Etat = "O";
    $UpdateRetraite = $this->db->set('date_depart_retraite', $DateRetraite);
    $UpdateRetraite = $this->db->set('status_retraite'     , $Status);
    $UpdateRetraite = $this->db->set('date_notif_retraite' , $DateNotification);
    $UpdateRetraite = $this->db->where('id_retraite'       , $IdRetraite);
    $UpdateRetraite = $this->db->update('retraite');
}

?>

                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">Accueil</a></li>
                </ul>
                <!-- END BREADCRUMB -->




                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">


<!-- Liste des retraités de l'année courante après 3 mois d'avance -->

<div class="row">
     <div class="col-sm-12 col-md-12 col-xs-12">
       <!--ici-->
       <div class="x_panel">
         <div class="x_title">
         <!-- <a href="#" type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#exampleModal" >Ajouter retraite <i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i></a> -->
         <a href="http://localhost/excel/" type="button" class="btn btn-sm btn-info"  >Ajouter retraite <i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i></a>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
          </ul>
          <div class="clearfix"></div>
        </div>


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


                      <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Option: activate to sort column ascending" style="width: 74px;">Option</th>
                        </tr>
                      </thead>
                      <tbody>

                      <?php
                       $queryDetail = $this->db->query("SELECT *,
                                                               DATEDIFF(CURRENT_DATE, retraite.date_naissance_retraite)/365 AS AgeCalcule,
                                                               DATE_ADD(retraite.date_naissance_retraite,INTERVAL (parametre.age_retraite_parametre) YEAR) AS DateRetraite,
                                                               DATE_SUB( DATE_ADD(retraite.date_naissance_retraite,INTERVAL (parametre.age_retraite_parametre) YEAR),INTERVAL 3 MONTH) AS DateNotification
                                                        FROM retraite
                                                        JOIN cadre on (retraite.id_cadre = cadre.id_cadre AND
                                                                       cadre.deleted_cadre = 'N')
                                                        JOIN regime on (retraite.id_regime = regime.id_regime AND
                                                                        regime.deleted_regime = 'N')
                                                                        JOIN parametre ON (regime.id_regime = parametre.regime AND
                                                                                           (YEAR(retraite.date_naissance_retraite) BETWEEN SUBSTRING(parametre.condition_parametre,1,4) AND SUBSTRING(parametre.condition_parametre,6,4)))
                                                        JOIN retraite.position on (retraite.id_position = position.id_position)
                                                        WHERE retraite.deleted_retraite ='N' AND
                                                              retraite.status_retraite ='N'  AND
                                                              retraite.status_prolongation ='N'");
                       foreach($queryDetail->result() as $rowDetail ){
                        ?>

                      <tr role="row" class="odd">

                        <td class="sorting_1" id="elm_num-<?= $rowDetail->id_retraite ?>"><?= $rowDetail->num_somme_retraite ?></td>
                        <td class="elm_title" id="elm_title-<?= $rowDetail->id_retraite ?>"><?= $rowDetail->nom_retraite ?></td>
                          <td><?= $rowDetail->date_naissance_retraite ?></td>
                          <td><?= $rowDetail->DateRetraite ?></td>
                          <td><?= $rowDetail->libelle_cadre ?></td>
                          <td><?= $rowDetail->libelle_regime ?></td>
                          <td><?= $rowDetail->libelle_position ?></td>

                          <td>
                                <i class="fa fa-trash fa-fw del_elm" id="del-<?= $rowDetail->id_retraite ?>" rel="tooltip" title="" data-original-title="Supprimer" data="<?= $rowDetail->id_retraite ?>" ></i>
                                <a class="item-edit green" href="#" data="<?= $rowDetail->id_retraite ?>"  nom="<?= $rowDetail->nom_retraite ?>"  daten="<?= $rowDetail->date_naissance_retraite ?>"  nums="<?= $rowDetail->num_somme_retraite ?>"   >
                                   <i class="ace-icon fa fa-edit bigger-130"></i>
                                </a>

                                   <i class="fa fa-paypal bigger-130 item-pr green" id="pr-<?= $rowDetail->id_retraite ?>" data="<?= $rowDetail->id_retraite ?>"  cadre="<?= $rowDetail->id_cadre ?>"  nums="<?= $rowDetail->num_somme_retraite ?>"  regime="<?= $rowDetail->id_regime ?>" notif="<?= $rowDetail->date_notif_retraite ?>" departr="<?= $rowDetail->date_depart_retraite ?>" ></i>

                                <a class="item-v green" href="<?=base_url('etablissement/etab/edit/'.$rowDetail->id_retraite)?>" data="<?= $rowDetail->id_retraite ?>" dat="benabbes@gmail.com" >
                                  <i class="fa fa-check-square-o bigger-130"></i>
                                </a>
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


<div class="modal fade" id="modalRet-id" tabindex="-1" role="dialog" aria-labelledby="op_modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
           <div class="op_modal_results"></div>
            <div class="modal-header" style="background:#5bc0de">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h2 class="modal-title" style="color:#fff;font-size:14px;"></h2>
            </div>
            <div class="modal-body">
               <div class="row" >
                    <div id="results_handler1" class="col-sm-6  alert alert-danger hide " style="margin-left:200px;text-align:center;" >
                    <span></span>
                    </div>
                </div>
                <div class="row">
                    <h4 class="op_modal_message col-sm-10 col-sm-offset-1"></h4>
                </div>
               <br/>
              <div class="row" id="nom_prnd" >
                 <input type="text" class="form-control nom_prn" name="nom_prn" id="nom_prn" placeholder="Nom prenom"  />
                 <span></span>
              </div>
              &nbsp;&nbsp;&nbsp;&nbsp;
              <div class="row" id="datenD" >
                 <input type="datetime" class="form-control daten" name="daten" id="daten" placeholder="Date de naissance" class="daten" />
                 <span></span>
              </div>

               <!-- </div>
                <div class="row" style="text-align:center">
                <h4 class="op_modal_message_first col-sm-10 col-sm-offset-1" ></h4>
                <h4 class="op_modal_message_second col-sm-10 col-sm-offset-1" ></h4>
                <h4 class="op_modal_message_thrt col-sm-10 col-sm-offset-1" ></h4>
                <h4 class="op_modal_message_four col-sm-10 col-sm-offset-1" ></h4>
                </div> -->
            </div>
            <div class="modal-footer">


                    <?= form_button('op_modal_close', 'Non', 'data-dismiss="modal" class="btn btn-default" id="op_modal_close2"'); ?>
                    <?= form_button('op_modal_submit', 'Oui', 'id="op_modal_submit2" class="btn btn-info"'); ?>

            </div>
        </div>
    </div>

</div>


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
//prlonger la duree de la retraite
$('.item-pr').on('click',function(e){

  var id = $(this).attr('data');
  $('#modaldel-id').find('.modal-title').text('Prologation:');

  $('#modaldel-id').find('.op_modal_message').text('Veuillez saisir le nombre de fois de prologation');
  //$('#modaldel-id').find('#modal-body').find('#nb_pr').show();
  $('#modaldel-id').modal('show');

});

//prlonger la duree de la retraite
//supprimer retraite

    $('.del_elm').on('click',function(){
         //you have to load the "url_helper" to use this function ?>';
     var id = $(this).attr('data');
     $('#modaldel-id').find('.modal-title').text('Êtes-vous sûr de vouloir supprimer les lignes selectionnées:');
     $('#modaldel-id').find('.op_modal_message').text('');
     $('#modaldel-id').find('.op_modal_message').html('Nom/prenom: ' + $("#elm_title-"+ $(this).attr('data')).html() + ' <br/> numero de somme: ' + $("#elm_num-"+ $(this).attr('data')).html() );
     $('#modaldel-id').find('.nb_pr').hide();
     $('#modaldel-id').modal('show');

     $("#op_modal_close").click(function(){
        window.location.href = base_url;
     });

    // window.location.href = base_url;
     $("#op_modal_submit").click(function(){
     var base_url = '<?php echo base_url(); ?>';

    var results_handlerd = $('#results_handler1');

         $.ajax({
                 type: 'POST',
                  url: base_url + 'accueil/retraite/del',
                  data: {id:id},
                  dataType: "JSON",
                  cache:false,
                  success: function(msg){
                   if(msg.status == '200'){

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




  // valider prolongations

 $('.item-pr').on('click',function(){
      id = $(this).attr('data');
      cadre = $(this).attr('cadre');
      regime = $(this).attr('regime');
      nums   = $(this).attr('nums');
      notif   = $(this).attr('notif');
        departr   = $(this).attr('departr');
    //  alert(cadre);
    $('#modaldel-id').find('.nb_pr').val('');
      //alert(id +' '+'cadre = ' + cadre + 'regime = ' +  regime  +'nums= ' + nums);
      $('#modaldel-id').find('.modal-title').text('Êtes-vous sûr de vouloir supprimer les lignes selectionnées:');

      $('#modaldel-id').find('.op_modal_message').html('Nom/prenom: ' + $("#elm_title-"+ $(this).attr('data')).html() + ' <br/> numero de somme: ' + nums);

    //  $('#modaldel-id').find('.nb_pr').attr('value',nbE);

      $('#modaldel-id').modal('show');



      $("#op_modal_close").click(function(){
         window.location.href = base_url;
      });

     $("#op_modal_submit").click(function(){
    var nbv = $('#modaldel-id').find('.nb_pr').val();
     var base_url = '<?php echo base_url(); ?>';
     var results_handlerd = $('#results_handler');

         $.ajax({
                 type: 'POST',
                  url: base_url + 'accueil/ValiderPrologation/' + nbv,
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


  // valider prolongations

 $('.item-edit').on('click',function(){
   var base_url = '<?php echo base_url(); ?>';
      id = $(this).attr('data');
      nom = $(this).attr('nom');
      daten   = $(this).attr('daten');
    //  alert(cadre);
       $('#modalRet-id').find('.nom_prn').val(nom);
        $('#modalRet-id').find('.daten').val(daten);
      //alert(id +' '+'cadre = ' + cadre + 'regime = ' +  regime  +'nums= ' + nums);
      $('#modalRet-id').find('.modal-title').text('mofocation de la retraite:');

      $('#modalRet-id').modal('show');

       $("#op_modal_close2").click(function(){
         window.location.href = base_url;

     });

     $("#op_modal_submit2").click(function(){

     var base_url = '<?php echo base_url(); ?>';
     var results_handlerd = $('#results_handler');
     var nom_prn=  $('#modalRet-id').find('.nom_prn').val();
     var daten=   $('#modalRet-id').find('.daten').val();
     alert(nom_prn + ' ' + daten);
         $.ajax({
                 type: 'POST',
                  url: base_url + 'accueil/retraite/edit/' + id,
                  data: {id:id,nom_prn:nom_prn,daten:daten},
                  dataType: "JSON",
                  cache:false,
                  success: function(msg){
                    //alert(nbv);
                   if(msg.status == '200'){

                 //form_btn_loadingjs($('#op_modal_submit'));
                 form_show_resultst(results_handlerd, 'info', msg.message, 'true');
                 //showAllUtilisateur();
             setTimeout(function() {$('#modalRet-id').modal('hide');}, 4000);
             window.location.href=base_url + msg.url;
                 }else{
                    form_show_resultst(results_handlerd, 'dangers', msg.message, true);
                    alert('erreur de traitement')
                     window.location.href=base_url + msg.url;
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
