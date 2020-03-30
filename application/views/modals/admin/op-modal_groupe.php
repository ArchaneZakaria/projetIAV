<!-- ajouter un nouveau groupe -->

  <div class="modal fade" id="modal-add-groupe" tabindex="-1" role="dialog" aria-labelledby="modal-add-groupe" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title">Ajouter un groupe</h3>
                </div>
                <?=  form_open(base_url('administration/groupe/'), array('id' => 'edit-status-form'), array('annee_calendar_id' => '0'))?>
                <div class="modal-body">
                    <div class="row">
                        <div id="modal-edit-status-results" class="col-sm-10 col-sm-offset-1 alert alert-danger hide"><span></span></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-10 col-sm-offset-1">
                            <?= form_label('Nom :', 'groupe_name'); ?>
                            <?= form_input('groupe_name','groupe1', 'class="form-control text-center"') ?>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-sm-10 col-sm-offset-1">
                            <?= form_label('Nom :', 'groupe_description'); ?>
                            <?= form_textarea('groupe_description','groupe description', 'class="form-control text-center" rows=30') ?>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <?=form_submit('submit', 'Enregistrer', 'id="modal-edit-groupe-submit" class="btn btn-lg btn-success"'); ?>
                </div>
                <?=  form_close()?>
            </div>
        </div>
</div>



<!-- ajouter un nouveau groupe -->