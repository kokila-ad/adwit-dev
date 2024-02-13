<div id="wrapper" class="main-wrapper ">
<?php $my_credits = $this->db->get_where('lite_free_credits_added',array('uid'=>$this->session->userdata('lcId'), 'is_active'=>'1'))->row_array(); ?>            
    <header id="header" class="awe-menubar-header">
        <nav class="awemenu-nav headroom" data-responsive-width="1200">
            <div class="container">
                <div class="awemenu-container">
					
                  <div class="navbar-header">
                    <ul class="navbar-icons">
					
                        <?php if($this->session->userdata('lite_client')){?>
																
                        <li class="menubar-account">
                            <a href="<?php echo base_url().index_page().'lite/home/profile'; ?>" title="" class="awemenu-icon">
                                <i class="fa fa-user"></i>
                                <span class="awe-hidden-text">Account</span>
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
                                                <li class="border-bottom"><a href="<?php echo base_url().index_page().'lite/home/help'; ?>">Help</a></li>
												<li><a href="<?php echo base_url().index_page().'lite/login/shutdown'; ?>">Logout</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
												
						<li class="menubar-cart">
							<a href= "<?php echo base_url().index_page().'lite/home/mycredits'; ?>" title = "" class = "awemenu-icon menu-shopping-cart">
								<i class="glyphicon glyphicon-copyright-mark"></i>
								<span class="large cart-numbe">
								<?php if($my_credits) echo ''.$my_credits['free_credits'].'<br/>'; ?>
								</span>
							</a>	
					<?php }else{ ?>
						<li>
						  <!-- <a href="<?php echo base_url().index_page().'lite/home/mycredits'; ?>" title="" class="awemenu-icon menu-shopping-cart">-->
							  <button type="button" class="btn  btn-primary btn-sm btn-outline">
								  <span>Sign In</span>
							   </button>
						  <!-- </a> -->
                  </li>
				 <?php } ?> 
					
					</ul>
                  </div>
  
					<!--<div class="awe-logo">
                        <a href="<?php echo base_url().index_page().'lite/home/'; ?>" title=""><img src="<?php echo base_url(); ?>/assets/lite/img/logo.png" alt=""></a>
                    </div> /.awe-logo -->
					
					
					
                    <ul class="awemenu awemenu-right">
						<li class="awemenu-item">
                           <a href="<?php echo base_url().index_page().'lite/home'; ?>" title="Home">
                                <span>Home</span>
                           </a>
						</li>
						
                        <li class="awemenu-item">
                           <a href="<?php echo base_url().index_page().'lite/home/print_ad'; ?>" title="Place order">
                                <span>Place order</span>
                           </a>
						</li>

                        <li class="awemenu-item">
                            <a href="<?php echo base_url().index_page().'lite/home/dashboard'; ?>" title="Dashboard">
                               <span>Dashboard</span>
                            </a>
						</li>

                        <li class="awemenu-item">
                            <a href="<?php echo base_url().index_page().'lite/home/buycredit'; ?>" title="Buy Credits">
                                <span>Buy Credits</span>
                            </a>
						</li>						
					</ul><!-- /.awemenu -->
                </div>
            </div><!-- /.container -->

        </nav><!-- /.awe-menubar -->
    </header><!-- /.awe-menubar-header -->

