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
											<label class="col-lg-1 no-space control-label margin-top-5">Publication</label>
												<div class="col-md-4">
													<select name="pub_id" id = "pub_id" class="select2me form-control margin-bottom-10" required >
														<option value="">Select</option>
													<?php foreach($publications as $pub_row){ ?>
														<option value = "<?php echo($pub_row['id'])?>" <?php if(isset($_GET['pub_id']) && $_GET['pub_id'] == $pub_row['id'])echo"selected"; ?> >
															<?php echo($pub_row['name']); ?>
														</option>
													<?php } ?>
														<option value="all" <?php if(isset($_GET['pub_id']) && $_GET['pub_id'] == 'all')echo"selected"; ?> >All</option>
													</select>
												</div>
												<label class="col-lg-1 no-space control-label margin-top-5">Date Range</label>
												<div class="col-md-4">
													<div class="input-group input-large date-picker input-daterange" data-date="2012-10-11" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
														<input type="text"  name="from_date" placeholder="YYYY-MM-DD" class="form-control" <?php if(isset($_GET['from_date'])) echo 'value = "'.$_GET['from_date'].'"'; ?> autocomplete="off" required>
														<span class="input-group-addon">
														to </span>
														<input type="text" name="to_date" placeholder="YYYY-MM-DD" class="form-control" <?php if(isset($_GET['to_date'])) echo 'value = "'.$_GET['to_date'].'"'; ?> autocomplete="off" required>
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
									<span class="font-md font-grey-gallery bold">Q&A</span>
								</div>
								</div>
							</div>
						</div>
						
						<div class="row col-md-offset-2 list-separated">
							<div class="col-md-2 col-sm-2 col-xs-6">
							    <!-- count from orders table between specified timstamp (created_on) according to specified publication(orders.publication_id)-->
								<div class="uppercase font-hg font-blue"><?php echo $new_order_count; ?></div>
								<div class="font-grey-mint font-sm" title="count from orders table between specified timstamp (orders.created_on) according to publication(orders.publication_id)">New Order Count</div>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-6">
							    <!-- count from orders_Q_A table between specified timstamp (orders.created_on) according to specified publication(orders.publication_id)-->
								<div class="uppercase font-hg font-blue"><?php echo $question_sent_count; ?></div>
								<div class="font-grey-mint font-sm" title="count from orders_Q_A table between specified timstamp (orders.created_on) according to publication(orders.publication_id)">Question Sent Count</div>
							</div>
						</div>
											
			            </div>
					</div>
				</div>
			</div>
			</div>
		</div>
		
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