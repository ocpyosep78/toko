<script src="<?php echo base_url().'asset/js/default/jquery-1.9.1.js';?>"></script>
<script type="text/javascript">
  $(function(){
      $('#img').change( function(event) {
        var tmppath = URL.createObjectURL(event.target.files[0]);
          $("img").fadeIn("fast").attr('src',tmppath);
          //document.getElementById("txthint").innerHTML=tmppath;
      });
      //-----------------------------------------------------------------------------------
  });
</script>
  <div class="form-group">
<span id="hslupload"></span>
<?php if (!isset($_GET['edit'])): ?>
<label for="" class="col-sm-2 control-label">Upload <?php echo ($this->uri->segment(4)==='20')? 'Brosur' : 'Gambar';?></label>
<?php endif;?>
          <div class="col-sm-10">
      <input type="file" class="form-control" placeholder="unggah gambar produk berextensi .jpeg / .png / .gif" name="userfile" id="img">
      <?php if (isset($_GET['edit'])): ?>
        <input type="hidden" name="ttd" value="" />
      <?php else:?>
        <input type="hidden" name="idimg" value="0" />
      <?php endif;?>
    </div>
  </div>
  <div class="form-group">
    <img src="" class="img-responsive" alt="upload preview" style="display:none;" id="uplimg">
  </div>