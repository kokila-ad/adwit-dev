<?php
	$this->load->view("india/header");
?>

<div id="content">
	<?php
		$this->load->view('india/'.$type['value'].'-view');
	?>
</div><!-- #content-->
			
<?php
	$this->load->view("india/footer");
?>