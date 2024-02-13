<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>AdwitAds</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1" name="viewport"/>
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<base href="<?php echo base_url(); ?>" />
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<link href="assets/admin/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="assets/admin/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
<link href="assets/admin/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="assets/admin/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="assets/admin/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css">
<link rel="stylesheet" type="text/css" href="assets/admin/css/profile.css"/>
<link rel="stylesheet" type="text/css" href="assets/admin/css/font_opensans.css"/>
<link rel="stylesheet" type="text/css" href="assets/admin/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="assets/admin/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>
<link rel="stylesheet" type="text/css" href="assets/admin/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="assets/admin/plugins/datetime-picker.css"/>
<link rel="stylesheet" type="text/css" href="assets/admin/css/components.css" id="style_components">
<link rel="stylesheet" type="text/css" href="assets/admin/global/plugins/select2/select2.css"/>
<link rel="shortcut icon" href="assets/admin/favicon.ico"/>
<style>
.tabletools-btn-group {
    display: none;
}
</style>
</head>
<!-- END HEAD -->

<!-- BEGIN BODY -->
<body class="page-boxed page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-sidebar-closed-hide-logo">
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
	<!-- BEGIN HEADER INNER -->
	<div class="page-header-inner container">
		<!-- BEGIN LOGO -->
		<div class="page-logo">
			<a href="<?php echo base_url().index_page()."admin/home";?>">
			<img src="assets/admin/img/logo-default.png" alt="logo" class="logo-default"/>
			</a>
			<div class="menu-toggler sidebar-toggler">
				<!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
			</div>
		</div>
		<!-- END LOGO -->
		<!-- BEGIN RESPONSIVE MENU TOGGLER -->
		<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
		</a>
		<!-- END RESPONSIVE MENU TOGGLER -->

		<!-- BEGIN PAGE TOP -->
		<div class="page-top">
			<!-- BEGIN HEADER SEARCH BOX -->
			<!-- DOC: Apply "search-form-expanded" right after the "search-form" class to have half expanded search box -->
			<form class="search-form search-form-expanded" action="extra_search.html" method="GET">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Search..." name="query">
					<span class="input-group-btn">
					<a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
					</span>
				</div>
			</form>
			<!-- END HEADER SEARCH BOX -->
			
			<!-- BEGIN TOP NAVIGATION MENU -->
			<div class="top-menu">
				<ul class="nav navbar-nav pull-right">
					<?php $admin_users = $this->db->get_where('admin_users',array('id' => $this->session->userdata('aId')))->result_array(); ?>
					<!-- BEGIN USER LOGIN DROPDOWN -->
					<li class="dropdown dropdown-user">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
						<img alt="" class="img-circle" src="<?php echo $admin_users[0]['image_path'];?>"/>
						<span class="username username-hide-on-mobile">
						<?php echo $admin_users[0]['username'];?> </span>
						<i class="fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu dropdown-menu-default">
							<li>
								<a href="<?php echo base_url().index_page()."admin/home/change";?>">
								<i class="icon-user"></i> My Profile </a>
							</li>
							<li>
								<a href="page_calendar.html">
								<i class="icon-calendar"></i> My Calendar </a>
							</li>
							<li>
								<a href="inbox.html">
								<i class="icon-envelope-open"></i> My Inbox <span class="badge badge-danger">
								3 </span>
								</a>
							</li>
							<li>
								<a href="page_todo.html">
								<i class="icon-rocket"></i> My Tasks <span class="badge badge-success">
								7 </span>
								</a>
							</li>
							<li class="divider">
							</li>
							<li>
								<a href="extra_lock.html">
								<i class="icon-lock"></i> Lock Screen </a>
							</li>
							<li>
								<a href="<?php echo base_url().index_page()."admin/login/shutdown";?>">
								<i class="icon-key"></i> Log Out </a>
							</li>
						</ul>
					</li>
					<!-- END USER LOGIN DROPDOWN -->
				</ul>
			</div>
			<!-- END TOP NAVIGATION MENU -->
		</div>
		<!-- END PAGE TOP -->
	</div>
	<!-- END HEADER INNER -->
</div>
<!-- END HEADER -->

