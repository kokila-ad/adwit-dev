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

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/new_login/scripts/font-awesome/css/font-awesome.min.css"/>
<link rel="stylesheet" type="text/css" href="assets/new_login/scripts/bootstrap/css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="assets/new_login/css/custom.css"/>
<script src="assets/new_login/scripts/jquery-latest.min.js" type="text/javascript" ></script>
</head>

<body>

<!-- BEGIN PAGE CONTAINER -->
	<div class="container">
		<div class="row login">
			<div class="col-md-4 col-md-offset-4">
				<div class="logo"><a href="#"><img src="assets/new_login/img/logo.svg" alt="logo" class="logo-default"></a></div>
				<p>Sign in to AdwitAds</p>
				<form id="loginFrm" action="<?php echo base_url().index_page()."login/home/doIt";?>" method="post">    
					<input type="text" class="form-control" placeholder="Enter your email" id="username" name="username" autofocus required/>
					<button type="submit" class="btn btn-danger btn-block">Next</button>
				</form>
				<p style="color:red;"><?php echo $this->session->flashdata('message'); ?></p>
			</div>	
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

