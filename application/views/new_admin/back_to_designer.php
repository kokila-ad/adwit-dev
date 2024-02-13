<?php $this->load->view("new_admin/header.php");?>
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
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.datatables.net/buttons/1.2.1/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css">
<!--<script type="text/javascript" src="jquery-1.3.2.js" ></script>
<script type="text/javascript" src="html2csv.js" ></script>-->

<script type="text/javascript" src="https://code.jquery.com/jquery-latest.min.js"></script>

	<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<div class="page-content">
		<div class="portlet light">
			<div class="portlet-body">					
						
				<!-- BEGIN PAGE HEADER-->
				<!-- END PAGE HEADER-->
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet box green-haze">
						<div class="portlet-title">
							<div class="caption" id="titleCaption">
								Back to Designer Stats 
							</div>
							<div class="tools  margin-left-10">
								<a href="javascript:;" class="collapse"></a>
							    <a href="javascript:;" class="reload"></a>
							</div>
							<!--<div class="margin-top-10 text-right">
								<button class="btn bg-grey btn-xs" onclick="tableToExcel('user_data', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
								<button class="btn bg-grey btn-xs"><i class="fa fa-print"></i> Print</button>
							</div>-->
						</div>
							
						<div class="portlet-body">
							<div class="portlet light margin-bottom-5">
								<div class="portlet-body">					
									<div class="row">
									    <div class="col-md-4 col-lg-4">
									        <select id="dateRange" name="dateRange" class="colorselector select2me form-control margin-bottom-10 border-radius-5  select2-offscreen" tabindex="-1" title="">
                        						<option value="">Select</option>
                        						<option value="today">Today</option>
                        						<option value="one_week">1 Week</option>
                        						<option value="one_month">1 Month</option>
                        						<option value="three_month">3 Month</option>
                        						<option value="one_year">1 Year</option>
                        						<option value="custom">Custom</option>
                        					</select>
									    </div>
									    <div class="col-md-8 col-lg-8 text-right" id="customDiv">
									     	<form id="form_date" method="post">
    											
    											<div class="col-md-4">
    												<div class="input-group input-large date-picker input-daterange" data-date="2012-10-11" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
    													<input type="text"  name="from_date" id="from_date" placeholder="YYYY-MM-DD" class="form-control" autocomplete="off" required>
    													<span class="input-group-addon"> to </span>
    													<input type="text" name="to_date" id="to_date" placeholder="YYYY-MM-DD" class="form-control" autocomplete="off" required>
    												</div>
    											</div>	
    											<div class="">
    												<input type="submit" name="date_submit" class="btn bg-green-haze" value="Submit">
    											</div>
    										</form>
										</div>
									</div>
								</div>
							</div>
				
							<table class="table table-striped table-bordered table-hover" id="user_data">
								<thead>
    								<tr>
    									<th title="Adwit Id">Order Id</th>
    									<th>Designer</th>
    									<th>CSR</th>
    									<th>Message</th>
    									<th>Date</th>
    								</tr>
								</thead>
							    
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
	<?php
	        $today = date('Y-m-d');
        	$one_week = date('Y-m-d', strtotime("-1 week +1 day"));
        	$one_month = date('Y-m-d', strtotime("-1 month"));
        	$three_month = date('Y-m-d', strtotime("-3 month"));
        	$one_year = date('Y-m-d', strtotime("-1 year"));
	?>
<script>
$(document).ready(function(){ 
    
    $("#customDiv").hide();
 
    
$("#dateRange").on("change", function(){ 
    /*var drange = $(this).val(); //alert(drange);
    if(drange == 'custom'){
        $("#customDiv").show();
    }else if(drange != ''){
        var fromDate = '';
        var toDate = '';
        var today = <?php echo $today; ?>;
            if(drange == 'today'){
                fromDate = '<?php echo $today; ?>';
                toDate = '<?php echo $today; ?>';
            }else if(drange == 'one_week'){
                fromDate = '<?php echo $one_week; ?>';
                toDate = '<?php echo $today; ?>';   
            }else if(drange == 'one_month'){
                fromDate = '<?php echo $one_month; ?>';
                toDate = '<?php echo $today; ?>';   
            }else if(drange == 'three_month'){
                fromDate = '<?php echo $three_month; ?>';
                toDate = '<?php echo $today; ?>';   
            }else if(drange == 'one_year'){
                fromDate = '<?php echo $one_year; ?>';
                toDate = '<?php echo $today; ?>';    
            }
        $("#titleCaption").html('Back to Designer Stats '+fromDate+' To '+toDate);  */ 
        load_data();
    //}
   
 });
//custom date  
 $("#form_date").on("submit", function(){ 
    var fromDate = $('#from_date').val();
    var toDate = $('#to_date').val(); 
    $("#titleCaption").html('Back to Designer Stats '+fromDate+' To '+toDate); 
    load_data(fromDate, toDate);
    return false;
 });
 
 function load_data(){
     //load table data
      var dataTable = $('#user_data').DataTable({  
           "processing":true,  
           "serverSide":true,
           "bDestroy": true, //reinitialise
           "order":[],  
           "ajax":{  
                url:"<?php echo base_url().index_page().'new_admin/home/back_to_designer_content'; ?>",  
                type:"GET",
                //data: 'from_date='+fromDate+'&to_date='+toDate,
                data : { 
                            dateRange: $("#dateRange").val()
                        }
           },  
           "columnDefs":[  
                {  
                     "targets":[0, 1, 2, 3],  
                     "orderable":false,  
                },  
           ],
           "dom": 'Bfrtip',
           "buttons": [
                    'csv', 'pdf' //'copy', 'csv', 'excel', 'pdf'
                ]
      }); 
   return false;
 }
 
});
</script>

    <script>
		
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
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.1/js/buttons.html5.min.js"></script>