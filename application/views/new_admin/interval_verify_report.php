<?php $this->load->view('new_admin/header.php'); ?>

<!-- BEGIN PAGE CONTAINER -->
<div class="portlet light">
<div class="portlet-title">
<div  class="col-xs-12 text-center">
	<?php echo '<span style=" color:#900;">'.$this->session->flashdata('message').'</span>'; ?> 
</div>
<div class="row">
	<div class="col-md-7 col-xs-12 margin-bottom-10 font-lg font-grey-gallery">
		<a href="<?php echo base_url().index_page(). 'new_admin/home/interval_verify_report/'.$type; ?>" class="font-grey-gallery"><?php echo $type;?></a> :
		<span><?php $f = strtotime($from) ; $t = strtotime($to); echo "From "." - ".date('M d, Y', $f)." ". "  To " . " - " .date('M d, Y', $t);?> </span>
	</div>
	<div></div>
	<div class="col-md-3 col-xs-9 margin-bottom-10 text-right padding-right-0">
		
	</div>
	<div class="col-md-1 col-xs-4 margin-bottom-10 text-right">
		<button class="btn bg-grey btn-xs" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
	</div>
	<div class="col-md-1 col-xs-4 margin-bottom-10 text-right">	
		<span class="cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
	</div>
	</div>
	</div>

	<div class="portlet-body " >
		<div>
			<table class="table table-bordered table-hover" >
				<thead>					
					<tr>
						
						<th hidden> Sl_no </th>
						
						<th> Job No</th>

						<th> Orders <br> Created On</th>

						<th> Categorised <br>timetaken </th>

						<th> Design End<br>timetaken</th>
						
						<th> Design Check <br>timetaken </th>
						
						<th> Proof Check <br>timetaken</th> 
						
						<!--<th> Diff betn <br> Categorised and created_on</th>
						
						<th> Diff betn <br> design end time and category</th>
						
						<th> Diff betn <br> dc and design</th>
						
						<th> Diff betn <br> proofcheck and dc</th>-->
						
						<th> Orders sent <br>timetaken</th>
						
						<th> Total </th>

					</tr>

				</thead>

				<tbody> 
					<?php $i=0; $sum=0; $cat_category_result=0; $category_design_result=0; $dc_result=0; $proofcheck_result=0;
					 foreach($orders as $row){ $i++;
						$query = "SELECT cat_result.order_no, 
						CONCAT(cat_result.tl_date,' ',cat_result.tl_time) as qa_sent,
						CONCAT(cat_result.date,' ',cat_result.time)as cat_datetime, 
						CONCAT(designer_ads_time.end_date,' ',designer_ads_time.end_time) as design_endtime
						FROM `cat_result` 
						LEFT JOIN `designer_ads_time` ON cat_result.order_no = designer_ads_time.order_id 
						WHERE cat_result.order_no = '".$row['id']."' GROUP BY designer_ads_time.order_id ";
						
						$interval = $this->db->query($query)->result_array();
						//echo $query; 
						foreach($interval as $in_row){
						$created_on = strtotime($row['created_on']);
						$categorised = strtotime($in_row['cat_datetime']);
						$design_time = strtotime($in_row['design_endtime']);
						$design_check_time = strtotime($in_row['qa_sent']);
						$send_to_adrep = strtotime($row['pdf_timestamp']);
						
						//Diff between category and created_on 
						$diff = $categorised - $created_on;
						$cat_category_result = floor(($diff / 60));
						
						//Diff between design endtime and categorised
						$diff = $design_time - $categorised;
						$category_design_result = floor(($diff / 60));
						
						//Diff between design endtime and Design check (tl endtime)
						$diff = $design_check_time - $design_time ;
						$dc_result = floor(($diff / 60));
						
						
						// Diff between designcheck endtime and proof check(send to adrep)
						$diff = $send_to_adrep - $design_check_time ;
						$proofcheck_result = floor(($diff / 60));
						
						//Total Result
						$sum = $cat_category_result + $category_design_result + $dc_result + $proofcheck_result;
						$total = $sum ;
						
					?>
					<tr>
						<td hidden><?php echo $i;?></td>
						
						<td><?php echo $row['id'];?></td>

						<td><?php echo $row['created_on'];?></td>

						<!--<td><?php echo $in_row['cat_datetime'];?></td>

						<td><?php echo $in_row['design_endtime'];?></td>
						
						<td><?php echo $in_row['qa_sent'];?></td>
						
						<td><?php echo $row['pdf_timestamp'];?></td> -->
						
						<td><?php echo $cat_category_result." Mins";?></td>
						
						<td><?php echo $category_design_result." Mins";?></td>

						<td><?php echo $dc_result." Mins";?></td>
						
						<td><?php echo $proofcheck_result." Mins";?></td>
						
						<td><?php echo $row['pdf_timestamp'];?></td>
						
						<td><?php echo $total." Mins";?></td>
					</tr>
					 <?php } }?>
				</tbody>
			</table>
		</div>
	</div>
</div>	

<?php $this->load->view('new_admin/footer.php'); ?>

<?php $this->load->view('new_admin/datatable.php'); ?>

