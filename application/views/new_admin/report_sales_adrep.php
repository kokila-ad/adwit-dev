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
							<label><input type="radio" name="order_type" id="print" value="2" checked>Print Ad </label>
							<label><input type="radio" name="order_type" id="web" value="1" <?php if($order_type=='1') echo 'checked';?>>Web Ad </label>
							<label><input type="radio" name="order_type" id="all" value="all" <?php if($order_type=='all') echo 'checked';?>>All </label>
						</div>
						<div class="date-picker input-daterange" data-date="10/11/2012" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
							<input type="text" class="form-control border-radius-left" name="from" value="<?php if(isset($from)) echo $from; ?>" placeholder="From Date">
							<input type="text" class="form-control border-radius-right margin-top-5" name="to"  value="<?php if(isset($to)) echo $to; ?>" placeholder="To Date">
							<div class="text-right margin-top-10">
								<input type="text" name="adrep_id" value="<?php echo $adrep_id ;?>" style="display:none;">
								<button type="submit" class="btn bg-red-flamingo btn-sm"> Submit</button>
							</div>
						</div>
					</div>
					<span class="cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
				</div>
			</form>		
		</div>			
	</div>
	<?php foreach($adrep as $row) {
			$rev_count = 0; $new_count = 0; $ratio = 0; $new_avg = 0; $rev_avg = 0; $newad_time_taken = 0; $revad_time_taken = 0; $tot_sq_in = 0; $avg_sq = 0; $new_ad_count = 0; $pickup_ad_count = 0;	$rush_count = 0; $count_A = 0; $count_B = 0; $count_C = 0; $count_D = 0; $count_E = 0; $count_F = 0;
			
			if($order_type == '2'){
				$orders = $this->db->query("SELECT * FROM `orders` WHERE `order_type_id` = '2' AND `adrep_id` = '".$row['id']."' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf` != 'none')")->result_array();
			}elseif($order_type == '1'){
				$orders = $this->db->query("SELECT * FROM `orders` WHERE `order_type_id` = '1' AND `adrep_id` = '".$row['id']."' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf` != 'none')")->result_array();
			}else{
			    $orders = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '".$row['id']."' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf` != 'none')")->result_array();
			}
			
			$publication_name = $this->db->query("SELECT * FROM `publications` WHERE `id` = '".$row['publication_id']."'")->result_array();
			
			$revision = $this->db->query("SELECT `id`,`time_taken` FROM `rev_sold_jobs` WHERE `adrep` = '".$row['id']."' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf_path` != 'none')")->result_array();
			
			foreach($orders as $order_row){ $sq_in = 0;
				$cat = $this->db->query("SELECT `id`,`category` FROM `cat_result` WHERE `order_no` = '".$order_row['id']."'")->result_array();
				if($cat[0]['category'] == 'M'){
					$count_A++;
				}elseif($cat[0]['category'] == 'N'){
					$count_B++;
				}elseif($cat[0]['category'] == 'P'){
					$count_C++;
				}elseif($cat[0]['category'] == 'T'){
					$count_D++;
				}elseif($cat[0]['category'] == 'W'){
					$count_E++;
				}elseif($cat[0]['category'] == 'G'){
					$count_F++;
				}
				
				if($order_row['spec_sold_ad'] == '0'){
					$new_ad_count++;
				}
				if($order_row['spec_sold_ad'] == '1'){
					$pickup_ad_count++;
				}
				if($order_row['rush'] == '1'){
					$rush_count++;
				}
				if($order_row['pdf_timestamp'] != '0000-00-00 00:00:00'){
					$a = strtotime($order_row['created_on']); $b = strtotime($order_row['pdf_timestamp']);
					$newad_time_taken = $newad_time_taken + round(abs($b - $a) / 60,2);
				}
				$width = '0'; $height = '0';
				if($order_row['order_type_id']=='1'){ // webad 
					if($order_row['pixel_size']=='custom'){
    					$width = $order_row['custom_width'];
    					$height = $order_row['custom_height'];
					} else {
    					$size_px = $this->db->get_where('pixel_sizes',array('id'=>$order_row['pixel_size']))->result_array();
    					if($size_px){
        					$width = $size_px[0]['width'];
        					$height = $size_px[0]['height'];
    					}
					 } 
				 }else{
					$width = $order_row['width'];
					$height = $order_row['height']; 
				} 
				if(is_numeric($width) && is_numeric($height)){
				    $sq_in = $width * $height;    
				}
				
				$tot_sq_in = $tot_sq_in + $sq_in;
					
			}
				if($revision){
					foreach($revision as $rev_row){ 
						$revad_time_taken = $revad_time_taken + round(abs($rev_row['time_taken']) / 60,2);
					}
				}
				$new_count = count($orders);
				$rev_count = $rev_count + count($revision);
				//$rush_count = $rush_count + $rush;
				
				if($new_count != '0'){
					$new_avg = $newad_time_taken/$new_count;
					$avg_sq = ($tot_sq_in/$new_count) ;
				}
				if($rev_count != '0'){
					$rev_avg = $revad_time_taken/$rev_count;
				}
				if(($rev_count !='0') && $new_count !='0'){ 
					$ratio = $rev_count/$new_count; 
				} 
		?>
	<div class="portlet-body">
		<div class="row report margin-0 border-top border-bottom">
			<div class="col-md-3 col-sm-12 report-tab">
				<h3 class="font-blue"><?php echo $row['first_name'].' '.$row['last_name'] ;?></h3>
				<p class="font-grey-gallery margin-0"><?php if(isset($publication_name)) { echo $publication_name[0]['name'] ; }?></p>
				<p class="font-grey-cascade margin-0"><?php if(isset($from) && isset($to)){ $from1 = strtotime($from); $to1 = strtotime($to); echo date('M d, Y', $from1)." to ".date('M d, Y', $to1) ;} ?></p>
			</div>
			<div class="col-md-9">
				<div class="row">  
					<div class="col-md-3 col-sm-6 report-tab padding-left-40">
						<h3 class="font-grey-gallery">
							<?php if($new_count > '0') { ?>
							<a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_admin/home/details/'.$row['id'].'/'.$type.'/'.$user.'/'.$order_type.'/'.$date.'?from='.$from.'&to='.$to;?>'" style="cursor:pointer; text-decoration: none;"><?php echo $new_count;?> <?php }else{ echo "0" ;} ?></a></h3>
						<h5 class="bold font-grey-gallery">Total No of Orders</h5>
					</div>
					<div class="col-md-3 col-sm-6 report-tab padding-left-40">
						<h3 class="font-grey-gallery"><?php echo round($avg_sq,2);?></h3>
						<h5 class="bold font-grey-gallery">Avg Size of Ad</h5>
					</div>
					<div class="col-md-3 col-sm-6 report-tab padding-left-40">
						<h3 class="font-grey-gallery"><?php echo $rush_count;?></h3>
						<h5 class="bold font-grey-gallery">No of Rush</h5>
					</div>
					<div class="col-md-3 col-sm-6 report-tab padding-left-40">
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
				<span class="font-grey-gallery">Ad Category</span> <span class="font-lg bold font-blue"></span>
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
						<!--<li><a href="#portlet_tab2" data-toggle="tab">Late Ads </a></li>-->									
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
</div>
<?php } ?>
			
	
<script>
		var chart;

		var chartData = [
			{ "day": "M",	"ads": <?php echo $count_A;?> },
			{ "day": "N",	"ads": <?php echo $count_B;?> },
			{ "day": "P",	"ads": <?php echo $count_C;?> },
			{ "day": "T",   "ads": <?php echo $count_D;?> },
			{ "day": "W",   "ads": <?php echo $count_E;?> },
			{ "day": "G",   "ads": <?php echo $count_F;?> }
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
			graph1.valueField = "ads";
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