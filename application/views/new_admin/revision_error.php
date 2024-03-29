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
	
	$('#designer_id').change(function() {
	window.location = "<?php echo base_url().index_page().'new_admin/home/admin_report_production/'.$type.'/'.$user.'/';?>" + $('#designer_id').val() ;
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
			
	
			<div class="col-md-4 col-md-offset-4">	
				
			
				<!--------Revision Error Starts-------->
			<?php if((isset($type)) && ($type == 'error')) { ?>
				<div class="form-group has-success"></div>
			
				<div class="row">
					<div class="col-md-12 col-md-offset-1" >
					 <select id="custom_date" class="colorselector form-control " name="custom_date">
				   <option value="">Select</option>
					<option value="yesterday" <?php if($date=='yesterday') echo 'selected';?>>Yesterday</option>
					<option value="last_week" <?php if($date=='last_week') echo 'selected';?> >Last Week</option>
					<option value="last_month" <?php if($date=='last_month') echo 'selected';?>>Last Month</option>
					<option value="three_month" <?php if($date=='three_month') echo 'selected';?>>3 Month</option>
					<!--<option value="six_month" <?php if($date=='six_month') echo 'selected';?>>6 Month</option>-->
					<option value="one_year" <?php if($date=='one_year') echo 'selected';?>>1 Year</option>
					<option value="custom" <?php if($date=='custom') echo 'selected';?> >Custom</option>
					</select>
					</div>
					  </div>
				<form method="GET" autocomplete="off" action="<?php echo base_url().index_page().'new_admin/home/revision_error_report/'.$type.'/custom';?>">
					<div class="row " >
                        <div class="col-md-12 col-md-offset-1 colors margin-top-15" id="custom" style="display:none">
					  <div  class="input-group  date-picker input-daterange margin-bottom-15  " data-date="2012/11/10" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
						<!--<input type="text" name="order_type" value="2" style="display:none">-->
						<input type="text" class="form-control border-radius-left" name="from" placeholder="From Date" required/>
						<span class="input-group-addon"> to </span>
						<input type="text" class="form-control border-radius-right" name="to" placeholder="To Date" required/>
					</div>
					<div   class="margin-bottom-10  pull-right">
						<button type="submit"  class="btn bg-red-intense border-radius-5">Submit</button>
					</div>
					</div>
					
					</div>
					<div class="row " >
					<div  id="red" style="display:none" class="col-md-4 col-md-offset-5 left margin-bottom-10 colors ">
						<button type="submit" name="search" class="btn bg-red-intense border-radius-5">Submit2</button>
					</div>
					</div>
				
				
				</form>
				<?php } ?>
			
			
			<!--------Revision Error Ends------------->
			
			</div>
			</div>	
		</div>	 
	</div>

	<script>
 $(function() {
        $('.colorselector').change(function(){
            $('.colors').hide();
            $('#' + $(this).val()).show();
        });
    });
	
</script>	
<script>
$('#custom_date').change(function() {
		if($('#custom_date').val() != 'custom'){
			window.location = "<?php echo base_url().index_page().'new_admin/home/revision_error_report/'.$type.'/';?>" + $('#custom_date').val() ;
		}
	});
</script>
				
<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable.php'); ?>

