<?php $this->load->view('new_admin/header')?>
	
			<div class="portlet light">
				<div class="row margin-bottom-5">	
					<div class="col-md-6 col-xs-12 margin-bottom-5">
						<a href="<?php echo base_url().index_page().'new_admin/home/manage'; ?>" class="font-lg">Manage</a> - 
						<u class="font-lg font-grey-gallery">Image Bank</u>
					</div>							
					<div class="col-md-6 col-xs-12 text-right">	
						<?php echo $this->session->flashdata('message'); ?>
						<span class="cursor-pointer" onclick="goBack()"><img src="assets/new_admin/img/back.png"></span>
					</div>			
				</div>
				<div class="portlet-body">
					<div class="row report margin-0 border-top border-bottom">
					<?php $image_bank = $this->db->query("SELECT * FROM `image_bank`")->result_array(); ?>
						<div class="col-md-4 col-sm-6 report-tab">
							<h3 class="font-blue margin-top-15 margin-bottom-5"><?php echo count($image_bank); ?></h3>
							<p class="font-grey-gallery margin-0">Total No Of Images</p>
						</div>
						<div class="col-md-4 col-sm-6 report-tab padding-right-20">
						<form method="get" > 
							<div class="input-group margin-top-25">
								<input type="text" name="id" class="form-control" placeholder="Enter Tag">
								<span class="input-group-btn">
								<button type="submit" name="search" class="btn bg-grey-gallery" type="button">Search</button>
								</span>
							</div>
						</form>
						</div>
						
						<div class="col-md-4 col-sm-6 report-tab padding-right-10 padding-left-40 align-center">
							<div class="text-right margin-right-5"><i class="fa fa-info-circle tooltips cursor-pointer" data-container="body" data-placement="left" data-original-title="Info in Tooltip"></i></div>
								<div class="row">
									<div class="col-md-8 col-md-offset-2">
									<form method="post" action="<?php echo base_url().index_page().'new_admin/home/multiple_image'; ?>" enctype="multipart/form-data">
										<div class="btn-group btn-block left-dropdown margin-top-5 margin-bottom-10">
											<span class="dropdown" data-toggle="dropdown" aria-expanded="true">
												<button class="btn default btn-block" id="filter"><i class="fa fa-upload fa-2x"></i> Uplaod Images</button>
											</span>
											<div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu">
												<input type="file" name="img_url" multiple class="form-control margin-bottom-10">
												<div class="text-right margin-top-10">
													<button type="submit" class="btn btn-primary btn-sm">Submit</button>
												</div>													
											</div>
										</div>	
										<!--<button type="submit" name="generate" class="btn default margin-bottom-10 btn-block"><i class="fa fa-copy fa-2x"></i> Generate</button>-->
									</form>		
										
										<button class="btn default btn-block"><i class="fa fa-gear fa-2x"></i> Settings</button>
									</div>
								</div>
						</div>
					</div>
				</div>
			</div>
		<!--
			<div class="col-md-12 imagebank">			 
				<?php if(isset($image)) { foreach($image as $sql) { ?>
					<div class="imgbank">
						<a href="<?php echo $sql['thumbnail_url']; ?>" target="_blank"><img class="border" src="<?php echo $sql['thumbnail_url']; ?>"></a>
						<div class="row margin-0 margin-top-5">
							<div class="col-md-10 col-sm-10 col-xs-6 padding-0">
								<span class="text-grey">ID:</span> <?php echo $sql['id']; ?>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-6 text-right padding-0"> 
							<a href='<?php echo $sql['url'];?>' >
								<i class="fa fa-download margin-right-5" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Download"></i> 
							</a>
							</div>
						</div>
					</div>				
				<?php } } ?>
			</div> 
			-->
			
			<div class="col-md-12">			 
				<div id="imagebank" class="justified-gallery">	
				<?php if(isset($image)) { foreach($image as $sql) { ?>
					<a href="<?php echo $sql['thumbnail_url']; ?>">
						<img src="<?php echo $sql['thumbnail_url']; ?>" />
						<div class="caption">
							ID: <?php echo $sql['id']; ?>
							<!--<span class="download" target="_Blank" onClick="window.location='<?php echo $sql['url'];?>'; return false;">
								<i class="fa fa-download margin-right-5"></i> 
							</span>-->
							<span class="download" onclick="window.open('<?php echo $sql['url'];?>', '_blank')">
							<i class="fa fa-download">&nbsp;</i> </span>
						</div>
					</a>								
				<?php } } ?>
				</div> 
			</div> 
		
	
<?php $this->load->view('new_admin/imagebank.php'); ?>