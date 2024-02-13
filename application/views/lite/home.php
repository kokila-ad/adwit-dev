<?php $this->load->view("lite/head.php"); ?>										
<?php $this->load->view("lite/header.php"); ?>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.3/angular.min.js"></script>
<script type = "text/javascript" >
   function preventBack(){window.history.forward();}
    setTimeout("preventBack()", 0);
    window.onunload=function(){null};
</script>
<style>
	.margin-bottom-2{ margin-bottom: 2px;}
	@media screen and (max-width: 450px){
		.mob .text-right , .mob .text-left{ text-align: center !important;}
	}
</style>
<script>
$(document).ready(function(){
	//ad format
				$('input[name="ad_format"]').change(function(){
						var x = $(this).attr("value");
						var si = $('input[name="static'+x+'"]').attr("value");
						var ai = $('input[name="animated'+x+'"]').attr("value");
						
						if(si == '0'){ 
							$("#web_ad_type_static").hide();
						} else if(si == '1') {
							$("#web_ad_type_static").show();
						}
						
						if(ai == '0'){ 
							$("#web_ad_type_animated").hide();
						} else if(ai == '1') {
							$("#web_ad_type_animated").show();
						}
						
					});
	//form hide show
	$("#web_form").hide();
	$("#print_form").hide();
	
	$('#calc_type').change(function(){
		var type = $('#calc_type').val();
		if (type == 'print_calc') {
			$("#web_form").hide();
			$("#print_form").show();
		} else if (type == 'online_calc') {
			$("#web_form").show();
			$("#print_form").hide();
		}
	});
	
});
</script>


    <section>
        <div class="container margin-bottom-50 margin-top-10">
		 <div class="row margin-0">             
           <div class="col-md-12 col-sm-6 col-xs-12 margin-top-20">
				<div class="row border">
					<div class="col-md-6 col-sm-6 col-xs-12 border-right padding-top-10">			
				<!---- Start: Credit Balance ----->
					<div class="row margin-0">             
						<div class="col-md-12 col-sm-12 col-xs-12 center">
						    					<p class="margin-top-10" style="text-align: left;">In these COVID times we understand that our customers' resources are stretched thin. Adwit has decided to open up its pagination services to any of our customers who might need it.
