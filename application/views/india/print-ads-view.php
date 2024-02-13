    <div id="container">
<div id="content">
<div>&nbsp;</div>
<div class="form">
<table align="center" width="900px" border="0" cellspacing="0" cellpadding="0" style="font-family:Tahoma, Geneva, sans-serif; font-size:13px; margin:0;">
    <tr>
      <td style="width:100px;"><p style="padding-left:20px; font-weight:bold;">Order No :</p></td>
      <td style="width:600px;"><?php echo $order['id'];?></td>
      <td style="width: 200px; text-align: right;"><?php echo $order['created_on'];?></td>
</table>



<table width="960" border="0" cellspacing="0" cellpadding="4">
  <tr>
    <td style="border-top: 1px solid #40a873; border-left: 1px solid #40a873;"><p style="padding: 15px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php echo $publications['name'];?></p></td>
    <td colspan="2" style="border-top: 1px solid #40a873;">&nbsp;</td>
    <td style="width:288px; border-top: 1px solid #40a873; border-right: 1px solid #40a873;"><p style="padding: 0px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center;">Print Media Form</p></td>
  </tr>
  <tr style="background-color:#67c5cf; color:#000;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Campaign Name<span style="color:#fe905f;">*</span></p></td>
    <td style="width: 288px;"><p style="padding: 0px 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
      <?php echo $order['campaign_title'];?>
    </p></td>
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Deadline<span style="color:#7037c6;">*</span></p></td>
    <td style="width: 288px;"><p style="padding: 0px 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"> <?php echo $order['dead_line_date']; ?></p></td>
    </tr>
  <tr style="background-color:#006ea1; color:#fff;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Account Manager<span style="color:#fe905f;"></span></p></td>
    <td style="width: 288px;"><p style="padding: 0px 10px; margin: 0px; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-decoration: none; color: #FFF;"><?php echo $client['email_id'];?></p></td>
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Print Media Type<span style="color:#fe905f;"></span></p></td>
    <td style="width: 288px;"><p style="padding: 0px 10px; margin: 0px; color: #FFF; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
        <?php
		echo $order['print_media_type']==1 ? 'Press Ad' : ($order['print_media_type']==2 ? 'Brochure' : ($order['print_media_type']==3 ? 'Annual' : ($order['print_media_type']==4 ? 'Newsletter' : ($order['print_media_type']==5 ? 'Outdoor' :  'Other'))));
		?></p></td>
    </tr>
  <tr style="background-color:#006ea1; color:#fff;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Client<span style="color:#fe905f;">*</span></p></td>
    <td style="width: 288px;"><p style="padding: 0px 10px; margin: 0px; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
      <?php echo $order['client_name'];?>
    </p></td>
    
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Other Print Media Type<span style="color:#fe905f;"></span></p></td>
 
    <td style="width: 288px;"><p style="padding: 0px 10px; margin: 0px; color: #FFF; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
      <?php echo $order['other_print_type']; ?>
    </p></td>
  
    </tr>
  <tr style="background-color:#006ea1; color:#FFF;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Projected Ad Spend<span style="color:#fe905f;">*</span></p></td>
    <td style="width: 288px;"><p style="padding: 0px 10px; margin: 0px; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
      <?php echo $order['projected_ad_spent'];?>
    </p></td>
    <td style="width: 192px; "><p style="padding:10px; margin: 0px; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Agencies Competing</p></td>
    <td style="width: 288px; "><p style="padding: 0px 10px; margin: 0px; color: #FFF; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
      <?php echo $order['no_of_agencies_competing'];?>
    </p></td>
    </tr>
  <tr style="background-color:#006ea1; color:#FFF;">
    <td style="width: 192px; ">&nbsp;</td>
    <td align="center" style="width: 288px; ">&nbsp;</td>
    <td style="width: 192px; "><p style="padding:10px; margin: 0px; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Release Date<span style="color:#fe905f;">*</span></p></td>
    <td style="width: 288px;"><p style="padding: 0px 10px; margin: 0px; color: #FFF; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
      <?php echo $order['release_date']; ?>
    </p></td>
    </tr>
    <tr style="background-color:#e77a42;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Mandatories<span style="color:#fe905f;"></span></p></td>
    <td style="width: 288px;"><p style="padding: 0px 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
      <?php echo $order['mandatories'];?>
    </p></td>
    <td style="width: 192px; ">&nbsp;</td>
    <td align="center" style="width: 288px;">&nbsp;</td>
  </tr>
  <tr style="background-color:#e77a42;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Size (cc)<span style="color:#ffffff;">*</span></p></td>
    <td style="width: 288px;"><p style="padding: 0px 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
      <?php echo $order['size_cms'];?>
    </p></td>
    <td style="width: 192px; "><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Width (cm)<span style="color:#ffffff;">*</span></p></td>
    <td style="width: 288px;"><p style="padding: 0px 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php echo $order['width'];?></p></td>
  </tr>
  <tr style="background-color:#e77a42;">
    <td rowspan="2" style="width: 192px;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Languages<span style="color:#ffffff;">*</span></p></td>
    <td rowspan="2" align="left" style="width: 288px;"><p style="padding: 10px 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"> 
    
		<?php echo $order['language'];?>
	</p></td>
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Height (cm)<span style="color:#ffffff;">*</span></p></td>
    <td style="width: 288px;"><p style="padding: 0px 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php echo $order['height'];?></p></td>
  </tr>
  <tr style="background-color:#e77a42;">
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Color Preferences</p></td>
    <td style="width: 288px;"><p style="padding: 0px 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php echo $order['color_preferences'];?></p></td>
  </tr>
  <tr style="background-color:#e77a42;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">No of Options<span style="color:#ffffff;">*</span></p></td>
    <td align="left" style="width: 288px;">
    <p style="padding: 0px 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
    <?php
		echo $order['no_of_options']==1 ? '1' : ($order['no_of_options']==2 ? '2' : '3');
		?></p>
