<?php $this->load->view("new_csr/head.php"); ?>

<script>
function Adp_confirm(){
    var X=confirm('Are You Sure ?');
	if(X==true){
    return true;
  }
else
  {
    return false;
  }
} 
</script>
<script>
$(document).ready(function(){
     $("#hidden_data").hide();
	 
	 $("#showhidden_data").click(function(){
        $("#hidden_data").toggle();      
     });
});	
</script>
<script>
  $(document).ready(function(){
  $("#show-text").hide();
  
  $("#open-text").click(function(){
  $("#show-text").toggle();     
   });
     
  });
</script>

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
							<div class="tools margin-right-10">
								<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()"></a>
							</div>
						</div>
                        <div class="portlet-body">
						<?php echo '<h4 style="color:#900;">'.$this->session->flashdata('ext_message').'</h4>'; ?>
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
											<div class="col-md-5 name">Order #:</div>
											<div class="col-md-7 value"><?php echo $order_id; ?></div>
										</div>
										<div class="row static-info">
											<div class="col-md-5 name">Order Date &amp; Time:</div>
											<div class="col-md-7 value"><?php echo $row['created_on']; ?></div>
										</div>
										<div class="row static-info">
											<div class="col-md-5 name">Unique Job Name:</div>
											<div class="col-md-7 value"><?php echo $row['job_no'];?></div>
										</div>
										<div class="row static-info">
											<div class="col-md-5 name">Date Needed:</div>
											<div class="col-md-7 value"><?php echo $row['date_needed']; ?></div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6 col-sm-12">
								<div class="portlet blue-hoki box">
									<div class="portlet-title">
										<div class="caption"><i class="fa fa-cogs"></i>Customer Information</div>
									</div>
									<div class="portlet-body">
										<div class="row static-info">
											<div class="col-md-5 name">Publication:</div>
											<div class="col-md-7 value"><?php echo $pub_name[0]['name']; ?></div>
										</div>
											
										<div class="row static-info">
											<div class="col-md-5 name">AdRep Name:</div>
											<div class="col-md-7 value"><?php echo $adrep_name[0]['first_name']; ?></div>
										</div>
												
										<div class="row static-info">
											<div class="col-md-5 name">Email:</div>
											<div class="col-md-7 value"><?php echo $adrep_name[0]['email_id']; ?></div>
										</div>
										<div class="row static-info">
											<div class="col-md-5 name">Advertiser:</div>
											<div class="col-md-7 value"><?php echo $row['advertiser_name']; ?></div>
										</div>
									</div>
								</div>
							</div>
						</div>
                        <div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="portlet blue-hoki box">
									<div class="portlet-title">
										<div class="caption"><i class="fa fa-cogs"></i>Ad Details</div>
									</div>
									
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
										<?php if($row['job_instruction']!=="") {?>
											<div class="row static-info">
												<div class="col-md-5 name"> Job Instruction :</div>
												<div class="col-md-7 value">
													<?php  if($row['job_instruction']==1)  { echo "Follow Instructions Carefully"; }?>
													<?php  if($row['job_instruction']==2)  { echo  "Be Creative"; }?>
													<?php  if($row['job_instruction']==3)  { echo  "Camera Ready Ad"; } ?>
												</div>
											</div>
											<?php } if($row['art_work']!=="") { ?>
											<div class="row static-info">
												<div class="col-md-5 name">Art Work :</div>
												<div class="col-md-7 value">
													<?php  if($row['art_work']==1)  { echo "Use additional art if required"; }?>
													<?php  if($row['art_work']==2)  { echo  "Modify art provided if necessary"; }?>
													<?php  if($row['art_work']==3)  { echo  "Use art provided without change"; }?>
												</div>
											</div>
											<?php } if($row['copy_content']!=="") { ?>
											<div class="row static-info">
												<div class="col-md-5 name">Copy/Content:</div>
												<div class="col-md-7 value">
													<?php  if($row['copy_content']==1)  { echo "Included in the form"; }?>
													<?php  if($row['copy_content']==2)  { echo  "Sent separately"; }?>
													<?php  if($row['copy_content']==3)  { echo  "Changes only"; }?>
												</div>
											</div>
											<?php } if($row['notes']!=="") { ?>
											<div class="row static-info">
												<div class="col-md-5 name">Notes & Instructions:</div>
												<div class="col-md-7 value"><?php echo $row['notes']; ?></div>
											</div>
											<?php } ?>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-12">
									<div class="portlet blue-hoki box">
										<div class="portlet-title">
											<div class="caption"><i class="fa fa-cloud-download"></i>Attachments</div>
											<?php if($row['file_path']!='none') { ?>										
											<div class="actions">
             									<form method="post" action="<?php echo base_url().index_page().'new_csr/home/zip_folder';?>">
													<input name="file_path" value="downloads/<?php echo($order_id.'-'.$row['job_no'])?>" readonly style="display:none" /> 
													<input name="file_name" value="<?php echo($order_id.'-'.$row['job_no'])?>" readonly style="display:none" />
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
												<?php $i=1;
												if(isset($downloads)){
														foreach($file_format as $format){
														$this->load->helper('directory');
														$map = glob($downloads.'/*{'.$format['name'].'}',GLOB_BRACE);		
														if($map){
															foreach($map as $row_map)
															{ 
												?>
												<tr>
													<td class="small"><?php echo $i; $i++;?></td>                                     
													<td> <?php echo basename($row_map) ?></td>
													<td>
													<a href="<?php echo base_url()?><?php echo $row_map ?>";  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
													<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row_map; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a>
													</td>
												</tr><?php } } } } ?>
												
												
												</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
								
	<!--cshift_category-->
	
	</div>
						<!-- End: life time stats -->
					</div>
					</div>
					
					<?php	if($row['question']=="1" || $row['question']=="2"){ ?>
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
													<a href="javascript:;" class="collapse"></a>
													<a href="javascript:;" class="reload"></a>
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
								<input type="text" name="qid" id="qid" value="<?php echo $Qrow['id']; ?>"  readonly style="display:none" />
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
					
	<div class="page-content">
			<?php if(isset($cat_pending)) { ?>
			<div class="row">
				<div class="col-md-12">				
					<div class="portlet box blue-hoki">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-gift"></i>Category Tool
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse"></a>
								<a href="javascript:;" class="remove"></a>
							</div>
						</div>
						<div class="portlet-body form">
							<!-- BEGIN FORM-->		
							<div class="form-body">
								<form name="form" method="post" action="<?php echo base_url().index_page().'new_csr/home/cshift_category_demo/'.$order_id;?>" class="horizontal-form">
									<div Hidden class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label">Unique Job Name</label>
												<input name="job_name" type="text" value="<?php if(isset($orders))echo $orders[0]['job_no'];?>" autocomplete="off" required  class="form-control" style="display:none;" >
												<span class="help-block">
												adrep provided job name</span>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label">Order No</label>
												<input type="text" id="order_no" name="order_no" value="<?php if(isset($orders))echo $orders[0]['id'];?>" autocomplete="off" required  class="form-control" style="display:none;">
												<span class="help-block">
												adrep job no</span>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label">Adrep Name</label>
												<?php if(isset($orders)){ $adrep = $this->db->get_where('adreps',array('id' => $orders[0]['adrep_id']))->result_array(); } ?>
												<input name="adrep" type="text" value="<?php if(isset($orders))echo $adrep[0]['first_name'];?>" autocomplete="off" required class="form-control" style="display:none;">
												<span class="help-block">
												adrep name</span>
											</div>
										</div>
										<!--/span-->
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label">Advertiser Name</label>
												<input name="adv_name" type="text" value="<?php if(isset($orders))echo $orders[0]['advertiser_name'];?>" autocomplete="off" required class="form-control" style="display:none;">
												<span class="help-block">
												client name</span>
											</div>
										</div>
										<!--/span-->
										<?php if($orders[0]['order_type_id']=='1'){  // webad 
											if($orders[0]['pixel_size']=='custom'){ ?>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label">Width</label>
												<input value="<?php if(isset($orders))echo $orders[0]['custom_width'];?>" id="width" name="width" autocomplete="off" class="form-control" >
												<span class="help-block">
												In inches </span>
											</div>
										</div>
										<!--/span-->
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label">Height</label>
												<input id="height" name="height" value="<?php if(isset($orders))echo $orders[0]['custom_height'];?>" autocomplete="off"  class="form-control" >
												<span class="help-block">
												In inches  </span>
											</div>
										</div>
											<?php }else {?>
												<?php $size_px = $this->db->get_where('pixel_sizes',array('id'=>$orders[0]['pixel_size']))->result_array();
											?>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label">Width</label>
												<input value="<?php if(isset($orders))echo $size_px[0]['width'];?>" id="width" name="width" autocomplete="off" class="form-control" >
												<span class="help-block">
												In inches </span>
											</div>
										</div>
										<!--/span-->
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label">Height</label>
												<input  id="height" name="height" value="<?php if(isset($orders))echo $size_px[0]['height'];?>" autocomplete="off"  class="form-control" >
												<span class="help-block">
												In inches  </span>
											</div>
										</div>
										<!--/span-->
										<?php } }else{ ?>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label">Width</label>
												<input value="<?php if(isset($orders))echo $orders[0]['width'];?>" id="width" name="width" autocomplete="off" class="form-control" >
												<span class="help-block">
												In inches </span>
											</div>
										</div>
										<!--/span-->
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label">Height</label>
												<input id="height" name="height" value="<?php if(isset($orders))echo $orders[0]['height'];?>" autocomplete="off"  class="form-control" >
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
													<input type="text" name="copy_content_description" class="form-control" value="<?php if(isset($orders))echo $orders[0]['copy_content_description']; else echo set_value('copy_content_description'); ?>">
										    </div>
										</div>
									</div>
									<div hidden class="row">
										<div class="col-md-12 ">
											<div class="form-group">
												<label>Notes & Instructions</label>														
													<input type="text" id="notes" name="notes" class="form-control" value="<?php if(isset($orders))echo $orders[0]['notes']; else echo set_value('notes'); ?>">	
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
																	<!--<div class="iradio_square-grey" style="position: relative;"><input type="radio"   name="artinst" id="artinst" value="<?php echo $result['id']; ?>" onClick="run1(this.value);"  required="required" class="icheck" data-radio="iradio_square-grey" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div><?php echo $result['name'];?></label>-->
															<input type="radio" name="adtype" id="adtype" value="<?php echo $result['id']; ?>" >
															<?php echo $result['name'];?>
																	<?php } ?>													</div>
														</div>
												</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>CSR Instruction</label>									
												<input type="text" name="instruction" class="form-control" >
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
															<input type="radio" name="adtype" id="adtype" value="<?php echo $result['id']; ?>" >
															<?php echo $result['name'];?>
															</label>
		<?php }  ?>										</div>
													</div>
												</div>
											</div>
												<!--<div class="col-md-6">
												<div class="form-group">
												<?php if($orders[0]['cancel']=='1') {
														echo "<a class='btn red'>Order has been Cancelled..!!</a>";
													} else if($orders[0]['crequest']=='1'){
														echo "<a class='btn red'>Request for Order Cancellation Sent To Adrep..!!</a>";
													} else {?>
												<div> &nbsp </div>
												<div> &nbsp </div>
												<a class="btn blue" href="#form_modal13" data-toggle="modal">Send Question<i class="fa fa-question"></i></a>
												<a class="btn red" href="#form_modal11" data-toggle="modal">Order Cancel Request<i class="fa fa-question"></i></a>			
												</div>
												<?php }?>
												</div>-->
										</div>
									</div>
				<input name="category" value="<?php if(isset($category)) echo($category)?>" readonly style="display:none;" />
							</div>
				<input value="<?php if(isset($orders))echo $orders[0]['publication_id'];?>" id="publication" name="publication" autocomplete="off" readonly style="display:none;" />
					<div class="form-actions right">
						<button type="button" class="btn default">Cancel</button>
						<button type="submit" type="submit" name="confirm" class="btn blue" onclick="return Adp_confirm();" >Submit</button>
					</div>
					<div style=" display: none;">	
						<p class="contact"><label for="name">No of Options</label></p>
							<select class="select-style gender" id="no_pages" name="no_pages" >
							<option value="1" >1</option>
							</select> 
					</div>
								</form>
										<!-- END FORM-->
						</div>
					</div>			
				</div>
			</div>
        </div>
	</div>
			<?php }  ?>
	<!--cshift_category-->	
	</div>				
	</div>
	</div>
			
			
		<!--DC comment -->
			<?php if(isset($dc_reason)) { ?>
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-basket font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold uppercase">
								DC Comment</span>
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
						</div>
			
					</div>	
				</div>		
			</div>
		<?php } }?>	
		<!--designer message -->
		
		<?php	
			$pp = $this->db->query("SELECT * FROM `designer_ads_time` WHERE `order_id`='".$row['id']."'")->result_array(); 
			echo '<span style="color:#900;">'.$this->session->flashdata('message').'</span>'; 
			if($row['status'] > '2' && $cat[0]['pro_status']>'1' && ($row['status'] != '5' || $cat[0]['pro_status'] != '5')) { 
		?>
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-basket font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold uppercase">
								Ad Design </span>
								<span class="caption-helper"><?php echo $pp[0]['end_date'] ?> <?php echo $pp[0]['end_time'] ?></span>
							</div>
							
						</div>
					
						<div class="portlet-body">
								
						<!--  Attachments -->
							<div class="row">
								<div class="col-md-6 col-sm-12">
									<div class="portlet blue-hoki box">
										<div class="portlet-title">
											<div class="caption">
												Ad designed by <b><?php echo $designer[0]['name'];  ?></b>
											</div>
										</div>
										<div class="portlet-body" style="min-height: 110px;">
												
												<?php  $i=1;  
													if(isset($sourcefile)&& ($cat[0]['pro_status']=='3' || $cat[0]['pro_status']=='4')){ 
														$this->load->helper('directory');	
														$map1 = glob($sourcefile.'/'.$slug.'.{pdf,jpg,gif,png}',GLOB_BRACE);
								
														if($map1){
															foreach($map1 as $row_map1){	  
												?>
													                                    
													
														<!-- <?php echo basename($row_map1) ?>
														<a href="<?php echo base_url().$row_map1 ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
														<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row_map1; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a>
														-->
											<div class="row margin-top-20 margin-bottom-30">
												<div class="col-md-3">
													<a href="<?php echo base_url().$row_map1 ?>" target="_Blank" type="button" class="btn green">View PDF
													</a>
													<?php } } ?>
												</div>
												<div class="col-md-3">
													<?php 
														$map2 = glob($sourcefile.'/'.$slug.'.{indd,psd}',GLOB_BRACE); 
														if($map2){ 
															foreach($map2 as $row_map2){ $source_file = basename($row_map2); }
															/*echo $source_file."<br/>"; 
															echo $slug."<br/>";
															echo $sourcefile."<br/>";*/
													?>
													<!-- source file -->
													<!--<?php echo $source_file; ?>-->
													<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row_map2; ?>" class="btn green">Source File
													</a>
												</div>
												<div class="col-md-3">
													<form action="<?php echo base_url().'index.php/new_csr/home/zip_folder_select'?>" method="post">
															<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
															<input name="new_slug" value="<?php echo $slug;?>" readonly style="display:none;" />
															<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
															<input name="download" value="download" readonly style="display:none;" />
															<button type="submit" name="SourceDownload" class="btn green">Source Package</button>
														</form>
													<?php } ?>
													<?php } ?>
												</div>
											</div>	
										</div>
									</div>
								</div>
								<?php foreach($orders as $row)  ?>				
								<div class="col-md-6 col-sm-12">
								<?php if(($cat[0]['pro_status']=='3' || $cat[0]['pro_status']=='4' || $cat[0]['pro_status']=='6') && isset($sourcefile))  { 
											$map2 = glob($sourcefile.'/'.$slug.'.{indd,psd}',GLOB_BRACE); 
											if($map2){ 
												foreach($map2 as $row_map2){ $source_file = basename($row_map2); }
								?>		
										<form method="POST">
											<input type="text" hidden value="<?php echo $row['id']; ?>" name="order_id">
										
											<input name="order_id" value="<?php echo $order_id;?>" readonly style="display:none;" />
											<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
											<input name="new_slug" value="<?php echo $slug;?>" readonly style="display:none;" />
											<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
										
											<div class="form-group"><input type="checkbox" value="1" id="showhidden_data"><label>Note</label>  </div>
											 <div id="hidden_data" class="margin-bottom-10">
											  <textarea name="note" rows="3" class="form-control border"></textarea>
											 </div>
										
											<button type="submit" name="end_time" class="btn blue start" onclick="return Adp_confirm();"><span>Send To Adrep</span></button>
											<?php if($cat[0]['pro_status']!='4'){ ?>
											<!--<button type="submit" name="send_DC" class="btn blue start"><span>Send To DC</span></button>-->
											<a class="btn red" href="#form_modal14" data-toggle="modal">Send To DC<i class="fa fa-question"></i></a>
											<?php } ?>
										   <a class="btn red" href="#form_modal10" data-toggle="modal">Back To Designer<i class="fa fa-question"></i></a>
										</form>
								<?php  } }  ?>
								<!-- Qustion for Designer -->
								<?php  $qustion = $this->db->query("SELECT * FROM `ads_designcheck_msg` WHERE `order_id`='".$row['id']."'")->result_array(); 
										foreach($qustion as $qustion1){ 
											//CSR Question
											if($qustion1['csr_id']!='0') { $csr = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$qustion1['csr_id']."'")->result_array();   ?>
											 <div class="note note-info">
											 <b class="block"><?php  echo $csr[0]['name'];  ?></b>
											 <span class="font-grey-cascade"> at - <?php echo $qustion1['time']; ?> </span>
											 <p> <?php echo $qustion1['message']; ?></p>
											 <?php  if(isset($csr_path)) { 
														$map = glob($csr_path.'/*.{jpg,pdf}',GLOB_BRACE);
														if($map){			
															foreach($map as $row_csr) {  
											?>
												<p> Attached File - <?php echo basename($row_csr) ?> 
												<a href="<?php echo base_url().$row_csr; ?>"  target="_Blank" class="btn btn-circle btn-xs">
												<span class="fa fa-eye"></span></a>
												</p>
											<?php } } }  ?>
											</div>
									<?php } ?>
									<!--tl part-->
									<?php  if($qustion1['tl_id']!='0'){ $tl = $this->db->query("SELECT * FROM `team_lead` WHERE `id`='".$qustion1['tl_id']."'")->result_array(); ?>
											<div class="note note-danger">
											 <b class="block"><?php   echo $tl[0]['first_name']; ?></b>
											 <span class="font-grey-cascade"> at - <?php echo $qustion1['time']; ?> </span>
											 <p> <?php echo $qustion1['message']; ?></p>
											 <?php  if(isset($tl_path)) { 
														$map = glob($tl_path.'/*.{jpg,pdf}',GLOB_BRACE);
														if($map){			
															foreach($map as $row_tl) {  
											?>
											<p> Attached File - <?php echo basename($row_tl) ?> 
											<a href="<?php echo base_url().$row_tl; ?>"  target="_Blank" class="btn btn-circle btn-xs">
											<span class="fa fa-eye"></span></a>
											</p>
									 <?php } } }  ?>
										  </div>
									<?php } ?>
									<!--tl part-->
									
									 <?php if($qustion1['dc_id']!='0'){
									 $csr = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$qustion1['dc_id']."'")->result_array();
									?>
									<div class="portlet-title">
									<div class="note note-danger">
														 <b class="block"><?php  echo $csr[0]['name'];  ?></b>
														 
														 <p> <?php echo $qustion1['message']; ?></p>
									</div></div>
									<?php  } } ?>
									 
									<?php  if(isset($dc_path)) { 
											$map1 = glob($dc_path.'/*.{jpg,pdf}',GLOB_BRACE);								
											if($map1){ 
											foreach($map1 as $row_dc) {  
									?>
									<p> Attached File - <?php echo basename($row_dc) ?> <a href="<?php echo base_url()?><?php echo $row_dc ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a></p>
									<?php } } }  ?>
									<div id="form_modal10" class="modal fade" role="dialog" aria-labelledby="myModalLabel10" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
													<h4 class="modal-title">Send Question To Designer</h4>
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
													<input type="text" name="sourcefile" value="<?php echo $sourcefile; ?>" style="display:none;">
													<div class="modal-footer">
														<button class="btn default" data-dismiss="modal" aria-hidden="true">Close</button>
														<button type="submit" name="sent_designer" value="<?php echo $cat[0]['pro_status']; ?>" class="btn red">Send</button>
													</div>
													</form>
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
								</div>
							</div>
						<?php } ?>
					
	<!-- Ad design Details -->	
	<?php if(isset($cat)){ if($row['status'] == '5' || $cat[0]['pro_status'] == '5'){ ?>
	
			 <div class="note note-info note-bordered">
                <h3 class="block">Ad Design Details</h3>
				<ul class="list-group">
					<?php if(isset($designer)){ ?>
					<li class="list-group-item bg-blue-madison">
					  Ad Designed by - <strong><?php echo $designer[0]['name']."	";  ?></strong><small><?php echo $pp[0]['end_date'].' '.$pp[0]['end_time']; ?></small>
					</li>
					<?php } if(isset($csr_name1)){ ?>
					<li class="list-group-item bg-yellow-frusta">
					  Ad QA checked by - <strong><?php echo $csr_name1[0]['name']."	";  ?></strong><small><?php echo $cp_tool[0]['time_stamp']; ?></small>
					</li>
					<?php } if(isset($csr_name1)){ ?>
					<li class="list-group-item bg-green-meadow">
					  Ad DC checked by - <strong><?php echo $csr_name1[0]['name']."	";  ?></strong><small><?php echo $cp_tool[0]['time_stamp']; ?></small>
					</li>
					<?php } if(isset($tl)){ ?>
					<li class="list-group-item  bg-yellow-frusta">
					  Ad TL checked by - <strong><?php echo $tl[0]['first_name']."	";  ?></strong><small><?php echo $cat[0]['tl_date'].' '.$cat[0]['tl_time']; ?></small>
					</li>
					<?php } if(isset($sourcefile) && $cat[0]['pdf_path']!='none'){ ?>
					<a href="<?php echo base_url().''.$cat[0]['pdf_path'];?>" target="_Blank" class="btn blue-madison"> View PDF </a>
					<?php } ?>
				</ul>
             </div>
	
	<?php } }?>
	<!-- status display--><?php if(isset($cat)){ ?>
								<div class="alert alert-danger" align="center">
								<strong>Status - </strong> 
								<?php 
									if($cat[0]['pro_status']!='0'){ 
										$status = $this->db->query("SELECT * FROM `production_status` WHERE id='".$cat[0]['pro_status']."'")->result_array();
									echo $status[0]['name']; 
									}elseif($row['status']!='0'){ 
										$status1 = $this->db->query("SELECT * FROM `order_status` WHERE id='".$row['status']."'")->result_array(); 
										echo $status1[0]['name'];
								} }
								?>
							    </div>
				
						<div class="form-group center">
								<?php if($row['cancel']=='1') {
									echo "<a class='btn red'>Order has been Cancelled..!!</a>";
								} else if($row['crequest']=='1'){
									echo "<a class='btn red'>Request for Order Cancellation Sent To Adrep..!!</a>";
								} else {?>
								<a class="btn blue" href="#form_modal13" data-toggle="modal">Send Question<i class="fa fa-question"></i></a>			
								<a class="btn red" href="#form_modal11" data-toggle="modal">Order Cancel Request<i class="fa fa-question"></i></a>			
						</div>	
								<?php } ?>							
				</div>
				</div>
				</div>
				
				</div>
