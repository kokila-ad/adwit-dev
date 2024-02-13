<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('new_csr/head');?>
<style>
.dropzone {
    border: 2px dashed #ccc;
    background: white;
    padding: 10px 10px;
}
.dropzone, .dropzone * {
    box-sizing: border-box;
}
.dropzone {
    -webkit-border-radius: 0px;
    -moz-border-radius: 0px;
    border-radius: 0px;
}

</style>
<div id="main">
	<section>
		<div class="container margin-top-80">
			<div class="container margin-top-20">
				<div class="row">
				<div class="col-md-7">
					<p>
						<a href="#" class="text-blue">Order</a>
						<span class="padding-horizontal-5"><i class="fa fa fa-angle-double-right"></i></span>
						<a href="#">Id:<?php echo $pass_id['id']; ?></a>
					</p>
				</div>
				<div class="col-md-5 col-sm-12 col-xs-12">
					<form method="get"> 
						<div id="search">
							<div class="row">
								<div class="col-md-8 col-sm-8 col-xs-8 padding-right-0"></div>
								<div class="col-md-4 col-sm-4 col-xs-4 padding-left-0" style="text-align: right;">
									<p>
										<a href="#" class="text-blue">Version</a>
										<span class="padding-horizontal-5"><i class="fa fa fa-angle-double-right"></i></span>
										<a href="#">V1</a>
									</p> 
								</div>
							</div>	
						</div>
					</form>	 
				</div>
			</div>
		</div>
			<div class="portlet-body">
				<?php foreach ($list as $value) 
				{?>
				<div class="panel-group accordion" id="accordion3">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_1<?php echo $value['id'];?>">
									<?php echo $value['page_no']; ?> 
								</a>
							</h4>
						</div>
						<div id="collapse_3_1<?php echo $value['id'];?>" class="panel-collapse collapse">
							<div class="panel-body">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<th>Article</th>
										<th>Ads</th>
										<th>Note & Instruction</th>
									</thead>
									<tbody>
										<tr>
											<td><?php
												$i=1; 
												$articles_path = $value['articles'];
        										if ($articles_path != null && file_exists($articles_path) && $atp = opendir($articles_path))
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
                											<table>
                												<tr>
		                											<?php echo $i."."; ?>
		                											<a href='<?php echo base_url().'page_design/articles'.'/'.$value['pd_id'].'/'.$value['id'].'/'.$file?>' target="_blank">
		                												<?php echo $file;?>
		                											</a>
		                										</tr>
		                									</table>
                								<?php   }
                										$i++;
                									}
             										closedir($atp);//dirctry $atp clocsed
        										}?></td>
											<td><?php
												$i=1; 
												$articles_path = $value['ads'];
        										if ($articles_path != null && file_exists($articles_path) && $atp = opendir($articles_path))
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
                											<table>
                												<tr>
		                											<?php echo $i."."; ?>
		                											<a href='<?php echo base_url().'page_design/ads'.'/'.$value['pd_id'].'/'.$value['id'].'/'.$file?>' target="_blank">
		                												<?php echo $file;?>
		                											</a>
                												</tr>
                											</table>
                								<?php   }
                										$i++;
                									}
             										closedir($atp);//dirctry $atp clocsed
        										}?></td>
											<td><?php echo $value['note_instructions'];?></td>
										</tr>
									</tbody>
								</table>   
							
							
							<?php 
							$mess = $this->db->query("SELECT pages.attch_article,pages.attch_ads,page_message.message FROM `pages` INNER JOIN `page_message` ON page_message.pages_id =pages.id WHERE page_message.pages_id ='".$value['id']."' ")->result_array();
							foreach ($mess as $key) {?>
							<div class="">
								<p><b>Additional Attachments</b></p>
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<th>Article</th>
										<th>Ads</th>
										<th>Note & Instruction</th>
									</thead>
									<tbody>
										<tr>
											<td><?php
												$i=1; 
												$articles_path = $key['attch_article'];

        										if ($articles_path != null && file_exists($articles_path) && $atp = opendir($articles_path))
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
                											<table class="table table-striped table-bordered table-hover">
                												<tbody>
	                												<tr>
	                													<td>
			                												<?php echo $i.".";date_default_timezone_set('Asia/Kolkata');?>
			                											</td>
			                											<td>
			                												<?php echo $dat =date("F d/h:i A",filemtime($articles_path.'/'.$file));?>
			                											</td>
	                													<td>
			                												<a href='<?php echo base_url().'page_design/attachments/articles/'.$value['pd_id'].'/'.$value['id'].'/'.$file?>' target="_blank">
																				<?php echo $file;?>
			                												</a>
			                											</td>
			                										</tr>
		                										</tbody>
		                									</table>
                								<?php   }
                										$i++;
                									}
             										closedir($atp);//dirctry $atp clocsed
        										}?></td>
											<td><?php
												$i=1; 
												$articles_path = $key['attch_ads'];
        										if ($articles_path != null && file_exists($articles_path) && $atp = opendir($articles_path))
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
                											<table class="table table-striped table-bordered table-hover">
                												<tbody>
	                												<tr>
	                													<td>
	                														<?php echo $i.".";?>
	                													</td>
			                											<td>
			                												<?php echo $dat =date("F d/h:i A",filemtime($articles_path.'/'.$file));?>
			                											</td>
			                											<td>
			                												<a href='<?php echo base_url().'page_design/attachments/ads'.'/'.$value['pd_id'].'/'.$value['id'].'/'.$file?>' target="_blank">
			                													<?php echo $file;?>
			                												</a>
			                											</td>
	                												</tr>
                											</table>
                								<?php   }
                										$i++;
                									}
             										closedir($atp);
        										}?></td>
											<td><?php echo $key['message'];?></td>
										</tr>
									</tbody>
								</table>   
							</div> 
							</div>  
							<?php } ?>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-12">
					<span>Zip Files</span>
					<span class="dropdown margin-left-5 text-grey pull-right">
						<span class="cursor-pointer padding-left-5 " type="button" data-toggle="dropdown" id="zip-view">View uploaded files 
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
										{?>
											<tr>
												<td>
													<?php echo $i; ?>
												</td>
												<td>
													<a href="<?php echo base_url().'page_sourcefile/'.$pass_id['id'].'/v1/'.$row;?>" target="_blank">
														<?php echo $row?>
													</a>
												</td>
												<td>
													<a href="<?php echo base_url().'page_sourcefile/'.$pass_id['id'].'/v1/'.$row;?>"  target="_blank" >
														<i class="fa fa-download"></i>
													</a>
												</td>
											</tr>
								<?php  		$i++; 
										} 
									}?>
								</tbody>
							</table>
						</div>
					</span>	
				    <form action="<?php echo base_url().index_page()."new_csr/home/page_zip_upload/".$pass_id['id']; ?>" name="file" class="dropzone  dz-clickable"> 
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
								<tbody>
									<tr>
										<td>
											<a href="<?php echo base_url().'page_sourcefile/'.$pass_id['id'].'/v1/'.$pass_id['pdf'];?>" target="_blank">
												<?php echo $pass_id['pdf']; ?>
											</a>
										</td>
										<td>
											<a href="<?php echo base_url().'page_sourcefile/'.$pass_id['id'].'/v1/'.$pass_id['pdf'] ;?>" target="_blank" >
												<i class="fa fa-download"></i>
											</a>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</span>		
				    <form action="<?php echo base_url().index_page()."new_csr/home/page_pdf_upload/".$pass_id['id']; ?>" name="file" class="dropzone  dz-clickable"> 
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
				<div class=" col-md-12 margin-top-15 text-right">
					<form method="post" action="<?php echo base_url().index_page()."new_csr/home/page_end/".$pass_id['id']; ?>">
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
		   $( "#mytable-zip" ).load( "<?php echo base_url().index_page()."new_csr/home/page_start_end/".$pass_id['id'];?> #mytable-zip" );
		   $( "#mytable-pdf" ).load( "<?php echo base_url().index_page()."new_csr/home/page_start_end/".$pass_id['id'];?> #mytable-pdf" );
	   }
	   $("#zip-view").on("click", RefreshTablePrint);
	   $("#pdf-view").on("click", RefreshTablePrint);
</script>
<script>	

 	function  remove_zip(i) {
 		 var fname =$('#zip'+i).val();
 		 $.ajax({
 		 	url:"<?php echo base_url().index_page().'new_csr/home/page_remove_zip_file/'.$pass_id['id'];?>",
 		 	data:'filename='+fname,
 		 	type:"POST",
 		 });
	}
</script>