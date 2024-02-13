<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('new_client/header') ?>
<div id="main">
<section>
      <div class="container margin-top-40 center">                        
		 <a href="<?php echo base_url().index_page().'new_client/home/dashboard';?>" class="btn btn-sm btn-dark btn-outline margin-right-5">Ads</a>
		
		   <a href="<?php echo base_url().index_page().'new_client/home/page_dashboard';?>" class="btn btn-sm btn-dark btn-outline btn-active">Pagination</a>
	  </div>
</section>

<section>
    <div class="container margin-top-50"> 
		 <!-- <form method="post" action=""> -->
				<div class="row">  		 
					<div class="col-md-7">
					</div>
					  <div class="col-md-5 col-sm-12 col-xs-12">
					   		<form method="get"> 
								<div id="search">
									<div class="row">
										<div class="col-md-8 col-sm-8 col-xs-8 padding-right-0">
							  				<input type="text" name="input" class="form-control border-blue input-sm" title="" placeholder="Search Pagination ID, Publication / Edition Name">
										</div>
							 			<div class="col-md-4 col-sm-4 col-xs-4 padding-left-0">
											<button type="submit" name="search" class="btn btn-blue btn-sm btn-block margin-right-15">Search</button>
										</div>
						 			</div>	
						  		<!--	<p class="text-right margin-top-5 margin-0" >
						  				<a class="cursor-pointer text-blue" id="showadvancesearch">advanced search</a>
						  			</p>-->
						 		</div>
						 		<div class="row margin-0" id="advancesearch" style="display: none;">
									<div class="col-md-12 col-sm-12 col-xs-12 background-color-blue padding-bottom-15">
							  			<p class="padding-top-10 margin-bottom-5">Search Keywords</p>
							 		 	<input type="text" name="keyword" value="<?php if(isset($keyword))echo $keyword; ?>" class="form-control input-sm" title="" placeholder="Search Pagination ID, Publication / Edition Name">
										<div class="row">
								  			<div class="col-md-6 col-sm-6 col-xs-12 background-color-blue">
												<p class="padding-top-10 margin-bottom-5">From</p>
												<div class="input-group date date-picker margin-bottom-15" data-date-format="dd-mm-yyyy">
													<input type="text" name="from_dt" value="<?php if(isset($from))echo $from; ?>" class="form-control input-sm" readonly="">
													<span class="input-group-btn">
														<button class="btn btn-blue btn-sm" type="button"><i class="fa fa-calendar"></i></button>
													</span>
												</div>
								  			</div>
								  			<div class="col-md-6 col-sm-6 col-xs-12 background-color-blue">
												<p class="padding-top-10 margin-bottom-5">To</p>
												<div class="input-group date date-picker margin-bottom-15" data-date-format="dd-mm-yyyy">
													<input type="text" name="to_dt" value="<?php if(isset($to))echo $to; ?>" class="form-control input-sm" readonly="">
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
													<option value="All" <?php if(isset($status) && $status == 'All')echo "selected"; ?>>All</option>
													<?php 
														$status_lists = $this->db->get('page_design_status')->result_array();
														foreach($status_lists as $status_list) { ?>
															<option value="<?php echo $status_list['id'];?>" <?php if(isset($status) && $status == $status_list['id'])echo "selected"; ?>><?php echo $status_list['name'];?></option>
													<?php } ?>
												</select>
								  			</div>
								  			<div class="col-md-6 col-sm-6 col-xs-12 background-color-blue">
												<button type="submit" name="adv_search" class="btn btn-blue btn-sm margin-top-35 ">  <span>Submit</span> </button>
												<span class="float-right margin-top-55 text-white"><a class="cursor-pointer text-blue" id="showsearch">« back</a></span>
								  			</div>	
							   			</div>					   
									</div>
						 		</div>
							</form>	 
					 	</div>					 
					</div>	  
		 <!-- </form> -->
	 </div>
