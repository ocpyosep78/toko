<?php foreach ($cus as $isi){
	$id=$isi["idcus"];
	$sales=$isi["sales"];
	$nm=$isi["nama"];
	$almt=$isi["alamat"];
	$city=$isi["kota"];
	$prov=$isi["provinsi"];
	$kdp=$isi["kdpos"];
	$neg=$isi["negara"];
	$telp=$isi["telp"];
	$fax=$isi["fax"];
	$kontak=$isi["kontak"];
	$norek=$isi["norek"];
	$an_rek=$isi["an_rek"];
	$bank=$isi["bank"];
}?>
<?php echo form_open("gudang/updatecus");?>
<input type="hidden" name="id" value="<?php echo $id;?>"/>
  <div class="form-group">
  	 	<label for="">Sales</label>
    	<input type="text" class="form-control" id="" name="sales" value="<?php echo $sales;?>">
  </div>
  <div class="form-group">
  	 	<label for="">Nama Lengkap</label>
    	<input type="text" class="form-control" id="" name="nama" value="<?php echo $nm;?>">
  </div>
    <div class="form-group">
  	 	<label for="">Alamat</label>
    	<input type="text" class="form-control" id="" name="alamat" value="<?php echo $almt;?>">
  </div>
    <div class="form-group">
  	 	<label for="">Kota</label>
    	<input type="text" class="form-control" id="" name="kota" value="<?php echo $city;?>">
  </div>
    <div class="form-group">
  	 	<label for="">provinsi</label>
    	<input type="text" class="form-control" id="" name="prov" value="<?php echo $prov;?>">
  </div>
    <div class="form-group">
  	 	<label for="">kode pos</label>
    	<input type="text" class="form-control" id="" name="kdpos" value="<?php echo $kdp;?>">
  </div>
    <div class="form-group">
  	 	<label for="">Negara</label>
    	<input type="text" class="form-control" id="" name="neg" value="<?php echo $neg;?>">
  </div>
    <div class="form-group">
  	 	<label for="">No. Telp</label>
    	<input type="text" class="form-control" id="" name="telp" value="<?php echo $telp;?>">
  </div>
    <div class="form-group">
  	 	<label for="">Fax</label>
    	<input type="text" class="form-control" id="" name="fax" value="<?php echo $fax;?>">
  </div>
    <div class="form-group">
  	 	<label for="">Kontak</label>
    	<input type="text" class="form-control" id="" name="kontak" value="<?php echo $kontak;?>">
  </div>
    <div class="form-group">
  	 	<label for="">No Rekening</label>
    	<input type="text" class="form-control" id="" name="norek" value="<?php echo $norek;?>">
  </div>
  <div class="form-group">
  	 	<label for="">Atas Nama Rekening</label>
    	<input type="text" class="form-control" id="" name="anrek" value="<?php echo $an_rek;?>">
  </div>
    <div class="form-group">
  	 	<label for="">Bank</label>
    	<input type="text" class="form-control" id="" name="bank" value="<?php echo $bank;?>">
  </div>
  <button type="submit" class="btn btn-default">Submit</button>
<?php echo form_close();?>