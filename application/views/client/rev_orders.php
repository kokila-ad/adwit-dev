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
<?php echo '<h3 style="color:#900;">'.$this->session->flashdata('message2').'</h3>'; ?>
<form id="order_form" name="order_form" method="post" enctype="multipart/form-data" onsubmit="submit_form.disabled = true; return true;" >
<div class="form">
<div id="ad-form">
      <div id="ad-form-h">Submit Revision</div>
      <div id="ad-form-p">&nbsp;</div>
      <div id="ad-form-s">
      <!--<form id="contactform">      -->
        <div id="ad-form-s-l">
       <p class="contact"><label for="name">Adwit Ads ID</label></p>
		<input type="text" id="order_id" name="order_id" value="<?php echo $order; ?>" readonly />
        
        <p class="contact"><label for="name">Unique Job ID</label></p>
		<input type="text" id="job_name" name="job_name" value="<?php echo $cat_result['job_name']; ?>" readonly />
			
	  
        <input type="text" id="job_slug" name="job_slug"  value="<?php echo $slug;?>" readonly style="display:none;"/> 
        
<?php if($cat_result['publication_id']=='43' || $cat_result['publication_id']=='13'){  ?> 
	  <p><input type="checkbox" name="rush" value="1" style="width:20px;"> 
	  <label for="name"><span></span>Rush</label></p>
<?php } ?>	
        </div>
        <div id="ad-form-s-r">
        <p class="contact"><label for="name">Notes & Instructions <span class="mandatory">*</span></label></p>
        <textarea name="copy_content_description" id="copy_content_description"  style="width: 80%; height: 80px;"  required></textarea>
        </div>
       <div id="ad-form-s3">
       <div style="max-width: 400px; margin: 0 auto;">
       <p style="text-align: center;">Attach File</p>
      
		<label for="name">File 1 </label> <input class="input-file uniform_on" type="file" name="ufile[]" id="ufile[]" value="upload" /> <br><br>
        <label for="name"> File 2 </label> <input type="file" name="ufile[]" id="ufile[]" value="upload" />
        </div>
        </div>
		
   
        <div id="ad-form-s4">        
        <input class="buttom" name="submit_form" id="submit_form" type="submit" value="SUBMIT" />
        </div>
      <!--</form>-->
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