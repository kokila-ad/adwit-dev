<?php $this->load->view("new_csr/head.php"); ?>
<style>
.tabletools-btn-group {
		display: none !important;
}
.word-wrap-name{
	max-width: 250px;
	word-wrap: break-word;
}
</style>
<script>
    setTimeout(function(){
       window.location.reload(1);
    }, 50000);
    
$(document).ready(function () {
    localStorage.removeItem('selected_display');
    localStorage.removeItem('selected_date');
});
</script>

<script>
   function Refresh() {
        window.parent.location = window.parent.location.href;
		<?php 
				$current_time = date("H:i:s"); 
		?>
    }
</script>

<script type="text/javascript">
	$(document).ready(function(e) {
	   
        $('#help_desk').change(function(e) {
            window.location = "<?php echo base_url().index_page().'new_csr/home/frontlinetrack_all/';?>" + $('#help_desk').val() ;
        });
    });
</script>

<script type="text/javascript">
	$(document).ready(function(e) {
	   
        $('#display_type').change(function(e) {
		
            window.location = "<?php echo base_url().index_page().'new_csr/home/frontlinetrack_';?>" + $('#display_type').val() + "<?php echo '/'.$form; ?>" ;
        });
    });
</script>

<div class="page-container">
	<!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
		<div class="container">
        <div class="row">
        <div class="col-lg-12">
        <div class="navbar navbar-default" role="navigation">
								<!-- Brand and toggle get grouped for better mobile display -->
								<div class="navbar-header">
									<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
									<span class="sr-only">
									Toggle navigation </span>
									<span class="icon-bar">
									</span>
									<span class="icon-bar">
									</span>
									<span class="icon-bar">
									</span>
									</button>
									<?php  $type = $this->db->get_where('help_desk',array('active'=>'1','id'=>$form))->row_array(); ?>
									<a class="navbar-brand" href="javascript:;">
									<?php if(isset($type['id'])) echo $type['name']; ?> </a>
									<a class="navbar-brand" href="javascript:;"><?php echo $this->session->flashdata('sold_status');?></a>
									
									
								</div>
								<!-- Collect the nav links, forms, and other content for toggling -->
								<div class="collapse navbar-collapse navbar-ex1-collapse">
									<ul class="nav navbar-nav navbar-right">
									<?php if($form=='2'){ ?>
									<li class="margin-top-10">
									   <form class="search-form"  name="form" method="get" action="<?php echo base_url().index_page()."new_csr/home/metro_revision/".$form; ?>">
											<div class="col-sm-8"  style="padding: 0;">
												<input type="text" class="form-control" placeholder="Metro Order Search" name="orderId" required>
												<!--<input name="form" value="<?php echo $form;?>" readonly style="display:none;" />-->
											</div>
											<div class="col-sm-4"  style="padding: 0;">
												<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
											</div>		
									   </form>
									</li>
									 <?php } ?>
									 
									<!--<li>
										<select id="display_type" name="display_type" class="margin-top-10 form-control padding-0">
										   <option value="all" <?php echo ($display_type=='all' ? 'selected="selected"' : ''); ?> >All</option>
										   <option value="pending" <?php echo ($display_type=='pending' ? 'selected="selected"' : ''); ?> >Pending</option>
										</select>
									</li>-->
									<?php if($form=='12'){ ?>
										<li>
											<a onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/vidn_rev_entries';?>'" href="javascript:;">
											Vidn Entries </a>
										</li>
									<?php } ?>
									<?php $help_desk1 = $this->db->query("SELECT * FROM `help_desk` WHERE `id` = '$form' AND `sold` = '1'")->result_array();
									if($help_desk1) { ?>
									<li>
										<a href="<?php echo base_url().index_page().'new_csr/home/sold_track/'.$form;?>" target="_blank" href="javascript:;">				
										Sold Orders</a>								
									</li><?php } ?>
									<li>
										<a href="<?php echo base_url().index_page().'new_csr/home/revision/'.$form;?>" target="_blank" href="javascript:;">				
										Create Revision</a>								
									</li>
									<!--<li>
										<a href="<?php echo base_url().index_page().'new_csr/home/frontlinetrack_all/'.$form;?>" href="javascript:;">All</a>						
									</li>-->
									<?php if(isset($rev_classification) && $form == '10'){ foreach($rev_classification as $classification){ ?>
									<li>
										<a href="<?php echo base_url().index_page().'new_csr/home/frontlinetrack_all/'.$form.'/'.$display_type.'/'.$classification['id'];?>" href="javascript:;">				
										<?php echo $classification['name']; ?></a>								
									</li>
									<?php } } ?>
										<li class="dropdown">
											<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
											Select Desk &nbsp;<i class="fa fa-angle-down"></i>
											</a>
											<ul class="dropdown-menu">
											<?php 
											$types = $this->db->get_where('help_desk',array('active'=>'1'))->result_array();
											foreach($types as $type)
				{ ?>
				                                
												<li>
													<a href="<?php echo base_url().index_page().'new_csr/home/frontlinetrack_all/';?><?php echo $type['id']; ?>">
													<?php echo $type['name']; ?> </a>
												</li>
												<?php } ?>
											</ul>
										</li>
										
									</ul>
								</div>
								<!-- /.navbar-collapse -->
							</div>
        </div>
        </div>
		
        <div class="row">
        <div class="col-md-12">
		<?php echo '<span style="color:#900;">'.$this->session->flashdata('message').'</span>'; ?>
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption margin-right-10">
								<i class="fa fa-cogs font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold uppercase"><?php echo $display_type; ?></span>
							</div> 
							<div class="caption">
    							<form method="post">
    								<input type="submit" name="date" <?php if(isset($date) && $date == $qystday) echo'class="btn btn-xs blue"'; else echo'class="btn btn-xs green"'; ?> value="<?php echo $qystday; ?>" /> 
    								<input type="submit" name="date" <?php if(isset($date) && $date == $pystday) echo'class="btn btn-xs blue"'; else echo'class="btn btn-xs green"'; ?> value="<?php echo $pystday; ?>" /> 
    								<input type="submit" name="date" <?php if(isset($date) && $date == $ystday) echo'class="btn btn-xs blue"'; else echo'class="btn btn-xs green"'; ?> value="<?php echo $ystday; ?>" /> 
    								<input type="submit" name="date" <?php if(isset($date) && $date == $today) echo'class="btn btn-xs blue"'; else echo'class="btn btn-xs green"'; ?> value="<?php echo $today; ?>" /> 
    							</form>
							</div>
							<div class="tools">
								<button class="btn bg-grey btn-sm" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Excel</button>
								<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()"></a>
							</div>
						</div>
						<div class="portlet-body">
							<table class="table table-striped table-bordered table-hover" id="sample_6">
										<thead>											
										<tr>
											    <th>No.</th>
											    <th>Type</th>
												<th>Job No.</th>												
							<!--					<th>New</th>												
												<th>Pickup</th>		-->										
												<th>Revision</th> 										
				<!--	<?php if($form!='5') { ?>   <th>Sold</th>     <?php } ?>-->
												<th>Designer</th>
												<th>Time Left</th>
												<th>Time Sent</th>
												<th>Time Taken</th>
												<!--<th rowspan="2"style="vertical-align: middle;">Inst/<br/>Attch</th>-->
												<th>PDF</th>
												<th>Classification</th>
												
				<?php if($this->session->userdata('sId') == '68'){  echo '<th>Action</th>'; } ?>						
										</tr>
										</thead> 
											
										<tbody name="testTable" id="testTable">	
