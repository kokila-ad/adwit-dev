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
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.3/angular.min.js"></script>
	</head>
	
<body>

<section>
	<div class="container margin-vertical-20">
		<h2><center>Free Trial<center></center></center></h2>
		<?php echo $this->session->flashdata('signup_message'); ?>
		<form ng-app="" method="post" action="" name="signUpForm" id="order_form" class="margin-top-40">
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-6">
					<p class="margin-bottom-5">First Name <span class="text-red">*</span></p>
					<input type="text" name="first_name" ng-model="first_name" class="form-control input-sm margin-bottom-15" required="">
				</div>	    
				<div class="col-md-6 col-sm-6 col-xs-6">
					<p class="margin-bottom-5">Last Name <span class="text-red">*</span></p>
					<input type="text" name="last_name" ng-model="last_name" class="form-control input-sm margin-bottom-15" required="">
				</div>				
				<div class="col-md-6 col-sm-6 col-xs-12">
					<p class="margin-bottom-5">Email Address <span class="text-red">*</span> </p>
					<input type="email" name="email_id" ng-model="email_id" class="form-control input-sm margin-bottom-15" required="">		   
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<p class="margin-bottom-5">Publisher <span class="text-red">*</span> </p>
					<input type="text" name="publication" ng-model="publication" class="form-control input-sm margin-bottom-15" required="">		   
				</div>
				<div class="col-xs-12 text-right margin-top-10">
					<button class="btn btn-sm btn-blue" type="submit" name="signup" ng-disabled="signUpForm.$invalid" >Sign Up</button>
				</div>	
			</div>
		</form>
	</div>
</section>

 
</body>
</html>
