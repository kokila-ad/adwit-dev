<?php $this->load->view('new_client/header');?>
		   <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>



<script type="text/javascript">
	$(document).ready(function(){
		$(".select").change(function(){
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
		$(".select").change(function(){
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
   
   <section>
    <div class="container margin-top-40">   
	<form method="post" name="order_form" id="order_form" >
	  <div class="row">
		
	   <div class="col-md-6 col-sm-6 col-xs-12">
			<p class="margin-bottom-5">Publications<span class="text-red">*</span></p>
		   <div class="btn-group2" data-toggle="buttons">	
			   <?php foreach($pub_list as $row){ ?>
					<label class="btn btn-sm btn-default margin-right-10 margin-bottom-15 wd-45" >	
						<input type="checkbox" name="pub_project_id[]" id="<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" >
						<?php echo $row['name']; ?>
					</label>
			   <?php } ?>
			</div>
	     
		   <p class="margin-bottom-5<?php if(null != form_error('advertiser_name')):?> text-red<?php endif;?>">Advertiser Name<?php if(null != form_error('advertiser_name')):?><span class="text-red"> Required</span>
		   <?php endif;?>
		   <span class="text-red">*</span><small class="text-grey"> (any alphanumeric of your choice)</small></p>
	       <input type="text" name="advertiser_name" value="<?php echo set_value('advertiser_name');?>"
		   class="form-control input-sm margin-bottom-15" <?php if(null != form_error('advertiser_name')):?>style="border: 1px solid red"<?php endif;?> required>		  
			
		   <p class="margin-bottom-5<?php if(null != form_error('job_no')):?> text-red<?php endif;?>">Unique Job Name / Number <?php if(null != form_error('job_no')): ?><span class="text-red"> Required</span><?php endif;?>		   				
		   <span class="text-red">*</span> <small class="text-grey">(any alphanumeric of your choice)</small> </p>
	       <input type="text" name="job_no" pattern="[a-zA-Z0-9 ]{1,50}" value="<?php echo set_value('job_no');?>"
		   class="form-control input-sm margin-bottom-15"  <?php if(null != form_error('advertiser_name')):?>style="border: 1px solid red"<?php endif;?> required>
		  
			<p class="margin-bottom-5">Publications<span class="text-red">*</span></p>
			<div class="row margin-bottom-5">
				<div class="col-sm-12">
					<div class="btn-group2" data-toggle="buttons">	
					<label class="btn btn-sm btn-default margin-right-10 margin-bottom-10 wd-45" >	
						<input type="checkbox" name="print_ad" value="2" >
						Print
					</label>
					<label class="btn btn-sm btn-default margin-right-10 margin-bottom-10 wd-45">	
						<input type="checkbox" name="online_ad" value="1" >
						Online
					</label>
					</div>
					<div id="form_color_error">
					</div>
				</div>   
			</div>
			
		</div>
		
	    <div class="col-md-6 col-sm-6 col-xs-12">
			
<!----- Start of Size -->		
			<?php if($publication['custom_sizes'] == '1') { ?>			
			<p class="margin-bottom-5 <?php if(null != form_error('orders_custom_sizes')):?> text-red<?php endif;?>">Size <?php if(null != form_error('orders_custom_sizes')): ?><span class="text-red">* </span><small class="text-grey">(in Pixels)</small></p>
			<?php endif;?>	
			<div class="row margin-bottom-15">
			   <div class="col-sm-12">
			   
					<select class="select form-control input-sm"  name="orders_custom_sizes" required>
						<option value="">Select</option>
						<?php 
							$custom_sizes = $this->db->get_where('orders_custom_sizes',array('pub_id' => $publication['id']))->result_array();
							//$custom_sizes = $this->db->query("SELECT * FROM `orders_custom_sizes`")->result_array();
							foreach($custom_sizes as $result){
								echo '<option value="'.$result['id'].'" '.set_select('orders_custom_sizes',$result['id']).' >'.$result['width'].' X '. $result['height'].' ('.$result['name'].') '.'</option>';	
							}
						?>
						<option value="custom" <?php echo set_select('orders_custom_sizes','custom'); ?>>Custom</option>
					</select>
		
				</div>   
			</div>
			<?php } ?>
			<div class="row margin-bottom-15 custom box">
	           <div class="col-md-6 col-sm-6 col-xs-6">
					 <p class="margin-bottom-5 <?php if(null != form_error('width')):?> text-red<?php endif;?>">Width <?php if(null != form_error('width')): ?></p><span class="text-red"> Required</span>
					  <?php endif;?>
					  <span class="text-red">*</span> <small class="text-grey">(in inches)</small>
					 <input type="number" id="width" name="width" max="99" min="0.5" step="0.0001"  class="form-control input-sm" <?php if(null != form_error('width')):?><?php endif;?> ><?php echo set_value('width');?>
				</div>
					 
					 
			   <div class="col-md-6 col-sm-6 col-xs-6"> 
					<p class="margin-bottom-5 <?php if(null != form_error('height')):?> text-red<?php endif;?> ">Height <?php if(null != form_error('height')): ?> </p><span class="text-red"> Required</span>
					<?php endif;?>
					<span class="text-red">*</span> <small class="text-grey">(in inches)</small>
					<input type="number" id="height" name="height" max="99" min="0.5" step="0.0001" class="form-control input-sm" <?php if(null != form_error('height')):?><?php endif;?>><?php echo set_value('height');?></div>
			</div> 
<!----- End of Size -->		
			
			<p class="margin-bottom-5<?php if(null != form_error('print_ad_type')):?> text-red<?php endif;?>">Color / B&W / Spot<?php if(null != form_error('print_ad_type')):?> Required
			<?php endif;?> 			
			<span class="text-red"> * </span><small class="text-grey">(select one)</small></p>
		    <div class="row margin-bottom-5">
			    <div class="col-sm-12">
					<div class="btn-group" data-toggle="buttons">
						<label class="btn btn-sm btn-default margin-right-10 margin-bottom-10">
							<input type="radio" name="print_ad_type" value="1" <?php echo set_radio('print_ad_type', '1'); ?> required> Color
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
		  
		<?php if($publication['enable_project']=='1'){ 
				$pub_project = $this->db->get_where('pub_project',array('pub_id' => $publication['id']))->result_array(); 
		?>	
		<p class="margin-bottom-5">Publication Name</p> 
			<select class="form-control input-sm margin-bottom-15"  name="project_id" >
				<option value="">Select</option> 
				<?php foreach($pub_project as $project){ ?>
				<option value="<?php echo $project['id']; ?>"><?php echo $project['name']; ?></option>
				<?php } ?>
			</select>   
		<?php } ?>
		   
		   <p class="margin-bottom-5"> Notes &amp; Instructions</p>
		   <textarea rows="3" name="notes" 
			data-max-length-warning="Input must be 5000 characters or less" 
			data-max-length="5000" 
			data-max-length-warning-container="name123"
			class=" js-max-char-warning123 form-control input-sm margin-bottom-15 txtLimit2 " id="yourtextarea2" type="text">
			</textarea>	
		  <div  style="color:red;"> <span class="name123"></span></div>
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
				<div class="input-group date date-picker margin-bottom-15" data-date-format="mm/dd/yyyy" data-date-start-date="+0d">
					<input id="date_needed" type="text" class="form-control input-sm" name="date_needed">
					<span class="input-group-btn">
					<button class="btn btn-sm btn-dark" type="button"><i class="fa fa-calendar"></i></button>
					</span>
				</div>
				
				<p class="margin-bottom-5">Publish Date</p>	 
				<div class="input-group date date-picker margin-bottom-15" data-date-format="mm/dd/yyyy" data-date-start-date="+0d">
					<input id="date_needed" type="text" class="form-control input-sm" name="publish_date">
					<span class="input-group-btn">
					<button class="btn btn-sm btn-dark" type="button"><i class="fa fa-calendar"></i></button>
					</span>
				</div>
			<?php if($publication['enable_project']=='0'){ ?>	
			   <p class="margin-bottom-5">Publication Name</p>
			   <input type="text" name="publication_name" class="form-control input-sm  margin-bottom-15" title="">
			<?php } ?>  
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
						<button type="submit" name="submit" onclick="required()" class="btn btn-blue btn-sm">Submit</button>
		   
				</div>	
			</div>
		 </div>
	</form>
	</div>
   </section>
	
</div>



<script>
$("#yourtextarea2").keyup(function(){
     
    });
    $(document).ready(function() {
        $('.txtLimit2').on('input propertychange', function() {
            CharLimit(this,5000);
        });
    });

    function CharLimit(input, maxChar) {
        var len = $(input).val().length;
        if (len > maxChar) {
            $(input).val($(input).val().substring(0, maxChar));
        }
    }
	
	
	
	$.fn.maxCharWarning = function() {

  return this.each(function() {
    var el                    = $(this),
        maxLength             = el.data('max-length'),
        warningContainerClass = el.data('max-length-warning-container'),
        warningContainer      = $('.'+warningContainerClass),
        maxLengthMessage      = el.data('max-length-warning')
    ;
    el.keyup(function() {
      var length = el.val().length;      
      if (length >= maxLength & warningContainer.is(':empty')){
        warningContainer.html(maxLengthMessage);
        el.addClass('input-error');
      }
      else if (length < maxLength & !(warningContainer.is(':empty'))) {
        warningContainer.html('');
        el.removeClass('input-error');
      }
    });
  });
};

$('.js-max-char-warning').maxCharWarning();
$('.js-max-char-warning123').maxCharWarning();

$("#yourtextarea1").keyup(function(){
    
    });
    $(document).ready(function() {
        $('.txtLimits1').on('input propertychange', function() {
            CharLimit(this,5000);
        });
    });

    function CharLimit(input, maxChar) {
        var len = $(input).val().length;
        if (len > maxChar) {
            $(input).val($(input).val().substring(0, maxChar));
        }
    }
</script>	
			
<?php if($this->session->userdata('ncId')=='36'){ $this->load->view('new_client/privacy_footer'); }else{ $this->load->view('new_client/footer'); } ?>		
