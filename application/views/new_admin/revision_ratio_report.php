<?php $this->load->view('new_admin/header')?>

<style>
    @media (max-width: 767px)
    {
        .list-separated {
            position: relative;
            left: 36px;
        }
    }
    
</style>
<!-- BEGIN PAGE CONTAINER -->
<div class="page-container"></div>
	<div class="page-content">
		<div class="container">
		    <div class="portlet light margin-bottom-5">
		        <div class="portlet-title">
            		<div class="caption">
            			<label>Revision Ratio Report : <span id="DateRangeDisplay"></span><?php //if(isset($from) && isset($to)){ $from1 = strtotime($from); $to1 = strtotime($to); echo "<b>".date('M d, Y', $from1)."</b> to <b>".date('M d, Y', $to1)."</b>" ;} ?></label>
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
                                        		<!--<option value="">Select</option>-->
                                        		<option value="today" <?php if(isset($_GET['dateRange']) && $_GET['dateRange'] == 'today') echo 'selected'; ?>>Today</option>
                                        		<option value="one_week" <?php if(isset($_GET['dateRange']) && $_GET['dateRange'] == 'one_week') echo 'selected'; ?>>1 Week</option>
                                        		<option value="one_month" <?php if(isset($_GET['dateRange']) && $_GET['dateRange'] == 'one_month') echo 'selected'; ?>>1 Month</option>
                                        		<option value="three_month" <?php if(isset($_GET['dateRange']) && $_GET['dateRange'] == 'three_month') echo 'selected'; ?>>3 Month</option>
                                        		<option value="one_year" <?php if(isset($_GET['dateRange']) && $_GET['dateRange'] == 'one_year') echo 'selected'; ?>>1 Year</option>
                                        		<option value="custom" <?php if(isset($_GET['dateRange']) && $_GET['dateRange'] == 'custom') echo 'selected'; ?>>Custom</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 col-lg-6">
                                            <div>
                                                <label class="inline version"><input type="radio" name="version" value="V1" checked <?php if(isset($_GET['version']) && $_GET['version'] == 'V1') echo 'checked'; ?>>V1-V1a</label>
                                                <label class="inline version"><input type="radio" name="version" value="V1a" <?php if(isset($_GET['version']) && $_GET['version'] == 'V1a') echo 'checked'; ?>>V1a-V1b</label>
                                                <label class="inline version"><input type="radio" name="version" value="V1b" <?php if(isset($_GET['version']) && $_GET['version'] == 'V1b') echo 'checked'; ?>>V1b-V1c</label>
                                            </div>
                                            <!--<a href="<?php echo base_url().index_page().'new_admin/home/revision_ratio_report/V1';?>" 
                                            <?php if($version == 'V1') echo 'class="btn btn-success"'; else echo 'class="btn btn-primary"'; ?>>V1-V1a</a> 
                                            <a href="<?php echo base_url().index_page().'new_admin/home/revision_ratio_report/V1a';?>" 
                                            <?php if($version == 'V1a') echo 'class="btn btn-success"'; else echo 'class="btn btn-primary"'; ?>>V1a-V1b</a> 
                                            <a href="<?php echo base_url().index_page().'new_admin/home/revision_ratio_report/V1b';?>" 
                                            <?php if($version == 'V1b') echo 'class="btn btn-success"'; else echo 'class="btn btn-primary"'; ?>>V1b-V1c</a> 
                                            -->
                                        </div>
                                        <!--<div class="col-md-6 col-lg-6">
                                            <select id="team" name="team" required class="colorselector select2me form-control margin-bottom-10 border-radius-5  select2-offscreen" tabindex="-1" title="">
                                        		<?php foreach($adwit_teams as $team){ ?>
                                        		    <option value="<?php echo $team['adwit_teams_id']; ?>" <?php if(isset($_GET['team']) && $_GET['team'] == $team['adwit_teams_id']) echo 'selected'; ?>>
                                        		        <?php echo $team['name']; ?>
                                        		    </option>
                                        		<?php } ?>
                                            </select>
                                        </div>-->
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
        				<div class="row">
        				    <div class="portlet light border padding-top-0">	
    						    <div class="portlet light">
    							    <div class="portlet-title">
    							        <div class="col-md-6">
        								<div class="caption">
        									<span class="font-md font-grey-gallery bold">Adwit Global</span> 
        									<!--<span id="loading<?php echo $adwit_teams_id; ?>" class="font-md font-green">  Loading...</span>-->
        								</div>
    								</div>
                    				    <!--<div class="col-md-3" id="DesignerOverAllCount"></div>
                    				    <div class="col-md-3" id="NewAdOverAllCount"></div>
                    				    <div class="col-md-3" id="RevAdOverAllCount"></div>
                    				    <div class="col-md-3" id="RatioOverAllCount"></div>-->
        				            </div>
        			            </div>
        			            <div class="row col-md-offset-1 list-separated">
        			                <table class="table table-striped table-bordered table-hover">
        			                    <thead>
        			                    <tr>
        			                        <th>DesignerOverAllCount </th> 
        			                        <th>NewAdOverAllCount</th>
        			                        <th>RevAdOverAllCount</th>
        			                        <th>OverAllRatio</th>
        			                    </tr>
        			                    </thead>
        			                    <tbody>
        			                        <tr style="color:#e14e6a">
        			                           <td id="DesignerOverAllCount"></td> 
            			                        <td id="NewAdOverAllCount"></td>
            			                        <td id="RevAdOverAllCount"></td>
            			                        <td id="RatioOverAllCount"></td> 
        			                        </tr>
        			                    </tbody>
        			                </table>
        			            </div>
        	        	    </div>
        				</div>
        			</div>
        		</div>
        	
			<div class="row margin-top-15">
			<?php $i=0; foreach($adwit_teams as $adwit_team){ $i++; $adwit_teams_id = $adwit_team['adwit_teams_id']; ?>
				<div class="col-sm-6" style="height: 800px;" id="Team<?php echo $adwit_teams_id; ?>">
					<div class="portlet light border padding-top-0">	
    						 <div class="portlet light">
    							<div class="portlet-title">
    							    <div class="col-md-6">
        								<div class="caption">
        									<span class="font-md font-grey-gallery bold"><?php echo $adwit_team['name']; ?></span> 
        									<span id="team_total_count<?php echo $adwit_teams_id; ?>" class="font-sm"></span>
        									<span id="loading<?php echo $adwit_teams_id; ?>" class="font-md font-green">  Loading...</span>
        								</div>
    								</div>
    							</div>
    						</div>
						    <!-- Status wise Ad count -->
						    <div class="row col-md-offset-1 list-separated" id="status_wise_count_div<?php echo $adwit_teams_id; ?>">
						        
					    </div>
						    
					</div>
				</div>    
			<?php } ?>
			</div>
	    </div>
    </div>


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

