<?php $this->load->view("new_csr/head.php"); ?>

<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
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
								<img src="<?php echo base_url() ?><?php echo $csr_name[0]['image_path']; ?>" class="img-responsive" alt="">
							</div>
							<!-- END SIDEBAR USERPIC -->
							<!-- SIDEBAR USER TITLE -->
							<div class="profile-usertitle">
								<div class="profile-usertitle-name">
									<?php echo $csr_name[0]['name'];?>
								</div>
								<div class="profile-usertitle-job">
									 <?php $csr_role = $this->db->query("SELECT * FROM `csr_role` WHERE `id` = '".$csr_name[0]['csr_role']."'")->result_array();
										 if(isset($csr_role[0]['id'])){
											echo $csr_role[0]['name'];
										 } ?>
								</div>
							</div>
							<!-- END SIDEBAR USER TITLE -->
							<!-- SIDEBAR BUTTONS -->
							<!-- END SIDEBAR BUTTONS -->
							<!-- SIDEBAR MENU -->
							<div class="profile-usermenu">
								<ul class="nav">
									<li>
										<a href="<?php echo base_url().index_page()."new_csr/home/my_profile";?>">
										<i class="icon-home"></i>
										Overview </a>
									</li>
									<li class="active">
										<a href="<?php echo base_url().index_page()."new_csr/home/my_account";?>">
										<i class="icon-settings"></i>
										Account Settings </a>
									</li>
									<!--<li>
										<a href="<?php echo base_url().index_page()."new_csr/home/assign_designer";?>">
										<i class="icon-settings"></i>
										Assign Designer </a>
									</li>-->
									<!--
									<?php if($csr_name[0]['csr_role'] != '3'){ ?>
									<li>
										<a href="<?php echo base_url().index_page()."new_csr/home/reports";?>">
										<i class="icon-settings"></i>
										Reports </a>
									</li><?php } ?>
									<?php if($csr_name[0]['csr_role'] == '3'){ ?>
									<li>
										<a href="<?php echo base_url().index_page()."new_csr/home/csr_reports";?>">
										<i class="icon-settings"></i>
										Reports </a>
									</li><?php } ?>
									-->
									<li>
										<a href="<?php echo base_url().index_page()."new_csr/home/help";?>">
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
											<span class="caption-subject font-blue-madison bold uppercase">Your Profile</span>
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
												<a href="#tab_1_4" data-toggle="tab">Settings</a>
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
										<?php echo '<span style="color:#900;">'.$this->session->flashdata('personal_message').'</span>'; ?>
											<!-- PERSONAL INFO TAB -->
											<div class="tab-pane <?php if($tab=='1')echo'active';?>" id="tab_1_1">
												<div class="form-group">
													<label class="control-label"><b>Email:</b> <?php echo $csr_name[0]['email_id'];?></label>
												</div>
												<div class="form-group">
													<?php if($csr_name[0]['Work_location'] != '0'){
														$location = $this->db->query("SELECT `id`,`name` FROM `location` WHERE `id` = '".$csr_name[0]['Work_location']."'")->result_array();} ?>
													<label class="control-label"><b>Working Location:</b> <?php if(isset($location[0]['id'])){ echo $location[0]['name']; }?></label>
												</div>
												<div class="form-group">
													<label class="control-label"><b>Gender:</b> <?php if($csr_name[0]['gender'] == '1'){ echo "Male"; } else { echo "Female"; }?></label>
												</div>
												<div class="form-group">
													<label class="control-label"><b>Username:</b> <?php echo $csr_name[0]['username'];?></label>
												</div>
												<div class="form-group">
													<label class="control-label"><b>Mobile Number:</b> <?php echo $csr_name[0]['mobile_no'];?></label>
												</div>
												<?php if(isset($assigned_pub)){ ?>
												<div class="form-group">
													<label class="control-label"><b>Assigned Publications:</b> <?php echo $assigned_pub;?></label>
												</div>
												<?php } ?>
											</div>
											<!-- END PERSONAL INFO TAB -->
											<!-- CHANGE AVATAR TAB -->
											<div class="tab-pane <?php if($tab=='2')echo'active';?>" id="tab_1_2">	
											<?php echo '<span style="color:red;">'.$this->session->flashdata('size_message').'</span>'; ?>
												<form role="form" method="POST" enctype="multipart/form-data">
													<div class="form-group">
														<div class="fileinput fileinput-new" data-provides="fileinput">
														 <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 150px; height: 150px; line-height: 150px;">
															<img src="<?php echo base_url() ?><?php echo $csr_name[0]['image_path']; ?>">
														 </div>
														 
														 <div>
														  <span class="btn btn-primary btn-file">
														  <span class="fileinput-new  margin-top-10">
														  Select image </span>
														  <span class="fileinput-exists  margin-top-10">
														  Change </span>
														  <input type="file" name="file">
														  </span>
														  <input type="text" value=<?php echo $csr_name[0]['id'];?> name="csr_id" style="display:none">
														  <button class="btn btn-danger btn-file" type="submit" name="remove_pic" >Remove</button>
														  <!--<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput">
														  Remove </a>-->
														 </div>
														</div>
	
	
														<!--<div class="clearfix margin-top-10">
															<span class="label label-danger">NOTE : Attached image thumbnail is supported in Latest Firefox, Chrome, Opera, Safari and Internet Explorer 10 only</span>
														</div>-->
													</div>
													<div class="margin-top-10">
														<button type="submit" name="change_avatar" class="btn green-haze">
														Submit </button>
														<a href="<?php echo base_url().index_page()."new_csr/home/my_account";?>" class="btn default">
														Cancel </a>
													</div>
												</form>
											</div>
											<!-- END CHANGE AVATAR TAB -->
											<!-- CHANGE PASSWORD TAB -->
											<div class="tab-pane <?php if($tab=='3')echo'active';?>" id="tab_1_3">
												<span style="color:darkred"><?php echo $this->session->flashdata('pwd_message').'<br/>'; ?></span>
												<form id="do-change" name="do-change" action="<?php echo base_url().index_page()."new_csr/home/dochange";?>" method="post">
													<div class="form-group">
														<label class="control-label">Current Password</label>
														<input type="password" class="form-control" required id="current_password" name="current_password"/>
													</div>
													<div class="form-group">
														<label class="control-label">New Password</label>
														<input type="password" class="form-control"  required id="new_password" name="new_password"/>
														<span id="pwd-msg">(Minimum 1 uppercase, 1 digit & 8 words)</span>
													</div>
													<div class="form-group">
														<label class="control-label">Re-type New Password</label>
														<input type="password" class="form-control" required id="confirm_password" name="confirm_password" />
													</div>
													<div class="margin-top-10">
														<button type="submit" class="btn green-haze">
														Change Password </button>
														<a href="<?php echo base_url().index_page()."new_csr/home/my_account";?>" class="btn default">
														Cancel </a>
													</div>
												</form>
											</div>
											<!-- END CHANGE PASSWORD TAB -->
											<!-- PRIVACY SETTINGS TAB -->
											<div class="tab-pane" id="tab_1_4">
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
														<a href="<?php echo base_url().index_page()."new_csr/home/my_account";?>" class="btn default">
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
<?php $this->load->view("new_csr/foot.php"); ?>
<script>
$(document).ready(function(){
	console.log('ready');
	$("#new_password").blur(function(){ 
		var text = $(this).val();
		var r = text.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/);
		if(!r){
			console.log(r+' - no match');
			$('#pwd-msg').css({"color":"red"});
			$(this).val('');
		}else{
			$('#pwd-msg').css({"color":""});
		}
		
	});
});

</script>