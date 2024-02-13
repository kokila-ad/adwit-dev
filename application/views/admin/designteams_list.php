<?php $this->load->view("admin/head1.php"); ?>
<script type="text/javascript" src="jquery-1.3.2.js" ></script>

<script type="text/javascript" src="html2csv.js" ></script>
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
				<div class="portlet light">
					<div class="portlet-body">	
				<!-- BEGIN PAGE HEADER-->
				<div class="row">
					<div class="col-md-6">
						<h3 class="page-title">Design Teams</h3>
					</div>
					<div class="col-md-6">
						<?php echo '<span style="color:#900;">'.$this->session->flashdata('designteams_successful').'</span>'; ?>
						<?php echo '<span style="color:#900;">'.$this->session->flashdata('designteams_updated_successful').'</span>'; ?>
					</div>
				</div>
				<!-- END PAGE HEADER-->

				<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box green-haze">
							<div class="portlet-title">
								<div class="caption">
									<a data-toggle="modal" href="#addnew" type="button" class="btn btn-default btn-xs">
										<i class="fa fa-plus margin-right-10"></i>Add Design Team
									</a>
								</div>
								<div class="tools margin-left-10">
									<a href="javascript:;" class="collapse">
									</a>
									<a href="javascript:;" class="reload">
									</a>
								</div>
								<div class="margin-top-10 text-right">
									<!--<button class="btn bg-grey btn-xs"><i class="fa fa-file-excel-o"></i> Export</button>-->
									<button class="btn bg-grey btn-xs" onclick="tableToExcel('sample_2', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
									<button class="btn bg-grey btn-xs"><i class="fa fa-print"></i> Print</button>
								</div>
							</div>
							<div class="portlet-body">
								<table class="table table-striped table-bordered table-hover" id="sample_2">
								<thead>
								<tr>
									<th>Id</th>
									<th>Name</th>
									<th>Email id</th>
									<th>Actions</th>
								</tr>
								</thead>
								<tbody>
								<?php $i=0; foreach($design_team as $row) {  $i++; ?>
								<tr>
									<td><?php echo $row['id'];?></td>
									<td><?php echo $row['name'];?></td>
									<td><?php echo $row['email_id'];?></td>
									<?php if($row['is_active']==1) { ?>
									<td>
										<a data-toggle="modal" href="#edit<?php echo $i;?>" class="font-blue margin-right-10"><i class="fa fa-edit"></i></a>
										<a title="" class="btn btn-primary btn-xs">Active</a>
									</td>
									<?Php } else { ?>
									<td>
										<a data-toggle="modal" href="#edit<?php echo $i;?>" class="font-blue  margin-right-10"><i class="fa fa-edit"></i></a>
										<a title="" class="btn btn-danger btn-xs">Deactive</a>
									</td>
									<?php } ?>
								</tr>	
								<div id="edit<?php echo $i;?>" class="modal fade" tabindex="-1" data-width="760">
									<div class="modal-dialog">
										<div class="modal-content">
											<form method="post" name="order_form" action="<?php echo base_url().index_page().'admin/home/designteams_update/'.$row['id'];?>" id="order_form">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h4 class="modal-title">Edit Design Team</h4>
											</div>
											<div class="modal-body">																																		
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label class="margin-top-5">Name</label><span class="mandatory font-red">*</span>
															<input type="text" class="form-control" name="name" value="<?php echo $row['name'];?>" required>
														</div>

														<div class="form-group">
															<label class="margin-top-5">Email Id</label><span class="mandatory font-red">*</span>
															<input type="text" class="form-control" name="email_id" value="<?php echo $row['email_id'];?>" required>
														</div>						  
														
														<div class="form-group">
															<label class="margin-top-5">Newad Template</label><span class="mandatory font-red">*</span>
															<input type="text" class="form-control" name="newad_template" value="<?php echo $row['newad_template'];?>" required>
														</div>

														<div class="form-group">
															<label class="margin-top-5">Revad Template</label><span class="mandatory font-red">*</span>
															<input type="text" class="form-control" name="revad_template" value="<?php echo $row['revad_template'];?>" required>
														</div>
													</div>				
												</div>		
											</div>
											<div class="modal-footer">	
												<!--<button type="button" class="btn btn-primary">Update</button>-->
												<button type="button" class="btn red-flamingo" data-dismiss="modal" aria-hidden="true">Back</button>
												<input class="btn btn-primary" type="submit" value="Update" id="submit_form"  />
												<!--<button type="button" class="btn btn-success">Update and go back to list</button>-->	
												
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
						<!-- END EXAMPLE TABLE PORTLET-->
						
				</div>
		
				</div>
			</div>
		<!-- END CONTENT -->
	</div>
	<!-- END CONTAINER -->


	
<div id="addnew" class="modal fade" tabindex="-1" data-width="760">
	<div class="modal-dialog">
		<div class="modal-content">
		<form method="post" name="order_form" id="order_form">	
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Add Design Team</h4>
			</div>
  	        <div class="modal-body">																																		
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="margin-top-5">Name</label><span class="mandatory font-red">*</span>
							<input type="text" name="name" class="form-control" required/>
						</div>

						<div class="form-group">
							<label class="margin-top-5">Email Id</label><span class="mandatory font-red">*</span>
							<input type="text" name="email_id" class="form-control" required/>
						</div>						  
						
						<div class="form-group">
							<label class="margin-top-5">Newad Template</label><span class="mandatory font-red">*</span>
							<input type="text" name="newad_template" class="form-control" required/>
						</div>

						<div class="form-group">
							<label class="margin-top-5">Revad Template</label><span class="mandatory font-red">*</span>
							<input type="text" name="revad_template" class="form-control" required/>
						</div>
					</div>				
				</div>		
			</div>
			<div class="modal-footer">	
				<!--<button type="button" class="btn btn-primary">Save</button>-->
				<button type="button" class="btn red-flamingo" data-dismiss="modal" aria-hidden="true">Back</button>
				 <input class="btn btn-primary" type="submit" value="Create" id="submit_form"  />
				
			 </div>
			 </form>
		</div>
	</div>
</div>
	</div>
</div>
<script>
        $(function() {
            
        });
        </script>
		<script>
		
			var tableToExcel = (function() {
				
		  var uri = 'data:application/vnd.ms-excel;base64,'
			, template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head></head><body><table>{table}</table></body></html>'
			, base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
			, format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
		  return function(table, name) {
			if (!table.nodeType) table = document.getElementById(table)
			var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
			window.location.href = uri + base64(format(template, ctx))
		  }
		})()
		
        </script>
<?php $this->load->view("admin/foot1.php"); ?>