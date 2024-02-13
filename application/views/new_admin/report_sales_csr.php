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
    width: 50%;
table.table-bordered thead th, table.table-bordered thead td {
    border-left-width: 1px;
    border-top-width: 0;
}
</style>
<!--<script>    
    if(typeof window.history.pushState == 'function') {
        window.history.pushState({}, "Hide", '<?php echo $_SERVER['PHP_SELF'];?>');
    }
</script>-->


<div class="portlet light">
	<div class="portlet-title">
		<div class="row">	
			<div class="col-md-7 col-xs-12 margin-bottom-10 font-lg font-grey-gallery">
				<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report'; ?>" class="font-grey-gallery">Reports</a> - <a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report/'.$type; ?>" class="font-grey-gallery"><?php echo $type;?></a> - 
				<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report/'.$type.'/'.$user; ?>" class="font-grey-gallery"><?php echo $user;?></a> 
				<?php if($csr_id != 'all') { echo '- '.$csr[0]['name'] ; }?>-
				<?php if(isset($from) && isset($to)){echo date('M d, Y ',strtotime($from))." to ".date('M d, Y',strtotime($to));}elseif(isset($today)){echo date('M d, Y',strtotime($today));} ?>
			</div>
			
			<div class="col-md-3 col-xs-8 margin-bottom-10 text-right padding-right-0">	
				<?php if($csr_id != 'all') { ?>
					<form method="get">
						<div class="btn-group left-dropdown">							
							<button class="btn bg-grey btn-xs dropdown-toggle" margin-right-10" data-toggle="dropdown" aria-expanded="true"	id="filter">
								<i class="fa fa-filter cursor-pointer"></i> Filter</button>
							<div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu">
								<div class=" date-picker input-daterange" data-date="10/11/2012" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
									<input type="text" class="form-control border-radius-left" name="csr_id" value="<?php echo $csr_id ;?>" style="display:none;">
									<input type="text" class="form-control border-radius-left" name="from" placeholder="From Date">
									<input type="text" class="form-control border-radius-right margin-top-10" name="to" placeholder="To Date">
									<div class="text-right margin-top-10">
										<button type="submit" class="btn bg-red-flamingo btn-sm"> Submit</button>
									</div>
								</div>
							</div>
						</div>
					</form>
				<?php } ?>	
			</div>	
			<div class="col-md-1 col-xs-4 margin-bottom-10 text-right">	
				<a href="javascript:;" class="btn btn-primary btn-xs" onclick="window.location = '<?php echo base_url().index_page().'new_admin/home/error_report_csr?csr_id='.$csr_id.'&from='.$from.'&to='.$to;?>'">Others(%)</a>
			</div>
			<div class="col-md-1 col-xs-4 margin-bottom-10 text-right">		
				<button class="btn bg-grey btn-xs" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
			</div>
		</div>
	</div>
	<div class="portlet-body " id="close_filter">
	<div>
		<?php if($csr_id == 'all') { ?>
				<table class="table table-bordered table-hover" id="sample_6">
			<?php }else{ ?>
				<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-hover table-striped" id="sample_6">
		<?php } ?> 
				<thead>
					<tr>
						<th rowspan="2" style="vertical-align: middle;">Name</th>
						<th rowspan="2" style="vertical-align: middle;">Code</th>
						<th colspan="2" class="text-center border-bottom">Content Certified</th>
						<th colspan="2" class="text-center border-bottom">Categorised</th>
						<th colspan="1" class="text-center border-bottom">Sent</th>
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
					<?php $category_count = 0; $tot_QA_count = 0; $rev_accepted_count = 0; $rov_checked_count = 0; $rev_sent_count = 0; $tot_final_nj = 0; $new_qa_count=0; $rev_check_count=0; $rev_check=0;  $quality_check_count =0;
						  foreach($csr as $row){ 
						  $csr_qa_nj=0;  $cat_a = 0; $cat_b = 0; $cat_c = 0; $cat_d = 0; $cat_e = 0; $cat_f = 0; $cat_g = 0;  $cat_h = 0; $QA_nj=0; $csr_order =0; $csr_revision = 0;
						
						  $cat_job_count = $this->db->query("SELECT `id` FROM `cat_result` WHERE `csr` = '".$row['id']."' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59')")->num_rows();
						  
						  $QA = $this->db->query("SELECT `id`,`order_no`,`slug`,`category` FROM `cat_result` WHERE `csr_QA` = '".$row['id']."' AND (`date` BETWEEN '$from' AND '$to')")->result_array();
					
						  $rov_checked = $this->db->query("SELECT rev_sold_jobs.version, rev_sold_jobs.id, rev_sold_jobs.order_id, rev_sold_jobs.category, print.wt from `rev_sold_jobs` LEFT OUTER JOIN `print` ON print.name=rev_sold_jobs.category WHERE `rov_csr` = '".$row['id']."' AND (`date` BETWEEN '$from' AND '$to') ")->result_array();
						  
						  $rev_accepted = $this->db->query("SELECT `id` from `rev_sold_jobs` where `c_create` = '".$row['id']."' AND (`date` BETWEEN '$from' AND '$to') ")->num_rows();
							
						  $rev_sent = $this->db->query("SELECT `id` from `rev_sold_jobs` where `frontline_csr` = '".$row['id']."' AND (`date` BETWEEN '$from' AND '$to') ")->num_rows();
						 
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
							<td><a href="<?php echo base_url().index_page().'new_admin/home/csr_report?csr_id='.$row['id'].'&from='.$from.'&to='.$to;?>"><?php echo $QA_count ;?></td></a><!-- QA(New ads) -->
							<td><a href="<?php echo base_url().index_page().'new_admin/home/csr_report?csr_id='.$row['id'].'&from='.$from.'&to='.$to;?>"><?php echo count($rov_checked);?></td></a> <!-- Rov Checked(Revision) -->
							<td><?php echo $cat_job_count;?></td><!-- Categorised(New ads) -->
							<td><?php echo $rev_accepted;?></td> <!-- Revision Accepted -->
							<td><?php echo $rev_sent;?></td><!-- Revision DC -->
							<td><?php echo round($final_nj,2); ?></td> <!-- Final NJ  -->
							
						</tr>
						<?php $category_count = $category_count +  $cat_job_count;
							  $tot_QA_count = $tot_QA_count + $QA_count;
							  $rev_accepted_count = $rev_accepted_count + $rev_accepted;
							  $rov_checked_count = $rov_checked_count + count($rov_checked);
							  $rev_sent_count = $rev_sent_count + $rev_sent;
							  $tot_final_nj = $tot_final_nj + $final_nj;  ?>
						<?php } ?>
				</tbody>
				<?php if($csr_id == 'all') { ?>
				<tfoot>
					<tr>
						<th colspan="2">Total</th>
						<th><?php echo $tot_QA_count ;?></th><!-- QA(New) -->
						<th><?php echo $rov_checked_count ;?></th><!-- Rov Checked(Revision) -->
						<th><?php echo $category_count ;?></th><!-- Categorised -->
						<th><?php echo $rev_accepted_count ;?></th> <!-- Revision Incoming -->
						<th><?php echo $rev_sent_count ;?></th><!-- Revision DC -->
						<th><?php echo round($tot_final_nj,2) ;?></th><!-- Final NJ -->
					</tr>
				</tfoot>
			  <?php } ?>
			</table>
		</div>
	</div>
</div>


<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable.php'); ?>