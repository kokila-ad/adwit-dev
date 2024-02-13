<?php $this->load->view('team-lead/head'); ?>
<style>
 textarea {
  resize: none;
 }
 .margin-top-5{
  margin-top: 5px;
 }
 .tab-btn {
  border: 0;
  padding: 10px;
  color: #5b9bd1;
 }
 .dropzone { 
		min-height: 48px !important;
	}
.note-grey, .note-grey i {
  background-color: #f3f5f6 !important;
  color: #b8b4b4 !important;
  border-color: #d7d7d7 !important;
  }	
</style>
<!-- dropzone-->
<link href="ui_assetss/dropzone/dropzone.css" type="text/css" rel="stylesheet" />
<script src="ui_assetss/dropzone/dropzone.min.js"></script>
<!-- end-dropzone-->
<script>
	 $(document).ready(function(){
	 $("#others1").hide();
	 $("#others2").hide();
	 $("#others3").hide();
	 $("#show_pickup").hide();
	 $("#file2").hide();
  
	 $("#pickup").click(function(){
	  $("#show_pickup").toggle();     
	  });
	  
	 $("#show_others1").click(function(){
		$("#others1").toggle();  	
	  });
	 
	  $("#show_others2").click(function(){
		$("#others2").toggle();  	
	  });
	  
	  $("#show_others1").click(function(){
		$("#others1").show();  	
	  });
	  
	  $("#show_others2").click(function(){
		$("#others2").show();  	
	  });
	  
	   $("#show_others3").click(function(){
		$("#others3").show();  	
	  });
	  
	  <?php foreach($note_tl_qa as $result){ ?>
	   $("#hide_others1<?php echo $result['id']; ?>").click(function(){
		$("#others1").hide();
	  });
	  <?php } ?> 
	  
	  <?php foreach($note_tl_dc as $result){ ?>
	   $("#hide_others2<?php echo $result['id']; ?>").click(function(){
		$("#others2").hide();
	  });
	  <?php } ?>
	  
	  <?php foreach($note_tl_designer as $result){ ?>
	   $("#hide_others3<?php echo $result['id']; ?>").click(function(){
		$("#others3").hide();
	  });
	  <?php } ?> 
	   
	  
	  $("#show_fileupload").click(function(){
		$("#file2").toggle();  	
	  });
 
	 });
 </script>
 
 <script>

Dropzone.options.dropzonepsd = {
	init: function() {
		this.on("sending", function(file)
		{ 
			var string1_value = $(slug_name).val() + ".psd";
			var string2_value = file.name;
			if(string1_value != string2_value)
			{
				alert("Wrong file. File will be removed");
				this.removeFile(file);
			}		
		 });
	}
};

Dropzone.options.dropzoneindd = {
	init: function() {
		this.on("sending", function(file)
		{ 
			var string1_value = $(slug_name).val() + ".indd";
			var string2_value = file.name;
			if(string1_value != string2_value)
			{
				alert("Wrong file. File will be removed");
				this.removeFile(file);
			}
		 });
	}
};

Dropzone.options.dropzoneimages = {
	init: function() {
		this.on("sending", function(file)
		{ 
			/* var string1_value = $(slug_name).val() + '.jpg';
			var string2_value = $(slug_name).val() + '.gif';
			 */
			 var string1_value = $(slug_name).val();
			 var input_file_value = file.name;
			 var string2_value = input_file_value.substr(0, input_file_value.lastIndexOf('.'));
			if(string1_value != string2_value )
			{
				alert("Wrong file. File will be removed");
				this.removeFile(file);
			}
		 });
	}
};

Dropzone.options.dropzonepdf = {
	init: function() {
		this.on("sending", function(file)
		{ 
			var string1_value = $(slug_name).val() + ".pdf";
			var string2_value = file.name;
			if(string1_value != string2_value)
			{
				alert("Wrong file. File will be removed");
				this.removeFile(file);
			}
		 });
	}
};
</script>

<div class="page-container">
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
											<div class="col-md-9 value bold">Order #<?php echo $order_id; ?><?php foreach($orders as $row)
																 ?><small> &nbsp; (<?php echo $row['created_on']; ?>)</small>
										
											<span class="font-red-sunglo margin-right-10 pull-right">
												<?php echo $this->session->flashdata('file_message'); ?>
											</span>
											</div>
											<div class="col-md-3 text-right">
											<div class="tools">
												<span class="btn red-sunglo btn-xs margin-right-10">
												<?php if($cat[0]['pro_status']!='0') { 
														$status = $this->db->query("SELECT * FROM `production_status` WHERE id='".$cat[0]['pro_status']."'")->result_array(); 
														echo $status[0]['name'];  
													} else { 
														$status1 = $this->db->query("SELECT * FROM `order_status` WHERE id='".$row['status']."'")->result_array(); 
														echo $status1[0]['name'];
													} ?>
												</span> 
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
														<div class="col-md-5 col-xs-6 name">Unique Job Name:</div>
														<div class="col-md-7 col-xs-6 value"><?php echo $row['job_no'];?></div>
													</div>
													<div class="row static-info">
														<div class="col-md-5 col-xs-12 name">Ad Size:</div>
														<?php if($row['order_type_id']=='1'){ // webad 
																	if($row['pixel_size']=='custom'){?>
														<div class="col-md-3 col-xs-6 value">W: <?php echo $row['custom_width']; ?></div>
														<div class="col-md-4 col-xs-6 value">H: <?php echo $row['custom_height']; ?></div>
														<?php } else {
																	$size_px = $this->db->get_where('pixel_sizes',array('id'=>$row['pixel_size']))->result_array();
																?>
														<div class="col-md-3 col-xs-6 value">W: <?php echo $size_px[0]['width']; ?></div>
														<div class="col-md-4 col-xs-6 value">H: <?php echo $size_px[0]['height']; ?></div>
														<?php } }else{ //printad ?>
														<div class="col-md-3 col-xs-6 value">W: <?php echo $row['width']; ?></div>
														<div class="col-md-4 col-xs-6 value">H: <?php echo $row['height']; ?></div>
														<?php } ?>
													</div>
													<?php if($row['order_type_id']=='1'){ // webad ?>  
													<div class="row static-info">
														<div class="col-md-5 col-xs-6 name">Static/Animated:</div>
														<div class="col-md-7 col-xs-6 value"><?php echo $row['web_ad_type']; ?></div>
													</div>
													<?php }else{	//printad
															$print_ad_type =$this->db->get_where('print_ad_types',array('id' => $row['print_ad_type']))->result_array();
													?>
													<div class="row static-info">
														<div class="col-md-5 col-xs-6 name">Full Color/B&amp;W/Spot:</div>
														<div class="col-md-7 col-xs-6 value"><?php echo $print_ad_type[0]['name']; ?></div>
													</div>
													<?php  } ?>
													<div class="row static-info">
														<div class="col-md-5 col-xs-6 name">Advertiser:</div>
														<div class="col-md-7 col-xs-6 value"><?php echo $row['advertiser_name']; ?></div>
													</div>
													<?php if($row['job_instruction']!=="") { ?>
													<div class="row static-info">
														<div class="col-md-5 col-xs-5 name">Job Instruction:</div>
														<div class="col-md-7 col-xs-7 value">
															<?php  if($row['job_instruction']==1)  { echo "Follow Instructions Carefully"; }?>
															<?php  if($row['job_instruction']==2)  { echo  "Be Creative"; }?>
															<?php  if($row['job_instruction']==3)  { echo  "Camera Ready Ad"; } ?>
														</div>
													</div>
													<?php } ?>
													<?php if($row['copy_content_description']!=="") { ?>
													<div class="row static-info">
														<div class="col-md-5 col-xs-5 name">Copy/Content:</div>
														<div class="col-md-7 col-xs-7 value">
															<div class="scroller" style="height:55px" data-always-visible="1" data-rail-visible="0">
																 <?php echo $row['copy_content_description']; ?>
															</div>
														</div>
													</div>
													<?php } ?>
													<?php if($row['notes']!=="") { ?>
													<div class="row static-info">
														<div class="col-md-5 col-xs-5 name">Notes & Instructions:</div>
														<div class="col-md-7 col-xs-7 value">
															<div class="scroller" style="height:55px" data-always-visible="1" data-rail-visible="0">
																<?php echo $row['notes']; ?>
															</div>
														</div>
													</div>
													<?php } ?>
												</div>				
											</div>
										</div>	
										
											<?php 
											if($orders[0]['cancel']=='1') {
													echo "<span> &nbsp; &nbsp; 
																<p class='btn red-pink btn-xs margin-right-10 margin-bottom-10'> Order has been Cancelled..!!</p>
															</span>";
													} else if($orders[0]['crequest']=='1'){
														echo "<span> &nbsp; &nbsp; 
																<p class='btn red-pink btn-xs margin-right-10 margin-bottom-10'> Request for Order Cancellation Sent To Adrep..!!</p>
															</span>";
													}?>
																				
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
														<div class="col-md-5 col-xs-6 name">Publication:</div>
														<div class="col-md-7 col-xs-6 value"><?php echo $pub_name[0]['name']; ?></div>
												<?php } ?>
									
													</div>
												<?php 
													$adrep_name=$this->db->get_where('adreps',array('id' => $row['adrep_id']))->result_array();
													{
												?>
													<div class="row static-info">
														<div class="col-md-5 col-xs-6 name">AdRep Name:</div>
														<div class="col-md-7 col-xs-6 value"><?php echo $adrep_name[0]['first_name'];  ?></div>
													<?php } ?>
													</div>
											
													<!--<div class="row static-info">
														<div class="col-md-5 col-xs-6 name">Email:</div>
														<div class="col-md-7 col-xs-6 value"><?php echo $adrep_name[0]['email_id']; ?></div>
													</div>-->
													<div class="row static-info">
														<div class="col-md-5 col-xs-6 name">Date Needed:</div>
														<div class="col-md-7 col-xs-6 value"><?php echo $row['date_needed']; ?></div>
													</div>
												</div>
											</div>
										
											<!--<div class="portlet blue-hoki box">
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
															 Pickup Ad No: <?php echo $row['pickup_adno']; ?>					
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
											</div>-->
										
									<div class="portlet blue-hoki box margin-bottom-10">
										<div class="portlet-title">
											<div class="caption">PickUp Ad</div>
											<div class="actions">
												<a id="pickup" class="font-grey-cararra tooltips" data-container="body" data-placement="top" data-original-title="Attach File">
												<i class="fa fa-link"></i></a> &nbsp;              
											</div>
										</div>
										<div class="portlet-body">
										<!--<?php if($row['pickup_adno'] != '') { ?>
											<div class="row static-info margin-top-10">
												<div class="col-md-5 name">PickUp Ad No:</div>
												<div class="col-md-7 value"><a href="<?php echo base_url().index_page().'team-lead/home/orderview'.'/'.$hd.'/'.$row['pickup_adno'];?>" target="_Blank"><?php echo $row['pickup_adno']; ?></a></div>
											</div>
										<?php } ?>-->
										<?php if($row['pickup_adno'] != '') { ?>
											<div class="row static-info margin-top-10">
												<div class="col-md-5 name">PickUp Ad No:</div>
												<div class="col-md-7 value"><?php echo $row['pickup_adno']; ?></div>
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
												<td class="word-wrap"> <?php echo basename($pickup_row_map) ?></td>
												<td>
												<a href="<?php echo base_url()?><?php echo $pickup_row_map ?>";  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
												<a href="<?php echo base_url()?>download.php?file_source=<?php echo $pickup_row_map; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a>
												</td>
											</tr><?php } } } } ?>
											
											
											</tbody>
											</table>
										</div>
											<?php echo $this->session->flashdata('pickup_message'); ?>
										<div class="row no-space margin-bottom-10" id="show_pickup">
											<form  action="<?php echo base_url().index_page().'team-lead/home/attach_pickup_file/'.$order_id;?>" method="post" enctype="multipart/form-data">
										
										
												<div class="col-md-6 no-space"><input type="file" name="file[]" class="form-control"></div>
												<div class="col-md-6 no-space"><input type="file" name="file[]" class="form-control"></div>
												<div class="col-md-12 no-space text-right margin-top-10">
												<input type="text" name="pickup_adno" id="redirect" value="<?php echo $row['pickup_adno']; ?>"  readonly style="display:none" />
												<?php if(isset($redirect)){ ?>
													<input type="text" name="redirect" id="redirect" value="<?php echo $redirect; ?>"  readonly style="display:none" />
												<?php } ?>
													<button type="submit" name="pickup_submit" class="btn btn-primary btn-sm">Upload</button>
												</div>
											</form>
										</div>
										</div>
									</div>
											<div class="portlet blue-hoki box">
												<div class="portlet-title">
													<div class="caption">Downloads</div>
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

