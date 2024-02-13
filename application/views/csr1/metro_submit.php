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
		<input type="text" id="job_name" name="job_name" value="<?php echo $metro_orders[0]['job_num'].'_'.$metro_orders[0]['metro_ref']; ?>"  />
		
		<p class="contact"><label for="name">Order Type <span class="mandatory">*</span></label></p>
		<select id="order_type" name="order_type" class="select-style gender" required >
			<option value="" >Select</option>
			<option value="2" <?php if($metro_orders[0]['ad_type']=='Print'){echo'selected';} ?>> Print </option>
			<option value="1" <?php if($metro_orders[0]['ad_type']=='Web'){echo'selected';} ?>> Web </option>
			<option value="3" <?php if($metro_orders[0]['ad_type']=='Print & Web'){echo'selected';} ?>> Print & Web </option>
		</select>
		
		<p class="contact"><label for="name">Ad Type <span class="mandatory">*</span></label></p>
		<select id="ad_type" name="ad_type" class="select-style gender" required >
			<option value="" >Select</option>
			<option value="0" <?php if($metro_orders[0]['order_type']=='New'){echo'selected';} ?>> New </option>
			<option value="1" <?php if($metro_orders[0]['order_type']=='Pickup'){echo'selected';} ?>> Pickup </option>
			<option value="2" <?php if($metro_orders[0]['order_type']=='Resize'){echo'selected';} ?>> Resize </option>
		</select>
		
		<p class="contact"><label for="name">Advertiser</label></p>
		<input type="text" id="advertiser" name="advertiser" value="<?php echo $metro_orders[0]['advertiser']; ?>" readonly />
		
        <p class="contact"><label for="name">Publication_name</label></p>
		<input type="text" id="publication_name" name="publication_name" value="<?php echo $metro_orders[0]['publication']; ?>" readonly />
		
		<p class="contact"><label for="name">Color <span class="mandatory">*</span></label></p>
		<select id="color" name="color" class="select-style gender" required >
			<option value="" >Select</option>
			<option value="1" <?php if($metro_orders[0]['ad_color']=='Color'){echo'selected';} ?>> Color </option>
			<option value="2" <?php if($metro_orders[0]['ad_color']=='Black & White'){echo'selected';} ?>> B&W </option>
			<option value="3" <?php if($metro_orders[0]['ad_color']=='Spot'){echo'selected';} ?>> Spot </option>
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
		<input type="text" id="publish_date" name="publish_date" value="<?php echo date("Y-m-d", strtotime($metro_orders[0]['publish_date'])); ?>" readonly />
		-->
		<p class="contact"><label for="name">Adrep<span class="mandatory">*</span></label></p>
		<?php 
		//$adreps = $this->db->query("SELECT * FROM `adreps` WHERE `is_active`='1' ORDER BY `first_name` ASC;")->result_array(); 
		$adreps = $this->db->query("SELECT  adreps.id, adreps.first_name, adreps.publication_id
							FROM adreps 
								left outer join publications on adreps.publication_id = publications.id 
									where publications.channel = '1';")->result_array();
		?>
		<select id="adrep" name="adrep" class="select-style gender" required >
			<option value="">Select</option>
			<?php foreach($adreps as $users){ ?>
			<option value="<?php echo $users['id'].'_'.$users['publication_id']; ?>" > <?php echo $users['first_name']; ?> </option>
			<?php } ?>
        </select>
		
		<!--<p class="contact"><label for="name">Date Needed</label></p>
		<input type="text" id="date_needed" name="date_needed" value="<?php echo $metro_orders[0]['date_needed']; ?>" readonly />
		-->
		<p class="contact"><label for="name">Width (in columns)<span class="mandatory">*</span></label></p>
		<input type="text" id="width" name="width" value="<?php echo $metro_orders[0]['width']; ?>"/>
		
        <p class="contact"><label for="name">Height (in inches)<span class="mandatory">*</span></label></p>
		<input type="text" id="height" name="height" value="<?php echo $metro_orders[0]['height']; ?>" />
		
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
        <textarea name="copy_content_description" id="copy_content_description"  style="width: 80%; height: 80px;"   ><?php //echo $metro_orders[0]['copy_content_description']; ?></textarea>
	   <p class="contact"><label for="name">Notes & Instructions </label></p>
        <textarea name="notes" id="notes"  style="width: 80%; height: 80px;" ><?php echo $metro_orders[0]['last_customer_msg']; ?></textarea>
       
	   <div style="max-width: 400px; margin: 0 auto;">
       <p class="contact"><label for="name">Attach File(s)</label></p>
	   <!--
		<?php $this->load->helper('directory');
				$path = '../softwritetechnologies.com/login/forms/'.$metro_orders[0]['id'] ;
				$map = directory_map($path.'/');
				if($map){ foreach($map as $row){ //echo $row;
				?>
				<a href="<?php echo $path.'/'.$row;?>" target="_blank" style="cursor:pointer; text-decoration: none;"><?php echo $row; ?></a>
				<br/><br/>
		<?php
			} }   
	   ?>-->
		<label for="name">File 1 </label> <input class="input-file uniform_on" type="file" name="ufile[]" id="ufile[]" value="upload" accept="application/pdf" /> <br><br>
        <label for="name"> File 2 </label> <input type="file" name="ufile[]" id="ufile[]" value="upload" accept="application/pdf" />
		<label for="name"> File 3 </label> <input type="file" name="ufile[]" id="ufile[]" value="upload" accept="application/pdf" />
		
	   </div>
		
        </div>
		
   
        <div id="ad-form-s4">  
		<input name="id" value="<?php echo $metro_orders[0]['id'];?>" readonly style="display:none;" />
		<!--<input name="adrep_id" value="<?php echo "36"; ?>" readonly style="display:none;" />	
		<input name="publication_id" value="<?php echo "13"; ?>" readonly style="display:none;" />	
        -->
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