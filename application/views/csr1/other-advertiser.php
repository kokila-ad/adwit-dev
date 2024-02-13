<?php
	$this->load->view("csr/header");
?>
<link href="ui-lightness/jquery-ui-1.10.3.custom.css" rel="stylesheet">

<div id="Middle-Div">
<form name="form" method="post">
   <div id="ad-form">
   <div id="ad-form-h"></div>
   <div id="ad-form-s-l">
   <p class="contact"><h2><label for="name">Advertiser Name</label></h2></p>
   <input type="text" id="name" name="name" size="50" autocomplete="off"  required>
	<input class="buttom" type="submit" name="submit" id="submit" value="SUBMIT">
    <p>&nbsp;</p>
    <?php	
if(isset($msg))
{ echo $msg; }
?>
</div>
</div>
</form>
</div>

<?php
	$this->load->view("csr/footer");
?>