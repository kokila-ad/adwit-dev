<?php $this->load->view('new_admin/header')?>

<div class="portlet light">
	<div class="portlet-title">
		<div class="row">	
			<div class="col-md-7 col-xs-12">
				<span class="font-lg">Pending Status</span> 
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
				<th>AdwitAds Id</th>
				<th>Helpdesk Name</th>
				<th>Publication Name</th>
				<th>Status</th>
				<th>Priority</th>
			</tr>
		</thead>
		<tbody>
		<!--Mon -->
		
		<?php if(isset($dbyst_all_orders)){?>
		<?php	foreach($dbyst_all_orders as $row){
				$hd_name = $this->db->query("SELECT * FROM `help_desk` WHERE `id` = '".$row['help_desk']."'")->result_array();
				$status_name = $this->db->query("SELECT * FROM `order_status` WHERE `id` = '".$row['status']."'")->result_array();
				$adrep_name = $this->db->query("SELECT * FROM `adreps` WHERE `id` = '".$row['adrep_id']."'")->row_array();
				$publication_name = $this->db->query("SELECT * FROM `publications` WHERE `id` = '".$adrep_name['publication_id']."'")->row_array();
				
			?>
			<tr>
				<td><a href="<?php echo base_url().index_page().'new_admin/home/orderview_history/'.$row['group_id'].'/'.$row['id'];?>"><?php echo $row['id']; ?></a></td>	
				<td><?php echo $hd_name[0]['name']; ?></td>
				<td><?php echo $publication_name['name'];?></td>
				<td><?php echo $status_name[0]['name'];?></td>
				<td><?php echo $row['time_zone_priority']; ?></td>
			</tr>
		<?php } } ?>
		<!--Mon & Sun -->
		
		<?php if(isset($dbyyst_all_orders)){?>
			<?php foreach($dbyyst_all_orders as $row){
			$hd_name = $this->db->query("SELECT * FROM `help_desk` WHERE `id` = '".$row['help_desk']."'")->result_array();
				$status_name = $this->db->query("SELECT * FROM `order_status` WHERE `id` = '".$row['status']."'")->result_array();
				$adrep_name = $this->db->query("SELECT * FROM `adreps` WHERE `id` = '".$row['adrep_id']."'")->row_array();
				$publication_name = $this->db->query("SELECT * FROM `publications` WHERE `id` = '".$adrep_name['publication_id']."'")->row_array();
			?>
			<tr>
				<td><a href="<?php echo base_url().index_page().'new_admin/home/orderview_history/'.$row['group_id'].'/'.$row['id'];?>"><?php echo $row['id']; ?></a></td>	
				<td><?php echo $hd_name[0]['name']; ?></td>
				<td><?php echo $publication_name['name'];?></td>
				<td><?php echo $status_name[0]['name'];?></td>
				<td><?php echo $row['time_zone_priority']; ?></td>
			</tr>
		<?php } }?>
		
		<!--All days -->
		
		<?php if(isset($all_orders)){?>
			<?php foreach($all_orders as $row){
				$hd_name = $this->db->query("SELECT * FROM `help_desk` WHERE `id` = '".$row['help_desk']."'")->result_array();
				$status_name = $this->db->query("SELECT * FROM `order_status` WHERE `id` = '".$row['status']."'")->result_array();
				$adrep_name = $this->db->query("SELECT * FROM `adreps` WHERE `id` = '".$row['adrep_id']."'")->row_array();
				$publication_name = $this->db->query("SELECT * FROM `publications` WHERE `id` = '".$adrep_name['publication_id']."'")->row_array();
				?>
			
			<tr>
				<td><a href="<?php echo base_url().index_page().'new_admin/home/orderview_history/'.$row['group_id'].'/'.$row['id'];?>"><?php echo $row['id']; ?></a></td>	
				<td><?php echo $hd_name[0]['name']; ?></td>
				<td><?php echo $publication_name['name'];?></td>
				<td><?php echo $status_name[0]['name'];?></td>
				<td><?php echo $row['time_zone_priority']; ?></td>
			</tr>
		<?php } } ?>
		
		</tbody>
		</table>
	</div>	
</div>

<?php $this->load->view('new_admin/footer')?>
<?php $this->load->view('new_admin/datatable')?>
