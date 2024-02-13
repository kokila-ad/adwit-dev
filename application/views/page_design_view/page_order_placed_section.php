<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    $this->load->view('page_design_view/header');
?>
<style>
    .item-page{
        padding: 5px !important
    }
    .list-group-item:last-child {
    
        margin-bottom: unset !important;
        border-bottom-right-radius: unset !important;
        border-bottom-left-radius: unset !important;
       
    
    }
    .list-group-item:first-child {
    
        border-top-right-radius: unset !important;
        border-top-left-radius: unset !important;
       
    
    }
    form{
    	margin-bottom: 0em !important;
    }
    .list-group-item{
    	border-left: 1px solid #ddd !important;
    border: 0px solid #ddd !important;
    border-bottom: 1px solid #ddd !important;
    }
    
    .flashmsg {
    
        background-color: #dff0d8;
        border: 1px solid #c4d4be;
        padding: 5px 15px 5px 15px;
    
    
</style>
<style>
    	.progress{
    		margin-bottom:70px;
    	}
    	.progress-bar-grey{
    		background-color: grey;
    		border-top-left-radius: 9px ;
    		border-bottom-left-radius: 9px ;
    	}
    	
    	.dropzone .dz-message { 
    	 margin-top: 4%; 
    	 margin-bottom: 4%; 
     } 
    
    .font-12{
    	font-size:12px;
    }
    textarea,
    textarea::-webkit-textarea-placeholder {
        font-size: 12px !important;
       
    }
    
    
    
    .progress-bar-border{
    	border:1px solid #aaa;
    	height:20px;
    	border-radius:15px;
    	background-color: #aaa;
    }
    .progress-bar {
    	text-align: center !important;
    }
    	
</style>
<style>
        /*18/5/2022*/
        .clickedit{
        	position: relative;
            left: 15px;
            top: 3px;
        }
        .margin-0-res{
        	margin-left: 0px !important;
        	margin-right: 0px !important;
        }
        @media only screen and (max-width: 600px) {
        	    .margin-0-res{
        	    margin-left: 15px !important;
        	    margin-right: 15px !important;
            }
        }
        /*18/5/2022*/	
</style>

	<div class="container margin-bottom-30"> 
		<section>
			<div class="container margin-top-40 center">                        
			  <!--  <a href="print_ad.php" class="btn btn-sm btn-dark btn-outline margin-right-5 width-equal">Print Ad</a>
			   <a href="online_ad.php" class="btn btn-sm btn-dark btn-outline margin-right-5 width-equal">Online Ad</a -->
			   <a href="<?php echo base_url().index_page()."new_client/home/page_proceed/";?>" class="btn btn-sm btn-dark btn-outline btn-active width-equal">Pagination</a>
			</div>
		</section>
	</div>
	<div class="middle3">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-2 col-md-2 col-md-offset-5 col-sm-offset-5  " >
					<div class="progress">
						<div class="progress-bar-border">
							<div class="progress-bar progress-bar-grey " role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 50%" ><i class="fa fa-check"></i>
							</div>
						</div>
						<br>
						<p><span class="padding-left-25">Step 1 </span> <span class="pull-right padding-right-25">Step 2</span></p>
					</div>
				</div>
			</div>
<!-- *********************************************** Select Pages *********************************************** -->	
			<div class="row">
			    <p class="text-grey"><span>Publication/Edition Name: <span class="text-dark"><?php echo $page_design['unique_job_name']; ?></span></span></p>
				<div class="col-sm-4 padding-division padding-top-20">
					<div class="row">
						<div class="list-group">
						  	<a class="list-group-item active main-color-bg margin-0-res" >Select Section
						  		<span  class="btn btn-xs btn-blue pull-right" id="addclick" data-toggle="tooltip" title="Add New Section">
						  			ADD SECTION 
						  		</span>
							 	<form method="post" action="<?php echo base_url().index_page().'new_client/home/page_add_section/'.$page_design['id'];?>">
									<div class="row" id="clickshow">
										<div class="col-md-6 col-xs-6">
											<input type="text" name='section_name' placeholder="Enter Section Name" class="form-control input-sm margin-top-10" maxlength="25" title="" required="" autocomplete="off">	 	
										</div>
										<div class="col-md-6 col-xs-6">
											<button type="submit"  name="add" class="btn btn-sm btn-blue margin-top-10" id="submit_form" >Submit</button>
										</div>
									</div>
							 	</form><!--This is Add option -->
						  	</a>
						  	<div class="list-group_scroll ">
					        <?php 
					            if(isset($page_design_section[0]['id'])){
					                foreach ($page_design_section as $section){
					         ?>
					                <div class="border " style="border: 1px solid #ddd !important;">
						  	            <div class="row padding-top-10 padding-bottom-10 margin-0-res">   
    						  	            <div class="col-md-5 col-xs-5" ><!-- Page Name/Number -->
        						  	            <!--<a href="#">-->
            						  	            <span id='select-section' style="color: brown;"> <?php echo $section['section_name'];?> </span>
            								    <!--</a>-->
            								</div>
                                                
        						  			
    						  				<div class="col-md-7 col-xs-7"><!-- Section Remove icon, edit icon-->
    						  				    <!--<a href="<?php echo base_url().index_page().'new_client/home/page_section_delete/'.$page_design['id'].'/'.$section['id'];?>">-->
    						  				        <i class="fa fa-trash section-delete-button" data-page_design_id = "<?php echo $page_design['id']; ?>" data-section_id = "<?php echo $section['id']; ?>"></i>
    						  				        <!--</a>-->
            									<a value='<?php echo $section['id']; ?>' data-toggle="tooltip" title="Edit Section Name">
        											<i id="editclickSection<?php echo $section['id']; ?>" data-id="<?php echo $section['id'];?>" value='<?php echo $section['id']; ?>' class="fa fa-edit editclickSection"></i>
        										</a>
    						  				    <span  class="btn btn-xs btn-blue pull-right btnAddPage" data-id="<?php echo $section['id']; ?>" data-toggle="tooltip" title="Add New Page">ADD PAGE</span>
                							 	
        									</div>
    									</div>
    									<!-- edit section -->
            							<div class="row padding-top-10 padding-bottom-10 margin-0-res clickedit" id="clickeditSection<?php echo $section['id']; ?>">
        									<form method="post" action="<?php echo base_url().index_page().'new_client/home/page_section_edit_section/'.$page_design['id'].'/'.$section['id']; ?>">
        										<div style="position: relative;left: 15px;top: 5px;">
        											<div class="col-md-6 col-xs-6" >
        											    <input type="text" name='editrow' maxlength="25" value="<?php echo $section['section_name'];?>" class="form-control col-md-8 input-sm " title="" required="" autocomplete="off">
        										    </div>
        										    <div class="col-md-6 col-xs-6" >
        											    <button type="submit"  name="editit" class="btn btn-sm btn-blue " id="submit_form" >Submit</button>
        										    </div>
        									    </div>
        									</form><!--This is Edit option -->
        								</div>
    									<div class="row padding-top-10 padding-bottom-10 margin-0-res">
    									    <form method="post" action="<?php echo base_url().index_page().'new_client/home/page_add_new/'.$section['id'];?>">
            									<div class="addPageDiv" id="clickshow<?php echo $section['id'] ?>">
            										<div class="col-md-6 col-xs-6">
            											<input type="text" name='page_name' placeholder="Enter Page Name" maxlength="25" class="form-control input-sm margin-top-10" title="" required="" autocomplete="off">	 	
            										</div>
            										<div class="col-md-6 col-xs-6">
            											<button type="submit"  name="add_page_order" class="btn btn-sm btn-blue margin-top-10" id="submit_form" >ADD</button>
            										</div>
            									</div>
            							 	</form>
            							</div>
            							
            							<!-- List Page details of particular section -->
            							<?php
            							    $order_data = $this->db->query("SELECT orders.id, orders.job_no, orders.id, orders.id, orders.status, order_status.name  FROM `orders`
                                                                                JOIN `order_status` ON order_status.id = orders.status
                                                                                WHERE orders.page_design_id = '".$section['id']."';")->result_array();
            							     
    						  	            if(isset($order_data)){
    						  		            foreach ($order_data as $order){ //number off pages to printed here.
    						  		                $edit_allowed_status = array(1,9,10,11);
						  		    
                						  		    if ($order['name'] == 'Selected') {
                						  				$display_status = $order['name'];
                						  				$display_status_icon = '';
                						  				$cssBG = 'style="border: 1px solid #ddd !important;background-color:black;color:white;"';
                						  				$fontColor = 'color:white;';
                						  			}elseif ($order['name'] == 'Submitted' || $order['name'] == 'Order Received'){
                						  			    if(isset($order_id) && ($order_id == $order['id'])){
                						  			        $display_status = "Submitted";
                						  			        $display_status_icon = "<i class='fa fa-check' style='font-size:12px' aria-hidden='true'></i>";
                						  				    $cssBG = 'style="border: 1px solid #ddd !important;background-color:black;color:white;"';
                						  				    $fontColor = 'color:white;';    
                						  			    }else{
                						  				    $display_status = "Submitted";
                						  				    $display_status_icon = "<i class='fa fa-check' style='font-size:12px' aria-hidden='true'></i>";
                						  				    $cssBG = 'style="border: 1px solid #ddd !important;background-color:green;color:white;"';
                						  				    $fontColor = 'color:white;';
                						  			    }
                						  			}else{
                						  			    if(isset($order_id) && ($order_id == $order['id'])){
                    						  		        $cssBG = 'style="border: 1px solid #ddd !important;background-color:black;color:white;"';
                    						  		        $fontColor = 'color:white;';
                    						  		    }else{
                    						  		        $cssBG = 'style="border: 1px solid #ddd !important;"';
                    						  		        $fontColor = '';
                    						  		    }
                    						  			$display_status = $order['name'];
                    						  			$display_status_icon = "<span class='glyphicon glyphicon-time' style='font-size:12px'></span>";
                						  			} 
        						  	?>
						  	        <div class="row border padding-top-10 padding-bottom-10 margin-0-res item-page" <?php echo $cssBG; ?>>
						  	            <a href="<?php echo base_url().index_page().'new_client/home/page_order_view_section/'.$page_design['id'].'/'.$section['id'].'/'.$order['id']; ?>">
    						  	            <div class="col-md-5 col-xs-5" ><!-- Page Name/Number -->
        						  	            <span style="<?php echo $fontColor; ?>"  value='<?php echo $order['id']; ?>'
            						  						<?php if(isset($order_id) && ($order['id'] == $order_id)){echo"selected";}?> id='selecte-page'>
        												<?php echo $order['job_no'];?>						  											  						
        									    </span>
        									</div>
                                            <div class="col-md-4 col-xs-4" ><!-- Page Status -->
        										<span style="<?php echo $fontColor; ?>"><?php echo $display_status; ?> </span>
        										
        									</div>
    						  			</a>
						  				<div class="col-md-3 col-xs-3"><!-- Page Remove icon, edit icon, status icon -->
						  				    <?php if(in_array($order['status'], $edit_allowed_status) && $section['num_pages'] != 1){ //if single page no delete option  ?>
    											<a class="pull-right padding-top-5 " value='<?php echo $order['id']; ?>' style="<?php echo $fontColor; ?>" 
        										href="<?php echo base_url().index_page().'new_client/home/page_remove_section/'.$page_design['id'].'/'.$section['id'].'/'.$order['id']; ?>" data-toggle="tooltip" title="Delete Page">
        											<i class="fa fa-trash"></i>
        										</a>
    										<?php } ?>
    										<a class="pull-right padding-top-5 margin-right-10" value='<?php echo $order['id']; ?>' data-toggle="tooltip" title="Edit Page Name" style="<?php echo $fontColor; ?>" >
    											<i id="editclick<?php echo $order['id']; ?>" data-id="<?php echo $order['id'];?>" value='<?php echo $order['id']; ?>' class="fa fa-edit editclick"></i>
    										</a>
    										<a class="pull-right padding-top-5 margin-right-10" data-toggle="tooltip" title="" style="<?php echo $fontColor; ?>" >
    										   <?php echo $display_status_icon; ?>
    									    </a>
    									</div>
    									
						  				<div class="row">
        									<form method="post" action="<?php echo base_url().index_page().'new_client/home/page_edit_section/'.$page_design['id'].'/'.$section['id'].'/'.$order['id']; ?>">
        										<div id="clickedit<?php echo $order['id']; ?>" class="clickedit " style="position: relative;left: 15px;top: 5px;">
        											<div class="col-md-6 col-xs-6" >
        											    <input  type="text" name='editrow' maxlength="25" value="<?php echo $order['job_no'];?>" class="form-control col-md-8 input-sm " title="" required="" autocomplete="off">
        										    </div>
        										    <div class="col-md-6 col-xs-6" >
        											    <button type="submit"  name="editit" class="btn btn-sm btn-blue " id="submit_form" >Submit</button>
        										    </div>
        									    </div>
        									</form><!--This is Edit option -->
        								</div>
        								
								    </div>
							<?php  
						        } 
                            }
						    ?>
						  		</div>
					         <?php
					                }
					            }
						    ?>
						  	
						  	</div>
						</div>

					</div>
					
				</div>

<!-- *********************************************** Articles Uploading *********************************************** -->
			<?php if(isset($order_id)){ ?>	
				<div class="col-sm-8">
					<div class="margin-top-20 margin-bottom-20">
						<?php echo $this->session->flashdata('item');?> 
						<div class="form-group">
							<span class="dropdown margin-left-5 text-blue pull-right">
								<p class="cursor-pointer padding-left-5" type="button" data-toggle="dropdown" id="article-view" >View uploaded files 
									<span class="caret margin-left-5" ></span>
								</p>
								<div class="table-responsive dropdown-menu ">  							 
									<table class="table table-striped table-hover" id="mytable-article">
										<tbody>
											<?php $a=0;
												if(isset($articles_name)) 
												{ 
													$i=1;  
													foreach($articles_name as $row){
											?><!--This is listed the files -->
														<tr>
															<td><?php echo $i; ?></td>
															<td>
																<a href="<?php echo base_url().$order_detail['file_path'].'/articles/'.$row;?>" target="_blank">
																    <?php echo $row?>
																</a>
															</td><!--This is path and name  option -->
															<td>
																<a href="<?php echo base_url().$order_detail['file_path'].'/articles/'.$row;?>" download target="_blank" ><i class="fa fa-download"></i></a>
															</td>
															<td>
																<input type="hidden" name="filename" id="article_name<?php echo $i;?>" value="<?php echo $row; ?>">
    															<input type="button" name="remove" value="remove" onclick="remove_art(<?php echo $i;?>)"><!--This is remove file option -->
    														</td>
														</tr>
											<?php       $a=$i++; 
													} 
												}?>
										</tbody>
									</table>
								</div>
							</span>
							
							<div id="attachments">
							    <p class="margin-bottom-5 ">Articles / Images</p>								
								<div action="<?php echo base_url().index_page()."new_client/home/page_artical_upload/".$order_id; ?>" name="file" id="files" multiple="" webkitdirectory="" class="dropzone" enctype="multipart/form-data"></div><!--This is upload file option -->
							</div>
							
						</div>
<!-- *********************************************** Ads Uploading *********************************************** -->	

						<div class="form-group">
							<span class="dropdown margin-left-5 text-blue pull-right">
								<span class="cursor-pointer padding-left-5" type="button" data-toggle="dropdown" id="ads-view">View uploaded files 
									<span class="caret margin-left-5"></span>
								</span>
								<div class="table-responsive dropdown-menu file_li">  							 
									<table class="table table-striped table-hover" id="mytable-ads">
										<tbody>
											<?php $a=0;
												if(isset($file_names1)){ 
													$i=1;  
													foreach($file_names1 as $row){
											?>
															<tr>
																<td><?php echo $i; ?></td>
																<td>
																	<a href="<?php echo base_url().$order_detail['file_path'].'/ads/'.$row;?>" target="_blank">
																	    <?php echo $row?>
																	</a>
																</td>
																<td>
																	<a href="<?php echo base_url().$order_detail['file_path'].'/ads/'.$row;?>" download target="_blank" >
																		<i class="fa fa-download"></i>
																	</a>
																</td>
																<td>
																    <input type="hidden" name="filename" id="ad_name<?php echo $i;?>" value="<?php echo $row;?>">
																	<input type="button" name="remove" value="remove" onclick="remove_ad(<?php echo $i;?>)">
																</td>
															</tr>
											<?php           
											            $a=$i++; 
													} 
												}
											?>
										</tbody>
									</table>
								</div>
							</span>
							
							<div id="attachments">
									<p class="margin-bottom-5 ">Ads</p>
								<div action="<?php echo base_url().index_page()."new_client/home/page_ads_upload/".$order_id ?>" name="file"  class="dropzone" enctype="multipart/form-data"> </div>
							</div>
						
						</div>
<!-- *********************************************** Note & Instructions *********************************************** -->
						<form method = "POST" action="<?php echo base_url().index_page()."new_client/home/page_note_section/".$page_design['id'].'/'.$section['id'].'/'.$order_id;?>">
							<div class="form-group">
								<p class="margin-bottom-0">Notes & Instructions <span class="text-red">*</span></p>
								<textarea class="form-control text-area-height"  rows="4" name="notes" required=""><?php echo $order_detail['notes']; ?></textarea>	
							</div>	
							<?php if ($order_detail['status']=='10' or $order_detail['status']=='9') {?>
								<div class="">
								<button type="submit" name="complete" class="btn  btn-blue margin-top-5 margin-bottom-20 pull-right"  >Submit <?php echo $order_detail['job_no']; ?></button>
							</div>
							 <?php }?>
							 <?php if ($order_detail['status']=='11' || $order_detail['status']=='1'){?>
								<button type="submit" name="complete" class="btn  btn-warning margin-top-5 margin-bottom-20 pull-right"  >Resubmit <?php echo $order_detail['job_no']; ?></button>
							<?php } ?>
						</form>
					
					</div>
				</div>
			<?php } ?>	
			</div>	
		</div>
	</div>	

	
<?php $this->load->view('page_design_view/footer') ?>

<script>window.SHOW_LOADING = false;</script>
<script>
			 $(document).ready(function(){
			    $('[data-toggle="tooltip"]').tooltip();
				$("#optional").hide();
				$("#clickshow").hide();
                $(".clickedit").hide();	
                $("#uplods").hide(); 
                
                $(".addPageDiv").hide();
                
				 $("#showoptional").click(function(){
					$("#optional").toggle();      
				 });

                  $("#sub").click(function(){
                    $("#uplods").show(); 
                    $("#sub").hide();     
                 });

                  $("#addclick").click(function(){
                    $("#clickshow").show();  
                    $("#addclick").hide();      
                 });
                $(".editclick").click(function(){
					var id = $(this).attr("data-id");
					//alert('ID : '+id);   
                    $("#clickedit"+id).show();  
                    $("#editclick"+id).hide();     
                 });
                //section
                $(".editclickSection").click(function(){
					var id = $(this).attr("data-id");
					//alert('ID : '+id);   
                    $("#clickeditSection"+id).show();  
                    $("#editclickSection"+id).hide();     
                 });
                 
                $("#showadvancesearch").click(function(){
                    $("#advancesearch").toggle();  
                    $("#search").toggle();          
                  });
                 
                 $("#showsearch").click(function(){
                    $("#advancesearch").toggle();  
                    $("#search").toggle();          
                  }); 
                  //add page for section
                  $(".btnAddPage").click(function(){
                    var id = $(this).attr("data-id"); 
                    $("#clickshow"+id).show();
                  });
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

 	function  remove_art(i) {
 		 var fname =$('#article_name'+i).val();
 		 $.ajax({
 		 	url:"<?php echo base_url().index_page().'new_client/home/page_remove_att/'.$order_id;?>",
 		 	data:'filename='+fname,
 		 	type:"POST",
 		 });
	}

	function  remove_ad(i) {
 		 var fname =$('#ad_name'+i).val();
 		 $.ajax({
 		 	url:"<?php echo base_url().index_page().'new_client/home/page_remove_ads/'.$order_id;?>",
 		 	data:'filename='+fname,
 		 	type:"POST",
 		 });
	}

</script>
<script>
    $(".section-delete-button").click(function(){
        var page_design_id = $(this).attr("data-page_design_id") ;
        var section_id = $(this).attr("data-section_id") ;
        if(confirm("Are you sure you want to delete this Section?")){
            $(location).prop('href', '<?php echo base_url().index_page()."new_client/home/page_section_delete/"?>'+page_design_id+'/'+section_id);
        } else {
            return false;
        }    
    });
    
	   function RefreshTablePrint() { 
		   $( "#mytable-article" ).load( "<?php //echo base_url().index_page().'new_client/home/page_order_view_section/'.$page_design['id'].'/'.$section['id'].'/'.$order_detail['id'];?> #mytable-article" );
		   $( "#mytable-ads" ).load( "<?php //echo base_url().index_page().'new_client/home/page_order_view_section/'.$page_design['id'].'/'.$section['id'].'/'.$order_detail['id'];?> #mytable-ads" );
	   }
	   $("#article-view").on("click", RefreshTablePrint);
	   $("#ads-view").on("click",RefreshTablePrint);

</script>

