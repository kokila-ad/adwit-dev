<link rel="stylesheet" href="jq-ui/themes/base/jquery.ui.all.css" />
<script src="jq-ui/ui/jquery.ui.core.js"></script>
<script src="jq-ui/ui/jquery.ui.datepicker.js"></script>

<link rel="stylesheet" href="color-picker/jquery.miniColors.css" />
<script language="JavaScript" src="color-picker/jquery.miniColors.js"></script>

<script type="text/javascript">
	
	$(document).ready(function(e) {    

		$('.color-picker').miniColors();
		
   		$( "#publish_date" ).datepicker({ minDate: 0, maxDate: "+1Y", dateFormat: 'dd-mm-yy' });
		
		$( "#date_needed" ).datepicker({ minDate: 0, maxDate: "+1Y", dateFormat: 'dd-mm-yy'});
		
		$('#pixel_size').change(function(e) {
            if($('#pixel_size').val()=='custom') $('#ad-form-sr-custom').show();
			else $('#ad-form-sr-custom').hide();
        });		
		<?php if(set_value('pixel_size')=='custom'):?>
			$('#ad-form-sr-custom').show();
		<?php else:?>
			$('#ad-form-sr-custom').hide();
		<?php endif;?>
	});
</script>

<div class="form">

<div id="ad-form">
      <div id="ad-form-h"><?php echo $publications['name'];?></div>
      <div id="ad-form-p">New Web Ad</div>
      <div id="ad-form-s">
      <form id="contactform">      
        <div id="ad-form-s-l">
        <p class="contact"><label for="name">Advertiser Name <span class="mandatory">*</span></label></p>
        <input type="text" id="advertiser_name" name="advertiser_name" value="<?php if(isset($pick_order))echo $pick_order['advertiser_name'];else echo set_value('advertiser_name');?>" />
        <p class="contact"><label for="name">Unique Job Name / Number <span class="mandatory">*</span></label></p>
        <input type="text" id="job_no" name="job_no"  pattern="[a-zA-Z0-9 ]{1,50}" value="<?php if(isset($pick_order))echo $pick_order['job_no'];else echo set_value('job_no');?>" />
		<p class="contact"><label for="name">Date Needed</label></p>
        <input type="text" id="date_needed" name="date_needed" value="<?php if(isset($pick_order)){ $date_needed=date("d-m-Y", strtotime($pick_order['date_needed'])); echo $date_needed; }else echo set_value('date_needed');?>" autocomplete="off"/>
        <p class="contact"><label for="name">Publish Date</label></p>
        <input type="text" id="publish_date" name="publish_date"  value="<?php if(isset($pick_order)){ $publish_date=date("d-m-Y", strtotime($pick_order['publish_date'])); echo $publish_date;}else echo set_value('publish_date');?>" autocomplete="off"/>
        <p class="contact"><label for="name">Publication Name</label></p>
        <input type="text" id="publication_name" name="publication_name"  value="<?php if(isset($pick_order))echo $pick_order['publication_name']; else echo set_value('publication_name');?>" />
         <p class="contact"><label for="name">Color Preferences</label></p>
        <input type="text" id="color_preferences" name="color_preferences"  value="<?php if(isset($pick_order))echo $pick_order['color_preferences'];else echo set_value('color_preferences');?>" />
        <p class="contact"><label for="name">Font Preferences</label></p>
        <input type="text" id="font_preferences" name="font_preferences" value="<?php if(isset($pick_order))echo $pick_order['font_preferences'];else echo set_value('font_preferences');?>" />
        </div>
        <div id="ad-form-s-r">
       <p class="contact"><label for="name">Size (in Pixels) <span class="mandatory">*</span></label></p>
        <select class="select-style gender" id="pixel_size" name="pixel_size">
            	<option value="">Select</option>
                <?php
					$results = $this->db->get('pixel_sizes')->result_array();
					foreach($results as $result)
					{
						echo '<option value="'.$result['id'].'" '.($result['id']==$pick_order['pixel_size'] ? 'selected="selected"': '').set_select('pixel_size',$result['id']).' >'.$result['width'].' x '.$result['height'].'('.$result['name'].')'.'</option>';					
						//echo '<option value="'.$result['id'].'" '.set_select('pixel_size',$result['id']).' >'.$result['width'].' x '.$result['height'].'('.$result['name'].')'.'</option>';
					}
				?>
   <option value="custom" <?php echo set_select('pixel_size', 'custom'); ?> >Custom</option>
    </select>
        <div id="ad-form-sr-custom">
        <p class="contact"><label for="name">Width (in Pixels)</label></p>
        <input name="custom_width" type="text" id="custom_width" value="<?php echo set_value('custom_width'); ?>" />
        <p class="contact"><label for="name">Height (in Pixels)</label></p>
        <input name="custom_height" type="text" id="custom_height" value="<?php echo set_value('custom_height'); ?>" />
        </div>
