<?php $this->load->view('new_client/header'); ?>

 <div id="main">
   
  <section>
      <div class="container margin-top-20">         
        <div class="row">      		   	 
			          
			<div class="col-md-12">	
				<p class="margin-vertical-25 xlarge"> Notifications</p>  
			</div>
			<?php if(isset($notification_list)){
					foreach($notification_list as $list){
			?>
				<div class="col-md-6 col-sm-6 col-xs-12 margin-bottom-15">				
					<div class="row padding-vertical-15 margin-0 border">
						<div class="col-md-12 col-sm-12 col-xs-12 padding-bottom-10">
							<div class="float-left">
								<p class="xxlarge margin-0"><?php echo $list['headline']; ?></p>
									<!--<p><small>Adrep</small></p>-->
							</div>
							<div class="float-right">
								<p class="cursor-pointer text-right">
									<small><?php $date = strtotime($list['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?></small>
								</p>		
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 border-top padding-top-10">
							<p><?php echo $list['message']; ?></p>
						</div>
						<?php if($list['image']!='none'){ ?>
						<div class="col-md-12 col-sm-12 col-xs-12">
						<img class="profile-img" src="<?php echo base_url().$list['image']; ?>" alt="image">
						</div>
						<?php } ?>
					</div>
				</div>
			<?php } } ?>	
				
			
		</div><!-- /.row -->
      </div><!-- /.container -->
  </section><!-- /section -->
</div>

 
<?php if($this->session->userdata('ncId')=='36'){ $this->load->view('new_client/privacy_footer'); }else{ $this->load->view('new_client/footer'); } ?>