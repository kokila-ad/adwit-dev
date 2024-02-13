<?php
       $this->load->view("client/header");
?>

  <div id="Middle-Div">
    <div id="Middle-text">Welcome <?php echo $this->session->userdata('client');?></div>
  </div>
                       
<?php
       $this->load->view("client/footer");
?>