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


					<div class="portlet light">
					   <div class="portlet-title">
							<div class="row static-info">
								<div class="col-md-6 col-xs-12 margin-top-15 font-lg font-grey-gallery">
									<div class="font-grey-gallery">Frontline Report : <?php if(isset($from) && isset($to)){ $from1 = strtotime($from); $to1 = strtotime($to); echo date('M d, Y', $from1)." to ".date('M d, Y', $to1) ;} ?> <br>
									</div>
								</div>
								
								<div class="col-md-6 col-xs-12 margin-top-10 text-right">	
									<div class="btn-group left-dropdown">
										<form method="get">
											<div class="btn-group left-dropdown">							
												<button class="btn bg-grey btn-xs dropdown-toggle" margin-right-10" data-toggle="dropdown" aria-expanded="true"	id="filter">
													<i class="fa fa-filter cursor-pointer"></i> Filter
												</button>
												<div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu" id="show_filter">
													<div class=" date-picker input-daterange" data-date="10/11/2012" data-date-format="yyyy-mm-dd">
														<input type="text" class="form-control border-radius-left" name="id" value="<?php echo $id ;?>" style="display:none;">
														<input type="text" class="form-control border-radius-left" name="from" placeholder="From Date">
														<input type="text" class="form-control border-radius-right margin-top-10" name="to" placeholder="To Date">
														<div class="text-right margin-top-10">
															<button type="submit" class="btn bg-red-flamingo btn-sm"> Submit</button>
														</div>
													</div>
												</div>
											</div>
										</form>
									</div>
									<button class="btn bg-grey btn-xs" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
									<span class="cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
							</div>
						  </div>
						</div>
						<div class="portlet-body">
						<?php foreach($help_desk as $hd_row){ ?>
							<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="sample_6">
								<thead>
									<tr>
										<th><?php echo $hd_row['name']; ?></th>
										<th>Total</th>
										<th>0-20mins</th>
										<th>21-40mins</th>
										<th>41-60mins</th>
										<th>61-90mins</th>
										<th>91-120mins</th>
										<th>above 120mins</th>
									</tr>
								</thead>
								<tbody>
<?php										
		$tot_r_design9 = 0;
		$Dr_row1 = 0; $Dr_row2 = 0 ; $Dr_row3 = 0 ; $Dr_row4 = 0 ; $Dr_row5 = 0 ; $Dr_row6 = 0 ; $Dr_rest = 0;
		
		$Dr_row1_percentage = 0; $Dr_row2_percentage = 0; $Dr_row3_percentage = 0; $Dr_row4_percentage = 0; $Dr_row5_percentage = 0; $Dr_row6_percentage = 0; $Dr_rest_percentage = 0;
		foreach($rev_sold as $row)
		{
			if($row['help_desk'] == $hd_row['id'])
			{
				$tot_r_design9++;
				if($row['time_taken']<='1200')
				{
					$Dr_row1++;
				}elseif($row['time_taken']>'1200' && $row['time_taken']<='2400')
				{
					$Dr_row2++;
				}elseif($row['time_taken']>'2400' && $row['time_taken']<='3600')
				{
					$Dr_row3++;
				}elseif($row['time_taken']>'3600' && $row['time_taken']<='5400')
				{
					$Dr_row4++;
				}elseif($row['time_taken']>'5400' && $row['time_taken']<='7200')
				{
					$Dr_row5++;
				}else{
					$Dr_rest++;
				}
			}
		}
		
		if($tot_r_design9!='0')
		{
			$Dr_row1_percentage = ($Dr_row1 / $tot_r_design9)*100 ;
			$Dr_row2_percentage = ($Dr_row2 / $tot_r_design9)*100 ;
			$Dr_row3_percentage = ($Dr_row3 / $tot_r_design9)*100 ;
			$Dr_row4_percentage = ($Dr_row4 / $tot_r_design9)*100 ;
			$Dr_row5_percentage = ($Dr_row5 / $tot_r_design9)*100 ;
			$Dr_rest_percentage = ($Dr_rest / $tot_r_design9)*100 ;
		}
?>		
						
									<tr class="odd gradeX">
										<td><?php echo "No"; ?></td>
										<td><?php echo $tot_r_design9; ?></td>
										<td><?php echo $Dr_row1; ?></td>
										<td><?php echo $Dr_row2; ?></td>
										<td><?php echo $Dr_row3; ?></td>
										<td><?php echo $Dr_row4; ?></td>
										<td><?php echo $Dr_row5; ?></td>
										<td><?php echo $Dr_rest; ?></td>
									</tr>
									<tr class="odd gradeX">
										<td><?php echo "Percentage"; ?></td>
										<td><?php echo ''; ?></td>
										<td><?php echo round($Dr_row1_percentage,2).'%'; ?></td>
										<td><?php echo round($Dr_row2_percentage,2).'%'; ?></td>
										<td><?php echo round($Dr_row3_percentage,2).'%'; ?></td>
										<td><?php echo round($Dr_row4_percentage,2).'%'; ?></td>
										<td><?php echo round($Dr_row5_percentage,2).'%'; ?></td>
										<td><?php echo round($Dr_rest_percentage,2).'%'; ?></td>
									</tr>
								</tbody>
							</table>
						<?php } ?>
						</div>
                    </div>
               
                       
<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable.php'); ?>