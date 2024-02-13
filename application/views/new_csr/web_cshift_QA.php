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
								
								<!-- Collect the nav links, forms, and other content for toggling -->
								<div class="collapse navbar-collapse navbar-ex1-collapse">
									<ul class="nav navbar-nav">
										<li>
											<a href="<?php echo base_url().index_page().'new_csr/home/web_cshift/';?>">
											Category<span class="badge bg-red"></span></a>
										</li>
										<li class="active">
											<a href="<?php echo base_url().index_page().'new_csr/home/web_cshift/QA';?>">
											QA<span class="badge bg-green"></span></a>
										</li>
										<li>
											<a href="<?php echo base_url().index_page().'new_csr/home/web_cshift/DC';?>">
											DC<span class="badge bg-green"></span></a>
										</li>
										<li>
											<a href="<?php echo base_url().index_page().'new_csr/home/web_cshift/new_pending';?>">
										    All<span class="badge bg-green"></span></a>
										</li>
									</ul>
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
		
        <div class="row">
        <div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cogs font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold">QA Pending List</span>
							</div>
							<div class="tools">
								<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()"></a>
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
                <th style="text-align: center;">QA</th>
              </tr>              
            </thead>
            <tbody name="testTable" id="testTable">
<?php 
		foreach($All_pending as $row)
		{	$form = $row['help_desk'];
			$cat_result = $this->db->get_where('cat_result',array('order_no'=>$row['id'], 'pro_status'=>'3'))->result_array();
			if($cat_result)
			{
				//$order_type = $this->db->get_where('orders_type',array('id' => $row['order_type_id']))->result_array();
				$publication_name = $this->db->query("SELECT `name` FROM `publications` WHERE `id`='".$row['publication_id']."' ;")->result_array();		
				
?>
              <tr <?php if($row['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="odd gradeX error"'; } ?>>

<!-- date -->			<td><?php $date = strtotime($cat_result[0]['timestamp']); echo date('Y-m-d', $date); ?></td>

<!-- type -->			<td title="<?php echo'web'; ?>"><span class="badge bg-blue"><?php echo "W"; ?></span></td>

<!-- order_no --> 		<td title="OrderView"><a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;"><?php echo $row['id']; ?></a></td>

<!-- job_name -->		<td><?php echo $cat_result[0]['job_name']; ?></td>

<!-- newspaper -->		<td><?php echo $publication_name[0]['name']; ?></td>
		           
<!-- QA -->            	<td><a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;"><button class="btn blue btn-xs" >QA</button></a></td>     

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

<?php $this->load->view("new_csr/foot.php"); ?>