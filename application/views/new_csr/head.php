<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<title>CSR | Adwitads</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1" name="viewport">
<meta content="" name="description">
<meta content="" name="author">
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<base href="<?php echo base_url();?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/new_csr/css/fonts.googleapis.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/new_csr/plugins/font-awesome/css/font-awesome.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/new_csr/plugins/simple-line-icons/simple-line-icons.min.css"/>
<link rel="stylesheet" type="text/css" href="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_csr/plugins/bootstrap/css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_csr/plugins/uniform/css/uniform.default.css"/>
<link rel="stylesheet" type="text/css" href="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_csr/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_csr/plugins/icheck/skins/all.css"/>
<link rel="stylesheet" type="text/css" href="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_csr/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>
<link rel="stylesheet" type="text/css" href="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_csr/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_csr/plugins/bootstrap-datepicker/css/datepicker.css"/>
<link rel="stylesheet" type="text/css" href="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_csr/css/dropzone.css"/>
<link rel="stylesheet" type="text/css" href="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_csr/css/custom.css"/>
<script src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_csr/scripts/jquery-latest.min.js" type="text/javascript" ></script>
<link rel="shortcut icon" href="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_csr/favicon.ico"/>
<link rel="stylesheet" type="text/css" href="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_csr/plugins/bootstrap-datepicker/css/datepicker3.css"/>


<script>
function AvoidSpace(event) {
    var k = event ? event.which : window.event.keyCode;
    if (k == 32) return false;
}
</script> 
</head>
<!-- END HEAD -->

<body>
<!-- BEGIN HEADER -->
<div class="page-header">
	<!-- BEGIN HEADER TOP -->
	<div class="page-header-top"> 
		<div class="container">
			<!-- BEGIN LOGO -->
			<div class="page-logo">
				<a href="<?php echo base_url().index_page()."new_csr/home";?>"><img src="<?php echo base_url() ?>assets/new_csr/img/logo.png" alt="logo" class="logo-default"></a>
			</div>
			<!-- END LOGO -->
			<!-- BEGIN RESPONSIVE MENU TOGGLER -->
			<a href="javascript:;" class="menu-toggler"></a>
			<!-- END RESPONSIVE MENU TOGGLER -->
			<!-- BEGIN TOP NAVIGATION MENU -->
			<div class="top-menu">
				<ul class="nav navbar-nav pull-right">
					<!-- BEGIN NOTIFICATION DROPDOWN -->
					<li class="dropdown dropdown-extended dropdown-dark dropdown-notification" id="header_notification_bar">
						<a href="<?php echo base_url().index_page()."new_csr/home/notifications";?>" class="dropdown-toggle">
						<i class="icon-bell"></i>
						<span class="badge badge-default">0</span>
						</a>
						<ul class="dropdown-menu">
							<li class="external">
								<h3>You have <strong>4 pending</strong> tasks</h3>
								<a href="javascript:;">view all</a>
							</li>
							<li>
								<ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
									<li>
										<a href="javascript:;">
										<span class="time">just now</span>
										<span class="details">
										<span class="label label-sm label-icon label-success">
										<i class="fa fa-plus"></i>
										</span>
										New user registered. </span>
										</a>
									</li>
									<li>
										<a href="javascript:;">
										<span class="time">3 mins</span>
										<span class="details">
										<span class="label label-sm label-icon label-danger">
										<i class="fa fa-bolt"></i>
										</span>
										Server #12 overloaded. </span>
										</a>
									</li>
									<li>
										<a href="javascript:;">
										<span class="time">10 mins</span>
										<span class="details">
										<span class="label label-sm label-icon label-warning">
										<i class="fa fa-bell-o"></i>
										</span>
										Server #2 not responding. </span>
										</a>
									</li>
									<li>
										<a href="javascript:;">
										<span class="time">14 hrs</span>
										<span class="details">
										<span class="label label-sm label-icon label-info">
										<i class="fa fa-bullhorn"></i>
										</span>
										Application error. </span>
										</a>
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<!-- END NOTIFICATION DROPDOWN -->
					<!-- BEGIN USER LOGIN DROPDOWN -->
				<?php
					$csr_name = $this->db->get_where('csr',array('id' => $this->session->userdata('sId')))->result_array()
				?>
					<li class="dropdown dropdown-user dropdown-dark">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
						<img alt="" class="img-circle" src="<?php echo base_url() ?><?php echo $csr_name[0]['image_path']; ?>">
	
						<span class="username username-hide-mobile capitalize"><?php echo $csr_name[0]['name'];?> </span>
						</a>
						<ul class="dropdown-menu dropdown-menu-default">
							<!--<li>
								<a href="<?php echo base_url().index_page()."new_csr/home/my_profile";?>">
								<i class="icon-user"></i> My Profile </a>
							</li>-->
							<li>
								<a href="<?php echo base_url().index_page()."new_csr/home/my_account";?>">
								<i class="icon-user"></i> My Profile </a>
							</li>
							<li class="divider">
							</li>
							<li>
								<a onclick="noBack();" href="<?php echo base_url().index_page()."new_csr/home/lock";?>">
								<i class="icon-lock"></i> Lock Screen </a>
							</li>
							<li>
								<a href="<?php echo base_url().index_page()."new_csr/login/shutdown";?>" onclick="performAction(); return false;">
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
	<!-- END HEADER TOP -->

