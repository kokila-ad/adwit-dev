<?php $this->load->view("new_admin/header"); ?>

<div class="page-container">
	<div class="page-content" style="min-height: 603px;">
		<div class="container">	
<div class="border-bottom margin-bottom-20">
	<div class="portlet-title">
	<div class="row">
	<div class="caption margin-bottom-30" style= "color:black;font-size: 13px;text-align:center;">
		<span><?php $f = strtotime($from) ; $t = strtotime($to); echo "From "." - ".date('M d, Y', $f)." ". "  To " . " - " .date('M d, Y', $t);?> </span>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-2 col-xs-9 margin-bottom-10 pull-right" style=" text-align: right;">
	
		<button class="btn bg-grey btn-xs" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
	
		
	</div>
	<div class="col-md-10 col-xs-12 margin-bottom-10 font-lg font-grey-gallery">
	
	<div class="row">
	<form method="GET" autocomplete="off" action="<?php echo base_url().index_page().'new_admin/home/advocate_w_m_report'.'/custom';?>">
	<div class="col-md-8">
	<div id="custom" style="display:none" class=" colors custom  " >
		<div class="col-md-12 col-lg-10 col-sm-6 col-xs-12 ">
			<div class=" input-group date-picker input-daterange " data-date="2012/11/10" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
				<input type="text" class="form-control border-radius-left" name="from" value="" placeholder="From Date" required="">
				<span class="input-group-addon">
				to </span>
				<input type="text" class="form-control border-radius-right" name="to" value="" placeholder="To Date" required="">
			</div>
		</div>
	<div class="col-md-4 col-lg-2 col-sm-6 col-xs-12 ">
		<button type="submit"  name= "search" class="btn btn-danger ">Submit </button>
	</div>
	</div>
	</div>
	<div class="col-md-4">
	<select id="custom_date" name="custom_date"class="colorselector form-control margin-left-20" >
			<option value="yesterday" <?php if($date=='yesterday') echo 'selected';?>>Yesterday</option>
			<option value="last_week" <?php if($date=='last_week') echo 'selected';?> >Last Week</option>
			<option value="last_month" <?php if($date=='last_month') echo 'selected';?>>Last Month</option>
			<option value="three_month" <?php if($date=='three_month') echo 'selected';?>>3 Month</option>
			<option value="six_month" <?php if($date=='six_month') echo 'selected';?>>6 Month</option>
			<option value="one_year" <?php if($date=='one_year') echo 'selected';?>>1 Year</option>
			<option value="custom" <?php if($date=='custom') echo 'selected';?> >Custom</option>
	</select>
	</div>
	</form>
	</div>
