<?php $this->load->view('new_client/header');?>
	<style>#edit_placement {margin-top:-24px;margin-bottom:5px;}</style>
		
	<script>
			 $(document).ready(function(){
			  $("#advancesearch").hide();
			  $("#show_password").hide();
			  $("#show_pic").hide();
			  $('#edit_pic').hide();
			  $('#choose_gender').hide();
			  $('#choose_phone').hide();
			  $('#choose_add').hide();
			  $('#edit_placement').hide();
			 
			 $("#edit_gender").click(function(){
				$("#choose_gender").show();  
				$("#gender").hide();
			 });
			 $("#edit_phone").click(function(){
				$("#choose_phone").show();  
				$("#phone").hide();
			 });
			 $("#edit_add").click(function(){
				$("#choose_add").show();  
				$("#add").hide();
			 });
			 
			 $('#profile_img').hover(function(){
				$('#edit_pic').show();
				$('#edit_placement').show();
				//},function(){
				//$('#edit_pic').hide();
			 });
			 	
			  $("#edit_pic").click(function(){
				$("#show_pic").show();  	
				$("#choose").focus();
			  }); 		
 			$("#password").click(function(){
				$("#show_password").show();
				$("#password_focus").focus();
			  });

			  $("#showadvancesearch").click(function(){
				$("#advancesearch").toggle();  
				$("#search").toggle();  		
			  });
			 
			 $("#showsearch").click(function(){
				$("#advancesearch").toggle();  
				$("#search").toggle();  		
			  });
			  
			   //change pwd
			  $.extend($.validator.messages, {
					equalTo: "These passwords don't match. Try again?"
				});
			
				$("#do-change").validate({
					rules: {
						"new_password": {
							minlength: 5,
							maxlength: 20
						},
						"confirm_password": {
							equalTo: "#new_password"
						}
					}
				});
				
				
			  
			 });
		 </script>
		
