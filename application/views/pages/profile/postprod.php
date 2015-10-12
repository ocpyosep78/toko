<table class="table table-bordered"> 
                    <thead>
                    <tr>
                      <td>kode barang</td>
                      <td>website</td>
                      <td>link post</td>
                      <td>time created</td>
                    </tr>
                    </thead>
                    <tbody>
                      <?php
                      if (($postprod) && (!empty($postprod))) { 
                        foreach ($postprod as $vprod) {?>
                            <tr>
                              <td><a href="<?php echo(site_url('gudang/profile/wew?tab=5&id='.$vprod['kdbarang'].'&tbl=3'))?>"><?php echo($vprod['kdbarang'])?></a>
                              <input type="hidden" value="<?php echo($vprod['kdbarang']);?>" />
                              </td>
                              <td><?php echo(geturlweb($vprod['website']));?></td>                              
                              <td><a href="<?php echo($vprod['link']);?>" target="blank"><?php echo($vprod['link']);?></a></td>
                              <td><?php echo($vprod['time']);?></td>
                            </tr>
                        <?php } ?>
                    <?php }else{ ?>
                        <tr>
                          <td colspan="4">belum ada produk yang terkait LINK :(</td>
                        </tr>
                  <?php } ?>
                    </tbody>
                    </table>
                    <hr>
                    <form action="<?php echo(site_url('gudang/insert'))?>" method="post">
                    <input type="hidden" name="tabel" value="17">
                      <div class="form-group">
                          <label for="nmprod">Nama produk / Description</label>
                          <?php include APPPATH.'views/fields/kdbarang.php'; ?>
                      </div>
                      <span id="txtHprod">
                      </span>
                      <div class="form-group">
                      <label>Nama Website</label>
                      <?php if ($website) {?>
                        <select class="form-control" name="website">
                        <?php foreach ($website as $vweb) { ?>
                            <option value="<?php echo($vweb['id']);?>"><?php echo($vweb['namaweb'])?></option>
                        <?php }?>
                        </select>
                      <?php }else{?>
                      <span class="alert alert-warning" role="alert ">anda belum mendaftarkan website</span>
                      <?php } ?>
                      </div>
                      <div class="form-group">
                      <label>Link postingan produk</label>
                      <input type="text" name="link" class="form-control">
                      </div>
                      <input type="submit" value="create" class="btn btn-lg btn-success" />
                    </form>