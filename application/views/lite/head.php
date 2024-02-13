<!DOCTYPE html>
<html class="no-js" lang="">
    <head>
        
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Adwit Lite</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/lite/css/bootstrap.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/lite/css/datepicker.css"/>
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/lite/css/awemenu.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/lite/css/font-awesome.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/lite/css/main.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/lite/css/dropzone.css"/>
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/lite/css/datatables.min.css"/> 
		<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/lite/favicon.ico"/>		
		<script src="<?php echo base_url(); ?>assets/lite/js/modernizr-2.8.3.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/lite/js/jquery-1.11.3.min.js"></script>	
		
	
		<script>
		 $(document).ready(function(){
		 $("#advancesearch").hide();
	  
		 $("#showadvancesearch").click(function(){
			$("#advancesearch").toggle();  
			$("#search").toggle();  		
		  });
		 
		 $("#showsearch").click(function(){
			$("#advancesearch").toggle();  
			$("#search").toggle();  		
		  });
		 
		$('#example1').DataTable( {
		"order": [[ 0, "desc" ]]
		} );
		
		$('#example1').DataTable(); 
		 });
	  </script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-24406365-4', 'auto');
  ga('send', 'pageview');

</script>
    </head>
    <body>
      

		