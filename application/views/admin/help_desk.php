<?php $this->load->view("admin/head1.php"); ?>
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
				<div class="portlet light">
					<div class="portlet-body">	
				<!-- BEGIN PAGE HEADER-->
				<div class="row">
					<div class="col-md-6">
						<h3 class="page-title">Help Desk</h3>
					</div>
					<div class="col-md-6">
						<?php echo '<span style="color:#900;">'.$this->session->flashdata('hd_successful').'</span>'; ?>
						<?php echo '<span style="color:#900;">'.$this->session->flashdata('hd_updated_successful').'</span>'; ?>
					</div>
				</div>
				<!-- END PAGE HEADER-->

				<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box green-haze">
							<div class="portlet-title">
								<div class="caption">
									<a data-toggle="modal" href="#addnew" type="button" class="btn btn-default btn-xs">
										<i class="fa fa-plus margin-right-10"></i>Add Help Desk
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
									<th>Name</th>
									<th>Actions</th>
								</tr>
								</thead>
								<tbody>
								<?php $i=0; foreach($help_desk as $row) {  $i++; ?>
								<tr>
									<td><?php echo $row['id'];?></td>
									<td><?php echo $row['name'];?></td>
									<?php if($row['active']==1) { ?>
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
										<div class="modal-dialog">
											<div class="modal-content">
											<form method="post" name="order_form" action="<?php echo base_url().index_page().'admin/home/help_desk_update/'.$row['id'];?>" id="order_form">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
													<h4 class="modal-title">Edit Help Desk</h4>
												</div>
												<div class="modal-body">																																		
													<div class="row">
														<div class="col-md-12">				
															<div class="form-group">
																<label class="margin-top-5">Name</label>
																<input type="text" class="form-control" name="name" value="<?php echo $row['name'];?>" required>
															</div>								  
															<div class="form-group">
																<label class="margin-top-5">D Name</label>
																<input type="text" class="form-control" name="d_name" value="<?php echo $row['d_name'];?>" required>
															</div>	
															<div class="form-group">
																<label class="margin-top-5">Team</label>
																<select class="form-control" name="team" required/>
																	<option>Select Team</option>
																	<?php foreach($teams as $row1){ ?>
																	<option value = "<?php echo($row1['id'])?>" <?php if($row1['id']==$row['team'])echo"selected"; ?> ><?php echo($row1['name']);?></option>
																	<?php } ?>
																</select>
															</div>	
															<div class="form-group">
																<label class="margin-top-5">Is active</label>
																<div class="clearfix">
																	<div class="btn-group" data-toggle="buttons">
																		<label class="btn btn-success <?php if($row['active']=='1')echo"active"; ?> margin-right-10">
																		<input type="radio" name="active" value="1" class="toggle"> Active </label>
																		<label class="btn btn-success <?php if($row['active']=='0')echo"active"; ?>">
																		<input type="radio" name="active" value="0" class="toggle" checked> In-Active </label>
																	</div>
																</div>
															</div>	
														</div>					
													</div>								
												</div>
												<div class="modal-footer">	
													<!--<button type="button" class="btn btn-primary">Update</button>-->
													<input class="btn btn-primary" type="submit" value="Update" id="submit_form"  />
													<button type="button" class="btn btn-success">Update and go back to list</button>	
													<button type="button" class="btn red-flamingo" data-dismiss="modal" aria-hidden="true">Cancel</button>
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
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="post" name="order_form" id="order_form">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Add Help Desk</h4>
			</div>
  	        <div class="modal-body">																																		
				<div class="row">
					<div class="col-md-12">				
						<div class="form-group">
							<label class="margin-top-5">Name</label>
							<input type="text" class="form-control" name="name" required/>
						</div>								  
						<div class="form-group">
							<label class="margin-top-5">D Name</label>
							<input type="text" class="form-control" name="d_name" required/>
						</div>	
						<div class="form-group">
							<label class="margin-top-5">Team</label>
							<select class="form-control" name="team" required/>
								<option>Select Team</option>
								<?php foreach($teams as $row1){ ?>
								<option value = "<?php echo($row1['id'])?>" ><?php echo($row1['name']); ?></option>
								<?php } ?>
							</select>
						</div>	
						<div class="form-group">
							<label class="margin-top-5">Is active</label>
							<div class="clearfix">
								<div class="btn-group" data-toggle="buttons">
									<label class="btn btn-success active margin-right-10">
									<input type="radio" name="active" class="toggle"> Active </label>
									<label class="btn btn-success">
									<input type="radio" name="active" class="toggle"> In-Active </label>
								</div>
							</div>
						</div>	
					</div>						
				</div>								
		    </div>
			<div class="modal-footer">	
				<!--<button type="button" class="btn btn-primary">Save</button>-->
				<input class="btn btn-primary" type="submit" value="Save" id="submit_form"  />
				<button type="button" class="btn btn-success">Save and go back to list</button>	
				<button type="button" class="btn red-flamingo">Cancel</button>
			</div>
			</form>
		</div>
	</div>
</div>	
	

	
	</div>
</div>
<?php $this->load->view("admin/foot1.php"); ?>