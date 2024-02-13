<?php $this->load->view("new_admin/header.php");?>

<script type="text/javascript" src="jquery-1.3.2.js" ></script>
<script type="text/javascript" src="html2csv.js" ></script>

<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript">
	$(document).ready(function($) {
        $('#help_desk').change(function() {
            window.location = "<?php echo base_url().index_page().'new_admin/home/billing_revision_report/';?>" + $('#help_desk').val() ;
        });
    });
</script>
	<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
				 
				<div class="portlet light">
					<div class="portlet-body">					
						<div class="row">
							<label class="col-lg-4 col-lg-offset-1 col-md-4 col-md-offset-1 col-sm-12 control-label text-right margin-top-5">Select Your Help Desk:</label>
							<div class="col-lg-3 col-md-4 col-sm-12">
								<select id="help_desk" name="help_desk" class="form-control">
									<option value="">Select Help Desk </option>
									<?php
											$types = $this->db->query("SELECT * FROM `help_desk` WHERE `active`= '1' ORDER BY `name`")->result_array();
										foreach($types as $type)
										{
											echo '<option value="'.$type['id'].'" '.($form==$type['id'] ? 'selected="selected"' : '').'>'.$type['name'].'</option>';	
										}
									?>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-3 col-lg-offset-9">
								<form class="search-form search-form-expanded" method="post">
									<div class="input-group">
										<input type="text" name="order_id" id="order_id" class="form-control" placeholder="Search Order..." >
										<span class="input-group-btn">
										<!--<a href="javascript:;" class="btn submit bg-green-haze"><i class="icon-magnifier"></i></a>-->
										<input class="btn bg-green-haze" type="submit" value="Search" name="search" />
										</span>
									</div>
								</form>
							</div>	
						</div>
					
				<hr>		
<?php if(isset($form)){ ?>				
				<!-- BEGIN PAGE HEADER-->
				<!-- END PAGE HEADER-->
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box green-haze">
							<div class="portlet-title">
								<div class="caption">
									Revision Bill Report :<?php if(isset($from) && isset($to)){echo $from." to ".$to;}elseif(isset($today)){echo $today;} ?>
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
											<form method="post">
												<label class="col-lg-1 no-space control-label margin-top-5">Date Range</label>
												<div class="col-md-4">
													<div class="input-group input-large date-picker input-daterange" data-date="2012/10/11" data-date-format="yyyy/mm/dd">
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
									<th>Time Stamp</th>
									<th>Adwit Id</th>
									<th>Ad Type</th>
									<th>Job Name</th>
									<th>Adrep</th>
									<th>Publication</th>
									<th>Advertiser</th>
									<th>Width</th>
									<th>Height</th>
									<th>Total sq inches</th>
									<th>File path</th>
									<th>Time Taken</th>
									
 								</tr>
								</thead>
								<tbody>
<?php 
		foreach($rev_orders as $row)
		{	
			$tot_size = 0;
			$orders = $this->db->get_where('orders',array('id' => $row['order_id']))->result_array();
			if(isset($orders[0]['id'])){
				$ad_type = $this->db->get_where('orders_type',array('id' => $orders[0]['order_type_id']))->result_array();
				$adrep = $this->db->get_where('adreps',array('id' =>  $orders[0]['adrep_id']))->result_array();
				$publication = $this->db->get_where('publications',array('id' =>  $orders[0]['publication_id']))->result_array();
				$tot_size =  $orders[0]['width'] *  $orders[0]['height'];
				$tt = $row['time_taken'];
				if($tt != '0'){
					$tt = ($tt / 60);
					$tt= round($tt, 0);
				}
?>								
		<tr>  
			<td><?php echo $row['date']; ?></td>
			
			<td><?php echo $row['time'];?></td>
			
            <td><?php echo $row['order_id']; ?></td>
			
			<td><?php echo $ad_type[0]['name']; ?></td>
			
			<td><?php echo $row['new_slug']; ?></td>
			
			<td><?php echo $adrep[0]['first_name'].' '.$adrep[0]['last_name']; ?></td>
			
			<td><?php if($publication) echo $publication[0]['name'] ?></td>
			
			<td><?php echo $orders[0]['advertiser_name']; ?></td>
			
            <td><?php echo $orders[0]['width']; ?></td>
			
            <td><?php echo $orders[0]['height']; ?></td>
			
			<td><?php echo round($tot_size,2); ?></td>
			
            <td><?php echo $row['pdf_path'];  ?></td>
			
			<td><?php echo $tt.'mins';?></td>
			
		</tr>
<?php } } ?>								
		</tbody>
		</table>
	</div>
</div>
						<!-- END EXAMPLE TABLE PORTLET-->
<?php }elseif(isset($search_orders)){ ?>
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box green-haze">
							<div class="portlet-title">
								<div class="caption">
									Search Report
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
								<thead>
								<tr>
									<th>Date</th>
									<th>Adwit Id</th>
									<th>Ad Type</th>
									<th>Job Name</th>
									<th>Adrep</th>
									<th>Publication</th>
									<th>Advertiser</th>
									<th>Width</th>
									<th>Height</th>
									<th>Total sq inches</th>
									<th>File path</th>
								</tr>
								</thead>
								<tbody>
<?php 
		foreach($search_orders as $row)
		{	
			$tot_size = 0;
			$orders = $this->db->get_where('orders',array('id' => $row['order_id']))->result_array();
			if(isset($orders[0]['id'])){
				$ad_type = $this->db->get_where('orders_type',array('id' => $orders[0]['order_type_id']))->result_array();
				$adrep = $this->db->get_where('adreps',array('id' =>  $orders[0]['adrep_id']))->result_array();
				$publication = $this->db->get_where('publications',array('id' => $orders[0]['publication_id']))->result_array();
				$tot_size =  $orders[0]['width'] *  $orders[0]['height'];
			
?>		
		<tr>
			<td><?php echo $row['date']; ?></td>
			<td><?php echo $row['order_id']; ?></td>
			<td><?php echo $ad_type[0]['name']; ?></td>
			<td><?php echo $row['new_slug']; ?></td>
			<td><?php echo $adrep[0]['first_name'].' '.$adrep[0]['last_name']; ?></td>
			<td><?php echo $publication[0]['name']; ?></td>
			<td><?php echo $orders[0]['advertiser_name']; ?></td>
			<td><?php echo $orders[0]['width']; ?></td>
			<td><?php echo $orders[0]['height']; ?></td>
			<td><?php echo round($tot_size,2); ?></td>
			<td><?php echo $row['pdf_path'];  ?></td>
		</tr>
		
<?php } } ?>								
								</tbody>
								</table>
							</div>
						</div>
		<!-- END EXAMPLE TABLE PORTLET-->
<?php } ?>
					
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