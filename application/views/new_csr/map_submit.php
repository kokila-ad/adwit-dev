<?php $this->load->view("new_csr/head");?>
<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">

	<!-- BEGIN PAGE CONTENT -->
	<div class="page-content">
		<div class="container">
			
        <div class="row">
			<div class="col-md-12">							
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-green-sharp bold ">
									Order Submit Form </span>
							</div>
							<div class="actions">
								<a onclick="goBack()" class="btn btn-default btn-circle">
								<i class="fa fa-angle-left"></i>
								<span class="hidden-480">
								Back </span>
								</a>
							</div>
						</div>
						
						<div class="portlet-body form">
					<!-- BEGIN FORM-->								
					
							<form id="order_form"  name="order_form" method="post" onsubmit="return validateForm()" enctype="multipart/form-data">
								<div class="form-body">
									
									<div class="row margin-top-15">
										<div class="col-md-6">
												<label>Unique Job ID </label>
												<input type="text" class="form-control margin-bottom-15" id="job_name" name="job_name" value="<?php echo $map_orders['job_name']; ?>" required>
												
												<label>Order Type </label>
												<select class="form-control margin-bottom-15" id="order_type" name="order_type" required>
													<option value="" >Select</option>
													<option value="2" <?php if($map_orders['order_type_id']=='2'){echo'selected';} ?>> Print </option>
													<option value="1" <?php if($map_orders['order_type_id']=='1'){echo'selected';} ?>> Web </option>
												</select>
												
												<label>Ad Type </label>
												
												<label>Advertiser</label>
												<input type="text" class="form-control margin-bottom-15" id="advertiser" name="advertiser" value="<?php echo $map_orders['adv_id']; ?>" readonly />
												
												<label>Publication Name</label>
												<?php $publications = $this->db->query("SELECT  publications.id, publications.name FROM `publications` WHERE `id` = '".$publication_id."'")->result_array();	?>
												<select id="publication_name" name="publication_name" class="form-control margin-bottom-15" required>
													<?php foreach($publications as $pub){ ?>
														<option value="<?php echo $pub['id']; ?>"> <?php echo $pub['name']; ?> </option>
													<?php } ?>
												</select>
												
											<?php if($map_orders['order_type_id']=='2'){ ?>	
												<label>Color/B&W/Spot  <span class="font-red">*</span></label>
												<select id="color" name="print_ad_type" class="form-control margin-bottom-15">
													<option value="" >Select</option>
													<option value="1" <?php if($map_orders['print_ad_type']=='1'){echo'selected';} ?>> Color </option>
													<option value="2" <?php if($map_orders['print_ad_type']=='2'){echo'selected';} ?>> B&W </option>
													<option value="3" <?php if($map_orders['print_ad_type']=='3'){echo'selected';} ?>> Spot </option>
												</select>
											<?php }elseif($map_orders['order_type_id']=='1'){ ?>
												<label>Static/Animated  <span class="font-red">*</span></label>
												
													<input type="text" class="form-control margin-bottom-15" id="web_ad_type" name="web_ad_type" value="<?php echo $map_orders['web_ad_type']; ?>" readonly />
												
											<?php } ?>
												<label for="name">Art Instruction  <span class="font-red">*</span></label>
												<div class="input-group">
													<div class="icheck-inline">
														<?php 
															$results = $this->db->get('cat_artinstruction')->result_array();
															foreach($results as $result){ 
														?>
															<label class="">
															<input type="radio" name="artinst" id="artinst" value="<?php echo $result['id']; ?>" required="required"><?php echo $result['name'];?></label>
														<?php } ?>													
													</div>
												</div>
												
												
										</div>

										<div class="col-md-6">	
												<label>AdRep <span class="font-red">*</span></label>
												<?php 
													if($map_orders['user_id'] != 0 || $map_orders['user_id'] != NULL){
														$adreps = $this->db->query("SELECT  adreps.id, adreps.first_name, adreps.last_name FROM adreps WHERE `id` = '".$map_orders['user_id']."'")->result_array();
													}else{
														$adreps = $this->db->query("SELECT  adreps.id, adreps.first_name, adreps.last_name FROM adreps WHERE `publication_id` = '".$publication_id."'")->result_array();
													}
												?>
												<select id="adrep" name="adrep" class="form-control margin-bottom-15" required>
													<?php foreach($adreps as $users){ ?>
														<option value="<?php echo $users['id']; ?>"> <?php echo $users['first_name'].$users['last_name']; ?> </option>
													<?php } ?>
												</select>
											<?php if($map_orders['order_type_id']=='2'){ ?>	
												<label for="name">Width <small>(in inches)</small> <span class="font-red">*</span></label>
												<input type="text" class="form-control margin-bottom-15" id="width" name="width" value="<?php echo $map_orders['width']; ?>" required>
												
												<label for="name">Height <small>(in inches)</small> <span class="font-red">*</span></label>
												<input type="text" class="form-control margin-bottom-15" id="height" name="height" value="<?php echo $map_orders['height']; ?>" required>
											<?php 
											}elseif($map_orders['order_type_id']=='1'){ ?>
													<label for="name">size <small>(in pixels)</small> <span class="font-red">*</span></label>
													<select class="form-control input-sm margin-bottom-15" name="pixel_size" required >
														<option value="">Select</option>
														<?php  $pixel_sizes = $this->db->get('pixel_sizes')->result_array();
																foreach($pixel_sizes as $row){
														?>
														<option value="<?php echo $row['id']; ?>" <?php if($row['id'] == $map_orders['pixel_size']) echo'selected="selected"'; ?>>
														<?php echo $row['width'].' X '.$row['height'].' ('.$row['name'].')'; ?>
														</option>
														<?php } ?>
														<option value="custom" <?php if($map_orders['pixel_size'] == 'custom') echo 'selected="selected"';?>>Custom</option>
													</select>
												<div class="row margin-bottom-15 custom box">
													<div class="col-md-6 col-sm-6 col-xs-6">
														 <p class="margin-bottom-5">Width <span class="text-red">*</span> <small class="text-grey">(in Pixels)</small></p>
														 <input type="number" name="custom_width" value="<?php echo $map_orders['custom_width']; ?>" pattern="[1-9]{1,50}" min="1" class="form-control input-sm">
													</div>
													<div class="col-md-6 col-sm-6 col-xs-6"> 
														<p class="margin-bottom-5">Height <span class="text-red">*</span> <small class="text-grey">(in Pixels)</small></p>
														<input type="number" name="custom_height" value="<?php echo $map_orders['custom_height']; ?>" pattern="[1-9]{1,50}" min="1" class="form-control input-sm">
													</div>
												</div>	
											<?php } ?>
												<label for="name">Ad Type  <span class="font-red">*</span></label></br>
												<div class="input-group">
														<div class="radio-list">
															<?php $results = $results = $this->db->get('cat_new_adtype')->result_array();
																foreach($results as $result){ ?>
															<label class="">
															<input type="radio" name="adtype" id="adtype" value="<?php echo $result['id']; ?>" required="required"><?php echo $result['name'];?></label>
															<!--<div><input type="radio" name="adtype" id="adtype" value="<?php echo $result['id']; ?>" onClick="run(this.value);" required="required"></div><?php echo $result['name'];?>-->
						<?php }  ?>						</div>
												</div>
										</div>
									</div>
																													
									<div class="row margin-top-15">
										<div class="col-md-6">
											<div class="form-group">
												<label>CSR Instruction</label>
													<input type="text" name="instruction" class="form-control">
											</div>
										</div>
									</div>
								
									<div class="row margin-top-15">	
										<div class="col-md-6">
											<label class="bold">Attach File(s)</label>
											<div class="form-group">
											  <label for="name">File 1
											  <input type="file" name="ufile[]" id="ufile[]"  accept="application/pdf"></label>
											 </div>
										
											<div class="form-group">
											  <label for="name">File 2
											  <input type="file" name="ufile[]" id="ufile[]"  accept="application/pdf"></label>
											 </div>
										
											  <div class="form-group">
											  <label for="name">File 3
											  <input type="file" name="ufile[]" id="ufile[]"  accept="application/pdf"></label>
											 </div>
										 </div>
										<div class="col-md-6">
											<label class="bold">MAP File Attachments</label>
											<p>
											<?php
												$map_dir = 'map_downloads/'.$map_orders['map_id'].'.zip'; 
												if(file_exists($map_dir)){
											?>
												<input type="text" name="attachfile" value="<?php echo $map_dir; ?>" style="display:none"/>
												<a href="<?php echo base_url()?>download.php?file_source=<?php echo $map_dir; ?>" >
													<?php echo basename($map_dir);  ?>
												</a>
											<?php	} ?>
											</p>
										</div>
									</div>
								</div>		
								<div class="form-actions right">
								<input name="id" value="<?php echo $map_orders['id'];?>" readonly style="display:none;" />
								<input name="map_order_id" value="<?php echo $map_orders['map_id'];?>" readonly style="display:none;" />
									<button name="order_submit" type="submit" class="btn blue">Submit</button>
								</div>
							
							</form>
					</div>
					<!-- END FORM-->
						
					</div>
					
				</div>		
	</div>

</div>					

</div><!-- END PAGE CONTAINER -->
<script type="text/javascript">
			$(document).ready(function(){
				$("select").change(function(){
					$(this).find("option:selected").each(function(){
						if($(this).attr("value")=="custom"){
							$(".box").not(".custom").hide();
							$(".custom").show();
						}
					   else{
							$(".box").hide();
						}
					});
				}).change();
			});
</script>

<!-- BEGIN PRE-FOOTER -->
	
<!-- END PRE-FOOTER -->
<?php $this->load->view("new_csr/foot");?>