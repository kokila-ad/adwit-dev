<?php
	$this->load->view("admin/header");
?>


<div id="Middle-Div">
<?php echo '<h5 style="color:#900;">'.$this->session->flashdata('message').'</h5>'; ?>
 <form accept-charset="utf-8" method="post" >
 <?php echo validation_errors(); ?>
 <div class="form">
<div id="ad-form">
      <div id="ad-form-h"> Add Publications </div>
      <div id="ad-form-p"> Publications </div>
      <div id="ad-form-s">
      <form id="contactform">      
        <div id="ad-form-s-l">
         
        <p class="contact"><label for="name">Business Group :</label> <span class="mandatory">*</span>
        <select class="select-style gender" id="business_group_id" name="business_group_id">
          <option value="">Select</option>
          <?php foreach($bg as $bg_row){ echo '<option value="'.$bg_row['id'].'" '.set_select('business_group_id', $bg_row['id']).' >'.$bg_row['name'].'</option>'; } ?>
        </select>
        </p>
		<p class="contact"><label for="name">Name :<span class="mandatory">*</span></label>
        <input type="text" value="<?php echo set_value('name'); ?>" id="name" name="name" autocomplete="off"/>
		</p>
		<p class="contact"><label for="name">Advertising Director Email Id :</label>
        <input type="text" value="<?php echo set_value('advertising_director_email_id'); ?>" id="advertising_director_email_id" name="advertising_director_email_id"  autocomplete="off"/>
        </p>
		<p class="contact"><label for="name">Design Team :</label>
        <select class="select-style gender" id="design_team_id" name="design_team_id">
          <option value="">Select</option>
          <?php foreach($dt as $dt_row){ echo '<option value="'.$dt_row['id'].'" '.set_select('design_team_id', $dt_row['id']).' >'.$dt_row['name'].'</option>'; } ?>
        </select>
        </p>
		<p class="contact"><label for="name">Team lead id : </label>
        <select class="select-style gender" id="team_lead_id" name="team_lead_id">
          <option value="">Select</option>
          <?php foreach($tl as $tl_row){ echo '<option value="'.$tl_row['id'].'" '.set_select('team_lead_id', $tl_row['id']).' >'.$tl_row['first_name'].'</option>'; } ?>
        </select>
        </p>
		<p class="contact"><label for="name">Spec ads : </label>
        <input type="text" value="<?php echo set_value('spec_ads'); ?>" id="spec_ads" name="spec_ads" />
        </p>
       <p class="contact"><label for="name">Sold ads : <span class="mandatory">*</span></label>
        <input value="<?php echo set_value('sold_ads'); ?>" name="sold_ads" type="text" id="sold_ads" />
        </p>
		<p class="contact"><label for="name">Slug type :  <span class="mandatory">*</span></label>
        <select class="select-style gender" id="slug_type" name="slug_type">
          <option value="">Select</option>
          <?php foreach($slug_type as $slug_type_row){ echo '<option value="'.$slug_type_row['id'].'" '.set_select('slug_type', $slug_type_row['id']).' >'.$slug_type_row['name'].'</option>'; } ?>
        </select>
        </p>
		<p class="contact"><label for="name">News id :  <span class="mandatory">*</span></label>
        <input name="news_id" value="<?php echo set_value('news_id'); ?>" type="text" id="news_id" autocomplete="off" />
		</p>
		<p class="contact"><label for="name">Initial : <span class="mandatory">*</span> </label>
        <input name="initial" value="<?php echo set_value('initial'); ?>" type="text" id="initial" autocomplete="off" />
		</p>
        <p class="contact"><label for="name">Help desk :  </label>
        <select class="select-style gender" id="help_desk" name="help_desk">
          <option value="">Select</option>
          <?php foreach($help_desk as $help_desk_row){ echo '<option value="'.$help_desk_row['id'].'" '.set_select('help_desk', $help_desk_row['id']).' >'.$help_desk_row['name'].'</option>'; } ?>
        </select>
        </p>
		<p class="contact"><label for="name">Ordering system :  </label>
        <select class="select-style gender" id="ordering_system" name="ordering_system">
          <option value="">Select</option>
          <?php foreach($ordering_system as $ordering_system_row){ echo '<option value="'.$ordering_system_row['id'].'" '.set_select('ordering_system', $ordering_system_row['id']).' >'.$ordering_system_row['name'].'</option>'; } ?>
        </select>
		</p>
		<p class="contact"><label for="name">Channel :  </label>
        <select class="select-style gender" id="channel" name="channel">
          <option value="">Select</option>
          <?php foreach($channel as $channel_row){ echo '<option value="'.$channel_row['id'].'" '.set_select('channel', $channel_row['id']).' >'.$channel_row['name'].'</option>'; } ?>
        </select>
		</p>
		<p class="contact"><label for="name">Time Zone : </label></p>
        <select class="select-style gender" id="time_zone_id" name="time_zone_id">
          <option value="">Select</option>
          <?php foreach($time_zone as $time_zone_row){ echo '<option value="'.$time_zone_row['id'].'" '.set_select('time_zone_id', $time_zone_row['id']).' >'.$time_zone_row['name'].'</option>'; } ?>
        </select>
		           
		<p class="contact"><label for="name">City :  </label>
        <input name="city" value="<?php echo set_value('city'); ?>" type="text" id="city" />
		</p>
	</div>

      <div id="ad-form-s4">        
        <input class="buttom" type="submit" value="SUBMIT" style="width:20%"/>
		<a href= "<?php echo base_url().index_page().'admin/home/soft_publication';?>"><input class="buttom" id="button" type="button" name="button" value="CANCEL" style="width:20%"></a>
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