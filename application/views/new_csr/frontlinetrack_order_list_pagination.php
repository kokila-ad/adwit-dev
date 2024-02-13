<?php $this->load->view("new_csr/head.php"); ?>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"/>    
<style>
.btnRadio{
    margin-right: 10px;
}
.tabletools-btn-group {
		display: none !important;
}
.word-wrap-name,a.word-wrap-name{
	max-width: 250px;
	word-wrap: break-word;
	display: block;
}
div.radio {
 display: none;
}

/*table {
  table-layout:fixed;
}
.word-wrap-name{
  word-wrap: break-word;
  max-width: 150px;
}
#revision_table td {
  white-space:inherit;
}*/
</style>
<script>
    function sluf_confirm123(){    
	    var X=confirm('Confirm To Proof Check!!');	
	    if(X==true){ return true; }else{ return false; }
	} 

    setTimeout(function(){
      var selected_date = $('input[name="date"]:checked').val();
       localStorage.setItem('selected_date',selected_date);
	  var selected_display = $('#display_type').val();
	   localStorage.setItem('selected_display',selected_display);
	   localStorage.setItem('go_back_tab',"revision");
      window.location.reload(1);
    }, 250000);
    

</script>

<script>
   function Refresh() {
        window.parent.location = window.parent.location.href;
		<?php 
				$current_time = date("H:i:s"); 
		?>
    }
