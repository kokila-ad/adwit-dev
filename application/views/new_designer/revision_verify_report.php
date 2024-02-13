<?php $this->load->view("new_designer/head");  ?>

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
<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
		<div class="container">
<div class="portlet light">
    <div class="portlet-title">
        		<div class="caption">
        			<label>Revision Verification  : <?php if(isset($from) && isset($to)){ $from1 = strtotime($from); $to1 = strtotime($to); echo "<b>".date('M d, Y', $from1)."</b> to <b>".date('M d, Y', $to1)."</b>" ;} ?></label>
        		</div>
        		<div class="margin-top-10 margin-bottom-10 text-right">
        			<button class="btn bg-grey btn-xs" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
        			<span class="cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
        		</div>
        	</div>
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
	<div class="portlet-body">	
	<form method="post">
		<table class="table table-striped table-bordered table-hover" id="sample_6">
			<thead>
				<tr>
					<th style='display:none'></th>
					<th>Helpdesk</th>
					<th>Publication</th>
					<th>AdwitAds ID</th>
					<th>Designer Name</th>
					<th>Code</th>
					<th>Version</th>
					<th>Category</th> 
					<th>Instruction</th>
					<th width="10%">Action</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			if(isset($rev_orders)){
				foreach($rev_orders as $rev_order){ 
					//$prev[] = $rev_order['rev_id']; $prev_rev_id = implode(',',$prev); 
					$help_desk = $this->db->query("SELECT `name` FROM `help_desk` WHERE `id` = '".$rev_order['help_desk']."'")->row_array();
						if(isset($rev_order) && $rev_order['version'] == 'V1a'){
							$designer_name = $this->db->query("SELECT `id`, `name`,`username` FROM `designers` WHERE `id` = '".$rev_order['cat_result_designer']."'")->row_array();
							$prev_ver = $rev_order['cat_result_version'];						
						}else{
							$cur_ver = $rev_order['version'];
							$str = substr($cur_ver, -1);
							$str_prev = chr(ord($str)-1);
							$prev_ver = 'V1'.$str_prev;
							$prev_rev_details = $this->db->query("SELECT `id`, `designer` FROM `rev_sold_jobs` 
																	WHERE rev_sold_jobs.order_id = '".$rev_order['order_id']."' AND rev_sold_jobs.version = '$prev_ver' AND rev_sold_jobs.designer !='0' ")->row_array();
							if(isset($prev_rev_details['designer'])){
								$designer_name = $this->db->query("SELECT `id`, `name`,`username` FROM `designers` WHERE `id` = '".$prev_rev_details['designer']."'")->row_array();
							}
						}
					?>
					
				<td style='display:none'></td>
				<td><?php if(isset($help_desk['name'])){ echo $help_desk['name']; }else{ echo''; } ?></td>
				<td><?php echo $rev_order['publicationName'] ?></td>
				<td> 
					<a style=" color:#5b9bd1;" target = "blank" href="<?php echo base_url().index_page().'new_designer/home/orderview_history/'.$rev_order['help_desk'].'/'.$rev_order['order_id'];?>"><?php echo $rev_order['order_id'];?>
					</a>
				</td>
				<td><?php if(isset($designer_name['name'])){echo $designer_name['name'];}else{echo'';} ?></td>
				<td><?php if(isset($designer_name['username'])){echo $designer_name['username'];}else{echo'';}?></td>
				<td><?php echo $prev_ver;?></td>
				<td><?php echo $rev_order['cat_result_category']; ?></td>
				<td><?php echo $rev_order['rev_note']?></td>
				<td>
				<!--Start: Cancel-->	
				<?php if($rev_order['verify']== '0'){?>	
				<div class = "btn btn-block btn-xs btn-grey cursor-pointer padding-left ">
				<form id="form-id" method = "POST" action="<?php echo base_url().index_page().'new_designer/home/revision_verify_report?dateRange='.$date.'&from='.$from.'&to='.$to.'';?>">
					<input type ="hidden" value="<?php echo $rev_order['rev_id']; ?>" name="id" >
					<input type ="hidden" value="<?php echo $rev_order['order_id']; ?>" name="order_id">
					<input type ="hidden" value ="1" name ="verify">
					<!--<input type ="hidden" value="<?php echo $prev_rev_id; ?>" name="prev_rev_id">-->
					<a href="<?php echo base_url().index_page().'new_designer/home/revision_verify_type/'.$rev_order['rev_id'].'/'.$date.'?from='.$from.'&to='.$to.'';?>">
					<button class = "btn btn-block btn-xs grey" name="submit">Verify</button></a>
				</form>
				</div>
				<?php }?>
				
				<?php if($rev_order['verify']== '1'){?>	
				<div class = "btn btn-block btn-xs padding-5 btn-grey cursor-pointer padding-left-5">
					<input type="hidden" value="<?php echo $rev_order['rev_id']; ?>" name="id">
					<input type="hidden" value="<?php echo $rev_order['order_id']; ?>" name="order_id">
					<a href="<?php echo base_url().index_page().'new_designer/home/revision_verify_type/'.$rev_order['rev_id'].'/'.$date.'?from='.$from.'&to='.$to.'';?>">Verifying</a>
				</div>
				<?php }?>
				
			   <!--End: Cancel-->
			   
				</td>
			</tr>
			<?php } } ?>
			</tbody>		
		</table>
		</form>
	</div>
</div>
</div>
</div>
</div>
<!-- BEGIN FOOTER -->
<?php  $this->load->view("new_designer/foot"); ?>
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
            
        });
</script>