<!-- BEGIN CONTAINER -->
<div class="container">
	<div class="page-container">
		<!-- BEGIN SIDEBAR -->
		<div class="page-sidebar-wrapper">
			<div class="page-sidebar navbar-collapse collapse">
				<ul class="page-sidebar-menu page-sidebar-menu-hover-submenu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
					<li class="start active ">
						<a href="<?php echo base_url().index_page()."admin/home/";?>">
							<i class="icon-home"></i><span class="title">Dashboard</span><span class="selected"></span> 
						</a>
					</li>
					
					<!--<li>
						<a href="javascript:;">
						<i class="icon-emoticon-smile"></i>
						<span class="title">India Client Links</span>
						<span class="arrow "></span>
						</a>
						<ul class="sub-menu">
							<li><a href="india_client_controllers.html">Controllers</a></li>
							<li><a href="india_client_views.html">Views</a></li>
						</ul>
					</li>-->
					<li>
						<a href="javascript:;">
						<i class="icon-basket"></i>
						<span class="title">Manage</span>
						<span class="arrow "></span>
						</a>
						<ul class="sub-menu">
							<li><a href="<?php echo base_url().index_page()."admin/home/publications_list";?>">Publications</a></li>
							<li><a href="<?php echo base_url().index_page()."admin/home/";?>"><span class="badge bg-blue-chambray">></span>Users</a>
								<ul class="sub-menu">
									<li><a href="<?php echo base_url().index_page()."admin/home/art_director_list" ;?>">Art Director</a></li>
									<li><a href="<?php echo base_url().index_page()."admin/home/bg_head" ;?>">BG Head</a></li>
									<li><a href="<?php echo base_url().index_page()."admin/home/csr_list" ;?>">CSR</a></li>
									<li><a href="<?php echo base_url().index_page()."admin/home/teamlead_list";?>">Team Lead</a></li>
									<li><a href="<?php echo base_url().index_page()."admin/home/designteams_list";?>">Design Teams</a></li>
									<li><a href="<?php echo base_url().index_page()."admin/home/designers_list";?>">Designers</a></li>
									<li><a href="<?php echo base_url().index_page()."admin/home/management_list";?>">Management</a></li>
									<li><a href="<?php echo base_url().index_page()."admin/home/notification_list";?>">Notification</a></li>
								</ul>
							</li>
						</ul>
					</li>
					
					<li class="last ">
						<a href="javascript:;">
						<i class="icon-user"></i>
						<span class="title">Analysis</span>
						<span class="arrow "></span>
						</a>
					</li>
					
					<li>
						<a href="javascript:;">
						<i class="icon-basket"></i>
						<span class="title">Report</span>
						<span class="arrow "></span>
						</a>
						<ul class="sub-menu">
							<li><a href="<?php echo base_url().index_page()."admin/home/publications_list";?>"><span class="badge bg-blue-chambray">></span>Billing</a>
								<ul class="sub-menu">
									<li><a href="<?php echo base_url().index_page()."admin/home/bill_report" ;?>">Publication Billing</a></li>
									<li><a href="<?php echo base_url().index_page()."admin/home/bill_report_helpdesk";?>">Helpdesk Billing</a></li>
									<li><a href="<?php echo base_url().index_page()."admin/home/bill_grp_report" ;?>">Group Billing</a></li>
									<li><a href="<?php echo base_url().index_page()."admin/home/billing_revision_report" ;?>">Revision Billing</a></li>
									<!--<li><a href="<?php echo base_url().index_page()."admin/home/new_adreps_list" ;?>">New Adreps</a></li>-->
								</ul>
							</li>
							<li><a href="<?php echo base_url().index_page()."admin/home/";?>"><span class="badge bg-blue-chambray">></span>Production</a>
								<ul class="sub-menu">
									<li><a href="<?php echo base_url().index_page()."admin/home/helpdesk_hourly_report" ;?>">Hourly Revision Report</a></li>
									<li><a href="<?php echo base_url().index_page()."admin/home/newads_hourly_report" ;?>">Hourly New_Ads Report</a></li>
								</ul>
							</li>
						</ul>
					</li>					
					
					
				</ul>
					   
					
					
				<!-- END SIDEBAR MENU -->
			</div>
		</div>
		<!-- END SIDEBAR -->
		