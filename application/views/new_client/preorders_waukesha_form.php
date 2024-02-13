<?php $this->load->view('new_client/header');?>
<!-- check box readonly -->
<style> 
    input[type="checkbox"][readonly] {
        pointer-events: none;
    }
</style>
<div id="main"> 
   
   <section>
     <div class="container margin-top-40">   
	 <form method="post" name="order_form" id="order_form">
	  <div class="row">
	      
	   <div class="col-md-6 col-sm-6 col-xs-12">
	       <p class="margin-bottom-5">Keyword </p>
	            <input type="text" name="Keyword" class="form-control input-sm margin-bottom-15" value="<?php echo $xml_file_data[0]['adtitle']; ?>">
	       
		   <p class="margin-bottom-5">Advertiser Name <span class="text-red">*</span></p>
	            <input type="text" name="advertiser_name" class="form-control input-sm margin-bottom-15" value="<?php echo $xml_file_data[0]['customer_name']; ?>">

		   <p class="margin-bottom-5">Unique Job Name / Number <span class="text-red">*</span> <small class="text-grey">(any alphanumeric of your choice)</small> </p>
	            <input type="text" name="job_no" pattern="[a-zA-Z0-9 ]{1,50}" class="form-control input-sm margin-bottom-15" value="<?php echo $xml_file_data[0]['ad_number']; ?>" readonly >
		   
		   <p class="margin-bottom-5">User Name</p>
			   <input type="text" name="user_name" class="form-control input-sm  margin-bottom-15" value="<?php echo $xml_file_data[0]['user']; ?>" readonly>
			
    		<?php 
    				$pub_project = $this->db->get_where('pub_project',array('pub_id' => '580'))->result_array();
    				$pre_select_pub = '';
    				if(isset($xml_file_data_publication[0]['publication'])) $pre_select_pub = strtoupper($xml_file_data_publication[0]['publication']); 
    		?>	
    		<p class="margin-bottom-5">Publication Name</p> 
    			<select class="form-control input-sm margin-bottom-15"  name="project_id" >
    				<option value="">Select</option> 
    				<?php 
    				    foreach($pub_project as $project){ 
    				        $pub_name = strtoupper($project['name']);
    				?>
    				<option value="<?php echo $project['id']; ?>" <?php if(strcmp($pub_name, $pre_select_pub) == 0) echo 'selected'; ?>><?php echo $project['name']; ?></option>
    				<?php } ?>
    			</select>   
    	
		   <?php if($xml_file_data[0]['order_type'] == 'Online'){ ?> 
	       <p class="margin-bottom-5">Maximum File Size <span class="text-red"> * </span></p>
	            <input type="text" name="maximum_file_size" class="form-control input-sm margin-bottom-15" title="" required="">         
		   <?php } ?>
		   
		    <p class="margin-bottom-5">Additional Color option</p>
		    <?php if($xml_file_data[0]['output_type'] == 2){  $additional_color='B&W'; }else{ $additional_color=''; } ?>
			   <input type="text" name="additional_color" class="form-control input-sm  margin-bottom-15" value="<?php echo $additional_color; ?>" >
			   
		  <p class="margin-bottom-5">Copy, Content, Text<span class="text-red"> *</span></p>
		       <textarea rows="3" name="copy_content_description" class="form-control input-sm margin-bottom-15" required=""></textarea>
		       
		   <?php if($xml_file_data[0]['camera_ready'] == 'true'){ ?>
		   <p class="margin-bottom-15"> <input type="checkbox" name="camera_ready" value="true" checked readonly> Customer File</p>
		        <!--<input type="camera_ready" value="Yes" class="form-control input-sm margin-bottom-15" readonly>-->
		  <?php } ?>
	   </div>
	    
	   <div class="col-md-6 col-sm-6 col-xs-12">
	       <p class="margin-bottom-5">Ad Type </p>
	       <input type="text" name="adtype" class="form-control input-sm margin-bottom-15" value="<?php echo $xml_file_data[0]['adtype']; ?>">
	       
			<div class="row margin-bottom-5">
	           <div class="col-md-7 col-sm-12 col-xs-12">
					 <p class="margin-bottom-5">Width <span class="text-red">*</span> <?php if($xml_file_data[0]['order_type'] == 'Online') echo'<small class="text-grey">(in pixels)</small>'; else echo'<small class="text-grey">(in inches)</small>'; ?></p>
					 <input type="number" name="width" max="99" min="1"  step="0.0001" class="form-control input-sm margin-bottom-10" value="<?php echo $xml_file_data[0]['width']; ?>" required="">
				</div>
				<div class="col-md-5 col-sm-12 col-xs-12"> 
					<p class="margin-bottom-5">Height <span class="text-red">*</span> <?php if($xml_file_data[0]['order_type'] == 'Online') echo'<small class="text-grey">(in pixels)</small>'; else echo'<small class="text-grey">(in inches)</small>'; ?></p>
					<input type="number" name="height" max="99" min="1"  step="0.0001" class="form-control input-sm margin-bottom-10" value="<?php echo $xml_file_data[0]['height']; ?>" required="">
				</div> 
			</div>
			<?php if($xml_file_data[0]['order_type'] == 'Online'){ ?>
			    <p class="margin-bottom-5">Format <span class="text-red">*</span><small class="text-grey">(select one)</small></p>
    		    <div class="row margin-bottom-5">
    			   <div class="col-sm-12">
    				 <div class="btn-group" data-toggle="buttons">
    				<?php 
    					$results = $this->db->get('web_ad_formats')->result_array();
    					  foreach($results as $result){
    				?>
    							<label class="btn btn-sm btn-default margin-right-10 margin-bottom-10" >
    								<input type="radio" name="ad_format" value="<?php echo $result['id']; ?>" required=""> 
    								<?php echo $result['name']; ?>
    							</label> 
    				<?php } ?>
        
    				  </div>
    				</div>   
    		   </div>
		   
			    <p class="margin-bottom-5">Web Ad Type<span class="text-red"> * </span><small class="text-grey">(select one)</small></p>
    		    <div class="row margin-bottom-5">
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
    		    
			<?php }else{ ?>
			 <p class="margin-bottom-5">Full Color / B&W / Spot<span class="text-red"> * </span><small class="text-grey">(select one)</small></p>
    		    <div class="row margin-bottom-5">
    			   <div class="col-sm-12">
    				<div class="btn-group" data-toggle="buttons">
    					<label <?php if($xml_file_data[0]['numberofcolors']=='Full Color') { ?> class="active btn btn-default btn-sm margin-right-10 margin-bottom-10" <?php } else { ?> class=" btn btn-default btn-sm margin-right-15 margin-bottom-5" <?php } ?>>
    						<input type="radio" name="color" value="1" required="" <?php if($xml_file_data[0]['numberofcolors']=='Full Color'){echo 'checked="checked"';} ?>> Full Color
    					</label> 
    					<label <?php if($xml_file_data[0]['numberofcolors']=='B&W' || $xml_file_data[0]['numberofcolors']=='') { ?> class="active btn btn-default btn-sm margin-right-10 margin-bottom-10" <?php } else { ?> class=" btn btn-default btn-sm margin-right-15 margin-bottom-5" <?php } ?>>
    						<input type="radio" name="color" value="2" required="" <?php if($xml_file_data[0]['numberofcolors']=='B&W' || $xml_file_data[0]['numberofcolors']==''){echo 'checked="checked"';} ?>> B&amp;W
    					</label> 
    					<label <?php if($xml_file_data[0]['numberofcolors']=='Spot') { ?> class="active btn btn-default btn-sm margin-bottom-10" <?php } else { ?> class=" btn btn-default btn-sm margin-right-15 margin-bottom-5" <?php } ?>>
    						<input type="radio" name="color" value="3" required="" <?php if($xml_file_data[0]['numberofcolors']=='Spot'){echo 'checked="checked"';} ?>> Spot
    					</label>  
    				  </div>
    				</div>   
    		    </div>
		    <?php } ?>	
			
			    
					<p class="margin-bottom-5">Publish Date</p>
    				<div class="input-group date date-picker margin-bottom-15" data-date-format="yyyy/mm/dd" data-date-start-date="+0d">
    					<input id="publish_date" type="text" class="form-control input-sm datepickerautoff" autocomplete="off" name="publish_date" value="<?php if(isset($xml_file_data[0]['run_date']) && !empty($xml_file_data[0]['run_date'])) echo date('Y-m-d', strtotime($xml_file_data[0]['run_date'])); ?>">
    					<span class="input-group-btn">
    					<button class="btn btn-sm btn-dark" type="button"><i class="fa fa-calendar"></i></button>
    					</span>
    				</div>
				
					<p class="margin-bottom-5">Proof by</p>
    				<div class="input-group date date-picker margin-bottom-15" data-date-format="yyyy/mm/dd" data-date-start-date="+0d">
    					<input id="date_needed" type="text" class="form-control input-sm datepickerautoff" autocomplete="off" name="date_needed" value="<?php if(isset($xml_file_data[0]['duedate']) && !empty($xml_file_data[0]['duedate'])) echo date('Y-m-d', strtotime($xml_file_data[0]['duedate'])); ?>">
    					<span class="input-group-btn">
    					<button class="btn btn-sm btn-dark" type="button"><i class="fa fa-calendar"></i></button>
    					</span>
    				</div>
				
			
		
		<!--	
	        <p class="margin-bottom-5">Proof by</p>
				<div class="input-group date date-picker margin-bottom-15" data-date-format="mm/dd/yyyy" data-date-start-date="+0d">
					<input id="date_needed" type="text" class="form-control input-sm datepickerautoff" autocomplete="off" name="date_needed" value="<?php echo $xml_file_data[0]['duedate']; ?>">
					<span class="input-group-btn">
					<button class="btn btn-sm btn-dark" type="button"><i class="fa fa-calendar"></i></button>
					</span>
				</div> -->
		    <?php //if($xml_file_data[0]['pickupadnumber'] != NULL){ ?>
			    <p class="margin-bottom-5">PickUp Ad Number </p>
	            <input type="text" name="pickupadnumber" class="form-control input-sm margin-bottom-15" value="<?php echo $xml_file_data[0]['pickupadnumber']; ?>">
	       <?php //} ?>
			<p class="margin-bottom-5"> Notes &amp; Instructions</p>
				<textarea rows="3" name="notes" class="form-control input-sm margin-bottom-15">
				<?php if($xml_file_data[0]['output_type'] == '2') echo 'Additional colour option - B&W.'; ?> 
				<?php echo $xml_file_data[0]['instruction']; ?> 
				</textarea>	
		   			
		</div> 
	  </div>
	  
	  <!-- file upload dropzone START-->	
	<div class="margin-top-10 margin-bottom-15">
	<section>
		 
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
	
	</section>
	</div>
