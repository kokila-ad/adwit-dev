<?php
	$this->load->view("designer/header");
?>
<style>
#start-day {
}

#start-day input {
	width: 100%;
	padding: 10px;
	border: #000;
	border-radius: 5px;
	color: #ffffff;
  	background-color: #2f96b4;
	*background-color: #2a85a0;
}

</style>

<div id="Middle-Div">

<div id="start-day" style="width: 200px; padding: 50px 0px; margin: 0 auto;">
<form name="form" method="post">
<input type="submit" name="start_time" value="Start Your Shift"/>
</form>
</div>

</div>
<?php
	$this->load->view("designer/footer");
?>