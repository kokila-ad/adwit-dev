<?php $this->load->view('professional_edition/header'); ?>
 

<div id="wrapper" class="main-wrapper ">
 
  
<div id="main">
<p style="text-align:center;color:red;font-size:18px;"><?php echo $this->session->flashdata('message'); ?></p>
<section>
    <div class="container margin-vertical-80">  
		<div class="row">  		 
			<div class="col-md-4 col-md-offset-4 col-xs-12 padding-left-0 ">  				
				<form method="POST" >
					<div class="text-center margin-bottom-15">
						<span class="xlarge">Assign a designer</span>
					</div>
					<input type="text" name="code" class="form-control margin-bottom-10" placeholder="Enter Graphic Designer Code" required>
					<div class="form-button text-right">
						<button class="btn btn-sm btn-blue">Submit</button>
					</div>
				</form>						
			</div> 	
		</div>	 
	 </div>
</section>

</div>
 </div>
<?php $this->load->view('professional_edition/footer'); ?>