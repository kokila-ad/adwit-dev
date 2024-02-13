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
      <div id="ad-form-p">Print & Web Ad Form</div>
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
        <p class="contact"><label for="name">Unique Job Name / Number</label></p>
        <input type="text" id="job_no" name="job_no" pattern="[a-zA-Z0-9 ]{1,50}" value="<?php echo set_value('job_no'); ?>" />
		<p class="contact"><label for="name">Date Needed</label></p>
        <input type="text" id="date_needed" name="date_needed" value="<?php echo set_value('date_needed'); ?>" autocomplete="off"/>
        <p class="contact"><label for="name">Publish Date</label></p>
        <input type="text" id="publish_date" name="publish_date"  value="<?php echo set_value('publish_date');?>" autocomplete="off"/>
        <p class="contact"><label for="name">Publication Name</label></p>
        <input type="text" id="publication_name" name="publication_name"  value="<?php echo set_value('publication_name');?>"/>
        
        </div>
        <div id="ad-form-s-r">
       <p class="contact"><label for="name">Width (in inches)</label></p>
        <input name="width" type="text" id="width" value="<?php echo set_value('width'); ?>" />
        <p class="contact"><label for="name">Height (in inches)</label></p>
        <input name="height" type="text" id="height" value="<?php echo set_value('height'); ?>" />
        <p class="contact"><label for="name">Full Color/B&W/Spot </label></p>
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
        <div id="ad-form-s6a">Web Ad</div>
        <div id="ad-form-s6b">
        <p class="contact"><label for="name">Format </label></p>
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
        </div>
        <div id="ad-form-s6e">
        <div id="ad-form-s6ea">
       <p class="contact"><label for="name">Width (in inches)</label></p>
        <input name="custom_width" type="text" id="custom_width" value="<?php echo set_value('custom_width'); ?>"  />
        </div>
        <div id="ad-form-s6eb">
        <p class="contact"><label for="name">Height (in inches)</label></p>
        <input name="custom_height" type="text" id="custom_height" value="<?php echo set_value('custom_height'); ?>" />
        </div>
        </div>
<div id="ad-form-s6b">
  <p class="contact"><label for="name">Maximum File Size (In KBs) </label></p>
        <input type="text" id="maxium_file_size" name="maxium_file_size"  value="<?php echo set_value('maxium_file_size'); ?>"/>
      </div>
        <div id="ad-form-s6c">
        <p class="contact"><label for="name">Web Ad Type </label></p>
        <select class="select-style gender" id="web_ad_type" name="web_ad_type">
        <option value="">Select</option>
        <option value="Static" <?php echo set_select('web_ad_type', 'Static'); ?> >Static</option>
        <option value="Animated" <?php echo set_select('web_ad_type', 'Animated'); ?> >Animated</option>
      </select>
        </div>
        </div>
        
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
        <input class="buttom" type="submit" value="SUBMIT" />
        </div>
      </form>
      </div>
    </div>

