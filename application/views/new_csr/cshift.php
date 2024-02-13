 <?php $this->load->view("new_csr/head"); ?>
<!-- BEGIN PAGE CONTAINER -->
 <script>
	function sluf_confirm123(){    
	var X=confirm('Confirm To Proof Check!!');	
	if(X==true)	  {    return true;  }else  {    return false;  }} 

	function goBack() {    window.history.back();}

	function myFunction() {
		location.reload();
	}
	
	function reset_metrosendads(){
	   $.ajax({
        type: 'POST',
		url: "<?php echo base_url().index_page().'new_csr/home/unsetmetro_ads';?>",
        success: function(response) {
            // Redirect the user to the new location
            window.location.href = "<?php echo base_url() . index_page() . 'new_csr/home/cshift/2/metro_ad_sent'; ?>";
        },
        error: function() {
            alert('Error destroying the session.');
        }
    });
	}
	function getMetroSendAdList(){
	     var no_of_order = $("#no_of_metro_ad").val();  
	  
	  var dataString = "no_of_order="+no_of_order;
    	$.ajax({
    		url: "<?php echo base_url().index_page().'new_csr/home/cshift/2/metro_ad_sent';?>",
    		type: 'POST',
    		data: dataString,
            success: function(response) {
                // Redirect the user to the new location
                window.location.href = "<?php echo base_url() . index_page() . 'new_csr/home/cshift/2/metro_ad_sent'; ?>";
            },
            error: function() {
                alert('Something went wrong!!');
            }
        }); 
	}
