<?php
       $this->load->view("team-lead/head"); 
?>
<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<!-- BEGIN PAGE HEAD -->
	<!-- END PAGE HEAD -->
	<!-- BEGIN PAGE CONTENT -->
	<div class="page-content">
		<div class="container">
			<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">Modal title</h4>
						</div>
						<div class="modal-body">
							 Widget settings form goes here
						</div>
						<div class="modal-footer">
							<button type="button" class="btn blue">Save changes</button>
							<button type="button" class="btn default" data-dismiss="modal">Close</button>
						</div>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>
			<!-- /.modal -->
			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<!-- BEGIN PAGE BREADCRUMB -->
			<!-- END PAGE BREADCRUMB -->
			<!-- BEGIN PAGE CONTENT INNER -->
			<div class="row margin-top-10">
				<div class="col-md-12">
					<!-- BEGIN PROFILE SIDEBAR -->
					<div class="profile-sidebar" style="width: 250px;">
						<!-- PORTLET MAIN -->
						<div class="portlet light profile-sidebar-portlet">
							<!-- SIDEBAR USERPIC -->
							<div class="profile-userpic">
								<img src="<?php echo base_url() ?><?php echo $team[0]['image']; ?>" class="img-responsive" alt="">
							</div>
							<!-- END SIDEBAR USERPIC -->
							<!-- SIDEBAR USER TITLE -->
							<div class="profile-usertitle">
								<div class="profile-usertitle-name">
										<?php echo $team[0]['first_name'];?> <?php echo $team[0]['last_name'];?>
								</div>
								<div class="profile-usertitle-job">
									 TEAM LEAD
								</div>
							</div>
							<!-- END SIDEBAR USER TITLE -->
							<!-- SIDEBAR BUTTONS -->
							<!-- END SIDEBAR BUTTONS -->
							<!-- SIDEBAR MENU -->
							<div class="profile-usermenu">
								<ul class="nav">
									<li>
										<a href="<?php echo base_url().index_page()."team-lead/home/my_profile";?>">
										<i class="icon-home"></i>
										Overview </a>
									</li>
									<li class="active">
										<a href="<?php echo base_url().index_page()."team-lead/home/my_account";?>">
										<i class="icon-settings"></i>
										Account Settings </a>
									</li>
									<li>
										<a href="<?php echo base_url().index_page()."team-lead/home/add_designer";?>">
										<i class="icon-settings"></i>
										Add Designer </a>
									</li>
									<li>
										<a href="<?php echo base_url().index_page()."team-lead/home/help";?>">
										<i class="icon-info"></i>
										Help </a>
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
								<div class="portlet light">
									<div class="portlet-title tabbable-line">
										<div class="caption caption-md">
											<i class="icon-globe theme-font hide"></i>
											<span class="caption-subject font-blue-madison bold uppercase">Profile Account</span>
										</div>
										<ul class="nav nav-tabs">
											<li <?php if($tab=='1')echo'class="active"';?>>
												<a href="#tab_1_1" data-toggle="tab">Personal Info</a>
											</li>
											<li <?php if($tab=='2')echo'class="active"';?>>
												<a href="#tab_1_2" data-toggle="tab">Change Avatar</a>
											</li>
											<li <?php if($tab=='3')echo'class="active"';?>>
												<a href="#tab_1_3" data-toggle="tab">Change Password</a>
											</li>
											<li <?php if($tab=='4')echo'class="active"';?>>
												<a href="#tab_1_4" data-toggle="tab">Privacy Settings</a>
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
												<form role="form" Method="POST">
													<div class="form-group">
														<label class="control-label">Your Name</label>
														<input type="text" placeholder="<?php echo $team[0]['first_name']?>" name="first_name"  class="form-control"/>
														<input type="text" Hidden value="<?php echo $team[0]['id']?>" name="aid"  />
													</div>
													<div class="form-group">
														<label class="control-label">Last Name</label>
														<input type="text" placeholder="<?php echo $team[0]['last_name']?>" name="last_name" class="form-control"/>
													</div>
													<div class="form-group">
														<label class="control-label">Mobile Number</label>
														<input type="text" placeholder="<?php echo $team[0]['mobile_no']?>" name="mobile_no"  class="form-control"/>
													</div>
													<!--<div class="form-group">
														<label class="control-label">Interests</label>
														<input type="text" placeholder="Design, Web etc." class="form-control"/>
													</div>
													<div class="form-group">
														<label class="control-label">Occupation</label>
														<input type="text" placeholder="Web Developer" class="form-control"/>
													</div>
													<div class="form-group">
														<label class="control-label">About</label>
														<textarea class="form-control" rows="3" placeholder="We are KeenThemes!!!"></textarea>
													</div>
													<div class="form-group">
														<label class="control-label">Website Url</label>
														<input type="text" placeholder="http://www.mywebsite.com" class="form-control"/>
													</div>-->
													<div class="margiv-top-10">
														<button type="submit" name="personal_info"  class="btn green-haze">
														Save Changes </button>
														<a href="<?php echo base_url().index_page()."team-lead/home/my_account";?>" class="btn default">
														Cancel </a>
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
															<div class="fileinput-new thumbnail" style="width: 200px; height: 150px; line-height: 150px;">
																<img src="<?php echo base_url()?><?php echo $team[0]['image']; ?>">
															</div>
															<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
															</div>
															<div>
																<span class="btn btn-primary btn-file">
																<span class="fileinput-new">
																Select image </span>
																<span class="fileinput-exists">
																Change </span>
																<input type="file" name="file" id="file">
																</span>
																<input type="text" value=<?php echo $team[0]['id'];?> name="team_id" style="display:none">
																<button class="btn btn-primary btn-file" type="submit" name="remove_pic" >Remove</button>
																<!--<a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">
																Remove </a>-->
															</div>
														</div>
														<div class="clearfix margin-top-10">
															<span class="label label-danger">NOTE! </span>
															<span> Attached image thumbnail is supported in Latest Firefox, Chrome, Opera, Safari and Internet Explorer 10 only </span>
														</div>
													</div>
													<div class="margin-top-10">
														<button type="submit" name="change_avatar" class="btn green-haze">
														Submit </button>
														<a href="<?php echo base_url().index_page()."team-lead/home/my_account";?>" class="btn default">
														Cancel </a>
													</div>
												</form>
											</div>
											<!-- END CHANGE AVATAR TAB -->
											<!-- CHANGE PASSWORD TAB -->
											<div class="tab-pane <?php if($tab=='3')echo'active';?>" id="tab_1_3">
											 <form id="do-change" name="do-change" onsubmit="return check();" action="<?php echo base_url().index_page()."team-lead/home/dochange";?>" method="post">
											
													<div class="form-group">
														<label class="control-label">Current Password</label>
														<input type="password" class="form-control" required id="current_password" name="current_password"/>
													</div>
													<div class="form-group">
														<label class="control-label">New Password</label>
														<input type="password" class="form-control" id="pass1" required id="new_password" name="new_password"/>
													</div>
													<div class="form-group">
														<label class="control-label">Re-type New Password</label>
														<input type="password" class="form-control" id="pass2" required id="confirm_password" name="confirm_password" />
													</div>
													<div class="margin-top-10">
														<button type="submit"  class="btn green-haze">
														Change Password </button>
														<a href="<?php echo base_url().index_page()."team-lead/home/my_account";?>" class="btn default">
														Cancel </a>
													</div>
												</form>
											</div>
											<!-- END CHANGE PASSWORD TAB -->
											<!-- PRIVACY SETTINGS TAB -->
											<div class="tab-pane <?php if($tab=='4')echo'active';?>" id="tab_1_4">
												<form action="#">
													<table class="table table-light table-hover">
													<tr>
														<td>
															 Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus..
														</td>
														<td>
															<label class="uniform-inline">
															<input type="radio" name="optionsRadios1" value="option1"/>
															Yes </label>
															<label class="uniform-inline">
															<input type="radio" name="optionsRadios1" value="option2" checked/>
															No </label>
														</td>
													</tr>
													<tr>
														<td>
															 Enim eiusmod high life accusamus terry richardson ad squid wolf moon
														</td>
														<td>
															<label class="uniform-inline">
															<input type="checkbox" value=""/> Yes </label>
														</td>
													</tr>
													<tr>
														<td>
															 Enim eiusmod high life accusamus terry richardson ad squid wolf moon
														</td>
														<td>
															<label class="uniform-inline">
															<input type="checkbox" value=""/> Yes </label>
														</td>
													</tr>
													<tr>
														<td>
															 Enim eiusmod high life accusamus terry richardson ad squid wolf moon
														</td>
														<td>
															<label class="uniform-inline">
															<input type="checkbox" value=""/> Yes </label>
														</td>
													</tr>
													</table>
													<!--end profile-settings-->
													<div class="margin-top-10">
														<a href="#" class="btn green-haze">
														Save Changes </a>
														<a href="<?php echo base_url().index_page()."team-lead/home/my_account";?>" class="btn default">
														Cancel </a>
													</div>
												</form>
											</div>
											<!-- END PRIVACY SETTINGS TAB -->
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- END PROFILE CONTENT -->
				</div>
			</div>
			<!-- END PAGE CONTENT INNER -->
		</div>
	</div>
	<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->
<!-- BEGIN PRE-FOOTER -->
<!-- END PRE-FOOTER -->
<!-- BEGIN FOOTER -->
<?php
       $this->load->view("team-lead/foot"); 
?>