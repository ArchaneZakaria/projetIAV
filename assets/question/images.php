<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Images - Questionnaire</title>
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
                position: relative;
            }
            .reponses div {
                width: 98px;
                height: 98px;
                margin: 4px 2px;
                display: inline-block;
                position: relative;
            }
            .reponses div img {
                width: 100%;
                height: 100%;
            }
            .reponses div .active {
                background: url('images/active.png');
                width: 20px;
                height: 20px;
                position: absolute;
                display: inline-block;
                background-size: 100%;
            }
            .button {
                background-color: #296112;
                color: #fff;
                padding: 10px;
                margin: auto 40%;
                text-align: center
            }
        </style>
    </head>
    <body>

        <div class="page">
            <div class="question">
                <p>Quel est le nom du président des état unis d'amérique ?</p>
                <span>Choisissez la bonne réponse</span>
            </div>
            <div class="reponses">
                <div><img src="images/rabat.jpg" ><div class="active"/></div>
                <div><img src="images/suede.jpg" ></div>
                <div><img src="images/london.jpg" ></div>
                <div><img src="images/paris.jpg" ></div>
                <div><img src="images/dubai.jpg" ></div>
            </div>
            <input type="hidden" name="reponse_id" id="reponse_id" value="0" />
            <div class="button">Valider</div>
            <div class="result"></div>
        </div>

        <script type="text/javascript">
            var index = 0;
            $( document ).ready(function() {                
                $('.reponses div').click(function() {
                    index = $(this).index();
                    index++;
                    $('#reponse_id').val(index)
                    $('.reponses div').removeClass('active');
                    $(this).addClass('active');
                });
                
                $('.button').click(function() {
                    var id = $('#reponse_id').val();
                    $('.result').html(id);
                });
                
            });
        </script>

    </body>
</html>
