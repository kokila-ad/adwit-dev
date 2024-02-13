<!DOCTYPE html>

<body style="margin: 0; padding: 0;">

<table border="0" cellspacing="0" cellpadding="0" 

style="width: 100%; max-width: 650px; margin-top: 20px; padding: 10px 10px 2px 10px;font-family:'Helvetica Neue', Helvetica, Arial, sans-serif;">

 <tbody>

 

  

<tr>

 	<td>

	 <p style="color:#2e2c2c;margin:0px;padding-top:5px;font-size:14px;">

	 Hi <?php echo $client['first_name'];?>, </p>

	</td>

</tr>

 

<tr>

 	<td>

		<p style="color:#605c5c;font-size:14px;line-height:20px;margin:30px 0 0 0;line-height:22px;">

		We have received your change request and most revisions are returned within 2 hours.Your AdwitAds ID is <span style="color:red"><?php echo $order['id'];?></span> &amp; Unique Job Name / Number is 

		<span style="color:red"><?php echo $order['unique_job_name'];?></span>

	</p>

	</td>

</tr>
<?php if(isset($rev_note)){ ?>
<tr>

 	<td>

		<p style="color:#605c5c;font-size:14px;line-height:20px;margin:30px 0 0 0;line-height:22px;">
 
		Changes Requested: <?php echo $rev_note;?>
		</p>

	</td>

</tr>
<?php } ?>
 

 

<tr>

 	<td>

		<p style="margin:40px 0 30px 0;">

			<a href="<?php echo base_url().index_page().'new_client/home/page_dashboard';?>" style="text-decoration:none;font-size:14px;background:#30a6c6;padding:8px 30px;border-radius:3px;color:white;outline:none;border:none;cursor:pointer;" >

				Click to view the status of this ad

			</a>

		</p>

	</td>

</tr>

 

<tr>

 	<td>

	 <p style="color:#2e2c2c;margin:0px;font-size:14px;margin:10px 0 0 0;">Thanks, </p>

	 <p style="color:#605c5c;margin:0px;padding-bottom:15px;font-size:13px;">Adwit <?php echo 'Pagination';//echo $design_team['name'];?></p>	 

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