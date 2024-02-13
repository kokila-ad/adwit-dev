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
    <p>Thank you, </p>
	<p>For placing your order with AdwitAds,	</p>
	<p>The job name for this Ad is <u><?php echo $order['job_no']; ?></u>,</p> 
	<p>For any queries regarding this Ad,</p> 
	<p>please contact design team  <u><?php echo $design_team['email_id']; ?></u></p>
	<?php
		//$this->load->view('client/'.$type['value'].'-view');
	if	($order_type['value'] == 'html_order')
		{
			$this->load->view('client/'.$order_type['value'].'-'.$html_type['value'].'-view');
		}
			else {
		$this->load->view('client/'.$order_type['value'].'-'.$ad_type['value'].'-view');
			}
	?>
    <p>&nbsp;</p>
    <p>Regards,</p>
    <p>AdwitAds Customer Service</p>
</div><!-- #wrapper -->


</body>
</html>