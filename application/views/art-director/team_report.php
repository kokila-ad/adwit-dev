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

   		$( "#from_date" ).datepicker({ minDate: "-8D", maxDate: 0, dateFormat: 'yy-mm-dd' });
		
		$( "#to_date" ).datepicker({ minDate: "-8D", maxDate: 0, dateFormat: 'yy-mm-dd'});
		
		
		
	});

</script> 

<div id="Middle-Div">
<div style="padding-left: 30px; padding-top: 20px;">
    <form method="post" style="padding:0; margin:0;">
      <span>From &nbsp;</span>
      <input type="text" name="from_date" id="from_date" placeholder="YYYY-MM-DD" style="border: thin solid #CCC; padding:5px; outline: none; margin:0;"/>
      &nbsp;&nbsp;<span>To &nbsp;</span>
      <input type="text" id="to_date" name="to_date" placeholder="YYYY-MM-DD" style="border: thin solid #CCC; padding:5px; outline: none; margin:0;"/>
      <input type="submit" value="Submit" />
    </form>
</div>
<div class="row-fluid" style="width:96%; margin: 0 auto;">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Team Report : <?php if(isset($from) && isset($to)){echo $from." to ".$to;}else{ echo $today; } ?></div>
							<div style="float: right;"><input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Export to Excel" /></div>	
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
										<thead>
											<tr>
												<th> Designer</th>
												<th> Code</th>
												<th>Team1</th>
												<th>Team2</th>
												<th>Team3</th>
												<th>Team4</th>
                                                <th>Team5</th>
												
											</tr>
										</thead>
										<tbody name="testTable" id="testTable">
<?php foreach($designer as $row){
		if(isset($from) && isset($to))
		{	
			$team1 = $this->db->query("SELECT * FROM `cat_result` WHERE `designer`= ".$row['id']." AND `team`= '1' AND (`date` BETWEEN '$from' AND '$to') ;")->result_array();
			$team2 = $this->db->query("SELECT * FROM `cat_result` WHERE `designer`= ".$row['id']." AND `team`= '2' AND (`date` BETWEEN '$from' AND '$to') ;")->result_array();
			$team3 = $this->db->query("SELECT * FROM `cat_result` WHERE `designer`= ".$row['id']." AND `team`= '3' AND (`date` BETWEEN '$from' AND '$to') ;")->result_array();
			$team4 = $this->db->query("SELECT * FROM `cat_result` WHERE `designer`= ".$row['id']." AND `team`= '4' AND (`date` BETWEEN '$from' AND '$to') ;")->result_array();
			$team5 = $this->db->query("SELECT * FROM `cat_result` WHERE `designer`= ".$row['id']." AND `team`= '5' AND (`date` BETWEEN '$from' AND '$to') ;")->result_array();
			
		}else{
			$team1 = $this->db->get_where('cat_result',array('designer' => $row['id'], 'team' => '1', 'ddate' => $today))->result_array();
			$team2 = $this->db->get_where('cat_result',array('designer' => $row['id'], 'team' => '2', 'ddate' => $today))->result_array();
			$team3 = $this->db->get_where('cat_result',array('designer' => $row['id'], 'team' => '3', 'ddate' => $today))->result_array();
			$team4 = $this->db->get_where('cat_result',array('designer' => $row['id'], 'team' => '4', 'ddate' => $today))->result_array();
			$team5 = $this->db->get_where('cat_result',array('designer' => $row['id'], 'team' => '5', 'ddate' => $today))->result_array();
		}
?>									
											<tr class="odd gradeX">
											<td><?php echo $row['name']; ?></td>
												<td><?php echo $row['username']; ?></td>
												<td><?php echo count($team1); ?></td>
												<td><?php echo count($team2); ?></td>
												<td><?php echo count($team3); ?></td>
												<td> <?php echo count($team4); ?></td>
                                                <td> <?php echo count($team5); ?></td>
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