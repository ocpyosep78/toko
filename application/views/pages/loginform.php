
<div class="container">
  <div class="row login_box">
      <div class="col-md-12 col-xs-12" align="center">
            <div class="line"><h3 id="txt"></h3></div>
            <div class="outter"><img src="<?php echo base_url().'asset/img/logo-login.png';?>" class="image-circle"/></div>   
            <h1>JVM stockroom</h1>
            <span>General Suplier, Distributor & Representive of Laboratory Environmetal, Medical and Industrial Equipment</span>
      </div>
      <a href="<?php echo(current_url().'?reg')?>">
        <div class="col-md-6 col-xs-6 follow line" align="center">
            <h3>
                    <span class="glyphicon glyphicon-user"></span> <br/> <span>Sign Up</span>                   
                 
            </h3>
        </div>
        </a>
        <?php if (isset($_GET['reg'])): ?>
   <a href="<?php echo(site_url('gudang'));?>">
        <div class="col-md-6 col-xs-6 follow line" align="center">
        
            <h3>
                 <span class="glyphicon glyphicon-home"></span> <br/> <span>Home</span>
            </h3>
        </div>
        </a>
    <?php else:?>
    <a href="<?php echo(site_url('login/resetpass'));?>">
        <div class="col-md-6 col-xs-6 follow line" align="center">
            <h3>
                 <span class="glyphicon glyphicon-random"></span> <br/> <span>Reset password</span>
            </h3>
        </div>
        </a>
    <?php endif;?>
        <div class="col-md-12 col-xs-12 login_control">
     <?php
     if (isset($_GET['reg'])) {
            include APPPATH.'views/pages/signup.php';
     }else if (isset($_GET['u'])) {
            include APPPATH.'views/pages/ubaru.php';
     }else{
            include APPPATH.'views/pages/signin.php';
     }
     ?>
        </div>
    </div>
</div>


   
