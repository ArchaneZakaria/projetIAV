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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/ju/dt-1.10.15/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>


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
         <a href="#" type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#exampleModal" >Ajouter retraite <i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i></a>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
          </ul>
          <div class="clearfix"></div>
        </div>

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
                       $queryDetail = $this->db->query("select *
                                                        from retraite
                                                        inner join cadre on (retraite.id_cadre = cadre.id_cadre)
                                                        inner join regime on (retraite.id_regime = regime.id_regime)
                                                        inner join retraite.position on (retraite.id_position = position.id_position)
                                                        where retraite.deleted_retraite ='N' AND
                                                              retraite.status_retraite ='V'");
                       foreach($queryDetail->result() as $rowDetail ){
                        ?>

                      <tr role="row" class="odd">

                          <td class="sorting_1"><?= $rowDetail->num_somme_retraite ?></td>
                          <td class="elm_title" id="elm_title-<?= $rowDetail->id_retraite ?>"><?= $rowDetail->nom_retraite ?></td>
                          <td><?= $rowDetail->date_naissance_retraite ?></td>
                          <td><?= $rowDetail->date_depart_retraite ?></td>
                          <td><?= $rowDetail->libelle_cadre ?></td>
                          <td><?= $rowDetail->libelle_regime ?></td>
                          <td><?= $rowDetail->libelle_position ?></td>

                          <td>
                            <?php
                            $QueryTypeDoc = $this->db->query("SELECT *
                                                             FROM typedocument
                                                             JOIN typedocument_retraite ON (typedocument_retraite.id_typedocument = typedocument.id_typedocument AND typedocument_retraite.id_retraite = ".$rowDetail->id_retraite." )
                                                             WHERE deleted_typedocument = 'N'");
                            foreach($QueryTypeDoc->result() as $RowTypeDoc ){
                            ?>

                                       <a target="_blank"  href ="<?= base_url() ?>assets/images/<?= $RowTypeDoc->file_document_retraite ?>"  style="color:#009966;text-decoration:underline;"  ><?= $RowTypeDoc->code_typedocument ?> </a> &nbsp;
                                       <?php '<img src="data:image/jpeg;base64,'.base64_encode($RowTypeDoc->file_typedocument_retraite) .'" />';  ?>
                              <?php
                            }
                            ?>
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
       <?= form_button('op_modal_close', 'Non', 'data-dismiss="modal" class="btn btn-default"'); ?>
       <?= form_button('op_modal_submit', 'Oui', 'id="op_modal_submit" class="btn btn-info"'); ?>
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
        var ID = $(this).attr("id");

          $.ajax({
            type: 'POST',
            url: base_url + 'verifvaliation',
            data: {ID  :ID},
            cache:false,
            async:false,
            success: function(msg){
              $("#CoreHtml").html(msg);
              $("#IdRetraite").val(ID);
              $("#exampleModal").show();

              $("#file-simple").on('change',function(){
                readImage($(this)).done(function(base64Data){
                  alert(base64Data);
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
          url: base_url + 'insertvaliation',
          data: {ID  :ID, listCheck:sList},
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
      var FileBlob = $("#FileBlob").val();

      if(FileBlob == ""){
        alert("Veuillez selectionnez le fichier.");
        return false;
      }

      $.ajax({
          type: 'POST',
          url: base_url + 'validationretraite',
          data: {ID  :ID, FileBlob:FileBlob},
          success: function(msg){
            if(msg == 1){
              alert("retraite valider");
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



/***** ================ telecharger fichier ****/
  // c est une erreur de donnee le meme id file_pt l span (d'acc)
  // au lieu d envoyer tous le code de l image f l POST pourkoi ne pas envoye le id document et le id retraite w dir reqeute bach trecuperer la fichier ( c preque pareil chef : le contenu recu reste le meme andiro f href je crois jereb att)
    // $(".file_pt").on('click',function(){
    //
    //   var file =  $(this).attr('data');
    //   //golt lik sift id w id retraite1: ana nsifto bgit 3i ntester href bach ysiftk directement la page tester a 7nini
    // //  window.href.location = file;  nkhliha hka wwla khs chihaja
    //   var url = "http://stackoverflow.com";
    //   $(location).attr('href',file);
    //
    //   $.ajax({
    //       type: 'POST',
    //       url: base_url + '/accueil/blob' ,
    //       data: {FileBlob:file},
    //       success: function(msg){
    //         if(msg == 1){
    //           alert("retraite valider");
    //         // hat la reponse an tant reference vers ==>att  window.href.locaion =
    //
    //         }
    //       },
    //       error: function(msg){
    //         alert('error');
    //       }
    //   });
    //
    //
    // });
/***** ================ telecharger fichier ****/
} );




</script>




<!-- Modal -->
<!-- <div class="modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Valider une Etape</h5>
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
        <button type="button" class="btn btn-danger" id="SaveUpload">Enregistrer Fichier</button>
      </div>
    </div>
  </div>
</div> -->


                </div>
                <!-- END PAGE CONTENT WRAPPER -->
