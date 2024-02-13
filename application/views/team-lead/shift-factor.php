<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
	$this->load->view("team-lead/header");
	
?>
		<link rel="stylesheet" href="http://www.formmail-maker.com/var/demo/jquery-popup-form/colorbox.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script src="http://www.formmail-maker.com/var/demo/jquery-popup-form/jquery.colorbox-min.js"></script>

<div id="Middle-Div">
<h1>Shift Request </h1>
<?php if(isset($designers)){ ?>
<form name="form" method="post" enctype="multipart/form-data">
<?php foreach($designers as $row)
		{
			echo "Request from designer <b>".$row['username']."</b> for Shift change From shift timings ".$row['shift_factor']."hrs to <b>".$row['shift_factor_status']."</b>hrs &nbsp;&nbsp;&nbsp;";
			echo '<input type="text" name="shift_factor_status" value="'.$row['shift_factor_status'].'" readonly style="visibility:hidden" />';
			echo '<input type="submit" name="submit" id="submit" value="Confirm" />';
			echo "<br/>";
		}
?>
</form>
<?php }else{ echo "No Request Found!!"; } ?>
</div>
<?php
	$this->load->view("team-lead/footer");
	
?>