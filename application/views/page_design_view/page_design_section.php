<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('page_design_view/header') ?>
	<div id="main">
	<?php $adrep = $this->db->get_where('adreps',array('id'=>$this->session->userdata('ncId')))->result_array(); ?>
		<section>
		  <div class="container margin-top-40 center">                        
			
			<?php if($adrep[0]['pagedesign_ad']=='1'){  ?>
			   <a href="<?php echo base_url().index_page().'new_client/home/page_proceed';?>" class="btn btn-sm btn-dark btn-outline btn-active">Pagination</a>
			<?php } ?>
		  </div>
		</section>
		<!--<section>
			<div class="container margin-top-40 center">                        
			   <a href="<?php echo base_url().index_page()."new_client/home/page_proceed";?>" class="btn btn-sm btn-dark btn-outline btn-active width-equal">Page Design</a>
			</div>
		</section>-->
		
		<section>
			<div class="container margin-top-40">  
				<div class="row">
					<div class="col-xs-12 col-sm-2 col-md-2 col-md-offset-5 col-sm-offset-5  " >
					   <div class="progress">
						    <div class="progress-bar-border">
								<div class="progress-bar progress-bar-grey" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 50%" ></div>
							</div>
							<p>Step 1  <span class="pull-right">Step 2</span></p>
					   </div>
					</div>
				</div>		
				<form method="post" name="order_form" id="order_form" >
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-12">
						   	<p class="margin-bottom-5">Publication / Edition Name <span class="text-red">*</span></p>
						   	<input type="text" name="unique_job_name" class="form-control input-sm margin-bottom-15" title="" required="">
						</div>
						<div class="col-md-3 col-sm-3 col-xs-12">
						   	<p class="margin-bottom-5">Select Publish Date <span class="text-red">*</span></p>
						   	<div class="input-group date date-picker margin-bottom-15" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
								<input type="text" name="publish_date" class="form-control input-sm" required="" autocomplete="off">
								<span class="input-group-btn">
									<button class="btn btn-blue btn-sm" type="button" name="publish_date"><i class="fa fa-calendar"></i></button>
								</span>
							</div>
						</div>
						<div class="col-md-3 col-sm-3 col-xs-12">
						   <p class="margin-bottom-5">No. of Sections <span class="text-red">*</span></p>
						   <input type="number" name="No_of_pages" class="form-control input-sm margin-bottom-15" title="" required="" id="No_of_pages" min="1">
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 text-right margin-top-5">
							<div class="padding-top-15">
								<button type="submit" name="proceed" class="btn btn-sm btn-blue" id="submit_form" >Proceed to Step 2	</button>
							</div>	
						</div>
					</div>
				</form>
			</div>
	   </section>
	</div>
<?php $this->load->view('page_design_view/footer') ?>
<style>
	.progress{
		margin-bottom:70px;
	}
	.progress-bar-grey{
		background-color: grey;
		border-top-left-radius: 9px ;
		border-bottom-left-radius: 9px ;
	}
	
	.dropzone .dz-message { 
	 margin-top: 4%; 
	 margin-bottom: 4%; 
 } 

.font-12{
	font-size:12px;
}
textarea,
textarea::-webkit-textarea-placeholder {
    font-size: 12px !important;
   
}



.progress-bar-border{
	border:1px solid #aaa;
	height:20px;
	border-radius:15px;
	background-color: #aaa;
}
.progress-bar {
	text-align: center !important;
}
	
</style>