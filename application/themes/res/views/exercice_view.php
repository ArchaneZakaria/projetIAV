  <h1 class="titrePage"> Exercice </h1>
<div class="container-fluid">

                <form action="#">
                    <div class="form-group row">
                    <div class="span">
                         <input type="text" class="span4" style="height: 35px; font-size: 12px;">
                    </div>
                    <div class="span">
                        <button type="submit" class="btn btn-primary" style="border-radius:5px; border: 2px solid #006699;">Ajouter un Exercice <span class="glyphicon glyphicon-arrow-right"></span></button>
                    </div>
                </div>


                </form>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="widget-box">
                            <div class="widget-title">
                                <span class="icon"><i class="icon-th"></i></span>
                                <h5>Exercice</h5>
                            </div>
                            <div class="widget-content nopadding">
                                <table class="table table-bordered no-footer data-table" role="grid" aria-describedby="dynamic-table_info">
                                    <thead>
                                        <tr class="">
                                            <th>Domaine d'activité</th>
                                            <th>Validation</th>
                                            <th>Option</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="gradeX" style="background-color:green; color: white;">
                                            <td>2010</td>
                                            <td>Non valider</td>
                                            <td>
                                                <p>
                                                    <a href="#" >
                                                        <span class="glyphicon glyphicon-trash" style="color: white;" data-target="#exampleModalCenterA" data-toggle="modal" Title="Supprimer" ></span>
                                                    </a>
                                                    <a href="#" >
                                                        <span class="glyphicon glyphicon-edit green" style="color: white;" Title="Modifier" data-target="#exampleModalCenter" data-toggle="modal"></span>
                                                    </a>
                                                    <a href="#" class="pull-right">
                                                        <button class="btn btn-success btn-sm" Title="Désactiver" style="border-radius:5px;width: 80px; padding: 8px; border: 2px solid #1c6f30 ;">Désactiver</button>
                                                    </a>
                                                </p>
                                            </td>
                                        </tr>
                                        <tr class="gradeX" style="background-color: #BA1E20; color: white;">
                                            <td>2011</td>
                                            <td>Valider</td>
                                            <td>
                                                <p>
                                                    <a href="#" >
                                                        <span class="glyphicon glyphicon-trash red" style="color: white;" data-target="#exampleModalCenterA" data-toggle="modal" Title="Supprimer" ></span>
                                                    </a>
                                                    <a href="#" >
                                                        <span class="glyphicon glyphicon-edit green " style="color: white;" Title="Modifier" data-target="#exampleModalCenter" data-toggle="modal"></span>
                                                    </a>
                                                    <a href="#" class="pull-right">
                                                        <button class="btn btn-danger btn-sm" Title="Activer" style="border-radius:5px;width: 80px; padding: 8px; border: 2px solid #a71f10;">Activer</button>
                                                    </a>
                                                </p>
                                            </td>
                                        </tr>
                                        <tr class="gradeX" style="background-color: #BA1E20; color: white;">
                                            <td>2012</td>
                                            <td>Non valider</td>
                                            <td>
                                                <p>
                                                    <a href="#" >
                                                        <span class="glyphicon glyphicon-trash red" style="color: white;" data-target="#exampleModalCenterA" data-toggle="modal" Title="Supprimer" ></span>
                                                    </a>
                                                    <a href="#" >
                                                        <span class="glyphicon glyphicon-edit green" style="color: white;" Title="Modifier" data-target="#exampleModalCenter" data-toggle="modal"></span>
                                                    </a>
                                                    <a href="#" class="pull-right">
                                                        <button class="btn btn-danger btn-sm"  Title="Activer" style="border-radius:5px;width: 80px; padding: 8px; border: 2px solid #a71f10;">Activer</button>
                                                    </a>
                                                </p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <script>
                                    $('.gradeX .btn').on('click',function(){
                                        if(this.classList.contains('btn-danger')){
                                            //script qui permet d'activer ce domaine dans la base des donnée et désactiver le domaine activé\naprès refrecher la listewq
                                        }else if(this.classList.contains('btn-success')){
                                            //script qui permet de désactiver ce domaine dans la base des donnée\naprès refrecher la liste
                                        }
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pièce jounte modal -->

        <!-- Prestataire modal -->


        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="margin:auto;width:100%;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Modifier Prestataire</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                      <div class="control-group">
                            <label class="control-label">Prestataire</label>
                            <div class="controls">
                                <input type="text" name="Ordre" class="form-control"  placeholder="Nom et prenom"style="height: 30px;width: 509px;font-size: 12px;" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Email</label>
                            <div class="controls">
                                <input type="Email" name="Ordre" class="form-control"  placeholder="Email" style="height: 30px;width: 509px;font-size: 12px;"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Tel</label>
                            <div class="controls">
                                <input type="text" name="Ordre" class="form-control"  placeholder="Numéro de téléphone"style="height: 30px;width: 509px;font-size: 12px;" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Ville</label>
                            <div class="controls">
                                <input type="text" name="Ordre" class="form-control"  placeholder="Ville"style="height: 30px;width: 509px;font-size: 12px;" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Domaine d'activité</label>
                            <div class="controls">
                                <select class="browser-default custom-select">
                                    <option selected>Selectionner un Service</option>
                                    <option value="1">Ordre de service</option>
                                    <option value="2">Achevement de service</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-primary">Enregistrer</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenterA" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="margin:auto;width:100%;">
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
