<div id="order_form">
<div class="form">
<div id="ad-form">
      <div id="ad-form-h"><?php echo $publications['name'];?></div>
      <div id="ad-form-p">Html Email Blast</div>
      <div id="ad-form-s">
      <form id="contactform">      
        <div id="ad-form-s-l"> 
        <p class="contact"><label for="name">Advertiser Name</label>&nbsp;-&nbsp;<?php echo $order['advertiser_name'];?></p>        
        <p class="contact"><label for="name">Unique Job Name / Number</label>&nbsp;-&nbsp;<?php echo $order['job_no'];?></p>
        
		<p class="contact"><label for="name">Date Needed</label>&nbsp;-&nbsp;<?php echo $order['date_needed']; ?></p>
		<p class="contact">
		  <label for="name2">Width (in Pixel)</label>
		  &nbsp;-&nbsp;<?php echo $order['custom_width']; ?></p>
        </div>
        <div id="ad-form-s-r">
          <p class="contact"><label for="name">Job Instruction </label>&nbsp;-&nbsp;<?php
          		echo $order['job_instruction']!=1 ? 'Follow Instructions Carefully' : 'Be Creative';
		  	?></p>
        
        <p class="contact"><label for="name">ArtWork </label>&nbsp;-&nbsp;<?php
		echo $order['art_work']==1 ? 'Use additional art if required' : ($order['art_work']==2 ? 'Modify art provided if necessary' : 'Use art provided without change');
		?></p>
        
        <p class="contact"><label for="name">Color Preferences</label>&nbsp;-&nbsp;<?php echo $order['color_preferences'];?></p>
        
        <p class="contact"><label for="name">Font Preferences</label>&nbsp;-&nbsp;<?php echo $order['font_preferences'];?></p>
                    
        </div>
        <div id="ad-form-s5">
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
		<?php
		$order['copy_content_description'] = str_replace(PHP_EOL,'<br/>', $order['copy_content_description']);
		?>
  <p class="contact"><label for="name">Copy/Content</label><br/><?php echo $order['copy_content_description'];?></p>
        
        <p class="contact"><label for="name">Notes & Instructions</label><br/><?php echo $order['notes'];?></p>
        
      </div>
      </form>
      </div>
    </div>

</div>
</div>

