<style type="text/css">
	.form-control {
		margin: 5px;
	}
</style>
<script src="<?php echo(base_url().'assets/js/inserttempbrg.js');?>"></script>
<script src="<?php echo(base_url().'assets/js/tabel.js');?>"></script>
<strong id="msg"></strong>
<div class="row">
<div class="col-xs-6">
 	<div class="row">
      <label class="col-xs-4" for="">Date</label>
      <div class="col-xs-8">
        <input type="date" name="tgl" class="form-control" value="<?php echo(date('Y-m-d'));?>" />
      </div>
   	</div>
   	 <div class="row">
      <label class="col-xs-4" for="">Quotation No</label>
      <div class="col-xs-8">
        <strong><?php echo('THC/QUO/'.date('d/m/').$lastid);?></strong>
        <input type="hidden" name="kdquo" value="<?php echo('THC/QUO/'.date('d/m/').$lastid);?>" />
        

      </div>
   	</div>
   	 	<div class="row">
      <label class="col-xs-4" for="">To</label>
      <div class="col-xs-8">
        <?php include APPPATH.'views/fields/idcus.php';?>
        <input type="hidden" id="idcus" name="idcus" value="<?php echo $idcus;?>" />
      </div>
   	</div>
   	 	<div class="row">
      <label class="col-xs-4" for="">Address</label>
      <div class="col-xs-8">
      <textarea  id="alamtc" class="form-control" name="address"><?php echo(count($datacus)>0)? $datacus['alamat']: '';?></textarea>
      </div>
   	</div>

</div>
<div class="col-xs-6">
	<div class="row">
      <label class="col-xs-4" for="">Attn</label>
      <div class="col-xs-8">
        <input type="text" class="form-control" name="attn"  />
      </div>
   	</div>
   	 <div class="row">
      <label class="col-xs-4" for="">CC</label>
      <div class="col-xs-8">
        <input type="text" class="form-control" name="cc" />
      </div>
   	</div>
   	 	<div class="row">
      <label class="col-xs-4" >Telp / Hp</label>
      <div class="col-xs-8">
        <input type="text" class="form-control" name="telp"  id="telpc" value="<?php echo (count($datacus)>0)? $datacus['telp']:'' ; ?>" />
      </div>
   	</div>
    <div class="row">
      <label class="col-xs-4" for="">No fax</label>
      <div class="col-xs-8">
        <input type="text" class="form-control" name="fax"  id="faxc" value="<?php echo (count($datacus)>0)? $datacus['fax']: '';?>" />
      </div>
    </div>
   	<div class="row">
      <label class="col-xs-4" for="">Email</label>
      <div class="col-xs-8">
        <input type="email" class="form-control" name="email"  id="emailc" value="<?php echo (count($datacus)>0)? $datacus['email']: '';?>" />
      </div>
   	</div>
</div>
</div>
<div class="row">
  <div class="col-xs-6">
         <div class="row">
      <label class="col-xs-4" for="">Website</label>
      <div class="col-xs-8">
        <select class="form-control" name="website">
          <?php $listweb=getwebusr();
          foreach ($listweb as $valw) { ?>
            <option value="<?php echo($valw);?>"><?php echo geturlweb($valw);?></option>
          <?php } ?>
        </select>
      </div>
    </div>
  </div>
  <div class="col-xs-6">
         <div class="row">
      <label class="col-xs-4" for="">Catatan</label>
      <div class="col-xs-8">
        <textarea class="form-control" name="catatan"></textarea>
      </div>
    </div>
  </div>
</div>
<?php include APPPATH.'views/pages/insert/tabelact.php';?>
<div class="row">
  <div class="col-xs-12">
    <button type="submit" class="btn btn-lg btn-primary">Save</button>
  </div>
</div>

