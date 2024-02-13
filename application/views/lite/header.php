<!-- // LOADING -->
	<div class="awe-page-loading">
		<div class="awe-loading-wrapper">				
			<img src="<?php echo base_url(); ?>assets/lite/img/lite-logo.png" alt="AdwitLite">
			<div class="progress">
				<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
			</div>
		</div>
	</div>
<!-- // END LOADING -->
		
<div id="wrapper" class="main-wrapper ">
<?php $my_credits = $this->lite_client_model->check_credits(); ?>            
    <header id="header" class="awe-menubar-header">
        <nav class="awemenu-nav headroom" data-responsive-width="1200">
            <div class="container">
                				
				<div class="awemenu-container">
				   <div class="awe-logo">
                        <a href="<?php echo base_url().index_page().'lite/home/'; ?>" title="Adwit Lite">
							<img src="<?php echo base_url(); ?>assets/lite/img/lite-logo.png" alt="" style="width: 85%;">
						</a>
                   </div><!-- /.awe-logo -->
					
                  <div class="navbar-header">
                    <ul class="navbar-icons">
					
                        <?php if($this->session->userdata('lite_client')){?>
												
						<li class="menubar-cart border-right">
							<a href= "<?php echo base_url().index_page().'lite/home/mycredits'; ?>" title = "" class = "awemenu-icon menu-shopping-cart">
								<img src="<?php echo base_url()?>/assets/lite/img/credits.png" style="width: 20px;margin-top: -3px;">
								<span class="large cart-numbe">
								<?php if($my_credits) echo ''.$my_credits.'<br/>'; ?>
								</span>
							</a>	
					<?php }else{ ?>
						<li class="border-right">
						  <!-- <a href="<?php echo base_url().index_page().'lite/home/mycredits'; ?>" title="" class="awemenu-icon menu-shopping-cart">-->
							  <button type="button" class="btn  btn-primary btn-sm btn-outline">
								  <span>Sign In</span>
							   </button>
						  <!-- </a> -->
                  </li>
				 <?php } ?> 
					<li class="menubar-account">
						<a class="awemenu-icon">
							<i class="fa fa-user"></i>
						</a>
						<ul class="submenu megamenu">
							<li>
							   <div class="container-fluid">
									<div class="header-account">
										<div class="header-account-avatar">
											<a href="<?php echo base_url().index_page().'lite/home'; ?>" title="">
												<img src="<?php  echo base_url();  ?>./assets/lite/img/dp_s.jpg" alt="" class="img-circle" style="width: 70px;">
											</a>
										</div>

										<div class="header-account-username">
											<h4><a style="word-wrap: break-word;width: 100px; "href="<?php echo base_url().index_page().'lite/home/profile'; ?>"><?php echo $this->session->userdata('lite_client'); ?></a></h4>
										</div>

										<ul>
											<li class="border-bottom"><a href="<?php echo base_url().index_page().'lite/home/profile'; ?>">View Profile</a></li>
											<li><a href="<?php echo base_url().index_page().'lite/login/shutdown'; ?>">Logout</a></li>
										</ul>
									</div>
								</div>
							</li>
						</ul>
					</li>
					
					</ul>
                  </div>
  
					<!--<div class="awe-logo">
                        <a href="<?php echo base_url().index_page().'lite/home/'; ?>" title=""><img src="<?php echo base_url(); ?>/assets/lite/img/logo.png" alt=""></a>
                    </div> /.awe-logo -->
					
					
					
                    <ul class="awemenu awemenu-right">
						<li class="awemenu-item">
                           <a href="<?php echo base_url().index_page().'lite/home'; ?>">Home</a>
						</li>
						
                        <li class="awemenu-item">
                           <a href="<?php echo base_url().index_page().'lite/home/print_ad'; ?>">Place Order</a>
						</li>

                        <li class="awemenu-item">
                            <a href="<?php echo base_url().index_page().'lite/home/dashboard'; ?>">Dashboard</a>
						</li>

                        <li class="awemenu-item">
                            <a href="<?php echo base_url().index_page().'lite/home/buycredit'; ?>">Buy Credits</a>
						</li>

						<li class="awemenu-item">
                            <a href="<?php echo base_url().index_page().'lite/home/help'; ?>">Help</a>
						</li>						
					</ul><!-- /.awemenu -->
                </div>
            </div><!-- /.container -->

        </nav><!-- /.awe-menubar -->
    </header><!-- /.awe-menubar-header -->

