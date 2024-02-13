<?php $this->load->view("new_csr/head"); ?>
<div class="page-container">

	<!-- BEGIN PAGE CONTENT -->
	<div class="page-content">
		<div class="container">
			<!-- BEGIN PAGE CONTENT INNER -->
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption">Metro Orders <?php echo '<h5 style="color:#900;">'.$this->session->flashdata('message').'</h5>'; ?> </div>
				</div>
				<div class="portlet-body">
					<div class="row">
						<div class="col-md-12">
							<table class="table table-striped table-bordered table-hover" id="sample_2">
								<thead>
								<tr>
									<th>Date</th>
									<th>Job Name</th>
									<th>Action</th>
								</tr>
								</thead>
								<tbody>
								 <?php 
									foreach($metro_orders as $row){ 
								?>
									<tr>
										<td><?php echo $row['timestamp']; ?></td>
										<td><?php echo $row['job_num'].'_'.$row['metro_ref']; ?></td>
										<?php if($row['approve']!='0'){ echo '<td> uploaded </td>'; }else{ ?>	
										<td>
										<form method="post">
										<input type="submit" name= "Submit" class="btn btn-primary btn-xs" value="Submit">
										<input name="id" value="<?php echo $row['id'];?>" readonly style="display:none;" />
										</form>
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