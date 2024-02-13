<?php $this->load->view('new_admin/header.php'); ?>

<script>
$(document).ready(function(){	    
	$(".dropdown-checkboxes").hide();	
	$('.date-picker').click(function() {
		$(".cursor-pointer").addClass(" filter ");
	});	
	$('#filter').click(function() {
		$(".dropdown-checkboxes").toggle();
	});
});
</script>
<!--<script>    
    if(typeof window.history.pushState == 'function') {
        window.history.pushState({}, "Hide", '<?php echo $_SERVER['PHP_SELF'];?>');
    }
</script>-->


<div class="portlet light">
	<div class="portlet-title">
		<div class="row">	
			<div class="col-md-6 col-xs-12 margin-bottom-10 font-lg font-grey-gallery">
				<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report'; ?>" class="font-grey-gallery">Reports</a> - <a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report/'.$type; ?>" class="font-grey-gallery"><?php echo $type;?></a> - 
				<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report/'.$type.'/'.$user; ?>" class="font-grey-gallery"><?php echo $user;?></a> 
			</div>
			
			<div class="col-md-5 col-xs-9 margin-bottom-10 text-right padding-right-0">	
				
					<form method="get">
						<div class="btn-group left-dropdown">							
							<button class="btn bg-grey btn-xs dropdown-toggle" margin-right-10" data-toggle="dropdown" aria-expanded="true"	id="filter">
								<i class="fa fa-filter cursor-pointer"></i> Filter</button>
							<div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu">
								<div class=" date-picker input-daterange" data-date="10/11/2012" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
									
									<input type="text" class="form-control border-radius-left" name="from" value="<?php if(isset($from)){ echo $from; }?>" placeholder="From Date">
									<input type="text" class="form-control border-radius-right margin-top-10" name="to" value="<?php if(isset($to)){ echo $to; }?>" placeholder="To Date">
									<div class="text-right margin-top-10">
										<button type="submit" class="btn bg-red-flamingo btn-sm"> Submit</button>
									</div>
								</div>
							</div>
						</div>
					</form>
					
			</div>	
			
			<div class="col-md-1 col-xs-5 margin-bottom-10 text-right">		
				<button class="btn bg-grey btn-xs" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
			</div>
		</div>
	</div>
	<div class="portlet-body no-space" id="close_filter">
			<table class="table table-bordered table-hover" id="sample_6">
				<thead>
					<tr>
						<th>Date</th>
						<th>AdwitAds ID</th>
						<th>Job Name</th>
						<th>Adrep</th>
						<th>Group</th>
						<th>Width</th>
						<th>Height</th>
						<th>Type</th>
						<th>Publication</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($orders as $row) { 
					$adreps = $this->db->query("SELECT `id`,`first_name`,`last_name` FROM `adreps` WHERE `id` = '".$row['adrep_id']."'")->result_array();
					$publications = $this->db->query("SELECT `id`,`name` FROM `publications` WHERE `id` = '".$row['publication_id']."'")->result_array();
					if($row['group_id'] != '0'){
					$group = $this->db->query("SELECT `id`,`name` FROM `Group` WHERE `id` = '".$row['group_id']."'")->result_array();
					}
					$orders_type = $this->db->query("SELECT * FROM `orders_type` WHERE `id` = '".$row['order_type_id']."'")->result_array();
					$web_format = $this->db->query("SELECT * FROM `web_ad_formats` WHERE `id` = '".$row['ad_format']."'")->result_array(); 
					?>
					<tr>
						<td><?php $date = strtotime($row['created_on']); echo date('M d, Y', $date); ?></td>
						
						<td><?php echo $row['id']; ?></td>
						
						<td><a href="<?php echo base_url().index_page().'new_admin/home/orderview_history/'.$row['help_desk'].'/'.$row['id'].'/'.$type.'/'.$user;?>" type="button" >
						<?php echo $row['job_no']; ?></a> </td>
						
						<td><?php echo $adreps[0]['first_name'].' '.$adreps[0]['last_name']; ?></td>
						
						<td><?php if(isset($group)){ echo $group[0]['name']; }?></td>
						
						<td><?php if($row['pixel_size']==''){ echo " ";
						}elseif($row['pixel_size']=='custom'){?>
							<?php echo $row['custom_width']; ?>
							<?php } else {
								$size_px = $this->db->get_where('pixel_sizes',array('id'=>$row['pixel_size']))->result_array();
							?><?php echo $size_px[0]['width']; } ?>
						</td>
						
						<td><?php if($row['pixel_size']==''){ echo " ";
							}elseif($row['pixel_size']=='custom'){?>
							<?php echo $row['custom_height']; ?>
							<?php } else {
								$size_px = $this->db->get_where('pixel_sizes',array('id'=>$row['pixel_size']))->result_array();
							?><?php echo $size_px[0]['height']; } ?>
						</td>
						
						<td><?php if(isset($web_format) && ($row['ad_format'] != '0')){ echo $web_format[0]['name']; } ?></td>
						
						<td><?php echo $publications[0]['name']; ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>


<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable.php'); ?>