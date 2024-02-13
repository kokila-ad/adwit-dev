<?php $this->load->view('new_admin/header')?>
				
<script>
	 $(document).ready(function(){
	  $("#show_password").hide();
	  $('#submit_form').hide();
	  $('#email').hide();
	  $('#name').hide();
	  
	  $("#form").click(function(){$("#submit_form").show(); });
	  $("#edit_email").click(function(){ $("#email").toggle(); });
	  
	   $("#form").click(function(){$("#submit_form").show(); });
	  $("#edit_name").click(function(){ $("#name").toggle(); });
	  
		$("#password").click(function(){
			$("#show_password").show();
			$("#password_focus").focus();
			$("#password").hide();
		});
		$("#close_password").click(function(){
			$("#show_password").hide();
			$("#password").show();
		});
	 });
 </script>



<div class="portlet light">
	<div class="row margin-bottom-5">	
		<div class="col-md-7 col-xs-12">
			<a href="<?php echo base_url().index_page().'new_admin/home/manage'?>" class="font-lg">Manage</a> - 
			<a href="<?php echo base_url().index_page().'new_admin/home/admin'?>" class="font-lg font-grey-gallery"><u>Admin</u></a>									
		</div>		
		<div class="col-md-4 col-xs-8">
			<?php if(null != $this->session->flashdata('message')){ ?>						
				<div class="alert alert-success margin-0 padding-5 small"><?php echo $this->session->flashdata('message'); ?></div>
			<?php } ?>
		</div>
		<div class="col-md-1 col-xs-12 text-right">	
			<span class=" cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
		</div>									
	</div>
	<div class="portlet-body border-top margin-bottom-10">
		<div class="row">  
		<form method="post" name="order_form" id="order_form">
			<div class="col-md-7 col-sm-7 margin-top-10 margin-bottom-15">
				<div class="">
					<div class="row color">
						<div class="col-md-3 col-sm-4 col-xs-6">
							<img id="profile_img" src="<?php echo $admin_user[0]['image_path'];?>" width="150px" height="150px">	
						</div>
						<div class="col-md-9 col-sm-8 col-xs-12">
						   <div class="row padding-bottom-5">
							  <span class="font-hg col-xs-12"><?php echo $admin_user[0]['first_name'].' '.$admin_user[0]['last_name'];?> <i class="fa fa-pencil" id="edit_name"></i></span>
							  
						    <div id="name" class="row margin-0 margin-bottom-10">
								<div class="col-md-4 padding-right-0 margin-top-5"><input type = "text" name="first_name" class="form-control input-sm" placeholder="First name"></div>
								<div class="col-md-4 padding-right-0 margin-top-5"><input type = "text" name="last_name" class="form-control input-sm" placeholder="Last name"></div>
								<div class="col-md-12 margin-top-5"><input type="submit" name="name_submit" class="btn btn-sm btn-primary"></div>
							</div>
						    <span class="col-xs-12 margin-0 margin-top-5"><?php echo $admin_user[0]['email_id'];?> <i class="fa fa-pencil" id="edit_email"></i></span>
						     <div id="email" class="row margin-0 margin-bottom-10">
								<div class="col-md-6 padding-right-0 margin-top-5"><input type = "email" name="email_id" class="form-control input-sm" placeholder="Enter Email address"></div>
								<div class="col-md-12 margin-top-5"><input type="submit" name="email_submit" class="btn btn-sm btn-primary"></div>
							</div>
						   </div>
						</div>
					</div>
				</div>
			</div>	

			<div class="col-md-5 col-sm-5 margin-0">
				<div class="row border-bottom margin-0">
					<div class="col-md-6 col-xs-6 padding-10 padding-right-0">Username</div>
					<div class="col-md-6 col-xs-6 padding-vertical-10 padding-0 text-grey capitalize"><?php if($admin_user[0]['username']!='') echo $admin_user[0]['username']; else echo "-";?></div>
				</div>
				
				<div class="row border-bottom margin-0">
					<div class="col-md-6 col-xs-6 padding-10 padding-right-0">Account Activated On</div>
					<div class="col-md-6 col-xs-6 padding-vertical-10 padding-0 text-grey">
						<?php if($admin_user[0]['created_on']!='')echo date('M d, Y H:i:s',strtotime($admin_user[0]['created_on'])); else echo"-";?>
					</div>
				</div>
				<div class="row border-bottom margin-0">
					<div class="col-md-6 col-xs-6 padding-10 padding-right-0">Reports</div>
					<div class="col-md-6 col-xs-6 padding-vertical-10 padding-0 text-grey">
						<button class="btn bg-grey-gallery btn-xs">Click Here</button>
					</div>
				</div>		
			</div>
			</form>
		</div>
	</div>
</div>


<div class="portlet light">
	<form method="post" name="order_form" id="order_form">
	<div class="row">
		
		<div class="col-sm-6 text-right">
			<button  id="submit_form" type="submit" name="Save" class="btn btn-xs btn-primary margin-left-10">Save Changes</button>
		</div>
	</div>
	</form>
	
	<div class="row margin-top-10">    
		<div class="col-md-12 font-grey-gallery text-right font-sm cursor-pointer" id="password">Change password</div>
		<div class="col-md-12" id="show_password" style="display: none;">
			 <form method="post">
				<div class="row margin-top-10">
					<div class="col-md-5 col-md-offset-7 col-xs-12">
						<div class="input-group">
							<div class="input-icon">
								<input type="password" id="newpassword" name="newpassword" class="form-control input-sm" required="">
							</div>
							<span class="input-group-btn">
							<button id="genpassword" class="btn btn-dark btn-sm" type="button"> Password</button>
							</span>
						</div>
						<div class="margin-top-5 small text-right">
							<div class="checker"><span class="checked"><input type="checkbox" checked=""></span></div> Send the new user an email about their account.
						</div>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12 text-right margin-vertical-10">
						 <button type="submit" name="pwd_submit" class="btn smedium padding-vertical-5 btn-primary btn-sm">Submit</button>
						 <button id="close_password" type="button" class="btn smedium padding-vertical-5 btn-danger btn-sm">Cancel</button>
					 </div>
				</div> 
			  </form>
		  </div> 
		</div>
</div>


<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/foot.php'); ?>