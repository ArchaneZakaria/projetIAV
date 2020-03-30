<h1 class="titrePage">Marché travaux</h1>
<div class="container-fluid"><button class="btn btn-primary" style="border-radius:5px; border: 2px solid #006699;" type="submit"  data-target="#exampleModalAjouter" data-toggle="modal">Ajouter</button>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="widget-box">
                            <div class="widget-title">
                                <span class="icon"><i class="icon-th"></i></span>
                                <h5>Les phases de marché travaux</h5>
                            </div>
                            <div class="widget-content nopadding">
                                <table class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="dynamic-table_info">
                                    <thead>
                                    <tr>
                                        <th>Phase</th>
                                        <th>Ordre</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="gradeX">
                                            <td class="col-md-6" style="text-align:center;">Brouillon</td>
                                            <td><div class="controls col-md-6"style="margin-left: 30%;">
                                              <input type="number" class="span11 " value="1" style="text-align:center;" />
                                           </div></td>
                                        </tr>
                                        <tr class="gradeX">
                                            <td class="col-md-6" style="text-align:center;">Enregistré</td>
                                            <td><div class="controls col-md-6" style="margin-left: 30%;">
                                              <input type="number" class="span11 " value="2" style="text-align:center;" />
                                           </div></td>
                                        </tr>
                                        <tr class="gradeX">
                                            <td class="col-md-6" style="text-align:center;">Receptionnés</td>
                                            <td><div class="controls col-md-6  "style="margin-left: 30%;">
                                              <input type="number" class="span11 " value="3" style="text-align:center;" />
                                           </div></td>
                                        </tr>
                                    </tbody>
                                </table>

            
              
            
                            </div>
                        </div><button class="btn btn-primary" style="border-radius:5px; border: 2px solid #006699;float: right;" type="submit" data-target="#exampleModalAjouter" data-toggle="modal">Modifier</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Forunisseur modal -->
        <div class="modal fade" id="exampleModalAjouter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="margin:auto;width:100%;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Ajouter une phase aux marché travaux</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="control-group">
                            <label class="control-label">Phase</label>
                            <div class="controls">
                                <select class="browser-default custom-select">
                                    <option >Selectionner la phase</option>
                                    <option value="1">DL</option>
                                    <option value="2">SG</option>
                                    <option value="1">DL</option>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Ordre</label>
                            <div class="controls">
                                <input type="number" name="Ordre" class="form-control" style="height: 30px;width: 509px;" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-primary">Ajouter</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="margin:auto;width:100%;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Reponse</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="control-group">
                            <label class="control-label">Destinataire</label>
                            <div class="controls">
                                <select class="browser-default custom-select">
                                    <option selected>Selectionner le destinataire</option>
                                    <option value="1">DL</option>
                                    <option value="2">SG</option>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Response</label>
                            <div class="controls">
                                <textarea style="width:100%; "></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-primary">Enregistrers</button>
                    </div>
                </div>
            </div>
        </div>

        
        <!-- notification -->
        <script>
            $(document).ready(function(){
                $( ".del" ).click(function(e) {
                    e.preventDefault();
                    $('#TR_111').hide();
                });

                $( ".valider" ).click(function(e) {
                    e.preventDefault();
                    $('#TR_111').show();
                });

                $( ".linev" ).click(
                    function(){
                        if($(this).hasClass('glyphicon-chevron-up')){
                         $(this).removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
                         $('.lineVErs').show();

                        }else{
                          $(this).removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
                          $('.lineVErs').hide();

                        }
                    }
                );
            });
            /*** sous menu **/
$(document).ready(function(){
  $('.dropdown-submenu a.test').on("click", function(e){
    $(this).next('ul').toggle();
    e.stopPropagation();
    e.preventDefault();
  });
});

/*** sous menu **/

        </script>