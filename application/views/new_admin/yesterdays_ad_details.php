<?php $this->load->view('new_admin/header')?>

<div class="portlet light">
	<div class="portlet-title">
		<div class="row">	
			<div class="col-md-7 col-xs-12">
				<span class="font-lg">Yesterday's Ads Details - </span> <?php if(isset($cat)) echo $cat; ?>
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
				<th>Publication</th>
				<th>Group</th>
				<th>Help Desk</th>
				<th>Status</th>
				<th>View</th>
				<th>Priority</th>
			</tr>
		</thead>
		<tbody>
		<!--All days -->
		
		<?php if(isset($all_orders)){
				foreach($all_orders as $row){
					$grp_details = $this->db->get_where('Group',array('id' => $row['group_id']))->result_array();
					$hd_details = $this->db->get_where('help_desk',array('id' => $row['help_desk']))->result_array();
					$status_details = $this->db->get_where('order_status',array('id' => $row['status']))->result_array();
					$publi_details = $this->db->get_where('publications',array('id' => $row['publication_id']))->result_array();
		?>
			<tr>
				<td><?php echo date('Y-m-d',strtotime($row['created_on']));  ?></td>
				<td><?php echo $row['id']; ?></td>
				<td><?php echo $publi_details[0]['name'];?></td>
				<td><?php if($row['group_id']=='0'){ echo''; }else{ echo $grp_details[0]['name']; }?></td>
				<td><?php echo $hd_details[0]['name']; ?></td>
				<td><?php echo $status_details[0]['name'];?></td>
				<td><a href="javascript:;" class="btn btn-primary btn-xs" onclick="window.location = '<?php echo base_url().index_page()."new_admin/home/order_review_history/".$row['id'];?>'">View</a></td>
                <td><?php echo $row['time_zone_priority']; ?></td>
			</tr>
		<?php } } ?>
		
		<!-- categorywise -->
		
		<?php if(isset($cat_orders)){
				foreach($cat_orders as $row){
					$grp_details = $this->db->get_where('Group',array('id' => $row['group_id']))->row_array();
					$hd_details = $this->db->get_where('help_desk',array('id' => $row['help_desk']))->row_array();
					$status_details = $this->db->get_where('order_status',array('id' => $row['status']))->row_array();
					$publi_details = $this->db->get_where('publications',array('id' => $row['publication_id']))->row_array();
		?>
			<tr>
				<td><?php echo date('Y-m-d',strtotime($row['created_on']));  ?></td>
				<td><?php echo $row['id']; ?></td>
				<td><?php echo $publi_details['name'];?></td>
				<td><?php if($row['group_id']=='0'){ echo''; }else{ echo $grp_details['name']; }?></td>
				<td><?php echo $hd_details['name']; ?></td>
				<td><?php echo $status_details['name'];?></td>
				<td><a href="javascript:;" class="btn btn-primary btn-xs" onclick="window.location = '<?php echo base_url().index_page()."new_admin/home/order_review_history/".$row['id'];?>'">View</a></td>
                <td><?php echo $row['time_zone_priority']; ?></td>
			</tr>
		<?php } } ?>
		</tbody>
		</table>
	</div>	
</div>

<?php $this->load->view('new_admin/footer')?>
<?php $this->load->view('new_admin/datatable')?>
