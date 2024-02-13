<style> .dropdown-menu {right: -60px; } 
div.dataTables_wrapper div.dataTables_info , div.dataTables_wrapper div.dataTables_paginate {
    display: none;
   }

hr { display: block; height: 1px;
    border: 0; border-top: 1px solid #ccc;
    margin: 1em 0; padding: 0; }
</style>

<!-- Approve popup modal code START--> 
    <style>
        /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            padding-top: 100px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }
        
        /* Modal Content */
        .modal-content {
            position: relative;
            background-color: #fefefe;
            margin: auto;
            padding: 0;
            border: 1px solid #888;
            width: 60%;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
            -webkit-animation-name: animatetop;
            -webkit-animation-duration: 0.4s;
            animation-name: animatetop;
            animation-duration: 0.4s
        }
        
        /* Add Animation */
        @-webkit-keyframes animatetop {
            from {top:-300px; opacity:0}
            to {top:0; opacity:1}
        }
        
        @keyframes animatetop {
            from {top:-300px; opacity:0}
            to {top:0; opacity:1}
        }
        
        /* The Close Button */
        .close {
           color: white;
           float: right;
           font-size: 28px;
           font-weight: bold;
           opacity: 2;
        }
        
        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
        
        .modal-header {
            padding: 2px 16px;
            background-color: #5cb85c;
            color: white;
        }
        
        .modal-body {padding: 2px 16px;}
        
        .modal-footer {
            padding: 2px 16px;
            background-color: #5cb85c;
            color: white;
        }
        /* mamatha changes */
        #tracker_table > tbody > tr > td > p {
           margin: 0px 0px 0px 0px !important;
        padding: 0px 0px 0px 10px !important;
        }
        #tracker_table >  tbody > tr >  td{
        padding: 1px !important;
        }
        input.individual {
          margin-right: 5px !important;
        }
        
        .pagination-btn {
            padding: 8px 8px !important;
        }
    </style>
<!-- Approve popup modal code END-->

