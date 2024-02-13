<?php
	$this->load->view("client/header1");
?>


  <div id="Middle-Div">
  <div id="Select_Form">
    </div>
    <div id="form">
        	<?php if(isset($form)):?>
            	<form id="order_form" name="order_form" method="post">
                	<?php if(isset($num_errors) && $num_errors!=0):?>
                   	 	<h3 style="color:#900;">Please check for the errors below!</h3>
						<div class="errors_list">
                            <ul >
                                <?php echo validation_errors();?>
                            </ul>
                    	</div>
                     <?php endif;?>
                    <?php $this->load->view('client/print_web-new-ads01');?>
				</form>
			<?php endif;?>
        </div>
	<div id="Back-btn"><a href="<?php echo base_url().index_page().'client/home/home/';?>">Back</a></div>
  </div>


<?php
	$this->load->view("client/footer");
?>