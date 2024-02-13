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
<title><?php echo $this->session->userdata('admin');?> @ Adwit Ads - Admin</title>
<meta name="keywords" content="adwitads, adwit, ads, print ads, web ads at india, ads at bangalore" />
	<meta name="description" content="adwit ads for print and web ad development" />
     <base href="<?php echo base_url();?>" />
     
	<link rel="stylesheet" href="stylesheet/style_fluid.css" type="text/css" />
    	<link rel="stylesheet" href="stylesheet/boilerplate.css" type="text/css" />
        <link href="stylesheet/flexnav.css" media="screen, projection" rel="stylesheet" type="text/css">
                <link rel="stylesheet" href="flatmenu/flatmenu.css" type="text/css" />
 <link rel="stylesheet" type="text/css" href="pagination/datatables.min.css"/> 
  <script type="text/javascript" src="pagination/datatables.min.js"></script>
  <script type="text/javascript" charset="utf-8">
   $(document).ready(function() {
    $('#paginate').DataTable();
   } );
  </script>				
<!-- 
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
<script src="js/respond.min.js"></script>
<script src="js/amcharts.js"></script>
</head>
<body>
<div class="gridContainer clearfix">

<!-- header starts -->
  <div id="Logo">
    <div id="Logo-Img">	
    <img src="images/logo.png"/>
    </div>
    <div id="top-nav">
    <div class="nav green-black">
    <ul class="dropdown clear">
      <li class="divider"></li>
      <li><a href="<?php echo base_url().index_page()."admin/home/";?>">Home</a></li>
	   <li class="divider"></li>
	   
      <li class="sub"><a href="#">India_Client Links</a>
		<ul>
			<li><a href="<?php echo base_url().index_page()."admin/home/controllers/";?>">Controllers</a></li>
			<li><a href="<?php echo base_url().index_page()."admin/grid/india_client_links/";?>">Views</a></li>
		</ul>
	  </li>
	   <li class="divider"></li>
		<li class="sub"><a href="#">Ordering System</a>
        <ul>
			<li><a href="<?php echo base_url().index_page()."admin/grid/customers";?>">Customers</a></li>
			 <li><a href="<?php echo base_url().index_page()."admin/grid/publications";?>">Publications</a></li>
			 <li><a href="<?php echo base_url().index_page()."admin/grid/adreps";?>">Adreps</a></li>
       <!--  <li><a href="<?php echo base_url().index_page()."admin/home/soft_adrep";?>">Soft Adreps</a></li>
             <li><a href="<?php echo base_url().index_page()."admin/home/soft_publication";?>">Soft Publication</a></li>-->
             <li><a href="<?php echo base_url().index_page()."admin/home/bill_report";?>">Billing</a></li>
			 <li><a href="<?php echo base_url().index_page()."admin/home/bill_report_helpdesk";?>">Helpdesk Billing </a></li>
             <li><a href="<?php echo base_url().index_page()."admin/home/new_adreps";?>">New Adreps</a></li>
			 <li><a href="<?php echo base_url().index_page()."admin/home/rev_new";?>">Rev/New</a></li>
		</ul>
		</li>
		
	   <li class="divider"></li>
		<li class="sub"><a href="#">Work Flow</a>
        <ul>
			<li><a href="<?php echo base_url().index_page()."admin/home/job_status";?>">Job Status</a></li>
			<li><a href="<?php echo base_url().index_page()."admin/grid/channels";?>">Channels</a></li>
			 <li><a href="<?php echo base_url().index_page()."admin/grid/designteams";?>">Design Teams</a></li>
			 <li><a href="<?php echo base_url().index_page()."admin/grid/help_desk";?>">Help Desk</a></li>
			  <li class="sub"><a href="#">Users</a>
				<ul>
					<li><a href="<?php echo base_url().index_page()."admin/grid/art_director";?>">Art Director</a></li>
					<li><a href="<?php echo base_url().index_page()."admin/grid/bg_head";?>">BG Head</a></li>
					<li><a href="<?php echo base_url().index_page()."admin/grid/csr";?>">CSR</a></li>
					<li><a href="<?php echo base_url().index_page()."admin/grid/team_lead";?>">Team Lead</a></li>
					<li><a href="<?php echo base_url().index_page()."admin/grid/designteams";?>">Design Teams</a></li>
					<li><a href="<?php echo base_url().index_page()."admin/grid/designers";?>">Designers</a></li>
					<li><a href="<?php echo base_url().index_page()."admin/grid/management";?>">Management</a></li>
					<li><a href="<?php echo base_url().index_page()."admin/grid/notification";?>">Notification</a></li>
				</ul>
			  </li>
			  <li><a href="<?php echo base_url().index_page()."admin/home/designer_team_assign";?>">Designer Assign</a></li>
			  <li><a href="<?php echo base_url().index_page()."admin/home/teamlead_team_assign";?>">Team Lead Assign</a></li>
		</ul>
	   </li>	
	<!--  
      <li class="divider"></li>
      <li class="sub"><a href="#">Corporate</a>
        <ul>
          <li class="sub"><a href="#">Analytics</a>
          <ul>
          	<li><a href="<?php echo base_url().index_page()."admin/home/corporate";?>">Ad Reps</a></li>
                 <li><a href="<?php echo base_url().index_page()."admin/home/puborders";?>">No of Jobs</a></li>
   
          </ul>
          </li>
          <li class="sub"><a href="#">Reports</a>
          <ul>
          	<li><a href="#">Management</a></li>
            <li><a href="<?php echo base_url().index_page()."admin/home/bill_report";?>">Billing</a></li>
            <li><a href="#">Art Director</a></li>
  		    <li><a href="#">BG's</a></li>
            <li><a href="#">TL</a></li>
    	    <li class="sub"><a href="#">CSR</a>
				<ul>
				<li><a href="<?php echo base_url().index_page()."admin/home/csr_performance";?>">Performance</a></li>
                </ul>
			</li>
            <li class="sub"><a href="#">Designer</a>
            	<ul>
				<li><a href="<?php echo base_url().index_page()."admin/home/performance_pay";?>">Performance Pay</a></li>
                <li><a href="<?php echo base_url().index_page()."admin/home/Designer_production_table";?>">Production</a></li>
                <li><a href="<?php echo base_url().index_page()."admin/home/Designer_nosnj";?>">No's & NJ</a></li>
                <li><a href="<?php echo base_url().index_page()."admin/home/Designer_error";?>">Error</a></li>
                </ul>
            </li>
            <li><a href="<?php echo base_url().index_page()."admin/home/frontline/all";?>">Frontline Deliveries Report</a></li>
          </ul>
          </li>
          <li class="sub"><a href="#">Ads</a>
         	<ul>
                 <li><a href="<?php echo base_url().index_page()."admin/grid/webads";?>">Web Ads</a></li>
        		 <li><a href="<?php echo base_url().index_page()."admin/grid/printads";?>">Print Ads</a></li>
				 <li><a href="<?php echo base_url().index_page()."admin/grid/cat_result";?>">Category</a></li>
				 <li><a href="<?php echo base_url().index_page()."admin/grid/designer_dp";?>">Designer DP</a></li>
                 <li><a href="<?php echo base_url().index_page()."admin/home/DP_report";?>">DP Report</a></li>
                 <li><a href="<?php echo base_url().index_page()."admin/home/QA_report";?>">QA Report</a></li>
				 <li><a href="<?php echo base_url().index_page()."admin/home/job_status";?>">Job_Status</a></li>
				 
            </ul>
         </li>
          <li><a href="<?php echo base_url().index_page()."admin/grid/businessgroups";?>">Business Groups</a></li>
          <li><a href="<?php echo base_url().index_page()."admin/grid/publications";?>">Publications</a></li>
         <li><a href="<?php echo base_url().index_page()."admin/grid/adreps";?>">Ad Reps</a></li>
         <li><a href="<?php echo base_url().index_page()."admin/grid/cat_newspaper";?>">Newspaper Types</a></li>
		 <li><a href="<?php echo base_url().index_page()."admin/grid/dp_error";?>">Errors</a></li>
		 <li><a href="<?php echo base_url().index_page()."admin/grid/help_desk";?>">Help Desk</a></li>
		 <li><a href="<?php echo base_url().index_page()."admin/grid/error_type";?>">Error Type</a></li>
		 <li><a href="<?php echo base_url().index_page()."admin/grid/frontline_timer";?>">Frontline Timer</a></li>
         <li><a href="<?php echo base_url().index_page()."admin/grid/notification";?>">Notification</a></li>
		 <li><a href="<?php echo base_url().index_page()."admin/grid/cat_adreps";?>">Category Adreps</a></li>
        </ul>
      </li>
      <li class="divider"></li>
      <li class="sub"><a href="<?php echo base_url().index_page()."admin/home/adwitusers";?>">Adwit Users</a>
         	<ul>
				<li><a href="<?php echo base_url().index_page()."admin/grid/art_director";?>">Art Director</a></li>
				<li><a href="<?php echo base_url().index_page()."admin/grid/bg_head";?>">BG Head</a></li>
                <li><a href="<?php echo base_url().index_page()."admin/grid/csr";?>">CSR</a></li>
				<li><a href="<?php echo base_url().index_page()."admin/grid/team_lead";?>">Team Lead</a></li>
       			<li><a href="<?php echo base_url().index_page()."admin/grid/designteams";?>">Design Teams</a></li>
         		<li><a href="<?php echo base_url().index_page()."admin/grid/designers";?>">Designers</a></li>
				<li><a href="<?php echo base_url().index_page()."admin/grid/management";?>">Management</a></li>
				<li><a href="<?php echo base_url().index_page()."admin/grid/notification";?>">Notification</a></li>
            </ul>
         </li>
         <li class="divider"></li>
         <li class="sub"><a href="<?php echo base_url().index_page()."admin/grid/adwitjobs";?>">Adwit Jobs</a>
	<ul>
	<?php
	$publications = $this->db->get('publications')->result_array();	
	foreach($publications as $row)	
	{
	?>	
		<li><a href="<?php echo base_url().index_page().'admin/grid/adwitjobs/'.$row['id']; ?>" ><?php echo $row['name'] ;?></a></li>
	<?php			
	 }	
	?>			
	</ul>	
	</li>
	-->
    <li class="divider"></li>
      <li class="sub"><a href="#">My Account</a>
      <ul><li><a href="<?php echo base_url().index_page()."admin/home/change";?>">View Profile</a></li>
      <li><a href="<?php echo base_url().index_page()."admin/login/shutdown";?>">Logout</a></li>
      </ul>
      </li>
      </ul>
  </div>
    </div>
  </div>
  <div id="header-div">&nbsp;</div>
<!-- header Ends -->
