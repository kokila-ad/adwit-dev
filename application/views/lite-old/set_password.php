<!DOCTYPE html>
<html class="no-js" lang="">
    <head>        
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>AdwitAds</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <base href="<?php echo base_url(); ?>" />
        <link rel="stylesheet" href="assets/lite/css/bootstrap.css">
        <link rel="stylesheet" href="assets/lite/css/main.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	</head>
	
<body>

 <section>
    <div class="container margin-vertical-50">  
		<p class="text-center font-lg margin-bottom-40">Your account has been activated please set password</p>
		<?php echo $this->session->flashdata('message'); ?>
		<form method="post" name="order_form" id="order_form" class="margin-top-20">
			<div class="row">
				<div class="col-md-offset-4 col-md-4">
					<p class="margin-top-10 margin-bottom-5">Username </p>
					<input type="text" name="username" value="<?php echo $adrep['username']; ?>" class="form-control input-sm margin-bottom-15" readonly>
										
					<p class="margin-bottom-5">Password</p>
					<input type="password" name="password" id="password" class="form-control input-sm margin-bottom-15" required>
				
					<p class="margin-bottom-5">Retype Password</p>
					<input type="password" name="confirm_password" id="confirm_password" class="form-control input-sm margin-bottom-15" required>
			<span id='message'></span>		
					<div class="text-right margin-top-10">
						<button class="btn btn-sm btn-blue" type="submit" name="set_password">Submit</button>
					</div>	
				</div>
			</div>
		</form>
	</div>
</section>
</body>
<script>
		$('#confirm_password').on('keyup', function () {
			if ($('#password').val() == $('#confirm_password').val()) {
				$('#message').html('');
			} else 
				$('#message').html('Not Matching');
		});
	</script>
</html>
