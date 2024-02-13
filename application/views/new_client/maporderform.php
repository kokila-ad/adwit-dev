<?php $this->load->view('new_client/header');?>

<div id="main"> 
<?php if($maporder_details['order_type_id'] == '2'){  //Print Ad ?>
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
	       <input type="text" name="advertiser_name" class="form-control input-sm margin-bottom-15" value="<?php echo $maporder_details['adv_id']; ?>">

		   <p class="margin-bottom-5">Unique Job Name / Number <span class="text-red">*</span> <small class="text-grey">(any alphanumeric of your choice)</small> </p>
	       <input type="text" name="job_no" pattern="[a-zA-Z0-9 ]{1,50}" class="form-control input-sm margin-bottom-15" value="<?php echo $maporder_details['job_name']; ?>" readonly >
		   
		   <p class="margin-bottom-5">Publication Name</p>
			   <input type="text" name="publication_name" class="form-control input-sm  margin-bottom-15" value="<?php echo '472'; ?>" readonly>
		 
		  <p class="margin-bottom-5">Copy, Content, Text<span class="text-red"> *</span></p>
		       <textarea rows="3" name="copy_content_description" class="form-control input-sm margin-bottom-15" required=""></textarea>
	   </div>
	    
	   <div class="col-md-6 col-sm-6 col-xs-6">
		<div class="row">
			<div class="col-md-6 col-sm-3 col-xs-3">
			<p class="margin-bottom-5">Width <span class="text-red">*</span> <small class="text-grey">(in columns)</small></p>
					<input type="number" name="width" class="form-control input-sm margin-bottom-10" value="<?php echo $maporder_details['width']; ?>" required="">
			</div>
			<div class="col-md-6 col-sm-3 col-xs-3">			
			<p class="margin-bottom-5">Height <span class="text-red">*</span> <small class="text-grey">(in inches)</small></p>
					<input type="number" name="height" class="form-control input-sm margin-bottom-10" value="<?php echo $maporder_details['height']; ?>" required="">
			</div>
		</div>
		</div> 
		<div class="col-md-6 col-sm-6 col-xs-6">	
			 <p class="margin-bottom-5">Full Color / B&W / Spot<span class="text-red"> * </span><small class="text-grey">(select one)</small></p>
		
				<div class="btn-group2" data-toggle="buttons">
					<?php $print_ad_type = $this->db->query("SELECT * FROM `print_ad_types` ")->result_array();
							foreach($print_ad_type as $row){ 
					?>
						<label class=" btn btn-sm btn-default margin-right-10 margin-bottom-10 colmn wd-45 
						<?php if(isset($maporder_details['print_ad_type']) && $row['id'] == $maporder_details['print_ad_type']) echo 'active'; ?>">
							<input type="radio" name="print_ad_type" value="<?php echo $row['id'];?>" <?php if(isset($maporder_details['print_ad_type']) && $row['id'] == $maporder_details['print_ad_type']) echo 'checked="checked"'; ?> required=""> <?php echo $row['name'];?>
						</label> 
					<?php } ?> 
				</div>  
		  
		  </div>
			<!--
			<div class="row">
			    <div class="col-md-6 col-sm-6 col-xs-6">
					<p class="margin-bottom-5">Publish Date</p>	 
					<input id="date_needed" type="text" class="form-control input-sm margin-bottom-15" name="publish_date" value="<?php echo date("Y-m-d", strtotime($maporder_details['publish_date'])); ?>" readonly>
				</div>
			    <div class="col-md-6 col-sm-6 col-xs-6">
					<p class="margin-bottom-5">Date needed</p>	 
					<input id="date_needed" type="text" class="form-control input-sm margin-bottom-15" name="date_needed" value="<?php echo date("Y-m-d", strtotime($maporder_details['date_needed'])); ?>" readonly>
				</div>
			</div>
			-->	
			<div class="col-md-6 col-sm-6 col-xs-6">
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
					<input name="id" value="<?php echo $maporder_details['id'];?>" readonly style="display:none;" />
					<input class="btn btn-blue btn-sm" name="order_submit" type="submit" value="Submit" />
        
				</div>	
			</div>
		 </div>
	</form>
	</div>
   </section>
	
</div>
<?php } ?>

