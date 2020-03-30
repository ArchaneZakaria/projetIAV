  <h1 class="titrePage"> Liste des prestataires </h1>
<?php  $prefix ='prestataire'; ?>
        <!-- page content -->
        <div class="container-fluid">
             <a href="<?= base_url('prestataire/add') ?>"   class="btn btn-primary" style="border-radius:5px;  border: 2px solid #006699;"  > Ajouter un prestataire <span class="glyphicon glyphicon-arrow-right" ></span></a>
             <div class="row-fluid">
                 <div class="span12">
                     <div class="widget-box">
                         <div class="widget-title">
                             <span class="icon"><i class="icon-th"></i></span>
                             <h5>Liste des prestataires</h5>
                         </div>
                         <div class="widget-content nopadding">
                             <table class="table table-striped table-bordered table-hover dataTable no-footer data-table" role="grid" aria-describedby="dynamic-table_info">
                                 <thead>
                                 <tr class="">
                                     <th style="text-align: left;">Nom fournisseur</th>
                                     <th style="text-align: left;">Domaine d'activité</th>
                                     <th style="text-align: left;">Ville</th>
                                     <th style="text-align: left;">Tel</th>
                                     <th style="text-align: left;">Email</th>
                                     <th>Option</th>
                                   </tr>
                                 </thead>
                                 <tbody>
                <?php foreach($fournisseurs->result() as $rowDetail ):?>
                                     <tr class="gradeX">
                                       <td  id="elm_fournisseur<?= $rowDetail->id_fournisseur ?>"><?= $rowDetail->nom_fournisseur ?></td>
                                       <td id="elm_domaine<?=  $rowDetail->id_fournisseur  ?>"><?= $rowDetail->libelle_domaineactivite ?></td>
                                       <td id="elm_ville<?= $rowDetail->id_fournisseur ?>"><?= $rowDetail->ville_fournisseur ?></td>
                                       <td><?= $rowDetail->tel_fournisseur ?></td>
                                       <td><?= $rowDetail->email_fournisseur ?></td>
                                         <td class="center" style="text-align: center;"><div class="">
                                                 <p>
                                      <a class="item-del red" href="#" data="<?= $rowDetail->id_fournisseur ?>" dat="imad@gmail.com">
                                                         <span class="glyphicon glyphicon-trash red" data-target="#exampleModalCenterA" data-toggle="modal" Title="Supprimer" ></span>
                                      </a>
                                       <!-- href=" //base_url('prestataire/etab/edit/'.$rowDetail->id_fournisseur)"  -->
                                      <a class="edit_domn green" href="#" data="<?= $rowDetail->id_fournisseur ?>" dat="imad@gmail.com">
                                           <span class="glyphicon glyphicon-edit green " Title="Modifier"></span>
                                      </a>

                                                 </p>
                                             </div></td>

                                     </tr>
                            <?php endforeach; ?>


                                 </tbody>
                             </table>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>

     <!-- Pièce jounte modal -->

     <!-- Prestataire modal -->


     <!-- Modal -->
     <div class="modal fade" id="modal-id" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="margin:auto;width:100%;">
         <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLongTitle">Modifier Prestataire</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
              <div class="row" >
                 <div id="prestataire_result" class="col-sm-10  alert alert-danger hide  " style="margin-left:50px;margin-top:10px;;"  >
                   <span></span>
                 </div>
               </div>
                 <div class="modal-body">


                   <input type="hidden" id="id_fournisseur" name="nom" class="form-control"  />

                   <div class="control-group">
                         <label class="control-label">Prestataire</label>
                         <div class="controls">
                             <input type="text" id="nom" name="nom" class="form-control"  placeholder="Nom et prenom" style="height: 30px;width: 509px;font-size: 12px;" />
                         </div>
                     </div>
                     <div class="control-group">
                         <label class="control-label">Email</label>
                         <div class="controls">
                             <input type="Email"  id="email" name="email" class="form-control"  placeholder="Email" style="height: 30px;width: 509px;font-size: 12px;"/>
                         </div>
                     </div>
                     <div class="control-group">
                         <label class="control-label">Tel</label>
                         <div class="controls">
                             <input type="text" id="tel" name="tel" class="form-control"  placeholder="Numéro de téléphone" style="height: 30px;width: 509px;font-size: 12px;" />
                         </div>
                     </div>
                     <div class="control-group">
                         <label class="control-label">Ville</label>
                         <div class="controls">
                             <input type="text" id="ville" name="ville" class="form-control"  placeholder="Ville" style="height: 30px;width: 509px;font-size: 12px;" />
                         </div>
                     </div>
                     <div class="control-group">
                         <label class="control-label">Domaine d'activité</label>
                         <div class="controls">
                             <select class="browser-default custom-select" id="Iddomaine">



                                 <option selected value="0" >Selectionner un Service</option>
     <?php  $sql = "SELECT * FROM iav_domaineactivite where module='bm'" ;
     $queryDetail = $this->db->query($sql);
     foreach($queryDetail->result() as $rowDetail ):
     ?>
                                 <option value="<?= $rowDetail->id_domaineactivite ?>"><?= $rowDetail->libelle_domaineactivite  ?></option>
    <?php  endforeach;  ?>
                             </select>
                         </div>
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button id="op_modal_reset" type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                     <button id="btnedit" type="button" class="btn btn-primary">Enregistrer</button>
                 </div>
             </div>
         </div>
     </div>