</script>
<script type="text/javascript">
/*	$(document).ready(function(e) {
        $('.dateClass').change(function(e) {
            $(this).closest("form").submit();
        });
        
        $('#display_type').change(function(e) {
            $(this).closest("form").submit();
        });
    });*/
    
    function getOrderList(order_type){
	  var order_type = order_type;
	  var no_of_order = $("#no_of_order").val();
	  var selected_date = $('input[name="date"]:checked').val();
	  var display_type = "<?php echo $display_type ?>";
	  var dataString = "no_of_order="+no_of_order+"&order_type="+order_type+"&selected_date="+selected_date;
        // console.log(dataString);
    	$.ajax({
    		url: "<?php echo base_url().index_page().'new_csr/home/frontlinetrack_order_list/';?>"+order_type,
    		type: 'POST',
    		data: dataString,
            success: function(response) {
                // Redirect the user to the new location 
                window.location.href = "<?php echo base_url() . index_page() . 'new_csr/home/frontlinetrack_order_list/'; ?>"+order_type+"?date="+selected_date+"&display_type="+display_type;
            },
            error: function() {
                alert('Something went wrong!!');
            }
        }); 
        
	}

	function reset_rev_search(help_desk_id){
    	$.ajax({
        type: 'POST',
    	url: "<?php echo base_url().index_page().'new_csr/home/reset_rev_search';?>",
        success: function(response) {
            // Redirect the user to the new location
            window.location.href = "<?php echo base_url() . index_page() . 'new_csr/home/frontlinetrack_order_list/'; ?>"+help_desk_id;
        },
        error: function() {
            alert('Something went wrong!!');
        }
        });
	}
	
	function getRushOrderList(order_type){
	  var order_type = order_type;
	  var no_of_order = $("#rush_no_of_order").val();
	  var dataString = "no_of_order="+no_of_order+"&order_type="+order_type;
    	$.ajax({
    		url: "<?php echo base_url().index_page().'new_csr/home/frontlinetrack_order_list/';?>"+order_type,
    		type: 'POST',
    		data: dataString,
            success: function(response) {
                // Redirect the user to the new location
                window.location.href = "<?php echo base_url() . index_page() . 'new_csr/home/frontlinetrack_order_list/'; ?>"+order_type;
            },
            error: function() {
                alert('Something went wrong!!');
            }
        }); 
        
	}
	function reset_rush_search(help_desk_id){
    	$.ajax({
        type: 'POST',
    	url: "<?php echo base_url().index_page().'new_csr/home/reset_rush_search';?>",
        success: function(response) {
            // Redirect the user to the new location
            window.location.href = "<?php echo base_url() . index_page() . 'new_csr/home/frontlinetrack_order_list/'; ?>"+help_desk_id;
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
	    $("#revision_excel_form").submit();
	    
	}
	
	function confirm_qa(help_desk,order_id){
      $("#selected_help_desk").val(help_desk);
      $("#selected_order_id").val(order_id);
      $("#proofConfirmationModal").modal("show"); 
    }
    
    var base_url = "<?php echo base_url(); ?>";
    var index_page = "<?php echo index_page(); ?>";
    
    function confirm(){
        help_desk = $("#selected_help_desk").val();
        order_id = $("#selected_order_id").val();
        var form = document.getElementById("proof_check_form");
        // Append the input element to the "proof_check_div"
        var submitInput = '<input type="text" name="proof_check">';
        $('#proof_check_div').append(submitInput);
         form.action = base_url + index_page + 'new_csr/home/orderview/' + help_desk + '/' + order_id;
        // Close the modal
        $('#proofConfirmationModal').modal('hide');
        // Submit the form
        form.submit();
    }
       
</script>
<!--
<script type="text/javascript">
	$(document).ready(function(e) {
        $('#help_desk').change(function(e) {
            window.location = "<?php echo base_url().index_page().'new_csr/home/frontlinetrack_all/';?>" + $('#help_desk').val() ;
        });
    });
</script>

<script type="text/javascript">
	$(document).ready(function(e) {
        $('#display_type').change(function(e) {
		
            window.location = "<?php echo base_url().index_page().'new_csr/home/frontlinetrack_';?>" + $('#display_type').val() + "<?php echo '/'.$help_desk_id; ?>" ;
        });
    });
</script>
-->
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
									<?php  $type = $this->db->get_where('help_desk',array('active'=>'1','id'=> $help_desk_id))->row_array(); ?>
									<a class="navbar-brand" href="javascript:;"> <?php echo $type['name']; ?> </a>
									<a class="navbar-brand" href="javascript:;"><?php echo $this->session->flashdata('sold_status');?></a>
									
									
								</div>
								<!-- Collect the nav links, forms, and other content for toggling -->
								<div class="collapse navbar-collapse navbar-ex1-collapse">
									<ul class="nav navbar-nav navbar-right">
									<?php if($help_desk_id=='2'){ ?>
									<li class="margin-top-10">
									   <form class="search-form"  name="form" method="get" action="<?php echo base_url().index_page()."new_csr/home/metro_revision/".$help_desk_id; ?>">
											<div class="col-sm-8"  style="padding: 0;">
												<input type="text" class="form-control" placeholder="Metro Order Search" name="orderId" required>
												<!--<input name="form" value="<?php echo $help_desk_id;?>" readonly style="display:none;" />-->
											</div>
											<div class="col-sm-4"  style="padding: 0;">
												<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
											</div>		
									   </form>
									</li>
									 <?php } ?>
									
									<?php if($help_desk_id=='12'){ ?>
										<li>
											<a onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/vidn_rev_entries';?>'" href="javascript:;">
											Vidn Entries </a>
										</li>
									<?php } ?>
									<?php $help_desk1 = $this->db->query("SELECT * FROM `help_desk` WHERE `id` = '$help_desk_id' AND `sold` = '1'")->result_array();
									if($help_desk1) { ?>
									<li>
										<a href="<?php echo base_url().index_page().'new_csr/home/sold_track/'.$help_desk_id;?>" target="_blank" href="javascript:;">				
										Sold Orders</a>								
									</li><?php } ?>
									<li>
										<a href="<?php echo base_url().index_page().'new_csr/home/revision/'.$help_desk_id;?>" target="_blank" href="javascript:;">				
										Create Revision</a>								
									</li>
									
									<?php 
									    if(isset($rev_classification) && $help_desk_id == '10'){ 
									        foreach($rev_classification as $classification){ ?>
									<li>
										<a href="<?php echo base_url().index_page().'new_csr/home/frontlinetrack_all/'.$help_desk_id.'/'.$display_type.'/'.$classification['id'];?>" href="javascript:;">				
										<?php echo $classification['name']; ?></a>								
									</li>
									<?php 
									        } 
									    } 
									?>
										<li class="dropdown">
											<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
											Select Desk &nbsp;<i class="fa fa-angle-down"></i>
											</a>
											<ul class="dropdown-menu">
											<?php 
											    $types = $this->db->get_where('help_desk',array('active'=>'1'))->result_array();
											    foreach($types as $type){
				                            ?>
				                            	<li>
													<a href="<?php echo base_url().index_page().'new_csr/home/frontlinetrack_order_list/';?><?php echo $type['id']; ?>">
													<?php echo $type['name']; ?> </a>
												</li>
											<?php } ?>
											</ul>
										</li>
										
									</ul>
								</div>
								<!-- /.navbar-collapse -->
							</div>
        </div>
        </div>
		
        <div class="row">
            <div class="col-md-12">
		<?php echo '<span style="color:#900;">'.$this->session->flashdata('message').'</span>'; ?>
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption margin-right-10">
								<i class="fa fa-cogs font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold uppercase" id="selected_d_type"><?php if(isset($display_type)) echo $display_type; ?></span>
							</div> 
							<div class="caption">
    							<form method="get">
    								<!--<input type="submit" name="date" <?php if(isset($date) && $date == $qystday) echo'class="btn btn-xs blue"'; else echo'class="btn btn-xs green"'; ?> value="<?php echo $qystday; ?>" /> 
    								<input type="submit" name="date" <?php if(isset($date) && $date == $pystday) echo'class="btn btn-xs blue"'; else echo'class="btn btn-xs green"'; ?> value="<?php echo $pystday; ?>" /> 
    								<input type="submit" name="date" <?php if(isset($date) && $date == $ystday) echo'class="btn btn-xs blue"'; else echo'class="btn btn-xs green"'; ?> value="<?php echo $ystday; ?>" /> 
    								<input type="submit" name="date" <?php if(isset($date) && $date == $today) echo'class="btn btn-xs blue"'; else echo'class="btn btn-xs green"'; ?> value="<?php echo $today; ?>" /> 
    							-->
    							    <div class="btn-group" data-toggle="buttons" style="float:left">
                                          <label <?php if(isset($date) && $date == $qystday) echo'class="btn btn-xs btnRadio blue"'; else echo'class="btn btn-xs btnRadio green"'; ?> >
                                              <input type="radio" name="date" value="<?php echo $qystday; ?>" class="dateClass" <?php if(isset($date) && $date == $qystday) echo'checked'; ?>/> 
                                              <?php echo $qystday; ?>
                                          </label>
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
                                          <label <?php if(isset($date) && $date == 'rush') echo'class="btn btn-xs btnRadio blue"'; else echo'class="btn btn-xs btnRadio green"'; ?> >
                                              <input type="radio" name="date" value="rush" class="dateClass" <?php if(isset($date) && $date == 'rush') echo'checked'; ?>/> 
                                              Rush
                                          </label>
                                           <label <?php if(isset($date) && $date == 'question') echo'class="btn btn-xs btnRadio blue"'; else echo'class="btn btn-xs btnRadio green"'; ?> >
                                              <input type="radio" name="date" value="question" class="dateClass" <?php if(isset($date) && $date == 'question') echo'checked'; ?>/> 
                                              Question
                                          </label>
                                    </div>
                                    <select name="display_type" id="display_type" class="select2-container form-control input-xsmall input-inline" style="float:left">
                                        <!--<option value="all" <?php if($display_type == 'all') echo "selected"; ?>>All</option>-->
                                        <option value="pending" <?php if($display_type == 'pending') echo "selected"; ?>>Pending</option>
                                        <option value="sent" <?php if($display_type == 'sent' ) echo "selected"; ?>>Sent</option>
                                        <option value="QA" <?php if($display_type == 'QA' ) echo "selected"; ?>>QA</option>
                                    </select>
    							</form>
							</div>
							<div class="tools">
							     <!--<form method="post" id="revision_excel_form" action="<?php echo base_url().index_page().'new_csr/home/getRevisionAdsExcel'?>">
							        <input style="display:none;" name="selected_date" id="selected_date">   
							        <input style="display:none;" name="selected_display_type" id="selected_display_type">   
							        <input style="display:none;" name="selected_help_desk" id="selected_help_desk" value="<?php echo $help_desk_id;?>">   
            				        <button type="button" onclick="getSelectedDate()" class="btn bg-grey btn-sm"><i class="fa fa-file-excel-o"></i> Excel</button>
            				    </form>-->
								<button class="btn bg-grey btn-sm" onclick="tableToExcel('revision_table', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Excel</button>
								<!--<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()"></a>-->
							</div>
						</div>
						<div class="portlet-body">
				            <div class="portlet-title">
            				<div class="caption">
            					<span class="caption-subject font-green-sharp bold" id="caption"></span>
            				</div>
            				<div class="tools">
            				<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()"></a>
            				</div>
            			</div>
            			<div class="portlet-body">
            				<table class="table table-striped table-bordered table-hover" id="revision_table">
            				    <thead></thead>
            				</table>
            			</div>
                        </div>
                 </div>
            </div>
        </div>

  </div>
  </div>
  </div>
  <!-- Modal starts here-->
    <div class="modal fade" id="proofConfirmationModal" tabindex="-1"  data-backdrop="static" role="dialog" aria-labelledby="confirmationModalTitle" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="width:85%">
          <div class="modal-header  portlet blue-hoki box" style="border-bottom: 0 !important;">
            <h5 class="modal-title portlet-title margin-top-10" id="confirmationModalTitle" style="margin-top: 0px !important; padding:10px !important;"><center><b></b></center></h5>
          </div>
          <div class="modal-body">
           <center>Confirm To Proof Check!!</center>
          </div>
          <input style="display:none"  id="selected_help_desk" name="selected_help_desk">
          <input style="display:none" id="selected_order_id" name="selected_order_id">
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" onclick="confirm()">Ok</button>
          </div>
        </div>
      </div>
    </div>
<!-- Modal ends here-->
 <?php $this->load->view("new_csr/foot.php"); ?> 

<script>
    function deleteItem(revId) {
        // alert(revId);
        if (confirm("Are you sure?")) {
            // your deletion code
            $.ajax({
              url: '<?php echo base_url().index_page();?>new_csr/home/revision_order_deletion',
              data:'rev_id='+revId,
              type: 'POST',
              success: function(data) {
                alert(data);
                location.reload();
              }
            });
        }
        return false;
    } 
    
    $(document).ready(function () {
    // Function to initialize or reinitialize DataTable
    function initializeDataTable() {
        localStorage.setItem('go_back_tab',"revision");
        
        if(localStorage.getItem('selected_date') != null){
            var date  = localStorage.getItem('selected_date');
            $('input:radio[name=date]').val([date]);
             $('label.btnRadio').removeClass('blue active').addClass('green');
             $('label.btnRadio:has(input:radio[name="date"][value="' + date + '"])').removeClass('green').addClass('blue active');
        }/*else if(localStorage.getItem('date') != null){
             var date  = localStorage.getItem('date');
            $('input:radio[name=date]').val([date]);
             $('label.btnRadio').removeClass('blue active').addClass('green');
             $('label.btnRadio:has(input:radio[name="date"][value="' + date + '"])').removeClass('green').addClass('blue active');
        }*/else{
           var date = $('input[name="date"]:checked').val(); 
           localStorage.setItem('selected_date',date);
        }
        // $('input:radio[name=date]').val([date]);
        console.log(date);
        console.log(localStorage.getItem('selected_date'));
        console.log(localStorage.getItem('date'));
       
        if(localStorage.getItem('selected_display') != null){
            var display_type  = localStorage.getItem('selected_display');
            $("#display_type").val(display_type);
        }/*else if(localStorage.getItem('display_type') != null){
            var display_type  = localStorage.getItem('display_type');
            $("#display_type").val(display_type);
        }*/else{
          var display_type = $('#display_type').val();
          localStorage.setItem('selected_display',display_type);
        }
        
        $("#selected_d_type").html(display_type);
        var helpdesk_id = "<?php echo $help_desk_id?>";
        var session_id = "<?php echo $this->session->userdata('sId');?>";
        // Check if DataTable is already initialized
        if ($.fn.DataTable.isDataTable('#revision_table')) { 
            $('#revision_table').DataTable().destroy();
        }
      /*  localStorage.setItem('go_back_tab',"revision");
        localStorage.setItem('display_type',display_type);
        localStorage.setItem('date',date);
        */
         $.ajax({
             url:"<?php echo base_url().index_page().'new_csr/home/frontlinetrack_order_list_pagination_columns/'; ?>"+date, 
    		//cache: false,
    		success: function(data){
    		     $('#revision_table').empty();
    		    columnNames = JSON.parse(data);
                 var columns = [];               
                    for (var i in columnNames) {
                        columns.push({title:columnNames[i]});
                    }
                     var dataTable = $('#revision_table').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "order": [],
                        "ajax": {
                            url: "<?php echo base_url().index_page().'new_csr/home/frontlinetrack_order_list_pagination_details/'; ?>" + helpdesk_id,
                            type: "GET",
                            data: {"date": date, "display_type": display_type, "action": 'completed'}
                        },
                         'columnDefs': [ {
                            'targets': [], 
                            'orderable': false, 
                         }],
                        "columns": columns,
                        createdRow: function (row, data, index) {
                            if (data[0] == "1") {
                                $(row).addClass('bg-red-pink');
                            }
                        },
                       "pageLength": 25,
                       "bDestroy": true
                    });
                    dataTable.column(0).visible(false);
    		}

         });
      
    
    }

    // Call the function on document ready
    initializeDataTable();

      $('.dateClass').change(function () {
         localStorage.removeItem('selected_date');
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
            localStorage.removeItem('selected_display');
            initializeDataTable();

        });
    });
    

</script>