<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css">
<link href="../../../../../ui_assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="../../../../../ui_assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css">
<link href="../../../../../ui_assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="../../../../../ui_assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css">
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link href="../../../../../ui_assets/global/plugins/icheck/skins/all.css" rel="stylesheet"/>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME STYLES -->
<link href="../../../../../ui_assets/global/css/components-rounded.css" id="style_components" rel="stylesheet" type="text/css">
<link href="../../../../../ui_assets/global/css/plugins.css" rel="stylesheet" type="text/css">
<link href="../../../../../ui_assets/admin/layout3/css/layout.css" rel="stylesheet" type="text/css">
<link href="../../../../../ui_assets/admin/layout3/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color">
<link href="../../../../../ui_assets/admin/layout3/css/custom.css" rel="stylesheet" type="text/css">
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
<title>CSR | Adwitads</title>
<script>
function goBack() {
    window.history.back();
}
</script>
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
				<a href="<?php echo base_url().index_page()."new_csr/home";?>"><img src="../../http://198.57.184.151/~adwitac/weborders//images/logo-default.png" alt="logo" class="logo-default"></a>
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
						<img alt="" class="img-circle" src="../../../../../ui_assets/admin/layout3/img/avatar9.jpg">
						<?php
	$csr_name=$this->db->get_where('csr',array('id' => $this->session->userdata('sId')))->result_array()
	?>
						<span class="username username-hide-mobile"><?php echo $csr_name[0]['name'];?> </span>
						</a>
						<ul class="dropdown-menu dropdown-menu-default">
							<li>
								<a href="extra_profile.html">
								<i class="icon-user"></i> My Profile </a>
							</li>
							<li class="divider">
							</li>
							<li>
								<a href="extra_lock.html">
								<i class="icon-lock"></i> Lock Screen </a>
							</li>
							<li>
								<a href="<?php echo base_url().index_page()."csr/login/shutdown";?>">
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
	<div class="page-header-menu">
		<div class="container">
			<!-- BEGIN HEADER SEARCH BOX -->
				
			<form class="search-form"  name="form" method="post" action="<?php echo base_url().index_page().'csr/home/cshift_order_search'; ?>">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Search" name="id">
					<span class="input-group-btn">
					<a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
					<input type="submit" name="search" style="display: none;" />
					</span>
				</div>
			</form>
			      
			<!-- END HEADER SEARCH BOX -->
			<!-- BEGIN MEGA MENU -->
			<!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
			<!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
			<div class="hor-menu ">
				<ul class="nav navbar-nav">
					<li>
						<a href="<?php echo base_url().index_page()."new_csr/home";?>">Dashboard</a>
					</li>
					<li class="active">
						<a href="<?php echo base_url().index_page()."csr/home/cshift";?>">New Ad</a>
					</li>
					<li>
						<a href="<?php echo base_url().index_page()."csr/home/frontlinetrack_all";?>">Revision</a>
					</li>
				</ul>
			</div>
			<!-- END MEGA MENU -->
		</div>
	</div>
<script type="text/javascript">
function closeWin()
{
	myWindow.close();
}
</script>
<link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
<link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
<link href="theme001/vendors/jGrowl/jquery.jgrowl.css" rel="stylesheet" media="screen">
<link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/DT_bootstrap.css" rel="stylesheet" media="screen">
        <script src="theme001/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script> 

<div class="container"> 
<div class="span12">
                                     <form class="form-horizontal"  method="post">
                                      <fieldset>
									  <div> 
									  &nbsp;
									  </div>
                                        <p class="alert alert-danger"><b>Remarks/Remove</b></p>
                                        <div class="control-group">
                                          <label class="control-label" for="focusedInput">Adwit Id</label>
                                          <div class="controls">
                                            <input type="text" class="form-control" id="order_no" name="order_no"  value="<?php echo $cat_result['order_no'];?>" readonly />
                                          </div>
                                        </div>
										<div class="control-group">
                                          <label class="control-label" for="focusedInput">Job Name</label>
                                          <div class="controls">
                                            <input type="text" class="form-control" id="job_name" name="job_name"  value="<?php echo $cat_result['job_name'];?>" readonly />
                                          </div>
                                        </div>
                                        <div class="control-group">
                                          <label class="control-label">Reson/Remarks</label>
                                          <div class="controls">
                                            <textarea class="form-control" name="reason"  value="<?php echo $cat_result['reason'];?>" style="width:470px; height:80px;" required></textarea>
                                          </div>
                                        </div>
											<div> 
									  &nbsp;
									  </div>
                                        <div style="padding-left: 180px;">
                                        <!--<button type="submit" name="Submit" value="Submit" class="btn btn-primary">Save changes</button>-->
                                          <button name="remove" value="Remove" class="btn btn-danger" onclick="return confirm('Are you sure you want to remove ?');">Remove</button>
                                          <a onclick="goBack()" style="cursor:pointer; text-decoration: none;"><button class="btn">Back</button></a>
										  
                                        </div>
										<div> 
									  &nbsp;
									  </div>
                                      </fieldset>
                                    </form>

                                </div>

</div>

          <script src="theme001/vendors/jquery-1.9.1.js"></script>
        <script src="theme001/bootstrap/js/bootstrap.min.js"></script>
        <script src="theme001/vendors/datatables/js/jquery.dataTables.min.js"></script>


        <script src="theme001/assets/scripts.js"></script>
        <script src="theme001/assets/DT_bootstrap.js"></script>
        <script>
        $(function() {
            
        });
        </script>
<div class="page-footer">
	<div class="container">
		 2015 &copy; adwitads. All Rights Reserved.
	</div>
</div>
<div class="scroll-to-top">
	<i class="icon-arrow-up"></i>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="../../../../../ui_assets/global/plugins/respond.min.js"></script>
<script src="../../../../../ui_assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="../../../../../ui_assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="../../../../../ui_assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="../../../../../ui_assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
<script src="../../../../../ui_assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../../../../ui_assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="../../../../../ui_assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../../../../ui_assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="../../../../../ui_assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="../../../../../ui_assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="../../../../../ui_assets/global/plugins/icheck/icheck.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../../../../../ui_assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="../../../../../ui_assets/admin/layout3/scripts/layout.js" type="text/javascript"></script>
<script src="../../../../../ui_assets/admin/layout3/scripts/demo.js" type="text/javascript"></script>
<script src="../../../../../ui_assets/admin/pages/scripts/form-icheck.js"></script>
<!-- BEGIN END LEVEL SCRIPTS -->
<script>
     jQuery(document).ready(function() {    
         Metronic.init(); // init metronic core components
Layout.init(); // init current layout
Demo.init(); // init demo features
FormiCheck.init(); // init page demo
      });
   </script>