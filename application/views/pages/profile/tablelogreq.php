<table class="table table-bordered">
<tr>
  <td>Details</td>
  <td>No Request</td>
  <td>Waktu</td>
  <td>harga jual</td>
  <td>Nama barang </td>
  <td>Model</td>
  <td>Deskripsi</td>
  <td>Prev gambar</td>  
</tr>
<?php if ($reqbrg) { ?>
  <?php foreach ($reqbrg as $valreq) : ?>
  <tr>
  <td>
  <?php if (cekstatus($valreq['idreq'])): ?>
    <?php $kdbrge=getkdbreq($valreq['idreq']);?>
    <?php if (cekposting($kdbrge)) {
      $cekbrg=cekposting($kdbrge);
     ?>
      <a href="<?php echo(current_url().'/a?id='.$cekbrg.'&tbl=17')?>" class="btn btn-sm btn-success">posted</a>
    <?php }else{?>
<a href="<?php echo(site_url('gudang/profile?tab=5&isi2='.$kdbrge))?>" class="btn btn-sm btn-primary">post produk</a>
    <?php  }?>
<?php else:?>
    <div class="btn-group" role="group" aria-label="...">
<?php $btn=getsts_purc($valreq['idreq']);?>
<?php
$n=count($btn);
if ($n > 0) {
  for ($b=0; $b < $n; $b++) {?>
    <a href="<?php echo(current_url().'?idreq='.$valreq['idreq'].'&tbl='.$btn[$b])?>" class="btn btn-sm btn-primary">
      <?php 
      switch ($btn[$b]) {
        case 'p':
          echo('process');
          break;
        case 'w':
          echo('waiting');
          break;
        case 'wp':
          echo('waiting approval');
          break;
        case 's':
          echo('success');
          break;
        default:
          echo('pending');
          break;
      }
      ?>
    </a>
  <?php }
}else{
  echo('null');
}
?>
  </div>
<?php endif;?>
   </td>
      <td><a href="<?php echo(current_url().'/a?id='.$valreq['idreq'].'&tbl=16');?>"><?php echo($valreq['idreq']);?></a></td>
    <td><?php echo($valreq['time']);?></td>
    <td><?php echo ((empty($valreq['kdbarang'])) || (is_null($valreq['kdbarang'])) || (strlen($valreq['kdbarang'])===0))? 0 : gethrgbrg($valreq['kdbarang']);?></td>
    <td><?php echo($valreq['namaprod']);?></td>
    <td><?php echo($valreq['Model']);?></td>
    <td><?php echo($valreq['desc']);?></td>
    <td><a href="<?php echo(current_url().'/a?img='.$valreq['idimg'].'&tbl=20');?>"><?php echo(geturl_img($valreq['idimg']));?></a></td>
</tr>
<?php endforeach;?>
<?php }else{ ?>
<tr>
  <td colspan="7">
belum ada request    
  </td>
</tr>

<?php } ?>
</table>