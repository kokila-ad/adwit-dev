<?php $this->load->view('new_client/header');?>
<!-- editor tool bar -->	
    <link rel="stylesheet" href="https://cdn.quilljs.com/1.3.7/quill.snow.css">
<!-- editor tool bar END-->	

<style>
	.dropzone {
    display: block;
    //background-image: url(../img/attachment.png);
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

<style> 
    .fa-info-circle { cursor: pointer; } 
    .paddinh-horizontal-30{ padding-left: 30px; padding-right: 30px;}
</style>
<!-- Advertiser suggestion box -->
<style>
            .active > a{
            	color: #d71a22 !important;
            	border-color: #333;
            	background: #e1e1e100 !important;
            }

            #suggestions-box {
              position: absolute; /* To position it right under the input */
              max-height: 200px; /* Adjust as needed */
              overflow-y: auto; /* Scroll if there are too many items */
              width: 100%; /* Match width of input box */
              box-shadow: 0 4px 8px rgba(0,0,0,0.1); /* Bootstrap-like shadow */
              z-index: 999;
              border-top: none; /* No top border to align with the input box */
              background: #ffffff;
          }

          #suggestions-box div {
              padding: 10px 15px; /* Bootstrap-like padding */
              cursor: pointer; /* Hand cursor for clickable items */
          }

          #suggestions-box div:hover {
              background-color: #f8f9fa; /* A light hover effect */
          }
 </style>
