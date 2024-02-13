<?php $this->load->view("admin/head1");?>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script type="text/javascript">	//all pending
	$(document).ready(function(e) {
        $('#display_type').change(function(e) {
		
            window.location = "<?php echo base_url().index_page().'admin/home/job_status/';?>" + $('#display_type').val() ;
        });
    });
</script>
<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
				 
				<div class="portlet light">
					<div class="portlet-body">					
						
						<div class="row">						
							<div class="col-lg-10 col-md-6 col-sm-3">
							<h3 class="page-title">Job Status</h3>
							</div>
							<div class="col-lg-2 col-md-3 col-sm-3">
									<select class="form-control" name="display_type" id="display_type" >
										<option value="pending" <?php echo ($display_type=='pending' ? 'selected="selected"' : ''); ?> >Pending</option>
										<option value="all" <?php echo ($display_type=='all' ? 'selected="selected"' : ''); ?> >All</option>
										<option value="sent" <?php echo ($display_type=='sent' ? 'selected="selected"' : ''); ?> >Sent</option>
									</select>
							</div>							
							</div>
					
						
				
				<!-- BEGIN PAGE HEADER-->
				<!-- END PAGE HEADER-->
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box green-haze">
							<div class="portlet-title">
								<div class="caption">
									Cshift Tracker : <?php if(isset($from) && isset($to)){echo $from." to ".$to;}else{echo $ystday."  to  ".$today ;} ?>
								</div>
								<div class="tools  margin-left-10">
									<a href="javascript:;" class="collapse">
									</a>
									<a href="javascript:;" class="reload">
									</a>
								</div>
								<div class="margin-top-10 text-right">
									<button class="btn bg-grey btn-xs"><i class="fa fa-file-excel-o"></i> Export to Excel</button>
								</div>
							</div>
							

							<div class="portlet-body">
				
								<table class="table table-striped table-bordered table-hover" id="sample_6">
								<thead>
								<tr>
									<th>Adwit Id</th>
									<th>Job Name</th>
									<th>Publication</th>
									<th>Date</th>
									<th>Category</th>
									<th>Design</th>
									<th>QA</th>
									<th>Upload</th>
									<th>Cancel</th>
								</tr>
								</thead>
<!-- Display All -->								
<?php if($display_type=='all') { ?>								
		<tbody>
<?php 
		$i=1;
		foreach($cat_id as $row1)
		{	
			$orders = $this->db->get_where('orders',array('id' => $row1['order_no']))->result_array();
			$cat_csr = $this->db->get_where('csr',array('id' => $row1['csr']))->result_array();
			$cat_designer = $this->db->get_where('designers',array('id' => $row1['designer']))->result_array();
			$job_status = $this->db->get_where('cp_tool',array('order_no' => $row1['order_no']))->result_array();
			$cat_news = $this->db->get_where('cat_newspaper',array('id' => $row1['news_id']))->result_array();
			
			if($job_status)
			{
				$cp_csr = $this->db->get_where('csr',array('id' => $job_status[0]['csr']))->result_array();
				$upload_csr = $this->db->get_where('csr',array('id' => $job_status[0]['upload_csr']))->result_array();
			}

?>								
			<tr>
<!-- order_no --> 		<td><?php echo $row1['order_no']; ?></td>

<!-- job_name -->		<td><?php echo $row1['job_name']; ?></td>

<!-- newspaper -->		<td><?php if(isset($cat_news[0]['name']) && $cat_news[0]['name']!='0'){echo $cat_news[0]['name'];}else{echo"";} ?></td>

<!-- date -->			<td><?php echo $row1['date']; ?></td>
				
<!-- category -->       <td title="<?php echo $cat_csr[0]['name']; ?>" style="cursor:pointer;" ><?php echo $row1['category']; ?></td>
               
<!-- design -->         <?php if($row1['slug']=='none'){ echo "<td>Pending</td>"; }else{ echo "<td title='".$cat_designer[0]['username']."'style='cursor:pointer;'>Completed</td>"; } ?>
				                
<!-- QA -->             <?php if($job_status){ echo "<td title='".$cp_csr[0]['name']."' style='cursor:pointer;'>".$job_status[0]['job_status']."</td>"; }else{ echo "<td>Pending</td>"; } ?>
			
<!-- upload -->		 <td>
						<?php if(($orders && $orders[0]['cancel']!='0') || $row1['cancel']!='0'){ echo "Cancelled" ; }elseif($job_status){
						if($job_status[0]['upload_csr']!='0'){ echo "uploaded" ; }else{ echo''; } } ?>
					</td>
              
<!--cancel -->	<?php if($job_status && $job_status[0]['upload_csr']!='0'){
							if($row1['pdf_path']!='none')
							{ $pdf_path = base_url().$row1['pdf_path']; 
				?>
								<td><a href="<?php echo $pdf_path;?>" target="_blank" style="cursor:pointer; text-decoration: none;"><img src="images/pdf.png" alt="pdf"/></a></td>
				<?php
							}else{ echo "<td>Uploaded</td>";} 
						}elseif(($orders && $orders[0]['cancel']!='0') || $row1['cancel']!='0')
						{ echo"<td>Cancelled</td>"; }else{ 
				?>
				<td></td>
                <?php } ?>
			</tr>
<?php } ?>								
		</tbody>
<?php } ?>	

