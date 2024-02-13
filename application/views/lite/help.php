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
										<p>Here is a brief list of frequently asked questions. If you have a question you don’t see below, please write email to your design team (if its regarding an ad) or <a href="mailto:itsupport@adwitads.com">itsupport@adwitads.com</a> (if its regarding the portal). We will continue to update these FAQ’s.</p><div class="panel panel-default">
										  <a data-toggle="collapse" data-parent="#accordion" href="#collapse7">
											<div class="panel-heading">
												<h4 class="panel-title">Is there any limit on the number of free ads?</h4>
											</div>
										  </a>
										  <div id="collapse7" class="panel-collapse collapse">
											<div class="panel-body">The basic version offers up to 2 free ads every week. This limit is reset every Sunday.</div>
										  </div>
										</div>	
										<div class="panel panel-default">
										   <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
										   <div class="panel-heading">
												<h4 class="panel-title">What if I need more than this?</h4>
										  </div></a>
										  <div id="collapse2" class="panel-collapse collapse">
											<div class="panel-body">We offer 3 pricing options available on the Buy Credits page. If you are a large newspaper/group and require enterprise level pricing, please Contact Us.</div>
										  </div>
										</div>
										<div class="panel panel-default">					  
											<a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
											<div class="panel-heading">
											<h4 class="panel-title">How many credits are required to design an ad?
											</h4>
										  </div></a>
										  <div id="collapse3" class="panel-collapse collapse">
											<div class="panel-body">The credits required vary based on size, complexity, creativity among other factors. An algorithm determines the cost (no. of credits) required to build the ad.</div>
										  </div>
										</div>
										<div class="panel panel-default">
										  <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">
										  <div class="panel-heading">
											<h4 class="panel-title">Will I know in advance of ordering, how much an ad will cost?</h4>
										  </div></a>
										  <div id="collapse4" class="panel-collapse collapse">
											<div class="panel-body">Yes. You will see the number of credits required, after the order form is filled out and you hit submit. You will not be charged until you click on proceed & attach files in the next step.</div>
										  </div>
										</div>									
										<div class="panel panel-default">
										  <a data-toggle="collapse" data-parent="#accordion" href="#collapse5">
										  <div class="panel-heading">
											<h4 class="panel-title">I do not have sufficient credits. Will my existing order information be lost?</h4>
										  </div></a>
										  <div id="collapse5" class="panel-collapse collapse">
											<div class="panel-body">Don’t worry. If you do not have sufficient credits after you’ve filled out an order, you can return to your dashboard to complete your order, once you have purchased the required credits.</div>
										  </div>
										</div>
										<div class="panel panel-default">
										 <a data-toggle="collapse" data-parent="#accordion" href="#collapse6">
										 <div class="panel-heading">
											<h4 class="panel-title">How does the entire process work?</h4>
										  </div></a>
										  <div id="collapse6" class="panel-collapse collapse">
											<div class="panel-body">
												<p>Click on the following links to watch videos that are helpful.</p>
												<a href="http://adwitglobal.com/stage/place-order/" target="_blank"><i class="fa fa-angle-double-right"></i> How to Place an Order</a><br/>
												<a href="http://adwitglobal.com/stage/proof-ready/" target="_blank"><i class="fa fa-angle-double-right"></i> How to View a Proof</a><br/>
												<a href="http://adwitglobal.com/stage/revision-submission/" target="_blank"><i class="fa fa-angle-double-right"></i> How to Request Changes</a>
											</div>
										  </div>
										</div>
										<div class="panel panel-default">
										  <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
											<div class="panel-heading">
											<h4 class="panel-title">What are your delivery times for new ads?</h4>
										  </div></a>
										  <div id="collapse1" class="panel-collapse collapse">
											<div class="panel-body">Ads are designed and delivered as soon as possible within a maximum time of 12 hours from the time of submission. In our experience you will typically have your design back in about 4 hours.</div>
										  </div>
										</div>
										<div class="panel panel-default">
										  <a data-toggle="collapse" data-parent="#accordion" href="#collapse8">
											  <div class="panel-heading">
													<h4 class="panel-title">What about changes or corrections?</h4>
											  </div>
										  </a>
										  <div id="collapse8" class="panel-collapse collapse">
											<div class="panel-body">Changes are guaranteed within 2 hours. However the average time based on current usage is about 1 hour.</div>
										  </div>
										</div>	
										<div class="panel panel-default">
										  <a data-toggle="collapse" data-parent="#accordion" href="#collapse9">
											  <div class="panel-heading">
													<h4 class="panel-title">What format do you deliver the ads in?</h4>
											  </div>
										  </a>
										  <div id="collapse9" class="panel-collapse collapse">
											<div class="panel-body">All ads are delivered in Hi-Res PDF format ready for printing. If you have any specific print setting preferences, please let us know in the Notes & Instructions field on your order. Examples of these could be magazine glossy paper, standard newsprint or special posters.</div>
										  </div>
										</div>	
										<div class="panel panel-default">
										  <a data-toggle="collapse" data-parent="#accordion" href="#collapse10">
											  <div class="panel-heading">
												<h4 class="panel-title">What are the features available on my Dashboard?</h4>
											  </div>
										  </a>
										  <div id="collapse10" class="panel-collapse collapse">
											<div class="panel-body">This is the central location for all your activity. You can view orders, view proofs, request changes, attach files, view the status of an ad and approve orders.</div>
										  </div>
										</div>	
										<div class="panel panel-default">
										  <a data-toggle="collapse" data-parent="#accordion" href="#collapse11">
											  <div class="panel-heading">
												<h4 class="panel-title">I forgot to attach additional information or files and I submitted my order already.</h4>
											  </div>
										  </a>
										  <div id="collapse11" class="panel-collapse collapse">
											<div class="panel-body">The paper clip icon in your dashboard allows you to attach additional files. This can be done only until the ad is being checked for quality. If it is absolutely important that you need help at this stage, please contact your design team. Their email address will be in the activation email sent to you at the time of signup.</div>
										  </div>
										</div>	
										<div class="panel panel-default">
										  <a data-toggle="collapse" data-parent="#accordion" href="#collapse12">
											  <div class="panel-heading">
												<h4 class="panel-title">Can I pickup a previously approved order to make a change?</h4>
											  </div>
										  </a>
										  <div id="collapse12" class="panel-collapse collapse">
											<div class="panel-body">Yes. There is a pickup icon available in your dashboard that corresponds to every approved order. This will however be considered as a new ad and all appropriate charges and timelines are applicable.</div>
										  </div>
										</div>	
										<div class="panel panel-default">
										  <a data-toggle="collapse" data-parent="#accordion" href="#collapse13">
											  <div class="panel-heading">
												<h4 class="panel-title">Can I access a proof from a few months ago?</h4>
											  </div>
										  </a>
										  <div id="collapse13" class="panel-collapse collapse">
											<div class="panel-body">Absolutely. We typically configure the portal to retain proofs from the last 13 months. So, any and all proofs for that period are available in your dashboard.</div>
										  </div>
										</div>		
									</div>
                                </div>
                            </div>

							 <div role="tabpanel" class="tab-pane fade" id="docs-tabs-2">
                                <div class="text-muted">
                                    <div class="panel-group" id="accordion">		
										<p class="large text-dark margin-bottom-5">Design Team</p>
										<a href="mailto:design6@adwitads.com" class="text-grey"><i class="fa fa-envelope fa-fw"></i>design6@adwitads.com</a>
										
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
