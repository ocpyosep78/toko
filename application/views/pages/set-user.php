 <?php
$uname='';$id=''; $tabell='';$idmennu='';
if (isset($_GET['del'])) {
    $dell=htmlspecialchars($_GET['del']);
    $expl=explode(',', $dell);
    $detuser=getuserbyid($expl[0]);
    $uname=$detuser['username'];;
    $id=$detuser['id'];
    $taabel=$detuser['jabatan'];
    $idmennu=$expl[1];
    $this->db->where('iduser',$id);
    $this->db->where('idmenu',$idmennu);
    $qupt=$this->db->update($taabel,array('idact'=>'0'));
    if ($qupt) {
      redirect(site_url('gudang/slug/4/4/5?isi='.$id));
    }else{?>
              <script type="text/javascript">alert('maaf terjadi kesalahan pada system :(');</script>
      <?php
    }
}
if (isset($_GET['isi'])) {
  $idu=htmlspecialchars($_GET['isi']);
  $detuser=getuserbyid($idu);
  $uname=$detuser['username'];
  $id=$detuser['id'];
  $tabell=$detuser['jabatan'];
}
if (isset($_POST['savemng'])) {
  $idus=$_POST['iu'];
  $rtridm=rtrim($_GET['idmn']);
  if (empty($rtridm)) {
    $idmnu='1';
  }else{
    $idmnu=htmlspecialchars($rtridm);
  }

  if (!empty($_POST['act'])){
    $error=array();
    $arract=$_POST['act'];
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
          $qdel=$this->db->delete($tabell,array('idmenu'=>$idmnu,'iduser'=>$idus,'idact'=>'0'));
          if ($qdel) {
              for ($c=0; $c < $nq; $c++) { 
                $datain = array(
                  'iduser' =>$idus,
                  'idmenu'=>$idmnu,
                  'idact'=>$qq[$c]
                  );
                $qin=$this->db->insert($tabell,$datain);
                if (!$qin) {
                  $error[]=$qq[$c]; 
                }
              }
              if (count($error) > 0) { ?>
                    <script type="text/javascript">alert('ada error sebanyak <?php echo count($error);?>');</script>
              <?php }
          }else{ ?>
              <script type="text/javascript">alert('maaf terjadi kesalahan pada system :(');</script>
              <?php
          }
      }else{

          $jml=count($arract);
          for ($e=0; $e < $jml; $e++) { 
            $dtin= array(
                  'iduser' =>$idus,
                  'idmenu'=>$idmnu,
                  'idact'=>$arract[$e]
                  );
            $qin2=$this->db->insert($tabell,$dtin);
            if (!$qin2) {
                $error[]=$arract[$e];
            }
          }
          if (count($error)) {?>
                    <script type="text/javascript">alert('ada error sebanyak <?php echo count($error);?>');</script>
        <?php
          }
      }
      unset($_GET['idmn']);
  }else{
    if (returnm($idmnu,$idus,$tabell)){
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


<script src="<?php echo base_url().'asset/js/table/jquery-1.11.1.min.js';?>"></script>
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

function clearcek(){
    var idu=document.getElementById('idus').value;
    var idmm=document.getElementById('idm').value;
    var arrdel=[idu,idmm];
    window.location.href="?del="+arrdel;
}
</script>


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
         <select class="form-control" name="menu" id="idm" onchange="window.location.href=document.URL+this.value">
              <?php 
          $idt=1;
          foreach ($lmenu as $vmng):?>
                
                <option value="<?php echo('&idmn='.$vmng['idmenu']);?>"
                <?php echo ((isset($_GET['idmn']) && ($_GET['idmn']===$vmng['idmenu']) || ($vmng['idmenu']==$idmennu)))? 'selected': '';?>>
                 <?php                 
                echo($vmng['menu']);?>
                </option>
            <?php endforeach;?>
              </select>
    </div>
    </td>
<?php 
$n=count($idact);
?>
<?php for ($x=0; $x < $n; $x++) { ?>
                  <td>
                  <?php
                   if ((isset($_GET['idmn'])) && (getcheckm($_GET['isi'],$_GET['idmn'],$idact[$x],$tabell))):?>
                      <span class="glyphicon glyphicon-ok"></span>
                  <?php else:?>
                          <div class="checkbox">
                        <label>
                          <input type="checkbox" value="<?php echo($idact[$x]);?>" name="act[]">
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