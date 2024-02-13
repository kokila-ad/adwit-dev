<?php $this->load->view('new_designer/head')?>
<style>
@media (max-width: 767px)
{
.list-separated {
    position: relative;
    left: 36px;
}
}
</style>
<!-- BEGIN PAGE CONTAINER -->
<div class="page-container"></div>
	<div class="page-content">
		<div class="container">
			<div class="row margin-top-15">
			<?php $i=0; foreach($output as $data){ $i++; ?>
				<div class="col-sm-6" style="height: 520px;">
					<div class="portlet light border padding-top-0">	
    						 <div class="portlet light">
    							<div class="portlet-title">
    							    <div class="col-md-6">
        								<div class="caption">
        									<span class="font-md font-grey-gallery bold"><?php echo $data[0]; ?></span> <span id="team<?php echo $i; ?>" class="font-sm"></span>
        								</div>
    								</div>
    							</div>
    						</div>
						    <!-- Status wise Ad count -->
						    <div class="row col-md-offset-1 list-separated">
						        <div class="col-md-2 col-sm-4 col-xs-4">
    								<div class="uppercase font-hg font-black-flamingo">
    								    <a href="#" target="_blank"><?php echo $data[1]['ad_count']; ?></a>
    								</div>
    								<div class="font-grey-mint font-sm"><?php echo $data[1]['statusName']; ?></div>
    							</div>
    						    <?php $total_count = $data[1]['ad_count']; foreach($data[2] as $row){ $total_count = ($total_count + $row['ad_count']); //print_r($row);?> 
    							<div class="col-md-2 col-sm-4 col-xs-4">
    								<div class="uppercase font-hg font-black-flamingo">
    								    <a href="#" target="_blank"><?php echo $row['ad_count']; ?></a>
    								</div>
    								<div class="font-grey-mint font-sm"><?php echo $row['statusName']; ?></div>
    							</div>
    							<?php } ?>
						    </div>
						    <script>
    					 	    $( document ).ready(function() {
                                    $('#team<?php echo $i; ?>').html('(Total - <b>'+<?php echo $total_count; ?>+'</b>)');
                                });
    					 	</script>
    					 	<!-- Total, Pending, Sent Ad count -->
    						<div class="row col-md-offset-1 list-separated">
    						    <div class="col-md-2 col-sm-4 col-xs-4">
    								<div class="uppercase font-hg font-black-flamingo">
    								    <a href="#" target="_blank"><?php echo $data[3]['total_Ads']; ?></a>
    								</div>
    								<div class="font-grey-mint font-sm">Total Ads</div>
    							</div>
    						
    						    <div class="col-md-2 col-sm-4 col-xs-4">
    								<div class="uppercase font-hg font-black-flamingo">
    								    <a href="#" target="_blank"><?php echo $data[4]['pending_Ads']; ?></a>
    								</div>
    								<div class="font-grey-mint font-sm">Pending Ads</div>
    							</div>
    						
    						    <div class="col-md-2 col-sm-4 col-xs-4">
    								<div class="uppercase font-hg font-black-flamingo">
    								    <a href="#" target="_blank"><?php echo $data[5]['sent_Ads']; ?></a>
    								</div>
    								<div class="font-grey-mint font-sm">Sent Ads</div>
    							</div>
    						</div>
    						<!-- Category wise Ad count -->
						    <div class="row col-md-offset-1 list-separated">
    						    <?php foreach($data[6] as $row){ ?> 
    							<div class="col-md-2 col-sm-4 col-xs-4">
    								<div class="uppercase font-hg font-black-flamingo">
    								    <a href="#" target="_blank"><?php echo $row['ad_count']; ?></a>
    								</div>
    								<div class="font-grey-mint font-sm"><?php echo $row['category']; ?></div>
    							</div>
    							<?php } ?>
					       </div>
					       <!-- Yesterdays Status wise Ad count -->
					       <?php if(isset($data[7][0]['ad_count'])){ ?>
						    <div class="row col-md-offset-1 list-separated"><p>Yesterday's Ad Count</p>
    						    <?php foreach($data[7] as $row){ ?> 
    							<div class="col-md-2 col-sm-4 col-xs-4">
    								<div class="uppercase font-hg font-black-flamingo">
    								    <a href="#" target="_blank"><?php echo $row['ad_count']; ?></a>
    								</div>
    								<div class="font-grey-mint font-sm"><?php echo $row['name']; ?></div>
    							</div>
    							<?php } ?>
					       </div>
					      <?php } ?> 
					</div>
				</div>    
			<?php } ?>
			</div>
	    </div>
    </div>

<?php $this->load->view('new_designer/foot')?>
