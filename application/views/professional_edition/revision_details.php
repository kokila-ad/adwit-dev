<?php 
	$this->load->view('professional_edition/header');
?>
<div id="main">

<section>
    <div class="container margin-top-50">
		<div class="row">  		 
			<div class="col-md-7"><p>History</p></div>				   
			<div class="col-md-12 col-sm-12 col-xs-12 ">
				<?php $this->load->view('professional_edition/order_search') ; ?>
			</div>				 
		</div>	 
	 </div>
</section>


<section>
    <div class="container"> 
		<div class="row">	 			  
			  <div class="col-md-12 margin-top-20">
				 <div class="table-responsive border padding-15">     
					<table class="table table-striped table-bordered table-hover" id="example1">
						<thead>
							<tr>
								<td>AdwitAds ID</td>
								<td>Unique Job ID</td>
								<td>Version</td>
								<td>Status</td>
								<td>PDF</td>
								<td>Source</td>
							</tr>  									
						</thead>
						<tbody>	
							<?php
								$order_status = $this->db->get_where('order_status',array('id'=>$order[0]['status']))->result_array();
								$pdf_path = $order[0]['pdf'];
								if(!file_exists($pdf_path)){
									$pdf_path = 'pdf_uploads/'.$order[0]['id'].'/'.$order[0]['pdf']; 
								}	
							?>	
						   <tr>
							   <td><?php echo $order[0]['id']; ?></td>
							   <td><?php echo $order[0]['job_no']; ?></td>
							   <td><?php echo 'V1'; ?></td>
							   <td><?php echo $order_status[0]['name']; ?></td>
							   <td><?php if($order[0]['pdf'] != 'none' && file_exists($pdf_path)){ ?>
										<a href="<?php echo base_url().$pdf_path ?>" target="_Blank" data-toggle="tooltip" title="PDF" ><img src="<?php echo base_url(); ?>assets/professional_edition/img/pdf.png"></a>
									<?php }else{ echo ''; }?>
							   </td>
							   <td>
								   <!--Source File Download -->
									<?php if($publication['enable_source']=='1' && isset($sourcefilepath)){ 
											$this->load->helper('directory');
											$map2 = glob($sourcefilepath.'/'.$slug.'.{indd,psd}',GLOB_BRACE);	//source indd/psd
											if($map2){
												foreach($map2 as $row_map2){ $source_file = basename($row_map2); } 
									?>	
									<form action="<?php echo base_url().'index.php/professional_edition/home/zip_folder_select'?>" method="post">
										<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
										<input name="new_slug" value="<?php echo $slug;?>" readonly style="display:none;" />
										<input name="source_path" value="<?php echo $sourcefilepath;?>" readonly style="display:none;" />
										<input name="download" value="download" readonly style="display:none;" />
										<button type="submit" name="SourceDownload" class="btn btn-blue btn-sm">Source Package</button>
									</form>
									<?php } } ?>
							   </td>
						  </tr>
<?php
	foreach($orders_rev as $row){
		$source_file_path='none';
		$rev_status = 'Revision Submitted';
		if($row['new_slug']!='none'){ $rev_status = 'In Production'; }
		if($row['pdf_path']!='none'){ 
			$rev_status = 'Proof Ready';
			$rev_path = $row['pdf_path'];
			if(!file_exists($pdf_path)){ $rev_path = $row['pdf_path'].'/'.$row['pdf_file']; }
		}
		if(isset($sourcefilepath) && $row['status']=='5' && $row['source_file']!='none'){
			$source_file_path = $sourcefilepath.'/'.$row['source_file'];
		}
		
?>
							<tr>
								<td><?php echo $row['order_id']; ?></td>
								<td><?php echo $order[0]['job_no']; ?></td>
								<td><?php echo $row['version']; ?></td>
								<td><?php if($row['question']=='1'){ ?>
									<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'professional_edition/home/rev_ad_answer/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;">
										<button class="btn tooltip-top" title="<?php echo $row['question']; ?>">Question</button>
									</a> 
								<?php }else{ echo $rev_status; }?>
								</td>
								<td><?php if($row['pdf_path']!='none' && file_exists($rev_path)){ ?>	
									<a href="<?php echo base_url().$rev_path ?>" target="_Blank" data-toggle="tooltip" title="PDF" ><img src="<?php echo base_url(); ?>assets/professional_edition/img/pdf.png"></a>
									<?php  }else{ echo ''; } ?>
								</td>
								
								<!--Source File Download -->
								<td>
									<?php if($publication['enable_source']=='1' && $row['source_file']!='none' && isset($source_file_path) && file_exists($source_file_path)){ ?>
									<form action="<?php echo base_url().'index.php/professional_edition/home/zip_folder_select'?>" method="post">
										<input name="source_file" value="<?php echo $row['source_file'];?>" readonly style="display:none;" />
										<input name="pdf_file" value="<?php echo $row['pdf_file'];?>" readonly style="display:none;" />
										<input name="new_slug" value="<?php echo $row['new_slug'];?>" readonly style="display:none;" />
										<input name="source_path" value="<?php echo $sourcefilepath;?>" readonly style="display:none;" />
										<input name="download" value="download" readonly style="display:none;" />
										<button type="submit" name="SourceDownload" class="btn btn-blue btn-sm">Source Package</button>
									</form>
									<?php } ?>
								</td>
							</tr> 
<?php } ?>							
					  </tbody>         
					</table>
				</div>
			</div>
	   </div>
   </div>
</section>

</div>

<?php 
	$this->load->view('professional_edition/footer');
?>
