<?php $this->load->view("admin/head1") ?>
<script type="text/javascript" src="jquery-1.3.2.js" ></script>
<script type="text/javascript" src="html2csv.js" ></script> 
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
				<div class="portlet light">
					<div class="portlet-body">	
				<!-- BEGIN PAGE HEADER-->
				<div class="row">
					<div class="col-md-6">
						<h3 class="page-title">Publications</h3>
					</div>
					<div class="col-md-6">
						<?php echo '<span style="color:#900;">'.$this->session->flashdata('publications_successful').'</span>'; ?>
						<?php echo '<span style="color:#900;">'.$this->session->flashdata('publications_updated_successful').'</span>'; ?>
						<div class="text-right">
							<!--<button class="btn bg-grey btn-xs"><i class="fa fa-file-excel-o"></i> Export</button>-->
							<a data-toggle="modal" href="<?php echo base_url().index_page()."admin/home/publications_add";?>" type="button" class="btn bg-grey btn-xs">
									<i class="fa fa-plus margin-right-10"></i>Add</a>
							<button class="btn bg-grey btn-xs" onclick="tableToExcel('sample_2', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
						</div>
					</div>
				</div>
				<!-- END PAGE HEADER-->

				<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box green-haze">
							<div class="portlet-title">
								<div class="caption">
									
								</div>
								<div class="tools  margin-left-10">
									<a href="javascript:;" class="collapse">
									</a>
									<a href="javascript:;" class="reload">
									</a>
								</div>
							</div>
							<div class="portlet-body">	
								<table class="table table-striped table-bordered table-hover" id="sample_2">
								<thead>
								<tr>
									<th>ID</th>
									<th>Name</th>
									<th>Design Team</th>
									<th>Slug Type</th>
									<th>Help desk</th>
									<th>Group</th>
									<th>Channel</th>
									<th>View</th>
									
								</tr>
								</thead>
								<tbody>
						<?php $i=0; foreach($publications_list as $row) {  $i++;
								//$business_group = $this->db->query("SELECT * FROM `business_groups` WHERE `id` = '".$row['business_group_id']."'")->result_array();
								$design_team_name = $this->db->query("SELECT * FROM `design_teams` WHERE `id` = '".$row['design_team_id']."'")->result_array();
								$slug_types = $this->db->query("SELECT * FROM `cat_slug_type` WHERE `id` = '". $row['slug_type']."'")->result_array();
								$help_desk_name = $this->db->query("SELECT * FROM `help_desk` WHERE `id` = '".$row['help_desk']."'")->result_array();
								//$ordering_system_name = $this->db->query("SELECT * FROM `ordering_system` WHERE `id` = '".$row['ordering_system']."'")->result_array();
								$group_name = $this->db->query("SELECT * FROM `Group` WHERE `id` = '".$row['group_id']."' ")->result_array();
								$channels_name = $this->db->query("SELECT * FROM `channels` WHERE `id` = '".$row['channel']."'")->result_array();
								?>
								<tr>
									<td><?php echo $row['id']; ?></td>
									<td><?php echo $row['name']; ?></td>
									<td><?php if($row['design_team_id']=='0'){echo "";}else{ echo $design_team_name[0]['name']; } ?></td>
									<td><?php if($row['slug_type']=='0'){echo "";}else{ echo $slug_types[0]['name']; }?></td>
									<td><?php if($row['help_desk']=='0'){echo "";}else{ echo $help_desk_name[0]['name']; }?></td>
									<td><?php if($row['group_id'] == '0'){ echo ""; }else{ echo $group_name[0]['name']; } ?></td>
									<td><?php if($row['channel']== '0'){ echo "";}else { echo $channels_name[0]['name'];}?></td>
									<td><a href="javascript:;" class="btn btn-primary btn-xs" onclick="window.location = '<?php echo base_url().index_page()."admin/home/publications_edit/".$row['id'];?>'">View</a>
								</tr>
<!-- EDIT -->							
<!-- EDIT -->
						<?php } ?>
								</tbody>
								</table>
							</div>
						</div>
						<!-- END EXAMPLE TABLE PORTLET-->
						
				</div>
				</div>
			</div>
		<!-- END CONTENT -->
		<!-- BEGIN QUICK SIDEBAR -->
		<!--Cooming Soon...-->
		<!-- END QUICK SIDEBAR -->
		</div>
	<!-- END CONTAINER -->

<!-- Add-->
	
