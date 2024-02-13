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
			<div class="row margin-top-10">
				<div class="col-md-12">
	<form id="emp_details" name="emp_details" method="post" enctype="multipart/form-data"> 
					<!-- BEGIN PROFILE CONTENT -->
					<div class="profile-content">
					<!--	<div class="row">-->
							<div class="col-md-6">
								<!-- BEGIN PORTLET -->
								<div class="portlet light ">
									<div class="portlet-title">
										<div class="caption caption-md">
											<i class="icon-bar-chart theme-font hide"></i>
											<span class="caption-subject font-blue-madison bold uppercase">Personnal Details</span>
											
										</div>
										
									</div>
									<div class="portlet-body">
									<div class="form-body">
									<div class="form-group">
										<div class="input-icon">
											
										<p>
											
											<label>Name:</label>
											<?php echo $details_emp[0]['empname'];?>
											</p>																			
											<label>Date of Birth</label>
											<i class="fa fa-user"></i>
											<input type="text" class="form-control" name="empdob" value="<?php echo $details_emp[0]['empdob'];?>" placeholder="Enter Text">
											<label>Father Name</label>
											<i class="fa fa-user"></i>
											<input type="text" class="form-control" name="fathername" value="<?php echo $details_emp[0]['fathername'];?>" placeholder="Enter Text">									
											<p><label>Gender</label>
											<input type="text" class="form-control" name="gender" value="<?php echo $details_emp[0]['gender'] ;?>" placeholder="Enter Text">									
											</p>
											<label>Nationality</label>
											<i class="fa fa-user"></i>
											<input type="text" class="form-control" name="nationality" value="<?php echo $details_emp[0]['nationality'];?>" placeholder="Enter Text">										
											<label>Marital Status</label>
											<i class="fa fa-user"></i>
											<input type="text" class="form-control" name="marital_status" name="empdob" value="<?php echo $details_emp[0]['marital_status']; ?>"  placeholder="Enter Text">
											<label>Contact Number</label>
											<i class="fa fa-phone"></i>
											<input type="text" class="form-control" name="contact_no" value="<?php echo $details_emp[0]['contact_no'];?>" placeholder="Enter Number">
											<label>Present Address</label>
											<i class="fa fa-user"></i>
											<input type="text" class="form-control" name="present_addr" value="<?php echo $details_emp[0]['present_addr'];?>" placeholder="Enter Text">
											<label>Premanent Address</label>
											<i class="fa fa-user"></i>
											<input type="text" class="form-control" name="permanent_addr" value="<?php echo $details_emp[0]['permanent_addr'];?>" placeholder="Enter Text">
											<label>Personnal Email_id</label>
											<i class="fa fa-envelope"></i>
											<input type="text" class="form-control" name="personalemail_id" value="<?php echo $details_emp[0]['personalemail_id'];?>" placeholder="Email Address">
											<label>Spouse Name </label>
											<i class="fa fa-user"></i>
											<input type="text" class="form-control" name="spousename" value="<?php echo $details_emp[0]['spousename'];?>" placeholder="Enter Text">
											<label>Children Name</label>
											<i class="fa fa-user"></i>
											<input type="text" class="form-control" name="childrenname" value="<?php echo $details_emp[0]['childrenname'];?>" placeholder="Enter Text">
											<label>Educational Details</label>
											<i class="fa fa-user"></i>
											<input type="text" class="form-control" name="educational_details" value="<?php echo $details_emp[0]['educational_details'];?>" placeholder="Enter Text">
											<label>Language Proficiency</label>
											<i class="fa fa-user"></i>
											<input type="text" class="form-control" name="language_proficiency" value="<?php echo $details_emp[0]['language_proficiency'];?>" placeholder="Enter Text">
											<p><label>Designation:</label>
											<?php $designation=$this->db->get_where('designation',array('id'=>$details_emp[0]['designation']))->result_array();
											echo $designation[0]['name'] ?></p>
											<p><label>Date of Joining:</label>
											<?php echo $details_emp[0]['doj'];?>
											</p>
											<p><label>Branch</label>
											<?php $branch=$this->db->get_where('branch',array('id'=>$details_emp[0]['branch']))->result_array();  
											echo $branch[0]['name'];?>
											</p>
											<label>Emp. Is Active:</label>
											<?php if($details_emp[0]['isactive']=='1') echo "Yes"; else echo "No"; ?>
											<p><label>Date of Resignation : </label>
											<?php echo $details_emp[0]['dor'];?>
											</p>										
									</div>
								</div>
								<!-- END PORTLET -->
							</div>
						</div>
					</div>
					<!-- END PROFILE CONTENT -->
				</div>
				<div class="col-md-6">
				<div class="portlet light ">
				<div class="portlet-title">
				<div class="form-body">
				<div class="form-group">
				<div class="input-icon">
				
					<div class="caption caption-md">
					<i class="icon-bar-chart theme-font hide"></i>
					<span class="caption-subject font-blue-madison bold uppercase">Previous Employment Details</span>
					</div>
					</div>
				</div>
				</div>
				</div>
					<label>Organisation</label>
					<input type="text" class="form-control" name="organisation" value="<?php echo $emp_experience[0]['organisation'];?>" placeholder="Enter Text">
					<label>Role</label>
					<input type="text" class="form-control" name="role" value="<?php echo $emp_experience[0]['role'];?>" placeholder="Enter Text">
					<label>From Date </label>
					<input type="text" class="form-control" name="from_dt" value="<?php echo $emp_experience[0]['from_dt'];?>" placeholder="Enter Date">
					<label>To Date</label>
					<input type="text" class="form-control" name="to_dt" value="<?php echo $emp_experience[0]['to_dt'];?>" placeholder="Enter Date">
											
				</div>
				</div>
				
				
				
			
			
			
		
			<!--</div> 	-->				
							
						</div>
	</form>	

