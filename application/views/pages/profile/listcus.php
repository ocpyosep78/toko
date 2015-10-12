<form action="" method="">
<table class="table">
  <tr>
    <td>aksi</td>
    <td>ID Customer</td>
    <td>Customer Name</td>
  </tr>
  <?php 
  if($listcus){ ?>
  <?php foreach ($listcus as $vcus) { ?>
    <tr>
      <td>
      <div class="btn-group" role="group" aria-label="...">
        <a href="<?php echo(site_url('gudang/slug/5/1/7?isi='.$vcus['idcus']));?>" class="btn btn-sm btn-primary">Quotation</a>
        <a href="<?php echo(site_url('gudang/slug/5/1/7?isi='.$vcus['idcus']));?>" class="btn btn-sm btn-primary">Invoice</a>
      </div>
      </td>
      <td><a href="<?php echo(site_url('gudang?id='.$vcus['idcus'].'&tbl=1'))?>"><?php echo($vcus['idcus']);?></a></td>
      <td><?php echo($vcus['nama']);?></td>
    </tr>
  <?php }?>
  <?php }else{ ?>
  <tr>
  <a href="<?php echo(site_url('gudang/slug/2/1/1'))?>" class="btn btn-primary"><span class="glyphicon glyphicon-plus" ></span>Tambahkan pelanggan</a>
    <td colspan="3" class="alert alert-warning" role="alert">
      anda belum mendaftarkan pelanggan :(
    </td>
  </tr>
  <?php } ?>
</table>
</form>