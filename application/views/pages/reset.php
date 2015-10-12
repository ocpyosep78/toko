
<div class="container">
  <div class="row login_box">
      <div class="col-md-12 col-xs-12" align="center">
            <div class="line"><h3 id="txt"></h3></div>
            <div class="outter"><img src="<?php echo base_url().'asset/img/logo-login.png';?>" class="image-circle"/></div>   
            <h1>reset password</h1>
            <span>
              Please enter your username or email address. You will receive a link to create a new password via email.
            </span>
      </div>
      <a href="<?php echo(current_url().'?reg')?>">
        <div class="col-md-6 col-xs-6 follow line" align="center">
            <h3>
                 <span class="glyphicon glyphicon-user"></span> <br/> <span>Sign Up</span>
            </h3>
        </div>
        </a>
        <a href="<?php echo(site_url('gudang'));?>">
        <div class="col-md-6 col-xs-6 follow line" align="center">
        
            <h3>
                 <span class="glyphicon glyphicon-home"></span> <br/> <span>Home</span>
            </h3>
        </div>
        </a>
        <div class="col-md-12 col-xs-12 login_control">
        <?php if (isset($_GET['reg'])):?>
          <?php include APPPATH.'views/pages/signup.php';?>
      <?php else:?>
         <?php echo form_open('verifylogin/verifyres'); ?>
                <?php if (validation_errors()) :?> 
                <div class="control">
                  <div class="alert alert-warning" role="alert" ><?php echo validation_errors(); ?></div>
                </div>
                <?php endif;?> 
                <div class="control">
                    <label >Username</label>
                    <input type="text" class="form-control"  placeholder="Enter username" name="uname" />
                </div>
                <div class="control">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" name="resemail">
                </div>
                <div align="center">
                     <button class="btn btn-orange">Submit</button>
                </div>
        <?php echo form_close();?>
      <?php endif;?>
        </div>
    </div>
</div>


   
