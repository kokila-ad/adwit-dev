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

	<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
				 
				<div class="portlet light">
					<div class="portlet-body">					
					
					
				<hr>		
			
				<!-- BEGIN PAGE HEADER-->
				<!-- END PAGE HEADER-->
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box green-haze">
							<div class="portlet-title">
								<div class="caption">
									Revision Review Report :<?php if(isset($from) && isset($to)){echo $from." to ".$to;}elseif(isset($today)){echo $today;} ?>
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
								
								<div class="portlet light margin-bottom-5">
									<div class="portlet-body">					
										<div class="row">
											<form method="get">
												<label class="col-lg-1 no-space control-label margin-top-5">Date Range</label>
												<div class="col-md-4">
													<div class="input-group input-large date-picker input-daterange" data-date="2012-10-11" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
														<input type="text"  name="from_date" placeholder="YYYY-MM-DD" class="form-control" autocomplete="off">
														<span class="input-group-addon">
														to </span>
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
									<th title="Designer name with username">
									    Designer</th>
									<th title="count from cat_result table of each designer within specified timestamp">
									    New Ads Count</th>
									<th title="count from rev_sold_jobs table of each designer within specified timestamp">
									    Rev Ads Count</th>
									<th title="count from order_revision_review table of each designer within specified timestamp">
									    No.of Ads Reviewed</th>
									<th title="count from order_revision_review table of each designer where designer_mistake = 'yes'  within specified timestamp">
									    No.of Mistakes</th>
								</tr>
								</thead>
								<tbody>
<?php 
	if(isset($from)&& isset($to)){
		$designers = $this->db->query("SELECT id, name, username FROM designers WHERE is_active = '1' ")->result_array();	
		foreach($designers as $row){
			$query = "SELECT COUNT(id) AS ads_count, order_id 
						FROM order_revision_review 
							WHERE designer_id='".$row['id']."' AND timestamp BETWEEN '$from' AND '$to'";
							
			$ads_count = $this->db->query($query)->row_array();
			
		//count from order_revision_review table of each designer within specified timestamp
			$query .= " AND designer_mistake = 'yes'";
			$mistake_count = $this->db->query($query)->result_array();
			
		//count from order_revision_review table of each designer where designer_mistake = 'yes'  within specified timestamp
			$new_ads_count = $this->db->query("SELECT COUNT(id) AS new_ads_count 
							FROM cat_result 
							WHERE designer='".$row['id']."' AND ddate BETWEEN '".$_GET['from_date']."' AND '".$_GET['to_date']."'")->row_array();
		//count from cat_result table of each designer within specified timestamp 				
			$rev_ads_count = $this->db->query("SELECT COUNT(id) AS rev_ads_count 
							FROM rev_sold_jobs 
							WHERE designer='".$row['id']."' AND ddate BETWEEN '".$_GET['from_date']."' AND '".$_GET['to_date']."'")->row_array();
		//count from rev_sold_jobs table of each designer within specified timestamp 					
?>								
		<tr>
			<td><?php echo $row['name'].'('.$row['username'].')'; ?></td>
			
			<td><?php echo $new_ads_count['new_ads_count']; ?></td>
			
			<td><?php echo $rev_ads_count['rev_ads_count']; ?></td>
			
            <td><?php echo $ads_count['ads_count']; ?></td>
			
			<td>
			    <div class="tooltip-wrap">
                    <?php echo $mistake_count[0]['ads_count']; ?>
                    <div class="tooltip-content">
                        <?php foreach($mistake_count as $mcount){ echo $mcount['order_id'].'<br/>'; } ?>
                    </div> 
                </div>
			</td>
			
		</tr>
<?php } } ?>								
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
        $(function() {
            
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