<!doctype html>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="">
<!--<![endif]-->
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $this->session->userdata('client');?> @ Adwit Ads - Client</title>
<meta name="keywords" content="adwitads, adwit, ads, print ads, web ads at india, ads at bangalore" />
	<meta name="description" content="adwit ads for print and web ad development" />
     <base href="<?php echo base_url();?>" />
     
	<link rel="stylesheet" href="stylesheet/style_fluid.css" type="text/css" />
    	<link rel="stylesheet" href="stylesheet/boilerplate.css" type="text/css" />
<!-- 
To learn more about the conditional comments around the html tags at the top of the file:
paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/

Do the following if you're using your customized build of modernizr (http://www.modernizr.com/):
* insert the link to your js here
* remove the link below to the html5shiv
* add the "no-js" class to the html tags at the top
* you can also remove the link to respond.min.js if you included the MQ Polyfill in your modernizr build 
-->
<!--[if lt IE 9]>
<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
 <script type="text/javascript" src="js/jquery.min.js"></script>
<script src="js/respond.min.js"></script>
    <script type="text/javascript">
		$(document).ready(function(e) {
            $('#forget').click(function(e) {
				$('#Login-div').hide();
                $('#Forgot-pass').show();
            });
			$('#back').click(function(e) {
				$('#Forgot-pass').hide();
                $('#Login-div').show();
            });			
		 });
    </script>
</head>
<body>
<div class="gridContainer clearfix">

<!-- header starts -->
  <div id="Logo">
    <div id="Logo-Img">
    <img src="images/logo.png"/>
    </div>
  </div>
  <div id="header-div">&nbsp;</div>
<!-- header Ends -->
<div id="Navigation-Tab">
<ul>
     <li><a href="<?php echo base_url().index_page()."client/home/neworder";?>">New Order</a></li>
     <li><a href="<?php echo base_url().index_page()."client/home/myorders";?>">My Orders History</a></li>
     <li><a href="<?php echo base_url().index_page()."client/home/orders_history";?>">Old Orders History</a></li>
	 <li><a href="<?php echo base_url().index_page()."client/home/change";?>">Change Password</a></li>
     <li><a href="<?php echo base_url().index_page()."client/login/shutdown";?>">Logout</a></li>
    </ul>
</div>