<p class="contact"><label for="name">Format <span class="mandatory">*</span></label></p>
        <select class="select-style gender" id="ad_format" name="ad_format">
        <option value="">Select</option>
        <?php
					$results = $this->db->get('web_ad_formats')->result_array();
					foreach($results as $result)
					{
						echo '<option value="'.$result['id'].'" '.($result['id']==$pick_order['ad_format'] ? 'selected="selected"': '').set_select('ad_format',$result['id']).' >'.$result['name'].'</option>';	
						//echo '<option value="'.$result['id'].'" '.set_select('ad_format',$result['id']).' >'.$result['name'].'</option>';	
					}
				?>
      </select>
        <p class="contact"><label for="name">Web Ad Type <span class="mandatory">*</span></label></p>
        <select class="select-style gender" id="web_ad_type" name="web_ad_type">
        <option value="">Select</option>
        <option value="Static" <?php echo set_select('web_ad_type', 'Static'); if(isset($pick_order) && $pick_order['web_ad_type']=='Static')echo 'selected="selected"'; ?> >Static</option>
        <option value="Animated" <?php echo set_select('web_ad_type', 'Animated'); if(isset($pick_order) && $pick_order['web_ad_type']=='Animated')echo 'selected="selected"'; ?> >Animated</option>
      </select>
      <p class="contact"><label for="name">Maximum File Size (In KBs) <span class="mandatory">*</span></label></p>
		<input type="text" id="maxium_file_size" name="maxium_file_size"  value="<?php if(isset($pick_order))echo $pick_order['maxium_file_size']; else echo set_value('maxium_file_size'); ?>" />
        <p class="contact"><label for="name">Copy/Content <span class="mandatory">*</span> </label></p>
        <select class="select-style gender" id="copy_content" name="copy_content">
        <option value="">Select</option>
		<option value="1" <?php if(isset($pick_order) && $pick_order['copy_content']=='1')echo 'selected';else echo set_select('copy_content','1');?> >Included in the form</option>
        <option value="2" <?php if(isset($pick_order) && $pick_order['copy_content']=='2')echo 'selected';else echo set_select('copy_content','2');?> >Sent separately</option>
        <option value="3" <?php if(isset($pick_order) && $pick_order['copy_content']=='3')echo 'selected';else echo set_select('copy_content','3');?> >Changes only</option>
      </select>
       <p class="contact"><label for="name">Job Instruction </label></p>
        <select class="select-style gender" id="job_instruction" name="job_instruction">
        <option value="">Select</option>
        <option value="1" <?php if(isset($pick_order) && $pick_order['job_instruction']=='1')echo 'selected';else echo set_select('job_instruction','1');?> >Follow Instructions Carefully</option>
        <option value="2" <?php if(isset($pick_order) && $pick_order['job_instruction']=='2')echo 'selected';else echo set_select('job_instruction','2');?> >Be Creative</option>
		<option value="3" <?php if(isset($pick_order) && $pick_order['job_instruction']=='3')echo 'selected';else echo set_select('job_instruction','3');?> >Camera Ready Ad</option>
	  </select>       
        <p class="contact"><label for="name">ArtWork </label></p>
        <select class="select-style gender" id="art_work" name="art_work">
        <option value="">Select</option>
        <option value="1"<?php if(isset($pick_order) && $pick_order['art_work']=='1')echo 'selected';else echo set_select('art_work', '1'); ?>>Use additional art if required</option>
        <option value="2"<?php if(isset($pick_order) && $pick_order['art_work']=='2')echo 'selected';else echo set_select('art_work', '2'); ?>>Modify art provided if necessary</option>
        <option value="3"<?php if(isset($pick_order) && $pick_order['art_work']=='3')echo 'selected';else echo set_select('art_work', '3'); ?>>Use art provided without change</option>
        </select>
       
	   <?php if($client['rush']=='1'){ ?> 
		<p><input type="checkbox" name="rush" value="1" style="width:20px;"> 
		<label for="name"><span></span>Rush</label></p>
		<?php } ?>	
	   
         </div>
        <div id="ad-form-s1">
        </div>
        <div id="ad-form-s2">
        </div>
        <div id="ad-form-s3">
  <p class="contact"><label for="name">Copy/Content <span class="mandatory">*</span></label></p>
        <textarea name="copy_content_description" id="copy_content_description" ><?php echo set_value('copy_content_description');?></textarea>
        <p class="contact"><label for="name">Notes & Instructions</label></p>
        <textarea id="notes" name="notes"><?php echo set_value('notes');?></textarea>
      </div>
        <div id="ad-form-s4">        
        <input class="buttom" type="submit" value="SUBMIT" name="submit_form" id="submit_form" />
        </div>
      </form>
      </div>
    </div>
</div>
<!--
<script type="text/javascript">
	$('#submit_form').click(function(){ 
		$(this).prop('disabled', true);
	});
</script>-->