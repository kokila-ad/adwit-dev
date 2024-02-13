

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>Adwitads | Designer Dashboard</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css">
<base href="<?php echo base_url();?>" />

<link href="ui_assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="ui_assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css">
<link href="ui_assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="ui_assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css">
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link href="ui_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
<link href="ui_assets/admin/pages/css/profile.css" rel="stylesheet" type="text/css"/>
<link href="ui_assets/admin/pages/css/tasks.css" rel="stylesheet" type="text/css"/>
<link href="ui_assets/admin/pages/css/search.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN THEME STYLES -->
<link href="ui_assets/global/css/components-rounded.css" id="style_components" rel="stylesheet" type="text/css">
<link href="ui_assets/global/css/plugins.css" rel="stylesheet" type="text/css">
<link href="ui_assets/admin/layout3/css/layout.css" rel="stylesheet" type="text/css">
<link href="ui_assets/admin/layout3/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color">
<link href="ui_assets/admin/layout3/css/custom.css" rel="stylesheet" type="text/css">
<!-- END THEME STYLES -->
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-menu-fixed" class to set the mega menu fixed  -->
<!-- DOC: Apply "page-header-top-fixed" class to set the top menu fixed  -->
<body>

<!-- BEGIN HEADER -->
<div class="page-header">
	<!-- BEGIN HEADER TOP -->
	<div class="page-header-top">
		<div class="container">
			<!-- BEGIN LOGO -->
			<div class="page-logo">
				<a href="index.html"><img src="ui_assets/admin/layout3/img/logo-default.png" alt="logo" class="logo-default"></a>
			</div>
			<!-- END LOGO -->
			<!-- BEGIN RESPONSIVE MENU TOGGLER -->
			<a href="javascript:;" class="menu-toggler"></a>
			<!-- END RESPONSIVE MENU TOGGLER -->
			<!-- BEGIN TOP NAVIGATION MENU -->
			<div class="top-menu">
				<ul class="nav navbar-nav pull-right">
					<!-- BEGIN USER LOGIN DROPDOWN -->
					<li class="dropdown dropdown-user dropdown-dark">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
						<img alt="" class="img-circle" src="ui_assets/admin/layout3/img/avatar9.jpg">
						<span class="username username-hide-mobile">Acharya</span>
						</a>
						<ul class="dropdown-menu dropdown-menu-default">
							<li>
								<a href="extra_profile.html">
								<i class="icon-user"></i> My Profile </a>
							</li>
							<li class="divider">
							</li>
							<li>
								<a href="lock_screen.html">
								<i class="icon-lock"></i> Lock Screen </a>
							</li>
							<li>
								<a href="login.html">
								<i class="icon-key"></i> Log Out </a>
							</li>
						</ul>
					</li>
					<!-- END USER LOGIN DROPDOWN -->
				</ul>
			</div>
			<!-- END TOP NAVIGATION MENU -->
		</div>
	</div>
	<!-- END HEADER TOP -->
	<!-- BEGIN HEADER MENU -->
	<div class="page-header-menu">
		<div class="container">

			<!-- BEGIN MEGA MENU -->
			<!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
			<!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
			<div class="hor-menu ">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="index.html">Dashboard</a>
					</li>
					<li class="menu-dropdown classic-menu-dropdown ">
						<a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;">
						Reports <i class="fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu pull-left">
							<li class=" dropdown-submenu">
								<a href=javascript:;>
								<i class="icon-briefcase"></i>
								Orders </a>
								<ul class="dropdown-menu">
									<li class=" ">
										<a href="table_basic.html">
										Publication </a>
									</li>
								</ul>
							</li>
							<li class=" dropdown-submenu">
								<a href=javascript:;>
								<i class="icon-bar-chart"></i>
								Production </a>
								<ul class="dropdown-menu">
									<li class=" ">
										<a href="charts_amcharts.html">
										Designer </a>
									</li>
								</ul>
							</li>
						</ul>
					</li>
				</ul>
			</div>
			<!-- END MEGA MENU -->
		</div>
	</div>
	<!-- END HEADER MENU -->
