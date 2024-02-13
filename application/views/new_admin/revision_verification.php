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
			 <div class="col-md-4 col-md-offset-4">
		
			<!--------Revision Verification Starts-------->
			<?php if((isset($type)) && ($type == 'verify')) { ?>
				<div class="form-group has-success"></div>
			<!---Verify Report starts--->
				
				
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
				<form method="GET" autocomplete="off" action="<?php echo base_url().index_page().'new_admin/home/revision_verify_report/'.$type.'/custom';?>">
					<div class="row " >
                        <div class="col-md-12 col-md-offset-1 colors margin-top-15" id="custom" style="display:none">
					  <div  class="input-group  date-picker input-daterange margin-bottom-15 "  data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
						<!--<input type="text" name="order_type" value="2" style="display:none">-->
						<input type="text" class="form-control border-radius-left" name="from" placeholder="From Date" required/>
						<span class="input-group-addon"> to </span>
						<input type="text" class="form-control border-radius-right" name="to" placeholder="To Date" required/>
					</div>
					<div class="margin-bottom-10  pull-right">
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
			<!--- Verify Report ends--->
			
			<!--------Revision Verification Ends------------->
			
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
			window.location = "<?php echo base_url().index_page().'new_admin/home/revision_verify_report/'.$type.'/';?>" + $('#custom_date').val() ;
		}
	});
</script>
				
<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable.php'); ?>

