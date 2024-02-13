<style>
.ui-datepicker-inline.ui-datepicker.ui-widget.ui-widget-content.ui-helper-clearfix.ui-corner-all{
display:none !important;
}
td.ui-datepicker-unselectable.ui-state-disabled {
    color: #d4d4d4;
}
a.ui-state-default.ui-state-highlight.ui-state-active, a.ui-state-default.ui-state-active {
   background-color: grey;
    color: white;   
}
.ui-datepicker { width: 17em; padding: .2em .2em 0; display: none;background-color: white;
    border: 1px solid #c1c1c1; }
.ui-datepicker .ui-datepicker-header { position:relative; padding:.2em 0; }
.ui-datepicker .ui-datepicker-prev, .ui-datepicker .ui-datepicker-next { position:absolute; top: 10px; width: 1.8em; height: 1.8em; }
.ui-datepicker .ui-datepicker-prev-hover, .ui-datepicker .ui-datepicker-next-hover { top: 1px; }
.ui-datepicker .ui-datepicker-prev { left:2px; }
.ui-datepicker .ui-datepicker-next { right:2px; }
.ui-datepicker .ui-datepicker-prev-hover { left:1px; }
.ui-datepicker .ui-datepicker-next-hover { right:1px; }
.ui-datepicker .ui-datepicker-prev span, .ui-datepicker .ui-datepicker-next span { display: block; position: absolute; left: 50%; margin-left: -8px; top: 50%; margin-top: -8px;  }
.ui-datepicker .ui-datepicker-title { margin: 0 2.3em; line-height: 1.8em; text-align: center; }
.ui-datepicker .ui-datepicker-title select { font-size:1em; margin:1px 0; }
.ui-datepicker select.ui-datepicker-month-year {width: 100%;}
.ui-datepicker select.ui-datepicker-month, 
.ui-datepicker select.ui-datepicker-year { width: 49%;}
.ui-datepicker table {width: 100%; font-size: .9em; border-collapse: collapse; margin:0 0 .4em; }
.ui-datepicker th { padding: .7em .3em; text-align: center; font-weight: bold; border: 0;  }
.ui-datepicker td { border: 0; padding: 1px; }
.ui-datepicker td span, .ui-datepicker td a { display: block; padding: .2em; text-align: center; text-decoration: none; }
.ui-datepicker .ui-datepicker-buttonpane { background-image: none; margin: .7em 0 0 0; padding:0 .2em; border-left: 0; border-right: 0; border-bottom: 0; }
.ui-datepicker .ui-datepicker-buttonpane button { float: right; margin: .5em .2em .4em; cursor: pointer; padding: .2em .6em .3em .6em; width:auto; overflow:visible; }
.ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current { float:left; }

/* with multiple calendars */
.ui-datepicker.ui-datepicker-multi { width:auto; }
.ui-datepicker-multi .ui-datepicker-group { float:left; }
.ui-datepicker-multi .ui-datepicker-group table { width:95%; margin:0 auto .4em; }
.ui-datepicker-multi-2 .ui-datepicker-group { width:50%; }
.ui-datepicker-multi-3 .ui-datepicker-group { width:33.3%; }
.ui-datepicker-multi-4 .ui-datepicker-group { width:25%; }
.ui-datepicker-multi .ui-datepicker-group-last .ui-datepicker-header { border-left-width:0; }
.ui-datepicker-multi .ui-datepicker-group-middle .ui-datepicker-header { border-left-width:0; }
.ui-datepicker-multi .ui-datepicker-buttonpane { clear:left; }
.ui-datepicker-row-break { clear:both; width:100%; font-size:0em; }

/* RTL support */
.ui-datepicker-rtl { direction: rtl; }
.ui-datepicker-rtl .ui-datepicker-prev { right: 2px; left: auto; }
.ui-datepicker-rtl .ui-datepicker-next { left: 2px; right: auto; }
.ui-datepicker-rtl .ui-datepicker-prev:hover { right: 1px; left: auto; }
.ui-datepicker-rtl .ui-datepicker-next:hover { left: 1px; right: auto; }
.ui-datepicker-rtl .ui-datepicker-buttonpane { clear:right; }
.ui-datepicker-rtl .ui-datepicker-buttonpane button { float: left; }
.ui-datepicker-rtl .ui-datepicker-buttonpane button.ui-datepicker-current { float:right; }
.ui-datepicker-rtl .ui-datepicker-group { float:right; }
.ui-datepicker-rtl .ui-datepicker-group-last .ui-datepicker-header { border-right-width:0; border-left-width:1px; }
.ui-datepicker-rtl .ui-datepicker-group-middle .ui-datepicker-header { border-right-width:0; border-left-width:1px; }

/* IE6 IFRAME FIX (taken from datepicker 1.5.3 */
.ui-datepicker-cover {
    display: none; /*sorry for IE5*/
    display/**/: block; /*sorry for IE5*/
    position: absolute; /*must have*/
    z-index: -1; /*must have*/
    filter: mask(); /*must have*/
    top: -4px; /*must have*/
    left: -4px; /*must have*/
    width: 200px; /*must have*/
    height: 200px; /*must have*/
}/*
</style>
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css">
<?php $this->load->view('new_client/header');?>

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
<?php 
	$adrep = $this->db->get_where('adreps',array('id'=>$this->session->userdata('ncId')))->result_array();
?>
   <section>
      <div class="container margin-top-40 center">                        
		<p>Place New Order</p>
		<?php if($adrep[0]['print_ad']=='1'){  ?>
           <a href="<?php echo base_url().index_page().'new_client/home/print_ad';?>" class="btn btn-sm btn-dark btn-outline btn-active margin-right-5">Print Ad</a>
		<?php } ?>
		
		<?php if($adrep[0]['online_ad']=='1'){  ?>
           <a href="<?php echo base_url().index_page().'new_client/home/online_ad';?>" class="btn btn-sm btn-dark btn-outline">Online Ad</a>
		<?php } ?>
		
		<?php if($adrep[0]['pagedesign_ad']=='1'){  ?>
           <a href="<?php echo base_url().index_page().'new_client/home/page_proceed';?>" class="btn btn-sm btn-dark btn-outline">Pagination</a>
		<?php } ?>
		
      </div>
   </section>

   <section>
    <div class="container margin-top-40">   
	<form method="post" name="order_form" id="order_form" >
	  <div class="row">
		
	   <div class="col-md-6 col-sm-6 col-xs-12">
		   <p class="margin-bottom-5<?php if(null != form_error('advertiser_name')):?> text-red<?php endif;?>">Advertiser Name<?php if(null != form_error('advertiser_name')):?><span class="text-red"> Required</span>
		   <?php endif;?>
		   <span class="text-red">*</span><small class="text-grey"> (any alphanumeric of your choice)</small></p>
	       <input type="text" name="advertiser_name" value="<?php echo set_value('advertiser_name');?>"
		   class="form-control input-sm margin-bottom-15" <?php if(null != form_error('advertiser_name')):?>style="border: 1px solid red"<?php endif;?> required>		  
			
		   <p class="margin-bottom-5<?php if(null != form_error('job_no')):?> text-red<?php endif;?>">Unique Job Name / Number <?php if(null != form_error('job_no')): ?><span class="text-red"> Required</span><?php endif;?>		   				
		   <span class="text-red">*</span> <small class="text-grey">(any alphanumeric of your choice)</small> </p>
	       <input type="text" name="job_no" pattern="[a-zA-Z0-9 ]{1,50}" value="<?php echo set_value('job_no');?>"
		   class="form-control input-sm margin-bottom-15"  <?php if(null != form_error('advertiser_name')):?>style="border: 1px solid red"<?php endif;?> required>
		   
			
		   <p class="margin-bottom-5<?php if(null != form_error('copy_content_description')):?> text-red<?php endif;?>">Copy, Content, Text <?php if(null != form_error('copy_content_description')): ?><span class="text-red"> Required</span>
		   <?php endif;?>	
		   <span class="text-red"> *</span></p>
		   <textarea <?php if($publication['enable_project']=='1'){echo 'rows="6"';}else{echo 'rows="3"';} ?> name="copy_content_description"  
			data-max-length-warning="Input must be 5000 characters or less" 
			data-max-length="5000" 
			data-max-length-warning-container="name" class="js-max-char-warning form-control input-sm margin-bottom-15 txtLimits1 " type="text" id="yourtextarea1"  <?php if(null != form_error('copy_content_description')):?>style="border: 1px solid red"<?php endif;?> required><?php echo set_value('copy_content_description');?></textarea>	
		    <div  style="color:red;"> <span class="name"></span></div>
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
					 <input  id="width" name="width" max="99" min="0.5"  class="decimal form-control input-sm" <?php if(null != form_error('width')):?><?php endif;?> ><?php echo set_value('width');?>
				</div>
					 
					 
			   <div class="col-md-6 col-sm-6 col-xs-6"> 
					<p class="margin-bottom-5 <?php if(null != form_error('height')):?> text-red<?php endif;?> ">Height <?php if(null != form_error('height')): ?> </p><span class="text-red"> Required</span>
					<?php endif;?>
					<span class="text-red">*</span> <small class="text-grey">(in inches)</small>
					<input  id="height" name="height" max="99" min="0.5"  class="decimal form-control input-sm" <?php if(null != form_error('height')):?><?php endif;?>><?php echo set_value('height');?></div>
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
			data-max-length-warning-container="name123" class="js-max-char-warning form-control input-sm margin-bottom-15 txtLimit2 " type="text" id="yourtextarea2"></textarea>	
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
					<input id="date_needed" type="text" class="form-control input-sm datepickerautoff" autocomplete="off" name="date_needed">
					<span class="input-group-btn">
					<button class="btn btn-sm btn-dark" type="button"><i class="fa fa-calendar"></i></button>
					</span>
				</div>
				
				<p class="margin-bottom-5">Publish Date</p>	 
				<div class="input-group date date-picker margin-bottom-15" data-date-format="mm/dd/yyyy" data-date-start-date="+0d">
					<input id="publish_date" type="text" class="form-control input-sm datepickerautoff" autocomplete="off" name="publish_date">
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
					
							<?php if($adrep[0]['rush']=='1') { ?>
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
		    $(window).load(function(){
      
var dates = $("#date_needed, #publish_date").datepicker({
    minDate: "0",
    maxDate: "+2Y",
    defaultDate: "+1w",
    dateFormat: 'mm/dd/yy',
    numberOfMonths: 1,
    onSelect: function(date) {
        for(var i = 0; i < dates.length; ++i) {
            if(dates[i].id < this.id)
                $(dates[i]).datepicker('option', 'maxDate', date);
            else if(dates[i].id > this.id)
                $(dates[i]).datepicker('option', 'minDate', date);
        }
    } 
});
    });
			//decimal number restriction
$(function() {
  $('.decimal').on('input', function() {
    this.value = this.value
      .replace(/[^\d.]/g, '')             // numbers and decimals only
      .replace(/(^[\d]{4})[\d]/g, '$1')   // not more than 2 digits at the beginning
      .replace(/(\..*)\./g, '$1')         // decimal can't exist more than once
      .replace(/(\.[\d]{4})./g, '$1');    // not more than 4 digits after decimal
	 
      
  });
});

$('.datepickerautoff').on('click', function(e) {
				e.preventDefault();
				$(this).attr("autocomplete", "off");  
			});
</script>	
			
       <footer class="footer">
           <div class="footer-copyright ">
               <div class="page-footer">
					<div class="container">
						<div class="copyright">
							<p><?php $footer_copy = $this->db->query("SELECT * FROM `footer_copy`")->result_array(); 
		 echo $footer_copy[0]['footer_name'];  ?></p>
						</div>
						<div class="footer-nav margin-top-5">
							<nav class="padding-0">
								<ul>
									<li><a href="<?php echo base_url().index_page()."new_client/home/about"?>">About Us</a></li>
									<li><a href="<?php echo base_url().index_page()."new_client/home/contact_us"?>">Contact Us</a></li>
									<li><a href="<?php echo base_url().index_page()."new_client/home/terms_of_use"?>">Terms of Use</a></li>
									<li><a href="<?php echo base_url().index_page()."new_client/home/privacy_policy"?>">Privacy Policy</a></li>
								</ul>
							</nav>
						</div>
					</div>
				</div>
           </div><!-- /.footer-copyright -->          
        </footer>
        </div><!-- /#wrapper -->

	<script src="<?php echo base_url(); ?>assets/new_client/js/dropzone.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/new_client/js/datatables.min.js"></script>	  
    <script src="<?php echo base_url(); ?>assets/new_client/js/awe-hosoren.js"></script>	
	<script src="<?php echo base_url(); ?>assets/new_client/js/jquery-ui.min.js"></script>	
	<script src="<?php echo base_url(); ?>assets/new_client/js/plugins/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/new_client/js/plugins/awemenu.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/new_client/js/plugins/headroom.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/new_client/js/plugins/jquery.parallax-1.1.3.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/new_client/js/plugins/jquery.nanoscroller.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/new_client/js/plugins/list.min.js"></script>	
    <script src="<?php echo base_url(); ?>assets/new_client/js/main.js"></script>
	<script src="<?php echo base_url(); ?>assets/new_client/js/datepicker/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/new_client/js/datepicker/jquery.validate.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/new_client/js/datepicker/select2.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/new_client/js/datepicker/main.js"></script>
	<script src="<?php echo base_url(); ?>assets/new_client/js/datepicker/form-validation.js"></script>
	<script>
		jQuery(document).ready(function() {       
		FormValidation.init();
	});
	

	</script>
	<!-- end:js datepicker -->
    </body>
</html>


	
