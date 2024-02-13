<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>Adwitads | Managment Dashboard</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css">
<link href="../../../ui_assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="../../../ui_assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css">
<link href="../../../ui_assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="../../../ui_assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css">
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link href="../../../ui_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
<link href="../../../ui_assets/admin/pages/css/profile.css" rel="stylesheet" type="text/css"/>
<link href="../../../ui_assets/admin/pages/css/tasks.css" rel="stylesheet" type="text/css"/>
<link href="../../../ui_assets/admin/pages/css/search.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN THEME STYLES -->
<link href="../../../ui_assets/global/css/components-rounded.css" id="style_components" rel="stylesheet" type="text/css">
<link href="../../../ui_assets/global/css/plugins.css" rel="stylesheet" type="text/css">
<link href="../../../ui_assets/admin/layout3/css/layout.css" rel="stylesheet" type="text/css">
<link href="../../../ui_assets/admin/layout3/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color">
<link href="../../../ui_assets/admin/layout3/css/custom.css" rel="stylesheet" type="text/css">
<!-- END THEME STYLES -->
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-menu-fixed" class to set the mega menu fixed  -->
<!-- DOC: Apply "page-header-top-fixed" class to set the top menu fixed  -->
<body>

<!-- BEGIN HEADER -->
<div class="page-header">
	<!-- BEGIN HEADER TOP -->
	<div class="page-header-top">
		<div class="container">
			<!-- BEGIN LOGO -->
			<div class="page-logo">
				<a href="index.html"><img src="../../../ui_assets/admin/layout3/img/logo-default.png" alt="logo" class="logo-default"></a>
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
						<img alt="" class="img-circle" src="../../../ui_assets/admin/layout3/img/avatar9.jpg">
						<span class="username username-hide-mobile">Acharya</span>
						</a>
						<ul class="dropdown-menu dropdown-menu-default">
							<li>
								<a href="extra_profile.html">
								<i class="icon-user"></i> My Profile </a>
							</li>
							<li class="divider">
							</li>
							<li>
								<a href="lock_screen.html">
								<i class="icon-lock"></i> Lock Screen </a>
							</li>
							<li>
								<a href="login.html">
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

			<!-- BEGIN MEGA MENU -->
			<!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
			<!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
			<div class="hor-menu ">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="index.html">Dashboard</a>
					</li>
					<li class="menu-dropdown classic-menu-dropdown ">
						<a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;">
						Reports <i class="fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu pull-left">
							<li class=" dropdown-submenu">
								<a href=javascript:;>
								<i class="icon-briefcase"></i>
								Orders </a>
								<ul class="dropdown-menu">
									<li class=" ">
										<a href="table_basic.html">
										Publication </a>
									</li>
								</ul>
							</li>
							<li class=" dropdown-submenu">
								<a href=javascript:;>
								<i class="icon-bar-chart"></i>
								Production </a>
								<ul class="dropdown-menu">
									<li class=" ">
										<a href="charts_amcharts.html">
										Designer </a>
									</li>
								</ul>
							</li>
						</ul>
					</li>
				</ul>
			</div>
			<!-- END MEGA MENU -->
		</div>
	</div>
	<!-- END HEADER MENU -->
</div>
<!-- END HEADER -->

