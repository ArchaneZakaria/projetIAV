<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="modal fade" id="op_modal" tabindex="-1" role="dialog" aria-labelledby="op_modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title"></h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div id="op_modal_results" class="col-sm-10 col-sm-offset-1 alert alert-danger hide"><span></span></div>
                </div>
                <div class="row">
                    <h4 class="op_modal_message col-sm-10 col-sm-offset-1"></h4>
                </div>
            </div>
            <div class="modal-footer">
                <?= form_button('op_modal_close', 'Non', 'data-dismiss="modal" class="btn btn-default"'); ?>
                <?= form_button('op_modal_submit', 'Oui', 'id="op_modal_submit" class="btn btn-info"'); ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#op_modal').on('hidden.bs.modal', function() {
            reset_cb_on_table();
        });
    });
</script>
