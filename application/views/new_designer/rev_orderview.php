<?php
       $this->load->view("new_designer/head"); 
?>
<style>
	textarea {
		resize: none;
	}
	.note-grey, .note-grey i {
		background-color: #f3f5f6 !important;
		color: #b8b4b4 !important;
		border-color: #d7d7d7 !important;
		}
</style>
<script>
	 $(document).ready(function(){
	 $("#message").hide();
	 $("#exrev").hide();
	 $("#folder").hide();
 	 
	$("#show_message").click(function(){
	$("#message").toggle();  	
	 });
	 
	$("#show_exrev").click(function(){
	$("#exrev").toggle();  	
	 });
	  
	$("#show_links").click(function(){
	$("#links").toggle();  	
	});
	  
	$("#show_fonts").click(function(){
	$("#fonts").toggle();  	
	});
	
	$("#show_folder").click(function(){
	$("#folder").show();  
	$("#upload").toggle();  	
	});
	
	$("#show_upload").click(function(){
	$("#upload").show();
	$("#folder").toggle();  
	});
	  	  
});
 </script>

<script>
Dropzone.options.dropzonepsd = {
	init: function() {
		this.on("sending", function(file)
		{ 
			var string1_value = $(slug_name).val() + ".psd";
			var string2_value = file.name;
			if(string1_value != string2_value)
			{
				alert("Wrong file. File will be removed");
				this.removeFile(file);
			}		
		 });
	}
};

Dropzone.options.dropzoneindd = {
	init: function() {
		this.on("sending", function(file) 
		{ 
			var string1_value = $(slug_name).val() + ".indd";
			var string2_value = file.name;
			if(string1_value != string2_value)
			{
				alert("Wrong file. File will be removed");
				this.removeFile(file);
			}
		 });
	}
};

Dropzone.options.dropzoneimages = {
	init: function() {
		this.on("sending", function(file)
		{ 
			 var string1_value = $(slug_name).val();
			 var input_file_value = file.name;
			 var string2_value = input_file_value.substr(0, input_file_value.lastIndexOf('.'));
			if(string1_value != string2_value )
			{
				alert("Wrong file. File will be removed");
				this.removeFile(file);
			}
		 });
	}
};

Dropzone.options.dropzonepdf = {
	init: function() {
		this.on("sending", function(file)
		{ 
			var string1_value = $(slug_name).val() + ".pdf";
			var string2_value = file.name;
			if(string1_value != string2_value)
			{
				alert("Wrong file. File will be removed");
				this.removeFile(file);
			}
		 });
	}
};
</script>
<div class="page-container">
   <div class="page-content">
	<div class="container">
		<div class="row margin-top-10">
			<div class="col-md-12">
