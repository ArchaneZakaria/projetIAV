
    <style>
      .header.blue {
    border-bottom-color: #d5e3ef;
}
.header {
    line-height: 28px;
    margin-bottom: 16px;
    margin-top: 18px;
    padding-bottom: 4px;
    border-bottom: 1px solid #CCC;
}
    </style>

<style>

  input[type=email], input[type=url], input[type=search],
  input[type=tel], input[type=color], input[type=text], input[type=password], input[type=datetime], input[type=datetime-local], input[type=date], input[type=month], input[type=time], input[type=week], input[type=number], textarea {
    border-radius: 10px!important;
  }

</style>

       <div class="page-title">


              <div class="pull_right">
                <div class="col-md-2 col-sm-2 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Rechercher...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                  </div>
                </div>
              </div>
            </div>

          <div class="row">

<style>
  .leftmenu{
margin-left:10%;
  }
</style>


         </div>
<!-- page content row -->
         <div class="row">

              <div class="col-sm-12 col-md-12 col-xs-12 col-offset-3">

            <div class="x_panel">
                      <div class="x_title">
                      <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>

                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
  <!-- La forme -->
    <?php foreach($fournisseur as $rowDetail ):?><?php endforeach; ?>
    <form class="form-horizontal" role="form" id="form-crud"  validate>
    <input type="hidden" value="<?= $rowDetail->id_fournisseur ?>" name="id_fournisseur" id="id_fournisseur" />
       <div class="row" >
       <div id="<?= $prefix ?>_results" class="col-sm-6  alert alert-danger hide " style="margin-left:200px;text-align:center;" >
         <span></span>
       </div>
       </div>
           <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nom">Nom du prestataire<span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input  id="<?= $prefix ?>_nomfournisseur" value="<?= $rowDetail->nom_fournisseur ?>" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="nom" placeholder="Nom Prenom" required="required" type="text">
                </div>
            </div>
           <!--  prenom -->
           <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="prenom">Email <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input  id="<?= $prefix ?>_emailfournisseur" value="<?= $rowDetail->email_fournisseur ?>" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="email" placeholder="Email" required="required" type="email">
                </div>
            </div>
             <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tel">Tel <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="<?= $prefix ?>_tel" value="<?= $rowDetail->tel_fournisseur ?>" name="tel" required="required" class="form-control col-md-7 col-xs-12" data-inputmask="'mask' : '(999) 999-9999'">
                </div>
            </div>
            <div class="item form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tel">Ville<span class="required">*</span>
               </label>
               <div class="col-md-6 col-sm-6 col-xs-12">
                 <input type="text" id="<?= $prefix ?>_ville" value="<?= $rowDetail->ville_fournisseur ?>" name="ville" required="required" class="form-control col-md-7 col-xs-12">
               </div>
           </div>
              <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tel">Departement/Service <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class=" chosen form-control" id="<?= $prefix ?>_domaine" >
                      <?php foreach($domaines->result() as $rowDetail ):?>
                          <option value='<?=$rowDetail->id_domaineactivite;?>'><?= $rowDetail->libelle_domaineactivite ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
               </div>


         <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                        <a href="<?= base_url('prestataire/list')?>" class="btn" type="reset" ><i class="ace-icon fa fa-undo"></i>Annuler</a>
                          <button class="btn btn-info" type="button" id="btnedit">Modifier</button>
                        </div>
                      </div>
        </form>
<!-- La forme -->
                    <div class="clearfix"></div></div><div class="x_content">
                    <br />
                    </div>
              </div>
         </div>
<!-- page content row -->
         <br />
<!-- Google Analytics -->
<script type="text/javascript">
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-23581568-13', 'auto');
ga('send', 'pageview');

var base_url = '<?php echo base_url(); //you have to load the "url_helper" to use this function ?>';
$('#btnedit').click(function() {
 var id              =  $("#id_fournisseur").val();
 var nom             =  $("#<?= $prefix ?>_nomfournisseur").val();
 var email           =  $("#<?= $prefix ?>_emailfournisseur").val();
 var tel             =  $("#<?= $prefix ?>_tel").val();
 var ville           =  $("#<?= $prefix ?>_ville").val();
 var domaine         =  $("#<?= $prefix ?>_domaine").val();
 var results_handler = $('#<?= $prefix ?>_results');
 $.ajax({
    type: 'POST',
    url: base_url + 'prestataire/ajax/Ajouter_prestataire',
    data: {nom:nom,email:email,tel:tel,ville:ville,domaine:domaine,id:id},
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

});



</script>
