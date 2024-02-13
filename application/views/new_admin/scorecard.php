<?php $this->load->view("new_admin/header.php");?>
<script type="text/javascript" src="jquery-1.3.2.js" ></script>
<script type="text/javascript" src="html2csv.js" ></script>

<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>

	<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
				 
				<div class="portlet light">
					<div class="portlet-body">					
					
				
				<!-- BEGIN PAGE HEADER-->
				<!-- END PAGE HEADER-->
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet ">
							<div class="portlet-body">
								
								<div class="portlet light margin-bottom-5">
									<div class="portlet-body">					
										<div class="row">
											<form method="get">
												<label class="col-lg-1 no-space control-label margin-top-5">Date Range</label>
												<div class="col-md-4">
													<div class="input-group input-large date-picker input-daterange" data-date="2012-10-11" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
														<input type="text"  name="from_date" placeholder="YYYY-MM-DD" class="form-control" <?php if(isset($_GET['from_date'])) echo 'value = "'.$_GET['from_date'].'"'; ?> autocomplete="off">
														<span class="input-group-addon">
														to </span>
														<input type="text" name="to_date" placeholder="YYYY-MM-DD" class="form-control" <?php if(isset($_GET['to_date'])) echo 'value = "'.$_GET['to_date'].'"'; ?> autocomplete="off">
													</div>
												</div>	
												<div class="col-md-1">
													<input type="submit" class="btn bg-green-haze" value="Submit">
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
								
							</div>
						</div>
						<!-- END EXAMPLE TABLE PORTLET-->
					</div>
		<div class="container">
			<div class="row margin-top-15">
				<div class="col-sm-12">
					<div class="portlet light border padding-top-0">
						<div class="portlet light">
							<div class="portlet-title">
							<div class="col-md-3">
								<div class="caption">
									<span class="font-md font-grey-gallery bold">Scorecard</span>
								</div>
								</div>
							</div>
						</div>
						
						<div class="row col-md-offset-2 list-separated">
							<div class="col-md-2 col-sm-2 col-xs-6">
								<div class="uppercase font-hg font-blue"><?php echo $new_order_count; ?></div>
								<div class="font-grey-mint font-sm" title="order count from `orders` table `created_on` between specified timestamp">New Ads Number</div>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-6">
								<div class="uppercase font-hg font-blue"><?php echo $new_order_nj; ?></div>
								<div class="font-grey-mint font-sm" title="weightage from `print` table according to `category` of order from `cat_result` table">New Ads NJ</div>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-6">
								<div class="uppercase font-hg  font-blue"><?php echo $rev_order_count; ?></div>
								<div class="font-grey-mint font-sm" title="Revision order count from `rev_sold_jobs` table `date` between specified timestamp">Revision Number</div>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-6">
								<div class="uppercase font-hg  font-blue"><?php echo $rev_order_nj; ?></div>
								<div class="font-grey-mint font-sm" title="weightage 0.25 * revision order count">Revision NJ</div>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-6">
								<div class="uppercase font-hg font-blue"><?php echo $new_and_rev_ratio; ?></div>
								<div class="font-grey-mint font-sm" title="revision order count / new order count">New Ads vs Revision Ration</div>
							</div>
						</div>
											
			            </div>
					</div>
				</div>
			</div>
			</div>
		</div>
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