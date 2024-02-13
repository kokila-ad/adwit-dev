<?php $this->load->view('new_admin/header')?>


<div class="portlet light">
	<div class="portlet-title">
		<div class="row">	
			<div class="col-md-7 col-xs-12">
				<span class="font-lg"> Pending Helpdesk Status</span> 
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
				<th>Order Id</th>
				<th>Advertiser Name</th>
				<th>Publication Name</th>
				<th>Adrep Name</th>
				<th>Status</th>
				<!--<th>View PDF</th>-->
			</tr>
		</thead>
		<tbody>
		<!--Mon -->
		
		<?php if(isset($dbyst_all_orders)){?>
		<?php	foreach($dbyst_all_orders as $row){
				$adrep_name = $this->db->get_where('adreps',array('id' => $row['adrep_id']))->result_array();
				$publication_name = $this->db->get_where('publications',array('id'=> $row['publication_id']))->result_array();
				$status = $this->db->get_where('order_status',array('id' => $row['status']))->result_array();
				?>
			<tr>
				<td><a href="<?php echo base_url().index_page().'new_admin/home/orderview_history/'.$row['help_desk'].'/'.$row['id'];?>"><?php echo $row['id']; ?></a></td>	
				<td><?php echo $row['advertiser_name']; ?></td>
				<td><?php echo $publication_name[0]['name'];?></td>
				<td><?php echo $adrep_name[0]['first_name'].' '.$adrep_name[0]['last_name'];?></td>
				<td><?php echo $status[0]['name']?></td>
				<!--<td>
					<?php if($row['pdf'] != 'none') { ?>
						<a href="<?php echo base_url().$row['pdf'] ?>" target="_Blank" type="button" class="btn bg-red btn-xs"><i class="fa fa-file-pdf-o"></i></a>
					<?php } ?>
				</td>-->
			</tr>
		<?php } } ?>
		<!--Mon & Sun -->
		
		<?php if(isset($dbyyst_all_orders)){?>
			<?php foreach($dbyyst_all_orders as $row){
					$adrep_name = $this->db->get_where('adreps',array('id' => $row['adrep_id']))->result_array();
					$publication_name = $this->db->get_where('publications',array('id'=> $row['publication_id']))->result_array();
					$status = $this->db->get_where('order_status',array('id' => $row['status']))->result_array();
					?>
			<tr>
				<td><a href="<?php echo base_url().index_page().'new_admin/home/orderview_history/'.$row['help_desk'].'/'.$row['id'];?>"><?php echo $row['id']; ?></a></td>	
				<td><?php echo $row['advertiser_name']; ?></td>
				<td><?php echo $publication_name[0]['name']; ?></td>
				<td><?php echo $adrep_name[0]['first_name'].' '.$adrep_name[0]['last_name'];?></td>
				<td><?php echo $status[0]['name']?></td>
			<!--	<td>
					<?php if($row['pdf'] != 'none') { ?>
						<a href="<?php echo base_url().$row['pdf'] ?>" target="_Blank" type="button" class="btn bg-red btn-xs"><i class="fa fa-file-pdf-o"></i></a>
					<?php } ?>
				</td> -->
			</tr>
		<?php } }?>
		
		<!--All days -->
		
		<?php if(isset($all_orders)){?>
			<?php foreach($all_orders as $row){
					$adrep_name = $this->db->get_where('adreps',array('id' => $row['adrep_id']))->result_array();
					$publication_name = $this->db->get_where('publications',array('id'=> $row['publication_id']))->result_array();
					$status = $this->db->get_where('order_status',array('id' => $row['status']))->result_array();
					?>
			<tr>
				<td><a href="<?php echo base_url().index_page().'new_admin/home/orderview_history/'.$row['help_desk'].'/'.$row['id'];?>"><?php echo $row['id']; ?></a></td>	
				<td><?php echo $row['advertiser_name']; ?></td>
				<td><?php echo $publication_name[0]['name'];?></td>
				<td><?php echo $adrep_name[0]['first_name'].' '.$adrep_name[0]['last_name'];?></td>
				<td><?php echo $status[0]['name']?></td>
			<!--	<td>
					<?php if($row['pdf'] != 'none') { ?>
						<a href="<?php echo base_url().$row['pdf'] ?>" target="_Blank" type="button" class="btn bg-red btn-xs"><i class="fa fa-file-pdf-o"></i></a>
					<?php } ?>
				</td> -->
			</tr>
		<?php } } ?>
		
		</tbody>
		</table>
	</div>	
</div>

<?php $this->load->view('new_admin/footer')?>
<?php $this->load->view('new_admin/datatable')?>
