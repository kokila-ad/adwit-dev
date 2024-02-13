<?php $this->load->view('marketing/header');?>

<section>
	<div class="container margin-vertical-20">
		<form method="post" name="order_form" id="order_form" class="margin-top-40">
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-12">
					<p class="margin-bottom-5">First Name <span class="text-red">*</span></p>
					<input type="text" name="first_name" class="form-control input-sm input-sm input-sm input-sm margin-bottom-15" title="" required>
				</div>	    
				<div class="col-md-6 col-sm-6 col-xs-12">
					<p class="margin-bottom-5">Last Name <span class="text-red">*</span></p>
					<input type="text" name="last_name" class="form-control input-sm input-sm input-sm input-sm margin-bottom-15" title="" required>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<p class="margin-bottom-5">Publication<span class="text-red">*</span> </p>
					<input type="text" name="publication"  class="form-control input-sm input-sm input-sm input-sm margin-bottom-15" title="" required>		   
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<p class="margin-bottom-5">Email Address <span class="text-red">*</span> </p>
					<input type="email" name="email_id"  class="form-control input-sm input-sm input-sm input-sm margin-bottom-15" title="" required>		   
				</div>
				<div class="col-xs-12 text-right margin-top-10">
					<button class="btn btn-sm btn-blue" type="submit">SIGN UP</button>
				</div>	
			</div>
		</form>
	</div>
</section>

 <section>
    <div class="text-center margin-vertical-20">  
		<p><?php echo $this->session->flashdata('message'); ?></p>					
	 </div>		 	
</section>
 

<?php $this->load->view('marketing/footer');?>