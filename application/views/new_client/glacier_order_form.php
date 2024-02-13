<?php $this->load->view('new_client/header');?>
<style>
	.dropzone {
    display: block;
    background-image: url(../img/attachment.png);
}

.file_li {
   // width: 350px;
	min-width: 250px;
   // overflow-x: hidden;
}

.lightbox-opened {
  background-color: #333;
  background-color: rgba(51, 51, 51, 0.9);
  cursor: pointer;
  height: 100%;
  left: 0;
  overflow-y: scroll;
  padding: 24px;
  position: fixed;
  text-align: center;
  top: 0;
  width: 100%;
}
.lightbox-opened:before {
  background-color: #333;
  background-color: rgba(51, 51, 51, 0.9);
  color: #eee;
  content: "x";
  font-family: sans-serif;
  padding: 6px 12px;
  position: fixed;
  text-transform: uppercase;
}
.lightbox-opened img {
  box-shadow: 0 0 6px 3px #333;
}

.no-scroll {
  overflow: hidden;
}
.awemenu-nav {
   z-index: 0 !important;
}
#header{
    display: contents !important;
	}
</style>

<style class="cp-pen-styles">

/** LIGHTBOX MARKUP **/

.lightbox {
	/** Default lightbox to hidden */
	display: none;

	/** Position and style */
	position: fixed;
	z-index: 999;
	width: 100%;
	height: 100%;
	text-align: center;
	top: 0;
	left: 0;
	background: rgba(0,0,0,0.8);
}

.lightbox img {
	/** Pad the lightbox image */
	max-width: 90%;
	max-height: 80%;
	margin-top: 2%;
}

.lightbox:target {
	/** Remove default browser outline */
	outline: none;

	/** Unhide lightbox **/
	display: block;
}
.thumbnail {
    display: block;
   /*height: 100px;*/
    width: 120px;
        padding: 0px;
    margin-bottom: 17px;
}
/* The Close Button */
.close {
  color: white;
  position: absolute;
  top: 10px;
  right: 25px;
  font-size: 35px;
  font-weight: bold;
  opacity: 2.2;
}

.close:hover,
.close:focus {
  color: #999;
  text-decoration: none;
  cursor: pointer;
}
</style>

<style>
.side_alignr{
    position: relative !important;
    left: 5px !important;
	}
	.side_alignl{
    position: relative !important;
    right: 5px !important;
	}
