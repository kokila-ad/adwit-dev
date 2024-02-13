<?php $this->load->view("admin/head1.php");?>
<script type="text/javascript" src="jquery-1.3.2.js" ></script>
<script type="text/javascript" src="html2csv.js" ></script>

<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript">
	$(document).ready(function($) {
        $('#new_ads').change(function() {
            window.location = "<?php echo base_url().index_page().'admin/home/newads_hourly_report/';?>" + $('#new_ads').val() ;
        });
    });
</script>
	<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
				 
				<div class="portlet light">
					<div class="portlet-body">					
						<div class="row">
							<label class="col-lg-4 col-lg-offset-1 col-md-4 col-md-offset-1 col-sm-12 control-label text-right margin-top-5">Select Your Helpdesk:</label>
							<div class="col-lg-3 col-md-4 col-sm-12">
								<select id="new_ads" name="new_ads" class="form-control">
									<option value="">Select</option>
									<?php
										$types = $this->db->query("SELECT * FROM `help_desk` WHERE `active` ='1' ORDER BY `name` ")->result_array();
										foreach($types as $type)
										{
											echo '<option value="'.$type['id'].'" '.($form==$type['id'] ? 'selected="selected"' : '').'>'.$type['name'].'</option>';	
										}
									?>
								</select>
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
									New Ads Report : <?php if(isset($from) && isset($from)){ echo $from.' - '.$to; }else{ echo date('Y-m-d'); } ?>
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
														<input type="text"  name="from_date" placeholder="YYYY-MM-DD" class="form-control">
														<span class="input-group-addon">
														to </span>
														<input type="text" name="to_date" placeholder="YYYY-MM-DD" class="form-control">
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
									<th>Date/Time</th>
									<th>0-1</th>
									<th>1-2</th>
									<th>2-3</th>
									<th>3-4</th>
									<th>4-5</th>
									<th>5-6</th>
									<th>6-7</th>
									<th>7-8</th>
									<th>8-9</th>
									<th>9-10</th>
									<th>10-11</th>
									<th>11-12</th>
									<th>12-13</th>
									<th>13-14</th>
									<th>14-15</th>
									<th>15-16</th>
									<th>16-17</th>
									<th>17-18</th>
									<th>18-19</th>
									<th>19-20</th>
									<th>20-21</th>
									<th>21-22</th>
									<th>22-23</th>
									<th>23-24</th>		
								</tr>
								</thead>
						<tbody>
					<?php 
						foreach($dates as $d){	
								for($i=1;$i<=24;$i++){ $t[$i] = '0'; }
								$orders = $this->db->query("SELECT  * FROM `orders` WHERE `help_desk` = '$form' AND `created_on` LIKE '$d%';")->result_array();
								foreach($orders as $row){ 
									$time_range = $this->db->get('time_range')->result_array();
									$time = strtotime(date('H:i:s', strtotime($row['created_on']))); 
									$i=0;
									foreach($time_range as $tr){ $i++;
										if($time >= strtotime($tr['from']) && $time <= strtotime($tr['to'])){ $t[$i]++ ;}
									}
								}	
								?>
							<tr>
							<td><?php echo $d; ?></td>
							<?php for($i=1;$i<=24;$i++){ ?> 
							<td><?php echo $t[$i]; ?> </td> 
							<?php } ?>
							</tr>
				<?php } ?>
						</tbody>								
								</table>
							</div>
						</div>
<?php } ?>
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
	
<?php $this->load->view("admin/foot1.php");?>