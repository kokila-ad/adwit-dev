<?php
       $this->load->view("new_designer/head"); 
?>
<?php
	$designer_name=$this->db->get_where('designers',array('id' => $this->session->userdata('dId')))->result_array()
?>
			<!-- BEGIN TOP NAVIGATION MENU -->
			
<!-- END HEADER -->
<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<!-- BEGIN PAGE HEAD -->

	<!-- END PAGE HEAD -->
	<!-- BEGIN PAGE CONTENT -->
	<div class="page-content">
		<div class="container">
			<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">Modal title</h4>
						</div>
						<div class="modal-body">
							 Widget settings form goes here
						</div>
						<div class="modal-footer">
							<button type="button" class="btn blue">Save changes</button>
							<button type="button" class="btn default" data-dismiss="modal">Close</button>
						</div>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>
			<!-- /.modal -->
			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<!-- BEGIN PAGE BREADCRUMB -->
			<!-- END PAGE BREADCRUMB -->
    
			<!-- BEGIN PAGE CONTENT INNER -->
			<div class="row margin-top-10">
				<div class="col-md-12">
					<!-- BEGIN PROFILE SIDEBAR -->
					<div class="profile-sidebar" style="width: 250px;">
						<!-- PORTLET MAIN -->
						<div class="portlet light profile-sidebar-portlet">
							<!-- SIDEBAR USERPIC -->
							<div class="profile-userpic">
								<img src="<?php echo base_url() ?><?php echo $designer_name[0]['image']; ?>" class="img-responsive" alt="">
							</div>
							<!-- END SIDEBAR USERPIC -->
							<!-- SIDEBAR USER TITLE -->
							<div class="profile-usertitle">
								<div class="profile-usertitle-name">
									<?php echo $designer_name[0]['name'];?>
								</div>
								<div class="profile-usertitle-job">
									<?php $role = $this->db->query("SELECT * FROM `designer_role` WHERE `id` = '".$designer_name[0]['designer_role']."'")->result_array();
									if(isset($role[0]['id'])){
										echo $role[0]['name'];
									}	
									?>
								</div>
							</div>
							<!-- END SIDEBAR USER TITLE -->
							<!-- SIDEBAR BUTTONS --
							<!-- END SIDEBAR BUTTONS -->
							<!-- SIDEBAR MENU -->
							<div class="profile-usermenu">
								<ul class="nav">
									<li class="active">
										<a href="<?php echo base_url().index_page()."new_designer/home/my_profile";?>">
										<i class="icon-home"></i>
										Overview </a>
									</li>
									<?php if($designer_name[0]['designer_role'] == '2') { ?>
									<li>
										<a href="<?php echo base_url().index_page()."new_designer/home/team_report";?>">
										<i class="icon-settings"></i>
										Team Report </a>
									</li>
									<?php } ?>
									<li>
										<a href="<?php echo base_url().index_page()."new_designer/home/my_account";?>">
										<i class="icon-settings"></i>
										Account Settings </a>
									</li>
									<?php if($designer_name[0]['designer_role'] == '1' || $designer_name[0]['designer_role'] == '2') { ?>
									<li>
										<a href="<?php echo base_url().index_page()."new_designer/home/add_designer";?>">
										<i class="icon-settings"></i>
										Add Designer </a>
									</li>
									<?php } ?>
									<li>
										<a href="<?php echo base_url().index_page()."new_designer/home/help";?>">
										<i class="icon-info"></i>
										Help </a>
									</li>
								<!--	<li>
										<a href="<?php echo base_url().index_page()."new_designer/home/job_list";?>">
										<i class="icon-info"></i>
										Job List </a>
									</li>-->
								</ul>
							</div>
							<!-- END MENU -->
						</div>
						<!-- END PORTLET MAIN -->
						<!-- PORTLET MAIN -->
						<!-- END PORTLET MAIN -->
					</div>
					<!-- END BEGIN PROFILE SIDEBAR -->
					<!-- BEGIN PROFILE CONTENT -->
					<div class="profile-content">
						<div class="row">
							<div class="col-md-12">
								<!-- BEGIN PORTLET -->
								<div class="portlet light ">
									<div class="portlet-title">
										<div class="caption caption-md">
											<span class="caption-subject font-blue-madison bold">Performance</span>
										</div>
										<div class="caption col-md-offset-3">
											<span style= "color:black;font-size: 13px;">
											<?php if(isset($from) && isset($to)){
												  $d_from = strtotime($from); $d_to = strtotime($to); 
													echo date('d M Y', $d_from).' to '.date('d M Y', $d_to); 
												}else{ 
													$d_today = strtotime($today);
													echo date('d M Y', $d_today); } ?>
											</span>
										</div>
										<div class="actions">
											<form role="form" method="post">
												<?php if(isset($num_days)) { ?>
												<a class="btn btn-circle btn-default btn-xs <?php if($num_days == '')echo 'active'; ?>" href="<?php echo base_url().index_page().'new_designer/home/my_profile';?>">
												Today
												</a>
												<a class="btn btn-circle btn-default btn-xs <?php if($num_days == '7')echo 'active'; ?>" href="<?php echo base_url().index_page().'new_designer/home/my_profile/7';?>">
												7 Days
												</a>
												<a class="btn btn-circle btn-default btn-xs <?php if($num_days == 'curr_month')echo 'active'; ?>" href="<?php echo base_url().index_page().'new_designer/home/my_profile/curr_month';?>">
												Current Month
												</a>
												<a class="btn btn-circle btn-default btn-xs <?php if($num_days == 'prev_month')echo 'active'; ?>" href="<?php echo base_url().index_page().'new_designer/home/my_profile/prev_month';?>">
												Last Month
												</a><?php } ?>
											</form>
										</div>
									</div>
									<div class="portlet-body">
										<div class="table-scrollable table-scrollable-borderless">
						
						<table class="table table-striped table-bordered table-hover" id="sample_6">
							<thead>
								<tr>
									<th>Name</th>
									<th>Code</th>
									<th>P</th>
									<th>M</th>
									<th>N</th>
									<th>T</th>
									<th>W</th>
									<th>New Ads</th>
									<th>Revision</th>
								<!--	<th>SJ</th>  --> 
								<!--	<th>NJ</th> -->
								<!--<th>Error</th>-->
								</tr>
							</thead>
							<tbody name="testTable" id="testTable">
