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
								<span class="caption-subject font-green-sharp bold uppercase">csr production</span>
							</div>
							<div class="tools">
							</div>
						</div>
						<div class="portlet-body">
							<table class="table table-striped table-bordered table-hover" id="sample_1">
							<thead>
											<tr>
												<th rowspan="2" style="vertical-align: middle;">CSR</th>
											
												<!--<th colspan="7" style=" text-align: center;">Catergory(QA)</th>-->
												<th colspan="6" style=" text-align: center;">Total</th>
                                                <th rowspan="2" style="vertical-align: middle;">Final NJ</th>
                                            </tr>
                                            <tr>
											<!--
												<th>A</th>
												<th>B</th>
                                                <th>C</th>
												<th>D</th>
                                                <th>E</th>
												<th>F</th>
												<th>G</th>
												-->
                                                <th style=" text-align: center;">QA
<a onclick="window.open('<?php echo base_url().index_page().'management/home/QA_performance/';?>')" style="cursor:pointer; text-decoration: none; color:#999;">(?)</a>																							
												</th>
											<!--<th style=" text-align: center;">QA_NJ</th> -->
                                                <th style=" text-align: center;">Categorised</th>
												<th style=" text-align: center;">Incoming
<a onclick="window.open('<?php echo base_url().index_page().'management/home/incoming_performance/';?>')" style="cursor:pointer; text-decoration: none; color:#999;">(?)</a>												
												</th>
												<th style=" text-align: center;">Outgoing
<a onclick="window.open('<?php echo base_url().index_page().'management/home/outgoing_performance/';?>')" style="cursor:pointer; text-decoration: none; color:#999;">(?)</a>																								
												</th>
												<th>RovCheck</th>
												<th>Uploads</th>
                                            </tr>
										</thead>
							<tbody name="testTable" id="testTable">
<?php

foreach($csr as $row)
{	
	
	$QA_nj = 0; $cat_nj = 0; $incoming_nj = 0; $outgoing_nj = 0; $final_nj = 0; $pub_nj = 0; $rev_nj = 0; $revision_nj = 0;
	$cat_job_count = 0; $sq_inches = 0; $cp_job_count = 0;
	$cat_a = 0; $cat_b = 0; $cat_c = 0; $cat_d = 0; $cat_e = 0; $cat_f = 0; $cat_g = 0; $cat_rev = 0; $cat_sold = 0;
	
			$csr_id = $row['id'];
			if(isset($from) && isset($to))
			{
				$cat_result = $this->db->query("SELECT * FROM `cat_result` WHERE  `csr`='$csr_id' AND `date` BETWEEN '$from' AND '$to' ;")->result_array();
				$cp = $this->db->query("SELECT * FROM `cp_tool` WHERE  `csr`='$csr_id' AND `date` BETWEEN '$from' AND '$to' ;")->result_array();
				$rev_sold = $this->db->query("SELECT * FROM `ptrands` WHERE  `csr`='$csr_id' AND `date` BETWEEN '$from' AND '$to' ;")->result_array();			
				$incoming = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE  `csr`='$csr_id' AND `date` BETWEEN '$from' AND '$to' ;")->result_array();
				$outgoing = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE  `frontline_csr`='$csr_id' AND `date` BETWEEN '$from' AND '$to' ;")->result_array();			
				$upload = $this->db->query("SELECT * FROM `cp_tool` WHERE  `upload_csr`='$csr_id' AND `date` BETWEEN '$from' AND '$to' ;")->result_array();			
			}else{
				$cat_result = $this->db->get_where('cat_result',array('csr' => $csr_id, 'date' => $today))->result_array();
				$cp = $this->db->get_where('cp_tool',array('csr' => $csr_id, 'date' => $today))->result_array();
				$rev_sold = $this->db->query("SELECT * FROM `ptrands` WHERE  `csr`='$csr_id' AND `date`='$today' ;")->result_array();
				$incoming = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE  `csr`='$csr_id' AND `date`='$today' ;")->result_array();
				$outgoing = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE  `frontline_csr`='$csr_id' AND `date`='$today' ;")->result_array();			
				$upload = $this->db->query("SELECT * FROM `cp_tool` WHERE  `upload_csr`='$csr_id' AND `date`='$today' ;")->result_array();			
			}
			$cat_job_count = count($cat_result);
			$cp_job_count = count($cp);
			foreach($cp as $row2)
			{
				$cat = $this->db->get_where('cat_result',array('order_no' => $row2['order_no']))->result_array();
				if($cat){
					$cat_wt = $this->db->get_where('print',array('name' => $cat[0]['category']))->result_array();
					$pub_nj = $pub_nj + $cat_wt[0]['wt'];
					
					if($cat[0]['category'] == 'A')
					{
						$cat_a++;
					}
					if($cat[0]['category'] == 'B')
					{
						$cat_b++;
					}
					if($cat[0]['category'] == 'C' || $cat[0]['category'] == 'c')
					{
						$cat_c++;
					}
					if($cat[0]['category'] == 'D')
					{
						$cat_d++;
					}
					if($cat[0]['category'] == 'E')
					{
						$cat_e++;
					}
					if($cat[0]['category'] == 'F')
					{
						$cat_f++;
					}
					if($cat[0]['category'] == 'G')
					{
						$cat_g++;
					}
				}
			}
			
			if($rev_sold)
			{			
				foreach($rev_sold as $row3)
				{
					$cat_wt = $this->db->get_where('print',array('name' => $row3['category']))->result_array();
					$rev_nj = $rev_nj + $cat_wt[0]['wt'];
					
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
			$QA_nj = $pub_nj / 5 ;
			$cat_nj = $cat_job_count / 27;
			$incoming_nj = count($incoming) / 27;
			$outgoing_nj = count($outgoing) / 27;
			$revision_nj = $rev_nj / 27;
			$final_nj = $QA_nj + $cat_nj + $incoming_nj + $outgoing_nj + $revision_nj;
	
	?>    									
											<tr class="odd gradeX">
												<td><?php echo $row['name']; ?></td>
												<!--
												<td><?php echo $cat_a; ?></td>
												<td><?php echo $cat_b; ?></td>
												<td><?php echo $cat_c; ?></td>
												<td><?php echo $cat_d; ?></td>
												<td><?php echo $cat_e; ?></td>
												<td><?php echo $cat_f; ?></td>
												<td><?php echo $cat_g; ?></td>
												-->
												<td><?php echo $cp_job_count; ?></td>
												<!--<td><?php echo round($pub_nj,2); ?></td>-->
												<td><?php echo $cat_job_count; ?></td>
												<td><?php echo round(count($incoming),2); ?></td>
												<td><?php echo round(count($outgoing),2); ?></td>
												<td><?php echo $cat_rev; ?></td>
												<td><?php echo round(count($upload),2); ?></td>
												<td><?php echo round($final_nj,2); ?></td>
												
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