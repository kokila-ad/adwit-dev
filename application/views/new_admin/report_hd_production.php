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
	
	if($('#help_desk_id').val() != ''){ 
		$("#hdate_demo").show();
	} else {
		$("#hdate_demo").hide();
	}
	
	
	$('#user_id').change(function() {
	window.location = "<?php echo base_url().index_page().'new_admin/home/report_hd_production/'.$type.'/';?>" + $('#user_id').val() ;
	});
	
	
	$('#help_desk_id').change(function() {
	window.location = "<?php echo base_url().index_page().'new_admin/home/report_hd_production/'.$type.'/'.$user.'/';?>" + $('#help_desk_id').val() ;
	});

});
</script>

<div class="portlet light">
	<div class="portlet-body">		
		<div class="row">
			
			
		<div class="col-md-4 col-md-offset-4">	
		
				
		<?php if((isset($type)) && ($type == 'production')) { ?>
			<div class="form-group has-success">
				<select id="user_id" name="user_id" class="select2me form-control">
					<option value="">Select</option>
				
					<option value="help_desk" <?php if($user=='help_desk') echo 'selected';?> >Helpdesk</option>
				</select>
			</div>
			
			
			<!---Helpdesk Report starts--->
			<?php if(isset($help_desk)) { ?>
				<form method="GET" action="<?php echo base_url().index_page().'new_admin/home/report_sales_hd/'.$type.'/'.$user;?>">
					<select id="help_desk_id" name="help_desk_id" class="select2me form-control margin-bottom-10 border-radius-5">
						<option value="">Select</option>
						<option value="all" <?php if($id=='all') echo 'selected';?>>All</option>
						<?php foreach($help_desk as $row) { ?>
						<option value="<?php echo $row['id']?>" <?php if($id == $row['id']) echo 'selected';?> ><?php echo $row['name']; ?></option>
						<?php } ?>
					</select>
					<div id="hdate_demo">
						<div class="input-group  date-picker input-daterange margin-bottom-15" data-date="2012/11/10" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
							<input type="text" class="form-control border-radius-left" name="from" placeholder="From Date" required/>
							<span class="input-group-addon">
							to </span>
							<input type="text" class="form-control border-radius-right" name="to" placeholder="To Date" required/>
						</div>
						
						<div class="margin-bottom-10 pull-right">
							<button type="submit" name="search" class="btn bg-red-intense border-radius-5">Submit</button>
						</div>
					</div>
				</form>
			<?php } ?>
			<!---Helpdesk Report ends--->
		<?php } ?>
	
				
			
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
				
<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable.php'); ?>

