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
        $(document).ready(function(){
        
            $.extend($.validator.messages, {
                equalTo: "These passwords don't match. Try again?"
            });
        
            $("#do-change").validate({
                rules: {
                    "new_password": {
                        minlength: 5,
                        maxlength: 20
                    },
                    "confirm_password": {
                        equalTo: "#new_password"
                    }
                }
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
		
		<div class="row margin-0">
		<?php if(isset($error)): ?>
			<p class="msg" style="color:<?php echo $color;?>"><?php echo $error;?></p>
		<?php endif;?>
			<div class="col-md-4 col-md-offset-4 col-xs-12">  
				<!--<form action="index.html" method="POST" >-->
					<div class="text-center margin-bottom-15">
						<span class="xlarge">Reset Password</span>
					</div>
				<form id="do-change" action="<?php echo base_url().index_page()."professional_edition/login/dochange/".$encrypted_key;?>" method="post">
					<div class="form-group">
						<label for="login-password">New Password <span class="text-red">*</span></label>
						<input type="password" id="new_password" name="new_password" class="form-control margin-bottom-10" required>
			
						<label for="login-password">Re-Enter New Password <span class="text-red">*</span></label>
						<input type="password" id="confirm_password" name="confirm_password" class="form-control margin-bottom-25" required>
			
					</div>
					
					<div class="form-button text-right">
						<button type="submit" class="btn btn-sm btn-blue">Submit</button>
					</div>
					<div class="text-right margin-top-5">
						<a href="<?php echo base_url().index_page().'professional_edition/login'; ?>">
							<small>« Back to Login</small>
						</a>
					</div>
					<p>&nbsp;</p>
					<p style="text-align: center; color:green;">Reset password for <?php echo $email_id;?></p>
					<p>&nbsp;</p>	
				</form>
			</div> 		 
		</div>	
		  
	 </div>
</section>

</div>
<?php $this->load->view('professional_edition/footer'); ?>