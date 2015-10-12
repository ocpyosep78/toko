<?php $infouser=datauser();?>
<?php $detuser=getdetuser($infouser['id']);
      $likol=$this->db->list_fields('user'); ?>
<script src="<?php echo base_url().'asset/js/default/jquery-1.9.1.js';?>"></script>
<script type="text/javascript">
//$(window).load(function(){
  var counter = 0;
$(document).ready(function() {
    $("#btnweb").click(function(){
    var map = {};
      $(".web").each(function() {
            map[$(this).attr("name")] = $(this).val();
      });
        var postData = {
          'namaweb' : map.namaweb,
          'website' : map.website
        };
          $.ajax({
            type: "POST",
            url: "<?php echo site_url('gudang/addweb');?>",
            data: postData , //assign the var here 
            success: function(){
              alert( "Data berhasil ditambahkan :) ");
              location.reload();
            }
        });
    }); 

});
//});  
</script>
<script src="<?php echo base_url().'asset/js/default/jquery.min.js';?>"></script>
<script type="text/javascript">
$(document).ready(function(){
  $("#passbaru").prop('disabled', true);

});

function cekpasslama(isinya){
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
</script>
<style type="text/css">
.user-details {position: relative; padding: 0;}
.user-details .user-info-block {width: 100%; position: absolute; top: 55px; background: rgb(255, 255, 255); z-index: 0; padding-top: 35px;}
 .user-info-block .user-heading {width: 100%; text-align: center; margin: 10px 0 0;}
 .user-info-block .navigation {float: left; width: 100%; margin: 0; padding: 0; list-style: none; border-bottom: 1px solid #428BCA; border-top: 1px solid #428BCA;}
  .navigation li {float: left; margin: 0; padding: 0;}
   .navigation li a {padding: 20px 30px; float: left;}
   .navigation li.active a {background: #428BCA; color: #fff;}
 .user-info-block .user-body {float: left; padding: 5%; width: 90%;}
  .user-body .tab-content > div {float: left; width: 100%;}
  .user-body .tab-content h4 {width: 100%; margin: 10px 0; color: #333;}
</style>
	<div class="row">
		<div class="col-md-8">
	<div class="user-info-block">
<!-- tab -->
                <ul class="navigation">
                    <li class="active">
                        <a  href="?tab=1">
                          <span class="glyphicon glyphicon-user"></span>
                        </a>
                    </li>
                    <li>
                        <a  href="?tab=2">
                          <span class="fa fa-paw" data-toggle="tooltip" data-placement="top" title="Log aktivitas "></span>
                        </a>
                    </li>
                    <li>
                        <a  href="?tab=3" >
                          <span class="glyphicon glyphicon-envelope" data-toggle="tooltip" data-placement="top" title="Kirim permintaan "></span>
                        </a>
                    </li>
                    <li>
                        <a  href="?tab=4">
                            <span class="fa fa-users"></span>
                        </a>
                    </li>
                    <li>
                      <a href="?tab=5">
                            <span class="glyphicon glyphicon-link" data-toggle="tooltip" data-placement="top" title="tambah link ke produk "></span>
                      </a>
                    </li>
                </ul>

<!-- end tab-->

<!-- body tab -->
                <div class="user-body">
                    <div class="tab-content">
                            <div id="info" class="<?php echo ((isset($_GET['tab'])) && $_GET['tab']==1)? 'tab-pane active': 'tab-pane';?>">
                                      <!-- pengguna -->
                                      <?php include APPPATH.'views/pages/profile/identitas.php';?>
                              </div>

                              <div id="set" class="<?php echo ((isset($_GET['tab'])) && $_GET['tab']==2)? 'tab-pane active': 'tab-pane';?>">
                                    <!-- log request -->                          
                                    <?php include APPPATH.'views/pages/profile/tablelogreq.php';?>
                              </div>  
                              <div id="send" class="<?php echo ((isset($_GET['tab'])) && $_GET['tab']==3)? 'tab-pane active': 'tab-pane';?>">
                                    <!-- send request -->
                                    <?php include APPPATH.'views/pages/profile/sendreq.php';?>
                              </div>
                              <div id="cus" class="<?php echo ((isset($_GET['tab'])) && $_GET['tab']==4)? 'tab-pane active': 'tab-pane';?>">
                                    <!-- list cus -->
                                    <?php include APPPATH.'views/pages/profile/listcus.php';?>
                              </div>
                              <div id="info" class="<?php echo ((isset($_GET['tab'])) && $_GET['tab']==5)? 'tab-pane active': 'tab-pane';?>">
                                    <!-- post prod -->
                                    <?php include APPPATH.'views/pages/profile/postprod.php';?>
                              </div>
                    </div>
                </div>
<!-- end body tab -->


            </div>
</div>
<div class="col-md-4"></div>
</div>