<!--Question and Answer Display starts-->
<?php
   foreach($orders as $row)
  	if($row['question']=="1" || $row['question']=="2"){ ?>
		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN TOOLTIPS PORTLET-->
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption static-info">
							<div class="value bold">Question & Answer </div>
						</div>	
						<div class="tools">
							<a href="javascript:;" class="expand" data-original-title="" title=""></a>
						</div>
					</div>
					<div class="portlet-body" style="display: none;">
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
									<span class="font-grey-cascade">Replied at - <?php $date = date_create($Qrow['Atimestamp']); echo date_format($date, 'g:i A \o\n l jS F Y'); ?> </span>
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
									<span class="font-grey-cascade">Replied at - <?php $date = date_create($Qrow['Atimestamp']); echo date_format($date, 'g:i A \o\n l jS F Y'); ?> </span>
								</div>
							</div>
						
						<!--csr qstn ends-->
						
						</div>
						<?php } } ?>
						</div>
					  </div>
					</div>
				<!-- END TOOLTIPS PORTLET-->
			</div>
		</div>
	<?php } ?>
	</div>
<!--Question and Answer Display starts-->
		
					
					
<!------ Production Status 1 Starts ------->
<?php if($cat[0]['pro_status']=='1') { ?>
<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
			<div class="row static-info  margin-top-10">
				<div class="col-md-10 value bold"><?php if($cat) { echo $cat[0]['version']; }?> &nbsp; 
					<a class="popovers margin-right-10" data-trigger="hover" data-container="body" data-placement="top" 	
					data-title="Slug Created by: <?php echo $designer[0]['name'];  ?> (<?php echo $designer[0]['username'];  ?>)" data-content="Date & Time: <?php echo $cat[0]['ddate']; ?> <?php echo  $cat[0]['start_time'];?>">
					<i class="fa  fa-info-circle"></i>
					</a>
				</div>
				<div class="col-md-2 pull-right">
					<form method="post">
						<input type="text" name="cat_result_id" value="<?php echo $cat[0]['id']; ?>" style ="display:none;">
						<button class="btn btn-default btn-sm btn-block" type="submit" name="reassign">Reassign</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<?php } ?>			
<!------ Production Status 1 Ends ------->	


