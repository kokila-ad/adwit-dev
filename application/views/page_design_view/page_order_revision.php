<?php $this->load->view('new_client/header'); ?>

<div id="main">
<section>
    <div class="container margin-top-30"> 
		<div class="row margin-0">	 
			<div class="col-md-2 col-sm-12 col-xs-12 margin-vertical-10 padding-0 text-grey">
				<span class="margin-right-15">AdwitAds ID: <span class="text-dark"><?php echo $order_details['id'];?></span></span>
			</div>
			<div class="col-md-4 col-sm-12 col-xs-12 margin-vertical-10 padding-0 text-grey">
				<span>Unique Job Name / Number: <span class="text-dark"><?php echo $order_details['job_no'];?></span></span>
			</div>
						
			<div class="col-md-6 col-sm-12 col-xs-12 margin-vertical-10 padding-0 text-right small">
				<span class="margin-right-5 text-grey">
					<a href="javascript:history.back()"><i class="fa fa-mail-reply padding-right-5 text-grey"></i></a>
				</span>
			</div>
		</div>
		<hr>
	</div>
</section>
		<!--<div class="container margin-top-5"> <?php echo $this->session->flashdata('message');?> -->
		
<section id="revision">
    <div class="container"> 
	<div class="row margin-top-10">
		
		<form  method="post" >
		    <div class="row">
        		<div class="col-md-6 col-sm-4 col-xs-12">
				<div class="form-group">
					<span>Articles / Images</span>
					<span class="dropdown margin-left-5 text-grey pull-right">
						<span class="cursor-pointer padding-left-5" type="button" data-toggle="dropdown" id="article-view" >
							View uploaded files 
							<span class="caret margin-left-5"></span>
						</span>
						<div class="table-responsive dropdown-menu file_li">
							<table class="table table-striped table-hover" id="mytable-article">
								<tbody>
									<?php $a=0;
										if(isset($articles_name)) 
										{ 
											$i=1;  
											foreach($articles_name as $row){?><!--This is listed the files -->
												<tr>
													<td><?php echo $i; ?></td>
													<td>
														<a href="<?php echo base_url().'page_design/revision/articles'.'/'.$Id.'/'.$rId.'/'.$row;?>" target="_blank">
															<?php echo $row?>
														</a>
													</td><!--This is path and name  option -->
													<td>
														<a href="<?php echo base_url().'page_design/articles'.'/'.$Id.'/'.$row;?>" download target="_blank" >
															<i class="fa fa-download"></i>
														</a>
													</td>
													<td>
														<input type="hidden" name="filename" id="article_name<?php echo $i;?>" value="<?php echo $row; ?>">
														<input type="button" name="remove" value="remove" onclick="remove_art(<?php echo $i;?>)"><!--This is remove file option -->
													</td>
												</tr>
									<?php   $a=$i++; 
											} 
										}?>
								</tbody>
							</table>
						</div>
					</span>
					<div id="attachments">
						<span><?php //echo $a ;?></span>
						<div action="<?php echo base_url().index_page()."new_client/home/page_revision_artical_upload/".$order_details['id'];?>" class="dropzone"> </div>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-4 col-xs-12">
				<div class="form-group">
					<span>Ads</span>
					<span class="dropdown margin-left-5 text-grey pull-right">
						<span class="cursor-pointer padding-left-5" type="button" data-toggle="dropdown" id="ads-view">
							View uploaded files 
							<span class="caret margin-left-5"></span>
						</span>
						<div class="table-responsive dropdown-menu file_li">  							 
							<table class="table table-striped table-hover" id="mytable-ads">
								<tbody>
									<?php 
									$a=0;
									if(isset($file_names1)) 
									{ 
										$i=1;  
										foreach($file_names1 as $row){?>
										<tr>
											<td><?php echo $i; ?></td>
											<td>
												<a href="<?php echo base_url().'page_design/ads'.'/'.$Id.'/'.$row;?>" target="_blank">
													<?php echo $row?>
												</a>
											</td>
											<td>
												<a href="<?php echo base_url().'page_design/ads'.'/'.$Id.'/'.$row;?>" download target="_blank" >
													<i class="fa fa-download"></i>
												</a>
											</td>
											<td>
												<input type="hidden" name="filename" id="ad_name<?php echo $i;?>" value="<?php echo $row;?>">
												<input type="button" name="remove" value="remove" onclick="remove_ad(<?php echo $i;?>)">
											</td>
										</tr>
								<?php   $a=$i++; 
										} 
									}?>
								</tbody>
							</table>
						</div>
					</span>
					<div id="attachments">
						<span><?php //echo $a ;?></span>
						<div action="<?php echo base_url().index_page()."new_client/home/page_revision_ads_upload/".$order_details['id'];?>" class="dropzone"> </div>
					</div>
				</div>
			</div>
    		</div>
    		<div class="row">
    			<div class="col-md-12 col-sm-12 col-xs-12">
    			   <p class="margin-bottom-5">Notes & Instructions <span class="text-red">*</span></p>
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
		    </div>
		    
		    <button type="submit" class="btn btn-blue btn-sm margin-top-5 margin-bottom-20 pull-right" name="rev_submit" id="hide">Submit Revision</button>
		</form>
		
	</div> 
	</div>
</section>
</div>

<?php if($this->session->userdata('ncId')=='36'){ $this->load->view('new_client/privacy_footer'); }else{ $this->load->view('new_client/footer'); } ?>
<!-- Listout files -->
<script>
       function RefreshTablePrint() { 
		   $( "#mytable-article" ).load( "<?php echo base_url().index_page()."new_client/home/page_list_download_files/".$order_details['id'].'/articles';?> #mytable-article" );
		   $( "#mytable-ads" ).load( "<?php echo base_url().index_page()."new_client/home/page_list_download_files/".$order_details['id'].'/ads';?> #mytable-ads" );
	   }
	   $("#article-view").on("click", RefreshTablePrint);
	   $("#ads-view").on("click",RefreshTablePrint);
</script>
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