<script>
    $(document).ready(function(){
            /*
            $('#sample_6').dataTable({
                "iDisplayLength": 10
            });*/
            
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
            
            $("#team").change(function() {
               var d = $("#dateRange").val(); 
               if(d != 'custom'){
                   this.form.submit();
               }
            });
            //version radio button change
             $(".version").change(function(){
                this.form.submit();
            }); 
            
        //ajax call //dateRange,team,from_date,to_date
        const formatter = new Intl.NumberFormat('en-US', {
                                                   minimumFractionDigits: 2,      
                                                   maximumFractionDigits: 2,
                                                });
        var overAllDesignerAdCount = 0; var NewAdOverAllCount = 0; var RevAdOverAllCount = 0; var OverAllRatio = 0;
        <?php foreach($adwit_teams as $adwit_team){ $adwit_teams_id = $adwit_team['adwit_teams_id']; ?>
        var jqxhr = $.get("<?php echo base_url().index_page().'new_admin/home/revision_ratio_report_detail/'.$adwit_teams_id;?>", 
            { dateRange: $("#dateRange").val(), from_date: $('#from_date').val(), to_date: $('#to_date').val(), 
                version: $('input[name="version"]:checked').val() },
            function(data){
                var myObj = JSON.parse(data);
                $("#status_wise_count_div<?php echo $adwit_teams_id; ?>").append(myObj.output);
                $("#DateRangeDisplay").html(myObj.DateRangeDisplay);
                $('#loading<?php echo $adwit_teams_id; ?>').hide();
                
               overAllDesignerAdCount = parseInt(overAllDesignerAdCount) + parseInt(myObj.totalDesigner);  
               NewAdOverAllCount = parseInt(NewAdOverAllCount) + parseInt(myObj.totalNewAdCount);
               RevAdOverAllCount = parseInt(RevAdOverAllCount) + parseInt(myObj.totalRevisionAdCount);
               
                $("#DesignerOverAllCount").html(overAllDesignerAdCount);
                $("#NewAdOverAllCount").html(NewAdOverAllCount);
                $("#RevAdOverAllCount").html(RevAdOverAllCount);
                  
                if(RevAdOverAllCount > 0) OverAllRatio = (parseInt(RevAdOverAllCount) / parseInt(NewAdOverAllCount)) * 100, 2; 
                
                $("#RatioOverAllCount").html(formatter.format(OverAllRatio));
                  
               //console.log('overAllDesignerAdCount - '+overAllDesignerAdCount); 
            }
        );
        <?php } ?>
           
    });
</script>
<?php $this->load->view('new_admin/footer')?>
<?php $this->load->view("new_admin/datatable"); ?>