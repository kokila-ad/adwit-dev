<html>
<body>

<p>Hi <?php echo $approve_details['name']; ?>,</p>
<p><b>Artwork For Your Approval </b></p>
<p>Your artwork is ready for printing and waiting for your approval!</p>
<p>Kindly approve your ad for publication by clicking the link below:</p>

<button><?php echo'<a href="'.base_url().index_page().'approval/home/'.$this->uencrypter->encode($order_id).'">Review Artwork</a>'; ?></button>

<p>Please note that we will not be able to publish your ad until we receive confirmation of your approval.</p>

<p>For questions, changes to the run dates, size or any other information regarding your order, please
contact your Media Consultant listed below:</p> 

<p>
<b><?php echo $client['first_name'].' '.$client['last_name']; ?></b>
<br/>
<?php echo $client['email_id']; ?>
<br/>
</p>
<br/><br/> 
Thank you, 
<br/>
Daily News Design Team
</body>
</html>