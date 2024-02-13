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
												
												<th colspan="2"style=" text-align: center;">Total Error</th>
											</tr>
                                            <tr>
												<!--<th>ID</th>-->
												<th>Name</th>
												<th>Code</th>
												
												<th>QA</th>
												
                                                <th>MinorTOT</th>
												<th>MajorTOT</th>
												
												<th>Perfect</th>
											</tr>
										</thead>
										<tbody name="testTable" id="testTable">
<?php

foreach($designer as $row)
{	
	
	$total_QA = 0;
	
	 $tot_minor_count = 0; $tot_major_count = 0; $tot_perfect_count = 0;
	
			$designer_id = $row['id'];
			if(isset($from) && isset($to))
			{
				$cp_id = $this->db->query("SELECT * FROM `cp_tool` WHERE `designer`='$designer_id' AND `date` BETWEEN '$from' AND '$to' ;")->result_array();			
			}else{
				$cp_id = $this->db->query("SELECT * FROM `cp_tool` WHERE `designer`='$designer_id' AND `date`='$today' ;")->result_array();
			}
			$total_QA = count($cp_id);	
			
			
	//minor major error
			foreach($cp_id as $row1)
			{
				$minor_count = 0; $major_count = 0; 
				
				$cid = $row1['id'];
				
				$minor_err = $this->db->query("SELECT * FROM `cp_error_result` WHERE `cp_result_id`='$cid' AND `error_degree`='1' AND (`error_type`='1' OR `error_type`='2' OR `error_type`='3' OR `error_type`='4' OR `error_type`='6' OR `error_type`='7') ;")->result_array();
				
				$major_err = $this->db->query("SELECT * FROM `cp_error_result` WHERE `cp_result_id`='$cid' AND `error_degree`='2' AND (`error_type`='1' OR `error_type`='2' OR `error_type`='3' OR `error_type`='4' OR `error_type`='6' OR `error_type`='7') ;")->result_array();
			
				//$perfect_err = $this->db->query("SELECT * FROM `cp_error_result` WHERE `cp_result_id`='$cid' AND (`error_degree`='3' OR `error_type`='5') ;")->result_array();
			
				foreach($minor_err as $x)
				{
					$minor_count++;
				}
				foreach($major_err as $y)
				{
					$major_count++;
				}
			/*	foreach($perfect_err as $z)
				{
					$perfect_count++;
				}
			*/
				if($minor_count>1){ $major_count++; $minor_count=0;}
				if($major_count>1){ $major_count=1; }
				
				$tot_minor_count = $tot_minor_count + $minor_count ; 
				$tot_major_count = $tot_major_count + $major_count ;
			}
			
			
			$tot_perfect_count = $total_QA - ($tot_minor_count + $tot_major_count);
	
	?>    									
											<tr class="odd gradeX">
												<!--<td><?php echo $row['id']; ?></td>-->
												<td><?php echo $row['name']; ?></td>
												<td><?php echo $row['username']; ?></td>
												
												<td><?php echo $total_QA; ?></td>
												
												<td><?php echo $tot_minor_count; ?></td>
												<td><?php echo $tot_major_count; ?></td>
												
												<td><?php echo $tot_perfect_count; ?></td>
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