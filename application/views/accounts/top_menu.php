<div class="page-header">
	<!-- BEGIN HEADER TOP -->
	<div class="page-header-top">
		<div class="container">
			<!-- BEGIN LOGO -->
			<div class="page-logo">
				<a href="<?php echo base_url().index_page()."accounts/home/index";?>"><img src="<?php echo base_url() ?>ui_assets/admin/layout3/img/adwitads.png"  alt="logo" class="logo-default"></a>
			</div>
			<!-- END LOGO -->
			<!-- BEGIN RESPONSIVE MENU TOGGLER -->
			<a href="javascript:;" class="menu-toggler"></a>
			<!-- END RESPONSIVE MENU TOGGLER -->
				<!-- BEGIN TOP NAVIGATION MENU -->
				
				
			<div class="top-menu">
				<ul class="nav navbar-nav pull-right">
					<!-- BEGIN USER LOGIN DROPDOWN -->

					<li class="dropdown dropdown-user dropdown-dark">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
						<img alt="" class="img-circle" src="<?php echo base_url() ?>ui_assets/admin/layout3/img/avatar.png">
						<span class="username username-hide-mobile">Accounts</span>
						</a>
						<ul class="dropdown-menu dropdown-menu-default">
							<li>
								<a href="<?php echo base_url().index_page()."accounts/home/my_profile";?>">
								<i class="icon-user"></i> My Profile </a>
							</li>
							<li class="divider">
							</li>
							<li>
								<a onclick="noBack();" href="<?php echo base_url().index_page()."accounts/home/lock";?>">
								<i class="icon-lock"></i> Lock Screen </a>
							</li>
							<li>
								<a href="<?php echo base_url().index_page()."accounts/login/shutdown";?>">
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
					<li class="menu-dropdown classic-menu-dropdown ">
						<a href="<?php echo base_url().index_page()."accounts/home/index";?>">DASHBOARD</a>
					</li>
					<li class="menu-dropdown classic-menu-dropdown ">
						<a href="<?php echo base_url().index_page()."accounts/home/employees";?>">EMPLOYEE</a>
					</li>
					<!--<li class="menu-dropdown classic-menu-dropdown ">
						<a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;">
						CUSTOMERS<i class="fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu pull-left">
							<li class=" dropdown-submenu">
								<?php $types = $this->db->get_where('customers')->result_array(); foreach($types as $type) { ?>
									<li class=" ">
										<a href="<?php echo base_url().index_page().'accounts/home/publication/'.$type['id'];?>">
										<?php echo $type['name']; ?></a>
									</li>
									<?php } ?>	
							</li>
						</ul>
					</li>
					<li class="menu-dropdown classic-menu-dropdown ">
						<a data-hover="megamenu-dropdown" href="<?php echo base_url().index_page().'accounts/home/group_list';?>">
						BILLING</a>
						
					</li>-->
					<li class="menu-dropdown classic-menu-dropdown ">
						<a data-hover="megamenu-dropdown" href="<?php echo base_url().index_page().'accounts/home/billing_homepage';?>">
						BILLING</a>
						
					</li>
					<!--<li class="menu-dropdown classic-menu-dropdown ">
						<a data-hover="megamenu-dropdown" href="<?php echo base_url().index_page().'accounts/home/billing_homepage1';?>">
						BILLING TEST</a>
						
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