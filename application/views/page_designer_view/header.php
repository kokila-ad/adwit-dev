
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<title>Designer | Adwitads</title>
<meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8"><meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/designer/plugins/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/designer/plugins/simple-line-icons/simple-line-icons.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/designer/plugins/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/designer/plugins/uniform/css/uniform.default.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/designer/plugins/jstree/dist/themes/default/style.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/designer/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/designer/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/designer/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/designer/plugins/bootstrap-datepicker/css/datepicker.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/designer/plugins/jstree/dist/themes/default/style.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/designer/css/custom.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/designer/plugins/bootstrap-datepicker/css/datepicker3.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/designer/	css/bootstrap-fileinput.css"/>
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="<?php echo base_url();?>assets/designer/favicon.ico">
<script src="<?php echo base_url();?>assets/designer/scripts/dropzone.min.js"></script>
<script src="<?php echo base_url();?>assets/designer/scripts/jquery-latest.min.js" type="text/javascript" ></script>
<link href="<?php echo base_url();?>assets/designer/css/dropzone/dropzone.css" type="text/css" rel="stylesheet" />
<script src="<?php echo base_url();?>assets/designer/css/dropzone/dropzone.min.js"></script>


</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-menu-fixed" class to set the mega menu fixed  -->
<!-- DOC: Apply "page-header-top-fixed" class to set the top menu fixed  -->
<body>
<!-- BEGIN HEADER -->
<style>
	.bg-search {
    color: #ccc !important;
    background-color: #38414c;
    border-right: 1px solid #444d58;
}
</style>

<div class="page-header">
	<!-- BEGIN HEADER TOP -->
	<div class="page-header-top">
		<div class="container">
			<!-- BEGIN LOGO -->
			<div class="page-logo">
				<a href="index.php/designer/home"><img src="<?php echo base_url();?>assets/designer/img/logo.png" alt="logo" class="logo-default"></a>
			</div>
			<!-- END LOGO -->
			<!-- BEGIN RESPONSIVE MENU TOGGLER -->
			<a href="javascript:;" class="menu-toggler"></a>
			<!-- END RESPONSIVE MENU TOGGLER -->
			<!-- BEGIN TOP NAVIGATION MENU -->
				<div class="top-menu">
				<ul class="nav navbar-nav pull-right">
				<!-- BEGIN NOTIFICATION DROPDOWN -->
					<li class="dropdown dropdown-extended dropdown-dark dropdown-notification" id="header_notification_bar">
						<a href="index.php/designer/home/notifications" class="dropdown-toggle">
						<i class="icon-bell"></i>
						<span class="badge badge-default">0</span>
						</a>
						<ul class="dropdown-menu">
							<li class="external">
								<h3>You have <strong>4 pending</strong> tasks</h3>
								<a href="javascript:;">view all</a>
							</li>
							<li>
								<ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
									<li>
										<a href="javascript:;">
										<span class="time">just now</span>
										<span class="details">
										<span class="label label-sm label-icon label-success">
										<i class="fa fa-plus"></i>
										</span>
										New user registered. </span>
										</a>
									</li>
									<li>
										<a href="javascript:;">
										<span class="time">3 mins</span>
										<span class="details">
										<span class="label label-sm label-icon label-danger">
										<i class="fa fa-bolt"></i>
										</span>
										Server #12 overloaded. </span>
										</a>
									</li>
									<li>
										<a href="javascript:;">
										<span class="time">10 mins</span>
										<span class="details">
										<span class="label label-sm label-icon label-warning">
										<i class="fa fa-bell-o"></i>
										</span>
										Server #2 not responding. </span>
										</a>
									</li>
									<li>
										<a href="javascript:;">
										<span class="time">14 hrs</span>
										<span class="details">
										<span class="label label-sm label-icon label-info">
										<i class="fa fa-bullhorn"></i>
										</span>
										Application error. </span>
										</a>
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<!-- END NOTIFICATION DROPDOWN -->
					<!-- BEGIN USER LOGIN DROPDOWN -->
					<?php 
                    $uid = $this->session->userdata('uId');
                    $user = $this->db->query("SELECT `first_name`, `image` FROM `users` WHERE `id` = '$uid'")->row_array();
                    ?>






					<li class="dropdown dropdown-user dropdown-dark">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
							
                                <img class="img-circle" src="<?php echo base_url().$user['image']; ?>" alt="profile">
                           
                            <span class="username username-hide-mobile"><?php echo $user['first_name']; ?></span>
						</a>
						<ul class="dropdown-menu dropdown-menu-default">
							<li>
								<a href="<?php echo base_url().index_page()."/Designer_home/profile";?>">
								<i class="icon-user"></i> My Profile </a>
							</li>
							<li class="divider">
							</li>
							<!-- <li>
								<a onclick="noBack();" href="index.php/designer/home/lock">
								<i class="icon-lock"></i> Lock Screen </a>
							</li> -->
							<li>
								<a href="<?php echo base_url().index_page()."/Login/shutdown"?>">
								<i class="icon-key"></i> Log Out </a>
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
<script>
	$(document).ready(function(){
    $("#advancesearch").hide();
		 
	 $("#showadvancesearch").click(function(){
	 $("#advancesearch").show();  
     $("#search").hide();  		
		});
	 $("#idsearch").click(function(){
	 $("#advancesearch").hide();  
     $("#search").show();  		
		});	
		
	});
