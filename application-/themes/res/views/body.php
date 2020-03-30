<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>


<!-- START PAGE CONTAINER -->
<div class="page-container">


<!-- START PAGE CONTAINER -->
<div class="page-container">
<?php if (isset($template['partials']['header'])) echo $template['partials']['header']; ?>
    <!-- START PAGE SIDEBAR -->
    <!-- PAGE CONTENT -->
    <div class="page-content">

 <?php if (isset($template['partials']['notify'])) echo $template['partials']['notify']; ?>
 <?php if (isset($template['partials']['container'])) echo $template['partials']['container']; ?>
    </div>

</div>
<?php if (isset($template['partials']['footer'])) echo $template['partials']['footer']; ?>

</div>
<!-- END PAGE CONTAINER -->

<!-- JavaScripts placed at the end of the document so the pages load faster -->

<!-- script -->

<link rel="stylesheet" href="<?=base_url('assets')?>/css/chosen.css" type="text/css">
<script type="text/javascript" src="<?=base_url('assets')?>/js/chosen.jquery.js"></script>


 <script type="text/javascript">

$(document).ready(function(){



$(".chosen-select").chosen({width: "100%"});


$(".chosen-selectrole").chosen({width: "100%"});


                   });




 </script>

<!-- script -->
