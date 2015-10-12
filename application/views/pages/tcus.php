<div class="row">
  <div class="col-md-11">
  <div class="page-header">
    <?php //$result=;
        if(isset($_GET["notfound"])):?>
        <div class="alert alert-warning" role="alert">Maaf data yang anda cari tidak ditemukan</div>
      <?php endif;?>
  <form action="<?php echo base_url('gudang/caricus');?>" method="post" class="form-inline" role="form">
    <div class="form-group">
      <select class="form-control" name="coll">
        <option>Pilih kolom</option>
        <?php foreach ($kolomcus as $coll): ?>
          <option><?php echo $coll;?></option>
          <?php  endforeach;?>
        </select>
    </div>
  <div class="form-group">
    <input type="text" class="form-control" name="keyword" placeholder="cari berdasarkan keyword">
  </div>
  <button type="submit" class="btn btn-default">cari</button>
</form>
</div>

<div class="table-responsive">
  <table class="table">
  	<tr>
      <td>AKsi</td>
  		<td>ID Customer</td>
  		<td>Sales</td>
  		<td>Nama</td>
  		<td>Alamat</td>
  		<td>Kota</td>
  		<td>Provinsi</td>
  		<td>Kode Pos</td>
  		<td>Negara</td>
  		<td>telp</td>
  		<td>fax</td>
  		<td>kontak</td>
  		<td>No. rek</td>
  		<td>Atas Nama Rek</td>
  		<td>bank</td>
      
  	</tr>
    <?php foreach ($cus as $isi): ?>
    <tr>
      <td>
        <a href="<?php echo base_url('gudang/deletecus/'.$isi['idcus']);?>" />hapus</a>|
        <a href="<?php echo base_url('gudang/editcus/'.$isi['idcus']);?>" />update</a>
      </td>
    	<td><?php echo $isi["idcus"];?></td>
    	<td><?php echo $isi["sales"];?></td>
    	<td><?php echo $isi["nama"];?></td>
    	<td><?php echo $isi["alamat"];?></td>
    	<td><?php echo $isi["kota"];?></td>
    	<td><?php echo $isi["provinsi"];?></td>
    	<td><?php echo $isi["kdpos"];?></td>
    	<td><?php echo $isi["negara"];?></td>
    	<td><?php echo $isi["telp"];?></td>
    	<td><?php echo $isi["fax"];?></td>
    	<td><?php echo $isi["kontak"];?></td>
		<td><?php echo $isi["norek"];?></td>
		<td><?php echo $isi["an_rek"];?></td>
    	<td><?php echo $isi["bank"];?></td>
		
    </tr>	
  	<?php  endforeach;?>
  </table>
</div>

</div>
</div>