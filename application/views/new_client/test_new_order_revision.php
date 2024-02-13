<?php $this->load->view('new_client/header'); ?>
<style>
    .active > a{
                color: #d71a22 !important;
                border-color: #333;
                background: #e1e1e100 !important;
            }
    
    .panel-heading .accordion-toggle:after {
        /* symbol for "opening" panels */
        font-family: 'Glyphicons Halflings';  /* essential for enabling glyphicon */
        content: "\e114";    /* adjust as needed, taken from bootstrap.css */
        float: right;        /* adjust as needed */
        color: rgb(255, 255, 255);         /* adjust as needed */
        
    }
    .panel-heading {
       border-top-right-radius: 0px !important;
        border-top-left-radius: 0px !important;
    }
    .panel-default {
        border-color: #808080 !important;
    }
    .panel-group .panel + .panel {
        margin-top: 0px !important;
    }
    .panel-heading .accordion-toggle.collapsed:after {
        /* symbol for "collapsed" panels */
        font-family: 'Glyphicons Halflings';  /* essential for enabling glyphicon */
        content: "\e080";   /* adjust as needed, taken from bootstrap.css */
        float: right;        /* adjust as needed */
        color: rgb(255, 255, 255);  
    }
    .panel-heading {
        background-color: #989898;
    }
    .panel-heading.collapsed {
        background-color: #d8d8d8;
    }
    iframe {
        width: 100%;
        height: 300px;
    }
    @font-face {
    font-family: 'Glyphicons Halflings';
    src: url('https://netdna.bootstrapcdn.com/bootstrap/3.0.0/fonts/glyphicons-halflings-regular.eot');  src: url('https://netdna.bootstrapcdn.com/bootstrap/3.0.0/fonts/glyphicons-halflings-regular.eot?#iefix') format('embedded-opentype'), url('https://netdna.bootstrapcdn.com/bootstrap/3.0.0/fonts/glyphicons-halflings-regular.woff') format('woff'), url('https://netdna.bootstrapcdn.com/bootstrap/3.0.0/fonts/glyphicons-halflings-regular.ttf') format('truetype'), url('https://netdna.bootstrapcdn.com/bootstrap/3.0.0/fonts/glyphicons-halflings-regular.svg#glyphicons-halflingsregular') format('svg');
    
     
    
    }
</style>
<style>
    .awe-nav > li > a {
        bottom: -1px !important;
        border: solid 1px #e1e1e1 !important;
        border-bottom: 0px !important; 
    }
    iframe {
        width: 100%;
        height: 500px;
    }
</style>
<?php
    $annotation_file = '';
    if(isset($latest_order_cache['file_path']) && file_exists($latest_order_cache['file_path'])){
        //retrieve partially saved pdf annotation
        $pdf_annotation =  $latest_order_cache['file_path'].'/order_annotation/'.$order_details['id'].'.pdf';
        if(file_exists($pdf_annotation)){
            $annotation_file = $order_details['id'].'.pdf';;
            $pdf_annotation_url = base_url().$pdf_annotation;
        }elseif(isset($orders_rev['id'])){
            $annotation_file = basename($orders_rev['pdf_path']);
            $pdf_annotation_url = base_url().$orders_rev['pdf_path'];
        }else{
            $annotation_file = basename($order_details['pdf']);
            $pdf_annotation_url = base_url().$order_details['pdf'];
        }
    }else{
        //get the latest version PDF
        if(isset($orders_rev['id'])){
            $annotation_file = basename($orders_rev['pdf_path']);
            $pdf_annotation_url = base_url().$orders_rev['pdf_path'];
        }else{
            $annotation_file = basename($order_details['pdf']);
            $pdf_annotation_url = base_url().$order_details['pdf'];
        }
    }
    //echo $pdf_annotation_url;
