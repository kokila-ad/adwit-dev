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
			<label>Number of Revision by Category Report : <?php if(isset($from) && isset($to)){ $from1 = strtotime($from); $to1 = strtotime($to); echo date('M d, Y', $from1)." to ".date('M d, Y', $to1) ;} ?></label>
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
					<th>Version</th>
					<th>P</th>
					<th>M</th>
					<th>N</th>
					<th>T</th>
					<th>W</th>
				</tr>
			</thead>
			<tbody>
			<?php
			if(isset($output)){
			    foreach($output as $row){
			?>
			        <tr>
    					<td><b><?php echo $row['0']; ?></b></td>   <!-- version -->
    					<td><?php echo $row['1']; ?></td>   <!-- P -->
    					<td><?php echo $row['2']; ?></td>   <!-- M -->
    					<td><?php echo $row['3']; ?></td>   <!-- N -->
    					<td><?php echo $row['4']; ?></td>   <!-- T -->
    					<td><?php echo $row['5']; ?></td>   <!-- W -->
					</tr>
				      
			<?php
				}
			}
			?>
			 </tbody>
		<?php if(isset($total_p)){ ?> 
			 <tfoot>
			     <tr>
			         <th>Total</th>
			         <th><?php echo $total_p; ?></th>
			         <th><?php echo $total_m; ?></th>
			         <th><?php echo $total_n; ?></th>
			         <th><?php echo $total_t; ?></th>
			         <th><?php echo $total_w; ?></th>
			     </tr>
			 </tfoot>
		<?php } ?> 
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