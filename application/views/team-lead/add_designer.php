<?php
       $this->load->view("team-lead/head"); 
?>



<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">

	<!-- BEGIN PAGE CONTENT -->
	<div class="page-content">
		<div class="container">
	
			<!-- BEGIN PAGE CONTENT INNER -->
			<div class="portlet light">
				<div class="portlet-body">
					<div class="row">
					<form method="post">
					<div class="col-md-12">
						<h4 class="font-blue-steel">Add Designer</h4>
						<table class="table table-striped table-bordered table-hover" id="sample_2">
							<thead>
							<tr>
								<th>DesignerName</th>
								<th>DesignerCode</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody>
							
								<?php foreach($designers as $row) { 
									$tag_designer = $this->db->query("SELECT * FROM `tag_designer_teamlead` where `designer_id` = '".$row['id']."' AND `teamlead_id`='".$this->session->userdata('tId')."'")->result_array(); ?>
								<tr>
									<td><?php echo $row['name']; ?></td>
									<td><?php echo $row['username']; ?></td>
									<td>
								
									  <?php if($tag_designer) { ?>
										<form method="post">
											
												<input type="text" name="rid" id="rid" value="<?php echo $tag_designer[0]['id']; ?>" style="display:none;" />
												<button type="submit" name="remove_button" class="btn btn-danger">Remove</button>			 
											
										</form>
									  <?php } else { ?>
									<form method="post">
										<input type="text" name="did" id="did" value="<?php echo $row['id']; ?>" style="display:none;" />
										<button type="submit" name="add_button" class="btn btn-success">Add</button>
									</form>
								<?php } ?>
									</td>
   
								</tr> 
							<?php } ?>
								
							</tbody>
						</table>  
					</div>	
					</form>		
					</div>
				</div>
				
			</div>
			<!-- END PAGE CONTENT INNER -->
		</div>
	</div>
	<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->

	


<?php
       $this->load->view("team-lead/foot"); 
?>
