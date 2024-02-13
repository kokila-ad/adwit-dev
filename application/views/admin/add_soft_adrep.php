<?php
	$this->load->view("admin/header");
?>


<div id="Middle-Div">
<?php echo '<h5 style="color:#900;">'.$this->session->flashdata('message').'</h5>'; ?>
 <form accept-charset="utf-8" method="post" >
 <?php echo validation_errors(); ?>
 <div class="form">
<div id="ad-form">
      <div id="ad-form-h"> Add Adrep </div>
      <div id="ad-form-p"> Adreps </div>
      <div id="ad-form-s">
      <form id="contactform">      
        <div id="ad-form-s-l">
         
        <p class="contact"><label for="name">First Name :</label> <span class="mandatory">*</span>
        <input type="text" value="<?php echo set_value('first_name'); ?>" id="first_name" name="first_name" autocomplete="off"/>
        </p>
		<p class="contact"><label for="name">Last Name :<span class="mandatory">*</span></label>
        <input type="text" value="<?php echo set_value('last_name'); ?>" id="last_name" name="last_name" autocomplete="off"/>
		</p>
		<p class="contact"><label for="name">Email Id :<span class="mandatory">*</span></label>
        <input type="text" value="<?php echo set_value('email_id'); ?>" id="email_id" name="email_id"  autocomplete="off"/>
        </p>
		
		<p class="contact"><label for="name">Publication : <span class="mandatory">*</span></label>
        <select class="select-style gender" id="publication_id" name="publication_id">
          <option value="">Select</option>
          <?php foreach($soft_publications as $row){ echo '<option value="'.$row['id'].'" '.set_select('publication_id', $row['id']).' >'.$row['name'].'</option>'; } ?>
        </select>
        </p>
		<p class="contact"><label for="name">User Name : <span class="mandatory">*</span></label>
        <input type="text" value="<?php echo set_value('username'); ?>" id="username" name="username" />
        </p>
       <p class="contact"><label for="name">Password : <span class="mandatory">*</span></label>
        <input value="<?php echo set_value('password'); ?>" name="password" type="password" id="password" />
        </p>
		<p class="contact"><label for="name">Phone1 Number :  </label>
		<input value="<?php echo set_value('phone_1'); ?>" name="phone_1" type="text" id="phone_1" />
        </p>
		<p class="contact"><label for="name">Phone2 Number :  </label>
        <input value="<?php echo set_value('phone_2'); ?>" name="phone_2" type="text" id="phone_2" />
		</p>
		<p class="contact"><label for="name">Mobile Number :  </label>
        <input name="mobile_no" value="<?php echo set_value('mobile_no'); ?>" type="text" id="mobile_no" autocomplete="off" />
		</p>
        
	</div>

      <div id="ad-form-s4">        
        <input class="buttom" type="submit" value="SUBMIT" style="width:20%"/>
		<a href= "<?php echo base_url().index_page().'admin/home/soft_adrep';?>"><input class="buttom" id="button" type="button" name="button" value="CANCEL" style="width:20%"></a>
       </div>
     </form>
   </div>
  </div>
</div>

 </form>
 <div id="Back-btn"><a href="<?php echo base_url().index_page().'admin/home/home/';?>">Back</a></div>
</div>



<?php
	$this->load->view("admin/footer");
?>