<script type="text/javascript">
	$(document).ready(function(){
	    $("#copy_content_description").hide();
	   
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
		
		$("#mood_board_opt").hide();	
        $("#show_mood_board").click(function(){
			$("#mood_board_opt").toggle(); 
			$("#no_os_submit").toggle();
        });
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

</script>
<div id="main"> 
<?php $adrep = $this->db->get_where('adreps',array('id'=>$this->session->userdata('ncId')))->row_array(); ?>
   <section>
      <div class="container margin-top-40 center"> 
		 <?php if($adrep['print_ad']=='1'){  ?>
		   <a href="<?php echo base_url().index_page().'new_client/home/new_print_ad';?>" class="btn btn-sm btn-dark btn-outline btn-active margin-right-5">Print Ad</a>
		 <?php } ?>
		 
		  <?php if($adrep['online_ad']=='1'){  ?>
           <a href="<?php echo base_url().index_page().'new_client/home/new_online_ad';?>" class="btn btn-sm btn-dark btn-outline">Online Ad</a>
		  <?php } ?>
		 	
         <?php if($adrep['pagedesign_ad']=='1'){  ?>
           <a href="<?php echo base_url().index_page().'new_client/home/page_proceed';?>" class="btn btn-sm btn-dark btn-outline">Pagination</a>
		<?php } ?>
      </div>
   </section>
   <section>
    <div class="container margin-top-40">   
	<form action="<?php echo base_url().index_page().'new_client/home/new_print_ad';?>" method="post" name="order_form" id="order_form">
	<div class="row">
		
	   <div class="col-md-6 col-sm-6 col-xs-12">
	       <p class="margin-bottom-5">Advertiser Name		   <span class="text-red">*</span><small class="text-grey"> (Select or add an advertiser)</small></p>
	       <input type="text" name="advertiser_name" value=""
		   class="form-control input-sm margin-bottom-15"  required id="autocomplete-input" autocomplete="off">	
            <div id="suggestions-box"></div>	
		   <!--<p class="margin-bottom-5<?php if(null != form_error('advertiser_name')):?> text-red<?php endif;?>">Advertiser Name<?php if(null != form_error('advertiser_name')):?><span class="text-red"> Required</span>
		   <?php endif;?>
		   <span class="text-red">*</span><small class="text-grey"> (any alphanumeric of your choice)</small></p>
	       <input type="text" name="advertiser_name" value="<?php echo set_value('advertiser_name');?>"
		   class="form-control input-sm margin-bottom-15" <?php if(null != form_error('advertiser_name')):?>style="border: 1px solid red"<?php endif;?> required>-->		  
			
		   <p class="margin-bottom-5<?php if(null != form_error('job_no')):?> text-red<?php endif;?>">Unique ID <?php if(null != form_error('job_no')): ?><span class="text-red"> Required</span><?php endif;?>		   				
		   <span class="text-red">*</span> <small class="text-grey">(Add your own number or letters)</small> </p>
	       <input type="text" name="job_no" pattern="[a-zA-Z0-9 ]{1,50}" value="<?php echo set_value('job_no');?>"
		   class="form-control input-sm margin-bottom-15"  <?php if(null != form_error('advertiser_name')):?>style="border: 1px solid red"<?php endif;?> required>
		   
			
		   <p class="margin-bottom-5<?php if(null != form_error('copy_content_description')):?> text-red<?php endif;?>">Copy, Content, Text <?php if(null != form_error('copy_content_description')): ?><span class="text-red"> Required</span>
		   <?php endif;?>	
		   <span class="text-red"> *</span></p>
		   <?php    
		        $quill_disable_adrep = array('971','308','307','2195','2716');
		        if (in_array($adrep['id'],$quill_disable_adrep, TRUE)){
		   ?>
    		   <textarea <?php if($publication['enable_project']=='1'){echo 'rows="6"';}else{echo 'rows="3"';} ?> name="copy_content_description" 
    			data-max-length-warning="Input must be 5000 characters or less" 
    			data-max-length="5000" 
    			data-max-length-warning-container="name" class="js-max-char-warning form-control input-sm margin-bottom-15 txtLimits1 " type="text" id="yourtextarea1"  <?php if(null != form_error('copy_content_description')):?>style="border: 1px solid red"<?php endif;?> required><?php echo set_value('copy_content_description');?></textarea>	
    		    <div  style="color:red;"> <span class="name" id="txtLimit"></span> </div>
		    <?php }else{ ?>
    		    <textarea name="copy_content_description" id="copy_content_description" type="text" ></textarea>
    		    <div id="editor" style="height:125px;"></div>
    		    <div  style="color:red;"> <span class="name" id="txtLimit"></span> </div>
		    <?php } ?>
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
			
			<p class="margin-bottom-5<?php if(null != form_error('print_ad_type')):?> text-red<?php endif;?>">Color Options<?php if(null != form_error('print_ad_type')):?> Required
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
		   
		   <p class="margin-bottom-5"> Production Notes</p>
		   <textarea rows="3" name="notes"   
			data-max-length-warning="Input must be 5000 characters or less" 
			data-max-length="5000" 
			data-max-length-warning-container="name123" class="js-max-char-warning form-control input-sm margin-bottom-15 txtLimit2 " type="text" id="yourtextarea2"></textarea>
		    <div  style="color:red;"> <span class="name123"></span></div>	
		    
		</div> 
	  </div>
	
	<!-- file upload dropzone START-->	
	<div class="margin-top-10 margin-bottom-15">
	<section>
		<div class="container">     
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
	<input id="cacheid" type="hidden" class="form-control input-sm" name="cacheid" value="<?php echo $cacheid;?>" >
						
		
		<div class="row margin-bottom-5">
			<div class="col-md-12 col-sm-12 col-xs-12 text-grey">   
				<label class="cursor-pointer">
					<input id="showoptional" type="checkbox" class="margin-right-5"> 
					<span class="text-grey">Check to view optional fields</span>
				</label>
			</div>
		</div>	
<!-- optional fields START-->		
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
					<input id="date_needed" type="text" class="form-control input-sm datepickerautoff" autocomplete="off" name="publish_date">
					<span class="input-group-btn">
					<button class="btn btn-sm btn-dark" type="button"><i class="fa fa-calendar"></i></button>
					</span>
				</div>
				
			<?php if($publication['enable_project']=='0'){ ?>		
			   <p class="margin-bottom-5">Publication Name</p>
			   <input type="text" name="publication_name" class="form-control input-sm  margin-bottom-15" title="">
			<?php } ?> 
			
			   <p class="margin-bottom-5">Font Preferences</p>
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
<!-- optional fields END-->	
<!-- mood_board START -->
<?php if($publication['is_mood_board_enable']=='1'){ ?>	
        <div class="row margin-bottom-5 margin-top-10">
			<div class="col-md-12 col-sm-12 col-xs-12 text-grey">   
				<label class="cursor-pointer" >
						<input id="show_mood_board" type="checkbox" class="margin-right-5"> 
						<span class="text-grey">Tell us if you have a particular type of ad in mind.</span>
					</label>
			</div>
	    </div>

    <section>
		<div class="container margin-top-15" id="mood_board_opt"> 
			<div class="row">
				
					<div class="col-md-12 margin-bottom-20">
					<?php 
						$mood_board_bold = $this->db->query("SELECT * FROM `mood_board` WHERE `id` = '1';")->row_array();
						if(isset($mood_board_bold)) {
					?>
					<!---------------------- BOLD ----------------------------------------------------------------------->
					   <div class="col-md-3 border">
							<div class="row">
								<p class="tabhead"><?php echo $mood_board_bold['name']; ?></p>
							</div>
						   <div class="row img_row">
						   <?php 
								$path = $mood_board_bold['path'].'/';
								if(file_exists($path)){
									$files = scandir($path);
									foreach($files as $file){ 
										if (!in_array($file,array(".",".."))){
						   ?>
								<div class="col-md-4 col-sm-4 col-xs-4 side_alignr">
									<input type="radio" class="radiobtn mood_board" name="mood_board" data-mood_board_id="<?php echo $mood_board_bold['id']; ?>" value="<?php echo $path.$file;?>" >
									<a href="#<?php echo base_url().$path.$file;?>" >
										
										<img src="<?php echo base_url().$path.$file;?>" class="thumbnail" >
									</a>
									<!-- lightbox container hidden with CSS -->
									<a href="#_" class="lightbox" id="<?php echo base_url().$path.$file;?>"><span class="close cursor" onclick="closeModal()">&times;</span>
									<img src="<?php echo base_url().$path.$file;?>"></a>
								</div>
						<?php 	} } } ?>	
							</div>	
						 				
						</div>
					<?php } ?> 
					
					<!---------------------- CLEAN ----------------------------------------------------------------------->
					<?php 
						$mood_board_clean = $this->db->query("SELECT * FROM `mood_board` WHERE `id` = '2';")->row_array();
						if(isset($mood_board_clean)) {
					?>
					   <div class="col-md-3 border">
							<div class="row">
								<p class="tabhead"><?php echo $mood_board_clean['name']; ?></p>
							</div>
						   <div class="row img_row">
						   <?php 
								$path = $mood_board_clean['path'].'/';
								if(file_exists($path)){
									$files = scandir($path);
									foreach($files as $file){ 
										if (!in_array($file,array(".",".."))){
						   ?>
								<div class="col-md-4 col-sm-4 col-xs-4 side_alignr">
									<input type="radio" class="radiobtn mood_board" name="mood_board" data-mood_board_id="<?php echo $mood_board_clean['id']; ?>" value="<?php echo $path.$file;?>" >
									<a href="#<?php echo base_url().$path.$file;?>" >
										<img src="<?php echo base_url().$path.$file;?>" class="thumbnail" >
									</a>
									<!-- lightbox container hidden with CSS -->
									<a href="#_" class="lightbox" id="<?php echo base_url().$path.$file;?>"><span class="close cursor" onclick="closeModal()">&times;</span>
									<img src="<?php echo base_url().$path.$file;?>"></a>
								</div>
						<?php 	} } } ?>	
							</div>	
						 				
						</div>
					<?php } ?>
					
					<!---------------------- DIFFERENT ----------------------------------------------------------------------->
					<?php 
						$mood_board_different = $this->db->query("SELECT * FROM `mood_board` WHERE `id` = '3';")->row_array();
						if(isset($mood_board_different)) {
					?>
					   <div class="col-md-3 border">
							<div class="row">
								<p class="tabhead"><?php echo $mood_board_different['name']; ?></p>
							</div>
						   <div class="row img_row">
						   <?php 
								$path = $mood_board_different['path'].'/';
								if(file_exists($path)){
									$files = scandir($path);
									foreach($files as $file){ 
										if (!in_array($file,array(".",".."))){
						   ?>
								<div class="col-md-4 col-sm-4 col-xs-4 side_alignr">
									<input type="radio" class="radiobtn mood_board" name="mood_board" data-mood_board_id="<?php echo $mood_board_different['id']; ?>" value="<?php echo $path.$file;?>" >
									<a href="#<?php echo base_url().$path.$file;?>" >
										<img src="<?php echo base_url().$path.$file;?>" class="thumbnail" >
									</a>
									<!-- lightbox container hidden with CSS -->
									<a href="#_" class="lightbox" id="<?php echo base_url().$path.$file;?>"><span class="close cursor" onclick="closeModal()">&times;</span>
									<img src="<?php echo base_url().$path.$file;?>"></a>
								</div>
						<?php 	} } } ?>	
							</div>	
						 				
						</div>
					<?php } ?>
					
					<!---------------------- ANY OTHERS ----------------------------------------------------------------------->
					   <div class="col-md-3 border ">
					    <div class="row" >
						   <p class="tabhead">Any Others</p>
						   <div style="padding-left: 15px; padding-right: 15px;">
								<input type="radio" id="other_file" class="radiobtn radbtn mood_board" name="mood_board" data-mood_board_id="4" value="4" >
								<p id="moodboard_upload" action="<?php echo base_url().index_page().'new_client/home/moodboard_cache/'.$cacheid; ?>"  class="dropzone" style="visibility:hidden;"></p>
						   </div> 
						</div>
					   </div>
					
					</div>
			
			</div>
		</div>
    </section>

<?php } ?>
<!-- mood_board ENDS -->
			<div class="col-md-12 margin-bottom-10"><div class="float-right text-grey">Please wait for all files to upload before submitting.</div></div>
					<div class="col-md-12">
						<div class="float-right ">
							<?php if($client['rush']=='1') { ?>
								<input type="checkbox" name="rush" value="1"> 
								<span class="margin-right-10  text-grey"><label>Rush (additional charge applies)</label></span>
							<?php } ?>
							<input id="cacheid" type="hidden" class="form-control input-sm" name="cacheid" value="<?php echo $cacheid;?>" >
							<button type="submit" name="os_submit" id="os_submit" class="btn btn-blue btn-sm margin-bottom-5">Submit</button>
						</div>
					</div>

		</form>
		
	</section>
	
</div>
<!-- editor tool bar -->	
<script src="https://cdn.quilljs.com/1.3.7/quill.js"></script>

<script>
		// Initialize Quill editor
    var quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],  
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'size': ['small', false, 'large', 'huge'] }],  
                [{ 'color': [] }]
            ]
        }
    });
    
    var maxLength = 5000;

    quill.on('text-change', function() {
      var text = quill.getText();
      $("#txtLimit").html("");
      if (text.length > maxLength) {
        quill.deleteText(maxLength, text.length);
        $("#txtLimit").html("Input must be 5000 characters or less");//alert("TextLimit");
      }
    });
    
    
    
