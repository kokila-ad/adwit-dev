<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	
    <meta charset="utf-8" />
    
	<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	
</head>

<body>
Hi <?php echo $client['first_name'].' '.$client['last_name']; ?>,<br/>

<br/>
<?php if(isset($note)){ echo '<span style="color:#F00">'.$note.'</span>'; } ?>
<br/>
<br/>
The High-Res version of your <?php echo $ad_type; ?> ad is  attached for your perusal. If approved you may forward this pdf to production. <br/>
<br/>
If it needs work before the final approval, you may mark up this PDF and mail it back. We will revise the ad and send it back ASAP for your review.<br/>
<br/>
<br/>
Thanks,<br/>
<?php if(isset($alias)){ echo $alias; }else{ echo "Your Design Team"; }?>
<br/>
" We appreciate your business, every order! " <br/>
<br/>
Email: <?php echo $from; ?><br/>
www.adwitglobal.com <br/>
Vote for us on <a href="https://www.facebook.com/adwitglobal">Facebook!</a> <br/> 
<br/>
<p style="font-weight: bold; color: rgb(106, 168, 79);"><i>PS Anytime you prefer to call, you can now dial 1 619 796 2784 (ART4). It is a local area code and you can expect a quick response,
just make sure that we get your name and contact information</i></p>

</body>
</html>
