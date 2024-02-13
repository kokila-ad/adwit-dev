<?php $this->load->view("lite/head.php"); ?>
<?php $this->load->view("lite/header.php"); ?>
<style>
.file_li {
   // width: 350px;
	min-width: 250px;
   // overflow-x: hidden;
}
.min-height-155 {
	min-height: 155px;
}
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
	$(document).ready(function() {
	   function RefreshTable() {
		   $( "#mytable" ).load( "<?php echo base_url().index_page()."lite/home/view_uploaded_files/".$order_details[0]['id'];?> #mytable" );
	   }
	   $("#view").on("click", RefreshTable);
	});	
</script>

<div id="main">
<!-- <form method="post">-->

<section>
    <div class="container margin-top-30"> 
		<div class="row margin-0">	 
			<div class="col-md-2 col-sm-12 col-xs-12 margin-vertical-10 padding-0 text-grey">
				<span class="margin-right-15">AdwitAds Id: <span class="text-dark"><?php echo $order_details[0]['id'];?></span></span>
			</div>
			<div class="col-md-4 col-sm-12 col-xs-12 margin-vertical-10 padding-0 text-grey">
				<span>Unique Job Name / Number: <span class="text-dark"><?php echo $order_details[0]['job_no'];?></span></span>
			</div>
						
			<div class="col-md-6 col-sm-12 col-xs-12 margin-vertical-10 padding-0 text-right small">
				<span class="margin-right-5 text-grey">
					<a href="<?php echo base_url().index_page().'lite/home/dashboard';?>"><i class="fa fa-mail-reply padding-right-5 text-grey"></i></a> |
				</span>
				<span class="margin-0 text-grey">
					<?php $action_name = $this->db->get_where('adrep_actions',array('id'=> $action_id))->result_array();
					   echo $action_name[0]['name'];
					 ?>
				</span>
				
				<span class="dropdown margin-left-5 text-grey">|
						<span class="cursor-pointer padding-left-5" type="button" data-toggle="dropdown" id="view">View Uploaded Files
						<span class="caret margin-left-5"></span></span>
													
						<div class="table-responsive dropdown-menu file_li ">  							 
								<table class="table table-striped table-hover" id="mytable">
								 <tbody>
								<?php if(isset($file_names)) { $i=1;  foreach($file_names as $row)  { ?>
									 <tr>
										<td><?php echo $i ?></td>
										<td><a href="<?php echo base_url().'downloads/'.$order_details[0]['id'].'-'.$order_details[0]['job_no'].'/'.$row;?>" target="_blank"><?php echo $row; 	$i++; ?></a></td>
										<td><a href="<?php echo base_url().'download.php?file_source='.$order_details[0]['file_path'].'/'.$row; ?>" target="_blank"><i class="fa fa-download"></i></a></td>
										 </tr>
								<?php  } }?> 
								</tbody>
							 </table>
						</div>
					</span>
			</div>
		</div>
	</div>
</section>

