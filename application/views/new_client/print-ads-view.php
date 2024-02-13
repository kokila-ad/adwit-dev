    <div id="container">
<div id="content">
<div>&nbsp;</div>
<div class="form">
<table align="center" width="900px" border="0" cellspacing="0" cellpadding="0" style="font-family:Tahoma, Geneva, sans-serif; font-size:13px; margin:0;">
    <tr>
      <td style="width:100px;"><p style="padding-left:20px; font-weight:bold;">Order No:</p></td>
      <td style="width:800px;"><?php echo $order[0]['id'];?></td>
</table>
<table width="960" border="0" cellspacing="1" cellpadding="4">
  <tr style="background-color:#333;">
    <td colspan="3" style="width: 672px;"><p style="padding: 15px; margin: 0px; color: #FFF; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php echo $order[0]['publication_name'];?></p></td>
    <td style="width:288px;"><p style="padding: 0px; margin: 0px; color: #FFF; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center;">Print Ad Form</p></td>
  </tr>
  <tr style="background-color:#eee;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Ad Type<span style="color:#F00;">*</span></p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php 
             if($order[0]['spec_sold_ad']==0){
			 echo 'New ad';
			 }
			 if($order[0]['spec_sold_ad']==1){ 
			 echo'Pickup/Template ad';
			 }
			 if($order[0]['spec_sold_ad']==2){
			 echo'Resize ad';
			 }
         ?></p>
	</td>
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Publish Date</p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
	<?php if($order[0]['publish_date'] == '0000-00-00')
	{ echo ""; } else { $date = strtotime($order[0]['publish_date']); echo date('M d, Y', $date); //echo $order[0]['publish_date']; 
						} ?>
	</p>
	</td>
  </tr>
  <tr style="background-color:#eee;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Adrep Email id</p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
	<?php echo $client['email_id'];?></p></td>
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Publication Name</p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
	<?php echo $order[0]['publication_name']; ?></p></td>
  </tr>
  <tr style="background-color:#eee;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Advertiser Name<span style="color:#F00;">*</span></p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
	<?php echo $order[0]['advertiser_name'];?></p></td>
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Width<span style="color:#F00;">*</span></p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
	<?php echo $order[0]['width']; ?></p></td>
  </tr>
  <tr style="background-color:#eee;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Job Name / No<span style="color:#F00;">*</span></p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
	<?php echo $order[0]['job_no'];?></p></td>
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Height<span style="color:#F00;">*</span></p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
	<?php echo $order[0]['height']; ?></p></td>
  </tr>
  <tr style="background-color:#eee;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Date Needed</p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
	<?php if($order[0]['date_needed'] == '0000-00-00' || $order[0]['date_needed'] === NULL)
	{ echo ""; } else { $date = strtotime($order[0]['date_needed']); echo date('M d, Y', $date); // $order[0]['date_needed']; 
						}?>
	</p></td>
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Full Color/B&W/Spot<span style="color:#F00;">*</span></p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
	<?php if($order[0]['print_ad_type'] == '1')
	{ echo "Color"; }
		elseif($order[0]['print_ad_type'] == '2')
		{ echo "B&W"; }
		else { echo "Spot"; } ?></p></td>
  </tr>
  <tr style="background-color:#eee;">
	<td style="width: 192px;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Job Instruction</p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
      <?php 
	 /*  if($order[0]['job_instruction'] == '1') { echo "Follow Instructions Carefully"; }
		elseif($order[0]['job_instruction'] == '0'){echo "";} else { echo "Be Creative"; }
		 */
		 if($order[0]['job_instruction'] == '0' || $order[0]['job_instruction'] == ''){echo "";} else {
		 echo $order[0]['job_instruction']==1 ? 'Follow Instructions Carefully' : ($order[0]['job_instruction']==2 ? 'Be Creative' : 'Camera Ready Ad');
		 }
	  ?>
    </p></td>
 
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Color Preferences</p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
	<?php echo $order[0]['color_preferences'];?></p></td>
  </tr>
  <tr style="background-color:#eee;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Art Work</p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
      <?php if($order[0]['art_work']==0 || $order[0]['art_work']=='' ){ echo ""; }else {
	  echo $order[0]['art_work']==1 ? 'Use additional art if required' : ($order[0]['art_work']==2 ? 'Modify art provided if necessary' : 'Use art provided without change');}
		?>
    </p>
     </td>
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Font Preferences</p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
	<?php echo $order[0]['font_preferences'];?></p></td>
  </tr>
  <?php if($order[0]['pickup_adno']!='') { ?>
  <tr style="background-color:#eee; vertical-align: top;">
    <td colspan="4"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center;">Pickup Ad No. <?php echo $order[0]['pickup_adno'];?></p></td>
    </tr>
  <?php }?>
  <tr style="background-color:#eee; vertical-align: top;">
    <td colspan="4"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center;">Copy/Content</p></td>
    </tr>
  <tr style="background-color:#eee; vertical-align: top;">
    <td colspan="4" align="center"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
	<?php 
	//$order[0]['copy_content_description'] = str_replace(PHP_EOL,'<br/>', $order[0]['copy_content_description']);echo $order[0]['copy_content_description']; 
	echo nl2br($order[0]['copy_content_description']);?></p></td>
    </tr>
    <tr style="background-color:#eee; vertical-align: top;">
    <td colspan="4"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center;">Notes & Instructions</p></td>
    </tr>
    <tr style="background-color:#eee; vertical-align: top;">
    <td colspan="4" align="center"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
		<?php echo nl2br($order[0]['notes']); 
			//echo htmlspecialchars($order[0]['notes'], ENT_QUOTES, 'UTF-8');
			?></p>
	</td>
    </tr>  
</table>

</div>

