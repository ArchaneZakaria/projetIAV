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

</style>
<script src="<?=base_url('assets/js')?>/mainjs.js" ></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/ju/dt-1.10.15/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>

  <?php  $acces_f = $this->session->user['id_role']; ?>
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
           <a href="http://localhost/excel/" type="button" class="btn btn-sm btn-info"  >Ajouter retraite <i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i></a>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
          </ul>
          <div class="clearfix"></div>
        </div>


         <div class="x_content" style="display: block;">

<!-- Table -->

<div class="btn-group pull-left">
  <br/><br/>
    <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Exporter </button>
    <ul class="dropdown-menu">

        <li><a href="#" onClick ="$('#IDexample').tableExport({type:'csv',escape:'false'});"><img src='<?=base_url('assets') ?>/img/icons/csv.png' width="24"/> CSV</a></li>
        <li class="divider"></li>
        <li><a href="#" onClick ="$('#IDexample').tableExport({type:'excel',escape:'false'});"><img src='<?=base_url('assets') ?>/img/icons/xls.png' width="24"/> XLS</a></li>
        <!-- <li><a href="#" onClick ="$('#IDexample').tableExport({type:'doc',escape:'false'});"><img src='img/icons/word.png' width="24"/> Word</a></li> -->
        <!-- <li><a href="#" onClick ="$('#IDexample').tableExport({type:'pdf',escape:'false'});"><img src='img/icons/pdf.png' width="24"/> PDF</a></li> -->
    </ul>
