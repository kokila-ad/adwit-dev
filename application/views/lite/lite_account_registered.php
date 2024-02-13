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
	<?php if($adrep['new_ui']=='4'){ $adrepId = urlencode(base64_encode($adrep['id'])); ?>
		<p class="font-lg margin-bottom-10">This account already exists.</br>
			Please <a href="<?php echo base_url().index_page().'lite/login/set_password/'.$adrepId; ?>" target='_blank'><u>click here</u></a> to reset your password to continue.
		</p>
	<?php }elseif($adrep['new_ui']=='0' || $adrep['new_ui']=='1' || $adrep['new_ui']=='2'){ ?>
		<p class="font-lg margin-bottom-10">
			This account is associated with an AdwitAds enterprise account.</br>
			Please use the login credentials provided to you or <a href="<?php echo base_url().index_page().'client/login'; ?>" target='_blank'><u>click here</u></a> to reset your password to continue.
		</p>
	<?php } ?>
	</div>
</section>
</body>
</html>
