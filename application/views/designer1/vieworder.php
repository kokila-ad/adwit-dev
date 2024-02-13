<?php
	$this->load->view("designer/header");
?>

<div id="content">
	<?php
		$this->load->view('client/'.$type['value'].'-view');
	?>
</div><!-- #content-->
			
<?php
	$this->load->view("designer/footer");
?>