</p><p class="margin-top-10" style="text-align: left;">We will continue providing pagination as part of our service to existing print customers till the end of July.
</p><p class="margin-top-10" style="text-align: left;">You can immediately set up a brief webinar by contacting us.</p>
						<!--	 <p class="large margin-top-10">Credit Balance <span class="text-blue "><?php if(isset($credits)){ echo $credits; } ?></span> -->
							<!-- <a href="<?php echo base_url().index_page().'lite/home/buycredit'; ?>" class="btn btn-dark btn-sm btn-outline"><span>Buy Credits</span></a>-->
							 </p>
						</div>	
					</div> 			
				<!---- Start: Credit Balance ----->
				<!---- Start: Refer Friend
					<div class="row margin-0 margin-top-15">             
						<div class="col-md-12 col-sm-12 col-xs-12 border center">
							 <div class="padding-horizontal-15 padding-vertical-25 border-theme row  margin-0">
							 <p class="xlarge margin-bottom-20">Refer A Friend</p>
								 <form method="post" action="<?php echo base_url().index_page().'lite/home/invite_friends'; ?>">
									<div class="col-sm-8 col-xs-12 padding-0">
										<input type="email" name="email" class="form-control" placeholder="Enter E-mail Id...">
									</div>
									<div class="col-sm-4 col-xs-12 padding-0">
										<button class="btn btn-blue btn-sm btn-block" type="submit" name="invite">Submit</button>   
									</div>
								</form>
							</div>
						</div>	
					</div>				
			 End: Refer Friend ----->
					</div>
					<div class="col-md-6 col-sm-12 col-xs-12 padding-15 padding-top-25">
					<?php //$this->load->view("lite/search_view.php"); ?>	
					<form method="post" action="<?php echo base_url().index_page().'lite/home/order_search';?>"> 
						<div id="search">
							<div class="row">
								<div class="col-md-8 col-sm-8 col-xs-8 padding-right-0">
								  <input type="text" name="input" class="form-control" title="" placeholder="Enter Order ID, Job ID or Advertiser Name">
								</div>
								 <div class="col-md-4 col-sm-4 col-xs-4 padding-left-0">
								<button type="submit" name="search" class="btn btn-blue btn-sm btn-block margin-right-15 " required>Search</button>
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
										<button class="btn btn-dark btn-sm" type="button"><i class="fa fa-calendar"></i></button>
										</span>
									</div>
								  </div>
								  <div class="col-md-6 col-sm-6 col-xs-12 background-color-blue">
									<p class="padding-top-10 margin-bottom-5">To</p>
									<div class="input-group date date-picker margin-bottom-15" data-date-format="dd-mm-yyyy">
										<input type="text" name="to_dt" class="form-control input-sm" readonly name="datepicker">
										<span class="input-group-btn">
										<button class="btn btn-dark btn-sm" type="button"><i class="fa fa-calendar"></i></button>
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
									<button type="submit" name="adv_search" class="btn btn-dark btn-outline btn-sm margin-top-35 ">  <span>SUBMIT</span> </button>
									<span class="float-right margin-top-55"><a class="cursor-pointer text-white" id="showsearch">&laquo back</a></span>
								  </div>	
							   </div>					   
							</div>
						</div>	
					</form> 
					</div>
				</div>
				
				<div class="row border margin-top-15">
					<!--
					<div class="col-md-6 padding-15 mob">
						<p class="bold large text-center">Features</p>
						<div class="row margin-top-25">
							<div class="col-md-6 border-right margin-bottom-10 text-right">
								<p class="margin-bottom-5 padding-right-10"> Up to 2 ads per week free </p>
							</div>
							<div class="col-md-6 margin-bottom-10 text-left">
								<p class="margin-bottom-5 padding-left-10">24x5 Support</p>
							</div>
							<div class="col-md-6 border-right margin-bottom-10 text-right">
								<p class="margin-bottom-5 padding-right-10">Immediate delivery of new ads</p>
							</div>
							<div class="col-md-6 margin-bottom-10 text-left">
								<p class="margin-bottom-5 padding-left-10">Unlimited Changes in 2 hours or less</p>
							</div>
						</div>
					</div>
					-->
					<div class="col-md-6 text-center padding-15">
						<p class="bold large margin-bottom-20">Features</p>
						<p class="margin-bottom-10"><i class="fa fa-copy">&nbsp;</i> Up to 2 ads per week free</p>
						<p class="margin-bottom-10"><i class="fa fa-download">&nbsp;</i> Immediate delivery of new ads</p>
						<p class="margin-bottom-10"><i class="fa fa-history">&nbsp;</i> Unlimited Changes in 2 hours or less</p>
						<p class="margin-bottom-10"><i class="fa fa-clock-o">&nbsp;</i> 24x5 Support</p>
					</div>
					<div class="col-md-6 border-left padding-vertical-15" ng-app="">
						<p class="bold large text-center margin-bottom-10">Credits Calculator</p>
						<div class="col-md-6 col-sm-offset-3 margin-bottom-10">
							<select id="calc_type" class="form-control input-sm text-center">
								 <option value="">Select Order Type</option>
								 <option value="print_calc" >Print Ad</option>
								 <option value="online_calc">Online Ad</option>
							</select>
						</div>
						
						<!--
						<div class="col-md-6 margin-bottom-10">
							<button type="button" id="print_btn" class="btn btn-blue btn-sm btn-block">Print Ad</button>
						</div>
						<div class="col-md-6 margin-bottom-10">
							<button type="button" id="web_btn" class="btn btn-blue btn-sm btn-block">Online Ad</button>
						</div>-->
						<!-- print ad calc -->
						<form name="calculator" id="print_form">
						
						<div class="row1">
							<div class="col-md-6 margin-bottom-10">
								<input type="number" name="width" id="width" ng-model="width" max="99" min="1" step="0.0001" class="form-control input-sm" placeholder="Width In Inches" required>
								<span class="text-red" ng-show="calculator.width.$error.number">Enter only numbers</span>
								<span class="text-red" ng-show="calculator.width.$error.min">Minimum value is 1</span>
								<span class="text-red" ng-show="calculator.width.$error.max">Maximum value is 99</span>
							</div>
							<div class="col-md-6 margin-bottom-10">
								<input type="number" name="height" id="height" ng-model="height" max="99" min="1" step="0.0001" class="form-control input-sm" placeholder="Height In Inches" required>
								<span class="text-red" ng-show="calculator.height.$error.number">Enter only numbers</span>
								<span class="text-red" ng-show="calculator.height.$error.min">Minimum value is 1</span>
								<span class="text-red" ng-show="calculator.height.$error.max">Maximum value is 99</span>
							</div>
							<div class="col-md-6 margin-bottom-10">
								<input type="number" name="num_ads" id="num_ads" ng-model="num_ads" max="99" min="1" class="form-control input-sm" placeholder="No Of Ads" required>
								<span class="text-red" ng-show="calculator.num_ads.$error.number">Enter only numbers</span>
								<span class="text-red" ng-show="calculator.num_ads.$error.min">Minimum value is 1</span>
								<span class="text-red" ng-show="calculator.num_ads.$error.max">Maximum value is 99</span>
							</div>
							<div class="col-md-6 margin-bottom-10">
								<input type="number" name="num_img" id="num_img" ng-model="num_img" max="99" min="1" class="form-control input-sm" placeholder="No Of Images" required>
								<span class="text-red" ng-show="calculator.num_img.$error.number">Enter only numbers</span>
								<span class="text-red" ng-show="calculator.num_img.$error.min">Minimum value is 1</span>
								<span class="text-red" ng-show="calculator.num_img.$error.max">Maximum value is 99</span>
							</div>
							<div class="col-md-6">
								<p class="margin-top-5 margin-0" id="credits"></p>
							</div>
							<div class="col-md-6 text-right">
								<button type="button" onclick="calc()" class="btn btn-blue btn-sm btn-block" ng-disabled="calculator.$invalid">Calculate</button>
								<p class="margin-top-10 text-grey" style="font-size: 11px;">*Credit required is approximate and may change based on complexity.</p>
							</div>
							</div>
						</form>
						<!-- online ad calc -->
						<form name="online_calc" id="web_form" >
						<div class="row2">
							<div class="col-md-12 margin-bottom-10">
								<p>
								Format<span class="text-red"> * </span><small class="text-grey">(select one)</small>
								</p>
								<div class="btn-group" data-toggle="buttons">
								<?php 
									$results = $this->db->get('lite_online_format')->result_array();
									  foreach($results as $result){
								?>
									<label class="btn btn-sm btn-default margin-right-10 margin-bottom-10">
										<input type="radio" class="ad_format form-control input-sm" name="ad_format" value="<?php echo $result['id']; ?>" > 
										<?php echo $result['name']; ?>
									</label>
									<input type="hidden" id="static<?php echo $result['id']; ?>" name="static<?php echo $result['id']; ?>" value="<?php echo $result['static']; ?>">
									<input type="hidden" id="animated<?php echo $result['id']; ?>" name="animated<?php echo $result['id']; ?>" value="<?php echo $result['animated']; ?>">
								<?php } ?>
								</div>
							</div>
							<div class="col-md-12 margin-bottom-10">
								<div class="col-md-6 margin-bottom-10">
								<p class="margin-bottom-5">
									Ad Type <span class="text-red">* </span><small class="text-grey">(select one)</small>
							    </p>
								<div class="btn-group" data-toggle="buttons">
									<label id="web_ad_type_static" class="btn btn-sm btn-default margin-right-10 margin-bottom-10">
										<input type="radio" name="web_ad_type" class="web_ad_type" value="Static" > Static
									</label> 
									<label id="web_ad_type_animated" class="btn btn-sm btn-default margin-right-10 margin-bottom-15">
										<input type="radio" name="web_ad_type" class="web_ad_type" value="Animated" > Animated
									</label> 
								</div>
								</div>
								<div class="col-md-6 margin-bottom-10">
								<p class="margin-bottom-5">
									Number Of Ads <span class="text-red">* </span><small class="text-grey"></small>
							    </p>
									<input type="number" name="num_ads" id="num_ads_online" ng-model="num_ads_online" max="20" min="1" class="form-control input-sm" placeholder="No Of Images" required>
									<span class="text-red" ng-show="online_calc.num_ads_online.$error.number">Enter only numbers</span>
									<span class="text-red" ng-show="online_calc.num_ads_online.$error.min">Minimum value is 1</span>
									<span class="text-red" ng-show="online_calc.num_ads_online.$error.max">Maximum value is 99</span>
								</div>
							</div>
							<div class="col-md-6">
								<p class="margin-top-5 margin-0" id="credits_online"></p>
							</div>
							<div class="col-md-6 text-right">
								<button type="button" onclick="calc_online()" class="btn btn-blue btn-sm btn-block" ng-disabled="online_calc.$invalid">Calculate</button>
								<p class="margin-top-10 text-grey" style="font-size: 11px;">*Credit required is approximate and may change based on complexity.</p>
							</div>
							</div>
						</form>
					</div>
				</div>
				
				
				
