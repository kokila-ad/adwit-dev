<?php $this->load->view('new_admin/header')?>
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
				<div class="col-sm-6">
					<div class="portlet light border padding-top-0">
						<div class="portlet light">
							<div class="portlet-title">
							<div class="col-md-3">
								<div class="caption">
									<span class="font-md font-grey-gallery bold">Today's Ads</span>
								</div>
								</div>
							</div>
						</div>
					
						<div class="row col-md-offset-2 list-separated">
							<div class="col-md-4 col-sm-4 col-xs-8">
								<div class="uppercase font-hg font-black-flamingo">
								    <a href="<?php echo base_url().index_page().'new_admin/home/todays_ad_details'; ?>" target="_blank"><?php echo $total_ads['total_Ads']; ?></a>
								</div>
								<div class="font-grey-mint font-sm">Total Ads</div>
							</div>
							<div class="col-md-4 col-sm-3 col-xs-6">
								<div class="uppercase font-hg  font-blue">
								    <a href="<?php echo base_url().index_page().'new_admin/home/pending_status'; ?>" target="_blank"><?php echo $pending_ads['pending_Ads']; ?></a>
								</div>
								<div class="font-grey-mint font-sm">Pending</div>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-8">
								<div class="uppercase font-hg font-green"><a href="<?php echo base_url().index_page().'new_admin/home/sent_status'; ?>" target="_blank"><?php echo $sent_ads['sent_Ads']; ?></a> </div>
								<div class="font-grey-mint font-sm">Sent</div>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-8">
								<div class="uppercase font-hg font-green"><a href="<?php echo base_url().index_page().'new_admin/home/question_status'; ?>" target="_blank"><?php echo $question_ads['question_Ads']; ?></a> </div>
								<div class="font-grey-mint font-sm">Question</div>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-8">
								<div class="uppercase font-hg font-green"><a href="#" target="_blank"><?php echo $cancel_ads['cancel_Ads']; ?></a> </div>
								<div class="font-grey-mint font-sm">Cancel</div>
							</div>
						</div>
						<?php //} ?>
						</br>
					<!-- Yesterdays Ad Counts -->
					<?php if(isset($yst_total_ads)){ ?>
    					<div id="yesterday_ads">
    						<div class="portlet light">
    							<div class="portlet-title">
    							<div class="col-md-6">
    								<div class="caption">
    									<span class="font-md font-grey-gallery bold">Yesterday's Ads</span>
    								</div>
    							</div>
    							</div>
    						</div>
    						<div class="row col-md-offset-2 list-separated">
        							<div class="col-md-4 col-sm-4 col-xs-8">
        								<div class="uppercase font-hg font-black-flamingo">
        								    <a href="<?php echo base_url().index_page().'new_admin/home/yesterdays_ad_details/all?from='.$yst_from_date_range.'&to='.$yst_to_date_range; ?>" target="_blank"><?php echo $yst_total_ads['total_Ads']; ?></a>
        								</div>
        								<div class="font-grey-mint font-sm">Total Ads</div>
        							</div>
        							<div class="col-md-4 col-sm-3 col-xs-6">
        								<div class="uppercase font-hg  font-blue">
        								    <a href="<?php echo base_url().index_page().'new_admin/home/yesterdays_ad_details/pending?from='.$yst_from_date_range.'&to='.$yst_to_date_range; ?>" target="_blank"><?php echo $yst_pending_ads['pending_Ads']; ?></a>
        								</div>
        								<div class="font-grey-mint font-sm">Pending</div>
        							</div>
        							<div class="col-md-4 col-sm-4 col-xs-8">
        								<div class="uppercase font-hg font-green"><a href="<?php echo base_url().index_page().'new_admin/home/yesterdays_ad_details/sent?from='.$yst_from_date_range.'&to='.$yst_to_date_range; ?>" target="_blank"><?php echo $yst_sent_ads['sent_Ads']; ?></a> </div>
        								<div class="font-grey-mint font-sm">Sent</div>
        							</div>
        					</div>
        					
    					</div>
						</br>
					<?php } ?>
					
					<!-- HelpDesk -->	
						<div class="portlet light">
						<div class="portlet-title ">
						<div class="row margin-bottom-15">
						
				           <div class="col-md-3 margin-left-15">
								<div class="caption">
									<span class="font-md font-grey-gallery bold">Helpdesk</span>
								</div>
							</div>
							<div class="col-md-3">
								<select name="help_desk" id="help_desk">
    								<option value="all">Select</option>
    								<?php foreach($adwit_teams as $hd_row){ ?>
    									<option  value = "<?php echo($hd_row['adwit_teams_id'])?>" <?php if(isset($hd_id) && $hd_id == $hd_row['adwit_teams_id']) echo 'selected';?> ><?php echo($hd_row['name']); ?></option>
    								<?php } ?>
								</select>
							</div>
						
						</div>
						</div>
						</div>
						
                           <div id="help_desk_count">
    						   <div class="row col-md-offset-2 list-separated" >
    							<div class="col-md-4 col-sm-4 col-xs-8">
    								<div id="hd_total_ad_count"></div>
    								<div class="font-grey-mint font-sm">Total Ads</div>
    							</div>
    							<div class="col-md-4 col-sm-3 col-xs-6">
    								<div id="hd_pending_ad_count"></div>
    								<div class="font-grey-mint font-sm">Pending</div>
    							</div>
    							<div class="col-md-4 col-sm-4 col-xs-8">
    								<div id="hd_sent_ad_count"></div>
    								<div class="font-grey-mint font-sm">Sent</div>
    							</div>
    						   </div>	
    						</div>
						
						</br>
			            </div>
				</div>
					
				<div class="col-sm-6">
				    <div class="border padding-top-0">
							<div class="portlet light">
								<div class="portlet-title">
								<div class="col-md-12">
									<div class="caption">
										<span class="font-md font-grey-gallery bold">Category - Pending Ads Count</span>
									</div>
									</div>
								</div>
							</div>
					    <div class="row col-md-offset-2 list-separated">
    					<?php 
    						//category wise pending ads counts
    						foreach($order_cat_count as $cat){ 
    						
    					?>
							<div class="col-md-2 col-sm-2 col-xs-4">
								<div class="uppercase font-hg font-black-flamingo">
								    <!--<a href="<?php echo base_url().index_page().'new_admin/home/todays_ad_details/'.$cat['category']; ?>" target="_blank">-->
								    <a href="<?php echo base_url().index_page().'new_admin/home/todays_ad_details?category='.$cat['category'].'&from='.$today_from_date_range.'&to='.$today_to_date_range; ?>" target="_blank">
								        <?php echo $cat['ad_count']; ?>
								    </a>
								</div>
								<div class="font-grey-mint font-sm"><?php echo $cat['category']; ?></div>
							</div>
							
					    <?php } ?>
					    </div>
				    </div>
				    <!--Status wise Ads Count -->
				    <div class="border padding-top-0">
							<div class="portlet light">
								<div class="portlet-title">
								<div class="col-md-12">
									<div class="caption">
										<span class="font-md font-grey-gallery bold">Status - Ads Count</span>
									</div>
									</div>
								</div>
							</div>
					    <div class="row col-md-offset-1 list-separated">
    					<?php 
    						foreach($order_status_count as $status){ 
    					?>
							<div class="col-md-2 col-sm-2 col-xs-6">
								<div class="uppercase font-hg font-black-flamingo">
								    <a href="<?php echo base_url().index_page().'new_admin/home/todays_ad_details?status='.$status['id'].'&from='.$today_from_date_range.'&to='.$today_to_date_range; ?>" target="_blank">
								        <?php echo $status['ad_count']; ?>
								    </a>
								</div>
								<div class="font-grey-mint font-sm"><?php echo $status['name']; ?></div>
							</div>
						<?php } ?>
					    </div>
				    </div>
				    
				    <!--Status wise Yst Ads Count -->
				    <?php if(isset($yst_order_status_count)){ ?>
				    <div class="border padding-top-0">
							<div class="portlet light">
								<div class="portlet-title">
								<div class="col-md-12">
									<div class="caption">
										<span class="font-md font-grey-gallery bold">Status - Yesterday's Ads Count</span>
									</div>
									</div>
								</div>
							</div>
					    <div class="row col-md-offset-1 list-separated">
    					<?php
    					    foreach($yst_order_status_count as $status){ 
    					?>
							<div class="col-md-2 col-sm-2 col-xs-6">
								<div class="uppercase font-hg font-black-flamingo">
								    <a href="<?php echo base_url().index_page().'new_admin/home/todays_ad_details?status='.$status['id'].'&from='.$yst_from_date_range.'&to='.$yst_to_date_range; ?>" target="_blank">
								        <?php echo $status['ad_count']; ?>
								    </a>
								</div>
								<div class="font-grey-mint font-sm"><?php echo $status['name']; ?></div>
							</div>
						<?php } ?>
					    </div>
				    </div>
				<?php } ?>
			    </div>
			 
			</div>
			<!----------------------------- Pagination Ads Section ---------------------------------->
		<?php if($this->session->userdata('aId') == '1'){ ?>
			<div class="row margin-top-15">
				<div class="col-sm-12">
					<div class="portlet light border padding-top-0">
						<div class="portlet light">
							<div class="portlet-title">
							<div class="col-md-3">
								<div class="caption">
									<span class="font-md font-grey-gallery bold">Pagination Ad Details</span>
								</div>
								</div>
							</div>
						</div>
					    <div class="row">
					       <div class="col-sm-6">
					           <div class="portlet light border padding-top-0">
            						<div class="portlet light">
            							<div class="portlet-title">
            							    <div class="col-md-3">
            								    <div class="caption">
            									    <span class="font-md font-grey-gallery bold">Today's Ads</span> <span class="font-md font-green loading">  Loading...</span>
            								    </div>
            								</div>
            							</div>
            						</div>
            						<div class="row col-md-offset-2 list-separated">
            							<div class="col-md-4 col-sm-4 col-xs-8">
            							    <a href="<?php echo base_url().index_page().'new_admin/home/todays_ad_details_pagination/total' ?>" target="_blank">
            								    <div class="uppercase font-hg font-black-flamingo" id="todays_total_ads"></div>
            								    <div class="font-grey-mint font-sm">Total Ads</div>
            								</a>
            							</div>
            							<div class="col-md-4 col-sm-3 col-xs-6">
            							    <a href="<?php echo base_url().index_page().'new_admin/home/todays_ad_details_pagination/pending' ?>" target="_blank">
            								    <div class="uppercase font-hg  font-blue" id="todays_pending_ads"></div>
            								    <div class="font-grey-mint font-sm">Pending</div>
            								</a>
            							</div>
            							<div class="col-md-4 col-sm-4 col-xs-8">
            							    <a href="<?php echo base_url().index_page().'new_admin/home/todays_ad_details_pagination/sent' ?>" target="_blank">
            								    <div class="uppercase font-hg font-green" id="todays_sent_ads"></div>
            								    <div class="font-grey-mint font-sm">Sent</div>
            								</a>
            							</div>
            							<div class="col-md-4 col-sm-4 col-xs-8">
            							    <a href="<?php echo base_url().index_page().'new_admin/home/todays_ad_details_pagination/question' ?>" target="_blank">
            								    <div class="uppercase font-hg font-green" id="question_ads"></div>
            								    <div class="font-grey-mint font-sm">Question</div>
            								</a>
            							</div>
            							<div class="col-md-4 col-sm-4 col-xs-8">
            							    <a href="<?php echo base_url().index_page().'new_admin/home/todays_ad_details_pagination/cancel' ?>" target="_blank">
            								    <div class="uppercase font-hg font-green" id="cancel_ads"></div>
            								    <div class="font-grey-mint font-sm">Cancel</div>
            								</a>
            							</div>
            						</div>
            					</div>
            				</div>
            				<div class="col-sm-6">
            					<!--Status wise Ads Count -->
            				    <div class="border padding-top-0">
            						<div class="portlet light">
        								<div class="portlet-title">
        								    <div class="col-md-12">
        									    <div class="caption">
        										    <span class="font-md font-grey-gallery bold">Status - Ads Count</span><span class="font-md font-green loading">  Loading...</span>
        									    </div>
        									</div>
        								</div>
        							</div>
        					        <div class="row col-md-offset-1 list-separated" id="status_wise_count_div">
                				    </div>
					            </div>
					        </div>
					    </div>
						<!--<div class="row">
						    <div class="col-sm-6">
						        <div id="yesterday_ads" class="border padding-top-0">
        						    <div class="portlet light">
    								    <div class="portlet-title">
    								        <div class="col-md-6">
    									        <div class="caption">
    										        <span class="font-md font-grey-gallery bold">Yesterday's Status - Ads Count</span><span class="font-md font-green loading">  Loading...</span>
    									        </div>
    									    </div>
    								    </div>
    							    </div>
    					            <div class="row col-md-offset-1 list-separated" id="yst_status_wise_count_div"></div>
    						        </br>
    					        </div>
    				        </div>
				        </div>-->
					</div>
				</div>
			</div>
		<?php } ?>
			<!----------------------------- END Pagination Ads Section ---------------------------------->
	    </div>
    </div>
 <!--<script>
            document
                .getElementById('target')
                .addEventListener('change', function () {
                    'use strict';
                    var vis = document.querySelector('.vis'),
                        target = document.getElementById(this.value);
                    if (vis !== null) {
                        vis.className = 'inv';
                    }
                    if (target !== null ) {
                        target.className = 'vis';
                    }
            });
