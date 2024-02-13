<?php $this->load->view("new_csr/head"); ?>
<!-- BEGIN PAGE CONTAINER -->
 
<div class="page-container"> 
	<!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
		<div class="container">
			<div class="row"> 
				<div class="col-lg-12">
					<div class="navbar navbar-default" role="navigation">
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
						<!-- Collect the nav links, forms, and other content for toggling -->
						<div class="collapse navbar-collapse navbar-ex1-collapse">
							<ul class="nav navbar-nav">
								<?php  if($display_type == 'category'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_csr/home/web_cshift/category';?>">
									Category<span class="badge bg-red"><?php echo $cat_count ?></span></a>
								</li>
								<?php  if($display_type == 'QA'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_csr/home/web_cshift/QA';?>">
									QA<span class="badge bg-green"><?php echo $QA_count ?></span></a>
								</li>
								<?php  if($display_type == 'new_pending'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_csr/home/web_cshift/new_pending';?>">
									All<span class="badge bg-green"><?php echo $new_pending_count ?></span></a>
								</li>
							</ul>
							<span style="margin-left: 20px; padding: 0 10px;" class="font-blue">
								<?php echo $this->session->flashdata('metro_message'); ?>
							</span>
							<ul class="nav navbar-nav navbar-right">
								<li>
									<a onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/new_cat/web';?>'" href="javascript:;">
									Web New Ad </a>
								</li>
							</ul>
						</div>
						<!-- /.navbar-collapse -->
					</div>
				</div>
			</div>
		<!--web_cshift_category-->
		<?php if($display_type=='category') { ?>
        <div class="row">
        <div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cogs font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold">Category Pending List</span>
								<span style="margin-left: 20px; padding: 0 10px;" class="font-blue">
										<?php echo $this->session->flashdata('sucess_message'); ?>	
								</span>
							</div>
							<div class="tools">
							<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()"></a>
							</div>
						</div>	
						<div class="portlet-body">
						    <!-- serach form starts here-->
            			    <form action="<?php echo base_url().index_page().'new_csr/home/web_cshift/category' ?>" method="get">
                				<div class="form-group row">
                				<div class="col-sm-6" >
                				    <div class="col-sm-3">
                				        <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="no_of_cat_webad_order" id="no_of_cat_webad_order" onchange="getOrderList('category')">
                                          <option selected value="">select</option>
                                          <option value="10" <?php if($this->session->userdata('no_of_cat_webad_order') == '10'){echo 'selected';}?> >10</option>
                                          <option value="25" <?php if($this->session->userdata('no_of_cat_webad_order') == '25'){echo 'selected';}?> >25</option>
                                          <option value="50" <?php if($this->session->userdata('no_of_cat_webad_order') == '50'){echo 'selected';}?> >50</option>
                                          <option value="100" <?php if($this->session->userdata('no_of_cat_webad_order') == '100'){echo 'selected';}?>>100</option>
                                        </select>
                				    </div>
                				   
                				</div>
                					<div class="col-sm-3">
                						<input type="text" id="web_category_search" name="web_category_search" value="<?php if($this->session->userdata("web_search_val") !== "" ){echo $this->session->userdata("web_search_val");}?>" placeholder="Search here" class="form-control">
                					</div>
                					<div class="col-sm-1">
                						<input type="submit" value="Search" class="btn btn-primary">
                					</div>
                					<div class="col-sm-1">
                						<button type="button" class="btn btn-warning" onclick="unset_webad_sess()">Reset</button>
                					</div>
                				</div>
            			    </form>
            			    <!-- serach form ends here-->
							<table class="table table-striped table-bordered table-hover" id="web_cat_tbl">
							<thead>
							  <tr>
								<th style="vertical-align: middle;" id="created_on">Date</th>
								<!--<th style="vertical-align: middle;">Type</th>-->
								<th style="vertical-align: middle;" id="order_id">AdwitAds ID</th>
								<th style="vertical-align: middle;">Unique Job Name</th>
								<th style="vertical-align: middle;" id="adreps">Adrep</th>
								<th style="vertical-align: middle;" id="publications">Publication</th>						
								<th style="text-align: middle;">View</th>
							  </tr>              
							</thead>
							<tbody name="testTable" id="testTable">
				<?php 
						$i=1;
						if($order_list != false){
						foreach($order_list as $row1)
						{	$form = $row1['help_desk'];
							//$order_type = $this->db->get_where('orders_type',array('id' => $row1['order_type_id']))->result_array();
							//$publication = $this->db->query("SELECT `name` FROM `publications` WHERE `id`='".$row1['publication_id']."' ;")->result_array();		
							//$adreps = $this->db->query("SELECT `first_name` FROM `adreps` WHERE `id`='".$row1['adrep_id']."' ;")->result_array();
							//$cat_result = $this->db->get_where('cat_result',array('order_no' => $row1['id']))->result_array();
							
									
				?>
					 <tr <?php if($row1['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="bg-red-pink"'; } ?>>

				<!-- date -->			<td><?php $date = strtotime($row1['created_on']); echo date('d-M', $date); ?></td>

				<!-- type -->		<!--	<td title="<?php echo'web'; ?>"><span class="badge bg-blue"><?php echo "W"; ?></span></td>-->

				<!-- order_no --> 		<td>
				                            <a <?php if($row1['rush']==1){ echo "class='font-grey-cararra'";} ?>  href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;">
				                                <?php echo $row1['id']; ?>
				                            </a>
				                        </td>

				<!-- job_name -->		<td><?php echo $row1['job_no']; ?></td>

				<!-- adrep -->	        <td><?php echo $row1['first_name'];  ?></td>

				<!-- Publication -->	<td><?php echo $row1['name']; ?></td>

				<!-- category -->		<td>
				                            <a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;">
				                                <button class="btn blue btn-xs" >view</button>
				                            </a>
				                            <?php 
    				                            if($row1['crequest']=='1'){
    				                                echo" Cancel Request Sent";
    				                            }elseif($row1['question']=='1'){
    				                                echo" Question Sent";
    				                            }elseif($row1['question']=='2'){
    				                                echo" Question Answered";
    				                            } 
				                            ?>
				                        </td>
				                <!--        <?php if(($cat_result && $cat_result[0]['cancel']!='0') || $row1['cancel']!='0'){ 
												echo'<td>Cancelled</td>';
											}elseif(!$cat_result){?>
											<td><a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;"><button class="btn blue btn-xs" >view</button></a><?php if($row1['crequest']=='1'){echo" Cancel Request Sent";}elseif($row1['question']=='1'){echo" Question Sent";}elseif($row1['question']=='2'){echo" Question Answered";} ?></td>
										 <?php } ?>
										 -->
					</tr>
				   <?php $i++; }} ?>
							</tbody>
							</table>
							<p><?php echo $web_cat_links; ?></p>
							<p><?php echo $web_cat_result; ?></p>
						</div>
					</div>
				</div>
         </div>
		<?php } ?>
		<!--web_cshift_category-->
		 
		<!--web_cshift_QA-->
		 <?php if($display_type=='QA') { ?>
		 <div class="row">
            <div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cogs font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold">QA Pending List</span>
								<span style="margin-left: 20px; padding: 0 10px;" class="font-blue">
										<?php echo $this->session->flashdata('sucess_message'); ?>	
										<?php echo $this->session->flashdata('message'); ?>
								</span>
							</div>
							<div class="tools">
								<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()"></a>
							</div>
						</div>
						<div class="portlet-body">
						 <!-- serach form starts here-->
            			    <form action="<?php echo base_url().index_page().'new_csr/home/web_cshift/QA' ?>" method="get">
                				<div class="form-group row">
                				<div class="col-sm-6" >
                				    <div class="col-sm-3">
                				        <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="no_of_web_qa_order" id="no_of_web_qa_order" onchange="getOrderList('QA')">
                                          <option selected value="">select</option>
                                          <option value="10" <?php if($this->session->userdata('no_of_web_qa_order') == '10'){echo 'selected';}?> >10</option>
                                          <option value="25" <?php if($this->session->userdata('no_of_web_qa_order') == '25'){echo 'selected';}?> >25</option>
                                          <option value="50" <?php if($this->session->userdata('no_of_web_qa_order') == '50'){echo 'selected';}?> >50</option>
                                          <option value="100" <?php if($this->session->userdata('no_of_web_qa_order') == '100'){echo 'selected';}?>>100</option>
                                        </select>
                				    </div>
                				   
                				</div>
                					<div class="col-sm-3">
                						<input type="text" id="web_qa_search" name="web_qa_search" value="<?php if($this->session->userdata("web_qa_search_val") !== "" ){echo $this->session->userdata("web_qa_search_val");}?>" placeholder="Search here" class="form-control">
                					</div>
                					<div class="col-sm-1">
                						<input type="submit" value="Search" class="btn btn-primary">
                					</div>
                					<div class="col-sm-1">
                						<button type="button" class="btn btn-warning" onclick="unset_webqa_sess()">Reset</button>
                					</div>
                				</div>
            			    </form>
            			    <!-- serach form ends here-->   
						<table class="table table-striped table-bordered table-hover" id="web_qa_tbl">
							<thead>
							  <tr>
								<th style="vertical-align: middle;" id="created_on">Date</th>
								<th style="vertical-align: middle;" id="type">Type</th>
								<th style="vertical-align: middle;" id="order_id">AdwitAds ID</th>
								<th style="vertical-align: middle;">Unique Job Name</th>
								<th style="vertical-align: middle;" id="adreps">Adrep</th>
								<th style="vertical-align: middle;" id="publications">Publication</th>										
								<th style="text-align: center;">QA</th>
							  </tr>              
							</thead>
							<tbody name="testTable" id="testTable">
				<?php 
				        if($order_list != false){
						foreach($order_list as $row)
						{	$form = $row['help_desk'];
							//$cat_result = $this->db->get_where('cat_result',array('order_no'=>$row['id'], 'pro_status'=>'3'))->result_array();
							/*
							$cat_result = $this->db->query("SELECT * FROM `cat_result` 
							                                WHERE `order_no` = '".$row['id']."' AND `pro_status` = '3' 
							                                AND (`csr_QA`='".$csr[0]['id']."' OR `csr_QA` = '0')")->result_array();
							                                */
							if(isset($row['catId']))
							{
								//$order_type = $this->db->get_where('orders_type',array('id' => $row['order_type_id']))->result_array();
								//$publication_name = $this->db->query("SELECT `name` FROM `publications` WHERE `id`='".$row['publication_id']."' ;")->result_array();		
								//$adreps = $this->db->query("SELECT `first_name` FROM `adreps` WHERE `id`='".$row['adrep_id']."' ;")->result_array();
				?>
							  <tr <?php if($row['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="bg-red-pink"'; } ?>>

				<!-- date -->			<td><?php $date = strtotime($row['timestamp']); echo date('d-M', $date); ?></td>

				<!-- type -->			<td title="<?php echo'web'; ?>"><span class="badge bg-blue"><?php echo "W"; ?></span></td>

				<!-- order_no --> 		<td title="OrderView"><a <?php if($row['rush']==1){ echo "class='font-grey-cararra'";} ?>  href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;"><?php echo $row['id']; ?></a></td>

				<!-- job_name -->		<td><?php echo $row['job_no']; ?></td>

				<!-- adreps -->			<td><?php echo $row['first_name']; ?></td>

				<!-- newspaper -->		<td><?php echo $row['name']; ?></td>
								   
				<!-- QA -->            	<td>
				                            <a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;">
				                                <button class="btn blue btn-xs" >QA</button>
				                            </a>
											<?php 
											    if($row['csr_QA'] == $csr[0]['id']) { 
												    echo '<i class="fa fa-flag"></i>';
											    } else { echo ' '; } 
											?>
										</td>     

							  </tr>
				   <?php  } }} ?>
							</tbody>
						  </table>
						  <p><?php echo $web_qa_links; ?></p>
						  <p><?php echo $web_qa_result; ?></p>
						</div>
					</div>
				</div>
                </div>
		 <?php } ?>
		<!--web_cshift_QA-->
		 
		<!--web_cshift_new_pending-->
		 <?php if($display_type=='new_pending') { ?>
		 <div class="row">
        <div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cogs font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold">All Pending List</span>
								<span style="margin-left: 20px; padding: 0 10px;" class="font-blue">
										<?php echo $this->session->flashdata('sucess_message'); ?>	
										<?php echo $this->session->flashdata('message'); ?>
								</span>
							</div>
							<div class="tools">
							<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()"></a>
							</div>
						</div>
						<div class="portlet-body">
						    <!-- serach form starts here-->
            			    <form action="<?php echo base_url().index_page().'new_csr/home/web_cshift/new_pending' ?>" method="get">
                				<div class="form-group row">
                				<div class="col-sm-6" >
                				    <div class="col-sm-3">
                				        <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="no_of_web_newpending_order" id="no_of_web_newpending_order" onchange="getOrderList('new_pending')">
                                          <option selected value="">select</option>
                                          <option value="10" <?php if($this->session->userdata('no_of_web_newpending_order') == '10'){echo 'selected';}?> >10</option>
                                          <option value="25" <?php if($this->session->userdata('no_of_web_newpending_order') == '25'){echo 'selected';}?> >25</option>
                                          <option value="50" <?php if($this->session->userdata('no_of_web_newpending_order') == '50'){echo 'selected';}?> >50</option>
                                          <option value="100" <?php if($this->session->userdata('no_of_web_newpending_order') == '100'){echo 'selected';}?>>100</option>
                                        </select>
                				    </div>
                				   
                				</div>
                					<div class="col-sm-3">
                						<input type="text" id="web_newpending_search" name="web_newpending_search" value="<?php if($this->session->userdata("web_newpending_search_val") !== "" ){echo $this->session->userdata("web_newpending_search_val");}?>" placeholder="Search here" class="form-control">
                					</div>
                					<div class="col-sm-1">
                						<input type="submit" value="Search" class="btn btn-primary">
                					</div>
                					<div class="col-sm-1">
                						<button type="button" class="btn btn-warning" onclick="unset_web_newpending_sess()">Reset</button>
                					</div>
                				</div>
            			    </form>
            			    <!-- serach form ends here-->
							<table class="table table-striped table-bordered table-hover" id="web_new_tbl"> 
								 <thead>
								<tr>
									<th style="vertical-align: middle;" id="created_on">Date</th>
									<th style="vertical-align: middle;" id="type">Type</th>
									<th style="vertical-align: middle;" id="order_id">AdwitAds ID</th>
									<th style="vertical-align: middle;">Unique Job Name</th>
									<th style="vertical-align: middle;" id="order_id">Adrep</th>
									<th style="vertical-align: middle;" id="publications">Publication</th>
									<th style="vertical-align: middle;">Status</th>
								</tr>              
								</thead>
								<tbody name="testTable" id="testTable">
					<?php 
					        if($order_list != false){
							foreach($order_list as $row1)
							{	$form = $row1['help_desk'];
								//$order_type = 	$this->db->get_where('orders_type',array('id' => $row1['order_type_id']))->result_array();
								//$publication = $this->db->query("SELECT `name` FROM `publications` WHERE `id`='".$row1['publication_id']."' ;")->result_array();		
								//$adreps = $this->db->query("SELECT `first_name` FROM `adreps` WHERE `id`='".$row1['adrep_id']."' ;")->result_array();
								//$order_status = $this->db->get_where('order_status',array('id'=>$row1['status']))->result_array();
					?>
								  <tr <?php if($row1['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="bg-red-pink"'; } ?>>
					<!-- Date -->			<td><?php $date = strtotime($row1['created_on']); echo date('d-M', $date); ?></td>
					<!-- type -->			<td title="<?php echo'web'; ?>"><span class="badge bg-blue"><?php echo "W"; ?></span></td>
					<!-- Order_no --> 		<td title="view attachments"><a <?php if($row1['rush']==1){ echo "class='font-grey-cararra'";} ?>  href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;"><?php echo $row1['id']; ?></a></td>

					<!-- Job_name -->		<td><?php echo $row1['job_no']; ?></td>
					<!-- adrep -->		<td><?php echo $row1['first_name']; ?></td>
					<!-- Newspaper -->		<td><?php echo $row1['name']; ?></td>

					<!-- Status -->			<?php if($row1['status']=='1') { ?><td <?php if($row1['question']=='1') { echo "class='danger'";} if($row1['question']=='2') { echo "class='success '";} ?>><a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;" ><button class="btn blue btn-xs" ><?php echo $row1['d_name']; ?></button></a></td><?php } ?>
					<!-- Status -->			<?php if($row1['status']=='2') { ?><td <?php if($row1['question']=='1') { echo "class='danger'";} if($row1['question']=='2') { echo "class='success '";} ?>><a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;"><button class="btn blue btn-xs" ><?php echo $row1['d_name']; ?></button></a></td><?php } ?>
					<!-- Status -->			<?php if($row1['status']=='3') { ?><td <?php if($row1['question']=='1') { echo "class='danger'";} if($row1['question']=='2') { echo "class='success '";} ?>><a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;"><button class="btn blue btn-xs" ><?php echo $row1['d_name']; ?></button></a></td><?php } ?>
					<!-- Status -->			<?php 
					                            if($row1['status']=='4') { ?>
					                                <td <?php if($row1['question']=='1') { echo "class='danger'";} if($row1['question']=='2') { echo "class='success '";} ?>>
					                                    <a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;">
					                                        <button class="btn blue btn-xs" ><?php echo $row1['d_name']; ?></button>
					                                    </a>
        												<?php 
        												    $cat_result = $this->db->query("SELECT cat_result.id, cat_result.csr_QA, csr.name FROM `cat_result`
        												                                    RIGHT JOIN `csr` ON cat_result.csr_QA = csr.id
        												                                    WHERE cat_result.order_no = '".$row1['id']."' AND cat_result.pro_status = '3'")->row_array();
        												  if(isset($cat_result['name'])){ echo $cat_result['name']; } 
        												?>
        											</td>
											<?php } ?>
									
								  </tr>
					   <?php  }} ?>
								</tbody>
							</table>
							<p><?php echo $web_new_links; ?></p>
							<p><?php echo $web_new_result; ?></p>
						</div>
					</div>
				</div>
                </div>
		 <?php } ?>
		<!--web_cshift_new_pending-->
        
		</div>
</div>
</div>
	<!-- END PAGE CONTENT -->
</div>

<form method = "POST" action="<?php echo base_url().index_page().'new_csr/home/web_cshift/category';?>" id="web_cat_form"> 
<input id="c_web_order_by" name ="c_web_order_by" hidden>
<input id="c_web_sort_by" name="c_web_sort_by" hidden>
</form>
<form method = "POST" action="<?php echo base_url().index_page().'new_csr/home/web_cshift/QA';?>" id="web_qa_form"> 
<input id="c_qa_order_by" name ="c_qa_order_by" hidden>
<input id="c_qa_sort_by" name="c_qa_sort_by" hidden>
</form>
<form method = "POST" action="<?php echo base_url().index_page().'new_csr/home/web_cshift/new_pending';?>" id="web_new_pending_form"> 
<input id="c_new_order_by" name ="c_new_order_by" hidden>
<input id="c_new_sort_by" name="c_new_sort_by" hidden>
</form>

<!-- END PAGE CONTAINER -->
<?php $this->load->view("new_csr/foot"); ?>

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
    
    function unset_webad_sess(){
        $.ajax({
        type: 'POST',
        url: "<?php echo base_url().index_page().'new_csr/home/unset_webad_sess';?>",
        success: function(response) {
        sessionStorage.removeItem('web_c_columnIndex');
        sessionStorage.removeItem('web_c_sort_by');
        var dataTable = $('#web_cat_tbl').DataTable();
        dataTable.state.clear(); // Clear the saved state
        dataTable.draw(); // Redraw the DataTable
        // Redirect the user to the new location
        window.location.href = "<?php echo base_url() . index_page() . 'new_csr/home/web_cshift/category'; ?>";
        },
        error: function() {
        alert('Something went wrong!!');
        }
        });
    }
    function unset_webqa_sess(){
        $.ajax({
        type: 'POST',
        url: "<?php echo base_url().index_page().'new_csr/home/unset_webqa_sess';?>",
        success: function(response) {
        sessionStorage.removeItem('web_qa_columnIndex');
        sessionStorage.removeItem('web_qa_sort_by');
        var dataTable = $('#web_qa_tbl').DataTable();
        dataTable.state.clear(); // Clear the saved state
        dataTable.draw(); // Redraw the DataTable
        // Redirect the user to the new location
        window.location.href = "<?php echo base_url() . index_page() . 'new_csr/home/web_cshift/QA'; ?>";
        },
        error: function() {
        alert('Something went wrong!!');
        }
        });
    }
    function unset_web_newpending_sess(){
        $.ajax({
        type: 'POST',
        url: "<?php echo base_url().index_page().'new_csr/home/unset_web_newpending_sess';?>",
        success: function(response) {
        sessionStorage.removeItem('web_new_columnIndex');
        sessionStorage.removeItem('web_new_sort_by');
        var dataTable = $('#web_new_tbl').DataTable();
        dataTable.state.clear(); // Clear the saved state
        dataTable.draw(); // Redraw the DataTable
        // Redirect the user to the new location
        window.location.href = "<?php echo base_url() . index_page() . 'new_csr/home/web_cshift/new_pending'; ?>";
        },
        error: function() {
        alert('Something went wrong!!');
        }
        });
    }
    
    function getOrderList(order_type){
	  var order_type = order_type;
	  if(order_type == "category"){
	     var no_of_order = $("#no_of_cat_webad_order").val();  
	  }else if (order_type == "new_pending"){
	     var no_of_order = $("#no_of_web_newpending_order").val();   
	  }else if(order_type == "QA"){
	     var no_of_order = $("#no_of_web_qa_order").val(); 
	  }
	  var dataString = "no_of_order="+no_of_order+"&order_type="+order_type;
    	$.ajax({
    		url: "<?php echo base_url().index_page().'new_csr/home/web_cshift/';?>"+order_type,
    		type: 'POST',
    		data: dataString,
            success: function(response) {
                // Redirect the user to the new location
                window.location.href = "<?php echo base_url() . index_page() . 'new_csr/home/web_cshift/'; ?>"+order_type;
            },
            error: function() {
                alert('Something went wrong!!');
            }
        }); 
        
	}
	
var web_c_columnIndex = sessionStorage.getItem('web_c_columnIndex') || "";
var web_c_sort_by = sessionStorage.getItem('web_c_sort_by') || "";

var web_qa_columnIndex = sessionStorage.getItem('web_qa_columnIndex') || "";
var web_qa_sort_by = sessionStorage.getItem('web_qa_sort_by') || "";

var web_new_columnIndex = sessionStorage.getItem('web_new_columnIndex') || "";
var web_new_sort_by = sessionStorage.getItem('web_new_sort_by') || "";


$(document).ready(function() {
     // Initialize DataTable
    var dataTable = $('#category_tbl').DataTable({
        destroy: true,
        stateSave: true,
        order: (web_c_columnIndex !== "" && web_c_sort_by !== "") ? [[parseInt(web_c_columnIndex), web_c_sort_by]] : [[0, 'desc']],
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
        $("#c_web_order_by").val(order_by);
        $("#c_web_sort_by").val(sort_by);
        // Save values to localStorage
        sessionStorage.setItem('web_c_columnIndex', columnIndex);
        sessionStorage.setItem('web_c_sort_by', sort_by);
        $("#web_cat_form").submit();
    });
    
    var dataTable = $('#web_qa_tbl').DataTable({
        destroy: true,
        stateSave: true,
        order: (web_qa_columnIndex !== "" && web_qa_sort_by !== "") ? [[parseInt(web_qa_columnIndex), web_qa_sort_by]] : [[0, 'desc']],
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
    $('#web_qa_tbl thead th').click(function () {
        // Get column index
        // Get column id
        var columnId = $(this).attr('id');
         var order = dataTable.order();
         order_by = ('Column ID: ', columnId);
         sort_by = ('Sorting Direction: ', order[0][1]);
         var columnIndex = order[0][0];
        $("#c_qa_order_by").val(order_by);
        $("#c_qa_sort_by").val(sort_by);
        // Save values to localStorage
        sessionStorage.setItem('web_qa_columnIndex', columnIndex);
        sessionStorage.setItem('web_qa_sort_by', sort_by);
        $("#web_qa_form").submit();
    });
    
    var dataTable = $('#web_new_tbl').DataTable({
        destroy: true,
        stateSave: true,
        order: (web_new_columnIndex !== "" && web_new_sort_by !== "") ? [[parseInt(web_new_columnIndex), web_new_sort_by]] : [[0, 'desc']],
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
    $('#web_new_tbl thead th').click(function () {
        // Get column index
        // Get column id
        var columnId = $(this).attr('id');
         var order = dataTable.order();
         order_by = ('Column ID: ', columnId);
         sort_by = ('Sorting Direction: ', order[0][1]);
         var columnIndex = order[0][0];
        $("#c_new_order_by").val(order_by);
        $("#c_new_sort_by").val(sort_by);
        // Save values to localStorage
        sessionStorage.setItem('web_new_columnIndex', columnIndex);
        sessionStorage.setItem('web_new_sort_by', sort_by);
        $("#web_new_pending_form").submit();
    });
});

</script>