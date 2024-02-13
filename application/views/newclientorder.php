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
	<!--<p>Hello</p><br/>
    <p>An order has been placed for</p><br/>
    <p>
	   Adrep Name&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $client['first_name'].' '.$client['last_name'];?></p><br/>
	-->
		
	<?php
		if($order[0]['order_type_id'] == 1){
			$this->load->view('new_client/web-ads-view');
		}else{
			$this->load->view('new_client/print-ads-view');
		}
	?>
    <!--<p>Regards,</p>
    <p>AdwitAds Customer Service</p>-->
<!--  </div>#wrapper -->

