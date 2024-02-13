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
										<li>
											<a href="<?php echo base_url().index_page().'new_csr/home/web_cshift/QA';?>">
											QA<span class="badge bg-green"></span></a>
										</li>
										<li>
											<a href="<?php echo base_url().index_page().'new_csr/home/web_cshift/DC';?>">
											DC<span class="badge bg-green"></span></a>
										</li>
										<li class="active">
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
								<span class="caption-subject font-green-sharp bold">All Pending List</span>
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
				<th style="vertical-align: middle;">Status</th>
			</tr>              
            </thead>
            <tbody name="testTable" id="testTable">
<?php 
		foreach($All_pending as $row1)
		{	$form = $row1['help_desk'];
			//$order_type = 	$this->db->get_where('orders_type',array('id' => $row1['order_type_id']))->result_array();
			$publication = $this->db->query("SELECT `name` FROM `publications` WHERE `id`='".$row1['publication_id']."' ;")->result_array();		
			
?>
              <tr <?php if($row1['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="odd gradeX error"'; } ?>>
<!-- Date -->			<td><?php $date = strtotime($row1['created_on']); echo date('Y-m-d', $date); ?></td>
<!-- type -->			<td title="<?php echo'web'; ?>"><span class="badge bg-blue"><?php echo "W"; ?></span></td>
<!-- Order_no --> 		<td title="view attachments"><a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;"><?php echo $row1['id']; ?></a></td>

<!-- Job_name -->		<td><?php echo $row1['job_no']; ?></td>
<!-- Newspaper -->		<td><?php echo $publication[0]['name']; ?></td>

<!-- Status -->			<?php if($row1['status']=='1') { ?><td <?php if($row1['question']=='1') { echo "class='danger'";} if($row1['question']=='2') { echo "class='success '";} ?>><a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/cshift_category/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;" ><button class="btn blue btn-xs" >category</button></a></td><?php } ?>
<!-- Status -->			<?php if($row1['status']=='2') { ?><td <?php if($row1['question']=='1') { echo "class='danger'";} if($row1['question']=='2') { echo "class='success '";} ?>><a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;"><button class="btn blue btn-xs" >View</button></a></td><?php } ?>
<!-- Status -->			<?php if($row1['status']=='3') { ?><td <?php if($row1['question']=='1') { echo "class='danger'";} if($row1['question']=='2') { echo "class='success '";} ?>><a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;"><button class="btn blue btn-xs" >QA</button></a></td><?php } ?>
<!-- Status -->			<?php if($row1['status']=='4') { ?><td <?php if($row1['question']=='1') { echo "class='danger'";} if($row1['question']=='2') { echo "class='success '";} ?>><a href="<?php echo base_url().index_page().'new_csr/home/pdf_upload/'.$row1['id'];?>" onclick="javascript:void window.open('<?php echo base_url().index_page().'new_csr/home/pdf_upload/'.$row1['id'];?>','1432728298066','width=800,height=650,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=50,top=20');return false;"><button class="btn blue btn-xs">Upload</button></a></td><?php } ?>
				
			  </tr>
   <?php  } ?>
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
