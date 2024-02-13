<?php 
	$this->load->view("new_designer/head");
?>

<style>
.tabletools-btn-group {
 display:none;
}

</style>
<div class="page-container">
	<!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 margin-top-15">
				
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
						<!-- count Tab start -->
					<div class="collapse navbar-collapse navbar-ex1-collapse no-space"> 
						<?php if($designers['designer_role'] == '1'){ ?>
							<ul class="nav navbar-nav">
								<?php if($display_type == 'upload_pending'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/live_new_ads/upload_pending';?>">
									&nbsp; My Q <span class="badge bg-green" id="MyQ"></span></a>
								</li>  
								
								<?php if($display_type == 'design_pending'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/live_new_ads/design_pending';?>">
									&nbsp; Total Q <span class="badge bg-blue" id="TotalQ"></span></a>
								</li>
								
								  <?php if($display_type == 'design_check'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/live_new_ads/design_check';?>">
									&nbsp; Design Check <span class="badge bg-blue" id="DcQ"> </span></a> 
								</li>
								
									<?php if($display_type == 'all_pending'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/live_new_ads/all_pending';?>">
									&nbsp; Pending <span class="badge bg-green" id="DpQ"></span></a> 
								</li>
								
								<?php if($display_type == 'all'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/live_new_ads/all';?>">
									&nbsp; All <span class="badge bg-green" id="AllQ"></span></a> 
								</li>
								
								<?php if($display_type == 'question_sent'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/live_new_ads/question_sent';?>">
									&nbsp; Question Sent <span class="badge bg-green" id="questionSent"></span></a> 
								</li>
							</ul>
						<?php }elseif($designers['designer_role'] == '2'){ ?>
							<ul class="nav navbar-nav">
							    <?php if($display_type == 'upload_pending'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/live_new_ads/upload_pending';?>">
									&nbsp; My Q <span class="badge bg-green" id="MyQ"></span></a>
								</li> 
								<?php if($display_type == 'design_pending'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/live_new_ads/design_pending';?>">
									&nbsp; Total Q <span class="badge bg-blue" id="TotalQ"></span></a>
								</li>
								
								  <?php if($display_type == 'design_check'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/live_new_ads/design_check';?>">
									&nbsp; Design Check <span class="badge bg-blue" id="DcQ"> </span></a> 
								</li>
								
									<?php if($display_type == 'all_pending'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/live_new_ads/all_pending';?>">
									&nbsp; Pending <span class="badge bg-green" id="DpQ"></span></a> 
								</li>
								
								<?php if($display_type == 'all'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/live_new_ads/all';?>">
									&nbsp; All <span class="badge bg-green" id="AllQ"></span></a> 
								</li>
								
								<?php if($display_type == 'question_sent'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/live_new_ads/question_sent';?>">
									&nbsp; Question Sent <span class="badge bg-green" id="questionSent"></span></a> 
								</li>
							</ul>
						<?php }elseif($designers['designer_role'] == '3' || $designers['designer_role'] == '4'){ ?>
							<ul class="nav navbar-nav">
								<?php if($display_type == 'upload_pending'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/live_new_ads/upload_pending';?>">
									&nbsp; My Q <span class="badge bg-green" id="MyQ"></span></a>
								</li>  
								
								<?php if($display_type == 'design_pending'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/live_new_ads/design_pending';?>">
									&nbsp; Total Q <span class="badge bg-blue" id="TotalQ"></span></a>
								</li>
								
							</ul>
						<?php } ?>
					</div>
					<!-- count Tab End -->	
					</div>
					
				</div>
			</div>

<!--Design Pending - TotalQ-->	
<?php if($display_type =='design_pending') { ?> 
<div class="row">
	<div class="col-md-12">
		<!--<form Method="POST" onsubmit="return myFunction(this)">-->
		<form Method="POST">
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption">
						<?php if($designers['designer_role'] == '2') { ?>
						<span class="caption-subject font-green-sharp bold uppercase">Assign</span>
						<?php }else{ ?>
						<span class="caption-subject font-green-sharp bold uppercase">Design Pending</span>
						<?php } ?>
					</div>
					<div class="tools">
					    <a class="reload" onclick="myFunction()"></a>
					</div>
					
				</div>
				<div class="portlet-body">
				    <!-- search form starts here-->
    			    <form action="<?php echo base_url().index_page().'new_designer/home/live_new_ads/design_pending' ?>" method="post">
        				<div class="form-group row">
        				<div class="col-sm-6">
        				    <div class="col-sm-3">
        				        <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="new_design_pending_order" id="new_design_pending_order" onchange="getOrder('design_pending')">
                                  <option selected value="">select</option>
                                  <option value="10" <?php if($this->session->userdata('new_design_pending_order') == '10'){echo 'selected';}?> >10</option>
                                  <option value="25" <?php if($this->session->userdata('new_design_pending_order') == '25'){echo 'selected';}?> >25</option>
                                  <option value="50" <?php if($this->session->userdata('new_design_pending_order') == '50'){echo 'selected';}?> >50</option>
                                  <option value="100" <?php if($this->session->userdata('new_design_pending_order') == '100'){echo 'selected';}?>>100</option>
                                </select>
        				    </div>
        				   
        				</div>
        					<div class="col-sm-3">
        						<input type="text" id="new_design_pending_search" name="new_design_pending_search" value="<?php if($this->session->userdata("new_design_pending_search_val") !== "" ){echo $this->session->userdata("new_design_pending_search_val");}?>" placeholder="Search here" class="form-control">
        					</div>
        					<div class="col-sm-1">
        						<input type="submit" value="Search" class="btn btn-primary">
        					</div>
        					<div class="col-sm-1">
        						<button type="button" class="btn btn-warning" onclick="unset_design_pending_session()">Reset</button>
        					</div>
        				</div>
    			    </form>
		            <!-- search form ends here-->
				  <table class="table table-striped table-bordered table-hover" id="sample_2">
					<thead> 
					<tr>
					    <th style="display:none;" ></th>
						<th id="order_id">AdwitAds ID</th>
						<th id="type">Type</th>
						<th id="u_id">Unique Job Name</th>
						<th id="publication">Publication</th>
						<th id="category">Category</th>
						<th id="designer">Design</th><!--<?php //if($designers['designer_role'] != '2') echo '<th>Design</th>'; ?>-->
						<th id="club">Club</th>
						<th id="priority">Priority</th>
					</tr>
					</thead>
					  <tbody name="testTable" id="testTable">
					 
<?php 
//$myq = $MyQcount;

if(isset($TotalQ[0]['category'])) $max_cat = $TotalQ[0]['category']; 
if($TotalQ != false){
foreach($TotalQ as $data){
	
		$order_type = 	$this->db->get_where('orders_type', array('id' => $data['order_type_id']))->row_array();	
		
		/*$publication = $this->db->query("SELECT publications.name, publications.design_team_id, time_zone.priority AS time_zone_priority FROM `publications`
		                                    JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
		                                    WHERE publications.id = '".$data['publication_id']."'")->row_array();*/
		                                    
		$club_name = $this->db->query("SELECT `name` FROM `club` WHERE id='".$data['club_id']."'")->row_array();
		//$adreps = $this->db->query("SELECT `first_name`,`last_name`,`premium` FROM `adreps` WHERE `id`='".$row['adrep_id']."' ;")->row_array();
		$adreps = $this->db->query("SELECT adreps.first_name, adreps.last_name , adreps.premium, color_code.code FROM `adreps`
    					                            JOIN color_code ON color_code.id = adreps.color_code
		                                             WHERE adreps.id = '".$data['adrep_id']."' ;")->row_array();
		//echo $data['oid'].'- '.$row['rush'];
		if(($designers['designer_role'] == '3' ||  $designers['designer_role'] == '4')) 
		{ 
		
?>				
			<tr <?php if($data['rush']=='1'){ echo'class="bg-red-pink"'; }elseif($adreps['premium']=='1'){ echo'class="bg-yellow"'; }elseif(isset($adreps['code'])){ echo'class="'.$adreps['code'].'"'; } ?> >
	  
						<td style="display:none;"> <?php if($data['rush']=='1'){ echo 1; }?> </td>

<!-- Adwit Id -->		<td><?php echo $data['oid']; ?></td>

<!-- Type -->			<td title="<?php echo $order_type['name']; ?>">
                            <span class="badge bg-blue">
                                <?php 
                                if($order_type['value']=='print') { echo "P";} 
                                elseif($order_type['value']=='web'){ echo "W";} 
                                elseif($order_type['value']=='pagination'){ echo "PG";} 
                                else{ echo "P&W";}
                                ?>
                            </span>
                        </td>
							
<!-- job_name -->		<?php 
                            if($data['order_type_id'] == '6'){
                                echo '<td>'.$data['advertiser_name'].'/'.$data['job_no'].'</td>';
                            }else{
                                echo '<td>'.$data['job_no'].'</td>';
                            }
                        ?>

<!-- adrep 		<td><?php if(isset($adreps[0]['first_name'])){echo $adreps[0]['first_name'].' '.$adreps[0]['last_name'];} ?></td>-->	

<!-- Publication -->	<td><?php echo $data['name']; ?></td>
<!-- Category -->		<td <?php if($data['question']=='1'){ echo'class="danger"'; } if($data['question']=='2'){ echo'class="success"'; } ?>>
							<?php echo $data['category']; ?>
						</td>

<!-- Design -->		    <td>
						    <!--<button type="button" name="confirm_slug" class="btn green-jungle btn-sm" onClick="createSlug(<?php echo $data['oid']; ?>);" >Start Design</button>-->
						    <button type="button" name="confirm_slug" class="btn green-jungle btn-sm" onClick="create_slug(<?php echo $data['oid']; ?>);" >Start Design</button>
						</td>
						
						<td><?php echo $club_name['name']; ?></td>
						
<!-- Priority -->		<td><?php echo $data['time_zone_priority']; ?></td>						
			</tr>
					
<?php   } elseif($designers['designer_role'] == '1' || $designers['designer_role'] == '2') { ?>

			<tr <?php if($data['rush']=='1'){ echo'class="bg-red-pink"'; }elseif($adreps['premium']=='1'){ echo'class="bg-yellow"'; } ?> >
	  
					<td style="display:none;"> <?php if($data['rush']=='1'){  echo 1; } ?></td>
<!-- date 		<td><?php $date = strtotime($data['created_on']); echo date('d-M', $date); ?></td>-->

<!-- Adwit Id -->	<td title="view order details">
						<a <?php if($data['rush']==1){ echo "class='font-grey-cararra'";} ?> href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_designer/home/orderview/'.$data['help_desk'].'/'.$data['id'];?>'" style="cursor:pointer; text-decoration: none;">
						<?php echo $data['id']; ?>
						</a>
					</td>

<!-- Type -->		<td title="<?php echo $order_type['name']; ?>">
                        <span class="badge bg-blue">
                            <?php if($order_type['value']=='print') { echo "P"; } elseif($order_type['value']=='web'){ echo "W";} elseif($order_type['value']=='pagination'){ echo "PG";} else{ echo "P&W";}?>
                        </span>
                    </td>								
<!-- job_name -->	<td><?php echo $data['job_no']; ?></td>

<!-- adrep 	<td><?php echo $adreps[0]['first_name'].' '.$adreps[0]['last_name']; ?></td>-->	

<!-- Publication --><td><?php echo $data['name']; ?></td>

<!-- Category -->	<td <?php if($data['question']=='1'){ echo'class="danger"'; } if($data['question']=='2'){ echo'class="success"'; } ?>>
						<?php echo $data['category'];?>
					</td>

<?php //if($designers['designer_role'] == '1'){ ?>
<!-- Design -->		<td>
						<!--<button type="button" name="confirm_slug" class="btn green-jungle btn-sm" onClick="createSlug(<?php echo $data['oid']; ?>);" >Start Design</button>-->
						 <button type="button" name="confirm_slug" class="btn green-jungle btn-sm" onClick="create_slug(<?php echo $data['oid']; ?>);" >Start Design</button>
						
					</td> 
 <?php //} ?>	
                    <td><?php echo $club_name['name']; ?></td>
                    
<!-- Priority -->	<td><?php echo $data['time_zone_priority']; ?></td>	                    
			</tr>
<?php } }  } ?>
				
					</tbody>
				</table>
			<!--	<?php if($sort_by == null && $sort_by == ""){ ?>
				    <p><?php echo $design_pending_links ?></p>
				<?php } ?>-->
				<p><?php echo $design_pending_links ?></p>
				</div>
			</div>
		</form>
	</div>
</div>
<?php } ?>
<!--Design Pending--> 

<!--Upload Pending - MyQ-->		
<?php if($display_type=='upload_pending') { ?> 
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
			    <!-- search form starts here-->
    			    <form action="<?php echo base_url().index_page().'new_designer/home/live_new_ads/upload_pending' ?>" method="post">
        				<div class="form-group row">
        				<div class="col-sm-6">
        				    <div class="col-sm-3">
        				        <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="new_upload_pending_order" id="new_upload_pending_order" onchange="getOrder('upload_pending')">
                                  <option selected value="">select</option>
                                  <option value="10" <?php if($this->session->userdata('new_upload_pending_order') == '10'){echo 'selected';}?> >10</option>
                                  <option value="25" <?php if($this->session->userdata('new_upload_pending_order') == '25'){echo 'selected';}?> >25</option>
                                  <option value="50" <?php if($this->session->userdata('new_upload_pending_order') == '50'){echo 'selected';}?> >50</option>
                                  <option value="100" <?php if($this->session->userdata('new_upload_pending_order') == '100'){echo 'selected';}?>>100</option>
                                </select>
        				    </div>
        				   
        				</div>
        					<div class="col-sm-3">
        						<input type="text" id="new_upload_pending_search" name="new_upload_pending_search" value="<?php if($this->session->userdata("new_upload_pending_search_val") !== "" ){echo $this->session->userdata("new_upload_pending_search_val");}?>" placeholder="Search here" class="form-control">
        					</div>
        					<div class="col-sm-1">
        						<input type="submit" value="Search" class="btn btn-primary">
        					</div>
        					<div class="col-sm-1">
        						<button type="button" class="btn btn-warning" onclick="unset_new_upload_pending_session()">Reset</button>
        					</div>
        				</div>
    			    </form>
		        <!-- search form ends here-->
				<table class="table table-striped table-bordered table-hover" id="upload_pending_tbl">
					<thead>
						<tr>
						    <th style="display:none;" ></th>
							<th id="created_on">Date</th>
							<th id="order_id">AdwitAds ID</th>
							<th>Unique Job Name</th>
							<th id="adrep">Adrep</th>
							<th id="publication">Publication</th>
							<th id="category">Category</th>
							<th>Status</th>
							<th id="club">Club</th>
							<th id="priority">Priority</th>
						</tr>
					</thead>
					<tbody name="testTable" id="testTable">
					
				<?php 
				if($MyQ != false){
				foreach($MyQ as $data){
					$order_id = $data['order_id'];
					$order = $this->db->query("SELECT `publication_id`,`adrep_id`,`rush`,`created_on`,`job_no`,`id`,`question`,`help_desk`, `advertiser_name`, `order_type_id` FROM `orders` WHERE id='".$order_id."'")->row_array();
					if(isset($order['id'])){
    					$cat_result = $this->db->query("SELECT `pro_status`,`category` FROM `cat_result` WHERE `order_no`='".$order_id."' ;")->row_array();
    					$publication = $this->db->query("SELECT `name`,`design_team_id` FROM `publications` WHERE id='".$order['publication_id']."'")->row_array();
    					//$adreps = $this->db->query("SELECT `first_name`,`last_name`,`premium` FROM `adreps` WHERE `id`='".$order['adrep_id']."' ;")->row_array();
    					$adreps = $this->db->query("SELECT adreps.first_name, adreps.last_name , adreps.premium, color_code.code FROM `adreps`
    					                            JOIN color_code ON color_code.id = adreps.color_code
		                                             WHERE adreps.id = '".$order['adrep_id']."' ;")->row_array();
    					$status = $this->db->query("SELECT `name` FROM `production_status` WHERE id='".$cat_result['pro_status']."'")->row_array();
    					$club_name = $this->db->query("SELECT `name` FROM `club` WHERE id='".$data['club_id']."'")->row_array();
				?>
				
					<tr <?php if($order['rush']=='1'){ echo'class="bg-red-pink"'; }elseif($adreps['premium']=='1'){ echo'class="bg-yellow"'; }elseif(isset($adreps['code'])){ echo'class="'.$adreps['code'].'"'; }else{ echo'class="odd gradeX"'; } ?>>
	                    <td style="display:none;"> <?php if($order['rush']=='1'){ echo 1; }?> </td>
	<!-- date -->		<td><?php $date = strtotime($order['created_on']); echo date('d-M', $date); ?></td>
	<!-- Adwit Id -->	<td <?php if($order['rush']==1){ echo "class='font-grey-cararra'";} ?>><?php echo $order['id']; ?></td>							
	<!-- job_name -->	<?php 
                            if($order['order_type_id'] == '6'){
                                echo '<td>'.$order['advertiser_name'].'/'.$order['job_no'].'</td>';
                            }else{
                                echo '<td>'.$order['job_no'].'</td>';
                            }
                        ?>
	<!-- adrep -->		<td><?php echo $adreps['first_name'].' '.$adreps['last_name']; ?></td>
	<!-- Publication --><td><?php echo $publication['name']; ?></td>
	
	<!-- design team <?php if($publication['design_team_id']=='4'){echo "<td>D6</td>";}elseif($publication['design_team_id']=='5'){ echo "<td>D7</td>"; } ?>-->
	
	<!-- Category -->	<td <?php if($order['question']=='1') { echo 'class="danger"'; } if($order['question']=='2') { echo 'class="success"'; } ?>>
							<?php  if($cat_result['category']){ echo $cat_result['category']; }else{ echo 'Pending'; } ?>
						</td>
	<!-- Design -->		<td>
							<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_designer/home/orderview/'.$order['help_desk'].'/'.$order['id'];?>'" style="cursor:pointer; text-decoration: none;">
								<button class="btn blue-sunglo btn-xs"><?php if($status)echo $status['name']; else echo''; ?></button>
							</a>
						</td>
	<!-- Club -->		<td><?php echo $club_name['name']; ?></td>
	
<!-- Priority -->		<td><?php echo $data['time_zone_priority']; ?></td>	
					</tr>
					<?php } }} ?>
					</tbody>
				</table>
				<p><?php echo $upload_pending_links;?></p>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<!--Upload Pending-->	
	
<!--design check - Design Check-->	
<?php if($display_type=='design_check') { ?>  
<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="caption">
					<?php echo '<span style="color:#900;">'.$this->session->flashdata('ext_message').'</span>'; ?>
				</div>
				<div class="tools">				
				<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()"></a>
				</div>
			</div>
			<div class="portlet-body">
			  <table class="table table-striped table-bordered table-hover" id="sample_6">
				<thead>
					<tr>
					    <th style="display:none;" ></th>
						<th>Date</th>
						<th>AdwitAds ID</th>
						<th>Unique Job Name</th>
						<!--<th>Adrep</th>-->
						<th>Publication</th>
						<th>C</th>
						<th>Designer</th>
						<th>Status</th>
						<th>Priority</th>
				   </tr>  
				</thead>
				<tbody>
<?php 
	foreach($DcQ as $data){
		$order_id = $data['order_id'];
		
		$row = $this->db->query("SELECT `help_desk`,`created_on`,`rush`,`id`,`question`,`adrep_id` FROM `orders` 
									WHERE id='".$order_id."'")->row_array();
		$publication = $this->db->query("SELECT `name`,`design_team_id` FROM `publications` WHERE id='".$data['pub_id']."'")->row_array();
		//$adreps = $this->db->query("SELECT `first_name`,`last_name`,`premium` FROM `adreps` WHERE `id`='".$row['adrep_id']."' ;")->row_array();
		$adreps = $this->db->query("SELECT adreps.first_name, adreps.last_name , adreps.premium, color_code.code FROM `adreps`
    					                            JOIN color_code ON color_code.id = adreps.color_code
		                                             WHERE adreps.id = '".$row['adrep_id']."' ;")->row_array();
		$status = $this->db->get_where('production_status',array('id' => $data['pro_status']))->row_array();
		if(isset($data['designer_id'])){				
			$designer_pending = $this->db->query("SELECT `username` FROM `designers` WHERE `id`='".$data['designer_id']."' ;")->row_array();
		}
		
?>
				<tr <?php if($row['rush']=='1'){ echo'class="bg-red-pink"'; }elseif($adreps['premium']=='1'){ echo'class="bg-yellow"'; }elseif(isset($adreps['code'])){ echo'class="'.$adreps['code'].'"'; }else{ echo'class="odd gradeX"'; } ?>>
				    
				    <td style="display:none;"> <?php if($row['rush']=='1'){ echo 1; }?> </td>
				    
					<td><?php $date = strtotime($row['created_on']); echo date('d-M', $date); ?></td>
					
					<td>
    					<a <?php if($row['rush']==1){ echo "class='font-grey-cararra'";} ?> href="<?php echo base_url().index_page().'new_designer/home/orderview/'.$row['help_desk'].'/'.$row['id']; ?>">
    					<?php echo $row['id']; ?></a>
					</td>
					
					<td><?php echo $data['job_no']; ?></td>
					
					<!--<td><?php echo $adreps['first_name'].' '.$adreps['last_name'];?></td>-->
					
					<td><?php echo $publication['name'];?></td>
					
					<td <?php if($row['question']=='1') { echo 'class="danger"'; } if($row['question']=='2') { echo 'class="success"'; } ?>>
						<?php echo $data['category']; ?>
					</td>
					
<!-- Designer -->	<td><?php if(isset($designer_pending['username'])){ echo $designer_pending['username']; } else { echo ' ' ; }?></td>				
					
<!--Status-->		<td>
						<a  class="btn btn-xs btn-success" <?php if($row['rush']==1){ echo "class='font-grey-cararra'";} ?> href="<?php echo base_url().index_page().'new_designer/home/orderview/'.$row['help_desk'].'/'.$row['id']; ?>">
							<?php if(isset($status['name'])) { echo $status['name']; } else{ echo"None"; } ?>
						</a>
						<!--temp file check in directory
							<?php
							$inddtemp1 = $cat_result['source_path'].'/'.'temp1'.".indd";
							$pdftemp1 = $cat_result['source_path'].'/'.'temp1'.".pdf";
							
							$inddtemp2 = $cat_result['source_path'].'/'.'temp2'.".indd";
							$pdftemp2 = $cat_result['source_path'].'/'.'temp2'.".pdf";
							
							$inddtemp3 = $cat_result['source_path'].'/'.'temp3'.".indd";
							$pdftemp3 = $cat_result['source_path'].'/'.'temp3'.".pdf";
							
							if((file_exists($inddtemp1) && file_exists($pdftemp1)) || (file_exists($inddtemp2) && file_exists($pdftemp2)) ||
							(file_exists($inddtemp3) && file_exists($pdftemp3))) { ?>
								<i class="fa fa-flag"></i>
							<?php } else{ echo ' ';}
							?>
						temp file check in directory-->
					</td>

<!-- Priority -->	<td><?php echo $data['time_zone_priority']; ?></td>					
				</tr>
			<?php }?>	
				</tbody>
			</table>
			</div>
		</div>
	</div>
</div>	
<?php } ?>
<!--design check-->	
	
<!--All Pending - Pending-->	
<?php if($display_type=='all_pending') { ?>
<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="tools">
				<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()"></a>
				</div>
			</div>
			<div class="portlet-body">
		    <!-- search form starts here-->
			    <form action="<?php echo base_url().index_page().'new_designer/home/live_new_ads/all_pending' ?>" method="post">
    				<div class="form-group row">
    				<div class="col-sm-6">
    				    <div class="col-sm-3">
    				        <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="new_all_pending_order" id="new_all_pending_order" onchange="getOrder('all_pending')">
                              <option selected value="">select</option>
                              <option value="10" <?php if($this->session->userdata('new_all_pending_order') == '10'){echo 'selected';}?> >10</option>
                              <option value="25" <?php if($this->session->userdata('new_all_pending_order') == '25'){echo 'selected';}?> >25</option>
                              <option value="50" <?php if($this->session->userdata('new_all_pending_order') == '50'){echo 'selected';}?> >50</option>
                              <option value="100" <?php if($this->session->userdata('new_all_pending_order') == '100'){echo 'selected';}?>>100</option>
                            </select>
    				    </div>
    				   
    				</div>
    					<div class="col-sm-3">
    						<input type="text" id="new_all_pending_search" name="new_all_pending_search" value="<?php if($this->session->userdata("new_all_pending_search_val") !== "" ){echo $this->session->userdata("new_all_pending_search_val");}?>" placeholder="Search here" class="form-control">
    					</div>
    					<div class="col-sm-1">
    						<input type="submit" value="Search" class="btn btn-primary">
    					</div>
    					<div class="col-sm-1">
    						<button type="button" class="btn btn-warning" onclick="unset_all_pending_session()">Reset</button>
    					</div>
    				</div>
			    </form>
	            <!-- search form ends here-->
			 <table class="table table-striped table-bordered table-hover" id="sample">
				<thead>
					<tr>
					    <th style="display:none;" ></th>
						<th>Date</th>
						<th>AdwitAds ID</th>
						<th>Unique Job Name</th>
						<th>Adrep</th>
						<th>Publication</th>
						<th>C</th>
						<th>Designer</th>
						<th>Status</th>
						<th>Priority</th>
				   </tr>  
				</thead>
				<tbody>
			<?php 
			    if($DpQ != false){
				foreach($DpQ as $data){
					$row = $this->db->query("SELECT `publication_id`,`adrep_id`,`rush`,`created_on`,`job_no`,`id`,`question`,`status`,`help_desk` FROM `orders` WHERE id='".$data['order_id']."'")->row_array();
					$publication = $this->db->query("SELECT `name`,`design_team_id` FROM `publications` WHERE id='".$data['pub_id']."'")->row_array();
					if(isset($row['id'])){
						//$adreps = $this->db->query("SELECT `first_name`,`last_name`,`premium` FROM `adreps` WHERE `id`='".$row['adrep_id']."' ;")->row_array();
						$adreps = $this->db->query("SELECT adreps.first_name, adreps.last_name , adreps.premium, color_code.code FROM `adreps`
    					                            JOIN color_code ON color_code.id = adreps.color_code
		                                             WHERE adreps.id = '".$row['adrep_id']."' ;")->row_array();
						if($data['pro_status']!='0'){
							$status = $this->db->get_where('production_status',array('id' => $data['pro_status']))->row_array();					
						}else{
							$status = 	$this->db->get_where('order_status',array('id' => $data['status']))->row_array();					
						}
						$design_assign = $this->db->get_where('design_assign')->result_array();
						if(isset($data['designer_id'])){				
							$designer_pending = $this->db->query("SELECT `username` FROM `designers` WHERE `id`='".$data['designer_id']."' ;")->row_array();
						}
					
			?>
			    <tr <?php if($row['rush']=='1'){ echo'class="bg-red-pink"'; }elseif($adreps['premium']=='1'){ echo'class="bg-yellow"'; }elseif(isset($adreps['code'])){ echo'class="'.$adreps['code'].'"'; }else{ echo'class="odd gradeX"'; } ?>>
					<td style="display:none;"> <?php if($row['rush']=='1'){ echo 1; }?> </td>
					<td><?php $date = strtotime($row['created_on']); echo date('d-M', $date); ?></td>
					<td><a <?php if($row['rush']==1){ echo "class='font-grey-cararra'";} ?> href="<?php echo base_url().index_page().'new_designer/home/orderview/'.$row['help_desk'].'/'.$row['id']; ?>"><?php echo $row['id']; ?></a></td>
					<td><?php echo $row['job_no']; ?></td>
					<td><?php echo $adreps['first_name'].' '.$adreps['last_name'];?></td>
					<td><?php echo $publication['name'];?></td>
					<td <?php if($row['question']=='1') { echo 'class="danger"'; } if($row['question']=='2') { echo 'class="success"'; } ?>><?php echo $data['category']; ?></td>
<!-- Designer -->	<td><?php if(isset($data['designer_id']) && isset($designer_pending['username'])){ echo $designer_pending['username']; } else { echo ' ' ; }?></td>
					<td><a class="btn btn-xs btn-success" href="<?php echo base_url().index_page().'new_designer/home/orderview/'.$row['help_desk'].'/'.$row['id']; ?>"><?php if(isset($status['name'])) { echo $status['name']; } else{ echo"None"; } ?></a></td>
<!-- Priority -->	<td><?php echo $data['time_zone_priority']; ?></td>				
				</tr>
				
			<?php } } } ?>	
				
				</tbody>
			</table>
			<p><?php echo $all_pending_links;?></p>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<!--All Pending-->	      
			
<!-- all - All-->
<?php if($display_type=='all') { ?> 
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
						    <th style="display:none;" ></th>
							<th>Date</th>
							<th>Type</th>
							<th>AdwitAds ID</th>
							<th>Unique Job Name</th>
							<th>Adrep</th>
							<th>Publication</th>
							<th>Group</th>
							<th>Status</th>
							<th>Club</th>
							<th>Priority</th>
					   </tr>  
					</thead>
					<tbody>
					
				<?php foreach($AllQ as $data){
					
					$order_type = 	$this->db->get_where('orders_type', array('id' => $data['order_type_id']))->result_array();
					
					//$adreps = $this->db->query("SELECT `first_name`,`last_name`,`premium` FROM `adreps` WHERE `id`='".$data['adrep_id']."' ;")->row_array();
					$adreps = $this->db->query("SELECT adreps.first_name, adreps.last_name , adreps.premium, color_code.code FROM `adreps`
    					                            JOIN color_code ON color_code.id = adreps.color_code
		                                             WHERE adreps.id = '".$data['adrep_id']."' ;")->row_array();
		                                             
					$status = 	$this->db->get_where('order_status',array('id' => $data['status']))->row_array();					
					
					$group = $this->db->query("SELECT `name` FROM `Group` WHERE `id` = '".$data['group_id']."'")->row_array();
					
					$club_name = $this->db->query("SELECT `name` FROM `club` WHERE id='".$data['club_id']."'")->row_array();
				 ?>
					<tr <?php if($data['rush']=='1'){ echo'class="bg-red-pink"'; }elseif($adreps['premium']=='1'){ echo'class="bg-yellow"'; }elseif(isset($adreps['code'])){ echo'class="'.$adreps['code'].'"'; }else{ echo'class="odd gradeX"'; } ?>>
						
						<td style="display:none;"> <?php if($data['rush']=='1'){ echo '1'; }?> </td>
						
						<td><?php $date = strtotime($data['created_on']); echo date('d-M', $date); ?></td>
						
						<td title="<?php echo $order_type[0]['name']; ?>">
						    <span class="badge bg-blue">
						        <?php if($order_type[0]['value']=='print') {echo "P";} elseif($order_type[0]['value']=='web'){ echo "W";} elseif($order_type[0]['value']=='pagination'){ echo "PG";} else{ echo "P&W";}?>
						    </span>
					    </td>
						
						<td><a <?php if($data['rush']==1){ echo "class='font-grey-cararra'";} ?> href="<?php echo base_url().index_page().'new_designer/home/orderview/'.$data['help_desk'].'/'.$data['id']; ?>" ><?php echo $data['id']; ?></a></td>
						
						<td><?php echo $data['job_no']; ?></td>
						
						<td><?php echo $adreps['first_name'].' '.$adreps['last_name'];?></td>
						
						<td><?php echo $data['name'];?></td>
						
						<td><?php echo $group['name'];?></td>
						
						<td>
						<a class="btn btn-xs btn-success" href="<?php echo base_url().index_page().'new_designer/home/orderview/'.$data['help_desk'].'/'.$data['id']; ?>" ><?php if(isset($status['name'])) { echo $status['name']; } else{ echo""; } ?></a>
						</td>
						
						<td><?php echo $club_name['name']; ?></td>
						
<!-- Priority -->		<td><?php echo $data['time_zone_priority']; ?></td>						
					</tr>
				<?php  } ?>	
					
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php } ?>		
<!-- all-->

<!--Question Sent-->	
<?php if($display_type=='question_sent') { ?>
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
					    <th style="display:none;" ></th>
						<th>Date</th>
						<th>AdwitAds ID</th>
						<th>Unique Job Name</th>
						<th>Adrep</th>
						<th>Publication</th>
						<th>C</th>
						<th>Designer</th>
						<th>Status</th>
						<th>Priority</th>
				   </tr>  
				</thead>
				<tbody>
			<?php 
				foreach($question_sent as $data){
					$row = $this->db->query("SELECT `publication_id`,`adrep_id`,`rush`,`created_on`,`job_no`,`id`,`question`,`status`,`help_desk` FROM `orders` WHERE id='".$data['order_id']."'")->row_array();
					$publication = $this->db->query("SELECT `name`,`design_team_id` FROM `publications` WHERE id='".$data['pub_id']."'")->row_array();
					if(isset($row['id'])){
						//$adreps = $this->db->query("SELECT `first_name`,`last_name`,`premium` FROM `adreps` WHERE `id`='".$row['adrep_id']."' ;")->row_array();
						$adreps = $this->db->query("SELECT adreps.first_name, adreps.last_name , adreps.premium, color_code.code FROM `adreps`
    					                            JOIN color_code ON color_code.id = adreps.color_code
		                                             WHERE adreps.id = '".$row['adrep_id']."' ;")->row_array();
						if($data['pro_status']!='0'){
							$status = $this->db->get_where('production_status',array('id' => $data['pro_status']))->row_array();					
						}else{
							$status = 	$this->db->get_where('order_status',array('id' => $data['status']))->row_array();					
						}
						$design_assign = $this->db->get_where('design_assign')->result_array();
						if(isset($data['designer_id'])){				
							$designer_pending = $this->db->query("SELECT `username` FROM `designers` WHERE `id`='".$data['designer_id']."' ;")->row_array();
						}
					
			?>
			    <tr <?php if($row['rush']=='1'){ echo'class="bg-red-pink"'; }elseif($adreps['premium']=='1'){ echo'class="bg-yellow"'; }elseif(isset($adreps['code'])){ echo'class="'.$adreps['code'].'"'; }else{ echo'class="odd gradeX"'; } ?>>
					<td style="display:none;"> <?php if($row['rush']=='1'){ echo 1; }?> </td>
					<td><?php $date = strtotime($row['created_on']); echo date('d-M', $date); ?></td>
					<td><a <?php if($row['rush']==1){ echo "class='font-grey-cararra'";} ?> href="<?php echo base_url().index_page().'new_designer/home/orderview/'.$row['help_desk'].'/'.$row['id']; ?>"><?php echo $row['id']; ?></a></td>
					<td><?php echo $row['job_no']; ?></td>
					<td><?php echo $adreps['first_name'].' '.$adreps['last_name'];?></td>
					<td><?php echo $publication['name'];?></td>
					<td <?php if($row['question']=='1') { echo 'class="danger"'; } if($row['question']=='2') { echo 'class="success"'; } ?>><?php echo $data['category']; ?></td>
<!-- Designer -->	<td><?php if(isset($data['designer_id']) && isset($designer_pending['username'])){ echo $designer_pending['username']; } else { echo ' ' ; }?></td>
					<td><a class="btn btn-xs btn-success" href="<?php echo base_url().index_page().'new_designer/home/orderview/'.$row['help_desk'].'/'.$row['id']; ?>"><?php if(isset($status['name'])) { echo $status['name']; } else{ echo"None"; } ?></a></td>
<!-- Priority -->	<td><?php echo $data['time_zone_priority']; ?></td>				
				</tr>
				
			<?php } } ?>	
				
				</tbody>
			</table>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<!--Question Sent-->

		</div>
	</div>
</div>

<!-- confirmation modal starts here-->
<div class="modal fade" id="slugConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
     <form method="post">
    <div class="modal-content" style="width:85%">
      <div class="modal-header  portlet blue-hoki box" style="border-bottom: 0 !important;">
        <h5 class="modal-title portlet-title margin-top-10" style="margin-top: 0px !important; padding:10px !important;"  id="confirmationModalTitle"><center><b>Confirm Slug</b></center></h5>
      
      </div>
      <div class="modal-body"> 
      <div id="message"></div>
      <div class="text-center">
          <p name="slug_url" id="slug_url"> </p><i class="fa fa-clipboard" onclick="copySlug()" title="copy to clipboard"></i>
        </div>
      <div id="input_div" style="display:none;">
          <input name="cat_id" id="cat_id"> 
          <input name="help_desk_id" id="help_desk_id"> 
          <input name="slug_order_id" id="slug_order_id"> 
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" onclick="confirmSlug()">Confirm</button>
      </div>
    </div>
    </form>
  </div>
</div>
<!-- confirmation modal ends here-->

<!-- test form starts here-->
<form method = "POST" action="<?php echo base_url().index_page().'new_designer/home/live_new_ads/design_pending';?>" id="test_form"> 
<input id="order_by" name ="order_by" hidden>
<input id="sort_by" name="sort_by" hidden>
</form>
<!-- test form ends here-->
<form method = "POST" action="<?php echo base_url().index_page().'new_designer/home/live_new_ads/upload_pending';?>" id="upload_pending_form"> 
<input id="u_order_by" name ="u_order_by" hidden>
<input id="u_sort_by" name="u_sort_by" hidden>
</form>
<!-- END PAGE CONTENT -->
<!-- END PAGE CONTAINER -->
<!-- BEGIN FOOTER -->

<script type="text/javascript">
    $(document).ready(function(){
    	$.ajax({
    		url: "<?php echo base_url().index_page().'new_designer/home/tab_count';?>",
    		//cache: false,
    		success: function(data){
    			var myObj = JSON.parse(data);
    			$('#MyQ').html(myObj.MyQCount);
    			$('#TotalQ').html(myObj.TotalQCount);
    			$('#DcQ').html(myObj.DcQCount);
    			$('#DpQ').html(myObj.DpQCount);
    			$('#AllQ').html(myObj.AllQCount);
    			$('#questionSent').html(myObj.questionSentCount);	
    		}
    	});
    	//$('#MyQ').html('110');
    	
    	$('.adwitad_id').on('hover',function(){ var id = $(this).data('adwitad_id'); alert('ID : '+id); });
    	    
    	    
    });
      function myFunction() {
            var checkbox= document.querySelector('input[name="assign[]"]:checked');
    		var checkbox1= document.querySelector('input[name="assign_designer[]"]:checked');
      if(!checkbox && !checkbox1) {
        alert('Please select!');
        return false;
      }
    
    }
</script>

<script type="text/javascript"> 
    function conf() { var con = alert("Please complete 'My Q' before you take a new ad(Allowed Limit In-Production: 3, In-QA: 10 Ads)."); } 

    function catconf() { var con=confirm("Lower category ads Not allowed.. As You still have higher category ads pending.."); }

    function createSlug(order_id){
	//ajax
			$.ajax({
					url: "<?php echo base_url().index_page();?>new_designer/home/createSlug/"+order_id,
					success: function(data) { 
					    var myObj = JSON.parse(data);
							var slug = myObj.slug;
							var alert_msg = myObj.msg;
							if(alert_msg != ''){
								alert(alert_msg);
								return false;
							}
					   		var X = confirm('Confirm Slug : '+slug);
						    if(X == true && slug != '')	 {
						     	var data_id = myObj.cat_id;
                    			var confirm_slug = 'none';
                    			var help_desk = myObj.help_desk;
                				//ajax
                				$.ajax({
                					url: "<?php echo base_url().index_page();?>new_designer/home/orderview/"+help_desk+"/"+order_id,
                					data:'slug='+slug+'&data_id='+data_id+'&confirm_slug='+confirm_slug,
                					type: "POST",
                					success: function(msg) { window.location.href = "<?php echo base_url().index_page();?>new_designer/home/orderview/"+help_desk+"/"+order_id; }
                				});	
                				return true;  
                			}else { 
								return false;  
                			}
					}
			});	
			return true;  
		
	}
    
    function create_slug(order_id){
    	$.ajax({
				url: "<?php echo base_url().index_page();?>new_designer/home/createSlug/"+order_id,
				success: function(data) { 
				    var myObj = JSON.parse(data);
						var alert_msg = myObj.msg;
						if(alert_msg != ''){
						  $('#message').text(alert_msg);
						  $('#slugConfirmationModal').modal('show');
						}else{
						   	var slug = myObj.slug;
						   	var data_id = myObj.cat_id;
                			var help_desk = myObj.help_desk;
                			$("#slug_url").text(slug);
                			$("#cat_id").text(data_id);
                			$("#help_desk_id").text(help_desk);
                			$("#slug_order_id").text(order_id);
                			$('#slugConfirmationModal').modal('show');
						}
				}
		});	
	}
	
	function confirmSlug(){
        var slug = $('#slug_url').text();
        var data_id =  $("#cat_id").text();
        var confirm_slug = 'none';
        var help_desk = $("#help_desk_id").text();
        var order_id = $("#slug_order_id").text();
    	$.ajax({
			url: "<?php echo base_url().index_page();?>new_designer/home/orderview/"+help_desk+"/"+order_id,
			data:'slug='+slug+'&data_id='+data_id+'&confirm_slug='+confirm_slug,
			type: "POST",
			success: function(msg) { 
			    $('#slugConfirmationModal').modal('hide');
			    window.location.href = "<?php echo base_url().index_page();?>new_designer/home/orderview/"+help_desk+"/"+order_id; 
			    
			}
		});	
	}
	
	function copySlug() {
        var text = $('#slug_url').text();
        // Create a temporary input element to copy the text
        var tempInput = document.createElement('input');
        tempInput.value = text;
        // Append the input element to the body
        document.body.appendChild(tempInput);
        // Select and copy the text
        tempInput.select();
        document.execCommand("copy");
        // Remove the temporary input element
        document.body.removeChild(tempInput);
        // alert("Copied the text: " + text);
    
    }
</script>

<?php 
	$this->load->view("new_designer/foot");
?>

<script>


$(document).ready(function() {
    
    var table = $('#sample_6').DataTable({
        destroy: true,
        order: [[0, 'desc']],
        columnDefs: [
            { targets: 0, visible: false }  // hide the first column
        ],
        iDisplayLength: -1
    });

   
});

function getOrder(order_type){
	  var order_type = order_type;
	  if(order_type == "design_pending"){
	     var no_of_order = $("#new_design_pending_order").val();  
	  }else if (order_type == "upload_pending"){
	     var no_of_order = $("#new_upload_pending_order").val();   
	  }else if (order_type == "all_pending"){
	     var no_of_order = $("#new_all_pending_order").val();   
	  }
	  var dataString = "no_of_order="+no_of_order;
        // console.log(dataString);
    	$.ajax({
    		url: "<?php echo base_url().index_page().'new_designer/home/live_new_ads/';?>"+order_type,
    		type: 'POST',
    		data: dataString,
            success: function(response) {
                // Redirect the user to the new location
                window.location.href = "<?php echo base_url() . index_page() . 'new_designer/home/live_new_ads/'; ?>"+order_type;
            },
            error: function() {
                alert('Something went wrong!!');
            }
        }); 
        
	}
	 
	function unset_new_upload_pending_session(){
	  $.ajax({
        type: 'POST',
		url: "<?php echo base_url().index_page().'new_designer/home/unset_new_upload_pending_session';?>",
        success: function(response) {
            sessionStorage.removeItem('u_columnIndex');
            sessionStorage.removeItem('u_sort_by');
            var dataTable = $('#upload_pending_tbl').DataTable();
            dataTable.state.clear(); // Clear the saved state
            dataTable.draw(); // Redraw the DataTable
            // Redirect the user to the new location
            window.location.href = "<?php echo base_url() . index_page() . 'new_designer/home/live_new_ads/upload_pending'; ?>";
        },
        error: function() {
            alert('Something went wrong!!');
        }
    });  
	}
	
	function unset_design_pending_session(){
	  $.ajax({
        type: 'POST',
		url: "<?php echo base_url().index_page().'new_designer/home/unset_new_design_pending_session';?>",
        success: function(response) {
            sessionStorage.removeItem('columnIndex');
            sessionStorage.removeItem('sort_by');
            var dataTable = $('#sample_2').DataTable();
            dataTable.state.clear(); // Clear the saved state
            dataTable.draw(); // Redraw the DataTable
            // Redirect the user to the new location
            window.location.href = "<?php echo base_url() . index_page() . 'new_designer/home/live_new_ads/design_pending'; ?>";
        },
        error: function() {
            alert('Something went wrong!!');
        }
    });  
	}
	
  function unset_all_pending_session(){
	  $.ajax({
        type: 'POST',
		url: "<?php echo base_url().index_page().'new_designer/home/unset_all_pending_session';?>",
        success: function(response) {
            // Redirect the user to the new location
            window.location.href = "<?php echo base_url() . index_page() . 'new_designer/home/live_new_ads/all_pending'; ?>";
        },
        error: function() {
            alert('Something went wrong!!');
        }
    });  
	}

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
    // 	"bFilter": false
    });
    
    // uploading pending tbl sorting starts here
    
    var u_columnIndex = sessionStorage.getItem('u_columnIndex') || "";
    var u_sort_by = sessionStorage.getItem('u_sort_by') || "";
    console.log(u_columnIndex);
    console.log("next");
    console.log(u_sort_by);
     $(document).ready(function () {
         // Initialize DataTable
        var dataTable = $('#upload_pending_tbl').DataTable({
            destroy: true,
            stateSave: true,
            order: (u_columnIndex !== "" && u_sort_by !== "") ? [[parseInt(u_columnIndex), u_sort_by]] : [[0, 'desc']],
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
        $('#upload_pending_tbl thead th').click(function () {
            var columnId = $(this).attr('id');
             var order = dataTable.order();
             order_by = ('Column ID: ', columnId);
             sort_by = ('Sorting Direction: ', order[0][1]);
             var columnIndex = order[0][0];
            $("#u_order_by").val(order_by);
            $("#u_sort_by").val(sort_by);
            // Save values to localStorage
            sessionStorage.setItem('u_columnIndex', columnIndex);
            sessionStorage.setItem('u_sort_by', sort_by);
            $("#upload_pending_form").submit();
           
        });
    });
    
     // uploading pending tbl sorting ends here
     
    var columnIndex1 = sessionStorage.getItem('columnIndex') || "";
    var sort_by1 = sessionStorage.getItem('sort_by') || "";
    
    $(document).ready(function () {
         // Initialize DataTable
        var dataTable = $('#sample_2').DataTable({
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
        $('#sample_2 thead th').click(function () {
            // Get column index
            // Get column id
            var columnId = $(this).attr('id');
             var order = dataTable.order();
             order_by = ('Column ID: ', columnId);
             sort_by = ('Sorting Direction: ', order[0][1]);
             var columnIndex = order[0][0];
            $("#order_by").val(order_by);
            $("#sort_by").val(sort_by);
            // Save values to localStorage
            sessionStorage.setItem('columnIndex', columnIndex);
            sessionStorage.setItem('sort_by', sort_by);
            $("#test_form").submit();
        });
    });

 
   
</script>