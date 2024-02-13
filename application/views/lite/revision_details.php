<?php $this->load->view("lite/head.php"); ?>
<?php $this->load->view("lite/header.php"); ?>
<div id="main">

<section>
    <div class="container margin-top-50">
		<div class="row">  		 
			<div class="col-md-7"><p>History</p></div>				   
			<div class="col-md-5 col-sm-12 col-xs-12 ">
				<form method="post" action="<?php echo base_url().index_page().'lite/home/order_search';?>"> 
					<div id="search">
					<div class="row">
						<div class="col-md-8 col-sm-8 col-xs-8 padding-right-0">
						  <input type="text" name="input" class="form-control border-blue input-sm" title="" placeholder="Enter Order ID, Job ID or Advertiser Name">
						</div>
						 <div class="col-md-4 col-sm-4 col-xs-4 padding-left-0">
						<button type="submit" name="search" class="btn btn-blue btn-sm btn-block margin-right-15">Search</button>
						</div>
					 </div>	
					  <p class="text-right margin-top-5"><a class="text-blue cursor-pointer" id="showadvancesearch">advanced search</a></p>
					 </div>
					 
					 <div class="row margin-0" id="advancesearch">
						<div class="col-md-12 col-sm-12 col-xs-12 background-color-blue padding-bottom-15">
						  <p class="padding-top-10 margin-bottom-5">Search Keywords</p>
						  <input type="text" name="keyword" class="form-control input-sm" title="" placeholder="Search order ID, Job ID  or Client Name">
						   <div class="row">
							  <div class="col-md-6 col-sm-6 col-xs-12 background-color-blue">
								<p class="padding-top-10 margin-bottom-5">From</p>
								<div class="input-group date date-picker margin-bottom-15" data-date-format="dd-mm-yyyy">
									<input type="text" name="from_dt" class="form-control input-sm" readonly name="datepicker">
									<span class="input-group-btn">
									<button class="btn btn-blue btn-sm" type="button"><i class="fa fa-calendar"></i></button>
									</span>
								</div>
							  </div>
							  <div class="col-md-6 col-sm-6 col-xs-12 background-color-blue">
								<p class="padding-top-10 margin-bottom-5">To</p>
								<div class="input-group date date-picker margin-bottom-15" data-date-format="dd-mm-yyyy">
									<input type="text" name="to_dt" class="form-control input-sm" readonly name="datepicker">
									<span class="input-group-btn">
									<button class="btn btn-blue btn-sm" type="button"><i class="fa fa-calendar"></i></button>
									</span>
								</div>
							  </div>	
						   </div>
							
						   <div class="row">
							   <div class="col-md-6 col-sm-6 col-xs-12 background-color-blue">
									<p class="padding-top-10 margin-bottom-5">Select Status</p>
									<select class="form-control input-sm" name="status">
										<option value="">Select</option>
										<?php $status = $this->db->get('order_status')->result_array();
										foreach($status as $row) { ?>
										<option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
										<?php } ?>
										<option>All</option>
									</select>
								  </div>
							  <div class="col-md-6 col-sm-6 col-xs-12 background-color-blue">
								<button type="submit" name="adv_search" class="btn btn-blue btn-sm margin-top-35 ">  <span>SUBMIT</span> </button>
								<span class="float-right margin-top-55 text-white"><a class="cursor-pointer text-blue" id="showsearch">&laquo back</a></span>
							  </div>	
						   </div>					   
						</div>
					 </div>	
				</form> 
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
								//note sent newad
								$note = $this->db->get_where('note_sent',array('order_id' => $order[0]['id'], 'revision_id' => '0'))->row_array();	
							?>	
						   <tr>
							   <td><?php echo $order[0]['id']; ?></td>
							   <td><?php echo $order[0]['job_no']; ?></td>
							   <td><?php echo 'V1'; ?></td>
							   <td><?php echo $order_status[0]['name']; ?></td>
							   <td><?php if($order[0]['pdf'] != 'none' && file_exists($pdf_path)){ ?>
										<a href="<?php echo base_url().$pdf_path ?>" data-toggle="tooltip" title="<?php if(isset($note['id'])){ echo $note['note']; }else{ echo"PDF"; } ?>" data-placement="top" target="_Blank" data-toggle="tooltip" title="PDF" ><img src="<?php echo base_url(); ?>assets/lite/img/pdf.png"></a>
									<?php }else{ echo ''; }?>
							   </td>
							   <td>
								   <!--Source File Download -->
							 <?php 	if($publication['enable_source']=='1' && $order[0]['source_del']=='1' && isset($ftp_source_path) && !isset($last_orders_rev['id'])) 	 
									{//ftp source path ?>
										<a href="<?php echo $ftp_source_path; ?>"><button class="btn green">Download</button></a>
								<?php }elseif($publication['enable_source']=='1' && isset($sourcefilepath)){ 
											$this->load->helper('directory');
											$map2 = glob($sourcefilepath.'/'.$slug.'.{indd,psd}',GLOB_BRACE);	//source indd/psd
											if($map2){
												foreach($map2 as $row_map2){ $source_file = basename($row_map2); } 
									?>	
									<form action="<?php echo base_url().'index.php/lite/home/zip_folder_select'?>" method="post">
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
		//note sent revision
		$note_rev = $this->db->get_where('note_sent',array('revision_id' => $row['id']))->row_array();
?>
							<tr>
								<td><?php echo $row['order_id']; ?></td>
								<td><?php echo $order[0]['job_no']; ?></td>
								<td><?php echo $row['version']; ?></td>
								<td><?php if($row['question']=='1'){ ?>
									<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'lite/home/rev_ad_answer/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;">
										<button class="btn tooltip-top" title="<?php echo $row['question']; ?>">Question</button>
									</a> 
								<?php }else{ echo $rev_status; }?>
								</td>
								<td><?php if($row['pdf_path']!='none' && file_exists($rev_path)){ ?>	
									<a href="<?php echo base_url().$rev_path ?>" data-toggle="tooltip" title="<?php if(isset($note_rev['id'])){ echo $note_rev['note']; }else{ echo"PDF"; } ?>" data-placement="top" target="_Blank" data-toggle="tooltip" title="PDF" ><img src="<?php echo base_url(); ?>assets/lite/img/pdf.png"></a>
									<?php  }else{ echo ''; } ?>
								</td>
								
								<!--Source File Download -->
								<td>
							 <?php  if($publication['enable_source']=='1' && $order[0]['source_del']=='1' && isset($ftp_source_path) && isset($last_orders_rev['id']) && $last_orders_rev['id']==$row['id'])
									{  //ftp source path
							 ?>
							<a href="<?php echo $ftp_source_path; ?>"><button class="btn green">Download</button></a>
							<?php }elseif($publication['enable_source']=='1' && $row['source_file']!='none' && isset($source_file_path) && file_exists($source_file_path)){ ?>
									<form action="<?php echo base_url().'index.php/lite/home/zip_folder_select'?>" method="post">
										<input name="source_file" value="<?php echo $row['source_file'];?>" readonly style="display:none;" />
										<input name="pdf_file" value="<?php echo $row['pdf_file'];?>" readonly style="display:none;" />
										<input name="new_slug" value="<?php echo $row['new_slug'];?>" readonly style="display:none;" />
										<input name="source_path" value="<?php echo $sourcefilepath;?>" readonly style="display:none;" />
										<input name="download" value="download" readonly style="display:none;" />
										<button type="submit" name="SourceDownload" class="btn btn-xs padding-5 btn-grey">Source Package</button>
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

<?php $this->load->view("lite/footer.php"); ?>
 <?php $this->load->view("lite/foot.php"); ?>	