<!------ Production Status 2 Starts ------->
 <?php $pp = $this->db->query("SELECT * FROM `designer_ads_time` WHERE `order_id`='".$order_id."'")->result_array();
		$designer = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$cat[0]['designer']."'")->result_array(); 
			if($cat[0]['pro_status'] == '2'){ ?>
<div class="row">
	<div class="col-md-6">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="row static-info">
					<div class="col-md-2 value bold margin-top-5"><?php if($cat) { echo $cat[0]['version']; }?> &nbsp;
						<a class="popovers margin-right-10" data-trigger="hover" data-container="body" data-placement="top" data-title="Ad Designed by: <?php echo $designer[0]['name'];  ?> (<?php echo $designer[0]['username'];  ?>)" data-content="Date & Time: <?php echo $pp[0]['end_date'] ?> <?php echo $pp[0]['end_time'] ?>">
											<i class="fa  fa-info-circle"></i>
						</a>
					</div>
					<div class="col-md-10 text-right">						
						<?php  $i=1;  if(isset($dir1)) { $this->load->helper('directory');	
						$map = glob($sourcefile.'/'.$cat[0]['slug'].'.{pdf,jpg,gif,png}',GLOB_BRACE);								
						if($map){ foreach($map as $row) { ?>
						  <a href="<?php echo base_url()?><?php echo $row ?>" target="_Blank" class="btn btn-default btn-sm">PDF</a>
						<?php } } } ?>
					</div>
				</div>
			</div>
			<div class="portlet-body">
				<div class=" portlet-tabs">
					<ul class="nav nav-tabs">
						<input type="text" Hidden value="<?php echo $order_id; ?>" name="order_id" >
						<li class="active"><a href="#portlet_tab1" data-toggle="tab">To QA</a></li>
						<li><a href="#portlet_tab2" data-toggle="tab">To DC </a></li>
						<li><a href="#portlet_tab3" data-toggle="tab">To Designer</a></li>
						<form method="POST">
						<li><button type="submit" name="make_changes" onclick="return Make_confirm()" class="btn btn-default tab-btn">Make Changes</button></li>
						</form>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active skin skin-flat" id="portlet_tab1" >
							<form method="POST">
								<div class="form-body margin-bottom-10">
									<div class="form-group">
										<div class="scroller" style="height:35px; width:300px" data-always-visible="1" data-rail-visible="0">
											<div class="input-group">
												<div class="icheck-list" onSelect="clickMeId">
													<?php
														foreach($note_tl_qa as $result){ ?>
													<label>
														<input type="radio" id="hide_others1<?php echo $result['id']; ?>" name="tl_QA_reason" value="<?php echo $result['name']; ?>"> <?php echo $result['name'];?> 
													</label>
												<?php } ?>
												</div>
											</div>
										</div>
									</div>
								</div>
																				
								<div class="text-right">
									<label id="show_others1" class="font-grey-cascade"><input name="tl_QA_reason" value="others" type="radio"> Write your own</label>
								</div>
								<input type="text" Hidden value="<?php echo $order_id; ?>" name="order_id" >
								<input type="text" Hidden value="<?php echo $cat[0]['publication_id']; ?>" name="publication_id" >
								<textarea id="others1" name="QA_reason" class="form-control margin-top-10" rows="4"></textarea>
								<div class="text-right margin-top-10" >
									<button type="submit" name="sent" class="btn red-sunglo" onclick="return warning_confirm()">Send to QA </button>
								</div>
							</form>
						</div>
						<div class="tab-pane" id="portlet_tab2">
							<form method="POST">
								<div class="form-body margin-bottom-10">
									<div class="form-group">
										<div class="scroller" style="height:35px; width:300px" data-always-visible="1" data-rail-visible="0">
											<div class="input-group">
												<div class="icheck-list" onSelect="clickMeId">
													<?php
														foreach($note_tl_dc as $result){ ?>
													<label>
														<input type="radio" id="hide_others2<?php echo $result['id']; ?>" name="tl_dc_reason" value="<?php echo $result['name']; ?>"> <?php echo $result['name'];?> 
													</label>
												<?php } ?>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="text-right">
									<label id="show_others2" class="font-grey-cascade"><input name="tl_dc_reason" value="others" type="radio" /> Write your own</label>
								</div>
								<textarea id="others2" name="DC_reason" class="form-control margin-top-10" rows="4" /></textarea>
								<div class="text-right margin-top-10" >
									<button type="submit" name="send_DC" class="btn red-thunderbird" onclick="return warning_confirm()">Send to DC</button>
								</div>
							</form>
						</div>	
						<div class="tab-pane" id="portlet_tab3">
							<form method="POST" enctype="multipart/form-data">
								<div class="form-body">
									<div class="form-group">
										<div class="scroller" style="height:85px; width:300px" data-always-visible="1" data-rail-visible="0">
											<div class="input-group">
												<div class="icheck-list">
												<?php //$results = $results = $this->db->get('note_teamlead_designer')->result_array();
														foreach($note_tl_designer as $result){ ?>
													<label>
														<input type="radio" id="hide_others3<?php echo $result['id']; ?>" name="tl_msg" value="<?php echo $result['name']; ?>"> <?php echo $result['name'];?> 
													</label>
												<?php } ?>
												</div>
											</div>
										</div>
									</div>
								</div>
										<div class="col-sm-7 no-space pull-right">
											<div class="row margin-bottom-10">	
												<div class="col-sm-6">
													<label class="font-grey-cascade"><input  id="show_fileupload" type="checkbox" name="" value=""> Attach Files </label>
												</div>
												<div class="col-sm-6 no-space">
													<label id="show_others3" class="font-grey-cascade"><input type="radio" name="tl_msg" value="others"> Write your own </label>
												</div>
											</div>
										</div>
								
								
								<textarea id="others3" name="tl_note" class="form-control margin-top-15" rows="4"></textarea>
								
								<div class="col-md-12 border" id="file2"> 
								  <input type="file" name="file2" class="margin-top-10 margin-bottom-10">
								</div>
								
								<div class="row">	
									<div class="col-md-6 col-xs-6 pull-right text-right margin-top-10">
										<button type="submit" name="sent_designer" class="btn green">Back to Designer </button>
									</div>
							</form>
									
									<div class="col-md-6 col-xs-6 margin-top-10" >
									  <div class="row no-space">
										<?php  $i=1;  if(isset($dir1)) { 
										$map2 = glob($sourcefile.'/'.$cat[0]['slug'].'.{indd,psd}',GLOB_BRACE); 
											if($map2){ 
												foreach($map2 as $row_map2){ $source_file = basename($row_map2); }?>
												
												<div class="col-md-4 col-xs-6 no-space">
													<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row_map2; ?>"
													class="btn btn-default btn-sm">In-Design</a>
												</div>
												
												<div class="col-md-5 col-xs-6">
													<form action="<?php echo base_url().'index.php/team-lead/home/zip_folder_select'?>" method="post">
														<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
														<input name="new_slug" value="<?php echo $cat[0]['slug'];?>" readonly style="display:none;" />
														<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
														<input name="download" value="download" readonly style="display:none;" />
														<button type="submit" name="SourceDownload" class="btn btn-default btn-sm">Package</button>
													</form>
												</div>
												<?php } ?>
											<?php } ?>
									  </div>
									</div>
								</div>
							
							<div class="row">
								
							</div>							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
						
	<div class="col-md-6">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="row static-info  margin-top-10">
					<div class="col-md-10 value bold">Conversations</div>
				</div>
			</div>
			<div class="row portlet-body">
				<div class="col-md-12 col-sm-12">
				 <div class="scroller" style="height:218px" data-always-visible="1" data-rail-visible="0">
					<?php
				$qustion = $this->db->query("SELECT * FROM `production_conversation` WHERE `order_id`='".$order_id."' order by `id` desc")->result_array(); 
				
				  if(!isset($qustion[0]['id'])){
					echo '<p class="text-center">'."No Conversations".'</p>';
				}  
				if($qustion) { $i=0; foreach($qustion as $qustion1) { $i++; 
							
			?>
				<!--TL_designer MESSAGE-->
				<?php if(($qustion1['tl_id']!='0') && ($qustion1['operation']=='tl_designer')){ 
							$tl = $this->db->query("SELECT * FROM `team_lead` WHERE `id`='".$qustion1['tl_id']."'")->result_array(); 
				?>
					<div <?php if($i=='1'){ echo'class="note note-danger"'; }else{ echo 'class="note note-grey"'; } ?>>
						<div class="row">
							<div class="col-sm-6">
								<?php echo $qustion1['message']; ?>
								<?php
									if(isset($tl_path)){ 
										$map = glob($tl_path.'/*.{jpg,png,tiff,gif,html,pdf,indd}',GLOB_BRACE);								
										if($map){			
											foreach($map as $row) {  
										?>
								<p class="margin-top-10"> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
								<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a></p>
								<?php } } } ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php   echo $tl[0]['first_name']; ?> (Team Lead) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
					<!--TL_designer MESSAGE-->
					
					<?php } else { ?>
					
			<!--designer_TL_designer MESSAGE-->
				<?php if(($qustion1['tl_designer_id']!='0') && ($qustion1['operation']=='tl_designer')){ 
							$tl_designer_id = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$qustion1['tl_designer_id']."'")->result_array(); 
				?>
					<div <?php if($i=='1'){ echo'class="note note-danger"'; }else{ echo 'class="note note-grey"'; } ?>>
						<div class="row">
							<div class="col-sm-6">
								<?php echo $qustion1['message']; ?>
								<?php
									if(isset($tl_path)){ 
										$map = glob($tl_path.'/*.{jpg,png,tiff,gif,html,pdf,indd}',GLOB_BRACE);								
										if($map){			
											foreach($map as $row) {  
										?>
								<p class="margin-top-10"> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
								<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a></p>
								<?php } } } ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php   echo $tl_designer_id[0]['name']; ?> (D Team Lead) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
				<?php } } ?>
			<!--designer_TL_designer MESSAGE-->
						
			<!--QA to designer MESSAGE-->
					<?php if(($qustion1['csr_id']!='0') && ($qustion1['operation']=='QA_designer')) { 
								$csr = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$qustion1['csr_id']."'")->result_array();   
					?>
					<div <?php if($i=='1'){ echo'class="note note-info"'; }else{ echo 'class="note note-grey"'; } ?>>
					
						<div class="row">
							<div class="col-sm-6">
							<?php echo $qustion1['message']; ?>
							<?php if(isset($csr_path)){ 
										$map = glob($csr_path.'/*.{jpg,png,gif,tiff,html,pdf,indd}',GLOB_BRACE);								
										if($map){			
											foreach($map as $row) {  
								?>
								 <p class="margin-top-10"> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
								<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a></p>
							<?php } } } ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php  echo $csr[0]['name'];  ?> (CSR) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
			<!--QA to designer MESSAGE-->
					
			<!--DC to designer MESSAGE-->
				<?php } if(($qustion1['dc_id']!='0') && ($qustion1['operation']=='DC_designer')) { $csr = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$qustion1['dc_id']."'")->result_array();   ?>		
					
					<div <?php if($i=='1'){ echo'class="note note-success"'; }else{ echo 'class="note note-grey"'; } ?>>
						<div class="row">
							<div class="col-sm-6">
								<?php echo $qustion1['message']; ?>
								<?php if(isset($dc_csr_path)){ 
								$map = glob($dc_csr_path.'/*.{jpg,png,gif,html,tiff,pdf,indd}',GLOB_BRACE);								
								if($map){			
									foreach($map as $row){  
								?>
								<p class="margin-top-10"> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
								<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a>
								</p>
								<?php } } } ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php  echo $csr[0]['name'];  ?> (CSR) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
			<!--DC to designer MESSAGE-->
					
			<!--designer msg-->
			<?php }  if($qustion1['designer_id']!='0') { $designer = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$qustion1['designer_id']."'")->result_array();   ?>		
					<div <?php if($i=='1'){ echo'class="note note-danger"'; }else{ echo 'class="note note-grey"'; } ?>>
						
						<div class="row">
							<div class="col-sm-6"><?php echo $qustion1['message']; ?></div>
							<div class="col-sm-6 text-right">
							<h4><?php echo $designer[0]['name'] ;?> (Designer)</h4>
								<span class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </span>
							</div>
						</div>
					</div>
					<?php } ?>
			<!--designer mesg-->
				
			<!--TL to QA-->
			<?php if(($qustion1['tl_id']!='0') && ($qustion1['operation']=='tl_QA')) { $tl = $this->db->query("SELECT * FROM `team_lead` WHERE `id`='".$qustion1['tl_id']."'")->result_array();   ?>
					<div <?php if($i=='1'){ echo'class="note note-info"'; }else{ echo 'class="note note-grey"'; } ?>>
						
						<div class="row">
							<div class="col-sm-6">
								<?php echo $qustion1['message']; ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php  echo $tl[0]['first_name'];  ?> (Team Lead) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
			<?php } else { ?>
			<!--TL to QA -->
			
			<!--designer_TL to QA-->
			<?php if(($qustion1['tl_designer_id']!='0') && ($qustion1['operation']=='tl_QA')) { $tl_designer_id = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$qustion1['tl_designer_id']."'")->result_array();   ?>
					<div <?php if($i=='1'){ echo'class="note note-info"'; }else{ echo 'class="note note-grey"'; } ?>>
						
						<div class="row">
							<div class="col-sm-6">
								<?php echo $qustion1['message']; ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php  echo $tl_designer_id[0]['name'];  ?> (D Team Lead) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
			<?php } } ?>
			<!--designer_TL to QA -->
			
			<!--TL to DC -->
			<?php if(($qustion1['tl_id']!='0') && ($qustion1['operation']=='tl_DC')) { $tl = $this->db->query("SELECT * FROM `team_lead` WHERE `id`='".$qustion1['tl_id']."'")->result_array();   ?>
					<div <?php if($i=='1'){ echo'class="note note-success"'; }else{ echo 'class="note note-grey"'; } ?>>
						<div class="row">
							<div class="col-sm-6"><?php echo $qustion1['message']; ?></div>
							<div class="col-sm-6 text-right">
							<h4><?php  echo $tl[0]['first_name'];  ?> (D Team Lead) </h4>
								<span class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </span>
							</div>
						</div>
					</div>
			<!--TL to DC-->
			<?php } else { ?>
			<!--designer_TL to DC -->
			<?php if(($qustion1['tl_designer_id']!='0') && ($qustion1['operation']=='tl_DC')) { $tl_designer_id = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$qustion1['tl_designer_id']."'")->result_array();   ?>
					<div <?php if($i=='1'){ echo'class="note note-success"'; }else{ echo 'class="note note-grey"'; } ?>>
						<div class="row">
							<div class="col-sm-6"><?php echo $qustion1['message']; ?></div>
							<div class="col-sm-6 text-right">
							<h4><?php  echo $tl_designer_id[0]['name'];  ?> (D Team Lead) </h4>
								<span class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </span>
							</div>
						</div>
					</div>
			<?php } } ?>	
			<!--designer_TL to DC-->
			
				
			<!--QA to DC-->
			<?php if(($qustion1['csr_id']!='0') && ($qustion1['operation']=='QA_DC')) { $csr = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$qustion1['csr_id']."'")->result_array();   ?>
					<div <?php if($i=='1'){ echo'class="note note-danger"'; }else{ echo 'class="note note-grey"'; } ?>>
						
						<div class="row">
							<div class="col-sm-6"><?php echo $qustion1['message']; ?></div>
							<div class="col-sm-6 text-right">
							<h4><?php  echo $csr[0]['name'];  ?> (CSR) </h4>
								<span class="font-grey-cascade"><?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </span>
							</div>
						</div>
					</div>
			<!--QA to DC-->	
			<?php } } } ?>
				</div>	
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<!------ Production Status 2 Ends ------->	


