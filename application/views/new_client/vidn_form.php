<?php $this->load->view('new_client/header');?>

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
		$("select").change(function(){
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
		$("select").change(function(){
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
</script>
<div id="main"> 
<div class="container margin-top-40">
	<div class="row">
		<div class="col-md-12 center">
			<div class="btn-group " >
				<a class="btn btn-sm btn-default margin-right-10 margin-bottom-10 active" href="<?php echo base_url().index_page().'new_client/home/vidn_form';?>" >
					 New Ad
				</a>
			</div>
		</div>   
	</div>
</div>	
 <!-- New --> 
 
   <section>
    <div class="container margin-top-40">   
	<form action="<?php echo base_url().index_page().'new_client/home/vidn_form';?>" method="post" name="order_form" id="order_form">
	  <div class="row">
		<?php //echo $this->session->flashdata('message'); 
    		if ($this->session->flashdata('message')) {
                    echo '<script>
                        $(document).ready(function() {
                            $("#errorModal").modal("show");
                        });
                    </script>';
                }
		?>
		<?php if(isset($num_errors) && $num_errors!=0):?>
		<h3 style="color:#900;">Please check for the errors below!</h3>
			<div class="errors_list">
				<ul >
					<?php echo validation_errors();?>
				</ul>
			</div>
		<?php endif;?>
	
	   <div class="col-md-6 col-sm-6 col-xs-12"  ng-app="myApp" ng-controller="checkboxController">
			<p class="margin-bottom-5<?php if(null != form_error('job_no')):?> text-red<?php endif;?>">Unique Job Name / Subject Line<?php if(null != form_error('job_no')): ?>
		   <span class="text-red"> Required</span><?php endif;?>		   				
		   <span class="text-red">*</span> <small class="text-grey">(any alphanumeric of your choice) </small></p>		   
	       <input type="text" name="job_no" pattern="[a-zA-Z0-9 ]{1,50}" value="<?php echo set_value('job_no');?>"
		   class="form-control input-sm margin-bottom-15"  <?php if(null != form_error('advertiser_name')):?>style="border: 1px solid red"<?php endif;?> required >
		   
			<p class="margin-bottom-5">Client Name<small class="text-grey"> (any alphanumeric of your choice)</small></p>
	       <input type="text" name="advertiser_name" value="<?php echo set_value('advertiser_name');?>"
		   class="form-control input-sm margin-bottom-15"  >
		   
		   <p class="margin-bottom-5">Copy, Content, Text, Instruction</p>
		   <textarea ng-model="data" rows="5" name="copy_content_description" class="form-control input-sm margin-bottom-15" ><?php echo set_value('copy_content_description');?></textarea>	
		</div>
		
	    <div class="col-md-6 col-sm-6 col-xs-12">
			
<!----- Start of Size -->		
			
			<div class="row margin-bottom-15 custom box">
	           <div class="col-md-6 col-sm-6 col-xs-6">
					 <p class="margin-bottom-5">Width <small class="text-grey">(in inches)</small></p>
					 <input type="number" id="width" name="width" max="99" min="1" step="0.0001"  class="form-control input-sm" <?php echo set_value('width');?> required>
				</div>
					 
					 
			    <div class="col-md-6 col-sm-6 col-xs-6"> 
					<p class="margin-bottom-5">Height <small class="text-grey">(in inches)</small></p>
					<input type="number" id="height" name="height" max="99" min="1" step="0.0001" class="form-control input-sm" <?php echo set_value('height');?> required>
				</div>
			</div> 
<!----- End of Size -->		
			
			<p class="margin-bottom-5">Full Color / B&W / Spot <small class="text-grey">(select one)</small></p>
		    <div class="row margin-bottom-5">
			    <div class="col-sm-12">
					<div class="btn-group" data-toggle="buttons">
						<label class="btn btn-sm btn-default margin-right-10 margin-bottom-10">
							<input type="radio" name="print_ad_type" value="1" <?php echo set_radio('print_ad_type', '1'); ?> required> Full Color
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
		<!-- Drag&Drop -->
		<!--<div action="<?php echo base_url().index_page().'new_client/home/vidn_order_fileupload/'.$cacheid; ?>" class="dropzone margin-top-15 margin-bottom-25" >-->
		<div action="<?php echo base_url().index_page().'new_client/home/order_fileupload/'.$cacheid; ?>" class="dropzone margin-top-15 margin-bottom-25" >
			<div class="dz-default dz-message margin-top-55 margin-0"><span>You can attach or drag files here</span></div>
		</div>
		  	
		</div> 
	  </div>
	  
		<input id="cacheid" type="hidden" class="form-control input-sm" name="cacheid" value="<?php echo $cacheid;?>" >
		
		<div class="row">	
			<div class="col-xs-12 text-right">					
				<button type="submit" name="without_file_submit" onclick="required()" class="btn btn-danger btn-sm padding-horizontal-30">Order Now</button>
			</div>
		 </div>
	</form>

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
			
<?php $this->load->view('new_client/footer');?>			