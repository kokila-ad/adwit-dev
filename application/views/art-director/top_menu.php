<div class="page-header">
	<!-- BEGIN HEADER TOP -->
	<div class="page-header-top">
		<div class="container">
			<!-- BEGIN LOGO -->
			<div class="page-logo">
				<a href="<?php echo base_url().index_page()."art-director/home";?>"><img src="<?php echo base_url() ?>/images/logo-default.png"  alt="logo" class="logo-default"></a>
			</div>
			<!-- END LOGO -->
			<!-- BEGIN RESPONSIVE MENU TOGGLER -->
			<a href="javascript:;" class="menu-toggler"></a>
			<!-- END RESPONSIVE MENU TOGGLER -->
	<?php
	$art_director=$this->db->get_where('art_director',array('username' => $this->session->userdata('art')))->result_array();
	?>
			<!-- BEGIN TOP NAVIGATION MENU -->
			<div class="top-menu">
				<ul class="nav navbar-nav pull-right">
					<!-- BEGIN USER LOGIN DROPDOWN -->

					<li class="dropdown dropdown-user dropdown-dark">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
						<img alt="" class="img-circle" src="<?php echo base_url() ?>/images/<?php echo $art_director[0]['image_path']; ?>">
	
						<span class="username username-hide-mobile"><?php echo $this->session->userdata('art');?></span>
						</a>
						<ul class="dropdown-menu dropdown-menu-default">
							<li>
								<a href="<?php echo base_url().index_page()."art-director/home/my_profile";?>">
								<i class="icon-user"></i> My Profile </a>
							</li>
							<li class="divider">
							</li>
							<li>
								<a onclick="noBack();" href="<?php echo base_url().index_page()."art-director/home/lock";?>">
								<i class="icon-lock"></i> Lock Screen </a>
							</li>
							<li>
								<a href="<?php echo base_url().index_page()."art-director/login/shutdown";?>">
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
		<!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
			<div class="hor-menu ">
				<ul class="nav navbar-nav">
					<li>
						<a href="<?php echo base_url().index_page()."art-director/home";?>">DASHBOARD</a>
					</li>
					<li class="menu-dropdown classic-menu-dropdown ">
						<a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;">
						REPORTS <i class="fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu pull-left">
								<li><a href="<?php echo base_url().index_page()."art-director/home/production";?>"><i class="icon-briefcase"></i>
								PRODUCTION </a></li>
								<li><a href="<?php echo base_url().index_page()."art-director/home/joblist";?>"><i class="icon-briefcase"></i>
								GROUP </a></li>
<li><a href="<?php echo base_url().index_page()."art-director/home/newadreport";?>"><i class="icon-briefcase"></i>
								Publication</a></li>
						</ul> 
					</li>
					<li class="menu-dropdown classic-menu-dropdown ">
						<a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;">
						ADWIT USERS <i class="fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu pull-left">
							<li>
							<a href="<?php echo base_url().index_page()."art-director/home/new_designer";?>"><i class="icon-briefcase"></i>
								DESIGNERS</a></li>
								<li><a href="<?php echo base_url().index_page()."art-director/home/new_teams";?>"><i class="icon-briefcase"></i>
								TEAM LEAD </a></li>
								<li><a href="<?php echo base_url().index_page()."art-director/home/teams";?>"><i class="icon-briefcase"></i>
								TEAMS </a></li>
						</ul> 
					</li>
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