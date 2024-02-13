<?php $this->load->view('india_client/header'); ?>

   <div id="main">
   
    <section>
	
      <div class="container margin-top-40 center">                        
			   	<p class="large">Place New Order</p>  

               <button type="button" class="btn btn-dark btn-sm btn-outline btn-active">Print Ad</button>
              
      </div><!-- /.container -->
    </section><!-- /section -->

	 <section>
      <div class="container margin-top-40">   
	  <form method="post" name="order_form" id="order_form">
	   <div class="row">
	     <div class="col-md-6 col-sm-6 col-xs-12">
		   <p class="margin-bottom-5">Client Name <span class="text-red">*</span></p>
	       <input type="text" name="advertiser_name" class="form-control input-sm margin-bottom-15" title="" required>

		    
		   <p class="margin-bottom-5">Job Name <span class="text-red">*</span> <small class="text-grey">(only alphanuemeric characters allowed)</small> </p>
	       <input type="text"  name="job_no" pattern="[a-zA-Z0-9 ]{1,50}" class="form-control input-sm margin-bottom-15" title="" required>
		   
		   <p class="margin-bottom-5">Publication Name <span class="text-red"></span></p>
	       <input type="text" name="publication_name" class="form-control input-sm margin-bottom-15" title="">
		   
	       <div class="row margin-bottom-15">
	           <div class="col-md-6 col-sm-6 col-xs-6">
					 <p class="large margin-bottom-5">Width <span class="text-red">*</span> <small class="text-grey">(in cms)</small></p>
					 <input type="number" name="width" pattern="[1-9]{1,50}" min="1" class="form-control input-sm"  required></div>
			   <div class="col-md-6 col-sm-6 col-xs-6"> 
					<p class="large margin-bottom-5">Height <span class="text-red">*</span> <small class="text-grey">(in cms)</small></p>
					<input type="number" name="height"  pattern="[1-9]{1,50}" min="1" class="form-control input-sm" required></div>
			</div> 
			
		   <p class="margin-bottom-5">Full Color/B&W/Spot<span class="text-red"> *</span></p>
		   <div class="row margin-bottom-15">
           <div class="col-sm-9">
             <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-default btn-sm margin-right-15 margin-bottom-5">
                    <input type="radio" name="print_ad_type" value="1" required/> Full Color
                </label> 
                <label class="btn btn-default btn-sm margin-right-15 margin-bottom-5">
                    <input type="radio" name="print_ad_type" value="2" required /> B&W
                </label> 
                <label class="btn btn-default btn-sm margin-right-15 margin-bottom-5">
                    <input type="radio" name="print_ad_type" value="3" required/> Spot
                </label>  
              </div>
            </div>   
		 </div>
		 
		 <p class="margin-bottom-5">Job Instruction<span class="text-red"> *</span></p>
		<div class="row">
           <div class="col-sm-9">
             <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-default btn-sm margin-right-15 margin-bottom-5">
                    <input type="radio" name="job_instruction" value="1" required/> Follow Instructions Carefully
                </label> 
                <label class="btn btn-default btn-sm margin-right-15 margin-bottom-15">
                    <input type="radio" name="job_instruction" value="2" required /> Be Creative
                </label>  
              </div>
           </div>   
		</div>
  
	   </div> 
	   
	    <div class="col-md-6 col-sm-6 col-xs-12">
			<p class="margin-bottom-5">Date needed <span class="text-red">*</span> </p>	 
			<div class="input-group date date-picker margin-bottom-15" data-date-format="dd-mm-yyyy" data-date-start-date="+0d">
				<input id="date_needed" type="text" class="form-control input-sm" name="date_needed" required >
				<span class="input-group-btn">
				<button class="btn btn-blue btn-sm" type="button"><i class="fa fa-calendar"></i></button>
				</span>
			</div>
					
		<p class="margin-bottom-5">Copy & Content<span class="text-red"> *</span></p>
		<textarea rows="5" name="copy_content_description" class="form-control margin-bottom-25" required></textarea>	
		
		<p>Note & Instruction</p>
		<textarea rows="5" name="notes" class="form-control margin-bottom-15"></textarea>	
		</div>
	</div> 
	   		  
	   <div class="row text-right margin-top-5">
	   <input class="btn btn-primary btn-sm margin-right-15" type="submit" value="Submit" id="submit_form"  />
	    <!--<button type="submit" name="submit" value="Submit" class="btn btn-primary btn-lg margin-right-15 ">SUBMIT</button>-->
	   </div>
	 </form> 
	  </div>
	 </section>
	
            </div>

            
<?php $this->load->view('india_client/footer'); ?>



