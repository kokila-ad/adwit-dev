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
});
</script>
<style>
.table-scrollable {
    width: 50%;
}
table.table-bordered thead th, table.table-bordered thead td {
    border-left-width: 1px;
    border-top-width: 0;
}

</style>

<div class="portlet light">
	<div class="portlet-title">
		<div class="row">	
			<div class="col-md-6 col-xs-12 margin-bottom-10 font-lg font-grey-gallery">
			<a href="" class="font-grey-gallery">Others(%) Report</a> 
				<?php if($csr_id != 'all') { echo '- '.$csr[0]['name'] ; }?>-
				<?php if(isset($from) && isset($to)){echo date('M d, Y ',strtotime($from))." to ".date('M d, Y',strtotime($to));}elseif(isset($today)){echo date('M d, Y',strtotime($today));} ?>
			</div>
			
			<div class="col-md-6 col-xs-20 margin-bottom-10 text-right">		
				<button class="btn bg-grey btn-xs" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
				<span class="cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
			</div>
			
			
		
		</div>
	</div>
	<div class="portlet-body " id="close_filter">
	<div>
		<?php if($csr_id == 'all') { ?>
				<table class="table table-bordered table-hover" id="sample_6">
			<?php }else{ ?>
			
				<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-hover table-striped"  id="sample_6">
		<?php } ?> 
				<thead>
					<tr>
						<th>Name</th>
						<th>Code</th>
						<th>Error(%)</th>
					</tr>
				</thead>
				<tbody>
					<?php $category_count = 0; $tot_QA_count = 0; $rev_accepted_count = 0; $rov_checked_count = 0; $rev_sent_count = 0; $tot_final_nj = 0; $new_qa_count=0; $rev_check_count=0; $rev_check=0;  $quality_check_count =0;$total_err=0; $total_error = 0;
						foreach($csr as $row){ 
						   $csr_qa_nj=0;  $rev_nj = 0; $cat_a = 0; $cat_b = 0; $cat_c = 0; $cat_d = 0; $cat_e = 0; $cat_f = 0; $cat_g = 0;  $cat_h = 0; $QA_nj=0; $cat_rev = 0; $cat_sold = 0;$csr_order =0; $csr_revision = 0;
							
							$cat_result = $this->db->query("SELECT * FROM `cat_result` WHERE `csr` = '".$row['id']."' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59')")->result_array();
							
							$QA = $this->db->query("SELECT `id`,`order_no`,`slug`,`category` FROM `cat_result` WHERE `csr_QA` = '".$row['id']."' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59')")->result_array();
							
							$rev_accepted = $this->db->query("SELECT * from `rev_sold_jobs` where `c_create` = '".$row['id']."' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ")->result_array();
							
							$rov_checked = $this->db->query("SELECT `version`,`id`,`order_id`,`category`,`rov_csr` from `rev_sold_jobs` where `rov_csr` = '".$row['id']."' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ")->result_array();
							
							$rev_sent = $this->db->query("SELECT * from `rev_sold_jobs` where `frontline_csr` = '".$row['id']."' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ")->result_array();
							
							$cat_job_count = count($cat_result);
							
							if($QA){  
								foreach($QA as $Q) { //echo $Q['order_no'].'-'.$Q['category'].'</br>';
									$csr_order_jobs = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id` = '".$Q['order_no']."' AND `order_no` = '".$Q['slug']."'")->result_array();
										//echo 'new_count:'.count($csr_order_jobs).'<br/>';
										if(isset($csr_order_jobs[0]['id'])){ 
											foreach($csr_order_jobs as $csr_row){
												$csr_rea_jobs = $this->db->query("SELECT `reason_id` FROM `rev_order_reason` WHERE `rev_id` = '".$csr_row['id']."' AND `reason_id` = '3'")->result_array();
												//echo count($csr_rea_jobs);
												if(isset($csr_rea_jobs[0]['reason_id'])){
													$csr_order = $csr_order + 1;
												}
												
											}
										}
									
									$cat_wt = $this->db->get_where('print',array('name' => $Q['category']))->result_array();
									if($Q['category'] == 'A')
									{
										$cat_a++;
									}
									if($Q['category'] == 'B')
									{
										$cat_b++;
									}
									if($Q['category'] == 'C')
									{
										$cat_c++;
									}
									if($Q['category'] == 'D')
									{
										$cat_d++;
									}
									if($Q['category'] == 'E')
									{
										$cat_e++;	
									}
									if($Q['category'] == 'F')
									{
										$cat_f++;
									}
									if($Q['category'] == 'G')
									{
										$cat_g++;
									}
									if($Q['category'] == 'H')
									{
										$cat_h++;
									}
								} 
							}
							if($rov_checked)
							{			
								foreach($rov_checked as $row3){
								
									$rev_rea_id = array();
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
									$next_rev_sold = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id` = '".$row3['order_id']."' AND `version`='$version' LIMIT 1")->row_array();
									if(isset($next_rev_sold['id'])){
										$csr_rea_jobs = $this->db->query("SELECT * FROM `rev_order_reason` WHERE `rev_id` = '".$next_rev_sold['id']."' AND `reason_id` = '3'")->result_array();
										//echo 'rev_count:'.count($csr_rea_jobs).'<br/>';
										if(isset($csr_rea_jobs[0]['id'])){
										//echo $csr_rea_jobs[0]['rev_id'].'-'.$csr_rea_jobs[0]['order_id'];
										
										$csr_revision = $csr_revision + count($csr_rea_jobs);
										//echo  'rev_reason:'.count($csr_revision).'<br/>';
										}	
									}										
										$row3['category'] = strtoupper($row3['category']);
										$cat_wt = $this->db->get_where('print',array('name' => $row3['category']))->result_array();
										if(isset($cat_wt[0]['wt'])){
											$rev_nj = $rev_nj + $cat_wt[0]['wt'];
										}
										if($row3['category'] == 'REVISION')
										{
											$cat_rev++;
										}
										if($row3['category'] == 'SOLD')
										{
											$cat_sold++;
										}
								}
							}
							//csr weight
							$print = $this->db->query("SELECT * FROM `print`")->result_array();
							foreach($print as $print_row){
								$name = $print_row['name'];
								$weight[$name] = $print_row['csr_wt'];
							}
							$csr_qa_nj = ($cat_a * $weight['A']) + ($cat_b * $weight['B']) + ($cat_c * $weight['C']) + ($cat_d * $weight['D']) + ($cat_e * $weight['E']) + ($cat_f * $weight['F']) + ($cat_g * $weight['G']) + ($cat_h * $weight['H']);
							$QA_count = count($QA);
							$rov_check_nj = count($rov_checked)/ 20;
							$rev_check_count = $rev_check_count + $rev_check;
							//echo 'rev_count:'. $rev_check_count.'</br>';
							$cat_nj = $cat_job_count / 80;
							$incoming_nj = count($rev_accepted) / 80;
							$outgoing_nj = count($rev_sent) / 80; 
							$total_count = $new_qa_count + $rev_check_count;
							$final_nj = $csr_qa_nj + $cat_nj + $incoming_nj + $outgoing_nj + $rov_check_nj;
							
							$total_csr_add = $QA_count + count($rov_checked);
							//echo $total_csr_add.'</br>';
							$total_csr_rev_add = $csr_order + $csr_revision;
							//echo $total_csr_rev_add.'</br>';
							if($total_csr_add != 0){
								$total_err = (($total_csr_rev_add / $total_csr_add ) * 100);
								//echo 'total:'.$total_err.'</br>';
							}
							?>
					<tr>
						<td><?php echo $row['name'] ;?></td> <!-- Name -->
						<td><?php echo $row['username'] ;?></td><!-- Code -->
						<td><?php echo round($total_err,2);?></td><!-- Error(%)-->
					</tr>
					<?php 
						  $total_error= $total_error + $total_err;
						  ?>
					<?php } ?>
				</tbody>
				<?php if($csr_id == 'all') { ?>
				<tfoot>
					<tr>
						<th colspan="2">Total</th>
						<th><?php echo round($total_error,2);?></th><!-- Error(%) -->
				</tfoot>
			  <?php } ?>
			</table>
			
		</div>
	</div>
</div>


<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable.php'); ?>