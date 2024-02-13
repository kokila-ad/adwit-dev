<?php
       $this->load->view("team-lead/head"); 
?>
<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
		<div class="container">
        <!-- <div class="row">
        <div class="col-lg-12">
        <div class="navbar navbar-default" role="navigation">
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
									
									<a class="navbar-brand" href="javascript:;">
									 </a>
								</div>
								<div class="collapse navbar-collapse navbar-ex1-collapse">
										<form class="navbar-form navbar-left"  name="form" method="post" action="<?php echo base_url().index_page().'team-lead/home/cshift_search/'; ?>">
										<div class="form-group">
											<input type="text" class="form-control" placeholder="Search"  name="id" autocomplete="off" required/>
										</div>
										<button type="submit" class="btn blue" name="search">Search</button>
									</form>
								</div>
								
							</div>
        </div>
        </div>-->
		<?php 
		if(isset($msg))echo "<h3 style='color:#900;'>No Orders Found!! </h3>"; 
		?>
        <div class="row">
        <div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cogs font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold uppercase">Order Search Result</span>  <button onclick="goBack()" type="button" class="btn red btn-xs">Back to live Tracker</button>
							</div>
							<div class="tools">
							</div>
							
						</div>
						<div class="portlet-body">
							<table class="table table-striped table-bordered table-hover" id="sample_1">
							<thead>
							<tr>
				<th style="vertical-align: middle;">Date</th>
				<th style="vertical-align: middle;">Type</th>
                <th style="vertical-align: middle;">Adwit Id</th>
				<th style="vertical-align: middle;">Job Name</th>
				<th style="vertical-align: middle;">Publication</th>
				<th style="vertical-align: middle;">Status</th>
				<th style="vertical-align: middle;">View</th>
							</tr>
							</thead>
							<tbody name="testTable" id="testTable">
								
<?php 
	if(isset($order))
	{
		foreach($order as $row1)
		{
			$cat_result = $this->db->query("SELECT * FROM `cat_result` WHERE `order_no`='".$row1['id']."'")->result_array();
			if(isset($rev_orders)){
				$order_status = 'Revision Submitted';
				if($rev_orders[0]['new_slug']!='none'){ $order_status = 'In Production'; }
				if($rev_orders[0]['pdf_path']!='none'){ $order_status = 'Proof Ready'; }
				if($rev_orders[0]['approve']!='0'){ $order_status = 'Approved'; }
				$location = base_url().index_page().'team-lead/home/rev_orderview/'.$row1['help_desk'].'/'.$row1['id'] ;
			}else{
				if($cat_result && $cat_result[0]['pro_status']!='0'){
					$order_status = $this->db->get_where('production_status',array('id' => $cat_result[0]['pro_status']))->result_array();					
				}else{
					$order_status = $this->db->get_where('order_status',array('id' => $row1['status']))->result_array();
				}
				$order_status = $order_status[0]['name'];
				$location = base_url().index_page().'team-lead/home/orderview/'.$row1['help_desk'].'/'.$row1['id'] ;
			}
			$order_type = 	$this->db->get_where('orders_type',array('id' => $row1['order_type_id']))->result_array();
			$publication = 	$this->db->get_where('publications',array('id' => $row1['publication_id']))->result_array();
			
			//$status = 	$this->db->get_where('order_status',array('id' => $row1['status']))->result_array();	
			
?>
              <tr>
<!-- date -->			<td><?php $date = strtotime($row1['created_on']); echo date('Y-m-d', $date); ?></td>
                         <td title="<?php echo $order_type[0]['name']; ?>"><span class="badge bg-blue"><?php if($order_type[0]['id']=='1') {echo "W"; } if($order_type[0]['id']=='2') { echo "P"; } if($order_type[0]['id']=='3') { echo "P&W";}?></span></td>
<!-- order_no --> 		<td><a href="<?php echo $location; ?>"><?php echo $row1['id']; ?></a></td>
<!-- job_name -->		<td><?php echo $row1['job_no']; ?></td>
<!-- newspaper -->		<td><?php echo $publication[0]['name']; ?></td>
                         <td><button type="button" class="btn red-sunglo btn-xs"><?php echo $order_status; ?></button></td>  
                        <td><a href="javascript:;" onclick="window.location = '<?php echo $location; ?>'" style="cursor:pointer; text-decoration: none;"><button type="button" class="btn blue btn-xs">View</button></td></a>
                       
                       
               </tr>
<?php } }?>
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

<!-- BEGIN FOOTER -->
<?php
       $this->load->view("team-lead/foot"); 
?>