<!DOCTYPE html>
<html lang="en" class="body-full-height">
    <head>
        <!-- META SECTION -->
        <title>IAV - HASSAN II </title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->

        <!-- CSS INCLUDE -->
        <link rel="stylesheet" type="text/css" id="theme" href="<?=base_url()?>/assets/css/theme-default.css"/>
        <link href="<?= base_url('assets/vendors/bootstrap/dist/css/bootstrap.min.css') ?>" rel="stylesheet" id="bootstrap-css">
        <script src="<?= base_url('assets/vendors/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
        <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
        <!-- EOF CSS INCLUDE -->
    </head>
    <body>

        <div class="login-container">

            <div class="login-box animated fadeInDown">
                <!-- <div class="login-logo"></div> -->
                <div class="login-body">
                    <div class="login-title"><strong>Bienvenue</strong>, veuillez à s'authentifier</div>
                    <form action="#" class="form-horizontal"  id='form_login' method="post">
                      <div id="result_errors"></div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="text" class="form-control" placeholder="Username" name="username" id="username" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="password" class="form-control" placeholder="Password" name="password" id="password" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <a href="#" class="btn btn-link btn-block">Mot de passe oublié?</a>
                        </div>
                        <div class="col-md-6">
                            <!-- <span class="btn btn-info btn-block" id="connecter" >Se connecter</span> -->
                            <button type="submit" class="btn btn-info btn-block" id="login_send" >Se connecter</button>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="login-footer">
                    <div class="pull-left">
                        &copy; 2019 IAV Hassan II
                    </div>
                    <div class="pull-right">
                        <a href="#">Apropos</a> |
                        <a href="#">Droit d'auteur</a> |
                        <a href="#">Contactez nous</a>
                    </div>
                </div>
            </div>

        </div>
        <script type="text/javascript">
   //var base_url = '<?= base_url(); ?>';
//    $('#connecter').click(function(){
//
//         window.location.href = base_url;
// });

        </script>


        <script type="text/javascript">
        var base_url = '<?= base_url(); ?>';

        $("#form_login").submit(function functionName(evn) {
          evn.preventDefault();
          //  window.location.href = base_url;
           $.ajax({
              type: 'POST',
              url: base_url + 'connexion/login',
              enctype: 'multipart/form-data',
              data: new FormData(this),
              dataType: "JSON",
              cache:false,
              processData: false,
              contentType: false,
              success: function(msg){
                if(msg.status == 0){
                  erros = '';
                 for(var i = 0; i<msg.message.length; i++){
                   erros = erros + msg.message[i];
                 }
                    $("#result_errors").html("<div  class='alert alert-danger' style='text-align: center;font-weight: bold;font-style: italic;'>"+erros+"</div>");
                  setTimeout(function(){
                    $("#result_errors").html("");
                  },2000);
               }else{
                   $("#result_errors").html("<div  class='alert alert-success' style='text-align: center;font-weight: bold;font-style: italic;'>Connexion</div>");

                   setTimeout(function(){
                      window.location.href=base_url + msg.location;
                   }, 2000);
               }

              }

            });
        });
        </script>


    </body>
</html>