?>
<div id="main">
<section>
    <div class="container margin-top-30"> 
		<div class="row margin-0">	 
			<div class="col-md-2 col-sm-12 col-xs-12 margin-vertical-10 padding-0 text-grey">
				<span class="margin-right-15">AdwitAds ID: <span class="text-dark"><?php echo $order_details['id'];?></span></span>
			</div>
			<?php 
    			if($order_details['order_type_id'] == '6'){
    		?>
            		<div class="col-md-4 col-sm-12 col-xs-12 margin-vertical-10 padding-0 text-grey">
        				<span>Publication/Edition Name: <span class="text-dark"><?php echo $order_details['advertiser_name'];?></span></span>
        			</div>
    		<?php
    			}else{
			?>
        			<div class="col-md-4 col-sm-12 col-xs-12 margin-vertical-10 padding-0 text-grey">
        				<span>Unique ID: <span class="text-dark"><?php echo $order_details['job_no'];?></span></span>
        			</div>
			<?php } ?>			
			<div class="col-md-6 col-sm-12 col-xs-12 margin-vertical-10 padding-0 text-right small">
				<span class="margin-right-5 text-grey">
					<a href="javascript:history.back()"><i class="fa fa-mail-reply padding-right-5 text-grey"></i></a>
				</span>
			</div>
		</div>
		<hr>
	</div>
</section>
<section>
      <div class="container margin-top-20">         
    	<div class="row margin-0">
    	    <form  method="post" >	
			  <div role="tabpanel"> 
			    
				<div class="col-md-12 padding-0  zindex" style="text-align: center;">	
					<div class="awe-nav-responsive">
						<ul class="awe-nav" role="tablist">
						 
                            <li role="presentation" data-id="markUp" class="tab active " data-toggle="tooltip" data-placement="bottom" title="Annotate your Proof and click Save directly in this window">
								<a href="#docs-tabs-1" title="" class="" aria-controls="docs-tabs-1" role="tab" data-toggle="tab">
                                <span class="padding-right-5"></span>Markup the Proof and Save </a>
							</li>
                        
							<li role="presentation" data-id="attachFile" class="tab " data-toggle="tooltip" data-placement="bottom" title="Send images, text or other files that you want in the ad">
								<a href="#docs-tabs-3" title="" aria-controls="docs-tabs-2" role="tab" data-toggle="tab"><span class="padding-right-5"></span>Attach files</a>
							</li>
							
							<li role="presentation" data-id="notesInstructions" class="tab " data-toggle="tooltip" data-placement="bottom" title="Additional comments, instructions or guidelines you want us to follow">
								<a href="#docs-tabs-2" title="" aria-controls="docs-tabs-2" role="tab" data-toggle="tab"><span class="padding-right-5"></span>Production Notes</a>
							</li>	
						</ul>
					</div>
				</div>
			    	
                <div class="col-md-12 padding-0 border left-2 ">
					<div class="padding-20">
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="docs-tabs-1">
                                <div class="text-muted">
                                  <div class="panel-group" id="accordion">	
                                    <div id="adobe-dc-view" style="height: 1000px"></div>
                                    
                                </div>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane fade " id="docs-tabs-3">
                                <div class="text-muted">
                                   <div class="panel-group" id="accordion">		
                                    <div class="tooltip">Hover over me
                                      <span class="tooltiptext">Tooltip text</span>
                                    </div>
										<div action="<?php echo base_url().index_page().'new_client/home/revision_order_fileupload'.'/'.$cacheid; ?>"   class="dropzone margin-top-5" > 
                                            <div class="dz-default dz-message margin-top-50">You can attach or drag files here</div>
                                        </div>									
									</div>
								</div>
							</div>
							
							 <div role="tabpanel" class="tab-pane fade" id="docs-tabs-2">
                                <div class="text-muted">
                                    <div class="panel-group" id="accordion">		
                                        <span id="show">
                                            <textarea rows="7" name="notes" data-max-length-warning="Input must be 5000 characters or less" data-max-length="5000" 
                			                data-max-length-warning-container="name123" class="js-max-char-warning form-control margin-bottom-15 txtLimit2 " 
                			                type="text" id="yourtextarea2"></textarea>	
                		                    <div  style="color:red;"> <span class="name123"></span></div>
                                        </span>
                                        <input type="text" id="cacheid" name="cacheid"  value="<?php echo $cacheid; ?>" readonly style="display:none;"/> 
                                        <input type="text" id="job_slug" name="job_slug"  value="<?php echo $slug;?>" readonly style="display:none;"/> 
                                   </div>
								</div>                         
							</div>
					</div>
				</div>
			</div>
			  </div>
			  <div id="markup_instruction_id" style="text-align:right;color:#898989">Mark up and save the pdf to enable Submit Revision</div>
			  <button type="submit" style="border-radius: 10px;" class="btn btn-blue btn-sm margin-top-5 margin-bottom-20 pull-right" name="rev_submit" id="btn-submit-revision">Submit Revision</button>
		</form>
		 </div>	
	  </div>		
