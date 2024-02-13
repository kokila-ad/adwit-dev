<link rel="stylesheet" href="jq-ui/themes/base/jquery.ui.all.css" />
<link rel="stylesheet" href="color-picker/jquery.miniColors.css" />
<script language="JavaScript" src="color-picker/jquery.miniColors.js"></script>
<script src="jq-ui/ui/jquery.ui.core.js"></script>
<script src="jq-ui/ui/jquery.ui.datepicker.js"></script>
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
		
	});
	
	
</script>
 <script type='text/javascript' src='searchitem/jquery-1.2.6.pack.js'></script>
  <script type='text/javascript' src='searchitem/quicksilver.js'></script>
  <script type='text/javascript' src='searchitem/jquery.quickselect.pack.js'></script>
  <link rel="stylesheet" type="text/css" href="searchitem/jquery.quickselect.css" />
 

<div class="form">
<div id="ad-form">
      <div id="ad-form-h"><?php echo $publications['name'];?></div>
      <div id="ad-form-p">Pickup Print Ad</div>
      <div id="ad-form-s">
      <form id="contactform">      
        <div id="ad-form-s-l">
        <p class="contact"><label for="name">Advertiser Name</label> <span class="mandatory">*</span></p>
        <input type="text" id="advertiser_name" name="advertiser_name" value="<?php if(isset($pick_order))echo $pick_order['advertiser_name'];else echo set_value('advertiser_name');?>"/>     
        <p class="contact"><label for="name">New Unique Job Name / Number <span class="mandatory">*</span></label></p>
        <input type="text" id="job_no" name="job_no" pattern="[a-zA-Z0-9 ]{1,50}" value="<?php echo set_value('job_no'); ?>" />
        <p class="contact"><label for="name">Pickup Ad No <span class="mandatory">*</span></label></p>
		<?php if(isset($pick_order)){ echo '<input type="text" id="pickup_adno" name="pickup_adno" value="'.set_value('pickup_adno', $order_num).'" readonly/>'; }
			  else{ ?>
     
	 <?php if(isset($order_publication)){ ?>
		
		<!--<select class="select-style gender" name="pickup_adno" id="pickup_adno" onchange='window.location="<?php echo base_url().index_page().'client/home/print_type/pickup-ads/';?>"+ $(this).val()' >-->
          <select class="select-style gender" name="pickup_adno" id="pickup_adno" onchange='window.location="<?php echo base_url().index_page().'client/home/order_form/print/pickup-ads/';?>"+ $(this).val()' >
		  <option value=''></option>
		<?php foreach($order_publication as $num){ echo '<option value="'.$num['job_no'].'"'.set_select('pickup_adno',$num['job_no']).' >'.$num['job_no'].'</option>'; } ?>  
        </select> 
		
	<?php }else{ ?>
	
        <!--<select class="select-style gender" name="pickup_adno" id="pickup_adno" onchange='window.location="<?php echo base_url().index_page().'client/home/print_type/pickup-ads/';?>"+ $(this).val()' >-->
		<select class="select-style gender" name="pickup_adno" id="pickup_adno" onchange='window.location="<?php echo base_url().index_page().'client/home/order_form/print/pickup-ads/';?>"+ $(this).val()' >
          <option value=''></option>
		<?php 
			foreach($order_no as $num)
			{ echo '<option value="'.$num['id'].'"'.set_select('pickup_adno',$num['id']).' >'.$num['id'].'</option>'; }
		?>  
	    </select> 
		
	<?php } } ?>

        </div>
        <div id="ad-form-s-r">
        <p class="contact"><label for="name">Publication Name</label></p>
        <input type="text" id="publication_name" name="publication_name"  value="<?php if(isset($pick_order))echo $pick_order['publication_name']; else echo set_value('publication_name');?>"/>
        <p class="contact"><label for="name">New Width (in inches) <span class="mandatory">*</span></label></p>
        <input name="width" type="text" id="width" value="<?php if(isset($pick_order))echo $pick_order['width']; else echo set_value('width'); ?>" />
        <p class="contact"><label for="name">New Height (in inches) <span class="mandatory">*</span></label></p>
        <input name="height" type="text" id="height" value="<?php if(isset($pick_order))echo $pick_order['height']; else echo set_value('height'); ?>" />
        <p class="contact"><label for="name">Full Color/B&W/Spot <span class="mandatory">*</span> </label></p>
        <select class="select-style gender" id="print_ad_type" name="print_ad_type">
          <option value="">Select</option>
          <?php
					$results = $this->db->get('print_ad_types')->result_array();
					foreach($results as $result)
					{
						echo '<option value="'.$result['id'].'" '.($result['id']==$pick_order['print_ad_type'] ? 'selected="selected"': '').set_select('print_ad_type',$result['id']).' >'.$result['name'].'</option>';	
					}
				?>
        </select>
         
		<?php if($client['rush']=='1'){  ?> 
		  <p><input type="checkbox" name="rush" value="1" style="width:20px;"> 
		  <label for="name"><span></span>Rush</label></p>
		<?php } ?>	
		 
        </div>
     
        
        <div id="ad-form-s3">
  <p class="contact"><label for="name">Copy/Content</label></p>
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
  /*
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
  });*/
  
 
  </script>
  
 