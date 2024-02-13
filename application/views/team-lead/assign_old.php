<?php
       $this->load->view("team-lead/head"); 
?>
<!-- BEGIN HEADER -->
<?php
       $this->load->view("team-lead/top_menu"); 
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
								</div>
								<!-- Collect the nav links, forms, and other content for toggling -->
								
								<div class="collapse navbar-collapse navbar-ex1-collapse">
								
								<form class="navbar-form navbar-left"  name="form" method="post" action="<?php echo base_url().index_page().'team-lead/home/cshift_search'; ?>">
										<div class="form-group">
											<input type="text" class="form-control" placeholder="Search"  name="id" autocomplete="off" required/>
										</div>
										<button type="submit" class="btn blue" name="search">Search</button>
									</form>
								
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
													<a href="<?php echo base_url().index_page().'team-lead/home/assign/';?><?php echo $type['id']; ?>">
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
		<?php echo '<h5 style="color:#900;">'.$this->session->flashdata('message').'</h5>'; if(isset($form)) { ?>
	   <div class="row">
        <div class="col-md-12">
		 <form Method="POST" action="" onsubmit="return myFunction(this)">	
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-green-sharp bold uppercase">Design Pending</span>
							</div>
							<div class="actions btn-set">
								<?php  $design_assign = 	$this->db->get_where('design_assign')->result_array();		foreach($design_assign as $result){ ?>
								<button class="btn green-haze btn-circle" type="submit" name="submit"  value="<?php echo $result['id']; ?>"><?php echo $result['name']; ?></button>
							<?php } ?>
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
                         $design_assign = 	$this->db->get_where('design_assign')->result_array();					
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
						<?php } ?>	
						<?php foreach($design_assign as $result){ ?>
						<?php } ?>
							</form>
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