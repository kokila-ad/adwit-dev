<?php $this->load->view("new_csr/head.php"); ?>
<script>
	function sluf_confirm123(){    
	var X=confirm('Confirm To Proof Check!!');	
	if(X==true)	  {    return true;  }else  {    return false;  }} 

	function goBack() {    window.history.back();}

	function myFunction() {
		location.reload();
	}
</script>
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
									 Adwit ID
								</th>
								<th>
									 Job Name
								</th>
								<th>
									 Advertiser
								</th>
								<th>
									 Publication
								</th>
								<!--<th>
									Status
								</th>-->
                                <th>
									 View
								</th>
							</tr>
							</thead>
		<tbody name="testTable" id="testTable">
								
<?php if(isset($orders)){
		$sId = $this->session->userdata('sId');
		foreach($orders as $row1)
		{	
			if(isset($rev_orders)){
				$order_status = 'Revision Submitted';
				if($rev_orders[0]['new_slug']!='none'){ $order_status = 'In Production'; }
				if($rev_orders[0]['pdf_path']!='none'){ $order_status = 'Proof Ready'; }
				if($rev_orders[0]['approve']!='0'){ $order_status = 'Approved'; }
				$location = base_url().index_page().'new_csr/home/orderview/'.$row1['help_desk'].'/'.$row1['id'] ;
				$publication = $this->db->get_where('publications',array('id' => $row1['publication_id']))->result_array();
			}else{
				$order_status = $this->db->get_where('order_status',array('id' => $row1['status']))->result_array();
				$order_status = $order_status[0]['d_name'];
				$publication = $this->db->get_where('publications',array('id' => $row1['publication_id']))->result_array();
				$location = base_url().index_page().'new_csr/home/orderview/'.$row1['help_desk'].'/'.$row1['id'] ;
			}
			$cat_result = $this->db->query("SELECT * FROM `csr`,`cat_result` WHERE `order_no`='".$row1['id']."' AND csr.id = cat_result.csr ")->result_array();
			if($cat_result){ 
				$form = $cat_result[0]['help_desk'];
				$cat_designer = $this->db->get_where('designers',array('id' => $cat_result[0]['designer']))->result_array();
				$pro_status = $this->db->get_where('production_status', array('id' => $cat_result[0]['pro_status']))->result_array();
			}
			//$job_status = $this->db->query("SELECT * FROM `csr`,`cp_tool` WHERE `order_no`='".$row1['id']."' AND csr.id = cp_tool.csr ")->result_array();
						
?>
              <tr <?php if($row1['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="bg-red-pink"'; } ?>>
<!-- date -->			<td><?php $date = strtotime($row1['created_on']); echo date('Y-m-d', $date); ?></td>

<!-- order_no --> 		<td><?php echo $row1['id']; ?></td></a>

<!-- job_name -->		<td><?php echo $row1['job_no']; ?></td>

<!-- Advertiser -->		<td><?php echo $row1['advertiser_name']; ?></td>

<!-- newspaper -->		<td><?php echo $publication[0]['name']; ?></td>


					
<!-- View -->			<?php if($cat_result && $cat_result[0]['pro_status']=='3') { 

							if($cat_result[0]['csr_QA']=='0' && $cat_result[0]['tag_csr']=='0'){ ?>
							<td>
								<form method="post" action="<?php echo base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row1['id'];?>"> 
									<button name="proof_check" class="btn blue btn-xs" onclick="return sluf_confirm123()">Proof Check</button>
									<input type="text" name="order_id" value="<?php echo $row1['id']; ?>" style="display:none;">
							   </form>
							</td><?php }elseif($cat_result[0]['csr_QA'] == $sId || $cat_result[0]['tag_csr'] == $sId  ){?>
							<td>
								<a href="javascript:;" onclick="window.location = '<?php echo $location; ?>'" style="cursor:pointer; text-decoration: none;"><button type="button" class="btn blue btn-xs">Complete Proof</button></a>
							</td><?php }elseif($cat_result[0]['csr_QA'] != $sId || $cat_result[0]['tag_csr'] != $sId ){ ?>
							<td>
								<?php $csr = $this->db->query("SELECT `name` FROM `csr` WHERE `id` = '".$cat_result[0]['csr_QA']."'")->row_array();?>
								<a href="javascript:;" onclick="window.location = '<?php echo $location; ?>'" style="cursor:pointer; text-decoration: none;"><button type="button" class="btn blue btn-xs">View</button><?php echo $csr['name'];?></a>
							</td><?php }?>
						<?php }elseif($cat_result && $cat_result[0]['pro_status'] != '3' && $cat_result[0]['pro_status'] != '0'){ ?>
						<td>
							<a href="javascript:;" onclick="window.location = '<?php echo $location; ?>'" style="cursor:pointer; text-decoration: none;"><button type="button" class="btn blue btn-xs"><?php  echo $pro_status[0]['name'];?></button></a>
						</td>
						<?php }elseif($order_status){?>
						<td>
							<a href="javascript:;" onclick="window.location = '<?php echo $location; ?>'" style="cursor:pointer; text-decoration: none;"><button type="button" class="btn blue btn-xs"><?php echo $order_status;?></button></a>
						</td>
						<?php } ?>
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