<script src="<?php echo base_url().'asset/js/default/jquery-1.9.1.js';?>"></script>
<script type="text/javascript">
$(document).ready(function() {
    var pane = $("#addr");
    pane.val($.trim(pane.val()).replace(/\s*[\r\n]+\s*/g, '\n')
                               .replace(/(<[^\/][^>]*>)\s*/g, '$1')
                               .replace(/\s*(<\/[^>]+>)/g, '$1'));
});
</script>
<?php
foreach ($tabel as $barisv) {
  $iduserr=$barisv['iduser'];
  $id=$barisv['id'];$kdinv=$barisv['kdinv'];
  $tgl=$barisv['tgl'];$idcus=$barisv['idcus'];

$email=$barisv['email'];$ship_method=$barisv['ship_method'];
$pay_stat=$barisv['pay_stat'];$note_pay=$barisv['note_pay'];
$cust_address=$barisv['cust_address'];$cust_telp=$barisv['cust_telp'];
$bill_name=$barisv['bill_name'];$bill_address=$barisv['bill_address'];
$bill_telp=$barisv['bill_telp'];$ship_name=$barisv['ship_name'];
$ship_address=$barisv['ship_address'];$ship_telp=$barisv['ship_telp'];
$ship_cost=$barisv['ship_cost'];$pay_method=$barisv['pay_method'];
$catt=$barisv['catatan'];$web=$barisv['website'];
$produk=explode('|',$barisv['produk']);$qty=explode('|',$barisv['qty']);$price=explode('|', $barisv['price']);
$disc=explode('|', $barisv['disc']);$amount=$barisv['amount'];$subtotal=explode('|',$barisv['subtotal']);$total=$barisv['total'];
}

?>
<div class="row">
<div class="col-xs-12">
  <div class="page-header">
    <h1>Created By : <?php echo(getuname($iduserr));?></h1>
  </div>
</div>
</div>

<div class="row">
    <div class="col-xs-6">
<div class="panel panel-default height">
                        <div class="panel-heading">Informasi TOKO</div>
                        <div class="panel-body">
<!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
                    <input type="hidden" name="kolid" value="id">
                    <input type="hidden" name="id" id="idkol" value="<?php echo $id;?>">
<!--++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
                      <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <td colspan="2"><img src="<?php echo base_url().'asset/img/jvm.jpg';?>" class="img-responsive"></td>
                                </tr>
                                <tr>
                                    <td colspan="2">Jl. Raya Baturaden Timur KM 7 No. 17</td>
                                </tr>
                                 <tr>
                                    <td>Phone</td>
                                    <td>62-281-5755222</td>
                                </tr>
                                 <tr>
                                    <td>Faks</td>
                                    <td>62-281-6572606</td>
                                </tr>
                                 <tr>
                                    <td>Hp</td>
                                    <td>085291771888</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>info@jvm.co.id</td>
                                </tr>
                                <tr>
                                  <td>
                                    catatan
                                  </td>
                                  <td>
                                    <textarea id="addr" class="form-control" name="catatan"><?php echo(!empty($catt))? trim($catt): '';?></textarea>
                                  </td>
                                </tr>
                                  <tr>
                                      <td>
                                        website
                                      </td>
                                  <td>
                                    <select class="form-control" name="website">
                                      <option value="<?php echo($web)?>"><?php echo(geturlweb($web));?></option>
                                      <?php 

                                      if ((count($website)>0) && ($website)) {
                                        foreach ($website as $vweb) { 
                                          if ($vweb['id']!==$web) { ?>
                                            <option value="<?php echo($vweb['id']);?>"><?php echo($vweb['website'])?></option>
                                          <?php }?>
                                        <?php }
                                      }else{ ?>
                                        <option>Null</option>
                                      <?php } ?>
                                    </select>
                                  </td>
                                </tr>
                            </table>
                        </div>
                        </div>
                </div>
