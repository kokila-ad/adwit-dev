<?php $this->load->view("new_admin/header"); ?>

<style>
	.bg-credit { background-color:#f7f7f7; border: 1px solid #ccc;}
	.fa-plus , .xxlarge { font-size: 24px;}
</style>

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular.min.js"></script>
<script>
  $(document).ready(function(){
  $("#show").hide();
  
  $("#hide").click(function(){
  $("#show").toggle();     
   });
     
  });
</script>
	           
<section  data-ng-app=""  data-ng-init="cost=<?php if(isset($price_credit)) echo $price_credit; ?>">
<div class="container margin-top-20">
	<div class="row margin-top-20">
		<div class="col-md-6 col-xs-12 margin-bottom-10">            
			<?php if(isset($lite_free_credits )){ ?>
			  <div class="row margin-0 padding-15 bg-credit" >
				 <div class="col-md-9 col-xs-9 padding-0"> 
					 <p class="xlarge padding-vertical-20 padding-horizontal-5 margin-0">Free Credit <small>per week</small></p>
				 </div>
				 <div class="col-md-2 col-xs-2"> 
					 <p class="xlarge text-right"><?php echo $lite_free_credits[0]['credits']; ?></p>    
				 </div>
				 <div class="col-md-1 col-xs-1 margin-top-40 padding-0 text-right"> 
					<a class="white" data-toggle="collapse" data-target="#demo2">
						<i class="glyphicon glyphicon-pencil small cursor-pointer"></i>
					</a>      
				 </div>
			  </div>
			  <form role="form" method="post" action="<?php echo base_url().index_page()."new_admin/home/lite_credit_update";?>">  
				 <div id="demo2" class="collapse padding-10 border-theme center row margin-0">
				 <div class="col-xs-9 padding-0">
				  	<input type="number" min="0" name="credits" value="<?php echo $lite_free_credits[0]['credits']; ?>" class="padding-5 form-control" placeholder="Credits..." autocomplete="off">
				 </div>
				 <div class="col-xs-3 padding-0">
					<input type="text" name= "id" value="<?php echo $lite_free_credits[0]['id']; ?>" style="display:none;"/>
					<button type="submit" name="freecredits_update" class="btn btn-dark btn-block"><span>Submit</span></button>
				 </div>
				 </div>
			 </form>	
			<?php } ?>
		</div>
					
		<div class="col-md-6 col-xs-12">            
		<?php if(isset($lite_price_per_credit)){ ?>
			<div class="row margin-0 padding-15 bg-credit" >
				<div class="col-md-9 col-xs-9 padding-0"> 
					<p class="xlarge padding-vertical-20 padding-horizontal-5 margin-0">Price Per Credit</p>
				</div>
				<div class="col-md-2 col-xs-2"> 
					<p class="xlarge text-right">$<?php echo $lite_price_per_credit[0]['price']; ?></p>     
				</div>
				<div class="col-md-1 col-xs-1 margin-top-40 padding-0 text-right"> 
					<a class="white" data-toggle="collapse" data-target="#demo3">
						<i class="glyphicon glyphicon-pencil small cursor-pointer"></i>
					</a>      
				</div>
			</div>
			<form role="form" method="post" action="<?php echo base_url().index_page()."new_admin/home/lite_credit_update";?>">
				<div id="demo3" class="collapse padding-10 border-theme center row  margin-0">
				<div class="col-xs-9 padding-0">
					<input type="number" step='0.01' min="0" name= "price" class="padding-5 form-control" placeholder="Price..." autocomplete="off">
				</div>
				<div class="col-xs-3 padding-0">
					<input type="text" name="table" value="lite_price_per_credit" style="display:none;"/>
					<input type="text" name= "id" value="<?php echo $lite_price_per_credit[0]['id']; ?>" style="display:none;"/>
					<button class="btn btn-dark btn-block" type="submit" name="price_update">Submit</button>   
				</div>
				</div>
			</form> 
		<?php } ?>	  
	    </div>             
	</div>
					  
	<!-- Form Calculation -->
	
	<div class="row margin-top-10">
		<div class="col-md-6 col-xs-12  margin-bottom-10">            
			<div>
			<div class="row margin-0 padding-15 bg-credit"  >
				<div class="col-md-9 col-xs-12 padding-0"> 
					<p class="xlarge padding-vertical-20 padding-horizontal-5 margin-0">Form Calculation</p>
				</div>  
			</div>
			
			<div>
			<!-- Start Per Sq  inch-->
			  <div class="row margin-top-10">
					<div class="col-md-12 col-xs-12">            
						<div>
							<?php if(isset($lite_credit_sqinch)){ ?>
							<div class="row margin-0 padding-0 bg-credit">
								<div class="col-md-12 padding-10 large"> 
									 <span class="padding-vertical-10 padding-horizontal-5 margin-0">Per Sq.Inch</span>
									 <span class="pull-right padding-right-10">
									   <i class="pull-right padding-left-10">
										<a class="white" data-toggle="collapse" data-target="#trial">
											<i class="glyphicon glyphicon-pencil small cursor-pointer"></i>
										</a>  
									 </i>
									 </span>  
								</div>
							</div>
				<div id="trial" class="collapse  padding-vertical-5 margin-top-5">
					<?php $i=0; foreach($lite_credit_sqinch as $per_sqinch){ $i++;?>
						<div class="row margin-bottom-5">
							<div class="col-md-1 col-xs-1"></div>
							<div class="col-md-11 col-xs-11">            
								<div>
									<form role="form" method="post" action="<?php echo base_url().index_page()."new_admin/home/lite_credit_update";?>">
										<div class="row margin-0 padding-0  bg-credit" >
											<div class="col-md-12 padding-10 large"> 
												 <span class="padding-vertical-10 padding-horizontal-5 margin-0"><?php if($per_sqinch['max_inch']=='0'){ echo $per_sqinch['min_inch'].'&#8243;- above'; }else{ echo $per_sqinch['min_inch'].'&#8243; - '.$per_sqinch['max_inch'].'&#8243'; } ?></span>
												 <span class="pull-right padding-right-10"><?php echo $per_sqinch['credits']; ?>  credits
												   <i class="pull-right padding-left-10">
													<a class="white" data-toggle="collapse" data-target="#trial<?php echo $i; ?>">
														<i class="glyphicon glyphicon-pencil small cursor-pointer"></i>
													</a>  
												   </i>
												 </span>  
											</div>
										</div>
										
									   <div id="trial<?php echo $i; ?>" class="collapse border-theme padding-10 center row  margin-0">
									   <div class="col-xs-4 margin-bottom-10">
											<input type="text" min="0" name="min_credits" min='0' autocomplete="off" class="padding-5 form-control" placeholder="Min Inch...">
									   </div>									   
									   <div class="col-xs-4 margin-bottom-10">
											<input type="text" min="0" name="max_credits" min='0' autocomplete="off" class="padding-5 form-control" placeholder="Max Inch...">
									   </div>									   
									   <div class="col-xs-4">
											<input type="text" min="0" name="credits" min='0' autocomplete="off" class="padding-5 form-control" placeholder="Credits...">
									   </div>
									   <div class="col-xs-12 text-right">
												<input type="text" name="id" value="<?php echo $per_sqinch['id']; ?>" style="display:none;"/>
												<input type="text" name="table" value="lite_credit_sqinch" style="display:none;"/>
											<button class="btn btn-dark" type="submit" name="credit_update">Submit</button>   
									   </div>    
									  </div>
									</form>	
								</div>
							</div> 
						</div>
					<?php } ?>
				</div>
						<?php } ?>
					</div>
				</div> 
			</div>
			<!--- End : Per SqInch --->						

			<!--- Start : Color Preference --->	  
			<div class="row margin-top-10">
				<div class="col-md-12 col-xs-12">            
					<div>
					<?php if(isset($lite_color_preference)){ ?>
					<div class="row margin-0 padding-0 bg-credit">
						<div class="col-md-12 padding-10 large"> 
							 <span class="padding-vertical-10 padding-horizontal-5 margin-0">Color Preference</span>
							 <span class="pull-right padding-right-10">
								 <i class="pull-right padding-left-10">
									<a class="white" data-toggle="collapse" data-target="#color">
										<i class="glyphicon glyphicon-pencil small cursor-pointer"></i>
									</a>  
								 </i>
							 </span>  
						</div>
					</div>
			<div id="color" class="collapse  padding-vertical-5 margin-top-5">
			<?php $i=0; foreach($lite_color_preference as $color){ $i++;?>
			
			<!--- Start : B&W --->	  
			<div class="row margin-bottom-5">
				<div class="col-md-1 col-xs-1"></div>
				<div class="col-md-11 col-xs-11">            
					<div>
						<form role="form" method="post" action="<?php echo base_url().index_page()."new_admin/home/lite_credit_update";?>">
							<div class="row margin-0 padding-0  bg-credit" >
								<div class="col-md-12 padding-10 large"> 
									<span class="padding-vertical-10 padding-horizontal-5 margin-0"><?php echo $color['name']; ?></span>
									<span class="pull-right padding-right-10"><?php echo $color['credits']; ?>  credits
									<i class="pull-right padding-left-10">
										<a class="white" data-toggle="collapse" data-target="#cp<?php echo $i; ?>">
											<i class="glyphicon glyphicon-pencil small cursor-pointer"></i>
										</a>  
									</i>
									</span>  
								</div>
							</div>
						
						  <div id="cp<?php echo $i; ?>" class="collapse border-theme padding-10 center row  margin-0">
							<div class="col-xs-9 padding-0">
								<input type="number" name="credits" min='0' autocomplete="off" class="padding-5 form-control" placeholder="Credits...">
							</div>
							<div class="col-xs-3 padding-0">
									<input type="text" name="id" value="<?php echo $color['id']; ?>" style="display:none;"/>
									<input type="text" name="table" value="lite_color_preference" style="display:none;"/>
								<button class="btn btn-dark btn-block" type="submit" name="credit_update">Submit</button>   
							</div>    
						  </div>
						</form>	
					</div>
				</div> 
		    </div>
			<!--- End : B&W --->
			<?php } ?>
			</div>
			<?php } ?>
					</div>
				</div> 
		    </div>
			<!--- End : Color Preference --->	  	
			
			<!--- Start : No of Days --->		
		    <div class="row margin-top-10">
			<div class="col-md-12 col-xs-12">            
			<div>
				<?php if(isset($lite_credit_date)){ ?>
					<div class="row margin-0 padding-0 bg-credit" >
						<div class="col-md-12 padding-10 large"> 
							 <span class="padding-vertical-10 padding-horizontal-5 margin-0">No of Days</span>
							 <span class="pull-right padding-right-10">
							   <i class="pull-right padding-left-10">
								<a class="white" data-toggle="collapse" data-target="#days">
									<i class="glyphicon glyphicon-pencil small cursor-pointer"></i>
								</a>  
							 </i>
							 </span>  
						</div>
					</div>
				
					<div id="days" class="collapse padding-vertical-5 margin-top-5">
					<?php $i=0; foreach($lite_credit_date as $credit_day){ $i++;?>
						<!--- Start : One --->	  
						  <div class="row margin-bottom-5">
							<div class="col-md-1 col-xs-1"></div>
							<div class="col-md-11 col-xs-11">            
								<div>
									<div class="row margin-0 padding-0 " >
										<div class="col-md-12 bg-credit padding-10 large"> 
											 <span class="padding-vertical-10 padding-horizontal-5 margin-0"><?php echo $credit_day['num_days']; ?> Day</span>
											 <span class="pull-right padding-right-10"><?php echo $credit_day['credits']; ?>
											   <i class="pull-right padding-left-10">
												<a class="white" data-toggle="collapse" data-target="#one<?php echo $i; ?>">
													<i class="glyphicon glyphicon-pencil small cursor-pointer"></i>
												</a>  
											 </i>
											 </span>  
										</div>
									</div>
									<form role="form" method="post" action="<?php echo base_url().index_page()."new_admin/home/lite_credit_update";?>">
									  <div id="one<?php echo $i; ?>" class="collapse border-theme padding-10 center row  margin-0">
										<div class="col-xs-9 padding-0">
											<input type="number" min="0" name="credits" class="padding-5 form-control" placeholder="Credits..." autocomplete="off">
										</div>
										<div class="col-xs-3 padding-0">
												<input type="text" name= "id" value="<?php echo $credit_day['id']; ?>" style="display:none;"/>
												<input type="text" name="table" value="lite_credit_date" style="display:none;"/>
											<button name="credit_update" class="btn btn-dark btn-block" type="submit">Submit</button>   
										</div>    
									  </div>
									</form>   
								</div>
							</div> 
						  </div>
					<!--- End : One --->	
					<?php } ?>
					  </div>
					<?php } ?>
				</div>
			</div> 
		  </div>
			<!--- End : No of Days --->	  	
			
				  </div>
			</div>
		</div>          
		<div class="col-md-3 col-xs-12">
			<div class="row center">
				<div class="col-md-12 col-xs-12 margin-bottom-10">
					<div class="bg-credit padding-10 align-center cursor-pointer padding-vertical-20" data-toggle="collapse" data-target="#new">
						<a href ="<?php echo base_url().index_page()."new_admin/home/create_package";?>"><p class="xxlarge padding-bottom-5 margin-0"><i class="fa fa-plus"></i></p></a>
						<p class="margin-0">Create New Package</p>
					</div>
				</div>
			</div>	
		</div>
	
	<div class="col-md-3 col-sm-12 col-xs-12 count">
		<div class="bg-credit padding-10 align-center cursor-pointer padding-vertical-20"  data-target="#new">
			<a href ="<?php echo base_url().index_page()."new_admin/home/lite_adrep";?>"><p class="xxlarge padding-bottom-5 margin-0"> <?php if(isset($adreps)){echo count($adreps);}?></p></a>
			<p class="margin-0">Lite Adreps</p>
		</div>
	</div>
	
	
    </div><!-- End Form Calculation -->
</section>


	
<?php $this->load->view("new_admin/footer"); ?>
<?php $this->load->view("new_admin/datatable")?>


