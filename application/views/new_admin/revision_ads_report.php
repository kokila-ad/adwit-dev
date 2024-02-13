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
			<div class="col-md-2 col-sm-6 margin-bottom-20">
				<a href="<?php echo base_url().index_page().'new_admin/home/number_of_revision_by_category' ?>"><div class="option-theme5">Number Of Revision By Category</div></a>
			</div>
		</div>		
	</div>	 
</div>
</div>
	
				
<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable.php'); ?>