<?php if($action == "pickup") { ?>
<section id="pickup">
    <div class="container">
		<form method="post">	      
        <div class="row margin-top-30">
			   <div class="col-md-6 col-sm-6 col-xs-12 margin-bottom-15">
               <p class="margin-bottom-5">Advertiser Name <span class="text-red">*</span> </p>
               <input type="text" name="advertiser_name" value="<?php echo $order_details[0]['advertiser_name']; ?>" class="form-control input-sm margin-bottom-15" title="" required>
               
               <p class="margin-bottom-5">New Unique Job Name / Number <span class="text-red">*</span> <small class="text-grey">(any alphanumeric of your choice)</small> </p>
               <input type="text" name="job_no" pattern="[a-zA-Z0-9 ]{1,50}" value="<?php echo $order_details[0]['job_no']; ?>" class="form-control input-sm margin-bottom-15" title="" required>
               
			   <p class="margin-bottom-5">Copy, Content, Text </p>
               <textarea rows="4" name="copy_content_description" value="<?php echo $order_details[0]['copy_content_description']; ?>" class="form-control margin-bottom-15" title="" ></textarea>
			
			   <p>Notes & Instructions</p>
               <textarea rows="4" name="notes" value="<?php echo $order_details[0]['notes']; ?>" class="form-control" title=""></textarea> 			   
            </div>
			
			<div class="col-md-6 col-sm-6 col-xs-12 margin-bottom-15">
				<p class="margin-bottom-5">Pickup Order Type</p>			
					<div>
						<a href="<?php echo base_url().index_page().'lite/home/order_action/pickup/'.$order_details[0]['id'].'/print';?>"
							<?php if($pickup=='print') { ?> class="btn btn-sm btn-dark btn-outline btn-active margin-right-10" <?php } else { ?> class="margin-right-10 btn btn-sm btn-dark btn-outline" <?php } ?> >Print Ad</a>
						<!--<a href="<?php echo base_url().index_page().'lite/home/order_action/pickup/'.$order_details[0]['id'].'/online';?>" 
							<?php if($pickup=='online') { ?> class="btn btn-sm btn-dark btn-outline btn-active margin-right-10" <?php } else { ?> class="margin-right-10 btn btn-sm btn-dark btn-outline" <?php } ?> >Online Ad</a>-->
					</div>
			</div>
			
			<?php if(isset($pickup) && $pickup == 'print') { ?>
			
            <div class="col-md-6 col-sm-6 col-xs-12">
			
			
			
				<div class="row margin-bottom-15">
                  <div class="col-md-6 col-sm-6 col-xs-6"> 
					<p class="margin-bottom-5">New Width <span class="text-red">*</span> <small class="text-grey">(in inches)</small></p>
					<input type="number" name="width" max="99" min="1"  step="0.0001" value="<?php echo $order_details[0]['width']; ?>" class="form-control input-sm" title="width" required>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-6">
					<p class="margin-bottom-5">New Height <span class="text-red">*</span> <small class="text-grey">(in inches)</small></p>
					<input type="number" name="height" max="99" min="1"  step="0.0001" value="<?php echo $order_details[0]['height']; ?>" class="form-control input-sm" title="height" required>
				</div>
               </div> 
			
			<p class="margin-bottom-5">Full Color / B&W / Spot<span class="text-red"> *</span></p>
				<div class="row  margin-bottom-5">
				<div class="col-sm-9">
					<div class="btn-group" data-toggle="buttons">
                   <?php $print_ad_type = $this->db->query("SELECT * FROM `print_ad_types`")->result_array();
					 foreach($print_ad_type as $row){ 
					?>
						 
					 <label <?php if($row['id'] == $order_details[0]['print_ad_type']) { ?> class="active btn btn-default btn-sm margin-right-15 margin-bottom-5" <?php } else { ?> class=" btn btn-default btn-sm margin-right-15 margin-bottom-5" <?php } ?>>
					<input type="radio" name="print_ad_type" value="<?php echo $row['id'];?>"  <?php if($row['id'] == $order_details[0]['print_ad_type']){ echo 'checked="checked"';  } ?> required > <?php echo $row['name'];?>
                    </label> 
					
					<?php }	?>
					 
                  </div>
                </div>   
                </div>	
              
 		   
            </div> 
			<div class="col-md-12 col-sm-12 col-xs-12">
                <button type="submit" class="btn btn-blue btn-sm float-right  margin-top-20" name="print_pickup_submit">Submit</button>
            </div>			
            <?php }	?>
			
			<?php if(isset($pickup) && $pickup == 'online') { ?>
			
			 <div class="col-md-6 col-sm-6 col-xs-12">
			<p class="margin-bottom-5">Format<span class="text-red"> * </span><small class="text-grey">(select one)</small></p>
		    <div class="row margin-bottom-5">
			   <div class="col-sm-12">
				 <div class="btn-group" data-toggle="buttons">
				 
        <?php $web_ad_formats = $this->db->get('web_ad_formats')->result_array();
			  foreach($web_ad_formats as $result){ ?>
			  <label <?php if($result['id'] == $order_details[0]['ad_format']) { ?> class="active btn btn-sm btn-default margin-right-10 margin-bottom-10" <?php } else { ?>  class="btn btn-sm btn-default margin-right-10 margin-bottom-10" <?php } ?>>
				<input type="radio" name="ad_format" value="<?php echo $result['id']; ?>" <?php if($result['id'] == $order_details[0]['ad_format']){ echo 'checked="checked"';  } ?> required="">
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
					<label <?php if($order_details[0]['web_ad_type']=='Static') { ?> class="active btn btn-sm btn-default margin-right-10 margin-bottom-10" <?php } else { ?> class="btn btn-sm btn-default margin-right-10 margin-bottom-10" <?php } ?> >
						<input type="radio" name="web_ad_type" value="Static" <?php if($order_details[0]['web_ad_type']=="Static"){ echo 'checked="checked"';  } ?> required=""> Static
					</label> 
					<label <?php if($order_details[0]['web_ad_type']=='Animated') { ?> class="active btn btn-sm btn-default margin-right-10 margin-bottom-15" <?php } else { ?> class="btn btn-sm btn-default margin-right-10 margin-bottom-10" <?php } ?>>
						<input type="radio" name="web_ad_type" value="Animated" <?php if($order_details[0]['web_ad_type']=="Animated"){ echo 'checked="checked"';  } ?> required=""> Animated
					</label> 
				  </div>
			   </div>   
			</div>
			 		
					<p class="margin-bottom-5">Maximum File Size <span class="text-red">* </span><small class="text-grey">(In KBs)</small></p>
	        <input type="text" name="maximum_file_size" value="<?php echo $order_details[0]['maxium_file_size']; ?>" class="form-control input-sm margin-bottom-15" title="" required="">
		   		
		   <p class="margin-bottom-5">Size <span class="text-red">* </span><small class="text-grey">(in Pixels)</small></p>
		   <div class="row margin-bottom-15">
			   <div class="col-sm-12">
					
					<select class="form-control input-sm" name="pixel_size" required >
						<option value="">Select</option>
						<?php  $pixel_sizes = $this->db->get('pixel_sizes')->result_array();
								foreach($pixel_sizes as $row)
								{
						?>
						<option value="<?php echo $row['id']; ?>" <?php if($row['id']==$order_details[0]['pixel_size']) echo'selected="selected"'; ?>><?php echo $row['width'].' X '.$row['height'].' ('.$row['name'].')'; ?></option>
						<?php } ?>
						<option value="custom">Custom</option>
					</select>
					
				</div>   
			</div>	
			
			<div class="row margin-bottom-15 custom box">
	           <div class="col-md-6 col-sm-6 col-xs-6">
					 <p class="margin-bottom-5">Width <span class="text-red">*</span> <small class="text-grey">(in pixels)</small></p>
					 <input type="number" name="custom_width" pattern="[1-9]{1,50}" min="1" class="form-control input-sm" value="<?php echo $order_details[0]['custom_width']; ?>"></div>
			   <div class="col-md-6 col-sm-6 col-xs-6"> 
					<p class="margin-bottom-5">Height <span class="text-red">*</span> <small class="text-grey">(in pixels)</small></p>
					<input type="number" name="custom_height" pattern="[1-9]{1,50}" min="1" class="form-control input-sm" value="<?php echo $order_details[0]['custom_height']; ?>"></div>
			</div> 
			 
		</div> 
		 <div class="col-md-12 col-sm-12 col-xs-12">
                <button type="submit" class="btn btn-blue btn-sm float-right  margin-top-20" name="web_pickup_submit">Submit</button>
            </div>
			<?php } ?>
            
        </div> 
		</form>
    </div>
</section>
<?php } ?>

<?php if($action == "revision") { ?>
<section id="revision">
    <div class="container"> 
	<div class="row margin-top-30">
		
		<form  method="post" >
			<div class="col-md-6 col-sm-6 col-xs-12">
			   <p class="margin-bottom-5">Notes & Instructions <span class="text-red">*</span></p>
			   <span id="show">
					<!--
					<textarea rows="7" name="notes" id="note" class="form-control margin-bottom-15" required></textarea>	
					-->
					<textarea rows="7" name="notes" id="note" required class="form-control margin-bottom-15"<?php if(isset($rev_sold_jobs)){ echo "readonly"; }?>><?php if(isset($rev_sold_jobs)){ echo $rev_sold_jobs[0]['note']; }  ?></textarea>
					 
			   </span>
			   <?php if(empty($rev_sold_jobs)){ ?>
			   <input type="text" id="job_slug" name="job_slug"  value="<?php echo $slug;?>" readonly style="display:none;"/> 
			   <button type="submit" class="btn btn-blue btn-sm margin-top-5 margin-bottom-20 pull-right" name="rev_submit" id="hide">Submit</button>
			   <?php } ?>
			</div> 
		</form>
			<?php if(isset($rev_sold_jobs) && $rev_sold_jobs[0]['file_path'] != 'none' && file_exists($rev_sold_jobs[0]['file_path'])){  ?>
			<div class="col-md-6 col-sm-6 col-xs-12" id="show-drag">
			   <span class="margin-bottom-10">Attach Files</span>
				
			 <form action="<?php echo base_url().index_page().'lite/home/order_revision'.'/'.$rev_sold_jobs[0]['id']; ?>"  class="dropzone margin-top-5" > 
				<div class="dz-default dz-message margin-top-50">You can attach or drag files here</div>
			</form>
			<a href="<?php echo base_url().index_page().'lite/home'; ?>" name="submit" class="btn btn-blue btn-sm margin-top-20 margin-bottom-20 pull-right">Submit</a>
			</div> 
			<?php } ?>
			
		</div> 
	</div>
</section>
<?php } ?>

<?php if($action == "attachments") { ?>
<section id="attachments">
    <div class="container"> 		
		
		<div class="row margin-top-20">
			<div class="col-md-12 col-sm-12 col-xs-12">	
				<form action="<?php echo base_url().index_page().'lite/home/additional_att'.'/'.$order_details[0]['id']; ?>" class="dropzone margin-350 drag-bg" method="post"> 							
			</div> 
				<div class="col-md-12 col-sm-12 col-xs-12 margin-top-20 text-right">	
			<!--	<button type="button" class="btn btn-sm btn-lightblue margin-right-10 margin-bottom-10">Submit order without files</button>--->
				<button type="submit" name = "add_submit" class="btn btn-sm btn-blue margin-bottom-10 btn-md">Submit</button>
			</div>
			</form>
		</div> 
	</div>
</section>
<?php } ?>

<?php if($action == "QA") { ?>
<section id="answers" class="margin-bottom-30">
<div class="container"> 
<div class="row  margin-top-15">
		<form id="order_form" name="order_form" method="post" enctype="multipart/form-data">
				  <div class="col-md-6 col-sm-6 col-xs-12">
					   <p class="margin-bottom-5">Question</p>
					   <p class="text-grey"><?php $question['question'] = str_replace(PHP_EOL,'<br/>', $question['question']); echo $question['question'] ; ?></p>			   
				  </div> 
				  
				  <div class="col-md-6 col-sm-6 col-xs-12">
					   <p class="margin-bottom-5">Answer</p>
					   <textarea rows="3"  name="answer" id="answer" class="form-control margin-bottom-15"  required=""></textarea>
					   
					   <p class="margin-bottom-5">Attach File</p>
					   <input type="file" name="ufile[]" id="ufile[]" value="upload" class="form-control">
					   <input type="file" class="form-control margin-top-10">
				  </div> 
			
					<div class="col-md-12 col-sm-6 col-xs-12">
						<input name="id" value="<?php echo $question['id'];?>" readonly style="display:none;" />
						<button type="submit" class="btn btn-blue btn-sm pull-right margin-top-15" name="QA_submit">Submit</button>
					</div>
			</form>
</div> 
</div>	
</section>
<?php } ?>

<?php if($action == "QA_rev") { ?>
<section id="answers" class="margin-bottom-30">
<div class="container"> 
<div class="row  margin-top-15">
			<form id="order_form" name="order_form" method="post" enctype="multipart/form-data">
				  <div class="col-md-6 col-sm-6 col-xs-12">
					   <p class="margin-bottom-5">Question</p>
					   <p class="text-grey"><?php $question['question'] = str_replace(PHP_EOL,'<br/>', $question['question']); echo $question['question'] ; ?></p>			   
				  </div> 
				  
				  <div class="col-md-6 col-sm-6 col-xs-12">
					   <p class="margin-bottom-5">Answer</p>
					   <textarea rows="3"  name="answer" id="answer" class="form-control margin-bottom-15"  required=""></textarea>
					   
					   <p class="margin-bottom-5">Attach File</p>
					   <input type="file" name="ufile[]" id="ufile[]" value="upload" class="form-control">
					   <input type="file" name="ufile[]" id="ufile[]" value="upload" class="form-control margin-top-10">
				  </div> 
			
					<div class="col-md-12 col-sm-6 col-xs-12">
						<input name="id" value="<?php echo $order_details[0]['id'];?>" readonly style="display:none;" />
						<button type="submit" class="btn btn-blue btn-sm pull-right margin-top-15" name="QA_rev_submit">Submit</button>
					</div>
			</form>


</div> 
</div>	
</section>
<?php } ?>

<?php if($action == "view") { ?>
<section id="view_sec">
    <div class="container"> 	
	
		<div class="row  margin-top-25">			
			<div class="col-md-6 col-sm-12 col-xs-12">
				<div class="row">			
					<div class="col-md-6 col-sm-6 col-xs-12 margin-bottom-10">
						<p class="margin-0 text-grey">Advertiser Name</p>			
						<p class="margin-0 medium"><?php echo $order_details[0]['advertiser_name'];?></p>	
					</div>
					<!--<div class="col-md-6 col-sm-6 col-xs-12 margin-bottom-10">
						<p class="margin-0 text-grey">Unique Job Name / Number</p>			
						<p class="margin-0 medium"><?php echo $order_details[0]['job_no'];?></p>	
					</div>-->
					<?php if($order_details[0]['order_type_id']=='1') { ?>
					<div class="col-md-6 col-sm-6 col-xs-12 margin-bottom-10">
						<p class="margin-0 text-grey">Maximum File Size</p>			
						<p class="margin-0 medium"><?php echo $order_details[0]['maxium_file_size'];?></p>	
					</div>
					<?php }?>
					<?php if($order_details[0]['order_type_id']=='1') { ?>
					<div class="col-md-6 col-sm-6 col-xs-12 margin-bottom-10">
						<p class="margin-0 text-grey">Format</p>			
						<p class="margin-0 medium"><?php $results = $this->db->get_where('web_ad_formats',array('id' =>$order_details[0]['ad_format']))->result_array();
							echo $results[0]['name']; ?></p>	
					</div>
					<?php }?>
					<?php if($order_details[0]['order_type_id']=='1') { ?>
					<div class="col-md-6 col-sm-6 col-xs-12 margin-bottom-10">
						<p class="margin-0 text-grey">Ad Type</p>			
						<p class="margin-0 medium"><?php echo $order_details[0]['web_ad_type']; ?></p>	
					</div>
					<?php }?>
					<div class="col-md-6 col-sm-6 col-xs-12 margin-bottom-10">
						<p class="margin-0 text-grey">Width & Height (In Inches)</p>			
						<?php if($order_details[0]['order_type_id']=='1') { 
						if($order_details[0]['pixel_size'] == 'custom') {?>
						<p class="margin-0 medium"><?php echo $order_details[0]['custom_width']." X ".$order_details[0]['custom_height'];?></p>	
						<?php  } else {
							$size = $this->db->get_where('pixel_sizes',array('id' =>$order_details[0]['pixel_size']))->result_array(); ?>
						<p class="margin-0 medium"><?php echo $size[0]['width']." X ".$size[0]['height']; }  ?></p>	<?php } else { ?>
						<p class="margin-0 medium"><?php echo $order_details[0]['width']." X ".$order_details[0]['height']; }?></p>	
					</div>
					<?php if($order_details[0]['order_type_id']=='2') { ?>
					<div class="col-md-6 col-sm-6 col-xs-12 margin-bottom-10">
						<p class="margin-0 text-grey">Full Color / B&W / Spot</p>			
						<p class="margin-0 medium"><?php if($order_details[0]['print_ad_type'] == '1')
							{ echo "Colour"; }
							elseif($order_details[0]['print_ad_type'] == '2')
								{ echo "B&W"; }
							else { echo "Spot"; } ?>
						</p>	
					</div>
					<?php }?>	
				</div>
			</div>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<div class="row">
					<div class="col-md-12 col-sm-6 col-xs-12 margin-bottom-10">
						<p class="margin-0 text-grey">Copy, Content, Text</p>			
						<p class="margin-0 medium"><?php echo $order_details[0]['copy_content_description'];?></p>	
					</div>
					<?php if($order_details[0]['notes']!='') { ?>
					<div class="col-md-12 col-sm-6 col-xs-12 margin-bottom-10">
						<p class="margin-0 text-grey">Notes & Instructions</p>			
						<p class="margin-0 medium"><?php echo $order_details[0]['notes']; ?></p>	
					</div>
					<?php }?>	
				</div>
			</div>
		</div>
		
		<div class="row margin-top-10">
			<div class="col-md-12 col-sm-12 col-xs-12 padding-bottom-10">
				<div class="divider horizontal">
					<small>Optional Fields</small>
				</div>
			</div>
		</div>
		
		<div class="row  margin-top-15">			
			<?php if($order_details[0]['date_needed'] != '0000-00-00') { ?>
			<div class="col-md-3 col-sm-6 col-xs-12 margin-bottom-10">
				<p class="margin-0 text-grey">Date needed</p>			
				<p class="margin-0 medium"><?php echo $order_details[0]['date_needed']; ?></p>	
			</div>
			<?php }?>
			<?php if($order_details[0]['publish_date'] != '0000-00-00') { ?>
			<div class="col-md-3 col-sm-6 col-xs-12 margin-bottom-10">
				<p class="margin-0 text-grey">Publish Date</p>			
				<p class="margin-0 medium"><?php echo $order_details[0]['publish_date']; ?></p>	
			</div>
			<?php }?>
			<?php if($order_details[0]['publication_name'] != '') { ?>
			<div class="col-md-3 col-sm-6 col-xs-12 margin-bottom-10">
				<p class="margin-0 text-grey">Publication Name</p>			
				<p class="margin-0 medium"><?php echo $order_details[0]['publication_name']; ?></p>	
			</div>
			<?php }?>
			<?php if($order_details[0]['font_preferences'] != '') { ?>
			<div class="col-md-3 col-sm-6 col-xs-12 margin-bottom-10">
				<p class="margin-0 text-grey">Font Preferences</p>			
				<p class="margin-0 medium"><?php echo $order_details[0]['font_preferences']; ?></p>	
			</div>
			<?php }?>
			<?php if($order_details[0]['color_preferences'] != '') { ?>
			<div class="col-md-3 col-sm-6 col-xs-12 margin-bottom-10">
				<p class="margin-0 text-grey">Color Preferences</p>			
				<p class="margin-0 medium"><?php echo $order_details[0]['color_preferences']; ?></p>	
			</div>
			<?php }?>
			<?php if($order_details[0]['job_instruction'] != '0' && $order_details[0]['job_instruction'] != '') { ?>
			<div class="col-md-3 col-sm-6 col-xs-12 margin-bottom-10">
				<p class="margin-0 text-grey">Job Instructions</p>			
				<p class="margin-0 medium"><?php if($order_details[0]['job_instruction'] == '1')
							{ echo "Follow Instructions Carefully"; }
							elseif($order_details[0]['job_instruction'] == '2') { echo "Be Creative"; } else { echo "Camera Ready Ad";}?></p>	
			</div>
			<?php }?>
			<?php if($order_details[0]['art_work'] != '0' && $order_details[0]['art_work'] != '') { ?>
			<div class="col-md-3 col-sm-6 col-xs-12 margin-bottom-10">
				<p class="margin-0 text-grey">Art Work</p>			
				<p class="margin-0 medium"><?php echo $order_details[0]['art_work']==1 ? 'Use additional art if required' : ($order_details[0]['art_work']==2 ? 'Modify art provided if necessary' : 'Use art provided without change');?></p>	
			</div>
			<?php }?>
		</div>	
		
	</div>
</section>
	
</div>

<?php } ?>
<!--</form>-->


<?php if($action == "native_files") { ?>
<section id="view_sec">
    <div class="container"> 	
		<div class="row  margin-top-30">	
		
			<div class="col-md-6 col-sm-6 col-xs-12">

					<!-- <div class="col-md-6 col-sm-6 col-xs-12">						
						<?php $order = $this->db->get_where('orders',array('id' => $orderid))->result_array();?>	
						<?php if($order!='' && isset($order[0]['id']))
						{
							$publication = $this->db->get_where('publications',array('id' => $order[0]['publication_id']))->result_array();
							$cat_result = $this->db->get_where('cat_result',array('order_no' => $orderid))->result_array();
							if(($order[0]['status']=='5' || $order[0]['status']=='7') && $cat_result[0]['source_path'] != 'none' && file_exists($cat_result[0]['source_path'])){
								$slug = $cat_result[0]['slug'];
				
								$sourcefilepath = $cat_result[0]['source_path'];
							$sourcefilepath = $sourcefilepath;
								}
						} ?>
								
					</div> -->
							<!--Source File Download -->
							<?php if($publication[0]['enable_source']=='1' && isset($sourcefilepath)){ 
							$this->load->helper('directory');
							$map2 = glob($sourcefilepath.'/'.$slug.'.{indd,psd}',GLOB_BRACE);	//source indd/psd
							if($map2){
							foreach($map2 as $row_map2){ $source_file = basename($row_map2); } 
							?>
												
							<form action="<?php echo base_url().'index.php/lite/home/zip_folder_select'?>" method="post">
								<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
								<input name="new_slug" value="<?php echo $slug;?>" readonly style="display:none;" />
								<input name="source_path" value="<?php echo $sourcefilepath;?>" readonly style="display:none;" />
								<input name="download" value="download" readonly style="display:none;" />
								<button type="submit" name="SourceDownload" class="btn green">Download Package</button>
							</form>
						<?php } } ?>
	
				
				
							
			</div>
					
		
		</div>

	</div>
</section>
<?php } ?>
</div>
         
<?php $this->load->view("lite/footer.php"); ?>
 <?php $this->load->view("lite/foot.php"); ?>	
