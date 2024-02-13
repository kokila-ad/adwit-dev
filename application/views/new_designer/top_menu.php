<style>
	.bg-search {
    color: #ccc !important;
    background-color: #38414c;
    border-right: 1px solid #444d58;
}
</style>

<div class="page-header">
	<!-- BEGIN HEADER TOP -->
	<div class="page-header-top">
		<div class="container">
			<!-- BEGIN LOGO -->
			<div class="page-logo">
				<a href="<?php echo base_url().index_page()."new_designer/home";?>"><img src="<?php echo base_url() ?>assets/new_designer/img/logo.png" alt="logo" class="logo-default"></a>
			</div>
			<!-- END LOGO -->
			<!-- BEGIN RESPONSIVE MENU TOGGLER -->
			<a href="javascript:;" class="menu-toggler"></a>
			<!-- END RESPONSIVE MENU TOGGLER -->
			<!-- BEGIN TOP NAVIGATION MENU -->
	<?php
	$designer_name=$this->db->get_where('designers',array('id' => $this->session->userdata('dId')))->result_array()
	?>
			<div class="top-menu">
				<ul class="nav navbar-nav pull-right">
				<!-- BEGIN NOTIFICATION DROPDOWN -->
					<li class="dropdown dropdown-extended dropdown-dark dropdown-notification" id="header_notification_bar">
						<a href="<?php echo base_url().index_page()."new_designer/home/notifications";?>" class="dropdown-toggle">
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
					<li class="dropdown dropdown-user dropdown-dark">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
						<img alt="" class="img-circle" src="<?php echo base_url() ?><?php echo $designer_name[0]['image']; ?>"> 
						<span class="username username-hide-mobile"><?php echo $designer_name[0]['name'];?></span>
						</a>
						<ul class="dropdown-menu dropdown-menu-default">
							<li>
								<a href="<?php echo base_url().index_page()."new_designer/home/my_profile";?>">
								<i class="icon-user"></i> My Profile </a>
							</li>
							<li class="divider">
							</li>
							<li>
								<a onclick="noBack();" href="<?php echo base_url().index_page()."new_designer/home/lock";?>">
								<i class="icon-lock"></i> Lock Screen </a>
							</li>
							<li>
								<a href="<?php echo base_url().index_page()."new_designer/login/shutdown";?>" onclick="performAction(); return false;">
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
	<!-- BEGIN HEADER MENU -->
	<div class="page-header-menu">
		<div class="container">
<script>
	$(document).ready(function(){
    $("#advancesearch").hide();
    //$("#search").hide();
		 
	 $("#showadvancesearch").click(function(){
	 $("#advancesearch").show();  
     $("#search").hide();  		
		});
	 $("#idsearch").click(function(){
	 $("#advancesearch").hide();  
     $("#search").show();  		
		});	
		
	});
function performAction(){
    localStorage.removeItem('go_back_tab');
    localStorage.removeItem('display_type');
    localStorage.removeItem('d_selected_date');
    localStorage.removeItem('d_selected_display');
     window.location.href = "<?php echo base_url().index_page()."new_designer/login/shutdown";?>";
}	
	
