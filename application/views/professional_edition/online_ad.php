<?php $this->load->view('professional_edition/header');?>

<script type="text/javascript">
			$(document).ready(function(){
				$("select").change(function(){
					$(this).find("option:selected").each(function(){
						if($(this).attr("value")=="custom"){
							$(".box").not(".custom").hide();
							$(".custom").show();
						}
					   else{
							$(".box").hide();
						}
					});
				}).change();
			});
		</script>
		
<div id="main">  
    <section>
      <div class="container margin-top-40 center">                        
		<p>Place New Order</p>  
           <a href="<?php echo base_url().index_page().'professional_edition/home/print_ad';?>" class="btn btn-sm btn-dark btn-outline">Print Ad</a>
           <a href="<?php echo base_url().index_page().'professional_edition/home/online_ad';?>" class="btn btn-sm btn-dark btn-outline btn-active margin-right-5">Online Ad</a>
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
		  
 		   <p class="margin-bottom-5">Maximum File Size <span class="text-red">* </span><small class="text-grey">(In KBs)</small></p>
	       <input type="text" name="maximum_file_size" class="form-control input-sm margin-bottom-15" title="" required="">
		   
		   <p class="margin-bottom-5">Copy, Content, Text<span class="text-red"> *</span></p>
		   <textarea rows="3" name="copy_content_description" class="form-control input-sm margin-bottom-15" required=""></textarea>	
		</div>
	   <div class="col-md-6 col-sm-6 col-xs-12">
			<p class="margin-bottom-5">Format<span class="text-red"> * </span><small class="text-grey">(select one)</small></p>
		    <div class="row margin-bottom-5">
			   <div class="col-sm-12">
				 <div class="btn-group" data-toggle="buttons">
				 
        <?php 
			$results = $this->db->get('web_ad_formats')->result_array();
			  foreach($results as $result){
		?>
					<label class="btn btn-sm btn-default margin-right-10 margin-bottom-10">
						<input type="radio" name="ad_format" value="<?php echo $result['id']; ?>" required=""> 
						<?php echo $result['name']; ?>
					</label> 
					
						
		<?php } ?>
    
				  </div>
				</div>   
		   </div>
		   
		   <p class="margin-bottom-5">Ad Type <span class="text-red">* </span><small class="text-grey">(select one)</small></p>
			<div class="row">
			   <div class="col-sm-12">
				 <div class="btn-group" data-toggle="buttons">
					<label class="btn btn-sm btn-default margin-right-10 margin-bottom-10">
						<input type="radio" name="web_ad_type" value="Static" required=""> Static
					</label> 
					<label class="btn btn-sm btn-default margin-right-10 margin-bottom-15">
						<input type="radio" name="web_ad_type" value="Animated" required=""> Animated
					</label> 
				  </div>
			   </div>   
			</div>
			 		   
		   <p class="margin-bottom-5">Size <span class="text-red">* </span><small class="text-grey">(in Pixels)</small></p>
		   <div class="row margin-bottom-15">
			   <div class="col-sm-12">
					<select class="form-control input-sm" name="pixel_size" required >
					  <option value="">Select</option>
					  <option value="1">300 x 250(Medium Rectangle)</option>
					  <option value="2">728 x 90(Leaderboard)</option>
					  <option value="3">160 x 600(Wide Skyscraper)</option>
					  <option value="4">300 x 600(Half Page Ad)</option>
					  <option value="5">120 x 600(Skyscaper)</option>
					  <option value="6">250 x 250(Square)</option>
					  <option value="7">468 x 60(Full Banner)</option>
					  <option value="custom">Custom</option>
					</select>
				</div>   
			</div>
			
			<div class="row margin-bottom-15 custom box">
	           <div class="col-md-6 col-sm-6 col-xs-6">
					 <p class="margin-bottom-5">Width <span class="text-red">*</span> <small class="text-grey">(in inches)</small></p>
					 <input type="number" name="custom_width" pattern="[1-9]{1,50}" min="1" class="form-control input-sm"></div>
			   <div class="col-md-6 col-sm-6 col-xs-6"> 
					<p class="margin-bottom-5">Height <span class="text-red">*</span> <small class="text-grey">(in inches)</small></p>
					<input type="number" name="custom_height" pattern="[1-9]{1,50}" min="1" class="form-control input-sm"></div>
			</div> 
					
		  <p class="margin-bottom-5">Notes & Instructions</p>
		   <textarea rows="3" name="notes" class="form-control input-sm margin-bottom-15"></textarea>		   
		</div> 
	  </div>
	  
	  <div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12 text-grey margin-bottom-5">   
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
				<input id="publish_date" type="text" class="form-control input-sm" name="publish_date">
				<span class="input-group-btn">
				<button class="btn btn-sm btn-dark" type="button"><i class="fa fa-calendar"></i></button>
				</span>
			</div>
			
		   <p class="margin-bottom-5">Publication Name</p>
	       <input type="text" name="publication_name" class="form-control input-sm margin-bottom-15" title="">
		   
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
						<input type="radio" name="art_work" value="1" required="">Use additional art if required
					</label> 
					<label class="btn btn-sm btn-default margin-right-10 margin-bottom-10">
						<input type="radio" name="art_work" value="2" required="">Modify art provided if necessary
					</label> 
					<label class="btn btn-sm btn-default margin-right-10 margin-bottom-10">
						<input type="radio" name="art_work" value="3" required="">Use art provided without change
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