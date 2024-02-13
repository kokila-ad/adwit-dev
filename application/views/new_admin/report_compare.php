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

<?php if($user == 'groups'){ ?>
<div class="portlet light">
	<div class="portlet-title">
		<div class="row">	
			<div class="col-md-6 col-xs-12 margin-bottom-10 font-lg font-grey-gallery">
				<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report'; ?>" class="font-grey-gallery">Reports</a> - <a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report/'.$type; ?>" class="font-grey-gallery"><?php echo $type;?></a> - 
				<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report/'.$type.'/'.$user; ?>" class="font-grey-gallery"><?php echo $user;?></a> 
				<!--<?php if($csr_id != 'all') { echo '- '.$csr[0]['name'] ; }?>-->
			</div>
			
			<div class="col-md-5 col-xs-9 margin-bottom-10 text-right padding-right-0">	
				<?php if($cgroup_id != 'all') { ?>
					<form method="get">
						<div class="btn-group left-dropdown">							
							<button class="btn bg-grey btn-xs dropdown-toggle" margin-right-10" data-toggle="dropdown" aria-expanded="true"	id="filter">
								<i class="fa fa-filter cursor-pointer"></i> Filter</button>
							<div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu">
								<div class=" date-picker input-daterange" data-date="10/11/2012" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
									<input type="text" class="form-control border-radius-left" name="cgroup_id" value="<?php echo $cgroup_id ;?>" style="display:none;">
									<input type="text" class="form-control border-radius-left" name="from" placeholder="From Date">
									<input type="text" class="form-control border-radius-right margin-top-10" name="to" placeholder="To Date">
									<div class="text-right margin-top-10">
										<button type="submit" class="btn bg-red-flamingo btn-sm"> Submit</button>
									</div>
								</div>
							</div>
						</div>
					</form>
				<?php } ?>	
			</div>	
			
			<div class="col-md-1 col-xs-5 margin-bottom-10 text-right">		
				<button class="btn bg-grey btn-xs" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
			</div>
		</div>
	</div>
	<div class="portlet-body no-space" id="close_filter">
			<?php if($cgroup_id == 'all') { ?>
				<table class="table table-bordered table-hover" id="sample_6">
			<?php } else{ ?>
		<div class="table-scrollable">
			<table class="table table-bordered table-hover"><?php } ?> 
				<thead>
					<tr>
						<th>Group Name</th>
						<th>Total Ads</th>
						<th>Total NJ</th>
					</tr>
				</thead>
				<tbody>
					<?php $tot_ads = 0; $tot_nj= 0;
					foreach($groups as $row){ 
					$orders = $this->db->query("SELECT `id` FROM `orders` WHERE `group_id` = '".$row['id']."' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf` != 'none')")->result_array();
					
					$pub_nj = 0;
					foreach($orders as $order_row){
						$cat = $this->db->get_where('cat_result',array('order_no' => $order_row['id']))->result_array();
							if($cat){
								$cat_wt = $this->db->get_where('print',array('name' => $cat[0]['category']))->result_array();
								$pub_nj = $pub_nj + $cat_wt[0]['wt'];
							}
							
					}
					$tot_ads_count = count($orders);
					?>
					
					<tr>
						<td><?php echo $row['name'] ;?></td>
						<td><?php echo $tot_ads_count ;?></td>
						<td><?php echo $pub_nj;?></td>
					</tr>
					<?php $tot_ads = $tot_ads + $tot_ads_count;
						  $tot_nj = $tot_nj + $pub_nj;
					?>
					<?php } ?>
				</tbody>
				<?php if($cgroup_id == 'all') { ?>
				<tfoot>
					<tr>
						<th>Total</th>
						<th><?php echo $tot_ads ;?></th>
						<th><?php echo $tot_nj ;?></th>
					</tr>
				</tfoot>
					<?php } ?>
			</table>
		</div>
	</div>
	
</div>
<?php } ?>
<?php if($user == 'help_desk'){ ?>
<div class="portlet light">
	<div class="portlet-title">
		<div class="row">	
			<div class="col-md-6 col-xs-12 margin-bottom-10 font-lg font-grey-gallery">
				<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report'; ?>" class="font-grey-gallery">Reports</a> - <a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report/'.$type; ?>" class="font-grey-gallery"><?php echo $type;?></a> - 
				<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report/'.$type.'/'.$user; ?>" class="font-grey-gallery"><?php echo $user;?></a>
			</div>
			
			<div class="col-md-5 col-xs-9 margin-bottom-10 text-right padding-right-0">	
				<?php if($chd_id != 'all') { ?>
					<form method="get">
						<div class="btn-group left-dropdown">							
							<button class="btn bg-grey btn-xs dropdown-toggle" margin-right-10" data-toggle="dropdown" aria-expanded="true"	id="filter">
								<i class="fa fa-filter cursor-pointer"></i> Filter</button>
							<div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu">
								<div class=" date-picker input-daterange" data-date="10/11/2012" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
									<input type="text" class="form-control border-radius-left" name="chd_id" value="<?php echo $chd_id ;?>" style="display:none;">
									<input type="text" class="form-control border-radius-left" name="from" placeholder="From Date">
									<input type="text" class="form-control border-radius-right margin-top-10" name="to" placeholder="To Date">
									<div class="text-right margin-top-10">
										<button type="submit" class="btn bg-red-flamingo btn-sm"> Submit</button>
									</div>
								</div>
							</div>
						</div>
					</form>
				<?php } ?>	
			</div>	
			
			<div class="col-md-1 col-xs-5 margin-bottom-10 text-right">		
				<button class="btn bg-grey btn-xs" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
			</div>
		</div>
	</div>
	<div class="portlet-body no-space" id="close_filter">
			<?php if($chd_id == 'all') { ?>
				<table class="table table-bordered table-hover" id="sample_6">
			<?php } else{ ?>
		<div class="table-scrollable">
			<table class="table table-bordered table-hover"><?php } ?> 
				<thead>
					<tr>
						<th>Help Desk Name</th>
						<th>Total Ads</th>
						<th>Total NJ</th> 
					</tr>
				</thead>
				<tbody>
					<?php $tot_ads = 0; $tot_nj= 0;
					foreach($help_desk as $row){ 
					$orders = $this->db->query("SELECT `id` FROM `orders` WHERE `help_desk` = '".$row['id']."' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf` != 'none')")->result_array();
					
					$pub_nj = 0;
					foreach($orders as $order_row){
						$cat = $this->db->get_where('cat_result',array('order_no' => $order_row['id']))->result_array();
							if($cat){
								$cat_wt = $this->db->get_where('print',array('name' => $cat[0]['category']))->result_array();
								$pub_nj = $pub_nj + $cat_wt[0]['wt'];
							}
							
					}
					$tot_ads_count = count($orders);
					?>
					
					<tr>
						<td><?php echo $row['name'] ;?></td>
						<td><?php echo $tot_ads_count ;?></td>
						<td><?php echo $pub_nj;?></td>
					</tr>
					<?php $tot_ads = $tot_ads + $tot_ads_count;
						  $tot_nj = $tot_nj + $pub_nj;
					?>
					<?php } ?>
				</tbody>
				<?php if($chd_id == 'all') { ?>
				<tfoot>
					<tr>
						<th>Total</th>
						<th><?php echo $tot_ads ;?></th>
						<th><?php echo $tot_nj ;?></th>
					</tr>
				</tfoot>
					<?php } ?>
			</table>
		</div>
	</div>
	
</div>
<?php } ?>


<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable.php'); ?>