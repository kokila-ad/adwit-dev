<?php $this->load->view("admin/head1.php");?>
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
						<h3 class="page-title">CSR</h3>
					</div>
					<div class="col-md-6">
						<?php echo '<span style="color:#900;">'.$this->session->flashdata('csr_successful').'</span>'; ?>
						<?php echo '<span style="color:#900;">'.$this->session->flashdata('csr_updated_successful').'</span>'; ?>
					</div>
				</div>
				<!-- END PAGE HEADER-->

				<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box green-haze">
							<div class="portlet-title">
								<div class="caption">
									<a data-toggle="modal" href="#addnew" type="button" class="btn btn-default btn-xs">
										<i class="fa fa-plus margin-right-10"></i>Add CSR
									</a>
								</div>
								<div class="tools margin-left-10">
									<a href="javascript:;" class="collapse">
									</a>
									<a href="javascript:;" class="reload">
									</a>
								</div>
								<div class="margin-top-10 text-right">
									<!--<button class="btn bg-grey btn-xs"><i class="fa fa-file-excel-o"></i> Export</button>-->
									<button class="btn bg-grey btn-xs" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
									<button class="btn bg-grey btn-xs"><i class="fa fa-print"></i> Print</button>
								</div>
							</div>
							<div class="portlet-body">
								<table class="table table-striped table-bordered table-hover" id="sample_6">
								<thead>
								<tr>
									<th>Name</th>
									<th>Username</th>
									<th>Email id</th>
									<!--<th>Username</th>-->
									<th>Business Group Id</th>
									<th>Join Location</th>
									<th>Work Location</th>
									<th>Actions</th>
								</tr>
								</thead>
								<tbody>
								<?php $i=0; foreach($csr as $row) { $i++; 
								$business_group_name = $this->db->query("SELECT * FROM `business_groups` WHERE `id` = '".$row['business_group_id']."'")->result_array();
								$location_name = $this->db->query("SELECT * FROM `location` WHERE `id` = '".$row['Join_location']."'")->result_array();
								$work_location = $this->db->query("SELECT * FROM `location` WHERE `id` = '".$row['Work_location']."'")->result_array();
								?>
								<tr>
									<td><?php echo $row['name'] ;?></td>
									<td><?php echo $row['username'];?></td>
									<td><?php echo $row['email_id'] ;?></td>
									<!--<td><?php echo $row['username'] ;?></td>-->
									<td><?php if($row['business_group_id']=='0'){ echo "";}else{ echo $business_group_name[0]['name']; } ?></td>
									<td><?php if($row['Join_location']=='0' || $row['Join_location']=='' ){ echo "";}else{ echo $location_name[0]['name']; } ?></td>
									<td><?php if($row['Work_location']=='0' || $row['Work_location']==''){ echo "";}else{ echo $work_location[0]['name']; } ?></td>
									<?php if($row['is_active']==1) { ?>
									<td>
										<a data-toggle="modal" href="#edit<?php echo $i;?>" class="font-blue margin-right-10"><i class="fa fa-edit"></i></a>
										<a title="" class="btn btn-primary btn-xs">Active</a>
									</td>
									<?Php } else { ?>
									<td>
										<a data-toggle="modal" href="#edit<?php echo $i;?>" class="font-blue  margin-right-10"><i class="fa fa-edit"></i></a>
										<a title="" class="btn btn-danger btn-xs">Deactive</a>
									</td>
									<?php } ?>
								</tr>
								<div id="edit<?php echo $i;?>" class="modal fade" tabindex="-1" data-width="760">
									<div class="modal-dialog modal-lg">
										<div class="modal-content">
										<form method="post" name="order_form" action="<?php echo base_url().index_page().'admin/home/csr_update/'.$row['id'];?>" id="order_form">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h4 class="modal-title">Edit CSR</h4>
											</div>
											 <div class="modal-body">																																		
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="margin-top-5">Name</label><span class="mandatory font-red">*</span>
															<input type="text" class="form-control" name="name" value="<?php echo $row['name'] ;?>" required/>
														</div>
													</div>								
													<div class="col-md-6">
														<div class="form-group">
															<label class="margin-top-5">Gender</label>
															<div class="clearfix">
																<div class="btn-group" data-toggle="buttons">
																	<label class="btn btn-success <?php if($row['gender']=='0')echo"active"; ?> margin-right-10">
																	<input type="radio" value="0" name="gender" class="toggle"> Female </label>
																	<label class="btn btn-success <?php if($row['gender']=='1')echo"active"; ?>">
																	<input type="radio" value="1" name="gender" class="toggle"> Male </label>
																</div>
															</div>
														</div>							  
													</div>
													
													<div class="col-md-6">
														<div class="form-group">
															<label class="margin-top-5">Email Id</label><span class="mandatory font-red">*</span>
															<input type="text" class="form-control" name="email_id" value="<?php echo $row['email_id'] ;?>" required/>
														</div>						  
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label class="margin-top-5">Team</label><span class="mandatory font-red">*</span>
															<input type="text" class="form-control" name="team" value="<?php echo $row['team'] ;?>" required/>
														</div>
													</div>
													
													<div class="col-md-6">
														<div class="form-group">
															<label class="margin-top-5">Business group id</label><span class="mandatory font-red">*</span>
															<select class="form-control" name="business_group_id" required/>
																<option value="">Select Business Group</option>
																	<?php foreach($business_groups as $row1){ ?>
																	<option value = "<?php echo($row1['id'])?>" <?php if($row1['id']==$row['business_group_id'])echo"selected"; ?> ><?php echo($row1['name']);?></option>
																	<?php } ?>
															</select>
															
														</div>							  
													</div>				
												</div>
								<hr>				
												<div class="row">												
													<div class="col-md-6">
														<div class="form-group">
															<label class="margin-top-5">User Name</label><span class="mandatory font-red">*</span>
															<input type="text" class="form-control"  name="username" value="<?php echo $row['username'] ;?>" required/>
														</div>							  
													</div>
													<!--<div class="col-md-6">
														<div class="form-group">
															<label class="margin-top-5">Password</label>
															<input type="password" class="form-control"  name="password"/>
														</div>						  
													</div>-->
													
													<div class="col-md-6">
														<div class="form-group">
															<label class="margin-top-5">Mobile no</label>
															<input type="text" class="form-control"  name="mobile_no" value="<?php echo $row['mobile_no'] ;?>" />
														</div>						  
													</div>								
													<div class="col-md-6">
														<div class="form-group">
															<label class="margin-top-5">Join Location</label><span class="mandatory font-red">*</span>
															<select class="form-control" name="Join_location" required/>
																<option value="">Select Join Location</option>
																	<?php foreach($location as $loc_row){ ?>
																	<option value = "<?php echo($loc_row['id'])?>" <?php if($loc_row['id']==$row['Join_location'])echo"selected"; ?> ><?php echo($loc_row['name']);?></option>
																	<?php } ?>
															</select>					
														</div>						  
													</div>	
													
													<div class="col-md-6">
														<div class="form-group">
															<label class="margin-top-5">Work Location</label><span class="mandatory font-red">*</span>
															<select class="form-control" name="Work_location" required/>
																<option value="">Select Work Location</option>
																	<?php foreach($location as $work_row){ ?>
																	<option value = "<?php echo($work_row['id'])?>" <?php if($work_row['id']==$row['Work_location'])echo"selected"; ?> ><?php echo($work_row['name']);?></option>
																	<?php } ?>
															</select>	
														</div>						  
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label class="margin-top-5">Ext no</label>
															<input type="text" class="form-control" name="ext_no" value="<?php echo $row['ext_no']?>">
														</div>						  
													</div>	
													
													
													
													<div class="col-md-6">
														<div class="form-group">
																<label class="margin-top-5">Is Active</label>
																<div class="clearfix">
																	<div class="btn-group" data-toggle="buttons">
																		<label class="btn btn-success <?php if($row['is_active']=='1')echo"active"; ?> margin-right-10">
																		<input type="radio" name="is_active" value="1" class="toggle" <?php if($row['is_active']=='1')echo"checked"; ?> /> Active </label>
																		<label class="btn btn-success <?php if($row['is_active']=='0')echo"active"; ?>">
																		<input type="radio" name="is_active" value="0" class="toggle" <?php if($row['is_active']=='0')echo"checked"; ?> /> In-Active </label>
																	</div>
																</div>
														</div>
													</div>
											</div>								
											</div>
											 <div class="modal-footer">	
											 <button type="button" class="btn red-flamingo" data-dismiss="modal" aria-hidden="true">Back</button>
											 <input class="btn btn-primary" type="submit" value="Update" id="submit_form"  />
												
											</div>
										</form>
									</div>
								</div>	
								</div>	
								
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
	</div>
	<!-- END CONTAINER -->


	
<div id="addnew" class="modal fade" tabindex="-1" data-width="760">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
		<form method="post" name="order_form" id="order_form">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Add CSR</h4>
			</div>
  	        <div class="modal-body">																																		
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Name</label><span class="mandatory font-red">*</span>
							<input type="text" class="form-control" name="name" required/>
						</div> 
					</div>								
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Gender</label>
							<div class="clearfix">
								<div class="btn-group" data-toggle="buttons">
									<label class="btn btn-success active margin-right-10">
									<input type="radio" value="1" name="gender" class="toggle"> Male </label>
									<label class="btn btn-success">
									<input type="radio" value="0" name="gender" class="toggle"> Female </label>
								</div>
							</div>
						</div>							  
					</div>
								
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Email Id</label><span class="mandatory font-red">*</span>
							<input type="text" class="form-control" name="email_id" required/>
						</div>						  
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Team</label><span class="mandatory font-red">*</span>
							<input type="text" class="form-control" name="team" required/>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Business group id</label><span class="mandatory font-red">*</span>
							<select class="form-control" name="business_group_id" required/>
								<option value="">Select Business group</option>
								<?php foreach($business_groups as $row1) { ?>
								<option value="<?php echo $row1['id'] ;?>"><?php echo $row1['name'] ;?></option>
								<?php } ?>
							</select>
							
						</div>							  
					</div>					
				</div>
<hr>				
				<div class="row">												
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">User Name</label><span class="mandatory font-red">*</span>
							<input type="text" class="form-control" name="username" required/>
						</div>							  
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Password</label><span class="mandatory font-red">*</span>
							<input type="password" class="form-control" name="password" required/>
						</div>						  
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Mobile no</label>
							<input type="text" class="form-control" name="mobile_no">
						</div>						  
					</div>								
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Join Location</label>
							<select class="form-control" name="Join_location">
								<option>Select Join Location</option>
								<?php foreach($location as $loc_row) { ?>
								<option value="<?php echo $loc_row['id'] ;?>"><?php echo $loc_row['name'] ;?></option>
								<?php } ?>
							</select>					
						</div>						  
					</div>	
					
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Work Location</label>
							<select class="form-control" name="Work_location">
								<option>Select Work Location</option>
								<?php foreach($location as $loc_row) { ?>
								<option value="<?php echo $loc_row['id'] ;?>"><?php echo $loc_row['name'] ;?></option>
								<?php } ?>
							</select>	
						</div>						  
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Ext no</label>
							<input type="text" class="form-control" name="ext_no">
						</div>						  
					</div>	
					
					
					<div class="col-md-6">
						<div class="form-group">
								<label class="margin-top-5">Is Active</label>
								<div class="clearfix">
									<div class="btn-group" data-toggle="buttons">
										<label class="btn btn-success active margin-right-10">
										<input type="radio" name="is_active" value="1" class="toggle"> Active </label>
										<label class="btn btn-success">
										<input type="radio" name="is_active" value="0" class="toggle"> In-Active </label>
										</div>
								</div>
						</div>
					</div>	

		</div>								
		    </div>
			 <div class="modal-footer">	
				<!--<button type="button" class="btn btn-primary">Save</button>-->
				<button type="button" class="btn red-flamingo" data-dismiss="modal" aria-hidden="true">Back</button>
				<input class="btn btn-primary" type="submit" value="Create" id="submit_form"  />
				<!--<button type="submit" class="btn btn-success">Save and go back to list</button>-->
				
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
<?php $this->load->view("admin/foot1.php");?>