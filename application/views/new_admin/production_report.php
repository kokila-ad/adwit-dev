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

<script>
 $(document).ready(function(){
	if($('#adrep_id').val() != ''){ 
		$("#date_demo").show();
	} else {
		$("#date_demo").hide();
	}
	
	if($('#publication_id').val() != ''){ 
		$("#date_demo1").show();
	} else {
		$("#date_demo1").hide();
	}
	if($('#group_id').val() != ''){ 
		$("#date_demo2").show();
	} else {
		$("#date_demo2").hide();
	}
	if($('#csr_id').val() != ''){ 
		$("#cdate_demo").show();
	} else {
		$("#cdate_demo").hide();
	}
	if($('#ppcsr_id').val() != ''){ 
		$("#ppdate_demo").show();
	} else {
		$("#ppdate_demo").hide();
	}
	if($('#designer_id').val() != ''){ 
		$("#ddate_demo").show();
	} else {
		$("#ddate_demo").hide();
	}
	
	if($('#tl_id').val() !=''){
		$("#tldate_demo").show();
	} else {
		$("#tldate_demo").hide();
	}
	
	if($('#help_desk_id').val() != ''){ 
		$("#hdate_demo").show();
	} else {
		$("#hdate_demo").hide();
	}
	if($('#cgroup_id').val() != ''){ 
		$("#date_compare").show();
	} else {
		$("#date_compare").hide();
	}
	if($('#chd_id').val() != ''){ 
		$("#hd_date_compare").show();
	} else {
		$("#hd_date_compare").hide();
	}
	if($('#tl_hd_id').val() != ''){ 
		$("#tl_hd_date_compare").show();
	} else {
		$("#tl_hd_date_compare").hide();
	}
	
	$('#user_id').change(function() {
	window.location = "<?php echo base_url().index_page().'new_admin/home/admin_report_production/'.$type.'/';?>" + $('#user_id').val() ;
	});
	
	$('#adrep_id').change(function() {
	window.location = "<?php echo base_url().index_page().'new_admin/home/admin_report_production/'.$type.'/'.$user.'/';?>" + $('#adrep_id').val() ;
	});
	
	$('#publication_id').change(function() {
	window.location = "<?php echo base_url().index_page().'new_admin/home/admin_report_production/'.$type.'/'.$user.'/';?>" + $('#publication_id').val() ;
	});
	
	$('#group_id').change(function() {
	window.location = "<?php echo base_url().index_page().'new_admin/home/admin_report_production/'.$type.'/'.$user.'/';?>" + $('#group_id').val() ;
	});
	
	$('#csr_id').change(function() {
	window.location = "<?php echo base_url().index_page().'new_admin/home/admin_report_production/'.$type.'/'.$user.'/';?>" + $('#csr_id').val() ;
	});
	
	$('#csr_custom_date').change(function() {
		if($('#csr_custom_date').val() != 'custom'){
			window.location = "<?php echo base_url().index_page().'new_admin/home/report_csr_interval/'.$type.'/'.$user.'/'.$id.'/';?>" + $('#csr_custom_date').val() ;
		}
	});
	
	$('#designer_id').change(function() {
	window.location = "<?php echo base_url().index_page().'new_admin/home/admin_report_production/'.$type.'/'.$user.'/';?>" + $('#designer_id').val() ;
	});
	
	$('#design_custom_date').change(function() {
		if($('#design_custom_date').val() != 'custom'){
			window.location = "<?php echo base_url().index_page().'new_admin/home/report_designer_interval/'.$type.'/'.$user.'/'.$id.'/';?>" + $('#design_custom_date').val() ;
		}
	});
	
	$('#tl_id').change(function() {
	window.location = "<?php echo base_url().index_page().'new_admin/home/admin_report_production/'.$type.'/'.$user.'/';?>" + $('#tl_id').val() ;
	});
	
	$('#tl_custom_date').change(function() {
		if($('#tl_custom_date').val() != 'custom'){
			window.location = "<?php echo base_url().index_page().'new_admin/home/report_tl_interval/'.$type.'/'.$user.'/'.$id.'/';?>" + $('#tl_custom_date').val() ;
		}
	});
	
	$('#help_desk_id').change(function() {
	window.location = "<?php echo base_url().index_page().'new_admin/home/admin_report_production/'.$type.'/'.$user.'/';?>" + $('#help_desk_id').val() ;
	});
	
	$('#cgroup_id').change(function() {
	window.location = "<?php echo base_url().index_page().'new_admin/home/admin_report_production/'.$type.'/'.$user.'/';?>" + $('#cgroup_id').val() ;
	});
	
	$('#chd_id').change(function() {
	window.location = "<?php echo base_url().index_page().'new_admin/home/admin_report_production/'.$type.'/'.$user.'/';?>" + $('#chd_id').val() ;
	});
	$('#ppcsr_id').change(function() {
	window.location = "<?php echo base_url().index_page().'new_admin/home/admin_report_production/'.$type.'/'.$user.'/';?>" + $('#ppcsr_id').val() ;
	});
	
	$('#tl_hd_id').change(function() {
	window.location = "<?php echo base_url().index_page().'new_admin/home/admin_report_production/'.$type.'/'.$user.'/';?>" + $('#tl_hd_id').val() ;
	});
	
});
</script>

<div class="portlet light">
	<div class="portlet-body">		
		<div class="row">
			<div class="col-md-2 col-sm-6 margin-bottom-20 <?php if($type == 'production') echo 'active'; ?>">
				<a href="<?php echo base_url().index_page().'new_admin/home/report_designer_production/production/designer'?>" ><div class="option-theme5">Designer</div></a>
			</div>
			<div class="col-md-2 col-sm-6 margin-bottom-20 <?php if($type == 'production') echo 'active'; ?> ">
				<a href="<?php echo base_url().index_page().'new_admin/home/report_csr_production/production/csr'?>" ><div class="option-theme5">CSR</div></a>
			</div>
			<div class="col-md-2 col-sm-6 margin-bottom-20  <?php if($type == 'production') echo 'active'; ?>">
				<a href="<?php echo base_url().index_page().'new_admin/home/report_hd_production/production/help_desk'?>" ><div class="option-theme5">Helpdesk</div></a>
			</div>
			<div class="col-md-2 col-sm-6 margin-bottom-20  <?php if($type == 'production') echo 'active'; ?>">
				<a href="<?php echo base_url().index_page().'new_admin/home/teamwise_ad_volume'?>" ><div class="option-theme5">Team wise Ad Volume</div></a>
			</div>
			<div class="col-md-2 col-sm-6 margin-bottom-20">
				<a href="<?php echo base_url().index_page(). 'new_admin/home/others_report'; ?>"><div class="option-theme5">Others</div></a>
			</div> 
			
		</div>

		</div>	 
	</div>
</div>
	
				
<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable.php'); ?>

