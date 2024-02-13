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
<script type="text/javascript" src="jquery-1.3.2.js" ></script>
<script type="text/javascript" src="html2csv.js" ></script>

<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<?php
    function foo($seconds) {
        $t = round($seconds);
        return sprintf('%02d:%02d:%02d', ($t/3600),($t/60%60), $t%60);
    }
?>
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
							<div class="caption">
								Production Report - <?php if(isset($from) && isset($to)){echo $from." to ".$to;}elseif(isset($today)){echo $today;} ?>
							</div>
							<div class="tools  margin-left-10">
								<a href="javascript:;" class="collapse"></a>
							    <a href="javascript:;" class="reload"></a>
							</div>
							<div class="margin-top-10 text-right">
								<button class="btn bg-grey btn-xs" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
								<button class="btn bg-grey btn-xs"><i class="fa fa-print"></i> Print</button>
							</div>
						</div>
							
						<div class="portlet-body">
							<!--<div class="portlet light margin-bottom-5">
								<div class="portlet-body">					
									<div class="row">
										<form method="get">
											<label class="col-lg-1 no-space control-label margin-top-5">Date Range</label>
											<div class="col-md-4">
												<div class="input-group input-large date-picker input-daterange" data-date="2012-10-11" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
													<input type="text"  name="from_date" placeholder="YYYY-MM-DD" class="form-control" autocomplete="off">
													<span class="input-group-addon"> to </span>
													<input type="text" name="to_date" placeholder="YYYY-MM-DD" class="form-control" autocomplete="off">
												</div>
											</div>	
											<div class="col-md-1">
												<input type="submit" class="btn bg-green-haze" value="Submit">
											</div>
										</form>
									</div>
								</div>
							</div>-->
				
							<table class="table table-striped table-bordered table-hover" id="sample_6">
								<thead>
    								<tr>
    									<th title="Adwit Id">Order Id</th>
    									<th>Version</th>
    									<th>TimeTaken</th>
    								</tr>
								</thead>
							    <tbody>
                                    <?php 
                                    	    if(isset($new_ad[0]['id'])){
                                    	    
                                    			$new_ad_timetaken = 0; $rev_ad_timetaken = 0; $distinct_order_id=0; $total_ad_count = 0; 
                                    			$new_cat_wt = 0; $rev_cat_wt = 0; $total_wt = 0; $rev_count = 0;
                                    			foreach($new_ad as $nad){ 
                                    			    if($distinct_order_id != $nad['order_no']){ //designer_ads_time contains multiple time slot for an order, consider only first record
                                    			        $distinct_order_id =  $nad['order_no']; 
                                    ?>
                                                    <tr>
                                            			<td><?php echo $nad['order_no']; ?></td>
                                            			<td><?php echo $nad['version']; ?></td>
                                            			<td><?php echo foo($nad['TimeTaken']); ?></td>
                                            		</tr>   
                                    <?php		        
                                    			    }
                                    			}
                                    	    }		
                                    			
                                    			if(isset($rev_ad[0]['id'])){
                                    			    foreach($rev_ad as $rad){
                                    ?>
                                                     <tr>
                                            			<td><?php echo $rad['order_id']; ?></td>
                                            			<td><?php echo $rad['version']; ?></td>
                                            			<td><?php echo foo($rad['time_taken']); ?></td>
                                            		</tr> 
                                    <?php
                                    			    }
                                    			}
                                    ?>								
                                    								
								</tbody>
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