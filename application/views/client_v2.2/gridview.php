<?php
	$this->load->view("client/header1");
?>

<?php 
foreach($grid->css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($grid->js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>

  <div id="Middle-Div">
  <div id="Middle-text1"><?php echo $heading?></div>
        <div id="grid">
    	    <?php echo $grid->output;?>		
        </div>
        <div id="Back-btn"><a href="<?php echo base_url().index_page().'client/home/home/';?>">Back</a></div>
</div>
			
<?php
	$this->load->view("client/footer");
?>