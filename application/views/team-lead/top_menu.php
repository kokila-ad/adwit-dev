<div class="page-header">
	<!-- BEGIN HEADER TOP -->
	<div class="page-header-top">
		<div class="container">
		
			<!-- BEGIN LOGO -->
			<div class="page-logo">
				<a href="<?php echo base_url().index_page()."team-lead/home";?>"><img src="<?php echo base_url() ?>/images/logo-default.png"  alt="logo" class="logo-default"></a>
			</div>
			<!-- END LOGO -->
			<!-- BEGIN RESPONSIVE MENU TOGGLER -->
			<a href="javascript:;" class="menu-toggler"></a>
			<!-- END RESPONSIVE MENU TOGGLER -->
	<?php
	$team = $this->db->get_where('team_lead',array('id' => $this->session->userdata('tId')))->result_array();
	?>
			<!-- BEGIN TOP NAVIGATION MENU -->
			<div class="top-menu">
				<ul class="nav navbar-nav pull-right">
				<!-- BEGIN NOTIFICATION DROPDOWN -->
					<li class="dropdown dropdown-extended dropdown-dark dropdown-notification" id="header_notification_bar">
						<a href="<?php echo base_url().index_page()."team-lead/home/notifications";?>" class="dropdown-toggle">
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
						<img alt="" class="img-circle" src="<?php echo base_url() ?><?php echo $team[0]['image']; ?>">
	
						<span class="username username-hide-mobile"><?php echo $team[0]['first_name'];?> <?php echo $team[0]['last_name'];?></span>
						</a>
						<ul class="dropdown-menu dropdown-menu-default">
							<li>
								<a href="<?php echo base_url().index_page()."team-lead/home/my_profile";?>">
								<i class="icon-user"></i> My Profile </a>
							</li>
							<li class="divider">
							</li>
							<li>
								<a onclick="noBack();" href="<?php echo base_url().index_page()."team-lead/home/lock";?>">
								<i class="icon-lock"></i> Lock Screen </a>
							</li>
							<li>
								<a href="<?php echo base_url().index_page()."team-lead/login/shutdown";?>">
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
			<!-- BEGIN HEADER SEARCH BOX -->
	<form class="search-form" name="form" method="post" action="<?php echo base_url().index_page().'team-lead/home/cshift_search'; ?>">
		<div class="input-group">
		 <input type="text" class="form-control" placeholder="Search"  name="id" autocomplete="off" required/>
		 <span class="input-group-btn">
		 <!--<button type="submit" class="btn blue" name="search">Search</button>-->
		 <a href="javascript:;" class="btn"><button type="submit" name="search" style=" background: transparent; border: 0;"><i class="icon-magnifier"></i></button></a>
		 </span>
		</div>
	</form>
		<!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
			<div class="hor-menu ">
				<ul class="nav navbar-nav">
					<li class="">
						<a href="<?php echo base_url().index_page()."team-lead/home";?>">DASHBOARD</a>
					</li>
					<!--<li class="">
						<a href="<?php echo base_url().index_page()."team-lead/home/cshift";?>">NEW JOB</a>
					</li>-->
					 <!--<li class="menu-dropdown classic-menu-dropdown ">
						<a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;">
						NEW JOB <i class="fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu pull-left">
								<li><a href="<?php echo base_url().index_page()."team-lead/home/assign";?>"><i class="icon-briefcase"></i>
								Assign</a></li>
								<li><a href="<?php echo base_url().index_page()."team-lead/home/design_check";?>"><i class="icon-briefcase"></i>
								Design Check </a></li>
								<li><a href="<?php echo base_url().index_page()."team-lead/home/all_pending";?>"><i class="icon-briefcase"></i>
								All Pending </a></li>
						</ul>
					</li> -->
					<li class="">
						<a href="<?php echo base_url().index_page()."team-lead/home/cshift";?>">NEW JOB</a>
					</li>
					<?php if($team[0]['web_ad']=='1') { ?>
					<li class="">
						<a href="<?php echo base_url().index_page()."team-lead/home/web_cshift";?>">WEB AD</a>
					</li>
					<?php } ?>
					 <!--<li class="menu-dropdown classic-menu-dropdown ">
						<a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;">
						WEB AD <i class="fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu pull-left">
								<li><a href="<?php echo base_url().index_page()."team-lead/home/web_assign";?>"><i class="icon-briefcase"></i>
								Assign</a></li>
								<li><a href="<?php echo base_url().index_page()."team-lead/home/web_design_check";?>"><i class="icon-briefcase"></i>
								Design Check </a></li>
								<li><a href="<?php echo base_url().index_page()."team-lead/home/web_all_pending";?>"><i class="icon-briefcase"></i>
								All Pending </a></li>
						</ul> 
					</li> -->
					
					<!--<li class="menu-dropdown classic-menu-dropdown ">
						<a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;">
						ADWIT USERS <i class="fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu pull-left">
							<li>
							<a href="<?php echo base_url().index_page()."team-lead/home/new_designer";?>"><i class="icon-briefcase"></i>
								DESIGNERS</a></li>
								<li><a href="<?php echo base_url().index_page()."team-lead/home/new_teams";?>"><i class="icon-briefcase"></i>
								TEAM LEAD </a></li>
								<li><a href="<?php echo base_url().index_page()."team-lead/home/teams";?>"><i class="icon-briefcase"></i>
								TEAMS </a></li>
						</ul> 
					</li>-->
				</ul> 
				
			</div>
			
			      
			<!-- END HEADER SEARCH BOX -->
			<!-- BEGIN MEGA MENU -->
			<!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
			<!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
			
			<!-- END MEGA MENU -->
		</div>
	</div>
	<!-- END HEADER MENU -->
</div>