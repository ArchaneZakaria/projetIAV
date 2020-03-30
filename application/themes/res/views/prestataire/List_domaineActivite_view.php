<?php $prefix = 'domaineactivite'  ?>
<!--sidebar-menu-->
<!---------------------------------------------------------------------------------------------------------------------------------------------------------------->
<div id="content-header" style="margin-top:20px;">

                <h1 class="titrePage">Domaine d'activité</h1>
</div>

<div class="row" >
    <div id="<?= $prefix ?>_results" class="col-sm-6  alert alert-danger hide " style="margin-left:200px;text-align:center;" >
          <span></span>
    </div>
</div>


<div class="container-fluid">
    <div class="form-group row">
        <div class="span">
            <input id="<?= $prefix ?>_domaine"  required="required" type="text" class="form-control span4" style="font-size: 12px; height: 35px;">
        </div>
        <div class="span">
          <a href="#" id="add_domn" type="button" class="btn btn-primary " style="border-radius:5px;  border: 2px solid #006699;" data-target="#exampleModalAjouter" data-toggle="modal" >Ajouter<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i></a>
        </div>
    </div>

</div>


<?php if(isset($domaine_modf)== true) { ?>
  <div class="container-fluid">
      <div class="form-group row">
          <div class="span">
     <?php foreach($domaine_modf->result() as $rowDetail ):?><?php endforeach; ?>
     <input id="<?= $prefix ?>_domaine_modf" data="<?= $rowDetail->id_domaineactivite ?>" value="<?= $rowDetail->libelle_domaineactivite ?>" required="required" type="text" class="form-control span4" style="font-size: 12px; height: 35px;"  name="nom_domaine_modifier" placeholder="Domaine d'activite"  >

     </div>
       <div class="span">
    <a  id="edit_domn" type="button" class="btn btn-sm btn-success" style="border-radius:5px;  border: 2px solid #006699;">Modifier<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
     </a>
        </div>
<?php } ?>


<div class="container-fluid">
                <div class="row-fluid">
                  <div class="controls">
                    <div class="span12">
                        <div class="widget-box">
                            <div class="widget-title">
                                <span class="icon"><i class="icon-th"></i></span>
                                <h5>Domaine d'activité</h5>
                            </div>
                            <div class="widget-content nopadding">

                                <table class="table  table-bordered data-table" role="grid" aria-describedby="dynamic-table_info">
                                    <thead>
                                    <tr>
                                        <th>Domaine d'activité</th>
                                        <th>Option</th>
                                    </tr>
                                    </thead>
                                    <tbody>


                      <?php foreach($domaines->result() as $rowDetail ):?>
                                        <tr class="gradeX">
                                          <td class="sorting_1" id="elm_domaine_<?= $rowDetail->id_domaineactivite ?>"><?= $rowDetail->libelle_domaineactivite ?></td>
                                            <td>
                                      <a class="item-edit green" href="<?=base_url('prestataire/domaineActivite/modifier/'.$rowDetail->id_domaineactivite)?>" data="<?= $rowDetail->id_domaineactivite ?>" dat="benabbes@gmail.com">
                                                    <span class="glyphicon glyphicon-edit frns " Title="Edit" data-target="#exampleModalEdit"  data-toggle="modal"></span>
                                      </a>
                                                <a class="item-del red" href="#" data="<?= $rowDetail->id_domaineactivite ?>" dat="imad@gmail.com">
                                                            <span class="glyphicon glyphicon-trash red"  Title="Supprimer" ></span>
                                                        </a>
                                            </td>
                                        </tr>
                 <?php endforeach;  ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
</div>

<!-- Edit domaine d'activité modal -->
<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="margin:auto;width:100%;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modifier domaine d'activité</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="control-group">
                    <label class="control-label">Nom domaine d'activité</label>
                    <div class="controls">
                        <input type="text" name="titreAlerte" class="form-control" style="height: 40px;" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary">Enregistrer </button>
            </div>
        </div>
    </div>
