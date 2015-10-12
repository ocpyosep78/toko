   <?php echo form_open('login/reg'); ?>
                <?php if (validation_errors()) :?> 
                <div class="control">
                  <div class="alert alert-warning" role="alert" ><?php echo validation_errors(); ?></div>
                </div>
                <?php endif;?> 
                <div class="control">
                    <div class="label">Email</div>
                    <input type="email" class="form-control"  name="email" />
                </div>
                <div class="control">
                    <div class="label">Username</div>
                    <input type="text" class="form-control"  name="uname" />
                </div>
                <div class="control">
                     <div class="label">Password</div>
                    <input type="password" class="form-control" name="pass" />
                </div>
                <div align="center">
                     <button class="btn btn-orange">Sign UP</button>
                </div>
        <?php echo form_close();?>