<?php $count = count($rev_orders); $prev=$count-1; $i=0; foreach($rev_orders as $rev_row){ $i++; ?>	
<!----START: Status1----->	
<?php if($rev_row['pdf_path'] == 'none') { ?>			
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light">
					<div class="portlet-title  margin-top-10">
						<div class="row static-info">
							<div class="col-md-8 value">Revision #<?php echo $order_id ;?> <?php echo $rev_row['version']; ?><small> &nbsp; (<?php echo $rev_row['date']; ?>)</small>
							</div>
							<?php if($rev_row['status'] == '4' && $rev_row['status'] != '7' && $rev_row['source_file']!='none' && $rev_row['pdf_file']!='none'){ ?>
							<div class="col-md-4">
								<div class="row">
									<?php  if(isset($sourcefile) && $rev_row['source_file']!='none' && $rev_row['pdf_file']!='none'){ 
									//PDF File View & Download
									$map1 = $sourcefile.'/'.$rev_row['pdf_file'];
									if(file_exists($map1)){									
									?>
									<div class="col-xs-4 padding-0 pull-right">
										<a class="btn btn-default btn-sm btn-block" href="<?php echo base_url()?><?php echo $map1 ;?>" target="_blank">PDF</a>
									</div>
									<?php } ?>
									<?php //zip source
											$source_file = $rev_row['source_file'];
											$map2 = $sourcefile.'/'.$source_file;
											if(file_exists($map2)){		
									?>
									<div class="col-md-4 padding-0 pull-right">
										<form action="<?php echo base_url().'index.php/new_designer/home/zip_folder_select'?>" method="post">
											<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
											<input name="pdf_file" value="<?php echo $rev_row['pdf_file'];?>" readonly style="display:none;" />
											<input name="new_slug" value="<?php echo $rev_row['new_slug'];?>" readonly style="display:none;" />
											<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
											<input name="download" value="download" readonly style="display:none;" />
											<button type="submit" name="SourceDownload" class="btn btn-default btn-sm btn-block">Package</button>
										</form>
									</div>
									<?php } } ?>	
								</div>
							</div>
							<?php } ?>
						</div>
					</div>
				<div class="portlet-body">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="portlet blue-hoki box">
								<div class="portlet-title">
									<div class="caption">Instructions</div>
								</div>
								<div class="portlet-body">
									<div class="row static-info">
										<div class="col-md-12 margin-top-20 margin-bottom-10"> <?php $rev_row['note'] = str_replace(PHP_EOL,'<br/>', $rev_row['note']); 
											echo $rev_row['note'];?>
										</div>
									</div>
								</div>				
							</div>
						</div>	
						<div class="col-md-6 col-sm-12">
							<div class="portlet blue-hoki box">
								<div class="portlet-title">
									<div class="caption">Downloads</div>
										<div class="tools">
											<?php if($rev_row['file_path']!='none') { $filepath = $rev_row['file_path']; ?>
												<form method="post" action="<?php echo base_url().index_page().'new_designer/home/zip_folder';?>">
												<input name="file_path" value="<?php echo $filepath; ?>" readonly style="display:none;" /> 
												<input name="file_name" value="<?php echo $rev_row['order_id']; ?>" readonly style="display:none;" />
												<button type="submit" name="Submit" class="btn bg-blue-hoki btn-xs"><i class="fa fa-cloud-download"></i></button>
												</form>
											<?php } ?>
										</div>
								</div>
								<div class="portlet-body">
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
													<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row1; ?>" class="font-grey-gallery"><i class="fa fa-cloud-download"></i></a></span>							
												</td> 		  
											</tr>  
								<?php } } } ?> 
										</tbody> 
									</table>
								</div>				
							</div>
						</div>
						<?php if($rev_row['new_slug'] == 'none'){ ?>
						<div class="col-md-12">
							<form name="myform" method="post" >
								<button type="submit" name="create_slug" class="btn bg-green">Create Slug</button>
								<input name="id" value="<?php echo $rev_row['id'];?>" readonly style="display:none;" />
								<input name="order_id" value="<?php echo $rev_row['order_id'];?>" readonly style="display:none;" />
								<input name="prev_slug" value="<?php echo $rev_row['order_no'];?>" readonly style="display:none;" />
								<input name="version" value="<?php echo $rev_row['version'];?>" readonly style="display:none;" />
							</form>
						</div>
						<?php } ?>
					</div>	
				</div>
			</div>
		</div>
	</div>
<?php } ?>	
<!----- END: Status1 ----->

