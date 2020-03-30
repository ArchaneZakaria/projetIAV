<!DOCTYPE html>

<html lang="en">


<!-- Mirrored from colorlib.com/polygon/gentelella/media_gallery.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Dec 2017 15:47:58 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Iav | Applications </title>

    <!-- Bootstrap -->
    <link href="<?=base_url('assets/vendors/bootstrap/dist/css/bootstrap.min.css')?>" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?=base_url('vendors/font-awesome/css/font-awesome.min.css')?>" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css')?>" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="<?=base_url('build/css/custom.min.css')?>" rel="stylesheet">
    <style type="text/css">
      .bgmaskblurb {
    border-radius: 8px;
    padding: 7px;
    background: url(https://cdn.4uc.org/maskbg.png) left top repeat;
    box-shadow: 0 2px 30px #000;
}

    </style>
  </head>

  <body class="nav-md" style="background-color:#2a3f54">

    <div class="container body">
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>
            </nav>
          </div>
        </div>
          <div class="row">
          <div class="col-md-3 col-sm-3 col-xs-12 col-md-offset-5 col-sm-offset-5 ">
              <div style="clear:both;">&nbsp;</div>
              <div class="bgmaskblurb" style="width:80%;margin-top:20px;margin-left:0%;margin-right:auto;padding:20px;text-align:center;box-shadow: 0px 2px 30px #000000;font-size:24px;color:#fff;">
               DLP
              </div>
              <div style="clear:both;">&nbsp;</div>
              <div style="clear:both;">&nbsp;</div>
              <div style="clear:both;">&nbsp;</div>
          </div>
          <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-2 col-sm-offset-2 " style="width:100%;margin-left:10%">
            <?php foreach ($applications as $key => $value) {
              $block = '';
              $style = '';
              if(!isset($appli_user[$value->id_application])){
                $block = '#';
                $style = "pointer-events: none;opacity: 0.4;";
              }else {
                if($value->nom_application == "SGP"){
                  $block = base_url($value->url_application."/0/".$departement);
                }else {
                $block   = base_url($value->url_application);
                }
                $style = '';
              }
              ?>

              <div class="col-md-4" style="<?= $style ?> width:300px;"  >
                <div class="thumbnail" >
                  <div class="image view view-first" style="text-align:center;" >
                  <a href="#" data="<?= $value->id_application ?>"  class="clss_application"> <img style="width: 100%!important; height: 250px;" src="<?= base_url("uploads/global/".$value->img_application) ?>" alt="image" /> </a>
                  <div class="mask">
                  <p><?= $value->nom_application ?></p>
                  </div>
                  </div>
                  <div class="caption">
                  <p></p>
                  </div>
                  </div>
                  </div>
            <?php  } ?>

          </div>
         </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer style="margin-left:0px;margin-bottom:0px;margin-right:0px;">
          <div class="pull-right">

          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->

    </div>

   <br>

    <!-- jQuery -->
    <script src="<?=base_url('assets/vendors/jquery/dist/jquery.min.js')?>"></script>
    <!-- Bootstrap -->
    <script src="<?=base_url('assets/vendors/bootstrap/dist/js/bootstrap.min.js')?>"></script>
    <!-- FastClick -->
    <script src="<?=base_url('assets/vendors/fastclick/lib/fastclick.js')?>"></script>
    <!-- NProgress -->
    <script src="<?=base_url('assets/vendors/nprogress/nprogress.js')?>"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?=base_url('assets/build/js/custom.min.js')?>"></script>
<!-- Google Analytics -->
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-23581568-13', 'auto');
ga('send', 'pageview');
var base_url = '<?= base_url() ?>';
$(document).on('click','.clss_application',function() {
  var id = $(this).attr('data');
  $.ajax({
     type: 'POST',
     url: base_url + 'connexion/setApplicationId',
    data:{id:id},
   success: function(msg){
    window.location.href=base_url +msg;
   }
   });
});
</script>
  </body>
</html>
