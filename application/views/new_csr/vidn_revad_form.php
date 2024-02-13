<?php $this->load->view("new_csr/head.php"); ?>

 <div class="page-container">
	<!-- BEGIN PAGE CONTENT -->
	<div class="page-content" style="min-height: 598px;">
		<div class="container">	
			<!-- BEGIN PROFILE -->
			<div class="row margin-top-10">
				<div class="col-md-12">
					<!-- BEGIN PROFILE CONTENT -->
					<div class="profile-content">
						<div class="row">				  						   
						   <div class="col-md-12">
								<div class="portlet light">
								<?php echo '<h3 style="color:#900;">'.$this->session->flashdata('message').'</h3>'; ?>
								<?php echo '<h3 style="color:#900;">'.$this->session->flashdata('message2').'</h3>'; ?>
									<div class="portlet-title">
									<!--	<div class="caption">
											<span class="caption-subject grey-gallery">Submit Revision</span>
										</div>	-->
										<div class="actions">
											<a onclick="goBack()" class="btn btn-default btn-circle btn-xs">
											<i class="fa fa-angle-left"></i>
											<span class="hidden-480">
											Back </span>
											</a>
										</div>
									</div>
									<div class="row portlet-body">
										<form id="order_form" name="order_form" method="post">
											<div class="col-md-6">
												<div class="form-group">
													<label>Order Id</label>
													<input type="text" id="order_id" name="order_id" <?php if(isset($order_id))echo"value='$order_id'"; ?> placeholder="Order Id, Job Name" required="required" /> 
													<span><button type="submit" name="order_search" value="submit">Search</button></span>
												</div>
											</div>
										</form>
									</div>
 
<form id="rev_order_form" name="rev_order_form" method="post">
	<div class="row portlet-body">
		<div class="col-md-6">
			<div class="form-group">
				<label>Job Name</label>
				<input type="text" class="form-control" id="job_no" name="job_no" value="<?php echo $vidn['job_no'];?>" readonly />
			</div>
			
			<div class="form-group">
				<strong>Adwit Id</strong>
				<div class="radio-list">
				<?php if(isset($orders)){ foreach($orders as $row){ ?>
					<label> <input type="radio" name="adwit_order_id" id="adwit_order_id" value="<?php echo $row['id']; ?>" required="required"><?php echo $row['id'];?></label>
				<?php } } ?>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>Copy & Content <small class="font-red">*</small></label>
				<textarea class="form-control" name="copy_content_description" id="copy_content_description"  style="width: 80%; height: 80px;" ><?php echo $vidn['copy_content_description'];?></textarea>
			</div>
			
			<strong>Attach Files</strong>
			<div class="form-group">
				<label>File 1</label>
				<input class="input-file uniform_on" type="file" name="ufile[]" id="ufile[]" value="upload" accept="application/pdf" />
			</div>
			<div class="form-group">
				<label>File 2 </label>
				<input type="file" name="ufile[]" id="ufile[]" value="upload" accept="application/pdf" />
			</div>
			
			<div class="form-group">
				<strong>Choose One Option</strong>
				<div class="radio-list">
				<?php foreach($rev_reason as $row){ ?>
					<label> <input type="radio" name="reason_option" id="reason_option" value="<?php echo $row['id']; ?>" required="required"><?php echo $row['name'];?></label>
				<?php } ?>
				</div>
			</div>   
			<div class="form-group margin-top-20">
				<input class="form-contro" type="checkbox" name="redesign" value="1" id="redesign"><strong>Redesign</strong>
			</div> 
			<div class="col-md-6 text-right margin-top-20">	
				<input class="btn btn-primary btn-block" name="rev_submit" type="submit" value="SUBMIT" onclick="show_me(this.form.file_name)" />
			</div>										
		</div>
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


<script language="javascript" type="text/javascript">

$("form").submit(function() { 

if ($('#loading_image').length == 0) { //is the image on the form yet?

                // add it just before the submit button

$(':submit').after('<img src="images/up.gif" alt="loading...." id="loading_image" >')

}

    $('#loading_image').show(); // show the animated image    

     // disable double submits

    return true; // allow regular form submission

});

</script>

<?php $this->load->view("new_csr/foot.php"); ?>
