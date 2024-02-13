<?php
       $this->load->view("new_client/header");
?>

<div id="main">

<section>
    <div class="container margin-top-50"> 
		  <form method="post" action=""> 
				    <div class="row">  		 
						  <div class="col-md-7">
								<p>History</p>
						  </div>
					   
						   <div class="col-md-5 col-sm-12 col-xs-12">
							<div id="search">
							<div class="row">
								<div class="col-md-8 col-sm-8 col-xs-8 padding-right-0">
								  <input type="text" name="input" class="form-control border-blue input-sm" title="" placeholder="Type order ID, Job ID or Client Name">
								</div>
								 <div class="col-md-4 col-sm-4 col-xs-4 padding-left-0">
								<button type="submit" name="search" class="btn btn-blue btn-sm btn-block margin-right-15">Search</button>
								</div>
							 </div>	
							  <p class="text-right margin-top-5 margin-0" ><a href="#" class="text-blue" id="showadvancesearch">advanced search</a></p>
							 </div>
							 
							 <div class="row margin-0" id="advancesearch" style="display: none;">
								<div class="col-md-12 col-sm-12 col-xs-12 background-color-blue padding-bottom-15">
								  <p class="padding-top-10 margin-bottom-5">Search Keywords</p>
								  <input type="text" name="keyword" class="form-control input-sm" title="" placeholder="Search order ID, Job ID  or Client Name">
								  
								   <div class="row">
									  <div class="col-md-6 col-sm-6 col-xs-12 background-color-blue">
										<p class="padding-top-10 margin-bottom-5">From</p>
										<div class="input-group date date-picker margin-bottom-15" data-date-format="dd-mm-yyyy">
											<input type="text" name="from_dt" class="form-control input-sm" readonly="">
											<span class="input-group-btn">
											<button class="btn btn-blue btn-sm" type="button"><i class="fa fa-calendar"></i></button>
											</span>
										</div>
									  </div>
									  
									  <div class="col-md-6 col-sm-6 col-xs-12 background-color-blue">
										<p class="padding-top-10 margin-bottom-5">To</p>
										<div class="input-group date date-picker margin-bottom-15" data-date-format="dd-mm-yyyy">
											<input type="text" name="to_dt" class="form-control input-sm" readonly="">
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
											<option>All</option>
											<option value="1">Order Received</option>
											<option value="2">Order Accepted</option>
											<option value="3">IN Production</option>
											<option value="4">Quality Check</option>
											<option value="5">Proof Ready</option>
											<option value="6">Cancelled </option>
											<option value="7">Approved</option>
										</select>
									  </div>
									  <div class="col-md-6 col-sm-6 col-xs-12 background-color-blue">
										<button type="submit" name="adv_search" class="btn btn-blue btn-sm margin-top-35 ">  <span>Submit</span> </button>
										<span class="float-right margin-top-55 text-white"><a href="#" class="text-blue" id="showsearch">« back</a></span>
									  </div>	
								   </div>					   
								</div>
							 </div>			 
						 </div>					 
					</div>	 
		  </form> 
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
								<td>Adwit Ads ID</td>
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
										<a href="<?php echo base_url().$pdf_path ?>" target="_Blank" data-toggle="tooltip" title="PDF" ><img src="<?php echo base_url(); ?>assets/new_client/img/pdf.png"></a>
									<?php }else{ echo ''; }?>
							   </td>
							   <!--Source File Download -->
								<?php if($publication['enable_source']=='1' && isset($sourcefilepath)){ 
										$this->load->helper('directory');
										$map2 = glob($sourcefilepath.'/'.$slug.'.{indd,psd}',GLOB_BRACE);	//source indd/psd
										if($map2){
											foreach($map2 as $row_map2){ $source_file = basename($row_map2); } 
								?>	
							   <td>
								<form action="<?php echo base_url().'index.php/new_client/home/zip_folder_select'?>" method="post">
									<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
									<input name="new_slug" value="<?php echo $slug;?>" readonly style="display:none;" />
									<input name="source_path" value="<?php echo $sourcefilepath;?>" readonly style="display:none;" />
									<input name="download" value="download" readonly style="display:none;" />
									<button type="submit" name="SourceDownload" class="btn btn-xs padding-5 btn-grey">Source Package</button>
								</form>
							   </td>
							   <?php } } ?>
							</tr>
					  </tbody>         
					</table>
				 </div>
			 </div>
	  	  </div>
        </div>
	</div>
</section>
</div>

<?php
       $this->load->view("new_client/footer");
?>
