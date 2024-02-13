<?php $this->load->view("team-lead/head"); ?>
<!-- BEGIN PAGE CONTAINER -->

<div class="page-container"> 
	<!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="navbar navbar-default" role="navigation">
								<!-- Brand and toggle get grouped for better mobile display -->
								<span style="margin-left: 20px; padding: 0 10px;" class="font-blue">
										<?php echo $this->session->flashdata('sucess_message'); ?>	
										<?php echo $this->session->flashdata('message'); ?>
								</span>
								<!-- Collect the nav links, forms, and other content for toggling -->
								<div class="collapse navbar-collapse navbar-ex1-collapse">
									<ul class="nav navbar-nav">
										<?php  if($display_type == 'web_assign'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
											<a href="<?php echo base_url().index_page().'team-lead/home/web_cshift/web_assign';?>">
											Assign<span class="badge bg-red"></span></a>
										</li>
										<?php  if($display_type == 'web_design_check'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
											<a href="<?php echo base_url().index_page().'team-lead/home/web_cshift/web_design_check';?>">
											Design Check<span class="badge bg-green"></span></a>
										</li>
										<?php  if($display_type == 'web_all_pending'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
											<a href="<?php echo base_url().index_page().'team-lead/home/web_cshift/web_all_pending';?>">
											All Pending<span class="badge bg-green"></span></a>
										</li>
									</ul>
								</div>
								<!-- /.navbar-collapse -->
					</div>
				
			</div>
        </div>
		<!--web_cshift_category-->
		<?php if($display_type=='web_assign') { ?>
        <div class="row">
        <div class="col-md-12">
		 <form Method="POST" action="" onsubmit="return myFunction(this)">	
					<div class="portlet light">
						<div class="portlet-title">

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
								<th>DT</th>
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
							$adreps = $this->db->query("SELECT `first_name` FROM `adreps` WHERE `id`='".$row['adrep_id']."' ;")->result_array();
							$cat_result = $this->db->query("SELECT * FROM `cat_result` WHERE `order_no`='".$row['id']."'")->result_array();						
							$status = 	$this->db->get_where('order_status',array('id' => $row['status']))->result_array();					
							$dteam = 	$this->db->get_where('publications',array('id' => $row['publication_id']))->result_array();					
							//$design_assign = 	$this->db->get_where('design_assign')->result_array();					
						 ?>
						
							<tr <?php if($row['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="bg-red-pink"'; } ?>>
								<td><?php $date = strtotime($row['created_on']); echo date('d-M', $date); ?></td>
								<td title="<?php echo $order_type[0]['name']; ?>"><span class="badge bg-blue"><?php if($order_type[0]['id']=='1') {echo "W"; } if($order_type[0]['id']=='2') { echo "P"; } if($order_type[0]['id']=='3') { echo "P&W";}?></span></td>
								<td><a <?php if($row['rush']==1){ echo "class='font-grey-cararra'";} ?> href="<?php echo base_url().index_page().'team-lead/home/orderview/';?><?php echo $row['help_desk'] ?>/<?php echo $row['id']; ?>"><?php echo $row['id']; ?></a></td>
								<td><?php echo $row['job_no']; ?></td>
								<td><?php echo $adreps[0]['first_name'];?></td>
								<td><?php echo $publication[0]['name'];?></td>
								<td><?php if($row['help_desk']=='5' && $dteam[0]['design_team_id']=='4'){echo "D6";}elseif($row['help_desk']=='5' && $dteam[0]['design_team_id']=='5'){ echo "D7"; }else{ echo " "; } ?></td>
								
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
						<?php }?>
						<?php if(isset($tag_designer_teamlead) && count($tag_designer_teamlead) > '0') { foreach($tag_designer_teamlead as $tag_row){ 
								$designer_name = $this->db->query("SELECT * FROM `designers` WHERE `id` = '".$tag_row['designer_id']."' ")->result_array();
								?>
								
								<button class="btn green-haze btn-circle btn-sm" type="submit" name="submit_designer"  value="<?php echo $tag_row['designer_id']; ?>"><?php if(isset($designer_name)) { echo $designer_name[0]['username'];  }?></button>
								
								<?php } } ?>
							
							</tbody>
						</table>
						</div>
					</div>
				</form> 
				</div>
        
		</div>
		<?php } ?>
		 <!--web_cshift_assign-->
		 
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
                           </tr>  
							</thead>
							<tbody>
						<?php 
						foreach($orders_inproduction as $row){
							$form = $row['help_desk'];
							$cat_result = $this->db->query("SELECT * FROM `cat_result` WHERE `order_no`='".$row['id']."' AND `pro_status` ='2'; ")->result_array();
							foreach($cat_result as $row1)
							{
								$order_type = $this->db->get_where('orders_type',array('id' => $row['order_type_id']))->result_array();
								$publication = $this->db->query("SELECT * FROM `publications` WHERE id='".$row['publication_id']."'")->result_array();
								$adreps = $this->db->query("SELECT `first_name` FROM `adreps` WHERE `id`='".$row['adrep_id']."' ;")->result_array();
								$status = $this->db->get_where('production_status',array('id' => $row1['pro_status']))->result_array();				
								$dteam = $this->db->get_where('publications',array('id' => $row['publication_id']))->result_array();	 
											
						?>
							<tr <?php if($row['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="bg-red-pink"'; } ?>>
								<td><?php $date = strtotime($row['created_on']); echo date('d-M', $date); ?></td>
								<td title="<?php echo $order_type[0]['name']; ?>"><span class="badge bg-blue"><?php if($order_type[0]['id']=='1') {echo "W"; } if($order_type[0]['id']=='2') { echo "P"; } if($order_type[0]['id']=='3') { echo "P&W";}?></span></td>
								<td><a <?php if($row['rush']==1){ echo "class='font-grey-cararra'";} ?> href="<?php echo base_url().index_page().'team-lead/home/orderview/';?><?php echo $row['help_desk'] ?>/<?php echo $row['id']; ?>"><?php echo $row['id']; ?></a></td>
								<td><?php echo $row['job_no']; ?></td>
								<td><?php echo $adreps[0]['first_name'];?></td>
								<td><?php echo $publication[0]['name'];?></td>
								<td><?php if($row['help_desk']=='5' && $dteam[0]['design_team_id']=='4'){echo "D6";}elseif($row['help_desk']=='5' && $dteam[0]['design_team_id']=='5'){ echo "D7"; }else{ echo " "; } ?></td>
								
								<td <?php if($row['question']=='1') { echo 'class="danger"'; } if($row['question']=='2') { echo 'class="success"'; } ?>><?php echo $row1['category']; ?></td>
								<td><?php if(isset($status[0]['name'])) { echo '<span class="label label-sm label-success">'.$status[0]['name'].' </span>'; } else{ echo"None"; } ?></td>
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

					<!--<div class="actions btn-set">
          <a href=""><button type="button" class="btn green-haze btn-circle">Total Count - <?php echo count($orders_pending); ?></button></a>
          <a href="<?php echo base_url().index_page().'team-lead/home/design_check/'.$form;?>"><button type="button" class="btn green-haze btn-circle">In Design - <?php echo count($orders_inproduction); ?></button></a>
          <a href="<?php echo base_url().index_page().'team-lead/home/assign/'.$form;?>"><button  type="button" class="btn green-haze btn-circle">In Assign - <?php echo count($orders); ?></button></a>
					</div>-->
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
						 ?>
						
							<tr <?php if($row['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="bg-red-pink"'; } ?>>
								<td><?php $date = strtotime($row['created_on']); echo date('d-M', $date); ?></td>
								<td title="<?php echo $order_type[0]['name']; ?>"><span class="badge bg-blue"><?php if($order_type[0]['id']=='1') {echo "W"; } if($order_type[0]['id']=='2') { echo "P"; } if($order_type[0]['id']=='3') { echo "P&W";}?></span></td>
								<td><a <?php if($row['rush']==1){ echo "class='font-grey-cararra'";} ?> href="<?php echo base_url().index_page().'team-lead/home/orderview/';?><?php echo $row['help_desk'] ?>/<?php echo $row['id']; ?>"><?php echo $row['id']; ?></a></td>
								<td><?php echo $row['job_no']; ?></td>
								<td><?php echo $adreps[0]['first_name'];?></td>
								<td><?php echo $publication[0]['name'];?></td>
								<td><?php if($row['help_desk']=='5' && $dteam[0]['design_team_id']=='4'){echo "D6";}elseif($row['help_desk']=='5' && $dteam[0]['design_team_id']=='5'){ echo "D7"; }else{ echo " "; } ?></td>
								<td <?php if($row['question']=='1') { echo 'class="danger"'; } if($row['question']=='2') { echo 'class="success"'; } ?>><?php echo $cat_result[0]['category']; ?></td>
								<td><?php if(isset($status[0]['name'])) { echo $status[0]['name']; } else{ echo"None"; } ?></td>
							</tr>
					<?php } ?>	
							
							</tbody>
						</table>
						</div>
					</div>
				</div>
        
		</div>
		 <?php } ?>
		 <!--web_cshift_DC-->
		 
		
        
		</div>
</div>
</div>
	<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->
<?php $this->load->view("team-lead/foot"); ?> 