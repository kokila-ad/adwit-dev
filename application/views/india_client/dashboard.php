<?php $this->load->view('india_client/header'); ?>

<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				$('#example1').DataTable( {
					"order": [[ 0, "desc" ]]
				} );
			} );
			$(document).ready(function() {
				$('#example2').DataTable( {
					"order": [[ 0, "desc" ]]
				} );
			} );
			
			$(document).ready(function() {
				$('#example1').DataTable();
			} );
			
			$(document).ready(function() {
				$('#example2').DataTable();
			} );
			
</script>	
<script>window.SHOW_LOADING = false;</script>
<script>
		  $(document).ready(function(){
		  $("#show-search").hide();
		  $("#show-request").hide();
		  
		  $("#open-search").click(function(){
		  $("#show-search").toggle();     
		   });
		   
		  $("#orders").click(function(){
		  $("#show-orders").show();  
		  $("#show-request").hide();  
		   });
		   
		  $("#request").click(function(){
		  $("#show-request").show(); 
		  $("#show-orders").hide();   
		   });
			 
		  });
</script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
   
<section>
    <div class="container margin-vertical-50"> 
		<div role="tabpanel">
           <div class="row">
		      <div class="col-md-8">
				<p class="xlarge">Dashboard</p>
			  </div>
				
			  <div class="col-md-4 text-right"><p class="btn btn-blue text-blue padding-top-10 cursor-pointer" id="open-search">Search</p></div>
				<div class="col-md-12 margin-top-20" id="show-search">
					<?php $this->load->view('india_client/order_search');//search tab ?>
				</div>
				<?php echo $this->session->flashdata('message'); ?>
                    <div class="col-md-12">
                        <div class="tab-content padding-top-25">
							
<div role="tabpanel" class="tab-pane fade active in" id="docs-tabs-1">


