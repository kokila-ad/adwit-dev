<?php
       $this->load->view("team-lead/header");
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
		<form id="search" name="search" method="post" style="padding:0; margin:0;">
		<span>From &nbsp;</span><input type="text" name="from_date" id="from_date" placeholder="YYYY-MM-DD" style="border: thin solid #CCC; padding:5px; outline: none; margin:0;"/> &nbsp;&nbsp;<span>To &nbsp;</span><input type="text" id="to_date" name="to_date" placeholder="YYYY-MM-DD" style="border: thin solid #CCC; padding:5px; outline: none; margin:0;"/>
		<input type="submit" value="Submit" />
		</form>
   </div>
   <div class="row-fluid" style="width:96%; margin: 0 auto;">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">QA Report : <?php if(isset($from) && isset($to)){echo $from." to ".$to;}else{echo "Last 3 Days";} ?></div>
                                <div style="float: right;"><input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Export to Excel" /></div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                                                                        				<thead>
                                        	<tr>
                                            <th>Date</th>
                                            <th>Designer</th>
                                            <th>Code</th>
                                            <th>Slug</th>
                                            <th>Error List</th>
											</tr>
										</thead>

										<tbody name="testTable" id="testTable">
<?php 
		
	foreach($designer as $row)
	{
		$designer = $row['id'];
		if(isset($from) && isset($to))
		{
			$cp_id = $this->db->query("SELECT * FROM `cp_tool` WHERE `designer`='$designer' AND `date` BETWEEN '$from' AND '$to' ;")->result_array();
		}else{
			$cp_id = $this->db->query("SELECT * FROM `cp_tool` WHERE `time_stamp` LIKE '%$pystday%' AND `designer`='$designer' OR  `time_stamp` LIKE '%$ystday%' AND `designer`='$designer' OR  `time_stamp` LIKE '%$tday%' AND `designer`='$designer' AND `job_status`='completed' ;")->result_array();
		}
		foreach($cp_id as $row1)
		{	
		
			$designer = $this->db->get_where('designers',array('id' => $row1['designer']))->result_array();
			$cid = $row1['id'];
			$err = $this->db->query("SELECT * FROM `cp_error_result` WHERE `cp_result_id`='$cid' AND `error_name`!='28' ;")->result_array();
			$slug = $this->db->get_where('cat_result',array('order_no'=>$row1['order_no']))->result_array();
			if($err)
			{
			
?>											
											<tr class="odd gradeX">
                                            <td><?php echo $row1['date']; ?></td>
                                                <td><?php if($designer){echo $designer[0]['name'];}else{echo "undefined";} ?></td>
                                                <td><?php if($designer){echo $designer[0]['username'];}else{echo "undefined";} ?></td>
												<td><?php if($slug){echo $slug[0]['slug'];}else{echo "undefined";} ?></td>
<td>
<?php
	
	foreach($err as $row2)
	{
		$error_name = $this->db->get_where('dp_error',array('id'=>$row2['error_name']))->result_array();
		$error_degree = $this->db->get_where('dp_error_degree',array('id'=>$row2['error_degree']))->result_array();
		echo $error_name[0]['name']." - ".$error_degree[0]['name']."<br/>";
	}			

?>	
</td>				
										</tr>
<?php } } } ?>										
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
       $this->load->view("team-lead/footer");
?>