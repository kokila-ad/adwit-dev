
    <div id="container">
<div id="content">
<div>&nbsp;</div>
    <div class="form">
    <div><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Order No. <?php echo $order['id'];?></p></div>
    <table width="960" border="0" cellspacing="1" cellpadding="4">
  <tr style="background-color:#333;">
    <td colspan="3" style="width: 672px;"><p style="padding: 15px; margin: 0px; color: #FFF; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php echo $publications['name'];?></p></td>
    <td style="width:288px;"><p style="padding: 0px; margin: 0px; color: #FFF; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center;">Web Ad Form</p></td>
  </tr>
  <tr style="background-color:#eee;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Ad Type<span style="color:#F00;">*</span></p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php 
             if($order['spec_sold_ad']==0){
			 echo 'New ad';
			 }
			 if($order['spec_sold_ad']==1){ 
			 echo'Pickup/Template ad';
			 }
			 if($order['spec_sold_ad']==2){
			 echo'Resize ad';
			 }
         ?></p></td>
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Publish Date<span style="color:#F00;">*</span></p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php echo $order['publish_date'];?></p></td>
  </tr>
  <tr style="background-color:#eee;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Adrep Email id</p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php echo $client['email_id'];?></p></td>
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Publication Name</p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"> <?php echo $order['publication_name']; ?></p></td>
    </tr>
  <tr style="background-color:#eee;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Advertiser Name<span style="color:#F00;">*</span></p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php echo $order['advertiser_name'];?></p></td>
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Size (in Pixels)<span style="color:#F00;">*</span></p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
      <?php
                if($order['pixel_size']!='custom'):
					 $results = $this->db->get_where('pixel_sizes',array('id' => $order['pixel_size']))->result_array();
					 echo $results[0]['width'].' x '.$results[0]['height'].' ('.$results[0]['name'].')';
                else:
					 echo 'Custom';
				endif;
           ?>
    </p></td>
    </tr>
      <?php if($order['pixel_size']=='custom')
  {?>
  <tr style="background-color:#eee;">
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Width (in Pixels)<span style="color:#F00;">*</span></p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php echo $order['custom_width']; ?></p></td>
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Height (in Pixels)<span style="color:#F00;">*</span></p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php echo $order['custom_height']; ?></p></td>
  </tr>
  <?php } ?>
  <tr style="background-color:#eee;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Job Name / No<span style="color:#F00;">*</span></p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php echo $order['job_no'];?></p></td>
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Format<span style="color:#F00;">*</span></p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
      <?php
                $results = $this->db->get_where('web_ad_formats',array('id' => $order['ad_format']))->result_array();
                echo $results[0]['name'];
           ?>
    </p></td>
    </tr>
  <tr style="background-color:#eee;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Date Needed<span style="color:#F00;">*</span></p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 010px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php echo $order['date_needed']; ?></p></td>
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Web Ad Type<span style="color:#F00;">*</span></p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
      <?php
                    echo $order['web_ad_type']!='Animated' ? 'Static' : 'Animated';
               ?>
    </p></td>
    </tr>
  <tr style="background-color:#eee;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Copy/Content<span style="color:#F00;">*</span></p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php
                        echo $order['copy_content']==1 ? 'Included in the form' : ($order['copy_content']==2 ? 'Sent separately' : 'Changes only');
                   ?></p></td>
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Maximum File Size (In KBs)<span style="color:#F00;">*</span></p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php echo $order['maxium_file_size']; ?></p></td>
    </tr>  
  <tr style="background-color:#eee; vertical-align: top;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Job Instruction<span style="color:#F00;">*</span></p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding:10px;  margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php
          		echo $order['job_instruction']!=1 ? 'Follow Instructions Carefully' : 'Be Creative';
		  	?></p></td>
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Color Preferences</p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php echo $order['color_preferences'];?></p></td>
    </tr>
  <tr style="background-color:#eee; vertical-align: top;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">ArtWork<span style="color:#F00;">*</span></p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding:10px;  margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php
		echo $order['art_work']==1 ? 'Use additional art if required' : ($order['art_work']==2 ? 'Modify art provided if necessary' : 'Use art provided without change');
		?></p></td>
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Font Preferences</p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php echo $order['font_preferences'];?></p></td>
    </tr>
  <tr style="background-color:#eee; vertical-align: top;">
  	<td>&nbsp;</td>
    <td><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center;">No. of Files Sent Via<span style="color:#F00;">*</span></p></td>
    <td align="center" colspan="2">
      <table width="0" border="0" cellspacing="1" cellpadding="4">
      <tr>
          <td style="width:35px;"><p style="padding: 5px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Ftp:</p></td>
            <td style="width:60px;"><p style="padding: 0px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">			
			<?php	echo $order['no_fax_items']==1 ? 'yes' : 'no';?></p></td>
			
          <td style="width: 55px;"><p style="padding: 5px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: right;">Email:</p></td>
            <td style="width: 60px;"><p style="padding: 0px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">			
			<?php	echo $order['no_email_items']==1 ? 'yes' : 'no';?></p></td>
			
          <td style="width: 150px;"><p style="padding: 5px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: right;">Along with this Form:</p></td>
            <td style="width: 60px;"><p style="padding: 0px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
			
			<?php	echo $order['with_form']==1 ? 'yes' : 'no';?></p></td>
			
          </tr>        
        </table>
    </td>
  </tr>
  
  <tr style="background-color:#eee; vertical-align: top;">
    <td colspan="4"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center;">Copy/Content</p></td>
    </tr>
  <tr style="background-color:#eee; vertical-align: top;">
    <td colspan="4" align="center"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
	<?php $order['copy_content_description'] = str_replace(PHP_EOL,'<br/>', $order['copy_content_description']);
	echo $order['copy_content_description'];?></p></td>
    </tr>
    <tr style="background-color:#eee; vertical-align: top;">
    <td colspan="4"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center;">Notes & Instructions</p></td>
    </tr>
    <tr style="background-color:#eee; vertical-align: top;">
    <td colspan="4" align="center"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php echo $order['notes'];?></p></td>
    </tr>     
</table>
        
            <div>&nbsp;</div>
        </div>
        </div><!-- #content-->
    </div>
    </section>