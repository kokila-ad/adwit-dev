<?php $this->load->view("new_admin/header"); ?>

<script>
$(document).ready(function(){	    
	$(".dropdown-checkboxes").hide();	
	$('.date-picker').click(function() {
		$(".cursor-pointer").addClass(" filter ");
	});	
	$('#filter').click(function() {
		$(".dropdown-checkboxes").toggle();
	});
});
</script>


<div class="portlet light">
	<div class="portlet-title">
		<div class="caption">
			<label>Hourly Production Report : <?php if(isset($from) && isset($to)){ $from1 = strtotime($from); $to1 = strtotime($to); echo date('M d, Y', $from1)." to ".date('M d, Y', $to1) ;} ?></label>
		</div>
		<div class="margin-top-10 margin-bottom-10 text-right">
			<button class="btn bg-grey btn-xs" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
			<span class="cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
		</div>
	</div>
	<div class="portlet-body">
	    <!-- Date Select DropDown -->
	    <div class="portlet light margin-bottom-5">
			<div class="portlet-body">					
				<div class="row">
					<div class="col-md-4 col-lg-4">
						<form method="get">
									        <select id="dateRange" name="dateRange" class="colorselector select2me form-control margin-bottom-10 border-radius-5  select2-offscreen" tabindex="-1" title="">
                        						<option value="">Select</option>
                        						<option value="today" <?php if(isset($_GET['dateRange']) && $_GET['dateRange'] == 'today') echo 'selected'; ?>>Today</option>
                        						<option value="one_week" <?php if(isset($_GET['dateRange']) && $_GET['dateRange'] == 'one_week') echo 'selected'; ?>>1 Week</option>
                        						<option value="one_month" <?php if(isset($_GET['dateRange']) && $_GET['dateRange'] == 'one_month') echo 'selected'; ?>>1 Month</option>
                        						<option value="three_month" <?php if(isset($_GET['dateRange']) && $_GET['dateRange'] == 'three_month') echo 'selected'; ?>>3 Month</option>
                        						<option value="one_year" <?php if(isset($_GET['dateRange']) && $_GET['dateRange'] == 'one_year') echo 'selected'; ?>>1 Year</option>
                        						<option value="custom" <?php if(isset($_GET['dateRange']) && $_GET['dateRange'] == 'custom') echo 'selected'; ?>>Custom</option>
                        					</select>
                        					</form>
									    </div>
									    <div class="col-md-8 col-lg-8 text-right" id="customDiv">
									     	<form id="form_date" method="get">
    											
    											<div class="col-md-4">
    												<div class="input-group input-large date-picker input-daterange" data-date="2012-10-11" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
    													<input type="text"  name="from_date" id="from_date" <?php if(isset($_GET['from_date'])) echo"value='".$_GET['from_date']."'"; ?> placeholder="YYYY-MM-DD" class="form-control" autocomplete="off" required>
    													<span class="input-group-addon"> to </span>
    													<input type="text" name="to_date" id="to_date" <?php if(isset($_GET['to_date'])) echo"value='".$_GET['to_date']."'"; ?> placeholder="YYYY-MM-DD" class="form-control" autocomplete="off" required>
    												</div>
    											</div>	
    											<div class="">
    											    <input type="hidden" name="dateRange" value="custom">
    												<input type="submit" name="date_submit" class="btn bg-green-haze" value="Submit">
    											</div>
    										</form>
										</div>
									</div>
								</div>
							</div>
		<table class="table table-striped table-bordered table-hover" id="sample_6">
			<thead>
				<tr>
					<th>Category</th>
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
					<!--<th>Total</th>-->
				</tr>
			</thead>
			<tbody>
			<?php
			if(isset($orders[0]['id'])){
			    for($i=1;$i<=24;$i++){ $p[$i] = '0'; $m[$i] = '0'; $n[$i] = '0'; $t[$i] = '0'; $w[$i] = '0'; }
				foreach($orders as $order){
				
					    $time_range = $this->db->get('time_range')->result_array();
					    $pdf_datetime = explode(" ", $order['pdf_timestamp']);
					    $pdf_sent_time = strtotime($pdf_datetime[1]);
					    $i=0;
						foreach($time_range as $tr){ 
						    $i++;
						    //P
							if(($pdf_sent_time >= strtotime($tr['from']) && $pdf_sent_time <= strtotime($tr['to'])) && $order['category'] == 'P'){ 
							    $p[$i]++ ; 
							}
							//M
							if(($pdf_sent_time >= strtotime($tr['from']) && $pdf_sent_time <= strtotime($tr['to'])) && $order['category'] == 'M'){ 
							    $m[$i]++ ; 
							}
							//N
							if(($pdf_sent_time >= strtotime($tr['from']) && $pdf_sent_time <= strtotime($tr['to'])) && $order['category'] == 'N'){ 
							    $n[$i]++ ; 
							}
							//T
							if(($pdf_sent_time >= strtotime($tr['from']) && $pdf_sent_time <= strtotime($tr['to'])) && $order['category'] == 'T'){ 
							    $t[$i]++ ; 
							}
							//W
							if(($pdf_sent_time >= strtotime($tr['from']) && $pdf_sent_time <= strtotime($tr['to'])) && $order['category'] == 'W'){ 
							    $w[$i]++ ; 
							}
						}
				}
					
			?>
			        <!-- P category Entries-->
					<tr>
    					<td><?php echo 'P'; ?></td>
    					<?php for($i=1;$i<=24;$i++){ echo '<td>'.$p[$i].'</td>'; } ?> 
    					<!--<td><?php echo '';//count($orders);?></td>-->
					</tr>
					<!-- M category Entries-->
					<tr>
					    <td><?php echo 'M'; ?></td>
					    <?php for($i=1;$i<=24;$i++){ echo '<td>'.$m[$i].'</td>'; } ?> 
					    <!--<td><?php echo '';//count($orders);?></td>-->
					</tr>
					<!-- N category Entries-->
					<tr>
					    <td><?php echo 'N'; ?></td>
					    <?php for($i=1;$i<=24;$i++){ echo '<td>'.$n[$i].'</td>'; } ?> 
					    <!--<td><?php echo '';//count($orders);?></td>-->
					</tr>
					<!-- T category Entries-->
					<tr>
    					<td><?php echo 'T'; ?></td>
    					<?php for($i=1;$i<=24;$i++){ echo '<td>'.$t[$i].'</td>'; } ?> 
    					<!--<td><?php echo '';//count($orders);?></td>-->
					</tr>
					<!-- W category Entries-->
					<tr>
    					<td><?php echo 'W'; ?></td>
    					<?php for($i=1;$i<=24;$i++){ echo '<td>'.$w[$i].'</td>'; } ?> 
    					<!--<td><?php echo '';//count($orders);?></td>-->
					</tr>
			<?php } ?>
			</tbody>		
		</table>
	</div>
</div>

<script>
        $(document).ready(function(){
            <?php if(isset($_GET['dateRange']) && $_GET['dateRange'] == 'custom'){ ?>
                $('#customDiv').show();
             <?php }else{ ?>
                $('#customDiv').hide();
             <?php } ?>
     
            $("#dateRange").change(function() {
                var d = $(this).val(); //alert(d);
                if(d == 'custom'){
                    $('#customDiv').show();
                }else{
                    this.form.submit();
                }
            });
        
        });
</script>	
<?php $this->load->view("new_admin/footer"); ?>
<?php $this->load->view("new_admin/datatable"); ?>