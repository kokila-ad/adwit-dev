<!DOCTYPE html>
<html class="no-js" lang="">
    <head>
        
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>AdwitAds</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<base href="<?php echo base_url(); ?>">
	<link rel="stylesheet" href="assets/professional_edition/css/bootstrap.css">
	<link rel="stylesheet" href="assets/professional_edition/css/datepicker.css"/>
	<link rel="stylesheet" href="assets/professional_edition/css/awemenu.css">
	<link rel="stylesheet" href="assets/professional_edition/css/font-awesome.css">
	<link rel="stylesheet" href="assets/professional_edition/css/main.css">
	<script src="assets/professional_edition/js/vendor/modernizr-2.8.3.min.js"></script>
	<script src="assets/professional_edition/js/vendor/jquery-1.11.3.min.js"></script>
    <link rel="shortcut icon" href="assets/professional_edition/favicon.ico"/>
	<style>
	.awemenu-bars{display:none!important;}
	</style>
	<script type="text/javascript">

		$(document).ready(function(e) {
			
            $('#forget').click(function(e) {

				$('#login_box').hide();

                $('#forgot_box').show();

            });

			$('#back').click(function(e) {

				$('#forgot_box').hide();

                $('#login_box').show();

            });	
			
		 });

    </script>
	</head>
    
	<body>
	
	<!-- // LOADING -->
        <div class="awe-page-loading">
            <div class="awe-loading-wrapper">
                <div class="awe-loading-icon">
                    <span class="icon icon-logo"></span>
                </div>
                
                <div class="progress">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
        <!-- // END LOADING -->

<div id="wrapper" class="main-wrapper ">
    <header id="header" class="awe-menubar-header">
        <nav class="awemenu-nav navbar-fixed-top" data-responsive-width="1200">
            <div class="container">
                <div class="awemenu-container">              
                    <div class="awe-logo">
                        <a href="#" title=""><img src="assets/professional_edition//img/logo.png" alt=""></a>
                    </div><!-- /.awe-logo -->
                    <ul class="awemenu awemenu-right"></ul>
                </div>
            </div><!-- /.container -->

        </nav><!-- /.awe-menubar -->
    </header>

       
  
<div id="main">

<section>
 
	 <div class="container margin-vertical-50">  
		
		<div class="row margin-0" id="login_box">  		 
		<div class="margin-bottom-30 text-center">  
				<div class="row margin-0 ">  		 
					<div class="col-md-12 col-xs-12 padding-0">  
						<!--<p>Congratulations! Your account has been activated successfully, login to continue.</p>-->
						<p><?php echo $this->session->flashdata('message'); ?></p>
						<?php if(isset($error)): ?>
							<p class="msg" style="color:<?php echo $color;?>"><?php echo $error;?></p>
						<?php endif;?>
					</div>
				</div> 
			</div>	
			<div class="col-md-4 col-md-offset-4 col-xs-12">
				<form id="loginFrm" action="<?php echo base_url().index_page()."professional_edition/login/doIt";?>" method="post">
				<!--<form action="index.html" method="POST" >-->
					<!--<div class="text-center margin-bottom-15">
						<span class="xlarge">Login</span>
					</div>
					-->
					<div class="form-group">
						<label>Username/Email Address <span class="text-red">*</span></label>
						<input type="text" id="username" name="username" class="form-control margin-bottom-10">
					
						<label>Password <span class="text-red">*</span></label>
						<input type="password" id="password" name="password" class="form-control margin-bottom-25">
					</div>

					<div class="form-button text-right">
						<!--<a href="index.html" type="submit" class="btn btn-sm btn-blue">Login</a>-->
						<button type="submit" class="btn btn-sm btn-blue">Sign In</button>
					</div>
					
					<div class="text-right margin-top-5">
						<a id="forget" href="javascript: void(0);">
							<small>Forgot your password?</small>
						</a>
						
					</div>
				</form>
			</div> 		 
		</div>	
	<!-- Forgot password -->
	<div class="row margin-0" id="forgot_box" style="display: none;"> 			
			<!--<div class="margin-bottom-50 text-center">  
				<div class="row margin-0 ">  		 
					<div class="col-md-4 col-md-offset-4 col-xs-12">  
						<p class="xlarge">Reset Password</p>
						<p>An email has been sent to your registered mail id, please click the link that has been sent to your email.</p>
					</div>
				</div> 
			</div>-->
			<div class="col-md-4 col-md-offset-4 col-xs-12" id="reset">
				<form id="forgetFrm" action="<?php echo base_url().index_page()."professional_edition/login/reset";?>" method="post">
				<!--<form action="index.html" method="POST" >				-->
				 	<div class="margin-bottom-25">
						<span class="medium">New Password will be sent to your email address.</span>
					</div>
					<!--<h6>New Password will be sent to your email address.</h6>
					<p>&nbsp;</p>-->
					<div class="form-group">
						<label>Registered Email Id <span class="text-red">*</span></label>
						<input type="email" id="email_id" name="email_id" class="form-control margin-bottom-10" required>						
					</div>
					<div class="form-button text-right">
						<!--<a id="reset_password" type="submit" class="btn btn-sm btn-blue">Submit</a>-->
							<button type="submit" id="reset_password" class="btn btn-sm btn-blue">Submit</button>
					</div>
					<div class="text-right margin-top-5">
						<a id="back" href="javascript: void(0);">
							<small>« Back to Login</small>
						</a>
					</div>
				</form>
			</div> 		 
	</div>
	<!-- Forgot password End-->
	 </div>
</section>

</div>
<?php
	 $this->load->view("professional_edition/footer");
?>