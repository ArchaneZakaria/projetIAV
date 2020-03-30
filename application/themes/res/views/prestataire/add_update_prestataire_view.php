
<div class="container-fluid">
  <div class="row-fluid">
    <div class="">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Prestataire</h5>
        </div>
        <div class="widget-content nopadding">
 <form action="#" method="get" class="form-horizontal">
    <input type="hidden" value="<?= isset($hidden) ? $hidden['id_fournisseur'] : '' ?>" name="id_fournisseur" id="id_fournisseur" />
       <div class="row" >
           <div id="<?= $prefix ?>_results" class="col-sm-6  alert alert-danger hide " style="margin-left:200px;text-align:center;" >
             <span></span>
           </div>
       </div>

       <div class="control-group row box">
              <label class="col-md-3">Prestataire* </label>
              <div class="col-md-8">
                <input id="<?= $prefix ?>_nomfournisseur"  type="text" class="span11" placeholder="Nom Prenom" style="font-size: 12px;" name="nom" />
              </div>
        </div>

      <div class="control-group row box">
              <label class="col-md-3">Email*</label>
              <div class="col-md-8">
                <input id="<?= $prefix ?>_emailfournisseur" type="email" class="span11" placeholder="Email"style="font-size: 12px;" name="email" />
              </div>
        </div>

          <div class="control-group row box">
                    <label class="col-md-3">Tel*</label>
                    <div class="col-md-8">
                      <input id="<?= $prefix ?>_tel" name="tel" type="tel" class="span11" placeholder="" style="font-size: 12px;" />
                    </div>
              </div>

              <div class="control-group row box">
                <label class="col-md-3">Ville*</label>
                <div class="col-md-8">
                  <input  id="<?= $prefix ?>_ville" name="ville" required="required" type="text" class="span11" placeholder="" style="font-size: 12px;" />
                </div>
          </div>

       <div class="control-group row box row box">
              <label class=" col-md-3" >Domaine d'activité :</label>
              <div class="col-md-8">

                <select class="chosen form-control" id="<?= $prefix ?>_domaine" >
                  <option value="null">Selectionner domaine d'Activité</option>
                  <?php foreach($domaines->result() as $rowDetail ):?>
                      <option value='<?=$rowDetail->id_domaineactivite;?>'><?= $rowDetail->libelle_domaineactivite ?></option>
                  <?php endforeach; ?>
                </select>

            </div>
      </div>


              <div class="form-actions" style="text-align: center;">
                <a href="<?= base_url('prestataire/list')?>"   type="reset" class="btn btn-danger" style="border-radius:5px;  border: 2px solid #a71f10;"><span class="glyphicon glyphicon-repeat"></span> Annuler</button>

                <a type="submit"  id="btnadd" class="btn btn-primary " style="border-radius:5px;  border: 2px solid #006699;">Enregistrer</a>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>
</div>


<!-- =============================================================== -->


<!-- Google Analytics -->
<script type="text/javascript">
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-23581568-13', 'auto');
ga('send', 'pageview');

var base_url = '<?php echo base_url(); //you have to load the "url_helper" to use this function ?>';
$('#btnadd').click(function() {

 var nom             =  $("#<?= $prefix ?>_nomfournisseur").val();
 var email           =  $("#<?= $prefix ?>_emailfournisseur").val();
 var tel             =  $("#<?= $prefix ?>_tel").val();
 var ville           =  $("#<?= $prefix ?>_ville").val();
 var domaine         =  $("#<?= $prefix ?>_domaine").val();
 var results_handler =  $('#<?= $prefix ?>_results');
 if(domaine == "null"){
     form_show_resultst(results_handler, 'danger', "Vous selectionez un domaine activité", true);
 }else {
   $.ajax({
      type: 'POST',
      url: base_url + 'prestataire/ajax/Ajouter_prestataire',
      data: {nom:nom,email:email,tel:tel,ville:ville,domaine:domaine},
      dataType: "JSON",
      cache:false,
      success: function(msg){
       if(msg.status == '1'){
         form_show_resultst(results_handler, 'info', msg.message, 'true');
         setTimeout(function(){
           window.location.href=base_url + 'prestataire/list';
         }, 2000);

       }else if(msg.status == '0'){
          form_show_resultst(results_handler, 'danger', msg.message, true);
       }
      },
      error: function(msg){
        alert('error');
      }
   });
 }


});



</script>