<?php if(($rev_row['status'] < '4') && ($rev_row['new_slug'] != 'none')){ ?>
	
			<div class="row">
				<!--- Start : File Upload --->
				<div class="col-md-6">
					<div class="portlet light">
					 <div class="portlet-title">
						<div class="row">
							<div class="static-info col-md-8">    
								<span class="word-break"><?php echo $rev_row['new_slug']; ?></span><br>
								<small class="font-red font-xs">(Copy this slug &amp; paste it into the design document)</small>
							</div>
							<div class="col-md-4 margin-top-5 text-right">
							<?php if(isset($sourcefile)) { 
									$map2 = glob($sourcefile.'/'.$rev_row['new_slug'].'.{zip}',GLOB_BRACE); 
										if($map2){ 
										foreach($map2 as $row_map2){ $source_file = basename($row_map2); } ?>
											<form action="<?php echo base_url().'index.php/new_designer/home/zip_folder_select'?>" method="post">
												<input name="source_file" value="<?php echo $source_file;?>" readonly="" class="hidden" />
												<input name="pdf_file" value="<?php echo $rev_row['pdf_file'];?>" readonly="" class="hidden" />
												<input name="new_slug" value="<?php echo $rev_row['new_slug'];?>" readonly="" class="hidden" />
												<input name="source_path" value="<?php echo $sourcefile;?>" readonly="" class="hidden" />
												<input name="download" value="download" readonly="" class="hidden" />
												<button type="submit" name="SourceDownload" class="btn btn-default btn-sm">Package</button>
											</form>
							<?php } } ?>
							</div>
						</div>
					</div>
					<div class="portlet-body margin-top-10" id="upload">
					<?php echo '<h4 style="color:#900;">'.$this->session->flashdata('file_message').'</h4>'; ?>
						<div class="scroller" style="height:200px" data-always-visible="1" data-rail-visible="0">
							<div class="row">									
								<div class="col-md-6 col-sm-6 col-xs-12 margin-bottom-15">	
								  <div class="row no-space border-dashed">
										<div class="col-md-4 col-sm-3 col-xs-4 no-space">	
											<img class="padding-6" src="assets/new_designer/img/indd.jpg" alt="indd" width="100%">
										</div>	
										<?php if($orders[0]['order_type_id']=='1'){ ?>
										<div class="col-md-8 col-sm-9 col-xs-8 no-space">	
											<form action="<?php echo base_url().index_page().'new_designer/home/rev_new_fileuploads/'.$order_id; ?>"  id="dropzonepsd" class="dropzone" method="post">
												<input type="hidden" name="slug_name" id="slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $rev_row['new_slug'];  ?>">
												<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="psd">
												<input type="text" name="rev_id" value="<?php  echo $rev_row['id']; ?>" style="display:none;">
												<input type="hidden" name="cat_slug" class="form-control margin-bottom-15" value="<?php echo $cat[0]['slug']; ?>">
												<div class="dz-default dz-message margin-top-20">
													<span>PSD File</span>
												</div>
											</form>
										</div>
										<?php } else{ ?>
										<div class="col-md-8 col-sm-9 col-xs-8 no-space">	
											<form action="<?php echo base_url().index_page().'new_designer/home/rev_new_fileuploads/'.$order_id; ?>"  id="dropzoneindd" class="dropzone" method="post">
												<input type="hidden" name="slug_name" id="slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $rev_row['new_slug'];  ?>">
												<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="indd">
												<input type="text" name="rev_id" value="<?php  echo $rev_row['id']; ?>" style="display:none;">
												<input type="hidden" name="cat_slug" class="form-control margin-bottom-15" value="<?php echo $cat[0]['slug']; ?>">
												<div class="dz-default dz-message margin-top-20">
													<span>Indesign File</span>
												</div>
											</form>
										</div>
										<?php } ?>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12 margin-bottom-15">	
								  <div class="row no-space border-dashed">
										<div class="col-md-4 col-sm-3 col-xs-4 no-space">	
											<img class="padding-6" src="assets/new_designer/img/pdf.jpg" alt="indd" width="100%">
										</div>	
										<?php if($orders[0]['order_type_id']=='1'){ ?>
										<div class="col-md-8 col-sm-9 col-xs-8 no-space">	
											<form action="<?php echo base_url().index_page().'new_designer/home/rev_new_fileuploads/'.$order_id; ?>"   id="dropzoneimages" class="dropzone" method="post">
												<input type="hidden" name="slug_name" id="slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $rev_row['new_slug'];?>">
												<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="images">
												<input type="text" name="rev_id" value="<?php  echo $rev_row['id']; ?>" style="display:none;">
												<input type="hidden" name="cat_slug" class="form-control margin-bottom-15" value="<?php echo $cat[0]['slug']; ?>">
												<div class="dz-default dz-message margin-top-20">
													<span>Image File</span>
												</div>
											</form>
										</div>
										<?php } else{ ?>
										<div class="col-md-8 col-sm-9 col-xs-8 no-space">	
											<form action="<?php echo base_url().index_page().'new_designer/home/rev_new_fileuploads/'.$order_id; ?>"   id="dropzonepdf" class="dropzone" method="post">
												<input type="hidden" name="slug_name" id="slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $rev_row['new_slug'];?>">
												<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="pdf">
												<input type="text" name="rev_id" value="<?php  echo $rev_row['id']; ?>" style="display:none;">
												<input type="hidden" name="cat_slug" class="form-control margin-bottom-15" value="<?php echo $cat[0]['slug']; ?>">
												<div class="dz-default dz-message margin-top-20">
													<span>PDF File</span>
												</div>
											</form>
										</div>	
										<?php } ?>
									</div>
								</div>
							</div>
									
							<div class="row">
								<div class="col-xs-6 margin-bottom-15">	
								  <div class="row no-space border-dashed" id="links">
										<div class="col-md-12 col-sm-12 col-xs12 no-space">	
											<form action="<?php echo base_url().index_page().'new_designer/home/rev_new_fileuploads/'.$order_id; ?>"   id="dropzone" class="dropzone" method="post">
												<input type="hidden" name="slug_name" id="slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $rev_row['new_slug'];?>">
												<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="links">
												<input type="hidden" name="cat_slug" class="form-control margin-bottom-15" value="<?php echo $cat[0]['slug']; ?>">
												<div class="dz-default dz-message margin-top-20 margin-bottom-20">
													<span>Links File</span>
												</div>
											</form>
										</div>	
									</div>
								</div>
								<div class="col-xs-6 margin-bottom-15">	
								  <div class="row no-space border-dashed" id="fonts">
										<div class="col-md-12 col-sm-12 col-xs12 no-space">	
											<form action="<?php echo base_url().index_page().'new_designer/home/rev_new_fileuploads/'.$order_id; ?>"   id="dropzone" class="dropzone" method="post">
												<input type="hidden" name="slug_name" id="slug_name" class="form-control margin-bottom-15" title="" value="<?php echo $rev_row['new_slug'];?>">
												<input type="hidden" name="file_type" id="file_type" class="form-control margin-bottom-15" title="" value="fonts">
												<input type="hidden" name="cat_slug" class="form-control margin-bottom-15" value="<?php echo $cat[0]['slug']; ?>">
												<div class="dz-default dz-message margin-top-20 margin-bottom-20">
													<span>Fonts File</span>
												</div>
											</form>
										</div>	
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 margin-top-5 text-center">
								<form method="post">
									<input type="text"  name="slug" value="<?php echo $rev_row['new_slug']; ?>" readonly style="display:none;" >
									<button name="file_submit"  type="submit" class="btn btn-success btn-sm">Refresh Folder structure</button>
								</form> 
								<!--<button class="btn btn-success btn-sm" id="show_folder">Refresh Folder structure</button>-->
							</div>
							<div class="col-md-12">
								<?php
										$this->load->helper('directory');	
										$map_dir = glob($sourcefile.'/'.$rev_row['new_slug'].'.{indd,pdf,psd,ai,jpg,gif,png}',GLOB_BRACE);	
										//$map = directory_map($sourcefile.'/');
										if($map_dir){
											$map_links = directory_map($sourcefile.'/Links/');	
											$map_fonts = directory_map($sourcefile.'/Document fonts/');
								?>	
									<div class="portlet-body text-center">					
										<div id="tree_1" class="tree-demo margin-bottom-30 text-left wrap">
											<ul>
												<li data-jstree='{ "opened" : true }'>
													<?php echo $order_id; ?>
													<ul>
														<?php foreach($map_dir as $files){ ?>
															<li data-jstree='{ "type" : "file" }'>
																<a href="<?php echo base_url()?>download.php?file_source=<?php echo $files; ?>" class="btn btn-circle btn-xs">
																	<?php echo basename($files); ?>
																</a>
															</li>
														<?php } ?>
														<li>Links &nbsp; <span class="badge bg-red"><?php echo count($map_links); ?></span>
															<ul>
																<?php if($map_links)foreach($map_links as $link_files){ ?>
																<li data-jstree='{ "type" : "file" }'>
																<a href="#"><?php echo basename($link_files); ?> </a></li><?php } ?>
															</ul>
														</li>	
														<li>Fonts &nbsp; <span class="badge bg-red"><?php echo count($map_fonts); ?></span>
															<ul>
																<?php if($map_fonts)foreach($map_fonts as $font_files){ ?>
																<li data-jstree='{ "type" : "file" }'>
																<a href="#"><?php echo basename($font_files); ?> </a></li><?php } ?>
															</ul>
														</li>
													</ul>
												</li>
											</ul>
										 </div>
									</div>
								<?php }  ?>
							</div>
						</div>
					</div>
				</div>
				</div>
				<!--- End : File Upload --->

				<!--- Start : Conversation --->					
					<div class="col-md-6">
						<div class="portlet light">
							<div class="portlet-title">
								<div class="row static-info margin-top-10">
									<div class="col-md-10">Conversations</div>
								</div>
							</div>
							<div class="row portlet-body">
								<div class="col-md-12 col-sm-12">
								  <div class="scroller" style="height:230px" data-always-visible="1" data-rail-visible="0">
								  <?php
									$qustion = $this->db->query("SELECT * FROM `production_conversation` WHERE  `revision_id`='".$rev_row['id']."' order by `id` desc")->result_array(); 
									$csr_path = $sourcefile.'/csr_change_'.$rev_row['id']; 
									if(!isset($qustion[0]['id'])){
										echo '<p class="text-center">'."No Conversations".'</p>';
									}
									if($qustion) { $i=0; foreach($qustion as $qustion1) { $i++; 
												
								?>
								<?php if(($qustion1['revision_id']!='0' && $qustion1['csr_id']!='0') && ($qustion1['operation']=='revcsr_designer')) { 
											$csr = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$qustion1['csr_id']."'")->result_array();   
									?>
									<div <?php if($i=='1'){ echo'class="note note-info"'; }else{ echo 'class="note note-grey"'; } ?>>
										<h4><?php  echo $csr[0]['name'];  ?> (CSR)</h4>
										<div class="row">
											<div class="col-sm-6">
												<?php echo $qustion1['message']; ?>
												<?php if($csr_path){ 
													$map_csr_path = glob($csr_path.'/*.{jpg,png,tiff,gif,html,pdf,indd}',GLOB_BRACE);								
													if($map_csr_path){			
														foreach($map_csr_path as $row_csr_path){  
											 ?>
												<p>Attached File -  <?php echo basename($row_csr_path) ?>
													<a href="<?php echo base_url()?><?php echo $row_csr_path ?>" target="_Blank" class="btn btn-circle btn-xs"><i class="fa fa-eye"></i></a>
													<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row_csr_path; ?>" class="btn btn-circle btn-xs"><i class="fa fa-cloud-download"></i></a>
												</p>
											<?php } } } ?>
											</div>
											<div class="col-sm-6 text-right">
												<span class="font-grey-cascade small"> at - <?php echo $qustion1['time']; ?> </span>
											</div>
										</div>
									</div>
								<?php } ?>
								<?php if(($qustion1['revision_id']!='0' && $qustion1['designer_id']!='0') && ($qustion1['operation']=='revdesigner_QA')) { 
											$designer = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$qustion1['designer_id']."'")->result_array();?>
									<div <?php if($i=='1'){ echo'class="note note-info"'; }else{ echo 'class="note note-grey"'; } ?>>
										<h4><?php echo $designer[0]['name'] ;?> (Designer)</h4>
										<div class="row">
											<div class="col-sm-6">
												<?php echo $qustion1['message']; ?>
											</div>
											<div class="col-sm-6 text-right">
												<span class="font-grey-cascade small"> at - <?php echo $qustion1['time']; ?></span>
											</div>
										</div>
									</div>
								<?php } } } ?>
								  </div>	
								</div>
							</div>
						</div>
					</div>
				<!--- End : Conversation --->
				 <!--- Start : End Design --->						
					<div class="col-md-12 text-center">
						<div class="portlet light">
							<div class="portlet-body no-space">
								<form method="POST">
								<p class="margin-top-10 font-red">Check your folder & make sure everything is Uploloaded!</p>
								<div class="row">
									<div class="col-md-8 col-md-offset-2 text-right">
										<div class="row">
											<div class="col-md-4 text-right">
												<input id="show_message" type="checkbox">Send message 
												<textarea name="note" rows="3" id="message" class="form-control margin-top-10"></textarea>
											</div>
											<div class="col-md-4 text-center">
												<input id="show_exrev" type="checkbox">Extensive Revision
												<input name="order_id" value="<?php echo $rev_row['order_id'];?>" readonly style="display:none;" />
												<textarea name="extensive_revision_note" rows="3" id="exrev" class="form-control margin-top-10"></textarea>
											</div>
											<div class="col-md-3 text-left">
												<select class="form-control input-sm" id="csr" name="csr" required>
													<option>Select Checker</option>
													<?php foreach($csr as $result){ echo '<option value="'.$result['id'].'" >'.$result['name'].'</option>'; } ?>
												</select>
											</div>
										</div>
									</div>
								</div>
								<p class="margin-top-15 margin-bottom-10">
									<input type="text"  name="slug" value="<?php echo $rev_row['new_slug']; ?>" readonly style="display:none;" >
									<input type="text" name="rev_id" value="<?php  echo $rev_row['id']; ?>" style="visibility:hidden">		
									<button type="submit" name="complete" class="btn red" id="focusdiv" onclick="return warning_confirm()" onClick="complete(<?php echo $order_id; ?>)">	End Design </button>
								</p>
								</form>
							</div>
						</div>
					</div>
		        <!--- End : End Design --->
			</div>
