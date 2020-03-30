<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- META SECTION -->
        <title>Application de retraite</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->

        <!-- CSS INCLUDE -->
        <link rel="stylesheet" type="text/css" id="theme" href="<?=base_url('assets') ?>/css/theme-default.css"/>
        <!-- Bootstrap -->
        <link href="<?=base_url('assets/vendors/bootstrap/dist/css/bootstrap.min.css')?>" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="<?=base_url('assets/vendors/font-awesome/css/font-awesome.min.css')?>" rel="stylesheet">

        <!-- Custom Theme Style -->
        <link href="<?=base_url('assets/build/css/custom.min.css')?>" rel="stylesheet">
          <link href="<?=base_url('assets/build/css/bootstrap-select.min.css')?>" rel="stylesheet">
          <link href="<?=base_url('assets/build/css/custom.min.css')?>" rel="stylesheet">
        <!-- EOF CSS INCLUDE -->

<!-- script personnelle -->
<!-- <script src="<?=base_url('assets')?>/js/main.js"></script> -->
 <!-- admin style -->

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <script>
            var base_url = '<?= base_url() ?>';
            var site_url = '<?= site_url() ?>';
        </script>


        <?php if (isset($template['metadata'])) echo $template['metadata']; ?>
    </head>
    <body>


          <div class="page-container">

            <?php if (isset($template['body'])) echo $template['body']; ?>
          </div>
          <!-- END PAGE CONTAINER -->



       <!-- START PRELOADS -->
       <audio id="audio-alert" src="<?=base_url('assets') ?>/audio/alert.mp3" preload="auto"></audio>
       <audio id="audio-fail" src="<?=base_url('assets') ?>/audio/fail.mp3" preload="auto"></audio>
       <!-- END PRELOADS -->

   <!-- START SCRIPTS -->
       <!-- START PLUGINS -->
       <script type="text/javascript" src="<?=base_url('assets') ?>/js/plugins/jquery/jquery.min.js"></script>
       <script type="text/javascript" src="<?=base_url('assets') ?>/js/plugins/jquery/jquery-ui.min.js"></script>
       <script type="text/javascript" src="<?=base_url('assets') ?>/js/plugins/bootstrap/bootstrap.min.js"></script>
       <!-- END PLUGINS -->

       <!-- START THIS PAGE PLUGINS-->
       <script type='text/javascript' src='<?=base_url('assets') ?>/js/plugins/icheck/icheck.min.js'></script>
       <script type="text/javascript" src="<?=base_url('assets') ?>/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
       <script type="text/javascript" src="<?=base_url('assets') ?>/js/plugins/scrolltotop/scrolltopcontrol.js"></script>

       <script type="text/javascript" src="<?=base_url('assets') ?>/js/plugins/morris/raphael-min.js"></script>
       <script type="text/javascript" src="<?=base_url('assets') ?>/<?=base_url('assets') ?>/js/plugins/morris/morris.min.js"></script>
       <script type="text/javascript" src="<?=base_url('assets') ?>/js/plugins/rickshaw/d3.v3.js"></script>
       <script type="text/javascript" src="<?=base_url('assets') ?>/js/plugins/rickshaw/rickshaw.min.js"></script>
       <script type='text/javascript' src='<?=base_url('assets') ?>/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js'></script>
       <script type='text/javascript' src='<?=base_url('assets') ?>/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js'></script>
       <script type='text/javascript' src='<?=base_url('assets') ?>/js/plugins/bootstrap/bootstrap-datepicker.js'></script>
       <script type="text/javascript" src="<?=base_url('assets') ?>js/plugins/owl/owl.carousel.min.js"></script>

       <script type="text/javascript" src="<?=base_url('assets') ?>/js/plugins/moment.min.js"></script>
       <script type="text/javascript" src="<?=base_url('assets') ?>/js/plugins/daterangepicker/daterangepicker.js"></script>
       <!-- END THIS PAGE PLUGINS-->

       <!-- START TEMPLATE -->
       <!-- <script type="text/javascript" src="<?=base_url('assets') ?>/js/settings.js"></script> -->

       <script type="text/javascript" src="<?=base_url('assets') ?>/js/plugins.js"></script>
       <script type="text/javascript" src="<?=base_url('assets') ?>/js/actions.js"></script>

       <script type="text/javascript" src="<?=base_url('assets') ?>/js/demo_dashboard.js"></script>


       <!-- jQuery -->

       <script src="<?=base_url('assets/vendors/jquery/dist/jquery.min.js')?>"></script>
       <script src="<?=base_url('assets/js/jquery-ui.min.js')?>"></script>
       <script src="<?=base_url('assets/js/jquery.dataTables.min.js')?>"></script>


    </body>
</html>
