<?php ob_start();?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Gudang JVM</title>
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url().'asset/css/bootstrap.min.css';?>" rel="stylesheet">
    <link href="<?php echo base_url().'asset/css/bootstrap-switch.min.css';?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo base_url().'asset/css/sb-admin.css';?>" rel="stylesheet">
    <link href="<?php echo base_url().'asset/css/custom.css';?>" rel="stylesheet">

    <link href="<?php echo base_url().'asset/css/dataTables.bootstrap.css';?>" rel="stylesheet">
    <!-- Custom Fonts -->
<link href="<?php echo base_url().'asset/font-awesome-4.1.0/css/font-awesome.min.css';?>" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<style type="text/css">
.navbar-inverse .navbar-nav>.active>a, .navbar-inverse .navbar-nav>.active>a:hover, .navbar-inverse .navbar-nav>.active>a:focus {
color: #fff;
/*background-color: #080808;*/
background-color:#FC563B;
}

.modal.modal-wide .modal-dialog {
  width: 90%;
}
.modal-wide .modal-body {
  overflow-y: auto;
}

/* irrelevant styling 
body { text-align: center; }
body p { 
  max-width: 400px; 
  margin: 20px auto; 
}*/
#tallModal .modal-body p { margin-bottom: 900px }

/* Paste this css to your style sheet file or under head tag */
/* This only works with JavaScript, 
if it's not present, don't show loader */
.no-js #loader { display: none;  }
.js #loader { display: block; position: absolute; left: 100px; top: 0; }
.se-pre-con {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url(" <?php echo base_url().'asset/img/memuat.gif' ?>") center no-repeat #fff;
}

</style>
</head>
<body <?php echo ( (isset($detailbrg)) || (isset($_GET['img'])) || (isset($_GET['id'])) || (isset($_GET['tbl']))) ? 'onload="klik()"':'';?>>
<?php include APPPATH.'views/templates/loading.php';?>
