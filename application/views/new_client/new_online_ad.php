<?php $this->load->view('new_client/header');?>
<!-- editor tool bar -->	
    <link rel="stylesheet" href="https://cdn.quilljs.com/1.3.7/quill.snow.css">
<!-- editor tool bar END-->	
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css">
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

<!-- multiple size select css -->
<style>
    .dropdown-check-list {
      display: block;
    }
    .dropdown-check-list .anchor {
      position: relative;
      cursor: pointer;
      display: block;
      padding: 5px 50px 5px 10px;
      border: 1px solid #ccc;
    }
    .dropdown-check-list .anchor:after {
      position: absolute;
      content: "";
      border-left: 2px solid black;
      border-top: 2px solid black;
      padding: 5px;
      right: 10px;
      top: 20%;
      -moz-transform: rotate(-135deg);
      -ms-transform: rotate(-135deg);
      -o-transform: rotate(-135deg);
      -webkit-transform: rotate(-135deg);
      transform: rotate(-135deg);
    }
    .dropdown-check-list .anchor:active:after {
      right: 8px;
      top: 21%;
    }
    .dropdown-check-list ul.items {
      padding: 2px;
      display: none;
      margin: 0;
      border: 1px solid #ccc;
      border-top: none;
    }
    .dropdown-check-list ul.items li {
      list-style: none;
    }
    .checkbox_check{
    margin-right: 10px !important;
    margin-left: 10px !important;
        margin-top: 5px !important;
    }
    span.ui-icon.ui-icon-circle-triangle-w {
        -webkit-transition: none !important;
        transition: none;
    }
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
    .ui-datepicker, .ui-datepicker .ui-datepicker-next-hover { //top: 1px; }
    .ui-datepicker .ui-datepicker-prev { //left:2px; }
    .ui-datepicker .ui-datepicker-next { right:2px; }
    .ui-datepicker .ui-datepicker-prev-hover { //left:1px; }
    .ui-datepicker .ui-datepicker-next-hover { //right:1px; }
    .ui-datepicker .ui-datepicker-prev span, .ui-datepicker .ui-datepicker-next span {     display: block;
        position: absolute;
        left: 50%;
        margin-left: -14px;
        top: 20%;
        background-color: #333333;
        color: white;
        padding: 1px;
        font-size: 15px;
        cursor: pointer;
        margin-top: -8px;  }
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
<style>
    .active > a{
        color: #d71a22 !important;
        border-color: #333;
        background: #e1e1e100 !important;
    }
	.ui.dropdown:not(.button)>.default.text {
        color: rgba(82, 82, 82, 0.87);
    }
    .ui.selection.dropdown{
    border: 1px solid rgb(193, 193, 193);
        border-radius: 0;
    }
      .customer_records{
      display:none;
    }
    .remove {
        padding: 0px 10px 25px 0px;
        position: relative;
        top: 5px;
    }
    a.btn.red-sunglo.btn-link.btn-xs.extra-fields-customer {
        background-color: grey;
        color: white;
        margin-bottom: 6px;
    }
      .customer_records1{
      display:none;
    }
    .remove1{
        padding: 5px 15px 10px 0px;
    }
    a.btn.red-sunglo.btn-link.btn-xs.extra-fields-customer1 {
        background-color: grey;
        color: white;
        margin-bottom: 6px;
    }
    a.remove-field.btn-remove-customer {
        position: relative;
        top: 5px;
    }
    
</style>
<!-- multiple size select css END-->      

<style> .fa-info-circle { cursor: pointer; } 
.paddinh-horizontal-30: padding-left: 30px; padding-right: 30px;}
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
<?php $adrep = $this->db->get_where('adreps',array('id'=>$this->session->userdata('ncId')))->row_array(); ?>
	<section>
      <div class="container margin-top-40 center"> 
		 <?php if($adrep['print_ad']=='1'){  ?>
		   <a href="<?php echo base_url().index_page().'new_client/home/new_print_ad';?>" class="btn btn-sm btn-dark btn-outline">Print Ad</a>
		 <?php } ?>
		 
		  <?php if($adrep['online_ad']=='1'){  ?>
           <a href="<?php echo base_url().index_page().'new_client/home/new_online_ad';?>" class="btn btn-sm btn-dark btn-outline btn-active margin-right-5">Online Ad</a>
		  <?php } ?>
		 	
         <?php if($adrep['pagedesign_ad']=='1'){  ?>
           <a href="<?php echo base_url().index_page().'new_client/home/page_proceed';?>" class="btn btn-sm btn-dark btn-outline">Pagination</a>
		<?php } ?>
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
	   <div class="col-md-6 col-sm-6 col-xs-12">
		   <!--<p class="margin-bottom-5">Advertiser Name <span class="text-red">*</span></p>
	       <input type="text" name="advertiser_name" class="form-control input-sm margin-bottom-15" title="" required="">-->
            <p class="margin-bottom-5">Advertiser Name		   <span class="text-red">*</span><small class="text-grey"> (Select or add an advertiser)</small></p>
	       <input type="text" name="advertiser_name" value=""
		   class="form-control input-sm margin-bottom-15"  required id="autocomplete-input" autocomplete="off">	
            <div id="suggestions-box"></div>
            
		   <p class="margin-bottom-5">Unique ID <span class="text-red">*</span> <small class="text-grey">(Add your own number or letters)</small> </p>
	       <input type="text" name="job_no" pattern="[a-zA-Z0-9 ]{1,50}" class="form-control input-sm margin-bottom-15" title="" required="">
		  
 		   <p class="margin-bottom-5">Maximum File Size <span class="text-red">* </span><small class="text-grey">(In KBs)</small></p>
	       <input type="text" name="maximum_file_size" class="form-control input-sm margin-bottom-15" title="" required="">
		   
		   <p class="margin-bottom-5">Copy, Content, Text<span class="text-red"> *</span></p>
		   <?php    
		        $quill_disable_adrep = array('971','308','307','2195','2716');
		        if (in_array($adrep['id'],$quill_disable_adrep, TRUE)){
		   ?>
        		   <textarea rows="3" name="copy_content_description" style="margin: 0px -4px 15px 0px; height: 140px;" 
        			data-max-length-warning="Input must be 5000 characters or less" 
        			data-max-length="5000" 
        			data-max-length-warning-container="name" class="js-max-char-warning form-control input-sm margin-bottom-15 txtLimits1" id="yourtextarea1" required="" type="text"></textarea>
        			 <div  style="color:red;"> <span class="name"></span></div>	 
        	<?php }else{ ?>
        			<textarea name="copy_content_description" id="copy_content_description" type="text" ></textarea>
        		    <div id="editor" style="height:92px;"></div>
        		    <div  style="color:red;"> <span class="name" id="txtLimit"></span> </div>
		    <?php } ?>
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
			
		<div id="size-div" >
		   <p class="margin-bottom-5">
		       Size <span class="text-red">* </span><small id="size_unit" class="text-grey">(in Pixels)</small>
		       <a class="btn red-sunglo btn-link btn-xs  extra-fields-customer" style="float:right;" >
			    <span class="glyphicon glyphicon-plus"></span> Add Custom Size
			   </a>
		   </p>
		    <div class="row margin-bottom-5">
		        <div class="col-sm-12"> 
			        <div class="inline field">
                        <select name="size_id[]" id="size_id" multiple="" class="form-control  label ui selection fluid dropdown" >
                           
        					  <?php  $pixel_sizes = $this->db->get('pixel_sizes')->result_array();
        								foreach($pixel_sizes as $row)
        								{
        						?>
        						<option value="<?php echo $row['id']; ?>" ><?php echo $row['width'].' X '.$row['height'].' ('.$row['name'].')'; ?></option>
        					  <?php } ?>
        				  
					    </select>
                    </div>
			
			        <div id="list1" class="dropdown-check-list checkbox-group required" tabindex="100" style="display:none;">
                        <span class="anchor">Select</span>
                        <ul id="items" class="items" >
	                        
                        </ul>
                    </div>
				</div>   
			</div>
			<div class="row static-info">
				<div class="customer_records">
                    <div class="col-md-5 col-xs-3 value margin-bottom-10">  
                        <input type="number" pattern="[1-9]{1,50}" min="1" name="custom_width[]" class="col-md-12 decimal form-control input-sm custom_width"  placeholder="width">
                    </div>
  	                <div class="col-md-5 col-xs-4 value margin-bottom-10">  
  	                    <input type="number" pattern="[1-9]{1,50}" min="1" name="custom_height[]" class="col-md-12 decimal form-control input-sm custom_height"  placeholder="height">
  	                </div>
                </div>
                <div class="customer_records_dynamic"></div>  
            </div>
            
		</div>
				
		  <p class="margin-bottom-5">Production Notes</p>
		   <textarea rows="3" name="notes" style="margin: 0px -4px 15px 0px; height: 140px;" 
			data-max-length-warning="Input must be 5000 characters or less" 
			data-max-length="5000" 
			data-max-length-warning-container="name123" class="js-max-char-warning123 form-control input-sm margin-bottom-15 txtLimit2" id="yourtextarea2" type="text"></textarea>	
			 <div  style="color:red;"> <span class="name123"></span></div>
			 
		</div> 
	  </div>
	<!-- Required primary fields END -->

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

	<div class="row margin-bottom-5">
		<div class="col-md-12 col-sm-12 col-xs-12 text-grey">   
			<label class="cursor-pointer">
				<input id="showoptional" type="checkbox" class="margin-right-5"> 
				<span class="text-grey">Check to view optional fields</span>
			</label>
		</div>
	</div>	
<!-- optional fields START-->	
		<div class="row margin-top-15 margin-bottom-25" id="optional">
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
							<button type="submit" name="os_submit" id="os_submit" onclick="required()" class="btn btn-blue btn-sm margin-bottom-5">Submit</button>
							
						</div>
					</div>
	</form>

	</section>
	
</div>
<!-- editor tool bar 	-->
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
            //return true;
        }
        
        if ($(this).valid()) {
            //validation for size   
            if( $('#size_id :selected').length > 0 ){
                return true;
    		} else {
    		    if($('.custom_height').length > 1){
    		        return true;
    		    }
    			alert("Please Select Size. Size is Mandatory");
    			return false;
    		}
    			
            return true;
        } else {
            alert("Please fill all the Mandatory Fields");
            return false;
        }
  
});

