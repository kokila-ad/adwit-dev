<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	<title>Admin | Adwitads</title>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8"><meta content="" name="description"/>
	<meta content="" name="author"/>
		
	<base href="<?php echo base_url(); ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/new_admin/css/fonts.googleapis.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/new_admin/plugins/font-awesome/css/font-awesome.min.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/new_admin/plugins/bootstrap/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/new_admin/plugins/select2/select2.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/new_admin/css/awemenu.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/new_admin/css/custom.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/new_admin/plugins/uniform/css/uniform.default.css"/>
	<script src="<?php echo base_url(); ?>assets/new_admin/scripts/jquery-latest.min.js" type="text/javascript" ></script>
	
<style>
	@media only screen and (max-width: 767px){
.input-group 
{
    width: 289px !important;
       left: 43px !important;
   position: relative;
	}
	}
	@media only screen and (max-width: 767px){
.form-control, .btn bg-search dropdown-toggle{
    border-color: #2C3E50 !important;
    background-image: none !important;
    background-color: #2C3E50 !important;
    color: #FFFFFF !important;
}
.icons{
	display:none !important;
}
	}
	@media only screen and (max-width: 767px){
  .portlet {
    margin-top: 45px !important;
}
.padding-0 {
    padding: 0px 10px !important;
}
.awemenu-item > a:hover{
		color: #333 !important;
	}
	}
	#buttn{
		  border-color: #2C3E50 !important;
		  background-image: none !important;
		  background-color: #2C3E50 !important;
		  color: #FFFFFF !important;
		  position: relative;  
		  top: 1px;
		  margin-right: 2px;
	}
	#srbuttn{
		border-color: #2C3E50 !important;
		background-image: none !important;
		background-color: #2C3E50 !important;
		color: #FFFFFF !important; 
		width: 29px;
		position: relative;
		height: 34px;
		right: 13px;  
		top: 1px;
	}
	#inbutn{
		border-color: #2C3E50 !important;
		background-image: none !important;
		background-color: #2C3E50 !important;
		color: #FFFFFF !important;
		top: 8px;
	}
	.awemenu-default .awemenu .awemenu-item .awemenu-submenu{
		    background-color: #55616f;
    -webkit-box-shadow: 1px 2px 3px rgba(0, 0, 0, 0.15);
    box-shadow: 1px 2px 3px rgba(0, 0, 0, 0.15);
    text-align: left;
    border: 1px solid #ccc;
    border-top: 0px solid #ed1c24;
    top: 49px;
	}
	.awemenu-default .awemenu .awemenu-item .awemenu-submenu .list-unstyled >li > a:hover{
		    background-color: #64707e !important;
	}
	
	.awemenu-default .awemenu .awemenu-item .awemenu-submenu .awemenu-item > a {
    color: #fff;
    }
	.dropdown-backdrop{
		display:none;
	}
	.awemenu-default .awemenu .awemenu-item .awemenu-submenu .awemenu-item > a:hover{
		 color: #fff;
	}
	.input-group{
    z-index: 0;
	}
	/* 11-11-2021 */
	a.hover-initialized {
    color: white !important;
}
.nav .open>a, .nav .open>a:hover, .nav .open>a:focus {
	background-color: #55616f;
}
ul.dropdown-menu.pull-left  {
    left: 0px !important;
}
.dropdown-submenu > .dropdown-menu {
left: 100% !important;
/*border: 1px solid #444d58;*/
border: 1px solid #55616f !important;
    border-radius: 0%;
}
/*.dropdown-menu  {
border: 1px solid #55616f !important;
border-radius: 0%;
}*/
.dropdown-submenu > a{
	color: white !important;
	background-color: #55616f !important;
}
.dropdown-submenu > a:hover{
	color: white !important;
	background-color: #64707e !important;
}
.nav>li>a:hover, .nav>li>a:focus {
    text-decoration: none;
    background-color: #444d58 !important;
}
.dropdown-submenu > a:after{
	display :none;
}
@media only screen and (max-width: 767px){
.nav .open>a, .nav .open>a:hover, .nav .open>a:focus {
    background-color: #ffffff;

    padding: 10px 10px 10px 35px;

}
.navbar-nav {
    margin: 0px -15px;
}
.nav>li>a, .navbar-nav .open .dropdown-menu > li > a{
	padding: 15px 15px 15px 35px;
	font-family: "Open Sans", sans-serif;
	border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}
.navbar-nav .open .dropdown-menu{
	width: 100%;
	padding: 0px 13px 0px 0px;
	box-shadow: 0px 0px rgb(102 102 102 / 10%);
	font-family: "Open Sans", sans-serif;
	color: #000 !important;
}
.dropdown-submenu > a {
    color: #000 !important;
    background-color: #fff !important;
}
.dropdown-menu {
    border: 0px solid #55616f !important;
	
}

.navbar-nav .open .dropdown-menu .subsub-menu{
	position: static;
}
li.menu-dropdown.classic-menu-dropdown.open > a {
	color: #000;
    background-color: #f5f5f5;
	padding: 15px 15px 15px 35px !important;
    text-decoration: none;
    text-transform: capitalize;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}
li.dropdown-submenu.open > a {
	color: #000 !important;
    background-color: #f5f5f5 !important;
	padding: 15px 15px 15px 35px;
    text-decoration: none;
    text-transform: capitalize;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}
.dropdown-submenu > a:hover {
    color: #000 !important;
    background-color: #ffffff !important;
}
.nav .open>a, .nav .open>a:hover, .nav .open>a:focus{
	border-bottom: 1px solid rgba(0, 0, 0, 0.05);
	border-color:rgba(0, 0, 0, 0.05);
}
a.hover-initialized {
    color: #000000 !important;
}
.mobile-display{
display: block !important;
}
.desk-display{
	display: none !important;
}
}
.mobile-display{
display: none;
}
.desk-display{
	display: block;
}
/* 11-11-2021 */
	</style>
	
	
	
	<script> 
		function goBack(){ window.history.back(); }
	</script>
	
	<script>
			var tableToExcel = (function() {	
		  var uri = 'data:application/vnd.ms-excel;base64,'
			, template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head></head><body><table>{table}</table></body></html>'
			, base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
			, format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
		  return function(table, name) {
			if (!table.nodeType) table = document.getElementById(table)
			var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
			window.location.href = uri + base64(format(template, ctx))
		  }
		})()
		
    </script>
	
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
</head>

