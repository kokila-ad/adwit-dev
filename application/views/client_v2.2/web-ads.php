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
      <div id="ad-form-p">Web Ad Form</div>
      <div id="ad-form-s">
      <form id="contactform">      
        <div id="ad-form-s-l">
        <p class="contact"><label for="name">Ad Type</label></p>
        <select class="select-style gender" id="spec_sold_ad" name="spec_sold_ad">
          <option value="0" <?php echo set_select('spec_sold_ad', '0');?> >New ad</option>
          <option value="1"  <?php echo set_select('spec_sold_ad', '1');?> >Pickup / Template ad</option>
          <option value="2"  <?php echo set_select('spec_sold_ad', '2');?> >Resize ad</option>
        </select>         
        <p class="contact"><label for="name">Advertiser Name</label></p>
        <input type="text" id="advertiser_name" name="advertiser_name" value="<?php echo set_value('advertiser_name');?>"/>
        <p class="contact"><label for="name">Job Name / No</label></p>
        <input type="text" id="job_no" name="job_no" value="<?php echo set_value('job_no'); ?>" />
		<p class="contact"><label for="name">Date Needed</label></p>
        <input type="text" id="date_needed" name="date_needed" value="<?php echo set_value('date_needed'); ?>"/>
        <p class="contact"><label for="name">Publish Date</label></p>
        <input type="text" id="publish_date" name="publish_date"  value="<?php echo set_value('publish_date');?>" />
        <p class="contact"><label for="name">Publication Name</label></p>
        <input type="text" id="publication_name" name="publication_name"  value="<?php echo set_value('publication_name');?>"/>
         <p class="contact"><label for="name">Color Preferences</label></p>
        <input type="text" id="color_preferences" name="color_preferences"  value="<?php echo set_value('color_preferences');?>"/>
        <p class="contact"><label for="name">Font Preferences</label></p>
        <input type="text" id="font_preferences" name="font_preferences" value="<?php echo set_value('font_preferences');?>"/>
        </div>
        <div id="ad-form-s-r">
       <p class="contact"><label for="name">Size (in Pixels)</label></p>
        <select class="select-style gender" id="pixel_size" name="pixel_size">
            	<option value="">Select</option>
                <?php
					$results = $this->db->get('pixel_sizes')->result_array();
					foreach($results as $result)
					{
echo '<option value="'.$result['id'].'" '.set_select('pixel_size',$result['id']).' >'.$result['width'].' x '.$result['height'].'('.$result['name'].')'.'</option>';
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
<p class="contact"><label for="name">Format</label></p>
        <select class="select-style gender" id="ad_format" name="ad_format">
        <option value="">Select</option>
        <?php
					$results = $this->db->get('web_ad_formats')->result_array();
					foreach($results as $result)
					{
						echo '<option value="'.$result['id'].'" '.set_select('ad_format',$result['id']).' >'.$result['name'].'</option>';	
					}
				?>
      </select>
        <p class="contact"><label for="name">Web Ad Type</label></p>
        <select class="select-style gender" id="web_ad_type" name="web_ad_type">
        <option value="">Select</option>
        <option value="Static" <?php echo set_select('web_ad_type', 'Static'); ?> >Static</option>
        <option value="Animated" <?php echo set_select('web_ad_type', 'Animated'); ?> >Animated</option>
      </select>
      <p class="contact"><label for="name">Maximum File Size (In KBs)</label></p>
		<input type="text" id="maxium_file_size" name="maxium_file_size"  value="<?php echo set_value('maxium_file_size'); ?>" />
        <p class="contact"><label for="name">Copy/Content </label></p>
        <select class="select-style gender" id="copy_content" name="copy_content">
        <option value="">Select</option>
        <option value="1" <?php echo set_select('copy_content','1');?> >Included in the form</option>
        <option value="2" <?php echo set_select('copy_content','2');?> >Sent separately</option>
        <option value="3" <?php echo set_select('copy_content','3');?> >Changes only</option>
      </select>
       <p class="contact"><label for="name">Job Instruction </label></p>
        <select class="select-style gender" id="job_instruction" name="job_instruction">
        <option value="">Select</option>
        <option value="1" <?php echo set_select('job_instruction','1');?> >Follow Instructions Carefully</option>
        <option value="2" <?php echo set_select('job_instruction','2');?> >Be Creative</option>
      </select>       
        <p class="contact"><label for="name">ArtWork </label></p>
        <select class="select-style gender" id="art_work" name="art_work">
        <option value="">Select</option>
        <option value="1"<?php echo set_select('art_work', '1'); ?>>Use additional art if required</option>
        <option value="2" <?php echo set_select('art_work', '2'); ?> >Modify art provided if necessary</option>
        <option value="3" <?php echo set_select('art_work', '3'); ?>  >Use art provided without change</option>
        </select>
       
         </div>
        <div id="ad-form-s1">
        </div>
        <div id="ad-form-s2">
        </div>
        <div id="ad-form-s5">
        <div id="ad-form-s5a">
        <p class="contact"><label for="name">Files Sent Via</label></p>
        </div>
        <div id="ad-form-s5b">&nbsp;</div>
        <div id="ad-form-s5e">
        <p class="contact"><label for="name">Ftp</label></p>
        <select class="select-style gender" id="no_fax_items" name="no_fax_items">
            <option value="1"<?php echo set_select('no_fax_items', '1'); ?> >Yes</option>
            <option value="0"<?php echo set_select('no_fax_items', '0'); ?>, selected="selected" >No</option>
            </select>
        </div>
<div id="ad-form-s5c">
  <p class="contact"><label for="name">Email</label></p>
        <select class="select-style gender" id="no_email_items" name="no_email_items">
            <option value="1"<?php echo set_select('no_email_items', '1'); ?>, >Yes</option>
            <option value="0"<?php echo set_select('no_email_items', '0'); ?>, selected="selected" >No</option>
            </select>
      </div>
      <div id="ad-form-s5f">
      <p class="contact"><label for="name">Along with this Form</label></p>
      <select class="select-style gender" id="with_form" name="with_form">
            <option value="1"<?php echo set_select('with_form', '1'); ?> >Yes</option>
            <option value="0"<?php echo set_select('with_form', '0'); ?>, selected="selected" >No</option>
            </select>
      </div>
<div id="ad-form-s5d">&nbsp;</div>
        </div>
        <div id="ad-form-s3">
  <p class="contact"><label for="name">Copy/Content</label></p>
        <textarea name="copy_content_description" id="copy_content_description" ><?php echo set_value('copy_content_description');?></textarea>
        <p class="contact"><label for="name">Notes & Instructions</label></p>
        <textarea id="notes" name="notes"><?php echo set_value('notes');?></textarea>
      </div>
        <div id="ad-form-s4">        
        <input class="buttom" type="submit" value="Submit to Upload Files" />
        </div>
      </form>
      </div>
    </div>
</div>