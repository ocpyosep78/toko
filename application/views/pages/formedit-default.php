<script src="<?php echo base_url().'asset/js/default/jquery-1.9.1.js';?>"></script>
<script type="text/javascript">
$(document).ready(function() {
    var pane = $("#addr");
    pane.val($.trim(pane.val()).replace(/\s*[\r\n]+\s*/g, '\n')
                               .replace(/(<[^\/][^>]*>)\s*/g, '$1')
                               .replace(/\s*(<\/[^>]+>)/g, '$1'));
});
</script>
<?php
$mng=$this->uri->segment(4);
if ($mng==='16'): ?>
  <?php
  $idreq=getreq_byantri($this->uri->segment(3));
  $brgreq=getkdbreq($idreq);?>
<div class="row">
  <div class="col-xs-12">
    <div class="page-header">
      <h1>
      <?php echo($brgreq);?>
      <a href="<?php echo(current_url().'/a?id='.$idreq.'&tbl=15');?>" class="btn btn-sm btn-primary">View details</a>
      </h1>
    </div>
  </div>
</div>
<?php endif;?>
<div class="row">
    <div class="col-xs-12">
        <div class="table-responsive">
        <table class="table">
        <?php 
        $n=count($kolom);
        foreach ($tabel as $row) {
            for ($x=0; $x < $n; $x++) {  ?>
           <?php if ($x==0): ?>
                        <input type="hidden" name="kolid" value="<?php echo $kolom[$x];?>">
                        <input type="hidden" name="<?php echo $kolom[$x];?>" value="<?php echo $row[$kolom[$x]];?>">
            <?php else :?>
              <?php switch ($kolom[$x]) {
                case 'password': ?>
                <tr>
                    <td>
                        <?php echo $kolom[$x];?>
                    </td>
                    <td>
                    <script type="text/javascript">
                    function cekpasslama(isinya) {                        
                        
                        var x=sha1(isinya);
                        var y=document.getElementById("cocokpass").value;
                        if (x==y) {
                            document.getElementById("msgcek").innerHTML="sama";
                            document.getElementById("passbaru").disabled = false;
                        }else{
                            document.getElementById("msgcek").innerHTML="tidak sama";
                            document.getElementById("passbaru").disabled = true;
                        };
                        return false;
                    }
                    function kosongpass () {
                        var x=document.getElementById("passlama").value;
                        if (x=='') { alert("masukkan password lama terlebih dahulu");};
                    }
                    </script>
                        <input type="password" class="form-control" id="passlama" onkeyup="cekpasslama(this.value)" placeholder="masukkan password lama"><div id="msgcek"></div><hr>
                        <input type="hidden" id="cocokpass" value="<?php echo $row[$kolom[$x]];?>" />
                        <input type="password" class="form-control" name="<?php echo $kolom[$x];?>" value="" id="passbaru" placeholder="masukkan password baru" onkeyup="kosongpass()">
                    </td>
                  </tr>
                  <?php break;
                case 'email': ?>
                <tr>
                    <td>
                        <?php echo $kolom[$x];?>
                    </td>
                    <td>
                        <input type="email" class="form-control" name="<?php echo $kolom[$x];?>" value="<?php echo $row[$kolom[$x]];?>">
                    </td>
                </tr>
                <?php  break;
                case 'alamat': ?>
                    <tr>
                    <td>
                        <?php echo $kolom[$x];?>
                    </td>
                    <td>
                        <textarea id="addr" class="form-control" name="<?php echo $kolom[$x];?>"><?php echo trim($row[$kolom[$x]]);?></textarea>
                    </td>
                </tr>
                <?php  break;
                case 'cust_address': ?>
                <tr>
                    <td>
                        <?php echo $kolom[$x];?>
                    </td>
                    <td>
                        <textarea id="addr" class="form-control" name="<?php echo $kolom[$x];?>"><?php echo trim($row[$kolom[$x]]);?></textarea>
                    </td>
                </tr>
                <?php  break;
                case 'bill_address': ?>
                <tr>
                    <td>
                        <?php echo $kolom[$x];?>
                    </td>
                    <td>
                        <textarea id="addr" class="form-control" name="<?php echo $kolom[$x];?>"><?php echo trim($row[$kolom[$x]]);?></textarea>
                    </td>
                </tr>
                <?php  break;
                case 'ship_address': ?>
                <tr>
                    <td>
                        <?php echo $kolom[$x];?>
                    </td>
                    <td>
                        <textarea id="addr" class="form-control" name="<?php echo $kolom[$x];?>"><?php echo trim($row[$kolom[$x]]);?></textarea>
                    </td>
                </tr>
                <?php  break;
                case 'address': ?>
                <tr>
                    <td>
                        <?php echo $kolom[$x];?>
                    </td>
                    <td>
                        <textarea id="addr" class="form-control" name="<?php echo $kolom[$x];?>"><?php echo trim($row[$kolom[$x]]);?></textarea>
                    </td>
                </tr>
                <?php  break;
                case 'stock': ?>
                <tr>
                    <td>
                        <?php echo $kolom[$x];?>
                    </td>
                    <td>
                    <select name="<?php echo $kolom[$x];?>" class="form-control">
                    <?php if (!empty($row[$kolom[$x]])):?>
                      <?php
                        switch ($row[$kolom[$x]]) {
                          case 'a': ?>
                          <option value="<?php echo $row[$kolom[$x]];?>" selected>
                            Stok Tersedia                           
                            </option>
                            <option value="l">Stock indent</option>
                        <?php  break;
                          case 'l': ?>
                          <option value="<?php echo $row[$kolom[$x]];?>" selected>
                          Stok indent
                          </option>
                          <option value="a">Stok Tersedia</option>
                          <?php   break;
                          default: ?>
                          <option value="<?php echo $row[$kolom[$x]];?>" selected>
                          silahkan pilih
                          </option>
                          <option value="a">Stok Tersedia</option>
                          <option value="l">Stock indent</option>
                          <?php  break;
                        }
                      ?>
                      <?php endif; ?>
                      </select>
                    </td>
                </tr>
                <?php    break;
                case 'idaksi': ?>
                  <tr>
                    <td>
                        kode Invoice             
                    </td>
                    <td>
                        <?php $getdata=mysql_query("SELECT kdinv FROM invoice WHERE id='".$row[$kolom[$x]]."'");
                        while ($bhsl=mysql_fetch_array($getdata)) { ?>
                          <input type="text" class="form-control" name="<?php echo $kolom[$x];?>" value="<?php echo $bhsl['kdinv'];?>" onkeyup="persen(this.value)" readonly/>
                        <?php }?>
                        <?php mysql_free_result($getdata);?>
                    </td>
                </tr>
                <?php  break;
              case 'kdbarang': ?>
            <tr>
              <td>
                Nama Produk
              </td>
              <td>
                <?php 
                $mng=$this->uri->segment(4);
                switch ($mng) {
                    case '20':  ?>
                    <label><?php echo getnamabrg($row[$kolom[$x]]);?></label>
                    <input type="hidden" class="form-control" name="<?php echo $kolom[$x];?>" value="<?php echo $row[$kolom[$x]];?>">
                <?php    break;
                    default: ?>
                <?php if (isset($_GET['ubahkd'])) { ?>
                    <?php include APPPATH.'views/fields/kdbarang.php'; ?>
                    <a href="<?php echo(site_url('gudang/edit/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5)));?>">Batal</a>
                <?php }else{ ?>
                    <input type="text" class="form-control" name="namaprod" value="<?php echo getnamabrg($row[$kolom[$x]]);?>">
                    <input type="hidden" class="form-control" name="<?php echo $kolom[$x];?>" value="<?php echo $row[$kolom[$x]];?>">
                    <a href="<?php echo(current_url().'?ubahkd')?>">Edit</a>
                <?php }?>
                    <?php 
                    break;
                }
                ?>
              </td>
            </tr>
              <?php  break;
            case 'idimg': ?>
            <tr>

              <td colspan="2">
                <?php include APPPATH.'views/fields/uploadimg.php';?>
              </td>
            </tr>
          <?php   break;
          case 'iduser': ?>
          <tr>
            <td>
              Username
          </td>
          <td>
              <label><?php echo(getuname($row[$kolom[$x]]));?></label><input type="hidden" name="<?php echo $kolom[$x];?>" value="<?php echo $row[$kolom[$x]];?>">
          </td>
          </tr>
           <?php    break;
        case 'ket': ?>
                    <tr>
                    <td>
                        <?php echo $kolom[$x];?>
                    </td>
                    <td>
                        <textarea id="addr" class="form-control" name="<?php echo $kolom[$x];?>" ><?php echo $row[$kolom[$x]];?></textarea>
                    </td>
                </tr> 
            <?php break;
          case 'status': ?>
            <td>
                        <?php echo $kolom[$x];?>
            </td>
            <td>
              <label><?php echo(tandastts($row[$kolom[$x]]));?></label>
            </td>
              <?php break;
                default: ?>
                <tr>
                    <td>
                        <?php echo $kolom[$x];?>
                    </td>
                    <td>
                        <input type="text" class="form-control" name="<?php echo $kolom[$x];?>" value="<?php echo $row[$kolom[$x]];?>">
                    </td>
                </tr> 
                <?php  break;
              }?>
            <?php endif;?> 
<?php 
}
} ?>
        </table>
        </div>
    </div>
</div>