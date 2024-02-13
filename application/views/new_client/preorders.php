<?php $this->load->view('new_client/header');?>

<style>
    .btn.btn-xs, .btn-xs.search-submit {
        font-size: 13px !important;
        padding: 6px 10px !important;
    }
</style>

<div id="main">

<section>
    <div class="container margin-top-50"> 
		  <form method="post" action="<?php echo base_url().index_page().'new_client/home/order_search';?>"> 
					    <div class="row">  		 
    						 <div class="col-md-7">
    							<p>
        							<a class="btn btn-xs btn-dark btn-outline margin-right-10"  href="<?php echo base_url().index_page().'new_client/home/dashboard';?>">
        								    Dashboard</a>
        							<a class="btn btn-xs btn-dark margin-right-10"  href="#">
        								    Booked-<?php if(isset($preorder)) echo count($preorder); ?></a>
    							</p>
    						 </div>
					   
						   <div class="col-md-5 col-sm-12 col-xs-12">
							<div id="search">
							<div class="row">
								<div class="col-md-8 col-sm-8 col-xs-8 padding-right-0">
								  <input type="text" name="input" class="form-control border-blue input-sm" title="" placeholder="Type Job ID or Advertiser Name">
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
								  <input type="text" name="keyword" class="form-control input-sm" title="" placeholder="Search Job ID  or Advertiser Name">
								  
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
										<option value="">Select</option>
										<?php $status = $this->db->get('order_status')->result_array();
										foreach($status as $row) { ?>
										<option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
										<?php } ?>
										<option>All</option>
									</select>
								  </div>
							  <div class="col-md-6 col-sm-6 col-xs-12 background-color-blue">
								<button type="submit" name="adv_search" class="btn btn-blue btn-sm margin-top-35 ">  <span>SUBMIT</span> </button>
								<span class="float-right margin-top-55 text-white"><a class="cursor-pointer text-blue" id="showsearch">&laquo back</a></span>
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
								<td>S</td>
								<td>Unique Job ID</td>
								<td>Advertiser Name</td>
								<td>Publish Date</td>
								<td>Status</td>
								<td>Action</td>
						   </tr>  									
						</thead>
						<tbody>	
						 <?php foreach($preorder as $row){ ?>	
						   <tr>       
							   <td><?php echo $row['status']; ?></td>
								<td><?php echo $row['job_name']; ?></td>
								<td><?php echo $row['advertiser']; ?></td>
								<td><?php $date = strtotime($row['publish_date']); echo date('M d, Y', $date); ?></td>
								<td><?php echo "Booked"; ?></td>
							   <td>
							   <form name="myform" action="<?php echo base_url().index_page().'new_client/home/preorderform';?>" method='post'><input type="submit" name="Submit" value="Submit" class="btn btn-xs padding-5 btn-blue" /><input name="id" value="<?php echo $row['id'];?>" readonly style="display:none;"/></form>
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


<?php if($this->session->userdata('ncId')=='36'){ $this->load->view('new_client/privacy_footer'); }else{ $this->load->view('new_client/footer'); } ?>
