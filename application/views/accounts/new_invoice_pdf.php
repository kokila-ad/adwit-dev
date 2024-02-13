<?php //tcpdf();
//$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//$obj_pdf = new TCPDF();
//$obj_pdf->SetCreator(PDF_CREATOR);
//$title = "Orders PDF Report";
//$obj_pdf->SetTitle($title);
//$obj_pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $title, PDF_HEADER_STRING);
//$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
//$obj_pdf->SetDefaultMonospacedFont('helvetica');
//$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
//$obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
//$obj_pdf->SetFont('helvetica', '', 9);
//$obj_pdf->setFontSubsetting(false);
//$obj_pdf->AddPage();
//ob_start();?>
<?php tcpdf();
	$obj_pdf = new TCPDF();
	$obj_pdf->AddPage();
	ob_start();
?>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<title>Print Ad Invoice</title>
		<meta name="description" content="">
	</head>
	<body>
		<table  width="530" height="842" border="0" cellspacing="0" cellpadding="0" 
       style="background-color:#fff; font-family:Arial, sans-serif; border: 2px solid #000; padding: 15px; margin-top: 20px">
		 <tr>
		   <td>
			  <p style="text-align:center; font-size: 18px;">ADWIT GLOBAL PVT LTD</p>
		   </td>
		 </tr> 
		 
   <tr style="padding-left: 15px;">
  	<td style="color: #2E2C2C; margin: 10px; padding: 25px; font-size: 12px; line-height: 10px;">
	 <p style="margin-bottom: 0 !important;"> Adwit Global Private Limited </p>
	 <p> 92, Railway Parallel Road</p>
	 <p> Kumara Park West</p>
	 <p> Bangalor 560020</p>
	 <p> INDIA</p>
	</td>
  </tr>
  
  <tr>
   <td style="padding-top:15px; padding-bottom:35px;">
      <h3 style="text-align:center">PRINT AD INVOICE</h3>
	  <br/><br/><br/><br/><br/><br/>
   </td>
 </tr>  
 
 
  <tr>
   <td>
	<table width="530" border="0" cellspacing="0" cellpadding="0">
	<thead style="font-size: 14px; line-height: 28px;">
	<tr>
	
		<td>
		<span style="color: #2E2C2C; margin: 0px; padding-top: 5px; font-size: 12px; line-height: 18px; float: left;">
	  <strong>  Bill To:</strong><br/>
	    <?php $publication_id=$this->db->get_where('publications',array('id'=>$inv_id[0]['publication_id']))->result_array();
										echo $publication_id[0]['name'] ?><br/>
	    .................<br/><br/>
	    .................<br/>
	    ..................
	 </span>
		</td>
		<td>
		<span style="color: #2E2C2C; margin-right: 80px; padding-top: 5px; font-size: 12px; line-height: 18px; float: right;">
			<strong>Invoice No:</strong> <?php echo $inv_id[0]['invoice_no'].'/'.$inv_id[0]['invoice_no1']; ?> <br/>
			<strong>  Date:</strong> <?php echo date('Y-m-d', strtotime($inv_id[0]['time']));?><br/><br/>
			<strong>  Billed Month:</strong> <?php echo date('M-Y', strtotime($inv_id[0]['date']));?><br/>
		</span>
		</td>
	</tr>
	</thead>
	</table>
  </td>
 </tr>
 
 
 
 <tr> 
	<td>
	  <p style="color: #2E2C2C; padding-top: 5px; font-size: 14px; font-weight: 500; text-align:left; padding-bottom: 15px;">
				  Attn:  ..................
				 </p>
	 </td>
  </tr>
	
   <tr>
   <td style="text-align: center;">  
	<table align="center" width="515" border="1" cellspacing="0" cellpadding="0" style="text-align: center;">
	<thead style="font-size: 14px; line-height: 28px;">
	<tr>
		<th>Type of ad prsntn</th>
		<th>Quantity</th>
		<th>Total Sq Inches</th>
		<th>Unit Price per Sq.Inch</th>
		<th>Total $(USD)</th>
	</tr>
	</thead>
	<tbody style="font-size: 13px; line-height: 26px;">
	<?php foreach($inv_id as $row) { ?>
	<tr>
		<td>Print ads Built</td>
		<td><?php echo $row['quantity']; ?></td>
		<td><?php echo round($row['total_sq_inches'],2); ?></td>
		<td><?php $price = $this->db->get_where('price_per_sq_inches',array('publication_id'=>$row['publication_id']))->result_array();
				echo $price[0]['price'];?></td>
		<td><?php echo round($row['total_usd'],2); ?></td>
	</tr>
	<tr>
		<td colspan="4" style="text-align: right; padding-right:5px;">Special long term discount @34%</td>
		<td><?php echo round($row['special_discount'],2); ?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td style="text-align: right; padding-right:5px;"><strong>Sub-total</strong></td>
		<td><?php echo round($row['sub_total'],2); ?></td>
	</tr>
	<tr>
		<td colspan="4" style="text-align: right; padding-right:5px;">Additional Credit Applied</td>
		<td><?php echo round($row['desc'],2); ?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td style="text-align: right; padding-right:5px;"><strong>Total Due</strong></td>
		<td><?php echo round($row['total_due'],2); ?></td>
	</tr>
	<?php } ?>
	</tbody>
	</table>
    </td>
   </tr>
   
	<tr>
	<td>
	 <p style="color: #2E2C2C; margin: 0px; padding-top: 10px; font-size: 14px; font-weight: 500; text-align: left;">
	  Pay <?php echo $inv_amount; ?>
	 </p>
	</td>
	</tr>
	
	<tr>
	<td>
	 <p style="color: #2E2C2C; margin: 0px; padding-top: 100px; font-size: 14px; font-weight: 500;">
	  ___________________<br>
	  &nbsp; Authorized Signature
	  <br/><br/>
	 </p>
	</td>
	</tr>
  
    <tr>
	<td>
	 <p style="color: #2E2C2C; margin: 0px; padding-top: 60px; font-size: 12px; font-weight: 500; text-align: center;">
	 <br/><br/><br/><br/><br/><br/>
	  Make all checks payable to Adwit Global Pvt Ltd<br/>
	  Thank you for your business!<br/><br/>
	 </p>
	</td>
	</tr>
	
