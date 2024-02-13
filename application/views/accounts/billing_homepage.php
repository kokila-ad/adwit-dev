<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">

<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>Adwitads | Accounts Dashboard</title>
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

<!-- BEGIN HEADER -->
<?php
       $this->load->view("accounts/top_menu"); 
?>
<!-- END HEADER -->
	<!-- BEGIN PAGE CONTENT -->
	<div class="page-content">
		<div class="container">
			
			<!-- BEGIN PAGE CONTENT INNER -->
			<!-- BEGIN PROFILE -->
			 <div class="row margin-top-10">
				<div class="col-md-12">
					<!-- BEGIN PROFILE CONTENT -->
					<div class="profile-content">
						<div class="row">
							<div class="col-md-3">
								<!-- BEGIN PORTLET -->
								<div class="portlet light ">
									<div class="portlet-body text-center margin-bottom-25 ">
									<h4>To be Billed</h4>
								     <div class="btn-group btn-group-solid btn-group-lg ">
										
										<form action="<?php echo base_url().index_page().'accounts/home/groupbillinglist';?>" method="post">
										<input type="submit" name="billable" value="<?php echo count($billable);?>" class="btn btn-circle blue-chambray">	
										</form>
										
										
										<form method="post">
										<button name="update" class="btn blue-chambray btn-block" type="submit" value="Update">Update</button>
										</form>	 
										
									 </div>
									</div>
								</div>
								<!-- END PORTLET -->
							</div>
							
							<div class="col-md-3">
								<!-- BEGIN PORTLET -->
								<div class="portlet light ">
									<div class="portlet-body text-center margin-bottom-25 ">
									<h4>Invoice's Sent</h4>
								     <div class="btn-group btn-group-solid btn-group-lg ">
										<form action="<?php echo base_url().index_page().'accounts/home/pending_payments';?>" method="post">
										<input type="submit" name="payment_pending" value="<?php echo count($pending_payments);?>" class="btn btn-circle blue-chambray">	
										</form>
									</div>
									</div>
								</div>
								<!-- END PORTLET -->
							</div>
							
							<div class="col-md-3">
								<!-- BEGIN PORTLET -->
								<div class="portlet light ">
									<div class="portlet-body text-center margin-bottom-25 ">
									<h4>Payment Received</h4>
								     <div class="btn-group btn-group-solid btn-group-lg ">
										<form action="<?php echo base_url().index_page().'accounts/home/received_payments';?>" method="post">
										<input type="submit" name="payment_pending" value="<?php echo count($received_payments);?>" class="btn btn-circle blue-chambray">	
										</form>
									 </div>
									</div>
								</div>
								<!-- END PORTLET -->
							</div>
							
							<div class="col-md-3">
								<!-- BEGIN PORTLET -->
								<div class="portlet light ">
									<div class="portlet-body text-center margin-bottom-25 ">
									<h4>Billing History</h4>
								     <div class="btn-group btn-group-solid btn-group-lg ">
										
										<form action="<?php echo base_url().index_page().'accounts/home/bill_completed';?>" method="post">
										<input type="submit" name="payment_pending" value="<?php echo count($bill_completed);?>" class="btn btn-circle blue-chambray">	
										</form>
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
			
			<!-- BEGIN PROFILE -->
			 <div class="row margin-top-10">
				<div class="col-md-12">
					<!-- BEGIN PROFILE CONTENT -->
					<div class="profile-content">
						<div class="row">
							<div class="col-md-12">
								<!-- BEGIN PORTLET -->
								<div class="portlet light">
								   <div class="portlet-title tabbable-line">
										<div class="caption caption-md">
											<span class="caption-subject font-grey-gallery bold uppercase">Recent Activities</span>
										</div>
									</div>
									<div class="row portlet-body">
					    <div class=" col-md-5">
						<table class="table table-scrollable table-striped table-hover">
							<tbody>
							<tr>
								<td>No Recent Activities</td>
								 		  
							</tr>  
							
							</tbody>
					</table>           
					</div>
					</div>
					</div>
					</div>
					</div>
					</div>
					<!-- END PROFILE CONTENT -->
				</div>
			</div>
			<!-- END PROFILE -->
			
		
			
	</div>
	<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->

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
<script src="ui_assets/global/plugins/respond.min.js"></script>
<script src="ui_assets/global/plugins/excanvas.min.js"></script> 
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
<script type="text/javascript" src="<?php echo base_url(); ?>ui_assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>ui_assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>ui_assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>ui_assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>ui_assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>ui_assets/admin/layout3/scripts/layout.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>ui_assets/admin/layout3/scripts/demo.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>ui_assets/admin/pages/scripts/table-advanced.js"></script>
<script src="<?php echo base_url(); ?>ui_assets/admin/pages/scripts/table-ajax.js"></script>
<script src="<?php echo base_url(); ?>ui_assets/admin/pages/scripts/todo.js" type="text/javascript"></script>
<script>
jQuery(document).ready(function() {       
     Metronic.init(); // init metronic core components
     Layout.init(); // init current layout
     Demo.init(); // init demo features
     TableAdvanced.init();
	 TableAjax.init();
	 Todo.init(); // init todo page
});
</script>
</body>
<!-- END BODY -->
</html>