<!------ Production Status 3-4 Starts ------->
 <?php  $pp = $this->db->query("SELECT * FROM `designer_ads_time` WHERE `order_id`='".$order_id."'")->result_array();
		foreach($orders as $row)
			$designer = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$cat[0]['designer']."'")->result_array(); 
				if(($cat[0]['pro_status'] == '3' || $cat[0]['pro_status'] == '4') && ($row['status'] != '5' || $cat[0]['pro_status'] != '5')){ ?> 
<div class="row">
	<div class="col-md-6">
		<div class="portlet light">
			<div class="row margin-bottom-20 margin-top-10 static-info">
				<div class="col-md-9 value bold"><?php if($cat) { echo $cat[0]['version']; }?> &nbsp;
					<a class="blue popovers margin-right-10" data-trigger="hover" data-container="body" data-placement="top" data-title="Ad Designed by: <?php echo $designer[0]['name'];  ?> (<?php echo $designer[0]['username'];  ?>)" data-content="Date & Time: <?php echo $pp[0]['end_date'] ?> <?php echo $pp[0]['end_time'] ?>">
						<i class="fa  fa-info-circle"></i></a>
				</div>
			<?php  $i=1;  if(isset($dir1)) { $this->load->helper('directory');	$map = glob($sourcefile.'/'.$cat[0]['slug'].'.{pdf,jpg,gif,png}',GLOB_BRACE);								
					if($map){ foreach($map as $row) {	?>
				<div class="tools text-right no-space">
					<a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-default btn-sm margin-right-10">PDF</a>
				</div>
			<?php } } } ?>
			</div>	
		</div>
	</div>
	<div class="col-md-6">
		<div class="portlet light">
			<div class="row portlet-title static-info no-border">
				<div class="col-md-9 value bold margin-top-10">Conversation</div>
				<div class="tools no-space margin-right-10 margin-top-10">
					<a href="javascript:;" class="expand" data-original-title="" title="">
						<i class="fa fa-icon-angle-up"></i>
					</a>
				</div>
			</div>	
			<div class="portlet-body" style="display: none;">
				  <div class="scroller" style="height:218px" data-always-visible="1" data-rail-visible="0">
					<?php
				$qustion = $this->db->query("SELECT * FROM `production_conversation` WHERE `order_id`='".$order_id."' order by `id` desc")->result_array(); 
				
				  if(!isset($qustion[0]['id'])){
					echo '<p class="text-center">'."No Conversations".'</p>';
				}  
				if($qustion) { $i=0; foreach($qustion as $qustion1) { $i++; 
							
			?>
				<!--TL_designer MESSAGE-->
				<?php if(($qustion1['tl_id']!='0') && ($qustion1['operation']=='tl_designer')){ 
							$tl = $this->db->query("SELECT * FROM `team_lead` WHERE `id`='".$qustion1['tl_id']."'")->result_array(); 
				?>
					<div <?php if($i=='1'){ echo'class="note note-danger"'; }else{ echo 'class="note note-grey"'; } ?>>
						<div class="row">
							<div class="col-sm-6">
								<?php echo $qustion1['message']; ?>
								<?php
									if(isset($tl_path)){ 
										$map = glob($tl_path.'/*.{jpg,png,tiff,gif,html,pdf,indd}',GLOB_BRACE);								
										if($map){			
											foreach($map as $row) {  
										?>
								<p class="margin-top-10"> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
								<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a></p>
								<?php } } } ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php   echo $tl[0]['first_name']; ?> (Team Lead) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
					<!--TL_designer MESSAGE-->
					
					<?php } else { ?>
					
			<!--designer_TL_designer MESSAGE-->
				<?php if(($qustion1['tl_designer_id']!='0') && ($qustion1['operation']=='tl_designer')){ 
							$tl_designer_id = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$qustion1['tl_designer_id']."'")->result_array(); 
				?>
					<div <?php if($i=='1'){ echo'class="note note-danger"'; }else{ echo 'class="note note-grey"'; } ?>>
						<div class="row">
							<div class="col-sm-6">
								<?php echo $qustion1['message']; ?>
								<?php
									if(isset($tl_path)){ 
										$map = glob($tl_path.'/*.{jpg,png,tiff,gif,html,pdf,indd}',GLOB_BRACE);								
										if($map){			
											foreach($map as $row) {  
										?>
								<p class="margin-top-10"> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
								<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a></p>
								<?php } } } ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php   echo $tl_designer_id[0]['name']; ?> (D Team Lead) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
				<?php } } ?>
			<!--designer_TL_designer MESSAGE-->
						
			<!--QA to designer MESSAGE-->
					<?php if(($qustion1['csr_id']!='0') && ($qustion1['operation']=='QA_designer')) { 
								$csr = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$qustion1['csr_id']."'")->result_array();   
					?>
					<div <?php if($i=='1'){ echo'class="note note-info"'; }else{ echo 'class="note note-grey"'; } ?>>
					
						<div class="row">
							<div class="col-sm-6">
							<?php echo $qustion1['message']; ?>
							<?php if(isset($csr_path)){ 
										$map = glob($csr_path.'/*.{jpg,png,gif,tiff,html,pdf,indd}',GLOB_BRACE);								
										if($map){			
											foreach($map as $row) {  
								?>
								 <p class="margin-top-10"> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
								<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a></p>
							<?php } } } ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php  echo $csr[0]['name'];  ?> (CSR) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
			<!--QA to designer MESSAGE-->
					
			<!--DC to designer MESSAGE-->
				<?php } if(($qustion1['dc_id']!='0') && ($qustion1['operation']=='DC_designer')) { $csr = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$qustion1['dc_id']."'")->result_array();   ?>		
					
					<div <?php if($i=='1'){ echo'class="note note-success"'; }else{ echo 'class="note note-grey"'; } ?>>
						<div class="row">
							<div class="col-sm-6">
								<?php echo $qustion1['message']; ?>
								<?php if(isset($dc_csr_path)){ 
								$map = glob($dc_csr_path.'/*.{jpg,png,gif,html,tiff,pdf,indd}',GLOB_BRACE);								
								if($map){			
									foreach($map as $row){  
								?>
								<p class="margin-top-10"> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
								<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a>
								</p>
								<?php } } } ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php  echo $csr[0]['name'];  ?> (CSR) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
			<!--DC to designer MESSAGE-->
					
			<!--designer msg-->
			<?php }  if($qustion1['designer_id']!='0') { $designer = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$qustion1['designer_id']."'")->result_array();   ?>		
					<div <?php if($i=='1'){ echo'class="note note-danger"'; }else{ echo 'class="note note-grey"'; } ?>>
						
						<div class="row">
							<div class="col-sm-6"><?php echo $qustion1['message']; ?></div>
							<div class="col-sm-6 text-right">
							<h4><?php echo $designer[0]['name'] ;?> (Designer)</h4>
								<span class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </span>
							</div>
						</div>
					</div>
					<?php } ?>
			<!--designer mesg-->
				
			<!--TL to QA-->
			<?php if(($qustion1['tl_id']!='0') && ($qustion1['operation']=='tl_QA')) { $tl = $this->db->query("SELECT * FROM `team_lead` WHERE `id`='".$qustion1['tl_id']."'")->result_array();   ?>
					<div <?php if($i=='1'){ echo'class="note note-info"'; }else{ echo 'class="note note-grey"'; } ?>>
						
						<div class="row">
							<div class="col-sm-6">
								<?php echo $qustion1['message']; ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php  echo $tl[0]['first_name'];  ?> (Team Lead) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
			<?php } else { ?>
			<!--TL to QA -->
			
			<!--designer_TL to QA-->
			<?php if(($qustion1['tl_designer_id']!='0') && ($qustion1['operation']=='tl_QA')) { $tl_designer_id = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$qustion1['tl_designer_id']."'")->result_array();   ?>
					<div <?php if($i=='1'){ echo'class="note note-info"'; }else{ echo 'class="note note-grey"'; } ?>>
						
						<div class="row">
							<div class="col-sm-6">
								<?php echo $qustion1['message']; ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php  echo $tl_designer_id[0]['name'];  ?> (D Team Lead) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
			<?php } } ?>
			<!--designer_TL to QA -->
			
			<!--TL to DC -->
			<?php if(($qustion1['tl_id']!='0') && ($qustion1['operation']=='tl_DC')) { $tl = $this->db->query("SELECT * FROM `team_lead` WHERE `id`='".$qustion1['tl_id']."'")->result_array();   ?>
					<div <?php if($i=='1'){ echo'class="note note-success"'; }else{ echo 'class="note note-grey"'; } ?>>
						<div class="row">
							<div class="col-sm-6"><?php echo $qustion1['message']; ?></div>
							<div class="col-sm-6 text-right">
							<h4><?php  echo $tl[0]['first_name'];  ?> (D Team Lead) </h4>
								<span class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </span>
							</div>
						</div>
					</div>
			<!--TL to DC-->
			<?php } else { ?>
			<!--designer_TL to DC -->
			<?php if(($qustion1['tl_designer_id']!='0') && ($qustion1['operation']=='tl_DC')) { $tl_designer_id = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$qustion1['tl_designer_id']."'")->result_array();   ?>
					<div <?php if($i=='1'){ echo'class="note note-success"'; }else{ echo 'class="note note-grey"'; } ?>>
						<div class="row">
							<div class="col-sm-6"><?php echo $qustion1['message']; ?></div>
							<div class="col-sm-6 text-right">
							<h4><?php  echo $tl_designer_id[0]['name'];  ?> (D Team Lead) </h4>
								<span class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </span>
							</div>
						</div>
					</div>
			<?php } } ?>	
			<!--designer_TL to DC-->
			
				
			<!--QA to DC-->
			<?php if(($qustion1['csr_id']!='0') && ($qustion1['operation']=='QA_DC')) { $csr = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$qustion1['csr_id']."'")->result_array();   ?>
					<div <?php if($i=='1'){ echo'class="note note-danger"'; }else{ echo 'class="note note-grey"'; } ?>>
						
						<div class="row">
							<div class="col-sm-6"><?php echo $qustion1['message']; ?></div>
							<div class="col-sm-6 text-right">
							<h4><?php  echo $csr[0]['name'];  ?> (CSR) </h4>
								<span class="font-grey-cascade"><?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </span>
							</div>
						</div>
					</div>
			<!--QA to DC-->	
			<?php } } } ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?> 				
