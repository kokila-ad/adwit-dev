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
	</head>
	
<body>

 <section>
    <div class="container text-center margin-vertical-50">  
		<p class="font-lg margin-bottom-10">Account has been already registered with <span class="text-red">"<?php echo $adrep['email_id']; ?>"</span> email id .</br>
			<a href="<?php echo base_url().index_page().'lite/login/set_password/'.$adrep['id']; ?>"><u>Click here</u></a> to reset password</p>
	</div>
</section>
</body>
</html>