<div class="col-md-6">
<div class="profile-content">
				<div class="portlet light ">
				<div class="portlet-title">
				<div class="form-body">
				<div class="form-group">
				<div class="input-icon">
				
										<div class="caption caption-md">
										<i class="icon-bar-chart theme-font hide"></i>
										<span class="caption-subject font-blue-madison bold uppercase">Other Details</span>
										</div>
										</div>
										</div>
										</div>
										</div>
										<label>Bank Account</label>
										<form name="bankacctno" action="<?php echo base_url();?>index.php/hr/home/upload01/passbook_path/<?php echo $details_emp[0]['empid']; ?>" method="post" enctype="multipart/form-data">
											<input type="file" name="userfile" id="filetoupload" onchange="bankacctno.submit();">
											<?php if($emp_otherdetails[0]['passbook_path']!="NA"){ 
												echo $emp_otherdetails[0]['passbook_path'];
												}
											?>
										</form>	
										
										
										<label>Aadhar Card</label>
										<form name="aadharcard" action="<?php echo base_url();?>index.php/hr/home/upload01/aadharcard_path/<?php echo $details_emp[0]['empid']; ?>" method="post" enctype="multipart/form-data">
											<input type="file" name="userfile" id="filetoupload" onchange="aadharcard.submit();">
											<?php if($emp_otherdetails[0]['aadharcard_path']!="NA"){ 
												echo $emp_otherdetails[0]['aadharcard_path'];
												}
											?>
										</form>	
											
										<label>Pancard</label>
										<form name="pancard" action="<?php echo base_url();?>index.php/hr/home/upload01/pancard_path/<?php echo $details_emp[0]['empid']; ?>" method="post" enctype="multipart/form-data">
											<input type="file" name="userfile" id="filetoupload" onchange="pancard.submit();">
											<?php if($emp_otherdetails[0]['pancard_path']!="NA"){ 
												echo $emp_otherdetails[0]['pancard_path'];
												}
											?>
										</form>		
										<label>Passport</label>
										<form name="passport" action="<?php echo base_url();?>index.php/hr/home/upload01/passport_path/<?php echo $details_emp[0]['empid']; ?>" method="post" enctype="multipart/form-data">
											<input type="file" name="userfile" id="filetoupload" onchange="passport.submit();">
											<?php if($emp_otherdetails[0]['passport_path']!="NA"){ 
												echo $emp_otherdetails[0]['passport_path'];
												}
											?>
										</form>		
										<label>Driving license</label>
										<form name="drivinglicense" action="<?php echo base_url();?>index.php/hr/home/upload01/drivinglicense_path/<?php echo $details_emp[0]['empid']; ?>" method="post" enctype="multipart/form-data">
											<input type="file" name="userfile" id="filetoupload" onchange="passport.submit();">
											<?php if($emp_otherdetails[0]['drivinglicense_path']!="NA"){ 
												echo $emp_otherdetails[0]['drivinglicense_path'];
												}
											?>
										</form>			
										<label>Election Card</label>
										<form name="electioncard" action="<?php echo base_url();?>index.php/hr/home/upload01/electioncard_path/<?php echo $details_emp[0]['empid']; ?>" method="post" enctype="multipart/form-data">
											<input type="file" name="userfile" id="filetoupload" onchange="passport.submit();">
											<?php if($emp_otherdetails[0]['electioncard_path']!="NA"){ 
												echo $emp_otherdetails[0]['electioncard_path'];
												}
											?>
										</form>			
										<label>Ration Card</label>
										<form name="rationcard" action="<?php echo base_url();?>index.php/hr/home/upload01/rationcard_path/<?php echo $details_emp[0]['empid']; ?>" method="post" enctype="multipart/form-data">
											<input type="file" name="userfile" id="filetoupload" onchange="passport.submit();">
											<?php if($emp_otherdetails[0]['rationcard_path']!="NA"){ 
												echo $emp_otherdetails[0]['rationcard_path'];
												}
											?>
										</form>			
										<label>ESI Card</label>
										<form name="passport" action="<?php echo base_url();?>index.php/hr/home/upload01/passport_path/<?php echo $details_emp[0]['empid']; ?>" method="post" enctype="multipart/form-data">
											<input type="file" name="userfile" id="filetoupload" onchange="passport.submit();">
											<?php if($emp_otherdetails[0]['passport_path']!="NA"){ 
												echo $emp_otherdetails[0]['passport_path'];
												}
											?>
										</form>			
												<!-- Employee Other Details end-->
				
				</div>
				</div>
						<div id="ad-form-s4">   
									<div class="form-actions">
									<input class="buttom" name="update" type="submit" value="Update" style="width:20%" form="emp_details" onclick="emp_details.submit();"/>
									<a href= "<?php echo base_url().index_page().'hr/home/employees';?>"><input class="buttom" id="button" type="button" name="button" value="Back" style="width:20%"></a>
									</div>
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