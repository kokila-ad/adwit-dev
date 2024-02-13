<?php $this->load->view('new_client/header');?>

<div id="main"> 
   <section>
      <div class="container margin-top-40 center">                        
		<p>Place New Order</p>  
           <a href="<?php echo base_url().index_page().'new_client/home/print_ad';?>" class="btn btn-sm btn-dark btn-outline btn-active margin-right-5">Print Ad</a>
		</div>
   </section>
	
   <section>
     <div class="container margin-top-40">   
	 <form method="post" name="order_form" id="order_form">
	  <div class="row">
	   <div class="col-md-6 col-sm-6 col-xs-12">
		   <p class="margin-bottom-5">Advertiser Name <span class="text-red">*</span></p>
	       <input type="text" name="advertiser_name" class="form-control input-sm margin-bottom-15" value="<?php echo $preorder_details[0]['advertiser']; ?>">

		   <p class="margin-bottom-5">Unique Job Name / Number <span class="text-red">*</span> <small class="text-grey">(any alphanumeric of your choice)</small> </p>
	       <input type="text" name="job_no" pattern="[a-zA-Z0-9 ]{1,50}" class="form-control input-sm margin-bottom-15" value="<?php echo $preorder_details[0]['job_name']; ?>" readonly >
		   
		   <p class="margin-bottom-5">Publication Name</p>
			   <input type="text" name="publication_name" class="form-control input-sm  margin-bottom-15" value="<?php echo $preorder_details[0]['publication']; ?>" readonly>
		 
		  <p class="margin-bottom-5">Copy, Content, Text<span class="text-red"> *</span></p>
		       <textarea rows="3" name="copy_content_description" class="form-control input-sm margin-bottom-15" required=""></textarea>
	   </div>
	    
	   <div class="col-md-6 col-sm-6 col-xs-12">
			<div class="row margin-bottom-5">
	           <div class="col-md-7 col-sm-12 col-xs-12">
					 <p class="margin-bottom-5">Width <span class="text-red">*</span> <small class="text-grey">(in columns)</small></p>
					 <div class="btn-group" data-toggle="buttons">
						<?php
							$preorder_width = $this->db->get('preorder_width')->result_array();
							foreach($preorder_width as $row)
								{
						?>
							<label <?php if($row['id'] == $preorder_details[0]['width1']) { ?> class="active btn btn-default btn-sm margin-right-10 margin-bottom-10" <?php } else { ?> class=" btn btn-default btn-sm margin-right-10 margin-bottom-10" <?php } ?>>
								<input type="radio" name="width" value="<?php echo $row['value'];?>" <?php if($row['id'] == $preorder_details[0]['width1']){ echo 'checked="checked"';  } ?> required=""> <?php echo $row['id']; ?>
							</label>
							<?php } ?>
						
				     </div>
				 </div>
					<div class="col-md-5 col-sm-12 col-xs-12"> 
					<p class="margin-bottom-5">Height <span class="text-red">*</span> <small class="text-grey">(in inches)</small></p>
					<input type="number" name="height" max="99" min="1"  step="0.0001" class="form-control input-sm margin-bottom-10" value="<?php echo $preorder_details[0]['height']; ?>" required=""></div>
				</div> 
			
			 <p class="margin-bottom-5">Full Color / B&W / Spot<span class="text-red"> * </span><small class="text-grey">(select one)</small></p>
		    <div class="row margin-bottom-5">
			   <div class="col-sm-12">
				<div class="btn-group" data-toggle="buttons">
					<label <?php if($preorder_details[0]['color']=='CMYK') { ?> class="active btn btn-default btn-sm margin-right-10 margin-bottom-10" <?php } else { ?> class=" btn btn-default btn-sm margin-right-15 margin-bottom-5" <?php } ?>>
						<input type="radio" name="color" value="1" required="" <?php if($preorder_details[0]['color']=='CMYK'){echo 'checked="checked"';} ?>> Full Color
					</label> 
					<label <?php if($preorder_details[0]['color']=='B&W') { ?> class="active btn btn-default btn-sm margin-right-10 margin-bottom-10" <?php } else { ?> class=" btn btn-default btn-sm margin-right-15 margin-bottom-5" <?php } ?>>
						<input type="radio" name="color" value="2" required="" <?php if($preorder_details[0]['color']=='B&W'){echo 'checked="checked"';} ?>> B&amp;W
					</label> 
					<label <?php if($preorder_details[0]['color']=='Spot') { ?> class="active btn btn-default btn-sm margin-bottom-10" <?php } else { ?> class=" btn btn-default btn-sm margin-right-15 margin-bottom-5" <?php } ?>>
						<input type="radio" name="color" value="3" required="" <?php if($preorder_details[0]['color']=='Spot'){echo 'checked="checked"';} ?>> Spot
					</label>  
				  </div>
				</div>   
		   </div>
			
			<div class="row">
			    <div class="col-md-6 col-sm-6 col-xs-6">
					<p class="margin-bottom-5">Publish Date</p>	 
					<input id="date_needed" type="text" class="form-control input-sm margin-bottom-15" name="publish_date" value="<?php echo date("Y-m-d", strtotime($preorder_details[0]['publish_date'])); ?>" readonly>
				</div>
			    <div class="col-md-6 col-sm-6 col-xs-6">
					<p class="margin-bottom-5">Date needed</p>	 
					<input id="date_needed" type="text" class="form-control input-sm margin-bottom-15" name="date_needed" value="<?php echo date("Y-m-d", strtotime($preorder_details[0]['date_needed'])); ?>" readonly>
				</div>
			</div>
				
			<p class="margin-bottom-5"> Notes &amp; Instructions</p>
				<textarea rows="3" name="notes" class="form-control input-sm margin-bottom-15"></textarea>	
		   
						
		</div> 
	  </div>
	
		
		<div class="row">	
			<div class="col-xs-12 text-right margin-top-5">
				<div class="padding-top-15">
					<?php $adrep = $this->db->get_where('adreps',array('id'=>$this->session->userdata('ncId')))->result_array();
								if($adrep[0]['rush']=='1') { ?>
									<p><input type="checkbox" name="rush" value="1"> 
									<span class="margin-right-10  text-grey"><label>Rush if possible</label></span>
						<?php } ?>
					<input name="id" value="<?php echo $preorder_details[0]['id'];?>" readonly style="display:none;" />
					<input class="btn btn-blue btn-sm" name="order_submit" type="submit" value="Submit" />
        
				</div>	
			</div>
		 </div>
	</form>
	</div>
   </section>
	
</div>
			
<?php if($this->session->userdata('ncId')=='36'){ $this->load->view('new_client/privacy_footer'); }else{ $this->load->view('new_client/footer'); } ?>		