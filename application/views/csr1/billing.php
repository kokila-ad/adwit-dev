<?php
	$this->load->view("csr/header");
?>

<div id="Middle-Div">
<form name="form" method="post">
   <div id="ad-form">
   <div id="ad-form-h">Billing</div>
   <div id="ad-form-s-l">
   <p class="contact"><label for="name">Order No</label></p>
   <input type="text" id="order_chk" name="order_chk"  autocomplete="off">
	<input class="buttom" type="submit" name="search" id="search" value="search">
</form>	
    <p>&nbsp;</p>
<?php	
if(isset($error_data))
{ echo $error_data; }
if(isset($order)){
	echo '<div id="ad-form-h">Status</div>';
	echo '<p>&nbsp; </p><p>&nbsp; </p>';
	echo '<form name="ContactForm" id="ContactForm" method="post" style="padding:0; margin:0;">';
	echo '<p class="contact"><label for="name"><b>Order No : </label><input name="order_no" value='.$order[0]['order_no'].' readonly /></b></p>';
	if($order[0]['billing_status']=='0' || $order[0]['billing_status']=='2'){ echo '<p class="contact"><input type="radio" name="status" id="status" value="1"> Approved </p>';}
	if($order[0]['billing_status']=='1' || $order[0]['billing_status']=='2'){echo '<p class="contact"><input type="radio" name="status" id="status" value="0"> Pending </p>';}
	if($order[0]['billing_status']=='0' || $order[0]['billing_status']=='1'){ echo '<p class="contact"><input type="radio" name="status" id="status" value="2"> Cancelled </p>';}
	
	echo '<p>&nbsp; </p><p class="contact"><textarea name="reason"  style="width:270px;"></textarea></p>';
	echo "<input name='id' value='".$order[0]['id']."' readonly style='display:none;' />";
	echo '<input class="buttom" type="submit" name="Submit" id="Submit" value="Submit" >' ;
} ?>
</div>
</div>
</form>
</div>
<?php
	$this->load->view("csr/footer");
?>