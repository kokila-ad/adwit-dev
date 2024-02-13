<?php $this->load->view("admin/head1")?>
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
				<div class="portlet light">
					<div class="portlet-body">	
				<!-- BEGIN PAGE HEADER-->
				<div class="row">
					<div class="col-md-6">
						<h3 class="page-title">Team Lead</h3>
					</div>
					<div class="col-md-6">
						<?php echo '<span style="color:#900;">'.$this->session->flashdata('teamlead_successful').'</span>'; ?>
						<?php echo '<span style="color:#900;">'.$this->session->flashdata('teamlead_updated_successful').'</span>'; ?>
					</div>
				</div>
				<!-- END PAGE HEADER-->

				<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box green-haze">
							<div class="portlet-title">
								<div class="caption">
									<a data-toggle="modal" href="#addnew" type="button" class="btn btn-default btn-xs">
										<i class="fa fa-plus margin-right-10"></i>Add Team Lead
									</a>
								</div>
								<div class="tools margin-left-10">
									<a href="javascript:;" class="collapse">
									</a>
									<a href="javascript:;" class="reload">
									</a>
								</div>
								<div class="margin-top-10 text-right">
									<button class="btn bg-grey btn-xs"><i class="fa fa-file-excel-o"></i> Export</button>
									<button class="btn bg-grey btn-xs"><i class="fa fa-print"></i> Print</button>
								</div>
							</div>
							<div class="portlet-body">
								<table class="table table-striped table-bordered table-hover" id="sample_2">
								<thead>
								<tr>
									<th>ID</th>
									<th>First Name</th>
									<th>Email id</th>
									<th>Business Group Id</th>
									<th>Join Location</th>
									<th>Work Location</th>
									<th>Actions</th>
								</tr>
								</thead>
								<tbody>
								<?php $i=0; foreach($team_lead as $row) { $i++;
								$business_group_name = $this->db->query("SELECT * FROM `business_groups` WHERE `id` = '".$row['bg']."'")->result_array();
								$location_name = $this->db->query("SELECT * FROM `location` WHERE `id` = '".$row['Join_location']."'")->result_array();
								$work_location = $this->db->query("SELECT * FROM `location` WHERE `id` = '".$row['Work_location']."'")->result_array();
								?>
								<tr>
									<td><?php echo $row['id']; ?></td>
									<td><?php echo $row['first_name'];?></td>
									<td><?php echo $row['email_id'];?></td>
									<td><?php if($row['bg']=='0'){ echo "";}else{ echo $business_group_name[0]['name'] ;}?></td>
									<td><?php if($row['Join_location']=='0'){ echo "";}else{ echo $location_name[0]['name'] ;}?></td>
									<td><?php if($row['Work_location']=='0'){ echo "";}else{ echo $work_location[0]['name'] ;}?></td>
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
								<!--EDIT-->
<div id="edit<?php echo $i?>" class="modal fade" tabindex="-1" data-width="760">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
		<form method="post" name="order_form" action="<?php echo base_url().index_page().'admin/home/teamlead_update/'.$row['id'];?>" id="order_form">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Edit Team Lead</h4>
			</div>
  	        <div class="modal-body">																																		
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">First Name</label><span class="mandatory font-red">*</span>
							<input type="text" class="form-control" value="<?php echo $row['first_name'];?>" name="first_name" required/>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Last Name</label><span class="mandatory font-red">*</span>
							<input type="text" class="form-control" name="last_name" value="<?php echo $row['last_name'];?>" required/>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Gender</label>
							<div class="clearfix">
								<div class="btn-group" data-toggle="buttons">
									<label class="btn btn-success <?php if($row['gender']=='1')echo"active"; ?> margin-right-10">
									<input type="radio" value="1" name="gender" class="toggle"> Male </label>
									<label class="btn btn-success <?php if($row['gender']=='0')echo"active"; ?>">
									<input type="radio" value="0" name="gender" class="toggle"> Female </label>
								</div>
							</div>
						</div>							  
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Art director</label><span class="mandatory font-red">*</span>
							<input type="text" name="art_director" value="<?php echo $row['art_director'];?>" class="form-control" required/>
						</div>
					</div>
				
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Business Group </label>
							<select class="form-control" name="bg">
								<option>Select Business group</option>
								<?php foreach($business_groups as $bg_row){ ?>
								<option value = "<?php echo($bg_row['id'])?>" <?php if($bg_row['id']==$row['bg'])echo"selected"; ?> ><?php echo($bg_row['name']);?></option>
								<?php } ?>
							</select>
						</div>							  
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Email Id</label><span class="mandatory font-red">*</span>
							<input type="text" name="email_id" value="<?php echo $row['email_id'];?>" class="form-control" required/>
						</div>						  
					</div>				
				</div>
<hr>				
				<div class="row">												
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">User Name</label><span class="mandatory font-red">*</span>
							<input type="text" name="username" value="<?php echo $row['username'];?>" class="form-control" required/>
						</div>							  
					</div>
												
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Phone</label><span class="mandatory font-red">*</span>
							<input type="text" name="phone" value="<?php echo $row['phone'];?>" class="form-control" required/>
						</div>						  
					</div>	
					
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Mobile no</label><span class="mandatory font-red">*</span>
							<input type="text" name="mobile_no" value="<?php echo $row['mobile_no'];?>" class="form-control" required/>
						</div>					  
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Join Location</label>
							<select class="form-control" name="join_location">
								<option>Select Join Location</option>
								<?php foreach($location as $loc_row){ ?>
								<option value = "<?php echo($loc_row['id'])?>" <?php if($loc_row['id']==$row['Join_location'])echo"selected"; ?> ><?php echo($loc_row['name']);?></option>
								<?php } ?>
							</select>					
						</div>						  
					</div>				
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Work Location</label>
							<select class="form-control" name="work_location">
								<option>Select Work Location</option>
								<?php foreach($location as $loc_row){ ?>
								<option value = "<?php echo($loc_row['id'])?>" <?php if($loc_row['id']==$row['Work_location'])echo"selected"; ?> ><?php echo($loc_row['name']);?></option>
								<?php } ?>
							</select>	
						</div>						  
					</div>
					<div class="col-md-6">
						<div class="form-group">
								<label class="margin-top-5">Is Active</label>
								<div class="clearfix">
									<div class="btn-group" data-toggle="buttons">
									<label class="btn btn-success <?php if($row['is_active']=='1')echo"active"; ?> margin-right-10">
									<input type="radio" name="is_active" value="1" class="toggle" <?php if($row['is_active']=='1')echo"checked"; ?>> Active </label>
									<label class="btn btn-success <?php if($row['is_active']=='0')echo"active"; ?>">
									<input type="radio" name="is_active" value="0" class="toggle"<?php if($row['is_active']=='0')echo"checked"; ?> > In-Active </label>
								</div>
								</div>
						</div>
					</div>
		</div>								
		    </div>
		<div class="modal-footer">	
				<!--<button type="button" class="btn btn-primary">Update</button>-->
				<input class="btn btn-primary" type="submit" value="Update" id="submit_form"  />
				<!--<button type="button" class="btn btn-success">Update and go back to list</button>-->
				<button type="button" class="btn red-flamingo" data-dismiss="modal" aria-hidden="true">Cancel</button>
		</div>
		</form>
	</div>
</div>	
</div>
		<!--EDIT-->
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
				<h4 class="modal-title">Add Team Lead</h4>
			</div>
  	        <div class="modal-body">																																		
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">First Name</label><span class="mandatory font-red">*</span>
							<input type="text" class="form-control" name="first_name" required/>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Last Name</label><span class="mandatory font-red">*</span>
							<input type="text" class="form-control" name="last_name" required/>
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
							<label class="margin-top-5">Art director</label><span class="mandatory font-red">*</span>
							<input type="text" name="art_director" class="form-control" required/>
						</div>
					</div>
				
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Business Group </label>
							<select class="form-control" name="bg">
								<option>Select Business group</option>
								<?php foreach($business_groups as $bg_row){ ?>
								<option value="<?php echo $bg_row['id'];?>"><?php echo $bg_row['name'];?></option>
								<?php } ?>
							</select>
						</div>							  
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Email Id</label><span class="mandatory font-red">*</span>
							<input type="text" name="email_id" class="form-control" required/>
						</div>						  
					</div>				
				</div>
<hr>				
				<div class="row">												
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">User Name</label><span class="mandatory font-red">*</span>
							<input type="text" name="username" class="form-control" required/>
						</div>							  
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Password</label><span class="mandatory font-red">*</span>
							<input type="password" name="password" class="form-control" required/>
						</div>						  
					</div>
												
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Phone</label><span class="mandatory font-red">*</span>
							<input type="text" name="phone" class="form-control" required/>
						</div>						  
					</div>	
					
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Mobile no</label><span class="mandatory font-red">*</span>
							<input type="text" name="mobile_no" class="form-control" required/>
						</div>					  
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Join Location</label>
							<select class="form-control" name="Join_location">
								<option>Select Join Location</option>
								<?php foreach($location as $loc_row){ ?>
								<option value="<?php echo $loc_row['id'];?>"><?php echo $loc_row['name'];?></option>
								<?php } ?>
							</select>					
						</div>						  
					</div>				
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Work Location</label>
							<select class="form-control" name="Work_location">
								<option>Select Work Location</option>
								<?php foreach($location as $loc_row){ ?>
								<option value="<?php echo $loc_row['id'];?>"><?php echo $loc_row['name'];?></option>
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
				 <input class="btn btn-primary" type="submit" value="Save" id="submit_form"  />
				<button type="submit" class="btn btn-success">Save and go back to list</button>	
				<button type="button" class="btn red-flamingo" data-dismiss="modal" aria-hidden="true">Cancel</button>
			 </div>
		</form>
		</div>
	</div>
</div>	
	
	
	
	
	</div>
</div>
	<?php $this->load->view("admin/foot1")?>