<?php $this->load->view("new_csr/head.php"); ?>
<script>
  $(document).ready(function(){
  $("#show-text").hide();
  
  $("#open-text").click(function(){
  $("#show-text").toggle();     
   });
     
  });
</script>
<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<!-- BEGIN PAGE HEAD -->
	<div class="page-content">
		<div class="container"><?php echo $this->session->flashdata('message'); ?>
       <div class="row">
	   <?php foreach($orders as $row)  ?>
				<div class="col-md-12">
					<!-- Begin: life time stats -->
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-basket font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold uppercase">
								Order #<?php echo $row['id']; ?> </span> 
								
													
								<span class="caption-helper"> <?php echo $row['created_on']; ?></span>
							</div>
							<div class="actions">
								<a onclick="goBack()" class="btn btn-default btn-circle">
								<i class="fa fa-angle-left"></i>
								<span class="hidden-480">
								Back </span>
								</a>
							</div>
							<div class="tools margin-right-10">
								<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()"></a>
							</div>
						</div>
                        <div class="portlet-body">
                        <div class="row">
											<div class="col-md-6 col-sm-12">
												<div class="portlet blue-hoki box">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-cogs"></i>Order Details
														</div>
													</div>
													
													<div class="portlet-body">
														<div class="row static-info">
															<div class="col-md-5 name">
																 Order #:
															</div>
															<div class="col-md-7 value">
																 <?php echo $row['id']; ?>
															</div>
														</div>
														<div class="row static-info">
															<div class="col-md-5 name">
																 Order Date &amp; Time:
															</div>
															<div class="col-md-7 value">
																 <?php echo $row['created_on']; ?>
															</div>
														</div>
														<div class="row static-info">
															<div class="col-md-5 name">
																 Unique Job Name:
															</div>
															<div class="col-md-7 value">
																<?php echo $row['job_no'];?>
															</div>
														</div>
														<div class="row static-info">
															<div class="col-md-5 name">
																Date Needed:
															</div>
															<div class="col-md-7 value">
																<?php echo $row['date_needed']; ?>
															</div>
														</div>
													</div>
													
												</div>
											</div>
											<div class="col-md-6 col-sm-12">
												<div class="portlet blue-hoki box">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-cogs"></i>Customer Information
														</div>
													</div>
													<div class="portlet-body">
													<?php 
													$pub_name=$this->db->get_where('publications',array('id' => $row['publication_id']))->result_array();
													{
													?>
                                                     <div class="row static-info">
															<div class="col-md-5 name">
																 Publication:
															</div>
															<div class="col-md-7 value">
																<?php echo $pub_name[0]['name']; ?>
															</div>
														</div>
														<?php } ?>
														<?php 
													$adrep_name=$this->db->get_where('adreps',array('id' => $row['adrep_id']))->result_array();
													{
													?>
														<div class="row static-info">
															<div class="col-md-5 name">
																 AdRep Name:
															</div>
															<div class="col-md-7 value">
																<?php echo $adrep_name[0]['first_name'];  ?>
															</div>
														</div>
														<?php } ?>
														<div class="row static-info">
															<div class="col-md-5 name">
																 Email:
															</div>
															<div class="col-md-7 value">
															<?php echo $adrep_name[0]['email_id']; ?>
															</div>
														</div>
														<div class="row static-info">
															<div class="col-md-5 name">
																 Advertiser:
															</div>
															<div class="col-md-7 value">
																 <?php echo $row['advertiser_name']; ?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
                                        <div class="row">
											<div class="col-md-6 col-sm-12">
												<div class="portlet blue-hoki box">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-cogs"></i>Ad Details
														</div>
													</div>
													<?php foreach($orders as $row){ ?>
													<div class="portlet-body">
                                                     <?php if($row['order_type_id']=='1'){ // webad 
														if($row['pixel_size']=='custom'){ ?>
																<div class="row static-info">
															<div class="col-md-5 name">
																 Width:
															</div>
															<div class="col-md-7 value">
																 <?php echo $row['custom_width']; ?>
															</div>
														</div>
														<div class="row static-info">
															<div class="col-md-5 name">
																 Height:
															</div>
															<div class="col-md-7 value">
																<?php echo $row['custom_height']; ?>
															</div>
														</div>
															<?php } else {
														$size_px = $this->db->get_where('pixel_sizes',array('id'=>$row['pixel_size']))->result_array();
													?>
														<div class="row static-info">
															<div class="col-md-5 name">
																 Width:
															</div>
															<div class="col-md-7 value">
																 <?php echo $size_px[0]['width']; ?>
															</div>
														</div>
														<div class="row static-info">
															<div class="col-md-5 name">
																 Height:
															</div>
															<div class="col-md-7 value">
																<?php echo $size_px[0]['height']; ?>
															</div>
														</div>
														<?php } }else{ //printad ?>
														<div class="row static-info">
															<div class="col-md-5 name">
																 Width:
															</div>
															<div class="col-md-7 value">
																 <?php echo $row['width']; ?>
															</div>
														</div>
														<div class="row static-info">
															<div class="col-md-5 name">
																 Height:
															</div>
															<div class="col-md-7 value">
																<?php echo $row['height']; ?>
															</div>
														</div>
													<?php } ?>
														<?php 
														if($row['order_type_id']=='1'){ // webad 
														?>
															<div class="row static-info">
														
																<div class="col-md-5 name">
																 Static/Animated:
																</div>
																<div class="col-md-7 value">
																	<?php echo $row['web_ad_type']; ?>
																</div>
																</div>
														
														<?php
															}else{	//printad
															$print_ad_type =$this->db->get_where('print_ad_types',array('id' => $row['print_ad_type']))->result_array();
															
														?>
																<div class="row static-info">
														
																<div class="col-md-5 name">
																 Full Color/B&W/Spot:
																</div>
																<div class="col-md-7 value">
																	<?php echo $print_ad_type[0]['name']; ?>
																</div>
																</div>
														
														<?php }  if($row['job_instruction']!=="") {?>
														
														<div class="row static-info">
															<div class="col-md-5 name">
																 Job Instruction :
															</div>
															<div class="col-md-7 value">
															<?php  if($row['job_instruction']==1)  { echo "Follow Instructions Carefully"; }?>
															<?php  if($row['job_instruction']==2)  { echo  "Be Creative"; }?>
															<?php  if($row['job_instruction']==3)  { echo  "Camera Ready Ad"; } ?>
															
															</div>
														</div>
														<?php } if($row['art_work']!=="") { ?>
														<div class="row static-info">
															<div class="col-md-5 name">
																 Art Work :
															</div>
															<div class="col-md-7 value">
														   <?php  if($row['art_work']==1)  { echo "Use additional art if required"; }?>
															<?php  if($row['art_work']==2)  { echo  "Modify art provided if necessary"; }?>
															<?php  if($row['art_work']==3)  { echo  "Use art provided without change"; }?>
															
															</div>
														</div>
														<?php } if($row['copy_content']!=="") { ?>
														<div class="row static-info">
															<div class="col-md-5 name">
																 Copy/Content:
															</div>
															<div class="col-md-7 value">
														   <?php  if($row['copy_content']==1)  { echo "Included in the form"; }?>
															<?php  if($row['copy_content']==2)  { echo  "Sent separately"; }?>
															<?php  if($row['copy_content']==3)  { echo  "Changes only"; }?>
															
															</div>
														</div>
														<?php } if($row['notes']!=="") { ?>
														<div class="row static-info">
															<div class="col-md-5 name">
																 Notes & Instructions:
															</div>
															<div class="col-md-7 value">
																 <?php echo $row['notes']; ?>
															</div>
														</div>
														<?php } ?>
													</div>
													<?php } ?>
												</div>
											
											<!-- pick up ad source file link-->
												<?php if($row['pickup_adno'] != '') { ?>
													<div class="portlet blue-hoki box">
														<div class="portlet-title">
															<div class="caption"><i class="fa fa-cogs"></i>Pick up Ad</div>
															<div class="actions">
																<a href="#attach_pickup" data-toggle="modal" class="font-grey-cararra tooltips" data-container="body" data-placement="top" data-original-title="Attach File"><i class="fa fa-link"></i></a> &nbsp;              
															</div>
														</div>
														<div class="portlet-body">
														<?php echo '<h4 style="color:#900;">'.$this->session->flashdata('message').'</h4>'; ?>
														<div class="row static-info">
															<div class="col-md-12 name">
																 Pickup Ad No: <?php echo $row['pickup_adno']; ?>					
															</div>
														</div>
														
										
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
										
														<!--<div class="row static-info">
															<div class="col-md-5 name">
																 Source Link:
															</div>
														<div class="col-md-7 value">
													<?php  $i=1;
													if(isset($pickup_sourcefile)){ 
														$this->load->helper('directory');	
														$map_pk = glob($pickup_sourcefile.'/'.$pickup_slug.'.{indd,psd}',GLOB_BRACE); 
														if($map_pk){ 
															foreach($map_pk as $row_map_pk){ $source_file_pk = basename($row_map_pk); }
													?>	
												
														<form action="<?php echo base_url().'index.php/new_csr/home/zip_folder_select'?>" method="post">
															<input name="source_file" value="<?php echo $source_file_pk;?>" readonly style="display:none;" />
															<input name="new_slug" value="<?php echo $pickup_slug;?>" readonly style="display:none;" />
															<input name="source_path" value="<?php echo $pickup_sourcefile;?>" readonly style="display:none;" />
															<input name="download" value="download" readonly style="display:none;" />
															<button type="submit" name="SourceDownload" class="btn blue">Pickup Ad SourceFile</button>
														</form>
													<?php }  } ?>
														</div>	
														</div>-->
														</div>
													</div>
												<?php } ?>
											<!-- pick up ad source file link-->
											</div>
											
				<div class="col-md-6 col-sm-12">
					<div class="portlet blue-hoki box">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-cloud-download"></i>Attachments
								</div>
								<?php if($row['file_path']!='none') { ?>										
								<div class="actions">			 
									 <form method="post" action="<?php echo base_url().index_page().'new_csr/home/zip_folder';?>">
										<input name="file_path" value="downloads/<?php echo($row['id'].'-'.$row['job_no'])?>" readonly style="display:none" /> 
										<input name="file_name" value="<?php echo($row['id'].'-'.$row['job_no'])?>" readonly style="display:none" />
										<a href="#attach_file" data-toggle="modal" class="font-grey-cararra tooltips" data-container="body" data-placement="top" data-original-title="Attach File"><i class="fa fa-link"></i></a> &nbsp;              
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
								<?php $i=1;	if(isset($dir)){
								foreach($file_format as $format){
								$this->load->helper('directory');																		
								$map = glob($dir.'/*{'.$format['name'].'}',GLOB_BRACE);																		
								if($map){																			
								foreach($map as $row)																			
								{  ?>
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
				
				
				
			<?php
                foreach($orders as $row)
  				if($row['question']=="1" || $row['question']=="2"){ 
			?>
				<div class="row">
					<div class="col-md-12">
					<!-- BEGIN TOOLTIPS PORTLET-->
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cogs font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold uppercase">Question & answer</span>
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse">
								</a>
								<a href="javascript:;" class="reload">
								</a>
							</div>
						</div>
						<div class="portlet-body">
							<div class="scroller" style="height:150px" data-always-visible="1" data-rail-visible="0">
							<?php $question = 	$this->db->query("SELECT * FROM `orders_Q_A` WHERE `order_id` = '$order_id' ORDER BY `id` DESC")->result_array();
							//$this->db->get_where('orders_Q_A',array('order_id' => $order_id))->result_array(); 
							?>
							<?php $iq='0'; foreach($question as $Qrow){ $iq++; ?>
							<?php $csr_name = 	$this->db->get_where('csr',array('id' => $Qrow['csr']))->result_array(); ?>
							<?php $adreps = 	$this->db->get_where('adreps',array('id' => $Qrow['adrep']))->result_array(); ?>
							<?php $Acsr_name = 	$this->db->get_where('csr',array('id' => $Qrow['Acsr']))->result_array(); ?>
							
							<div class="note note-danger">
								<h4 class="block"><?php echo $csr_name[0]['name']; ?></h4>
								<p>
									 <?php echo $Qrow['question']; ?>
								</p>
								 <span class="font-grey-cascade">Sent at - <?php $date = date_create($Qrow['Qtimestamp']); echo date_format($date, 'g:i A \o\n l jS F Y'); ?> </span>
							<?php if($Qrow['answer']==''){  ?>
								<a class="btn blue" href="#form_answer<?php echo $iq; ?>" data-toggle="modal">Answer</a>
							<?php } ?>
							</div>
							
							<?php if(isset($adreps[0]['first_name'])) { ?>
							<div class="note note-success">
								<h4 class="block"><?php echo $adreps[0]['first_name'] ?></h4>
								<p>
									 <?php echo $Qrow['answer']; ?>
								</p>
								<span class="font-grey-cascade">Replayed at - <?php $date = date_create($Qrow['Atimestamp']); echo date_format($date, 'g:i A \o\n l jS F Y'); ?> </span>
							</div>
							<?php }elseif(isset($Acsr_name[0]['name'])){ ?> 
							<div class="note note-success">
								<h4 class="block"><?php echo $Acsr_name[0]['name'] ?></h4>
								<p>
									 <?php echo $Qrow['answer']; ?>
								</p>
								<span class="font-grey-cascade">Replayed at - <?php $date = date_create($Qrow['Atimestamp']); echo date_format($date, 'g:i A \o\n l jS F Y'); ?> </span>
							</div>
							<?php } ?>
		<!-- Answer -->
		<div id="form_answer<?php echo $iq; ?>" class="modal fade" role="dialog" aria-labelledby="myModalLabel10" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Answer to Question</h4>
					</div>
					<div class="modal-body">
						<form  method="POST" action="<?php echo base_url().index_page().'new_csr/home/cshift_answer_v2/'.$order_id;?>" class="form-horizontal" role="form" enctype="multipart/form-data">
							<div class="form-group">
								<div class="col-md-12">
									<textarea class="form-control" name="answer" rows="3" required/></textarea>
								</div>
							</div>
							<label>File input</label>
							<input type="file" name="ufile[]" id="ufile[]"/>
							<input type="file" name="ufile[]" id="ufile[]"/>
							
							<div class="modal-footer">
								<?php if(isset($redirect)){ ?>
								<input type="text" name="redirect" id="redirect" value="<?php echo $redirect; ?>"  readonly style="display:none" />
								<?php } ?>
								<input type="text" name="qid" id="qid" value="<?php echo $Qrow['id']; ?>"  readonly style="display:none"   />
								<button class="btn default" data-dismiss="modal" aria-hidden="true">Close</button>
								<button type="submit" name="sent_designer" class="btn red">Send</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
							<?php } ?>
							</div>
						</div>
					</div>
					<!-- END TOOLTIPS PORTLET-->
				</div>
				</div>
		<?php } ?>	
				
		      </div>
		  </div>
		  
	  </div>
  </div>
 </div>
	</div>
	

	<div class="page-content">
		<div class="container">
			<?php foreach($orders as $row)
			if($row['status']=='1'){
				if(isset($error))
				{
					echo "<div style='font-weight: bold; color:#F00;'>".$error."</div>";
				}
			?>	
        <div class="row">
				<div class="col-md-12">
											
								<div class="portlet box blue-hoki">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-gift"></i>Category Tool
										</div>
										<div class="tools">
											<a href="javascript:;" class="collapse">
											</a>
											<!--<a href="#portlet-config" data-toggle="modal" class="config">
											</a>
											<a href="javascript:;" class="reload">
											</a>-->
											<a href="javascript:;" class="remove">
											</a>
										</div>
									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
									<?php foreach($orders as $row) ?>
													
											<div class="form-body">
												<form name="form" method="post" class="horizontal-form">
												<div Hidden class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label class="control-label">Unique Job Name</label>
															<input name="job_name" type="text" value="<?php echo set_value('job_name');?><?php if(isset($order))echo $order[0]['job_no'];?>" autocomplete="off" required  class="form-control" >
															<span class="help-block">
															adrep provided job name</span>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Order No</label>
															<input type="text" id="order_no" name="order_no" value="<?php echo set_value('order_no'); ?><?php if(isset($order))echo $order[0]['id'];?>" autocomplete="off" required  class="form-control" >
															<span class="help-block">
															adrep job no</span>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Adrep Name</label>
															<?php if(isset($order)){ $adrep = $this->db->get_where('adreps',array('id' => $order[0]['adrep_id']))->result_array(); } ?>
															<input name="adrep" type="text" value="<?php echo set_value('adrep');?><?php if(isset($order))echo $adrep[0]['first_name'];?>" autocomplete="off" required class="form-control" >
															<span class="help-block">
															adrep name</span>
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Advertiser Name</label>
															<input name="adv_name" type="text" value="<?php echo set_value('adv_name');?><?php if(isset($order))echo $order[0]['advertiser_name'];?>" autocomplete="off"  class="form-control" >
															<span class="help-block">
															client name</span>
														</div>
													</div>
													<!--/span-->
													<?php if($row['order_type_id']=='1'){  // webad 
															 if($row['pixel_size']=='custom'){ ?>
																<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Width</label>
															<input value="<?php echo set_value('width');?><?php if(isset($order))echo $order[0]['custom_width'];?>" id="width" name="width" autocomplete="off" class="form-control" >
															<span class="help-block">
															In inches </span>
														</div>
														</div>
														<!--/span-->
														<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Height</label>
															<input id="height" name="height" value="<?php echo set_value('height');?><?php if(isset($order))echo $order[0]['custom_height'];?>" autocomplete="off"  class="form-control" >
															<span class="help-block">
															In inches  </span>
														</div>
														</div>
													
															<?php }else {?>
														<?php $size_px = $this->db->get_where('pixel_sizes',array('id'=>$row['pixel_size']))->result_array();
													?>
														<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Width</label>
															<input value="<?php echo set_value('width');?><?php if(isset($order))echo $size_px[0]['width'];?>" id="width" name="width" autocomplete="off" class="form-control" >
															<span class="help-block">
															In inches </span>
														</div>
														</div>
														<!--/span-->
														<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Height</label>
															<input  id="height" name="height" value="<?php echo set_value('height');?><?php if(isset($order))echo $size_px[0]['height'];?>" autocomplete="off"  class="form-control" >
															<span class="help-block">
															In inches  </span>
														</div>
														</div>
													<!--/span-->
															<?php } }else{ ?>
														<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Width</label>
															<input value="<?php echo set_value('width');?><?php if(isset($order))echo $order[0]['width'];?>" id="width" name="width" autocomplete="off" class="form-control" >
															<span class="help-block">
															In inches </span>
														</div>
														</div>
														<!--/span-->
														<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Height</label>
															<input id="height" name="height" value="<?php echo set_value('height');?><?php if(isset($order))echo $order[0]['height'];?>" autocomplete="off"  class="form-control" >
															<span class="help-block">
															In inches  </span>
														</div>
														</div>
													<?php }?>
													<!--/span-->
												</div>
												<div Hidden class="row">
													<div class="col-md-12 ">
														<div class="form-group">
															<label>Copy & Content</label>
															
		<input type="text" name="copy_content_description" class="form-control" value="<?php if(isset($order))echo $order[0]['copy_content_description']; else echo set_value('copy_content_description'); ?>">
	
														</div>
													</div>
												</div>
												<div Hidden class="row">
													<div class="col-md-12 ">
														<div class="form-group">
															<label>Notes & Instructions</label>
															
		<input type="text" id="notes" name="notes" class="form-control" value="<?php if(isset($order))echo $order[0]['notes']; else echo set_value('notes'); ?>">
	
														</div>
													</div>
												</div>
										<div class="row">
												<div class="col-md-12">
												<div class="form-group">
												<div class="col-md-6">
												
															<label>Art Instruction</label>
															<div class="input-group">
																<div class="icheck-inline">
		<?php $results = $artinst;
		foreach($results as $result)
		{ ?>
																	<label class="">
																	<div class="iradio_square-grey" style="position: relative;"><input type="radio"   name="artinst" id="artinst" value="<?php echo $result['id']; ?>"  <?php echo set_radio('artinst', $result['id']); ?> onClick="run1(this.value);"  required="required" class="icheck" data-radio="iradio_square-grey" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div><?php echo $result['name'];?></label>
																	<?php } ?>													</div>
															</div>
														</div>
												
												<div class="col-md-6">
														<div class="form-group">
															<label>CSR Instruction</label>
															
		<input type="text" name="instruction" class="form-control" value="<?php echo set_value('instruction');?>">
	
														</div>
													</div>
										</div>
										</div>
										</div>
										<div class="row">	
										<div class="col-md-12">
											<div class="col-md-6">
												<div class="form-group">
													<label>Ad Type</label>
																   
													<div class="input-group">
														<div class="icheck-list">
		<?php $results = $adtype; foreach($results as $result){ ?>
															<label class="">
															<div class="iradio_square-grey"  style="position: relative;"><input type="radio"   name="adtype" id="adtype" value="<?php echo $result['id']; ?>" <?php echo set_radio('adtype',$result['id']); ?> onClick="run(this.value);" required="required" class="icheck" data-radio="iradio_square-grey" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div><?php echo $result['name'];?></label>
		<?php }  ?>										</div>
													</div>
												</div>
											</div>
												<div class="col-md-6">
												<div class="form-group">
												<?php $orders_cancel = $this->db->query("SELECT * FROM `orders_cancel` WHERE `order_id`= '".$row['id']."'")->result_array();
												if($orders_cancel){
													$csr_cancel = $this->db->get_where('csr',array('id'=>$orders_cancel[0]['csr']))->result_array();
												}
												?>
												<?php if($row['cancel']=='1') {
														echo "<a class='btn red'>Order has been Cancelled..!!</a>";
													} else if($row['crequest']=='1' && $orders_cancel){
														//echo "<a class='btn red'>Request for Order Cancellation Sent To Adrep..!!</a></br>";
														echo "<div class='note note-info margin-top-10'>
															<h4 class='font-red'> Request for Order Cancellation Sent To Adrep..!!</h4>
															<p class='no-space'>Reason: ".$orders_cancel[0]['Creason']."</p>
															<p class='no-space'>CSR: ".$csr_cancel[0]['name']."</p>
														</div>";
													} else
													if($row['status']=='6'){
														echo "<a class='btn red'>Order Cancelled..!!</a>";
													} else { ?>
												<div> &nbsp </div>
												<div> &nbsp </div>
												<a class="btn blue" href="#form_modal10" data-toggle="modal">Send Question<i class="fa fa-question"></i></a>			
												<a class="btn red" href="#form_modal11" data-toggle="modal">Order Cancel Request<i class="fa fa-question"></i></a>			
												</div>
												<?php }?>
												</div>
										</div>
										</div>
										<div style=" display: none;">	<p class="contact"><label for="name">No of Options</label></p>
        <select class="select-style gender" id="no_pages" name="no_pages" >

   	<option value="1" <?php echo set_select('no_pages', '1');?> >1</option>
	<!--<option value="2" <?php echo set_select('no_pages', '2');?> >2</option>
	<option value="3" <?php echo set_select('no_pages', '3');?> >3</option>
	<option value="4" <?php echo set_select('no_pages', '4');?> >4</option>
	<option value="5" <?php echo set_select('no_pages', '5');?> >5</option> -->     
         
    </select> </div>
	
	<input hidden name="category" value="<?php if(isset($category)) echo($category)?>" readonly />
	</div>
				<input value="<?php echo set_value('publication');?><?php if(isset($order))echo $order[0]['publication_id'];?>" id="publication" name="publication" autocomplete="off" readonly style="visibility:hidden" />
			<div class="form-actions right">
				<button type="button" class="btn default">Cancel</button>
				<button type="submit" type="submit" name="confirm" class="btn blue" >Submit</button>
				
			</div>

<?php
	if(isset($error))
	{
		 "<div style='font-weight: bold; color:#F00;'>".$error."</div>";
	}
	elseif(isset($category))
	{
		 "Category : ".$category;
	}
?>
									
</form>
										<!-- END FORM-->
						
									</div>
								</div>
								
				</div>
			</div>
            
            <?php } ?>
	
		</div>
	</div>
	<!-- order cancelled msg-->
	<?php if($row['status']=='6') { ?>
	<div class="alert alert-danger" align="center">
								<strong>Status - </strong> 
				<?php echo "Order has been Cancelled";  ?>
								
	</div>
	<?php } ?>
				<!-- order cancelled msg-->
	<!-- END PAGE CONTENT -->
</div>       
							<div id="form_modal10" class="modal fade" role="dialog" aria-labelledby="myModalLabel10" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Send Question To Adrep</h4>
										</div>
										<div class="modal-body">
										<form id="order_form" name="order_form" action="<?php echo base_url().index_page().'new_csr/home/cshift_question_v2/'.$hd.'/'.$order[0]['id'];?>" method="post" enctype="multipart/form-data">
										<div class="form-group">
										<div class="col-md-12">
										<input type="text" id="order_id" name="order_id" value="<?php echo $order[0]['id']; ?>" readonly  style="display:none;" />
										<input name="job_name" value="<?php echo $order[0]['job_no'];?>" readonly style="display:none;" />
											<textarea class="form-control" name="question" id="question"  rows="3" required/></textarea>
										</div>
										</div>
										<div class="modal-footer">
										     <button class="btn default" data-dismiss="modal" aria-hidden="true">Close</button>
											<button type="submit" name="submit" type="submit" value="SUBMIT"class="btn red">Send</button>
										</div>
										</div>
										</form>
									</div>
								</div>
							</div>
		<!--order cancel request-->
									<div id="form_modal11" class="modal fade" role="dialog" aria-labelledby="myModalLabel10" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
													<h4 class="modal-title">Send Reason for Cancellation</h4>
												</div>
												<form id="order_form" name="order_form" action="<?php echo base_url().index_page().'new_csr/home/ordercshift_cancel_v2/'.$hd.'/'.$order_id;?>" method="post" enctype="multipart/form-data">
													<div class="modal-body">
													<div class="radio-list">
													<?php foreach($cancel_reason as $result){?>
														<label class="radio-inline">
														<input type="radio" name="Creason"  value="<?php echo $result['name']; ?>" required> <?php echo $result['name'];?></label>
													<?php } ?>
													<label class="radio-inline">
													<input type="radio" id="open-text" name="Creason"  value="others" required> Others</label>
													</div>
														<div id="show-text" class="form-group">
															<div class="margin-top-10">
																<input type="text" id="order_id" name="order_id" value="<?php echo $order_id; ?>" readonly  style="display:none;" />
																<textarea class="form-control" name="reason" id="reason" rows="3"></textarea>
															</div>
														</div>			
													</div>
												<div class="modal-footer">
													<button class="btn default" data-dismiss="modal" aria-hidden="true">Close</button>
													<button type="submit" name="remove" type="submit" value="SUBMIT" class="btn red">Send</button>
												</div>
												</form>
											</div>
										</div>
									</div>
									<!--order cancel request-->
		<!-- Answer -->
		<div id="form_answer" class="modal fade" role="dialog" aria-labelledby="myModalLabel10" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Answer to Question</h4>
					</div>
					<div class="modal-body">
						<form  method="POST" action="<?php echo base_url().index_page().'new_csr/home/cshift_answer_v2/'.$order_id;?>" class="form-horizontal" role="form" enctype="multipart/form-data">
							<div class="form-group">
								<div class="col-md-12">
									<textarea class="form-control" name="answer" rows="3" required/></textarea>
								</div>
							</div>
							<label>File input</label>
							<input type="file" name="ufile[]" id="ufile[]"/>
							<input type="file" name="ufile[]" id="ufile[]"/>
							
							<div class="modal-footer">
								<input type="text" name="qid" id="qid" value="<?php echo $question[0]['id']; ?>"  readonly  style="display:none;" />
								<button class="btn default" data-dismiss="modal" aria-hidden="true">Close</button>
								<button type="submit" name="sent_designer" class="btn red">Send</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div id="attach_file" class="modal fade" role="dialog" aria-labelledby="myModalLabel10" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Attach File</h4>
					</div>
					<div class="modal-body">
						<form  action="<?php echo base_url().index_page().'new_csr/home/attach_file/'.$order_id;?>" method="post" enctype="multipart/form-data">
							<div class="form-group">  
								<input type="file" name="ufile[]" id="ufile[]"/>
							<input type="file" name="ufile[]" id="ufile[]"/>
							</div>
							<div class="modal-footer">
								<?php if(isset($redirect)){ ?>
								<input type="text" name="redirect" id="redirect" value="<?php echo $redirect; ?>"  readonly style="display:none" />
								<?php } ?>
								<button type="submit" name="submit" type="submit" value="SUBMIT" class="btn red">Send</button>
								<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>
							</div>
						</form>
					</div>
				</div>
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
						<form  action="<?php echo base_url().index_page().'new_csr/home/attach_pickup_file/'.$order_id;?>" method="post" enctype="multipart/form-data">
							<div class="form-group">  
								<input type="file" name="file[]" id="file"/> 
								<input type="file" name="file[]" id="file"/>
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
		
</div>

<!-- END PAGE CONTAINER -->
<?php $this->load->view("new_csr/foot.php"); ?>