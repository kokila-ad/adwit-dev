<?php $this->load->view("lite/head.php"); ?>
<?php $this->load->view("lite/header.php"); ?>

<div id="main">   
<section>
    <div class="container">

        <div class="padding-vertical-50">
			<!--<div class="row">
				<div class="col-md-4 col-md-offset-8">
					<div class="search-form margin-bottom-10">
						<input type="search" placeholder="Search order..." class="search-field">
						<input type="submit" value="Search" class="search-submit btn-xs padding-5">
					</div>
				</div>
			</div>-->
			
            <div class="row">
				<div class="col-md-4 col-xs-12">
		            <div class="portfolio-content">
                        <p class="xlarge">My Credits</p>
                        <ul class="portfolio-list">
                            <li>
                                <span class="large">Total Credit Balance</span>
								 <span class="value">
								<?php echo $balance_credits; ?>
								</span>
                            </li>

                           <!-- <li>
                                <span class="large">Free Credit Balance</span>
                                <span class="value">
								<?php if(isset($free_credit_details[0]['credits'])){ echo $free_credit_details[0]['credits']; }else{ echo '0'; } ?>
								</span>
                            </li>-->
						
                            <li>
                                <span class="large">Credit History</span>
                                <span class="value">
								<a class="btn btn-block btn-xs padding-5 btn-grey" href="<?php echo base_url().index_page().'lite/home/mycredits_history'; ?>">View</a>
								</span>
                            </li>
							<!--
							<li>
                                <span class="large">Paid Credit Balance</span>
                                <span class="value">
								<?php if(isset($paid_credit_details[0]['credits'])){ echo $paid_credit_details[0]['credits']; }else{ echo '0'; } ?>
								</span>
                            </li>
						
                            <li>
                                <span class="large">Paid Credit Expiry</span>
                                <span class="value">
								<?php if(isset($paid_credit_details[0]['expiry'])){ echo $paid_credit_details[0]['expiry']; }else{ echo '0'; } ?>
								</span>
                            </li>-->
                        </ul>
                    </div> 
				</div>
				
				<div class="col-md-4 col-xs-12">
					<p class="xlarge">Refer a Friend</p>
					<form method="post" action="<?php echo base_url().index_page().'lite/home/invite_friends'; ?>">
						<div class="padding-horizontal-15 padding-vertical-20 border row  margin-0">
							<div class="col-xs-12 padding-0">
								<input type="email" name="email" class="padding-5 form-control" placeholder="Type email address" required>
							</div>
							<div class="col-xs-12 padding-0 text-right">
								<button class="btn btn-dark btn-sm margin-top-25" type="submit" name="invite">Submit</button>   
							</div>
						</div>
					</form>
				</div>
						
				<div class="col-md-4 col-xs-12 margin-top-35">
					<div class="search-form margin-bottom-15">
					<form method="post" action="<?php echo base_url().index_page().'lite/home/order_search';?>"> 
						<input type="text" name="input" class="search-field" placeholder="Order Number..." required style="height: 42px;">
						<input type="submit" name="search" value="Search" class="search-submit search-submit btn btn-dark btn-sm">
					</form>
					</div>
					
					<a href="<?php echo base_url().index_page().'lite/home/buycredit'; ?>">
						<button type="button" class="form-control btn btn-blue margin-bottom-10 ">
							<span>Buy More Credit</span>
						</button>
					</a>
			
					<!--<a href="<?php echo base_url().index_page().'lite/home/invoice'; ?>">
						<button type="button" class="form-control btn  btn-blue  margin-bottom-15 ">
							<span>View Invoice</span>
						</button>
					</a>-->
			
					<a href="<?php echo base_url().index_page().'lite/home/order'; ?>">
						<button type="button" class="form-control btn btn-blue">
							<span>Place Order</span>
						</button>
					</a>
				</div>
			</div>
        </div>

    </div><!-- /.container -->
</section><!-- /section -->
</div>	
			
<?php $this->load->view("lite/footer.php"); ?>
 <?php $this->load->view("lite/foot.php"); ?>
