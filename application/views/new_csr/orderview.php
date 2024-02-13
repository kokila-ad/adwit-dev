<?php $this->load->view('new_csr/head'); ?>
<style>
    .form-horizontal .radio, .form-horizontal .checkbox, .form-horizontal .radio-inline, .form-horizontal .checkbox-inline {
        padding-top: 0px;
    }

	.padding-left-0{
		padding-left:0 !important; 
	}
	
	.margin-0 {
		margin: 0 !important;
	}
	.margin-bottom-20 {
		margin-bottom: 20px !important;
	}
	.light-grey, .light-grey i {
		background-color: #f3f5f6 !important;
		color: #b8b4b4 !important;
		border-color: #d7d7d7 !important;
		}
		
	.flat-radio div.radio {
		display: none;
	}
	.border-top {
		border-top: 1px solid #eee;
	}
	
	textarea {
		resize: none;
	}
	
	.tab-btn {
		border: 0;
		padding: 10px;
		color: #5b9bd1;
		margin-top: 1px;
	}
	.font-lg {
		font-size: 16px !important;
	}
	.font-sm {
		font-size: 13px !important;
	}
	.word-break{max-width:100%;word-wrap:break-word;}
	.note-grey, .note-grey i {
  background-color: #f3f5f6 !important;
  color: #b8b4b4 !important;
  border-color: #d7d7d7 !important;
  }
  
  /*  set background color for active tabs*/
    .nav-tabs>li.active>a, .nav-tabs>li.active>a:hover, .nav-tabs>li.active>a:focus {
        color: #fff;
        cursor: default;
        background-color: #67809F;
        border: 1px solid #ddd;
        border-bottom-color: transparent;
    }
    /*  set background color for active tabs*/
</style>

<script type="text/javascript">
    $(document).ready(function () {
        $('#focusdiv').click(function() {
          checked = $("#reason_check:checked").length;
    
          if(!checked) {
            alert("You must check at least one checkbox.");
            return false;
          }
    
        });
    });
</script>
<script>
	$(document).ready(function() {
	   function RefreshTable() {
		   $( "#mytable" ).load( "<?php echo base_url().index_page().'new_csr/home/orderview/'.'/'.$hd.'/'.$order_id;?> #mytable" );
	   }
	   $("#view").on("load", RefreshTable);
	   
	   //revision classification confirmation box
	  /* $(".reason_option").on('click', function(){
	        var id = $(this).data("id");
	        var content = '<label> <small> Client Dislike</small> <input type="radio" name="new_content" value="1" required> Yes <input type="radio" name="new_content" value="0"> No </label>';
            //if(id == 1 || id == 3 || id == 4){
                $("#confirmation_div").html(content);
            //}else{
            //    $("#confirmation_div").html('');
            //}
        });
        */
        //rushBox
        $('#rushBox').change(function() {
            if($(this).is(":checked")) {
                $.post("<?php echo base_url().index_page().'new_csr/home/updateOrderRush/'.$order_id;?>", function(){
                    alert("Order Marked Rush..");
                });
            }       
        });
	});
</script>
<script>
	  $(document).ready(function(){
	  $("#instructions").hide();
	  //$("#custom_notes_textarea").hide();
	  $("#show_pickup").hide();
	  $("#show_attach").hide();
	  $("#question").hide();
	  $("#cancel_request").hide();
	  $("#DC_reason").hide();
	  $("#msg").hide();
	  $("#help").hide();
	  $("#csr_answer").hide();
	  $("#note").hide();
	  $("#details").hide(); 
	  $("#revision").hide();
	  $("#subrev").hide();
	  $("#ans").hide();
	 
	  $("#show_revision").click(function(){
	  $("#revision").toggle();     
	  });
	  
	  $("#show_subrev").click(function(){
	  $("#subrev").toggle();     
	  });
	  
	  $("#show_ans").click(function(){
	  $("#ans").toggle();     
	  });
	  
	  $("#show_help").click(function(){
	  $("#help").toggle();     
	  });
	  
	  $("#show_note").click(function(){
	  $("#note").toggle();     
	  });
	  
	  $("#show_csr_answer").click(function(){
	  $("#csr_answer").toggle();     
	  });
	   
	  $("#checkbox").click(function(){
	  $("#instructions").toggle();     
	  });
	  
	 /* $("#custom_notes").click(function(){
	  $("#custom_notes_textarea").toggle();     
	  });*/
	   
	  $("#pickup").click(function(){
	  $("#show_pickup").toggle();     
	  });
	  
	  $("#attach ").click(function(){
	  $("#show_attach").toggle();     
	  });
	  
	  $("#show_details").click(function(){
	  $("#details").toggle();     
	  });
	  
	  $('input[name=to_dc]').on('click init-show_others2', function() {
      $('#DC_reason').toggle($('#show_others2').prop('checked'));
      }).trigger('init-to_dc');		
	  
	  $('input[name=to_designer]').on('click init-show_others3', function() {
        $('#msg').toggle($('#show_others3').prop('checked'));
      }).trigger('init-to_designer');
	  
	  $('input[name=Creason]').on('click init-show_cancel_request', function() {
      $('#cancel_request').toggle($('#show_cancel_request').prop('checked'));
      }).trigger('init-cancel_request');
	  
	  $("#retain").hide();
 

 $("#retain_order").click(function(){
 $("#retain").toggle();     
 });
 
$('#question_template').on('change', function() {
  $('#question_message').val(this.value) ;
});

$('#frontline_question_template').on('change', function() {
  $('#frontline_question_message').val(this.value) ;
});

$('#frontline_question_template2').on('change', function() {
  $('#frontline_question_message2').val(this.value) ;
});

});
</script>	
<script>
	 $(document).ready(function(){
		 $("#others3").hide();
		$("#others2").hide();
	  
		<?php if(isset($note_csr_designer)){ foreach($note_csr_designer as $result){ ?>
			$("#hide_others3<?php echo $result['id']; ?>").click(function(){
				$("#others3").show();
		});
		<?php } } ?>
		
	  <?php if(isset($note_csr_dc)){ foreach($note_csr_dc as $result){ ?>
			$("#hide_others2<?php echo $result['id']; ?>").click(function(){
				$("#others2").hide();
		});
		<?php } } ?>
		
	  $("#show_others3").click(function(){
	  $("#others3").show();  	
	  });
		
	  $("#show_others2").click(function(){
	  $("#others2").show();  	
	  });
	  
});
</script>
				<!-------------------------------------------New Ad Starts----------------------------------------------->
<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<div class="page-content">
		<div class="container">
	    <?php 
	    if($this->session->userdata('sId') == '68'){ 
	        echo 'CLUB ID - '.$orders[0]['club_id'].' HD-AdwitTeam - '.$help_desk['adwit_teams_id'].' PubId - '.$orders[0]['publication_id'].' OrderType-'.$orders[0]['order_type_id'];
	        if(isset($cat[0]['category'])) echo ' Cat - '.$cat[0]['category']; 
	    } ?>
		<?php if($orders[0]['status']!='5' && $orders[0]['status']!='7') { //Not in pdf_sent & Approved ?>
        <div class="row margin-top-20 margin-bottom-20">			
			<div class="col-md-12">							
				<div class="portlet light margin-0">
					<div class="portlet-title no-space margin-top-10">
						<div class="row static-info">
						<?php foreach($orders as $row) ?>
							<div class="col-md-4 value bold">ID: <?php echo $order_id; ?>&nbsp;<small class="font-grey-cascade"> (<?php echo $row['created_on']; ?>)</small></div>
							<div class="col-md-3">
								<?php echo '<p style="color:#900;">'.$this->session->flashdata('question_message').'</p>'; ?>
							</div>
							<div class="col-md-5 text-right">
								<div class="tools">
								    <?php if($row['cancel']!='1' && $row['crequest']!='1') { ?>
									<span class="btn btn-xs margin-right-10 tooltips font-grey-cascade" id="show_help" data-container="body" data-placement="top" data-original-title="Question or Cancel Request">
										Question / Cancel <!--<i class="fa fa-question font-lg"></i>-->
									</span>
							        <?php } ?>
									<span class="btn red-sunglo btn-xs margin-right-10">
									<?php 
										if(isset($cat) && $cat[0]['pro_status']!='0'){ 
											$status = $this->db->query("SELECT * FROM `production_status` WHERE id='".$cat[0]['pro_status']."'")->result_array();
										    echo $status[0]['name']; 
										}elseif($row['status']!='0'){ 
											$status1 = $this->db->query("SELECT * FROM `order_status` WHERE id='".$row['status']."'")->result_array(); 
											echo $status1[0]['name'];
										} 
									?> &nbsp										
									<?php 
									    if($row['question']=='1'){											
									        echo ": Question Sent";										
									    }elseif($row['question']=='2'){											
									        echo ": Question Answered";										
									    }
									?>
									</span>
									<button onclick="goBack()" class="btn btn-default btn-xs">← Back</button>
								</div>
							</div>
						</div>
					</div>
					
					<div class="portlet-body margin-top-10">
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="portlet blue-hoki box">
									<div class="portlet-title">
										<div class="caption">Order Info</div>
									</div>
													
									<div class="portlet-body">
										<div class="row static-info margin-top-10">
											<div class="col-md-5 col-xs-5 name">Unique Job Name:</div>
											<div class="col-md-7 col-xs-7 value word-break"><?php echo $row['job_no'];?></div>
										</div>
										<div class="row static-info">
											<div class="col-md-5 col-xs-5 name">Ad Size
											<?php if($row['order_type_id']=='1') echo '<a title="Add Extra Sizes" href="'.base_url().index_page().'new_csr/home/add_extra_sizes/'.$row['id'].'" target="_blank"><i class="fa fa-plus-circle" style="padding-left: 5px;padding-right: 5px;"></i></a>'; ?>
											:</div>
										<?php 
										if($row['order_type_id']=='1'){ // webad 
										    if($row['ad_format']=='5' && empty($row['pixel_size'])){ //Flexitive ad
											    
    											if(isset($row['flexitive_size']) && $row['flexitive_size'] > 0){
    												$flexitive_size = $this->db->get_where('flexitive_size',array('id' => $row['flexitive_size']))->row_array();
    												$fs = explode('x', $flexitive_size['ratio']);
    												
    												echo'<div class="col-md-3 col-xs-3 value">'.$flexitive_size['ratio'].'</div>';
    											}else{  //multiple size
                							        echo '<div class="col-md-7 col-xs-7 value ">';
                							        if(isset($orders_multiple_size[0]['id'])){
                							            //echo '<p class="margin-0 text-grey">Size <small class="text-grey">(in ratio)</small></p>';
                							            foreach($orders_multiple_size as $msize){
                							                echo '<p>'.$msize['ratio'].'</p>';
                							            }
                							        }
    											    if(isset($orders_multiple_custom_size[0]['id'])){
    											        foreach($orders_multiple_custom_size as $mcsize){
    											            echo '<p>'.$mcsize['custom_width'].' X '.$mcsize['custom_height'].'</p>';
    											        }
    											    }
    											    echo '</div>';
    											}
										    
										    }else{
											
												if($row['pixel_size']=='custom'){
										?>
												<div class="col-md-3 col-xs-3 value">W: <?php echo $row['custom_width']; ?>
												</div>
												<div class="col-md-4 col-xs-4 value">H: <?php echo $row['custom_height']; ?></div>
										<?php 	} elseif($row['pixel_size'] != '') { 
												$size_px = $this->db->get_where('pixel_sizes',array('id'=>$row['pixel_size']))->result_array();
											?>
												<div class="col-md-3 col-xs-3 value">W: <?php echo $size_px[0]['width']; ?></div>
												<div class="col-md-4 col-xs-4 value">H: <?php echo $size_px[0]['height']; ?></div>
										<?php 
											    }else{ //multiple size
                							         echo '<div class="col-md-7 col-xs-7 value ">';
                							        if(isset($orders_multiple_size[0]['id'])){
                							            foreach($orders_multiple_size as $msize){
                							                echo '<p>'.$msize['width'].' X '.$msize['height'].'</p>';
                							            }
                							        }
                								    if(isset($orders_multiple_custom_size[0]['id'])){
    											        foreach($orders_multiple_custom_size as $mcsize){
    											            echo '<p>'.$mcsize['custom_width'].' X '.$mcsize['custom_height'].'</p>';
    											        }
    											    }
    											    echo '</div>';
                								} 
											}
											
										}else{ //printad ?>
												<div class="col-md-3 col-xs-3 value">W: <?php echo $row['width']; ?></div>
												<div class="col-md-4 col-xs-4 value">H: <?php echo $row['height']; ?></div>
											<?php } ?>
										</div>
										<div class="row static-info">
											<?php if($row['order_type_id']=='1'){ // webad ?>  
												<div class="col-md-5 col-xs-5 name">Static/Animated:</div>
												<div class="col-md-7 col-xs-7 value"><?php echo $row['web_ad_type']; ?></div>
											<?php }else{	//printad
											    $print_ad_type =$this->db->get_where('print_ad_types',array('id' => $row['print_ad_type']))->result_array();?>
												<div class="col-md-5 col-xs-5 name">Full Color/B&amp;W/Spot:</div>
												<div class="col-md-7 col-xs-7 value"><?php if(isset($print_ad_type[0]['name'])) echo $print_ad_type[0]['name']; ?></div>
											<?php } ?>
										</div>
										<div class="row static-info">
											<div class="col-md-5 col-xs-5 name">Advertiser:</div>
											<div class="col-md-7 col-xs-7 value word-break"><?php echo $row['advertiser_name']; ?></div>
										</div>
										<?php if($row['job_instruction']!=="") { ?>
										<div class="row static-info">
											<div class="col-md-5 col-xs-5 name">Job Instruction:</div>
											<div class="col-md-7 col-xs-7 value">
												<?php  if($row['job_instruction']==1)  { echo "Follow Instructions Carefully"; }?>
												<?php  if($row['job_instruction']==2)  { echo  "Be Creative"; }?>
												<?php  if($row['job_instruction']==3)  { echo  "Camera Ready Ad"; } ?>
											</div>
										</div>
										<?php } ?>
										
										<?php if($row['copy_content_description']!=="" && $row['copy_content_description'] != NULL) { ?>
										<div class="row static-info">
											<div class="col-md-5 col-xs-5 name">Copy/Content:</div>
											<div class="col-md-7 col-xs-7 value">
												<div class="scroller" style="height:auto" data-always-visible="1" data-rail-visible="0">
												<?php echo nl2br($row['copy_content_description']);?>
													<!--<?php echo htmlspecialchars($row['copy_content_description'], ENT_QUOTES, 'UTF-8');?>-->
												</div>
											</div>
										</div>
										<?php } ?>
										
										<?php if($row['notes']!=="" && $row['notes'] != NULL) { ?>
										<div class="row static-info">
											<div class="col-md-5 col-xs-5 name">Notes & Instructions:</div>
											<div class="col-md-7 col-xs-7 value">
												<div class="scroller" style="height:auto" data-always-visible="1" data-rail-visible="0">
												    <?php if(isset($preorders_waukesha['output_type']) && $preorders_waukesha['output_type'] == '2'){ echo 'Additional colour option - B&W.<br/>'; } ?>
												    <?php if(isset($preorders_waukesha['camera_ready']) && $preorders_waukesha['camera_ready'] == 'true'){ echo 'Camera Ready Ad.<br/>'; } ?>
													<?php echo nl2br($row['notes']); ?>
												</div>
											</div>
										</div>
										<?php } ?>
										
										<?php
                                            $additional_instruction = $this->db->query("SELECT * FROM `orders_additional_instruction` WHERE `order_id` = ".$row['id']." AND `revision_id` = '0'")->result_array();
                    						if(isset($additional_instruction[0]['id'])){
                    					?>
                    					<div class="row static-info">
											<div class="col-md-5 col-xs-5 name">Additional Instructions:</div>
											<div class="col-md-7 col-xs-7 value">
												<div class="scroller" style="height:auto" data-always-visible="1" data-rail-visible="0">
												    <?php
                            						    foreach($additional_instruction as $instruction){
                            						        echo nl2br($instruction['instructions']).'<br/>';     
                            						    } 
                            					    ?>
												</div>
											</div>
										</div>
                    					<?php } ?>
										
										<?php if(isset($order_mood)) { ?>
										<div class="row static-info">
											<div class="col-md-5 col-xs-6 name">Moodboard</div>
											<?php if(isset($moodboard_path) && file_exists($moodboard_path)){ ?>
											<div class="col-md-7 col-xs-6 value"><a href="<?php echo base_url().$moodboard_path;?>" target="_blank"><?php echo $moodboard_filename; ?></a></div>
											<?php } ?>
										</div>
										<?php } ?>
								
									</div>				
								</div>
							</div>	
							
							<div class="col-md-6 col-sm-12">								
								<div class="row">	
								
							<?php  $orders_cancel = $this->db->query("SELECT * FROM `orders_cancel` WHERE `order_id`= '".$row['id']."'")->result_array();
									/* if($orders_cancel){
										$csr_cancel = $this->db->get_where('csr',array('id'=>$orders_cancel[0]['csr']))->result_array();
									} */
									if($row['cancel']=='1') {
										echo "<span> &nbsp; &nbsp; 
													<p class='btn red-pink btn-xs margin-right-10 margin-bottom-10'> Order has been Cancelled..!!</p>
												</span>";
										} else if($row['crequest']=='1' && $orders_cancel){
											echo "<span> &nbsp; &nbsp; 
													<p class='btn red-pink btn-xs margin-right-10 margin-bottom-10'> Request for Order Cancellation Sent To Adrep..!!</p>
												</span>";
												
										}?>
										<?php if($row['crequest']=='1' && $orders_cancel){ ?>
										<button type="submit" name="retain_cancel" id="retain_order" class="btn green btn-xs margin-right-10 margin-bottom-10">Retain Cancel Request</button><?php } ?>
										<div class="col-md-12 col-sm-12">
											<div class="text-right" id="retain">
												<form id="order_form" name="order_form" action="<?php echo base_url().index_page().'new_csr/home/ordercshift_retain_cancel/'.$hd.'/'.$order_id;?>" method="post" enctype="multipart/form-data">
													<textarea rows="2" class="form-control" name="retain_reason" placeholder="Order Cancel Request...."></textarea>
													<button type="submit" name="retain" class="btn btn-sm red-thunderbird margin-top-10 margin-bottom-15">Send <i class="fa fa-send"></i></button>
												</form>
											</div>
										</div>
									<?php echo $this->session->flashdata('message'); ?>
								
								<div class="col-md-12 col-sm-12" id="help">
									<div class=" portlet-tabs">
										<ul class="nav nav-tabs">
											<li class="active"><a href="#portlet_tab1" data-toggle="tab">Send Question</a></li>
											<li><a href="#portlet_tab2" data-toggle="tab">Send Cancel Request</a></li>
										</ul>
										<div class="tab-content">
											<div class="tab-pane active" id="portlet_tab1">
												<select name="question_template" id="question_template" class="form-control">
													<option value="">SELECT</option>
													<?php
														$question_template = $this->db->query("SELECT * FROM `question_template`")->result_array();
														foreach($question_template as $template){
													?>
													<option value="<?php echo $template['message']; ?>"><?php echo $template['name']; ?></option>
													<?php
														}
													?>
												</select><br/>
												<form id="order_form" name="order_form" action="<?php echo base_url().index_page().'new_csr/home/cshift_question_v2/'.$hd.'/'.$orders[0]['id'];?>" method="post" enctype="multipart/form-data">
													<div class="text-right">
														<input id="order_id" name="order_id" value="<?php echo $orders[0]['id']; ?>" style="display:none;" />
														<input name="job_name" value="<?php echo $orders[0]['job_no'];?>"  style="display:none;" />
														<textarea rows="2" name="question" id="question_message" class="form-control" placeholder="Send Question...." required></textarea>
														<button type="submit" name="submit" class="btn btn-sm red-thunderbird margin-top-10 margin-bottom-15">Send <i class="fa fa-send"></i></button>
													</div>
												</form>
											</div>
											
											<div class="tab-pane" id="portlet_tab2">
											<form id="order_form" name="order_form" action="<?php echo base_url().index_page().'new_csr/home/ordercshift_cancel_v2/'.$hd.'/'.$order_id;?>" method="post" enctype="multipart/form-data">
												<div class="form-actions">
												<?php $cancel_reason = $this->db->get('cancel_reason')->result_array(); foreach($cancel_reason as $result){ ?>
													<label class="margin-right-10 font-grey-gallery">
														<input type="radio" name="Creason"  value="<?php echo $result['name']; ?>" required> <?php echo $result['name'];?>
													</label>
													<?php } ?>
													<label class="margin-right-10 font-grey-gallery">
														<input type="radio" id="show_cancel_request" name="Creason" value="others"> Others
													</label>
												</div>
													<input type="text" id="order_id" name="order_id" value="<?php echo $order_id; ?>" readonly  style="display:none;" />
													<textarea id="cancel_request" name="reason" rows="2" class="form-control margin-top-10" placeholder="Order Cancel Request...."></textarea>
												<div class="text-right">
													<button type="submit" name="remove" class="btn btn-sm red-thunderbird margin-top-10 margin-bottom-15">Send <i class="fa fa-send"></i></button>
												</div>
											</form>
											</div>	
										</div>
									</div>
								</div>
								
								<div class="col-md-12 col-sm-12">
									<div class="portlet blue-hoki box margin-bottom-10">
										<div class="portlet-title">
											<div class="caption">Customer Info</div>
										</div>
										<div class="portlet-body">
											<div class="row static-info margin-top-10">
												<div class="col-md-5 col-xs-5 name">Publication:</div>
												<div class="col-md-7 col-xs-7 value"><?php echo $pub_name[0]['name']; ?></div>
											</div>
											<div class="row static-info">
												<div class="col-md-5 col-xs-5 name">AdRep Name:</div>
												<div class="col-md-7 col-xs-7 value"><?php echo $adrep_name[0]['first_name']; ?></div>
											</div>
									
										<!--	<div class="row static-info">
												<div class="col-md-5 col-xs-5 name">Email:</div>
												<div class="col-md-7 col-xs-7 value"><?php echo $adrep_name[0]['email_id']; ?></div>
											</div> -->
											<div class="row static-info">
												<div class="col-md-5 col-xs-5 name">Date Needed:</div>
												<div class="col-md-7 col-xs-7 value"><?php echo $row['date_needed']; ?></div>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-md-12 col-sm-12">
									<div class="portlet blue-hoki box margin-bottom-10">
										<div class="portlet-title">
											<div class="caption">Downloads</div>
											<?php if($row['file_path']!='none') { ?>
											<div class="actions">
												<form method="post" action="<?php echo base_url().index_page().'new_csr/home/zip_folder';?>">
													<!--<input name="file_path" value="downloads/<?php echo($order_id.'-'.$row['job_no'])?>" readonly style="display:none" />-->
													<input name="file_path" value="<?php echo $row['file_path']; ?>" readonly style="display:none" />
													<input name="file_name" value="<?php echo($order_id.'-'.$row['job_no'])?>" readonly style="display:none" />
													<a id="attach" class="font-grey-cararra tooltips" data-container="body" data-placement="top" data-original-title="Attach File">
													    <i class="fa fa-link"></i>
													</a>
													<button type="submit" name="Submit" class="btn btn-default btn-sm">
													<i class="fa fa-cloud-download"></i>All</button>
												</form>
											</div>
											<?php }else{ ?>
											    <div class="actions">
											        <a href="<?php echo base_url().index_page().'new_csr/home/order_form_details/'.$order_id;?>" target="_blank">orderform</a>
											    </div>
											<?php } ?>
										</div>
										<div class="portlet-body">
											<div class="table-scrollable table-scrollable-borderless">
												<table class="table table-light table-hover">
													<tbody>
												<?php $i=1;
													if(isset($downloads)){
													    if($row['order_type_id'] == '6'){ //page orders
													        $this->load->helper('directory');
														    $page_downloads_map = glob($downloads.'/*', GLOB_BRACE);
														    $html_order_form = $row['file_path'].'/'.$row['job_no'].'.html';
														    if(file_exists($html_order_form)){
												?>
														     <tr>
                													<td class="small"></td>                       
                													<td><?php echo basename($html_order_form) ?></td>
                													<td>
                														<a href="<?php echo base_url()?><?php echo $html_order_form ?>";  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
                														<a href="<?php echo base_url()?>download.php?file_source=<?php echo $html_order_form; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a>
                													</td>
                											</tr>
                								<?php						
														    }
													        //$downloads = $downloads.'/articles';
													        foreach($page_downloads_map as $page_downloads){ 
													            $map = glob($page_downloads.'/*',GLOB_BRACE);		
    														    if($map){
    															    foreach($map as $row_map){
    											?>
    											                        <!--<tr><td><?php  echo basename($page_downloads);  ?></td></tr>-->
    											                        <tr>
                															<td class="small"><?php echo $i; $i++;?></td>                       
                															<td><?php echo basename($row_map) ?></td>
                															<td>
                																<a href="<?php echo base_url()?><?php echo $row_map ?>";  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
                																<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row_map; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a>
                															</td>
                														</tr>
    											<?php
    															    }
    														    }
													        }
													    }else{
    														foreach($file_format as $format){
    														    $this->load->helper('directory');
    														    $map = glob($downloads.'/*{'.$format['name'].'}',GLOB_BRACE);		
    														    if($map){
    															    foreach($map as $row_map){ 
    												?>
            														<tr>
            															<td class="small"><?php echo $i; $i++;?></td>                       
            															<td><?php echo basename($row_map) ?></td>
            															<td>
            																<a href="<?php echo base_url()?><?php echo $row_map ?>";  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
            																<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row_map; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a>
            															<?php 
            															    if($row['group_id'] == '2' || $row['group_id'] == '4'){
            																    echo "<span onclick=remove_attachment('".basename($row_map)."') class='fa fa-trash' title='Delete'></span>";
            														
            																} 
            															?>
            															</td>
            														</tr>
    											    <?php           } 
    														    } 
    														}
													    }
													} 
												?>
													</tbody>
												</table>
											</div>
											<div class="row no-space margin-bottom-10" id="show_attach">
												<form  action="<?php echo base_url().index_page().'new_csr/home/attach_file/'.$order_id;?>" method="post" enctype="multipart/form-data">
													<div class="col-md-6 no-space"><input type="file" name="ufile[]" class="form-control"></div>
													<div class="col-md-6 no-space"><input type="file" name="ufile[]" class="form-control"></div>
													<div class="col-md-12 no-space text-right margin-top-10">
													<?php if(isset($redirect)){ ?>
														<input type="text" name="redirect" id="redirect" value="<?php echo $redirect; ?>"  readonly style="display:none" />
													<?php } ?>
														<button type="submit" name="submit" class="btn btn-primary btn-sm">Upload</button>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
								
								<!-- pick up ad source file link-->
								<div class="col-md-12 col-sm-12">
									<div class="portlet blue-hoki box margin-bottom-10">
										<div class="portlet-title">
											<div class="caption">Pickup Ad</div>
											<div class="actions">
												<a id="pickup" class="font-grey-cararra tooltips" data-container="body" data-placement="top" data-original-title="Attach File">
												<i class="fa fa-link"></i></a> &nbsp;              
											</div>
										</div>
										<div class="portlet-body">
										<!--<?php if($row['pickup_adno'] != '') { ?>
											<div class="row static-info margin-top-10">
												<div class="col-md-5 name">PickUp Ad No:</div>
												<div class="col-md-7 value"><a href="<?php echo base_url().index_page().'new_csr/home/orderview'.'/'.$hd.'/'.$row['pickup_adno'];?>" target="_Blank"><?php echo $row['pickup_adno']; ?></a></div>
											</div>
										<?php } ?>-->
										<?php 
										    if($row['pickup_adno'] != '') { 
										        $pickup_order_id = $row['pickup_adno'];
										        $pickup_order_details = $this->db->query("SELECT id, help_desk FROM `orders` WHERE `id` = '$pickup_order_id'")->row_array();
										?>
											<div class="row static-info margin-top-10">
												<div class="col-md-5 name">PickUp Ad No:</div>
												<div class="col-md-7 value">
												    <?php 
												        if(isset($pickup_order_details['id'])){ 
												            echo '<a target="_blank" href="'.base_url().index_page().'new_csr/home/orderview/'.$pickup_order_details['help_desk'].'/'.$pickup_order_id.'">'
												                    .$row['pickup_adno'].'</a>';    
												        }else{
												            echo $row['pickup_adno'];
												        }
												    ?>
												    
												</div>
											</div>
										<?php } ?>
										
										<div class="table-scrollable table-scrollable-borderless">
											<table class="table table-light table-hover">
											<tbody>
											<?php $i=1;
											if(isset($pickup_downloads)){
													foreach($file_format as $format){
													$this->load->helper('directory');
													$pickup_map = glob($pickup_downloads.'/*{'.$format['name'].'}',GLOB_BRACE);		
													if($pickup_map){
														foreach($pickup_map as $pickup_row_map)
														{ 
											?>
											<tr>
												<td class="small"><?php echo $i; $i++;?></td>                                     
												<td class="word-wrap"> <?php echo basename($pickup_row_map) ?></td>
												<td>
												<a href="<?php echo base_url()?><?php echo $pickup_row_map ?>";  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
												<a href="<?php echo base_url()?>download.php?file_source=<?php echo $pickup_row_map; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a>
												</td>
											</tr><?php } } } } ?>
											
											
											</tbody>
											</table>
										</div>
											<?php echo $this->session->flashdata('pickup_message'); ?>
										<div class="row no-space margin-bottom-10" id="show_pickup">
											<form  action="<?php echo base_url().index_page().'new_csr/home/attach_pickup_file/'.$order_id;?>" method="post" enctype="multipart/form-data">
												<div class="col-md-6 no-space"><input type="file" name="file[]" class="form-control"></div>
												<div class="col-md-6 no-space"><input type="file" name="file[]" class="form-control"></div>
												<div class="col-md-12 no-space text-right margin-top-10">
												<input type="text" name="pickup_adno" id="redirect" value="<?php echo $row['pickup_adno']; ?>"  readonly style="display:none" />
												<?php if(isset($redirect)){ ?>
													<input type="text" name="redirect" id="redirect" value="<?php echo $redirect; ?>"  readonly style="display:none" />
												<?php } ?>
													<button type="submit" name="pickup_submit" class="btn btn-primary btn-sm">Upload</button>
												</div>
											</form>
										</div>
										</div>
									</div>
								</div>
								<!-- pick up ad source file link-->
								</div>
							</div>
						</div>
					</div>
				</div>						
			</div>
		</div>
		
        <?php } ?>

