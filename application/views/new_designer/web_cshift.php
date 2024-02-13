<?php 
	$this->load->view("new_designer/head");
?>
<script>
    function getOrder(order_type){
	  var order_type = order_type;
	  if(order_type == "design_pending"){
	     var no_of_order = $("#pending_no_of_order").val();  
	  }else if (order_type == "upload_pending"){
	     var no_of_order = $("#upending_no_of_order").val();   
	  }
	  var dataString = "no_of_order="+no_of_order;
        // console.log(dataString);
    	$.ajax({
    		url: "<?php echo base_url().index_page().'new_designer/home/web_cshift/';?>"+order_type,
    		type: 'POST',
    		data: dataString,
            success: function(response) {
                // Redirect the user to the new location
                window.location.href = "<?php echo base_url() . index_page() . 'new_designer/home/web_cshift/'; ?>"+order_type;
            },
            error: function() {
                alert('Something went wrong!!');
            }
        }); 
        
	}
	 
	function unset_design_pending_session(){
	  $.ajax({
        type: 'POST',
		url: "<?php echo base_url().index_page().'new_designer/home/unset_design_pending_session';?>",
        success: function(response) {
            sessionStorage.removeItem('d_columnIndex');
            sessionStorage.removeItem('d_sort_by');
            var dataTable = $('#design_pending_tbl').DataTable();
            dataTable.state.clear(); // Clear the saved state
            dataTable.draw(); // Redraw the DataTable
            // Redirect the user to the new location
            window.location.href = "<?php echo base_url() . index_page() . 'new_designer/home/web_cshift/design_pending'; ?>";
        },
        error: function() {
            alert('Something went wrong!!');
        }
    });  
	}
	
	function unset_udesign_pending_session(){
      $.ajax({
        type: 'POST',
    	url: "<?php echo base_url().index_page().'new_designer/home/unset_udesign_pending_session';?>",
        success: function(response) {
            sessionStorage.removeItem('wu_columnIndex');
            sessionStorage.removeItem('wu_sort_by');
            var dataTable = $('#w_upload_pending_tbl').DataTable();
            dataTable.state.clear(); // Clear the saved state
            dataTable.draw(); // Redraw the DataTable
            // Redirect the user to the new location
            window.location.href = "<?php echo base_url() . index_page() . 'new_designer/home/web_cshift/upload_pending'; ?>";
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
				<div class="col-lg-12 margin-top-15">
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
						<div class="collapse navbar-collapse navbar-ex1-collapse no-space">
							<ul class="nav navbar-nav">
								<?php if($designers[0]['designer_role'] == '3' || $designers[0]['designer_role'] == '1') { ?>
								<?php  if($display_type == 'upload_pending'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/web_cshift/upload_pending';?>">
									&nbsp; My Q <span class="badge bg-green"><?php echo $upload_count; ?></span></a>
								</li>
								<?php } if($designers[0]['designer_role'] == '3') { ?>
								<?php  if($display_type == 'design_pending'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/web_cshift/design_pending';?>">
									&nbsp; General Q <span class="badge bg-blue"> <?php echo $design_count; ?></span></a>
								</li>
								<?php } elseif($designers[0]['designer_role'] == '2') { ?>
								<?php  if($display_type == 'design_pending'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/web_cshift/design_pending';?>">
									&nbsp; Assign <span class="badge bg-blue"></span></a>
								</li>
								<?php } elseif($designers[0]['designer_role'] == '1') { ?>
								<?php  if($display_type == 'design_pending'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/web_cshift/design_pending';?>">
									&nbsp; General Q <span class="badge bg-blue"><?php echo count($orders);?></span></a>
								</li>
								<?php } if($designers[0]['designer_role'] == '1' || $designers[0]['designer_role'] == '2') { ?>
								<?php  if($display_type == 'web_design_check'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/web_cshift/web_design_check';?>">
									&nbsp; Design Check</a> 
								</li>
								<?php } if($designers[0]['designer_role'] == '1' || $designers[0]['designer_role'] == '2') { ?>
								<?php  if($display_type == 'web_all_pending'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/web_cshift/web_all_pending';?>">
									&nbsp; All Pending</span></a> 
								</li>
								<?php } ?>
							</ul>
						</div> 
					</div>
				</div>
			</div>
			<!--web_cshift Design pending-->       
		<?php 
			echo '<h5 style="color:#900;">'.$this->session->flashdata('message').'</h5>'; 
			if($display_type =='design_pending') { 
		?>
			<div class="row">
				<div class="col-md-12">
					<!--<form Method="POST" onsubmit="return myFunction(this)">-->
					<form Method="POST">
						<div class="portlet light">
							<div class="portlet-title">
								<div class="caption">
									<?php if($designers[0]['designer_role'] == '2') { ?>
									<span class="caption-subject font-green-sharp bold uppercase">Assign</span>
									<?php }elseif($designers[0]['designer_role'] == '3') { ?>
									<span class="caption-subject font-green-sharp bold uppercase">Design Pending<?php echo "(".$design_count.")";?></span>
									<?php }elseif($designers[0]['designer_role'] == '1') { ?>
									<span class="caption-subject font-green-sharp bold uppercase">Design Pending<?php echo "(".count($orders).")";?></span>
									<?php } ?>
								</div>
								<div class="tools">
								<?php  if($designers[0]['designer_role'] == '1' || $designers[0]['designer_role'] == '2') { 
									$design_assign = $this->db->get_where('design_assign')->result_array();		
									foreach($design_assign as $result){ ?>
									<button class="btn green-haze btn-circle btn-sm" type="submit" name="submit"  value="<?php echo $result['id']; ?>"><?php echo $result['name']; ?></button>
								<?php } } ?>
								<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()"></a>
								</div>
							</div>
							<div class="portlet-body">
							    <!-- serach form starts here-->
                			    <form action="<?php echo base_url().index_page().'new_designer/home/web_cshift/design_pending' ?>" method="post">
                    				<div class="form-group row">
                    				<div class="col-sm-6">
                    				    <div class="col-sm-3">
                    				        <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="pending_no_of_order" id="pending_no_of_order" onchange="getOrder('design_pending')">
                                              <option selected value="">select</option>
                                              <option value="10" <?php if($this->session->userdata('pending_no_of_orders') == '10'){echo 'selected';}?> >10</option>
                                              <option value="25" <?php if($this->session->userdata('pending_no_of_orders') == '25'){echo 'selected';}?> >25</option>
                                              <option value="50" <?php if($this->session->userdata('pending_no_of_orders') == '50'){echo 'selected';}?> >50</option>
                                              <option value="100" <?php if($this->session->userdata('pending_no_of_orders') == '100'){echo 'selected';}?>>100</option>
                                            </select>
                    				    </div>
                    				   
                    				</div>
                    					<div class="col-sm-3">
                    						<input type="text" id="design_pending_search" name="design_pending_search" value="<?php if($this->session->userdata("pending_search_val") !== "" ){echo $this->session->userdata("pending_search_val");}?>" placeholder="Search here" class="form-control">
                    					</div>
                    					<div class="col-sm-1">
                    						<input type="submit" value="Search" class="btn btn-primary">
                    					</div>
                    					<div class="col-sm-1">
                    						<button type="button" class="btn btn-warning" onclick="unset_design_pending_session()">Reset</button>
                    					</div>
                    				</div>
                			    </form>
                			    <!-- serach form ends here-->
								<table class="table table-striped table-bordered table-hover" id="design_pending_tbl">
									<thead>
										<tr>
											<th id="created_on">Date</th>
											<th id="type">Type</th>
											<th id="order_id">AdwitAds ID</th>
											<th>Unique Job Name</th>
											<th id="adreps">Adrep</th>
											<th id="publication">Publication</th>
											<?php //if($form=='5')echo '<th style="vertical-align: middle;">Design Team</th>'; ?>
											<th id="category">Category</th>
											<th id="ad_type">Ad Type</th>
											<th>Format</th>
										<?php if($designers[0]['designer_role'] == '1' || $designers[0]['designer_role'] == '2'){?>
											<!--<th>Assign</th>-->
											<th>DT</th>
											<!--<th>Designer Assign</th>-->
										<?php } ?>
											<?php if($designers[0]['designer_role'] != '2'){?>
											<th>Design</th><?php } ?>
											<th id="priority">Priority</th>
										</tr>
									</thead>
									<tbody name="testTable" id="testTable">
			<?php 
            if(isset($orders) && $orders !=false){
			foreach($orders as $row1)
			{
				$form = $row1['help_desk'];
				$order_type = 	$this->db->get_where('orders_type',array('id' => $row1['order_type_id']))->result_array();
				//$cat_result = $this->db->query("SELECT * FROM `designers`,`cat_result` WHERE `order_no`='".$row1['id']."' AND designers.id = cat_result.designer ")->result_array();
				$cat_result = $this->db->get_where('cat_result',array('order_no' => $row1['id']))->result_array();
				$publication = $this->db->query("SELECT publications.*, time_zone.priority AS time_zone_priority FROM `publications`
				                                    JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
				                                    WHERE publications.id='".$row1['publication_id']."'")->result_array();
				$adreps = $this->db->query("SELECT `first_name` FROM `adreps` WHERE `id`='".$row1['adrep_id']."' ;")->result_array();
				$designer = $this->db->get_where('designers',array('id' => $cat_result[0]['designer']))->result_array();
				$format = $this->db->query("SELECT `name` FROM `web_ad_formats` WHERE id='".$row1['ad_format']."'")->row_array();
				$dteam = $this->db->get_where('publications',array('id' => $row1['publication_id']))->result_array();
				$dteam_name = $this->db->get_where('design_teams',array('id' => $dteam[0]['design_team_id']))->result_array();
				if($cat_result && $cat_result[0]['cancel']=='0' && $cat_result[0]['pdf_path']=='none' && ($cat_result[0]['tag_designer'] == $dId || $cat_result[0]['tag_designer'] == '0') && ($designers[0]['designer_role'] == '3') ||  $designers[0]['designer_role'] == '4') { ?>				
								<tr <?php if($row1['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="bg-red-pink"'; } ?>>

			<!-- date -->			<td><?php $date = strtotime($row1['created_on']); echo date('d-M', $date); ?></td>
			<!-- type -->			<td title="<?php echo $order_type[0]['name']; ?>"><button type="button" class="btn blue-steel btn-sm"><?php if($order_type[0]['value']=='print') {echo "P";} elseif($order_type[0]['value']=='web'){ echo "W";} else{ echo "P&W";}?></button></td>
			<!-- Adwit Id -->		<td title="view attachments"><a <?php if($row1['rush']==1){ echo "class='font-grey-cararra'";} ?> href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_designer/home/orderview/'.$form.'/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;"><?php echo $row1['id']; ?></a></td>							
			<!-- job_name -->		<td><?php echo $row1['job_no']; ?></td>
			<!-- adrep -->			<td><?php echo $adreps[0]['first_name']; ?></td>
			<!-- Publication -->	<td><?php echo $publication[0]['name']; ?></td>

			<!-- design team -->	<?php //if($form=='5' && $publication[0]['design_team_id']=='4'){echo "<td>D6</td>";}elseif($form=='5' && $publication[0]['design_team_id']=='5'){ echo "<td>D7</td>"; } ?>

			<!-- Category -->		<td <?php if($row1['question']=='1') { echo 'class="danger"'; } if($row1['question']=='2') { echo 'class="success"'; } ?>><?php if($cat_result && $row1['rush']=='1'){ //rushad
										echo $cat_result[0]['category'].'<span style="display:none;">rush</span>';
										}elseif($cat_result){echo $cat_result[0]['category'];}else{echo 'Pending';} ?>
									</td>
								
									<td><?php echo $row1['web_ad_type']; ?></td>
										<td>	<?php  echo $dteam_name[0]['name']; ?></td>
									<td><?php if(isset($format['name'])) echo $format['name']; ?></td>
			
					
			<!-- Design -->			<?php if($designers[0]['designer_role'] != '2'){?>
									<td>
										<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_designer/home/orderview/'.$form.'/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;"><button type="button" class="btn green-jungle btn-sm">Start Design</button></a>
										
										<?php if($cat_result && $designer){ echo $designer[0]['username'];} ?>
										<?php if($cat_result[0]['tag_designer'] == $dId) { ?>
											<i class="fa fa-flag"></i>
										<?php } else { echo ' '; } ?>
									</td>
									<td><?php echo $publication[0]['time_zone_priority']; ?></td>
									<?php } ?>
								</tr>
			<?php } elseif($designers[0]['designer_role'] == '1' || $designers[0]['designer_role'] == '2') { ?>
								<tr <?php if($row1['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="bg-red-pink"'; } ?>>

			<!-- date -->			<td><?php $date = strtotime($row1['created_on']); echo date('d-M', $date); ?></td>
			<!-- type -->			<td title="<?php echo $order_type[0]['name']; ?>"><button type="button" class="btn blue-steel btn-sm"><?php if($order_type[0]['value']=='print') {echo "P";} elseif($order_type[0]['value']=='web'){ echo "W";} else{ echo "P&W";}?></button></td>
			<!-- Adwit Id -->		<td title="view attachments"><a <?php if($row1['rush']==1){ echo "class='font-grey-cararra'";} ?> href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_designer/home/orderview/'.$form.'/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;"><?php echo $row1['id']; ?></a></td>							
			<!-- job_name -->		<td><?php echo $row1['job_no']; ?></td>
			<!-- adrep -->			<td><?php echo $adreps[0]['first_name']; ?></td>
			<!-- Publication -->	<td><?php echo $publication[0]['name']; ?></td>

			<!-- design team -->	<?php //if($form=='5' && $publication[0]['design_team_id']=='4'){echo "<td>D6</td>";}elseif($form=='5' && $publication[0]['design_team_id']=='5'){ echo "<td>D7</td>"; } ?>

			<!-- Category -->		<td <?php if($row1['question']=='1') { echo 'class="danger"'; } if($row1['question']=='2') { echo 'class="success"'; } ?>><?php if($cat_result && $row1['rush']=='1'){ //rushad
												echo $cat_result[0]['category'].'<span style="display:none;">rush</span>';
											}elseif($cat_result){echo $cat_result[0]['category'];}else{echo 'Pending';} ?>
									</td>
									<td><?php echo $row1['web_ad_type']; ?></td>
									<td><?php if(isset($format['name'])) echo $format['name']; ?></td>
			<!-- Designer Assign -->
									<?php if($designers[0]['designer_role'] == '1' || $designers[0]['designer_role'] == '2'){?>
									<!--
									<td> 
									<?php 
									if($cat_result[0]['assign']!='0') {
									    $design_assign_name = 	$this->db->get_where('design_assign',array('id' => $cat_result[0]['assign']))->result_array(); 
									    echo $design_assign_name[0]['name'];
									} else { 
									?>
										<input type="checkbox" name="assign[]" id="assign[]" value="<?php echo $cat_result[0]['id']; ?>">
										<input name="cat_id" value="<?php echo $cat_result[0]['id']; ?>" hidden />
									<?php } ?>
									</td>
									-->
										<td>	<?php  echo $dteam_name[0]['name']; ?></td>
									<!--<td>
										<?php if($cat_result[0]['tag_designer']=='0'){ ?>
										<input type="checkbox" name="assign_designer[]" id="assign_designer[]" value="<?php echo $cat_result[0]['id']; ?>">
										<?php }else{ 
										$cat_designer_name = $this->db->get_where('designers',array('id' => $cat_result[0]['tag_designer']))->result_array();
										echo $cat_designer_name[0]['username']; } ?>
									</td>-->
									<?php } ?>
									
			<!-- Design -->		    <?php if($designers[0]['designer_role'] != '2') { ?>
									<td>
										<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_designer/home/orderview/'.$form.'/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;"><button type="button" class="btn green-jungle btn-sm">Start Design</button></a>
										
										<?php if($cat_result && $designer){ echo $designer[0]['username'];} ?>
										<?php if($cat_result[0]['tag_designer'] == $dId) { ?>
											<i class="fa fa-flag"></i>
										<?php } else { echo ' '; } ?>
									</td>
									<?php } ?>
									<td><?php echo $publication[0]['time_zone_priority']; ?></td>
								</tr>
			<?php } } }?>
							<?php if($designers[0]['designer_role'] == '1' || $designers[0]['designer_role'] == '2'){?>
							<?php if((isset($tag_designer_teamlead) && count($tag_designer_teamlead) > '0')) { foreach($tag_designer_teamlead as $tag_row){ 
									$designer_name = $this->db->query("SELECT * FROM `designers` WHERE `id` = '".$tag_row['designer_id']."' ")->result_array(); ?>
								<button class="btn green-haze btn-circle btn-sm" type="submit" name="submit_designer"  value="<?php echo $tag_row['designer_id']; ?>"><?php if(isset($designer_name)) { echo $designer_name[0]['username'];  }?></button>
							<?php } } }?>
								</tbody>
							</table>
							<p><?php echo $design_pending_links; ?></p>
							</div>
						</div>
					</form>
				</div>
			</div>
			<?php } ?>
			<!--web_cshift Design pending-->

			<!--web_cshift Upload pending-->		
			<?php if($display_type =='upload_pending') { ?>
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-green-sharp bold uppercase">upload Pending</span>
							</div>
							<div class="tools">
							<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()"></a>
							</div>
						</div>
						<div class="portlet-body">
						    <!-- serach form starts here-->
                			    <form action="<?php echo base_url().index_page().'new_designer/home/web_cshift/upload_pending' ?>" method="post">
                    				<div class="form-group row">
                    				<div class="col-sm-6">
                    				    <div class="col-sm-3">
                    				        <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="upending_no_of_order" id="upending_no_of_order" onchange="getOrder('upload_pending')">
                                              <option selected value="">select</option>
                                              <option value="10" <?php if($this->session->userdata('upending_no_of_orders') == '10'){echo 'selected';}?> >10</option>
                                              <option value="25" <?php if($this->session->userdata('upending_no_of_orders') == '25'){echo 'selected';}?> >25</option>
                                              <option value="50" <?php if($this->session->userdata('upending_no_of_orders') == '50'){echo 'selected';}?> >50</option>
                                              <option value="100" <?php if($this->session->userdata('upending_no_of_orders') == '100'){echo 'selected';}?>>100</option>
                                            </select>
                    				    </div>
                    				   
                    				</div>
                    					<div class="col-sm-3">
                    						<input type="text" id="udesign_pending_search" name="udesign_pending_search" value="<?php if($this->session->userdata("upending_search_val") !== "" ){echo $this->session->userdata("upending_search_val");}?>" placeholder="Search here" class="form-control">
                    					</div>
                    					<div class="col-sm-1">
                    						<input type="submit" value="Search" class="btn btn-primary">
                    					</div>
                    					<div class="col-sm-1">
                    						<button type="button" class="btn btn-warning" onclick="unset_udesign_pending_session()">Reset</button>
                    					</div>
                    				</div>
                			    </form>
                			  <!-- serach form ends here-->
							<table class="table table-striped table-bordered table-hover" id="w_upload_pending_tbl">
								<thead>
									<tr>
										<th id="created_on">Date</th>
										<th id="type">Type</th>
										<th id="order_id">AdwitAds ID</th>
										<th>Unique Job Name</th>
										<th id="adreps">Adrep</th>
										<th id="publication">Publication</th>
										<?php //if($form=='5')echo '<th style="vertical-align: middle;">Design Team</th>'; ?>
										<th id="category">Category</th>
										<th>Status</th>
										<th id="priority">Priority</th>
									</tr>
								</thead>
								<tbody name="testTable" id="testTable">
			<?php 
             if(isset($orders_upload) && $orders_upload != false){
			foreach($orders_upload as $row)
			{
				$form = $row['help_desk'];
				$cat_result = $this->db->query("SELECT * FROM `cat_result` WHERE `order_no`='".$row['id']."' AND `designer` ='".$this->session->userdata('dId')."'; ")->result_array();
			
				if($cat_result && ($cat_result[0]['pro_status']=='1' || $cat_result[0]['pro_status']=='3' || $cat_result[0]['pro_status']=='6' || $cat_result[0]['pro_status']=='7') && ($cat_result[0]['tag_designer'] == $dId || $cat_result[0]['tag_designer'] == '0'))
				{
					$order_type = 	$this->db->get_where('orders_type',array('id' => $row['order_type_id']))->result_array();
					//$cat_result = $this->db->query("SELECT * FROM `designers`,`cat_result` WHERE `order_no`='".$row1['id']."' AND designers.id = cat_result.designer ")->result_array();
					//$cat_result = $this->db->get_where('cat_result',array('order_no' => $row['id']))->result_array();
					$publication = $this->db->query("SELECT publications.*, time_zone.priority AS time_zone_priority FROM `publications`
				                                    JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
				                                    WHERE publications.id='".$row['publication_id']."'")->result_array();
					$adreps = $this->db->query("SELECT `first_name` FROM `adreps` WHERE `id`='".$row['adrep_id']."' ;")->result_array();
					$status = $this->db->query("SELECT * FROM `production_status` WHERE id='".$cat_result[0]['pro_status']."'")->result_array();
			?>
					<tr <?php if($row['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="bg-red-pink"'; } ?>>
			<!-- date -->		<td><?php $date = strtotime($row['created_on']); echo date('d-M', $date); ?></td>
			<!-- type -->		<td title="<?php echo $order_type[0]['name']; ?>"><button type="button" class="btn blue-steel btn-sm"><?php if($order_type[0]['value']=='print') {echo "P";} elseif($order_type[0]['value']=='web'){ echo "W";} else{ echo "P&W";}?></button></td>
			<!-- Adwit Id -->	<td title="view attachments">
								<a <?php if($row['rush']==1){ echo "class='font-grey-cararra'";} ?> href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_designer/home/orderview/'.$form.'/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;">
									<?php echo $row['id']; ?>
								</a>
							</td>							
			<!-- job_name -->	<td><?php echo $row['job_no']; ?></td>
			<!-- adrep -->		<td><?php echo $adreps[0]['first_name']; ?></td>
			<!-- Publication --><td><?php echo $publication[0]['name']; ?></td>

			<!-- design team --><?php //if($form=='5' && $publication[0]['design_team_id']=='4'){echo "<td>D6</td>";}elseif($form=='5' && $publication[0]['design_team_id']=='5'){ echo "<td>D7</td>"; } ?>

			<!-- Category -->	<td <?php if($row['question']=='1') { echo 'class="danger"'; } if($row['question']=='2') { echo 'class="success"'; } ?>>
							<!--rushad-->
								<?php  if($cat_result){echo $cat_result[0]['category'];}else{echo 'Pending';} ?>
							</td>
									
			<!-- Design -->		<td>
								<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_designer/home/orderview/'.$form.'/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;">
									<button class="btn blue-sunglo btn-xs"><?php if($status)echo $status[0]['name']; ?></button>
								</a>
							</td>
							<td><?php echo $publication[0]['time_zone_priority']; ?></td>
					</tr>
			<?php } }} ?>
								</tbody>
							</table>
							<p><?php echo $udesign_pending_links; ?></p>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
			<!--web_cshift Upload pending-->

			<!--web_cshift_design_check-->
			<?php if($display_type=='web_design_check') { ?>
				<div class="row">
					<div class="col-md-12">
						<div class="portlet light">
							<div class="portlet-title">
								<div class="tools">
								<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()"></a>
								</div>
							</div>
							<div class="portlet-body">
								<table class="table table-striped table-bordered table-hover" id="sample_6">
									<thead>
										<tr>
											<th>Date</th>
											<th>T</th>
											<th>AdwitAds ID</th>
											<th>Unique Job Name</th>
											<th>Adrep</th>
											<th>Publication</th>
											<th>DT</th>
											 <th>C</th>
											<th>Status</th>
											<th>Priority</th>
										</tr>  
									</thead>
									<tbody>
									<?php 
										foreach($orders_inproduction as $row){
											$form = $row['help_desk'];
											$cat_result = $this->db->query("SELECT * FROM `cat_result` WHERE `order_no`='".$row['id']."' AND (`pro_status` ='2' OR `pro_status` = '8'); ")->result_array();
											foreach($cat_result as $row1)
											{
												$order_type = $this->db->get_where('orders_type',array('id' => $row['order_type_id']))->result_array();
												$publication = $this->db->query("SELECT publications.*, time_zone.priority AS time_zone_priority FROM `publications`
				                                    JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
				                                    WHERE publications.id='".$row['publication_id']."'")->result_array();
												$adreps = $this->db->query("SELECT `first_name` FROM `adreps` WHERE `id`='".$row['adrep_id']."' ;")->result_array();
												$status = $this->db->get_where('production_status',array('id' => $row1['pro_status']))->result_array();				
												$dteam = $this->db->get_where('publications',array('id' => $row['publication_id']))->result_array();	 
												$dteam_name = $this->db->get_where('design_teams',array('id' => $dteam[0]['design_team_id']))->result_array();
										
									?>
										<tr <?php if($row['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="bg-red-pink"'; } ?>>
											<td><?php $date = strtotime($row['created_on']); echo date('d-M', $date); ?></td>
											<td title="<?php echo $order_type[0]['name']; ?>"><span class="badge bg-blue"><?php if($order_type[0]['id']=='1') {echo "W"; } if($order_type[0]['id']=='2') { echo "P"; } if($order_type[0]['id']=='3') { echo "P&W";}?></span></td>
											<td><a <?php if($row['rush']==1){ echo "class='font-grey-cararra'";} ?> href="<?php echo base_url().index_page().'new_designer/home/orderview/';?><?php echo $row['help_desk'] ?>/<?php echo $row['id']; ?>"><?php echo $row['id']; ?></a></td>
											<td><?php echo $row['job_no']; ?></td>
											<td><?php echo $adreps[0]['first_name'];?></td>
											<td><?php echo $publication[0]['name'];?></td>
											<td>
        											<?php echo $dteam_name[0]['name'];
        											/*if($row['help_desk']=='5' && $dteam[0]['design_team_id']=='4'){
        											    echo "D6";
        											    
        											}elseif($row['help_desk']=='2' && $dteam[0]['design_team_id']=='3'){ 
        											    echo "Metro"; 
        											    
        											}
        											elseif($row['help_desk']=='16' && $dteam[0]['design_team_id']=='5'){ 
        											    echo "D7"; 
        											    
        											}elseif($row['help_desk']=='11' && $dteam[0]['design_team_id']=='11'){ 
        											    echo "D5"; 
        											    
        											}elseif($row['help_desk']=='12' && $dteam[0]['design_team_id']=='12'){ 
        											    echo "VIDN"; 
        											    
        											}elseif($row['help_desk']=='15' && $dteam[0]['design_team_id']=='13'){ 
        											    echo "D8"; 
        											    
        											}elseif($row['help_desk']=='10' && $dteam[0]['design_team_id']=='1'){ 
        											    echo "Demo"; 
        											    
        											}else{ echo " "; } */
        											?>
											</td>
											
											<td <?php if($row['question']=='1') { echo 'class="danger"'; } if($row['question']=='2') { echo 'class="success"'; } ?>><?php echo $row1['category']; ?></td>
											<td><?php if(isset($status[0]['name'])) { echo '<span class="label label-sm label-success">'.$status[0]['name'].' </span>'; } else{ echo"None"; } ?></td>
											<td><?php echo $publication[0]['time_zone_priority']; ?></td>
										</tr>
									<?php } } ?>	
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
					 <?php } ?>
			<!--web_cshift_design_check-->
					 
			<!--web_cshift_all-->
			<?php if($display_type=='web_all_pending') { ?>
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							
							<div class="tools">
							<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()"></a>
							</div>
						</div>
						<div class="portlet-body">
						  <table class="table table-striped table-bordered table-hover" id="sample_6">
							<thead>
							<tr>
								<th>Date</th>
								<th>T</th>
								<th>AdwitAds Id</th>
								<th>Unique Job Name</th>
								<th>Adrep</th>
								<th>Publication</th>
								<th>DT</th>
								 <th>C</th>
								 <th>Status</th>
								 <th>Priority</th>
						   </tr>  
							</thead>
							<tbody>
							
					<?php foreach($orders_pending as $row){
						
							$order_type = 	$this->db->get_where('orders_type',array('id' => $row['order_type_id']))->result_array();
							$publication = $this->db->query("SELECT publications.*, time_zone.priority AS time_zone_priority FROM `publications`
				                                    JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
				                                    WHERE publications.id='".$row['publication_id']."'")->result_array();
							$adreps = $this->db->query("SELECT `first_name` FROM `adreps` WHERE `id`='".$row['adrep_id']."' ;")->result_array();
							$cat_result = $this->db->query("SELECT * FROM `cat_result` WHERE `order_no`='".$row['id']."'")->result_array();						
							//$status = 	$this->db->get_where('order_status',array('id' => $row['status']))->result_array();
							if($cat_result && $cat_result[0]['pro_status']!='0'){
								$status = $this->db->get_where('production_status',array('id' => $cat_result[0]['pro_status']))->result_array();					
							}else{
								$status = 	$this->db->get_where('order_status',array('id' => $row['status']))->result_array();					
							}
							$dteam = $this->db->get_where('publications',array('id' => $row['publication_id']))->result_array();
								$dteam_name = $this->db->get_where('design_teams',array('id' => $dteam[0]['design_team_id']))->result_array();
							$design_assign = $this->db->get_where('design_assign')->result_array();					
						 ?>
						
							<tr <?php if($row['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="bg-red-pink"'; } ?>>
								<td><?php $date = strtotime($row['created_on']); echo date('d-M', $date); ?></td>
								<td title="<?php echo $order_type[0]['name']; ?>"><span class="badge bg-blue"><?php if($order_type[0]['id']=='1') {echo "W"; } if($order_type[0]['id']=='2') { echo "P"; } if($order_type[0]['id']=='3') { echo "P&W";}?></span></td>
								<td><a <?php if($row['rush']==1){ echo "class='font-grey-cararra'";} ?> href="<?php echo base_url().index_page().'new_designer/home/orderview/';?><?php echo $row['help_desk'] ?>/<?php echo $row['id']; ?>"><?php echo $row['id']; ?></a></td>
								<td><?php echo $row['job_no']; ?></td>
								<td><?php echo $adreps[0]['first_name'];?></td>
								<td><?php echo $publication[0]['name'];?></td>
								<td>
								   	<?php  echo $dteam_name[0]['name']; ?>
								</td>
								<td <?php if($row['question']=='1') { echo 'class="danger"'; } if($row['question']=='2') { echo 'class="success"'; } ?>><?php echo $cat_result[0]['category']; ?></td>
								<td><?php if(isset($status[0]['name'])) { echo $status[0]['name']; } else{ echo"None"; } ?></td>
								<td><?php echo $publication[0]['time_zone_priority']; ?></td>
							</tr>
					<?php } ?>	
							
							</tbody>
						</table>
						</div>
					</div>
				</div>

			</div>
			 <?php } ?>
			 <!--web_cshift_all-->
       
		</div>
	</div>
</div>
	<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->
<form method = "POST" action="<?php echo base_url().index_page().'new_designer/home/web_cshift/design_pending';?>" id="design_pending_form"> 
<input id="d_order_by" name ="d_order_by" hidden>
<input id="d_sort_by" name="d_sort_by" hidden>
</form>
<form method = "POST" action="<?php echo base_url().index_page().'new_designer/home/web_cshift/upload_pending';?>" id="w_upload_pending_form"> 
<input id="wu_order_by" name ="wu_order_by" hidden>
<input id="wu_sort_by" name="wu_sort_by" hidden>
</form>

<!-- BEGIN FOOTER -->
<?php 
	$this->load->view("new_designer/foot");
?>
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
    //design_pending_tbl starts here
     var d_columnIndex = sessionStorage.getItem('d_columnIndex') || "";
    var d_sort_by = sessionStorage.getItem('d_sort_by') || "";
    $(document).ready(function () {
         // Initialize DataTable
        var dataTable = $('#design_pending_tbl').DataTable({
            destroy: true,
            stateSave: true,
            order: (d_columnIndex !== "" && d_sort_by !== "") ? [[parseInt(d_columnIndex), d_sort_by]] : [[0, 'desc']],
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
        $('#design_pending_tbl thead th').click(function () {
            // Get column index
            // Get column id
            var columnId = $(this).attr('id');
             var order = dataTable.order();
             order_by = ('Column ID: ', columnId);
             sort_by = ('Sorting Direction: ', order[0][1]);
             var columnIndex = order[0][0];
            $("#d_order_by").val(order_by);
            $("#d_sort_by").val(sort_by);
            // Save values to localStorage
            sessionStorage.setItem('d_columnIndex', columnIndex);
            sessionStorage.setItem('d_sort_by', sort_by);
            $("#design_pending_form").submit();
        });
    });
    //design_pending_tbl ends here
    
    //upload_pending_tbl starts here
     var wu_columnIndex = sessionStorage.getItem('wu_columnIndex') || "";
    var wu_sort_by = sessionStorage.getItem('wu_sort_by') || "";
    $(document).ready(function () {
         // Initialize DataTable
        var dataTable = $('#w_upload_pending_tbl').DataTable({
            destroy: true,
            stateSave: true,
            order: (wu_columnIndex !== "" && wu_sort_by !== "") ? [[parseInt(wu_columnIndex), wu_sort_by]] : [[0, 'desc']],
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
        $('#w_upload_pending_tbl thead th').click(function () {
            // Get column index
            // Get column id
            var columnId = $(this).attr('id');
             var order = dataTable.order();
             order_by = ('Column ID: ', columnId);
             sort_by = ('Sorting Direction: ', order[0][1]);
             var columnIndex = order[0][0];
            $("#wu_order_by").val(order_by);
            $("#wu_sort_by").val(sort_by);
            // Save values to localStorage
            sessionStorage.setItem('wu_columnIndex', columnIndex);
            sessionStorage.setItem('wu_sort_by', sort_by);
            $("#w_upload_pending_form").submit();
        });
    });
    //design_pending_tbl ends here
    
</script>