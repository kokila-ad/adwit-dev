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
<link href="../../../ui_assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="../../../ui_assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css">
<link href="../../../ui_assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="../../../ui_assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css">
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="../../../ui_assets/global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="../../../ui_assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>
<link rel="stylesheet" type="text/css" href="../../../ui_assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css"/>
<link rel="stylesheet" type="text/css" href="../../../ui_assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>

<link rel="stylesheet" type="text/css" href="../../../ui_assets/global/plugins/clockface/css/clockface.css"/>
<link rel="stylesheet" type="text/css" href="../../../ui_assets/global/plugins/bootstrap-datepicker/css/datepicker3.css"/>
<link rel="stylesheet" type="text/css" href="../../../ui_assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
<link rel="stylesheet" type="text/css" href="../../../ui_assets/global/plugins/bootstrap-colorpicker/css/colorpicker.css"/>
<link rel="stylesheet" type="text/css" href="../../../ui_assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css"/>
<link rel="stylesheet" type="text/css" href="../../../ui_assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"/>

<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN THEME STYLES -->
<link href="../../../ui_assets/global/css/components-rounded.css" id="style_components" rel="stylesheet" type="text/css">
<link href="../../../ui_assets/global/css/plugins.css" rel="stylesheet" type="text/css">
<link href="../../../ui_assets/admin/layout3/css/layout.css" rel="stylesheet" type="text/css">
<link href="../../../ui_assets/admin/layout3/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color">
<link href="../../../ui_assets/admin/layout3/css/custom.css" rel="stylesheet" type="text/css">
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
								<span class="caption-subject font-green-sharp bold uppercase">Designer Production</span>
							</div>
							<div class="tools">
							</div>
						</div>
						<div class="portlet-body">
							<table class="table table-striped table-bordered table-hover" id="sample_1">
							<thead>
                                        <tr>
												<!--<th>ID</th>-->
												<th colspan="2" style="text-align: center;">Designer</th>
												<!--<th>Team Lead</th>-->
												<th rowspan="2" style="vertical-align: middle;">New Ads</th>
												<!--<th>Total NJ</th>-->
												<th rowspan="2"style="vertical-align: middle;">Revision</th>
												<th rowspan="2"style="vertical-align: middle;">Sold</th>
												<th colspan="3"style="text-align: center;">Total</th>
												<!--<th>A</th>
												<th>B</th>
                                                <th>C</th>
												<th>D</th>
                                                <th>E</th>
												<th>F</th>
												<th>G</th>
                                                <th>REVISION</th>
												<th>SOLD</th>-->
                                                
											</tr>
											<tr>
												<!--<th>ID</th>-->
												<th>Name</th>
												<th>Code</th>
												<!--<th>Team Lead</th>-->
												<!--<th>Total NJ</th>-->
												<th>NJ</th>
												<th>Minor Error</th>
												<th>Major Error</th>
												<!--<th>A</th>
												<th>B</th>
                                                <th>C</th>
												<th>D</th>
                                                <th>E</th>
												<th>F</th>
												<th>G</th>
                                                <th>REVISION</th>
												<th>SOLD</th>-->
                                                
											</tr>
										</thead>
							<tbody>
<?php

