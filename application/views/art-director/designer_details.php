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
<link href="../../../../ui_assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="../../../../ui_assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css">
<link href="../../../../ui_assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="../../../../ui_assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css">
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link href="../../../../ui_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
<link href="../../../../ui_assets/admin/pages/css/profile.css" rel="stylesheet" type="text/css"/>
<link href="../../../../ui_assets/admin/pages/css/tasks.css" rel="stylesheet" type="text/css"/>
<link href="../../../../ui_assets/admin/pages/css/search.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN THEME STYLES -->
<link href="../../../../ui_assets/global/css/components-rounded.css" id="style_components" rel="stylesheet" type="text/css">
<link href="../../../../ui_assets/global/css/plugins.css" rel="stylesheet" type="text/css">
<link href="../../../../ui_assets/admin/layout3/css/layout.css" rel="stylesheet" type="text/css">
<link href="../../../../ui_assets/admin/layout3/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color">
<link href="../../../../ui_assets/admin/layout3/css/custom.css" rel="stylesheet" type="text/css">
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
<script>

function active_deactive(id,result) {
X=confirm("Are you Sure");
if(X==true){
var designer_id = id
var result = result

  $.ajax({
   url: "<?php echo base_url().index_page().'art-director/home/active_deactive';?>",
     data: "designer_id="+designer_id+"&result="+result,
    type: "POST"
    });
	window.location = "<?php echo base_url().index_page().'art-director/home/new_designer';?>";
}
}
</script>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-menu-fixed" class to set the mega menu fixed  -->
<!-- DOC: Apply "page-header-top-fixed" class to set the top menu fixed  -->
<body>


<!-- BEGIN HEADER -->
<?php
       $this->load->view("art-director/top_menu"); 
?>
<!-- END HEADER -->


<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<!-- BEGIN PAGE HEAD -->
	<div class="page-head">
		<div class="container">
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<h1>User <small>details</small></h1>
			</div>
			<!-- END PAGE TITLE -->
			<!-- BEGIN PAGE TOOLBAR -->
			<div class="page-toolbar">
				<!-- BEGIN THEME PANEL -->
	<!-- END THEME PANEL -->
			</div>
			<!-- END PAGE TOOLBAR -->
		</div>
	</div>
	<!-- END PAGE HEAD -->
	<!-- BEGIN PAGE CONTENT -->
	<div class="page-content">
		<div class="container">
			<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">Modal title</h4>
						</div>
						<div class="modal-body">
							 Widget settings form goes here
						</div>
						<div class="modal-footer">
							<button type="button" class="btn blue">Save changes</button>
							<button type="button" class="btn default" data-dismiss="modal">Close</button>
						</div>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>
			<!-- /.modal -->
			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			
			
			<!-- BEGIN PROFILE -->
			 <div class="row margin-top-10">
				<div class="col-md-12">
					<!-- BEGIN PROFILE SIDEBAR -->
					<div class="profile-sidebar" style="width: 250px;">
						<!-- PORTLET MAIN -->
						<div class="portlet light profile-sidebar-portlet">
							<!-- SIDEBAR USERPIC -->
							<div class="profile-userpic">
								<img src="../../../../ui_assets/admin/pages/media/profile/profile_user.jpg" class="img-responsive" alt="">
							</div>
							<!-- END SIDEBAR USERPIC -->
							<!-- SIDEBAR USER TITLE -->
							<div class="profile-usertitle">
								<div class="profile-usertitle-name">
									<?php echo $type[0]['name']; ?>
								</div>
								<div class="profile-usertitle-job">
									 Designer
								</div>
							</div>
							<!-- END SIDEBAR USER TITLE -->
							<!-- SIDEBAR BUTTONS -->
							<div class="profile-userbuttons">
							 <ul class="stars list-inline">
													<li>
														<i class="fa fa-star font-yellow"></i>
													</li>
													<li>
														<i class="fa fa-star font-yellow"></i>
													</li>
													<li>
														<i class="fa fa-star font-yellow"></i>
													</li>
													<li>
														<i class="fa  fa-star-half-o font-yellow"></i>
													</li>
													<li>
														<i class="fa fa-star-o font-yellow"></i>
													</li>
												</ul>
							</div>
							<!-- END SIDEBAR BUTTONS -->
							<!-- SIDEBAR MENU -->
							<div class="profile-usermenu">
								<ul class="nav">
									<li class="active">
										<a href="extra_profile.html">
										<i class="icon-home"></i>
										Overview </a>
									</li>
									<li>
									<div class="profile-userbuttons">
								<button type="button" <?php if($type[0]['is_active']=='1') { ?> onClick="active_deactive(<?php echo $type[0]['id']; ?>,<?php echo $type[0]['is_active']; ?>);" <?php } ?> <?php if($type[0]['is_active']=='0'){ echo "class='btn btn-circle btn-green btn-sm'";} else { echo "class='btn btn-circle btn-danger btn-sm'";} ?>>Deactivate</button>
								<button type="button" <?php if($type[0]['is_active']=='0') { ?> onClick="active_deactive(<?php echo $type[0]['id']; ?>,<?php echo $type[0]['is_active']; ?>);" <?php } ?> class="btn btn-circle green-haze btn-sm"><?php if($type[0]['is_active']=='0'){ echo "Activate";} else { echo "Send Message";} ?></button>
							</div>
							</li>
								</ul>
							</div>
							<!-- END MENU -->
						</div>
						<!-- END PORTLET MAIN -->
					</div>
					<!-- END BEGIN PROFILE SIDEBAR -->
					<!-- BEGIN PROFILE CONTENT -->
					<div class="profile-content">
						<div class="row">
							<div class="col-md-6">
							<?php
