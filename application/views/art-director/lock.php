<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<script type="text/javascript">
        window.history.forward();
        function noBack()
        {
            window.history.forward();
        }
		history.pushState({ page: 1 }, "title 1", "#nbb");
    window.onhashchange = function (event) {
        window.location.hash = "nbb";

    };
</script>
<head>
<meta charset="utf-8"/>
<title>Metronic | Lock Screen 1</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<link href="../../../ui_assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="../../../ui_assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
<link href="../../../ui_assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="../../../ui_assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link href="../../../ui_assets/admin/pages/css/lock.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN THEME STYLES -->
<link href="../../../ui_assets/global/css/components-rounded.css" id="style_components" rel="stylesheet" type="text/css"/>
<link href="../../../ui_assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="../../../ui_assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
<link href="../../../ui_assets/admin/layout/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
<link href="../../../ui_assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body onLoad="noBack();" onpageshow="if (event.persisted) noBack();" onUnload="">
          <?php
	$art_director=$this->db->get_where('art_director',array('username' => $this->session->userdata('art')))->result_array();
	?>
<div class="page-lock">
	<div class="page-logo">
		<a class="brand" href="index.html">
		<img src="../../../ui_assets/admin/layout3/img/logo-big.png" alt="logo"/>
		</a>
	</div>
	<div class="page-body">
		<div class="lock-head">
			 Locked
		</div>
		<center>
		<?php if(isset($psd))  echo '<h4 style="color:red;">'. $psd .'</h4>';?>
		</center>
		<div class="lock-body">
			<div class="pull-left lock-avatar-block">
				<img src="<?php echo base_url() ?>/images/<?php echo $art_director[0]['image_path']; ?>" class="lock-avatar">
			</div>
			<form class="lock-form pull-left"  method="post">
				<h4><?php echo $this->session->userdata('art');?></h4>
				<div class="form-group">
					<input class="form-control placeholder-no-fix" type="password" autocomplete="off" required="required" placeholder="Password" name="password"/>
					<input type="text"  id="aid" name="aid" value="<?php echo $art_director[0]['id']; ?>"Hidden />
				</div>
				<div class="form-actions">
					<button type="submit" name="submit" class="btn btn-success uppercase">Login</button>
				</div>
			</form>
		</div>
		<div class="lock-bottom">
			<a href="<?php echo base_url().index_page()?>">Not <?php echo $this->session->userdata('art');?> </a>
		</div>
	</div>
	<div class="page-footer-custom">
		 2014 &copy; Metronic. Admin Dashboard Template.
	</div>
</div>
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="../../../ui_assets/global/plugins/respond.min.js"></script>
<script src="../../../ui_assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="../../../ui_assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="../../../ui_assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<script src="../../../ui_assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../../ui_assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="../../../ui_assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="../../../ui_assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="../../../ui_assets/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script src="../../../ui_assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="../../../ui_assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="../../../ui_assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script>
jQuery(document).ready(function() {    
	Metronic.init(); // init metronic core components
	Layout.init(); // init current layout
	Demo.init();
});
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>