</div>
<div class="col-xs-6">
    <div class="panel panel-default height">
                        <div class="panel-heading"><?php echo $kdinv;?></div>
                        <div class="panel-body">
                             <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <td>STATUS</td>
                                    <td><input type="text" class="form-control" name="status" value="OPEN" /></td>
                                </tr>
                                 <tr>
                                    <td>DATE</td>
                                    <td><input type="date" class="form-control" name="tgl" value="<?php echo $tgl;?>" /></td>
                                </tr>
                                 <tr>
                                    <td>PAYMENT METHOD</td>
                                    <td><input type="text" class="form-control" name="pay_method" value="<?php echo $pay_method;?>" /></td>
                                </tr>
                                 <tr>
                                    <td>SHIPING METHOD</td>
                                    <td><input type="text" class="form-control" name="ship_method" value="<?php echo $ship_method;?>" /></td>
                                </tr>
                                  <tr>
                                    <td>PAYMENT STATUS</td>
                                    <td><input type="text" class="form-control" name="pay_stat" value="<?php echo $pay_stat;?>" /></td>
                                </tr>
                                  <tr>
                                    <td>NOTE PAYMENT</td>
                                    <td><input type="text" class="form-control" name="note_pay" value="<?php echo $note_pay;?>" /></td>
                                </tr>
 
                            </table>
                        </div>
                        </div>
                </div>
</div>
</div>
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
                                   <?php if (isset($_GET['editcus'])) {?>
                                    <?php include APPPATH.'views/fields/idcus.php';?>
                                    <a href="<?php echo(site_url('gudang/edit/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5)));?>">batal</a>
                                    <?php }else{ ?>
                                    <?php if (isset($_GET['isi'])): ?>
                                        <?php 
                                        $idnec=htmlspecialchars($_GET['isi']);
                                        $datacuse=getdatacus($idnec);
                                        $cust_telp=$datacuse['telp'];
                                        $cust_address=$datacuse['alamat'];
                                        $namacuse=getnamacus($idnec);
                                        ?>
                                    <input type="hidden" name="idcus" value="<?php echo (isset($_GET['isi']))? htmlspecialchars($_GET['isi']) : $idcus;?>">
                                    <?php else: ?>
                                    <?php $namacuse=getnamacus($idcus);?>
                                    <?php endif;?>
                                    <?php echo $namacuse; ?><a href="<?php echo current_url().'?editcus='.$idcus;?>">Edit</a>
                                    <?php } ?>

                                    </td>
                                </tr>
                                 <tr>
                                    <td>Customer Email</td>
                                    <td><input type="text" class="form-control" name="email" value="<?php echo $email;?>" /></td>
                                </tr>
                                 <tr>
                                    <td>Address</td>
                                    <td>
                                        <textarea id="addr" class="form-control" name="cust_address"><?php echo trim($cust_address);?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Customer telp</td>
                                    <td><input type="text" class="form-control" name="cust_telp" value="<?php echo $cust_telp;?>" /></td>
                                </tr>
                                 <tr>
                                    <td>barcode</td>
                                    <td></td>
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
                                    <td><input type="text" class="form-control" name="bill_name" value="<?php echo $bill_name;?>" /></td>
                                </tr>
                                 <tr>
                                    <td>Bill address</td>
                                    <td>
                                      <textarea class="form-control" name="bill_address"><?php echo $bill_address;?></textarea>
                                    </td>
                                </tr>
                                 <tr>
                                    <td>Bill telp</td>
                                    <td><input type="text" class="form-control" name="bill_telp" value="<?php echo $bill_telp;?>" /></td>
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
                                    <td><input type="text" class="form-control" name="ship_name" value="<?php echo $ship_name;?>" /></td>
                                </tr>
                                 <tr>
                                    <td>Ship Address</td>
                                    <td>
                                        <textarea id="addr" class="form-control" name="ship_address"><?php echo trim($ship_address);?></textarea>
                                    </td>
                                </tr>
                                 <tr>
                                    <td>Ship telp</td>
                                    <td><input type="text" class="form-control" name="ship_telp" value="<?php echo $ship_telp;?>" /></td>
                                </tr>
                            </table>
                        </div>
                        </div>
                    </div>
  </div>
</div>
<?php include APPPATH."views/pages/tabble-quo-inv.php";?>