<!DOCTYPE html>
<html class="no-js" lang="">
<head>
        
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>AdwitAds</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

	<!-- build:css css/bootstrap.css -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/india_client/css/bootstrap.css">
	<!-- endbuild -->
	<!-- build: datepicker -->
	<link href="<?php echo base_url(); ?>assets/india_client/css/datepicker/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url(); ?>assets/india_client/css/datepicker/css/datepicker.css" rel="stylesheet" type="text/css"/>
	<!-- end: datepicker -->	
	<!-- build:css css/plugins.css -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/india_client/css/awe-icon.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/india_client/css/font-awesome.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/india_client/css/magnific-popup.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/india_client/css/owl.carousel.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/india_client/css/awemenu.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/india_client/css/swiper.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/india_client/css/easyzoom.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/india_client/css/nanoscroller.css">
	<!-- endbuild -->
	<!-- build:css css/styles.css -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/india_client/css/awe-background.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/india_client/css/main.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/india_client/css/docs.css">
	<!-- endbuild -->
	<!-- pagination -->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/india_client/css/pagination/datatables.min.css"/> 
	<!-- endpagination -->		
	<!-- build:js js/vendor.js -->
	<script src="<?php echo base_url(); ?>assets/india_client/js/vendor/modernizr-2.8.3.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/india_client/js/vendor/jquery-1.11.3.min.js"></script>
	<!-- endbuild -->
	<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/india_client/favicon.ico"/>		
	<script>window.SHOW_LOADING = false;</script>
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
	 });
  </script> 
</head>
<body>
    
<div id="wrapper" class="main-wrapper ">
            
 
   <section class="border-bottom topbar">
     <div class="container">
      <div class="row">
	   <div class="col-md-8">
	   <div class="border-left padding-vertical-10 padding-left-0 padding-right-15 float-left">
			<a href="mailto:itsupport@adwitads.com"><small><i class="glyphicon glyphicon-envelope margin-horizontal-10"></i></small>
			itsupport@adwitads.com
			</a>
	   </div>
	   </div>
	   
	   <div class="col-md-4">
	    <ul class="float-right border-right">
		  <li><a href="https://www.facebook.com/adwitglobal" target="_blank"><i class="icon icon-facebook"></i></a></li>
		  <li><a href="https://twitter.com/adwit"  target="_blank"><i class="icon icon-twitter"></i></a></li>
		  <li><a href="https://plus.google.com/111920031867514571462/posts" target="_blank"><i class="icon icon-google-plus"></i></a></li>
		</ul>
	   </div>
	 </div>
    </div>
   </section>
   
 
    <header id="header" class="awe-menubar-header">
        <nav class="awemenu-nav navbar-fixed-top" data-responsive-width="1200">
            <div class="container">
                <div class="awemenu-container">

              
                    <div class="awe-logo">
                        <a href="<?php echo base_url().index_page()."india_client/home"?>" title=""><img src="<?php echo base_url(); ?>assets/india_client//img/logo.png" alt=""></a>
                    </div><!-- /.awe-logo -->


                    <ul class="awemenu awemenu-right">
                         <li class="awemenu-item">
                            <a href="<?php echo base_url().index_page()."india_client/home"?>" title="">Home</a>
                        </li>

                       <li class="awemenu-item">
                            <a href="<?php echo base_url().index_page()."india_client/home/place_order";?>" title="">Place Order</a>
                       </li>
						
						<?php $adrep_id = $this->session->userdata('icId');
						$adrep = $this->db->query("SELECT * FROM `adreps` WHERE `id` = $adrep_id")->result_array();
						$publication = $this->db->get_where('publications',array('id' => $adrep[0]['publication_id']))->result_array();
						if($publication[0]['enable_request'] == '1'){ ?>
						<li class="awemenu-item">
							<a href="<?php echo base_url().index_page()."india_client/home/request_order";?>" title="">Request</a>
						</li>
						<?php } ?>
						    
					   <li class="awemenu-item">
                            <a href="<?php echo base_url().index_page()."india_client/home/dashboard";?>" title="">Dashboard</a>   
                        </li>
						                        
                        <li class="awemenu-item">
                            <a class=" border-right" href="#"><small><img src="<?php echo base_url(); ?>assets/india_client/img/profile.png" alt="profile"></small><?php echo $adrep[0]['first_name'].' '.$adrep[0]['last_name']; ?></a>
                            <ul class="awemenu-submenu awemenu-megamenu" data-width="170px" data-animation="fadeup">
                                <li class="awemenu-megamenu-item padding-0">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <ul class="list-unstyled">
                                                    <li class="awemenu-item border-bottom"><a href="<?php echo base_url().index_page()."india_client/home/profile";?>">View Profile</a></li>
												    <!--<li class="awemenu-item border-bottom"><a href="<?php echo base_url().index_page()."india_client/home/faq";?>">Help</a></li>-->
													<li class="awemenu-item"><a href="<?php echo base_url().index_page()."india_client/login/shutdown"?>">Signout</a></li>
												</ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>

                    </ul><!-- /.awemenu -->
                </div>
            </div><!-- /.container -->

        </nav><!-- /.awe-menubar -->
    </header><!-- /.awe-menubar-header -->

                        </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>

                    </ul><!-- /.awemenu -->
                </div>
            </div><!-- /.container -->

        </nav><!-- /.awe-menubar -->
    </header><!-- /.awe-menubar-header -->
	
	