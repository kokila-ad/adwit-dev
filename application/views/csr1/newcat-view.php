<?php
	$this->load->view("csr/header1");
?>

<div id="Middle-Div">
<form name="form" method="post">
   <div id="ad-form">
   <div id="ad-form-h">Category Tool</div>
   <div id="ad-form-s-l">
   <p class="contact"><label for="name">Order No</label></p>
   <input type="text" id="order_chk" name="order_chk"  autocomplete="off">
	<input class="buttom" type="submit" name="search" id="search" value="search">
    <p>&nbsp;</p>
    <?php	
if(isset($error_data))
{ echo $error_data; }
?>
</div>
</div>
</form>
</div>
<?php
	$this->load->view("csr/footer");
?>