<?php
    $count = '0'; $cat_time = '0'; $timer = '0';
    
	$hd_name = $this->db->get_where('help_desk',array('id' => $form))->result_array();
	
	$query = "SELECT rev_sold_jobs.*, orders.order_type_id  FROM rev_sold_jobs
	                JOIN `orders` ON orders.id = rev_sold_jobs.order_id ";
	                
	if($form == '20'){ //if pagination help desk display oly pagination orders irrespective of hd
	    $query .= "WHERE rev_sold_jobs.order_id != '' AND orders.order_type_id = '6' ";    
	}else{
	    $query .= "WHERE rev_sold_jobs.order_id != '' AND rev_sold_jobs.help_desk = '$form' AND orders.order_type_id != '6' ";
	}
	
	if($display_type=='pending'){
	    $query .= " AND rev_sold_jobs.sent_time = '00:00:00' AND rev_sold_jobs.job_status = '1' ";
		if(isset($date)){
			$query .= " AND rev_sold_jobs.date = '$date' ";
		
		}else{
			$query .= " AND rev_sold_jobs.date = '$today' ";
			
		}
	}

	if($display_type=='all')
	{ 
	 	if(isset($date)){
			if(isset($rev_class_id) && $rev_class_id != '' && $form == '10'){
				$query .= " AND rev_sold_jobs.date = '$date' AND rev_sold_jobs.classification = '$rev_class_id' ";
			}else{
				$query .= " AND rev_sold_jobs.date = '$date' ";
			} 
		}else{
			if(isset($rev_class_id) && $rev_class_id != '' && $form == '10'){
				$query .= " AND rev_sold_jobs.date = '$today' AND rev_sold_jobs.classification = '$rev_class_id' ";
			}else{
				$query .= " AND rev_sold_jobs.date = '$today' ";
			}
		}
		
	}
	
	$query .= " ORDER BY rev_sold_jobs.id ASC";	
	$jobs = $this->db->query("$query")->result_array();
	
	$i=0;
	foreach($jobs as $row){
	    if($row['designer']!='0'){
			$designer = $this->db->get_where('designers',array('id' => $row['designer']))->result_array();
		}
		$count--; 
		$time_left = '0';
		//$count = sprintf('%03d',$count);
		$start = strtotime($row['time']);
		$end = strtotime($current_time);
		$time_left = $end - $start ; 
		$time_left = $time_left / 60;
		$time_left_rnd = round($time_left,0);
		$frontline_timer = $this->db->get('frontline_timer')->result_array();
		if($row['classification']!='0'){ $rev_classification = $this->db->get_where('rev_classification',array('id' => $row['classification']))->row_array(); }
		foreach($frontline_timer as $row1){
			if($row['category'] == $row1['cat_name']){ $cat_time = $row1['duration']; }
		}
?>										
							 <tr <?php if($row['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo 'class="bg-red-pink"'; } ?>>
										<td><?php echo $count ; ?></td>
		    	<!-- type -->			<td>
											<span class="badge bg-blue">
											    <?php if($row['order_type_id']=='2'){echo "P";} elseif($row['order_type_id']=='1'){ echo "W";} elseif($row['order_type_id']=='6'){ echo "PG";} else{ echo "P&W";}?>
											</span>
										</td>							
										<td class="word-wrap-name">
											<a <?php if($row['rush']==1){ echo "class='font-grey-cararra'";} ?> href="<?php echo base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row['order_id'];?>">
												<?php echo $row['order_no']; ?>
											</a>
										</td>
										
										
										<td><?php if($row['category']=='revision'){ echo $row['time'];} ?></td>  
										
		<!--	<?php if($form!='5') { ?>	<td><?php if($row['category']=='sold'){ echo $row['time'];} ?></td>  <?php } ?> -->
										
										<td><?php if($row['designer']!='0'){ echo $designer[0]['username']; } ?></td>
										
                                        <td><?php	
												if($row['status']=='5' || $row['status']=='8'){
													echo '';
												}elseif($time_left < $cat_time && $row['sent_time']=='00:00:00'){ 
													$timer = $cat_time - $time_left ;  
													if($timer<= '5'){
														echo "<font color='red'>". round($timer,0)." min </font>";
													}else{ echo round($timer,0)." mins"; }
												}else{ echo "Elapsed"; } 
											?>
										</td>
	<!--time sent -->						
										
										<td>
											<?php if($row['job_status']=='1'){ 
														if($row['question']=='1'){ 
															echo'<button>Question Sent</button>';
														}elseif($row['sent_time']!='00:00:00' && $row['status'] != '8'){ 
																//echo $row['sent_time'] ; ?>
																<a href="<?php echo base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row['order_id'];?>">
																	<button type="button" id="accept" class="btn btn-sm btn-primary">Sent</button>
																</a>
															<?php }elseif($row['sent_time']!='00:00:00' && $row['status'] == '8'){ echo $row['sent_time'] ; ?>
														<?php }else{ ?>
															<form method="post" enctype="multipart/form-data">
																	<?php if($row['sold_pdf'] != 'none' && $row['frontline_csr'] == '0' && $row['status'] == '8') { ?>
																	<button type="submit" name="Submit" class="btn btn-sm btn-primary">Send</button>
																	<?php }elseif($row['sold_pdf'] != 'none' && $row['status'] == '4') { ?>
																	<button type="submit" name="send_sold" class="btn btn-sm btn-primary">Send</button>
																	<?php }elseif($row['sold_pdf']=='none' && $row['status'] == '8'){ ?>
																		<div class="btn-group">
																		 <a href="<?php echo base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row['order_id'];?>">
																			<button type="button" id="accept" class="btn btn-sm btn-primary">In Production</button>
																		 </a>
																		</div>
																	<?php }elseif($row['job_accept']=='0' && $row['order_id']!=''){ ?>
																		<div class="btn-group">
																		 <a href="<?php echo base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row['order_id'];?>">
																			<button type="button" id="accept" class="btn btn-sm btn-primary">Accept</button>
																		 </a>
																		</div>
																	<?php }elseif($row['source_file']!='none'&&$row['status']=='4'){ ?> 
																		<a href="<?php echo base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row['order_id'];?>">
																		<button type="button" id="accept" class="btn btn-sm btn-primary">ReadyForQA</button>
																		</a>
																	<?php }elseif($row['sold_pdf']!='none'&&$row['status']=='4'){ ?> 
																		<a href="<?php echo base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row['order_id'];?>">
																		<button type="button" id="accept" class="btn btn-sm btn-primary">ReadyForQA</button>
																		</a>
																	<?php }elseif($row['sold_pdf']!='none'&&$row['status']=='5'&&$row['new_slug']!='none'){ ?> 
																		<a href="<?php echo base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row['order_id'];?>">
																		<button type="button" id="accept" class="btn btn-sm btn-primary">ProofReady</button>
																		</a>
																	<?php }elseif($row['new_slug']!='none'){ ?>
																		<a href="<?php echo base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row['order_id'];?>">
																		<button type="button" id="accept" class="btn btn-sm btn-primary">In Production</button>
																		</a>
																	<?php }elseif($row['status']=='2'){ ?>
																		<a href="<?php echo base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row['order_id'];?>">
																		<button type="button" id="accept" class="btn btn-sm btn-primary">Accepted</button>
																		</a>
																	<?php } ?>
																	<input name="id" value="<?php echo $row['id'];?>" readonly style="display:none;" />
																	<input name="new_slug" value="<?php echo $row['new_slug'];?>" readonly style="display:none;" />
																	<input name="adrep" value="<?php echo $row['adrep'];?>" readonly style="display:none;" />
																	<?php if(isset($date)){ ?><input name="date" value="<?php echo $date;?>" readonly style="display:none;" /><?php } ?>
															</form>
												
													<?php } }else{ echo "<font color='blue'>removed</font>"; } ?>
										</td>	
	<!--time sent end -->											
										<td>
											<?php if($row['time_taken']!='0')
												  { 
													//calculating hours, minutes and seconds (as floating point values)
													$hours = $row['time_taken'] / 3600; //one hour has 3600 seconds
													$minutes = ($hours - floor($hours)) * 60;
													$seconds = ($minutes - floor($minutes)) * 60;

													//formatting hours, minutes and seconds
													$final_hours = floor($hours);
													$final_minutes = floor($minutes);
													$final_seconds = floor($seconds);

													//output
													echo $final_hours . ":" . $final_minutes . ":" . $final_seconds; 
												  } 
											?>												  
										</td>
										
										<?php if($row['category']!='sold') { ?>
										<td>
											<?php if($row['pdf_path']!='none' && file_exists($row['pdf_path'])){
														$pdf_path = base_url().$row['pdf_path'];   ?>
												<a href="<?php echo $pdf_path;?>" target="_blank" style="cursor:pointer; text-decoration: none;"><img src="<?php echo base_url()?>images/pdf.png" alt="pdf"/></a>
											<?php }else{ echo' '; }  ?> 
										</td><?php }else{ ?>
										<td>
											<?php $cat = $this->db->get_where('cat_result',array('order_no' => $row['order_id']))->result_array();
													$sold_pdf_path = 'sold_pdf/'.$row['order_id'].'/'.$cat[0]['slug'];
													if(isset($sold_pdf_path) && $row['sold_pdf']!='none'){ 
													$map1 = $sold_pdf_path.'/'.$row['sold_pdf'];
														if(file_exists($map1)){	   ?>
													<a href="<?php echo base_url()?><?php echo $map1 ;?>" target="_blank" style="cursor:pointer; text-decoration: none;"><img src="<?php echo base_url()?>images/pdf.png" alt="pdf"/></a>
													<?php  }else{ echo' '; } } ?> 
										</td>
										<?php } ?>
								
										<td><?php if($row['classification']!='0'){ echo $rev_classification['name']; } ?></td>
										
										<?php 
										    if($this->session->userdata('sId') == '68'){
										        if($row['status'] != '5'){
										           echo '<td><button onclick="deleteItem('.$row['id'].')">Delete</button></td>';
										        }else{ 
										            echo '<td></td>';  
										        }
										    }
										?>	
							</tr>
<?php $i++; } ?>											
										</tbody>
									</table>
                                </div>
                            </div>
                        </div>
                        </div>

  </div>
  </div>
  </div>
 <?php $this->load->view("new_csr/foot.php"); ?> 

<script>
    function deleteItem(revId) {
        if (confirm("Are you sure?")) {
            // your deletion code
            $.ajax({
              url: '<?php echo base_url().index_page();?>new_csr/home/revision_order_deletion',
              data:'rev_id='+revId,
              type: 'POST',
              success: function(data) {
                alert(data);
                location.reload();
              }
            });
        }
        return false;
    } 
</script>