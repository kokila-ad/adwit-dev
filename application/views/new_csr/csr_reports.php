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
							<a class="btn btn-circle btn-default btn-xs <?php if($num_days == '')echo 'active'; ?>" href="<?php echo base_url().index_page().'new_csr/home/csr_reports';?>">
							Today
							</a>
							<a class="btn btn-circle btn-default btn-xs <?php if($num_days == '7')echo 'active'; ?>" href="<?php echo base_url().index_page().'new_csr/home/csr_reports/7';?>">
							7 Days
							</a>
							<a class="btn btn-circle btn-default btn-xs <?php if($num_days == 'curr_month')echo 'active'; ?>" href="<?php echo base_url().index_page().'new_csr/home/csr_reports/curr_month';?>">
							Current Month
							</a>
							<a class="btn btn-circle btn-default btn-xs <?php if($num_days == 'prev_month')echo 'active'; ?>" href="<?php echo base_url().index_page().'new_csr/home/csr_reports/prev_month';?>">
							Last Month
							</a><?php } ?>
						</form>
					</div>
					
				</div>
				<div class="portlet-body">
					<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-hover table-striped" id="sample_6">
						<thead>
							<tr>
								<th rowspan="2" style="vertical-align: middle;">Name</th>
								<th rowspan="2" style="vertical-align: middle;">Code</th>
								<th colspan="2" class="text-center" style="border-bottom:solid 1px #e5e5e5">Content Certified</th>
								<th colspan="2" class="text-center" style="border-bottom:solid 1px #e5e5e5">Categorised</th>
								<th colspan="1" class="text-center" style="border-bottom:solid 1px #e5e5e5">Sent</th>
								<!--<th rowspan="2" style=" vertical-align: middle;">Final NJ</th>-->

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
						<?php $category_count = 0; $tot_QA_count = 0; $rev_accepted_count = 0; $rov_checked_count = 0; $rev_sent_count = 0; $tot_final_nj = 0; $new_qa_count=0; $rev_check_count=0; $rev_check=0;  $quality_check_count =0;
						  foreach($csr as $row){ 
						  $csr_qa_nj=0;  $cat_a = 0; $cat_b = 0; $cat_c = 0; $cat_d = 0; $cat_e = 0; $cat_f = 0; $cat_g = 0;  $cat_h = 0; $QA_nj=0; $csr_order =0; $csr_revision = 0;
						
						if(isset($from) && isset($to))
						{
							$cat_job_count = $this->db->query("SELECT `id` FROM `cat_result` WHERE `csr` = '".$row['id']."' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59')")->num_rows();
							
							$QA = $this->db->query("SELECT `id`,`order_no`,`slug`,`category` FROM `cat_result` WHERE `csr_QA` = '".$row['id']."' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59')")->result_array();
							
							$rev_accepted = $this->db->query("SELECT `id` from `rev_sold_jobs` where `c_create` = '".$row['id']."' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ")->num_rows();
							
							 $rov_checked = $this->db->query("SELECT rev_sold_jobs.version, rev_sold_jobs.id, rev_sold_jobs.order_id, rev_sold_jobs.category, print.wt from `rev_sold_jobs` LEFT OUTER JOIN `print` ON print.name=rev_sold_jobs.category WHERE `rov_csr` = '".$row['id']."' AND (`date` BETWEEN '$from' AND '$to') ")->result_array();
							
							$rev_sent = $this->db->query("SELECT `id` from `rev_sold_jobs` where `frontline_csr` = '".$row['id']."' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ")->num_rows();
						}else{
							$cat_job_count = $this->db->query("SELECT `id` FROM `cat_result` WHERE `csr` = '".$row['id']."' AND `date`='$today'")->num_rows();
							
							$QA = $this->db->query("SELECT `id`,`order_no`,`slug`,`category` FROM `cat_result` WHERE `csr_QA` = '".$row['id']."' AND `date`='$today'")->result_array();
							
							$rev_accepted = $this->db->query("SELECT `id` from `rev_sold_jobs` where `c_create` = '".$row['id']."' AND `date`='$today' ")->num_rows();
							
							 $rov_checked = $this->db->query("SELECT rev_sold_jobs.version, rev_sold_jobs.id, rev_sold_jobs.order_id, rev_sold_jobs.category, print.wt from `rev_sold_jobs` LEFT OUTER JOIN `print` ON print.name=rev_sold_jobs.category WHERE `rov_csr` = '".$row['id']."' AND `date`='$today' ")->result_array();
							
							$rev_sent = $this->db->query("SELECT `id` from `rev_sold_jobs` where `frontline_csr` = '".$row['id']."' AND `date`='$today' ")->num_rows();
								
						}
						 
						  $QA_count = count($QA);
						  if($QA){  
							foreach($QA as $Q) {
								$Q['category'] = strtoupper($Q['category']);
								if($Q['category'] == 'A')
								{
									$cat_a++;
								}elseif($Q['category'] == 'B')
								{
									$cat_b++;
								}elseif($Q['category'] == 'C')
								{
									$cat_c++;
								}elseif($Q['category'] == 'D')
								{
									$cat_d++;
								}elseif($Q['category'] == 'E')
								{
									$cat_e++;	
								}elseif($Q['category'] == 'F')
								{
									$cat_f++;
								}elseif($Q['category'] == 'G')
								{
									$cat_g++;
								}elseif($Q['category'] == 'H')
								{
									$cat_h++;
								}
							} 
						}
							$csr_qa_nj = ($cat_a * $weight['A']) + ($cat_b * $weight['B']) + ($cat_c * $weight['C']) + ($cat_d * $weight['D']) + ($cat_e * $weight['E']) + ($cat_f * $weight['F']) + ($cat_g * $weight['G']) + $cat_h * $weight['H'];
							$cat_nj = $cat_job_count / 80;
							$incoming_nj = $rev_accepted / 80;
							$outgoing_nj = $rev_sent / 80; 
							$total_count = $new_qa_count + $rev_check_count;
							$rov_check_nj = count($rov_checked)/ 20;
							$final_nj = $csr_qa_nj + $cat_nj + $incoming_nj + $outgoing_nj + $rov_check_nj;
						?>
						<tr>
							<td><?php echo $row['name'] ;?></td> <!-- Name -->
							<td><?php echo $row['username'] ;?></td><!-- Code -->
							<td><?php echo $QA_count ;?></td><!-- QA(New ads) -->
							<td><?php echo count($rov_checked);?></td><!-- Rov Checked(Revision) -->
							<td><?php echo $cat_job_count;?></td><!-- Categorised(New ads) -->
							<td><?php echo $rev_accepted;?></td> <!-- Revision Accepted -->
							<td><?php echo $rev_sent;?></td><!-- Revision DC -->
							<!--<td><?php echo round($final_nj,2); ?></td>  Final NJ  -->
							
						</tr>
						<?php $category_count = $category_count +  $cat_job_count;
					  $tot_QA_count = $tot_QA_count + $QA_count;
					  $rev_accepted_count = $rev_accepted_count + $rev_accepted;
					  $rov_checked_count = $rov_checked_count + count($rov_checked);
					  $rev_sent_count = $rev_sent_count + $rev_sent;
					  $tot_final_nj = $tot_final_nj + $final_nj;  ?>
						<?php } ?>
						</tbody>
						<tfoot>
							<tr>
								<th colspan="2">Total</th>
								<th><?php echo $tot_QA_count ;?></th><!-- QA(New) -->
								<th><?php echo $rov_checked_count ;?></th><!-- Rov Checked(Revision) -->
								<th><?php echo $category_count ;?></th><!-- Categorised -->
								<th><?php echo $rev_accepted_count ;?></th> <!-- Revision Incoming -->
								<th><?php echo $rev_sent_count ;?></th><!-- Revision DC -->
								<!--<th><?php echo round($tot_final_nj,2) ;?></th> Final NJ -->
							</tr>
						</tfoot>
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