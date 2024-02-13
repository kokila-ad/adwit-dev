<?php $this->load->view("admin/head1.php");?>
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
						<h3 class="page-title">Notification</h3>
					</div>
					<div class="col-md-6">
						<?php echo '<span style="color:#900;">'.$this->session->flashdata('successful').'</span>'; ?>
						<?php echo '<span style="color:#900;">'.$this->session->flashdata('updated_successful').'</span>'; ?>
					</div>
				</div>
				<!-- END PAGE HEADER-->

				<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box green-haze">
							<div class="portlet-title">
								<div class="caption">
									<a href="<?php echo base_url().index_page()."admin/home/notification_add";?>" class="btn btn-default btn-xs">
										<i class="fa fa-plus margin-right-10"></i>Add Notification 1
									</a>
									<a href="<?php echo base_url().index_page()."admin/home/notification_new";?>" class="btn btn-default btn-xs">
										<i class="fa fa-plus margin-right-10"></i>Add Notification 2
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
									<button class="btn bg-grey btn-xs" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
									<button class="btn bg-grey btn-xs"><i class="fa fa-print"></i> Print</button>
								</div>
							</div>
							<div class="portlet-body">
								<table class="table table-striped table-bordered table-hover" id="sample_6">
								<thead>
								<tr>
									<th>Headline</th>
									<th>Users</th>
									<th>Start Date</th>
									<th>End Date</th>
									<th>Job Status</th>
									<th>Actions</th>
								</tr>
								</thead>
								<tbody>
								<?php foreach($notification as $row) { 
								$adwit_users_name = $this->db->query("SELECT * FROM `adwit_users` WHERE `id` = '".$row['users']."'")->result_array();
								?>
								<tr>
									<td><?php echo $row['headline']; ?></td>
									<td><?php if($row['users']=='0'){ echo "";}else{ echo $adwit_users_name[0]['name']; } ?></td>
									<td><?php echo $row['start_date']; ?></td>
									<td><?php echo $row['end_date']; ?></td>
									<?php if($row['job_status']==1) { ?>
									<td>Active</td>
									<?Php } else { ?>
									<td>DeActive</td>
									<?php } ?>
									<td>
										<a href="<?php echo base_url().index_page().'admin/home/notification_edit/'.$row['id'];?>" class="font-blue margin-right-10"><i class="fa fa-edit"></i></a>
									</td>
								</tr>								
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
	<!-- END CONTAINER -->	</div>
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
<?php $this->load->view("admin/foot1.php");?>