<!--
<table width="960" border="0" cellspacing="1" cellpadding="4">
  <tr style="background-color:#333;">
  
  <input id=size_inches name="size_inches" value="0" readonly style="visibility:hidden"  />
  
    <td colspan="3" style="width: 672px;"><p style="padding: 15px; margin: 0px; color: #FFF; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php echo $publications['name'];?></p></td>
    <td style="width:288px;"><p style="padding: 0px; margin: 0px; color: #FFF; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center;">Print & Web Ad Form</p></td>
  </tr>
  <tr style="background-color:#eee;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Ad Type<span style="color:#F00;">*</span></p></td>
    <td align="center" style="width: 288px; background-color: #eee;"><p style="padding: 0px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><select id="spec_sold_ad" name="spec_sold_ad" style="width: 92%;">
          <option value="0" <?php echo set_select('spec_sold_ad', '0');?> >New ad</option>
          <option value="1"  <?php echo set_select('spec_sold_ad', '1');?> >Pickup / Template ad</option>
          <option value="2"  <?php echo set_select('spec_sold_ad', '2');?> >Resize ad</option>
        </select></p></td>
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Publish Date<span style="color:#F00;">*</span></p></td>
    <td align="center" style="width: 288px; background-color: #eee;"><p style="padding: 0px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><input type="text" id="publish_date" name="publish_date"  value="<?php echo set_value('publish_date');?>" style="width: 90%;"/></p></td>
  </tr>
  <tr style="background-color:#eee;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Adrep Email id</p></td>
    <td align="center" style="width: 288px; background-color: #eee;"><p style="padding: 0px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
      <input name="" type="text" disabled="disabled"  value="<?php echo $client['email_id'];?>" style="width: 90%;"/>
    </p></td>
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Publication Name</p></td>
    <td align="center" style="width: 288px; background-color: #eee;"><p style="padding: 0px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><input type="text" id="publication_name" name="publication_name"  value="<?php echo set_value('publication_name');?>" style="width: 90%;" /></p></td>
  </tr>
  <tr style="background-color:#eee;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Advertiser Name<span style="color:#F00;">*</span></p></td>
    <td align="center" style="width: 288px; background-color: #eee;"><p style="padding: 0px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
      <input type="text" id="advertiser_name" name="advertiser_name" value="<?php echo set_value('advertiser_name');?>" style="width: 90%;"/>
    </p></td>
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Width (in inches)<span style="color:#F00;">*</span></p></td>
    <td align="center" style="width: 288px; background-color: #eee;"><p style="padding: 0px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><input name="width" type="text" id="width" value="<?php echo set_value('width'); ?>" size="5"  style="width: 90%;" onChange="fill()" /></p></td>
  </tr>
  <tr style="background-color:#eee;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Job Name / No<span style="color:#F00;">*</span></p></td>
    <td align="center" style="width: 288px; background-color: #eee;"><p style="padding: 0px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
      <input type="text" id="job_no" name="job_no" value="<?php echo set_value('job_no'); ?>" style="width: 90%;" />
    </p></td>
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Height (in inches)<span style="color:#F00;">*</span></p></td>
    <td align="center" style="width: 288px; background-color: #eee;"><p style="padding: 0px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><input name="height" type="text" id="height" value="<?php echo set_value('height'); ?>" size="5" style="width: 90%;" onChange="fill()" /></p></td>
  </tr>
  <tr style="background-color:#eee;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Date Needed<span style="color:#F00;">*</span></p></td>
    <td align="center" style="width: 288px; background-color: #eee;"><p style="padding: 0px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
      <input type="text" id="date_needed" name="date_needed" value="<?php echo set_value('date_needed'); ?>" style="width: 90%;" />
    </p></td>
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Full Color/B&W/Spot<span style="color:#F00;">*</span></p></td>
    <td align="center" style="width: 288px; background-color: #eee;"><p style="padding: 0px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><select id="print_ad_type" name="print_ad_type" style="width: 92%;">
          <option value="">Select</option>
          <?php
					$results = $this->db->get('print_ad_types')->result_array();
					foreach($results as $result)
					{
						echo '<option value="'.$result['id'].'" '.set_select('print_ad_type',$result['id']).' >'.$result['name'].'</option>';	
					}
				?>
        </select></p></td>
  </tr>
  <tr style="background-color:#eee;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Copy/Content<span style="color:#F00;">*</span></p></td>
    <td align="center" style="width: 288px; background-color: #eee;"><p style="padding: 0px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
      <select id="copy_content" name="copy_content" style="width: 92%;">
        <option value="">Select</option>
        <option value="1" <?php echo set_select('copy_content','1');?> >Included in the form</option>
        <option value="2" <?php echo set_select('copy_content','2');?> >Sent separately</option>
        <option value="3" <?php echo set_select('copy_content','3');?> >Changes only</option>
      </select>
    </p></td>
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Color Preferences</p></td>
    <td align="center" style="width: 288px; background-color: #eee;"><p style="padding: 0px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><input type="text" id="color_preferences" name="color_preferences"  value="<?php echo set_value('color_preferences');?>" style="width: 90%;" /></p></td>
  </tr>
  <tr style="background-color:#eee;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Job Instruction<span style="color:#F00;">*</span></p></td>
    <td align="center" style="width: 288px; background-color: #eee;"><p style="padding:7px 0 0 0;  margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
      <select id="job_instruction" name="job_instruction" style="width: 92%;">
        <option value="">Select</option>
        <option value="1" <?php echo set_select('job_instruction','1');?> >Follow Instructions Carefully</option>
        <option value="2" <?php echo set_select('job_instruction','2');?> >Be Creative</option>
      </select>
    </p></td>
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Font Preferences</p></td>
    <td align="center" style="width: 288px; background-color: #eee;"><p style="padding: 0px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><input type="text" id="font_preferences" name="font_preferences" value="<?php echo set_value('font_preferences');?>" style="width: 90%;" /></p></td>
  </tr>
  
  <tr style="background-color:#eee; vertical-align: top;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">ArtWork<span style="color:#F00;">*</span></p></td>
    <td align="center" style="width: 288px; background-color: #eee;"><p style="padding:7px 0 0 0;  margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
      <select id="art_work" name="art_work" style="width: 92%;">
        <option value="">Select</option>
        <option value="1"<?php echo set_select('art_work', '1'); ?>>Use additional art if required</option>
        <option value="2" <?php echo set_select('art_work', '2'); ?> >Modify art provided if necessary</option>
        <option value="3" <?php echo set_select('art_work', '3'); ?>  >Use art provided without change</option>
      </select>
    </p></td>
    <td colspan="2"><p style="padding: 14px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center;">Files Sent Via<span style="color:#F00;">*</span></p></td>
    </tr>
  
  <tr style="background-color:#eee; vertical-align: top;">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  <td align="center" colspan="2">
      <table width="0" border="0" cellspacing="1" cellpadding="4">
        <tr>
          <td style="width:35px;"><p style="padding: 5px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Ftp:</p></td>
            <td style="width:60px;"><p style="padding: 0px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
			
			<select id="no_fax_items" name="no_fax_items" style="width: 92%;">
            <option value="1"<?php echo set_select('no_fax_items', '1'); ?> >Yes</option>
            <option value="0"<?php echo set_select('no_fax_items', '0'); ?>, selected="selected" >No</option>
            </select></p></td>
			
          <td style="width: 55px;"><p style="padding: 5px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: right;">Email:</p></td>
            <td style="width: 60px;"><p style="padding: 0px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
			
			<select id="no_email_items" name="no_email_items" style="width: 92%;">
            <option value="1"<?php echo set_select('no_email_items', '1'); ?>, >Yes</option>
            <option value="0"<?php echo set_select('no_email_items', '0'); ?>, selected="selected" >No</option>
            </select></p></td>
			
          <td style="width: 150px;"><p style="padding: 5px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: right;">Along with this Form:</p></td>
            <td style="width: 60px;"><p style="padding: 0px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
			
			<select id="with_form" name="with_form" style="width: 92%;">
            <option value="1"<?php echo set_select('with_form', '1'); ?> >Yes</option>
            <option value="0"<?php echo set_select('with_form', '0'); ?>, selected="selected" >No</option>
            </select></p></td>
			
          </tr>
  </table>
    </td>   
  </tr>
  <tr style="background-color:#eee; vertical-align: top;">
    <td colspan="4"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center; font-weight: bold;">Web Ad</p></td>
    </tr>
    
    <tr style="background-color:#eee;">
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Format<span style="color:#F00;">*</span></p></td>
    <td align="center" style="width: 288px; background-color: #eee;"><p style="padding: 0px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
      <select id="ad_format" name="ad_format" style="width: 92%;">
        <option value="">Select</option>
        <?php
					$results = $this->db->get('web_ad_formats')->result_array();
					foreach($results as $result)
					{
						echo '<option value="'.$result['id'].'" '.set_select('ad_format',$result['id']).' >'.$result['name'].'</option>';	
					}
				?>
      </select>
    </p></td>
    <td><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Size (in Pixels)<span style="color:#F00;">*</span></p></td>
    <td align="center"><p style="padding: 0px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><select id="pixel_size" name="pixel_size" style="width: 92%;">
            	<option value="">Select</option>
                <?php
					$results = $this->db->get('pixel_sizes')->result_array();
					foreach($results as $result)
					{
						echo '<option value="'.$result['id'].'" '.set_select('pixel_size',$result['id']).' >'.$result['width'].' x '.$result['height'].'('.$result['name'].')'.'</option>';
					}
				?>
                <option value="custom" <?php echo set_select('pixel_size', 'custom'); ?> >Custom</option>
    </select></p></td>   
  </tr>
  
  <tr id="custom_pixel" style="background-color:#eee;">
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Width (in Pixels)<span style="color:#F00;">*</span></p></td>
    <td align="center" style="width: 288px; background-color: #eee;"><p style="padding: 0px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
      <input name="custom_width" type="text" id="custom_width" value="<?php echo set_value('custom_width'); ?>" size="5" style="width: 90%;"  />
    </p></td>
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Height (in Pixels)<span style="color:#F00;">*</span></p></td>
    <td align="center" style="width: 288px; background-color: #eee;"><p style="padding: 0px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
      <input name="custom_height" type="text" id="custom_height" value="<?php echo set_value('custom_height'); ?>" size="5" style="width: 90%;"  />
    </p></td>
    <div>      </div>
    
  </tr>
  
  <tr style="background-color:#eee;">
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Maximum File Size (In KBs)<span style="color:#F00;">*</span></p></td>
    <td align="center" style="width: 288px; background-color: #eee;"><p style="padding: 0px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
      <input type="text" id="maxium_file_size" name="maxium_file_size"  value="<?php echo set_value('maxium_file_size'); ?>" style="width: 90%;"/>
    </p></td>
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Web Ad Type<span style="color:#F00;">*</span></p></td>
    <td align="center" style="width: 288px; background-color: #eee;"><p style="padding: 0px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
      <select id="web_ad_type" name="web_ad_type" style="width:92%;">
        <option value="">Select</option>
        <option value="0" <?php echo set_select('web_ad_type', '0'); ?> >Static</option>
        <option value="1" <?php echo set_select('web_ad_type', '1'); ?> >Animated</option>
      </select>
    </p></td>
    </tr>
  
  <tr style="background-color:#eee; vertical-align: top;">
    <td colspan="4"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center;">Copy/Content</p></td>
    </tr>
  <tr style="background-color:#eee; vertical-align: top;">
    <td colspan="4" align="center"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><textarea name="copy_content_description" id="copy_content_description"  style="width: 90%;"><?php echo set_value('copy_content_description');?></textarea><?php echo display_ckeditor($copy_content_ckeditor); ?></p></td>
    </tr>
    <tr style="background-color:#eee; vertical-align: top;">
    <td colspan="4"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center;">Notes & Instructions</p></td>
    </tr>
    <tr style="background-color:#eee; vertical-align: top;">
    <td colspan="4" align="center"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><textarea id="notes" name="notes" style="width: 90%;"><?php echo set_value('notes');?></textarea><?php echo display_ckeditor($notes_ckeditor); ?></p></td>
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
    <td align="right" style="width: 288px; background-color: #fff;"><input type="submit" value="Submit to Upload Files" class="submit" /></td>
  </tr>
</table> -->
</div>
