<html>
<head>
<title>Upload Form</title>
</head>
<body>


<?php echo form_open_multipart('accueil/do_upload');?>

<input type="file" name="userfile" size="20" />

<br /><br />

<input type="submit" value="upload" />

</form>





<form class="form-horizontal" id="submit">
                <div class="form-group">
                    <input type="text" name="title" class="form-control" placeholder="Title">
                </div>
                <div class="form-group">
                    <input type="file" name="file">
                </div>

                <div class="form-group">
                    <button class="btn btn-success" id="btn_upload" type="submit">Upload</button>
                </div>
  </form>



  <script type="text/javascript">

  var base_url = "<?= base_url() ?>"
    $(document).ready(function(){

        $('#submit').submit(function(e){
            e.preventDefault();
                 $.ajax({
                     url:base_url + 'accueil/do_upload',
                     type:"post",
                     data:new FormData(this),
                     processData:false,
                     contentType:false,
                     cache:false,
                     async:false,
                      success: function(data){
                          alert(data);
                   }
                 });
            });


    });

</script>

</body>
</html>
