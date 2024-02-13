<?php 
	$this->load->view("new_designer/head");
?>
<style>
 .padding-15{
     padding: 15px; }
     
  .margin-bottom-50{
      margin-bottom:50px;
  }   
  .margin-top-50{
      margin-top:50px;
  }  
</style>
<div id="main">
<section>
	<div class="container margin-top-50 margin-bottom-50">
		<div class="row">
			<!-- Live Orders Starts-->
			<div class="col-md-6">
				<div class="table-responsive border padding-15">   
					<p class="center">Live Orders</p>
					<table class="table table-striped table-bordered table-hover" id="tracker_table">
						<thead>
							<tr>
								<td width="30%">AdwitAds ID</td>
								<td width="30%">Status</td>
							</tr>  									
						</thead>
					
						<tbody>
							<?php if(isset($live_orders)) { 
								foreach($live_orders as $row) {
								$status = $this->db->query("SELECT * FROM `order_status` WHERE id='".$row['status']."'")->row_array();
							?>
							<tr> 
								<td><?php echo $row['order_id'];?></td>
								<td><button class="btn blue-sunglo btn-xs"><?php echo $status['name'];?></button></td>
							</tr>
							<?php } } ?>
						</tbody> 
					</table>
				</div>
			</div>
			<!-- Live Orders Ends-->
			<!-- Live Revisions Starts-->
			<div class="col-md-6">
				<div class="table-responsive border padding-15">     
					<p>Live Revisions</p>
					<table class="table table-striped table-bordered table-hover" id="tracker_table">
						<thead>
							<tr>
								<td width="30%">AdwitAds ID</td>
								<td width="30%">Status</td>
							</tr>  									
						</thead>
					
						<tbody>
							<?php if(isset($live_revisions)) { 
								foreach($live_revisions as $row) {
								$status = $this->db->query("SELECT * FROM `rev_order_status` WHERE id='".$row['status']."'")->row_array();
							?>
							<tr> 
								<td><?php echo $row['order_id'];?></td>
								<td class="width-105"><?php echo $status['name'];?></td>
							</tr>
							<?php } } ?>
						</tbody> 
					</table>
				</div>
			</div>
			<!-- Live Revisions Ends-->
		</div>
	</div>
</section>
</div>


<!-- BEGIN FOOTER -->
<?php 
	$this->load->view("new_designer/foot");
?>