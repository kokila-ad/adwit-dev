<?php
       $this->load->view("new_designer/head"); 
?>
<!-- END HEADER -->
<style>
    div.radio {
     display: none;
    }
    .btnRadio{
        margin-right: 10px;
    }
</style>
<script>
    setTimeout(function(){
       window.location.reload(1);
    }, 50000);
</script>
<script type="text/javascript">
	$(document).ready(function(e) {
        $('.dateClass').change(function(e) {
            $(this).closest("form").submit();
        });
        
        $('#display_type').change(function(e) {
            $(this).closest("form").submit();
        });
    });
  /*  
    function getDesignerOrderList(order_type){
	  var order_type = order_type;
	  var no_of_order = $("#no_of_order").val();
	  var display_type  = "<?php echo $display_type?>";
	  var selected_date = $('input[name="date"]:checked').val();
	  var dataString = "no_of_order="+no_of_order+"&order_type="+order_type;

    	$.ajax({
    		url: "<?php echo base_url().index_page().'new_designer/home/frontlinetrack_order_list/';?>"+order_type,
    		type: 'POST',
    		data: dataString,
            success: function(response) {
                // Redirect the user to the new location
                // window.location.href = "<?php echo base_url() . index_page() . 'new_designer/home/frontlinetrack_order_list/'; ?>"+order_type;
                 window.location.href = "<?php echo base_url() . index_page() . 'new_designer/home/frontlinetrack_order_list/'; ?>"+order_type+"?date="+selected_date+"&display_type="+display_type;
            },
            error: function() {
                alert('Something went wrong!!');
            }
        }); 
        
	}

	function reset_rev_search_designer(help_desk_id){
    	$.ajax({
        type: 'POST',
    	url: "<?php echo base_url().index_page().'new_designer/home/reset_designer_rev_search';?>",
        success: function(response) {
            // sessionStorage.removeItem('r_columnIndex');
            // sessionStorage.removeItem('r_sort_by');
            // var dataTable = $('#revision_tbl').DataTable();
            // dataTable.state.clear(); // Clear the saved state
            // dataTable.draw(); // Redraw the DataTable
            // Redirect the user to the new location
            window.location.href = "<?php echo base_url() . index_page() . 'new_designer/home/frontlinetrack_order_list/'; ?>"+help_desk_id;
        },
        error: function() {
            alert('Something went wrong!!');
        }
        });
	}
	function getSelectedDate(){
	    var selected_date = $('input[name="date"]:checked').val();
	    var display_type = $('#display_type').val();
	    //selected_date
	    $("#selected_date").val(selected_date);
	    $("#selected_display_type").val(display_type);
	    $("#designer_revision_excel_form").submit();
	    
	}*/

	
