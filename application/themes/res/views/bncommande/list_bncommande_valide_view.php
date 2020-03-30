<h1 class="titrePage">Bons de commande validé</h1>
<div class="container-fluid">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="widget-box">
                            <div class="widget-title">
                                <span class="icon"><i class="icon-th"></i></span>
                                <h5>Les bons de commande Validé</h5>
                            </div>
                            <div class="widget-content nopadding">
                                <table class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="dynamic-table_info">
                                    <thead>
                                    <tr>
                                        <th>N° BC</th>
                                        <th>Objet</th>
                                        <th>Intitulé</th>
                                        <th>Demandeur</th>
                                        <th>Entité</th>
                                        <th>Date de demarrage de projet</th>
                                        <th></th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="gradeX">
                                            <td>Trident</td>
                                            <td>Internet Explorer 4.0</td>
                                            <td>Win 95+</td>
                                            <td class="center">4</td>
                                            <td class="center">4</td>
                                            <td class="center">4</td>
                                            <td class="center">
                                                <div class="">
                                                    <p>
                                                        <a href="#">
                                                            <span class="glyphicon glyphicon-thumbs-down red" data-target="#exampleModalCenterA" data-toggle="modal" Title="Annuler" ></span>
                                                        </a>
                                                        <a href="#">
                                                          <span class="glyphicon glyphicon-chevron-up blue linev" Title="ligne de vie"></span>
                                                        </a>
                                                        <a href="#">
                                                            <span class="glyphicon glyphicon-saved green valider" Title="Valider" ></span>
                                                        </a>
                                                        <a href="#">
                                                            <span class="glyphicon glyphicon-plus frns " Title="Pièce jointe" data-target="#exampleModalPieceJointe"  data-toggle="modal">Pj</span>
                                                        </a>
                                                        <a href="#">
                                                            <span class="glyphicon glyphicon-ok green " Title="Valider" data-target="#exampleModalValider"  data-toggle="modal"></span>
                                                        </a>
                                                        <a href="#">
                                                            <span class="glyphicon glyphicon-trash red" data-target="#exampleModalDelete" data-toggle="modal" Title="Supprimer" ></span>
                                                        </a>
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="gradeX">
                                            <td>Trident</td>
                                            <td>Internet Explorer 4.0</td>
                                            <td>Win 95+</td>
                                            <td class="center">4</td>
                                            <td class="center">4</td>
                                            <td class="center">4</td>
                                            <td class="center">
                                                <div class="">
                                                    <p>
                                                        <a href="#">
                                                            <span class="glyphicon glyphicon-thumbs-down red" data-target="#exampleModalCenterA" data-toggle="modal" Title="Annuler" ></span>
                                                        </a>
                                                        <a href="#">
                                                          <span class="glyphicon glyphicon-chevron-up blue linev" Title="ligne de vie"></span>
                                                        </a>
                                                        <a href="#">
                                                            <span class="glyphicon glyphicon-saved green valider" Title="Valider" ></span>
                                                        </a>
                                                        <a href="#">
                                                            <span class="glyphicon glyphicon-plus frns " Title="Pièce jointe" data-target="#exampleModalPieceJointe"  data-toggle="modal">Pj</span>
                                                        </a>
                                                        <a href="#">
                                                            <span class="glyphicon glyphicon-ok green " Title="Valider" data-target="#exampleModalValider"  data-toggle="modal"></span>
                                                        </a>
                                                        <a href="#">
                                                            <span class="glyphicon glyphicon-trash red" data-target="#exampleModalDelete" data-toggle="modal" Title="Supprimer" ></span>
                                                        </a>
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr  id="TR_111" style="display:none;">
                                            <td colspan="7" >
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
                                                            <th>Fournisseur</th>
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
                                                            <td class="hidden-480 open-button" style="text-align: center;">
                                                                <span class="label label-success" onclick="openFormP()">MUNISYS</span>
                                                                <div class="form-popup" id="praistataireform">
                                                                    <form action="/action_page.php" class="form-container">
                                                                        <h1>Details</h1>
                                                                        <div style="text-align:justify;min-width:400px;color:#000;">Tous details sur la fournisseur</div>
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
                                                            <td class="hidden-480 open-button" style="text-align: center;">
                                                                <div>
                                                                    <a href="file1.txt" style="color: black;">File 1</a><br>
                                                                    <a href="file2.txt" style="color: black;">File 2</a><br>
                                                                    <a href="file3.txt" style="color: black;">File 3</a><br>
                                                                    <a href="file1.txt" style="color: black;">File 1</a><br>
                                                                    <a href="file2.txt" style="color: black;">File 2</a><br>
                                                                    <a href="file3.txt" style="color: black;">File 3</a><br>
                                                                </div>
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
                                        <tr class="lineVErs" style="display:none;">
                                            <td colspan="7">
                                                <div class="tracking-content"><span>Cycle de vie de projet</span></div>
                                                <div class="tracking-item">
                                                    <div class="tracking-icon status-intransit">
                                                        <svg class="svg-inline--fa fa-circle fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path>
                                                        </svg>
                                                        <!-- <i class="fas fa-circle"></i> -->
                                                    </div>
                                                    <div class="tracking-date">Jul 09, 2018<span>11:04 AM</span></div>
                                                    <div class="tracking-content">SA<span>Service d'approvisionnement</span></div>
                                                </div>
                                                <div class="tracking-item">
                                                    <div class="tracking-icon status-intransit">
                                                        <svg class="svg-inline--fa fa-circle fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                           <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path>
                                                        </svg>
                                                        <!-- <i class="fas fa-circle"></i> -->
                                                    </div>
                                                    <div class="tracking-date">Jul 09, 2018<span>10:09 AM</span></div>
                                                    <div class="tracking-content">DL<span>Division logistique</span></div>
                                                </div>
                                                <div class="tracking-item">
                                                    <div id="redicon" class="tracking-icon status-intransit">
                                                        <svg class="svg-inline--fa fa-circle fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path>
                                                        </svg>
                                                        <!-- <i class="fas fa-circle"></i> -->
                                                    </div>
                                                    <div><a href="#"><i  class="glyphicon glyphicon-arrow-up red" title="alerter" data-toggle="modal" data-target="#alerteModal"></i></a></div>
                                                    <div class="tracking-date">Jul 06, 2018<span>02:02 PM</span></div>
                                                    <div class="tracking-content">SG<span>Secretariat général</span></div>
                                                </div>
                                                <div class="tracking-item">
                                                    <div id="gryicon" class="tracking-icon status-intransit">
                                                        <svg class="svg-inline--fa fa-circle fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path>
                                                        </svg>
                                                      <!-- <i class="fas fa-circle"></i> -->
                                                   </div>
                                                   <div class="tracking-date">Jul 06, 2018<span>02:02 PM</span></div>
                                                   <div class="tracking-content">DG<span>Direction générale</span></div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="exampleModalValider" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="margin:auto;width:100%;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">L'état d'offre</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="control-group">
                            <label class="control-label">L'état d'offre</label>
                            <div class="controls">
                                <select class="browser-default custom-select">
                                    <option selected>Sélectionner l'état d'offre</option>
                                    <option value="1">Validé</option>
                                    <option value="2">Réceptionné</option>
                                </select>
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
        <div class="modal fade" id="exampleModalDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="margin:auto;width:100%;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Attention</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="control-group">
                            <label class="control-label">Vous voulez vraiment supprimer ?</label>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-primary">Oui</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pièce jounte modal -->
        <div class="modal fade" id="exampleModalPieceJointe" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="margin:auto;width:100%;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Pièce jointe</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="control-group">
                            <label class="control-label">Nom</label>
                            <div class="controls">
                                <input type="text" name="titreAlerte" class="form-control" style="height: 40px;" />
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Pièce(s) jointe(s)</label>
                            <div class="controls">

                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" multiple class="custom-file-input">
                                        <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Details</label>
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

        <!-- Forunisseur modal -->
        <div class="modal fade" id="exampleModalFournisseur" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="margin:auto;width:100%;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">FR</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="control-group">
                            <label class="control-label">Fournisseur</label>
                            <div class="controls">
                                <select class="browser-default custom-select">
                                    <option selected>Selectionner le fournisseur retenu</option>
                                    <option value="1">DL</option>
                                    <option value="2">SG</option>
                                    <option value="1">DL</option>
                                    <option value="2">SG</option>
                                    <option value="1">DL</option>
                                    <option value="2">SG</option>
                                </select>
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
