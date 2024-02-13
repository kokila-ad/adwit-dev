<?php $this->load->view('new_admin/header')?>
<script> 
$(document).ready(function(){ 
	$('#submit_form').hide(); 
	
	$("#savechanges").click(function(){
		$("#submit_form").show(); 
	});
	
	$('#submit_form1').hide(); 
	
	$("#savechanges1").click(function(){
		$("#submit_form1").show(); 
	});
	
});
</script>

<script> 
<?php if(isset($rev_sold_jobs)){ for($i=1; $i<=count($rev_sold_jobs); $i++){ ?>
$(document).ready(function(){ 
	$('#submit_form<?php echo $i;?>').hide(); 
	
	$(".savechanges<?php echo $i;?>").click(function(){
		$("#submit_form<?php echo $i;?>").show(); 
	});
});
<?php }} ?>
</script>

<div class="portlet light">
  <div class="portlet-body">
  
	<div class="row">		
		<div class="col-md-4 margin-bottom-15">
			<?php if(null != $this->session->flashdata('message')){ ?>						
				<div class="alert alert-success margin-0 padding-5 small"><?php echo $this->session->flashdata('message'); ?></div>
			<?php } ?>
		</div>	
	</div>
	
	<div class="row">
		<div class="col-md-12 col-md-12">
			<p class="font-lg">Order Status</p>
			
			<div class="table-scrollable">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Order Id</th>
							<th>Order Status</th>
							<th>Version</th>
							<th>PDF</th>
							<th>Adrep Name</th>
							<th>Publication Name</th>
							<th>History</th>
						</tr>
					</thead>
					<tbody>	
					<?php //echo'helloo';
					    if(isset($orders)){ 
				             foreach($orders as $row){
						        $adrep_name = $this->db->query("SELECT * FROM `adreps` WHERE `id` = '".$row['adrep_id']."' ")->result_array();
						        $publi_name = $this->db->query("SELECT * FROM `publications` WHERE `id` = '".$row['publication_id']."' ")->result_array();
						        $order_status = $this->db->query("SELECT * FROM `order_status` WHERE `id` = '".$row['status']."' ")->row_array();
					?>					
						<tr>		
							<form method="post">
								<input type ="text" value="<?php echo $row['id'];?>" name="order_id" style="display:none">
								<td>
									<!--<a href="<?php echo base_url().index_page().'new_admin/home/rev_status'; ?>"><?php echo $row['id'];?></a>-->
									<?php echo $row['id'];?>
								</td>
								<td id="savechanges">
								    <?php echo($order_status['name']); ?>
									<!--<select class="select2m form-control" name="status_id">
										<?php foreach($order_status as $status_row){ ?>
											<option value="<?php echo($status_row['id'])?>" <?php if($orders[0]['status']==$status_row['id']){ echo "selected"; } ?> ><?php echo($status_row['name']); ?></option>
										<?php }?>
									</select>
									<span class="pull-right">
										<button id="submit_form" type="submit" name="update_status" class="margin-top-5 btn btn-xs btn-primary" style="display: inline-block;">Save Changes</button>
									</span>-->
								</td>
								<td>V1</td>
								<td>
									<?php if($row['pdf'] != 'none') { ?>
										<a href="<?php echo base_url().$row['pdf'] ?>" target="_Blank" type="button" class="btn bg-red btn-xs"><i class="fa fa-file-pdf-o"></i></a>
									<?php } ?>
								</td>
								<td><?php if(isset($adrep_name[0]['id'])){ echo $adrep_name[0]['first_name'].' '.$adrep_name[0]['last_name'];}else{echo '';}?></td>
								<td><?php echo $publi_name[0]['name'];?></td>
								<td>
									<a href="javascript:;" class="btn btn-primary btn-xs" onclick="window.location = '<?php echo base_url().index_page()."new_admin/home/order_review_history/".$row['id'];?>'">History</a>
								</td>
							</form>
						</tr>
					<?php } }?>
					</tbody>
				</table>
			</div>
		</div>
		
		<div class="col-md-7 col-md-12">
			<p class="font-lg">Revision Order Status</p>
				<table class="table table-bordered table-hover">
				<?php if(isset($rev_sold_jobs[0]['id'])){ ?>
					<thead>
						<tr>
							<th>Order Id</th>
							<th>Revision Status</th>
							<th>Version</th>
						</tr>
					</thead>
					<tbody>	
							<?php 
							    $i=0; 
							    foreach($rev_sold_jobs as $row1){ $i++; 
							        $rev_order_status = $this->db->query("SELECT * FROM `rev_order_status` WHERE `id` = '".$row1['status']."'")->row_array();
							        
							?>		
						<tr>								
							<form method="post">
							<input type ="text" value="<?php echo $row1['id'];?>" name="rev_order_id" style="display:none">
								<input type ="text" value="<?php echo $row1['order_id'];?>" name="order_id" style="display:none">
								<td><?php echo $row1['order_id'];?></td>
								<td class="savechanges<?php echo $i;?>">
								    <?php echo($rev_order_status['name']); ?>
									<!--<select class="selec2m form-control" name="rev_status_id">
										<?php foreach($rev_order_status as $status_row1){ ?>
										<option value="<?php echo($status_row1['id'])?>" <?php if($row1['status']==$status_row1['id']){ echo "selected"; } ?> ><?php echo($status_row1['name']); ?></option>
										<?php }?>
									</select>
									<span class="pull-right">
										<button id="submit_form<?php echo $i;?>" type="submit" name="update_rev_status" class="margin-top-5 btn btn-xs btn-primary" style="display: inline-block;">Save Changes</button>
									</span>-->
								</td>
								<td><?php echo $row1['version'];?></td>	
							</form>					   
						</tr>
							<?php }?>		
					</tbody>
				<?php }?>
				</table>
		
		</div>
		
	
	<!--
	   <div class="col-md-7 col-md-12">
		<p class="font-lg">Revision Order Status</p>
		<table class="table table-bordered table-hover">
		<?php if(isset($rev_sold_jobs[0]['id'])){ ?>
		<thead>
			<tr>
				<th>Order Id</th>
				<th>Revision Status</th>
				<th>Version</th>
			</tr>
		</thead>
		<tbody>		
			<tr>		
			<?php $i=0; foreach($rev_sold_jobs as $row1){ $i++; ?>
				<form method="post">
					<input type ="text" value="<?php echo $row1['id'];?>" name="rev_order_id" style="display:none">
					<input type ="text" value="<?php echo $row1['order_id'];?>" name="order_id" style="display:none">
		
					<td><?php echo $row1['order_id'];?></td>
					<td class="savechanges<?php echo $i;?>">
						<select class="selec2m form-control" name="rev_status_id">
							<?php foreach($rev_order_status as $status_row1){ ?>
							<option value="<?php echo($status_row1['id'])?>" <?php if($row1['status']==$status_row1['id']){ echo "selected"; } ?> ><?php echo($status_row1['name']); ?></option>
							<?php }?>
						</select>
						<span class="pull-right">
							<button id="submit_form<?php echo $i;?>" type="submit" name="update_rev_status" class="margin-top-5 btn btn-xs btn-primary" style="display: inline-block;">Save Changes</button>
						</span>
					</td>
					<td><?php echo $row1['version'];?></td>
				</form>
			<?php } ?>
			</tr>
		</tbody>
		<?php } ?>
		</table>
		</div>	
		--->
	</div>
	
  </div>
</div>

<?php $this->load->view('new_admin/footer')?>
<?php $this->load->view('new_admin/foot')?>
