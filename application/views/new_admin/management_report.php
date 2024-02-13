<?php $this->load->view('new_admin/header.php'); ?>
<style>
	.option-theme5 {
		border: 1px solid #444d58 !important;
		color: #444d58 !important;
	}
	
	.option-theme5:hover, .active .option-theme5 {
		background-color: #444d58;
		color: #fff !important;
	}
	.only_mob{
		display: none;
	}
	.mob_hide{
		display: block;
	}
	@media only screen and (max-width: 500px){
		.only_mob{
			display: block;
		}
		.mob_hide{
			display: none;
		}
	}
</style>

<script>
    function deskView() {
		$(".mob_hide input").attr('required', true);
		$(".only_mob input").attr('required', false);
	}
	function mobView() {
		$(".mob_hide input").attr('required', false);
		$(".only_mob input").attr('required', true);
	}
</script>



<div class="portlet light">
	<div class="portlet-body">		
		<div class="row">
			<div class="col-md-2 col-sm-6 margin-bottom-20 <?php if($type == 'verify') echo 'active'; ?>">
				<a href="<?php echo base_url().index_page().'new_admin/home/revision_verification/verify' ?>"><div class="option-theme5">Revision Verification </div></a>
			</div>
		
			<div class="col-md-2 col-sm-6 margin-bottom-20 <?php if($type == 'error') echo 'active'; ?>">
				<a href="<?php echo base_url().index_page().'new_admin/home/revision_error/error' ?>"><div class="option-theme5">Advocate Control Account</div></a>
			</div> 
			
			<div class="col-md-2 col-sm-6 margin-bottom-20 <?php if($type == 's_date') echo 'active'; ?>">
				<a href="<?php echo base_url().index_page().'new_admin/home/size_date/s_date' ?>"><div class="option-theme5">Size Report</div></a>
			</div> 
			
			<div class="col-md-2 col-sm-6 margin-bottom-20 ">
				<a href="<?php echo base_url().index_page().'new_admin/home/user_log' ?>"><div class="option-theme5">Users Log</div></a>
			</div> 
			
			<div class="col-md-2 col-sm-6 margin-bottom-20 ">
				<a href="<?php echo base_url().index_page().'new_admin/home/yearly_count_report' ?>"><div class="option-theme5">Yearly Count</div></a>
			</div>
			
			<div class="col-md-2 col-sm-6 margin-bottom-20 ">
				<a href="<?php echo base_url().index_page().'new_admin/home/rev_ratio' ?>"><div class="option-theme5">Revision Ratio</div></a>
			</div> 
		</div>
		<div class="row">
			<div class="col-md-2 col-sm-6 margin-bottom-20 ">
				<a href="<?php echo base_url().index_page().'new_admin/home/subject_classification' ?>"><div class="option-theme5">Publication Ad Subject</div></a>
			</div>
			
			<div class="col-md-2 col-sm-6 margin-bottom-20 ">
				<a href="<?php echo base_url().index_page().'new_admin/home/bill_report_publication_wise' ?>"><div class="option-theme5">Billing Report</div></a>
			</div>

			<div class="col-md-2 col-sm-6 margin-bottom-20 ">
				<a href="<?php echo base_url().index_page().'new_admin/home/scorecard' ?>"><div class="option-theme5">Scorecard</div></a>
			</div>
			
			<div class="col-md-2 col-sm-6 margin-bottom-20 ">
				<a href="<?php echo base_url().index_page().'new_admin/home/QandA' ?>"><div class="option-theme5">Q&A </div></a>
			</div>
			
			<div class="col-md-2 col-sm-6 margin-bottom-20 ">
				<a href="<?php echo base_url().index_page().'new_admin/home/rev_review' ?>"><div class="option-theme5"> Revision Review </div></a>
			</div>
			<div class="col-md-2 col-sm-6 margin-bottom-20 ">
				<a href="<?php echo base_url().index_page().'new_admin/home/category_by_designer' ?>"><div class="option-theme5"> Category By Designer </div></a>
			</div>
		</div>	
			
		</div>	 
	</div>
</div>
	
				
<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable.php'); ?>

