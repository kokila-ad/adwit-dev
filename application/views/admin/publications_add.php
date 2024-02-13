<?php $this->load->view("admin/head1") ?>

<div class="page-content-wrapper">
	<div class="page-content">
		<div class="portlet light">
		<div class="portlet-body">	
		<!-- BEGIN PAGE HEADER-->
			<h4 class="page-title">Add Publication</h4>
			<hr>
		<!-- END PAGE HEADER-->
	<div class="prolet-body">																																		
				<div class="row">
				<form method="post" name="order_form" id="order_form">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Name </label><span class="mandatory font-red">*</span>
							<input type="text" name="name" class="form-control" required>
						</div>
					</div>					
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Advertising Director</label>
							<input type="text" name="advertising_director_email_id" class="form-control">
						</div>					  
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Initial</label><span class="mandatory font-red">*</span>
							<input type="text" name="initial" class="form-control" required>
						</div>						  
					</div>					
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Ordering system</label>
							<select class="form-control" name="ordering_system">
								<option value="">Select Ordering System</option>
								<?php foreach($ordering_system as $order_row){ ?>
								<option value = "<?php echo($order_row['id'])?>" ><?php echo($order_row['name']); ?></option>
								<?php } ?>
							</select>
						</div>							  
					</div>
		       </div>
			   
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Design Team</label><span class="mandatory font-red">*</span>
							<select class="form-control" name="design_team_id" required>
								<option value="">Select Design Team</option>
								<?php foreach($design_team as $design_row){ ?>
								<option value = "<?php echo($design_row['id'])?>" ><?php echo($design_row['name']); ?></option>
								<?php } ?>
							</select>
						</div>							  
					</div>
				</div>
			   
				<div class="row">	
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Group</label><span class="mandatory font-red">*</span>
							<select class="form-control" name="group_id" required>
								<option value="">Select Group</option>
								<?php foreach($group as $group_row){ ?>
								<option value = "<?php echo($group_row['id'])?>" ><?php echo($group_row['name']); ?></option>
								<?php } ?>
							</select>
						</div>											  
					</div>
				</div>
			   
				<div class="row">		
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Help desk</label><span class="mandatory font-red">*</span>
							<select class="form-control" name="help_desk" required>
								<option value="">Select Help Desk</option>
								<?php foreach($help_desk as $hd_row){ ?>
								<option value = "<?php echo($hd_row['id'])?>" ><?php echo($hd_row['name']); ?></option>
								<?php } ?>
							</select>
						</div>				  
					</div>
				</div>
			   
				<div class="row">	
					<div class="col-md-6">
						<div class="form-group">
							<label class="margin-top-5">Channel</label><span class="mandatory font-red">*</span>
							<select class="form-control" name="channel" required>
								<option value="">Select Channels</option>
								<?php foreach($channels as $ch_row){ ?>
								<option value = "<?php echo($ch_row['id'])?>" ><?php echo($ch_row['name']); ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group">
							<label class="margin-top-5">Slug Type</label><span class="mandatory font-red">*</span>
							<select class="form-control" name="slug_type" required>
								<option value="">Select Slug Type</option>
								<?php foreach($slug_type as $slug_type_row){ ?>
								<option value = "<?php echo ($slug_type_row['id'])?>"><?php echo($slug_type_row['name']);?></option>
								<?php }?>	
							</select>
						</div>						  
					</div>				
		       </div>
				</div>
			 <div class="modal-footer">	
			    <a href="<?php echo base_url().index_page()."admin/home/publications_list";?>" type="button" class="btn red-flamingo">Back</a>
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