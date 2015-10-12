<script src="<?php echo base_url().'asset/js/default/jquery-1.9.1.js';?>"></script>
<script type="text/javascript">
$(document).ready(function() {
    var pane = $("#addr");
    pane.val($.trim(pane.val()).replace(/\s*[\r\n]+\s*/g, '\n')
                               .replace(/(<[^\/][^>]*>)\s*/g, '$1')
                               .replace(/\s*(<\/[^>]+>)/g, '$1'));
});
</script>
<script type="text/javascript">
	function keyupdic(value) {
		var nom=document.getElementById('nom');
		var persen=document.getElementById('persen');
		if (nom.checked==false && persen.checked==false) {
			alert('pilih metode diskon dulu');
		}
		if(persen.checked==true){
			if (value>100) {
				alert('rentang persentase mulai dari 0 sampai 100 ');	
			}
		}
	}
</script>
<form action="<?php echo(site_url('gudang/insert'))?>" method="post">
<?php $req=$this->uri->segment(3);?>
<input type="hidden" name="tabel" value="3">
<input type="hidden" name="set" value="<?php echo(!empty($req))? $req : '1';?>">
<input type="hidden" name="kdbarang" value="">
	<div class="row">
		
			<?php
			if (!empty($req)) {
				$datareq=getnamaprod($req);
				if (count($datareq)!==0) {
					foreach ($datareq as $vreq) {
						$namaprod=$vreq['namaprod'];
						$Model=$vreq['Model'];
						$desc=$vreq['desc'];
						$iduser=$vreq['iduser'];
						$idimg=$vreq['idimg'];	
						$time=$vreq['time'];
					}
					$infouser=getdetuser($iduser);
					foreach ($infouser as $valuser) {
						$nama=$valuser['nama'];
						$uname=$valuser['username'];
						$uemail=$valuser['email'];
						$jbtn=returncab($valuser['id']);
					}
					$path=geturl_img($idimg);
					$src=substr($path,21);
					$urlimg=base_url().$src;
				}
			}
			?>
				<div class="col-xs-6">
				<div class="panel panel-default">
  					<div class="panel-heading">Data user</div>
  					<div class="panel-body">
    					<p>
    						<strong>Real name   :</strong><?php echo (!empty($nama))?  $nama: '';?><br>
    						<strong>username</strong> :<?php echo (!empty($uname))? $uname : '';?><br>
    						<strong>user email 	:</strong><?php echo (!empty($uemail))? $uemail : '';?><br>
    						<strong>user level 	:</strong><?php echo (!empty($jbtn))? $jbtn : '';?><br>
    					</p>
  					</div>
				</div>
				</div>
				<div class="col-xs-6">
				<div class="panel panel-default">
  					<div class="panel-heading">Data Request</div>
  					<div class="panel-body">
  					<strong> waktu : </strong><h3><?php echo(!empty($time))? $time :'';?></h3>
  					</div>
				</div>
				</div>
			</div>
	<div class="row">
	<div class="col-md-4">
		<img src="<?php echo(!empty($urlimg))? $urlimg : 'd:\hobbit_battle_five_armies.jpeg';?>" alt="cek thumb produk" class="img-rounded img-responsive">
	</div>
	<div class="col-md-8">
		<div class="form-f">
			<div class="form-group">
    			<label for="">Nama Produk</label>
    			<input type="text" class="form-control" name="namaprod" value="<?php echo(!empty($namaprod))? $namaprod : '' ;?>">
  			</div>
  			<div class="form-group">
    			<label for="">Model</label>
    			<input type="text" class="form-control" name="Model" value="<?php echo(!empty($Model))? $Model : '';?>">
  			</div>
  			<div class="form-group">
    			<label for="">Deskripsi Produk</label>
    			<textarea class="form-control" name="Description" id="addr">
    				<?php echo(!empty($desc))? $desc : '' ;?>
    			</textarea>
  			</div>
		</div>
	</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<table class="table table-bordered">
 				<thead>
 				<tr>
 					<td>Details</td>
 					<?php 
 					$jml=count($tbkol);
 					for ($i=0; $i < $jml; $i++) { ?>
 						<td><?php echo($tbkol[$i]);?></td>
 					<?php }?>
 				</tr>
 				</thead>
 				<tbody>
 					<?php 
 					
 					foreach ($purchase as $vpurchase) { ?>
 					<tr>
						<td><a href="<?php echo(current_url().'/d?id='.$vpurchase[$fkol].'&tbl=16');?>"><?php echo($vpurchase[$fkol]);?></a></td> 						
						<?php 
						$jml=count($tbkol);
						for ($x=0; $x < $jml; $x++) { ?>
								<td><?php echo($vpurchase[$tbkol[$x]]);?></td>
							
						<?php }?>
 					</tr>
 					<?php } ?>
 				</tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
		<h1 class="text-right">Set harga jual</h1>		
		</div>
		<div class="col-md-8">
		<div class="form-group">
			<input type="text" class="form-control" name="Harga_Lama" placeholder="Harga lama" value="" />
		</div>
		<div class="form-group">
			<input type="text" class="form-control" name="Harga_Baru" placeholder="Harga baru" />
		</div>			
		</div>
	</div>
	<div class="row">
	<div class="form-group">
		<label for="">Produk diskon</label>
		<div class="col-xs-6">
			<input type="text" class="form-control" name="disc" id="disc" onkeyup="keyupdic(this.value)">
		</div>
		<div class="col-xs-6">
			<label class="radio-inline">
  				<input type="radio" name="diskon" id="nom" value="n"> Nominal
			</label>
			<label class="radio-inline">
  				<input type="radio" name="diskon" id="persen" value="p" > persentase
			</label>
		</div>
	</div>
	<div class="form-group">
		<label for="">Produk stock</label>
		<select class="form-control" name="stock">
			<option value="a">ready</option>
			<option value="l">indent</option>
		</select>
	</div>
	<div class="form-group">
		<label for="">Produk quantity</label>
		<input type="text" class="form-control" name="qty" >
	</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-xs-12">
			<input type="submit" value="create" class="btn btn-lg btn-success" />
		</div>
	</div>
</form>
