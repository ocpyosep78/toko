$tabel=$this->mweb->getmanage_by_id($pecah[0]);	
    		$query=$this->mweb->getdatabykol($tabel,$pecah[1]);
    		$q = $pecah[2];
    		$hint = "";
    		if ($q !== "") {
    			$len=strlen($q);
    			$jmlr=count($query);
    			$similar=array();
    			for ($rr=0; $rr < $jmlr; $rr++) { 
    				if (stristr($q, substr($query[$rr], 0, $len))) {
                		$similar[]=$query[$rr];
        			}
    			}
    		} ?>
    		<table class="table">
    			<thead>
    				<tr>
    					<td></td>
    				</tr>
    			</thead>
    			<tbody>
    				<?php foreach ($similar as $key => $value) {
    					$hasil=$this->mweb->gettable_by_kol($pecah[1],$tabel,$value);
    					$kolomtb=$this->db->list_fields($tabel);
    					$ckoltb=count($kolomtb);
    					foreach ($hasil as $kh => $vhasil) { ?>
    						<tr>
    							<?php for ($h=0; $h < $ckoltb; $h++) { ?>
    							<?php if($h===0): ?>
    								<td>
    									<a href="<?php echo(site_url('gudang/getdetails/'.$vhasil[$kolomtb[$h]].'/'.$pecah[0]));?>"><?php echo $vhasil[$kolomtb[$h]];?></a>
    								</td>
            					<?php else :?>
    								<td><?php echo($vhasil[$kolomtb[$h]]);?></td>
    							<?php endif;?>
    							<?php }?>
    						</tr>
    					<?php }?>
    				<?php } ?>
    			</tbody>
    		</table>
<?php