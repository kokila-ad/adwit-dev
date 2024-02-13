<?php
	$this->load->view("admin/header");
?>

 <div id="Middle-Div">
	<?php
		$this->load->view('client/'.$type['value'].'-'.$ad_type['value'].'-fluid-view');		
	?>
</div>
			
<?php
	$this->load->view("admin/footer");
?>