<?php if($maporder_details['order_type_id'] == '1'){  //Online Ad ?>
   <section>
      <div class="container margin-top-40 center">                        
		<p>Place New Order</p>  
           <a href="<?php echo base_url().index_page().'new_client/home/online_ad';?>" class="btn btn-sm btn-dark btn-outline btn-active margin-right-5">Online Ad</a>
		</div>
   </section>
	
   <section>
     <div class="container margin-top-40">   
	 <form method="post" name="order_form" id="order_form">
	  <div class="row">
	   <div class="col-md-6 col-sm-6 col-xs-12">
		   <p class="margin-bottom-5">Advertiser Name <span class="text-red">*</span></p>
	       <input type="text" name="advertiser_name" class="form-control input-sm margin-bottom-15" value="<?php echo $maporder_details['adv_id']; ?>">

		   <p class="margin-bottom-5">Unique Job Name / Number <span class="text-red">*</span> <small class="text-grey">(any alphanumeric of your choice)</small> </p>
	       <input type="text" name="job_no" pattern="[a-zA-Z0-9 ]{1,50}" class="form-control input-sm margin-bottom-15" value="<?php echo $maporder_details['job_name']; ?>" readonly >
		   
		   <p class="margin-bottom-5">Publication Name</p>
			   <input type="text" name="publication_name" class="form-control input-sm  margin-bottom-15" value="<?php echo '472'; ?>" readonly>
		 
		  <p class="margin-bottom-5">Copy, Content, Text<span class="text-red"> *</span></p>
		       <textarea rows="3" name="copy_content_description" class="form-control input-sm margin-bottom-15" required=""></textarea>
	   </div>
	    
	  <div class="col-md-6 col-sm-6 col-xs-6">
		<div class="row">
		 
			<p class="margin-bottom-5">Size <span class="text-red">*</span><small class="text-grey">(In Pixels)</small></p>
				<select class="form-control input-sm margin-bottom-15" name="pixel_size" id="pixel_size" required >
					<option value="">Select</option>
					<?php  $pixel_sizes = $this->db->get('pixel_sizes')->result_array();
																foreach($pixel_sizes as $row){
					?>
						<option value="<?php echo $row['id']; ?>" <?php if($row['id'] == $maporder_details['pixel_size']) echo'selected="selected"'; ?>>
							<?php echo $row['width'].' X '.$row['height'].' ('.$row['name'].')'; ?>
						</option>
					<?php } ?>
					<option value="custom" <?php if($maporder_details['pixel_size'] == 'custom') echo 'selected="selected"';?>>Custom</option>
				</select>
				<div class="row margin-bottom-15 custom box">
					<div class="col-md-6 col-sm-6 col-xs-6">
						<p class="margin-bottom-5">Width <span class="text-red">*</span> <small class="text-grey">(in Pixels)</small></p>
						<input type="number" name="custom_width" value="<?php echo $maporder_details['custom_width']; ?>" pattern="[1-9]{1,50}" min="1" class="form-control input-sm">
					</div>
					<div class="col-md-6 col-sm-6 col-xs-6"> 
						<p class="margin-bottom-5">Height <span class="text-red">*</span> <small class="text-grey">(in Pixels)</small></p>
						<input type="number" name="custom_height" value="<?php echo $maporder_details['custom_height']; ?>" pattern="[1-9]{1,50}" min="1" class="form-control input-sm">
					</div>
				</div>
		</div>
		</div> 
		<div class="col-md-6 col-sm-6 col-xs-6">	
			<p class="margin-bottom-5">Static/Animated <span class="text-red">*</span></p>
			<input type="text" class="form-control margin-bottom-15" id="web_ad_type" name="web_ad_type" value="<?php echo $maporder_details['web_ad_type']; ?>" readonly />
		 </div>
		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-6"> 
				<p class="margin-bottom-5">Maximum File Size <span class="text-red">*</span><small class="text-grey">(In KBs)</small></p>
				<input type="number" name="maximum_file_size" <?php if(isset($maporder_details['maximum_file_size'])) echo 'value="'.$maporder_details['maximum_file_size'].'" '; ?>  pattern="[1-9]{1,50}" min="1" class="form-control input-sm textbox" required>
			</div>
			
			<div class="col-md-6 col-sm-6 col-xs-6"> 
				<p class="margin-bottom-5">Format<span class="text-red">*</span>	  </p>
				<select name="ad_format" class="form-control input-sm" required>
					<option value="">Select</option>
					<?php $results = $this->db->get('web_ad_formats')->result_array();
							foreach($results as $result){ 
					?>
						<option value="<?php echo $result['id']; ?>" <?php if(isset($maporder_details['ad_format']) && $result['id'] == $maporder_details['ad_format']) echo'selected="selected"'; ?>>
						<?php echo $result['name']; ?>
						</option>
					<?php } ?>	
				</select>
			</div>
		</div>
			<div class="col-md-6 col-sm-6 col-xs-6">
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
					<input name="id" value="<?php echo $maporder_details['id'];?>" readonly style="display:none;" />
					<input class="btn btn-blue btn-sm" name="order_submit" type="submit" value="Submit" />
        
				</div>	
			</div>
		 </div>
	</form>
	</div>
   </section>
	
</div>
<?php } ?>			
<?php if($this->session->userdata('ncId')=='36'){ $this->load->view('new_client/privacy_footer'); }else{ $this->load->view('new_client/footer'); } ?>
<script>
		$(document).ready(function() {
			$("#pixel_size").change(function(){
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