<!DOCTYPE html>
<body style="margin: 0; padding: 0;">
<table border="0" cellspacing="0" cellpadding="0" 
style="width: 100%; max-width: 650px; margin-top: 20px; padding: 10px 10px 2px 10px;font-family:'Helvetica Neue', Helvetica, Arial, sans-serif;">
 <tbody>
 
  
 <tr>
 	<td>
	 <p style="color:#2e2c2c;margin:0px;padding-top:5px;font-size:15px;font-weight:500">
	 Hi <?php echo $client['first_name']; ?>, </p>
	</td>
 </tr>
 
 
 <tr>
 	<td>
	<p style="color:#d71921;font-size:16px;margin:25px 0 10px 0"><?php if(isset($note)){ echo 'Note: <span style="color:#F00">'.$note.'</span>'; } ?></p>
	<p style="color:#605c5c;font-size:15px;line-height:20px;margin:0px;line-height:22px;">
		The High-Res version of your <?php echo $ad_type; ?> ad is attached for your perusal. If approved you may forward this pdf to production.
	</p>
 </td>
 </tr>
 
<?php if(isset($url)){ ?> 
 <tr>
 	<td>
		<p style="margin:30px 0 20px 0;">
			<a href="https://www.adwitads.com/weborders/index.php/new_client/home/dashboard" style="text-decoration:none;font-size:13px;background:#30a6c6;padding:8px 30px;border-radius:3px;color:white;outline:none;border:none;cursor:pointer;" >
				Click Here to View PDF
			</a>
		</p>
	</td>
 </tr>
<?php } ?> 
  <tr>
 	<td>
	<p style="color:#605c5c;font-size:15px;line-height:20px;margin:5px 0 15px 0;line-height:22px;">		
		If it needs work before the final approval, you may mark up this PDF and mail it back. We will revise the ad and send it back ASAP for your review. 
	</p>
 </td>
 </tr>
 
 
 <tr>
 	<td>
	 <p style="color:#2e2c2c;margin:0px;font-size:15px;margin:10px 0 0 0;"> Thanks, </p>
	 <p style="color:#605c5c;margin:0px;padding-bottom:15px;font-size:15px;"> <?php if(isset($alias)){ echo $alias; }else{ echo "Your Design Team"; }?> </p>	 
	</td>
 </tr>
 
 
 <tr>
 	<td style="border-top:1px solid #eee">
		<p style="color:#605c5c;font-size:12px;padding-top:2px;padding-bottom:1px;line-height:20px;margin:0px;text-align:center">
			"We appreciate your business, every order!"
		</p>
 </td>
 </tr>
 
 
 </tbody>
</table>

</body>



