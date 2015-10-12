<script src="<?php echo base_url().'asset/js/default/jquery-1.9.1.js';?>"></script>
<script type="text/javascript">
$(document).ready(function() {
    var pane = $("#addr");
    pane.val($.trim(pane.val()).replace(/\s*[\r\n]+\s*/g, '\n')
                               .replace(/(<[^\/][^>]*>)\s*/g, '$1')
                               .replace(/\s*(<\/[^>]+>)/g, '$1'));
});
</script>
<form action="<?php echo(site_url('gudang/insert/'))?>" method="post">
	<input type="hidden" value="<?php echo($idtbl);?>" name="tabel">
<input type="hidden" name="produk" value="<?php echo (!empty($improduk))? $improduk : '';?>" />
<input type="hidden" name="Model" value="<?php echo (!empty($imModel))? $imModel : '';?>" />
<input type="hidden" name="qty" value="<?php echo (!empty($imqty))? $imqty : '';?>" />
<input type="hidden" name="disc" value="<?php echo (!empty($imdisc))? $imdisc : '';?>" />
<input type="hidden" name="price" value="<?php echo (!empty($imprice))? $imprice : '';?>" />
<input type="hidden" name="subtotal" value="<?php echo (!empty($imsubtotal))? $imsubtotal : '';?>" />
   <div class="row">
    <div class="col-xs-6">
<div class="panel panel-default height">
                        <div class="panel-heading">Informasi TOKO</div>
                        <div class="panel-body">
                      <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <td colspan="2"><img src="<?php echo base_url().'asset/img/jvm.jpg';?>" class="img-responsive"></td>
                                </tr>
                                <tr>
                                    <td colspan="2">Jl. Raya Baturaden Timur KM 7 No. 17</td>
                                </tr>
                                <?php if ($user) { ?>
                                <?php foreach ($user as $valuser) { ?>
                                <tr>
                                    <td>Phone</td>
                                    <td><?php echo($valuser['telp']);?></td>
                                </tr>
                                 <tr>
                                    <td>Faks</td>
                                    <td><?php echo($valuser['fax']);?></td>
                                </tr>
                                 <tr>
                                    <td>Hp</td>
                                    <td><?php echo($valuser['nohp']);?></td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td><?php echo($valuser['email']);?></td>
                                </tr>
                                <tr>
                                    <td>Website</td>
                                    <td>
                                    
                                   <select name="website" class="form-control">
                                    <?php 
$kdweb=explode(',', $valuser['website']);
$nw=count($kdweb);
for ($ww=0; $ww < $nw; $ww++) { ?>
<option value="<?php echo($kdweb[$ww]);?>"><?php echo(geturlweb($kdweb[$ww]));?></option>
<?php } ?>
                                    </select>
                                    </td>
                                </tr>
                                    <?php }?>
                                <?php }else{ ?>
                                <tr>
                                    <td colspan="2">belum ada data</td>
                                </tr>
                                <?php } ?>
                            </table>
                        </div>
                        </div>
                </div>
</div>
<div class="col-xs-6">
    <div class="panel panel-default height">
                        <div class="panel-heading"><?php echo('THC/INV/'.date('m/d').'/'.$lastid);?><input type="hidden" name="kdinv" value="<?php echo('THC/INV/'.date('m/d').'/'.$lastid);?>"/></div>
                        <div class="panel-body">
                             <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <td>STATUS</td>
                                    <td><input type="text" class="form-control" name="status" value="OPEN" /></td>
                                </tr>
                                 <tr>
                                    <td>DATE</td>
                                    <td><input type="date" class="form-control" name="tgl" /></td>
                                </tr>
                                 <tr>
                                    <td>PAYMENT METHOD</td>
                                    <td><input type="text" class="form-control" name="pay_method" value="" /></td>
                                </tr>
                                 <tr>
                                    <td>SHIPING METHOD</td>
                                    <td><input type="text" class="form-control" name="ship_method" value="" /></td>
                                </tr>
                                  <tr>
                                    <td>PAYMENT STATUS</td>
                                    <td><input type="text" class="form-control" name="pay_stat" value="" /></td>
                                </tr>
                                  <tr>
                                    <td>NOTE PAYMENT</td>
                                    <td><input type="text" class="form-control" name="note_pay" value="" /></td>
                                </tr>
                            </table>
                        </div>
                        </div>
                </div>
</div>
</div>