<!--Question and Answer starts  -->
		<?php 
		    foreach($orders as $row)
		        if($row['status']!='5'){
		            if($row['question']=="1" || $row['question']=="2"){ 
	    ?>
		<div class="row margin-top-20">
			<div class="col-md-12">
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption static-info">
							<div class="value bold">Question & Answer </div>
						</div>	
						<div class="tools">
							<a href="javascript:;" class="expand" data-original-title="" title=""></a>
						</div>
					</div>
					<div class="portlet-body" style="display: none;">
						  <div class="scroller" style="height:180px" data-always-visible="1" data-rail-visible="0">
						  <?php $question = 	$this->db->query("SELECT * FROM `orders_Q_A` WHERE `order_id` = '$order_id' ORDER BY `id` DESC")->result_array();
							//$this->db->get_where('orders_Q_A',array('order_id' => $order_id))->result_array(); 
							?>
							<?php $iq='0'; foreach($question as $Qrow){ $iq++; ?>
							<?php $csr_name = 	$this->db->get_where('csr',array('id' => $Qrow['csr']))->result_array(); ?>
							<?php $adreps = 	$this->db->get_where('adreps',array('id' => $Qrow['adrep']))->result_array(); ?>
							<?php $Acsr_name = 	$this->db->get_where('csr',array('id' => $Qrow['Acsr']))->result_array(); ?>
							<div class="note note-danger">
								<div class="row">
									<div class="col-md-6"><h4><?php echo $csr_name[0]['name']; ?></h4></div>
									<?php if($Qrow['answer']==''){  ?>
									<div class="col-md-6 text-right">
											<span>
												<a class="btn btn-info btn-xs" id="show_csr_answer">Answer</a>
											</span>
									</div>
									<?php } ?>
								</div>
								<div class="row">
									<div class="col-md-6"><?php echo $Qrow['question']; ?></div>
									<div class="col-md-6 text-right">
										<span class="font-grey-cascade">Sent at - <?php $date = date_create($Qrow['Qtimestamp']); echo date_format($date, 'g:i A \o\n l jS F Y'); ?> </span>
									</div>
								</div>
							</div>
							<?php if($Qrow['answer']==''){  ?> 
							<div class="row" id="csr_answer">
								<form method="POST" action="<?php echo base_url().index_page().'new_csr/home/cshift_answer_v2/'.$order_id;?>" class="form-horizontal" role="form" enctype="multipart/form-data">
									<div class="col-md-6">
										<textarea rows="1" name="answer" class="form-control" placeholder="Answer goes here..."></textarea>
										<input type="file" name="ufile[]" id="ufile[]" class="margin-top-10" />
										<?php if(isset($redirect)){ ?>
										<input type="text" name="redirect" id="redirect" value="<?php echo $redirect; ?>"  readonly style="display:none" />
										<?php } ?>	
										<input type="text" name="qid" id="qid" value="<?php echo $Qrow['id']; ?>"  readonly style="display:none" />
										<button type="submit" class="btn btn-sm btn-primary margin-top-10 margin-bottom-10">Submit</button>
									</div>
								</form>
							</div>
							<?php } ?>
							<?php if(isset($adreps[0]['first_name'])) { ?>
							<div class="note note-success">
								<h4><?php echo $adreps[0]['first_name'] ?></h4>
								<div class="row">
									<div class="col-md-6"><?php echo $Qrow['answer']; ?></div>
									<div class="col-md-6 text-right">
										<span class="font-grey-cascade">Replied at - <?php $date = date_create($Qrow['Atimestamp']); echo date_format($date, 'g:i A \o\n l jS F Y'); ?></span>
									</div>
								</div>
							</div>
							<?php }elseif(isset($Acsr_name[0]['name'])){ ?>
							<div class="note note-warning">
								<h4><?php echo $Acsr_name[0]['name'] ?></h4>
								<div class="row">
									<div class="col-md-6"><?php echo $Qrow['answer']; ?></div>
									<div class="col-md-6 text-right">
										<span class="font-grey-cascade">Replied at - <?php $date = date_create($Qrow['Atimestamp']); echo date_format($date, 'g:i A \o\n l jS F Y'); ?></span>
									</div>
								</div>
							</div>
							<?php } ?>
							<?php } ?>
						  </div>
					</div>
				</div>
			</div>
		</div>	
	<?php } } ?>	
<!--Question and Answer  Ends  -->

<!-- Order Status 1 starts  Categorize -->
		<?php 
		//if(!isset($cat) && $row['status']=='1' && $row['crequest'] != '1') {
		if(($row['status']=='1' || $row['status']=='2') && $row['crequest'] != '1') {
		    if(isset($error)){
			    echo "<div style='font-weight: bold; color:#F00;'>".$error."</div>";
			}
		?>
		<div class="row margin-top-20">
		    <!--------------------------------------------------- Categorize -------------------------------------->
			<div class="col-md-12">
				<div class="portlet blue-hoki box">
						<div class="portlet-title margin-top-10">
							<div class="row caption static-info">
								<div class="col-md-6 value bold">Categorize</div>
								<div class="col-md-6 text-right">
									<div class="tools">
									</div>
								</div>
							</div>
					    </div>
					<div class="portlet-body">
						<form name="form" method="post" class="horizontal-form" id="ad_categorise">
							<div Hidden class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="control-label">Unique Job Name</label>
										<input name="job_name" type="text" value="<?php if(isset($orders))echo $orders[0]['job_no'];?>" autocomplete="off" required  class="form-control" style="display:none;" >
										<span class="help-block">
										adrep provided job name</span>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Order No</label>
										<input type="text" id="order_no" name="order_no" value="<?php if(isset($orders))echo $orders[0]['id'];?>" autocomplete="off" required  class="form-control" style="display:none;">
										<span class="help-block">
										adrep job no</span>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Adrep Name</label>
										<?php if(isset($orders)){ $adrep = $this->db->get_where('adreps',array('id' => $orders[0]['adrep_id']))->result_array(); } ?>
										<input name="adrep" type="text" value="<?php if(isset($orders))echo $adrep[0]['first_name'];?>" autocomplete="off" required class="form-control" style="display:none;">
										<span class="help-block">
										adrep name</span>
									</div>
								</div>
								<!--/span-->
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Advertiser Name</label>
										<input name="adv_name" type="text" value="<?php if(isset($orders))echo $orders[0]['advertiser_name'];?>" autocomplete="off"  class="form-control" style="display:none;">
										<span class="help-block">
										client name</span>
									</div>
								</div>
								<!--/span-->
								<?php 
								if($orders[0]['order_type_id']=='1'){  // webad 
									if($orders[0]['ad_format']=='5' && empty($orders[0]['pixel_size'])){ //flexitive ad
									    if(isset($orders_multiple_size[0]['id'])){ //multiple size web ads
        							        $fs = explode('x', $orders_multiple_size[0]['ratio']);
    										echo '<input value="'.$fs[0].'" id="width" name="width" autocomplete="off" class="form-control" >';
    										echo '<input id="height" name="height" value="'.$fs[1].'" autocomplete="off"  class="form-control" >';
        							    }elseif(isset($orders_multiple_custom_size[0]['id'])){ //multiple custom size
        							        echo '<input value="'.$orders_multiple_custom_size[0]['custom_width'].'" id="width" name="width" autocomplete="off" class="form-control" >';
    									    echo '<input id="height" name="height" value="'.$orders_multiple_custom_size[0]['custom_height'].'" autocomplete="off"  class="form-control" >'; 
        							    }else{
    										if(isset($orders[0]['flexitive_size']) && $orders[0]['flexitive_size'] > 0){
        										$flexitive_size = $this->db->get_where('flexitive_size',array('id' => $orders[0]['flexitive_size']))->row_array();
        										$fs = explode('x', $flexitive_size['ratio']);
        										echo '<input value="'.$fs[0].'" id="width" name="width" autocomplete="off" class="form-control" >';
        										echo '<input id="height" name="height" value="'.$fs[1].'" autocomplete="off"  class="form-control" >';
        									}
    									}
									}else{ //non flexitive multiple ads
									    if(isset($orders_multiple_size[0]['id'])){ //multiple size web ads
        							        echo '<input value="'.$orders_multiple_size[0]['width'].'" id="width" name="width" autocomplete="off" class="form-control" >';
    										echo '<input id="height" name="height" value="'.$orders_multiple_size[0]['height'].'" autocomplete="off"  class="form-control" >';
        							     }elseif(isset($orders_multiple_custom_size[0]['id'])){ //multiple custom size
        							        echo '<input value="'.$orders_multiple_custom_size[0]['custom_width'].'" id="width" name="width" autocomplete="off" class="form-control" >';
    										echo '<input id="height" name="height" value="'.$orders_multiple_custom_size[0]['custom_height'].'" autocomplete="off"  class="form-control" >';
        							     }else{
								            if($orders[0]['pixel_size']=='custom'){ 
								?>
                								<div class="col-md-6">
                									<div class="form-group">
                										<label class="control-label">Width</label>
                										<input value="<?php if(isset($orders))echo $orders[0]['custom_width'];?>" id="width" name="width" autocomplete="off" class="form-control" >
                										<span class="help-block">
                										In inches </span>
                									</div>
                								</div>
                								<!--/span-->
                								<div class="col-md-6">
                									<div class="form-group">
                										<label class="control-label">Height</label>
                										<input id="height" name="height" value="<?php if(isset($orders))echo $orders[0]['custom_height'];?>" autocomplete="off"  class="form-control" >
                										<span class="help-block">
                										In inches  </span>
                									</div>
                								</div>
							    <?php 
								            }else{
								                 $size_px = $this->db->get_where('pixel_sizes',array('id'=>$orders[0]['pixel_size']))->result_array();
							    ?>
                								<div class="col-md-6">
                									<div class="form-group">
                										<label class="control-label">Width</label>
                										<input value="<?php if(isset($orders))echo $size_px[0]['width'];?>" id="width" name="width" autocomplete="off" class="form-control" >
                										<span class="help-block">
                										In inches </span>
                									</div>
                								</div>
                								<!--/span-->
                								<div class="col-md-6">
                									<div class="form-group">
                										<label class="control-label">Height</label>
                										<input  id="height" name="height" value="<?php if(isset($orders))echo $size_px[0]['height'];?>" autocomplete="off"  class="form-control" >
                										<span class="help-block">
                										In inches  </span>
                									</div>
                								</div>
            								<!--/span-->
								<?php 
								            }
									    } 
									}
								}else{ //print ad size ?>
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Width</label>
										<input value="<?php if(isset($orders))echo $orders[0]['width'];?>" id="width" name="width" autocomplete="off" class="form-control" >
										<span class="help-block">
										In inches </span>
									</div>
								</div>
								<!--/span-->
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Height</label>
										<input id="height" name="height" value="<?php if(isset($orders))echo $orders[0]['height'];?>" autocomplete="off"  class="form-control" >
										<span class="help-block">
										In inches  </span>
									</div>
								</div>
									<?php }?>
								<!--/span-->
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-body flat-radio">
										<div class="row form-section">
										
										<!--	<div class="col-md-12 margin-top-10">
												<div>
													<label>Art Instruction</label>
												</div>
													<div class="btn-group" data-toggle="buttons">
													<?php $results = $artinst;
														foreach($results as $result) { ?>
														<label class="btn grey margin-right-10 margin-bottom-5 <?php if(isset($cat) && $cat[0]['artinstruction'] ==  $result['id']) echo 'active'; ?>">
															<input type="radio" name="artinst" id="artinst" value="<?php echo $result['id']; ?>" 
															<?php if(isset($cat) && $cat[0]['artinstruction'] ==  $result['id']) echo 'checked="checked"'; ?> required="required"> 
															    <?php echo $result['name'];?>
														</label>  
													<?php } ?>
													 </div>
											</div>-->
											<div class="col-md-12 margin-top-10">
												<div>
													<label>Ad Type</label> 
													
												</div>
												<div id="ad_type_error_div"></div>
      
												<div class="btn-group" data-toggle="buttons">
												<?php $results = $adtype; foreach($results as $result){ ?>
													<label class="adtype btn grey margin-right-10 margin-bottom-5 <?php if((isset($cat) && $cat[0]['adtypewt'] ==  $result['id']) || ($row['order_type_id'] == '6' && $result['id'] == '6')) echo 'active'; ?>" data-id="<?php echo $result['id']; ?>">
														<input type="radio" name="adtype" id="adtype" 
														value="<?php echo $result['id']; ?>" required="required" 
														<?php if((isset($cat) && $cat[0]['adtypewt'] ==  $result['id']) || ($row['order_type_id'] == '6' && $result['id'] == '6')) echo 'checked="checked"'; ?>
														> 
														<?php echo $result['name'];?>
													</label> 
												<?php }  ?>
												</div>
											</div>
											
											<div class="col-md-12 margin-top-10" id="sub_category_div">
											    
											    <!--- Load sub category based on ad type selected -->
											</div>
										</div>
									</div>	 
								</div>
							</div>
						<hr>
						<div class="row">	
						  <div class="col-md-7"></div>	
						  <div class="col-md-5">
							<div class="form-actions text-right">
								<span>
									<label class="margin-right-10 font-grey-cascade">
									<input type="checkbox" name="rush" value="1">Rush</label>
								</span>
								<div style=" display: none;">	
        						    <p class="contact"><label for="name">No of Options</label></p>
        							<select class="select-style gender" id="no_pages" name="no_pages" >
        							    <option value="1" >1</option>
        							</select> 
        					    </div>
        					    <div style="display:none;" id="cat_form_div">
                                                      
                                 </div>
								<input name="category" value="<?php if(isset($category)) echo($category)?>" readonly style="display:none;" />
								<input value="<?php if(isset($orders))echo $orders[0]['publication_id'];?>" id="publication" name="publication" autocomplete="off" readonly style="display:none;" />
								<!--button type="submit" id="btn" name="confirm" class="btn green-seagreen btn-sm" onclick="return Adp_confirm();">Submit</button>-->

                                 <button type="button" id="btn" name="confirm" class="btn green-seagreen btn-sm" onclick="showConfirmationModal();">Submit</button>
							</div> 
						  </div>	
						  
						  </div>
						</div>
						</form>
						
					</div>	
				</div>	
			</div>
		<?php } ?>
<!-- Order Status 1 Categorize Ends -->

<!-- Simplified Instruction --->
    <?php if($orders[0]['status']!='5' && $orders[0]['status']!='7') { //Not in pdf_sent & Approved ?>    
                <div class="row margin-top-20">
        			<div class="col-md-12">
        				<div class="portlet  blue-hoki box">
        					<div class="portlet-title">
        						<div class="caption static-info">
        							<div class="value bold">Simplify Instruction </div>
        						</div>	
        						<div class="tools">
        							<a href="javascript:;" class="collapse" data-original-title="" title=""></a>
        						</div>
        					</div>
        					<div class="portlet-body">
        					<?php 
                                $sit_file_path = 'SIT_notes/'.$order_id.'.txt'; 
                                if(file_exists($sit_file_path) && filesize($sit_file_path)){ 
                            ?> 
                                <div class="scroller" style="height:auto" data-always-visible="1" data-rail-visible="0">
        						      <?php echo nl2br(file_get_contents( $sit_file_path )); ?>
        						 </div>
        				        
        					<?php }else{ ?>    
        					        <div id="sitForm">
        							<form method="post" action="<?php echo base_url().index_page().'new_csr/home/sit/'.$order_id;?>">
        							    <textarea rows="2" name="custom_notes" class="form-control" placeholder="Simplify instructions" class=""></textarea>
        								<input class="btn btn-primary btn-xs" style="margin-top:20px" type="submit" value="Simplify Instructions">
        							</form>
        					    </div>	  
        				    <?php } ?>
        					</div>
        				</div>
        			</div>
        		</div>
    <?php } ?>
<!-- Simplified Instruction END--->   
<!------ Rush Ad Option --------->
<?php 
    $os = array('1', '2');
    if(!in_array($orders[0]['status'], $os) && $orders[0]['rush'] != '1' && !isset($rev_orders)){ 
?>
    <div class="row">	
		<div class="col-md-7"></div>	
		<div class="col-md-5">
			<div class="form-actions text-right">
				<span>
					    <label class="margin-right-10 font-grey-cascade">
						<input type="checkbox" id="rushBox" name="rush" value="1">Rush</label>
				</span>
            </div>
        </div>
    </div>
<?php } ?>    
<!------ Rush Ad Option END--------->
<!--pro status 1 and 2 starts-->
<?php $pp = $this->db->query("SELECT * FROM `designer_ads_time` WHERE `order_id`='".$order_id."'")->result_array();
		if(isset($cat) && ($cat[0]['pro_status']=='1' || $cat[0]['pro_status']=='2')){  ?>
<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
			<div class="portlet-titl no-space margin-top-10">
				<div class="row static-info">
					<div class="col-md-2 value bold margin-top-5">V1&nbsp;
					    <a class="popovers margin-right-10" data-trigger="hover" data-container="body" data-placement="top" 
						data-title="Slug Created by: <?php echo $designer[0]['name'].'('.$designer[0]['username'].')'; ?>" 
						data-content="Date & Time: <?php echo $cat[0]['ddate'].' '.$cat[0]['start_time']; ?>">
							<i class="fa  fa-info-circle"></i>
						</a>
					</div>

					<div class="col-md-6 text-right">
						<div class="tools">
						</div>
					</div>
				</div>
			</div>
		</div>	
	</div>
</div>
<?php } ?>
<!-- pro status 1 and 2 Ends-->	 

<!--pro status 3 (In QA) Starts-->
<?php 
    if(isset($cat) && ($cat[0]['pro_status'] == '3') && ($row['status'] != '5' || $cat[0]['pro_status'] != '5') && ($row['cancel']!="1" && $row['crequest']!="1")){
		$pp = $this->db->query("SELECT * FROM `designer_ads_time` WHERE `order_id`='".$order_id."'")->result_array();
		$designer = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$cat[0]['designer']."'")->result_array();  ?> 
