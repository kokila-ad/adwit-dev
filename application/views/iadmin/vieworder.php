<?php
	$this->load->view("iadmin/header");
?>

<div id="content">
	<?php
		$this->load->view('india/'.$type['value'].'-view');
	?>
</div><!-- #content-->
			
<?php
	$this->load->view("iadmin/footer");
?>