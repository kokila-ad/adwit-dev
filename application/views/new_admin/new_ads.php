<?php $this->load->view('new_admin/header')?>

<div class="portlet light">
	<div class="portlet-title">
		<div class="row">	
			<div class="col-md-7 col-xs-12">
				<span class="font-lg">New Ads Details</span> 
			</div>				
			<div class="col-md-5 col-xs-12 text-right">	
				<span class=" cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
			</div>
		</div>
	</div>
		
	<div class="portlet-body">
		<table class="table table-bordered table-hover" id="sample_6">
		<thead>
			<tr>
				<th>Date</th>
				<th>Adwitads ID</th>
				<th>Help Desk</th>
				<th>Publication</th>
				<th>Status</th>
				<th>View</th>
			</tr>
		</thead>
		<tbody>
		
		<?php if(isset($new_ads)){
				foreach($new_ads as $row){
					$hd_details = $this->db->get_where('help_desk',array('id' => $row['help_desk']))->result_array();
					$status_details = $this->db->get_where('order_status',array('id' => $row['status']))->result_array();
					$publi_details = $this->db->get_where('publications',array('id' => $row['publication_id']))->result_array();
		?>
			<tr>
				<td><?php echo date('Y-m-d',strtotime($row['created_on'])); ?></td>
				<td><?php echo $row['id']; ?></td>
				<td><?php echo $hd_details[0]['name']; ?></td>
				<td><?php echo $publi_details[0]['name'];?></td>
				<td><?php echo $status_details[0]['name']; ?></td>
				<td><a href="javascript:;" class="btn btn-primary btn-xs" onclick="window.location = '<?php echo base_url().index_page()."new_admin/home/orderview_history/".$row['help_desk'].'/'.$row['id'];?>'">View</a></td>
			</tr>
		<?php } } ?>
		
		
		</tbody>
		</table>
	</div>	
</div>

<?php $this->load->view('new_admin/footer')?>
<?php $this->load->view('new_admin/datatable')?>
