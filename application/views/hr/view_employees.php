<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>Adwitads | HR Dashboard</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>ui_assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>ui_assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>ui_assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>ui_assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css">
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>ui_assets/global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>ui_assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>ui_assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>ui_assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>ui_assets/global/plugins/bootstrap-datepicker/css/datepicker.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>ui_assets/admin/pages/css/todo.css"/>
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN THEME STYLES -->
<link href="<?php echo base_url(); ?>ui_assets/global/css/components-rounded.css" id="style_components" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>ui_assets/global/css/plugins.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>ui_assets/admin/layout3/css/layout.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>ui_assets/admin/layout3/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color">
<link href="<?php echo base_url(); ?>ui_assets/admin/layout3/css/custom.css" rel="stylesheet" type="text/css">
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
<?php
       $this->load->view("hr/top_menu"); 
?>

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
					<div class="col-md-3">
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
									<?php echo $details_emp[0]['empname']; ?>
								</div>
								
							</div>
							<!-- END SIDEBAR USER TITLE -->
							
							<!-- SIDEBAR MENU -->
							<div class="profile-usermenu">
								<ul class="nav">
									<li class="active">
										<a href="extra_profile.html">
										<i class="icon-home"></i>
										Overview </a>
									</li>
									<li>
									<?php 
								foreach($details_emp as $row)
								{
								?>
									<div class="profile-userbuttons">
									<a href= "<?php echo base_url().index_page().'hr/home/deactivate/'.$row['empid'];?>">
									<input id="button" type="button" name="button" value="Deactivate" class="btn btn-circle btn-danger btn-sm"></a>
									
									
								</div>
								<?php
								}
								?>
							</li>
								</ul>
							</div>
							<!-- END MENU -->
						</div>
						<!-- END PORTLET MAIN -->
					</div>
					</div>
					<!-- END BEGIN PROFILE SIDEBAR -->
					<!-- BEGIN PROFILE CONTENT -->
					<div class="profile-content">
						
							<div class="col-md-9">
							<!-- BEGIN PORTLET -->
								<div class="portlet light ">
									<div class="portlet-title">
										<div class="caption caption-md">
											<i class="icon-bar-chart theme-font hide"></i>
											<span class="caption-subject font-blue-madison bold uppercase">Personal Details</span>
											<span class="caption-helper hide">weekly stats...</span>
										</div>
									</div>
									<div class="portlet-body">
									<?php 
								foreach($details_emp as $row)
								{
							?>
								       <div class="table-scrollable table-scrollable-borderless">
											<table class="table table-hover table-light">
											<tr>
												<td>
													<span class="bold theme-font">Name</span>
												</td>
												<td>
													 <?php echo $row['empname'];?>
												</td>
											</tr>
											<tr>
												<td>
													<span class="bold theme-font">Date of Birth</span>
												</td>
												<td>
													 <?php echo $row['empdob'];?>
												</td>
											</tr>
											<tr>
												<td>
													<span class="bold theme-font">Father Name</span>
												</td>
												<td>
													 <?php echo $row['fathername'];?>
												</td>
											</tr>
											<tr>
												<td>
													<span class="bold theme-font">Gender</span>
												</td>
												<td>
													<?php echo $row['gender'];?>
													 
												</td>
											</tr>
											<tr>
												<td>
													<span class="bold theme-font">Nationality</span>
												</td>
												<td>
													<?php echo $row['nationality'];?>					
												</td>
											</tr>
											<tr>
												<td>
													<span class="bold theme-font">Marital Status</span>
												</td>
												<td>
													<?php echo $row['marital_status'];?>
												</td>
											</tr>
											<tr>
												<td>
													<span class="bold theme-font">Contact Number</span>
												</td>
												<td>
													 <?php echo $row['contact_no'];?>
												</td>
											</tr>
											<tr>
												<td>
													<span class="bold theme-font">Present Address</span>
												</td>
												<td>
													 <?php echo $row['present_addr'];?>
												</td>
											</tr>
											<tr>
												<td>
													<span class="bold theme-font">Premanent Address</span>
												</td>
												<td>
													 <?php echo $row['permanent_addr'];?>
												</td>
											</tr>
											<tr>
												<td>
													<span class="bold theme-font">Personnal Email_id</span>
												</td>
												<td>
													 <?php echo $row['personalemail_id'];?>
												</td>
											</tr>
											<tr>
												<td>
													<span class="bold theme-font">Spouse Name</span>
												</td>
												<td>
													 <?php echo $row['spousename'];?>
												</td>
											</tr>
											<tr>
												<td>
													<span class="bold theme-font">Children Name</span>
												</td>
												<td>
													 <?php echo $row['childrenname'];?>
												</td>
											</tr>
											<tr>
												<td>
													<span class="bold theme-font">Educational Details</span>
												</td>
												<td>
													<?php echo $row['educational_details'];?>
												</td>
											</tr>
											<tr>
												<td>
													<span class="bold theme-font">Language Proficiency</span>
												</td>
												<td>
													 <?php echo $row['language_proficiency'];?>
												</td>
											</tr>
											<tr>
												<td>
													<span class="bold theme-font">Designation</span>
												</td>
												<td>
													 <?php $designation=$this->db->get_where('designation',array('id'=>$row['designation']))->result_array();
														echo $designation[0]['name'] ?>
												</td>
											</tr>
											<tr>
												<td>
													<span class="bold theme-font">Date of Joining</span>
												</td>
												<td>
													 <?php echo $row['doj'];?>
												</td>
											</tr>
											<tr>
												<td>
													<span class="bold theme-font">Branch</span>
												</td>
												<td>
													 <?php $branch=$this->db->get_where('branch',array('id'=>$row['branch']))->result_array();  
											echo $branch[0]['name'];?>
												</td>
											</tr>
											<tr>
												<td>
													<span class="bold theme-font">Emp. Is Active</span>
												</td>
												<td>
													 <?php if($row['isactive']=='1') echo "Yes"; else echo "No"; ?>
												</td>
											</tr>
											<tr>
												<td>
													<span class="bold theme-font">Date of Resignation</span>
												</td>
												<td>
													 <?php echo $row['dor'];?>
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
											<span class="caption-subject font-blue-madison bold uppercase">Previous Employment Details</span>
										</div>
									</div>
									
									<div class="portlet-body">
								       <div class="table-scrollable table-scrollable-borderless">
									<table class="table table-hover table-light">
											<tbody>
											<tr>
												<td>
													<span class="bold theme-font">Organisation</span>
												</td>
												<td>
													<?php $organisation=$this->db->get_where('emp_experience',array('empid'=>$row['empid']))->result_array();
													echo $organisation[0]['organisation'] ?>
												</td>
												
											</tr>
											<tr>
												<td>
													<span class="bold theme-font">Role</span>
												</td>
												<td>
													 <?php $role=$this->db->get_where('emp_experience',array('empid'=>$row['empid']))->result_array();
														echo $role[0]['role'] ?>
												</td>
												
											</tr>
											<tr>
												<td>
													<span class="bold theme-font">From Date</span>
												</td>
												<td>
													<?php $fromdate=$this->db->get_where('emp_experience',array('empid'=>$row['empid']))->result_array();
													echo $fromdate[0]['from_dt'] ?>
												</td>
												
											</tr>
											<tr>
												<td>
													<span class="bold theme-font">To Date</span>
												</td>
												<td>
													 <?php $todate=$this->db->get_where('emp_experience',array('empid'=>$row['empid']))->result_array();
														echo $todate[0]['to_dt']; ?>
												</td>
												
											</tr>
											</tbody>
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
											<span class="caption-subject font-blue-madison bold uppercase">Other Details</span>
										</div>
									</div>
									
									<div class="portlet-body">
								       <div class="table-scrollable table-scrollable-borderless">
									<table class="table table-hover table-light">
											<tbody>
											<tr>
												<td>
													<span class="bold theme-font">Bank Account</span>
												</td>
												<td>
													 <?php $bankaccount=$this->db->get_where('emp_otherdetails',array('empid'=>$row['empid']))->result_array();
													echo $bankaccount[0]['bankacctno']; ?>
												</td>
												
											</tr>
											<tr>
												<td>
													<span class="bold theme-font">Aadhar Card </span>
												</td>
												<td>
													 <?php $aadharcard=$this->db->get_where('emp_otherdetails',array('empid'=>$row['empid']))->result_array();
													echo $aadharcard[0]['aadharcard']; ?>
												</td>
												
											</tr>
											<tr>
												<td>
													<span class="bold theme-font">Pancard</span>
												</td>
												<td>
													 <?php $pancard=$this->db->get_where('emp_otherdetails',array('empid'=>$row['empid']))->result_array();
													echo $pancard[0]['pancard']; ?>
												</td>
												
											</tr>
											<tr>
												<td>
													<span class="bold theme-font">Passport</span>
												</td>
												<td>
													 <?php $passport=$this->db->get_where('emp_otherdetails',array('empid'=>$row['empid']))->result_array();
														echo $passport[0]['passport']; ?>
												</td>
												
											</tr>
											<tr>
												<td>
													<span class="bold theme-font">Driving license</span>
												</td>
												<td>
													 <?php $drivinglicense=$this->db->get_where('emp_otherdetails',array('empid'=>$row['empid']))->result_array();
											echo $drivinglicense[0]['drivinglicense']; ?>
												</td>
												
											</tr>
											<tr>
												<td>
													<span class="bold theme-font">Election Card </span>
												</td>
												<td>
													 <?php $electioncard=$this->db->get_where('emp_otherdetails',array('empid'=>$row['empid']))->result_array();
											echo $electioncard[0]['electioncard']; ?>
												</td>
												
											</tr>
											<tr>
												<td>
													<span class="bold theme-font">Ration Card</span>
												</td>
												<td>
													 <?php $rationcard=$this->db->get_where('emp_otherdetails',array('empid'=>$row['empid']))->result_array();
											echo $rationcard[0]['rationcard']; ?>
												</td>
												
											</tr>
											<tr>
												<td>
													<span class="bold theme-font">ESI Card</span>
												</td>
												<td>
													 <?php $esicard=$this->db->get_where('emp_otherdetails',array('empid'=>$row['empid']))->result_array();
														echo $esicard[0]['esicard']; ?>
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
					<!-- END PROFILE CONTENT -->
				</div>
			</div>
			<!-- END PROFILE -->
								<div class="form-actions">
									<a href= "<?php echo base_url().index_page().'hr/home/deactivate/'.$row['empid'];?>"><input class="buttom" id="button" type="button" name="button" value="Deactivate" style="width:20%"></a>
									<a href= "<?php echo base_url().index_page().'hr/home/edit_employees/'.$row['empid'];?>"><input class="buttom" id="button" type="button" name="button" value="Edit" style="width:20%"></a>
									<a href= "<?php echo base_url().index_page().'hr/home/employees';?>"><input class="buttom" id="button" type="button" name="button" value="Back" style="width:20%"></a>
									
								</div>	
		

			
		</div>
	</div>
	<?php } ?>
	<!-- END PAGE CONTENT -->