.thumbnail {
    display: block;
       padding: 0px !important;
    margin-bottom: 20px;
    line-height: 1.42857;
    background-color: #fff !important;
    border: 0px solid #ddd !important;
    border-radius: 0px !important;
    transition: border 0.2s ease-in-out;
}
.file_li {
   // width: 350px;
	min-width: 250px;
   // overflow-x: hidden;
}
.radiobtn {
    margin-left: 40.66667% !important;
	
}
.outer{
    line-height: 1.42857;
    background-color: #fff;
    border: 1px solid #fff;
	}

	.margin-top-70 {
    margin-top: 35px !important;
}

 .col-md-4{
    padding-left: 5px !important;
    padding-right: 5px !important;
}
.headfont{
text-align:center; font-weight: 600;   margin-top: 10px;
}
#moodboard_upload{
       height: 593px !important;
    margin-bottom: 24px;
	}
	 .dropzone .dz-message {
   
    margin-top: 120% ;
  
}
@media only screen and (min-width: 426px) and (max-width: 768px) {
.thumbnail{
margin-left: 40px;
}
#moodboard_upload {
    height: 160px !important;
    margin-bottom: 17px;
}
.dropzone .dz-message {
    margin-top: 9%;
}
.clean {
    border-top: solid 0px #000000 !important;
    border-bottom: solid 0px #000000 !important;
	border-right: solid 1px #000000 !important;
    border-left: solid 1px #000000 !important;
}
.different {
    border-top: solid 1px #000000 !important;
    border-left: solid 1px #000000 !important;
    border-bottom: solid 0px #000000 !important;
    border-right: 1px solid #000000 !important;
}
.headfont {
    text-align: center;
    font-weight: 600;
    margin-top: 0px !important;
    position: relative !important;
    top: 5px !important;
	    right: 15px;
}
}
@media only screen and (min-width: 376px) and (max-width: 425px) {


#moodboard_upload {
    height: 160px !important;
    margin-bottom: 17px;
}
.dropzone .dz-message {
    margin-top: 9%;
}
.clean {
    border-top: solid 0px #000000 !important;
    border-bottom: solid 0px #000000 !important;
	border-right: solid 1px #000000 !important;
    border-left: solid 1px #000000 !important;
}
.different {
    border-top: solid 1px #000000 !important;
    border-left: solid 1px #000000 !important;
    border-bottom: solid 0px #000000 !important;
    border-right: 1px solid #000000 !important;
}
.headfont {
    text-align: center;
    font-weight: 600;
    margin-top: 0px !important;
    position: relative !important;
    top: 5px !important;
	    right: 15px;
}
.headfont {
    text-align: center;
    font-weight: 600;
    margin-top: 0px !important;
    position: relative !important;
    top: 5px !important;
    right: 12px ;
}
}
@media only screen and (max-width: 320px) {

#moodboard_upload {
    height: 160px !important;
    margin-bottom: 17px;
}
.dropzone .dz-message {
    margin-top: 9%;
}
.clean {
    border-top: solid 0px #000000 !important;
    border-bottom: solid 0px #000000 !important;
	border-right: solid 1px #000000 !important;
    border-left: solid 1px #000000 !important;
}
.different {
    border-top: solid 1px #000000 !important;
    border-left: solid 1px #000000 !important;
    border-bottom: solid 0px #000000 !important;
    border-right: 1px solid #000000 !important;
}
.headfont {
    text-align: center;
    font-weight: 600;
    margin-top: 0px !important;
    position: relative !important;
    top: 5px !important;
	    right: 15px;
}
}
@media only screen and (min-width: 321px) and (max-width: 375px) {

#moodboard_upload {
    height: 160px !important;
    margin-bottom: 17px;
}
.dropzone .dz-message {
    margin-top: 9%;
}
.clean {
    border-top: solid 0px #000000 !important;
    border-bottom: solid 0px #000000 !important;
	border-right: solid 1px #000000 !important;
    border-left: solid 1px #000000 !important;
}
.different {
    border-top: solid 1px #000000 !important;
    border-left: solid 1px #000000 !important;
    border-bottom: solid 0px #000000 !important;
    border-right: 1px solid #000000 !important;
}
.headfont {
    text-align: center;
    font-weight: 600;
    margin-top: 0px !important;
    position: relative !important;
    top: 5px !important;
	    right: 15px;
}
.headfont {
  
    right: 4px;
}
}
.radbtn{
  margin-left: 47.66667% !important;
  }
  .clean{
    border-top: solid 1px #000000;
    border-bottom: solid 1px #000000;
	}
	.different{
	  border-top: solid 1px #000000; border-left: solid 1px #000000;
    border-bottom: solid 1px #000000;
	}
	.tabhead{
	    text-align: center;
    position: relative;
       border-bottom: 1px solid black;
    background-color: #929191;
    color: white;
    padding: 5px;
	}
	.border {
    border: solid 1px #000000;
}
.img_row{
    margin-right: -5px !important;
	}
	
@media only screen and  (max-width: 990px) {
.dropzone .dz-message {
   margin-top: 14% !important;
}
#moodboard_upload {
   height: 222px !important;
   margin-bottom: 24px;
}
}
@media only screen and (min-width: 991px) and (max-width: 1200px) {
#moodboard_upload {
   height: 488px !important;
   margin-bottom: 24px;
}
}	
</style>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/new_client/js/angular.js"/></script>
<script type="text/javascript">
	var app = angular.module('myApp', []);
		app.controller('checkboxController',['$scope' , function($scope){  
			$scope.toggle = function(condition){
				if (condition) {
				  $scope.data = "Copy file attached";
				}    
				else $scope.data = '';
			  }
	}]);