<!-- page content row -->
         <br />
<!-- <div class="modal fade" id="modaldel-id" tabindex="-1" role="dialog" aria-labelledby="op_modal" aria-hidden="true">
         <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="modal-header" style="background:#5bc0de">
                   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                   <h3 class="modal-title" style="color:#242424;font-size:20px;"></h3>
               </div>
               <div class="modal-body">
                 <div class="row" >
                 <div id="domaine_result" class="col-sm-6  alert alert-danger hide " style="margin-left:200px;text-align:center;" >
                   <span></span>
                 </div>
                 </div>
                   <div class="row" style="text-align: center;">
                   <h4 class="op_modal_message_titre col-sm-10 col-sm-offset-1" ></h4>
                   <h4 class="op_modal_message_domaine col-sm-10 col-sm-offset-1" ></h4>
                   <h4 class="op_modal_message_ville col-sm-10 col-sm-offset-1" ></h4>
                   </div>
               </div>
               <div class="modal-footer">
                   <?= form_button('op_modal_close', 'Non', 'data-dismiss="modal" class="btn btn-default"'); ?>
                   <?= form_button('op_modal_submit', 'Oui', 'id="op_modal_submit" class="btn btn-info"'); ?>
               </div>
            </div>
        </div>
</div> -->
        <?php if (isset($op_modal)) echo $op_modal; ?>
        <!-- /page content -->
        <script type="text/javascript">
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-23581568-13', 'auto');
        ga('send', 'pageview');

        $('.item-del').on('click',function(){
          //you have to load the "url_helper" to use this function ?>';
          var id = $(this).attr('data');
          $('#modaldel-id').find('.modal-title').text('Êtes-vous sûr de vouloir supprimer La ligne selectionnée');
          $('#modaldel-id').find('.op_modal_message_titre').text($("#elm_fournisseur"+ $(this).attr('data')).html());
          $('#modaldel-id').find('.op_modal_message_domaine').text($("#elm_domaine"+ $(this).attr('data')).html());
          $('#modaldel-id').find('.op_modal_message_ville').text($("#elm_ville"+ $(this).attr('data')).html());
          $('#modaldel-id').modal('show');

           //****
           $("#op_modal_submit").click(function(){
             var base_url = '<?php echo base_url(); ?>';
             var results_handlerd = $('#domaine_result');
              $.ajax({
              type: 'POST',
              url: base_url + 'prestataire/ajax/Delete_fournisseur',
              data: {id:id},
              dataType: "JSON",
              cache:false,
              success: function(msg){
                if(msg.status == '1'){

                  form_show_resultst(results_handlerd,'info', msg.message, 'true');
                  setTimeout(function(){
                    window.location.href=base_url + 'prestataire/List';
                  },2000);
                }else {
                  form_show_resultst(results_handlerd, 'danger', msg.message, true);
                }
              },
              error: function(msg){
                console.log(msg);
                form_show_resultst(results_handlerd,'danger',"Erreur!",true);
              }
               });
            });

           //****
        });

        /***** modifier prestataire ***/

        $('.edit_domn').on('click',function(){
            var id              =  $(this).attr('data');

          //var results_handler =  $('#<?= $prefix ?>_results');
          $.ajax({
          type: 'POST',
          url: base_url + 'prestataire/ajax/edit_prestataire',
          data: {id:id},
          dataType: "JSON",
          cache:false,
          success: function(msg){
                 if(msg.status == '1'){

                  $('#modal-id').find('.modal-title').text('Modifier le prestataire');
                  $('#modal-id').modal('show');
                  console.log(msg.fournisseur['0']);
var nom = msg.fournisseur['0']['nom_fournisseur'];
var ville = msg.fournisseur['0']['ville_fournisseur'];
var tel = msg.fournisseur['0']['tel_fournisseur'];
var email = msg.fournisseur['0']['email_fournisseur'];
                  $("#nom").val(nom);
                  $("#ville").val(ville);
                  $("#tel").val(tel);
                  $("#email").val(email);
                  $("#id_fournisseur").val(id);

            }else {
              alert('ee');
              //form_show_resultst(results_handlerd, 'danger','Erreur de traitement', true);
            }
          },
          error: function(msg){
            console.log(msg);
            //form_show_resultst(results_handlerd,'danger',"Erreur!",true);
          }
     });

   });