<!------ Production Status 3-4 Ends ------->	


<!------ Production Status 5 Starts ------->
<?php  $pp = $this->db->query("SELECT * FROM `designer_ads_time` WHERE `order_id`='".$order_id."'")->result_array();
				$designer = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$cat[0]['designer']."'")->result_array(); 
					foreach($orders as $row) if($row['status'] == '5' || $cat[0]['pro_status'] == '5'){ ?> 
					
<div class="row">
	<div class="col-md-6">
		<div class="portlet light">
			<div class="row margin-bottom-20 margin-top-10 static-info">
				<div class="col-sm-7 value bold"><?php if($cat) { echo $cat[0]['version']; }?> &nbsp;
					<a class="popovers margin-right-10" data-trigger="hover" data-container="body" data-placement="top"
					data-content="
							 Designer: <?php echo $designer[0]['name']?> (<?php echo $pp[0]['end_date'].' '.$pp[0]['end_time']; ?>) <br>
							 QA: <?php if(isset($csr_name1)){ echo $csr_name1[0]['name']; ?> (<?php echo $cp_tool[0]['time_stamp']; ?>) <?php } ?> <br> 
							 DC: <?php echo $csr_name1[0]['name']; ?> (<?php echo $cp_tool[0]['time_stamp']; ?>) <br>
							 TL: "
						data-html="true" data-placement="bottom"><i class="fa  fa-info-circle"></i>
					</a>
				</div>
				<div class="col-sm-5 text-right">
					<div class="row">
						<div class="col-md-5 no-space">
							<?php if(isset($sourcefile)){ $this->load->helper('directory');	
								$map1 = glob($sourcefile.'/'.$cat[0]['slug'].'.{pdf}',GLOB_BRACE);
								$map2 = glob($sourcefile.'/'.$cat[0]['slug'].'.{indd,psd}',GLOB_BRACE); 
								if($map1){
									foreach($map1 as $row_map1){	  
							?>
								<a href="<?php echo base_url()?><?php echo $row_map1 ?>"  target="_Blank" 
								 class="btn btn-default btn-block btn-sm">PDF</a>
							<?php } } ?>
						</div>
						<?php $source_zip_file = $sourcefile.'/'.$cat[0]['slug'].'.zip' ; 
							if(file_exists($source_zip_file)){ ?>
							<div class="col-md-7">		
								<a href="<?php echo base_url()?><?php echo $source_zip_file ?>" class="btn btn-block btn-default btn-sm">Package</a>
							</div>
						<?php } else {
								if($map2){ 
								foreach($map2 as $row_map2){ $source_file = basename($row_map2); }?>
						<div class="col-md-7">
							<form action="<?php echo base_url().'index.php/team-lead/home/zip_folder_select'?>" method="post">
								<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
								<input name="new_slug" value="<?php echo $cat[0]['slug'];?>" readonly style="display:none;" />
								<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
								<input name="download" value="download" readonly style="display:none;" />
								<button type="submit" name="SourceDownload" class="btn btn-default btn-block btn-sm" title="source download">Package</button>
							</form>
						</div>
						<?php } } } ?>
					</div>
				</div>
			</div>	
		</div>
	</div>
	<div class="col-md-6">
		<div class="portlet light">
			<div class="row portlet-title static-info no-border">
				<div class="col-md-9 value bold margin-top-10">Conversation</div>
				<div class="tools no-space margin-right-10 margin-top-10">
					<a href="javascript:;" class="expand" data-original-title="" title="">
						<i class="fa fa-icon-angle-up"></i>
					</a>
				</div>
			</div>	
			<div class="portlet-body" style="display: none;">
				  <div class="scroller" style="height:218px" data-always-visible="1" data-rail-visible="0">
					<?php
				$qustion = $this->db->query("SELECT * FROM `production_conversation` WHERE `order_id`='".$order_id."' order by `id` desc")->result_array(); 
				
				  if(!isset($qustion[0]['id'])){
					echo '<p class="text-center">'."No Conversations".'</p>';
				}  
				if($qustion) { $i=0; foreach($qustion as $qustion1) { $i++; 
							
			?>
				<!--TL_designer MESSAGE-->
				<?php if(($qustion1['tl_id']!='0') && ($qustion1['operation']=='tl_designer')){ 
							$tl = $this->db->query("SELECT * FROM `team_lead` WHERE `id`='".$qustion1['tl_id']."'")->result_array(); 
				?>
					<div <?php if($i=='1'){ echo'class="note note-danger"'; }else{ echo 'class="note note-grey"'; } ?>>
						<div class="row">
							<div class="col-sm-6">
								<?php echo $qustion1['message']; ?>
								<?php
									if(isset($tl_path)){ 
										$map = glob($tl_path.'/*.{jpg,png,tiff,gif,html,pdf,indd}',GLOB_BRACE);								
										if($map){			
											foreach($map as $row) {  
										?>
								<p class="margin-top-10"> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
								<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a></p>
								<?php } } } ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php   echo $tl[0]['first_name']; ?> (Team Lead) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
					<!--TL_designer MESSAGE-->
					
					<?php } else { ?>
					
			<!--designer_TL_designer MESSAGE-->
				<?php if(($qustion1['tl_designer_id']!='0') && ($qustion1['operation']=='tl_designer')){ 
							$tl_designer_id = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$qustion1['tl_designer_id']."'")->result_array(); 
				?>
					<div <?php if($i=='1'){ echo'class="note note-danger"'; }else{ echo 'class="note note-grey"'; } ?>>
						<div class="row">
							<div class="col-sm-6">
								<?php echo $qustion1['message']; ?>
								<?php
									if(isset($tl_path)){ 
										$map = glob($tl_path.'/*.{jpg,png,tiff,gif,html,pdf,indd}',GLOB_BRACE);								
										if($map){			
											foreach($map as $row) {  
										?>
								<p class="margin-top-10"> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
								<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a></p>
								<?php } } } ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php   echo $tl_designer_id[0]['name']; ?> (D Team Lead) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
				<?php } } ?>
			<!--designer_TL_designer MESSAGE-->
						
			<!--QA to designer MESSAGE-->
					<?php if(($qustion1['csr_id']!='0') && ($qustion1['operation']=='QA_designer')) { 
								$csr = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$qustion1['csr_id']."'")->result_array();   
					?>
					<div <?php if($i=='1'){ echo'class="note note-info"'; }else{ echo 'class="note note-grey"'; } ?>>
					
						<div class="row">
							<div class="col-sm-6">
							<?php echo $qustion1['message']; ?>
							<?php if(isset($csr_path)){ 
										$map = glob($csr_path.'/*.{jpg,png,gif,tiff,html,pdf,indd}',GLOB_BRACE);								
										if($map){			
											foreach($map as $row) {  
								?>
								 <p class="margin-top-10"> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
								<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a></p>
							<?php } } } ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php  echo $csr[0]['name'];  ?> (CSR) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
			<!--QA to designer MESSAGE-->
					
			<!--DC to designer MESSAGE-->
				<?php } if(($qustion1['dc_id']!='0') && ($qustion1['operation']=='DC_designer')) { $csr = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$qustion1['dc_id']."'")->result_array();   ?>		
					
					<div <?php if($i=='1'){ echo'class="note note-success"'; }else{ echo 'class="note note-grey"'; } ?>>
						<div class="row">
							<div class="col-sm-6">
								<?php echo $qustion1['message']; ?>
								<?php if(isset($dc_csr_path)){ 
								$map = glob($dc_csr_path.'/*.{jpg,png,gif,html,tiff,pdf,indd}',GLOB_BRACE);								
								if($map){			
									foreach($map as $row){  
								?>
								<p class="margin-top-10"> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
								<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a>
								</p>
								<?php } } } ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php  echo $csr[0]['name'];  ?> (CSR) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
			<!--DC to designer MESSAGE-->
					
			<!--designer msg-->
			<?php }  if($qustion1['designer_id']!='0') { $designer = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$qustion1['designer_id']."'")->result_array();   ?>		
					<div <?php if($i=='1'){ echo'class="note note-danger"'; }else{ echo 'class="note note-grey"'; } ?>>
						
						<div class="row">
							<div class="col-sm-6"><?php echo $qustion1['message']; ?></div>
							<div class="col-sm-6 text-right">
							<h4><?php echo $designer[0]['name'] ;?> (Designer)</h4>
								<span class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </span>
							</div>
						</div>
					</div>
					<?php } ?>
			<!--designer mesg-->
				
			<!--TL to QA-->
			<?php if(($qustion1['tl_id']!='0') && ($qustion1['operation']=='tl_QA')) { $tl = $this->db->query("SELECT * FROM `team_lead` WHERE `id`='".$qustion1['tl_id']."'")->result_array();   ?>
					<div <?php if($i=='1'){ echo'class="note note-info"'; }else{ echo 'class="note note-grey"'; } ?>>
						
						<div class="row">
							<div class="col-sm-6">
								<?php echo $qustion1['message']; ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php  echo $tl[0]['first_name'];  ?> (Team Lead) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
			<?php } else { ?>
			<!--TL to QA -->
			
			<!--designer_TL to QA-->
			<?php if(($qustion1['tl_designer_id']!='0') && ($qustion1['operation']=='tl_QA')) { $tl_designer_id = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$qustion1['tl_designer_id']."'")->result_array();   ?>
					<div <?php if($i=='1'){ echo'class="note note-info"'; }else{ echo 'class="note note-grey"'; } ?>>
						
						<div class="row">
							<div class="col-sm-6">
								<?php echo $qustion1['message']; ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php  echo $tl_designer_id[0]['name'];  ?> (D Team Lead) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
			<?php } } ?>
			<!--designer_TL to QA -->
			
			<!--TL to DC -->
			<?php if(($qustion1['tl_id']!='0') && ($qustion1['operation']=='tl_DC')) { $tl = $this->db->query("SELECT * FROM `team_lead` WHERE `id`='".$qustion1['tl_id']."'")->result_array();   ?>
					<div <?php if($i=='1'){ echo'class="note note-success"'; }else{ echo 'class="note note-grey"'; } ?>>
						<div class="row">
							<div class="col-sm-6"><?php echo $qustion1['message']; ?></div>
							<div class="col-sm-6 text-right">
							<h4><?php  echo $tl[0]['first_name'];  ?> (D Team Lead) </h4>
								<span class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </span>
							</div>
						</div>
					</div>
			<!--TL to DC-->
			<?php } else { ?>
			<!--designer_TL to DC -->
			<?php if(($qustion1['tl_designer_id']!='0') && ($qustion1['operation']=='tl_DC')) { $tl_designer_id = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$qustion1['tl_designer_id']."'")->result_array();   ?>
					<div <?php if($i=='1'){ echo'class="note note-success"'; }else{ echo 'class="note note-grey"'; } ?>>
						<div class="row">
							<div class="col-sm-6"><?php echo $qustion1['message']; ?></div>
							<div class="col-sm-6 text-right">
							<h4><?php  echo $tl_designer_id[0]['name'];  ?> (D Team Lead) </h4>
								<span class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </span>
							</div>
						</div>
					</div>
			<?php } } ?>	
			<!--designer_TL to DC-->
			
				
			<!--QA to DC-->
			<?php if(($qustion1['csr_id']!='0') && ($qustion1['operation']=='QA_DC')) { $csr = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$qustion1['csr_id']."'")->result_array();   ?>
					<div <?php if($i=='1'){ echo'class="note note-danger"'; }else{ echo 'class="note note-grey"'; } ?>>
						
						<div class="row">
							<div class="col-sm-6"><?php echo $qustion1['message']; ?></div>
							<div class="col-sm-6 text-right">
							<h4><?php  echo $csr[0]['name'];  ?> (CSR) </h4>
								<span class="font-grey-cascade"><?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </span>
							</div>
						</div>
					</div>
			<!--QA to DC-->	
			<?php } } } ?>
				</div>
			</div>
		</div>
	</div>
