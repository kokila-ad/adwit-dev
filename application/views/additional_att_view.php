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
	<p>New files are attached  for the Order Id:<?php echo $orders[0]['id'];?> </p>
	<p><?php $i=1;
			if(isset($filename)){
			   foreach($filename as $row)
			   { 
		?>
				   <p><?php echo $i .'. '. $row; 
								$i++; ?>
					</p>
	<?php  } } ?>
		</p>
	
</div><!-- #wrapper -->


</body>
</html>