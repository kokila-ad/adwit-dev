<?php $this->load->view('new_admin/header')?>
				
<style>
	#edit_placement {margin-top:-24px;margin-left:0;margin-bottom:5px;}
	.fa-pencil { color: #E5E5E5 !important; cursor: pointer;}
	.fa-pencil:hover { color: #444444 !important; }
</style>
<script>
	 $(document).ready(function(){
	  $("#show_password").hide();
	  $('#submit_form').hide();
	  $('#email').hide();
	  $('#name').hide();
	  $("#to_adrep").hide();
	  
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
		
		$("#migrate").click(function(){
			$("#to_adrep").toggle();  
		});
	 });
 </script>

 
<div class="portlet light">
	<div class="row margin-bottom-5">	
		<div class="col-md-7 col-xs-12">
			<a href="<?php echo base_url().index_page().'new_admin/home/manage'?>" class="font-lg">Manage</a> - 
			<a href="<?php echo base_url().index_page().'new_admin/home/publication/'.$publication[0]['id']; ?>" class="font-lg"><?php echo $publication[0]['name'];?></a> -
			<a href="<?php echo base_url().index_page().'new_admin/home/adrep_profile/'.$id; ?>" class="font-lg font-grey-gallery"><u><?php echo $adreps_list[0]['first_name'].' '.$adreps_list[0]['last_name'];?></u></a>
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
						<div class="col-md-3 col-sm-4 col-xs-12">
							<img id="profile_img"  style="max-width: 150px; width: 100%;" height="150px"
								src="<?php echo $adreps_list[0]['image'];?>" alt="profile">	
						</div>
						<div class="col-md-9 col-sm-8 col-xs-12">
						   <div class="row padding-bottom-5">
							  <span class="font-hg col-xs-12"><?php echo $adreps_list[0]['first_name'].' '.$adreps_list[0]['last_name'];?> <i class="fa fa-pencil" id="edit_name"></i></span>
							  
						    <div id="name" class="row margin-0 margin-bottom-10">
								<div class="col-md-4 padding-right-0 margin-top-5"><input type = "text" name="first_name" class="form-control input-sm" placeholder="First name"></div>
								<div class="col-md-4 padding-right-0 margin-top-5"><input type = "text" name="last_name" class="form-control input-sm" placeholder="Last name"></div>
								<div class="col-md-12 margin-top-5"><input type="submit" name="name_submit" class="btn btn-sm btn-primary"></div>
							</div>
						    <span class="col-xs-12 margin-0 margin-top-5"><?php echo $adreps_list[0]['email_id'];?> <i class="fa fa-pencil" id="edit_email"></i></span>
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
				<?php if($adrep_details[0]['team_orders']=='1'){ ?>
					<div class="row border-bottom margin-0">
						<div class="col-md-6 col-xs-6 padding-10 padding-right-0">Total Ads</div>
						<div class="col-md-6 col-xs-6 padding-vertical-10 padding-0 text-grey"><?php echo $orders_count;?></div>
					</div>
				<?php }else {?>
				<div class="row border-bottom margin-0">
						<div class="col-md-6 col-xs-6 padding-10 padding-right-0">Total Ads</div>
						<div class="col-md-6 col-xs-6 padding-vertical-10 padding-0 text-grey"><?php echo '-';?></div>
					</div>
				<?php }?>
				<?php if(isset($storage_space)){ ?>
				<div class="row border-bottom margin-0">
					<div class="col-md-6 col-xs-6 padding-10 padding-right-0">Storage Used</div>
					<div class="col-md-6 col-xs-6 padding-vertical-10 padding-0 text-grey"><?php echo $storage_space; ?></div>
				</div>
				<?php } else {?>
				<div class="row border-bottom margin-0">
					<div class="col-md-6 col-xs-6 padding-10 padding-right-0">Storage Used</div>
					<div class="col-md-6 col-xs-6 padding-vertical-10 padding-0 text-grey"><?php echo '-'; ?></div>
				</div>
				<?php } ?>
				<div class="row border-bottom margin-0">
					<div class="col-md-6 col-xs-6 padding-10 padding-right-0">Username</div>
					<div class="col-md-6 col-xs-6 padding-vertical-10 padding-0 text-grey"><?php echo $adreps_list[0]['username'];?></div>
				</div>
				<div class="row border-bottom margin-0">
					<div class="col-md-6 col-xs-6 padding-10 padding-right-0">Account Activated On</div>
					<div class="col-md-6 col-xs-6 padding-vertical-10 padding-0 text-grey">
						<?php if($adreps_list[0]['created_on']!='')echo date('Y M d H:i:s',strtotime($adreps_list[0]['created_on'])); else echo"-";?>									
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
		<div class="col-sm-6 margin-top-5 font-grey-gallery"><b>More Details</b></div>
		<div class="col-sm-6 text-right">
			<button  id="submit_form" type="submit" name="Save" class="btn btn-xs btn-primary margin-left-10">Save Changes</button>
		</div>
	</div>
	<div class="row userdetails portlet-body" id="form">
		<div class="border-top">
			<div class="col-md-6 col-sm-6">
				<div class="data">
					<div class="details-title">Phone No</div>
					<div class="details-data">
						<div class="row">
							<div class="col-md-8 padding-right-0"><input type="number" value="<?php if($adreps_list[0]['phone_1']!='')echo $adreps_list[0]['phone_1']; else echo"-";?>" name="phone_1" class="form-control input-sm" placeholder="Enter Phone number"></div>
						</div>
					</div>	
				</div>
				
				<div class="data">
					<div class="details-title">Mobile No</div>
					<div class="details-data">
						<div class="row">
							<div class="col-md-8 padding-right-0"><input type="number" value="<?php if($adreps_list[0]['mobile_no']!='')echo $adreps_list[0]['mobile_no']; else echo"-";?>" name="mobile_no" class="form-control input-sm" placeholder="Enter Mobile number"></div>
						</div>
					</div>	
				</div>
				
				<div class="data">
					<div class="details-title">Email cc</div>
					<div class="details-data">
						<div class="row">
							<div class="col-md-8 padding-right-0">
							    <input type="text" value="<?php if($adreps_list[0]['email_cc']!='')echo $adreps_list[0]['email_cc']; else echo" ";?>" name="email_cc" class="form-control input-sm" placeholder="Enter Email address">
						    </div>
						</div>
					</div>
				</div>
				
				<div class="data">
					<div class="details-title">Gender</div>
					<div class="details-data">
						<div class="btn-group" data-toggle="buttons">
							<label class="btn btn-xs btn-default  <?php if($adreps_list[0]['gender']=='1')echo"active"; ?>">
							<input type="radio" name="gender" value="1" <?php if($adreps_list[0]['gender']== '1') echo"checked";?>  class="toggle"> Male </label>
							<label class="btn btn-xs btn-default  <?php if ($adreps_list[0]['gender']== '0') echo "active" ;?>">
							<input type="radio" name="gender" value="0" <?php if($adreps_list[0]['gender']== '0') echo"checked";?> class="toggle"> Female </label>
						</div>	
					</div>
				</div>
				
				<div class="data">
					<div class="details-title">Dashboard No of Days Display</div>
					<div class="details-data">
						<div class="row">
							<div class="col-md-8 padding-right-0"><input type="text" value="<?php if($adreps_list[0]['display_orders']!='')echo $adreps_list[0]['display_orders']; else echo"-";?>" name="display_orders" class="form-control input-sm" ></div>
						</div>
					</div>	
				</div>
				
				<div class="data">
					<div class="details-title">Print Tab</div>
					<div class="details-data">
						<div class="btn-group" data-toggle="buttons">
							<label class="btn btn-xs btn-default <?php if($adreps_list[0]['print_ad']== '1')echo"active";?> ">
							<input type="radio" name="print_ad" value="1" <?php if($adreps_list[0]['print_ad']== '1')echo"checked";?> class="toggle"> Active </label>
							<label class="btn btn-xs btn-default <?php if($adreps_list[0]['print_ad']== '0')echo"active";?>">
							<input type="radio" name="print_ad" value="0" <?php if($adreps_list[0]['print_ad']== '0')echo"checked";?> class="toggle"> In Active </label>
						</div>	
					</div>	
				</div>
				
				<div class="data">
					<div class="details-title">Online Tab</div>
					<div class="details-data">
						<div class="btn-group" data-toggle="buttons">
							<label class="btn btn-xs btn-default <?php if($adreps_list[0]['online_ad']== '1')echo"active";?> ">
							<input type="radio" name="online_ad" value="1" <?php if($adreps_list[0]['online_ad']== '1')echo"checked";?> class="toggle"> Active </label>
							<label class="btn btn-xs btn-default <?php if($adreps_list[0]['online_ad']== '0')echo"active";?>">
							<input type="radio" name="online_ad" value="0" <?php if($adreps_list[0]['online_ad']== '0')echo"checked";?> class="toggle"> In Active </label>
						</div>	
					</div>	
				</div>
			</div>
			
			<div class="col-md-6 col-sm-6">
				<div class="data">
					<div class="details-title">New UI</div>
					<div class="details-data">
						<div class="btn-group" data-toggle="buttons">
							<label class="btn btn-xs btn-default <?php if($adreps_list[0]['new_ui']== '1' || $adreps_list[0]['new_ui']== '2' || $adreps_list[0]['new_ui']== '3' || $adreps_list[0]['new_ui']== '4')echo"active" ;?>">
							<input type="radio" name="new_ui" value="<?php if($adreps_list[0]['new_ui']=='0') echo'1'; else echo $adreps_list[0]['new_ui']; ?>" <?php if($adreps_list[0]['new_ui']== '1' || $adreps_list[0]['new_ui']== '2' || $adreps_list[0]['new_ui']== '3' || $adreps_list[0]['new_ui']== '4')echo"checked" ;?> class="toggle"> Enable </label>
							<label class="btn btn-xs btn-default <?php if($adreps_list[0]['new_ui']== '0') echo"active";?>">
							<input type="radio" name="new_ui" value="0" <?php if($adreps_list[0]['new_ui']== '0') echo"checked";?> class="toggle"> Disable </label>
						</div>	
					</div>	
				</div>
				<div class="data">
					<div class="details-title">Team Orders</div>
					<div class="details-data">
						<div class="btn-group" data-toggle="buttons">
							<label class="btn btn-xs btn-default <?php if($adreps_list[0]['team_orders']== '1')echo"active" ;?>">
							<input type="radio" name="team_orders" value="1" <?php if($adreps_list[0]['team_orders']== '1')echo"checked" ;?> class="toggle"> Enable </label>
							<label class="btn btn-xs btn-default  <?php if($adreps_list[0]['team_orders']== '0')echo"active" ;?>">
							<input type="radio" name="team_orders" value="0" <?php if($adreps_list[0]['team_orders']== '0')echo"checked" ;?> class="toggle"> Disable </label>
						</div>	
					</div>		
				</div>
				<div class="data">
					<div class="details-title">Rush</div>
					<div class="details-data">
						<div class="btn-group" data-toggle="buttons">
							<label class="btn btn-xs btn-default <?php if($adreps_list[0]['rush']== '1')echo"active";?> ">
							<input type="radio" name="rush" value="1" <?php if($adreps_list[0]['rush']== '1')echo"checked";?> class="toggle"> Enable </label>
							<label class="btn btn-xs btn-default <?php if($adreps_list[0]['rush']== '0')echo"active";?> ">
							<input type="radio" name="rush" value="0" <?php if($adreps_list[0]['rush']== '0')echo"checked";?> class="toggle"> Disable </label>
						</div>	
					</div>	
				</div>
				<div class="data">
					<div class="details-title">Template</div>
					<div class="details-data">
						<div class="btn-group" data-toggle="buttons">
							<label class="btn btn-xs btn-default <?php if($adreps_list[0]['template']== '1')echo"active";?> ">
							<input type="radio" name="template" value="1" <?php if($adreps_list[0]['template']== '1')echo"checked";?> class="toggle"> Enable </label>
							<label class="btn btn-xs btn-default <?php if($adreps_list[0]['template']== '0')echo"active";?> ">
							<input type="radio" name="template" value="0" <?php if($adreps_list[0]['template']== '0')echo"checked";?> class="toggle"> Disable </label>
						</div>	
					</div>	
				</div>
				<div class="data">
					<div class="details-title">Account Status</div>
					<div class="details-data">
						<div class="btn-group" data-toggle="buttons">
							<label class="btn btn-xs btn-default <?php if($adreps_list[0]['is_active']== '1')echo"active";?> ">
							<input type="radio" name="is_active" value="1" <?php if($adreps_list[0]['is_active']== '1')echo"checked";?> class="toggle"> Active </label>
							<label class="btn btn-xs btn-default <?php if($adreps_list[0]['is_active']== '0')echo"active";?>">
							<input type="radio" name="is_active" value="0" <?php if($adreps_list[0]['is_active']== '0')echo"checked";?> class="toggle"> In Active </label>
						</div>	
					</div>
				</div>
				<div class="data">
					<div class="details-title">Page Design Tab</div>
					<div class="details-data">
						<div class="btn-group" data-toggle="buttons">
							<label class="btn btn-xs btn-default <?php if($adreps_list[0]['pagedesign_ad']== '1')echo"active";?> ">
							<input type="radio" name="pagedesign_ad" value="1" <?php if($adreps_list[0]['pagedesign_ad']== '1')echo"checked";?> class="toggle"> Active </label>
							<label class="btn btn-xs btn-default <?php if($adreps_list[0]['pagedesign_ad']== '0')echo"active";?>">
							<input type="radio" name="pagedesign_ad" value="0" <?php if($adreps_list[0]['pagedesign_ad']== '0')echo"checked";?> class="toggle"> In Active </label>
						</div>	
					</div>
				</div>
				<!-- Premium option -->
				<div class="data">
					<div class="details-title">Premium</div>
					<div class="details-data">
						<div class="btn-group" data-toggle="buttons">
							<label class="btn btn-xs btn-default <?php if($adreps_list[0]['premium']== '1')echo"active";?> ">
							<input type="radio" name="premium" value="1" <?php if($adreps_list[0]['premium']== '1')echo"checked";?> class="toggle"> Active </label>
							<label class="btn btn-xs btn-default <?php if($adreps_list[0]['premium']== '0')echo"active";?>">
							<input type="radio" name="premium" value="0" <?php if($adreps_list[0]['premium']== '0')echo"checked";?> class="toggle"> In Active </label>
						</div>	
					</div>
				</div>
				<!-- Color code option -->
				<div class="data">
					<div class="details-title">Color Code</div>
					<div class="details-data">
					    <select name="color_code">
        					<?php foreach($color_code as $cc){ ?>
        						<option value="<?php echo $cc['id']; ?>" <?php if($adreps_list[0]['color_code']== $cc['id']) echo"selected"; ?>><?php echo $cc['name']; ?></option>
        					<?php } ?>
        				</select>
					</div>
				</div>
			</div>
		</div>
	</div>
	</form>
	
	<div class="row margin-top-10"> 
		<div class="col-md-12 font-grey-gallery text-left font-sm cursor-pointer"><a id="migrate">Data Migrate</a></div>
		<div class="col-md-12" >
			<form method="POST" id="to_adrep">
				<select name="migrate_to_adrep" required>
					<option value="">Select Adrep</option>
					<?php foreach($migrate_adrep_list as $madrep){ ?>
						<option value="<?php echo $madrep['id']; ?>"><?php echo $madrep['first_name'].' '.$madrep['last_name']; ?></option>
					<?php } ?>
				</select>
				<button type="submit">SUBMIT</button>
			</form>
		</div>
	</div>
	
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
						
<script>
    $("#to_adrep").submit(function(){
    	confirm("Are You Sure, You want to Move Data?");
    });
</script>				
<?php $this->load->view('new_admin/footer')?>
<?php $this->load->view('new_admin/foot.php'); ?>