<div id="addnew" class="modal fade" tabindex="-1" data-width="760">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
		<form method="post" name="order_form" id="order_form">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Add Publication</h4>
			</div>
  	        <div class="modal-body">																																		
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Business Group</label><span class="mandatory font-red">*</span>
							<select class="form-control" name="business_group_id" required>
								<option value="">Select Business Group</option>
								<?php foreach($business_groups as $row1){ ?>
								<option value = "<?php echo($row1['id'])?>" ><?php echo($row1['name']); ?></option>
								<?php } ?>
							</select>
						</div>
					</div>	
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Group id</label><span class="mandatory font-red">*</span>
							<select class="form-control" name="group_id" required>
								<option value="">Select Group</option>
								<?php foreach($group as $group_row){ ?>
								<option value = "<?php echo($group_row['id'])?>" ><?php echo($group_row['name']); ?></option>
								<?php } ?>
							</select>
						</div>						  
					</div>
							
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Name </label><span class="mandatory font-red">*</span>
							<input type="text" name="name" class="form-control" required>
						</div>							  
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Advertising Director</label><span class="mandatory font-red">*</span>
							<input type="text" name="advertising_director_email_id" class="form-control" required>
						</div>						  
					</div>
		
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Design Team</label><span class="mandatory font-red">*</span>
							<select class="form-control" name="design_team_id" required>
								<option value="">Select Design Team</option>
								<?php foreach($design_team as $design_row){ ?>
								<option value = "<?php echo($design_row['id'])?>" ><?php echo($design_row['name']); ?></option>
								<?php } ?>
							</select>
						</div>							  
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Team lead id</label><span class="mandatory font-red">*</span>
							<select class="form-control" name="team_lead_id" required>
								<option value="">Select Team</option>
								<?php foreach($teams as $team_row){ ?>
								<option value = "<?php echo($team_row['id'])?>" ><?php echo($team_row['name']); ?></option>
								<?php } ?>
							</select>
						</div>						  
					</div>
					
					<!--<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Spec ads</label>
							<input type="text" class="form-control">
						</div>							  
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Sold ads</label>
							<input type="text" class="form-control">
						</div>						  
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Slug type </label>
							<select class="form-control">
								<option>Option 1</option>
								<option>Option 2</option>
								<option>Option 3</option>
							</select>
						</div>							  
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">News id</label>
							<input type="text" class="form-control">
						</div>						  
					</div>-->
					
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Initial</label><span class="mandatory font-red">*</span>
							<input type="text" name="initial" class="form-control" required>
						</div>							  
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Help desk</label><span class="mandatory font-red">*</span>
							<select class="form-control" name="help_desk" required>
								<option value="">Select Help Desk</option>
								<?php foreach($help_desk as $hd_row){ ?>
								<option value = "<?php echo($hd_row['id'])?>" ><?php echo($hd_row['name']); ?></option>
								<?php } ?>
							</select>
						</div>						  
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Ordering system</label><span class="mandatory font-red">*</span>
							<select class="form-control" name="ordering_system" required>
								<option value="">Select Ordering System</option>
								<?php foreach($ordering_system as $order_row){ ?>
								<option value = "<?php echo($order_row['id'])?>" ><?php echo($order_row['name']); ?></option>
								<?php } ?>
							</select>
						</div>							  
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Channel</label><span class="mandatory font-red">*</span>
							<select class="form-control" name="channel" required>
								<option value="">Select Channels</option>
								<?php foreach($channels as $ch_row){ ?>
								<option value = "<?php echo($ch_row['id'])?>" ><?php echo($ch_row['name']); ?></option>
								<?php } ?>
							</select>
						</div>						  
					</div>
				<div class="col-md-6">
						<div class="form-group">
								<label class="margin-top-5">Is Active</label>
								<div class="clearfix">
									<div class="btn-group" data-toggle="buttons">
									<label class="btn btn-success active margin-right-10">
									<input type="radio" name="is_active" value="1" class="toggle" /> Active </label>
									<label class="btn btn-success">
									<input type="radio" name="is_active" value="0" class="toggle" /> In-Active </label>
								</div>
								</div>
						</div>
					</div>
					<!--<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Time Zone</label>
							<select class="form-control">
								<option>Option 1</option>
								<option>Option 2</option>
								<option>Option 3</option>
							</select>
						</div>							  
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">City</label>
							<input type="text" class="form-control">
						</div>						  
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Priority</label>
							<input type="text" class="form-control">
						</div>							  
					</div>-->
		</div>								
		    </div>
			 <div class="modal-footer">	
				<!--<button type="button" class="btn btn-primary">Save</button>-->
				 <input class="btn btn-primary" type="submit" value="Save" id="submit_form"  />
				<!--<button type="submit" class="btn btn-success">Save and go back to list</button>	-->
				<button type="button" class="btn red-flamingo" data-dismiss="modal" aria-hidden="true">Cancel</button>
			 </div>
		</form>
		</div>
	</div>
</div>	
		
	</div>
</div>

		
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
		
	<?php $this->load->view("admin/foot1") ?>
