      <!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css">
<link href="<?php  echo base_url();  ?>/ui_assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="<?php  echo base_url();  ?>/ui_assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css">
<link href="<?php  echo base_url();  ?>/ui_assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="<?php  echo base_url();  ?>/ui_assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css">
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="<?php  echo base_url();  ?>/ui_assets/global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?php  echo base_url();  ?>/ui_assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php  echo base_url();  ?>/ui_assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php  echo base_url();  ?>/ui_assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN THEME STYLES -->
<link href="<?php  echo base_url();  ?>/ui_assets/global/css/components-rounded.css" id="style_components" rel="stylesheet" type="text/css">
<link href="<?php  echo base_url();  ?>/ui_assets/global/css/plugins.css" rel="stylesheet" type="text/css">
<link href="<?php  echo base_url();  ?>/ui_assets/admin/layout3/css/layout.css" rel="stylesheet" type="text/css">
<link href="<?php  echo base_url();  ?>/ui_assets/admin/layout3/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color">
<link href="<?php  echo base_url();  ?>/ui_assets/admin/layout3/css/custom.css" rel="stylesheet" type="text/css">
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
<title>Team Lead | Adwitads</title>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-menu-fixed" class to set the mega menu fixed  -->
<!-- DOC: Apply "page-header-top-fixed" class to set the top menu fixed  -->
<script>
function goBack() {
    window.history.back();
}
</script>

<body>
<!-- BEGIN HEADER -->
<?php
       $this->load->view("team-lead/top_menu"); 
?>
<!-- BEGIN PAGE CONTAINER -->
	<!-- END PAGE CONTENT -->
	<div class="page-container">
	<!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
	<div class="container">
	
	<div class="row">
        <div class="col-lg-12">
        <div class="navbar navbar-default" role="navigation">
								<!-- Brand and toggle get grouped for better mobile display -->
								<div class="navbar-header">
									<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
									<span class="sr-only">
									Toggle navigation </span>
									<span class="icon-bar">
									</span>
									<span class="icon-bar">
									</span>
									<span class="icon-bar">
									</span>
									</button>
									<?php if(isset($form)) {  $type = $this->db->get_where('help_desk',array('active'=>'1','id'=>$form))->result_array(); ?>
									<a class="navbar-brand" href="javascript:;">
									<?php echo $type[0]['name']; } ?> </a>
								</div>
								<!-- Collect the nav links, forms, and other content for toggling -->
								
								<div class="collapse navbar-collapse navbar-ex1-collapse">
								
								<form class="navbar-form navbar-left"  name="form" method="post" action="<?php echo base_url().index_page().'team-lead/home/cshift_search'; ?>">
										<div class="form-group">
											<input type="text" class="form-control" placeholder="Search"  name="id" autocomplete="off" required/>
										</div>
										<button type="submit" class="btn blue" name="search">Search</button>
									</form>
								
									<ul class="nav navbar-nav navbar-right">
										<li class="dropdown">
											<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
											Select Group &nbsp;<i class="fa fa-angle-down"></i>
											</a>
											<ul class="dropdown-menu">
											<?php 
											$types = $this->db->get_where('help_desk',array('active'=>'1'))->result_array();
											foreach($types as $type)
				                            { ?>
												<li>
													<a href="<?php echo base_url().index_page().'team-lead/home/design_check/';?><?php echo $type['id']; ?>">
													<?php echo $type['name']; ?> </a>
												</li>
										 <?php } ?>
											</ul>
										</li>
									</ul>
								</div>
	                     </div>
	               </div>
        </div>
	<?php echo '<h5 style="color:#900;">'.$this->session->flashdata('message').'</h5>'; if(isset($form)) { ?>
	 <div class="row">
        <div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-green-sharp bold uppercase">Design Quality Check</span>
							</div>
							<div class="tools">
							</div>
						</div>
						<div class="portlet-body">
						  <table class="table table-striped table-bordered table-hover" id="sample_6">
							<thead>
							<tr>
								<th>Date</th>
								<th>T</th>
								<th>Adwit Id</th>
								<th>Job Name</th>
								<th>Publication</th>
							<?php if($form=='5')echo '<th style="vertical-align: middle;">Design Team</th>'; ?>
								 <th>C</th>
								<th>Status</th>
                           </tr>  
							</thead>
							<tbody>
						<?php foreach($orders_inproduction as $row)	
						{
						$cat_result = $this->db->query("SELECT * FROM `cat_result` WHERE `order_no`='".$row['id']."' AND `pro_status` ='2'; ")->result_array();
		              foreach($cat_result as $row1)
		               {
						$order_type = 	$this->db->get_where('orders_type',array('id' => $row['order_type_id']))->result_array();
						$publication = $this->db->query("SELECT * FROM `publications` WHERE id='".$row['publication_id']."'")->result_array();
                        $cat_result = $this->db->query("SELECT * FROM `cat_result` WHERE `order_no`='".$row['id']."'")->result_array();						
                        $status = 	$this->db->get_where('production_status',array('id' => $cat_result[0]['pro_status']))->result_array();				
                        $dteam = 	$this->db->get_where('publications',array('id' => $row['publication_id']))->result_array();	 
                         	 		
						 ?>
							<tr>
								<td><?php $date = strtotime($row['created_on']); echo date('d-M', $date); ?></td>
								<td title="<?php echo $order_type[0]['name']; ?>"><span class="badge bg-blue"><?php if($order_type[0]['id']=='1') {echo "W"; } if($order_type[0]['id']=='2') { echo "P"; } if($order_type[0]['id']=='3') { echo "P&W";}?></span></td>
								<td><a href="<?php echo base_url().index_page().'team-lead/home/orderview/';?><?php echo $row['help_desk'] ?>/<?php echo $row['id']; ?>"><?php echo $row['id']; ?></a></td>
								<td><?php echo $row['job_no']; ?></td>
								<td><?php echo $publication[0]['name'];?></td>
								<?php if($form=='5' && $dteam[0]['design_team_id']=='4'){echo "<td>D6</td>";}elseif($form=='5' && $dteam[0]['design_team_id']=='5'){ echo "<td>D7</td>"; } ?>
								<td <?php if($row['question']=='1') { echo 'class="danger"'; } if($row['question']=='2') { echo 'class="success"'; } ?>><?php echo $cat_result[0]['category']; ?></td>
								<td><?php if(isset($status[0]['name'])) { echo '<span class="label label-sm label-success">'.$status[0]['name'].' </span>'; } else{ echo"None"; } ?></td>
							</tr>
						<?php } } ?>	
							</tbody>
						</table>
						</div>
					</div>
				</div>
        </div>
	<!--<div class="row">	
	 <div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-green-sharp bold uppercase">In Production</span>
							</div>
							<div class="tools">
							</div>
						</div>
						<div class="portlet-body">
						  <table class="table table-striped table-bordered table-hover" id="sample_1">
							<thead>
							<tr>
								<th>Date</th>
								<th>T</th>
								<th>Adwit Id</th>
								<th>Job Name</th>
								<!--<?php if($form=='5')echo '<th style="vertical-align: middle;">D</th>'; ?>-->
								<!--<th>Publication</th>
								 <th>C</th>
								<th>Status</th>
                           </tr>  
							</thead>
							<tbody>
						<?php foreach($orders_inproduction as $row)	
						{
						$cat_result = $this->db->query("SELECT * FROM `cat_result` WHERE `order_no`='".$row['id']."' AND `pro_status` !='2'; ")->result_array();
		              foreach($cat_result as $row1)
		               {
						$order_type = 	$this->db->get_where('orders_type',array('id' => $row['order_type_id']))->result_array();
						$publication = $this->db->query("SELECT * FROM `publications` WHERE id='".$row['publication_id']."'")->result_array();
                        $cat_result = $this->db->query("SELECT * FROM `cat_result` WHERE `order_no`='".$row['id']."'")->result_array();						
                        $status = 	$this->db->get_where('production_status',array('id' => $cat_result[0]['pro_status']))->result_array();		
                        $dteam = 	$this->db->get_where('publications',array('id' => $row['publication_id']))->result_array();						
						 ?>
							<tr>
								<td><?php $date = strtotime($row['created_on']); echo date('d-M', $date); ?></td>
								<td title="<?php echo $order_type[0]['name']; ?>"><span class="badge bg-blue"><?php if($order_type[0]['id']=='1') {echo "W"; } if($order_type[0]['id']=='2') { echo "P"; } if($order_type[0]['id']=='3') { echo "P&W";}?></span></td>
								<td><a href="<?php echo base_url().index_page().'team-lead/home/orderview/';?><?php echo $row['help_desk'] ?>/<?php echo $row['id']; ?>"><?php echo $row['id']; ?></a></td>
								<td><?php echo $row['job_no']; ?></td>
								<!--<?php if($form=='5' && $dteam[0]['design_team_id']=='4'){echo "<td>D6</td>";}elseif($form=='5' && $dteam[0]['design_team_id']=='5'){ echo "<td>D7</td>"; } ?>-->
								<!--<td><?php echo $publication[0]['name'];?></td>
								<td <?php if($row['question']=='1') { echo 'class="danger"'; } if($row['question']=='2') { echo 'class="success"'; } ?>><?php echo $cat_result[0]['category']; ?></td>
								<td><?php if(isset($status[0]['name'])) { echo '<span class="label label-sm label-success">'.$status[0]['name'].' </span>'; } else{ echo"None"; } ?></td>
							</tr>
						<?php } } ?>	
							</tbody>
						</table>
						</div>
					</div>
				</div>
        </div>-->
	<?php } ?>	
