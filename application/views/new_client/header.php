<!DOCTYPE html>

<html class="no-js" lang="">
    <head>
        
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>AdwitAds</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <style>
            .active > a{
            	color: #d71a22 !important;
            	border-color: #333;
            	background: #e1e1e100 !important;
            }
        </style>
       
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/new_client/css/bootstrap.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/new_client/css/datepicker.css"/>
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/new_client/css/awemenu.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/new_client/css/font-awesome.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/new_client/css/main.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/new_client/css/dropzone.css"/>
		<!--<link rel="stylesheet" href="<?php echo base_url(); ?>assets/new_client/css/datatables.min.css"/> -->
		<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/new_client/favicon.ico"/>
		
		<script src="<?php echo base_url(); ?>assets/new_client/js/modernizr-2.8.3.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/new_client/js/jquery-1.11.3.min.js"></script>		
		  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.3/angular.min.js"></script>

		<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/semantic-ui@2.2.13/dist/semantic.min.css'>	
				
        <!--  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/new_client/css/awe-icon.css">-->
					
	   <script>
			 $(document).ready(function(){
			     $("#optional").hide();
			    $("#showoptional").click(function(){
					$("#optional").toggle();      
				 });
				 
				$('#example1').DataTable( {
					"order": [[ 0, "desc" ]]
				} );
			
				$('#example1').DataTable();
			 });
					  
		   jQuery(function($) {
				$('#dateControlledByRange').on('input', function() {
					$('#rangeControlledByDate').prop('valueAsNumber', $.prop(this, 'valueAsNumber'));
				});
				$('#rangeControlledByDate').on('input', function() {
					$('#dateControlledByRange').prop('valueAsNumber', $.prop(this, 'valueAsNumber'));
				});
			});			
		</script>
</head>
    
<body>
<!-- // LOADING -->
        <div class="awe-page-loading">
            <div class="awe-loading-wrapper">
                <div class="awe-loading-icon">
                    <span class="icon icon-logo"></span>
                </div>
                
                <div class="progress">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
<!-- // END LOADING -->

<div id="wrapper" class="main-wrapper ">
    <header id="header" class="awe-menubar-header">
        <nav class="awemenu-nav navbar-fixed-top" data-responsive-width="1200">
            <div class="container">
                <div class="awemenu-container">
<?php $record_num = $this->uri->segment(3); ?>
              
                    <div class="awe-logo">
                        <a href="<?php echo base_url().index_page()."new_client/home"?>" title=""><img src="<?php echo base_url(); ?>assets/new_client/img/logo.png" alt=""></a>
                    </div><!-- /.awe-logo -->
					<?php
					$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('ncId')))->result_array();
					?>

                    <ul class="awemenu awemenu-right">
                         <li <?php if($record_num == '')echo 'class="awemenu-item active"'; else echo 'class="awemenu-item"'; ?> >
                            <a href="<?php echo base_url().index_page()."new_client/home"?>" title="">Home</a>
                        </li>
                        
					<!-- one page order form TAB -->		
					
					<?php if($client[0]['publication_id']=='538'){  ?>
							<li <?php if($record_num == 'glacier_order_print')echo 'class="awemenu-item active"'; else echo 'class="awemenu-item"'; ?> >
								<a href="<?php echo base_url().index_page()."new_client/home/glacier_order_print"?>">Place Order</a>
							</li>
					<?php }else{ if($client[0]['page']=='1'){ ?>
							<li <?php if($record_num == 'page_ad')echo 'class="awemenu-item active"'; else echo 'class="awemenu-item"'; ?> >
								<a href="<?php echo base_url().index_page()."new_client/home/page_ad"?>">Place Order</a>
							</li>
					<?php }else{
						
								if($client[0]['print_ad']=='1'){ ?>
									<li <?php if($record_num == 'new_print_ad')echo 'class="awemenu-item active"'; else echo 'class="awemenu-item"'; ?> >
										<a href="<?php echo base_url().index_page()."new_client/home/new_print_ad"?>">Place Order</a>
									</li>
								<?php }elseif($client[0]['online_ad']=='1'){ ?>
									<li <?php if($record_num == 'new_online_ad')echo 'class="awemenu-item active"'; else echo 'class="awemenu-item"'; ?> >
										<a href="<?php echo base_url().index_page()."new_client/home/new_online_ad"?>">Place Order</a>
									</li>
								<?php }elseif($client[0]['pagedesign_ad']=='1'){ ?>
								    <li <?php if($record_num == 'page_proceed')echo 'class="awemenu-item active"'; else echo 'class="awemenu-item"'; ?> >
										<a href="<?php echo base_url().index_page()."new_client/home/page_proceed"?>">Place Order</a>
									</li>
								<?php } ?>
								
					<?php } } ?>
					
				    <?php if($client[0]['pagedesign_ad']=='1' && $client[0]['print_ad']=='0' && $client[0]['online_ad']=='0'){ ?>
						<li <?php if($record_num == 'page_new_dashboard')echo 'class="awemenu-item active"'; else echo 'class="awemenu-item"'; ?> >
                            <a href="<?php echo base_url().index_page()."new_client/home/page_new_dashboard"?>" title="">Dashboard</a>   
                        </li>
					<?php }else{ ?>
					    <li <?php if($record_num == 'dashboard')echo 'class="awemenu-item active"'; else echo 'class="awemenu-item"'; ?> >
                            <a href="<?php echo base_url().index_page()."new_client/home/dashboard/0"?>" title="">Dashboard</a>   
                        </li>
					<?php } ?>
					
						<?php if($client[0]['template']=='1'){ ?>
						<li <?php if($record_num == 'templates')echo 'class="awemenu-item active"'; else echo 'class="awemenu-item"'; ?> >
                            <a href="<?php echo base_url().index_page()."new_client/home/templates"?>" title="">Templates</a>   
                        </li>
					<?php } ?>

                        <li <?php if($record_num == 'help')echo 'class="awemenu-item active"'; else echo 'class="awemenu-item"'; ?> >
                            <a href="<?php echo base_url().index_page()."new_client/home/help"?>">Help</a>
                        </li>
                    <?php if($client[0]['billing']=='1'){ ?>
						<li <?php if($record_num == 'billing')echo 'class="awemenu-item active"'; else echo 'class="awemenu-item"'; ?> >
                            <a href="<?php echo base_url().index_page()."new_client/home/billing"?>" title="">Billing </a>   
                        </li>
					<?php } ?>
						<li class="awemenu-item">
                            <a class=" border-right" href="#"><small><img src="<?php echo base_url().$client[0]['image']; ?>" alt="profile"></small><?php echo $client[0]['first_name'].' '.$client[0]['last_name'];?></a>
                            <ul class="awemenu-submenu awemenu-megamenu" data-width="170px" data-animation="fadeup">
                                <li class="awemenu-megamenu-item padding-0">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <ul class="list-unstyled">
                                                    <li class="awemenu-item border-bottom padding-0"><a href="<?php echo base_url().index_page()."new_client/home/profile"?>">View Profile</a></li>
 <li class="awemenu-item padding-0"><a href="<?php echo base_url().index_page()."new_client/login/shutdown"?>">Sign Off</a></li>                                                  
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
    </header>

       
  