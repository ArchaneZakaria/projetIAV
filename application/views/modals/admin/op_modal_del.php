<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Modal -->
<div class="modal fade" id="modaldel-id" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="margin:auto;width:100%;">
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

                <div id="domaine_result" class="col-sm-6  alert alert-danger hide " style="margin-left:200px;text-align:center;" >
                  <span></span>
                </div>

                <div class="row" style="text-align: center;">
                <h4 class="op_modal_message_titre col-sm-10 col-sm-offset-1" ></h4>
                </div>
        </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" id="op_modal_submit">Oui</button>
            </div>
        </div>
    </div>
</div>
