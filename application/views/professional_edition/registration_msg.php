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

    <div class="container margin-vertical-60 text-center">  
		<div class="row margin-0 ">  		 
			<div class="col-md-12 col-xs-12 padding-0">  
				<?php if(isset($email_error)){ 
						echo '<p>'.$email_error.'</p>';
					}else{ echo '<p>'.$error.'</p>'; ?>
				<p>To complete your registration, please click on the activation link that has been sent to your email <br> 
				<?php if(isset($email)){ echo '<b>'.$email.'</b>'; } ?>
				</p>
				<?php } ?>
				<?php if(isset($email) && isset($adrep_id)){ ?>
				<a href="<?php echo base_url().index_page().'professional_edition/login/resend_link/'.$adrep_id; ?>">
				<button class="btn btn-sm btn-blue margin-top-10">Resend Confirmation Email</button>
				</a>
				<?php } ?>
			</div>
		</div> 
	 </div>
		 	
</section>

</div>

<?php $this->load->view('professional_edition/footer'); ?>