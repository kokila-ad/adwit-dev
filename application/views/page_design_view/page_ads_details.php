<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('new_client/header') ?>
<div id="main">
<section>
      <div class="container margin-top-40 center">                        
		 <a href="<?php echo base_url().index_page().'new_client/home/dashboard';?>" class="btn btn-sm btn-dark btn-outline margin-right-5">Ads</a>
		
		   <a href="<?php echo base_url().index_page().'new_client/home/page_dashboard';?>" class="btn btn-sm btn-dark btn-outline btn-active">Pagination</a>
	  </div>
   </section>
<section>
  
</section>
<?php echo $this->session->flashdata('item');?> 
<?php echo $this->session->flashdata('message');?> 
<section>
    <div class="container">
        <div class="row margin-bottom-10">  		 
				<div class="col-md-7"> </div>
				<div class="col-md-5 col-sm-12 col-xs-12">
					<div id="search">
						<div class="row">
							<div class="col-md-8 col-sm-8 col-xs-8 padding-right-0"></div>
							 <div class="col-md-4 col-sm-4 col-xs-4 padding-left-0 right">
								<a href="<?php echo base_url().index_page()."new_client/home/page_dashboard/"?>" class="text-blue right"><i class="fa fa fa-angle-double-left"></i> back</a>
							</div>
						 </div>	
					</div>
				</div>					 
		</div>  
		<div class="row">	 			  
			  <div class="col-md-12 margin-top-20">
	    <?php if(isset($page_design['id']) && !isset($page_revision[0]['id'])){ ?>
				 <div class="table-responsive border padding-15">
				 <?php   
				        $status_name = $this->db->get_where('page_design_status',array('id' => $page_design['status']))->row_array();
						$page_design_zip = $page_design['zip'];
						$page_design_pdf = 'page_pdf/'.$page_design['id'].'/'.$page_design['pdf'];
						
						echo 'Pagination Id - '.$page_design['id'];
				 ?>
				 <button class="btn btn-xs btn-success padding-5">Approve</button>
				 <span  class="btn btn-xs btn-blue pull-right" id="addclick" data-toggle="tooltip" title="Add New Page">
						  			Add New Page
						  		</span>
							 	<form method="post" action="<?php echo base_url().index_page().'new_client/home/page_add/'.$id; ?>">
									<div class="row" id="clickshow">
										<div class="col-md-6">
											<input type="text" name='addrow' placeholder="Enter New Page Name" class="form-control input-sm margin-top-10" title="" required="" autocomplete="off">	 	
										</div>
										<div class="col-md-6">
											<button type="submit"  name="add" class="btn btn-sm btn-blue margin-top-10" id="submit_form" >Submit</button>
										</div>
									</div>
							 	</form><!--This is Add option -->
							 	
				 </div>
				<div class="table-responsive border padding-15">
				    <table class="table table-striped table-bordered table-hover" id="example1">
						<thead>
							<tr>
								<td>Page Name</td>
								<td></td>
						   </tr>  									
						</thead>
						<tbody>
						<?php foreach($pages as $p){ ?>
						    <tr>
						        <td><a href="<?php echo base_url().index_page().'new_client/home/view_pages/'.$page_design['id']; ?>"><?php echo $p['page_no']; ?></a></td>
						        <td>
						            <?php if($p['approve'] == 0){ ?>
						                <button class="btn btn-xs btn-success pull-right padding-5 approve" data-id="<?php echo $p['id']; ?>" id="approve<?php echo $p['id']; ?>">Approve</button>
						            <?php } ?>
						        </td>
						    </tr>
					    <?php } ?>
					    </tbody> 
				    </table>
				</div>
		<?php }elseif(isset($page_revision[0]['id'])){ ?>
			 
				<div class="table-responsive border padding-15">
					<table class="table table-striped table-bordered table-hover" id="example1">
						<thead>
							<tr>
								<td>Pagination ID</td>
								<td>Publication / Edition Name</td>
								<td>Version</td>
								<td>Status</td>
								<td>PDF</td>
								<td>Source</td>
						   </tr>  									
						</thead>
						<tbody>	
						<?php
						if(isset($page_design['id'])){
							$status_name = $this->db->get_where('page_design_status',array('id' => $page_design['status']))->row_array();
							$page_design_zip = $page_design['zip'];
							$page_design_pdf = 'page_pdf/'.$page_design['id'].'/'.$page_design['pdf'];
						?>
							<tr>
								<td><?php echo $page_design['id']; ?></td>
								<td><?php echo $page_design['unique_job_name']; ?></td>
								<td><?php echo 'V1'; ?></td>
								<td><?php echo $status_name['name']; ?></td>
								<td>
									<?php if($page_design['pdf'] != NULL && file_exists($page_design_pdf)){ ?>
										
									<a target="_blank" href="<?php echo base_url().$page_design_pdf;?>" data-toggle="tooltip" data-original-title="pdf">
											<img class="action-img" src="<?php echo base_url(); ?>assets/new_client/img/pdf.png">
									</a>
									
									<?php	
									}else{ echo ''; }
									?>
								</td>
								<td>
									<?php 
									if($page_design['zip'] != NULL && file_exists($page_design_zip)){
										$dirhandle = opendir($page_design_zip);    //open the directry using FILEPATH 
										while ($file = readdir($dirhandle))  // read the FILEPATH
										{
											$filename = basename($file);
											$ext = pathinfo($filename, PATHINFO_EXTENSION);
											if ($ext == 'zip'){ //in filepath location get filename 
											
									?>
												<a target="_blank" href="<?php echo base_url().$page_design_zip.'/'.$filename;?>" data-toggle="tooltip" data-original-title="SourceFile">
												<?php echo $filename; ?>
												</a>
									<?php
											}
										}
									}else{ echo ''; } 
									?>
								</td>
							</tr>
						<?php } ?>
				
				<!-- Revision Details List -->
				
						<?php
						if(isset($page_revision[0]['id'])){
							foreach($page_revision as $page_rev){
								$page_design = $this->db->query("SELECT * FROM `page_design` WHERE page_design.id = '".$page_rev['pd_id']."' ;")->row_array();
								$status_name = $this->db->get_where('page_rev_status',array('id' => $page_rev['status']))->row_array();
								$page_design_zip = $page_rev['zip_path'];
								$page_design_pdf = 'page_pdf/'.$page_design['id'].'/'.$page_rev['pdf_path'];
						?>
							<tr>
								<td><?php echo $page_rev['pd_id']; ?></td>
								<td><?php echo $page_design['unique_job_name']; ?></td>
								<td><?php echo $page_rev['revision_version']; ?></td>
								<td><?php echo $status_name['name']; ?></td>
								<td>
									<?php if($page_rev['pdf_path'] != NULL && file_exists($page_design_pdf)){ ?>
										
									<a target="_blank" href="<?php echo base_url().$page_design_pdf;?>" data-toggle="tooltip" data-original-title="pdf">
											<img class="action-img" src="<?php echo base_url(); ?>assets/new_client/img/pdf.png">
									</a>
									
									<?php	
									}else{ echo ''; }
									?>
								</td>
								<td>
									<?php 
									if($page_rev['zip_path'] != NULL && file_exists($page_design_zip)){
										$dirhandle = opendir($page_design_zip);    //open the directry using FILEPATH 
										while ($file = readdir($dirhandle))  // read the FILEPATH
										{
											$filename = basename($file);
											$ext = $ext = pathinfo($filename, PATHINFO_EXTENSION);
											if ($ext == 'zip'){ //in filepath location get filename 
											
									?>
												<a target="_blank" href="<?php echo base_url().$page_design_zip.'/'.$filename;?>" data-toggle="tooltip" data-original-title="SourceFile">
												<?php echo $filename; ?>
												</a>
									<?php
											}
										}
									}else{ echo ''; } 
									?>
								</td>
							</tr>
						<?php } } ?>
						
					   </tbody>
					</table>
				</div>
						
		<?php } ?>		 
			 </div>
	  	  </div>
        </div>
	</div>
