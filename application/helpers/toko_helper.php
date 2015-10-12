<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	function get_template_path($view_name)
	{
    	$target_file=APPPATH.'views/templates/'.$view_name.'.php';
    	if(file_exists($target_file)) return $target_file;
	}
	function curPageURL(){
 			$pageURL = 'http';
 			if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 			$pageURL .= "://";
 			if ($_SERVER["SERVER_PORT"] != "80") {
  				$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 			}else{
  				$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 			}
 	return $pageURL;
	}
?>
