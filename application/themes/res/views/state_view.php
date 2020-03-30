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

   #bar-chart{
     min-height: 250px;
   }

</style>
<script src="<?=base_url('assets/js')?>/mainjs.js" ></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/ju/dt-1.10.15/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>

  <?php  $acces_f = $this->session->user['id_role']; ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">Statistique</a></li>
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

           <?php  if($acces_f == '1'){ ?>
           <a href="http://localhost/excel/" type="button" class="btn btn-sm btn-info"  >Ajouter retraite <i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i></a>
         <?php } ?>
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

    <?php
          $queryDetailE =  $this->db->query("SELECT
                                  			YEAR(DATE_ADD(retraite.date_naissance_retraite,INTERVAL (parametre.age_retraite_parametre) YEAR))  AS DateRetraite,

                                  			count(retraite.id_retraite) as nb_ret
                                  FROM retraite
                                  JOIN cadre on (retraite.id_cadre = cadre.id_cadre AND
                                  cadre.deleted_cadre = 'N')
                                  JOIN regime on (retraite.id_regime = regime.id_regime AND
                                  regime.deleted_regime = 'N')
                                  JOIN parametre ON (regime.id_regime = parametre.regime AND
                                  cadre.id_cadre = parametre.cadre AND
                                               (YEAR(retraite.date_naissance_retraite) BETWEEN SUBSTRING(parametre.condition_parametre,1,4) AND SUBSTRING(parametre.condition_parametre,6,4)))
                                  JOIN retraite.position on (retraite.id_position = position.id_position)
                                  WHERE retraite.deleted_retraite ='N' AND
                                  			retraite.status_retraite ='E'
                                  Group by DateRetraite");

              $queryDetailN=  $this->db->query("SELECT
                                      			YEAR(DATE_ADD(retraite.date_naissance_retraite,INTERVAL (parametre.age_retraite_parametre) YEAR))  AS DateRetraite,

                                      			count(retraite.id_retraite) as nb_ret
                                      FROM retraite
                                      JOIN cadre on (retraite.id_cadre = cadre.id_cadre AND
                                      cadre.deleted_cadre = 'N')
                                      JOIN regime on (retraite.id_regime = regime.id_regime AND
                                      regime.deleted_regime = 'N')
                                      JOIN parametre ON (regime.id_regime = parametre.regime AND
                                      cadre.id_cadre = parametre.cadre AND
                                                   (YEAR(retraite.date_naissance_retraite) BETWEEN SUBSTRING(parametre.condition_parametre,1,4) AND SUBSTRING(parametre.condition_parametre,6,4)))
                                      JOIN retraite.position on (retraite.id_position = position.id_position)
                                      WHERE retraite.deleted_retraite ='N' AND
                                      			retraite.status_retraite ='N'
                                      Group by DateRetraite");



                $queryDetailV=  $this->db->query("SELECT
                                              YEAR(DATE_ADD(retraite.date_naissance_retraite,INTERVAL (parametre.age_retraite_parametre) YEAR))  AS DateRetraite,

                                              count(retraite.id_retraite) as nb_ret
                                        FROM retraite
                                        JOIN cadre on (retraite.id_cadre = cadre.id_cadre AND
                                        cadre.deleted_cadre = 'N')
                                        JOIN regime on (retraite.id_regime = regime.id_regime AND
                                        regime.deleted_regime = 'N')
                                        JOIN parametre ON (regime.id_regime = parametre.regime AND
                                        cadre.id_cadre = parametre.cadre AND
                                                     (YEAR(retraite.date_naissance_retraite) BETWEEN SUBSTRING(parametre.condition_parametre,1,4) AND SUBSTRING(parametre.condition_parametre,6,4)))
                                        JOIN retraite.position on (retraite.id_position = position.id_position)
                                        WHERE retraite.deleted_retraite ='N' AND
                                              retraite.status_retraite ='V'
                                        Group by DateRetraite");

          $queryDetailAT = $this->db->query("SELECT cadre.id_cadre,cadre.libelle_cadre,YEAR(DATE_ADD(retraite.date_naissance_retraite,INTERVAL (parametre.age_retraite_parametre) YEAR))  AS DateRetraite,

                                  			count(retraite.id_retraite) as nb_ret
                                  FROM retraite
                                  JOIN cadre on (retraite.id_cadre = cadre.id_cadre AND
                                  cadre.deleted_cadre = 'N')
                                  JOIN regime on (retraite.id_regime = regime.id_regime AND
                                  regime.deleted_regime = 'N')
                                  JOIN parametre ON (regime.id_regime = parametre.regime AND
                                  cadre.id_cadre = parametre.cadre AND
                                               (YEAR(retraite.date_naissance_retraite) BETWEEN SUBSTRING(parametre.condition_parametre,1,4) AND SUBSTRING(parametre.condition_parametre,6,4)))
                                  JOIN retraite.position on (retraite.id_position = position.id_position)
                                  WHERE retraite.deleted_retraite ='N' AND
                                  			retraite.status_retraite ='E'

                                  Group by DateRetraite,cadre.id_cadre ");






$chart_datasE = '';
foreach($queryDetailE->result() as $rowDetail ){



$chart_datasE .= "{ year:'".$rowDetail->DateRetraite ."', value:".$rowDetail->nb_ret ."}, ";
}

   $Chart_dataE = substr($chart_datasE, 0, -2);


   // ============================================= Non valide ===============

   $chart_datasN = '';
   foreach($queryDetailN->result() as $rowDetailN ){



   $chart_datasN .= "{ year:'".$rowDetailN->DateRetraite ."', value:".$rowDetailN->nb_ret ."}, ";
   }

      $Chart_dataN = substr($chart_datasN, 0, -2);
/** ============================================= Non valide ===============  **/


/*** ============================================= valide ===============  ***/
$chart_datasV = '';
foreach($queryDetailV->result() as $rowDetailV ){

$chart_datasV .= "{ year:'".$rowDetailV->DateRetraite ."', value:".$rowDetailV->nb_ret ."}, ";
}

   $Chart_dataV = substr($chart_datasV, 0, -2);



/**  ============================================= valide ===============  **/




// ==================================== AT =====================================

$chart_datasAT = '';
foreach($queryDetailAT->result() as $rowDetaiAT ){
$dateRetraite = $rowDetaiAT->DateRetraite;


  $queryDetailATDate = $this->db->query("SELECT cadre.id_cadre,cadre.libelle_cadre,YEAR(DATE_ADD(retraite.date_naissance_retraite,INTERVAL (parametre.age_retraite_parametre) YEAR))  AS DateRetraite,

                                  			count(retraite.id_retraite) as nb_ret
                                  FROM retraite
                                  JOIN cadre on (retraite.id_cadre = cadre.id_cadre AND
                                  cadre.deleted_cadre = 'N')
                                  JOIN regime on (retraite.id_regime = regime.id_regime AND
                                  regime.deleted_regime = 'N')
                                  JOIN parametre ON (regime.id_regime = parametre.regime AND
                                  cadre.id_cadre = parametre.cadre AND
                                               (YEAR(retraite.date_naissance_retraite) BETWEEN SUBSTRING(parametre.condition_parametre,1,4) AND SUBSTRING(parametre.condition_parametre,6,4)))
                                  JOIN retraite.position on (retraite.id_position = position.id_position)
                                  WHERE retraite.deleted_retraite ='N' AND
                                  			retraite.status_retraite ='E'

                                  Group by DateRetraite,cadre.id_cadre
                                  having DateRetraite = '" . $dateRetraite . "'");
                                  //echo $dateRetraite;
$AT = 0;
$ENS = 0;
foreach($queryDetailATDate->result() as $resultByDate){

  switch($resultByDate->id_cadre){
    case '1':
    $ENS = $resultByDate->nb_ret;
    continue;
    case '2':
    $AT = $resultByDate->nb_ret;
    continue;
  }
}
$chart_datasAT .= "{ y:'".$rowDetaiAT->DateRetraite ."', a:". $AT . ",b:" . $ENS . "}, ";
}

$Chart_dataAT = substr($chart_datasAT, 0, -2);
// ==================================== AT ================================= //
    ?>


    <div class="container" style="width:90%;">
   <h2 align="center">Nombre des retraités non validées par année </h2>

   <br /><br />

   <div id="chartN" style="height: 250px;"></div>
  </div>

<br/><br/>
<div class="row">
  <div class="col-md-6 col-sm-6">
  <h2 align="center">Nombre des retraités en cours par année </h2>

  <br /><br />

  <div id="chartE" style="height: 250px;"></div>
  </div>

  <div class="col-md-6 col-sm-6">
  <h2 align="center">Nombre des retraités validées par année </h2>

  <br /><br />

  <div id="chartV" style="height: 250px;"></div>
  </div>
<div>
  <div  class="col-sm-12">
     <h2 align="center">Nombre des retraités par cadre </h2>
    <div id="bar-chart" ></div>
  </div>





<script>

var data = [<?= $chart_datasAT ?>],
    config = {
      data: data,
      xkey: 'y',
      ykeys: ['a', 'b'],
      labels: ['AT', 'ENS'],
      fillOpacity: 0.6,
      hideHover: 'auto',
      behaveLikeLine: true,
      resize: true,
      pointFillColors:['#CC0033'],
      pointStrokeColors: ['black'],
      lineColors:['#CC0033','red']
  };

config.element = 'bar-chart';
Morris.Bar(config);
Morris.Donut({
  element: 'pie-chart',
  data: [
    {label: "Friends", value: 30},
    {label: "Allies", value: 15},
    {label: "Enemies", value: 45},
    {label: "Neutral", value: 10}
  ]
});
</script>

<script>
new Morris.Line({
  // ID of the element in which to draw the chart.
  element: 'chartN',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
data:[<?= $Chart_dataN ?>],
  // The name of the data record attribute that contains x-values.
  xkey: 'year',
  // A list of names of data record attributes that contain y-values.
  ykeys: ['value'],
  // Labels for the ykeys -- will be displayed when you hover over the
  // chart.
  labels: ['nb des retraités']
});

// =================== en cours ====


new Morris.Line({
  // ID of the element in which to draw the chart.
  element: 'chartE',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
data:[<?= $Chart_dataE ?>],
  // The name of the data record attribute that contains x-values.
  xkey: 'year',
  // A list of names of data record attributes that contain y-values.
  ykeys: ['value'],
  // Labels for the ykeys -- will be displayed when you hover over the
  // chart.
  labels: ['nb des retraités']
});
// =================== en cours ================
// =================== validées ================
new Morris.Line({
  // ID of the element in which to draw the chart.
  element: 'chartV',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
data:[<?= $Chart_dataV ?>],
  // The name of the data record attribute that contains x-values.
  xkey: 'year',
  // A list of names of data record attributes that contain y-values.
  ykeys: ['value'],
  // Labels for the ykeys -- will be displayed when you hover over the
  // chart.
  labels: ['nb des retraités']
});

// =================== validées ================
</script>


          </div>
       </div>
      </div>
         </div>
       </div>
        <!--ici-->
     </div>
</div>
<!-- page content row -->


<div class="modal fade" id="modaldel-id" tabindex="-1" role="dialog" aria-labelledby="op_modal" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
   <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h3 class="modal-title" style="color:#242424;font-size:12px;"></h3>
   </div>
   <div class="modal-body">
       <div class="row">
<div id="op_modal_results" class="col-sm-10 col-sm-offset-1 alert alert-danger hide" style="color:#242424;font-size:12px;" ><span></span></div>
       </div>
       <div class="row">
           <h4 class="op_modal_message col-sm-10 col-sm-offset-1" ></h4>
       </div>
   </div>
   <div class="modal-footer">
       <?= form_button('op_modal_closet', 'Non', 'data-dismiss="modal" class="btn btn-default" id="op_modal_closet"'); ?>
       <?= form_button('op_modal_submitt', 'Oui', 'id="op_modal_submitt" class="btn btn-info"'); ?>
   </div>
</div>
</div>
</div>



<?php if (isset($op_modal)) echo $op_modal; ?>




<!-- Liste des retraités de l'année courante après 3 mois d'avance -->





<script type="text/javascript">
  $(document).ready(function() {
    $('#IDexample').DataTable();
    $('#IDexample tbody tr').each(function(){
      $(this).find('td:last').find('a').click(function(){
        var ID      = $(this).attr("id");
        var TypeDoc = $(this).attr("name");
        var Title = $(this).attr("tit");

        $("#TitreModal_modal").html(Title);

          $.ajax({
            type: 'POST',
            url: base_url + 'accueil/verifierValidation',
            data: {ID  :ID, TypeDoc: TypeDoc},
            cache:false,
            async:false,
            success: function(msg){
              $("#CoreHtml").html(msg);
              $("#IdRetraite").val(ID);
              $("#TypeDocument").val(TypeDoc);
              $("#exampleModal").show();

              $("#file-simple").on('change',function(){
                readImage($(this)).done(function(base64Data){

                  $("#preview-picture").attr('src', base64Data);
                  $("#FileBlob").val(base64Data);
                  $(".file-preview").css("display", "block");
                });
              });

              $("#removepreview-thumb").on('click',function(){
                  $("#preview-picture").removeAttr('src');
                  $("#preview-picture").attr('src', "=");
                  $("#FileBlob").val('');
              });
            },
            error: function(msg){
              alert('error');
            }
        });
      });
    });

    $("#SaveValidation").click(function(){
      var ID = $("#IdRetraite").val();
      var TypeDoc = $("#TypeDocument").val();
      var input = $("#ModalForm input:checkbox");

      if(input.filter(':not(:disabled)').filter(':checked').length == 0){
        alert("Veuillez selectionnez une validation.");
        return false;
      }

      var sList = "";
      $('#ModalForm  input[type=checkbox]').each(function () {
          var sThisVal = (this.checked ? "1" : "0");
          var sThisId  = (this.checked ? this.id : this.id);
          sList += (sList=="" ? sThisId+"=" + sThisVal : "&"+sThisId+"=" + sThisVal);
      });

      $.ajax({
          type: 'POST',
          url: base_url + 'accueil/insertValidation',
          data: {ID  :ID, TypeDoc: TypeDoc, listCheck:sList},
          success: function(msg){
            if(msg == 1){
              window.location.reload();
            }
          },
          error: function(msg){
            alert('error');
          }
      });
    });

    $("#SaveUpload").click(function(){
      var ID       = $("#IdRetraite").val();
      var TypeDoc  = $("#TypeDocument").val();
      var FileBlob = $("#FileBlob").val();

      if(FileBlob == ""){
        alert("Veuillez selectionnez le fichier.");
        return false;
      }

      $.ajax({
          type: 'POST',
          url: base_url + 'accueil/retraiteValidation',
          data: {ID  :ID, TypeDoc : TypeDoc, FileBlob:FileBlob},
          success: function(msg){
            if(msg == 1){
              window.location.reload();
            }
          },
          error: function(msg){
            alert('error');
          }
      });
    });

    function readImage(inputElement) {
        var deferred = $.Deferred();

        var files = inputElement.get(0).files;
        if (files && files[0]) {
            var fr= new FileReader();
            fr.onload = function(e) {
                deferred.resolve(e.target.result);
            };
            fr.readAsDataURL( files[0] );
        } else {
            deferred.resolve(undefined);
        }

        return deferred.promise();
    }






    $("#Annuler").on('click',function(){
      window.location.reload();
    });



} );
</script>




<!-- Modal -->
<div class="modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="TitreModal_modal"></h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form class="md-form" id="ModalForm">
      <div class="file-field">

        <div class="d-flex justify-content-center">

          <div class="">
            <input type="hidden" name="IdRetraite" id="IdRetraite" value="">
            <input type="hidden" name="TypeDocument" id="TypeDocument" value="">
            <input type="hidden" name="FileBlob" id="FileBlob" value="">
            <div id="CoreHtml">
            </div>

          </div>
        </div>
      </div>
    </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="Annuler">Fermer</button>
        <button type="button" class="btn btn-primary" id="SaveValidation">Enregistrer</button>
  <?php if($acces_f == '1'){ ?>
        <button type="button" class="btn btn-danger" id="SaveUpload">Enregistrer Fichier</button>
  <?php } ?>
      </div>
    </div>
  </div>
</div>


<!-- =========================================================================== -->
<div class="modal fade" id="modaldell-id" tabindex="-1" role="dialog" aria-labelledby="op_modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
           <div class="op_modal_results"></div>
            <div class="modal-header" style="background:#5bc0de">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h2 class="modal-title" style="color:#fff;font-size:14px;"></h2>
            </div>
            <div class="modal-body">
               <div class="row" >
                    <div id="results_handler" class="col-sm-6  alert alert-danger hide " style="margin-left:200px;text-align:center;" >
                    <span></span>
                    </div>
                </div>
                <div class="row">
                    <h4 class="op_modal_message col-sm-10 col-sm-offset-1"></h4>
                </div>


               <br/>
              <div class="row" id="nb_pr" >
                 <input type="number" class="form-control nb_pr" name="nb_pr" id="nb_prc"/>
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
                <?= form_button('op_modal_close', 'Non', 'data-dismiss="modal" class="btn btn-default" id="op_modal_close"'); ?>
                <?= form_button('op_modal_submit', 'Oui', 'id="op_modal_submit" class="btn btn-info"'); ?>
            </div>
        </div>
    </div>
</div>


                </div>
                <!-- END PAGE CONTENT WRAPPER -->
                <script>
                  //var base_url = "<?= base_url() ?>";
                // valider prolongations

                $('.item-pr').on('click',function(){
                    id = $(this).attr('data');
                    cadre = $(this).attr('cadre');
                    regime = $(this).attr('regime');
                    nums   = $(this).attr('nums');
                    notif   = $(this).attr('notif');
                    departr   = $(this).attr('departr');

                  $('#modaldell-id').find('.nb_pr').val('');

                    $('#modaldell-id').find('.modal-title').text('Êtes-vous sûr de vouloir prolonger la ligne selectionnée:');

                    $('#modaldell-id').find('.op_modal_message').html('Nom/prenom: ' + $("#elm_title-"+ $(this).attr('data')).html() + ' <br/> numero de somme: ' + nums);



                    $('#modaldell-id').modal('show');



                    $("#op_modal_closet").click(function(){
                       window.location.href = base_url;
                    });

                   $("#op_modal_submit").click(function(){
                  var nbv = $('#modaldell-id').find('.nb_pr').val();
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
                               setTimeout(function() {$('#modaldell-id').modal('hide');}, 4000);
                               window.location.href=base_url + 'accueil/encours';
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


<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>

<div id="container" style="min-width: 310px; height: 400px; max-width: 800px; margin: 0 auto"></div>

<?php
/*** liste des années des retraités **/
$queryDetailATAnn = $this->db->query(" SELECT distinct YEAR(DATE_ADD(retraite.date_naissance_retraite,INTERVAL (parametre.age_retraite_parametre) YEAR))  AS DateRetraite

FROM retraite
JOIN cadre on (retraite.id_cadre = cadre.id_cadre AND
cadre.deleted_cadre = 'N')
JOIN regime on (retraite.id_regime = regime.id_regime AND
regime.deleted_regime = 'N')
JOIN cadretype ON (cadretype.id = retraite.id_cadre_type AND cadretype.deleted_cadreType = 'N')
JOIN parametre ON (regime.id_regime = parametre.regime AND
cadre.id_cadre = parametre.cadre AND
         (YEAR(retraite.date_naissance_retraite) BETWEEN SUBSTRING(parametre.condition_parametre,1,4) AND SUBSTRING(parametre.condition_parametre,6,4)))
JOIN retraite.position on (retraite.id_position = position.id_position)
WHERE retraite.deleted_retraite ='N' AND
  retraite.status_retraite ='E'

Group by DateRetraite,cadre.id_cadre ");
$chart_datasATn = '';
foreach($queryDetailATAnn->result() as $rowDetaiATT ){
 $chart_datasATn .= $rowDetaiATT->DateRetraite.",";
}

// print_r($chart_datasATn);
/*** liste des années des retraités **/

$queryDetailCadre = $this->db->query("select * from cadretype ");


$chart_datasAT = '';
$cadreTypeName='';
foreach($queryDetailCadre->result() as $rowDetaiAT ){
$cadreType= $rowDetaiAT->id;
$cadreTypeName= $rowDetaiAT->libelle_cadreType;
$nbR_type_cadre='';
foreach($queryDetailATAnn->result() as $rowDetaiATT ){
 $dateRet = $rowDetaiATT->DateRetraite;
  $queryDetailATDate = $this->db->query("SELECT cadretype.libelle_cadreType,cadre.id_cadre,cadre.libelle_cadre,YEAR(DATE_ADD(retraite.date_naissance_retraite,INTERVAL (parametre.age_retraite_parametre) YEAR))  AS DateRetraite,

                                        count(retraite.id_retraite) as nb_ret
                                  FROM retraite
                                  JOIN cadre on (retraite.id_cadre = cadre.id_cadre AND
                                  cadre.deleted_cadre = 'N')
                                  JOIN regime on (retraite.id_regime = regime.id_regime AND
                                  regime.deleted_regime = 'N')
                                  JOIN parametre ON (regime.id_regime = parametre.regime AND
                                  cadre.id_cadre = parametre.cadre AND
                                               (YEAR(retraite.date_naissance_retraite) BETWEEN SUBSTRING(parametre.condition_parametre,1,4) AND SUBSTRING(parametre.condition_parametre,6,4)))
                                  JOIN retraite.position on (retraite.id_position = position.id_position)
                                  JOIN cadretype ON (cadretype.id = retraite.id_cadre_type AND cadretype.deleted_cadreType = 'N')
                                  WHERE retraite.deleted_retraite ='N' AND
                                        retraite.status_retraite ='E'

                                  Group by DateRetraite,cadretype.id
                                  having cadretype.id='". $cadreType ."' AND DateRetraite = '" . $dateRet . "'");


$nbR_type_cadr = $queryDetailATDate->row();
if(isset($nbR_type_cadr->id_cadre) && !empty($nbR_type_cadr->id_cadre)){
$nbR_type_cadre .= $nbR_type_cadr->id_cadre.',';
}else{
$nbR_type_cadre .= '0'.',';
}
// if($nbR_type_cadr != ''){
//   $nbR_type_cadre .=$nbR_type_cadr.',';
// }else{
//    $nbR_type_cadre .='0'.',';
// }

}

$AT = 0;
$ENS = 0;

// foreach($queryDetailATDate->result() as $resultByDate){
//
//   switch($resultByDate->id_cadre){
//     case '1':
//     $ENS = $resultByDate->nb_ret;
//     continue;
//     case '2':
//     $AT = $resultByDate->nb_ret;
//     continue;
//   }
// }
$chart_datasAT .= "{ name:'".$cadreTypeName ."', data: [$nbR_type_cadre],},";


   //$chart_datasAT .= "{ name:'".$rowDetaiAT->libelle_cadreType ."', data: [" . $rowDetaiAT->DateRetraite . "," . $rowDetaiAT->nb_ret."],},";

}

$Chart_dataAT = substr($chart_datasAT, 0, -1);
// print_r($Chart_dataAT);
//
//    ?>
<script>
Highcharts.chart('container', {
chart: {
  type: 'area'
},
title: {
  text: 'Nombre des retraités par cadre '
},
subtitle: {
  text: 'Source: IAV HASSAN II'
},
xAxis: {
  categories: [<?= $chart_datasATn ?>],
  tickmarkPlacement: 'on',
  title: {
    enabled: false
  }
},
yAxis: {
  title: {
    text: 'nbr des retraités'
  }
},
tooltip: {
  pointFormat: '<span style="color:{series.color}">{series.name}</span>: ({point.y:,.0f} retraités)<br/>',
  split: true
},
plotOptions: {
  area: {
    stacking: 'percent',
    lineColor: '#ffffff',
    lineWidth: 1,
    marker: {
      lineWidth: 1,
      lineColor: '#ffffff'
    }
  }
},
series: [<?= $chart_datasAT ?>]
});
</script>