<?php } ?>

<?php if($rev_row['status'] == '7' && $rev_row['pdf_path'] == 'none') { ?>

<!--- Start : File Upload --->
				<div class="row">
					<div class="col-md-6">
					<div class="portlet light">
					 <div class="portlet-title">
						<div class="row">
							<div class=" static-info col-md-8">    
								<?php echo $rev_row['version'] ;?>
							</div>
							<?php if(isset($sourcefile)) { 
									$map2 = glob($sourcefile.'/'.$rev_row['new_slug'].'.{indd,psd}',GLOB_BRACE); 
										if($map2){ 
										foreach($map2 as $row_map2){ $source_file = basename($row_map2); } ?>
							<div class="col-md-4 margin-top-5 text-right">
								<form action="<?php echo base_url().'index.php/new_designer/home/zip_folder_select'?>" method="post">
									<input name="source_file" value="<?php echo $source_file;?>" readonly="" class="hidden" />
									<input name="pdf_file" value="<?php echo $rev_row['pdf_file'];?>" readonly="" class="hidden" />
									<input name="new_slug" value="<?php echo $rev_row['new_slug'];?>" readonly="" class="hidden" />
									<input name="source_path" value="<?php echo $sourcefile;?>" readonly="" class="hidden" />
									<input name="download" value="download" readonly="" class="hidden" />
									<button type="submit" name="SourceDownload" class="btn btn-default btn-sm">Package</button>
								</form>
							</div>
							<?php } } ?>
						</div>
					</div>
					<div class="portlet-body margin-top-10" id="upload">
						<div class="row">
							<div class="col-xs-12 margin-top-30 text-center">
								<div class="scroller" style="height:160px" data-always-visible="1" data-rail-visible="0">
									<p class="margin-top-10 font-red margin-top-30">Please download package before click</p>
									<form method="post">
									<?php 
										//zip source
											$map2 = glob($sourcefile.'/'.$rev_row['new_slug'].'.{indd,psd}',GLOB_BRACE); 
												if($map2){ 
												foreach($map2 as $row_map2){ $source_file = basename($row_map2); }	
											?>
										<button type="submit" name="csr_changes" class="btn btn-danger btn-sm">Make Changes</button>
										<input name="source_file" value="<?php echo $source_file;?>" readonly="" class="hidden" />
										<input name="order_id" value="<?php echo $order_id;?>" readonly style="display:none;" />
										<input name="rev_id" value="<?php echo $rev_row['id'];?>" readonly style="display:none;" />
										<input name="pdf_file" value="<?php echo $rev_row['pdf_file'];?>" readonly="" class="hidden" />
										<input name="new_slug" value="<?php echo $rev_row['new_slug'];?>" readonly="" class="hidden" />
										<input name="source_path" value="<?php echo $sourcefile;?>" readonly="" class="hidden" />
										<input name="archive" value="archive" readonly style="display:none;" />
									<?php }  ?>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				</div>
			
				<!--- End : File Upload --->
				<!--- Start : Conversation --->					
				
					<div class="col-md-6">
						<div class="portlet light">
							<div class="portlet-title">
								<div class="row static-info  margin-top-10">
									<div class="col-md-10">Conversations</div>
								</div>
							</div>
							<div class="row portlet-body">
								<div class="col-md-12 col-sm-12">
								  <div class="scroller" style="height:185px" data-always-visible="1" data-rail-visible="0">
										 <?php
										$qustion = $this->db->query("SELECT * FROM `production_conversation` WHERE  `revision_id`='".$rev_row['id']."' order by `id` desc")->result_array(); 
										$csr_path = $sourcefile.'/csr_change_'.$rev_row['id']; 
										if(!isset($qustion[0]['id'])){
											echo '<p class="text-center">'."No Conversations".'</p>';
										}
										if($qustion) { $i=0; foreach($qustion as $qustion1) { $i++; 
													
									?>
									<?php if(($qustion1['revision_id']!='0' && $qustion1['csr_id']!='0') && ($qustion1['operation']=='revcsr_designer')) { 
												$csr = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$qustion1['csr_id']."'")->result_array();   
										?>
										<div <?php if($i=='1'){ echo'class="note note-info"'; }else{ echo 'class="note note-grey"'; } ?>>
											<h4><?php  echo $csr[0]['name'];  ?> (CSR)</h4>
											<div class="row">
												<div class="col-sm-6">
													<?php echo $qustion1['message']; ?>
													<?php if($csr_path){ 
														$map_csr_path = glob($csr_path.'/*.{jpg,png,tiff,gif,html,pdf,indd}',GLOB_BRACE);								
														if($map_csr_path){			
															foreach($map_csr_path as $row_csr_path){  
												 ?>
													<p>Attached File -  <?php echo basename($row_csr_path) ?>
														<a href="<?php echo base_url()?><?php echo $row_csr_path ?>" target="_Blank" class="btn btn-circle btn-xs"><i class="fa fa-eye"></i></a>
														<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row_csr_path; ?>" class="btn btn-circle btn-xs"><i class="fa fa-cloud-download"></i></a>
													</p>
												<?php } } } ?>
												</div>
												<div class="col-sm-6 text-right">
													<span class="font-grey-cascade small"> at - <?php echo $qustion1['time']; ?> </span>
												</div>
											</div>
										</div>
									<?php } ?>
									<?php if(($qustion1['revision_id']!='0' && $qustion1['designer_id']!='0') && ($qustion1['operation']=='revdesigner_QA')) { 
												$designer = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$qustion1['designer_id']."'")->result_array();?>
										<div <?php if($i=='1'){ echo'class="note note-info"'; }else{ echo 'class="note note-grey"'; } ?>>
											<h4><?php echo $designer[0]['name'] ;?> (Designer)</h4>
											<div class="row">
												<div class="col-sm-6">
													<?php echo $qustion1['message']; ?>
												</div>
												<div class="col-sm-6 text-right">
													<span class="font-grey-cascade small"> at - <?php echo $qustion1['time']; ?></span>
												</div>
											</div>
										</div>
									<?php } } } ?>
								  </div>	
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--- End : Conversation --->

