<?php
       $this->load->view("team-lead/head"); 
?>
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
									
								</div>
								<!-- Collect the nav links, forms, and other content for toggling -->
								<div class="collapse navbar-collapse navbar-ex1-collapse no-space">
									<ul class="nav navbar-nav">
									
										<?php  if($display_type == 'assign'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
											<a href="<?php echo base_url().index_page().'team-lead/home/cshift/'.$form.'/assign';?>">
											Assign <span class="badge bg-red"> <?php echo count($orders); ?></span></a>
										</li>
									
										<?php  if($display_type == 'design_check'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
											<a href="<?php echo base_url().index_page().'team-lead/home/cshift/'.$form.'/design_check';?>">
											Design Check <span class="badge bg-blue"> <?php echo $DC_order_count; ?></span></a> 
										</li>
								
									<?php  if($display_type == 'all_pending'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
											<a href="<?php echo base_url().index_page().'team-lead/home/cshift/'.$form.'/all_pending';?>">
											Pending <span class="badge bg-green"><?php echo count($orders_pending); ?></span></a>
										</li>
										
										<?php  if($display_type == 'all'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
											<a href="<?php echo base_url().index_page().'team-lead/home/cshift/'.$form.'/all';?>">
											All <span class="badge bg-green"><?php echo count($all_orders); ?></span></a>
										</li>
								
									</ul>
									<!--<span style="margin-left: 20px; padding: 0 10px;" class="font-blue margin-top-10">	
										<?php echo $this->session->flashdata('metro_message'); ?>
									</span>-->
									
									<ul class="nav navbar-nav navbar-right  margin-right-10">
									<!--<?php if($form=='2'){ ?>
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
									<?php } ?>
										<li>
											<a onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/new_cat/'.$form;?>'" href="javascript:;">
											Create New Ad </a>
										</li>-->
										<li class="dropdown">
											<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
											Select Desk &nbsp;<i class="fa fa-angle-down"></i>
											</a>
											<ul class="dropdown-menu">
											<?php 
											$types = $this->db->get_where('help_desk',array('active'=>'1'))->result_array();
											foreach($types as $type)
											{ ?>
												<li>
													<a href="<?php echo base_url().index_page().'team-lead/home/cshift/'.$type['id']; ?>">
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
	<?php echo '<h5 style="color:#900;">'.$this->session->flashdata('message').'</h5>'; ?>
	<?php  if($display_type == 'assign'){ //assign ?>	
        <div class="row">
        <div class="col-md-12">
		 <form Method="POST" onsubmit="return myFunction(this)">	
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<p><?php  $type = $this->db->get_where('help_desk',array('active'=>'1','id'=>$form))->result_array(); ?>
									<?php echo $type[0]['name']; ?>
								</p>
							</div>

							<div class="tools margin-right-10">
								<?php  $design_assign = $this->db->get_where('design_assign')->result_array();		
								foreach($design_assign as $result){ ?>
								<button class="btn green-haze btn-circle btn-sm" type="submit" name="submit"  value="<?php echo $result['id']; ?>"><?php echo $result['name']; ?></button>
							<?php } ?>
							<a class="reload" onclick="myFunction()"></a>
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
							<?php if($form=='5')echo '<th style="vertical-align: middle;">Design Team</th>'; ?>
								<th>Assign</th>
								<th>Designer Assign</th>
								 <th>C</th>
								
                           </tr>  
							</thead>
							<tbody>
							
						<?php foreach($orders as $row)	
						{
							$order_type = 	$this->db->get_where('orders_type',array('id' => $row['order_type_id']))->result_array();
							$publication = $this->db->query("SELECT * FROM `publications` WHERE id='".$row['publication_id']."'")->result_array();
							$cat_result = $this->db->query("SELECT * FROM `cat_result` WHERE `order_no`='".$row['id']."'")->result_array();						
							$status = 	$this->db->get_where('order_status',array('id' => $row['status']))->result_array();					
							$dteam = 	$this->db->get_where('publications',array('id' => $row['publication_id']))->result_array();					
							$adreps = $this->db->query("SELECT `first_name` FROM `adreps` WHERE `id`='".$row['adrep_id']."' ;")->result_array();
							//$design_assign = 	$this->db->get_where('design_assign')->result_array();					
						 ?>
						
							<tr <?php if($row['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="bg-red-pink"'; } ?>>
								<td><?php $date = strtotime($row['created_on']); echo date('d-M', $date); ?></td>
								<td title="<?php echo $order_type[0]['name']; ?>"><span class="badge bg-blue"><?php if($order_type[0]['id']=='1') {echo "W"; } if($order_type[0]['id']=='2') { echo "P"; } if($order_type[0]['id']=='3') { echo "P&W";}?></span></td>
								<td><a <?php if($row['rush']==1){ echo "class='font-grey-cararra'";} ?> href="<?php echo base_url().index_page().'team-lead/home/orderview/'.$row['help_desk'].'/'.$row['id']; ?>"><?php echo $row['id']; ?></a></td>
								<td><?php echo $row['job_no']; ?></td>
								<td><?php echo $publication[0]['name'];?></td>
								<td><?php echo $adreps[0]['first_name'];?></td>
								<?php if($row['help_desk']=='5' && $dteam[0]['design_team_id']=='4'){echo "<td>D6</td>";}elseif($row['help_desk']=='5' && $dteam[0]['design_team_id']=='5'){ echo "<td>D7</td>"; } ?>
								
								<td> <?php if($cat_result[0]['assign']!='0') {$design_assign_name = 	$this->db->get_where('design_assign',array('id' => $cat_result[0]['assign']))->result_array(); echo $design_assign_name[0]['name'];} else { ?>
									<input type="checkbox" name="assign[]" id="assign[]" value="<?php echo $cat_result[0]['id']; ?>">
									<input name="cat_id" value="<?php echo $cat_result[0]['id']; ?>" hidden />
									<?php } ?>
								</td> 
								<!-- Designer Assign -->
								<td>
									<?php if($cat_result[0]['tag_designer']=='0'){ ?>
									<input type="checkbox" name="assign_designer[]" id="assign_designer[]" value="<?php echo $cat_result[0]['id']; ?>">
									<?php }else{ 
									$cat_designer_name = $this->db->get_where('designers',array('id' => $cat_result[0]['tag_designer']))->result_array();
									echo $cat_designer_name[0]['username']; } ?>
								</td> 
								<td <?php if($row['question']=='1') { echo 'class="danger"'; } if($row['question']=='2') { echo 'class="success"'; } ?>><?php echo $cat_result[0]['category']; ?></td>
							</tr>
				<?php } ?>	
								<?php if(isset($tag_designer_teamlead) && count($tag_designer_teamlead) > '0') { foreach($tag_designer_teamlead as $tag_row){ 
								$designer_name = $this->db->query("SELECT * FROM `designers` WHERE `id` = '".$tag_row['designer_id']."' ")->result_array();
								?>
								
								<button class="btn green-haze btn-circle btn-sm" type="submit" name="submit_designer"  value="<?php echo $tag_row['designer_id']; ?>"><?php if(isset($designer_name)) { echo $designer_name[0]['username'];  }?></button>
								
								<?php } } ?>
							</form>
							</tbody>
						</table>
						</div>
					</div>
				</div>
        
		</div>
	<?php } ?>
				
				
<?php if($display_type=='design_check') { ?>  <!--design check-->
	 <div class="row">
        <div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<p><?php  $type = $this->db->get_where('help_desk',array('active'=>'1','id'=>$form))->result_array(); ?>
									<?php echo $type[0]['name']; ?>
								</p>
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
								<th>Date</th>
								<th>T</th>
								<th>AdwitAds ID</th>
								<th>Unique Job Name</th>
								<th>Adrep</th>
								<th>Publication</th>
							<?php if($form=='5')echo '<th style="vertical-align: middle;">Design Team</th>'; ?>
								 <th>C</th>
								 <th>Designer</th>
								<th>Status</th>
                           </tr>  
							</thead>
							<tbody>
						<?php 
						foreach($orders_inproduction as $row){
							$cat_result = $this->db->query("SELECT * FROM `cat_result` WHERE `order_no`='".$row['id']."' AND (`pro_status` ='2' OR `pro_status` = '8'); ")->result_array();
							foreach($cat_result as $row1)
							{
								$order_type = $this->db->get_where('orders_type',array('id' => $row['order_type_id']))->result_array();
								$publication = $this->db->query("SELECT * FROM `publications` WHERE id='".$row['publication_id']."'")->result_array();
								$adreps = $this->db->query("SELECT `first_name` FROM `adreps` WHERE `id`='".$row['adrep_id']."' ;")->result_array();
								$status = $this->db->get_where('production_status',array('id' => $row1['pro_status']))->result_array();				
								$dteam = $this->db->get_where('publications',array('id' => $row['publication_id']))->result_array();
								$designer = $this->db->query("SELECT `username` FROM `designers` WHERE `id`='".$row1['designer']."' ;")->result_array();								
											
						?>
							<tr <?php if($row['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="bg-red-pink"'; } ?>>
								<td><?php $date = strtotime($row['created_on']); echo date('d-M', $date); ?></td>
								<td title="<?php echo $order_type[0]['name']; ?>"><span class="badge bg-blue"><?php if($order_type[0]['id']=='1') {echo "W"; } if($order_type[0]['id']=='2') { echo "P"; } if($order_type[0]['id']=='3') { echo "P&W";}?></span></td>
								<td><a <?php if($row['rush']==1){ echo "class='font-grey-cararra'";} ?> href="<?php echo base_url().index_page().'team-lead/home/orderview/'.$row['help_desk'].'/'.$row['id']; ?>"><?php echo $row['id']; ?></a></td>
								<td><?php echo $row['job_no']; ?></td>
								<td><?php echo $adreps[0]['first_name'];?></td>
								<td><?php echo $publication[0]['name'];?></td>
								<?php if($form=='5' && $dteam[0]['design_team_id']=='4'){echo "<td>D6</td>";}elseif($form=='5' && $dteam[0]['design_team_id']=='5'){ echo "<td>D7</td>"; } ?>
								<td <?php if($row['question']=='1') { echo 'class="danger"'; } if($row['question']=='2') { echo 'class="success"'; } ?>><?php echo $row1['category']; ?></td>
								<!--Status-->
								<td><?php echo $designer[0]['username'];?></td>
								<td>
								<a  class="btn btn-xs btn-success" <?php if($row['rush']==1){ echo "class='font-grey-cararra'";} ?> href="<?php echo base_url().index_page().'team-lead/home/orderview/'.$row['help_desk'].'/'.$row['id']; ?>">
								<?php if(isset($status[0]['name'])) { echo $status[0]['name']; } else{ echo"None"; } ?>
								</a>
								<!--temp file check in directory-->
									<?php
									$inddtemp1 = $row1['source_path'].'/'.'temp1'.".indd";
									$pdftemp1 = $row1['source_path'].'/'.'temp1'.".pdf";
									
									$inddtemp2 = $row1['source_path'].'/'.'temp2'.".indd";
									$pdftemp2 = $row1['source_path'].'/'.'temp2'.".pdf";
									
									$inddtemp3 = $row1['source_path'].'/'.'temp3'.".indd";
									$pdftemp3 = $row1['source_path'].'/'.'temp3'.".pdf";
									
									if((file_exists($inddtemp1) && file_exists($pdftemp1)) || (file_exists($inddtemp2) && file_exists($pdftemp2)) ||
									(file_exists($inddtemp3) && file_exists($pdftemp3))) { ?>
										<i class="fa fa-flag"></i>
									<?php } else{ echo ' ';}
									?>
								<!--temp file check in directory-->
								</td>
							</tr>
						<?php } } ?>	
							</tbody>
						</table>
						</div>
					</div>
				</div>
        </div>	
	<?php } ?>
<!--design check-->

	<?php if($display_type=='all_pending') { ?> <!-- all pending -->
 
<div class="row">
        <div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<p><?php  $type = $this->db->get_where('help_desk',array('active'=>'1','id'=>$form))->result_array(); ?>
									<?php echo $type[0]['name']; ?>
								</p>
							</div>
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
							<?php if($form=='5')echo '<th style="vertical-align: middle;">Design Team</th>'; ?>
								 <th>C</th>
								 <th>Designer</th>
								 <th>Status</th>
                           </tr>  
							</thead>
							<tbody>
							
					<?php foreach($orders_pending as $row){
						
							$order_type = 	$this->db->get_where('orders_type',array('id' => $row['order_type_id']))->result_array();
							$publication = $this->db->query("SELECT * FROM `publications` WHERE id='".$row['publication_id']."'")->result_array();
							$adreps = $this->db->query("SELECT `first_name` FROM `adreps` WHERE `id`='".$row['adrep_id']."' ;")->result_array();
							$cat_result = $this->db->query("SELECT * FROM `cat_result` WHERE `order_no`='".$row['id']."'")->result_array();						
							//$status = 	$this->db->get_where('order_status',array('id' => $row['status']))->result_array();
							if($cat_result && $cat_result[0]['pro_status']!='0'){
								$status = $this->db->get_where('production_status',array('id' => $cat_result[0]['pro_status']))->result_array();					
							}else{
								$status = 	$this->db->get_where('order_status',array('id' => $row['status']))->result_array();					
							}
							$dteam = $this->db->get_where('publications',array('id' => $row['publication_id']))->result_array();					
							$design_assign = $this->db->get_where('design_assign')->result_array();					
							$designer = $this->db->query("SELECT `username` FROM `designers` WHERE `id`='".$cat_result[0]['designer']."' ;")->result_array();								
						?>
						
							<tr <?php if($row['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="bg-red-pink"'; } ?>>
								<td><?php $date = strtotime($row['created_on']); echo date('d-M', $date); ?></td>
								<td title="<?php echo $order_type[0]['name']; ?>"><span class="badge bg-blue"><?php if($order_type[0]['id']=='1') {echo "W"; } if($order_type[0]['id']=='2') { echo "P"; } if($order_type[0]['id']=='3') { echo "P&W";}?></span></td>
								<td><a <?php if($row['rush']==1){ echo "class='font-grey-cararra'";} ?> href="<?php echo base_url().index_page().'team-lead/home/orderview/'.$row['help_desk'].'/'.$row['id']; ?>"><?php echo $row['id']; ?></a></td>
								<td><?php echo $row['job_no']; ?></td>
								<td><?php echo $adreps[0]['first_name'];?></td>
								<td><?php echo $publication[0]['name'];?></td>
								<?php if($row['help_desk']=='5' && $dteam[0]['design_team_id']=='4'){echo "<td>D6</td>";}elseif($row['help_desk']=='5' && $dteam[0]['design_team_id']=='5'){ echo "<td>D7</td>"; } ?>
								<td <?php if($row['question']=='1') { echo 'class="danger"'; } if($row['question']=='2') { echo 'class="success"'; } ?>><?php echo $cat_result[0]['category']; ?></td>
								<td><?php if($designer){ echo $designer[0]['username']; } else { echo ' ' ; }?></td>
								<!--Status-->
								<td>
								<a class="btn btn-xs btn-success" href="<?php echo base_url().index_page().'team-lead/home/orderview/'.$row['help_desk'].'/'.$row['id']; ?>">
								<?php if(isset($status[0]['name'])) { echo $status[0]['name']; } else{ echo"None"; } ?>
								</a>
								</td>
							</tr>
					<?php } ?>	
							
							</tbody>
						</table>
						</div>
					</div>
				</div>
        
		</div>
	<?php } ?>
        
	<?php if($display_type=='all') { ?> <!-- all-->
 
<div class="row">
        <div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<p><?php  $type = $this->db->get_where('help_desk',array('active'=>'1','id'=>$form))->result_array(); ?>
									<?php echo $type[0]['name']; ?>
								</p>
							</div>
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
							<?php if($form=='5')echo '<th style="vertical-align: middle;">Design Team</th>'; ?>
								 <th>C</th>
								 <th>Status</th>
                           </tr>  
							</thead>
							<tbody>
							
					<?php foreach($all_orders as $row){
						
							$order_type = 	$this->db->get_where('orders_type',array('id' => $row['order_type_id']))->result_array();
							$publication = $this->db->query("SELECT * FROM `publications` WHERE id='".$row['publication_id']."'")->result_array();
							$adreps = $this->db->query("SELECT `first_name` FROM `adreps` WHERE `id`='".$row['adrep_id']."' ;")->result_array();
							$cat_result = $this->db->query("SELECT * FROM `cat_result` WHERE `order_no`='".$row['id']."'")->result_array();						
							//$status = 	$this->db->get_where('order_status',array('id' => $row['status']))->result_array();
							if($cat_result && $cat_result[0]['pro_status']!='0'){
								$status = $this->db->get_where('production_status',array('id' => $cat_result[0]['pro_status']))->result_array();					
							}else{
								$status = 	$this->db->get_where('order_status',array('id' => $row['status']))->result_array();					
							}
							$dteam = $this->db->get_where('publications',array('id' => $row['publication_id']))->result_array();					
							$design_assign = $this->db->get_where('design_assign')->result_array();					
						 ?>
						
							<tr <?php if($row['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="bg-red-pink"'; } ?>>
								<td><?php $date = strtotime($row['created_on']); echo date('d-M', $date); ?></td>
								<td title="<?php echo $order_type[0]['name']; ?>"><span class="badge bg-blue"><?php if($order_type[0]['id']=='1') {echo "W"; } if($order_type[0]['id']=='2') { echo "P"; } if($order_type[0]['id']=='3') { echo "P&W";}?></span></td>
								<td><a <?php if($row['rush']==1){ echo "class='font-grey-cararra'";} ?> href="<?php echo base_url().index_page().'team-lead/home/orderview/'.$row['help_desk'].'/'.$row['id']; ?>"><?php echo $row['id']; ?></a></td>
								<td><?php echo $row['job_no']; ?></td>
								<td><?php echo $adreps[0]['first_name'];?></td>
								<td><?php echo $publication[0]['name'];?></td>
								<?php if($row['help_desk']=='5' && $dteam[0]['design_team_id']=='4'){echo "<td>D6</td>";}elseif($row['help_desk']=='5' && $dteam[0]['design_team_id']=='5'){ echo "<td>D7</td>"; } ?>
								<td <?php if($row['question']=='1') { echo 'class="danger"'; } if($row['question']=='2') { echo 'class="success"'; } ?>><?php if($cat_result) { echo $cat_result[0]['category'] ;} else { echo " " ;} ?></td>
								<!--Status-->
								<td>
								<a class="btn btn-xs btn-success" href="<?php echo base_url().index_page().'team-lead/home/orderview/'.$row['help_desk'].'/'.$row['id']; ?>">
								<?php if(isset($status[0]['name'])) { echo $status[0]['name']; } else{ echo"None"; } ?>
								</a>
								</td>
							</tr>
					<?php } ?>	
							
							</tbody>
						</table>
						</div>
					</div>
				</div>
        
		</div>
	<?php } ?>
		
		
		
		</div>
</div>
</div>
	<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->

<script>
function printPage() {
    window.print();
}

</script>

<?php
       $this->load->view("team-lead/foot"); 
?>
