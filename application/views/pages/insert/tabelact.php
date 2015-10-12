
<?php ((isset($_GET['isi2'])) && ($adadata) && (search_array($_GET['isi2'], $adadata))) ? $prm='?eb': $prm='';?>
<div class="row">
	<div class="col-xs-12">
		<div class="table-responsive">
    <input type="hidden" id="aksi" value="<?php echo (isset($lastid))? $lastid : '' ;?>" />
    <input type="hidden" id="mng" value="<?php echo (isset($idslug))? $idslug.$prm : '';?>" />
			<table class="table table-bordered">
      <thead>
      <tr>
        <td>No</td>
        <td>Description of Goods</td>
        <td>Qty</td>
        <td>Disc</td>
        <td>Price</td>
        <td>Subtotal</td>
        <td>Action</td>
      </tr>
      </thead>
      <tbody>      
     <tr id="addrow">
        <td>0</td>
        <td><?php include APPPATH.'views/fields/kdbarang.php';?>
          
        </td>
        <td class="col-xs-2">
          <input type="text" class="form-control" name="qty" id="qty" onkeyup="itung(this.value)" />
        </td>
        <td>
          <div class="radio">
            <label><input type="radio" name="cekdisc" id="ceknom" >Nominal</label>
            <div id="txtnom" style="display:none;"><input type="text" id="nominal" class="form-control" name="disc" onkeyup="disnom(this.value)" /></div>
          </div>
          <div class="radio">
            <label><input type="radio" name="cekdisc" id="cekpersen" value="">Persen</label>
            <p id="txtper"><?php echo(isset($discc))? $discc : '0' ;?></p>%
          </div>
        </td>
        <td><strong id="price"><?php echo(isset($price))? $price : '' ;?></strong></td>
        <td><strong id="subttl"></strong></td>
        <td>
          <a href="#" class="btn btn-default" id="btnsave"><span class="glyphicon glyphicon-floppy-saved"></span></a>
        </td>
      </tr>

      <?php if (($adadata) && (isset($adadata)) ) {
        $no=1;
        $kdb=array();$qtye=array();$disko=array();$hrge=array();$subt=array();
        foreach ($adadata as $valada) {
          $kdb[]=$valada['kdbarang'];$qtye[]=$valada['qty'];$disko[]=$valada['disc'];
          $hrge[]=$valada['price'];$subt[]=$valada['subtotal'];
          ?>
          <tr <?php echo((isset($_GET['isi2'])) && ($valada['kdbarang']===$_GET['isi2'])) ? 'style="display:none;"' : '';?>>
            <td><?php echo($no);?></td>
            <td><?php echo(getnamabrg($valada['kdbarang']));?><input type="hidden" id="<?php echo('idkdb'.$no);?>" value="<?php echo $valada['kdbarang']; ?>" /></td>
            <td><?php echo($valada['qty']);?></td>
            <td><?php echo(strlen($valada['disc'])>=4)? 'Rp '.$valada['disc'] : $valada['disc'].' %';?></td>
            <td><?php echo($valada['price']);?></td>
            <td><?php echo($valada['subtotal']);?></td>
            <td>
              <div class="btn-group" role="group" >
             
              <button type="button" class="btn btn-default" onclick="editbrg(<?php echo $no; ?>)"><span class="glyphicon glyphicon-pencil"></span></button>
              <button type="button" class="btn btn-default" onclick="deltempb(<?php echo($valada['id']);?>)"><span class="glyphicon glyphicon-remove">
              </span></button>
              </div>
            </td>
          </tr>
        <?php 
        $no++;
      }
      }
      ?>
      <tr>
        <td colspan="6">
          Grand Total
        </td>
        <td>
         <input type="hidden" name="produk" value="<?php echo (isset($kdb))? implode('|',$kdb) : '';?>" />
              <input type="hidden" name="qty" value="<?php echo (isset($qtye))? implode('|',$qtye) : '';?>" />
              <input type="hidden" name="disc" value="<?php echo (isset($disko))? implode('|',$disko) : '';?>" />
              <input type="hidden" name="price" value="<?php echo (isset($hrge))? implode('|',$hrge) : '';?>" />
              <input type="hidden" name="subtotal" value="<?php echo (isset($subt))? implode('|',$subt) : '';?>" />
          <strong id="gtotal"><?php echo (isset($subt))? array_sum($subt) : '0';?><input type="hidden" name="total" value="<?php echo (isset($subt))? array_sum($subt) : '0';?>" /></strong>
        </td>
      </tr>
      </tbody>
		</table>
		</div>
	</div>
</div>