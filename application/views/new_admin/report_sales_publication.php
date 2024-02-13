<?php $this->load->view('new_admin/header.php'); ?>
<?php $this->load->view('new_admin/amchart')?>


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

		<!-- BEGIN CONTENT -->

<div class="portlet light">
	<div class="row margin-bottom-5">	
		<div class="col-md-6 col-xs-12 text-capitalize margin-bottom-5">
			<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report'; ?>" class="font-lg">Reports</a> -
			<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report/'.$type; ?>" class="font-lg"><?php echo $type;?></a> - 
			<u><a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report/'.$type.'/'.$user; ?>" class="font-lg font-grey-gallery"><?php echo $user;?></a></u>
		</div>
		
		<div class="col-md-6 col-xs-12 text-right">	
			<form method="get"> 
				<div class="btn-group left-dropdown">
					<span class="dropdown margin-right-10" data-toggle="dropdown" aria-expanded="true">
						<a id="filter"><i class="fa fa-filter fa-2x cursor-pointer"></i></a>
					</span>
					<div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu">
						<div class="radio-list">
							<label><input type="radio" name="order_type" id="print" value="2" <?php if($order_type=='2') echo 'checked';?>>Print Ad </label>
							<label><input type="radio" name="order_type" id="web" value="1" <?php if($order_type=='1') echo 'checked';?>>Web Ad </label>
							<label><input type="radio" name="order_type" id="page" value="6" <?php if($order_type=='6') echo 'checked';?>>Page Ad </label>
							<label><input type="radio" name="order_type" id="all" value="0" <?php if($order_type=='0') echo 'checked';?>>All </label>
						</div>
						<div class="date-picker input-daterange" data-date="10/11/2012" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
						    
							<input type="text" class="form-control border-radius-left" name="from" <?php if(isset($from)) echo 'value="'.$from.'"'; ?> placeholder="From Date">
							<input type="text" class="form-control border-radius-right margin-top-5" name="to" <?php if(isset($to)) echo 'value="'.$to.'"'; ?> placeholder="To Date">
							
							<div class="text-right margin-top-10">
								<input type="text" name="publication_id" value="<?php echo $publication_id ;?>" style="display:none;">
								<button type="submit" class="btn bg-red-flamingo btn-sm"> Submit</button>
							</div>
						</div>
					</div>
					<span class="cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
				</div>									
			</form>	
		</div>
	</div>
	<?php foreach($publications as $row) {
			$rev_count = 0; $new_count = 0; $new_avg = 0; $rev_avg = 0; $ratio = 0; $newad_time_taken = 0; $revad_time_taken = 0;  $tot_sq_in = 0; $avg_sq = 0; $new_ad_count = 0; $pickup_ad_count = 0;
			
			$adrep = $this->db->query("SELECT `id` FROM `adreps` WHERE `publication_id` = '".$row['id']."' AND `is_active` = '1'")->num_rows();
			if($row['group_id'] != '0'){
			$groups = $this->db->query("SELECT `name` FROM `Group` WHERE `id` = '".$row['group_id']."'")->result_array();}
			if($order_type == '2'){ //print ads
				$orders = $this->db->query("SELECT * FROM `orders` WHERE `order_type_id` = '2' AND `publication_id` = '".$row['id']."' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf` != 'none')")->result_array();
			}elseif($order_type == '1'){    //web ads
				$orders = $this->db->query("SELECT * FROM `orders` WHERE `order_type_id` = '1' AND `publication_id` = '".$row['id']."' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf` != 'none')")->result_array();
			}elseif($order_type == '6'){    //pagination ads
				$orders = $this->db->query("SELECT * FROM `orders` WHERE `order_type_id` = '6' AND `publication_id` = '".$row['id']."' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf` != 'none')")->result_array();
			}else{  //all ads
				$q = "SELECT * FROM `orders` WHERE `publication_id` = '".$row['id']."' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf` != 'none')"; //echo $q;
				$orders = $this->db->query("$q")->result_array();
			}
			
			$week = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
			$arr_val = array();
			foreach($week as $day){ $arr_val[$day] = 0;	}
			
			$adrep_count = $this->db->query("SELECT `adrep_id`,COUNT(`id`) FROM orders WHERE (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND `publication_id` = '".$row['id']."' GROUP BY `adrep_id` ORDER BY COUNT(`id`) DESC LIMIT 1") ->result_array();
			if($adrep_count){
			$top_adrep = $this->db->query("SELECT `first_name`,`last_name` FROM `adreps` WHERE `id` = '".$adrep_count[0]['adrep_id']."'")->result_array();}
				
			$new_count = count($orders); 
			foreach($orders as $order_row){ 
				$sq_in = 0;
				$order_date = date('Y-m-d', strtotime($order_row['created_on']));
				$revision = $this->db->query("SELECT `id`,`time_taken` FROM `rev_sold_jobs` WHERE `order_id` = '".$order_row['id']."' AND (`pdf_path` != 'none')")->result_array();
				if($revision){
					foreach($revision as $rev_row){ 
						$revad_time_taken = $revad_time_taken + round(abs($rev_row['time_taken']) / 60,2);
					}
				}
				$rev_count = $rev_count + count($revision);
				if($order_row['spec_sold_ad'] == '0'){
					$new_ad_count++;
				}
				if($order_row['spec_sold_ad'] == '1'){
					$pickup_ad_count++;
				}
				
				if($order_row['pdf_timestamp'] != '0000-00-00 00:00:00'){
					$a = strtotime($order_row['created_on']); $b = strtotime($order_row['pdf_timestamp']);
					$newad_time_taken = $newad_time_taken + round(abs($b - $a) / 60,2);
				}
				$width = 0; $height = 0;
				if($order_row['order_type_id']=='1'){ // webAd 
				    if($order_row['pixel_size'] != ''){
				        if($order_row['pixel_size']=='custom'){
    					    $width = $order_row['custom_width'];
    					    $height = $order_row['custom_height'];
    					} else {
    					    $size_px = $this->db->get_where('pixel_sizes',array('id'=>$order_row['pixel_size']))->result_array();
    					    $width = $size_px[0]['width'];
    					    $height = $size_px[0]['height'];
    				    }     
				    }
				    
				}elseif($order_row['order_type_id']=='2'){ //printAd
					$width = $order_row['width'];
					$height = $order_row['height']; 
				}
				
				$sq_in = $width * $height;
				$tot_sq_in = $tot_sq_in + $sq_in;
					
				//day wise count
				$startDate = strtotime($from);
				$endDate = strtotime($to);
				foreach($week as $day){
					$x=0; $d = array();	//$arr_val[$day] = 0;
					for($i = strtotime($day, $startDate); $i <= $endDate; $i = strtotime('+1 week', $i)){
						$x++; $d[$x] = date('Y-m-d', $i); 
					}
					foreach($d as $r){ 
						if($order_date == $r){ $arr_val[$day]++; }
					}
				}
			}
			
			
			if($new_count != '0'){
				$new_avg = ($newad_time_taken / $new_count);
				$avg_sq = ($tot_sq_in / $new_count) ;
			}
			if($rev_count != '0'){
				$rev_avg = ($revad_time_taken / $rev_count);
			}
			if(($rev_count !='0') && $new_count !='0'){ 
				$ratio = ($rev_count / $new_count); 
			}
		?>
	<div class="portlet-body">
		<div class="row report margin-0 border-top border-bottom">
			<div class="col-md-3 col-sm-12 report-tab">
				<h3 class="font-blue margin-bottom-5"><?php echo $row['name'] ;?></h3>
				<p class="font-grey-gallery margin-0"><?php if(isset($groups)) { echo $groups[0]['name'] ; }?></p>
				<p class="font-grey-cascade margin-0"><?php if(isset($from) && isset($to)){ $from1 = strtotime($from); $to1 = strtotime($to); echo date('M d, Y', $from1)." to ".date('M d, Y', $to1) ;} ?></p>
			</div>
			<div class="col-md-4">
				<div class="row">
					<div class="col-md-6 col-sm-6 report-tab padding-left-40">
						<h3 class="font-grey-gallery">
						<?php if($new_count > '0') { ?>
						<a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_admin/home/details/'.$row['id'].'/'.$type.'/'.$user.'/'.$order_type.'/'.$date.'?from='.$from.'&to='.$to;?>'" style="cursor:pointer; text-decoration: none;"><?php echo $new_count;?> </a><?php }else{ echo "0" ;} ?></h3>
						
						<h5 class="bold font-grey-gallery">Total No of Orders</h5>
					</div>
					<div class="col-md-6 col-sm-6 report-tab padding-left-40 border-right padding-top-10">
						<h3 class="font-grey-gallery padding-top-10"><?php echo round($avg_sq,2);?></h3>
						<h5 class="bold font-grey-gallery">Avg Size of Ad</h5>
					</div>
				</div>
			</div>
			<div class="col-md-5"> 
				<div class="row">
					<div class="col-md-7 col-sm-6 report-tab padding-left-40">
						<h3 class="font-grey-gallery">
							<?php if(isset($new_avg)){ ?>
								<a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_admin/home/details/'.$row['id'].'/'.$type.'/'.$user.'/'.$order_type.'/'.$date.'?from='.$from.'&to='.$to;?>'" style="cursor:pointer; text-decoration: none;">
							<?php if($new_avg > '60'){
									printf("N %2d<small>h</small> %2d<small>m</small>", round($new_avg/60), (int)$new_avg%60);
								}else{ echo 'N '.round($new_avg).'<small>m</small>'; } }?></a> -
							<?php if(isset($rev_avg)){ ?>
								<a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_admin/home/rev_details/'.$row['id'].'/'.$type.'/'.$user.'/'.$order_type.'/'.$date.'?from='.$from.'&to='.$to;?>'" style="cursor:pointer; text-decoration: none;">
								<?php if($rev_avg > '60'){
									printf("R %2d<small>h</small> %2d<small>m</small>", round($rev_avg / 60), (int)$rev_avg % 60);
							}else{ echo 'R '.round($rev_avg).'<small>m</small>';  } ?></a><?php } ?>
						</h3>
						<h5 class="bold font-grey-gallery">Turnaround Time</h5>
					</div>
					<div class="col-md-5 col-sm-6 report-tab padding-left-40">
						<div class="text-right margin-right-5"><i class="fa fa-info-circle tooltips cursor-pointer font-grey-cascade" data-container="body" data-placement="left" data-original-title="Revision divided by No.of NewAd"></i></div>
						<h3 class="font-grey-gallery"><?php if(isset($ratio)) { echo round($ratio,2); } ?></h3>
						<h5 class="bold font-grey-gallery">Ratio New vs Revision</h5>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="row margin-top-10">			
	<div class="col-md-6">
		<div class="portlet light">
			<div class="portlet-title">								
				<span class="font-grey-gallery">Weekly Ads</span> <span class="font-lg bold font-blue"></span>
			</div>
			<div class="portlet-body">
				<div id="chartdiv" style="height: 240px;"></div>
			</div>
		</div>
	</div>
	 
	<div class="col-md-6">
		<div class="portlet light">
			<div class="portlet-body">
				<div class=" portlet-tabs">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#portlet_tab1" data-toggle="tab">Type of Orders </a></li>
						<!-- <li><a href="#portlet_tab2" data-toggle="tab">Late Ads </a></li>	-->							
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="portlet_tab1">
							<div id="chartdiv3" style="height: 250px;"></div>										
						</div>
						<!--<div class="tab-pane" id="portlet_tab2">
							<div id="chartdiv2" style="height: 250px;"></div>
						</div>-->
					</div>
				</div>
			</div>
		</div>
	</div>
	 
	<div class="col-md-12">
		<div class="portlet light">
			<div class="padding-bottom-5 font-grey-gallery">Details</div>
			<div class="details portlet-body">
				<div class="row margin-0 border-top">
					<div class="col-md-6 col-sm-6">
						<div class="details-title">Total No of Adrep's</div>
						<div class="details-data">
							<a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_admin/home/publication_details?type='.$type.'&user='.$user.'&publication_id='.$row['id'].'&order_type='.$order_type.'&date='.$date;?>'" style="cursor:pointer; text-decoration: none;">
							<?php if(isset($adrep)) { echo $adrep ; }?></a>
							
						</div>
					</div>
					<div class="col-md-6 col-sm-6">
						<div class="details-title">Publication Website</div>
						<div class="details-data"><a href="#" target="_blank"></a> </div>
					</div>
					<div class="col-md-6 col-sm-6">
						<div class="details-title">Top Adrep</div>
						<div class="details-data"><?php if(isset($top_adrep)) { echo $top_adrep[0]['first_name'].' '.$top_adrep[0]['last_name']; }?></div>
					</div>
					<div class="col-md-6 col-sm-6">
						<div class="details-title">Deadline</div>
						<div class="details-data"> </div>
					</div>
					<div class="col-md-6 col-sm-6">
						<div class="details-title">Distribution Frequency</div>
						<div class="details-data"> </div>
					</div>								
					<div class="col-md-6 col-sm-6">
						<div class="details-title">DPI</div>
						<div class="details-data"> </div>
					</div>								
					<div class="col-md-6 col-sm-6">
						<div class="details-title">Approximate Circulation</div>
						<div class="details-data"> </div>
					</div>
					<div class="col-md-6 col-sm-6">
						<div class="details-title">Main Point of Contact</div>
						<div class="details-data"> </div>
					</div>
					<div class="col-md-6 col-sm-6">
						<div class="details-title">Clean up or not</div>
						<div class="details-data"> </div>
					</div>
					<div class="col-md-6 col-sm-6">
						<div class="details-title">Native file version</div>
						<div class="details-data"> </div>
					</div>
					<div class="col-md-6 col-sm-6">
						<div class="details-title">Output Format</div>
						<div class="details-data"> </div>
					</div>
					<div class="col-md-6 col-sm-6">
						<div class="details-title">Font Preferences</div>
						<div class="details-data"> </div>
					</div>
					<div class="col-md-6 col-sm-6">
						<div class="details-title">Color Preferences</div>
						<div class="details-data"> </div>
					</div>
					<div class="col-md-6 col-sm-6">
						<div class="details-title">Special Instruction</div>
						<div class="details-data"> </div>
					</div>
				</div>
			</div>
		</div>
	</div>
	 <?php } ?>
</div>
		
<script>
	var chart;
	//$week = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
	
	var chartData = [
		{ "day": "Monday",	"income": <?php echo $arr_val['Monday']; ?> },
		{ "day": "Tuesday",	"income": <?php echo $arr_val['Tuesday']; ?> },
		{ "day": "Wednesday",	"income": <?php echo $arr_val['Wednesday']; ?> },
		{ "day": "Thursday",	"income": <?php echo $arr_val['Thursday']; ?> },
		{ "day": "Friday", "income": <?php echo $arr_val['Friday']; ?> }
	];

	AmCharts.ready(function () {
		// SERIAL CHART
		chart = new AmCharts.AmSerialChart();
		chart.dataProvider = chartData;
		chart.categoryField = "day";
		chart.fontFamily = "Open Sans";
		chart.startDuration = 1;
		chart.plotAreaBorderColor = "#ffffff";
		chart.plotAreaBorderAlpha = 1;
		// this single line makes the chart a bar chart
		chart.rotate = true;

		// AXES
		// Category
		var categoryAxis = chart.categoryAxis;
		categoryAxis.gridPosition = "start";
		categoryAxis.gridAlpha = 0.1;
		categoryAxis.axisAlpha = 0;

		// Value
		var valueAxis = new AmCharts.ValueAxis();
		valueAxis.axisAlpha = 0;
		valueAxis.gridAlpha = 0.1;
		valueAxis.gridColor = "#ffffff";
		//valueAxis.position = "top";
		chart.addValueAxis(valueAxis);

		// GRAPHS
		// first graph
		var graph1 = new AmCharts.AmGraph();
		graph1.type = "column";
		graph1.valueField = "income";
		graph1.balloonText = "Ads:[[value]]";
		graph1.lineAlpha = 0;
		graph1.fillColors = "#3dd13b";
		graph1.fillAlphas = 1;
		chart.addGraph(graph1);			
		
		// WRITE
		chart.write("chartdiv");
	});
</script>
		
<script>	
	var chart2Data = [
	{ type1: "Revision", ads1: 180},
	{ type1: "New Ad", ads1: 300}
	];
	AmCharts.ready(function () {
	
	// PIE CHART
    var chart2 = new AmCharts.AmPieChart();

    chart2.dataProvider = chart2Data;
    chart2.titleField = "type1";
    chart2.valueField = "ads1";
	chart2.fontFamily = "Open Sans";
    chart2.sequencedAnimation = true;
    chart2.innerRadius = "70%";
    chart2.startDuration = .9;
    chart2.labelText = "[[title]]"
    chart2.hideLabelsPercent = 4;
    chart2.labelRadius = 10;
    chart2.write("chartdiv2");
});
</script>

<script>	
	var chart3Data = [
	{ type: "Pickup", ads: <?php echo $pickup_ad_count; ?>},
	{ type: "New Ad", ads: <?php echo $new_ad_count; ?>}
	];
	AmCharts.ready(function () {
	
	// PIE CHART
    var chart3 = new AmCharts.AmPieChart();

    chart3.dataProvider = chart3Data;
    chart3.titleField = "type";
    chart3.valueField = "ads";
    chart3.sequencedAnimation = true;
    chart3.innerRadius = "70%";
    chart3.startDuration = .9;
    chart3.labelText = "[[title]]"
    chart3.hideLabelsPercent = 4;
    chart3.labelRadius = 10;
    chart3.write("chartdiv3");
});
</script>


<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable.php'); ?>