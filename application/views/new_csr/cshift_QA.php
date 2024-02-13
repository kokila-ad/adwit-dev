<?php $this->load->view("new_csr/head.php"); ?>
 
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
										<li>
											<a href="<?php echo base_url().index_page().'new_csr/home/cshift/'.$form;?>">
											Category <span class="badge bg-red"><?php echo count($c_orders); ?></span></a>
										</li>
										<li class="active">
											<a href="<?php echo base_url().index_page().'new_csr/home/cshift/'.$form.'/QA';?>">
											QA <span class="badge bg-green"><?php echo count($inQA); ?></span></a>
										</li>
										<li>
											<a href="<?php echo base_url().index_page().'new_csr/home/cshift/'.$form.'/DC';?>">
											DC <span class="badge bg-green"><?php echo count($inDC); ?></span></a>
										</li>
										<li>
											<a href="<?php echo base_url().index_page().'new_csr/home/cshift/'.$form.'/new_pending';?>">
										    All <span class="badge bg-green"><?php echo count($All_pending); ?></span></a>
										</li>
									</ul>
									
									
									<ul class="nav navbar-nav navbar-right margin-right-10">
										<li>
											<a onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/new_cat/'.$form;?>'" href="javascript:;">
											Create New Ad </a>
										</li>
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
													<a href="<?php echo base_url().index_page().'new_csr/home/cshift/';?><?php echo $type['id']; ?>">
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
		
        <div class="row">
        <div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<p><?php  $type = $this->db->get_where('help_desk',array('active'=>'1','id'=>$form))->result_array(); ?>
									<?php echo $type[0]['name']; ?></p>
							</div>
							<div class="tools">
									<button class="btn bg-grey btn-sm"><i class="fa fa-file-excel-o"></i> Exel</button>
									<button onclick="printPage()" class="btn bg-grey btn-sm"><i class="fa fa-print"></i> Print</button>
										<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()">
									 </a>
							</div>
						</div>
						<div class="portlet-body">
							<table class="table table-striped table-bordered table-hover" id="sample_6">
							<thead>
            <tr>
				<th style="vertical-align: middle;">Date</th>
				<th style="vertical-align: middle;">Type</th>
                <th style="vertical-align: middle;">Adwit Id</th>
				<th style="vertical-align: middle;">Job Name</th>
				<th style="vertical-align: middle;">Publication</th>											
                <!--<th style="text-align: center;">Category</th>
                <th style="text-align: center;">Design</th>-->
                <th style="vertical-align: middle;">Click to</th>
                <!--<th style="text-align: center;">Upload</th>
				<th style="vertical-align: middle;">Actions</th>-->
              </tr>              
            </thead>
            <tbody name="testTable" id="testTable">
<?php 
		foreach($All_pending as $row)
		{
			$cat_result = $this->db->get_where('cat_result',array('order_no'=>$row['id'], 'pro_status'=>'3'))->result_array();
			if($cat_result)
			{
				$order_type = $this->db->get_where('orders_type',array('id' => $row['order_type_id']))->result_array();
				$publication_name = $this->db->query("SELECT `name` FROM `publications` WHERE `id`='".$row['publication_id']."' ;")->result_array();		
				$order_status = $this->db->get_where('production_status',array('id'=>$cat_result[0]['pro_status']))->result_array();
?>
              <tr <?php if($row['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="odd gradeX error"'; } ?>>

<!-- date -->			<td><?php $date = strtotime($cat_result[0]['timestamp']); echo date('Y-m-d', $date); ?></td>

<!-- type -->			<td title="<?php echo $order_type[0]['name']; ?>"><span class="badge bg-blue"><?php if($order_type[0]['value']=='print') {echo "P";} elseif($order_type[0]['value']=='web'){ echo "W";} else{ echo "P&W";}?></span></td>

<!-- order_no --> 		<td title="OrderView"><a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;"><?php echo $row['id']; ?></a></td>

<!-- job_name -->		<td><?php echo $cat_result[0]['job_name']; ?></td>

<!-- newspaper -->		<td><?php echo $publication_name[0]['name']; ?></td>
		           
<!-- QA -->            	<td <?php if($row['question']=='1') { echo "class='danger'";} if($row['question']=='2') { echo "class='success '";} ?> title="OrderView">
							<a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;">
							<button class="btn blue btn-xs" ><?php echo $order_status[0]['d_name']; ?></button></a>
						</td>     

			  </tr>
   <?php  } } ?>
            </tbody>
          </table>
						</div>
					</div>
				</div>
                </div>
        
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
<?php $this->load->view("new_csr/foot.php"); ?>

