<?php $this->load->view("admin/head1.php");?>
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
				<div class="portlet light">
					<div class="portlet-body">	
				<!-- BEGIN PAGE HEADER-->
				<h3 class="page-title">Add Notification</h3>
				<hr>
				<!-- END PAGE HEADER-->
							<div class="prolet-body">
								<div class="row">
								<form method="post" name="order_form" id="order_form">
									<div class="col-md-6">
									<?php echo '<span style="color:#900;">'.$this->session->flashdata('Notification_successful').'</span>'; ?>
									<?php echo '<span style="color:#900;">'.$this->session->flashdata('Notification_updated_successful').'</span>'; ?>
										<div class="col-md-12">
											<div class="form-group">
												<label class="margin-top-5">Headline</label><span class="mandatory font-red">*</span>
												<input type="text" class="form-control" name="headline" required/>
											</div>
										</div>
										<div class="col-md-12">	
											<div class="form-group">
												<label class="margin-top-5">Message</label><span class="mandatory font-red">*</span>														
													<textarea class="ckeditor form-control" name="message" rows="6" required></textarea>
											</div>
										</div>
									</div>	
									<div class="col-md-6">
										<div class="col-md-12">
											<div class="form-group">
												<label class="margin-top-5">Users</label><span class="mandatory font-red">*</span>
												<select class="form-control" name="users" required/>
													<option value="">Select Users</option>
													<?php foreach($adwit_users as $row1) { ?>
													<option value="<?php echo $row1['id'] ;?>"><?php echo $row1['name'] ;?></option>
													<?php } ?>
												</select>
											</div>						  
										
											<div class="form-group">
												<label class="margin-top-5">Job Status</label>
												<div class="clearfix">
													<div class="btn-group" data-toggle="buttons">
														<label class="btn btn-success active margin-right-10">
														<input type="radio" name="job_status" value="1" class="toggle"> Active </label>
														<label class="btn btn-success">
														<input type="radio" name="job_status" value="0" class="toggle"> In-Active </label>
													</div>
												</div>
											</div>						  
										
											<div class="form-group">
												<label class="margin-top-5">Start Date</label>
												<div class="input-group date date-picker margin-bottom-5" data-date-format="yyyy/mm/dd">
													<input type="text" class="form-control form-filter" placeholder="YYYY-MM-DD" name="start_date">
													<span class="input-group-btn">
													<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
													</span>
												</div>
											</div>					  
										
											<div class="form-group">
												<label class="margin-top-5">End Date</label>
												<div class="input-group date date-picker margin-bottom-5" data-date-format="yyyy/mm/dd">
													<input type="text" class="form-control form-filter" placeholder="YYYY-MM-DD" name="end_date">
													<span class="input-group-btn">
													<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
													</span>
												</div>
											</div>	

											<hr>
											<div class="pull-right">
												<!--<button type="button" class="btn btn-primary">Save</button>-->
													<a href="<?php echo base_url().index_page()."admin/home/notification_list";?>" type="button" class="btn red-flamingo">Back</a>
												<input class="btn btn-primary" type="submit" value="Create" id="submit_form"  />
												<!--<button type="submit" name="submit" class="btn btn-success"> Save and go back to list</button>-->
											
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
<?php $this->load->view("admin/foot1.php");?>