<div class="row">	
		  <div class="col-md-12 margin-top-20">
			 <div class="table-responsive border padding-15">     
				<?php 
				    $client = $this->db->get_where('adreps',array('id'=>$this->session->userdata('ncId')))->result_array();
				    $pub_permit = array(48, 49, 45, 50, 58, 62, 408, 61, 63, 59, 60); //Aprove ad pop allowed publications
				?>
		 
				<table class="table table-striped table-bordered table-hover" id="example1">
				
					<thead>
						<tr>
							<td class="width-90">Order Date</td>
							
							<td>Type</td>
							
							<td>AdwitAds ID</td>
							
							<?php if($client[0]['page']=='1'){ ?>
							<td class="width-120">Page Number</td>
							<?php }else{ ?>
							<td class="width-120">Unique Job ID</td>
							<?php } ?>
							
							<?php if($client[0]['page']=='1'){ ?>
							<td class="width-120">Section Name</td>
							<?php }else{ ?>
							<td class="width-120">Advertiser Name</td>
							<?php } ?>
							
							<?php if($client[0]['team_orders']=='1'){ ?>
							<td class="width-90">Adrep Name</td>
							<?php } ?>
							
							<!-- waukesha freeman -->
							<?php 
							    if($publication[0]['id']=='580'){ 
							        echo '<td class="width-90">Keyword</td>';
							        echo '<td class="width-90">Account No.</td>'; 
							    } 
							 ?>
							
							<td class="width-90">Publish Date</td>
							
							<?php if($publication[0]['id']=='538'){ ?>
							<td class="width-90">Publication</td>
							<td class="width-90">Section</td>
							<td class="width-90">Deadline</td>
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
				<?php if(isset($orders)) {  ?>
					<tbody>
						<?php 
							foreach($orders as $row)
							{
							    if($publication[0]['id']=='580'){ 
                        		   $preorders_waukesha = $this->db->query("SELECT `id`, `adtitle`, `account_number` FROM `preorders_waukesha` WHERE `adwit_id` = '".$row['id']."'")->row_array(); 
                        		}
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
									//if($row['crequest']!='0'){ $order_status = 'Cancel Requested'; }//csr order cancellation req
									//if($row['cancel']!='0'){ $order_status = 'Cancelled'; }//adrep order cancellation
									//note sent newad
									$note = $this->db->get_where('note_sent',array('order_id' => $row['id'], 'revision_id' => '0'))->row_array();
								}
								
								//for glacier publication
								if($row['publication_id'] == '538'){
									$deadline = ''; $section =''; $project =''; $pub_date ='';
									
									$order_project_id = $this->db->query("SELECT pub_project.name, glacier_section.name AS section_name, order_project_id.publish_date FROM `order_project_id`
															JOIN `pub_project` ON pub_project.id = order_project_id.pub_project_id 
															JOIN `glacier_section` ON glacier_section.id = order_project_id.section_id
																WHERE order_project_id.order_id = '".$row['id']."'")->result_array();
									//$glacier_section = $this->db->query("SELECT `name` FROM `glacier_section` WHERE `id`='".$row['section']."'")->row_array();
								//	$order_publish_date = $this->db->query("SELECT `publish_date` FROM `order_publish_date` WHERE `order_id`='".$row['id']."'")->result_array();
									
									if(isset($order_project_id[0]['name'])){
										$i=0;
										foreach($order_project_id as $p){
											if($i != 0){ $project .= '<hr>'; $section .= '<hr>'; $pub_date .= '<hr>'; } $i++;
											$project .= '<p>'.$p['name'].'</p>';
											$section .= '<p>'.$p['section_name'].'</p>';
											if($p['publish_date'] != NULL){
												//echo $pub_date .= '<p>'.$p['publish_date'].'</p>';
												$pds = explode(',', $p['publish_date']);
												foreach($pds as $pd){ 
													$df = strtotime($pd); 
													$pub_date .= '<p>'.date('M d', $df).'</p>';
												}
												
												$restrict = array('6', '7');
												if(!in_array($row['status'], $restrict)){
													$a = $row['publish_date'].' 00:00:00';
													$b = Date('Y-m-d h:i:s');
													$datetime1 = new DateTime($a);//start time
													$datetime2 = new DateTime($b);//end time
													if($datetime1 > $datetime2){
														$interval = $datetime1->diff($datetime2);
														$days = $interval->format('%d');
														if($days == '0'){
															$deadline =  $interval->format('%H hrs %i mins');
														}else{
															$deadline =  $interval->format('%d days %H hrs %i mins');
														}
													}
												}
											}
											
										}
										
									}
									
								/*	if(isset($glacier_section['name'])) $section = $glacier_section['name'];
									
									if(isset($order_publish_date[0]['publish_date'])){
										foreach($order_publish_date as $pd){ 
											$df = strtotime($pd['publish_date']); 
											$pub_date .= '<p>'.date('M d', $df).'</p>';
										}
										$restrict = array('6', '7');
										if(!in_array($row['status'], $restrict)){
											$a = $row['publish_date'].' 00:00:00';
											$b = Date('Y-m-d h:i:s');
											$datetime1 = new DateTime($a);//start time
											$datetime2 = new DateTime($b);//end time
											if($datetime1 > $datetime2){
												$interval = $datetime1->diff($datetime2);
												$days = $interval->format('%d');
												if($days == '0'){
													$deadline =  $interval->format('%H hrs %i mins');
												}else{
													$deadline =  $interval->format('%d days %H hrs %i mins');
												}
											}
										}
									}*/
								}
						?> 
			<tr> 
			
<!-- Date -->		<td class="width-120"><?php if($row['activity_time'] != '0000-00-00 00:00:00') { $date = strtotime($row['activity_time']); echo date('M d, Y', $date); } else { echo ""; }?></td>


<!-- Type -->		<td class="center">
						<?php if($row['order_type_id'] == '1') { ?> 
						<img src="<?php echo base_url(); ?>assets/new_client/img/web.png" alt="Web">
						<?php } else { ?> 
							<img src="<?php echo base_url(); ?>assets/new_client/img/print.png" alt="print">
						<?php }  ?>
					</td>

<!-- order id -->	<td class="width-105">
						<?php if($row['status']!='1' || $row['status']!='2'){ ?>
						<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_client/home/revision_details/'.$row['id'];?>'" style="cursor:pointer; text-decoration: underline;"><?php echo $row['id']; ?></a>
						<?php }else{ echo $row['id']; }  ?>
					</td>
<!-- Unique Job ID -->					
					<td class="width-120"><?php echo $row['job_no']; ?></td>
<!-- Client Name -->					
					<?php if($client[0]['page']=='1'){ ?>
						<td class="width-90"><?php echo $row['section']; ?></td>
					<?php }else{ ?>
						<td class="width-90"><?php echo $row['advertiser_name']; ?></td>
					<?php } ?>
					
<!-- Waukesha freeman preorder adtitle(keyword)	-->
                    <?php if($publication[0]['id']=='580'){ 
                                if(isset($preorders_waukesha['adtitle'])) echo '<td class="width-90">'.$preorders_waukesha['adtitle'].'</td>'; else echo '<td class="width-90"></td>'; 
                                if(isset($preorders_waukesha['account_number'])) echo '<td class="width-90">'.$preorders_waukesha['account_number'].'</td>'; else echo '<td class="width-90"></td>'; 
                    } ?>
<!-- Publish Date  -->					
					<td class="width-120">
					<?php 
						if($publication[0]['id']=='538'){
							echo $pub_date;
						}else{
							if($row['publish_date'] == '0000-00-00'){ echo ""; }else{ echo date("M d, Y",strtotime($row['publish_date'])); }
						}
					?>
					</td>
<!-- project, section & countdown for glacier publication -->					
					<?php 
						if($publication[0]['id']=='538'){ 
							echo '<td>'.$project.'</td>'; 
							echo '<td>'.$section.'</td>';
							echo '<td>'.$deadline.'</td>';
						} 
					?>					
					
<!-- Status -->
					<td class="width-90">
						<?php 
						    echo $order_status;
						    if($row['question']=='1'){ 
						?>
						<!-- Question sent for Answer -->
						<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_client/home/new_ad_answer/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;">
						<!--<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_client/home/order_action/QA/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;">
						--><button class="btn red-thunderbird btn-grey btn-xs">Question</button></a>
						<?php }elseif($orders_rev && $orders_rev['question']=='1'){ ?>
						<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_client/home/rev_ad_answer/'.$orders_rev['id'];?>'" style="cursor:pointer; text-decoration: none;">
						<!--<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_client/home/order_action/QA_rev/'.$orders_rev['id'];?>'" style="cursor:pointer; text-decoration: none;">
						--><button class="btn btn-block btn-xs padding-5 btn-grey" title="<?php echo $orders_rev['question']; ?>">Question</button></a>
						<?php }  if($row['crequest']!='0'){ echo'<p><small>(Cancel Requested)</small></p>'; } ?>
						
						<!-- skip and download -->
        				<?php 
        				   // if($publication[0]['id']=='13'){ 
        				    //only if status in In Queue QA
        				        if($row['status'] == '8'){
        				            $order_id = $row['id'];
        				            $cat = $this->db->query("SELECT `slug`, `help_desk`, `source_path` FROM `cat_result` WHERE `order_no` = $order_id ;")->row_array();
        				            $slug = $cat['slug'];
        				            $hd = $cat['help_desk'];
        				            $sourcefile_path = $cat['source_path'];
        				            
        				            if($sourcefile_path != 'none' && !empty($sourcefile_path)) {
        				                $this->load->helper('directory');	
        								$map1 = glob($sourcefile_path.'/'.$slug.'.{pdf,jpg,gif,png}',GLOB_BRACE); //pdf/image
        								$map2 = glob($sourcefile_path.'/'.$slug.'.{indd,psd}',GLOB_BRACE); 
        								if($map1){
        									foreach($map1 as $row_map1){ $pdf_file = basename($row_map1); } 
        									foreach($map2 as $row_map2){ $source_file = basename($row_map2); } 
        					                if(isset($pdf_file) && file_exists($sourcefile_path.'/'.$pdf_file)){ //echo $row_map1;
        				    ?>
                				            <form  method="POST" action="<?php echo base_url().index_page().'new_client/home/skip_and_download'; ?>" class="form-horizontal" role="form"> 
                							    <input type="text" name="hd" value="<?php echo $hd; ?>" readonly style="display:none;">
                								<input name="order_id" value="<?php echo $order_id;?>" readonly style="display:none;" />
                								<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
                								<input name="new_slug" value="<?php echo $slug;?>" readonly style="display:none;" />
                								<input name="source_path" value="<?php echo $sourcefile_path;?>" readonly style="display:none;" />
                								<input name="pdf_file" value="<?php echo $pdf_file;?>" readonly style="display:none;" />
                								<input name="archive" value="archive" readonly style="display:none;" />
                								<button type="submit" name="end_time" class="btn red-thunderbird btn-blue btn-xs" onclick="return Adp_confirm();">Skip & Download</button>
                							</form>
        				    <?php 
        					                }
        				                }
        				            }else{ echo 'Sourcefile Path Missing..'; }
        				         }else{ echo ''; }
        				    //} 
        				?>
        				<!-- skip and download -->
					</td>
<!-- Pickup -->

					<!--<td class="center width-30" title="Pickup">
						<?php if($status_id=='5' || $order_status == 'Approved') { if($publication[0]['design_team_id']=='8' || $publication[0]['id']=='43'){ ?>
							<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_client/home/order_action/pickup/'.$row['job_no'];?>'" style="cursor:pointer; text-decoration: none;"><img class="action-img" src="<?php echo base_url(); ?>assets/new_client/img/pickup.png"></a>
						<?php }else{ ?>
							<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_client/home/order_action/pickup/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;"><img class="action-img" src="<?php echo base_url(); ?>assets/new_client/img/pickup.png"></a>
						<?php } }else{ echo ""; }?>
					</td>-->
					<td class="center width-30" title="Pickup">
						<?php if($status_id=='5' || $status_id == '7' || $order_status == 'Proof Ready' || $order_status == 'Approved') {  ?>
							<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_client/home/order_action/pickup/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;"><img class="action-img" src="<?php echo base_url(); ?>assets/new_client/img/pickup.png"></a>
						<?php  }else { echo ""; }?>
					</td>
<!-- Revision -->						
					<td class="center width-30" title="Revision">
						<?php if($status_id=='5' && $order_status != 'Approved') { 
								$rev_days = $publication[0]['rev_days'];
								if($rev_days =='0'){ 
						?>
							<a href="<?php echo base_url().index_page().'new_client/home/new_order_revision/'.$row['id'];?>" data-toggle="tooltip" title="Revision" >
							<img class="action-img" src="<?php echo base_url(); ?>assets/new_client/img/revision.png"></a>
						
						<?php }else{ 
								$date = date("Y-m-d",strtotime($row['created_on']));
								$rev_allowed = date('Y-m-d', strtotime($date. '+'.$rev_days.' days'));
								$today = date('Y-m-d');
						
								if($today >= $date && $today <= $rev_allowed ){ 
						?>
							<a href="<?php echo base_url().index_page().'new_client/home/new_order_revision/'.$row['id'];?>" data-toggle="tooltip" title="Revision" >
							<img class="action-img" src="<?php echo base_url(); ?>assets/new_client/img/revision.png"></a>
						
							
						<?php } } } ?>
					</td>
<!-- View -->	
					<td class="center width-30" title="View">
						<a href="<?php echo base_url().index_page().'new_client/home/order_action/view/'.$row['id'];?>" data-toggle="tooltip" title="View" >
						<img class="action-img" src="<?php echo base_url(); ?>assets/new_client/img/order_view.png"></a>
					</td>
<!-- Attachments -->						
					<td class="center width-30">
					<?php if($status_id=='1' || $status_id=='2' || $status_id=='3') {?>
							<a href="<?php echo base_url().index_page().'new_client/home/order_action/'.'attachments'.'/'.$row['id'];?>" data-toggle="tooltip" title="Attach" >
							<img class="action-img" src="<?php echo base_url(); ?>assets/new_client/img/attachment.png"></a>
						<?php }else{ echo""; } ?>
					</td>
					<!--<td class="center"><a class="btn btn-block btn-xs padding-5 btn-success">Approve</a></td>-->
<!-- PDF -->
					<td class="center width-30">
						<?php if($pdf_path != 'none' && file_exists($pdf_path)){ ?>
						<a href="<?php echo base_url().$pdf_path;?>" data-toggle="tooltip" title="<?php if(isset($note['id'])){ echo $note['note']; }else{ echo"PDF"; } ?>" data-placement="top" target="_blank" style="cursor:pointer; text-decoration: none;">
						<img class="action-img" src="<?php echo base_url(); ?>assets/new_client/img/pdf.png"></a>
						<?php  }else{ echo ''; }?>
					</td>
<!-- Actions -->							
						<?php if($pdf_path != 'none'){ ?>
		<!-- Approve Unapprove -->
							<?php if($order_status == 'Approved'){ ?>
								<td>
									<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_client/home/unapprove_order/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;">
									<button class="btn btn-block btn-xs padding-5 btn-danger">Unapprove</button></a>
								</td> 
							<?php }else{ ?>
								<!--<td title="Job Approval">
									<a href="<?php echo base_url().index_page().'new_client/home/jRate/'.$row['id'] ;?>" 
										onclick="javascript:void window.open('<?php echo base_url().index_page().'new_client/home/jRate/'.$row['id'];?>','1432728298066','width=515,height=228,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=50,top=20');return false;">
									<button class="btn btn-block btn-xs padding-5 btn-success">Approve</button>
									</a>
								</td>-->
								
								<td title="Job Approval">
								<?php if($publication[0]['id']=='190'){ ?> 
									<a href="<?php echo base_url().index_page().'new_client/home/approval/'.$row['id'] ;?>">
									<button class="btn btn-block btn-xs padding-5 btn-success">Approve</button>
									</a>
								<?php }elseif(in_array($publication[0]['id'], $pub_permit)){ //Lethbridge herald, Taber times popup modal ?>
								
								 <!-- Approve popup modal code START-->   
								    <button class="modal-button btn btn-block btn-xs padding-5 btn-success" href="#myModal<?php echo $row['id']; ?>">Approve</button>
								    <!-- The Modal -->
                                    <div id="myModal<?php echo $row['id']; ?>" class="modal">
                                    
                                      <!-- Modal content -->
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <span class="close">×</span>
                                          <h4>Approve Ad <?php echo $row['id']; ?></h4>
                                        </div>  
                                        <div class="table-responsive border padding-15"> 
                                            <table class="table table-striped table-bordered table-hover" id="tracker_table">
                            					<thead>
                            						<tr>
                            							<td width="30%"><b>Publication List</b></td>
                            						</tr>  									
                            					</thead>
                            					<tbody>
                            					    <form id="myForm<?php echo $row['id']; ?>" class="myForm" data-id="<?php echo $row['id']; ?>" method="post" action="<?php echo base_url().index_page().'new_client/home/jRate/'.$row['id'];?>">
                                                    <?php 
                                                        $sub_pub = $this->db->get_where('pub_project', array('pub_id' => '45'))->result_array();
                                                        foreach($sub_pub as $prow){ 
                                                    ?>
                                                        <tr> 
							                                <td>
							                                    <p><input type="checkbox" class="individual pub<?php echo $row['id']; ?>" name="pub[]" value="<?php echo $prow['initial']; ?>"><?php echo $prow['name'].' ('.$prow['initial'].')'; ?> </p> 
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                    <tr>
                                                        <td><button type="submit" name="submit" class="btn btn-blue pull-right margin-5" >SUBMIT</button></td>
                                                    </tr>
                                                    </form>
                                        
                            					</tbody>
                            				</table>
                                        </div>
                                        
                                      </div>
                                    
                                    </div>
                                <!-- Approve popup modal code --> 
                                
								<?php }else{ ?>
									<a href="<?php echo base_url().index_page().'new_client/home/jRate/'.$row['id'] ;?>" 
										onclick="javascript:void window.open('<?php echo base_url().index_page().'new_client/home/jRate/'.$row['id'];?>','1432728298066','width=515,height=228,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=50,top=20');return false;">
									<button class="btn btn-block btn-xs padding-5 btn-success">Approve</button>
									</a>
								<?php } ?>
								</td>
							<?php } ?>
		<!-- cancel -->
					<?php }elseif($row['cancel'] != '0'){ ?>
		<!--Resubmit -->
							
						<td><a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_client/home/resubmit_form/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;"><button class="btn btn-block btn-xs padding-5 btn-blue" >Resubmit</button></a></td>
							
					<?php }elseif($row['crequest']!='0'){ ?>
							<td style="cursor:pointer;">
							<form method="post" action="<?php echo base_url().index_page().'new_client/home/order_cancel/'.$row['id'];?>">
			<!--cancel req accept -->
								<button type="submit" name="remove" id="remove" class="btn btn-block btn-xs padding-5 btn-grey" onclick="return confirm('Are you sure you want to accept order cancellation ?');">Accept</button>
							</form>	 
			<!--cancel req reject -->
								<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_client/home/reject_v2/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;"><button class="btn btn-block btn-xs padding-5 btn-grey" >Reject</button></a>
							</td>
					<?php }elseif(!$orders_rev && $row['status'] != '5'){ ?>
			<!--cancel button -->
						<!--	<td title="Job Cancel">
								<form method="post" action="<?php echo base_url().index_page().'new_client/home/order_cancel/'.$row['id'];?>">
									<button type="submit" name="remove" id="remove" class="btn btn-block btn-xs padding-5 btn-grey" onclick="return confirm('Are you sure you want to cancel ?');">Cancel</button>
								</form>
							</td>-->
							<td title="Job Cancel">
								<span class="dropdown text-grey">
								
								<span class="btn btn-block btn-xs padding-5 btn-grey cursor-pointer padding-left-5" type="button" data-toggle="dropdown" id="view">Cancel</span>
										<div class="dropdown-menu file_li padding-10">  							 
											<p class="margin-bottom-5">Are you sure?</p>
											<div class="row margin-0">
												<div class="col-xs-6 padding-right-5 padding-left-0">
													<form method="post" action="<?php echo base_url().index_page().'new_client/home/order_cancel/'.$row['id'];?>">
														<button type="submit" name="remove" id="remove" class="btn btn-danger btn-xs padding-5 padding-horizontal-20 margin-right-5 btn-block">Yes</button>
													</form>
												</div>	
												<div class="col-xs-6 padding-left-5 padding-right-0">
													<button class="btn btn-blue btn-xs padding-5 padding-horizontal-20 btn-block">No</button>
												</div>
										</div>
								</span>
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
							    if($publication[0]['id']=='580'){ 
                        		   $preorders_waukesha = $this->db->query("SELECT `id`, `adtitle`, `account_number` FROM `preorders_waukesha` WHERE `adwit_id` = '".$row['id']."'")->row_array(); 
                        		}
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
									//if($row['crequest']!='0'){ $order_status = 'Cancel Requested'; }//csr order cancellation req
									//if($row['cancel']!='0'){ $order_status = 'Cancelled'; }//adrep order cancellation
									//note sent newad
									$note = $this->db->get_where('note_sent',array('order_id' => $row['id'], 'revision_id' => '0'))->row_array();
								}
								
								if($row['publication_id'] == '538'){
									$deadline = ''; $section =''; $project =''; $pub_date ='';
									
									$order_project_id = $this->db->query("SELECT pub_project.name, glacier_section.name AS section_name, order_project_id.publish_date FROM `order_project_id`
															JOIN `pub_project` ON pub_project.id = order_project_id.pub_project_id 
															JOIN `glacier_section` ON glacier_section.id = order_project_id.section_id
																WHERE order_project_id.order_id = '".$row['id']."'")->result_array();
								//	$glacier_section = $this->db->query("SELECT `name` FROM `glacier_section` WHERE `id`='".$row['section']."'")->row_array();
								//	$order_publish_date = $this->db->query("SELECT `publish_date` FROM `order_publish_date` WHERE `order_id`='".$row['id']."'")->result_array();
									
									if(isset($order_project_id[0]['name'])){
										$i=0;
										foreach($order_project_id as $p){
											if($i != 0){ $project .= '<hr>'; $section .= '<hr>'; $pub_date .= '<hr>'; } $i++;
											$project .= '<p>'.$p['name'].'</p>';
											$section .= '<p>'.$p['section_name'].'</p>';
											if($p['publish_date'] != NULL){
												//echo $pub_date .= '<p>'.$p['publish_date'].'</p>';
												$pds = explode(',', $p['publish_date']);
												foreach($pds as $pd){ 
													$df = strtotime($pd); 
													$pub_date .= '<p>'.date('M d', $df).'</p>';
												}
												
												$restrict = array('6', '7');
												if(!in_array($row['status'], $restrict)){
													$a = $row['publish_date'].' 00:00:00';
													$b = Date('Y-m-d h:i:s');
													$datetime1 = new DateTime($a);//start time
													$datetime2 = new DateTime($b);//end time
													if($datetime1 > $datetime2){
														$interval = $datetime1->diff($datetime2);
														$days = $interval->format('%d');
														if($days == '0'){
															$deadline =  $interval->format('%H hrs %i mins');
														}else{
															$deadline =  $interval->format('%d days %H hrs %i mins');
														}
													}
												}
											}
											
										}
										
									}
									/*
									if(isset($glacier_section['name'])) $section = $glacier_section['name'];
									
									if(isset($order_publish_date[0]['publish_date'])){
										foreach($order_publish_date as $pd){ 
											$df = strtotime($pd['publish_date']); 
											$pub_date .= '<p>'.date('M d', $df).'</p>';
										}
										$restrict = array('6', '7');
										if(!in_array($row['status'], $restrict)){
											$a = $row['publish_date'].' 00:00:00';
											$b = Date('Y-m-d h:i:s');
											$datetime1 = new DateTime($a);//start time
											$datetime2 = new DateTime($b);//end time
											if($datetime1 > $datetime2){
												$interval = $datetime1->diff($datetime2);
												$days = $interval->format('%d');
												if($days == '0'){
													$deadline =  $interval->format('%H hrs %i mins');
												}else{
													$deadline =  $interval->format('%d days %H hrs %i mins');
												}
											}
										}
									}*/
								}
						?>
			<tr> 
			
<!-- Date -->		<td class="width-120"><?php $date = strtotime($row['created_on']); echo date('M d, Y', $date); ?></td>

<!-- Type -->		<td class="center">
						<?php if($row['order_type_id'] == '1') { ?> 
						<img src="<?php echo base_url(); ?>assets/new_client/img/web.png" alt="Web">
						<?php } else { ?> 
							<img src="<?php echo base_url(); ?>assets/new_client/img/print.png" alt="print">
						<?php }  ?>
					</td>

<!-- order id -->	<td class="width-105">
						<?php if($row['status']!='1' || $row['status']!='2'){ ?>
						<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_client/home/revision_details/'.$row['id'];?>'" style="cursor:pointer; text-decoration: underline;"><?php echo $row['id']; ?></a>
						<?php }else{ echo $row['id']; }  ?>
					</td>
<!-- Unique Job ID -->					
					<td class="width-120"><?php echo $row['job_no']; ?></td>
<!-- Client Name -->					
					<?php if($client[0]['page']=='1'){ ?>
						<td class="width-90"><?php echo $row['section']; ?></td>
					<?php }else{ ?>
						<td class="width-90"><?php echo $row['advertiser_name']; ?></td>
					<?php } ?>

<!-- Adrep Name -->					
					<td class="width-90">
					<?php $adrep =  $this->db->get_where('adreps',array('id'=>$row['adrep_id']))->result_array();
						echo $adrep[0]['first_name'].' '.$adrep[0]['last_name'];
					?></td>
					
<!-- Waukesha freeman preorder adtitle(keyword)	-->
                    <?php if($publication[0]['id']=='580'){ 
                                if(isset($preorders_waukesha['adtitle'])) echo '<td class="width-90">'.$preorders_waukesha['adtitle'].'</td>'; else echo '<td class="width-90"></td>'; 
                                if(isset($preorders_waukesha['account_number'])) echo '<td class="width-90">'.$preorders_waukesha['account_number'].'</td>'; else echo '<td class="width-90"></td>'; 
                    } ?>				
<!-- Publish Date  -->					
					<td class="width-120">
					<?php 
						if($publication[0]['id']=='538'){
							echo $pub_date;
						}else{
							if($row['publish_date'] == '0000-00-00'){ echo ""; }else{ echo date("M d, Y",strtotime($row['publish_date'])); }
						}
					?>
					</td>
<!-- project, section & countdown for glacier publication -->					
					<?php if($publication[0]['id']=='538'){ 
						echo '<td>'.$project.'</td>'; 
						echo '<td>'.$section.'</td>';
						echo '<td>'.$deadline.'</td>';
					} 
					?>
					
<!-- Status -->
					<td class="width-90">
						<?php 
						    echo $order_status;
						    if($row['question']=='1'){ ?>
						<!-- Question sent for Answer -->
						<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_client/home/new_ad_answer/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;">
					
					<!--	<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_client/home/order_action/QA/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;">
					-->	<button class="btn red-thunderbird btn-grey btn-xs">Question</button></a>
						<?php }elseif($orders_rev && $orders_rev['question']=='1'){ ?>
						<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_client/home/rev_ad_answer/'.$orders_rev['id'];?>'" style="cursor:pointer; text-decoration: none;">
					<!--	<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_client/home/order_action/QA_rev/'.$orders_rev['order_id'];?>'" style="cursor:pointer; text-decoration: none;">
						--><button class="btn btn-block btn-xs padding-5 btn-grey" title="<?php echo $orders_rev['question']; ?>">Question</button></a>
						<?php }   if($row['crequest']!='0'){ echo'<p><small>(Cancel Requested)</small></p>'; }?>
						
						<!-- skip and download -->
        				<?php 
        				   // if($publication[0]['id']=='13'){ 
        				    //only if status in In Queue QA
        				        if($row['status'] == '8'){
        				            $order_id = $row['id'];
        				            $cat = $this->db->query("SELECT `slug`, `help_desk`, `source_path` FROM `cat_result` WHERE `order_no` = $order_id ;")->row_array();
        				            $slug = $cat['slug'];
        				            $hd = $cat['help_desk'];
        				            $sourcefile_path = $cat['source_path'];
        				            
        				            if($sourcefile_path != 'none' && !empty($sourcefile_path)) {
        				                $this->load->helper('directory');	
        								$map1 = glob($sourcefile_path.'/'.$slug.'.{pdf,jpg,gif,png}',GLOB_BRACE); //pdf/image
        								$map2 = glob($sourcefile_path.'/'.$slug.'.{indd,psd}',GLOB_BRACE); 
        								if($map1){
        									foreach($map1 as $row_map1){ $pdf_file = basename($row_map1); } 
        									foreach($map2 as $row_map2){ $source_file = basename($row_map2); } 
        					                if(isset($pdf_file) && file_exists($sourcefile_path.'/'.$pdf_file)){ //echo $row_map1;
        				    ?>
                				            <form  method="POST" action="<?php echo base_url().index_page().'new_client/home/skip_and_download'; ?>" class="form-horizontal" role="form"> 
                							    <input type="text" name="hd" value="<?php echo $hd; ?>" readonly style="display:none;">
                								<input name="order_id" value="<?php echo $order_id;?>" readonly style="display:none;" />
                								<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
                								<input name="new_slug" value="<?php echo $slug;?>" readonly style="display:none;" />
                								<input name="source_path" value="<?php echo $sourcefile_path;?>" readonly style="display:none;" />
                								<input name="pdf_file" value="<?php echo $pdf_file;?>" readonly style="display:none;" />
                								<input name="archive" value="archive" readonly style="display:none;" />
                								<button type="submit" name="end_time" class="btn red-thunderbird btn-blue btn-xs" onclick="return Adp_confirm();">Skip & Download</button>
                							</form>
        				    <?php 
        					                }
        				                }
        				            }else{ echo 'Sourcefile Path Missing..'; }
        				         }else{ echo ''; }
        				   // } 
        				?>
        				<!-- skip and download -->
					</td>
					
<!-- Pickup -->

					<!--<td class="center width-30" title="Pickup">
						<?php if($status_id=='5' || $status_id == '7') { if($publication[0]['design_team_id']=='8' || $publication[0]['id']=='43'){ ?>
							<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_client/home/order_action/pickup/'.$row['job_no'];?>'" style="cursor:pointer; text-decoration: none;"><img class="action-img" src="<?php echo base_url(); ?>assets/new_client/img/pickup.png"></a>
						<?php }else{ ?>
							<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_client/home/order_action/pickup/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;"><img class="action-img" src="<?php echo base_url(); ?>assets/new_client/img/pickup.png"></a>
						<?php } }else{ echo ""; }?>
					</td>-->
					<td class="center width-30" title="Pickup">
						<?php if($status_id=='5' || $status_id == '7' || $order_status == 'Proof Ready' || $order_status == 'Approved' ) { ?>
						<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_client/home/order_action/pickup/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;"><img class="action-img" src="<?php echo base_url(); ?>assets/new_client/img/pickup.png"></a>
						<?php } else { echo ""; }?>
					</td>
<!-- Revision -->						
					<!--<td class="center width-30" title="Revision">
						<?php if($status_id=='5' && $order_status != 'Approved') { ?>
							<a href="<?php echo base_url().index_page().'new_client/home/order_action/revision/'.$row['id'];?>" data-toggle="tooltip" title="Revision" >
							<img class="action-img" src="<?php echo base_url(); ?>assets/new_client/img/revision.png"></a>
						<?php } ?>
					</td> -->
					
					<td class="center width-30" title="Revision">
						<?php if($status_id=='5' && $order_status != 'Approved') { 
								$rev_days = $publication[0]['rev_days'];
								if($rev_days =='0'){ 
						?>
							<a href="<?php echo base_url().index_page().'new_client/home/new_order_revision/'.$row['id'];?>" data-toggle="tooltip" title="Revision" >
							<img class="action-img" src="<?php echo base_url(); ?>assets/new_client/img/revision.png"></a>
						
						<?php }else{ 
								$date = date("Y-m-d",strtotime($row['created_on']));
								$rev_allowed = date('Y-m-d', strtotime($date. '+'.$rev_days.' days'));
								$today = date('Y-m-d');
						
								if($today >= $date && $today <= $rev_allowed ){ 
						?>
							<a href="<?php echo base_url().index_page().'new_client/home/new_order_revision/'.$row['id'];?>" data-toggle="tooltip" title="Revision" >
							<img class="action-img" src="<?php echo base_url(); ?>assets/new_client/img/revision.png"></a>
							
						<?php } } } ?>
					</td>
					
<!-- View -->	
					<td class="center width-30" title="View">
						<a href="<?php echo base_url().index_page().'new_client/home/order_action/view/'.$row['id'];?>" data-toggle="tooltip" title="View" >
						<img class="action-img" src="<?php echo base_url(); ?>assets/new_client/img/order_view.png"></a>
					</td>
<!-- Attachments -->						
					<td class="center width-30">
					<?php if($status_id=='1' || $status_id=='2' || $status_id=='3') {?>
							<a href="<?php echo base_url().index_page().'new_client/home/order_action/'.'attachments'.'/'.$row['id'];?>" data-toggle="tooltip" title="Attachments" >
							<img class="action-img" src="<?php echo base_url(); ?>assets/new_client/img/attachment.png"></a>
						<?php }else{ echo""; } ?>
					</td>
					<!--<td class="center"><a class="btn btn-block btn-xs padding-5 btn-success">Approve</a></td>-->
<!-- PDF -->
					<td class="center width-30" title="PDF">
						<?php if($pdf_path != 'none' && file_exists($pdf_path)){ ?>
						<a href="<?php echo base_url().$pdf_path;?>" data-toggle="tooltip" title="<?php if(isset($note['id'])){ echo $note['note']; }else{ echo"PDF"; } ?>" data-placement="top" target="_blank" style="cursor:pointer; text-decoration: none;">
						<img class="action-img" src="<?php echo base_url(); ?>assets/new_client/img/pdf.png"></a>
						<?php  }else{ echo ''; }?>
					</td>
<!-- Actions -->							
						<?php if($pdf_path != 'none'){ ?>
		<!-- Approve Unapprove -->
							<?php if($order_status == 'Approved'){ ?>
								<td>
									<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_client/home/unapprove_order/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;">
									<button class="btn btn-block btn-xs padding-5 btn-danger">Unapprove</button></a>
								</td> 
							<?php }else{ ?>
								<td title="Job Approval">
								<?php if($publication[0]['id']=='190'){ ?> 
									<a href="<?php echo base_url().index_page().'new_client/home/approval/'.$row['id'] ;?>">
									<button class="btn btn-block btn-xs padding-5 btn-success">Approve</button>
									</a>
								<?php }elseif(in_array($publication[0]['id'], $pub_permit)){ //Lethbridge herald, Taber times popup modal ?>
								
								 <!-- Approve popup modal code START-->   
								    <button class="modal-button btn btn-block btn-xs padding-5 btn-success" href="#myModal<?php echo $row['id']; ?>">Approve</button>
								    <!-- The Modal -->
                                    <div id="myModal<?php echo $row['id']; ?>" class="modal">
                                    
                                      <!-- Modal content -->
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <span class="close">×</span>
                                          <h4>Approve Ad <?php echo $row['id']; ?></h4>
                                        </div>  
                                        <div class="table-responsive border padding-15"> 
                                            <table class="table table-striped table-bordered table-hover" id="tracker_table">
                            					<thead>
                            						<tr>
                            							<td width="30%"><b>Publication List</b></td>
                            						</tr>  									
                            					</thead>
                            					<tbody>
                            					    <form id="myForm<?php echo $row['id']; ?>" class="myForm" data-id="<?php echo $row['id']; ?>" method="post" action="<?php echo base_url().index_page().'new_client/home/jRate/'.$row['id'];?>">
                                                    <?php 
                                                        $sub_pub = $this->db->get_where('pub_project', array('pub_id' => '45'))->result_array();
                                                        foreach($sub_pub as $prow){ 
                                                    ?>
                                                        <tr> 
							                                <td>
							                                    <p><input type="checkbox" class="individual pub<?php echo $row['id']; ?>" name="pub[]" value="<?php echo $prow['initial']; ?>"><?php echo $prow['name'].' ('.$prow['initial'].')'; ?> </p> 
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                    <tr>
                                                        <td><button type="submit" name="submit" class="btn btn-blue pull-right margin-5" >SUBMIT</button></td>
                                                    </tr>
                                                    </form>
                                        
                            					</tbody>
                            				</table>
                                        </div>
                                        
                                      </div>
                                    
                                    </div>
                                <!-- Approve popup modal code --> 
                                
								<?php }else{ ?>
									<a href="<?php echo base_url().index_page().'new_client/home/jRate/'.$row['id'] ;?>" 
										onclick="javascript:void window.open('<?php echo base_url().index_page().'new_client/home/jRate/'.$row['id'];?>','1432728298066','width=515,height=228,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=50,top=20');return false;">
									<button class="btn btn-block btn-xs padding-5 btn-success">Approve</button>
									</a>
								<?php } ?>
								</td>
							<?php } ?>
		<!-- cancel -->
					<?php }elseif($row['cancel'] != '0'){ ?>
			<!--Resubmit -->
						<td><a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_client/home/resubmit_form/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;"><button class="btn btn-block btn-xs padding-5 btn-blue" >Resubmit</button></a></td>
						
							
							
					<?php }elseif($row['crequest']!='0'){ ?>
							<td style="cursor:pointer;">
							<form method="post" action="<?php echo base_url().index_page().'new_client/home/order_cancel/'.$row['id'];?>">
			<!--cancel req accept -->
								<button type="submit" name="remove" id="remove" class="btn btn-block btn-xs padding-5 btn-grey" onclick="return confirm('Are you sure you want to accept order cancellation ?');">Accept</button>
							</form>	 
			<!--cancel req reject -->
								<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_client/home/reject_v2/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;"><button class="btn btn-block btn-xs padding-5 btn-grey" >Reject</button></a>
							</td>
					<?php }elseif(!$orders_rev && $row['status'] != '5'){ ?>
			<!--cancel button -->
						<!--	<td title="Job Cancel">
								<form method="post" action="<?php echo base_url().index_page().'new_client/home/order_cancel/'.$row['id'];?>">
									<button type="submit" name="remove" id="remove" class="btn btn-block btn-xs padding-5 btn-grey" onclick="return confirm('Are you sure you want to cancel ?');">Cancel</button>
								</form>
							</td>-->
							
							
							<td title="Job Cancel">
								<span class="dropdown text-grey">
								<span class="btn btn-block btn-xs padding-5 btn-grey cursor-pointer padding-left-5" type="button" data-toggle="dropdown" id="view">Cancel</span>
										<div class="dropdown-menu file_li padding-10">  							 
											<p class="margin-bottom-5">Are you sure?</p>
											<div class="row">
												<div class="col-xs-6 padding-right-5">
													<form method="post" action="<?php echo base_url().index_page().'new_client/home/order_cancel/'.$row['id'];?>">
													<button type="submit" name="remove" id="remove" class="btn btn-success btn-xs padding-5 padding-horizontal-20 margin-right-5 btn-block">Yes</button>
													</form>
												</div>
												<div class="col-xs-6 padding-left-5">
													<button class="btn btn-primary btn-xs padding-5 padding-horizontal-20 btn-block">No</button>
												</div>
											</div>
									
								</span>
							</td>
							
							
					<?php }else{ echo'<td></td>'; } ?>
				
					</tr>
				<?php } ?>
					 
 
				   </tbody>  
					<?php } ?>
					                      
				</table>
			
		<?php if((isset($orders[0]['id']) || isset($tl_orders[0]['id'])) && (isset($order_count) && isset($offset) && isset($rowsPerPage))){ ?>	
			<div class="row margin-top-10">  	
				<div class="col-md-6 pull-right text-right prev-next-page">
				<?php 
					$a = $offset + 1;
					if(isset($orders[0]['id'])){
						if(count($orders) == $rowsPerPage){ $next = $num + 1; $z = $offset + $rowsPerPage; }else{ $z = $order_count; }
					}
					if(isset($tl_orders[0]['id'])){
						if(count($tl_orders) == $rowsPerPage){ $next = $num + 1; $z = $offset + $rowsPerPage; }else{ $z = $order_count; }
					}
					if($num > 1){ $back = $num - 1; }
					$key = "?input=&keyword=".$keyword."&from_dt=".$from."&to_dt=".$to."&status=".$status."&team_adrep_id=".$team_adrep_id."&project_id=".$project_id."&ad_type=".$ad_type."&adv_search=";
				?>
			<!--	
				<?php if(isset($back)){ ?>
					<a href="<?php echo base_url().index_page().'new_client/home/search_order/'.$back.$key; ?>" title="Back">
					<button class="btn btn-dark btn-outline btn-sm margin-right-5"><i class="fa fa-arrow-left"></i></button>
					</a>
				<?php } ?>
				<?php if(isset($next)){ ?>
					<a href="<?php echo base_url().index_page().'new_client/home/search_order/'.$next.$key; ?>" title="Next">
					<button class="btn btn-dark btn-outline btn-sm">2</button>
					</a>
				<?php } ?>
			-->	
				<?php 
				    $x = ceil($order_count / 10);
				    $start_index = 1 ;
				    if($num > 6){ $start_index = $num - 6; }
				    if($x <= 9){ $end_index = $x; }elseif(($x-$num) > 6){ $end_index = $num + 6; }else{ $end_index = $x; }
				    for($i=$start_index; $i<=$end_index; $i++){
				        $class = "btn btn-dark btn-outline btn-sm pagination-btn";
				        if($i == $num) $class = "btn btn-dark btn-outline btn-sm pagination-btn active";
				            
				        
				 ?>
				 <a href="<?php echo base_url().index_page().'new_client/home/search_order/'.$i.$key; ?>" title="Next">
					<button class="<?php echo $class;?>"><?php echo $i; ?></button>
					</a>
				 <?php
				    }
				?>
				</div>
				<div class="col-md-6 margin-top-5"><?php echo "Showing ".$a." to ".$z." of ".$order_count." entries"; ?></div>
			</div>
		<?php } ?>
			


				
			 </div>
			 		                               
		 </div>

	</div>
<!-- Approve popup modal code -->
    <script>
        // Get the button that opens the modal
        var btn = document.querySelectorAll("button.modal-button");
        
        // All page modals
        var modals = document.querySelectorAll('.modal');
        
        // Get the <span> element that closes the modal
        var spans = document.getElementsByClassName("close");
        
        // When the user clicks the button, open the modal
        for (var i = 0; i < btn.length; i++) {
         btn[i].onclick = function(e) {
            e.preventDefault();
            modal = document.querySelector(e.target.getAttribute("href"));
            modal.style.display = "block";
         }
        }
        
        // When the user clicks on <span> (x), close the modal
        for (var i = 0; i < spans.length; i++) {
         spans[i].onclick = function() {
            for (var index in modals) {
              if (typeof modals[index].style !== 'undefined') modals[index].style.display = "none";    
            }
         }
        }
        
        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
             for (var index in modals) {
              if (typeof modals[index].style !== 'undefined') modals[index].style.display = "none";    
             }
            }
        }
    </script>
    <script>
            $('.myForm').submit(function(){
                var id = $(this).data('id');
                //alert($('.pub'+id+':checked').length);
                if($('.pub'+id+':checked').length < 1){
                   alert('Select Publication..!!'); 
                   return false;
                }
                return true;
            });
    </script>
<!-- Approve popup modal code -->