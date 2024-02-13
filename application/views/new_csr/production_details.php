<?php $this->load->view('new_csr/head.php'); ?>

<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<!-- BEGIN PAGE CONTENT -->
	<div class="page-content">
		<div class="container">
			<div class="portlet light">
				<div class="portlet-title">
					<div class="row">
						<div class="col-md-6 font-lg margin-top-10">
							<p class="hidden">Production Details</p> 
						</div>
						<div class="col-md-6 text-right margin-top-5">	
							<button class="btn bg-grey btn-xs margin-right-10" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
							<span class="cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
						</div>
					</div>
				</div>
				
				<div class="portlet-body">	
					<table class="table table-bordered table-hover" id="sample_6">
						<thead>
							<tr>
								<th>Date</th>
								<th>Type</th>
								<th>AdwitAds ID</th>
								<th>Unique Job Name</th>
								<th>Publication</th>
								<th>PDF</th>	
							</tr>
						</thead>
						<tbody>
							<?php foreach($cat_result as $row) {
									$orders = $this->db->query("SELECT * FROM `orders` WHERE `id` = '".$row['order_no']."'")->result_array();
									$publication = $this->db->query("SELECT `name` FROM `publications` WHERE `id`='".$orders[0]['publication_id']."' ;")->result_array();
								$orders_type = $this->db->query("SELECT * FROM `orders_type` WHERE `id` = '".$orders[0]['order_type_id']."'")->result_array();
							?>
							<tr>
								<td><?php $date = strtotime($orders[0]['created_on']); echo date('d-M', $date);  ?></td>
								
								<td title="<?php echo $orders_type[0]['name']; ?>"><?php if($orders_type[0]['value']=='print') {echo "PrintAd";} elseif($orders_type[0]['value']=='web'){ echo "WebAd";} else{ echo "Print&Web Ad";}?></td>
								
								<td>
								<?php if($csr[0]['csr_role'] == '0') { ?>
								<a href="<?php echo base_url().index_page().'new_csr/home/orderview_history/'.$orders[0]['help_desk'].'/'.$orders[0]['id'];?>" type="button" >
								<?php echo $orders[0]['id'] ;?></a><?php }else{ echo $orders[0]['id'] ;} ?>
								</td>
								
								<td><?php echo $orders[0]['job_no'] ;?></td>
								
								<td><?php if(isset($publication)) { echo $publication[0]['name']; } else{ echo " ";}?></td>
								
								
								<td>
								<?php if($orders[0]['pdf'] != 'none') { ?>
									<a href="<?php echo base_url().$orders[0]['pdf'] ?>" target="_Blank" type="button" class="btn bg-red btn-xs"><i class="fa fa-file-pdf-o"></i></a>
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
</div>	
	<!-- BEGIN FOOTER -->
<?php $this->load->view('new_csr/foot.php'); ?>