<body>
<!-- // LOADING --
<div class="awe-page-loading">
	<div class="awe-loading-wrapper">
		<div class="awe-loading-icon">
			<span class="icon icon-logo">Loading...</span>
		</div>
		
		<div class="progress">
			<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
		</div>
	</div>
</div>
!-- // END LOADING --> 
	
	
<!-- BEGIN HEADER -->		
<header id="header" class="awe-menubar-header">
	<nav class="awemenu-nav" data-responsive-width="600">       
		<div class="awemenu-container">
			<div class="awe-logo padding-right-0">
				<div class="container padding-right-5"> 
					<a href="<?php echo base_url().index_page(). 'new_admin/home'; ?>" title=""><img src="assets/new_admin/img/logo.png" alt=""></a> 
					<?php $admin_users = $this->db->query("SELECT * FROM `admin_users` WHERE `id` = '".$this->session->userdata('aId')."'")->result_array();?>
					
					<span class="dropdown dropdown-user dropdown-dark pull-right margin-top-5">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
							<img alt="" style="width:40px; height:40px;" class="img-circle" src="<?php echo base_url() ?><?php echo $admin_users[0]['image_path']; ?>">
							<span class="username username-hide-mobile"><?php echo $admin_users[0]['username']?></span>
						</a>
						<ul class="dropdown-menu dropdown-menu-default">
							<li><a href="<?php echo base_url().index_page()."new_admin/home/change";?>"><i class="icon-user"></i> My Profile </a></li>
							<li class="divider"></li>
							<li><a href="<?php echo base_url().index_page()."new_admin/login/shutdown";?>">
							<i class="icon-key"></i> Log Out </a>
							</li>
						</ul> 
					</span>
				</div>
			</div><!-- /.awe-logo -->

			<div class="container">
			
				<div class="row">
					<div class="col-md-8">
					<ul class="awemenu awemenu-right">
						<li class="awemenu-item active"> <a href="<?php echo base_url().index_page(). 'new_admin/home/dashboard'; ?>" title="">Dashboard</a> </li>
						<li class="awemenu-item active"> <a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;"> Manage <i class="fa fa-angle-down icons"></i></a> 
							<ul class="awemenu-submenu awemenu-megamenu"  >
									<li class="awemenu-megamenu-item padding-0">
										<div class="container-fluid">
											<div class="row">
												<div class="">
													<ul class="list-unstyled">
														<li class="awemenu-item  padding-0"><a href="<?php echo base_url().index_page(). 'new_admin/home/sales_manage'; ?>" style="">Sales</a></li>
														<li class="awemenu-item padding-0"><a href="<?php echo base_url().index_page(). 'new_admin/home/production_manage'; ?>" style="">Production</a></li>                                                  
													</ul>
												</div>
											</div>
										</div>
									</li>
								</ul>
							</li>
							<li class="awemenu-item active"> <a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;"> Report <i class="fa fa-angle-down icons"></i></a> 
								<ul class="awemenu-submenu awemenu-megamenu"  >
										<li class="awemenu-megamenu-item padding-0">
											<div class="container-fluid">
												<div class="row">
													<div class="">
														<ul class="list-unstyled">
															<li class="awemenu-item  padding-0"><a href="<?php echo base_url().index_page().'new_admin/home/admin_report/sales'?>" style="">Sales</a></li>
															<li class="awemenu-item padding-0"><a href="<?php echo base_url().index_page(). 'new_admin/home/production_report'; ?>" style="">Production</a></li>                                                  
															<li class="awemenu-item active padding-0 mobile-display"> <a  href="javascript:;"> Management &#8964; </a> 
																<ul class="awemenu-submenu awemenu-megamenu"  >
																		<li class="awemenu-megamenu-item padding-0">
																			<div class="container-fluid">
																				<div class="row">
																					<div class="">
																						<ul class="list-unstyled">
																							<li class="awemenu-item  padding-0"><a href="<?php echo base_url().index_page(). 'new_admin/home/new_ads_report'; ?>" style="">New Ads</a></li>
																							<li class="awemenu-item padding-0"><a href="<?php echo base_url().index_page(). 'new_admin/home/revision_ads_report'; ?>" style="">Revision Ads</a></li>   
																							<li class="awemenu-item padding-0"><a href="<?php echo base_url().index_page(). 'new_admin/home/revision_ratio_report'; ?>">Revision Ratio </a></li>
																								<li class="awemenu-item padding-0"><a href="<?php echo base_url().index_page(). 'new_admin/home/publication_revision_ratio_report'; ?>">Revision Ratio By Publication</a></li>
																									<li class="awemenu-item padding-0"><a href="<?php echo base_url().index_page(). 'new_admin/home/back_to_designer_report'; ?>">Back To Designer</a></li>
																						</ul>
																					</div>
																				</div>
																			</div>
																		</li>
																	</ul>
															</li>
															<li class="awemenu-item padding-0 dropdown-submenu desk-display">
																<a  href="javascript:;">
																
																Management <i class="fa fa-angle-right icons"></i></a>
																<ul class="dropdown-menu subsub-menu">
																	<li class="dropdown-submenu ">
																		<a href="<?php echo base_url().index_page(). 'new_admin/home/new_ads_report'; ?>">
																			New Ads </a>
																	</li>
																	<li class="dropdown-submenu ">
																		<a href="<?php echo base_url().index_page(). 'new_admin/home/revision_ads_report'; ?>">
																			Revision Ads </a>
																	</li>
																	<li class="dropdown-submenu ">
																		<a href="<?php echo base_url().index_page(). 'new_admin/home/revision_ratio_report'; ?>">
																			Revision Ratio<br/> By Designer</a>
																	</li>
																	<li class="dropdown-submenu ">
																		<a href="<?php echo base_url().index_page(). 'new_admin/home/publication_revision_ratio_report'; ?>">
																			Revision Ratio<br/> By Publication</a>
																	</li>
																	<li class="dropdown-submenu ">
																		<a href="<?php echo base_url().index_page(). 'new_admin/home/back_to_designer_report'; ?>">
																			Back To<br/> Designer</a>
																	</li>
																</ul>
															</li>
															
														</ul>
													</div>
												</div>
											</div>
										</li>
									</ul>
								</li>
							<!--11-11-2021-->
						<!--	<div class="hor-menu ">
								<ul class="nav navbar-nav">
									
								
								
									<li class="menu-dropdown classic-menu-dropdown ">
										<a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;">
											Reports <i class="fa fa-angle-down icons"></i>
										</a>
										<ul class="dropdown-menu pull-left">
											<li class=" dropdown-submenu">
												<a href=":;">
												
												Sales </a>
												
											</li>
											<li class=" dropdown-submenu">
												<a href=":;">
												
												Production </a>
												
											</li>
											<li class=" dropdown-submenu">
												<a href="javascript:;">
												
												Management <i class="fa fa-angle-right icons"></i></a>
												<ul class="dropdown-menu subsub-menu">
													<li class="dropdown-submenu ">
														<a href="charts_amcharts.html">
															New Ads </a>
													</li>
													<li class="dropdown-submenu ">
														<a href="charts_flotcharts.html">
															Revision Ads </a>
													</li>
												</ul>
											</li>
											
										</ul>
									</li>
									
								
								</ul>
							</div>-->
						<!--11-11-2021-->
					</ul>
					</div>
					
					
					<form class="search-form" id="search" name="form" method="get" action="<?php echo base_url().index_page().'new_admin/home/search'?>">
						<div class="input-group">
							<span class="input-group-btn">
								<button type="button" id="buttn"  class="btn bg-search dropdown-toggle" data-toggle="dropdown" tabindex="-1" aria-expanded="false">ID &nbsp;<i class="fa fa-angle-down"></i></button>
								<ul class="dropdown-menu" role="menu">
									<li><a id="showadvancesearch" >All</a></li>
									<li><a>ID </a></li>
								</ul>
							</span>
					
							<input id="inbutn"  type="text" class="form-control" placeholder="Enter AdwitAds ID" name="id" required/>
							<span class="input-group-btn">
								<a href="javascript:;" class="btn"><button type="submit" id="srbuttn"><i class="fa fa-search  font-white"></i></button></a>
							</span>
						</div>
					</form>
					
					<form class="search-form" id="advancesearch" name="form" method="get" action="<?php echo base_url().index_page().'new_admin/home/advance_search'; ?>">
						<div class="input-group">
							<span class="input-group-btn">
								<button type="button" id="buttn" class="btn bg-search dropdown-toggle" data-toggle="dropdown" tabindex="-1" aria-expanded="false">All &nbsp;<i class="fa fa-angle-down"> </i></button>
								<ul class="dropdown-menu" role="menu">
									<li><a>All</a></li>
									<li><a id="idsearch">ID </a></li>
								</ul>
							</span>
							<input type="text" class="form-control" id="inbutn"  placeholder="Enter AdwitAds ID, Job ID or Advertiser Name" name="advance_search_id" required/>
							<span class="input-group-btn">
								<a href="javascript:;" class="btn"><button type="submit" name="advance_search" id="srbuttn" ><i class="fa fa-search font-white"></i></button></a>
							</span>
						</div>
					</form>
				
				</div>			
			</div> <!-- /.container -->
	</nav><!-- /.awe-menubar -->
</header>
<!-- END HEADER -->

<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<div class="page-content">
		<div class="container">			
				