</td>
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Full Color/B&W <span style="color:#ffffff;"></span></p></td>
    <td align="left" style="width: 288px;"><p style="padding: 0px 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php	echo $order['print_ad_type']==1 ? 'Full color' : 'B&W';?> 
    </p></td>
  </tr>
  <tr style="background-color:#e77a42;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Images<span style="color:#ffffff;">*</span></p></td>
    <td align="left" style="width: 288px;">
    <p style="padding: 0px 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"> 
	<?php echo $order['images'];?></p>
    </td>
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Final Output Format<span style="color:#fff;"></span></p></td>
    <td align="left" style="width: 288px;"><p style="padding: 5px 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"> 
	<?php echo $order['final_output_format'];?></p></td>
  </tr>
  <tr style="background-color:#539768; vertical-align: top;">
    <td colspan="4"><p style="padding-top: 10px; margin: 0px; color: #fff; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center;">Target Audience:
Who Are We Talking To? Lifestyle & Behaviour, Habits / Insights On The TG:</p></td>
    </tr>
    <tr style="background-color:#539768; vertical-align: top;">
    <td colspan="4" align="center"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php echo $order['target_audience'];?></p></td>
    </tr>
    <tr align="center" style="background-color:#8fc839; vertical-align: top;">
    <td colspan="4"><p style="padding-top:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Special Instructions<span style="color:#ffffff;"></span></p></td>
    </tr>
    <tr align="center" style="background-color:#8fc839; vertical-align: top;">
    <td colspan="4"><p style="padding: 0px 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
          <?php
		echo $order['job_instruction']==1 ? 'Be Creative' : ($order['job_instruction']==2 ? 'Sophisticated' : 'Follow Instructions Carefully');
		?></p></td>
    </tr>
  <tr style="background-color:#8fc839; vertical-align: top;">
    <td colspan="4"><p style="padding-top: 20px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center;">What Message should the Ad Communicate?</p></td>
    </tr>
  <tr style="background-color:#8fc839; vertical-align: top;">
    <td colspan="4" align="center"><p style="padding-top: 0px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php echo $order['one_single_line_of_text'];?></p></td>
    </tr>
    <tr style="background-color:#8fc839; vertical-align: top;">
    <td colspan="4"><p style="padding-top: 20px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center;">Look & Feel of the Ad / Suggestions</p></td>
    </tr>
    <tr style="background-color:#8fc839; vertical-align: top;">
    <td colspan="4" align="center"><p style="padding: 0px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php echo $order['look_feel'];?></p></td>
    </tr>
    <tr style="background-color:#8fc839; vertical-align: top;">
    <td colspan="4"><p style="padding-top: 20px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center;">What Do We Want Them To Do?</p></td>
    </tr>
    <tr style="background-color:#8fc839; vertical-align: top;">
    <td colspan="4" align="center"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php echo $order['what_do_we_want_them_to_do'];?></p></td>
    </tr>
    <tr style="background-color:#8fc839; vertical-align: top;">
    <td colspan="4"><p style="padding-top: 20px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center;">Attachments (Reference)</p></td>
    </tr> 
    <tr style="background-color:#8fc839; vertical-align: top;">
    <td colspan="4" align="center"><p style="padding: 0px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php echo $order['attachments_info'];?></p></td>
    </tr>
    <tr style="background-color:#8fc839; vertical-align: top;">
    <td colspan="4" align="center"></td>
    </tr>     <tr style="background-color:#8fc839; vertical-align: top;">
    <td colspan="4"><p style="padding-top: 20px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center;">Any other info / Suggestions</p></td>
    </tr>
    <tr style="background-color:#8fc839; vertical-align: top;">
    <td colspan="4" align="center"><p style="padding-bottom: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php echo $order['any_other_info'];?></p></td>
    </tr>
           <tr style="background-color:#fff; vertical-align: top;">
    <td style="width: 192px;">&nbsp;</td>
    <td align="left" style="width: 288px; background-color: #fff;">&nbsp;</td>
    <td style="width: 192px;">&nbsp;</td>
    <td align="right" style="width: 288px; background-color: #fff;">&nbsp;</td>
  </tr>
  <tr style="background-color:#fff; vertical-align: top;">
    <td style="width: 192px;">&nbsp;</td>
    <td align="left" style="width: 288px; background-color: #fff;">&nbsp;</td>
    <td style="width: 192px;">&nbsp;</td>
    <td align="right" style="width: 288px; background-color: #fff;"></td>
  </tr>
</table>

</div>

