<?php $this->load->view("new_csr/head"); ?>
<!-- BEGIN TOP NAVIGATION MENU -->	
<!-- END HEADER -->
<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<!-- BEGIN PAGE CONTENT -->
	<div class="page-content">
		<div class="container">
		<!-- BEGIN PROFILE CONTENT -->
		<div class="row margin-top-10">
			<div class="col-md-12">
			<!-- BEGIN PORTLET -->
			<div class="portlet light ">
				<div class="portlet-title">
					<div class="caption caption-md">
						<i class="icon-bar-chart theme-font hide"></i>
						<span class="caption-subject font-blue-madison bold">Performance</span>
					</div>
					<div class="caption col-md-offset-3">
						<span style= "color:black;font-size: 13px;">
						<?php if(isset($from) && isset($to)){
							  $d_from = strtotime($from); $d_to = strtotime($to); 
								echo date('d M Y', $d_from).' to '.date('d M Y', $d_to); 
							}else{ 
								$d_today = strtotime($today);
								echo date('d M Y', $d_today); } ?>
						</span>
					</div>
					<div class="actions">
						<form role="form" method="post">
							<?php if(isset($num_days)) { ?>
							<a class="btn btn-circle btn-default btn-xs <?php if($num_days == '')echo 'active'; ?>" href="<?php echo base_url().index_page().'new_csr/home/reports';?>">
							Today
							</a>
							<a class="btn btn-circle btn-default btn-xs <?php if($num_days == '7')echo 'active'; ?>" href="<?php echo base_url().index_page().'new_csr/home/reports/7';?>">
							7 Days
							</a>
							<a class="btn btn-circle btn-default btn-xs <?php if($num_days == 'curr_month')echo 'active'; ?>" href="<?php echo base_url().index_page().'new_csr/home/reports/curr_month';?>">
							Current Month
							</a>
							<a class="btn btn-circle btn-default btn-xs <?php if($num_days == 'prev_month')echo 'active'; ?>" href="<?php echo base_url().index_page().'new_csr/home/reports/prev_month';?>">
							Last Month
							</a><?php } ?>
						</form>
					</div>
					
				</div>
				<div class="portlet-body">
					<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-hover table-striped">
						<thead>
							<tr>
								<th rowspan="2" style="vertical-align: middle;">Name</th>
								<th rowspan="2" style="vertical-align: middle;">Code</th>
								<th colspan="2" class="text-center" style="border-bottom:solid 1px #e5e5e5">Content Certified</th>
								<th colspan="2" class="text-center" style="border-bottom:solid 1px #e5e5e5">Categorised</th>
								<th colspan="1" class="text-center" style="border-bottom:solid 1px #e5e5e5">Sent</th>
								<th rowspan="2" style=" vertical-align: middle;">Final NJ</th>

							</tr>
							<tr>
								<th>New</th>
								<th>Revision</th>
								<th>New</th>
								<th>Revision</th>	
								<th>Revision</th>				
							</tr>
						</thead>
						<tbody>
						<?php $new_qa_count=0; $rev_check_count=0; $rev_check=0; $total_err=0;
							foreach($csr as $row){ 
							   $csr_qa_nj=0;  $rev_nj = 0; $cat_a = 0; $cat_b = 0; $cat_c = 0; $cat_d = 0; $cat_e = 0; $cat_f = 0; $cat_g = 0;  $cat_h = 0; $QA_nj=0; $cat_rev = 0; $cat_sold = 0;$csr_order =0; $csr_revision = 0;
								if(isset($from) && isset($to))
								{
								$cat_result = $this->db->query("SELECT `id` FROM `cat_result` WHERE `csr` = '".$row['id']."' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59')")->result_array();
								
								$QA = $this->db->query("SELECT `id`,`order_no`,`slug`,`category` FROM `cat_result` WHERE `csr_QA` = '".$row['id']."' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59')")->result_array();
								
								$rev_accepted = $this->db->query("SELECT `id` from `rev_sold_jobs` where `c_create` = '".$row['id']."' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ")->result_array();
								
								$rov_checked = $this->db->query("SELECT `id`,`category`,`rov_csr` from `rev_sold_jobs` where `rov_csr` = '".$row['id']."' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ")->result_array();
								
								$rev_sent = $this->db->query("SELECT `id` from `rev_sold_jobs` where `frontline_csr` = '".$row['id']."' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ")->result_array();
								}else{
								$cat_result = $this->db->query("SELECT `id` FROM `cat_result` WHERE `csr` = '".$row['id']."' AND `date`='$today'")->result_array();
								
								$QA = $this->db->query("SELECT `id`,`order_no`,`slug`,`category` FROM `cat_result` WHERE `csr_QA` = '".$row['id']."' AND `date`='$today'")->result_array();
								
								$rev_accepted = $this->db->query("SELECT `id` from `rev_sold_jobs` where `c_create` = '".$row['id']."' AND `date`='$today' ")->result_array();
								
								$rov_checked = $this->db->query("SELECT `id`,`category`,`rov_csr` from `rev_sold_jobs` where `rov_csr` = '".$row['id']."' AND `date`='$today' ")->result_array();
								
								$rev_sent = $this->db->query("SELECT `id` from `rev_sold_jobs` where `frontline_csr` = '".$row['id']."' AND `date`='$today' ")->result_array();
									
								}
								$cat_job_count = count($cat_result);
								
								if($QA){  
									foreach($QA as $Q) {
										$csr_order_jobs = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id` = '".$Q['order_no']."' AND `order_no` = '".$Q['slug']."'")->result_array();
											if(isset($csr_order_jobs[0]['id'])){ 
												foreach($csr_order_jobs as $csr_row){
													$csr_rea_jobs = $this->db->query("SELECT `reason_id` FROM `rev_order_reason` WHERE `rev_id` = '".$csr_row['id']."'  AND `csr` = '".$csr_row['rov_csr']."' AND `reason_id` = '3'")->result_array();
													$csr_order = $csr_order + count($csr_rea_jobs);
													
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
								if($rov_checked){			
									foreach($rov_checked as $row3){
										$csr_rea_jobs = $this->db->query("SELECT * FROM `rev_order_reason` WHERE `rev_id` = '".$row3['id']."'  AND `csr` = '".$row3['rov_csr']."' AND `reason_id` = '3'")->result_array();
										if(isset($csr_rea_jobs[0]['id'])){
										
										$csr_revision = $csr_revision + count($csr_rea_jobs);
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
								$cat_nj = $cat_job_count / 80;
								$incoming_nj = count($rev_accepted) / 80;
								$outgoing_nj = count($rev_sent) / 80; 
								$total_count = $new_qa_count + $rev_check_count;
								$final_nj = $csr_qa_nj + $cat_nj + $incoming_nj + $outgoing_nj + $rov_check_nj;
								
								$total_csr_add = $QA_count + count($rov_checked);
								$total_csr_rev_add = $csr_order + $csr_revision;
								if($total_csr_add != 0){
									$total_err = (($total_csr_rev_add / $total_csr_add ) * 100);
								}
								?>
								<tr>
									<td><?php echo $row['name'] ;?></td> <!-- Name -->
									<td><?php echo $row['username'] ;?></td><!-- Code -->
									<td><?php echo $QA_count ;?></td><!-- QA(New ads) -->
									<td><?php echo count($rov_checked);?></td> <!-- Rov Checked(Revision) -->
									<td><?php echo $cat_job_count;?></td><!-- Categorised(New ads) -->
									<td><?php echo count($rev_accepted);?></td> <!-- Revision Accepted -->
									<td><?php echo count($rev_sent);?></td><!-- Revision DC -->
									<td><?php echo round($final_nj,2); ?></td> <!-- Final NJ  -->
								</tr>
								<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
	<!-- END PORTLET -->
			</div>
		</div>
	<!-- END PROFILE CONTENT -->
		</div>
	</div>
<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->
<!-- BEGIN PRE-FOOTER -->
<!-- END PRE-FOOTER -->
<!-- BEGIN FOOTER -->

<?php $this->load->view("new_csr/foot"); ?>