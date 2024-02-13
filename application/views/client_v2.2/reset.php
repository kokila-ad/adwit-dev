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
   
        
<div id="Middle-Div">
    <div id="Login-div">
    <?php if(isset($error)): ?>
    	<p class="msg" style="color:<?php echo $color;?>"><?php echo $error;?></p>
    <?php endif;?>
      <div id="Login-h1">
      Enter new password</div>
      <form id="do-change" action="<?php echo base_url().index_page()."client/login/dochange/".$encrypted_key;?>" method="post">
      <div id="Login-input">
      <input type="password" placeholder="New Password" required id="new_password" name="new_password" /><br/><br/>
      <input type="password" placeholder="Confirm Password" required id="confirm_password" name="confirm_password" /><br/><br/>
     </div>  
      <div id="Login-button">
      <button type="submit">submit</button>      
      </div>
      <p>&nbsp;</p>
      <p style="text-align: center;">Reset password for <?php echo $email_id;?></p>
      <p>&nbsp;</p>
      </form>
     </div>
      </div>
<?php
	$this->load->view("client/footer");
?>