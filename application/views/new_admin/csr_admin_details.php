<?php $this->load->view('new_admin/header')?>

<style>
@media (min-width: 900px) {.left-dropdown .dropdown-menu { min-width: 550px;} }
.pagination>li { float: left;}
</style>

<!-- START CHART -->
<script src="assets/new_admin/plugins/amchart/amcharts.js" type="text/javascript"></script>
<script src="assets/new_admin/plugins/amchart/serial.js" type="text/javascript"></script>
<script src="assets/new_admin/plugins/amchart/pie.js" type="text/javascript"></script>
<script src="assets/new_admin/plugins/amchart/funnel.js" type="text/javascript"></script>
<!-- END CHART -->
	

<div class="col-md-12">
<div class="portlet light">
	<div class="portlet-title margin-bottom-25">
		<div class="row margin-bottom-5">	
			<div class="col-md-8 col-xs-12">
				<a href="<?php echo base_url().index_page().'new_admin/home/manage'?>" class="font-lg">Manage</a> - 
				<a href="<?php echo base_url().index_page().'new_admin/home/csr_admin_details'?>" class="font-lg font-grey-gallery"><u>CSR</u></a>
			</div>							
			<div class="col-md-4 col-xs-12 text-right">	
				<span class="cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
			</div>									
		</div>
	</div>

	<div class="portlet-body">
		<div class="row">
		 <div class="col-md-6 margin-bottom-20">
			<p class="bold align-center" >CSR - 
			<a href="<?php echo base_url().index_page().'new_admin/home/csr'; ?>"><small class="btn btn-xs bg-grey btn-circle"><?php echo count($csr); ?></small></a></p>
			<div id="chartdiv" style="height: 240px;"></div>
		</div>	
		 <div class="col-md-6">
			<p class="bold align-center">Location - <small class="btn btn-xs bg-grey btn-circle"><?php echo count($locations); ?></small></p>
			<div id="chartdiv2" style="height: 240px;"></div>											
		 </div>						 
		</div>
	</div>
</div>
</div>			 
	
<script>
		var chart;
		
		var chartData = [
			<?php foreach($csr_role as $role){ 
					$count = $this->db->query("SELECT * FROM `csr` WHERE `csr_role` = '".$role['id']."' AND `is_active` = '1'")->num_rows();
			?>
			{ "adrep": "<?php echo $role['name'] ?>",	"csr": <?php echo $count;?> },
			<?php } ?>
		];

		AmCharts.ready(function () {
			// SERIAL CHART
			chart = new AmCharts.AmSerialChart();
			chart.dataProvider = chartData;
			chart.categoryField = "adrep";
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
			graph1.valueField = "csr";
			graph1.balloonText = "CSR:[[value]]";
			graph1.lineAlpha = 0;
			graph1.fillColors = "#3dd13b";
			graph1.fillAlphas = 1;
			chart.addGraph(graph1);			
			
			// WRITE
			chart.write("chartdiv");
		});
</script>

<script>
		var chart2;
		
		var chart2Data = [
		<?php foreach($location as $loc){ 
					$loc_count = $this->db->query("SELECT * FROM `csr` WHERE `Join_location` = '".$loc['id']."' AND `is_active` = '1'")->num_rows();
			?>
			{  "adrep": "<?php echo $loc['name'] ?>",	"csr": <?php echo $loc_count;?> },
			<?php } ?>
		];
		
		AmCharts.ready(function () {
			// SERIAL CHART
			chart2 = new AmCharts.AmSerialChart();
			chart2.dataProvider = chart2Data;
			chart2.categoryField = "adrep";
			chart2.fontFamily = "Open Sans";
			chart2.startDuration = 1;
			chart2.plotAreaBorderColor = "#ffffff";
			chart2.plotAreaBorderAlpha = 1;
			// this single line makes the chart a bar chart
			chart2.rotate = true;

			// AXES
			// Category
			var categoryAxis = chart2.categoryAxis;
			categoryAxis.gridPosition = "start";
			categoryAxis.gridAlpha = 0.1;
			categoryAxis.axisAlpha = 0;

			// Value
			var valueAxis = new AmCharts.ValueAxis();
			valueAxis.axisAlpha = 0;
			valueAxis.gridAlpha = 0.1;
			valueAxis.gridColor = "#ffffff";
			//valueAxis.position = "top";
			chart2.addValueAxis(valueAxis);

			// GRAPHS
			// first graph
			var graph1 = new AmCharts.AmGraph();
			graph1.type = "column";
			graph1.valueField = "csr";
			graph1.balloonText = "CSR:[[value]]";
			graph1.lineAlpha = 0;
			graph1.fillColors = "#3dd13b";
			graph1.fillAlphas = 1;
			chart2.addGraph(graph1);			
			
			// WRITE
			chart2.write("chartdiv2");
		});
</script>
	

<?php $this->load->view('new_admin/footer')?>

