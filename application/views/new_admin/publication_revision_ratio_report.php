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

	<div class="page-content">
		<div class="container">
		    <div class="portlet light margin-bottom-5">
		        <div class="portlet-title">
            		<div class="caption">
            			<label>Publication Revision Ratio Report : <?php if(isset($from) && isset($to)){ $from1 = strtotime($from); $to1 = strtotime($to); echo "<b>".date('M d, Y', $from1)."</b> to <b>".date('M d, Y', $to1)."</b>" ;} ?></label>
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
                                        <div class="col-md-6 col-lg-6">
                                            <div>
                                                <label class="inline version"><input type="radio" name="version" value="V1" checked <?php if(isset($_GET['version']) && $_GET['version'] == 'V1') echo 'checked'; ?>>V1-V1a</label>
                                                <label class="inline version"><input type="radio" name="version" value="V1a" <?php if(isset($_GET['version']) && $_GET['version'] == 'V1a') echo 'checked'; ?>>V1a-V1b</label>
                                                <label class="inline version"><input type="radio" name="version" value="V1b" <?php if(isset($_GET['version']) && $_GET['version'] == 'V1b') echo 'checked'; ?>>V1b-V1c</label>
                                            </div>
                                            <!--<a href="<?php echo base_url().index_page().'new_designer/home/revision_ratio_report/V1';?>" 
                                            <?php if($version == 'V1') echo 'class="btn btn-success"'; else echo 'class="btn btn-primary"'; ?>>V1-V1a</a> 
                                            <a href="<?php echo base_url().index_page().'new_designer/home/revision_ratio_report/V1a';?>" 
                                            <?php if($version == 'V1a') echo 'class="btn btn-success"'; else echo 'class="btn btn-primary"'; ?>>V1a-V1b</a> 
                                            <a href="<?php echo base_url().index_page().'new_designer/home/revision_ratio_report/V1b';?>" 
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
        			</div>
        		</div>
        	
			<div class="row">		
			  <div class="col-md-12 margin-top-20">
				 <div class="table-responsive border padding-15">     
					<table class="table table-striped table-bordered" id="sample_6">
						<thead>
							<tr>
								<th>Publication</th>
								<th>New Ads</th>
								<th>Revisions</th>
								<th>Ratio (%)</th>
						   </tr>  									
						</thead>
						<tbody>
						    <?php 
						        if(isset($new_ad)){
						            $totalPublication = 0; $totalNewAdCount = 0; $totalRevisionAdCount = 0; $totalRatio = 0;
						            foreach($new_ad as $key => $value){
						                $pName = $value['name'];
						                $new_ad_count = $value['new_ad_count'];
						                $revision_ad_count = 0; 
						                $ratio = '-';
						                $key_search='';
						                $key_search = array_search($pName, array_column($revision_ad, 'name'));
                                        if($key_search !== false){
                                           $revision_ad_count = $revision_ad[$key_search]['rev_ad_count'] ;
                                        }
                                        
                                        if($revision_ad_count > 0) $ratio = round(($revision_ad_count / $new_ad_count) * 100, 2); 
                                        
                                        $totalPublication++;
                                        $totalNewAdCount = $totalNewAdCount + $new_ad_count;
                                        $totalRevisionAdCount = $totalRevisionAdCount + $revision_ad_count;
						    ?>
						    <tr>
						        <td><?php echo $pName; ?></td>
						        <td><?php echo $new_ad_count; ?></td>
						        <td><?php echo $revision_ad_count; ?></td>
						        <td><?php echo $ratio; ?></td>
						    </tr>
						    <?php 
						           } 
						            if($totalRevisionAdCount > 0) $totalRatio = round(($totalRevisionAdCount / $totalNewAdCount) * 100, 2);
						    ?>
						        <tfoot>
                    			    <tr style="color: #e14e6a;">
                        			    <td><?php echo '<b>'.$totalPublication.'</br>'; ?></td> 
                        			    <td><?php echo '<b>'.$totalNewAdCount.'</br>'; ?></td> 
                        			    <td><?php echo '<b>'.$totalRevisionAdCount.'</br>'; ?></td>
                        			    <td><?php echo '<b>'.$totalRatio.'</br>'; ?></td> 
                        			</tr>
                        		</tfoot>
						    
						    <?php } ?>
						</tbody>     
					</table>
				 </div>
			 </div>
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
         
        //load table data
     
       
    });
</script>

<?php $this->load->view('new_admin/footer')?>
<?php $this->load->view("new_admin/datatable"); ?>