</section><!-- /section -->

</div>

<?php if($this->session->userdata('ncId')=='36'){ $this->load->view('new_client/privacy_footer'); }else{ $this->load->view('new_client/footer'); } ?>

<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>

<script src="https://documentcloud.adobe.com/view-sdk/main.js"></script> 

<script type="text/javascript">

	document.addEventListener("adobe_dc_view_sdk.ready", function(){ 

		var adobeDCView = new AdobeDC.View({clientId: "9962a6efddab4b0391adc0fd311e55ab", divId: "adobe-dc-view"});

		adobeDCView.previewFile({

			//content:{location: {url: "<%=pdfName%>"}},

			content:{location: {url: "<?php echo $pdf_annotation_url; ?>"}},

			//content:{location: {url: "https://documentcloud.adobe.com/view-sdk-demo/PDFs/Bodea Brochure.pdf"}},

			metaData:{fileName: "<?php echo $annotation_file; ?>"},
			
			defaultViewMode: "FIT_PAGE"

		}, {});//IN_LINE

	/* Register save callback */ 

        adobeDCView.registerCallback(

            AdobeDC.View.Enum.CallbackType.SAVE_API,

            function (metaData, content, options) {

                console.log(metaData);

                console.log(content);

                

                var base64PDF = arrayBufferToBase64(content);

                var formData = new FormData();

                formData.append('content', base64PDF);

                var submitRevision = document.getElementById('btn-submit-revision');
                
                submitRevision.disabled = true;
                submitRevision.innerHTML = 'Saving..';


                $.ajax({  

		  		       url : "<?php echo base_url().index_page().'new_client/home/revision_order_annotation/'.$cacheid; ?>",  

		  		       type : 'POST',

		  		     enctype: 'multipart/form-data',

		  		     data: formData,

		  		   processData: false,

		            contentType: false,

		            cache: false,

		            timeout: 600000, 

		  		   success : function(response) {
                        //submitRevision.style.display = 'block';
		  			    submitRevision.disabled = false; //console.log(response);
		  			    submitRevision.innerHTML = 'Submit Revision';

		  		   }

				});

                

				console.log('Uploaded a file!');

				

                return new Promise(function (resolve, reject) {

                    /* Dummy implementation of Save API, replace with your business logic */

                    setTimeout(function () {

                        var response = {

                            code: AdobeDC.View.Enum.ApiResponseCode.SUCCESS,

                            data: {

                                metaData: Object.assign(metaData, { updatedAt: new Date().getTime() })

                            },

                        };

                        resolve(response);

                    }, 2000);

                });

            }

        );

		

	});


	function arrayBufferToBase64(buffer) {

        var binary = "";

        var bytes = new Uint8Array(buffer);

        var len = bytes.byteLength;

        for (var i = 0; i < len; i++) {

            binary += String.fromCharCode(bytes[i]);

        }

        return window.btoa(binary);

    }

</script>
<!-- text limit for notes and instructions -->
<script>
$("#yourtextarea2").keyup(function(){
     
    });
    $(document).ready(function() {
        //$("#btn-submit-revision").hide(); //hide submit revision button initially
        $("#btn-submit-revision").prop('disabled', true);
        $('.txtLimit2').on('input propertychange', function() {
            CharLimit(this,5000);
        });
    });
    
    $(".tab").on('click', function(){
        var id = $(this).data('id'); //alert("hello"+id);    
        if(id == 'markUp'){
            //$("#btn-submit-revision").hide(); 
            $("#btn-submit-revision").prop('disabled', true);
           $("#markup_instruction_id").css('display', 'block');
        }else{
            //$("#btn-submit-revision").show(); 
            $("#btn-submit-revision").prop('disabled', false);
            $("#markup_instruction_id").css('display', 'none');
        }
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