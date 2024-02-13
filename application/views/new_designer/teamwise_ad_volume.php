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
			<?php $i=0; foreach($adwit_teams as $adwit_team){ $i++; $adwit_teams_id = $adwit_team['adwit_teams_id']; ?>
				<div class="col-sm-6" style="height: 520px;" id="Team<?php echo $adwit_teams_id; ?>">
					<div class="portlet light border padding-top-0">	
    						 <div class="portlet light">
    							<div class="portlet-title">
    							    <div class="col-md-6">
        								<div class="caption">
        									<span class="font-md font-grey-gallery bold"><?php echo $adwit_team['name']; ?></span> 
        									<span id="team_total_count<?php echo $adwit_teams_id; ?>" class="font-sm"></span>
        									<span id="loading<?php echo $adwit_teams_id; ?>" class="font-md font-green">  Loading...</span>
        								</div>
    								</div>
    							</div>
    						</div>
						    <!-- Status wise Ad count -->
						    <div class="row col-md-offset-1 list-separated" id="status_wise_count_div<?php echo $adwit_teams_id; ?>">
						        
						    </div>
						    
    					 	<!-- Total, Pending, Sent Ad count -->
    						<div class="row col-md-offset-1 list-separated">
    						    <div class="col-md-2 col-sm-4 col-xs-4">
    								<div class="uppercase font-hg font-black-flamingo" id="todays_total_ads<?php echo $adwit_teams_id; ?>"></div>
    								<div class="font-grey-mint font-sm">Total Ads</div>
    							</div>
    						
    						    <div class="col-md-2 col-sm-4 col-xs-4">
    								<div class="uppercase font-hg font-black-flamingo" id="todays_pending_ads<?php echo $adwit_teams_id; ?>"></div>
    								<div class="font-grey-mint font-sm">Pending Ads</div>
    							</div>
    						
    						    <div class="col-md-2 col-sm-4 col-xs-4">
    								<div class="uppercase font-hg font-black-flamingo" id="todays_sent_ads<?php echo $adwit_teams_id; ?>"></div>
    								<div class="font-grey-mint font-sm">Sent Ads</div>
    							</div>
    							
    							<div class="col-md-2 col-sm-4 col-xs-4">
    								<div class="uppercase font-hg font-black-flamingo" id="question_ads<?php echo $adwit_teams_id; ?>"></div>
    								<div class="font-grey-mint font-sm">Question</div>
    							</div>
    						</div>
    						<!-- Category wise Ad count -->
						    <div class="row col-md-offset-1 list-separated" id="category_wise_count_div<?php echo $adwit_teams_id; ?>"> </div>
					      
					       <!-- Yesterdays Status wise Ad count -->
					       <p style="padding:inherit;"><b>Yesterday's Ad Count</b></p>
					        <div class="row col-md-offset-1 list-separated" id="yst_status_wise_count_div<?php echo $adwit_teams_id; ?>"> </div>
					</div>
				</div>    
			<?php } ?>
			</div>
	    </div>
    </div>

<?php $this->load->view('new_designer/foot')?>

<script>
    $(document).ready(function(){ 
        //todays order count
        <?php foreach($adwit_teams as $adwit_team){ $adwit_teams_id = $adwit_team['adwit_teams_id']; ?>
            $.get("<?php echo base_url().index_page().'new_designer/home/get_dashboard_ad_count/'.$adwit_teams_id;?>", function(data){
                var myObj = JSON.parse(data);
                //console.log(myObj.todays_total_ads_count+'-'+myObj.todays_pending_ads_count+'-'+myObj.todays_sent_ads+'-'+myObj.question_ads_count);
                $('#todays_total_ads<?php echo $adwit_teams_id; ?>').html(myObj.todays_total_ads_count);
                $('#todays_pending_ads<?php echo $adwit_teams_id; ?>').html(myObj.todays_pending_ads_count);
                $('#todays_sent_ads<?php echo $adwit_teams_id; ?>').html(myObj.todays_sent_ads_count);
                $('#question_ads<?php echo $adwit_teams_id; ?>').html(myObj.question_ads_count);
                
                $('#yesterdays_total_ads<?php echo $adwit_teams_id; ?>').html(myObj.yesterdays_total_ads_count);
                $('#yesterdays_pending_ads<?php echo $adwit_teams_id; ?>').html(myObj.yesterdays_pending_ads_count);
                $('#yesterdays_sent_ads<?php echo $adwit_teams_id; ?>').html(myObj.yesterdays_sent_ads_count);
                
                //console.log(myObj.category_wise_count_div);
                $('#category_wise_count_div<?php echo $adwit_teams_id; ?>').html(myObj.category_wise_count_div);
                
                $('#yst_status_wise_count_div<?php echo $adwit_teams_id; ?>').html(myObj.yst_status_wise_count_div);
                
                $('#status_wise_count_div<?php echo $adwit_teams_id; ?>').html(myObj.status_wise_count_div);
                $('#team_total_count<?php echo $adwit_teams_id; ?>').html('<b> - '+myObj.total_count+'</b>');
                $('#loading<?php echo $adwit_teams_id; ?>').hide();
            });
        <?php } ?>
    });

</script>