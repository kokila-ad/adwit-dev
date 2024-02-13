
    <div id="container">
<div id="content">
<div>&nbsp;</div>
    <div class="form">
    <table align="center"  border="0" cellspacing="0" cellpadding="0" style=" width: 960px; font-family:Tahoma, Geneva, sans-serif; font-size:13px; margin:0;">
    <tr>
      <td style="width:100px;"><p style="padding-left:20px; font-weight:bold;">Order No :</p></td>
      <td style="width:100px;"><?php echo $order[0]['id'];?></td>
      <td style="width:760px;"><p style="text-align: right; padding-right: 20px;"><?php echo $order[0]['created_on'];?></p></td>
      </tr>
</table>
    <table width="960" border="0" cellspacing="1" cellpadding="4">
  <tr style="background-color:#333;">
    <td colspan="3" style="width: 672px;"><p style="padding: 15px; margin: 0px; color: #FFF; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php if(isset($publications['name'])) echo $publications['name'];?></p></td>
    <td style="width:288px;"><p style="padding: 0px; margin: 0px; color: #FFF; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center;">New Web Ad</p></td>
  </tr>
  <tr style="background-color:#eee;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Adrep Email id</p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php echo $client['email_id'];?></p></td>
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Publish Date</p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
	<?php if($order[0]['publish_date'] == '0000-00-00')
	{ echo ""; } else { echo $order[0]['publish_date']; }?></p></td>
  </tr>
  <tr style="background-color:#eee;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Advertiser Name</p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php echo $order[0]['advertiser_name'];?></p></td>
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Publication Name</p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"> <?php echo $order[0]['publication_name']; ?></p></td>
    </tr>
  <tr style="background-color:#eee;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Job Name / No</p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php echo $order[0]['job_no'];?></p></td>
	
	<?php 
		if($order[0]['ad_format']=='5'){
    		if(isset($order[0]['flexitive_size'])){
    			$flexitive_size = $this->db->get_where('flexitive_size',array('id' => $order[0]['flexitive_size']))->row_array(); 
    			echo'<td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Size (in ratio)</p></td>';
    			echo'<td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">'.$flexitive_size['ratio'].'</p></td>';
    		}else{ //multiple size
    		    $orders_multiple_size = $this->db->query("SELECT orders_multiple_size.*, flexitive_size.ratio FROM `orders_multiple_size`
							                                 LEFT JOIN `flexitive_size` ON flexitive_size.id = orders_multiple_size.size_id
							                                  WHERE orders_multiple_size.order_id = '".$order[0]['id']."'")->result_array();
				$orders_multiple_custom_size = $this->db->query("SELECT * FROM `orders_multiple_custom_size`
							                                         WHERE order_id = '".$order[0]['id']."'")->result_array();
			    echo'<td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Size (in ratio)</p></td>';
			    echo'<td align="left" style="width: 288px; background-color: #eee;">';
				if(isset($orders_multiple_size[0]['id'])){
					foreach($orders_multiple_size as $msize){
						if($msize['size_id'] != NULL){
						    echo '<p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">'.$msize['ratio'].'</p>';
						}
					}
				}
				if(isset($orders_multiple_custom_size[0]['id'])){
				    foreach($orders_multiple_custom_size as $mcsize){
					    echo'<p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">'.$mcsize['custom_width'].'x'.$mcsize['custom_height'].'</p>';
					}
				}
				echo '</td>';
    		}
		} else {
	?>
		<td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Size (in Pixels)</p></td>
		<td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
		  <?php
					if($order[0]['pixel_size']!='custom' && $order[0]['pixel_size'] != ''){
						 $results = $this->db->get_where('pixel_sizes',array('id' => $order[0]['pixel_size']))->result_array();
						 if(isset($results[0]['width'])){ echo $results[0]['width'].' x '.$results[0]['height'].' ('.$results[0]['name'].')'; }
					}else{ //multiple size
						$orders_multiple_size = $this->db->query("SELECT orders_multiple_size.*, pixel_sizes.width, pixel_sizes.height, pixel_sizes.name FROM `orders_multiple_size`
							                                         LEFT JOIN `pixel_sizes` ON pixel_sizes.id = orders_multiple_size.size_id
							                                            WHERE orders_multiple_size.order_id = '".$order[0]['id']."'")->result_array();
						$orders_multiple_custom_size = $this->db->query("SELECT * FROM `orders_multiple_custom_size`
							                                         WHERE order_id = '".$order[0]['id']."'")->result_array();
					    if(isset($orders_multiple_size[0]['id'])){
							//echo '<p class="margin-0 text-grey">Size <small class="text-grey">(in Pixels)</small></p>';
							foreach($orders_multiple_size as $msize){
							    if($msize['size_id'] != NULL){
							        echo '<p>'.$msize['width'].' X '.$msize['height'].' ('.$msize['name'].')</p>';
							    }
							 }
						}
						if(isset($orders_multiple_custom_size[0]['id'])){
    						foreach($orders_multiple_custom_size as $mcsize){
    						    echo '<p>'.$mcsize['custom_width'].' X '.$mcsize['custom_height'].'<p/>';
    						}
    					}
					} 
			   ?>
		</p></td>
		
	<?php } ?>
    </tr>
	
  <?php if($order[0]['pixel_size']=='custom'){ ?>
  <tr style="background-color:#eee;">
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Width (in Pixels)</p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php echo $order[0]['custom_width']; ?></p></td>
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Height (in Pixels)</p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php echo $order[0]['custom_height']; ?></p></td>
  </tr>
  <?php } ?>
  
  <tr style="background-color:#eee;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Date Needed</p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 010px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
	<?php if($order[0]['date_needed'] == '0000-00-00')
	{ echo ""; } else { echo $order[0]['date_needed']; }?>
	</p></td>
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Format</p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
      <?php
                $results = $this->db->get_where('web_ad_formats',array('id' => $order[0]['ad_format']))->result_array();
                if(isset($results[0]['name'])){ echo $results[0]['name']; }
           ?>
    </p></td>
    </tr>
  <tr style="background-color:#eee;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Copy/Content</p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
      <?php if($order[0]['copy_content']==0) { echo ""; } else {
	  echo $order[0]['copy_content']==1 ? 'Included in the form' : ($order[0]['copy_content']==2 ? 'Sent separately' : 'Changes only'); }?>
    </p></td>
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Web Ad Type</p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
      <?php
                    echo $order[0]['web_ad_type']!='Animated' ? 'Static' : 'Animated';
               ?>
    </p></td>
    </tr>
  <tr style="background-color:#eee;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Job Instruction</p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding:10px;  margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
      <?php if($order[0]['job_instruction']==0){ echo ""; }else {
	  echo $order[0]['job_instruction']!=1 ? 'Follow Instructions Carefully' : 'Be Creative'; } ?>
    </p></td>
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Maximum File Size (In KBs)</p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php echo $order[0]['maxium_file_size']; ?></p></td>
    </tr>  
  <tr style="background-color:#eee; vertical-align: top;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">ArtWork</p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding:10px;  margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
      <?php if($order[0]['art_work']==0){ echo ""; }else {
	  echo $order[0]['art_work']==1 ? 'Use additional art if required' : ($order[0]['art_work']==2 ? 'Modify art provided if necessary' : 'Use art provided without change');}
		?>
    </p></td>
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Color Preferences</p></td>
    <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php echo $order[0]['color_preferences'];?></p></td>
    </tr>
    <tr style="background-color:#eee; vertical-align: top;">
        <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Pickup Ad No.</p></td>
        <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
            <?php if($order[0]['pickup_adno'] != '') echo $order[0]['pickup_adno']; else echo ''; ?></p>
        </td>
        <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Font Preferences</p></td>
        <td align="left" style="width: 288px; background-color: #eee;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php echo $order[0]['font_preferences'];?></p></td>
    </tr>
 
    <tr style="background-color:#eee; vertical-align: top;">
        <td colspan="4"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center;">Copy/Content</p></td>
    </tr>
    <tr style="background-color:#eee; vertical-align: top;">
        <td colspan="4" align="center"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
    	<?php $order[0]['copy_content_description'] = str_replace(PHP_EOL,'<br/>', $order[0]['copy_content_description']);
    	echo $order[0]['copy_content_description'];?></p>
    	</td>
    </tr>
    <tr style="background-color:#eee; vertical-align: top;">
        <td colspan="4"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center;">Notes & Instructions</p></td>
    </tr>
    <tr style="background-color:#eee; vertical-align: top;">
    <td colspan="4" align="center"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php echo htmlspecialchars($order[0]['notes'], ENT_QUOTES, 'UTF-8'); ?></p></td>
    </tr>     
</table>
        
            <div>&nbsp;</div>
        </div>
        </div><!-- #content-->
    </div>
    </section>