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
<title><?php echo $this->session->userdata('client');?>csr @ Adwit Ads</title>
<meta name="keywords" content="adwitads, adwit, ads, print ads, web ads at india, ads at bangalore" />
	<meta name="description" content="adwit ads for print and web ad development" />
     <base href="<?php echo base_url();?>" />
     
	<link rel="stylesheet" href="stylesheet/style_fluid.css" type="text/css" />
    	<link rel="stylesheet" href="stylesheet/boilerplate.css" type="text/css" />
        <link rel="stylesheet" href="flatmenu/flatmenu.css" type="text/css" />
		
        
        	<script type="text/javascript" src="js/jquery.min.js"></script>
		<script src="js/respond.min.js"></script>
                <script type="text/javascript" src="flatmenu/flatmenu-responsive.js"></script>
        <script type="text/javascript" src="flatmenu/flatmenu-ie6.js"></script>



<!--[if lt IE 9]>
<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>
<body>
<div class="gridContainer clearfix">

<!-- header starts -->
  <div id="Logo">
    <div id="Logo-Img">
    <img src="images/logo.png"/>
    </div>
    <div id="top-nav">
    <?php
	$csr_name=$this->db->get_where('csr',array('id' => $this->session->userdata('sId')))->result_array()
	?>
    <div class="nav green-black">
    <ul class="dropdown clear">
      <li class="divider"></li>
      <li><a href="<?php echo base_url().index_page()."csr/home";?>">Home</a></li>
	  <li class="divider"></li>
	  <li><a href="<?php echo base_url().index_page()."csr/home/frontlinetrack_all";?>">Revision</a></li>      
	  <li class="divider"></li>
      <li class="sub"><a href="">Analytics</a>
      <ul>
      <li class="sub"><a href="#">Graphs</a>
      <ul>
      <li><a href="<?php echo base_url().index_page()."csr/home/chart";?>">Cat-QA</a></li>
      <li><a href="<?php echo base_url().index_page()."csr/home/chart";?>">Helpdesk</a></li>
      <li><a href="<?php echo base_url().index_page()."csr/home/chart";?>">Performance</a></li>
      </ul>
      </li>
      <li><a href="<?php echo base_url().index_page()."csr/home/chart";?>">Reports</a></li>
      </ul>
      </li>
      <li class="divider"></li>
      <li class="sub"><a href="#"><?php echo $csr_name[0]['name'];?></a>
      <ul>
      <li><a href="<?php echo base_url().index_page()."csr/home/change";?>">VIEW PROFILE</a></li>
      <li><a href="flipbook" target="blank">Help</a></li>
      <li><a href="<?php echo base_url().index_page()."csr/login/shutdown";?>">SIGN OUT</a></li>
      </ul>
      </li>
      </ul>
  </div>
    </div>
  </div>
  <div id="header-div">&nbsp;</div>
<!-- header Ends -->
