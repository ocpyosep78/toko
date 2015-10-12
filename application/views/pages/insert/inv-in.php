<style type="text/css">
	.form-control {
		margin: 5px;
	}
</style>
<script src="<?php echo(base_url().'assets/js/inserttempbrg.js');?>"></script>
<script src="<?php echo(base_url().'assets/js/tabel.js');?>"></script>
<div class="row">
	<div class="col-xs-12">
		<div class="page-header">
		<h1>INVOICE</h1>	
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-6">
		<p class="text-left">
		<strong>
			<span class="col-md-1">PHONE</span><span class="col-md-1" style="position:relative;left:20px;right:10px;">:</span><span class="col-md-4">0281-6572222</span><br/>
			<span class="col-md-1">FAKS</span><span class="col-md-1" style="position:relative;left:20px;right:10px;">:</span><span class="col-md-4">0281-6572606</span><br/>
			<span class="col-md-1">HP</span><span class="col-md-1" style="position:relative;left:20px;right:10px;">:</span><span class="col-md-4">085291771888</span><br/>
			<span class="col-md-1">EMAIL</span><span class="col-md-1" style="position:relative;left:20px;right:10px;">:</span><span class="col-md-4">info@jvm.co.id</span><br/>
		</strong>	
		</p>
	</div>
	<div class="col-xs-6">
	<div class="row">
      <label class="col-xs-4" for="">STATUS</label>
      <div class="col-xs-8">
<input type="text" name="" class="form-control"  id="" />
      </div>
   	</div>

	<div class="row">
      <label class="col-xs-4" for="">Date</label>
      <div class="col-xs-8">
        <input type="date" name="tgl" class="form-control" value="<?php echo(date('Y-m-d'));?>" />
      </div>
   	</div>

<div class="row">
      <label class="col-xs-4" for="">PAYMENT METHOD</label>
      <div class="col-xs-8">
<input type="text" name="pay_method" class="form-control"  id="" />
      </div>
   	</div>
   	<div class="row">
      <label class="col-xs-4" for="">SHIPING METHOD</label>
      <div class="col-xs-8">
<input type="text" name="ship_method" class="form-control"  id="" />
      </div>
   	</div>
   	<div class="row">
      <label class="col-xs-4" for="">PAYMENT STATUS</label>
      <div class="col-xs-8">
<input type="text" name="pay_stat" class="form-control"  id="" />
      </div>
   	</div>
   	<div class="row">
      <label class="col-xs-4" for="">NOTE PAYMENT</label>
      <div class="col-xs-8">
<input type="text" name="note_pay" class="form-control"  id="" />
      </div>
   	</div>


	</div>
</div>
<div class="row">
	<div class="col-md-4">
		<span class="col-xs-12"><h3>Customer</h3>
		<?php include APPPATH.'views/fields/idcus.php';?>
        <input type="hidden" id="idcus" name="idcus" value="<?php echo $idcus;?>" />
		<textarea class="form-control" name="cust_address" id="alamtc" placeholder="alamat"><?php echo (count($datacus)>0)? $datacus['alamat']:'' ; ?></textarea>
		<input type="text" name="cust_telp" class="form-control"  id="telpc" placeholder="no telp" value="<?php echo (count($datacus)>0)? $datacus['telp']:'' ; ?>"/>
		<input type="text" name="fax" class="form-control"  id="faxc" placeholder="no fax" value="<?php echo (count($datacus)>0)? $datacus['fax']:'' ; ?>"/>
		<input type="text" name="email" class="form-control"  id="emailc" placeholder="Email address" value="<?php echo (count($datacus)>0)? $datacus['email']:'' ; ?>"/>
		</span>
	</div>
	<div class="col-md-4">
		<span class="col-xs-12"><h3>Bill To</h3>
		<input type="text" name="bill_name" class="form-control"  id="bill_name" placeholder="Real Name" />
<textarea class="form-control" name="bill_address" id="bill_address" placeholder="alamat"></textarea>
		<input type="text" name="bill_telp" class="form-control"  id="bill_telp" placeholder="no telp" />
		</span>
	</div>
	<div class="col-md-4">
		
		<span class="col-xs-12"><h3>Ship To</h3>
		<input type="text" name="ship_name" class="form-control"  id="ship_name" placeholder="Real Name" />
		<textarea class="form-control" name="ship_address" id="ship_address" placeholder="alamat"></textarea>
		<input type="text" name="ship_telp" class="form-control"  id="ship_telp" placeholder="no telp" />
		</span>
		
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