</script>

<style> .fa-info-circle { cursor: pointer; } 
.paddinh-horizontal-30: padding-left: 30px; padding-right: 30px;}
</style>

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
		
		$("#mood_board_opt").hide();	
        $("#show_mood_board").click(function(){
			$("#mood_board_opt").toggle(); 
			$("#no_os_submit").toggle();
        });
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

<script>
$(document).ready(function(){
	$("#copy").click(function(){
			var copy = document.getElementbyid("copy");
			if(copy.checked = true)
			{
				alert("CHecked");
			}
		
		
	});

	
});

Dropzone.options.dropzonefileupload = {
	init: function() {
		this.on("sending", function(file)
		{ 
			 var string1_value = "Image2.jpg";
			 var input_file_value = file.name;
			 var string2_value = input_file_value.substr(0, input_file_value.lastIndexOf('.'));
			if(string1_value != string2_value )
			{
				alert("Wrong file. File will be removed");
				this.removeFile(file);
			}
		 });
	}
};

</script>
<div id="main"> 
   <section>
      <div class="container margin-top-40 center">                        
		   <a href="<?php echo base_url().index_page().'new_client/home/glacier_order_print';?>" class="btn btn-sm btn-dark btn-outline btn-active margin-right-5">Print Ad</a>
           <a href="<?php echo base_url().index_page().'new_client/home/glacier_order_online';?>" class="btn btn-sm btn-dark btn-outline margin-right-5">Online Ad</a>
      </div>
   </section>
	
   <section>
   <!--<span style="margin-left: 20px; padding: 0 10px;" class="font-blue"><?php //echo $this->session->flashdata('message'); ?></span>-->
     <?php if ($this->session->flashdata('message')) {
        echo '<script>
            $(document).ready(function() {
                $("#errorModal").modal("show");
            });
        </script>';
    } ?>
    <div class="container margin-top-40">   
	<form method="post" name="order_form" id="order_form">
	<!-- Required primary fields END -->
	<div class="row">
	    <div class="col-md-6 col-sm-6 col-xs-12"  ng-app="myApp" ng-controller="checkboxController">
		   <p class="margin-bottom-5<?php if(null != form_error('advertiser_name')):?> text-red<?php endif;?>">Advertiser Name<?php if(null != form_error('advertiser_name')):?><span class="text-red"> Required</span>
		   <?php endif;?>
		   <span class="text-red">*</span><small class="text-grey"> (any alphanumeric of your choice)</small></p>
	       <input type="text" name="advertiser_name" value="<?php echo set_value('advertiser_name');?>"
		   class="form-control input-sm margin-bottom-15" <?php if(null != form_error('advertiser_name')):?>style="border: 1px solid red"<?php endif;?> required>		  
			
		   <p class="margin-bottom-5<?php if(null != form_error('job_no')):?> text-red<?php endif;?>">Unique Ad Name / Number <?php if(null != form_error('job_no')): ?><span class="text-red"> Required</span><?php endif;?>		   				
		   <span class="text-red">*</span> <small class="text-grey">(any alphanumeric of your choice)</small> </p>
	       <input type="text" name="job_no" pattern="[a-zA-Z0-9 ]{1,50}" value="<?php echo set_value('job_no');?>"
		   class="form-control input-sm margin-bottom-15"  <?php if(null != form_error('advertiser_name')):?>style="border: 1px solid red"<?php endif;?> required>
		</div>
		
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
		
		</div> 
	</div>
<!-- Required primary fields END -->
<hr></hr>

