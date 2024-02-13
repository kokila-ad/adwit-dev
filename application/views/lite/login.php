
<?php $this->load->view("lite/head.php"); ?>

    <body class="page-register">
        <main class="page-content">
            <div class="page-inner">
                <div id="main-wrapper">
                    <div class="row margin-top-100">
					
                        <div class="col-md-4"></div>
                        <div class="col-md-4 center border">
							<span class="text-info" align="center" style="font-weight:600; color:#F00"><?php echo $this->session->flashdata('message'); ?></span>
                            <div class="login-box padding-vertical-10">
							  <!--<a href="index.html" class="logo-name text-lg text-center"><img src="assets/lite/img/logo.png" alt="Adwit Lite"></a>-->
                                <h5 class="text-center margin-0 padding-top-15">ACCOUNT LOGIN</h5>
                                <h6 align="right" style="font-weight:600; color:#F00"><?php echo $this->session->flashdata('sigin_message'); ?></h6>
                                 
								 <form name="signup_form" action="<?php echo base_url().index_page(); ?>lite/login/doIt" method="POST" >

									<div class="form-group">
									<input type="text" name="username" class="form-control" id="register-username" placeholder="Username" required>
									</div>
                                    
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                                    </div>
									
                                    <button type="submit" name="signin" class="btn btn-primary btn-block m-t-xs">Login</button>
                                    <p class="margin-0 padding-top-10">Dont have an account?</p>
                                    <a href="<?php  echo base_url().index_page().'lite/login/registration';  ?>" class="btn btn-dark btn-block m-t-xs">Register</a>
                                </form> 
								 
								 
                                <p class="margin-0 padding-top-10">2016 &copy; adwit global.</p> 
                            </div>
                        </div>
                        <div class="col-md-4"></div>
                    </div><!-- Row -->
                </div><!-- Main Wrapper -->
            </div><!-- Page Inner -->
        </main><!-- Page Content -->
	


<?php $this->load->view("lite/foot.php"); ?>