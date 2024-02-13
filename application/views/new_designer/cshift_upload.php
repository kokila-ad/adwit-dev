		<?php 
	$this->load->view("new_designer/head");
?>
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
									<?php if(isset($form)) $types = $this->db->get_where('help_desk',array('id'=>$form))->result_array(); ?>
									<a class="navbar-brand" href="javascript:;">
									<?php if(isset($form)) echo $types[0]['name']; ?></a>
								</div>
								<!-- Collect the nav links, forms, and other content for toggling -->
								
								<div class="collapse navbar-collapse navbar-ex1-collapse">
									<!--<form class="navbar-form navbar-left" role="search" name="form" method="post" <?php if(isset($form)) { ?>action="<?php echo base_url().index_page().'new_designer/home/cshift_search/'.$form;?>"; <?php } else { ?> action="<?php echo base_url().index_page().'new_designer/home/cshift_search';?>" <?php } ?>>
										<div class="form-group">
										<div class="input-group">
												<input type="text" class="form-control" name="id" type="text" autocomplete="off" required/>
											</div>
											
											<span></span>
									    </div>
										<button type="submit" name="search" class="btn blue">Search</button>
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
												{ 
											?>
												<li>
													<a href="<?php echo base_url().index_page().'new_designer/home/cshift_upload/'.$type['id'];?>">
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
 <?php 
	echo '<h5 style="color:#900;">'.$this->session->flashdata('message').'</h5>';
 if(isset($form)):
 ?>
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
						  <table class="table table-striped table-bordered table-hover" id="sample_6">
							<thead>
							<tr>
								<th>Date</th>
								<th>Type</th>
								<th>Adwit Id</th>
								<th>Job Name</th>
								<th>Publication</th>
								<?php if($form=='5')echo '<th style="vertical-align: middle;">Design Team</th>'; ?>
								<th>Category</th>
								<th>Status</th>
							</tr>
							</thead>
							 <tbody name="testTable" id="testTable">
<?php 
	
	foreach($orders_upload as $row)
	{
		$cat_result = $this->db->query("SELECT * FROM `cat_result` WHERE `order_no`='".$row['id']."' AND `designer` ='".$this->session->userdata('dId')."'; ")->result_array();
		if($cat_result && ($cat_result[0]['pro_status']=='1' || $cat_result[0]['pro_status']=='6' || $cat_result[0]['pro_status']=='7'))
		{
			$order_type = 	$this->db->get_where('orders_type',array('id' => $row['order_type_id']))->result_array();
			//$cat_result = $this->db->query("SELECT * FROM `designers`,`cat_result` WHERE `order_no`='".$row1['id']."' AND designers.id = cat_result.designer ")->result_array();
			//$cat_result = $this->db->get_where('cat_result',array('order_no' => $row['id']))->result_array();
			$publication = $this->db->query("SELECT * FROM `publications` WHERE id='".$row['publication_id']."'")->result_array();
			$status = $this->db->query("SELECT * FROM `production_status` WHERE id='".$cat_result[0]['pro_status']."'")->result_array();
			?>
			  
<!-- date -->			<td><?php $date = strtotime($row['created_on']); echo date('Y-m-d', $date); ?></td>
<!-- type -->			<td title="<?php echo $order_type[0]['name']; ?>"><button type="button" class="btn blue-steel btn-sm"><?php if($order_type[0]['value']=='print') {echo "P";} elseif($order_type[0]['value']=='web'){ echo "W";} else{ echo "P&W";}?></button></td>
<!-- Adwit Id -->		<td title="view attachments">
							<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_designer/home/orderview/'.$form.'/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;">
								<?php echo $row['id']; ?>
							</a>
						</td>							
<!-- job_name -->		<td><?php echo $row['job_no']; ?></td>
<!-- Publication -->	<td><?php echo $publication[0]['name']; ?></td>

<!-- design team -->	<?php if($form=='5' && $publication[0]['design_team_id']=='4'){echo "<td>D6</td>";}elseif($form=='5' && $publication[0]['design_team_id']=='5'){ echo "<td>D7</td>"; } ?>

<!-- Category -->		<td <?php if($row['question']=='1') { echo 'class="danger"'; } if($row['question']=='2') { echo 'class="success"'; } ?>>
							<!--rushad-->
							<?php  if($cat_result){echo $cat_result[0]['category'];}else{echo 'Pending';} ?>
						</td>
								
<!-- Design -->			<td>
						<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_designer/home/orderview/'.$form.'/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;">
							<button class="btn blue-sunglo btn-xs"><?php if($status)echo $status[0]['name']; ?></button>
						</a>
						</td>
				 </tr>
   <?php  } 
  }  ?>
            </tbody>
						</table>
						</div>
					</div>
				</div>
        </div>
		<?php  endif; ?>
        </div>
</div>
</div>
	<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->



<!-- BEGIN FOOTER -->
<?php 
	$this->load->view("new_designer/foot");
?>