</div>
<!-- END HEADER -->

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
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject grey-gallery bold ">Order #<?php echo $order_id; ?></span>
							</div>	
                             <div class="tools">
							 <?php
								if(isset($sourcefile)) { $this->load->helper('directory');	$map = glob($sourcefile.'/*.{zip}',GLOB_BRACE);
									if($map){ 
										foreach($map as $row) { $src = $row; } } }
							 ?>
								<span class="grey-gallery"> <a href="<?php echo base_url()?>download.php?file_source=<?php echo $src; ?>"><button><i class="fa fa-cloud-download"></i></button></a>|  <a href="#">Click to view V1</a></span>
							</div>							
						</div>
						<!--revision -->
						<?php foreach($rev_orders_all as $rev_row){ ?>
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject grey-gallery bold ">Revision<?php echo $rev_row['version']; ?></span>
							</div>	
							<?php if($rev_row['new_slug']!='none' && $rev_row['source_file']!='none'){ ?>
											
							<div class="tools">	
							<?php 
									$this->load->helper('directory');
									$map = glob($sourcefile.'/*');
							if($map){ 
							?>
								<form method="post" action="<?php echo base_url().index_page().'new_designer/home/zip_folder_select';?>" style="text-align: center;">
									<input name="slug" value="<?php echo($rev_row['new_slug'])?>" readonly style="visibility:hidden" />
									<input name="SourceFilePath" value="<?php echo($sourcefile)?>" readonly style="visibility:hidden" />
									<input name="source_file" value="<?php echo($rev_row['source_file'])?>" readonly style="visibility:hidden" />
									
									<button type="submit"><i class="fa fa-cloud-download"></i></button>
									<span class="grey-gallery"> |  <a href="#"><?php echo "Click to view ".$rev_row['version']; ?></a></span>
								</form>	
								
							<?php }  ?>
							</div>				
							<?php } ?>
						</div>
							<?php } ?>	
					</div>
					</div>	
					</div>
					<!-- END PROFILE CONTENT -->
				<?php echo '<h4 class="font-red">'.$this->session->flashdata('message').'</h4>'; ?>	
			    	</div>
		    	</div>
			<!-- END PROFILE -->
			</div>
	   


			<div class="row margin-top-10">
				<div class="col-md-12">
					<!-- BEGIN PROFILE CONTENT -->
					<div class="profile-content">
						<div class="row">				  						   
						   <div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject grey-gallery bold ">Revision <?php echo $rev_orders[0]['version']; ?> <small><?php echo $rev_orders[0]['date']; ?></small></span>
							</div>	
                             <div class="tools">
								 <span class="grey-gallery">10th Jan 2016 (Billed Date)</span>
							</div>							
						</div>
						<div class="row portlet-body">
						   <div class="col-md-6">	
                            <div class="portlet box blue-chambray">
													<div class="portlet-title">
														<div class="caption">Instructions</div>
													</div>
													<div class="portlet-body">
													  <div class="margin-bottom-20">
														<p> <?php echo $rev_orders[0]['note']; ?> </p>
														<!--<p> Acurian </p>
														<p> AG/AC001/TSCS/2016 </p>
														<p> Leonard Martin </p>-->
													  </div>
													  <div style="margin-top:50px">																			
														<h4 class="font-red"> CSR Instructions</h4>
														<p> Acurian </p>
														<p> AG/AC001/TSCS/2016 </p>
														<p> Leonard Martin </p>
													   </div>	
													</div>
												</div>
						   </div>
							
						    <div class="col-md-6">	
                            <div class="portlet box blue-chambray">
													<div class="portlet-title">
														<div class="caption">Downloads</div>
														<div class="tools">
															<span><a href="#" class="font-grey-cararra"><i class="fa fa-cloud-download"></i></a></span>
														</div>
													</div>
							<div class="portlet-body">
							<table class="table table-scrollable table-striped table-hover">
								<tbody>
								<?php 
									if($rev_orders[0]['file_path'] != 'none'){ 
										$filepath = $rev_orders[0]['file_path'];
										$this->load->helper('directory');
										$map = glob($filepath.'/*',GLOB_BRACE);
										if($map){ foreach($map as $row1){
								?>
								<tr>
								<td><?php echo basename($row1) ?></td>
								<td class="text-right">
								<span><a href="<?php echo base_url()?>download.php?file_source=<?php echo $row1; ?>" class="font-grey-gallery"><i class="fa fa-cloud-download"></i></a></span>							
								</td> 		  
								</tr>  
								<?php } } } ?> 
								</tbody>
							</table>  
							</div>
							</div>
							</div>	
						 
						 </div>
			<?php if($rev_orders[0]['new_slug'] == 'none'){ ?>		 
						<div class="row">
							<div class="col-md-6">	
								<form name="myform" method="post" >
									<button type="submit" name="create_slug" class="btn green">Create Slug</button>
									<input name="id" value="<?php echo $rev_orders[0]['id'];?>" readonly style="display:none;" />
									<input name="order_id" value="<?php echo $rev_orders[0]['order_id'];?>" readonly style="display:none;" />
									<input name="prev_slug" value="<?php echo $rev_orders[0]['order_no'];?>" readonly style="display:none;" />
									<input name="version" value="<?php echo $rev_orders[0]['version'];?>" readonly style="display:none;" />
								</form>
								
							</div>
						</div>
			<?php }elseif($rev_orders[0]['status']<'4'){ ?>
						<div class="row">
							<div class="col-md-6">	
							New Slug : <h4 class="font-blue"><?php echo $rev_orders[0]['new_slug']; ?></h4>
							</div>
						</div>
						
						<div class="row">
						    <div class="col-md-6">	
                            <div class="portlet box blue-chambray">
													<div class="portlet-title">
														<div class="caption">Upload if any link added</div>
													</div>
													<div class="portlet-body">												 
									<form method="post" id="links" enctype="multipart/form-data">
									    <div class="input-group">
											<input type="file" name="userfile[]" accept="image/*" multiple class="form-control" placeholder="Drag & Drop File">
											<input type="text" name="type" value="link" class="form-control" placeholder="Drag & Drop File" style="display:none;">
											<span class="input-group-btn">
											<button name="fupload" class="btn blue-chambray" type="submit">Upload</button>
											</span>										
									    </div>
								    </form>	
													</div>
												</div>
						   </div>
						   <div class="col-md-6">	
                            <div class="portlet box blue-chambray">
													<div class="portlet-title">
														<div class="caption">Upload if any fonts added</div>
													</div>
													<div class="portlet-body">												 
										<form method="post" id="fonts" enctype="multipart/form-data">
									    <div class="input-group">
											<input type="file" name="userfile[]" accept=".otf, .ttf" multiple class="form-control" placeholder="Drag & Drop File">
											<input type="text" name="type" value="fonts" class="form-control" placeholder="Drag & Drop File" style="display:none;">
											<span class="input-group-btn">
											<button name="fupload" class="btn blue-chambray" type="submit">Upload</button>
											</span>										
									    </div>
										</form>		
													</div>
												</div>
						   </div>
						   
						</div>	
						
						<div class="row">
						    
						   <div class="col-md-6">	
                            <div class="portlet box blue-chambray">
										<div class="portlet-title">
											<div><h3>Upload new indd and PDF file only</h3><p class="help-block">File name should be same as slug displayed above.</p></div>
										</div>
										<div class="portlet-body">												 
										<form method="post" enctype="multipart/form-data">
									    <div class="input-group">
											<input type="file" name="file" id="file" accept=".indd, .psd, .ai" required/>
											<p class="help-block">Only For .indd .psd .ai file</p>
											
											<input type="file" name="file1" id="file1" accept=".pdf" required/>
											<p class="help-block">Only For Pdf file.</p>
											<input type="text" hidden name="slug" value="<?php  echo $rev_orders[0]['new_slug']; ?>" >
											<input type="text" hidden name="slug1" value="<?php  echo $rev_orders[0]['new_slug']; ?>.pdf" >
											
											<button name="sourceUpload" class="btn blue-chambray" type="submit">Upload</button>
																				
									    </div>
										<?php if(isset($msg)) echo "<b> $msg </b>"?>
										</form>		
										</div>
							</div>
						   </div>
						   
							<div class="col-md-6 text-center" style="margin-top: 80px;">
							<?php if($rev_orders[0]['source_file']!='none'){ ?>
								<form method="post">
                                <button type="submit" name="complete" class="btn blue-chambray">Completed</button>
								</form>
							<?php } ?>	
								<?php if(isset($sucess_message)) echo '<p>'.$sucess_message.'</p>'; ?>
							</div>	
						   
					</div>
			<?php }elseif($rev_orders[0]['source_file']!='none'){ ?>
						<div class="col-md-6">	
                            <div class="portlet box blue-chambray">
										<div class="portlet-title">
											<div class="caption">Uploaded Source</div>
										</div>
										<div class="portlet-body">
											<?php 
													$this->load->helper('directory');
													$map = glob($sourcefile.'/*');
													if($map){ ?>
													
			<form method="post" action="<?php echo base_url().index_page().'new_designer/home/zip_folder_select';?>" style="text-align: center;">
				<input name="slug" value="<?php echo($rev_orders[0]['new_slug'])?>" readonly style="visibility:hidden" />
				<input name="SourceFilePath" value="<?php echo($sourcefile)?>" readonly style="visibility:hidden" />
				<input name="source_file" value="<?php echo($rev_orders[0]['source_file'])?>" readonly style="visibility:hidden" />
				<?php echo $rev_orders[0]['new_slug']; ?>
				<button type="submit">
				<i class="fa fa-cloud-download"></i>
				</button>
				
			</form>		
											<?php }  ?>
											
										</div>
							</div>
						   </div>
			<?php } ?>
				</div>

		
				    	</div>
					<!-- END PROFILE CONTENT -->
			    	</div>
		    	</div>
			<!-- END PROFILE -->
			</div>
	   
	         
	   </div>
	</div>
	<!-- END PAGE CONTENT -->
	
	
