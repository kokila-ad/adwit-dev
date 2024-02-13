<?php $this->load->view('new_client/header');?>

<div id="main"> 
   <section>
      <div class="container margin-top-40 center">                        
		<p>Place New Order</p>  
           <a href="<?php echo base_url().index_page().'new_client/home/print_ad';?>" class="btn btn-sm btn-dark btn-outline btn-active margin-right-5">Print Ad</a>
           <a href="<?php echo base_url().index_page().'new_client/home/online_ad';?>" class="btn btn-sm btn-dark btn-outline">Online Ad</a>
      </div>
   </section>
	
   <section>
    <div class="container margin-top-40">   
	<form method="post" name="order_form" id="order_form">
	  <div class="row">
		
	   <div class="col-md-6 col-sm-6 col-xs-12">
		   <p class="margin-bottom-5<?php if(null != form_error('advertiser_name')):?> text-red<?php endif;?>">Advertiser Name<?php if(null != form_error('advertiser_name')):?>
                       <span class="text-red"> Required</span>
			<?php endif;?><span class="text-red">*</span></p>
	       <input type="text" name="advertiser_name" value="<?php echo set_value('advertiser_name');?>"
		   class="form-control input-sm margin-bottom-15" <?php if(null != form_error('advertiser_name')):?>style="border: 1px solid red"<?php endif;?> required>
		  
			
		   <p class="margin-bottom-5<?php if(null != form_error('job_no')):?> text-red<?php endif;?>">Unique Job Name / Number <?php if(null != form_error('job_no')):?><span class="text-red"> Required</span><?php endif;?> <span class="text-red">*</span> <small class="text-grey">(any alphanumeric of your choice)</small> </p>
	       <input type="text" name="job_no" pattern="[a-zA-Z0-9 ]{1,50}" value="<?php echo set_value('job_no');?>"
		   class="form-control input-sm margin-bottom-15" <?php if(null != form_error('job_no')):?>style="border: 1px solid red"<?php endif;?> required>

		 <p class="margin-bottom-5<?php if(null != form_error('copy_content_description')):?> text-red<?php endif;?>">Copy, Content, Text  <?php if(null != form_error('copy_content_description')):?><span class="text-red"> Required</span><?php endif;?> <span class="text-red"> *</span></p>
		   <textarea rows="3" name="copy_content_description" class="form-control input-sm margin-bottom-15" <?php if(null != form_error('copy_content_description')):?>style="border: 1px solid red"<?php endif;?> required><?php echo set_value('copy_content_description');?></textarea>	
			
		</div>
	    <div class="col-md-6 col-sm-6 col-xs-12">
			<div class="row">
	            <div class="col-md-6 col-sm-6 col-xs-6">
					 <p class="margin-bottom-5<?php if(null != form_error('width')):?> text-red<?php endif;?>">Width <span class="text-red">*</span> <small class="text-grey">(in inches <?php if(null != form_error('width')):?>
					only numerical values allowed.<?php endif;?>)</small></p>
					 <input type="number" name="width" max="99" min="1" step="0.0001" value="<?php echo set_value('width'); ?>" class="form-control input-sm  margin-bottom-15" <?php if(null != form_error('width')):?>style="border: 1px solid red"<?php endif;?> required>
					
				</div>
			    <div class="col-md-6 col-sm-6 col-xs-6"> 
					<p class="margin-bottom-5<?php if(null != form_error('height')):?> text-red<?php endif;?>">Height<span class="text-red">*</span> <small class="text-grey">(in inches  <?php if(null != form_error('height')):?>
					only numerical values allowed.
					<?php endif;?>)</small></p>
					<input type="number" name="height" max="99" min="1"  step="0.0001" value="<?php echo set_value('height'); ?>" class="form-control input-sm margin-bottom-15" <?php if(null != form_error('height')):?>style="border: 1px solid red"<?php endif;?> required>
					
				</div>
			</div> 
			
			<p class="margin-bottom-5<?php if(null != form_error('print_ad_type')):?> text-red<?php endif;?>">Full Color / B&W / Spot <?php if(null != form_error('print_ad_type')):?><span class="text-red"> Required</span><?php endif;?><span class="text-red"> * </span><small class="text-grey">(select one)</small></p>
		    <div class="row margin-bottom-5">
			    <div class="col-sm-12">
					<div class="btn-group" data-toggle="buttons">
						<label class="btn btn-sm btn-default margin-right-10 margin-bottom-10">
							<input type="radio" name="print_ad_type" value="1" <?php echo set_radio('print_ad_type', '1'); ?> required> Full Color
						</label> 
						<label class="btn btn-sm btn-default margin-right-10 margin-bottom-10">
							<input type="radio" name="print_ad_type" value="2" <?php echo set_radio('print_ad_type', '2'); ?> required> B&amp;W
						</label> 
						<label class="btn btn-sm btn-default margin-right-10 margin-bottom-10">
							<input type="radio" name="print_ad_type" value="3" <?php echo set_radio('print_ad_type', '3'); ?> required> Spot
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
	 
	
		<div class="row">	
			<div class="col-xs-12 text-right margin-top-5">
				<div class="padding-top-15">
					
						<!--<?php if($publication['id']=='43' || $publication['id']=='13'){  ?> 
							<p><input type="checkbox" name="rush" value="1" class="margin-right-5"> 
							<span class="margin-right-10  text-grey"><label>Rush if possible</label></span>
						<?php } ?>	-->
							<?php $adrep = $this->db->get_where('adreps',array('id'=>$this->session->userdata('ncId')))->result_array();
								if($adrep[0]['rush']=='1') { ?>
							<p><input type="checkbox" name="rush" value="1" <?php echo set_checkbox('rush', '1'); ?>> 
							<span class="margin-right-10  text-grey"><label>Rush if possible</label></span>
							<?php } ?>
						<button type="submit" name="submit" value="Submit" class="btn btn-blue btn-sm">Submit</button>
		   
				</div>	
			</div>
		 </div>
	</form>
	</div>
   </section>
	
</div>
			
<?php $this->load->view('new_client/footer');?>			