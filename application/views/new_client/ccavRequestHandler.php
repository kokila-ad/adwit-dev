<form method="post" name="redirect" action="https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction"> 
	<input type='hidden' name='encRequest' value='<?php echo $encrypted_data; ?>' >
	<input type='hidden' name='access_code' value='<?php echo $access_code; ?>' >
	<input type='hidden' name='amount' value='<?php echo $amount; ?>' >
</form>

<script language='javascript'>document.redirect.submit();</script>