<?php $this->load->view("lite/head.php"); ?>
<?php $this->load->view("lite/header.php"); ?>

<div style="padding:50px;text-align: center;">
<?php

	for($i = 0; $i < $dataSize; $i++) 
	{
		$information=explode('=',$decryptValues[$i]);
		if($i==3)	$order_status=$information[1];
	}

	if($order_status==="Success")
	{
		echo "<br>Your payment has been received successfully". $value[9]."". $value[10].", Transaction id is ".$value[1]. "Thank you";
		//echo "<br>Thank you for shopping with us. Your credit card has been charged and your transaction is successful. We will be shipping your order to you soon.";
		
	}
	else if($order_status==="Aborted")
	{
		echo "Your payment is Aborted. The transaction ID is $value[1]. <br/> Please save (or print) this record for your reference.";
		//echo "<br>Your payment for Transaction id : $value[1] has been declined due to reason <br/> $value[8]";
		echo '<br/><a href="'.base_url().index_page().'lite/home/buycredit" class="btn btn-danger btn-sm margin-top-15">Buy Credits</a>';	
	}
	else if($order_status==="Failure")
	{
		echo "<br>Thank you for shopping with us.However,the transaction has been declined.";
	}
	else
	{
		echo "<br>Security Error. Illegal access detected";
	
	}

	echo "<br><br>";

	/*echo "<table cellspacing=4 cellpadding=4>";
	for($i = 0; $i < $dataSize; $i++) 
	{
		$information=explode('=',$decryptValues[$i]);
	    	echo '<tr><td>'.$information[0].'</td><td>'.$information[1].'</td></tr>';
	}

	echo "</table><br>";*/

?>
</div>

<?php $this->load->view("lite/footer.php"); ?>
<?php $this->load->view("lite/foot.php"); ?>