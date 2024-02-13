<?php $this->load->view("new_admin/header.php");?>
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
									Bill Report :<?php if(isset($from) && isset($to)){echo $from." to ".$to;}elseif(isset($today)){echo $today;} ?>
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
									<th>Date</th>
									<th>Adwit Id</th>
									<th>Adrep</th>
									<th>Publication</th>
									<th>Job Name</th>
									<th>No. of pages</th>
									<th>Publish Date</th>
									<th>PDF</th>
								</tr>
								</thead>
								<tbody>
<?php 
		foreach($orders as $row)
		{	
			
			
?>								
		<tr>
			<td><?php echo date("Y-m-d",strtotime($row['created_on'])); ?></td>
			
            <td><?php echo $row['id']; ?></td>

			<td><?php echo $row['adrepName']; ?></td>
			
			<td><?php echo $row['publicationName']; ?></td>

			<td><?php echo $row['unique_job_name']; ?></td>
			
			<td><?php echo $row['No_of_pages']; ?></td>
			
			<td><?php echo date("Y-m-d",strtotime($row['publish_date'])); ?></td>

			<td><?php echo $row['pdf']; ?></td>
			
			
			
		</tr>
 <?php } ?>								
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