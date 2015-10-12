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
foreach ($tabel as $baris) {
    $idq=$baris['id'];
    $iduserr=$baris['iduser'];
    $kdquo=$baris['kdquo'];$tgl=$baris['tgl'];
    $idcus=$baris['idcus'];$address=$baris['address'];
    $attn=$baris['attn'];$cc=$baris['cc'];
    $telp=$baris['telp'];$fax=$baris['fax'];
    $catt=$baris['catatan'];$web=$baris['website'];
    $email=$baris['email'];$produk=explode('|', $baris['produk']);
    $qty=explode('|', $baris['qty']);
    $disc=explode('|',$baris['disc']);$price=explode('|',$baris['price']);
    $subtotal=explode('|',$baris['subtotal']);$amount=$baris['amount'];
    $total=$baris['total'];$id=$baris['id'];
}
?>
<h1>Created By : <?php echo(getuname($iduserr));?></h1>
<div class="row">
        <div class="col-xs-6">
        <div class="panel panel-default height">
                        <div class="panel-heading"><?php echo $kdquo;?></div>
                        <div class="panel-body">
<!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
                    <?php $idne=$this->uri->segment(3);?>
                    <input type="hidden" name="id" value="<?php echo(empty($idne))? '': $idne;?>">
<!--++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
                            <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <td>Date</td>
                                    <td><input type="date" class="form-control" name="tgl" value="<?php echo (strlen($tgl)===0)? date('d/m/Y') :$tgl;?>" /></td>
                                </tr>
                                 <tr>
                                    <td>Quotation No</td>
                                    <td><?php echo $id;?></td>
                                </tr>
                                 <tr>
                                    <td>To</td>
                                    <td>
                                    <?php if (isset($_GET['editcus'])) {?>
                                    <?php include APPPATH.'views/fields/idcus.php';?>
                                    <a href="<?php echo(site_url('gudang/edit/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5)));?>">batal</a>
                                    <?php }else{ ?>
                                    <?php if (isset($_GET['isi'])): ?>
                                        <?php 
                                        $idnec=htmlspecialchars($_GET['isi']);
                                        $datacuse=getdatacus($idnec);
                                        $email=$datacuse['email'];
                                        $telp=$datacuse['telp'];
                                        $fax=$datacuse['fax'];
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
                                    <td>Address</td>
                                    <td><textarea id="addr" class="form-control" name="address" id="addrcus"><?php $testaddr=rtrim($address);echo ((empty($testaddr)) || (isset($_GET['isi'])))? getcusaddr(htmlspecialchars($_GET['isi'])): $testaddr;?></textarea></td>
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
                        <div class="panel-heading"><?php echo $kdquo;?></div>
                        <div class="panel-body">
                            <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <td>Attn</td>
                                    <td><input type="text" class="form-control" name="attn" value="<?php echo $attn;?>" /></td>
                                </tr>
                                 <tr>
                                    <td>Cc</td>
                                    <td><input type="text" class="form-control" name="cc" value="<?php echo $cc;?>" /></td>
                                </tr>
                                 <tr>
                                    <td>Telp</td>
                                    <td><input type="text" class="form-control" name="telp" value="<?php echo $telp;?>" /></td>
                                </tr>
                                 <tr>
                                    <td>Fax No</td>
                                    <td><input type="text" class="form-control" name="fax" value="<?php echo $fax;?>" /></td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td><input type="email" class="form-control" name="email" value="<?php echo $email;?>" /></td>
                                </tr>
                            </table>
                        </div>
                        </div>
                    </div>
        </div>
        </div>
<?php include APPPATH."views/pages/tabble-quo-inv.php";?>

