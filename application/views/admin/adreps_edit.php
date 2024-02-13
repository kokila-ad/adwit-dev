<?php $this->load->view("admin/head1") ?>
 
<div class="page-content-wrapper">
	<div class="page-content">
		<div class="portlet light">
			<div class="portlet-body">	
				<h3 class="modal-title">Edit AdRep</h3>
					<hr>
		
  	      <div class="modal-body">	
				<div class="row">
				<form method="post" name="order_form" id="order_form">
				<div class="row">
					<div class="col-md-6">
					<div class="form-group">
						<label class="margin-top-5">First Name</label>
						<input type="text" name="first_name" value="<?php echo $adrep['first_name'];?>" class="form-control" />
					</div>
					</div>	
					
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Last Name</label>
							<input type="text" name="last_name" value="<?php echo $adrep['last_name'];?>" class="form-control" />
						</div>						  
					</div>
							
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Gender</label><span class="mandatory font-red">*</span>
							<div class="clearfix">
								<div class="btn-group" data-toggle="buttons">
									<label class="btn btn-success <?php if($adrep['gender']=='0')echo"active"; ?> margin-right-10">
									<input type="radio" value="0" name="gender" class="toggle" required/> Female </label>
									<label class="btn btn-success <?php if($adrep['gender']=='1')echo"active"; ?>">
									<input type="radio" value="1" name="gender" class="toggle" required /> Male </label>
								</div>
							</div>
						</div>							  
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Email Id</label><span class="mandatory font-red">*</span>
							<input type="text" name="email_id" value="<?php echo $adrep['email_id'];?>" class="form-control" required/>
						</div>						  
					</div>
		
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Publication</label>
							<select class="form-control" name="publication_id" />
								<option>Select Publication</option>
								<?php foreach($publications_list as $row1){ ?>
								<option value = "<?php echo($row1['id'])?>" <?php if($row1['id']==$adrep['publication_id'])echo"selected"; ?> ><?php echo($row1['name']);?></option>
								<?php } ?>
							</select>
						</div>							  
					</div>
					
					<div class="col-md-6">
					<div class="form-group">
					<label class="margin-top-5">UI</label><span class="mandatory font-red">*</span>
					<div class="clearfix">
						<div class="btn-group" data-toggle="buttons">
							<label class="btn btn-success <?php if($adrep['new_ui']=='0')echo"active"; ?> margin-right-10">
							<input type="radio" value="0" name="new_ui" class="toggle" required> Old UI </label>
							<label class="btn btn-success <?php if($adrep['new_ui']=='1')echo"active"; ?> ">
							<input type="radio" value="1" name="new_ui" class="toggle" required> New UI </label>
						</div>
					</div>
				</div>	
				</div>
				</div>
<hr>				
				<div class="row">												
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">User Name</label>
							<input type="text" name="username" value="<?php echo $adrep['username'];?>" class="form-control" />
						</div>							  
					</div> 
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Password</label><span class="mandatory font-red">*</span>
							<input type="password" name="password" value="<?php echo $adrep['password'];?>" class="form-control" required>
						</div>						  
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Phone 1</label>
							<input type="text" name="phone_1" value="<?php echo $adrep['phone_1'];?>" class="form-control" >
						</div>							  
					</div>
					
					<div class="col-md-6">
					<div class="form-group">
							<label class="margin-top-5">Account Status</label>
							<select class="form-control" name="is_active">
								<option value="1">Active</option>
								<option value="0">Deactive</option>
							</select>
						</div>	
					</div>
					
					</div>
						
		
		 	
				<!--<div class="row">	
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Is active</label>
							<div class="clearfix">
								<div class="btn-group" data-toggle="buttons">
									<label class="btn btn-success <?php if($adrep['is_active']=='1')echo"active"; ?> margin-right-10">
									<input type="radio" name="is_active" value="1" class="toggle" <?php if($adrep['is_active']=='1')echo"checked"; ?> /> Active </label>
									<label class="btn btn-success <?php if($adrep['is_active']=='0')echo"active"; ?>">
									<input type="radio" name="is_active" value="0" class="toggle" <?php if($adrep['is_active']=='0')echo"checked"; ?> /> In-Active </label>
								</div>
							</div>
						</div>						  
					</div>	
				</div>	-->							
		    </div>
		<div class="modal-footer">	
				<a href="<?php echo base_url().index_page()."admin/home/adreps";?>" type="button" class="btn red-flamingo">Back</a>	 
				<input class="btn btn-primary" type="submit" value="Update" id="submit_form"  />
		</div>
	</form>	
	</div>
		</div>
</div>		
</div>
</div>
</div>

<?php $this->load->view("admin/foot1"); ?>