</div>
	
							<!---qstn to adrep--->
							<div id="form_modal13" class="modal fade" role="dialog" aria-labelledby="myModalLabel10" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Send Question To Adrep</h4>
										</div>
										<form id="order_form" name="order_form" action="<?php echo base_url().index_page().'new_csr/home/cshift_question_v2/'.$hd.'/'.$orders[0]['id'];?>" method="post" enctype="multipart/form-data">
										<div class="modal-body">
										<div class="form-group">
										<div class="col-md-12">
										<input type="text" id="order_id" name="order_id" value="<?php echo $orders[0]['id']; ?>" readonly  style="display:none;" />
										<input name="job_name" value="<?php echo $orders[0]['job_no'];?>" readonly style="display:none;" />
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
						<!--qstn to adrep--->
									
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
													<?php if(isset($cancel_reason)) { foreach($cancel_reason as $result){ ?>
														<label class="radio-inline">
														<input type="radio" name="Creason"  value="<?php echo $result['name']; ?>" required> <?php echo $result['name'];?></label>
													<?php } } ?>
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
									
							<!--additional file attachment-->
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
						<!--additional file attachment-->
		
	
			
			
	</div>
	<!-- END PAGE HEAD -->
	</div>
	
	<!-- BEGIN PAGE CONTENT -->
	
	
<?php $this->load->view("new_csr/foot.php"); ?>

