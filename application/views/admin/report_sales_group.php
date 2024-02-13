<?php $this->load->view('new_admin/header.php'); ?>

<script type="text/javascript">
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


<div class="portlet light">
	<div class="row margin-bottom-5">	
		<div class="col-md-6 col-xs-12 text-capitalize margin-bottom-5">
			<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report'; ?>" class="font-lg">Reports</a> - 
			<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report/'.$type; ?>" class="font-lg"><?php echo $type;?></a> - 
			<u><a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report/'.$type.'/'.$user; ?>" class="font-lg font-grey-gallery"><?php echo $user;?></a> </u>
		</div>
		<div class="col-md-6 col-xs-12 text-right">	
			<form method="get"> 
				<div class="btn-group left-dropdown">
					<span class="dropdown margin-right-10" data-toggle="dropdown" aria-expanded="true">
						<a id="filter"><i class="fa fa-filter fa-2x cursor-pointer"></i></a>
					</span>
					<div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu">
						<div class="radio-list">
							<label><input type="radio" name="order_type" id="print" value="2" checked>Print Ad </label>
							<label><input type="radio" name="order_type" id="web" value="1" <?php if($order_type=='1') echo 'checked';?>>Web Ad </label>
							<label><input type="radio" name="order_type" id="all" value="all" <?php if($order_type=='all') echo 'checked';?>>All </label>
						</div>
						<div class="date-picker input-daterange" data-date="10/11/2012" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
							<input type="text" class="form-control border-radius-left" name="from" value="" placeholder="From Date">
							<input type="text" class="form-control border-radius-right margin-top-5" name="to"  value="" placeholder="To Date">
							<div class="text-right margin-top-10">
								<input type="text" name="group_id" value="<?php echo $group_id ;?>" style="display:none;">
								<button type="submit" class="btn bg-red-flamingo btn-sm"> Submit</button>
							</div>
						</div>
					</div>
					<span class="cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
				</div>
			</form>		
		</div>
	</div>
	<?php 
	
		$new_count = 0; $rev_count = 0; $newad_time_taken = 0; $revad_time_taken = 0; $rev_avg = 0; $new_avg = 0;
		$new_count = count($orders);
		/*foreach($orders as $order_row)	{
			if($order_row['pdf_timestamp'] != '0000-00-00 00:00:00'){
				$a = strtotime($order_row['created_on']); $b = strtotime($order_row['pdf_timestamp']);
				$newad_time_taken = $newad_time_taken + round(abs($b - $a) / 60,2);
			}
			
			$revision = $this->db->query("SELECT `id`,`time_taken` FROM `rev_sold_jobs` WHERE `order_id` = '".$order_row['id']."' AND (`pdf_path` != 'none')")->result_array();
			$rev_count = $rev_count + count($revision);
			if($revision){
				foreach($revision as $rev_row){ 
					$revad_time_taken = $revad_time_taken + round(abs($rev_row['time_taken']) / 60,2);
				}
			}  
		}
		
		$new_count = count($orders);
		$newad_time_taken = round(abs($b - $a) / 60,2);
		if($new_count != '0'){
			$new_avg = ($newad_time_taken / $new_count);
		}
		if($rev_count != '0'){
			$rev_avg = ($revad_time_taken / $rev_count);
		}*/ 
	?> 
	<div class="portlet-body">
		<div class="row report margin-0 border-top border-bottom">
			<div class="col-md-3 col-sm-6 report-tab">
				<h3 class="font-blue"><?php echo $groups['name'] ;?></h3>
				<p class="font-grey-gallery margin-0"></p>
				<p class="font-grey-cascade margin-0"><?php if(isset($from) && isset($to)){ $from1 = strtotime($from); $to1 = strtotime($to); echo date('M d, Y', $from1)." to ".date('M d, Y', $to1) ;} ?></p>
			</div> 
			<div class="col-md-3 col-sm-6 report-tab padding-left-40">
				<h3 class="font-grey-gallery">
				<?php if($new_count > '0') { ?>
				<a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_admin/home/details/'.$groups['id'].'/'.$type.'/'.$user.'/'.$order_type.'/'.$date.'?from='.$from.'&to='.$to;?>'" style="cursor:pointer; text-decoration: none;"><?php echo $new_count; ?></a> <?php } else{ echo "0"; }?></h3>  
				<h5 class="bold font-grey-gallery">Total no of orders</h5>
			</div>
			<div class="col-md-3 col-sm-6 report-tab padding-left-40 margin-top-20">
			<a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_admin/home/group_publication_details/'.$groups['id'].'/'.$type.'/'.$user.'/'.$order_type.'/'.$date.'?from='.$from.'&to='.$to;?>'" style="cursor:pointer; text-decoration: none;">
				<h3 class="font-grey-gallery"><?php echo $publication;?></h3></a>
				<h5 class="bold font-grey-gallery">Total no of publications</h5>
			</div>
			<!--<div class="col-md-3 col-sm-6 report-tab padding-left-40" style="padding-top:20px;">
				<h3 class="font-grey-gallery"> 
				<?php if(isset($new_avg)){ ?>
						<a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_admin/home/details/'.$groups['id'].'/'.$type.'/'.$user.'/'.$order_type.'/'.$date.'?from='.$from.'&to='.$to;?>'" style="cursor:pointer; text-decoration: none;">
					<?php if($new_avg > '60'){
							printf("N %2d<small>h</small> %2d<small>m</small>", round($new_avg/60), $new_avg%60);
						}else{ echo 'N '.round($new_avg).'<small>m</small>'; } }?></a> -
					<?php if(isset($rev_avg)){ ?>
						<a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_admin/home/rev_details/'.$groups['id'].'/'.$type.'/'.$user.'/'.$order_type.'/'.$date.'?from='.$from.'&to='.$to;?>'" style="cursor:pointer; text-decoration: none;">
						<?php if($rev_avg > '60'){
							printf("R %2d<small>h</small> %2d<small>m</small>", round($rev_avg / 60), $rev_avg % 60);
					}else{ echo 'R '.round($rev_avg).'<small>m</small>';  } ?></a><?php } ?>
				</h3>
				<h5 class="bold font-grey-gallery">Turnaround Time</h5>
			</div>-->
		</div> 
	</div>
	
	
	<div class="margin-top-10">
	<a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_admin/home/grp_category_wise/'.$groups['id'].'/'.$type.'/'.$user.'/'.$order_type.'/'.$date.'?from='.$from.'&to='.$to;?>'" style="cursor:pointer; text-decoration: none;">
		<button type="button" class="btn btn-defaultgrey">Category Wise</button>
	</a>
	</div>
	
	
</div>
				 
				 
<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable.php'); ?>