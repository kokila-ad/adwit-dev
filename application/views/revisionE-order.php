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
The High-Res version of your <?php echo $ad_type; ?> ad is  attached for your perusal. If approved you may forward this pdf to production. <br/>
<br/>
<?php 
    if(isset($preorders_waukesha)){
        echo 'Job No - <b>'.$job_num.'</b><br/>';
        echo 'Keyword1 (AdTitle) - <b>'.$adtitle.'</b><br/>';
        echo 'Publication Names - ';
        foreach($preorders_waukesha as $row){
            echo  '<b>'.$row['publication'].'</b>, ' ; 
        }
        echo'<br/>'; 
        echo 'Publish Date - <b>'.date("M d, Y",strtotime($publish_date)).'</b><br/>';
        echo 'Account No - <b>'.$account_number.'</b><br/>';
        echo'<br/>';    
    }
?>
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

</body>
</html>