</script>
<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
		<div class="container">
           <div class="row">
              <div class="col-lg-12">
                <div class="navbar navbar-default" role="navigation">
								<!-- Brand and toggle get grouped for better mobile display -->
								<div class="navbar-header">
									<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
									<span class="sr-only">
									Toggle navigation </span>
									<span class="icon-bar">
									</span>
									<span class="icon-bar">
									</span>
									<span class="icon-bar">
									</span>
									</button>
									<?php if(isset($help_desk_id)) $types = $this->db->get_where('help_desk',array('id'=>$help_desk_id))->result_array(); ?>
									<a class="navbar-brand" href="javascript:;">
									<?php if(isset($help_desk_id)) echo $types[0]['name']; ?></a>
								</div>
								<!-- Collect the nav links, forms, and other content for toggling -->
								
								<div class="collapse navbar-collapse navbar-ex1-collapse">
								<?php if(!isset($help_desk_id_demo)) { ?>
									<ul class="nav navbar-nav navbar-right">
									<!--<li><a href="<?php echo base_url().index_page().'new_designer/home/revision'; ?>">REV/SOLD</a></li>-->
										<li class="dropdown">
											<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
											Select Group &nbsp;<i class="fa fa-angle-down"></i>
											</a>
											<ul class="dropdown-menu">
                                			<?php
                                			    $types = $this->db->get_where('help_desk',array('active'=>'1'))->result_array();
                                				foreach($types as $type){ 
                                			?>
												<li>
													<a href="<?php echo base_url().index_page().'new_designer/home/frontlinetrack_order_list/'.$type['id'];?>">
													<?php echo $type['name']; ?> </a>
												</li>
			                                <?php } ?>									
											</ul>
										</li>
									</ul>
								<?php } ?>			
								</div>
								<!-- /.navbar-collapse -->
		        </div>
	          </div>
           </div>
 <?php 
	echo '<h5 style="color:#900;">'.$this->session->flashdata('message').'</h5>';
    if(isset($help_desk_id)):
 ?>
            <div class="row">
                <div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
							    <form method="get">
    								<span class="caption-subject font-green-sharp bold uppercase">Revision Ads</span>
    								<!--
									<input type="submit" name="pday" value="<?php echo $pystday; ?>" class="btn btn-xs green"/>
									<input type="submit" name="yday" value="<?php echo $ystday; ?>" class="btn btn-xs green"/>
									<input type="submit" name="today" value="<?php echo $today; ?>" class="btn btn-xs green"/>
									-->
    							    <div class="btn-group" data-toggle="buttons">
                                          <!--<label <?php if(isset($date) && $date == $qystday) echo'class="btn btn-xs btnRadio blue"'; else echo'class="btn btn-xs btnRadio green"'; ?> >
                                              <input type="radio" name="date" value="<?php echo $qystday; ?>" class="dateClass" <?php if(isset($date) && $date == $qystday) echo'checked'; ?>/> 
                                              <?php echo $qystday; ?>
                                          </label>-->
                                          <label <?php if(isset($date) && $date == $pystday) echo'class="btn btn-xs btnRadio blue"'; else echo'class="btn btn-xs btnRadio green"'; ?> >
                                              <input type="radio" name="date" value="<?php echo $pystday; ?>" class="dateClass" <?php if(isset($date) && $date == $pystday) echo'checked'; ?>/> 
                                              <?php echo $pystday; ?>
                                          </label>
                                          <label <?php if(isset($date) && $date == $ystday) echo'class="btn btn-xs btnRadio blue"'; else echo'class="btn btn-xs btnRadio green"'; ?> >
                                              <input type="radio" name="date" value="<?php echo $ystday; ?>" class="dateClass" <?php if(isset($date) && $date == $ystday) echo'checked'; ?>/> 
                                              <?php echo $ystday; ?>
                                          </label>
                                          <label <?php if(isset($date) && $date == $today) echo'class="btn btn-xs btnRadio blue"'; else echo'class="btn btn-xs btnRadio green"'; ?> >
                                              <input type="radio" name="date" value="<?php echo $today; ?>" class="dateClass" <?php if(isset($date) && $date == $today) echo'checked'; ?>/> 
                                              <?php echo $today; ?>
                                          </label>
                                    </div>
                                    <select name="display_type" id="display_type" class="select2-container form-control input-xsmall input-inline">
                                        <option value="all" <?php if($display_type == 'all') echo "selected"; ?>>All</option>
                                        <option value="pending" <?php if($display_type == 'pending') echo "selected"; ?>>Pending</option>
                                        <option value="sent" <?php if($display_type == 'sent') echo "selected"; ?>>Sent</option>
                                        <option value="myQ" <?php if($display_type == 'myQ') echo "selected"; ?>>My Q</option>
                                    </select>
    							</form>
							</div>
							<div class="tools">
							     <form method="post" id="designer_revision_excel_form" action="<?php echo base_url().index_page().'new_designer/home/getDesignerRevisionAdsExcel'?>">
							        <input style="display:none;" name="selected_date" id="selected_date">   
							        <input style="display:none;" name="selected_display_type" id="selected_display_type">   
							        <input style="display:none;" name="selected_help_desk" id="selected_help_desk" value="<?php echo $help_desk_id;?>">   
            				        <button type="button" onclick="getSelectedDate()" class="btn bg-grey btn-sm"><i class="fa fa-file-excel-o"></i> Excel</button>
            				    </form>
    							<!--<button class="btn bg-grey btn-sm" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Excel</button>-->
    							
    							<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()"></a>
							</div>
						</div>
						
						<div class="portlet-body">
						    <!-- search form starts here-->
        			    <form action="<?php echo base_url().index_page().'new_designer/home/frontlinetrack_order_list/' .$help_desk_id?>" method="get">
            				<div class="form-group row">
            				<div class="col-sm-6">
            				    <div class="col-sm-3">
            				        <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="no_of_order" id="no_of_order" onchange="getDesignerOrderList(<?php echo $help_desk_id?>)">
                                      <option selected value="">select</option>
                                      <option value="10" <?php if($this->session->userdata('rev_no_of_order_des') == '10'){echo 'selected';}?> >10</option>
                                      <option value="25" <?php if($this->session->userdata('rev_no_of_order_des') == '25'){echo 'selected';}?> >25</option>
                                      <option value="50" <?php if($this->session->userdata('rev_no_of_order_des') == '50'){echo 'selected';}?> >50</option>
                                      <option value="100" <?php if($this->session->userdata('rev_no_of_order_des') == '100'){echo 'selected';}?>>100</option>
                                    </select>
            				    </div>
            				   	<input style="display:none;"  name="ad_order_type" id="ad_order_type" value="not_rush">
            				</div>
            					<div class="col-sm-3">
            						<input type="text" id="rev_order_search_designer" name="rev_order_search_designer" value="<?php if($this->session->userdata("rev_search_designer_val") !== "" ){echo $this->session->userdata("rev_search_designer_val");}?>" placeholder="Search here" class="form-control">
            					</div>
            					<div class="col-sm-1">
            						<input type="submit" value="Search" class="btn btn-primary">
            					</div>
            					<div class="col-sm-1">
            						<button type="button" class="btn btn-warning" onclick="reset_rev_search_designer(<?php echo $help_desk_id?>)">Reset</button>
            					</div>
            				</div>
        			    </form>
        			    <!-- search form ends here-->
				            <table class="table table-striped table-bordered table-hover" id="revision_tbl">
							  <thead>
    							 <tr>
    								<th>No</th>
    								<th>Order Id</th>
    								<th>Type</th>
    								<th>Previous Slug</th>
    								<th>Designer</th>
    								<!--<th>Classification</th>-->
    								<th>Status</th>
    							 </tr>
							  </thead>
							<!--  <tbody name="testTable" id="testTable">
