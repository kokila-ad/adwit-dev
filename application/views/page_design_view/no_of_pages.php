<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('new_client/header')//$this->load->view('page_design_view/header') ?>
<div id="main">
<section>
    <div class="container margin-top-50"> 
		  <form method="post" action=""> 
				<div class="row">  		 
					  <div class="col-md-7">
							<p>
								<a href="dashboard.html" class="text-blue">Dashboard</a>
									<span class="padding-horizontal-5"><i class="fa fa fa-angle-double-right"></i></span>
								<a href="dashboard_booked.html"><!-- <?php echo $order_id['id']; ?> -->Booked:1413</a>
							</p>
							<!-- <div class="dropdown margin-bottom-10">
								<span class="dropdown margin-right-10" data-toggle="dropdown" aria-expanded="true">
									<a id="filter"><i class="fa fa-filter xlarge"></i></a>
								</span>														
								<div class="dropdown-menu file_li padding-10">  							 
									<form>										
										<p class="margin-bottom-5">Switch your dashboard to:</p>
										<div class="onoff_btn" id="checkbox">
										  <input type="checkbox" name="group1" id="active" checked>
										  <label for="active"><span class="checkbox"></span></label>
										</div>
										<button class="btn btn-primary padding-5 small">Submit</button>
									</form>
								</div>
							</div> -->
					  </div>
				   
					   <div class="col-md-5 col-sm-12 col-xs-12">
						<div id="search">
						<div class="row">
							<div class="col-md-8 col-sm-8 col-xs-8 padding-right-0">
							  <input type="text" name="input" class="form-control border-blue input-sm" title="" placeholder="Type order ID, Job ID or Client Name">
							</div>
							 <div class="col-md-4 col-sm-4 col-xs-4 padding-left-0">
							<button type="submit" name="search" class="btn btn-blue btn-sm btn-block margin-right-15">Search</button>
							</div>
						 </div>	
						  <p class="text-right margin-top-5 margin-0" ><a href="#" class="text-blue" id="showadvancesearch">advanced search</a></p>
						 </div>
						 
						 <div class="row margin-0" id="advancesearch" style="display: none;">
							<div class="col-md-12 col-sm-12 col-xs-12 background-color-blue padding-bottom-15">
							  <p class="padding-top-10 margin-bottom-5">Search Keywords</p>
							  <input type="text" name="keyword" class="form-control input-sm" title="" placeholder="Search order ID, Job ID  or Client Name">
							  
							   <div class="row">
								  <div class="col-md-6 col-sm-6 col-xs-12 background-color-blue">
									<p class="padding-top-10 margin-bottom-5">From</p>
									<div class="input-group date date-picker margin-bottom-15" data-date-format="dd-mm-yyyy">
										<input type="text" name="from_dt" class="form-control input-sm" readonly="">
										<span class="input-group-btn">
										<button class="btn btn-blue btn-sm" type="button"><i class="fa fa-calendar"></i></button>
										</span>
									</div>
								  </div>
								  
								  <div class="col-md-6 col-sm-6 col-xs-12 background-color-blue">
									<p class="padding-top-10 margin-bottom-5">To</p>
									<div class="input-group date date-picker margin-bottom-15" data-date-format="dd-mm-yyyy">
										<input type="text" name="to_dt" class="form-control input-sm" readonly="">
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
										<option>All</option>
										<option value="1">Order Received</option>
										<option value="2">Order Accepted</option>
										<option value="3">IN Production</option>
										<option value="4">Quality Check</option>
										<option value="5">Proof Ready</option>
										<option value="6">Cancelled </option>
										<option value="7">Approved</option>
									</select>
								  </div>
								  <div class="col-md-6 col-sm-6 col-xs-12 background-color-blue">
									<button type="submit" name="adv_search" class="btn btn-blue btn-sm margin-top-35 ">  <span>Submit</span> </button>
									<span class="float-right margin-top-55 text-white"><a href="#" class="text-blue" id="showsearch">« back</a></span>
								  </div>	
							   </div>					   
							</div>
						 </div>			 
					 </div>					 
				</div>	 
		  </form> 
	 </div>
</section>
<section>
    <div class="container"> 
		<div class="row">	 			  
			  <div class="col-md-12 margin-top-20">
				 <div class="table-responsive border padding-15">     
					<table class="table table-striped table-bordered table-hover" id="example1">
						<thead>
							<tr>
								<td>ID</td>
								<td>Page Design ID</td>
								<td>Page Number</td>
								<td>Articles</td>
								<td>Ads</td>
								<td>Note Instructions</td>
								<td>Status</td>
						   </tr>  									
						</thead>
						<tbody>
						<?php foreach ($all as $value) {?>
							<tr>       
							   <td><?php echo $value['id'];?></td>
							   <td><?php echo $value['pd_id'];?></td>
							   <td><?php echo $value['page_no'];?></td>
							   <td><?php echo $value['articles'];?></td>
							   <td><?php echo $value['ads'];?></td>
							   <td><?php echo $value['note_instructions'];?></td>
							   <td><?php 
							   $status_name= $this->db->query("SELECT name FROM `page_status` WHERE page_status.id ='".$value['status']."';")->row_array();
							   echo $status_name['name'];?></td>
							</tr>
						<?php } ?>	
					   </tbody>         
					</table>
				 </div>
			 </div>
	  	  </div>
        </div>
	</div>
</section>
</div>
<?php $this->load->view('new_client/privacy_footer') //$this->load->view('page_design_view/footer') ?>