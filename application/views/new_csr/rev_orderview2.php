<?php $this->load->view("new_csr/head.php"); ?>
<style>
.padding-0 {
	padding: 0 5px 0 0;
}
</style>
<script>
function Adp_confirm(){
    var X=confirm('Are You Sure ?');
	if(X==true){
    return true;
  }
else
  {
    return false;
  }
} 


$(document).ready(function(){
     $("#hidden_data").hide();
	 
	 $("#showhidden_data").click(function(){
        $("#hidden_data").toggle();      
     });
});
</script>
<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">

	<!-- BEGIN PAGE CONTENT -->
	<div class="page-content">
		<div class="container">	
			<!-- BEGIN PROFILE -->

			<div class="row margin-top-10">
				<div class="col-md-12">
					<!-- BEGIN PROFILE CONTENT -->
					<div class="profile-content">
						<div class="row">				  						   
						   <div class="col-md-12">
<?php $count = count($rev_orders); $i=0; 
	foreach($rev_orders as $rev_row){ 
	$i++; 
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
			<?php if($rev_row['pdf_path']=='none'){ ?>
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
							
								<span class="caption-subject grey-gallery">Order #<?php echo $order_id.' '.$rev_row['version']; ?>  </span>
							</div>	
							<div class="actions">
								<a onclick="goBack()" class="btn btn-default btn-circle">
								<i class="fa fa-angle-left"></i>
								<span class="hidden-480">
								Back </span>
								</a>
							</div>
                             <div class="tools margin-right-10">
								<?php if($rev_rev[0]['id']==$rev_row['id'] && $rev_rev[0]['new_slug']!='none') {?>
								<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_csr/home/rev_orders/'.$order_id;?>'" style="cursor:pointer; text-decoration: none;"><img src="images/revision.png" alt="revision"/></a>
								<?php } ?>
								<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()"></a>
							</div>
						</div>
<?php echo '<h4 style="color:#900;">'.$this->session->flashdata('message').'</h4>'; ?>							
						<div class="row portlet-body">
						   <div class="col-md-6">	
                            <div class="portlet box blue-chambray">
													<div class="portlet-title">
														<div class="caption"><i class="fa fa-gears"></i>Notes & Instructions</div>
													</div>
													<div class="portlet-body" style="min-height: 70px;">
													  <div class="margin-bottom-20">	
														<p> <?php echo $rev_row['note']; ?> </p>
														
													</div>
												</div>
						   </div>
						</div>
							<div class="col-md-6">	
                            <div class="portlet box blue-chambray">
								<div class="portlet-title">
									<div class="caption">Attachments</div>
									<div class="tools">
									<?php if($rev_row['file_path'] != 'none'){ $filepath = $rev_row['file_path']; ?>										
										<div class="actions">
             							  <form method="post" action="<?php echo base_url().index_page().'new_csr/home/zip_folder';?>">
											<input name="file_path" value="<?php echo $filepath; ?>" readonly style="display:none" />
											<input name="file_name" value="<?php echo $rev_row['order_id']; ?>" readonly style="display:none" />
											<button type="submit" type="submit" name="Submit" class="btn btn-default btn-sm">
											<i class="fa fa-cloud-download"></i>All
											</button>
										  </form>
										 </div>
										  <?php } ?>
										<!--<span><a href="#" class="font-grey-cararra"><i class="fa fa-cloud-download"></i></a></span>-->
									</div>
								</div>
							<div class="portlet-body" style="min-height: 70px;" >
							<table class="table table-scrollable table-striped table-hover">
								<tbody>
								<?php 
									if($rev_row['file_path'] != 'none'){ 
										$filepath = $rev_row['file_path'];
										$this->load->helper('directory');
										$map = glob($filepath.'/*',GLOB_BRACE);
										if($map){ foreach($map as $row1){
								?>
								<tr>
								<td><?php echo basename($row1) ?></td>
								<td class="text-right">
								<a href="<?php echo base_url().$row1; ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
								<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row1; ?>" class="font-grey-gallery"><i class="fa fa-cloud-download"></i></a>
								</td> 		  
								</tr>  
									<?php } } } ?> 
									
								<!--<?php if(isset($order_form) && file_exists($order_form)) {
										$this->load->helper('directory');
										$map_form = glob($order_form.'/*',GLOB_BRACE);
										if($map_form){ foreach($map_form as $row_form){
								?>
								<tr>
								<td><?php echo basename($row_form) ?></td>
								<td class="text-right">
									<a href="<?php echo base_url().$row_form; ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
									<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row_form; ?>" class="font-grey-gallery"><i class="fa fa-cloud-download"></i></a>
								</td>
								<?php } } } ?>
								</tr>-->
								</tbody>
							</table>  
							</div>
							</div>
							</div>

							
 					   </div>
				<?php if($rev_row['job_status']=='1' && $rev_row['status']!='5'){ ?>	   
					<div class="row">
						
						<?php if(($rev_row['question']=='' && $rev_row['answer']=='none')||($rev_row['question']!='' && $rev_row['answer']!='none')){ ?>
								
								<?php if($rev_row['job_accept']=='0' && $rev_row['order_id']!=''){ ?>
								<div class="col-md-6">
									<form method="post">
									<label for="name" class="font-green-seagreen">Choose One Option</label>
										<div class="radio-list">
											<?php foreach($rev_reason as $row){ ?>
												<label> <input type="radio" name="reason_option" id="reason_option" value="<?php echo $row['id']; ?>" required="required"><?php echo $row['name'];?></label>
											<?php } ?>
										</div>
										<div class="margin-top-15">
											<input type="text" id="rev_id" name="rev_id" value="<?php echo $rev_row['id']; ?>" readonly  style="display:none;" />
											<button type="submit" name="accept" class="btn btn-primary">Accept</button>
											<span style="margin-left:50px;" >
												<input type="checkbox" name="redesign" value="1" id="redesign"><label>Redesign</label>
											</span>
										</div>
									</form>
								</div>
								<?php }elseif($rev_row['status']=='4' && $rev_row['new_slug']!='none' && $rev_row['source_file']!='none'){ ?>
								<div class="col-md-6">
									<form method="post">										<input name="hd" value="<?php echo $hd; ?>" readonly style="display:none;" />
										<input name="rev_id" value="<?php echo $rev_row['id'];?>" readonly style="display:none;" />
										<input name="new_slug" value="<?php echo $rev_row['new_slug'];?>" readonly style="display:none;" />
										<input name="adrep" value="<?php echo $rev_row['adrep'];?>" readonly style="display:none;" />
										<input name="source_file" value="<?php echo $rev_row['source_file'];?>" readonly style="display:none;" />
										<input name="pdf_file" value="<?php echo $rev_row['pdf_file'];?>" readonly style="display:none;" />
										<input name="source_path" value="<?php echo $SourcePath;?>" readonly style="display:none;" />
										<input name="order_id" value="<?php echo $order_id;?>" readonly style="display:none;" />
										<div class="form-group"> <input type="checkbox" value="1" id="showhidden_data"><label>Note</label> </div>
										<div id="hidden_data" class="margin-bottom-10">
											<textarea name="note" rows="3" class="form-control border"></textarea>
										</div>
										<button type="submit" name="sendToadrep" class="btn green" onclick="return Adp_confirm();">Send to Adrep</button>
										<a class="btn red" href="#form_modal10" data-toggle="modal">Back To Designer<i class="fa fa-question"></i></a>
									</form>
								</div>
								<!-- Back to Designer -->
								<div id="form_modal10" class="modal fade" role="dialog" aria-labelledby="myModalLabel10" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
													<h4 class="modal-title">Sent Question To Designer</h4>
												</div>
												<div class="modal-body">
													<form  method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
													<div class="form-group">
														<div class="col-md-12">
															<textarea class="form-control" name="msg" rows="3" required/></textarea>
														</div>
													</div>
													<label>File input</label>
													<input type="file" name="file2" id="file2"/>
													<input type="text" name="sourcefile" value="<?php echo $SourcePath; ?>" style="display:none;">
													<input type="text" id="rev_id" name="rev_id" value="<?php echo $rev_row['id']; ?>" style="display:none;" />
													<div class="modal-footer">
														<button class="btn default" data-dismiss="modal" aria-hidden="true">Close</button>
														<button type="submit" name="sent_designer" class="btn red">Send</button>
													</div>
													</form>
												</div>
											</div>
										</div>
								</div>
								<?php } ?>
						<!--Question -->								
								
								<div class="col-md-6 text-right">	
									<button type="button" class="btn red" data-toggle="modal" href="#send_question">Send Question</button>
									<!--<button type="button" class="btn yellow font-grey-gallery" data-toggle="modal" href="#cancel">Cancel</button>-->
								</div>
								 <div id="send_question" class="modal fade" tabindex="-1" aria-hidden="true">
							             	<div class="modal-dialog">
									<div class="modal-content">
										<form action="<?php echo base_url().index_page().'new_csr/home/revision_question/'.$hd;?>" method="post" >
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Send Question</h4>
										</div>
										<div class="modal-body">
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
														<input type="text" id="rev_id" name="rev_id" value="<?php echo $rev_row['id']; ?>" readonly  style="display:none;" />
														<textarea class="form-control" name="question" id="question"  rows="3" required/></textarea>
									                    </div>
													</div>
												</div>
										</div>
									
										<div class="modal-footer">
											<button type="button" data-dismiss="modal" class="btn default">Close</button>
											<button type="submit" name="question_submit" class="btn red">Send Question</button>
										</div>
									
										</form>
									</div>
								</div>
								</div>
								
						<?php }else{ echo "Question sent"; } ?>
						<!--Question End-->	
						        
					</div>
		<?php } ?>
					<div class="row margin-top-15">
							<div class="col-md-6 padding-top-10">	
								   
								    <?php if($rev_row['job_status']!='1'){ ?>
									<div class="note note-danger">
										<p class="block"><strong>Order Cancelled!</strong> by <strong><?php if(isset($frontline_csr_name)){ echo $frontline_csr_name; }?></strong></p>
									</div>
									<?php }elseif($rev_row['question']!=''){ ?>
							      	 <div class="note note-danger">
										<p class="block"><strong>Question Sent!</strong> by <strong><?php if(isset($frontline_csr_name)){ echo $frontline_csr_name; }?>.</strong> Got answer by mail<strong> <a class="font-grey-gallery" href="#">click here.</a></strong></p>
									 </div>
									<?php } if($rev_row['status']=='2'){ ?>	
								    <div class="note note-info">
							      	  <p class="block"><strong>Revision Accepted By <strong><?php if(isset($csr_name)){ echo $csr_name; }?></strong> & Sent To Designer!</strong> </p>
									</div>
									<?php }elseif($rev_row['status']=='3'){ ?>	
								    <div class="note note-info">
							      	  <p class="block"><strong>IN Production!</strong> This ad designing by <strong><?php if(isset($designer_name)){ echo $designer_name; } ?>.</strong> His code is <strong> <?php if(isset($designer_code)){ echo $designer_code; } ?>.</strong></p>
									</div>
									<?php }elseif($rev_row['status']=='4' && $rev_row['source_file']!='none' && $rev_row['pdf_file']!='none'){ 
										$pdf_path = $SourcePath.'/'.$rev_row['pdf_file'];
										if(file_exists($pdf_path)){
									?>
								    <div class="note note-success">
							      	  <p class="block"><strong>QA Ready!</strong> click to view <strong><a class="font-grey-gallery" href="<?php echo $pdf_path;?>" target="_blank" style="cursor:pointer; text-decoration: none; color: red;">PDF.</a></strong></p>
							        </div>
									<?php } }elseif($rev_row['status']=='7'){ ?>
									<div class="note note-success">
							      	  <p class="block"><strong>Sent Back To Designer!</strong> </p>
							        </div>
									<?php } ?>
							</div>
								
					</div>
					
				</div>
<?php }elseif($rev_row['pdf_file']!='none'){ 
			$pdf_path = $SourcePath.'/'.$rev_row['pdf_file'];
			//$source_zip_path = glob($SourcePath.'/'.$rev_row['new_slug'].'{indd,psd}',GLOB_BRACE);
			
		//note sent
		$note_revad = $this->db->get_where('note_sent',array('order_id'=>$order_id, 'revision_id'=>$rev_row['id']))->result_array();
?>

		<div class="portlet light">			 
					  <div class="row">
							<div class="col-sm-8 col-xs-12">	
								<h4><span class="font-grey-gallery">Order #<?php echo $order_id.' '.$rev_row['version']; ?></strong>
								<!--revsion part-->
								<span><?php if($rev_rev[0]['id']==$rev_row['id'] && $rev_rev[0]['new_slug']!='none') {?>
									<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_csr/home/rev_orders/'.$order_id;?>'" style="cursor:pointer; text-decoration: none;">  &nbsp; <img src="images/revision.png" alt="revision"/></a>
									<?php } ?>
									<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()"></a>
								</span>
								<!--revsion part-->
								</h4>
							</div>
							<div class="col-sm-4 col-xs-12 text-right margin-top-10">
									<?php if($note_revad){ ?>
									<span class="margin-right-10 font-yellow tooltips" data-container="body" data-placement="bottom" data-original-title="<?php echo $note_revad[0]['note']; ?>"><i class="fa fa-warning"></i></span> 
									<?php } if(file_exists($pdf_path)){ ?>
									
								<div class="row">	
									<div class="col-xs-4 padding-0 pull-right">
									<span><a class="btn btn-default btn-sm btn-block" href="<?php echo base_url().$pdf_path; ?>" target="_blank">
									PDF</a></span>
									</div>
									<?php } ?>
									<?php 
											//zip source
											$source_file = $rev_row['source_file'];
											$map2 = $SourcePath.'/'.$source_file;
											if(file_exists($map2)){		
										?>
									<div class="col-xs-4 padding-0">		
										<form action="<?php echo base_url().'index.php/new_csr/home/zip_folder_select'?>" method="post">
												<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
												<input name="pdf_file" value="<?php echo $rev_row['pdf_file'];?>" readonly style="display:none;" />
												<input name="new_slug" value="<?php echo $rev_row['new_slug'];?>" readonly style="display:none;" />
												<input name="source_path" value="<?php echo $SourcePath;?>" readonly style="display:none;" />
												<input name="download" value="download" readonly style="display:none;" />
												<button type="submit" name="SourceDownload" class="btn btn-default btn-sm btn-block">
											Source Files
											</button>
										</form>
									</div>
										<!--<span class="margin-right-10"><a href="<?php echo base_url().$source_zip_path; ?>" class="font-grey"><i class="fa fa-cloud-upload font-blue"></i></a></span>-->
										<?php } ?>
									<div class="col-xs-4 padding-0">
										<?php if(isset($rev_order_form) && file_exists($rev_order_form)) { ?>
									<form method="post" action="<?php echo base_url().index_page().'new_csr/home/zip_folder';?>">
										<input name="file_path" value="<?php echo $rev_order_form; ?>" readonly style="display:none;" /> 
										<input name="file_name" value="<?php echo $order_id; ?>" readonly style="display:none;" />
										<button type="submit" name="Submit" class="btn btn-default btn-sm btn-block">
											Download</i>
										</button>
									</form>
								<?php } ?>
									</div>
								</div> 	
							</div>  
					 </div>
					
		</div>
	
<?php }?>
<?php } ?>


