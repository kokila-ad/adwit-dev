<html>
<body>
	<table id="testTable">
	<tr><strong>ADWIT GLOBAL PVT LTD</strong></tr>
	<tr><img src="<?php echo base_url() ?>ui_assets/logo.jpg"  alt="logo" align="right" class="logo-default"></tr>
	
	<tr><td>Adwit Global Pvt Ltd</td></tr>
	<tr><td>92, Railway Parallel Road</td></tr>
	<tr><td>Kumara Park West</td></tr>
	<tr><td>Bangalore 560020</td></tr>
	<tr><td>INDIA</td></tr>
	<tr><td><strong>PRINT AD</strong></td></tr>
	<tr><td><strong>INVOICE</strong></td></tr>
	
	<tr><td>Bill To:</td> <td>Invoice #</td><td><?php echo $inv_id[0]['invoice_no'].'/'.$inv_id[0]['invoice_no1']; ?></td></tr>
	<tr><td></td> <td>Date</td><td><?php echo date('Y-m-d', strtotime($inv_id[0]['time']));?></td></tr>
	<tr><td></td> <td>Billed Month</td><td><?php echo date('Y-m', strtotime($inv_id[0]['date']));?></td></tr>
	<tr><td>Attn:</td> <td></td></tr>
	
			<tr>
				<th><strong>Type of ad prsntn	</strong></th>
				<th><strong>Quantity</strong></th>
				<th><strong>Total Sq Inches</strong></th>
				<th><strong>Unit Price per sq.inch</strong></th>
				<th><strong>Total $ (USD)</strong></th>
				
			</tr>
	
		
			<?php foreach($inv_id as $row) { ?>
							<tr>
								<td>Print ads built</td>   					    		      													   		       
								<td align="centre"><?php echo $row['quantity']; ?></td>
								<td align="centre"><?php echo round($row['total_sq_inches'],2); ?></td>
								<td>-----</td>
								<td align="centre"><?php echo round($row['total_usd'],2); ?></td>
							</tr>	
							<tr>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>Special long term discount @ 04%</td>
								<td align="centre"><?php echo round($row['special_discount'],2); ?></td>
							</tr> 
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td><strong>Sub-Total</strong></td>
								<td align="centre"><strong><?php echo round($row['sub_total'],2); ?></strong></td>
							</tr> 
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td>Additional Credit Applied</td>
								<td align="centre"><?php echo round($row['desc'],2); ?></td>
							</tr> 
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td><strong>Total Due</strong></td>
								<td align="centre"><strong><?php echo round($row['total_due'],2); ?></strong></td>
							</tr>
			<?php } ?>				

			<tr><td>Pay</td></tr>
			<tr><td>Authorized Signatory</td></tr>
			<tr><td>Make all checks payable to Adwit Global Pvt Ltd</td></tr>
			<tr><td>Thank you for your business!</td></tr>
				
					
							<tr>
								<th><strong>Date</strong></th>
								<th><strong>Adwit Id</strong></th>
								<th><strong>Job Name</strong></th>
								<th><strong>Advertiser name</strong></th>
								<th><strong>Adrep</strong></th>
								<th><strong>Publication name</strong></th>
								<th><strong>Width</strong></th>
								<th><strong>Height</strong></th>
								<th><strong>Total Sq Inch</strong></th>
								<th><strong>Price</strong></th>
							</tr>
						
				
								<?php foreach($publication_orders as $row)
								{	$inv_amount = '0'; $total_sqinches='0';
									
								?>
								<tr>
								<td>
									<?php $d = date('Y-m-d', strtotime($row['created_on']));
									echo $d;	?>
								</td>
								<td>
									 <?php echo $row['id'];?>
								</td>
								<td>
									<?php echo $row['job_no'];?>
								</td>
								<td>
									<?php echo $row['advertiser_name'];?>
								</td>
								<td>
									 <?php $adreps=$this->db->get_where('adreps',array('id'=>$row['adrep_id']))->result_array();
										echo $adreps[0]['first_name'] ?>
								</td>
								<td>	
									<?php $publication_id=$this->db->get_where('publications',array('id'=>$row['publication_id']))->result_array();
										echo $publication_id[0]['name'] ?>
								</td>
								<td align="centre">
									<?php echo round($row['width'],2);?>
								</td>
								<td align="centre">
									<?php echo round($row['height'],2);?>
								</td>
								<td align="centre">
									<?php $w=$row['width'];
										  $h=$row['height'];
										  $sqinches = $w*$h;
										  echo round($sqinches,2);
										  $total_sqinches = $total_sqinches + $sqinches;
									?>
								</td>
								<?php 
								$price = $this->db->get_where('price_per_sq_inches',array('publication_id'=>$row['publication_id']))->result_array();
								$rate = $sqinches * $price[0]['price']; ?>
								<?php	$inv_amount = $inv_amount + $rate;?>
								<td align="centre">
									<?php echo "<b>".$rate."</b>";?>
								</td>

					</tr>
										<?php } ?>				
				
	</table>
		
	

<button id="btnExport" onclick="tableToExcel('testTable', 'W3C Example Table')"> Export To Excel </button>

</body>
</html>

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
