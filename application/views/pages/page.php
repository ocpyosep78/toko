<script src="<?php echo base_url().'asset/js/default/jquery.min.js';?>"></script>
<script type="text/javascript">
  $(document).ready(function(){
    if ($('#cun').val().length==0) {
      document.getElementById('btnsv').disabled=true;
      document.getElementById('btnres').disabled=true;
    }else{
      document.getElementById('btnsv').disabled=false;
      document.getElementById('btnres').disabled=false;
    }
});
</script>
<div class="row">
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <?php foreach ($page as $val): ?>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="<?php echo '#'.$val['idpage'];?>" aria-expanded="true" aria-controls="<?php echo $val['idpage'];?>">
          <?php echo $val['page_name'];?>
        </a>
      </h4>
    </div>
    <div id="<?php echo $val['idpage'];?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body">
        <div class="row">
<?php if($val['page_name']!="Beranda"):?>
<div class="row">
  <div class="col-xs-12">
   
  </div>
</div>
<div class="row">
<div class="col-md-8">
<?php if ($this->uri->segment(3)==='4'): ?>
  <script type="text/javascript">

function showHint(str) {
     if (str.length === 0) { 
        document.getElementById('btnsv').disabled=true;
        document.getElementById('btnres').disabled=true;
         document.getElementById("txtHint").innerHTML = "";
         return;
     } else {
         var xmlhttp = new XMLHttpRequest();
         xmlhttp.onreadystatechange = function() {
             if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                 document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
             }
         }
         xmlhttp.open("GET", window.location.origin+"/toko/gudang/getuser?q="+str, true);
         xmlhttp.send();
     }
}
function doalert(obj){
      document.getElementById("hasilul").style.display = "none";
      window.location.href="?isi="+obj.getAttribute("href");
      return false;
}
 function setmenu(idmn){
      var uname=document.getElementById('cun').value;
          if (uname.length==0) { 
              alert('cari dulu nama usernya :)');
              window.location.href=document.URL;
          }else{
              window.location.href=document.URL+"&idmn="+idmn;
          }
        }
function clearcek(){
    var idu=document.getElementById('idus').value;
    var idmm=document.getElementById('idm').value;
    var arrdel=[idu,idmm];
    window.location.href="?del="+arrdel;
}
</script>
<?php
$uname='';$id=''; $tabell='';$idmennu='';
if (isset($_GET['del'])) {
    $dell=htmlspecialchars($_GET['del']);
    $expl=explode(',', $dell);
    $arruserr=getuser($expl[0]);
    $uname=$arruserr[1];
    $id=$arruserr[0];
    $taabel=returncab($arruserr[2]);
    $idmennu=$expl[1];
    mysql_query("UPDATE ".$taabel." SET idact='0' WHERE iduser='".$id."' AND idmenu='".$idmennu."'");
    redirect(site_url('gudang/page/4?isi='.$id));
}
if (isset($_GET['isi'])) {
  $idu=htmlspecialchars($_GET['isi']);
  $arrdata=getuser($idu);
  $uname=$arrdata[1];
  $id=$arrdata[0];
  $idsr=$arrdata[2];
  $tabell=returncab($idsr);
}
if (isset($_POST['savemng'])) {
  $arract=$_POST['act'];
  $idus=$_POST['iu'];
  $idmnu=$_POST['menu'];
  if (!empty($_POST['act'])) {
      if (returnact($idus,$idmnu,$tabell)) {
          $qq=returnact($idus,$idmnu,$tabell);
          $nq=count($qq);
          for ($a=0; $a < $nq; $a++) { 
            if (isset($arract[$a])){
              $qq[$a]=$arract[$a];
            }else{
              $qq[$a]=0;
            }
           }
          mysql_query("DELETE FROM ".$tabell." WHERE idmenu='".$idmnu."' AND iduser='".$idus."' AND idact='0'");
          for ($c=0; $c < $nq; $c++) { 
              mysql_query("INSERT INTO ".$tabell." VALUES('".$idus."','".$idmnu."','".$qq[$c]."')");
          }
          mysql_close();
      }else{
          $jml=count($arract);
          for ($e=0; $e < $jml; $e++) { 
            mysql_query("INSERT INTO ".$tabell." VALUES(".$idus.",".$idmnu.",".$arract[$e].")");
          }
      }
      unset($_GET['idmn']);
  }else{
    if (returnm($idmnu,$idus,$tabell)) {
      unset($_GET['idmn']);
    }else{
      $datacab = array(
        'iduser' =>$idus,
        'idmenu'=>$idmnu,
        'idact'=>'0' 
      );
      insertdata($tabell,$datacab);
      unset($_GET['idmn']);
    }
  }
}
?>
  <form class="form-inline" action="<?php $_SERVER['PHP_SELF'];?>" method="post" name="savemng">
  <table class="table table-bordered text-center">
  <tr>
    <td rowspan="2">Nama User</td>
    <td rowspan="2">Menu</td>
    <td colspan="4">Capability</td>
    <td rowspan="2">Aksi</td>
  </tr>
  <tr>
            <td>create</td>
            <td>import</td>
            <td>export</td>
            <td>Details</td>
  </tr>
  <tr>
    <td>
    <div class="form-group">
    <input type="text" class="form-control" onkeyup="showHint(this.value)" value="<?php echo $uname;?>" id="cun">
    <input type="hidden" name="iu" value="<?php echo $id;?>" id="idus">
    <span id="txtHint"></span>
    </div>
    </td>
    <td>
    <div class="form-group">
         <select class="form-control" name="menu" onchange="setmenu(this.value)" id="idm">
              <?php 
          $idt=1;
          foreach ($lmenu as $vmng):?>
                <option value="<?php echo($vmng['idmenu']);?>"
                <?php echo ((isset($_GET['idmn']) && ($_GET['idmn']===$vmng['idmenu']) || ($vmng['idmenu']==$idmennu)))? 'selected': '';?>>
                <?php                 
                echo($vmng['menu']);?>
                </option>
            <?php endforeach;?>
              </select>
    </div>
    </td>