<div id="main">
    <section>
     <div class="container margin-top-40">           
		
        <div class="row no-margin">    
			<div class="col-md-7 col-sm-7 margin-0 margin-bottom-15">
			  <div class="border">
				<div class="row padding-15 color">
					<div class="col-md-4 col-sm-4 col-xs-12 padding-right-0">
					   <img  id="profile_img" class="border-radius-50 cursor-pointer" src="<?php echo base_url().$adrep_details[0]['image']; ?>" alt="profile" width="190px" height="190px">	
					   
					   <div id="edit_placement"><a id="edit_pic" class="cursor-pointer small white padding-5 background-color-dark"><i class="glyphicon glyphicon-pencil"></i> Update Picture</a></div>
					</div>		 	
			
					<div class="col-md-8 col-sm-8 col-xs-12">
					   <div class="row padding-bottom-5">
						  <span class="xxlarge col-xs-12 padding-bottom-5 margin-0"><?php echo $adrep_details[0]['first_name'].' '.$adrep_details[0]['last_name'];?></span>
						  <span class="large col-xs-12 padding-bottom-5 margin-0"><?php echo $publication[0]['name']; ?></span>
						  <span class="col-xs-12 margin-0"><?php echo $adrep_details[0]['email_id']; ?></span>
					   </div>
					   
						   <div class="row margin-top-25 margin-bottom-5">
								<div class="col-md-3 col-sm-3 col-xs-4 text-grey smedium">Username</div>
								<div class="col-md-8 col-sm-8 col-xs-7 medium"><?php echo $adrep_details[0]['first_name'].' '.$adrep_details[0]['last_name'];?></div>
						   </div>
						   <div class="row margin-bottom-5">
								<div class="col-md-3 col-sm-3 col-xs-4 text-grey smedium">Gender</div>
								<div class="col-md-8 col-sm-8 col-xs-7 medium">
									<span id="gender"><?php if($adrep_details[0]['gender'] == '0') { echo "Female"; } else {echo "Male";}?>
										<a id="edit_gender" class="cursor-pointer small font-color-grey"><i class="glyphicon glyphicon-pencil"></i></a>
									</span>
									<div id="choose_gender">
										<form method="post">
											<div class="btn-group" data-toggle="buttons">
												<label class="btn smedium padding-5 btn-default margin-right-10">
													<input type="radio" name="gender" value="1" required=""> Male
												</label> 
												<label class="btn smedium padding-5 btn-default margin-bottom-5">
													<input type="radio" name="gender" value="0" required=""> Female
												</label> 
											</div><br>
											<button type="submit" name="gender_submit" class="btn smedium padding-vertical-5 btn-primary">Submit</button>						
										</form>
									</div>
								</div>
							</div>
						   <div class="row margin-bottom-5">
								<div class="col-md-3 col-sm-3 col-xs-4 text-grey smedium">Phone No</div>
								<div class="col-md-6 col-sm-8 col-xs-7 medium">
									<span id="phone"><?php if($adrep_details[0]['phone_1']==''){echo "";} else { echo $adrep_details[0]['phone_1']; } ?>
										<a id="edit_phone" class="cursor-pointer small font-color-grey"><i class="glyphicon glyphicon-pencil"></i></a>
									</span>
									<div id="choose_phone">
									  <form method="post">
										<input type="number" name="phone" class="form-control input-sm">
										<button type="submit" name="submit_phone" class="btn smedium margin-top-5 padding-vertical-5 btn-primary">Submit</button>
									  </form>
									</div>
								</div>
						   </div> 
						   <div class="row">
								<div class="col-md-3 col-sm-3 col-xs-4 text-grey smedium">Address</div>
								<div class="col-md-9 col-sm-8 col-xs-7 medium">
									<span id="ads"><?php if($adrep_details[0]['address']==''){echo "";} else { echo $adrep_details[0]['address']; } ?> 
										<a id="edit_add" class="cursor-pointer small font-color-grey"><i class="glyphicon glyphicon-pencil"></i></a>
									</span>
									<div id="choose_add">
									  <form method="post">
										<input type="text" name="address" class="form-control input-sm">
										<button type="submit" name="address_submit" class="btn smedium margin-top-5 padding-vertical-5 btn-primary">Submit</button>
									  </form>
									</div>
								</div>
						   </div> 
					</div>
				
				
				
					<div class="col-md-12 col-sm-12 col-xs-12 margin-0">
						<div class="row no-margin">    
							<div class="col-md-12 col-sm-5 padding-top-15" id="show_pic" tabindex="1">
							  <div class="border-top padding-top-10">
								<p class="margin-bottom-10">Upload New Profile Picture<br>
									<small class="text-grey">(Format Allowed jpeg only, file size allowed maximum 500x500 pixel)</small>
								</p>							
								<form method="POST" enctype="multipart/form-data">
									<input type="file" name="Photo" accept="image/jpeg" required="" id="docs-input-file"> 
									<button type="submit" name="img_upload" class="btn smedium margin-top-10 padding-vertical-5 btn-primary">Submit</button>
								</form>	
							  </div>
							</div>
											
							<div class="col-md-12" id="show_password">
							  <div class="border-top margin-top-15">
								 <form method="post" id="do-change">
									<div class="row margin-top-10">
										<div class="col-md-4">
											<p class="margin-bottom-5">Current Password <span class="text-red">*</span></p>
											<input type="password" name="current_password" class="form-control input-sm margin-bottom-15" required="" id="password_focus">
										</div>
										<div class="col-md-4">
											<p class="margin-bottom-5">New Password <span class="text-red">*</span></p>
											<input type="password" name="new_password" id="new_password" class="form-control input-sm margin-bottom-15" required="">
										</div>
										<div class="col-md-4">
											<p class="margin-bottom-5">Re-Type Password <span class="text-red">*</span></p>
											<input type="password" name="confirm_password" id="confirm_password" class="form-control input-sm margin-bottom-10" required="">
										</div>
										<div class="col-md-12 col-sm-12 col-xs-12 text-right">
										  <button type="submit" name="submit_pwd" id="submit_pwd" class="btn smedium padding-vertical-5 btn-primary">Submit</button>
										  </div>
									</div>
								</form>     
							  </div> 
							</div>
						</div>
					</div>
				
			
				</div>
				<div class="row padding-horizontal-15">			
					<div class="col-md-12 margin-top-5 padding-bottom-10 background-color-grey">
						<div class="row small text-grey border-dotted">  
							<div class="col-xs-12 margin-top-10 text-right"><a id="password" class="cursor-pointer">Change Password</a></div>
						</div>
					</div>
			    </div>
				<div class="col-md-12 col-sm-12 col-xs-12 text-right">
					<?php if(isset($invalid_pwd)) { ?>
						<div class="alert alert-danger alert-outline margin-bottom-5 padding-5"><p>Current Password Does Not Match.</p></div>	
					<?php } ?>
					<?php if(isset($pwd_success)){ ?>
						<div class="alert alert-success alert-outline margin-bottom-5 padding-5"><p>Password Changed Successfully.</p></div>	
					<?php } ?>
				</div>
			  </div>
			</div>	
		
			<div class="col-md-5 col-sm-5 margin-0">
				<div class="row border-bottom margin-0">
				<?php if($adrep_details[0]['team_orders']=='1'){ ?>
					<div class="col-md-7 col-xs-6 padding-10 padding-right-0"> Total No of team ads</div>
					<div class="col-md-5 col-xs-6 padding-vertical-10 padding-0 text-grey"><?php echo $orders_count; ?></div>
				<?php }else{ ?>
					<div class="col-md-7 col-xs-6 padding-10 padding-right-0">Total No of ads</div>
					<div class="col-md-5 col-xs-6 padding-vertical-10 padding-0 text-grey"><?php echo $orders_count; ?></div>
				<?php } ?>
				</div>
				
				<?php if(isset($storage_space)){ ?>
				<div class="row border-bottom margin-0">
					<div class="col-md-7 col-xs-6 padding-10 padding-right-0">Storage Used</div>
					<div class="col-md-5 col-xs-6 padding-vertical-10 padding-0 text-grey"><?php echo $storage_space; ?></div>
				</div>
				<?php } ?>
				
				<div class="row border-bottom margin-0">
					<div class="col-md-7 col-xs-6 padding-10 padding-right-0">Account activated on</div>
					<div class="col-md-5 col-xs-6 padding-vertical-10 padding-0 text-grey"><?php echo date("M d, Y",strtotime($adrep_details[0]['created_on'])); ?></div>
				</div>
				<div class="row border-bottom margin-0">
					<div class="col-md-7 col-xs-6 padding-vertical-15 padding-left-10  padding-right-0">Design Team</div>
					<div class="col-md-5 col-xs-6 padding-vertical-10 padding-0 text-grey">
					<?php echo $design_team[0]['name']; ?><br/>
					<small><?php echo $design_team[0]['email_id']; ?></small>
					</div>
				</div>
				
			</div>
		</div>
		 
	
	
      </div>

	</section><!-- /section -->
</div>

<script>

function readURL(input) {
	var file = document.getElementById('docs-input-file').files;
	//img size chk
	if(file[0] && file[0].size > 200000) { // 200 KB (this size is in bytes)
        //Prevent default and display error
		alert('File Size is Greater than 200kb. Try Files that are lesser than 200kb..!!');
		$('#docs-input-file').val('');
        evt.preventDefault();
    }
}

$("#docs-input-file").change(function(){
    readURL(this);
});

</script>

<?php if($this->session->userdata('ncId')=='36'){ $this->load->view('new_client/privacy_footer'); }else{ $this->load->view('new_client/footer'); } ?>