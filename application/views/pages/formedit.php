<?php include APPPATH."views/pages/js-edit.php";?>
<?php include APPPATH."views/pages/save-edit-inv-quo.php";?>
<?php echo form_open_multipart('gudang/update'); ?>
<?php  $idnee=$this->uri->segment(3); ?>
<input type="hidden" name="idtabel" value="<?php echo $idtbl;?>">
<input type="hidden" name="<?php echo($fkolom);?>" value="<?php echo((empty($idnee)) && (strlen($idnee)===0))? '': $idnee;?>" />
<?php
switch ($idtbl) {
  case '6': ?>
<?php include APPPATH."views/pages/inv-edit.php";?>
    <?php break;
  case '7': ?>
<?php include APPPATH."views/pages/quo-edit.php";?>
  <?php   break;
  default: ?>
<?php include APPPATH."views/pages/formedit-default.php";?>
  <?php 
  break;
}
?>
<hr>
<input type="submit" value="save" class="btn btn-primary btn-lg">
<?php echo form_close();?>
