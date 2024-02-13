<?php $this->load->view('new_admin/header.php'); ?>


<div class="portlet light">
	<div class="portlet-title">
		<div class="row">
			<div class="col-md-6 font-lg font-grey-gallery">
				<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report'; ?>" class="font-lg">Reports</a> - 
				<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report/'.$type; ?>" class="font-lg"><?php echo $type;?></a> - 
				<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report/'.$type.'/'.$user; ?>" class="font-lg font-grey-gallery"><?php echo $user;?></a> -
				<a class="font-lg font-grey-gallery">Category Wise</a>
					
			</div> 
			<div class="col-md-6 text-right">	
				<button class="btn bg-grey btn-xs margin-right-10" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
				<span class="cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
			</div>
		</div>
	</div>

	
	<div class="portlet-body no-space">	
		<table class="table table-bordered table-hover" id="sample_6">
			<thead>
				<tr>
					<th>Category</th>
					<th>Count</th>
					
				</tr>
			</thead>
			<tbody>
			<?php if(isset($print_cat)){
				foreach($print_cat as $row_cat){
				$cat_name = $row_cat['name'];
				$query = "SELECT cat_result.id, designers.name FROM `cat_result`
				LEFT JOIN `designers` ON cat_result.designer = designers.id
				WHERE `category` = '".$cat_name."' AND `publication_id` IN (".$tot_pub.") AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59')";
				$result = $this->db->query("$query")->result_array();
				
				
			?>
				<tr>
					<td><?php echo $cat_name;?></td>
					<td><a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_admin/home/category_design_details/'.$cat_name.'/'.$user.'/'.$date.'?from='.$from.'&to='.$to;?>'" style="cursor:pointer; text-decoration: none;">
					<?php echo count($result);?></a>
					</td>
				</tr>
			<?php } }?>
			</tbody>
		</table>
	</div>
	
</div>
  
  
  
<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable')?>