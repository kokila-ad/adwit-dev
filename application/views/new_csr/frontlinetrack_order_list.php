<?php $this->load->view("new_csr/head.php"); ?>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"/>    
<style>
.btnRadio{
    margin-right: 10px;
}
.tabletools-btn-group {
		display: none !important;
}
.word-wrap-name{
	max-width: 250px;
	word-wrap: break-word;
}
div.radio {
 display: none;
}
</style>
<script>
    function sluf_confirm123(){    
	    var X=confirm('Confirm To Proof Check!!');	
	    if(X==true){ return true; }else{ return false; }
	} 
	
    /*setTimeout(function(){
       window.location.reload(1);
    }, 50000);*/
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
	$(document).ready(function(e) {
        $('.dateClass').change(function(e) {
            $(this).closest("form").submit();
        });
        
        $('#display_type').change(function(e) {
            $(this).closest("form").submit();
        });
    });
    
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
                // Redirect the user to the new location ?date=2023-12-07&display_type=all
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
    
    function confirm1(){
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
								<span class="caption-subject font-green-sharp bold uppercase"><?php if(isset($display_type)) echo $display_type; ?></span>
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
                                    </div>
                                    <select name="display_type" id="display_type" class="select2-container form-control input-xsmall input-inline" style="float:left">
                                        <option value="all" <?php if($display_type == 'all') echo "selected"; ?>>All</option>
                                        <option value="pending" <?php if($display_type == 'pending') echo "selected"; ?>>Pending</option>
                                        <option value="sent" <?php if($display_type == 'sent') echo "selected"; ?>>Sent</option>
                                        <option value="QA" <?php if($display_type == 'QA') echo "selected"; ?>>QA</option>
                                    </select>
    							</form>
							</div>
							<div class="tools">
							     <form method="post" id="revision_excel_form" action="<?php echo base_url().index_page().'new_csr/home/getRevisionAdsExcel'?>">
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
				<?php
					if($date == 'rush'){
				?>
			            <!-- rush search form starts here-->
        			    <form action="<?php echo base_url().index_page().'new_csr/home/frontlinetrack_order_list/' .$help_desk_id?>" method="get">
            				<div class="form-group row">
            				<div class="col-sm-6">
            				    <div class="col-sm-3">
            				        <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="rush_no_of_order" id="rush_no_of_order" onchange="getRushOrderList(<?php echo $help_desk_id?>)">
                                      <option selected value="">select</option>
                                      <option value="10" <?php if($this->session->userdata('rush_no_of_order') == '10'){echo 'selected';}?> >10</option>
                                      <option value="25" <?php if($this->session->userdata('rush_no_of_order') == '25'){echo 'selected';}?> >25</option>
                                      <option value="50" <?php if($this->session->userdata('rush_no_of_order') == '50'){echo 'selected';}?> >50</option>
                                      <option value="100" <?php if($this->session->userdata('rush_no_of_order') == '100'){echo 'selected';}?>>100</option>
                                    </select>
            				    </div>
            				   
            				</div>
            				<input style="display:none;"  name="ad_order_type" id="ad_order_type" value="rush">
            					<div class="col-sm-3">
            						<input type="text" id="rush_order_search" name="rush_order_search" value="<?php if($this->session->userdata("rush_search_val") !== "" ){echo $this->session->userdata("rush_search_val");}?>" placeholder="Search here" class="form-control">
            					</div>
            					<div class="col-sm-1">
            						<input type="submit" value="Search" class="btn btn-primary">
            					</div>
            					<div class="col-sm-1">
            						<button type="button" class="btn btn-warning" onclick="reset_rush_search(<?php echo $help_desk_id?>)">Reset</button>
            					</div>
            				</div>
        			    </form>
        			    <!-- rush search form ends here-->
						    <table class="table table-striped table-bordered table-hover" id="revision_table">
										<thead>											
										<tr>
										    <th style="display:none;"></th>
                							<th style="vertical-align: middle;">Date</th>
                							<th style="vertical-align: middle;">Type</th>
                							<th style="vertical-align: middle;">AdwitAds ID</th>
                							<th style="vertical-align: middle;">Unique Job Name</th>
                							<th style="vertical-align: middle;">Adrep</th>
                							<th style="vertical-align: middle;">Publication</th>
                							<th style="vertical-align: middle;">Click to</th>
                						</tr> 
										</thead> 
											
										<tbody name="testTable" id="testTable">	
                        <?php
                            
                            if(isset($rev_sold_jobs) && $rev_sold_jobs != false ){
                        	    foreach($rev_sold_jobs as $row){
                        	        $order_type = $this->db->get_where('orders_type',array('id' => $row['order_type_id']))->row_array();
                        	        $order_status = $this->db->get_where('order_status',array('id'=>$row['status']))->row_array();
                        ?>										
                							<tr class="bg-red-pink">
                							    <td style="display:none;"> </td>
                							    <td>
                							        <?php $date = strtotime($row['created_on']); echo date('d-M', $date); ?>
                							    </td>
                							    <td title="<?php echo $order_type['name']; ?>">
                                                    <span class="badge bg-blue">
                                                        <?php if($order_type['value']=='print') {echo "P";} elseif($order_type['value']=='web'){ echo "W";}elseif($order_type['value']=='pagination'){ echo "PG";}else{ echo "P&W";}?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php echo $row['id']; ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                        if($row['order_type_id'] == '6'){
                                                            echo $row['advertiser_name'].'/'.$row['job_no'];
                                                         }else{
                                                            echo $row['job_no'];
                                                         }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['Aname'];  ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['Pname'];  ?>
                                                </td>
                                                <td <?php if($row['question']=='1') { echo "class='danger'";} if($row['question']=='2') { echo "class='success '";} ?> title="OrderView">
                            						<a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/orderview/'.$row['help_desk'].'/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;">
                            						    <button class="btn blue btn-xs" ><?php echo $order_status['d_name']; ?></button>
                            						</a> 
                        						</td>
                							</tr>
                    <?php  } } ?>											
										</tbody>
									</table>
									<p><?php echo $rush_ad_links; ?></p>
			<?php
				}else{   
			?>
		                <!-- search form starts here-->
        			    <form action="<?php echo base_url().index_page().'new_csr/home/frontlinetrack_order_list/' .$help_desk_id?>" method="get">
            				<div class="form-group row">
            				<div class="col-sm-6">
            				    <div class="col-sm-3">
            				        <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="no_of_order" id="no_of_order" onchange="getOrderList(<?php echo $help_desk_id?>)">
                                      <option selected value="">select</option>
                                      <option value="10" <?php if($this->session->userdata('rev_no_of_order') == '10'){echo 'selected';}?> >10</option>
                                      <option value="25" <?php if($this->session->userdata('rev_no_of_order') == '25'){echo 'selected';}?> >25</option>
                                      <option value="50" <?php if($this->session->userdata('rev_no_of_order') == '50'){echo 'selected';}?> >50</option>
                                      <option value="100" <?php if($this->session->userdata('rev_no_of_order') == '100'){echo 'selected';}?>>100</option>
                                    </select>
            				    </div>
            				   	<input style="display:none;"  name="ad_order_type" id="ad_order_type" value="not_rush">
            				</div>
            					<div class="col-sm-3">
            						<input type="text" id="rev_order_search" name="rev_order_search" value="<?php if($this->session->userdata("rev_search_val") !== "" ){echo $this->session->userdata("rev_search_val");}?>" placeholder="Search here" class="form-control">
            					</div>
            					<div class="col-sm-1">
            						<input type="submit" value="Search" class="btn btn-primary">
            					</div>
            					<div class="col-sm-1">
            						<button type="button" class="btn btn-warning" onclick="reset_rev_search(<?php echo $help_desk_id?>)">Reset</button>
            					</div>
            				</div>
        			    </form>
        			    <!-- search form ends here-->
							<table class="table table-striped table-bordered table-hover" id="revision_table">
										<thead>											
										<tr>
											    <th>No.</th>
											    <th>Type</th>
												<th>Job No.</th>												
												<th>Revision</th> 										
												<th>Designer</th>
												<th>Time Left</th>
												<th>Time Sent</th>
												<th>Time Taken</th>
												<th>PDF</th>
												<th>Classification</th>
												
				<?php if($this->session->userdata('sId') == '68'){  echo '<th>Action</th>'; } ?>						
										</tr>
										</thead> 
											
										<tbody name="testTable" id="testTable">	
<?php
    $count = '0'; $cat_time = '0'; $timer = '0'; $i=0;
    //$hd_name = $this->db->get_where('help_desk',array('id' => $help_desk_id))->result_array();
if(isset($rev_sold_jobs) && $rev_sold_jobs != false){
	foreach($rev_sold_jobs as $row){
	    if($row['designer']!='0'){
			$designer = $this->db->get_where('designers',array('id' => $row['designer']))->result_array();
		}
		$count--; 
		$time_left = '0';
		//$count = sprintf('%03d',$count);
		$start = strtotime($row['time']);
		$end = strtotime($current_time);
		$time_left = $end - $start ; 
		$time_left = $time_left / 60;
		$time_left_rnd = round($time_left,0);
		$frontline_timer = $this->db->get('frontline_timer')->result_array();
		if($row['classification']!='0'){ $rev_classification = $this->db->get_where('rev_classification',array('id' => $row['classification']))->row_array(); }
		foreach($frontline_timer as $row1){
			if($row['category'] == $row1['cat_name']){ $cat_time = $row1['duration']; }
		}
?>										
							 <tr <?php if($row['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo 'class="bg-red-pink"'; } ?>>
										<td><?php echo $count ; ?></td>
		    	<!-- type -->			<td>
											<span class="badge bg-blue">
											    <?php if($row['order_type_id']=='2'){echo "P";} elseif($row['order_type_id']=='1'){ echo "W";} elseif($row['order_type_id']=='6'){ echo "PG";} else{ echo "P&W";}?>
											</span>
										</td>							
										<td class="word-wrap-name">
											<a <?php if($row['rush']==1){ echo "class='font-grey-cararra'";} ?> href="<?php echo base_url().index_page().'new_csr/home/orderview/'.$help_desk_id.'/'.$row['order_id'];?>">
												<?php echo $row['order_no']; ?>
											</a>
										</td>
										
										
										<td><?php if($row['category']=='revision'){ echo $row['time'];} ?></td>  
										
		
										
										<td><?php if($row['designer']!='0'){ echo $designer[0]['username']; } ?></td>
										
                                        <td><?php	
												if($row['status']=='5' || $row['status']=='8'){
													echo '';
												}elseif($time_left < $cat_time && $row['sent_time']=='00:00:00'){ 
													$timer = $cat_time - $time_left ;  
													if($timer<= '5'){
														echo "<font color='red'>". round($timer,0)." min </font>";
													}else{ echo round($timer,0)." mins"; }
												}else{ echo "Elapsed"; } 
											?>
										</td>
	<!--time sent -->						
										
										<td>
											<?php if($row['job_status']=='1'){ 
														if($row['question']=='1'){ 
															echo'<button>Question Sent</button>';
														}elseif($row['sent_time']!='00:00:00' && $row['status'] != '8'){ 
																//echo $row['sent_time'] ; ?>
																<a href="<?php echo base_url().index_page().'new_csr/home/orderview/'.$help_desk_id.'/'.$row['order_id'];?>">
																	<button type="button" id="accept" class="btn btn-sm btn-primary">Sent</button>
																</a>
															<?php }elseif($row['sent_time']!='00:00:00' && $row['status'] == '8'){ echo $row['sent_time'] ; ?>
														<?php }else{ ?>
															<!--<form method="post" enctype="multipart/form-data">-->
																	<?php if($row['sold_pdf'] != 'none' && $row['frontline_csr'] == '0' && $row['status'] == '8') { ?>
																	<button name="Submit" class="btn btn-sm btn-primary">Send</button>
																	<?php }elseif($row['sold_pdf'] != 'none' && $row['status'] == '4') { ?>
																	<button name="send_sold" class="btn btn-sm btn-primary">Send</button>
																	<?php }elseif($row['sold_pdf']=='none' && $row['status'] == '8'){ ?>
																		<div class="btn-group">
																		 <a href="<?php echo base_url().index_page().'new_csr/home/orderview/'.$help_desk_id.'/'.$row['order_id'];?>">
																			<button type="button" id="accept" class="btn btn-sm btn-primary">In Production</button>
																		 </a>
																		</div>
																	<?php }elseif($row['job_accept']=='0' && $row['order_id']!=''){ ?>
																		<div class="btn-group">
																		 <a href="<?php echo base_url().index_page().'new_csr/home/orderview/'.$help_desk_id.'/'.$row['order_id'];?>">
																			<button type="button" id="accept" class="btn btn-sm btn-primary">Accept</button>
																		 </a>
																		</div>
																	<?php 
																	    }elseif($row['source_file']!='none' && $row['status']=='4'){ 
																	        if($row['frontline_csr'] == '0'){
																	 ?>
																	           <!-- <form method="post" action="<?php echo base_url().index_page().'new_csr/home/orderview/'.$help_desk_id.'/'.$row['order_id'];?>"> 
                                                            						<button type="submit" name="revision_proof_check" class="btn btn-sm btn-warning" onclick="return sluf_confirm123()">In QA</button>
                                                            						<input type="text" name="revision_id" value="<?php echo $row['id']; ?>" style="display:none;">
                                                            					</form> -->
                                                            					 <form method="post" id="proof_check_form"> 
                                                            						<button type="button" name="revision_proof_check" class="btn btn-sm btn-warning" onclick="confirm_qa(<?php echo $help_desk_id;?>,<?php echo $row['order_id']; ?>)">In QA</button>
                                                            						<input type="text" name="revision_id" value="<?php echo $row['id']; ?>" style="display:none;">
                                                            						<div style="display:none" id="proof_check_div"></div>
    						
                                                            					</form> 
																	<?php   }else{ ?>
																	            <a href="<?php echo base_url().index_page().'new_csr/home/orderview/'.$help_desk_id.'/'.$row['order_id'];?>">
        																		    <button type="button" id="accept" class="btn btn-sm btn-warning">In QA</button>
        																		</a>    
																	 <?php } ?>
																	    
																		
																	<?php 
																	    }elseif($row['sold_pdf']!='none' && $row['status']=='4'){ 
																	        if($row['frontline_csr'] == '0'){
																	?>
																	           <!-- <form method="post" action="<?php echo base_url().index_page().'new_csr/home/orderview/'.$help_desk_id.'/'.$row['order_id'];?>"> 
                                                            						<button type="submit" name="revision_proof_check" class="btn btn-sm btn-warning" onclick="return sluf_confirm123()">In QA</button>
                                                            						<input type="text" name="revision_id" value="<?php echo $row['id']; ?>" style="display:none;">
                                                            					</form>--> 
                                                            					<form method="post" id="proof_check_form"> 
                                                            						<button type="button" name="revision_proof_check" class="btn btn-sm btn-warning" onclick="confirm_qa(<?php echo $help_desk_id;?>,<?php echo $row['order_id']; ?>)">In QA</button>
                                                            						<input type="text" name="revision_id" value="<?php echo $row['id']; ?>" style="display:none;">
                                                            						<div style="display:none" id="proof_check_div"></div>
                                                            					</form>
																	<?php   }else{ ?>
																	            <a href="<?php echo base_url().index_page().'new_csr/home/orderview/'.$help_desk_id.'/'.$row['order_id'];?>">
        																		    <button type="button" id="accept" class="btn btn-sm btn-primary">In QA</button>
        																		</a>    
																	 <?php } ?>
																	 
																	<?php }elseif($row['sold_pdf']!='none'&&$row['status']=='5'&&$row['new_slug']!='none'){ ?> 
																		<a href="<?php echo base_url().index_page().'new_csr/home/orderview/'.$help_desk_id.'/'.$row['order_id'];?>">
																		<button type="button" id="accept" class="btn btn-sm btn-primary">ProofReady</button>
																		</a>
																	<?php }elseif($row['new_slug']!='none'){ ?>
																		<a href="<?php echo base_url().index_page().'new_csr/home/orderview/'.$help_desk_id.'/'.$row['order_id'];?>">
																		<button type="button" id="accept" class="btn btn-sm btn-primary">In Production</button>
																		</a>
																	<?php }elseif($row['status']=='2'){ ?>
																		<a href="<?php echo base_url().index_page().'new_csr/home/orderview/'.$help_desk_id.'/'.$row['order_id'];?>">
																		<button type="button" id="accept" class="btn btn-sm btn-primary">Accepted</button>
																		</a>
																	<?php } ?>
																	<input name="id" value="<?php echo $row['id'];?>" readonly style="display:none;" />
																	<input name="new_slug" value="<?php echo $row['new_slug'];?>" readonly style="display:none;" />
																	<input name="adrep" value="<?php echo $row['adrep'];?>" readonly style="display:none;" />
																	<?php if(isset($date)){ ?><input name="date" value="<?php echo $date;?>" readonly style="display:none;" /><?php } ?>
															<!--</form>-->
												
													<?php } }else{ echo "<font color='blue'>removed</font>"; } ?>
										</td>	
	<!--time sent end -->											
										<td>
											<?php if($row['time_taken']!='0')
												  { 
													//calculating hours, minutes and seconds (as floating point values)
													$hours = $row['time_taken'] / 3600; //one hour has 3600 seconds
													$minutes = ($hours - floor($hours)) * 60;
													$seconds = ($minutes - floor($minutes)) * 60;

													//formatting hours, minutes and seconds
													$final_hours = floor($hours);
													$final_minutes = floor($minutes);
													$final_seconds = floor($seconds);

													//output
													echo $final_hours . ":" . $final_minutes . ":" . $final_seconds; 
												  } 
											?>												  
										</td>
										
										<?php if($row['category']!='sold') { ?>
    										<td>
    											<?php if($row['pdf_path']!='none' && file_exists($row['pdf_path'])){
    														$pdf_path = base_url().$row['pdf_path'];   ?>
    												<a href="<?php echo $pdf_path;?>" target="_blank" style="cursor:pointer; text-decoration: none;"><img src="<?php echo base_url()?>images/pdf.png" alt="pdf"/></a>
    											<?php }else{ echo' '; }  ?> 
    										</td>
										<?php }else{ ?>
    										<td>
    											<?php 
    											    $cat = $this->db->get_where('cat_result',array('order_no' => $row['order_id']))->result_array();
    												$sold_pdf_path = 'sold_pdf/'.$row['order_id'].'/'.$cat[0]['slug'];
    												if(isset($sold_pdf_path) && $row['sold_pdf']!='none'){ 
    													$map1 = $sold_pdf_path.'/'.$row['sold_pdf'];
    												    if(file_exists($map1)){	   
    											?>
    													<a href="<?php echo base_url()?><?php echo $map1 ;?>" target="_blank" style="cursor:pointer; text-decoration: none;"><img src="<?php echo base_url()?>images/pdf.png" alt="pdf"/></a>
    											<?php  }else{ 
    											            echo' '; 
    											        } 
    												} 
    											?> 
    										</td>
										<?php } ?>
								
										<td><?php if($row['classification']!='0'){ echo $rev_classification['name']; } ?></td>
										
										<?php 
										    if($this->session->userdata('sId') == '68'){
										        if($row['status'] != '5'){
										           echo '<td><button onclick="deleteItem1('.$row['id'].')">Delete</button></td>';
										        }else{ 
										            echo '<td></td>';  
										        }
										    }
										?>	
							</tr>
<?php $i++; } } ?>											
										</tbody>
									</table>
									<p><?php echo $links; ?></p>
									<p><?php echo $result_range; ?></p>
			<?php } ?>
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
            <button type="button" class="btn btn-primary" onclick="confirm1()">Ok</button>
          </div>
        </div>
      </div>
    </div>
<!-- Modal ends here-->
 <?php $this->load->view("new_csr/foot.php"); ?> 

<script>
    function deleteItem1(revId) {
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
    
     var table = $('#revision_table').DataTable({
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

</script>