<!-- file upload dropzone END-->

	 <?php if(isset($xml_file_data_publication[0]['publication'])){ ?> 
	    <div class="row">
	        <div class="col-md-6 col-sm-6 col-xs-12">
	        <p class="margin-bottom-5">Publication </p>
	        <table class="table table-striped table-bordered ">
	            <tbody>
	                <?php foreach($xml_file_data_publication as $publication){ ?>
	                <tr>
	                   <td><?php echo $publication['publication'] ?></td> 
	                </tr>
	                <?php } ?>
	            </tbody>
	        </table>
	        </div>
	    </div>
	<?php } ?>	
		<div class="row">	
			<div class="col-xs-12 text-right margin-top-5">
				<div class="padding-top-15">
					<?php $adrep = $this->db->get_where('adreps',array('id'=>$this->session->userdata('ncId')))->result_array();
								if($adrep[0]['rush']=='1') { ?>
									<p><input type="checkbox" name="rush" value="1"> 
									<span class="margin-right-10  text-grey"><label>Rush if possible</label></span>
						<?php } ?>
					<input name="id" value="<?php echo $xml_file_data[0]['id'];?>" readonly style="display:none;" />
					<input id="cacheid" type="hidden" class="form-control input-sm" name="cacheid" value="<?php echo $cacheid;?>" >
					<input class="btn btn-blue btn-sm" name="order_submit" type="submit" value="Submit" />
        
				</div>	
			</div>
		 </div>
	</form>
	</div>
   </section>
	
</div>
			
<?php if($this->session->userdata('ncId')=='36'){ $this->load->view('new_client/privacy_footer'); }else{ $this->load->view('new_client/footer'); } ?>

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

</script>