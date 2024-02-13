<?php
       $this->load->view("team-lead/head"); 
?>
<div class="page-container">
	<!-- BEGIN PAGE HEAD -->
	<div class="page-content">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<!-- Begin: life time stats -->
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-basket font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold uppercase">
								Order #<?php echo $order_id; ?> </span>
								<?php foreach($orders as $row)
													 ?>
								<span class="caption-helper"> <?php echo $row['created_on']; ?></span>
							</div>
							<div class="actions">
								<a onclick="goBack()" class="btn btn-default btn-circle">
								<i class="fa fa-angle-left"></i>
								<span class="hidden-480">
								Back </span>
								</a>
							</div>
						</div>
                        <div class="portlet-body">
						<!--<?php echo '<h4 style="color:#900;">'.$this->session->flashdata('ext_message').'</h4>'; ?> -->
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
																 <?php echo $order_id; ?>
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
											<?php foreach($orders as $row) ?>
													<div class="portlet-body">
													
                                                     <?php if($row['order_type_id']=='1'){ // webad 
														if($row['pixel_size']=='custom'){?>
																<div class="row static-info">
											<div class="col-md-5 name"> Width:</div>
											<div class="col-md-7 value"><?php echo $row['custom_width']; ?></div>
										</div>
										<div class="row static-info">
											<div class="col-md-5 name">Height:</div>
											<div class="col-md-7 value"><?php echo $row['custom_height']; ?></div>
										</div>
										<?php } else {
														$size_px = $this->db->get_where('pixel_sizes',array('id'=>$row['pixel_size']))->result_array();
													?>
													<div class="row static-info">
											<div class="col-md-5 name"> Width:</div>
											<div class="col-md-7 value"><?php echo $size_px[0]['width']; ?></div>
										</div>
										<div class="row static-info">
											<div class="col-md-5 name">Height:</div>
											<div class="col-md-7 value"><?php echo $size_px[0]['height']; ?></div>
										</div>
										<?php } }else{ //printad ?>
													<div class="row static-info">
											<div class="col-md-5 name"> Width:</div>
											<div class="col-md-7 value"><?php echo $row['width']; ?></div>
										</div>
										<div class="row static-info">
											<div class="col-md-5 name">Height:</div>
											<div class="col-md-7 value"><?php echo $row['height']; ?></div>
										</div>
										<?php } ?>
														
										<?php if($row['order_type_id']=='1'){ // webad ?>  
														
										<div class="row static-info">
											<div class="col-md-5 name">Static/Animated:</div>
											<div class="col-md-7 value"><?php echo $row['web_ad_type']; ?></div>
										</div>
										<?php }else{	//printad
												$print_ad_type =$this->db->get_where('print_ad_types',array('id' => $row['print_ad_type']))->result_array();
										?>
																								<div class="row static-info">
											<div class="col-md-5 name">Full Color/B&W/Spot:</div>
											<div class="col-md-7 value"><?php echo $print_ad_type[0]['name']; ?></div>
										</div>
										<?php  } ?>
														
														<?php  if($row['job_instruction']!=="") {?>
														
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
										
												</div>
												
												<!-- pick up ad source file link-->
												<?php //if($row['pickup_adno'] != '') { ?>
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
																 Pickup Ad No: <a href="<?php echo base_url().index_page().'team-lead/home/orderview'.'/'.$row['help_desk'].'/'.$row['pickup_adno'];?>" target="_Blank"><?php echo $row['pickup_adno']; ?></a>					
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
														</div>
													</div>
												<?php //} ?>
											<!-- pick up ad source file link-->		
<!--additional pickup file attachment-->
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
<!--additional pickup file attachment-->
											</div>
											<div class="col-md-6 col-sm-12">
												<div class="portlet blue-hoki box">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-cloud-download"></i>Attachments
														</div>
				<?php if($row['file_path']!='none') { ?>										
														<div class="actions">
             
              <form method="post" action="<?php echo base_url().index_page().'team-lead/home/zip_folder';?>">
                                            
		                           <input name="file_path" value="downloads/<?php echo($order_id.'-'.$row['job_no'])?>" readonly style="visibility:hidden" /> 
                                    <input name="file_name" value="<?php echo($order_id.'-'.$row['job_no'])?>" readonly style="visibility:hidden" />
                             
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
		
			<?php
                foreach($orders as $row)
  				if($row['question']=="1" || $row['question']=="2"){ ?>
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
					<!-- End: life time stats -->
					</div>
				</div>
			</div>
			
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
			
			?>
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-basket font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold uppercase">
								QA Comment - </span><?php echo $dc_name; ?>
							</div>
						</div>
						<div class="portlet-body">
								<?php foreach($dc_reason as $reason) {?>
							<div class="alert alert-block alert-info">
								<p>
								<?php echo $reason['reason']; ?>
								</p>
							</div>
						</div>
			
					</div>	
				</div>		
			</div>
		<?php } }?>	
		<!--DC comment -->
		
			<!--designer message -->
			<?php if(isset($designer_message)) { ?>
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-basket font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold uppercase">
								Designer Message</span>
							</div>
						</div>
						<div class="portlet-body">
								<?php foreach($designer_message as $d_msg) {?>
							<div class="alert alert-block alert-info">
								<p>
								<?php echo $d_msg['message']; ?>
								</p>
							</div>
								<?php } ?>
						</div>
			
					</div>	
				</div>		
			</div>
		<?php  }?>	
		<!--designer message -->
			
		<?php  $pp = $this->db->query("SELECT * FROM `designer_ads_time` WHERE `order_id`='".$order_id."'")->result_array();
				//$cat = $this->db->query("SELECT * FROM `cat_result` WHERE `order_no`='".$row['id']."'")->result_array();
				if($cat[0]['pro_status']=='1' || $cat[0]['pro_status']=='1') { 
		?>
		
	
		
		<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						
							<!-- BEGIN FORM-->
							
								<div class="portlet-title">
								<?php	
								//$cat = $this->db->query("SELECT * FROM `cat_result` WHERE `order_no`='".$row['id']."'")->result_array(); 
								?>
									<?php if($cat[0]['pro_status']=='1'){ ?> <div class="caption">
								<i class="icon-basket font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold uppercase">Ad Design</span>
								<span class="caption-helper"><?php echo $cat[0]['ddate']; ?> <?php echo  $cat[0]['start_time']; } ?></span>
							</div>  
							</div>
							<?php if(($cat[0]['slug']!='none')){ $designer = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$cat[0]['designer']."'")->result_array(); ?>
							   <div class="alert alert-warning">
								<strong>Slug Created  - </strong> <?php echo $cat[0]['slug'];  ?> &nbsp &nbsp &nbsp &nbsp <strong>BY - </strong> <?php echo $designer[0]['name'];  ?><strong>&nbsp &nbsp &nbsp &nbsp Designer Code - </strong> <?php echo $designer[0]['username'];  ?> </strong> 
								 <?php  } ?> 
							</div>
							</form>
							<!-- END FORM-->
					</div>
				</div>
				<div class="col-md-12">
					<div class="portlet light">
						<form method="post">
							<input type="text" name="cat_result_id" value="<?php echo $cat[0]['id']; ?>" style ="display:none;">
							<button type="submit" name="reassign">ReAssign</button>
						</form>
					</div>
				</div>
			</div>

			<?php } $pp = $this->db->query("SELECT * FROM `designer_ads_time` WHERE `order_id`='".$order_id."'")->result_array();
					$designer = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$cat[0]['designer']."'")->result_array(); 
                    if($cat[0]['pro_status'] > '1'&& ($row['status'] != '5' || $cat[0]['pro_status'] != '5')){ 
			?>
								
				<div class="row">
				<div class="col-md-12">
				<div class="portlet light">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-basket font-green-sharp"></i>
						<span class="caption-subject font-green-sharp bold uppercase">Ad Design </span>
						<?php if($pp){ ?>
						<span class="caption-helper"><?php echo $pp[0]['end_date'] ?> <?php echo $pp[0]['end_time'] ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="portlet-body">
								
				<!--  Attachments -->
				<div class="row">
					<div class="col-md-6 col-sm-12">
						<div class="box">
								<!--<div class="portlet-title">
										<div class="caption">
												<i class="fa fa-cloud-download"></i>Sourcefile-<?php echo $designer[0]['name'];  ?>
										</div>
								</div>-->
								
					<!-- BEGIN PORTLET -->
								<div style="border: 1px solid #869ab3; border-radius: 3px; padding: 10px;">                                                                                                    
									  <div class="alert alert-success">   
									   <div class="row">
									   <div class="col-md-4"><strong>Ad Designed by</div>
									   <div class="col-md-4 text-center"><?php echo $designer[0]['name'];  ?></div>
									   <div class="col-md-4 text-right"><?php echo $designer[0]['username'];  ?></strong></div>                                    
									   </div>
									  </div>
										

										<div class="margin-bottom-20 row">
											<div class="col-md-3">
											<?php  $i=1;  if(isset($dir1)) { $this->load->helper('directory');	$map = glob($sourcefile.'/'.$cat[0]['slug'].'.{pdf,jpg,gif,png}',GLOB_BRACE);								
											if($map){			foreach($map as $row) {	  
											
										?>
										<a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" 
										class="btn red-intense margin-right-10 btn-block" style="padding: 30px 10px;">View PDF
										</a>
										<?php } }  ?>
											
											
											<?php 
											$map2 = glob($sourcefile.'/'.$cat[0]['slug'].'.{indd,psd}',GLOB_BRACE); 
												if($map2){ 
												foreach($map2 as $row_map2){ $source_file = basename($row_map2); }
													
										?>
												<!-- source file -->
										</div>
										<div class="col-md-3">
												<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row_map2; ?>"
												class="btn blue-steel btn-block" style="padding: 30px 10px;">Source File
												</a>
										</div>
										<div class="col-md-3">
												<form action="<?php echo base_url().'index.php/team-lead/home/zip_folder_select'?>" method="post">
													<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
													<input name="new_slug" value="<?php echo $cat[0]['slug'];?>" readonly style="display:none;" />
													<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
													<input name="download" value="download" readonly style="display:none;" />
													<button type="submit" name="SourceDownload" class="btn green margin-right-10 btn-block" style="padding: 20px 10px;">Source <br/>Package</button> 
												</form>
										<?php } ?>
										<?php } ?>
										</div>
											
										</div>
									  <br>
									  <div class="margin-top-15">
									   
									   <form method="POST">
										 <input type="text" Hidden value="<?php echo $order_id; ?>" name="order_id" >
											<?php if($cat[0]['pro_status']=='2') { ?>
											<!--<button type="submit" name="sent" class="btn blue start" onclick="return QA_confirm();"><span>Send To QA </span></button>-->
											<a class="btn blue start" href="#form_modalQA" data-toggle="modal">Send To QA <i class="fa fa-question"></i></a>
											<a class="btn red" href="#form_modal10" data-toggle="modal">Back to designer<i class="fa fa-question"></i></a><?php } ?>
											<?php if($cat[0]['pro_status']!='4'){ ?>
											<a class="btn red" href="#form_modal14" data-toggle="modal">Send To DC<i class="fa fa-question"></i></a>
											<?php } ?>
											<!--<button type="button" class="btn green margin-right-10">Make Changes</button> -->
									   </form> 
									  </div>
								</div>
					<!-- END PORTLET -->

								
								
						</div>
					</div>										
			<?php if($cat[0]['pro_status']=='2' || $cat[0]['pro_status']=='7' || $cat[0]['pro_status']=='9') { 
						if(($cat[0]['slug']!='none')){ 
			?>
					
<!--new ad	file upload-->				
			<div class="row">
				
				<div class="col-md-6">	
					<div class="portlet box blue-chambray">
						<div class="portlet-title">
							<div><h4>Upload Source </h4></div>
						</div>
						<div class="portlet-body">												 
							<form method="post" enctype="multipart/form-data">
								<div class="input-group">
									<!-- Source -->
									<input type="file" name="src_file" id="file" accept=".indd, .psd, .ai" class="form-control" placeholder="Drag & Drop File" required/>
									<p class="help-block">Only For In-design File(.indd, .psd, .ai). The File Name Should Be Same As Slug</p>
									
									<!-- Pdf -->
									<input type="file" name="pdf_file" id="file1" accept=".pdf,image/*" class="form-control" placeholder="Drag & Drop File"/>
									<p class="help-block">Only For Pdf file(.pdf) OR Image file(.jpg .gif .png). The File Name Should Be Same As Slug</p>
									
									<!-- Links -->
									<input type="file" name="link_file[]" accept="image/*" multiple class="form-control" placeholder="Drag & Drop File" />
									<p class="help-block">Only For link file.</p>
									
									<!-- Fonts -->
									<input type="file" name="font_file[]" accept=".otf, .ttf" multiple class="form-control" placeholder="Drag & Drop File" />
									<p class="help-block">Only For font file.</p>
									<?php if($cat[0]['pro_status']=='7') { ?>
										<input type="text" name="changes_csr" value="<?php  echo $cat[0]['pro_status']; ?>" style="display:none;">
									<?php } ?>									
									<input type="text" name="slug" value="<?php  echo $cat[0]['slug']; ?>" style="visibility:hidden">
									<input type="text" name="sourcefile" value="<?php  echo $dir1; ?>" style="display:none;">
									<button name="sourceUpload" class="btn blue-chambray" type="submit">Upload</button>
								</div>
								<?php 
										echo '<h5 style="color:#900;">'.$this->session->flashdata('msg').'</h5>';
										if(isset($msg)) echo "<b> $msg </b>";
								?>
							</form>		
						</div>
					</div>
				</div>
				<?php if(isset($msg)){ ?>
				<div class="col-md-6">
					<div class="alert alert-warning"><h3 style="color:red"><?php echo $msg; ?></h3></div>
				</div>
				<?php } ?>
			</div>	
		<?php }  } ?>			
		
		<div class="col-md-6 col-sm-12">
			<!--<form method="POST">
				<input type="text" Hidden value="<?php echo $order_id; ?>" name="order_id" >
		        <?php if($cat[0]['pro_status']=='2') { ?>
				<button type="submit" name="sent" class="btn blue start" onclick="return QA_confirm();"><span>Send To QA </span></button>
				<a class="btn red" href="#form_modal10" data-toggle="modal">Back to designer<i class="fa fa-question"></i></a><?php } ?>
			</form>	</br>-->
				<?php //$cat = $this->db->query("SELECT * FROM `cat_result` WHERE `order_no`='".$order_id."'")->result_array();
							if($cat[0]['pro_status']=='6' || $cat[0]['pro_status']=='7' || $cat[0]['pro_status']=='5' || $cat[0]['pro_status']=='9' || $cat[0]['pro_status']=='4' || $cat[0]['pro_status']=='2' || $cat[0]['pro_status']=='3') 
							{ 
								$qustion = $this->db->query("SELECT * FROM `ads_designcheck_msg` WHERE `order_id`='".$order_id."'")->result_array(); 
								foreach($qustion as $qustion1) { 
								
				?>
						<div class="portlet-title"> 
											<?php  if($qustion1['tl_id']!='0'){ 
												$tl = $this->db->query("SELECT * FROM `team_lead` WHERE `id`='".$qustion1['tl_id']."'")->result_array(); 
											?>
											 <div class="note note-danger">
											 <b class="block"><?php   echo $tl[0]['first_name']; ?></b>
											 <span class="font-grey-cascade"> at - <?php echo $qustion1['time']; ?> </span>
											 <p> <?php echo $qustion1['message']; ?></p>
											 <?php
												if(isset($tl_path)){ 
												$map = glob($tl_path.'/*.{jpg,png,tiff,gif,html,pdf,indd}',GLOB_BRACE);								
												if($map){			
													foreach($map as $row) {  
											?>
											 <p> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a></p>
											  <?php } } } ?>
											 </div>
											 <?php }  
												if($qustion1['csr_id']!='0') { 
													$csr = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$qustion1['csr_id']."'")->result_array();   
											?>
											 <div class="note note-danger">
											 <b class="block"><?php  echo $csr[0]['name'];  ?></b>
											 <span class="font-grey-cascade"> at - <?php echo $qustion1['time']; ?> </span>
											 <p> <?php echo $qustion1['message']; ?></p>
											<?php if(isset($csr_path)){ 
													$map = glob($csr_path.'/*.{jpg,png,gif,tiff,html,pdf,indd}',GLOB_BRACE);								
													if($map){			
														foreach($map as $row) {  
											?>
											 <p> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a></p>
											<?php } } } ?>
											 </div>
											 <?php }  if($qustion1['dc_id']!='0') { $csr = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$qustion1['dc_id']."'")->result_array();   ?>
											  <div class="note note-danger">
											 <b class="block"><?php  echo $csr[0]['name'];  ?></b>
											 <span class="font-grey-cascade"> at - <?php echo $qustion1['time']; ?> </span>
											 <p> <?php echo $qustion1['message']; ?></p>
											 </div>
						<?php } } } ?>
						</div>
		</div>
				</div>
                <!-- Qustion for Designer -->						
							<div id="form_modal10" class="modal fade" role="dialog" aria-labelledby="myModalLabel10" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Send changes to designer</h4>
										</div>
										<div class="modal-body">
										<form  method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
										<div class="form-group">
										<div class="col-md-12">
											<textarea class="form-control" name="msg" rows="3" required/></textarea>
										</div>
									    </div>
										<label>File input</label>
										<input type="file" name="file2" id="file2"/>
										<p class="help-block"><b>Allowed Extensions :</b> <?php if(isset($file_format)){foreach($file_format as $format_row){ echo $format_row['name'].', '; }} ?></p>
										<div class="modal-footer">
										     <button class="btn default" data-dismiss="modal" aria-hidden="true">Close</button>
											<button type="submit" name="sent_designer" class="btn red">Send</button>
										</div>
										</div>
										</form>
									</div>
								</div>
							</div>
							
				</div>
				
					<?php } ?>
			<!-- Ad design Details -->	
				<?php foreach($orders as $row) if($row['status'] == '5' || $cat[0]['pro_status'] == '5'){ ?>
	
			 <div class="note note-info note-bordered">
                <h3 class="block">Ad Design Details</h3>
				<ul class="list-group">
					<?php if(isset($designer)){ ?>
					<li class="list-group-item bg-red-sunglo">
					  Ad Designed by - <strong><?php echo $designer[0]['name']."	";  ?></strong><small><?php echo $pp[0]['end_date'].' '.$pp[0]['end_time']; ?></small>
					</li>
					<?php } if(isset($cp_tool)){ ?>
					<li class="list-group-item bg-purple-plum">
					  Ad QA checked by - <strong><?php echo $csr_name1[0]['name']."	";  ?></strong><small><?php echo $cp_tool[0]['time_stamp']; ?></small>
					</li>
					<?php } if(isset($csr)){ ?>
					<li class="list-group-item bg-green-meadow">
					  Ad DC checked by - <strong><?php echo $csr_name1[0]['name']."	";  ?></strong><small><?php echo $cp_tool[0]['time_stamp']; ?></small>
					</li>
					<?php } if(isset($tl)){ ?>
					<li class="list-group-item  bg-blue-madison"> 
					  Ad TL checked by - <strong><?php echo $tl[0]['first_name']."	";  ?></strong><small><?php echo $pp[0]['end_date'].' '.$pp[0]['end_time']; ?></small>
					</li>
					<?php } if(isset($sourcefile)){ $this->load->helper('directory');	
														$map1 = glob($sourcefile.'/'.$cat[0]['slug'].'.{pdf}',GLOB_BRACE);
								
														if($map1){
															foreach($map1 as $row_map1){	  
												?>
					<a href="<?php echo base_url().$row_map1 ?>" target="_Blank" class="btn btn-circle btn-xs">
					<p class="btn bg-purple"> View PDF </p></a>
					<?php } } } ?>
					<?php 
											$map2 = glob($sourcefile.'/'.$cat[0]['slug'].'.{indd,psd}',GLOB_BRACE); 
												if($map2){ 
												foreach($map2 as $row_map2){ $source_file = basename($row_map2); }
													
										?>
												<form action="<?php echo base_url().'index.php/team-lead/home/zip_folder_select'?>" method="post">
													<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
													<input name="new_slug" value="<?php echo $cat[0]['slug'];?>" readonly style="display:none;" />
													<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
													<input name="download" value="download" readonly style="display:none;" />
													<button type="submit" name="SourceDownload" class="btn green" title="source download">SourceDownload</button>
												</form>
										<?php } ?>
				</ul>
             </div>
	
				<?php } ?>
				</div>
				</div>
				</div>
				
			<!-- status display-->
		<div class="container">
			<div class="row no-margin">
				<div class="portlet light">
					<div class="portlet-body">
						<div class="row margin-top-10">
						<div class="col-md-12">
						<!-- status display-->
							<div class="alert alert-danger margin-top-10" align="center">
								<strong>Status - </strong> 
								<?php 
								if($cat[0]['pro_status']!='0') { 
									$status = $this->db->query("SELECT * FROM `production_status` WHERE id='".$cat[0]['pro_status']."'")->result_array(); 
									echo $status[0]['name'];  
								} else { 
									$status1 = $this->db->query("SELECT * FROM `order_status` WHERE id='".$row['status']."'")->result_array(); 
									echo $status1[0]['name'];
								} ?>
							</div>			
						</div>
						<div class="col-md-12">
							<?php if($orders[0]['cancel']=='1') {
								echo "<a class='btn red'>Order has been Cancelled..!!</a>";
								} else if($orders[0]['crequest']=='1'){
								echo "<a class='btn red'>Request for Order Cancellation Sent To Adrep..!!</a>";
							}?>
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
			
				</div> 
				
		<!--send to DC-->

									<div id="form_modal14" class="modal fade" role="dialog" aria-labelledby="myModalLabel10" aria-hidden="true">

										<div class="modal-dialog">

											<div class="modal-content">

												<div class="modal-header">

													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

													<h4 class="modal-title">Comment To DC</h4>

												</div>

												<div class="modal-body">

													<form  method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">

													<div class="form-group">

														<div class="col-md-12">

															<textarea class="form-control" name="DC_reason" rows="3" required/></textarea>

														</div>

													</div>

													

													<div class="modal-footer">

														<button class="btn default" data-dismiss="modal" aria-hidden="true">Close</button>

														<button type="submit" name="send_DC" class="btn red">Send</button>

													</div>

													</form>

												</div>

											</div>

										</div>

									</div>

									<!--send to DC-->
									
									
									<!--send to DC-->

									<div id="form_modalQA" class="modal fade" role="dialog" aria-labelledby="myModalLabel10" aria-hidden="true">

										<div class="modal-dialog">

											<div class="modal-content">

												<div class="modal-header">

													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

													<h4 class="modal-title">Comment To QA</h4>

												</div>

												<div class="modal-body">

													<form  method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">

													<div class="form-group">

														<div class="col-md-12">
															<input type="text" Hidden value="<?php echo $order_id; ?>" name="order_id" >
															
															<textarea class="form-control" name="QA_reason" rows="3" required/></textarea>

														</div>

													</div>

													

													<div class="modal-footer">

														<button class="btn default" data-dismiss="modal" aria-hidden="true">Close</button>

														<button type="submit" name="sent" class="btn red">Send</button>

													</div>

													</form>

												</div>

											</div>

										</div>

									</div>

									<!--send to DC-->
		</div>
		</div>
	
<?php
       $this->load->view("team-lead/foot"); 
?>