</section>
<?php echo $this->session->flashdata('item');?> 
<?php  echo '<h4 style="color:#900;">'.$this->session->flashdata('message').'</h4>';  ?>
<section>
    <div class="container"> 
		<div class="row">	 			  
			  <div class="col-md-12 margin-top-20">
				 <div class="table-responsive border padding-15">     
					<table class="table table-striped table-bordered table-hover" id="example11">
						<thead>
							<tr>
								<td>Order Date</td>
								<td>Pagination ID</td>
								<td>Publication / Edition Name</td>
								<td>Publish Date</td>
								<td>No. of Pages</td>
								<td>Status</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
						   </tr>  									
						</thead>
						<tbody>	
						<?php
						if(isset($all[0]['id'])){
							foreach ($all as $value) 
							{
								$status_name = $this->db->get_where('page_design_status',array('id' => $value['status']))->row_array();
								$rev_page_order = $this->db->query("SELECT * FROM `page_revision` WHERE `pd_id`='".$value['id']."' AND `status`!='0' ORDER BY `id` DESC LIMIT 1;")->row_array();
								$pdf_path = 'none';
								if (isset($rev_page_order['id'])){
									$rev_status_id=$rev_page_order['status'];
									$rev_order_status = $this->db->get_where('page_rev_status',array('id' => $rev_status_id))->row_array();
									$page_design_status = $rev_order_status['name'];
									
									if($rev_page_order['pdf_path']!=NULL){ 
										$order_status = 'Proof Ready';
										$path = 'page_pdf/'.$value['id'].'/'.$rev_page_order['pdf_path'];
										if(file_exists($path)){ 
											$pdf_path = $path; 
										}
									}
								}else{
									$rev_status_id=$value['status'];
									$page_design_status = $status_name['name'];
									
									if($value['pdf']!=NULL){ 
										$order_status = 'Proof Ready';
										$path = 'page_pdf/'.$value['id'].'/'.$value['pdf'];
										if(file_exists($path)){ 
											$pdf_path = $path; 
										}
									}
								}
								//$status_name= $this->db->query("SELECT name FROM `page_design_status` WHERE page_design_status.id ='".$value['status']."';")->row_array();
								?>
								<tr> 
								<!-- Order Date -->
									<td><?php  $date = strtotime($value['created_on']); echo date('M d, Y', $date);?></td> 
								<!-- Pagination ID -->
							   		<td><a href="<?php echo base_url().index_page()."new_client/home/page_ads_details".'/'.$value['id'] ?>"><?php echo $value['id'];?></a></td>
							   	<!-- Publication / Edition Name -->
							   		<td><?php echo $value['unique_job_name'];?></td>
							   	<!-- Publish Date -->
							   		<td><?php  $date = strtotime($value['publish_date']); echo date('M d, Y', $date);?></td>
							   	<!-- No. of pages -->
							   		<td>
							   			<!--<a href="<?php echo base_url().index_page()."new_client/home/no_of_pages".'/'.$value['id'];?>">	<?php echo $value['No_of_pages'];?>	</a>-->
							   			<?php echo $value['No_of_pages'];?>
							   		</td>
							   	<!-- Status -->
							   		<td>
							   			<?php 
										if($value['status'] == '0'){
											 $page_info = $this->db->query("SELECT * FROM `pages` WHERE pages.pd_id = '".$value['id']."'")->result_array();
										?>
											<a href="<?php echo base_url().index_page()."new_client/home/page_order_view".'/'.$value['id'].'/'.$page_info[0]['id'];?>">
										<?php echo $status_name['name']; ?>
											</a>
										<?php	
										}else{
											echo $page_design_status;
										}
										?>
							   		</td>
								<!-- Revision -->	
							   		<td class="center width-30">
							   		<?php 
							   			if ($value['status'] == '5' && !isset($rev_page_order['id'])){
									?>
							   			<a href="<?php echo base_url().index_page()."new_client/home/page_revision".'/'.$value['id'];?>" data-toggle="tooltip" data-original-title="Revision">
							   				<img class="action-img" src="<?php echo base_url(); ?>assets/new_client/img/revision.png">
							   			</a>
							   		<?php }elseif(isset($rev_page_order['id']) && $rev_page_order['status'] == '3'){ ?>
										<a href="<?php echo base_url().index_page()."new_client/home/page_revision".'/'.$value['id'];?>" data-toggle="tooltip" data-original-title="Revision">
							   				<img class="action-img" src="<?php echo base_url(); ?>assets/new_client/img/revision.png">
							   			</a>
									<?php }else{ echo''; } ?>
							   		</td>
								<!-- View Order -->	
							   		<td class="center width-30">
									<?php if($value['status'] != '0'){ ?>
							   			<a href="<?php echo base_url().index_page()."new_client/home/view_pages".'/'.$value['id'];?>" data-toggle="tooltip" data-original-title="View">
							   				<img class="action-img" src="<?php echo base_url(); ?>assets/new_client/img/order_view.png">
							   			</a>
									<?php } ?>
							   		</td>
								<!-- Additional Attachment -->	
							   		<td class="center width-30">
							   			<?php 
										if($value['status'] != '0'){
							   				$pid= $this->db->query("SELECT * FROM `pages` WHERE pages.pd_id ='".$value['id']."';")->row_array();?>
							   			<a href="<?php echo base_url().index_page()."new_client/home/page_attachment".'/'.$pid['pd_id'];?>" data-toggle="tooltip" data-original-title="attachment">
							   				<img class="action-img"  src="<?php echo base_url(); ?>assets/new_client/img/attachment.png">
							   			</a>
										<?php } ?>
							   		</td>
								<!-- PDF -->	
							   		<td class="center width-30">
							   			<?php if($pdf_path != 'none'){ ?>
							   				<a target="_blank" href="<?php echo base_url().$pdf_path;?>" data-toggle="tooltip" data-original-title="pdf">
											<img class="action-img" src="<?php echo base_url(); ?>assets/new_client/img/pdf.png">
										</a>
							   		    <?php } ?>
							   		</td>
								<!-- Approve/Unapprove -->	
							   		<td id="td-approve-<?php echo $value['id']; ?>">
										<?php 
										if($pdf_path != 'none'){
											if($value['status'] == '7'){ 
											?>
												<button class="btn btn-block btn-xs padding-5 btn-danger btn_unapprove" data-pid="<?php echo $value['id']; ?>">Unapprove</button>
										<?php }else{ ?>
												<button class="btn btn-block btn-xs padding-5 btn-danger btn_approve" data-pid="<?php echo $value['id']; ?>">Approve</button>
										<?php 
											} 
										} 
										?>
							   		</td>
								</tr>
					<?php } } ?>
					   </tbody> 
					   </tbody>
					</table>
					
					<?php if(isset($all[0]['id'])){ ?>	
						<div class="row margin-top-10">  	
							<div class=" ">  	
								<div class="col-md-6 pull-right text-right prev-next-page">
									<?php $a = $offset + 1;
										if(count($all) == $rowsPerPage)
										{ 
											$next = $num + 1; $z = $offset + $rowsPerPage; 
										}else
										{ 
											$z = $order_count; 
										}
										if($num > 1)
										{ 
											$back = $num - 1; 
										}
										$key = "";
										if(isset($keyword))
										{ 
											$key = "?input=&keyword=".$keyword."&from_dt=".$from."&to_dt=".$to; 
										}
									?>
									<?php if(isset($back))
									{?>
										<a href="<?php echo base_url().index_page().'new_client/home/page_dashboard/'.$back.$key; ?>" title="Back">
											<button class="btn btn-dark btn-outline btn-sm margin-right-5"><i class="fa fa-arrow-left"></i></button>
										</a>
							 		<?php } ?>
									<?php if(isset($next))
									{ ?>
										<a href="<?php echo base_url().index_page().'new_client/home/page_dashboard/'.$next.$key; ?>" title="Next">
											<button class="btn btn-dark btn-outline btn-sm"><i class="fa fa-arrow-right"></i></button>
										</a>
					 				<?php } ?>
								</div>
								<div class="col-md-6 margin-bottom-10">
									<?php  echo "Showing ".$a." to ".$z." of ".$order_count." entries"; ?>
								</div>
							</div>
						</div>
				    <?php } ?>
			 					

		 					

						
				 </div>
			 </div>
	  	  </div>
        </div>
	</div>
</section>
</div>
<?php $this->load->view('new_client/privacy_footer') ?>
<script>
$(document).on('click', '.btn_approve', function(){
	var pd_id = $(this).data('pid');
	//alert('helloo '+pd_id);
	$.ajax({
 		 	url:"<?php echo base_url().index_page().'new_client/home/page_approve_unapprove/';?>"+pd_id,
 		 	data:"action=approve",
 		 	type:"POST",
			success: function(data){
				$("#td-approve-"+pd_id).html(data);
			}
 		 });
});

$(document).on('click', '.btn_unapprove', function(){
	var pd_id = $(this).data('pid');
	//alert('helloo '+pd_id);
	$.ajax({
 		 	url:"<?php echo base_url().index_page().'new_client/home/page_approve_unapprove/';?>"+pd_id,
 		 	data:"action=unapprove",
 		 	type:"POST",
			success: function(data){
				$("#td-approve-"+pd_id).html(data);
			}
 		 });
});
</script>