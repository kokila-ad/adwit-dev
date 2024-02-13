<?php $this->load->view('management/head');?>
<style>
.box .table>tbody>tr>td , .box .table>thead>tr>th{padding:4px;}
.box .table>thead>tr>th{font-size:13px;}
.box input[type="search"]{padding:4px;font-size:12px;height:25px;}
</style>

<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<div class="page-content">
		<div class="container">
		
			<div class="row margin-top-15">
				<div class="col-sm-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="row static-info">
								<div class="col-md-8 value margin-top-10">Publication</div>
							</div>
						</div>
						<div class="portlet-body">
							<div class="row">
								<div class="col-md-12">
									<table class="table table-striped table-bordered table-hover" id="sample_2">
											<thead>
												<tr>
													<th>Publication</th>
													<th>Group</th>
													<th>Average ads</th>
													<th>New ads Turnaround</th>
													<th>Revision Turnaround</th>
													<th>Revision Ratio</th>
												</tr>
											</thead>
											<tbody><?php if(isset($publication)){?>
													<?php foreach($publication as $row){
														$group_name = $this->db->query("SELECT * FROM `Group` WHERE `id` = '".$row['group_id']."' ")->result_array();	
														$orders = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '".$row['id']."' AND `pdf`!='none' AND (`created_on` BETWEEN '$past_month' AND '$cur_date')")->result_array();
														$avg_tim_diff = 0; $rev_avg_tim_diff = 0; $ratio = 0;
														if($orders){
															
															$time_diff = 0; $count = 0;
															$rev_time_diff = 0; $rev_count = 0;
															foreach($orders as $order){
																$time1 = 0; $time2 = 0;
																$count++;
																$time1 = strtotime($order['created_on']);
																$time2 = strtotime($order['pdf_timestamp']);
																$time_diff = $time_diff + ($time2 - $time1);	
															
														$rev_orders = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id` = '".$order['id']."' AND `pdf_path`!='none';")->result_array();
														if($rev_orders){
															foreach($rev_orders as $r_order){ //echo 'rev_id : '.$r_order['id'];
															$rev_count++;
																$ttime1 = 0; $ttime2 = 0;
																$ttime1 = strtotime($r_order['date'].' '.$r_order['time']);
																$ttime2 = strtotime($r_order['ddate'].' '.$r_order['sent_time']);
																$rev_time_diff = $rev_time_diff + ($ttime2 - $ttime1);
															}	
														}
														}
														$avg_tim_diff = ($time_diff / $count);
														if($rev_time_diff != '0'){
															$rev_avg_tim_diff = ($rev_time_diff / $rev_count);
														}	
														
														$ratio = ($rev_count / $count) ;
														}
													?>
												<tr>
													<td><?php echo $row['name'];?></td>
													<td><?php if($row['group_id'] == '0'){ echo 'none'; }else{ echo $group_name[0]['name']; } ?></td>
													<td><?php if($orders){
															$count = count($orders);
															$avg = $count/6;
															echo (round($avg,2));
														} ?>
													</td>
													<td><?php if(isset($avg_tim_diff)){ echo gmdate("H:i:s", $avg_tim_diff ); } ?></td>
													<td><?php if(isset($rev_avg_tim_diff)){ echo gmdate("H:i:s", $rev_avg_tim_diff ); } ?></td>
													<td><?php echo (round($ratio,2));?></td>
												</tr>	
											<?php }?>
											<?php }?>
											</tbody>
										</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>		
		</div>
	</div>
</div>

<?php $this->load->view('management/foot');?>

