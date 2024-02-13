<?php
       $this->load->view("designer/header");
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
		<!-- <form method="post" style="padding:0; margin:0;">
		<span>From &nbsp;</span><input type="text" name="from_date" id="from_date" placeholder="YYYY-MM-DD" style="border: thin solid #CCC; padding:5px; outline: none; margin:0;"/> &nbsp;&nbsp;<span>To &nbsp;</span><input type="text" id="to_date" name="to_date" placeholder="YYYY-MM-DD" style="border: thin solid #CCC; padding:5px; outline: none; margin:0;"/>
		<input type="submit" value="Submit" />
		</form> -->
   </div>
     <div class="row-fluid" style="width:96%; margin: 0 auto;">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Production : <?php if(isset($from) && isset($to)){echo $from." to ".$to;}else{echo $today;} ?> </div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
										<thead>
                                        <tr>
												<th rowspan="2" style="vertical-align: middle;">Name</th>
												<th rowspan="2"style="vertical-align: middle;">Code</th>
												
												<th colspan="3" style="text-align: center;">Total</th>
												<th rowspan="2"style="vertical-align: middle;">Avg Dp</th>
												<th colspan="9"style="text-align: center;">Category</th>
											</tr>
											<tr>
												<th> Ads</th>
												<th>NJ</th>
                                                <th>QA</th>
												<th>A</th>
												<th>B</th>
                                                <th>C</th>
												<th>D</th>
                                                <th>E</th>
												<th>F</th>
												<th>G</th>
                                                <th>RJ</th>
												<th>SJ</th>
											</tr>
										</thead>
										<tbody>
<?php

foreach($designer as $row)
{	
	$team_lead = $this->db->get_where('team_lead',array('id' => $row['design_team_lead']))->result_array();
	$pub_nj = 0; $job_count = 0; $sq_inches = 0; $tot_QA = 0; 
	$cat_a = 0; $cat_b = 0; $cat_c = 0; $cat_d = 0; $cat_e = 0; $cat_f = 0; $cat_g = 0; $cat_rev = 0; $cat_sold = 0;
	
			$designer_id = $row['id'];
			if(isset($from) && isset($to))
			{
				$cat_result = 	$this->db->query("SELECT * FROM `cat_result` WHERE  `designer`='$designer_id' AND `ddate` BETWEEN '$from' AND '$to' ;")->result_array();
				$rev_sold = $this->db->query("SELECT * FROM `ptrands` WHERE  `designer`='$designer_id' AND `date` BETWEEN '$from' AND '$to' ;")->result_array();
				$cp_id = $this->db->query("SELECT * FROM `cp_tool` WHERE `designer`='$designer_id' AND `date` BETWEEN '$from' AND '$to' ;")->result_array();	//total QA
			}else{
				$cat_result = $this->db->get_where('cat_result',array('designer' => $designer_id, 'ddate' => $today))->result_array();
				$rev_sold = $this->db->query("SELECT * FROM `ptrands` WHERE  `designer`='$designer_id' AND `date`='$today' ;")->result_array();
				$cp_id = $this->db->query("SELECT * FROM `cp_tool` WHERE `designer`='$designer_id' AND `date`='$today' ;")->result_array();
			}
	$tot_QA = count($cp_id);	
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
	
		
	?>    									
											<tr class="odd gradeX">
												<!--<td><?php echo $row['id']; ?></td>-->
												<td><?php echo $row['name']; ?></td>
												<td><?php echo $row['username']; ?></td>
												<!--<td><?php echo $team_lead[0]['first_name']; ?></td>-->
												<td><?php echo $job_count; ?></td>
												<td><?php echo $pub_nj; ?></td>
                                                <td><?php echo $tot_QA; ?></td>
												<td><?php echo $avg_tt; ?></td>
												<td><?php echo $cat_a; ?></td>
												<td><?php echo $cat_b; ?></td>
												<td><?php echo $cat_c; ?></td>
												<td><?php echo $cat_d; ?></td>
												<td><?php echo $cat_e; ?></td>
												<td><?php echo $cat_f; ?></td>
												<td><?php echo $cat_g; ?></td>
												<td><?php echo $cat_rev; ?></td>
												<td><?php echo $cat_sold; ?></td>
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
       $this->load->view("designer/footer");
?>