</script>
					<!-- BEGIN HEADER SEARCH BOX -->

			<!--<form class="search-form" role="search" name="form" method="post" action="index.php/new_designer/home/cshift_search" >
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Search" name="id" required>
					<span class="input-group-btn">
					<a href="javascript:;" class="btn"><button type="submit" name="search" style=" background: transparent; border: 0;"><i class="icon-magnifier"></i></button></a>
					</span>
				</div>
			</form>-->
			<!-- BEGIN HEADER SEARCH BOX -->
			<form class="search-form" id="search" name="form" method="get" >
				<div class="input-group">
					<span class="input-group-btn">
						<button type="button" class="btn bg-search dropdown-toggle" data-toggle="dropdown" tabindex="-1" aria-expanded="false">
							ID &nbsp;<i class="fa fa-angle-down"></i>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li><a id="showadvancesearch" >All</a></li>
							<li><a>ID </a></li>
						</ul>
					</span>
					<input type="text" class="form-control" placeholder="Enter AdwitAds ID" name="search_id" required/>
					<span class="input-group-btn">
						<a href="javascript:;" class="btn">
							<button type="submit" name="search" style="color: #5b9bd1; background: transparent; border: 0;"><i class="icon-magnifier font-white"></i>
							</button>
						</a>
					</span>
				</div>
			</form>
			<form class="search-form" id="advancesearch" name="form" method="get">
				<div class="input-group">
					<span class="input-group-btn"> 
						<button type="button" class="btn bg-search dropdown-toggle" data-toggle="dropdown" tabindex="-1" aria-expanded="false">
							All &nbsp;<i class="fa fa-angle-down"> </i>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li><a>All</a></li>
							<li><a id="idsearch">ID </a></li>
						</ul>
					</span>
					<input type="text" class="form-control" placeholder="Enter AdwitAds ID, Job ID or Advertiser Name" name="advance_search_id" required/>
					<span class="input-group-btn">
						<a href="javascript:;" class="btn"><button type="submit" name="advance_search" style="color: #5b9bd1; background:transparent; border: 0;"><i class="icon-magnifier font-white"></i></button></a>
					</span>
				</div>
			</form>
			
			
			<!-- END HEADER SEARCH BOX -->
			      
	
			<!-- END HEADER SEARCH BOX -->

			<!-- BEGIN MEGA MENU -->
			<!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
			<!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
			<div class="hor-menu ">
				<ul class="nav navbar-nav" >
					<li class="">
						<a href="<?php echo base_url().index_page()."/Designer_home/pagedesign";?>">New Design</a>
					</li>
					<li class="">
						<a href="<?php echo base_url().index_page()."/Designer_home/revision_design";?>">Revision Design</a>
					</li>
					
				</ul>
			</div>
			<!-- END MEGA MENU -->
		</div>
	</div>
	<!-- END HEADER MENU -->
</div><!-- END HEADER -->
<style>
@keyframes blink {
to { color: red; }
}

.my-element {
color: black;
animation: blink 1s steps(2, start) infinite;
}
</style>