</div>
<!-- END PAGE CONTAINER -->


<!-- BEGIN PRE-FOOTER -->
	
<!-- END PRE-FOOTER -->

<!-- BEGIN FOOTER -->
<div class="page-footer">
	<div class="container">
		 2014 &copy; Metronic. All Rights Reserved.
	</div>
</div>
<div class="scroll-to-top">
	<i class="icon-arrow-up"></i>
</div>
<!-- END FOOTER -->

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="ui_assets/global/plugins/respond.min.js"></script>
<script src="ui_assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="ui_assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="ui_assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="ui_assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
<script src="ui_assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="ui_assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="ui_assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="ui_assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="ui_assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="ui_assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="ui_assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="ui_assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>


<script type="text/javascript" src="ui_assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
<script src="ui_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
<script src="ui_assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
<script src="ui_assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="ui_assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="ui_assets/admin/layout3/scripts/layout.js" type="text/javascript"></script>
<script src="ui_assets/admin/layout3/scripts/demo.js" type="text/javascript"></script>
<script src="ui_assets/admin/pages/scripts/table-advanced.js"></script>
<script src="ui_assets/global/scripts/datatable.js"></script>
<script src="ui_assets/admin/pages/scripts/table-ajax.js"></script>
<script src="ui_assets/admin/pages/scripts/profile.js" type="text/javascript"></script>
<script src="ui_assets/admin/pages/scripts/ui-alert-dialog-api.js"></script>

<script>
jQuery(document).ready(function() {       
   // initiate layout and plugins
   Metronic.init(); // init metronic core components
   Layout.init(); // init current layout
   Demo.init(); // init demo features

$("#uploadAll").click(function(){ 
	 $("#links").submit();
	 $("#fonts").submit();
	 $("#source").submit();
	 $("#pdf").submit();
});
   
});
</script>
</body>
<!-- END BODY -->
</html>