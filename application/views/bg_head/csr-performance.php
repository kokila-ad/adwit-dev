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
                                <div class="muted pull-left">CSR Performance : <?php if(isset($from) && isset($to)){echo $from." to ".$to;}else{echo $today;} ?> </div>
                            <div style="float: right;"><input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Export to Excel" /></div>
							</div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
										<thead>
											<tr>
												<th rowspan="2" style="vertical-align: middle;">CSR</th>
											
												<th colspan="7" style=" text-align: center;">Catergory(QA)</th>
												<th colspan="2" style=" text-align: center;">Total</th>
                                                <th rowspan="2" style="vertical-align: middle;">Revision</th>
                                            </tr>
                                            <tr>
												<th>A</th>
												<th>B</th>
                                                <th>C</th>
												<th>D</th>
                                                <th>E</th>
												<th>F</th>
												<th>G</th>
                                                <th style=" text-align: center;">QA</th>
                                                <th style=" text-align: center;">Categorised</th>
                                            </tr>
										</thead>
										<tbody name="testTable" id="testTable">
<?php

foreach($csr as $row)
{	
	
	$pub_nj = 0; $cat_job_count = 0; $sq_inches = 0; $cp_job_count = 0;
	$cat_a = 0; $cat_b = 0; $cat_c = 0; $cat_d = 0; $cat_e = 0; $cat_f = 0; $cat_g = 0; $cat_rev = 0; $cat_sold = 0;
	
			$csr_id = $row['id'];
			if(isset($from) && isset($to))
			{
				$cat_result = $this->db->query("SELECT * FROM `cat_result` WHERE  `csr`='$csr_id' AND `date` BETWEEN '$from' AND '$to' ;")->result_array();
				$cp = $this->db->query("SELECT * FROM `cp_tool` WHERE  `csr`='$csr_id' AND `date` BETWEEN '$from' AND '$to' ;")->result_array();
				$rev_sold = $this->db->query("SELECT * FROM `ptrands` WHERE  `csr`='$csr_id' AND `date` BETWEEN '$from' AND '$to' ;")->result_array();			
			}else{
				$cat_result = $this->db->get_where('cat_result',array('csr' => $csr_id, 'date' => $today))->result_array();
				$cp = $this->db->get_where('cp_tool',array('csr' => $csr_id, 'date' => $today))->result_array();
				$rev_sold = $this->db->query("SELECT * FROM `ptrands` WHERE  `csr`='$csr_id' AND `date`='$today' ;")->result_array();
			}
			$cat_job_count = count($cat_result);
			$cp_job_count = count($cp);
			foreach($cp as $row2)
			{
				$cat = $this->db->get_where('cat_result',array('order_no' => $row2['order_no']))->result_array();
				
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
	
	?>    									
											<tr class="odd gradeX">
												<td><?php echo $row['name']; ?></td>
												
												<td><?php echo $cat_a; ?></td>
												<td><?php echo $cat_b; ?></td>
												<td><?php echo $cat_c; ?></td>
												<td><?php echo $cat_d; ?></td>
												<td><?php echo $cat_e; ?></td>
												<td><?php echo $cat_f; ?></td>
												<td><?php echo $cat_g; ?></td>
												<td><?php echo $cp_job_count; ?></td>
												<td><?php echo $cat_job_count; ?></td>
												<td><?php echo $cat_rev; ?></td>
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
       $this->load->view("bg_head/footer");
?>