<div class="row">
	<div class="col-md-6">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="row static-info">
					<div class="col-md-2 col-sm-12 value bold margin-top-5">V1 &nbsp;
						<a class="popovers margin-right-10" data-trigger="hover" data-container="body" data-placement="top" 
						data-content="Designer: <?php echo $designer[0]['name'].'('.$pp[0]['end_date'].' '.$pp[0]['end_time'].')'; ?><br>"
							data-html="true" data-placement="bottom">
						    <i class="fa  fa-info-circle" title="Designer: <?php echo $designer[0]['name'].'('.$pp[0]['end_date'].' '.$pp[0]['end_time'].')'; ?>"></i>
						</a>
						<!--TL: <?php if(isset($tl)){ echo $tl[0]['name']; ?> (<?php echo $pp[0]['end_date'].' '.$pp[0]['end_time']; ?>)<?php } ?>-->
					</div> 
					<?php
						$from=date_create($orders[0]['created_on']);
						$to=date_create(date("Y-m-d"));
						$diff=date_diff($from,$to);
						$date_diff = $diff->format("%a");

						if($date_diff > $pub_name[0]['rev_days']) {
							if(file_exists($orders[0]['pdf'])) { ?>
						<div class="col-md-6 col-xs-6 pull-right ">
							<a href="<?php echo base_url().''.$orders[0]['pdf'];?>" target="_Blank" class="btn btn-block btn-default btn-sm">PDF</a>
						</div>
					<?php } } else {?>
					<div class="col-md-10 col-sm-12 margin-bottom-10 no-space">
						<div class="row">
							<?php if($csr_alias[0]['csr_role'] == '3') { ?>
								<div class="col-md-2 no-space">
								<form method="post">
									<input type="text" name="order_id" value="<?php echo $order_id; ?>" style="display:none;">
									<button type="submit" name="untag_csr" class="btn btn-default btn-outline btn-sm">Take Over</button>
								</form>
								</div>
							<?php } ?>
						
						<!--	<?php if($cat[0]['csr_QA'] =='0' && $csr_alias[0]['csr_role'] == '3' && $cat[0]['tag_csr'] != '0') { ?>
							
								<div class="col-md-2">
								<form method="post">
									<input type="text" name="order_id" value="<?php echo $order_id; ?>" style="display:none;">
									<button type="submit" name="untag_csr" class="btn btn-default btn-outline btn-sm">UnTag</button>
								</form>
								</div>
							<?php } ?> -->
						
						<!--	<?php if($cat[0]['csr_QA'] =='0' && $cat[0]['tag_csr'] == '0' && $csr_alias[0]['csr_role'] == '3') { ?>
								<div class="col-md-6">
								<form method="POST">
									<select name="tag_csr" onchange="this.form.submit()" class="form-control input-sm">
									<option value="">Tag CSR</option>
									<?php foreach($tag_csr as $tag_row) { ?>
									<option value="<?php echo $tag_row['id'] ;?>"><?php echo $tag_row['name'] ;?></option><?php } ?>
									</select>
								</form>
								</div>
							<?php } ?>-->
						<?php  
						    $i=1;  
						    if(isset($sourcefile)) { 
							    $this->load->helper('directory');	
							    $map1 = glob($sourcefile.'/'.$slug.'.{pdf,jpg,gif,png}',GLOB_BRACE); //pdf/image
							    $map2 = glob($sourcefile.'/'.$cat[0]['slug'].'.{indd,psd}',GLOB_BRACE);
							    
							    if((isset($orders_multiple_size[0]['id']) || isset($orders_multiple_custom_size[0]['id'])) && $orders[0]['ad_format']!='5'){ //multiple size web ads
							         $zip_file = $sourcefile.'/'.$cat[0]['slug'].'.zip' ; 
						?>
							            <div class="col-md-4 col-sm-4 col-xs-4">
            								<form action="<?php echo base_url().'index.php/new_csr/home/multiple_zip_folder_select/'.$order_id; ?>" method="post">
            									<input name="new_slug" value="<?php echo $cat[0]['slug'];?>" readonly style="display:none;" />
            									<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
            									<input name="download" value="download" readonly style="display:none;" />
            									<button type="submit" name="SourceDownload" class="btn btn-default btn-sm">Package</button>
            								</form>
            							</div>
						<?php
							    }else{
    								if($map2){ 
    								    $map3 = glob($sourcefile.'/'.$slug.'.{pdf,jpg,gif,png}',GLOB_BRACE);
    									if($map1){foreach($map1 as $row_map3){ $pdf_file = basename($row_map3); } }	
    									foreach($map2 as $row_map2){ $source_file = basename($row_map2); }
    							        if($cat[0]['csr_QA'] == $csr_alias[0]['id']) { 
    					?>	
                							<div class="col-md-2 col-sm-4 col-xs-4">
                								<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row_map2; ?>"
                								class="btn btn-default btn-sm">In-Design</a> 
                							</div>
                									
                							<div class="col-md-2 col-sm-4 col-xs-4">
                								<form action="<?php echo base_url().'index.php/new_csr/home/zip_folder_select'?>" method="post">
                									<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
                									<input name="new_slug" value="<?php echo $cat[0]['slug'];?>" readonly style="display:none;" />
                									<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
                									<input name="download" value="download" readonly style="display:none;" />
                									<button type="submit" name="SourceDownload" class="btn btn-default btn-sm">Package</button>
                								</form>
                							</div>		
    						<?php 
    							        } 
    							    } 
							    
							?>
        							<div class="col-md-2 col-sm-4 col-xs-4">
        							    <?php if($cat[0]['sold_pdf']!='none' && ($cat[0]['csr_QA'] == $csr_alias[0]['id'])){ ?>
        								    <a href="<?php echo base_url().''.$cat[0]['sold_pdf'];?>" target="_Blank" type="button" class="btn btn-default btn-sm">Sold PDF</a>
        							    <?php } ?>
        							</div>							
        							<div class="col-md-4 col-sm-4 col-xs-4 pull-right">
        								<?php 
        								    if($map1){ 
        								        foreach($map1 as $row_map1){   
        								?>
        								            <a href="<?php echo base_url().$row_map1 ?>" target="_Blank" type="button" class="btn btn-default btn-sm">PDF</a> 
        								<?php
        								        } 
        								    }else{ echo "<small>No Files</small>"; } 
        								?>
        							</div>
						<?php 
							    }
						    }elseif($help_desk['ftp_server'] != 'none' && $cat[0]['source_path']!='none'){ //FTP  
						?>
							<div class="col-md-2 col-sm-2 col-xs-4">
								<a href="<?php echo 'http://'.$cat[0]['source_path'].'/'.$cat[0]['slug'].'.zip'; ?>" target="_Blank" type="button" class="btn btn-default btn-sm">Package</a>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-4 pull-right">
								<a href="<?php echo 'http://'.$cat[0]['pdf_file']; ?>" target="_Blank" type="button" class="btn btn-default btn-sm">PDF</a>
							</div>
						<?php 
						    }elseif($cat[0]['ftp_source_path'] != 'none' || $cat[0]['ftp_source_path'] != '') { echo " "; }
						    
						     if(isset($proofing_msg)){ 
						?>
								<div class="col-md-6 margin-top-5">
								<span class="font-sm font-green">
									<?php echo $proofing_msg; ?>
								</span>
								</div>
						<?php } ?>
						</div>
					</div>
					<?php }?>
				</div>
			</div>
			<div class="portlet-body"> 
			<?php 
			    if(isset($sourcefile)) {
					$this->load->helper('directory');	
					$map1 = glob($sourcefile.'/'.$slug.'.{pdf,jpg,gif,png}',GLOB_BRACE); //pdf/image
					$map2 = glob($sourcefile.'/'.$cat[0]['slug'].'.{indd,psd}',GLOB_BRACE); 
					if($map2){
						if($map1){ foreach($map1 as $row_map3){ $pdf_file = basename($row_map3); } }
						foreach($map2 as $row_map2){ $source_file = basename($row_map2); } 
					}
				} 
			?>
				<div class=" portlet-tabs">
					<?php if($cat[0]['csr_QA'] == '0') { ?>
					<form method="post"> 
						<button type="submit" name="proof_check" class="btn btn-default btn-sm bg-red-thunderbird">Proof Check</button>
						<input type="text" name="order_id" value="<?php echo $order_id; ?>" style="display:none;">
					</form>
					<?php 
					    }elseif($cat[0]['csr_QA'] == $csr_alias[0]['id']) { 
					?>
    					<ul class="nav nav-tabs">
    						<!--<li class=""><a href="#portlet_tab4" data-toggle="tab">To DC </a></li>-->
    						
    						<li><a href="#portlet_tab5" data-toggle="tab">To Designer</a></li>
    						<!--<li class=""><a href="#portlet_tab6" data-toggle="tab" class="bg-red-thunderbird">To AdRep </a></li>-->
    						<li class=""><a href="#portlet_tab6" data-toggle="tab">To AdRep </a></li>
    					</ul>
					<?php } ?>
					
					<div class="tab-content">
					    <!-- To DC start
						<div class="tab-pane" id="portlet_tab4">
							<form  method="POST" role="form" enctype="multipart/form-data">
								<div class="form-body margin-bottom-10">
									<div class="form-group">
										<div class="scroller" style="height:35px; width:300px" data-always-visible="1" data-rail-visible="0">
											<div class="input-group">
												<div class="icheck-list" onSelect="clickMeId">
													<?php
														foreach($note_csr_dc as $result){ ?>
													<label>
														<input type="radio" id="hide_others2<?php echo $result['id']; ?>" name="QA_msg" value="<?php echo $result['name']; ?>"> <?php echo $result['name'];?> 
													</label>
												<?php } ?>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-12 no-space text-right margin-top-10">
									<label><input id="show_others2" type="radio" name="QA_msg" value="others"/> Write you own </label>
								</div>								
								<textarea id="others2" name="DC_reason" class="form-control margin-top-15 margin-bottom-10" rows="2"/></textarea>
								
								<div class="row">	
									<div class="col-sm-12 text-right margin-top-10" >
										<button type="submit" name="send_DC" class="btn red">Send to DC </button>
									</div>
								</div>
							</form>
						</div>
						 To DC END-->
						 
						<!-- To Designer start-->
						<div class="tab-pane margin-top-10" id="portlet_tab5">
						   <?php if($csr_alias[0]['pdf_review_tool'] == '1' && $orders[0]['order_type_id'] == '2'){ ?>
        							<a href="#full" data-toggle="modal" type="button" class="btn btn-default btn-sm pull-right">PDF Review</a>   
        					<?php } ?>
							<form method="POST" role="form" enctype="multipart/form-data"> 
								<div class="form-body">
									<div class="form-group margin-bottom-5">
										<div class="scroller" style="height:110px; width:300px" data-always-visible="1" data-rail-visible="0">
											<div class="input-group">
												<div class="icheck-list" onSelect="clickMeId">
													<?php foreach($note_csr_designer as $result){ ?>
														<label>
															<input required type="radio" id="hide_others3<?php echo $result['id']; ?>" name="msg" value="<?php echo $result['name']; ?>"> <?php echo $result['name'];?> 
														</label>
													<?php } ?>
												</div> 
											</div>
										</div> 
									</div>
								</div>    
								<div class="row">
								<?php 
								    if($csr_alias[0]['pdf_review_tool'] == '1' && $orders[0]['order_type_id']=='2'){  
								    }else{
								?> 	
									<div class="col-sm-6">
									    <input type="hidden" name="slug_name" id="slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $cat[0]['slug'];?>">
										<input type="file" name="file2" id="file2" onchange="getFileData(this);" class="form-control"/>
									</div>
								<?php } ?>	
									<div class="col-sm-6">
										<label><input required id="show_others3" type="radio" name="msg" value="others" /> Write your own </label>
									</div>								
									<div class="col-sm-12">
										<textarea id="others3" name="csr_msg" class="form-control margin-top-10" rows="2" /></textarea>
									</div>
								</div>
							<?php if($help_desk['ftp_server'] != 'none'){ ?>
								<div class="row margin-top-10">	
									<div class="col-md-6 col-xs-6 pull-right text-right margin-top-10">
										<button type="submit" name="sent_designer" value="<?php echo $cat[0]['pro_status']; ?>" class="btn green">Send to Designer </button>
									</div>
								</div>
							<?php }elseif(isset($sourcefile)){ ?>
								<div class="row margin-top-10">	
									<div class="col-md-6 col-xs-6 pull-right text-right margin-top-10">
										<input type="text" name="sourcefile" value="<?php echo $sourcefile; ?>" style="display:none;">
										<button type="submit" name="sent_designer" value="<?php echo $cat[0]['pro_status']; ?>" class="btn green">Send to Designer </button>
									</div>
								</div>
							<?php } ?>
							</form>
						</div>
						<!-- To Designer END-->
						
						<!-- To Adrep start-->
						<?php if($help_desk['ftp_server'] != 'none'){ ?>
						<div class="tab-pane" id="portlet_tab6">
							<form  method="POST" id="send_to_adrep_form" class="form-horizontal" role="form" enctype="multipart/form-data"> 
								<textarea id="note" name="note" class="form-control margin-top-15 margin-bottom-10" rows="2"></textarea>
								
								<div class="row">	
									<div class="col-sm-12 text-right margin-top-10" >
										<span class="margin-right-10">
										<input type="text" name="hd" hidden value="<?php echo $hd; ?>">
										<input name="order_id" value="<?php echo $order_id;?>" readonly style="display:none;" />
										<!--<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />-->
										<input name="new_slug" value="<?php echo $slug;?>" readonly style="display:none;" />
										<input name="cat_slug" value="<?php echo $slug;?>" readonly style="display:none;" />
										<!--<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
										<input name="pdf_file" value="<?php echo $pdf_file;?>" readonly style="display:none;" />-->
										<input name="archive" value="archive" readonly style="display:none;" />
										<input  id="show_note"  type="checkbox" value="1">Note
										<input  name="end_time" style="display:none;" type="text">
										</span>
										<button type="button" class="btn red-thunderbird" onclick="sendToAdrepmodal()">Send to AdRep </button>
										<!--<button type="submit" name="end_time" class="btn red-thunderbird" onclick="return Adp_confirm();">Send to AdRep </button>-->
									</div>
								</div>
							</form>
						</div>
						<?php 
						    }elseif(isset($sourcefile)){ 
						        if((isset($orders_multiple_size[0]['id']) || isset($orders_multiple_custom_size[0]['id'])) && $orders[0]['ad_format']!='5'){  //multiple size web ads
						?>
						            <div class="tab-pane" id="portlet_tab6">
            							<form  method="POST" id="send_to_adrep_form" class="form-horizontal" role="form" enctype="multipart/form-data"> 
            								<textarea id="note" name="note" class="form-control margin-top-15 margin-bottom-10" rows="2"></textarea>
            								<div class="row">	
            									<div class="col-sm-12 text-right margin-top-10" >
            										<span class="margin-right-10">
            										<input type="text" name="hd" hidden value="<?php echo $hd; ?>">
            										<input name="order_id" value="<?php echo $order_id;?>" readonly style="display:none;" />
            										<input name="new_slug" value="<?php echo $slug;?>" readonly style="display:none;" />
            										<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
            										<input name="archive" value="archive" readonly style="display:none;" />
            										<input  id="show_note"  type="checkbox" value="1">Note
            										<input  name="end_time" style="display:none;" type="text">
            										</span>
            										<button type="button" class="btn red-thunderbird" onclick="sendToAdrepmodal()">Send to AdRep </button>
            										<!--<button type="submit" name="end_time" class="btn red-thunderbird" onclick="return Adp_confirm();">Send to AdRep </button>-->
            									</div>
            								</div>
            							</form>
            						</div>
					    <?php 
					            }else{ 
					    ?>
            						<div class="tab-pane" id="portlet_tab6">
            						<?php if($csr_alias[0]['pdf_review_tool'] == '1' && $orders[0]['order_type_id'] == '2'){  //for pdf review ?>
            						    <!-- source upload START-->
                						    <div class="margin-top-10">
                										<div class="row"><p><?php //echo $cat[0]['slug'];  ?></p>
                										    <!--  Indesign file	-->									
                                        					<div class="col-md-6 col-sm-6 col-xs-12 margin-bottom-15">
                                        					  <div class="row no-space border-dashed">
                                        							<div class="col-md-4 col-sm-3 col-xs-4 no-space">	
                                        								<img class="padding-6" src="<?php echo base_url();?>assets/new_designer/img/indd.jpg" alt="indd" width="100%">
                                        							</div>
                                        							<div class="col-md-8 col-sm-9 col-xs-8 no-space">	
                                        								<form action="<?php echo base_url().index_page().'new_csr/home/new_fileuploads/'.$order_id; ?>"  id="dropzoneindd" class="dropzone" method="post">
                                        									<input type="hidden" name="slug_name" id="slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $cat[0]['slug'];  ?>">
                                        									<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="indd">
                                        									<div class="dz-default dz-message margin-top-20">
                                        										<span>Indesign File</span>
                                        									</div>
                                        								</form>
                                        							</div>
                                        						</div>
                                        					</div>
                                        					<!--  PDF file	-->
                                        					<div class="col-md-6 col-sm-6 col-xs-12 margin-bottom-15">	
                                        					  <div class="row no-space border-dashed">
                                        							<div class="col-md-4 col-sm-3 col-xs-4 no-space">	
                                        								<img class="padding-6" src="<?php echo base_url();?>assets/new_designer/img/pdf.jpg" alt="pdf" width="100%">
                                        							</div>
                                        							<div class="col-md-8 col-sm-9 col-xs-8 no-space">	
                                        								<form action="<?php echo base_url().index_page().'new_csr/home/new_fileuploads/'.$order_id; ?>"   id="dropzonepdf" class="dropzone" method="post">
                                        									<input type="hidden" name="slug_name" id="slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $cat[0]['slug'];?>">
                                        									<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="pdf">
                                        									<div class="dz-default dz-message margin-top-20">
                                        										<span>PDF File</span>
                                        									</div>
                                        								</form>
                                        							</div>
                                        						</div>
                                        					</div>
                                        				</div>
                                        					
                                        				<div class="row">
                                        				    <!-- Links File -->	
                                        					<div class="col-xs-6 margin-bottom-15">	
                                        					  <div class="row no-space border-dashed" id="links">
                                        							<div class="col-md-12 col-sm-12 col-xs12 no-space">	
                                        								<form action="<?php echo base_url().index_page().'new_csr/home/new_fileuploads/'.$order_id; ?>" id="dropzonelink" class="dropzone" method="post">
                                        									<input type="hidden" name="slug_name" id="slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $cat[0]['slug'];?>">
                                        									<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="links">
                                        									<div class="dz-default dz-message margin-top-20 margin-bottom-20">
                                        										<span>Links File</span>
                                        									</div>
                                        								</form>
                                        							</div>	
                                        						</div>
                                        					</div>
                                        					<!-- Fonts File -->	
                                        					<div class="col-xs-6 margin-bottom-15">	
                                        					  <div class="row no-space border-dashed" id="fonts">
                                        							<div class="col-md-12 col-sm-12 col-xs12 no-space">	
                                        								<form action="<?php echo base_url().index_page().'new_csr/home/new_fileuploads/'.$order_id; ?>" id="dropzonefont" class="dropzone" method="post">
                                        									<input type="hidden" name="slug_name" id="slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $cat[0]['slug'];?>">
                                        									<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="fonts">
                                        									<div class="dz-default dz-message margin-top-20 margin-bottom-20">
                                        										<span>Fonts File</span>
                                        									</div>
                                        								</form>
                                        							</div>	
                                        						</div>
                                        					</div>
                                        				</div>
                                        	</div>
                					    <!-- source upload END -->
                					<?php } ?>
            							<form  method="POST" id="send_to_adrep_form" class="form-horizontal" role="form" enctype="multipart/form-data">
            							    <?php if($csr_alias[0]['pdf_review_tool'] == '1' && $orders[0]['order_type_id'] == '2'){  //for pdf review ?>
                							    <div class="form-body">
                									<div class="form-group margin-bottom-10">
                										<!--<div class="scroller" style="height:85px; width:300px" data-always-visible="1" data-rail-visible="0">-->
                											<div class="input-group">
                												<div class="icheck-list" onSelect="clickMeId" >
                													<?php foreach($csr_to_adrep_options as $result){ ?>
                														<label>
                															<input type="radio" name="csr_to_adrep_option" value="<?php echo $result['id']; ?>"> <?php echo $result['name'];?> 
                														</label>
                													<?php } ?>
                												</div> 
                											</div>
                										<!--</div> -->
                									</div>
                								</div>
            								<?php } ?>
            								<textarea id="note" name="note" class="form-control margin-top-15 margin-bottom-10" rows="2"></textarea>
            								<div class="row">	
            									<div class="col-sm-12 text-right margin-top-10" >
            										<span class="margin-right-10">
                										<input type="text" name="hd" hidden value="<?php echo $hd; ?>">
                										<input name="order_id" value="<?php echo $order_id;?>" readonly style="display:none;" />
                										<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
                										<input name="new_slug" value="<?php echo $slug;?>" readonly style="display:none;" />
                										<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
                										<input name="pdf_file" value="<?php echo $pdf_file;?>" readonly style="display:none;" />
                										<input name="archive" value="archive" readonly style="display:none;" />
                										<input  id="show_note"  type="checkbox" value="1">Note
                										<input  name="end_time" style="display:none;" type="text">
            										</span>
            										<!--<button type="submit" name="end_time" class="btn red-thunderbird" onclick="return Adp_confirm();">Send to AdRep </button>-->
            										<button type="button" class="btn red-thunderbird" onclick="sendToAdrepmodal()">Send to AdRep </button>
            									</div>
            								</div>
            							</form>
            						</div>
						<?php 
						        }
						    } 
						?>
						<!-- To Adrep END-->
					</div>
				    
				</div>
				
			</div>
		</div>
	</div>
	
	<div class="col-md-6">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="row static-info  margin-top-10">
					<div class="col-md-10 value bold">Conversations</div>
				</div>
			</div>
			<div class="row portlet-body">
				<div class="col-md-12 col-sm-12">
				    <div id="pdf_annotation_div">
				    <?php if(isset($oa_fname) && isset($oa_url)){  //pdf annotation ?>
						<div class="row margin-top-10 margin-bottom-10">
						    <div class="col-sm-12">
							    <span class="font-red">CSR marked PDF changes - </span>
							    <a href="<?php echo $oa_url; ?>" target="_Blank"><?php echo $oa_fname; ?></a>
							 </div>
					    </div>
				    <?php } ?>
				    </div>
				 <div class="scroller" style="height:200px" data-always-visible="1" data-rail-visible="0">
						<?php
				$qustion = $this->db->query("SELECT * FROM `production_conversation` WHERE `order_id`='".$order_id."' order by `id` desc")->result_array(); 
				
				  if(!isset($qustion[0]['id'])){
					echo '<p class="text-center">'."No Conversations".'</p>';
				}  
				if($qustion) { $i=0; foreach($qustion as $qustion1) { $i++; 
							
			?>
				<!--TL_designer MESSAGE-->
				<?php if(($qustion1['tl_id']!='0') && ($qustion1['operation']=='tl_designer')){ 
							$tl = $this->db->query("SELECT * FROM `team_lead` WHERE `id`='".$qustion1['tl_id']."'")->result_array(); 
				?>
					<div <?php if($i=='1'){ echo'class="note note-danger"'; }else{ echo 'class="note note-grey"'; } ?>>
						<div class="row">
							<div class="col-sm-6">
								<?php echo $qustion1['message']; ?>
								<?php
									if(isset($tl_path)){ 
										$map = glob($tl_path.'/*.{jpg,png,tiff,gif,html,pdf,indd}',GLOB_BRACE);								
										if($map){			
											foreach($map as $row) {  
										?>
								<p class="margin-top-10"> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
								<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a></p>
								<?php } } } ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php   echo $tl[0]['first_name']; ?> (Team Lead) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
					<!--TL_designer MESSAGE-->
					
					<?php } else { ?>
					
			<!--designer_TL_designer MESSAGE-->
				<?php if(($qustion1['tl_designer_id']!='0') && ($qustion1['operation']=='tl_designer')){ 
							$tl_designer_id = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$qustion1['tl_designer_id']."'")->result_array(); 
				?>
					<div <?php if($i=='1'){ echo'class="note note-danger"'; }else{ echo 'class="note note-grey"'; } ?>>
						<div class="row">
							<div class="col-sm-6">
								<?php echo $qustion1['message']; ?>
								<?php
									if(isset($tl_path)){ 
										$map = glob($tl_path.'/*.{jpg,png,tiff,gif,html,pdf,indd}',GLOB_BRACE);								
										if($map){			
											foreach($map as $row) {  
										?>
								<p class="margin-top-10"> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
								<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a></p>
								<?php } } } ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php   echo $tl_designer_id[0]['name']; ?> (D Team Lead) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
				<?php } } ?>
			<!--designer_TL_designer MESSAGE-->
						
			<!--QA to designer MESSAGE-->
					<?php if(($qustion1['csr_id']!='0') && ($qustion1['operation']=='QA_designer')) { 
								$csr = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$qustion1['csr_id']."'")->result_array();   
					?>
					<div <?php if($i=='1'){ echo'class="note note-info"'; }else{ echo 'class="note note-grey"'; } ?>>
					
						<div class="row">
							<div class="col-sm-6">
							<?php echo $qustion1['message']; ?>
							<?php if(isset($csr_path)){ 
										$map = glob($csr_path.'/*.{jpg,png,gif,tiff,html,pdf,indd}',GLOB_BRACE);								
										if($map){			
											foreach($map as $row) {  
								?>
								 <p class="margin-top-10"> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
								<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a></p>
							<?php } } } ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php  echo $csr[0]['name'];  ?> (CSR) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
			<!--QA to designer MESSAGE-->
					
			<!--DC to designer MESSAGE-->
				<?php } if(($qustion1['dc_id']!='0') && ($qustion1['operation']=='DC_designer')) { $csr = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$qustion1['dc_id']."'")->result_array();   ?>		
					
					<div <?php if($i=='1'){ echo'class="note note-success"'; }else{ echo 'class="note note-grey"'; } ?>>
						<div class="row">
							<div class="col-sm-6">
								<?php echo $qustion1['message']; ?>
								<?php if(isset($dc_csr_path)){ 
								$map = glob($dc_csr_path.'/*.{jpg,png,gif,html,tiff,pdf,indd}',GLOB_BRACE);								
								if($map){			
									foreach($map as $row){  
								?>
								<p class="margin-top-10"> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
								<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a>
								</p>
								<?php } } } ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php  echo $csr[0]['name'];  ?> (CSR) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
			<!--DC to designer MESSAGE-->
					
			<!--designer msg-->
			<?php }  if($qustion1['designer_id']!='0') { $designer = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$qustion1['designer_id']."'")->result_array();   ?>		
					<div <?php if($i=='1'){ echo'class="note note-danger"'; }else{ echo 'class="note note-grey"'; } ?>>
						
						<div class="row">
							<div class="col-sm-6"><?php echo $qustion1['message']; ?></div>
							<div class="col-sm-6 text-right">
							<h4><?php echo $designer[0]['name'] ;?> (Designer)</h4>
								<span class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </span>
							</div>
						</div>
					</div>
					<?php } ?>
			<!--designer mesg-->
				
			<!--TL to QA-->
			<?php if(($qustion1['tl_id']!='0') && ($qustion1['operation']=='tl_QA')) { $tl = $this->db->query("SELECT * FROM `team_lead` WHERE `id`='".$qustion1['tl_id']."'")->result_array();   ?>
					<div <?php if($i=='1'){ echo'class="note note-info"'; }else{ echo 'class="note note-grey"'; } ?>>
						
						<div class="row">
							<div class="col-sm-6">
								<?php echo $qustion1['message']; ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php  echo $tl[0]['first_name'];  ?> (Team Lead) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
			<?php } else { ?>
			<!--TL to QA -->
			
			<!--designer_TL to QA-->
			<?php if(($qustion1['tl_designer_id']!='0') && ($qustion1['operation']=='tl_QA')) { $tl_designer_id = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$qustion1['tl_designer_id']."'")->result_array();   ?>
					<div <?php if($i=='1'){ echo'class="note note-info"'; }else{ echo 'class="note note-grey"'; } ?>>
						
						<div class="row">
							<div class="col-sm-6">
								<?php echo $qustion1['message']; ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php  echo $tl_designer_id[0]['name'];  ?> (D Team Lead) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
			<?php } } ?>
			<!--designer_TL to QA -->
			
			<!--TL to DC -->
			<?php if(($qustion1['tl_id']!='0') && ($qustion1['operation']=='tl_DC')) { $tl = $this->db->query("SELECT * FROM `team_lead` WHERE `id`='".$qustion1['tl_id']."'")->result_array();   ?>
					<div <?php if($i=='1'){ echo'class="note note-success"'; }else{ echo 'class="note note-grey"'; } ?>>
						<div class="row">
							<div class="col-sm-6"><?php echo $qustion1['message']; ?></div>
							<div class="col-sm-6 text-right">
							<h4><?php  echo $tl[0]['first_name'];  ?> (D Team Lead) </h4>
								<span class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </span>
							</div>
						</div>
					</div>
			<!--TL to DC-->
			<?php } else { ?>
			<!--designer_TL to DC -->
			<?php if(($qustion1['tl_designer_id']!='0') && ($qustion1['operation']=='tl_DC')) { $tl_designer_id = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$qustion1['tl_designer_id']."'")->result_array();   ?>
					<div <?php if($i=='1'){ echo'class="note note-success"'; }else{ echo 'class="note note-grey"'; } ?>>
						<div class="row">
							<div class="col-sm-6"><?php echo $qustion1['message']; ?></div>
							<div class="col-sm-6 text-right">
							<h4><?php  echo $tl_designer_id[0]['name'];  ?> (D Team Lead) </h4>
								<span class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </span>
							</div>
						</div>
					</div>
			<?php } } ?>	
			<!--designer_TL to DC-->
			
				
			<!--QA to DC-->
			<?php if(($qustion1['csr_id']!='0') && ($qustion1['operation']=='QA_DC')) { $csr = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$qustion1['csr_id']."'")->result_array();   ?>
					<div <?php if($i=='1'){ echo'class="note note-danger"'; }else{ echo 'class="note note-grey"'; } ?>>
						
						<div class="row">
							<div class="col-sm-6"><?php echo $qustion1['message']; ?></div>
							<div class="col-sm-6 text-right">
							<h4><?php  echo $csr[0]['name'];  ?> (CSR) </h4>
								<span class="font-grey-cascade"><?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </span>
							</div>
						</div>
					</div>
			<!--QA to DC-->	
			<?php } } } ?>
				</div>	
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?> 
<!--pro status 3 Ends-->		
		
