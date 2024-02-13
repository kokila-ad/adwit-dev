<?php $this->load->view("new_designer/head"); ?>
<!-- BEGIN TOP NAVIGATION MENU -->
			
<!-- END HEADER -->
<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<!-- BEGIN PAGE CONTENT -->
	<div class="page-content">
		<div class="container">
		<!-- BEGIN PROFILE CONTENT -->
				<div class="row margin-top-10">
					<div class="col-md-12">
						<!-- BEGIN PORTLET -->
								<div class="portlet light ">
									<div class="portlet-title">
										<div class="caption caption-md">
											<i class="icon-bar-chart theme-font hide"></i>
											<span class="caption-subject font-blue-madison bold">Team Report</span>
										</div>
								</div>
										<div class="row">
												<div class="col-md-2">
													<select id="dateRange" name="dateRange" required class="colorselector select2me form-control margin-bottom-10 border-radius-5  select2-offscreen" tabindex="-1" title="">
                                                		<option value="">Select Date</option>
                                                		<option value="today" <?php if(isset($_GET['dateRange']) && $_GET['dateRange'] == 'today') echo 'selected'; ?>>Today</option>
                                                		<option value="one_week" <?php if(isset($_GET['dateRange']) && $_GET['dateRange'] == 'one_week') echo 'selected'; ?>>1 Week</option>
                                                		<option value="one_month" <?php if(isset($_GET['dateRange']) && $_GET['dateRange'] == 'one_month') echo 'selected'; ?>>1 Month</option>
                                                		<option value="three_month" <?php if(isset($_GET['dateRange']) && $_GET['dateRange'] == 'three_month') echo 'selected'; ?>>3 Month</option>
                                                		<option value="one_year" <?php if(isset($_GET['dateRange']) && $_GET['dateRange'] == 'one_year') echo 'selected'; ?>>1 Year</option>
                                                		<option value="custom" <?php if(isset($_GET['dateRange']) && $_GET['dateRange'] == 'custom') echo 'selected'; ?>>Custom</option>
                                                    </select>
												</div>
												<div id="customDiv">
    												<form id="customForm">
        										        <div class="col-md-6">	
                                    							<div class="input-group input-large date-picker input-daterange" data-date="2012-10-11" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
                                    								<input type="text"  name="from_date" id="from_date" <?php if(isset($_GET['from_date'])) echo"value='".$_GET['from_date']."'"; ?> placeholder="YYYY-MM-DD" class="form-control" autocomplete="off" >
                                    								<span class="input-group-addon"> to </span>
                                    								<input type="text" name="to_date" id="to_date" <?php if(isset($_GET['to_date'])) echo"value='".$_GET['to_date']."'"; ?> placeholder="YYYY-MM-DD" class="form-control" autocomplete="off" >
                                    							</div>
                                    					</div>
                                    					<div class="col-md-2"><input type="submit" name="date_submit" id="date_submit" class="btn bg-green-haze" value="Submit"></div>
                                					</form>
                            					</div>
                            			</div>
									
									<div class="portlet-body">
										<div class="table-scrollable table-scrollable-borderless">
										<table class="table table-striped table-bordered table-hover" id="user_data_completed">
											<thead>
												<tr>
													<th>Name</th>
													<th>New Ads</th>
													<th>Revision</th>
												
												</tr>
											</thead>
											
								</table>
								</div>
							</div>
						</div>
						<!-- END PORTLET -->
					</div>
				</div>
			<!-- END PROFILE CONTENT -->
		</div>
	</div>
<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->
<!-- BEGIN PRE-FOOTER -->
<!-- END PRE-FOOTER -->
<!-- BEGIN FOOTER -->

<?php $this->load->view("new_designer/foot"); ?>
<script>
    $(document).ready(function(){
        $('#customDiv').hide();
        LoadData('today','','');
        
    });
    
        function LoadData(dataRange, fromDate, toDate)
        {
            var d = dataRange;
            var dataTable = $('#user_data_completed').DataTable({  
                   "processing":true,  
                   "serverSide":true,  
                   "order":[],  
                   "ajax":{  
                        url:"<?php echo base_url().index_page().'new_designer/home/team_report_details'; ?>",  
                        type:"POST",
                        data:{"dateRange":d, "from_date":fromDate, "to_date":toDate}
                   },  
                   "columnDefs":[  
                        {  
                            // "targets":[0, 1],  
                            // "orderable":false,  
                        },  
                   ],
                   // Clear previous data
                   "destroy": true,
              }); 
        }    
        
    $('#dateRange').on('change', function(){
         var d = $(this).val(); //alert(d);
                if(d == 'custom'){
                    $('#customDiv').show();
                    $("#from_date").prop('required',true);
                    $("#to_date").prop('required',true);
                }else{
                    $('#customDiv').hide();
                    $('#from_date').removeAttr('required');
                    $('#to_date').removeAttr('required');
                    $('#from_date').val('');
                    $('#to_date').val('');
                    LoadData(d,'','');
                }
    });
    
    $("#customForm").submit(function(){
        var fromDate = $('#from_date').val();
        var toDate = $('#to_date').val();  
        LoadData('custom', fromDate, toDate);
        return false;
    });
</script>