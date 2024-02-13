<?php $this->load->view("lite/head.php"); ?>
<?php $this->load->view("lite/header.php"); ?>
<style> .fa-info-circle{ cursor: pointer}</style>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
	<script>
			 $(document).ready(function(){
				 $("#advancesearch").hide();
				 $("#optional").hide();
				 
				 $("#showoptional").click(function(){
					$("#optional").toggle();      
				 });
				 
				 $("#showadvancesearch").click(function(){
					$("#advancesearch").toggle();  
					$("#search").toggle();  		
				  });
				 
				 $("#showsearch").click(function(){
					$("#advancesearch").toggle();  
					$("#search").toggle();  		
				  });  
				  
				$('#example1').DataTable( {
					"order": [[ 0, "desc" ]]
				} );
			
				$('#example1').DataTable();
				//custom size
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
				//ad format
				$('input[name="ad_format"]').change(function(){
						var x = $(this).attr("value");
						var si = $('input[name="static'+x+'"]').attr("value");
						var ai = $('input[name="animated'+x+'"]').attr("value");
						
						if(si == '0'){ 
							$("#web_ad_type_static").hide();
						} else if(si == '1') {
							$("#web_ad_type_static").show();
						}
						
						if(ai == '0'){ 
							$("#web_ad_type_animated").hide();
						} else if(ai == '1') {
							$("#web_ad_type_animated").show();
						}
						
					});
				
			 });
					  
		   jQuery(function($) {
				$('#dateControlledByRange').on('input', function() {
					$('#rangeControlledByDate').prop('valueAsNumber', $.prop(this, 'valueAsNumber'));
				});
				$('#rangeControlledByDate').on('input', function() {
					$('#dateControlledByRange').prop('valueAsNumber', $.prop(this, 'valueAsNumber'));
				});
			});			
	</script>
   <section>   
	<div class="container margin-top-40 center">   
<?php if(isset($order_credit['credits'])){ ?>                     
		<div class="padding-10 margin-bottom-20 border-theme">
			<p class="large">Credit Required - <?php echo $order_credit['credits']; ?> </p>
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<div class="row">
						<form action="<?php echo base_url().index_page()."lite/home/preorder/".$order_credit['id']; ?>" method="post">
							<div class="col-md-6 padding-right-0">
								<div><button class="form-control btn  btn-dark margin-top-10" type="submit" name="decline">Decline</button></div>
							</div>
							<div class="col-md-6 padding-right-0">
								<div><button class="form-control btn  btn-primary margin-top-10" type="submit" name="proceed">Proceed</button></div>
							</div>
						</form>	
					</div>
				</div>
			</div>
		</div>	
<?php } ?>	
		<p>Place New Order</p>  
           <a href="<?php echo base_url().index_page().'lite/home/print_ad';?>" class="btn btn-sm btn-dark btn-outline margin-right-5">Print Ad</a>
           <a href="<?php echo base_url().index_page().'lite/home/online_ad';?>" class="btn btn-sm btn-dark btn-active margin-right-5">Online Ad</a>
      </div>
   </section>
   
   <section>
    <div class="container margin-top-40"> 
