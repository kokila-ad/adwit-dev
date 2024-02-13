<!doctype html>

<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->

<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->

<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->

<!--[if gt IE 8]><!-->

<html class="">

<!--<![endif]-->

<head>

<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Adwit Ads</title>

<meta name="keywords" content="adwitads, adwit, ads, print ads, web ads at india, ads at bangalore" />

<meta name="description" content="adwit ads for print and web ad development" />

<base href="<?php echo base_url();?>" />

<link rel="stylesheet" href="stylesheet/style_fluid.css" type="text/css" />

<link rel="stylesheet" href="stylesheet/boilerplate.css" type="text/css" />

<!-- 

To learn more about the conditional comments around the html tags at the top of the file:

paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/



Do the following if you're using your customized build of modernizr (http://www.modernizr.com/):

* insert the link to your js here

* remove the link below to the html5shiv

* add the "no-js" class to the html tags at the top

* you can also remove the link to respond.min.js if you included the MQ Polyfill in your modernizr build 

-->

<!--[if lt IE 9]>

<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>

<![endif]-->	

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


<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:98003,hjsv:5};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'//static.hotjar.com/c/hotjar-','.js?sv=');
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

    <form id="loginFrm" action="<?php echo base_url().index_page()."client/login/doIt";?>" method="post">    

    <div id="Login-div">    
      <div id="Login-input">

      <div id="error-div"><?php if(isset($error)): ?>

  <p class="msg" style="color:<?php echo $color;?>"><?php echo $error;?></p>

  <?php endif;?></div>

      <input type="text" placeholder="Username" id="username" name="username" /><br/><br/>

      <input type="password" placeholder="Password" id="password" name="password" /><br/><br/>

      <input type="checkbox" value="remember" id="remember" name="remember" style="width: 5%">

      Remember Me</div>  

      <div id="Login-button">

      <button type="submit">Sign in</button>

      <p><a id="forget" href="javascript: void(0);">Forgot  Password? Cilck Here</a></p>

      </div>

     </div> 

     </form>

     <!-- Login Ends -->

     

    <!-- Forgot Starts -->

     <form id="forgetFrm" action="<?php echo base_url().index_page()."client/login/reset";?>" method="post">

    <div id="Forgot-pass">

      <div id="Forgot-pass-h1">

      New Password will be sent to your email address.</div>

      <div id="Forgot-pass-input">

     <input type="text" placeholder="Registered Email Id" id="email_id" name="email_id" />

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

  <div id="Footer">

  <div id="footer-copy">&copy; <a href="http://www.adwitglobal.com/" target="_blank">Adwit Global</a></div>

  <div id="footer-version">version 3.2</div>

  </div>

  <div>&nbsp;</div>

  <div style=" margin-top:20px; text-align:right;">Works Best With&nbsp;&nbsp;<a href="https://www.google.com/intl/en/chrome/browser/" target="_blank"><img src="images/C-icon.png"/></a>&nbsp;&nbsp;&nbsp;&nbsp;</div>

  <!-- Footer Ends -->

  

</div>

</body>

</html>

