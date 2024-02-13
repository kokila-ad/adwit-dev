<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('new_client/header');
?>
    <style>
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
			    <p class="text-grey"><span>Publication/Edition Name: <span class="text-dark"><?php echo $page_design_page_count['unique_job_name']; ?></span></span></p>
				<div class="col-sm-4 padding-division padding-top-20">
					<div class="row">
						<div class="list-group">
						  	<a class="list-group-item active main-color-bg margin-0-res" >Select page
						  		<span  class="btn btn-xs btn-blue pull-right" id="addclick" data-toggle="tooltip" title="Add New Page">
						  			ADD 
						  		</span>
							 	<form method="post" action="<?php echo base_url().index_page().'new_client/home/page_add/'.$id.'/'.$pid?>">
									<div class="row" id="clickshow">
										<div class="col-md-6 col-xs-6">
											<input type="text" name='addrow' placeholder="Enter Page Name" class="form-control input-sm margin-top-10" title="" required="">	 	
										</div>
										<div class="col-md-6 col-xs-6">
											<button type="submit"  name="add" class="btn btn-sm btn-blue margin-top-10" id="submit_form" >Submit</button>
										</div>
									</div>
							 	</form><!--This is Add option -->
						  	</a>
						  	<div class="list-group_scroll ">
						  	<?php 
						  		foreach ($orders as $pag){ //number off pages to printed here.
						  		    $edit_allowed_status = array(1,9,10,11);
						  		    
						  			
						  		    
						  	?>
						  	<?php
						  		    if ($pag['name'] == 'Selected') {
						  				$display_status = $pag['name'];
						  				$display_status_icon = '';
						  				$cssBG = 'style="border: 1px solid #ddd !important;background-color:black;color:white;"';
						  				$fontColor = 'color:white;';
						  			}elseif ($pag['name'] == 'Submitted' || $pag['name'] == 'Order Received'){
						  			    if($pid == $pag['id']){
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
						  			    if($pid == $pag['id']){
    						  		        $cssBG = 'style="border: 1px solid #ddd !important;background-color:black;color:white;"';
    						  		        $fontColor = 'color:white;';
    						  		    }else{
    						  		        $cssBG = 'style="border: 1px solid #ddd !important;"';
    						  		        $fontColor = '';
    						  		    }
    						  			$display_status = $pag['name'];
    						  			$display_status_icon = "<span class='glyphicon glyphicon-time' style='font-size:12px'></span>";
						  			} 
						  	?>
						  	        <div class="row border padding-top-10 padding-bottom-10 margin-0-res" <?php echo $cssBG; ?>>
						  	            <a href="<?php echo base_url().index_page().'new_client/home/page_order_view/'.$id.'/'.$pag['id']; ?>">
    						  	            <div class="col-md-5 col-xs-5" ><!-- Page Name/Number -->
        						  	            <span style="<?php echo $fontColor; ?>"  value='<?php echo $pag['id']; ?>'
            						  						<?php if($pag['id'] == $pid){echo"selected";}?> id='selecte-page'>
        												<?php echo $pag['job_no'];?>						  											  						
        									    </span>
        									</div>
                                            <div class="col-md-4 col-xs-4" ><!-- Page Status -->
        										<span style="<?php echo $fontColor; ?>"><?php echo $display_status; ?> </span>
        										
        									</div>
    						  			</a>
						  				<div class="col-md-3 col-xs-3"><!-- Page Remove icon, edit icon, status icon -->
						  				    <?php if(in_array($pag['status'], $edit_allowed_status) && $page_design_page_count['No_of_pages'] != 1){ //if single page no delete option  ?>
    											<a class="pull-right padding-top-5 " value='<?php echo $pag['id']; ?>' style="<?php echo $fontColor; ?>" 
        										href="<?php echo base_url().index_page().'new_client/home/page_remove/'.$id.'/'.$pag['id']; ?>" data-toggle="tooltip" title="Delete Page">
        											<i class="fa fa-trash"></i>
        										</a>
    										<?php } ?>
    										<a class="pull-right padding-top-5 margin-right-10" value='<?php echo $pag['id']; ?>' data-toggle="tooltip" title="Edit Page Name" style="<?php echo $fontColor; ?>" >
    											<i id="editclick<?php echo $pag['id']; ?>" data-id="<?php echo $pag['id'];?>" value='<?php echo $pag['id']; ?>' class="fa fa-edit editclick"></i>
    										</a>
    										<a class="pull-right padding-top-5 margin-right-10" data-toggle="tooltip" title="" style="<?php echo $fontColor; ?>" >
    										   <?php echo $display_status_icon; ?>
    									    </a>
    									</div>
    									
						  				<div class="row " >
        									<form method="post" action="<?php echo base_url().index_page().'new_client/home/page_edit/'.$id.'/'.$pag['id']; ?>">
        										<div id="clickedit<?php echo $pag['id']; ?>" class="clickedit " style="position: relative;left: 15px;top: 5px;">
        											<div class="col-md-6 col-xs-6" >
        											    <input  type="text" name='editrow'  value="<?php echo $pag['job_no'];?>" class="form-control col-md-8 input-sm " title="" required="">
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
						    ?>
						  	</div>
						</div>

					</div>
					<!--<form method = "POST" action="<?php echo base_url().index_page()."new_client/home/page_complete_orders/".$id.'/'.$pid;?>">
							<div class="row">
								<button type="submit" name="complete_order" class="btn  btn-danger pull-left" value="complete"<?php if ($order['status']=='10' or $order['status']=='9'){?>disabled title="Submit All Pages Then complete the order..!" <?php }?>>Complete Order</button>
							</div>
							
						</form>-->
				</div>

<!-- *********************************************** Articles Uploading *********************************************** -->
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
													foreach($articles_name as $row)
													{?><!--This is listed the files -->
														<tr>
															<td><?php echo $i; ?></td>
															<td>
																<a href="<?php echo base_url().$order['file_path'].'/articles/'.$row;?>" target="_blank">
																    <?php echo $row?>
																</a>
															</td><!--This is path and name  option -->
															<td>
																<a href="<?php echo base_url().$order['file_path'].'/articles/'.$row;?>" download target="_blank" ><i class="fa fa-download"></i></a>
															</td>
															<td>
																<!--<a href="<?php echo base_url().index_page().'new_client/home/page_order_view/'.$id.'/'.$pid; ?>">-->
    																<input type="hidden" name="filename" id="article_name<?php echo $i;?>" value="<?php echo $row; ?>">
    																<input type="button" name="remove" value="remove" onclick="remove_art(<?php echo $i;?>)"><!--This is remove file option -->
    														<!--	</a>-->
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
								<div action="<?php echo base_url().index_page()."new_client/home/page_artical_upload/".$pid; ?>" name="file" id="files" multiple="" webkitdirectory="" class="dropzone" enctype="multipart/form-data"></div><!--This is upload file option -->
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
												if(isset($file_names1)) 
													{ 
														$i=1;  
														foreach($file_names1 as $row) 
														{?>
															<tr>
																<td><?php echo $i; ?></td>
																<td>
																	<a href="<?php echo base_url().$order['file_path'].'/ads/'.$row;?>" target="_blank">
																	    <?php echo $row?>
																	</a>
																</td>
																<td>
																	<a href="<?php echo base_url().$order['file_path'].'/ads/'.$row;?>" download target="_blank" >
																		<i class="fa fa-download"></i>
																	</a>
																</td>
																<td>
																	<!--<a href="<?php echo base_url().index_page().'new_client/home/page_order_view/'.$id.'/'.$pid; ?>">-->
																	    <input type="hidden" name="filename" id="ad_name<?php echo $i;?>" value="<?php echo $row;?>">
																	    <input type="button" name="remove" value="remove" onclick="remove_ad(<?php echo $i;?>)">
																    <!--</a>-->
																</td>
															</tr>
											<?php           $a=$i++; 
														} 
													}?>
										</tbody>
									</table>
								</div>
							</span>
							<div id="attachments">
									<p class="margin-bottom-5 ">Ads</p>
								<div action="<?php echo base_url().index_page()."new_client/home/page_ads_upload/".$pid ?>" name="file"  class="dropzone" enctype="multipart/form-data"> </div>
							</div>
						</div>
<!-- *********************************************** Note & Instructions *********************************************** -->
						<form method = "POST" action="<?php echo base_url().index_page()."new_client/home/page_note/".$id.'/'.$pid;?>">
							<div class="form-group">
								<p class="margin-bottom-0">Notes & Instructions <span class="text-red">*</span></p>
								<textarea class="form-control text-area-height"  rows="4" name="notes" required=""><?php echo $order['notes']; ?></textarea>	
							</div>	
							<?php if ($order['status']=='10' or $order['status']=='9') {?>
								<div class="">
								<button type="submit" name="complete" class="btn  btn-blue margin-top-5 margin-bottom-20 pull-right"  >Submit <?php echo $order['job_no']; ?></button>
							</div>
							 <?php }?>
							 <?php if ($order['status']=='11' || $order['status']=='1'){?>
								<button type="submit" name="complete" class="btn  btn-warning margin-top-5 margin-bottom-20 pull-right"  >Resubmit <?php echo $order['job_no']; ?></button>
							<?php } ?>
						</form>
						
					</div>
				</div>	
			</div>	
		</div>
	</div>	

	
<?php $this->load->view('new_client/privacy_footer') ?>
<!--<script>
    window.onload = function(){
	var output = document.getElementById('output');

	// Detect when the value of the files input changes.
	document.getElementById('files').onsubmit = function(e) { alert('hello');
		// Retrieve the file list from the input element
		//uploadFiles(e.target.files);
		
		// Outputs file names to div id "output"
        output.innerText = "";
		for (var i in e.target.files)
			output.innerText  = output.innerText + e.target.files[i].webkitRelativePath+"\n";
	}
}
</script>-->
<script>window.SHOW_LOADING = false;</script>
<script>
			 $(document).ready(function(){
			    $('[data-toggle="tooltip"]').tooltip();
				 $("#optional").hide();
					$("#clickshow").hide();
                    $(".clickedit").hide();	
                     $("#uplods").hide();    
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

                $("#showadvancesearch").click(function(){
                    $("#advancesearch").toggle();  
                    $("#search").toggle();          
                  });
                 
                 $("#showsearch").click(function(){
                    $("#advancesearch").toggle();  
                    $("#search").toggle();          
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
 		 	url:"<?php echo base_url().index_page().'new_client/home/page_remove_att/'.$pid;?>",
 		 	data:'filename='+fname,
 		 	type:"POST",
 		 });
	}

	function  remove_ad(i) {
 		 var fname =$('#ad_name'+i).val();
 		 $.ajax({
 		 	url:"<?php echo base_url().index_page().'new_client/home/page_remove_ads/'.$pid;?>",
 		 	data:'filename='+fname,
 		 	type:"POST",
 		 });
	}

</script>
<script>
	   function RefreshTablePrint() { 
		   $( "#mytable-article" ).load( "<?php echo base_url().index_page()."new_client/home/page_order_view/".$id."/".$pid;?> #mytable-article" );
		   $( "#mytable-ads" ).load( "<?php echo base_url().index_page()."new_client/home/page_order_view/".$id."/".$pid;?> #mytable-ads" );
	   }
	   $("#article-view").on("click", RefreshTablePrint);
	   $("#ads-view").on("click",RefreshTablePrint);

</script>