<!-- Display sent -->								
<?php if($display_type=='sent') { ?>								
		<tbody>
<?php 
		$i=1;
		foreach($cat_id as $row1)
		{	
			$orders = $this->db->get_where('orders',array('id' => $row1['order_no']))->result_array();
			$cat_csr = $this->db->get_where('csr',array('id' => $row1['csr']))->result_array();
			$cat_designer = $this->db->get_where('designers',array('id' => $row1['designer']))->result_array();
			$job_status = $this->db->get_where('cp_tool',array('order_no' => $row1['order_no']))->result_array();
			$cat_news = $this->db->get_where('cat_newspaper',array('id' => $row1['news_id']))->result_array();
			
			if($job_status)
			{
				$cp_csr = $this->db->get_where('csr',array('id' => $job_status[0]['csr']))->result_array();
				$upload_csr = $this->db->get_where('csr',array('id' => $job_status[0]['upload_csr']))->result_array();
			}
			
			if(($job_status && $job_status[0]['upload_csr']!='0')){  
?>								
			<tr>
<!-- order_no --> 		<td><?php echo $row1['order_no']; ?></td>
<!-- job_name -->		<td><?php echo $row1['job_name']; ?></td>
<!-- newspaper -->		<td><?php if(isset($cat_news[0]['name']) && $cat_news[0]['name']!='0'){echo $cat_news[0]['name'];}else{echo"";} ?></td>
<!-- date -->			<td><?php echo $row1['date']; ?></td>
				
<!-- category -->       <td title="<?php echo $cat_csr[0]['name']; ?>" style="cursor:pointer;" ><?php echo $row1['category']; ?></td>
               
<!-- design -->         <?php if($row1['slug']=='none'){ echo "<td>Pending</td>"; }else{ echo "<td title='".$cat_designer[0]['username']."'style='cursor:pointer;'>Completed</td>"; } ?>
				                
<!-- QA -->             <?php if($job_status){ echo "<td title='".$cp_csr[0]['name']."' style='cursor:pointer;'>".$job_status[0]['job_status']."</td>"; }else{ echo "<td>Pending</td>"; } ?>
			
<!-- upload -->		 <td>
						<?php if(($orders && $orders[0]['cancel']!='0') || $row1['cancel']!='0'){ echo "Cancelled" ; }elseif($job_status){
						if($job_status[0]['upload_csr']!='0'){ echo "uploaded" ; }else{ echo''; } } ?>
					</td>
                <!--<td><?php if($job_status && $upload_csr){echo $upload_csr[0]['name'];}else{echo "None";} ?></td>-->
<!--cancel -->	<?php if($job_status && $job_status[0]['upload_csr']!='0'){
							if($row1['pdf_path']!='none')
							{ $pdf_path = 'http://www.adwitads.com/weborders/'.$row1['pdf_path']; 
				?>
								<td><a href="<?php echo $pdf_path;?>" target="_blank" style="cursor:pointer; text-decoration: none;"><img src="images/pdf.png" alt="pdf"/></a></td>
				<?php
							}else{ echo "<td>Uploaded</td>";} 
						}elseif(($orders && $orders[0]['cancel']!='0') || $row1['cancel']!='0')
						{ echo"<td>Cancelled</td>"; }else{ 
				?>
				<td></td>
                <?php } ?>
			</tr>
		<?php } } ?>								
		</tbody>
<?php } ?>	

