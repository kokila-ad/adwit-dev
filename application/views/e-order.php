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
    <p>An order has been placed for</p><br/>
    <p>Advertiser Name&nbsp;:&nbsp;&nbsp;<?php echo $order['advertiser_name'];?><br/>
	   Adrep Name&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $client['first_name'].' '.$client['last_name'];?></p><br/>
	<?php
	if	($order_type['value'] == 'html_order')
		{
			$this->load->view('client/'.$order_type['value'].'-'.$html_type['value'].'-view');
		}
			else {
		$this->load->view('client/'.$order_type['value'].'-'.$ad_type['value'].'-view');
			}
		//$this->load->view('client/'.$type['value'].'-view');
	?>
    <p>Regards,</p>
    <p>AdwitAds Customer Service</p>
</div><!-- #wrapper -->


</body>
</html>