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
<link rel="shortcut icon" href="favicon.ico"/>
<script>
function delete_designer(id,d_id) {
var id = id
var d_id = d_id
//alert(id);
//alert(d_id);

  $.ajax({
    url: "<?php echo base_url().index_page().'art-director/home/delete';?>",
     data: "id="+id+"&d_id="+d_id,
    type: "POST"
    });
	window.location = "<?php echo base_url().index_page().'art-director/home/teams';?>";
}
</script>
<script>
function delete_tlead(id,t_id) {
var id = id
var t_id = t_id
//alert(id);
//alert(t_id);

  $.ajax({
    url: "<?php echo base_url().index_page().'art-director/home/delete';?>",
     data: "id="+id+"&t_id="+t_id,
    type: "POST"
    });
	window.location = "<?php echo base_url().index_page().'art-director/home/teams';?>";
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
						<?php $teams = $this->db->query("SELECT * FROM `help_desk` WHERE active='1'")->result_array(); 
						foreach($teams as $row) {
						
						?>
						    <div class="col-md-4" <?php  if($row['id']=="10") { ?>  Hidden <?php } ?>>
								<!-- BEGIN PORTLET -->
								<div class="portlet light ">
									<div class="portlet-title">
										<div class="caption caption-md">
											<i class="icon-bar-chart theme-font hide"></i>
											<span class="caption-subject font-blue-madison bold uppercase"><?php echo $row['d_name']; ?> - <?php echo $row['name']; ?></span>
											<span class="caption-helper hide">weekly stats...</span>
										</div>
										<div class="tools">
										  <button class="btn grey btn-xs" data-toggle="modal" href="#responsive<?php echo $row['id']; ?>">Add </button>
										 <!-- <button class="btn red-pink btn-xs font-mx" data-toggle="modal" href="#responsive_<?php echo $row['id']; ?>">Remove </button>-->
								        </div>
								         <div id="responsive<?php echo $row['id']; ?>" class="modal fade" tabindex="-1" aria-hidden="true">
										 
							             	<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Add to <?php echo $row['d_name'];?></h4>
										</div>
										<div class="modal-body">
										<form method="POST" action="<?php echo base_url().index_page()."art-director/home/manage";?>"> 
											<div class="scroller" style="height:250px" data-always-visible="1" data-rail-visible1="1">
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
										                       <h4>Group</h4>
									                      <select class="form-control" name="group">
											                     <option required="required" value="">Select</option>
                                   <?php
			                                                $type1 = $this->db->query("SELECT * FROM `Group`")->result_array();
		
															foreach($type1 as $type11)
															{
																echo '<option value="'.$type11['id'].'" autocomplete="on">'.$type11['name'].'</option>';	
																	
															}
			                       ?>
										                 </select>
									                    </div>
														
														<div class="form-group">
										                       <h4>Designer</h4>
									                       <select class="form-control" name="designer">
											                     <option required="required" value="">Select</option>
                                   <?php
			                                                $type1 = $this->db->query("SELECT * FROM `designers` WHERE `is_active`='1'")->result_array();
		
															foreach($type1 as $type11)
															{
																echo '<option value="'.$type11['id'].'">'.$type11['name'].'</option>';	
																	
															}
			                       ?>
										                 </select>
									                    </div>
														
														<div class="form-group">
										                       <h4>Team Lead</h4>
									                      <select class="form-control" name="tlead">
											                     <option required="required" value="">Select</option>
                                   <?php
			                                               // match = $this->db->query("SELECT * FROM `team_lead_assign` WHERE `helop`")->result_array();
															$type1 = $this->db->query("SELECT * FROM `team_lead` WHERE `is_active`='1'")->result_array();
                      // $data['result'] = $this->db->query("SELECT * FROM `publications`,`cat_result`  WHERE `date` BETWEEN '$ptday' AND '$today' AND publications.id =cat_result.publication_id AND publications.channel='$channel' AND cat_result.pdf_path='none' AND cat_result.cancel!='1' ORDER BY date DESC")->result_array();
					                                        
															foreach($type1 as $type11) 
															{
																echo '<option value="'.$type11['id'].'">'.$type11['first_name'].'</option>';	
																	
															}
			                       ?>
										                 </select>
									                    </div>
														<div class="form-group">
										                       <input type="text" hidden  name="team" value="<?php echo $row['id']; ?>">
										                 
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
										 <div id="responsive_<?php echo $row['id']; ?>" class="modal fade" tabindex="-1" aria-hidden="true">
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
							<div class="panel-group accordion" id="accordion<?php echo $row['id']; ?>">
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
										<a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion<?php echo $row['id']; ?>" href="#collapse_<?php echo $row['id']; ?>_1">
										<?php $group = $this->db->query("SELECT * FROM `Group` WHERE help_desk_id='".$row['id']."'")->result_array(); ?>
										<span class="badge badge-success bg-green-haze"> <?php echo count($group); ?> </span>
										&nbsp;<span class="font-mx">Group </span>
										 
										</a>
										</h4>
									</div>
									<div id="collapse_<?php echo $row['id']; ?>_1" class="panel-collapse collapse">
									  <div class="panel-body">
										 <table class="table table-hover table-light">
										   <thead>
											<tr>
												<th class="font-blue-madison"></th>
												<th></th>
											</tr>
											</thead>
										   <tbody>
										   <?php
										   foreach($group as $row1){
										   ?>
											<tr>
												<td>
													<span><?php echo $row1['name']; ?></span>
												</td>
												<td>
													 <a href="javascript:;" class="label label-sm bg-blue-madison label-mini">View</a>
												</td>
											</tr>
											<?php } ?>
										  </tbody>	
										</table>	
									  </div>
									</div>
								</div>
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
										<a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion<?php echo $row['id']; ?>" href="#collapse_<?php echo $row['id']; ?>_2">
										<?php $designer = $this->db->query("SELECT * FROM `designer_assign` WHERE help_desk_id='".$row['id']."'")->result_array(); ?>
										<span class="badge badge-success bg-green-haze"> <?php  echo count($designer); ?> </span>
										&nbsp;<span class="font-mx">Designer</span>
										</a>
										</h4>
									</div>
									<div id="collapse_<?php echo $row['id']; ?>_2" class="panel-collapse collapse">
										<div class="panel-body">
										 <table class="table table-hover table-light">
										   <thead>
											<tr>
												<th class="font-blue-madison"></th>
												<th></th>
											</tr>
											</thead>
										   <tbody>
											<tr>
										<?php
										   foreach($designer as $name){
										   $designer_name = $this->db->query("SELECT * FROM `designers` WHERE id='".$name['designer_id']."'")->result_array();
										 ?>
												<td>
													<span><?php echo $designer_name[0]['name']; ?></span>
												</td>
												<td>
													 <a href="<?php echo base_url().index_page()."art-director/home/new_designer";?>/<?php echo $designer_name[0]['id']; ?>" class="label label-sm bg-blue-madison label-mini">View</a>
													 &nbsp  <a  onClick="delete_designer(<?php echo $designer_name[0]['id']; ?>,<?php echo $row['id'];?>);" class="label label-sm bg-blue-madison label-mini">Remove</a>
												</td>
											</tr>
											<?php } ?>
										  </tbody>	
										</table>	
									  </div>
									</div>
								</div>
								<div class="panel panel-default" <?php  if($row['id']=="10") { ?>  Hidden <?php } ?>>
									<div class="panel-heading">
										<h4 class="panel-title">
										<a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion<?php echo $row['id']; ?>" href="#collapse_<?php echo $row['id']; ?>_3">
										<?php $team_lead = $this->db->query("SELECT * FROM `team_lead_assign` WHERE help_desk_id='".$row['id']."'")->result_array(); ?>
										<span class="badge badge-success bg-green-haze"> <?php echo count($team_lead); ?> </span>
										&nbsp;<span class="font-mx">Team Lead</span>
										</a>
										</h4>
									</div>
									<div id="collapse_<?php echo $row['id']; ?>_3" class="panel-collapse collapse">
										<div class="panel-body">
										 <table class="table table-hover table-light">
										   <thead>
											<tr>
												<th class="font-blue-madison"></th>
												<th></th>
											</tr>
											</thead>
										   <tbody>
										   <?php
										   foreach($team_lead as $tlname){
										   $team_lead_name = $this->db->query("SELECT * FROM `team_lead` WHERE id='".$tlname['team_lead_id']."'")->result_array();
										 ?>
											<tr>
												<td>
													<span><?php echo $team_lead_name[0]['first_name']; ?></span>
												</td>
												<td>
													 <a href="<?php echo base_url().index_page()."art-director/home/new_teams";?>/<?php echo $team_lead_name[0]['id']; ?>" class="label label-sm bg-blue-madison label-mini">View</a>
													 &nbsp <a  onClick="delete_tlead(<?php echo $team_lead_name[0]['id']; ?>,<?php echo $row['id'];?>);" class="label label-sm bg-blue-madison label-mini">Remove</a>
												</td>
											</tr>
											<?php } ?>
										  </tbody>	
										</table>	
									  </div>
									</div>
								</div>
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
										<a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion<?php echo $row['id']; ?>" href="#collapse_<?php echo $row['id']; ?>_4">
										<?php $csr = $this->db->query("SELECT * FROM `csr_assign` WHERE help_desk_id='".$row['id']."'")->result_array(); ?>
										<span class="badge badge-success bg-green-haze"> <?php  echo count($csr); ?> </span>
										&nbsp;<span class="font-mx">Csr</span>
										</a>
										</h4>
									</div>
									<div id="collapse_<?php echo $row['id']; ?>_4" class="panel-collapse collapse">
										<div class="panel-body">
										 <table class="table table-hover table-light">
										   <thead>
											<tr>
												<th class="font-blue-madison"></th>
												<th></th>
											</tr>
											</thead>
										   <tbody>
											<tr>
										<?php
										   foreach($csr as $name){
										   $csr_name = $this->db->query("SELECT * FROM `csr` WHERE id='".$name['csr_id']."'")->result_array();
										 ?>
												<td>
													<span><?php echo $csr_name[0]['name']; ?></span>
												</td>
												<td>
												     	 <a  class="label label-sm bg-blue-madison label-mini">view</a>
													
												
												</td>
											</tr>
											<?php } ?>
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
						<?php } ?>
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
<script type="text/javascript" src="../../../ui_assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
<script type="text/javascript" src="../../../ui_assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js"></script>
<script type="text/javascript" src="../../../ui_assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
<script src="../../../ui_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
<script src="../../../ui_assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../../../ui_assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="../../../ui_assets/admin/layout3/scripts/layout.js" type="text/javascript"></script>
<script src="../../../ui_assets/admin/layout3/scripts/demo.js" type="text/javascript"></script>
<script src="../../../ui_assets/admin/pages/scripts/table-advanced.js"></script>
<script src="../../../ui_assets/global/scripts/datatable.js"></script>
<script src="../../../ui_assets/admin/pages/scripts/table-ajax.js"></script>
<script src="../../../ui_assets/admin/pages/scripts/profile.js" type="text/javascript"></script>
<script>
jQuery(document).ready(function() {       
   	// initiate layout and plugins
   	Metronic.init(); // init metronic core components
	Layout.init(); // init current layout
	Demo.init(); // init demo features\
	Profile.init(); // init page demo
	TableAdvanced.init();
    Todo.init(); // init todo page
});
</script>
</body>
<!-- END BODY -->
</html>