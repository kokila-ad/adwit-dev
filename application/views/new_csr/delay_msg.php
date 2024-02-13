<?php $this->load->view("new_csr/head.php"); ?>
<link rel="stylesheet" href="jq-ui/themes/base/jquery.ui.all.css" />

<div class="container"> 
<div id="form">
<form id="order_form" name="order_form" method="post">
<div class="form">
<div id="ad-form">
      <!--<div id="ad-form-h"></div>-->
	  <div>
	  &nbsp;
	  </div>
      <div id="ad-form-p" class="alert alert-danger"><strong>Delay Message</strong></div>
      <div id="ad-form-s">
      <form id="contactform">      
        <div class="form-group">
       <label class="control-label">Ad No <span>*</span></label>
		<input class="form-control" type="text" id="order_id" name="order_id" value="<?php echo $order['id']; ?>" readonly/>
        </div>
		
       <div class="form-group">
	    <label class="control-label">Message</label>
        <textarea name="msg" id="msg" class="form-control" required></textarea>
        </div>
	
   <div>
	  &nbsp;
	  </div>
        <div id="ad-form-s4"> 
		<input name="job_name" value="<?php echo $order['job_no'];?>" readonly style="display:none;" /> 
        <button type="submit" class="btn blue" name="submit" type="submit" value="SUBMIT"  />SUBMIT</button>
        </div>
		<div>
	  &nbsp;
	  </div>
      </form>
      </div>
    </div>
</div>
</form>
</div>
</div>

<?php $this->load->view("new_csr/foot.php"); ?>