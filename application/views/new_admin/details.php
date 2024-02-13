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
				<u><a href="<?php echo base_url().index_page(). 'new_admin/home/report_sales_publication/'.$type.'/'.$user.'?publication_id='.$id.'&order_type='.$order_type.'$date='.$date; ?>" class="font-grey-gallery"><?php echo $publication[0]['name'];?></a></u>
				<?php } if($user == 'groups') { ?>
				<u><a href="<?php echo base_url().index_page(). 'new_admin/home/report_sales_group/'.$type.'/'.$user.'?group_id='.$id.'&order_type='.$order_type.'date='.$date; ?>" class="font-grey-gallery"><?php echo $group_name[0]['name'];?></a></u>
				<?php } ?>
			</div>
			<div class="col-md-6 text-right">	
				<button class="btn bg-grey btn-xs margin-right-10" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
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
					<th>Advertiser</th>
					<th>Width</th>
					<th>Height</th>
					<th>Time Taken</th>
					<th>PDF</th>
					<th>Form</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($orders as $row) {
						//get latest pdf check in rev_sold_jobs get recent revision if exists
						$order_id = $row['id'];
						$pdf_path = 'none';
					    $rev_sold_jobs_recent = $this->db->query("SELECT rev_sold_jobs.id, rev_sold_jobs.pdf_path, rev_sold_jobs.pdf_file FROM `rev_sold_jobs` WHERE `order_id` = '$order_id' ORDER BY `id` DESC LIMIT 1;")->row_array();
					    if(isset($rev_sold_jobs_recent['id'])){
					        if($rev_sold_jobs_recent['pdf_path']!='none'){
					            $pdf_path = $rev_sold_jobs_recent['pdf_path'];
							    if(!file_exists($pdf_path)){ $pdf_path = $rev_sold_jobs_recent['pdf_path'].'/'.$rev_sold_jobs_recent['pdf_file']; }
					        }
						}else{
						    if($row['pdf']!='none'){ 
								$pdf_path = $row['pdf'];
								if(!file_exists($pdf_path)){ $pdf_path = 'pdf_uploads/'.$row['id'].'/'.$row['pdf']; }
							}
						}
				?>
				<tr> 
					<td><?php $date = strtotime($row['created_on']); echo date('d-M', $date);  ?></td>
					<td title="<?php echo $row['name']; ?>"><?php if($row['value']=='print') {echo "Print Ad";} elseif($row['value']=='web'){ echo "Web Ad";} else{ echo "Print & Web Ad";}?></td>
					<td><a href="<?php echo base_url().index_page().'new_admin/home/orderview_history/'.$row['help_desk'].'/'.$row['id'].'/'.$id.'/'.$type.'/'.$user.'/'.$date.'/'.$order_type;?>" type="button" >
					<?php echo $row['id'] ;?></a></td>
					<td><?php echo $row['job_no'] ;?></td>
					<td><?php if(isset($row['publication_name'])) { echo $row['publication_name']; } else{ echo " ";}?></td>
					<td><?php echo $row['advertiser_name'] ;?></td>
					<td><?php if($row['order_type_id']=='1'){ // webad 
						if($row['pixel_size']=='custom'){?>
						<?php echo $row['custom_width']; ?>
						<?php } else {
							$size_px = $this->db->get_where('pixel_sizes',array('id'=>$row['pixel_size']))->result_array();
						?><?php echo $size_px[0]['width']; ?>
						<?php } }else{ //printad ?>
						<?php echo $row['width']; ?>
					<?php } ?>
					</td>
					<td><?php if($row['order_type_id']=='1'){ // webad 
						if($row['pixel_size']=='custom'){?>
						<?php echo $row['custom_height']; ?>
						<?php } else {
							$size_px = $this->db->get_where('pixel_sizes',array('id'=>$row['pixel_size']))->result_array();
						?><?php echo $size_px[0]['height']; ?>
						<?php } }else{ //printad ?>
						<?php echo $row['height']; ?>
					<?php } ?>
					</td>
					<td>
					<?php if($row['pdf_timestamp'] != '0000-00-00 00:00:00'){
								$a = strtotime($row['created_on']); $b = strtotime($row['pdf_timestamp']);
								$t = round(abs($b - $a) / 60);
							if($t > '60'){
							printf("%2d<small>h</small> %2d<small>m</small>", round($t / 60), $t % 60);
							}else{ echo round($t).'<small>m</small>';  } }?>
					</td>
					<td>
					<?php if($pdf_path != 'none') { ?>
						<a href="<?php echo base_url().$pdf_path ?>" target="_Blank" type="button" class="btn bg-red btn-xs"><i class="fa fa-file-pdf-o"></i></a>
					<?php } ?>
					</td>
					<td>
						<?php
							$html_file = $row['file_path'].'/'.$row['job_no'].'.html';
							if(file_exists($html_file)){
						?>
						<a href="<?php echo base_url().'download.php?file_source='.$html_file; ?>" target="_blank"><i class="fa fa-download"></i></a>
						<?php
							}
						?>
					</td>
				</tr>
				<?php } ?>	
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
					<th width="70">Date</th>
					<th>Type</th>
					<th>AdwitAds ID</th>
					<th>Unique Job Name</th>
					<th>Category</th>
					<th>Adrep</th>
					<th>Advertiser</th>
					<th>Width</th>
					<th>Height</th>
					<th>Tot Sq Inch</th>
					<th>Time Taken</th>
					<th>PDF</th>
					<th>Form</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($orders as $row) {
					$publication = $this->db->query("SELECT `name` FROM `publications` WHERE `id`='".$row['publication_id']."' ;")->result_array();		
					$adreps = $this->db->query("SELECT `first_name`, `last_name` FROM `adreps` WHERE `id`='".$row['adrep_id']."' ;")->result_array();
					$orders_type = $this->db->query("SELECT * FROM `orders_type` WHERE `id` = '".$row['order_type_id']."'")->result_array();
					$cat_category = $this->db->query("SELECT `order_no`,`category`,`publication_id` FROM `cat_result` WHERE  `order_no` = '".$row['id']."'  AND `publication_id` = '".$row['publication_id']."' AND `ddate` BETWEEN '$from 00:00:00' AND '$to 23:59:59' ;")->result_array();
				?>
				<tr>
					<td><?php $date = strtotime($row['created_on']); echo date('d M, Y', $date);  ?></td>
					<td title="<?php echo $orders_type[0]['name']; ?>"><?php if($orders_type[0]['value']=='print') {echo "Print Ad";} elseif($orders_type[0]['value']=='web'){ echo "Web Ad";} else{ echo "Print & Web Ad";}?></td>
					<td>
					<a href="<?php echo base_url().index_page().'new_admin/home/orderview_history/'.$row['help_desk'].'/'.$row['id'].'/'.$id.'/'.$type.'/'.$user.'/'.$date.'/'.$order_type;?>" type="button" >
					<?php echo $row['id'] ;?></a> 
					</td>
					<td><?php echo $row['job_no'] ;?></td>
					<td><?php if($cat_category ){echo $cat_category[0]['category'] ;}else {echo '';}?></td>
					<td><?php if(isset($adreps[0]['first_name'])) { echo $adreps[0]['first_name'].' '.$adreps[0]['last_name'];} else{ echo " ";} ?> </td>
					<td><?php echo $row['advertiser_name'] ;?></td>
					<td><?php if($row['order_type_id']=='1'){ // webad 
						if($row['pixel_size']=='custom'){?>
						<?php echo $row['custom_width']; ?>
						<?php } else {
							$size_px = $this->db->get_where('pixel_sizes',array('id'=>$row['pixel_size']))->result_array();
						?><?php echo $size_px[0]['width']; ?>
						<?php } }else{ //printad ?>
						<?php echo $row['width']; ?>
					<?php } ?>
					</td>
					<td><?php if($row['order_type_id']=='1'){ // webad 
						if($row['pixel_size']=='custom'){?>
						<?php echo $row['custom_height']; ?>
						<?php } else {
							$size_px = $this->db->get_where('pixel_sizes',array('id'=>$row['pixel_size']))->result_array();
						?><?php echo $size_px[0]['height']; ?>
						<?php } }else{ //printad ?>
						<?php echo $row['height']; ?>
					<?php } ?>
					</td>
					<td>
						<?php if($row['order_type_id']=='1'){ // webad 
						if($row['pixel_size']=='custom'){
						 $width = $row['custom_width'];
						 $height = $row['custom_height'];
						} else {
						$size_px = $this->db->get_where('pixel_sizes',array('id'=>$row['pixel_size']))->result_array();
						 $width = $size_px[0]['width']; $height = $size_px[0]['height'];
						} }else{ //printad
						 $width = $row['width']; $height = $row['height']; 
						}  
						echo $tot_sq_inch = ($width * $height);
						?>
					</td>	
					<td>
					<?php if($row['pdf_timestamp'] != '0000-00-00 00:00:00'){
								$a = strtotime($row['created_on']); $b = strtotime($row['pdf_timestamp']);
								$t = round(abs($b - $a) / 60);
							if($t > '60'){
							printf("%2d<small>h</small> %2d<small>m</small>", round($t / 60), $t % 60);
							}else{ echo round($t).'<small>m</small>';  } }?>
					</td>
					<td>
					<?php if($row['pdf'] != 'none') { ?>
						<a href="<?php echo base_url().$row['pdf'] ?>" target="_Blank" type="button" class="btn bg-red btn-xs"><i class="fa fa-file-pdf-o"></i></a>
					<?php } ?>
					</td>
					<td>
						<?php
							$html_file = $row['file_path'].'/'.$row['job_no'].'.html';
							if(file_exists($html_file)){
						?>
							<a href="<?php echo base_url().'download.php?file_source='.$html_file; ?>" target="_blank"><i class="fa fa-download"></i></a>
						<?php
							}else{
						?>
							<a href="<?php echo base_url().index_page().'new_admin/home/order_form/'.$row['id']; ?>" target="_blank"><i class="fa fa-download"></i></a>
						<?php
							}
						?>
					</td>
				</tr>
				<?php } ?>	
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
					<th width="70">Date</th>
					<th>Type</th>
					<th>AdwitAds ID</th>
					<th>Unique Job Name</th>
					<th>Adrep</th>
					<th>Publication</th>
					<th>Advertiser</th>
					<th>Width</th>
					<th>Height</th>
					<th>Time Taken</th>
					<th>PDF</th>
					<th>Form</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($orders as $row) {
						$publication = $this->db->query("SELECT `name` FROM `publications` WHERE `id`='".$row['publication_id']."' ;")->result_array();		
					$adreps = $this->db->query("SELECT `first_name`, `last_name` FROM `adreps` WHERE `id`='".$row['adrep_id']."' ;")->result_array();	
						$orders_type = $this->db->query("SELECT * FROM `orders_type` WHERE `id` = '".$row['order_type_id']."'")->result_array();
				?>
				<tr>
					<td><?php $date = strtotime($row['created_on']); echo date('d M, Y', $date);  ?></td>
					<td title="<?php echo $orders_type[0]['name']; ?>"><?php if($orders_type[0]['value']=='print') {echo "Print Ad";} elseif($orders_type[0]['value']=='web'){ echo "Web Ad";} else{ echo "Print & Web Ad";}?></td>
					<td><a href="<?php echo base_url().index_page().'new_admin/home/orderview_history/'.$row['help_desk'].'/'.$row['id'].'/'.$id.'/'.$type.'/'.$user.'/'.$date.'/'.$order_type;?>" type="button" >
					<?php echo $row['id'] ;?></a></td>
					<td><?php echo $row['job_no'] ;?></td>
					<td><?php if(isset($adreps[0]['first_name'])) { echo $adreps[0]['first_name'].' '.$adreps[0]['last_name'];} else{ echo " ";} ?> </td>
					<td><?php if(isset($publication)) { echo $publication[0]['name'];} else{ echo " ";} ?> </td>
					<td><?php echo $row['advertiser_name'] ;?></td>
					<td><?php if($row['order_type_id']=='1'){ // webad 
						if($row['pixel_size']=='custom'){?>
						<?php echo $row['custom_width']; ?>
						<?php } else {
							$size_px = $this->db->get_where('pixel_sizes',array('id'=>$row['pixel_size']))->result_array();
						?><?php echo $size_px[0]['width']; ?>
						<?php } }else{ //printad ?>
						<?php echo $row['width']; ?>
					<?php } ?>
					</td>
					<td><?php if($row['order_type_id']=='1'){ // webad 
						if($row['pixel_size']=='custom'){?>
						<?php echo $row['custom_height']; ?>
						<?php } else {
							$size_px = $this->db->get_where('pixel_sizes',array('id'=>$row['pixel_size']))->result_array();
						?><?php echo $size_px[0]['height']; ?>
						<?php } }else{ //printad ?>
						<?php echo $row['height']; ?>
					<?php } ?>
					</td>
					<td>
					<?php if($row['pdf_timestamp'] != '0000-00-00 00:00:00'){
								$a = strtotime($row['created_on']); $b = strtotime($row['pdf_timestamp']);
								$t = round(abs($b - $a) / 60);
							if($t > '60'){
							printf("%2d<small>h</small> %2d<small>m</small>", round($t / 60), $t % 60);
							}else{ echo round($t).'<small>m</small>';  } }?>
					</td>
					<td>
					<?php if($row['pdf'] != 'none') { ?>
						<a href="<?php echo base_url().$row['pdf'] ?>" target="_Blank" type="button" class="btn bg-red btn-xs"><i class="fa fa-file-pdf-o"></i></a>
					<?php } ?>
					</td>
					<td>
						<?php
							$html_file = $row['file_path'].'/'.$row['job_no'].'.html';
							if(file_exists($html_file)){
						?>
							<a href="<?php echo base_url().'download.php?file_source='.$html_file; ?>" target="_blank"><i class="fa fa-download"></i></a>
						<?php
							}
						?>
					</td>
				</tr>
				<?php } ?>	
			</tbody>
		</table>
	</div>
	<?php } ?>
	<!--GROUPS--->
</div>

   
<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable.php'); ?>