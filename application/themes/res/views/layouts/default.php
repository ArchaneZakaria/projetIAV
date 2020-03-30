<!DOCTYPE html>
<html lang="en">
<head>
<title>SUIVI BM</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
     <link rel="stylesheet" href="<?= base_url('assets/css/MyStyle.css')?>" />
     <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>" >
      <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap-responsive.min.css') ?>" >
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <link rel="stylesheet" href="<?= base_url('assets/css/uniform.css')?>" >
      <link rel="stylesheet" href="<?= base_url('assets/css/select2.css') ?>" >
      <link rel="stylesheet" href="<?= base_url('assets/css/matrix-style.css') ?>" >
      <link rel="stylesheet" href="<?= base_url('assets/css/matrix-media.css') ?>" >
      <link rel="stylesheet" href="<?= base_url('assets/css/datepicker.css') ?>" >
      <link href="<?= base_url('assets/font-awesome/css/font-awesome.css') ?>" rel="stylesheet" />
      <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <script src="<?=base_url('assets/js/mainjs.js') ?>"></script>

<style>
#search input[type="text"] {
    background-color: #47515b;
    color: #fff;
    padding: 13px 8px;
}
</style>

<script>
            var base_url = '<?= base_url() ?>';
            var site_url = '<?= site_url() ?>';
</script>

 <?php if (isset($template['metadata'])) echo $template['metadata']; ?>
</head>
<body style="margin-top: -20px;">
  <div class="page-container">

    <?php if (isset($template['body'])) echo $template['body']; ?>

  </div>

  <!--end-Footer-part-->




        <script src="<?=base_url('assets/js/excanvas.min.js')?>"></script>
        <script src="<?=base_url('assets/js/jquery.min.js')?>"></script>
        <script src="<?=base_url('assets/js/jquery.ui.custom.js')?>"></script>
        <script src="<?=base_url('assets/js/bootstrap.min.js')?>"></script>
        <script src="<?=base_url('assets/js/jquery.uniform.js')?>"></script>
        <script src="<?=base_url('assets/js/select2.min.js')?>"></script>
        <script src="<?=base_url('assets/js/jquery.dataTables.min.js')?>"></script>
        <script src="<?=base_url('assets/js/matrix.js')?>"></script>

        <script src="<?=base_url('assets/js/matrix.tables.js')?>"></script>

            <script src="<?=base_url('assets/js/matrix.form_common.js')?>"></script>
            <script src="<?=base_url('assets/js/bootstrap-datepicker.js')?>"></script>
            <script src="<?=base_url('assets/js/bootstrap-colorpicker.js')?>"></script>
  <script type="text/javascript">
    // This function is called from the pop-up menus to transfer to
    // a different page. Ignore if the value returned is a null string:
    function goPage (newURL) {

        // if url is empty, skip the menu dividers and reset the menu selection to default
        if (newURL != "") {

            // if url is "-", it is this page -- reset the menu:
            if (newURL == "-" ) {
                resetMenu();
            }
            // else, send page to designated URL
            else {
              document.location.href = newURL;
            }
        }
    }

  // resets the menu selection upon entry to this page:
  function resetMenu() {
     document.gomenu.selector.selectedIndex = 2;
  }



  /*** sous menu **/
  $(document).ready(function(){
    $('.dropdown-submenu a.test').on("click", function(e){
      $(this).next('ul').toggle();
      e.stopPropagation();
      e.preventDefault();
    });
  });

  /*** sous menu **/
  </script>










</body>
</html>
