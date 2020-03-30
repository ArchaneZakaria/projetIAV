<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
    tinymce.init({
        selector: ".wysiwyg",
        language : 'fr_FR',
        plugins: [
            "advlist anchor autolink autoresize autosave charmap code colorpicker contextmenu",
            "directionality emoticons example example_dependency fullscreen hr image insertdatetime",
            "link lists importcss media nonbreaking noneditable pagebreak paste preview",
            "print save searchreplace spellchecker tabfocus table template textcolor textpattern visualblocks visualchars wordcount"
        ],
        toolbar: "undo redo | formatselect fontselect fontsizeselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
     });
</script>