</div>				
<?php } ?>
<!------ Production Status 5 Ends ------->	


<!------ Production Status 6-7 Starts ------->
<?php  $pp = $this->db->query("SELECT * FROM `designer_ads_time` WHERE `order_id`='".$order_id."'")->result_array();foreach($orders as $row)
			$designer = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$cat[0]['designer']."'")->result_array(); 
				if(($cat[0]['pro_status'] == '6' || $cat[0]['pro_status'] == '7') && ($row['status'] != '5' || $cat[0]['pro_status'] != '5')){ ?> 
<div class="row">
	<div class="col-md-6">
		<div class="portlet light">
			<div class="row margin-bottom-20 margin-top-10 static-info">
				<div class="col-sm-8 value bold"><?php if($cat) { echo $cat[0]['version']; }?> &nbsp;
					<a class="popovers margin-right-10" data-trigger="hover" data-container="body" data-placement="top" data-title="Ad Designed by: <?php echo $designer[0]['name'];  ?> (<?php echo $designer[0]['username'];  ?>)" data-content="Date & Time: <?php echo $pp[0]['end_date'] ?> <?php echo $pp[0]['end_time'] ?>">
						<i class="fa  fa-info-circle"></i>
					</a>
				</div>
				<div class="col-sm-4 tools text-right no-space">
					<div class="row">
						<div class="col-sm-6">
							<form method="POST">
								<button type="submit" name="make_changes" class="btn btn-default btn-sm margin-right-10" onclick="return Make_confirm()">Make Changes</button>
							</form>
						</div>
						<?php  $i=1;  if(isset($dir1)) { $this->load->helper('directory');	$map = glob($sourcefile.'/'.$cat[0]['slug'].'.{pdf,jpg,gif,png}',GLOB_BRACE);								
									if($map){ foreach($map as $row) { ?>
						<div class="col-sm-6">
							<a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-default btn-sm margin-right-10">PDF</a>
						</div>
						<?php } } } ?>
					</div>
				</div>
			</div>	
		</div>
	</div>
	<div class="col-md-6">
		<div class="portlet light">
			<div class="row portlet-title static-info no-border">
				<div class="col-md-9 value bold margin-top-10">Conversation</div>
				<div class="tools no-space margin-right-10 margin-top-10">
					<a href="javascript:;" class="expand" data-original-title="" title="">
						<i class="fa fa-icon-angle-up"></i>
					</a>
				</div>
			</div>	
			<div class="portlet-body" style="display: none;">
				  <div class="scroller" style="height:218px" data-always-visible="1" data-rail-visible="0">
					<?php
				$qustion = $this->db->query("SELECT * FROM `production_conversation` WHERE `order_id`='".$order_id."' order by `id` desc")->result_array(); 
				
				  if(!isset($qustion[0]['id'])){
					echo '<p class="text-center">'."No Conversations".'</p>';
				}  
				if($qustion) { $i=0; foreach($qustion as $qustion1) { $i++; 
							
			?>
				<!--TL_designer MESSAGE-->
				<?php if(($qustion1['tl_id']!='0') && ($qustion1['operation']=='tl_designer')){ 
							$tl = $this->db->query("SELECT * FROM `team_lead` WHERE `id`='".$qustion1['tl_id']."'")->result_array(); 
				?>
					<div <?php if($i=='1'){ echo'class="note note-danger"'; }else{ echo 'class="note note-grey"'; } ?>>
						<div class="row">
							<div class="col-sm-6">
								<?php echo $qustion1['message']; ?>
								<?php
									if(isset($tl_path)){ 
										$map = glob($tl_path.'/*.{jpg,png,tiff,gif,html,pdf,indd}',GLOB_BRACE);								
										if($map){			
											foreach($map as $row) {  
										?>
								<p class="margin-top-10"> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
								<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a></p>
								<?php } } } ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php   echo $tl[0]['first_name']; ?> (Team Lead) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
					<!--TL_designer MESSAGE-->
					
					<?php } else { ?>
					
			<!--designer_TL_designer MESSAGE-->
				<?php if(($qustion1['tl_designer_id']!='0') && ($qustion1['operation']=='tl_designer')){ 
							$tl_designer_id = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$qustion1['tl_designer_id']."'")->result_array(); 
				?>
					<div <?php if($i=='1'){ echo'class="note note-danger"'; }else{ echo 'class="note note-grey"'; } ?>>
						<div class="row">
							<div class="col-sm-6">
								<?php echo $qustion1['message']; ?>
								<?php
									if(isset($tl_path)){ 
										$map = glob($tl_path.'/*.{jpg,png,tiff,gif,html,pdf,indd}',GLOB_BRACE);								
										if($map){			
											foreach($map as $row) {  
										?>
								<p class="margin-top-10"> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
								<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a></p>
								<?php } } } ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php   echo $tl_designer_id[0]['name']; ?> (D Team Lead) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
				<?php } } ?>
			<!--designer_TL_designer MESSAGE-->
						
			<!--QA to designer MESSAGE-->
					<?php if(($qustion1['csr_id']!='0') && ($qustion1['operation']=='QA_designer')) { 
								$csr = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$qustion1['csr_id']."'")->result_array();   
					?>
					<div <?php if($i=='1'){ echo'class="note note-info"'; }else{ echo 'class="note note-grey"'; } ?>>
					
						<div class="row">
							<div class="col-sm-6">
							<?php echo $qustion1['message']; ?>
							<?php if(isset($csr_path)){ 
										$map = glob($csr_path.'/*.{jpg,png,gif,tiff,html,pdf,indd}',GLOB_BRACE);								
										if($map){			
											foreach($map as $row) {  
								?>
								 <p class="margin-top-10"> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
								<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a></p>
							<?php } } } ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php  echo $csr[0]['name'];  ?> (CSR) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
			<!--QA to designer MESSAGE-->
					
			<!--DC to designer MESSAGE-->
				<?php } if(($qustion1['dc_id']!='0') && ($qustion1['operation']=='DC_designer')) { $csr = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$qustion1['dc_id']."'")->result_array();   ?>		
					
					<div <?php if($i=='1'){ echo'class="note note-success"'; }else{ echo 'class="note note-grey"'; } ?>>
						<div class="row">
							<div class="col-sm-6">
								<?php echo $qustion1['message']; ?>
								<?php if(isset($dc_csr_path)){ 
								$map = glob($dc_csr_path.'/*.{jpg,png,gif,html,tiff,pdf,indd}',GLOB_BRACE);								
								if($map){			
									foreach($map as $row){  
								?>
								<p class="margin-top-10"> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
								<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a>
								</p>
								<?php } } } ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php  echo $csr[0]['name'];  ?> (CSR) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
			<!--DC to designer MESSAGE-->
					
			<!--designer msg-->
			<?php }  if($qustion1['designer_id']!='0') { $designer = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$qustion1['designer_id']."'")->result_array();   ?>		
					<div <?php if($i=='1'){ echo'class="note note-danger"'; }else{ echo 'class="note note-grey"'; } ?>>
						
						<div class="row">
							<div class="col-sm-6"><?php echo $qustion1['message']; ?></div>
							<div class="col-sm-6 text-right">
							<h4><?php echo $designer[0]['name'] ;?> (Designer)</h4>
								<span class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </span>
							</div>
						</div>
					</div>
					<?php } ?>
			<!--designer mesg-->
				
			<!--TL to QA-->
			<?php if(($qustion1['tl_id']!='0') && ($qustion1['operation']=='tl_QA')) { $tl = $this->db->query("SELECT * FROM `team_lead` WHERE `id`='".$qustion1['tl_id']."'")->result_array();   ?>
					<div <?php if($i=='1'){ echo'class="note note-info"'; }else{ echo 'class="note note-grey"'; } ?>>
						
						<div class="row">
							<div class="col-sm-6">
								<?php echo $qustion1['message']; ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php  echo $tl[0]['first_name'];  ?> (Team Lead) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
			<?php } else { ?>
			<!--TL to QA -->
			
			<!--designer_TL to QA-->
			<?php if(($qustion1['tl_designer_id']!='0') && ($qustion1['operation']=='tl_QA')) { $tl_designer_id = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$qustion1['tl_designer_id']."'")->result_array();   ?>
					<div <?php if($i=='1'){ echo'class="note note-info"'; }else{ echo 'class="note note-grey"'; } ?>>
						
						<div class="row">
							<div class="col-sm-6">
								<?php echo $qustion1['message']; ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php  echo $tl_designer_id[0]['name'];  ?> (D Team Lead) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
			<?php } } ?>
			<!--designer_TL to QA -->
			
			<!--TL to DC -->
			<?php if(($qustion1['tl_id']!='0') && ($qustion1['operation']=='tl_DC')) { $tl = $this->db->query("SELECT * FROM `team_lead` WHERE `id`='".$qustion1['tl_id']."'")->result_array();   ?>
					<div <?php if($i=='1'){ echo'class="note note-success"'; }else{ echo 'class="note note-grey"'; } ?>>
						<div class="row">
							<div class="col-sm-6"><?php echo $qustion1['message']; ?></div>
							<div class="col-sm-6 text-right">
							<h4><?php  echo $tl[0]['first_name'];  ?> (D Team Lead) </h4>
								<span class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </span>
							</div>
						</div>
					</div>
			<!--TL to DC-->
			<?php } else { ?>
			<!--designer_TL to DC -->
			<?php if(($qustion1['tl_designer_id']!='0') && ($qustion1['operation']=='tl_DC')) { $tl_designer_id = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$qustion1['tl_designer_id']."'")->result_array();   ?>
					<div <?php if($i=='1'){ echo'class="note note-success"'; }else{ echo 'class="note note-grey"'; } ?>>
						<div class="row">
							<div class="col-sm-6"><?php echo $qustion1['message']; ?></div>
							<div class="col-sm-6 text-right">
							<h4><?php  echo $tl_designer_id[0]['name'];  ?> (D Team Lead) </h4>
								<span class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </span>
							</div>
						</div>
					</div>
			<?php } } ?>	
			<!--designer_TL to DC-->
			
				
			<!--QA to DC-->
			<?php if(($qustion1['csr_id']!='0') && ($qustion1['operation']=='QA_DC')) { $csr = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$qustion1['csr_id']."'")->result_array();   ?>
					<div <?php if($i=='1'){ echo'class="note note-danger"'; }else{ echo 'class="note note-grey"'; } ?>>
						
						<div class="row">
							<div class="col-sm-6"><?php echo $qustion1['message']; ?></div>
							<div class="col-sm-6 text-right">
							<h4><?php  echo $csr[0]['name'];  ?> (CSR) </h4>
								<span class="font-grey-cascade"><?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </span>
							</div>
						</div>
					</div>
			<!--QA to DC-->	
			<?php } } } ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>			
