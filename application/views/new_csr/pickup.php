<?php
	$this->load->view("csr/header");
?>
	 <link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/DT_bootstrap.css" rel="stylesheet" media="screen">
        <script src="theme001/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>

<script>
function handleChange(input) {
    if (input.value <= 0) input.value = 0;
    if (input.value >= 100) input.value = 99;
  } 
</script>

<style>
#confirm input {
	background: #333; color: #FFF; border: 0;
}
</style>

	<link href="ui-lightness/jquery-ui-1.10.3.custom.css" rel="stylesheet">

<div id="Middle-Div">
<?php echo '<h3 style="color:#900;">'.$this->session->flashdata('message').'</h3>'; ?>
<?php echo '<h3 style="color:#0066FF;">'.$this->session->flashdata('message1').'</h3>'; ?>
<p><form method="post" style="text-align: center;">
               <span>Pickup Order:  </span><input type="text" name="order_id" id="order_id" placeholder="search order" style="padding: 5px; outline:none;" required />
               <input type="submit" name="Search" value="Submit" />
   </form></p>


<?php if(isset($order)): 
	$publications = $this->db->get_where('publications',array('id' => $order['publication_id']))->result_array();
	$adreps = $this->db->get_where('adreps',array('id' => $order['adrep_id']))->result_array();

	
?>

   <div id="order_form">
      <form name="form" method="post" enctype="multipart/form-data">
   <div id="ad-form"> 
         <div id="ad-form-h">Publication Name: <?php echo $publications[0]['name']; ?></div>
		 <div id="ad-form-h">Adrep Name: <?php echo $adreps[0]['first_name']; ?></div>
   <div id="ad-form-s-l">
   <!--<p class="contact"><label for="name">Order No</label></p> -->
        <input type="text" id="order_no" name="order_no" value="<?php if(isset($order_no))echo $order_no; ?>" autocomplete="off" readonly style="visibility:hidden" /> 
   
   <p class="contact"><label for="name">Pickup Number</label></p>
        <input name="pickup_adno" type="text" value="<?php echo $order['id'];?>" readonly>
   
   <p class="contact"><label for="name">Unique Job Name Number</label></p>
        <input name="job_name" type="text" required>
		
        <p class="contact"><label for="name">Width</label></p>
        <input value="<?php echo $order['width'];?>" id="width" name="width" autocomplete="off" onchange="handleChange(this);" />
	
	<p class="contact"><label for="name">Height</label></p>
        <input id="height" name="height" value="<?php echo $order['height'];?>" autocomplete="off" onchange="handleChange(this);" />

	<p class="contact"><label for="name">Advertiser Name(Client Name)</label></p>
        <input name="advertiser" type="text" value="<?php echo $order['advertiser_name'];?>" autocomplete="off">
    
   </div>
   
   <div id="ad-form-s-r">  
  
       <p class="contact"><label for="name">Ad Type</label></p>
        <?php $results = $this->db->query("select * from `cat_new_adtype` where `name` like 'Pickup%';")->result_array();
		
		foreach($results as $result)
		{
			echo '<input type="radio" name="adtype" id="adtype" value="'.$result['id'].'" required="required" style="width:5%;"><label>'.$result['name'].'</label>';
     		echo '<br/>';
		}
	?>

	<p class="contact" style="padding-top:15px;"><label for="name">Art Instruction</label></p>
        <?php $results = $this->db->get('cat_artinstruction')->result_array();
		
		foreach($results as $result)
		{
			echo '<input type="radio" name="artinst" id="artinst" value="'.$result['id'].'" required="required" style="width:5%;"><label>'.$result['name'].'</label>';
     		echo '&nbsp';
		}
		echo '<br/>';
		?>
	
	<p class="contact"><label for="name">Full Color/B&W/Spot <span class="mandatory">*</span></label></p>
        <select class="select-style gender" id="print_ad_type" name="print_ad_type">
          <option value="">Select</option>
          <?php
					$results = $this->db->get('print_ad_types')->result_array();
					foreach($results as $result)
					{
						echo '<option value="'.$result['id'].'"'.($result['id']==$order['print_ad_type'] ? 'selected="selected"': '').'  >'.$result['name'].'</option>';	
					}
				?>
        </select>
	
	<p class="contact"><label for="name">Copy/Content <span class="mandatory">*</span></label></p>
        <textarea name="copy_content_description" id="copy_content_description" required ></textarea>
	
	  </div>
	  
	<div id="ad-form-s3">
       <div style="max-width: 400px; margin: 0 auto;">
       <p style="text-align: center;"><label for="name">Attach File</label></p>
      
		<label for="name">File 1 </label> <input class="input-file uniform_on" type="file" name="ufile[]" id="ufile[]" value="upload" /> <br><br>
        <label for="name"> File 2 </label> <input type="file" name="ufile[]" id="ufile[]" value="upload" />
        </div>
    </div>
	  
   <div id="ad-form-s4">  
		<input type="text" id="adrep_id" name="adrep_id" value="<?php echo $order['adrep_id']; ?>" style="visibility:hidden" /> 
		<input type="text" id="publication_id" name="publication_id" value="<?php echo $order['publication_id']; ?>" style="visibility:hidden" /> 
        <input class="buttom" type="submit" name="Submit" value="SUBMIT" style="width:20%" />
      
        </div>
   </div>

</form>
</div>
<div id="Back-btn"><a href="<?php echo base_url().index_page().'csr/home/';?>">Back</a></div>

<?php  endif; ?>
</div>

  <?php
	$this->load->view("csr/footer");
?>