foreach($type as $row)
	 $location = $this->db->get_where('location',array('id' => $row['Join_location']))->result_array(); 
	 $teams = $this->db->get_where('designer_assign',array('designer_id' => $row['id']))->result_array();
	?> 
							
								<!-- BEGIN PORTLET -->
								<div class="portlet light ">
									<div class="portlet-title">
										<div class="caption caption-md">
											<i class="icon-bar-chart theme-font hide"></i>
											<span class="caption-subject font-blue-madison bold uppercase">About</span>
											<span class="caption-helper hide">weekly stats...</span>
										</div>
									</div>
									<div class="portlet-body">
								       <div class="table-scrollable table-scrollable-borderless">
											<table class="table table-hover table-light">
											<tr>
												<td>
													<span class="bold theme-font">Location</span>
												</td>
												<td>
													 <?php if(!empty($location[0]['name'])){ echo $location[0]['name'];} ?>
												</td>
											</tr>
											<tr>
												<td>
													<span class="bold theme-font">Team</span>
												</td>
												<td>
													 <?php if(isset($teams[0]['help_desk_id'])) { $teams_name = $this->db->get_where('help_desk',array('id' => $teams[0]['help_desk_id']))->result_array();
													 echo $teams_name[0]['d_name']; } ?>
												</td>
											</tr>
											<tr>
												<td>
													<span class="bold theme-font">Joining Date</span>
												</td>
												<td>
													 10/3/2011
												</td>
											</tr>
											<tr>
												<td>
													<span class="bold theme-font">Capacity</span>
												</td>
												<td>
													 <span class="badge badge-success"> 20 </span>
												</td>
											</tr>
											</table>
										</div>
									</div>
								</div>
								<!-- END PORTLET -->
							</div>
							<div class="col-md-6">
								<!-- BEGIN PORTLET -->
								<div class="portlet light">
									<div class="portlet-title tabbable-line">
										<div class="caption caption-md">
											<i class="icon-globe theme-font hide"></i>
											<span class="caption-subject font-blue-madison bold uppercase">Performance</span>
										</div>
									</div>
									
									<div class="portlet-body">
								       <div class="table-scrollable">
									<table class="table table-hover table-bordered">
											<thead>
											<tr class="uppercase">
												<th></th>
												<th>
													 <span class="bold theme-font">A</span>
												</th>
												<th>
													 <span class="bold theme-font">B</span>
												</th>
												<th>
													 <span class="bold theme-font">C</span>
												</th>
												<th>
													 <span class="bold theme-font">D</span>
												</th>
												<th>
													 <span class="bold theme-font">E</span>
												</th>
												<th>
													 <span class="bold theme-font">F</span>
												</th>
												<th>
													 <span class="bold theme-font">G</span>
												</th>
											</tr>
											</thead>
											<tbody>
											<tr>
												<td>
													<span class="bold theme-font">Ads</span>
												</td>
												<td>
													 12
												</td>
												<td>
													 10
												</td>
												<td>
													 12
												</td>
												<td>
													 15
												</td>
												<td>
													 18
												</td>
												<td>
													 20
												</td>
												<td>
													 22
												</td>
											</tr>
											<tr>
												<td>
													<span class="bold theme-font">NJ's</span>
												</td>
												<td>
													 08
												</td>
												<td>
													 16
												</td>
												<td>
													 22
												</td>
												<td>
													 10
												</td>
												<td>
													 11
												</td>
												<td>
													 15
												</td>
												<td>
													 12
												</td>
											</tr>
											<tr>
												<td>
													<span class="bold theme-font">RV</span>
												</td>
												<td>
													 05
												</td>
												<td>
													 12
												</td>
												<td>
													 11
												</td>
												<td>
													 10
												</td>
												<td>
													 18
												</td>
												<td>
													 15
												</td>
												<td>
													 20
												</td>
											</tr>
											</tbody>
									</table>
									</div>
									</div>
								</div>
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
<script src="../../../../ui_assets/global/plugins/respond.min.js"></script>
<script src="../../../../ui_assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="../../../../ui_assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="../../../../ui_assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="../../../../ui_assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
<script src="../../../../ui_assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../../../ui_assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="../../../../ui_assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../../../ui_assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="../../../../ui_assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="../../../../ui_assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="../../../../ui_assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="../../../../ui_assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../../../../ui_assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
<script type="text/javascript" src="../../../../ui_assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js"></script>
<script type="text/javascript" src="../../../../ui_assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
<script src="../../../../ui_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
<script src="../../../../ui_assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../../../../ui_assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="../../../../ui_assets/admin/layout3/scripts/layout.js" type="text/javascript"></script>
<script src="../../../../ui_assets/admin/layout3/scripts/demo.js" type="text/javascript"></script>
<script src="../../../../ui_assets/admin/pages/scripts/table-advanced.js"></script>
<script src="../../../../ui_assets/global/scripts/datatable.js"></script>
<script src="../../../../ui_assets/admin/pages/scripts/table-ajax.js"></script>
<script src="../../../../ui_assets/admin/pages/scripts/profile.js" type="text/javascript"></script>
<script>
jQuery(document).ready(function() {       
   	// initiate layout and plugins
   	Metronic.init(); // init metronic core components
	Layout.init(); // init current layout
	Demo.init(); // init demo features\
	Profile.init(); // init page demo
});
</script>
</body>
<!-- END BODY -->
</html>