<!------ Production Status 6-7 Ends ------->	


<!------ Production Status 8 Starts ------->
<?php  $pp = $this->db->query("SELECT * FROM `designer_ads_time` WHERE `order_id`='".$order_id."'")->result_array();foreach($orders as $row)
			$designer = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$cat[0]['designer']."'")->result_array(); 
				if($cat[0]['pro_status'] == '8' && ($row['status'] != '5' || $cat[0]['pro_status'] != '5')){ ?> 
<div class="row">
	<div class="col-md-6">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="row static-info">
					<div class="col-md-5 value bold margin-top-5"><?php if($cat) { echo $cat[0]['version']; }?> &nbsp;
						<a class="popovers margin-right-10" data-trigger="hover" data-container="body" data-placement="top" data-title="Ad Designed by: <?php echo $designer[0]['name'];  ?> (<?php echo $designer[0]['username'];  ?>)" data-content="Date & Time: <?php echo $pp[0]['end_date'] ?> <?php echo $pp[0]['end_time'] ?>">
						<i class="fa  fa-info-circle"></i>
					</a>
					</div>
					
					<?php  $i=1;  if(isset($dir1)) { $this->load->helper('directory');	
					$map = glob($sourcefile.'/'.$cat[0]['slug'].'.{pdf,jpg,gif,png}',GLOB_BRACE);								
					if($map){ foreach($map as $row) { ?>
					<div class="col-md-7 text-right">
					  <div class="row">
						 <div class="col-md-4">
							<a href="<?php echo base_url()?><?php echo $row ?>" target="_Blank" class="btn btn-default btn-sm btn-block">PDF</a>
						 </div>
						 
						 <?php  $i=1;  if(isset($dir1)) { 
												$map2 = glob($sourcefile.'/'.$cat[0]['slug'].'.{indd,psd}',GLOB_BRACE); 
													if($map2){ 
														foreach($map2 as $row_map2){ $source_file = basename($row_map2); }?>
						<div class="col-md-4 no-space">
							<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row_map2; ?>"
							class="btn btn-default btn-block btn-sm">In-Design</a>
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
					<?php } } } ?>
				</div>
			</div>
			<div class="portlet-body row">
					<!--<?php if(isset($msg)){ ?>
									<?php } else { echo $this->session->flashdata('file_message'); } ?>-->
									
									<?php $order_details = $this->db->query("SELECT * FROM `orders` WHERE `id`='".$order_id."'")->result_array();
								?>	
								
								<div class="scroller" style="height:145px" data-always-visible="1" data-rail-visible="0">	
									<div class="row no-space">
									<?php if($order_details[0]['order_type_id'] == '1') { ?>
										<div class="col-md-6">
											<div id="dropzone" class="border">
												<form action="<?php echo base_url().index_page().'team-lead/home/new_fileuploads/'.$order_id; ?>"  id="dropzonepsd" class="dropzone" method="post">
													<input type="hidden" name="slug_name" id="slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $cat[0]['slug'];  ?>">
													<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="psd">
													<div class="dz-default dz-message no-space">
														<span class="font-sm">PSD file</span>
													</div>
												</form>
											</div>
										</div>
									<?php } else { ?>
										<div class="col-md-6">
											<div id="dropzone" class="border">
												<form action="<?php echo base_url().index_page().'team-lead/home/new_fileuploads/'.$order_id; ?>"  id="dropzoneindd" class="dropzone" method="post">
													<input type="hidden" name="slug_name" id="slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $cat[0]['slug'];  ?>">
													<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="indd">
													<div class="dz-default dz-message no-space">
														<span class="font-sm">Indesign file</span>
													</div>
												</form>
											</div>
										</div>
									<?php } ?>
									<?php if($order_details[0]['order_type_id'] == '1') { ?>
										<div class="col-md-6">
											<div id="dropzone" class="border">
												<form action="<?php echo base_url().index_page().'team-lead/home/new_fileuploads/'.$order_id; ?>"   id="dropzoneimages" class="dropzone" method="post">
													<input type="hidden" name="slug_name" id="slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $cat[0]['slug'];?>">
													<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="images">
													<div class="dz-default dz-message no-space">
														<span class="font-sm">Image file</span>
													</div>
												</form>
											</div>
										</div>
									<?php } else { ?>
										<div class="col-md-6">
											<div id="dropzone" class="border">
												<form action="<?php echo base_url().index_page().'team-lead/home/new_fileuploads/'.$order_id; ?>"   id="dropzonepdf" class="dropzone" method="post">
													<input type="hidden" name="slug_name" id="slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $cat[0]['slug'];?>">
													<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="pdf">
													<div class="dz-default dz-message no-space">
														<span class="font-sm">PDF file</span>
													</div>
												</form>
											</div>
										</div>
									<?php } ?>
									</div>
								
									<div class="row no-space">
										<div class="col-md-6">
											<div id="dropzone" class="margin-top-10 border">
												<form action="<?php echo base_url().index_page().'team-lead/home/new_fileuploads/'.$order_id; ?>"   id="dropzone" class="dropzone" method="post">
													<input type="hidden" name="slug_name" id="slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $cat[0]['slug'];?>">
													<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="links">
													<div class="dz-default dz-message no-space">
														<span class="font-sm">Links file</span>
													</div>
												</form>
											</div>
										</div>
										<div class="col-md-6">
											<div id="dropzone" class="margin-top-10 border">
												<form action="<?php echo base_url().index_page().'team-lead/home/new_fileuploads/'.$order_id; ?>"   id="dropzone" class="dropzone" method="post">
													<input type="hidden" name="slug_name" id="slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $cat[0]['slug'];?>">
													<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="fonts">
													<div class="dz-default dz-message no-space">
														<span class="font-sm">Fonts file</span>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>	
									
									<div class="col-md-12 margin-top-10">
										<div class="row">
											<div class="col-md-12 text-right">
											<form method="POST">
												<?php if($cat[0]['pro_status']=='7') { ?>
												<input type="text" name="changes_csr" value="<?php  echo $cat[0]['pro_status']; ?>" style="display:none;">
												<?php } ?>
												<input type="text" name="slug" value="<?php  echo $cat[0]['slug']; ?>" style="display:none">
												<input type="text" name="sourcefile" value="<?php  echo $dir1; ?>" style="display:none;">
												<button type="submit" name="sourceUpload" class="btn blue">Complete</button>
											</form>
											</div>
										</div>
									</div>
										
						
					<div class="col-sm-5 text-left margin-top-10" >
						
					</div>
						</div>
					</div>
			</div>
			
	<div class="col-md-6">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="row static-info  margin-top-10">
					<div class="col-md-10 value bold">Conversations</div>
				</div>
			</div>
			<div class="row portlet-body">
				<div class="col-md-12 col-sm-12">
				  <div class="scroller" style="height:200px" data-always-visible="1" data-rail-visible="0">
					<?php
				$qustion = $this->db->query("SELECT * FROM `production_conversation` WHERE `order_id`='".$order_id."' order by `id` desc")->result_array(); 
				
				  if(!isset($qustion[0]['id'])){
					echo '<p class="text-center">'."No Conversations".'</p>';
				}  
				if($qustion) { $i=0; foreach($qustion as $qustion1) { $i++; 
							
			?>
				<!--TL_designer MESSAGE-->
				<?php if(($qustion1['tl_id']!='0') && ($qustion1['operation']=='tl_designer')){ 
							$tl = $this->db->query("SELECT * FROM `team_lead` WHERE `id`='".$qustion1['tl_id']."'")->result_array(); 
				?>
					<div <?php if($i=='1'){ echo'class="note note-danger"'; }else{ echo 'class="note note-grey"'; } ?>>
						<div class="row">
							<div class="col-sm-6">
								<?php echo $qustion1['message']; ?>
								<?php
									if(isset($tl_path)){ 
										$map = glob($tl_path.'/*.{jpg,png,tiff,gif,html,pdf,indd}',GLOB_BRACE);								
										if($map){			
											foreach($map as $row) {  
										?>
								<p class="margin-top-10"> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
								<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a></p>
								<?php } } } ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php   echo $tl[0]['first_name']; ?> (Team Lead) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
					<!--TL_designer MESSAGE-->
					
					<?php } else { ?>
					
			<!--designer_TL_designer MESSAGE-->
				<?php if(($qustion1['tl_designer_id']!='0') && ($qustion1['operation']=='tl_designer')){ 
							$tl_designer_id = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$qustion1['tl_designer_id']."'")->result_array(); 
				?>
					<div <?php if($i=='1'){ echo'class="note note-danger"'; }else{ echo 'class="note note-grey"'; } ?>>
						<div class="row">
							<div class="col-sm-6">
								<?php echo $qustion1['message']; ?>
								<?php
									if(isset($tl_path)){ 
										$map = glob($tl_path.'/*.{jpg,png,tiff,gif,html,pdf,indd}',GLOB_BRACE);								
										if($map){			
											foreach($map as $row) {  
										?>
								<p class="margin-top-10"> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
								<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a></p>
								<?php } } } ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php   echo $tl_designer_id[0]['name']; ?> (D Team Lead) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
				<?php } } ?>
			<!--designer_TL_designer MESSAGE-->
						
			<!--QA to designer MESSAGE-->
					<?php if(($qustion1['csr_id']!='0') && ($qustion1['operation']=='QA_designer')) { 
								$csr = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$qustion1['csr_id']."'")->result_array();   
					?>
					<div <?php if($i=='1'){ echo'class="note note-info"'; }else{ echo 'class="note note-grey"'; } ?>>
					
						<div class="row">
							<div class="col-sm-6">
							<?php echo $qustion1['message']; ?>
							<?php if(isset($csr_path)){ 
										$map = glob($csr_path.'/*.{jpg,png,gif,tiff,html,pdf,indd}',GLOB_BRACE);								
										if($map){			
											foreach($map as $row) {  
								?>
								 <p class="margin-top-10"> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
								<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a></p>
							<?php } } } ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php  echo $csr[0]['name'];  ?> (CSR) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
			<!--QA to designer MESSAGE-->
					
			<!--DC to designer MESSAGE-->
				<?php } if(($qustion1['dc_id']!='0') && ($qustion1['operation']=='DC_designer')) { $csr = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$qustion1['dc_id']."'")->result_array();   ?>		
					
					<div <?php if($i=='1'){ echo'class="note note-success"'; }else{ echo 'class="note note-grey"'; } ?>>
						<div class="row">
							<div class="col-sm-6">
								<?php echo $qustion1['message']; ?>
								<?php if(isset($dc_csr_path)){ 
								$map = glob($dc_csr_path.'/*.{jpg,png,gif,html,tiff,pdf,indd}',GLOB_BRACE);								
								if($map){			
									foreach($map as $row){  
								?>
								<p class="margin-top-10"> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
								<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a>
								</p>
								<?php } } } ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php  echo $csr[0]['name'];  ?> (CSR) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
			<!--DC to designer MESSAGE-->
					
			<!--designer msg-->
			<?php }  if($qustion1['designer_id']!='0') { $designer = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$qustion1['designer_id']."'")->result_array();   ?>		
					<div <?php if($i=='1'){ echo'class="note note-danger"'; }else{ echo 'class="note note-grey"'; } ?>>
						
						<div class="row">
							<div class="col-sm-6"><?php echo $qustion1['message']; ?></div>
							<div class="col-sm-6 text-right">
							<h4><?php echo $designer[0]['name'] ;?> (Designer)</h4>
								<span class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </span>
							</div>
						</div>
					</div>
					<?php } ?>
			<!--designer mesg-->
				
			<!--TL to QA-->
			<?php if(($qustion1['tl_id']!='0') && ($qustion1['operation']=='tl_QA')) { $tl = $this->db->query("SELECT * FROM `team_lead` WHERE `id`='".$qustion1['tl_id']."'")->result_array();   ?>
					<div <?php if($i=='1'){ echo'class="note note-info"'; }else{ echo 'class="note note-grey"'; } ?>>
						
						<div class="row">
							<div class="col-sm-6">
								<?php echo $qustion1['message']; ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php  echo $tl[0]['first_name'];  ?> (Team Lead) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
			<?php } else { ?>
			<!--TL to QA -->
			
			<!--designer_TL to QA-->
			<?php if(($qustion1['tl_designer_id']!='0') && ($qustion1['operation']=='tl_QA')) { $tl_designer_id = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$qustion1['tl_designer_id']."'")->result_array();   ?>
					<div <?php if($i=='1'){ echo'class="note note-info"'; }else{ echo 'class="note note-grey"'; } ?>>
						
						<div class="row">
							<div class="col-sm-6">
								<?php echo $qustion1['message']; ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php  echo $tl_designer_id[0]['name'];  ?> (D Team Lead) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
			<?php } } ?>
			<!--designer_TL to QA -->
			
			<!--TL to DC -->
			<?php if(($qustion1['tl_id']!='0') && ($qustion1['operation']=='tl_DC')) { $tl = $this->db->query("SELECT * FROM `team_lead` WHERE `id`='".$qustion1['tl_id']."'")->result_array();   ?>
					<div <?php if($i=='1'){ echo'class="note note-success"'; }else{ echo 'class="note note-grey"'; } ?>>
						<div class="row">
							<div class="col-sm-6"><?php echo $qustion1['message']; ?></div>
							<div class="col-sm-6 text-right">
							<h4><?php  echo $tl[0]['first_name'];  ?> (D Team Lead) </h4>
								<span class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </span>
							</div>
						</div>
					</div>
			<!--TL to DC-->
			<?php } else { ?>
			<!--designer_TL to DC -->
			<?php if(($qustion1['tl_designer_id']!='0') && ($qustion1['operation']=='tl_DC')) { $tl_designer_id = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$qustion1['tl_designer_id']."'")->result_array();   ?>
					<div <?php if($i=='1'){ echo'class="note note-success"'; }else{ echo 'class="note note-grey"'; } ?>>
						<div class="row">
							<div class="col-sm-6"><?php echo $qustion1['message']; ?></div>
							<div class="col-sm-6 text-right">
							<h4><?php  echo $tl_designer_id[0]['name'];  ?> (D Team Lead) </h4>
								<span class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </span>
							</div>
						</div>
					</div>
			<?php } } ?>	
			<!--designer_TL to DC-->
			
				
			<!--QA to DC-->
			<?php if(($qustion1['csr_id']!='0') && ($qustion1['operation']=='QA_DC')) { $csr = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$qustion1['csr_id']."'")->result_array();   ?>
					<div <?php if($i=='1'){ echo'class="note note-danger"'; }else{ echo 'class="note note-grey"'; } ?>>
						
						<div class="row">
							<div class="col-sm-6"><?php echo $qustion1['message']; ?></div>
							<div class="col-sm-6 text-right">
							<h4><?php  echo $csr[0]['name'];  ?> (CSR) </h4>
								<span class="font-grey-cascade"><?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </span>
							</div>
						</div>
					</div>
			<!--QA to DC-->	
			<?php } } } ?>
				</div>	
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<!------ Production Status 8 Ends ------->	
					
			
			
	
				</div>			
			</div>
		</div>
	</div>
  </div>
</div>

<!-- BEGIN FOOTER -->
<?php $this->load->view('team-lead/foot'); ?>