</script>
<div class="page-container"> 
	<!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
		<div class="container">
			<div class="row margin-bottom-15">
				<div class="col-md-12">
				    <a style= "color:black; text-decoration:none; font-size: 13px;" href="<?php echo base_url().index_page().'new_csr/home/cshift';?>">New Ad</a> -
				    <a style= "text-decoration:none; font-size: 13px;" ><?php echo $help_desk_name['name'];?>	</a>
				</div>
			</div>
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
        						<?php if($csr['csr_role'] == '2' || $csr['csr_role'] == '3') { ?>
        							<?php  if($display_type == 'category'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
        								<a href="<?php echo base_url().index_page().'new_csr/home/cshift/'.$form.'/category';?>">
        								Categorise <span class="badge bg-red" id="categoryCount"><?php if(isset($c_orders)) echo count($c_orders); ?></span></a>
        							</li>
        						<?php } ?>
        						<?php if($csr['csr_role'] == '1' || $csr['csr_role'] == '2' || $csr['csr_role'] == '3') { ?>
        							<?php  if($display_type == 'QA'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
        								<a href="<?php echo base_url().index_page().'new_csr/home/cshift/'.$form.'/QA';?>">
        								My Q <span class="badge bg-green" id="QACount"><?php if(isset($QA_order_pending)) echo count($QA_order_pending); ?></span></a>
        							</li>
        						<?php } ?>
        						<?php if($csr['csr_role'] == '1' || $csr['csr_role'] == '2' || $csr['csr_role'] == '3') { ?>
        							<?php  if($display_type == 'total_QA'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
        								<a href="<?php echo base_url().index_page().'new_csr/home/cshift/'.$form.'/total_QA';?>">
        								General Q <span class="badge bg-green" id="generalQCount"><?php if(isset($csr_QA_pending)) echo count($csr_QA_pending); ?></span></a>
        							</li>
        						<?php } ?>
        							<!--ALL-->
        						<?php if($csr['csr_role'] == '2' || $csr['csr_role'] == '3') { ?>
        							<?php  if($display_type == 'new_pending'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
        								<a href="<?php echo base_url().index_page().'new_csr/home/cshift/'.$form.'/new_pending';?>">
        								All <span class="badge bg-green" id="all"><?php if(isset($All_pending)) echo count($All_pending); ?></span></a>
        							</li>
        						<?php } ?>
        						<!--ALL-->
        						<!--today metro ad sent -->
        						<?php if($form == '2'){ ?>
        							<?php  if($display_type == 'metro_ad_sent'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
        								<a href="<?php echo base_url().index_page().'new_csr/home/cshift/'.$form.'/metro_ad_sent';?>">
        								Sent Ads <span class="badge bg-green"><?php echo $metroad_count; ?></span></a>
        							</li>
        						<?php } ?>
        						<!--today metro ad sent-->
    						</ul>
							<span style="margin-left: 20px; padding: 0 10px;" class="font-blue margin-top-10">	
								<?php echo $this->session->flashdata('metro_message'); ?>
							</span>
							<ul class="nav navbar-nav navbar-right  margin-right-10">
							    <?php if($form=='2'){ ?>
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
    						<!--	<li class="margin-top-10">
    								<form class="search-form"  name="form" method="post" action="<?php echo base_url().index_page().'new_csr/home/metro_job_search'; ?>">
    									<div class="col-sm-8"  style="padding: 0;">
    										<input type="text" class="form-control" placeholder="Enter Data Here" name="id2" required>
    									</div>
    									<div class="col-md-4"   style="padding: 0;"> 
    										<button type="submit" name="search2" class="btn blue"><i class="fa fa-search"></i></button>
    									</div>
    								</form>
    					  
    							</li>-->
    							<li>
    								<a href="<?php echo base_url().index_page()."new_csr/home/metro_orders";?>">Aod Orders</a>
    							</li>
    							<?php }elseif($form=='5'){ ?>	<!-- MAP orders for Design6 help_desk-->
    								<li>
    									<a href="<?php echo base_url().index_page()."new_csr/home/map_orders";?>" target="_blank">Map Orders</a>
    								</li>
        						<?php } ?>
    							
    							<?php if($form=='12'){ ?>
    								<li>
    									<a onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/vidn_entries';?>'" href="javascript:;">
    									Vidn Entries </a>
    								</li>
    							<?php } ?>
						
								<li>
									<a onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/new_cat/'.$form;?>'" href="javascript:;">
									Create New Ad </a>
								</li>
							<!--	<li class="dropdown">
									<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
									Select Desk &nbsp;<i class="fa fa-angle-down"></i>
									</a>
									<ul class="dropdown-menu">
									<?php foreach($help_desk as $type){ ?>
										<li>
											<a href="<?php echo base_url().index_page().'new_csr/home/cshift/';?><?php echo $type['id']; ?>">
											<?php echo $type['name']; ?> </a>
										</li>
									<?php } ?>
									</ul>
								</li> -->
							</ul>
						</div>
						<!-- /.navbar-collapse -->
					</div>
				</div>
			</div>
<!--*********************************category*************************************-->
<?php  if($display_type == 'category'){ //category ?>	
<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="caption static-info no-space margin-top-10">
					<div class="value bold">
						<?php echo $help_desk_name['name']; ?> 
						<span style="margin-left: 20px; padding: 0 10px;" class="font-blue">
							<?php echo $this->session->flashdata('sucess_message'); ?>	
							<?php echo $this->session->flashdata('message'); ?>
						</span>
						</div>
				</div>
				<div class="tools no-space">
					<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()"> </a>
				</div>
			</div>			
			<div class="portlet-body">
				<table class="table table-striped table-bordered table-hover" id="sample_6">
					<thead>
						<tr>
							<th style="vertical-align: middle;">Date</th>
							<th style="vertical-align: middle;">AdwitAds ID</th>
							<th style="vertical-align: middle;">Unique Job Name</th>
							<th style="vertical-align: middle;">Adrep</th>
							<th style="vertical-align: middle;">Publication</th>						
							<th style="text-align: middle;">Click to</th>
						  </tr>              
					</thead>
					<tbody name="testTable" id="testTable">
<?php 
	$i=1;
	foreach($c_orders as $row1)
	{
		//$order_type = $this->db->get_where('orders_type',array('id' => $row1['order_type_id']))->result_array();
		$publication = $this->db->query("SELECT `name` FROM `publications` WHERE `id`='".$row1['publication_id']."' ;")->row_array();		
		$adreps = $this->db->query("SELECT `first_name` FROM `adreps` WHERE `id`='".$row1['adrep_id']."' ;")->row_array();		
		$cat_result = $this->db->query("SELECT `cancel` FROM `cat_result` WHERE `order_no` = '". $row1['id']."'")->row_array();
		$order_status = $this->db->get_where('order_status',array('id'=>$row1['status']))->row_array();
				
?>
					<tr <?php if($row1['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo 'class="bg-red-pink"'; } ?>>

<!-- date -->			<td><?php $date = strtotime($row1['created_on']); echo date('d-M', $date); ?></td>

<!-- type -->			<!--<td title="<?php echo $order_type[0]['name']; ?>"><span class="badge bg-blue"><?php if($order_type[0]['value']=='print') {echo "P";} elseif($order_type[0]['value']=='web'){ echo "W";} else{ echo "P&W";}?></span></td>-->

<!-- order_no --> 		<td><?php echo $row1['id']; ?></td>

<!-- job_name -->		<td><?php echo $row1['job_no']; ?></td>

<!-- adrep -->			<td><?php if($adreps) { echo $adreps['first_name']; } ?> </td>

<!-- Publication -->	<td><?php if(isset($publication)) { echo $publication['name']; } else{ echo " ";}?></td>

<!-- category -->		<?php if(($cat_result && $cat_result['cancel']!='0') || $row1['cancel']!='0'){ 
							echo'<td>Cancelled</td>';
						}elseif(!$cat_result){?>
						<td <?php if($row1['question']=='1') { echo "class='danger'";} if($row1['question']=='2') { echo "class='success '";} ?>>
							<a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;">
							<button class="btn blue btn-xs" ><?php if($order_status) echo $order_status['d_name']; else echo''; ?></button></a>
						</td>
					 <?php } ?>
					</tr>
<?php $i++; } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<!--category-->
						
<!--*************************************QA*********************************************-->
<?php if($display_type=='QA') { ?>
<div class="row">
	<div class="col-md-12">
		<div class="portlet light">						
			<div class="portlet-title">
				<div class="caption static-info no-space margin-top-10">
					<div class="value bold">
						<?php echo $help_desk_name['name']; ?>
						<span style="margin-left: 20px; padding: 0 10px;" class="font-blue">
							<?php echo $this->session->flashdata('sucess_message'); ?>	
							<?php echo $this->session->flashdata('message'); ?>
						</span>
					</div>
				</div>
				<div class="tools no-space">
						<button class="btn bg-grey btn-sm" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Excel</button>
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
							<th style="vertical-align: middle;">AdwitAds ID</th>
							<th style="vertical-align: middle;">Unique Job Name</th>
							<th style="vertical-align: middle;">Adrep</th>
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
foreach($QA_order_pending as $row)
{
    //$cat_result = $this->db->query("SELECT * FROM `cat_result` WHERE `order_no` = '".$row['id']."' AND `pro_status` != '5' AND `csr_QA` = '".$csr['id']."'")->result_array();
    //if($cat_result){
    	//$order_type = $this->db->get_where('orders_type',array('id' => $row['order_type_id']))->result_array();
    	
    	$order_status = $this->db->get_where('production_status',array('id'=>$row['pro_status']))->result_array();
?>
					<tr <?php if($row['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="bg-red-pink"'; } ?>>

<!-- date -->			<td><?php $date = strtotime($row['timestamp']); echo date('d-M', $date); ?></td>

<!-- type -->			<td title="OrderType">
                            <span class="badge bg-blue">
                                <?php if($row['order_type_id'] == 2){ echo "P"; }elseif($row['order_type_id'] == 1){ echo "W"; }elseif($row['order_type_id'] == 6){ echo "PG";}else{ echo "P&W";}?>
                            </span>
                        </td>

<!-- order_no --> 		<td><?php echo $row['id']; ?></td>

<!-- job_name -->		<td><?php echo $row['job_no']; ?></td>

<!-- adreps -->			<td><?php echo $row['adrepName'];  ?></td>

<!-- newspaper -->		<td><?php echo $row['publicationName']; ?></td>
						
						
<!-- QA -->            	<td <?php if($row['question']=='1') { echo "class='danger'";} if($row['question']=='2') { echo "class='success '";} ?> title="OrderView">
							<?php if($order_status && $row['pro_status'] == '3') { ?>
							<a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/orderview/'.$row['help_desk'].'/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;">
							<button class="btn blue btn-xs" ><?php echo $order_status[0]['d_name']; ?></button></a> <?php }else{ ?>
							<button class="btn grey btn-xs" ><?php echo $order_status[0]['d_name']; ?></button>
							<?php } ?>
						</td>  
					</tr>
				<?php  //} 
} 
?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>	
<?php } ?>
<!--QA-->
				
<!--***********************************new_pending*************************************************************-->
<?php if($display_type=='new_pending') { ?>
<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="caption static-info no-space margin-top-10">
					<div class="value bold">
						<?php echo $help_desk_name['name']; ?>
						<span style="margin-left: 20px; padding: 0 10px;" class="font-blue">
							<?php echo $this->session->flashdata('sucess_message'); ?>	
							<?php echo $this->session->flashdata('message'); ?>
						</span>
					</div>
				</div>
				<div class="tools no-space">
					<button class="btn bg-grey btn-sm"><i class="fa fa-file-excel-o"></i> Excel</button>
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
						<th style="vertical-align: middle;">AdwitAds ID</th>
						<th style="vertical-align: middle;">Unique Job Name</th>
						<th style="vertical-align: middle;">Adrep</th>
						<th style="vertical-align: middle;">Publication</th>
						<th style="vertical-align: middle;">Click to</th>
					</tr>              
				</thead>
				<tbody name="testTable" id="testTable">
<?php 
foreach($All_pending as $row1)
{
    //$order_type = 	$this->db->get_where('orders_type',array('id' => $row1['order_type_id']))->result_array();
	
    $order_status = $this->db->get_where('order_status',array('id'=>$row1['status']))->result_array();

?>
				<tr <?php if($row1['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="bg-red-pink"'; } ?>>
<!-- Date -->			<td><?php $date = strtotime($row1['created_on']); echo date('d-M', $date); ?></td>
<!-- Type -->			<td title="OrderType">
                            <span class="badge bg-blue">
                                <?php if($row1['order_type_id']==2) {echo "P";} elseif($row1['order_type_id']==1){ echo "W";}elseif($row1['order_type_id'] == 6){ echo "PG";} else{ echo "P&W";}?>
                            </span>
                        </td>
<!-- Order_no --> 		<td title="view attachments"><a <?php if($row1['rush']==1){ echo "class='font-grey-cararra'";} ?> href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;"><?php echo $row1['id']; ?></a></td>

<!-- Job_name -->		<td><?php echo $row1['job_no']; ?></td>

<!-- adrep -->			<td><?php echo $row1['adrepName'];  ?></td>

<!-- Newspaper -->		<td><?php echo $row1['publicationName']; ?></td>

<!-- Status -->			<?php if($row1['status']=='1') { ?><td <?php if($row1['question']=='1') { echo "class='danger'";} if($row1['question']=='2') { echo "class='success '";} ?>><a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;" ><button class="btn blue btn-xs" ><?php echo $order_status[0]['d_name']; ?></button></a></td><?php } ?>
<!-- Status -->			<?php if($row1['status']=='2') { ?><td <?php if($row1['question']=='1') { echo "class='danger'";} if($row1['question']=='2') { echo "class='success '";} ?>><a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;"><button class="btn blue btn-xs" ><?php echo $order_status[0]['d_name']; ?></button></a></td><?php } ?>
<!-- Status -->			<?php if($row1['status']=='3') { ?><td <?php if($row1['question']=='1') { echo "class='danger'";} if($row1['question']=='2') { echo "class='success '";} ?>><a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;"><button class="btn blue btn-xs" ><?php echo $order_status[0]['d_name']; ?></button></a></td><?php } ?>
<!-- Status -->			<?php if($row1['status']=='4') { ?>
    						<td <?php if($row1['question']=='1') { echo "class='danger'";} if($row1['question']=='2') { echo "class='success '";} ?>><a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;"><button class="btn blue btn-xs"><?php echo $order_status[0]['d_name']; ?></button></a>
    						<?php //$cat_result = $this->db->query("SELECT * FROM `cat_result` WHERE `order_no` = '".$row1['id']."' AND `pro_status` = '3'")->result_array();
    							  if(isset($row1['csr_QA'])){
    							    $log_csr = $this->db->query("SELECT name FROM `csr` WHERE `id` = '".$row1['csr_QA']."' ")->row_array();
    							    if($log_csr){ $log_csr_name = $log_csr['name']; echo $log_csr_name; } 
    						       } 
    						 ?>
    						</td>
						<?php } ?>
				</tr>
<?php  } ?>
				</tbody>
			  </table>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<!--new_pending-->

<!--Total_QA-->
<?php if($display_type=='total_QA') { ?>
<div class="row">
	<div class="col-md-12">
		<div class="portlet light">						
			<div class="portlet-title">
				<div class="caption static-info no-space margin-top-10">
					<div class="value bold">
						<?php echo $help_desk_name['name']; ?>
						<span style="margin-left: 20px; padding: 0 10px;" class="font-blue">
							<?php echo $this->session->flashdata('sucess_message'); ?>	
							<?php echo $this->session->flashdata('message'); ?>
						</span>
					</div>
				</div>
				<div class="tools no-space">
						<button class="btn bg-grey btn-sm" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Excel</button>
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
							<th style="vertical-align: middle;">AdwitAds ID</th>
							<th style="vertical-align: middle;">Unique Job Name</th>
							<th style="vertical-align: middle;">Adrep</th>
							<th style="vertical-align: middle;">Publication</th>	
							<!--<th style="vertical-align: middle;">Assign</th>	-->						
							<!--<th style="text-align: center;">Category</th>
							<th style="text-align: center;">Design</th>-->
							<th style="vertical-align: middle;">Click to</th>
							<!--<th style="text-align: center;">Upload</th>
							<th style="vertical-align: middle;">Actions</th>-->
						</tr>              
					</thead>
					<tbody name="testTable" id="testTable">
<?php 
foreach($csr_QA_pending as $row)
{
    //$cat_result = $this->db->query("SELECT  id, timestamp, assign, csr_QA FROM `cat_result` WHERE `order_no` = '".$row['id']."' AND `pro_status` = '3' AND `csr_QA` = '0'")->result_array();
    //if($cat_result){
    	//$order_type = $this->db->get_where('orders_type',array('id' => $row['order_type_id']))->result_array();
    			
    	$order_status = $this->db->get_where('order_status',array('id'=>$row['status']))->result_array();
?>
					<tr <?php if($row['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="bg-red-pink"'; } ?>>

<!-- date -->			<td><?php $date = strtotime($row['timestamp']); echo date('d-M', $date); ?></td>

<!-- type -->			<td title="OrderType">
                            <span class="badge bg-blue">
                                <?php if($row['order_type_id'] == 2) {echo "P";} elseif($row['order_type_id'] == 1){ echo "W";}elseif($row['order_type_id'] == 6){ echo "PG";} else{ echo "P&W";}?>
                            </span>
                        </td>

<!-- order_no --> 		<td>
						<?php if($row['rush']==1){ echo "class='font-grey-cararra'";} ?><?php echo $row['id']; ?>
						
						</td>

<!-- job_name -->		<td><?php echo $row['job_no']; ?></td>

<!-- adreps -->			<td><?php echo $row['adrepName'];  ?></td>

<!-- newspaper -->		<td><?php echo $row['publicationName']; ?></td>
<!-- Assign 
						<?php if($csr['csr_role'] == '1' || $csr['csr_role'] == '2' || $csr['csr_role'] == '3') { ?>
                		<td> <?php if($cat_result[0]['assign']!='0') {$design_assign_name = $this->db->get_where('design_assign',array('id' => $cat_result[0]['assign']))->result_array(); echo $design_assign_name[0]['name'];} else { ?>
							<input type="checkbox" name="assign[]" id="assign[]" value="<?php echo $cat_result[0]['id']; ?>">
							<input name="cat_id" value="<?php echo $cat_result[0]['id']; ?>" hidden />
							<?php } ?>
						</td>
						<?php }?>
-->			
<!-- QA -->            	<td <?php if($row['question']=='1') { echo "class='danger'";} if($row['question']=='2') { echo "class='success '";} ?> title="OrderView">
							<?php if($order_status && $row['csr_QA'] == '0') { ?>
							<form method="post" action="<?php echo base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row['id'];?>"> 
								<button name="proof_check" class="btn blue btn-xs" onclick="return sluf_confirm123()">Proof Check</button>
								<input type="text" name="order_id" value="<?php echo $row['id']; ?>" style="display:none;">
							</form>
							<?php }?>
							
							<?php if($row['csr_QA'] == $csr['id']) { ?>
								<i class="fa fa-flag"></i>
							<?php } else { echo ' '; } ?>
								
						</td>  
					</tr>
					<?php  //} 
					} ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>	
<?php } ?>
<!--Total_QA-->
		
<!--metro ad sent-->
<?php if($display_type=='metro_ad_sent') { ?>
<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="caption static-info no-space margin-top-10">
					<div class="value bold"><?php  $type = $this->db->get_where('help_desk',array('active'=>'1','id'=>$form))->result_array(); ?>
						<?php echo $type[0]['name']; ?>
						<span style="margin-left: 20px; padding: 0 10px;" class="font-blue">
							<?php echo $this->session->flashdata('sucess_message'); ?>	
							<?php echo $this->session->flashdata('message'); ?>
						</span>
					</div>
				</div>
				<div class="tools no-space">
					<!--<button class="btn bg-grey btn-sm"><i class="fa fa-file-excel-o"></i> Excel</button>-->
					<form method="post" action="<?php echo base_url().index_page().'new_csr/home/getMetroSendAdsExcel'?>">
				        <button type="submit" class="btn bg-grey btn-sm"><i class="fa fa-file-excel-o"></i> Excel</button>
				    </form>
					<button onclick="printPage()" class="btn bg-grey btn-sm"><i class="fa fa-print"></i> Print</button>
						<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()">
					 </a>
				</div>
			</div>
			<div class="portlet-body">
			    <!-- search form starts here -->
			    <form action="<?php echo base_url().index_page().'new_csr/home/cshift/2/metro_ad_sent' ?>" method="get">
    				<div class="form-group row">
    				<div class="col-sm-6">
    				    <div class="col-sm-3">
    				        <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="no_of_metro_ad" id="no_of_metro_ad" onchange="getMetroSendAdList()">
                              <option selected value="">select</option>
                              <option value="10" <?php if($this->session->userdata('no_of_metro_ad') == '10'){echo 'selected';}?> >10</option>
                              <option value="25" <?php if($this->session->userdata('no_of_metro_ad') == '25'){echo 'selected';}?> >25</option>
                              <option value="50" <?php if($this->session->userdata('no_of_metro_ad') == '50'){echo 'selected';}?> >50</option>
                              <option value="100" <?php if($this->session->userdata('no_of_metro_ad') == '100'){echo 'selected';}?>>100</option>
                            </select>
    				    </div>
            				   
            			</div>
    					<div class="col-sm-3">
    						<input type="text" id="metrosend_ads" name="metrosend_ads" value="<?php if($this->session->userdata("metroad_val") !== "" ){echo $this->session->userdata("metroad_val");}?>" placeholder="Search here" class="form-control">
    					</div>
    					<div class="col-sm-1">
    						<input type="submit" value="Search" class="btn btn-primary">
    					</div>
    					<div class="col-sm-1">
    						<button type="button" class="btn btn-warning" onclick="reset_metrosendads()">Reset</button>
    					</div>
    				</div>
    
    			</form>
			    <!-- search form ends here -->
				<table class="table table-striped table-bordered table-hover" id="metro_send_ad"> 
				<thead>
					<tr>
						<th style="vertical-align: middle;">Date</th>
						<th style="vertical-align: middle;">AdwitAds ID</th>
						<th style="vertical-align: middle;">Unique Job Name</th>
						<th style="vertical-align: middle;">Adrep</th>
						<th style="vertical-align: middle;">Publication</th>
						<th style="vertical-align: middle;">Click to</th>
					</tr>              
				</thead>
				<tbody name="testTable" id="testTable">
<?php 
if(isset($metro_sent) && $metro_sent != false){
foreach($metro_sent as $row1)
{
    //$order_type = 	$this->db->get_where('orders_type',array('id' => $row1['order_type_id']))->result_array();
    $publication = $this->db->query("SELECT `name` FROM `publications` WHERE `id`='".$row1['publication_id']."' ;")->result_array();		
    $adreps = $this->db->query("SELECT `first_name` FROM `adreps` WHERE `id`='".$row1['adrep_id']."' ;")->result_array();
    $order_status = $this->db->get_where('order_status',array('id'=>$row1['status']))->result_array();

?>
				<tr <?php if($row1['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="bg-red-pink"'; } ?>>
<!-- Date -->			<td><?php $date = strtotime($row1['created_on']); echo date('d-M', $date); ?></td>
<!-- Order_no --> 		<td title="view attachments"><a <?php if($row1['rush']==1){ echo "class='font-grey-cararra'";} ?> href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;"><?php echo $row1['id']; ?></a></td> 

<!-- Job_name -->		<td><?php echo $row1['job_no']; ?></td>

<!-- adrep -->			<td><?php if($adreps) { echo $adreps[0]['first_name']; } ?></td>

<!-- Newspaper -->		<td><?php echo $publication[0]['name']; ?></td>

						<td><?php if($order_status) { ?>
						<form method="post">
							<input type="text" name="order_id" value="<?php echo $row1['id'] ;?>" style="display:none;">
 							<button type="submit" class="btn blue btn-xs" name="ad_sent"><?php echo $order_status[0]['d_name'];?></button><?php }else{ echo' '; }?>
						</form>
						</td> 
				</tr>
				<?php  }} ?>
				
				</tbody>
			  </table>
			  <p><?php echo $links; ?></p>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<!--metro ad sent-->	

		
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
<!--
<script>
$( document ).ready(function() {
    $.get("<?php echo base_url().index_page().'new_csr/home/cshift_tab_ad_count/'.$form;?>", function(data){
        var myObj = JSON.parse(data);
        $('#categoryCount').html(myObj.category_count);
        $('#QACount').html(myObj.QA_count);
        $('#generalQCount').html(myObj.generalQ_count);
        $('#all').html(myObj.all_count);
    });
});
</script>
-->
<script>
        
    var tableToExcel = (function() {
                
        var uri = 'data:application/vnd.ms-excel;base64,'
            , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head></head><body><table>{table}</table></body></html>'
            , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
            , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
        return function(table, filename) {
            if (!table.nodeType) table = document.getElementById(table)
            var ctx = {worksheet: filename || 'Worksheet', table: table.innerHTML}
                window.location.href = uri + base64(format(template, ctx))
        }
    })()
    
$(document).ready(function() {
    
    var table = $('#metro_send_ad').DataTable({
        destroy: true,
        order: [[0, 'desc']],
        columnDefs: [
            { targets: 0, visible: false }  // hide the first column
        ],
        iDisplayLength: -1,
		"paging": false, //Dont want paging 
		"bInfo": false, //Dont display info e.g. "Showing 1 to 4 of 4 entries"
		"bFilter": false
    });

   
});
    
</script>

<?php $this->load->view("new_csr/foot"); ?>

