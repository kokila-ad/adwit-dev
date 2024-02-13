<?php
	$this->load->view("hr/header");
?>


<div id="Middle-Div">
<?php
	$accounts_name=$this->db->get_where('hr',array('id' => $this->session->userdata('hrId')))->result_array()
	?>
    <div id="Middle-text">Welcome <?php echo $accounts_name[0]['first_name'];?></div>
  </div>

		
<?php
	$this->load->view("hr/footer");
?>