<?php $akksi=explode(',', $idact);
$n=count($akksi);
?>
<?php for ($x=0; $x < $n; $x++) { ?>
                  <td>
                  <?php
                   if ((isset($_GET['idmn'])) && (getcheckm($_GET['isi'],$_GET['idmn'],$akksi[$x],$tabell))):?>
                      <span class="glyphicon glyphicon-ok"></span>
                  <?php else:?>
                          <div class="checkbox">
                        <label>
                          <input type="checkbox" value="<?php echo($akksi[$x]);?>" name="act[]">
                          </label>
                      </div>
                  <?php endif;?>
                  </td>                  
<?php } ?>
    <td>
    <div class="btn-group" role="group" aria-label="...">
    <button type="submit" name="savemng" class="btn btn-sm btn-success" id="btnsv" disabled>create</button> 
    <button type="button" onclick="clearcek()" class="btn btn-sm btn-primary" id="btnres" disabled>reset</button>
    </div>
    </td>
  </tr>
  </table>
  </form>
<?php endif;?>
            <ul class="list-inline">
            <?php foreach ($action as $isiact) { ?>
              <li><a href="<?php echo base_url('gudang/slug/'.$isiact['idact'].'/'.$val['idmng']);?>"><?php echo $isiact["act"];?></a></li>
            <?php }?>
            </ul>
<div class="table-responsive">
     <?php echo $this->table->generate($tabel); ?>
 <?php echo $this->pagination->create_links(); ?>
</div>
</div>
</div>
<?php else:?>
  <h1>Log aktivitas</h1>
  <div class="row">
    <div class="col-xs-6">
        <div class="table-responsive">
  <table class="table table-bordered">
  <?php 
  $file = 'log.txt';
  $pathfile=APPPATH.'views/'.$file;
  $myfile = fopen($pathfile, "r") or die("Unable to open file!");
  if (filesize($pathfile)===0) { ?>
  <tr>
    <td> Belum ada Riwayat</td>
  </tr>
  <?php }else{ 
      $datalog=fread($myfile,filesize($pathfile));
      $pecah=explode("\r\n", $datalog);
      $n=count($pecah);  ?>
      <?php for ($i=0; $i < $n; $i++) {  ?>
      <tr>
        <?php //echo $pecah[$i];
        if ($pecah[$i]!='') {
          $pecahlagi=explode(',', $pecah[$i]);
          $jml=count($pecahlagi);
          for ($jj=0; $jj < $jml; $jj++) { ?>
             <td><?php echo $pecahlagi[$jj];?></td>
          <?php }
      }
      ?>
      </tr><?php } fclose($myfile);
    } ?>
  </table>
</div>

    </div>
    <div class="col-xs-6">
   
    </div>
  </div>
<?php endif;?>

        </div>
      </div>
    </div>
  </div>
  <?php   endforeach; ?>
</div>
</div> 