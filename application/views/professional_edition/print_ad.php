<?php $this->load->view('professional_edition/header');?>

<div id="main"> 
   <section>
      <div class="container margin-top-40 center">                        
		<p>Place New Order</p>  
           <a href="<?php echo base_url().index_page().'professional_edition/home/print_ad';?>" class="btn btn-sm btn-dark btn-outline btn-active margin-right-5">Print Ad</a>
           <a href="<?php echo base_url().index_page().'professional_edition/home/online_ad';?>" class="btn btn-sm btn-dark btn-outline">Online Ad</a>
      </div>
   </section>
	
   <section>
     <div class="container margin-top-40">   
	 <form method="post" name="order_form" id="order_form">
	  <div class="row">
	   <div class="col-md-6 col-sm-6 col-xs-12">
		   <p class="margin-bottom-5">Advertiser Name <span class="text-red">*</span></p>
	       <input type="text" name="advertiser_name" class="form-control input-sm margin-bottom-15" title="" required="">

		   <p class="margin-bottom-5">Unique Job Name / Number <span class="text-red">*</span> <small class="text-grey">(any alphanumeric of your choice)</small> </p>
	       <input type="text" name="job_no" pattern="[a-zA-Z0-9 ]{1,50}" class="form-control input-sm margin-bottom-15" title="" required="">
		   
		 <p class="margin-bottom-5">Copy, Content, Text<span class="text-red"> *</span></p>
		   <textarea rows="3" name="copy_content_description" class="form-control input-sm margin-bottom-15" required=""></textarea>	
		</div>
	    <div class="col-md-6 col-sm-6 col-xs-12">
			<div class="row margin-bottom-15">
	           <div class="col-md-6 col-sm-6 col-xs-6">
					 <p class="margin-bottom-5">Width <span class="text-red">*</span> <small class="text-grey">(in inches)</small></p>
					 <input type="number" name="width" pattern="[1-9]{1,2}" max="99" min="1" step="0.0001" class="form-control input-sm" required=""></div>
			   <div class="col-md-6 col-sm-6 col-xs-6"> 
					<p class="margin-bottom-5">Height <span class="text-red">*</span> <small class="text-grey">(in inches)</small></p>
					<input type="number" name="height" pattern="[1-9]{1,2}" max="99" min="1"  step="0.0001" class="form-control input-sm" required=""></div>
			</div> 
			
			<p class="margin-bottom-5">Full Color / B&W / Spot<span class="text-red"> * </span><small class="text-grey">(select one)</small></p>
		    <div class="row margin-bottom-5">
			   <div class="col-sm-12">
				<div class="btn-group" data-toggle="buttons">
					<label class="btn btn-sm btn-default margin-right-10 margin-bottom-10">
						<input type="radio" name="print_ad_type" value="1" required="" > Full Color
					</label> 
					<label class="btn btn-sm btn-default margin-right-10 margin-bottom-10">
						<input type="radio" name="print_ad_type" value="2" required=""> B&amp;W
					</label> 
					<label class="btn btn-sm btn-default margin-right-10 margin-bottom-10">
						<input type="radio" name="print_ad_type" value="3" required=""> Spot
					</label>  
				  </div>
				</div>   
		   </div>
		  
		   <div id="spot_color" class="hidden">
			  <p class="margin-bottom-5">Spot Color <span class="text-red">*</span></p>
			  <input type="text" name="spot_color" class="form-control input-sm margin-bottom-15" title="">
		   </div>
		   
		   <p class="margin-bottom-5"> Notes &amp; Instructions</p>
		   <textarea rows="3" name="notes" class="form-control input-sm margin-bottom-15"></textarea>	
		</div> 
	  </div>
	
		<div class="row margin-bottom-5">
			<div class="col-md-12 col-sm-12 col-xs-12 text-grey">   
			<label><input id="showoptional" type="checkbox" class="margin-right-5">Check to view optional fields</label>
			</div>
		</div>	
	
		<div class="row" id="optional">
			<div class="col-md-6 col-sm-6 col-xs-12">  
				<p class="margin-bottom-5">Date needed</p>	 
				<div class="input-group date date-picker margin-bottom-15" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
					<input id="date_needed" type="text" class="form-control input-sm" name="date_needed">
					<span class="input-group-btn">
					<button class="btn btn-sm btn-dark" type="button"><i class="fa fa-calendar"></i></button>
					</span>
				</div>
				
				<p class="margin-bottom-5">Publish Date</p>	 
				<div class="input-group date date-picker margin-bottom-15" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
					<input id="date_needed" type="text" class="form-control input-sm" name="publish_date">
					<span class="input-group-btn">
					<button class="btn btn-sm btn-dark" type="button"><i class="fa fa-calendar"></i></button>
					</span>
				</div>
				
			   <p class="margin-bottom-5">Publication Name</p>
			   <input type="text" name="publication_name" class="form-control input-sm  margin-bottom-15" title="">
			   
			   <p class="margin-bottom-5">Font Preferences </p>
			   <input type="text" name="font_preferences" class="form-control input-sm margin-bottom-15" title="">
			</div>
			
			<div class="col-md-6 col-sm-6 col-xs-12">  
			  <p class="margin-bottom-5">Color Preferences</p>
			  <input type="text" name="color_preferences" class="form-control input-sm margin-bottom-15" title="">
			   
			<p class="margin-bottom-5">Job Instructions <small class="text-grey">(select one)</small></p>
				<div class="row">
				   <div class="col-sm-12">
					 <div class="btn-group" data-toggle="buttons">
						<label class="btn btn-sm btn-default margin-right-10 margin-bottom-10 hidden">
							<input type="radio" name="job_instruction" value="0" checked="checked"> Default
						</label> 	
						<label class="btn btn-sm btn-default margin-right-10 margin-bottom-10">
							<input type="radio" name="job_instruction" value="1"> Follow Instructions Carefully
						</label> 
						<label class="btn btn-sm btn-default margin-right-10 margin-bottom-10">
							<input type="radio" name="job_instruction" value="2"> Be Creative
						</label> 
						<label class="btn btn-sm btn-default margin-right-10 margin-bottom-10">
							<input type="radio" name="job_instruction" value="3"> Camera Ready Ad
						</label> 
					  </div>
				   </div>   
				</div>
			
				<p class="margin-top-5 margin-bottom-5">Art Work <small class="text-grey">(select one)</small></p>
				<div class="row">
				   <div class="col-sm-12">
					<div class="btn-group" data-toggle="buttons">
						<label class="btn btn-sm btn-default margin-right-10 margin-bottom-10 hidden">
							<input type="radio" name="art_work" value="0" checked="checked">Default
						</label> 
						<label class="btn btn-sm btn-default margin-right-10 margin-bottom-10">
							<input type="radio" name="art_work" value="1">Use additional art if required
						</label> 
						<label class="btn btn-sm btn-default margin-right-10 margin-bottom-10">
							<input type="radio" name="art_work" value="2">Modify art provided if necessary
						</label> 
						<label class="btn btn-sm btn-default margin-right-10 margin-bottom-10">
							<input type="radio" name="art_work" value="3">Use art provided without change
						</label>
					  </div>
				   </div>   
				</div>
			</div>
		</div>
