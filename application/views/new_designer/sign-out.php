<?php
	$this->load->view("designer/header");
?>
        <link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
        <link href="theme001/vendors/jGrowl/jquery.jgrowl.css" rel="stylesheet" media="screen">
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <script src="theme001/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>

<div id="Middle-Div">
<div style="text-align: center;">
<p style="padding-top: 100px;">&nbsp;</p>
<p><b style="color:#F00"> Do you know that not submitting Daily/Weekly/Monthly report will affect your daily NJ / Performance Report? </b></p>
<p >Please click on <b>YES button</b> if you have submitted the report else click on <b>NO button</b> and submit the report. </p>
<a href="<?php echo base_url().index_page()."designer/login/shutdown";?>"><button> YES </button></a>
<a href="<?php echo base_url().index_page()."designer/home/links";?>"><button> NO </button></a>
<p style="padding-top: 100px;">&nbsp;</p>
</div>
</div>
  
    <script src="theme001/vendors/jquery-1.9.1.min.js"></script>
        <script src="theme001/bootstrap/js/bootstrap.min.js"></script>
        <script src="theme001/vendors/jGrowl/jquery.jgrowl.js"></script>
        <script src="theme001/assets/scripts.js"></script> 
		<?php
	$this->load->view("designer/footer");
?>