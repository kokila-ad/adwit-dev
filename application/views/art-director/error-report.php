<?php
       $this->load->view("art-director/header");
?>
  <div id="Middle-Div">
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
  <div style="padding-left: 30px; padding-top: 20px;">
	<form id="search" name="search" method="post" style="padding:0; margin:0;">
	<span>From &nbsp;</span><input type="text" name="from_date" id="from_date" placeholder="YYYY-MM-DD" style="border: thin solid #CCC; padding:5px; outline: none; margin:0;"/> &nbsp;&nbsp;<span>To &nbsp;</span><input type="text" id="to_date" name="to_date" placeholder="YYYY-MM-DD" style="border: thin solid #CCC; padding:5px; outline: none; margin:0;"/>
	<input type="submit" value="Submit" />
	</form>
</div>
  
   <div class="row-fluid" style="width:96%; margin: 0 auto;">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
							<div class="muted pull-left">Error Report : <?php if(isset($from) && isset($to)){echo $from." to ".$to;}else{echo $today;} ?></div>
                            <div style="float: right;"><input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Export to Excel" /></div>
							</div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
										<thead>
                                        	<tr>
												<th rowspan="2" style=" vertical-align:middle;">Code</th>
												<th rowspan="2" style=" vertical-align:middle;">Designer</th>
												<th rowspan="2" style=" vertical-align:middle;">Team Lead</th>
												<!--<th rowspan="2" style=" vertical-align:middle;">Total NJ</th>
												<th rowspan="2" style=" vertical-align:middle;">Avg DP</th>-->
                                                <th rowspan="2" style=" vertical-align:middle;">Total QA</th>
												<th colspan="2" style=" text-align: center;">Perfect Ad</th>
												<th colspan="2" style="text-align: center;">Design</th>
                                                <th colspan="2" style="text-align: center;">Visual</th>
												<th colspan="2" style="text-align: center;">Tech</th>
                                                <th colspan="2" style="text-align: center;">Text</th>
												
											</tr>
											<tr>
												<th>Nos</th>
												<th>%</th>
                                                <th>Minor</th>
												<th>Major</th>
                                                <th>Minor</th>
												<th>Major</th>
                                                <th>Minor</th>
												<th>Major</th>
                                                <th>Minor</th>
												<th>Major</th>
											</tr>
										</thead>
										<tbody name="testTable" id="testTable">
<?php 
		
		
		
		foreach($designer as $row)
		{
			$id = $row['id']; $total_job_count = 0;
			
			$team_lead = $this->db->get_where('team_lead',array('id' => $row['design_team_lead']))->result_array();
			$designerr_min_count = 0; $designerr_major_count = 0; $perfect_count = 0;
			$techerr_min_count = 0; $techerr_major_count = 0; 
			$texterr_min_count = 0; $texterr_major_count = 0; 
			$visualerr_min_count = 0; $visualerr_major_count = 0;
			
			if(isset($from) && isset($to))
			{
				$cp_id = $this->db->query("SELECT * FROM `cp_tool` WHERE `designer`='$id' AND `date` BETWEEN '$from' AND '$to' ;")->result_array();
			}else{
				$cp_id = $this->db->query("SELECT * FROM `cp_tool` WHERE `designer`='$id' AND `date`='$today' ;")->result_array();
			}
			
			$total_job_count = count($cp_id);
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
				
				//perfect error degree
				$err_perfect = $this->db->query("SELECT * FROM `cp_error_result` WHERE `cp_result_id`='$cid' AND `error_degree`='3' ;")->result_array();
			//	$err_tech_perfect = $this->db->query("SELECT * FROM `cp_error_result` WHERE `cp_result_id`='$cid' AND `error_type`='2' AND `error_degree`='3' ;")->result_array();
			//	$err_text_perfect = $this->db->query("SELECT * FROM `cp_error_result` WHERE `cp_result_id`='$cid' AND `error_type`='3' AND `error_degree`='3' ;")->result_array();
				
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
				foreach($err_perfect as $perfect)		//perfect error degree
				{
					//echo $row['id']."<br/>";
					$perfect_count++;
				}
			}
	?>
<?php 
	// NJ, DP display
	if(isset($from) && isset($to))
	{
		$dp = 	$this->db->query("SELECT * FROM `designer_dp` WHERE  `designer`='$id' AND `date` BETWEEN '$from' AND '$to' ;")->result_array();
	}else{
		$dp = 	$this->db->query("SELECT * FROM `designer_dp` WHERE `designer`='$id' AND `date`='$today' AND `job_status`='completed' ;")->result_array();
	}
	
	if(!$dp)
	{
		$sum_nj = '0'; $num_jobs = '0'; $sum_tt = '0'; $avg_tt = '0';
	}else
	{
		if(isset($from) && isset($to))
		{
			$jobs = $this->db->query("SELECT * FROM `cat_result` WHERE  `designer`='$id' AND `ddate` BETWEEN '$from' AND '$to' ;")->result_array();
		}else{
			$jobs = $this->db->get_where('cat_result',array('designer' => $id, 'ddate' => $today))->result_array();
		}
		$num_jobs = count($jobs);
		$sum_nj=0; $sum_tt=0; $count=0;
		foreach($dp as $row1)
		{	
			$sum_nj = $sum_nj + $row1['NJ'];
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
	}
	?>	
								
<?php  
	if($total_job_count == 0)
	{ $percent = 0;}
	else
	{ 
		$tot_minor = ( $designerr_min_count + $techerr_min_count + $visualerr_min_count + $texterr_min_count ) * 1 ;
		$tot_major = ( $designerr_major_count + $techerr_major_count + $visualerr_major_count + $texterr_major_count ) * 2 ;
													
		$min_major = $tot_minor + $tot_major;
													
		$end_value = $perfect_count - $min_major ;
		$percent = $end_value / $total_job_count ;
		$percent = round($percent,2)*100;
	}
?>	
											<tr class="odd gradeX">
												<td><?php echo $row['username']; ?></td>
												<td><?php echo $row['name']; ?></td>
												<td><?php echo $team_lead[0]['first_name']; ?></td>
												<!--<td><?php echo $sum_nj; ?></td>
												<td><?php echo $avg_tt; ?></td>-->
                                                <td><?php echo $total_job_count; ?></td>
												<td class="center"> <?php echo $perfect_count; ?></td>

												<td class="center"><?php echo $percent ?></td>
												<td><?php echo $designerr_min_count; ?></td>
												<td><?php echo $designerr_major_count; ?></td>
                                                <td><?php echo $visualerr_min_count; ?></td>
												<td><?php echo $visualerr_major_count; ?></td>
                                                <td><?php echo $techerr_min_count; ?></td>
												<td><?php echo $techerr_major_count; ?></td>
                                                <td><?php echo $texterr_min_count; ?></td>
												<td><?php echo $texterr_major_count; ?></td>
												
											</tr>
<?php }?>											
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
          
		<script>
		
			var tableToExcel = (function() {
		  var uri = 'data:application/vnd.ms-excel;base64,'
			, template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head></head><body><table>{table}</table></body></html>'
			, base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
			, format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
		  return function(table, name) {
			if (!table.nodeType) table = document.getElementById(table)
			var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
			window.location.href = uri + base64(format(template, ctx))
		  }
		})()
		
        </script>
		  
<?php
       $this->load->view("art-director/footer");
?>