<?php $this->load->view('india_client/header'); ?>
<link href="<?php echo base_url(); ?>assets/india_client/css/dropzone/dropzone.css" type="text/css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/india_client/js/dropzone/dropzone.min.js"></script>

<style>
.file_li {
   // width: 350px;
	min-width: 250px;
   // overflow-x: hidden;
}
.min-height-155 {
	min-height: 155px;
}
</style>
											
<script>
	$(document).ready(function() {
	   function RefreshTable() {
		   $( "#mytable" ).load( "<?php echo base_url().index_page()."india_client/home/view_uploaded_files/".$order_details[0]['id'];?> #mytable" );
	   }
	   $("#view").on("click", RefreshTable);
	});
	
	
</script>




<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

		
<div id="main">
<!-- <form method="post">-->
<section>
    <div class="container margin-top-30"> 
		<div class="row border-bottom margin-0">	 
			<div class="col-md-6 col-sm-12 col-xs-12 margin-vertical-10 padding-0 text-grey">
				Adwitads Id : <?php echo $order_details[0]['id'];?> | Job Name : <?php echo $order_details[0]['job_no'];?>
			</div>
			
			
			<div class="col-md-6 col-sm-12 col-xs-12 margin-vertical-10 padding-0 text-right">
				<span class="margin-right-5 text-grey">
					<a href="<?php echo base_url().index_page().'india_client/home/dashboard';?>"><i class="fa fa-mail-reply padding-right-5 text-grey"></i></a> |
				</span>
				<span class="large margin-0 text-grey">
					<?php $action_name = $this->db->get_where('adrep_actions',array('id'=> $action_id))->result_array();
					   echo $action_name[0]['name'];
					 ?>
				</span>
				
				<span class="dropdown margin-left-5 text-grey">|
						<span class="cursor-pointer padding-left-5" type="button" data-toggle="dropdown" id="view">View Uploaded Files
						<span class="caret margin-left-5"></span></span>
													
						<div class="table-responsive dropdown-menu file_li ">  							 
								<table class="table table-striped table-hover" id="mytable">
								 <tbody>
								<?php if(isset($file_names)) { $i=1;  foreach($file_names as $row)  { ?>
									 <tr>
										<td><?php echo $i ?></td>
										<td><a href="#"><?php echo $row; 	$i++; ?></a></td>
										<!--<td><a href="<?php echo base_url().'downloads/'.$order_details[0]['id'].'/'.$row ?>" target="_blank"><i class="fa fa-download"></i></a></td>
									 --></tr>
								<?php  } }?> 
								</tbody>
							 </table>
						</div>
					</span>
			</div>
		</div>
	</div>
</section>

