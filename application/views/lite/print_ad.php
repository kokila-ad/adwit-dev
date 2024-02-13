<?php $this->load->view("lite/head.php"); ?>
<?php $this->load->view("lite/header.php"); ?>
<style> .fa-info-circle{ cursor: pointer}</style>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
	<script>
			 $(document).ready(function(){
				 $("#advancesearch").hide();
				 $("#optional").hide();
				 
				 $("#showoptional").click(function(){
					$("#optional").toggle();      
				 });
				 
				 $("#showadvancesearch").click(function(){
					$("#advancesearch").toggle();  
					$("#search").toggle();  		
				  });
				 
				 $("#showsearch").click(function(){
					$("#advancesearch").toggle();  
					$("#search").toggle();  		
				  });  
				  
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

   <section>   
	<div class="container margin-top-40 center">   
<?php if(isset($order_credit['credits'])){ ?>                     
		<div class="padding-10 margin-bottom-20 border-theme">
			<p class="large">Credit Required - <?php echo $order_credit['credits']; ?> </p>
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<div class="row">
						<form action="<?php echo base_url().index_page()."lite/home/preorder/".$order_credit['id']; ?>" method="post">
							<div class="col-md-6 padding-right-0">
								<div><button class="form-control btn  btn-dark margin-top-10" type="submit" name="decline">Decline</button></div>
							</div>
							<div class="col-md-6 padding-right-0">
								<div><button class="form-control btn  btn-primary margin-top-10" type="submit" name="proceed">Proceed</button></div>
							</div>
						</form>	
					</div>
				</div>
			</div>
		</div>	
<?php } ?>	
		<p>Place New Order</p>  
			<a href="<?php echo base_url().index_page().'lite/home/print_ad';?>" class="btn btn-sm btn-dark btn-active margin-right-5">Print Ad</a>
			<a href="<?php echo base_url().index_page().'lite/home/online_ad';?>" class="btn btn-sm btn-dark btn-outline">Online Ad</a>
		
      </div>
   </section>
   
   <section>
    <div class="container margin-top-40"> 
<?php echo $this->session->flashdata('message'); ?>	
	<form role="form" action="" method="post" name="order_form" id="order_form" >
	  <div class="row">
		<div class="col-md-6 col-sm-6 col-xs-12">
		<!-- Advertiser Name -->
		   <p class="margin-bottom-5<?php if(null != form_error('advertiser_name')):?> text-red<?php endif;?>">Advertiser Name<?php if(null != form_error('advertiser_name')):?><span class="text-red"> Required</span>
		   <?php endif;?>
		   <span class="text-red">*</span><small class="text-grey"> (any alphanumeric of your choice)<span class="margin-left-5" data-toggle="tooltip" data-placement="right" data-html="true" title="Enter the Advertiser for whom this ad is being produced. <br/>You can use a combination of numbers and letters in this field. No special characters are allowed."> <i class="fa fa-info-circle"></i></span> </small></p>
		   <input type="text" name="advertiser_name" pattern="[a-zA-Z0-9 ]{1,50}" value="<?php echo set_value('advertiser_name');?>"
		   class="form-control input-sm margin-bottom-15" <?php if(null != form_error('advertiser_name')):?>style="border: 1px solid red"<?php endif;?> ng-model="job" required>		  
		<!-- Unique Job Name -->
		   <p class="margin-bottom-5<?php if(null != form_error('job_no')):?> text-red<?php endif;?>">Unique Job Name / Number <?php if(null != form_error('job_no')): ?><span class="text-red"> Required</span><?php endif;?>		   				
		   <span class="text-red">*</span> <small class="text-grey">(any alphanumeric of your choice)<span class="margin-left-5" data-toggle="tooltip" data-placement="right" data-html="true" title="A combination of numbers and/or letters that you can use to identify and reference this ad internally. <br/>Again, no special characters allowed."> <i class="fa fa-info-circle"></i></span> </small></p>	
	       <input type="text" name="job_no" pattern="[a-zA-Z0-9 ]{1,50}" value="<?php echo set_value('job_no');?>"
		   class="form-control input-sm margin-bottom-15"  <?php if(null != form_error('advertiser_name')):?>style="border: 1px solid red"<?php endif;?> required>	
		<!-- copy_content_description -->
			<p class="margin-bottom-5<?php if(null != form_error('copy_content_description')):?> text-red<?php endif;?>">Copy, Content, Text <?php if(null != form_error('copy_content_description')): ?><span class="text-red"> Required</span>
		   <?php endif;?>	
		   <span class="text-red"> *</span><small class="text-grey margin-left-5" data-toggle="tooltip" data-placement="right" title="Enter the headline, body copy and footer content that goes into the ad. If possible please enter each part on a seperate line. This can prevent any obvious errors."> <i class="fa fa-info-circle"></i></small></p>
		   <textarea rows="3" name="copy_content_description" class="form-control input-sm margin-bottom-15" <?php if(null != form_error('copy_content_description')):?>style="border: 1px solid red"<?php endif;?> required><?php echo set_value('copy_content_description');?></textarea>
		</div>
		
	    <div class="col-md-6 col-sm-6 col-xs-12">
			<div class="row">
	            <div class="col-md-6 col-sm-6 col-xs-6">
					<p class="margin-bottom-5<?php if(null != form_error('width')):?> text-red<?php endif;?>">
					Width<?php if(null != form_error('width')):?> Required<?php endif;?> 
					<span class="text-red">*</span> <small class="text-grey">(in inches)</small><small class="text-grey margin-left-5" data-toggle="tooltip" data-placement="right" title="Width of the ad in inches. Upto 4 decimal places are allowed."> <i class="fa fa-info-circle"></i></small>
					</p>
					 <input type="number" name="width" max="999" min="1" step="0.0001" value="<?php echo set_value('width'); ?>" class="form-control input-sm  margin-bottom-15" <?php if(null != form_error('width')):?> style="border: 1px solid red"<?php endif;?> required>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-6">
					<p class="margin-bottom-5<?php if(null != form_error('height')):?> text-red<?php endif;?>">Height<?php if(null != form_error('height')):?> Required<?php endif;?> 
					<span class="text-red">*</span> <small class="text-grey">(in inches)</small> <small class="text-grey margin-left-5" data-toggle="tooltip" data-placement="right" title="Height of the ad in inches. Upto 4 decimal places are allowed."> <i class="fa fa-info-circle"></i></small></p>
					
					 <input type="number" name="height" max="999" min="1" step="0.0001" value="<?php echo set_value('height'); ?>" class="form-control input-sm  margin-bottom-15" <?php if(null != form_error('height')):?> style="border: 1px solid red"<?php endif;?>  required>
				</div>
			</div> 
			
			<p class="margin-bottom-5<?php if(null != form_error('print_ad_type')):?> text-red<?php endif;?>">Color / B&W <?php if(null != form_error('print_ad_type')):?> Required
			<?php endif;?> 			
			<span class="text-red"> * </span><small class="text-grey">(select one)</small><small class="text-grey margin-left-5" data-toggle="tooltip" data-placement="right" title="Process Color or B&W ad."> <i class="fa fa-info-circle"></i></small>
			</p>
			<div class="row margin-bottom-5">
			    <div class="col-sm-12">
					<div class="btn-group" data-toggle="buttons">
					<?php $result = $this->db->get('lite_color_preference')->result_array();
							foreach($result as $row){
								if($row['name'] != 'Spot'){
					?>
						<label class="btn btn-sm btn-default margin-right-10 margin-bottom-10">
							<input type="radio" name="print_ad_type" value="<?php echo $row['id'];?>" <?php echo set_radio('print_ad_type', $row['id']); ?> required> <?php echo $row['name'];?>
						</label> 
					<?php } } ?> 
					</div>
				</div>   
		   </div>
					   
		   <p class="margin-bottom-5"> Notes &amp; Instructions<small class="text-grey margin-left-5" data-toggle="tooltip" data-placement="right" data-html="true" title="Please enter any special instructions for this ad. If we have to refer to a particular file or website, please indicate it here. Any special advertiser preferences or standard themes need to be mentioned here. <br/>Please be as specific as possible."> <i class="fa fa-info-circle"></i></small></p>
		   <textarea rows="3" name="notes" class="form-control input-sm margin-bottom-15"><?php echo set_value('notes');?></textarea>	
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
					<input id="date_needed" type="text" class="form-control input-sm" name="date_needed">
					<span class="input-group-btn">
					<button class="btn btn-sm btn-dark" type="button"><i class="fa fa-calendar"></i></button>
					</span>
				</div>
				<!--<p class="margin-bottom-5<?php if(null != form_error('date_needed')):?> text-red<?php endif;?>">Date Needed<?php if(null != form_error('date_needed')):?> Required
				<?php endif;?> 			
				<span class="text-red"> * </span><small class="text-grey">(select one)</small><small class="text-grey margin-left-5" data-toggle="tooltip" data-placement="right" title="Ex: abc123"> <i class="fa fa-info-circle"></i></small>
				</p>
				<div class="row margin-bottom-5">
					<div class="col-sm-12">
						<div class="btn-group" >
						<?php $result = $this->db->get('lite_credit_date')->result_array();
								foreach($result as $row){
						?>
							<label class="btn btn-sm btn-default margin-right-10 margin-bottom-10 ">
								<input type="radio" value="<?php echo $row['num_days'];?>"  id="date_needed" name="date_needed" <?php echo set_radio('date_needed', $row['num_days']); ?> ><?php echo $row['name'];?>	
							</label>
						<?php } ?>
						</div>
					</div>   
			   </div>-->
			
			  
				<p class="margin-bottom-5">Publication Name<small class="text-grey margin-left-5" data-toggle="tooltip" data-placement="right" title="Name of the publication that this ad will be printed in."> <i class="fa fa-info-circle"></i></small></p>
			   <input type="text" name="publication_name" class="form-control input-sm  margin-bottom-15" title="">
			   
			   <p class="margin-bottom-5">Font Preferences <small class="text-grey margin-left-5" data-toggle="tooltip" data-placement="right" title="Any specific or special fonts that need to be used in part or the entire ad."> <i class="fa fa-info-circle"></i></small></p>
			   <input type="text" name="font_preferences" class="form-control input-sm margin-bottom-15" title="">
			
			</div>
			
			<div class="col-md-6 col-sm-6 col-xs-12"> 

			<p class="margin-bottom-5">Color Preferences<small class="text-grey margin-left-5" data-toggle="tooltip" data-placement="right" title="Enter any special color preferences that either you or the advertiser likes. Our designers will use these as guidelines."> <i class="fa fa-info-circle"></i></small></p>
			  <input type="text" name="color_preferences" class="form-control input-sm margin-bottom-15" title="">
			
			<p class="margin-bottom-5">Job Instructions <small class="text-grey">(select one)</small><small class="text-grey margin-left-5" data-toggle="tooltip" data-placement="right" title="Indicate whether we are to follow your instructions to the T, if we have freedom to be creative or if we are to use an existing camera ready document and place it in the correct size on PDF."> <i class="fa fa-info-circle"></i></small></p>
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
			
				<p class="margin-top-5 margin-bottom-5">Art Work <small class="text-grey">(select one)</small><small class="text-grey margin-left-5" data-toggle="tooltip" data-placement="right" title="Check if we are to use creative freedom to modify art, use customer supplied art, or source additional art from our subscription to stock image databases."> <i class="fa fa-info-circle"></i></small></p>
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
			<div class="col-xs-12 text-right margin-top-5 margin-bottom-30">
				<div class="padding-top-15">
					
						<!--<?php if($publication['id']=='43' || $publication['id']=='13'){  ?> 
							<p><input type="checkbox" name="rush" value="1" class="margin-right-5"> 
							<span class="margin-right-10  text-grey"><label>Rush if possible</label></span>
						<?php } ?>	-->
							<?php $adrep = $this->db->get_where('adreps',array('id'=>$this->session->userdata('lcId')))->result_array();
								if($adrep[0]['rush']=='1') { ?>
							<p><input type="checkbox" name="rush" value="1" <?php echo set_checkbox('rush', '1'); ?>> 
							<span class="margin-right-10  text-grey"><label>Rush if possible</label></span>
							<?php } ?>
						<?php if(!isset($order_credit['credits'])){ ?>
						<!--<span>Total Credit Required: {{ sqinches_credits }}</span>-->
						<button type="submit" name="submit" value="Submit" class="btn btn-blue btn-sm">Submit</button>
						<?php } ?>
				</div>	
			</div>
		 </div>
	</div>
	</form>
	</div>
   </section>
	
<!--
<script>
var app = angular.module('myApp', []);
app.controller('formCtrl', ['$scope', function($scope) {
    
	$scope.sqinch = function(){ alert('keydown');
		var sqinches = $scope.width * $scope.height;
		
		<?php 
		$lite_credit_sqinch = $this->db->get('lite_credit_sqinch')->result_array();
		$max = $this->db->query('SELECT MAX(`max_inch`), MAX(`credits`)  FROM `lite_credit_sqinch`')->row_array();
		
		$max_inch_value = $max['MAX(`max_inch`)'];
		$max_inch_credit = $max['MAX(`credits`)'];
		
		?>
		if(sqinches > '<?php echo $max_inch_value; ?>'){
			$scope.sqinches_credits = <?php echo round($max_inch_credit,1); ?>;
		}else{
			<?php foreach($lite_credit_sqinch as $row){ ?>
				if(sqinches >= '<?php echo $row['min_inch'] ?>' && sqinches <= '<?php echo $row['max_inch'] ?>'){
					$scope.sqinches_credits = '<?php echo $row['credits']; ?>';
					 //break; 
				}
			<?php } ?>
		}
	}
	
}]);
</script>
-->			
<?php $this->load->view("lite/footer.php"); ?>
 <?php $this->load->view("lite/foot.php"); ?>		