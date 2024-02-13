<!DOCTYPE html>
<!--
Author: Keenthemes
Product Name: Metronic - Bootstrap 5 HTML, VueJS, React, Angular, Asp.Net Core, Blazor, Django, Flask & Laravel Admin Dashboard Theme
Purchase: https://1.envato.market/EA4JP
Website: http://www.keenthemes.com
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html lang="en">
	<!--begin::Head-->
	<head>
		<base href="../../../">
		<title>Adwit signup</title>
		<meta charset="utf-8" />
		<meta name="description" content="The most advanced Bootstrap Admin Theme on Themeforest trusted by 100,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue, Asp.Net Core, Blazor, Django, Flask &amp; Laravel versions. Grab your copy now and get life-time updates for free." />
		<meta name="keywords" content="Metronic, Bootstrap, Bootstrap 5, Angular, VueJs, React, Asp.Net Core, Blazor, Django, Flask &amp; Laravel, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="Metronic - Bootstrap 5 HTML, VueJS, React, Angular, Asp.Net Core, Blazor, Django, Flask &amp; Laravel Admin Dashboard Theme" />
		<meta property="og:url" content="https://keenthemes.com/metronic" />
		<meta property="og:site_name" content="Keenthemes | Metronic" />
		<link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
		<link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Page Vendor Stylesheets(used by this page)-->
		<link href="https://adshub-adwit.s3.ap-south-1.amazonaws.com/adwit_adrep_v1/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
		<link href="https://adshub-adwit.s3.ap-south-1.amazonaws.com/adwit_adrep_v1/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Page Vendor Stylesheets-->
		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="https://adshub-adwit.s3.ap-south-1.amazonaws.com/adwit_adrep_v1/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="https://adshub-adwit.s3.ap-south-1.amazonaws.com/adwit_adrep_v1/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
        <link href="https://adshub-adwit.s3.ap-south-1.amazonaws.com/adwit_adrep_v1/assets/css/adrep-custom.css" rel="stylesheet" type="text/css" />
		<!--begin::Page Vendor Stylesheets(used by this page)-->
		<link href="https://adshub-adwit.s3.ap-south-1.amazonaws.com/adwit_adrep_v1/assets/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Page Vendor Stylesheets-->

	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body data-kt-name="metronic" id="kt_body" class="app-blank app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
		<!--begin::Theme mode setup on page load-->
		<script>if ( document.documentElement ) { const defaultThemeMode = "system"; const name = document.body.getAttribute("data-kt-name"); let themeMode = localStorage.getItem("kt_" + ( name !== null ? name + "_" : "" ) + "theme_mode_value"); if ( themeMode === null ) { if ( defaultThemeMode === "system" ) { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } else { themeMode = defaultThemeMode; } } document.documentElement.setAttribute("data-theme", themeMode); }</script>
		<!--end::Theme mode setup on page load-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<!--begin::Page bg image-->
			<style>body { background-image: url('https://adshub-adwit.s3.ap-south-1.amazonaws.com/adwit_adrep_v1/assets/media/bg9-dark.jpg'); } [data-theme="dark"] body { background-image: url('https://adshub-adwit.s3.ap-south-1.amazonaws.com/adwit_adrep_v1/assets/media/bg4-dark.jpg'); }</style>
			<!--end::Page bg image-->
			<!--begin::Authentication - Sign-up -->
			<div class="row">
				<!--begin::Aside-->
				<div class="d-flex col-md-6 pt-15 pt-lg-0 px-10">
					<!--begin::Aside-->
					<div class="d-flex flex-column">
						<!--begin::Logo-->
						<a href="javascript:;" class="mb-7 pt-10">
							<img alt="Logo" src="https://adwitads.com/weborders/assets/new_client/img/Adwit_ads_white.png" />
						</a>
						<!--end::Logo-->
						<!--begin::Title-->
						<div class="flex-center pt-20">
							<h1 class="pt-20" style="font-size: 60px;color: #ffff">Unlimited Designs.</h1>
							<h1 class="pt-0" style="font-size: 60px;color: #ffff">Unlimited Changes.</h1>
							<h2 class="text-white fw-normal m-0 pt-20">No credit card needed. No obligation. 30 day free-trial.</h2>
						</div> 
						<!--end::Title-->
					</div> 
					<!--begin::Aside-->
				</div>
				<!--begin::Aside-->
				<!--begin::Body-->
				<div class="d-flex flex-center col-md-6 p-10">
					<!--begin::Card-->
					<div class="card rounded-3 w-md-550px">
						<!--begin::Card body-->
						<div class="card-body p-10 p-lg-20">
							<!--begin::Form-->
							<form method="post" name="signUpForm" class="form w-100 fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate" id="kt_sign_up_form">
							<!--begin::Heading-->
							<div class="mb-10 text-center">
								<!--begin::Title-->
								<h1 class="text-dark mb-3">Create an Account</h1>
								<!--end::Title-->
								<!--begin::Link-->
								<div class="text-gray-400 fw-bold fs-4">Already have an account?
								<a href="https://adwitads.com/weborders/" target="_blank" class="link-primary fw-bolder">Sign in here</a></div>
								<!--end::Link-->
								<p class="text-dark fw-bolder"><?php echo $this->session->flashdata('message'); ?></p>
								<?php echo $this->session->flashdata('success_message'); ?>
							</div>
							<!--end::Heading-->
							<!--begin::Action-->
							<!--end::Action-->
						<?php if($this->session->flashdata('success_message') == ''){ ?>	
							<!--begin::Input group-->
							<div class="row fv-row mb-7 fv-plugins-icon-container">
								<!--begin::Col-->
								<div class="col-xl-12 ps-3 pe-3 pt-1 pb-1">
									<input class="form-control form-control-lg form-control-solid" type="text" placeholder="First Name" name="first_name" autocomplete="off">
								<div class="fv-plugins-message-container invalid-feedback"></div></div>
								<!--end::Col-->
								
								<!--end::Col-->
							</div>
							<!--end::Input group-->
							
							<!--begin::Input group-->
							<div class="row fv-row mb-7 fv-plugins-icon-container">
								<!--begin::Col-->
								<div class="col-xl-12 ps-3 pe-3 pt-3 pb-3">
									<input class="form-control form-control-lg form-control-solid" type="text" placeholder="Last Name" name="last_name" autocomplete="off">
								<div class="fv-plugins-message-container invalid-feedback"></div></div>
								<!--end::Col-->
								
								<!--end::Col-->
							</div>
							<!--end::Input group-->
							
							
							<!--begin::Input group-->
							<div class="fv-row mb-7 fv-plugins-icon-container ps-3 pe-3 pt-3 pb-3">
								<input class="form-control form-control-lg form-control-solid" type="email" placeholder="Work Email" name="email" autocomplete="off">
							<div class="fv-plugins-message-container invalid-feedback"></div></div>
							<!--end::Input group-->
							
							<!--begin::Input group-->
							<div class="fv-row mb-7 fv-plugins-icon-container ps-3 pe-3 pt-3 pb-3">
								<input class="form-control form-control-lg form-control-solid" type="email" placeholder="Publication / Newspaper" name="publication" autocomplete="off">
							<div class="fv-plugins-message-container invalid-feedback"></div></div>
							<!--end::Input group-->
							
							
							<!--begin::Input group-->
							<div class="fv-row mb-7 fv-plugins-icon-container ps-3 pe-3 pt-3 pb-3" data-kt-password-meter="true">
								<!--begin::Wrapper-->
								
									<!--begin::Label-->
									<!--end::Label-->
									<!--begin::Input wrapper-->
									<div class="position-relative ">
										<input class="form-control form-control-lg form-control-solid" type="password" placeholder="Password" name="password" autocomplete="off">
										<span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
											<i class="bi bi-eye-slash fs-2"></i>
											<i class="bi bi-eye fs-2 d-none"></i>
										</span>
									</div>
									<!--end::Input wrapper-->
									

								<!--end::Wrapper-->
								<!--begin::Hint-->
								 
								<!--div class="text-muted">Use 6 or more characters.</div-->
								<!--end::Hint-->
							<div class="fv-plugins-message-container invalid-feedback"></div></div>
							<!--end::Input group=-->
							<!--begin::Input group-->
							<div class="fv-row mb-5 fv-plugins-icon-container ps-3 pe-3 pt-3 pb-3">
								<input class="form-control form-control-lg form-control-solid" type="password" placeholder="Confirm Password" name="confirm-password" autocomplete="off">
							<div class="fv-plugins-message-container invalid-feedback"></div></div>
							<!--end::Input group-->
							<!--begin::Input group-->
							<div class="fv-row mb-5 fv-plugins-icon-container ps-3 pe-3">
								<a href="#" style="font-size: 11px" data-bs-toggle="modal" data-bs-target="#kt_modal_1">By Submitting you agree to the Terms & Conditions</a>
								</div>
							<!--end::Input group--> 
							<!--begin::Actions-->
							<div class="right pt-1">
								<button type="button" id="kt_sign_up_submit" class="btn btn-lg btn-primary">
									<span class="indicator-label">Submit</span>
									<span class="indicator-progress">Please wait...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
								</button>
							</div>
							<!--end::Actions-->
						<?php } ?>	
						<div></div></form>
							<!--end::Form-->
						</div>
						<!--end::Card body-->
					</div>
					<!--end::Card-->
				</div>
				<!--end::Body-->
			</div>
			<!--end::Authentication - Sign-up-->
			
			

			<div class="modal fade" tabindex="-1" id="kt_modal_1">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h3 class="modal-title">Free Trial Terms & Conditions for Adwit Global's Graphic Design Service</h3>

							<!--begin::Close-->
							<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
								<i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
							</div>
							<!--end::Close-->
						</div> 

						<div class="modal-body">
							<p>1. Eligibility: This free trial offer is exclusively for new customers. Existing customers are not eligible.</p>
							<p>2. Modification & Cancellation: Adwit Global reserves the right to cancel or modify this offer at any time without prior notice.</p>
							<p>3. Duration & Usage: Upon sign up, you'll receive unlimited ads and can request changes for 30 days. The trial starts immediately after signing up.</p>
							<p>4. No Payment Details Required: Signing up for the free trial does not require a credit card.</p>
							<p>5. Data Usage: We may use some of your personal data to contact you about our services. Rest assured, your data is protected with us.</p>
							<p>6. Post-Trial: Once your free trial ends, there's absolutely no obligation to continue with our services.</p>
						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>

						</div>
					</div>
				</div>
			</div>




		</div>
		<!--end::Root-->
		<!--begin::Javascript-->
		<script>var hostUrl = "assets/";</script>
		<!--begin::Global Javascript Bundle(used by all pages)-->
        <script src="https://adshub-adwit.s3.ap-south-1.amazonaws.com/adwit_adrep_v1/assets/plugins/global/plugins.bundle.js"></script>
		<script src="https://adshub-adwit.s3.ap-south-1.amazonaws.com/adwit_adrep_v1/assets/js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Custom Javascript(used by this page)-->
        <script src="https://adshub-adwit.s3.ap-south-1.amazonaws.com/adwit_adrep_v1/assets/js/custom/authentication/sign-up/general_v1.js"></script>
		<!--end::Custom Javascript-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>