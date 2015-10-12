 <table class="table">
      <tr>
        <td colspan="2" class="text-right">
        <?php if (!isset($_GET['edit'])) { ?>
          <a href="<?php echo(current_url().'?tab=1&edit');?>" class="btn btn-sm btn-default">
            <i class="glyphicon glyphicon-pencil">edit</i>
          </a>
        <?php }else{ ?>
        <a href="<?php echo(site_url('gudang/profile?tab=1'));?>" class="btn btn-sm btn-default">
            <i class="glyphicon glyphicon-remove">cancel</i>
        </a>
        <?php }?>
        </td>
      </tr>
      <?php if (!isset($_GET['edit'])) { ?>
        <tr>
        <td>Username :</td>
        <td><?php echo $infouser['username'];?></td>
      </tr>
      <tr>
        <td>User Level :</td>
        <td><?php echo $infouser['jabatan'];?></td>
      </tr>
      <?php 
      
      foreach ($detuser as $vdetu): ?>
      <?php foreach ($likol as $vkol): ?>
        <?php if ($vkol!=='username' && $vkol!=='kdcapab' && $vkol!=='password' && $vkol!=='acc') {?>
          <tr>
            <td><?php echo($vkol);?></td>
            <td>
            <?php 
            switch ($vkol) {
              case 'website':
                $pchweb=explode(',', $vdetu[$vkol]);
                  $cpchw=count($pchweb);
                  for ($wb=0; $wb < $cpchw; $wb++) { 
                    echo '<a href="'.geturlweb($pchweb[$wb]).'" target="blank">'.geturlweb($pchweb[$wb]) .'</a><br>';
                  }
                break;
              case 'ttd': ?>
                <?php if (($vdetu[$vkol]===0)) {
                  echo('silahkan upload scan ttd');
                }else{ 
                  $path=geturl_img($vdetu[$vkol]);
                  $src=substr($path,21);
                  $urlimg=base_url().$src;  
                  ?>
                <img src="<?php echo((empty($urlimg)) || (strlen($urlimg)===0))? 'kosong' : $urlimg;?>" class="image-responsive" alt="<?php echo('tanda tangan '.$infouser['username'])?>" />
                <?php }?>
              <?php   break;
              default:
                echo($vdetu[$vkol]);
                break;
            }?>
            </td>
          </tr>
        <?php }?>
      <?php endforeach; ?>
      <?php endforeach; ?>
      <?php }else{ 
        
        ?>
      <form enctype="multipart/form-data" action="<?php echo(site_url('gudang/editprof'));?>" name="saveprof" method="post">
      <?php 
      foreach ($detuser as $vdetu) {
      foreach ($likol as $vkol) {?>
      <tr>
        <?php
      switch ($vkol) {
        case 'website': ?>
          <td>
            <label ><?php echo($vkol);?></label>
          </td>
          <td>
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
          <?php if (($website) && (!empty($website)) ):
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
          </td>
        <?php   break;
        case 'password':?>
          <td><label ><?php echo($vkol);?></label></td>
          <td>
            <input type="hidden" value="<?php echo($vdetu[$vkol]);?>" id="cocokpass" />
            <div class="form-group">
            <input type="password" name="<?php echo($vkol.'lm');?>" class="form-control" placeholder="password lama" onkeyup="cekpasslama(this.value)">
            <div id="msgcek"></div>
            </div>
            <div class="form-group">
            <input type="password" name="<?php echo($vkol);?>" class="form-control" id="passbaru" placeholder="password baru">
            </div>
          </td>
          <?php break;
        case 'ttd': ?>
          <td>
            <label> Upload tanda tangan</label>
          </td>
          <td>
              <?php include APPPATH.'views/fields/uploadimg.php';?>
          </td>
          <?php break;
        default:?>
        <?php if ($vkol!=='id' && $vkol!=='kdcapab' && $vkol!=='acc') { ?>
          <td><label ><?php echo($vkol);?></label></td>
          <td><input type="text" name="<?php echo($vkol);?>" id="" class="form-control" value="<?php echo($vdetu[$vkol]);?>"></td>
      <?php } ?>
          <?php break;
      }
      ?>
      </tr>
      <?php }
      } ?>
      <tr>
        <td colspan="2"><input type="submit" name="saveprof" value="save" class="btn btn-lg btn-success"></td>
      </tr>
      </form>
      <?php }?>
    </table>