<?php
       $this->load->view("admin/header");
?>
        <link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/DT_bootstrap.css" rel="stylesheet" media="screen">
        <script src="theme001/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
<?php
$designer = $this->db->get('designers')->result_array();
?>
  <div id="Middle-Div">
   <div class="row-fluid" style="width:96%; margin: 0 auto;">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Design Type Error</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
										<thead>
                                        	<tr>
												<th rowspan="2" style=" vertical-align:middle;">Designer</th>
                                                <th rowspan="2" style=" vertical-align:middle;">Total Jobs</th>
												<th colspan="2" style="text-align: center;">Design</th>
                                                <th colspan="2" style="text-align: center;">Visual</th>
												<th colspan="2" style="text-align: center;">Tech</th>
                                                <th colspan="2" style="text-align: center;">Text</th>
												<th rowspan="2" style=" vertical-align:middle;">Perfect</th>
                                                <th rowspan="2" style=" vertical-align:middle;">&nbsp;%&nbsp;</th>
											</tr>
											<tr>
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
										<tbody>
<?php 
		$total_job_count = 0;
		$prev_month = date("Y-m", strtotime("-1 month"));
		
		foreach($designer as $row)
		{
			$id = $row['id'];
			//$total_jobs = $this->db->query("SELECT * FROM `cat_result` WHERE `designer`='$id' AND `ddate` LIKE '%$prev_month%' ;")->result_array();
			//$total_job_count = count($total_jobs);
			$designerr_min_count = 0; $designerr_major_count = 0; $perfect_count = 0;
			$techerr_min_count = 0; $techerr_major_count = 0; 
			$texterr_min_count = 0; $texterr_major_count = 0; 
			$visualerr_min_count = 0; $visualerr_major_count = 0;
			//$cp_id = $this->db->get_where('cp_tool',array('designer'=> $row['id']))->result_array();
			$cp_id = $this->db->query("SELECT * FROM `cp_tool` WHERE `designer`='$id' AND `time_stamp` LIKE '%$prev_month%' ;")->result_array();
			$total_job_count = count($cp_id);
			foreach($cp_id as $row1)
			{
				//echo $row1['id']." - ".$row1['time_stamp']." - ".$row1['designer']."<br/>";
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
					$perfect_count++;
				}
			}
	?>									
											<tr class="odd gradeX">
												<td><?php echo $row['name']; ?></td>
                                                <td><?php echo $total_job_count; ?></td>
												<td><?php echo $designerr_min_count; ?></td>
												<td><?php echo $designerr_major_count; ?></td>
                                                <td><?php echo $visualerr_min_count; ?></td>
												<td><?php echo $visualerr_major_count; ?></td>
                                                <td><?php echo $techerr_min_count; ?></td>
												<td><?php echo $techerr_major_count; ?></td>
                                                <td><?php echo $texterr_min_count; ?></td>
												<td><?php echo $texterr_major_count; ?></td>
												<td class="center"> <?php echo $perfect_count; ?></td>
								
                                                <td class="center"> <?php if($total_job_count == 0){ $percent = 0;}else{ $percent = $perfect_count / $total_job_count; $percent = round($percent,2)*100;}
																		echo $percent ?></td>
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
                       
<?php
       $this->load->view("admin/footer");
?>