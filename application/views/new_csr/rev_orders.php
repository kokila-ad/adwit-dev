<?php $this->load->view("new_csr/head.php"); ?>
<script>
	$(document).ready(function() {
 //revision classification confirmation box
	   $(".reason_option").on('click', function(){
	        var id = $(this).data("id");
	        var content = '<label> <small> Client Dislike</small> <input type="radio" name="new_content" value="1" required> Yes <input type="radio" name="new_content" value="0"> No </label>';
            //if(id == 1 || id == 3 || id == 4){
                $("#confirmation_div").html(content);
            //}else{
            //    $("#confirmation_div").html('');
            //}
        });
	});
</script>
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
									<div class="portlet-title">
										<div class="caption">
											<span class="caption-subject grey-gallery">Submit Revision</span>
										</div>	
										<div class="actions">
											<a onclick="goBack()" class="btn btn-default btn-circle btn-xs">
											<i class="fa fa-angle-left"></i>
											<span class="hidden-480">
											Back </span>
											</a>
										</div>
										<div class="tools margin-right-10">
											<?php echo '<h3 style="color:#900;">'.$this->session->flashdata('message2').'</h3>'; ?>
										</div>
									</div>
									<div class="row portlet-body">
										<form id="order_form" name="order_form" method="post" enctype="multipart/form-data">
												  <div class="col-md-6">
													<div class="form-group">
													   <label>Adwit Ads ID</label>
													   <input type="text" class="form-control" id="order_id" name="order_id" value="<?php echo $order; ?>" readonly />
													</div>
													
													<div class="form-group">
														<label>Unique Job ID</label>
														<input type="text" class="form-control" id="job_name" name="job_name" value="<?php echo $cat_result['job_name']; ?>" readonly />
													</div>
													
													<div class="form-group">
														<label>Job Slug</label>
														<input type="text" class="form-control" id="job_slug" name="job_slug"  value="<?php echo $slug;?>" readonly /> 
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
												 </div>
												 
												 <div class="col-md-6">
													<div class="form-group">
														<label>Notes & Instructions <small class="font-red">*</small></label>
														<textarea class="form-control" name="copy_content_description" id="copy_content_description"  style="width: 80%; height: 80px;"  ></textarea>
												    </div>
													
													<div class="form-group">
													  <strong>Choose One Option</strong>
													  <div class="radio-list">
													   <?php foreach($rev_reason as $row){ ?>
														<label class="reason_option" data-id="<?php echo $row['id']; ?>"> 
														    <input type="radio" name="reason_option" id="reason_option" value="<?php echo $row['id']; ?>" required="required"><?php echo $row['name'];?>
														</label>
													   <?php } ?>
													  </div>
													  <div id="confirmation_div"></div>
													</div>  
													
													<div class="form-group margin-top-20">
														<input class="form-contro" type="checkbox" name="redesign" value="1" id="redesign"><strong>Redesign</strong>
													</div> 
													
												 </div>
												 
												 <hr>
												 
												<div class="col-md-12 text-right margin-top-20">
													<input class="btn btn-primary btn-block" name="submit" type="submit" value="SUBMIT" onclick="show_me(this.form.file_name)" />
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
 </div>


<script language="javascript" type="text/javascript">

$("form").submit(function() {

if ($('#loading_image').length == 0) { //is the image on the form yet?

                // add it just before the submit button

$(':submit').after('<img src="images/up.gif" alt="Uploading...." id="loading_image" >')

}

    $('#loading_image').show(); // show the animated image    

     // disable double submits

    return true; // allow regular form submission

});

</script>

<?php $this->load->view("new_csr/foot.php"); ?>
