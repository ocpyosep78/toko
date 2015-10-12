<div class="row">
  <div class="col-md-11">
<div class="table-responsive">
  <table class="table">
  	<tr>
  		<td>ID Sales</td>
  		<td></td>
  		<td></td>
  		<td></td>
  		<td></td>
  		<td></td>
  		<td></td>
  		<td></td>
  		<td></td>
  		<td></td>
  		<td></td>
  		<td></td>
  		<td></td>
  		<td></td>
  	</tr>
    <?php foreach ($supplier as $isi): ?>
    <tr>
    	<td><?php echo $isi["idsupp"];?></td>
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
	<?php endforeach;?>
  </table>
</div>
</div>
</div>