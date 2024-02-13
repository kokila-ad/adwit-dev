<?php $this->load->view("admin/head1");?>
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
				<div class="portlet">
					<div class="portlet-body">	
					<div class="row">
					<div class="col-md-6">
						<h3 class="page-title">Profile</h3>
					</div>
					<div class="col-md-6">
						<?php echo '<span style="color:red;">'.$this->session->flashdata('size_message').'</span>'; ?>
					</div>
				</div>
								<div class="row">
									<div class="col-md-3 col-sm-6 col-xs-12">
										<div class="portlet light ">
											<div class="portlet-body">
												<div class="row">	
													<div class="portlet light profile-sidebar-portlet margin-0">													
														<div class="profile-userpic">
															<img src="<?php echo base_url() ?><?php echo $admin_users[0]['image_path']; ?>" class="img-responsive" alt="">
															<p class="text-center margin-top-5"><small>
																<a data-toggle="modal" href="#profilepic" ><i class="fa fa-edit"></i>Change Pic</a>
															</small></p>
														</div>															
														<div class="profile-usertitle">
															<div class="profile-usertitle-name">
																 <?php echo $admin_users[0]['first_name'];?>
															</div>
															<div class="profile-usertitle-job">
																 Admin
															</div>
														</div>	
													</div>	
												</div>
											</div>
										</div>
									</div>
									
									<div class="col-md-4 col-sm-6 col-xs-12">
										<div class="portlet light">
											<div class="portlet-title">
												<div class="caption">Basic Information</div>
											</div>
											<div class="portlet-body">
												<div class="row form-group">
													<label class="col-md-6 margin-top-5">Name</label>
													<label class="col-md-6 margin-top-5"> <?php echo $admin_users[0]['first_name'];?></label>
												</div>
												
												<div class="row form-group">
													<label class="col-md-6 margin-top-5">UserName</label>
													<label class="col-md-6 margin-top-5"> <?php echo $admin_users[0]['username'];?></label>
												</div>
												
												<div class="row form-group">
													<label class="col-md-6 margin-top-5">Gender</label>
													<label class="col-md-6 margin-top-5">Male</label>
												</div>
												
												<div class="row form-group margin-bottom-40">
													<label class="col-md-6 margin-top-5">Email Id</label>
													<label class="col-md-6 margin-top-5"> <?php echo $admin_users[0]['email_id'];?></label>
												</div>
													
											</div>
										</div>
									</div>
									
									<div class="col-md-5 col-sm-6 col-xs-12">
									<?php if(isset($error)): ?>
										<p class="msg" style="color:<?php echo $color;?>"><?php echo $error;?></p>
									<?php endif;?>
										<div class="portlet light ">
											<div class="portlet-title">
												<div class="caption">Change Password</div>
											</div>
											<form id="do-change" action="<?php echo base_url().index_page()."admin/home/dochange";?>" method="post">
											<div class="portlet-body">
												<div class="row form-group">
													<label class="col-md-5 margin-top-5">Current Password</label>
													<div class="col-md-7">
														<input type="password" class="form-control" placeholder="Current Password" required id="current_password" name="current_password">
													</div>
												</div>
												
												<div class="row form-group margin-bottom-20">
													<label class="col-md-5 margin-top-5">New Password</label>
													<div class="col-md-7">
														<input type="password" class="form-control" placeholder="New Password" required id="new_password" name="new_password">
													</div>
												</div>
												
												<div class="row form-group">
													<label class="col-md-5 margin-top-5">Confirm Password</label>
													<div class="col-md-7">
														<input type="password" class="form-control" placeholder="Confirm Password" required id="confirm_password" name="confirm_password">
														
														<button type="submit" class="btn btn-danger pull-right margin-top-20">Submit</button>
													</div>
												</div>
											</div>
											</form>
										</div>
									</div>
									


								</div>
							</div>
					</div>
				</div>
			</div>
		<!-- END CONTENT -->

<div id="profilepic" class="modal fade" tabindex="-1" data-width="760">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Change Profile Pic</h4>
			</div>
			<form role="form" method="POST" enctype="multipart/form-data" action="<?php echo base_url().index_page()."admin/home/change_profile";?>">
			 
			 <div class="modal-body">
				<div class="fileinput fileinput-new" data-provides="fileinput">
					<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 150px; height: 150px; line-height: 150px;">
					<img src="<?php echo base_url() ?><?php echo $admin_users[0]['image_path']; ?>">
					</div>
					<div>
						<span class="btn btn-primary btn-file">
						<span class="fileinput-new  margin-top-10">
						Select image </span>
						<span class="fileinput-exists  margin-top-10">
						Change </span>
						<input type="file" name="file">
						</span>
						
						<button class="btn red fileinput-exists" data-dismiss="fileinput" type="submit" name="remove_pic" >Remove</button>
						<!--<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput">
						 Remove </a>-->
					</div>
				</div>								
			 </div>
			 <div class="modal-footer">	
				<input type="text" value=<?php echo $admin_users[0]['id'];?> name="admin_id" style="display:none">
				<button type="submit" name="change_avatar" class="btn green-haze">
				Submit </button>
				<a href="<?php echo base_url().index_page()."admin/home/change";?>" class="btn default">
				Cancel </a>
			</div>
			</form> 
		</div>
	</div>
</div>	
		
		
		
		</div>
	</div>
	<!-- END CONTAINER -->
	
	</div>
</div>
	<?php $this->load->view("admin/foot1");?>