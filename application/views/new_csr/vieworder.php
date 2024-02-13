<?php
	$this->load->view("csr/header");
?>

<div id="Middle-Div">
	<?php
		$this->load->view('client/'.$type['value'].'-'.$ad_type['value'].'-fluid-view');
	?>
    <p>&nbsp;</p>
</div>
			
<?php
	$this->load->view("csr/footer");
?>