</script>
<!-- editor tool bar END-->	

<!-- restrict multiple form submission -->			
<script>
$("#order_form").submit(function () {
    var content = quill.root.innerHTML;
    
    $("#copy_content_description").val(content);
    
    var copy_content_description = $('#copy_content_description').val(); 
    if(copy_content_description.length <= 11){
        $("#txtLimit").html("Copy Content Required!");
        return false;
    } else {
        $("#txtLimit").html("");
        return true;
    }
    if ($(this).valid()) {
        $(this).submit(function () {
            return false;
        });
        return true;
    } else {
        return false;
    }
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

//date_needed , publish_date
$('.datepickerautoff').on('click', function(e) {
				e.preventDefault();
				$(this).attr("autocomplete", "off");  
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
	/*
	$(".muldate").datepicker({
     format: 'yyyy-mm-dd'
	});
*/

</script>		
<!--- Advertiser auto fetch --->
<script>

    $("#autocomplete-input").on("keyup", function() {
        var query = $(this).val().toLowerCase();

        if (query.length < 3) { // Check if input length is less than 3 characters
            $("#suggestions-box").empty(); // If so, hide suggestions
            return;
        }
/*
        var matches = suggestions.filter(function(item) {
            return item.toLowerCase().indexOf(query) !== -1;
        });
*/
        if (query === "") { // Check if the input is empty
            $("#suggestions-box").empty(); // If so, hide suggestions
        } else {
            $.ajax({
               url: "<?php echo base_url().index_page().'new_client/home/fetch_advertiser';?>",
               method: "POST",
               data:{name:query},
               success: function(data){ 
				if(data){
                   var suggestions = JSON.parse(data);
				   console.log(suggestions);
				   
                   var matches = suggestions.filter(function(item) {
                        return item.toLowerCase().indexOf(query) !== -1;
                    });
                    displaySuggestions(matches);
				  }else{
					   $("#suggestions-box").empty();
				   }
                }
           });
            
        }
    });
    
    function displaySuggestions(matches) {
        $("#suggestions-box").empty();
        matches.forEach(function(item) {
            $("#suggestions-box").append('<div>' + item + '</div>');
        });
    }

    $(document).on("click", "#suggestions-box div", function() {
        $("#autocomplete-input").val($(this).text());
        $("#suggestions-box").empty();
    });

	
</script>
<?php $this->load->view('new_client/footer');?>	
