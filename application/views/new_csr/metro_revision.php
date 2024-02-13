<?php $this->load->view("new_csr/head"); ?>
<div class="page-container">

	<!-- BEGIN PAGE CONTENT -->
	<div class="page-content">
		<div class="container">
			<!-- BEGIN PAGE CONTENT INNER -->
			<?php if(isset($orders)):?>
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption">Order Details  
						<?php echo $this->session->flashdata('sold_status');?>
					</div> 
				<div class="actions">
					<a onclick="goBack()" class="btn btn-default btn-circle">
					<i class="fa fa-angle-left"></i>
					<span class="hidden-480">
						Back </span>
					</a>
				</div>
				
				
				</div>
				<div class="portlet-body">
					<div class="row">
						<div class="col-md-12">
							<table class="table table-striped table-bordered table-hover" id="sample">
								<thead>
								<tr>
									<th>Date</th>
									<th>Adwit ID</th>
									<th>Job Name</th>
									<th>Advertiser</th>
									<th>Publication</th>
									<th>Adrep Name</th>
									<th>Action</th>
									<th>Sold </th>
								</tr>
								</thead>
								<tbody>
								<?php
	foreach($orders as $row)
	{
		$slug = 'none';
		$adrep = $this->db->get_where('adreps',array('id' => $row['adrep_id']))->result_array();
		$publication = $this->db->get_where('publications',array('id' => $row['publication_id']))->result_array();
		$orders_rev = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `id`=(SELECT MAX(`id`) FROM `rev_sold_jobs` WHERE `order_id`='".$row['id']."')")->result_array();
		$cat_result = $this->db->get_where('cat_result',array('order_no' => $row['id']))->result_array();
		$check = $this->db->get_where('rev_sold_jobs',array('order_id' => $row['id'], 'category' => 'sold'))->result_array();
		if($orders_rev)
		{
			$slug = $orders_rev[0]['new_slug'];
		}elseif($cat_result){
			$slug = $cat_result[0]['slug'];
		}
		
?>
									<tr class="odd gradeX">
											<td><?php $date = strtotime($row['created_on']); echo date('Y-m-d', $date); ?></td>
											<td><?php echo $row['id']; ?> </td>
											<td><?php echo $row['job_no']; ?> </td>
											<td><?php echo $row['advertiser_name']; ?> </td>
											<td><?php echo $publication[0]['name']; ?> </td>
											<td><?php echo $adrep[0]['username']; ?> </td>
											
							<!--Revision --><?php if($slug=='none'){ echo'<td> </td>'; }else{?>
											<td title="Revision"><a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_csr/home/rev_orders/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;"><img src="images/revision.png" alt="revision"/></a></td> 
											<?php } ?>
											<td>
											<?php if(!$check) { ?>
												<form method="post" action="<?php echo base_url().index_page().'new_csr/home/metro_sold/'.$form;?>">
													<input type="text" name="order_id" value="<?php echo $row['id']; ?>" style="display:none">
													<input type="text" name="order_no" value="<?php echo $slug; ?>" style="display:none">
													<button type="submit" name="submit_sold" value="Submit" onclick="return sold_confirm();">Sold</button>
												</form>
											<?php } ?>
											</td>
											</tr>
<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
<?php endif; ?>					
			<!-- END PAGE CONTENT INNER -->
		</div>
	</div>
	<!-- END PAGE CONTENT -->
</div>






<?php $this->load->view("new_csr/foot"); ?>