<?php $this->load->view("lite/head.php"); ?>
<?php $this->load->view("lite/header.php"); ?>
 
<div class="container margin-vertical-50 col-md-offset-4">         
    <?php if(isset($message)) echo '<p style="color:#FCA13F;">'.$message.'</p><br/>'; ?>    
<?php if(isset($pay_details['id'])) { 
		$price_per_credits = $this->db->get('lite_price_per_credit')->result_array();
		$price_per_credit = $price_per_credits[0]['price'];
?>		
		<div class="row margin-bottom-10 col-md-offset-1">
			<div class="col-md-6 col-xs-6"><p class="xlarge ">$<?php echo $pay_details['amount']; ?> for <?php echo $pay_details['credits']; ?> Credits</p>
				<p class="small ">Please enter your card details below</p>
			</div>
		</div>	
		<div class="row ng-scope">			
			<div class="col-md-5 margin-bottom-25">
			<form ng-app ng-init="price = <?php echo $pay_details['amount']; ?>" action="<?php echo base_url().index_page().'lite/home/stripePay/'.$pay_details['md5_id'];?>" method="post" class="form-horizontal align-center">
				<div class="border padding-15 ">
					
					<div class="margin-top-20" id="desig" style="display: block;">	
						<label class="col-md-5 " >Card Number</label>
						<input type="text" size="20" autocomplete="off" name="cardnumber"  />
					</div>
						
					<div class="margin-top-20" id="desig" style="display: block;">	
						<label class="col-md-5">Expiration </label>
						<input type="text" size="2" name="expirymonth" placeholder="MM" maxlength="2" />
						<span> / </span>
						<input type="text" size="4" name="expiryyear" placeholder="YYYY" maxlength="4" />
					</div>
					<div class="margin-top-20" id="desig" style="display: block;">	
						<div class="col-md-offset-5 margin-bottom-10">
							<button style="border-radius: 4px;" type="submit" name="btnsubmit" class="btn btn-primary"> Pay Now </button>
						</div>
					</div>
				</div>
			</form>
			</div>
		
		</div>
<?php } ?>
      </div>
			
<!-- /.container-fluid -->
<?php $this->load->view("lite/footer.php"); ?>
<?php $this->load->view("lite/foot.php"); ?>
	