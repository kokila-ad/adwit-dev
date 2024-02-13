<?php
	$this->load->view("bg_head/header");
?>

<div id="content">
	<?php
		$this->load->view('client/'.$type['value'].'-view');
	?>
</div><!-- #content-->
			
<?php
	$this->load->view("bg_head/footer");
?>