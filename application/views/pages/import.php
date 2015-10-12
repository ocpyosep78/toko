
<div class="well well-sm">
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php echo form_open_multipart('gudang/readexcel/'.$idtbl);?> 
<input type="file" id="file_upload" name="userfile" size="20" required/>
<br /><input type="submit"value="Upload" />
<?php echo form_close();?>	
</div>