<!-- Display Pending -->								
<?php if($display_type=='pending') { ?>								
		<tbody>
<?php 
		$i=1;
		foreach($cat_id as $row1)
		{	
			$orders = $this->db->get_where('orders',array('id' => $row1['order_no']))->result_array();
			$cat_csr = $this->db->get_where('csr',array('id' => $row1['csr']))->result_array();
			$cat_designer = $this->db->get_where('designers',array('id' => $row1['designer']))->result_array();
			$job_status = $this->db->get_where('cp_tool',array('order_no' => $row1['order_no']))->result_array();
			$cat_news = $this->db->get_where('cat_newspaper',array('id' => $row1['news_id']))->result_array();
			
			if($job_status)
			{
				$cp_csr = $this->db->get_where('csr',array('id' => $job_status[0]['csr']))->result_array();
				$upload_csr = $this->db->get_where('csr',array('id' => $job_status[0]['upload_csr']))->result_array();
			}
			
			if((!$job_status || $job_status[0]['upload_csr']=='0')){ 
?>								
			<tr>
<!-- order_no --> 		<td><?php echo $row1['order_no']; ?></td>
<!-- job_name -->		<td><?php echo $row1['job_name']; ?></td>
<!-- newspaper -->		<td><?php if(isset($cat_news[0]['name']) && $cat_news[0]['name']!='0'){echo $cat_news[0]['name'];}else{echo"";} ?></td>
<!-- date -->			<td><?php echo $row1['date']; ?></td>
				
<!-- category -->       <td title="<?php echo $cat_csr[0]['name']; ?>" style="cursor:pointer;" ><?php echo $row1['category']; ?></td>
               
<!-- design -->         <?php if($row1['slug']=='none'){ echo "<td>Pending</td>"; }else{ echo "<td title='".$cat_designer[0]['username']."'style='cursor:pointer;'>Completed</td>"; } ?>
				                
<!-- QA -->             <?php if($job_status){ echo "<td title='".$cp_csr[0]['name']."' style='cursor:pointer;'>".$job_status[0]['job_status']."</td>"; }else{ echo "<td>Pending</td>"; } ?>
			
<!-- upload -->		 <td>
						<?php if(($orders && $orders[0]['cancel']!='0') || $row1['cancel']!='0'){ echo "Cancelled" ; }elseif($job_status){
						if($job_status[0]['upload_csr']!='0'){ echo "uploaded" ; }else{ echo''; } } ?>
					</td>
                <!--<td><?php if($job_status && $upload_csr){echo $upload_csr[0]['name'];}else{echo "None";} ?></td>-->
<!--cancel -->	<?php if($job_status && $job_status[0]['upload_csr']!='0'){
							if($row1['pdf_path']!='none')
							{ $pdf_path = 'http://www.adwitads.com/weborders/'.$row1['pdf_path']; 
				?>
								<td><a href="<?php echo $pdf_path;?>" target="_blank" style="cursor:pointer; text-decoration: none;"><img src="images/pdf.png" alt="pdf"/></a></td>
				<?php
							}else{ echo "<td>Uploaded</td>";} 
						}elseif(($orders && $orders[0]['cancel']!='0') || $row1['cancel']!='0')
						{ echo"<td>Cancelled</td>"; }else{ 
				?>
				<td></td>
                <?php } ?>
			</tr>
	<?php } } ?>								
		</tbody>
<?php } ?>						
								</table>
							</div>

						</div>
						<!-- END EXAMPLE TABLE PORTLET-->
						
					</div>
				</div>
			</div>
		</div>
		<!-- END CONTENT -->
		<!-- BEGIN QUICK SIDEBAR -->
		<!--Cooming Soon...-->
		<!-- END QUICK SIDEBAR -->
	</div>
	<!-- END CONTAINER -->
<?php $this->load->view("admin/foot1");?>