<script src="<?php echo base_url().'asset/js/default/jquery-1.9.1.js';?>"></script>
<script type="text/javascript">
$(document).ready(function() {
    var pane = $("#addr");
    pane.val($.trim(pane.val()).replace(/\s*[\r\n]+\s*/g, '\n')
                               .replace(/(<[^\/][^>]*>)\s*/g, '$1')
                               .replace(/\s*(<\/[^>]+>)/g, '$1'));
});
</script>
<?php $temp=0;?>
<div class="row">
  <div class="col-md-8">
    
<div class="page-header">

  <p id="hasilnye"></p>
<?php
if (isset($_GET['arrsts'])) {
    $lariksts=htmlspecialchars($_GET['arrsts']);
    if (updatelunas($lariksts)) {
        redirect(site_url('gudang/slug/1/11'));
    }
}?>
 
</div>
<?php echo form_open("gudang/insert");?>
<div class="form-group">
    <?php foreach ($kol as $row): ?>
      <label>
      <?php
          switch ($row) {
            case 'iduser':
              echo('username');
              break;
            case 'kdbarang':
              echo('Nama produk');
              break;
            case 'idimg':
              if ($this->uri->segment(5)==='20') {
                echo('Upload Brosur');
              }else{
                echo('Upload Gambar');
              }
              break;
            default:
              echo $row;
              break;
          }
      ?>
      </label>
      <?php switch ($row) {

        case 'idcus': 
        include APPPATH.'views/fields/idcus.php'; 
        break;
        case 'password': ?>
          <input type="password" class="form-control" id="" name="<?php echo($row);?>">
          <?php break;
          case 'email':
          if (empty($email)) {
            $email='';
          } ?>
          <input type="email" class="form-control" id="" name="<?php echo($row);?>" value="<?php echo($email);?>">
          <?php break;
        case 'tgl': ?>
          <input type="date" class="form-control" id="date" name="<?php echo($row);?>" value="">
          <?php break;
        case 'date': ?>
          <input type="date" class="form-control" id="date" name="<?php echo($row);?>" value="">
        <?php   break;
        case 'kdquo': ?>
          <input type="text" class="form-control" name="<?php echo($row);?>" value="<?php echo('THC/QUO/'.date('m/d').'/'.$lastid);?>" readonly>
          <input type="hidden" id="lastid" value="<?php echo $lastid;?>" />
          <?php 
          break;
        case 'kdinv': ?>
          <input type="text" class="form-control" name="<?php echo($row);?>" value="<?php echo('THC/INV/'.date('m/d').'/'.$lastid);?>" readonly>
          <input type="hidden" id="lastid" value="<?php echo $lastid;?>" />
          <?php break;
        case 'alamat': ?>
          <textarea class="form-control" id="addr" name="<?php echo($row);?>"><?php echo (!empty($alamate))? trim($alamate):''; ?></textarea>
        <?php  break;
        case 'catatan':  ?>
          <textarea class="form-control" id="addr" name="<?php echo($row);?>"></textarea>
        <?php   break;
        case 'address': ?>
        <textarea class="form-control" id="addr" name="<?php echo($row);?>"><?php echo (!empty($alamate))? trim($alamate):'';?></textarea>
          <?php break;
        case 'cust_address': ?>
          <textarea class="form-control" id="addr" name="<?php echo($row);?>"><?php echo (!empty($alamate))? trim($alamate):'';?></textarea>
          <?php break;
          case 'produk': ?>
         <?php include APPPATH.'views/fields/kdbarang.php'; ?>
        <?php  break;
          case 'price':
            if (empty($price)) {
              $price='';
            } ?>
            <input type="text" class="form-control" id="" name="<?php echo($row);?>" value="<?php echo($price);?>">
            <?php break;
          case 'fax':
            if (empty($fax)) {
              $fax='';
            }?>
            <input type="text" class="form-control" id="" name="<?php echo($row);?>" value="<?php echo($fax);?>">
            <?php 
            break;
          case 'telp':
            if (empty($telp)) {
              $telp='';
            } ?>
            <input type="text" class="form-control" id="" name="<?php echo($row);?>" value="<?php echo($telp);?>">
            <?php break;
          case 'disc':
            if (empty($discc)) {
              $discc='';
            } ?>
            <script type="text/javascript">
            function textLength(value){
                var maxLength = 100;
                if(value > maxLength) return false;
                return true;
          }
            function cekdisk(potongan){                
                if(!textLength(potongan)) alert('masukkan angka 0 s/d 100');
            }
            </script>
            <input type="text" class="form-control" id="diskoon" name="<?php echo $row;?>" value="<?php echo $discc;?>" onkeyup="cekdisk(this.value)"/>
            <?php 
            break;
          case 'Model':
            if (empty($Modelnya)) {
              $Modelnya='';
            } ?>
            <input type="text" class="form-control" id="" name="<?php echo($row);?>" value="<?php echo($Modelnya);?>">
            <?php break;

        case 'kdbarang': ?>
<!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->

<div class="well well-sm">
<?php if ($this->uri->segment(5)==='12' || $this->uri->segment(5)==='20' ) :?>
<?php include APPPATH.'views/fields/kdbarang.php'; ?>
<?php else :?>
<?php include APPPATH.'views/fields/kdbarang.php'; ?>
<?php include(APPPATH."views/pages/multibrg.php");?>
<?php endif;?>
</div>

<!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
        <?php  break;
        case 'idcus':
        include APPPATH.'views/fields/idcus.php';
        break;
        case 'stock': ?>
          <select name="<?php echo $row;?>" class="form-control" >
            <option value="r">Stok Tersedia</option>
            <option value="l">Stok Terbatas</option>
            <option value="o">Stok Habis</option>
          </select>
        <?php   break;
        case 'ket': ?>
          <textarea name="<?php echo($row)?>" class="form-control"></textarea>
        <?php  break;
        case 'kdcapab': ?>
          <select name="<?php echo $row;?>" class="form-control">
          <option value="0">pilih jabatan</option>
          <?php foreach ($cab as $vcab) { ?>
            <option value="<?php echo($vcab['kdcapab']);?>" <?php echo ((isset($_GET['cab'])) && ($vcab['kdcapab']===$_GET['cab']))? 'selected': '';?>><?php echo($vcab['jabatan']);?></option>
          <?php }?>
        </select>
        <?php  break;
        case 'idreq': ?>

        <?php if (isset($_GET['req'])): ?>
                  <script type="text/javascript">
        function cari(){
            var keyw=document.getElementById('namaprode').innerHTML;
            document.getElementById('btncari').href='https://www.google.com/#q='+keyw;

        }
        </script>
        <div class="form-group">
            <div class="input-group">
            <span class="input-group-btn">
              <a id="btncari" href="" target="blank" class="btn btn-default" onclick="cari()"><span class="glyphicon glyphicon-search"></span></a>
            </span>
              <label id="namaprode"> <?php echo (isset($_GET['req']))? getdescprod($_GET['req']) : '';?></label>
              <input type="hidden" value="<?php echo (isset($_GET['req']))? $_GET['req'] : '';?>" name="idreq">
            </div><!-- /input-group -->   
          </div>
        <?php else:?>
<div class="form-group">
          <label>cari request barang </label><a href="<?php echo(site_url('gudang/slug/17/4/21'))?>" class="btn btn-sm btn-primary">disini</a>
</div>
        <?php endif; ?>
        </div>
        <?php  break;
        case 'website': ?>
          <div class="form-group">
            <select name="website" class="form-control">
              <?php if (!empty($website)) { 
                foreach ($website as $valweb) { ?>
                  <option value="<?php echo($valweb['id']);?>"><?php echo($valweb['namaweb']);?></option>
                <?php }
                  }else{ ?>
                <option value="0">belum ada website</option>
              <?php  } ?>
            </select>
          </div>
<?php   break;
        case 'idimg': ?>
        <?php include APPPATH.'views/fields/uploadimg.php';?>
        <?php  break;
        default: ?>
          <input type="text" class="form-control" name="<?php echo($row);?>" >
          <?php
          break;
      }?>
      <?php endforeach;?>
     
      <?php
      if($this->uri->segment(5)=='6' || $this->uri->segment(5)=='7'){ ?>
          <?php include(APPPATH."views/pages/multibrg.php"); ?>
      <?php } ?>
  <input type="hidden" name="tabel" value="<?php echo $idtbl;?>">  
  <input type="hidden" name="kodeaksi" value="<?php echo $kodeaksi;?>">
  <button type="submit" class="btn btn-default" <?php echo($idtbl==='11')? 'style="display:none;"': '';?>>Submit</button>
<?php echo form_close();?>
<script> 
  /*var sel = document.getElementById("cusname");*/
  /*var text_value = sel.options[sel.selectedIndex].text;*/
  //alert(text_value);
/*function get_dataselect() {
    var url="<?php echo base_url();?>";
    var isi=document.getElementById("cusname").value;
    var isi2=document.getElementById("product").value;
    //document.getElementById("hasilnye").innerHTML = isi+","+isi2;
    window.location.href="?isi="+isi+"&isi2="+isi2;
}*/
function ceknomnya(){
    document.getElementById("disc").disabled = false;
}
function cekpersennya() {
    var diskonn=$("#backupdisc").val();
    document.getElementById("disc").value=diskonn;
    document.getElementById("disc").disabled = true;

}

</script>
  </div>
  <div class="col-md-4">

  </div>
</div>