</script>-->

<script>
    $(document).ready(function(){ 
        //Pagination todays order count
        $.get("<?php echo base_url().index_page().'new_admin/home/get_dashboard_pagination_ad_count';?>", function(data){
            var myObj = JSON.parse(data);
            //console.log(myObj.todays_total_ads_count+'-'+myObj.todays_pending_ads_count+'-'+myObj.todays_sent_ads+'-'+myObj.question_ads_count);
            $('#todays_total_ads').html(myObj.todays_total_ads_count);
            $('#todays_pending_ads').html(myObj.todays_pending_ads_count);
            $('#todays_sent_ads').html(myObj.todays_sent_ads_count);
            $('#question_ads').html(myObj.question_ads_count);
            $('#cancel_ads').html(myObj.cancel_ads_count);
            
            //$('#yesterdays_total_ads').html(myObj.yesterdays_total_ads_count);
            //$('#yesterdays_pending_ads').html(myObj.yesterdays_pending_ads_count);
           // $('#yesterdays_sent_ads').html(myObj.yesterdays_sent_ads_count);
            
            //console.log(myObj.category_wise_count_div);
            $('#category_wise_count_div').html(myObj.category_wise_count_div);
            
            $('#yst_status_wise_count_div').html(myObj.yst_status_wise_count_div);
            
            $('#status_wise_count_div').html(myObj.status_wise_count_div);
            $('.loading').hide();
        });
        
        //HelpDesk Wise adCount
        $('#help_desk_count').hide();
        $('#help_desk').on('change', function(){
            var adwit_teams_id = this.value; //alert( this.value );
            $('#help_desk_count').show();
            $('#hd_total_ad_count').html('Loading...');
            $('#hd_pending_ad_count').html('Loading...');
            $('#hd_sent_ad_count').html('Loading...');
           $.get("<?php echo base_url().index_page().'new_admin/home/teamwise_ad_volume_content/';?>"+adwit_teams_id, function(data){
                var myObj = JSON.parse(data);
                //console.log(myObj.todays_total_ads_count+'-'+myObj.todays_pending_ads_count+'-'+myObj.todays_sent_ads+'-'+myObj.question_ads_count);
                $('#hd_total_ad_count').html('<span class="uppercase font-hg font-black-flamingo">'+myObj.todays_total_ads_count+'<span>');
                $('#hd_pending_ad_count').html('<span class="uppercase font-hg font-blue">'+myObj.todays_pending_ads_count+'<span>');
                $('#hd_sent_ad_count').html('<span class="uppercase font-hg font-green">'+myObj.todays_sent_ads_count+'<span>');
                
            });
        });
        
    });
</script>

<?php $this->load->view('new_admin/footer')?>
