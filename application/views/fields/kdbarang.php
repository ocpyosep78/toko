 <script type="text/javascript">
          function showHintprod(str) {
          if (str.length == 0) { 
            document.getElementById("txtHprod").innerHTML = "";
          return;
          } else {
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function() {
              if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                 document.getElementById("txtHprod").innerHTML = xmlhttp.responseText;
                }
              }
              xmlhttp.open("GET", window.location.origin+"/toko/gudang/getproduk?p="+str, true);
              xmlhttp.send();
            }
          }
          function detailprod(obj){
            document.getElementById("hasilbrg").style.display = "none";
            window.location.href=document.URL+"&isi2="+obj.getAttribute("href");
            return false;
        } 
</script>
 <?php
  if (isset($_GET['isi2'])) {
    $kdbarange=htmlspecialchars($_GET['isi2']);
    $databrg=mysql_query("SELECT * FROM barang WHERE kdbarang='".$kdbarange."'");
      if($databrg){
          while($barisbrg = mysql_fetch_array($databrg)){
              $price=$barisbrg['Harga_Lama'];
              $discc=$barisbrg['disc'];
              $Modelnya=$barisbrg['Model'];
              $nmbrgnya=$barisbrg['Description'];
              $jmlnya=$barisbrg['qty'];
          }
      }
  }
  //4 =mng 3 =id 2 =func
  //getnamabrg(
  ?>
<?php if (($this->uri->segment(2)==='edit') && ($this->uri->segment(5)==='20')):?>
<?php 
  $kdb=$this->uri->segment(3);
  $nmbrgnya=getnamabrg($kdb);
?>
<input type="text" class="form-control" value="<?php echo (!empty($nmbrgnya)) ? $nmbrgnya : '';?>" readonly>
<input type="hidden" name="kdbarang" value="<?php echo(empty($kdb))? '': $kdb ;?>">
<?php else: ?>
<input type="text" class="form-control" onkeyup="showHintprod(this.value)" value="<?php echo (!empty($nmbrgnya)) ? $nmbrgnya : '';?>">
<input type="hidden" name="kdbarang" id="kdbarang" value="<?php echo (isset($_GET['isi2'])) ? $_GET['isi2'] : '';?>">
<?php endif;?>
<span  id="txtHprod"></span><br>