<?php echo form_open_multipart('barang/insertbrg');?> 
<div class="form-horizontal" role="form">
  <div class="form-group">
    <label for="" class="col-sm-2 control-label">Kode Barang</label>
    <div class="col-sm-10">
      <input type="text" name="kdb" class="form-control">
    </div>
  </div>
    <div class="form-group">
    <label for="" class="col-sm-2 control-label">Nama Barang</label>
    <div class="col-sm-10">
      <input type="text" name="namabrg" class="form-control">
    </div>
  </div>
    <div class="form-group">
    <label for="" class="col-sm-2 control-label">Kategory barang</label>
    <div class="col-sm-10">
      <select class="form-control" name="catbrg">
            <option>Tanah</option>
            <option>air</option>
            <option>udara</option>
        </select>
    </div>
  </div>
    <div class="form-group">
    <label for="" class="col-sm-2 control-label">Harga Pokok</label>
    <div class="col-sm-10">
      <input type="text" name="hrgp" class="form-control">
    </div>
  </div>
    <div class="form-group">
    <label for="" class="col-sm-2 control-label">Harga Jual</label>
    <div class="col-sm-10">
      <input type="text" name="hrgj" class="form-control">
    </div>
  </div>
    <div class="form-group">
    <label for="" class="col-sm-2 control-label">Stock</label>
    <div class="col-sm-10">
      <input type="text" name="stock" class="form-control">
    </div>
  </div>
    <div class="form-group">
    <label for="" class="col-sm-2 control-label">Quantity</label>
    <div class="col-sm-10">
      <input type="text" name="qty" class="form-control">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-primary">Save</button>
    </div>
  </div>
</div>
<?php echo form_close();?>