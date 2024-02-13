
<?php $this->load->view("lite/head.php"); ?>

    <body class="page-register">
        <main class="page-content">
            <div class="page-inner">
                <div id="main-wrapper">
                    <div class="row margin-top-100">
                        <div class="col-md-4"></div>
                        <div class="col-md-4 center border">
                            <div class="login-box padding-vertical-10">
                                <!--<a href="index.html" class="logo-name text-lg text-center"><img src="assets/img/logo.png" alt="Adwit lite"></a>-->
                                <!--<h5 class="text-center margin-0 padding-top-15">CREATE AN ACCOUNT</h5>-->
                                <h6 align="right" style="font-weight:600; color:#F00">
									<?php echo $this->session->flashdata('signup_message'); ?>
								</h6>
                                 <form name="signup_form" class="m-t-md" action="<?php echo base_url().index_page(); ?>lite/login/register" method="POST" >
									<div class="form-group">
									<input type="text" name="first_name" class="form-control" id="register-username" placeholder="First Name" required>
									</div>
									<div class="form-group">
									<input type="text" name="last_name" class="form-control" id="register-username" placeholder="Last Name" required>
									</div>
									<div class="form-group">
									<input type="text" name="username" class="form-control" id="register-username" placeholder="Username" required>
									</div>
                                    <div class="form-group">
                                        <input type="email" name="email_id" class="form-control" placeholder="Email" required>
                                    </div>
									<!-- <div class="form-group">
                                        <input type="text" name="phonenumber" class="form-control" placeholder="Phone number" required>
                                    </div>-->
									 <div class="form-group">
                                        <input type="text" name="publication" class="form-control" placeholder="Publisher" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                                    </div>
									  <div class="form-group">
									<input type="password" name="confirm_password" class="form-control" id="register-confirm-password" placeholder="Confirm Password" required>
															<span id='message'></span>
									</div>
                                    <!--<label>
                                        <input type="checkbox"> Agree the terms and policy
                                    </label>-->
                                    <button type="submit" name="signup" class="btn btn-primary btn-block m-t-xs">Sign Up</button>
                                    <p class="margin-0 padding-top-10">Already have an account?</p>
                                    <a href="<?php  echo base_url().index_page(); ?>lite/login" class="btn btn-dark btn-block m-t-xs">Login</a>
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