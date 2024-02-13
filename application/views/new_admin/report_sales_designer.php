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

<?php $DB2 = $this->db ; //$DB2 = $this->load->database('otherdb', TRUE); ?>

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
						
						<th>Level</th>
						
						<th>P</th>

						<th>M</th>

						<th>N</th>

						<th>T</th>

						<th>W</th>
						
						<th>G</th>
						
						<th>New Ads</th>

						<th>Revision</th>
						
						<th>Corrections</th>
						
						<th>Changes</th>

						<th>Final NJ</th>

					<!--<th>Error(%)</th>--> 

					</tr>

				</thead>

				<tbody> 

		<?php 

				$tot_job_count = 0; $tot_total_QA = 0; $tot_pub_nj = 0; $tot_cat_a = 0; $tot_cat_b = 0;$tot_cat_c = 0; $tot_cat_d = 0; $tot_cat_e = 0; $tot_cat_f = 0; $tot_cat_g = 0; $tot_cat_rev = 0;
					
				foreach($designers as $row)
				{	

					$pub_nj = 0; $job_count = 0; $total_QA = 0; $cat_a = 0; $cat_b = 0; $cat_c = 0; $cat_d = 0; $cat_e = 0; $cat_f = 0; $cat_g = 0; $cat_rev = 0; $cat_sold = 0;
	
					$des_id = $row['id'];
					if(isset($from) && isset($to))
					{
						$cat_result = 	$DB2->query("SELECT `id`,`category`,`shift_factor`,`order_no`,`slug`,`width`,`height` FROM `cat_result` WHERE  `designer`='$des_id' AND `ddate` BETWEEN '$from 00:00:00' AND '$to 23:59:59' ;")->result_array();
						$rev_sold = $DB2->query("SELECT `id`,`designer`,`category` FROM `rev_sold_jobs` WHERE  `designer`='$des_id' AND `date` BETWEEN '$from 00:00:00' AND '$to 23:59:59' ;")->result_array();
					}else{
						$cat_result = $DB2->get_where('cat_result',array('designer' => $des_id, 'ddate' => $today))->result_array();
						$rev_sold = $DB2->query("SELECT `id`,`designer`,`category` FROM `rev_sold_jobs` WHERE  `designer`='$des_id' AND `date`='$today' ;")->result_array();
					}
					foreach($cat_result as $row2)
					{
						$cat_value = $row2['category'];
						$cat_value = strtoupper($cat_value);
						if($cat_value == 'P'){

							$cat_a++;

						}elseif($cat_value == 'M'){

							$cat_b++;

						}elseif($cat_value == 'N'){

							$cat_c++;

						}elseif($cat_value == 'T'){

							$cat_d++;

						}elseif($cat_value == 'W'){

							$cat_e++;

						}elseif($cat_value == 'G'){

							$cat_g++;

						}
						
						$category = $DB2->get_where('print',array('name' => $row2['category']))->result_array();
						$pub_nj = $pub_nj + $category[0]['wt'];
						$job_count++;
					}	
					if($rev_sold)
					{	
						foreach($rev_sold as $row3)
						{
							$row3['category'] = strtoupper($row3['category']);
							$cat_wt = $DB2->get_where('print',array('name' => $row3['category']))->result_array();
							if($cat_wt){ 
								$pub_nj = $pub_nj + $cat_wt[0]['wt'];
							}
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
					$reason_count_correct = $DB2->query("SELECT * FROM `rev_order_reason` WHERE `reason_id` = '3' AND `designer` = '".$row['id']."' AND (`timestamp` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ")->result_array();
					$reason_count_changes = $DB2->query("SELECT * FROM `rev_order_reason` WHERE `reason_id` = '5' AND `designer` = '".$row['id']."' AND (`timestamp` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ")->result_array();
					
					$designer_level = $DB2->query("SELECT `name` FROM `designer_level` WHERE `id` = '".$row['level']."'")->result_array();
					
					?>

					<tr>

						<td><?php echo $row['name']; ?></td><!--Name-->

						<td><?php echo $row['username']; ?></td><!--Code-->
						
						<td><?php if($row['level']!=0){echo $designer_level[0]['name'];}else {echo '';}?></td><!---Designer Level--->
						
						<td><?php echo $cat_a; ?></td><!--P -->

						<td><?php echo $cat_b; ?></td><!--M-->

						<td><?php echo $cat_c; ?></td><!--N-->

						<td><?php echo $cat_d; ?></td><!--T-->

						<td><?php echo $cat_e; ?></td><!--W-->

                        <td><?php echo $cat_g; ?></td><!--G-->
                        
						<td>
						<a href="<?php echo base_url().index_page().'new_admin/home/designer_report?designer_id='.$row['id'].'&from='.$from.'&to='.$to;?>">
						<?php echo $job_count; ?>
						</a>
						</td><!--Ads-->

						<td>
						<a href="<?php echo base_url().index_page().'new_admin/home/designer_report?designer_id='.$row['id'].'&from='.$from.'&to='.$to;?>">
						<?php echo $cat_rev; ?>
						</a>
						</td><!--RJ-->
						
						<td><?php echo count($reason_count_correct);?></td> <!---Corrections---->
						
						<td><?php echo count($reason_count_changes);?></td> <!----Changes----->
						
						<td><?php echo round($pub_nj,2); ?></td><!-- Final NJ-->


					</tr>
					<?php 	$tot_cat_a = $tot_cat_a + $cat_a;

							$tot_cat_b = $tot_cat_b + $cat_b;

							$tot_cat_c = $tot_cat_c + $cat_c;

							$tot_cat_d = $tot_cat_d + $cat_d;

							$tot_cat_e = $tot_cat_e + $cat_e;
							
							$tot_cat_g = $tot_cat_g + $cat_g;

							$tot_job_count = $tot_job_count + $job_count;

							$tot_cat_rev = $tot_cat_rev + $cat_rev;
							
							$tot_pub_nj = $tot_pub_nj + $pub_nj;
				} ?>

				</tbody>

				<?php if($designer_id == 'all') { ?>

				<tfoot>
				<tr> 

					<th colspan="3">Total</th>

					<th><?php echo $tot_cat_a ;?></th>

					<th><?php echo $tot_cat_b ;?></th>

					<th><?php echo $tot_cat_c ;?></th>

					<th><?php echo $tot_cat_d ;?></th>

					<th><?php echo $tot_cat_e ;?></th>
					
					<th><?php echo $tot_cat_g ;?></th>

					<th><?php echo $tot_job_count ;?></th>

					<th><?php echo $tot_cat_rev ;?></th>
					
					<th> </th>
					
					<th> </th>

					<th><?php echo $tot_pub_nj ;?></th>

				</tr>

				</tfoot>

			<?php } ?>
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

