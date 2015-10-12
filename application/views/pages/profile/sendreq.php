<?php
$nmaprod='';$kdbrg='';$mdl='';
if (isset($_GET['isi2'])) {
  $kdb=htmlspecialchars($_GET['isi2']);
  $prod=getprod($kdb);
  $nmaprod=$prod[2];$kdbrg=$prod[0];$mdl=$prod[1];
}
?>

<?php
if (isset($_GET['e'])) { ?>
  <div class="alert alert-danger" role="alert"> Maaf terjadi kesalahan saat mengupload gambar pastikan extensi gambar .jpeg , .gif atau .png </div>
<?php } ?>
<form  enctype="multipart/form-data" class="form-horizontal" action="<?php echo(site_url('gudang/insert'))?>" method="post">
<input type="hidden" value="15" name="tabel">
  <div class="form-group">
    <label for="" class="col-sm-2 control-label">Nama Produk</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" placeholder="isikan nama produk" name="namaprod">
    </div>
  </div>
    <div class="form-group">
    <label for="" class="col-sm-2 control-label">Model Produk</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="Model" placeholder="isikan model produk" name="Model" value="<?php echo($mdl);?>">
    </div>
    </div>
  <div class="form-group">
    <label for="" class="col-sm-2 control-label">Description produk</label>
    <div class="col-sm-10">
      <textarea name="desc" class="form-control" placeholder="isikan deskripsi produk"></textarea>
    </div>
  </div>
   <div class="form-group">
    <label for="" class="col-sm-2 control-label">Spesifikasi produk</label>
    <div class="col-sm-10">
    <textarea name="ket" class="form-control" placeholder="isikan spesifikasi produk"></textarea>
    </div>
  </div>
<!-- upload  -->
<?php include APPPATH.'views/fields/uploadimg.php';?>
<!-- -->
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">kirim</button>
    </div>
  </div>