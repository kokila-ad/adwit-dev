<?php $this->load->view("admin/head1");?>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript">
	$(document).ready(function($) {
        $('#help_desk').change(function() {
            window.location = "<?php echo base_url().index_page().'admin/home/bill_grp_report/';?>" + $('#help_desk').val() ;
        });
    });
</script>
	<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
				 
				<div class="portlet light">
					<div class="portlet-body">					
						<div class="row">
							<label class="col-lg-4 col-lg-offset-1 col-md-4 col-md-offset-1 col-sm-12 control-label text-right margin-top-5">Select Your Group:</label>
							<div class="col-lg-3 col-md-4 col-sm-12">
								<select id="help_desk" name="help_desk" class="form-control">
									<option value="">Select Group</option>
									<?php
										$types = $this->db->query("SELECT * FROM `Group` WHERE `is_active` ='1' ORDER BY `name`")->result_array();
										foreach($types as $type)
										{
											echo '<option value="'.$type['id'].'" '.($form==$type['id'] ? 'selected="selected"' : '').'>'.$type['name'].'</option>';	
										}
									?>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-3 col-lg-offset-9">
								<form class="search-form search-form-expanded" method="post">
									<div class="input-group">
										<input type="text" name="order_id" id="order_id" class="form-control" placeholder="Search Order..." >
										<span class="input-group-btn">
										<!--<a href="javascript:;" class="btn submit bg-green-haze"><i class="icon-magnifier"></i></a>-->
										<input class="btn bg-green-haze" type="submit" value="Search" name="search" />
										</span>
									</div>
								</form>
							</div>	
						</div>
					
				<hr>		
