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
		
		$("#csr-list").on('change', function(){
		    var csr_id = $(this).val(); 
		   window.location.href = "<?php echo base_url().index_page().'new_admin/home/csr_profile/'?>"+csr_id ;
		});
	 });
 </script>



<div class="portlet light">
	<div class="row margin-bottom-5">	
		<div class="col-md-7 col-xs-12">
			<a href="<?php echo base_url().index_page().'new_admin/home/manage'?>" class="font-lg">Manage</a> - 
			<a href="<?php echo base_url().index_page().'new_admin/home/csr'?>" class="font-lg font-grey-gallery"><u>CSR</u></a>
			<?php if(isset($csrs_list[0]['id'])){ ?>
    		-   <select id="csr-list">
    			    <?php foreach($csrs_list as $c){ ?>
    			    <option value="<?php echo $c['id']; ?>" <?php if($c['id'] == $id)echo"selected"; ?>>
    			        <?php echo $c['name'].'('.$c['username'].')'; ?>
    			    </option>
    			    <?php } ?>
    			</select>
			<?php } ?>
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
							<img id="profile_img" src="<?php echo $csr_list[0]['image_path'];?>" width="150px" height="150px">	
						</div>
						<div class="col-md-9 col-sm-8 col-xs-12">
						   <div class="row padding-bottom-5">
							  <span class="font-hg col-xs-12"><?php echo $csr_list[0]['name'];?> <i class="fa fa-pencil" id="edit_name"></i></span>
							  
						    <div id="name" class="row margin-0 margin-bottom-10">
								<div class="col-md-6 padding-right-0 margin-top-5"><input type = "text" name="name" class="form-control input-sm" placeholder="Enter the name"></div>
								<div class="col-md-12 margin-top-5"><input type="submit" name="name_submit" class="btn btn-sm btn-primary"></div>
							</div>
						    <span class="col-xs-12 margin-0 margin-top-5"><?php echo $csr_list[0]['email_id'];?> <i class="fa fa-pencil" id="edit_email"></i></span>
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
				<!--<?php if(isset($csr_list)){?>
					<div class="row border-bottom margin-0">
						<div class="col-md-6 col-xs-6 padding-10 padding-right-0">Total Ads</div>
						<div class="col-md-6 col-xs-6 padding-vertical-10 padding-0 text-grey"><?php echo $order_count;?></div>
					</div>
				<?php }else {?>
					<div class="row border-bottom margin-0">
						<div class="col-md-6 col-xs-6 padding-10 padding-right-0">Total Ads</div>
						<div class="col-md-6 col-xs-6 padding-vertical-10 padding-0 text-grey"><?php echo '-';?></div>
					</div>
				<?php }?>	-->									
				<div class="row border-bottom margin-0">
					<div class="col-md-6 col-xs-6 padding-10 padding-right-0">Username</div>
					<div class="col-md-6 col-xs-6 padding-vertical-10 padding-0 text-grey capitalize"><?php if($csr_list[0]['username']!='') echo $csr_list[0]['username']; else echo "-";?></div>
				</div>
				
				<div class="row border-bottom margin-0">
					<div class="col-md-6 col-xs-6 padding-10 padding-right-0">Account Activated On</div>
					<div class="col-md-6 col-xs-6 padding-vertical-10 padding-0 text-grey">
						<?php if($csr_list[0]['created_on']!='')echo date('M d, Y H:i:s',strtotime($csr_list[0]['created_on'])); else echo"-";?>
					</div>
				</div>
				<div class="row border-bottom margin-0">
					<div class="col-md-6 col-xs-6 padding-10 padding-right-0">Reports</div>
					<div class="col-md-6 col-xs-6 padding-vertical-10 padding-0 text-grey">
						<button class="btn bg-grey-gallery btn-xs">Click Here</button>
					</div>
				</div>
				<!--Assiging Publication to Designer Starts-->
				<div class="row border-bottom margin-0">
					<div class="col-md-6 col-xs-6 padding-10 padding-right-0">Assign Publication</div>
					<div class="col-md-6 col-xs-6 padding-vertical-10 padding-0 text-grey">
						<a href="<?php echo base_url().index_page().'new_admin/home/assign_publication/csr/'.$csr_list[0]['id'];?>" class="btn bg-grey-gallery btn-xs">Click Here</a>
					</div>
					<?php 
    					if(isset($pub_assign)){
    					    $i = 0;
    					    foreach($pub_assign as $row_pub){
    					        if($i == 0){
    					           echo $row_pub['name']."\t";  
    					        }else{
    					           echo ", ".$row_pub['name']."\t"; 
    					        }
    					        $i++;
    					    }
    					} 
					?>
				</div>	
				<!--Assiging Publication to Designer Ends-->
				<!--Assiging Club-->
				<div class="row border-bottom margin-0">
					<div class="col-md-6 col-xs-6 padding-10 padding-right-0">Assign Club</div>
					<div class="col-md-6 col-xs-6 padding-vertical-10 padding-0 text-grey">
						<a href="<?php echo base_url().index_page().'new_admin/home/assign_club/csr/'.$csr_list[0]['id'];?>" class="btn bg-grey-gallery btn-xs">Click Here</a>
					</div>
					<?php if(isset($club_assign)){
					    $i = 0;
					    foreach($club_assign as $row_club){
					       if($i == 0){
    					       echo $row_club['name']."\t";  
    					   }else{
    					       echo ", ".$row_club['name']."\t"; 
    					   }
    					   $i++;
					    }
					} ?>
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
					<div class="details-title">Mobile No</div>
					<div class="details-data">
						<div class="row">
							<div class="col-md-8 padding-right-0"><input type="number" value="<?php if($csr_list[0]['mobile_no']!='')echo $csr_list[0]['mobile_no']; else echo"-";?>" name="mobile_no" class="form-control input-sm" placeholder="Enter Mobile number"></div>
						</div>
					</div>	
				</div>
				
				
				<div class="data">
					<div class="details-title">Alias</div>
					<div class="details-data">
						<div class="row">
							<div class="col-md-8 padding-right-0"><input type="text" value="<?php if($csr_list[0]['alias']!='')echo $csr_list[0]['alias']; else echo"-";?>" name="alias" class="form-control input-sm" ></div>
						</div>
					</div>	
				</div>
				
				
				<div class="data">
				<div class="details-title">Join Location</div>
				<div class="details-data">
					<div class="row">
						<div class="col-md-8 padding-right-0">
							<select class="form-control input-sm" name="Join_location">
								<option value=""></option>
								<?php foreach($location as $loc_row){ ?>
								<option value="<?php echo($loc_row['id'])?>" <?php if($csr_list[0]['Join_location']==$loc_row['id']){ echo "selected"; } ?> ><?php echo($loc_row['name']); ?></option>
								<?php } ?>
							</select>	
						</div>
					</div>
				</div>											
				</div>
												
				<div class="data">
				<div class="details-title">Work Location</div>
				<div class="details-data">
					<div class="row">
						<div class="col-md-8 padding-right-0">
							<select class="form-control input-sm" name="Work_location">
								<option value=""></option>
								<?php foreach($location as $wrk_row){ ?>
								<option value="<?php echo($wrk_row['id'])?>" <?php if($csr_list[0]['Work_location']==$wrk_row['id']){ echo "selected"; } ?> ><?php echo($wrk_row['name']); ?></option>
								<?php } ?>
							</select>	
						</div>
					</div>
				</div>											
				</div>
				<div class="data">
					<div class="details-title">Shift Factor</div>
					<div class="details-data">
						<div class="row">
							<div class="col-md-8 padding-right-0"><input type="text" value="<?php if($csr_list[0]['shift_factor']!='')echo $csr_list[0]['shift_factor']; else echo"-";?>" name="shift_factor" class="form-control input-sm" ></div>
						</div>
					</div>	
				</div>
				
				<div class="data">
					<div class="details-title">CSR Category Level</div>
					<div class="details-data">
						<div class="row">
						<div class="col-md-8 padding-right-0">
						    <?php 
						        $csr_category_level = explode(',', $csr_list[0]['category_level']);
						        foreach($category_level as $cl_row){
						    ?>
						            <input type="checkbox" name="category_level[]" value="<?php echo $cl_row['name']; ?>" <?php if(in_array($cl_row['name'], $csr_category_level)) echo 'checked'; ?>> <?php echo $cl_row['name']; ?>
						  <?php
						        }
						    ?>
							<!--<select class="form-control input-sm" name="category_level">
								<option value=""></option>
								<?php foreach($category_level as $cl_row){ ?>
								<option value="<?php echo($cl_row['name'])?>" 
								<?php if(isset($csr_list[0]['category_level'])){
									if($csr_list[0]['category_level']==$cl_row['name']){ 
									echo "selected"; 
									} 
								} ?> > <?php echo($cl_row['name']); ?></option>
								<?php } ?>
							</select>-->	
						</div>
					</div>
					</div>	
				</div>
			</div>
			
			<div class="col-md-6 col-sm-6">
			
				<div class="data">
					<div class="details-title">CSR Role</div>
					<div class="details-data">
						<div class="row">
						<div class="col-md-8 padding-right-0">
							<select class="form-control input-sm" name="csr_role">
								<option value=""></option>
								<?php foreach($c_role as $c_row){ ?>
								<option value="<?php echo($c_row['id'])?>" <?php if($csr_list[0]['csr_role']==$c_row['id']){ echo "selected"; } ?> ><?php echo($c_row['name']); ?></option>
								<?php } ?>
							</select>	
						</div>
					</div>
					</div>	
				</div>
				
				<div class="data">
				<div class="data">
					<div class="details-title">Saral ID</div>
					<div class="details-data">
						<div class="row">
							<div class="col-md-8 padding-right-0"><input type="number" value="<?php if($csr_list[0]['saral_id']!='')echo $csr_list[0]['saral_id']; else echo"-";?>" name="saral_id" class="form-control input-sm" ></div>
						</div>
					</div>	
				</div>
					<div class="details-title">Gender</div>
					<div class="details-data">
						<div class="btn-group" data-toggle="buttons">
							<label class="btn btn-xs btn-default  <?php if($csr_list[0]['gender']=='1')echo"active"; ?>">
							<input type="radio" name="gender" value="1" <?php if($csr_list[0]['gender']== '1') echo"checked";?>  class="toggle"> Male </label>
							<label class="btn btn-xs btn-default  <?php if ($csr_list[0]['gender']== '0') echo "active" ;?>">
							<input type="radio" name="gender" value="0" <?php if($csr_list[0]['gender']== '0') echo"checked";?> class="toggle"> Female </label>
						</div>	
					</div>
				</div>
				<div class="data">
					<div class="details-title">Web Ad</div>
					<div class="details-data">
						<div class="btn-group" data-toggle="buttons">
							<label class="btn btn-xs btn-default <?php if($csr_list[0]['web_ad']== '1')echo"active" ;?>">
							<input type="radio" name="web_ad" value="1" <?php if($csr_list[0]['web_ad']== '1')echo"checked" ;?> class="toggle"> Enable </label>
							<label class="btn btn-xs btn-default <?php if($csr_list[0]['web_ad']== '0') echo"active";?>">
							<input type="radio" name="web_ad" value="0" <?php if($csr_list[0]['web_ad']== '0') echo"checked";?> class="toggle"> Disable </label>
						</div>	
					</div>	
				</div>
				
		
				<div class="data">
					<div class="details-title">Account Status</div>
					<div class="details-data">
						<div class="btn-group" data-toggle="buttons">
							<label class="btn btn-xs btn-default <?php if($csr_list[0]['is_active']== '1')echo"active";?> ">
							<input type="radio" name="is_active" value="1" <?php if($csr_list[0]['is_active']== '1')echo"checked";?> class="toggle"> Active </label>
							<label class="btn btn-xs btn-default <?php if($csr_list[0]['is_active']== '0')echo"active";?>">
							<input type="radio" name="is_active" value="0" <?php if($csr_list[0]['is_active']== '0')echo"checked";?> class="toggle"> In Active </label>
						</div>	
					</div>
				</div>
				
				<div class="data">
					<div class="details-title">PDF Review Tool</div>
					<div class="details-data">
						<div class="btn-group" data-toggle="buttons">
							<label class="btn btn-xs btn-default <?php if($csr_list[0]['pdf_review_tool'] == '1') echo"active"; ?> ">
							<input type="radio" name="pdf_review_tool" value="1" <?php if($csr_list[0]['pdf_review_tool']== '1') echo"checked"; ?> class="toggle"> Enable </label>
							
							<label class="btn btn-xs btn-default <?php if($csr_list[0]['pdf_review_tool'] == '0') echo"active"; ?>">
							<input type="radio" name="pdf_review_tool" value="0" <?php if($csr_list[0]['pdf_review_tool']== '0') echo"checked"; ?> class="toggle"> Disable </label>
						</div>	
					</div>
				</div>
			</div>
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