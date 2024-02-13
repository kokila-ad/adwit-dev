<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('new_client/header') ?>
<style>
.right{
	float: right;
}
</style>

<link href="<?php echo base_url();?>assets/new_client/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url();?>assets/new_client/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>	
<div id="main">
	<section>
    	<div class="container margin-top-80"> 
    		<div class="row margin-bottom-20">  		 
				<div class="col-md-7">
					<p>
						<a href="#">Pagination ID: <?php echo $Id; ?></a>
					</p>
				</div>
				<div class="col-md-5 col-sm-12 col-xs-12">
					<form method="get"> 
						<div id="search">
							<div class="row">
								<div class="col-md-8 col-sm-8 col-xs-8 padding-right-0"></div>
							 	<div class="col-md-4 col-sm-4 col-xs-4 padding-left-0">
									<a href="<?php echo base_url().index_page()."new_client/home/page_dashboard/"?>" class="text-blue right"><i class="fa fa fa-angle-double-left"></i> back</a>
								</div>
						 	</div>	
						  </div>
					</form>	 
				</div>					 
			</div>
			<?php echo $this->session->flashdata('item');?>
			<div class="portlet-body">
				<?php foreach ($order_id as $value)
				{
					$page_id= $this->db->query("SELECT * FROM `pages` WHERE pages.id='".$value['id']."';")->row_array();
					?>
				<div class="panel-group accordion margin-bottom-5" id="accordion3">
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
										<th>Article </th>
										<th>Ads</th>
										<th>Note & Instruction</th>
									</thead>
									<tbody>
										<tr>
										 	<td>
										 		<div class="form-group">
													<span>&nbsp;</span>
													<span class="dropdown margin-left-5 text-grey pull-right">
														<span class="cursor-pointer padding-left-5" type="button" data-toggle="dropdown" id="article-view<?php echo $value['id'];?>">
															View uploaded files 
															<span class="caret margin-left-5"></span>
														</span>
														
														<div class="table-responsive dropdown-menu file_li">
															<table class="table table-striped table-hover" id="mytable-article<?php echo $value['id'];?>">
																<tbody>
																<?php 
																	if(isset($articles_name)){  
																		$i=1;  
																		foreach($articles_name as $file){ 
																?>
                												<tr>
                													<td><?php echo $i; ?></td>
                													<td><?php echo $file; ?></td>
                													<td>
																		<a href="<?php echo base_url().'page_design/attachments/articles/'.$Id.'/'.$value['id'].'/'.$file;?>" download target="_blank" >
																			<i class="fa fa-download"></i>
																		</a>
																	</td>
																	<td>
																		<!--<a href="<?php echo base_url().index_page().'new_client/home/page_attachment/'.$Id; ?>">-->
																			<input type="hidden" name="filename" id="article_name<?php echo $value['id'];?>" value="<?php echo $file; ?>">
																		<input type="button" name="remove" value="remove" onclick="remove_art(<?php echo $value['id'];?>)"><!--This is remove file option -->
																		<!--</a>-->
																	</td>
                												</tr>
																<?php $i++; } } ?>
																</tbody>
										 					</table>
														</div>
													</span>
													<div id="attachments">
														<span><?php //echo '1' ;?></span>
														<div action="<?php echo base_url().index_page()."new_client/home/page_artical_attch/".$value['id']; ?>" name="file" class="dropzone"enctype="multipart/form-data">
														</div>
													</div>
												</div>
											</td>
											
									<!-- Ads file upload -->		
										  	<td>
										  		<div class="form-group">
													<span>&nbsp;</span>
													<span class="dropdown margin-left-5 text-grey pull-right">
														<span class="cursor-pointer padding-left-5" type="button" data-toggle="dropdown" id="ads-view<?php echo $value['id']?>">
															View uploaded files 
															<span class="caret margin-left-5"></span>
														</span>
														<div class="table-responsive dropdown-menu file_li">  
															<table class="table table-striped table-hover" id="mytable-ads<?php echo $value['id']?>">
																<tbody>
																<?php 
																	if(isset($ads_name)){  
																		$i=1;  
																		foreach($ads_name as $file){ 
																?>
                												<tr>
                													<td><?php echo $i; ?></td>
                													<td><?php echo $file; ?></td>
                													<td>
																		<a href="<?php echo base_url().'page_design/attachments/ads/'.$Id.'/'.$value['id'].'/'.$file;?>" download target="_blank" >
																			<i class="fa fa-download"></i>
																		</a>
																	</td>
																	<td>
																		<!--<a href="<?php echo base_url().index_page().'new_client/home/page_attachment/'.$Id; ?>">-->
																			<input type="hidden" name="filename" id="ad_name<?php echo $value['id'];?>" value="<?php echo $file; ?>">
																		<input type="button" name="remove" value="remove" onclick="remove_ad(<?php echo $value['id'];?>)"><!--This is remove file option -->
																		<!--</a>-->
																	</td>
                												</tr>
																<?php $i++; } } ?>
																</tbody>
										 					</table>
														</div>
													</span>
													<div id="attachments">
														<span><?php //echo $a ;?></span>
														<div action="<?php echo base_url().index_page()."new_client/home/page_ads_attch/".$value['id']; ?>" name="file" class="dropzone"enctype="multipart/form-data">
														</div>
													</div>
												</div>
											</td>
										  	<td>
										  		<form method="post" action="<?php echo base_url().index_page()."new_client/home/page_message/".$value['id'];?>">
										  			<div class="form-group">
														<p class="margin-bottom-0"><span>Message</span></p>
														<textarea class="form-control text-area-height" placeholder="Type here..."  rows="4" name="message" required=""></textarea>
													</div>
													<div class="">
														<button type="submit" name="submit" class="btn  btn-blue margin-top-10 pull-right">Submit</button> 
													</div>
												</form>
											</td>
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
	</section>
</div>
<?php $this->load->view('new_client/footer') ?>
<script>
	function remove_art(i) {
 		 var fname =$('#article_name'+i).val();
 		 $.ajax({
 		 	url:"<?php echo base_url().index_page().'new_client/home/page_remove_att_art/';?>"+i,
 		 	data:'filename='+fname,
 		 	type:"POST",
 		 });
	}

	function remove_ad(i) {
 		 var fname =$('#ad_name'+i).val();
 		 $.ajax({
 		 	url:"<?php echo base_url().index_page().'new_client/home/page_remove_att_ads/';?>"+i,
 		 	data:'filename='+fname,
 		 	type:"POST",
 		 });
	}
	
<?php foreach($order_id as $value){ ?>
	   function RefreshTablePrint<?php echo $value['id']; ?>() { 
		   $( "#mytable-article<?php echo $value['id']; ?>" ).load( "<?php echo base_url().index_page()."new_client/home/page_attachment_files/".$Id.'/'.$value['id'];?> #mytable-article<?php echo $value['id']; ?>" );
		   
		   $( "#mytable-ads<?php echo $value['id']; ?>" ).load( "<?php echo base_url().index_page()."new_client/home/page_attachment_files/".$Id.'/'.$value['id'];?> #mytable-ads<?php echo $value['id']; ?>" );
	   }
	   $("#article-view<?php echo $value['id']; ?>").on("click", RefreshTablePrint<?php echo $value['id']; ?>);
	   $("#ads-view<?php echo $value['id']; ?>").on("click", RefreshTablePrint<?php echo $value['id']; ?>);
<?php } ?>	   
</script>
