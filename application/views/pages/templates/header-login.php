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
    <!--font-google harus onlen cuk-->
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,200' rel='stylesheet' type='text/css'>
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url().'asset/css/bootstrap.min.css';?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo base_url().'asset/custom-css/login.css';?>">
    <link href="<?php echo base_url().'asset/css/sb-admin.css';?>" rel="stylesheet">
    <link href="<?php echo base_url().'asset/css/custom.css';?>" rel="stylesheet">
    <!-- Custom Fonts -->
<link href="<?php echo base_url().'asset/font-awesome-4.1.0/css/font-awesome.min.css';?>" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<script>
function startTime() {
    var today=new Date();
    var h=today.getHours();
    var m=today.getMinutes();
    var s=today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('txt').innerHTML = h+":"+m+":"+s;
    var t = setTimeout(function(){startTime()},500);
}

function checkTime(i) {
    if (i<10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}
</script>
<style type="text/css">
.alert-warning {
color: #000000;
background-color: #f1c40f;
border-color: #faebcc;
}

</style>
</head>
<body onload="startTime()">
