<?php $this->load->view('new_admin/header.php'); ?>

<script>
$(document).ready(function(){	    
	$(".dropdown-checkboxes").hide();	
	$('.date-picker').click(function() {
		$(".cursor-pointer").addClass(" filter ");
	});	
	$('#filter').click(function() {
		$(".dropdown-checkboxes").toggle();
	});
	

/*	$("#hd_select").hide();
	
	$("#hd_select").change(function(){
		$("#hd_select").toggle();
		$("#hd_select").hide();
	});*/
	
	
});
</script>

<style>
.table-scrollable {
    width: 50%;
    overflow-x: auto;
    overflow-y: hidden;
    border: 1px solid #dddddd;
    margin: 10px 0 !important;
}
</style>
<!-- BEGIN PAGE CONTAINER -->

<div class="portlet light">
	<div class="portlet-title">
	<div class="row">	
		<div class="col-md-6 col-xs-12 margin-bottom-10 font-lg font-grey-gallery">
			<a href="" class="font-grey-gallery">Others(%) Report</a> 
			<?php if($designer_id != 'all') { echo '- '.$designers[0]['name'] ; }?>-
			<?php if(isset($from) && isset($to)){echo date('M d, Y ',strtotime($from))." to ".date('M d, Y',strtotime($to));}elseif(isset($today)){echo date('M d, Y',strtotime($today));} ?>
		</div>
			<div class="col-md-6 col-xs-9 text-right ">	
			<button class="btn bg-grey btn-xs" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
			<span class="cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
		</div>
	</div>
	</div>
	<div class="portlet-body " >
		<?php if($designer_id == 'all') { ?>
			<table class="table table-bordered table-hover" id="sample_6">
			<?php } else { ?>
		
				<table class="table table-bordered table-hover" id="sample_6"><?php } ?> 
				<thead>					
					<tr>
						<th>Name</th>
						<th>Code</th>
						<th>Others(%)</th>
					</tr>
				</thead>
				<tbody> 
				<?php $tot_job_count = 0; $tot_total_QA = 0; $tot_pub_nj = 0; $tot_dp_sft = 0; $tot_cat_a = 0; $tot_cat_b = 0;$tot_cat_c = 0;
				  $tot_cat_d = 0; $tot_cat_e = 0; $tot_cat_f = 0; $tot_cat_g = 0; $tot_cat_rev = 0; $tot_cat_sold = 0;$total_error = 0; $total_err = 0;
				  if($designer_id == 'all'){ 
						$data['designers'] = $this->db->query("SELECT * FROM `designers` WHERE `is_active` = '1'")->result_array();
						
					}else{
						$data['designers'] = $this->db->query("SELECT * FROM `designers` WHERE `id` = '".$_GET['designer_id']."'")->result_array();
						
					}
				  
				  foreach($designers as $row)
				  {	
					$dp_sft = 0; $pub_nj = 0; $job_count = 0; $sq_inches = 0; $total_QA = 0;
					$cat_a = 0; $cat_b = 0; $cat_c = 0; $cat_d = 0; $cat_e = 0; $cat_f = 0; $cat_g = 0; $cat_rev = 0; $cat_sold = 0; $error=0; $error_rev=0;
					$error_rev_count = 0; $new_reason = 0; $rev_reason = 0;
					
					$cat_result = 	$this->db->query("SELECT `id`,`order_no`,`shift_factor`,`height`,`width`,`slug`,`category` FROM `cat_result` WHERE  `designer`='".$row['id']."' AND `ddate` BETWEEN '$from 00:00:00' AND '$to 23:59:59' ;")->result_array();
					
					$additional_hrs = $this->db->query("SELECT * FROM `designer_additional_hours` WHERE  `designer` = '".$row['id']."' AND `status`='approved' AND `date` BETWEEN '$from 00:00:00' AND '$to 23:59:59' ;")->result_array();
					
					$rev_sold = $this->db->query("SELECT `id`,`order_id`,`category`,`designer`,`version` FROM `rev_sold_jobs` WHERE  `designer` = '".$row['id']."' AND `date` BETWEEN '$from 00:00:00' AND '$to 23:59:59' ;")->result_array();
				
					
					foreach($cat_result as $row2)
					{
					
						$w_h = 0;
						$category = $this->db->get_where('print',array('name' => $row2['category']))->result_array();
						$pub_nj = $pub_nj + $category[0]['wt'];
						if($row2['shift_factor']!='0'){
							if($additional_hrs){
								$dp_sft = $dp_sft + ($category[0]['wt'] / ($row2['shift_factor'] + $additional_hrs[0]['hours'])); //new job DP calculation (dp=nj/(shift_factor+$additional_hrs))
							}else{
								$dp_sft = $dp_sft + ($category[0]['wt'] / $row2['shift_factor']); //new job DP calculation (dp=nj/shift_factor)
							}
						}
						/* New Reason Id*/
						$jobs = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id` = '".$row2['order_no']."' AND `order_no` = '".$row2['slug']."'")->result_array();
						if(isset($jobs[0]['id'])){
							foreach($jobs as $job_row){
								$rev_order_reason = $this->db->query("SELECT * FROM `rev_order_reason` WHERE `rev_id` = '".$job_row['id']."' AND `reason_id` = '3'")->result_array();
								$new_reason = $new_reason + count($rev_order_reason);
								
							}
						}
						$job_count++;
						
						$w_h = isset($row2['width']) * isset($row2['height']);
                        //$w_h = $row2['width'] * $row2['height'];
						$sq_inches = $sq_inches + $w_h;
						
						if($row2['category'] == 'P')
						{
							$cat_a++;
						}
						if($row2['category'] == 'M')
						{
							$cat_b++;
						}
						if($row2['category'] == 'N')
						{
							$cat_c++;
						}
						if($row2['category'] == 'T')
						{
							$cat_d++;
						}
						if($row2['category'] == 'W')
						{
							$cat_e++;
						}
					}	
			
					if($rev_sold)
					{	
						foreach($rev_sold as $row3)
						{
							$version = $row3['version'];
							if($version == 'V1a'){ $version = 'V1b'; }
							elseif($version == 'V1b'){ $version = 'V1c'; }
							elseif($version == 'V1c'){ $version = 'V1d'; }
							elseif($version == 'V1d'){ $version = 'V1e'; }
							elseif($version == 'V1e'){ $version = 'V1f'; }
							elseif($version == 'V1f'){ $version = 'V1g'; }
							elseif($version == 'V1g'){ $version = 'V1h'; }
							elseif($version == 'V1h'){ $version = 'V1i'; }
							elseif($version == 'V1i'){ $version = 'V1j'; }
							elseif($version == 'V1j'){ $version = 'V1k'; }
							elseif($version == 'V1k'){ $version = 'V1l'; }
							elseif($version == 'V1l'){ $version = 'V1m'; }
							elseif($version == 'V1m'){ $version = 'V1n'; }
							elseif($version == 'V1n'){ $version = 'V1o'; }
							elseif($version == 'V1o'){ $version = 'V1p'; }
							elseif($version == 'V1p'){ $version = 'V1q'; }
							elseif($version == 'V1q'){ $version = 'V1r'; }
							elseif($version == 'V1r'){ $version = 'V1s'; }
							elseif($version == 'V1s'){ $version = 'V1t'; }
							elseif($version == 'V1t'){ $version = 'V1u'; }
							elseif($version == 'V1u'){ $version = 'V1v'; }
							elseif($version == 'V1v'){ $version = 'V1w'; }
							elseif($version == 'V1w'){ $version = 'V1x'; }
							elseif($version == 'V1x'){ $version = 'V1y'; }
							elseif($version == 'V1y'){ $version = 'V1z'; }
						
							$next_rev_sold = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `designer` = '".$row3['designer']."' AND `order_id` = '".$row3['order_id']."' AND `version`='$version' LIMIT 1")->row_array();
							if(isset($next_rev_sold['id'])){
								$rev_ads_reason = $this->db->query("SELECT `reason_id` FROM `rev_order_reason` WHERE `rev_id` = '".$next_rev_sold['id']."' AND `designer` = '".$row3['designer']."' AND `reason_id` = '3' ")->result_array();
								//echo  'rev_reason:'.count($rev_ads_reason).'<br/>';
								$rev_reason = $rev_reason + count($rev_ads_reason);
								//echo count($rev_ads_reason);
							}	
							$row3['category'] = strtoupper($row3['category']);
							$cat_wt = $this->db->get_where('print',array('name' => $row3['category']))->result_array();
							if($cat_wt){
							$pub_nj = $pub_nj + $cat_wt[0]['wt'];
							
							$dp_sft = $dp_sft + $cat_wt[0]['wt'];}
							if($row3['category'] == 'REVISION')
							{
								$cat_rev++;
							}
							if($row3['category'] == 'SOLD')
							{
								$cat_sold++;
							}
						}
						
					//	}
					} 
					$dp_sft = $dp_sft/30;
					if($dp_sft > '1'){ $dp_sft = '1'; }
					
					$total_add = $job_count + $cat_rev;
					$total_add_reason = $new_reason + $rev_reason;
					if($total_add != 0){
						$total_err = (($total_add_reason / $total_add ) * 100);
					}
					?>
					<tr>
						<td><?php echo $row['name']; ?></td><!--Name-->
						<td><?php echo $row['username']; ?></td><!--Code-->
						<td><?php echo round($total_err,2); ?></td><!--Error-->
					</tr>
					<?php 
						$total_error = $total_error + $total_err ;} ?>
				</tbody>
				<?php if($designer_id == 'all') { ?>
				<tfoot>
				<tr>
					<th colspan="2">Total</th>
					<th><?php echo round($total_error,2);?></th>
				</tr>
				</tfoot><?php } ?>
			</table>
		
	</div>

</div>	
</div>
</div>
</div>
</div>
<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable.php'); ?>
