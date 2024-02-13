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
						<a href="#">AdwitAds ID: <?php echo $Id; ?></a>
					</p>
				</div>
				<div class="col-md-5 col-sm-12 col-xs-12">
					<form method="get"> 
						<div id="search">
							<div class="row">
								<div class="col-md-8 col-sm-8 col-xs-8 padding-right-0"></div>
							 	<div class="col-md-4 col-sm-4 col-xs-4 padding-left-0">
									<a href="<?php echo base_url().index_page()."new_client/home/dashboard/"?>" class="text-blue right"><i class="fa fa fa-angle-double-left"></i> back</a>
								</div>
						 	</div>	
						  </div>
					</form>	 
				</div>					 
			</div>
		</div>
		<div class="container margin-top-5"> <?php echo $this->session->flashdata('message');?> 
			<!-- <div class="col-md-12">
				<p class="margin-bottom-0 text-red"><span><b>Notes & Instructions you first Submit,then you Upload Articles and Ads.</b></span></p>
			</div> -->
		</div>
		
		<div class="container margin-top-5" > 
			<div class="col-md-6 col-sm-4 col-xs-12">
				<div class="form-group">
					<span>Articles / Images</span>
					<span class="dropdown margin-left-5 text-grey pull-right">
						<span class="cursor-pointer padding-left-5" type="button" data-toggle="dropdown" id="article-view" >
							View uploaded files 
							<span class="caret margin-left-5"></span>
						</span>
						<div class="table-responsive dropdown-menu file_li">
							<table class="table table-striped table-hover" id="mytable-article">
								<tbody>
									<?php $a=0;
										if(isset($articles_name)) 
										{ 
											$i=1;  
											foreach($articles_name as $row){?><!--This is listed the files -->
												<tr>
													<td><?php echo $i; ?></td>
													<td>
														<a href="<?php echo base_url().'page_design/revision/articles'.'/'.$Id.'/'.$rId.'/'.$row;?>" target="_blank">
															<?php echo $row?>
														</a>
													</td><!--This is path and name  option -->
													<td>
														<a href="<?php echo base_url().'page_design/articles'.'/'.$Id.'/'.$row;?>" download target="_blank" >
															<i class="fa fa-download"></i>
														</a>
													</td>
													<td>
														<input type="hidden" name="filename" id="article_name<?php echo $i;?>" value="<?php echo $row; ?>">
														<input type="button" name="remove" value="remove" onclick="remove_art(<?php echo $i;?>)"><!--This is remove file option -->
													</td>
												</tr>
									<?php   $a=$i++; 
											} 
										}?>
								</tbody>
							</table>
						</div>
					</span>
					<div id="attachments">
						<span><?php //echo $a ;?></span>
						<div action="<?php echo base_url().index_page()."new_client/home/page_revision_artical_upload/".$rId;?>" class="dropzone"> </div>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-4 col-xs-12">
				<div class="form-group">
					<span>Ads</span>
					<span class="dropdown margin-left-5 text-grey pull-right">
						<span class="cursor-pointer padding-left-5" type="button" data-toggle="dropdown" id="ads-view">
							View uploaded files 
							<span class="caret margin-left-5"></span>
						</span>
						<div class="table-responsive dropdown-menu file_li">  							 
							<table class="table table-striped table-hover" id="mytable-ads">
								<tbody>
									<?php 
									$a=0;
									if(isset($file_names1)) 
									{ 
										$i=1;  
										foreach($file_names1 as $row){?>
										<tr>
											<td><?php echo $i; ?></td>
											<td>
												<a href="<?php echo base_url().'page_design/ads'.'/'.$Id.'/'.$row;?>" target="_blank">
													<?php echo $row?>
												</a>
											</td>
											<td>
												<a href="<?php echo base_url().'page_design/ads'.'/'.$Id.'/'.$row;?>" download target="_blank" >
													<i class="fa fa-download"></i>
												</a>
											</td>
											<td>
												<input type="hidden" name="filename" id="ad_name<?php echo $i;?>" value="<?php echo $row;?>">
												<input type="button" name="remove" value="remove" onclick="remove_ad(<?php echo $i;?>)">
											</td>
										</tr>
								<?php   $a=$i++; 
										} 
									}?>
								</tbody>
							</table>
						</div>
					</span>
					<div id="attachments">
						<span><?php //echo $a ;?></span>
						<div action="<?php echo base_url().index_page()."new_client/home/page_revision_ads_upload/".$rId;?>" class="dropzone"> </div>
					</div>
				</div>
			</div>
			<div class="container margin-top-20"> 
				<form method="post" action="<?php echo base_url().index_page()."new_client/home/page_revision_note/".$Id.'/'.$rId;?>">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="form-group">
							<p class="margin-bottom-0"><span>Notes & Instructions</span></p>
							<textarea class="form-control text-area-height" placeholder="Type here..."  rows="4" name="notes" required=""></textarea>
						</div>
						<div class="">
							<button type="submit" name="submit"  class="btn  btn-blue margin-top-10 col-md-12">Submit</button> 
						</div>
					</div>
				</form>
			</div>
			<!-- <div class="col-md-12">
				<form method="post">
					<button type="submit" name="allsubmit"  class="btn  btn-blue margin-top-10 col-md-12">Submit</button>
				</form>
			</div> -->
		</div>
	</section>
</div>
<?php $this->load->view('new_client/footer') ?>
<script>
	   function RefreshTablePrint() { 
		   $( "#mytable-article" ).load( "<?php echo base_url().index_page()."new_client/home/page_revision_note/".$Id.'/'.$rId;?> #mytable-article" );
		   $( "#mytable-ads" ).load( "<?php echo base_url().index_page()."new_client/home/page_revision_note/".$Id.'/'.$rId;?> #mytable-ads" );
	   }
	   $("#article-view").on("click", RefreshTablePrint);
	   $("#ads-view").on("click",RefreshTablePrint);
</script>
<script>	

 	function  remove_art(i) {
 		 var fname =$('#article_name'+i).val();
 		 $.ajax({
 		 	url:"<?php echo base_url().index_page().'new_client/home/page_remove_rev_att/'.$rId;?>",
 		 	data:'filename='+fname,
 		 	type:"POST",
 		 });
	}

	function  remove_ad(i) {
 		 var fname =$('#ad_name'+i).val();
 		 $.ajax({
 		 	url:"<?php echo base_url().index_page().'new_client/home/page_remove_rev_ads/'.$rId;?>",
 		 	data:'filename='+fname,
 		 	type:"POST",
 		 });
	}

</script>