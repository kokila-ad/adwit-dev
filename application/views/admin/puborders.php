<?php
	$this->load->view("admin/header");
	
?>


        <script type="text/javascript">
            // note, each data item has "bullet" field.
            var columnChartData = [{
                name: "San Diego Reader",
                points: <?php echo count($puborder_users1) ?>,
                color: "#7F8DA9",
            }, {
                name: "Times Republican",
                points: <?php echo count($puborder_users2) ?>,
                color: "#FEC514",
            }, {
                name: "Coast News Group",
                points: <?php echo count($puborder_users3) ?>,
                color: "#b0de09",
            }, {
				name: "Vancouver Courier",
                points: <?php echo count($puborder_users12) ?>,
                color: "#ff6600",
            }, {
				name: "Richmond News",
                points: <?php echo count($puborder_users14) ?>,
                color: "#ff9e01",
				 }, {
				name: "Biz Info",
                points: <?php echo count($puborder_users15) ?>,
                color: "#ff9e01",
            }];


            AmCharts.ready(function () {
                // SERIAL CHART
                var chart = new AmCharts.AmSerialChart();
                chart.dataProvider = columnChartData;
                chart.categoryField = "name";
                chart.startDuration = 1;
                // sometimes we need to set margins manually
                // autoMargins should be set to false in order chart to use custom margin values                
                chart.autoMargins = false;
                chart.marginRight = 0;
                chart.marginLeft = 0;
                chart.marginBottom = 0;
                chart.marginTop = 0;

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.inside = true;
                categoryAxis.axisAlpha = 0;
                categoryAxis.gridAlpha = 0;
                categoryAxis.tickLength = 0;

                // value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.minimum = 0;
                valueAxis.axisAlpha = 0;
                valueAxis.maximum = 6000;
                valueAxis.dashLength = 4;
                chart.addValueAxis(valueAxis);

                // GRAPH
                var graph = new AmCharts.AmGraph();
                graph.valueField = "points";
                graph.customBulletField = "bullet"; // field of the bullet in data provider
                graph.bulletOffset = 16; // distance from the top of the column to the bullet
                graph.colorField = "color";
                graph.bulletSize = 34; // bullet image should be rectangle (width = height)
                graph.type = "column";
                graph.fillAlphas = 0.8;
                graph.cornerRadiusTop = 8;
                graph.lineAlpha = 0;
                chart.addGraph(graph);

                // WRITE
                chart.write("chartdiv");
            });
        </script>
  <div id="Middle-Div">
  <h2 style="text-align: center; color: #666;">No.of Jobs by Publication</h2>
    <div id="chartdiv" style="width: 700px; height: 500px; margin: 0 auto;"></div>
  </div>

<?php
	$this->load->view("admin/footer");
?>