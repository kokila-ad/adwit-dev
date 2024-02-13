<?php $this->load->view('new_admin/header.php'); ?>


<div class="row">
<div class="col-md-6">		
	<div class="caption">
		<span class="font-md font-grey-gallery bold"><h3>Project Head Details</h3></span>
	</div>
</div>	
<div class="col-md-6">
	<?php echo '<span style="color:#900;">'.$this->session->flashdata('message').'</span>'; ?>
</div>	
</div>	
	<hr class="margin-top-10">		
	
	
<div class="portlet light">
	<div class="portlet-body">
		<div class="row">
		
			<div class="col-md-7">
				<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>Request Id</th>
						<th>Type</th>
						<th>Date</th>
						<th>Approved</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
				<?php if(isset($pro_details)){?>
				<?php  foreach($pro_details as $row){
						$type_name = $this->db->query("SELECT * FROM `request_type` WHERE `id` = '".$row['type']."' ")->result_array();
				?>
					<tr>
						<td><?php echo $row['id'];?></td>
						<td><?php echo $type_name[0]['name'];?></td>
						<td><?php echo $row['date'];?></td>
						<td><?php echo $row['approved'];?></td>
						<td title="Job Cancel">
						<!--Start: Cancel-->									
						<span class="dropdown text-grey">
							<span class="btn btn-block btn-xs padding-5 btn-grey cursor-pointer padding-left-5" type="button" data-toggle="dropdown" id="view" aria-expanded="false">Approve</span>
							<div class="dropdown-menu file_li padding-10">  
								<p class="margin-bottom-5">Are you sure?</p>
								<div class="row">
									<div class="col-xs-6 padding-right-5 ">
									<form method = "post" name="order_form" id="order_form" action="<?php echo base_url().index_page().'new_admin/home/project_head_details';?>">
										<input type="hidden" value="<?php echo $row['id']; ?>" name="id">
										<input type = "hidden" value ="1"<?php if($row['approved']== '1') echo"checked";?> name ="approved">
											<button type="submit" name="submit" class="btn btn-primary btn-xs padding-5 padding-horizontal-20 margin-right-5 btn-block">Yes</button>
									</form>
									</div>
									<div class="col-xs-6 padding-left-5">
										<button class="btn btn-blue btn-xs padding-5 padding-horizontal-20 btn-block">No</button>
									</div>
								</div>
							</div>
						</span>
					<!--End: Cancel-->
					</td>
					</tr>
					
				<?php } }?>
				</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

	
<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable.php'); ?>