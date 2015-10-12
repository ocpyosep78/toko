<div class="row">
  <div class="col-md-11">
<div class="table-responsive">
  <table class="table">
  	<tr>
  		<td>kodebarang</td> 
  		<td>nama barang</td>
  		<td>category barang</td>
  		<td>hrg pokok</td>
  		<td>hrg jual</td>
  		<td>stock</td>
  		<td>quantity</td>
  		
  	</tr>
    <?php foreach ($barang as $isi): ?>
    <tr>
    	<td><?php echo $isi["kdbarang"];?></td>
    	<td><?php echo $isi["namabrg"];?></td>
    	<td><?php echo $isi["catbrg"];?></td>
    	<td><?php echo $isi["hrgpokok"];?></td>
    	<td><?php echo $isi["hrgjual"];?></td>
    	<td><?php echo $isi["stock"];?></td>
    	<td><?php echo $isi["qty"];?></td>
    	
		
    </tr>
	<?php endforeach;?>
  </table>
</div>
</div>
</div>