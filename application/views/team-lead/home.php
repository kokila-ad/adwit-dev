<?php
       $this->load->view("team-lead/head");
?>
<!-- END HEADER -->
<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<!-- BEGIN PAGE HEAD -->

	<div class="page-content">
		<div class="container">
			<!-- BEGIN PAGE BREADCRUMB -->
			<ul class="page-breadcrumb breadcrumb hide">
				<li>
					<a href="#">Home</a><i class="fa fa-circle"></i>
				</li>
				<li class="active">
					 Dashboard
				</li>
			</ul>
			<!-- END PAGE BREADCRUMB -->
			
						<!-- BEGIN PAGE CONTENT INNER -->
			<div class="tiles">
			<!--<a href="<?php echo base_url().index_page()."team-lead/home/notifications";?>">
				<div class="tile double-down bg-blue-hoki">
					<div class="tile-body">
						<i class="fa fa-bell-o"></i>
					</div>
					<div class="tile-object">
						<div class="name">
							 Notifications
						</div>
						<div class="number">
							 0
						</div>
					</div>
				</div>
				</a>-->
				<!--<a href="<?php echo base_url().index_page()."team-lead/home/meetings";?>">
				<div class="tile bg-red-sunglo">
					<div class="tile-body">
						<i class="fa fa-calendar"></i>
					</div>
					<div class="tile-object">
						<div class="name">
							 Meetings
						</div>
						<div class="number">
							 0
						</div>
					</div>
				</div>
				</a>-->

				<!--<a href="<?php echo base_url().index_page()."team-lead/home/all_pending";?>">
				<div class="tile bg-purple-studio">
					<div class="tile-body">
						<i class="fa fa-shopping-cart"></i>
					</div>
					<div class="tile-object">
						<div class="name">
							 Orders
						</div>
						<div class="number">
							 121
						</div>
					</div>
				</div>
				</a>-->
				<!--<a href="<?php echo base_url().index_page()."team-lead/home/meetups";?>">
				<div class="tile bg-red-intense">
					<div class="tile-body">
						<i class="fa fa-coffee"></i>
					</div>
					<div class="tile-object">
						<div class="name">
							 Meetups
						</div>
						<div class="number">
							 12 Jan
						</div>
					</div>
				</div>
				</a>-->
				<a href="<?php echo base_url().index_page()."team-lead/home/reports";?>">
				<div class="tile bg-green">
					<div class="tile-body">
						<i class="fa fa-bar-chart-o"></i>
					</div>
					<div class="tile-object">
						<div class="name">
							 Reports
						</div>
						<div class="number">
						</div>
					</div>
				</div>
				</a>
				<a href="<?php echo base_url().index_page()."team-lead/home/my_account";?>">
				<div class="tile bg-yellow-lemon selected">
					<div class="corner">
					</div>
					<div class="check">
					</div>
					<div class="tile-body">
						<i class="fa fa-cogs"></i>
					</div>
					<div class="tile-object">
						<div class="name">
							 Settings
						</div>
					</div>
				</div>
				</a>
			</div>
			<!-- END PAGE CONTENT INNER -->

		</div>
	</div>
    
  
  	
			<!-- END PAGE CONTENT INNER -->

		</div>
	</div>
	<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->

<!-- BEGIN FOOTER -->
<?php 
	$this->load->view("team-lead/foot");
?>