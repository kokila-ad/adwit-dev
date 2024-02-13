<?php $this->load->view("lite/head.php"); ?>
<?php $this->load->view("lite/header.php"); ?>
<style>.action-img { max-width: 20px; height; 20px;}</style>

<div id="main">
<section>
   <div class="container margin-top-50">
      <div class="row">
	
		  <div class="col-md-7">
				<p><a href="" class="text-blu">Dashboard</a></p>
				<?php  echo '<h4 style="color:#900;">'.$this->session->flashdata('message').'</h4>';  ?>
		  </div>
				<?php $client = $this->db->get_where('adreps',array('id'=>$this->session->userdata('lcId')))->result_array();?>
		  <div class="col-md-5 col-sm-12 col-xs-12 ">
			 <form method="post" action="<?php echo base_url().index_page().'lite/home/order_search';?>"> 
					<div id="search">
					<div class="row">
						<div class="col-md-8 col-sm-8 col-xs-8 padding-right-0">
						  <input type="text" name="input" class="form-control border-blue input-sm" title="" placeholder="Enter Order ID, Job ID or Advertiser Name">
						</div>
						 <div class="col-md-4 col-sm-4 col-xs-4 padding-left-0">
						<button type="submit" name="search" class="btn btn-blue btn-sm btn-block margin-right-15">Search</button>
						</div>
					 </div>	
					  <p class="text-right margin-top-5"><a class="cursor-pointer text-blue" id="showadvancesearch">advanced search</a></p>
					 </div>
					 
					 <div class="row margin-0" id="advancesearch">
						<div class="col-md-12 col-sm-12 col-xs-12 background-color-blue padding-bottom-15">
						  <p class="padding-top-10 margin-bottom-5">Search Keywords</p>
						  <input type="text" name="keyword" class="form-control input-sm" title="" placeholder="Enter Order ID, Job ID or Advertiser Name">
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
										<option value="All">All</option>
										<?php $status = $this->db->get('order_status')->result_array();
										foreach($status as $row) { ?>
										<option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
										<?php } ?>
										
									</select>
								  </div>
							  <div class="col-md-6 col-sm-6 col-xs-12 background-color-blue">
								<button type="submit" name="adv_search" class="btn btn-blue btn-sm margin-top-35 ">  <span>SUBMIT</span> </button>
								<span class="float-right margin-top-55 text-white"><a class="cursor-pointer text-blue" id="showsearch">&laquo back</a></span>
							  </div>	
						   </div>					   
						</div>
					 </div>	
					</form> 
		  </div>

	 
		  <div class="col-md-12 margin-top-20">
			 <div class="table-responsive border padding-15">     
				<table class="table table-striped table-bordered table-hover" id="example1">
					<thead>
						<tr>
							<td class="width-90">Date</td>
							<td>AdwitAds ID</td>
							<td class="width-120">Unique Job ID</td>
							<td class="width-120">Advertiser Name</td>
							<?php if($client[0]['team_orders']=='1'){ ?>
							<td class="width-90">Adrep Name</td>
							<?php } ?>
							<td class="width-90">Publish Date</td>
							<td class="width-90">Status</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
					   </tr>  									
					</thead>
					<?php if(isset($orders)) { ?>
					<tbody>
						<?php 
							foreach($orders as $row)
							{ 
								$order_type = 	$this->db->get_where('orders_type',array('id' => $row['order_type_id']))->row_array();
								$orderstatus = $this->db->get_where('order_status',array('id'=>$row['status']))->row_array();
								//$orders_rev = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `id`=(SELECT MAX(`id`) FROM `rev_sold_jobs` WHERE `order_id`='".$row['id']."')")->result_array();
								$orders_rev = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`='".$row['id']."' ORDER BY `id` DESC LIMIT 1;")->row_array();
								$pdf_path = 'none';
								if($orders_rev){ //if revision
									$status_id = $orders_rev['status'];
									$order_status = 'Revision Submitted';
									if($orders_rev['new_slug']!='none'){ $order_status = 'In Production'; }
									if($orders_rev['pdf_path']!='none'){ 
										$order_status = 'Proof Ready';
										$pdf_path = $orders_rev['pdf_path'];
										if(!file_exists($pdf_path)){ $pdf_path = $orders_rev['pdf_path'].'/'.$orders_rev['pdf_file']; }
									}
									if($orders_rev['approve']!='0'){ $order_status = 'Approved'; }
									//note sent revision
									$note = $this->db->get_where('note_sent',array('revision_id' => $orders_rev['id']))->row_array();
								}else{
									$status_id = $row['status'];
									$order_status = $orderstatus['name'];
									if($row['pdf']!='none'){ 
										$pdf_path = $row['pdf'];
										if(!file_exists($pdf_path)){ $pdf_path = 'pdf_uploads/'.$row['id'].'/'.$row['pdf']; }
									}
									if($row['crequest']!='0'){ $order_status = 'Cancel Requested'; }//csr order cancellation req
									//if($row['cancel']!='0'){ $order_status = 'Cancelled'; }//adrep order cancellation
									//note sent newad
									$note = $this->db->get_where('note_sent',array('order_id' => $row['id'], 'revision_id' => '0'))->row_array();
								}
						?> 
			<tr> 
<!-- Date -->		<td class="width-120"><?php $date = strtotime($row['created_on']); echo date('M d, Y', $date); ?></td>

<!-- order id -->	<td class="width-105">
						<?php if($row['status']!='1' || $row['status']!='2'){ ?>
						<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'lite/home/revision_details/'.$row['id'];?>'" style="cursor:pointer; text-decoration: underline;"><?php echo $row['id']; ?></a>
						<?php }else{ echo $row['id']; }  ?>
					</td>
<!-- Unique Job ID -->					
					<td class="width-120"><?php echo $row['job_no']; ?>
		  </td>
<!-- Client Name -->					
					<td class="width-90"><?php echo $row['advertiser_name']; ?></td>
<!-- Date Needed -->					
					<td class="width-120"><?php if($row['publish_date'] == '0000-00-00')
							{ echo ""; } else { echo date("M d, Y",strtotime($row['publish_date']));}?>
					</td>
<!-- Status -->
					<td class="width-90">
						<?php if($row['question']=='1'){ ?>
						<!-- Question sent for Answer -->
						<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'lite/home/new_ad_answer/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;">
						<!--<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'lite/home/order_action/QA/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;">
						--><button class="btn btn-block btn-xs padding-5 btn-grey">Question</button></a>
						<?php }elseif($orders_rev && $orders_rev['question']=='1'){ ?>
						<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'lite/home/rev_ad_answer/'.$orders_rev['id'];?>'" style="cursor:pointer; text-decoration: none;">
						<!--<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'lite/home/order_action/QA_rev/'.$orders_rev['id'];?>'" style="cursor:pointer; text-decoration: none;">
						--><button class="btn btn-block btn-xs padding-5 btn-grey" title="<?php echo $orders_rev['question']; ?>">Question</button></a>
						<?php } else{ ?>
						<?php echo $order_status; ?> 
						<?php } ?>
					</td>
<!-- Pickup -->

					<!--<td class="center width-30" title="Pickup">
						<?php if($status_id=='5' || $order_status == 'Approved') { if($publication[0]['design_team_id']=='8' || $publication[0]['id']=='43'){ ?>
							<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'lite/home/order_action/pickup/'.$row['job_no'];?>'" style="cursor:pointer; text-decoration: none;"><img class="action-img" src="<?php echo base_url(); ?>assets/lite/img/pickup.png"></a>
						<?php }else{ ?>
							<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'lite/home/order_action/pickup/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;"><img class="action-img" src="<?php echo base_url(); ?>assets/lite/img/pickup.png"></a>
						<?php } }else{ echo ""; }?>
					</td>-->
					<td class="center width-30" title="Pickup">
						<?php if($status_id=='5' || $status_id == '7' || $order_status == 'Proof Ready' || $order_status == 'Approved') {  ?>
							<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'lite/home/order_action/pickup/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;"><img class="action-img" src="<?php echo base_url(); ?>assets/lite/img/pickup.png"></a>
						<?php  }else { echo ""; }?>
					</td>
<!-- Revision -->						
					<td class="center width-30" title="Revision">
						<?php if($status_id=='5' && $order_status != 'Approved') { 
								$rev_days = $publication[0]['rev_days'];
								if($rev_days =='0'){ 
						?>
							<a href="<?php echo base_url().index_page().'lite/home/order_action/revision/'.$row['id'];?>" data-toggle="tooltip" title="Revision" >
							<img class="action-img" src="<?php echo base_url(); ?>assets/lite/img/revision.png"></a>
						
						<?php }else{ 
								$date = date("Y-m-d",strtotime($row['created_on']));
								$rev_allowed = date('Y-m-d', strtotime($date. '+'.$rev_days.' days'));
								$today = date('Y-m-d');
						
								if($today >= $date && $today <= $rev_allowed ){ 
						?>
							<a href="<?php echo base_url().index_page().'lite/home/order_action/revision/'.$row['id'];?>" data-toggle="tooltip" title="Revision" >
							<img class="action-img" src="<?php echo base_url(); ?>assets/lite/img/revision.png"></a>
						
							
						<?php } } } ?>
					</td>
<!-- View -->	
					<td class="center width-30" title="View">
						<a href="<?php echo base_url().index_page().'lite/home/order_action/view/'.$row['id'];?>" data-toggle="tooltip" title="View" >
						<img class="action-img" src="<?php echo base_url(); ?>assets/lite/img/order_view.png"></a>
					</td>
<!-- Attachments -->						
					<td class="center width-30">
					<?php if($status_id=='1' || $status_id=='2' || $status_id=='3') {?>
							<a href="<?php echo base_url().index_page().'lite/home/order_action/'.'attachments'.'/'.$row['id'];?>" data-toggle="tooltip" title="Attachments" >
							<img class="action-img" src="<?php echo base_url(); ?>assets/lite/img/attachment.png"></a>
						<?php }else{ echo""; } ?>
					</td>
					<!--<td class="center"><a class="btn btn-block btn-xs padding-5 btn-success">Approve</a></td>-->
<!-- PDF -->
					<td class="center width-30">
						<?php if($pdf_path != 'none' && file_exists($pdf_path)){ ?>
						<a href="<?php echo base_url().$pdf_path;?>" data-toggle="tooltip" title="<?php if(isset($note['id'])){ echo $note['note']; }else{ echo"PDF"; } ?>" data-placement="top" target="_blank" style="cursor:pointer; text-decoration: none;">
						<img class="action-img" src="<?php echo base_url(); ?>assets/lite/img/pdf.png"></a>
						<?php  }else{ echo ''; }?>
					</td>
<!-- Actions -->							
						<?php if($pdf_path != 'none'){ ?>
		<!-- Approve Unapprove -->
							<?php if($row['status'] == '7' || $order_status == 'Approved'){ ?>
								<td>
									<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'lite/home/unapprove_order/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;">
									<button class="btn btn-block btn-xs padding-5 btn-danger">Unapprove</button></a>
								</td> 
							<?php }else{ ?>
								<td title="Job Approval">
									<a href="<?php echo base_url().index_page().'lite/home/jRate/'.$row['id'] ;?>" 
										onclick="javascript:void window.open('<?php echo base_url().index_page().'lite/home/jRate/'.$row['id'];?>','1432728298066','width=515,height=228,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=50,top=20');return false;">
									<!--<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'lite/home/jRate/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;">-->
									<button class="btn btn-block btn-xs padding-5 btn-success">Approve</button>
									</a>
								</td>
							<?php } ?>
		<!-- cancel -->
					<?php }elseif($row['cancel'] != '0'){
			//Resubmit 
							if($publication[0]['design_team_id']=='8' || $publication[0]['id']=='43'){ ?>
								<td><a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'lite/home/order_action/pickup/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;"><button class="btn btn-block btn-xs padding-5 btn-blue" >Resubmit</button></a></td>
							<?php }else{ ?>
								<td><a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'lite/home/order_action/pickup/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;"><button class="btn btn-block btn-xs padding-5 btn-blue" >Resubmit</button></a></td>
							<?php }	?>
							
					<?php }elseif($order_status == 'Cancel Requested'){ ?>
							<td style="cursor:pointer;">
							<form method="post" action="<?php echo base_url().index_page().'lite/home/order_cancel/'.$row['id'];?>">
			<!--cancel req accept -->
								<button type="submit" name="remove" id="remove" class="btn btn-block btn-xs padding-5 btn-grey" onclick="return confirm('Are you sure you want to accept order cancellation ?');">Accept</button>
							</form>	 
			<!--cancel req reject -->
								<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'lite/home/reject_v2/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;"><button class="btn btn-block btn-xs padding-5 btn-grey" >Reject</button></a>
							</td>
					<?php }elseif(!$orders_rev && $row['status'] != '5'){ ?>
			<!--cancel button -->
							<td title="Job Cancel">
								<form method="post" action="<?php echo base_url().index_page().'lite/home/order_cancel/'.$row['id'];?>">
									<button type="submit" name="remove" id="remove" class="btn btn-block btn-xs padding-5 btn-grey" onclick="return confirm('Are you sure you want to cancel ?');">Cancel</button>
								</form>
							</td>
					<?php }else{ echo'<td></td>'; } ?>
				
					</tr>
				<?php } ?>
					 
 
				   </tbody>  
					<?php } ?>
				
				<?php if(isset($tl_orders)) { ?>
					<tbody>
						<?php 
							foreach($tl_orders as $row)
							{ 
								$order_type = 	$this->db->get_where('orders_type',array('id' => $row['order_type_id']))->row_array();
								$orderstatus = $this->db->get_where('order_status',array('id'=>$row['status']))->row_array();
								//$orders_rev = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `id`=(SELECT MAX(`id`) FROM `rev_sold_jobs` WHERE `order_id`='".$row['id']."')")->result_array();
								$orders_rev = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`='".$row['id']."' ORDER BY `id` DESC LIMIT 1;")->row_array();
								$pdf_path = 'none';
								if($orders_rev){ //if revision
									$status_id = $orders_rev['status'];
									$order_status = 'Revision Submitted';
									if($orders_rev['new_slug']!='none'){ $order_status = 'In Production'; }
									if($orders_rev['pdf_path']!='none'){ 
										$order_status = 'Proof Ready';
										$pdf_path = $orders_rev['pdf_path'];
										if(!file_exists($pdf_path)){ $pdf_path = $orders_rev['pdf_path'].'/'.$orders_rev['pdf_file']; }
									}
									if($orders_rev['approve']!='0'){ $order_status = 'Approved'; }
									//note sent revision
									$note = $this->db->get_where('note_sent',array('revision_id' => $orders_rev['id']))->row_array();
								}else{
									$status_id = $row['status'];
									$order_status = $orderstatus['name'];
									if($row['pdf']!='none'){ 
										$pdf_path = $row['pdf'];
										if(!file_exists($pdf_path)){ $pdf_path = 'pdf_uploads/'.$row['id'].'/'.$row['pdf']; }
									}
									if($row['crequest']!='0'){ $order_status = 'Cancel Requested'; }//csr order cancellation req
									//if($row['cancel']!='0'){ $order_status = 'Cancelled'; }//adrep order cancellation
									//note sent newad
									$note = $this->db->get_where('note_sent',array('order_id' => $row['id'], 'revision_id' => '0'))->row_array();
								}
						?>
			<tr> 
<!-- Date -->		<td class="width-120"><?php $date = strtotime($row['created_on']); echo date('M d, Y', $date); ?></td>

<!-- Type -->		<td class="center">
						<?php if($row['order_type_id'] == '1') { ?> 
						<img src="<?php echo base_url(); ?>assets/lite/img/web.png" alt="Web">
						<?php } else { ?> 
							<img src="<?php echo base_url(); ?>assets/lite/img/print.png" alt="print">
						<?php }  ?>
					</td>

<!-- order id -->	<td class="width-105">
						<?php if($row['status']!='1' || $row['status']!='2'){ ?>
						<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'lite/home/revision_details/'.$row['id'];?>'" style="cursor:pointer; text-decoration: underline;"><?php echo $row['id']; ?></a>
						<?php }else{ echo $row['id']; }  ?>
					</td>
<!-- Unique Job ID -->					
					<td class="width-120"><?php echo $row['job_no']; ?>
		  </td>
<!-- Client Name -->					
					<td class="width-90"><?php echo $row['advertiser_name']; ?></td>
<!-- Adrep Name -->					
					<td class="width-90">
					<?php $adrep =  $this->db->get_where('adreps',array('id'=>$row['adrep_id']))->result_array();
						echo $adrep[0]['first_name'].' '.$adrep[0]['last_name'];
					?></td>
				
<!-- Date Needed -->					
					<td class="width-120"><?php if($row['publish_date'] == '0000-00-00')
							{ echo ""; } else { echo date("M d, Y",strtotime($row['publish_date']));}?>
					</td>
<!-- Status -->
					<td class="width-90">
						<?php if($row['question']=='1'){ ?>
						<!-- Question sent for Answer -->
						<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'lite/home/new_ad_answer/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;">
					
					<!--	<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'lite/home/order_action/QA/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;">
					-->	<button class="btn btn-block btn-xs padding-5 btn-grey">Question</button></a>
						<?php }elseif($orders_rev && $orders_rev['question']=='1'){ ?>
						<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'lite/home/rev_ad_answer/'.$orders_rev['id'];?>'" style="cursor:pointer; text-decoration: none;">
					<!--	<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'lite/home/order_action/QA_rev/'.$orders_rev['order_id'];?>'" style="cursor:pointer; text-decoration: none;">
						--><button class="btn btn-block btn-xs padding-5 btn-grey" title="<?php echo $orders_rev['question']; ?>">Question</button></a>
						<?php } else{ ?>
						<?php echo $order_status; ?> 
						<?php } ?>
					</td>
					
<!-- Pickup -->

					<!--<td class="center width-30" title="Pickup">
						<?php if($status_id=='5' || $status_id == '7') { if($publication[0]['design_team_id']=='8' || $publication[0]['id']=='43'){ ?>
							<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'lite/home/order_action/pickup/'.$row['job_no'];?>'" style="cursor:pointer; text-decoration: none;"><img class="action-img" src="<?php echo base_url(); ?>assets/lite/img/pickup.png"></a>
						<?php }else{ ?>
							<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'lite/home/order_action/pickup/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;"><img class="action-img" src="<?php echo base_url(); ?>assets/lite/img/pickup.png"></a>
						<?php } }else{ echo ""; }?>
					</td>-->
					<td class="center width-30" title="Pickup">
						<?php if($status_id=='5' || $status_id == '7' || $order_status == 'Proof Ready' || $order_status == 'Approved' ) { ?>
						<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'lite/home/order_action/pickup/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;"><img class="action-img" src="<?php echo base_url(); ?>assets/lite/img/pickup.png"></a>
						<?php } else { echo ""; }?>
					</td>
<!-- Revision -->						
					<!--<td class="center width-30" title="Revision">
						<?php if($status_id=='5' && $order_status != 'Approved') { ?>
							<a href="<?php echo base_url().index_page().'lite/home/order_action/revision/'.$row['id'];?>" data-toggle="tooltip" title="Revision" >
							<img class="action-img" src="<?php echo base_url(); ?>assets/lite/img/revision.png"></a>
						<?php } ?>
					</td> -->
					
					<td class="center width-30" title="Revision">
						<?php if($status_id=='5' && $order_status != 'Approved') { 
								$rev_days = $publication[0]['rev_days'];
								if($rev_days =='0'){ 
						?>
							<a href="<?php echo base_url().index_page().'lite/home/order_action/revision/'.$row['id'];?>" data-toggle="tooltip" title="Revision" >
							<img class="action-img" src="<?php echo base_url(); ?>assets/lite/img/revision.png"></a>
						
						<?php }else{ 
								$date = date("Y-m-d",strtotime($row['created_on']));
								$rev_allowed = date('Y-m-d', strtotime($date. '+'.$rev_days.' days'));
								$today = date('Y-m-d');
						
								if($today >= $date && $today <= $rev_allowed ){ 
						?>
							<a href="<?php echo base_url().index_page().'lite/home/order_action/revision/'.$row['id'];?>" data-toggle="tooltip" title="Revision" >
							<img class="action-img" src="<?php echo base_url(); ?>assets/lite/img/revision.png"></a>
						
							
						<?php } } } ?>
					</td>
					
<!-- View -->	
					<td class="center width-30" title="View">
						<a href="<?php echo base_url().index_page().'lite/home/order_action/view/'.$row['id'];?>" data-toggle="tooltip" title="View" >
						<img class="action-img" src="<?php echo base_url(); ?>assets/lite/img/order_view.png"></a>
					</td>
<!-- Attachments -->						
					<td class="center width-30">
					<?php if($status_id=='1' || $status_id=='2' || $status_id=='3') {?>
							<a href="<?php echo base_url().index_page().'lite/home/order_action/'.'attachments'.'/'.$row['id'];?>" data-toggle="tooltip" title="Attachments" >
							<img class="action-img" src="<?php echo base_url(); ?>assets/lite/img/attachment.png"></a>
						<?php }else{ echo""; } ?>
					</td>
					<!--<td class="center"><a class="btn btn-block btn-xs padding-5 btn-success">Approve</a></td>-->
<!-- PDF -->
					<td class="center width-30" title="PDF">
						<?php if($pdf_path != 'none' && file_exists($pdf_path)){ ?>
						<a href="<?php echo base_url().$pdf_path;?>" data-toggle="tooltip" title="<?php if(isset($note['id'])){ echo $note['note']; }else{ echo"PDF"; } ?>" data-placement="top" target="_blank" style="cursor:pointer; text-decoration: none;">
						<img class="action-img" src="<?php echo base_url(); ?>assets/lite/img/pdf.png"></a>
						<?php  }else{ echo ''; }?>
					</td>
<!-- Actions -->							
						<?php if($pdf_path != 'none'){ ?>
		<!-- Approve Unapprove -->
							<?php if($row['status'] == '7' || $order_status == 'Approved'){ ?>
								<td>
									<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'lite/home/unapprove_order/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;">
									<button class="btn btn-block btn-xs padding-5 btn-danger">Unapprove</button></a>
								</td> 
							<?php }else{ ?>
								<td title="Job Approval">
									<a href="<?php echo base_url().index_page().'lite/home/jRate/'.$row['id'] ;?>" 
										onclick="javascript:void window.open('<?php echo base_url().index_page().'lite/home/jRate/'.$row['id'];?>','1432728298066','width=515,height=228,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=50,top=20');return false;">
									<!--<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'lite/home/jRate/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;">-->
									<button class="btn btn-block btn-xs padding-5 btn-success">Approve</button> 
									</a>
								</td>
							<?php } ?>
		<!-- cancel -->
					<?php }elseif($row['cancel'] != '0'){
			//Resubmit 
							if($publication[0]['design_team_id']=='8' || $publication[0]['id']=='43'){ ?>
								<td><a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'lite/home/order_action/pickup/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;"><button class="btn btn-block btn-xs padding-5 btn-blue" >Resubmit</button></a></td>
							<?php }else{ ?>
								<td><a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'lite/home/order_action/pickup/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;"><button class="btn btn-block btn-xs padding-5 btn-blue" >Resubmit</button></a></td>
							<?php }	?>
							
					<?php }elseif($order_status == 'Cancel Requested'){ ?>
							<td style="cursor:pointer;">
							<form method="post" action="<?php echo base_url().index_page().'lite/home/order_cancel/'.$row['id'];?>">
			<!--cancel req accept -->
								<button type="submit" name="remove" id="remove" class="btn btn-block btn-xs padding-5 btn-grey" onclick="return confirm('Are you sure you want to accept order cancellation ?');">Accept</button>
							</form>	 
			<!--cancel req reject -->
								<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'lite/home/reject_v2/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;"><button class="btn btn-block btn-xs padding-5 btn-grey" >Reject</button></a>
							</td>
					<?php }elseif(!$orders_rev && $row['status'] != '5'){ ?>
			<!--cancel button -->
							<td title="Job Cancel">
								<form method="post" action="<?php echo base_url().index_page().'lite/home/order_cancel/'.$row['id'];?>">
									<button type="submit" name="remove" id="remove" class="btn btn-block btn-xs padding-5 btn-grey" onclick="return confirm('Are you sure you want to cancel ?');">Cancel</button>
								</form>
							</td>
					<?php }else{ echo'<td></td>'; } ?>
				
					</tr>
				<?php } ?>
					 
 
				   </tbody>  
					<?php } ?>
				
				</table>
			 </div>
		 </div>
	 </div>
  </div>
</section>
</div>


<?php $this->load->view("lite/footer.php"); ?>
 <?php $this->load->view("lite/foot.php"); ?>		