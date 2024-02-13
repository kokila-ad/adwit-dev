<?php $this->load->view("new_csr/head.php"); ?>

<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
		<div class="container">

		<?php 
		if(isset($msg))echo "<h3 style='color:#900;'>No Orders Found!! </h3>"; 
		?>
        <div class="row">
        <div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cogs font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold">Orders Search Result</span>
							</div>
							<div class="tools">
							</div>
							
						</div>
						<div class="portlet-body">
							<table class="table table-striped table-bordered table-hover" id="sample_1">
							<thead>
							<tr>
								<th>
									 Date
								</th>
								
								<th>
									 Adwit Id
								</th>
								<th>
									 Job Name
								</th>
								<th>
									 Publication
								</th>
								<th>
									Status
								</th>
                                <th>
									 View
								</th>
							</tr>
							</thead>
		<tbody name="testTable" id="testTable">
								
<?php if(isset($orders)){
		
		foreach($orders as $row1)
		{	
			if(isset($rev_orders)){
				$order_status = 'Revision Submitted';
				if($rev_orders[0]['new_slug']!='none'){ $order_status = 'In Production'; }
				if($rev_orders[0]['pdf_path']!='none'){ $order_status = 'Proof Ready'; }
				if($rev_orders[0]['approve']!='0'){ $order_status = 'Approved'; }
				$location = base_url().index_page().'new_csr/home/rev_orderview/'.$row1['help_desk'].'/'.$row1['id'] ;
			}else{
				$order_status = $this->db->get_where('order_status',array('id' => $row1['status']))->result_array();
				$order_status = $order_status[0]['name'];
				$location = base_url().index_page().'new_csr/home/orderview/'.$row1['help_desk'].'/'.$row1['id'] ;
			}
			$cat_result = $this->db->query("SELECT * FROM `csr`,`cat_result` WHERE `order_no`='".$row1['id']."' AND csr.id = cat_result.csr ")->result_array();
			if($cat_result){ 
				$form = $cat_result[0]['help_desk'];
				$cat_designer = $this->db->get_where('designers',array('id' => $cat_result[0]['designer']))->result_array();
			}
			//$job_status = $this->db->query("SELECT * FROM `csr`,`cp_tool` WHERE `order_no`='".$row1['id']."' AND csr.id = cp_tool.csr ")->result_array();
						
?>
              <tr <?php if($row1['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="odd gradeX error"'; } ?>>
<!-- date -->			<td><?php $date = strtotime($row1['created_on']); echo date('Y-m-d', $date); ?></td>

<!-- order_no --> 		<td><a href="<?php echo $location; ?>" style="cursor:pointer; text-decoration: none;"><?php echo $row1['id']; ?></td></a>

<!-- job_name -->		<td><?php echo $row1['job_no']; ?></td>

<!-- newspaper -->		<td><?php echo $publication[0]['name']; ?></td>

<!-- Status -->			<td> <button type="button" class="btn red-sunglo btn-xs"><?php echo $order_status; ?></button></td>

<!-- Status         <?php if($cat_result && $cat_result[0]['slug']!='none'){ 
								echo "<td title='".$cat_designer[0]['username']."'style='cursor:pointer;'>Completed</td>";
							}else{ echo"<td>Pending</td>"; } ?>
		--> 
		
<!-- View -->            <td> <a href="javascript:;" onclick="window.location = '<?php echo $location; ?>'" style="cursor:pointer; text-decoration: none;"><button type="button" class="btn blue btn-xs">View</button></a></td>
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