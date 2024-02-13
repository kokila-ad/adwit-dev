<?php 
$this->load->library('dompdf');
$dompdf = new DOMPDF();

//$html = $this->load->view('accounts/invoice.html');
$dompdf->load_html("Hello World");
$dompdf->render();
$dompdf->stream("test.pdf");
?>
