<?php $this->load->view('new_admin/header')?>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<!-- calender -->
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/semantic-ui@2.2.13/dist/semantic.min.css'>	
	<link href="<?php echo base_url();?>assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo base_url();?>assets/js/scripts.bundle.js"></script>
   
<div class="page-container"></div>
	<div class="page-content">
	    <div class="row">
	        <div class="col-md-3 padding-15">
			            <form id="form-date" method="get">
						    <p  class="margin-bottom-5">Select date range</p>
							<input name="daterange" class="form-control form-control-solid " placeholder="Pick date rage" id="kt_daterangepicker_4"/>
						</form>
					</div>
	    </div>
		<div class="container">
		    <div id="containerEST" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
		</div>
		
		<div class="container">
		    <div id="containerIST" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
		</div>
	</div>
</div>

			
<script type="text/javascript">

    Highcharts.chart('containerEST', {
    
        title: {
            	text: 'Hourly Ad Count EST'
        },
    
       /*subtitle: {
            text: 'Source: adwitads.com'
        },*/
    
        yAxis: {
            title: {
                text: 'Number of Ads'
            }
        },
    
        xAxis: {
            accessibility: {
                rangeDescription: 'Range: 0 to 23'
            },
            title: {
                text: 'Hours'
            }
        },
    
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },
    
        plotOptions: {
            series: {
                label: {
                    connectorAllowed: false
                },
                pointStart: 1
            }
        },
    
        series: [{
            	name: 'Order Received',
                data: [<?php echo join($order_receive_count, ',') ?>]
        }, {
           name: 'Order Accepted',
            data: [<?php echo join($order_accepted_count, ',') ?>]
        }, {
            name: 'In Production',
            data: [<?php echo join($inproduction_count, ',') ?>]
        }, {
            	name: 'Quality Check',
            data: [<?php echo join($quality_check_count, ',') ?>]
        }, {
            name: 'Proof Ready',
           data: [<?php echo join($proof_ready_count, ',') ?>]
        }, {
            	name: 'Approved',
            data: [<?php echo join($approved_count, ',') ?>]
        }],
    
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }
    
    });


</script>

<script type="text/javascript">

    Highcharts.chart('containerIST', {
    
        title: {
            	text: 'Hourly Ad Count IST'
        },
    
       /*subtitle: {
            text: 'Source: adwitads.com'
        },*/
    
        yAxis: {
            title: {
                text: 'Number of Ads'
            }
        },
    
        xAxis: {
            accessibility: {
                rangeDescription: 'Range: 0 to 23'
            },
            title: {
                text: 'Hours'
            }
        },
    
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },
    
        plotOptions: {
            series: {
                label: {
                    connectorAllowed: false
                },
                pointStart: 1
            }
        },
    
        series: [{
            	name: 'Order Received',
                data: [<?php echo join($order_receive_count_ist, ',') ?>]
        }, {
           name: 'Order Accepted',
            data: [<?php echo join($order_accepted_count_ist, ',') ?>]
        }, {
            name: 'In Production',
            data: [<?php echo join($inproduction_count_ist, ',') ?>]
        }, {
            	name: 'Quality Check',
            data: [<?php echo join($quality_check_count_ist, ',') ?>]
        }, {
            name: 'Proof Ready',
           data: [<?php echo join($proof_ready_count_ist, ',') ?>]
        }, {
            	name: 'Approved',
            data: [<?php echo join($approved_count_ist, ',') ?>]
        }],
    
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }
    
    });


</script>
<!-- calender -->
<script src="<?php echo base_url();?>assets/js/plugins.bundle.js"></script>
<script>
// pre defined date range//
    <?php if(isset($_GET['from'])){ ?>
        var from = '<?php echo $_GET['from']; ?>';
        var to = '<?php echo $_GET['to']; ?>'; 
         console.log(from, to);
        
       var start = moment(from).format('MM/DD/YYYY');
       var end = moment(to).format('MM/DD/YYYY');
        
       
        //console.log(start, end);
   <?php }else{ ?>
   console.log('no get request');
        var start = moment();
        var end = moment();
   <?php } ?>
    $('#kt_daterangepicker_4').daterangepicker({
           buttonClasses: ' btn',
           applyClass: 'btn-primary',
           cancelClass: 'btn-secondary',
        
           startDate: start,
           endDate: end,
           ranges: {
              'Today': [moment(), moment()],
              //'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
              'Last 7 Days': [moment().subtract(6, 'days'), moment()],
              'Last 14 Days': [moment().subtract(13, 'days'), moment()],
              'Last 30 Days': [moment().subtract(29, 'days'), moment()],
              'Last 60 Days': [moment().subtract(59, 'days'), moment()],
              'Last 90 Days': [moment().subtract(89, 'days'), moment()],
              'This Month': [moment().startOf('month'), moment().endOf('month')],
              'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
           }
        }, function(start, end, label) {
           $('#kt_daterangepicker_4 .form-control').val( start.format('DD MMMM, YYYY') + ' / ' + end.format('DD MMMM, YYYY'));
           var from_date = start.format('MM/DD/YYYY');
            var to_date = end.format('MM/DD/YYYY');
            window.location.href='<?php echo base_url().index_page()."new_admin/home/hourly_order_count_graph?"; ?>from='+from_date+'&to='+to_date;
        });    
</script>		
   </body>
<?php $this->load->view('new_admin/footer')?>