<?php
       $this->load->view("india/header");
?>
   <div id="container">
<div id="content">
   <div class="form">
           <h1>Welcome <?php echo $this->session->userdata('india');?></h1>
   </div>
</div><!-- #content-->
   </div>
   </section>
                       
<?php
       $this->load->view("india/footer");
?>