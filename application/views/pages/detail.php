<form class="form-horizontal">
<?php foreach ($detailss as $key => $vdetail) { ?>
<?php foreach ($kolomm as $kkolomm) { ?>
  <div class="form-group">
    <label for="" class="col-sm-2 control-label"><p class="text-left"><?php echo($kkolomm);?></p></label>
    <div class="col-sm-10">
    <?php switch($kkolomm){
    	case 'idimg': ?>
    		<a href="<?php echo full_url().'?img='.$vdetail[$kkolomm];?>"><?php echo geturl_img($vdetail[$kkolomm]);?></a>
    <?php	break;
    		default: ?>
    		<p class="form-control-static"><?php echo($vdetail[$kkolomm]);?></p>
    <?php 	break;
    } ?>
    </div>
  </div>
<?php } ?>
<?php }?>
</form>