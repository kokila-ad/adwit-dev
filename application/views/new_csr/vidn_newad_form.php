<?php $this->load->view('new_csr/head'); ?>
<!--print ad start-->				
<div class="col-md-12">
	<div class="portlet box blue">
	<?php echo '<h3 style="color:#900;">'.$this->session->flashdata('message').'</h3>'; ?>
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-gift"></i>VIDN - <?php echo $vidn['vidn_type'] ?> - Print Ad
			</div>
			<div class="tools">
				<a href="javascript:;" class="collapse"></a>
			</div>
		</div>
		<div class="portlet-body form">
			<!-- BEGIN FORM-->
			<form name="form" method="post" enctype="multipart/form-data" class="horizontal-form">
				<div class="form-body">
					<h3 class="form-section"><?php echo $adrep['first_name']; ?> <?php echo $adrep['last_name']; ?></h3>
					<div class="row form-section">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Unique Job Name<span style="font-size: 11px; font-weight: normal;">(only alphanumeric characters allowed)</span></label>
								<input type="text" name="job_name" type="text" value="<?php echo $vidn['job_no'];?>" autocomplete="off" class="form-control" required="required">
								<span class="help-block">adrep provided job name</span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Advertiser Name</label>
								<input type="text" name="advertiser"  value="<?php echo $vidn['advertiser_name'];?>"  autocomplete="off" class="form-control" required="required">
								<span class="help-block">client name</span>
							</div>
						</div>
						<!--/span-->
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Width</label>
								<input type="number" step="0.0001" min=0 value="<?php echo $vidn['width'];?>" id="width" name="width" autocomplete="off" onchange="handleChange(this);" class="form-control" required="required">
								<span class="help-block">In inches </span>
							</div>
						</div>
						<!--/span-->
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Height</label>
								<input type="number" step="0.0001" min=0 id="height" name="height" value="<?php echo $vidn['height'];?>" autocomplete="off" onchange="handleChange(this);" class="form-control" required="required">
								<span class="help-block">	In inches  </span>
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
										$results = $print_ad_types;
										foreach($results as $result){ 
									?>
										<label class="">
											<div class="iradio_square-grey" style="position: relative;">
												<input type="radio" value="<?php echo $result['id']; ?>" <?php if($vidn['print_ad_type']==$result['id'])echo "checked= 'checked'"; ?> id="print_ad_type" name="print_ad_type" required="required" class="icheck" data-radio="iradio_square-grey" style="position: absolute; opacity: 0;">
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
								<input type="text" name="copy_content_description" id="copy_content_description" class="form-control" value="<?php echo $vidn['copy_content_description'];?>">
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
										$results = $artinst;
										foreach($results as $result){ 
									?>
										<label class="">
											<div class="iradio_square-grey" style="position: relative;"><input type="radio" name="artinst" id="artinst" value="<?php echo $result['id']; ?>" required="required" class="icheck" data-radio="iradio_square-grey" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div><?php echo $result['name'];?></label>
									<?php } ?>													
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row form-section">	
						<div class="col-md-6">
							<div class="form-group">
								<label>Ad Type</label>
								<div class="input-group">
									<div class="icheck-list">
									<?php 
										$results = $adtype;
										foreach($results as $result){
									?>
										<label class="">
											<div class="iradio_square-grey" style="position: relative;"><input type="radio" name="adtype" id="adtype" value="<?php echo $result['id']; ?>" required="required" class="icheck" data-radio="iradio_square-grey" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div>
											<?php echo $result['name'];?>
										</label>
									<?php }  ?>													
									</div>
								</div>
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
<!--print ad end-->	
<?php $this->load->view('new_csr/foot'); ?>