<!DOCTYPE html>
<body style="margin: 0; padding: 0;">
<table border="0" cellspacing="0" cellpadding="0" 
style="width: 100%; max-width: 650px; margin-top: 20px; padding: 0 10px 2px 10px;font-family:'Helvetica Neue', Helvetica, Arial, sans-serif;">
 <tbody>
 
  
<tr>
 	<td>
	 <p style="color:#2e2c2c;margin:0px;padding-top:0;font-size:14px;">
		Hi <?php echo $client['first_name'];?>, </p>
	</td>
</tr>
 
<tr>
 	<td>
		<p style="color:#000000;font-size:14px;line-height:20px;margin:20px 0 0 0;line-height:22px;">
			We have a question regarding your order# <?php echo $order['id']; ?>, Unique Job Name is <?php echo $order['job_no']; ?>.
		</p>
	</td>
</tr>
 
 
<tr>
 	<td>
		<p style="color:#605c5c;font-size:14px;line-height:20px;margin:30px 0 0 0;line-height:22px;">
			Question: <?php echo $question; ?>.
		</p>
	</td>
</tr>
 
 <tr>
 	<td>
		<p style="color:#605c5c;font-size:14px;line-height:20px;margin:30px 0 30px 0;line-height:22px;">
			<a href="<?php echo base_url().index_page().'new_client/home/dashboard';?>">Please click here to answer.</a>
		</p>
	</td>
</tr>

<tr>
 	<td>
	 <p style="color:#2e2c2c;margin:0px;font-size:14px;margin:10px 0 0 0;">Thanks, </p>
	 <p style="color:#605c5c;margin:0px;padding-bottom:15px;font-size:13px;">Adwit Your <?php echo $design_team; ?></p>	 
	</td>
</tr>
 
 
<tr>
 	<td style="border-top:1px solid #eee">
		<p style="color:#605c5c;font-size:13px;padding-top:2px;padding-bottom:1px;line-height:20px;margin:0px;">
			"We appreciate your business, every order!"
		</p>
	</td>
</tr>
 
 
</tbody>
</table>

</body>