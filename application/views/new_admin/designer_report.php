<?php $this->load->view('new_admin/header.php'); ?>

<style>
.tabletools-btn-group {
    margin: 0 0 10px 0;
    display: none;
}
.tabletools-dropdown-on-portlet > .btn:last-child {
    margin-right: 0;
    display: none;
}
</style>
	
<div class="page-content">
	<div class="container">
		<div class="row margin-top-15">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="portlet-body">
				<div class="caption">
				<div class="col-md-11">
					<span class="font-lg font-grey-gallery bold">Designer Report</span>
				</div>
				<div class="col-md-1 text-right">
					<span class=" cursor-pointer right"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
				</div>
				</div>
				</div>	
			</div>
		</div>
			<div class="row">
			<div class="col-sm-6">
				<div class="portlet light">
					<div class="portlet-body">
						<table class="table table-striped table-bordered table-hover" id="sample_6">
						<thead>
						<tr>
							<th>New Ads</th>
							<th>Revision Recieved</th>
							<th>Reason</th>
						</tr>
						</thead>
						<tbody>
						<?php 
							if(isset($ads[0]['order_no'])){ 
							    $nt = 0; $rt = 0; $ratio = 0;
							    $nt = count($ads);
								$hd_neg = array(4,7); // For exception of numbers
								foreach($ads as $row){ 
									//if(!in_array($row['help_desk'], $hd_neg)){
								$jobs = $this->db->query("SELECT * FROM `rev_sold_jobs` 
								                            WHERE `order_id` = '".$row['order_no']."' AND `order_no` = '".$row['slug']."'")->result_array();
						?>
						<tr>
							<td><?php echo $row['order_no'];?></td>
							<?php 
							if(isset($jobs[0]['id'])){ 
								foreach($jobs as $job_row){
								    $rt++;
									$rev_order_reason = $this->db->query("SELECT * FROM `rev_order_reason` WHERE `rev_id` = '".$job_row['id']."' AND `reason_id` = '3'")->result_array();
							?>
							
							<td><?php if(isset($job_row['id'])){ echo $job_row['version']; }?></td>
							<td><?php if(isset($rev_order_reason[0]['reason_id'])){ echo "others"; }else{ echo ''; } ?></td>
							<?php } }else{ ?>
							
							<td></td>
							<td></td>
							<?php } ?>
						</tr>
						<?php 
									//} 
								}
							$ratio = $rt / $nt;
						?>
						<!--total display -->
						    <td style="font-weight:bold"><?php echo $nt; ?></td>
						    <td style="font-weight:bold"><?php echo $rt; ?></td>
						    <td style="font-weight:bold"><?php echo round($ratio, 2); ?></td>
						<?php
							}
						?>
						</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
			<div class="portlet light">
				<div class="portlet-body">
				<table class="table table-striped table-bordered table-hover" id="sample_2">
				<thead>
				<tr>
					<!--<th>Revision ID </th>-->
					<th>Revision Ads</th>
					<th>Version</th>
					<th>Revision Recieved Reason</th>
					<th>Version</th>
				</tr>
				</thead>
				<tbody>
					<?php if(isset($rj[0]['id'])){?>
						<?php foreach($rj as $row1){
								$error_rev = array();
								$version = $row1['version'];
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
							
							$next_rev_sold = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `designer` = '".$row1['designer']."' AND `order_id` = '".$row1['order_id']."' AND `version`='$version' LIMIT 1")->row_array();
							if(isset($next_rev_sold['id'])){
								$error_rev = $this->db->query("SELECT `reason_id` FROM `rev_order_reason` WHERE `rev_id` = '".$next_rev_sold['id']."' AND `designer` = '".$row1['designer']."' AND `reason_id` = '3' ")->result_array();
							}
							//$error_rev = $this->db->query("SELECT `reason_id` FROM `rev_order_reason` WHERE `rev_id` = '".$row1['id']."' AND `designer` = '".$row1['designer']."' AND `reason_id` = '3' ")->result_array();
					?>
					<tr class="odd gradeX">
					<!--	<td><?php echo $row1['id'];?></td>-->
						<td><?php echo $row1['order_id'];?></td>
						<td><?php echo $row1['version'];?></td>
						<td><?php if(isset($error_rev[0]['reason_id'])){echo "others";} ?></td>
						<td><?php if(isset($next_rev_sold['order_id'])){echo $next_rev_sold['version'];}?></td>
					</tr>
					<?php } }?>
				</tbody>
				</table>
				</div> 
			</div>
			</div> 
		</div>
	</div>
</div>
</div>

<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable.php'); ?>
