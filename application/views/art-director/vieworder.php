<?php
	$this->load->view("art-director/header");
?>

<div id="content">
	<?php
		$this->load->view('client/'.$type['value'].'-view');
	?>
</div><!-- #content-->
			
<?php
	$this->load->view("art-director/footer");
?>