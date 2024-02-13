<?php
	$this->load->view("admin/header");
	
?>

        <script type="text/javascript">
            var chart;

           /* var chartData = [{
                country: "San Diego Reader",
                visits: <?php echo count($ad_users1) ?>
            }, {
				country: "Virgin Islands Daily News",
                visits: <?php echo count($ad_users9) ?>
            }, {
				country: "Wownow",
                visits: <?php echo count($ad_users10) ?>
            }, {
                country: "Times Republican",
                visits: <?php echo count($ad_users2) ?>
            }, {
                country: "Coast News Group",
                visits: <?php echo count($ad_users3) ?>
            }, {
                country: "Vancouver Courier News",
                visits: <?php echo count($ad_users12) ?>
            }, {
                country: "Richmond News",
                visits: <?php echo count($ad_users14) ?>
            }, {
                country: "Biz Info Group",
                visits: <?php echo count($ad_users15) ?>
            }];
			*/
			var chartData = [
				<?php foreach($pub_users as $row){ ?>
					{
						country: "<?php echo $row['name']; ?>",
						<?php $client = $this->db->get_where('adreps',array('publication_id' => $row['id']))->result_array(); ?>
						 visits: <?php echo count($client); ?>
					},
				<?php } ?>
            ];

            AmCharts.ready(function () {
                // PIE CHART
                chart = new AmCharts.AmPieChart();

                // title of the chart
                chart.dataProvider = chartData;
                chart.titleField = "country";
                chart.valueField = "visits";
                chart.sequencedAnimation = true;
                chart.startEffect = "elastic";
                chart.innerRadius = "30%";
                chart.startDuration = 2;
                chart.labelRadius = 15;

                // the following two lines makes the chart 3D
                chart.depth3D = 10;
                chart.angle = 15;

                // WRITE                                 
                chart.write("chartdiv");
            });
        </script>
  <div id="Middle-Div">
  <h2 style="text-align: center; color: #666;">No.of Adreps by Publication</h2>
  <div id="chartdiv" style="width:800px; height:650px; margin: 0 auto;"></div>
  </div>

<?php
	$this->load->view("admin/footer");
?>