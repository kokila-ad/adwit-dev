<?php $this->load->view("lite/head.php"); ?>
<?php $this->load->view("lite/header.php"); ?>

<div id="main">

	
<section>
	<div class="container center padding-top-50 margin-bottom-100">                        
		<p class="xlarge">Credits Required</p>
		<p class="xxxlarge"><?php echo $order_check['credits']; ?> </p>  
     
		<div class="row">
			<form method="post">
				<div class="col-md-4 col-md-offset-4">
					<span class="dropdown text-grey">								
						<span class="btn btn-grey padding-horizontal-60"  type="btn" name="" data-toggle="dropdown" id="view" aria-expanded="true">Cancel</span>
						<div class="dropdown-menu file_li padding-10">  							 
							<p class="margin-bottom-5">Are you sure?</p>
							<div class="row margin-0">
								<div class="col-xs-6 padding-right-5 padding-left-0">
									<form method="post" action="http://www.adwitads444.time-capsule.in/index.php/lite/home/order_cancel/<?php echo $order_id; ?>">
										<button type="submit" name="decline" id="remove" class="btn btn-danger btn-xs padding-5 padding-horizontal-20 margin-right-5 btn-block">Yes</button>
									</form>
								</div>	
								<div class="col-xs-6 padding-left-5 padding-right-0">
									<button class="btn btn-blue btn-xs padding-5 padding-horizontal-20 btn-block">No</button>
								</div>
							</div>								
						</div>
					</span>
					<button class="btn btn-danger" type="submit" name="proceed" >Proceed To Attach File</button>
				</div>		
			</form>	
		</div>	
	</div>
</section>

  </div><!-- /.container -->
</section><!-- /section -->
</div>	<!-- /main -->
			
<?php $this->load->view("lite/footer.php"); ?>
 <?php $this->load->view("lite/foot.php"); ?>
 
 
