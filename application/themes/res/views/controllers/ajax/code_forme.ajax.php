

jQuery.extend(jQuery.validator.messages, {
    required: "",
    remote: "Corriger ce champ.",
    email: "Saisir Email valide.",
    url: "entrer URL valide.",
    date: "Entrer une date valide.",
    dateISO: "Entrer une date valide(ISO).",
    number: "Entrer un nombre valide.",
    digits: "Entrer seulement ds chiffres.",
    creditcard: "Entrer un numéro de carte de crédit valide.",
    equalTo: "Veuillez entrer à nouveau la même valeur.",
    accept: "Entrer une valeur avec une extension valide.",
    maxlength: jQuery.validator.format("Merci de ne pas entrer plus de {0} caractères."),
    minlength: jQuery.validator.format("Merci de ne pas entrer moins de {0} caractères."),
    rangelength: jQuery.validator.format("Merci de saisir une valeur entre {0} et {1} caractères long."),
    range: jQuery.validator.format("Please enter a value between {0} and {1}."),
    max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
    min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
});




    $('#form-crud').validate({
        rules: {
            <?= $prefix ?>_name: {
                minlength: 3,
                maxlength: 15,
                required: true
            },
            <?= $prefix ?>_designation: {
                minlength: 3,
                maxlength: 15,
                required: true
            }
        },
        messages: {
         <?= $prefix ?>_name: "Enter Nom d'etablissement",
         <?= $prefix ?>_designation: "Enter Designation d'etablissement",
        <?= $prefix ?>_name: {
            required: "Enter a username",
            minlength: jQuery.format("Enter at least {0} characters"),
            remote: jQuery.format("{0} is already in use")
        }
    },
        highlight: function(element) {
             $(element).parent().is('.has-success, .has-error') ?
        $(element).parent().removeClass('has-success').addClass('has-error') :
        $(element).wrap('<span class="has-error"></span>');

        },
        unhighlight: function(element) {
            $(element).closest("input").removeClass('has-error');
        },

        messages: {
        'etablissement_name': {
            required: "Enter your First Name.",
            maxlength: "Your First Name cannot exceed 200 characters"
        },
        'etablissement_designation': {
            required: "Enter your Last Name.",
            maxlength: "Your Last Name cannot exceed 200 characters"
        }
    },
    submitHandler : function(form) {

var base_url = '<?php echo base_url(); //you have to load the "url_helper" to use this function ?>';
 var results_handler = $('#<?= $prefix ?>_results');

    //do something here
var name = $('#etablissement_name').val();
var designation  = $('#etablissement_designation').val();
var ville  = $('#etablissement_ville').val();

alert(base_url);


 $.ajax({
                type: 'POST',
                url: base_url + 'ajax/etablissement_ajax/ajouter',
                data: $('#form-crud').serialize(),
                success: function(response) {
                  alert('1');
                }

            });



        $("#form-crud").ajaxSubmit({
            url:base_url + 'ajax/etablissement_ajax/ajouter',
            type:"post",
             data: $('#form-crud').serialize(),
            success: function(data,status){
              alert('ee');
            },error; fuction(data){
              alert('error');
            }
        });


}
  /*submitHandler*/



    /*validate*/


    });  /*load jquery*/