<!--++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
<?php 
$alamat=array();
foreach ($cus as $vcus) {
	$idc=$vcus['idcus'];
	$nama=$vcus['nama'];
    $telp=$vcus['telp'];
	$alamat[]=$vcus['alamat'];$alamat[]=$vcus['kota'];
	$alamat[]=$vcus['kabupaten'];$alamat[]=$vcus['provinsi'];
	$alamat[]=$vcus['kdpos'];$alamat[]=$vcus['negara'];
	$email=$vcus['email'];
}
$alamate=implode(',', $alamat);
?>
<div class="row">
  <div class="col-md-4">
        <div class="panel panel-default height">
                        <div class="panel-heading">Customer</div>
                        <div class="panel-body">
                             <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <td>Customer Name</td>
                                    <td>
                                    <label><?php echo (!empty($nama))? $nama :''; ?></label>
                                    <input type="hidden" name="idcus" value="<?php echo (!empty($idc))? $idc : '';?>">
                                    </td>
                                </tr>
                                 <tr>
                                    <td>Customer Email</td>
                                    <td><label><?php echo (!empty($email))? $email :''; ?></label>
                                    <input type="hidden" class="form-control" name="email" value="<?php echo (!empty($email))? $email :''; ?>" /></td>
                                </tr>
                                <tr>
                                    <td>no. Telp</td>
                                    <td>
                                        <label><?php echo((strlen($telp)===0) || empty($telp))? '' : $telp;?></label>
                                        <input type="hidden" name="cust_telp" value="<?php echo((strlen($telp)===0) || empty($telp))? '' : $telp;?>" />
                                    </td>
                                </tr>
                                 <tr>
                                    <td>Address</td>
                                    <td>
                                        <textarea class="form-control" name="cust_address" id="addr">
                                            <?php echo (!empty($alamate))? trim($alamate) :''; ?>
                                        </textarea>
                                    </td>
                                </tr>
                                 <tr>
                                    <td>barcode</td>
                                    <td class="emptyrow"><i class="fa fa-barcode iconbig"></i></td>
                                </tr>
                            </table>
                        </div>
                        </div>
                    </div>
  </div>
  <div class="col-md-4">
        <div class="panel panel-default height">
                        <div class="panel-heading">Bill to</div>
                        <div class="panel-body">
                            <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <td>Bill name</td>
                                    <td><input type="text" class="form-control" name="bill_name" value="" /></td>
                                </tr>
                                 <tr>
                                    <td>Bill address</td>
                                    <td>
                                    <textarea class="form-control" name="bill_address" value="" id="addr">
                                    	
                                    </textarea>
                                    </td>
                                </tr>
                                 <tr>
                                    <td>Bill telp</td>
                                    <td><input type="text" class="form-control" name="bill_telp" value="" /></td>
                                </tr>
                            </table>
                        </div>
                        </div>
                    </div>
  </div>
  <div class="col-md-4">
        <div class="panel panel-default height">
                        <div class="panel-heading">Ship to</div>
                        <div class="panel-body">
                            <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <td>Ship name</td>
                                    <td><input type="text" class="form-control" name="ship_name" value="" /></td>
                                </tr>
                                 <tr>
                                    <td>Ship Address</td>
                                    <td>
                                        <textarea class="form-control" name="ship_address" id="addr">
                                            
                                        </textarea>
                                    </td>
                                </tr>
                                 <tr>
                                    <td>Ship telp</td>
                                    <td><input type="text" class="form-control" name="ship_telp" value="" /></td>
                                </tr>
                            </table>
                        </div>
                        </div>
                    </div>
  </div>
</div>

<!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
<div class="row">
<div class="col-xs-12">
    <div class="form-group">
        <label>catatan</label>
        <textarea class="form-control" name="catatan"></textarea>
    </div>
</div>
</div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="text-center"><strong>Order summary</strong></h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-condensed table-bordered">
                            <thead>
                                <tr>
                                    <td><strong>Produk</strong></td>
                                    <td class="text-center"><strong>Harga</strong></td>
                                    <td class="text-center"><strong>disc</strong></td>
                                    <td class="text-center"><strong>qty</strong></td>
                                    <td class="text-right"><strong>subtotal</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($barang) { ?>
                                    <?php foreach ($barang as $valbrg) { 
                                        $kdbrg=explode('|', $valbrg['produk']);
                                        $pbrg=explode('|', $valbrg['price']);
                                        $qbrg=explode('|', $valbrg['qty']);
                                        $dsbrg=explode('|', $valbrg['disc']);
                                        $sbrg=explode('|', $valbrg['subtotal']);
                                     } ?>
                                     <?php
                                     $n=count($kdbrg);
                                     for ($xx=0; $xx < $n; $xx++) { ?>
                                     <tr>
                                         <td><?php echo(getnamabrg($kdbrg[$xx]));?><input type="hidden" name="produk" value="<?php echo($valbrg['produk']);?>" /></td>
                                         <td><?php echo($pbrg[$xx]);?><input type="hidden" name="price" value="<?php echo($valbrg['price']);?>" /></td>
                                         <td><?php echo($qbrg[$xx]);?><input type="hidden" name="qty" value="<?php echo($valbrg['qty']);?>" /></td>
                                         <td><?php echo($dsbrg[$xx]);?><input type="hidden" name="disc" value="<?php echo($valbrg['disc']);?>" /></td>
                                         <td class="emptyrow text-right"><?php echo($sbrg[$xx]);?><input type="hidden" name="subtotal" value="<?php echo($valbrg['subtotal']);?>" /></td>
                                     </tr>
                                    <?php  } ?>
                                <?php }else{ ?>
                                <tr><td colspan="5" class="text-center"> Tidak ada hasil</td></tr>
                                <?php } ?>
                                <tr>
                                    
                                    <td class="emptyrow text-right" colspan="4"><strong>Total</strong></td>
                                    <td class="emptyrow text-right"><?php echo ((empty($sbrg)) || (count($sbrg)===0))? '0': array_sum($sbrg);?><input type="hidden" name="total" value="<?php echo ((empty($sbrg)) || (count($sbrg)===0))? '0': array_sum($sbrg);?>"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<input type="submit" value="create" class="btn btn-lg btn-success">
</form>