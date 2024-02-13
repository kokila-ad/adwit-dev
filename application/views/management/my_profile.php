<?php $this->load->view("management/head"); ?>
	
<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<!-- BEGIN PAGE HEAD -->
	<div class="page-content">
		<div class="container">
 
			<!-- BEGIN PAGE CONTENT INNER -->
			<div class="row margin-top-10">
				<div class="col-md-12">
					<!-- BEGIN PROFILE SIDEBAR -->
					<div class="profile-sidebar" style="width: 250px;">
						<!-- PORTLET MAIN -->
						<div class="portlet light profile-sidebar-portlet">
							<!-- SIDEBAR USERPIC -->
							<div class="profile-userpic">
								<img src="<?php echo base_url() ?><?php echo $management['image']; ?>" class="img-responsive" alt="">
							</div>
							<!-- END SIDEBAR USERPIC -->
							<!-- SIDEBAR USER TITLE -->
							<div class="profile-usertitle">
								<div class="profile-usertitle-name">
								<?php echo $management['first_name'];?>
								</div>
								<div class="profile-usertitle-job">Management</div>
							</div>
							<!-- END SIDEBAR USER TITLE -->
							<!-- SIDEBAR BUTTONS --
							<!-- END SIDEBAR BUTTONS -->
							<!-- SIDEBAR MENU -->
							<div class="profile-usermenu">
								<ul class="nav">
									<li>
										<a href="#"><i class="fa fa-home"></i>Overview </a>
									</li>
									<li class="active">
										<a href="<?php echo base_url().index_page()."management/home/my_profile";?>"><i class="fa fa-gear"></i>Account Settings </a>
									</li>
									<li>
										<a href="#"><i class="fa fa-info-circle"></i>Help </a>
									</li>
								</ul>
							</div>
							<!-- END MENU -->
						</div>
						<!-- END PORTLET MAIN -->
						<!-- PORTLET MAIN -->
						<!-- END PORTLET MAIN -->
					</div>
					<!-- END BEGIN PROFILE SIDEBAR -->
					<!-- BEGIN PROFILE CONTENT -->
					<div class="profile-content">
						<div class="row">
							<div class="col-md-12">
								<!-- BEGIN PORTLET -->
								<div class="portlet light">
									<div class="portlet-title tabbable-line">
										<div class="caption caption-md">
											<i class="icon-globe theme-font hide"></i>
											<span class="caption-subject font-blue-madison bold uppercase">Account Settings</span>
										</div>
										<ul class="nav nav-tabs">
											<li <?php if($tab=='1') echo'class="active"';?>>
												<a href="#tab_1_1" data-toggle="tab" aria-expanded="true">Personal Info</a>
											</li>
											<li <?php if($tab=='2')echo'class="active"';?>>
												<a href="#tab_1_2" data-toggle="tab" aria-expanded="false">Change Avatar</a>
											</li>
											<li <?php if($tab=='3')echo'class="active"';?>>
												<a href="#tab_1_3" data-toggle="tab" aria-expanded="false">Change Password</a>
											</li>
										</ul>
									</div>
									<div>
									<?php if(isset($error)): ?>
										<p class="msg" style="color:<?php echo $color;?>"><?php echo $error;?></p>
									<?php endif;?>
									</div>
									
									<div class="portlet-body">
										<div class="tab-content">
											<!-- PERSONAL INFO TAB -->
											<div class="tab-pane <?php if($tab=='1')echo'active';?>" id="tab_1_1">
												<form role="form" method="POST">
													<div class="form-group">
														<label class="control-label">Your Name</label>
														<input type="text" placeholder="<?php echo $management['first_name']?>" name="first_name" class="form-control">
														<input type="text" hidden="<?php echo $management['id']?>" value="1" name="mid">
													</div>
													<div class="form-group">
														<label class="control-label">Last Name</label>
														<input type="text" placeholder="<?php echo $management['last_name']?>" name="last_name" class="form-control">
													</div>
													<div class="form-group">
														<label class="control-label">Mobile Number</label>
														<input type="text" placeholder="<?php echo $management['mobile_no']?>" name="mobile_no" class="form-control">
													</div>
													<div class="margiv-top-10">
														<button type="submit" name="personal_info" class="btn green-haze">Save Changes </button>
														<a href="<?php echo base_url().index_page()."management/home/my_profile";?>" class="btn default">Cancel</a>
													</div>
												</form>
											</div>
											<!-- END PERSONAL INFO TAB -->
											<!-- CHANGE AVATAR TAB -->
											<div class="tab-pane <?php if($tab=='2')echo'active';?>" id="tab_1_2">
											<?php echo '<span style="color:red;">'.$this->session->flashdata('size_message').'</span>'; ?>
												<form role="form" method="POST" enctype="multipart/form-data">
													<div class="form-group">
														<div class="fileinput fileinput-new" data-provides="fileinput">
															<div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
																<img src="<?php echo base_url() ?><?php echo $management['image']; ?>">
															</div>
															<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
															</div>
															<div>
															<input type="text" Hidden value="<?php echo $management['id']?>" name="mid"  />
																<span class="btn btn-primary btn-file">
																<span class="fileinput-new">
																Select image </span>
																<span class="fileinput-exists">
																Change </span>
																<input type="file" name="file" id="file">
																</span>
																<input type="text" value=<?php echo $management['id'];?> name="management_id" style="display:none">
																<button class="btn btn-primary btn-file" type="submit" name="remove_pic" >Remove</button>
																<!--<a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">
																Remove </a>-->
															</div>
														</div>
														<!--<div class="clearfix margin-top-10">
															<span class="label label-danger">NOTE! </span>
															<span>Attached image thumbnail is supported in Latest Firefox, Chrome, Opera, Safari and Internet Explorer 10 only </span>
														</div>-->
													</div>
													<div class="margin-top-10">
														<button type="submit" name="change_avatar" class="btn green-haze">
														Submit </button>
														<a href="<?php echo base_url().index_page()."management/home/my_profile";?>" class="btn default">
														Cancel </a>
													</div>
												</form>
											</div>
											<!-- END CHANGE AVATAR TAB -->
											<!-- CHANGE PASSWORD TAB -->
											<div class="tab-pane <?php if($tab=='3')echo'active';?>" id="tab_1_3">
											<span style="color:darkred"><?php echo $this->session->flashdata('pwd_message').'<br/>'; ?></span>
											 <form id="do-change" name="do-change" onsubmit="return check();" action="<?php echo base_url().index_page()."management/home/dochange";?>" method="post">
											        <div class="form-group">
														<label class="control-label">Current Password</label>
														<input type="password" class="form-control" required id="current_password" name="current_password" autocomplete="off">
													</div>
													<div class="form-group">
														<label class="control-label">New Password</label>
														<input type="password" class="form-control" id="pass1" required id="new_password" name="new_password" autocomplete="off">
													</div>
													<div class="form-group">
														<label class="control-label">Re-type New Password</label>
														<input type="password" class="form-control" id="pass2" required id="confirm_password" name="confirm_password" autocomplete="off">
													</div>
													<div class="margin-top-10">
														<button type="submit" class="btn green-haze">
														Change Password </button>
														<a href="<?php echo base_url().index_page()."management/home/my_profile";?>" class="btn default">
														Cancel </a>
													</div>
											  </form>
											</div>
											<!-- END CHANGE PASSWORD TAB -->
										</div>
									</div>
								</div>
								<!-- END PORTLET -->
							</div>
						</div>
					</div>
					<!-- END PROFILE CONTENT -->
				</div>
			</div>
			<!-- END PAGE CONTENT INNER -->
		</div>
	</div>
</div>

<?php $this->load->view("management/foot"); ?>