<!--Pro status 5 starts-->
 <?php if((isset($cat) && ($cat[0]['pro_status'] == '5')) && (!isset($rev_orders))){ ?>
<div class="row margin-top-20">			
			<div class="col-md-12">							
				<div class="portlet light margin-0">
					<div class="portlet-titl no-space margin-top-10">
						<div class="row static-info">
							<div class="col-sm-7 value ">AdwitAds ID: <?php echo $order_id; ?><?php foreach($orders as $row)?><small class="font-grey-cascade"> &nbsp; 
							(<?php $date = strtotime($row['created_on']); echo date('d F', $date).','.date('Y', $date).' '.'at'.' '.date('g:i A', $date);?>)</small>
							</div>
							<div class="col-sm-5 text-right">
								<div class="tools">
									<div class="row">
										<div class="col-sm-6">
											<?php if($cat[0]['ftp_source_path'] != 'none' && $cat[0]['ftp_source_path'] !=''){ ?>
											<div class="margin-bottom-5">
												<a href="<?php echo $cat[0]['ftp_source_path']; ?>" class="btn grey btn-sm  btn-block">Package</a>
											</div> 
											<?php } ?>
										</div>
										<div class="col-sm-3 no-space">
										<?php
											$from=date_create($row['created_on']);
											$to=date_create(date("Y-m-d"));
											$diff=date_diff($from,$to);
											$date_diff = $diff->format("%a");
								
										if(!($date_diff > $pub_name[0]['rev_days'])) { ?>
											<button class="btn bg-blue btn-xs btn-block" id="show_subrev"> Submit Revision</button>	
										<?php }else{ echo '<p style="text-align:center;">This ad is more than 30 days old, Revision not allowed, Place new order</p>'; } ?>
										</div>	
										<div class="col-sm-3">
											<button onclick="goBack()" class="btn btn-default btn-xs">← Back</button>
										</div>											
									</div>
								</div>
								<?php echo '<h3 style="color:#900;">'.$this->session->flashdata('message2').'</h3>'; ?>
							</div>
						</div>
					</div>
					
					<div class="portlet portlet-body margin-top-15 margin-bottom-10" id="subrev">
						<div class="row">
							<hr class="no-space">
							<form class="margin-top-15" id="order_form" name="order_form" method="post" enctype="multipart/form-data">
							<div class="col-md-8">
								<div class="form-group">
								<label>Note &amp; Instructions </label> <small class="font-red">*</small>
								<textarea class="form-control margin-top-10" rows="8" name="copy_content_description" id="copy_content_description" required=""></textarea>
								</div>
							</div> 
							<div class="col-md-4">
								<div class="form-group">
									<label>Attach Files</label>
									<div class="row no-space">
									<div class="col-md-12  margin-top-10 no-space"><input type="file" name="ufile[]" id="ufile[]" accept="application/pdf"></div>
									<div class="col-md-12  margin-top-10 no-space"><input type="file" name="ufile[]" id="ufile[]" accept="application/pdf"></div>
									</div>
								</div>
							</div>
							 <div class="col-md-12 text-right">
							  <hr>
								<span class=" margin-right-10 font-grey-cascade">
									<label><small><input type="checkbox" name="rush" id="rush" value="1">Rush</small></label>
								</span>
								<span class="form-group no-margin">
									 <span class="form-body flat-radio">										
										<div class="btn-group" data-toggle="buttons">
										<?php foreach($rev_reason as $row){ ?>
											<label class="btn grey btn-sm margin-right-10 margin-bottom-5 reason_option" data-id="<?php echo $row['id']; ?>"> 
											    <input type="radio" name="reason_option" id="reason_option" value="<?php echo $row['id']; ?>" required="required"><?php echo $row['name'];?>
											</label>
										<?php } ?>
										 </div>										
									</span>														
								</span>
								<input type="text" id="order_id" name="order_id" value="<?php echo $order_id; ?>" style="display:none" />
								<input type="text" id="hd" name="hd" value="<?php echo $cat[0]['help_desk']; ?>" style="display:none" />
								<input type="text" id="job_name" name="job_name" value="<?php echo $cat[0]['job_name']; ?>" style="display:none" />
								<input type="text" id="job_slug" name="job_slug"  value="<?php echo $slug;?>" style="display:none" /> 
								<div id="confirmation_div"></div>
								<button type="submit" name="submit" class="btn btn-sm btn-primary">Submit</button>
							</div>
							</form>
						 </div>						
					</div>
				</div>
			</div>
		</div>
		
		<div class="row margin-top-20">
			<div class="col-md-12">
				<div class="portlet light grey-cararra">
					<div class="portlet-titl">
						<div class="row static-info">
							<div class="col-md-7 col-sm-12 value  margin-top-15 font-grey-gallery">V1&nbsp;
							
							<?php if(isset($note_newad)){ ?>
								<span class="margin-right-10 font-yellow tooltips" data-container="body" data-placement="top" data-original-title="<?php echo $note_newad['note']; ?>"><i class="fa fa-warning"></i></span>
								<?php } ?> 
								<?php if(isset($cat) && $cat[0]['pro_status']!='0'){ 
										$status = $this->db->query("SELECT * FROM `production_status` WHERE id='".$cat[0]['pro_status']."'")->result_array();
											if($status) { ?>
								<span class="font-green tooltips" data-container="body" data-placement="top" data-original-title="<?php echo $status[0]['name'] ;?>"><i class="fa fa-check-circle font-lg"></i></span>
								<?php } else { echo " "; } } ?>
							</div>
							<?php
								$from=date_create($orders[0]['created_on']);
								$to=date_create(date("Y-m-d"));
								$diff=date_diff($from,$to);
								$date_diff = $diff->format("%a");
								//echo $date_diff;
								if($date_diff > $pub_name[0]['rev_days']) {
									if(file_exists($orders[0]['pdf']))  { ?>

								<div class="col-md-1 col-sm-3 col-xs-6 pull-right margin-bottom-5" >
									<a href="<?php echo base_url().''.$orders[0]['pdf'];?>" target="_Blank" class="btn grey btn-sm btn-block">PDF</a>
								</div>
							<?php } }else{ ?>
							<?php $help_desk = $this->db->get_where('help_desk',array('id' => $hd))->row_array();
							if($help_desk['ftp_server'] != 'none' && $cat[0]['source_path']!='none'){ ?>
								<div class="col-md-5 col-sm-12 value bold margin-top-10 no-space text-right">
									<div class="col-md-3 col-sm-3 col-xs-6 pull-right margin-bottom-5">
										<a href="<?php echo 'http://'.$cat[0]['pdf_file']; ?>" target="_Blank" class="btn grey btn-sm btn-block">PDF</a>
									</div>
									<div class="col-md-2 col-sm-3 col-xs-6 pull-right  no-space margin-bottom-5">
										<a href="<?php echo 'http://'.$cat[0]['source_path'].'/'.$cat[0]['slug'].'.zip'; ?>" class="btn btn-block btn-default btn-xs">Package</a>
									</div>
									<?php if(isset($order_form) && file_exists($order_form)) { 
									$order_map = glob($order_form.'/*',GLOB_BRACE);
									if($order_map) { ?>
									<div class="col-md-3 col-sm-3 col-xs-6 pull-right margin-bottom-5">
										<form method="post" action="<?php echo base_url().index_page().'new_csr/home/zip_folder';?>">
											<input name="file_path" value="<?php echo $order_form; ?>" readonly style="display:none;" /> 
											<input name="file_name" value="<?php echo $order_id; ?>" readonly style="display:none;" />
											<button type="submit" name="Submit" class="btn grey btn-sm btn-block">
												Download
											</button>	
										</form>
									</div>
								<?php } } ?>
								</div>
							<?php } ?>
							<?php  if(isset($sourcefile)) { 
									$map2 = glob($sourcefile.'/'.$cat[0]['slug'].'.{indd,psd}',GLOB_BRACE); 
									$map3 = glob($sourcefile.'/'.$cat[0]['slug'].'.{pdf,jpg,gif,png}',GLOB_BRACE); 
									$source_zip_file = $sourcefile.'/'.$cat[0]['slug'].'.zip' ;
							?>
							<div class="col-md-5 col-sm-12 value bold margin-top-10 no-space text-right">
								
								<?php if($cat[0]['pdf_path']!='none'){ ?>
								<div class="col-md-3 col-sm-3 col-xs-6 pull-right margin-bottom-5">
									<a href="<?php echo base_url().''.$cat[0]['pdf_path'];?>" target="_Blank" class="btn grey btn-sm btn-block">PDF</a>
								</div>
								<?php } if(file_exists($source_zip_file)){ ?>
								
								<div class="col-md-2 col-sm-3 col-xs-6 pull-right  no-space margin-bottom-5">
									<a href="<?php echo base_url()?><?php echo $source_zip_file ?>" class="btn grey btn-sm  btn-block">Package</a>
								</div>
								
								<?php } else {
									if($map2){ 
										if($map3){ foreach($map3 as $row_map3){ $pdf_file = basename($row_map3); } }
											foreach($map2 as $row_map2){ $source_file = basename($row_map2); }
								?>
								<div class="col-md-2 col-sm-3 col-xs-6 pull-right  no-space margin-bottom-5">
									<form action="<?php echo base_url().'index.php/new_csr/home/zip_folder_select'?>" method="post">
										<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
										<input name="new_slug" value="<?php echo $cat[0]['slug'];?>" readonly style="display:none;" />
										<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
										<input name="download" value="download" readonly style="display:none;" />
										<button type="submit" name="SourceDownload" class="btn grey btn-sm  btn-block">Package</button>
									</form>
								</div> 
								<?php } }?>
								<?php if(isset($order_form) && file_exists($order_form)) { 
									$order_map = glob($order_form.'/*',GLOB_BRACE);
									if($order_map) { ?>
								<div class="col-md-3 col-sm-3 col-xs-6 pull-right margin-bottom-5">
									<form method="post" action="<?php echo base_url().index_page().'new_csr/home/zip_folder';?>">
										<input name="file_path" value="<?php echo $order_form; ?>" readonly style="display:none;" /> 
										<input name="file_name" value="<?php echo $order_id; ?>" readonly style="display:none;" />
										<button type="submit" name="Submit" class="btn grey btn-sm btn-block">
											Download
										</button>	
									</form>
								</div> 
								<?php } } ?>
								<!--sold PDF-->
								<?php $help_desk1 = $this->db->query("SELECT * FROM `help_desk` WHERE `id` = '".$cat[0]['help_desk']."' AND `sold` = '1'")->result_array();
								if(($help_desk1) && ($cat[0]['sold_pdf']!='none')){ ?>
								<div class="col-md-3 col-sm-3 col-xs-6 pull-right margin-bottom-5">
									<form method="post" action="<?php echo base_url().index_page().'new_csr/home/metro_sold_order/'.$cat[0]['help_desk'].'/'.$order_id;?>">
										<input name="job_name" value="<?php echo $cat[0]['slug']; ?>" readonly style="display:none;" />
										<input name="sold_pdf" value="<?php echo $cat[0]['sold_pdf']; ?>" readonly style="display:none;" />
										<button type="submit" name="metro_sold_submit" class="btn grey btn-sm btn-block">Sold</button>
									</form>
								</div>
								<?php } ?>
								<!--sold PDF-->
							</div>
							<?php }elseif($cat[0]['ftp_source_path'] != 'none' || $cat[0]['ftp_source_path'] != '') { ?>
								<?php if($cat[0]['pdf_path']!='none' && file_exists($cat[0]['pdf_path'])){ ?>
								<div class="col-md-2 pull-right margin-bottom-5">
									<a href="<?php echo base_url().''.$cat[0]['pdf_path'];?>" target="_Blank" class="btn grey btn-sm btn-block">PDF</a>
								</div>
							<?php } } ?>
							<?php }?>
						 </div>
					</div>
				</div>
			 </div>
		  </div>

		<div class="row">
			<div class="col-md-12 text-center">
				<form method="post" action="<?php echo base_url().index_page().'new_csr/home/orderview_history/'.$hd.'/'.$order_id;?>">
					<button type="submit" class="btn bg-grey-sliver btn-sm no-margin"><i class="fa fa-history"></i> History</button>	
				</form>
			</div>
		</div>

 <?php } ?>
<!--pro status 5 Ends-->

<!--pro status 6,7,8 Starts-->
<?php if(isset($cat) && ($cat[0]['pro_status'] == '6' || $cat[0]['pro_status'] == '7' || $cat[0]['pro_status'] == '8') && ($row['status'] != '5' || $cat[0]['pro_status'] != '5')){
			$pp = $this->db->query("SELECT * FROM `designer_ads_time` WHERE `order_id`='".$order_id."'")->result_array();
			   $designer = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$cat[0]['designer']."'")->result_array();  ?>
<div class="row">
	<div class="col-md-6">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="row static-info">
					<div class="col-md-5 value bold margin-top-10">V1&nbsp;
						<a class="popovers margin-right-10" data-trigger="hover" data-container="body" data-placement="top" data-content="
							 Designer: <?php echo $designer[0]['name']?> (<?php echo $pp[0]['end_date'].' '.$pp[0]['end_time']; ?>) <br>"
							data-html="true" data-placement="bottom"><i class="fa  fa-info-circle"></i>
						</a>
						<!-- TL: <?php if(isset($tl)){ echo $tl[0]['first_name']; ?> (<?php echo $pp[0]['end_date'].' '.$pp[0]['end_time']; ?>)<?php } ?>-->
					</div>
					<?php
								$from=date_create($orders[0]['created_on']);
								$to=date_create(date("Y-m-d"));
								$diff=date_diff($from,$to);
								$date_diff = $diff->format("%a");
								//echo $date_diff;
								if($date_diff > $pub_name[0]['rev_days']) {
									if(file_exists($orders[0]['pdf']))  { ?>

								<div class="col-md-1 col-sm-3 col-xs-6 pull-right margin-bottom-5" >
									<a href="<?php echo base_url().''.$orders[0]['pdf'];?>" target="_Blank" class="btn grey btn-sm btn-block">PDF</a>
								</div>
					<?php } }else{ ?>
					
					<div class="col-md-7 value bold margin-top-5">
					 <div class="row">
						<div class="col-md-8 text-right"></div>
						<div class="col-md-4 text-right">
						<?php 
							if(isset($sourcefile)){ 
								$this->load->helper('directory');
								if((isset($orders_multiple_size[0]['id']) || isset($orders_multiple_custom_size[0]['id'])) && $orders[0]['ad_format']!='5'){  //multiple size web ads
								    $source_zip_file = $sourcefile.'/'.$cat[0]['slug'].'.zip' ; 
									if(file_exists($source_zip_file)){ 
									    echo "<a href='".base_url().$source_zip_file."' target='_Blank' type='button class='btn btn-default btn-sm'>Package</a>";
									}else{
						?>
						                <form action="<?php echo base_url().'index.php/new_csr/home/multiple_zip_folder_select/'.$order_id; ?>" method="post">
            								<input name="new_slug" value="<?php echo $cat[0]['slug'];?>" readonly style="display:none;" />
            								<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
            								<input name="download" value="download" readonly style="display:none;" />
            								<button type="submit" name="SourceDownload" class="btn btn-default btn-sm">Package</button>
            							</form>
						<?php
									}
								}else{
								    $map1 = glob($sourcefile.'/'.$slug.'.{pdf,jpg,gif,png}',GLOB_BRACE); //pdf/image
								    if($map1){ 
								        foreach($map1 as $row_map1){ 
							?>
									    <a href="<?php echo base_url().$row_map1 ?>" target="_Blank" type="button" class="btn btn-default btn-sm btn-block">PDF</a>
						<?php 
								        } 
							    	}else{ echo "No PDF or Ad Image Found for this job.."; } 
							    }
							}
						?>
						</div>
					</div>
				   </div>
<?php }?>
				</div>
			</div>
		</div>
	</div> 
			
	<div class="col-md-6">
	<div class="portlet light">
		<div class="portlet-title">
			<div class="caption static-info">
				<div class="value bold">Conversations</div>
			</div>	
			<div class="tools">
				<a href="javascript:;" class="expand" data-original-title="" title=""></a>
			</div>
		</div>
		<div class="row portlet-body" style="display:none;">
			<div class="col-md-12 col-sm-12">
			    <div id="pdf_annotation_div">
			    <?php if(isset($oa_fname) && isset($oa_url)){ //pdf annotation  ?>
						<div class="row margin-top-10 margin-bottom-10">
						    <div class="col-sm-12">
							    <span class="font-red">CSR marked PDF changes - </span>
							    <a href="<?php echo $oa_url; ?>" target="_Blank"><?php echo $oa_fname; ?></a>
							 </div>
					    </div>
				<?php } ?>
				</div>
			 <div class="scroller" style="height:218px" data-always-visible="1" data-rail-visible="0">
				<?php
				$qustion = $this->db->query("SELECT * FROM `production_conversation` WHERE `order_id`='".$order_id."' order by `id` desc")->result_array(); 
				
				  if(!isset($qustion[0]['id'])){
					echo '<p class="text-center">'."No Conversations".'</p>';
				}  
				if($qustion) { $i=0; foreach($qustion as $qustion1) { $i++; 
							
			?>
				<!--TL_designer MESSAGE-->
				<?php if(($qustion1['tl_id']!='0') && ($qustion1['operation']=='tl_designer')){ 
							$tl = $this->db->query("SELECT * FROM `team_lead` WHERE `id`='".$qustion1['tl_id']."'")->result_array(); 
				?>
					<div <?php if($i=='1'){ echo'class="note note-danger"'; }else{ echo 'class="note note-grey"'; } ?>>
						<div class="row">
							<div class="col-sm-6">
								<?php echo $qustion1['message']; ?>
								<?php
									if(isset($tl_path)){ 
										$map = glob($tl_path.'/*.{jpg,png,tiff,gif,html,pdf,indd}',GLOB_BRACE);								
										if($map){			
											foreach($map as $row) {  
										?>
								<p class="margin-top-10"> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
								<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a></p>
								<?php } } } ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php   echo $tl[0]['first_name']; ?> (Team Lead) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
					<!--TL_designer MESSAGE-->
					
					<?php } else { ?>
					
			<!--designer_TL_designer MESSAGE-->
				<?php if(($qustion1['tl_designer_id']!='0') && ($qustion1['operation']=='tl_designer')){ 
							$tl_designer_id = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$qustion1['tl_designer_id']."'")->result_array(); 
				?>
					<div <?php if($i=='1'){ echo'class="note note-danger"'; }else{ echo 'class="note note-grey"'; } ?>>
						<div class="row">
							<div class="col-sm-6">
								<?php echo $qustion1['message']; ?>
								<?php
									if(isset($tl_path)){ 
										$map = glob($tl_path.'/*.{jpg,png,tiff,gif,html,pdf,indd}',GLOB_BRACE);								
										if($map){			
											foreach($map as $row) {  
										?>
								<p class="margin-top-10"> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
								<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a></p>
								<?php } } } ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php   echo $tl_designer_id[0]['name']; ?> (D Team Lead) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
				<?php } } ?>
			<!--designer_TL_designer MESSAGE-->
						
			<!--QA to designer MESSAGE-->
					<?php if(($qustion1['csr_id']!='0') && ($qustion1['operation']=='QA_designer')) { 
								$csr = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$qustion1['csr_id']."'")->result_array();   
					?>
					<div <?php if($i=='1'){ echo'class="note note-info"'; }else{ echo 'class="note note-grey"'; } ?>>
					
						<div class="row">
							<div class="col-sm-6">
							<?php echo $qustion1['message']; ?>
							<?php if(isset($csr_path)){ 
										$map = glob($csr_path.'/*.{jpg,png,gif,tiff,html,pdf,indd}',GLOB_BRACE);								
										if($map){			
											foreach($map as $row) {  
								?>
								 <p class="margin-top-10"> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
								<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a></p>
							<?php } } } ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php  echo $csr[0]['name'];  ?> (CSR) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
			<!--QA to designer MESSAGE-->
					
			<!--DC to designer MESSAGE-->
				<?php } if(($qustion1['dc_id']!='0') && ($qustion1['operation']=='DC_designer')) { $csr = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$qustion1['dc_id']."'")->result_array();   ?>		
					
					<div <?php if($i=='1'){ echo'class="note note-success"'; }else{ echo 'class="note note-grey"'; } ?>>
						<div class="row">
							<div class="col-sm-6">
								<?php echo $qustion1['message']; ?>
								<?php if(isset($dc_csr_path)){ 
								$map = glob($dc_csr_path.'/*.{jpg,png,gif,html,tiff,pdf,indd}',GLOB_BRACE);								
								if($map){			
									foreach($map as $row){  
								?>
								<p class="margin-top-10"> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
								<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a>
								</p>
								<?php } } } ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php  echo $csr[0]['name'];  ?> (CSR) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
			<!--DC to designer MESSAGE-->
					
			<!--designer msg-->
			<?php }  if($qustion1['designer_id']!='0') { $designer = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$qustion1['designer_id']."'")->result_array();   ?>		
					<div <?php if($i=='1'){ echo'class="note note-danger"'; }else{ echo 'class="note note-grey"'; } ?>>
						
						<div class="row">
							<div class="col-sm-6"><?php echo $qustion1['message']; ?></div>
							<div class="col-sm-6 text-right">
							<h4><?php echo $designer[0]['name'] ;?> (Designer)</h4>
								<span class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </span>
							</div>
						</div>
					</div>
					<?php } ?>
			<!--designer mesg-->
				
			<!--TL to QA-->
			<?php if(($qustion1['tl_id']!='0') && ($qustion1['operation']=='tl_QA')) { $tl = $this->db->query("SELECT * FROM `team_lead` WHERE `id`='".$qustion1['tl_id']."'")->result_array();   ?>
					<div <?php if($i=='1'){ echo'class="note note-info"'; }else{ echo 'class="note note-grey"'; } ?>>
						
						<div class="row">
							<div class="col-sm-6">
								<?php echo $qustion1['message']; ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php  echo $tl[0]['first_name'];  ?> (Team Lead) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
			<?php } else { ?>
			<!--TL to QA -->
			
			<!--designer_TL to QA-->
			<?php if(($qustion1['tl_designer_id']!='0') && ($qustion1['operation']=='tl_QA')) { $tl_designer_id = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$qustion1['tl_designer_id']."'")->result_array();   ?>
					<div <?php if($i=='1'){ echo'class="note note-info"'; }else{ echo 'class="note note-grey"'; } ?>>
						
						<div class="row">
							<div class="col-sm-6">
								<?php echo $qustion1['message']; ?>
							</div>
							<div class="col-sm-6 text-right">
								<h4><?php  echo $tl_designer_id[0]['name'];  ?> (D Team Lead) </h4>
								<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
							</div>
						</div>
					</div>
			<?php } } ?>
			<!--designer_TL to QA -->
			
			<!--TL to DC -->
			<?php if(($qustion1['tl_id']!='0') && ($qustion1['operation']=='tl_DC')) { $tl = $this->db->query("SELECT * FROM `team_lead` WHERE `id`='".$qustion1['tl_id']."'")->result_array();   ?>
					<div <?php if($i=='1'){ echo'class="note note-success"'; }else{ echo 'class="note note-grey"'; } ?>>
						<div class="row">
							<div class="col-sm-6"><?php echo $qustion1['message']; ?></div>
							<div class="col-sm-6 text-right">
							<h4><?php  echo $tl[0]['first_name'];  ?> (D Team Lead) </h4>
								<span class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </span>
							</div>
						</div>
					</div>
			<!--TL to DC-->
			<?php } else { ?>
			<!--designer_TL to DC -->
			<?php if(($qustion1['tl_designer_id']!='0') && ($qustion1['operation']=='tl_DC')) { $tl_designer_id = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$qustion1['tl_designer_id']."'")->result_array();   ?>
					<div <?php if($i=='1'){ echo'class="note note-success"'; }else{ echo 'class="note note-grey"'; } ?>>
						<div class="row">
							<div class="col-sm-6"><?php echo $qustion1['message']; ?></div>
							<div class="col-sm-6 text-right">
							<h4><?php  echo $tl_designer_id[0]['name'];  ?> (D Team Lead) </h4>
								<span class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </span>
							</div>
						</div>
					</div>
			<?php } } ?>	
			<!--designer_TL to DC--> 
			
				
			<!--QA to DC-->
			<?php if(($qustion1['csr_id']!='0') && ($qustion1['operation']=='QA_DC')) { $csr = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$qustion1['csr_id']."'")->result_array();   ?>
					<div <?php if($i=='1'){ echo'class="note note-danger"'; }else{ echo 'class="note note-grey"'; } ?>>
						
						<div class="row">
							<div class="col-sm-6"><?php echo $qustion1['message']; ?></div>
							<div class="col-sm-6 text-right">
							<h4><?php  echo $csr[0]['name'];  ?> (CSR) </h4>
								<span class="font-grey-cascade"><?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </span>
							</div>
						</div>
					</div>
			<!--QA to DC-->	
			<?php } } } ?>
			</div>	
			</div>
		</div>
	</div>
	</div>
