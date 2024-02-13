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
    <p>Additonal file(s) has been Uploaded for</p><br/>
    <p>Advertiser Name&nbsp;:&nbsp;&nbsp;<?php echo $order['advertiser_name'];?><br/>
	   Adrep Name&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $client['first_name'].' '.$client['last_name'];?></p><br/>
	   
	<p style="padding: 20px; text-align: center; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:16px; color: #F00;">
	<?php
		$count=0;

		$this->load->helper('directory');

		$map = directory_map($dir4.'/');
		if($map)
		{
			foreach($map as $row)
			{
				echo $row."<br/>";
			}
			$count = count($map);
		}
		
	?></p>

	

	<p style="padding: 20px; text-align: center; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:16px; color: #0C0;">

	<?php

	

	   echo $count." File(s) Successfully Uploaded. <br/> ";

	   

	?></p>

    <p>Regards,</p>
    <p>AdwitAds Customer Service</p>
</div><!-- #wrapper -->


</body>
</html>