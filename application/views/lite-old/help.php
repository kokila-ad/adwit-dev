<?php $this->load->view("lite/head.php"); ?>
<?php $this->load->view("lite/header.php"); ?>
  
<style>
.help .awe-nav {display: block;padding-left: 0;margin-bottom: 0;}
.help .awe-nav > li {  display: block;}
.help .awe-nav > li.active > a {color: #444;background: #ffffff;border-right: 1px solid #fff;border-left: 6px solid #333333;}
.help .awe-nav > li > a {padding: 10px 15px;font-size: 14px;display: inline-block;position: relative;border-top: 0;width: 100%;background: #f4f5f6;border-bottom: solid 1px #e1e1e1;border-right: solid 1px #e1e1e1;border-left: solid 6px #f4f5f6;}
.help .awe-nav > li > a:hover { color: #333;}
.help .left-2 {left: -1px;min-height: 120px;}
.help .zindex {z-index: 999;background-color: #fff;}
.help .awe-nav > li.current,.help .awe-nav > li.active > a {color: #444;background: #ffffff;border-right: 1px solid #fff;border-left: 6px solid #333333;}
.help .awe-nav-responsive {overflow: auto;}
.help .awe-nav-responsive .awe-nav {white-space: nowrap;}
.help .awemenu-nav { height: 62px;background-color: #fff;border-bottom: solid 1px #e1e1e1;border-top: solid 2px #ed1c24;}
.help .awemenu-nav .awemenu-bars {display: none;}
.help .awemenu-nav .awemenu-container { position: relative; }
</style>

<div id="main">
   
<section class="help">
      <div class="container margin-top-20">         
        <div class="row">
			<div class="col-md-12">	
				<p class="margin-vertical-25 xlarge"> Help</p>  
			</div>
		</div>	
		<div class="row border-top margin-0">
			  <div role="tabpanel">               			
				<div class="col-md-4 padding-0 border-left zindex">	
					<div class="awe-nav-responsive">
						<ul class="awe-nav" role="tablist">
							<li role="presentation" class="active">
								<a href="#docs-tabs-1" title="" aria-controls="docs-tabs-1" role="tab" data-toggle="tab"><span class="padding-right-5"></span>FAQ's</a>
							</li>

							<li role="presentation" class="">
								<a href="#docs-tabs-3" title="" aria-controls="docs-tabs-2" role="tab" data-toggle="tab"><span class="padding-right-5"></span>Videos</a>
							</li>
							
							<li role="presentation" class="">
								<a href="#docs-tabs-2" title="" aria-controls="docs-tabs-2" role="tab" data-toggle="tab"><span class="padding-right-5"></span>Contact Us</a>
							</li>	
						</ul>
					</div>
				</div>
				
                <div class="col-md-8 padding-0 border-bottom border-right left-2 border-left">
					<div class="padding-20">
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="docs-tabs-1">
                                <div class="text-muted">
                                   <div class="panel-group" id="accordion">												
										<div class="panel panel-default">
										  <a data-toggle="collapse" data-parent="#accordion" href="#collapse7">
											<div class="panel-heading">
												<h4 class="panel-title">Can I use AdwitAds on my mobile device?</h4>
											</div>
										  </a>
										  <div id="collapse7" class="panel-collapse collapse">
											<div class="panel-body">Yes. AdwitAds is completely mobile enabled and can be used on both mobile phones and tablets.</div>
										  </div>
										</div>	
										<div class="panel panel-default">
										   <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
										   <div class="panel-heading">
												<h4 class="panel-title">I am not receiving email notifications.</h4>
										  </div></a>
										  <div id="collapse2" class="panel-collapse collapse">
											<div class="panel-body">Email notifications may not be delivered for a variety of reasons. Sometimes they are delivered incorrectly to your SPAM folder. Check the spam folder of your email box. If they’re not there please check your dashboard to ensure the order is present. If they’re in your dashboard, please contact your design team who will then resend the email notification.</div>
										  </div>
										</div>
										<div class="panel panel-default">					  
											<a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
											<div class="panel-heading">
											<h4 class="panel-title">I cannot see some of the action icons on my dashboard.
											</h4>
										  </div></a>
										  <div id="collapse3" class="panel-collapse collapse">
											<div class="panel-body">AdwitAds is built using a mobile responsive theme. This means that if your window size is not at its maximum size, some fields and tabs are hidden to automatically adjust to a tablet or mobile screen size. If you maximize the window you will be able to see all fields.</div>
										  </div>
										</div>
										<div class="panel panel-default">
										  <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">
										  <div class="panel-heading">
											<h4 class="panel-title">How do I access the Source/Native Files? What format are they in? </h4>
										  </div></a>
										  <div id="collapse4" class="panel-collapse collapse">
											<div class="panel-body">To access the native files click on the AdwitAds ID that corresponds to your order. This will open up another screen that allows you to download the ‘Source Package’. This package contains the InDesign file (in CS6) along with the images used in the ad, fonts and PDF proof.</div>
										  </div>
										</div>									
										<div class="panel panel-default">
										  <a data-toggle="collapse" data-parent="#accordion" href="#collapse5">
										  <div class="panel-heading">
											<h4 class="panel-title"> Can I place an order for a print ad and combine it with an online ad? </h4>
										  </div></a>
										  <div id="collapse5" class="panel-collapse collapse">
											<div class="panel-body">Unfortunately at this time the two requests are directed to specialists in either print or online ad design. It is therefore recommended that you place two independent orders. However adding a note indicating that they are for the same advertiser will ensure uniformity in design style and instructions to be followed.</div>
										  </div>
										</div>
										<div class="panel panel-default">
										 <a data-toggle="collapse" data-parent="#accordion" href="#collapse6">
										 <div class="panel-heading">
											<h4 class="panel-title">Can I view the order i’ve submitted along with files I’ve attached to it? </h4>
										  </div></a>
										  <div id="collapse6" class="panel-collapse collapse">
											<div class="panel-body">Yes. On your dashboard you can click on the ‘eye’ icon that corresponds to the order you want to view. This will show you the order you submitted along with files you attached.</div>
										  </div>
										</div>
										<div class="panel panel-default">
										  <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
											<div class="panel-heading">
											<h4 class="panel-title"> I am not able to see old orders. </h4>
										  </div></a>
										  <div id="collapse1" class="panel-collapse collapse">
											<div class="panel-body">Orders in your dashboard from the past 3 days are displayed on the first screen of your dashboard. To view orders older than 3 days select advanced search and enter a date range. We typically save all orders for 13 months. If you still cannot find your order please contact your design team.</div>
										  </div>
										</div>
										<div class="panel panel-default">
										  <a data-toggle="collapse" data-parent="#accordion" href="#collapse8">
											  <div class="panel-heading">
													<h4 class="panel-title"> I have a problem that is not listed.</h4>
											  </div>
										  </a>
										  <div id="collapse8" class="panel-collapse collapse">
											<div class="panel-body">If it is regarding a particular ad please contact your design team. If it is regarding the AdwitAds portal, please contact itsupport@adwitads.com. As with any problem the more information we receive, the faster we can investigate it and identify a solution. Sending us screenshots specifying the action you are trying to perform along with your browser version we will be able to address it quickly.

											We continuously release updates to fix bugs and deploy enhancements to the AdwitAds portal.  Your valuable feedback will help significantly speed up the development process. Please contact our development team at itsupport@adwitads.com if you have any thoughts or suggestions regarding AdwitAds.</div>
										  </div>
										</div>		
									</div>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane fade in active" id="docs-tabs-3">
                                <div class="text-muted">
                                   <div class="panel-group" id="accordion">		
										<div class="panel panel-default">
										  <a data-toggle="collapse" data-parent="#accordion" href="#video1">
											<div class="panel-heading">
												<h4 class="panel-title"> How to place an order?</h4>
											</div>
										  </a>
										  <div id="video1" class="panel-collapse collapse">
											<div class="panel-body">
												<a href="http://adwitglobal.com/stage/place-order/" class="text-red" target="_blank">Click here</a> to view the video.
											</div>
										  </div>
										</div>									
										<div class="panel panel-default">
										  <a data-toggle="collapse" data-parent="#accordion" href="#video22">
											<div class="panel-heading">
												<h4 class="panel-title">How to view proof?</h4>
											</div>
										  </a>
										  <div id="video22" class="panel-collapse collapse">
											<div class="panel-body"><a href="http://adwitglobal.com/stage/proof-ready/" class="text-red" target="_blank">Click here</a> to view the video.</div>
										  </div>
										</div>
										<div class="panel panel-default">
										  <a data-toggle="collapse" data-parent="#accordion" href="#video3">
											<div class="panel-heading">
												<h4 class="panel-title">How to submit revision?</h4>
											</div>
										  </a>
										  <div id="video3" class="panel-collapse collapse">
											<div class="panel-body"><a href="http://adwitglobal.com/stage/revision-submission/" class="text-red" target="_blank">Click here</a> to view the video.</div>
										  </div>
										</div>							
									</div>
								</div>
							</div>
							
							 <div role="tabpanel" class="tab-pane fade" id="docs-tabs-2">
                                <div class="text-muted">
                                    <div class="panel-group" id="accordion">		
										<p class="large text-dark margin-bottom-5">Design Team</p>
										<a href="mailto: ravikumar@adwitads.com" class="text-grey"><i class="fa fa-envelope fa-fw"></i>ravikumar@adwitads.com</a>
										
										<p class="large text-dark margin-top-30 margin-bottom-5">IT Support</p>
										<a href="mailto:itsupport@adwitads.com" class="text-grey"><i class="fa fa-envelope fa-fw"></i> itsupport@adwitads.com</a>
									</div>
								</div>                         
							</div>
					</div>
				</div>
			</div>
			  </div>
		 </div>	
	  </div>		
</section><!-- /section -->

</div>
          
<?php $this->load->view("lite/footer.php"); ?>
 <?php $this->load->view("lite/foot.php"); ?>	