</script>			

<script>
Dropzone.options.moodboard_upload = {
  paramName: "file", // The name that will be used to transfer the file
  maxFilesize: 8, // MB
  clickable : true,
  uploadMultiple :true,
  addRemoveLinks:true,
  dictRemoveFile="Remove File",
  dictDefaultMessage="Hey Yo"
 
};
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
	
	function ad_format(id){
	    //$('#size-div').show();
		$('#size_id').val('');
		$(".item").removeClass("filtered"); $(".item").removeClass("active");
		$("a.ui.label.transition.visible").remove();
		$(".customer_records_dynamic").empty(); // clear custom size div customer_records_dynamic
		$('#size_id').empty();
		if(id == 5){
			//Load flexitive_size option to dropdown
		    $('#size_unit').html("(in ratio)");
			<?php 
				$flexitive_size = $this->db->get('flexitive_size')->result_array(); 
			    foreach($flexitive_size as $result){ 
			?>
			        $("#size_id").append("<option value='<?php echo $result['id']; ?>'><?php echo $result['ratio'].' ('.$result['text'].')'; ?></option>");
			<?php        
				}
			?>
			
		}else{
		    //Load pixel_size options to dropdown
    		$('#size_unit').html("(in Pixels)");
    		<?php  
                $pixel_sizes = $this->db->get('pixel_sizes')->result_array();
    			foreach($pixel_sizes as $row){
    		?>
    		    $("#size_id").append("<option value='<?php echo $row['id']; ?>'><?php echo $row['width'].' X '.$row['height'].' ('.$row['name'].')'; ?></option>");
    		<?php } ?>
		}
	}
