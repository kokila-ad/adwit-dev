<?php
       $this->load->view("team-lead/head"); 
?>
<!-- END HEADER -->

<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">

	<!-- BEGIN PAGE CONTENT -->
	<div class="page-content">
		<div class="container">	
		<!-- BEGIN PROFILE -->
<?php $count = count($rev_orders); $prev=$count-1; $i=0; foreach($rev_orders as $rev_row){ $i++; 
			if($rev_row['pdf_path']=='none'){
?>
<!--revision -->			 
			
		<!--<div id="toggle<?php echo $i; ?>">-->
			<div class="row margin-top-10">
				<div class="col-md-12">
					<!-- BEGIN PROFILE CONTENT -->
					<div class="profile-content">
						<div class="row">				  						   
						   <div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject grey-gallery bold ">Revision <?php echo $rev_row['version']; ?> <small><?php echo $rev_row['date']; ?></small></span>
							</div>	
							<?php if($rev_row['status']=='3') { ?>
							<div class="col-md-2 pull-right">
								<form method="post">
									<input type="text" name="rev_id" value="<?php echo $rev_row['id']; ?>" style ="display:none;">
									<button class="btn btn-default btn-sm btn-block" type="submit" name="reassign">Reassign</button>
								</form>
							</div>
							<?php } ?>
												
						</div>
						<div class="row portlet-body">
						   <div class="col-md-6">	
                            <div class="portlet box blue-chambray">
								<div class="portlet-title">
									<div class="caption">Instructions</div>
								</div>
								<div class="portlet-body">
									<div class="margin-bottom-20">
										<p> <?php $rev_row['note'] = str_replace(PHP_EOL,'<br/>', $rev_row['note']); 
												echo $rev_row['note'];?>
										</p>
									</div>
								</div>
							</div>
						   </div>
							
						    <div class="col-md-6">	
                            <div class="portlet box blue-chambray">
													<div class="portlet-title">
														<div class="caption">Downloads</div>
														<div class="tools">
															<?php if($rev_row['file_path']!='none') { $filepath = $rev_row['file_path']; ?>
																<form method="post" action="<?php echo base_url().index_page().'new_designer/home/zip_folder';?>">
																<input name="file_path" value="<?php echo $filepath; ?>" readonly style="display:none;" /> 
																<input name="file_name" value="<?php echo $rev_row['order_id']; ?>" readonly style="display:none;" />
																<button type="submit" name="Submit" class="font-grey-cararra"><i class="fa fa-cloud-download"></i></button>
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
								<span>
								<a href="<?php echo base_url().$row1; ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
								<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row1; ?>" class="font-grey-gallery"><i class="fa fa-cloud-download"></i></a></span>							
								</td> 		  
								</tr>  
								<?php } } } ?> 
								<tr>
									<?php if(isset($order_form) && file_exists($order_form)) { ?>
									<td><?php echo basename($order_form) ?></td>
									<td class="text-right">
									<a href="<?php echo base_url().$order_form; ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
									<a href="<?php echo base_url()?>download.php?file_source=<?php echo $order_form; ?>" class="font-grey-gallery"><i class="fa fa-cloud-download"></i></a></span>
									</td>
									<?php } ?>
								</tr>
								</tbody>
							</table>  
							</div>
							</div>
							</div>	
						 
						
			<?php if($rev_row['new_slug'] == 'none'){ ?>	
			<?php }elseif($rev_row['status']<'4'){ ?>
						<div class="row">
							<div class="col-md-6">	
							New Slug : <h4 class="font-blue"><?php echo $rev_row['new_slug']; ?></h4>
							</div>
						</div>		
			<?php }elseif($rev_row['source_file']!='none' && $rev_row['pdf_file']!='none'){ ?>
			
			<div class="col-md-6 col-sm-12">
				<div class="portlet blue-hoki box">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-cloud-download"></i>Sourcefile
						</div>
					</div>
					<div class="portlet-body">
						<div class="table-scrollable table-scrollable-borderless">
							<table class="table table-light table-hover">
								<tbody>
								<tr>
								<?php   
									if(isset($sourcefile) && $rev_row['source_file']!='none' && $rev_row['pdf_file']!='none'){ 
										//PDF File View & Download
										$map1 = $sourcefile.'/'.$rev_row['pdf_file'];
										if(file_exists($map1)){									
								?>
									<td>
									<?php echo $rev_row['pdf_file']; ?>
									<a href="<?php echo base_url()?><?php echo $map1 ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
									<a href="<?php echo base_url()?>download.php?file_source=<?php echo $map1; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a>
									</td>
								
								</tr><?php }  ?>
								<tr>
									<td>
										<?php 
											//zip source
											$source_file = $rev_row['source_file'];
											$map2 = $sourcefile.'/'.$source_file;
											if(file_exists($map2)){		
										?>
										<form action="<?php echo base_url().'index.php/team-lead/home/zip_folder_select'?>" method="post">
											<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
											<input name="new_slug" value="<?php echo $rev_row['new_slug'];?>" readonly style="display:none;" />
											<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
											<input name="download" value="download" readonly style="display:none;" />
											<button type="submit" name="SourceDownload" class="btn green">SourceDownload</button>
										</form>
										<?php }  ?>
									</td>
								<?php } ?>
								</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
		</div>
								
		
			
			<?php } ?>
		</div>

		 </div>
				    
                    
					
					</div>
					<!-- END PROFILE CONTENT -->
			    	</div>
		    	</div>
			<!-- END PROFILE -->
			</div>
	   	         
	   </div>
	  <!-- </div> -->
	<?php }else{ 
			if($rev_row['pdf_file']!='none'){
				$pdf_path = $sourcefile.'/'.$rev_row['pdf_file'];
				$source_zip_path = $sourcefile.'/'.$rev_row['new_slug'].'.zip';
			}
?>
		<div class="portlet light">			 
					  
					<div class="row">
								<div class="col-sm-9 col-xs-12">	
									<h4><strong class="font-grey-gallery">Order #<?php echo $order_id.' '.$rev_row['version']; ?></strong></h4>
								</div>
								<div class="col-sm-3 col-xs-12 text-right margin-top-10">
									<?php if(file_exists($pdf_path)){ ?>
									<div class="col-xs-6 padding-0 pull-right">
									<span><a class="btn btn-default btn-sm btn-block" href="<?php echo base_url().$pdf_path; ?>" target="_blank">
									PDF</a></span>
									</div>
									<?php }
									if(file_exists($source_zip_path)){ ?>
									<div class="col-xs-6 padding-0">
										<a href="<?php echo base_url()?><?php echo $source_zip_path ?>" class="btn btn-default btn-sm btn-block">Package</a>
									</div>	
								<?php } else {  
											//zip source
											if(isset($prev_rev_orders[0]['id']) && ($prev_rev_orders[0]['id']==$rev_row['id'])){
											$source_file = $rev_row['source_file'];
											$map2 = $sourcefile.'/'.$source_file;
											if(file_exists($map2)){		
										?>
									<div class="col-xs-6 padding-0">
									<form action="<?php echo base_url().'index.php/team-lead/home/zip_folder_select'?>" method="post">
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
										<!--<span class="margin-right-10"><a href="<?php echo base_url().$source_zip_path; ?>" class="font-grey"><i class="fa fa-cloud-upload font-blue"></i></a></span>-->
									<?php } } }?>
									<!--<div class="col-xs-4"><span><i class="fa fa-eye"></i></span></div>-->
								</div>  
					</div>
					
		</div>
	<?php } } ?>
				<div class="portlet light">			 
					   <div class="row">
								<div class="col-sm-8 col-xs-12">	
									<h4><strong class="font-grey-gallery">Order #<?php echo $order_id; ?> V1</strong></h4>
								</div>
								<!--<div class="col-md-6 text-right margin-top-10">	
									<span class="margin-right-10"><a href="<?php echo $orders[0]['pdf']; ?>" target="_blank"><i class="fa fa-file-pdf-o font-red"></i></a></span>
									<?php if($count=='1' && $rev_orders[0]['pdf_path']=='none'){ ?>
										<span class="margin-right-10"><a href="<?php if(isset($ZipPath)){echo $ZipPath;} ?>" class="font-grey"><i class="fa fa-cloud-upload font-blue"></i></a></span>
									<?php } ?>
									<span><i class="fa fa-eye"></i></span> 
								</div>
								-->
								<div class="col-sm-4 col-xs-12 text-right margin-top-10">
								<?php if(isset($sourcefile) && isset($cat)){
											$this->load->helper('directory');
											//$map_zip = glob($sourcefile.'/'.$cat[0]['slug'].'.{zip}',GLOB_BRACE);
											$map2 = glob($sourcefile.'/'.$cat[0]['slug'].'.{indd,psd}',GLOB_BRACE);
											$map_pdf = glob($sourcefile.'/'.$cat[0]['slug'].'.{pdf,jpg,gif,png}',GLOB_BRACE);
											if($map_pdf){ foreach($map_pdf as $row){
								?>
								<div class="col-xs-4 padding-0 pull-right">
									<span><a class="btn btn-default btn-sm btn-block" href="<?php echo $row; ?>" target="_blank">
									PDF</a></span>
								</div>
								<?php }}
									$source_zip_file = $sourcefile.'/'.$cat[0]['slug'].'.zip' ;
										if(file_exists($source_zip_file)){ ?>
								<div class="col-md-4 padding-0">
									<a href="<?php echo base_url()?><?php echo $source_zip_file ?>" class="btn btn-default btn-sm btn-block">Package</a>
								</div>	
							<?php } else {

									if($count=='1' && $rev_orders[0]['pdf_path']=='none' && $map2){ 
											foreach($map2 as $row_map2){
											$source_file = basename($row_map2);
									}
								?>
								<div class="col-md-4 padding-0">
								<form action="<?php echo base_url().'index.php/team-lead/home/zip_folder_select'?>" method="post">
											<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
											<input name="new_slug" value="<?php echo $cat[0]['slug'];?>" readonly style="display:none;" />
											<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
											<input name="download" value="download" readonly style="display:none;" />
											<button type="submit" name="SourceDownload" class="btn btn-default btn-sm btn-block">
											Package
											</button>
								</form>
								</div>
									<!--<span class="margin-right-10"><a href="<?php echo $row; ?>" class="font-grey"><i class="fa fa-cloud-upload font-blue"></i></a></span>-->
									<?php } } }  ?>
									
									<div class="col-md-4 padding-0 pull-right">
									<?php if(isset($order_form1) && file_exists($order_form1)) { ?>
									<form method="post" action="<?php echo base_url().index_page().'team-lead/home/zip_folder';?>">
										<input name="file_path" value="<?php echo $order_form1; ?>" readonly style="display:none;" /> 
										<input name="file_name" value="<?php echo $order_id; ?>" readonly style="display:none;" />
										<button type="submit" name="Submit" class="btn btn-default btn-sm btn-block">
											Downloads</i>
										</button>
									</form>
								<?php } ?>
									
									</div>
								</div>
								
						</div>
					
				</div>
				
	</div>
	<!-- END PAGE CONTENT -->
</div>
</div>
<!-- END PAGE CONTAINER -->


<!-- BEGIN PRE-FOOTER -->
	
<!-- END PRE-FOOTER -->

<!-- BEGIN FOOTER -->
<?php
       $this->load->view("team-lead/foot"); 
?>