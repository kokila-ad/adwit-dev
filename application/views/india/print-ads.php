<link rel="stylesheet" href="jq-ui/themes/base/jquery.ui.all.css" />
<script src="jq-ui/ui/jquery.ui.core.js"></script>
<script src="jq-ui/ui/jquery.ui.datepicker.js"></script>
<link rel="stylesheet" href="color-picker/jquery.miniColors.css" />
<script language="JavaScript" src="color-picker/jquery.miniColors.js"></script>
<script type="text/javascript">
	
	$(document).ready(function(e) {    

		$('.color-picker').miniColors();
		
   		$( "#release_date" ).datepicker({ minDate: 0, maxDate: "+1Y", dateFormat: 'dd-mm-yy' });
		
		$( "#dead_line_date" ).datepicker({ minDate: 0, maxDate: "+1Y", dateFormat: 'dd-mm-yy'});
		
		$( "#todays_date" ).datepicker({ minDate: 0, maxDate: "+1Y", dateFormat: 'dd-mm-yy'});

		
		$('#template_used').change(function(e) {
            if($('#template_used').val()=='1') $('#template_name').show();
			else $('#template_name').hide();
        });
		
		<?php if(set_value('template_used')=='1'):?>
			$('#template_name').show();
		<?php else:?>
			$('#template_name').hide();
		<?php endif;?>
		
		$('#print_media_type').change(function(e) {
            if($('#print_media_type').val()=='6') $('#other_print_type').show();
			else $('#other_print_type').hide();
        });		
		<?php if(set_value('print_media_type')=='6'):?>
			$('#other_print_type').show();
		<?php else:?>
			$('#other_print_type').hide();
		<?php endif;?>
		
	});
	
	function fill() {
        var txt8 = document.getElementById("width").value-0;
        var txt9 = document.getElementById("height").value-0;
        document.getElementById("size_inches").value = txt8 * txt9;
		
	}
	
