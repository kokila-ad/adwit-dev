<?php $this->load->view("admin/head1") ?>

<div class="page-content-wrapper">
	<div class="page-content">
		<div class="portlet light">
		<div class="portlet-body">	
			<h3 class="modal-title">Add AdRep</h3>	
<hr>			
		<div class="modal-body">
			<div class="row">
			<form method="post" name="order_form" id="order_form">
				<div class="col-md-12">
					<div class="form-group">
						<label class="margin-top-5">Publication</label><span class="mandatory font-red">*</span>
						<select class="form-control" name="publication_id" required/>
							<option value="">Select Publication</option>
							<?php foreach($publications_list as $row1){ ?>
							<option value = "<?php echo($row1['id'])?>" ><?php echo($row1['name']); ?></option>
							<?php } ?>
						</select>	
					</div>							  
				</div>
				
				<div class="col-md-12">
					<div class="form-group">
						<label class="margin-top-5">First Name</label><span class="mandatory font-red">*</span>
						<input type="text" name="first_name" class="form-control" required/>
					</div>
				</div>
				
				<div class="col-md-12">
					<div class="form-group">
						<label class="margin-top-5">Last Name</label><span class="mandatory font-red">*</span>
						<input type="text" name="last_name" class="form-control" required/>
					</div>	
				</div>
				
				<div class="col-md-12">
					<div class="form-group">
					<label class="margin-top-5">Gender</label><span class="mandatory font-red">*</span>
					<div class="clearfix">
						<div class="btn-group" data-toggle="buttons">
							<label class="btn btn-success margin-right-10">
							<input type="radio" value="0" name="gender" class="toggle" required> Female </label>
							<label class="btn btn-success active">
							<input type="radio" value="1" name="gender" class="toggle" required> Male </label>
						</div>
					</div>
				</div>	
				</div>
				
				<div class="col-md-12">
					<div class="form-group">
					<label class="margin-top-5">UI</label><span class="mandatory font-red">*</span>
					<div class="clearfix">
						<div class="btn-group" data-toggle="buttons">
							<label class="btn btn-success margin-right-10">
							<input type="radio" value="0" name="new_ui" class="toggle" required> Old UI </label>
							<label class="btn btn-success active">
							<input type="radio" value="1" name="new_ui" class="toggle" required> New UI </label>
						</div>
					</div>
				</div>	
				</div>
				
				<div class="col-md-12">
					<div class="form-group">
						<label class="margin-top-5">Email Id</label><span class="mandatory font-red">*</span>
						<input type="text" name="email_id" class="form-control" required/>
					</div>	
				</div>
				
				<div class="col-md-12">
					<div class="form-group">
						<label class="margin-top-5">User Name</label><span class="mandatory font-red">*</span>
						<input type="text" name="username" class="form-control" required/>
					</div>	
				</div>
				
				<div class="col-md-12">
					<div class="form-group">
						<label class="margin-top-5">Password</label><span class="mandatory font-red">*</span>
						<input type="password" name="password" class="form-control" required/>
					</div>
				</div>
				
				</div>			
				<div class="modal-footer">	
				 <a href="<?php echo base_url().index_page()."admin/home/adreps";?>" type="button" class="btn red-flamingo">Back</a> 
				 <input class="btn btn-primary" type="submit" value="Create" id="submit_form"  /> 
				</div>	
			</form>
			</div>
		</div>
	</div>
 </div>
</div>	

</div>

<?php $this->load->view("admin/foot1"); ?>