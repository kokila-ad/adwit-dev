<?php $this->load->view('new_client/header');?>
<style> 
	.action-img { max-width: 20px; height; 20px;}
	#heading .dropdown-menu { left:0 !important; right:450px !important; } 
	@media (max-width: 700px){#heading .dropdown-menu { right:250px !important; }}
	@media (max-width: 300px){#heading .dropdown-menu { right 0px !important; } }
	/**********Active In-Active checkbox**********/
	.onoff_btn input[type="checkbox"]{ display:none;}
	.onoff_btn span::before,.onoff_btn span::after { content: ''; position: absolute; top: 0; bottom: 0; margin: auto;}
	.onoff_btn span.checkbox {width:170px; height:26px; margin:0; background-color: #333333;}
	.onoff_btn span.checkbox:hover {cursor: pointer;}
	.onoff_btn span.checkbox::before {}
	.onoff_btn span.checkbox::after {padding-top:1px; left:3px; width:99px; height:20px; color:#000; text-align:center; content:'Team Orders'; background-color:#f5f5f5; transition:left .25s, background-color .25s;}
	.onoff_btn input[type="checkbox"]:checked + label span.checkbox::after {left:67px; background-color:#f5f5f5; content:'My Orders'; color: #000;}
	.display-block { display: block !important;}
	
    .btn.btn-xs, .btn-xs.search-submit {
        font-size: 13px !important;
        padding: 6px 10px !important;
    }
    
    table.table-bordered th:last-child, table.table-bordered td:last-child {
      border-right-width: 0;
      overflow:hidden;
    }
    
    
    
    @media (min-width: 1200px) {
      .container {
        width: 1200px;
      }
    }
    
    .col-sm-12{
    	
    	padding-left:5px;
    	padding-right:5px;
    }
    
    .btn{
        border-radius:5px;
    }
</style>
<script>
$(document).ready(function(){
	        $("#advancesearch").hide();
				/* $("#showoptional").click(function(){
					$("#optional").toggle();      
				 });*/
				 
				 $("#showadvancesearch").click(function(){
					$("#advancesearch").toggle();  
					$("#search").toggle();  		
				  });
				 
				 $("#showsearch").click(function(){
					$("#advancesearch").toggle();  
					$("#search").toggle();  		
				  });  
				
			 });
</script>
<div id="main">
<?php if($client[0]['pagedesign_ad'] == '1'){ ?>
	<section>
      <div class="container margin-top-20 center">                        
		 <a href="<?php echo base_url().index_page().'new_client/home/dashboard';?>" class="btn btn-sm btn-dark btn-outline btn-active margin-right-5">Ads</a>
		
		   <a href="<?php echo base_url().index_page().'new_client/home/page_new_dashboard';?>" class="btn btn-sm btn-dark btn-outline">Pagination</a>
	  </div>
   </section>
<?php } ?>

<section>
   <div class="container margin-top-20">
      <div class="row">
	 <?php //echo $this->uri->segment(3);  ?>
		  <div class="col-md-7" id="heading">
			<p>
			    <a class="btn btn-xs btn-dark margin-right-10"  href="<?php echo base_url().index_page().'new_client/home/dashboard';?>">Dashboard</a>
			   
    			<!-- preorder -->
    			<?php if($publication[0]['id']=='13' || $publication[0]['id']=='43' || $publication[0]['id']=='47'){ ?>
    			    <!-- text 
    			    <a class="btn btn-xs btn-dark btn-outline margin-right-10"  href="<?php echo base_url().index_page().'new_client/home/preorders'; ?>">
    			        Booked-<?php if(isset($preorder_count)) echo $preorder_count; ?></a>-->
    			    <!-- xml -->
    			    <a class="btn btn-xs btn-dark btn-outline margin-right-10"  href="<?php echo base_url().index_page().'new_client/home/list_preorders_desert_shoppers'; ?>">
    			        Pre-order</a>
    			<?php } ?>
    			
    			<!-- xmlorder for Waukesha Freeman publication-->
    			<?php if($publication[0]['id']=='13' || $publication[0]['id']=='580'){ ?>
    			        <a class="btn btn-xs btn-dark btn-outline margin-right-10"  href="<?php echo base_url().index_page().'new_client/home/list_preorders_waukesha'; ?>">
    			        Pre-order</a>
    			<?php } ?>
    			
    			<!-- map orders link-->
    			<?php if($publication[0]['id']=='13' || $publication[0]['id']=='190'){ ?>
    			<a class="btn btn-xs btn-dark btn-outline margin-right-10"  href="<?php echo base_url().index_page().'new_client/home/maporders'; ?>">
    			        MAP Orders</a>
    			<?php } ?>
			
			</p>
				
				<!--<?php  echo '<h4 style="color:#900;">'.$this->session->flashdata('message').'</h4>';  ?>-->
					<?php if ($this->session->flashdata('message')) {
                                    echo '<script>
                                        $(document).ready(function() {
                                            $("#dashboardModal").modal("show");
                                        });
                                    </script>';
                                } ?>
				<?php if($client[0]['team_orders'] == '1' || $client[0]['team_orders'] == '0' ) { ?>
					<div class="dropdown margin-bottom-10">
						<span class="cursor-pointer dropdown margin-right-10" data-toggle="dropdown" aria-expanded="true">
							<a id="filter1"><i class="fa fa-filter xlarge"></i></a>
						</span>														
						<div class="dropdown-menu dropdown-menu1 file_li padding-10">  							 
							<form method="post" action="<?php echo base_url().index_page().'new_client/home/dashboard/0';?>">
								<div>
								<label><input type="radio" name="orders" value='0' id="active" <?php if($client[0]['team_orders'] == '0' || $client[0]['team_orders'] == '2') { echo 'checked'; } ?>> My Orders</label><br/>
								<label><input type="radio" name="orders" value='1' id="active" <?php if($client[0]['team_orders'] == '1') { echo 'checked'; } ?> > Team Orders</label>
								</div>
								<button type="submit" name="order_display_submit" class="btn btn-primary padding-5 small margin-top-5">Enable</button>
							</form>
						</div>
					</div>
				<?php } ?>
		  </div>
				 <div class="col-md-5 col-sm-12 col-xs-12 ">
				     
				<form method="get" action="<?php echo base_url().index_page().'new_client/home/search_order';?>"> 
					<div id="search">
					<div class="row">
						<div class="col-md-8 col-sm-8 col-xs-8 padding-right-0">
						  <input type="text" name="input" class="form-control border-blue input-sm" title="" placeholder="Enter Order ID, Job ID or Advertiser Name" <?php if(isset($keyword) && !empty($keyword))echo"value='$keyword'"; ?>>
						</div>
						 <div class="col-md-4 col-sm-4 col-xs-4 padding-left-0">
						<button type="submit" name="search" class="btn btn-blue btn-sm btn-block margin-right-15">Search</button>
						</div>
					 </div>	
					  <p class="text-right margin-top-5"><a class="cursor-pointer text-blue" id="showadvancesearch">advanced search</a></p>
					 </div>
					 
					 <div class="row margin-0" id="advancesearch">
						<div class="col-md-12 col-sm-12 col-xs-12 background-color-blue padding-bottom-15">
						<!-- publish date -->
						  <div class="row">
							  <div class="col-md-6 col-sm-6 col-xs-12 background-color-blue">
								<p class="padding-top-10 margin-bottom-5">Publish Date</p>
								<div class="input-group date date-picker margin-bottom-15" data-date-format="yyyy-mm-dd">
									<input type="text" name="from_dt" class="form-control input-sm" placeholder="From" <?php if(isset($from))echo"value='$from'"; ?>   >
									<span class="input-group-btn">
									<button class="btn btn-blue btn-sm" type="button"><i class="fa fa-calendar"></i></button>
									</span>
								</div>
							  </div>
							  <div class="col-md-6 col-sm-6 col-xs-12 background-color-blue">
								<p class="padding-top-10 margin-bottom-5">&nbsp;</p>
								<div class="input-group date date-picker margin-bottom-15" data-date-format="yyyy-mm-dd">
									<input type="text" name="to_dt" class="form-control input-sm" placeholder="To" <?php if(isset($to))echo"value='$to'"; ?>   >
									<span class="input-group-btn">
									<button class="btn btn-blue btn-sm" type="button"><i class="fa fa-calendar"></i></button>
									</span>
								</div>
							  </div>	
						   </div>
						<!-- Adrep list for teamorders enabled -->  
						   <div class="row">
						   <?php if($client[0]['team_orders']=='1'){ ?>
						      <div class="col-md-6 col-sm-6 col-xs-6 background-color-blue">
									<p class="padding-top-10 margin-bottom-5">Ad Rep</p>
									<select class="form-control input-sm" name="team_adrep_id">
										<option value="">All</option>
										<?php 
										$team_adrep_list = $this->db->get_where('adreps', array('publication_id' => $client[0]['publication_id'], 'is_active' => '1'))->result_array();
										
										foreach($team_adrep_list as $row) { ?>
										<option value="<?php echo $row['id'];?>" <?php if(isset($team_adrep_id) && $row['id'] == $team_adrep_id)echo"selected='selected'"; ?>>
											<?php echo $row['first_name'].' '.$row['last_name'];?>
										</option>
										<?php } ?>
										
									</select>
								</div>
						   <?php } ?>
						<!-- pub_project enable_project enabled -->
						   <?php 
								if($publication[0]['enable_project']=='1'){ 
										$pub_project = $this->db->get_where('pub_project',array('pub_id' => $publication[0]['id']))->result_array(); 
							?>
							   <div class="col-md-6 col-sm-6 col-xs-6 background-color-blue">
									<p class="padding-top-10 margin-bottom-5">Publication</p>
									<select class="form-control input-sm" name="project_id">
										<option value="">All</option>
										<?php foreach($pub_project as $row) { ?>
										<option value="<?php echo $row['id'];?>" <?php if(isset($project_id) && $row['id'] == $project_id)echo"selected='selected'"; ?>>
											<?php echo $row['name'];?>
										</option>
										<?php } ?>
										
									</select>
								</div>
							<?php } ?>
							<!-- Print OR web adtype -->
								<div class="col-md-6 col-sm-6 col-xs-6 background-color-blue">
									<p class="padding-top-10 margin-bottom-5">Ad Type</p>
									<select class="form-control input-sm" name="ad_type">
										<option value="">All</option>
										<option value="2" <?php if(isset($ad_type) && $ad_type == '2')echo"selected='selected'"; ?>>Print</option>
										<option value="1" <?php if(isset($ad_type) && $ad_type == '1')echo"selected='selected'"; ?>>Online</option>
									</select>
								</div>
							<!-- status -->	
								<div class="col-md-6 col-sm-6 col-xs-12 background-color-blue">
									<p class="padding-top-10 margin-bottom-5">Status</p>
									<select class="form-control input-sm" name="status">
										<option value="">All</option>
										<?php 
										if($client[0]['new_ui'] == '4'){
											$orderStatus = $this->db->get('order_status')->result_array();
										}else{
											$orderStatus = $this->db->get_where('order_status', array('id !='=>'0'))->result_array();
										}
										foreach($orderStatus as $row) { ?>
										<option value="<?php echo $row['id'];?>" <?php if(isset($status) && $row['id'] == $status)echo"selected='selected'"; ?>>
											<?php echo $row['name'];?>
										</option>
										<?php } ?>
										
									</select>
								 </div>
							</div>
						   <div class="row">
						       <div class="col-md-6 col-sm-6 col-xs-6 background-color-blue">
						       	<button type="submit" name="adv_search" class="btn btn-blue btn-sm margin-top-35 ">  <span>SUBMIT</span> </button>
						       	</div>

							  <div class="col-md-6 col-sm-6 col-xs-6 background-color-blue">

								<span class="float-right margin-top-55 text-white"><a class="cursor-pointer text-blue" id="showsearch">&laquo Collapse</a></span>
							  </div>	
						   </div>					   
						</div>
					 </div>	
				</form>
				
			
			</div>	
		  </div>

<?php 
        if(empty($pre_next)){ 
			$this->load->view('new_client/dashboard_order_table'); 
		}else{
			 $this->load->view('new_client/order_search_display');
		} 
?>

		  
	 </div>
  </div>
</section>
</div>
<style>
    .modal-backdrop {
    display:none;
}

</style>
<!-- Modal -->
<div class="modal" id="dashboardModal" tabindex="-1"  role="dialog" aria-labelledby="confirmationModalTitle" >
 <div class="modal-dialog modal-dialog-centered" role="document" style="width:700px;">
    <div class="modal-content" style="width:85%">
      <div class="modal-header" style="border-bottom: 0 !important;background-color:#333 !important;">
        <h5 class="modal-title portlet-title margin-top-10" id="dashboardModal" style="margin-top: 0px !important; padding:10px !important;"><center><b>Alert</b></center></h5>
      </div>
      <div class="modal-body" style="padding: 15px 16px;">
          <h4 style="color:#900;"><?php echo $this->session->flashdata('message')?></h4>
      </div>
      <div class="modal-footer" style="background-color:#fff !important;">
        <button type="button" class="btn btn-warning" data-dismiss="modal" >Close</button>
      </div>
    </div>
  </div>
</div>

<?php $this->load->view('new_client/privacy_footer');?>