</div>
		
<?php } ?>
<!--pro status 6,7,8 Ends-->

<!-------------------------------------------New Ad Ends-------------------------------------------------->


<!--------------------------------------Revision Starts--------------------------------------------------->

<?php $i=0; if(isset($rev_orders)) { foreach($rev_orders as $rev_row){ $i++;
if($rev_row['csr']!=0){
		$csr = $this->db->get_where('csr',array('id'=>$rev_row['csr']))->result_array();
		$csr_name = $csr[0]['name'];
	}
if($rev_row['designer']!=0){
	$designer = $this->db->get_where('designers',array('id'=>$rev_row['designer']))->result_array();
	$designer_name = $designer[0]['name'];
	$designer_code = $designer[0]['username'];
	}
if($rev_row['frontline_csr']!=0){
	$csr = $this->db->get_where('csr',array('id'=>$rev_row['frontline_csr']))->result_array();
	$frontline_csr_name = $csr[0]['name'];
	}
?>
<!--Rev_orderview status 1,2,3 Starts-->
<?php if($rev_row['pdf_path']=='none' && $rev_row['status']=='2' || $rev_row['status']=='1' || $rev_row['status']=='3'){ ?>
			<div class="row margin-top-20">			
				<div class="col-md-12">							
					<div class="portlet light margin-0">
						<div class="portlet-titl no-space margin-top-10 margin-bottom-10">
							<div class="row static-info">
								<div class="col-sm-4 value ">AdwitAds ID: <?php echo $order_id; ?><small class="font-grey-cascade"> &nbsp; 
								(<?php $date = strtotime($orders[0]['created_on']); echo date('d F', $date).','.date('Y', $date).' '.'at'.' '.date('g:i A', $date);?>)</small>
							</div>
								<div class="col-sm-4">
								<?php echo $this->session->flashdata('message'); ?>
								</div>
								<div class="col-sm-4 text-right">
									<div class="tools">
									<?php if($cat[0]['ftp_source_path'] != 'none' && $cat[0]['ftp_source_path'] !=''){ ?>
										<div class="col-md-4 col-sm-6 no-space margin-bottom-5">
											<a href="<?php echo $cat[0]['ftp_source_path']; ?>" class="btn grey btn-sm  btn-block">Package</a>
										</div>
									<?php } ?>
										<button onclick="goBack()" class="btn btn-default btn-xs">← Back</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		
			<div class="row margin-top-20 margin-bottom-20">			
				<div class="col-md-12">							
					<div class="portlet light margin-0">
						<div class="portlet-title">
						<div class="row static-info">
							<div class="col-md-6 col-sm-6 value margin-top-10"><?php echo $rev_row['version']; ?>&nbsp;
								<a class="popovers margin-right-10" data-trigger="hover" data-container="body" data-placement="top"
								data-content="Designed by : <?php if(isset($designer_name)) { echo $designer_name;} else { echo " ";}?><br/>
											  Received by: <?php if(isset($csr_name)) { echo $csr_name;} else { echo " ";}?> <br />
											 "
								data-html="true" data-placement="bottom"><i class="fa  fa-info-circle"></i>
								</a>
							</div>
							<div class="col-md-6 col-sm-12 value margin-top-10 padding-left-0 text-right">
							<!--Downloads-->
								<?php if($rev_row['file_path'] != 'none' && file_exists($rev_row['file_path'])){
										$filepath = $rev_row['file_path']; ?>
									<div class="col-md-3 col-sm-3 col-xs-6 pull-right margin-bottom-5">
										<form method="post" action="<?php echo base_url().index_page().'new_csr/home/zip_folder';?>">
											<input name="file_path" value="<?php echo $filepath; ?>" readonly style="display:none" />
											<input name="file_name" value="<?php echo $rev_row['order_id']; ?>" readonly style="display:none" />
											<button type="submit" type="submit" name="Submit" class="btn btn-default btn-sm btn-block">Downloads</button>
										</form>
									</div>
								<?php } ?>
							<!--Downloads-->
								
							<!--Status Starts--->
								<div class="col-md-3 col-sm-3 col-xs-6 pull-right margin-bottom-10 padding-left-0 text-left">
									<?php if( $rev_row['status']!='0'){ 
									$rev_status = $this->db->query("SELECT * FROM `rev_order_status` WHERE `id` = '".$rev_row['status']."'")->result_array();?>
									<span class="no-space font-green font-sm"><?php echo $rev_status[0]['name']; ?></span>
									<p class="no-space font-green font-sm">
									<?php if($rev_row['question']=='1'){ 						
											echo "Question Sent";								
										}elseif($rev_row['question']=='2'){				
											echo "Question Answered";					
										} ?>
									</p>
									<?php } else { echo " "; }?>
								</div>
							<!--status Ends-->
							
							<!--Question tooltip Starts-->
								<div class="col-md-1 col-sm-2 col-xs-6 pull-right padding-left-0 margin-bottom-10">
									<?php if($rev_row['question']!='1'){ ?>
									<span class="btn btn-xs margin-right-10 tooltips font-grey-cascade" id="show_help" data-container="body" data-placement="top" data-original-title="Question to AdRep">
										<i class="fa fa-question font-lg"></i>
									</span>
									<?php } ?>
								</div>
							<!--Question tooltip Ends-->
							</div>
						</div>
					</div>
						<div class="portlet-body">
							<div class="row">
								<div class="col-md-6 col-sm-12">
									<div class="portlet blue-hoki box">
										<div class="portlet-title">
											<div class="caption font-lg">Instructions</div>
										</div>
										<div class="portlet-body">
											<div class="row static-info margin-top-20 margin-bottom-20">
												<div class="col-md-12 name"><?php $rev_row['note'] = str_replace(PHP_EOL,'<br/>', $rev_row['note']); 
													echo $rev_row['note'];?>
												</div>
											</div>
										</div>
									</div>
									<!-- Additional Instructions -->
									<?php
                                        $additional_instruction = $this->db->query("SELECT * FROM `orders_additional_instruction` WHERE `revision_id` = '".$rev_row['id']."'")->result_array();
                    					if(isset($additional_instruction[0]['id'])){
                    				?>
                    					<div class="portlet blue-hoki box">
    										<div class="portlet-title">
    											<div class="caption font-lg">Additional Instructions</div>
    										</div>
    										<div class="portlet-body">
    											<div class="row static-info margin-top-20 margin-bottom-20">
    												<div class="col-md-12 name">
    												    <?php
                                						    foreach($additional_instruction as $instruction){
                                						        echo nl2br($instruction['instructions']).'<br/>';     
                                						    } 
                                					    ?>
    												</div>
    											</div>
    										</div>
    									</div>
									<?php } ?>
                    					
									<!-----------SIT Revision----------->
                                    <div class="portlet blue-hoki box">
                                        <div class="portlet-title">
                                            <div class="caption font-lg">Simplify Instruction</div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="row static-info" style="margin: 0px">
                                                <?php 
                                                    $sit_file_path = 'SIT_notes/'.$order_id.'-'.$rev_row['id'].'.txt';  
                                                     if(file_exists($sit_file_path) && filesize($sit_file_path)){ 
                                                 ?> 
                                                    <div class="scroller" style="height:auto" data-always-visible="1" data-rail-visible="0">
                            						      <?php echo nl2br(file_get_contents( $sit_file_path )); ?>
                            						 </div>
                            				        
                            					<?php }else{ ?> 
                                                    <form method="post" action="<?php echo base_url().index_page().'new_csr/home/sit/'.$order_id; ?>">
                                                        <textarea row="10" cols="64" class="form-control" name="custom_notes" placeholder="Instructions...."></textarea>
                                                        <input type="hidden" value="<?php echo $rev_row['id'] ?>" name="revision_id">
                                                        <button type="submit" class="btn btn-primary btn-xs margin-top-10">Simplify Instruction</button>
                                                   </form>
                                                 <?php } ?>
                                            </div> 
                                        </div>
                                    </div>
                                  <!-----------SIT END----------->
								</div>
							
							<div class="col-md-6 margin-bottom-5">
							<!--Question To Adrep starts-->
									<div class=" portlet-tabs" id="help">
										<ul class="nav nav-tabs">
											<?php if($rev_row['question']!='1'){ ?>
											<li class="active"><a href="#portlet_tab1" data-toggle="tab">Send Question</a></li><?php } ?>
											<!--<li><a href="#portlet_tab2" data-toggle="tab">Order Cancel Request</a></li>-->
										</ul>
										<div class="tab-content">
											<div class="tab-pane active" id="portlet_tab1">
												<div class="text-right">
													<select name="frontline_question_template" id="frontline_question_template" class="form-control">
														<option value="">SELECT</option>
														<?php
															$question_template = $this->db->query("SELECT * FROM `question_template`")->result_array();
															foreach($question_template as $template){
														?>
														<option value="<?php echo $template['message']; ?>"><?php echo $template['name']; ?></option>
														<?php
															}
														?>
													</select><br/>
													<form action="<?php echo base_url().index_page().'new_csr/home/frontline_question/'.$hd.'/'.$rev_row['id'];?>" method="post" >
														<textarea name="question" id="frontline_question_message" rows="2" class="form-control" placeholder="Send Question...."></textarea>
														<?php if(isset($redirect)){ ?>
															<input type="text" name="redirect" id="redirect" value="<?php echo $redirect; ?>"  readonly style="display:none" />
															<?php } ?>
														<button type="submit" name="question_submit" class="btn btn-sm red-thunderbird margin-top-10 margin-bottom-15">Send <i class="fa fa-send"></i></button>
													</form>
												</div>
											</div>	
											<div class="tab-pane" id="portlet_tab2">
												<div class="form-actions">
													<label class="margin-right-10 font-grey-gallery">
														<input type="radio" name="order_cancel"> Duplicate Order
													</label>
													<label class="margin-right-10 font-grey-gallery">
														<input type="radio" name="order_cancel"> Cancel Request via email by adrep
													</label>
													<label class="margin-right-10 font-grey-gallery">
														<input type="radio" id="show_cancel_request" name="order_cancel"> Others
													</label>
												</div>
													
													<textarea id="cancel_request" rows="2" class="form-control margin-top-10" placeholder="Order Cancel Request...."></textarea>
													<div class="text-right">
														<button type="" class="btn btn-sm red-thunderbird margin-top-10 margin-bottom-15">Send <i class="fa fa-send"></i></button>
													</div>
											</div>	
										</div>
									</div>
							<!--Question To Adrep ends-->
								
							<!--Attachments-->
							<div class="portlet blue-hoki box">
								<div class="portlet-title">
									<div class="caption font-lg">Downloads</div>
									<div class="actions"><i class="fa fa-link" id="attach"></i></div>
								</div>
								<div class="portlet-body">
								<?php 
									if($rev_row['file_path'] != 'none'){  
										$filepath = $rev_row['file_path'];
										$this->load->helper('directory');
										$map = glob($filepath.'/*',GLOB_BRACE);
										if($map) { ?>
										<div class="margin-bottom-10">
											<div class="scroller" style="height:80px" data-always-visible="1" data-rail-visible="0">
												<div class="table-scrollable table-scrollable-borderless margin-0">
													<table class="table table-light table-striped  table-hover" id="mytable">
														<tbody>
													<?php 
														$i=0;  
														foreach($map as $row1){ $i++;
														    if(is_dir($row1)){
														       $map2 = glob($row1.'/*',GLOB_BRACE);
														       foreach($map2 as $row2){ $row1 = $row2; }
														    }
													?>
															<tr>
																<td class="small"><?php echo $i;?></td>                                     
																<td><?php echo basename($row1) ?></td>
																<td>
																	<a href="<?php echo base_url().$row1; ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
																	<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row1; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a>
																</td>
															</tr>
														<?php } ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
										<?php } } ?>	
									<div class="row no-space margin-bottom-10" id="show_attach" style="display: block;">
										<form class="dropzone border-dashed" action="<?php echo base_url().index_page().'new_csr/home/rev_attach_file/'.$rev_row['id'];?>" method="post" enctype="multipart/form-data">
											<div class="dz-default dz-message margin-top-20">
											<?php if(isset($redirect)){ ?>
											<input type="text" name="redirect" id="redirect" value="<?php echo $redirect; ?>"  readonly style="display:none" />
											<?php } ?>
											<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="pickup">
												<span><strong>Drag files</strong> or click to upload</span>
											</div>
										</form>
									</div>
								</div>
							</div>	
							<!--Attachments-->
								
							<!--Qstn and Answer Starts-->
									<?php $question = 	$this->db->query("SELECT * FROM `orders_Q_A` WHERE `rev_id` = '".$rev_row['id']."' ORDER BY `id` DESC")->result_array(); 
										if($question) { ?>
									<div class="margin-bottom-15">
									<div class="scroller" style="height:150px" data-always-visible="1" data-rail-visible="0">
										<?php foreach($question as $Qrow){ 
											$Qcsr_name = 	$this->db->get_where('csr',array('id' => $Qrow['csr']))->result_array();
											$adreps = 	$this->db->get_where('adreps',array('id' => $Qrow['adrep']))->result_array();
											$Acsr_name = 	$this->db->get_where('csr',array('id' => $Qrow['Acsr']))->result_array(); ?>
										<div class="note note-danger margin-bottom-5">
											<div class="row">
												<div class="col-sm-6">
													<p><?php echo $Qrow['question']; ?> </p>
													<?php if($Qrow['answer']==''){  ?>
													<a id="show_ans"><i class="fa fa-pencil font-grey-gallery"></i> <small> Click to Answer</small></a>
													<?php } ?>
													<?php if($Qrow['answer']==''){  ?>
													<div id="ans">
													<form  method="POST" action="<?php echo base_url().index_page().'new_csr/home/frontline_answer/'.$rev_row['id'];?>" role="form" enctype="multipart/form-data">
														<textarea name="answer" rows="1" class="form-control"></textarea>
														<input type="file" name="ufile[]" class="margin-top-10 margin-bottom-5" />
														<?php if(isset($redirect)){ ?>
														<input type="text" name="redirect" id="redirect" value="<?php echo $redirect; ?>"  readonly style="display:none" />
														<?php } ?>
														<input type="text" name="qid" id="qid" value="<?php echo $Qrow['id']; ?>"  readonly style="display:none" />
														<button type="Submit" name="sent_designer" class="btn btn-xs btn-primary margin-top-5">Send</button>
													</form>
													</div>
													<?php } ?>
												</div>
												<div class="col-sm-6 text-right">
													<h4><?php echo $Qcsr_name[0]['name']; ?></h4>
													<span class="font-grey-cascade small"> at - <?php $date = date_create($Qrow['Qtimestamp']); echo date_format($date, 'g:i A \o\n l jS M Y'); ?> </span>
												</div>
											</div>
										</div>
										<?php if(isset($adreps[0]['first_name'])) { ?>
										<div class="note light-grey margin-bottom-5">
											<div class="row">
												<div class="col-sm-6">
													<?php echo $Qrow['answer']; ?>
												</div>
												<div class="col-sm-6 text-right">
													<h4><?php echo $adreps[0]['first_name'] ?></h4>
													<span class="font-grey-cascade small"> at - <?php $date = date_create($Qrow['Atimestamp']); echo date_format($date, 'g:i A \o\n l jS M Y'); ?> </span>
												</div>
											</div>
										</div>
										<?php }elseif(isset($Acsr_name[0]['name'])){ ?>
										<div class="note light-grey margin-bottom-5">
											<div class="row">
												<div class="col-sm-6">
													<?php echo $Qrow['answer']; ?>
												</div>
												<div class="col-sm-6 text-right">
													<h4><?php echo $Acsr_name[0]['name'] ?></h4>
													<span class="font-grey-cascade small"> at - <?php $date = date_create($Qrow['Atimestamp']); echo date_format($date, 'g:i A \o\n l jS M Y'); ?></span>
												</div>
											</div>
										</div>
									<?php } } ?>
									 </div>
									</div>
									<?php } ?>
							<!--Qstn and Answer Ends-->
								
							<!--Conversation Starts-->
								<div class="portlet blue-hoki box">
									<div class="portlet-title">
										<div class="caption font-lg">Conversations</div>
									</div>
									<div class="portlet-body">
										<div class="scroller" style="height:150px" data-always-visible="1" data-rail-visible="0">
											<?php $qustion = $this->db->query("SELECT * FROM `production_conversation` WHERE `revision_id`='".$rev_row['id']."' order by `id` desc")->result_array(); 
												if(!isset($qustion[0]['id'])){
													echo '<p class="text-center">'."No Conversations".'</p>';
												}  
												if($qustion) { $i=0; foreach($qustion as $qustion1) { $i++; ?>
											<!--designer to CSR MESSAGE-->
										<?php if(($qustion1['designer_id']!='0') && ($qustion1['operation']=='revdesigner_QA')){ 
													$designer = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$qustion1['designer_id']."'")->result_array(); 
										?>
											<div <?php if($i=='1'){ echo'class="note note-danger"'; }else{ echo 'class="note note-grey"'; } ?>>
												<div class="row">
													<div class="col-sm-8">
														<p><?php echo $qustion1['message']; ?></p>
													</div>
													<div class="col-sm-4 text-right">
														<h4><?php  echo $designer[0]['name'];  ?> (Designer)</h4>
														<span class="font-grey-cascade small"><?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?>  </span>
													</div>
												</div>
											</div> 
											<!--designer to CSR MESSAGE-->
											
											
											<!--QA to designer MESSAGE-->
										<?php } if(($qustion1['csr_id']!='0') && ($qustion1['operation']=='revcsr_designer')){ 
													$csr = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$qustion1['csr_id']."'")->result_array(); ?>
											<div <?php if($i=='1'){ echo'class="note note-danger"'; }else{ echo 'class="note note-grey"'; } ?>>
												<div class="row">
													<div class="col-sm-8">
														<p><?php echo $qustion1['message']; ?></p>
														<?php
															if(isset($rev_csr_path)){ 
																$map = glob($rev_csr_path.'/*.{jpg,png,tiff,gif,html,pdf,indd}',GLOB_BRACE);								
																if($map){			
																	foreach($map as $row) {  
																?>
														<p class="margin-top-10"> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
														<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a></p>
														<?php } } } ?>
													</div>
													<div class="col-sm-4 text-right">
														<h4><?php  echo $csr[0]['name'];  ?> (CSR)</h4>
														<span class="font-grey-cascade small"><?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?>  </span>
													</div>
												</div> 
											</div>
											<!--QA to designer MESSAGE-->
										<?php } } } ?>
										</div>
									</div>
								</div>
							<!--Conversation Ends-->
							</div>
							
							<!--Submit Revision starts-->
								<?php if($rev_row['status']!='5' && $rev_row['job_accept']=='0'){ ?>	
									<!--<div class="col-md-12 margin-bottom-5">
										<div class="form-group no-margin">
											<div class="form-body flat-radio">
												<div class="form-section">
													<form method="post">
													<label>Choose One Option</label><br>
													<div class="btn-group" data-toggle="buttons">
														<?php foreach($rev_reason as $row){ ?>
															<label class="btn grey btn-sm margin-right-10 margin-bottom-5"> <input type="radio" name="reason_option" id="reason_option" value="<?php echo $row['id']; ?>" required="required"><?php echo $row['name'];?></label>
														<?php } ?>
													 </div>
												</div>
											</div>														
										</div> 
									</div>-->
							
									<div class="col-md-12 text-right">
									<form method="post" id="form_rev_classification">
										<hr class="margin-top-5">
										<span class="margin-right-10 font-grey-cascade">
											
											<label><small><input type="checkbox" name="rush" id="rush" value="1">Rush</small></label>
										</span>
										<span class="form-group no-margin">
											 <span class="form-body flat-radio">										
												<div class="btn-group" data-toggle="buttons">
												<?php foreach($rev_reason as $row){ ?>
													<label class="btn grey btn-sm margin-right-10 margin-bottom-5 reason_option" data-id="<?php echo $row['id']; ?>"> 
													    <input type="radio" name="reason_option" id="reason_option" value="<?php echo $row['id']; ?>" required="required"><?php echo $row['name'];?>
													</label>
												<?php } ?>
												</div>										
											</span>														
										</span>
										<input type="text" id="rev_id" name="rev_id" value="<?php echo $rev_row['id']; ?>" readonly  style="display:none;" />
										<div id="confirmation_div"></div>
										<button type="submit" name="accept" class="btn btn-sm btn-primary">Accept</button>
									</form>
									</div>
								<?php } ?>
							<!--Submit Revision ends-->
							</div>
						</div>
					</div>	
				</div>
			</div>
<?php } ?>
<!--Rev_orderview Status 1,2,3 Ends-->

