<?php $this->load->view('new_admin/header.php'); ?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<div class="page-content">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="row">
					<div class="col-md-6 font-lg font-grey-gallery">Designer Category details</div> 
					<div class="col-md-6 text-right">	
						<button class="btn bg-grey btn-xs margin-right-10" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
						<span class="cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
					</div> 
				</div>
			</div>
			
			
			<div class="portlet-body no-space">	
				<table class="table table-bordered table-hover" id="sample_6">
					<thead>
						<tr>
							<th>Designer Name</th>
							<th>Total Ads</th>
						</tr>
					</thead>
					<tbody>
					<?php 
						if(isset($result )){
							foreach($result as $r){
					?>
					<tr>
					
						<td><?php echo $r['name']; ?></td>
						<td><?php echo $r['dcount'];?></td>
					
					</tr>
						<?php } } ?>
					</tbody>
				</table>
			</div>
	   </div>
   </div>
<!-- END CONTAINER -->
</div>
</div>
	<!-- BEGIN FOOTER -->

<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable.php'); ?>