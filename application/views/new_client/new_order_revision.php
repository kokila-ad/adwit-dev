<?php $this->load->view('new_client/header'); ?>

<div id="main">
<section id="revision">
    <div class="container"> 
	<div class="row margin-top-30">
		
		<form  method="post" >
			<div class="col-md-6 col-sm-6 col-xs-12">
			   <p class="margin-bottom-5">Production Notes <span class="text-red">*</span></p>
			   <span id="show">
					 <!--<textarea rows="7" name="notes" id="note" required class="form-control margin-bottom-15"></textarea>-->
					 <textarea rows="7" name="notes" required
                			data-max-length-warning="Input must be 5000 characters or less" 
                			data-max-length="5000" 
                			data-max-length-warning-container="name123" class="js-max-char-warning form-control margin-bottom-15 txtLimit2 " type="text" id="yourtextarea2">
                        </textarea>	
                		    <div  style="color:red;"> <span class="name123"></span></div>
			   </span>
			   <input type="text" id="cacheid" name="cacheid"  value="<?php echo $cacheid;?>" readonly style="display:none;"/> 
			   <input type="text" id="job_slug" name="job_slug"  value="<?php echo $slug;?>" readonly style="display:none;"/> 
			</div> 
		
    		<div class="col-md-6 col-sm-6 col-xs-12" id="show-drag">
    			<span class="margin-bottom-10">Attach Files</span>
    			 <div action="<?php echo base_url().index_page().'new_client/home/revision_order_fileupload'.'/'.$cacheid; ?>"  class="dropzone margin-top-5" > 
    				<div class="dz-default dz-message margin-top-50">You can attach or drag files here</div>
    			</div>
    		</div>
    
		    <button type="submit" class="btn btn-blue btn-sm margin-top-5 margin-bottom-20 pull-right" name="rev_submit" id="hide">Submit Revision</button>
		</form>
	</div> 
	</div>
</section>
</div>

<?php if($this->session->userdata('ncId')=='36'){ $this->load->view('new_client/privacy_footer'); }else{ $this->load->view('new_client/footer'); } ?>

<!-- text limit for notes and instructions -->
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


</script>