<?php $this->load->view("admin/head1.php"); ?>
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
				<div class="portlet light">
					<div class="portlet-body">	
				<!-- BEGIN PAGE HEADER-->

				<!-- END PAGE HEADER-->
<?php echo '<h5 class="font-blue">'.$this->session->flashdata('message').'</h5>'; ?>
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box green-haze">
							<div class="portlet-title">
								<div class="caption">
									 Assign Designers
									 
								</div>
								<div class="tools margin-left-10">
									<a href="javascript:;" class="collapse">
									</a>
									<a href="javascript:;" class="reload">
									</a>
								</div>
							</div>
							<div class="portlet-body">
								<form method="post">
									<div class="row margin-top-15 margin-bottom-15">
										<div class="col-md-4  col-sm-6">
											<label>Designers</label>
											<select class="form-control" id="designer" name="designer" required>
												<option value=''>Select Designers</option>
												<?php foreach($designers as $row){ ?>
												<option value="<?php echo $row['id']; ?>"><?php echo $row['username']; ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-4  col-sm-6">
											<label>Team</label>
											<select class="form-control" id="team" name="team">
												<option value=''>Select Team</option>
													<?php foreach($teams as $row){ ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
													<?php } ?>
											</select>
										</div>
										<div class="col-md-4">
											<input type="submit" name="submit" value="Submit" class="btn btn-danger margin-top-25">
										</div>
									</div>
								</form>
							</div>
						</div>
					
				<div class="row">
					<div class="col-md-6  col-sm-6">
						<div class="portlet box green-haze">
							<div class="portlet-title">
								<div class="caption">
									Check by Team
								</div>
								<div class="tools margin-left-10">
									<a href="javascript:;" class="collapse">
									</a>
									<a href="javascript:;" class="reload">
									</a>
								</div>
							</div>
							<div class="portlet-body">
								<form method="post">
									<label class="margin-top-15">Team</label>
									<select class="form-control" id="team" name="team" required>
										<option value=''>Select</option>
										<?php foreach($teams as $row){ ?>
											<option value="<?php echo $row['id']; ?>" <?php if(isset($tId)&&($row['id']==$tId)){echo'selected';} ?>>
												<?php echo $row['name']; ?>
											</option>
										<?php } ?>
									</select>
									<input name="team_search" type="submit" value="Search" class="btn btn-danger margin-top-25">
								</form>
								<?php if(isset($list1)){ ?>
								<table class="table table-striped table-bordered table-hover margin-top-15">
									<thead>
										<tr>
											<th>Designer</th>
											<th>Team</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									<?php foreach($list1 as $row){ ?>
										<tr>
										<td>
											<?php 
												$designer_name = $this->db->get_where('designers',array('id' => $row['designer_id']))->result_array();
												echo $designer_name[0]['username']; 
											?>
										</td>
										<td>
											<?php 
												$team_name = 	$this->db->get_where('teams',array('id' => $row['team_id']))->result_array();
												echo $team_name[0]['name']; 
											?>
										</td>
										<td>
											<form method="post">
												<?php if(isset($tId)){ ?>
													<input name="tId" value="<?php echo $tId;?>" readonly style="display:none;" />
													<?php }elseif(isset($dId)){ ?>
													<input name="dId" value="<?php echo $dId;?>" readonly style="display:none;" />
													<?php } ?>
													<input name="id" value="<?php echo $row['id'];?>" readonly style="display:none;" />
													<button class="btn btn-outline btn-default margin-left-10" name="delete"><i class="fa fa-trash-o font-red"></i></button></td>
											</form>
										</tr>
									<?php } ?>
									</tbody>
								</table>
								<?php } ?>
							</div>
						</div>
					</div>	
					<div class="col-md-6  col-sm-6">
						<div class="portlet box green-haze">
							<div class="portlet-title">
								<div class="caption">
									Check by Designer
								</div>
								<div class="tools margin-left-10">
									<a href="javascript:;" class="collapse">
									</a>
									<a href="javascript:;" class="reload">
									</a>
								</div>
							</div>
							<div class="portlet-body">
								<form method="post">
									<label class="margin-top-15">Designers</label>
									<select class="form-control" id="designer" name="designer">
										<option value=''>Select</option>
									<?php foreach($designers as $row){ ?>
											<option value="<?php echo $row['id']; ?>" <?php if(isset($dId)&&($row['id']==$dId)){echo'selected';} ?>>
											<?php echo $row['username']; ?>
											</option>
									<?php } ?>
									</select>
									<input name="designer_search" type="submit" value="Search" class="btn btn-danger margin-top-25">
								</form>
								<?php if(isset($list2)){ ?>
								<table class="table table-striped table-bordered table-hover margin-top-15">
									<thead>
										<tr>
											<th>Designer</th>
											<th>Team</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									<?php foreach($list2 as $row){ ?>
										<tr>
											<td>
											<?php 
												$designer_name = $this->db->get_where('designers',array('id' => $row['designer_id']))->result_array();
												echo $designer_name[0]['username']; 
											?>
										</td>
										<td>
											<?php 
												$team_name = 	$this->db->get_where('teams',array('id' => $row['team_id']))->result_array();
												if($row['team_id']==0){ echo "" ;} else { echo $team_name[0]['name']; } 
											?>
										</td>
										<td>
											<form method="post">
												<?php if(isset($tId)){ ?>
													<input name="tId" value="<?php echo $tId;?>" readonly style="display:none;" />
													<?php }elseif(isset($dId)){ ?>
													<input name="dId" value="<?php echo $dId;?>" readonly style="display:none;" />
													<?php } ?>
													<input name="id" value="<?php echo $row['id'];?>" readonly style="display:none;" />
													<button class="btn btn-outline btn-default margin-left-10" name="delete"><i class="fa fa-trash-o font-red"></i></button></td>
											</form>
										</tr>
									</tbody>
									<?php } ?>
								</table>
								<?php } ?>
							</div>
						</div>
						
				</div>
				<!-- END EXAMPLE TABLE PORTLET-->
						
				</div>
		
				</div>
			</div>
		<!-- END CONTENT -->
	</div>
	<!-- END CONTAINER -->
	
	</div>
</div>
	<?php $this->load->view("admin/foot1.php"); ?>