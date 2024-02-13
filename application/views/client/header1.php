<!doctype html>

<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->

<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->

<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->

<!--[if gt IE 8]><!-->

<html class="">

<!--<![endif]-->

<head>

<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title><?php echo $this->session->userdata('client');?> @ Adwit Ads - Client</title>

<meta name="keywords" content="adwitads, adwit, ads, print ads, web ads at india, ads at bangalore" />

	<meta name="description" content="adwit ads for print and web ad development" />

     <base href="<?php echo base_url();?>" />

     

	<link rel="stylesheet" href="stylesheet/style_fluid.css" type="text/css" />

    	<link rel="stylesheet" href="stylesheet/boilerplate.css" type="text/css" />
                <link rel="stylesheet" href="flatmenu/flatmenu.css" type="text/css" />

<!-- 

To learn more about the conditional comments around the html tags at the top of the file:

paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/



Do the following if you're using your customized build of modernizr (http://www.modernizr.com/):

* insert the link to your js here

* remove the link below to the html5shiv

* add the "no-js" class to the html tags at the top

* you can also remove the link to respond.min.js if you included the MQ Polyfill in your modernizr build 

-->

<!--[if lt IE 9]>

<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>

<![endif]-->

 <script type="text/javascript" src="js/jquery.min.js"></script>

<script src="js/respond.min.js"></script>
        <script type="text/javascript" src="flatmenu/flatmenu-responsive.js"></script>
        <script type="text/javascript" src="flatmenu/flatmenu-ie6.js"></script>

    <script type="text/javascript">

		$(document).ready(function(e) {

            $('#forget').click(function(e) {

				$('#Login-div').hide();

                $('#Forgot-pass').show();

            });

			$('#back').click(function(e) {

				$('#Forgot-pass').hide();

                $('#Login-div').show();

            });			

		 });

    </script>



    
    

</head>

<body>

<div class="gridContainer clearfix">



<!-- header starts -->

  <div id="Logo">

    <div id="Logo-Img">

    <img src="images/logo.png"/>

    </div>
    <div id="top-nav">
    <?php
	$client_name=$this->db->get_where('adreps',array('id' => $this->session->userdata('cId')))->result_array()
	?>
    <div class="nav green-black">
    <ul class="dropdown clear">
      <li class="divider"></li>
      <li><a href="<?php echo base_url().index_page()."client/home/";?>">Home</a></li>
      <li class="divider"></li>
      <li class="sub"><a href="#">Place Order</a>
      <ul>
	  <?php
		if($client_name[0]['publication_id']!='24'){
	  ?>
           <li class="sub"><a href="<?php echo base_url().index_page()."client/home/order_form";?>">Print Ad</a>
          <ul>
          	<li><a href="<?php echo base_url().index_page()."client/home/order_form/print/new-ads";?>">New Ad</a></li>
            <li><a href="<?php echo base_url().index_page()."client/home/order_form/print/pickup-ads";?>">Pickup/Template Ad</a></li>
            <li><a href="<?php echo base_url().index_page()."client/home/order_form/print/resize-ads";?>">Resize Ad</a></li>
          </ul>
          </li>
          <li class="sub"><a href="<?php echo base_url().index_page()."client/home/order_form";?>">Online Ad</a>
          <ul>
          	<li><a href="<?php echo base_url().index_page()."client/home/order_form/web/new-ads";?>">New Ad</a></li>
            <li><a href="<?php echo base_url().index_page()."client/home/order_form/web/pickup-ads";?>">Pickup/Template Ad</a></li>
            <li><a href="<?php echo base_url().index_page()."client/home/order_form/web/resize-ads";?>">Resize Ad</a></li>
          </ul>
          </li>
           
		<?php  } ?>  
        <li class="sub"><a href="<?php echo base_url().index_page()."client/home/order_form";?>">Print & Online Ad</a>
          <ul>
          	<li><a href="<?php echo base_url().index_page()."client/home/order_form/print_web/new-ads";?>">New Ad</a></li>
            <li><a href="<?php echo base_url().index_page()."client/home/order_form/print_web/pickup-ads";?>">Pickup/Template Ad</a></li>
            <li><a href="<?php echo base_url().index_page()."client/home/order_form/print_web/resize-ads";?>">Resize Ad</a></li>
          </ul>
          </li>
           <li><a href="<?php echo base_url().index_page()."client/home/html_order_type/email-blast";?>">Email Blast</a>          </li>
        </ul>
      </li>
      <li class="divider"></li>
	   <li class="sub"><a href="#">History</a>
        <ul>
          <li><a href="<?php echo base_url().index_page()."client/home/myorders_v2";?>">My Orders</a></li>
          <?php if($client_name[0]['team_orders']=='1'){ ?>
          <li><a href="<?php echo base_url().index_page()."client/home/myteam_orders";?>">Team Orders</a></li>
          <?php } ?>

        </ul>
      </li>
      
     <!-- <li class="divider"></li>
      <li><a href="<?php echo base_url().index_page()."client/home/ad_status";?>">Status</a></li> -->
      <li class="divider"></li>
      <li class="sub"><a href="#">Analytics</a>
        <ul>
          <li class="sub"><a href="#">Graphs</a>
          <ul> 
       <!--  <li><a href="<?php echo base_url().index_page()."client/home/adtype_chart";?>">B&W vs Color</a></li> -->
          <li><a href="<?php echo base_url().index_page()."client/home/ordertype_chart";?>">Print vs Web</a></li>
         <!--   <li><a href="<?php echo base_url().index_page()."client/home/column_chart";?>">No of Ads</a></li> -->
          </ul>
          </li>
          <li><a href="<?php echo base_url().index_page()."client/home/reportview";?>">Reports</a></li>
        </ul>
      </li>
	  <?php if($this->session->userdata('cId')=='33'){ ?>
	  <li class="divider"></li>
      <li><a href="<?php echo base_url().index_page()."client/home/check_mail";?>">Test Mailer</a></li>
	  <?php } ?> 
      <li class="divider"></li>
      <li class="sub"><a href="#"><?php echo $client_name[0]['username'];?></a>
      <ul>
      <li><a href="<?php echo base_url().index_page()."client/home/change";?>">View Profile</a></li>
	  <li><a href="<?php echo base_url().index_page()."client/home/help";?>">Help</a></li>
      <li><a href="<?php echo base_url().index_page()."client/login/shutdown";?>">Sign out</a></li>
      </ul>
      </li>
      </ul>
  </div>
    </div>

  </div>

  <div id="header-div">&nbsp;</div>

<!-- header Ends -->