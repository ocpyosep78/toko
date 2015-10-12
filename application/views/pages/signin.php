   <?php echo form_open('verifylogin'); ?>
                <?php if (validation_errors()) :?> 
                <div class="control">
                  <div class="alert alert-warning" role="alert" ><?php echo validation_errors(); ?></div>
                </div>
                <?php endif;?> 
                <div class="control">
                    <div class="label">Username</div>
                    <input type="text" class="form-control"  name="uname" value="" />
                </div>
                
                <div class="control">
                     <div class="label">Password</div>
                    <input type="password" class="form-control" name="pass" value="" />
                </div>
                <div align="center">
                     <button class="btn btn-orange">Sign in</button>
                </div>
        <?php echo form_close();?>