<?php
$tot_job_count = 0; $tot_total_QA = 0; $tot_pub_nj = 0; $tot_dp_sft = 0; $tot_cat_a = 0; $tot_cat_b = 0;$tot_cat_c = 0;
$tot_cat_d = 0; $tot_cat_e = 0; $tot_cat_f = 0; $tot_cat_g = 0; $tot_cat_rev = 0; $tot_cat_sold = 0;$total_error = 0; $total_err = 0;
	
	$dp_sft = 0; $pub_nj = 0; $job_count = 0; $sq_inches = 0; $total_QA = 0;
	$p_count = 0; $m_count = 0; $n_count = 0; $t_count = 0; $w_count = 0; $cat_rev = 0; $cat_sold = 0;$error=0; $error_rev=0;
	$error_rev_count = 0; $new_reason = 0; $rev_reason = 0;
	
	foreach($cat_result as $c_row){
	    if($c_row['category'] == 'P'){ $p_count = $c_row['ad_count']; }
	    if($c_row['category'] == 'M'){ $m_count = $c_row['ad_count']; }
	    if($c_row['category'] == 'N'){ $n_count = $c_row['ad_count']; }
	    if($c_row['category'] == 'T'){ $t_count = $c_row['ad_count']; }
	    if($c_row['category'] == 'W'){ $w_count = $c_row['ad_count']; }
	}
			
					if($rev_sold)
					{	
						//$hd_rev_neg = array(4,7);
						foreach($rev_sold as $row3)
						{
							//if(!in_array($row3['help_desk'], $hd_rev_neg)){
								$rev_ads_reason = $this->db->query("SELECT `reason_id` FROM `rev_order_reason` WHERE `rev_id` = '".$row3['id']."' AND `designer` = '".$row3['designer']."' AND `reason_id` = '3' ")->result_array();
								//echo  'rev_reason:'.count($rev_ads_reason).'<br/>';
								$rev_reason = $rev_reason + count($rev_ads_reason);
								
								$row3['category'] = strtoupper($row3['category']);
								$cat_wt = $this->db->get_where('print',array('name' => $row3['category']))->result_array();
								if($cat_wt){
								$pub_nj = $pub_nj + $cat_wt[0]['wt'];
								
								$dp_sft = $dp_sft + $cat_wt[0]['wt'];}
								if($row3['category'] == 'REVISION')
								{
									$cat_rev++;
								}
								if($row3['category'] == 'SOLD')
								{
									$cat_sold++;
								}
						}
					
					} 
					
	?>  
									<tr class="odd gradeX">
										<td><?php echo $designer['name']; ?></td><!--Name-->
										<td><?php echo $designer['username']; ?></td><!--Code-->
										<td><?php echo $p_count; ?></td><!--P -->
										<td><?php echo $m_count; ?></td><!--M-->
										<td><?php echo $n_count; ?></td><!--N-->
										<td><?php echo $t_count; ?></td><!--T-->
										<td><?php echo $w_count; ?></td><!--W-->
										<td><?php echo $job_count; ?></td><!--Ads-->
										<td><?php echo $cat_rev; ?></td><!--RJ-->
									<!--	<td><?php echo $cat_sold; ?></td>--><!--SJ-->
									<!--	<td><?php echo $pub_nj; ?></td> NJ-->
									<!--<td><?php echo round($total_err,2); ?></td>--><!--Error-->
									</tr>

							</tbody>
						</table>
					
										</div>
									</div>
								</div>
								<!-- END PORTLET -->
							</div>
						</div>
					</div>
					<!-- END PROFILE CONTENT -->
				</div>
			</div>
			<!-- END PAGE CONTENT INNER -->
		</div>
	</div>
	<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->
<!-- BEGIN PRE-FOOTER -->
<!-- END PRE-FOOTER -->
<!-- BEGIN FOOTER -->
<?php
       $this->load->view("new_designer/foot"); 
?>


