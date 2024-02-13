<?php $this->load->view("new_admin/header.php");?>
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/semantic-ui@2.2.13/dist/semantic.min.css'>	
	<link href="<?php echo base_url();?>assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo base_url();?>assets/js/scripts.bundle.js"></script>
<style>
    .tooltip-wrap {
  position: relative;
}
.tooltip-wrap .tooltip-content {
  display: none;
  position: absolute;
  bottom: 5%;
  left: 5%;
  right: 5%;
  background-color: #fff;
  padding: .5em;
}
.tooltip-wrap:hover .tooltip-content {
  display: block;
}

</style>
<script type="text/javascript" src="jquery-1.3.2.js" ></script>
<script type="text/javascript" src="html2csv.js" ></script>

<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>

	<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
				 
				<div class="portlet light">
					<div class="portlet-body">					
					
					
				<hr>
				<div class="row">
				    <div class="col-md-9 padding-15">
				        <label class="btn btn-outline-secondary text-muted text-hover-white text-active-white btn-outline btn-active-success active all" data-kt-button="true">
							<input class="btn-check status" type="radio" name="status" value="category_team" checked="checked">
							Category and Team wise
						</label>
						<label class="btn btn-outline-secondary text-muted text-hover-white text-active-white btn-outline btn-active-success active all" data-kt-button="true">
							<input class="btn-check status" type="radio" name="status" value="category">
							Category wise
						</label>
						<label class="btn btn-outline-secondary text-muted text-hover-white text-active-white btn-outline btn-active-success active all" data-kt-button="true">
							<input class="btn-check status" type="radio" name="status" value="team">
							Team wise
						</label>
				    </div>
			        <div class="col-md-3 padding-15">
			            <form id="form-date" method="get">
						    <p  class="margin-bottom-5">Select date range</p>
							<input name="daterange" class="form-control form-control-solid " placeholder="Pick date rage" id="kt_daterangepicker_4"/>
						</form>
					</div>
				</div>
				<!-- BEGIN PAGE HEADER-->
				<!-- END PAGE HEADER-->
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box green-haze">
							<div class="portlet-title">
								<div class="caption">
									Adwit Team Report 
								</div>
								<div class="tools  margin-left-10">
									<a href="javascript:;" class="collapse">
									</a>
									<a href="javascript:;" class="reload">
									</a>
								</div>
								<div class="margin-top-10 text-right">
									<!--<button class="btn bg-grey btn-xs"><i class="fa fa-file-excel-o"></i> Export</button>-->
									<button class="btn bg-grey btn-xs" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
									<button class="btn bg-grey btn-xs"><i class="fa fa-print"></i> Print</button>
								</div>
							</div>
							
							<div class="portlet-body">
							
								<table class="table table-striped table-bordered table-hover" id="sample_6">
    							
								</table>
							</div>
						</div>
						<!-- END EXAMPLE TABLE PORTLET-->

				

					</div>
				</div>
			</div>
		</div>
		<!-- END CONTENT -->
		
		<!-- BEGIN QUICK SIDEBAR -->
		<!--Cooming Soon...-->
		<!-- END QUICK SIDEBAR -->
	</div>
	<!-- END CONTAINER -->
<script type="text/javascript">

   var tableToExcel = (function() {
				
		  var uri = 'data:application/vnd.ms-excel;base64,'
			, template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head></head><body><table>{table}</table></body></html>'
			, base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
			, format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
		  return function(table, name) {
			if (!table.nodeType) table = document.getElementById(table)
			var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
			window.location.href = uri + base64(format(template, ctx))
		  }
	})()
		
</script>
	
<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable.php'); ?>
    <script src="<?php echo base_url();?>assets/js/plugins.bundle.js"></script>
	
<script>
	 $(document).ready(function(){
        // pre defined date range//
        var start = moment().subtract(1, 'days');
        var end = moment();
        
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
           
           $("#dashboard_v3").html("Loading Productivity by Designer...");
           
            var dateRange = start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD');
            //console.log('dateRange : '+dateRange);
            
            //Load table content and ads count
            var status = $('input[name="status"]:checked').val();
            var from_date = start.format('MM/DD/YYYY');
            var to_date = end.format('MM/DD/YYYY');
            LoadContent(status, from_date, to_date);
        });
        
        //When initial document load get time range from datepicker
            var dval = $('#kt_daterangepicker_4').val();
            var array = dval.split(' - ');
            var from_date = array[0];
            var to_date = array[1];
            var status = $('input[name="status"]:checked').val();
            LoadContent(status, from_date, to_date);
        
        $('.status').on('change', function(){
            //get time range from datepicker
            var dval = $('#kt_daterangepicker_4').val();
            var array = dval.split(' - ');
            var from_date = array[0];
            var to_date = array[1];
            var status = $(this).val();
            LoadContent(status, from_date, to_date); //load table content
        });
        
        function LoadContent(status, from_date, to_date)
        {
           $('#sample_6').html("<div><img src='<?php echo base_url()."assets/page_design/img/adwit-loading.gif"; ?>'> Content Loading..</div>");  
           $.ajax({
               method: "GET",
               url: "<?php echo base_url().index_page().'new_admin/home/adwit_team_report_content'; ?>",
               data: { status_wise: status, from: from_date, to: to_date },
               success: function(data){
                    var response = JSON.parse(data);
                   $('#sample_6').html(response);
               }
           }); 
        }
    });
    
</script>