</script>
<div class="form">
<table width="960" border="0" cellspacing="0" cellpadding="4">
  <tr>
    <td style="border-top: 1px solid #40a873; border-left: 1px solid #40a873;"><p style="padding: 15px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><?php echo $india_bg['name'];?></p></td>
    <td colspan="2" style="border-top: 1px solid #40a873;">&nbsp;</td>
    <td style="width:288px; border-top: 1px solid #40a873; border-right: 1px solid #40a873;"><p style="padding: 0px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center;">Print Media Form</p></td>
  </tr>
  <tr style="background-color:#67c5cf; color:#000;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Campaign Name<span style="color:#fe905f;">*</span></p></td>
    <td align="center" style="width: 288px;"><p style="padding: 0px; margin: 0px; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><input type="text" id="campaign_title" name="campaign_title" value="<?php echo set_value('campaign_title');?>" style="width: 90%;"/></p></td>
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Deadline<span style="color:#7037c6;">*</span></p></td>
    <td align="center" style="width: 288px;"><p style="padding: 0px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"> <input type="text" id="dead_line_date" name="dead_line_date"  value="<?php echo set_value('dead_line_date');?>" style="width: 90%;"/></p></td>
    </tr>
  <tr style="background-color:#006ea1; color:#fff;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Account Manager<span style="color:#fe905f;"></span></p></td>
    <td align="center" style="width: 288px;"><p style="padding: 0px; margin: 0px; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><input name="client_name" type="text" disabled="disabled" id="client_name" style="width: 90%;" value="<?php echo $client['email_id'];?>"/></p></td>
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Print Media Type<span style="color:#fe905f;"></span></p></td>
    <td align="center" style="width: 288px;"><p style="padding: 0px; margin: 0px; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><select id="print_media_type" name="print_media_type" style="width: 92%;">
          <option value="1" <?php echo set_select('print_media_type', '1');?> >Press Ad</option>
          <option value="2"  <?php echo set_select('print_media_type', '2');?> >Brochure</option>
          <option value="3"  <?php echo set_select('print_media_type', '3');?> >Annual </option>
           <option value="4"  <?php echo set_select('print_media_type', '4');?> >Newsletter </option>
            <option value="5"  <?php echo set_select('print_media_type', '5');?> >Outdoor </option>
             <option value="6"  <?php echo set_select('print_media_type', '6');?> >If other, please specify below</option>
        </select></p></td>
    </tr>
  <tr style="background-color:#006ea1; color:#fff;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Client<span style="color:#fe905f;">*</span></p></td>
    <td align="center" style="width: 288px;"><p style="padding: 0px; margin: 0px; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
      <input type="text" id="client_name" name="client_name" value="<?php echo set_value('client_name');?>" style="width: 90%;"/>
    </p></td>
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Other Print Media Type<span style="color:#fe905f;"></span></p></td>
    <td align="center" style="width: 288px;"><p style="padding: 0px; margin: 0px; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
      <input name="other_print_type" type="text" id="other_print_type" value="<?php echo set_value('other_print_type'); ?>" style="width: 90%;"/>
    </p></td>
    </tr>
  <tr style="background-color:#006ea1; color:#FFF;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Projected Ad Spend<span style="color:#fe905f;">*</span></p></td>
    <td align="center" style="width: 288px;"><p style="padding: 0px; margin: 0px; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
      <input type="text" id="projected_ad_spent" name="projected_ad_spent" value="<?php echo set_value('projected_ad_spent');?>" style="width: 90%;"/>
    </p></td>
    <td style="width: 192px; "><p style="padding:10px; margin: 0px; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Agencies Competing</p></td>
    <td align="center" style="width: 288px; "><p style="padding: 0px; margin: 0px; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
      <input type="text" name="no_of_agencies_competing" id="no_of_agencies_competing" value="<?php echo set_value('no_of_agencies_competing');?>" style="width: 90%;"/>
    </p></td>
    </tr>
  <tr style="background-color:#006ea1; color:#FFF;">
    <td style="width: 192px; ">&nbsp;</td>
    <td align="center" style="width: 288px; ">&nbsp;</td>
    <td style="width: 192px; "><p style="padding:10px; margin: 0px; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Release Date<span style="color:#fe905f;">*</span></p></td>
    <td align="center" style="width: 288px;"><p style="padding: 0px; margin: 0px; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
      <input type="text" id="release_date" name="release_date"  value="<?php echo set_value('release_date');?>" style="width: 90%;"/>
    </p></td>
    </tr>
    <tr style="background-color:#e77a42;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Mandatories<span style="color:#fe905f;"></span></p></td>
    <td align="center" style="width: 288px;"><p style="padding: 0px; margin: 0px; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
      <input type="text" id="mandatories" name="mandatories" value="<?php echo set_value('mandatories');?>" style="width: 90%;"/>
    </p></td>
    <td style="width: 192px; ">&nbsp;</td>
    <td align="center" style="width: 288px;">&nbsp;</td>
  </tr>
  <tr style="background-color:#e77a42;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Size (cc)<span style="color:#ffffff;">*</span></p></td>
    <td align="center" style="width: 288px;"><p style="padding: 0px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
      <input type="text" id="size_cms" name="size_cms" value="<?php echo set_value('size_cms');?>" style="width: 90%;"/>
    </p></td>
    <td style="width: 192px; "><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Width (cm)<span style="color:#ffffff;">*</span></p></td>
    <td align="center" style="width: 288px;"><p style="padding: 0px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><input name="width" type="text" id="width" value="<?php echo set_value('width'); ?>" style="width: 90%;"/></p></td>
  </tr>
  <tr style="background-color:#e77a42;">
    <td rowspan="2" style="width: 192px;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Languages<span style="color:#ffffff;">*</span></p></td>
    <td rowspan="2" align="left" style="width: 288px;"><p style="padding: 10px 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
      <label>
          <input type="checkbox" name="language[]" value="Kannada" <?php echo set_checkbox('language[]', 'Kannada'); ?> id="language" />
          Kannada</label><br/>
          <label>
          <input type="checkbox" name="language[]" value="Hindi" <?php echo set_checkbox('language[]', 'Hindi'); ?> id="language" />
          Hindi</label><br/>
          <label>
          <input type="checkbox" name="language[]" value="English" <?php echo set_checkbox('language[]', 'English'); ?> id="language" />
          English</label>           
   <!--   <select id="language" name="language" style="width: 90%;">
          <option value="0" <?php echo set_select('language', '0');?> >select language</option>
          <option value="1"  <?php echo set_select('language', '1');?> >Kannada</option>
          <option value="2"  <?php echo set_select('language', '2');?> >Hindi</option>
		  <option value="3"  <?php echo set_select('language', '3');?> >English</option>
		</select>    -->  
    </p>    </td>
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Height (cm)<span style="color:#ffffff;">*</span></p></td>
    <td align="center" style="width: 288px;"><p style="padding: 0px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><input name="height" type="text" id="height" value="<?php echo set_value('height'); ?>" style="width: 90%;"/></p></td>
  </tr>
  <tr style="background-color:#e77a42;">
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Color Preferences</p></td>
    <td align="center" style="width: 288px;"><p style="padding: 0px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><input type="text" id="color_preferences" name="color_preferences"  value="<?php echo set_value('color_preferences');?>" style="width: 90%;"/></p></td>
  </tr>
  <tr style="background-color:#e77a42;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">No of Options<span style="color:#ffffff;">*</span></p></td>
    <td align="left" style="width: 288px;">
    <p style="padding: 0px 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"> <label>
           <input type="radio" name="no_of_options" value="1" <?php echo set_radio('no_of_options', '1'); ?> />
          1</label>
        <br />
        <label>
          <input type="radio" name="no_of_options" value="2" <?php echo set_radio('no_of_options', '2'); ?> />
          2</label>
        <br />
        <input type="radio" name="no_of_options" value="3" <?php echo set_radio('no_of_options', '3'); ?> />
          3</label>
        <br />
    </p>
