<?php $this->load->view("lite/head.php"); ?>
<?php $this->load->view("lite/header.php"); ?>


		<style>
		.dropbtn {
			background-color: #4CAF50;
			color: white;
			padding: 16px;
			font-size: 16px;
			border: none;
			cursor: pointer;
		}

		.dropdown {
			position: relative;
			display: inline-block;
		}

		.dropdown-content {
			display: none;
			left: -40px;
			z-index: 999;
			position: absolute;
			background-color: #f9f9f9;
			min-width: 160px;
			box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
		}

		.dropdown-content a {
			color: black;
			padding: 8px 16px;
			text-decoration: none;
			display: block;
		}

		.dropdown-content a:hover {background-color: #f1f1f1}

		.dropdown:hover .dropdown-content {
			display: block;
		}

		.dropdown:hover .dropbtn {
			background-color: #3e8e41;
		}
		</style>

   
<section>
	<div class="container center margin-top-30">                        
		<p class="xlarge">Place New Order</p>  
	</div><!-- /.container -->
</section><!-- /section -->
	
<section>
    <div class="container margin-vertical-20">  
	
	   <div class="row">
	  
	   <form role="form" method="post" enctype="multipart/form-data" >
		 <div class="col-md-6 col-sm-6 col-xs-12 margin-bottom-10"> 
		    <p class="large margin-bottom-5">Unique Job Name/Number <span class="text-red">*</span> <small class="text-grey">(only alphanumeric characters allowed)</small></p>
			  <input type="text" pattern="[a-zA-Z0-9 ]{1,50}" class="form-control" id="job_name" name="job_name" value="<?php if(isset($order)){ echo $order['job_no']; } ?>" required >
			 
	        <div class="row margin-top-15">
	            <div class="col-md-6 col-sm-6 col-xs-6"> 
					<p class="large margin-bottom-5">Width <span class="text-red">*</span> <small class="text-grey">(in inches)</small></p>
					<input type="number" step="0.0001" min='1' class="form-control" id="width" name="width" value="<?php if(isset($order)){ echo $order['width']; } ?>" required >
					</div>
				<div class="col-md-6 col-sm-6 col-xs-6">
					<p class="large margin-bottom-5">Height <span class="text-red">*</span> <small class="text-grey">(in inches)</small></p>
					<input type="number" step="0.0001" min='1' class="form-control" id="height" name="height" value="<?php if(isset($order)){ echo $order['height']; }?>" required >
					</div>
			</div> 
			
		   <p class="large margin-bottom-5 margin-top-15">Full Color/B&W/Spot<span class="text-red"> *</span></p>
			<div class="row margin-bottom-20">
				<div class="col-sm-9">
					<div class="btn-group" data-toggle="buttons">
					<?php 
						$result = $color_preference;
						foreach($result as $row){
					?>
					<label class="btn btn-default margin-right-15 margin-bottom-5 <?php if(isset($order) && $order['print_ad_type']== $row['id']){ echo 'active'; } ?>">
					<input type="radio" value="<?php echo $row['id'];?>" id="color_preference" name="color_preference" <?php if(isset($order) && $order['print_ad_type']== $row['id']){ echo 'checked';}?> required="required">
					<?php echo $row['name'];?>	
					</label>
					<?php } ?>
				    </div>
			    </div>
		   </div>
		   
		    <p class="large margin-bottom-5 margin-top-15 active">Date Needed<span class="text-red"> *</span> 				
				<div class="row">
					<div class="col-sm-12">
						<div class="btn-group" data-toggle="buttons">
							<?php 
								$result = $lite_credit_date;
								foreach($result as $row){
							?>
							<label class="btn btn-default margin-right-15 margin-bottom-5 <?php if(isset($order) && $order['date_needed']== $row['id']){ echo 'active'; } ?>">
							<input type="radio" value="<?php echo $row['id'];?>" id="date_needed" name="date_needed" <?php if(isset($order) && $order['date_needed']== $row['id']){ echo 'checked';}?> required="required"><?php echo $row['name'];?>	
							</label>
							<?php } ?>
						</div>
				    </div>
				    </div>	 
		   </div>
		 
		   <div class="col-md-6 col-sm-6 col-xs-12 margin-bottom-15">
				<p class="large margin-bottom-5">Copy/Content<span class="text-red"> *</span> 	</p>
				<textarea rows ="5" rows="4" name="copy_content" class="form-control" required="required"><?php  if(isset($order)){ echo $order['copy_content_description']; } ?></textarea>

				 <p class="large margin-bottom-5 margin-top-15">Note & Instruction</p>
				 <textarea rows ="5" rows="4" name="instruction" class="form-control"><?php if(isset($order)){ echo $order['notes']; } ?></textarea>
				
				<div class="text-right margin-top-20">
					<button type="submit" name="submit" class="btn btn-primary btn-lg">  <span>Submit</span></button>
				</div>
			</div>
		</form>
		  	
		</div> 

		  </div>
	 </section>
</section>
    
<?php $this->load->view("lite/footer.php"); ?>
<?php $this->load->view("lite/foot.php"); ?>
 