<?php if($action == "pickup") { ?>
<section id="pickup">
    <div class="container">
		<form method="post">	      
        <div class="row margin-top-30">
            <div class="col-md-6 col-sm-6 col-xs-12">
               <p class="margin-bottom-5">Publication Name <span class="text-red">*</span> </p>
               <input type="text" name="publication_name" class="form-control input-sm margin-bottom-15" title="" required>
               
               <p class="margin-bottom-5">New Unique Job Name <span class="text-red">*</span> </p>
               <input type="text" name="job_no" pattern="[a-zA-Z0-9 ]{1,50}" class="form-control input-sm margin-bottom-15" title="" required>
               
               <div class="row margin-bottom-15">
                  <div class="col-md-6 col-sm-6 col-xs-6"> 
					<p class="margin-bottom-5">New Width <span class="text-red">*</span> <small class="text-grey">(in cms)</small></p>
					<input type="text" name="width" pattern="[1-9]{1,50}" min="1" class="form-control input-sm" title="width" required>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-6">
					<p class="margin-bottom-5">New Height <span class="text-red">*</span> <small class="text-grey">(in cms)</small></p>
					<input type="text" name="height" pattern="[1-9]{1,50}" min="1" class="form-control input-sm" title="height" required>
				</div>
               </div> 
                
               <p class="margin-bottom-5">Full Color/B&amp;W/Spot<span class="text-red"> *</span></p>
               <div class="row  margin-bottom-5">
               <div class="col-sm-9">
                 <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-default btn-sm margin-right-15 margin-bottom-5">
                        <input type="radio" name="print_ad_type" value="1" required> Full Color
                    </label> 
                    <label class="btn btn-default btn-sm margin-right-15 margin-bottom-5">
                        <input type="radio" name="print_ad_type" value="2" required> B&amp;W
                    </label> 
                    <label class="btn btn-default btn-sm margin-right-15 margin-bottom-5 ">
                        <input type="radio" name="print_ad_type" value="3" required> Spot
                    </label>  
                  </div>
                </div>   
                </div>
				
			   <p class="margin-bottom-5">Job Instructions<span class="text-red"> *</span></p>
               <div class="row">
				   <div class="col-sm-9">
					 <div class="btn-group" data-toggle="buttons">
						<label class="btn btn-default btn-sm margin-right-15 margin-bottom-5">
							<input type="radio" name="job_instruction" value="1" required/> Follow Instructions Carefully
						</label> 
						<label class="btn btn-default btn-sm margin-right-15 margin-bottom-15">
							<input type="radio" name="job_instruction" value="2" required /> Be Creative
						</label>  
					  </div>
				   </div>   
				</div>
				
            </div>
            
            <div class="col-md-6 col-sm-6 col-xs-12">
				<p class="margin-bottom-5">Date needed <span class="text-red">*</span></p>	 
				<div class="input-group date date-picker margin-bottom-15" data-date-format="dd-mm-yyyy" data-date-start-date="+0d">
					<input type="text" class="form-control input-sm" readonly name="date_needed" required >
					<span class="input-group-btn">
					<button class="btn btn-blue btn-sm" type="button"><i class="fa fa-calendar"></i></button>
					</span>
				</div>
			
                <p class="margin-bottom-5">Copy/Content <span class="text-red">*</span> </p>
               <textarea rows="4" name="copy_content_description" class="form-control margin-bottom-15" title="" required></textarea>
               
               <p>Notes & Instructions</p>
               <textarea rows="4" name="notes" class="form-control" title=""></textarea> 
            </div>     
            
            <div class="col-md-12 col-sm-12 col-xs-12">
                <button type="submit" class="btn btn-primary btn-sm float-right  margin-top-20" name="pickup_submit">SUBMIT</button>
            </div> 
        </div> 
		</form>
    </div>
</section>
<?php } ?>

<?php if($action == "revision") { ?>
<section id="revision">
    <div class="container"> 
	<div class="row margin-top-30">
		<!--<form action="<?php echo base_url().index_page().'india_client/home/order_revision/'.$orderid; ?>" method="post" >-->
		<form  method="post" >
			<div class="col-md-6 col-sm-6 col-xs-12">
			   <p class="large margin-bottom-5">Notes & Instructions <span class="text-red">*</span></p>
			   <span id="show">
					<textarea name="notes" id="note" class="form-control margin-bottom-15 min-height-155" <?php if(isset($rev_sold_jobs)){ ?> readonly <?php }?>required>
					<?php if(isset($rev_sold_jobs)){ echo $rev_sold_jobs[0]['note'];}  ?> </textarea>
			   </span>
			   <?php if(empty($rev_sold_jobs)){ ?>
			   <button type="submit" class="btn btn-primary btn-md margin-top-5 margin-bottom-20 pull-right" name="rev_submit" id="hide">SUBMIT TO UPLOAD FILES</button>
			   <?php } ?>
			</div> 
			
		</form>
			<?php if(isset($rev_sold_jobs) && $rev_sold_jobs[0]['file_path'] != 'none' && file_exists($rev_sold_jobs[0]['file_path'])){  ?>
			<div class="col-md-6 col-sm-6 col-xs-12" id="show-drag">
			   <span class="large margin-bottom-10">Attach Files</span>
				
			 <form action="<?php echo base_url().index_page().'india_client/home/order_revision'.'/'.$rev_sold_jobs[0]['id']; ?>"  class="dropzone margin-top-5" > 
				<div class="dz-default dz-message margin-top-50"><span><strong>Choose a file</strong> or drag it here</span></div>
			</form>
			<a href="<?php echo base_url().index_page().'india_client/home'; ?>" name="submit" class="btn btn-primary btn-md margin-top-20 margin-bottom-20 pull-right">Submit</a>
			</div> 
			<?php } ?>
			
		</div> 
	</div>
</section>
<?php } ?>

