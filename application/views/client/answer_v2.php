<?php
	 $this->load->view("client/header1");
?>
<link rel="stylesheet" href="jq-ui/themes/base/jquery.ui.all.css" />

<div id="Middle-Div">

<!-- rev_sold_jobs -->
<?php if(isset($rev_sold_jobs)){ ?>
<div id="form">
<form id="order_form" name="order_form" method="post" enctype="multipart/form-data">
<div class="form">
<div id="ad-form">
      <!--<div id="ad-form-h"></div>-->
      <div id="ad-form-p">Answer</div>
      <div id="ad-form-s">
      <form id="contactform">      
        <div id="ad-form-s-l">
       <p class="contact"><label for="name">Ad No <span class="mandatory">*</span></label></p>
		<input type="text" id="order_id" name="order_id" value="<?php echo $rev_sold_jobs['order_id']; ?>" readonly />
			
	   <p class="contact"><label for="name">Job Slug</label></p>
        <input type="text" id="job_slug" name="job_slug"  value="<?php echo $rev_sold_jobs['order_no']; ?>" readonly />
        
        </div>
       <div id="ad-form-s3">
	   <p class="contact"><label for="name">Question <span class="mandatory">*</span></label></p>
        <textarea name="answer" id="answer" readonly /><?php $question['question'] = str_replace(PHP_EOL,'<br/>', $question['question']); echo $question['question'] ; ?></textarea>
		<p class="contact"><label for="name">Answer <span class="mandatory">*</span></label></p>
        <textarea name="answer" id="answer" required></textarea>
        </div>
   
		<div id="ad-form-s3">
       <div style="max-width: 400px; margin: 0 auto;">
       <p style="text-align: center;">Attach File</p>
      
		<label for="name">File 1 </label> 
		<input class="input-file uniform_on" type="file" name="ufile[]" id="ufile[]" accept="application/pdf" /> 
		<br><br>
        
        </div>
        </div>
   
        <div id="ad-form-s4">
		<input name="id" value="<?php echo $question['id'];?>" readonly style="display:none;" />			
        <input class="buttom" name="submit" type="submit" value="SUBMIT"  />
        </div>
      </form>
      </div>
    </div>
</div>
</form>
</div>
<?php }else{ ?>

<div id="form">
<form id="order_form" name="order_form" method="post" enctype="multipart/form-data">
<div class="form">
<div id="ad-form">
      <!--<div id="ad-form-h"></div>-->
      <div id="ad-form-p">Answer</div>
      <div id="ad-form-s">
      <form id="contactform">      
        <div id="ad-form-s-l">
       <p class="contact"><label for="name">Ad No <span class="mandatory">*</span></label></p>
		<input type="text" id="order_id" name="order_id" value="<?php echo $question['order_id']; ?>" readonly />
		
        </div>
       <div id="ad-form-s3">
	   <p class="contact"><label for="name">Question <span class="mandatory">*</span></label></p>
        <textarea name="answer" id="answer" readonly /><?php $question['question'] = str_replace(PHP_EOL,'<br/>', $question['question']); echo $question['question'] ; ?></textarea>
		<p class="contact"><label for="name">Answer <span class="mandatory">*</span></label></p>
        <textarea name="answer" id="answer" required></textarea>
        </div>
   
		<div id="ad-form-s3">
       <div style="max-width: 400px; margin: 0 auto;">
       <p style="text-align: center;">Attach File</p>
      
		<label for="name">File 1 </label> <input class="input-file uniform_on" type="file" name="ufile[]" id="ufile[]" value="upload" /> 
		<label for="name">File 2 </label> <input type="file" name="ufile[]" id="ufile[]" value="upload" /> 
		<br><br>
        
        </div>
        </div>
   
        <div id="ad-form-s4">
		<input name="id" value="<?php echo $question['id'];?>" readonly style="display:none;" />
		<!--<input name="job_name" value="<?php echo $cat_result['job_name'];?>" readonly style="display:none;" />-->
        <input class="buttom" name="submit" type="submit" value="SUBMIT"  />
        </div>
      </form>
      </div>
    </div>
</div>
</form>
</div>

<?php } ?>
</div>


<?php
	$this->load->view("client/footer");
?>