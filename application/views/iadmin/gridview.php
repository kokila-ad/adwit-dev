<?php
	$this->load->view("iadmin/header");
?>

<?php 
foreach($grid->css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($grid->js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
    <div id="container">
<div id="content">
    <div class="form">
   		<h3><?php echo $heading?></h3>
        <div class="grid">
    	    <?php echo $grid->output;?>		
        </div>
    </div>
</div><!-- #content-->
    </div>
    </section>
			
<?php
	$this->load->view("iadmin/footer");
?>