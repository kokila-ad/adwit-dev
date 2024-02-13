<link rel="stylesheet" href="jq-ui/themes/base/jquery.ui.all.css" />
<script src="jq-ui/ui/jquery.ui.core.js"></script>
<script src="jq-ui/ui/jquery.ui.datepicker.js"></script>

<link rel="stylesheet" href="color-picker/jquery.miniColors.css" />
<script language="JavaScript" src="color-picker/jquery.miniColors.js"></script>

<script type='text/javascript' src='searchitem/jquery-1.2.6.pack.js'></script>
  <script type='text/javascript' src='searchitem/quicksilver.js'></script>
  <script type='text/javascript' src='searchitem/jquery.quickselect.pack.js'></script>
  <link rel="stylesheet" type="text/css" href="searchitem/jquery.quickselect.css" />
  
  <script type="text/javascript">
	
	$(document).ready(function(e) {    

		
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
      <div id="ad-form-p">Resize Web Ad</div>
      <div id="ad-form-s">
      <form id="contactform">      
        <div id="ad-form-s-l">
        <p class="contact"><label for="name">Advertiser Name <span class="mandatory">*</span></label></p>
        <input type="text" id="advertiser_name" name="advertiser_name" value="<?php echo set_value('advertiser_name');?>"/>
        <p class="contact"><label for="name">Unique Job Name / Number </label> <span class="mandatory">*</span></p>
        <input type="text" id="job_no" name="job_no" value="<?php echo set_value('job_no'); ?>" />
         <p class="contact"><label for="name">Resize Ad No</label> <span class="mandatory">*</span></p>
        <?php if(isset($order_publication)){ ?>
		
		 <select name="pickup_adno" id="pickup_adno">
          <option value=''></option>
		<?php 
		foreach($order_publication as $num)
		{ 
			//echo '<option value="'.$num['job_no'].'" >'.$num['job_no'].'</option>';	
			echo '<option value="'.$num['job_no'].'"'.set_select('pickup_adno',$num['job_no']).' >'.$num['job_no'].'</option>';
		} 
		?>  
        </select> 
		
	<?php }else{ ?>
	
         <select name="pickup_adno" id="pickup_adno">
          <option value=''></option>
		<?php 
			foreach($order_no as $num)
			{
				//echo '<option value="'.$num['id'].'" >'.$num['id'].'</option>';	
				echo '<option value="'.$num['id'].'"'.set_select('pickup_adno',$num['id']).' >'.$num['id'].'</option>';	
			}
		?>  
	    </select> 
		
	<?php } ?> 
	
		<p class="contact"><label for="name">Maximum File Size (In KBs) <span class="mandatory">*</span></label></p>
        <input type="text" id="maxium_file_size" name="maxium_file_size"  value="<?php echo set_value('maxium_file_size'); ?>" />
        </div>
		<div id="ad-form-s-r">
        <p class="contact"><label for="name">Publication Name</label></p>
        <input type="text" id="publication_name" name="publication_name"  value="<?php echo set_value('publication_name');?>"/>
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
						echo '<option value="'.$result['id'].'" '.set_select('ad_format',$result['id']).' >'.$result['name'].'</option>';	
					}
				?>
      </select>
        <p class="contact"><label for="name">Web Ad Type <span class="mandatory">*</span></label></p>
        <select class="select-style gender" id="web_ad_type" name="web_ad_type">
        <option value="">Select</option>
        <option value="Static" <?php echo set_select('web_ad_type', 'Static'); ?> >Static</option>
        <option value="Animated" <?php echo set_select('web_ad_type', 'Animated'); ?> >Animated</option>
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

  <script type="text/javascript">
  $(function(){
    $('#ExampleTwo_AjaxData').quickselect({
      url:'ask.json',
      match:'substring',
      autoSelectFirst:false,
			mustMatch:true,
      additional_fields:$('#other_thing_field'),
      formatItem:function(data, index, total){return ""+index+"/"+total+". "+data[0]+" ("+data[1]+")"}
    });

    $("#pickup_adno").quickselect();
  });
  </script>
 