<?php $this->load->view('new_csr/head'); ?>
<script>
function Adp_confirm(){
    var X=confirm('Are You Sure ?');
	if(X==true){
    return true;
  }
else
  {
    return false;
  }
} 
</script>
<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">

	<!-- BEGIN PAGE CONTENT -->
	<div class="page-content">
		<div class="container">
	
			<!-- BEGIN PAGE CONTENT INNER -->
			<div class="portlet light">
				<div class="portlet-body">
					<div class="row">
					<div class="col-md-12">
						<h4 class="font-blue-steel">Resend AdRep</h4>
						<?php echo '<h4 style="color:#900;">'.$this->session->flashdata('message').'</h4>'; ?>
						<table class="table table-striped table-bordered table-hover" id="sample_2">
							<thead>
							<tr>
								<th>Id</th>
								<th>Type</th>
								<th>Timestamp</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody>
							<!--<form method="post" action="<?php echo base_url().index_page().'new_csr/home/order_mail_resend';?>">-->
								<?php $i=0; foreach($order_mail_sent as $row){ $i++; ?>
									<tr>
										<td><?php if($row['order_id']!='0') { echo $row['order_id']; } else { echo $row['rev_id']; }?></td>
										
										<td><?php if($row['order_id']!='0'){ echo "New"; }else{ echo "Rev"; } ?></td>
										
										<td><?php echo $row['timestamp']; ?></td>
										
										<td>
											<form method="post">
											<input name="order_id" value="<?php echo $row['order_id'];?>" readonly style="display:none;" />
											<input name="rev_id" value="<?php echo $row['rev_id'];?>" readonly style="display:none;" />
											<input name="id" value="<?php echo $row['id'];?>" readonly style="display:none;" />
											<button type="submit" name="end_time" class="btn blue start" onclick="return Adp_confirm();"><span>Resend To Adrep</span></button>
											</form>	
										</td>					
									</tr> 	
										
										<?php } ?>
								
							</tbody>
						</table>  
						</div>	
					</div>
				</div>
				
			</div>
			<!-- END PAGE CONTENT INNER -->
		</div>
	</div>
	<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->

	


<?php $this->load->view('new_csr/foot'); ?>