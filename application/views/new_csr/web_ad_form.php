<script type="text/javascript">
	
	$(document).ready(function(e) {    

		$('#pixel_size').change(function(e) {
            if($('#pixel_size').val()=='custom') $('#ad-form-sr-custom').show();
			else $('#ad-form-sr-custom').hide();
        });		
		<?php if(set_value('pixel_size')=='custom'):?>
			$('#ad-form-sr-custom').show();
		<?php else:?>
			$('#ad-form-sr-custom').hide();
		<?php endif;?>
	});
</script>
<div class="col-md-12">
											
								<div class="portlet box blue">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-gift"></i><?php echo $publication_details[0]['name'].' '; ?>
											- Web Ad
										</div>
										<div class="tools">
											<a href="javascript:;" class="collapse">
											</a>
											<!--<a href="#portlet-config" data-toggle="modal" class="config">
											</a>
											<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()">
												</a>
											<a href="javascript:;" class="remove">
											</a>-->
										</div>
									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form name="form" method="post" enctype="multipart/form-data" class="horizontal-form">
											<div class="form-body">
												<h3 class="form-section"><?php echo $adrep_details[0]['first_name']; ?> <?php echo $adrep_details[0]['last_name']; ?></h3>
												<div class="row form-section">
													<div class="col-md-6">
													<?php if(isset($order)){ ?>
														<div class="form-group">
															<label class="control-label">Pickup Number</label>
															<input name="pickup_adno" type="text" value="<?php echo $order['id'];?>" readonly class="form-control" >
															<span class="help-block">
															</span>
														</div>
													<?php }else{ ?>
														<div class="form-group">
															<label class="control-label">Unique Job Name<span style="font-size: 11px; font-weight: normal;">(only alphanumeric characters allowed, no multiple spacing)</span></label>
															<input type="text" name="job_name" pattern="[a-zA-Z0-9 ]{1,50}" type="text" value="<?php echo set_value('job_name');?>" autocomplete="off" class="form-control job_no" required="required">
															<span class="help-block">
															adrep provided job name</span>
														</div>
													<?php } ?>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Advertiser Name</label>
															<input type="text" name="advertiser"  value="<?php if(isset($order))echo $order['advertiser_name'];else echo set_value('advertiser');?>"  autocomplete="off" class="form-control" required="required">
															<span class="help-block">
															client name</span>
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Size (in Pixels)</label>
															<select class="form-control" id="pixel_size" name="pixel_size">
																<option value="">Select</option>
																<?php
																	$results = $this->db->get('pixel_sizes')->result_array();
																	foreach($results as $result)
																	{
																		echo '<option value="'.$result['id'].'" '.($result['id']==$order['pixel_size'] ? 'selected="selected"': '').' >'.$result['width'].' x '.$result['height'].'('.$result['name'].')'.'</option>';					
																	}
																?>
																<option value="custom" >Custom</option>
															</select>
															<span class="help-block">
															In Pixels </span>
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Maximum File Size </label>
															<input type="number" min='0' id="maxium_file_size" name="maxium_file_size" value="<?php if(isset($order))echo $order['maxium_file_size'];else echo set_value('maxium_file_size');?>" autocomplete="off" class="form-control" required="required">
															<span class="help-block">
															In KBs  </span>
														</div>
													</div>
													<!--/span-->
														<!--custom size -->
													<div id="ad-form-sr-custom">
														<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Width</label>
															<input type="number" step="0.0001" min='0'  value="<?php echo set_value('custom_width');?>" id="custom_width" name="custom_width" autocomplete="off"  class="form-control">
															<span class="help-block">
															In Pixels </span>
														</div>
														</div>
														<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Height</label>
															<input type="number" step="0.0001" min='0' id="custom_height" name="custom_height" value="<?php echo set_value('custom_height');?>" autocomplete="off" class="form-control">
															<span class="help-block">
															In Pixels  </span>
														</div>
														</div>
													</div>
												</div>
											<div class="row form-section">
												<?php if(isset($order)){ ?>
												<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Unique Job Name<span style="font-size: 11px; font-weight: normal;">(only alphanumeric characters allowed)</span></label>
															<input type="text" name="job_name" pattern="[a-zA-Z0-9 ]{1,50}" value="<?php echo set_value('job_name');?>" autocomplete="off" class="form-control job_no" required="required">
															<span class="help-block">
															adrep provided job name</span>
														</div>
													</div>
												<?php } ?>
												<div class="col-md-6">
												<div class="form-group">
															<label>Web Ad Type</label>
															<div class="input-group">
																<div class="icheck-inline">
																
																	<label class="">
																	<div class="iradio_square-grey" style="position: relative;">
																	<input type="radio" value="Static" <?php if(isset($order) && $order['web_ad_type']=='Static')echo "checked= 'checked'"; ?> id="web_ad_type" name="web_ad_type" required="required" class="icheck" data-radio="iradio_square-grey" style="position: absolute; opacity: 0;">
																	<ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
																	</div>
																	Static
																	</label>
																	<label class="">
																	<div class="iradio_square-grey" style="position: relative;">
																	<input type="radio" value="Animated" <?php if(isset($order) && $order['web_ad_type']=='Animated')echo "checked= 'checked'"; ?> id="web_ad_type" name="web_ad_type" required="required" class="icheck" data-radio="iradio_square-grey" style="position: absolute; opacity: 0;">
																	<ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
																	</div>
																	Animated
																	</label>													
																</div>
															</div>
														</div>
														</div>
												<div class="col-md-6">
													<div class="form-group">
															<label>Format</label>
															<div class="input-group">
																<div class="icheck-inline">
																	<?php
																	$results = $this->db->get('web_ad_formats')->result_array();
																	foreach($results as $result)
																	{ ?>
																	<label class="">
																	<div class="iradio_square-grey" style="position: relative;">
																	<input type="radio" value="<?php echo $result['id']; ?>" <?php if(isset($order) && $order['ad_format']==$result['id'])echo "checked= 'checked'"; ?> id="ad_format" name="ad_format" required="required" class="icheck" data-radio="iradio_square-grey" style="position: absolute; opacity: 0;">
																	<ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
																	</div><?php echo $result['name'];?></label>
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
															<input type="text" name="copy_content_description" id="copy_content_description" class="form-control">
														</div>
													</div>
												</div>
										<div class="row form-section">
												<div class="col-md-6">
												<div class="form-group">
															<label>Art Instruction</label>
															<div class="input-group">
																<div class="icheck-inline">
		<?php $results = $artinst;
		foreach($results as $result)
		{ ?>
																	<label class="">
																	<div class="iradio_square-grey" style="position: relative;"><input type="radio" name="artinst" id="artinst" value="<?php echo $result['id']; ?>" required="required" class="icheck" data-radio="iradio_square-grey" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div><?php echo $result['name'];?></label>
																	<?php } ?>													</div>
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
																<?php $results = $adtype;
																foreach($results as $result)
																{?>
																	<label class="">
																	<div class="iradio_square-grey" style="position: relative;"><input type="radio" name="adtype" id="adtype" value="<?php echo $result['id']; ?>" required="required" class="icheck" data-radio="iradio_square-grey" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div><?php echo $result['name'];?></label>
																	<?php }  ?>													</div>
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
													  <div class="form-group">
													  <label for="exampleInputFile1">File input</label>
													  <input type="file" name="ufile[]" id="ufile[]" value="upload" />
													 </div>
												 </div>
										</div>
											</div>
											<div class="form-actions right">
												<a  onclick="goBack()" type="button" class="btn default">Cancel</a>
												<button type="submit" name="Submit" class="btn blue">Submit</button>
											</div>
										</form>
										<!-- END FORM-->
									</div>
								</div>
								
				</div>		
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