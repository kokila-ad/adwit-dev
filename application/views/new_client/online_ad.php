<?php $this->load->view('new_client/header');?>
<script type="text/javascript">
			$(document).ready(function(){
				$("select").change(function(){
					$(this).find("option:selected").each(function(){
						if($(this).attr("value")=="custom"){
							$(".box").not(".custom").hide();
							$(".custom").show();
							$('#custom_width').attr('required', 'required');
							$('#custom_height').attr('required', 'required');
						}
					   else{
					        $('#custom_width').removeAttr('required');
							$('#custom_height').removeAttr('required');
							$(".box").hide();
						}
					});
				}).change();
			});
		</script>
		
<div id="main">
<?php   $adrep = $this->db->get_where('adreps',array('id'=>$this->session->userdata('ncId')))->result_array();  ?>      
    <section>
      <div class="container margin-top-40 center">                        
		<p>Place New Order</p> 
		<?php if($adrep[0]['print_ad']=='1'){  ?>
           <a href="<?php echo base_url().index_page().'new_client/home/print_ad';?>" class="btn btn-sm btn-dark btn-outline">Print Ad</a>
		<?php } ?>
		<?php if($adrep[0]['online_ad']=='1'){  ?>
           <a href="<?php echo base_url().index_page().'new_client/home/online_ad';?>" class="btn btn-sm btn-dark btn-outline btn-active margin-right-5">Online Ad</a>
		<?php } ?>
		<?php if($adrep[0]['pagedesign_ad']=='1'){  ?>
           <a href="<?php echo base_url().index_page().'new_client/home/page_proceed';?>" class="btn btn-sm btn-dark btn-outline">Pagination</a>
		<?php } ?>
      </div>
    </section>
    
        <?php //echo '<span style="color:#900;">'.$this->session->flashdata('message').'</span>';
        if ($this->session->flashdata('message')) {
                echo '<script>
                    $(document).ready(function() {
                        $("#errorModal").modal("show");
                    });
                </script>';
            }
        ?>	
        
	<section>
     <div class="container margin-top-40">   
	 <form method="post" name="order_form" id="order_form">
	  <div class="row">
	   <div class="col-md-6 col-sm-6 col-xs-12">
		   <p class="margin-bottom-5">Advertiser Name <span class="text-red">*</span></p>
	       <input type="text" name="advertiser_name" class="form-control input-sm margin-bottom-15" title="" required="">

		   <p class="margin-bottom-5">Unique Job Name / Number <span class="text-red">*</span> <small class="text-grey">(any alphanumeric of your choice)</small> </p>
	       <input type="text" name="job_no" class="form-control input-sm margin-bottom-15" title="" required="">
		  
 		   <p class="margin-bottom-5">Maximum File Size <span class="text-red">* </span><small class="text-grey">(In KBs)</small></p>
	       <input type="text" name="maximum_file_size" class="form-control input-sm margin-bottom-15" title="" required="">
		   
		   <p class="margin-bottom-5">Copy, Content, Text<span class="text-red"> *</span></p>
		   <textarea rows="3" name="copy_content_description" style="margin: 0px -4px 15px 0px; height: 140px;" 
			data-max-length-warning="Input must be 5000 characters or less" 
			data-max-length="5000" 
			data-max-length-warning-container="name" class="js-max-char-warning form-control input-sm margin-bottom-15 txtLimits1" id="yourtextarea1" required="" type="text"></textarea>
			 <div  style="color:red;"> <span class="name"></span></div>	   
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
					<label class="btn btn-sm btn-default margin-right-10 margin-bottom-10" onclick="ad_format(<?php echo $result['id']; ?>)">
						<input type="radio" name="ad_format" value="<?php echo $result['id']; ?>" required=""> 
						<?php echo $result['name']; ?>
					</label> 
					
						
		<?php } ?>
     <!--
					<label class="btn btn-sm btn-default margin-right-10 margin-bottom-10">
						<input type="radio" name="print_ad_type" value="1" required=""> JPEG
					</label> 
					<label class="btn btn-sm btn-default margin-right-10 margin-bottom-10">
						<input type="radio" name="print_ad_type" value="2" required=""> GIF
					</label> 
					<label class="btn btn-sm btn-default margin-right-10 margin-bottom-10">
						<input type="radio" name="print_ad_type" value="3" required=""> HTML5
					</label> 
					<label class="btn btn-sm btn-default margin-right-10 margin-bottom-10">
						<input type="radio" name="print_ad_type" value="4" required=""> SWF
					</label> 
					<label class="btn btn-sm btn-default margin-right-10 margin-bottom-10">
						<input type="radio" name="print_ad_type" value="5" required=""> EBLAST
					</label> -->
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
			
		<div id="size-div">
		   <p class="margin-bottom-5">Size <span class="text-red">* </span><small class="text-grey">(in Pixels)</small></p>
		   <div class="row margin-bottom-15">
			   <div class="col-sm-12">
					<select class="form-control input-sm" name="pixel_size" id="pixel_size" >
					  <option value="">Select</option>
					  <?php  $pixel_sizes = $this->db->get('pixel_sizes')->result_array();
								foreach($pixel_sizes as $row)
								{
						?>
						<option value="<?php echo $row['id']; ?>" ><?php echo $row['width'].' X '.$row['height'].' ('.$row['name'].')'; ?></option>
					  <?php } ?>
					  <option value="custom">Custom</option>
					</select>
				</div>   
			</div>
		</div>
	<!-- flexitive_size -->	
		<div id="flexitive-size-div" style="display:none">
		   <p class="margin-bottom-5">Size <span class="text-red">* </span><small class="text-grey">(in ratio)</small></p>
		   <div class="row margin-bottom-15">
			   <div class="col-sm-12">
					<select class="form-control input-sm" name="flexitive_size" id="flexitive_size" >
					  <option value="">Select</option>
						<?php 
							$flexitive_size = $this->db->get('flexitive_size')->result_array(); 
							foreach($flexitive_size as $result){ 
								echo '<option value="'.$result['id'].'" >'.$result['ratio'].' ('.$result['text'].')</option>';
							} 
						?>
					</select>
				</div>   
			</div>
		</div>
	<!-- flexitive_size End -->
			<div class="row margin-bottom-15 custom box">
	           <div class="col-md-6 col-sm-6 col-xs-6">
					 <p class="margin-bottom-5">Width <span class="text-red">*</span> <small class="text-grey">(in Pixels)</small></p>
					 <input type="number" name="custom_width" id="custom_width" pattern="[1-9]{1,50}" min="1" class="form-control input-sm"></div>
			   <div class="col-md-6 col-sm-6 col-xs-6"> 
					<p class="margin-bottom-5">Height <span class="text-red">*</span> <small class="text-grey">(in Pixels)</small></p>
					<input type="number" name="custom_height" id="custom_height" pattern="[1-9]{1,50}" min="1" class="form-control input-sm"></div>
			</div> 
					
		  <p class="margin-bottom-5">Notes & Instructions</p>
		   <textarea rows="3" name="notes" style="margin: 0px -4px 15px 0px; height: 140px;" 
			data-max-length-warning="Input must be 5000 characters or less" 
			data-max-length="5000" 
			data-max-length-warning-container="name123" class="js-max-char-warning123 form-control input-sm margin-bottom-15 txtLimit2" id="yourtextarea2" type="text"></textarea>	
			 <div  style="color:red;"> <span class="name123"></span></div>	   
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
	  
	  <div class="row">
		<div class="col-xs-12 text-right margin-top-5">
			<div class="padding-top-15">
			<!--<?php if($publication['id']=='43' || $publication['id']=='13'){ ?>
				<span class="margin-right-10 text-grey"><label><input type="checkbox" name="rush" value="1" class="margin-right-5">Rush</label></span>
			<?php } ?>-->
				<?php if($adrep[0]['rush']=='1') { ?>
							<p><input type="checkbox" name="rush" value="1" class="margin-right-5"> 
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

<!-- Modal -->
<style>
    .modal-backdrop {
    display:none;
}

</style>
<div class="modal" id="errorModal" tabindex="-1"  role="dialog" aria-labelledby="confirmationModalTitle" >
 <div class="modal-dialog modal-dialog-centered" role="document" style="width:700px;">
    <div class="modal-content" style="width:85%">
      <div class="modal-header" style="border-bottom: 0 !important;background-color:#333 !important;">
        <h5 class="modal-title portlet-title margin-top-10" id="errorModal" style="margin-top: 0px !important; padding:10px !important;"><center><b>Alert</b></center></h5>
      </div>
      <div class="modal-body" style="padding: 15px 16px;">
          <h4 style="color:#900;"><?php echo $this->session->flashdata('message')?></h4>
      </div>
      <div class="modal-footer" style="background-color:#fff !important;">
        <button type="button" class="btn btn-warning" data-dismiss="modal" >Close</button>
      </div>
    </div>
  </div>
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
	
	function ad_format(id){
		if(id == 5){
			$('#size-div').hide();
			$('#flexitive-size-div').show();
			
			$('#pixel_size').removeAttr('required');
			$('#flexitive_size').attr('required', 'required');
		}else{
			$('#size-div').show();
			$('#flexitive-size-div').hide();
			
			$('#flexitive_size').removeAttr('required');
			$('#pixel_size').attr('required', 'required');
		}
	}
</script>	

            		
<?php if($this->session->userdata('ncId')=='36'){ $this->load->view('new_client/privacy_footer'); }else{ $this->load->view('new_client/footer'); } ?>