</tbody>
</table>

<br/><br/>
	<table align="center" width="530" height="" border="0" cellspacing="0" cellpadding="0" 
       style="background-color:#fff; font-family:Arial, sans-serif; border: 1px solid #fff; padding: 15px;">
	<tr>
	<td>
	 <p style="color: #2E2C2C; margin: 0px; padding-top: 20px; font-size: 14px; font-weight: 600; text-align: center;">APPEAL DEMOCRAT </p>
	</td>
	</tr>
	<tr>
	<td>
	 <p style="color: #2E2C2C; margin: 0px; padding-top: 0px; padding-bottom: 10px; font-size: 14px; font-weight: 500; text-align: center;">Billing Period: <?php echo date('M-Y', strtotime($inv_id[0]['date']));?></p>
	<br/></td>
	</tr>
	
	<tr>
   <td style="text-align: center;">  
	<table align="center" width="515" border="1" cellspacing="0" cellpadding="0" style="text-align: center;">
	<thead style="font-size: 13px; line-height: 28px; background-color: #ddd;">
	<tr>
		<th rowspan="2">Sl.No</th>
		<th rowspan="2">Date</th>
		<th rowspan="2">Order ID</th>
		<th rowspan="2">Job#</th>
		<th rowspan="2">Advertiser's Name</th>
		<th rowspan="2">Sales Rep</th>
		<th colspan="2">Size</th>
		<th rowspan="2">Sq Inch</th>
		<th rowspan="2">Billed $</th>
	</tr>
	
		<tr>
		<th>Width</th>
		<th>Height</th>
	</tr>

	
	</thead>
	<tbody style="font-size: 13px; line-height: 26px;">
	<tr>
		<td style="text-align: left; padding-left:5px;line-height: 26px;" colspan="10" >Spec ads @$ <?php $price = $this->db->get_where('price_per_sq_inches',array('publication_id'=>$inv_id[0]['publication_id']))->result_array();
				echo $price[0]['price'];?></td>
	</tr>
							<?php $i='1'; $total_sqinches='0'; $inv_amount = '0'; 
							foreach($publication_orders as $row)
								{	
									
							?>
	<tr>
		<td><?php echo $i;?></td>
		<td><?php $d = date('Y-m-d', strtotime($row['created_on']));
									echo $d;	?></td>
		<td><?php echo $row['id'];?></td>
		<td><?php echo $row['job_no'];?></td>
		<td><?php echo $row['advertiser_name'];?></td>
		<td> <?php $adreps=$this->db->get_where('adreps',array('id'=>$row['adrep_id']))->result_array();
										echo $adreps[0]['first_name'] ?></td>
		<td><?php echo round($row['width'],2);?></td>
		<td><?php echo round($row['height'],2);?></td>
		<td><?php $w=$row['width'];
										  $h=$row['height'];
										  $sqinches = $w*$h;
										  echo round($sqinches,2);
										  $total_sqinches = $total_sqinches + $sqinches;
									?></td>
									<?php 
								$price = $this->db->get_where('price_per_sq_inches',array('publication_id'=>$row['publication_id']))->result_array();
								$rate = $sqinches * $price[0]['price']; ?>
								<?php	$inv_amount = $inv_amount + $rate;
										
								
								?>
								<td align="centre">
									<?php echo "<b>".$rate."</b>";?>
								</td>
	</tr>
	
	<?php  $i = $i+'1'; } ?>				
	
	<tr style="font-weight: 600;line-height: 26px;">
		<td colspan="8">Total</td>
		<td><?php echo $total_sqinches; ?></td>
		<td><?php echo $inv_amount; ?></td>
	</tr>
	
	
	
	</tbody>
	</table>
	<br/><br/><br/><br/>
	</td>
	</tr>
   
	</table>
	</body>
	

</html>



<?php  $content = ob_get_contents();
ob_end_clean();
$obj_pdf->writeHTML($content, true, false, true, false, '');
//$obj_pdf->Output('Invoice.pdf', 'I');
$obj_pdf->Output('Invoice.pdf', 'D');
?>	   