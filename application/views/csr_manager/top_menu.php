<div class="page-header">
	<!-- BEGIN HEADER TOP -->
	<div class="page-header-top">
		<div class="container">
			<!-- BEGIN LOGO -->
			<div class="page-logo">
				<a href="<?php echo base_url().index_page()."csr_manager/home";?>"><img src="<?php echo base_url() ?>/images/logo-default.png" alt="logo" class="logo-default"></a>
			</div>
			<!-- END LOGO -->
			<!-- BEGIN RESPONSIVE MENU TOGGLER -->
			<a href="javascript:;" class="menu-toggler"></a>
			<!-- END RESPONSIVE MENU TOGGLER -->
			<!-- BEGIN TOP NAVIGATION MENU -->
	<?php
	$csr_manager_name=$this->db->get_where('csr_manager',array('id' => $this->session->userdata('cmId')))->result_array()
	?>
			<div class="top-menu">
				<ul class="nav navbar-nav pull-right">
					<!-- BEGIN USER LOGIN DROPDOWN -->
					<li class="dropdown dropdown-user dropdown-dark">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
						<img alt="" class="img-circle" src="<?php echo base_url() ?>/images/<?php echo $csr_manager_name[0]['image_path']; ?>">
						<span class="username username-hide-mobile"><?php echo $csr_manager_name[0]['name'];?></span>
						</a>
						<ul class="dropdown-menu dropdown-menu-default">
							<li>
								<a href="<?php echo base_url().index_page()."csr_manager/home/my_profile";?>">
								<i class="icon-user"></i> My Profile </a>
							</li>
							<li class="divider">
							</li>
							<li>
								<a onclick="noBack();" href="<?php echo base_url().index_page()."csr_manager/home/lock";?>">
								<i class="icon-lock"></i> Lock Screen </a>
							</li>
							<li>
								<a href="<?php echo base_url().index_page()."csr_manager/home/shutdown";?>">
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

			<!-- BEGIN MEGA MENU -->
			<!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
			<!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
			<div class="hor-menu ">
				<ul class="nav navbar-nav" >
					<li class="">
						<a href="<?php echo base_url().index_page()."csr_manager/home";?>">DASHBOARD</a>
					</li>
					<li class="menu-dropdown classic-menu-dropdown ">
						<a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;">
						ADWIT USERS <i class="fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu pull-left">
							<li>
							<a href="<?php echo base_url().index_page()."csr_manager/home/csrs";?>"><i class="icon-briefcase"></i>
								CSR</a></li>
								<li><a href="<?php echo base_url().index_page()."csr_manager/home/teams";?>"><i class="icon-briefcase"></i>
								TEAMS </a></li>
						</ul> 
						
					</li>
					<li class="menu-dropdown classic-menu-dropdown ">
						<a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;">
						REPORTS <i class="fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu pull-left">
								<li><a href="<?php echo base_url().index_page()."csr_manager/home/pub_performance";?>"><i class="icon-briefcase"></i>
								PUBLICATIONS </a></li>
								<li><a href="<?php echo base_url().index_page()."csr_manager/home/production";?>"><i class="icon-briefcase"></i>
								DESIGNER </a></li>
								<li><a href="<?php echo base_url().index_page()."csr_manager/home/csr_performance";?>"><i class="icon-briefcase"></i>
								CSR </a></li>
								<li><a href="<?php echo base_url().index_page()."csr_manager/home/frontline/all";?>"><i class="icon-briefcase"></i>
								FRONT LINE </a></li>
								<li><a href="<?php echo base_url().index_page()."csr_manager/home/tracking";?>"><i class="icon-briefcase"></i>
								TIME TRACKING </a></li>
						</ul> 
					</li>
				</ul>
			</div>
			<!-- END MEGA MENU -->
		</div>
	</div>
	<!-- END HEADER MENU -->
</div>