<?php
       $this->load->view("admin/header");
?>
        <link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/DT_bootstrap.css" rel="stylesheet" media="screen">
        <script src="theme001/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>

<link rel="stylesheet" href="jq-ui/themes/base/jquery.ui.all.css" />
<script src="jq-ui/ui/jquery.ui.core.js"></script>
<script src="jq-ui/ui/jquery.ui.datepicker.js"></script>

<script type="text/javascript">
	
	$(document).ready(function($) {    

   		$( "#from_date" ).datepicker({ minDate: "-6M", maxDate: 0, dateFormat: 'yy-mm-dd' });
		
		$( "#to_date" ).datepicker({ minDate: "-6M", maxDate: 0, dateFormat: 'yy-mm-dd'});
		
		
		
	});
	
</script>
<script type="text/javascript">
	$(document).ready(function(e) {
        $('#category').change(function(e) {
            window.location = "<?php echo base_url().index_page().'admin/home/frontline/';?>" + $('#category').val() ;
        });
    });
</script>		
		
  <div id="Middle-Div">
  <div style="width: 90%; margin:0 auto; height: 30px;">
  <div style="float: right; "> 
        	Select Type&nbsp;
        	<select id="category" name="category">
            <option value="">Select</option>
        	<?php
			$types = $this->db->get('frontline_timer')->result_array();
				foreach($types as $type)
				{
					echo '<option value="'.$type['cat_name'].'" '.($form==$type['cat_name'] ? 'selected="selected"' : '').'>'.$type['cat_name'].'</option>';	
				}
			?>
            </select>
   </div>
   <div  style="float: left; ">
							<form method="post">
							From <input type="text" name="from_date" id="from_date" placeholder="YY-MM-DD"/> To<input type="text" name="to_date" id="to_date" placeholder="YY-MM-DD"/>
							<input type="submit" value="Submit" />
							</form>
							</div>
                            </div>
		
   <div class="row-fluid" style="width:96%; margin: 0 auto;">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
							
                                <div class="muted pull-left">Frontline <?php echo ucfirst($form); ?> Report : <?php if(isset($from) && isset($to)){echo $from." to ".$to;}else{echo $today;} ?> 
								</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
	<!-- Design9 -->							
  	<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" >
										<thead>
											<tr>
												<th>Design9</th>
												<th>Total</th>
												<th>0-60mins</th>
												<th>61-120mins</th>
												<th>121-180mins</th>
												<th>181-240mins</th>
												<th>above 240mins</th>
											</tr>
										</thead>
										<tbody>
										