<?php if($action == "attachments") { ?>
<section id="attachments">
    <div class="container"> 		
	    <div class="row margin-top-30">

			<div class="col-md-12 col-sm-12 col-xs-12">	
				<form action="<?php echo base_url().index_page().'india_client/home/additional_att'.'/'.$order_details[0]['id']; ?>"  class="dropzone" method="post"> 
					<div class="dz-default dz-message"><span><strong>Choose a file</strong> or drag it here</span></div>
				
			</div> 
				<div class="col-md-12 col-sm-12 col-xs-12 margin-top-20 text-right">	
				<button type="submit" name = "add_submit" class="btn btn-primary">Submit</button>
			</div>
			</form>
		</div> 
	</div>
</section>
<?php } ?>

<?php if($action == "QA") { ?>
<section id="answers" class="margin-bottom-30">
	<div class="container"> 		
		<div class="row margin-top-30">
			<div class="col-md-12">			
			<div class="border padding-10">
				
				<div class="row margin-0">
					<div class="col-md-11 col-sm-11 col-xs-11 padding-left-0">
						<p class=" padding-vertical-10 background-color-grey" >
							<span class="padding-10  radius-2">Question: Lorem Ipsum is simply dummy text dummy text of the printing.</span>
						</p>
					</div>
					<div class="col-md-1 col-sm-1 col-xs-1 padding-0">
						<p class="small padding-vertical-10 text-right" >9.48 AM</p>
					</div>
				</div>
				
				<div class="row margin-0">					
					<div class="col-md-1 col-sm-1 col-xs-1 padding-0">
						<p class="small padding-vertical-10" >9.48 AM</p>
					</div>
					<div class="col-md-11 col-sm-11 col-xs-11 padding-right-0">
						<p class=" padding-vertical-10 background-color-seablue text-right" >
							<span class="padding-10  radius-2">Answer: Lorem Ipsum is simply dummy text dummy text of the printing.</span>
						</p>
					</div>
				</div>
				
				<div class="row margin-0">
					<div class="col-md-11 col-sm-11 col-xs-11 padding-left-0">
						<p class=" padding-vertical-10 background-color-grey" >
							<span class="padding-10  radius-2">Question: Lorem Ipsum is simply dummy text dummy text of the printing.</span>
						</p>
					</div>
					<div class="col-md-1 col-sm-1 col-xs-1 padding-0">
						<p class="small padding-vertical-10 text-right" >9.48 AM</p>
					</div>
				</div>
				
				<div class="row margin-0">					
					<div class="col-md-1 col-sm-1 col-xs-1 padding-0">
						<p class="small padding-vertical-10" >9.48 AM</p>
					</div>
					<div class="col-md-11 col-sm-11 col-xs-11 padding-right-0">
						<p class=" padding-vertical-10 background-color-seablue text-right" >
							<span class="padding-10  radius-2">Answer: Lorem Ipsum has been the industry's standard dummy text ever since the 1500s has been the industry's standard</span>
						</p>
					</div>
				</div>
				
				<hr class="margin-0 padding-bottom-10">
				
				<div class="row">
	            <div class="col-md-10 col-sm-8 col-xs-8 padding-right-0">
				  <input type="text" class="form-control height-38 " title="" placeholder="Enter....">
				</div>
		         <div class="col-md-2 col-sm-4 col-xs-4 padding-left-0">
				  <button type="button" class="btn btn-dark btn-lg btn-block margin-right-15 "><span>Submit</span> </button>
				</div>
			 </div>
			</div>
		</div>
		</div>
	</div>
</section>
<?php } ?>

