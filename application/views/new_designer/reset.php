<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	
    <!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	
    <title>Adwit Ads</title>
	
    <meta name="keywords" content="adwitads, adwit, ads, print ads, web ads at india, ads at bangalore" />
	<meta name="description" content="adwit ads for print and web ad development" />
    
    <base href="<?php echo base_url();?>" />
    
	<link rel="stylesheet" href="stylesheet/style.css" type="text/css" media="screen, projection" />
	<link rel="stylesheet" href="stylesheet/style_fluid.css" type="text/css" />
	<link rel="stylesheet" href="stylesheet/boilerplate.css" type="text/css" />
	
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/validate.js"></script>
   
   
		<script type="text/javascript">
        $(document).ready(function(){
        
            $.extend($.validator.messages, {
                equalTo: "<br/>These passwords don't match. Try again?"
            });
        
            $("#do-change").validate({
                rules: {
                    "new_password": {
                        minlength: 8,
                        maxlength: 20
                    },
                    "confirm_password": {
                        equalTo: "#new_password"
                    }
                }
            });
			
			$("#new_password").blur(function(){ 
				var text = $(this).val();
				var r = text.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/);
				if(!r){
					console.log(r+' - no match');
					$('#pwd-msg').css({"color":"red"});
					$(this).val('');
				}else{
					$('#pwd-msg').css({"color":""});
				}
				
			});
            
        });
        </script>

    <!--[if lte IE 6]><link rel="stylesheet" href="stylesheet/style_ie.css" type="text/css" media="screen, projection" /><![endif]-->

</head>

<body>
<div class="gridContainer clearfix">
<!-- header starts -->
  <div id="Logo"> <div id="Logo-Img"> <img src="images/logo.png"/> </div> </div>
  <div id="header-div">&nbsp;</div>
<!-- header Ends -->
<div id="Middle-Div">
    <?php if(isset($error)): ?><p class="msg" style="color:<?php echo $color;?>"><?php echo $error;?></p><?php endif;?>
	
    <form id="do-change" action="<?php echo base_url().index_page()."new_designer/login/dochange/".$encrypted_key;?>" method="post">
		<div id="Login-div">
            <div id="Forgot-pass-h1">Enter new password.</div>
			<div id="Login-input">
				<span id="pwd-msg" style="font-size: 13px;">(Minimum 1 uppercase, 1 digit & 8 characters)</span>	<br/><br/>
				<input type="password" placeholder="New Password" required id="new_password" name="new_password"  />
					<br/><br/>
				<input type="password" placeholder="Confirm Password" required id="confirm_password" name="confirm_password" />
			</div>
			<div id="Login-button">
				<button type="submit">Submit</button>
				<p>Reset password for <?php echo $email_id;?></p>
			</div>
        </div>	 
    </form>
	
</div>
<!-- Footer starts -->

  <div id="Footer">

  <div id="footer-copy">&copy; <a href="http://www.adwitglobal.com/" target="_blank">Adwit Global</a></div>

  <div id="footer-version">2017 © adwitads. All Rights Reserved. version 4.8.12</div>

  </div>

  <div>&nbsp;</div>

  <div style=" margin-top:20px; text-align:right;">Works Best With&nbsp;&nbsp;<a href="https://www.google.com/intl/en/chrome/browser/" target="_blank"><img src="images/C-icon.png"/></a>&nbsp;&nbsp;&nbsp;&nbsp;</div>

  <!-- Footer Ends -->
</div>

</body>
</html>