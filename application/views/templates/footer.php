</div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <!-- jQuery  -->
    
    
    <!--<script type="text/javascript">
    /*window.onbeforeunload = function (e) {
    e = e || window.event;

    // For IE and Firefox prior to version 4
    if (e) {
        e.returnValue = 'JVM Said';
    }

    // For Safari
    return 'JVM said';*/
};
    </script>-->

<!-- Modal -->
<style type="text/css">
  .img-responsive {
    margin: 0 auto;
  }
</style>
<script type="text/javascript">
     function klik() {
      document.getElementById('btnmodal').click();
  }
  function unset(){
    var url = document.URL;
    url = url.substring(0, url.lastIndexOf("/") + 1);
    window.location.href=url;
      //window.location.origin = window.location.protocol+"//"+window.location.host;
     //window.location.href='gudang';
  }
</script>

<div style="display:none;">
    <a href="#tallModal" id="btnmodal" data-toggle="modal" >
    Launch modal
    </a>
</div>
<div class="modal modal-wide fade" id="tallModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true" onclick="unset()">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Detail data <?php echo (isset($_GET['tbl']))? getnamatbl($_GET['tbl']) : '-';?></h4>
      </div>
      <div class="modal-body">
<!-- preview gambar -->

<?php if (isset($_GET['img'])) {
  $idimge=htmlspecialchars($_GET['img']);
  $cekarrid=cekurlid('image','idimg');
  if (in_array($idimge, $cekarrid)) {
      $path=geturl_img($idimge);
      if ((strlen($path) > 0) && (!is_null($path))) {
      $src=substr($path, 21); ?>
          <img src="<?php echo(base_url().$src);?>" class="img-responsive" alt="thumbnail" />  
      <?php     
       }else{
          echo('tidak ada info lokasi');
        }
  }else{
      echo('tidak terdaftar :(');
  }
}

?>


<!-- preview gambar -->

<!-- table req details -->

<?php if ((isset($_GET['idreq'])) && (isset($_GET['tbl']))): ?>
<?php
        $tbl=htmlspecialchars($_GET['tbl']);
        $dafkol=$this->db->list_fields('purchase');
        $fkol=array_shift(array_slice($dafkol, 0, 1));
        $idreqs=rtrim(htmlspecialchars($_GET['idreq']));
        $cekurld=cekurlid('purchase','idreq');
        if (in_array($idreqs, $cekurld)){
            $datanya=getpurc_byst($tbl,$idreqs);

             ?>

            <div class="table-responsive">
            <table class="table table-bordered">
            <thead>
              <tr>
              <?php if (is_admin() || is_mimin()): ?>
                <th>Aksi</th>
              <?php endif;?>
                    <?php foreach ($dafkol as $kol) { ?>
                          <th><?php echo($kol);?></th>
                    <?php }?>
              </tr>
            </thead>
            <tfoot>
              <tr>
                    <?php if (is_admin() || is_mimin()): ?>
                    <th>Aksi</th>
                    <?php endif;?>
                    <?php foreach ($dafkol as $kol) { ?>
                          <th><?php echo($kol);?></th>
                    <?php }?>
              </tr>
            </tfoot>
            <tbody>
              <?php foreach ($datanya as $valdata) {?>
                  <tr>
                  <?php if (is_admin() || is_mimin()): ?>
                  <td>
                       <div class="btn-group" role="group"  >
                                <?php
                                $cektemp=gettemp_data($fkol,$tabel);
                                if ($cektemp): ?> 
                                    <span class="<?php echo($cektemp['klas']);?>" data-toggle="tooltip" data-placement="top" title="<?php echo($cektemp['toolstip']);?>"></span >
                                    <?php
                                    if (is_admin()) { ?>
                                        <a href="<?php echo(site_url('gudang/deltempdata/'.$valdata[$fkol].'/'.$tabel));?>"  class="btn btn-sm btn-success" role="group">Acc</a>
                                        <a href="<?php echo(site_url('gudang/deltdata/'.$valdata[$fkol].'/'.$tabel));?>"  class="btn btn-sm btn-danger" role="group">Reject</a>
                                    <?php } ?>
                                <?php else : ?>
                                <?php if ($tbl!=='4') { ?>
                                  <a href="<?php echo(site_url('gudang/edit/'.$valdata[$fkol].'/'.$tbl.'/'.$fkol));?>"  class="btn btn-sm btn-primary" role="group">edit</a>
                                <?php }?>
                                <a href="<?php echo(site_url('gudang/delete/'.$valdata[$fkol].'/'.$tbl.'/'.$fkol));?>"  class="btn btn-sm btn-primary" role="group">delete</a>
                                <?php endif;?>
                                </div>
                  </td>
                  <?php endif;?>
                      <?php foreach ($dafkol as $valkol) {?>
                          <td><?php echo($valdata[$valkol]);?></td>
                      <?php }?>    
                  </tr>
                  <?php }?>
            </tbody>
            </table>
            </div>


        <?php }else{
              echo('tak terdaftar');
        } ?>
