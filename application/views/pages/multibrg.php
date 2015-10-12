<label for="">Pilih metode diskon</label>

      <div class="radio">
        <label>
          <input type="radio" value="" name="cekdisc" id="ceknom" onclick="ceknomnya()">
          diskon berdasarkan Nominal
        </label>
        <div class="radio">
        <label>
          <input type="radio" value="" name="cekdisc" id="cekpersen" onclick="cekpersennya()">
          diskon berdasarkan persentase
        </label>
      </div>
      </div>    
<div class="page-header">

  <?php if (isset($_GET['isi'])):?>
  <?php
    $kirmdt=mysql_query("SELECT * FROM tempbarang WHERE idcus='".htmlspecialchars($_GET["isi"])."' AND idmng='".$idmnge."' AND idaksi='".$lastid."'");
        $arrkird=array();$arrkird2=array();
        $arrkird3=array();$arrkird4=array();
        $arrkird5=array();$arrkird6=array();
        while($bariskird=mysql_fetch_array($kirmdt)){ 
            $arrkird[]=$bariskird['kdbarang'];
            $arrkird2[]=$bariskird['Model'];
            $arrkird3[]=$bariskird['qty'];
            $arrkird4[]=$bariskird['disc'];
            $arrkird5[]=$bariskird['price'];
            $arrkird6[]=$bariskird['subtotal'];
        }
      $improduk=implode('|', $arrkird);$imModel=implode('|', $arrkird2);
      $imqty=implode('|', $arrkird3); 
      $imdisc=implode('|', $arrkird4);$imprice=implode('|', $arrkird5);$imsubtotal=implode('|', $arrkird6); 
