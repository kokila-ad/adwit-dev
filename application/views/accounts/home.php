<?php
	$this->load->view("accounts/header");
?>


<div id="Middle-Div">
<?php
	$accounts_name=$this->db->get_where('accounts',array('id' => $this->session->userdata('actId')))->result_array()
	?>
    <div id="Middle-text">Welcome <?php echo $accounts_name[0]['first_name'];?></div>
  </div>

		
<?php
	$this->load->view("accounts/footer");
?>