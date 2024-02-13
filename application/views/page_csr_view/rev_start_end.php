<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('new_csr/head');?>
<div id="main">
	<section>
		<div class="container margin-top-20">
			<div class="row">
			<?php echo $this->session->flashdata('message');?> 
			<div class="col-md-7">
				<p>
					<a href="#" class="text-blue">Order</a>
					<span class="padding-horizontal-5"><i class="fa fa fa-angle-double-right"></i></span>
					<a href="#">Id:<?php echo $all['pd_id']; ?></a>
				</p>
			</div>
			<div class="col-md-5 col-sm-12 col-xs-12">
				<form method="get"> 
					<div id="search">
						<div class="row">
							<div class="col-md-8 col-sm-8 col-xs-8 padding-right-0"></div>
							<div class="col-md-4 col-sm-4 col-xs-4 padding-left-0 " style="text-align: right;">
								<p>
									<a href="#" class="text-blue">Version</a>
									<span class="padding-horizontal-5"><i class="fa fa fa-angle-double-right"></i></span>
									<a href="#"><?php echo $all['revision_version']; ?></a>
								</p>
							</div>
						</div>	
					</div>
				</form>	 
			</div>
		</div>
			<div class="container"> 
				<div class="row">	 			  
			  		<div class="col-md-12 margin-top-50">
				 		<div class=""> 
							<table class="table table-striped table-bordered table-hover" id="example1">
								<thead>
									<tr>
										<td>Articles</td>
										<td>Ads</td>
										<td>Notes & Instructions</td>
									</tr>  									
								</thead>
								<tbody>
									<tr>
										<td>
											<?php
													$i=1; 
													$articles_path = $all['articles'];
        											if ($articles_path != null && file_exists($articles_path) && $atp = opendir($articles_path)) //check the notnull exitsfile and openfile
        											{
            											while (($file = readdir($atp)) !== false)  //loop to read the file path then store it
            											{
                											if ($file == '.' || $file == '..')  //.,.. get 
                											{
                    											continue; // left that and continue next
                											}?>
                											<?php
                											if($file) // file get 
                											{?>
                												<?php echo "<b>".$i."."; ?>
                												<a href='<?php echo base_url().'page_design/revision/articles'.'/'.$all['pd_id'].'/'.$all['id'].'/'.$file?>' target="_blank"><?php echo $file;?><br></a>
                											<?php }

                											$i++;
                										}
             											closedir($atp);//dirctry $atp clocsed
        											}
													?></td>
										<td><?php
													$i=1; 
													$articles_path = $all['ads'];
        											if ($articles_path != null && file_exists($articles_path) && $atp = opendir($articles_path)) //check the notnull exitsfile and openfile
        											{
            											while (($file = readdir($atp)) !== false)  //loop to read the file path then store it
            											{
                											if ($file == '.' || $file == '..')  //.,.. get 
                											{
                    											continue; // left that and continue next
                											}?>
                											<?php
                											if($file) // file get 
                											{?>
                												<?php echo "<b>".$i."."; ?>
                												<a href='<?php echo base_url().'page_design/revision/ads'.'/'.$all['pd_id'].'/'.$all['id'].'/'.$file?>' target="_blank"><?php echo $file;?><br></a>
                											<?php }

                											$i++;
                										}
             											closedir($atp);//dirctry $atp clocsed
        											}
													?></td>
										<td><?php echo $all['note']; ?></td>
									</tr> 
								</tbody> 
							</table>	
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 margin-top-20">
					<div class="">
						<form method="post" action="<?php echo base_url().index_page().'new_csr/home/page_source/'.$all['pd_id']?>">
							<p style="text-align: center;"><button type="submit"  class="btn btn-info   name="source">Source File Download</button></p>
						</form>
					</div>
				</div>
			</div>
			<div class="row">
				<div class=" margin-top-20">
				<div class="col-md-6 col-sm-6 col-xs-12">
					<span>Zip Files</span>
					<span class="dropdown margin-left-5 text-grey pull-right">
						<span class="cursor-pointer padding-left-5" type="button" data-toggle="dropdown" id="zip-view">View uploaded files 
							<span class="caret margin-left-5"></span>
						</span>
						<div class="table-responsive dropdown-menu file_li">
						  	<table class="table table-striped table-hover" id="mytable-zip">
								<tbody>
									<?php 
										if(isset($zip_name)) 
										{ 
											$i=1;  
											foreach($zip_name as $row)
											{?><!--This is listed the files -->
												<tr>
													<td>
														<?php echo $i; ?>
													</td>
													<td>
														<a href="<?php echo base_url().'page_sourcefile/'.$all['pd_id'].'/'.$all['revision_version'].'/'.$row;?>" target="_blank">
															<?php echo $row?>
														</a>
													</td><!--This is path and name  option -->
													<td>
														<a href="<?php echo base_url().'page_sourcefile/'.$all['pd_id'].'/'.$all['revision_version'].'/'.$row;?>" download target="_blank" >
															<i class="fa fa-download"></i>
														</a>
													</td>
													<!--This is remove file option -->
													<!--<td>
														<input type="hidden" name="filename" id="zip_path<?php echo $i;?>" value="<?php echo $row; ?>">
														<input type="button" name="remove" value="remove" onclick="remove_art(<?php echo $i;?>)">
													</td>-->
												</tr>
									<?php   $i++; 
											} 
										}?>
								</tbody>
							</table>
						</div>
					</span>	
			    	<form action="<?php echo base_url().index_page()."new_csr/home/page_rev_zip_upload/".$all['id'].'/'.$all['pd_id'];?>" name="file" class="dropzone  dz-clickable"> 
			    		<div class="dz-default dz-message">
			    			<span>
			    				<strong>
			    					Drag files
			    				</strong> 
			    				or click to upload
			    			</span>
			    		</div>
			    	</form>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<span>PDF Files</span>
					<span class="dropdown margin-left-5 text-grey pull-right">
						<span class="cursor-pointer padding-left-5" type="button" data-toggle="dropdown" id="pdf-view">View uploaded files 
							<span class="caret margin-left-5"></span>
						</span>
						<div class="table-responsive dropdown-menu file_li">
						  	<table class="table table-striped table-hover" id="mytable-pdf">
								<tbody><!--This is listed the files -->
									<?php 
										if(isset($pdf_name)){ 
											$i=1;  
											foreach($pdf_name as $row){
									?>
												<tr>
													<td>
														<?php echo $i; ?>
													</td>
													<td>
														<a href="<?php echo base_url().'page_sourcefile/'.$all['pd_id'].'/'.$all['revision_version'].'/'.$row;?>" target="_blank">
															<?php echo $row?>
														</a>
													</td><!--This is path and name  option -->
													<td>
														<a href="<?php echo base_url().'page_sourcefile/'.$all['pd_id'].'/'.$all['revision_version'].'/'.$row;?>" download target="_blank" >
															<i class="fa fa-download"></i>
														</a>
													</td>
												</tr>
									<?php   $i++; 
											} 
										}?>
								</tbody>
							</table>
						</div>
					</span>		
			    	<form action="<?php echo base_url().index_page()."new_csr/home/page_rev_pdf_upload/".$all['id'].'/'.$all['pd_id'];?>" name="file" class="dropzone  dz-clickable"> 
			    		<div class="dz-default dz-message">
			    			<span>
			    				<strong>
			    					Drag files
			    				</strong> 
			    				or click to upload
			    			</span>
			    		</div>
			    	</form>
				</div> 

				</div> 
				<div class=" col-md-12 margin-top-15 text-right">
					<form method="post" action="<?php echo base_url().index_page()."new_csr/home/page_rev_end/".$all['id']; ?>">
						<button type="submit" class="btn btn-danger margin-bottom-10 " name="end">End</button>
					</form>
			   </div>
			</div> 
		</div>
</section>
</div>
<?php $this->load->view('new_csr/foot');?>
<script>
	   function RefreshTablePrint() { 
		   $( "#mytable-zip" ).load( "<?php echo base_url().index_page()."new_csr/home/page_rev_start_end/".$all['id'];?> #mytable-zip" );
		   $( "#mytable-pdf" ).load( "<?php echo base_url().index_page()."new_csr/home/page_rev_start_end/".$all['id'];?> #mytable-pdf" );
	   }
	   $("#zip-view").on("click", RefreshTablePrint);
	   $("#pdf-view").on("click",RefreshTablePrint);
</script>