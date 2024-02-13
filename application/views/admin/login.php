<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	
    <!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	
    <title>Adwit Ads</title>
	
    <meta name="keywords" content="adwitads, adwit, ads, print ads, web ads at india, ads at bangalore" />
	<meta name="description" content="adwit ads for print and web ad development" />
    
    <base href="<?php echo base_url();?>" />
    
	<link rel="stylesheet" href="stylesheet/style_fluid.css" type="text/css" media="screen, projection" />
    	<link rel="stylesheet" href="stylesheet/boilerplate.css" type="text/css" media="screen, projection" />
	
    <script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/respond.min.js"></script>
    <script type="text/javascript">
		$(document).ready(function(e) {
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
<div class="gridContainer clearfix">

<!-- header starts -->
  <div id="Logo">
    <div id="Logo-Img">
    <img src="images/logo.png"/>
    </div>
  </div>
  <div id="header-div">&nbsp;</div>
<!-- header Ends -->

<!-- Middle Starts -->
  <div id="Middle-Div">  
  
  	<!-- Login Starts -->
    <form id="loginFrm" action="<?php echo base_url().index_page()."admin/login/doIt";?>" method="post">    
    <div id="Login-div">    
      <div id="Login-h1">
      Login to Place Your Order</div>
      <div id="Login-input">
      <div id="error-div"><?php if(isset($error)): ?>
  <p class="msg" style="color:<?php echo $color;?>"><?php echo $error;?></p>
  <?php endif;?></div>
      <input type="text" placeholder="Username" id="username" name="username" /><br/><br/>
      <input type="password" placeholder="Password" id="password" name="password" /><br/><br/>
      <input type="checkbox" value="remember" id="remember" name="remember" style="width: 5%">
      Remember Me</div>  
      <div id="Login-button">
      <button type="submit">Log in</button>
      <p><a id="forget" href="javascript: void(0);">Lost Your Password?</a></p>
      </div>
     </div> 
     </form>
     <!-- Login Ends -->
     
    <!-- Forgot Starts -->
     <form id="forgetFrm" action="<?php echo base_url().index_page()."admin/login/reset";?>" method="post">
    <div id="Forgot-pass">
      <div id="Forgot-pass-h1">
      Please send us your email and<br/>
we'll reset your password.</div>
      <div id="Forgot-pass-input">
     <input type="text" placeholder="Email Id" id="email_id" name="email_id" />
      </div>  
      <div id="Forgot-pass-button">
      <button type="submit">Submit</button>
      <p><a id="back" href="javascript: void(0);">Back to Login</a></p>
      </div>
     </div>
     </form>
    <!-- Forgot Ends --> 
     
  </div>
  <!-- Middle Ends -->
  
  <!-- Footer starts -->
  <div id="Footer">&nbsp;</div>
  <!-- Footer Ends -->
  
</div>
</body>
</html>
