<?php $this->load->view('new_admin/header.php'); ?>

<div class="row">
<div class="col-md-6">		
	<div class="caption">
		<span class="font-md font-grey-gallery bold"><h3>Request Details</h3></span>
	</div>
</div>		
<div class="col-md-6">
			<?php echo '<span style="color:#900;">'.$this->session->flashdata('message').'</span>'; ?>
</div>
</div>	
	<hr class="margin-top-10">		
<div class="portlet light">
	<div class="portlet-body">
		<div class="row">
		 <form method="get" name="order_form" id="order_form" >
			<div class="col-md-6">
				<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>Request Id</th>
						<th>Type</th>
						<th>Date</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				<?php if(isset($rqt_details)){
						foreach($rqt_details as $row){
						$type_name = $this->db->query("SELECT * FROM `request_type` WHERE `id` = '".$row['type']."' ")->result_array();
					?>
					<tr>
						<td><?php echo $row['id'];?></td>
						<td><?php echo $type_name[0]['name'];?></td>
						<td><?php echo $row['date'];?></td>
						<td><a href="javascript:;" class="btn btn-primary btn-xs" onclick="window.location = '<?php echo base_url().index_page()."new_admin/home/request_develop/".$row['id'];?>'">View</a>
					</tr>
				<?php } }?>
			
				</tbody>
				</table>
			</div>
			</form>
		</div>
	</div>
</div>

	
<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable.php'); ?>