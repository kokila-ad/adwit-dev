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

  <div id="Middle-Div">
  <div style="padding-left: 30px; padding-top: 20px;">
		<form method="post" style="padding:0; margin:0;">
		<span>From &nbsp;</span><input type="text" name="from_date" id="from_date" placeholder="YYYY-MM-DD" style="border: thin solid #CCC; padding:5px; outline: none; margin:0;"/> &nbsp;&nbsp;<span>To &nbsp;</span><input type="text" id="to_date" name="to_date" placeholder="YYYY-MM-DD" style="border: thin solid #CCC; padding:5px; outline: none; margin:0;"/>
		<input type="submit" value="Submit" />
		</form>
   </div>
     <div class="row-fluid" style="width:96%; margin: 0 auto;">
                        <!-- block -->
                        <div class="block">
                        <div class="navbar navbar-inner block-header">
                            <div class="muted pull-left">Production : <?php if(isset($from) && isset($to)){echo $from." to ".$to;}else{echo $today;} ?> </div>
                            <div style="float: right;"><input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Export to Excel" /></div>
						</div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
										<thead>
											<tr>
												<!--<th>ID</th>-->
												<th colspan="2" style=" text-align: center;">Designer</th>
												<th rowspan="2" style=" vertical-align: middle;">BG</th>
												<th rowspan="2"style=" vertical-align: middle;">TL</th>
												<th colspan="3" style=" text-align: center;">Total</th>
												<th rowspan="2" style=" vertical-align: middle;">Avg DP</th>
												<th colspan="9" style=" text-align: center;">Category</th>
												<th colspan="2"style=" text-align: center;">Total Error</th>
											</tr>
                                            <tr>
												<!--<th>ID</th>-->
												<th>Name</th>
												<th>Code</th>
												<th> Ads</th>
												<th>QA</th>
												<th>NJ</th>
												<th>A</th>
												<th>B</th>
                                                <th>C</th>
												<th>D</th>
                                                <th>E</th>
												<th>F</th>
												<th>G</th>
                                                <th>RJ</th>
												<th>SJ</th>
												<th>Minor</th>
												<th>Major</th>
                                                <th>wt</th>
											</tr>
										</thead>
										<tbody name="testTable" id="testTable">
<?php 

