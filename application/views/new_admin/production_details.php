<?php $this->load->view('new_admin/header.php'); ?>


<div class="portlet light">
	<div class="portlet-title">
		<div class="row">
			<div class="col-md-6 font-lg font-grey-gallery">
				<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report'; ?>" class="font-grey-gallery">Reports</a> - <a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report/'.$type; ?>" class="font-grey-gallery"><?php echo $type;?></a> -
				<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report/'.$type.'/'.$user; ?>" class="font-grey-gallery"><?php echo $user;?></a> -
				<?php if($user == 'csr') { ?>
				<u><a href="<?php echo base_url().index_page(). 'new_admin/home/report_sales_csr/'.$type.'/'.$user.'?csr_id='.$id.'&month=&from='.$from.'&to='.$to; ?>" class="font-grey-gallery"><?php echo $csr[0]['name'];?></a></u>
				<?php } if($user == 'designer') { ?>
				<u><a href="<?php echo base_url().index_page(). 'new_admin/home/report_sales_designer/'.$type.'/'.$user.'?designer_id='.$id.'&month=&from='.$from.'&to='.$to; ?>" class="font-grey-gallery"><?php echo $designers[0]['name'];?></a></u>
				<?php } if($user == 'help_desk') { ?>
				<u><a href="<?php echo base_url().index_page(). 'new_admin/home/report_sales_hd/'.$type.'/'.$user.'?help_desk_id='.$id.'&month=&from='.$from.'&to='.$to; ?>" class="font-grey-gallery"><?php echo $help_desk[0]['name'];?></a></u>
				<?php } ?>
			
			</div>
			<div class="col-md-6 text-right">	
				<button class="btn bg-grey btn-xs margin-right-10" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
				<span class="cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
			</div>
		</div>
	</div>
	<?php if($user == 'csr') { ?>
	<div class="portlet-body no-space">	
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
					
					<td title="<?php echo $orders_type[0]['name']; ?>"><span class="badge bg-blue"><?php if($orders_type[0]['value']=='print') {echo "P";} elseif($orders_type[0]['value']=='web'){ echo "W";} else{ echo "P&W";}?></span></td>
					
					<td><a href="<?php echo base_url().index_page().'new_admin/home/orderview_history/'.$orders[0]['help_desk'].'/'.$orders[0]['id'].'/'.$id.'/'.$type.'/'.$user.'/'.$from.'/'.$to;?>" type="button" >
					<?php echo $orders[0]['id'] ;?></a></td>
					
					<td><?php echo $orders[0]['job_no'] ;?></td>
					
					<td><?php if(isset($publication)) { echo $publication[0]['name']; } else{ echo " ";}?></td>
					
					<!--<td><?php if($orders[0]['order_type_id']=='1'){ // webad 
						if($orders[0]['pixel_size']=='custom'){?>
						<?php echo $orders[0]['custom_width']; ?>
						<?php } else {
							$size_px = $this->db->get_where('pixel_sizes',array('id'=>$orders[0]['pixel_size']))->result_array();
						?><?php echo $size_px[0]['width']; ?>
						<?php } }else{ //printad ?>
						<?php echo $orders[0]['width']; ?>
					<?php } ?>
					</td>
					
					<td><?php if($orders[0]['order_type_id']=='1'){ // webad 
						if($orders[0]['pixel_size']=='custom') { ?>
						<?php echo $orders[0]['custom_height']; ?>
						<?php } else {
							$size_px = $this->db->get_where('pixel_sizes',array('id'=>$orders[0]['pixel_size']))->result_array();
						?><?php echo $size_px[0]['height']; ?>
						<?php } }else{ //printad ?>
						<?php echo $orders[0]['height']; ?>
					<?php } ?>
					</td>
					
					<td>
					<?php if($orders[0]['pdf_timestamp'] != '0000-00-00 00:00:00'){
								$a = strtotime($orders[0]['created_on']); $b = strtotime($orders[0]['pdf_timestamp']);
								$t = round(abs($b - $a) / 60);
							if($t > '60'){
							printf("%2d<small>h</small> %2d<small>m</small>", round($t / 60), $t % 60);
							}else{ echo round($t).'<small>m</small>';  } }?>
					</td>-->
					
					<td>
					<?php if($orders[0]['pdf'] != 'none') { ?>
						<a href="<?php echo base_url().$orders[0]['pdf'] ?>" target="_Blank" type="button" class="btn bg-red btn-xs"><i class="fa fa-file-pdf-o"></i></a>
					<?php } ?>
					</td>
				</tr>
				<?php } ?>	
			</tbody>
		</table>
	</div><?php } ?>
	
	<?php if($user == 'designer') { ?>
	<div class="portlet-body no-space">	
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
					
					<td title="<?php echo $orders_type[0]['name']; ?>"><span class="badge bg-blue"><?php if($orders_type[0]['value']=='print') {echo "P";} elseif($orders_type[0]['value']=='web'){ echo "W";} else{ echo "P&W";}?></span></td>
					
					<td><a href="<?php echo base_url().index_page().'new_admin/home/orderview_history/'.$orders[0]['help_desk'].'/'.$orders[0]['id'].'/'.$id.'/'.$type.'/'.$user.'/'.$from.'/'.$to;?>" type="button" >
					<?php echo $orders[0]['id'] ;?></a></td>
					
					<td><?php echo $orders[0]['job_no'] ;?></td>
					
					<td><?php if(isset($publication)) { echo $publication[0]['name']; } else{ echo " ";}?></td>
					
					<!--<td><?php if($orders[0]['order_type_id']=='1'){ // webad 
						if($orders[0]['pixel_size']=='custom'){?>
						<?php echo $orders[0]['custom_width']; ?>
						<?php } else {
							$size_px = $this->db->get_where('pixel_sizes',array('id'=>$orders[0]['pixel_size']))->result_array();
						?><?php echo $size_px[0]['width']; ?>
						<?php } }else{ //printad ?>
						<?php echo $orders[0]['width']; ?>
					<?php } ?>
					</td>
					
					<td><?php if($orders[0]['order_type_id']=='1'){ // webad 
						if($orders[0]['pixel_size']=='custom'){?>
						<?php echo $orders[0]['custom_height']; ?>
						<?php } else {
							$size_px = $this->db->get_where('pixel_sizes',array('id'=>$orders[0]['pixel_size']))->result_array();
						?><?php echo $size_px[0]['height']; ?>
						<?php } }else{ //printad ?>
						<?php echo $orders[0]['height']; ?>
					<?php } ?>
					</td>
					
					<td>
					<?php if($orders[0]['pdf_timestamp'] != '0000-00-00 00:00:00'){
								$a = strtotime($orders[0]['created_on']); $b = strtotime($orders[0]['pdf_timestamp']);
								$t = round(abs($b - $a) / 60);
							if($t > '60'){
							printf("%2d<small>h</small> %2d<small>m</small>", round($t / 60), $t % 60);
							}else{ echo round($t).'<small>m</small>';  } }?>
					</td>-->
					
					<td>
					<?php if($orders[0]['pdf'] != 'none') { ?>
						<a href="<?php echo base_url().$orders[0]['pdf'] ?>" target="_Blank" type="button" class="btn bg-red btn-xs"><i class="fa fa-file-pdf-o"></i></a>
					<?php } ?>
					</td>
				</tr>
				<?php } ?>	
			</tbody>
		</table>
	</div><?php } ?>
	
	<?php if($user == 'help_desk') { ?>
	<div class="portlet-body no-space">	
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
				<?php foreach($orders as $row) {
				
						$publication = $this->db->query("SELECT `name` FROM `publications` WHERE `id`='".$row['publication_id']."' ;")->result_array();
					$orders_type = $this->db->query("SELECT * FROM `orders_type` WHERE `id` = '".$row['order_type_id']."'")->result_array();
				?>
				<tr>
					<td><?php $date = strtotime($row['created_on']); echo date('d-M', $date);  ?></td>
					
					<td title="<?php echo $orders_type[0]['name']; ?>"><span class="badge bg-blue"><?php if($orders_type[0]['value']=='print') {echo "P";} elseif($orders_type[0]['value']=='web'){ echo "W";} else{ echo "P&W";}?></span></td>
					
					<td><a href="<?php echo base_url().index_page().'new_admin/home/orderview_history/'.$row['help_desk'].'/'.$row['id'].'/'.$id.'/'.$type.'/'.$user.'/'.$from.'/'.$to;?>" type="button" >
					<?php echo $row['id'] ;?></a></td>
					
					<td><?php echo $row['job_no'] ;?></td>
					
					<td><?php if(isset($publication)) { echo $publication[0]['name']; } else{ echo " ";}?></td>
					
					<td>
					<?php if($row['pdf'] != 'none') { ?>
						<a href="<?php echo base_url().$row['pdf'] ?>" target="_Blank" type="button" class="btn bg-red btn-xs"><i class="fa fa-file-pdf-o"></i></a>
					<?php } ?>
					</td>
				</tr>
				<?php } ?>	
			</tbody>
		</table>
	</div><?php } ?>
</div>

<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable.php'); ?>