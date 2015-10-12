<!--<form class="form-inline" role="form">
<script type="text/javascript">
          function ngetik(valuee){
              var kolomnya=document.getElementById("kkol").value;
              var x=document.getElementById("nyari").value;
              var idtbl=document.getElementById("idtbl").value;              
              if (x.length > 0) {
                  document.getElementById("tb").style.display="none";
                  document.getElementById("hasilcari").style.display="block";
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            document.getElementById("txthasilcari").innerHTML = xmlhttp.responseText;
                            }
                    }
                    xmlhttp.open("GET", window.location.origin+"/toko/gudang/getkeyword/"+kolomnya+"/"+idtbl+"?kw="+x, true);
                    xmlhttp.send();
              }else{
                  document.getElementById("txthasilcari").innerHTML = "";
                  document.getElementById("tb").style.display="block";
                  document.getElementById("hasilcari").style.display="none";
              }
          }
</script>
          <div class="form-group">
            <label for="" class="sr-only">Berdasarkan kolom</label>
            <select class="form-control" name="namakol" id="kkol">
              <?php //foreach ($kolom as $row): ?>
              <option><?php// echo $row;?></option>
            <?php// endforeach;?>
            </select>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="nyari" id="nyari" onkeyup="ngetik(this.value)" placeholder="keyword">
            <input type="hidden" value="<?php //echo($this->uri->segment(5));?>" id="idtbl">
          </div>
</form>
<div class="table-responsive" id="tb">
</div>
<div id="hasilcari" style="display:none;">
    <div id="txthasilcari"></div>
</div>-->
<?php
    echo $this->table->generate($data);
    echo $this->pagination->create_links();
?>