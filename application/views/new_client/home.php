<?php $this->load->view('new_client/header');?>


<div id="main">

<section>
    <div class="container margin-top-80">  
        <form method="get" action="<?php echo base_url().index_page().'new_client/home/search_order';?>">
			<div class="row margin-0 border ">  		 
				<div class="col-md-6 col-sm-12 col-xs-12 padding-15 padding-left-0 border-right"> 
					<p class="margin-top-10" style="text-align: center;">No new notification</p>
				</div> 		 
		        <?php if($client[0]['pagedesign_ad']=='1' && $client[0]['print_ad']=='0' && $client[0]['online_ad']=='0'){ ?>
		        <?php }else{ ?>
				<div class="col-md-6 col-sm-12 col-xs-12 padding-15 padding-right-0">
					<div id="search">
						<div class="row">
							<div class="col-md-8 col-sm-8 col-xs-8 padding-right-0">
								 <input type="text" name="input" class="form-control input-sm border-blue" title="" placeholder="Enter Order ID, Job ID or Advertiser Name">
							</div>
							<div class="col-md-4 col-sm-4 col-xs-4 padding-left-0">
								<button type="submit" name="search" class="btn btn-blue btn-sm btn-block margin-right-15">Search</button>
							</div>
						</div>	
					</div>
				</div>
				<?php } ?>		 
			</div>	 
		</form>
	 </div>
</section>

</div>


<?php if($this->session->userdata('ncId')=='36'){ $this->load->view('new_client/privacy_footer'); }else{ $this->load->view('new_client/footer'); } ?>