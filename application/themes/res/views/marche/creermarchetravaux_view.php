<h1 class="titrePage">Lancer un marché travaux</h1>

<div class="container-fluid">
  <div class="row-fluid">
    <div class="">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Marché travaux</h5>
        </div>
        <div class="widget-content nopadding">
          <form action="#" method="get" class="form-horizontal">
   <div class="control-group row box">
              <label class=" col-md-3" >N° AO *:</label>
              <div class="col-md-8">
                <input id="<?= $prefix ?>_numappeloffre" type="text" class="span11" title="numero d'appel d'offre" placeholder="N° Appel d'offre"style="font-size: 12px;" name="NumAppelOffre"/>
              </div>
        </div>

    <div class="control-group row box">
              <label class=" col-md-3" >Objet *:</label>
              <div class="col-md-8">
                <textarea id="<?= $prefix ?>_objet" class="span11" placeholder="Veuillez saisir un objet" style="font-size: 12px;" name="ObjetMarcheTravaux"></textarea>
              </div>
        </div>

       <div class="control-group row box">
              <label class=" col-md-3" >Estimation *:</label>
              <div class="col-md-8">
                <input id="<?= $prefix ?>_estimation" type="number" class="span11" placeholder="Estimation" step="0.01" style="font-size: 12px;" name="EstimationMarcheTravaux"/>
              </div>
        </div>

      <div class="control-group row box">
              <label class=" col-md-3" >Budget *:</label>
              <div class="col-md-8">
              <select class="" id="<?= $prefix ?>_TypeBudget" name="budget">
              <?php foreach($typeBudget->result() as $rowDetail ):?>
                      <option value='<?=$rowDetail->id_type_budget;?>'><?= $rowDetail->libelle_type_budget ?></option>
                  <?php endforeach; ?>

                </select>
            </div>
      </div>

      <div class="control-group row box">
              <label class=" col-md-3" >Date d'ouverture du plis *:</label>
              <div class="col-md-8">
                <input id="<?= $prefix ?>_DateOuverturePlis" type="text" data-date="<?php echo date('yyyy-mm-dd'); ?>" data-date-format="yyyy-mm-dd"   value="<?php echo date('yy-m-d'); ?>" class="datepicker span11" style="font-size: 12px;" name="DateOuverturePlisMarcheTravaux">
                 </div>
            </div>


          <div class="control-group row box">
              <label class=" col-md-3" >N° Marché *:</label>
              <div class="col-md-8">
                <input id="<?= $prefix ?>_Numero" type="text" class="span11" title="numero du marché" placeholder="N° Marché" style="font-size: 12px;" name="NumeroMarcheTravaux"/>
              </div>
        </div>

        <div class="control-group row box">
              <label class=" col-md-3" >Montant marché (ttc) :</label>
              <div class="col-md-8">
                <input id="<?= $prefix ?>_Montant" type="number" class="span11" placeholder="Montant" step="0.01"style="font-size: 12px;" name="MontantMarcheTravaux"/>
              </div>
        </div>
        <div class="control-group row box">
              <label class=" col-md-3" >Date d'engagement :</label>
              <div class="col-md-8">
                <input id="<?= $prefix ?>_DateEngagement" type="text" data-date-format="yyyy-mm-dd" value="" class="datepicker span11"style="font-size: 12px;" name="DateEngagementMarcheTravaux">
                 </div>
            </div>
        <div class="control-group row box">
              <label class=" col-md-3" >Date caution définitive :</label>
              <div class="col-md-8">
                <input id="<?= $prefix ?>_DateCautionDefinitive" type="text" data-date="" data-date-format="yyyy-mm-dd" value="" class="datepicker span11"style="font-size: 12px;" name="DateCautionDefinitiveMarcheTravaux">
                 </div>
            </div>
        <div class="control-group row box">
              <label class=" col-md-3" >Date ordre-service :</label>
              <div class="col-md-8">
                <input id="<?= $prefix ?>_DateOrdreService" type="text" data-date="" data-date-format="yyyy-mm-dd" value="" class="datepicker span11"style="font-size: 12px;" name="DateOrdreServiceMarcheTravaux">
                 </div>
            </div>
        <div class="control-group row box">
              <label class=" col-md-3" >Date achevement-prestation</label>
              <div class="col-md-8">
                <input id="<?= $prefix ?>_DateAchevementPrestation" type="text" data-date="" data-date-format="yyyy-mm-dd" value="" class="datepicker span11"style="font-size: 12px;" name="DateAchevementPrestationMarcheTravaux">
                 </div>
            </div>
        <div class="control-group row box">
              <label class=" col-md-3" >Autres informations :</label>
              <div class="col-md-8">
                <textarea id="<?= $prefix ?>_AutresInformations" class="span11" placeholder="Plus d'informations"style="font-size: 12px;" name="AutresInformationsMarcheTravaux"></textarea>
              </div>
        </div>


          <div class="control-group row box">
              <label class=" col-md-3" >Piéces jointes :</label>
              <div class="col-md-8">
                <div class="uploader" id="uniform-undefined" style="width: 168px;"><input id="<?= $prefix ?>_PiecesJointes"type="file" size="19" style="opacity: 0;"name="userfile"><span class="filename">Aucun fichier</span><span class="action">Choisir fichier</span></div>
              </div>
            </div>



            <div class="form-actions">
            <a type="submit"  id="btnadd" class="btn btn-primary " style="border-radius:5px;  border: 2px solid #006699;">Créer</a>
            <div class="row" >
           <div id="<?= $prefix ?>_results" class="col-sm-6  alert alert-danger hide " style="margin-left:200px;text-align:center;" >
             <span></span>
           </div>
       </div>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>
