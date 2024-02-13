<?php $this->load->view('new_admin/header.php'); ?>
<style>
.tabletools-btn-group {
		display: none !important;
}
.word-wrap-name{
	max-width: 250px;
	word-wrap: break-word;
}
.btn-xxs{
	padding: 5px;
	font-size: 12px;
	line-height: .8;
}
.no-border{
	border: 0px !important;
}
.btn-xs {
    margin-bottom: 5px;
}
</style>

<!--<script>
   function Refresh() {
        window.parent.location = window.parent.location.href;
		<?php 
				$current_time = date("H:i:s"); 
		?>
    }
</script>-->


				
				
<div class="page-container">
	<!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
				<?php echo '<span style="color:#900;">'.$this->session->flashdata('message').'</span>'; ?>
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<a href="<?php echo base_url().index_page().'new_admin/home/revision_frontlinetrack/'.$qystday; ?>"><button class="btn btn-xs green"><?php echo $qystday; ?></button></a>
								<a href="<?php echo base_url().index_page().'new_admin/home/revision_frontlinetrack/'.$pystday; ?>"><button class="btn btn-xs green"><?php echo $pystday; ?></button></a>
								<a href="<?php echo base_url().index_page().'new_admin/home/revision_frontlinetrack/'.$ystday; ?>"><button class="btn btn-xs green"><?php echo $ystday; ?></button></a>
								<a href="<?php echo base_url().index_page().'new_admin/home/revision_frontlinetrack/'.$today; ?>"><button class="btn btn-xs green"><?php echo $today; ?></button></a>
							</div>
							<div class="tools">
								<span class="cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
							</div>
						</div>
						<div class="portlet-body no-space">						
							<table class="table table-bordered table-hover" id="sample_3">
								<thead>											
									<tr>										
										<th class="hidden">Copy</th>
										<th class="hidden">Attachments</th>
										<th>No.</th>
										<th>Job No.</th>
										<th>Reason</th>										
										<th>Recieved Version</th>
										<th>Previous Version</th>
										<th>Action</th>
									</tr>
								</thead> 
								<tbody>	
								<?php
								
								$count = '0'; $i=0;
									foreach($jobs as $row){ 
									$count++;
									$rev_name = array();
									$rev_reason = $this->db->query("SELECT `id`, `reason_id`, `error_type` FROM `rev_order_reason` WHERE `rev_id` = '".$row['id']."'")->row_array();
									
									if(isset($rev_reason['reason_id'])){
										$rev_name = $this->db->query("SELECT `name` FROM `rev_reason` WHERE `id` = '".$rev_reason['reason_id']."'")->row_array();
									}
										
									
												$version = $row['version'];
												if($version == 'V1a'){ $version = 'V1'; }
												elseif($version == 'V1b'){ $version = 'V1a'; }
												elseif($version == 'V1c'){ $version = 'V1b'; }
												elseif($version == 'V1d'){ $version = 'V1c'; }
												elseif($version == 'V1e'){ $version = 'V1d'; }
												elseif($version == 'V1f'){ $version = 'V1e'; }
												elseif($version == 'V1g'){ $version = 'V1f'; }
												elseif($version == 'V1h'){ $version = 'V1g'; }
												elseif($version == 'V1i'){ $version = 'V1h'; }
												elseif($version == 'V1j'){ $version = 'V1i'; }
												elseif($version == 'V1k'){ $version = 'V1j'; }
												elseif($version == 'V1l'){ $version = 'V1k'; }
												elseif($version == 'V1m'){ $version = 'V1l'; }
												elseif($version == 'V1n'){ $version = 'V1m'; }
												elseif($version == 'V1o'){ $version = 'V1n'; }
												elseif($version == 'V1p'){ $version = 'V1o'; }
												elseif($version == 'V1q'){ $version = 'V1p'; }
												elseif($version == 'V1r'){ $version = 'V1q'; }
												elseif($version == 'V1s'){ $version = 'V1r'; }
												elseif($version == 'V1t'){ $version = 'V1s'; }
												elseif($version == 'V1u'){ $version = 'V1t'; }
												elseif($version == 'V1v'){ $version = 'V1u'; }
												elseif($version == 'V1w'){ $version = 'V1v'; }
												elseif($version == 'V1x'){ $version = 'V1w'; }
												elseif($version == 'V1y'){ $version = 'V1x'; }
												elseif($version == 'V1z'){ $version = 'V1y'; }
									
									if($version == 'V1'){
										$orders = $this->db->query("SELECT `pdf` FROM `orders` WHERE `id` = '".$row['order_id']."'")->row_array();
										$pdf = $orders['pdf'];
									}else{
										$prev_rev_sold = $this->db->query("SELECT `pdf_path` FROM `rev_sold_jobs` WHERE `order_id` = '".$row['order_id']."' AND `version`='$version' LIMIT 1")->row_array();
										$pdf = $prev_rev_sold['pdf_path'];
									}
								?>										
									 <tr>
										<td class="hidden">								
											<?php echo $row['note']; ?>
										</td>
										<td class="hidden">	
											<?php 
												if($row['file_path'] != 'none' && file_exists($row['file_path'])){ 
													$filepath = $row['file_path'];
													$this->load->helper('directory');
													$map = glob($filepath.'/*',GLOB_BRACE);
													if($map)$i=0;{ foreach($map as $row1){$i++;
											?>								
											<a href="<?php echo base_url().$row1; ?>" target="_Blank" class="btn btn-xxs bg-grey-cascade">Attachments <?php echo $i;?></a>
											<?php } } } ?>
											<!--<a href="#" class="btn btn-xxs bg-grey-cascade">Attachments 2</a>
											<a href="#" class="btn btn-xxs bg-grey-cascade">Attachments 3</a>-->
										</td>
										<td><?php echo $count ; ?></td>
										<td class="word-wrap-name">
											<a href="<?php echo base_url().index_page().'new_admin/home/orderview_history/'.$row['help_desk'].'/'.$row['order_id'];?>">
												<?php echo $row['order_no']; ?>
											</a>
										</td>
										
										<td><?php if(isset($rev_name['name'])){echo $rev_name['name'];} ?></td>
										
										<td><a href="<?php echo base_url().$row['pdf_path'];?>"><?php echo $row['version']; ?></a></td>	
										
										<td><a href="<?php echo base_url().$pdf?>"><?php if(isset($version)){ echo $version; }?></a></td>	
										
										<td id="savechanges<?php echo $count; ?>">
										<?php if(isset($rev_reason['reason_id'])){ ?>
											<form method="post">
												<input type ="text" value="<?php echo $rev_reason['id'];?>" name="id" style="display:none">
												<select class="select2m form-control" name="error_id">
													<option value=""></option>
													<?php foreach($error_type as $error_row){ ?>
														<option value="<?php echo  $error_row['id']; ?>" <?php if($rev_reason['error_type']==$error_row['id']){ echo "selected"; } ?> ><?php echo $error_row['name']; ?></option>
													<?php } ?>
												</select>
												<span class="pull-right">
													<button id="submit_form<?php echo $count; ?>" type="submit" name="update_status" class="margin-top-5 btn btn-xs btn-primary" style="display: inline-block;">Save Changes</button>
												</span>
											</form>
										<?php } ?>
										</td>
																		
									</tr>						
									<script> 
									$(document).ready(function(){
										$('#submit_form<?php echo $count; ?>').hide(); 
										
										$("#savechanges<?php echo $count; ?>").click(function(){
											$("#submit_form<?php echo $count; ?>").show(); 
										});

									});
									</script>	
									<?php } ?>											
									</tbody>
								</table>	
							</div>
                    </div>
				</div>
			</div>	
	</div>
  </div>
</div>


<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable.php'); ?>