<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css">
<link href="../../../../ui_assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="../../../../ui_assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css">
<link href="../../../../ui_assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="../../../../ui_assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css">
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="../../../../ui_assets/global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="../../../../ui_assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>
<link rel="stylesheet" type="text/css" href="../../../../ui_assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css"/>
<link rel="stylesheet" type="text/css" href="../../../../ui_assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>

<link rel="stylesheet" type="text/css" href="../../../../ui_assets/global/plugins/clockface/css/clockface.css"/>
<link rel="stylesheet" type="text/css" href="../../../../ui_assets/global/plugins/bootstrap-datepicker/css/datepicker3.css"/>
<link rel="stylesheet" type="text/css" href="../../../../ui_assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
<link rel="stylesheet" type="text/css" href="../../../../ui_assets/global/plugins/bootstrap-colorpicker/css/colorpicker.css"/>
<link rel="stylesheet" type="text/css" href="../../../../ui_assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css"/>
<link rel="stylesheet" type="text/css" href="../../../../ui_assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"/>

<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN THEME STYLES -->
<link href="../../../../ui_assets/global/css/components-rounded.css" id="style_components" rel="stylesheet" type="text/css">
<link href="../../../../ui_assets/global/css/plugins.css" rel="stylesheet" type="text/css">
<link href="../../../../ui_assets/admin/layout3/css/layout.css" rel="stylesheet" type="text/css">
<link href="../../../../ui_assets/admin/layout3/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color">
<link href="../../../../ui_assets/admin/layout3/css/custom.css" rel="stylesheet" type="text/css">
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
<title>Adwitads | Managment Dashboard</title>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-menu-fixed" class to set the mega menu fixed  -->
<!-- DOC: Apply "page-header-top-fixed" class to set the top menu fixed  -->

<body>

<!-- BEGIN HEADER -->
<?php
       $this->load->view("csr_manager/top_menu"); 
?>
<!-- END HEADER -->