<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<!-- BEGIN PAGE HEAD -->
	<!-- END PAGE HEAD -->
	<!-- BEGIN PAGE CONTENT -->
	<div class="page-content">
		<div class="container">	
			<!-- BEGIN PROFILE -->
			 <div class="row margin-top-10">
				<div class="col-md-12">
					<!-- BEGIN PROFILE CONTENT -->
					<div class="profile-content">
						<div class="row">
						
						    <div class="col-md-4">
								<!-- BEGIN PORTLET -->
								<div class="portlet light ">
									<div class="portlet-title">
										<div class="caption caption-md">
											<i class="icon-bar-chart theme-font hide"></i>
											<span class="caption-subject font-blue-madison bold uppercase">Team 1</span>
											<span class="caption-helper hide">weekly stats...</span>
										</div>
										<div class="tools">
										  <button class="btn grey btn-xs" data-toggle="modal" href="#responsive1">Add </button>
										  <button class="btn red-pink btn-xs font-mx" data-toggle="modal" href="#responsive2">Remove </button>
								        </div>
								         <div id="responsive1" class="modal fade" tabindex="-1" aria-hidden="true">
							             	<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Add to Team 1</h4>
										</div>
										<div class="modal-body">
										<form method="POST" action="hh.php"> 
											<div class="scroller" style="height:250px" data-always-visible="1" data-rail-visible1="1">
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
										                       <h4>Group</h4>
									                              <select class="form-control">
											                         <option>Option 1</option>
											                         <option>Option 2</option>
																	 <option>Option 3</option>
																	 <option>Option 4</option>
										                           </select>
									                    </div>
														
														<div class="form-group">
										                       <h4>Designer</h4>
									                              <select class="form-control">
											                         <option>Option 1</option>
											                         <option>Option 2</option>
											                         <option>Option 3</option>
											                         <option>Option 4</option>
										                           </select>
									                    </div>
														
														<div class="form-group">
										                       <h4>Team Lead</h4>
									                              <select class="form-control">
											                         <option>Option 1</option>
											                         <option>Option 2</option>
											                         <option>Option 3</option>
											                         <option>Option 4</option>
										                           </select>
									                    </div>
													</div>
													</div>
											</div>
											
										</div>
										<div class="modal-footer">
											<button type="button" data-dismiss="modal" class="btn default">Close</button>
											<button type="submit" class="btn green">Save changes</button>
										</div>
										</form>
									</div>
								</div>
							            </div>
										 <div id="responsive2" class="modal fade" tabindex="-1" aria-hidden="true">
								           <div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Remove from Team 1</h4>
										</div>
										<div class="modal-body">
											<div class="scroller" style="height:250px" data-always-visible="1" data-rail-visible1="1">
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
										                       <h4>Group</h4>
									                              <select class="form-control">
											                         <option>Option 1</option>
											                         <option>Option 2</option>
																	 <option>Option 3</option>
																	 <option>Option 4</option>
										                           </select>
									                    </div>
														
														<div class="form-group">
										                       <h4>Designer</h4>
									                              <select class="form-control">
											                         <option>Option 1</option>
											                         <option>Option 2</option>
											                         <option>Option 3</option>
											                         <option>Option 4</option>
										                           </select>
									                    </div>
														
														<div class="form-group">
										                       <h4>Team Lead</h4>
									                              <select class="form-control">
											                         <option>Option 1</option>
											                         <option>Option 2</option>
											                         <option>Option 3</option>
											                         <option>Option 4</option>
										                           </select>
									                    </div>
													</div>
													</div>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" data-dismiss="modal" class="btn default">Close</button>
											<button type="button" class="btn green">Save changes</button>
										</div>
									</div>
								</div>
						                 </div>
							        </div>
				<!-- BEGIN ACCORDION PORTLET-->
							<div class="panel-group accordion" id="accordion1">
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
										<a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion1" href="#collapse_1_1">
										<span class="badge badge-success bg-green-haze"> 10 </span>
										&nbsp;<span class="font-mx">Group </span>
										 
										</a>
										</h4>
									</div>
									<div id="collapse_1_1" class="panel-collapse collapse">
									  <div class="panel-body">
										 <table class="table table-hover table-light">
										   <thead>
											<tr>
												<th class="font-blue-madison">Name</th>
												<th></th>
											</tr>
											</thead>
										   <tbody>
											<tr>
												<td>
													<span>A</span>
												</td>
												<td>
													 <a href="javascript:;" class="label label-sm bg-blue-madison label-mini">View</a>
												</td>
											</tr>
											<tr>
												<td>
													<span>B</span>
												</td>
												<td>
													  <a href="javascript:;" class="label label-sm bg-blue-madison label-mini">View</a>
												</td>
											</tr>
										  </tbody>	
										</table>	
									  </div>
									</div>
								</div>
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
										<a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion1" href="#collapse_1_2">
										<span class="badge badge-success bg-green-haze"> 10 </span>
										&nbsp;<span class="font-mx">Designer</span>
										</a>
										</h4>
									</div>
									<div id="collapse_1_2" class="panel-collapse collapse">
										<div class="panel-body">
										 <table class="table table-hover table-light">
										   <thead>
											<tr>
												<th class="font-blue-madison">Name</th>
												<th></th>
											</tr>
											</thead>
										   <tbody>
											<tr>
												<td>
													<span>A</span>
												</td>
												<td>
													 <a href="javascript:;" class="label label-sm bg-blue-madison label-mini">View</a>
												</td>
											</tr>
											<tr>
												<td>
													<span>B</span>
												</td>
												<td>
													  <a href="javascript:;" class="label label-sm bg-blue-madison label-mini">View</a>
												</td>
											</tr>
										  </tbody>	
										</table>	
									  </div>
									</div>
								</div>
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
										<a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion1" href="#collapse_1_3">
										<span class="badge badge-success bg-green-haze"> 10 </span>
										&nbsp;<span class="font-mx">Team Lead</span>
										</a>
										</h4>
									</div>
									<div id="collapse_1_3" class="panel-collapse collapse">
										<div class="panel-body">
										 <table class="table table-hover table-light">
										   <thead>
											<tr>
												<th class="font-blue-madison">Name</th>
												<th></th>
											</tr>
											</thead>
										   <tbody>
											<tr>
												<td>
													<span>A</span>
												</td>
												<td>
													 <a href="javascript:;" class="label label-sm bg-blue-madison label-mini">View</a>
												</td>
											</tr>
											<tr>
												<td>
													<span>B</span>
												</td>
												<td>
													  <a href="javascript:;" class="label label-sm bg-blue-madison label-mini">View</a>
												</td>
											</tr>
										  </tbody>	
										</table>	
									  </div>
									</div>
								</div>
							</div>
				<!-- END ACCORDION PORTLET-->
			<!-- END PORTLET -->
							</div>
						</div>
					
							<div class="col-md-4">
								<!-- BEGIN PORTLET -->
								<div class="portlet light ">
									<div class="portlet-title">
										<div class="caption caption-md">
											<i class="icon-bar-chart theme-font hide"></i>
											<span class="caption-subject font-blue-madison bold uppercase">Team 2</span>
											<span class="caption-helper hide">weekly stats...</span>
										</div>
										<div class="tools">
										  <button class="btn grey btn-xs" data-toggle="modal" href="#responsive3">Add </button>
										  <button class="btn red-pink btn-xs font-mx" data-toggle="modal" href="#responsive4">Remove </button>
								        </div>
								         <div id="responsive3" class="modal fade" tabindex="-1" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Add to Team 2</h4>
										</div>
										<div class="modal-body">
											<div class="scroller" style="height:250px" data-always-visible="1" data-rail-visible1="1">
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
										                       <h4>Group</h4>
									                              <select class="form-control">
											                         <option>Option 1</option>
											                         <option>Option 2</option>
																	 <option>Option 3</option>
																	 <option>Option 4</option>
										                           </select>
									                    </div>
														
														<div class="form-group">
										                       <h4>Designer</h4>
									                              <select class="form-control">
											                         <option>Option 1</option>
											                         <option>Option 2</option>
											                         <option>Option 3</option>
											                         <option>Option 4</option>
										                           </select>
									                    </div>
														
														<div class="form-group">
										                       <h4>Team Lead</h4>
									                              <select class="form-control">
											                         <option>Option 1</option>
											                         <option>Option 2</option>
											                         <option>Option 3</option>
											                         <option>Option 4</option>
										                           </select>
									                    </div>
													</div>
													</div>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" data-dismiss="modal" class="btn default">Close</button>
											<button type="button" class="btn green">Save changes</button>
										</div>
									</div>
								</div>
							            </div>
										  <div id="responsive4" class="modal fade" tabindex="-1" aria-hidden="true">
								 <div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Remove from Team 2</h4>
										</div>
										<div class="modal-body">
											<div class="scroller" style="height:250px" data-always-visible="1" data-rail-visible1="1">
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
										                       <h4>Group</h4>
									                              <select class="form-control">
											                         <option>Option 1</option>
											                         <option>Option 2</option>
																	 <option>Option 3</option>
																	 <option>Option 4</option>
										                           </select>
									                    </div>
														
														<div class="form-group">
										                       <h4>Designer</h4>
									                              <select class="form-control">
											                         <option>Option 1</option>
											                         <option>Option 2</option>
											                         <option>Option 3</option>
											                         <option>Option 4</option>
										                           </select>
									                    </div>
														
														<div class="form-group">
										                       <h4>Team Lead</h4>
									                              <select class="form-control">
											                         <option>Option 1</option>
											                         <option>Option 2</option>
											                         <option>Option 3</option>
											                         <option>Option 4</option>
										                           </select>
									                    </div>
													</div>
													</div>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" data-dismiss="modal" class="btn default">Close</button>
											<button type="button" class="btn green">Save changes</button>
										</div>
									</div>
								</div>
						                 </div>
							        </div>
				<!-- BEGIN ACCORDION PORTLET-->
							<div class="panel-group accordion" id="accordion2">
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
										<a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_1">
										<span class="badge badge-success bg-green-haze"> 10 </span>
										&nbsp;<span class="font-mx">Group </span>
										 
										</a>
										</h4>
									</div>
									<div id="collapse_2_1" class="panel-collapse collapse">
										<div class="panel-body">
										 <table class="table table-hover table-light">
										   <thead>
											<tr>
												<th class="font-blue-madison">Name</th>
												<th></th>
											</tr>
											</thead>
										   <tbody>
											<tr>
												<td>
													<span>A</span>
												</td>
												<td>
													 <a href="javascript:;" class="label label-sm bg-blue-madison label-mini">View</a>
												</td>
											</tr>
											<tr>
												<td>
													<span>B</span>
												</td>
												<td>
													  <a href="javascript:;" class="label label-sm bg-blue-madison label-mini">View</a>
												</td>
											</tr>
										  </tbody>	
										</table>	
									  </div>
									</div>
								</div>
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
										<a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_2">
										<span class="badge badge-success bg-green-haze"> 10 </span>
										&nbsp;<span class="font-mx">Designer</span>
										</a>
										</h4>
									</div>
									<div id="collapse_2_2" class="panel-collapse collapse">
										<div class="panel-body">
										 <table class="table table-hover table-light">
										   <thead>
											<tr>
												<th class="font-blue-madison">Name</th>
												<th></th>
											</tr>
											</thead>
										   <tbody>
											<tr>
												<td>
													<span>A</span>
												</td>
												<td>
													 <a href="javascript:;" class="label label-sm bg-blue-madison label-mini">View</a>
												</td>
											</tr>
											<tr>
												<td>
													<span>B</span>
												</td>
												<td>
													  <a href="javascript:;" class="label label-sm bg-blue-madison label-mini">View</a>
												</td>
											</tr>
										  </tbody>	
										</table>	
									  </div>
									</div>
								</div>
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
										<a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_3">
										<span class="badge badge-success bg-green-haze"> 10 </span>
										&nbsp;<span class="font-mx">Team Lead</span>
										</a>
										</h4>
									</div>
									<div id="collapse_2_3" class="panel-collapse collapse">
										<div class="panel-body">
										 <table class="table table-hover table-light">
										   <thead>
											<tr>
												<th class="font-blue-madison">Name</th>
												<th></th>
											</tr>
											</thead>
										   <tbody>
											<tr>
												<td>
													<span>A</span>
												</td>
												<td>
													 <a href="javascript:;" class="label label-sm bg-blue-madison label-mini">View</a>
												</td>
											</tr>
											<tr>
												<td>
													<span>B</span>
												</td>
												<td>
													  <a href="javascript:;" class="label label-sm bg-blue-madison label-mini">View</a>
												</td>
											</tr>
										  </tbody>	
										</table>	
									  </div>
									</div>
								</div>
							</div>
					<!-- END ACCORDION PORTLET-->
			<!-- END PORTLET -->
							</div>
						</div>
					
							<div class="col-md-4">
								<!-- BEGIN PORTLET -->
								<div class="portlet light ">
									<div class="portlet-title">
										<div class="caption caption-md">
											<i class="icon-bar-chart theme-font hide"></i>
											<span class="caption-subject font-blue-madison bold uppercase">Team 3</span>
											<span class="caption-helper hide">weekly stats...</span>
										</div>
										<div class="tools">
										  <button class="btn grey btn-xs" data-toggle="modal" href="#responsive5">Add </button>
										  <button class="btn red-pink btn-xs font-mx" data-toggle="modal" href="#responsive6">Remove </button>
								        </div>
								         <div id="responsive5" class="modal fade" tabindex="-1" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Add to Team 3</h4>
										</div>
										<div class="modal-body">
											<div class="scroller" style="height:250px" data-always-visible="1" data-rail-visible1="1">
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
										                       <h4>Group</h4>
									                              <select class="form-control">
											                         <option>Option 1</option>
											                         <option>Option 2</option>
																	 <option>Option 3</option>
																	 <option>Option 4</option>
										                           </select>
									                    </div>
														
														<div class="form-group">
										                       <h4>Designer</h4>
									                              <select class="form-control">
											                         <option>Option 1</option>
											                         <option>Option 2</option>
											                         <option>Option 3</option>
											                         <option>Option 4</option>
										                           </select>
									                    </div>
														
														<div class="form-group">
										                       <h4>Team Lead</h4>
									                              <select class="form-control">
											                         <option>Option 1</option>
											                         <option>Option 2</option>
											                         <option>Option 3</option>
											                         <option>Option 4</option>
										                           </select>
									                    </div>
													</div>
													</div>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" data-dismiss="modal" class="btn default">Close</button>
											<button type="button" class="btn green">Save changes</button>
										</div>
									</div>
								</div>
							            </div>
										  <div id="responsive6" class="modal fade" tabindex="-1" aria-hidden="true">
								            <div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Remove from Team 3</h4>
										</div>
										<div class="modal-body">
											<div class="scroller" style="height:250px" data-always-visible="1" data-rail-visible1="1">
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
										                       <h4>Group</h4>
									                              <select class="form-control">
											                         <option>Option 1</option>
											                         <option>Option 2</option>
																	 <option>Option 3</option>
																	 <option>Option 4</option>
										                           </select>
									                    </div>
														
														<div class="form-group">
										                       <h4>Designer</h4>
									                              <select class="form-control">
											                         <option>Option 1</option>
											                         <option>Option 2</option>
											                         <option>Option 3</option>
											                         <option>Option 4</option>
										                           </select>
									                    </div>
														
														<div class="form-group">
										                       <h4>Team Lead</h4>
									                              <select class="form-control">
											                         <option>Option 1</option>
											                         <option>Option 2</option>
											                         <option>Option 3</option>
											                         <option>Option 4</option>
										                           </select>
									                    </div>
													</div>
													</div>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" data-dismiss="modal" class="btn default">Close</button>
											<button type="button" class="btn green">Save changes</button>
										</div>
									</div>
								</div>
						                 </div>
							        </div>
				<!-- BEGIN ACCORDION PORTLET-->
							<div class="panel-group accordion" id="accordion3">
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
										<a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_1">
										<span class="badge badge-success bg-green-haze"> 10 </span>
										&nbsp;<span class="font-mx">Group </span>
										 
										</a>
										</h4>
									</div>
									<div id="collapse_3_1" class="panel-collapse collapse">
										<div class="panel-body">
										 <table class="table table-hover table-light">
										   <thead>
											<tr>
												<th class="font-blue-madison">Name</th>
												<th></th>
											</tr>
											</thead>
										   <tbody>
											<tr>
												<td>
													<span>A</span>
												</td>
												<td>
													 <a href="javascript:;" class="label label-sm bg-blue-madison label-mini">View</a>
												</td>
											</tr>
											<tr>
												<td>
													<span>B</span>
												</td>
												<td>
													  <a href="javascript:;" class="label label-sm bg-blue-madison label-mini">View</a>
												</td>
											</tr>
										  </tbody>	
										</table>	
									  </div>
									</div>
								</div>
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
										<a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_2">
										<span class="badge badge-success bg-green-haze"> 10 </span>
										&nbsp;<span class="font-mx">Designer</span>
										</a>
										</h4>
									</div>
									<div id="collapse_3_2" class="panel-collapse collapse">
									  <div class="panel-body">
										 <table class="table table-hover table-light">
										   <thead>
											<tr>
												<th class="font-blue-madison">Name</th>
												<th></th>
											</tr>
											</thead>
										   <tbody>
											<tr>
												<td>
													<span>A</span>
												</td>
												<td>
													 <a href="javascript:;" class="label label-sm bg-blue-madison label-mini">View</a>
												</td>
											</tr>
											<tr>
												<td>
													<span>B</span>
												</td>
												<td>
													  <a href="javascript:;" class="label label-sm bg-blue-madison label-mini">View</a>
												</td>
											</tr>
										  </tbody>	
										</table>	
									  </div>
									</div>
								</div>
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
										<a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_3">
										<span class="badge badge-success bg-green-haze"> 10 </span>
										&nbsp;<span class="font-mx">Team Lead</span>
										</a>
										</h4>
									</div>
									<div id="collapse_3_3" class="panel-collapse collapse">
									<div class="panel-body">
										 <table class="table table-hover table-light">
										   <thead>
											<tr>
												<th class="font-blue-madison">Name</th>
												<th></th>
											</tr>
											</thead>
										   <tbody>
											<tr>
												<td>
													<span>A</span>
												</td>
												<td>
													 <a href="javascript:;" class="label label-sm bg-blue-madison label-mini">View</a>
												</td>
											</tr>
											<tr>
												<td>
													<span>B</span>
												</td>
												<td>
													  <a href="javascript:;" class="label label-sm bg-blue-madison label-mini">View</a>
												</td>
											</tr>
										  </tbody>	
										</table>	
									  </div>
									</div>
								</div>
							</div>
					<!-- END ACCORDION PORTLET-->
			<!-- END PORTLET -->
							</div>
						</div>
					
				    	</div>
					<!-- END PROFILE CONTENT -->
			    	</div>
		    	</div>
			<!-- END PROFILE -->
			</div>
	    </div>
	</div>
	<!-- END PAGE CONTENT -->
	
	
