<div class="page-header">
<?php
  $idme=$this->uri->segment(3);
  $idmngee=$this->uri->segment(5);
   ?>
  <?php if ((!empty($idme)) && (!empty($idmngee))): ?>
        <h1>Data <?php echo(getpagename($idme,$idmngee));?></h1>
  <?php else: ?>
        <h1>Dashboard</h1>
  <?php endif; ?>
</div>
<div class="row">
<div class="col-xs-12">
<!---->

<?php if ($this->uri->segment(5)!=='4') { ?>
            <?php foreach ($action as $vaction) { ?>
                <a href="<?php echo(site_url('gudang/slug/'.$curmenu.'/'.$vaction['idact'].'/'.$idmnge));?>"><?php echo($vaction['act']);?></a>
            <?php }?>
<?php } ?>
</div>
</div>
<div class="row">
  <div class="col-md-10">
  <?php if ((count($data) > 0) && (count($kolom) > 0)){ ?>
  <div class="table-responsive">
      <?php //include APPPATH."views/pages/table-data.php";?>
      <?php include APPPATH."views/pages/table-jq.php";?>
  </div>
<?php   }else{ ?>
    <script src="<?php echo base_url().'asset/js/table/jquery-1.11.1.min.js';?>"></script>
    <div class="alert alert-warning alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong> Warning ! </strong> <p>Tidak ada hasil yang ditampilkan :(</p>
    </div>
<?php   } ?>
  </div>
  <div class="col-md-2">
    
  </div>
</div>
</div>