<?php } ?>

<?php if($rev_row['pdf_file'] != 'none' && $rev_row['status'] == '5') {
			$pdf_path = $sourcefile.'/'.$rev_row['pdf_file'];
				$source_zip_path = $sourcefile.'/'.$rev_row['new_slug'].'.zip';
	?>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light">
				<div class="portlet-title  margin-top-10">
					<div class="row static-info">
						<div class="col-md-8 value">Order #<?php echo $order_id.' '.$rev_row['version']; ?></div>
						<div class="col-md-4 text-right">
							<div class="row">
								<?php if(isset($pdf_path) && file_exists($pdf_path)){ ?>
								<div class="col-xs-4 padding-0 pull-right">
									<a class="btn btn-default btn-sm btn-block" href="<?php echo base_url().$pdf_path; ?>" target="_blank">PDF</a>
								</div>
								<?php }	
								if(file_exists($source_zip_path)){ ?>
								<div class="col-md-4 padding-0 pull-right">
									<a href="<?php echo base_url()?><?php echo $source_zip_path ?>" class="btn btn-default btn-sm btn-block">Package</a>
								</div>	
								<?php } else { 
								
								//zip source
										if(isset($prev_rev_orders[0]['id']) && ($prev_rev_orders[0]['id']==$rev_row['id'])){
											$source_file = $rev_row['source_file'];
											$map2 = $sourcefile.'/'.$source_file;
											if(file_exists($map2)){
									?>
								<div class="col-md-4 padding-0 pull-right">
									<form action="<?php echo base_url().'index.php/new_designer/home/zip_folder_select'?>" method="post">
										<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
										<input name="pdf_file" value="<?php echo $rev_row['pdf_file'];?>" readonly style="display:none;" />
										<input name="new_slug" value="<?php echo $rev_row['new_slug'];?>" readonly style="display:none;" />
										<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
										<input name="download" value="download" readonly style="display:none;" />
										<button type="submit" name="SourceDownload" class="btn btn-default btn-sm btn-block">
										Package
										</button>
									</form>
								</div>
							<?php } } } ?>					
							</div>
						</div>
						</div>
					</div>
			  </div>
		</div>
	</div>	
<?php } ?>		