</div>

								
							
						</div>
					</div>
					<!-- END SAMPLE FORM PORTLET-->
					
				</div>
				
				</div>
			</div>
			
			
		<!-- END PAGE CONTAINER -->


<!-- BEGIN PRE-FOOTER -->
	
<!-- END PRE-FOOTER -->

<!-- BEGIN FOOTER -->
<div class="page-footer">
	<div class="container">
		 2015 &copy; adwitads. All Rights Reserved.
	</div>
</div>
<div class="scroll-to-top">
	<i class="icon-arrow-up"></i>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?php echo base_url(); ?>ui_assets/global/plugins/respond.min.js"></script>
<script src="<?php echo base_url(); ?>ui_assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="<?php echo base_url(); ?>ui_assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>ui_assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?php echo base_url(); ?>ui_assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>ui_assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>ui_assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>ui_assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>ui_assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>ui_assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>ui_assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="<?php echo base_url(); ?>ui_assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>ui_assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>ui_assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>ui_assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>ui_assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>ui_assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>ui_assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>ui_assets/admin/layout3/scripts/layout.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>ui_assets/admin/layout3/scripts/demo.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>ui_assets/global/scripts/datatable.js"></script>
<script src="<?php echo base_url(); ?>ui_assets/admin/pages/scripts/table-ajax.js"></script>
<script src="<?php echo base_url(); ?>ui_assets/admin/pages/scripts/todo.js" type="text/javascript"></script>
<script>
jQuery(document).ready(function() {   
   // initiate layout and plugins
   Metronic.init(); // init metronic core components
Layout.init(); // init current layout
Demo.init(); // init demo features
});
</script>
</body>
<!-- END BODY -->
</html>