<?php
$i=0;
if(isset($rev_sold_jobs) && $rev_sold_jobs != false){
foreach($rev_sold_jobs as $row){ 
    $i--;
    $designer = $this->db->get_where('designers',array('id'=>$row['designer']))->row_array();
	if($row['classification']!='0'){ $rev_classification = $this->db->get_where('rev_classification',array('id' => $row['classification']))->row_array(); }
	$rev_status = $this->db->query("SELECT `name` FROM `rev_order_status` WHERE `id` = '".$row['status']."'")->row_array();
	
?>
            <tr <?php if($row['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="bg-red-pink"'; } ?>>
                 
                <td><?php echo $i; ?></td>
                
				<td><?php echo $row['order_id']; ?></td>
				
				<td>
					<span class="badge bg-blue"><?php if($row['order_type_id']=='2') {echo "P";} elseif($row['order_type_id']=='1'){ echo "W";}elseif($row['order_type_id']=='6'){ echo "P&G";} else{ echo "P&W";}?></span>
				</td>
				
				<td <?php if($row['rush']==1){ echo "class='font-grey-cararra'";} ?>>
				    <?php echo $row['order_no']; ?>
				</td>
				
				<?php if($row['new_slug']=='none') { ?>
    				<td>
        				<?php if($row['category'] == 'sold'){ ?>
            				<a href="<?php echo base_url().index_page().'new_designer/home/orderview/'.$help_desk_id.'/'.$row['order_id'];?>">
            					<input type="button" value="Upload" />
            				</a>
        				<?php }else{ ?>
            				<!--<form name="myform" method="post" onsubmit="return confirm('Do you really want to submit?');">
            					<button type="submit" name="create_slug" class="btn bg-green">Create Slug</button>
            					<input name="order_id" value="<?php echo $row['order_id'];?>" readonly style="display:none;" />
            				</form>-->
            				<form name="myform" id="create_slug_form_<?php echo $row['order_id']; ?>" method="post">
            					<button type="button"  onclick="showCreateSlugModal(<?php echo $row['order_id']; ?>)" class="btn bg-green">Create Slug</button>
            					<input name="order_id" value="<?php echo $row['order_id'];?>" readonly style="display:none;" />
            					<input type="text" name="create_slug" style="display:none;">
            				</form>
        				<?php } ?>
    				</td>
				<?php }else{ ?>
					<td>
        				<a <?php if($row['designer']!='0')?> href="<?php echo base_url().index_page().'new_designer/home/orderview/'.$help_desk_id.'/'.$row['order_id'];?>">
        				    <?php if(isset($designer['username'])) echo $designer['username'] ; else echo ''; ?>
        				</a>
    				</td>
    			<?php } ?>
			
				<!--<td><?php if($row['classification']!='0'){ echo $rev_classification['name']; } ?></td>-->
				
				<!--<td>
				    <a href="<?php echo base_url().index_page().'new_designer/home/orderview/'.$help_desk_id.'/'.$row['order_id'];?>" style="cursor:pointer; text-decoration: none;">
				        <?php   
				            if(isset($rev_status)){
				                if($row['status'] == '7') echo '<button class="btn text-danger btn-xs">'.$rev_status['name'].'</button>';
				                else echo '<button class="btn blue-sunglo btn-xs">'.$rev_status['name'].'</button>'; 
				            }else{ echo ''; }
				        ?>
				    </a>
				</td>
            </tr>
   <?php } } ?>
            </tbody>  -->
							</table>
						</div>
					</div>
			    </div>
            </div>
		<?php  endif; ?>
        </div>
	</div>
</div>
	<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->

<!-- Modal starts here-->
<div class="modal fade" id="slugConfirmationModal" tabindex="-1"  data-backdrop="static" role="dialog" aria-labelledby="confirmationModalTitle" aria-hidden="true">
 <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="width:85%">
      <div class="modal-header  portlet blue-hoki box" style="border-bottom: 0 !important;">
        <h5 class="modal-title portlet-title margin-top-10" id="confirmationModalTitle" style="margin-top: 0px !important; padding:10px !important;"><center><b>Alert</b></center></h5>
      </div>
      <input hidden type="text" id="selected_order_id">
      <div class="modal-body">
       Do you really want to submit ?
      </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" onclick="confirmSlugModal()">Ok</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal ends here-->

<!-- BEGIN FOOTER -->
<?php  $this->load->view("new_designer/foot"); ?>
<script>
     var table = $('#sample').DataTable({
        destroy: true,
        order: [[0, 'desc']],
        columnDefs: [
            { targets: 0, visible: false }  // hide the first column
        ],
        iDisplayLength: -1,
        // lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]]
        "paging": false, //Dont want paging 
		"bInfo": false, //Dont display info e.g. "Showing 1 to 4 of 4 entries"
		"bFilter": false
    });


    
 $(document).ready(function(){ 
     var dataTable = $('#revision_tbl').DataTable({  
           "processing":true,  
           "serverSide":true,  
           "order":[],  
           "ajax":{  
                url:"<?php echo base_url().index_page().'new_designer/home/pg_frontlinetrack_order_list/'; ?>",  
                type:"GET",
                //data:{"fromDate":fromDate, "toDate":toDate, "action":'completed'}
           },  
           "columnDefs":[  
                {  
                    // "targets":[],  
                    // "orderable":false, 
                    //hide the second column
                    'visible': false, 'targets': [0],

                },  
           ],  
        });	    
 });
     
     
</script>