<?php } ?>

<!--- V1 files for all status Starts-->		
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light">
				<div class="portlet-title  margin-top-10">
					<div class="row static-info">
						<div class="col-md-8 value">Order #<?php echo $order_id; ?> V1</div>
						<div class="col-md-4 text-right">
							<div class="row">
								<?php if(isset($sourcefile) && isset($cat)){
									$this->load->helper('directory');
									//$map_zip = glob($sourcefile.'/'.$cat[0]['slug'].'.{zip}',GLOB_BRACE);
									$map2 = glob($sourcefile.'/'.$cat[0]['slug'].'.{indd,psd}',GLOB_BRACE);
									$map_pdf = glob($sourcefile.'/'.$cat[0]['slug'].'.{pdf,jpg,gif,png}',GLOB_BRACE);
									if($map_pdf){ foreach($map_pdf as $row){
								?>
								<div class="col-xs-4 padding-0 pull-right">
									<a class="btn btn-default btn-sm btn-block" href="<?php echo $row; ?>" target="_blank">PDF</a>
								</div>
							<?php } } 
								$source_zip_file = $sourcefile.'/'.$cat[0]['slug'].'.zip' ;
									if(file_exists($source_zip_file)){ ?>
								<div class="col-md-4 padding-0 pull-right">
									<a href="<?php echo base_url()?><?php echo $source_zip_file ?>" class="btn btn-default btn-sm btn-block">Package</a>
								</div>	
							<?php } else {
							
							if($count=='1' && $rev_orders[0]['pdf_path']=='none' && $map2){
								//if($rev_orders[0]['pdf_path']=='none' && $map2){ 	
								foreach($map2 as $row_map2){
									$source_file = basename($row_map2);
								} ?>
								<div class="col-md-4 padding-0">
									<form action="<?php echo base_url().'index.php/new_designer/home/zip_folder_select'?>" method="post">
										<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
										<input name="new_slug" value="<?php echo $cat[0]['slug'];?>" readonly style="display:none;" />
										<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
										<input name="download" value="download" readonly style="display:none;" />
										<button type="submit" name="SourceDownload" class="btn btn-default btn-sm btn-block">
										Package</button>
									</form>
								</div>
								<?php } } } ?>
								<?php if(isset($order_form) && file_exists($order_form)) { 
										$order_map = glob($order_form.'/*',GLOB_BRACE);
										if($order_map) { ?>
								<div class="col-md-4 padding-0 pull-right">
									<form method="post" action="<?php echo base_url().index_page().'new_designer/home/zip_folder';?>">
										<input name="file_path" value="<?php echo $order_form; ?>" readonly style="display:none;" /> 
										<input name="file_name" value="<?php echo $order_id; ?>" readonly style="display:none;" />
										<button type="submit" name="Submit" class="btn btn-default btn-sm btn-block">
											Downloads</i></button>
									</form>										
								</div>
								<?php } } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<!--- V1 files for all status Starts-->	
	
	
			</div>
		</div> 
	</div>
  </div>
</div>



<?php
       $this->load->view("new_designer/foot"); 
?>