<!-- file upload dropzone START-->
	
	<div class="margin-top-10 margin-bottom-15" id="Vancouver">
	
	<section>
		<div class="container">
		<div class="row">
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
					 <input type="number" id="width" name="width" max="99" min="0.5" step="0.0001"  class="form-control input-sm" <?php if(null != form_error('width')):?><?php endif;?> value="<?php echo set_value('width');?>">
				</div>
					 
					 
			   <div class="col-md-6 col-sm-6 col-xs-6"> 
					<p class="margin-bottom-5 <?php if(null != form_error('height')):?> text-red<?php endif;?> ">Height <?php if(null != form_error('height')): ?> </p><span class="text-red"> Required</span>
					<?php endif;?>
					<span class="text-red">*</span> <small class="text-grey">(in inches)</small>
					<input type="number" id="height" name="height" max="99" min="0.5" step="0.0001" class="form-control input-sm" <?php if(null != form_error('height')):?><?php endif;?> value="<?php echo set_value('height');?>">
				</div>
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
		   
		   <p class="margin-bottom-5<?php if(null != form_error('copy_content_description')):?> text-red<?php endif;?>">Copy, Content, Text <?php if(null != form_error('copy_content_description')): ?><span class="text-red"> Required</span>
		   <?php endif;?>	
		   <span class="text-red"> *</span></p>
		   <textarea rows="3" name="copy_content_description"  
			data-max-length-warning="Input must be 5000 characters or less" 
			data-max-length="5000" 
			data-max-length-warning-container="name" class="js-max-char-warning form-control input-sm margin-bottom-15 txtLimits1 " type="text" id="yourtextarea1"  <?php if(null != form_error('copy_content_description')):?>style="border: 1px solid red"<?php endif;?>  required><?php echo set_value('copy_content_description');?></textarea>	
		    <div  style="color:red;"> <span class="name"></span></div>
		   
		</div>
		<div class="col-md-6 col-sm-6 col-xs-12"  ng-app="myApp" ng-controller="checkboxController">
		   <p class="margin-bottom-5 ">Publish Dates <span class="text-red"> * </span></p>
				<div class="input-group date date-picker muldate  margin-bottom-15" data-date-format="M d yyyy" data-date-start-date="+0d" >
					<input  type="text" class="form-control input-sm" name="publish_date"  required>
					<span class="input-group-btn ">
						<button class="btn btn-sm btn-dark" type="button"><i class="fa fa-calendar"></i></button>
					</span>
				</div>
				
			<p class="margin-bottom-5">Section <span class="text-red"> * </span></p> 
			<select class="form-control input-sm margin-bottom-15"  name="section_id" id="showselector" required>
				<option value="">Select</option> 
				<?php foreach($section_list as $sec){ ?>
				<option value="<?php echo $sec['id']; ?>"><?php echo $sec['name']; ?></option>
				<?php } ?>
				<option value="other_section">Others</option> 
			</select> 
			<div id="other_section" class="colors margin-bottom-5" style="display:none">
			<p class="margin-bottom-5"> Add Section <span class="text-red"> * </span></p>
		   	<input type="text" class="form-control input-sm" name="add_section" id="add_section">
		    <div  style="color:red;"> <span class="name456"></span></div>
			</div>
			
			<p class="margin-bottom-5"> Notes &amp; Instructions</p>
		   <textarea rows="3" name="notes"  
			data-max-length-warning="Input must be 5000 characters or less" 
			data-max-length="5000" 
			data-max-length-warning-container="name123" class="js-max-char-warning form-control input-sm margin-bottom-15 txtLimit2 " type="text" id="yourtextarea2"    ></textarea>	
		    <div  style="color:red;"> <span class="name123"></span></div>
		   
		</div>
		</div>
			<div class="row">
			
				<div class="col-md-12 margin-bottom-15 text-right">
					<span class="dropdown">
						<a class="cursor-pointer" type="button" data-toggle="dropdown" id="view">View Uploaded Files<span class="caret"></span></a>
						<div class="table-responsive dropdown-menu file_li " id="show"> 
							<table class="table table-striped table-hover" id="mytable">
								 <tbody id="tbody">
								 
								</tbody>
							 </table>
						</div>
					</span>
				</div>
			</div>
			<div>
				<div action="<?php echo base_url().index_page().'new_client/home/order_cache/'.$cacheid; ?>" id="dropzonefileupload" class="dropzone margin-top-10 margin-bottom-15" > 
					<div class="dz-default dz-message margin-top-55 margin-0"><span>You can attach or drag files here</span></div>
				</div>
			</div>	 			
		</div>
	</section>
	</div>
