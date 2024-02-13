<?php $this->load->view("new_csr/head"); ?>
<div class="page-container">

	<!-- BEGIN PAGE CONTENT -->
	<div class="page-content">
		<div class="container">
			<!-- BEGIN PAGE CONTENT INNER -->
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption">Map Orders <?php echo '<h5 style="color:#900;">'.$this->session->flashdata('message').'</h5>'; ?> </div>
				</div>
				<div class="portlet-body">
					<div class="row">
						<div class="col-md-12">
							<table class="table table-striped table-bordered table-hover" id="sample_2">
								<thead>
								<tr>
									<th>Date</th>
									<th>Order Type</th>
									<th>Job Name</th>
									<th>Action</th>
								</tr>
								</thead>
								<tbody>
								 <?php 
									foreach($map_orders as $row){ 
								?>
									<tr>
										<td><?php echo $row['timestamp']; ?></td>
										<td><?php echo $row['name']; ?></td>
										<td><?php echo $row['job_name']; ?></td>
										<?php if($row['approve']!='0'){ echo '<td> uploaded </td>'; }else{ ?>	
										<td>
											<a href="<?php echo base_url().index_page()."new_csr/home/map_orders_submit/".$row['id']; ?>" class="btn btn-primary btn-xs">Submit</a>
										</td>
									<?php } ?>	
									</tr>
								<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
									
			<!-- END PAGE CONTENT INNER -->
		</div>
	</div>
	<!-- END PAGE CONTENT -->
</div>






<?php $this->load->view("new_csr/foot"); ?>