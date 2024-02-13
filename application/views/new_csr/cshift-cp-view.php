<?php $this->load->view("new_csr/head.php"); ?>

<div class="page-container">
	<!-- BEGIN PAGE HEAD -->
	<div class="page-content">
	<div class="container"> 
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
													<?php foreach($orders as $row)
													{ ?>
													<div class="portlet-body">
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
														<?php  
														$fname=$this->db->get_where('print_ad_types',array('id' => $row['print_ad_type']))->result_array();
													{
														?>
														<div class="row static-info">
														
															<div class="col-md-5 name">
																 Full Color/B&W/Spot:
															</div>
															<div class="col-md-7 value">
																<?php echo $fname[0]['name']; ?>
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
                                            
		                           <input name="file_path" value="downloads/<?php echo($row['id'].'-'.$row['job_no'])?>" readonly style="visibility:hidden" /> 
                                    <input name="file_name" value="<?php echo($row['id'].'-'.$row['job_no'])?>" readonly style="visibility:hidden" />
                             
               <button type="submit" type="submit" name="Submit" class="btn btn-default btn-sm">
               <i class="fa fa-cloud-download"></i>All</button>
               </form>
             
              </div>
			  <?php } ?>
													</div>
													<div class="portlet-body">
														<div class="table-scrollable table-scrollable-borderless">
								<table class="table table-light table-hover">
								<tbody><?php $i=1;																	if(isset($dir))																	{																																				$this->load->helper('directory');																		$map = glob($dir.'/*.{jpg,png,gif,html}',GLOB_BRACE);																		if($map){																			foreach($map as $row)																			{  ?>
								<tr>
									<td class="small"><?php echo $i; $i++;?></td>                                     
									<td> <?php echo basename($row) ?></td>
									<td>
									<a href="<?php echo base_url()?><?php echo $row ?>";  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
									<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a>
									</td>
								</tr><?php } } } ?>
								
								
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
 </div>

 	<?php
	    $pp = $this->db->query("SELECT * FROM `designer_ads_time` WHERE `order_id`='".$row['id']."'")->result_array();
		$cat_result = $this->db->query("SELECT * FROM `cat_result` WHERE `order_no`='".$row['id']."'")->result_array();
        $designer = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$cat_result[0]['designer']."'")->result_array();
	 ?>

<div class="container">
<?php echo '<span style="color:#900;">'.$this->session->flashdata('message').'</span>'; ?>
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
							<!-- <div class="actions">
								<a onclick="goBack()" class="btn btn-default btn-circle">
								<i class="fa fa-angle-left"></i>
								<span class="hidden-480">
								Back </span>
								</a>
							</div> -->
						</div>
					<!-- <div class="alert alert-warning">
								<strong>Slug Created  - </strong> <?php echo $cat_result[0]['slug'];  ?> &nbsp &nbsp &nbsp &nbsp <strong>BY - </strong> <?php echo $designer[0]['name'];  ?> </strong> 
								&nbsp &nbsp &nbsp &nbsp <strong>AT - </strong> <?php echo $cat_result[0]['ddate']; ?> <?php echo  $cat_result[0]['start_time'];  ?> </strong> 
							</div>-->	
				<div class="portlet-body">
								
				<!--  Attachments -->
				<div class="row">
					<div class="col-md-6 col-sm-12">
												<div class="portlet blue-hoki box">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-cloud-download"></i>Sourcefile-<?php echo $designer[0]['name'];  ?>
														</div>
													</div>
				<div class="portlet-body">
														<div class="table-scrollable table-scrollable-borderless">
								<table class="table table-light table-hover">
								<tbody>
								<tr>
								<?php  $i=1;  if(isset($dir1)) { $this->load->helper('directory');	$map = glob($dir1.'/*.{zip,pdf}',GLOB_BRACE);								
								if($map){			foreach($map as $row) {	  ?>
									<td class="small"><?php echo $i; $i++;?></td>                                     
									<td> <?php echo basename($row) ?></td>
									<td>
									<a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
									<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a>
									</td>
								</tr><?php } } } ?>
								
								
								</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
	
							<?php foreach($orders as $row)  ?>				
											
					<div class="col-md-6 col-sm-12">
					 				<?php if($cat_result[0]['pro_status']=='3')  { ?>		
						<form method="POST">
						<input type="text" hidden value="<?php echo $row['id']; ?>" name="order_id">
		                <button type="submit" name="end_time" class="btn blue start" onclick="return QA_confirm();"><span>Sent To Adrep</span></button>
		                <button type="submit" name="send_DC" class="btn blue start"><span>Sent To DC</span></button>
						   <a class="btn red" href="#form_modal10" data-toggle="modal">Back To Designer<i class="fa fa-question"></i></a>
						</form>	</br>
					<?php } ?>
                <!-- Qustion for Designer -->
                  <?php  $qustion = $this->db->query("SELECT * FROM `ads_designcheck_msg` WHERE `order_id`='".$row['id']."'")->result_array(); 
                             foreach($qustion as $qustion1){ if($qustion1['csr_id']!='0'){
						?>
						<div class="portlet-title"><div class="note note-danger"><b> <?php echo $qustion1['message'];  ?></b>
						
						</div></div><?php } }
						  ?>
<?php  if(isset($csr_path)) { $map = glob($csr_path.'/*.{jpg,pdf}',GLOB_BRACE);								
								if($map){			foreach($map as $row) {  ?>
											 <p> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a></p>
											  <?php } } } ?>
				
							<div id="form_modal10" class="modal fade" role="dialog" aria-labelledby="myModalLabel10" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Sent Question To Designer</h4>
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
					</div>
							<div class="alert alert-danger" align="center">
								<strong>Status - </strong> <?php $status = $this->db->query("SELECT * FROM `production_status` WHERE id='".$cat_result[0]['pro_status']."'")->result_array(); echo $status[0]['name'];  
								?>
							    </div>					
				</div>
				</div>
				</div>
				
				</div>
</div>

   </div>
   </div>
  
<script src="theme001/vendors/jquery-1.9.1.min.js"></script> 
<script src="theme001/bootstrap/js/bootstrap.min.js"></script> 
<script src="theme001/vendors/jGrowl/jquery.jgrowl.js"></script> 
<script src="theme001/assets/scripts.js"></script>
<script>
var lastChecked = null;
    
            $(document).ready(function() {
                var $chkboxes = $('.chkbox');
                $chkboxes.click(function(e) {
                    if(!lastChecked) {
                        lastChecked = this;
                        return;
                    }
    
                    if(e.shiftKey) {
                        var start = $chkboxes.index(this);
                        var end = $chkboxes.index(lastChecked);

                        $chkboxes.slice(Math.min(start,end), Math.max(start,end)+ 1).prop('checked', lastChecked.checked);
    
                    }
    
                    lastChecked = this;
                });
            });
	
</script>
<?php $this->load->view("new_csr/foot.php"); ?>