<!--Rev_orderview status 4,7 Stars-->
<?php if($rev_row['pdf_path']=='none' && ($rev_row['status']=='4' || $rev_row['status']=='7') && $rev_row['new_slug']!='none' && $rev_row['source_file']!='none'){ ?>
		<div class="row margin-top-20">			
			<div class="col-md-12">							
				<div class="portlet light margin-0">
					<div class="portlet-titl no-space margin-top-10 margin-bottom-10">
						<div class="row static-info">
							<div class="col-sm-6 value ">AdwitAds ID: <?php echo $order_id; ?><small class="font-grey-cascade"> &nbsp; 
								(<?php $date = strtotime($orders[0]['created_on']); echo date('d F', $date).','.date('Y', $date).' '.'at'.' '.date('g:i A', $date);?>)</small>
								</div>
							<div class="col-sm-6 text-right">
								<div class="tools">
								<?php if($cat[0]['ftp_source_path'] != 'none' && $cat[0]['ftp_source_path'] !=''){ ?>
										<div class="col-md-4 col-sm-6 no-space margin-bottom-5">
											<a href="<?php echo $cat[0]['ftp_source_path']; ?>" class="btn grey btn-sm  btn-block">Package</a>
										</div>
									<?php } ?>
									<button onclick="goBack()" class="btn btn-default btn-xs">← Back</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row margin-top-20 margin-bottom-20">			
			<div class="col-md-12">							
				<div class="portlet light margin-0">
					<div class="portlet-title">
						<div class="row static-info">
							<div class="col-md-6 col-sm-6 value margin-top-10"><?php echo $rev_row['version']; ?>&nbsp;
								<a class="popovers margin-right-10" data-trigger="hover" data-container="body" data-placement="top"
								data-content="Designed by : <?php if(isset($designer_name)) { echo $designer_name;} else { echo " ";}?><br/>
											  Received by: <?php if(isset($csr_name)) { echo $csr_name;} else { echo " ";}?> <br />
											  "
								data-html="true" data-placement="bottom"><i class="fa  fa-info-circle"></i>
								</a>
							</div>
							<div class="col-md-6 col-sm-12 value bold margin-top-10 padding-left-0 text-right">
								<?php 
									if(isset($sourcefile)){
										$source_file = $rev_row['source_file'];
										$map2 = $sourcefile.'/'.$source_file;
										$pdf_path = $sourcefile.'/'.$rev_row['pdf_file']; 
										if((isset($orders_multiple_size[0]['id']) || isset($orders_multiple_custom_size[0]['id'])) && $orders[0]['ad_format']!='5'){
										}else{
								?>
								<!--PDF-->
								
									<div class="col-md-2 col-sm-3 col-xs-6 pull-right padding-left-0 margin-bottom-5">
										<a class="btn btn-default btn-sm btn-block" href="<?php echo base_url().$pdf_path; ?>" target="_blank">PDF</a>
									</div>
								<!--PDF-->
								    <?php } ?>
									
								<!--Package-->
								<?php 
								     if((isset($orders_multiple_size[0]['id']) || isset($orders_multiple_custom_size[0]['id'])) && $orders[0]['ad_format']!='5'){
								         //$map2 = glob($sourcefile.'/'.$rev_row['new_slug'].'.{zip}',GLOB_BRACE) ; 
    							        //if($map2){ 
    							 ?>
    							        <div class="col-md-2 col-sm-2 col-xs-6 pull-right padding-left-0 margin-bottom-5">
    							        <form action="<?php echo base_url().'index.php/new_csr/home/multiple_zip_folder_select/'.$order_id ; ?>" method="post">
        							        <input name="new_slug" value="<?php echo $rev_row['new_slug'];?>" readonly style="display:none;" />
        								    <input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
        								    <input name="download" value="download" readonly style="display:none;" />
        								    <button type="submit" name="SourceDownload" class="btn btn-default btn-sm">Package</button>
        							    </form>
        							    </div
    							 <?php
    							        //}
								     }else{
								        if(file_exists($map2)) { 
								?>
									<div class="col-md-2 col-sm-2 col-xs-6 pull-right padding-left-0 margin-bottom-5">
										<form action="<?php echo base_url().'index.php/new_csr/home/zip_folder_select'?>" method="post">
											<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
											<input name="pdf_file" value="<?php echo $rev_row['pdf_file'];?>" readonly style="display:none;" />
											<input name="new_slug" value="<?php echo $rev_row['new_slug'];?>" readonly style="display:none;" />
											<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
											<input name="download" value="download" readonly style="display:none;" />
											<button type="submit" name="SourceDownload" class="btn btn-default btn-sm  btn-block">Package</button>
										</form>
									</div> 
								<?php 
								        } 
									}
								?>
								<!--Package-->
									
								<!--Downloads-->	
							    <?php
								    if($rev_row['file_path'] != 'none') { 
								        $rev_order_form = $rev_row['file_path'];
									    if(isset($rev_order_form) && file_exists($rev_order_form)) { 
											$rev_map = glob($rev_order_form.'/*',GLOB_BRACE);
											if($rev_map){ 
								?>
									<div class="col-md-3 col-sm-3 col-xs-6 pull-right padding-left-0 margin-bottom-5">
										<form method="post" action="<?php echo base_url().index_page().'new_csr/home/zip_folder';?>">
											<input name="file_path" value="<?php echo $rev_order_form; ?>" readonly style="display:none;" /> 
											<input name="file_name" value="<?php echo $order_id; ?>" readonly style="display:none;" />
											<button type="submit" name="Submit" class="btn btn-default btn-sm btn-block">Download</button>
										</form>
									</div>
									<?php } } } ?>
									<?php }elseif($cat[0]['ftp_source_path'] != 'none' || $cat[0]['ftp_source_path'] != '') { echo " "; } ?>
								<!--Downloads-->
									
								<!--Status Starts-->
								<div class="col-md-4 col-sm-4 col-xs-6 padding-left-0 pull-right margin-bottom-5 text-left">
									<?php if( $rev_row['status']!='0'){ 
									$rev_status = $this->db->query("SELECT * FROM `rev_order_status` WHERE `id` = '".$rev_row['status']."'")->result_array();?>
									<span class="no-space font-green font-sm"><?php echo $rev_status[0]['name']; ?></span>
									<p class="no-space font-green font-sm">
									<?php if($rev_row['question']=='1'){ 						
											echo "Question Sent";								
										}elseif($rev_row['question']=='2'){				
											echo "Question Answered";					
										} ?>
									</p>
									<?php } else { echo " "; }?>
								</div>
								<!--Status Ends-->
								
								<!--Question tooltip-->
								<div class="col-md-1 col-sm-1 col-xs-6 padding-left-0 pull-right margin-bottom-5">
									<?php if($rev_row['question']!='1'){ ?>
										<span class="btn btn-xs margin-right-10 tooltips font-grey-cascade" id="show_help" data-container="body" data-placement="top" data-original-title="Question to AdRep">
											<i class="fa fa-question font-lg"></i>
										</span> 
									<?php } ?>
								</div>
								<!--Question tooltip-->
							</div>
						</div>
					</div>
					<div class="portlet-body">
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="portlet blue-hoki box">
									<div class="portlet-title">
										<div class="caption font-lg">Instructions</div>
									</div>
									<div class="portlet-body">
										<div class="row static-info margin-top-20 margin-bottom-20">
											<div class="col-md-12 name"><?php $rev_row['note'] = str_replace(PHP_EOL,'<br/>', $rev_row['note']); 
												echo $rev_row['note'];?>
											</div>
										</div>
									</div>
								</div>
								<!-- Additional Instructions -->
									<?php
                                        $additional_instruction = $this->db->query("SELECT * FROM `orders_additional_instruction` WHERE `revision_id` = '".$rev_row['id']."'")->result_array();
                    					if(isset($additional_instruction[0]['id'])){
                    				?>
                    					<div class="portlet blue-hoki box">
    										<div class="portlet-title">
    											<div class="caption font-lg">Additional Instructions</div>
    										</div>
    										<div class="portlet-body">
    											<div class="row static-info margin-top-20 margin-bottom-20">
    												<div class="col-md-12 name">
    												    <?php
                                						    foreach($additional_instruction as $instruction){
                                						        echo nl2br($instruction['instructions']).'<br/>';     
                                						    } 
                                					    ?>
    												</div>
    											</div>
    										</div>
    									</div>
									<?php } ?>
							<!--To adrep and To Designer Starts-->
								<?php 
								    if($rev_row['status'] != '7') { 
								        if($rev_row['frontline_csr'] == '0' || empty($rev_row['frontline_csr'])){
								?>
								    <form method="post"> 
                						<button type="submit" name="revision_proof_check" class="btn btn-default btn-sm bg-red-thunderbird">Proof Check</button>
                						<input type="text" name="revision_id" value="<?php echo $rev_row['id']; ?>" style="display:none;">
                					</form> 
					            <?php
								        }elseif($rev_row['frontline_csr'] == $this->session->userdata('sId')) { 
								?>
									<div class=" portlet-tabs">
										<ul class="nav nav-tabs">
											<li><a href="#portlet_tab5" data-toggle="tab">To Designer</a></li>
											<li class=""><a href="#portlet_tab4" class="bg-red" data-toggle="tab">To AdRep </a></li>
										</ul>
										<div class="tab-content">
											<div class="tab-pane " id="portlet_tab4">
												<form method="post" id="send_to_adrep_form">
												    <div class="col-md-6 text-left">
        												<div class="checkbox-list">
        												<?php 
        													$rev_order_reason = $this->db->query("SELECT * FROM `rev_reason`")->result_array(); 
        													foreach($rev_order_reason as $reason_row) {  
        												?>
        													<label>	
        														<input type="checkbox" id="reason_check" name="revision_reason[]" value="<?php echo $reason_row['id'];?>" > <?php echo $reason_row['name'];?> 
        														<input name="order_id" value="<?php echo $rev_row['order_id'];?>" readonly style="display:none;" />
        													</label>
        												<?php } ?>
        												</div>
        											</div>
        											
													<textarea id="note" name="note" class="form-control margin-top-15 margin-bottom-10" rows="2"></textarea>
													
													<div class="row">	
														<div class="col-sm-12 text-right margin-top-10" >
															<span class="margin-right-10">
															<input name="hd" value="<?php echo $hd; ?>" readonly style="display:none;" />
															<input name="rev_id" value="<?php echo $rev_row['id'];?>" readonly style="display:none;" />
															<input name="new_slug" value="<?php echo $rev_row['new_slug'];?>" readonly style="display:none;" />
															<input name="adrep" value="<?php echo $rev_row['adrep'];?>" readonly style="display:none;" />
															<input name="source_file" value="<?php echo $rev_row['source_file'];?>" readonly style="display:none;" />
															<input name="pdf_file" value="<?php echo $rev_row['pdf_file'];?>" readonly style="display:none;" />
															<input name="source_path" value="<?php if(isset($sourcefile)) { echo $sourcefile;}?>" readonly style="display:none;" />
															<input name="archive" value="archive" readonly style="display:none;" />
															<input name="cat_slug" value="<?php echo $cat[0]['slug'];?>" readonly style="display:none;" />
															<input name="order_id" value="<?php echo $order_id;?>" readonly style="display:none;" />
															<input  id="show_note"  type="checkbox" value="note">Note
															<input  name="sendToadrep" style="display:none;" type="text">
															</span>
															<button type="button" class="btn red-thunderbird" onclick="sendToAdrepmodal()">Send to AdRep </button>
															<!--<button type="submit" name="sendToadrep" id="focusdiv" class="btn red-thunderbird" onclick="return Adp_confirm();">Send to AdRep </button>-->
														</div>
													</div>
												</form>
											</div>	
											<div class="tab-pane " id="portlet_tab5">
											    <?php if($csr_alias[0]['pdf_review_tool'] == '1' && $orders[0]['order_type_id'] == '2'){ ?>
                            							<a href="#full" data-toggle="modal" type="button" class="btn btn-default btn-sm pull-right">PDF Review</a>   
                            					<?php } ?>
												<form method="POST" role="form" enctype="multipart/form-data">
													<div class="form-body">
														<div class="form-group margin-bottom-10">
															<div class="scroller" style="height:110px; width:300px" data-always-visible="1" data-rail-visible="0">
																<div class="input-group">
																	<div class="icheck-list" onSelect="clickMeId">
																		<?php //$results = $results = $this->db->get('note_teamlead_designer')->result_array();
																	foreach($note_csr_designer as $result){ ?>
																		<label>
																			<input required type="radio" id="hide_others3<?php echo $result['id']; ?>" name="msg" value="<?php echo $result['name']; ?>"> <?php echo $result['name'];?> 
																		</label>
																	<?php } ?>
																	</div>
																</div>
															</div>
														</div>
													</div>
													
												<div class="row">
												    <?php 
												        if($csr_alias[0]['pdf_review_tool'] == '1' && $orders[0]['order_type_id'] == '2'){ 
												        }else{
												    ?>	
														<div class="col-sm-6">
														<input type="hidden" name="slug_name" id="slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $rev_row['new_slug'];?>">
															<input type="file" name="file2" id="file2" class="form-control"/>
														</div>
													<?php } ?>	
														<div class="col-sm-6">
															<label><input id="show_others3" type="radio" name="msg" value="others" required> Write your own </label>
														</div>								
														<div class="col-sm-12">
															<textarea id="others3" name="csr_msg" class="form-control margin-top-10" rows="2"></textarea>
														</div>
													</div>
													<div class="row margin-top-10">	
														<div class="col-md-12 text-right">
															<input type="text" name="sourcefile" value="<?php if(isset($sourcefile)) { echo $sourcefile;}?>" style="display:none;">
															<input type="text" id="rev_id" name="rev_id" value="<?php echo $rev_row['id']; ?>" style="display:none;" />
															<input type="hidden" name="cat_slug" id="cat_slug" value="<?php echo $cat[0]['slug'];?>">
															<button type="submit" name="rev_sent_designer"	 class="btn green">Send to Designer </button>
														</div>
													</div>
												</form>
											</div>
										</div>
									</div>
								<?php }else{ 
								    $proof_csr = $this->db->query("SELECT name FROM `csr` WHERE `id` = '".$rev_row['frontline_csr']."' ")->row_array(); 
								    echo '<span class="no-space font-red font-sm">'.$proof_csr['name'].' is proofing the ad</span>'; 
								    }
								?>
								<?php } ?>
							<!--To adrep and To Designer Ends-->
							</div>
							
							<div class="col-md-6 col-sm-12">
							<!--Question To Adrep starts-->
									<div class=" portlet-tabs" id="help">
										<ul class="nav nav-tabs">
											<?php if($rev_row['question']!='1'){ ?>
											<li class="active"><a href="#portlet_tab1" data-toggle="tab">Send Question</a></li><?php } ?>
											<!--<li><a href="#portlet_tab2" data-toggle="tab">Order Cancel Request</a></li>-->
										</ul>
										<div class="tab-content">
											<div class="tab-pane active" id="portlet_tab1">
												<div class="text-right">
													<select name="frontline_question_template2" id="frontline_question_template2" class="form-control">
														<option value="">SELECT</option>
														<?php
															$question_template = $this->db->query("SELECT * FROM `question_template`")->result_array();
															foreach($question_template as $template){
														?>
														<option value="<?php echo $template['message']; ?>"><?php echo $template['name']; ?></option>
														<?php
															}
														?>
													</select><br/>
													<form action="<?php echo base_url().index_page().'new_csr/home/frontline_question/'.$hd.'/'.$rev_row['id'];?>" method="post" >
														<textarea name="question" id="frontline_question_message2" rows="2" class="form-control" placeholder="Send Question...."></textarea>
														<?php if(isset($redirect)){ ?>
															<input type="text" name="redirect" id="redirect" value="<?php echo $redirect; ?>"  readonly style="display:none" />
															<?php } ?>
														<button type="submit" name="question_submit" class="btn btn-sm red-thunderbird margin-top-10 margin-bottom-15">Send <i class="fa fa-send"></i></button>
													</form>
												</div>
											</div>	
											<div class="tab-pane" id="portlet_tab2">
												<div class="form-actions">
													<label class="margin-right-10 font-grey-gallery">
														<input type="radio" name="order_cancel"> Duplicate Order
													</label>
													<label class="margin-right-10 font-grey-gallery">
														<input type="radio" name="order_cancel"> Cancel Request via email by adrep
													</label>
													<label class="margin-right-10 font-grey-gallery">
														<input type="radio" id="show_cancel_request" name="order_cancel"> Others
													</label>
												</div>
													
													<textarea id="cancel_request" rows="2" class="form-control margin-top-10" placeholder="Order Cancel Request...."></textarea>
													<div class="text-right">
														<button type="" class="btn btn-sm red-thunderbird margin-top-10 margin-bottom-15">Send <i class="fa fa-send"></i></button>
													</div>
											</div>	
										</div>
									</div>
							<!--Question To Adrep ends-->
							
							
							<!--Attachments-->
							<div class="portlet blue-hoki box">
								<div class="portlet-title">
									<div class="caption font-lg">Downloads</div>
									<div class="actions"><i class="fa fa-link" id="attach"></i></div>
								</div>
								<div class="portlet-body">
									<?php if($rev_row['file_path'] != 'none'){  
										$filepath = $rev_row['file_path'];
										$this->load->helper('directory');
										$map = glob($filepath.'/*',GLOB_BRACE);
										if($map) { ?>
										<div class="margin-bottom-10">
											<div class="scroller" style="height:80px" data-always-visible="1" data-rail-visible="0">
												<div class="table-scrollable table-scrollable-borderless margin-0">
													<table class="table table-light table-striped  table-hover">
														<tbody>
														<?php $i=0;  
														    foreach($map as $row1){ $i++;
														        if(is_dir($row1)){
    														       $map2 = glob($row1.'/*',GLOB_BRACE);
    														       foreach($map2 as $row2){ $row1 = $row2; }
    														    }
													    ?>
															<tr>
																<td class="small"><?php echo $i;?></td>                                     
																<td><?php echo basename($row1) ?></td>
																<td>
																	<a href="<?php echo base_url().$row1; ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
																	<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row1; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a>
																</td>
															</tr>
														<?php } ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
										<?php } } ?>	
									<div class="row no-space margin-bottom-10" id="show_attach" style="display: block;">
										<form class="dropzone border-dashed" action="<?php echo base_url().index_page().'new_csr/home/rev_attach_file/'.$rev_row['id'];?>" method="post" enctype="multipart/form-data">
											<div class="dz-default dz-message margin-top-20">
											<?php if(isset($redirect)){ ?>
											<input type="text" name="redirect" id="redirect" value="<?php echo $redirect; ?>"  readonly style="display:none" />
											<?php } ?>
											<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="pickup">
												<span><strong>Drag files</strong> or click to upload</span>
											</div>
										</form>
									</div>
								</div>
							</div>	
							<!--Attachments-->
								
							<!--Qstn and Answer Starts-->
								<?php $question = 	$this->db->query("SELECT * FROM `orders_Q_A` WHERE `rev_id` = '".$rev_row['id']."' ORDER BY `id` DESC")->result_array(); 
											if($question) { ?>
							<div class="margin-bottom-15">
								<div class="scroller" style="height:140px" data-always-visible="1" data-rail-visible="0">
										<?php foreach($question as $Qrow){
										 $Qcsr_name = 	$this->db->get_where('csr',array('id' => $Qrow['csr']))->result_array(); 
										 $adreps = 	$this->db->get_where('adreps',array('id' => $Qrow['adrep']))->result_array(); 
										 $Acsr_name = 	$this->db->get_where('csr',array('id' => $Qrow['Acsr']))->result_array(); ?>
									<div class="note note-danger margin-bottom-5">
										<div class="row">
											<div class="col-sm-6">
												<p><?php echo $Qrow['question']; ?> </p>
												<?php if($Qrow['answer']==''){  ?>
													<a id="show_ans"><i class="fa fa-pencil font-grey-gallery"></i> <small> Click to Answer</small></a>
												<?php } ?>
												<?php if($Qrow['answer']==''){  ?>
													<div id="ans">
													<form  method="POST" action="<?php echo base_url().index_page().'new_csr/home/frontline_answer/'.$rev_row['id'];?>" role="form" enctype="multipart/form-data">
														<textarea name="answer" rows="1" class="form-control"></textarea>
														<input type="file" name="ufile[]" class="margin-top-10 margin-bottom-5" />
														<?php if(isset($redirect)){ ?>
														<input type="text" name="redirect" id="redirect" value="<?php echo $redirect; ?>"  readonly style="display:none" />
														<?php } ?>
														<input type="text" name="qid" id="qid" value="<?php echo $Qrow['id']; ?>"  readonly style="display:none" />
														<button type="Submit" class="btn btn-xs btn-primary margin-top-5">Send</button>
													</form>
													</div>
												<?php } ?>
											</div>
											<div class="col-sm-6 text-right">
												<h4><?php echo $Qcsr_name[0]['name']; ?></h4>
												<span class="font-grey-cascade small"> at - <?php $date = date_create($Qrow['Qtimestamp']); echo date_format($date, 'g:i A \o\n l jS M Y'); ?> </span>
											</div>
										</div>
									</div>
									<?php if(isset($adreps[0]['first_name'])) { ?>
									<div class="note light-grey margin-bottom-5">
										<div class="row">
											<div class="col-sm-6">
												<?php echo $Qrow['answer']; ?>
											</div>
											<div class="col-sm-6 text-right">
												<h4><?php echo $adreps[0]['first_name'] ?></h4>
												<span class="font-grey-cascade small"> at - <?php $date = date_create($Qrow['Atimestamp']); echo date_format($date, 'g:i A \o\n l jS M Y'); ?> </span>
											</div>
										</div>
									</div>
									<?php }elseif(isset($Acsr_name[0]['name'])){ ?>
									<div class="note light-grey margin-bottom-5">
										<div class="row">
											<div class="col-sm-6">
												<?php echo $Qrow['answer']; ?>
											</div>
											<div class="col-sm-6 text-right">
												<h4><?php echo $Acsr_name[0]['name'] ?></h4>
												<span class="font-grey-cascade small"> at - <?php $date = date_create($Qrow['Atimestamp']); echo date_format($date, 'g:i A \o\n l jS M Y'); ?></span>
											</div>
										</div>
									</div>
									<?php } }?>
								</div>
							</div>
							<?php } ?>
							<!--Qstn and Answer Ends-->
							
							<!--Conversation Starts-->
								<div class="portlet blue-hoki box">
									<div class="portlet-title">
										<div class="caption font-lg">Conversations</div>
									</div>
									<div class="portlet-body">
									    <div id="pdf_annotation_div">
                    				    <?php if(isset($oa_fname) && isset($oa_url)){  //pdf annotation ?>
                    						<div class="row margin-top-10 margin-bottom-10">
                    						    <div class="col-sm-12">
                    							    <span class="font-red">CSR marked PDF changes - </span>
                    							    <a href="<?php echo $oa_url; ?>" target="_Blank"><?php echo $oa_fname; ?></a>
                    							 </div>
                    					    </div>
                    				    <?php } ?>
                    				    </div>
										<div class="scroller" style="height:150px" data-always-visible="1" data-rail-visible="0">
											<?php $qustion = $this->db->query("SELECT * FROM `production_conversation` WHERE `revision_id`='".$rev_row['id']."' order by `id` desc")->result_array(); 
												if(!isset($qustion[0]['id'])){
													echo '<p class="text-center">'."No Conversations".'</p>';
												}  
												if($qustion) { $i=0; foreach($qustion as $qustion1) { $i++; ?>
											<!--designer to CSR MESSAGE-->
										<?php if(($qustion1['designer_id']!='0') && ($qustion1['operation']=='revdesigner_QA')){ 
													$designer = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$qustion1['designer_id']."'")->result_array(); 
										?>
											<div <?php if($i=='1'){ echo'class="note note-danger"'; }else{ echo 'class="note note-grey"'; } ?>>
												<div class="row">
													<div class="col-sm-8">
														<p><?php echo $qustion1['message']; ?></p>
													</div>
													<div class="col-sm-4 text-right">
														<h4><?php  echo $designer[0]['name'];  ?> (Designer)</h4>
														<span class="font-grey-cascade small"><?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?>  </span>
													</div>
												</div>
											</div>
											<!--designer to CSR MESSAGE-->
											
											
											<!--QA to designer MESSAGE-->
										<?php } if(($qustion1['csr_id']!='0') && ($qustion1['operation']=='revcsr_designer')){ 
													$csr = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$qustion1['csr_id']."'")->result_array(); ?>
											<div <?php if($i=='1'){ echo'class="note note-danger"'; }else{ echo 'class="note note-grey"'; } ?>>
												<div class="row">
													<div class="col-sm-8">
														<p><?php echo $qustion1['message']; ?></p>
														<?php
															if(isset($rev_csr_path)){ 
																$map = glob($rev_csr_path.'/*.{jpg,png,tiff,gif,html,pdf,indd}',GLOB_BRACE);								
																if($map){			
																	foreach($map as $row) {  
																?>
														<p class="margin-top-10"> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
														<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a></p>
														<?php } } } ?>
													</div>
													<div class="col-sm-4 text-right">
														<h4><?php  echo $csr[0]['name'];  ?> (CSR)</h4>
														<span class="font-grey-cascade small"><?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?>  </span>
													</div>
												</div>
											</div>
											<!--QA to designer MESSAGE-->
										<?php } } } ?>
										</div>
									</div>
								</div>
							<!--Conversation Ends-->
							</div>
						</div>	
					</div>
				</div>
			</div>	
		</div>
