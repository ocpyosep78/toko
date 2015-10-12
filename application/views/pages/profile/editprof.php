<div class="row">
  <div class="col-md-4">
    <h1 class="text-primary"><span class="glyphicon glyphicon-user"></span>Edit profile</h1>
  </div>
  <div class="col-md-8" style="padding-top:20px;">
    <a href="<?php echo(site_url('gudang/profile'));?>" class="btn btn-lg btn-primary ">Cancel</a>
  </div>
</div>
      <hr>
  <div class="row">
      <!-- left column -->
      <div class="col-md-3">
        <div class="text-center">
          <img src="//placehold.it/100" class="avatar img-circle" alt="avatar">
          <h6>Upload a different photo...</h6>
          
          <input type="file" class="form-control">
        </div>
      </div>
      
      <!-- edit form column -->
      <div class="col-md-9 personal-info">
        <!--<div class="alert alert-info alert-dismissable">
          <a class="panel-close close" data-dismiss="alert">×</a> 
          <i class="fa fa-coffee"></i>
          This is an <strong>.alert</strong>. Use this to show important messages to the user.
        </div>-->
        <h3>Personal info</h3>
        
        <form class="form-horizontal" role="form" enctype="multipart/form-data" action="<?php echo(site_url('gudang/editprof'));?>" name="saveprof" method="post">
              <?php foreach ($detuser as $vdetu): ?>
            <?php foreach ($likol as $vkol): ?>
               <?php if ($vkol!=='id' && $vkol!=='acc' ):?>
          <div class="form-group">
          
            <label class="col-lg-3 control-label">
            <?php 
            switch ($vkol) {
              case 'kdcapab':
                echo('jabatan');
                break;
              case 'nohp':
                echo('No. Handphone');
                break;
              case 'nama':
                echo('real name');
                break;
              case 'telp':
                echo('No. Telephone');
                break;
              default:
                echo($vkol);
                break;
            }
            ?></label>
            <div class="col-lg-8">
          <?php
            switch ($vkol) {
              case 'ttd': 
                 include APPPATH.'views/fields/uploadimg.php';
                break;
              case 'password':?>
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
                        <input type="password" class="form-control" id="passlama" onkeyup="cekpasslama(this.value)" placeholder="masukkan password lama"><div id="msgcek"></div><hr style="margin:-1px;">
                        <input type="hidden" id="cocokpass" value="<?php echo $vdetu[$vkol];?>" />
                        <input type="password" class="form-control" name="<?php echo $vkol;?>" value="" id="passbaru" placeholder="masukkan password baru" onkeyup="kosongpass()">

                <?php 
                break;
              case 'website': ?>
                 <div class="col-md-4">
            <button class="btn btn-default" type="button" id="btnweb"><span class="glyphicon glyphicon-plus"></span></button>
          </div>
          <div class="col-md-8">
          <div class="form-group">
            <input type="text" class="form-control web" placeholder="nama website" name="namaweb" />
          </div>
          <div class="form-group">
            <input type="text" class="form-control web" placeholder="link website" name="website" />
          </div>
          </div>
          <table class="table table-bordered">
          <thead>
              <tr>
              <td>aksi</td>
              <td>No</td>
              <td>Nama website</td>
              <td>Link website</td>
            </tr>
          </thead>
          <tbody>
          <?php if ((isset($website)) && (!empty($website)) ):
          $x=1;
          ?>
            <?php foreach ($website as $vwebsite) { ?>
            <tr>
            <td>
              <a href="<?php echo(site_url('gudang/edit/'.$vwebsite['id'].'/18/id'));?>">edit</a>
              <a href="<?php echo(site_url('gudang/delete/'.$vwebsite['id'].'/18/id'));?>">delete</a>
            </td>
            <td><?php echo($x);?></td>
              <td>
                <?php echo($vwebsite['namaweb']);?>
              </td>
              <td>
                <?php echo($vwebsite['website']);?>
              </td>
            </tr>
            <?php 
            $x++;
            }?>
            <?php else: ?>
            <tr>
              <td>0</td>
              <td colspan="2">belum ada link website</td>
            </tr>
          <?php endif; ?>
          </tbody>
          </table>
                <?php break;
              default:?>
                <input class="form-control" type="text" value="<?php echo($vdetu[$vkol]);?>" name="<?php echo($vkol);?>" />
                <?php break;
            }
            ?>
            </div>
          </div>
        <?php endif;?>
          <?php endforeach; ?>
          <?php endforeach; ?>
          <button type="submit" class="btn btn-lg btn-primary">save</button>
        </form>
      </div>
  </div>