$("#op_modal_reset").click(function(){
  $('#nom').val('');
  $('#ville').val('');
  $('#tel').val('');
  $('#email').val('');
});

// $("#op_modal_submit").click(function(){
//      var base_url = '<?php echo base_url(); ?>';
//
//      var nom = $('#nom').val();
//      var ville = $('#ville').val();
//      var tel = $('#tel').val();
//      var email =$('#email').val();
//       var id =$('#id_fournisseur').val();
//
//      var results_handlerd = $('#domaine_result');
//
//       $.ajax({
//       type: 'POST',
//       url: base_url + 'prestataire/edit',
//       data: {id:id,nom:nom,ville:ville,tel:tel,email:email},
//       dataType: "JSON",
//       cache:false,
//       success: function(msg){
//         if(msg.status == '1'){
//           form_show_resultst(results_handlerd,'info', msg.message, 'true');
//           setTimeout(function(){
//             window.location.href=base_url + 'prestataire/domaineActivite/List';
//           },2000);
//         }else {
//           form_show_resultst(results_handlerd, 'danger', msg.message, true);
//         }
//       },
//       error: function(msg){
//         console.log(msg);
//         form_show_resultst(results_handlerd,'danger',"Erreur!",true);
//       }
//        });
//     });



    var base_url = '<?php echo base_url(); //you have to load the "url_helper" to use this function ?>';
    $('#btnedit').click(function() {


     var nom = $('#nom').val();
     var ville = $('#ville').val();
     var tel = $('#tel').val();
     var email =$('#email').val();
     var id =$('#id_fournisseur').val();
     var domaine   =  $("#Iddomaine").val();
     var results_handlerd = $('#prestataire_result');


     $.ajax({
        type: 'POST',
        url: base_url + 'prestataire/ajax/Ajouter_prestataire',
        data: {nom:nom,email:email,tel:tel,ville:ville,domaine:domaine,id:id},
        dataType: "JSON",
        cache:false,
        success: function(msg){
         if(msg.status == '1'){
           form_show_resultst(results_handlerd, 'info', msg.message, 'true');
           setTimeout(function(){
             window.location.href=base_url + 'prestataire/list';
           }, 2000);

         }else if(msg.status == '0'){
            form_show_resultst(results_handlerd, 'danger', msg.message, true);
         }
        },
        error: function(msg){
      form_show_resultst(results_handlerd, 'danger', 'veuillez remplir les champs vides', true);
        }
     });

    });

        /*** modifier prestataire ***/


        </script>