</script>
					
			<!-- BEGIN HEADER SEARCH BOX -->
			<form class="search-form" id="search" name="form" method="get" action="<?php echo base_url().index_page().'new_designer/home/cshift_order_search'; ?>">
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
					<input type="text" class="form-control" placeholder="Enter AdwitAds ID" name="search_id" required/>
					<span class="input-group-btn">
						<a href="javascript:;" class="btn"><button type="submit" name="search" style="color: #5b9bd1; background: transparent; border: 0;"><i class="icon-magnifier font-white"></i></button></a>
					</span>
				</div>
			</form>
			
			<form class="search-form" id="advancesearch" name="form" method="get" action="<?php echo base_url().index_page().'new_designer/home/cshift_advance_search'; ?>">
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
					<input type="text" class="form-control" placeholder="Enter AdwitAds ID, Job ID or Advertiser Name" name="advance_search_id" required/>
					<span class="input-group-btn">
						<a href="javascript:;" class="btn"><button type="submit" name="advance_search" style="color: #5b9bd1; background:transparent; border: 0;"><i class="icon-magnifier font-white"></i></button></a>
					</span>
				</div>
			</form>
			
			
			<!-- END HEADER SEARCH BOX -->
			      
	
			<!-- END HEADER SEARCH BOX -->

			<!-- BEGIN MEGA MENU -->
			<!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
			<!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
			<div class="hor-menu ">
				<ul class="nav navbar-nav" >
					<li class="">
						<a href="<?php echo base_url().index_page()."new_designer/home";?>">Dashboard</a>
					</li>
						
    					<!--<li>
    						<a href="<?php echo base_url().index_page().'new_designer/home/live_revisions';?>">Live Revision</a>
    					</li>-->
    			<!--		
				        <li>
    						<a href="<?php echo base_url().index_page().'new_designer/home/live_new_ads';?>">Live New Ad</a>
    					</li>
    					
    				    <li>
    						<a href="<?php echo base_url().index_page()."new_designer/home/cshift";?>">New Ad</a>
    					</li> 
    			-->	
    			        <li>
    						<a href="<?php echo base_url().index_page()."new_designer/home/live_new_ads";?>">New Ad</a>
    					</li> 
    					<?php if($designer_name[0]['designer_role'] == '2') { //For TeamLead ?>
        					<li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Revision <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li>
        					        	<a href="<?php echo base_url().index_page().'new_designer/home/Qrevision';?>">HelpDesk</a>
        					        </li>
        					        <li>
        					        	<a href="<?php echo base_url().index_page().'new_designer/home/revision_verify_report';?>">Verification</a>
        					        </li>
                                </ul>
                            </li>
    					<?php }else{ ?>
    					    <li>
        						<a href="<?php echo base_url().index_page()."new_designer/home/Qrevision";?>">Revision</a>
        					</li>
    					<?php } ?>
    					
    					<?php if($designer_name[0]['designer_role'] != '4') { ?>
    					<li>
    						<a href="<?php echo base_url().index_page()."new_designer/home/web_cshift";?>">Web Ad</a>
    					</li>
    					<?php } ?>
					
					<!--li>
						<a href="<?php echo base_url().index_page()."new_designer/home/imagebank";?>">Image Bank</a>
					</li--> 
					<!-- page design 
					<li>
						<a href="<?php echo base_url().index_page()."new_designer/home/page_index";?>">Page Design</a>
					</li> -->
					
				<?php
					if($designer_name[0]['designer_role'] == '2') { //Team Lead
					    $dId = $this->session->userdata('dId');
						$today = date('Y-m-d 23:59:59');
						$ystdy = date('2017-09-01 00:00:00');
						$upload_count = $this->db->query("SELECT * FROM orders 
											left outer join cat_result on orders.id = cat_result.order_no 
												WHERE orders.order_type_id!='1' AND orders.cancel!='1' 
						AND orders.crequest!='1' AND (orders.status='3' OR orders.status='4') AND (orders.created_on BETWEEN '$ystdy' AND '$today') AND (cat_result.pro_status = '6' OR cat_result.pro_status = '7')  AND cat_result.designer = '$dId' AND (cat_result.tag_designer = '$dId' OR cat_result.tag_designer = '0');")->num_rows();
							?>
					<!--li>
						<a href="<?php echo base_url().index_page().'new_designer/home/cshift';?>">My Q - <?php echo $upload_count; ?></a>
					</li-->
					
					<li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Report <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
					        	<a href="<?php echo base_url().index_page().'new_designer/home/teamwise_ad_volume';?>">Team Wise Ad Volume</a>
					        </li>
					        <li>
					        	<a href="<?php echo base_url().index_page().'new_designer/home/hourly_designer_production_report';?>"> Designers Hourly Production Report</a>
					        </li>
					        <li>
					        	<a href="<?php echo base_url().index_page().'new_designer/home/revision_ratio_report';?>"> Revision Ratio By Designer</a>
					        </li>
					        <li>
					        	<a href="<?php echo base_url().index_page().'new_designer/home/publication_revision_ratio_report';?>"> Revision Ratio By Publication</a>
					        </li>
					        <li>
					        	<a href="<?php echo base_url().index_page().'new_designer/home/back_to_designer_report';?>"> Back To Designer</a>
					        </li>
                        </ul>
                    </li>
                     
                     <li>
						<a href="http://admin.adwitads.com/" target="_blank">New Report</a>
					</li>
                      
				<?php } ?>
				</ul>
			</div>
			<!-- END MEGA MENU -->
		</div>
	</div>
	<!-- END HEADER MENU -->
</div>