<?php if($action == "view") { ?>
<section id="view_sec">
    <div class="container"> 	
		<div class="row  margin-top-30">	
		
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="row padding-bottom-10">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<p class="padding-5 margin-0 large">Client Name</p>			
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<p class="padding-5 margin-0 text-grey"><?php echo $order_details[0]['advertiser_name'];?></p>	
					</div>
				</div>
				
				<div class="row padding-bottom-10">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<p class="padding-5 margin-0 large">Job Name</p>			
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<p class="padding-5 margin-0 text-grey"><?php echo $order_details[0]['job_no'];?></p>	
					</div>
				</div>
				
				<div class="row padding-bottom-10">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<p class="padding-5 margin-0 large">Publication Name</p>			
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<p class="padding-5 margin-0 text-grey"><?php echo $order_details[0]['publication_name'];?></p>	
					</div>
				</div>
				
				<div class="row padding-bottom-10">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<p class="padding-5 margin-0 large">Width & Height (In Inches)</p>			
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<p class="padding-5 margin-0 text-grey"><?php echo round($order_details[0]['width'],2)."X".round($order_details[0]['height'],2);?></p>	
					</div>
				</div>

				<div class="row padding-bottom-10">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<p class="padding-5 margin-0 large">Full Color/B&W/Spot</p>			
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<p class="padding-5 margin-0 text-grey">
						<?php if($order_details[0]['print_ad_type'] == '1')
							{ echo "Colour"; }
							elseif($order_details[0]['print_ad_type'] == '2')
							{ echo "B&W"; }
							else { echo "Spot"; } ?>
						</p>	
					</div>
				</div>
				
				<div class="row padding-bottom-10">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<p class="padding-5 margin-0 large">Date needed</p>			
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<p class="padding-5 margin-0 text-grey"><?php echo $order_details[0]['date_needed'];?></p>	
					</div>
				</div>
				
				<div class="row padding-bottom-10">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<p class="padding-5 margin-0 large">Job Instruction</p>			
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<p class="padding-5 margin-0 text-grey">
						 <?php if($order_details[0]['job_instruction'] == '1')
						{ echo "Follow Instructions Carefully"; }
							else { echo "Be Creative"; }
						  ?>
						</p>	
					</div>
				</div>
							
			</div>
					
			<div class="col-md-6">
				<div class="row padding-bottom-10">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<p class="padding-5 margin-0 large">Copy/Content</p>			
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<p class="padding-5 margin-0 text-grey"><?php echo $order_details[0]['copy_content_description'];?></p>	
					</div>
				</div>
				
				<div class="row padding-bottom-10">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<p class="padding-5 margin-0 large">Note & Instructions</p>			
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<p class="padding-5 margin-0 text-grey"><?php echo $order_details[0]['notes'];?></p>	
					</div>
				</div>
			</div>   
		</div>

	</div>
</section>
<?php } ?>
<!--</form>-->


<?php if($action == "native_files") { ?>
<section id="view_sec">
    <div class="container"> 	
		<div class="row  margin-top-30">	
		
			<div class="col-md-6 col-sm-6 col-xs-12">

					<!-- <div class="col-md-6 col-sm-6 col-xs-12">						
						<?php $order = $this->db->get_where('orders',array('id' => $orderid))->result_array();?>	
						<?php if($order!='' && isset($order[0]['id']))
						{
							$publication = $this->db->get_where('publications',array('id' => $order[0]['publication_id']))->result_array();
							$cat_result = $this->db->get_where('cat_result',array('order_no' => $orderid))->result_array();
							if(($order[0]['status']=='5' || $order[0]['status']=='7') && $cat_result[0]['source_path'] != 'none' && file_exists($cat_result[0]['source_path'])){
								$slug = $cat_result[0]['slug'];
				
								$sourcefilepath = $cat_result[0]['source_path'];
							$sourcefilepath = $sourcefilepath;
								}
						} ?>
								
					</div> -->
							<!--Source File Download -->
							<?php if($publication[0]['enable_source']=='1' && isset($sourcefilepath)){ 
							$this->load->helper('directory');
							$map2 = glob($sourcefilepath.'/'.$slug.'.{indd,psd}',GLOB_BRACE);	//source indd/psd
							if($map2){
							foreach($map2 as $row_map2){ $source_file = basename($row_map2); } 
							?>
												
							<form action="<?php echo base_url().'index.php/client/home/zip_folder_select'?>" method="post">
								<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
								<input name="new_slug" value="<?php echo $slug;?>" readonly style="display:none;" />
								<input name="source_path" value="<?php echo $sourcefilepath;?>" readonly style="display:none;" />
								<input name="download" value="download" readonly style="display:none;" />
								<button type="submit" name="SourceDownload" class="btn green">Download Package</button>
							</form>
						<?php } } ?>
	
				
				
							
			</div>
					
		
		</div>

	</div>
</section>
<?php } ?>
</div>
         
<?php $this->load->view('india_client/footer'); ?>