</script>

<!-- multiple size -->
<script src='https://cdn.jsdelivr.net/npm/semantic-ui@2.2.13/dist/semantic.min.js'></script>
<script>
    function yesnoCheck() {
        if (document.getElementById('yesCheck').checked) {
            document.getElementById('ifYes').style.visibility = 'visible';
        }
        else document.getElementById('ifYes').style.visibility = 'hidden';
    
    }
    			//decimal number restriction
    $(function() {
      $('.decimal').on('input', function() {
        this.value = this.value
          .replace(/[^\d]/g, '')             // numbers and decimals only
          .replace(/(^[\d]{4})[\d]/g, '$1')   // not more than 2 digits at the beginning
       
      });
    });

    $('.datepickerautoff').on('click', function(e) {
				e.preventDefault();
				$(this).attr("autocomplete", "off");  
			});

		jQuery(document).ready(function() {       
		FormValidation.init();
	});
	
    $('.extra-fields-customer').click(function() {
      $('.customer_records').clone().appendTo('.customer_records_dynamic');
      $('.customer_records_dynamic .customer_records').addClass('single remove');
      $('.single .extra-fields-customer').remove();
      $('.single').append('<a href="#" class="remove-field btn-remove-customer">X</a>');
      $('.customer_records_dynamic > .single').attr("class", "remove");
    
      $('.customer_records_dynamic input').each(function() {
        var count = 0;
        var fieldname = $(this).attr("name");
        $(this).attr('name', fieldname + count);
        $(this).attr('required', 'required'); // add required
        count++;
      });
    
    });
    
    $(document).on('click', '.remove-field', function(e) {
      $(this).parent('.remove').remove();
      e.preventDefault();
    });
    
    /*
    $('.extra-fields-customer1').click(function() {
      $('.customer_records').clone().appendTo('.customer_records_dynamic1');
      $('.customer_records_dynamic1 .customer_records').addClass('single remove');
      $('.single .extra-fields-customer1').remove();
      $('.single').append('<a href="#" class="remove-field btn-remove-customer">X</a>');
      $('.customer_records_dynamic1 > .single').attr("class", "remove");
    
      $('.customer_records_dynamic1 input').each(function() {
        var count = 0;
        var fieldname = $(this).attr("name");
        $(this).attr('name', fieldname + count);
        
        count++;
      });
    
    });
    
    $(document).on('click', '.remove-field', function(e) {
      $(this).parent('.remove1').remove();
      e.preventDefault();
    });
    */
	
    var checkList = document.getElementById('list1');
    var items = document.getElementById('items');
    checkList.getElementsByClassName('anchor')[0].onclick = function(evt) {
      if (items.classList.contains('visible')) {
        items.classList.remove('visible');
        items.style.display = "none";
      } else {
        items.classList.add('visible');
        items.style.display = "block";
      }
    
    }
    /*
    var checkList = document.getElementById('list2');
    var items2 = document.getElementById('items2');
    checkList.getElementsByClassName('anchor')[0].onclick = function(evt) {
      if (items2.classList.contains('visible')) {
        items2.classList.remove('visible');
        items2.style.display = "none";
      } else {
        items2.classList.add('visible');
        items2.style.display = "block";
      }
    
    }
    items2.onblur = function(evt) {
      items2.classList.remove('visible');
    }
    */
    items.onblur = function(evt) {
      items.classList.remove('visible');
    }
    
    $('.label.ui.dropdown')
      .dropdown();
    
    $('.no.label.ui.dropdown')
      .dropdown({
      useLabels: false
    });
    
    $('.ui.button').on('click', function () {
      $('.ui.dropdown')
        .dropdown('restore defaults')
    });
</script>
<script src="http://code.jquery.com/jquery.js"></script>
<!-- multiple size END -->
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
