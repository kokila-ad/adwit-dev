<?php $this->load->view('new_client/header'); ?>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<style>
.highcharts-figure, .highcharts-data-table table {
  min-width: 320px; 
  max-width: 660px;
  margin: 1em auto;
}

.highcharts-data-table table {
	font-family: Verdana, sans-serif;
	border-collapse: collapse;
	border: 1px solid #EBEBEB;
	margin: 10px auto;
	text-align: center;
	width: 100%;
	max-width: 500px;
}
.highcharts-data-table caption {
  padding: 1em 0;
  font-size: 1.2em;
  color: #555;
}
.highcharts-data-table th {
	font-weight: 600;
  padding: 0.5em;
}
.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
  padding: 0.5em;
}
.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
  background: #f8f8f8;
}
.highcharts-data-table tr:hover {
  background: #f1f7ff;
}
</style>
<script>
$(document).ready(function(){
        if($('#date_range').val() == 'custom'){
            $('#custom').show();
        }
        
    $('#date_range').change(function() {
        if($(this).val() == 'custom'){
            $('#custom').show();
        }else{
            $('#custom').hide();
    	    window.location = "<?php echo base_url().index_page().'new_client/home/report_ad_type?date_range=';?>" + $('#date_range').val() ;
        }
    });

});
</script>

<div id="main">

<section>
    <div class="container">
        <div class="row margin-top-15 margin-bottom-15">
			<div class="col-md-4 col-md-offset-1" >
			
				<select id="date_range" class="colorselector form-control " name="date_range">
				   <!--<option value="">Select</option>-->
					<option value="last_week" <?php if(isset($date) && $date=='last_week') echo 'selected';?> >Last Week</option>
					<option value="last_month" <?php if(isset($date) && $date=='last_month') echo 'selected';?>>Last Month</option>
					<option value="three_month" <?php if(isset($date) && $date=='three_month') echo 'selected';?>>3 Month</option>
					<option value="six_month" <?php if(isset($date) && $date=='six_month') echo 'selected';?>>6 Month</option>
					<option value="one_year" <?php if(isset($date) && $date=='one_year') echo 'selected';?>>1 Year</option>
					<option value="custom" <?php if(isset($date) && $date=='custom') echo 'selected';?> >Custom</option>
				</select>
		  
			</div>
		</div>
		
				
		<div class="row margin-top-15" id="custom" style="display:none">
			<form method="GET" action="<?php echo base_url().index_page().'new_client/home/bar_chart'; ?>" autocomplete="off" >
                <div class="col-md-6 col-md-offset-1 colors " >
            		<div  class="input-group  date-picker input-daterange margin-bottom-15 "  data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
            			<input type="text" class="form-control border-radius-left" name="from_date" placeholder="From Date" value="<?php if(isset($from)) echo $from; ?>" required/>
            			<span class="input-group-addon"> to </span>
            			<input type="text" class="form-control border-radius-right" name="to_date" placeholder="To Date" value="<?php if(isset($to)) echo $to; ?>" required/>
            		</div>
            	</div>
            	<div class="col-md-4 col-md-offset-1" >
            		<button type="submit" name="search" class="btn bg-red-intense border-radius-5">Submit</button>
            	</div>
            	
    		</form>
    	</div>
	
        <figure class="highcharts-figure">
          <div id="container"></div>
        </figure>
        
    </div>
</section>
</div>

<script>

Highcharts.chart('container', {
  chart: {
    plotBackgroundColor: null,
    plotBorderWidth: null,
    plotShadow: false,
    type: 'pie'
  },
  title: {
    text: 'Ad Count - Color/B&W Over Time'
  },
  tooltip: {
    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
  },
  accessibility: {
    point: {
      valueSuffix: '%'
    }
  },
  plotOptions: {
    pie: {
      allowPointSelect: true,
      cursor: 'pointer',
      dataLabels: {
        enabled: false
      },
      showInLegend: true
    }
  },
  series: [{
    name: 'Count',
    colorByPoint: true,
    data: [{
      name: 'Color',
      y: <?php echo $color_count; ?>,
      sliced: true,
      selected: true
    }, {
      name: 'B&W',
      y: <?php echo $bw_count; ?>
    }]
  }]
});
</script>

<?php $this->load->view('new_client/footer'); ?>
