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
p .line{

color: blue !important;
font-family: 'collegeregular';
font-size: 20px;
margin-left: 5px;
position: relative;
width: 100%;
}

p.line:after {
position: absolute;
    content: "";
    height: 1px;
    background-color: blue;
    width: 100%;
    margin-left: 5px;
    margin-top: 10px;

}
h5 { width:100%;     font-weight: 200;    font-size: 14px !important; text-align:left; color:#3e3ee6; border-bottom: 1px solid #3e3ee6; line-height:0.5em; margin:10px 0 20px; } 
h5 span { background:#fff;  }
h6 { width:100%; text-align:center; color:#ff0000;font-weight: 200; border-bottom: 1px dashed #ccc; line-height:0.5em; margin:10px 0 20px; } 
h6 span { background:#fff; padding:0 10px; }
p .line1{

color: blue !important;
font-family: 'collegeregular';
font-size: 20px;
margin-left: 5px;
position: relative;
width: 93%;
}

p.line1:after {
position: absolute;
    content: "";
    height: 1px;
    background-color: blue;
    width: 60.7%;
    margin-left: 5px;
    margin-top: 10px;

}
.outborder{
padding:15px;
border:1px solid #ccc;
    border-radius: 10px;
}
.backblack{
       background-color: black;
    padding: 5px;
    border-radius: 10px;
    padding-top: 8px;
    padding-bottom: 28px;
	}
	.subbtn {
        font-size: 12px !important;
    padding: 6px 35px !important;
    float: right;
    position: relative;
    bottom: 3px;
}
.fagreen{
    position: relative;
    float: right;
    left: 25px;
    color: green;
    font-size: 20px;
	}
	.fared{
	 position: relative;
    float: right;
    left: 25px;
    color: red;
    font-size: 20px;
	}
	.linebtm{
	border-bottom:1px solid #ccc;position: relative;
    bottom: 10px;

}
@media (max-width: 767px){
.fagreen,.fared {
    position: relative;
    left: 9px !important;
}
}
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

/*Dropzone.options.dropzonefileupload = {
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
};*/

</script>
<script>
	    $(document).ready(function(){
				
				 $("#alltxt").hide();
				  $("#showall").hide();
				 
				 $("#addtxt").click(function(){
					$("#alltxt").show(); 
					$("#adpub").hide(); 
					$("#showmpub").hide(); 
				 });
				 $("#fagreen").click(function(){
					$("#showall").show(); 
					//required feilds
					$("#job_no2").attr("required",true);
					$("#width2").attr("required",true);
					$("#height2").attr("required",true);
					$("#copy_content_description2").attr("required",true);	
					$("#pub_project_id2").attr("required",true);
					$("#publish_date2").attr("required",true);
					$("#section_id2").attr("required",true);
					//fill value
					var job_no2 = $("#job_no").val();
					var width2 = $("#width").val();
					var height2 = $("#height").val();
					var copy_content_description2 = $("#copy_content_description").val();
					$("#job_no2").val(job_no2);
					$("#width2").val(width2);
					$("#height2").val(height2);
					$("#copy_content_description2").val(copy_content_description2);
				 });
				 $(".fared").click(function(){
					$("#showall").hide(); 
					//required feilds
					$("#job_no2").attr("required",false);
					$("#width2").attr("required",false);
					$("#height2").attr("required",false);
					$("#copy_content_description2").attr("required",false);	
					$("#pub_project_id2").attr("required",false);
					$("#publish_date2").attr("required",false);
					$("#section_id2").attr("required",false);
					//VALUE
					$("#job_no2").val('');
					$("#width2").val('');
					$("#height2").val('');
					$("#copy_content_description2").val('');
				 });
				 $("#addmpub").click(function(){
					$("#showmpub").show(); 
					
				 });
				
			 });
			 
			 $(document).ready(function(){
				 
				$('#example1').DataTable( {
					"order": [[ 0, "desc" ]]
				} );
			
				$('#example1').DataTable();
			 });
					  
		   jQuery(function($) {
				$('#dateControlledByRange').on('input', function() {
					$('#rangeControlledByDate').prop('valueAsNumber', $.prop(this, 'valueAsNumber'));
				});
				$('#rangeControlledByDate').on('input', function() {
					$('#dateControlledByRange').prop('valueAsNumber', $.prop(this, 'valueAsNumber'));
				});
			});			
		</script>
<div id="main"> 
<form method="post" name="order_form" id="order_form">
<section>
    <div class="container margin-top-40 ">  
		<h6><span>Ad1</span></h6>
		<div class="outborder">
	 
			<h5><span>Ad Information &nbsp;</span></h5>

			<p> select Ad type</p>	  
			<a href="" class="btn btn-sm btn-dark btn-outline btn-active margin-right-5">Print Ad</a>
			<a href="" class="btn btn-sm btn-dark btn-outline margin-right-5">Online Ad</a>
     
			<span style="margin-left: 20px; padding: 0 10px;" class="font-blue"></span>
   		
				<!-- Required primary fields END -->
				<div class="row margin-top-20 ">
					<div class="col-md-3 col-sm-6 col-xs-12"  ng-app="myApp" ng-controller="checkboxController">
					   <p class="margin-bottom-5">Advertiser Name <span class="text-red">*</span></p>
					   <input type="text" name="advertiser_name" value=""
					   class="form-control input-sm margin-bottom-15"  required>	
					</div>		   
					<div class="col-md-3 col-sm-6 col-xs-12">
					   <p class="margin-bottom-5">Ad Number 		   				
					   <span class="text-red">*</span>  </p>
					   <input type="text" name="job_no" id="job_no" pattern="[a-zA-Z0-9 ]{1,50}" value=""
					   class="form-control input-sm margin-bottom-15"   required>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12">
						<p class="margin-bottom-5">Color / B&W <span class="text-red">*</span>	</p>
						<div class="row margin-bottom-5">
							<div class="col-sm-12">
								<div class="btn-group" data-toggle="buttons">
									<label class="btn btn-sm btn-default margin-right-10 margin-bottom-10">
										<input type="radio" name="print_ad_type" value="1"  required> Color
									</label> 
									<label class="btn btn-sm btn-default margin-right-10 margin-bottom-10">
										<input type="radio" name="print_ad_type" value="2"  required> B&amp;W
									</label> 
								</div>
							</div>   
					   </div>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12">
						<div class="row margin-bottom-15 custom box">
						   <div class="col-md-6 col-sm-6 col-xs-6">
								 <p class="margin-bottom-5 ">Width <small class="text-grey">(in inches)</small><span class="text-red">*</span>
								 <input type="number" id="width" name="width" max="99" min="0.5" step="0.0001"  class="form-control input-sm"  value="" required>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6"> 
								<p class="margin-bottom-5  ">Height<small class="text-grey">(in inches)</small><span class="text-red">*</span>
								<input type="number" id="height" name="height" max="99" min="0.5" step="0.0001" class="form-control input-sm"  value="" required>
							</div>
						</div> 
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<p class="margin-bottom-5"> Copy &amp; Content <span class="text-red">*</span></p>
						<textarea rows="3" name="copy_content_description" id="copy_content_description"
						data-max-length-warning="Input must be 5000 characters or less" 
						data-max-length="5000" 
						data-max-length-warning-container="name" class="js-max-char-warning form-control input-sm margin-bottom-15 txtLimit2 " type="text" id="yourtextarea2"  placeholder="Please use copy from the file attached" required></textarea>	
						<div  style="color:red;"> <span class="name"></span></div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<p class="margin-bottom-5"> Notes &amp; Instructions</p>
						<textarea rows="3" name="notes"  
						data-max-length-warning="Input must be 5000 characters or less" 
						data-max-length="5000" 
						data-max-length-warning-container="name123" class="js-max-char-warning form-control input-sm margin-bottom-15 txtLimit2 " type="text" id="yourtextarea2"  placeholder="Be creative use bright colors"  ></textarea>	
						<div  style="color:red;"> <span class="name123"></span></div>
					</div>	
					<i class="fa fa-plus-circle fagreen" id="fagreen" aria-hidden="true"></i>
				</div>
				
				<div class="row">
					<div class="col-md-12  ">
						<p class=""> Attachments</p>
						<span class="dropdown">
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
					<div action="<?php echo base_url().index_page().'new_client/home/order_cache/'.$cacheid; ?>" id="dropzonefileupload" class="dropzone margin-bottom-15" > 
						<div class="dz-default dz-message margin-top-55 margin-0"><span>You can attach or drag files here</span></div>
					</div>
				</div>	

			<!-- Required primary fields END -->


			<!-- file upload dropzone START-->
			 
			<h5 class=" margin-top-30 "><span>Publication Information &nbsp;</span></h5>
			<div id="pub_lists">
				<div class="row pub_list">
						<div id="showmpub" >
							<div class="col-md-3 col-sm-6 col-xs-6 ">
								<select class="form-control input-sm" name="pub_project_id[]" required="required">
									<option>Choose publication</option>
									<?php foreach($pub_list as $row){ ?>
										<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-md-3 col-sm-6 col-xs-6 ">
								<div class="input-group date muldate date-picker margin-bottom-15" data-date-format="M d" data-date-start-date="+0d">
									<input type="text" name="publish_date[]" class="form-control input-sm" placeholder="Choose publication Date"  required >
									<span class="input-group-btn" >
										<button class="btn btn-blue btn-sm" type="button" style="display:none;"><i class="fa fa-calendar"></i></button>
									</span>
								</div>
							</div>
							<div class="col-md-3 col-sm-6 col-xs-6 ">
								<select class="form-control input-sm" name="section_id[]" required="required">
									<option>Section</option>
									<?php foreach($section_list as $sec){ ?>
									<option value="<?php echo $sec['id']; ?>"><?php echo $sec['name']; ?></option>
									<?php } ?>
								</select>
							</div>
						<!--							
							<div class="col-md-1 col-sm-6 col-xs-6 ">
								<button class="btn btn-sm btn-blue" id="addtxt"> Add </button>
							</div>
						
							<div class="col-md-2 col-sm-6 col-xs-12 ">
								<a style="cursor: pointer;" onclick="addcontact();"> Add more publications</a>
							 </div>	--> 
						</div>
				</div>
				<div id="addpub"></div>
			</div>
		</div> 
	</div> 
</section>

<section id="showall">
    <div class="container margin-top-30 ">  
		<h6><span>Ad2</span></h6>
		<div class="outborder">
	 		<h5><span>Ad Information &nbsp;</span></h5>
 			<span style="margin-left: 20px; padding: 0 10px;" class="font-blue"></span>
			<!-- Required primary fields END -->
				<div class="row margin-top-20 ">
					<div class="col-md-3 col-sm-6 col-xs-12">
					   <p class="margin-bottom-5">Ad Number 		   				
					   <span class="text-red">*</span>  </p>
					   <input type="text" name="job_no2" ID="job_no2" pattern="[a-zA-Z0-9 ]{1,50}" value=""
					   class="form-control input-sm margin-bottom-15"  >
					</div>
					
					<div class="col-md-3 col-sm-6 col-xs-12">
						<div class="row margin-bottom-15 custom box">
						   <div class="col-md-6 col-sm-6 col-xs-6">
								 <p class="margin-bottom-5 ">Width <small class="text-grey">(in inches)</small><span class="text-red">*</span>
								 <input type="number" id="width2" name="width2" max="99" min="0.5" step="0.0001"  class="form-control input-sm"  value="" >
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6"> 
								<p class="margin-bottom-5  ">Height<small class="text-grey">(in inches)</small><span class="text-red">*</span>
								<input type="number" id="height2" name="height2" max="99" min="0.5" step="0.0001" class="form-control input-sm"  value="" >
							</div>
						</div> 
					</div>
					
					<div class="col-md-6 col-sm-6 col-xs-12">
						<p class="margin-bottom-5"> Copy &amp; Content <span class="text-red">*</span></p>
						<textarea rows="3" name="copy_content_description2" ID="copy_content_description2"  
						data-max-length-warning="Input must be 5000 characters or less" 
						data-max-length="5000" 
						data-max-length-warning-container="name" class="js-max-char-warning form-control input-sm margin-bottom-15 txtLimit2 " type="text" id="yourtextarea2"  placeholder="Please use copy from the file attached" ></textarea>	
						<div  style="color:red;"> <span class="name"></span></div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-12"></div>
				</div>
				
				<div class="row">
					<i class="fa fa-minus-circle fared" aria-hidden="true"></i>
					<div class="col-md-12  ">
					 <p class=""> Attachments</p>
						<span class="dropdown">
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
					<div action="<?php echo base_url().index_page().'new_client/home/order_cache2/'.$cacheid; ?>" id="dropzonefileupload" class="dropzone margin-bottom-15" >  
						<div class="dz-default dz-message margin-top-55 margin-0"><span>You can attach or drag files here</span></div>
					</div>
				</div>	

			<!-- Required primary fields END -->


			<!-- file upload dropzone START-->
				<h5 class=" margin-top-30 "><span>Publication Information &nbsp;</span></h5>
			<div id="pub_lists2">
				<div class="row pub_list2">	
				<div id="showmpub1">
					
						<div class="col-md-3 col-sm-6 col-xs-6 ">
							<select class="form-control input-sm" name="pub_project_id2[]" id="pub_project_id2[]" >
								<option>Choose publication</option>
								<?php foreach($pub_list as $row){ ?>
									<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-6 ">
							<div class="input-group date muldate date-picker margin-bottom-15" data-date-format="M d" data-date-start-date="+0d">
								<input type="text" name="publish_date2[]" id="publish_date2[]" class="form-control input-sm" placeholder="Choose publication Date"   >
								<span class="input-group-btn" >
									<button class="btn btn-blue btn-sm" type="button" style="display:none;"><i class="fa fa-calendar"></i></button>
								</span>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-6 ">
							<select class="form-control input-sm" name="section_id2[]" id="section_id2[]">
								<option>Section</option>
								<?php foreach($section_list as $sec){ ?>
								<option value="<?php echo $sec['id']; ?>"><?php echo $sec['name']; ?></option>
								<?php } ?>
							</select>
						</div>
						<!--		
						<div class="col-md-3 col-sm-6 col-xs-6 ">
								    <button class="btn btn-sm btn-blue" id="addtxt"> Add </button>
						</div>
						-->
												 
				</div>
			</div>
			<div id="addpub2"></div>
			</div>
		</div>
	</div>
</section>
<section>
	<div class="container margin-top-20 ">  
		<div class=" backblack">
	 
			<div class="col-md-6 col-sm-6 col-xs-6 ">
				<p style="color:white;">Help?</p>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-6 ">
				<input id="cacheid" type="hidden" class="form-control input-sm" name="cacheid" value="<?php echo $cacheid;?>" >
				<button type="submit" name="os_submit"  class="btn btn-danger btn-sm  subbtn">Submit</button>
			</div>
		</div>				
	</div>
</section>

</form>	
<!-- file upload dropzone END-->
<!--<section>
	<div class="container margin-top-20 ">  
		<div class=" backblack">
	 
			<div class="col-md-6 col-sm-6 col-xs-6 ">
				<p style="color:white;">Help?</p>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-6 ">
				<button type="submit" name="os_submit"  class="btn btn-danger btn-sm  subbtn">Submit</button>
			</div>
		</div>				
	</div>
</section>				
-->
<script>
	var room = 1;
	function addcontact() {
	 
		room++;
		var objTo = document.getElementById('addpub')
		var divtest = document.createElement("div");
		divtest.setAttribute("class", "ol-lg-3 removeclass"+room);
		var rdiv = 'removeclass'+room;
		
		divtest.innerHTML = '<div class="row pub_list"><div class="col-md-3 col-sm-6 col-xs-6 "><select class="form-control input-sm" name="pub_project_id[]" required><option>Choose publication</option><?php foreach($pub_list as $row){ ?><option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option><?php } ?></select></div><div class="col-md-3 col-sm-6 col-xs-6"><div class="input-group date  date-picker margin-bottom-15 add_date" data-date-format="M d" data-date-start-date="+0d"><input type="text" name="publish_date[]" class="form-control input-sm" placeholder="Choose publication Date" onmouseover="datepick();" required><span class="input-group-btn"><button class="btn btn-blue btn-sm" type="button" style="display:none;"><i class="fa fa-calendar"></i></button></span></div></div><div class="col-md-3 col-sm-6 col-xs-6 "><select class="form-control input-sm" name="section_id[]" required><option>Section</option><?php foreach($section_list as $sec){ ?><option value="<?php echo $sec['id']; ?>"><?php echo $sec['name']; ?></option><?php } ?></select></div><div class="col-md-1 col-sm-2 col-xs-12"><div class="input-group-btn"><button class="btn" type="button" onclick="remove_addcontact_fields('+ room +');"> Remove </button></div></div></div>';
		objTo.appendChild(divtest);
		//$('#addpub div.pub_list').css("background-color", "");
		$("div").remove(".last_child"); 
		$('#pub_lists div.pub_list:last').append('<div class="col-md-2 col-sm-6 col-xs-12 last_child"><button style="cursor: pointer;position:relative;top: 5px;" onclick="addcontact();"> Add </button></div><div class="clearfix"></div>');
	}
	
   function remove_addcontact_fields(rid) {
	   $('.removeclass'+rid).remove();
	   $("div").remove(".last_child");
	   $('#pub_lists div.pub_list:last').append('<div class="col-md-2 col-sm-6 col-xs-12 last_child"><button style="cursor: pointer;position:relative;top: 5px;" onclick="addcontact();"> Add </button></div><div class="clearfix"></div>');
   }
   
	function datepick() { //alert('datpicker');
    	$('.add_date').addClass('muldate');
        $('.muldate').datepicker({
            dateFormat: 'yy-mm-dd',
			multidate: true
        });
	}
</script>

<script>
	var room2 = 1;
	function addcontact2() {
	 
		room2++;
		var objTo = document.getElementById('addpub2')
		var divtest = document.createElement("div");
		divtest.setAttribute("class", "ol-lg-3 removeclass2"+room2);
		var rdiv = 'removeclass2'+room2;
		
		divtest.innerHTML = '<div class="row pub_list2"><div class="col-md-3 col-sm-6 col-xs-6 "><select class="form-control input-sm" name="pub_project_id2[]" required><option>Choose publication</option><?php foreach($pub_list as $row){ ?><option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option><?php } ?></select></div><div class="col-md-3 col-sm-6 col-xs-6"><div class="input-group date  date-picker margin-bottom-15 add_date2" data-date-format="M d" data-date-start-date="+0d"><input type="text" name="publish_date2[]" class="form-control input-sm" placeholder="Choose publication Date" onmouseover="datepick2();" required><span class="input-group-btn"><button class="btn btn-blue btn-sm" type="button" style="display:none;"><i class="fa fa-calendar"></i></button></span></div></div><div class="col-md-3 col-sm-6 col-xs-6 "><select class="form-control input-sm" name="section_id2[]" required><option>Section</option><?php foreach($section_list as $sec){ ?><option value="<?php echo $sec['id']; ?>"><?php echo $sec['name']; ?></option><?php } ?></select></div><div class="col-md-1 col-sm-2 col-xs-12"><div class="input-group-btn"><button class="btn" type="button" onclick="remove_addcontact_fields2('+ room2 +');"> Remove </button></div></div></div>';
		objTo.appendChild(divtest);
		//$('#addpub div.pub_list').css("background-color", "");
		$("div").remove(".last_child2"); 
		$('#pub_lists2 div.pub_list2:last').append('<div class="col-md-2 col-sm-6 col-xs-12 last_child2"><button style="cursor: pointer;position:relative;top: 5px;" onclick="addcontact2();"> Add </button></div><div class="clearfix"></div>');
	}
	
   function remove_addcontact_fields2(rid) {
	   $('.removeclass2'+rid).remove();
	   $("div").remove(".last_child2");
	   $('#pub_lists2 div.pub_list2:last').append('<div class="col-md-2 col-sm-6 col-xs-12 last_child2"><button style="cursor: pointer;position:relative;top: 5px;" onclick="addcontact2();"> Add </button></div><div class="clearfix"></div>');
   }
   
	function datepick2() { //alert('datpicker');
    	$('.add_date2').addClass('muldate');
        $('.muldate').datepicker({
            dateFormat: 'yy-mm-dd',
			multidate: true
        });
	}
</script>
   
<script>
$(function() {
	//section
        $('#section_id').change(function(){
            $('.other_section').hide();
			var val = $(this).val();
            $('#' + val).show();
			
			if(val == 'other_section') { 
				$('#add_section').attr('required', 'required');
			} else {
				$('#add_section').removeAttr('required');
			}
			
        });
	//advertiser	
		$('#advertiser_name').change(function(){
            $('.other_advertiser').hide();
			var val = $(this).val();
            $('#' + val).show();
			
			if(val == 'other_advertiser') { 
				$('#add_advertiser').attr('required', 'required');
			} else {
				$('#add_advertiser').removeAttr('required');
			}
        });
    });
	
/*$("#order_form").submit(function(e){
	var pub_project_id_len =  $("[name='pub_project_id[]']:checked").length;
	
	if(pub_project_id_len == 0){
		alert('Please Select Publications Required..!!');
		e.preventDefault();
	}
});*/

</script>
<script>
	$(document).ready(function() {
	//add more publication
		$('#pub_lists div.pub_list:last').append('<div class="col-md-2 col-sm-6 col-xs-12 last_child"><button style="cursor: pointer;position:relative;top: 5px;" onclick="addcontact();"> Add </button></div><div class="clearfix"></div>');
		
		$('#pub_lists2 div.pub_list2:last').append('<div class="col-md-2 col-sm-6 col-xs-12 last_child2"><button style="cursor: pointer;position:relative;top: 5px;" onclick="addcontact2();"> Add </button></div><div class="clearfix"></div>');
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
	
	/*$(".muldate").datepicker({
     format: 'yyyy-mm-dd'
	});	*/
</script>			
<?php $this->load->view('new_client/footer');?>			