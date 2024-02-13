<?php tcpdf();
$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$obj_pdf->SetCreator(PDF_CREATOR);
$title = "Orders PDF Report";
$obj_pdf->SetTitle($title);
$obj_pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $title, PDF_HEADER_STRING);
$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$obj_pdf->SetDefaultMonospacedFont('helvetica');
$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$obj_pdf->SetFont('helvetica', '', 9);
$obj_pdf->setFontSubsetting(false);
$obj_pdf->AddPage();
ob_start();?>
<html>
<body>
	<h1> Success</h1>
	<marquee>Hi</marquee>	
	<table class="table table-scrollable table-striped table-hover" id="sample_1">
							<thead>
							<tr>
								<th>Date</th>
								<th>Adwit Id</th>
								<th>Job Name</th>
								<th>Advertiser name</th>
								<th>Adrep</th>
								<th>Publication name</th>
								<th>Width</th>
								<th>Height</th>
								<th>Total Sq Inch</th>
								<th>Price</th>
								</tr>
							</thead>
				<tbody>
				
					<?php foreach($publication_orders as $row)
					{	$inv_amount = '0'; $total_sqinches='0';
						if(($row['order_type_id'] == '2' || $row['order_type_id'] == '3') && $row['cancel'] == '0')
						{	$sqinches = '0';
					?>
					<tr>
					<td>
						<?php 
										  $d = date('Y-m-d', strtotime($row['created_on']));
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
								<td>
									<?php echo round($row['width'],2);?>
								</td>
								<td>
									<?php echo round($row['height'],2);?>
								</td>
								<td>
									<?php $w=$row['width'];
										  $h=$row['height'];
										  $sqinches = $w*$h;
										  echo round($sqinches,2);
										  $total_sqinches = $total_sqinches + $sqinches;
									?>
								</td>
								<?php 
								$rate = $sqinches * $price[0]['price']; ?>
								<?php	$inv_amount = $inv_amount + $rate;?>
								<td>
									<?php echo "<b>".$rate."</b>";?>
								</td>
					<?php }	?>


					</tr>
										<?php } ?>				
				</tbody>
	</table>
	
</body>
</html>

<?php  $content = ob_get_contents();
ob_end_clean();
$obj_pdf->writeHTML($content, true, false, true, false, '');
$obj_pdf->Output('output.pdf', 'I');
?>