<?php if(isset($form)){ ?>				
				<!-- BEGIN PAGE HEADER-->
				<!-- END PAGE HEADER-->
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box green-haze">
							<div class="portlet-title">
								<div class="caption">
									Group Bill Report :<?php if(isset($from) && isset($to)){echo $from." to ".$to;}elseif(isset($today)){echo $today;} ?>
								</div>
								<div class="tools  margin-left-10">
									<a href="javascript:;" class="collapse">
									</a>
									<a href="javascript:;" class="reload">
									</a>
								</div>
								<div class="margin-top-10 text-right">
									<button class="btn bg-grey btn-xs"><i class="fa fa-file-excel-o"></i> Export</button>
									<button class="btn bg-grey btn-xs"><i class="fa fa-print"></i> Print</button>
								</div>
							</div>
							
							<div class="portlet-body">
								
								<div class="portlet light margin-bottom-5">
									<div class="portlet-body">					
										<div class="row">
											<form method="post">
												<label class="col-lg-1 no-space control-label margin-top-5">Date Range</label>
												<div class="col-md-4">
													<div class="input-group input-large date-picker input-daterange" data-date="2012/10/11" data-date-format="yyyy/mm/dd">
														<input type="text"  name="from_date" placeholder="YYYY-MM-DD" class="form-control">
														<span class="input-group-addon">
														to </span>
														<input type="text" name="to_date" placeholder="YYYY-MM-DD" class="form-control">
													</div>
												</div>	
												<div class="col-md-1">
													<input type="submit" class="btn bg-green-haze" value="Submit">
												</div>
											</form>
										</div>
									</div>
								</div>
				
								<table class="table table-striped table-bordered table-hover" id="sample_6">
								<thead>
								<tr>
									<th>Date</th>
									<th>Adwit Id</th>
									<th>Ad Type</th>
									<th>Job Name</th>
									<th>Adrep</th>
									<th>Publication</th>
									<th>Advertiser</th>
									<th>Width</th>
									<th>Height</th>
									<th>Total sq inches</th>
									<th>File path</th>																		<th>Category</th>
								</tr>
								</thead>
								<tbody>
<?php 
		foreach($grp_pub as $row1){
		$pid = $row1['id'];
		if(isset($from) && isset($to)){
			$orders = $this->db->query("SELECT  * FROM `orders` WHERE `publication_id`='$pid' AND `pdf`!='none' AND `created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59' ;")->result_array();
		}else{
			$orders = $this->db->query("SELECT  * FROM `orders` WHERE `publication_id`='$pid' AND `pdf`!='none' AND	 `created_on` LIKE '$today%';")->result_array();
		}
	
		foreach($orders as $row)
		{	
			$tot_size = 0;
			$ad_type = $this->db->get_where('orders_type',array('id' => $row['order_type_id']))->result_array();
			$cat_result = $this->db->get_where('cat_result',array('order_no' => $row['id']))->result_array();
			$adrep = $this->db->get_where('adreps',array('id' => $row['adrep_id']))->result_array();
			$tot_size = $row['width'] * $row['height'];
?>								
		<tr>
			<td><?php echo $row['created_on']; ?></td>
			
                <td><?php echo $row['id']; ?></td>
				
				<td><?php echo $ad_type[0]['name']; ?></td>
				
				<td><?php echo $row['job_no']; ?></td>
				
				<td><?php echo $adrep[0]['first_name'].' '.$adrep[0]['last_name']; ?></td>
				
				<td><?php echo $row1['name']; ?></td>
				
				<td><?php echo $row['advertiser_name']; ?></td>
				
                <td><?php echo $row['width']; ?></td>
				
                <td><?php echo $row['height']; ?></td>
				
				<td><?php echo round($tot_size,2); ?></td>
				
                <td><?php if($cat_result){ echo $cat_result[0]['pdf_path']; }else{ echo 'none';} ?></td>												<td><?php echo $cat_result[0]['category'];?></td>
			
		</tr>
		<?php } }?>								
								</tbody>
								</table>
							</div>
						</div>
						<!-- END EXAMPLE TABLE PORTLET-->
<?php }elseif(isset($search_orders)){ ?>
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box green-haze">
							<div class="portlet-title">
								<div class="caption">
									Search Report
								</div>
								<div class="tools  margin-left-10">
									<a href="javascript:;" class="collapse">
									</a>
									<a href="javascript:;" class="reload">
									</a>
								</div>
								<div class="margin-top-10 text-right">
									<button class="btn bg-grey btn-xs"><i class="fa fa-file-excel-o"></i> Export</button>
									<button class="btn bg-grey btn-xs"><i class="fa fa-print"></i> Print</button>
								</div>
							</div>
							
							<div class="portlet-body">
								
								<table class="table table-striped table-bordered table-hover" id="sample_6">
								<thead>
								<tr>
									<th>Date</th>
									<th>Adwit Id</th>
									<th>Ad Type</th>
									<th>Job Name</th>
									<th>Adrep</th>
									<th>Publication</th>
									<th>Advertiser</th>
									<th>Width</th>
									<th>Height</th>
									<th>Total sq inches</th>
									<th>File path</th>
								</tr>
								</thead>
								<tbody>
<?php 	
			foreach($search_orders as $row)
		{	
			$tot_size = 0;
			$ad_type = $this->db->get_where('orders_type',array('id' => $row['order_type_id']))->result_array();
			$cat_result = $this->db->get_where('cat_result',array('order_no' => $row['id']))->result_array();
			$adrep = $this->db->get_where('adreps',array('id' => $row['adrep_id']))->result_array();
			$publication = $this->db->get_where('publications',array('id' => $row['publication_id']))->result_array();
			$tot_size = $row['width'] * $row['height'];
?>								
		<tr>
			<td><?php echo $row['created_on']; ?></td>
                <td><?php echo $row['id']; ?></td>
				<td><?php echo $ad_type[0]['name']; ?></td>
				<td><?php echo $row['job_no']; ?></td>
				<td><?php echo $adrep[0]['first_name'].' '.$adrep[0]['last_name']; ?></td>
				<td><?php echo $publication[0]['name']; ?></td>
				<td><?php echo $row['advertiser_name']; ?></td>
                <td><?php echo $row['width']; ?></td>
                <td><?php echo $row['height']; ?></td>
				<td><?php echo round($tot_size,2); ?></td>
                <td><?php if($cat_result){ echo $cat_result[0]['pdf_path']; }else{ echo 'none';} ?></td>
			
		</tr>
 <?php } ?>								
								</tbody>
								</table>
							</div>
						</div>
		<!-- END EXAMPLE TABLE PORTLET-->
<?php } ?>
					
					</div>
				</div>
			</div>
		</div>
		<!-- END CONTENT -->
		
		<!-- BEGIN QUICK SIDEBAR -->
		<!--Cooming Soon...-->
		<!-- END QUICK SIDEBAR -->
	</div>
	<!-- END CONTAINER -->

	
<?php $this->load->view("admin/foot1");?>