<?php echo $this->session->flashdata('message'); ?>	
	<form role="form" action="" method="post" name="order_form" id="order_form" >
	  <div class="row">
		<div class="col-md-6 col-sm-6 col-xs-12">
		<!-- Advertiser Name -->
		   <p class="margin-bottom-5<?php if(null != form_error('advertiser_name')):?> text-red<?php endif;?>">Advertiser Name<?php if(null != form_error('advertiser_name')):?><span class="text-red"> Required</span>
		   <?php endif;?>
		   <span class="text-red">*</span><small class="text-grey"> (any alphanumeric of your choice)<span class="margin-left-5" data-toggle="tooltip" data-placement="right" data-html="true" title="Enter the Advertiser for whom this ad is being produced. <br/>You can use a combination of numbers and letters in this field. No special characters are allowed."> <i class="fa fa-info-circle"></i></span> </small>
		   </p>
		   <input type="text" name="advertiser_name" pattern="[a-zA-Z0-9 ]{1,50}" value="<?php echo set_value('advertiser_name');?>"
		   class="form-control input-sm margin-bottom-15" <?php if(null != form_error('advertiser_name')):?>style="border: 1px solid red"<?php endif;?> ng-model="job" required>		  
		<!-- Unique Job Name -->
		   <p class="margin-bottom-5<?php if(null != form_error('job_no')):?> text-red<?php endif;?>">
		   Unique Job Name / Number <?php if(null != form_error('job_no')): ?><span class="text-red"> Required</span><?php endif;?>		   				
		   <span class="text-red">*</span> <small class="text-grey">(any alphanumeric of your choice)<span class="margin-left-5" data-toggle="tooltip" data-placement="right" data-html="true" title="A combination of numbers and/or letters that you can use to identify and reference this ad internally. <br/>Again, no special characters allowed."> <i class="fa fa-info-circle"></i></span> </small>
		   </p>	
	       <input type="text" name="job_no" pattern="[a-zA-Z0-9 ]{1,50}" value="<?php echo set_value('job_no');?>"
		   class="form-control input-sm margin-bottom-15"  <?php if(null != form_error('job_no')):?>style="border: 1px solid red"<?php endif;?> required>
		<!-- max file size -->
			<p class="margin-bottom-5">
			Maximum File Size <span class="text-red">* </span><small class="text-grey">(In KBs)</small>
			</p>
	       <input type="text" name="maxium_file_size" value="<?php echo set_value('maxium_file_size');?>" class="form-control input-sm margin-bottom-15" title="" required="">
		<!-- copy_content_description -->
			<p class="margin-bottom-5<?php if(null != form_error('copy_content_description')):?> text-red<?php endif;?>">
			Copy, Content, Text <?php if(null != form_error('copy_content_description')): ?><span class="text-red"> Required</span>
		   <?php endif;?>	
		   <span class="text-red"> *</span><small class="text-grey margin-left-5" data-toggle="tooltip" data-placement="right" title="Enter the headline, body copy and footer content that goes into the ad. If possible please enter each part on a seperate line. This can prevent any obvious errors."> <i class="fa fa-info-circle"></i></small>
		   </p>
		   <textarea rows="3" name="copy_content_description" class="form-control input-sm margin-bottom-15" <?php if(null != form_error('copy_content_description')):?>style="border: 1px solid red"<?php endif;?> required><?php echo set_value('copy_content_description');?></textarea>
		</div>
		
	    <div class="col-md-6 col-sm-6 col-xs-12">
			<p class="margin-bottom-5">
			Format<span class="text-red"> * </span><small class="text-grey">(select one)</small>
			</p>
		    <div class="row margin-bottom-5">
			   <div class="col-sm-12">
				 <div class="btn-group" data-toggle="buttons">
				 
				<?php 
					$results = $this->db->get('lite_online_format')->result_array();
					  foreach($results as $result){
				?>
					<label class="btn btn-sm btn-default margin-right-10 margin-bottom-10">
						<input type="radio" id="ad_format<?php echo $result['id']; ?>" name="ad_format" value="<?php echo $result['id']; ?>" <?php echo set_radio('ad_format', $result['id']); ?> required> 
						<input type="hidden" id="static<?php echo $result['id']; ?>" name="static<?php echo $result['id']; ?>" value="<?php echo $result['static']; ?>">
						<input type="hidden" id="animated<?php echo $result['id']; ?>" name="animated<?php echo $result['id']; ?>" value="<?php echo $result['animated']; ?>">
						<?php echo $result['name']; ?>
					</label> 
				<?php } ?>
     			  </div>
				</div>   
			</div>
		   
		   <p class="margin-bottom-5">
		   Ad Type <span class="text-red">* </span><small class="text-grey">(select one)</small>
		   </p>
			<div class="row">
			   <div class="col-sm-12">
				 <div class="btn-group" data-toggle="buttons">
					<label id="web_ad_type_static" class="btn btn-sm btn-default margin-right-10 margin-bottom-10">
						<input type="radio" name="web_ad_type"  value="Static" <?php echo set_radio('web_ad_type', 'Static'); ?> required> Static
					</label> 
					<label id="web_ad_type_animated" class="btn btn-sm btn-default margin-right-10 margin-bottom-15">
						<input type="radio" name="web_ad_type" value="Animated" <?php echo set_radio('web_ad_type', 'Animated'); ?> required> Animated
					</label> 
				  </div>
			   </div>   
			</div>
			 		   
		   <p class="margin-bottom-5">
		   Size <span class="text-red">* </span><small class="text-grey">(in Pixels)</small>
		   </p>
		   <div class="row margin-bottom-15">
			   <div class="col-sm-12">
					<select class="form-control input-sm" name="pixel_size" required >
					  <option value="">Select</option>
					  <option value="1" <?php echo set_select('pixel_size', '1'); ?>>300 x 250(Medium Rectangle)</option>
					  <option value="2" <?php echo set_select('pixel_size', '2'); ?>>728 x 90(Leaderboard)</option>
					  <option value="3" <?php echo set_select('pixel_size', '3'); ?>>160 x 600(Wide Skyscraper)</option>
					  <option value="4" <?php echo set_select('pixel_size', '4'); ?>>300 x 600(Half Page Ad)</option>
					  <option value="5" <?php echo set_select('pixel_size', '5'); ?>>120 x 600(Skyscaper)</option>
					  <option value="6" <?php echo set_select('pixel_size', '6'); ?>>250 x 250(Square)</option>
					  <option value="7" <?php echo set_select('pixel_size', '7'); ?>>468 x 60(Full Banner)</option>
					  <option value="custom" <?php echo set_select('pixel_size', 'custom'); ?>>Custom</option>
					</select>
				</div>   
			</div>
			
			<div class="row margin-bottom-15 custom box">
	           <div class="col-md-6 col-sm-6 col-xs-6">
					 <p class="margin-bottom-5">Width <span class="text-red">*</span> <small class="text-grey">(in pixels)</small></p>
					 <input type="number" name="custom_width" value="<?php echo set_value('custom_width'); ?>" pattern="[1-9]{1,50}" min="1" class="form-control input-sm"></div>
			   <div class="col-md-6 col-sm-6 col-xs-6"> 
					<p class="margin-bottom-5">Height <span class="text-red">*</span> <small class="text-grey">(in pixels)</small></p>
					<input type="number" name="custom_height" value="<?php echo set_value('custom_height'); ?>" pattern="[1-9]{1,50}" min="1" class="form-control input-sm"></div>
			</div> 
			   
		   <p class="margin-bottom-5"> 
		   Notes &amp; Instructions<small class="text-grey margin-left-5" data-toggle="tooltip" data-placement="right" data-html="true" title="Please enter any special instructions for this ad. If we have to refer to a particular file or website, please indicate it here. Any special advertiser preferences or standard themes need to be mentioned here. <br/>Please be as specific as possible."> <i class="fa fa-info-circle"></i></small>
		   </p>
		   <textarea rows="3" name="notes" class="form-control input-sm margin-bottom-15"><?php echo set_value('notes');?></textarea>	
		</div> 
	  </div>
	
		<div class="row margin-bottom-5">
			<div class="col-md-12 col-sm-12 col-xs-12 text-grey">   
			<label><input id="showoptional" type="checkbox" class="margin-right-5">Check to view optional fields</label>
			</div>
		</div>	
	
	<div class="row" id="optional">
	   <div class="col-md-6 col-sm-6 col-xs-12">  
			<p class="margin-bottom-5">
			Date needed
			</p>	 
			<div class="input-group date date-picker margin-bottom-15" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
				<input id="date_needed" type="text" class="form-control input-sm" name="date_needed">
				<span class="input-group-btn">
				<button class="btn btn-sm btn-dark" type="button"><i class="fa fa-calendar"></i></button>
				</span>
			</div>
			
			<p class="margin-bottom-5">
			Publish Date
			</p>	 
			<div class="input-group date date-picker margin-bottom-15" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
				<input id="publish_date" type="text" class="form-control input-sm" name="publish_date">
				<span class="input-group-btn">
				<button class="btn btn-sm btn-dark" type="button"><i class="fa fa-calendar"></i></button>
				</span>
			</div>
			
		   <p class="margin-bottom-5">
		   Publication Name
		   </p>
	       <input type="text" name="publication_name" class="form-control input-sm margin-bottom-15" title="">
		   
		   <p class="margin-bottom-5">
		   Font Preferences 
		   </p>
	       <input type="text" name="font_preferences" class="form-control input-sm margin-bottom-15" title="">
		</div>
		
		<div class="col-md-6 col-sm-6 col-xs-12">  
		  <p class="margin-bottom-5">
		  Color Preferences
		  </p>
	      <input type="text" name="color_preferences" class="form-control input-sm margin-bottom-15" title="">
		   
		   <p class="margin-bottom-5">
		   Job Instructions <small class="text-grey">(select one)</small>
		   </p>
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
		
			<p class="margin-top-5 margin-bottom-5">
			Art Work <small class="text-grey">(select one)</small>
			</p>
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
	  
		<div class="row">	
			<div class="col-xs-12 text-right margin-top-5 margin-bottom-30">
				<div class="padding-top-15">
						<!--<?php if($publication['id']=='43' || $publication['id']=='13'){  ?> 
							<p><input type="checkbox" name="rush" value="1" class="margin-right-5"> 
							<span class="margin-right-10  text-grey"><label>Rush if possible</label></span>
						<?php } ?>	-->
							<?php $adrep = $this->db->get_where('adreps',array('id'=>$this->session->userdata('lcId')))->result_array();
								if($adrep[0]['rush']=='1') { ?>
							<p><input type="checkbox" name="rush" value="1" <?php echo set_checkbox('rush', '1'); ?>> 
							<span class="margin-right-10  text-grey"><label>Rush if possible</label></span>
							<?php } ?>
						<?php if(!isset($order_credit['credits'])){ ?>
						<!--<span>Total Credit Required: {{ sqinches_credits }}</span>-->
						<button type="submit" name="submit" value="Submit" class="btn btn-blue btn-sm">Submit</button>
						<?php } ?>
				</div>	
			</div>
		 </div>
	</div>
	</form>
	</div>
   </section>
	
		
<?php $this->load->view("lite/footer.php"); ?>
 <?php $this->load->view("lite/foot.php"); ?>		