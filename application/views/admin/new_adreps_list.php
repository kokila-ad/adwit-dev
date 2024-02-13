<?php $this->load->view("admin/head1");?>
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
				<div class="portlet light">
					<div class="portlet-body">	
				<!-- BEGIN PAGE HEADER-->
				<h3 class="page-title">Adreps</h3>
				<!-- END PAGE HEADER-->

				<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box green-haze">
							<div class="portlet-title">
								<div class="caption">								
								</div>
								<div class="tools  margin-left-10">
									<a href="javascript:;" class="collapse">
									</a>
									<a href="javascript:;" class="reload">
									</a>
								</div>
								<div class="margin-top-10 text-right">
									<button class="btn bg-grey btn-xs"><i class="fa fa-file-excel-o"></i> Export To Excel</button>
								</div>
							</div>
							<div class="portlet-body">
								<table class="table table-striped table-bordered table-hover" id="sample_2">
								<thead>
								<tr>
									<th>Id</th>
									<th>First Name</th>
									<th>Last Name</th>
									<th>Username</th>
									<th>Email ID</th>
									<th>Publication</th>
								</tr>
								</thead>
								<tbody>
								<?php $i=0; foreach($adreps as $row) { $i++;
								$publications = $this->db->query("SELECT * FROM `publications` WHERE `id` = '".$row['publication_id']."'")->result_array();
								?>
								<tr>
									<td><?php echo $row['id'] ;?></td>
									<td><?php echo $row['first_name'] ;?></td>
									<td><?php echo $row['last_name'] ;?></td>
									<td><?php echo $row['username'] ;?></td>
									<td><a data-toggle="modal" href="#sendmail<?php echo $i;?>"><?php echo $row['email_id'] ;?></a></td>
									<td><?php if($row['publication_id']=='0'){ echo "";}else{ echo $publications[0]['name']; }?></td>
								</tr>
								<!--EDIT-->
								<div id="sendmail<?php echo $i;?>" class="modal fade" tabindex="-1" data-width="760">
									<div class="modal-dialog">
										<div class="modal-content">
										<form method="post">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h4 class="modal-title">Send Mail to Adrep</h4>
											</div>
											<div class="modal-body">																																		
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<input type="text" name="id" id="id" value="<?php echo $row['id']; ?>" class="form-control" required/>
														</div>
													</div>	
												</div>
												
											</div>
											 <div class="modal-footer">	
												<button type="submit" name="send_mail" class="btn btn-primary">Send</button>
												<button type="button" class="btn red-flamingo" data-dismiss="modal" aria-hidden="true">Cancel</button>
											 </div>
										</form>	 
										</div>
									</div>
								</div>
								<!--EDIT-->
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
		<!-- BEGIN QUICK SIDEBAR -->
		<!--Cooming Soon...-->
		<!-- END QUICK SIDEBAR -->
		</div>
	<!-- END CONTAINER -->

	
	</div>
</div>	
	<?php $this->load->view("admin/foot1");?>