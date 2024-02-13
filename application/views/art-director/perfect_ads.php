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

   		$( "#from_date" ).datepicker({ minDate: "-6M", maxDate: -1, dateFormat: 'yy-mm-dd' });
		
		$( "#to_date" ).datepicker({ minDate: "-6M", maxDate: -1, dateFormat: 'yy-mm-dd'});
		
		
		
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
                            <div class="muted pull-left">Production : <?php if(isset($from) && isset($to)){echo $from." to ".$to;}else{echo $ystday;} ?> </div>
                            <div style="float: right;"><input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Export to Excel" /></div>
						</div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
										<thead>
											<tr>
												<th rowspan="2" style=" text-align: center;">Designer Code</th>
												<th rowspan="2" style=" text-align: center;">Designer Name</th>
												<th rowspan="2" style=" vertical-align: middle;">Total ADs</th>
												<th rowspan="2" style=" text-align: center;">Total NJ</th>
												<th rowspan="2" style=" text-align: center;">PP NJ</th>
												<th rowspan="2" style=" text-align: center;">% Perfect Ads</th>
												<th rowspan="2" style=" text-align: center;">DP</th>
											</tr>
                                           
										</thead>
										<tbody name="testTable" id="testTable">
<?php

foreach($designer as $row)
{	
	$designer_id = $row['id'];
	
	
	if(isset($from) && isset($to))
	{
		$result = $this->db->query("SELECT * FROM `Designer_Production` WHERE `designer`='$designer_id' AND `date` BETWEEN '$from' AND '$to' ;")->result_array();
	}else{
		$result = $this->db->get_where('Designer_Production',array('designer'=>$designer_id, 'date' => $ystday))->result_array();
	}
	$tot_ads = 0; $tot_NJ = 0; $perfect_ads = 0; $avg_dp = 0; $error_catwt = 0;
	 foreach($result as $row1)
	{
		$tot_ads = $tot_ads + $row1['tot_ads'];
		$tot_NJ = $tot_NJ + $row1['tot_NJ'];
		$perfect_ads = $perfect_ads + ($row1['tot_ads'] - ($row1['tot_err_minor'] + $row1['tot_err_major']));
		$avg_dp = $avg_dp + $row1['avg_dp'];
		$error_catwt = $error_catwt + $row1['error_catwt'];
	} 
	?>    									
											<tr class="odd gradeX">
												<td><?php echo $row['id']; ?></td>
												<!--<td><?php echo $row['username']; ?></td>-->
												<td><?php echo $row['name']; ?></td>
												<td><?php echo $tot_ads; ?></td>
												<td><?php echo $tot_NJ; ?></td>
												<td><?php echo $tot_NJ - $error_catwt; ?></td>
												<td><?php if($tot_ads != 0){ echo round(($perfect_ads / $tot_ads)*100, 2) ."%"; }else{ echo "0"; } ?></td>
												<td><?php echo round($avg_dp, 2); ?></td>
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
       $this->load->view("art-director/footer");
?>