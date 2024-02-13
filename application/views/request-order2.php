<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	
    <meta charset="utf-8" />
    
	<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	 
    <base href="<?php echo base_url();?>" />
    
	<link rel="stylesheet" href="stylesheet/style.css" type="text/css" media="screen, projection" />
  
</head>

<body>

<div id="wrapper">
	<p>Hello</p><br/>
    <p>Request has been placed </p><br/>
   <?php
	$this->load->view('india_client/request-order-view');
		
	?>
    <p>Regards,</p>
    <p>AdwitAds Customer Service</p>
</div><!-- #wrapper -->


</body>
</html>