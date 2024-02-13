<?php
	$this->load->view("csr/header");
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
<?php echo '<h3 style="color:#900;">'.$this->session->flashdata('message').'</h3>'; ?>
<form id="order_form" name="order_form" method="post" enctype="multipart/form-data">
<div class="form">
<div id="ad-form">
      <div id="ad-form-h">Order Submit Form</div>
      <div id="ad-form-p">&nbsp;</div>
      <div id="ad-form-s">
      <form id="contactform">      
        <div id="ad-form-s-l">
               
        <p class="contact"><label for="name">Unique Job ID</label></p>
		<input type="text" id="job_name" name="job_name" value="<?php echo 'S'.$softwrite_orders[0]['id'].'_'.$softwrite_orders[0]['ad_identifier']; ?>"  />
			
		<p class="contact"><label for="name">Advertiser</label></p>
		<input type="text" id="advertiser" name="advertiser" value="<?php echo $softwrite_orders[0]['advertiser']; ?>" readonly />
		
        <p class="contact"><label for="name">Publication</label></p>
		<input type="text" id="publication" name="publication" value="<?php echo $soft_publications[0]['name']; ?>" readonly />
		
		<p class="contact"><label for="name">Color <span class="mandatory">*</span></label></p>
		<?php $results = $this->db->get('soft_adtype')->result_array(); ?>
		<select id="color" name="color" class="select-style gender" required >
			<?php
				foreach($results as $result)
				{ ?>
			<option value="<?php echo $result['id'] ?>" <?php if($result['id']==$softwrite_orders[0]['adtype']){echo'selected';} ?>> <?php echo $result['name'] ?> </option>
			<?php } ?>
        </select>
		
		<p class="contact"><label for="name">Art Instruction <span class="mandatory">*</span></label></p>
        <?php $results = $this->db->get('cat_artinstruction')->result_array();
			foreach($results as $result)
			{
				echo '<input type="radio" name="artinst" id="artinst" value="'.$result['id'].'" required="required" style="width:5%;"><label>'.$result['name'].'</label>';
				echo '&nbsp';
			}
			//echo '<br/>';
		?>
		
        </div>
        <div id="ad-form-s-r">
		<!--
			<p class="contact"><label for="name">Publish Date</label></p>
		<input type="text" id="publish_date" name="publish_date" value="<?php echo date("Y-m-d", strtotime($softwrite_orders[0]['publish_date'])); ?>" readonly />
		-->
		<p class="contact"><label for="name">Adrep<span class="mandatory">*</span></label></p>
		<input type="text" id="user" name="user" value="<?php echo $soft_users[0]['first_name']; ?>" readonly required />
		
		<p class="contact"><label for="name">Date Needed</label></p>
		<input type="text" id="date_needed" name="date_needed" value="<?php echo $softwrite_orders[0]['date_needed']; ?>" readonly />
		
		<p class="contact"><label for="name">Width (in columns)<span class="mandatory">*</span></label></p>
		<input type="text" id="width" name="width" value="<?php echo $softwrite_orders[0]['width']; ?>"/>
		
        <p class="contact"><label for="name">Height (in inches)<span class="mandatory">*</span></label></p>
		<input type="text" id="height" name="height" value="<?php echo $softwrite_orders[0]['height']; ?>" />
		
		<p class="contact"><label for="name">Ad Type <span class="mandatory">*</span></label></p>
		<?php $results = $this->db->get('cat_new_adtype')->result_array(); 
		foreach($results as $result)
		{
			echo '<input type="radio" name="adtype" id="adtype" value="'.$result['id'].'" required="required" style="width:5%;"><label>'.$result['name'].'</label>';
     		echo '<br/>';
		} echo '<br/>';
		?>
				
		<!--<p><input type="checkbox" name="rush" value="1" style="width:20px;"> <label for="name"><span></span>Rush</label></p>-->
		</div>
       <div id="ad-form-s3">
	   <p class="contact"><label for="name">Copy & Content <span class="mandatory">*</span></label></p>
        <textarea name="copy_content_description" id="copy_content_description"  style="width: 80%; height: 80px;" required readonly ><?php echo $softwrite_orders[0]['copy_content_description']; ?></textarea>
	   <p class="contact"><label for="name">Notes & Instructions </label></p>
        <textarea name="notes" id="notes"  style="width: 80%; height: 80px;" ><?php echo $softwrite_orders[0]['notes']; ?></textarea>
       
	   <div style="max-width: 400px; margin: 0 auto;">
       <p class="contact"><label for="name">Attach File(s)</label></p>
	   
		<?php $this->load->helper('directory');
				$path = '../softwritetechnologies.com/login/forms/'.$softwrite_orders[0]['id'] ;
				$map = directory_map($path.'/');
				if($map){ foreach($map as $row){ //echo $row;
				?>
				<a href="<?php echo $path.'/'.$row;?>" target="_blank" style="cursor:pointer; text-decoration: none;"><?php echo $row; ?></a>
				<br/><br/>
		<?php
			} }   
	   ?>
		<label for="name">File 1 </label> <input class="input-file uniform_on" type="file" name="ufile[]" id="ufile[]" value="upload" accept="application/pdf" /> <br><br>
        <label for="name"> File 2 </label> <input type="file" name="ufile[]" id="ufile[]" value="upload" accept="application/pdf" />
		<label for="name"> File 3 </label> <input type="file" name="ufile[]" id="ufile[]" value="upload" accept="application/pdf" />
		
	   </div>
		
        </div>
		
   
        <div id="ad-form-s4">  
		<input name="id" value="<?php echo $softwrite_orders[0]['id'];?>" readonly style="display:none;" />
		<input name="adrep_id" value="<?php echo $soft_users[0]['adwit_adrep_id']; ?>" readonly style="display:none;" />	
		<input name="publication_id" value="<?php echo $soft_publications[0]['adwit_publication_id']; ?>" readonly style="display:none;" />	
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
	$this->load->view("csr/footer");
?>