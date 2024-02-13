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
												<input type="text" class="form-control margin-bottom-15" id="job_name" name="job_name" value="<?php echo $metro_orders[0]['job_num'].'_'.$metro_orders[0]['metro_ref']; ?>" required>
												
												<label>Order Type </label>
												<select class="form-control margin-bottom-15" id="order_type" name="order_type" required>
													<option value="" >Select</option>
													<option value="2" <?php if($metro_orders[0]['ad_type']=='Print'){echo'selected';} ?>> Print </option>
													<option value="1" <?php if($metro_orders[0]['ad_type']=='Web' || $metro_orders[0]['ad_type']=='digital' || $metro_orders[0]['ad_type']=='Digital'){echo'selected';} ?>> Web </option>
													<!--<option value="3" <?php if($metro_orders[0]['ad_type']=='Print & Web'){echo'selected';} ?>> Print & Web </option>-->
												</select>
												
												<label>Ad Type </label>
												<select id="color" name="color" class="form-control margin-bottom-15" required>
													<option value="" >Select</option>
													<option value="0" <?php if($metro_orders[0]['order_type']=='New'){echo'selected';} ?>> New </option>
													<option value="1" <?php if($metro_orders[0]['order_type']=='Pickup'){echo'selected';} ?>> Pickup </option>
													<option value="2" <?php if($metro_orders[0]['order_type']=='Resize'){echo'selected';} ?>> Resize </option>
												</select>
												
												<label>Advertiser</label>
												<input type="text" class="form-control margin-bottom-15" id="advertiser" name="advertiser" value="<?php echo $metro_orders[0]['advertiser']; ?>" readonly />
												
												<label>Publication Name</label>
												<input type="text" class="form-control margin-bottom-15" id="publication_name" name="publication_name" value="<?php echo $metro_orders[0]['publication']; ?>" readonly />
												
												<label>Color/B&W/Spot  <span class="font-red">*</span></label>
												<select id="color" name="color" class="form-control margin-bottom-15">
													<option value="" >Select</option>
													<option value="1" <?php if($metro_orders[0]['ad_color']=='Color'){echo'selected';} ?>> Color </option>
													<option value="2" <?php if($metro_orders[0]['ad_color']=='Black & White'){echo'selected';} ?>> B&W </option>
													<option value="3" <?php if($metro_orders[0]['ad_color']=='Spot'){echo'selected';} ?>> Spot </option>
												</select>
												
												<label for="name">Art Instruction  <span class="font-red">*</span></label>
												<div class="input-group">
																<div class="icheck-inline">
																	<?php $results = $this->db->get('cat_artinstruction')->result_array();
																	foreach($results as $result)
																	{ ?>
																	<label class="">
																	<input type="radio" name="artinst" id="artinst" value="<?php echo $result['id']; ?>" required="required"><?php echo $result['name'];?></label>
																	<!--<input type="radio"   name="artinst" id="artinst" value="<?php echo $result['id']; ?>" onClick="run1(this.value);"  required="required" class="icheck" data-radio="iradio_square-grey" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div><?php echo $result['name'];?></label>-->
																	<?php } ?>													
																</div>
												</div>
												
												
										</div>

										<div class="col-md-6">	
												<label>AdRep <span class="font-red">*</span></label>
												<?php 
												$pub_name = substr($metro_orders[0]['publication'],0,4);
													$adreps = $this->db->query("SELECT  adreps.id, adreps.first_name, adreps.publication_id
																		FROM adreps 
																			left outer join publications on adreps.publication_id = publications.id 
																				where publications.channel = '1';")->result_array();
												?>
												<select  id="adrep" name="adrep" class="form-control margin-bottom-15" required>
													<option value="">Select</option>
													<?php foreach($adreps as $users){ ?>
													<option value="<?php echo $users['id'].'_'.$users['publication_id']; ?>" <?php if(stristr($users['first_name'], $pub_name) == True){echo"selected";} ?>> <?php echo $users['first_name'].'-'.$pub_name; ?> </option>
													<?php } ?>
												</select>
												
												<label for="name">Width <small>(in inches)</small> <span class="font-red">*</span></label>
												<input type="text" class="form-control margin-bottom-15" id="width" name="width" value="<?php echo $metro_orders[0]['width']; ?>" required>
												
												<label for="name">Height <small>(in inches)</small> <span class="font-red">*</span></label>
												<input type="text" class="form-control margin-bottom-15" id="height" name="height" value="<?php echo $metro_orders[0]['height']; ?>" required>
												
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
											<label class="bold">Metro File Attachments</label>
											<p>
											<?php
												$i=1;
												$metro_file_path = pathinfo($metro_orders[0]['file']);
												$metro_dir = $metro_file_path['dirname']; 
												
												$this->load->helper('directory');
												$metro_file_map = glob($metro_dir.'/*');
												
												if($metro_file_map){ foreach($metro_file_map as $row){ 
													$dir = dirname($row);
													$dir = explode('/', $dir);
													if(is_dir($row)){ 
														$map2 = glob($row.'/*');
														foreach($map2 as $row2){
															$dir2 = dirname($row2);
															$dir2 = explode('/', $dir2);
											?>
											<input type="text" name="attachfile[]" value="<?php echo $row2; ?>" style="display:none"/>
												<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row2; ?>" >
													<?php echo basename($row2);  ?>
												</a>	
												<a href="<?php echo 'http://192.249.113.204/~adwitac/metroaod/incoming/New Order/'.end($dir).'/'.end($dir2).'/'.basename($row2); ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
												<!--<a href="<?php echo 'http://adwitdigital.com/metroaod/'.end($dir).'/'.end($dir2).'/'.basename($row2); ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>-->
												<br/>
											<?php } }else{ $ext = pathinfo($row, PATHINFO_EXTENSION); 
												if($ext!='csv' && $ext!='xls'){
													
											?>
											<input type="text" name="attachfile[]" value="<?php echo $row; ?>" style="display:none"/>
												<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" >
													<?php echo basename($row);  ?>
												</a>	
												<a href="<?php echo 'http://192.249.113.204/~adwitac/metroaod/incoming/New Order/'.end($dir).'/'.basename($row); ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
												<!--<a href="<?php echo 'http://adwitdigital.com/metroaod/'.end($dir).'/'.basename($row); ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>-->
												<br/>
												
										<?php } } } } ?>
										</p>
										</div>
									</div>
								</div>		
								<div class="form-actions right">
								<input name="id" value="<?php echo $metro_orders[0]['id'];?>" readonly style="display:none;" />
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


<!-- BEGIN PRE-FOOTER -->
	
<!-- END PRE-FOOTER -->
<?php $this->load->view("new_csr/foot");?>