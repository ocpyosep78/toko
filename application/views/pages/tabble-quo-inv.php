<!--invoice dan quo -->
<div class="row">
    <div class="col-xs-12">
            <div class="panel panel-default height">
                        <div class="panel-heading">Details </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                            <table class="table">
                                <tr>
                                  <?php if (isset($_GET['ubah'])):?>
                                    <td>metode disc</td>
                                  <?php endif;?>
                                    <td>Aksi</td>
                                    <td>Product</td>
                                    <td>Qty</td>
                                    <td>Unit Price</td>
                                    <td>Disc</td>
                                    <td>Subtotal</td>
                                </tr>
                                <?php 
                                $nin=count($produk);
                                for ($in=0; $in < $nin; $in++) { ?>
                                <tr>
                                    <?php if (isset($_GET['ubah']) && $_GET['ubah']==$in):?>
                                    <td>
                                        <label for="">Pilih metode diskon</label>
                                        <div class="radio"><label>
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
                                    </td>
                                    <td><a href="#" onclick="saveedit(<?php echo $in.','.$id;?>)">Simpan</a> | <a href="?cancel=<?php echo $in;?>">batal</a></td>
                                    <td>
                                        <?php include APPPATH.'views/fields/kdbarang.php'; ?>
                                    </td>
                                    <td><input type="number" id="qty" class="form-control" value="<?php echo $qty[$in];?>" onkeyup="sub_ttl()"/></td>
                                    <td><input type="text" id="hrgj" value="<?php echo (isset($_GET['isi2']))? $price : $price[$in];?>" readonly/></td>
                                    <td><input type="text" id="disc" class="form-control" value="<?php echo $disc[$in];?>" onkeyup="sub_ttl()"/>
                                        <input type="hidden" id="backupdisc" value="<?php echo $disc[$in];?>">
                                    </td>
                                    <td><input type="text" id="subttl" value="<?php echo (!isset($_GET['isi2'])) ? $subtotal[$in] : '';?>" readonly/></td>

                                    <?php else: ?> 

                                    <td><a href="?ubah=<?php echo $in;?>">Edit</a>|<a href="?del=<?php echo $in;?>">Hapus</a></td>
                                    <td>
                                        <?php echo $nmprod[$in];?>
                                        <input type="hidden" value="<?php echo $produk[$in];?>"/>
                                    </td>
                                    <td><?php echo $qty[$in];?>
                                    </td>
                                    <td><?php echo $price[$in];?></td>
                                    <td><?php echo $disc[$in];?></td>
                                    <td><?php echo $subtotal[$in];?></td>
                                    <?php endif; ?>
                                </tr>
                                <?php }?>
                                <tr>
                                    <td colspan="<?php echo (isset($_GET['ubah']))? '6' : '5';?>">Total</td>
                                    <td><?php echo $total;?></td>
                                </tr>
                            </table>
                        </div>
                        </div>
                    </div>
    </div>
    </div>