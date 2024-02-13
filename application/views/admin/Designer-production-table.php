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
		<span>From &nbsp;</span><input type="text" name="from_date" id="from_date" placeholder="YYYY-MM-DD" readonly='readonly' style="border: thin solid #CCC; padding:5px; outline: none; margin:0;"/> &nbsp;&nbsp;<span>To &nbsp;</span><input type="text" id="to_date" name="to_date" readonly='readonly' placeholder="YYYY-MM-DD" style="border: thin solid #CCC; padding:5px; outline: none; margin:0;"/>
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
												<!--<th>ID</th>-->
												<th colspan="2" style=" text-align: center;">Designer</th>
												<!--<th rowspan="2" style=" vertical-align: middle;">BG</th>-->
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
	
	$tot_ads=0; $tot_QA=0; $tot_NJ=0; $avg_dp=0; $count=0;
	$cat_A=0; $cat_B=0; $cat_C=0; $cat_D=0; $cat_E=0; $cat_F=0; $cat_G=0; $cat_RJ=0; $cat_SJ=0;
	$tot_err_minor=0; $tot_err_major=0;
	foreach($result as $row1)
	{
		$team_lead = $this->db->get_where('team_lead',array('id'=>$row1['teamlead']))->result_array(); 
		$tot_ads = $tot_ads + $row1['tot_ads'];
		$tot_QA = $tot_QA + $row1['tot_QA'];
		$tot_NJ = $tot_NJ + $row1['tot_NJ'];
		$avg_dp = $avg_dp + $row1['avg_dp'];
		
		$cat_A = $cat_A + $row1['cat_A'];
		$cat_B = $cat_B + $row1['cat_B'];
		$cat_C = $cat_C + $row1['cat_C'];
		$cat_D = $cat_D + $row1['cat_D'];
		$cat_E = $cat_E + $row1['cat_E'];
		$cat_F = $cat_F + $row1['cat_F'];
		$cat_G = $cat_G + $row1['cat_G'];
		$cat_RJ = $cat_RJ + $row1['cat_RJ'];
		$cat_SJ = $cat_SJ + $row1['cat_SJ'];
		
		$tot_err_minor = $tot_err_minor + $row1['tot_err_minor'];
		$tot_err_major = $tot_err_major + $row1['tot_err_major'];
		$count++;
	}
	?>    									
											<tr class="odd gradeX">
												<!--<td><?php echo $row['id']; ?></td>-->
												<td><?php echo $row['name']; ?></td>
												<td><?php echo $row['username']; ?></td>
												
												<!--<td><?php echo $bg_grp[0]['name']; ?></td>-->
												<td><?php if($result)echo $team_lead[0]['first_name']; ?></td>
												
												<td><?php echo $tot_ads; ?></td>
												<td><?php echo $tot_QA; ?></td>
												<td><?php echo $tot_NJ; ?></td>
												<td><?php if($count!='0')echo round($avg_dp/$count,2); ?></td>
												<td><?php echo $cat_A; ?></td>
												<td><?php echo $cat_B; ?></td>
												<td><?php echo $cat_C; ?></td>
												<td><?php echo $cat_D; ?></td>
												<td><?php echo $cat_E; ?></td>
												<td><?php echo $cat_F; ?></td>
												<td><?php echo $cat_G; ?></td>
												<td><?php echo $cat_RJ; ?></td>
												<td><?php echo $cat_SJ; ?></td>
												<td><?php echo $tot_err_minor; ?></td>
												<td><?php echo $tot_err_major; ?></td>
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