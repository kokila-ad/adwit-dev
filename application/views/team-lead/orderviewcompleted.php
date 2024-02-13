<?php $this->load->view('team-lead/head'); ?>
<style>
	textarea {
		resize: none;
	}
</style>
<script>
	 $(document).ready(function(){
	 $("#others1").hide();
	 $("#others2").hide();
	 $("#others3").hide();
  
	 $("#show_others1").click(function(){
		$("#others1").toggle();  	
	  });
	 
	  $("#show_others2").click(function(){
		$("#others2").toggle();  	
	  });
	  
	   $("#show_others3").click(function(){
		$("#others3").toggle();  	
	  });
	 
	  
	 });
 </script>


<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<!-- BEGIN PAGE HEAD -->
	<div class="page-content">
		<div class="container">
		<div class="row margin-top-10">
				<div class="col-md-12">
					
				<div class="profile-content">
									  						  								
        <div class="row">
			<div class="col-md-12">
					<!-- Begin: life time stats -->
				<div class="portlet light">
						<div class="portlet-title  margin-top-10">
							<div class="row static-info">
								<div class="col-md-6 value bold">Order #<?php echo $order_id; ?><?php foreach($orders as $row)
													 ?><small> &nbsp; (<?php echo $row['created_on']; ?>)</small>
								</div>
								<div class="col-md-6 text-right">
									<div class="tools">
										<span class="btn red-sunglo btn-xs margin-right-10"><strong>Status - </strong><?php 
								if($cat[0]['pro_status']!='0') { 
									$status = $this->db->query("SELECT * FROM `production_status` WHERE id='".$cat[0]['pro_status']."'")->result_array(); 
									echo $status[0]['name'];  
								} else { 
									$status1 = $this->db->query("SELECT * FROM `order_status` WHERE id='".$row['status']."'")->result_array(); 
									echo $status1[0]['name'];
								} ?></span> 
								<div class="col-md-12">
							<?php if($orders[0]['cancel']=='1') {
								echo "<a class='btn red'>Order has been Cancelled..!!</a>";
								} else if($orders[0]['crequest']=='1'){
								echo "<a class='btn red'>Request for Order Cancellation Sent To Adrep..!!</a>";
							}?>
						</div>
										<button onclick="goBack()" class="btn btn-default btn-xs">← Back</button>
									</div>
								</div>
							</div>
						</div>
					<div class="portlet-body">
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="portlet blue-hoki box">
									<div class="portlet-title">
										<div class="caption">Order Details</div>
									</div>
													
									<div class="portlet-body">
										<div class="row static-info">
											<div class="col-md-5 name">Unique Job Name:</div>
											<div class="col-md-7 value"><?php echo $row['job_no'];?></div>
										</div>
										<div class="row static-info">
											<div class="col-md-5 name">Ad Size:</div>
											<?php if($row['order_type_id']=='1'){ // webad 
														if($row['pixel_size']=='custom'){?>
											<div class="col-md-3 value">Width: <?php echo $row['custom_width']; ?></div>
											<div class="col-md-4 value">Height: <?php echo $row['custom_height']; ?></div>
											<?php } else {
														$size_px = $this->db->get_where('pixel_sizes',array('id'=>$row['pixel_size']))->result_array();
													?>
											<div class="col-md-3 value">Width: <?php echo $size_px[0]['width']; ?></div>
											<div class="col-md-4 value">Height: <?php echo $size_px[0]['height']; ?></div>
											<?php } }else{ //printad ?>
											<div class="col-md-3 value">Width: <?php echo $row['width']; ?></div>
											<div class="col-md-4 value">Height: <?php echo $row['height']; ?></div>
											<?php } ?>
										</div>
										<?php if($row['order_type_id']=='1'){ // webad ?>  
										<div class="row static-info">
											<div class="col-md-5 name">Static/Animated:</div>
											<div class="col-md-7 value"><?php echo $row['web_ad_type']; ?></div>
										</div>
										<?php }else{	//printad
												$print_ad_type =$this->db->get_where('print_ad_types',array('id' => $row['print_ad_type']))->result_array();
										?>
										<div class="row static-info">
											<div class="col-md-5 name">Full Color/B&amp;W/Spot:</div>
											<div class="col-md-7 value"><?php echo $print_ad_type[0]['name']; ?></div>
										</div>
										<?php  } ?>
										<div class="row static-info">
											<div class="col-md-5 name">Advertiser:</div>
											<div class="col-md-7 value"><?php echo $row['advertiser_name']; ?></div>
										</div>
									</div>				
								</div>
							</div>		
							<div class="col-md-6 col-sm-12">
								<div class="portlet blue-hoki box">
									<div class="portlet-title">
										<div class="caption">Customer Information</div>
									</div>
									<div class="portlet-body">
									<?php 
										$pub_name=$this->db->get_where('publications',array('id' => $row['publication_id']))->result_array();
										{
									?>
										<div class="row static-info">
											<div class="col-md-5 name">Publication:</div>
											<div class="col-md-7 value"><?php echo $pub_name[0]['name']; ?></div>
									<?php } ?>
						
										</div>
									<?php 
										$adrep_name=$this->db->get_where('adreps',array('id' => $row['adrep_id']))->result_array();
										{
									?>
										<div class="row static-info">
											<div class="col-md-5 name">AdRep Name:</div>
											<div class="col-md-7 value"><?php echo $adrep_name[0]['first_name'];  ?></div>
										<?php } ?>
										</div>
								
										<div class="row static-info">
											<div class="col-md-5 name">Email:</div>
											<div class="col-md-7 value"><?php echo $adrep_name[0]['email_id']; ?></div>
										</div>
										<div class="row static-info">
											<div class="col-md-5 name">Date Needed:</div>
											<div class="col-md-7 value"><?php echo $row['date_needed']; ?></div>
										</div>
									</div>
								</div>
							</div>
						</div>
			
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="portlet blue-hoki box">
									<div class="portlet-title">
										<div class="caption">Pick up Ad</div>
										<div class="actions">
											<a href="#attach_pickup" data-toggle="modal" class="font-grey-cararra tooltips" data-container="body" data-placement="top" data-original-title="Attach File">
											<i class="fa fa-link"></i></a> &nbsp;              
										</div>
									</div>
											<div id="attach_pickup" class="modal fade" role="dialog" aria-labelledby="myModalLabel10" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
															<h4 class="modal-title">Attach File</h4>
														</div>
														<div class="modal-body">
															<form  action="<?php echo base_url().index_page().'team-lead/home/attach_pickup_file/'.$order_id;?>" method="post" enctype="multipart/form-data">
																<div class="form-group">  
																	<input type="file" name="file[]" id="file" required/>
																	<input type="file" name="file[]" id="file" class="margin-top-20" required/>
																</div>
																<div class="modal-footer">
																		<input type="text" name="pickup_adno" id="redirect" value="<?php echo $row['pickup_adno']; ?>"  readonly style="display:none" />
																	<?php if(isset($redirect)){ ?>
																		<input type="text" name="redirect" id="redirect" value="<?php echo $redirect; ?>"  readonly style="display:none" />
																	<?php } ?>	
																	<button type="submit" name="pickup_submit" type="submit" value="SUBMIT" class="btn red">Send</button>
																	<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>
																</div>
															</form>
														</div>
													</div>
												</div>
											</div>
											
									<div class="portlet-body">
										<?php if($row['pickup_adno'] != '') { ?>
										<div class="row static-info">
											<div class="col-md-12 name">
												 Pickup Ad No: <a href="<?php echo base_url().index_page().'team-lead/home/orderview'.'/'.$row['help_desk'].'/'.$row['pickup_adno'];?>" target="_Blank"><?php echo $row['pickup_adno']; ?></a>					
											</div>
										</div>
										<?php } ?>
										<div class="table-scrollable table-scrollable-borderless">
											<table class="table table-light table-hover">
											<tbody>
											<?php $i=1;
											if(isset($pickup_downloads)){
													foreach($file_format as $format){
													$this->load->helper('directory');
													$pickup_map = glob($pickup_downloads.'/*{'.$format['name'].'}',GLOB_BRACE);		
													if($pickup_map){
														foreach($pickup_map as $pickup_row_map)
														{ 
											?>
											<tr>
												<td class="small"><?php echo $i; $i++;?></td>                                     
												<td> <?php echo basename($pickup_row_map) ?></td>
												<td>
												<a href="<?php echo base_url()?><?php echo $pickup_row_map ?>";  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
												<a href="<?php echo base_url()?>download.php?file_source=<?php echo $pickup_row_map; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a>
												</td>
											</tr><?php } } } } ?>
											</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6 col-sm-12">
								<div class="portlet blue-hoki box">
									<div class="portlet-title">
										<div class="caption">Attachments</div>
										<?php if($row['file_path']!='none') { ?>
										<div class="actions">
             								<form method="post" action="<?php echo base_url().index_page().'team-lead/home/zip_folder';?>">
												<input name="file_path" value="downloads/<?php echo($order_id.'-'.$row['job_no'])?>" readonly style="display:none" /> 
												<input name="file_name" value="<?php echo($order_id.'-'.$row['job_no'])?>" readonly style="display:none" />
												<button type="submit" type="submit" name="Submit" class="btn btn-default btn-sm">
												<i class="fa fa-cloud-download"></i>All</button>
											</form>
										</div>
										<?php } ?>
									</div>
									<div class="portlet-body">
										<div class="table-scrollable table-scrollable-borderless">
											<table class="table table-light table-hover">
												<tbody>
												<?php $i=1;																	
													if(isset($dir))																	
													{																																				
														foreach($file_format as $format){
														$this->load->helper('directory');																		
														$map = glob($dir.'/*{'.$format['name'].'}',GLOB_BRACE);																		
														if($map){																			
														foreach($map as $row)																			
														{  
													?>
													<tr>
														<td class="small"><?php echo $i; $i++;?></td>                                     
														<td> <?php echo basename($row) ?></td>
														<td>
														<a href="<?php echo base_url()?><?php echo $row ?>";  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
														<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a>
														</td>
													</tr>
													<?php } } } } ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
		
		<?php
                foreach($orders as $row)
  				if($row['question']=="1" || $row['question']=="2"){ ?>
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN TOOLTIPS PORTLET-->
					<div class="portlet light">
						<div class="portlet-title">
							<div class="row static-info">
								<div class="col-md-6 value bold margin-top-10">Question & answer </div>
								<div class="col-md-6">
									<div class="tools">
										<a href="javascript:;" class="collapse">
										</a>
										<a href="javascript:;" class="reload">
										</a>
									</div>
								</div>
							</div>
						</div>
						<div class="portlet-body">
						  <div class="scroller" style="height:175px" data-always-visible="1" data-rail-visible="0">
							<?php $question = 	$this->db->query("SELECT * FROM `orders_Q_A` WHERE `order_id` = '$order_id' ORDER BY `id` DESC")->result_array();
							//$this->db->get_where('orders_Q_A',array('order_id' => $order_id))->result_array(); 
							?>
							<?php $iq='0'; foreach($question as $Qrow){ $iq++; ?>
							<?php $csr_name = 	$this->db->get_where('csr',array('id' => $Qrow['csr']))->result_array(); ?>
							<?php $adreps = 	$this->db->get_where('adreps',array('id' => $Qrow['adrep']))->result_array(); ?>
							<?php $Acsr_name = 	$this->db->get_where('csr',array('id' => $Qrow['Acsr']))->result_array(); ?>
							<!--adrep qstn starts-->
							<div class="note note-danger">
								<h4><?php echo $csr_name[0]['name']; ?></h4>
								<div class="row">
									<div class="col-md-6"><?php echo $Qrow['question']; ?></div>
									<div class="col-md-6 text-right">
										<span class="font-grey-cascade">Sent at - <?php $date = date_create($Qrow['Qtimestamp']); echo date_format($date, 'g:i A \o\n l jS F Y'); ?> </span>
									</div>
								</div>
							</div>
							
							<?php if(isset($adreps[0]['first_name'])) { ?>
							<div class="note note-success">
								<h4><?php echo $adreps[0]['first_name'] ?></h4>
								<div class="row">
									<div class="col-md-6"><?php echo $Qrow['answer']; ?></div>
									<div class="col-md-6 text-right">
										<span class="font-grey-cascade">Replayed at - <?php $date = date_create($Qrow['Atimestamp']); echo date_format($date, 'g:i A \o\n l jS F Y'); ?> </span>
									</div>
								</div>
							</div>
							<!--adrep qstn ends-->
							
							<!--csr qstn starts-->
							<?php }elseif(isset($Acsr_name[0]['name'])){ ?> 
							<div class="note note-success">
								<h4><?php echo $Acsr_name[0]['name'] ?></h4>
								<div class="row">
									<div class="col-md-6"><?php echo $Qrow['answer']; ?></div>
									<div class="col-md-6 text-right">
										<span class="font-grey-cascade">Replayed at - <?php $date = date_create($Qrow['Atimestamp']); echo date_format($date, 'g:i A \o\n l jS F Y'); ?> </span>
									</div>
								</div>
							<?php } ?>
							<!--csr qstn ends-->
							<?php } ?>
							</div>
						  </div>
						</div>
					<!-- END TOOLTIPS PORTLET-->
				</div>
			</div>
		<?php } ?>
		

		
	<!------ Production Status 1 Starts ------->	
		<?php  $pp = $this->db->query("SELECT * FROM `designer_ads_time` WHERE `order_id`='".$order_id."'")->result_array();
				//$cat = $this->db->query("SELECT * FROM `cat_result` WHERE `order_no`='".$row['id']."'")->result_array();
				if($cat[0]['pro_status']=='1' || $cat[0]['pro_status']=='1') { 
		?>
		
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="row static-info">
								<div class="col-md-6 value bold margin-top-10">Actions for V1 &nbsp;
									<a class="blue popovers margin-right-10" data-trigger="hover" data-container="body" data-placement="top" data-title="Slug Created by: <?php echo $designer[0]['name'];  ?> (<?php echo $designer[0]['username'];  ?>)" data-content="Date & Time: <?php echo $cat[0]['ddate']; ?> <?php echo  $cat[0]['start_time'];?>">
										<i class="fa  fa-info-circle"></i>
									</a>
								</div>
								<div class="col-md-4"></div>
								<div class="col-md-2">
									<form method="post">
										<input type="text" name="cat_result_id" value="<?php echo $cat[0]['id']; ?>" style ="display:none;">
										<button class="btn btn-default btn-block btn-sm" type="submit" name="reassign">Reassign</button>
									</form>
								</div>
							</div>
						</div>
					</div>				   
				</div>
			</div>
       <?php } ?>
	<!------ Production Status 1 Ends ------->
			   
			   
			   
	<!------ Production Status 2 Starts ------>
	   <?php $pp = $this->db->query("SELECT * FROM `designer_ads_time` WHERE `order_id`='".$order_id."'")->result_array();
				$designer = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$cat[0]['designer']."'")->result_array(); 
					if($cat[0]['pro_status'] == '2'){ ?>
			   
				<div class="row">
					<div class="col-md-12">
						<div class="portlet light">
							<div class="portlet-title">
								<div class="row static-info">
									<div class="col-md-2 value bold margin-top-10">Actions for V1  &nbsp;
										<a class="blue popovers margin-right-10" data-trigger="hover" data-container="body" data-placement="top" data-title="Ad Designed by: <?php echo $designer[0]['name'];  ?> (<?php echo $designer[0]['username'];  ?>)" data-content="Date & Time: <?php echo $pp[0]['end_date'] ?> <?php echo $pp[0]['end_time'] ?>">
											<i class="fa  fa-info-circle"></i>
										</a>
									</div>	
									
									<div class="col-md-5">
									<?php if(isset($msg)){ ?>
										<p class="btn green-jungle pull-right btn-sm"><strong>Message - </strong><?php echo $msg; ?></p>
									<?php } ?>
									<?php echo '<span class="btn font-red pull-right btn-sm">'.$this->session->flashdata('msg').'</span>' ;?>
									</div>
											
									<div class="col-md-5 pull-right">
										<div class="row">
											<?php  $i=1;  if(isset($dir1)) { $this->load->helper('directory');	$map = glob($sourcefile.'/'.$cat[0]['slug'].'.{pdf,jpg,gif,png}',GLOB_BRACE);								
												if($map){			foreach($map as $row) {	  
												
											?>
											<div class="col-md-4">
											<a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" 
											 class="btn btn-default btn-block btn-sm">PDF</a>
											
											</div>
											<?php } }  ?>
										
											<?php 
												$map2 = glob($sourcefile.'/'.$cat[0]['slug'].'.{indd,psd}',GLOB_BRACE); 
													if($map2){ 
													foreach($map2 as $row_map2){ $source_file = basename($row_map2); }
														
											?>
											<div class="col-md-4 no-space">
												<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row_map2; ?>"
												class="btn btn-default btn-block btn-sm">Indesign</a>
											</div>
											
											<div class="col-md-4">
												<form action="<?php echo base_url().'index.php/team-lead/home/zip_folder_select'?>" method="post">
													<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
													<input name="new_slug" value="<?php echo $cat[0]['slug'];?>" readonly style="display:none;" />
													<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
													<input name="download" value="download" readonly style="display:none;" />
													<button type="submit" name="SourceDownload" class="btn btn-default btn-block btn-sm">Package</button>
												</form>
											</div>
											<?php } ?>
											<?php } ?>
										</div>
									</div>
									</div>
							</div>		
							<div class="portlet-body">
							  <div class="row">
								<div class="col-md-6">
									<div class=" portlet-tabs">
										<ul class="nav nav-tabs">
											<input type="text" Hidden value="<?php echo $order_id; ?>" name="order_id" >
											
											<li><a href="#portlet_tab1" data-toggle="tab">To QA</a></li>
											
											
											<li><a href="#portlet_tab2" data-toggle="tab">To DC </a></li>
											
											
											<li><a href="#portlet_tab3" data-toggle="tab">To Designer</a></li>
											
											
											<li><a href="#portlet_tab4" data-toggle="tab">Make Changes</a></li>
											
										</ul>	
										<div class="tab-content">
											<div class="tab-pane skin skin-flat" id="portlet_tab1" >
												<form method="post">
													<div class="text-right">
														<input id="show_others1" type="checkbox"> Write your own
													</div>
													<input type="text" Hidden value="<?php echo $order_id; ?>" name="order_id" >
													<textarea id="others1" name="QA_reason" class="form-control margin-top-10" rows="4"></textarea>
													<div class="text-right margin-top-10" >
														<button type="submit" name="sent" class="btn red-sunglo">Send to QA </button>
													</div>
												</form>
											</div>
											<div class="tab-pane" id="portlet_tab2">
												<form method="post">
													<div class="text-right">
														<input id="show_others2" type="checkbox" required/> Write your own
													</div>
													<textarea id="others2" name="DC_reason" class="form-control margin-top-10" rows="4"></textarea>
													<div class="text-right margin-top-10" >
														<button type="submit" name="send_DC" class="btn red-thunderbird">Send to DC</button>
													</div>
												</form>
											</div>	
											<div class="tab-pane" id="portlet_tab3">
												<form method="post">
													<div class="text-right">
														<input id="show_others3" type="checkbox" required/> Write your own
													</div>
													<textarea id="others3" name="msg" class="form-control margin-top-10" rows="4"></textarea>
													<div class="text-right margin-top-10" >
														<button type="submit" name="sent_designer" class="btn green">Back to Designer </button>
													</div>
												</form>
											</div>
											<div class="tab-pane" id="portlet_tab4">
												<form method="post" enctype="multipart/form-data">
													<!-- Source -->
													<div class="col-md-6">
														<input type="file" name="src_file" id="file" accept=".indd, .psd, .ai"  placeholder="Drag & Drop File" required/>
														<p class="help-block">Upload Indesign file here.</p>
													</div>
													<!-- Pdf -->
													<div class="col-md-6">
														<input type="file" name="pdf_file" id="file1" accept=".pdf,image/*" placeholder="Drag & Drop File" required/>
														<p class="help-block">Upload Pdf file here.</p>
													</div>
													<!-- Links -->
													<div class="col-md-6 margin-top-20">
														<input type="file" name="link_file[]" accept="image/*" multiple  placeholder="Drag & Drop File" />
														<p class="help-block">Upload Links file here.</p>
													</div>
													<!-- Fonts -->
													<div class="col-md-6 margin-top-20">
														<input type="file" name="font_file[]" accept=".otf, .ttf" multiple placeholder="Drag & Drop File" />
														<p class="help-block">Upload Fonts file here.</p>
													</div>
													
													<div class="text-right margin-top-10">
													<?php if($cat[0]['pro_status']=='7') { ?>
														<input type="text" name="changes_csr" value="<?php  echo $cat[0]['pro_status']; ?>" style="display:none;">
													<?php } ?>
													<input type="text" name="slug" value="<?php  echo $cat[0]['slug']; ?>" style="visibility:hidden">
													<input type="text" name="sourcefile" value="<?php  echo $dir1; ?>" style="display:none;">
														<button type="submit" name="sourceUpload" class="btn blue">Upload</button>
													</div>
												</form>
												
											</div>
											
										</div>
									</div>
								</div>
								
						<div class="col-md-6 col-sm-12">
							<div class="scroller" style="height:215px" data-always-visible="1" data-rail-visible="0">
								<?php
									$qustion = $this->db->query("SELECT * FROM `ads_designcheck_msg` WHERE `order_id`='".$order_id."'")->result_array(); 
									foreach($qustion as $qustion1) { 
									
								?>
								<!--TL MESSAGE-->
									<?php if($qustion1['tl_id']!='0'){ 
											$tl = $this->db->query("SELECT * FROM `team_lead` WHERE `id`='".$qustion1['tl_id']."'")->result_array(); 
									?>
									<div class="note note-success">
										<h4><?php   echo $tl[0]['first_name']; ?></h4>
										<div class="row">
											<div class="col-sm-6"><?php echo $qustion1['message']; ?></div>
											<div class="col-sm-6 text-right">
												<span class="font-grey-cascade"> at - <?php echo $qustion1['time']; ?> </span>
											</div>
										</div>	
										<?php
											if(isset($tl_path)){ 
												$map = glob($tl_path.'/*.{jpg,png,tiff,gif,html,pdf,indd}',GLOB_BRACE);								
												if($map){			
													foreach($map as $row) {  
												?>
										<p> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a></p>
									 <?php } } } ?>
									</div>
									<!--TL MESSAGE-->
									
									<!--CSR MESSAGE-->
									<?php }  
										if($qustion1['csr_id']!='0') { 
											$csr = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$qustion1['csr_id']."'")->result_array();   
									?>
									<div class="note note-danger">
										<h4><?php  echo $csr[0]['name'];  ?></h4>
										<div class="row margin-top-10">
											<div class="col-sm-6"><?php echo $qustion1['message']; ?></div>
											<div class="col-sm-6 text-right">
												<span class="font-grey-cascade"> at - <?php echo $qustion1['time']; ?> </span>
											</div>
										</div>
										
										<?php if(isset($csr_path)){ 
												$map = glob($csr_path.'/*.{jpg,png,gif,tiff,html,pdf,indd}',GLOB_BRACE);								
												if($map){			
													foreach($map as $row) {  
										?>
										<p> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a></p>
									<?php } } } ?>
									</div>
									<!--CSR MESSAGE-->
									
									<!--DC MESSAGE-->
									<?php } if($qustion1['dc_id']!='0') { $csr = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$qustion1['dc_id']."'")->result_array();   ?>		
									
									<div class="note note-info">
										<h4><?php  echo $csr[0]['name'];  ?></h4>
										<div class="row">
											<div class="col-sm-6"><?php echo $qustion1['message']; ?></div>
											<div class="col-sm-6 text-right">
												<span class="font-grey-cascade"> at - <?php echo $qustion1['time']; ?> </span>
											</div>
										</div>
									</div>
									<!--DC MESSAGE-->
								<?php } }  ?>
								
								<!--DC comment -->
								<?php if(isset($dc_reason)) { 
								$dc = $this->db->query("SELECT * FROM `dc_reason` WHERE `order_id` = '$order_id' ")->result_array();
								if($dc[0]['csr']!='0'){
									$csr_dc_name = $this->db->query("SELECT * FROM `csr` WHERE `id` = '".$dc[0]['csr']."' ")->result_array();
									$dc_name = $csr_dc_name[0]['name'];
								}elseif($dc[0]['team_lead']!='0'){
									$tl_dc_name = $this->db->query("SELECT * FROM `team_lead` WHERE `id` = '".$dc[0]['team_lead']."' ")->result_array();
									$dc_name = $tl_dc_name[0]['first_name'];
								}
								 foreach($dc_reason as $reason) { 
								?>
								<div class="note note-danger">
									<h4>QA Comment- <?php echo $dc_name; ?></h4>
									<div class="row">
											<div class="col-sm-6"><?php echo $reason['reason']; ?></div>
											<div class="col-sm-6 text-right">
												<span class="font-grey-cascade"> at - <?php echo $reason['timestamp']; ?> </span>
											</div>
									</div>
								</div>
							<?php } } ?>
								<!--DC comment -->
								
								<!--designer message -->
								<?php if(isset($designer_message)) { 
								foreach($designer_message as $d_msg) { ?>
								<div class="note note-warning">
									<h4>Designer Message</h4>
									<div class="row">
										<?php  ?>
											<div class="col-sm-6"><?php echo $d_msg['message']; ?></div>
											<div class="col-sm-6 text-right">
												<span class="font-grey-cascade"> at - <?php echo $d_msg['timestamp']; ?> </span>
											</div>
									</div>
								</div>
								<?php } } ?>
								
							</div>		
						</div>
							  </div>
							 </div>
						</div>
					</div>
			   </div> 
		<?php } ?>
	<!------ Production Status 2 Ends ------>	
			  

			  
	<!------ Production Status 2 3,4 Starts ------>
		 <?php  $pp = $this->db->query("SELECT * FROM `designer_ads_time` WHERE `order_id`='".$order_id."'")->result_array();
				$designer = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$cat[0]['designer']."'")->result_array(); 
					if($cat[0]['pro_status'] > '2' && ($row['status'] != '5' || $cat[0]['pro_status'] != '5')){ ?> 
				<div class="row">
					<div class="col-md-12">
							<div class="portlet light">
								<div class="portlet-title">
									<div class="row static-info">
										<div class="col-md-6 value bold margin-top-10">Actions for V1 &nbsp;
										<a class="blue popovers margin-right-10" data-trigger="hover" data-container="body" data-placement="top" data-title="Ad Designed by: <?php echo $designer[0]['name'];  ?> (<?php echo $designer[0]['username'];  ?>)" data-content="Date & Time: <?php echo $pp[0]['end_date'] ?> <?php echo $pp[0]['end_time'] ?>">
													<i class="fa  fa-info-circle"></i></a>
										</div>
										<div class="col-md-6">
											<div class="col-md-8 no-space pull-right">
														<div class="row">
															<?php  $i=1;  if(isset($dir1)) { $this->load->helper('directory');	$map = glob($sourcefile.'/'.$cat[0]['slug'].'.{pdf,jpg,gif,png}',GLOB_BRACE);								
																if($map){			foreach($map as $row) {	  
																
															?>
															<div class="col-md-4">
															<a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" 
															 class="btn btn-default btn-block btn-sm">PDF</a>
															
															</div>
															<?php } }  ?>
														
															<?php 
																$map2 = glob($sourcefile.'/'.$cat[0]['slug'].'.{indd,psd}',GLOB_BRACE); 
																	if($map2){ 
																	foreach($map2 as $row_map2){ $source_file = basename($row_map2); }
																		
															?>
															<div class="col-md-4 no-space">
																<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row_map2; ?>"
																class="btn btn-default btn-block btn-sm">Indesign</a>
															</div>
															
															<div class="col-md-4">
																<form action="<?php echo base_url().'index.php/team-lead/home/zip_folder_select'?>" method="post">
																	<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
																	<input name="new_slug" value="<?php echo $cat[0]['slug'];?>" readonly style="display:none;" />
																	<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
																	<input name="download" value="download" readonly style="display:none;" />
																	<button type="submit" name="SourceDownload" class="btn btn-default btn-block btn-sm">Package</button>
																</form>
															</div>
															<?php } ?>
															<?php } ?>
														</div>
													</div>
										</div>
									</div>
								</div>
							</div>
							   
					</div>
				</div>
		<?php } ?>
	<!------ Production Status 2 3,4 Ends -------->

	
	
	<!------- Production Status 5 Starts --------->
			<?php  $pp = $this->db->query("SELECT * FROM `designer_ads_time` WHERE `order_id`='".$order_id."'")->result_array();
				$designer = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$cat[0]['designer']."'")->result_array(); 
					foreach($orders as $row) if($row['status'] == '5' || $cat[0]['pro_status'] == '5'){ ?> 
			
				<div class="row">
					<div class="col-md-12">
						<div class="portlet light">
							<div class="portlet-title">
								<div class="row static-info">
									<div class="col-md-9 value bold margin-top-10">Actions for V1 &nbsp;
										<a class="popovers margin-right-10" data-trigger="hover" data-container="body" data-placement="top"
											data-content="
												 Designer: <?php echo $designer[0]['name']?> <br>
												 QA: <?php echo $csr_name1[0]['name']; ?> (<?php echo $cp_tool[0]['time_stamp']; ?>) <br> 
												 DC: <?php echo $csr_name1[0]['name']; ?> (<?php echo $cp_tool[0]['time_stamp']; ?>) <br>
												 TL: <?php echo $tl[0]['first_name']; ?> (<?php echo $pp[0]['end_date'].' '.$pp[0]['end_time']; ?>) "
											data-html="true"><i class="fa  fa-info-circle"></i>
										</a>
									</div>
									<div class="col-md-3 pull-right">
													<div class="row">
														<div class="col-md-5 no-space">
															<?php if(isset($sourcefile)){ $this->load->helper('directory');	
																$map1 = glob($sourcefile.'/'.$cat[0]['slug'].'.{pdf}',GLOB_BRACE);
										
																if($map1){
																	foreach($map1 as $row_map1){	  
															?>
																<a href="<?php echo base_url()?><?php echo $row_map1 ?>"  target="_Blank" 
																 class="btn btn-default btn-block btn-sm">PDF</a>
															<?php } } }?>
														</div>
													 
													
														<?php 
															$map2 = glob($sourcefile.'/'.$cat[0]['slug'].'.{indd,psd}',GLOB_BRACE); 
																if($map2){ 
																foreach($map2 as $row_map2){ $source_file = basename($row_map2); }
																	
														?>
														<div class="col-md-7">
															<form action="<?php echo base_url().'index.php/team-lead/home/zip_folder_select'?>" method="post">
																<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
																<input name="new_slug" value="<?php echo $cat[0]['slug'];?>" readonly style="display:none;" />
																<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
																<input name="download" value="download" readonly style="display:none;" />
																<button type="submit" name="SourceDownload" class="btn btn-default btn-block btn-sm" title="source download">Package</button>
															</form>
														</div>
														
														<?php } ?>
													</div>
												</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
	<!------- Production Status 5 Ends --------->
		 
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
	</div>
	</div>
	</div>
	</div>
	</div>
	


<?php $this->load->view('team-lead/foot'); ?>

