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
      var selected_date = $('input[name="date"]:checked').val();
       localStorage.setItem('d_selected_date',selected_date);
	  var selected_display = $('#display_type').val();
	   localStorage.setItem('d_selected_display',selected_display);
       window.location.reload(1);
    }, 250000);  
 
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
    //if(isset($help_desk_id)):
 ?>
            <div class="row">
                <div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
							    <form method="get">
    								<span class="caption-subject font-green-sharp bold uppercase">Revision Ads</span>
    								
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
                                        <!--<option value="all" <?php if($display_type == 'all') echo "selected"; ?>>All</option>-->
                                        <option value="pending" <?php if($display_type == 'pending') echo "selected"; ?>>Pending</option>
                                        <option value="sent" <?php if($display_type == 'sent') echo "selected"; ?>>Sent</option>
                                        <option value="myQ" <?php if($display_type == 'myQ') echo "selected"; ?>>My Q</option>
                                    </select>
    							</form>
							</div>
							<div class="tools">
							    
    							<!--<button class="btn bg-grey btn-sm" onclick="tableToExcel('revision_tbl', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Excel</button>-->
    							
    							<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()"></a>
							</div>
						</div>
						
						<div class="portlet-body">
				            <table class="table table-striped table-bordered table-hover" id="revision_tbl">
							  <thead>
    							 <tr>
    							    <th></th>
    							    <!--<th>No</th>-->
    								<th >Order Id</th>
    								<th>Type</th>
    								<th>Previous Slug</th>
    								<th>Designer</th>
    								<!--<th>Classification</th>-->
    								<th>Status</th>
    							 </tr>
							  </thead>
							 
							</table>
						</div>
						
					</div>
			    </div>
            </div>
		<?php  //endif; ?>
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

$(document).ready(function () {
    // Function to initialize or reinitialize DataTable
    function initializeDataTable() { 
        if(localStorage.getItem('d_selected_date') != null){
            var date  = localStorage.getItem('d_selected_date');
            $('input:radio[name=date]').val([date]);
             $('label.btnRadio').removeClass('blue active').addClass('green');
             $('label.btnRadio:has(input:radio[name="date"][value="' + date + '"])').removeClass('green').addClass('blue active');
        }else{
           var date = $('input[name="date"]:checked').val(); 
         
        }
        if(localStorage.getItem('d_selected_display') != null){
            var display_type  = localStorage.getItem('d_selected_display');
            $("#display_type").val(display_type);
        }else{
          var display_type = $('#display_type').val();
         
        }
        
        var helpdesk_id = "<?php echo $help_desk_id?>";
        // Check if DataTable is already initialized
        if ($.fn.DataTable.isDataTable('#revision_tbl')) {
            // If yes, destroy the existing DataTable
            $('#revision_tbl').DataTable().destroy();
        }

        // Initialize DataTable
       var dataTable =  $('#revision_tbl').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "<?php echo base_url().index_page().'new_designer/home/pg_frontlinetrack_order_list/'; ?>" + helpdesk_id,
                type: "GET",
                data: {"date": date, "display_type": display_type, "action": 'completed'}
            },
             'columnDefs': [ {
                'targets': [], /* column index */
                'orderable': false, /* true or false */
             }],
             createdRow: function (row, data, index) {
                if (data[0] == "1") {
                    $(row).addClass('bg-red-pink');
                }
            },
           "pageLength": 25,
        });
        dataTable.column(0).visible(false); 
    }

    // Call the function on document ready
    initializeDataTable();

  $('.dateClass').change(function () {
      localStorage.removeItem('d_selected_date');
    // Get the selected date value
    var selectedDateValue = $('input[name="date"]:checked').val();
    // Call the function when date class changes
    initializeDataTable();
    // Remove the 'blue active' class from all labels wrapping radio buttons
    $('label.btnRadio').removeClass('blue active').addClass('green');

    // Add the 'blue active' class to the label wrapping the radio button corresponding to the selected date
    $('label.btnRadio:has(input:radio[name="date"][value="' + selectedDateValue + '"])').removeClass('green').addClass('blue active');

});

 $('#display_type').change(function(e) {
        localStorage.removeItem('d_selected_display');
        initializeDataTable();
    });
});

   
</script>