<?php if(isset($activate_notification) && $activate_notification=='inactive'){ ?>	
		<div class="row">        
               <div class="col-xs-12 text-right margin-top-5">
                       <div class="padding-top-15">
                               <span class="margin-right-10 text-grey"><label><input type="checkbox" class="margin-right-5">Rush</label></span>
                               <input class="btn btn-sm btn-blue" value="Submit" disabled>
                       </div>        
               </div>
               <div class="col-md-6 col-md-offset-6 col-xs-12 margin-top-15">
                       <div class="alert alert-danger  text-center alert-outline padding-5 small">
							Please <a href="<?php echo base_url().index_page().'professional_edition/home/activate_account'; ?>" class="text-blue">click here</a> to assign a designer to your account.
                       </div>
               </div>
        </div>
<?php }else{ ?>
		<div class="row">	
			<div class="col-xs-12 text-right margin-top-5">
				<div class="padding-top-15">
					
						<?php if($client['rush']=='1') {  ?>
							<p><input type="checkbox" name="rush" value="1" class="margin-right-5"> 
							<span class="margin-right-10  text-grey"><label>Rush if possible</label></span>
						<?php } ?>
						<button type="submit" name="submit" value="Submit" class="btn btn-blue btn-sm">Submit</button>
		   
				</div>	
			</div>
		 </div>
<?php } ?>		 
	</form>
		
	</div>
   </section>
	
</div>
			
<?php $this->load->view('professional_edition/footer');?>			