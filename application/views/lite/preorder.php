<?php $this->load->view("lite/head.php"); ?>
<?php $this->load->view("lite/header.php"); ?>

<div id="main">
<?php if(isset($insufficient_bal)){ ?>
<section>
<?php if(isset($check_credits)){ $balance =  ($check_credits - $order_check['credits']); } ?>	
	<div class="container center padding-top-50 margin-bottom-100">                        
		<p>
		Current Credits: <strong><?php echo $check_credits; ?></strong> | 
		Required Credits: <strong class="text-red"><?php echo $order_check['credits']; ?></strong> 
		</p>
		
		<p class="margin-top-40">Insufficient Credit Balance.</p>
		
		<p>
			Please purchase credits to continue placing your order. 
			Don't worry, you will not lose any of your unsaved work.
		</p>
		<div class="row">
			
			<div class="col-md-4 col-md-offset-4">
				<a href="<?php echo base_url().index_page().'lite/home/buycredit'; ?>">
					<button class="btn btn-danger margin-bottom-20">Buy Credits</button>
				</a>	
			</div>		
			
		</div>	
	</div>
</section>

<?php }else{ ?>

<section>
<?php if(isset($check_credits)){ $balance =  ($check_credits - $order_check['credits']); } ?>	
	<div class="container center padding-top-50 margin-bottom-100">                        
		<p>Current Credits: <strong><?php echo $check_credits; ?></strong> | 
		Credits to have this ad designed: <strong class="text-red"><?php echo $order_check['credits']; ?></strong> |
		Your remaining credit balance: <strong><?php if(isset($check_credits)){echo $balance;} ?></strong></p>
		
		
		
<p class="margin-top-40">Would you like to proceed?</p>
		<div class="row">
			<form method="post">
				<div class="col-md-4 col-md-offset-4">
				<button class="btn btn-danger margin-bottom-20" type="submit" name="proceed" >Proceed and Attach Files</button>
					<div class="dropdown text-grey">								
						<span class="btn btn-grey padding-horizontal-40 btn-outline margin-top-10"  type="btn" name="" data-toggle="dropdown" id="view" aria-expanded="true">Cancel Order</span>
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
					</div>
					
				</div>		
			</form>	
		</div>	
	</div>
</section>
<?php } ?>
  </div><!-- /.container -->
</section><!-- /section -->
</div>	<!-- /main -->
			
<?php $this->load->view("lite/footer.php"); ?>
 <?php $this->load->view("lite/foot.php"); ?>
 
 
