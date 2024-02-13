<div id="order_form">
<div class="form">
<div id="ad-form">
      <div id="ad-form-h"><?php echo $publications['name'];?></div>
      <div id="ad-form-p">Print Ad Form</div>
      <div id="ad-form-s">
      <form id="contactform">      
        <div id="ad-form-s-l">
        <p class="contact"><label for="name">Ad Type</label>
		&nbsp;-&nbsp;<?php 
             if($order['spec_sold_ad']==0){
			 echo 'New ad';
			 }
			 if($order['spec_sold_ad']==1){ 
			 echo'Pickup/Template ad';
			 }
			 if($order['spec_sold_ad']==2){
			 echo'Resize ad';
			 }
         ?></p>    
        <p class="contact"><label for="name">Advertiser Name</label>&nbsp;-&nbsp;<?php echo $order['advertiser_name'];?></p>        
        <p class="contact"><label for="name">Unique Job Name / Number</label>&nbsp;-&nbsp;<?php echo $order['job_no'];?></p>
        
		<p class="contact"><label for="name">Date Needed</label>&nbsp;-&nbsp;<?php echo $order['date_needed']; ?></p>
        
        <p class="contact"><label for="name">Publish Date</label>&nbsp;-&nbsp;<?php echo $order['publish_date'];?></p>
        
        <p class="contact"><label for="name">Publication Name</label>&nbsp;-&nbsp;<?php echo $order['publication_name']; ?></p>
        
        
        </div>
        <div id="ad-form-s-r">
       <p class="contact"><label for="name">Width (in inches)</label>&nbsp;-&nbsp;<?php echo $order['width']; ?></p>
        
        <p class="contact"><label for="name">Height (in inches)</label>&nbsp;-&nbsp;<?php echo $order['height']; ?></p>
        
        <p class="contact"><label for="name">Full Color/B&W/Spot </label>&nbsp;-&nbsp;<?php
                $results = $this->db->get_where('print_ad_types',array('id' => $order['print_ad_type']))->result_array();
                echo $results[0]['name'];
           ?></p>
        
		<p class="contact"><label for="name">Copy/Content </label>&nbsp;-&nbsp;<?php
                        echo $order['copy_content']==1 ? 'Included in the form' : ($order['copy_content']==2 ? 'Sent separately' : 'Changes only');
                   ?></p>
        
        <p class="contact"><label for="name">Job Instruction </label>&nbsp;-&nbsp;<?php
          		//echo $order['job_instruction']!=1 ? 'Follow Instructions Carefully' : 'Be Creative';
				echo $order['job_instruction']==1 ? 'Follow Instructions Carefully' : ($order['job_instruction']==2 ? 'Be Creative' : 'Camera Ready Ad');
		  	?></p>
        
        <p class="contact"><label for="name">ArtWork </label>&nbsp;-&nbsp;<?php
		echo $order['art_work']==1 ? 'Use additional art if required' : ($order['art_work']==2 ? 'Modify art provided if necessary' : 'Use art provided without change');
		?></p>
                    
        </div>
        <div id="ad-form-s1">
        <p class="contact"><label for="name">Color Preferences</label>&nbsp;-&nbsp;<?php echo $order['color_preferences'];?></p>
        
        </div>
        <div id="ad-form-s2">
        <p class="contact"><label for="name">Font Preferences</label>&nbsp;-&nbsp;<?php echo $order['font_preferences'];?></p>
        
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
        <div id="ad-form-s5a">
        <p class="contact"><label for="name">Files Sent Via</label></p>
        </div>
        <div id="ad-form-s5b">&nbsp;</div>
        <div id="ad-form-s5e">
        <p class="contact"><label for="name">Ftp</label>&nbsp;-&nbsp;<?php	echo $order['no_fax_items']==1 ? 'yes' : 'no';?></p>
        
        </div>
<div id="ad-form-s5c">
  <p class="contact"><label for="name">Email</label>&nbsp;-&nbsp;<?php	echo $order['no_email_items']==1 ? 'yes' : 'no';?></p>
        
      </div>
      <div id="ad-form-s5f">
      <p class="contact"><label for="name">Along with this Form</label>&nbsp;-&nbsp;<?php	echo $order['with_form']==1 ? 'yes' : 'no';?></p>
      
      </div>
<div id="ad-form-s5d">&nbsp;</div>
        </div>
        <div id="ad-form-s3">
  <p class="contact"><label for="name">Copy/Conten</label><br/>
  <?php $order['copy_content_description'] = str_replace(PHP_EOL,'<br/>', $order['copy_content_description']);
	echo $order['copy_content_description'];
	?></p>
        
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