</div>
</div>
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
<script src="<?php  echo base_url();  ?>/ui_assets/global/plugins/respond.min.js"></script>
<script src="<?php  echo base_url();  ?>/ui_assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="<?php  echo base_url();  ?>/ui_assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php  echo base_url();  ?>/ui_assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?php  echo base_url();  ?>/ui_assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
<script src="<?php  echo base_url();  ?>/ui_assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php  echo base_url();  ?>/ui_assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php  echo base_url();  ?>/ui_assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php  echo base_url();  ?>/ui_assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php  echo base_url();  ?>/ui_assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?php  echo base_url();  ?>/ui_assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="<?php  echo base_url();  ?>/ui_assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?php  echo base_url();  ?>/ui_assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php  echo base_url();  ?>/ui_assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
<script type="text/javascript" src="<?php  echo base_url();  ?>/ui_assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js"></script>
<script type="text/javascript" src="<?php  echo base_url();  ?>/ui_assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
<script type="text/javascript" src="<?php  echo base_url();  ?>/ui_assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php  echo base_url();  ?>/ui_assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php  echo base_url();  ?>/ui_assets/admin/layout3/scripts/layout.js" type="text/javascript"></script>
<script src="<?php  echo base_url();  ?>/ui_assets/admin/layout3/scripts/demo.js" type="text/javascript"></script>
<script src="<?php  echo base_url();  ?>/ui_assets/admin/pages/scripts/table-advanced.js"></script>
<script>
jQuery(document).ready(function() {       
   Metronic.init(); // init metronic core components
Layout.init(); // init current layout
Demo.init(); // init demo features
   TableAdvanced.init();
});
</script>
</body>
<!-- END BODY -->
</html>


<!--- OLD File -->