</div>






        <!-- notification -->
        <div class="modal fade" id="alerteModal" tabindex="-1" role="dialog" aria-labelledby="alerteModal" aria-hidden="true" style="margin:auto;width:100%;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Alerte</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="control-group">
                            <label class="control-label">Titre</label>
                            <div class="controls">
                                <input type="text" name="titreAlerte" class="form-control" style="height: 40px;" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Message</label>
                            <div class="controls">
                                <textarea class="form-control" style="width:100%; "></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-primary">Valider</button>
                    </div>
                </div>
            </div>
        </div>
  <!-- notification -->

 <?php if (isset($op_modal)) echo $op_modal; ?>
        <!-- notification -->
        <script>
           /*** sous menu **/
$(document).ready(function(){
  $('.dropdown-submenu a.test').on("click", function(e){
    $(this).next('ul').toggle();
    e.stopPropagation();
    e.preventDefault();
  });
});
</script>



<!-- /page content -->

<script type="text/javascript">
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-23581568-13', 'auto');
ga('send', 'pageview');

var base_url = '<?php echo base_url(); //you have to load the "url_helper" to use this function ?>';
$('#add_domn').click(function() {

 var domaine     =  $("#<?= $prefix ?>_domaine").val();
var results_handler = $('#<?= $prefix ?>_results');


 $.ajax({
    type: 'POST',
    url: base_url + 'prestataire/ajax/ajouter_domaine',
    data: {domaine:domaine},
    dataType: "JSON",
    cache:false,
    success: function(msg){
     if(msg.status == '1'){
       form_show_resultst(results_handler, 'info', msg.message, 'true');
       setTimeout(function(){
         window.location.href=base_url + 'prestataire/domaineActivite/List';
       }, 2000);

     }else if(msg.status == '0'){
        form_show_resultst(results_handler, 'danger', msg.message, true);
     }
    },
    error: function(msg){
      alert('error');
    }
 });
});


$('.item-del').on('click',function(){
  //you have to load the "url_helper" to use this function ?>';
  var id = $(this).attr('data');
  $('#modaldel-id').find('.modal-title').text('Êtes-vous sûr de vouloir supprimer La ligne selectionnée');
  $('#modaldel-id').find('.op_modal_message_titre').text($('#elm_domaine_' + id).text());
  $('#modaldel-id').modal('show');

   //****
   $("#op_modal_submit").click(function(){
     var base_url = '<?php echo base_url(); ?>';
     var results_handlerd = $('#domaine_result');

      $.ajax({
      type: 'POST',
      url: base_url + 'prestataire/ajax/delete_domaine',
      data: {id:id},
      dataType: "JSON",
      cache:false,
      success: function(msg){
        if(msg.status == '1'){
          form_show_resultst(results_handlerd,'info', msg.message, 'true');
          setTimeout(function(){
            window.location.href=base_url + 'prestataire/domaineActivite/List';
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



$('.item-edit').on('click',function(){
var idDomaine = $(this).attr('data');
var nomDomaine = $('#elm_domaine_' + idDomaine).text();
window.location.href=base_url + 'prestataire/domaineActivite/modifier/'+idDomaine;
});


$('#edit_domn').on('click',function(){
  var domaine         =  $("#<?= $prefix ?>_domaine_modf").val();
  var id              =  $("#<?= $prefix ?>_domaine_modf").attr('data');
  var results_handler =  $('#<?= $prefix ?>_results');
  $.ajax({
  type: 'POST',
  url: base_url + 'prestataire/ajax/modifier_domaine',
  data: {id:id,domaine:domaine},
  dataType: "JSON",
  cache:false,
  success: function(msg){
    if(msg.status == '1'){
      form_show_resultst(results_handler,'info', msg.message, 'true');
      setTimeout(function(){
        window.location.href=base_url + 'prestataire/domaineActivite/List';
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

</script>
