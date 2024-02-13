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
			<div class="col-md-6 col-xs-12 margin-top-15 margin-bottom-10 font-lg font-grey-gallery">
				<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report'; ?>" class="font-grey-gallery">Reports</a> - <a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report/'.$type; ?>" class="font-grey-gallery"><?php echo $type;?></a> - 
				<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report/'.$type.'/'.$user; ?>" class="font-grey-gallery"><?php echo $user;?></a> 
				<?php if($help_desk_id != 'all' && isset($help_desk[0]['name'])) { echo '- '.$help_desk[0]['name'] ; }?>
			</div>
			
			<div class="col-md-6 col-xs-12 margin-bottom-10 margin-top-10 text-right">
				<div class="btn-group left-dropdown">
				<?php if($help_desk_id != 'all') { ?>
					<form method="get">
						<div class="btn-group left-dropdown">							
							<button class="btn bg-grey btn-xs dropdown-toggle" margin-right-10" data-toggle="dropdown" aria-expanded="true"	id="filter">
								<i class="fa fa-filter cursor-pointer"></i> Filter</button>
							<div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu">
								<div class=" date-picker input-daterange" data-date="10/11/2012" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
									<input type="text" class="form-control border-radius-left" name="help_desk_id" value="<?php echo $help_desk_id ;?>" style="display:none;">
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
				<button class="btn bg-grey btn-xs" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
				<span class="cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
			</div>
		</div>
	</div>
	<div class="portlet-body no-space" id="close_filter">
			<?php if($help_desk_id == 'all') { ?>
				<table class="table table-bordered table-hover" id="sample_6">
			<?php } else { ?>
		<div>
			<table class="table table-bordered table-hover" id="sample_6"><?php } ?> 
				<thead>					
					<tr>
						<th>Name</th>
						<th>Total No of Ads</th>
						<th>Total No of Revision</th>
						<th>NewAd Time</th>
						<th>RevisionAd Time</th>
					</tr>
				</thead>
				<tbody> 
				<?php	$tot_new_count = 0; $tot_rev_count = 0; $tot_new_avg = 0; $tot_rev_avg = 0;
						foreach($help_desk as $row) { 
						$rev_count = 0; $new_count = 0; $new_avg = 0; $rev_avg = 0; $newad_time_taken = 0; $revad_time_taken = 0;
						
						$orders = $this->db->query("SELECT * FROM `orders` WHERE `help_desk` = '".$row['id']."' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf` != 'none')")->result_array();
						
						$revision = $this->db->query("SELECT `id`,`time_taken` FROM `rev_sold_jobs` WHERE `help_desk` = '".$row['id']."' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf_path` != 'none')")->result_array(); 
						
						foreach($orders as $order_row)	{ 
							if($order_row['pdf_timestamp'] != '0000-00-00 00:00:00'){
								$a = strtotime($order_row['created_on']); $b = strtotime($order_row['pdf_timestamp']);
								$newad_time_taken = $newad_time_taken + round(abs($b - $a) / 60,2);
							}
						}
						if($revision){
							foreach($revision as $rev_row){ 
								$revad_time_taken = $revad_time_taken + round(abs($rev_row['time_taken']) / 60,2);
							}
						} 
						$rev_count = $rev_count + count($revision);
						$new_count = count($orders);
						if($new_count != '0'){
							$new_avg = $newad_time_taken/$new_count;
						}
						if($rev_count != '0'){
							$rev_avg = $revad_time_taken/$rev_count;
						}
				?>
				<tr>
					<td><?php echo $row['name'] ;?></td>
					<td>
						<a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_admin/home/production_details/'.$row['id'].'/'.$type.'/'.$user.'/'.$from.'/'.$to;?>'" style="cursor:pointer; text-decoration: none;">
						<?php echo $new_count ;?></a></td>
					<td><a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_admin/home/revision_hd/'.$row['id'].'/'.$from.'/'.$to;?>'" style="cursor:pointer; text-decoration: none;">
						<?php echo $rev_count ;?></a></td>
					<td><?php if(isset($new_avg)){ echo round($new_avg).'m';  }?></td>
					<td><?php if(isset($rev_avg)){  echo round($rev_avg).'m'; }?></td>
				</tr>
				<?php 
					$tot_new_count = $tot_new_count + $new_count;
					$tot_rev_count = $tot_rev_count + $rev_count;
					$tot_new_avg = $tot_new_avg + $new_avg;
					$tot_rev_avg = $tot_rev_avg + $rev_avg;
				 ?>
				 <?php } ?>
				</tbody>
				<?php if($help_desk_id == 'all') { ?>
					<tfoot>
						<tr>
							<th>Total</th>
							<th><?php echo $tot_new_count ;?></th>
							<th><?php echo $tot_rev_count ;?></th>
							<th><?php echo round($tot_new_avg) ;?></th>
							<th><?php echo round($tot_rev_avg) ;?></th>
						</tr>
					</tfoot>
				<?php } ?>
			</table>
		</div>
		<?php if($help_desk_id != 'all') { ?>
		 <div class="pull-right margin-top-20">
				<a href="<?php echo base_url().index_page(). 'new_admin/home/frontline?id='.$help_desk_id.'&from='.$from.'&to='.$to; ?>" class="btn btn-primary margin-bottom-10">Frontline Delivery Report</a>
				<a href="<?php echo base_url().index_page(). 'new_admin/home/hd_hourly_report?id='.$help_desk_id.'&from='.$from.'&to='.$to; ?>" class="btn bg-red margin-bottom-10">Hourly Report</a>
		 </div>
		<?php } ?>
	</div>		
</div>

<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable.php'); ?>