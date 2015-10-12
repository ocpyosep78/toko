<script>
function showHint(str) {
     if (str.length == 0) { 
         document.getElementById("txtHint").innerHTML = "";
         return;
     } else {
         var xmlhttp = new XMLHttpRequest();
         xmlhttp.onreadystatechange = function() {
             if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                 document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
             }
         }
         xmlhttp.open("GET", window.location.origin+"/toko/gudang/get_namacus?q="+str, true);
         xmlhttp.send();
     }
}
function doalert(obj){
      document.getElementById("hasilul").style.display = "none";
      window.location.href="?isi="+obj.getAttribute("href");
      return false;
}
</script>
<?php
if (isset($_GET["isi"])){
      $idcuse=htmlspecialchars($_GET["isi"]);
      $datacus=mysql_query("SELECT * FROM cus WHERE idcus='".$idcuse."'");
      if($datacus){
          $alamat=array();

          while($bariscus=mysql_fetch_array($datacus)){
              $alamat[]=$bariscus['alamat'];
              $alamat[]=$bariscus['kota'];
              $alamat[]=$bariscus['provinsi'];
              $alamat[]=$bariscus['kdpos'];
              $alamat[]=$bariscus['negara'];
              $namaacus=$bariscus['nama'];
              $email=$bariscus['email'];
              $telp=$bariscus['telp'];
              $fax=$bariscus['fax'];
          }
          $alamate=implode(',',$alamat);
      }
  }
?>
<input type="text" class="form-control" onkeyup="showHint(this.value)" value="<?php echo (!empty($namaacus)) ? $namaacus : '';?>">
<input type="hidden" name="idcus" id="idcustm" value="<?php echo (isset($_GET['isi'])) ? $_GET['isi'] : '';?>">
<span  id="txtHint"></span><br>