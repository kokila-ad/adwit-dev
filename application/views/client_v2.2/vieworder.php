<?php
	$this->load->view("client/header1");
?>

 <div id="Middle-Div">
	<?php
		$this->load->view('client/'.$type['value'].'-fluid-view');
	?>
</div>
			
<?php
	$this->load->view("client/footer");
?>