<script>
    function performAction(){
        localStorage.removeItem('go_back_tab');
        localStorage.removeItem('display_type');
        localStorage.removeItem('new_ads');
        window.location.href = "<?php echo base_url().index_page()."new_csr/login/shutdown";?>";
    }	
    	
	$(document).ready(function(){
        $("#advancesearch").hide(); //changes done by kokila on 31st oct 2023
       // $("#search").hide();
		 
	 $("#showadvancesearch").click(function(){
	 $("#advancesearch").show();  
     $("#search").hide();  		
		});
	 $("#idsearch").click(function(){
	 $("#advancesearch").hide();  
     $("#search").show();  		
		});	
		
	});
	
	function unset_ordernot_found(){
	    $.ajax({
        type: 'POST',
		url: "<?php echo base_url().index_page().'new_csr/home/unset_ordernot_found';?>",
        success: function(response) {
            
        },
        error: function() {
            alert('Something went wrong!!');
        }
    });
	}
</script>

    <!-- order not found modal starts here-->
	<?php if ($this->session->userdata('order_not_found')) {
        echo '<script>
            $(document).ready(function() {
                $("#ordernotfoundModal").modal("show");
            });
        </script>';
     
    } ?>
  
    <div class="modal fade" id="ordernotfoundModal" tabindex="-1"  data-backdrop="static" role="dialog" aria-labelledby="confirmationModalTitle" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="width:85%">
          <div class="modal-header  portlet blue-hoki box" style="border-bottom: 0 !important;">
            <h5 class="modal-title portlet-title margin-top-10" id="confirmationModalTitle" style="margin-top: 0px !important; padding:10px !important;"><center><b></b></center></h5>
          </div>
          <div class="modal-body">
            <b style="color:#900;">Order Not Found !!</b>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="unset_ordernot_found()">Close</button>
          </div>
        </div>
      </div>
    </div>
   
    <!-- order not found modal ends here-->
	<!-- BEGIN HEADER MENU -->
	<div class="page-header-menu"> 
		<div class="container" ng-app="textarea" ng-controller="textCtrl">
		<?php //if($csr_name[0]['csr_role'] != '1') { ?>
			<!-- BEGIN HEADER SEARCH BOX -->
			<form class="search-form" id="search" name="form" method="post" action="<?php echo base_url().index_page().'new_csr/home/cshift_order_search'; ?>">
				<div class="input-group">
				
					<span class="input-group-btn">
						<button type="button" class="btn bg-search dropdown-toggle" data-toggle="dropdown" tabindex="-1" aria-expanded="false">
							ID &nbsp;<i class="fa fa-angle-down"></i>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li><a id="showadvancesearch" >All</a></li>
							<li><a>ID </a></li>
						</ul>
					</span>
				    <input type="text" style="display:none;" name="current_url" value="<?php echo $_SERVER['REQUEST_URI']?>">
					<input type="text" class="form-control"  maxlength="7" onkeypress="return AvoidSpace(event)" placeholder="Enter 7 digits" name="search_id" required/>
					<span class="input-group-btn">
						<a href="javascript:;" class="btn"><button type="submit" name="search" style="color: #5b9bd1; background: transparent; border: 0;"><i class="icon-magnifier font-white"></i></button></a>
					</span>
				</div>
			</form>
			<form class="search-form" id="advancesearch" name="form" method="get" action="<?php echo base_url().index_page().'new_csr/home/cshift_advance_search'; ?>">
				<div class="input-group">
					<span class="input-group-btn">
						<button type="button" class="btn bg-search dropdown-toggle" data-toggle="dropdown" tabindex="-1" aria-expanded="false">
							All &nbsp;<i class="fa fa-angle-down"> </i>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li><a>All</a></li>
							<li><a id="idsearch">ID </a></li>
						</ul>
					</span>
					<input type="text" class="form-control"  placeholder="Enter AdwitAds ID, Job ID or Advertiser Name" name="advance_search_id" required/>
					<span class="input-group-btn">
						<a href="javascript:;" class="btn"><button type="submit" name="advance_search" style="color: #5b9bd1; background:transparent; border: 0;"><i class="icon-magnifier font-white"></i></button></a>
					</span>
				</div>
			</form>
			<!-- END HEADER SEARCH BOX -->
		<?php //} ?>	
			<!-- BEGIN MEGA MENU -->
			<!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
			<!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
			<div class="hor-menu ">
				<ul class="nav navbar-nav">
					<li>
						<a href="<?php echo base_url().index_page()."new_csr/home";?>">Dashboard</a>
					</li>
				<!--	
					<li>
						<a href="<?php echo base_url().index_page()."new_csr/home/live_new_ads";?>">Live New Ad</a>
					</li>
					
					<li>
						<a href="<?php echo base_url().index_page()."new_csr/home/cshift";?>">New Ad</a>
					</li>
				-->	
				    <li>
						<a href="<?php echo base_url().index_page()."new_csr/home/live_new_ads";?>">New Ad</a>
					</li>
					
					<li>
						<a href="<?php echo base_url().index_page()."new_csr/home/frontlinetrack_all";?>">Revision</a>
					</li>
					<?php if($csr_name[0]['web_ad']=='1'){ ?>
					<li>
						<a href="<?php echo base_url().index_page()."new_csr/home/web_cshift";?>">Web Ad</a>
					</li>
					<?php } if($csr_name[0]['requests']==1){  ?>
					<li>
						<a href="<?php echo base_url().index_page()."new_csr/home/request";?>">Requests</a>
					</li>
					<?php } ?>
					
					<li>
						<a href="<?php echo base_url().index_page()."new_csr/home/communication";?>">Communication</a>
					</li>
				    <!-- page design 
					<li>
						<a href="<?php echo base_url().index_page()."new_csr/home/page_index";?>">Page Design</a>
					</li>-->
				<?php if($this->session->userdata('sId') == '68' || $this->session->userdata('sId') == '19'){ ?>
				    <!-- adwitmap orders -->
					<li>
						<a href="<?php echo base_url().index_page()."new_csr/home/map_orders";?>">Map Orders</a>
					</li>
					<!-- tscs preorders 
					<li class="awemenu-item padding-0 dropdown-submenu desk-display">
						<a href="javascript:;">TSCS PreOrders</a>
						<ul class="dropdown-menu subsub-menu">
							<li class="dropdown">
								<a href="<?php echo base_url().index_page().'new_csr/home/tscs_preorder_list'; ?>">New Ads </a>
							</li>
							<li class="dropdown">
								<a href="<?php echo base_url().index_page().'new_csr/home/tscs_correction_preorder_list'; ?>">Revision Ads </a>
							</li>
						</ul>
					</li>
					-->
				<!--	<li>
						<a href="<?php echo base_url().index_page()."new_csr/home/tscs_preorder_list";?>">TSCS PreOrders</a>
					</li>-->
				<?php } ?>
				<!-- Gmail Draft 
				<li>
						<a href="<?php echo base_url().index_page()."new_csr/home/GmailDraft";?>">Gmail Draft</a>
					</li>
					-->
			    <!--<li class="awemenu-item active"> <a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;"> Manage <i class="fa fa-angle-down icons"></i></a> 
							<ul class="awemenu-submenu awemenu-megamenu"  >
									<li class="awemenu-megamenu-item padding-0">
										<div class="container-fluid">
											<div class="row">
												<div class="">
													<ul class="list-unstyled">
														<li class="awemenu-item  padding-0"><a href="<?php echo base_url().index_page(). 'new_admin/home/sales_manage'; ?>" style="">Sales</a></li>
														<li class="awemenu-item padding-0"><a href="<?php echo base_url().index_page(). 'new_admin/home/production_manage'; ?>" style="">Production</a></li>                                                  
													</ul>
												</div>
											</div>
										</div>
									</li>
								</ul>
							</li>-->
				</ul>
			</div>
			<!-- END MEGA MENU -->
			
		</div>
	</div>
	<!-- END HEADER MENU -->
</div>
<!-- END HEADER -->

