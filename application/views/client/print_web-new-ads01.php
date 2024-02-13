
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
		
		$('#template_used').change(function(e) {
            if($('#template_used').val()=='1') $('#template_name').show();
			else $('#template_name').hide();
        });
		
		<?php if(set_value('template_used')=='1'):?>
			$('#template_name').show();
		<?php else:?>
			$('#template_name').hide();
		<?php endif;?>
		
		$('#pixel_size').change(function(e) {
            if($('#pixel_size').val()=='custom') $('#ad-form-s6e').show();
			else $('#ad-form-s6e').hide();
        });
		
		<?php if(set_value('pixel_size')=='custom'):?>
			$('#ad-form-s6e').show();
		<?php else:?>
			$('#ad-form-s6e').hide();
		<?php endif;?>
	});
	
	function fill() {
        var txt8 = document.getElementById("width").value-0;
        var txt9 = document.getElementById("height").value-0;
        document.getElementById("size_inches").value = txt8 * txt9;
		
	}
</script>


<div class="form">
<div id="ad-form">
      <div id="ad-form-h"><?php echo $publications['name'];?></div>
      <div id="ad-form-p">New Print & Online Ad</div>
      <div id="ad-form-s">
      <form id="contactform">      
        <div id="ad-form-s-l">
        <p class="contact"><label for="name">Advertiser Name <span class="mandatory">*</span></label></p>
        <input type="text" id="advertiser_name" name="advertiser_name" value="<?php echo set_value('advertiser_name');?>"/>
        <p class="contact"><label for="name">Unique Job Name / Number <span class="mandatory">*</span></label></p>
        <input type="text" id="job_no" name="job_no" value="<?php echo set_value('job_no'); ?>" />
		<p class="contact"><label for="name">Date Needed</label></p>
        <input type="text" id="date_needed" name="date_needed" value="<?php echo set_value('date_needed'); ?>" autocomplete="off"/>
        <p class="contact"><label for="name">Publish Date</label></p>
        <input type="text" id="publish_date" name="publish_date"  value="<?php echo set_value('publish_date');?>" autocomplete="off"/>
        <p class="contact"><label for="name">Publication Name</label></p>
        <input type="text" id="publication_name" name="publication_name"  value="<?php echo set_value('publication_name');?>"/>
        
        </div>
        <div id="ad-form-s-r">
       <p class="contact"><label for="name">Width (in inches) <span class="mandatory">*</span></label></p>
        <input name="width" type="text" id="width" value="<?php echo set_value('width'); ?>" />
        <p class="contact"><label for="name">Height (in inches) <span class="mandatory">*</span></label></p>
        <input name="height" type="text" id="height" value="<?php echo set_value('height'); ?>" />
        <p class="contact"><label for="name">Full Color/B&W/Spot <span class="mandatory">*</span> </label></p>
        <select class="select-style gender" id="print_ad_type" name="print_ad_type">
          <option value="">Select</option>
          <?php
					$results = $this->db->get('print_ad_types')->result_array();
					foreach($results as $result)
					{
						echo '<option value="'.$result['id'].'" '.set_select('print_ad_type',$result['id']).' >'.$result['name'].'</option>';	
					}
				?>
        </select>
		<p class="contact"><label for="name">Copy/Content <span class="mandatory">*</span> </label></p>
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
		<option value="3" <?php echo set_select('job_instruction','3');?> >Camera Ready Ad</option>
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
        <p class="contact"><label for="name">Color Preferences</label></p>
        <input type="text" id="color_preferences" name="color_preferences"  value="<?php echo set_value('color_preferences');?>"/>
        </div>
        <div id="ad-form-s2">
        <p class="contact"><label for="name">Font Preferences</label></p>
        <input type="text" id="font_preferences" name="font_preferences" value="<?php echo set_value('font_preferences');?>"/>
        </div>
        <div id="ad-form-s5">
        <div id="ad-form-s6">
        <div id="ad-form-s6a">Online Ad</div>
        <div id="ad-form-s6b">
        <p class="contact"><label for="name">Format <span class="mandatory">*</span> </label></p>
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
        </div>
        <div id="ad-form-s6c">
        <p class="contact"><label for="name">Size (in Pixels) <span class="mandatory">*</span></label></p>
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
        </div>
        <div id="ad-form-s6e">
        <div id="ad-form-s6ea">
        <p class="contact"><label for="name">Width (in Pixels)</label></p>
        <input name="custom_width" type="text" id="custom_width" value="<?php echo set_value('custom_width'); ?>"  />
        </div>
        <div id="ad-form-s6eb">
        <p class="contact"><label for="name">Height (in Pixels)</label></p>
        <input name="custom_height" type="text" id="custom_height" value="<?php echo set_value('custom_height'); ?>" />
        </div>
        </div>
<div id="ad-form-s6b">
  <p class="contact"><label for="name">Maximum File Size (In KBs) <span class="mandatory">*</span> </label></p>
        <input type="text" id="maxium_file_size" name="maxium_file_size"  value="<?php echo set_value('maxium_file_size'); ?>"/>
      </div>
        <div id="ad-form-s6c">
        <p class="contact"><label for="name">Web Ad Type <span class="mandatory">*</span></label></p>
        <select class="select-style gender" id="web_ad_type" name="web_ad_type">
        <option value="">Select</option>
        <option value="0" <?php echo set_select('web_ad_type', '0'); ?> >Static</option>
        <option value="1" <?php echo set_select('web_ad_type', '1'); ?> >Animated</option>
      </select>
        </div>
        </div>
        <div id="ad-form-s5b">&nbsp;</div>
        </div>
        <div id="ad-form-s3">
  <p class="contact"><label for="name">Copy/Content <span class="mandatory">*</span></label></p>
        <textarea name="copy_content_description" id="copy_content_description" ><?php echo set_value('copy_content_description');?></textarea>
        <p class="contact"><label for="name">Notes & Instructions</label></p>
        <textarea id="notes" name="notes"><?php echo set_value('notes');?></textarea>
        </div>
        <div id="ad-form-s4">        
        <input class="buttom" type="submit" name="submit" value="SUBMIT" />
        </div>
      
	  </form>
	  </div>
      </div>
    </div>


<?php
	$this->load->view("client/footer");
?>