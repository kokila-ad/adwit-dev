<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<title><?php echo $this->session->userdata('india');?> @ Adwit Ads - india</title>
	
    <meta name="keywords" content="adwitads, adwit, ads, print ads, web ads at india, ads at bangalore" />
	<meta name="description" content="adwit ads for print and web ad development" />
    
	 
    <base href="<?php echo base_url();?>" />   
	<link rel="stylesheet" href="stylesheet/india_style.css" type="text/css" media="screen, projection" />
    
    <script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript">
	function hidestatus(){
	window.status=''
	return true
}

if (document.layers)
	document.captureEvents(Event.MOUSEOVER | Event.MOUSEOUT)
	
	document.onmouseover=hidestatus
	document.onmouseout=hidestatus
    </script>
	<!--[if lte IE 6]><link rel="stylesheet" href="stylesheet/style_ie.css" type="text/css" media="screen, projection" /><![endif]-->
</head>

<body>

<div id="wrapper">

	<header id="header">
    <div class="logo"><a href="<?php echo base_url().index_page()."india/home";?>"><img src="images/india_logo.jpg"/></a></div>    
  </header><!-- #header-->
  
  <section id="middle">
<div id="content-right-btn">
 <ul>
     <li><a href="<?php echo base_url().index_page()."india/home/neworder";?>">Creative Brief</a></li>
     <li><a href="<?php echo base_url().index_page()."india/home/myorders";?>">History</a></li>
   	 <li><a href="<?php echo base_url().index_page()."india/home/change";?>">Change Password</a></li>
     <li><a href="<?php echo base_url().index_page()."india/login/shutdown";?>">Logout</a></li>
    </ul>
</div>