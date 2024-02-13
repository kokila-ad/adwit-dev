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
                                <div class="muted pull-left">CSR Performance : <?php if(isset($from) && isset($to)){echo $from." to ".$to;}else{echo $ystday;} ?> </div>
                            <div style="float: right;"><input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Export to Excel" /></div>
							</div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
										<thead>
											<tr>
												<th rowspan="2" style="vertical-align: middle;">CSR</th>
											
												<!--<th colspan="7" style=" text-align: center;">Catergory(QA)</th>-->
												<th colspan="6" style=" text-align: center;">Total</th>
                                                <th rowspan="2" style="vertical-align: middle;">Final NJ</th>
                                            </tr>
                                            <tr>
											<!--
												<th>A</th>
												<th>B</th>
                                                <th>C</th>
												<th>D</th>
                                                <th>E</th>
												<th>F</th>
												<th>G</th>
												-->
                                                <th style=" text-align: center;">QA
<a onclick="window.open('<?php echo base_url().index_page().'admin/home/QA_performance/';?>')" style="cursor:pointer; text-decoration: none; color:#999;">(?)</a>																							
												</th>
											<!--<th style=" text-align: center;">QA_NJ</th> -->
                                                <th style=" text-align: center;">Categorised</th>
												<th style=" text-align: center;">Incoming
<a onclick="window.open('<?php echo base_url().index_page().'admin/home/incoming_performance/';?>')" style="cursor:pointer; text-decoration: none; color:#999;">(?)</a>												
												</th>
												<th style=" text-align: center;">Outgoing
<a onclick="window.open('<?php echo base_url().index_page().'admin/home/outgoing_performance/';?>')" style="cursor:pointer; text-decoration: none; color:#999;">(?)</a>																								
												</th>
												<th>Revision</th>
												<th>Uploads</th>
                                            </tr>
										</thead>
										<tbody name="testTable" id="testTable">
<?php

foreach($csr as $row)
{	
	$tot_QA = 0; $tot_categorised = 0; $tot_incoming = 0; $tot_outgoing = 0; $tot_revision = 0; $final_NJ = 0;
	$tot_upload = 0;
	$csr_id = $row['id'];
	if(isset($from) && isset($to))
	{
		$csr_performance = $this->db->query("SELECT * FROM `csr_performance` WHERE  `csr`='$csr_id' AND `date` BETWEEN '$from' AND '$to' ;")->result_array();
	}else{
		$csr_performance = $this->db->get_where('csr_performance',array('csr' => $csr_id, 'date' => $ystday))->result_array();
	}

	foreach($csr_performance as $row1)
	{
		$tot_QA = $tot_QA + $row1['tot_QA'];
		$tot_categorised = $tot_categorised + $row1['tot_categorised'];
		$tot_incoming = $tot_incoming + $row1['tot_incoming'];
		$tot_outgoing = $tot_outgoing + $row1['tot_outgoing'];
		$tot_revision = $tot_revision + $row1['tot_revision'];
		$tot_upload = $tot_upload + $row1['tot_upload'];
		$final_NJ = $final_NJ + $row1['final_NJ'];
	}
	
?>    									
											<tr class="odd gradeX">
												<td><?php echo $row['name']; ?></td>
												
												<td><?php echo $tot_QA; ?></td>
												
												<td><?php echo $tot_categorised; ?></td>
												<td><?php echo $tot_incoming; ?></td>
												<td><?php echo $tot_outgoing; ?></td>
												<td><?php echo $tot_revision; ?></td>
												<td><?php echo $tot_upload; ?></td>
												<td><?php echo round($final_NJ,2); ?></td>
												
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
       $this->load->view("admin/footer");
?>










