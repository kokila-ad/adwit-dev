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
Please review.<br/>
<br/>
<br/>
<br/>
Thanks,<br/>
<?php if(isset($alias)){ echo $alias; }else{ echo "Anbal"; } ?>
<br/>

</body>
</html>