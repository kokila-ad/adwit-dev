<?php $this->load->view('new_csr/head'); ?>


<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">

	<!-- BEGIN PAGE CONTENT -->
	<div class="page-content">
		<div class="container">
	
			<!-- BEGIN PAGE CONTENT INNER -->
			<div class="portlet light">
				<div class="portlet-title no-space margin-top-10">
						<div class="row static-info">
							<div class="col-sm-6 value bold">Assign Designer
							</div>
						</div>
					</div>
				<div class="portlet-body">
					<table class="table table-striped table-bordered table-hover" id="sample_6">
							<thead>
							<tr>
								<th>DesignerName</th>
								<th>DesignerCode</th>
								<th>NewUI(Design8)</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody>
								<?php $i=0; foreach($designers as $row){ $i++; ?>
									<tr>
										<td><?php echo $row['name']; ?>
										<td><?php echo $row['username']; ?></td>
										<td><?php if($row['new_d']=='1'){  echo "Enabled";  } else { echo "Disabled";  } ?></td>
										<td>
										<a data-toggle="modal" href="#edit<?php echo $i; ?>" class="font-blue  margin-right-10"><i class="fa fa-edit"></i> Edit</a>
										</td>
									</tr> 
<div id="edit<?php echo $i; ?>" class="modal fade" tabindex="-1" data-width="760">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Edit Designer</h4>
			</div>
			<form method="post">
  	        <div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group"> 
							<label class="margin-top-5">Designer Name</label>
							<input type="text" name="designer_name" id="designer_name" value="<?php echo $row['name'];?>" class="form-control margin-bottom-20" hidden readonly>
						
							<label class="margin-top-5">Designer Code</label>
							<input type="text" name="designer_code" id="designer_code" value="<?php echo $row['username'];?>" class="form-control margin-bottom-20" hidden readonly>
						
							<label class="margin-top-5">Action</label>
							<div class="clearfix">
								<div class="btn-group" data-toggle="buttons">
								
									<div class="btn-group" data-toggle="buttons">
										<label class="btn btn-success active margin-right-10">
										<input type="radio" name="action" value="1" class="toggle" required> Enable </label>
										<label class="btn btn-success">
										<input type="radio" name="action" value="0" class="toggle"> Disable </label>
									</div>
								
								</div>
							</div>
						</div>	
					</div>	 
				</div>							
		    </div>
			<div class="modal-footer">
				<input type="text" name="did" id="did" value="<?php echo $row['id']; ?>" style="display:none;" />
				<button type="submit" name="update" class="btn btn-success">Update</button>
				<button data-dismiss="modal" aria-hidden="true" class="btn red-flamingo">Cancel</button>
			</div>
			</form>
		</div>
	</div>
</div>
									
								<?php } ?>
							</tbody>
						</table>  
						</div>
				</div>
			<!-- END PAGE CONTENT INNER -->
		</div>
	</div>
	<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->

	


<?php $this->load->view('new_csr/foot'); ?>