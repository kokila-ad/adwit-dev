<?php $this->load->view('new_client/header'); ?>
<style>
.file_li {
   // width: 350px;
	min-width: 250px;
   // overflow-x: hidden;
}
.min-height-155 {
	min-height: 155px;
}
.dz-message {display: none; }
.drag-bg { display: block; background-image: url(http://adwitdigital.com/adwitads425/assets/new_client/img/drag_bg.png); //background-size: cover; }

@media (max-width: 490px) {
	.dz-message {display: block; }
}
</style>

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
		
		<script>
$(document).ready(function(){
		$("select").change(function(){
			$(this).find("option:selected").each(function(){
				if($(this).attr("value")=="custom"){
						$("#width").attr("required",true);
						$("#height").attr("required",true);	
					} else {
						$("#width").attr("required",false);
						$("#height").attr("required",false);	
					}
			   	});
		}).change();
	});
</script>
<div id="main">

<!-- <form method="post">-->

<section>
      <div class="container margin-top-40 center">                        
		<p>Place New Order</p>  
           <div>
				<a href="<?php echo base_url().index_page().'new_client/home/resubmit_form/'.$order_details[0]['id'].'/print';?>"
				<?php if($adtype=='print') { ?> class="btn btn-sm btn-dark btn-outline btn-active margin-right-10" <?php } else { ?> class="margin-right-10 btn btn-sm btn-dark btn-outline" <?php } ?> >Print Ad</a>
				<a href="<?php echo base_url().index_page().'new_client/home/resubmit_form/'.$order_details[0]['id'].'/online';?>" 
				<?php if($adtype=='online') { ?> class="btn btn-sm btn-dark btn-outline btn-active margin-right-10" <?php } else { ?> class="margin-right-10 btn btn-sm btn-dark btn-outline" <?php } ?> >Online Ad</a>
			</div>
		</div>
</section>

<section id="resubmit">
    <div class="container">
		<form method="post">	      
        <div class="row margin-top-30">
			
			<div class="col-md-6 col-sm-6 col-xs-12 margin-bottom-15">
               <p class="margin-bottom-5">Advertiser Name <span class="text-red">*</span> </p>
               <input type="text" name="advertiser_name" value="<?php echo $order_details[0]['advertiser_name']; ?>" class="form-control input-sm margin-bottom-15" title="" required>
               
               <p class="margin-bottom-5">New Unique Job Name / Number <span class="text-red">*</span> <small class="text-grey">(any alphanumeric of your choice)</small> </p>
               <input type="text" name="job_no" pattern="[a-zA-Z0-9 ]{1,50}" value="<?php echo $order_details[0]['job_no']; ?>" class="form-control input-sm margin-bottom-15" title="" required>
             
				<?php if(isset($adtype) && $adtype == 'online') { ?>
					<p class="margin-bottom-5">Maximum File Size <span class="text-red">* </span><small class="text-grey">(In KBs)</small></p>
					<input type="text" name="maximum_file_size" value="<?php echo $order_details[0]['maxium_file_size']; ?>" class="form-control input-sm margin-bottom-15" title="" required="">
				<?php } ?>
			   
			   <p class="margin-bottom-5">Copy, Content, Text </p>
               <textarea rows="4" name="copy_content_description" value="<?php echo $order_details[0]['copy_content_description']; ?>" class="form-control margin-bottom-15" title=""><?php echo $order_details[0]['copy_content_description']; ?></textarea>
			</div>
			
			<?php if(isset($adtype) && $adtype == 'print') { ?>
			
            <div class="col-md-6 col-sm-6 col-xs-12">
			
					
			<div class="row margin-bottom-15 custom box">
	           <div class="col-md-6 col-sm-6 col-xs-6">
					 <p class="margin-bottom-5">Width <span class="text-red">*</span> <small class="text-grey">(in inches)</small> </p>
					 
					 <input type="number" id="width" name="width" value="<?php echo $order_details[0]['width']; ?>" max="99" min="1" step="0.0001"  class="form-control input-sm" required>
				</div>
					 
					<div class="col-md-6 col-sm-6 col-xs-6"> 
					<p class="margin-bottom-5">Height<span class="text-red">*</span> <small class="text-grey">(in inches)</small></p>
					<input type="number" id="height" name="height" value="<?php echo $order_details[0]['height']; ?>" max="99" min="1" step="0.0001" class="form-control input-sm" required>
					</div>
					
					
			</div> 
			<p class="margin-bottom-5">Full Color / B&W / Spot<span class="text-red"> *</span></p>
				<div class="row  margin-bottom-5">
				<div class="col-sm-9">
					<div class="btn-group" data-toggle="buttons">
                   <?php $print_ad_type = $this->db->query("SELECT * FROM `print_ad_types`")->result_array();
					 foreach($print_ad_type as $row){ 
					?>
						 
					 <label <?php if($row['id'] == $order_details[0]['print_ad_type']) { ?> class="active btn btn-default btn-sm margin-right-15 margin-bottom-5" <?php } else { ?> class=" btn btn-default btn-sm margin-right-15 margin-bottom-5" <?php } ?>>
					<input type="radio" name="print_ad_type" value="<?php echo $row['id'];?>"  <?php if($row['id'] == $order_details[0]['print_ad_type']){ echo 'checked="checked"';  } ?> required > <?php echo $row['name'];?>
                    </label> 
					
					<?php }	?>
					 
                  </div>
                </div>   
                </div>	
              <p>Notes & Instructions</p>
               <textarea rows="4" name="notes" value="<?php echo $order_details[0]['notes']; ?>" class="form-control" title=""><?php echo $order_details[0]['notes']; ?></textarea> 			   
            
 		   
            </div> 
			<div class="col-md-12 col-sm-12 col-xs-12">
                <button type="submit" class="btn btn-blue btn-sm float-right  margin-top-20" name="print_submit">Submit</button>
            </div>	
            <?php }	?>
			
			<?php if(isset($adtype) && $adtype == 'online') { ?>
			
			 <div class="col-md-6 col-sm-6 col-xs-12">
			<p class="margin-bottom-5">Format<span class="text-red"> * </span><small class="text-grey">(select one)</small></p>
		    <div class="row margin-bottom-5">
			   <div class="col-sm-12">
				 <div class="btn-group" data-toggle="buttons">
				 
        <?php $web_ad_formats = $this->db->get('web_ad_formats')->result_array();
			  foreach($web_ad_formats as $result){ ?>
			  <label <?php if($result['id'] == $order_details[0]['ad_format']) { ?> class="active btn btn-sm btn-default margin-right-10 margin-bottom-10" <?php } else { ?>  class="btn btn-sm btn-default margin-right-10 margin-bottom-10" <?php } ?>>
				<input type="radio" name="ad_format" value="<?php echo $result['id']; ?>" <?php if($result['id'] == $order_details[0]['ad_format']){ echo 'checked="checked"';  } ?> required="">
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
					<label <?php if($order_details[0]['web_ad_type']=='Static') { ?> class="active btn btn-sm btn-default margin-right-10 margin-bottom-10" <?php } else { ?> class="btn btn-sm btn-default margin-right-10 margin-bottom-10" <?php } ?> >
						<input type="radio" name="web_ad_type" value="Static" <?php if($order_details[0]['web_ad_type']=="Static"){ echo 'checked="checked"';  } ?> required=""> Static
					</label> 
					<label <?php if($order_details[0]['web_ad_type']=='Animated') { ?> class="active btn btn-sm btn-default margin-right-10 margin-bottom-15" <?php } else { ?> class="btn btn-sm btn-default margin-right-10 margin-bottom-10" <?php } ?>>
						<input type="radio" name="web_ad_type" value="Animated" <?php if($order_details[0]['web_ad_type']=="Animated"){ echo 'checked="checked"';  } ?> required=""> Animated
					</label> 
				  </div>
			   </div>   
			</div>
			 		
						
		   <p class="margin-bottom-5">Size <span class="text-red">* </span><small class="text-grey">(in Pixels)</small></p>
		   <div class="row margin-bottom-15">
			   <div class="col-sm-12">
					
					<select class="form-control input-sm" name="pixel_size" required >
						<option value="">Select</option>
						<?php  $pixel_sizes = $this->db->get('pixel_sizes')->result_array();
								foreach($pixel_sizes as $row)
								{
						?>
						<option value="<?php echo $row['id']; ?>" <?php if($row['id']==$order_details[0]['pixel_size']) echo'selected="selected"'; ?>><?php echo $row['width'].' X '.$row['height'].' ('.$row['name'].')'; ?></option>
						<?php } ?>
						<option value="custom" <?php if($order_details[0]['pixel_size'] == 'custom') echo 'selected="selected"';?>>Custom</option>
					</select>
					
				</div>   
			</div>	
			
			<div class="row margin-bottom-15 custom box">
	           <div class="col-md-6 col-sm-6 col-xs-6">
					 <p class="margin-bottom-5">Width <span class="text-red">*</span> <small class="text-grey">(in pixels)</small></p>
					 <input type="number" name="custom_width" pattern="[1-9]{1,50}" min="1" class="form-control input-sm" value="<?php echo $order_details[0]['custom_width']; ?>"></div>
			   <div class="col-md-6 col-sm-6 col-xs-6"> 
					<p class="margin-bottom-5">Height <span class="text-red">*</span> <small class="text-grey">(in pixels)</small></p>
					<input type="number" name="custom_height" pattern="[1-9]{1,50}" min="1" class="form-control input-sm" value="<?php echo $order_details[0]['custom_height']; ?>"></div>
			</div> 
			 <p>Notes & Instructions</p>
               <textarea rows="4" name="notes" value="<?php echo $order_details[0]['notes']; ?>" class="form-control" title=""><?php echo $order_details[0]['notes']; ?></textarea> 			   
            
		</div> 
		 <div class="col-md-12 col-sm-12 col-xs-12">
                <button type="submit" class="btn btn-blue btn-sm float-right  margin-top-20" name="online_submit">Submit</button>
            </div>
			<?php } ?>
            
        </div> 
		</form>
    </div>
</section>


<!--</form>-->

</div>
         
<?php if($this->session->userdata('ncId')=='36'){ $this->load->view('new_client/privacy_footer'); }else{ $this->load->view('new_client/footer'); } ?>