<!-- file upload dropzone END-->
<hr></hr>


					<div class="col-md-12 margin-bottom-10"><div class="float-right text-grey">Please wait for all files to upload before submitting.</div></div>
					<div class="col-md-12">
						<div class="float-right ">
							<?php if($client['rush']=='1') { ?>
								<input type="checkbox" name="rush" value="1" <?php echo set_checkbox('rush', '1'); ?>> 
								<span class="margin-right-10  text-grey"><label>Rush if possible</label></span>
							<?php } ?>
							<input id="cacheid" type="hidden" class="form-control input-sm" name="cacheid" value="<?php echo $cacheid;?>" >
							<button type="submit" name="os_submit" id="os_submit" onclick="required()" class="btn btn-blue btn-sm margin-bottom-5">Submit</button>
							
						</div>
					</div>
	</form>

	</section>
	
</div>

<style>
    .modal-backdrop {
    display:none;
}

</style>
<!-- Modal -->
<div class="modal" id="errorModal" tabindex="-1"  role="dialog" aria-labelledby="confirmationModalTitle" >
 <div class="modal-dialog modal-dialog-centered" role="document" style="width:700px;">
    <div class="modal-content" style="width:85%">
      <div class="modal-header" style="border-bottom: 0 !important;background-color:#333 !important;">
        <h5 class="modal-title portlet-title margin-top-10" id="errorModal" style="margin-top: 0px !important; padding:10px !important;"><center><b>Alert</b></center></h5>
      </div>
      <div class="modal-body" style="padding: 15px 16px;">
          <h4  class="font-blue" style="color:#900;" ><?php echo $this->session->flashdata('message')?></h4>
      </div>
      <div class="modal-footer" style="background-color:#fff !important;">
        <button type="button" class="btn btn-warning" data-dismiss="modal" >Close</button>
      </div>
    </div>
  </div>
</div>

<script>
$(function() {
        $('#showselector').change(function(){
            $('.colors').hide();
			var val = $(this).val();
            $('#' + val).show();
			if(val == 'other_section') { 
				$('#add_section').attr('required', 'required');
			} else {
				$('#add_section').removeAttr('required');
			}
        });
    });
	
$("#order_form").submit(function(e){
	var pub_project_id_len =  $("[name='pub_project_id[]']:checked").length;
	
	if(pub_project_id_len == 0){
		alert('Please Select Publications Required..!!');
		e.preventDefault();
	}
});

</script>
<script>
	$(document).ready(function() {
	//list attachments
	   function attachment_list(){
		   $.ajax({
			  url: "<?php echo base_url().index_page()."new_client/home/order_cache/".$cacheid;?>",
			  dataType: "json",
			  success: function(data){
				  $('#tbody').html('');
				  var count = data.length;
				  console.log(count);
				  for(var i=0;i<count;i++){
					  $('#tbody').append(data[i]);
				  }
			  }
			 
		   });
	   }
	   
	   $("#view").on("click", function(){
		   attachment_list();
	   });
	
	});
	
	//remove attachment
		function remove_att_cache(fname){  
			var x = confirm("Delete the item "+fname+" ?")
			if(x == true){
			   $.ajax({
				  url: "<?php echo base_url().index_page()."new_client/home/remove_att_cache/".$cacheid;?>/"+fname,
				  success: function(data){
					  //attachment_list();
				  }
				 
			   });
			}
		}
	
//Mood Board Attach file
	$(".mood_board").click(function(){
	var mood_board_id = $(this).data('mood_board_id'); 
	if(mood_board_id == 4){
		$('#moodboard_upload').css("visibility", "visible");
	}else{
		$('#moodboard_upload').css("visibility", "hidden");
	}
	
});
		
</script>
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
	
	$(".muldate").datepicker({
     format: 'yyyy-mm-dd'
	});	
</script>			
<?php $this->load->view('new_client/footer');?>			