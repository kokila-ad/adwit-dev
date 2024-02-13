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
			<div class="row">
				<div class="col-md-12">
						<div class="portlet light">
							<div class="portlet-title">
								<span class="caption font-green-sharp bold uppercase">
										<?php echo $customer['name'];?> /
										<?php echo $publication_name[0]['name']; ?>
								</span>
							</div>				
						</div>
					</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
						<div class="portlet light">
							<div class="portlet-title">
							<form method="post">
								<span class="caption-subject font-green-sharp bold uppercase">Select Month</span>
								<?php if($date1 != $latest_date1){ ?>
								<button name="month" class="btn btn-circle blue" type="submit" style="width:15%" value="<?php echo $date1;?>"><?php echo date('M-Y', strtotime($date1));?></button>
								<?php } ?>
								<?php if($pdate != $latest_date1){ ?>
								<button name="month" class="btn btn-circle blue" type="submit" style="width:15%" value="<?php echo $pdate;?>"><?php echo date('M-Y', strtotime($pdate));?></button>
								<?php } ?>
							</form>	 
							</div>				
						</div>
					</div>
			</div>
			<div class="row">
				<div class="col-md-12">
						<div class="portlet light">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-cogs font-green-sharp"></i>
									<span class="caption-subject font-green-sharp bold uppercase">Invoice's Raised</span>
								</div>
									<table class="table table-striped table-bordered table-hover" id="sample_1" name="example">
							<thead>
							
								<tr>
									<th>
										Invoice Number
									</th>
									<th>
										Invoice Period
									</th>
									
									<th>
										 Total Billing Amount($)
									</th>
									<th>
										 Total Due
									</th>
									<th>
										 Status
									</th>
									<th>
										 View Invoice
									</th>
									<th>
										 View Orders
									</th>
								</tr>
							
							</thead>
							<tbody name="testTable" id="testTable">
							<?php 
								$date1;
								foreach($billing as $row)
								{
							?>
							<tr>
								<td>
									<?php $arg1 = $row['invoice_no'];
										  $arg2 = $row['invoice_no1'];	
										  $inv_number = $arg1.'/'. $arg2;
									echo $inv_number;?>
								</td>
								<td>
									
									 <?php  echo $row['date'];
											$date1 = $row['date'];
											?>
								</td>
								
								<td>
									<?php echo $row['total_usd'];?>
								</td>
								<td>
									<?php echo $row['total_due'];?>
								</td>
								<td>
									<?php $status=$this->db->get_where('billing_status',array('id'=>$row['billing_status']))->result_array();
										echo $status[0]['status'] ?>
								</td>
								<td>	
									<a href="<?php echo base_url().index_page().'accounts/home/view_invoice'.'/'.$publication_name[0]['id'].'/'.$date1;?>" target="_blank">View</a>
								</td>
								<td>	
									<a href="<?php echo base_url().index_page().'accounts/home/view_orders'.'/'.$customer['id'].'/'.$publication_name[0]['id'].'/'.$row['id'];?>" target="_blank">View</a>
								</td>
							</tr>
							<?php } ?>
							
							</tbody>
							</table>
						</div>	
							</div>				
						</div>
					</div>
			</div>
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



