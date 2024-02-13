<?php
	$this->load->view("team-lead/header");
?>

<div id="content">
	<?php
		$this->load->view('client/'.$type['value'].'-view');
	?>
</div><!-- #content-->
			
<?php
	$this->load->view("team-lead/footer");
?>