<?php $this->load->view('new_csr/head'); ?>
<!-- END HEADER -->
<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<div class="page-content">
		<div class="container">
		    <div class="col-md-12">
											
								<div class="portlet box blue">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-gift"></i><?php echo $tscs_preorder_detail['publicationName'].' '; ?>- Print Ad
										</div>
										<div class="tools">
											<a href="javascript:;" class="collapse">
											</a>
											
										</div>
									</div>
									<?php echo '<span style="color:#900;">'.$this->session->flashdata('message').'</span>'; ?>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form name="form" id="myForm" method="post" enctype="multipart/form-data" class="horizontal-form">
											<div class="form-body">
												<h4 class="form-section"><?php echo $tscs_preorder_detail['adrepName']; ?></h4>
												<div class="row form-section">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Unique Job Name<span style="font-size: 11px; font-weight: normal;">(only alphanumeric characters allowed, no multiple spacing)</span></label>
																<input type="text" name="job_name" pattern="[a-zA-Z0-9 ]{1,50}" type="text" value="<?php echo $tscs_preorder_detail['job_no'];?>" autocomplete="off" class="form-control job_no" required="required">
															<span class="help-block">
															adrep provided job name</span>
														</div>
													</div>
													<!--/span-->
													
													
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Advertiser Name</label>
															<input type="text" name="advertiser"  value="<?php echo $tscs_preorder_detail['advertiser_name'];?>"  autocomplete="off" class="form-control" required="required">
															<span class="help-block">
															client name</span>
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Width</label>
															<input type="number" step="0.0001" min=0 value="<?php echo $tscs_preorder_detail['width'];?>" id="width" name="width" autocomplete="off" onchange="handleChange(this);" class="form-control" required="required">
															<span class="help-block">
															In inches </span>
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Height</label>
															<input type="number" step="0.0001" min=0 id="height" name="height" value="<?php echo $tscs_preorder_detail['height'];?>" autocomplete="off" onchange="handleChange(this);" class="form-control" required="required">
															<span class="help-block">
															In inches  </span>
														</div>
													</div>
													<!--/span-->
												</div>
											<div class="row form-section">
												<div class="col-md-6">
												    <div class="form-group">
															<label>Color/B&W/Spot</label>
															<div class="input-group">
																<div class="icheck-inline">
																<?php 
																    $print_ad_type = '';
																    if($tscs_preorder_detail['ad_color_info'] == 'Full Process'){
																        $print_ad_type = 'Color';    
																    }elseif($tscs_preorder_detail['ad_color_info'] == 'BW'){
																        $print_ad_type = 'B&W';
																    }
																    
																	$results = $this->db->query("SELECT * FROM `print_ad_types` ")->result_array();
																	foreach($results as $result){ 
																?>
																	<label class="">
    																	<div class="iradio_square-grey" style="position: relative;">
    																		<input type="radio" value="<?php echo $result['id']; ?>" <?php if($print_ad_type == $result['name'])echo "checked= 'checked'"; ?> id="print_ad_type" name="print_ad_type" required="required" class="icheck" data-radio="iradio_square-grey" style="position: absolute; opacity: 0;">
    																		<ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
    																	</div>
    																	<?php echo $result['name'];?>
																	</label>
																	<?php } ?>
																</div>
															</div>
													</div>
												</div>
											</div>
												<div class="row form-section">
													<div class="col-md-12 ">
														<div class="form-group">
															<label>Copy & Content</label>
															<textarea rows="6" name="copy_content_description" data-max-length-warning="Input must be 5000 characters or less" data-max-length="5000" data-max-length-warning-container="name" 
															class="js-max-char-warning form-control input-sm margin-bottom-15 txtLimits1 " type="text" id="yourtextarea1" required="">
															    <?php echo $tscs_preorder_detail['notes'];?>    
															</textarea>
															<div  style="color:red;"> <span class="name"></span></div>
														</div>
													</div>
												</div>
										    <div class="row form-section">
												<div class="col-md-6">
												    <div class="form-group">
													    <label>Art Instruction</label>
														<div class="input-group">
															<div class="icheck-inline">
															<?php
																$cat_artinstruction = $this->db->query("SELECT * FROM `cat_artinstruction`")->result_array();
																foreach($cat_artinstruction as $result){ 
															?>
																<label class="">
																    <div class="iradio_square-grey" style="position: relative;">
																        <input type="radio" name="artinst" id="artinst" value="<?php echo $result['id']; ?>" required="required" class="icheck" data-radio="iradio_square-grey" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
																    </div>
																	<?php echo $result['name'];?>
																</label>
																<?php } ?>							
															</div>
														</div>
												    </div>
												</div>
												<div class="col-md-6">
												 <p><input type="checkbox" name="rush" value="1" style="width:20px;"> 
													<label for="name"><span></span>Rush</label></p>
												</div>
										    </div>
										    <div class="row form-section">	
												<div class="col-md-6">
												    <div class="form-group">
														<label>Ad Type</label>
														<div class="input-group">
															<div class="icheck-list">
																<?php 
																	$cat_new_adtype = $this->db->query("SELECT * FROM `cat_new_adtype`")->result_array();    
																	foreach($cat_new_adtype as $result){
																?>
																	<label class="">
																	<div class="iradio_square-grey" style="position: relative;"><input type="radio" name="adtype" id="adtype" value="<?php echo $result['id']; ?>" required="required" class="icheck" data-radio="iradio_square-grey" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div><?php echo $result['name'];?></label>
																<?php }  ?>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-6">
													 <div class="form-group">
													  <label for="exampleInputFile1">File input</label>
													  <input type="file" name="ufile[]" id="ufile[]" value="upload" />
													 </div>
													  <div class="form-group">
													  <label for="exampleInputFile1">File input</label>
													  <input type="file" name="ufile[]" id="ufile[]" value="upload" />
													 </div>
													  <div class="form-group">
													  <label for="exampleInputFile1">File input</label>
													  <input type="file" name="ufile[]" id="ufile[]" value="upload" />
													 </div>
													 <label for="exampleInputFile1">
													     <a href="<?php echo $tscs_preorder_detail['zip_file_path']; ?>"><?php echo basename($tscs_preorder_detail['zip_file_path']); ?></a>
													 </label>
												</div>
										    </div>
										</div>
											<div class="form-actions right">
												<button type="submit" name="cancelSubmit" onclick="return confirm('Click OK to continue?')" class="btn default" formnovalidate>Cancel</button>
												<button type="submit" name="Submit" class="btn blue">Submit</button>
											</div>
										</form>
										<!-- END FORM-->
									</div>
								</div>
								
				</div>
	    </div>
    </div>
