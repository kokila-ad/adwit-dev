<?php
	$this->load->view("csr/header1");
?>
<script type="text/javascript">
	
	$(document).ready(function(e) {    

		
		$('#priority').change(function(e) {
            if($("#priority").attr("checked")) $('#ad-form-sr-custom').show();
			else $('#ad-form-sr-custom').hide();
        });	
		
		 if($("#priority").attr("checked")) $('#ad-form-sr-custom').show();
		else $('#ad-form-sr-custom').hide();
		
		
	});
</script>
<style>
#confirm input {
	background: #333; color: #FFF; border: 0;
}
</style>
<link href="ui-lightness/jquery-ui-1.10.3.custom.css" rel="stylesheet">
	

<div id="Middle-Div">
	<p style="padding:0 0 0 10px; margin:0;"><?php echo $this->session->flashdata('message'); ?></p> 
	
<!-- Question -->
<div id="form"><div style="font-weight: bold; color:#F00;" align='center'>Question Tab</div>
<?php if(isset($question)){ 
		foreach($question as $q){ ?>
		
<div class="form">
<div id="ad-form">
      <div id="ad-form-s">
	  
	  <div id="ad-form-s-l">
       <p class="contact"><label for="name">Ad No <span class="mandatory">*</span></label></p>
		<input type="text" id="order_id" name="order_id" value="<?php echo $order[0]['id']; ?>" readonly/>
	  </div>
		
	  <div id="ad-form-s-l">
      <div id="ad-form-s3">
		<p class="contact"><label for="name">Question <span class="mandatory">*</span></label></p>
        <textarea name="question" id="question" readonly><?php echo $q['question']; ?></textarea>
       </div>
	  </div>
	  
<?php if($q['answer']!='') {?>
		<div id="ad-form-s-r">
		 <div id="ad-form-s3">
			<p class="contact"><label for="name">Answer <span class="mandatory">*</span></label></p>
			<textarea name="question" id="question" readonly><?php echo $q['answer']; ?></textarea>
		</div>
		</div>
<?php }else{ ?>

<form id="order_form" name="order_form" action="<?php echo base_url().index_page().'csr/home/cshift_answer_v2/'.$hd.'/'.$order[0]['id'];?>" method="post" enctype="multipart/form-data">

       <div id="ad-form-s3">
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
		<input name="id" value="<?php echo $q['id'];?>" readonly style="display:none;" />
		<!--<input name="job_name" value="<?php echo $cat_result['job_name'];?>" readonly style="display:none;" />-->
        <input class="buttom" name="submit" type="submit" value="SUBMIT"  />
        </div>
      
</form>

<?php } ?>
      
      </div>
    </div>
</div>

<?php } }if($order[0]['question']=='0' || $order[0]['question']=='2'){ ?>
<form id="order_form" name="order_form" action="<?php echo base_url().index_page().'csr/home/cshift_question_v2/'.$hd.'/'.$order[0]['id'];?>" method="post" enctype="multipart/form-data">
<div class="form">
<div id="ad-form">
      <!--<div id="ad-form-h"></div>-->
      <div id="ad-form-p">Question</div>
      <div id="ad-form-s">
      <form id="contactform">      
        <div id="ad-form-s-l">
       <p class="contact"><label for="name">Ad No <span class="mandatory">*</span></label></p>
		<input type="text" id="order_id" name="order_id" value="<?php echo $order[0]['id']; ?>" readonly/>
		        
        </div>
       <div id="ad-form-s3">
		<p class="contact"><label for="name">Message <span class="mandatory">*</span></label></p>
        <textarea name="question" id="question" required></textarea>
        </div>
   
        <div id="ad-form-s4"> 
		<input name="job_name" value="<?php echo $order[0]['job_no'];?>" readonly style="display:none;" /> 
        <input class="buttom" name="submit" type="submit" value="SUBMIT"  />
        </div>
      </form>
      </div>
    </div>
</div>
</form>
<?php } ?>
</div>

<!-- Cancel -->
<div id="form"><div style="font-weight: bold; color:#F00;" align='center'>Order Cancellation Tab</div>
<?php if($order[0]['crequest']=='0'){ ?>
<form id="order_form" name="order_form" action="<?php echo base_url().index_page().'csr/home/ordercshift_cancel_v2/'.$hd.'/'.$order[0]['id'];?>" method="post" enctype="multipart/form-data">
<div class="form">
<div id="ad-form">
      <div id="ad-form-s">
      <form id="contactform">      
        <div id="ad-form-s-l">
         <p class="contact"><label for="name">Ad No <span class="mandatory">*</span></label></p>
		 <input type="text" id="order_id" name="order_id" value="<?php echo $order[0]['id']; ?>" readonly/>
		</div>
		<div id="ad-form-s3">
		 <p class="contact"><label for="name">Reason <span class="mandatory">*</span></label></p>
         <textarea name="reason" id="reason" required></textarea>
        </div>
   
        <div id="ad-form-s4"> 
		<input class="buttom" name="remove" type="submit" value="SUBMIT" />
        </div>
      </form>
      </div>
    </div>
</div>
</form>
<?php }elseif(isset($cancel)){ ?>
<div class="form">
<div id="ad-form">
	<div id="ad-form-s">
	  <p class="contact"><label for="name"> Order Cancellation Request Sent..!! </label></p>
	  <form id="contactform">      
        <div id="ad-form-s3">
		 <p class="contact"><label for="name">Reason <span class="mandatory">*</span></label></p>
         <textarea name="reason" id="reason" readonly> <?php echo $cancel[0]['Creason']; ?> </textarea>
        </div>
	  </form>
	 </div>
</div>
</div>
<?php } ?>
</div>

</div>
  <?php
	$this->load->view("csr/footer");
?>









