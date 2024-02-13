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
	<p style="padding:0 0 0 10px; margin:0;"><?php echo validation_errors(); ?></p>
   <div id="order_form">
      <form name="form" method="post" >
   <div id="ad-form">
         <div id="ad-form-h">Category Tool</div>
   <div id="ad-form-s-l">
   <p class="contact"><label for="name">Order No</label></p>
        <input type="text" id="order_no" name="order_no" value="<?php echo set_value('order_no'); ?><?php if(isset($order))echo $order[0]['id'];?>" autocomplete="off" >


	<p class="contact"><label for="name">Job Name</label></p>
        <!--<input name="job_name" type="text" value="<?php echo set_value('job_name');?><?php if(isset($order)){if($order[0]['publication_id']=='26'){echo $order[0]['job_no'];}else{echo $order[0]['job_no']."_".$order[0]['advertiser_name'];}}?>" autocomplete="off" required >-->
        <input name="job_name" type="text" value="<?php echo set_value('job_name');?><?php if(isset($order))echo $order[0]['job_no'];?>" autocomplete="off" required >
		
            <p class="contact"><label for="name">Width</label></p>
        <input value="<?php echo set_value('width');?><?php if(isset($order))echo $order[0]['width'];?>" id="width" name="width" autocomplete="off" />
	
	<p class="contact"><label for="name">Height</label></p>
        <input onChange="fill()"  id="height" name="height" value="<?php echo set_value('height');?><?php if(isset($order))echo $order[0]['height'];?>" autocomplete="off"  />
	
	<p class="contact"><label for="name">Adrep Name</label></p>
		<?php if(isset($order)){ $adrep = $this->db->get_where('adreps',array('id' => $order[0]['adrep_id']))->result_array(); } ?>
        <input name="adrep" type="text" value="<?php echo set_value('adrep');?><?php if(isset($order))echo $adrep[0]['first_name'];?>" autocomplete="off" required >
        	
    
	<p class="contact"><label for="name">Advertiser Name</label></p>
        <input name="adv_name" type="text" value="<?php echo set_value('adv_name');?><?php if(isset($order))echo $order[0]['advertiser_name'];?>" autocomplete="off" required >
        	
	<p class="contact" style="padding-top:15px; padding-bottom: 10px;"><label for="name">Copy/Content</label></p>
		<textarea name="copy_content_description" rows="2" cols="50" ><?php if(isset($order))echo $order[0]['copy_content_description']; else echo set_value('copy_content_description'); ?></textarea>
	
	<p class="contact" style="padding-top:15px; padding-bottom: 10px;"><label for="name">Notes & Instructions</label></p>
        <textarea id="notes" name="notes" rows="2" cols="50" ><?php if(isset($order))echo $order[0]['notes']; else echo set_value('notes'); ?></textarea>
   </div>
   
   <div id="ad-form-s-r">
 
<div style=" display: none;">	<p class="contact"><label for="name">No of Options</label></p>
        <select class="select-style gender" id="no_pages" name="no_pages" >

   	<option value="1" <?php echo set_select('no_pages', '1');?> >1</option>
	<!--<option value="2" <?php echo set_select('no_pages', '2');?> >2</option>
	<option value="3" <?php echo set_select('no_pages', '3');?> >3</option>
	<option value="4" <?php echo set_select('no_pages', '4');?> >4</option>
	<option value="5" <?php echo set_select('no_pages', '5');?> >5</option> -->     
         
    </select> </div>
    
    		
   <p class="contact"><label for="name">Ad Type</label></p>
        <?php $results = $adtype;
		
		foreach($results as $result)
		{
			echo '<input type="radio" name="adtype" id="adtype" value="'.$result['id'].'" '.set_radio('adtype',$result['id']).' onClick="run(this.value);" required="required" style="width:5%;"><label>'.$result['name'],'</label>';
     		echo '<br/>';
		}
	?>

	<p class="contact" style="padding-top:15px;"><label for="name">Art Instruction</label></p>
        <?php $results = $artinst;
		
		foreach($results as $result)
		{
			echo '<input type="radio" name="artinst" id="artinst" value="'.$result['id'].'" '.set_radio('artinst',$result['id']).' onClick="run1(this.value);" required="required" style="width:5%;"><label>'.$result['name'].'</label>';
     		echo '&nbsp';
		}
		?>
	
	<p class="contact" style="padding-top:15px; padding-bottom: 10px;"><label for="name">CSR Instruction</label></p>
		<textarea name="instruction" rows="2" cols="50" ><?php echo set_value('instruction');?></textarea>
	 
	<div style="font-weight: bold; color:#F00;">Frontline Immediate&nbsp;<input type="checkbox" name="priority" id="priority" value="1"<?php echo set_checkbox('priority', '1');?> style=" padding:0; margin-left: -200px; margin-top: -10px;" /></div>
	 <div id="ad-form-sr-custom">
		Select Help Desk:&nbsp;
        	<select id="help_desk" name="help_desk">
            <option value="">Select</option>
        	<?php
			$types = $this->db->get('help_desk')->result_array();
				foreach($types as $type)
				{
					echo '<option value="'.$type['id'].'" '.set_select('help_desk',$type['id']).'>'.$type['name'].'</option>';	
				}
			?>
            </select>
	 </div>
	 <p class="contact">&nbsp;</p>
		  
	</div>
	
	<div id="ad-form-s3">
	<p class="contact"><label for="name">Attachments </label></p>
		<?php if(isset($order) && $order[0]['file_path']!='none'){
			
				$this->load->helper('directory');
				$map = directory_map($order[0]['file_path'].'/');
				if($map){ foreach($map as $row){
		?>
	<a href="<?php echo $order[0]['file_path'].'/'.$row;?>" target="_blank" style="cursor:pointer; text-decoration: none;"><?php echo $row; ?></a>
		<br/>
		<?php  } } } ?>
	</div>

   <div id="ad-form-s4">  
		<input value="<?php echo set_value('publication');?><?php if(isset($order))echo $order[0]['publication_id'];?>" id="publication" name="publication" autocomplete="off" readonly style="visibility:hidden" />
        <input class="buttom" type="submit" name="submit" value="SUBMIT" style="width:20%" />
       <a href= "<?php echo base_url().index_page().'csr/home/cshift/'.$hd;?>"><input class="buttom" id="button" type="button" name="button" value="Reset" style="width:20%"></a>
   </div>
  
</form>
</div>
<div id="Back-btn"><a href="<?php echo base_url().index_page().'csr/home/';?>">Back</a></div>

<!-- Question -->
<div id="form"><div style="font-weight: bold; color:#F00;" align='center'>Question Tab</div>
<?php if(isset($question)){ 
		foreach($question as $q){ ?>
		
<div class="form">
<div id="ad-form">
      <div id="ad-form-s">
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