</td>
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Full Color/B&W <span style="color:#ffffff;"></span></p></td>
    <td align="left" style="width: 288px;"><p style="padding: 0px 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"> <label>
          <input type="radio" name="print_ad_type" value="1" <?php echo set_radio('no_of_options', '1'); ?> />
          Full Color</label>
        <br />
        <label>
           <input type="radio" name="print_ad_type" value="2" <?php echo set_radio('no_of_options', '2'); ?> />
          B&W</label>
    <!--    <br />
         <input type="radio" name="print_ad_type" value="3" <?php echo set_radio('no_of_options', '3'); ?> />
          Spot</label>
	-->	  
        <br />
    </p></td>
  </tr>
  <tr style="background-color:#e77a42;">
    <td style="width: 192px;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Images<span style="color:#ffffff;">*</span></p></td>
    <td align="left" style="width: 288px;">
    <p style="padding: 0px 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"> 
<label>
<!--<input type="checkbox" name="final_output_format[]" value="1" <?php echo set_checkbox('final_output_format[]', '1'); ?> id="final_output_format" />-->
		  <input type="checkbox" name="images[]" value="From Client" <?php echo set_checkbox('images[]', 'From Client'); ?> id="images" />
          From Client</label>
        <br />
        <label>
          <input type="checkbox" name="images[]" value="Free Images" <?php echo set_checkbox('images[]', 'Free Images'); ?> id="images" />
          Free Images</label>
        <br />
        <label>
          <input type="checkbox" name="images[]" value="Paid Image" <?php echo set_checkbox('images[]', 'Paid Image'); ?> id="images" />
          Paid Image</label>
        <br /></p>
    </td>
    <td style="width: 192px;"><p style="padding:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Final Output Format<span style="color:#fff;"></span></p></td>
    <td align="left" style="width: 288px;"><p style="padding: 5px 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"> 
<label>
          <input type="checkbox" name="final_output_format[]" value="Pdf" <?php echo set_checkbox('final_output_format[]', 'Pdf'); ?> id="final_output_format" />
          Pdf</label>
        <br />
        <label>
          <input type="checkbox" name="final_output_format[]" value="Jpeg" <?php echo set_checkbox('final_output_format[]', 'Jpeg'); ?> id="final_output_format" />
          Jpeg</label>
        <br />
        <label>
          <input type="checkbox" name="final_output_format[]" value="Source File" <?php echo set_checkbox('final_output_format[]', 'Source File'); ?> id="final_output_format" />
          Source File</label>
        <br /></p></td>
  </tr>
  <tr style="background-color:#539768; vertical-align: top;">
    <td colspan="4"><p style="padding-top: 10px; margin: 0px; color: #fff; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center;">Target Audience:
