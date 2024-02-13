<?php $this->load->view('new_admin/header.php'); ?>


<div class="portlet light">
	<div class="portlet-title">
		<div class="row">
			<div class="col-md-6 font-lg font-grey-gallery">
				<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report'; ?>" class="font-lg">Reports</a> - 
				<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report/'.$type; ?>" class="font-lg"><?php echo $type;?></a> - 
				<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report/'.$type.'/'.$user; ?>" class="font-lg font-grey-gallery"><?php echo $user;?></a> -
				<u><a href="<?php echo base_url().index_page(). 'new_admin/home/report_sales_group/'.$type.'/'.$user.'?group_id='.$id.'&order_type='.$order_type.'&month=&from='.$from.'&to='.$to; ?>" class="font-lg font-grey-gallery">Publications</a>
					</u>
			</div>
			<div class="col-md-6 text-right">	
				<button class="btn bg-grey btn-xs margin-right-10" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
				<span class="cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
			</div>
		</div>
	</div>
	
	<?php if($user == 'groups'){ ?>
	<div class="portlet-body no-space">	
		<table class="table table-bordered table-hover" id="sample_6">
			<thead>
				<tr>
					<th>Publication Name</th>
					<th>Total Ads</th>
					<th>Total Adreps</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($publications as $row) {	
					$q = "SELECT `id` FROM `orders` WHERE `publication_id` = '".$row['id']."' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf` != 'none')";
					$orders = $this->db->query("$q")->num_rows();
					$adrep = $this->db->query("SELECT `id` FROM `adreps` WHERE `publication_id` = '".$row['id']."' AND `is_active` = '1'")->num_rows();
				//echo $q;
				?>
				<tr>
					<td><?php echo $row['name'] ;?></td>
					<td><?php echo $orders ;?></td>
					<td><?php echo $adrep ;?></td>
				</tr>
				<?php } ?>	
			</tbody>
		</table>
	</div>
	<?php } ?>			
</div>
  
  
  
<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable')?>