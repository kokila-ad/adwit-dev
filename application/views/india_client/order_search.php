
					   <form method="post" action="<?php echo base_url().index_page().'india_client/home/order_search';?>"> 
					    <div class="row margin-0 border ">  		 
						  <div class="col-md-6 col-sm-12 col-xs-12 padding-15 padding-left-0">  
							 <p class="center margin-top-25"> No New Notifications</p>		  
							 <div class="row margin-0 background-color-lightred border-red hide">
								<div class="col-md-11 col-sm-11 col-xs-11 background-color-lightred "> 
									<p class="padding-top-10">Question Received for 125636</p>
								</div> 	
								 <div class="col-md-1 col-sm-1 col-xs-1 center background-color-red padding-0"> 
									<p class=" padding-top-10 text-white"><a href="#"><i class="glyphicon glyphicon-check"></i></a></p>					
								</div> 					
							</div>	 
						 </div> 		 
						 
						   <div class="col-md-6 col-sm-12 col-xs-12 padding-15 padding-right-0  border-left">
							<div id="search">
							<div class="row">
								<div class="col-md-8 col-sm-8 col-xs-8 padding-right-0">
								  <input type="text" name="input" class="form-control input-sm border-blue" title="" placeholder="Type order ID, Job ID or Client Name">
								</div>
								 <div class="col-md-4 col-sm-4 col-xs-4 padding-left-0">
								<button type="submit" name="search" class="btn btn-blue btn-sm btn-block margin-right-15">Search</button>
								</div>
							 </div>	
							  <p class="text-right margin-top-5 margin-0"><a class="text-blue cursor-pointer " id="showadvancesearch">advanced search</a></p>
							  <?php $adrep_id = $this->session->userdata('icId');
									$adrep = $this->db->query("SELECT * FROM `adreps` WHERE `id` = $adrep_id")->result_array();
									$publication = $this->db->get_where('publications',array('id' => $adrep[0]['publication_id']))->result_array();
									if($publication[0]['enable_request'] == '1'){ ?>
									<p class="text-right margin-top-5 margin-0"><a href="<?php echo base_url().index_page().'india_client/home/dashboard/2';?>" class="text-blue" >view request list</a></p>
							 <?php } ?>
							 </div>
							 
							 <div class="row margin-0" id="advancesearch">
								<div class="col-md-12 col-sm-12 col-xs-12 background-color-blue padding-bottom-15">
								  <p class="padding-top-10 margin-bottom-5">Search Keywords</p>
								  <input type="text" name="keyword" class="form-control input-sm" title="" placeholder="Search order ID, Job ID  or Client Name">
								  
								   <div class="row">
									  <div class="col-md-6 col-sm-6 col-xs-12 background-color-blue">
										<p class="padding-top-10 margin-bottom-5">From</p>
										<div class="input-group date date-picker margin-bottom-15" data-date-format="dd-mm-yyyy">
											<input type="text" name="from_dt" class="form-control input-sm" readonly name="datepicker">
											<span class="input-group-btn">
											<button class="btn btn-blue btn-sm" type="button"><i class="fa fa-calendar"></i></button>
											</span>
										</div>
									  </div>
									  
									  <div class="col-md-6 col-sm-6 col-xs-12 background-color-blue">
										<p class="padding-top-10 margin-bottom-5">To</p>
										<div class="input-group date date-picker margin-bottom-15" data-date-format="dd-mm-yyyy">
											<input type="text" name="to_dt" class="form-control input-sm" readonly name="datepicker">
											<span class="input-group-btn">
											<button class="btn btn-blue btn-sm" type="button"><i class="fa fa-calendar"></i></button>
											</span>
										</div>
									  </div>
									  
								   </div>
									
								   <div class="row">
									  <div class="col-md-6 col-sm-6 col-xs-12 background-color-blue">
										<p class="padding-top-10 margin-bottom-5">Select Status</p>
										<select class="form-control input-sm" name="status">
										<option value="">Select</option>
										<option>All</option>
											<?php $status = $this->db->get('order_status')->result_array();
											foreach($status as $row)
											{
											?>
											<option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
											<?php } ?>
										</select>
									  </div>
									  <div class="col-md-6 col-sm-6 col-xs-12 background-color-blue">
										<button type="submit" name="adv_search" class="btn btn-blue btn-sm margin-top-35 ">  <span>SUBMIT</span> </button>
										<span class="float-right margin-top-55 text-white"><a href="#" class="text-blue" id="showsearch">&laquo back</a></span>
									  </div>	
								   </div>					   
								</div>
							 </div>			 
						 </div>
						 
						</div>	 
					  </form> 