<?php } ?>		
<!--Rev_orderview Status 4,7 Ends-->

<!-- Rev_orderview sold status 5 Starts--->
<?php if($rev_row['status'] == '5' && $rev_row['sold_pdf'] != 'none' && $rev_row['category'] == 'sold' ){ 
		$sold_pdf_path = 'sold_pdf/'.$order_id.'/'.$cat[0]['slug'];
		if(isset($sold_pdf_path)) { 
		$map1 = $sold_pdf_path.'/'.$rev_row['sold_pdf'];
		}
		//$note_revad = $this->db->get_where('note_sent',array('order_id'=>$order_id, 'revision_id'=>$rev_row['id']))->result_array();
?>
<?php if($rev_rev[0]['id']==$rev_row['id'] && $rev_rev[0]['new_slug']!='none') { ?>
		<div class="row margin-top-20">			
			<div class="col-md-12 margin-bottom-20">							
				<div class="portlet light margin-0">
					<div class="portlet-titl no-space margin-top-10 margin-bottom-10">
						<div class="row static-info">
							<div class="col-sm-7 value ">AdwitAds ID: <?php echo $order_id; ?><?php foreach($orders as $row)?><small class="font-grey-cascade"> &nbsp; 
							(<?php $date = strtotime($row['created_on']); echo date('d F', $date).','.date('Y', $date).' '.'at'.' '.date('g:i A', $date);?>)</small>
							</div>
							
							<div class="col-sm-5 text-right">
								<div class="tools">
									<div class="row">
										<div class="col-sm-4">
											<?php if($cat[0]['ftp_source_path'] != 'none' && $cat[0]['ftp_source_path'] !=''){ ?>
											<div class="margin-bottom-5">
												<a href="<?php echo $cat[0]['ftp_source_path']; ?>" class="btn grey btn-sm  btn-block">Package</a>
											</div> 
											<?php } ?>
										</div>
										<div class="col-sm-3">
											<?php 
											$help_desk1 = $this->db->query("SELECT * FROM `help_desk` WHERE `id` = '".$row['help_desk']."' AND `sold` = '1'")->result_array();
											$orders_rev = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `id`=(SELECT MAX(`id`) FROM `rev_sold_jobs` WHERE `order_id`='".$row['id']."')")->result_array();
											$check = $this->db->get_where('rev_sold_jobs',array('order_id' => $row['id'], 'category' => 'sold'))->result_array();
											if($orders_rev)
											{
												$slug = $orders_rev[0]['new_slug'];
											}elseif($cat){
												$slug = $cat[0]['slug'];
											}
											?>
									<?php if($help_desk1 && !$check) { ?>
										<form method="post" action="<?php echo base_url().index_page().'new_csr/home/metro_sold/'.$row['help_desk'];?>">
											<input type="text" name="order_id" value="<?php echo $row['id']; ?>" style="display:none">
											<input type="text" name="order_no" value="<?php echo $slug; ?>" style="display:none">
											<button class="btn bg-blue btn-xs" type="submit" name="submit_sold" value="Submit" onclick="return sold_confirm();">Submit Sold</button>
										</form>
									<?php } ?>
										</div>
										<div class="col-sm-3 no-space">
											<button class="btn bg-blue btn-xs btn-block" id="show_subrev"> Submit Revision</button>	
										</div>	
										<div class="col-sm-2">
											<button onclick="goBack()" class="btn btn-default btn-xs">← Back</button>
										</div>									
									</div>
								</div>
								<?php echo '<h3 style="color:#900;">'.$this->session->flashdata('message2').'</h3>'; ?>
							</div>
						</div>
					</div>
					
					<!---Accept Revision --->
					<div class="portlet portlet-body margin-top-15 margin-bottom-10" id="subrev">
						<div class="row">
							<hr class="no-space">
							<form class=" margin-top-15" id="order_form" name="order_form" method="post" method="post" action="<?php echo base_url().'index.php/new_csr/home/orderview/'.$hd.'/'.$order_id ;?>" enctype="multipart/form-data">
								<div class="col-md-8">
									<div class="form-group">
										<label>Note &amp; Instructions </label> <small class="font-red">*</small>
										<textarea class="form-control margin-top-10" name="copy_content_description" rows="8" id="copy_content_description" required=""></textarea>
									</div>
								</div> 
								<div class="col-md-4">
									<div class="form-group">
										<label>Attach Files</label>
										<div class="row no-space">
										<div class="col-md-12  margin-top-10 no-space"><input type="file" name="ufile[]" id="ufile[]" accept="application/pdf"></div>
										<div class="col-md-12  margin-top-10 no-space"><input type="file" name="ufile[]" id="ufile[]" accept="application/pdf"></div>
										</div>
									</div>
								</div>   
								<div class="col-md-12 text-right">
								  <hr>
									<div class="btn-group left-dropdown">		
										<span class=" margin-right-10 font-grey-cascade">								
											<label><small><input type="checkbox" name="rush" id="rush" value="1">Rush</small></label>
										</span>	
									</div>
									<span class="form-group no-margin">
									 <span class="form-body flat-radio">										
										<div class="btn-group" data-toggle="buttons">
										<?php foreach($rev_reason as $row){ ?>
											<label class="btn grey btn-sm margin-right-10 margin-bottom-5 reason_option" data-id="<?php echo $row['id']; ?>"> 
											    <input type="radio" name="reason_option" id="reason_option" value="<?php echo $row['id']; ?>" required="required"><?php echo $row['name'];?>
											</label>
										<?php } ?>
										 </div>										
									</span>														
								</span>
									<input type="text" id="order_id" name="order_id" value="<?php echo $order_id; ?>" style="display:none" />
									<input type="text" id="job_slug" name="job_slug"  value="<?php echo $rev_row['new_slug'];?>" style="display:none" /> 
									<div id="confirmation_div"></div>
									<button type="submit" name="submit" class="btn btn-sm btn-primary">Submit</button>
								</div>
							</form>
						 </div>						
					</div>
					<!---Accept Revision --->
				</div>
			</div>
		</div>
<?php 
    } 
} 
?>	  
<!-- Rev_orderview sold status 5 Ends--->

<!--Sold PDF file upload starts-->
<?php if(($rev_row['status'] == '3' || $rev_row['status'] == '5' ||  $rev_row['status'] == '8' || $rev_row['status'] == '4') && $rev_row['category'] == 'sold') { ?>			
<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
			<div class="portlet-title  margin-top-10">
				<div class="row static-info">
					<div class="col-md-8 value">Sold #<?php echo $order_id ;?> <?php echo $rev_row['version']; ?><small> &nbsp; (<?php echo $rev_row['date']; ?>)</small></div>
					<?php if($rev_row['status'] == '8' && $rev_row['sold_pdf'] == 'none') { ?>
					<div class="col-md-3 col-sm-3 col-xs-6 pull-right margin-bottom-5">
						<form method="post" action="<?php echo base_url().index_page().'new_csr/home/metro_sold/'.$hd;?>">
							<input name="rev_id" value="<?php echo $rev_row['id'];?>" readonly style="display:none;" />
							<input name="order_id" value="<?php echo $rev_row['order_id'];?>" readonly style="display:none;" />
							<button class="btn red-thunderbird pull-right" type="submit" name="cancel_sold" value="cancel">Cancel</button>
						</form>
					</div><?php } ?>
					<?php if($rev_row['sold_pdf']!='none'){ ?>
						<div class="col-md-4">
							<div class="row">
								<?php $sold_pdf_path = 'sold_pdf/'.$order_id.'/'.$cat[0]['slug'];
									  if(isset($sold_pdf_path) && $rev_row['sold_pdf']!='none'){ 
								//PDF File View & Download
								$map1 = $sold_pdf_path.'/'.$rev_row['sold_pdf'];
								if(file_exists($map1)){									
								?>
								<div class="col-md-3 col-sm-3 col-xs-6 pull-right margin-bottom-5">
									<a class="btn grey btn-sm btn-block" href="<?php echo base_url()?><?php echo $map1 ;?>" target="_blank">PDF</a>
								</div>
								<?php } } ?>
							</div>
						</div>
					<?php } ?>
					<?php if($rev_row['status'] == '4') { ?>
					<div class="col-md-4">
						<div class="row">	
							<div class="col-md-12">
								<form method="post" action="<?php echo base_url().index_page().'new_csr/home/metro_sold/'.$hd;?>">
									<input name="rev_id" value="<?php echo $rev_row['id'];?>" readonly style="display:none;" />
									<button type="submit" name="end_sold_QA" class="btn red-thunderbird" onclick="return Adp_confirm();">Send</button>
								</form>
							</div>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<!--Sold PDF file upload ends-->

<!-- Rev_orderview status 5 Starts (7&1 approved ad)--->
<?php if($rev_row['pdf_file']!='none' && ($rev_row['status'] == '5' || ($rev_row['status'] == '7' && $rev_row['approve'] == '1') || $rev_row['status'] == '8' || $rev_row['status'] == '9')){
		if(isset($sourcefile)) { 
		$pdf_path = $sourcefile.'/'.$rev_row['pdf_file'];
		}
		$note_revad = $this->db->get_where('note_sent',array('order_id'=>$order_id, 'revision_id'=>$rev_row['id']))->result_array();
?>
<?php if($rev_rev[0]['id']==$rev_row['id'] && $rev_rev[0]['new_slug']!='none') { ?>
		<div class="row margin-top-20">			
			<div class="col-md-12 margin-bottom-20">							
				<div class="portlet light margin-0">
					<div class="portlet-titl no-space margin-top-10 margin-bottom-10">
						<div class="row static-info">
							<div class="col-sm-7 value ">AdwitAds ID: <?php echo $order_id; ?><?php foreach($orders as $row)?><small class="font-grey-cascade"> &nbsp; 
							(<?php $date = strtotime($row['created_on']); echo date('d F', $date).','.date('Y', $date).' '.'at'.' '.date('g:i A', $date);?>)</small>
							</div>
							
							<div class="col-sm-5 text-right">
								<div class="tools">
									<div class="row">
										<div class="col-sm-6">
											<?php if($cat[0]['ftp_source_path'] != 'none' && $cat[0]['ftp_source_path'] !=''){ ?>
											<div class="margin-bottom-5">
												<a href="<?php echo $cat[0]['ftp_source_path']; ?>" class="btn grey btn-sm  btn-block">Package</a>
											</div> 
											<?php } ?>
										</div>
										<!--<div class="col-sm-3">
											<?php 
											$help_desk1 = $this->db->query("SELECT * FROM `help_desk` WHERE `id` = '".$row['help_desk']."' AND `sold` = '1'")->result_array();
											$orders_rev = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `id`=(SELECT MAX(`id`) FROM `rev_sold_jobs` WHERE `order_id`='".$row['id']."')")->result_array();
											$check = $this->db->get_where('rev_sold_jobs',array('order_id' => $row['id'], 'category' => 'sold'))->result_array();
											if($orders_rev)
											{
												$slug = $orders_rev[0]['new_slug'];
											}elseif($cat){
												$slug = $cat[0]['slug'];
											}
											?>
									<?php if($help_desk1) { ?>
										<form method="post" action="<?php echo base_url().index_page().'new_csr/home/metro_sold/'.$row['help_desk'];?>">
											<input type="text" name="order_id" value="<?php echo $row['id']; ?>" style="display:none">
											<input type="text" name="order_no" value="<?php echo $slug; ?>" style="display:none">
											<button class="btn bg-blue btn-xs" type="submit" name="submit_sold" value="Submit" onclick="return sold_confirm();">Submit Sold</button>
										</form>
									<?php } ?>
										</div>-->
										<div class="col-sm-3 no-space">
										<?php
											$from=date_create($row['created_on']);
											$to=date_create(date("Y-m-d"));
											$diff=date_diff($from,$to);
											$date_diff = $diff->format("%a");

										if(!($date_diff > $pub_name[0]['rev_days'])) { ?>
											<button class="btn bg-blue btn-xs btn-block" id="show_subrev"> Submit Revision</button>	
										<?php } ?>
										</div>	
										<div class="col-sm-3">
											<button onclick="goBack()" class="btn btn-default btn-xs">← Back</button>
										</div>									
									</div>
								</div>
								<?php echo '<h3 style="color:#900;">'.$this->session->flashdata('message2').'</h3>'; ?>
							</div>
						</div>
					</div>
					
					<!---Accept Revision --->
					<div class="portlet portlet-body margin-top-15 margin-bottom-10" id="subrev">
						<div class="row">
							<hr class="no-space">
							<form class=" margin-top-15" id="order_form" name="order_form" method="post" enctype="multipart/form-data">
								<div class="col-md-8">
									<div class="form-group">
									<label>Note &amp; Instructions </label> <small class="font-red">*</small>
									<textarea class="form-control margin-top-10" name="copy_content_description" rows="8" id="copy_content_description" required=""></textarea>
									</div>

									<!--<div class="form-group no-margin">
										 <div class="form-body flat-radio">
											<div class="form-section">
												<label>Choose One Option</label><br>
													<div class="btn-group" data-toggle="buttons">
													<?php foreach($rev_reason as $row){ ?>
														<label class="btn grey btn-sm margin-right-10 margin-bottom-5"> <input type="radio" name="reason_option" id="reason_option" value="<?php echo $row['id']; ?>" required="required"><?php echo $row['name'];?></label>
													<?php } ?>
													 </div>
											</div>
										</div>														
									</div>-->
								</div> 
								<div class="col-md-4">
									<div class="form-group">
										<label>Attach Files</label>
										<div class="row no-space">
										<div class="col-md-12  margin-top-10 no-space"><input type="file" name="ufile[]" id="ufile[]" accept="application/pdf"></div>
										<div class="col-md-12  margin-top-10 no-space"><input type="file" name="ufile[]" id="ufile[]" accept="application/pdf"></div>
										</div>
									</div>
								</div>
								<div class="col-md-12 text-right">
								  <hr>
									<span class=" margin-right-10 font-grey-cascade">
										<label><small><input type="checkbox" name="rush" id="rush" value="1">Rush</small></label>
									</span>
									<span class="form-group no-margin">
									 <span class="form-body flat-radio">										
										<div class="btn-group" data-toggle="buttons">
										<?php foreach($rev_reason as $row){ ?>
											<label class="btn grey btn-sm margin-right-10 margin-bottom-5 reason_option" data-id="<?php echo $row['id']; ?>"> 
											    <input type="radio" name="reason_option" id="reason_option" value="<?php echo $row['id']; ?>" required="required"><?php echo $row['name'];?>
											</label>
										<?php } ?>
										 </div>										
									</span>														
								</span>
									<input type="text" id="order_id" name="order_id" value="<?php echo $order_id; ?>" style="display:none" />
									<input type="text" id="job_slug" name="job_slug"  value="<?php echo $rev_row['new_slug'];?>" style="display:none" /> 
									<div id="confirmation_div"></div>
									<button type="submit" name="submit" class="btn btn-sm btn-primary">Submit</button>
								</div>
							</form>
						 </div>						
					</div>
					<!---Accept Revision --->
				</div>
			</div>
		</div>
		<?php } ?>
		
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light grey-cararra">
					<div class="portlet-titl">
						<div class="row static-info">
							<div class="col-md-7 col-sm-12 value  margin-top-15 font-grey-gallery"><?php echo $rev_row['version'] ;?> &nbsp;
								<?php if($note_revad){ ?>
								<span class="margin-right-10 font-yellow tooltips" data-container="body" data-placement="top" data-original-title="<?php echo $note_revad[0]['note']; ?>"><i class="fa fa-warning"></i></span>
								<?php } ?>
								<?php if( $rev_row['status']!='0'){ 
										$rev_status = $this->db->query("SELECT * FROM `rev_order_status` WHERE `id` = '".$rev_row['status']."'")->result_array();
										if($rev_status) { ?>
											<span class="font-green tooltips" data-container="body" data-placement="top" data-original-title="<?php echo $rev_status[0]['name'] ;?>"><i class="fa fa-check-circle font-lg"></i></span>
										<?php } else { echo " ";} } ?>
							</div>
							
							<div class="col-md-5 col-sm-12 value bold margin-top-10 no-space text-right">
								<!--PDF FILE-->
								<?php if(isset($pdf_path) && file_exists($pdf_path)){ ?>
									<div class="col-md-3 col-sm-3 col-xs-6 pull-right margin-bottom-5">
										<a class="btn grey btn-sm btn-block" href="<?php echo base_url().$pdf_path; ?>" target="_blank">
										PDF</a>
									</div>
								<?php } ?>
								<!--PDF FILE-->
								
								<!--Package-->
								<?php if(isset($sourcefile)){ 
								$source_zip_file = $sourcefile.'/'.$rev_row['new_slug'].'.zip' ;
										if(file_exists($source_zip_file)){ ?>
									<div class="col-md-2 col-sm-3 col-xs-6 pull-right  no-space margin-bottom-5">
										<a href="<?php echo base_url()?><?php echo $source_zip_file ?>" class="btn grey btn-sm  btn-block">Package</a>
									</div>	
										<?php } else { 
												//zip source
												$source_file = $rev_row['source_file'];
												$map2 = $sourcefile.'/'.$source_file;
												if(file_exists($map2)){	?>
												
									<div class="col-md-2 col-sm-3 col-xs-6 pull-right  no-space margin-bottom-5">
										<form action="<?php echo base_url().'index.php/new_csr/home/zip_folder_select'?>" method="post">
											<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
											<input name="pdf_file" value="<?php echo $rev_row['pdf_file'];?>" readonly style="display:none;" />
											<input name="new_slug" value="<?php echo $rev_row['new_slug'];?>" readonly style="display:none;" />
											<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
											<input name="download" value="download" readonly style="display:none;" />
											<button type="submit" name="SourceDownload" class="btn grey btn-sm  btn-block">Package</button>
										</form>
									</div> 
									<?php } } ?>
								<!--Package-->
									 
								<!--Downloads-->
								<?php if($rev_row['file_path'] != 'none') { $rev_order_form = $rev_row['file_path'];
										if(isset($rev_order_form) && file_exists($rev_order_form)) { 
										$rev_map = glob($rev_order_form.'/*',GLOB_BRACE);
										if($rev_map){ ?>
								<div class="col-md-3 col-sm-3 col-xs-6 pull-right margin-bottom-5">
									<form method="post" action="<?php echo base_url().index_page().'new_csr/home/zip_folder';?>">
										<input name="file_path" value="<?php echo $rev_order_form; ?>" readonly style="display:none;" /> 
										<input name="file_name" value="<?php echo $order_id; ?>" readonly style="display:none;" />
										<button type="submit" name="Submit" class="btn grey btn-sm btn-block">Download</button>
									</form>
								</div>
								<?php } } } ?>
								<!--Downloads-->
								
								<!--sold PDF-->
								<?php $help_desk1 = $this->db->query("SELECT * FROM `help_desk` WHERE `id` = '".$cat[0]['help_desk']."' AND `sold` = '1'")->result_array();
								if(($help_desk1) && ($rev_row['sold_pdf']!='none')){ ?>
								<div class="col-md-3 col-sm-3 col-xs-6 pull-right margin-bottom-5">
									<form method="post" action="<?php echo base_url().index_page().'new_csr/home/metro_sold_order/'.$cat[0]['help_desk'].'/'.$order_id;?>">
										<input name="rev_id" value="<?php echo $rev_row['id']; ?>" readonly style="display:none;" />
										<input name="sold_pdf" value="<?php echo $rev_row['sold_pdf']; ?>" readonly style="display:none;" />
										<input name="job_name" value="<?php echo $rev_row['new_slug']; ?>" readonly style="display:none;" />
										<button type="submit" name="metro_sold_submit" class="btn grey btn-sm btn-block">Sold</button>
									</form>
								</div>
								<?php } ?>
								<!--sold PDF-->
								
								<?php }elseif($cat[0]['ftp_source_path'] != 'none' || $cat[0]['ftp_source_path'] != '') { ?>
								<?php if($rev_row['pdf_path']!='none' && file_exists($rev_row['pdf_path'])){ ?>
								<div class="col-md-3 pull-right margin-bottom-5">
									<a href="<?php echo base_url().''.$rev_row['pdf_path'];?>" target="_Blank" class="btn grey btn-sm btn-block">PDF</a>
								</div>
								<?php } } ?>
							</div>
						</div>
					</div>
				</div>
			 </div>
		</div>
<?php } ?>	  
<!-- Rev_orderview status 5 Ends--->
<?php }  ?>

<!--- V1 files-->
<?php if((isset($rev_orders)) && ($rev_row['status'] == '1' || $rev_row['status'] == '2' || $rev_row['status'] == '3' || $rev_row['status'] == '4' || $rev_row['status'] == '5' || $rev_row['status'] == '7' || $rev_row['status'] == '8' || $rev_row['status'] == '9')) { ?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light grey-cararra">
					<div class="portlet-titl">
						<div class="row static-info">
							<div class="col-md-7 col-sm-12 value  margin-top-15 font-grey-gallery">V1 &nbsp;
								<?php if(isset($note_newad)){ ?>
								<span class="margin-right-10 font-yellow tooltips" data-container="body" data-placement="top" data-original-title="<?php echo $note_newad['note']; ?>"><i class="fa fa-warning"></i></span>
								<?php } ?> 
								<?php if(isset($cat) && $cat[0]['pro_status']!='0'){ 
										$status = $this->db->query("SELECT * FROM `production_status` WHERE id='".$cat[0]['pro_status']."'")->result_array();
											if($status) { ?>
								<span class="font-green tooltips" data-container="body" data-placement="top" data-original-title="<?php echo $status[0]['name'] ;?>"><i class="fa fa-check-circle font-lg"></i></span>
								<?php } else { echo " "; } } ?>
							</div>
							<?php
								$from=date_create($orders[0]['created_on']);
								$to=date_create(date("Y-m-d"));
								$diff=date_diff($from,$to);
								$date_diff = $diff->format("%a");
								//echo $date_diff;
								if($date_diff > $pub_name[0]['rev_days']) {
									if(file_exists($orders[0]['pdf'])) { ?>

								<div class="col-md-1 pull-right" >
									<a href="<?php echo base_url().''.$orders[0]['pdf'];?>" target="_Blank" class="btn grey btn-sm btn-block">PDF</a>
								</div>
							<?php } }else{ ?>
							
							<?php $help_desk = $this->db->get_where('help_desk',array('id' => $hd))->row_array();
							if($help_desk['ftp_server'] != 'none' && $cat[0]['source_path']!='none'){ ?>
							<div class="col-md-5 col-sm-12 value bold margin-top-10 no-space text-right">
								<div class="col-md-3 col-sm-3 col-xs-6 pull-right margin-bottom-5">
									<a href="<?php echo 'http://'.$cat[0]['source_file']; ?>" target="_Blank" class="btn grey btn-sm btn-block">PDF</a>
								</div>
								<div class="col-md-2 col-sm-3 col-xs-6 pull-right  no-space margin-bottom-5">
										<a href="<?php echo 'http://'.$cat[0]['source_path'].'/'.$cat[0]['slug'].'.zip'; ?>" class="btn grey btn-sm  btn-block">Package</a>
								</div>
								<!--Downloads-->
								<?php  if(isset($order_form) && file_exists($order_form)) { 
									$order_map = glob($order_form.'/*',GLOB_BRACE);
									if($order_map) { ?>
								<div class="col-md-3 col-sm-3 col-xs-6 pull-right margin-bottom-5">
									<form method="post" action="<?php echo base_url().index_page().'new_csr/home/zip_folder';?>">
										<input name="file_path" value="<?php echo $order_form; ?>" readonly style="display:none;" /> 
										<input name="file_name" value="<?php echo $order_id; ?>" readonly style="display:none;" />
										<button type="submit" name="Submit" class="btn grey btn-sm btn-block">
											Download
										</button>	
									</form>
								</div>
								<?php } } ?>
							</div>
							<?php } ?>
							
							<?php  if(isset($sourcefile)) { 
									$map2 = glob($sourcefile.'/'.$cat[0]['slug'].'.{indd,psd}',GLOB_BRACE); 
									$map3 = glob($sourcefile.'/'.$cat[0]['slug'].'.{pdf,jpg,gif,png}',GLOB_BRACE); 
									$source_zip_file = $sourcefile.'/'.$cat[0]['slug'].'.zip' ; ?>	
							<div class="col-md-5 col-sm-12 value bold margin-top-10 no-space text-right">
								
								<!--PDF-->
								<?php if($cat[0]['pdf_path']!='none'){ ?>
								<div class="col-md-3 col-sm-3 col-xs-6 pull-right margin-bottom-5">
									<a href="<?php echo base_url().''.$cat[0]['pdf_path'];?>" target="_Blank" class="btn grey btn-sm btn-block">PDF</a>
								</div>
								<!--PDF-->
								
								<!--Package-->
								<?php } if(file_exists($source_zip_file)){ ?>
								
								<div class="col-md-2 col-sm-3 col-xs-6 pull-right  no-space margin-bottom-5">
									<a href="<?php echo base_url()?><?php echo $source_zip_file ?>" class="btn grey btn-sm  btn-block">Package</a>
								</div>
								
								<?php } else {
									if($map2){ 
										if($map3){ foreach($map3 as $row_map3){ $pdf_file = basename($row_map3); } }
											foreach($map2 as $row_map2){ $source_file = basename($row_map2); } ?>
											
								<div class="col-md-2 col-sm-3 col-xs-6 pull-right  no-space margin-bottom-5">
									<form action="<?php echo base_url().'index.php/new_csr/home/zip_folder_select'?>" method="post">
										<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
										<input name="new_slug" value="<?php echo $cat[0]['slug'];?>" readonly style="display:none;" />
										<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
										<input name="download" value="download" readonly style="display:none;" />
										<button type="submit" name="SourceDownload" class="btn grey btn-sm  btn-block">Package</button>
									</form>
								</div> 
								<?php } } ?>
								<!--Package-->
								
								<!--Downloads-->
								<?php if(isset($order_form) && file_exists($order_form)) { 
									$order_map = glob($order_form.'/*',GLOB_BRACE);
									if($order_map) { ?>
								<div class="col-md-3 col-sm-3 col-xs-6 pull-right margin-bottom-5">
									<form method="post" action="<?php echo base_url().index_page().'new_csr/home/zip_folder';?>">
										<input name="file_path" value="<?php echo $order_form; ?>" readonly style="display:none;" /> 
										<input name="file_name" value="<?php echo $order_id; ?>" readonly style="display:none;" />
										<button type="submit" name="Submit" class="btn grey btn-sm btn-block">
											Download
										</button>	
									</form>
								</div>
								<?php } } ?>
								<!--Downloads-->
								
								<?php }elseif($cat[0]['ftp_source_path'] != 'none' || $cat[0]['ftp_source_path'] != '') { ?>
								<?php if($cat[0]['pdf_path']!='none' && file_exists($cat[0]['pdf_path'])){ ?>
								<div class="col-md-1 pull-right margin-bottom-5">
									<a href="<?php echo base_url().''.$cat[0]['pdf_path'];?>" target="_Blank" class="btn grey btn-sm btn-block">PDF</a>
								</div>
								<?php } } ?>
							</div>
						<?php }?>
							
						 </div>
					</div>
				</div>
			 </div>
		 </div>

		<div class="row">
			<div class="col-md-12 text-center">
				<form method="post" action="<?php echo base_url().index_page().'new_csr/home/orderview_history/'.$hd.'/'.$order_id;?>">
					<button type="submit" class="btn bg-grey-sliver btn-sm no-margin"><i class="fa fa-history"></i> History</button>	
				</form>
			</div>
		</div>

<?php } ?>
<!--- V1 files-->
<?php } ?>	

				<!--------------------------------------------Revision Ends----------------------------------------------->

