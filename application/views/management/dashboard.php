<?php $this->load->view("management/head"); ?>
<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<div class="page-content">
		<div class="container">
		
			<div class="row margin-top-15">
				<div class="col-sm-6">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="font-md font-grey-gallery bold">Today's Ads </span>
							</div>
							<div class="tools">
								<span class="badge"> <?php echo count($all_orders); ?> </span> 
							</div>
						</div>
						<div class="portlet-body form">
							<!--<p class="font-md margin-bottom-15 font-grey-gallery">List of Groups</p>-->
							<div class="scroller" style="height:312px" data-always-visible="1" data-rail-visible="0">
								<?php if(isset($groups)){?>
								<ul class="list-group">
								<?php foreach($groups as $row){ ?>
									<li class="list-group-item">
										<?php echo $row['name'];?> <span class="pull-right"><?php echo $row['help_desk_id'];?></span>
									</li>
								<?php } ?>	
								</ul>
								<?php }?>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="portlet light">
						<div class="portlet-body form">
							<div class="portlet light no-space">
								<div class="portlet-title">
									<div class="caption">
										<span class="font-md font-grey-gallery bold">Complaints</span>
									</div>
									<div class="tools">
										<a>view all</a>
									</div>
								</div>
								<div class="portlet-body form">
									<div class="scroller" style="height:127px" data-always-visible="1" data-rail-visible="0">
										<div class="no-margin">
											No Complaints
										</div>
									</div>
								</div>
							</div>
							<div class="portlet light no-space">
								<div class="portlet-title">
									<div class="caption">
										<span class="font-md font-grey-gallery bold">Compliments</span>
									</div>
									<div class="tools">
										<a>view all</a>
									</div>
								</div>
								<div class="portlet-body form">
									<div class="scroller" style="height:127px" data-always-visible="1" data-rail-visible="0">
										<div class="no-margin">
											No Compliments
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
				
			<div class="row">
				<div class="col-sm-6">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="font-md font-grey-gallery bold">Customer Rating </span>
							</div>
							<div class="tools">
								<a>view details</a>
							</div>
						</div>
						<div class="portlet-body">
							<ul class="list-group">
								<li class="row list-group-item">
									<div class="col-md-3 col-sm-6 col-xs-7">
										<i class="fa fa-star font-yellow"></i>
										<i class="fa fa-star font-yellow"></i>
										<i class="fa fa-star font-yellow"></i>
										<i class="fa fa-star font-yellow"></i>
										<i class="fa fa-star font-yellow"></i>
									</div>
									<div class="col-md-9 col-sm-6 col-xs-5">
										<span class=""><?php echo $order_ratings5; ?></span>
									</div>
								</li>
								<li class="row list-group-item">
									<div class="col-md-3 col-sm-6 col-xs-7">
										<i class="fa fa-star font-yellow"></i>
										<i class="fa fa-star font-yellow"></i>
										<i class="fa fa-star font-yellow"></i>
										<i class="fa fa-star font-yellow"></i>
									</div>
									<div class="col-md-9 col-sm-6 col-xs-5">
										<span class=""><?php echo $order_ratings4; ?></span>
									</div>
								</li>
								<li class="row list-group-item">
									<div class="col-md-3 col-sm-6 col-xs-7">
										<i class="fa fa-star font-yellow"></i>
										<i class="fa fa-star font-yellow"></i>
										<i class="fa fa-star font-yellow"></i>
									</div>
									<div class="col-md-9 col-sm-6 col-xs-5">
										<span class=""> <?php  echo $order_ratings3; ?> </span>
									</div>
								</li>
								<li class="row list-group-item">
									<div class="col-md-3 col-sm-6 col-xs-7">
										<i class="fa fa-star font-yellow"></i>
										<i class="fa fa-star font-yellow"></i>
									</div>
									<div class="col-md-9 col-sm-6 col-xs-5">
										<span class=""><?php echo $order_ratings2; ?></span>
									</div>
								</li>
								<li class="row list-group-item">
									<div class="col-md-3 col-sm-6 col-xs-7">
										<i class="fa fa-star font-yellow"></i>
									</div>
									<div class="col-md-9 col-sm-6 col-xs-5">
										<span class=""><?php  echo $order_ratings1;?></span>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="font-md font-grey-gallery bold">Recent Announcement</span>
							</div>
							<div class="tools">
								<a>view all</a>
							</div>
						</div>
						<div class="portlet-body">
							<div class="scroller" style="height:218px" data-always-visible="1" data-rail-visible="0">
								<ul class="list-group">
									<li class="list-group-item">
										No Recent Announcement
										<p class="text-right font-grey-cascade no-space"><small></small></p>
									</li>
									<!--<li class="list-group-item">
										Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
										<p class="text-right font-grey-cascade no-space"><small>- 24-Aug-16</small></p>
									</li>
									<li class="list-group-item">
										Lorem Ipsum has been the industry's standard as been the industry's text ever since the 1500s.
										<p class="text-right font-grey-cascade no-space"><small>- 08-July-16</small></p>
									</li>
									<li class="list-group-item">
										Lorem Ipsum has been the industry's standard that has been the industry's standard dummy text ever since the 1500s.
										<p class="text-right font-grey-cascade no-space"><small>- 01-July-16</small></p>
									</li>
									<li class="list-group-item">
										Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
										<p class="text-right font-grey-cascade no-space"><small>- 28-June-16</small></p>
									</li>
									<li class="list-group-item">
										Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
										<p class="text-right font-grey-cascade no-space"><small>- 17-June-16</small></p>
									</li> -->
								</ul>
							</div>
							<!---<div class=" margin-bottom-10">
									Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
								</div>--->
						</div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-6">
					<div class="portlet light">
						<div class="portlet-body form">
							<ul class="list-group"  style="margin-bottom:38px;">
								<li class="list-group-item">
									No of Publication <span class="pull-right"> <?php echo $publication; ?> </span>
								</li>
								<li class="list-group-item">
									No of Adrep<span class="pull-right"> <?php echo $adrep;?></span>
								</li>
							</ul>  
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="portlet light">
						<div class="portlet-body form">
							<ul class="list-group no-space">
								<li class="list-group-item">
									No of Designers <span class="pull-right"> <?php echo $designer;?> </span>
								</li>
								<li class="list-group-item">
									No of CSR's <span class="pull-right"> <?php echo $csr;?> </span>
								</li>
								<li class="list-group-item">
									No of Team Leads <span class="pull-right"><?php echo $teamlead;?></span>
								</li>
							</ul>  
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

<?php $this->load->view("management/foot"); ?>
