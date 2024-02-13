<?php
       $this->load->view("new_designer/head"); 
?>
<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	
	<!-- BEGIN PAGE CONTENT -->
	<div class="page-content">
		<div class="container">
			
			
			<!-- BEGIN PAGE CONTENT INNER -->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light">
						<div class="portlet-body">
							
							<div class="tab-content">
								<div class="tab-pane fade active in" id="tab_2_1">
									<table class="table table-striped table-bordered table-hover" id="sample_1">
									<thead>
										<tr>
											<th>Order Id</th>
											<th>Mistake</th>
											<th>Adrep</th>
											<th>Publication</th>
										</tr>
									</thead>
									<tbody>
									<?php
										foreach($order_revision_review as $row){
										    $review_count = $this->db->query("SELECT `id` FROM `order_revision_review` WHERE order_id='".$row['order_id']."'")->num_rows();
									?>									
										<tr>
											<td><?php echo $row['order_id']; ?></td>
											<td><?php echo $review_count; ?></td>
											<td><?php echo $row['first_name'].' '.$row['last_name']; ?></td>
											<td><?php echo $row['name']; ?></td>
										</tr>  
									<?php } ?>									
									</tbody>
									</table>  
								</div>
							</div>
					</div>
					<!-- END EXAMPLE TABLE PORTLET-->
				</div>
			</div>
			<!-- END PAGE CONTENT INNER -->
		</div>
	</div>
	<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->
</div>

<?php
       $this->load->view("new_designer/foot"); 
?>