<!-- Order Details -->
<?php if(isset($order_details)) { ?>
      <div class="table-responsive border padding-15">     
			<table class="table table-striped table-bordered table-hover" id="example1">
				<thead>
					<tr>
						<th>Adwit Ads ID</th>
						<th>Date</th>
						<th>Unique Job ID</th>
						<th>Client Name</th>
						<th>Date Needed</th>
						<th>Status</th>
						<th>PDF</th>
						<th class="center">Actions</th>	
													
					</tr>  		 									
				</thead>
				<tbody>	
		<?php 
			foreach($order_details as $row) { 
				$orders_rev = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `id`=(SELECT MAX(`id`) FROM `rev_sold_jobs` WHERE `order_id`='".$row['id']."')")->result_array();
				if($orders_rev){
					$order_status = $orders_rev[0]['status'];
					$order_status_name = $this->db->query("SELECT * FROM `rev_order_status` WHERE `id` = $order_status")->result_array();
					$pdf_path = $orders_rev[0]['pdf_path'];
					if(!file_exists($pdf_path)){
						$pdf_path = $orders_rev[0]['pdf_path'].'/'.$orders_rev[0]['pdf_file'];
					}
				}else{
					$order_status = $row['status'];
					$order_status_name = $this->db->query("SELECT * FROM `order_status` WHERE `id` = $order_status")->result_array();
					if($row['pdf']!='none'){ 
						$pdf_path = $row['pdf'];
						if(!file_exists($pdf_path)){
							$pdf_path = 'pdf_uploads/'.$row['id'].'/'.$row['pdf']; 
						}
					}
					if($row['crequest']!='0'){ $order_status = 'Cancel Requested'; }//csr order cancellation req
					if($row['cancel']!='0'){ $order_status = 'Cancelled'; }//adrep order cancellation
				}
		?>
				<tr> 
<!-- order id -->	
					<td><?php if($orders_rev) { ?>
						<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'india_client/home/revision_details/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;">
							<?php echo $row['id']; ?>
						</a>
						<?php }else{ echo $row['id']; }  ?>
					</td>
<!-- Date -->					
					<td><?php echo date("M-d",strtotime($row['created_on']));?></td>
<!-- Unique Job ID -->					
					<td><?php echo $row['job_no']; ?></td>
<!-- Client Name -->					
					<td><?php echo $row['advertiser_name']; ?></td>
<!-- Date Needed -->					
					<td><?php echo date("M-d",strtotime($row['date_needed']));?></td>
<!-- Status -->
					<td>
						<?php if($row['question']=='1'){ ?>
						<!-- Question sent for Answer -->
						<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'india_client/home/new_ad_answer/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;">
						<button class="btn-danger btn-sm">Question</button></a>
						<?php }elseif($orders_rev && $orders_rev[0]['question']!='' && $orders_rev[0]['answer']=='none'){ ?>
						<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'india_client/home/rev_ad_answer/'.$orders_rev[0]['id'];?>'" style="cursor:pointer; text-decoration: none;">
						<button class="btn-danger btn-sm" title="<?php echo $orders_rev[0]['question']; ?>">Question</button></a>
						<?php } else{ ?>
						<?php echo $order_status_name[0]['name']; ?> 
						<?php } ?>
					</td>
<!-- PDF -->
					<td>
						<?php if(($order_status == '5' || $order_status == '10') && $pdf_path != 'none' && file_exists($pdf_path)){ ?>
								<a href="<?php echo base_url().$pdf_path;?>" target="_blank" style="cursor:pointer; text-decoration: none;">
									<i class="fa fa-file-pdf-o"></i>
								</a>
						<?php  }else{ echo ""; } ?>
					</td>
<!-- Actions -->				
					<td>
						<span class="dropdown">
						<span class="cursor-pointer" type="button" data-toggle="dropdown">Actions<span class="caret"></span></span>
						<ul class="dropdown-menu">
						<?php 
							$actions = $this->db->get_where('order_adrep_actions',array('order_status_id' => $order_status))->result_array();
							foreach($actions as $data){
								$action_link = $this->db->get_where('adrep_actions',array('id' => $data['adrep_action_id']))->result_array(); 
						?>
						<!--	<li><a href="<?php echo base_url().index_page().'india_client/home/order_action'.'/'.$row['id'].'/'.$action_link[0]['id'];?>" data-toggle="tooltip" class="margin-right-25 margin-left-15"><?php echo $action_link[0]['name']; ?></a></li>-->
						 <li><a href="<?php echo base_url().index_page().'india_client/home/order_action/'.$action_link[0]['action'].'/'.$row['id'];?>" data-toggle="tooltip" class="margin-right-25 margin-left-15"><?php echo $action_link[0]['name']; ?></a></li> 
						<?php } ?>
						</ul>
						</span>
					</td>
					
				</tr>
				
	<?php } ?>
		</tbody>         
	</table>
	</div>
<?php } elseif(isset($tl_order_details)){ ?>  


      <div class="table-responsive border padding-15">     
			<table class="table table-striped table-bordered table-hover" id="example1">
				<thead>
					<tr>
						<th>Adwit Ads ID</th>
						<th>Date</th>
						<th>Unique Job ID</th>
						<th>Client Name</th>
						<th>Adrep Name</th>
						<th>Date Needed</th>
						<th>Status</th>
						<th>PDF</th>
						<th class="center">Actions</th>	
													
					</tr>  		 									
				</thead>
				<tbody>	
		<?php 
			foreach($tl_order_details as $row) { 
				$orders_rev = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `id`=(SELECT MAX(`id`) FROM `rev_sold_jobs` WHERE `order_id`='".$row['id']."')")->result_array();
				if($orders_rev){
					$order_status = $orders_rev[0]['status'];
					$order_status_name = $this->db->query("SELECT * FROM `rev_order_status` WHERE `id` = $order_status")->result_array();
					$pdf_path = $orders_rev[0]['pdf_path'];
					if(!file_exists($pdf_path)){
						$pdf_path = $orders_rev[0]['pdf_path'].'/'.$orders_rev[0]['pdf_file'];
					}
				}else{
					$order_status = $row['status'];
					$order_status_name = $this->db->query("SELECT * FROM `order_status` WHERE `id` = $order_status")->result_array();
					if($row['pdf']!='none'){ 
						$pdf_path = $row['pdf'];
						if(!file_exists($pdf_path)){
							$pdf_path = 'pdf_uploads/'.$row['id'].'/'.$row['pdf']; 
						}
					}
					if($row['crequest']!='0'){ $order_status = 'Cancel Requested'; }//csr order cancellation req
					if($row['cancel']!='0'){ $order_status = 'Cancelled'; }//adrep order cancellation
				}
		?>
				<tr> 
<!-- order id -->	
					<td><?php if($orders_rev) { ?>
						<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'india_client/home/revision_details/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;">
							<?php echo $row['id']; ?>
						</a>
						<?php }else{ echo $row['id']; }  ?>
					</td>
<!-- Date -->					
					<td><?php echo date("M-d",strtotime($row['created_on']));?></td>
<!-- Unique Job ID -->					
					<td><?php echo $row['job_no']; ?></td>
<!-- Client Name -->					
					<td><?php echo $row['advertiser_name']; ?></td>
					
<!-- Adrep Name -->					
					<td><?php $adrep = $this->db->get_where('adreps',array('id' => $row['adrep_id']))->result_array();
						echo $adrep[0]['first_name'];
					?></td>
<!-- Date Needed -->					
					<td><?php echo date("M-d",strtotime($row['date_needed']));?></td>
<!-- Status -->
					<td>
						<?php if($row['question']=='1'){ ?>
						<!-- Question sent for Answer -->
						<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'india_client/home/new_ad_answer/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;">
						<button class="btn btn-primary btn-sm">Question</button></a>
						<?php }elseif($orders_rev && $orders_rev[0]['question']!='' && $orders_rev[0]['answer']=='none'){ ?>
						<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'india_client/home/rev_ad_answer/'.$orders_rev[0]['id'];?>'" style="cursor:pointer; text-decoration: none;">
						<button class="btn-danger btn-sm" title="<?php echo $orders_rev[0]['question']; ?>">Question</button></a>
						<?php } else{ ?>
						<?php echo $order_status_name[0]['name']; ?> 
						<?php } ?>
					</td>
<!-- PDF -->
					<td class="center">
						<?php if(($order_status == '5' || $order_status == '10') && $pdf_path != 'none' && file_exists($pdf_path)){ ?>
								<a href="<?php echo base_url().$pdf_path;?>" target="_blank" style="cursor:pointer; text-decoration: none;">
									<img src="http://www.adwitads.com/weborders/images/pdf.png" alt="PDF">
								</a>
						<?php  }else{ echo ""; } ?>
					</td>
<!-- Actions -->				
					<td>
						<span class="dropdown">
						<span class="cursor-pointer" type="button" data-toggle="dropdown">Actions<span class="caret"></span></span>
						<ul class="dropdown-menu">
						<?php 
							$actions = $this->db->get_where('order_adrep_actions',array('order_status_id' => $order_status))->result_array();
							foreach($actions as $data){
								$action_link = $this->db->get_where('adrep_actions',array('id' => $data['adrep_action_id']))->result_array(); 
						?>
						<!--	<li><a href="<?php echo base_url().index_page().'india_client/home/order_action'.'/'.$row['id'].'/'.$action_link[0]['id'];?>" data-toggle="tooltip" class="margin-right-25 margin-left-15"><?php echo $action_link[0]['name']; ?></a></li>-->
						 <li><a href="<?php echo base_url().index_page().'india_client/home/order_action/'.$action_link[0]['action'].'/'.$row['id'];?>" data-toggle="tooltip" class="margin-right-25 margin-left-15"><?php echo $action_link[0]['name']; ?></a></li> 
						<?php } ?>
						</ul>
						</span>
					</td>
					
				</tr>
				
	<?php } ?>
		</tbody>         
	</table>
	</div>



<?php } elseif(isset($requests_details)){ ?>  
 <!--Request List -->
		<div class="table-responsive border padding-15">     
			<table class="table table-striped table-bordered table-hover" id="example2">
				<thead>
					<tr>
						<th>Request ID</th>
						<th>Subject</th>
						<th>Message</th>
					</tr>  		 									
				</thead>
				<tbody>	
	<?php foreach($requests_details as $row){ ?>
					<tr>       
						<td><?php echo $row['id'];?></td>
						<td><?php echo $row['subject']; ?></td>
						<td><?php echo $row['message']; ?></td>
					</tr>
	<?php } ?>
				</tbody>         
			</table>
		</div>
	<?php } ?>
</div>
												
</div><!-- /.tab-content -->
</div>
           </div>
        </div>
	</div>
</section>


<?php $this->load->view('india_client/footer'); ?>



