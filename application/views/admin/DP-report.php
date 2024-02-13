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
                                <div class="muted pull-left">Designer Total Dp : <?php if(isset($from) && isset($to)){echo $from." to ".$to;}else{echo $prev_month;} ?> </div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
										<thead>
											<tr>
												<th>Designer</th>
												<th>Code</th>
												<th>Total NJ</th>
												<th>Average DP</th>
											</tr>
										</thead>
										<tbody>
<?php 

foreach($designer as $row)
{
	$id = $row['id'];
	if(isset($from) && isset($to))
	{
		$dp = 	$this->db->query("SELECT * FROM `designer_dp` WHERE  `designer`='$id' AND `date` BETWEEN '$from' AND '$to' ;")->result_array();
	}else{
		$dp = 	$this->db->query("SELECT * FROM `designer_dp` WHERE `designer`='$id' AND `date` LIKE '%$prev_month%' ;")->result_array();
	}
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
	?>									
											<tr class="odd gradeX">
												<td><?php echo $row['name']; ?></td>
												<td><?php echo $row['username']; ?></td>
												<td><?php echo $sum_nj; ?></td>
												<td class="center"> <?php echo $avg_tt; ?></td>
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