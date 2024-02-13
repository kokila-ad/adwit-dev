<?php $this->load->view('new_client/header');?>         

<div id="main"> 
   <section>
      <div class="container margin-top-40 center">                        
		<p>Place New Order</p>  
           <a class="btn btn-sm btn-dark btn-outline btn-active">Page Design</a>
      </div>
   </section>
	
   <section>
     <div class="container margin-top-40">	 
		<form action="" method="post" name="order_form" id="order_form">
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-12">	
				
  
                    <p class="margin-bottom-5">Page Number <span class="text-red">*</span></p>
					<input type="number" min="0" step="1" name="job_no"  class="form-control input-sm input-sm input-sm input-sm margin-bottom-15" title="" required="">
                    
					<p class="margin-bottom-5">Name of Section  <span class="text-red">*</span><small class="text-grey"> (any alphanumeric of your choice)</small>  </p>
					<input type="text" name="section" pattern="[a-zA-Z0-9 ]{1,50}" class="form-control input-sm input-sm input-sm input-sm margin-bottom-15" title="" required="">
                   
					<p class="margin-bottom-5"> Color/B&amp;W<span class="text-red"> * </span><small class="text-grey">(select one)</small></p>
					<div class="btn-group" data-toggle="buttons">					
						<label class="btn btn-sm btn-default margin-right-10 margin-bottom-10">
						 <input type="radio" name="print_ad_type" value="1" required="" > Color
						</label> 
						<label class="btn btn-sm btn-default margin-right-10 margin-bottom-10">
						 <input type="radio" name="print_ad_type" value="2" required=""> B&amp;W
						</label> 
					</div>
					 
					<p class="margin-bottom-5">Note &amp; Instruction</p>
					<textarea rows="3" name="notes" style="margin: 0px -4px 15px 0px; height: 140px;" class="js-max-char-warning form-control input-sm input-sm input-sm input-sm margin-bottom-15 txtLimit" 
				    data-max-length-warning="Input must be 5000 characters or less" 
					data-max-length="5000" 
					data-max-length-warning-container="name"
					id="yourtextarea2"
					type="text"  ></textarea>	
					
				 <div style="color:red;" >   <span class="name"></span></div>
				</div>
				
				<div class="col-md-6 col-sm-6 col-xs-12">
					<div class="row margin-bottom-15">
					<div class="col-md-12 col-sm-12 col-xs-12">
					  <p class="margin-bottom-5">Content & Text<span class="text-red"> *</span></p>
					  <p action="<?php echo base_url().index_page().'new_client/home/page_ad_fileupload'.'/'.$orderid.'/content'; ?>" class="dropzone margin-bottom-15"> </p>
				    </div> 
                    </div>
					
					  <p class="margin-bottom-5">Attachments <span class="text-red">*</span> <small class="text-grey">(Only images)</small></p>
					  <p action="<?php echo base_url().index_page().'new_client/home/page_ad_fileupload'.'/'.$orderid; ?>" class="dropzone "> </p>
				</div> 
			</div>
			
            <div class="row">	
		      <div class="col-xs-12 text-right margin-top-5">
			     <div class="padding-top-15">
					<input type="hidden" name="orderid" value="<?php echo $orderid; ?>" >
				   <input class="btn btn-sm btn-blue" name="submit" type="submit" value="Order Now" id="submit_form">
			     </div>	
	          </div>
            </div>
		</form>
    </div>
</section>
</div>

<script>

	
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


$("#yourtextarea2").keyup(function(){
    
    });
    $(document).ready(function() {
        $('.txtLimit').on('input propertychange', function() {
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