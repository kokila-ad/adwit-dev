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
                            <div class="muted pull-left">Date : <?php if(isset($from) && isset($to)){echo $from." to ".$to;}else{echo $today;} ?> </div>
                            <div style="float: right;"><input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Export to Excel" /></div>
						</div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
										<thead>
											<tr>
												<!--<th>ID</th>-->
												<th colspan="2" style=" text-align: center;">Deseigner</th>
												<th colspan="2" style=" text-align: center;">Total New Ads</th>
												<th colspan="2" style=" text-align: center;">Total Revision</th>
												<th colspan="2" style=" text-align: center;">Total Sold</th>
												<th colspan="2" rowspan="2" style=" text-align: center;">Total NJ</th>
											</tr>
                                            <tr>
												<!--<th>ID</th>-->
												<th>Name</th>
												<th>Code</th>
												<th> Nos</th>
												<th>NJ</th>
												<th> Nos</th>
												<th>NJ</th>
												<th> Nos</th>
												<th>NJ</th>
											</tr>
										</thead>
										<tbody name="testTable" id="testTable">
										
<?php

foreach($designer as $row)
{	
	$tot_nj = 0; $new_nj = 0; $rev_sold_nj = 0; $rev_nj = 0; $sold_nj = 0; $job_count = 0; $sq_inches = 0; $total_QA = 0;
	$cat_a = 0; $cat_b = 0; $cat_c = 0; $cat_d = 0; $cat_e = 0; $cat_f = 0; $cat_g = 0; $cat_rev = 0; $cat_sold = 0;
	
	
			$designer_id = $row['id'];
			if(isset($from) && isset($to))
			{
				$cat_result = 	$this->db->query("SELECT * FROM `cat_result` WHERE  `designer`='$designer_id' AND `ddate` BETWEEN '$from' AND '$to' ;")->result_array();
				$rev_sold = $this->db->query("SELECT * FROM `ptrands` WHERE  `designer`='$designer_id' AND `date` BETWEEN '$from' AND '$to' ;")->result_array();
				
			}else{
				$cat_result = $this->db->get_where('cat_result',array('designer' => $designer_id, 'ddate' => $today))->result_array();
				$rev_sold = $this->db->query("SELECT * FROM `ptrands` WHERE  `designer`='$designer_id' AND `date`='$today' ;")->result_array();
				//$rev_sold = $this->db->get_where('ptrands',array('designer' => $designer_id, 'date' => $today))->result_array();			
			}
			
			foreach($cat_result as $row2)
			{
				$w_h = 0;
				$category = $this->db->get_where('print',array('name' => $row2['category']))->result_array();
				$tot_nj = $tot_nj + $category[0]['wt'];
				$new_nj = $new_nj + $category[0]['wt'];
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
					$rev_sold_nj = $rev_sold_nj + $cat_wt[0]['wt'];
					$tot_nj = $tot_nj + $cat_wt[0]['wt'];
					
					if($row3['category'] == 'REVISION')
					{
						$rev_nj = $rev_nj + $cat_wt[0]['wt'];
						$cat_rev++;
					}
					if($row3['category'] == 'SOLD')
					{
						$sold_nj = $sold_nj + $cat_wt[0]['wt'];
						$cat_sold++;
					}
				}
			}
			
	?>    									
											
										
											<tr class="odd gradeX">
												<td><?php echo $row['name']; ?></td>
												<td><?php echo $row['username']; ?></td>
												<td><?php echo $job_count; ?></td>
												<td><?php echo $new_nj; ?></td>
												<td><?php echo $cat_rev; ?></td>
												<td><?php echo $rev_nj; ?></td>
												<td><?php echo $cat_sold; ?></td>
												<td><?php echo $sold_nj; ?></td>
												<!--<td><?php //echo $rev_sold_nj; ?></td>-->
												<td><?php echo $tot_nj; ?></td>
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