<?php $this->load->view('india_client/header'); ?>

<script type="text/javascript" src="assets/india_client/css/pagination/datatables.min.js"></script>
<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		$('#example1').DataTable( {
			"order": [[ 0, "desc" ]]
		} );
	} );
				
	$(document).ready(function() {
		$('#example1').DataTable();
	} );
	
</script>
		
<section>
	<div class="container margin-top-40 center">                        
	 	<p class="xlarge">Revision Orders</p>  
    </div>
    <div class="container">
		<div class="row">
		<!--<div class="row border margin-15 padding-0">
		<form method="post" style="padding:0; margin:0;">
			<div class="col-md-3">
				<div class="input-group date date-picker margin-vertical-15" data-date-format="dd-mm-yyyy">
					<input type="text" name="from_dt" class="form-control" readonly name="datepicker" placeholder="From Date">
					<span class="input-group-btn">
					<button class="btn btn-blue" type="button"><i class="fa fa-calendar"></i></button>
					</span>
				</div>
			</div>
			<div class="col-md-3">
				<div class="input-group date date-picker margin-vertical-15" data-date-format="dd-mm-yyyy">
					<input type="text" name="to_dt" class="form-control" readonly name="datepicker" placeholder="To Date">
					<span class="input-group-btn">
					<button class="btn btn-blue" type="button"><i class="fa fa-calendar"></i></button>
					</span>
				</div>
			</div>
			<div class="col-md-2">
				<button type="Submit" name="submit" class="btn btn-blue margin-vertical-15" type="submit" value="Submit" />Submit</button>
			</div>
		</form>
		
			<div class="col-md-4 text-right">
				<input class="btn btn-blue margin-vertical-15" type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Export to Excel" />
			</div>
		</div>	-->
		
			<div class="col-md-12  margin-vertical-20">                        
				<div class="table-responsive border padding-15">     
					<table class="table table-striped table-bordered table-hover" id="example1">
						<thead>
							<tr>
								<th>Adwit Ads ID</th>
								<th>Unique Job ID</th>
								<th>Version</th>
								<th>Status</th>
								<th>PDF</th>
								<?php if($publication['enable_source']=='1' && isset($sourcefilepath)){ ?><th>Source</th><?php } ?>
							</tr>
						</thead>
						<tbody name="testTable" id="testTable">
							<?php if($order) {
							$order_status = $this->db->get_where('order_status',array('id'=>$order[0]['status']))->result_array();
							$pdf_path = $order[0]['pdf'];
							if(!file_exists($pdf_path)){
							$pdf_path = 'pdf_uploads/'.$order[0]['id'].'/'.$order[0]['pdf']; 
							}
							?>										
						<tr class="odd gradeX">
								<td><?php echo $order[0]['id']; ?></td>
								<td><?php echo $order[0]['job_no']; ?></td>
								<td><?php echo 'V1'; ?></td>
								<td><?php echo $order_status[0]['name']; ?></td>
								<td>
									<?php if($pdf_path != 'none' && file_exists($pdf_path)){ ?>
											<a onclick="window.open('<?php  echo base_url().$pdf_path; ?>')" style="cursor:pointer; text-decoration: none;"><i class="fa fa-file-pdf-o"></i></a>
									<?php } else{ echo ''; }?>
								</td>
								<!--Source File Download -->
												<?php if($publication['enable_source']=='1' && isset($sourcefilepath)){ 
														$this->load->helper('directory');
														$map2 = glob($sourcefilepath.'/'.$slug.'.{indd,psd}',GLOB_BRACE);	//source indd/psd
														if($map2){
															foreach($map2 as $row_map2){ $source_file = basename($row_map2); } 
												?>
												<td>
													<form action="<?php echo base_url().'index.php/india_client/home/zip_folder_select'?>" method="post">
														<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
														<input name="new_slug" value="<?php echo $slug;?>" readonly style="display:none;" />
														<input name="source_path" value="<?php echo $sourcefilepath;?>" readonly style="display:none;" />
														<input name="download" value="download" readonly style="display:none;" />
														<button type="submit" name="SourceDownload" class="btn green">Source Package</button>
													</form>
												</td>
											<?php } } ?>
							</tr> <?php } ?>
						<?php if($orders_rev)  {
							  foreach($orders_rev as $row){ 
							  $order_status = $this->db->get_where('rev_order_status',array('id'=>$row['status']))->result_array();
							  $pdf_path = $row['pdf_path'];
							  if(isset($sourcefilepath) && $row['status']=='5' && $row['source_file']!='none'){
								$source_file_path = $sourcefilepath.'/'.$row['source_file'];
								}
						?>    									
							<tr class="odd gradeX">
								<td><?php echo $row['order_id']; ?></td>
								<td><?php if(isset($order[0]['job_no'])) { echo $order[0]['job_no']; }  ?></td>
								<td><?php echo $row['version']; ?></td>
								<td><?php echo $order_status[0]['name']; ?></td>
								<td><?php if($pdf_path != 'none' && file_exists($pdf_path)){ ?>
											<a onclick="window.open('<?php  echo base_url().$row['pdf_path']; ?>')" style="cursor:pointer; text-decoration: none;"><i class="fa fa-file-pdf-o"></i></a>
									<?php } else{ echo ''; }?></td>
									<!--Source File Download -->
												<?php if($publication['enable_source']=='1' && $row['source_file']!='none' && isset($source_file_path) && file_exists($source_file_path)){ ?>
												<td>
													<form action="<?php echo base_url().'index.php/client/home/zip_folder_select'?>" method="post">
														<input name="source_file" value="<?php echo $row['source_file'];?>" readonly style="display:none;" />
														<input name="pdf_file" value="<?php echo $row['pdf_file'];?>" readonly style="display:none;" />
														<input name="new_slug" value="<?php echo $row['new_slug'];?>" readonly style="display:none;" />
														<input name="source_path" value="<?php echo $sourcefilepath;?>" readonly style="display:none;" />
														<input name="download" value="download" readonly style="display:none;" />
														<button type="submit" name="SourceDownload" class="btn green">Source Package</button>
													</form>
												</td>
												<?php }else{ echo'<td></td>'; } ?>
							</tr>
						<?php } } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
  
<?php $this->load->view('india_client/footer'); ?>
  

  