<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="input-group input-group-lg">
    <span class="input-group-addon" style="line-height: 0px; height: auto; padding: 2px 5px;">
        <span id="<?= $captcha_id ?>_cap_img"><?= $captcha_img; ?></span>
        <i style="cursor: pointer;" id="<?= $captcha_id ?>_refresh_captcha" class="fa fa-refresh main-color"></i>
    </span>
    <?php echo form_input('captcha', '', 'id="' . $captcha_id . '_captcha" class="form-control" maxlength="' . CAPTCHA_COUNT . '" size="' . CAPTCHA_COUNT . '" required style="width: 120px;"'); ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#<?=$captcha_id?>_refresh_captcha').click(function() {
                captcha('<?=$captcha_id?>');
            });
        });
    </script>
</div>