<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>Management | Adwitads</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>

<base href="<?php echo base_url();?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/management/css/fonts.googleapis.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/management/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/management/css/uniform.default.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/management/css/dataTables.bootstrap.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/management/css/dataTables.scroller.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/management/css/datepicker.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/management/css/bootstrap-fileinput.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/management/css/components-rounded.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/management/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/management/css/select2.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/management/css/custom.css">
	<script type="text/javascript" src="<?php echo base_url();?>assets/management/script/jquery.1.12.min.js"></script>
</head>

<body>
<?php $management_name = $this->db->get_where('management',array('id' => $this->session->userdata('mId')))->result_array()
	?>
<!-- BEGIN HEADER -->
<div class="page-header">
	<!-- BEGIN HEADER TOP -->
	<div class="page-header-top">
		<div class="container">
			<!-- BEGIN LOGO -->
			<div class="page-logo">
				<a href="<?php echo base_url().index_page()."management/home";?>"><img src="<?php echo base_url();?>assets/management/img/logo.png" alt="logo" class="logo-default"></a>
			</div>
			<!-- END LOGO -->
			<!-- BEGIN RESPONSIVE MENU TOGGLER -->
			<a href="javascript:;" class="menu-toggler"></a>
			<!-- END RESPONSIVE MENU TOGGLER -->
			<!-- BEGIN TOP NAVIGATION MENU -->
			<div class="top-menu">
				<ul class="nav navbar-nav pull-right">
					<!-- BEGIN USER LOGIN DROPDOWN -->
					<li class="dropdown dropdown-user dropdown-dark">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
						<img alt="" class="img-circle" src="<?php echo base_url() ?><?php echo $management_name[0]['image']; ?>">
						<span class="username username-hide-mobile"><?php echo $management_name[0]['first_name'].' '.$management_name[0]['last_name'];?></span>
						</a>                                        
						<ul class="dropdown-menu dropdown-menu-default">
							<li>
								<a href="<?php echo base_url().index_page()."management/home/my_profile";?>">
								<i class="fa fa-user"></i> My Profile </a>
							</li>
							<li>
								<a href="#">
								<i class="fa fa-lock"></i> Lock Screen </a>
							</li>
							<li>
								<a href="<?php echo base_url().index_page()."management/login/shutdown";?>">
								<i class="fa fa-key"></i> Log Out </a>
							</li>
						</ul>
					</li>
					<!-- END USER LOGIN DROPDOWN -->
				</ul>
			</div>
			<!-- END TOP NAVIGATION MENU -->
		</div>
	</div>
	<!-- END HEADER TOP -->
	<!-- BEGIN HEADER MENU -->
	<div class="page-header-menu">
		<div class="container">
			<div class="hor-menu ">
				<ul class="nav navbar-nav">
					<li><a href="<?php echo base_url().index_page()."management/home/dashboard";?>">Dashboard</a></li>
					<li><a href="<?php echo base_url().index_page()."management/home/ads";?>">Ads</a></li>
					<li class="menu-dropdown classic-menu-dropdown ">
					  <a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;">
					  Customers <i class="fa fa-angle-down"></i>
					  </a>
					  <ul class="dropdown-menu pull-left">
					   <li><a href="<?php echo base_url().index_page()."management/home/publication";?>">Publication</a></li>
					   <li><a href="<?php echo base_url().index_page()."management/home/adrep";?>">Adrep</a></li>
					  </ul>
					</li>
					<li><a href="<?php echo base_url().index_page()."management/home/employee";?>">Employees</a></li>
					<!--<li><a href="<?php echo base_url().index_page()."management/home/production";?>">Production</a></li>-->
					<li class="menu-dropdown classic-menu-dropdown ">
						<a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;">
						Production <i class="fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu pull-left">
						<li><a href="<?php echo base_url().index_page()."management/home/csr_performance";?>">CSR</a></li>
						<li><a href="<?php echo base_url().index_page()."management/home/frontline/all";?>">Frontline Deliveries Report</a></li>
						<li><a href="<?php echo base_url().index_page()."management/home/hd_hourly_report";?>">Hourly Report</a></li>
						</ul>
					</li>	
					<li><a href="<?php echo base_url().index_page()."management/home/announcement";?>">Announcement</a></li>
					
				</ul>
			</div>
		</div>
	</div>
	<!-- END HEADER MENU -->
</div>
<!-- END HEADER -->