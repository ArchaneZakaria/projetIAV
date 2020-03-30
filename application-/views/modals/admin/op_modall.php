
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="modal fade" id="modaldel-id" tabindex="-1" role="dialog" aria-labelledby="op_modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
           <div class="op_modal_results"></div>
            <div class="modal-header" style="background:#5bc0de">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h2 class="modal-title" style="color:#fff;font-size:14px;"></h2>
            </div>
            <div class="modal-body">
               <div class="row" >
                    <div id="results_handler" class="col-sm-6  alert alert-danger hide " style="margin-left:200px;text-align:center;" >
                    <span></span>
                    </div>
                </div>
                <div class="row">
                    <h4 class="op_modal_message col-sm-10 col-sm-offset-1"></h4>
                </div>


               <br/>
              <div class="row" id="nb_pr" >
                 <input type="number" class="form-control nb_pr" name="nb_pr" id="nb_prc"/>
                 <span></span>
              </div>

               <!-- </div>
                <div class="row" style="text-align:center">
                <h4 class="op_modal_message_first col-sm-10 col-sm-offset-1" ></h4>
                <h4 class="op_modal_message_second col-sm-10 col-sm-offset-1" ></h4>
                <h4 class="op_modal_message_thrt col-sm-10 col-sm-offset-1" ></h4>
                <h4 class="op_modal_message_four col-sm-10 col-sm-offset-1" ></h4>
                </div> -->
            </div>
            <div class="modal-footer">
                <?= form_button('op_modal_close', 'Non', 'data-dismiss="modal" class="btn btn-default" id="op_modal_close"'); ?>
                <?= form_button('op_modal_submit', 'Oui', 'id="op_modal_submit" class="btn btn-info"'); ?>
            </div>
        </div>
    </div>
</div>




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
