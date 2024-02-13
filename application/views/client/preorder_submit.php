<?php
	$this->load->view("client/header1");
?>
<link rel="stylesheet" href="jq-ui/themes/base/jquery.ui.all.css" />
<link rel="stylesheet" href="color-picker/jquery.miniColors.css" />
<script language="JavaScript" src="color-picker/jquery.miniColors.js"></script>
<script src="jq-ui/ui/jquery.ui.core.js"></script>
<script src="jq-ui/ui/jquery.ui.datepicker.js"></script>
<script type="text/javascript">

	
</script>
 <script type='text/javascript' src='searchitem/jquery-1.2.6.pack.js'></script>
  <script type='text/javascript' src='searchitem/quicksilver.js'></script>
  <script type='text/javascript' src='searchitem/jquery.quickselect.pack.js'></script> 
  <link rel="stylesheet" type="text/css" href="searchitem/jquery.quickselect.css" />
 
<div id="Middle-Div">
<div id="form">

<form id="order_form" name="order_form" method="post" enctype="multipart/form-data" onsubmit="order_submit.disabled = true; return true;">
<div class="form">
<div id="ad-form">
      <div id="ad-form-h">Order Submit Form</div>
      <div id="ad-form-p">&nbsp;</div>
      <div id="ad-form-s">
      <form id="contactform">      
        <div id="ad-form-s-l">
               
        <p class="contact"><label for="name">Unique Job ID</label></p>
		<input type="text" id="job_name" name="job_name" value="<?php echo $preorder_details[0]['job_name']; ?>" readonly />
			
		<p class="contact"><label for="name">Advertiser</label></p>
		<input type="text" id="advertiser" name="advertiser" value="<?php echo $preorder_details[0]['advertiser']; ?>" />
		
        <p class="contact"><label for="name">Publication</label></p>
		<input type="text" id="publication" name="publication" value="<?php echo $preorder_details[0]['publication']; ?>" readonly />
		
		<p class="contact"><label for="name">Color <span class="mandatory">*</span></label></p>
		<select id="color" name="color" class="select-style gender" required >
			<option value="" >select</option>
        	<option value="1" <?php if($preorder_details[0]['color']=='CMYK'){echo'selected';} ?>> Color </option>
			<option value="2" <?php if($preorder_details[0]['color']=='B&W'){echo'selected';} ?>>  B&W </option>
			<option value="3" <?php if($preorder_details[0]['color']=='Spot'){echo'selected';} ?>> Spot </option>
			
        </select>
		
        </div>
        <div id="ad-form-s-r">
		
			<p class="contact"><label for="name">Publish Date</label></p>
		<input type="text" id="publish_date" name="publish_date" value="<?php echo date("Y-m-d", strtotime($preorder_details[0]['publish_date'])); ?>" readonly />
		
		<p class="contact"><label for="name">Date Needed</label></p>
		<input type="text" id="date_needed" name="date_needed" value="<?php echo $preorder_details[0]['date_needed']; ?>" readonly />
		
		<p class="contact"><label for="name">Width (in columns)<span class="mandatory">*</span></label></p>
		<select id="width" name="width" class="select-style gender">
        	<?php
			$preorder_width = $this->db->get('preorder_width')->result_array();
				foreach($preorder_width as $width)
				{
					echo '<option value="'.$width['value'].'" '.($width['id']==$preorder_details[0]['width1'] ? 'selected="selected"' : '').'>'.$width['id'].'</option>';	
				}
			?>
        </select>
        <p class="contact"><label for="name">Height (in inches)<span class="mandatory">*</span></label></p>
		<input type="text" id="height" name="height" value="<?php echo $preorder_details[0]['height']; ?>" />
		<p><input type="checkbox" name="rush" value="1" style="width:20px;"> <label for="name"><span></span>Rush</label></p>
		</div>
       <div id="ad-form-s3">
	   <p class="contact"><label for="name">Copy & Content <span class="mandatory">*</span></label></p>
        <textarea name="copy_content_description" id="copy_content_description"  style="width: 80%; height: 80px;" required ></textarea>
	   <p class="contact"><label for="name">Notes & Instructions </label></p>
        <textarea name="notes" id="notes"  style="width: 80%; height: 80px;" ></textarea>
       <div style="max-width: 400px; margin: 0 auto;">
       <p style="text-align: center;">Attach File</p>
      
		<label for="name">File 1 </label> <input class="input-file uniform_on" type="file" name="ufile[]" id="ufile[]" value="upload" accept="application/pdf" /> <br><br>
        <label for="name"> File 2 </label> <input type="file" name="ufile[]" id="ufile[]" value="upload" accept="application/pdf" />
		<label for="name"> File 3 </label> <input type="file" name="ufile[]" id="ufile[]" value="upload" accept="application/pdf" />
		<label for="name"> File 4 </label> <input type="file" name="ufile[]" id="ufile[]" value="upload" accept="application/pdf" />
		<label for="name"> File 5 </label> <input type="file" name="ufile[]" id="ufile[]" value="upload" accept="application/pdf" />
        </div>
        </div>
		
   
        <div id="ad-form-s4">  
		<input name="id" value="<?php echo $preorder_details[0]['id'];?>" readonly style="display:none;" />		
        <input class="buttom" name="order_submit" type="submit" value="SUBMIT" />
        </div>
      </form>
      </div>
    </div>
</div>
</form>
</div>
</div>

<script language="javascript" type="text/javascript">

$("form").submit(function() {

if ($('#loading_image').length == 0) { //is the image on the form yet?

                // add it just before the submit button

$(':submit').after('<img src="images/up.gif" alt="Uploading...." id="loading_image" >')

}

    $('#loading_image').show(); // show the animated image    

     // disable double submits

    return true; // allow regular form submission

});

</script>

<?php
	$this->load->view("client/footer");
?>