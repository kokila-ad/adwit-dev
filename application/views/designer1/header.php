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
<title>Designer @ Adwit Ads</title>
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
<script type="text/javascript">
    $('.confirmation').on('click', function () {
        return confirm('Are you sure?');
    });
</script>
<!-- 
		
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
	$designer_name=$this->db->get_where('designers',array('id' => $this->session->userdata('dId')))->result_array()
	?>
    <div class="nav green-black">
    <ul class="dropdown clear">
      <li class="divider"></li>
      <li><a href="<?php echo base_url().index_page()."designer/home";?>">Home</a></li>
      <li class="divider"></li>
      <!--<li><a href="<?php echo base_url().index_page()."designer/home/dp_tool01";?>">New Ad</a></li>
	  <li class="divider"></li>
      <li><a href="<?php echo base_url().index_page()."designer/home/cshift";?>">Downloads</a></li>-->
      <!--<li class="divider"></li>
      <li><a href="<?php echo base_url().index_page()."designer/home/revision";?>">Rev/Sold</a></li>
	  -->
      <li class="divider"></li>
     <li><a href="<?php echo base_url().index_page()."designer/home/Qrevision";?>">RevD Track</a></li> 
      <li class="divider"></li>
	  <li class="sub"><a href="#">Analytics</a>
        <ul>
		  <li class="sub"><a href="#">GRAPHS</a>
			<ul>
				<li><a href="<?php echo base_url().index_page()."designer/home/category_orders";?>">CATEGORY</a></li>
				<li><a href="<?php echo base_url().index_page()."designer/home/QA_error_chart";?>">ERRORS</a></li>
				<li><a href="<?php echo base_url().index_page()."designer/home/NJ_chart";?>">NJ</a></li>
			</ul>
		  </li>
		  <li class="sub"><a href="#">REPORTS</a>
			<ul>
				<li><a href="<?php echo base_url().index_page()."designer/home/production";?>">PRODUCTION</a></li>
				<li><a href="<?php echo base_url().index_page()."designer/home/error";?>">ERROR</a></li>
			</ul>
		  </li>
        </ul>
      </li>
	  
      <li class="divider"></li>
      <li class="sub"><a href="#">Profile</a>
      <ul>
      <li><a href="<?php echo base_url().index_page()."designer/home/change";?>"><?php echo strtoupper($designer_name[0]['name']); ?></a></li>
      <li class="sub"><a href="#">HELP</a>
      <ul>
		<li><a href="<?php echo base_url().index_page()."designer/home/admin_support";?>">TICKET</a></li>
		<li><a href="<?php echo base_url().index_page()."designer/home/job_list";?>">JOBS LIST</a></li>
		<li><a href="<?php echo base_url().index_page()."designer/home/links";?>">LINKS</a></li>
		<li><a href="<?php echo base_url().index_page()."designer/home/rev_status";?>">NFT</a></li>
        <li><a href="<?php echo base_url().index_page()."designer/home/shift_factor";?>">A Hours</a></li>
	  </ul>
	  </li>
	  <li><a href="<?php echo base_url().index_page()."designer/home/sign_out";?>" >SIGN OUT</a></li>
	  </ul>
      </li>
      </ul>
  </div>
    </div>
  </div>
  <div id="header-div">&nbsp;</div>
<!-- header Ends -->
