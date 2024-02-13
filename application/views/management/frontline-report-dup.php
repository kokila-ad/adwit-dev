<?php $this->load->view("management/head"); ?>

<!--<script type="text/javascript">	
	$(document).ready(function($) { 
   		$( "#from_date" ).datepicker({ minDate: "-14M", maxDate: 0, dateFormat: 'yy-mm-dd' });	
		$( "#to_date" ).datepicker({ minDate: "-14M", maxDate: 0, dateFormat: 'yy-mm-dd'});			
	});
</script>-->
	
<div class="page-container">
	<div class="page-content">
		<div class="container">
		
			<div class="row margin-top-15">
				<div class="col-sm-12">
					<div class="portlet light">
					   <div class="portlet-title">
							<div class="row static-info">
							
								<div class="col-md-10 value margin-top-10">
								Frontline <?php echo ucfirst($form); ?> Report : <?php if(isset($from) && isset($to)){echo $from." to ".$to;}else{echo $today;} ?>  <br>
									<form method="post">
									<div class="row">
										<div class="col-md-4">
											<div class="input-group input-large date-picker input-daterange" data-date="2012-10-11" data-date-format="yyyy-mm-dd">
												<input type="text"  name="from_date" class="form-control"  id="from_date" placeholder="YYYY-MM-DD">
												<span class="input-group-addon">to </span>
												<input type="text" name="to_date" class="form-control"  id="to_date" placeholder="YYYY-MM-DD" >
											</div>
										</div>
										<div class="col-md-2">
											<button type="submit" name="submit" class="btn btn-primary btn-md">Submit</button>
										</div>
									</div>
									</form>
								</div>
								<div class="col-md-2 text-right">
								<ul class="nav navbar-nav navbar-right margin-right-10">
										<li class="dropdown">
											<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Select Type &nbsp;<i class="fa fa-angle-down"></i>
											</a>
											<ul class="dropdown-menu">
											<?php
												$types = $this->db->get('frontline_timer')->result_array();
												foreach($types as $type)
												{
													echo '<li><a href="'.base_url().index_page().'management/home/frontline/'.$type['cat_name'].'"><option value="'.$type['cat_name'].'" '.($form==$type['cat_name'] ? 'selected="selected"' : '').'>'.$type['cat_name'].'</option></a></li>';	
												}
												?>
												<!--<li><a href="">Pickup</a></li>
												<li><a href="">Revision</a></li>-->
											</ul>
										</li>
									</ul>
								</div>
								
							</div>
						</div>
					  <div class="portlet-body">
					  
		<?php foreach($help_desk as $hd_row){ ?>				
  		<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" >
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
                        </div>
                        </div>
  </div>
  </div>
  </div>

                       
<?php $this->load->view("management/foot"); ?>