<?php endif; ?>
<!-- table req details -->


<!-- table details -->

<?php if ((isset($_GET['id'])) && (isset($_GET['tbl']))): ?>
<?php
        $tbl=htmlspecialchars($_GET['tbl']);
        $tabel=getnamatbl($tbl);
        $dafkol=$this->db->list_fields($tabel);
        $fkol=array_shift(array_slice($dafkol, 0, 1));
        $id=rtrim(htmlspecialchars($_GET['id']));
        $cekurld=cekurlid($tabel,$fkol);
        if (in_array($id, $cekurld)){
            $datanya=get_details($id,$tbl); ?>
            <div class="table-responsive">
            <table class="table table-bordered">
            <thead>
              <tr>
              <?php if (is_admin() || is_mimin()): ?>
                    <th>Aksi</th>
              <?php endif;?>
              <?php if (in_array('idimg', $dafkol)): ?>
                  <th>download</th>
              <?php endif;?>
                    <?php foreach ($dafkol as $kol) { ?>
                          <th><?php echo($kol);?></th>
                    <?php }?>
              </tr>
            </thead>
            <tfoot>
              <tr>
                  <?php if (is_admin() || is_mimin()): ?>
                    <th>Aksi</th>
                    <?php endif;?>
                    <?php if (in_array('idimg', $dafkol)): ?>
                  <th>download</th>
              <?php endif;?>
                    <?php foreach ($dafkol as $kol) { ?>
                          <th><?php echo($kol);?></th>
                    <?php }?>
              </tr>
            </tfoot>
            <tbody>
              <?php foreach ($datanya as $valdata) {?>
                  <tr>
                  <?php if (is_admin() || is_mimin()): ?>
                      <td>
                          <div class="btn-group" role="group"  >
                                <?php
                                $cektemp=gettemp_data($fkol,$tabel);
                                if ($cektemp): ?> 
                                    <span class="<?php echo($cektemp['klas']);?>" data-toggle="tooltip" data-placement="top" title="<?php echo($cektemp['toolstip']);?>"></span >
                                    <?php
                                    if (is_admin()) { ?>
                                        <a href="<?php echo(site_url('gudang/deltempdata/'.$valdata[$fkol].'/'.$tabel));?>"  class="btn btn-sm btn-success" role="group">Acc</a>
                                        <a href="<?php echo(site_url('gudang/deltdata/'.$valdata[$fkol].'/'.$tabel));?>"  class="btn btn-sm btn-danger" role="group">Reject</a>
                                    <?php } ?>
                                <?php else : ?>
                                <?php if ($tbl==='15'){ ?>
                                <a href="<?php echo(site_url('gudang/slug/17/1/16?req='.$valdata['idreq']));?>"  class="btn btn-sm btn-danger" role="group">search</a>
                                <?php }?>
                                <?php if ($tbl!=='4') { ?>
                                  <a href="<?php echo(site_url('gudang/edit/'.$valdata[$fkol].'/'.$tbl.'/'.$fkol));?>"  class="btn btn-sm btn-primary" role="group">edit</a>
                                <?php }?>
                                <a href="<?php echo(site_url('gudang/delete/'.$valdata[$fkol].'/'.$tbl.'/'.$fkol));?>"  class="btn btn-sm btn-primary" role="group">delete</a>
                                <?php endif;?>
                                </div>
                      </td>
                      <?php endif;?>
                      <?php if (in_array('idimg', $dafkol)): ?>
                        <td>
                          <?php 
                          $rtrimimg=rtrim($valdata['idimg']);
                          if ((empty($rtrimimg)) && (strlen($rtrimimg)===0)) {
                              $siuser=datauser();
                              if ($siuser['jabatan']==='designer') { ?>
                                <a href="<?php echo(site_url('gudang/edit/'.$valdata[$fkol].'/20/'.$fkol))?>" class="btn btn-sm btn-primary">upload</a>
                              <?php }
                          }else{ ?>
                            <a href="<?php echo(site_url('gudang/getimage/'.$rtrimimg))?>" class="btn btn-sm btn-success">download</a>
                          <?php } ?>
                        </td>
                      <?php endif;?>
                      <?php foreach ($dafkol as $valkol) {?>
                          <td><?php echo($valdata[$valkol]);?></td>
                      <?php }?>    
                  </tr>
                  <?php }?>
            </tbody>
            </table>
            </div>

        <?php }else{
            echo('tak terdaftar');
        } ?>
<?php endif; ?>
<!-- table details -->



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="unset()">Close</button>
      </div>
    </div>
  </div>
</div>
    <script src="<?php echo base_url().'asset/js/default/bootstrap.min.js';?>"></script>

    <!--<script src="<?php //echo base_url().'asset/js/default/jquery.autocomplete.js';?>"></script>-->
    <script src="<?php echo base_url().'asset/js/default/sha1.js';?>"></script>
  
        
</body>
</html>
<?php ob_end_flush();?>