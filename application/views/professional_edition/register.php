<!DOCTYPE html>
<html class="no-js" lang="">
    <head>
        
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>AdwitAds</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<base href="<?php echo base_url(); ?>">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script> 
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
		 
				    <div class="row margin-0 ">  		 
						<div class="col-md-4 col-md-offset-4 col-xs-12 padding-left-0 ">  
							 <form id="reg-form" action="<?php echo base_url().index_page().'professional_edition/login/register' ?>" method="POST" >
								<div class="text-center margin-bottom-15">
									<span class="xlarge">Account Registration</span>
								</div>
								<?php echo $this->session->flashdata('message'); ?>
								<div class="form-group">
									<label>Publication Name <span class="text-red">*</span></label>
									<input type="text" name="publication" class="form-control margin-bottom-10" required>
									
									<label>First Name <span class="text-red">*</span></label>
									<input type="text" name="first_name" class="form-control margin-bottom-10" required>
									
									<label>Last Name <span class="text-red">*</span></label>
									<input type="text" name="last_name" class="form-control margin-bottom-10" required>
								
									<label>Username<span class="text-red">*</span></label>
									<input type="text" name="username" class="form-control margin-bottom-10" required>
									
									<label>Email Address <span class="text-red">*</span></label>
									<input type="email" name="email_id" class="form-control margin-bottom-10" required>
									
									<label>Password <span class="text-red">*</span></label>
									<input type="password" name="password" id="password" class="form-control margin-bottom-10" required>
									
									<label>Re-Enter Password <span class="text-red">*</span> <span id='message'></span></label>
									<input type="password" name="confirm_password" id="confirm_password" class="form-control margin-bottom-25" required>
									
								</div>

								<div class="form-button text-right">
									<!--<a href="registration_msg.html" class="btn btn-sm btn-blue">Submit</a>-->
									<button type="submit" class="btn btn-sm btn-blue">Submit</button>
								</div>
							</form>
						</div> 		 
						
						 
					</div>	 
		 
	 </div>
</section>

</div>
<script>
	$(document).ready(function(){	
		$('#confirm_password').on('keyup', function () {
			if ($(this).val() == $('#password').val()) {
				$('#message').html('(Password matching)').css('color', 'green');
			} else $('#message').html('(Password not matching)').css('color', 'red');
		});
		
	});	
</script>
<?php
	 $this->load->view("professional_edition/footer");
?>


