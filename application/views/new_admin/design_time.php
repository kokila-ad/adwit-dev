<?php $this->load->view('new_admin/header.php'); ?>



<script>

$(document).ready(function(){	    

	$(".dropdown-checkboxes").hide();	

	$('.date-picker').click(function() {

		$(".cursor-pointer").addClass(" filter ");

	});	

	$('#filter').click(function() {

		$(".dropdown-checkboxes").toggle();

	});	

});

</script>





<!-- BEGIN PAGE CONTAINER -->



<div class="portlet light">

	<div class="portlet-title">

	<div class="row">

		<div class="col-md-7 col-xs-12 margin-bottom-10 font-lg font-grey-gallery">

			<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report'; ?>" class="font-grey-gallery">Reports</a> - <a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report/'.$type; ?>" class="font-grey-gallery"><?php echo $type;?></a> - 

			<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report/'.$type.'/'.$user; ?>" class="font-grey-gallery"><?php echo $user;?></a>

			<?php if($designer_id != 'all') { echo '- '.$designers[0]['name'] ; }?>-

			<?php if(isset($from) && isset($to)){echo date('M d, Y ',strtotime($from))." to ".date('M d, Y',strtotime($to));}elseif(isset($today)){echo date('M d, Y',strtotime($today));} ?>

		</div>

		<div>

			<?php if(null != $this->session->flashdata('message')){ ?>						

			<div class="alert alert-success padding-5 small margin-bottom-5 text-right"><?php echo '<span style="text-align: left;margin:0;">'.$this->session->flashdata('message').'</span>'; ?></div>

		<?php } ?>

		</div>

		<div class="col-md-3 col-xs-9 margin-bottom-10 text-right padding-right-0">	

			<?php if($designer_id != 'all') { ?>

				<form method="get" >

					<div class="btn-group left-dropdown">							

						<button class="btn bg-grey btn-xs dropdown-toggle" margin-right-10" data-toggle="dropdown" aria-expanded="true"	id="filter">

							<i class="fa fa-filter cursor-pointer"></i> Filter

						</button>

						<div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu">

						<div class="portlet light">

						<div class="portlet-body">

						<div class="row margin-top-10">

							<div class=" date-picker input-daterange" data-date="10/11/2012" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">

								<input type="text" class="form-control border-radius-left" name="designer_id" value="<?php echo $designer_id ;?>" style="display:none;">

								<input type="text" class="form-control border-radius-left" name="from" placeholder="From Date" required>

								<input type="text" class="form-control border-radius-right margin-top-10" name="to" placeholder="To Date" required>

							</div>	

                            

							<div class="text-right margin-bottom-10">

								<button type="submit" class="btn bg-red-flamingo btn-sm"> Submit</button>

							</div>

						</div>

						</div>

						</div>

						</div>		

					</div>

				</form>

				<?php } ?>	

			

					

		

			</div>

			<div class="col-md-1 col-xs-5 margin-bottom-10 text-right">	

				<a href="javascript:;" class="btn btn-primary btn-xs" onclick="window.location = '<?php echo base_url().index_page().'new_admin/home/error_report?designer_id='.$designer_id.'&from='.$from.'&to='.$to;?>'">Others(%)</a>

			</div>

			<div class="col-md-1 col-xs-4 margin-bottom-10 text-right">	

					<button class="btn bg-grey btn-xs" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>

			</div>

		

	</div>



	</div>

	<div class="portlet-body " >

		<?php if($designer_id == 'all') { ?>

		<table class="table table-bordered table-hover" id="sample_6">

		<?php } else { ?>

		<div>

			<table class="table table-bordered table-hover" id="sample_6"><?php } ?> 

				<thead>					

					<tr>

						<th>Name</th>

						<th>Code</th>
						
						<th>P</th>

						<th>M</th>

						<th>N</th>

						<th>T</th>

						<th>W</th>
						
					</tr>

				</thead>

				<tbody> 

				<?php 
					$tot_job_count = 0; $tot_total_QA = 0; $tot_pub_nj = 0; $tot_cat_rev = 0;

				foreach($designers as $row){	

					$pub_nj = 0; $job_count = 0; $total_QA = 0; $cat_a = 0; $cat_b = 0; $cat_c = 0; $cat_d = 0; $cat_e = 0; $cat_f = 0; $cat_g = 0; $cat_rev = 0; $cat_sold = 0;
	
					$des_id = $row['id'];
					if(isset($from) && isset($to)){
						//$cat_result = 	$this->db->query("SELECT `id`, `order_no`, `category` FROM `cat_result` WHERE  `designer`='$des_id' AND `ddate` BETWEEN '$from' AND '$to' ;")->result_array();
						$query = "SELECT designer_ads_time.order_id, designer_ads_time.time_taken, cat_result.category 
															FROM `designer_ads_time` 
															LEFT JOIN `cat_result` ON designer_ads_time.order_id = cat_result.order_no
															WHERE designer_ads_time.designer_id = '$des_id' AND designer_ads_time.start_time BETWEEN '$from 00:00:00' AND '$to 23:59:59' ;";
						$design_time = 	$this->db->query($query)->result_array();
						
					}else{
						//$cat_result = $this->db->get_where('cat_result',array('designer' => $des_id, 'ddate' => $today))->result_array();
						$query = "SELECT designer_ads_time.order_id, designer_ads_time.time_taken, cat_result.category 
															FROM `designer_ads_time` 
															LEFT JOIN `cat_result` ON designer_ads_time.order_id = cat_result.order_no 
															WHERE designer_ads_time.designer_id = '$des_id' AND designer_ads_time.start_time = '$today' ;";
						$design_time = 	$this->db->query($query)->result_array();
					}
					//echo $query;
					$tot_cat_a = 0; $tot_cat_b = 0; $tot_cat_c = 0; $tot_cat_d = 0; $tot_cat_e = 0; $tot_cat_f = 0; $tot_cat_g = 0;
					foreach($design_time as $row2){
						//$design_time = 
						$cat_value = $row2['category'];
						$cat_value = strtoupper($cat_value);
						if($cat_value == 'P'){
							$tot_cat_a++;
							$cat_a = $cat_a + $row2['time_taken'];

						}elseif($cat_value == 'M'){
							$tot_cat_b++;
							$cat_b = $cat_b + $row2['time_taken'];

						}elseif($cat_value == 'N'){
							$tot_cat_c++;
							$cat_c = $cat_c + $row2['time_taken'];

						}elseif($cat_value == 'T'){
							$tot_cat_d++;
							$cat_d = $cat_d + $row2['time_taken'];

						}elseif($cat_value == 'W'){
							$tot_cat_e++;
							$cat_e = $cat_e + $row2['time_taken'];

						}
					}	
					?>
					
					<tr>

						<td><?php echo $row['name']; ?></td><!--Name-->

						<td><?php echo $row['username']; ?></td><!--Code-->
						
						<td>
						<a href="<?php echo base_url().index_page()."new_admin/home/design_time_details/".$des_id."/A/".$from."/".$to; ?>" target="_blank">
						<!--<a href="<?php echo base_url().index_page()."new_admin/home/design_time_details/".$des_id."/A?from=".$from."&to=".$to; ?>" target="_blank">-->
							<?php 
									if($tot_cat_a != 0) $cat_a = $cat_a / $tot_cat_a;
									$hr_a = floor($cat_a / 60);
									$min_a = floor($cat_a - ($hr_a * 60));
									echo $hr_a."hrs ".$min_a."mins"; 
							?>
						</a>
						</td><!--A -->

						<td>
						<a href="<?php echo base_url().index_page()."new_admin/home/design_time_details/".$des_id."/B/".$from."/".$to; ?>" target="_blank">
							<?php 
									if($tot_cat_b != 0) $cat_b = $cat_b / $tot_cat_b;
									$hr_b = floor($cat_b / 60);
									$min_b = floor($cat_b - ($hr_b * 60));
									echo $hr_b."hrs ".$min_b."mins"; 
							?>
						</a>
						</td><!--B-->

						<td>
						<a href="<?php echo base_url().index_page()."new_admin/home/design_time_details/".$des_id."/C/".$from."/".$to; ?>" target="_blank">
							<?php 
									if($tot_cat_c != 0) $cat_c = $cat_c / $tot_cat_c;
									$hr_c = floor($cat_c / 60);
									$min_c = floor($cat_c - ($hr_c * 60));
									echo $hr_c."hrs ".$min_c."mins"; 
							?>
						</a>
						</td><!--C-->

						<td>
						<a href="<?php echo base_url().index_page()."new_admin/home/design_time_details/".$des_id."/D/".$from."/".$to; ?>" target="_blank">
							<?php 
									if($tot_cat_d != 0) $cat_d = $cat_d / $tot_cat_d;
									$hr_d = floor($cat_d / 60);
									$min_d = floor($cat_d - ($hr_d * 60));
									echo $hr_d."hrs ".$min_d."mins";   
							?>
						</a>
						</td><!--D-->

						<td>
						<a href="<?php echo base_url().index_page()."new_admin/home/design_time_details/".$des_id."/E/".$from."/".$to; ?>" target="_blank">
							<?php 
									if($tot_cat_e != 0) $cat_e = $cat_e / $tot_cat_e;
									$hr_e = floor($cat_e / 60);
									$min_e = floor($cat_e - ($hr_e * 60));
									echo $hr_e."hrs ".$min_e."mins";  
							?>
						</a>
						</td><!--E-->


					</tr>
				<?php } ?>

				</tbody>

			</table>

		</div>

	</div>



</div>	

</div>

</div>

</div>

</div>



<?php $this->load->view('new_admin/footer.php'); ?>

<?php $this->load->view('new_admin/datatable.php'); ?>

