<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<title>Admin | Adwitads</title>
<meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8"><meta content="" name="description"/>
<meta content="" name="author"/>
<base href="<?php echo base_url();?>" />
<link rel="stylesheet" type="text/css" href="assets/new_login/scripts/font-awesome/css/font-awesome.min.css"/>
<link rel="stylesheet" type="text/css" href="assets/new_login/scripts/bootstrap/css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="assets/new_login/css/custom.css"/>
<script src="assets/new_login/scripts/jquery-latest.min.js" type="text/javascript" ></script>
	<script type="text/javascript">
		$(document).ready(function(e) { 
			$('#Forgot-pass').hide();
            $('#forget').click(function(e) {
				$('#Login-div').hide();
                $('#Forgot-pass').show();
            });
			$('#back').click(function(e) {
				$('#Forgot-pass').hide();
                $('#Login-div').show();
            });			
		 });
    </script>
</head>

<body>

<!-- BEGIN PAGE CONTAINER -->
<div class="container">
	<div class="row login">
		<form id="loginFrm" action="<?php echo base_url().index_page()."new_csr/login/doIt";?>" method="post">    
		<div id="Login-div" class="col-md-4 col-md-offset-4">
			<div class="logo"><a href="#"><img src="assets/new_login/img/logo.svg" alt="logo" class="logo-default"></a></div>
			<div id="error-div">
				<?php if(isset($error)): ?>
					<p class="msg" style="color:<?php echo $color;?>"><?php echo $error;?></p>
				<?php endif;?>
			 </div>
			<?php if(isset($username)){ ?>
			<div class="input-group">
				<span class="input-group-addon"><a href="javascript: history.go(-1)" class="fa fa-mail-reply"></a></span>
				<input class="form-control" type="text" id="username" name="username" value="<?php echo $username; ?>" readonly />
			</div>
			<?php }else{ ?>
				<input class="form-control" type="text" id="username" name="username" placeholder="Enter your Username" required />
			<?php } ?>
			
			<div class="input-group">
				<span class="input-group-addon"></span>
				<input class="form-control" type="password" placeholder="Enter Password" id="password" name="password" required/>
			</div>
			<button type="submit" class="btn btn-danger btn-block">Sign In</button>
			<div class="forgot_password">
				<a id="forget" href="javascript: void(0);">Forgot password?</a>
			</div>
		</div>
		</form>
		<!-- Forgot Starts -->
		<form id="forgetFrm" action="<?php echo base_url().index_page()."new_csr/login/reset";?>" method="post">
			<div id="Forgot-pass" class="col-md-4 col-md-offset-4">
				<div class="logo"><a href="#"><img src="assets/new_login/img/logo.svg" alt="logo" class="logo-default"></a></div>
			<p class="margin-bottom-10">Please send us your email and<br/>we'll reset your password.</p>
				<input class="form-control" type="text" placeholder="Email Id" id="email_id" name="email_id" />
				<div id="Forgot-pass-button">
					<button type="submit" class="btn btn-danger btn-block">Submit</button>
					<div class="forgot_password">
						<a id="back" href="javascript: void(0);" class="color-red">Back to Login</a>
					</div>
				</div>
			 </div>
		</form>
		<!-- Forgot Ends -->
	 </div>
</div>

<div class="page-footer">
	<div class="container">
		 <ul>
			<li><a href="#">About</a></li>
			<li><a href="#">Privacy</a></li>
			<li><a href="#">Terms</a></li>
			<li><a href="#">Help</a></li>
		</ul>
	</div>
</div>

<script type="text/javascript" src="assets/new_login/scripts/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/new_login/scripts/metronic.js"></script>
<script type="text/javascript" src="assets/new_login/scripts/layout.js"></script>
<script>
        jQuery(document).ready(function() {       
           Metronic.init(); // init metronic core components
           Layout.init(); // init current layout
        });
</script>
</body>
</html>

