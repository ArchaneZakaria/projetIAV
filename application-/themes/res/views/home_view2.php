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
<?php
$SelectRetrait = $this->db->query("SELECT retraite.id_retraite,
                                          DATEDIFF(CURRENT_DATE, retraite.date_naissance_retraite)/365 AS AgeCalcule,
                                          DATE_ADD(retraite.date_naissance_retraite,INTERVAL (parametre.age_retraite_parametre) YEAR) AS DateRetraite,
                                          DATE_SUB( DATE_ADD(retraite.date_naissance_retraite,INTERVAL (parametre.age_retraite_parametre) YEAR),INTERVAL 3 MONTH) AS DateNotification
                                  FROM retraite
                                  JOIN regime ON (regime.id_regime = retraite.id_regime AND regime.deleted_regime = 'N')
                                  JOIN parametre ON (regime.id_regime = parametre.regime AND
                                                     (YEAR(retraite.date_naissance_retraite) BETWEEN SUBSTRING(parametre.condition_parametre,1,4) AND SUBSTRING(parametre.condition_parametre,6,4)) AND
                                                     ((DATEDIFF(CURRENT_DATE, retraite.date_naissance_retraite)/365) >= parametre.age_retraite_parametre))
                                  WHERE retraite.deleted_retraite = 'N' AND
                                        retraite.status_retraite = 'N'");
foreach($SelectRetrait->result() as $rowSelectRetrait){
    $DateRetraite     = $rowSelectRetrait->DateRetraite;
    $Status           = 'E';
    $DateNotification = $rowSelectRetrait->DateNotification;
    $IdRetraite       = $rowSelectRetrait->id_retraite;

    $Etat = "O";
    $UpdateRetraite = $this->db->set('date_depart_retraite', $DateRetraite);
    $UpdateRetraite = $this->db->set('status_retraite'     , $Status);
    $UpdateRetraite = $this->db->set('date_notif_retraite' , $DateNotification);
    $UpdateRetraite = $this->db->where('id_retraite'       , $IdRetraite);
    $UpdateRetraite = $this->db->update('retraite');
}

?>
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
                                                              retraite.status_retraite ='N'");
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
                                <a class="item-del red" href="#" data="<?= $rowDetail->id_retraite ?>" dat="benabbes@gmail.com">
                                   <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                </a>
                                <a class="item-edit green" href="<?=base_url('etablissement/etab/edit/'.$rowDetail->id_retraite)?>" data="<?= $rowDetail->id_retraite ?>" dat="benabbes@gmail.com">
                                   <i class="ace-icon fa fa-edit bigger-130"></i>
                                </a>
                                <a class="item-edit green" href="<?=base_url('etablissement/etab/edit/'.$rowDetail->id_retraite)?>" data="<?= $rowDetail->id_retraite ?>" dat="benabbes@gmail.com">
                                   <i class="fa fa-paypal bigger-130"></i>
                                </a>
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
} );
</script>




<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ajout d'un retrait&eacute;</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form class="md-form">
      <div class="file-field">

        <div class="d-flex justify-content-center">
          <div class="btn btn-mdb-color btn-rounded float-left">

            <input type="file">
          </div>
        </div>
      </div>
    </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>


                </div>
                <!-- END PAGE CONTENT WRAPPER -->
