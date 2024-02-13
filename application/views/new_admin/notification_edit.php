<?php $this->load->view("new_admin/header");?>
<?php $this->load->view("new_admin/datepicker");?>

		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
				<div class="portlet light">
					<div class="portlet-body">	
				<!-- BEGIN PAGE HEADER-->
				<h3 class="page-title">Edit Notification</h3>
				<hr>
				<!-- END PAGE HEADER-->
							<div class="prolet-body">
								<div class="row">
								<form method="post" name="order_form" id="order_form">
									<div class="col-md-6">
										<div class="col-md-12">
											<div class="form-group">
												<label class="margin-top-5">Headline</label>
												<input type="text" class="form-control" name="headline" value="<?php echo $row['headline'];?>">
											</div>
										</div>
										<div class="col-md-12">	
											<div class="form-group">
												<label class="margin-top-5">Message</label>																
													<textarea class="ckeditor form-control" name="message" rows="6" ><?php echo $row['message'];?></textarea>
											</div>
										</div>
									</div>	
									<div class="col-md-6">
										<div class="col-md-12">
											<div class="form-group">
												<label class="margin-top-5">Users</label>
												<select class="form-control" name="users">
													<option>Select Users</option>
													<?php foreach($adwit_users as $user_row){ ?>
													<option value = "<?php echo($user_row['id'])?>" <?php if($user_row['id']==$row['users'])echo"selected"; ?> ><?php echo $user_row['name'];?></option>
													<?php } ?>
												</select>
											</div>						  
										
											<div class="form-group">
												<label class="margin-top-5">Job Status</label>
												<div class="clearfix">
													<div class="btn-group" data-toggle="buttons">
														<label class="btn btn-success <?php if($row['job_status']=='1')echo"active"; ?>  margin-right-10">
														<input type="radio" name="job_status" value="1" class="toggle"<?php if($row['job_status']=='1')echo"checked"; ?>/> Active </label>
														<label class="btn btn-success <?php if($row['job_status']=='0')echo"active"; ?>">
														<input type="radio" name="job_status" value="0" class="toggle"<?php if($row['job_status']=='0')echo"checked"; ?>/> In-Active </label>
													</div>
												</div>
											</div>						  
										
											<div class="form-group">
												<label class="margin-top-5">Start Date</label>
												<div class="input-group date date-picker margin-bottom-5" data-date-format="yyyy/mm/dd">
													<input type="text" class="form-control form-filter" placeholder="YYYY-MM-DD" name="start_date" value="<?php echo $row['start_date'];?>">
													<span class="input-group-btn">
													<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
													</span>
												</div>
											</div>						  
										
											<div class="form-group">
												<label class="margin-top-5">End Date</label>
												<div class="input-group date date-picker margin-bottom-5" data-date-format="yyyy/mm/dd">
													<input type="text" class="form-control form-filter" placeholder="YYYY-MM-DD" name="end_date" value="<?php echo $row['start_date'];?>">
													<span class="input-group-btn">
													<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
													</span>
												</div>
											</div>	

											<hr>
											<div class="pull-right">
												<!--<button type="button" class="btn btn-primary">Update</button>-->
												<a href="<?php echo base_url().index_page()."new_admin/home/notification_list";?>" type="button" class="btn red-flamingo">Back</a>
												<input class="btn btn-primary" type="submit" value="Update" id="submit_form"  />
												<!--<button type="button" class="btn btn-success"> Update and go back to list</button>-->
											
											</div>

										</div>
												
									</div>	
								</form>
								</div>		
							</div>
				</div>
				</div>
			</div>
		<!-- END CONTENT -->
	</div>
	<!-- END CONTAINER -->
</div>
	</div>
</div>
<?php $this->load->view("new_admin/footer");?>
<?php $this->load->view("new_admin/datatable");?>