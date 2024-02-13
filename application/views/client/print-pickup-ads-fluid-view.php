<div id="order_form">
<div class="form">
<div id="ad-form">
      <div id="ad-form-h"><?php echo $publications['name'];?></div>
      <div id="ad-form-p">Pickup Print Ad</div>
      <div id="ad-form-s">
      <form id="contactform">      
        <div id="ad-form-s-l">
        <p class="contact"><label for="name">Advertiser Name</label>&nbsp;-&nbsp;<?php echo $order['advertiser_name'];?></p>
        <p class="contact"><label for="name">Pickup Ad No</label>
		&nbsp;-&nbsp;<?php 
              if($order['pickup_adno']==0){
			 echo 'Resize ad';
			 }else{
			 echo $order['pickup_adno'];
			 }
         ?></p>              
        <p class="contact"><label for="name">Unique Job Name / Number</label>&nbsp;-&nbsp;<?php echo $order['job_no'];?></p>
        </div>
        <div id="ad-form-s-r">
        <p class="contact"><label for="name">Publication Name</label>&nbsp;-&nbsp;<?php echo $order['publication_name']; ?></p>
       <p class="contact"><label for="name">Width (in inches)</label>&nbsp;-&nbsp;<?php echo $order['width']; ?></p>
        
        <p class="contact"><label for="name">Height (in inches)</label>&nbsp;-&nbsp;<?php echo $order['height']; ?></p>
        
        <p class="contact"><label for="name">Full Color/B&W/Spot </label>&nbsp;-&nbsp;<?php
                $results = $this->db->get_where('print_ad_types',array('id' => $order['print_ad_type']))->result_array();
                echo $results[0]['name'];
           ?></p>
                    
        </div>
                        <div id="ad-form-s3">
  <?php $order['copy_content_description'] = str_replace(PHP_EOL,'<br/>', $order['copy_content_description']);?>						
  <p class="contact"><label for="name">Copy/Content</label><br/><?php echo $order['copy_content_description'];?></p>
        
        <p class="contact"><label for="name">Notes & Instructions</label><br/><?php echo htmlspecialchars($order['notes'], ENT_QUOTES, 'UTF-8'); ?></p>
        
      </div>
      </form>
	  <?php
	  if(isset($file_path)){
		echo "<p> Files Uploaded</p>";
		$this->load->helper('directory');

		$map = directory_map($file_path.'/');
		if($map){
			foreach($map as $row)
			{
				echo $row."<br/>";
			}
		}else{ echo "None"; } 
	  }
	  ?>
      </div>
    </div>

</div>
</div>