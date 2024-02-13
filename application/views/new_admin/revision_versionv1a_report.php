<?php $this->load->view('new_admin/header.php'); ?>

<style>
.tabletools-btn-group {
    margin: 0 0 10px 0;
    display: none;
}
.tabletools-dropdown-on-portlet > .btn:last-child {
    margin-right: 0;
    display: none;
}
</style>

<div class="page-content">
	<div class="container">

		<div class="portlet light">
			<div class="portlet-title">
				<div class="caption">
					<span class="caption-subject font-grey-sharp bold">Todays Revision Ads </span>
				</div>
				<div class="actions btn-set">
					<span class=" cursor-pointer right"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
				</div>
			</div>
		</div>
	<div class="row">
			<div class="col-sm-12 ">
				<div class="portlet light">
					<div class="portlet-body">
						<table class="table table-striped table-bordered table-hover " id="sample_6">
						<thead>
						<tr>
							<th width="10px">No</th>
							<th>V1a Orders</th>
							<th>V1b Orders</th>
							<th>Version</th>
						</tr>
						</thead>
						<tbody>
						<?php $i= 1;
						if(isset($classification) ){
							foreach($classification as $row){
								$class_no = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id` = '".$row['order_id']."' AND `version` = 'V1b'")->result_array();
							?>
							<tr class="odd gradeX">
								<td><?php echo $i++; ?>
								<td><?php echo $row['order_id'];?></td>
								<?php
									if(isset($class_no[0]['id'])){
										foreach($class_no as $crow){ ?>
								<td><?php if(isset($class_no[0]['id'])) { echo $crow['order_id']; }?></td>
								<td><?php if(isset($class_no[0]['id'])) { echo $crow['version']; }?></td>
								<?php } }else{ ?>
								<td></td>
								<td></td>
								<?php } ?>
							</tr>
							<?php } } ?>
						</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	
<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable.php');?>