</section>
</div>
<!-- modal pop up window -->
    <div class="modal fade" id="full" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-full">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <div class="modal-title">
                        <?php echo "Page Name"; ?> 
                        <i class="fa fa-trash"></i>
                	    <i class="fa fa-edit" id="editclick"></i>
                	        <div id="clickedit" class="clickedit">
							    <input  type="text" name='editrow'  value="<?php //echo $pag['page_no'];?>" class="form-control col-md-8 input-sm " title="" required="">
								<button type="submit"  name="editit" class="btn btn-xs btn-blue margin-bottom-15" id="submit_form" >Submit</button>
							</div>
                    </div>
                </div>
                <div class="modal-body" style="width:100%;height:100%;">
                   <div class="container">
                    
            	     <div class="row">
            	          <!-- Articles -->
            	         <div class="col-xs-12 col-sm-12 col-md-12">
            	            <div id="attachments">
    							<p class="margin-bottom-5 ">Articles / Images</p>								
    								<div style="width:500px;height:100px;" action="<?php echo base_url().index_page()."new_client/home/page_artical_upload/"; ?>" name="file" class="dropzone" enctype="multipart/form-data">
    								    <!--This is upload file option -->
    								</div>
    						</div>   
            	         </div>
            	          <!-- Ads -->
            	         <div class="col-xs-12 col-sm-12 col-md-12">
            	            <div id="attachments">
									<p class="margin-bottom-5 ">Ads </p>
								<div style="width:500px;height:100px;" action="<?php echo base_url().index_page()."new_client/home/page_ads_upload/" ?>" name="file"  class="dropzone" enctype="multipart/form-data"> </div>
							</div>  
            	         </div>
            	         <!-- Notes&Instructions -->
            	        <div class="col-xs-12 col-sm-12 col-md-12" style="width:500px;height:100px;">
                    	    <form method = "POST" action="<?php //echo base_url().index_page()."new_client/home/page_note/".$id.'/'.$pid;?>">
    							<div class="form-group">
    								<p class="margin-bottom-0">Notes & Instructions <span class="text-red">*</span></p>
    								<textarea class="form-control text-area-height"  rows="4" name="notes" required=""><?php //echo $pageid['note_instructions']; ?></textarea>	
    							</div>	
    							<button type="submit" name="complete" class="btn  btn-blue margin-top-5 margin-bottom-20"  >Submit</button>
    						</form>
						</div>
            	     </div>
            	     
            	    </div>
                </div>
            </div>
        </div>
    </div>
<?php $this->load->view('new_client/privacy_footer') ?>
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
                $("#editclick").click(function(){
					  
                    $("#clickedit").toggle();  
                   // $("#editclick").hide();     
                 });

                 
			  });
			  
						
</script>
<script type="text/javascript">
			$(document).ready(function(){
				$("#add-page").click(function(){
				    $('#full').modal('show');
				});
				
				//approve On click
				$(".approve").click(function(){
				    var id = $(this).data('id');
				    var btn_id = 'approve'+id;
				    //alert("id "+id);
				    $.ajax({
				        url : "<?php echo base_url().index_page().'new_client/home/page_approve/'.$page_design['id']; ?>",
				        data : { id:id },
				        type : 'POST',
				        success : function(response){ //alert(response); 
				                        $('#'+btn_id).hide(); 
				            
				                 }
				        });
				});
			});
			
</script>
