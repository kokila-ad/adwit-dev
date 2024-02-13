<?php
       $this->load->view("team-lead/head"); 
?>
<!-- BEGIN PAGE CONTAINER -->
	<!-- END PAGE CONTENT -->
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
									<?php if(isset($form)) {  $type = $this->db->get_where('help_desk',array('active'=>'1','id'=>$form))->result_array(); ?>
									<a class="navbar-brand" href="javascript:;">
									<?php echo $type[0]['name']; } ?> </a>
									
									<!--<?php if(isset($form)){ ?>
									<a  class="navbar-brand"  href="<?php echo base_url().index_page().'team-lead/home/assign/';?><?php echo $form; ?>">Assign</a>
									<a  class="navbar-brand"  href="<?php echo base_url().index_page().'team-lead/home/all_pending/';?><?php echo $form; ?>">All Pending</a>
								    <?php } ?>-->
								</div>
								<!-- Collect the nav links, forms, and other content for toggling -->
								
								<div class="collapse navbar-collapse navbar-ex1-collapse">
								
								<!--<form class="navbar-form navbar-left"  name="form" method="post" action="<?php echo base_url().index_page().'team-lead/home/cshift_search'; ?>">
										<div class="form-group">
											<input type="text" class="form-control" placeholder="Search"  name="id" autocomplete="off" required/>
										</div>
										<button type="submit" class="btn blue" name="search">Search</button>
									</form>-->
								
									<ul class="nav navbar-nav navbar-right">
										<li class="dropdown">
											<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
											Select Group &nbsp;<i class="fa fa-angle-down"></i>
											</a>
											<ul class="dropdown-menu">
											<?php 
											$types = $this->db->get_where('help_desk',array('active'=>'1'))->result_array();
											foreach($types as $type)
				                            { ?>
												<li>
													<a href="<?php echo base_url().index_page().'team-lead/home/design_check/';?><?php echo $type['id']; ?>">
													<?php echo $type['name']; ?> </a>
												</li>
										 <?php } ?>
											</ul>
										</li>
									</ul>
								</div>
	                     </div>
	               </div>
        </div>
	<?php 
		echo '<h5 style="color:#900;">'.$this->session->flashdata('message').'</h5>'; 
		if(isset($form)) { 
	?>
	 <div class="row">
        <div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<div class="btn-group">
									<a class="btn btn-default" href="<?php echo base_url().index_page().'team-lead/home/assign/';?><?php echo $form; ?>">Assign - <?php echo $orders; ?></a></button>
									<button type="button" class="btn green">Design Check</button>
									<a class="btn btn-default  margin-right-10" href="<?php echo base_url().index_page().'team-lead/home/all_pending/';?><?php echo $form; ?>">All Pending- <?php echo $orders_pending; ?></a></button>
									<?php echo '<span style="color:#900;">'.$this->session->flashdata('ext_message').'</span>'; ?>
								</div>
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
								<th>Adwit Id</th>
								<th>Job Name</th>
								<th>Publication</th>
							<?php if($form=='5')echo '<th style="vertical-align: middle;">Design Team</th>'; ?>
								 <th>C</th>
								<th>Status</th>
                           </tr>  
							</thead>
							<tbody>
						<?php 
						foreach($orders_inproduction as $row){
							$cat_result = $this->db->query("SELECT * FROM `cat_result` WHERE `order_no`='".$row['id']."' AND `pro_status` ='2'; ")->result_array();
							foreach($cat_result as $row1)
							{
								$order_type = $this->db->get_where('orders_type',array('id' => $row['order_type_id']))->result_array();
								$publication = $this->db->query("SELECT * FROM `publications` WHERE id='".$row['publication_id']."'")->result_array();
								$status = $this->db->get_where('production_status',array('id' => $row1['pro_status']))->result_array();				
								$dteam = $this->db->get_where('publications',array('id' => $row['publication_id']))->result_array();	 
											
						?>
							<tr <?php if($row['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="bg-red-pink"'; } ?>>
								<td><?php $date = strtotime($row['created_on']); echo date('d-M', $date); ?></td>
								<td title="<?php echo $order_type[0]['name']; ?>"><span class="badge bg-blue"><?php if($order_type[0]['id']=='1') {echo "W"; } if($order_type[0]['id']=='2') { echo "P"; } if($order_type[0]['id']=='3') { echo "P&W";}?></span></td>
								<td><a <?php if($row['rush']==1){ echo "class='font-grey-cararra'";} ?> href="<?php echo base_url().index_page().'team-lead/home/orderview/';?><?php echo $row['help_desk'] ?>/<?php echo $row['id']; ?>"><?php echo $row['id']; ?></a></td>
								<td><?php echo $row['job_no']; ?></td>
								<td><?php echo $publication[0]['name'];?></td>
								<?php if($form=='5' && $dteam[0]['design_team_id']=='4'){echo "<td>D6</td>";}elseif($form=='5' && $dteam[0]['design_team_id']=='5'){ echo "<td>D7</td>"; } ?>
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
</div>
</div>
</div>
<!-- END PAGE CONTAINER -->

<!-- BEGIN FOOTER -->
<?php
       $this->load->view("team-lead/foot"); 
?>
      