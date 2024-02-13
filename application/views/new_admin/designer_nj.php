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
							<div class="portlet light margin-bottom-5">
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
							</div>
				
							<table class="table table-striped table-bordered table-hover" id="sample_6">
								<thead>
    								<tr>
    									<th title="Designer name with username">Designer</th>
    									<th>Total Ads</th>
    									<th>Total number of hours worked(hh:mm:ss)</th>
    									<th>Total nj</th>
    								</tr>
								</thead>
							    <tbody>
                                    <?php 
                                    	if(isset($designers[0]['id'])){
                                    	    foreach($designers as $row){
                                    	        $new_ad_query = "SELECT cat_result.id, cat_result.order_no, designer_ads_time.designer_id,
		                                                TIMESTAMPDIFF(SECOND, designer_ads_time.start_time, CONCAT(designer_ads_time.end_date,' ',designer_ads_time.end_time)) AS TimeTaken 
                                                        , print.wt
                                                        FROM `cat_result`
                    		                            JOIN `designer_ads_time` ON cat_result.order_no = designer_ads_time.order_id
                    		                            JOIN `print` ON cat_result.category = print.name
                    		                            WHERE cat_result.designer = '".$row['id']."' AND cat_result.ddate BETWEEN '".$from."' AND '".$to."'";
                    		                           
                    		                           
                                    		    //echo $new_ad_query;
                                    			$new_ad = $this->db->query($new_ad_query)->result_array();
                                    			$new_ad_timetaken = 0; $rev_ad_timetaken = 0; $distinct_order_id=0; $total_ad_count = 0; 
                                    			$new_cat_wt = 0; $rev_cat_wt = 0; $total_wt = 0; $rev_count = 0;
                                    			foreach($new_ad as $nad){ 
                                    			    if($distinct_order_id != $nad['order_no']){ //designer_ads_time contains multiple time slot for an order, consider only first record
                                    			        $new_ad_timetaken = $new_ad_timetaken + $nad['TimeTaken'];
                                    			        $new_cat_wt = $new_cat_wt + $nad['wt'];
                                    			        $total_ad_count++;
                                    			    }
                                    			    $distinct_order_id = $nad['order_no'];
                                    			}
                                    			
                                    			$rev_ad_query = "SELECT SUM(rev_sold_jobs.time_taken) AS TimeTaken, COUNT(rev_sold_jobs.id) AS RevCount FROM rev_sold_jobs
                                    			                    WHERE rev_sold_jobs.designer = '".$row['id']."' AND rev_sold_jobs.date BETWEEN '".$from."' AND '".$to."'";
                                    			//echo $rev_ad_query;
                                    			$rev_ad = $this->db->query($rev_ad_query)->result_array();
                                    			
                                    			if(isset($rev_ad[0]['TimeTaken'])){
                                    			    $rev_count = $rev_ad[0]['RevCount'];
                                    			    $rev_ad_timetaken = $rev_ad[0]['TimeTaken'];
                                    			    $rev_cat_wt = $rev_ad[0]['RevCount'] * $rev_wt;
                                    			}
                                    			    $total_timetaken = $new_ad_timetaken + $rev_ad_timetaken;
                                    			    $total_wt = $new_cat_wt + $rev_cat_wt;
                                    ?>								
                                    		<tr>
                                    			<td><?php echo $row['name'].'('.$row['username'].')'; ?></td>
                                    			<td>
                                    			    <a href="<?php echo base_url().index_page().'new_admin/home/designer_nj_details?designer_id='.$row['id'].'&from_date='.$from.'&to_date='.$to; ?>" target="_blank">
                                    			        <?php echo $total_ad_count + $rev_count ; ?>
                                    			    </a>
                                    			</td>
                                    			<td><?php echo foo($total_timetaken); ?></td>
                                    			<td><?php echo $total_wt; ?></td>
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