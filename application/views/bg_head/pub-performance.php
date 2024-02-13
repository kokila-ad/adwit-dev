<?php
       $this->load->view("bg_head/header");
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
                                <div class="muted pull-left">Publication Performance : <?php if(isset($from) && isset($to)){echo $from." to ".$to;}else{echo $today;} ?> </div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
										<thead>
											<tr>
												<th rowspan="2" style="vertical-align: middle;">Publication</th>
												<!--<th>Business Group</th>-->
											
												<th colspan="7" style="text-align: center;">Category (Job Count)</th>
												<th colspan="3" style="text-align: center;">Total</th>
                                                <th colspan="7" style="text-align: center;">Category (Sq. In.)</th>
											</tr>
                                            <tr>
												<!--<th>Business Group</th>-->
												<th>A</th>
												<th>B</th>
                                                <th>C</th>
												<th>D</th>
                                                <th>E</th>
												<th>F</th>
												<th>G</th>
                                                <th>Jobs</th>
                                                <th>NJ</th>
                                                <th>Sq. in.</th>
                                                <th>A</th>
                                                <th>B</th>
                                                <th>C</th>
                                                <th>D</th>
                                                <th>E</th>
                                                <th>F</th>
                                                <th>G</th>
                                            </tr>
										</thead>
										<tbody>
<?php

foreach($publication as $row)
{	
	
	$pub_nj = 0; $job_count = 0; $sq_inches = 0;
	$cat_a = 0; $cat_b = 0; $cat_c = 0; $cat_d = 0; $cat_e = 0; $cat_f = 0; $cat_g = 0; $cat_rev = 0; $cat_sold = 0;
	$cat_a_sq = 0; $cat_b_sq = 0; $cat_c_sq = 0; $cat_d_sq = 0; $cat_e_sq = 0; $cat_f_sq = 0; $cat_g_sq = 0;
			$news_id = $row['id'];
			if(isset($from) && isset($to))
			{
				$cat_result = 	$this->db->query("SELECT * FROM `cat_result` WHERE  `news_id`='$news_id' AND `ddate` BETWEEN '$from' AND '$to' ;")->result_array();
			}else{
				$cat_result = $this->db->get_where('cat_result',array('news_id' => $news_id, 'ddate' => $today))->result_array();
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
					$cat_a_sq = $cat_a_sq + ($row2['width'] * $row2['height']); 
				}
				if($row2['category'] == 'B')
				{
					$cat_b++;
					$cat_b_sq = $cat_b_sq + ($row2['width'] * $row2['height']);
				}
				if($row2['category'] == 'C' || $row2['category'] == 'c')
				{
					$cat_c++;
					$cat_c_sq = $cat_c_sq + ($row2['width'] * $row2['height']);
				}
				if($row2['category'] == 'D')
				{
					$cat_d++;
					$cat_d_sq = $cat_d_sq + ($row2['width'] * $row2['height']);
				}
				if($row2['category'] == 'E')
				{
					$cat_e++;
					$cat_e_sq = $cat_e_sq + ($row2['width'] * $row2['height']);
				}
				if($row2['category'] == 'F')
				{
					$cat_f++;
					$cat_f_sq = $cat_f_sq + ($row2['width'] * $row2['height']);
				}
				if($row2['category'] == 'G')
				{
					$cat_g++;
					$cat_g_sq = $cat_g_sq + ($row2['width'] * $row2['height']);
				}
				if($row2['category'] == 'REVISION')
				{
					$cat_rev++;
					$cat_rev_sq = $cat_rev_sq + ($row2['width'] * $row2['height']);
				}
				if($row2['category'] == 'SOLD')
				{
					$cat_sold++;
					$cat_sold_sq = $cat_sold_sq + ($row2['width'] * $row2['height']);
				}
				
			}
	
	?>    									
											<tr class="odd gradeX">
												<td><?php echo $row['name']; ?></td>
												<!--<td><?php echo $bg[0]['name']; ?></td>-->
												<td><?php echo $cat_a; ?></td>
												<td><?php echo $cat_b; ?></td>
												<td><?php echo $cat_c; ?></td>
												<td><?php echo $cat_d; ?></td>
												<td><?php echo $cat_e; ?></td>
												<td><?php echo $cat_f; ?></td>
												<td><?php echo $cat_g; ?></td>
												<td><?php echo $job_count; ?></td>
												<td><?php echo $pub_nj; ?></td>
												<td><?php echo round($sq_inches,2); ?></td>
												<td><?php echo round($cat_a_sq,2); ?></td>
												<td><?php echo round($cat_b_sq,2); ?></td>
												<td><?php echo round($cat_c_sq,2); ?></td>
												<td><?php echo round($cat_d_sq,2); ?></td>
												<td><?php echo round($cat_e_sq,2); ?></td>
												<td><?php echo round($cat_f_sq,2); ?></td>
												<td><?php echo round($cat_g_sq,2); ?></td>
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
       $this->load->view("bg_head/footer");
?>