<!-----------------------order details for orders not in cat result but completed------------------------------------------------->				
	<?php if(!isset($cat) && ($orders[0]['status']=='5' || $orders[0]['status']=='7')) { ?>
        <div class="row margin-top-20 margin-bottom-20">			
			<div class="col-md-12">							
				<div class="portlet light margin-0">
					<div class="portlet-title no-space margin-top-10">
						<div class="row static-info">
						<?php foreach($orders as $row) ?>
							<div class="col-md-4 value bold">ID: <?php echo $order_id; ?>&nbsp;<small class="font-grey-cascade"> (<?php echo $row['created_on']; ?>)</small>
							</div>
							<div class="col-md-4 text-right">
								<div class="tools">
								<?php
									if(isset($rev_orders[0]['pdf_path']) && $rev_orders[0]['pdf_path']!='none'){ 
										$version = $rev_orders[0]['version'];
										$pdf_path = $rev_orders[0]['pdf_path'];
										if(!file_exists($pdf_path)){ $pdf_path = $rev_orders[0]['pdf_path'].'/'.$rev_orders[0]['pdf_file']; }
									}elseif($row['pdf']!='none'){ 
										$version = 'V1';
										$pdf_path = $row['pdf'];
										if(!file_exists($pdf_path)){ $pdf_path = 'pdf_uploads/'.$row['id'].'/'.$row['pdf']; }
									}
									
									if(isset($pdf_path) && file_exists($pdf_path)){
										echo '<a href="'.base_url().$pdf_path.'" target="_Blank" class="btn grey btn-sm btn-block">PDF - '.$version.'</a>';
									}
								?>
								</div>
							</div>	
						</div>
					</div>
					
					<div class="portlet-body margin-top-10">
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="portlet blue-hoki box">
									<div class="portlet-title">
										<div class="caption">Order Info</div>
									</div>
													
									<div class="portlet-body">
										<div class="row static-info margin-top-10">
											<div class="col-md-5 col-xs-5 name">Unique Job Name:</div>
											<div class="col-md-7 col-xs-7 value word-break"><?php echo $row['job_no'];?></div>
										</div>
										<div class="row static-info">
											<div class="col-md-5 col-xs-5 name">Ad Size:</div>
											<?php if($row['order_type_id']=='1'){ // webad 
												if($row['pixel_size']=='custom'){?>
												<div class="col-md-3 col-xs-3 value">W: <?php echo $row['custom_width']; ?>
												</div>
												<div class="col-md-4 col-xs-4 value">H: <?php echo $row['custom_height']; ?></div>
											<?php } else {
												$size_px = $this->db->get_where('pixel_sizes',array('id'=>$row['pixel_size']))->result_array();
											?>
												<div class="col-md-3 col-xs-3 value">W: <?php echo $size_px[0]['width']; ?></div>
												<div class="col-md-4 col-xs-4 value">H: <?php echo $size_px[0]['height']; ?></div>
											<?php } }else{ //printad ?>
												<div class="col-md-3 col-xs-3 value">W: <?php echo $row['width']; ?></div>
												<div class="col-md-4 col-xs-4 value">H: <?php echo $row['height']; ?></div>
											<?php } ?>
										</div>
										<div class="row static-info">
											<?php if($row['order_type_id']=='1'){ // webad ?>  
												<div class="col-md-5 col-xs-5 name">Static/Animated:</div>
												<div class="col-md-7 col-xs-7 value"><?php echo $row['web_ad_type']; ?></div>
												<?php }else{	//printad
											$print_ad_type =$this->db->get_where('print_ad_types',array('id' => $row['print_ad_type']))->result_array();?>
												<div class="col-md-5 col-xs-5 name">Full Color/B&amp;W/Spot:</div>
												<div class="col-md-7 col-xs-7 value"><?php echo $print_ad_type[0]['name']; ?></div>
												<?php } ?>
										</div>
										<div class="row static-info">
											<div class="col-md-5 col-xs-5 name">Advertiser:</div>
											<div class="col-md-7 col-xs-7 value word-break"><?php echo $row['advertiser_name']; ?></div>
										</div>
										<?php if($row['job_instruction']!=="") { ?>
										<div class="row static-info">
											<div class="col-md-5 col-xs-5 name">Job Instruction:</div>
											<div class="col-md-7 col-xs-7 value">
												<?php  if($row['job_instruction']==1)  { echo "Follow Instructions Carefully"; }?>
												<?php  if($row['job_instruction']==2)  { echo  "Be Creative"; }?>
												<?php  if($row['job_instruction']==3)  { echo  "Camera Ready Ad"; } ?>
											</div>
										</div>
										<?php } ?>
										<?php if($row['copy_content_description']!=="" && $row['copy_content_description']!=NULL) { ?>
										<div class="row static-info">
											<div class="col-md-5 col-xs-5 name">Copy/Content:</div>
											<div class="col-md-7 col-xs-7 value">
												<div class="scroller" style="height:55px" data-always-visible="1" data-rail-visible="0">
												<?php echo nl2br($row['copy_content_description']);?>
													<!--<?php echo htmlspecialchars($row['copy_content_description'], ENT_QUOTES, 'UTF-8');?>-->
												</div>
											</div>
										</div>
										<?php } ?>
										<?php if($row['notes']!=="" && $row['notes']!=NULL) { ?>
										<div class="row static-info">
											<div class="col-md-5 col-xs-5 name">Notes & Instructions:</div>
											<div class="col-md-7 col-xs-7 value">
												<div class="scroller" style="height:55px" data-always-visible="1" data-rail-visible="0">
													<?php echo nl2br($row['notes']); ?>
												</div>
											</div>
										</div>
										<?php } ?>
										
										<?php if(isset($order_mood)) { ?>
										<div class="row static-info">
											<div class="col-md-5 col-xs-6 name">Moodboard</div>
											<?php if(isset($moodboard_path) && file_exists($moodboard_path)){ ?>
											<div class="col-md-7 col-xs-6 value"><a href="<?php echo base_url().$moodboard_path;?>" target="_blank"><?php echo $moodboard_filename; ?></a></div>
											<?php } ?>
										</div>
										<?php } ?>
								
									</div>				
								</div>
							</div>	
							
							<div class="col-md-6 col-sm-12">								
								<div class="row">	
								
								<div class="col-md-12 col-sm-12">
									<div class="portlet blue-hoki box margin-bottom-10">
										<div class="portlet-title">
											<div class="caption">Customer Info</div>
										</div>
										<div class="portlet-body">
											<div class="row static-info margin-top-10">
												<div class="col-md-5 col-xs-5 name">Publication:</div>
												<div class="col-md-7 col-xs-7 value"><?php echo $pub_name[0]['name']; ?></div>
											</div>
											<div class="row static-info">
												<div class="col-md-5 col-xs-5 name">AdRep Name:</div>
												<div class="col-md-7 col-xs-7 value"><?php echo $adrep_name[0]['first_name']; ?></div>
											</div>
									
											<div class="row static-info">
												<div class="col-md-5 col-xs-5 name">Date Needed:</div>
												<div class="col-md-7 col-xs-7 value"><?php echo $row['date_needed']; ?></div>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-md-12 col-sm-12">
									<div class="portlet blue-hoki box margin-bottom-10">
										<div class="portlet-title">
											<div class="caption">Downloads</div>
											<?php if($row['file_path']!='none') { ?>
											<div class="actions">
												<form method="post" action="<?php echo base_url().index_page().'new_csr/home/zip_folder';?>">
													<input name="file_path" value="downloads/<?php echo($order_id.'-'.$row['job_no'])?>" readonly style="display:none" /> 
													<input name="file_name" value="<?php echo($order_id.'-'.$row['job_no'])?>" readonly style="display:none" />
													<a id="attach" class="font-grey-cararra tooltips" data-container="body" data-placement="top" data-original-title="Attach File">
													<i class="fa fa-link"></i></a>
													<button type="submit" name="Submit" class="btn btn-default btn-sm">
													<i class="fa fa-cloud-download"></i>All</button>
												</form>
											</div>
											<?php }else{ ?>
											    <a href="<?php echo base_url().index_page().'new_csr/home/order_form_details/'.$order_id;?>" target="_blank">orderform</a>
											<?php } ?>
										</div>
										<div class="portlet-body">
											<div class="table-scrollable table-scrollable-borderless">
												<table class="table table-light table-hover">
													<tbody>
													<?php $i=1;
													if(isset($downloads)){
														foreach($file_format as $format){
														$this->load->helper('directory');
														$map = glob($downloads.'/*{'.$format['name'].'}',GLOB_BRACE);		
														if($map){
															foreach($map as $row_map)
															{ 
													?>
														<tr>
															<td class="small"><?php echo $i; $i++;?></td>                       
															<td><?php echo basename($row_map) ?></td>
															<td>
																<a href="<?php echo base_url()?><?php echo $row_map ?>";  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
																<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row_map; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a>
															</td>
														</tr>
														<?php } } } } ?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
								
								<!-- pick up ad source file link-->
								<div class="col-md-12 col-sm-12">
									<div class="portlet blue-hoki box margin-bottom-10">
										<div class="portlet-title">
											<div class="caption">Pickup Ad</div>
											<div class="actions">
												<a id="pickup" class="font-grey-cararra tooltips" data-container="body" data-placement="top" data-original-title="Attach File">
												<i class="fa fa-link"></i></a> &nbsp;              
											</div>
										</div>
										<div class="portlet-body">
										
										<?php if($row['pickup_adno'] != '') { ?>
											<div class="row static-info margin-top-10">
												<div class="col-md-5 name">PickUp Ad No:</div>
												<div class="col-md-7 value"><?php echo $row['pickup_adno']; ?></div>
											</div>
										<?php } ?>
										
										<div class="table-scrollable table-scrollable-borderless">
											<table class="table table-light table-hover">
											<tbody>
											<?php $i=1;
											if(isset($pickup_downloads)){
													foreach($file_format as $format){
													$this->load->helper('directory');
													$pickup_map = glob($pickup_downloads.'/*{'.$format['name'].'}',GLOB_BRACE);		
													if($pickup_map){
														foreach($pickup_map as $pickup_row_map)
														{ 
											?>
											<tr>
												<td class="small"><?php echo $i; $i++;?></td>                                     
												<td class="word-wrap"> <?php echo basename($pickup_row_map) ?></td>
												<td>
												<a href="<?php echo base_url()?><?php echo $pickup_row_map ?>";  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
												<a href="<?php echo base_url()?>download.php?file_source=<?php echo $pickup_row_map; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a>
												</td>
											</tr><?php } } } } ?>
											
											
											</tbody>
											</table>
										</div>
										
										</div>
									</div>
								</div>
								<!-- pick up ad source file link-->
								</div>
							</div>
						</div>
					</div>
				</div>						
			</div>
		</div>
	<?php } ?>
<!-----------------------END order details for orders not in cat result but completed------------------------------------------------->					
		</div>		
		</div>
	</div>					
</div>
<?php if(isset($pdf_annotation_url) && $csr_alias[0]['pdf_review_tool'] == '1'){ ?>
    <div class="modal fade" id="full" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-full">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">PDF Review </h4>
                </div>
                <div class="modal-body">
                   <div class="container">
            	        <div id="adobe-dc-view" style="width:100%;height:600px;"></div>
            		</div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>


<style>
    .custom-modal {
  max-height: 50vh; /* Adjust the maximum height as needed */
}
</style>
<!-- confirmation modal starts here-->
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="width:85%">
        <div id="modal_content">
      <div class="modal-header  portlet blue-hoki box" style="border-bottom: 0 !important;">
        <h5 class="modal-title portlet-title margin-top-10" style="margin-top: 0px !important; padding:10px !important;"  id="confirmationModalTitle"><center><b>Confirm Submission</b></center></h5>
      
      </div>
      <div class="modal-body">
        Before hitting <b>"Submit"</b> take a quick moment to ensure everything looks just right. Thanks!
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" onclick="submitForm()">Confirm</button>
      </div>
    </div>
  </div>
</div>
<!-- confirmation modal ends here-->

<!-- send to Adrep confirmation modal-->
<div class="modal fade" id="sendToAdrepConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="width:85%">
      <div class="modal-header  portlet blue-hoki box" style="border-bottom: 0 !important;">
        <h5 class="modal-title portlet-title margin-top-10" style="margin-top: 0px !important; padding:10px !important;"  id="confirmationModalTitle"><center><b>Confirm Submission</b></center></h5>
      
      </div>
      <div class="modal-body">
        Before hitting <b>"Submit"</b> take a quick moment to ensure everything looks just right. Thanks!
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" onclick="sendToAdrep()">Confirm</button>
      </div>
    </div>
  </div>
</div>
<!-- send to Adrep confirmation modal-->


<?php $this->load->view('new_csr/foot'); ?>
<script>
	//remove attachment
		function remove_attachment(fname='heloo'){  
			var x = confirm("Delete the item - "+fname+"?");
			if(x == true){
			   $.ajax({
				  url: "<?php echo base_url().index_page()."new_csr/home/remove_attachment/".$order_id;?>/"+fname,
				  success: function(data){
					  location.reload();//alert('result - '+data);
				  }
				 
			   });
			}
		}
</script>
<!-- source upload START -->
<script>
    //Fonts file
    Dropzone.options.dropzonefont = {
        maxFilesize: 15, //15mb
      	init: function() {
    	    this.on("success", function(file, responseText) {
                console.log(responseText); // console should show the ID you pointed to
                if(responseText != 'success'){ alert(responseText); this.removeFile(file); }
            });
            
    		this.on('error', function(file, response) {
                $(file.previewElement).find('.dz-error-message').text(response);
            });
    	}
    };
    //Links file
    Dropzone.options.dropzonelink = {
        maxFilesize: 15, //15mb
      	init: function() {
    	    this.on("success", function(file, responseText) {
                console.log(responseText); // console should show the ID you pointed to
                if(responseText != 'success'){ alert(responseText); this.removeFile(file); }
            });
            
    		this.on('error', function(file, response) {
                $(file.previewElement).find('.dz-error-message').text(response);
            });
    	}
    };
    //Print PDF
    Dropzone.options.dropzonepdf = {
        maxFilesize: 100, //mb
        acceptedFiles: '.pdf',
        maxFiles: 1,
    	init: function() {
    		this.on("sending", function(file) 
    		{ 
    			var string1_value = $(slug_name).val() + ".pdf";
                var string1caps_value = $(slug_name).val() + ".PDF";
    			var string2_value = file.name;
    			var myarray = [string1_value, string1caps_value];
    			if($.inArray(string2_value, myarray) == -1){
    				alert("Wrong file. Check File Name & Extension. File will be removed");
    				this.removeFile(file);
    			}
    		});
    		 //response from server
    		this.on("success", function(file, responseText) {
                console.log(responseText); // console should show the ID you pointed to
                if(responseText != 'success'){ alert(responseText); this.removeFile(file); }
            });
            
    		this.on('error', function(file, response) {
                $(file.previewElement).find('.dz-error-message').text(response);
                alert(response);
            });
    	}
    };
    //Print Indesign
    Dropzone.options.dropzoneindd = {
        maxFilesize: 100, //100mb
        acceptedFiles: '.indd',
        maxFiles: 1,
    	init: function() {
    		this.on("sending", function(file) 
    		{ 
    			var string1_value = $(slug_name).val() + ".indd";
                var string1caps_value = $(slug_name).val() + ".INDD";
    			var string2_value = file.name;
    			var myarray = [string1_value, string1caps_value];
    			if($.inArray(string2_value, myarray) == -1){
    				alert("Wrong file. Check File Name & Extension. File will be removed");
    				this.removeFile(file);
    			}
    		});
    		
            this.on("success", function(file, responseText) {
                //var responseText = file.id // or however you would point to your assigned file ID here;
                console.log(responseText); // console should show the ID you pointed to
                if(responseText != 'success'){ alert(responseText); this.removeFile(file); }
            });
            
            this.on('error', function(file, response) {
                $(file.previewElement).find('.dz-error-message').text(response);
                alert(response);
            });
    	}
    };
</script>
 <!-- source upload END-->

<!-- pdf annotation -->
<?php if(isset($pdf_annotation_url) && $csr_alias[0]['pdf_review_tool'] == '1'){  // load only if pdf file available ?>
<!--<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>-->

<script src="https://documentcloud.adobe.com/view-sdk/main.js"></script> 

<script type="text/javascript">

	document.addEventListener("adobe_dc_view_sdk.ready", function(){ 

		var adobeDCView = new AdobeDC.View({clientId: "9962a6efddab4b0391adc0fd311e55ab", divId: "adobe-dc-view"});

		adobeDCView.previewFile({

			//content:{location: {url: "<%=pdfName%>"}},
			
            content:{location: {url: "<?php echo $pdf_annotation_url; ?>"}},
            
			//content:{location: {url: "https://documentcloud.adobe.com/view-sdk-demo/PDFs/Bodea Brochure.pdf"}},

			metaData:{fileName: "<?php echo $pdf_name; ?>"},
			
			defaultViewMode: "FIT_PAGE"

		}, {});//IN_LINE

	/* Register save callback */ 

        adobeDCView.registerCallback(

            AdobeDC.View.Enum.CallbackType.SAVE_API,

            function (metaData, content, options) {

                console.log(metaData);

                console.log(content);

                

                var base64PDF = arrayBufferToBase64(content);

                var formData = new FormData();

                formData.append('content', base64PDF);

                

                $.ajax({  

		  		       url : "<?php echo base_url().index_page().'new_csr/home/csr_pdf_review/'.$order_id; ?>",  

		  		       type : 'POST',

		  		     enctype: 'multipart/form-data',

		  		     data: formData,

		  		   processData: false,

		            contentType: false,

		            cache: false,

		            timeout: 600000, 

		  		   success : function(response) {

		  			//console.log(response);
		  			document.getElementById("pdf_annotation_div").innerHTML = response; //display in conversation

		  		   }

				});

                

				console.log('Uploaded a file!');

				

                return new Promise(function (resolve, reject) {

                    /* Dummy implementation of Save API, replace with your business logic */

                    setTimeout(function () {

                        var response = {

                            code: AdobeDC.View.Enum.ApiResponseCode.SUCCESS,

                            data: {

                                metaData: Object.assign(metaData, { updatedAt: new Date().getTime() })

                            },

                        };

                        resolve(response);

                    }, 2000);

                });

            }

        );

		

	});


	function arrayBufferToBase64(buffer) {

        var binary = "";

        var bytes = new Uint8Array(buffer);

        var len = bytes.byteLength;

        for (var i = 0; i < len; i++) {

            binary += String.fromCharCode(bytes[i]);

        }

        return window.btoa(binary);

    }
</script>
<?php } ?>
 <!--pdf annotation END-->
 
 <script>
 
 //BACK to designer check filename 
    function getFileData(myFile){ console.log(myFile);
       var file = myFile.files[0];  
       var filename = file.name;
       var name = filename.split('.').shift(); //console.log(name);
       var slug = $("#slug_name").val(); 
       if(slug != name){
         alert("File name does not match Slug.."); 
         myFile.value = '';
       }
    }
    
     $(".adtype").on("click", function(){
        var adtypeId =  $(this).data('id'); //console.log('radio click - '+v);
        $.get('index.php/new_csr/home/get_subcategory', {'adtypeId':adtypeId}, function(result){
            $('#sub_category_div').html(result);
       });
    });
</script>