</div>

           <div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
             <div class="row">

            </div>
           <div class="row">
             <div class="col-sm-12">
               <table id="IDexample" class="display responsive nowrap table-bordered" cellspacing="0" width="100%" style="width:100;">
                      <thead id="data-table">
                        <tr role="row">


                        <th>Num de somme</th>
                        <th>Nom/Prenom</th>
                        <th> Date naissance retraite  </th>
                        <th>Date depart retraite</th>
                        <th>Age de retraite</th>
                        <th>Cadre</th>
                        <th>grade</th>
                        <th> Regime  </th>
                        <th>Position</th>
                        <th>Option</th>
                        </tr>
                      </thead>
                      <tbody>

                      <?php
                       // $queryDetail = $this->db->query("SELECT *,
                       //                                         DATEDIFF(CURRENT_DATE, retraite.date_naissance_retraite)/365 AS AgeCalcule,
                       //                                         WHEN
                       //                                           retraite.date_depart_retraite IS NULL
                       //                                             THEN
                       //                                                DATE_ADD(retraite.date_naissance_retraite,INTERVAL (parametre.age_retraite_parametre) YEAR)
                       //                                         ELSE
                       //                                           retraite.date_depart_retraite
                       //                                       END AS DateRetraite,
                       //
                       //
                       //                                         DATE_SUB( DATE_ADD(retraite.date_naissance_retraite,INTERVAL (parametre.age_retraite_parametre) YEAR),INTERVAL 12 MONTH) AS DateNotification,
                       //                                         parametre.age_retraite_parametre AS AgeRetraite
                       //                                  FROM retraite
                       //                                  JOIN cadre on (retraite.id_cadre = cadre.id_cadre AND
                       //                                                 cadre.deleted_cadre = 'N')
                       //                                  JOIN regime on (retraite.id_regime = regime.id_regime AND
                       //                                                  regime.deleted_regime = 'N')
                       //                                                  JOIN parametre ON (regime.id_regime = parametre.regime AND
                       //                                                    cadre.id_cadre = parametre.cadre AND
                       //                                                                     (YEAR(retraite.date_naissance_retraite) BETWEEN SUBSTRING(parametre.condition_parametre,1,4) AND SUBSTRING(parametre.condition_parametre,6,4)))
                       //                                  JOIN retraite.position on (retraite.id_position = position.id_position)
                       //                                  WHERE retraite.deleted_retraite ='N' AND
                       //                                        retraite.status_retraite ='E'");


                                                              $queryDetail = $this->db->query("SELECT *,
                                                            DATEDIFF(CURRENT_DATE, retraite.date_naissance_retraite)/365 AS AgeCalcule,
                                    -- DATE_ADD(retraite.date_naissance_retraite,INTERVAL (parametre.age_retraite_parametre) YEAR) AS DateRetraite,
                                                                      CASE
                                                                      WHEN
                                                                           retraite.date_depart_retraite IS NULL
                                                                               THEN
                                                                         DATE_ADD(retraite.date_naissance_retraite,INTERVAL (parametre.age_retraite_parametre) YEAR)
                                                                         ELSE
                                                                           retraite.date_depart_retraite
                                                                        END AS DateRetraite,
                                                                       -- DATE_ADD(retraite.date_naissance_retraite,INTERVAL (parametre.age_retraite_parametre) YEAR) AS DateRetraite,


                                                                                                      DATE_SUB( DATE_ADD(retraite.date_naissance_retraite,INTERVAL (parametre.age_retraite_parametre) YEAR),INTERVAL 12 MONTH) AS DateNotification,
                                                                                                      parametre.age_retraite_parametre AS AgeRetraite
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
                                                                                                     retraite.status_retraite ='E'");

                       foreach($queryDetail->result() as $rowDetail ){
                        ?>

                      <tr role="row" class="odd">

                          <td class="sorting_1"><?= $rowDetail->num_somme_retraite ?></td>
                          <td class="elm_title" id="elm_title-<?= $rowDetail->id_retraite ?>"><?= $rowDetail->nom_retraite ?></td>
                          <td><?= $rowDetail->date_naissance_retraite ?></td>
                          <td><?= $rowDetail->DateRetraite ?></td>
                          <td><?= $rowDetail->AgeRetraite ?></td>
                          <td><?= $rowDetail->libelle_cadre ?></td>
                          <td><?= $rowDetail->grade_retraite ?></td>
                          <td><?= $rowDetail->libelle_regime ?></td>
                          <td><?= $rowDetail->libelle_position ?></td>

                          <td>
                                <?php
                                $QueryTypeDoc = $this->db->query("SELECT *
                                                                 FROM typedocument inner join regime_document on(typedocument.id_typedocument = regime_document.id_type_document) inner join regime on (regime_document.id_regime = regime.id_regime)
                                                                 WHERE deleted_typedocument = 'N' and regime.id_regime =" . $rowDetail->id_regime);
                                foreach($QueryTypeDoc->result() as $RowTypeDoc ){

                                  $SQLValidDocretraite = $this->db->query("SELECT id_typedocument_retraite, file_typedocument_retraite
                                                                          FROM typedocument_retraite
                                                                          WHERE id_retraite = ".$rowDetail->id_retraite." AND
                                                                                id_typedocument =  ".$RowTypeDoc->id_typedocument);

                                //  echo $RowTypeDoc->id_typedocument.' ' . $rowDetail->id_regime;

                                  $NumberRow = $this->db->affected_rows();
                                  // echo '=='.$NumberRow .'==';
                                  $Disabled = false;
                                  $File = "";
                                  if($NumberRow == 1){
                                    $Disabled = true;
                                    $RowFileValidationretraite = $SQLValidDocretraite->result();
                                    $File = $RowFileValidationretraite[0]->file_typedocument_retraite;
                                  }
                                ?>
                                  <?php
                                  $StyleBadge = "style='background-color: #E04B4A;'";
                                  if(!$Disabled){
                                    // echo !$Disabled.'--';
                                    $StyleBadge = "";
                                    ?>
                                    <a class="item-edit green" href='#'  id="<?= $rowDetail->id_retraite ?>" name="<?= $RowTypeDoc->id_typedocument ?>" tit="<?= $RowTypeDoc->libeller_typedocument ?>">
                                    <?php
                                  }
                                  ?>

                                    <i class="badge badge-secondary bigger-130 ToolTip " <?php echo $StyleBadge; ?> data-toggle="tooltip" data-placement="bottom" title="<?= $RowTypeDoc->libeller_typedocument ?>">
                                      <?php
                                      $QueryTypeDocValidation = $this->db->query("SELECT COUNT(validation.id_validation) AS TotValidation, COUNT(typedocument_validation.id_typedocument) AS TotValidationTraiter
                                                                        FROM validation
                                                                        LEFt JOIN typedocument_validation ON (validation.id_validation = typedocument_validation.id_validation AND
                                                                                                              typedocument_validation.deleted_typedocument_validation = 'N'  AND
                                                                                                              typedocument_validation.id_typedocument = ".$RowTypeDoc->id_typedocument." AND
                                                                                                              typedocument_validation.id_retraite = ".$rowDetail->id_retraite." )
                                                                        WHERE validation.deleted_validation = 'N'");
                                      ?>
                                      <?= $RowTypeDoc->code_typedocument ?>
                                      <?php
                                      if($Disabled){
                                      ?>
                                      <i class="fa fa-file"></i>
                                      <?php
                                      }
                                      ?>
                                    </i>
                                    <?php
                                      foreach($QueryTypeDocValidation->result() as $RowTypeDocValidation ){
                                        if(!$Disabled){
                                        ?>
                                          <span class="badge badge-danger" style="position: relative; top: -14px; left: -24px; background-color: #E04B4A;"><?= $RowTypeDocValidation->TotValidationTraiter ?> / <?= $RowTypeDocValidation->TotValidation ?></span>
                                        <?php
                                        }
                                      }
                                      ?>
                                  <?php
                                  if(!$Disabled){
                                    ?>
                                    </a>

                                    <?php
                                  }
                                  ?>

                                  <?php
                                }
                                ?>

      <!-- <i class="fa fa-paypal bigger-130 item-pr green" id="pr-<?= $rowDetail->id_retraite ?>" data="<?= $rowDetail->id_retraite ?>"  cadre="<?= $rowDetail->id_cadre ?>"  nums="<?= $rowDetail->num_somme_retraite ?>"  regime="<?= $rowDetail->id_regime ?>" notif="<?= $rowDetail->date_notif_retraite ?>" departr="<?= $rowDetail->date_depart_retraite ?>" ></i> -->

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


<!-- <div class="modal fade" id="modaldel-id" tabindex="-1" role="dialog" aria-labelledby="op_modal" aria-hidden="true">
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
</div> -->



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

                // valider prolongations

               $('.item-pr').on('click',function(){
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
                  //  alert(id +' '+'cadre = ' + cadre + 'regime = ' +  regime  +'nums= ' + nums + 'depar:' + departr);
                  $('#modaldel-id').find('.modal-title').text('Êtes-vous sûr de vouloir supprimer les lignes selectionnées:');

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
