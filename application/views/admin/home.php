<?php $this->load->view("admin/head1.php"); ?>
 
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
				<!-- BEGIN PAGE HEADER-->
				<h3 class="page-title">Dashboard</h3>
				<!-- END PAGE HEADER-->
				<!-- BEGIN DASHBOARD STATS -->
				<div class="row margin-top-30">
				<?php 
				$publications = $this->db->query("SELECT * FROM `publications` WHERE `is_active` = '1'")->num_rows();
				$adreps = $this->db->query("SELECT * FROM `adreps` WHERE `is_active` = '1' ")->num_rows();
				$team_lead = $this->db->query("SELECT * FROM `team_lead` WHERE `is_active` = '1'")->num_rows();
				$designers = $this->db->query("SELECT * FROM `designers` WHERE `is_active` = '1'")->num_rows();
				$order_count = $this->db->query("SELECT * FROM `orders`")->num_rows();
				?>
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
						<a class="dashboard-stat dashboard-stat-light blue-soft" href="<?php echo base_url().index_page()."admin/home/publications_list";?>">
						<div class="visual">
							<i class="fa fa-sort-numeric-asc"></i>
						</div>
						<div class="details">
							<div class="number"><?php echo $publications;?></div>
							<div class="desc">No  Of Publication</div>
						</div>
						</a>
					</div>
					
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
						<a class="dashboard-stat dashboard-stat-light yellow-casablanca" href="#">
						<div class="visual">
							<i class="fa fa-globe"></i>
						</div>
						<div class="details">
							<div class="number"><?php echo $order_count; ?></div>
							<div class="desc">Total Orders So Far</div>
						</div>
						</a>
					</div>
					
					<div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
						<a class="dashboard-stat dashboard-stat-light red-soft" href="<?php echo base_url().index_page()."admin/home/adreps";?>">
						<div class="visual">
							<i class="fa fa-users"></i>
						</div>
						<div class="details">
							<div class="number"><?php echo $adreps;?></div>
							<div class="desc">No Of Adrep</div>
						</div>
						</a>
					</div>
					
					<div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
						<a class="dashboard-stat dashboard-stat-light green-soft" href="<?php echo base_url().index_page()."admin/home/designers_list";?>">
						<div class="visual">
							<i class="fa fa-users"></i>
						</div>
						<div class="details">
							<div class="number"><?php echo $designers;?></div>
							<div class="desc">No Of Designer</div>
						</div>
						</a>
					</div>
					
					<div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
						<a class="dashboard-stat dashboard-stat-light purple-soft" href="<?php echo base_url().index_page()."admin/home/teamlead_list";?>">
						<div class="visual">
							<i class="fa fa-users"></i>
						</div>
						<div class="details">
							<div class="number"><?php echo $team_lead;?></div>
							<div class="desc">No Of Team Lead</div>
						</div>
						</a>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 col-xs-12">
					<a class="btn btn-primary" href="<?php echo base_url().index_page()."new_admin/home";?>">Switch to New UI</a>
					</div>
				</div>
				<!-- END DASHBOARD STATS -->	
				</div>
				
		</div>
		<!-- END CONTENT -->
		<!-- BEGIN QUICK SIDEBAR -->
		<!--Cooming Soon...-->
		<!-- END QUICK SIDEBAR -->
	</div>
	<!-- END CONTAINER -->
	
<?php $this->load->view("admin/foot1.php"); ?>
	