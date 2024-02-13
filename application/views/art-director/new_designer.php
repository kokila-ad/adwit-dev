<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>Metronic | Advanced Datatables</title>
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
<div class="page-container">

	<!-- BEGIN PAGE CONTENT -->
	<div class="page-content">
		<div class="container">
			<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			
			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			
			<!-- BEGIN PAGE CONTENT INNER -->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					
					<!-- BEGIN TODO SIDEBAR -->
					<div class="col-md-3">
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
										<li <?php if(!isset($value)) { ?> class="active" <?php } $active_designer = $this->db->query("SELECT * FROM `designers` WHERE is_active='1'")->result_array(); ?>>
											<a href="<?php echo base_url().index_page()."art-director/home/new_designer";?>"> Active <span id="lol" class="badge bg-blue"><?php echo count($active_designer); ?></span></a>
										</li>
										<li <?php if(isset($value)) { ?> class="active" <?php } $dactive_designer = $this->db->query("SELECT * FROM `designers` WHERE is_active='0'")->result_array(); ?>>
											<a href="<?php echo base_url().index_page()."art-director/home/deactive_designer";?>"> Inactive <span id="lol" class="badge bg-blue"><?php echo count($dactive_designer); ?></span></a>
										</li>
										<li>
											<a href="<?php echo base_url().index_page()."art-director/home/add_designer";?>"> Add New </a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<!-- END TODO SIDEBAR -->
					
					<div class="col-md-9">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-green-sharp bold uppercase">Designer Table</span>
							</div>
							<div class="tools">
							</div>
						</div>
						<div class="portlet-body">
							<table class="table table-striped table-bordered table-hover" id="sample_1">
							<thead>
							   <tr>
									<th>
										 #
									</th>
									<th>
										Name
									</th>
									<th>
										Code
									</th>
									<th>
										 Location
									</th>
									<th>
									     Team
								    </th>
									<th>
										 Profile
									</th>
								</tr>
							</thead>
														<tbody>
<?php
$i=1;
foreach($designer as $row)
{	
	 $location = $this->db->get_where('location',array('id' => $row['Join_location']))->result_array(); 
	$team_lead = $this->db->get_where('team_lead',array('id' => $row['design_team_lead']))->result_array();
	?>    									
											<tr class="odd gradeX">
											    <td><?php echo $i; $i++;       ?></td>
												<td><?php echo $row['name']; ?></td>
												<td><?php echo $row['username']; ?></td>
												<td><?php if(!empty($location[0]['name'])){ echo $location[0]['name'];} ?></td>
												<td></td>
												<td><a href="<?php echo base_url().index_page()."art-director/home/new_designer";?>/<?php echo $row['id']; ?>" class="btn btn-xs blue">View</td>
											</tr>
<?php }?>											
										</tbody>
							</table>
						</div>
					</div>
					</div>
					
					<!-- END EXAMPLE TABLE PORTLET-->
					
				</div>
			</div>
			<!-- END PAGE CONTENT INNER -->
		</div>
	</div>
	<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->

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
<script type="text/javascript" src="../../../ui_assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
<script type="text/javascript" src="../../../ui_assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js"></script>
<script type="text/javascript" src="../../../ui_assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
<script type="text/javascript" src="../../../ui_assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../../../ui_assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="../../../ui_assets/admin/layout3/scripts/layout.js" type="text/javascript"></script>
<script src="../../../ui_assets/admin/layout3/scripts/demo.js" type="text/javascript"></script>
<script src="../../../ui_assets/admin/pages/scripts/table-advanced.js"></script>
<script src="../../../ui_assets/admin/pages/scripts/table-ajax.js"></script>
<script src="../../../ui_assets/admin/pages/scripts/todo.js" type="text/javascript"></script>
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