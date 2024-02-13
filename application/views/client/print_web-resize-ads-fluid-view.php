<div id="order_form">
<div class="form">
<div id="ad-form">
      <div id="ad-form-h"><?php echo $publications['name'];?></div>
      <div id="ad-form-p">Resize Print & web Ad</div>
      <div id="ad-form-s">
      <form id="contactform">      
        <div id="ad-form-s-l">
        <p class="contact"><label for="name">Advertiser Name</label>&nbsp;-&nbsp;<?php echo $order['advertiser_name'];?></p>
        <p class="contact"><label for="name">Resize Ad No</label>&nbsp;-&nbsp;
		<?php echo $order['pickup_adno'];?></p>        
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
		<div id="ad-form-s5">
        <div id="ad-form-s6">
        <div id="ad-form-s6a">Web Ad</div>
        <div id="ad-form-s6b">
        <p class="contact"><label for="name">Format </label>&nbsp;-&nbsp;<?php
                $results = $this->db->get_where('web_ad_formats',array('id' => $order['ad_format']))->result_array();
                echo $results[0]['name'];
           ?></p>
                </div>
        <div id="ad-form-s6c">
        <p class="contact"><label for="name">Size (in Pixels)</label>&nbsp;-&nbsp;<?php
                if($order['pixel_size']!='custom'):
					 $results = $this->db->get_where('pixel_sizes',array('id' => $order['pixel_size']))->result_array();
					 echo $results[0]['width'].' x '.$results[0]['height'].' ('.$results[0]['name'].')';
                else:
					 echo 'Custom';
				endif;
           ?></p>
                </div>
                
                <?php if($order['pixel_size']=='custom')
  {?>	
        <div id="ad-form-s6e">
        <div id="ad-form-s6ea">
       <p class="contact"><label for="name">Width (in inches)</label>&nbsp;-&nbsp;<?php echo $order['custom_width']; ?></p>
                </div>
        <div id="ad-form-s6eb">
        <p class="contact"><label for="name">Height (in inches)</label>&nbsp;-&nbsp;<?php echo $order['custom_height']; ?></p>
                </div>
        </div>
        <?php } ?>
<div id="ad-form-s6b">
  <p class="contact"><label for="name">Maximum File Size (In KBs) </label>&nbsp;-&nbsp;<?php echo $order['maxium_file_size']; ?></p>
              </div>
        <div id="ad-form-s6c">
        <p class="contact"><label for="name">Web Ad Type </label>&nbsp;-&nbsp;<?php
                    echo $order['web_ad_type']!=1 ? 'Static' : 'Animated';
               ?></p>
                </div>
        </div>
	<div id="ad-form-s5b">&nbsp;</div>
<div id="ad-form-s5d">&nbsp;</div>
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