</div>
<!-- END PAGE CONTAINER -->


<!-- BEGIN PRE-FOOTER -->
	
<!-- END PRE-FOOTER -->

<!-- BEGIN FOOTER -->
<div class="page-footer">
	<div class="container">
		 2014 &copy; Metronic. All Rights Reserved.
	</div>
</div>
<div class="scroll-to-top">
	<i class="icon-arrow-up"></i>
</div>
<!-- END FOOTER -->

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="../../../ui_assets/global/plugins/respond.min.js"></script>
<script src="../../../ui_assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="../../../ui_assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="../../../ui_assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="../../../ui_assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
<script src="../../../ui_assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../../ui_assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="../../../ui_assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../../ui_assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="../../../ui_assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="../../../ui_assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="../../../ui_assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="../../../ui_assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>


<script type="text/javascript" src="../../../ui_assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
<script src="../../../ui_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
<script src="../../../ui_assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
<script src="../../../ui_assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../../../ui_assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="../../../ui_assets/admin/layout3/scripts/layout.js" type="text/javascript"></script>
<script src="../../../ui_assets/admin/layout3/scripts/demo.js" type="text/javascript"></script>
<script src="../../../ui_assets/admin/pages/scripts/table-advanced.js"></script>
<script src="../../../ui_assets/global/scripts/datatable.js"></script>
<script src="../../../ui_assets/admin/pages/scripts/table-ajax.js"></script>
<script src="../../../ui_assets/admin/pages/scripts/profile.js" type="text/javascript"></script>
<script src="../../../ui_assets/admin/pages/scripts/ui-alert-dialog-api.js"></script>

<script>
jQuery(document).ready(function() {       
   // initiate layout and plugins
   Metronic.init(); // init metronic core components
   Layout.init(); // init current layout
   Demo.init(); // init demo features
});
</body>
<!-- END BODY -->
</html>