foreach($designer as $row)
{	
	$team_lead = $this->db->get_where('team_lead',array('id' => $row['design_team_lead']))->result_array();
	$art_dir = $this->db->get_where('art_director',array('id' => $team_lead[0]['art_director']))->result_array();
	$bg_grp = $this->db->get_where('business_groups',array('id' => $art_dir[0]['business_group_id']))->result_array();
	$dp_sft = 0; $pub_nj = 0; $job_count = 0; $sq_inches = 0; $total_QA = 0;
	$cat_a = 0; $cat_b = 0; $cat_c = 0; $cat_d = 0; $cat_e = 0; $cat_f = 0; $cat_g = 0; $cat_rev = 0; $cat_sold = 0;
	
	$designerr_min_count = 0; $designerr_major_count = 0; $perfect_count = 0;
	$techerr_min_count = 0; $techerr_major_count = 0; 
	$texterr_min_count = 0; $texterr_major_count = 0; 
	$visualerr_min_count = 0; $visualerr_major_count = 0;
	$error_catwt = 0;
			$designer_id = $row['id'];
			if(isset($from) && isset($to))
			{
				$cat_result = 	$this->db->query("SELECT * FROM `cat_result` WHERE  `designer`='$designer_id' AND `ddate` BETWEEN '$from' AND '$to' ;")->result_array();
				$rev_sold = $this->db->query("SELECT * FROM `ptrands` WHERE  `designer`='$designer_id' AND `date` BETWEEN '$from' AND '$to' ;")->result_array();
				$cp_id = $this->db->query("SELECT * FROM `cp_tool` WHERE `designer`='$designer_id' AND `date` BETWEEN '$from' AND '$to' ;")->result_array();			
				$cp_id1 = $this->db->query("SELECT DISTINCT `order_no` FROM `cp_tool` WHERE `designer`='$designer_id' AND `time_stamp` BETWEEN '$from' AND '$to' ;")->result_array();			
				//SELECT COUNT(DISTINCT column_name) FROM table_name;
				$additional_hrs = $this->db->get_where('designer_additional_hours',array('designer' => $designer_id, 'date' => $today, 'status' => "approved"))->result_array();
			}else{
				$cat_result = $this->db->get_where('cat_result',array('designer' => $designer_id, 'ddate' => $today))->result_array();
				$rev_sold = $this->db->query("SELECT * FROM `ptrands` WHERE  `designer`='$designer_id' AND `date`='$today' ;")->result_array();
				$cp_id = $this->db->query("SELECT * FROM `cp_tool` WHERE `designer`='$designer_id' AND `date`='$today' ;")->result_array();
				$cp_id1 = $this->db->query("SELECT DISTINCT `order_no` FROM `cp_tool` WHERE `designer`='$designer_id' AND `time_stamp` LIKE '$today%' ;")->result_array();			
				$additional_hrs = $this->db->get_where('designer_additional_hours',array('designer' => $designer_id, 'date' => $today, 'status' => "approved"))->result_array();
				
			}
			//$total_QA = count($cp_id);
				$total_QA = count($cp_id1) ;
			foreach($cat_result as $row2)
			{
				$w_h = 0;
				$category = $this->db->get_where('print',array('name' => $row2['category']))->result_array();
				
				$pub_nj = $pub_nj + $category[0]['wt'];	//new job weightage for NJ calc
				if($row2['shift_factor']!='0'){
					if($additional_hrs){
						$dp_sft = $dp_sft + ($category[0]['wt'] / ($row2['shift_factor'] + $additional_hrs[0]['hours'])); //new job DP calculation (dp=nj/(shift_factor+$additional_hrs))
					}else{
						$dp_sft = $dp_sft + ($category[0]['wt'] / $row2['shift_factor']); //new job DP calculation (dp=nj/shift_factor)
					}
				}
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
					
					$pub_nj = $pub_nj + $cat_wt[0]['wt']; //rev & sold job weightage for NJ calculation
					if($row3['shift_factor']!='0')
					{
						if($additional_hrs){
							$dp_sft = $dp_sft + ($cat_wt[0]['wt'] / ($row3['shift_factor'] + $additional_hrs[0]['hours'])); //new job DP calculation (dp=nj/(shift_factor+$additional_hrs))
						}else{
							$dp_sft = $dp_sft + ($cat_wt[0]['wt'] / $row3['shift_factor']); //new job DP calculation (dp=nj/shift_factor)
						}
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
			/* if(isset($from) && isset($to))
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
			} */
			
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
				
				//error category weightage
				$minor_error = $this->db->query("SELECT * FROM `cp_error_result` WHERE `cp_result_id`='$cid' AND `error_degree`='1' ;")->result_array();
				$major_error = $this->db->query("SELECT * FROM `cp_error_result` WHERE `cp_result_id`='$cid' AND `error_degree`='2' ;")->result_array();
				
				if(count($major_error)!='0')
				{ 
					$error_catwt = $error_catwt + ($major_error[0]['error_catwt']*2); 
				}elseif(count($minor_error)=='1')
				{ 
					$error_catwt = $error_catwt + $minor_error[0]['error_catwt'] ; 
				}elseif(count($minor_error)>='2')
				{
					$error_catwt = $error_catwt + ($minor_error[0]['error_catwt']*2);
				}
				//error category weightage END
				
				foreach($err_design_min as $min1)		//design type error
				{
					$designerr_min_count++;
					//$error_catwt = $error_catwt + $min1['error_catwt'];
				}
				foreach($err_design_major as $major1)
				{
					$designerr_major_count++;
					//$error_catwt = $error_catwt + ($major1['error_catwt']*2);
				}
				foreach($err_tech_min as $min2)			//tech type error
				{
					$techerr_min_count++;
					//$error_catwt = $error_catwt + $min2['error_catwt'];
				}
				foreach($err_tech_major as $major2)
				{
					$techerr_major_count++;
					//$error_catwt = $error_catwt + ($major2['error_catwt']*2);
				}
				foreach($err_text_min as $min3)			//text type error
				{
					$texterr_min_count++;
					//$error_catwt = $error_catwt + $min3['error_catwt'];
				}
				foreach($err_text_major as $major3)
				{
					$texterr_major_count++;
					//$error_catwt = $error_catwt + ($major3['error_catwt']*2);
				}
				foreach($err_visual_min as $min4)			//visual type error
				{
					$visualerr_min_count++;
					//$error_catwt = $error_catwt + $min4['error_catwt'];
				}
				foreach($err_visual_major as $major4)
				{
					$visualerr_major_count++;
					//$error_catwt = $error_catwt + ($major4['error_catwt']*2);
				}
	
			}
	
		$tot_minor =  $designerr_min_count + $techerr_min_count + $visualerr_min_count + $texterr_min_count  ;
		$tot_major =  $designerr_major_count + $techerr_major_count + $visualerr_major_count + $texterr_major_count ;
	
		
	?>    									
											<tr class="odd gradeX">
												<!--<td><?php echo $row['id']; ?></td>-->
												<td><?php echo $row['name']; ?></td>
												<td><?php echo $row['username']; ?></td>
												<td><?php echo $bg_grp[0]['name']; ?></td>
												<td><?php echo $team_lead[0]['first_name']; ?></td>
												<td><?php echo $job_count; ?></td>
												<td><?php echo $total_QA; ?></td>
												<td><?php echo $pub_nj; ?></td>
												<!--<td><?php echo $avg_tt; ?></td>-->
												<td><?php echo round($dp_sft,2); ?></td>
												<td><?php echo $cat_a; ?></td>
												<td><?php echo $cat_b; ?></td>
												<td><?php echo $cat_c; ?></td>
												<td><?php echo $cat_d; ?></td>
												<td><?php echo $cat_e; ?></td>
												<td><?php echo $cat_f; ?></td>
												<td><?php echo $cat_g; ?></td>
												<td><?php echo $cat_rev; ?></td>
												<td><?php echo $cat_sold; ?></td>
												<td><?php echo $tot_minor; ?></td>
												<td><?php echo $tot_major; ?></td>
												<td><?php echo $error_catwt; ?></td>
											</tr>
<?php
/*
$data = array(
   'designer' => $row['id'] ,
   'bg' => $bg_grp[0]['id'],
   'teamlead' => $team_lead[0]['id'],
   'tot_ads' => $job_count,
   'tot_QA' => $total_QA,
   'tot_NJ' => $pub_nj,
   'avg_dp' => $avg_tt,
   'cat_A' => $cat_a,
   'cat_B' => $cat_b,
   'cat_C' => $cat_c,
   'cat_D' => $cat_d,
   'cat_E' => $cat_e,
   'cat_F' => $cat_f,
   'cat_G' => $cat_g,
   'cat_RJ' => $cat_rev,
   'cat_SJ' => $cat_sold,
   'tot_err_minor' => $tot_minor,
   'tot_err_major' => $tot_major,
);

$this->db->insert('Designer_Production', $data); 
*/
 }?>											
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