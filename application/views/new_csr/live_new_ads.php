 <?php $this->load->view("new_csr/head"); ?>
<!-- BEGIN PAGE CONTAINER -->
 <script>
	function sluf_confirm123(){    
	    var X=confirm('Confirm To Proof Check!!');	
	    if(X==true){ return true; }else{ return false; }
	} 
	
	function confirm_proof_check(help_desk,order_id){
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
     

	function goBack(){ window.history.back(); }

	function myFunction() {
		location.reload();
	}
	
	function unset_categorised_ad(){
	  $.ajax({
        type: 'POST',
		url: "<?php echo base_url().index_page().'new_csr/home/unset_categorised_ad';?>",
        success: function(response) {
            // Redirect the user to the new location
            window.location.href = "<?php echo base_url() . index_page() . 'new_csr/home/live_new_ads/category'; ?>";
        },
        error: function() {
            alert('Something went wrong!!');
        }
    });  
	}

    function getOrderList(order_type){
	  var order_type = order_type;
	  if(order_type == "category"){
	     var no_of_order = $("#no_of_order").val();  
	  }else if (order_type == "new_pending"){
	     var no_of_order = $("#no_of_newpending_order").val();   
	  }
	  var dataString = "no_of_order="+no_of_order+"&order_type="+order_type;

    	$.ajax({
    		url: "<?php echo base_url().index_page().'new_csr/home/live_new_ads/';?>"+order_type,
    		type: 'POST',
    		data: dataString,
            success: function(response) {
                // Redirect the user to the new location
                 window.location.href = "<?php echo base_url() . index_page() . 'new_csr/home/live_new_ads/'; ?>"+order_type;
            },
            error: function() {
                alert('Something went wrong!!');
            }
        }); 
        
	}
	
	function check(){
    	$.ajax({
        type: 'POST',
    	url: "<?php echo base_url().index_page().'new_csr/home/unset_sess';?>",
        success: function(response) {
            sessionStorage.removeItem('c_columnIndex');
            sessionStorage.removeItem('c_sort_by');
            var dataTable = $('#upload_pending_tbl').DataTable();
            dataTable.state.clear(); // Clear the saved state
            dataTable.draw(); // Redraw the DataTable
            // Redirect the user to the new location
            window.location.href = "<?php echo base_url() . index_page() . 'new_csr/home/live_new_ads/category'; ?>";
        },
        error: function() {
            alert('Something went wrong!!');
        }
        });
	}
	
	function reset_newpendingads(){
		$.ajax({
        type: 'POST',
		url: "<?php echo base_url().index_page().'new_csr/home/reset_newpendingads';?>",
        success: function(response) {
            sessionStorage.removeItem('n_columnIndex');
            sessionStorage.removeItem('n_sort_by');
            var dataTable = $('#new_pending_ads_tbl').DataTable();
            dataTable.state.clear(); // Clear the saved state
            dataTable.draw(); // Redraw the DataTable
            // Redirect the user to the new location
            window.location.href = "<?php echo base_url() . index_page() . 'new_csr/home/live_new_ads/new_pending'; ?>";
        },
        error: function() {
            alert('Something went wrong!!');
        }
    });
	}
</script>
<div class="page-container"> 
	<!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
		<div class="container">
			<div class="row"> 
				<div class="col-lg-12"><?php echo $this->session->flashdata('message'); ?>
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
						</div>
	<?php $form=''; ?>					
						<!-- Collect the nav links, forms, and other content for toggling -->
						<div class="collapse navbar-collapse navbar-ex1-collapse no-space">
						<ul class="nav navbar-nav">
						<?php if($csr['csr_role'] == '2' || $csr['csr_role'] == '3') { ?>
							<?php  if($display_type == 'category'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
								<a href="<?php echo base_url().index_page().'new_csr/home/live_new_ads/category';?>">
								Order Acceptance <span class="badge bg-red"><?php echo $category_count; ?></span></a>
							</li>
						<?php } ?>
						<?php if($csr['csr_role'] == '1' || $csr['csr_role'] == '2' || $csr['csr_role'] == '3') { ?>
							<?php  if($display_type == 'QA'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
								<a href="<?php echo base_url().index_page().'new_csr/home/live_new_ads/QA';?>">
								My Ads <span class="badge bg-green"><?php echo $myQ_count; ?></span></a>
							</li>
						<?php } ?>
						<?php if($csr['csr_role'] == '1' || $csr['csr_role'] == '2' || $csr['csr_role'] == '3') { ?>
							<?php  if($display_type == 'total_QA'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
								<a href="<?php echo base_url().index_page().'new_csr/home/live_new_ads/total_QA';?>">
								Team Ads <span class="badge bg-green"><?php echo $generalQ_count; ?></span></a>
							</li>
						<?php } ?>
							<!--ALL--> 
						<?php if($csr['csr_role'] == '2' || $csr['csr_role'] == '3') { ?>
							<?php  if($display_type == 'new_pending'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
								<a href="<?php echo base_url().index_page().'new_csr/home/live_new_ads/new_pending';?>">
								All <span class="badge bg-green"><?php echo $all_count; ?></span></a>
							</li>
						<?php } ?>
						
						<!--today metro ad sent
						<?php if($form == '2'){ ?>
							<?php  if($display_type == 'metro_ad_sent'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
								<a href="<?php echo base_url().index_page().'new_csr/home/live_new_ads/metro_ad_sent';?>">
								Sent Ads <span class="badge bg-green"><?php echo count($metro_sent); ?></span></a>
							</li>
						<?php } ?>
						today metro ad sent-->
						</ul>
							<span style="margin-left: 20px; padding: 0 10px;" class="font-blue margin-top-10">	
								<?php echo $this->session->flashdata('metro_message'); ?>
							</span>
							<ul class="nav navbar-nav navbar-right  margin-right-10">
							<?php if($form=='2'){ ?>
							<li class="margin-top-10">
								<form class="search-form"  name="form" method="post" action="<?php echo base_url().index_page().'new_csr/home/metro_order_search'; ?>">
									<div class="col-sm-8"  style="padding: 0;">
										<input type="text" class="form-control" placeholder="Metro Order Search" name="id" required>
									</div>
									<div class="col-md-4"   style="padding: 0;">
										<button type="submit" name="search" class="btn blue"><i class="fa fa-search"></i></button>
									</div>
								</form>
					  
							</li>
						
							<li>
								<a href="<?php echo base_url().index_page()."new_csr/home/metro_orders";?>">Aod Orders</a>
							</li>
							<?php }elseif($form=='5'){ ?>	<!-- MAP orders for Design6 help_desk-->
								<li>
									<a href="<?php echo base_url().index_page()."new_csr/home/map_orders";?>" target="_blank">Map Orders</a>
								</li>
							<?php } ?>
							
								<?php if($form=='12'){ ?>
								<li>
									<a onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/vidn_entries';?>'" href="javascript:;">
									Vidn Entries </a>
								</li>
							<?php 
								} 
							    $club_id_array = explode(',', $csr['club_id']);
							    if(in_array(4, $club_id_array)){
							?>
						        <li>
									<a href="<?php echo base_url().index_page().'new_csr/home/cshift/2';?>" target="blank">
									Metro Ads </a>
								</li>
							<?php } ?>	
								<li>
									<a onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/new_cat/'.$form;?>'" href="javascript:;">
									Create New Ad </a>
								</li>
								
							</ul>
						</div>
						<!-- /.navbar-collapse -->
					</div>
				</div>
			</div>
<!--category-->
<?php  if($display_type == 'category'){ //category ?>	
<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="caption static-info no-space margin-top-10">
					<div class="value bold">
						<span style="margin-left: 20px; padding: 0 10px;" class="font-blue">
							<?php echo $this->session->flashdata('sucess_message'); ?>	
							<?php echo $this->session->flashdata('message'); ?>
							<?php if ($this->session->userdata('ad_categorised')) {
                                    echo '<script>
                                        $(document).ready(function() {
                                            $("#confirmationModal").modal("show");
                                        });
                                    </script>';
                                } ?>
						</span>
					</div>
				</div>
				<div class="tools no-space">
					<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()"> </a>
				</div>
			</div>			
			<div class="portlet-body">
			     <!-- serach form starts here-->
    			    <form action="<?php echo base_url().index_page().'new_csr/home/live_new_ads/category' ?>" method="get">
        				<div class="form-group row">
        				<div class="col-sm-6">
        				    <div class="col-sm-3">
        				        <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="no_of_order" id="no_of_order" onchange="getOrderList('category')">
                                  <option selected value="">select</option>
                                  <option value="10" <?php if($this->session->userdata('no_of_order') == '10'){echo 'selected';}?> >10</option>
                                  <option value="25" <?php if($this->session->userdata('no_of_order') == '25'){echo 'selected';}?> >25</option>
                                  <option value="50" <?php if($this->session->userdata('no_of_order') == '50'){echo 'selected';}?> >50</option>
                                  <option value="100" <?php if($this->session->userdata('no_of_order') == '100'){echo 'selected';}?>>100</option>
                                </select>
        				    </div>
        				   
        				</div>
        					<div class="col-sm-3">
        						<input type="text" id="category_search" name="category_search" value="<?php if($this->session->userdata("search_val") !== "" ){echo $this->session->userdata("search_val");}?>" placeholder="Search here" class="form-control">
        					</div>
        					<div class="col-sm-1">
        						<input type="submit" value="Search" class="btn btn-primary">
        					</div>
        					<div class="col-sm-1">
        						<button type="button" class="btn btn-warning" onclick="check()">Reset</button>
        					</div>
        				</div>
    			    </form>
			    <!-- serach form ends here-->
				<table class="table table-striped table-bordered table-hover" id="category_tbl">
					<thead>
						<tr>
						    <th style="display:none;" ></th>
							<th style="vertical-align: middle;" id="created_on">Date</th>
							<th style="vertical-align: middle;" id="order_id">AdwitAds ID</th>
							<th style="vertical-align: middle;" >Unique Job Name</th>
							<th style="vertical-align: middle;" id="adreps">Adrep</th>
							<th style="vertical-align: middle;" id="publications">Publication</th>						
							<th style="text-align: middle;">Click to</th>
							<th style="text-align: middle;" id="priority">Priority</th>
						  </tr>              
					</thead>
					<tbody name="testTable" id="testTable">
<?php 
	$i=1;
	if(isset($category_orders) && $category_orders != false){
	foreach($category_orders as $row1)
	{
			$publication = $this->db->query("SELECT `name` FROM `publications` WHERE `id`='".$row1['pub_id']."' ;")->result_array();		
			$adreps = $this->db->query("SELECT `id`, `first_name`, `color_code` FROM `adreps` WHERE `id`='".$row1['adrep_id']."' ;")->result_array();		
			$order_status = $this->db->get_where('order_status',array('id'=>$row1['status']))->result_array();
			$adrep_name = '';
			if(isset($adreps[0]['id'])){
			   $adrep_name = $adreps[0]['first_name'];
			   $color_code = $this->db->get_where('color_code',array('id' => $adreps[0]['color_code']))->row_array(); 
			}
				
?>
					<tr <?php if($row1['rush']=='1'){ echo'class="bg-red-pink"'; }elseif(isset($color_code['id'])){ echo 'class="'.$color_code['code'].'"'; } ?>>
					    
					    <td style="display:none;"> <?php if($row1['rush']=='1'){ echo 1; }?> </td>

<!-- date -->			<td><?php $date = strtotime($row1['created_on']); echo date('d-M', $date); ?></td>

<!-- order_no --> 		<td><?php echo $row1['order_id']; if(isset($row1['page_design_id'])){ echo ' / '.$row1['page_design_id']; } ?></td>

<!-- job_name -->		<?php 
                            if($row1['order_type_id'] == '6'){
                                echo '<td>'.$row1['advertiser_name'].'/'.$row1['job_no'].'</td>';
                            }else{
                                echo '<td>'.$row1['job_no'].'</td>';
                            }
                        ?>
                        
<!-- adrep -->			<td><?php echo $adrep_name;  ?> </td>

<!-- Publication -->	<td><?php if(isset($publication)) { echo $publication[0]['name']; } else{ echo " ";}?></td>

<!-- category -->		<td <?php if($row1['question']=='1') { echo "class='danger'";} if($row1['question']=='2') { echo "class='success '";} ?>>
							<a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/orderview/'.$row1['help_desk'].'/'.$row1['order_id'];?>'" style="cursor:pointer; text-decoration: none;">
							<button class="btn blue btn-xs" ><?php if($order_status) echo $order_status[0]['d_name']; else echo''; ?></button></a>
						</td>
						
<!-- Priority -->		<td><?php echo $row1['time_zone_priority']; ?></td>
					</tr>
	<?php $i++;  } }?>
					</tbody>
				</table>
				<p><?php echo $links; ?></p>
				<p><?php echo $result_range; ?></p>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<!--category-->


<!-- Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1"  data-backdrop="static" role="dialog" aria-labelledby="confirmationModalTitle" aria-hidden="true">
 <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="width:85%">
      <div class="modal-header  portlet blue-hoki box" style="border-bottom: 0 !important;">
        <h5 class="modal-title portlet-title margin-top-10" id="confirmationModalTitle" style="margin-top: 0px !important; padding:10px !important;"><center><b>Success</b></center></h5>
      </div>
      <div class="modal-body">
        Ad is successfully categorised <b style="color:#67809F;"><?php echo $this->session->userdata('ad_categorised')?></b>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="unset_categorised_ad()">Close</button>
      </div>
    </div>
  </div>
</div>
						
<!--QA-->
<?php if($display_type=='QA') { ?>
<div class="row">
	<div class="col-md-12">
		<div class="portlet light">						
			<div class="portlet-title">
				<div class="caption static-info no-space margin-top-10">
					<div class="value bold">
						<span style="margin-left: 20px; padding: 0 10px;" class="font-blue">
							<?php echo $this->session->flashdata('sucess_message'); ?>	
							<?php echo $this->session->flashdata('message'); ?>
						</span>
					</div>
				</div>
				<div class="tools no-space">
						<button class="btn bg-grey btn-sm" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Excel</button>
						<button onclick="printPage()" class="btn bg-grey btn-sm"><i class="fa fa-print"></i> Print</button>
							<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()">
						 </a>
				</div>
			</div>
			<div class="portlet-body">
				<table class="table table-striped table-bordered table-hover" id="sample_6">
					<thead>
						<tr>
							<th style="display:none;" ></th>
							<th style="vertical-align: middle;">Type</th>
							<th style="vertical-align: middle;">AdwitAds ID</th>
							<th style="vertical-align: middle;">Unique Job Name</th>
							<th style="vertical-align: middle;">Adrep</th>
							<th style="vertical-align: middle;">Publication</th>											
							<!--<th style="text-align: center;">Category</th>
							<th style="text-align: center;">Design</th>-->
							<th style="vertical-align: middle;">Click to</th>
							<!--<th style="text-align: center;">Upload</th>
							<th style="vertical-align: middle;">Actions</th>-->
							<th style="text-align: middle;">Priority</th>
						</tr>              
					</thead>
					<tbody name="testTable" id="testTable">
<?php 
foreach($myQ_orders as $row)
{
	$order =  $this->db->query("SELECT id, advertiser_name, job_no, order_type_id, rush, adrep_id, question, help_desk, page_design_id FROM `orders` WHERE `id`='".$row['order_id']."' ;")->row_array();		
	//$cat_result = $this->db->query("SELECT * FROM `cat_result` WHERE `order_no` = '".$row['order_id']."' ")->result_array();
	if(isset($order['id'])){
		$order_type = $this->db->get_where('orders_type',array('id' => $order['order_type_id']))->result_array();
		$publication_name = $this->db->query("SELECT `name` FROM `publications` WHERE `id`='".$row['pub_id']."' ;")->result_array();		
		$adreps = $this->db->query("SELECT `id`, `first_name`, `color_code` FROM `adreps` WHERE `id`='".$order['adrep_id']."' ;")->result_array();
		$order_status = $this->db->get_where('production_status',array('id'=>$row['pro_status']))->result_array();
		$adrep_name = '';
			if(isset($adreps[0]['id'])){
			   $adrep_name = $adreps[0]['first_name'];
			   $color_code = $this->db->get_where('color_code',array('id' => $adreps[0]['color_code']))->row_array();
			}
?>
					<tr <?php if($order['rush']=='1'){ echo'class="bg-red-pink"'; }elseif(isset($color_code['id'])){ echo 'class="'.$color_code['code'].'"'; } ?>>

                        <td style="display:none;"> <?php if($order['rush']=='1'){ echo 1; }?> </td>

<!-- type -->			<td title="<?php echo $order_type[0]['name']; ?>">
                            <span class="badge bg-blue">
                                <?php if($order_type[0]['value']=='print') {echo "P";} elseif($order_type[0]['value']=='web'){ echo "W";}elseif($order_type[0]['value']=='pagination'){ echo "PG";}else{ echo "P&W";}?>
                            </span>
                        </td>

<!-- order_no --> 		<td><?php echo $order['id']; if(isset($order['page_design_id'])){ echo ' / '.$order['page_design_id']; } ?></td>

<!-- job_name -->		<td>
                        <?php 
                            if($order['order_type_id'] == '6'){
                                echo $order['advertiser_name'].'/'.$order['job_no'];
                             }else{
                                echo $order['job_no'];
                             }
                        ?>
                        </td>

<!-- adreps -->			<td><?php echo $adrep_name;  ?></td>

<!-- newspaper -->		<td><?php echo $publication_name[0]['name']; ?></td>
						
						
<!-- QA -->            	<td <?php if($order['question']=='1') { echo "class='danger'";} if($order['question']=='2') { echo "class='success '";} ?> title="OrderView">
							<?php if($order_status) { 
									if($row['pro_status'] == '3') { 
							?>
							<a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/orderview/'.$order['help_desk'].'/'.$order['id'];?>'" style="cursor:pointer; text-decoration: none;">
							<button class="btn blue btn-xs" ><?php echo $order_status[0]['d_name']; ?></button></a> <?php }else{ ?>
							<button class="btn grey btn-xs" ><?php echo $order_status[0]['d_name']; ?></button>
							<?php } } ?>
						</td>
						
<!-- Priority -->		<td><?php echo $row['time_zone_priority']; ?></td>						
					</tr>
<?php } } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>	
<?php } ?>
<!--QA-->
				
<!--new_pending-->
<?php if($display_type=='new_pending') { ?>
<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="caption static-info no-space margin-top-10">
					<div class="value bold">
						<span style="margin-left: 20px; padding: 0 10px;" class="font-blue">
							<?php echo $this->session->flashdata('sucess_message'); ?>	
							<?php echo $this->session->flashdata('message'); ?>
						</span>
					</div>
				</div>
				<div class="tools no-space">
					<!--<button class="btn bg-grey btn-sm"><i class="fa fa-file-excel-o"></i> Excel</button>-->
					<form method="post" action="<?php echo base_url().index_page().'new_csr/home/getNewpendingAdsExcel'?>">
				        <button type="submit" class="btn bg-grey btn-sm"><i class="fa fa-file-excel-o"></i> Excel</button>
				    </form>
					<button onclick="printPage()" class="btn bg-grey btn-sm"><i class="fa fa-print"></i> Print</button>
						<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()">
					 </a>
				</div>
			</div>
			<div class="portlet-body">
			     <!-- search filter starts here -->
			    <form action="<?php echo base_url().index_page().'new_csr/home/live_new_ads/new_pending' ?>" method="get">
    				<div class="form-group row">
        				<div class="col-sm-6">
        				      <div class="col-sm-3">
        				        <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="no_of_newpending_order" id="no_of_newpending_order" onchange="getOrderList('new_pending')">
                                  <option selected value="">select</option>
                                  <option value="10" <?php if($this->session->userdata('no_of_newpending_order') == '10'){echo 'selected';}?> >10</option>
                                  <option value="25" <?php if($this->session->userdata('no_of_newpending_order') == '25'){echo 'selected';}?> >25</option>
                                  <option value="50" <?php if($this->session->userdata('no_of_newpending_order') == '50'){echo 'selected';}?> >50</option>
                                  <option value="100" <?php if($this->session->userdata('no_of_newpending_order') == '100'){echo 'selected';}?>>100</option>
                                </select>
        				    </div>
        				</div>
        					<div class="col-sm-3">
        						<input type="text" id="newpending_ads" name="newpending_ads" value="<?php if($this->session->userdata("newad_val") !== "" ){echo $this->session->userdata("newad_val");}?>" placeholder="Search here" class="form-control">
        					</div>
        					<div class="col-sm-1">
        						<input type="submit" value="Search" class="btn btn-primary">
        					</div>
        					<div class="col-sm-1">
        						<button type="button" class="btn btn-warning" onclick="reset_newpendingads()">Reset</button>
        					</div>
    				</div>
			    </form>
			    <!-- search filter ends here -->
				<table class="table table-striped table-bordered table-hover" id="new_pending_ads_tbl"> 
				<thead>
					<tr>
					    <th style="display:none;"></th>
						<th style="vertical-align: middle;" id="order_id">Date</th>
						<th style="vertical-align: middle;" id="type">Type</th>
						<th style="vertical-align: middle; id="order_id"">AdwitAds ID</th>
						<th style="vertical-align: middle;">Unique Job Name</th>
						<th style="vertical-align: middle;" id="adreps">Adrep</th>
						<th style="vertical-align: middle;" id="publications">Publication</th>
						<th style="vertical-align: middle;">Click to</th>
						<th style="text-align: middle;" id="priority">Priority</th>
					</tr>              
				</thead>
				<tbody name="testTable" id="testTable">
<?php 
if(isset($all_orders) && $all_orders != false){
foreach($all_orders as $row1)
{
		$order_type = 	$this->db->get_where('orders_type',array('id' => $row1['order_type_id']))->result_array();
		$publication = $this->db->query("SELECT `name` FROM `publications` WHERE `id`='".$row1['pub_id']."' ;")->result_array();		
		$adreps = $this->db->query("SELECT `id`, `first_name`, `color_code` FROM `adreps` WHERE `id`='".$row1['adrep_id']."' ;")->result_array();
		$order_status = $this->db->get_where('order_status',array('id'=>$row1['status']))->result_array();
        $adrep_name = '';
		if(isset($adreps[0]['id'])){
		    $adrep_name = $adreps[0]['first_name'];
		    $color_code = $this->db->get_where('color_code',array('id' => $adreps[0]['color_code']))->row_array();
		}
?>
				<tr <?php if($row1['rush']=='1'){ echo'class="bg-red-pink"'; }elseif(isset($color_code['id'])){ echo'class="'.$color_code['code'].'"'; } ?>>
				    
				        <td style="display:none;"> <?php if($row1['rush']=='1'){ echo 1; }?> </td>
				        
<!-- Date -->			<td><?php $date = strtotime($row1['created_on']); echo date('d-M', $date); ?></td>

<!-- Type -->			<td title="<?php echo $order_type[0]['name']; ?>">
                            <span class="badge bg-blue">
                                <?php if($order_type[0]['value']=='print') {echo "P";} elseif($order_type[0]['value']=='web'){ echo "W";}elseif($order_type[0]['value']=='pagination'){ echo "PG";} else{ echo "P&W";}?>
                            </span>
                        </td> 

<!-- Order_no --> 		<td title="view attachments">
							<a <?php if($row1['rush']==1){ echo "class='font-grey-cararra'";} ?> href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_csr/home/orderview/'.$row1['help_desk'].'/'.$row1['order_id'];?>'" style="cursor:pointer; text-decoration: none;">
								<?php echo $row1['order_id']; if(isset($row1['page_design_id'])){ echo ' / '.$row1['page_design_id']; } ?>
							</a>
						</td>

<!-- Job_name -->		<td>
                            <?php 
                                if($row1['order_type_id'] == '6'){
                                    echo $row1['advertiser_name'].'/'.$row1['job_no'];
                                 }else{
                                    echo $row1['job_no'];
                                 }
                            ?>
                        </td>

<!-- adrep -->			<td><?php echo $adrep_name;  ?></td>

<!-- Newspaper -->		<td><?php echo $publication[0]['name']; ?></td>

<!-- Status -->			<?php if($row1['status']=='1') { ?>
						<td <?php if($row1['question']=='1') { echo "class='danger'";} if($row1['question']=='2') { echo "class='success '";} ?>>
							<a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/orderview/'.$row1['help_desk'].'/'.$row1['order_id'];?>'" style="cursor:pointer; text-decoration: none;" >
								<button class="btn blue btn-xs" ><?php echo $order_status[0]['d_name']; ?></button>
							</a>
						</td>
						<?php } ?>

<!-- Status -->			<?php if($row1['status']=='2') { ?>
						<td <?php if($row1['question']=='1') { echo "class='danger'";} if($row1['question']=='2') { echo "class='success '";} ?>>
							<a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/orderview/'.$row1['help_desk'].'/'.$row1['order_id'];?>'" style="cursor:pointer; text-decoration: none;">
								<button class="btn blue btn-xs" ><?php echo $order_status[0]['d_name']; ?></button>
							</a>
						</td>
						<?php } ?>

<!-- Status -->			<?php if($row1['status']=='3') { ?>
						<td <?php if($row1['question']=='1') { echo "class='danger'";} if($row1['question']=='2') { echo "class='success '";} ?>>
							<a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/orderview/'.$row1['help_desk'].'/'.$row1['order_id'];?>'" style="cursor:pointer; text-decoration: none;">
								<button class="btn blue btn-xs" ><?php echo $order_status[0]['d_name']; ?></button>
							</a>
						</td>
						<?php } ?>
						
<!-- Status -->			<?php if($row1['status']=='4') { ?>
						<td <?php if($row1['question']=='1') { echo "class='danger'";} if($row1['question']=='2') { echo "class='success '";} ?>>
							<a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/orderview/'.$row1['help_desk'].'/'.$row1['order_id'];?>'" style="cursor:pointer; text-decoration: none;">
								<button class="btn blue btn-xs"><?php echo $order_status[0]['d_name']; ?></button>
							</a>
								<?php 
									$cat_result = $this->db->query("SELECT csr.name FROM `cat_result`
																		JOIN `csr` ON cat_result.csr_QA = csr.id
																		WHERE cat_result.order_no = '".$row1['order_id']."' AND cat_result.pro_status = '3'")->row_array();
									 if(isset($cat_result['name'])){	echo $cat_result['name'];  } 
								?>
						</td>
						<?php } ?>

<!-- Priority -->		<td><?php echo $row1['time_zone_priority']; ?></td>                        
				</tr>
<?php  }} ?>
				</tbody>
			  </table>
			  <p><?php echo $newad_links; ?></p>
			  <p><?php echo $new_result_range; ?></p>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<!--new_pending-->

<!--Total_QA-->
<?php if($display_type=='total_QA') { ?>
<div class="row">
	<div class="col-md-12">
		<div class="portlet light">						
			<div class="portlet-title">
				<div class="caption static-info no-space margin-top-10">
					<div class="value bold">
						<span style="margin-left: 20px; padding: 0 10px;" class="font-blue">
							<?php echo $this->session->flashdata('sucess_message'); ?>	
							<?php echo $this->session->flashdata('message'); ?>
						</span>
					</div>
				</div>
				<div class="tools no-space">
						<button class="btn bg-grey btn-sm" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Excel</button>
						<button onclick="printPage()" class="btn bg-grey btn-sm"><i class="fa fa-print"></i> Print</button>
							<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()">
						 </a>
				</div>
			</div>
			<div class="portlet-body">
				<table class="table table-striped table-bordered table-hover" id="sample_6">
					<thead>
						<tr>
							<th style="display:none;" ></th>
							<th style="vertical-align: middle;">Type</th>
							<th style="vertical-align: middle;">AdwitAds ID</th>
							<th style="vertical-align: middle;">Unique Job Name</th>
							<th style="vertical-align: middle;">Adrep</th>
							<th style="vertical-align: middle;">Publication</th>	
							<!--<th style="vertical-align: middle;">Assign</th>-->
							<th style="vertical-align: middle;">Category</th>
							<!--<th style="text-align: center;">Design</th>-->
							<th style="vertical-align: middle;">Click to</th>
							<!--<th style="text-align: center;">Upload</th>
							<th style="vertical-align: middle;">Actions</th>-->
							<th style="text-align: middle;">Priority</th>
						</tr>              
					</thead>
					<tbody name="testTable" id="testTable">
<?php 
foreach($generalQ_orders as $row)
{
	$order =  $this->db->query("SELECT id, order_type_id, rush, adrep_id, question, help_desk, created_on, job_no, status, page_design_id FROM `orders` WHERE `id`='".$row['order_id']."' ;")->row_array();
	//$cat_result = $this->db->query("SELECT * FROM `cat_result` WHERE `order_no` = '".$row['id']."' AND `pro_status` = '3' AND `csr_QA` = '0'")->result_array();
	//$cat_result = $this->db->query("SELECT * FROM `cat_result` WHERE `order_no` = '".$row['order_id']."'")->result_array();
	if(isset($order['id'])){
		$order_type = $this->db->get_where('orders_type',array('id' => $order['order_type_id']))->result_array();
		$publication_name = $this->db->query("SELECT `name` FROM `publications` WHERE `id`='".$row['pub_id']."' ;")->result_array();		
		$adreps = $this->db->query("SELECT `id`, `first_name`, `color_code` FROM `adreps` WHERE `id`='".$order['adrep_id']."' ;")->result_array();
		$order_status = $this->db->get_where('order_status',array('id'=>$row['status']))->result_array();
		$adrep_name = '';
		if(isset($adreps[0]['id'])){
		    $adrep_name = $adreps[0]['first_name'];
		    $color_code = $this->db->get_where('color_code',array('id' => $adreps[0]['color_code']))->row_array();
		}
?>
					<tr <?php if($order['rush']=='1'){ echo'class="bg-red-pink"'; }elseif(isset($color_code['id'])){ echo'class="'.$color_code['code'].'"'; }else{ echo'class="odd gradeX"'; } ?>>

                        <td style="display:none;"> <?php if($order['rush']=='1'){ echo 1; }?> </td>

<!-- type -->			<td title="<?php echo $order_type[0]['name']; ?>">
                            <span class="badge bg-blue">
                                <?php if($order_type[0]['value']=='print') {echo "P";} elseif($order_type[0]['value']=='web'){ echo "W";}elseif($order_type[0]['value']=='pagination'){ echo "PG";} else{ echo "P&W";}?>
                            </span>
                        </td>

<!-- order_no --> 		<td <?php if($order['rush']==1){ echo "class='font-grey-cararra'";} ?>> <?php echo $order['id']; if(isset($order['page_design_id'])){ echo ' / '.$order['page_design_id']; } ?> </td>

<!-- job_name -->		<td><?php echo $row['job_no']; ?></td>

<!-- adreps -->			<td><?php echo $adrep_name; ?></td>

<!-- newspaper -->		<td><?php echo $publication_name[0]['name']; ?></td>

<!-- Assign  		<td> 
						<?php if($cat_result[0]['assign']!='0') {
								$design_assign_name = $this->db->get_where('design_assign',array('id' => $cat_result[0]['assign']))->result_array(); echo $design_assign_name[0]['name'];
							} else { ?>
								<input type="checkbox" name="assign[]" id="assign[]" value="<?php echo $cat_result[0]['id']; ?>">
								<input name="cat_id" value="<?php echo $cat_result[0]['id']; ?>" hidden />
						<?php } ?>
						</td>-->
						
<!-- Category -->		<td><?php echo $row['category']; ?></td>
			
<!-- QA -->            	<td <?php if($order['question']=='1') { echo "class='danger'";} if($order['question']=='2') { echo "class='success '";} ?> title="OrderView">
							<?php if($order_status ) { ?>
							<!--<form method="post" action="<?php echo base_url().index_page().'new_csr/home/orderview/'.$order['help_desk'].'/'.$order['id'];?>"> -->
							<form method="post" id="proof_check_form">
								<!--<button name="proof_check" class="btn blue btn-xs" onclick="return sluf_confirm123()">Proof Check</button>-->
								<button type="button" id="proof_check" name="proof_check" class="btn blue btn-xs" onclick="confirm_proof_check(<?php echo $order['help_desk'];?>,<?php echo $order['id']; ?>)">Proof Check</button>
								<input type="text" name="order_id" value="<?php echo $order['id']; ?>" style="display:none;">
								<div style="display:none" id="proof_check_div">
    						
							    </div>
							</form>
							<?php }?>
						
							<?php if($row['csr_QA'] == $csr['id']) { ?>
								<i class="fa fa-flag"></i>
								<?php } else { echo ' '; } ?>
							
						</td>
						
<!-- Priority -->		<td><?php echo $row['time_zone_priority']; ?></td>						
					</tr>
<?php  } } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>	
<?php } ?>
<!--Total_QA-->
		
<!--metro ad sent-->
<?php if($display_type=='metro_ad_sent') { ?>
<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="caption static-info no-space margin-top-10">
					<div class="value bold"><?php  $type = $this->db->get_where('help_desk',array('active'=>'1','id'=>$form))->result_array(); ?>
						<?php echo $type[0]['name']; ?>
						<span style="margin-left: 20px; padding: 0 10px;" class="font-blue">
							<?php echo $this->session->flashdata('sucess_message'); ?>	
							<?php echo $this->session->flashdata('message'); ?>
						</span>
					</div>
				</div>
				<div class="tools no-space">
					<button class="btn bg-grey btn-sm"><i class="fa fa-file-excel-o"></i> Excel</button>
					<button onclick="printPage()" class="btn bg-grey btn-sm"><i class="fa fa-print"></i> Print</button>
						<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()">
					 </a>
				</div>
			</div>
			<div class="portlet-body">
				<table class="table table-striped table-bordered table-hover" id="sample_6"> 
				<thead>
					<tr>
					    <th style="display:none;" ></th>
						<th style="vertical-align: middle;">Date</th>
						<th style="vertical-align: middle;">AdwitAds ID</th>
						<th style="vertical-align: middle;">Unique Job Name</th>
						<th style="vertical-align: middle;">Adrep</th>
						<th style="vertical-align: middle;">Publication</th>
						<th style="vertical-align: middle;">Click to</th>
						<th style="text-align: middle;">Priority</th>
					</tr>              
				</thead>
				<tbody name="testTable" id="testTable">
<?php 
    foreach($metro_sent as $row1){
        $order_type = 	$this->db->get_where('orders_type',array('id' => $row1['order_type_id']))->result_array();
        $publication = $this->db->query("SELECT `name` FROM `publications` WHERE `id`='".$row1['publication_id']."' ;")->result_array();		
        $adreps = $this->db->query("SELECT `first_name` FROM `adreps` WHERE `id`='".$row1['adrep_id']."' ;")->result_array();
        $order_status = $this->db->get_where('order_status',array('id'=>$row1['status']))->result_array();

?>
				<tr <?php if($row1['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="bg-red-pink"'; } ?>>
				        <td style="display:none;"> <?php if($row1['rush']=='1'){ echo 1; }?> </td>
<!-- Date -->			<td><?php $date = strtotime($row1['created_on']); echo date('d-M', $date); ?></td>
<!-- Order_no --> 		<td title="view attachments"><a <?php if($row1['rush']==1){ echo "class='font-grey-cararra'";} ?> href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;"><?php echo $row1['id']; ?></a></td> 

<!-- Job_name -->		<td><?php echo $row1['job_no']; ?></td>

<!-- adrep -->			<td><?php if($adreps) { echo $adreps[0]['first_name']; } ?></td>

<!-- Newspaper -->		<td><?php echo $publication[0]['name']; ?></td>

						<td><?php if($order_status) { ?>
						<form method="post">
							<input type="text" name="order_id" value="<?php echo $row1['id'] ;?>" style="display:none;">
 							<button type="submit" class="btn blue btn-xs" name="ad_sent"><?php echo $order_status[0]['d_name'];?></button><?php }else{ echo' '; }?>
						</form>
						</td> 
						
<!-- Priority -->		<td><?php echo $row1['time_zone_priority']; ?></td>						
				</tr>
<?php  } ?>
				
				</tbody>
			  </table>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<!--metro ad sent-->	
		</div>
	</div>
</div>
	<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->
<!-- Modal starts here-->
<div class="modal fade" id="proofConfirmationModal" tabindex="-1"  data-backdrop="static" role="dialog" aria-labelledby="confirmationModalTitle" aria-hidden="true">
 <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="width:85%">
      <div class="modal-header  portlet blue-hoki box" style="border-bottom: 0 !important;">
        <h5 class="modal-title portlet-title margin-top-10" id="confirmationModalTitle" style="margin-top: 0px !important; padding:10px !important;"><center><b></b></center></h5>
      </div>
      <div class="modal-body">
       <center><b>Confirm To Proof Check!!</b></center>
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
<form method = "POST" action="<?php echo base_url().index_page().'new_csr/home/live_new_ads/category';?>" id="cat_form"> 
<input id="c_order_by" name ="c_order_by" hidden>
<input id="c_sort_by" name="c_sort_by" hidden>
</form>
<form method = "POST" action="<?php echo base_url().index_page().'new_csr/home/live_new_ads/new_pending';?>" id="new_pending_csr_form"> 
<input id="n_order_by" name ="n_order_by" hidden>
<input id="n_sort_by" name="n_sort_by" hidden>
</form>

<script>
function printPage() {
    window.print();
} 
</script>
<script>
        
        var tableToExcel = (function() {
                
        var uri = 'data:application/vnd.ms-excel;base64,'
            , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head></head><body><table>{table}</table></body></html>'
            , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
            , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
        return function(table, filename) {
        if (!table.nodeType) table = document.getElementById(table)
        var ctx = {worksheet: filename || 'Worksheet', table: table.innerHTML}
            window.location.href = uri + base64(format(template, ctx))
    }
    })()
</script>

<?php $this->load->view("new_csr/foot"); ?>

<script>
var columnIndex1 = sessionStorage.getItem('c_columnIndex') || "";
var sort_by1 = sessionStorage.getItem('c_sort_by') || "";

var n_columnIndex = sessionStorage.getItem('n_columnIndex') || "";
var n_sort_by = sessionStorage.getItem('n_sort_by') || "";
console.log(n_columnIndex);
console.log(n_sort_by);

$(document).ready(function() {
    
    var table = $('#sample_6').DataTable({
        destroy: true,
        order: [[0, 'desc']],
        columnDefs: [
            { targets: 0, visible: false }  // hide the first column
        ],
        iDisplayLength: -1,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]]
    });
    
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
    
    // Initialize DataTable
    var dataTable = $('#category_tbl').DataTable({
        destroy: true,
        stateSave: true,
        order: (columnIndex1 !== "" && sort_by1 !== "") ? [[parseInt(columnIndex1), sort_by1]] : [[0, 'desc']],
        columnDefs: [
            { targets: 0, visible: false }  // hide the first column
        ],
        iDisplayLength: -1,
        // lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]]
        "paging": false, //Dont want paging 
    	"bInfo": false, //Dont display info e.g. "Showing 1 to 4 of 4 entries"
    	"bFilter": false,
    	
    	drawCallback: function() {
            this.api().state.clear();
         }
    });

    // Event handler for header click
    $('#category_tbl thead th').click(function () {
        // Get column index
        // Get column id
        var columnId = $(this).attr('id');
         var order = dataTable.order();
         order_by = ('Column ID: ', columnId);
         sort_by = ('Sorting Direction: ', order[0][1]);
         var columnIndex = order[0][0];
        $("#c_order_by").val(order_by);
        $("#c_sort_by").val(sort_by);
        // Save values to localStorage
        sessionStorage.setItem('c_columnIndex', columnIndex);
        sessionStorage.setItem('c_sort_by', sort_by);
        $("#cat_form").submit();
    });
    
    // Initialize DataTable
    var dataTable = $('#new_pending_ads_tbl').DataTable({
        destroy: true,
        stateSave: true,
        order: (n_columnIndex !== "" && n_sort_by !== "") ? [[parseInt(n_columnIndex), n_sort_by]] : [[0, 'desc']],
        columnDefs: [
            { targets: 0, visible: false }  // hide the first column
        ],
        iDisplayLength: -1,
        // lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]]
        "paging": false, //Dont want paging 
    	"bInfo": false, //Dont display info e.g. "Showing 1 to 4 of 4 entries"
    	"bFilter": false,
    	
    	drawCallback: function() {
            this.api().state.clear();
         }
    });

    // Event handler for header click
    $('#new_pending_ads_tbl thead th').click(function () {
        // Get column index
        // Get column id
        var columnId = $(this).attr('id');
         var order = dataTable.order();
         order_by = ('Column ID: ', columnId);
         sort_by = ('Sorting Direction: ', order[0][1]);
         var columnIndex = order[0][0];
        $("#n_order_by").val(order_by);
        $("#n_sort_by").val(sort_by);
        // Save values to localStorage
        sessionStorage.setItem('n_columnIndex', columnIndex);
        sessionStorage.setItem('n_sort_by', sort_by);
        $("#new_pending_csr_form").submit();
    });



   
});

    
    
</script>