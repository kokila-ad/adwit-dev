<?php
       $this->load->view("art-director/header");
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
     <div class="row-fluid" style="width:96%; margin: 0 auto;">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
							<div class="form">
							<form method="post">
							From<input type="text" name="from_date" id="from_date" /> To<input type="text" name="to_date" id="to_date" />
							<input type="submit" value="Submit" />
							</form> 
							</div>	
                                <div class="muted pull-left">Daily Report : <?php if(isset($from) && isset($to)){echo $from." to ".$to;}else{echo $today;} ?> </div>
								<div style="float: right;"><input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Export to Excel" /></div>
							</div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
										<thead>
											<tr>
												<th>Code</th>
												<th>Designer</th>
												<th>Total NJ</th>
												<th>Total DP</th>
												<th>No Of Jobs</th>
											</tr>
										</thead>
										<tbody name="testTable" id="testTable">
<?php 

foreach($designer as $row)
{
	$id = $row['id'];
	if(isset($from) && isset($to))
	{
		$dp = 	$this->db->query("SELECT * FROM `designer_dp` WHERE  `designer`='$id' AND `date` BETWEEN '$from' AND '$to' ;")->result_array();
	}else{
		$dp = 	$this->db->query("SELECT * FROM `designer_dp` WHERE `designer`='$id' AND `date`='$today' AND `job_status`='completed' ;")->result_array();
	}
	
	if(!$dp)
	{
		$sum_nj = '0'; $num_jobs = '0';$sum_tt = '0';
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
											<tr class="odd gradeX">
												<td><?php echo $row['username']; ?></td>
												<td><?php echo $row['name']; ?></td>
												<td><?php echo $sum_nj; ?></td>
												<td><?php echo round($sum_tt,2); ?></td>
												<td class="center"> <?php echo $num_jobs; ?></td>
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