<?php $this->load->view("new_csr/head.php"); ?>
<link rel="stylesheet" href="jq-ui/themes/base/jquery.ui.all.css" />

<div class="container"> 
<div id="form">
<form id="order_form" name="order_form" method="post" enctype="multipart/form-data">
<div class="form">
<div id="ad-form">
      <!--<div id="ad-form-h"></div>-->
     <div>
	  &nbsp;
	  </div>
      <div id="ad-form-p" class="alert alert-danger"><strong>Question</strong></div>
      <div id="ad-form-s">
      <form id="contactform">      
          <div class="form-group">
       <label class="control-label">Ad No <span class="mandatory">*</span></label></label>
		<input type="text" class="form-control" id="order_id" name="order_id" value="<?php echo $cat_result['order_no']; ?>" readonly/>   
        </div>
      <div class="form-group">
		<label class="control-label">Message<span class="mandatory">*</span></label>
        <textarea class="form-control" name="question" id="question" required></textarea>
        </div>
   <div>
   &nbsp;
   </div>
        <div id="ad-form-s4"> 
		<input name="id" value="<?php echo $cat_result['id'];?>" readonly style="display:none;" />	
		<input name="job_name" value="<?php echo $cat_result['job_name'];?>" readonly style="display:none;" /> 
       <button type="submit" class="btn blue" name="submit" type="submit" value="SUBMIT">SUBMIT</button>
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