<!--designer message -->
			<?php if(isset($designer_message)) { ?>
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-basket font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold uppercase">
								Designer Message</span>
							</div>
						</div>
						<div class="portlet-body">
								<?php foreach($designer_message as $d_msg) {?>
							<div class="alert alert-block alert-info">
								<p>
								<?php echo $d_msg['message']; ?>
								</p>
							</div>
						</div>
			
					</div>	
				</div>		
			</div>
		<?php } }?>	
<!--designer message -->

		


		         <div class="portlet light">			 
					   <div class="row">
								<div class="col-sm-8 col-xs-12">	
									<h4><span class="font-grey-gallery">Order #<?php echo $order_id; ?> V1</span></h4>
								</div>
								<div class="col-sm-4 col-xs-12 text-right margin-top-10">
									<?php if(isset($note_newad)){ ?>
									<span class="margin-right-10 font-yellow tooltips" data-container="body" data-placement="bottom" data-original-title="<?php echo $note_newad['note']; ?>"><i class="fa fa-warning"></i></span> 
									<?php }
										if(isset($SourcePath) && isset($cat)){
											$this->load->helper('directory');
											$map_zip = glob($SourcePath.'/'.$cat[0]['slug'].'.{indd,psd}',GLOB_BRACE);
											$map_pdf = glob($SourcePath.'/'.$cat[0]['slug'].'.{pdf,jpg,gif,png}',GLOB_BRACE);
											//if($map){ foreach($map as $row){
											if($map_pdf){ foreach($map_pdf as $row){	
									?>
									
							<div class="row">	
								<!--<div class="col-xs-4">
										<a class="btn btn-default font-grey btn-sm" href="<?php echo $row; ?>" target="_blank">
											<i class="fa fa-file-pdf-o font-red"></i>
										</a>
								</div>-->
								<div class="col-xs-4 padding-0 pull-right">
									<span><a class="btn btn-default btn-sm btn-block" href="<?php echo $row; ?>" target="_blank">
									PDF</a></span>
								</div>
									<?php } } if($map_zip){ foreach($map_zip as $row_zip){ $source_file = basename($row_zip);  } ?>
								
								<div class="col-md-4 padding-0">
										<form action="<?php echo base_url().'index.php/new_csr/home/zip_folder_select'?>" method="post">
											<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
											<input name="new_slug" value="<?php echo $cat[0]['slug'];?>" readonly style="display:none;" />
											<input name="source_path" value="<?php echo $SourcePath;?>" readonly style="display:none;" />
											<input name="download" value="download" readonly style="display:none;" />
											<button type="submit" name="SourceDownload" class="btn btn-default btn-sm btn-block">
											Source Files
											</button>
										</form>
								</div>
								
									<!--<span class="margin-right-10"><a href="<?php echo $row; ?>" class="font-grey"><i class="fa fa-cloud-upload font-blue"></i></a></span>-->
									<?php } } ?>
								<div class="col-md-4 padding-0 pull-right">
					
								<?php if(isset($order_form) && file_exists($order_form)) { ?>
									<form method="post" action="<?php echo base_url().index_page().'new_csr/home/zip_folder';?>">
										<input name="file_path" value="<?php echo $order_form; ?>" readonly style="display:none;" /> 
										<input name="file_name" value="<?php echo $order_id; ?>" readonly style="display:none;" />
										<button type="submit" name="Submit" class="btn btn-default btn-sm btn-block">
											Download</i>
										</button>
                             			
									</form>
								<?php } ?>
					
						
								</div>	
							<div>		
								</div>
						</div>
					
				</div>

				    	</div>
					<!-- END PROFILE CONTENT -->
			    	</div>
		    	</div>
			<!-- END PROFILE -->
			</div>
	   
	         
	   </div>
	</div>
	</div>
	<!-- END PAGE CONTENT -->
	
	
</div>
<!-- END PAGE CONTAINER -->
<?php $this->load->view("new_csr/foot.php"); ?>