foreach($designer as $row)
{	
	$team_lead = $this->db->get_where('team_lead',array('id' => $row['design_team_lead']))->result_array();
	$pub_nj = 0; $job_count = 0; $sq_inches = 0; 
	$cat_a = 0; $cat_b = 0; $cat_c = 0; $cat_d = 0; $cat_e = 0; $cat_f = 0; $cat_g = 0; $cat_rev = 0; $cat_sold = 0;
	
	$designerr_min_count = 0; $designerr_major_count = 0; $perfect_count = 0;
	$techerr_min_count = 0; $techerr_major_count = 0; 
	$texterr_min_count = 0; $texterr_major_count = 0; 
	$visualerr_min_count = 0; $visualerr_major_count = 0;
	
			$designer_id = $row['id'];
			if(isset($from) && isset($to))
			{
				$cat_result = 	$this->db->query("SELECT * FROM `cat_result` WHERE  `designer`='$designer_id' AND `ddate` BETWEEN '$from' AND '$to' ;")->result_array();
				$rev_sold = $this->db->query("SELECT * FROM `ptrands` WHERE  `designer`='$designer_id' AND `date` BETWEEN '$from' AND '$to' ;")->result_array(); //rev, sold
				$cp_id = $this->db->query("SELECT * FROM `cp_tool` WHERE `designer`='$designer_id' AND `date` BETWEEN '$from' AND '$to' ;")->result_array();
			}else{
				$cat_result = $this->db->get_where('cat_result',array('designer' => $designer_id, 'ddate' => $today))->result_array();
				$rev_sold = $this->db->query("SELECT * FROM `ptrands` WHERE  `designer`='$designer_id' AND `date`='$today' ;")->result_array(); //rev, sold
				$cp_id = $this->db->query("SELECT * FROM `cp_tool` WHERE `designer`='$designer_id' AND `date`='$today' ;")->result_array();
			}
		
			foreach($cat_result as $row2)
			{
				$w_h = 0;
				$category = $this->db->get_where('print',array('name' => $row2['category']))->result_array();
				$pub_nj = $pub_nj + $category[0]['wt'];
				$job_count++;
				
				$w_h = $row2['width'] * $row2['height'];
				$sq_inches = $sq_inches + $w_h;
				
				if($row2['category'] == 'A')
				{
					$cat_a++;
				}
				if($row2['category'] == 'B')
				{
					$cat_b++;
				}
				if($row2['category'] == 'C' || $row2['category'] == 'c')
				{
					$cat_c++;
				}
				if($row2['category'] == 'D')
				{
					$cat_d++;
				}
				if($row2['category'] == 'E')
				{
					$cat_e++;
				}
				if($row2['category'] == 'F')
				{
					$cat_f++;
				}
				if($row2['category'] == 'G')
				{
					$cat_g++;
				}
			
			}
			if($rev_sold)
			{			
				foreach($rev_sold as $row3)
				{
					$cat_wt = $this->db->get_where('print',array('name' => $row3['category']))->result_array();
					$pub_nj = $pub_nj + $cat_wt[0]['wt'];
					
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
			if(isset($from) && isset($to))
			{
				
				$dp = 	$this->db->query("SELECT * FROM `designer_dp` WHERE  `designer`='$designer_id' AND `date` BETWEEN '$from' AND '$to' ;")->result_array();
			}else{
				
				$dp = 	$this->db->query("SELECT * FROM `designer_dp` WHERE `designer`='$designer_id' AND `date`='$today' ;")->result_array();
			}
			$sum_nj=0; $sum_tt=0; $count=0;
			foreach($dp as $row1)
			{
				
				$sum_tt = $row1['TT'] + $sum_tt;
				$count++;
			}
			if($sum_tt == 0)
			{
				$avg_tt = 0;
			}else{
				$avg_tt = $sum_tt / $count;
				$avg_tt = round($avg_tt,2);
			}
	//minor major error
			foreach($cp_id as $row1)
			{
				$cid = $row1['id'];
				//minor error degree
				$err_design_min = $this->db->query("SELECT * FROM `cp_error_result` WHERE `cp_result_id`='$cid' AND `error_type`='1' AND `error_degree`='1' ;")->result_array();
				$err_tech_min = $this->db->query("SELECT * FROM `cp_error_result` WHERE `cp_result_id`='$cid' AND `error_type`='2' AND `error_degree`='1' ;")->result_array();
				$err_text_min = $this->db->query("SELECT * FROM `cp_error_result` WHERE `cp_result_id`='$cid' AND `error_type`='3' AND `error_degree`='1' ;")->result_array();
				$err_visual_min = $this->db->query("SELECT * FROM `cp_error_result` WHERE `cp_result_id`='$cid' AND `error_type`='4' AND `error_degree`='1' ;")->result_array();
				
				//major error degree
				$err_design_major = $this->db->query("SELECT * FROM `cp_error_result` WHERE `cp_result_id`='$cid' AND `error_type`='1' AND `error_degree`='2' ;")->result_array();
				$err_tech_major = $this->db->query("SELECT * FROM `cp_error_result` WHERE `cp_result_id`='$cid' AND `error_type`='2' AND `error_degree`='2' ;")->result_array();
				$err_text_major = $this->db->query("SELECT * FROM `cp_error_result` WHERE `cp_result_id`='$cid' AND `error_type`='3' AND `error_degree`='2' ;")->result_array();
				$err_visual_major = $this->db->query("SELECT * FROM `cp_error_result` WHERE `cp_result_id`='$cid' AND `error_type`='4' AND `error_degree`='2' ;")->result_array();
	
				foreach($err_design_min as $min1)		//design type error
				{
					$designerr_min_count++;
				}
				foreach($err_design_major as $major1)
				{
					$designerr_major_count++;
				}
				foreach($err_tech_min as $min2)			//tech type error
				{
					$techerr_min_count++;
				}
				foreach($err_tech_major as $major2)
				{
					$techerr_major_count++;
				}
				foreach($err_text_min as $min3)			//text type error
				{
					$texterr_min_count++;
				}
				foreach($err_text_major as $major3)
				{
					$texterr_major_count++;
				}
				foreach($err_visual_min as $min4)			//visual type error
				{
					$visualerr_min_count++;
				}
				foreach($err_visual_major as $major4)
				{
					$visualerr_major_count++;
				}
	
			}
	
		$tot_minor =  $designerr_min_count + $techerr_min_count + $visualerr_min_count + $texterr_min_count  ;
		$tot_major =  $designerr_major_count + $techerr_major_count + $visualerr_major_count + $texterr_major_count ;
	
	?>    									
											<tr class="odd gradeX">
												<!--<td><?php echo $row['id']; ?></td>-->
												<td><?php echo $row['name']; ?></td>
												<td><?php echo $row['username']; ?></td>
												<!--<td><?php echo $team_lead[0]['first_name']; ?></td>-->
												<td><?php echo $job_count; ?></td>
												<!--<td><?php echo $pub_nj; ?></td>-->
												<td><?php echo $cat_rev; ?></td>
												<td><?php echo $cat_sold; ?></td>
												<td><?php echo $pub_nj; ?></td>
												<td><?php echo $tot_minor; ?></td>
												<td><?php echo $tot_major; ?></td>
												<!--<td><?php echo $cat_a; ?></td>
												<td><?php echo $cat_b; ?></td>
												<td><?php echo $cat_c; ?></td>
												<td><?php echo $cat_d; ?></td>
												<td><?php echo $cat_e; ?></td>
												<td><?php echo $cat_f; ?></td>
												<td><?php echo $cat_g; ?></td>
												<td><?php echo $cat_rev; ?></td>
												<td><?php echo $cat_sold; ?></td>-->
											</tr>
<?php }?>											
										</tbody>
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
<script src="../../../ui_assets/global/plugins/respond.min.js"></script>
<script src="../../../ui_assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->

<script src="../../../ui_assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="../../../ui_assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>

<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="../../../ui_assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
<script src="../../../ui_assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../../ui_assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="../../../ui_assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../../ui_assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="../../../ui_assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="../../../ui_assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="../../../ui_assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="../../../ui_assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../../../ui_assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
<script type="text/javascript" src="../../../ui_assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js"></script>
<script type="text/javascript" src="../../../ui_assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
<script type="text/javascript" src="../../../ui_assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>

<script type="text/javascript" src="../../../ui_assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="../../../ui_assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script type="text/javascript" src="../../../ui_assets/global/plugins/clockface/js/clockface.js"></script>
<script type="text/javascript" src="../../../ui_assets/global/plugins/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="../../../ui_assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="../../../ui_assets/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="../../../ui_assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../../../ui_assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="../../../ui_assets/admin/layout3/scripts/layout.js" type="text/javascript"></script>
<script src="../../../ui_assets/admin/layout3/scripts/demo.js" type="text/javascript"></script>
<script src="../../../ui_assets/admin/pages/scripts/components-pickers.js"></script>

<script src="../../../ui_assets/admin/pages/scripts/table-advanced.js"></script>
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