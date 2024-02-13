<?php $this->load->view('professional_edition/header'); ?>


<div id="main">

<section>
	
    <div class="container margin-top-80"> 
		<p style="text-align:center;color:green;font-size:18px;"><?php echo $this->session->flashdata('message'); ?></p>
		  <?php $this->load->view('professional_edition/order_search'); ?>
	 </div>
</section>

</div>


      

<?php $this->load->view('professional_edition/footer'); ?>