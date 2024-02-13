<?php $this->load->view('new_admin/header.php'); ?>

<div class="portlet light">
	<div class="portlet-title">
		<div class="row">
			<div class="col-md-6 font-lg font-grey-gallery">
				<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report'; ?>" class="font-grey-gallery">Reports</a> - 
				<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report/'.$type; ?>" class="font-grey-gallery"><?php echo $type;?></a> -
				<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report/'.$type.'/'.$user; ?>" class="font-grey-gallery"><?php echo $user;?></a> 
				-
				<?php if($user == 'adrep') { ?>
				<u><a href="<?php echo base_url().index_page(). 'new_admin/home/report_sales_adrep/'.$type.'/'.$user.'?adrep_id='.$id.'&order_type='.$order_type.'&date='.$date; ?>" class="font-grey-gallery"><?php echo $adrep[0]['first_name'].' '.$adrep[0]['last_name'];?></a></u>
				<?php } if($user == 'publications') { ?>
				<u><a href="<?php echo base_url().index_page(). 'new_admin/home/report_sales_publication/'.$type.'/'.$user.'?publication_id='.$id.'&order_type='.$order_type.'&date='.$date; ?>" class="font-grey-gallery"><?php echo $publication[0]['name'];?></a></u>
				<?php } if($user == 'groups') { ?>
				<u><a href="<?php echo base_url().index_page(). 'new_admin/home/report_sales_group/'.$type.'/'.$user.'?group_id='.$id.'&order_type='.$order_type.'&date='.$date; ?>" class="font-grey-gallery"><?php echo $group_name[0]['name'];?></a></u>
				<?php } ?>
			</div>
			<div class="col-md-6 text-right">
				<button class="btn bg-grey btn-xs" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
				<span class="cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
			</div>
		</div>
	</div>
	<!--ADREP--->
	<?php if($user == 'adrep') { ?>
	<div class="portlet-body no-space">	
		<table class="table table-bordered table-hover" id="sample_6">
			<thead>
				<tr>
					<th>Date</th>
					<th>Type</th>
					<th>AdwitAds ID</th>
					<th>Unique Job Name</th>
					<th>Publication</th>
					<th>Time Taken</th>
					<th>PDF</th>
					
				</tr>
			</thead>
			<tbody>
				<?php foreach($orders as $row) {
					$rev_orders = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id` = '".$row['id']."' AND (`pdf_path` != 'none')")->result_array();
					$publication = $this->db->query("SELECT `name` FROM `publications` WHERE `id`='".$row['publication_id']."' ;")->result_array();		
					$adreps = $this->db->query("SELECT `first_name` FROM `adreps` WHERE `id`='".$row['adrep_id']."' ;")->result_array();
					$orders_type = $this->db->query("SELECT * FROM `orders_type` WHERE `id` = '".$row['order_type_id']."'")->result_array();
					if(isset($rev_orders[0]['order_id'])){ 
					foreach($rev_orders as $rev_row){
					?>
				<tr>
					<td><?php $date = strtotime($rev_row['date']); echo date('d-M', $date);  ?></td>
					<td title="<?php echo $orders_type[0]['name']; ?>"><span class="badge bg-blue"><?php if($orders_type[0]['value']=='print') {echo "P";} elseif($orders_type[0]['value']=='web'){ echo "W";} else{ echo "P&W";}?></span></td>
					<td><?php echo $rev_row['order_id'] ; ?></td>
					<td><?php echo $rev_row['new_slug'] ; ?></td>
					<td><?php if(isset($publication)) { echo $publication[0]['name']; } else{ echo " ";}?></td>
					<td><?php echo $rev_row['time_taken'] ; ?></td>
					<td><?php if($rev_row['pdf_path'] != 'none') { ?>
						<a href="<?php echo base_url().$rev_row['pdf_path'] ?>" target="_Blank" type="button" class="btn bg-red btn-xs"><i class="fa fa-file-pdf-o"></i></a>
					<?php } ?></td>
					
				</tr>
				<?php } } } ?>	
			</tbody>
		</table>
	</div>
	<?php } ?>
	<!--ADREP--->
	
	<!--PUBLICATION--->
	<?php if($user == 'publications') { ?>
	<div class="portlet-body no-space">	
		<table class="table table-bordered table-hover" id="sample_6">
			<thead>
				<tr>
					<th>Date</th>
					<th>Type</th>
					<th>AdwitAds ID</th>
					<th>Unique Job Name</th>
					<th>Publication</th>
					<th>Time Taken</th>
					<th>PDF</th>
					
				</tr>
			</thead>
			<tbody>
				<?php foreach($orders as $row) {
					$rev_orders = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id` = '".$row['id']."' AND (`pdf_path` != 'none')")->result_array();
						$publication = $this->db->query("SELECT `name` FROM `publications` WHERE `id`='".$row['publication_id']."' ;")->result_array();		
					$adreps = $this->db->query("SELECT `first_name` FROM `adreps` WHERE `id`='".$row['adrep_id']."' ;")->result_array();
					$orders_type = $this->db->query("SELECT * FROM `orders_type` WHERE `id` = '".$row['order_type_id']."'")->result_array();
					if(isset($rev_orders[0]['order_id'])){ 
					foreach($rev_orders as $rev_row){
					?>
				<tr>
					<td><?php $date = strtotime($rev_row['date']); echo date('d-M', $date);  ?></td>
					<td title="<?php echo $orders_type[0]['name']; ?>"><span class="badge bg-blue"><?php if($orders_type[0]['value']=='print') {echo "P";} elseif($orders_type[0]['value']=='web'){ echo "W";} else{ echo "P&W";}?></span></td>
					<td><a href="<?php echo base_url().index_page().'new_admin/home/orderview_history/'.$rev_row['help_desk'].'/'.$rev_row['order_id'].'/'.$id.'/'.$type.'/'.$user.'/'.$from.'/'.$to.'/'.$order_type;?>" type="button" ><?php echo $rev_row['order_id'] ; ?></a></td>
					<td><?php echo $rev_row['new_slug'] ; ?></td>
					<td><?php if(isset($publication)) { echo $publication[0]['name']; } else{ echo " ";}?></td>
					<td><?php $t = round(abs($rev_row['time_taken']) / 60) ;
						if($t > '60'){
							printf("%2d<small>h</small> %2d<small>m</small>", round($t / 60), $t % 60);
						}else{ echo round($t).'<small>m</small>';  } ?>
					</td>
					<td><?php if($rev_row['pdf_path'] != 'none') { ?>
						<a href="<?php echo base_url().$rev_row['pdf_path'] ?>" target="_Blank" type="button" class="btn bg-red btn-xs"><i class="fa fa-file-pdf-o"></i></a>
					<?php } ?></td>
					
				</tr>
				<?php } } } ?>	
			</tbody>
		</table>
	</div>
	<?php } ?>
	<!--PUBLICATION--->
	
	<!--GROUPS--->
	<?php if($user == 'groups') { ?>
	<div class="portlet-body no-space">	
		<table class="table table-bordered table-hover" id="sample_6">
			<thead>
				<tr>
					<th>Date</th>
					<th>Type</th>
					<th>AdwitAds ID</th>
					<th>Unique Job Name</th>
					<th>Publication</th>
					<th>Time Taken</th>
					<th>PDF</th>
					
				</tr>
			</thead>
			<tbody> 
				<?php foreach($orders as $row) {
					$rev_orders = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id` = '".$row['id']."' AND (`pdf_path` != 'none')")->result_array();
						$publication = $this->db->query("SELECT `name` FROM `publications` WHERE `id`='".$row['publication_id']."' ;")->result_array();		
						$adreps = $this->db->query("SELECT `first_name` FROM `adreps` WHERE `id`='".$row['adrep_id']."' ;")->result_array();	
						$orders_type = $this->db->query("SELECT * FROM `orders_type` WHERE `id` = '".$row['order_type_id']."'")->result_array();
						if(isset($rev_orders[0]['order_id'])){ 
							foreach($rev_orders as $rev_row){
					?>
				<tr>
					<td><?php $date = strtotime($rev_row['date']); echo date('d-M', $date);  ?></td>
					<td title="<?php echo $orders_type[0]['name']; ?>"><span class="badge bg-blue"><?php if($orders_type[0]['value']=='print') {echo "P";} elseif($orders_type[0]['value']=='web'){ echo "W";} else{ echo "P&W";}?></span></td>
					<td><a href="<?php echo base_url().index_page().'new_admin/home/orderview_history/'.$rev_row['help_desk'].'/'.$rev_row['order_id'].'/'.$id.'/'.$type.'/'.$user.'/'.$from.'/'.$to.'/'.$order_type;?>" type="button" ><?php echo $rev_row['order_id'] ; ?></a></td>
					<td><?php echo $rev_row['new_slug'] ; ?></td>
					<td><?php if(isset($publication)) { echo $publication[0]['name']; } else{ echo " ";}?></td>
					<td><?php $t = round(abs($rev_row['time_taken']) / 60) ;
						if($t > '60'){
							printf("%2d<small>h</small> %2d<small>m</small>", round($t / 60), $t % 60);
						}else{ echo round($t).'<small>m</small>';  } ?>
					</td>
					<td><?php if($rev_row['pdf_path'] != 'none') { ?>
						<a href="<?php echo base_url().$rev_row['pdf_path'] ?>" target="_Blank" type="button" class="btn bg-red btn-xs"><i class="fa fa-file-pdf-o"></i></a>
					<?php } ?></td>
					
				</tr>
				<?php } } } ?>	
			</tbody>
		</table>
	</div>
	<?php } ?>
	<!--GROUPS--->
</div>
	  	   
<?php $this->load->view('new_admin/footer.php'); ?> 
<?php $this->load->view('new_admin/datatable.php'); ?> 