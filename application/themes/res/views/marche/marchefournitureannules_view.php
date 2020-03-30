<h1 class="titrePage">Marché fourniture </h1>
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="widget-box">
                            <div class="widget-title">
                                <span class="icon"><i class="icon-th"></i></span>
                                <h5>Marcher fourniture annulés</h5>
                            </div>
                            <div class="widget-content nopadding">
                                <table class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="dynamic-table_info">
                                    <thead>
                                    <tr>
                                        <th>N° AO</th>
                                        <th>N° Marché</th>
                                        <th>Objet</th>
                                        <th>Prestataires</th>
                                        <th>Estimation</th>
                                        <th>Phase</th>
                                        <th>Date overture</th>
                                        <th>Montant</th>
                                        <th>Date d'engagement</th>
                                        <th>Date d'exécution</th>
                                        <th>Date d'echauvement</th>
                                        <th></th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="gradeX">
                                            <td>092012</td>
                                            <td>12</td>
                                            <td>Internet Explorer 4.0</td>                                        
                                            <td>Préstataires 1</td>
                                            <td>100000</td>
                                            <td class="center">Phase 1</td>
                                            <td class="center">19/05/2000</td>
                                            <td class="center">400000</td>
                                            <td class="center">19/06/2000</td>
                                            <td class="center">19/05/2001</td>
                                            <td class="center">19/05/2001</td>                                            
                                            <td class="center">
                                                <div class="">
                                                    <p>
                                                        <a href="#">
                                                            <span class="glyphicon glyphicon-saved green valider" Title="Valider" ></span>
                                                        </a>
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="gradeX">
                                            <td>092012</td>
                                            <td>92</td>
                                            <td>Mozilla</td>
                                            <td>Préstataires 2</td>
                                            <td>84300</td>
                                            <td class="center">Phase 1</td>
                                            <td class="center">19/05/2007</td>
                                            <td class="center">90200</td>
                                            <td class="center">19/06/2009</td>
                                            <td class="center">19/05/2011</td>
                                            <td class="center">19/05/2012</td>                                            
                                            <td class="center">
                                                <div class="">
                                                    <p>
                                                        <a href="#">
                                                            <span class="glyphicon glyphicon-saved green valider" Title="Valider" ></span>
                                                        </a>
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr  id="TR_111" style="display:none;">
                                            <td colspan="13">
                                                <table class="table  table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Précedesseur</th>
                                                            <th>Remarque></th>
                                                            <th>>Reponse </th>
                                                            <th>Date d'entrée</th>
                                                            <th>Durée</th>
                                                            <th>Suivant</th>
                                                            <th>Attachés</th>
                                                            <th>Prestataire</th>
                                                            <th>Pièce Jointe</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="hidden-480" >SA</td>
                                                            <td  class="hidden-480" >element manquant</td>
                                                            <td  class="hidden-480">tout est OK</td>
                                                            <td  class="hidden-480">30/01/2020 à 20:20</td>
                                                            <td  class="hidden-480">4H</td>
                                                            <td  class="hidden-480">DL</td>
                                                            <td  class="hidden-480">Attaché</td>                                                            
                                                            <td class="hidden-480 open-button" style="padding-left:100px;">
                                                                <span class="label label-success" onclick="openFormP()">MUNISYS</span>
                                                                <div class="form-popup" id="praistataireform">
                                                                    <form action="/action_page.php" class="form-container">
                                                                        <h1>Details</h1>
                                                                        <div style="text-align:justify;min-width:400px;color:#000;">Tous details sur la prestataire</div>
                                                                        <button type="button" class="btn cancel" onclick="closeFormP()">Fermer</button>
                                                                    </form>
                                                                </div>
                                                                <script>
                                                                    function openFormP() {
                                                                        document.getElementById("piecesjointes").style.display = "none";
                                                                        document.getElementById("praistataireform").style.display = "block";
                                                                    }

                                                                    function closeFormP() {
                                                                        document.getElementById("praistataireform").style.display = "none";
                                                                    }
                                                                </script>
                                                            </td>
                                                            <td class="hidden-480 open-button" style="padding-left:100px;">
                                                                <span class="label label-success" onclick="openFormPiecesJointes()">MUNISYS</span>
                                                                <div class="form-popup" id="piecesjointes">
                                                                    <form action="/action_page.php" class="form-container">
                                                                        <h1>Details</h1>
                                                                        <div style="text-align:justify;min-width:400px;color:#000;">Tous details sur les pièces jointes</div>
                                                                        <button type="button" class="btn cancel" onclick="closeFormPiecesJointes()">Fermer</button>
                                                                    </form>
                                                                </div>
                                                                <script>
                                                                    function openFormPiecesJointes() {
                                                                        document.getElementById("praistataireform").style.display = "none";
                                                                        document.getElementById("piecesjointes").style.display = "block";
                                                                    }

                                                                    function closeFormPiecesJointes() {
                                                                        document.getElementById("piecesjointes").style.display = "none";
                                                                    }
                                                                </script>
                                                            </td>
                                                            <td>
                                                                <div class="hidden-480">
                                                                    <i class="glyphicon glyphicon-remove red del"  id="HideCache" name="111"></i>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
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

        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenterA" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="margin:auto;width:100%;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Remarque</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="control-group">
                            <label class="control-label">Remarque</label>
                            <div class="controls">
                                <textarea style="width:100%; "></textarea>
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
