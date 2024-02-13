<?php
	$this->load->view("designer/header");
?>
<?php
$designer = $this->db->get_where('designers',array('id' => $this->session->userdata('dId')))->result_array();
?>

<div class="form">
<div id="ad-form">
      
      <div id="ad-form-p">Adwit IT Trouble Ticket</div>
	   <div id="ad-form-s">
      <form id="contactform" name="contactform" method="post"> 
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
</div>
</div>
<?php
	$this->load->view("designer/footer");
?>
