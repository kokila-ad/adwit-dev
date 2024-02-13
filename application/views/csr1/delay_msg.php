<?php
	$this->load->view("csr/header");
?>
<link rel="stylesheet" href="jq-ui/themes/base/jquery.ui.all.css" />

<div id="Middle-Div">
<div id="form">
<form id="order_form" name="order_form" method="post">
<div class="form">
<div id="ad-form">
      <!--<div id="ad-form-h"></div>-->
      <div id="ad-form-p">Delay Message</div>
      <div id="ad-form-s">
      <form id="contactform">      
        <div id="ad-form-s-l">
       <p class="contact"><label for="name">Ad No <span class="mandatory">*</span></label></p>
		<input type="text" id="order_id" name="order_id" value="<?php echo $order['id']; ?>" readonly/>
		        
        </div>
       <div id="ad-form-s3">
		<p class="contact"><label for="name">Message <span class="mandatory">*</span></label></p>
        <textarea name="msg" id="msg" required></textarea>
        </div>
   
        <div id="ad-form-s4"> 
		<input name="job_name" value="<?php echo $order['job_no'];?>" readonly style="display:none;" /> 
        <input class="buttom" name="submit" type="submit" value="SUBMIT"  />
        </div>
      </form>
      </div>
    </div>
</div>
</form>
</div>
</div>


<?php
	$this->load->view("csr/footer");
?>