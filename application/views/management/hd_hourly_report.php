<?php $this->load->view("management/head"); ?>
<script type="text/javascript" src="jquery-1.3.2.js" ></script>
<script type="text/javascript" src="html2csv.js" ></script>

<script type="text/javascript">
	$(document).ready(function($) {
        $('#help_desk').change(function() {
            window.location = "<?php echo base_url().index_page().'management/home/hd_hourly_report/';?>" + $('#help_desk').val() ;
        });
    });
</script>

		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">	 
				<div class="container">
				<div class="portlet light">
					<div class="portlet-body">					
						<div class="row">
							<label class="col-lg-4 col-lg-offset-1 col-md-4 col-md-offset-1 col-sm-12 control-label text-right margin-top-5 margin-bottom-10">Select Your Help Desk:</label>
							<div class="col-lg-3 col-md-4 col-sm-12">
								<select id="help_desk" name="help_desk" class="form-control">
									<option value="">Select</option>
									<?php
										$types = $this->db->get_where('help_desk',array('active'=>'1'))->result_array();
										foreach($types as $type)
										{
											echo '<option value="'.$type['id'].'" '.($form==$type['id'] ? 'selected="selected"' : '').'>'.$type['name'].'</option>';	
										}
									?>
								</select>
							</div>
						</div>	
					</div>
				</div>
<?php if(isset($form)){ ?>				
				<div class="portlet light">
							<div class="portlet-title">
								<div class="caption">
									<label>Help Desk Hourly Management Report : <?php if(isset($from) && isset($from)){ echo $from.' - '.$to; }else{ echo date('Y-m-d'); } ?></label>
								</div>
								<div class="margin-top-10 margin-bottom-10 text-right">
									<!--<button class="btn bg-grey btn-xs"><i class="fa fa-file-excel-o"></i> Export</button>-->
									<button class="btn bg-grey btn-xs" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
								</div>
							</div>
							
							<div class="portlet-body">							
										<div class="row no-space margin-bottom-25">
											<form method="post">
												<label class="col-md-1 col-xs-12 margin-bottom-5 no-space control-label margin-top-5">Date Range</label>
												<div class="col-md-4 col-xs-12 margin-bottom-5 no-space">
													<div class="input-group input-large date-picker input-daterange" data-date="2012/10/11" data-date-format="yyyy/mm/dd">
														<input type="text"  name="from_date" placeholder="YYYY-MM-DD" class="form-control">
														<span class="input-group-addon">
														to </span>
														<input type="text" name="to_date" placeholder="YYYY-MM-DD" class="form-control">
													</div>
												</div>	
												<div class="col-md-1 col-xs-12 no-space">
													<input type="submit" class="btn bg-blue" value="Submit">
												</div>
											</form>
										</div>
									
				
								<table class="table table-striped table-bordered table-hover" id="sample_2">
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
									<th>Total</th>
								</tr>
								</thead>
								<tbody>
					<?php 
						foreach($dates as $d){
								for($i=1;$i<=24;$i++){ $t[$i] = '0'; }
								$orders = $this->db->query("SELECT  * FROM `rev_sold_jobs` WHERE `help_desk` = '$form' AND `date` = '$d';")->result_array();
								foreach($orders as $row){
									$time_range = $this->db->get('time_range')->result_array();
									$rev_time = strtotime($row['time']);
									$i=0;
									foreach($time_range as $tr){ $i++;
										if($rev_time >= strtotime($tr['from']) && $rev_time <= strtotime($tr['to'])){ $t[$i]++ ;}
									}
									$tot_jobs = count($orders);
								}	
								?>
							<tr>
							<td><?php echo $d; ?></td>
							<?php for($i=1;$i<=24;$i++){ ?> 
							<td><?php echo $t[$i]; ?> </td> 
							<?php } ?>
							<td><?php echo count($orders);?></td>
							</tr>
				<?php } ?>
						</tbody>		
								</table>
							</div>
						</div>
		<?php } ?>				
			</div>
			</div>
		</div>
		<!-- END CONTENT -->
		<!-- BEGIN QUICK SIDEBAR -->
		<!--Cooming Soon...-->
		<!-- END QUICK SIDEBAR -->
	
<?php $this->load->view("management/foot"); ?>