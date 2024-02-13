<?php $this->load->view('new_designer/head')?>

<style>
	.border-left { border-left: 1px solid #ccc;}
	.border-top { border-top: 1px solid #ccc;}
	.border-bottom { border-bottom: 1px solid #ccc;}
	.padding-0 { padding: 0 !important;}
	.margin-top-15 { margin-top: 15px; }
	.padding-15 { padding:15px; }
	.download {cursor: pointer; float: right;}
	.download:hover {color: #4ef5c7;}
</style>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/new_admin/plugins/imagebank/justifiedGallery.css" type="text/css" media="all" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/new_admin/plugins/imagebank/colorbox.css" type="text/css" media="screen" />

	<div class="container">
			<div class="portlet light">
				<div class="row margin-bottom-5">	
					<!--<div class="col-md-6 col-xs-12 margin-bottom-5">
						<a href="<?php echo base_url().index_page().'new_admin/home/manage'; ?>" class="font-lg">Manage</a> - 
						<u class="font-lg font-grey-gallery">Image Bank</u>
					</div>							
					<div class="col-md-6 col-xs-12 text-right">	
						<?php echo $this->session->flashdata('message'); ?>
						<span class="cursor-pointer" onclick="goBack()"><img src="assets/new_admin/img/back.png"></span>
					</div>	-->		
				</div>
				<div class="portlet-body">
					<div class="row report margin-0 border-top border-bottom">
						<div class="col-md-6 col-xs-4 report-tab padding-top-15">							
							<p class="font-grey-gallery margin-top-20"><?php if(isset($key)){ ?>Entered Keyword: <?php echo $key; } ?></p>
						</div>
						<div class="col-md-6 col-xs-8 report-tab border-left padding-15">
						<form method="get" > 
							<div class="input-group margin-top-25">
								<input type="text" name="id" class="form-control" placeholder="Enter Tag">
								<span class="input-group-btn">
								<button type="submit" name="search" class="btn bg-grey-gallery" type="button">Search</button>
								</span>
							</div> 
						</form>
						</div>
						
						
					</div>
				</div>
			</div>
			<h4 class="text-center"><?php echo $this->session->flashdata('message'); ?></h4>
			
			<!--
			<div class="imagebank">			 
				<?php if(isset($image)) { foreach($image as $sql) { ?>
					<div class="imgbank">
						<a href="<?php echo $sql['thumbnail_url']; ?>" target="_blank"><img class="border" src="<?php echo $sql['thumbnail_url']; ?>"></a>
						<div class="row margin-0">
							<div class="col-md-6 col-sm-6 col-xs-6 margin-top-5">
								<span class="text-grey">ID:</span> <?php echo $sql['id']; ?>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6 text-right margin-top-5"> 
							<a href='<?php echo $sql['url'];?>' >
								<i class="fa fa-download margin-right-5" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Download"></i> 
							</a>
							</div>
						</div>
					</div>				
				<?php } } ?>				
			</div>
			--->
	
			<div class="col-md-12 margin-bottom-30">			 
				<div id="imagebank" class="justified-gallery">	
				<?php if(isset($image)) { foreach($image as $sql) { ?>
					<a href="<?php echo $sql['thumbnail_url']; ?>">
						<img src="<?php echo $sql['thumbnail_url']; ?>" />
						<div class="caption">
							ID: <?php echo $sql['id']; ?>
							<!--<span class="download" onClick="window.location='<?php echo $sql['url'];?>'; return false;">
								<i class="fa fa-download"></i> 
							</span>-->
							
							<span class="download" onclick="window.open('<?php echo $sql['url'];?>', '_blank')">
							<i class="fa fa-download">&nbsp;</i> </span>
							
						</div>
					</a>								
				<?php } } ?>
				</div> 
			</div> 
				
	</div>
	
	


<?php $this->load->view('new_designer/imgbank')?>