Who Are We Talking To? Lifestyle & Behaviour, Habits / Insights On The TG:</p></td>
    </tr>
    <tr style="background-color:#539768; vertical-align: top;">
    <td colspan="4" align="center"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><textarea name="target_audience" rows="4" id="target_audience" style="width: 90%;"><?php echo set_value('notes');?></textarea></p></td>
    </tr>
    <tr align="center" style="background-color:#8fc839; vertical-align: top;">
    <td colspan="4"><p style="padding-top:10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">Special Instructions<span style="color:#ffffff;"></span></p></td>
    </tr>
    <tr align="center" style="background-color:#8fc839; vertical-align: top;">
    <td colspan="4"><p style="padding: 0px 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"> <label>
          <input type="radio" name="job_instruction" value="1" <?php echo set_radio('job_instruction','1');?> id="job_instruction" />
          Let's Be Creative</label>
        
        <label>
          &nbsp;&nbsp;<input type="radio" name="job_instruction" value="2" <?php echo set_radio('job_instruction','2');?> id="job_instruction" />
          Sophisticated </label>
        
         &nbsp;&nbsp;<input type="radio" name="job_instruction" value="3" <?php echo set_radio('job_instruction','3');?> id="job_instruction" />
          Follow Instructions Carefully</label>
       
    </p></td>
    </tr>
  <tr style="background-color:#8fc839; vertical-align: top;">
    <td colspan="4"><p style="padding-top: 20px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center;">What Message should the Ad Communicate?</p></td>
    </tr>
  <tr style="background-color:#8fc839; vertical-align: top;">
    <td colspan="4" align="center"><p style="padding-top: 0px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><textarea name="one_single_line_of_text" rows="4" id="one_single_line_of_text" style="width: 90%;"><?php echo set_value('one_single_line_of_text');?></textarea></p></td>
    </tr>
    <tr style="background-color:#8fc839; vertical-align: top;">
    <td colspan="4"><p style="padding-top: 20px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center;">Look & Feel of the Ad / Suggestions</p></td>
    </tr>
    <tr style="background-color:#8fc839; vertical-align: top;">
    <td colspan="4" align="center"><p style="padding: 0px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><textarea name="look_feel" rows="4" id="look_feel" style="width: 90%;"><?php echo set_value('look_feel');?></textarea></p></td>
    </tr>
    <tr style="background-color:#8fc839; vertical-align: top;">
    <td colspan="4"><p style="padding-top: 20px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center;">What Do We Want Them To Do?</p></td>
    </tr>
    <tr style="background-color:#8fc839; vertical-align: top;">
    <td colspan="4" align="center"><p style="padding: 0px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><textarea name="what_do_we_want_them_to_do" rows="4" id="what_do_we_want_them_to_do" style="width: 90%;"><?php echo set_value('what_do_we_want_them_to_do');?></textarea></p></td>
    </tr>
    <tr style="background-color:#8fc839; vertical-align: top;">
    <td colspan="4"><p style="padding-top: 20px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center;">Attachments (Reference)</p></td>
    </tr> 
    <tr style="background-color:#8fc839; vertical-align: top;">
    <td colspan="4" align="center"><p style="padding: 0px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><textarea name="attachments_info" rows="4" id="attachments_info" style="width: 90%;"><?php echo set_value('attachments_info');?></textarea></p></td>
    </tr>
    <tr style="background-color:#8fc839; vertical-align: top;">
    <td colspan="4" align="center"></td>
    </tr>     <tr style="background-color:#8fc839; vertical-align: top;">
    <td colspan="4"><p style="padding-top: 20px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center;">Any other info / Suggestions</p></td>
    </tr>
    <tr style="background-color:#8fc839; vertical-align: top;">
    <td colspan="4" align="center"><p style="padding-bottom: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><textarea name="any_other_info" rows="4" id="any_other_info" style="width: 90%;"><?php echo set_value('any_other_info');?></textarea></p></td>
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
    <td align="right" style="width: 288px; background-color: #fff;"><input type="submit" value="Submit Form to Upload Files" class="submit" /></td>
  </tr>
</table>

</div>
