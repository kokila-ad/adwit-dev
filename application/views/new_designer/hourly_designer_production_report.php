<?php $this->load->view('new_designer/head')?>

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

<div class="page-content">
    <div class="container">
        <div class="portlet light">
        	<div class="portlet-title">
        		<div class="caption">
        			<label>Hourly Designer Production Report : <?php if(isset($from) && isset($to)){ $from1 = strtotime($from); $to1 = strtotime($to); echo date('M d, Y', $from1)." to ".date('M d, Y', $to1) ;} ?></label>
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
        				    <form method="get">
        					<div class="col-md-6 col-lg-6">
        					    <div class="row">
        						
        						    <div class="col-md-6 col-lg-6">
        						    <select id="dateRange" name="dateRange" class="colorselector select2me form-control margin-bottom-10 border-radius-5  select2-offscreen" tabindex="-1" title="">
                                		<option value="">Select</option>
                                		<option value="today" <?php if(isset($_GET['dateRange']) && $_GET['dateRange'] == 'today') echo 'selected'; ?>>Today</option>
                                		<option value="one_week" <?php if(isset($_GET['dateRange']) && $_GET['dateRange'] == 'one_week') echo 'selected'; ?>>1 Week</option>
                                		<option value="one_month" <?php if(isset($_GET['dateRange']) && $_GET['dateRange'] == 'one_month') echo 'selected'; ?>>1 Month</option>
                                		<option value="three_month" <?php if(isset($_GET['dateRange']) && $_GET['dateRange'] == 'three_month') echo 'selected'; ?>>3 Month</option>
                                		<option value="one_year" <?php if(isset($_GET['dateRange']) && $_GET['dateRange'] == 'one_year') echo 'selected'; ?>>1 Year</option>
                                		<option value="custom" <?php if(isset($_GET['dateRange']) && $_GET['dateRange'] == 'custom') echo 'selected'; ?>>Custom</option>
                                    </select>
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                    <select id="designer_id" name="designer_id" class="colorselector select2me form-control margin-bottom-10 border-radius-5  select2-offscreen" tabindex="-1" title="">
                                		<option value="">Select</option>
                                		<?php foreach($designers as $designer){ ?>
                                		    <option value="<?php echo $designer['id']; ?>" <?php if(isset($_GET['designer_id']) && $_GET['designer_id'] == $designer['id']) echo 'selected'; ?>>
                                		        <?php echo $designer['name']; ?>
                                		    </option>
                                		<?php } ?>
                                    </select>
                                    </div>
                                
                                </div>
                            </div>
        					
        					<div class="col-md-5 col-lg-5 text-right" id="customDiv">
        					
            						<div class="col-md-4">
            							<div class="input-group input-large date-picker input-daterange" data-date="2012-10-11" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
            								<input type="text"  name="from_date" id="from_date" <?php if(isset($_GET['from_date'])) echo"value='".$_GET['from_date']."'"; ?> placeholder="YYYY-MM-DD" class="form-control" autocomplete="off" >
            								<span class="input-group-addon"> to </span>
            								<input type="text" name="to_date" id="to_date" <?php if(isset($_GET['to_date'])) echo"value='".$_GET['to_date']."'"; ?> placeholder="YYYY-MM-DD" class="form-control" autocomplete="off" >
            							</div>
            						</div>	
            						<div class="">
            							<input type="submit" name="date_submit" class="btn bg-green-haze" value="Submit">
            						</div>
            					
        					</div>
        					</form>
        				</div>
        			</div>
        		</div>
        		<table class="table table-striped table-bordered table-hover" id="sample_6">
        			<thead>
        				<tr>
        				    <th>Date</th>
        					<th>12:00 AM</th>
        					<th>1:00 AM</th>
        					<th>2:00 AM</th>
        					<th>3:00 AM</th>
        					<th>4:00 AM</th>
        					<th>5:00 AM</th>
        					<th>6:00 AM</th>
        					<th>7:00 AM</th>
        					<th>8:00 AM</th>
        					<th>9:00 AM</th>
        					<th>10:00 AM</th>
        					<th>11:00 AM</th>
        					<th>12:00 PM</th>
        					<th>1:00 PM</th>
        					<th>2:00 PM</th>
        					<th>3:00 PM</th>
        					<th>4:00 PM</th>
        					<th>5:00 PM</th>
        					<th>6:00 PM</th>
        					<th>7:00 PM</th>
        					<th>8:00 PM</th>
        					<th>9:00 PM</th>
        					<th>10:00 PM</th>
        					<th>11:00 PM</th>	
        					<th>Avg</th>
        				</tr>
        			</thead>
        			<tbody>
        			<?php
        			//var_dump($output);
        			if(isset($output)){
        			    foreach($output as $row){	
        				    
        			?>
        			       	<tr>
            					<td><?php echo '<b>'.$row['dateValue'].'</br>'; ?></td>
            					<?php 
            					    $total = 0;
            					    foreach($row['adCount'] as $h){
            					        $total += $h;
            					        echo '<td>'.$h.'</td>'; 
            					    } 
            					    $avg = $total / 24;
            					   
            					?> 
            					<td><?php echo round($avg, 2); ?></td>
            				</tr>
        					
        			<?php 
        			    }
        			} 
        			?>
        			</tbody>		
        		</table>
        	</div>
        </div>
    </div>
</div>
<script>
        $(document).ready(function(){
            <?php if(isset($_GET['dateRange']) && $_GET['dateRange'] == 'custom'){ ?>
                $('#customDiv').show();
                $("#from_date").prop('required',true);
                $("#to_date").prop('required',true);
             <?php }else{ ?>
                $('#customDiv').hide();
                $('#from_date').removeAttr('required');
                $('#to_date').removeAttr('required');
                $('#from_date').val('');
                $('#to_date').val('');
             <?php } ?>
     
            $("#dateRange").change(function() {
                var d = $(this).val(); //alert(d);
                if(d == 'custom'){
                    $('#customDiv').show();
                    $("#from_date").prop('required',true);
                    $("#to_date").prop('required',true);
                }else{
                    this.form.submit();
                }
            });
            
            $("#designer_id").change(function() {
               var d = $("#dateRange").val(); 
               if(d != 'custom'){
                   this.form.submit();
               }
                
            });
        });
</script>	
<?php $this->load->view('new_designer/foot')?>
<?php //$this->load->view("new_admin/datatable"); ?>