<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<!-- END PAGE HEAD -->
	<!-- BEGIN PAGE CONTENT -->
	<div class="page-content">
		<div class="container">
		<!-- BEGIN CALENDER SEARCH -->
			<div class="row">
        <div class="col-lg-12">
        <div class="navbar navbar-default" role="navigation">
								<!-- Brand and toggle get grouped for better mobile display -->
								<div class="navbar-header">
									<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
									<span class="sr-only">
									Toggle navigation </span>
									<span class="icon-bar">
									</span>
									<span class="icon-bar">
									</span>
									<span class="icon-bar">
									</span>
									</button>
									<a class="navbar-brand" href="javascript:;">
									 </a>
								</div>
								<!-- Collect the nav links, forms, and other content for toggling -->
								
								<div class="collapse navbar-collapse navbar-ex1-collapse">
									<form class="navbar-form navbar-left" role="search" method="post"> 
										<div class="form-group">
										<div class="input-group input-large date-picker input-daterange" data-date="2012/11/10" data-date-format="yyyy/mm/dd"> 
												<input type="text" class="form-control" name="from_date" id="from_date">
												<span class="input-group-addon">
												to </span>
												<input type="text" class="form-control" id="to_date" name="to_date">
											</div>
											<!-- /input-group -->
											<span></span>
									</div>
										<button type="submit"  value="Submit"class="btn blue">Search</button> 
									</form>
									<ul class="nav navbar-nav navbar-right">
										<li class="dropdown">
											<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
											Select Type &nbsp;<i class="fa fa-angle-down"></i>
											</a>
											<ul class="dropdown-menu">
											<?php
			   $types = $this->db->get('frontline_timer')->result_array();
				foreach($types as $type)
				{ ?>
												<li>
													<a href="<?php echo base_url().index_page().'csr_manager/home/frontline';?>/<?php echo $type['cat_name'];?>">
													<?php echo $type['cat_name'];  ?></a>
												</li>
			 <?php } ?>									
											</ul>
										</li>
									</ul>
								</div>
								
							
								
								<!-- /.navbar-collapse -->
	</div>
	    </div>
        </div>

			<!-- END CALENDER SEARCH -->
			
			
			
			<!-- BEGIN PUBLICATION TABLE -->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cogs font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold uppercase">Frontline All Report</span>
							</div>
							<div class="tools">
							</div>
						</div>
						<div class="portlet-body">
							<table class="table table-striped table-bordered table-hover">
							<thead>
											<tr>
												<th>Design9</th>
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
			if($row['help_desk']=='1')
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
		<!-- Metro -->							
		<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" >
										<thead>
											<tr>
												<th>Metro</th>
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
		$tot_s_design9 = 0;
		$Ds_row1 = 0; $Ds_row2 = 0 ; $Ds_row3 = 0 ; $Ds_row4 = 0 ; $Ds_row5 = 0 ; $Ds_row6 = 0 ; $Ds_rest = 0;
		
		$Ds_row1_percentage = 0; $Ds_row2_percentage = 0; $Ds_row3_percentage = 0; $Ds_row4_percentage = 0; $Ds_row5_percentage = 0; $Ds_row6_percentage = 0; $Ds_rest_percentage = 0;
		foreach($rev_sold as $row)
		{
			if($row['help_desk']=='2')
			{
				$tot_s_design9++;
				if($row['time_taken']<='1200')
				{
					$Ds_row1++;
				}elseif($row['time_taken']>'1200' && $row['time_taken']<='2400')
				{
					$Ds_row2++;
				}elseif($row['time_taken']>'2400' && $row['time_taken']<='3600')
				{
					$Ds_row3++;
				}elseif($row['time_taken']>'3600' && $row['time_taken']<='5400')
				{
					$Ds_row4++;
				}elseif($row['time_taken']>'5400' && $row['time_taken']<='7200')
				{
					$Ds_row5++;
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
			$Ds_row5_percentage = ($Ds_row5 / $tot_s_design9)*100 ;
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
												<td><?php echo $Ds_row5; ?></td>
												<td><?php echo $Ds_rest; ?></td>
												
											</tr>
											<tr class="odd gradeX">
												<td><?php echo "Percentage"; ?></td>
												<td><?php echo ''; ?></td>
												<td><?php echo round($Ds_row1_percentage,2).'%'; ?></td>
												<td><?php echo round($Ds_row2_percentage,2).'%'; ?></td>
												<td><?php echo round($Ds_row3_percentage,2).'%'; ?></td>
												<td><?php echo round($Ds_row4_percentage,2).'%'; ?></td>
												<td><?php echo round($Ds_row5_percentage,2).'%'; ?></td>
												<td><?php echo round($Ds_rest_percentage,2).'%'; ?></td>
												
											</tr>
										</tbody>
										</table>
	<!-- SDR -->
	<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" >
										<thead>
											<tr>
												<th>SDR+</th>
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
		$tot_n_design9 = 0;
		$Dn_row1 = 0; $Dn_row2 = 0 ; $Dn_row3 = 0 ; $Dn_row4 = 0 ; $Dn_row5 = 0 ; $Dn_row6 = 0 ; $Dn_rest = 0;
		
		$Dn_row1_percentage = 0; $Dn_row2_percentage = 0; $Dn_row3_percentage = 0; $Dn_row4_percentage = 0; $Dn_row5_percentage = 0; $Dn_row6_percentage = 0; $Dn_rest_percentage = 0;
		foreach($rev_sold as $row)
		{
			if($row['help_desk']=='0')
			{
				$tot_n_design9++;
				if($row['time_taken']<='1200')
				{
					$Dn_row1++;
				}elseif($row['time_taken']>'1200' && $row['time_taken']<='2400')
				{
					$Dn_row2++;
				}elseif($row['time_taken']>'2400' && $row['time_taken']<='3600')
				{
					$Dn_row3++;
				}elseif($row['time_taken']>'3600' && $row['time_taken']<='5400')
				{
					$Dn_row4++;
				}elseif($row['time_taken']>'5400' && $row['time_taken']<='7200')
				{
					$Dn_row5++;
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
			$Dn_row5_percentage = ($Dn_row5 / $tot_n_design9)*100 ;
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
												<td><?php echo $Dn_row5; ?></td>
												<td><?php echo $Dn_rest; ?></td>
												
											</tr>
											<tr class="odd gradeX">
												<td><?php echo "Percentage"; ?></td>
												<td><?php echo ''; ?></td>
												<td><?php echo round($Dn_row1_percentage,2).'%'; ?></td>
												<td><?php echo round($Dn_row2_percentage,2).'%'; ?></td>
												<td><?php echo round($Dn_row3_percentage,2).'%'; ?></td>
												<td><?php echo round($Dn_row4_percentage,2).'%'; ?></td>
												<td><?php echo round($Dn_row5_percentage,2).'%'; ?></td>
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
		$tot_p_design9 = 0;
		$Dp_row1 = 0; $Dp_row2 = 0 ; $Dp_row3 = 0 ; $Dp_row4 = 0 ; $Dp_row5 = 0 ; $Dp_row6 = 0 ; $Dp_rest = 0;
		
		$Dp_row1_percentage = 0; $Dp_row2_percentage = 0; $Dp_row3_percentage = 0; $Dp_row4_percentage = 0; $Dp_row5_percentage = 0; $Dp_row6_percentage = 0; $Dp_rest_percentage = 0;
		foreach($rev_sold as $row)
		{
			if($row['help_desk']=='4')
			{
				$tot_p_design9++;
				if($row['time_taken']<='1200')
				{
					$Dp_row1++;
				}elseif($row['time_taken']>'1200' && $row['time_taken']<='2400')
				{
					$Dp_row2++;
				}elseif($row['time_taken']>'2400' && $row['time_taken']<='3600')
				{
					$Dp_row3++;
				}elseif($row['time_taken']>'3600' && $row['time_taken']<='5400')
				{
					$Dp_row4++;
				}elseif($row['time_taken']>'5400' && $row['time_taken']<='7200')
				{
					$Dp_row5++;
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
			$Dp_row5_percentage = ($Dp_row5 / $tot_p_design9)*100 ;
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
												<td><?php echo $Dp_row5; ?></td>
												<td><?php echo $Dp_rest; ?></td>
												
											</tr>
											<tr class="odd gradeX">
												<td><?php echo "Percentage"; ?></td>
												<td><?php echo ''; ?></td>
												<td><?php echo round($Dp_row1_percentage,2).'%'; ?></td>
												<td><?php echo round($Dp_row2_percentage,2).'%'; ?></td>
												<td><?php echo round($Dp_row3_percentage,2).'%'; ?></td>
												<td><?php echo round($Dp_row4_percentage,2).'%'; ?></td>
												<td><?php echo round($Dp_row5_percentage,2).'%'; ?></td>
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
		$tot_f_design9 = 0;
		$Df_row1 = 0; $Df_row2 = 0 ; $Df_row3 = 0 ; $Df_row4 = 0 ; $Df_row5 = 0 ; $Df_row6 = 0 ; $Df_rest = 0;
		
		$Df_row1_percentage = 0; $Df_row2_percentage = 0; $Df_row3_percentage = 0; $Df_row4_percentage = 0; $Df_row5_percentage = 0; $Df_row6_percentage = 0; $Df_rest_percentage = 0;
		foreach($rev_sold as $row)
		{
			if($row['help_desk']=='5')
			{
				$tot_f_design9++;
				if($row['time_taken']<='1200')
				{
					$Df_row1++;
				}elseif($row['time_taken']>'1200' && $row['time_taken']<='2400')
				{
					$Df_row2++;
				}elseif($row['time_taken']>'2400' && $row['time_taken']<='3600')
				{
					$Df_row3++;
				}elseif($row['time_taken']>'3600' && $row['time_taken']<='5400')
				{
					$Df_row4++;
				}elseif($row['time_taken']>'3600' && $row['time_taken']<='5400')
				{
					$Df_row5++;
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
			$Df_row5_percentage = ($Df_row5 / $tot_f_design9)*100 ;
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
												<td><?php echo $Df_row5; ?></td>
												<td><?php echo $Df_rest; ?></td>
												
											</tr>
											<tr class="odd gradeX">
												<td><?php echo "Percentage"; ?></td>
												<td><?php echo ''; ?></td>
												<td><?php echo round($Df_row1_percentage,2).'%'; ?></td>
												<td><?php echo round($Df_row2_percentage,2).'%'; ?></td>
												<td><?php echo round($Df_row3_percentage,2).'%'; ?></td>
												<td><?php echo round($Df_row4_percentage,2).'%'; ?></td>
												<td><?php echo round($Df_row5_percentage,2).'%'; ?></td>
												<td><?php echo round($Df_rest_percentage,2).'%'; ?></td>
												
											</tr>
										</tbody>

									</table>
							</table>
						</div>
					</div>
					<!-- END EXAMPLE TABLE PORTLET-->
				</div>
			</div>
			<!-- END PUBLICATION TABLE -->
			
		

			
		</div>
	</div>
	<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->



<!-- BEGIN FOOTER -->
<div class="page-footer">
	<div class="container">
		 2015 &copy; adwitads. All Rights Reserved.
	</div>
</div>
<div class="scroll-to-top">
	<i class="icon-arrow-up"></i>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="../../../../ui_assets/global/plugins/respond.min.js"></script>
<script src="../../../../ui_assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->

<script src="../../../../ui_assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="../../../../ui_assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>

<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="../../../../ui_assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
<script src="../../../../ui_assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../../../ui_assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="../../../../ui_assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../../../ui_assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="../../../../ui_assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="../../../../ui_assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="../../../../ui_assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="../../../../ui_assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../../../../ui_assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
<script type="text/javascript" src="../../../../ui_assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js"></script>
<script type="text/javascript" src="../../../../ui_assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
<script type="text/javascript" src="../../../../ui_assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>

<script type="text/javascript" src="../../../../ui_assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="../../../../ui_assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script type="text/javascript" src="../../../../ui_assets/global/plugins/clockface/js/clockface.js"></script>
<script type="text/javascript" src="../../../../ui_assets/global/plugins/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="../../../../ui_assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="../../../../ui_assets/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="../../../../ui_assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../../../../ui_assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="../../../../ui_assets/admin/layout3/scripts/layout.js" type="text/javascript"></script>
<script src="../../../../ui_assets/admin/layout3/scripts/demo.js" type="text/javascript"></script>
<script src="../../../../ui_assets/admin/pages/scripts/components-pickers.js"></script>

<script src="../../../../ui_assets/admin/pages/scripts/table-advanced.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<script>
        jQuery(document).ready(function() {       
           // initiate layout and plugins
           Metronic.init(); // init metronic core components
           Layout.init(); // init current layout
           Demo.init(); // init demo features
           ComponentsPickers.init();
		   TableAdvanced.init();
        });   
    </script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>