</div>

<link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
<link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
<link href="theme001/assets/DT_bootstrap.css" rel="stylesheet" media="screen">
<script src="theme001/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>

<script>
    var $message = $(".job_no");
    $message.on("blur", function() {    
        var $this = $(this),
            val = $(this).val()
                         .replace(/(\r\n|\n|\r)/gm," ") // replace line breaks with a space
                         .replace(/ +(?= )/g,''); // replace extra spaces with a single space
    
        $this.val(val);
    });
</script> 
<script>
	$.fn.maxCharWarning = function() {
        return this.each(function() {
            var el                    = $(this),
                maxLength             = el.data('max-length'),
                warningContainerClass = el.data('max-length-warning-container'),
                warningContainer      = $('.'+warningContainerClass),
                maxLengthMessage      = el.data('max-length-warning')
            ;
            el.keyup(function() {
              var length = el.val().length;      
              if (length >= maxLength & warningContainer.is(':empty')){
                warningContainer.html(maxLengthMessage);
                el.addClass('input-error');
              }
              else if (length < maxLength & !(warningContainer.is(':empty'))) {
                warningContainer.html('');
                el.removeClass('input-error');
              }
            });
        });
    };

    $('.js-max-char-warning').maxCharWarning();
    $('.js-max-char-warning123').maxCharWarning();

    $("#yourtextarea1").keyup(function(){
    
    });
    $(document).ready(function() {
        $('.txtLimits1').on('input propertychange', function() {
            CharLimit(this,5000);
        });
    });

    function CharLimit(input, maxChar) {
        var len = $(input).val().length;
        if (len > maxChar) {
            $(input).val($(input).val().substring(0, maxChar));
        }
    }

</script>
<?php $this->load->view('new_csr/foot'); ?>