?>
<input type="hidden" name="produk" value="<?php echo $improduk;?>" />
<input type="hidden" name="Model" value="<?php echo $imModel;?>" />
<input type="hidden" name="qty" value="<?php echo $imqty;?>" />
<input type="hidden" name="disc" value="<?php echo $imdisc;?>" />
<input type="hidden" name="price" value="<?php echo $imprice;?>" />
<input type="hidden" name="subtotal" value="<?php echo $imsubtotal;?>" />
<button  type="button" class="btn btn-default btn-xs" onclick="insert_tempbrg()">
<?php elseif ($this->uri->segment(4)==='13' && (isset($_GET['isi2']))) :?>
<button  type="button" class="btn btn-default btn-xs" onclick="insert_tempbrg()">
<?php else: ?>
<button  type="button" class="btn btn-default btn-xs">
<?php endif; ?>
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbspTambahkan Barang
</button>
</div>
<?php
if (isset($_GET['cancel'])) {
  unset($_GET['update']);
}
if (isset($_GET['savedit'])) {
  $dataedit=htmlspecialchars($_GET['savedit']);
  $pecahedit=explode(',', $dataedit);
  mysql_query("update tempbarang set qty='".$pecahedit[1]."',disc='".$pecahedit[2]."',subtotal='".$pecahedit[3]."' WHERE id='".$pecahedit[0]."'"); ?>
  <script type="text/javascript">
    window.location.href="?isi="+document.getElementById("idcustm").value;
    </script>  
  <?php 
}
if (isset($_GET['hapus'])) {
  $idtempbrg=htmlspecialchars($_GET['hapus']);
  mysql_query("DELETE FROM tempbarang WHERE id='".$idtempbrg."'"); ?>
<script type="text/javascript">
window.location.href="?isi="+document.getElementById("idcustm").value;
</script>  
<?php 
}
if (isset($_GET['update'])) {
  $idtempbrg=htmlspecialchars($_GET['update']);
  $kondisi='AND id NOT IN("'.$idtempbrg.'")';
  $updettempbrg=mysql_query("SELECT * FROM tempbarang WHERE id='".$idtempbrg."'");
  $isiupdate=array();
  while ($kolupdtempbrg=mysql_fetch_array($updettempbrg)) {
    $isiupdate[]=$kolupdtempbrg['kdbarang'];
    $isiupdate[]=$kolupdtempbrg['Model'];
    $isiupdate[]=$kolupdtempbrg['qty'];
    $isiupdate[]=$kolupdtempbrg['disc'];
    $isiupdate[]=$kolupdtempbrg['price'];
    $isiupdate[]=$kolupdtempbrg['subtotal'];
  }
}else{
  $kondisi='';
}
if (isset($_GET['arrbrg'])) {
  $larikbrg=htmlspecialchars($_GET['arrbrg']);
  $pecahbrg=explode(',', $larikbrg);
  (empty($pecahbrg[7])) ? $discnya=0 : $discnya=$pecahbrg[7];
  $tambahbrg=mysql_query("INSERT INTO tempbarang(idmng,idaksi,waktu,kdbarang,idcus,Model,qty,disc,price,subtotal) VALUES (".$pecahbrg[0].",".$pecahbrg[1].",'".date('Y-m-d')."-".$pecahbrg[2]."',".$pecahbrg[3].",".$pecahbrg[4].",'".$pecahbrg[5]."',".$pecahbrg[6].",".$discnya.",".$pecahbrg[8].",".$pecahbrg[9].")");
  if ($tambahbrg) { ?>
    <script language='javascript'>
    window.alert('data berhasil ditambahkan');
    window.location.href="?isi="+document.getElementById("idcustm").value;
    </script>
  <?php }else{ ?>
    <script language='javascript'>
    window.alert('data gagal ditambahkan :( ');
    window.location.href="?isi="+document.getElementById("idcustm").value;
    </script>
  <?php }
  unset($_GET['arrbrg']);
  
}
?>
<div class="table-responsive">
  <table class="table">
  	<thead>
  		<tr>
        <td>aksi</td>
  			<?php foreach ($koltempbrg as $kolbrg):?>
  				<td><?php echo $kolbrg;?></td>
  			<?php	endforeach;?>
  		</tr>
  	</thead>
  	<tbody>
      <tr>
        <td>
        <?php if (isset($_GET['update'])) {
          echo "<button type='button' onclick='saveedit()' class='btn btn-default btn-xs'>
                  <span class='glyphicon glyphicon-ok' aria-hidden='true'></span> simpan
                </button>
                <a href='?cancel' class='btn btn-default btn-xs'>
                  <span class='glyphicon glyphicon-remove' aria-hidden='true'></span> batal
                </a>";
        }?></td>
      <?php 
      foreach ($koltempbrg as $kolbrg):
      switch ($kolbrg) {
        case 'kdbarang':
          echo (isset($_GET['isi2']) && !isset($_GET['update'])) ? "<td><input type='text' id='kdbarang' value='".$_GET['isi2']."' readonly></td>" : "<td>";
          if (!empty($isiupdate[0])) {
            echo $isiupdate[0];
          }
          echo "</td>";
          break;
        case 'qty':
          echo (isset($_GET['isi2']) && !isset($_GET['update'])) ? "<td><input type='text' onkeyup='sub_ttl()' id='qty'></td>" : "<td>";
          if (!empty($isiupdate[2])) {
            echo "<input type='text' id='qty' onkeyup='sub_ttl()' value='".$isiupdate[2]."'>";
          }
          echo "</td>";
          break;
        case 'price':
          echo (!empty($price) && !isset($_GET['update'])) ? "<td><input type='text' ng-Model='price' id='hrgj' value='".$price."' readonly></td>" : "<td>";
          if (!empty($isiupdate[4])) {
            echo $isiupdate[4]."<input type='hidden' id='hrgj' ng-Model='price' value='".$isiupdate[4]."'>";
          }
          echo "</td>";
          break;
        case 'disc':
          (!empty($isiupdate[3])) ? $diskkon=$isiupdate[3]: $diskkon='0';
          echo (!empty($discc) && !isset($_GET['update'])) ? "<td><input type='text' onkeyup='sub_ttl()' id='disc' value='".$discc."'><input type='hidden' id='backupdisc' value='".$discc."'></td>" : "<td><input type='text' id='disc' value='".$diskkon."' onkeyup='sub_ttl()' ><input type='hidden' id='backupdisc' value='0'>";
          echo "</td>";
          break;
        case 'Model':
          echo (!empty($Modelnya) && !isset($_GET['update'])) ? "<td><input type='text' id='Model' value='".$Modelnya."' readonly></td>" : "<td>";
          if (!empty($isiupdate[1])) {
            echo $isiupdate[1];
          }
          echo "</td>";
          break;
        case 'subtotal':
          echo (isset($_GET['isi2']) && !isset($_GET['update'])) ? "<td><input type='text' id='subttl' value='' readonly></td>" : "<td>";
          if (!empty($isiupdate[5])) {
              echo "<input type='text' id='subttl' value='".$isiupdate[5]."'>";
          }
          echo "</td>";
          break;
        default:
          echo "<td></td>";
          break;
      }
      endforeach;?>
      </tr>
      
        <?php 

        if (isset($_GET["isi"])):
            $arrdatatemp=array();
            $arrsubt=array();
            $fields=array();
            $koltempb=mysql_query("SHOW COLUMNS FROM tempbarang WHERE Field NOT IN('idaksi','idmng','waktu','idcus')");
            while($field=mysql_fetch_object($koltempb)){
                $fields[]=$field;//collect each field into a array
            };
            $datatmpbrg=mysql_query("SELECT * FROM tempbarang WHERE idcus='".$_GET["isi"]."' AND idmng='".$idmnge."' AND idaksi='".$lastid."' ".$kondisi."");
            while($baristemp=mysql_fetch_array($datatmpbrg)) : 
            
              $arrsubt[]=$baristemp['subtotal'];
              
            ?>
            <tr>
                <?php foreach($fields as $key=>$field){ ?>
                <?php switch ($field->Field) {
                  case 'id':
                    echo "<td>
                    <a href='".curPageURL()."&hapus=".$baristemp[$field->Field]."'>hapus</a>|
                    <a href='".curPageURL()."&update=".$baristemp[$field->Field]."'>update</a>
                    <input type='hidden' name='".$field->Field."' value='".$baristemp[$field->Field]."'></td>";
                    break;
                  /*case 'subtotal':
                    //echo "<td><input type='hidden' name='".$field->Field."' value='".$baristemp[$field->Field]."'>".$baristemp[$field->Field]."</td>";
                    break;*/
                  default: ?>
                    <td><?php echo $baristemp[$field->Field];?></td>
                  <?php  break;
                } 
              } ?>
            </tr>
        <?php
          endwhile;
          endif;
        ?>      
      <tr>
          <td colspan="7" class="text-right">total</td>
          <td ><?php 
          if (isset($_GET["isi"])){
            $total=array_sum($arrsubt);
            echo $total;
            echo "<input type='hidden' name='total' value='".$total."' />";
          }else{
            echo $total='0';
            echo "<input type='hidden' name='total' value='".$total."' />";
          }
          ?></td>
      </tr>
  	</tbody>
  </table>
