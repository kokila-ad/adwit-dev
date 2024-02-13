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
</script>
<div class="page-container"> 
	<!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
		<div class="container">
			<div class="row"> 
				<div class="col-lg-12"><?php echo $this->session->flashdata('message'); ?>
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
	<?php $form=''; ?>					
						<!-- Collect the nav links, forms, and other content for toggling -->
						<div class="collapse navbar-collapse navbar-ex1-collapse no-space">
    						<ul class="nav navbar-nav">
        						<?php if($csr['csr_role'] == '2' || $csr['csr_role'] == '3') { ?>
        							<?php  if($display_type == 'category'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
        								<a href="<?php echo base_url().index_page().'new_csr/home/pagination_orders/category';?>">
        								Categorise <span class="badge bg-red"><?php echo $category_count; ?></span></a>
        							</li>
        						<?php } ?>
        						<?php if($csr['csr_role'] == '1' || $csr['csr_role'] == '2' || $csr['csr_role'] == '3') { ?>
        							<?php  if($display_type == 'QA'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
        								<a href="<?php echo base_url().index_page().'new_csr/home/pagination_orders/QA';?>">
        								My Q <span class="badge bg-green"><?php echo $myQ_count; ?></span></a>
        							</li>
        						<?php } ?>
        						<?php if($csr['csr_role'] == '1' || $csr['csr_role'] == '2' || $csr['csr_role'] == '3') { ?>
        							<?php  if($display_type == 'total_QA'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
        								<a href="<?php echo base_url().index_page().'new_csr/home/pagination_orders/total_QA';?>">
        								General Q <span class="badge bg-green"><?php echo $generalQ_count; ?></span></a>
        							</li>
        						<?php } ?>
        							<!--ALL--> 
        						<?php if($csr['csr_role'] == '2' || $csr['csr_role'] == '3') { ?>
        							<?php  if($display_type == 'new_pending'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
        								<a href="<?php echo base_url().index_page().'new_csr/home/pagination_orders/new_pending';?>">
        								All <span class="badge bg-green"><?php echo $all_count; ?></span></a>
        							</li>
        						<?php } ?>
    						</ul>
						</div>
						<!-- /.navbar-collapse -->
					</div>
				</div>
			</div>
<!--category-->
<?php  if($display_type == 'category'){ //category ?>	
<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="caption static-info no-space margin-top-10">
					<div class="value bold">
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
							<th style="vertical-align: middle;">Page ID</th>
							<th style="vertical-align: middle;">Section</th>
							<th style="vertical-align: middle;">Unique Job Name</th>
							<th style="vertical-align: middle;">Adrep</th>
							<th style="vertical-align: middle;">Publication</th>						
							<th style="text-align: middle;">Click to</th>
							<th style="text-align: middle;">Priority</th>
						  </tr>              
					</thead>
					<tbody name="testTable" id="testTable">
<?php 
	$i=1;
	foreach($category_orders as $row1){
	    /*$cat_result = $this->db->query("SELECT cat_result.category, cat_result.designer, cat_result.csr, cat_result.pro_status FROM `cat_result` 
	                                        WHERE cat_result.order_no = '".$row1['id']."';")->row_array();
	    */                                    
	    $adreps = $this->db->query("SELECT adreps.id AS adrepId, adreps.first_name, adreps.color_code FROM `adreps` 
	                                        WHERE adreps.id = '".$row1['adrep_id']."';")->row_array();
	                                        
	    $publication = $this->db->query("SELECT publications.name AS publicationName, time_zone.priority AS time_zone_priority FROM `publications`
	                                        JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
	                                        WHERE publications.id = '".$row1['publication_id']."';")->row_array();
	                                        
	    $order_status = $this->db->query("SELECT order_status.name AS orderStatus, order_status.d_name FROM `order_status` 
	                                        WHERE order_status.id = '".$row1['status']."';")->row_array();
	    
	    $adrep_name = '';
		if(isset($adreps['id'])){
			$adrep_name = $adreps['first_name'];
		    $color_code = $this->db->get_where('color_code',array('id' => $adreps['color_code']))->row_array();
		}
		
?>
					<tr <?php if($row1['rush']=='1'){ echo'class="bg-red-pink"'; }elseif(isset($color_code['id'])){ echo 'class="'.$color_code['code'].'"'; } ?>>

<!-- date -->			<td><?php $date = strtotime($row1['created_on']); echo date('d-M', $date); ?></td>

<!-- order_no --> 		<td><?php echo $row1['id']; ?></td>

<!-- Page Id --> 		<td><?php echo $row1['page_design_id']; ?></td>

<!-- Section --> 		<td><?php echo $row1['section_name']; ?></td>

<!-- job_name -->		<td><?php  echo $row1['advertiser_name'].'/'.$row1['job_no']; ?></td>
                        
<!-- adrep -->			<td><?php echo $adrep_name;  ?> </td>

<!-- Publication -->	<td><?php echo $publication['publicationName']; ?></td>

<!-- category -->		<td <?php if($row1['question']=='1') { echo "class='danger'";} if($row1['question']=='2') { echo "class='success '";} ?>>
							<a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/orderview/'.$row1['help_desk'].'/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;">
							    <button class="btn blue btn-xs" ><?php if(isset($order_status['d_name'])) echo $order_status['d_name']; else echo''; ?></button>
							</a>
						</td>
						
<!-- Priority -->		<td><?php echo $publication['time_zone_priority']; ?></td>
					</tr>
	<?php $i++;  } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<!--category-->
						
<!--QA-->
<?php if($display_type=='QA') { ?>
<div class="row">
	<div class="col-md-12">
		<div class="portlet light">						
			<div class="portlet-title">
				<div class="caption static-info no-space margin-top-10">
					<div class="value bold">
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
							<!--<th style="vertical-align: middle;">Date</th>-->
							<th style="vertical-align: middle;">Type</th>
							<th style="vertical-align: middle;">AdwitAds ID</th>
							<th style="vertical-align: middle;">Page ID</th>
							<th style="vertical-align: middle;">Section</th>
							<th style="vertical-align: middle;">Unique Job Name</th>
							<th style="vertical-align: middle;">Adrep</th>
							<th style="vertical-align: middle;">Publication</th>											
							<!--<th style="text-align: center;">Category</th>
							<th style="text-align: center;">Design</th>-->
							<th style="vertical-align: middle;">Click to</th>
							<!--<th style="text-align: center;">Upload</th>
							<th style="vertical-align: middle;">Actions</th>-->
							<th style="text-align: middle;">Priority</th>
						</tr>              
					</thead>
					<tbody name="testTable" id="testTable">
<?php 
foreach($myQ_orders as $row)
{
	
		$order_type = $this->db->get_where('orders_type',array('id' => $row['order_type_id']))->row_array();
		
		$publication = $this->db->query("SELECT publications.name AS publicationName, time_zone.priority AS time_zone_priority FROM `publications`
	                                        JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
	                                        WHERE publications.id = '".$row['publication_id']."';")->row_array();	
	                                        
		$adreps = $this->db->query("SELECT `id`, `first_name`, `color_code` FROM `adreps` WHERE `id`='".$row['adrep_id']."' ;")->row_array();
		
		$order_status = $this->db->get_where('production_status',array('id'=>$row['pro_status']))->row_array();
		
		$adrep_name = '';
			if(isset($adreps['id'])){
			   $adrep_name = $adreps['first_name'];
			   $color_code = $this->db->get_where('color_code',array('id' => $adreps['color_code']))->row_array();
			}
?>
					<tr <?php if($row['rush']=='1'){ echo'class="bg-red-pink"'; }elseif(isset($color_code['id'])){ echo 'class="'.$color_code['code'].'"'; } ?>>



<!-- type -->			<td title="<?php echo $order_type['name']; ?>"><span class="badge bg-blue"><?php if($order_type['value']=='print') {echo "P";} elseif($order_type['value']=='web'){ echo "W";} else{ echo "P&W";}?></span></td>

<!-- order_no --> 		<td><?php echo $row['id']; ?></td>

<!-- Page Id --> 		<td><?php echo $row1['page_design_id']; ?></td>

<!-- Section --> 		<td><?php echo $row1['section_name']; ?></td>

<!-- job_name -->		<td><?php echo $row['job_no']; ?></td>

<!-- adreps -->			<td><?php echo $adrep_name;  ?></td>

<!-- newspaper -->		<td><?php echo $publication['publicationName']; ?></td>
						
						
<!-- QA -->            	<td <?php if($row['question']=='1') { echo "class='danger'";} if($row['question']=='2') { echo "class='success '";} ?> title="OrderView">
							
							<?php if($order_status) { 
									if($row['pro_status'] == '3') { 
							?>
							    <a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/orderview/'.$row['help_desk'].'/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;">
							    <button class="btn blue btn-xs" ><?php echo $order_status['d_name']; ?></button></a> 
							<?php }else{ ?>
							    <button class="btn grey btn-xs" ><?php echo $order_status['d_name']; ?></button>
							<?php } } ?>
						</td>
						
<!-- Priority -->		<td><?php echo $publication['time_zone_priority']; ?></td>						
					</tr>
<?php  } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>	
<?php } ?>
<!--QA-->
				
<!--new_pending-->
<?php if($display_type=='new_pending') { ?>
<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="caption static-info no-space margin-top-10">
					<div class="value bold">
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
						<th style="vertical-align: middle;">Page ID</th>
						<th style="vertical-align: middle;">Section</th>
						<th style="vertical-align: middle;">Unique Job Name</th>
						<th style="vertical-align: middle;">Adrep</th>
						<th style="vertical-align: middle;">Publication</th>
						<th style="vertical-align: middle;">Click to</th>
						<th style="text-align: middle;">Priority</th>
					</tr>              
				</thead>
				<tbody name="testTable" id="testTable">
<?php 
foreach($all_orders as $row1)
{
    $publication = $this->db->query("SELECT publications.name AS publicationName, time_zone.priority AS time_zone_priority FROM `publications`
	                                        JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
	                                        WHERE publications.id = '".$row1['publication_id']."';")->row_array();
	                                        
	$order_type = $this->db->get_where('orders_type',array('id' => $row1['order_type_id']))->row_array();
	
	$adreps = $this->db->query("SELECT `id`, `first_name`, `color_code` FROM `adreps` WHERE `id`='".$row1['adrep_id']."' ;")->row_array();
	
	$order_status = $this->db->get_where('order_status',array('id'=>$row1['status']))->row_array();
	
    $adrep_name = '';
	if(isset($adreps['id'])){
	    $adrep_name = $adreps['first_name'];
		$color_code = $this->db->get_where('color_code',array('id' => $adreps['color_code']))->row_array();
	}
?>
				<tr <?php if($row1['rush']=='1'){ echo'class="bg-red-pink"'; }elseif(isset($color_code['id'])){ echo'class="'.$color_code['code'].'"'; } ?>>
<!-- Date -->			<td><?php $date = strtotime($row1['created_on']); echo date('d-M', $date); ?></td>

<!-- Type -->			<td title="<?php echo $order_type['name']; ?>"><span class="badge bg-blue"><?php if($order_type['value']=='print') {echo "P";} elseif($order_type['value']=='web'){ echo "W";} else{ echo "P&W";}?></span></td> 

<!-- Order_no --> 		<td title="view attachments">
							<a <?php if($row1['rush']==1){ echo "class='font-grey-cararra'";} ?> href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_csr/home/orderview/'.$row1['help_desk'].'/'.$row1['order_id'];?>'" style="cursor:pointer; text-decoration: none;">
								<?php echo $row1['order_id']; ?>
							</a>
						</td>

<!-- Page Id --> 		<td><?php echo $row1['page_design_id']; ?></td>

<!-- Section --> 		<td><?php echo $row1['section_name']; ?></td>

<!-- Job_name -->		<td><?php echo $row1['job_no']; ?></td>

<!-- adrep -->			<td><?php echo $adrep_name;  ?></td>

<!-- Newspaper -->		<td><?php echo $publication['publicationName']; ?></td>

<!-- Status -->			<?php if($row1['status']=='1') { ?>
						<td <?php if($row1['question']=='1') { echo "class='danger'";} if($row1['question']=='2') { echo "class='success '";} ?>>
							<a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/orderview/'.$row1['help_desk'].'/'.$row1['order_id'];?>'" style="cursor:pointer; text-decoration: none;" >
								<button class="btn blue btn-xs" ><?php echo $order_status['d_name']; ?></button>
							</a>
						</td>
						<?php } ?>

<!-- Status -->			<?php if($row1['status']=='2') { ?>
						<td <?php if($row1['question']=='1') { echo "class='danger'";} if($row1['question']=='2') { echo "class='success '";} ?>>
							<a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/orderview/'.$row1['help_desk'].'/'.$row1['order_id'];?>'" style="cursor:pointer; text-decoration: none;">
								<button class="btn blue btn-xs" ><?php echo $order_status['d_name']; ?></button>
							</a>
						</td>
						<?php } ?>

<!-- Status -->			<?php if($row1['status']=='3') { ?>
						<td <?php if($row1['question']=='1') { echo "class='danger'";} if($row1['question']=='2') { echo "class='success '";} ?>>
							<a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/orderview/'.$row1['help_desk'].'/'.$row1['order_id'];?>'" style="cursor:pointer; text-decoration: none;">
								<button class="btn blue btn-xs" ><?php echo $order_status['d_name']; ?></button>
							</a>
						</td>
						<?php } ?>
						
<!-- Status -->			<?php if($row1['status']=='4') { ?>
						<td <?php if($row1['question']=='1') { echo "class='danger'";} if($row1['question']=='2') { echo "class='success '";} ?>>
							<a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/orderview/'.$row1['help_desk'].'/'.$row1['order_id'];?>'" style="cursor:pointer; text-decoration: none;">
								<button class="btn blue btn-xs"><?php echo $order_status['d_name']; ?></button>
							</a>
								<?php 
									$cat_result = $this->db->query("SELECT csr.name FROM `cat_result`
																		JOIN `csr` ON cat_result.csr_QA = csr.id
																		WHERE cat_result.order_no = '".$row1['order_id']."' AND cat_result.pro_status = '3'")->row_array();
									 if(isset($cat_result['name'])){	echo $cat_result['name'];  } 
								?>
						</td>
						<?php } ?>

<!-- Priority -->		<td><?php echo $publication['time_zone_priority']; ?></td>                        
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
							<!--<th style="vertical-align: middle;">Date</th>-->
							<th style="vertical-align: middle;">Type</th>
							<th style="vertical-align: middle;">AdwitAds ID</th>
							<th style="vertical-align: middle;">Page ID</th>
							<th style="vertical-align: middle;">Section</th>
							<th style="vertical-align: middle;">Unique Job Name</th>
							<th style="vertical-align: middle;">Adrep</th>
							<th style="vertical-align: middle;">Publication</th>	
							<!--<th style="vertical-align: middle;">Assign</th>-->
							<th style="vertical-align: middle;">Category</th>
							<!--<th style="text-align: center;">Design</th>-->
							<th style="vertical-align: middle;">Click to</th>
							<!--<th style="text-align: center;">Upload</th>
							<th style="vertical-align: middle;">Actions</th>-->
							<th style="text-align: middle;">Priority</th>
						</tr>              
					</thead>
					<tbody name="testTable" id="testTable">
<?php 
    foreach($generalQ_orders as $row)
    {
        $publication = $this->db->query("SELECT publications.name AS publicationName, time_zone.priority AS time_zone_priority FROM `publications`
	                                        JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
	                                        WHERE publications.id = '".$row1['publications']."';")->row_array();
	
		$order_type = $this->db->get_where('orders_type',array('id' => $row['id']))->row_array();
		$adreps = $this->db->query("SELECT `id`, `first_name`, `color_code` FROM `adreps` WHERE `id`='".$row['adrep_id']."' ;")->row_array();
		$order_status = $this->db->get_where('order_status',array('id'=>$row['status']))->row_array();
		$adrep_name = '';
		if(isset($adreps['id'])){
		    $adrep_name = $adreps['first_name'];
		    $color_code = $this->db->get_where('color_code',array('id' => $adreps['color_code']))->row_array();
		}
?>
					<tr <?php if($row['rush']=='1'){ echo'class="bg-red-pink"'; }elseif(isset($color_code['id'])){ echo'class="'.$color_code['code'].'"'; }else{ echo'class="odd gradeX"'; } ?>>

<!-- type -->			<td title="<?php echo $order_type['name']; ?>"><span class="badge bg-blue"><?php if($order_type['value']=='print') {echo "P";} elseif($order_type['value']=='web'){ echo "W";} else{ echo "P&W";}?></span></td>

<!-- order_no --> 		<td <?php if($row['rush']==1){ echo "class='font-grey-cararra'";} ?>> <?php echo $row['id']; ?> </td>

<!-- Page Id --> 		<td><?php echo $row1['page_design_id']; ?></td>

<!-- Section --> 		<td><?php echo $row1['section_name']; ?></td>

<!-- job_name -->		<td><?php echo $row['job_no']; ?></td>

<!-- adreps -->			<td><?php echo $adrep_name; ?></td>

<!-- newspaper -->		<td><?php echo $publication['publicationName']; ?></td>

<!-- Category -->		<td><?php echo $row['category']; ?></td>
			
<!-- QA -->            	<td <?php if($row['question']=='1') { echo "class='danger'";} if($row['question']=='2') { echo "class='success '";} ?> title="OrderView">
							<?php if($order_status ) { ?>
							<form method="post" action="<?php echo base_url().index_page().'new_csr/home/orderview/'.$row['help_desk'].'/'.$row['id'];?>"> 
								<button name="proof_check" class="btn blue btn-xs" onclick="return sluf_confirm123()">Proof Check</button>
								<input type="text" name="order_id" value="<?php echo $row['id']; ?>" style="display:none;">
							</form>
							<?php }?>
						
							<?php if($row['csr_QA'] == $csr['id']) { ?>
								<i class="fa fa-flag"></i>
								<?php } else { echo ' '; } ?>
							
						</td>
						
<!-- Priority -->		<td><?php echo $publication['time_zone_priority']; ?></td>						
					</tr>
<?php   } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>	
<?php } ?>
<!--Total_QA-->

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
</script>

<?php $this->load->view("new_csr/foot"); ?>

