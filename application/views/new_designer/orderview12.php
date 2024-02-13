<?php $this->load->view('new_designer/head')?>
<style>
 textarea{resize: none;}
 .font-lg{font-size:22px !important;color:#888;cursor:pointer}
 .wrap{
	height: auto;
	max-width: 515px;
	padding-bottom: 15px;
	overflow-x: auto;
	overflow-y: hidden;
 }
 .tab-btn {
  border: 0;
  padding: 10px;
  color: #5b9bd1;
 }
 .dropzone { 
		min-height: 48px !important;
	}
.word-break{max-width:100%;word-wrap:break-word;}

.note-grey, .note-grey i {
  background-color: #f3f5f6 !important;
  color: #b8b4b4 !important;
  border-color: #d7d7d7 !important;
  }
  #adrep_note
  {
	position: relative;left: 3px;  
  }
  .adrep
  {
	 position: relative;right: 2px;
  }
  .dropzone .dz-preview.dz-success .dz-success-mark {
    opacity: 1 !important;
	    animation: passing-through 0s cubic-bezier(0, 0, 0, 0);
}

.dz-success-mark {background: #0cec21;}

.dz-error-mark  {background: #ff3333;}

   
</style>

<script type="text/javascript">
$(document).ready(function () {
    $('#focusdiv').click(function() {
      checked = $("#reason_check:checked").length;

      if(!checked) {
        alert("You must check at least one checkbox.");
        return false;
      }

    });
});

</script>
<script>
	 $(document).ready(function(){
	 $("#message").hide();
	 $("#message1").hide();
	 $("#adrep_note").hide();
	 $("#conversation").hide();
	 $("#conversation1").hide();
	 $("#others1").hide();
	 $("#others2").hide();
	 $("#others3").hide();
	 $("#exrev").hide();
	 $("#folder").hide();
	 $("#pickup_files").hide();
	 $("#file2").hide();
 	 
	$("#pickup").click(function(){
	$("#pickup_files").toggle();     
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
	  
	$("#show_fileupload").click(function(){
	$("#file2").toggle();  	
	});
	  
	$("#show_message").click(function(){
	$("#message").toggle();  	
	});
	
	$("#show_adrep_note").click(function(){
	$("#adrep_note").toggle();  	
	});
	
	$("#Links_File").click(function(){
	$("#links1").toggle();  	
	});
	
	$("#idml_File").click(function(){
	$("#idml1").toggle();  	
	});
	
	$("#rev_sold1").click(function(){
	$("#rev_sold_file").toggle();  	
	});
	
	$("#show_message1").click(function(){
	$("#message1").toggle();  	
	});
	
	$("#show_exrev").click(function(){
	$("#exrev").toggle();  	
	});
	  
	$("#show_links").click(function(){
	$("#links").toggle();  	
	});
	  
	$("#show_fonts").click(function(){
	$("#fonts").toggle();  	
	});
	   
	$("#show_upload").click(function(){
	$("#upload").show();
	$("#folder_structure").toggle();  
	}); 
	
	$("#show_conversation").click(function(){
	$("#conversation").toggle();
	});
	
	$("#show_conversation1").click(function(){
	$("#conversation1").toggle();
	});
	
	$("#show_folder").click(function(){
	$("#folder").show();  
	$("#upload").toggle();  	
	});
});
	
Dropzone.options.dropzonepsd = {
	init: function() {
		this.on("sending", function(file) 
		{ 
			var string1_value = $(slug_name).val() + ".psd";
            var string1caps_value = $(slug_name).val() + ".PSD";
			var string2_value = file.name;
			var myarray = [string1_value, string1caps_value];
			if($.inArray(string2_value, myarray) == -1){
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
            var string1caps_value = $(slug_name).val() + ".INDD";
			var string2_value = file.name;
			var myarray = [string1_value, string1caps_value];
			if($.inArray(string2_value, myarray) == -1){
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
            var string1caps_value = $(slug_name).val() + ".PDF";
			var string2_value = file.name;
			var myarray = [string1_value, string1caps_value];
			if($.inArray(string2_value, myarray) == -1){
				alert("Wrong file. File will be removed");
				this.removeFile(file);
			}
		 });
	}
};

Dropzone.options.dropzonesoldpdf = {
	init: function() {
		this.on("sending", function(file)
		{ 
			 var string1_value = $(sold_slug_name).val();
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

Dropzone.options.dropzoneidml = {
	init: function() {
		this.on("sending", function(file)
		{ 
			 var string1_value = $(idml_slug_name).val();
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


</script>
<script>
$(document).ready(function(){
$("#others1").hide();
$("#others2").hide();
$("#others3").hide();
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
});
</script>

<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<div class="page-content">
		<div class="container">
					<!-----------------------------------New Ad orderview starts ------------------------------------------->
<?php if(!isset($rev_orders)){ ?>
<div class="row margin-top-10">
	<div class="col-md-12">
		<!-- Begin: life time stats -->
		<div class="portlet light">
			<div class="portlet-title  margin-top-10">
				<div class="row static-info">
					<div class="col-md-6 value bold">Adwit Id:<?php echo $order_id ;?>
						<?php foreach($orders as $row)?>
						<small> &nbsp; (<?php echo $row['created_on']; ?>)</small>
					</div>
					<div class="col-md-6 text-right">
						<div class="tools">
							<span class="btn red-sunglo btn-xs margin-right-10">
							<?php 
							if($cat[0]['pro_status']!='0') { 
								$status = $this->db->query("SELECT * FROM `production_status` WHERE id='".$cat[0]['pro_status']."'")->result_array(); 
								echo $status[0]['name'];  
							} else { 
								$status1 = $this->db->query("SELECT * FROM `order_status` WHERE id='".$row['status']."'")->result_array(); 
								echo $status1[0]['name'];
							} ?><br/>
					
							<?php if($orders[0]['cancel']=='1') {
								echo "<a class='btn red-sunglo btn-xs margin-right-10'>Order has been Cancelled..!!</a>";
								} else if($orders[0]['crequest']=='1'){
								echo "<a class='btn red-sunglo btn-xs margin-right-10'>Request for Order Cancellation Sent To Adrep..!!</a>";
							}?>
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
									<div class="col-md-5 col-xs-6 name">Unique Job Name</div>
									<div class="col-md-7 col-xs-6 value word-break"><?php echo $row['job_no'];?></div>
								</div>
								<div class="row static-info">
									<div class="col-md-5 col-xs-6">Ad Size</div>
									<?php if($row['order_type_id']=='1'){ // webad 
									if($row['pixel_size']=='custom'){?>
									<div class="col-md-3 col-xs-3 value">W: <?php echo $row['custom_width']; ?></div>
									<div class="col-md-4 col-xs-3 value">H: <?php echo $row['custom_height']; ?></div>
									<?php } else {
										$size_px = $this->db->get_where('pixel_sizes',array('id'=>$row['pixel_size']))->result_array();
									?>
									<div class="col-md-3 col-xs-3 value">W: <?php echo $size_px[0]['width']; ?></div>
									<div class="col-md-4 col-xs-3 value">H: <?php echo $size_px[0]['height']; ?></div>
									<?php } }else{ //printad ?>
									<div class="col-md-3 col-xs-3 value">W: <?php echo $row['width']; ?></div>
									<div class="col-md-4 col-xs-3 value">H: <?php echo $row['height']; ?></div>
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
									<div class="col-md-5 col-xs-6 name">Full Color/B&amp;W/Spot</div>
									<div class="col-md-7 col-xs-6 value"><?php echo $print_ad_type[0]['name']; ?></div>
								</div>
								<?php  } ?>
								<div class="row static-info">
									<div class="col-md-5 col-xs-6 name">Advertiser</div>
									<div class="col-md-7 col-xs-6 word-break value"><?php echo $row['advertiser_name']; ?></div>
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
												<?php echo nl2br($row['copy_content_description']);?>
													<!--<?php echo htmlspecialchars($row['copy_content_description'], ENT_QUOTES, 'UTF-8');?>-->
												</div>
											</div>
										</div>
										<?php } ?>
								<?php if($row['pickup_adno'] != '') { ?>
								<div class="row static-info">
									<div class="col-md-5 col-xs-6 name">Pickup Ad No</div>
									<div class="col-md-7 col-xs-6 value"><?php echo $row['pickup_adno']; ?></div>
								</div>
								<?php } ?>
								<?php if($row['copy_content']!=="") { ?>
								<div class="row static-info">
									<div class="col-md-5 col-xs-6 name">Copy/Content</div>
									<div class="col-md-7 col-xs-6 value">
										<?php  if($row['copy_content']==1)  { echo "Included in the form"; }?>
										<?php  if($row['copy_content']==2)  { echo  "Sent separately"; }?>
										<?php  if($row['copy_content']==3)  { echo  "Changes only"; }?>
									</div>
								</div>
								<?php } if($row['notes']!=="") { ?>
								<div class="row static-info">
									<div class="col-md-5 col-xs-6 name">Note & Instructions</div>
									<div class="col-md-7 col-xs-6 value"><?php echo nl2br($row['notes']); ?></div>
								</div>
								<?php } ?>
							</div>				
						</div>
					</div>	
					
					<div class="col-md-6 col-sm-12">
						<div class="portlet blue-hoki box margin-bottom-15">
							<div class="portlet-title">
								<div class="caption">Customer Information</div>
							</div>
							<div class="portlet-body">
								<div class="row static-info">
									<div class="col-md-5 col-xs-6 name">Publication</div>
									<div class="col-md-7 col-xs-6 value"><?php echo $pub_name[0]['name']; ?></div>
								</div>
								<div class="row static-info">
									<div class="col-md-5 col-xs-6 name">AdRep Name</div>
									<div class="col-md-7 col-xs-6 value"><?php if(isset($adrep_name[0]['first_name'])){echo $adrep_name[0]['first_name'];}else {echo "";}  ?></div>
								</div>
								<div class="row static-info">
									<div class="col-md-5 col-xs-5 name">Email:</div>
									<div class="col-md-7 col-xs-7 value"><?php if(isset($adrep_name[0]['email_id'])){echo $adrep_name[0]['email_id'];}else {echo "";} ?></div>
								</div>
								<div class="row static-info">
									<div class="col-md-5 col-xs-6 name">Date Needed</div>
									<div class="col-md-7 col-xs-6 value"><?php echo $row['date_needed']; ?></div> 
								</div>
							</div>
						</div>
						<?php if($designer_alias[0]['designer_role'] == '2' || $designer_alias[0]['designer_role'] == '1' || $designer_alias[0]['designer_role'] == '4'){?>
						<div class="portlet blue-hoki box">
							<div class="portlet-title">
								<div class="caption">Downloads</div>
								<?php if($row['file_path']!='none') { ?>
								<div class="actions">
									<form method="post" action="<?php echo base_url().index_page().'new_designer/home/zip_folder';?>">
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
											if(isset($downloads))																	
											{																																				
												foreach($file_format as $format){
												$this->load->helper('directory');																		
												$map = glob($downloads.'/*{'.$format['name'].'}',GLOB_BRACE);																		
												if($map){																			
												foreach($map as $map_row)																			
												{  
											?>
											<tr>
												<td class="small"><?php echo $i; $i++;?></td>                                     
												<td> <?php echo basename($map_row) ?></td>
												<td>
												<a href="<?php echo base_url()?><?php echo $map_row ?>";  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
												<a href="<?php echo base_url()?>download.php?file_source=<?php echo $map_row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a>
												</td>
											</tr>
											<?php } } } } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div><?php } ?>
						
						
						<div class="portlet blue-hoki box margin-bottom-10">
							<div class="portlet-title">
								<div class="caption">PickUp Ad</div>
								<div class="actions">
									<a id="pickup" class="font-grey-cararra tooltips" data-container="body" data-placement="top" data-original-title="Attach File">
									<i class="fa fa-link"></i></a> &nbsp;              
								</div>
							</div>
							<div class="portlet-body">
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
							<div class="row no-space margin-bottom-10" id="pickup_files">
								<form class="dropzone border-dashed" action="<?php echo base_url().index_page().'new_designer/home/attach_pickup_file/'.$order_id;?>" method="post" enctype="multipart/form-data">
									<div class="dz-default dz-message margin-top-20">
									<?php if(isset($redirect)){ ?>
									<input type="text" name="redirect" id="redirect" value="<?php echo $redirect; ?>"  readonly style="display:none" />
									<?php } ?>
									<input type="text" name="pickup_adno" id="redirect" value="<?php echo $row['pickup_adno']; ?>"  readonly style="display:none" />
									<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="pickup">
										<span><strong>Drag files</strong> or click to upload</span>
									</div>
								</form>
							</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-xs-2 text-right"></div>
							<?php if($designer_alias[0]['designer_role'] == '3') { ?>
							<div class="col-md-3 col-xs-5 text-right">
							<?php if($row['file_path']!='none') { ?>
									<form method="post" action="<?php echo base_url().index_page().'new_designer/home/zip_folder';?>">
									<input name="file_path" value="downloads/<?php echo($order_id.'-'.$row['job_no'])?>" readonly style="display:none;" /> 
									<input name="file_name" value="<?php echo($order_id.'-'.$row['job_no'])?>" readonly style="display:none;" />
									<button type="submit" name="Submit" class="btn btn-block btn-default btn-sm">Downloads</button>
									</form>
								<?php } ?>
							</div><?php } ?>
						</div>
					</div>
				</div>	
			</div>
		</div>
	</div>
</div>
	
<!--Question and Answer Display starts-->
<?php foreach($orders as $row)
		if($row['question']=="1" || $row['question']=="2") { ?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN TOOLTIPS PORTLET-->
		<div class="portlet light">
			<div class="portlet-titl no-space">
				<div class="row static-info">
					<div class="col-xs-6 margin-top-15">Question & Answer
					</div>
					<div class="col-xs-6 tools text-right margin-top-15">
						<i class="fa fa-angle-down font-lg" id="show_conversation1"></i>
					</div>								
				</div>
			</div>
			<div class="portlet-body"  id="conversation1">
				<hr class="no-space margin-bottom-10">
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
		<!-- END TOOLTIPS PORTLET-->
		</div>
	</div>
</div>
<?php } ?>
<!--Question and Answer Display starts-->			
				
<!--- Production Status 0 Starts-->
<?php if(($cat[0]['slug']=='none') && ($designer_alias[0]['designer_role'] == '1' || $designer_alias[0]['designer_role'] == '3')) { ?>			
	<?php if($row['question']!="1" && $row['cancel']!="1" && $row['crequest']!="1") { ?> 
<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
			<div class="portlet-body text-center">
				<form name="form" method="post">
					<input type="text" name="cat_result_id" id="cat_result_id" value="<?php if(isset($cat))echo $cat[0]['id']; ?>" Hidden />
					<input name="slug" value="<?php echo $slug;?>" readonly style="display:none;" />
					<?php if(isset($slug)){ ?>
					<p class="font-darkgrey word-break"><?php echo $slug ;?></p>
					<button type="submit" name="confirm_slug" class="btn bg-green" onclick="return sluf_confirm()">Start Design</button>
					<?php } ?>
				</form> 
			</div>
		</div>
	</div>
</div>
<?php } } ?>
<!--- Production Status 0 Ends  -->

<!--REASSIGN for designer_role 0,1,2 Starts--->
<?php if(($cat[0]['pro_status'] == '1') && ($designer_alias[0]['designer_role'] == '1' || $designer_alias[0]['designer_role'] == '2')) { ?>
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
<!--REASSIGN for designer_role 0,1,2 Ends--->

<!--- Production Status 1 Starts-->
<?php if($cat[0]['pro_status']=='1' && ($row['cancel']!="1") && ($row['crequest']!="1") && ($cat[0]['designer'] == $this->session->userdata('dId') || $designer_alias[0]['designer_role'] == '1' || $designer_alias[0]['designer_role'] == '2')) { ?> 
<div class="row">
	<div class="col-md-6">
		<div class="portlet light">
		<?php if(($cat[0]['slug']!='none')){ ?>
			<div class="portlet-title">
				<div class="row static-info">
					<div class="col-md-8">    
						<span class="word-break"><?php echo $cat[0]['slug'];  ?></span><br>
						<small class="font-red font-xs">(Copy this slug & paste it into the design document)</small>
					</div>
					<div class="col-md-4 margin-top-5 text-right">
						<?php if(isset($sourcefile)) { 
							$map2 = glob($sourcefile.'/'.$slug.'.{zip}',GLOB_BRACE) ;
								if($map2){ 
									foreach($map2 as $row_map2){ $source_file = basename($row_map2); } ?>
								<form action="<?php echo base_url().'index.php/new_designer/home/zip_folder_select'?>" method="post">
									<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
									<input name="new_slug" value="<?php echo $slug;?>" readonly style="display:none;" />
									<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
									<input name="download" value="download" readonly style="display:none;" />
									<button type="submit" name="SourceDownload" class="btn btn-default btn-sm">Package</button>
								</form>
						<?php } }?>
					</div>
				</div>
			</div>
			
			<!---new file upload function starts-->
			<?php $order_details = $this->db->query("SELECT * FROM `orders` WHERE `id`='".$order_id."'")->result_array();?>							
			<div class="portlet-body" id="upload">
			<?php echo '<h4 style="color:#900;">'.$this->session->flashdata('file_message').'</h4>'; ?>
			<div class="scroller" style="height:200px" data-always-visible="1" data-rail-visible="0">
				<div class="row">									
					<div class="col-md-6 col-sm-6 col-xs-12 margin-bottom-15">	
					  <div class="row no-space border-dashed">
							<div class="col-md-4 col-sm-3 col-xs-4 no-space">	
								<img class="padding-6" src="<?php echo base_url();?>assets/new_designer/img/indd.jpg" alt="indd" width="100%">
							</div>
							<?php if($order_details[0]['order_type_id'] == '1') { ?>
							<div class="col-md-8 col-sm-9 col-xs-8 no-space">	
								<form action="<?php echo base_url().index_page().'new_designer/home/new_fileuploads/'.$order_id; ?>"  id="dropzonepsd" class="dropzone" method="post">
									<input type="hidden" name="slug_name" id="slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $cat[0]['slug'];  ?>">
									<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="psd">
									<div class="dz-default dz-message margin-top-20">
										<span>PSD File</span>
									</div>
								</form>
							</div>
							<?php } else { ?>
							<div class="col-md-8 col-sm-9 col-xs-8 no-space">	
								<form action="<?php echo base_url().index_page().'new_designer/home/new_fileuploads/'.$order_id; ?>"  id="dropzoneindd" class="dropzone" method="post">
									<input type="hidden" name="slug_name" id="slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $cat[0]['slug'];  ?>">
									<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="indd">
									<div class="dz-default dz-message margin-top-20">
										<span>Indesign File</span>
									</div>
								</form>
							</div>
							<?php } ?>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12 margin-bottom-15">	
					  <div class="row no-space border-dashed">
							<div class="col-md-4 col-sm-3 col-xs-4 no-space">	
								<img class="padding-6" src="<?php echo base_url();?>assets/new_designer/img/pdf.jpg" alt="pdf" width="100%">
							</div>	
							<?php if($order_details[0]['order_type_id'] == '1') { ?>
							<div class="col-md-8 col-sm-9 col-xs-8 no-space">	
								<form action="<?php echo base_url().index_page().'new_designer/home/new_fileuploads/'.$order_id; ?>"   id="dropzoneimages" class="dropzone" method="post">
									<input type="hidden" name="slug_name" id="slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $cat[0]['slug'];?>">
									<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="images">
									<div class="dz-default dz-message margin-top-20">
										<span>Image File</span>
									</div>
								</form>
							</div>	
							<?php } else { ?>
							<div class="col-md-8 col-sm-9 col-xs-8 no-space">	
								<form action="<?php echo base_url().index_page().'new_designer/home/new_fileuploads/'.$order_id; ?>"   id="dropzonepdf" class="dropzone" method="post">
									<input type="hidden" name="slug_name" id="slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $cat[0]['slug'];?>">
									<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="pdf">
									<div class="dz-default dz-message margin-top-20">
										<span>PDF File</span>
									</div>
								</form>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
						
				<div class="row">
					<div class="col-xs-6 margin-bottom-15">	
					  <div class="row no-space border-dashed" id="links">
							<div class="col-md-12 col-sm-12 col-xs12 no-space">	
								<form action="<?php echo base_url().index_page().'new_designer/home/new_fileuploads/'.$order_id; ?>"   id="dropzone" class="dropzone" method="post">
									<input type="hidden" name="slug_name" id="slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $cat[0]['slug'];?>">
									<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="links">
									<div class="dz-default dz-message margin-top-20 margin-bottom-20">
										<span>Links File</span>
									</div>
								</form>
							</div>	
						</div>
					</div>
					<div class="col-xs-6 margin-bottom-15">	
					  <div class="row no-space border-dashed" id="fonts">
							<div class="col-md-12 col-sm-12 col-xs12 no-space">	
								<form action="<?php echo base_url().index_page().'new_designer/home/new_fileuploads/'.$order_id; ?>"   id="dropzone" class="dropzone" method="post">
									<input type="hidden" name="slug_name" id="slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $cat[0]['slug'];?>">
									<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="fonts">
									<div class="dz-default dz-message margin-top-20 margin-bottom-20">
										<span>Fonts File</span>
									</div>
								</form>
							</div>	
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-xs-12 text-center">
					<form method="post">
					<input type="text"  name="slug" value="<?php echo $cat[0]['slug']; ?>" readonly style="display:none;" >
					<button name="file_submit"  type="submit" class="btn btn-success btn-sm">Refresh Folder structure</button>
					</form> 
				</div>
			</div>
			</div>
<?php } ?>	
	
<?php if(isset($sourcefile)){
	$this->load->helper('directory');	
	$map_dir = glob($sourcefile.'/'.$slug.'.{indd,pdf,psd,ai,jpg,gif,png}',GLOB_BRACE);	
	if($map_dir){
		$map_links = directory_map($sourcefile.'/Links/');	
		$map_fonts = directory_map($sourcefile.'/Document fonts/'); ?>	
			<div class="portlet-body text-center">					
				<div id="tree_1" class="tree-demo margin-bottom-30 text-left wrap">
					<ul>
						<li data-jstree='{ "opened" : true }'>
							<?php echo $order_id; ?>
							<ul>
								<?php foreach($map_dir as $files){ ?>
									<li data-jstree='{ "type" : "file" }'>
										<a href="<?php echo base_url()?>download.php?file_source=<?php echo $files; ?>" class="btn btn-circle btn-xs">
											<?php echo basename($files); ?>
										</a>
									</li>
								<?php } ?>
								<li>Links &nbsp; <span class="badge bg-red"><?php echo count($map_links); ?></span>
									<ul>
										<?php if($map_links)foreach($map_links as $link_files){ ?>
										<li data-jstree='{ "type" : "file" }'>
										<a href="#"><?php echo basename($link_files); ?> </a></li><?php } ?>
									</ul>
								</li>	
								<li>Fonts &nbsp; <span class="badge bg-red"><?php echo count($map_fonts); ?></span>
									<ul>
										<?php if($map_fonts)foreach($map_fonts as $font_files){ ?>
										<li data-jstree='{ "type" : "file" }'>
										<a href="#"><?php echo basename($font_files); ?> </a></li><?php } ?>
									</ul>
								</li>
							</ul>
						</li>
					</ul>
				 </div>
			</div>
<?php } } ?>
		</div>
	</div>
					
<!--====Conversations======-->
	<div class="col-md-6">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="row static-info margin-top-10">
					<div class="col-md-10">Conversations</div>
				</div>
			</div>
			<div class="row portlet-body">
				<div class="col-md-12 col-sm-12">
				  <div class="scroller" style="height:250px" data-always-visible="1" data-rail-visible="0">
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

	
	<div class="col-md-12 text-center">
		<div class="portlet light">
			<div class="portlet-body">
				<p class="margin-top-10 font-red">Check your folder & make sure everything is Uploaded!</p>
				<div class="row">
					<div class="col-xs-3">	
						<p class="no-margin margin-bottom-10">
						<?php $help_desk1 = $this->db->query("SELECT * FROM `help_desk` WHERE `id` = '".$cat[0]['help_desk']."' AND `sold` = '1'")->result_array();
							if($help_desk1) { ?>
							<input id="Links_File" type="checkbox">Upload Sold 
						<div class="row no-space border-dashed" id="links1" style="display:none;">
							<div class="col-md-12 col-sm-12 col-xs12 no-space">	
								<form action="<?php echo base_url().index_page().'new_designer/home/newsold_pdf_upload/'.$order_id; ?>"   id="dropzonesoldpdf" class="dropzone" method="post">
									<input type="hidden" name="slug_name" id="sold_slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $cat[0]['slug'].'_sold';?>">
									<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="pdf">
									<div class="dz-default dz-message margin-top-20">
										<span>PDF File</span>
									</div>
								</form>
							</div>	
						</div>
						<small class="font-red font-xs">(Slug name)</small>
						<span class="word-break"><?php echo $cat[0]['slug'].'_sold';  ?></span><br><?php } ?>
					</div>
					
					<div class="col-xs-6">	
						<form method="POST">
							<input type="text" Hidden name="designer_id" value="<?php echo $cat[0]['designer']; ?>" >
							<input type="text" hidden name="start_time" value="<?php echo $cat[0]['ddate']; ?> <?php echo  $cat[0]['start_time'];  ?>" >
							<input type="text" hidden name="source_path" value="<?php if(isset($sourcefile)) echo $sourcefile; ?>" >
							<input type="text" hidden name="slug" value="<?php echo $cat[0]['slug']; ?>" >
							<p class="no-margin"><input id="show_message" type="checkbox">Send message 
								<div class="row">
									<div class="col-md-4 col-md-offset-4">
										<textarea name="note" id="message" rows="2" value="1" class="form-control margin-top-10"></textarea>
									</div>
								</div>
							</p>
							<p class="margin-bottom-10">
							<?php if($designer_alias[0]['designer_role'] == '4'){ ?>
								<input type="text" name="hd" hidden value="<?php echo $hd; ?>">
								<input name="new_slug" value="<?php echo $slug;?>" readonly style="display:none;" />
								<input name="cat_slug" value="<?php echo $slug;?>" readonly style="display:none;" />
								
								<button type="submit" name="complete" class="btn red" onclick="return warning_confirm()" onClick="complete(<?php echo $order_id; ?>)">	Send to Adrep </button>
							<?php }else{?>
								<button type="submit" name="complete" class="btn red" onclick="return warning_confirm()" onClick="complete(<?php echo $order_id; ?>)">	End Design </button>
							<?php } ?>
							</p>
						</form>
					</div>
					
					<div class="col-xs-3">	
						<p class="no-margin margin-bottom-10">
						<?php $idml_pub = $this->db->query("SELECT * FROM `publications` WHERE `id` = '".$cat[0]['publication_id']."' AND `idml` = '1'")->result_array();
							if(isset($idml_pub[0]['id'])) { ?>
							<input id="idml_File" type="checkbox">Upload idml 
						<div class="row no-space border-dashed" id="idml1" style="display:none;">
							<div class="col-md-12 col-sm-12 col-xs12 no-space">	
								<form action="<?php echo base_url().index_page().'new_designer/home/idml_upload/'.$order_id; ?>"   id="dropzoneidml" class="dropzone" method="post">
									<input type="hidden" name="slug_name" id="idml_slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $cat[0]['slug'];?>">
									<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="idml">
									<div class="dz-default dz-message margin-top-20">
										<span>IDML File</span>
									</div>
								</form>
							</div>	
						</div>
						<small class="font-red font-xs">(Slug name)</small>
						<span class="word-break"><?php echo $cat[0]['slug'];  ?></span><br><?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<!--- Production Status 1 Ends  -->

<!--- Production Status 2 Starts-->
<?php if(($cat[0]['pro_status'] == '2') && ($designer_alias[0]['designer_role'] == '3') && (!isset($rev_orders))){ ?> 
<div class="row">
	<div class="col-md-6"> 
		<div class="portlet light margin-0">
			<div class="portlet-tite no-space">
				<div class="row static-info">
					<div class="col-md-7 col-xs-1 margin-top-15"><?php echo $cat[0]['version'] ;?></div>
					<?php
						$from=date_create($orders[0]['created_on']);
						$to=date_create(date("Y-m-d"));
						$diff=date_diff($from,$to);
						$date_diff = $diff->format("%a");

						if($date_diff > $pub_name[0]['rev_days']) {
							if(file_exists($orders[0]['pdf']))  { ?>
						<div class="col-md-6 col-xs-6 pull-right ">
							<a href="<?php echo base_url().''.$orders[0]['pdf'];?>" target="_Blank" class="btn btn-block btn-default btn-sm">PDF</a>
						</div>
					<?php } } else {?>
					<div class="col-md-5 col-xs-6 pull-right text-right margin-top-10">
						<div class="row">
							<?php if(isset($sourcefile)) { 
								$map2 = glob($sourcefile.'/'.$slug.'.{indd,psd}',GLOB_BRACE);  ?>
								<?php $source_zip_file = $sourcefile.'/'.$cat[0]['slug'].'.zip' ; 
										if(file_exists($source_zip_file)){ ?>
								<div class="col-md-6 col-xs-6 no-space">		
										<a href="<?php echo base_url()?><?php echo $source_zip_file ?>" class="btn btn-block btn-default btn-xs">Package</a>
								</div>
								<?php } else {	
								if($map2){ foreach($map2 as $row_map2){ $source_file = basename($row_map2); } ?>	
								<div class="col-md-6 col-xs-6">
									<form action="<?php echo base_url().'index.php/new_designer/home/zip_folder_select'?>" method="post">
										<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
										<input name="new_slug" value="<?php echo $slug;?>" readonly style="display:none;" />
										<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
										<input name="download" value="download" readonly style="display:none;" />
										<button type="submit" name="SourceDownload" class="btn btn-block btn-default btn-xs">Package</button>
									</form>
								</div>
								<?php } }  $this->load->helper('directory');	
									$map = glob($sourcefile.'/'.$slug.'.{pdf,jpg,gif,png}',GLOB_BRACE);								
										if($map){			
											foreach($map as $row){		  
								?>
								<div class="col-md-6 col-xs-6">
									<a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-block btn-default btn-xs">PDF</a>
								</div>
							<?php } } } ?>
						</div>
					</div>
<?php }?>
				</div>
			</div>
		</div>
	</div>
	<!--====Conversations======-->
	<div class="col-md-6">
		<div class="portlet light margin-0">
			<div class="portlet-titl no-space">
				<div class="row static-info">
					<div class="col-xs-6 margin-top-15">Conversation</div>
					<div class="col-xs-6 tools text-right margin-top-15">
						<i class="fa fa-angle-down font-lg" id="show_conversation"></i>
					</div>								
				</div>
			</div>
			<div class="portlet-body margin-top-10" id="conversation">
				<hr class="no-space margin-bottom-10">
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
<!--- Production Status 2 Ends  -->

<!------ Production Status 2 for designer_role 1,2 Starts ------->
 <?php $pp = $this->db->query("SELECT * FROM `designer_ads_time` WHERE `order_id`='".$order_id."'")->result_array();
		$designer = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$cat[0]['designer']."'")->result_array(); 
if(($cat[0]['pro_status'] == '2') && ($designer_alias[0]['designer_role'] == '1' || $designer_alias[0]['designer_role'] == '2')){ ?>
<div class="row">
	<div class="col-md-6"> 
		<div class="portlet light">
			<div class="portlet-title">
				<div class="row static-info">
					<div class="col-md-2 value bold margin-top-5"><?php if($cat) { echo $cat[0]['version']; }?> &nbsp;
						<a class="popovers margin-right-10" data-trigger="hover" data-container="body" data-placement="top" data-title="Ad Designed by: <?php echo $designer[0]['name'];  ?> (<?php echo $designer[0]['username'];  ?>)" data-content="Date & Time: <?php echo $pp[0]['end_date'] ?> <?php echo $pp[0]['end_time'] ?>">
							<i class="fa  fa-info-circle"></i></a>
					</div>
					<?php
						$from=date_create($orders[0]['created_on']);
						$to=date_create(date("Y-m-d"));
						$diff=date_diff($from,$to);
						$date_diff = $diff->format("%a");

						if($date_diff > $pub_name[0]['rev_days']) {
							if(file_exists($orders[0]['pdf']))  { ?>
						<div class="col-md-6 col-xs-6 pull-right ">
							<a href="<?php echo base_url().''.$orders[0]['pdf'];?>" target="_Blank" class="btn btn-block btn-default btn-sm">PDF</a>
						</div>
					<?php } } else {?>
					<div class="col-md-10 text-right">						
						<?php  $i=1;  if(isset($sourcefile)) { $this->load->helper('directory');	
						$map = glob($sourcefile.'/'.$cat[0]['slug'].'.{pdf,jpg,gif,png}',GLOB_BRACE);								
						if($map){ foreach($map as $row) { ?>
						  <a href="<?php echo base_url()?><?php echo $row ?>" target="_Blank" class="btn btn-default btn-sm">PDF</a>
						<?php } } } ?>
					</div>
					<?php }?>
				</div>
			</div>
			<div class="portlet-body">
				<div class=" portlet-tabs">
					<ul class="nav nav-tabs">
						<input type="text" Hidden value="<?php echo $order_id; ?>" name="order_id" >
						<li class="active"><a href="#portlet_tab1" data-toggle="tab">To QA</a></li>
						<!--<li><a href="#portlet_tab2" data-toggle="tab">To DC </a></li>-->
						<li><a href="#portlet_tab3" data-toggle="tab">To Designer</a></li>
						<form method="POST">
						<?php 
							//zip source
							if(isset($sourcefile)){
								$map2 = glob($sourcefile.'/'.$slug.'.{indd,psd}',GLOB_BRACE); 
								if($map2){ 
									foreach($map2 as $row_map2){ $source_file = basename($row_map2); }	
						?>
						<li>
							<input name="new_slug" value="<?php echo $cat[0]['slug'];?>" readonly style="display:none;" />
							<button type="submit" name="make_changes" onclick="return Make_confirm()" class="btn btn-default tab-btn">Make Changes</button>
							<input type="text" Hidden name="designer_id" value="<?php echo $cat[0]['designer']; ?>" >
							<input type="text" hidden name="start_time" value="<?php echo $cat[0]['ddate']; ?> <?php echo  $cat[0]['start_time'];  ?>" >
							<input name="order_id" value="<?php echo $order_id;?>" readonly style="display:none;" />
							<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
							<input name="archive" value="archive" readonly style="display:none;" />
							<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
						</li>
						<?php } } ?>
						</form>
					</ul>
					<div class="tab-content">
						<!-- To QA Starts-->
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
						<!-- To QA Ends-->
						<!-- To Designer Starts-->
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
										<?php  $i=1;  if(isset($sourcefile)) { 
										$map2 = glob($sourcefile.'/'.$cat[0]['slug'].'.{indd,psd}',GLOB_BRACE); 
											if($map2){ 
												foreach($map2 as $row_map2){ $source_file = basename($row_map2); }?>
												<div class="col-md-4 col-xs-6 no-space">
													<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row_map2; ?>"
													class="btn btn-default btn-sm">In-Design</a>
												</div>
												
												<div class="col-md-5 col-xs-6">
													<form action="<?php echo base_url().'index.php/new_designer/home/zip_folder_select'?>" method="post">
														<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
														<input name="new_slug" value="<?php echo $cat[0]['slug'];?>" readonly style="display:none;" />
														<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
														<input name="download" value="download" readonly style="display:none;" />
														<button type="submit" name="SourceDownload" class="btn btn-default btn-sm">Package</button>
													</form>
												</div>
												<?php }
											 } ?>
										</div>
									</div>
								</div>
							<div class="row"></div>							
						</div>
						<!-- To Designer Ends-->
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
<!------ Production Status 2 for designer_role 1,2 Ends   ------->

<!--- Production Status 3,4 Starts -->
<?php if(($cat[0]['pro_status'] == '3' || $cat[0]['pro_status'] == '4') && (!isset($rev_orders))){ ?> 
<div class="row">
	<div class="col-md-6">
		<div class="portlet light margin-0">
			<div class="portlet-tite no-space">
				<div class="row static-info">
					<div class="col-md-7 col-xs-1 margin-top-15"><?php echo $cat[0]['version'] ;?></div>
					
					<div class="col-md-5 col-xs-6 pull-right text-right margin-top-10">
						<div class="row">
						<?php
						$from=date_create($orders[0]['created_on']);
						$to=date_create(date("Y-m-d"));
						$diff=date_diff($from,$to);
						$date_diff = $diff->format("%a");

						if($date_diff > $pub_name[0]['rev_days']) {
							if(file_exists($orders[0]['pdf']))  { ?>
						<div class="col-md-6 col-xs-6 pull-right ">
							<a href="<?php echo base_url().''.$orders[0]['pdf'];?>" target="_Blank" class="btn btn-block btn-default btn-sm">PDF</a>
						</div>
						<?php } } else {?>
							<?php if(isset($sourcefile)) { 
								$map2 = glob($sourcefile.'/'.$slug.'.{indd,psd}',GLOB_BRACE);  ?>
								<?php $source_zip_file = $sourcefile.'/'.$cat[0]['slug'].'.zip' ; 
										if(file_exists($source_zip_file)){ ?>
								<div class="col-md-6 col-xs-6 no-space">		
										<a href="<?php echo base_url()?><?php echo $source_zip_file ?>" class="btn btn-block btn-default btn-xs">Package</a>
								</div>
								<?php } else {	
								if($map2){ foreach($map2 as $row_map2){ $source_file = basename($row_map2); } ?>	
								<div class="col-md-6 col-xs-6">
									<form action="<?php echo base_url().'index.php/new_designer/home/zip_folder_select'?>" method="post">
										<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
										<input name="new_slug" value="<?php echo $slug;?>" readonly style="display:none;" />
										<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
										<input name="download" value="download" readonly style="display:none;" />
										<button type="submit" name="SourceDownload" class="btn btn-block btn-default btn-xs">Package</button>
									</form>
								</div>
								<?php } }  $this->load->helper('directory');	
									$map = glob($sourcefile.'/'.$slug.'.{pdf,jpg,gif,png}',GLOB_BRACE);								
										if($map){			
											foreach($map as $row){		  
								?>
								<div class="col-md-6 col-xs-6">
									<a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-block btn-default btn-xs">PDF</a>
								</div>
							<?php } } } ?>
							<?php }?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--====Conversations======-->
	<div class="col-md-6">
		<div class="portlet light margin-0">
			<div class="portlet-titl no-space">
				<div class="row static-info">
					<div class="col-xs-6 margin-top-15">Conversation</div>
					<div class="col-xs-6 tools text-right margin-top-15">
						<i class="fa fa-angle-down font-lg" id="show_conversation"></i>
					</div>								
				</div>
			</div>
			<div class="portlet-body margin-top-10" id="conversation">
			<hr class="no-space margin-bottom-10">
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
<!--- Production Status 3,4 Ends   -->

<!--- Production Status 5 Starts -->
<?php if(($cat[0]['pro_status'] == '5') && (!isset($rev_orders))){ ?> 
<div class="row">
	<div class="col-md-6">
		<div class="portlet light margin-0">
			<div class="portlet-tite no-space">
				<div class="row static-info">
					<div class="col-md-7 col-xs-1 margin-top-15"><?php echo $cat[0]['version'] ;?></div>
					<div class="col-md-5 col-xs-6 pull-right text-right margin-top-10">
						<div class="row">
						<?php
								$from=date_create($orders[0]['created_on']);
								$to=date_create(date("Y-m-d"));
								$diff=date_diff($from,$to);
								$date_diff = $diff->format("%a");

								if($date_diff > $pub_name[0]['rev_days']) {
									if(file_exists($orders[0]['pdf']))  { ?>
								<div class="col-md-6 col-xs-6 pull-right ">
									<a href="<?php echo base_url().''.$orders[0]['pdf'];?>" target="_Blank" class="btn btn-block btn-default btn-sm">PDF</a>
								</div>
							<?php } } else {?>
							<?php if(isset($sourcefile)) { 
								$map2 = glob($sourcefile.'/'.$slug.'.{indd,psd}',GLOB_BRACE);  ?>
								<?php $source_zip_file = $sourcefile.'/'.$cat[0]['slug'].'.zip' ; 
										if(file_exists($source_zip_file)){ ?>
								<div class="col-md-6 col-xs-6 no-space">		
										<a href="<?php echo base_url()?><?php echo $source_zip_file ?>" class="btn btn-block btn-default btn-xs">Package</a>
								</div>
								<?php } else {	
								if($map2){ foreach($map2 as $row_map2){ $source_file = basename($row_map2); } ?>	
								<div class="col-md-6 col-xs-6">
									<form action="<?php echo base_url().'index.php/new_designer/home/zip_folder_select'?>" method="post">
										<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
										<input name="new_slug" value="<?php echo $slug;?>" readonly style="display:none;" />
										<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
										<input name="download" value="download" readonly style="display:none;" />
										<button type="submit" name="SourceDownload" class="btn btn-block btn-default btn-xs">Package</button>
									</form>
								</div>
								<?php } }  $this->load->helper('directory');	
									$map = glob($sourcefile.'/'.$slug.'.{pdf,jpg,gif,png}',GLOB_BRACE);								
										if($map){			
											foreach($map as $row){		  
								?>
								<div class="col-md-6 col-xs-6">
									<a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-block btn-default btn-xs">PDF</a>
								</div>
							<?php } } }elseif($cat[0]['ftp_source_path'] != 'none' && $cat[0]['ftp_source_path'] != ''){ ?>
										<div class="col-md-6 col-xs-6">
											<a href="<?php echo $cat[0]['ftp_source_path']; ?>" class="btn grey btn-sm  btn-block">Package</a>
										</div>
										<div class="col-md-6 col-xs-6">
											<a href="<?php echo base_url()?><?php echo $cat[0]['pdf_path'] ?>"  target="_Blank" class="btn grey btn-sm  btn-block">PDF</a>
										</div>
								<?php } ?>
								<?php }?>
								
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--====Conversations======-->
	<div class="col-md-6">
		<div class="portlet light margin-0">
			<div class="portlet-titl no-space">
				<div class="row static-info">
					<div class="col-xs-6 margin-top-15">Conversation</div>
					<div class="col-xs-6 tools text-right margin-top-15">
						<i class="fa fa-angle-down font-lg" id="show_conversation"></i>
					</div>								
				</div>
			</div>
			<div class="portlet-body margin-top-10" id="conversation">
			<hr class="no-space margin-bottom-10">
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
<!--- Production Status 5 Ends   -->


<!--- Production Status 6,7 Starts -->
<?php $pp = $this->db->query("SELECT * FROM `designer_ads_time` WHERE `order_id`='".$order_id."' ORDER BY `id` DESC LIMIT 1")->result_array();
			if((isset($pp[0]['end_time'])) && ($cat[0]['pro_status']=='6' || $cat[0]['pro_status']=='7') && ($row['cancel']!='1' && $row['crequest']!='1') && ($cat[0]['designer'] == $this->session->userdata('dId') || $designer_alias[0]['designer_role'] == '1' || $designer_alias[0]['designer_role'] == '2')) { ?> 
			<div class="row">
				<div class="col-md-6">
					<div class="portlet light" id="upload">
						<div class="portlet-title">
							<div class="row static-info">
								<div class="col-md-7 col-xs-1 margin-top-10"><?php echo $cat[0]['version'] ;?></div>
								<div class="col-md-5 col-xs-6 pull-right text-right">
									<div class="row">
						<?php
						$from=date_create($orders[0]['created_on']);
						$to=date_create(date("Y-m-d"));
						$diff=date_diff($from,$to);
						$date_diff = $diff->format("%a");

						if($date_diff > $pub_name[0]['rev_days']) {
							if(file_exists($orders[0]['pdf']))  { ?>
						<div class="col-md-6 col-xs-6 pull-right ">
							<a href="<?php echo base_url().''.$orders[0]['pdf'];?>" target="_Blank" class="btn btn-block btn-default btn-sm">PDF</a>
						</div>
					<?php } } else {?>
									<?php if(isset($sourcefile)) { 
										$map2 = glob($sourcefile.'/'.$slug.'.{indd,psd}',GLOB_BRACE); 
											if($map2){ 
												foreach($map2 as $row_map2){ $source_file = basename($row_map2); } ?>
										<div class="col-md-6 col-xs-6 no-space">
											<form action="<?php echo base_url().'index.php/new_designer/home/zip_folder_select'?>" method="post">
												<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
												<input name="new_slug" value="<?php echo $slug;?>" readonly style="display:none;" />
												<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
												<input name="download" value="download" readonly style="display:none;" />
												<button type="submit" name="SourceDownload" class="btn btn-block btn-default btn-sm">Package</button>
											</form>
										</div>
										<?php }  $this->load->helper('directory');	
												$map = glob($sourcefile.'/'.$slug.'.{pdf,jpg,gif,png}',GLOB_BRACE);								
													if($map){			
														foreach($map as $row){		  
											?>
										<div class="col-md-6 col-xs-6">
											<a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-block btn-default btn-sm">PDF</a>
										</div>
									<?php } } } ?>
									<?php }?>
									</div>

								</div>
							</div>
						</div>
						
						<div class="portlet-body margin-top-10">
							<div class="scroller" style="height:205px" data-always-visible="1" data-rail-visible="0">
								<div class="row">
									<div class="col-xs-12 margin-top-30 text-center">
										<p class="margin-top-10 font-red margin-top-30">Please download package before click</p>
										<form method="post">
											<?php 
												//zip source
												if(isset($sourcefile)){
													$map2 = glob($sourcefile.'/'.$slug.'.{indd,psd}',GLOB_BRACE); 
													if($map2){ 
														foreach($map2 as $row_map2){ $source_file = basename($row_map2); }	
											?>
											<button type="submit" name="csr_tl_changes" class="btn btn-danger btn-sm">Make Changes</button>
											<input type="text" Hidden name="designer_id" value="<?php echo $cat[0]['designer']; ?>" >
											<input type="text" hidden name="start_time" value="<?php echo $cat[0]['ddate']; ?> <?php echo  $cat[0]['start_time'];  ?>" >
											<input name="order_id" value="<?php echo $order_id;?>" readonly style="display:none;" />
											<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
											<input name="new_slug" value="<?php echo $slug;?>" readonly style="display:none;" />
											<input name="archive" value="archive" readonly style="display:none;" />
											<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
												<?php } } ?>
										</form>
								</div>
								</div>
							</div>
						</div>
					</div>
				</div>
								
			<!--====Conversations======-->
				<div class="col-md-6">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="row static-info  margin-top-10">
								<div class="col-md-10">Conversations</div>
							</div>
						</div>
						<div class="row portlet-body">
							<div class="col-md-12 col-sm-12">
								<div class="scroller" style="height:205px" data-always-visible="1" data-rail-visible="0">
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
<!--- Production Status 6,7 Ends -->

<!------ Production Status 6-7 for designer_role 3 Starts ------->
<?php  $pp = $this->db->query("SELECT * FROM `designer_ads_time` WHERE `order_id`='".$order_id."'")->result_array();foreach($orders as $row)
			$designer = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$cat[0]['designer']."'")->result_array(); 
				if(($cat[0]['pro_status'] == '6' || $cat[0]['pro_status'] == '7') && ($row['status'] != '5' || $cat[0]['pro_status'] != '5') && ($designer_alias[0]['designer_role'] == '3')){ ?> 
<div class="row">
	<div class="col-md-6"> 
		<div class="portlet light margin-0">
			<div class="portlet-tite no-space">
				<div class="row static-info">
					<div class="col-md-7 col-xs-1 margin-top-15"><?php echo $cat[0]['version'] ;?></div>
					<div class="col-md-5 col-xs-6 pull-right text-right margin-top-10">
						<div class="row">
<?php
						$from=date_create($orders[0]['created_on']);
						$to=date_create(date("Y-m-d"));
						$diff=date_diff($from,$to);
						$date_diff = $diff->format("%a");

						if($date_diff > $pub_name[0]['rev_days']) {
							if(file_exists($orders[0]['pdf']))  { ?>
						<div class="col-md-6 col-xs-6 pull-right ">
							<a href="<?php echo base_url().''.$orders[0]['pdf'];?>" target="_Blank" class="btn btn-block btn-default btn-sm">PDF</a>
						</div>
					<?php } } else {?>
							<?php if(isset($sourcefile)) { 
								$map2 = glob($sourcefile.'/'.$slug.'.{indd,psd}',GLOB_BRACE);  ?>
								<?php $source_zip_file = $sourcefile.'/'.$cat[0]['slug'].'.zip' ; 
										if(file_exists($source_zip_file)){ ?>
								<div class="col-md-6 col-xs-6 no-space">		
										<a href="<?php echo base_url()?><?php echo $source_zip_file ?>" class="btn btn-block btn-default btn-xs">Package</a>
								</div>
								<?php } else {	
								if($map2){ foreach($map2 as $row_map2){ $source_file = basename($row_map2); } ?>	
								<div class="col-md-6 col-xs-6">
									<form action="<?php echo base_url().'index.php/new_designer/home/zip_folder_select'?>" method="post">
										<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
										<input name="new_slug" value="<?php echo $slug;?>" readonly style="display:none;" />
										<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
										<input name="download" value="download" readonly style="display:none;" />
										<button type="submit" name="SourceDownload" class="btn btn-block btn-default btn-xs">Package</button>
									</form>
								</div>
								<?php } }  $this->load->helper('directory');	
									$map = glob($sourcefile.'/'.$slug.'.{pdf,jpg,gif,png}',GLOB_BRACE);								
										if($map){			
											foreach($map as $row){		  
								?>
								<div class="col-md-6 col-xs-6">
									<a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-block btn-default btn-xs">PDF</a>
								</div>
							<?php } } } ?>
<?php }?>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
	<!--====Conversations======-->
	<div class="col-md-6">
		<div class="portlet light margin-0">
			<div class="portlet-titl no-space">
				<div class="row static-info">
					<div class="col-xs-6 margin-top-15">Conversation</div>
					<div class="col-xs-6 tools text-right margin-top-15">
						<i class="fa fa-angle-down font-lg" id="show_conversation"></i>
					</div>								
				</div>
			</div>
			<div class="portlet-body margin-top-10" id="conversation">
				<hr class="no-space margin-bottom-10">
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
<!------ Production Status 6-7 for designer_role 1,2 Starts ------->

<!--- Production Status 8 Starts-->
<?php if(($cat[0]['pro_status'] == '8') && ($designer_alias[0]['designer_role'] == '3') && (!isset($rev_orders))){ ?> 
<div class="row">
	<div class="col-md-6"> 
		<div class="portlet light margin-0">
			<div class="portlet-tite no-space">
				<div class="row static-info">
					<div class="col-md-7 col-xs-1 margin-top-15"><?php echo $cat[0]['version'] ;?></div>
					<div class="col-md-5 col-xs-6 pull-right text-right margin-top-10">
						<div class="row">
						<?php
						$from=date_create($orders[0]['created_on']);
						$to=date_create(date("Y-m-d"));
						$diff=date_diff($from,$to);
						$date_diff = $diff->format("%a");

						if($date_diff > $pub_name[0]['rev_days']) {
							if(file_exists($orders[0]['pdf']))  { ?>
						<div class="col-md-6 col-xs-6 pull-right ">
							<a href="<?php echo base_url().''.$orders[0]['pdf'];?>" target="_Blank" class="btn btn-block btn-default btn-sm">PDF</a>
						</div>
						<?php } } else {?>
							<?php if(isset($sourcefile)) { 
								$map2 = glob($sourcefile.'/'.$slug.'.{indd,psd}',GLOB_BRACE);  ?>
								<?php $source_zip_file = $sourcefile.'/'.$cat[0]['slug'].'.zip' ; 
										if(file_exists($source_zip_file)){ ?>
								<div class="col-md-6 col-xs-6 no-space">		
										<a href="<?php echo base_url()?><?php echo $source_zip_file ?>" class="btn btn-block btn-default btn-xs">Package</a>
								</div>
								<?php } else {	
								if($map2){ foreach($map2 as $row_map2){ $source_file = basename($row_map2); } ?>	
								<div class="col-md-6 col-xs-6">
									<form action="<?php echo base_url().'index.php/new_designer/home/zip_folder_select'?>" method="post">
										<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
										<input name="new_slug" value="<?php echo $slug;?>" readonly style="display:none;" />
										<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
										<input name="download" value="download" readonly style="display:none;" />
										<button type="submit" name="SourceDownload" class="btn btn-block btn-default btn-xs">Package</button>
									</form>
								</div>
								<?php } }  $this->load->helper('directory');	
									$map = glob($sourcefile.'/'.$slug.'.{pdf,jpg,gif,png}',GLOB_BRACE);								
										if($map){			
											foreach($map as $row){		  
								?>
								<div class="col-md-6 col-xs-6">
									<a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-block btn-default btn-xs">PDF</a>
								</div>
							<?php } } } ?>
<?php }?>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
	<!--====Conversations======-->
	<div class="col-md-6">
		<div class="portlet light margin-0">
			<div class="portlet-titl no-space">
				<div class="row static-info">
					<div class="col-xs-6 margin-top-15">Conversation</div>
					<div class="col-xs-6 tools text-right margin-top-15">
						<i class="fa fa-angle-down font-lg" id="show_conversation"></i>
					</div>								
				</div>
			</div>
			<div class="portlet-body margin-top-10" id="conversation">
				<hr class="no-space margin-bottom-10">
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
<!--- Production Status 8 Ends  -->

<!------ Production Status 8 for designer_role 1,2 Starts ------->
<?php  $pp = $this->db->query("SELECT * FROM `designer_ads_time` WHERE `order_id`='".$order_id."'")->result_array();foreach($orders as $row)
			$designer = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$cat[0]['designer']."'")->result_array(); 
				if(($cat[0]['pro_status'] == '8') && ($row['status'] != '5' || $cat[0]['pro_status'] != '5') && ($designer_alias[0]['designer_role'] == '1' || $designer_alias[0]['designer_role'] == '2')){ ?> 
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
					<?php
						$from=date_create($orders[0]['created_on']);
						$to=date_create(date("Y-m-d"));
						$diff=date_diff($from,$to);
						$date_diff = $diff->format("%a");

						if($date_diff > $pub_name[0]['rev_days']) {
							if(file_exists($orders[0]['pdf']))  { ?>
						<div class="col-md-6 col-xs-6 pull-right ">
							<a href="<?php echo base_url().''.$orders[0]['pdf'];?>" target="_Blank" class="btn btn-block btn-default btn-sm">PDF</a>
						</div>
					<?php } } else {?>
					<?php  $i=1;  
					if(isset($sourcefile)) { 
							$this->load->helper('directory');	
							$map = glob($sourcefile.'/'.$cat[0]['slug'].'.{pdf,jpg,gif,png}',GLOB_BRACE);								
							if($map){ 
								foreach($map as $row) { 
					?>
					<div class="col-md-7 text-right">
					  <div class="row">
						 <div class="col-md-4">
							<a href="<?php echo base_url()?><?php echo $row ?>" target="_Blank" class="btn btn-default btn-sm btn-block">PDF</a>
						 </div>
						 <?php  $i=1; 
										$map2 = glob($sourcefile.'/'.$cat[0]['slug'].'.{indd,psd}',GLOB_BRACE); 
											if($map2){ foreach($map2 as $row_map2){ $source_file = basename($row_map2); } ?>
						<div class="col-md-4 no-space">
							<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row_map2; ?>"
							class="btn btn-default btn-block btn-sm">In-Design</a>
						</div>
						 
						<div class="col-md-4">
							<form action="<?php echo base_url().'index.php/new_designer/home/zip_folder_select'?>" method="post">
								<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
								<input name="new_slug" value="<?php echo $cat[0]['slug'];?>" readonly style="display:none;" />
								<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
								<input name="download" value="download" readonly style="display:none;" />
								<button type="submit" name="SourceDownload" class="btn btn-default btn-block btn-sm">Package</button>
							</form>
						</div>
					  <?php } ?>
					 
					  </div>
					</div>
					<?php } }else{ //if zip file exists
								$map_zip = $sourcefile.'/'.$cat[0]['slug'].'.zip';
								if(file_exists($map_zip)){
									echo'<a href="'.base_url().$map_zip.'" class="btn btn-default btn-sm">Package</a>';
								}
							} 
						} 
					?>
<?php }?>
				</div>
			</div>
			<div class="portlet-body row">
				<?php $order_details = $this->db->query("SELECT * FROM `orders` WHERE `id`='".$order_id."'")->result_array();?>	
				<?php echo '<h4 style="color:#900;">'.$this->session->flashdata('file_message').'</h4>'; ?>
				<div class="scroller" style="height:200px" data-always-visible="1" data-rail-visible="0">
				<div class="row no-space">									
					<div class="col-md-6 col-sm-6 col-xs-12 margin-bottom-15">	
					  <div class="row no-space border-dashed">
							<div class="col-md-4 col-sm-3 col-xs-4 no-space">	
								<img class="padding-6" src="<?php echo base_url();?>assets/new_designer/img/indd.jpg" alt="indd" width="100%">
							</div>
							<?php if($order_details[0]['order_type_id'] == '1') { ?>
							<div class="col-md-8 col-sm-9 col-xs-8 no-space">	
								<form action="<?php echo base_url().index_page().'new_designer/home/new_fileuploads/'.$order_id; ?>"  id="dropzonepsd" class="dropzone" method="post">
									<input type="hidden" name="slug_name" id="slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $cat[0]['slug'];  ?>">
									<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="psd">
									<div class="dz-default dz-message margin-top-20">
										<span>PSD File</span>
									</div>
								</form>
							</div>
							<?php } else { ?>
							<div class="col-md-8 col-sm-9 col-xs-8 no-space">	
								<form action="<?php echo base_url().index_page().'new_designer/home/new_fileuploads/'.$order_id; ?>"  id="dropzoneindd" class="dropzone" method="post">
									<input type="hidden" name="slug_name" id="slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $cat[0]['slug'];  ?>">
									<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="indd">
									<div class="dz-default dz-message margin-top-20">
										<span>Indesign File</span>
									</div>
								</form>
							</div>
							<?php } ?>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12 margin-bottom-15">	
					  <div class="row no-space border-dashed">
							<div class="col-md-4 col-sm-3 col-xs-4 no-space">	
								<img class="padding-6" src="<?php echo base_url();?>assets/new_designer/img/pdf.jpg" alt="pdf" width="100%">
							</div>	
							<?php if($order_details[0]['order_type_id'] == '1') { ?>
							<div class="col-md-8 col-sm-9 col-xs-8 no-space">	
								<form action="<?php echo base_url().index_page().'new_designer/home/new_fileuploads/'.$order_id; ?>"   id="dropzoneimages" class="dropzone" method="post">
									<input type="hidden" name="slug_name" id="slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $cat[0]['slug'];?>">
									<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="images">
									<div class="dz-default dz-message margin-top-20">
										<span>Image File</span>
									</div>
								</form>
							</div>	
							<?php } else { ?>
							<div class="col-md-8 col-sm-9 col-xs-8 no-space">	
								<form action="<?php echo base_url().index_page().'new_designer/home/new_fileuploads/'.$order_id; ?>"   id="dropzonepdf" class="dropzone" method="post">
									<input type="hidden" name="slug_name" id="slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $cat[0]['slug'];?>">
									<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="pdf">
									<div class="dz-default dz-message margin-top-20">
										<span>PDF5 File</span>
									</div>
								</form>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
						
				<div class="row no-space">
					<div class="col-xs-6 margin-bottom-15">	
					  <div class="row no-space border-dashed" id="links">
							<div class="col-md-12 col-sm-12 col-xs12 no-space">	
								<form action="<?php echo base_url().index_page().'new_designer/home/new_fileuploads/'.$order_id; ?>"   id="dropzone" class="dropzone" method="post">
									<input type="hidden" name="slug_name" id="slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $cat[0]['slug'];?>">
									<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="links">
									<div class="dz-default dz-message margin-top-20 margin-bottom-20">
										<span>Links File</span>
									</div>
								</form>
							</div>	
						</div>
					</div>
					<div class="col-xs-6 margin-bottom-15">	
					  <div class="row no-space border-dashed" id="fonts">
							<div class="col-md-12 col-sm-12 col-xs12 no-space">	
								<form action="<?php echo base_url().index_page().'new_designer/home/new_fileuploads/'.$order_id; ?>"   id="dropzone" class="dropzone" method="post">
									<input type="hidden" name="slug_name" id="slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $cat[0]['slug'];?>">
									<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="fonts">
									<div class="dz-default dz-message margin-top-20 margin-bottom-20">
										<span>Fonts File</span>
									</div>
								</form>
							</div>	
						</div>
					</div>
				</div>
			</div>	 
				<div class="col-md-12 margin-top-10">
					<div class="row">
					<div class="col-md-6">
						<p class="no-margin margin-bottom-10">
						<?php $help_desk1 = $this->db->query("SELECT * FROM `help_desk` WHERE `id` = '".$cat[0]['help_desk']."' AND `sold` = '1'")->result_array();
							if($help_desk1) { ?>
						<input id="Links_File" type="checkbox">Upload Sold 
						<div class="row no-space border-dashed" id="links1" style="display:none;">
							<div class="col-md-12 col-sm-12 col-xs12 no-space">	
								<form action="<?php echo base_url().index_page().'new_designer/home/newsold_pdf_upload/'.$order_id; ?>"   id="dropzonesoldpdf" class="dropzone" method="post">
									<input type="hidden" name="slug_name" id="sold_slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $cat[0]['slug'].'_sold';?>">
									<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="pdf">
									<div class="dz-default dz-message margin-top-20">
										<span>PDF File</span>
									</div>
								</form>
							</div>	
						</div>
						<small class="font-red font-xs">(Slug name)</small>
						<span class="word-break"><?php echo $cat[0]['slug'].'_sold';  ?></span><br><?php } ?>
					</div>
					
						<div class="col-md-6 text-right">
							<form method="POST">
								<?php if($cat[0]['pro_status']=='7') { ?>
								<input type="text" name="changes_csr" value="<?php  echo $cat[0]['pro_status']; ?>" style="display:none;">
								<?php } ?>
								<input type="text" name="slug" value="<?php  echo $cat[0]['slug']; ?>" style="display:none">
								<input type="text" name="sourcefile" value="<?php  echo $sourcefile; ?>" style="display:none;">
								<button type="submit" name="sourceUpload" class="btn blue">Complete</button>
							</form>
						</div>
					</div>
				</div>
				<?php $idml_pub = $this->db->query("SELECT * FROM `publications` WHERE `id` = '".$cat[0]['publication_id']."' AND `idml` = '1'")->result_array();
					if(isset($idml_pub[0]['id'])) { ?>
				<div class="col-md-12 margin-top-10">
					<div class="row">
						<div class="col-md-6">	
							<p class="no-margin margin-bottom-10">
								<input id="idml_File" type="checkbox">Upload idml 
							<div class="row no-space border-dashed" id="idml1" style="display:none;">
								<div class="col-md-12 col-sm-12 col-xs12 no-space">	
									<form action="<?php echo base_url().index_page().'new_designer/home/idml_upload/'.$order_id; ?>"   id="dropzoneidml" class="dropzone" method="post">
										<input type="hidden" name="slug_name" id="idml_slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $cat[0]['slug'];?>">
										<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="idml">
										<div class="dz-default dz-message margin-top-20">
											<span>IDML File</span>
										</div>
									</form>
								</div>	
							</div>
							<small class="font-red font-xs">(Slug name)</small>
							<span class="word-break"><?php echo $cat[0]['slug'];  ?></span><br>
						</div>
					</div>
				</div>
				<?php } ?>
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
<!------ Production Status 8 for designer_role 1,2 Ends   ------->

	
					<!-----------------------------------New Ad orderview ends --------------------------------------------->
<?php }elseif(isset($rev_orders)) { ?>

					<!-----------------------------------Revision Ad orderview starts--------------------------------------->
<div class="row margin-top-10">
	<div class="col-md-12">
<?php $count = count($rev_orders); $prev=$count-1; $i=0; foreach($rev_orders as $rev_row){ $i++; ?>	
<!----START: Status1 ----->	
<?php if($rev_row['pdf_path'] == 'none') { ?>			
<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
			<div class="portlet-title  margin-top-10">
				<div class="row static-info">
					<div class="col-md-8 value">Revision #<?php echo $order_id ;?> <?php echo $rev_row['version']; ?><small> &nbsp; (<?php echo $rev_row['date']; ?>)</small></div>
					<?php if(($rev_row['status']=='3') && ($designer_alias[0]['designer_role'] == '1' || $designer_alias[0]['designer_role'] == '2') ) { ?>
							<div class="col-md-2 pull-right">
								<form method="post">
									<input type="text" name="rev_id" value="<?php echo $rev_row['id']; ?>" style ="display:none;">
									<button class="btn btn-default btn-sm btn-block" type="submit" name="reassign">Reassign</button>
								</form>
							</div>
					<?php } ?>
							<div class="col-md-2">
								<?php echo $this->session->flashdata('message'); ?>
							</div>
					<?php if($rev_row['status'] == '4' && $rev_row['status'] != '7' && $rev_row['source_file']!='none' && $rev_row['pdf_file']!='none'){ ?>
						<div class="col-md-4">
							<div class="row">
								<?php  if(isset($sourcefile) && $rev_row['source_file']!='none' && $rev_row['pdf_file']!='none'){ 
								//PDF File View & Download
								$map1 = $sourcefile.'/'.$rev_row['pdf_file'];
								if(file_exists($map1)){									
								?>
								<div class="col-xs-4 padding-0 pull-right">
									<a class="btn btn-default btn-sm btn-block" href="<?php echo base_url()?><?php echo $map1 ;?>" target="_blank">PDF</a>
								</div>
								<?php } ?>
								<?php //zip source
										$source_file = $rev_row['source_file'];
										$map2 = $sourcefile.'/'.$source_file;
										if(file_exists($map2)){		
								?>
								<div class="col-md-4 padding-0 pull-right">
									<form action="<?php echo base_url().'index.php/new_designer/home/zip_folder_select'?>" method="post">
										<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
										<input name="pdf_file" value="<?php echo $rev_row['pdf_file'];?>" readonly style="display:none;" />
										<input name="new_slug" value="<?php echo $rev_row['new_slug'];?>" readonly style="display:none;" />
										<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
										<input name="download" value="download" readonly style="display:none;" />
										<button type="submit" name="SourceDownload" class="btn btn-default btn-sm btn-block">Package</button>
									</form>
								</div>
								<?php } } ?>	
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
			<div class="portlet-body">
				<div class="row">
					<div class="col-md-6 col-sm-12">
						<div class="portlet blue-hoki box">
							<div class="portlet-title">
								<div class="caption">Instructions</div>
							</div>
							<div class="portlet-body">
								<div class="row static-info">
									<div class="col-md-12 margin-top-20 margin-bottom-10"> <?php $rev_row['note'] = str_replace(PHP_EOL,'<br/>', $rev_row['note']); 
										echo $rev_row['note'];?>
									</div>
								</div>
							</div>				
						</div>
					</div>	
					<div class="col-md-6 col-sm-12">
						<div class="portlet blue-hoki box">
							<div class="portlet-title">
								<div class="caption">Downloads</div>
									<div class="tools">
										<?php if($rev_row['file_path']!='none') { $filepath = $rev_row['file_path']; ?>
											<form method="post" action="<?php echo base_url().index_page().'new_designer/home/zip_folder';?>">
											<input name="file_path" value="<?php echo $filepath; ?>" readonly style="display:none;" /> 
											<input name="file_name" value="<?php echo $rev_row['order_id']; ?>" readonly style="display:none;" />
											<button type="submit" name="Submit" class="btn bg-blue-hoki btn-xs"><i class="fa fa-cloud-download"></i></button>
											</form>
										<?php } ?>
									</div>
							</div>
							<div class="portlet-body">
								<table class="table table-scrollable table-striped table-hover">
									<tbody>
									<?php 
										if($rev_row['file_path'] != 'none'){ 
											$filepath = $rev_row['file_path'];
											$this->load->helper('directory');
											$map = glob($filepath.'/*',GLOB_BRACE);
											if($map){ foreach($map as $row1){
									?>
										<tr>
											<td><?php echo basename($row1) ?></td>
											<td class="text-right">
												<a href="<?php echo base_url().$row1; ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
												<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row1; ?>" class="font-grey-gallery"><i class="fa fa-cloud-download"></i></a></span>							
											</td> 		  
										</tr>  
							<?php } } } ?> 
									</tbody> 
								</table>
							</div>				
						</div>
					</div>
					<?php if(($rev_row['new_slug'] == 'none') && ($designer_alias[0]['designer_role'] == '1' || $designer_alias[0]['designer_role'] == '3') ){ ?>
					<div class="col-md-12">
						<form name="myform" method="post" >
							<button type="submit" name="create_slug" class="btn bg-green">Create Slug</button>
							<input name="id" value="<?php echo $rev_row['id'];?>" readonly style="display:none;" />
							<input name="order_id" value="<?php echo $rev_row['order_id'];?>" readonly style="display:none;" />
							<input name="prev_slug" value="<?php echo $rev_row['order_no'];?>" readonly style="display:none;" />
							<input name="version" value="<?php echo $rev_row['version'];?>" readonly style="display:none;" />
						</form>
					</div>
					<?php } ?>
				</div>	
			</div>
		</div>
	</div>
</div>
<?php } ?>	
<!----- END: Status1 ----->



<?php if(($rev_row['status'] < '4') && ($rev_row['new_slug'] != 'none') && ($rev_row['designer'] == $this->session->userdata('dId')) && ($rev_row['category'] != 'sold')){ ?>
	
			<div class="row">
				<!--- Start : File Upload --->
				<div class="col-md-6">
					<div class="portlet light">
					 <div class="portlet-title">
						<div class="row">
							<div class="static-info col-md-8">    
								<span class="word-break"><?php echo $rev_row['new_slug']; ?></span><br>
								<small class="font-red font-xs">(Copy this slug &amp; paste it into the design document)</small>
							</div>
							<div class="col-md-4 margin-top-5 text-right">
								<?php if(isset($sourcefile)) { 
									$map2 = glob($sourcefile.'/'.$rev_row['new_slug'].'.{zip}',GLOB_BRACE); 
									if($map2){ foreach($map2 as $row_map2){ $source_file = basename($row_map2); } ?>
										<form action="<?php echo base_url().'index.php/new_designer/home/zip_folder_select'?>" method="post">
											<input name="source_file" value="<?php echo $source_file;?>" readonly="" class="hidden" />
											<input name="pdf_file" value="<?php echo $rev_row['pdf_file'];?>" readonly="" class="hidden" />
											<input name="new_slug" value="<?php echo $rev_row['new_slug'];?>" readonly="" class="hidden" />
											<input name="source_path" value="<?php echo $sourcefile;?>" readonly="" class="hidden" />
											<input name="download" value="download" readonly="" class="hidden" />
											<button type="submit" name="SourceDownload" class="btn btn-default btn-sm">Package</button>
										</form>
								<?php } } ?>
							</div>
						</div>
					</div>
					<div class="portlet-body margin-top-10" id="upload">
					<?php echo '<h4 style="color:#900;">'.$this->session->flashdata('file_message').'</h4>'; ?>
						<div class="scroller" style="height:200px" data-always-visible="1" data-rail-visible="0">
							<div class="row">									
								<div class="col-md-6 col-sm-6 col-xs-12 margin-bottom-15">	
								  <div class="row no-space border-dashed">
										<div class="col-md-4 col-sm-3 col-xs-4 no-space">	
											<img class="padding-6" src="assets/new_designer/img/indd.jpg" alt="indd" width="100%">
										</div>	
										<?php if($orders[0]['order_type_id']=='1'){ ?>
										<div class="col-md-8 col-sm-9 col-xs-8 no-space">	
											<form action="<?php echo base_url().index_page().'new_designer/home/rev_new_fileuploads/'.$order_id; ?>"  id="dropzonepsd" class="dropzone" method="post">
												<input type="hidden" name="slug_name" id="slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $rev_row['new_slug'];  ?>">
												<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="psd">
												<input type="text" name="rev_id" value="<?php  echo $rev_row['id']; ?>" style="display:none;">
												<input type="hidden" name="cat_slug" class="form-control margin-bottom-15" value="<?php echo $cat[0]['slug']; ?>">
												<div class="dz-default dz-message margin-top-20">
													<span>PSD File</span>
												</div>
											</form>
										</div>
										<?php } else{ ?>
										<div class="col-md-8 col-sm-9 col-xs-8 no-space">	
											<form action="<?php echo base_url().index_page().'new_designer/home/rev_new_fileuploads/'.$order_id; ?>"  id="dropzoneindd" class="dropzone" method="post">
												<input type="hidden" name="slug_name" id="slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $rev_row['new_slug'];  ?>">
												<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="indd">
												<input type="text" name="rev_id" value="<?php  echo $rev_row['id']; ?>" style="display:none;">
												<input type="hidden" name="cat_slug" class="form-control margin-bottom-15" value="<?php echo $cat[0]['slug']; ?>">
												<div class="dz-default dz-message margin-top-20">
													<span>Indesign File</span>
												</div>
											</form>
										</div>
										<?php } ?>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12 margin-bottom-15">	
								  <div class="row no-space border-dashed">
										<div class="col-md-4 col-sm-3 col-xs-4 no-space">	
											<img class="padding-6" src="assets/new_designer/img/pdf.jpg" alt="indd" width="100%">
										</div>	
										<?php if($orders[0]['order_type_id']=='1'){ ?>
										<div class="col-md-8 col-sm-9 col-xs-8 no-space">	
											<form action="<?php echo base_url().index_page().'new_designer/home/rev_new_fileuploads/'.$order_id; ?>"   id="dropzoneimages" class="dropzone" method="post">
												<input type="hidden" name="slug_name" id="slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $rev_row['new_slug'];?>">
												<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="images">
												<input type="text" name="rev_id" value="<?php  echo $rev_row['id']; ?>" style="display:none;">
												<input type="hidden" name="cat_slug" class="form-control margin-bottom-15" value="<?php echo $cat[0]['slug']; ?>">
												<div class="dz-default dz-message margin-top-20">
													<span>Image File</span>
												</div>
											</form>
										</div>
										<?php } else{ ?>
										<div class="col-md-8 col-sm-9 col-xs-8 no-space">	
											<form action="<?php echo base_url().index_page().'new_designer/home/rev_new_fileuploads/'.$order_id; ?>"   id="dropzonepdf" class="dropzone" method="post">
												<input type="hidden" name="slug_name" id="slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $rev_row['new_slug'];?>">
												<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="pdf">
												<input type="text" name="rev_id" value="<?php  echo $rev_row['id']; ?>" style="display:none;">
												<input type="hidden" name="cat_slug" class="form-control margin-bottom-15" value="<?php echo $cat[0]['slug']; ?>">
												<div class="dz-default dz-message margin-top-20">
													<span>PDF File</span>
												</div>
											</form>
										</div>	
										<?php } ?>
									</div>
								</div>
							</div>
									
							<div class="row">
								<div class="col-xs-6 margin-bottom-15">	
								  <div class="row no-space border-dashed" id="links">
										<div class="col-md-12 col-sm-12 col-xs12 no-space">	
											<form action="<?php echo base_url().index_page().'new_designer/home/rev_new_fileuploads/'.$order_id; ?>"   id="dropzone" class="dropzone" method="post">
												<input type="hidden" name="slug_name" id="slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $rev_row['new_slug'];?>">
												<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="links">
												<input type="hidden" name="cat_slug" class="form-control margin-bottom-15" value="<?php echo $cat[0]['slug']; ?>">
												<div class="dz-default dz-message margin-top-20 margin-bottom-20">
													<span>Links File</span>
												</div>
											</form>
										</div>	
									</div>
								</div>
								<div class="col-xs-6 margin-bottom-15">	
								  <div class="row no-space border-dashed" id="fonts">
										<div class="col-md-12 col-sm-12 col-xs12 no-space">	
											<form action="<?php echo base_url().index_page().'new_designer/home/rev_new_fileuploads/'.$order_id; ?>"   id="dropzone" class="dropzone" method="post">
												<input type="hidden" name="slug_name" id="slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $rev_row['new_slug'];?>">
												<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="fonts">
												<input type="hidden" name="cat_slug" class="form-control margin-bottom-15" value="<?php echo $cat[0]['slug']; ?>">
												<div class="dz-default dz-message margin-top-20 margin-bottom-20">
													<span>Fonts File</span>
												</div>
											</form>
										</div>	
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 margin-top-5 text-center">
								<form method="post">
									<input type="text"  name="slug" value="<?php echo $rev_row['new_slug']; ?>" readonly style="display:none;" >
									<button name="rev_file_submit"  type="submit" class="btn btn-success btn-sm">Refresh Folder structure</button>
								</form> 
								<!--<button class="btn btn-success btn-sm" id="show_folder">Refresh Folder structure</button>-->
							</div>
							<div class="col-md-12">
								<?php	if(isset($sourcefile)){
										$this->load->helper('directory');
										$map_dir = glob($sourcefile.'/'.$rev_row['new_slug'].'.{indd,pdf,psd,ai,jpg,gif,png}',GLOB_BRACE);	
										//$map = directory_map($sourcefile.'/');
										if($map_dir){
											$map_links = directory_map($sourcefile.'/Links/');	
											$map_fonts = directory_map($sourcefile.'/Document fonts/');
								?>	
									<div class="portlet-body text-center">					
										<div id="tree_1" class="tree-demo margin-bottom-30 text-left wrap">
											<ul>
												<li data-jstree='{ "opened" : true }'>
													<?php echo $order_id; ?>
													<ul>
														<?php foreach($map_dir as $files){ ?>
															<li data-jstree='{ "type" : "file" }'>
																<a href="<?php echo base_url()?>download.php?file_source=<?php echo $files; ?>" class="btn btn-circle btn-xs">
																	<?php echo basename($files); ?>
																</a>
															</li>
														<?php } ?>
														<li>Links &nbsp; <span class="badge bg-red"><?php echo count($map_links); ?></span>
															<ul>
																<?php if($map_links)foreach($map_links as $link_files){ ?>
																<li data-jstree='{ "type" : "file" }'>
																<a href="#"><?php echo basename($link_files); ?> </a></li><?php } ?>
															</ul>
														</li>	
														<li>Fonts &nbsp; <span class="badge bg-red"><?php echo count($map_fonts); ?></span>
															<ul>
																<?php if($map_fonts)foreach($map_fonts as $font_files){ ?>
																<li data-jstree='{ "type" : "file" }'>
																<a href="#"><?php echo basename($font_files); ?> </a></li><?php } ?>
															</ul>
														</li>
													</ul>
												</li>
											</ul>
										 </div>
									</div>
								<?php } } ?>
							</div>
						</div>
					</div>
				</div>
				</div>
				<!--- End : File Upload --->

				<!--- Start : Conversation --->					
					<div class="col-md-6">
						<div class="portlet light">
							<div class="portlet-title">
								<div class="row static-info margin-top-10">
									<div class="col-md-10">Conversations</div>
								</div>
							</div>
							<div class="row portlet-body">
								<div class="col-md-12 col-sm-12">
								  <div class="scroller" style="height:230px" data-always-visible="1" data-rail-visible="0">
								  <?php
									$qustion = $this->db->query("SELECT * FROM `production_conversation` WHERE  `revision_id`='".$rev_row['id']."' order by `id` desc")->result_array(); 
									if(isset($sourcefile)){
									$csr_path = $sourcefile.'/csr_change_'.$rev_row['id']; }
									if(!isset($qustion[0]['id'])){
										echo '<p class="text-center">'."No Conversations".'</p>';
									}
									if($qustion) { $i=0; foreach($qustion as $qustion1) { $i++; 
												
								?>
								<?php if(($qustion1['revision_id']!='0' && $qustion1['csr_id']!='0') && ($qustion1['operation']=='revcsr_designer')) { 
											$csr = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$qustion1['csr_id']."'")->result_array();   
									?>
									<div <?php if($i=='1'){ echo'class="note note-info"'; }else{ echo 'class="note note-grey"'; } ?>>
										<h4><?php  echo $csr[0]['name'];  ?> (CSR)</h4>
										<div class="row">
											<div class="col-sm-6">
												<?php echo $qustion1['message']; ?>
												<?php if(isset($csr_path)){ 
													$map_csr_path = glob($csr_path.'/*.{jpg,png,tiff,gif,html,pdf,indd}',GLOB_BRACE);								
													if($map_csr_path){			
														foreach($map_csr_path as $row_csr_path){  
											 ?>
												<p>Attached File -  <?php echo basename($row_csr_path) ?>
													<a href="<?php echo base_url()?><?php echo $row_csr_path ?>" target="_Blank" class="btn btn-circle btn-xs"><i class="fa fa-eye"></i></a>
													<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row_csr_path; ?>" class="btn btn-circle btn-xs"><i class="fa fa-cloud-download"></i></a>
												</p>
											<?php } } } ?>
											</div>
											<div class="col-sm-6 text-right">
												<span class="font-grey-cascade small"> at - <?php echo $qustion1['time']; ?> </span>
											</div>
										</div>
									</div>
								<?php } ?>
								<?php if(($qustion1['revision_id']!='0' && $qustion1['designer_id']!='0') && ($qustion1['operation']=='revdesigner_QA')) { 
											$designer = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$qustion1['designer_id']."'")->result_array();?>
									<div <?php if($i=='1'){ echo'class="note note-info"'; }else{ echo 'class="note note-grey"'; } ?>>
										<h4><?php echo $designer[0]['name'] ;?> (Designer)</h4>
										<div class="row">
											<div class="col-sm-6">
												<?php echo $qustion1['message']; ?>
											</div>
											<div class="col-sm-6 text-right">
												<span class="font-grey-cascade small"> at - <?php echo $qustion1['time']; ?></span>
											</div>
										</div>
									</div>
								<?php } } } ?>
								  </div>	
								</div>
							</div>
						</div>
					</div>
				<!--- End : Conversation --->
	
				
				 <!--- Start : End Design --->						
					<div class="col-md-12 text-center">
						<div class="portlet light">
							<div class="portlet-body no-space">
								<p class="margin-top-10 font-red">Check your folder & make sure everything is Uploloaded!</p>
									<div class="col-md-12">
										<div class="row">
										<?php $help_desk1 = $this->db->query("SELECT * FROM `help_desk` WHERE `id` = '".$rev_row['help_desk']."' AND `sold` = '1'")->result_array();
													if($help_desk1) { ?>
							 				<div class="col-md-2">
												<p class="no-margin margin-bottom-10">
													<input id="Links_File" type="checkbox">Upload Sold
												<div class="row no-space border-dashed" id="links1" style="display:none;">
													<div class="col-md-12 col-sm-12 col-xs12 no-space" id="upload">	
														<form action="<?php echo base_url().index_page().'new_designer/home/revsold_pdf_upload/'.$order_id; ?>"  class="dropzone" id="dropzonesoldpdf" method="post">
															<input type="hidden" name="slug_name" id="sold_slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $rev_row['new_slug'].'_sold';?>">
															<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="pdf">
															<input type="text" name="rev_id" value="<?php  echo $rev_row['id']; ?>" style="display:none;">
															<input type="hidden" name="cat_slug" class="form-control margin-bottom-15" value="<?php echo $cat[0]['slug']; ?>">
															<div class="dz-default dz-message margin-top-30 margin-bottom-30">
																<span>PDF File</span>
															</div>
														</form>
													</div>
												</div></br>
												<small class="font-red font-xs">(Slug name)</small>
												<span class="word-break"><?php echo $rev_row['new_slug'].'_sold'; ?></span><br>
											</div><?php } ?>
											<?php $idml_pub = $this->db->query("SELECT * FROM `publications` WHERE `id` = '".$cat[0]['publication_id']."' AND `idml` = '1'")->result_array();
												if($idml_pub) { ?>	
											<div class="col-md-2">
												<p class="no-margin margin-bottom-10">
													<input id="idml_File" type="checkbox">Upload idml 
												<div class="row no-space border-dashed" id="idml1" style="display:none;">
													<div class="col-md-12 col-sm-12 col-xs12 no-space">	
														<form action="<?php echo base_url().index_page().'new_designer/home/idml_rev_upload/'.$order_id; ?>"   id="dropzoneidml" class="dropzone" method="post">
															<input type="hidden" name="slug_name" id="idml_slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $rev_row['new_slug'];?>">
															<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="idml">
															<input type="text" name="rev_id" value="<?php  echo $rev_row['id']; ?>" style="display:none;">
															<input type="hidden" name="cat_slug" class="form-control margin-bottom-15" value="<?php echo $cat[0]['slug']; ?>">
															<div class="dz-default dz-message margin-top-30 margin-bottom-30">
																<span>IDML File</span>
															</div>
														</form>
													</div>	
												</div>
												<small class="font-red font-xs">(Slug name)</small>
												<span class="word-break"><?php echo $rev_row['new_slug'];  ?></span><br>
											</div><?php } ?>
											<form method="POST">
											<div class="col-md-2">
												<input id="show_adrep_note" type="checkbox" >Note to Adrep
												<textarea name="adrep_note" rows="3" id="adrep_note" class="form-control margin-top-10"></textarea>
											</div>
											
											<div class="col-md-2 col-md-offset-1 text-left">
												<div class="checkbox-list">
													<?php $rev_order_reason = $this->db->query("SELECT * FROM `rev_reason`")->result_array(); foreach($rev_order_reason as $reason_row) {  ?>
													<label>	
														<?php if($rev_row['version'] == 'V1a') { ?>
														<input name="rev_csr_id" value="<?php echo $cat[0]['csr_QA'];?>" readonly style="display:none;" />
														<input name="rev_designer_id" value="<?php echo $cat[0]['designer'];?>" readonly style="display:none;" />
														<?php }else{ ?>
														<input name="rev_csr_id" value="<?php if($prev_rev_orders) echo $prev_rev_orders[0]['rov_csr'];?>" readonly style="display:none;" />
														<input name="rev_designer_id" value="<?php if($prev_rev_orders) echo $prev_rev_orders[0]['designer'];?>" readonly style="display:none;" />
														<?php } ?>
														<input name="prev_rev_id" value="<?php if($prev_rev_orders) echo $prev_rev_orders[0]['id'];?>" readonly style="display:none;" />
														<input type="checkbox" id="reason_check" name="revision_reason[]" value="<?php echo $reason_row['id'];?>" > <?php echo $reason_row['name'];?> 
														<input name="order_id" value="<?php echo $rev_row['order_id'];?>" readonly style="display:none;" />
													</label><?php } ?>
												</div>
											</div>
											
											<div class="col-md-3 text-left pull-right">
												<select class="form-control input-sm" id="csr" name="csr" required>
													<option value="">Select Checker</option>
													<?php foreach($csr as $result){ echo '<option value="'.$result['id'].'" >'.$result['name'].'</option>'; } ?>
												</select>
											</div>
										</div>
									</div>
								
								<p class="margin-top-15 margin-bottom-10">
									<!--send to adrep-->
									<input name="hd" value="<?php echo $hd; ?>" readonly style="display:none;" />
									<input name="new_slug" value="<?php echo $rev_row['new_slug'];?>" readonly style="display:none;" />
									<input name="adrep" value="<?php echo $rev_row['adrep'];?>" readonly style="display:none;" />
									<input name="source_file" value="<?php echo $rev_row['source_file'];?>" readonly style="display:none;" />
									<input name="pdf_file" value="<?php echo $rev_row['pdf_file'];?>" readonly style="display:none;" />
									<input name="source_path" value="<?php if(isset($sourcefile)) { echo $sourcefile;}?>" readonly style="display:none;" />
									<input name="archive" value="archive" readonly style="display:none;" />
									<input name="cat_slug" value="<?php echo $cat[0]['slug'];?>" readonly style="display:none;" />
									<input name="order_id" value="<?php echo $order_id;?>" readonly style="display:none;" />
									<!--send to adrep-->
									<input type="text" name="rev_id" value="<?php  echo $rev_row['id']; ?>" style="visibility:hidden">		
									<button type="submit" name="rev_complete" class="btn red" id="focusdiv" onclick="return warning_confirm()" onClick="complete(<?php echo $order_id; ?>)">	End Design </button>
								</p>
								</form>
							</div>
						</div>
					</div>
		        <!--- End : End Design --->
				
			</div>
<?php } ?>

<?php if($rev_row['status'] == '7' && $rev_row['pdf_path'] == 'none') { ?>

<!--- Start : File Upload --->
<div class="row">
	<div class="col-md-6">
	<div class="portlet light">
	 <div class="portlet-title">
		<div class="row">
			<div class=" static-info col-md-8">    
				<?php echo $rev_row['version'] ;?>
			</div>
			<?php if(isset($sourcefile)) { 
					$map2 = glob($sourcefile.'/'.$rev_row['new_slug'].'.{indd,psd}',GLOB_BRACE); 
						if($map2){ 
						foreach($map2 as $row_map2){ $source_file = basename($row_map2); } ?>
			<div class="col-md-4 margin-top-5 text-right">
				<form action="<?php echo base_url().'index.php/new_designer/home/zip_folder_select'?>" method="post">
					<input name="source_file" value="<?php echo $source_file;?>" readonly="" class="hidden" />
					<input name="pdf_file" value="<?php echo $rev_row['pdf_file'];?>" readonly="" class="hidden" />
					<input name="new_slug" value="<?php echo $rev_row['new_slug'];?>" readonly="" class="hidden" />
					<input name="source_path" value="<?php echo $sourcefile;?>" readonly="" class="hidden" />
					<input name="download" value="download" readonly="" class="hidden" />
					<button type="submit" name="SourceDownload" class="btn btn-default btn-sm">Package</button>
				</form>
			</div>
			<?php } } ?>
		</div>
	</div>
	<div class="portlet-body margin-top-10" id="upload">
		<div class="row">
			<div class="col-xs-12 margin-top-30 text-center">
				<div class="scroller" style="height:160px" data-always-visible="1" data-rail-visible="0">
				<?php if(isset($sourcefile)) {
					if($rev_row['designer'] == $this->session->userdata('dId') || $designer_alias[0]['designer_role'] == '1' || $designer_alias[0]['designer_role'] == '2') { 
				?>
					<p class="margin-top-10 font-red margin-top-30">Please download package before click</p>
					<form method="post">
					<?php 
						//zip source
							$map2 = glob($sourcefile.'/'.$rev_row['new_slug'].'.{indd,psd}',GLOB_BRACE); 
								if($map2){ 
								foreach($map2 as $row_map2){ $source_file = basename($row_map2); }	
							?>
						<button type="submit" name="csr_changes" class="btn btn-danger btn-sm">Make Changes</button>
						<input name="source_file" value="<?php echo $source_file;?>" readonly="" class="hidden" />
						<input name="order_id" value="<?php echo $order_id;?>" readonly style="display:none;" />
						<input name="sold_pdf_path" value="<?php echo $rev_row['sold_pdf'];?>" readonly style="display:none;" />
						<input name="rev_id" value="<?php echo $rev_row['id'];?>" readonly style="display:none;" />
						<input name="pdf_file" value="<?php echo $rev_row['pdf_file'];?>" readonly="" class="hidden" />
						<input name="new_slug" value="<?php echo $rev_row['new_slug'];?>" readonly="" class="hidden" />
						<input name="source_path" value="<?php echo $sourcefile;?>" readonly="" class="hidden" />
						<input name="archive" value="archive" readonly style="display:none;" />
					<?php }  ?>
					</form>
				<?php } } ?>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

<!--- End : File Upload --->
<!--- Start : Conversation --->					

	<div class="col-md-6">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="row static-info  margin-top-10">
					<div class="col-md-10">Conversations</div>
				</div>
			</div>
			<div class="row portlet-body">
				<div class="col-md-12 col-sm-12">
				  <div class="scroller" style="height:185px" data-always-visible="1" data-rail-visible="0">
						 <?php
						$qustion = $this->db->query("SELECT * FROM `production_conversation` WHERE  `revision_id`='".$rev_row['id']."' order by `id` desc")->result_array(); 
						if(isset($sourcefile)){
						$csr_path = $sourcefile.'/csr_change_'.$rev_row['id']; }
						if(!isset($qustion[0]['id'])){
							echo '<p class="text-center">'."No Conversations".'</p>';
						}
						if($qustion) { $i=0; foreach($qustion as $qustion1) { $i++; 
									
					?>
					<?php if(($qustion1['revision_id']!='0' && $qustion1['csr_id']!='0') && ($qustion1['operation']=='revcsr_designer')) { 
								$csr = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$qustion1['csr_id']."'")->result_array();   
						?>
						<div <?php if($i=='1'){ echo'class="note note-info"'; }else{ echo 'class="note note-grey"'; } ?>>
							<h4><?php  echo $csr[0]['name'];  ?> (CSR)</h4>
							<div class="row">
								<div class="col-sm-6">
									<?php echo $qustion1['message']; ?>
									<?php if(isset($csr_path)){ 
										$map_csr_path = glob($csr_path.'/*.{jpg,png,tiff,gif,html,pdf,indd}',GLOB_BRACE);								
										if($map_csr_path){			
											foreach($map_csr_path as $row_csr_path){  
								 ?>
									<p>Attached File -  <?php echo basename($row_csr_path) ?>
										<a href="<?php echo base_url()?><?php echo $row_csr_path ?>" target="_Blank" class="btn btn-circle btn-xs"><i class="fa fa-eye"></i></a>
										<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row_csr_path; ?>" class="btn btn-circle btn-xs"><i class="fa fa-cloud-download"></i></a>
									</p>
								<?php } } } ?>
								</div>
								<div class="col-sm-6 text-right">
									<span class="font-grey-cascade small"> at - <?php echo $qustion1['time']; ?> </span>
								</div>
							</div>
						</div>
					<?php } ?>
					<?php if(($qustion1['revision_id']!='0' && $qustion1['designer_id']!='0') && ($qustion1['operation']=='revdesigner_QA')) { 
								$designer = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$qustion1['designer_id']."'")->result_array();?>
						<div <?php if($i=='1'){ echo'class="note note-info"'; }else{ echo 'class="note note-grey"'; } ?>>
							<h4><?php echo $designer[0]['name'] ;?> (Designer)</h4>
							<div class="row">
								<div class="col-sm-6">
									<?php echo $qustion1['message']; ?>
								</div>
								<div class="col-sm-6 text-right">
									<span class="font-grey-cascade small"> at - <?php echo $qustion1['time']; ?></span>
								</div>
							</div>
						</div>
					<?php } } } ?>
				  </div>	
				</div>
			</div>
		</div>
	</div>
</div>
<!--- End : Conversation  --->
<?php } ?>

<?php if($rev_row['pdf_file'] != 'none' && ($rev_row['status'] == '5' || $rev_row['status'] == '7' || $rev_row['status'] == '8')) {
			if(isset($sourcefile)){
			$pdf_path = $sourcefile.'/'.$rev_row['pdf_file'];
			$source_zip_path = $sourcefile.'/'.$rev_row['new_slug'].'.zip';} ?>
			
<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
			<div class="portlet-title  margin-top-10">
				<div class="row static-info">
					<div class="col-md-8 value">Order #<?php echo $order_id.' '.$rev_row['version']; ?></div>
					<div class="col-md-4 text-right">
						<div class="row">
							<?php if(isset($sourcefile)){ 
							if(isset($pdf_path) && file_exists($pdf_path)){ ?>
							<div class="col-xs-4 padding-0 pull-right">
								<a class="btn btn-default btn-sm btn-block" href="<?php echo base_url().$pdf_path; ?>" target="_blank">PDF</a>
							</div>
							<?php }	if(isset($prev_rev_orders[0]['id']) && ($prev_rev_orders[0]['id']==$rev_row['id']) && (file_exists($source_zip_path))){ ?>
							
							<div class="col-md-4 padding-0 pull-right">
								<a href="<?php echo base_url()?><?php echo $source_zip_path ?>" class="btn btn-default btn-sm btn-block">Package</a>
							</div>	
							<?php } else { 
							
							//zip source
									if(isset($prev_rev_orders[0]['id']) && ($prev_rev_orders[0]['id']==$rev_row['id'])){
										$source_file = $rev_row['source_file'];
										$map2 = $sourcefile.'/'.$source_file;
										if(file_exists($map2)){
								?>
							<div class="col-md-4 padding-0 pull-right">
								<form action="<?php echo base_url().'index.php/new_designer/home/zip_folder_select'?>" method="post">
									<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
									<input name="pdf_file" value="<?php echo $rev_row['pdf_file'];?>" readonly style="display:none;" />
									<input name="new_slug" value="<?php echo $rev_row['new_slug'];?>" readonly style="display:none;" />
									<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
									<input name="download" value="download" readonly style="display:none;" />
									<button type="submit" name="SourceDownload" class="btn btn-default btn-sm btn-block">
									Package
									</button>
								</form>
							</div>
						<?php } } } ?>	
							<!--Downloads-->
							<?php if($rev_row['file_path'] != 'none') { $rev_order_form = $rev_row['file_path'];
									if(isset($rev_order_form) && file_exists($rev_order_form)) { 
									$rev_map = glob($rev_order_form.'/*',GLOB_BRACE);
									if($rev_map){ ?>
							<div class="col-md-4 pull-right margin-bottom-5">
								<form method="post" action="<?php echo base_url().index_page().'new_designer/home/zip_folder';?>">
									<input name="file_path" value="<?php echo $rev_order_form; ?>" readonly style="display:none;" /> 
									<input name="file_name" value="<?php echo $order_id; ?>" readonly style="display:none;" />
									<button type="submit" name="Submit" class="btn btn-default btn-sm btn-block">Download</button>
								</form>
							</div>
							<?php } } } ?>
							<!--Downloads-->
							<?php }elseif($cat[0]['ftp_source_path'] != 'none' && $cat[0]['ftp_source_path'] != ''){
									 if($rev_row['pdf_path']!='none' && file_exists($rev_row['pdf_path'])){ 
										if(isset($prev_rev_orders[0]['id']) && ($prev_rev_orders[0]['id']==$rev_row['id'])){ ?>
										<div class="col-xs-4 padding-0 pull-right">
											<a href="<?php echo $cat[0]['ftp_source_path']; ?>" class="btn btn-default btn-sm btn-block">Package</a>
										</div> <?php } ?>
										<div class="col-xs-4 padding-0 pull-right">
											<a class="btn btn-default btn-sm btn-block" href="<?php echo base_url().$rev_row['pdf_path']; ?>" target="_blank">PDF</a>
										</div>
									 <?php } }?>
						</div>
					</div>
					</div>
				</div>
		  </div>
	</div>
</div>	
<?php } ?>		

<?php } ?>

<!--- V1 files for all status Starts -->		
<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
			<div class="portlet-title  margin-top-10">
				<div class="row static-info">
					<div class="col-md-8 value">Order #<?php echo $order_id; ?> V1</div>
					<div class="col-md-4 text-right">
						<div class="row">
						<?php
						$from=date_create($orders[0]['created_on']);
						$to=date_create(date("Y-m-d"));
						$diff=date_diff($from,$to);
						$date_diff = $diff->format("%a");

						if($date_diff > $pub_name[0]['rev_days']) {
							if(file_exists($orders[0]['pdf']))  { ?>
						<div class="col-md-6 col-xs-6 pull-right ">
							<a href="<?php echo base_url().''.$orders[0]['pdf'];?>" target="_Blank" class="btn btn-block btn-default btn-sm">PDF</a>
						</div>
					<?php } } else {?>
							<?php if(isset($sourcefile) && isset($cat)){
								$this->load->helper('directory');
								//$map_zip = glob($sourcefile.'/'.$cat[0]['slug'].'.{zip}',GLOB_BRACE);
								$map2 = glob($sourcefile.'/'.$cat[0]['slug'].'.{indd,psd}',GLOB_BRACE);
								$map_pdf = glob($sourcefile.'/'.$cat[0]['slug'].'.{pdf,jpg,gif,png}',GLOB_BRACE);
								if($map_pdf){ foreach($map_pdf as $row){
							?>
							<div class="col-xs-4 padding-0 pull-right">
								<a class="btn btn-default btn-sm btn-block" href="<?php echo $row; ?>" target="_blank">PDF</a>
							</div>
						<?php } } 
							$source_zip_file = $sourcefile.'/'.$cat[0]['slug'].'.zip' ;
								if(!isset($prev_rev_orders1) && (file_exists($source_zip_file))){ ?>
							<div class="col-md-4 padding-0 pull-right">
								<a href="<?php echo base_url()?><?php echo $source_zip_file ?>" class="btn btn-default btn-sm btn-block">Package</a>
							</div>	
						<?php } else {
						if(!isset($prev_rev_orders1) && ($count=='1') && $rev_orders[0]['pdf_path']=='none' && $map2){
							//if($rev_orders[0]['pdf_path']=='none' && $map2){ 	
							foreach($map2 as $row_map2){
								$source_file = basename($row_map2);
							} ?>
							<div class="col-md-4 padding-0">
								<form action="<?php echo base_url().'index.php/new_designer/home/zip_folder_select'?>" method="post">
									<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
									<input name="new_slug" value="<?php echo $cat[0]['slug'];?>" readonly style="display:none;" />
									<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
									<input name="download" value="download" readonly style="display:none;" />
									<button type="submit" name="SourceDownload" class="btn btn-default btn-sm btn-block">
									Package</button>
								</form>
							</div>
							<?php } } }elseif($cat[0]['ftp_source_path'] != 'none' || $cat[0]['ftp_source_path'] != '') { ?>
								<?php if($cat[0]['pdf_path']!='none' && file_exists($cat[0]['pdf_path'])){ ?>
								<div class="col-md-3 pull-right margin-bottom-5">
									<a href="<?php echo base_url().''.$cat[0]['pdf_path'];?>" target="_Blank" class="btn btn-default btn-sm btn-block">PDF</a>
								</div>
								<?php } } ?>
							<?php if(isset($order_form) && file_exists($order_form)) { 
									$order_map = glob($order_form.'/*',GLOB_BRACE);
									if($order_map) { ?>
							<div class="col-md-4 padding-0 pull-right">
								<form method="post" action="<?php echo base_url().index_page().'new_designer/home/zip_folder';?>">
									<input name="file_path" value="<?php echo $order_form; ?>" readonly style="display:none;" /> 
									<input name="file_name" value="<?php echo $order_id; ?>" readonly style="display:none;" />
									<button type="submit" name="Submit" class="btn btn-default btn-sm btn-block">
										Downloads</i></button>
								</form>										
							</div>
							<?php } } ?>
						<?php }?>					
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--- V1 files for all status Starts -->	

	</div>
</div>
<?php } ?>
					<!-----------------------------------Revision Ad orderview ends----------------------------------------->




	
		</div>
	</div>
</div>

<?php $this->load->view('new_designer/foot')?>