<?php										
		$tot_r_design9 = 0;
		$Dr_row1 = 0; $Dr_row2 = 0 ; $Dr_row3 = 0 ; $Dr_row4 = 0 ; $Dr_row5 = 0 ; $Dr_row6 = 0 ; $Dr_rest = 0;
		
		$Dr_row1_percentage = 0; $Dr_row2_percentage = 0; $Dr_row3_percentage = 0; $Dr_row4_percentage = 0; $Dr_row5_percentage = 0; $Dr_row6_percentage = 0; $Dr_rest_percentage = 0;
		foreach($rev_sold as $row)
		{
			if($row['help_desk']=='1')
			{
				$tot_r_design9++;
				if($row['time_taken']<='3600')
				{
					$Dr_row1++;
				}elseif($row['time_taken']>'3600' && $row['time_taken']<='7200')
				{
					$Dr_row2++;
				}elseif($row['time_taken']>'7200' && $row['time_taken']<='10800')
				{
					$Dr_row3++;
				}elseif($row['time_taken']>'10800' && $row['time_taken']<='14400')
				{
					$Dr_row4++;
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
												
												<td><?php echo $Dr_rest; ?></td>
												
											</tr>
											<tr class="odd gradeX">
												<td><?php echo "Percentage"; ?></td>
												<td><?php echo ''; ?></td>
												<td><?php echo round($Dr_row1_percentage,2).'%'; ?></td>
												<td><?php echo round($Dr_row2_percentage,2).'%'; ?></td>
												<td><?php echo round($Dr_row3_percentage,2).'%'; ?></td>
												<td><?php echo round($Dr_row4_percentage,2).'%'; ?></td>
												<td><?php echo round($Dr_rest_percentage,2).'%'; ?></td>
												
											</tr>
										</tbody>
									</table>
	<!-- Metro -->								
	<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" >
										<thead>
											<tr>
												<th>Metro</th>
												<th>Total</th>
												<th>0-60mins</th>
												<th>61-120mins</th>
												<th>121-180mins</th>
												<th>181-240mins</th>
												<th>above 240mins</th>
											</tr>
										</thead>
										<tbody>
<?php										
		$tot_s_design9 = 0;
		$Ds_row1 = 0; $Ds_row2 = 0 ; $Ds_row3 = 0 ; $Ds_row4 = 0 ; $Ds_row5 = 0 ; $Ds_row6 = 0 ; $Ds_rest = 0;
		
		$Ds_row1_percentage = 0; $Ds_row2_percentage = 0; $Ds_row3_percentage = 0; $Ds_row4_percentage = 0; $Ds_row5_percentage = 0; $Ds_row6_percentage = 0; $Ds_rest_percentage = 0;
		foreach($rev_sold as $row)
		{
			if($row['help_desk']=='2')
			{
				$tot_s_design9++;
				if($row['time_taken']<='3600')
				{
					$Ds_row1++;
				}elseif($row['time_taken']>'3600' && $row['time_taken']<='7200')
				{
					$Ds_row2++;
				}elseif($row['time_taken']>'7200' && $row['time_taken']<='10800')
				{
					$Ds_row3++;
				}elseif($row['time_taken']>'10800' && $row['time_taken']<='14400')
				{
					$Ds_row4++;
				}else{
					$Ds_rest++;
				}
			}
		}
		
		if($tot_s_design9!='0')
		{
			$Ds_row1_percentage = ($Ds_row1 / $tot_s_design9)*100 ;
			$Ds_row2_percentage = ($Ds_row2 / $tot_s_design9)*100 ;
			$Ds_row3_percentage = ($Ds_row3 / $tot_s_design9)*100 ;
			$Ds_row4_percentage = ($Ds_row4 / $tot_s_design9)*100 ;
			
			$Ds_rest_percentage = ($Ds_rest / $tot_s_design9)*100 ;
		}
?>								
											<tr class="odd gradeX">
												<td><?php echo "No"; ?></td>
												<td><?php echo $tot_s_design9; ?></td>
												<td><?php echo $Ds_row1; ?></td>
												<td><?php echo $Ds_row2; ?></td>
												<td><?php echo $Ds_row3; ?></td>
												<td><?php echo $Ds_row4; ?></td>
												
												<td><?php echo $Ds_rest; ?></td>
												
											</tr>
											<tr class="odd gradeX">
												<td><?php echo "Percentage"; ?></td>
												<td><?php echo ''; ?></td>
												<td><?php echo round($Ds_row1_percentage,2).'%'; ?></td>
												<td><?php echo round($Ds_row2_percentage,2).'%'; ?></td>
												<td><?php echo round($Ds_row3_percentage,2).'%'; ?></td>
												<td><?php echo round($Ds_row4_percentage,2).'%'; ?></td>
												
												<td><?php echo round($Ds_rest_percentage,2).'%'; ?></td>
												
											</tr>
										</tbody>
										</table>
	<!-- SDR+ -->
	<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" >
										<thead>
											<tr>
												<th>SDR+</th>
												<th>Total</th>
												<th>0-60mins</th>
												<th>61-120mins</th>
												<th>121-180mins</th>
												<th>181-240mins</th>
												<th>above 240mins</th>
											</tr>
										</thead>
										<tbody>
<?php										
		$tot_n_design9 = 0;
		$Dn_row1 = 0; $Dn_row2 = 0 ; $Dn_row3 = 0 ; $Dn_row4 = 0 ; $Dn_row5 = 0 ; $Dn_row6 = 0 ; $Dn_rest = 0;
		
		$Dn_row1_percentage = 0; $Dn_row2_percentage = 0; $Dn_row3_percentage = 0; $Dn_row4_percentage = 0; $Dn_row5_percentage = 0; $Dn_row6_percentage = 0; $Dn_rest_percentage = 0;
		foreach($rev_sold as $row)
		{
			if($row['help_desk']=='0')
			{
				$tot_n_design9++;
				if($row['time_taken']<='3600')
				{
					$Dn_row1++;
				}elseif($row['time_taken']>'3600' && $row['time_taken']<='7200')
				{
					$Dn_row2++;
				}elseif($row['time_taken']>'7200' && $row['time_taken']<='10800')
				{
					$Dn_row3++;
				}elseif($row['time_taken']>'10800' && $row['time_taken']<='14400')
				{
					$Dn_row4++;
				}else{
					$Dn_rest++;
				}
			}
		}
		
		if($tot_n_design9!='0')
		{
			$Dn_row1_percentage = ($Dn_row1 / $tot_n_design9)*100 ;
			$Dn_row2_percentage = ($Dn_row2 / $tot_n_design9)*100 ;
			$Dn_row3_percentage = ($Dn_row3 / $tot_n_design9)*100 ;
			$Dn_row4_percentage = ($Dn_row4 / $tot_n_design9)*100 ;
			
			$Dn_rest_percentage = ($Dn_rest / $tot_n_design9)*100 ;
		}
?>								
											<tr class="odd gradeX">
												<td><?php echo "No"; ?></td>
												<td><?php echo $tot_n_design9; ?></td>
												<td><?php echo $Dn_row1; ?></td>
												<td><?php echo $Dn_row2; ?></td>
												<td><?php echo $Dn_row3; ?></td>
												<td><?php echo $Dn_row4; ?></td>
												
												<td><?php echo $Dn_rest; ?></td>
												
											</tr>
											<tr class="odd gradeX">
												<td><?php echo "Percentage"; ?></td>
												<td><?php echo ''; ?></td>
												<td><?php echo round($Dn_row1_percentage,2).'%'; ?></td>
												<td><?php echo round($Dn_row2_percentage,2).'%'; ?></td>
												<td><?php echo round($Dn_row3_percentage,2).'%'; ?></td>
												<td><?php echo round($Dn_row4_percentage,2).'%'; ?></td>
												
												<td><?php echo round($Dn_rest_percentage,2).'%'; ?></td>
												
											</tr>
										</tbody>
										</table>
	<!-- Xpanse -->
	<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" >
										<thead>
											<tr>
												<th>Xpanse</th>
												<th>Total</th>
												<th>0-60mins</th>
												<th>61-120mins</th>
												<th>121-180mins</th>
												<th>181-240mins</th>
												<th>above 240mins</th>
											</tr>
										</thead>
										<tbody>
<?php										
		$tot_p_design9 = 0;
		$Dp_row1 = 0; $Dp_row2 = 0 ; $Dp_row3 = 0 ; $Dp_row4 = 0 ; $Dp_row5 = 0 ; $Dp_row6 = 0 ; $Dp_rest = 0;
		
		$Dp_row1_percentage = 0; $Dp_row2_percentage = 0; $Dp_row3_percentage = 0; $Dp_row4_percentage = 0; $Dp_row5_percentage = 0; $Dp_row6_percentage = 0; $Dp_rest_percentage = 0;
		foreach($rev_sold as $row)
		{
			if($row['help_desk']=='4')
			{
				$tot_p_design9++;
				if($row['time_taken']<='3600')
				{
					$Dp_row1++;
				}elseif($row['time_taken']>'3600' && $row['time_taken']<='7200')
				{
					$Dp_row2++;
				}elseif($row['time_taken']>'7200' && $row['time_taken']<='10800')
				{
					$Dp_row3++;
				}elseif($row['time_taken']>'10800' && $row['time_taken']<='14400')
				{
					$Dp_row4++;
				}else{
					$Dp_rest++;
				}
			}
		}
		
		if($tot_p_design9!='0')
		{
			$Dp_row1_percentage = ($Dp_row1 / $tot_p_design9)*100 ;
			$Dp_row2_percentage = ($Dp_row2 / $tot_p_design9)*100 ;
			$Dp_row3_percentage = ($Dp_row3 / $tot_p_design9)*100 ;
			$Dp_row4_percentage = ($Dp_row4 / $tot_p_design9)*100 ;
			
			$Dp_rest_percentage = ($Dp_rest / $tot_p_design9)*100 ;
		}
?>								
											<tr class="odd gradeX">
												<td><?php echo "No"; ?></td>
												<td><?php echo $tot_p_design9; ?></td>
												<td><?php echo $Dp_row1; ?></td>
												<td><?php echo $Dp_row2; ?></td>
												<td><?php echo $Dp_row3; ?></td>
												<td><?php echo $Dp_row4; ?></td>
												
												<td><?php echo $Dp_rest; ?></td>
												
											</tr>
											<tr class="odd gradeX">
												<td><?php echo "Percentage"; ?></td>
												<td><?php echo ''; ?></td>
												<td><?php echo round($Dp_row1_percentage,2).'%'; ?></td>
												<td><?php echo round($Dp_row2_percentage,2).'%'; ?></td>
												<td><?php echo round($Dp_row3_percentage,2).'%'; ?></td>
												<td><?php echo round($Dp_row4_percentage,2).'%'; ?></td>
												
												<td><?php echo round($Dp_rest_percentage,2).'%'; ?></td>
												
											</tr>
										</tbody>
									</table>
	<!-- VIDN++ -->
	<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" >
										<thead>
											<tr>
												<th>VIDN+</th>
												<th>Total</th>
												<th>0-60mins</th>
												<th>61-120mins</th>
												<th>121-180mins</th>
												<th>181-240mins</th>
												<th>above 240mins</th>
											</tr>
										</thead>
										<tbody>
<?php										
		$tot_f_design9 = 0;
		$Df_row1 = 0; $Df_row2 = 0 ; $Df_row3 = 0 ; $Df_row4 = 0 ; $Df_row5 = 0 ; $Df_row6 = 0 ; $Df_rest = 0;
		
		$Df_row1_percentage = 0; $Df_row2_percentage = 0; $Df_row3_percentage = 0; $Df_row4_percentage = 0; $Df_row5_percentage = 0; $Df_row6_percentage = 0; $Df_rest_percentage = 0;
		foreach($rev_sold as $row)
		{
			if($row['help_desk']=='5')
			{
				$tot_f_design9++;
				if($row['time_taken']<='3600')
				{
					$Df_row1++;
				}elseif($row['time_taken']>'3600' && $row['time_taken']<='7200')
				{
					$Df_row2++;
				}elseif($row['time_taken']>'7200' && $row['time_taken']<='10800')
				{
					$Df_row3++;
				}elseif($row['time_taken']>'10800' && $row['time_taken']<='14400')
				{
					$Df_row4++;
				}else{
					$Df_rest++;
				}
			}
		}
		
		if($tot_f_design9!='0')
		{
			$Df_row1_percentage = ($Df_row1 / $tot_f_design9)*100 ;
			$Df_row2_percentage = ($Df_row2 / $tot_f_design9)*100 ;
			$Df_row3_percentage = ($Df_row3 / $tot_f_design9)*100 ;
			$Df_row4_percentage = ($Df_row4 / $tot_f_design9)*100 ;
			
			$Df_rest_percentage = ($Df_rest / $tot_f_design9)*100 ;
		}
?>								
											<tr class="odd gradeX">
												<td><?php echo "No"; ?></td>
												<td><?php echo $tot_f_design9; ?></td>
												<td><?php echo $Df_row1; ?></td>
												<td><?php echo $Df_row2; ?></td>
												<td><?php echo $Df_row3; ?></td>
												<td><?php echo $Df_row4; ?></td>
												
												<td><?php echo $Df_rest; ?></td>
												
											</tr>
											<tr class="odd gradeX">
												<td><?php echo "Percentage"; ?></td>
												<td><?php echo ''; ?></td>
												<td><?php echo round($Df_row1_percentage,2).'%'; ?></td>
												<td><?php echo round($Df_row2_percentage,2).'%'; ?></td>
												<td><?php echo round($Df_row3_percentage,2).'%'; ?></td>
												<td><?php echo round($Df_row4_percentage,2).'%'; ?></td>
												
												<td><?php echo round($Df_rest_percentage,2).'%'; ?></td>
												
											</tr>
										</tbody>

									</table>
	<!-- Training -->
	<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" >
										<thead>
											<tr>
												<th>Training</th>
												<th>Total</th>
												<th>0-60mins</th>
												<th>61-120mins</th>
												<th>121-180mins</th>
												<th>181-240mins</th>
												<th>above 240mins</th>
											</tr>
										</thead>
										<tbody>
										
<?php										
		$tot_t_training = 0;
		$Dt_row1 = 0; $Dt_row2 = 0 ; $Dt_row3 = 0 ; $Dt_row4 = 0 ; $Dt_row5 = 0 ; $Dt_row6 = 0 ; $Dt_rest = 0;
		$Dt_row1_percentage = 0; $Dt_row2_percentage = 0; $Dt_row3_percentage = 0; $Dt_row4_percentage = 0; $Dt_row5_percentage = 0; $Dt_row6_percentage = 0; $Dt_rest_percentage = 0;
		
		foreach($rev_sold as $row)
		{
			if($row['help_desk']=='6')
			{
				$tot_t_training++;
				if($row['time_taken']<='3600')
				{
					$Dt_row1++;
				}elseif($row['time_taken']>'3600' && $row['time_taken']<='7200')
				{
					$Dt_row2++;
				}elseif($row['time_taken']>'7200' && $row['time_taken']<='10800')
				{
					$Dt_row3++;
				}elseif($row['time_taken']>'10800' && $row['time_taken']<='14400')
				{
					$Dt_row4++;
				}else{
					$Dt_rest++;
				}
			}
		}
		
		if($tot_t_training!='0')
		{
			$Dt_row1_percentage = ($Dt_row1 / $tot_t_training)*100 ;
			$Dt_row2_percentage = ($Dt_row2 / $tot_t_training)*100 ;
			$Dt_row3_percentage = ($Dt_row3 / $tot_t_training)*100 ;
			$Dt_row4_percentage = ($Dt_row4 / $tot_t_training)*100 ;
			
			$Dt_rest_percentage = ($Dt_rest / $tot_t_training)*100 ;
		}
?>								
											<tr class="odd gradeX">
												<td><?php echo "No"; ?></td>
												<td><?php echo $tot_t_training; ?></td>
												<td><?php echo $Dt_row1; ?></td>
												<td><?php echo $Dt_row2; ?></td>
												<td><?php echo $Dt_row3; ?></td>
												<td><?php echo $Dt_row4; ?></td>
												
												<td><?php echo $Dt_rest; ?></td>
												
											</tr>
											<tr class="odd gradeX">
												<td><?php echo "Percentage"; ?></td>
												<td><?php echo ''; ?></td>
												<td><?php echo round($Dt_row1_percentage,2).'%'; ?></td>
												<td><?php echo round($Dt_row2_percentage,2).'%'; ?></td>
												<td><?php echo round($Dt_row3_percentage,2).'%'; ?></td>
												<td><?php echo round($Dt_row4_percentage,2).'%'; ?></td>
												<td><?php echo round($Dt_rest_percentage,2).'%'; ?></td>
												
											</tr>
										</tbody>
									</table>
	<!-- TSCS -->
	<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" >
										<thead>
											<tr>
												<th>TSCS</th>
												<th>Total</th>
												<th>0-60mins</th>
												<th>61-120mins</th>
												<th>121-180mins</th>
												<th>181-240mins</th>
												<th>above 240mins</th>
											</tr>
										</thead>
										<tbody>
										
<?php										
		$tot_ts_tscs = 0;
		$Dts_row1 = 0; $Dts_row2 = 0 ; $Dts_row3 = 0 ; $Dts_row4 = 0 ; $Dts_row5 = 0 ; $Dts_row6 = 0 ; $Dts_rest = 0;
		$Dts_row1_percentage = 0; $Dts_row2_percentage = 0; $Dts_row3_percentage = 0; $Dts_row4_percentage = 0; $Dts_row5_percentage = 0; $Dts_row6_percentage = 0; $Dts_rest_percentage = 0;
		
		foreach($rev_sold as $row)
		{
			if($row['help_desk']=='7')
			{
				$tot_ts_tscs++;
				if($row['time_taken']<='3600')
				{
					$Dts_row1++;
				}elseif($row['time_taken']>'3600' && $row['time_taken']<='7200')
				{
					$Dts_row2++;
				}elseif($row['time_taken']>'7200' && $row['time_taken']<='10800')
				{
					$Dts_row3++;
				}elseif($row['time_taken']>'10800' && $row['time_taken']<='14400')
				{
					$Dts_row4++;
				}else{
					$Dts_rest++;
				}
			}
		}
		
		if($tot_ts_tscs!='0')
		{
			$Dts_row1_percentage = ($Dts_row1 / $tot_ts_tscs)*100 ;
			$Dts_row2_percentage = ($Dts_row2 / $tot_ts_tscs)*100 ;
			$Dts_row3_percentage = ($Dts_row3 / $tot_ts_tscs)*100 ;
			$Dts_row4_percentage = ($Dts_row4 / $tot_ts_tscs)*100 ;
			$Dts_rest_percentage = ($Dts_rest / $tot_ts_tscs)*100 ;
		}
?>								
											<tr class="odd gradeX">
												<td><?php echo "No"; ?></td>
												<td><?php echo $tot_ts_tscs; ?></td>
												<td><?php echo $Dts_row1; ?></td>
												<td><?php echo $Dts_row2; ?></td>
												<td><?php echo $Dts_row3; ?></td>
												<td><?php echo $Dts_row4; ?></td>
												
												<td><?php echo $Dts_rest; ?></td>
												
											</tr>
											<tr class="odd gradeX">
												<td><?php echo "Percentage"; ?></td>
												<td><?php echo ''; ?></td>
												<td><?php echo round($Dts_row1_percentage,2).'%'; ?></td>
												<td><?php echo round($Dts_row2_percentage,2).'%'; ?></td>
												<td><?php echo round($Dts_row3_percentage,2).'%'; ?></td>
												<td><?php echo round($Dts_row4_percentage,2).'%'; ?></td>
												<td><?php echo round($Dts_rest_percentage,2).'%'; ?></td>
												
											</tr>
										</tbody>
									</table>
	<!-- Wick -->
	<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" >
										<thead>
											<tr>
												<th>Wick</th>
												<th>Total</th>
												<th>0-60mins</th>
												<th>61-120mins</th>
												<th>121-180mins</th>
												<th>181-240mins</th>
												<th>above 240mins</th>
											</tr>
										</thead>
										<tbody>
										
<?php										
		$tot_w_wick = 0;
		$Dw_row1 = 0; $Dw_row2 = 0 ; $Dw_row3 = 0 ; $Dw_row4 = 0 ; $Dw_row5 = 0 ; $Dw_row6 = 0 ; $Dw_rest = 0;
		$Dw_row1_percentage = 0; $Dw_row2_percentage = 0; $Dw_row3_percentage = 0; $Dw_row4_percentage = 0; $Dw_row5_percentage = 0; $Dw_row6_percentage = 0; $Dw_rest_percentage = 0;
		
		foreach($rev_sold as $row)
		{
			if($row['help_desk']=='8')
			{
				$tot_w_wick++;
				if($row['time_taken']<='3600')
				{
					$Dw_row1++;
				}elseif($row['time_taken']>'3600' && $row['time_taken']<='7200')
				{
					$Dw_row2++;
				}elseif($row['time_taken']>'7200' && $row['time_taken']<='10800')
				{
					$Dw_row3++;
				}elseif($row['time_taken']>'10800' && $row['time_taken']<='14400')
				{
					$Dw_row4++;
				}else{
					$Dw_rest++;
				}
			}
		}
		
		if($tot_w_wick!='0')
		{
			$Dw_row1_percentage = ($Dw_row1 / $tot_w_wick)*100 ;
			$Dw_row2_percentage = ($Dw_row2 / $tot_w_wick)*100 ;
			$Dw_row3_percentage = ($Dw_row3 / $tot_w_wick)*100 ;
			$Dw_row4_percentage = ($Dw_row4 / $tot_w_wick)*100 ;
			
			$Dw_rest_percentage = ($Dw_rest / $tot_w_wick)*100 ;
		}
?>								
											<tr class="odd gradeX">
												<td><?php echo "No"; ?></td>
												<td><?php echo $tot_w_wick; ?></td>
												<td><?php echo $Dw_row1; ?></td>
												<td><?php echo $Dw_row2; ?></td>
												<td><?php echo $Dw_row3; ?></td>
												<td><?php echo $Dw_row4; ?></td>
												
												<td><?php echo $Dw_rest; ?></td>
												
											</tr>
											<tr class="odd gradeX">
												<td><?php echo "Percentage"; ?></td>
												<td><?php echo ''; ?></td>
												<td><?php echo round($Dw_row1_percentage,2).'%'; ?></td>
												<td><?php echo round($Dw_row2_percentage,2).'%'; ?></td>
												<td><?php echo round($Dw_row3_percentage,2).'%'; ?></td>
												<td><?php echo round($Dw_row4_percentage,2).'%'; ?></td>
												<td><?php echo round($Dw_rest_percentage,2).'%'; ?></td>
												
											</tr>
										</tbody>
									</table>
							
                                </div>
                            </div>
                        </div>
                        </div>
  </div>
  
    <script src="theme001/vendors/jquery-1.9.1.js"></script>
        <script src="theme001/bootstrap/js/bootstrap.min.js"></script>
        <script src="theme001/vendors/datatables/js/jquery.dataTables.min.js"></script>


        <script src="theme001/assets/scripts.js"></script>
        <script src="theme001/assets/DT_bootstrap.js"></script>
        <script>
        $(function() {
            
        });
        </script>

                       
<?php
       $this->load->view("admin/footer");
?>