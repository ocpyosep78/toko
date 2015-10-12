<script src="<?php echo base_url().'asset/js/default/jquery.min.js';?>"></script>
<script type="text/javascript" src="<?php echo base_url().'asset/js/ticker/jquery-1.8.0.min.js';?>"></script>
<script type="text/javascript" src="<?php echo base_url().'asset/js/ticker/newsticker.js';?>"></script> 
<script type="text/javascript">
$(function(){
  $('#newsticker-container').newsTicker();
});
</script>
<div class="row" >
<div class="col-md-8">
<div class="row">
  <?php if (!empty($antrian)): ?>
  <div class="panel panel-default">
  <div class="panel-heading">Ket. status</div>
  <div class="panel-body">
  <ul>
    <li><b>PENDING</b>: Belum di proses oleh purchasing karena masih dalam antrian</li>
    <li><b>PROSES</b> : Artinya sudah mulai dicari oleh purchasing, tapi belum mendapatkan supplier</li>
    <li><b>Waiting</b> : Sudah mendapatkan Supplier, tetapi belum mendapatkan harga pembelian</li>
    <li><b>Waiting Approval</b> : Harga pembelian sudah didapatkan, tinggal menunggu approval harga penjualan</li>
    <li><b>Success</b> : Request sudah berhasil diproses dan sudah masuk di data produk</li>
  </ul>
  </div>
</div>
<?php endif;?>
</div>
</div>
<div class="col-md-4">
<?php if (is_admin() || is_mimin()):?>  
<div class="panel panel-default">
  <div class="panel-heading"><strong>Follow up</strong></div>
  <div class="panel-body">
    <div id="newsticker-container" >
  <ul class="list-group">
    <?php if ($follap) : 
    foreach ($follap as $valfol) { ?>
      <li class="list-group-item"><?php echo((strlen($valfol['nama']) > 0) || (strlen($valfol['perusahaan']) > 0))? '<strong>ID. '.$valfol['id'].'</strong>--'.$valfol['nama'].'<a href="'.current_url().'?id='.$valfol['id'].'&tbl=16">details</a>': '<a href="'.current_url().'?idreq='.$valfol['idreq'].'&tbl=16">details</a>';?></li>
    <?php } ?>
    <?php else: ?>
      <li class="list-group-item">belum ada</li>
    <?php endif;?>
  </ul>
</div>
  </div>
  </div>
<?php endif; ?>
</div>
</div>