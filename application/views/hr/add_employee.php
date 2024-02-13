<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
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
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN THEME STYLES -->
<link href="<?php echo base_url(); ?>ui_assets/global/css/components-rounded.css" id="style_components" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>ui_assets/global/css/plugins.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>ui_assets/admin/layout3/css/layout.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>ui_assets/admin/layout3/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color">
<link href="<?php echo base_url(); ?>ui_assets/admin/layout3/css/custom.css" rel="stylesheet" type="text/css">
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-menu-fixed" class to set the mega menu fixed  -->
<!-- DOC: Apply "page-header-top-fixed" class to set the top menu fixed  -->
<body>
<!-- BEGIN HEADER -->
<?php
       $this->load->view("hr/top_menu"); 
?>

<!-- END HEADER -->



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
		<!-- BEGIN PAGE CONTENT INNER -->
			<div class="row">
				<div class="col-md-3">
					<!-- BEGIN SAMPLE FORM PORTLET-->
					<div class="todo-sidebar">
						<div class="portlet light">
							<div class="portlet-title">
								<div class="caption" data-toggle="collapse" data-target=".todo-project-list-content">
									<span class="caption-subject font-green-sharp bold uppercase">EMPLOYEES </span>
									<span class="caption-helper visible-sm-inline-block visible-xs-inline-block">click to view project list</span>
								</div>
								<div class="actions">
								</div>
							</div>
							<div class="portlet-body todo-project-list-content">
								<div class="todo-project-list">
									<ul class="nav nav-pills nav-stacked">
										<li  <?php  $active_employees = $this->db->query("SELECT * FROM `employees` WHERE isactive='1'")->result_array(); ?>>
											<a href="<?php echo base_url().index_page().'hr/home/employees/1';?>"> Active <span id="lol" class="badge bg-blue"><?php echo count($active_employees); ?></span></a>
										</li>
										<li <?php  $deactive_employees = $this->db->query("SELECT * FROM `employees` WHERE isactive='0'")->result_array(); ?>>
											<a href="<?php echo base_url().index_page().'hr/home/employees/0';?>"> Inactive <span id="lol" class="badge bg-blue"><?php echo count($deactive_employees); ?></span></a>
										</li>
										<li class="active" >
											<a href="<?php echo base_url().index_page()."hr/home/add_employee";?>"> Add New </a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					</div>
					<div class="col-md-9">
					 <div class="todo-content">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cogs font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold uppercase">Form</span>
							</div>
							<?php if(!empty($_POST['name']))
echo "<b style='background-color:pink;'>Submitted Successfully!</b>";
 ?>
							<div class="tools">
								<a href="javascript:;" class="collapse">
								</a>
								<a href="#portlet-config" data-toggle="modal" class="config">
								</a>
								<a href="javascript:;" class="reload">
								</a>
								<a href="javascript:;" class="remove">
								</a>
							</div>
						</div>
						<div class="portlet-body form">
							<form role="form" method="post">
								<div class="form-body">
									<div class="form-group">
										<label>Name</label>
										<div class="input-icon">
											<i class="fa fa-user"></i>
											<input type="text" class="form-control" placeholder="Enter Text" name="emp_name" required/>
										</div>
									</div>
									
									
									<div class="form-group">
										<label>Entity</label>
										<select class="form-control" name="entity" required/>
											<option required="required" value="">Select</option>
											<?php
											$entity=$this->db->get('entity')->result_array();
											foreach ($entity as $row)
											{ ?>
											<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
											<?php	} ?>
											
											
            
										</select>
									</div>
										
									<div class="form-group">
										<label>Branch</label>
										<select class="form-control"  name="branch" required/>
											<option required="required" value="">Select</option>
											  <?php
													$branch=$this->db->get('branch')->result_array();
													foreach ($branch as $row)
													{ ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
													<?php	} ?>
										</select>
									</div>
									
									<div class="form-group">
										<label>Department</label>
										<select class="form-control"  name="department" required/>
											<option required="required" value="">Select</option>
											<?php
											$department=$this->db->get('department')->result_array();
											foreach ($department as $row)
											{ ?>
											<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
											<?php	} ?>
										</select>
									</div>
									
									<div class="form-group">
										<label>Designation</label>
										<select class="form-control"  name="designation" required/>
											<option required="required" value="">Select</option>
											<?php
												$designation=$this->db->get('designation')->result_array();
												foreach ($designation as $row)
												{ ?>
												<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php	} ?>
										</select>
									</div>
								</div>
								
								
								<div id="ad-form-s4"> 
									<button type="submit" class="btn blue" name="submit" type="submit">Submit</button>
									<a href= "<?php echo base_url().index_page().'hr/home/employees';?>"><button type="submit" class="btn blue" name="submit" type="submit">Cancel</button>
									</a>
									</div>
							</form>
						</div>
					</div>
					<!-- END SAMPLE FORM PORTLET-->
					
				</div>
				
				</div>
			</div>
			</div>
			
 
	</div>
	</div>
	
     
          <script src="theme001/vendors/jquery-1.9.1.js"></script>
        <script src="theme001/bootstrap/js/bootstrap.min.js"></script>
        <script src="theme001/vendors/datatables/js/jquery.dataTables.min.js"></script>
        <script src="theme001/assets/scripts.js"></script>
        <script src="theme001/assets/DT_bootstrap.js"></script>
        <script>
        $(function() {
        });
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

<!-- BEGIN JAVASCRIPTS (Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="ui_assets/global/plugins/respond.min.js"></script>
<script src="ui_assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="ui_assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="ui_assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="ui_assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
<script src="ui_assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="ui_assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="ui_assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="ui_assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="ui_assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="ui_assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="ui_assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
<script src="ui_assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
<script src="ui_assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
<script src="ui_assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
<script src="ui_assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
<script src="ui_assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
<script src="ui_assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>
<!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support -->
<script src="ui_assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="ui_assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="ui_assets/admin/layout3/scripts/layout.js" type="text/javascript"></script>
<script src="ui_assets/admin/layout3/scripts/demo.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {    
   Metronic.init(); // init metronic core componets
   Layout.init(); // init layout
   Demo.init(); // init demo(theme settings page)
});
</script>


