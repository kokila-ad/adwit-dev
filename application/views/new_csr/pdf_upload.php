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
</head>
<title><?php echo $this->session->userdata('client');?> @ Adwit Ads - Client</title>
<base href="<?php echo base_url();?>" />
<link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
<link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
<link href="theme001/vendors/jGrowl/jquery.jgrowl.css" rel="stylesheet" media="screen">
        <script src="theme001/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script src="js/rate.js" type="text/javascript"></script>
<link rel="stylesheet" href="stylesheet/style_fluid.css" type="text/css" />
<link rel="stylesheet" href="stylesheet/boilerplate.css" type="text/css" />
<link rel="stylesheet" href="flatmenu/flatmenu.css" type="text/css" />
<script>
    function closeWindow() {
        window.open('','_parent','');
        window.close();
    }
</script>
<body>
<table class="demo-table" align="center" width="0" border="0" cellspacing="0" cellpadding="0" style=" width:702px; border:#000 solid 1px;">
  <tr>
    <td><table width="0" border="0" cellspacing="0" cellpadding="0" style="width:702px;">
  <tr>
    <td align="center" style="background-color:#000;"><img src="images/logo.png" width="189" height="50"></td>
  </tr>
   <tr>
    <td><table align="center" width="0" border="0" cellspacing="0" cellpadding="0" style="width:682px; border-bottom:#cccccc solid 1px;">
	<tr>
   &nbsp;
  </tr>
  <tr>
    <td style=" width:176px;"><p class="alert alert-danger"><strong>Adwit Ads ID:</strong><b><?php echo $order_id; ?></b></p></td>
  </tr>
</table>
</td>
  </tr> 
  
  <tr><!-- star rating -->
   <?php echo '<h4 style="color:#900;">'.$this->session->flashdata('message').'</h4>'; ?>
    <td align="center">
	<form name="form" method="post" enctype="multipart/form-data">
	<div class="col-md-6">
													 &nbsp;
	</div>												 
			<input type="file" name="pdf" id="pdf" value="upload PDF"  />
			<br/><label>Note</label><br/>
			<textarea name="note" id="note" class="form-control"></textarea>
							
			<br/><label>Remarks</label><br/>
			<textarea name="remark" id="remark" class="form-control"> </textarea>
							
			     <button type="submit" class="btn blue" name="Submit" value="Submit" onclick="return confirm('Are you sure you want to end ?');" >Submit</button>
	</form>
	</td>
  </tr>
 </table>
 </tr>
   <tr>
    <td align="center"><p style=" font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:14px; margin:0px; padding:90px 0 35px 0; color:#666666; "><a class="btn default" href="javascript:closeWindow();">Close window</a></p></td>
  </tr>
</td>
  </tr>
</table>

          <script src="theme001/vendors/jquery-1.9.1.js"></script>
        <script src="theme001/bootstrap/js/bootstrap.min.js"></script>
        <script src="theme001/vendors/datatables/js/jquery.dataTables.min.js"></script>
        <script src="theme001/assets/scripts.js"></script>
        <script src="theme001/assets/DT_bootstrap.js"></script>
                <script>
        $(function() {
            
        });
        </script>
<script language="javascript" type="text/javascript">

	function load() {

	if ($('#loading_image').length == 0) { //is the image on the form yet?

					// add it just before the submit button

	$(':submit').after('<img src="images/up.gif" alt="Uploading...." id="loading_image" >')

	}

		$('#loading_image').show(); // show the animated image    

		 // disable double submits

		return true; // allow regular form submission

	};

</script>

</body>

