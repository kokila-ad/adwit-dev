<?php $this->load->view("admin/head1.php"); ?>

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
						<h3 class="page-title">Adreps</h3>
					</div>
					<div class="col-md-6">
						<?php echo '<span style="color:#900;">'.$this->session->flashdata('adreps_successful').'</span>'; ?>
						<?php echo '<span style="color:#900;">'.$this->session->flashdata('adreps_updated_successful').'</span>'; ?>
					
					<div class="text-right">
							<!--<button class="btn bg-grey btn-xs"><i class="fa fa-file-excel-o"></i> Export</button>-->
							<a data-toggle="modal" href="<?php echo base_url().index_page()."admin/home/adreps_add";?>" type="button" class="btn bg-grey btn-xs">
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
								<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover" id="sample_2">
								<thead>
								<tr>
									<th>First Name</th>
									<th>Last Name</th>
									<th>Gender</th>
									<th>Username</th>
									<th>Design Team</th>
									<th>Email ID</th>
									<th>Publication</th>
									<!--<th>Actions</th>-->
									<th>View</th>
								</tr>
								</thead>
								<tbody>
								<?php $i=0; foreach($adreps_list as $row) {  $i++;
									$publications = $this->db->query("SELECT * FROM `publications` WHERE `id` = '".$row['publication_id']."'")->result_array();
									if($publications){
									$desg_team = $this->db->query("SELECT * FROM `design_teams` WHERE `id` = '".$publications[0]['design_team_id']."' ")->result_array();
									}?>
								<tr>
									<td><?php echo $row['first_name'];?></td>
									<td><?php echo $row['last_name'];?></td>
									<td><?php if($row['gender']==0) { echo "Female" ;} else { echo "male" ;}?></td>
									<td><?php echo $row['username'];?></td>
									<td><?php if(isset($desg_team)){ echo $desg_team[0]['name'];} else {echo " ";}?></td>
									<td><?php echo $row['email_id'];?></td>
									<td><?php if($row['publication_id']=='0'){ echo "";}else{ echo $publications[0]['name']; }?></td>
									<td><a href="javascript:;" class="btn btn-primary btn-xs" onclick="window.location = '<?php echo base_url().index_page()."admin/home/adreps_edit/".$row['id'];?>'">View</a>
								</tr>
<!-- EDIT -->								
  
<!-- edit -->									
	<?php } ?>							
								</tbody>
								</table>
								</div>
							</div>
						</div>
						
	
						<!-- END EXAMPLE TABLE PORTLET-->
					</div>
				</div>
		<!-- END CONTENT -->
		<!-- BEGIN QUICK SIDEBAR -->
		<!--Cooming Soon...-->
		<!-- END QUICK SIDEBAR -->
			</div>
		</div>
	<!-- END CONTAINER -->


<!--	
<div id="addnew" class="modal fade" tabindex="-1" data-width="760">
 <div class="modal-dialog">
	<?php echo '<span style="color:#900;">'.$this->session->flashdata('adreps_successful').'</span>'; ?>
	<div class="modal-content">
		<form method="post" name="order_form" id="order_form">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			<h4 class="modal-title">Add Ad Rep</h4>			
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="margin-top-5">Publication</label><span class="mandatory font-red">*</span>
						<select class="form-control" name="publication_id" required/>
							<option value="">Select Publication</option>
							<?php foreach($publications_list as $row1){ ?>
							<option value = "<?php echo($row1['id'])?>" ><?php echo($row1['name']); ?></option>
							<?php } ?>
						</select>	
					</div>							  
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label class="margin-top-5">First Name</label><span class="mandatory font-red">*</span>
						<input type="text" name="first_name" class="form-control" required/>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label class="margin-top-5">Last Name</label><span class="mandatory font-red">*</span>
						<input type="text" name="last_name" class="form-control" required/>
					</div>	
				</div>
				<div class="col-md-12">
					<div class="form-group">
					<label class="margin-top-5">Gender</label>
					<div class="clearfix">
						<div class="btn-group" data-toggle="buttons">
							<label class="btn btn-success margin-right-10">
							<input type="radio" value="0" name="gender" class="toggle"> Female </label>
							<label class="btn btn-success active">
							<input type="radio" value="1" name="gender" class="toggle"> Male </label>
						</div>
					</div>
				</div>	
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label class="margin-top-5">Email Id</label><span class="mandatory font-red">*</span>
						<input type="text" name="email_id" class="form-control" required/>
					</div>	
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label class="margin-top-5">User Name</label><span class="mandatory font-red">*</span>
						<input type="text" name="username" class="form-control" required/>
					</div>	
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label class="margin-top-5">Password</label><span class="mandatory font-red">*</span>
						<input type="password" name="password" class="form-control" required/>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
					<label class="margin-top-5">Phone No</label>
					<input type="text" name="phone_1" class="form-control" >
				</div>	
				</div>
			</div>
			
		</div>								
		<div class="modal-footer">
			<input class="btn btn-primary" type="submit" value="Save" id="submit_form"  />
			<button type="button" class="btn red-flamingo" data-dismiss="modal" aria-hidden="true">Cancel</button>
		 </div>
		</form>
	</div>
 </div>
</div>		
-->	
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

<?php $this->load->view("admin/foot1.php"); ?>