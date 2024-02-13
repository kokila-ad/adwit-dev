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
	
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/validate.js"></script>
   
   
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

    <!--[if lte IE 6]><link rel="stylesheet" href="stylesheet/style_ie.css" type="text/css" media="screen, projection" /><![endif]-->

</head>

<body>

<div id="wrapper">

  <header id="header">
  <div class="logo"><a href="#"><img src="images/logo.png"/></a></div>
  </header><!-- #header-->

	<div id="content">
    <?php if(isset($error)): ?>
    	<p class="msg" style="color:<?php echo $color;?>"><?php echo $error;?></p>
    <?php endif;?>
    <div class="login">
        <form id="do-change" action="<?php echo base_url().index_page()."iadmin/login/dochange/".$encrypted_key;?>" method="post">
             <h3>Enter new password.</h3>
             <div>
                 <input type="password" placeholder="New Password" required id="new_password" name="new_password" />
             </div>
              <div>
                 <input type="password" placeholder="Confirm Password" required id="confirm_password" name="confirm_password" />
             </div>
             <div>
                 <button type="submit">Submit</button>
                 <p>Reset password for <?php echo $email_id;?></p>
             </div>
         </form>
    </div>
	</div><!-- #content-->

</div><!-- #wrapper -->

<footer id="footer">
</footer><!-- #footer -->

</body>
</html>