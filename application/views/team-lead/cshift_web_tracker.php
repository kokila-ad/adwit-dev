<?php
       $this->load->view("team-lead/head"); 
?>
<!-- BEGIN PAGE CONTAINER -->
	<!-- END PAGE CONTENT -->
	<div class="page-container">
	<!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
		<div class="container">
		

		<?php echo '<h5 style="color:#900;">'.$this->session->flashdata('message').'</h5>'; { ?>
	   <div class="row">
        <div class="col-md-12">
		 <form Method="POST" action="" onsubmit="return myFunction(this)">	
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<div class="btn-group">
								<button type="button" class="btn green">Assign - <?php echo count($orders); ?></button>
						<a href="<?php echo base_url().index_page().'team-lead/home/web_design_check/';?>" class="btn btn-default">Design Check</a>
						<a class="btn btn-default" href="<?php echo base_url().index_page().'team-lead/home/web_all_pending/';?>">All Pending - <?php echo $orders_pending; ?></a>
								</div>
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
								<th>Adwit Id</th>
								<th>Job Name</th>
								<th>Publication</th>
							<?php //if($form=='5')echo '<th style="vertical-align: middle;">Design Team</th>'; ?>
								<th>Assign</th>
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
							//$design_assign = 	$this->db->get_where('design_assign')->result_array();					
						 ?>
						
							<tr>
								<td><?php $date = strtotime($row['created_on']); echo date('d-M', $date); ?></td>
								<td title="<?php echo $order_type[0]['name']; ?>"><span class="badge bg-blue"><?php if($order_type[0]['id']=='1') {echo "W"; } if($order_type[0]['id']=='2') { echo "P"; } if($order_type[0]['id']=='3') { echo "P&W";}?></span></td>
								<td><a href="<?php echo base_url().index_page().'team-lead/home/orderview/';?><?php echo $row['help_desk'] ?>/<?php echo $row['id']; ?>"><?php echo $row['id']; ?></a></td>
								<td><?php echo $row['job_no']; ?></td>
								<td><?php echo $publication[0]['name'];?></td>
								<?php if($row['help_desk']=='5' && $dteam[0]['design_team_id']=='4'){echo "<td>D6</td>";}elseif($row['help_desk']=='5' && $dteam[0]['design_team_id']=='5'){ echo "<td>D7</td>"; } ?>
								<td> <?php if($cat_result[0]['assign']!='0') {$design_assign_name = 	$this->db->get_where('design_assign',array('id' => $cat_result[0]['assign']))->result_array(); echo $design_assign_name[0]['name'];} else { ?>
									<input type="checkbox" name="assign[]" id="assign[]" value="<?php echo $cat_result[0]['id']; ?>">
									<input name="cat_id" value="<?php echo $cat_result[0]['id']; ?>" hidden />
									<?php } ?>
								</td> 
								<td <?php if($row['question']=='1') { echo 'class="danger"'; } if($row['question']=='2') { echo 'class="success"'; } ?>><?php echo $cat_result[0]['category']; ?></td>
							</tr>
						<?php }?>
						<?php //foreach($design_assign as $result){  } ?>
							
							</tbody>
						</table>
						</div>
					</div>
				</form>
				</div>
        
		</div>
	<?php } ?>
</div>
</div>
</div>
<!-- END PAGE CONTAINER -->
<!-- BEGIN FOOTER -->
<?php
       $this->load->view("team-lead/foot"); 
?>