<?php
	$this->load->view("art-director/header");
?>
<style>
#left-help {
	clear: both;
	float: left;
	margin-left: 3%;
	width: 45.8007%;
	display: block;
}
#right-help {
	clear: none;
	float: left;
	margin-left: 0.3984%;
	width: 49.8007%;
	display: block;
}
#slug-error input{
	background: #FFF;
	padding: 6px 10px;
	color: #e74c3c;
	border: 2px solid #e74c3c;
	border-radius: 5px;
}
</style>
<div id="Middle-Div">
<div id="left-help">
<div class="form">
<div id="ad-form">
      
      <div id="ad-form-p">Adwit Admin Support</div>
	   <div id="ad-form-s">
      <form id="contactform1" name="contactform1" action="<?php echo base_url().index_page().'art-director/home/admin_support';?>"  method="post"> 
	  
		<div id="ad-form-s-l">
		<p class="contact"><label for="name">DEPARTMENT </label></p>
        <select  id="department" name="department" >
			<option value="">Select</option>
			<option value="finance">FINANCE</option>
			<option value="hr">HR</option> 
			<option value="others">OTHERS</option>
		</select>
		</div>
		<div id="ad-form-s5b">&nbsp;</div>
		<div id="ad-form-s3">
		<p class="contact"><label for="name">Issue / Problem Description *</label></p>
        <textarea id="description" name="description"></textarea>
		</div>
		<div id="ad-form-s4">        
        <input class="buttom" type="submit" value="Submit" />
        </div>
		
	  </form>
</div>
<div id="slug-error">
		<?php if(isset($as_status)) echo "<p>".  $as_status ."</p>";	?>
		</div>
</div>
</div>
</div>
<div id="right-help">
<div class="form">
<div id="ad-form">
      
      <div id="ad-form-p">Adwit IT Trouble Ticket</div>
	   <div id="ad-form-s">
      <form id="contactform2" name="contactform2" action="<?php echo base_url().index_page().'art-director/home/trouble_ticket';?>" method="post"> 
	   <div id="ad-form-s-l">
        <p class="contact"><label for="name">Computer Name? (ex. iMac2) *</label></p>
		<input type="text" id="cname" name="cname" />
		</div>
		<div id="ad-form-s-r">
		<p class="contact"><label for="name">What area of IT is your problem related to? *</label></p>
        <select  id="IT_problem" name="IT_problem" >
		<option value="">Select</option>
          <?php
					$results = $this->db->get('IT_problem')->result_array();
					foreach($results as $result)
					{
						echo '<option value="'.$result['id'].'">'.$result['name'].'</option>';	
					}
				?>
		</select>
		</div>
		<div id="ad-form-s5b">&nbsp;</div>
		<div id="ad-form-s3">
		<p class="contact"><label for="name">Issue / Problem Description *</label></p>
        <textarea id="description" name="description"></textarea>
		</div>
		<div id="ad-form-s4">        
        <input class="buttom" type="submit" value="Submit" />
        </div>
		
	  </form>
</div>
<div id="slug-error">
		<?php if(isset($tt_status)) echo "<p>".  $tt_status ."</p>";	?>
		</div>
</div>
</div>
</div>
  </div>
<?php
	$this->load->view("art-director/footer");
?>
