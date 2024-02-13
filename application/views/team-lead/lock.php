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
<title>Team Lead | Lock Screen</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<base href="<?php  echo base_url();  ?>"/>
<link href="ui_assetss/global/fonts.googleapis.css" rel="stylesheet" type="text/css">
<link href="ui_assetss/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="ui_assetss/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css">
<link href="ui_assetss/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="ui_assetss/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css">
<link href="ui_assetss/global/css/components-rounded.css" id="style_components" rel="stylesheet" type="text/css">
<link href="ui_assetss/global/css/plugins.css" rel="stylesheet" type="text/css">
<link href="ui_assetss/admin/layout3/css/layout.css" rel="stylesheet" type="text/css">
<link href="ui_assetss/admin/layout3/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color">
<link href="ui_assetss/admin/layout3/css/custom.css" rel="stylesheet" type="text/css">
<link href="ui_assetss/lock.css" rel="stylesheet" type="text/css"/>

<link rel="shortcut icon" href="ui_assetss/favicon.ico"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body onLoad="noBack();" onpageshow="if (event.persisted) noBack();" onUnload="">
          <?php
	$team=$this->db->get_where('team_lead',array('id' => $this->session->userdata('tId')))->result_array();
	?>
<div class="page-lock">
	<div class="page-logo">
		<a class="brand" href="index.html">
		<img src="<?php echo base_url() ?>ui_assetss/lockscreen.png" alt="logo"/>
		</a>
	</div>
	<div class="page-body">
		<div class="lock-head" style="color:#fff;">
			 Locked
		</div>
		<center>
		<?php if(isset($psd))  echo '<h4 style="color:red;">'. $psd .'</h4>';?>
		</center>
		<div class="lock-body">
			<div class="pull-left lock-avatar-block">
				<img src="<?php echo base_url() ?><?php echo $team[0]['image']; ?>" class="lock-avatar">
			</div>
			<form class="lock-form pull-left"  method="post">
				<h4><?php echo $this->session->userdata('art');?></h4>
				<div class="form-group">
					<input class="form-control placeholder-no-fix" type="password" autocomplete="off" required="required" placeholder="Password" name="password"/>
					<input type="text"  id="aid" name="aid" value="<?php echo $team[0]['id']; ?>"Hidden />
				</div>
				<div class="form-actions">
					<button type="submit" name="submit" class="btn btn-success uppercase">Login</button>
				</div>
			</form>
		</div>
		<div class="lock-bottom">
			<!--<a href="<?php echo base_url().index_page()?>">Not <?php echo $team[0]['first_name'];?> </a>-->
		</div>
	</div>
	<div class="page-footer-custom">
		 2016 © adwitads. All Rights Reserved. version 4.1
	</div>
</div>
</body>
<!-- END BODY -->
</html>