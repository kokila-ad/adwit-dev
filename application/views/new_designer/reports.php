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
							<ul class="nav nav-pills">
								<li <?php if($tab==''){echo'class="active"';}?>>
									<a href="<?php echo base_url().'index.php/new_designer/home/reports'; ?>"  >
									Today’s NJ <span class="badge bg-blue"><?php if($tab=='' && isset($cat_result)){echo count($cat_result)+count($rev_sold);}?></span></a>
								</li>
								<li <?php if($tab=='1'){echo'class="active"';}?>>
									<a href="<?php echo base_url().'index.php/new_designer/home/reports/1'; ?>"  >
									Total <?php echo $current_month; ?> NJ <span class="badge bg-blue"><?php if($tab=='1' && isset($cat_result)){echo count($cat_result)+count($rev_sold);}?></span></a>
								</li>
								<li <?php if($tab=='2'){echo'class="active"';}?>>
									<a href="<?php echo base_url().'index.php/new_designer/home/reports/2'; ?>" >
									Total <?php echo $previous_month; ?> NJ <span class="badge bg-blue"><?php if($tab=='2' && isset($cat_result)){echo count($cat_result)+count($rev_sold);}?></span></a>
								</li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane fade active in" id="tab_2_1">
									<table class="table table-striped table-bordered table-hover" id="sample_1">
									<thead>
										<tr>
											<th>Date</th>
											<th>Order Id</th>
											<th>Job Name</th>
											<th>Publication</th>
											<th>Ads Type</th>
											<!--<th>NJ</th>-->
										</tr>
									</thead>
									<tbody>
<?php
	foreach($cat_result as $row){
		$publication = $this->db->get_where('publications',array('id' => $row['publication_id']))->result_array();
?>									<tr>
										<td><?php echo $row['ddate']; ?></td>
										<td><?php echo $row['order_no']; ?></td>
										<td><?php echo $row['job_name']; ?></td>
										<td><?php echo $publication[0]['name']; ?></td>
										<td><?php echo 'NewAd'; ?></td>
										<!--<td>4324</td>-->
									</tr>  
<?php }foreach($rev_sold as $row1){ ?>									
									<tr>
										<td><?php echo $row1['ddate']; ?></td>
										<td><?php echo $row1['order_id']; ?></td>
										<td><?php echo $row1['order_no']; ?></td>
										<td><?php echo ''; ?></td>
										<td><?php echo 'RevisionAd'; ?></td>
										<!--<td>4324</td>-->
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