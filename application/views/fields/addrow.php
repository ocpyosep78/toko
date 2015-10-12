<table class="table table-bordered">
<tr>
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
      <div class="btn-group" role="group" aria-label="...">
          <a href="<?php echo(site_url('gudang/slug/5/1/'.$idslug));?>" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span></a>
          <a href="#" class="btn btn-default" id="btnsave"><span class="glyphicon glyphicon-floppy-saved"></span></a>
        </div>
        </td>
      </tr>
</table>