<!--dashboard data-->	
<?php if(isset($orders[0]['id']) || isset($tl_orders[0]['id'])) {		?>				
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12 padding-0 margin-top-15">
						<div class="table-responsive border padding-15"> 
			
				<table class="table table-striped table-bordered table-hover margin-bottom-50" id="example">
					<thead>
						<tr>
							<td class="width-90">Date</td>
							<td>AdwitAds ID</td>
							<td class="width-120">Unique Job ID</td>
							<td class="width-120">Advertiser Name</td>
							<?php if($client[0]['team_orders']=='1'){ ?>
							<td class="width-90">Adrep Name</td>
							<?php } ?>
							
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
						<?php if($pdf_path != 'none'){ ?><td></td>
		<!-- Approve Unapprove -->
				<!--
							<?php if($row['status'] == '7' || $order_status == 'Approved'){ ?>
								<td>
									<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'lite/home/unapprove_order/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;">
									<button class="btn btn-block btn-xs padding-5 btn-danger">Unapprove</button></a>
								</td> 
							<?php }else{ ?>
								<td title="Job Approval">
									<a href="<?php echo base_url().index_page().'lite/home/jRate/'.$row['id'] ;?>" 
										onclick="javascript:void window.open('<?php echo base_url().index_page().'lite/home/jRate/'.$row['id'];?>','1432728298066','width=515,height=228,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=50,top=20');return false;">
									
									<button class="btn btn-block btn-xs padding-5 btn-success">Approve</button>
									</a>
								</td>
							<?php } ?>
				-->
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
			<?php if($row['status'] == '0'){ ?>
							<td title="Insufficient Balance">
							<a href="<?php echo base_url().index_page().'lite/home/preorder/'.$row['id']; ?>" class="btn btn-block btn-xs padding-5 btn-grey cursor-pointer padding-left-5">Proceed</a> 
							</td>
			<?php }else{ ?>
							<td title="Job Cancel">
								<!--Start: Cancel-->									
								<span class="dropdown text-grey">
									<span class="btn btn-block btn-xs padding-5 btn-grey cursor-pointer padding-left-5" type="button" data-toggle="dropdown" id="view" aria-expanded="false">Cancel</span>
									<div class="dropdown-menu file_li padding-10">  							 
										<p class="margin-bottom-5">Are you sure?</p>
										<div class="row">
											<div class="col-xs-6 padding-right-5">
												<form method="post" action="<?php echo base_url().index_page().'lite/home/order_cancel/'.$row['id'];?>">
													<button type="submit" name="remove" id="remove" class="btn btn-primary btn-xs padding-5 padding-horizontal-20 margin-right-5 btn-block">Yes</button>
												</form>
											</div>
											<div class="col-xs-6 padding-left-5">
												<button class="btn btn-blue btn-xs padding-5 padding-horizontal-20 btn-block">No</button>
											</div>
										</div>
									</div>
								</span>
							<!--End: Cancel-->
							</td>
			<?php } ?>
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
						<?php if($pdf_path != 'none'){ ?><td></td>
		<!-- Approve Unapprove -->
			<!--
							<?php if($row['status'] == '7' || $order_status == 'Approved'){ ?>
								<td>
									<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'lite/home/unapprove_order/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;">
									<button class="btn btn-block btn-xs padding-5 btn-danger">Unapprove</button></a>
								</td> 
							<?php }else{ ?>
								<td title="Job Approval">
									<a href="<?php echo base_url().index_page().'lite/home/jRate/'.$row['id'] ;?>" 
										onclick="javascript:void window.open('<?php echo base_url().index_page().'lite/home/jRate/'.$row['id'];?>','1432728298066','width=515,height=228,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=50,top=20');return false;">
									
									<button class="btn btn-block btn-xs padding-5 btn-success">Approve</button> 
									</a>
								</td>
							<?php } ?>
				-->
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
			<?php if($row['status'] == '0'){ ?>
							<td title="Insufficient Balance">
							<a href="<?php echo base_url().index_page().'lite/home/preorder/'.$row['id']; ?>" class="btn btn-block btn-xs padding-5 btn-grey cursor-pointer padding-left-5">Proceed</a> 
							</td>
			<?php }else{ ?>
							<td title="Job Cancel">
							<!--Start: Cancel-->
								<span class="dropdown text-grey">
									<span class="btn btn-block btn-xs padding-5 btn-grey cursor-pointer padding-left-5" type="button" data-toggle="dropdown" id="view" aria-expanded="false">Cancel</span>
									<div class="dropdown-menu file_li padding-10">  							 
										<p class="margin-bottom-5">Are you sure?</p>
										<div class="row">
											<div class="col-xs-6 padding-right-5">
												<form method="post" action="<?php echo base_url().index_page().'lite/home/order_cancel/'.$row['id'];?>">
													<button type="submit" name="remove" id="remove" class="btn btn-primary btn-xs padding-5 padding-horizontal-20 margin-right-5 btn-block">Yes</button>
												</form>
											</div>
											<div class="col-xs-6 padding-left-5">
												<button class="btn btn-blue btn-xs padding-5 padding-horizontal-20 btn-block">No</button>
											</div>
										</div>
									</div>
								</span>
							<!--End: Cancel-->
							</td>
			<?php } ?>
					<?php }else{ echo'<td></td>'; } ?>
				
					</tr>
				<?php } ?>
					 
 
				   </tbody>  
					<?php } ?>
				
				</table>
				
						</div>
					</div>
				</div>
<?php } ?>				
			</div>
		
			
		  </div>	
		</div>
	</section>
	
	
<script>	
function calc() {
	
	$.ajax({
	url: "<?php echo base_url().index_page().'lite/home/calc';?>",
	data:'w='+$('#width').val()+'&h='+$('#height').val()+'&num='+$('#num_ads').val(),
	type: "POST",
	 success: function(data){
                      document.getElementById("credits").innerHTML = 'Required Credits: '+data;
                   } 
	});
	e.preventDefault();
}
</script>

<script>	
function calc_online() {
	$.ajax({
		/*var xyz = $(".ad_format:checked").val();
		var abc = $(".web_ad_type:checked").val();*/
	url: "<?php echo base_url().index_page().'lite/home/calc_online';?>",
	data:'ad_format='+$(".ad_format:checked").val()+'&web_ad_type='+$(".web_ad_type:checked").val()+'&num_ads='+$('#num_ads_online').val(),
	type: "POST",
	 success: function(data){
                      document.getElementById("credits_online").innerHTML = 'Required Credits: '+data;
                   } 
	});
	e.preventDefault();
}
</script>
			
<?php $this->load->view("lite/footer.php"); ?>
 <?php $this->load->view("lite/foot.php"); ?>
 
 