<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Texte - Questionnaire</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <style>
            body {
                font-weight: bold;
                padding: 10px;
            }
            .question span {
                font-size: 12px;
                font-weight: 100;
            }
            .reponses {
                counter-reset: lik-counter;
            }
            .reponses div {
                text-align: center;
                border: 1px solid #54c2fa;
                margin: 20px;
                padding: 10px 0;
            }
            .reponses div:before {
                content: counter(lik-counter, upper-latin);
                counter-increment: lik-counter;
                float: left;
                color: #54c2fa;
                padding-left: 15px
            }
            .reponses .active, .reponses .active:before {
                background-color: #54c2fa;
                color: #fff;
            }
            .button {
                background-color: #296112;
                color: #fff;
                padding: 10px;
                margin: auto 40%;
                text-align: center
            }
        </style>
        <script type="text/javascript">
            var site_url = 'http://lik.aramobile.com/';
            var index = 0;
        </script>
    </head>
    <body>

        <div class="page">
            <div id="alert" class="alert" style="display: none;">Message</div>
            <div class="question">
                <p>Quel est le nom du président des état unis d'amérique ?</p>
                <span>Choisissez la bonne réponse</span>
            </div>
            <div class="reponses">
                <div>James Bond</div>
                <div>Barack Obama</div>
                <div>Nilson Mandella</div>
                <div>Une personne</div>
            </div>
            <div class="result"></div>
            <div class="button">Valider</div>
            <form action="" method="" id="form_interactive">
                <input type="hidden" name="reponse" id="reponse" value="0" />
                <input type="hidden" name="membre" id="membre" value="5" />
                <input type="hidden" name="push_id" id="push_id" value="7" />
            </form>
        </div>

        <script type="text/javascript">
            $( document ).ready(function() {                
                $('.reponses div').click(function() {
                    var trv = $(this).hasClass('active');
                    if(trv){
                        $('#reponse_id').val(0);
                        $('.reponses div').removeClass('active');
                    } else {
                        index = $(this).index();
                        index++;
                        $('#reponse').val(index);
                        $('.reponses div').removeClass('active');
                        $(this).addClass('active');                        
                    }
                    
                });
                
                $('.button').click(function() {
                    var id = $('#reponse').val();
                    $('.result').html(id);
                    if(id == '0'){
                        alert_lik('warning', 'Merci de choisir une réponse');
                        console.log('Merci de choisir un choix');
                        return false;
                    }
                    var page = $('.page');
                    var form = $('#form_interactive');
                    $.ajax({
                        url: site_url + 'ajax_push/op_question',
                        type: 'POST',
                        data: form.serialize(),
                        dataType: 'json',
                        //jsonp:"mycallback",
                        beforeSend: function (x) {
                            page.css('opacity', '0.4');
                        },
                        success: function (msg) {
                            alert_lik('success', 'Votre réponse à été envoyé avec succés, Merci!');
                            console.log(msg);
                            if (msg.status === '302') { // Redirection
                                //window.location.href = 'back.php';
                            }
                            else {  // Validation form errors
                                page.css('opacity', '1');
                            }
                        },
                        error: function (error) {
                            page.css('opacity', '1');
                            alert_lik('danger', 'Erreur!!!');
                            console.log(error);
                        }
                    });
                    
                    
                    function alert_lik(type, message){
                        $('#alert').addClass('alert-' + type);
                        $('#alert').html(message);
                        $('#alert').fadeIn( "slow");
                        setTimeout(
                        function(){
                            $('#alert').fadeOut( "slow", function() {
                                $('#alert').removeClass('alert-' + type);
                            });  
                        }
                        , 3000);
                    }
                    
                    
                    
                });
                
            });
        </script>

    </body>
</html>
