<?php
       $this->load->view("client/header1");
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
                               <div class="muted pull-left">Ads Report : <?php if(isset($from) && isset($to)){echo $from." to ".$to;}else{echo $today;} ?> </div>
								<div style="float: right;"><input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Export to Excel" /></div>
							</div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
										<thead>
											<tr>
												<th rowspan="2" style="vertical-align: middle;">Types</th>
												<th colspan="3"style="text-align: center;">No. of Ads</th>
												<th rowspan="2"style="vertical-align: middle;">Avg. Sq. Inch.</th>
												<th rowspan="2"style="vertical-align: middle;">Full Color</th>
												<th rowspan="2"style="vertical-align: middle;">B&amp;W</th>
												<th rowspan="2"style="vertical-align: middle;">Spot</th>
											</tr>
                                            <tr>
												<th>New</th>
												<th>Pickup/Template</th>
												<th>Resize</th>
											</tr>
										</thead>
										<tbody name="testTable" id="testTable">	
<?php
	foreach($order_type as $row)
	{	
		$no_ads = 0; $new = 0; $pickup = 0; $resize = 0; $sq_inches = 0; $color = 0; $bw = 0; $spot = 0;
		
		//$orders = $this->db->get_where('orders',array('adrep_id' => $this->session->userdata('cId'), 'order_type_id' => $row['id'], 'created_on LIKE' =>  '%'.$today.'%'))->result_array();
		$client_id = $this->session->userdata('cId');
		$order_id = $row['id'];
		if(isset($from) && isset($to))
		{
			$orders = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id`='$client_id' AND `order_type_id`='$order_id'  AND `created_on` BETWEEN '$from' AND '$to' ;")->result_array();
		}else{
			$orders = $this->db->get_where('orders',array('adrep_id' => $this->session->userdata('cId'), 'order_type_id' => $row['id'], 'created_on LIKE' =>  '%'.$today.'%'))->result_array();
		}
		$no_ads = count($orders);
		foreach($orders as $row1)
		{
			$w_h = $row1['width'] * $row1['height'];
			$sq_inches = $sq_inches + $w_h;
			
			if($row1['spec_sold_ad'] == '0' || $row1['html_type'] == '1' )
			{ $new++; }
			
			if($row1['spec_sold_ad'] == '1')
			{ $pickup++; }
			
			if($row1['spec_sold_ad'] == '2')
			{ $resize++; }
			
			if($row1['print_ad_type'] == '1' )
			{ $color++; }
			
			if($row1['print_ad_type'] == '2' )
			{ $bw++; }
			
			if($row1['print_ad_type'] == '3' )
			{ $spot++; }
		}
		
		if($no_ads != '0')
			{ $sq_inches = $sq_inches / $no_ads ; }
				
?>																	
											<tr class="odd gradeX">
												<td><?php echo $row['name']; ?></td>
												<td><?php echo $new; ?></td>
												<td><?php echo $pickup; ?></td>
												<td><?php echo $resize; ?></td>
												<td><?php echo round($sq_inches,2); ?></td>
												<td><?php echo $color; ?></td>
												<td><?php echo $bw; ?></td>
												<td><?php echo $spot; ?></td>
											</tr>
<?php } ?>											
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
       $this->load->view("client/footer");
?>










