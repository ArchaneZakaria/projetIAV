<?php defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/Master.php';

class Ctr_home extends Master
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('Piece_jointe_retraite_model', 'validation');

     $this->load->model('Retraite_model', 'retraite');




    }


    public function index($lang = '')
    {

             $this->display($lang);
             /** verifier l'ouverture de session */
            $this->template->set_partial('container', 'home_view',array());
            $this->template->build('body');



    }

    /**
     * Route vers l table des retraiter en cours
     * Hachim Samir
     */
    public function encours($lang = '')
    {

             $this->display($lang);
             /** verifier l'ouverture de session */
            $this->template->set_partial('container', 'retraite_view',array());
            $this->template->build('body');



    }

    /**
     * Route vers l table des retraiter en cours
     * Hachim Samir
     */
    public function valider($lang = '')
    {

             $this->display($lang);
             /** verifier l'ouverture de session */
            $this->template->set_partial('container', 'vretraite_view',array());
            $this->template->build('body');



    }

     /**
     * Verifier les validation a ajouter pour chaque retraiter
     * Hachim Samir
     */
    public function verifierValidation()
    {
        $ID = $this->input->post('ID');
            $QueryValidation = $this->db->query("SELECT validation.id_validation,
                                                    validation.libelle_validation,
                                                    piece_jointe_retraite.id_validation AS InsertValidation
                                            FROM validation
                                            LEFT JOIN piece_jointe_retraite ON (piece_jointe_retraite.id_validation = validation.id_validation AND
                                                                                piece_jointe_retraite.deleted_piece_jointe_retraite = 'N' AND
                                                                                piece_jointe_retraite.id_retraite = '".$ID."')
                                            WHERE validation.deleted_validation = 'N' ");


            $NumberRow = $this->db->affected_rows();
            $NbrRowsAff = 0;
            foreach($QueryValidation->result() as $rowValidation ){
                if($rowValidation->InsertValidation == $rowValidation->id_validation){
                    $NbrRowsAff+=1;
                }
            ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="checkbox">
                            <label>
                                    <input type="checkbox" style="margin-top:10px;" <?php if($rowValidation->InsertValidation == $rowValidation->id_validation){ echo "disabled"; echo " checked"; } ?> name="Check_<?= $rowValidation->id_validation ?>" value="Check_<?= $rowValidation->id_validation ?>" id="Check_<?= $rowValidation->id_validation ?>">
                                    <h5><?= $rowValidation->libelle_validation ?></h5>
                            </label>
                        </label>
                    </div>
                </div>
            <?php

            }

            if($NumberRow == $NbrRowsAff){
                ?>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label></label><br>
                            <span class="file-input file-input-new"><div class="file-preview ">
                                <div class="close fileinput-remove text-right" id="removepreview-thumb" style="display:block">×</div>
                                <div class="file-preview-thumbnails" id="preview-thumb"> <img id="preview-picture" src="" alt="" style="width:80px; height:80px"></div>
                                <div class="clearfix"></div>
                                <div class="file-preview-status text-center text-success">

                                </div>
                            </div>

                            <div class="btn btn-danger btn-file">
                                <i class="glyphicon glyphicon-folder-open"></i> &nbsp;Telecharger Fichier <input type="file" accept="image/*" id="file-simple">
                            </div>
            </span>
                        </div>
                    </div>
                <?php
            }
    }

    /**
     * Inserer les validation  pour chaque retraiter
     * Hachim Samir
     */
    public function insertValidation(){
        $ID           = $this->input->post('ID');
        $listCheck    = $this->input->post('listCheck');


        parse_str($listCheck, $output);

        $QueryValidation = $this->db->query("SELECT validation.id_validation,
                                                    validation.libelle_validation,
                                                    piece_jointe_retraite.id_validation AS InsertValidation
                                            FROM validation
                                            LEFT JOIN piece_jointe_retraite ON (piece_jointe_retraite.id_validation = validation.id_validation AND
                                                                                piece_jointe_retraite.deleted_piece_jointe_retraite = 'N' AND
                                                                                piece_jointe_retraite.id_retraite = '".$ID."')
                                            WHERE validation.deleted_validation = 'N' ");
        $NumberRow = $this->db->affected_rows();
        $NbrRowsAff = 0;
        $by = 1;
        $date = date('Y-m-d H:i:s');

        foreach($QueryValidation->result() as $rowValidation ){
            $IdValidation = $rowValidation->id_validation;
            if($rowValidation->InsertValidation == $rowValidation->id_validation){

            }else if($rowValidation->InsertValidation != $rowValidation->id_validation){

                    $ValueId = $output['Check_'.$IdValidation];

                if($ValueId == 1){
                    $options=array('id_retraite'                 => $ID,
                               'id_validation'               => $IdValidation,
                               'cby_piece_jointe_retraite'   => $by,
                               'cdate_piece_jointe_retraite' => $date);


                    $this->db->insert('piece_jointe_retraite', $options);

                    echo 1;
                }




            }
        }

    }

    /**
     * Inserer les validation  pour chaque retraiter
     * Hachim Samir
     */
    public function retraiteValidation(){
        $ID           = $this->input->post('ID');
        $FileBlob     = $this->input->post('FileBlob');

        $Status           = 'V';

        $UpdateRetraite = $this->db->set('file_upload_retraite', $FileBlob);
        $UpdateRetraite = $this->db->set('status_retraite'     , $Status);
        $UpdateRetraite = $this->db->where('id_retraite'       , $ID);
        $UpdateRetraite = $this->db->update('retraite');

        echo 1;

    }


    public function verifyUser()	{
		  $this->load->view('vue');
	  }


// This function call from AJAX
public function user_data_submit() {
$data = array(
'username' => $this->input->post('name'),
'pwd'=>$this->input->post('pwd')
);

//Either you can print value or you can send value to database
echo json_encode($data);
}


public function error(){

 $this->load->view('view_404');
}


}
/* End of file home.php */
/* Location: ./application/controllers/home.php */
