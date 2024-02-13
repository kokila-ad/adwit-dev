<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('designer_view/header'); ?>
<style>
	.bg-search {
    color: #ccc !important;
    background-color: #38414c;
    border-right: 1px solid #444d58;
}
.thumbnail>img{
	height: 100% !important;
}

</style>

<div class="page-container">
	<div class="page-content">
		<div class="container">
			<div class="row margin-top-10">
				<div class="col-md-12">
					<div class="profile-sidebar" style="width: 250px;">
						<div class="portlet light profile-sidebar-portlet">
							<div class="profile-userpic">
								<img src="<?php echo base_url() ?><?php echo $acc_name[0]['image']; ?>" class="img-responsive" alt="">
							</div>
							<div class="profile-usertitle">
								<div class="profile-usertitle-name"> 
									<span><?php echo $acc_name[0]['first_name'].$acc_name[0]['last_name']; ?></span>
								</div>
								<div class="profile-usertitle-job">
									Production
								</div>
							</div>
							<div class="profile-usermenu">
								<ul class="nav">
									<li class="active">
										<a href="">
										<i class="icon-home"></i>
										Overview </a>
									</li>
									<li>
										<a href="">
										<i class="icon-settings"></i>
										Account Settings </a>
									</li>
									<li>
										<a href="">
										<i class="icon-info"></i>
										Help </a>
									</li>
								
								</ul>
							</div>
						</div>
					</div>
					<div class="profile-content">
						<div class="row">
							<div class="col-md-12">
								<div class="portlet light">
								<div>
								</div>	
								<div class="portlet-body">
									<div class="profile-content">
										<div class="row">
											<div class="col-md-12">
												<div class="portlet light">
													<div class="portlet-title tabbable-line">
														<div class="caption caption-md">
															<i class="icon-globe theme-font hide"></i>
															<span class="caption-subject font-blue-madison bold uppercase">
																Profile Account
															</span>
														</div>
														<ul class="nav nav-tabs">
															<li class="active">
																<a href="#tab_1_1" data-toggle="tab">Personal Info</a>
															</li>
															<li >
																<a href="#tab_1_2" data-toggle="tab">Change Avatar</a>
															</li>
															<li >
																<a href="#tab_1_3" data-toggle="tab">Change Password</a>
															</li>
														</ul>
													</div>
													<div>
													</div>
													<div class="portlet-body">
														<div class="tab-content">
															<div class="tab-pane active" id="tab_1_1">
																<form role="form" method="post">
																	<div class="form-group">
																		<label class="control-label">First Name</label>
																		<input type="text" name="first_name" placeholder="<?php echo $acc_name[0]['first_name']; ?>" class="form-control"  />
																	</div>
																	<div class="form-group">
																		<label class="control-label">Last Name</label>
																		<input type="text" name="last_name" placeholder="<?php echo $acc_name[0]['last_name']; ?>" class="form-control"  />
																	</div>
																	<div class="form-group">
																		<label class="control-label">Email ID</label>
																		<input type="email_id" name="email_id" placeholder="<?php echo $acc_name[0]['email']; ?>"  class="form-control"  />
																	</div>
																	<div class="margiv-top-10">
																		<button type="submit" name="submit"class="btn green-haze">
																				Save Changes </button>
																		<a href="<?php echo base_url().index_page()."Designer_Home/profile";?>" class="btn default">
																		Cancel </a>
																	</div>
																</form>
															</div>

															 <div class="tab-pane " id="tab_1_2">
																<span style="color:red;"></span>
																<form role="form" method="post" enctype="multipart/form-data">
																	<div class="form-group">
																		<div class="fileinput fileinput-new" data-provides="fileinput">
																			<div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
																				<img src="<?php echo base_url() ?><?php echo $acc_name[0]['image']; ?>" alt="">
																			</div>
																			<div>
																				<span class="btn default btn-file">
																					<span class="fileinput-new">Select image</span>
																					<span class="fileinput-exists">change</span>
																				     <input type="file" name="file" >
																				</span>
																				<input type="text" value=<?php echo $acc_name[0]['id'];?> name="id" style="display:none">
																				<button class="btn default fileinput-exists" data-dismiss="fileinput" type="submit" name="remove_pic">Remove</button>
																			</div>
							
                                                            			</div>
																	</div>
																	<div class="margin-top-10">
																		<button type="submit" name="change_avatar" class="btn green-haze">Submit </button>	
																		<a href="<?php echo base_url().index_page()."Designer_Home/profile";?>" class="btn default">Cancel </a>
																	</div>
																</form>
															</div> 
															<div class="tab-pane " id="tab_1_3">
																<span style="color:darkred"><br/></span>
																<form id="do-change" name="do-change" method="post">
																	<div class="form-group">
																		<label class="control-label">Current Password</label>
																		<input type="password" class="form-control" required id="current_password" name="current_password"/>
																	</div>
																	<div class="form-group">
																		<label class="control-label">New Password</label>
																		<input type="password" class="form-control" required id="new_password" name="new_password"/>
																	</div>
																	<div class="form-group">
																		<label class="control-label">Re-type New Password</label>
																		<input type="password" class="form-control" required id="confirm_password" name="confirm_password"/>
																	</div>
																	<div>
																		<button type="submit" class="btn green-haze" name="submit_pwd">Change Password </button>
																		<a href="<?php echo base_url().index_page()."Designer_Home/profile";?>" class="btn default">Cancel </a>
																	</div>
																</form>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<?php $this->load->view('designer_view/footer');?>