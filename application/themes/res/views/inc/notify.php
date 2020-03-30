<div id="content-header">
  <div id="breadcrumb"> <a href="<?=  base_url('accueil') ?>" title="Go to Home" ><i class="icon-home"></i> Accueil</a>

    <?php if(isset($links) && !empty($links)){ foreach($links as $key => $value ){ ?>
    <i class="tip-bottom" ></i><a href="<?= $value ?>" class="current"><?php if(isset($links))  echo $key; ?></a>
  <?php }
}?> </div>
</div>