</div>
</div>
	</div>
	</div>
	<div class="portlet-body" id="red"  class="colors red">	
		<table class="table table-striped table-bordered table-hover" id="sample_6">
			<thead>
				<tr>
					<th>AdwitAds <br>ID</th>
					<th>DTL </th>
					<th>Des</th>
					<th>Des<br>Code</th>
					<th>PRF</th>
					<th>PRF<br>Code</th>
					<th>Rov <br>CSR</th>
					<th>Hybrid <br> Designer</th>
					<th>Feedback</th>
					<th>The Reply</th>
					<th>Complaint</th>
					<th>Avoidable</th>
					<th>Design</th>
					<th>Ad note <br> not sent</th>
					<th>Compliment</th>
					<th>Error</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($report as $order_row){
					$error_arr = explode(',',$order_row['verification_type']);	
			?>
			
			<tr>
				<td><?php echo $order_row['order_id'];?></td>
				<td><?php if(isset($order_row['tl_name']))echo $order_row['tl_name'];?></td>
				<td><?php if(isset($order_row['d_name'])){echo $order_row['d_name'];}?></td>
				<td><?php if(isset($order_row['du_name'])){echo $order_row['du_name'];}?></td>
				<td><?php if(isset($order_row['c_name']))echo $order_row['c_name'];?></td>
				<td><?php if(isset($order_row['cu_name']))echo $order_row['cu_name'];?></td>
				<td><?php if(isset($order_row['r_name']))echo $order_row['r_name'];?></td>
				<td><?php if(isset($order_row['hi_b_name']))echo $order_row['hi_b_name'];?></td>
				<td><?php echo $order_row['note'];?></td>
				<td>
					<div style="background-color:white; border:1px solid #e5e5e5;border-radius: 4px; padding: 8px; " class ="  margin-bottom-10 ">
				
					<?php if(isset($order_row['designer_id']) && $order_row['designer_id'] != '0' && $order_row['designer_reply'] != NULL ) {  ?>
						<p><?php echo $order_row['designer_reply']; ?> - <?php echo $order_row['d_name']; ?> <b>(Designer)</b> </p>
								
					</div>
							
							<?php } ?> 
							
							<?php if(isset($order_row['tl_designer_id']) && $order_row['tl_designer_id'] != '0' && $order_row['dtl_reply'] != NULL ) {  ?>
							<div class="row">
							<div class="col-sm-6">
								<?php echo $order_row['dtl_reply']; ?>
							</div>
							<div class="col-sm-6 text-right">
								<p><?php echo $order_row['tl_name']; ?> <b>(D Team Lead)</b> </p>
								<p class="font-grey-cascade"> </p>
							</div>
							</div>
							<?php }?>
							
							<?php if(isset($order_row['hi_b_designer_id']) && $order_row['hi_b_designer_id'] != '0' && $order_row['hi_b_designer_reply'] != NULL ) { //hi_b_designer ?>
							<div class="row">
							<div class="col-sm-6">
								<?php echo $order_row['hi_b_designer_reply']; ?>
							</div>
							<div class="col-sm-6 text-right">
								<p><?php echo $order_row['hi_b_name']; ?> <b>(Hybrid Designer)</b> </p>
								<p class="font-grey-cascade"> </p>
							</div>
							</div>
							<?php }?>
							
							<?php if(isset($order_row['csr_id']) && $order_row['csr_id'] != '0' && $order_row['csr_id'] != NULL && $order_row['csr_reply'] != NULL ){ ?>
							<div class="row">
							<div class="col-sm-6">
								<?php echo $order_row['csr_reply']; ?>
							</div>
							<div class="col-sm-6 text-right">
								<p><?php echo $order_row['c_name']; ?> <b> (Proof Reader)</b> </p>
								<p class="font-grey-cascade"> </p>
							</div>
							</div>
							<?php }?>
							
							<?php if(isset($order_row['rov_csr_id']) && $order_row['rov_csr_id'] != '0' &&  $order_row['rov_csr_id'] != NULL  && $order_row['rov_csr_reply'] != NULL ){ ?>
							<div class="row">
							<div class="col-sm-6">
								<?php echo $order_row['rov_csr_reply']; ?>
							</div>
							<div class="col-sm-6 text-right">
								<p><?php echo $order_row['r_name']; ?> <b> (Rov CSR)</b> </p>
								<p class="font-grey-cascade"> </p>
							</div>
							</div>
							<?php }?>
					</div>		
					</td>
				<td><?php if(in_array(1,$error_arr)) echo 'Complaint'; ?></td>
				<td><?php if(in_array(2,$error_arr)) echo 'Avoidable'; ?></td>
				<td><?php if(in_array(3,$error_arr)) echo 'Design'; ?></td>
				<td><?php if(in_array(4,$error_arr)) echo 'Ad note not sent'; ?></td>
				<td><?php if(in_array(5,$error_arr)) echo 'Compliment'; ?></td>
				<td><?php if($order_row['error'] == '1'){echo 'Yes';}?></td>
			</tr>
			
			<?php }?>
			</tbody>	
		</table>
	</div>
</div>
</div>
</div>
</div>
<script>
 $(function() {
        $('.colorselector').change(function(){
            $('.colors').hide();
            $('.' + $(this).val()).show();
        });
    });
</script>
<script>
$('#custom_date').change(function() { 
		if($('#custom_date').val() != 'custom'){
			window.location = "<?php echo base_url().index_page().'new_admin/home/advocate_w_m_report/'?>" + $('#custom_date').val() ;
		}
	});
</script>
<?php $this->load->view("new_admin/footer"); ?>
<?php $this->load->view('new_admin/datatable.php'); ?>