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
<title>Art Director @ Adwit Ads</title>
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
    <div class="nav green-black">
    <ul class="dropdown clear">
      <li class="divider"></li>
      <li><a href="<?php echo base_url().index_page()."art-director/home";?>">Home</a></li>
      <li class="divider"></li>
            <li><a href="<?php echo base_url().index_page()."art-director/home/deshboard";?>">Dashboard</a></li> 
			    <li class="divider"></li>
            <li><a href="<?php echo base_url().index_page()."art-director/home/live_ads";?>">Live Ads</a></li> 
            <li class="divider"></li>
      <li class="sub"><a href="#">Reports</a>
        <ul>
          <li><a href="<?php echo base_url().index_page()."art-director/home/BG_performance";?>">BG</a></li>
          <li><a href="<?php echo base_url().index_page()."art-director/home/pub_performance";?>">PUBLICATION</a></li>
          <li><a href="<?php echo base_url().index_page()."art-director/home/production";?>">PRODUCTION</a></li>
          <li><a href="<?php echo base_url().index_page()."art-director/home/error_report";?>">ERROR</a></li>
          <li><a href="<?php echo base_url().index_page()."art-director/home/joblist";?>">GROUP</a></li>
		  <?php  if($this->session->userdata('aId')=='4'): ?>
		  <li class="sub"><a href="#">PRODUCTIVITY</a>
			<ul>
				<li><a href="<?php echo base_url().index_page()."art-director/home/designer_productivity";?>">Designer</a></li>
				<li><a href="<?php echo base_url().index_page()."art-director/home/team_productivity";?>">Team</a></li>
				<li><a href="<?php echo base_url().index_page()."art-director/home/location_productivity";?>">Location Wise</a></li>
				
            </ul>
		  </li>
		  <?php endif; ?>
        </ul>
      </li>
	  <li class="divider"></li>
	  <li class="sub"><a href="#">Adwit Users</a>
        <ul>
          <li><a href="<?php echo base_url().index_page()."art-director/home/new_designer";?>">DESIGNERS</a></li>
		  <li><a href="<?php echo base_url().index_page()."art-director/home/newpublication";?>">PUBLICATIONS</a></li>
          <li><a href="<?php echo base_url().index_page()."art-director/home/new_teams";?>">TEAM LEAD</a></li>
		  <li><a href="<?php echo base_url().index_page()."art-director/grid/teams";?>">TEAMS</a></li>
          <li><a href="<?php echo base_url().index_page()."art-director/home/shift_factor";?>">Shift Request</a></li>
         </ul>
      </li>	  	  
	  
      <li class="divider"></li>
      <li class="sub"><a href="#">PROFILE</a>
      <ul>
            <li><a href="<?php echo base_url().index_page()."art-director/home/change";?>">VIEW</a></li>
      <li><a href="<?php echo base_url().index_page()."art-director/home/trouble_ticket";?>">Help</a></li>
      <li><a href="<?php echo base_url().index_page()."art-director/login/shutdown";?>">SIGN OUT</a></li>
      </ul>
      </li>
      </ul>
  </div>
    </div>
  </div>
  <div id="header-div">&nbsp;</div>