<?php
	$this->load->view("admin/header");
	
?>

        <script type="text/javascript">
            var chart;

            var chartData = [{
                country: "Print Ads",
                visits: <?php echo count($atype_users2) ?>
            }, {
                country: "Web Ads",
                visits: <?php echo count($atype_users1) ?>
            }, {
                country: "Print & Web Ads",
                visits: <?php echo count($atype_users3) ?>
            }, {
                country: "HTML Email Blast",
                visits: <?php echo count($atype_users4) ?>
            }];


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
  <h2 style="text-align: center; color: #666;">Type of Ads</h2>
  <div id="chartdiv" style="width:600px; height:250px; margin: 0 auto;"></div>
  </div>

<?php
	$this->load->view("admin/footer");
?>