</div>
<script type="text/javascript">
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-23581568-13', 'auto');
ga('send', 'pageview');

var base_url = '<?php echo base_url(); //you have to load the "url_helper" to use this function ?>';
$('#btnadd').click(function() {

 var NumeroAppelOffre             =  $("#<?= $prefix ?>_numappeloffre").val();
 var Objet          =  $("#<?= $prefix ?>_objet").val();
 var Estimation             =  $("#<?= $prefix ?>_estimation").val();
 var Budget         =  $("#<?= $prefix ?>_TypeBudget").val();
 var DateOuverturePlis        =  $("#<?= $prefix ?>_DateOuverturePlis").val();
 var NumeroMarche           =  $("#<?= $prefix ?>_Numero").val();
 var MontantMarche           =  $("#<?= $prefix ?>_Montant").val();
 var DateEngagement           =  $("#<?= $prefix ?>_DateEngagement").val();
 var DateCautionDefinitive           =  $("#<?= $prefix ?>_DateCautionDefinitive").val();
 var DateOrdreService           =  $("#<?= $prefix ?>_DateOrdreService").val();
 var DateAchevementPrestation           =  $("#<?= $prefix ?>_DateAchevementPrestation").val();
 var AutresInformations           =  $("#<?= $prefix ?>_AutresInformations").val();
 var PiecesJointes           =  $("#<?= $prefix ?>_Piecesjointes").val();
var results_handler =$("#<?= $prefix ?>_results");
 
 /*var results_handler =  $('#_results');
 if(Budget == "null"){
     form_show_resultst(results_handler, 'danger', "Vous selectionez un domaine activité", true);
 }else {*/
   $.ajax({
      type: 'POST',
      url: base_url + 'marcheTr/ajax/Ajouter_marche_travaux',
      data: {NumeroAppelOffre:NumeroAppelOffre,
              Objet:Objet,Estimation:Estimation,
              Budget:Budget,DateOuverturePlis:DateOuverturePlis,
              NumeroMarche:NumeroMarche,MontantMarche:MontantMarche,
              DateEngagement:DateEngagement,DateCautionDefinitive:DateCautionDefinitive,
              DateOrdreService:DateOrdreService,DateAchevementPrestation:DateAchevementPrestation,PiecesJointes:PiecesJointes,
              AutresInformations:AutresInformations},
      dataType: "JSON",
      cache:false,
      success: function(msg){
       if(msg.status == '1'){
         form_show_resultst(results_handler,'info', msg.message, 'true');
         /*setTimeout(function(){
           window.location.href=base_url + 'marcheTr/etab/marchetravauxec';
         }, 2000);*/

       }else if(msg.status == '0'){
          form_show_resultst(results_handler, 'danger', msg.message, true);
       }
      },
      error: function(msg){
        alert('erreur');
      }
   });
 return false;


});



</script>
