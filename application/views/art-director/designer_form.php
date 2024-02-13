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
<link rel="stylesheet" type="text/css" href="../../../ui_assets/global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="../../../ui_assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>
<link rel="stylesheet" type="text/css" href="../../../ui_assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css"/>
<link rel="stylesheet" type="text/css" href="../../../ui_assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="../../../ui_assets/global/plugins/bootstrap-datepicker/css/datepicker.css"/>
<link rel="stylesheet" type="text/css" href="../../../ui_assets/admin/pages/css/todo.css"/>
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
<?php
       $this->load->view("art-director/top_menu"); 
?>
<!-- END HEADER -->


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
		<!-- BEGIN PAGE CONTENT INNER -->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN SAMPLE FORM PORTLET-->
					<div class="todo-sidebar">
						<div class="portlet light">
							<div class="portlet-title">
								<div class="caption" data-toggle="collapse" data-target=".todo-project-list-content">
									<span class="caption-subject font-green-sharp bold uppercase">DESIGNERS </span>
									<span class="caption-helper visible-sm-inline-block visible-xs-inline-block">click to view project list</span>
								</div>
								<div class="actions">
								</div>
							</div>
							<div class="portlet-body todo-project-list-content">
								<div class="todo-project-list">
									<ul class="nav nav-pills nav-stacked">
										<li   <?php  $active_designer = $this->db->query("SELECT * FROM `designers` WHERE is_active='1'")->result_array(); ?>>
											<a href="<?php echo base_url().index_page()."art-director/home/new_designer";?>"> Active <span id="lol" class="badge bg-blue"><?php echo count($active_designer); ?></span></a>
										</li>
										<li  <?php  $dactive_designer = $this->db->query("SELECT * FROM `designers` WHERE is_active='0'")->result_array(); ?>>
											<a href="<?php echo base_url().index_page()."art-director/home/deactive_designer";?>"> Inactive <span id="lol" class="badge bg-blue"><?php echo count($dactive_designer); ?></span></a>
										</li>
										<li class="active">
											<a href="<?php echo base_url().index_page()."art-director/home/add_designer";?>"> Add New </a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
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
							<form role="form" method="post" action="<?php echo base_url().index_page()."art-director/home/add_designer";?>">
								<div class="form-body">
									<div class="form-group">
										<label>Name</label>
										<div class="input-icon">
											<i class="fa fa-user"></i>
											<input type="text" class="form-control" placeholder="Enter Text" name="name" required/>
										</div>
									</div>
									
									<div class="form-group">
										<label>Email Address</label>
										<div class="input-group">
											<span class="input-group-addon">
											<i class="fa fa-envelope"></i>
											</span>
											<input type="text" class="form-control" name="email" placeholder="Email Address" required/>
										</div>
									</div>
									
									<div class="form-group">
										<label>Gender</label>
										<div class="radio-list">
											<label class="radio-inline">
											<input type="radio" name="gender" value="1" id="optionsRadios1" value="option1" required> Male </label>
											<label class="radio-inline">
											<input type="radio" name="gender" value="0" id="optionsRadios2" value="option2"> Female </label>
										</div>
									</div>
									
									<div class="form-group">
										<label>Mobile Number</label>
										<div class="input-icon">
											<i class="fa fa-phone"></i>
											<input type="text" name="mobile" class="form-control" placeholder="Enter Number"required/>
										</div>
									</div>
									
									<div class="form-group">
										<label>User Name</label>
										<div class="input-icon">
											<i class="fa fa-user"></i>
											<input type="text" class="form-control" name="uname"  placeholder="Enter Text" required/>
										</div>
									</div>
									
									<div class="form-group">
										<label for="exampleInputPassword1">Password</label>
										<div class="input-group">
											<input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Password" required/>
											<span class="input-group-addon">
											<i class="fa fa-user"></i>
											</span>
										</div>
									</div>
									
									<div class="form-group">
										<label>Shift Factor</label>
										<input type="text" class="form-control" name="shift_factor"  placeholder="Enter Text" required/>
									</div>
									
									<div class="form-group">
										<label>Team Lead</label>
										<select class="form-control" name="tlead" required/>
											<option required="required" value="">Select</option>
            <?php
			$type1 = $this->db->query("SELECT * FROM `team_lead`")->result_array();
		
				foreach($type1 as $type11)
				{
					echo '<option value="'.$type11['id'].'">'.$type11['first_name'].'</option>';	
						
				}
			?>
										</select>
									</div>
									
									<div class="form-group">
										<label>Loaction</label>
										<select class="form-control"  name="location" required/>
											<option required="required" value="">Select</option>
          <?php
			$type1 = $this->db->query("SELECT * FROM `location`")->result_array();
		
				foreach($type1 as $type11)
				{
					echo '<option value="'.$type11['id'].'">'.$type11['name'].'</option>';	
						
				}
			?>
										</select>
									</div>
								
               						<div class="form-group">
										<label>Action</label>
										<div class="radio-list">
											<label class="radio-inline">
											<input type="radio" name="active" value="1" id="optionsRadios4" value="option1" required/> Is Active </label>
											<label class="radio-inline">
											<input type="radio" name="active" value="0" id="optionsRadios5" value="option2"> Is Deleted </label>
										</div>
									</div>
								
								</div>
								<div class="form-actions">
									<button type="submit" class="btn blue">Submit</button>
									
								</div>
							</form>
						</div>
					</div>
					<!-- END SAMPLE FORM PORTLET-->
					
				</div>
				
				</div>
			</div>
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
<script type="text/javascript" src="../../../ui_assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js"></script>
<script type="text/javascript" src="../../../ui_assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
<script type="text/javascript" src="../../../ui_assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="../../../ui_assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../../../ui_assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="../../../ui_assets/admin/layout3/scripts/layout.js" type="text/javascript"></script>
<script src="../../../ui_assets/admin/layout3/scripts/demo.js" type="text/javascript"></script>
<script src="../../../ui_assets/global/scripts/datatable.js"></script>
<script src="../../../ui_assets/admin/pages/scripts/table-ajax.js"></script>
<script src="../../../ui_assets/admin/pages/scripts/todo.js" type="text/javascript"></script>
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