</div>
<p id="ceknya"></p>
<script>
function sub_ttl(){
  var qty = parseInt($('#qty').val());
  var price = parseInt($('#hrgj').val());
  var diskon=parseInt($('#disc').val());
  if (qty > <?php echo (isset($_GET['isi2']))? $jmlnya : 100;?>) {
      alert('quantity Barang tidak mencukupi');
  }else{
      if(document.getElementById('cekpersen').checked== true) {
        if (!diskon) {
            $('#subttl').val(qty*price);
        }else{
            $('#subttl').val(qty*price-price*(diskon/100));
        };
      }else if(document.getElementById('ceknom').checked== true) {
        $('#subttl').val(qty*(price-diskon));
      }else{
        alert("pilih dulu metode diskonnya COEG !");
      }
  }
  
  //val((qty * price ? qty * price : 0).toFixed(2));
}
function insert_tempbrg(){
  var newURL = window.location.protocol + "://" + window.location.host + "/" + window.location.pathname;
  var pathArray = window.location.pathname.split( '/' );
  var tabel = pathArray[7];
  var today=new Date();
  var h=today.getHours();
  var m=today.getMinutes();
  var s=today.getSeconds();
  var waktu=h+":"+m+":"+s;
  var arrbrg=[
    tabel,
    $('#lastid').val(),
    waktu,
    $('#kdbarang').val(),
    $('#idcustm').val(),
    $('#Model').val(),
    $('#qty').val(),
    $('#disc').val(),
    $('#hrgj').val(),
    $('#subttl').val()
    ];
  //alert(arrbrg);
  window.open(document.URL+"&arrbrg="+arrbrg,"_self");
}
function saveedit(){
  var kd=getUrlVars()["update"];
  var arrupdate=[
    kd,
    $('#qty').val(),
    $('#disc').val(),
    $('#subttl').val()
  ];
  window.open(document.URL+"&savedit="+arrupdate,"_self");
}
function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}
</script>
