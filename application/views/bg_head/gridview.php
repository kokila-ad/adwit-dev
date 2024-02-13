<?php
	$this->load->view("bg_head/header");
?>
	<div id="Middle-Div">
<?php 
foreach($grid->css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($grid->js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
   <!-- <div id="container">
<div id="content">-->
   		<h3 style=" text-align: center;">All Jobs</h3>
        <div class="grid" style="width:95%; margin: 0 auto; ">
    	    <?php echo $grid->output;?>		
        </div>

	</div>	
    	
<?php
	$this->load->view("bg_head/footer");
?>