<?php $this->load->view('new_admin/header'); ?>

<style>
	.note-grey, .note-grey i { background-color: #f3f5f6 !important; color: #b8b4b4 !important; border-color: #d7d7d7 !important; }  
	.flat-radio div.radio {	display: none; }
	 .light-grey, .light-grey i { background-color: #f3f5f6 !important; color: #b8b4b4 !important; border-color: #d7d7d7 !important;	}
	 .border-bottom: 1px solid #ccc;
</style>

<script>
	$(document).ready(function(){
		$("#subrev").hide();

		$("#show_subrev").click(function(){
		$("#subrev").toggle();     
		});
	});
</script>

    <div class="row static-info">
			        <div class="col-sm-6 value ">
			            Adrep: <?php if(isset($adrep_name[0]['first_name'])) echo $adrep_name[0]['first_name'].' '.$adrep_name[0]['last_name']; ?>
			        </div>
			        <div class="col-sm-6 value text-right">
			            Publication: <?php if(isset($pub_name[0]['name'])) echo $pub_name[0]['name']; ?>
			        </div>
	</div>
			<!--------------New Ad Orderview_History Starts----------------->

<?php if(!isset($rev_orders)){ ?>
				
				
<div class="portlet light">
<!--V1 Files-->	
	<div class="portlet-title">
		<div class="row static-info">
		<?php if(isset($cat)){ ?>
			<div class="col-md-7 col-sm-12 value  margin-top-15 font-grey-gallery">V1 &nbsp;
			<?php if(isset($note_newad)){ ?>
				<span class="margin-right-10 font-yellow tooltips" data-container="body" data-placement="top" data-original-title="<?php echo $note_newad['note']; ?>"><i class="fa fa-warning"></i></span>
				<?php } ?> 
				<?php if(isset($cat) && $cat[0]['pro_status']!='0'){ 
						$status = $this->db->query("SELECT * FROM `production_status` WHERE id='".$cat[0]['pro_status']."'")->result_array();
							if($status) { ?>
				<span class="font-green tooltips" data-container="body" data-placement="top" data-original-title="<?php echo $status[0]['name'] ;?>"><i class="fa fa-check-circle font-lg"></i></span>
				<?php } else { echo " "; } } ?>
			</div>
			<?php  if(isset($sourcefile) && file_exists($sourcefile)) { 
					$map2 = glob($sourcefile.'/'.$cat[0]['slug'].'.{indd,psd}',GLOB_BRACE); 
					$map3 = glob($sourcefile.'/'.$cat[0]['slug'].'.{pdf,jpg,gif,png}',GLOB_BRACE); 
					$source_zip_file = $sourcefile.'/'.$cat[0]['slug'].'.zip' ;
			?>
			<div class="col-md-5 col-sm-12 value bold margin-top-10 no-space text-right">
				<?php if($cat[0]['pdf_path']!='none'){ ?>
				<div class="col-md-3 col-sm-3 col-xs-6 pull-right margin-bottom-5">
					<a href="<?php echo base_url().''.$cat[0]['pdf_path'];?>" target="_Blank" class="btn grey btn-sm btn-block">PDF</a>
				</div>
				<?php } if(file_exists($source_zip_file)){ ?>
				
				<div class="col-md-2 col-sm-3 col-xs-6 pull-right  no-space margin-bottom-5">
					<a href="<?php echo base_url()?><?php echo $source_zip_file ?>" class="btn grey btn-sm  btn-block">Package</a>
				</div>
				
				<?php } else {
					if($map2){ 
						if($map3){ foreach($map3 as $row_map3){ $pdf_file = basename($row_map3); } }
							foreach($map2 as $row_map2){ $source_file = basename($row_map2); }
				?>
				<div class="col-md-2 col-sm-3 col-xs-6 pull-right  no-space margin-bottom-5">
					<form action="<?php echo base_url().'index.php/new_admin/home/zip_folder_select'?>" method="post">
						<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
						<input name="new_slug" value="<?php echo $cat[0]['slug'];?>" readonly style="display:none;" />
						<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
						<input name="download" value="download" readonly style="display:none;" />
						<button type="submit" name="SourceDownload" class="btn grey btn-sm  btn-block">Package</button>
					</form>
				</div> 
				<?php } }?>
				<?php if(isset($order_form) && file_exists($order_form)) { 
						$order_map = glob($order_form.'/*',GLOB_BRACE);
						if($order_map) { ?>
				<div class="col-md-3 col-sm-3 col-xs-6 pull-right margin-bottom-5">
					<form method="post" action="<?php echo base_url().index_page().'new_admin/home/zip_folder';?>">
						<input name="file_path" value="<?php echo $order_form; ?>" readonly style="display:none;" /> 
						<input name="file_name" value="<?php echo $order_id; ?>" readonly style="display:none;" />
						<button type="submit" name="Submit" class="btn grey btn-sm btn-block">
							Download
						</button>	
					</form>
				</div>
				<?php } } ?>
			</div>
			<?php }elseif(isset($cat[0]['ftp_source_path']) && $cat[0]['ftp_source_path'] != ''){ ?>
			    <div class="col-md-2 col-sm-3 col-xs-6 pull-right  no-space margin-bottom-5">
					<a href="<?php echo base_url()?><?php echo $cat[0]['ftp_source_path'] ?>" class="btn grey btn-sm  btn-block">Package</a>
				</div>
			<?php } ?>
		 <?php } ?>	
		 </div>
	</div>
<!--V1 Files--->
<div class="portlet-body">
<div class="row">
<!--------------------------------- Order Info --------------------------------------->
    <div class="col-md-12">
		<div class="portlet box blue-hoki">
			<div class="portlet-title">
				<div class="row static-info margin-top-10">
					<div class="col-md-10 value bold">Order Info</div>
				</div>
			</div>
			<div class="portlet-body">
				<div class="row">
					<div class="col-md-6">
					    <div class="row static-info margin-top-10">
							<div class="col-md-5 col-xs-5 name">Unique Job Name:</div>
							<div class="col-md-7 col-xs-7 value word-break"><?php echo $orders[0]['job_no'];?></div>
						</div>    
					</div>
					<div class="col-md-6">
					    <div class="row static-info margin-top-10">
							<div class="col-md-5 col-xs-5 name">Advertiser:</div>
							<div class="col-md-7 col-xs-7 value word-break"><?php echo $orders[0]['advertiser_name'];?></div>
						</div>    
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
					    <div class="row static-info margin-top-10">
							<div class="col-md-5 col-xs-5 name">Copy/Content:</div>
							<div class="col-md-7 col-xs-7 value word-break"><?php echo nl2br($orders[0]['copy_content_description']);?></div>
						</div>    
					</div>
					<div class="col-md-6">
					    <div class="row static-info margin-top-10">
							<div class="col-md-5 col-xs-5 name">Notes & Instructions:</div>
							<div class="col-md-7 col-xs-7 value word-break"><?php echo nl2br($orders[0]['notes']); ?></div>
						</div>    
					</div>
				</div>
			</div>
		</div>
	</div>
<!--------------------------------- Order Info ENDS ---------------------------------->
    
<!--Ad Design Details-->
	<div class="col-md-6">
		<div class="portlet box blue-hoki">
			<div class="portlet-title">
				<div class="row static-info margin-top-10">
					<div class="col-md-10 value bold">Ad Design Details</div>
				</div>
			</div>
			<div class="portlet-body">
				<div class="row">
					<div class="col-md-11 col-md-offset-1">
						<ul class="list-group">
							<?php if(isset($csr)){ ?>
							<li>  
								Ad Categorized by - <strong><?php echo $csr[0]['name']."	";  ?></strong>
							</li>
							<?php } if(isset($designer)){ ?>
							<li>
								Ad Designed by - <strong><?php echo $designer[0]['name']."	";  ?></strong>
							</li>
							<?php } if(isset($tl)){ ?>
							<li>
								Ad TL checked by - <!--<strong><?php echo $tl[0]['first_name']."	";  ?></strong>-->
							</li>
							<?php } if(isset($qa_name)){ ?>
							<li>
								Ad QA checked by - <strong><?php echo $qa_name[0]['name']."	";  ?></strong>
							</li>
							<?php } if(isset($csr_name1[0]['name'])){ ?>
							<li>
								Ad DC checked by - <strong><?php echo $csr_name1[0]['name']."	";  ?></strong>
							</li>
							<?php } ?>
							<li>
								NewAd Received Time - <strong><?php $date = date_create($orders[0]['created_on']); echo date_format($date, 'g:i A jS M, Y');?></strong>
							</li>
							<li>
								NewAd Sent Time - <strong><?php $date = date_create($orders[0]['pdf_timestamp']); echo date_format($date, 'g:i A jS M, Y');?></strong>
							</li>
							<li>
								Time Taken - <strong><?php if($days!='0')echo $days.'day(s)';if($hours!='0')echo ' '.$hours.'hour(s)';if($mins!='0')echo ' '.$mins.'min(s)';if($seconds!='0')echo ' '.$seconds.'second(s)';?></strong>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
<!--Ad Design Details-->
	
		
<div class="col-md-6">
<!--Conversations-->
	<div class="portlet box blue-hoki">
		<div class="portlet-title">
			<div class="row static-info  margin-top-10">
				<div class="col-md-10 value bold">Conversations</div>
			</div>
		</div>
		<div class="portlet-body">
			<div class="row">
			<div class="col-md-12 col-sm-12">
			 <div class="scroller" style="height:200px" data-always-visible="1" data-rail-visible="0">
					<?php
						$qustion = $this->db->query("SELECT * FROM `production_conversation` WHERE `order_id`='".$order_id."' order by `id` desc")->result_array(); 
						
						  if(!isset($qustion[0]['id'])){
							echo '<p class="text-center">'."No Conversations".'</p>';
						}  
						if($qustion) { $i=0; foreach($qustion as $qustion1) { $i++; 
									
					?>
						<!--TL_designer MESSAGE-->
						<?php if(($qustion1['tl_id']!='0') && ($qustion1['operation']=='tl_designer')){ 
									$tl = $this->db->query("SELECT * FROM `team_lead` WHERE `id`='".$qustion1['tl_id']."'")->result_array(); 
						?>
							<div <?php if($i=='1'){ echo'class="note note-danger"'; }else{ echo 'class="note note-grey"'; } ?>>
								<div class="row">
									<div class="col-sm-6">
										<?php echo $qustion1['message']; ?>
										<?php
											if(isset($tl_path)){ 
												$map = glob($tl_path.'/*.{jpg,png,tiff,gif,html,pdf,indd}',GLOB_BRACE);								
												if($map){			
													foreach($map as $row) {  
												?>
										<p class="margin-top-10"> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
										<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a></p>
										<?php } } } ?>
									</div>
									<div class="col-sm-6 text-right">
										<h4><?php   echo $tl[0]['first_name']; ?> (Team Lead) </h4>
										<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
									</div>
								</div>
							</div>
							<!--TL_designer MESSAGE-->
							
							
							<!--QA to designer MESSAGE-->
						<?php } 
								if(($qustion1['csr_id']!='0') && ($qustion1['operation']=='QA_designer')) { 
									$csr = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$qustion1['csr_id']."'")->result_array();   
						?>
							<div <?php if($i=='1'){ echo'class="note note-info"'; }else{ echo 'class="note note-grey"'; } ?>>
							
								<div class="row">
									<div class="col-sm-6">
									<?php echo $qustion1['message']; ?>
									<?php if(isset($csr_path)){ 
												$map = glob($csr_path.'/*.{jpg,png,gif,tiff,html,pdf,indd}',GLOB_BRACE);								
												if($map){			
													foreach($map as $row) {  
										?>
										 <p class="margin-top-10"> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
										<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a></p>
									<?php } } } ?>
									</div>
									<div class="col-sm-6 text-right">
										<h4><?php  echo $csr[0]['name'];  ?> (CSR) </h4>
										<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
									</div>
								</div>
							</div>
							<!--QA to designer MESSAGE-->
							
							<!--DC to designer MESSAGE-->
						<?php } if(($qustion1['dc_id']!='0') && ($qustion1['operation']=='DC_designer')) { $csr = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$qustion1['dc_id']."'")->result_array();   ?>		
							
							<div <?php if($i=='1'){ echo'class="note note-success"'; }else{ echo 'class="note note-grey"'; } ?>>
								<div class="row">
									<div class="col-sm-6">
										<?php echo $qustion1['message']; ?>
										<?php if(isset($dc_csr_path)){ 
										$map = glob($dc_csr_path.'/*.{jpg,png,gif,html,tiff,pdf,indd}',GLOB_BRACE);								
										if($map){			
											foreach($map as $row){  
										?>
										<p class="margin-top-10"> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
										<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a>
										</p>
										<?php } } } ?>
									</div>
									<div class="col-sm-6 text-right">
										<h4><?php  echo $csr[0]['name'];  ?> (CSR) </h4>
										<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
									</div>
								</div>
							</div>
							<!--DC to designer MESSAGE-->
							
							<!--designer msg-->
					<?php }  if($qustion1['designer_id']!='0') { $designer = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$qustion1['designer_id']."'")->result_array();   ?>		
							<div <?php if($i=='1'){ echo'class="note note-danger"'; }else{ echo 'class="note note-grey"'; } ?>>
								
								<div class="row">
									<div class="col-sm-6"><?php echo $qustion1['message']; ?></div>
									<div class="col-sm-6 text-right">
									<h4><?php echo $designer[0]['name'] ;?> (Designer)</h4>
										<span class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </span>
									</div>
								</div>
							</div>
						<!--designer mesg-->
						
						<!--TL to QA-->
					<?php } if(($qustion1['tl_id']!='0') && ($qustion1['operation']=='tl_QA')) { $tl = $this->db->query("SELECT * FROM `team_lead` WHERE `id`='".$qustion1['tl_id']."'")->result_array();   ?>
							<div <?php if($i=='1'){ echo'class="note note-info"'; }else{ echo 'class="note note-grey"'; } ?>>
								
								<div class="row">
									<div class="col-sm-6">
										<?php echo $qustion1['message']; ?>
									</div>
									<div class="col-sm-6 text-right">
										<h4><?php  echo $tl[0]['first_name'];  ?> (Team Lead) </h4>
										<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
									</div>
								</div>
							</div>
						<!--TL to QA -->
						
						<!--TL to DC -->
					<?php }  if(($qustion1['tl_id']!='0') && ($qustion1['operation']=='tl_DC')) { $tl = $this->db->query("SELECT * FROM `team_lead` WHERE `id`='".$qustion1['tl_id']."'")->result_array();   ?>
							<div <?php if($i=='1'){ echo'class="note note-success"'; }else{ echo 'class="note note-grey"'; } ?>>
								<div class="row">
									<div class="col-sm-6"><?php echo $qustion1['message']; ?></div>
									<div class="col-sm-6 text-right">
									<h4><?php  echo $tl[0]['first_name'];  ?> (Team Lead) </h4>
										<span class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </span>
									</div>
								</div>
							</div>
						<!--TL to DC-->
						
						<!--QA to DC-->
					<?php } if(($qustion1['csr_id']!='0') && ($qustion1['operation']=='QA_DC')) { $csr = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$qustion1['csr_id']."'")->result_array();   ?>
							<div <?php if($i=='1'){ echo'class="note note-danger"'; }else{ echo 'class="note note-grey"'; } ?>>
								
								<div class="row">
									<div class="col-sm-6"><?php echo $qustion1['message']; ?></div>
									<div class="col-sm-6 text-right">
									<h4><?php  echo $csr[0]['name'];  ?> (CSR) </h4>
										<span class="font-grey-cascade"><?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </span>
									</div>
								</div>
							</div>
						<!--QA to DC-->	
					<?php } } } ?>
			</div>	
			</div>
			</div>
		</div>
	</div>
<!--Conversations-->
<!--Question and Answer starts  -->
<?php foreach($orders as $row)
	if($row['question']=="1" || $row['question']=="2"){ ?>
<div class="row margin-top-20">
<div class="col-md-12">
	<div class="portlet box blue-hoki">
		<div class="portlet-title">
			<div class="caption static-info">
				<div class="value bold">Question & Answer </div>
			</div>	
			<div class="tools">
				<a href="javascript:;" class="expand" data-original-title="" title=""></a>
			</div>
		</div>
		<div class="portlet-body" style="display: none;">
			  <div class="scroller" style="height:180px" data-always-visible="1" data-rail-visible="0">
			  <?php $question = 	$this->db->query("SELECT * FROM `orders_Q_A` WHERE `order_id` = '$order_id' ORDER BY `id` DESC")->result_array();
				//$this->db->get_where('orders_Q_A',array('order_id' => $order_id))->result_array(); 
				?>
				<?php $iq='0'; foreach($question as $Qrow){ $iq++; ?>
				<?php $csr_name = 	$this->db->get_where('csr',array('id' => $Qrow['csr']))->result_array(); ?>
				<?php $adreps = 	$this->db->get_where('adreps',array('id' => $Qrow['adrep']))->result_array(); ?>
				<?php $Acsr_name = 	$this->db->get_where('csr',array('id' => $Qrow['Acsr']))->result_array(); ?>
				<div class="note note-danger">
					<div class="row">
						<div class="col-md-6"><h4><?php echo $csr_name[0]['name']; ?></h4></div>
						<?php if($Qrow['answer']==''){  ?>
						<div class="col-md-6 text-right">
								<span>
									<a class="btn btn-info btn-xs" id="show_csr_answer">Answer</a>
								</span>
						</div>
						<?php } ?>
					</div>
					<div class="row">
						<div class="col-md-6"><?php echo $Qrow['question']; ?></div>
						<div class="col-md-6 text-right">
							<span class="font-grey-cascade">Sent at - <?php $date = date_create($Qrow['Qtimestamp']); echo date_format($date, 'g:i A \o\n l jS F Y'); ?> </span>
						</div>
					</div>
				</div>
				<?php if($Qrow['answer']==''){  ?> 
				<div class="row" id="csr_answer">
					<form method="POST" action="<?php echo base_url().index_page().'new_csr/home/cshift_answer_v2/'.$order_id;?>" class="form-horizontal" role="form" enctype="multipart/form-data">
						<div class="col-md-6">
							<textarea rows="1" name="answer" class="form-control" placeholder="Answer goes here..."></textarea>
							<input type="file" name="ufile[]" id="ufile[]" class="margin-top-10" />
							<?php if(isset($redirect)){ ?>
							<input type="text" name="redirect" id="redirect" value="<?php echo $redirect; ?>"  readonly style="display:none" />
							<?php } ?>	
							<input type="text" name="qid" id="qid" value="<?php echo $Qrow['id']; ?>"  readonly style="display:none" />
							<button type="submit" class="btn btn-sm btn-primary margin-top-10 margin-bottom-10">Submit</button>
						</div>
					</form>
				</div>
				<?php } ?>
				<?php if(isset($adreps[0]['first_name'])) { ?>
				<div class="note note-success">
					<h4><?php echo $adreps[0]['first_name'] ?></h4>
					<div class="row">
						<div class="col-md-6"><?php echo $Qrow['answer']; ?></div>
						<div class="col-md-6 text-right">
							<span class="font-grey-cascade">Replied at - <?php $date = date_create($Qrow['Atimestamp']); echo date_format($date, 'g:i A \o\n l jS F Y'); ?></span>
						</div>
					</div>
				</div>
				<?php }elseif(isset($Acsr_name[0]['name'])){ ?>
				<div class="note note-warning">
					<h4><?php echo $Acsr_name[0]['name'] ?></h4>
					<div class="row">
						<div class="col-md-6"><?php echo $Qrow['answer']; ?></div>
						<div class="col-md-6 text-right">
							<span class="font-grey-cascade">Replied at - <?php $date = date_create($Qrow['Atimestamp']); echo date_format($date, 'g:i A \o\n l jS F Y'); ?></span>
						</div>
					</div>
				</div>
				<?php } ?>
				<?php } ?>
			  </div>
		</div>
	</div>
</div>
</div>	
<?php } ?>	
<!--Question and Answer  Ends  -->
</div>	
</div>	
</div>
</div>
<?php } ?>	
							<!--------------New Ad Orderview_History Ends----------------->
										
							<!-------------Revision Orderview_History Starts----------------->
<?php $i=0; if(isset($rev_orders)) { ?>


<?php 	
		foreach($rev_orders as $rev_row){ $i++;
				$note_revad = $this->db->get_where('note_sent',array('order_id'=>$order_id, 'revision_id'=>$rev_row['id']))->result_array();
?> 
<div class="portlet light">
	<div class="portlet-title"> 
		<div class="row static-info">
			<div class="col-md-7 col-sm-12 value  margin-top-15 font-grey-gallery"><?php echo $rev_row['version'] ;?> &nbsp;
				<?php if($note_revad){ ?>
				<span class="margin-right-10 font-yellow tooltips" data-container="body" data-placement="top" data-original-title="<?php echo $note_revad[0]['note']; ?>"><i class="fa fa-warning"></i></span>
				<?php } ?>
				<?php if( $rev_row['status']!='0'){ 
						$rev_status = $this->db->query("SELECT * FROM `rev_order_status` WHERE `id` = '".$rev_row['status']."'")->result_array();
						if($rev_status) { ?>
							<span class="font-green tooltips" data-container="body" data-placement="top" data-original-title="<?php echo $rev_status[0]['name'] ;?>"><i class="fa fa-check-circle font-lg"></i></span>
						<?php } else { echo " ";} } ?>
			</div>
			
			<div class="col-md-5 col-sm-12 value bold margin-top-10 no-space text-right">
				<!--PDF FILE-->
				<?php  if(isset($sourcefile) && file_exists($sourcefile)){
						$pdf_path = $sourcefile.'/'.$rev_row['pdf_file'];
							if(file_exists($pdf_path)){ ?>
					<div class="col-md-3 col-sm-3 col-xs-6 pull-right margin-bottom-5">
						<a class="btn grey btn-sm btn-block" href="<?php echo base_url().$pdf_path; ?>" target="_blank">
						PDF</a>
					</div>
				<?php } ?>
				<!--PDF FILE-->
				
				<!--Package-->
				<?php $source_zip_file = $sourcefile.'/'.$rev_row['new_slug'].'.zip' ;
						if(file_exists($source_zip_file)){ ?>
					<div class="col-md-2 col-sm-3 col-xs-6 pull-right  no-space margin-bottom-5">
						<a href="<?php echo base_url()?><?php echo $source_zip_file ?>" class="btn grey btn-sm  btn-block">Package</a>
					</div>	
						<?php } else { 
								//zip source
								$source_file = $rev_row['source_file'];
								$map2 = $sourcefile.'/'.$source_file;
								if(file_exists($map2)){	?>
								
					<div class="col-md-2 col-sm-3 col-xs-6 pull-right  no-space margin-bottom-5">
						<form action="<?php echo base_url().'index.php/new_admin/home/zip_folder_select'?>" method="post">
							<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
							<input name="pdf_file" value="<?php echo $rev_row['pdf_file'];?>" readonly style="display:none;" />
							<input name="new_slug" value="<?php echo $rev_row['new_slug'];?>" readonly style="display:none;" />
							<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
							<input name="download" value="download" readonly style="display:none;" />
							<button type="submit" name="SourceDownload" class="btn grey btn-sm  btn-block">Package</button>
						</form>
					</div> 
					<?php } } ?>
				<!--Package-->
					
				<!--Downloads-->
				<?php if($rev_row['file_path'] != 'none') { $rev_order_form = $rev_row['file_path'];
						if(isset($rev_order_form) && file_exists($rev_order_form)) { 
						$rev_map = glob($rev_order_form.'/*',GLOB_BRACE);
						if($rev_map) { ?>
				<div class="col-md-3 col-sm-3 col-xs-6 pull-right margin-bottom-5">
					<form method="post" action="<?php echo base_url().index_page().'new_admin/home/zip_folder';?>">
						<input name="file_path" value="<?php echo $rev_order_form; ?>" readonly style="display:none;" /> 
						<input name="file_name" value="<?php echo $order_id; ?>" readonly style="display:none;" />
						<button type="submit" name="Submit" class="btn grey btn-sm btn-block">Download</button>
					</form>
				</div>
				<?php } } } ?>
				<!--Downloads-->
				<?php }elseif($i==1){ ?>
				    <div class="col-md-2 col-sm-3 col-xs-6 pull-right  no-space margin-bottom-5">
    					<a href="<?php echo $cat[0]['ftp_source_path'] ?>" class="btn grey btn-sm  btn-block">Package</a>
    				</div>
    			<?php } ?>
			</div>
		 </div>
	</div>
	<div class="portlet-body">
		<div class="row">
			<div class="col-md-6">
				<!--Notes & instructions-->
				<div class="portlet blue-hoki box">
					<div class="portlet-title">
						<div class="row static-info margin-top-10">
							<div class="col-md-10 value bold">Notes & Instructions</div>
						</div>
					</div>
					<div class="portlet-body">
						<div class="row static-info margin-top-20 margin-bottom-20">
							<div class="col-md-12 name"><?php $rev_row['note'] = str_replace(PHP_EOL,'<br/>', $rev_row['note']); 
								echo $rev_row['note'];?>
							</div>
						</div>
					</div>
				</div>
				<!--Notes & instructions-->
				
				<!--Ad Design Details-->
				<div class="portlet box blue-hoki">
					<div class="portlet-title">
						<div class="row static-info margin-top-10">
							<div class="col-md-10 value bold">Ad Design Details</div>
						</div>
					</div>
					<div class="portlet-body">
						<div class="row">
							<div class="col-md-11 col-md-offset-1">
								<ul class="list-group">
									<?php 
										$ptrands = $this->db->query("SELECT * FROM `ptrands` WHERE `text` = '".$rev_row['new_slug']."'")->row_array(); 
										if($rev_row['csr']!='0')  $rev_csr = $this->db->query("SELECT * FROM `csr` WHERE `id` = '".$rev_row['csr']."'")->row_array();
										
										if($rev_row['designer']!='0')  $rev_designer = $this->db->query("SELECT * FROM `designers` WHERE `id` = '".$rev_row['designer']."'")->row_array();
										
										if($rev_row['frontline_csr']!='0')  $rev_frontline_csr = $this->db->query("SELECT * FROM `csr` WHERE `id` = '".$rev_row['frontline_csr']."'")->row_array();
										
										if(isset($ptrands['csr']) && $ptrands['csr']!='0')  $ptrands_checker = $this->db->query("SELECT * FROM `csr` WHERE `id` = '".$ptrands['csr']."'")->row_array();
									
									?>
									<li>
										Adrep - <strong><?php echo $adrep_name[0]['first_name']; ?></strong>
									</li>
									<li>
										Publication - <strong><?php echo $pub_name[0]['name']; ?></strong>
									</li>
									<?php if(isset($rev_csr)){ ?>
									<li>
										Revision Accepted by - <strong><?php echo $rev_csr['name']."	";  ?></strong>
									</li>
									<?php } if(isset($rev_designer)){ ?>
									<li>
										Revision Designed by - <strong><?php echo $rev_designer['name']."	";  ?></strong>
									</li>
									<?php } if(isset($ptrands_checker)){ ?>
									<li>
										Revision Rov Checked by - <strong><?php echo $ptrands_checker['name']."	";  ?></strong>
									</li>
									<?php } if(isset($rev_frontline_csr)){ ?>
									<li>
										Revision sent by - <strong><?php echo $rev_frontline_csr['name']."	";  ?></strong>
									</li>
									<?php } ?>
									<li>
										RevisionAd Received Time - <strong><?php $date1 = date_create($rev_row['date']);  $date2 = date_create($rev_row['time']);
										$a = date_format($date1, 'jS M, Y');
										$b = date_format($date2, 'g:i A');
										echo $a.' '.$b;?></strong>
									</li>
									<li>
										RevisionAd Sent Time - <strong><?php $rdate = date_create($rev_row['end_timestamp']); echo date_format($rdate, 'jS M, Y g:i A'); ?></strong>
									</li>
									<li>
										Time Taken - <strong><?php 
										$r_time = $rev_row['time_taken'];
										$r_seconds = $r_time%60;
										$r_mins = floor($r_time/60)%60;
										$r_hours = floor($r_time/60/60)%24;
										$r_days = floor($r_time/60/60/24);
										if($r_days!='0')echo $r_days.'day(s)';if($r_hours!='0')echo ' '.$r_hours.'hour(s)';if($r_mins!='0')echo ' '.$r_mins.'min(s)';if($r_seconds!='0')echo ' '.$r_seconds.'second(s)'; ?></strong>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--Ad Design Details-->

			<div class="col-md-6">
				<!--Conversations-->
				<div class="portlet box blue-hoki">
					<div class="portlet-title">
						<div class="row static-info  margin-top-10">
							<div class="col-md-10 value bold">Conversations</div>
						</div>
					</div>
					<div class="portlet-body">
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="scroller" style="height:200px" data-always-visible="1" data-rail-visible="0">
									<?php $qustion = $this->db->query("SELECT * FROM `production_conversation` WHERE `revision_id`='".$rev_row['id']."' order by `id` desc")->result_array(); 
											if(!isset($qustion[0]['id'])){
												echo '<p class="text-center">'."No Conversations".'</p>';
											}  
											if($qustion) { $i=0; foreach($qustion as $qustion1) { $i++; ?>
										<!--designer to CSR MESSAGE-->
									<?php if(($qustion1['designer_id']!='0') && ($qustion1['operation']=='revdesigner_QA')){ 
												$designer = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$qustion1['designer_id']."'")->result_array(); 
									?>
										<div <?php if($i=='1'){ echo'class="note note-danger"'; }else{ echo 'class="note note-grey"'; } ?>>
											<div class="row">
												<div class="col-sm-8">
													<p><?php echo $qustion1['message']; ?></p>
												</div>
												<div class="col-sm-4 text-right">
													<h4><?php  echo $designer[0]['name'];  ?> (Designer)</h4>
													<span class="font-grey-cascade small"><?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?>  </span>
												</div>
											</div>
										</div>
										<!--designer to CSR MESSAGE-->
										
										
										<!--QA to designer MESSAGE-->
									<?php } if(($qustion1['csr_id']!='0') && ($qustion1['operation']=='revcsr_designer')){ 
												$csr = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$qustion1['csr_id']."'")->result_array(); ?>
										<div <?php if($i=='1'){ echo'class="note note-danger"'; }else{ echo 'class="note note-grey"'; } ?>>
											<div class="row">
												<div class="col-sm-8">
													<p><?php echo $qustion1['message']; ?></p>
													<?php
														if(isset($rev_csr_path)){ 
															$map = glob($rev_csr_path.'/*.{jpg,png,tiff,gif,html,pdf,indd}',GLOB_BRACE);								
															if($map){			
																foreach($map as $row) {  
															?>
													<p class="margin-top-10"> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
													<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a></p>
													<?php } } } ?>
												</div>
												<div class="col-sm-4 text-right">
													<h4><?php  echo $csr[0]['name'];  ?> (CSR)</h4>
													<span class="font-grey-cascade small"><?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?>  </span>
												</div>
											</div>
										</div>
										<!--QA to designer MESSAGE-->
									<?php } } } ?>
								</div>	
							</div>
						</div>
					</div>
				</div>
				<!--Conversations-->

				<!--Question and Answer starts  -->
				<?php $question = 	$this->db->query("SELECT * FROM `orders_Q_A` WHERE `rev_id` = '".$rev_row['id']."' ORDER BY `id` DESC")->result_array(); 
							if($question) { ?>
				<div class="row margin-top-20">
					<div class="col-md-12">
						<div class="portlet box blue-hoki">
							<div class="portlet-title">
								<div class="caption static-info">
									<div class="value bold">Question & Answer </div>
								</div>	
								<div class="tools">
									<a href="javascript:;" class="expand" data-original-title="" title=""></a>
								</div>
							</div>
							<div class="portlet-body" style="display: none;">
								  <div class="scroller" style="height:180px" data-always-visible="1" data-rail-visible="0">
								  <?php foreach($question as $Qrow){
										 $Qcsr_name = 	$this->db->get_where('csr',array('id' => $Qrow['csr']))->result_array(); 
										 $adreps = 	$this->db->get_where('adreps',array('id' => $Qrow['adrep']))->result_array(); 
										 $Acsr_name = 	$this->db->get_where('csr',array('id' => $Qrow['Acsr']))->result_array(); ?>
									<div class="note note-danger margin-bottom-5">
										<div class="row">
											<div class="col-sm-6">
												<p><?php echo $Qrow['question']; ?> </p>
											</div>
											<div class="col-sm-6 text-right">
												<h4><?php echo $Qcsr_name[0]['name']; ?></h4>
												<span class="font-grey-cascade small"> at - <?php $date = date_create($Qrow['Qtimestamp']); echo date_format($date, 'g:i A \o\n l jS M Y'); ?> </span>
											</div>
										</div>
									</div>
									<?php if(isset($adreps[0]['first_name'])) { ?>
									<div class="note light-grey margin-bottom-5">
										<div class="row">
											<div class="col-sm-6">
												<?php echo $Qrow['answer']; ?>
											</div>
											<div class="col-sm-6 text-right">
												<h4><?php echo $adreps[0]['first_name'] ?></h4>
												<span class="font-grey-cascade small"> at - <?php $date = date_create($Qrow['Atimestamp']); echo date_format($date, 'g:i A \o\n l jS M Y'); ?> </span>
											</div>
										</div>
									</div>
									<?php }elseif(isset($Acsr_name[0]['name'])){ ?>
									<div class="note light-grey margin-bottom-5">
										<div class="row">
											<div class="col-sm-6">
												<?php echo $Qrow['answer']; ?>
											</div>
											<div class="col-sm-6 text-right">
												<h4><?php echo $Acsr_name[0]['name'] ?></h4>
												<span class="font-grey-cascade small"> at - <?php $date = date_create($Qrow['Atimestamp']); echo date_format($date, 'g:i A \o\n l jS M Y'); ?></span>
											</div>
										</div>
									</div>
									<?php } }?>
								  </div>
							</div>
						</div>
					</div>
				</div>	
				<?php } ?>	
				<!--Question and Answer  Ends  -->
		
				<!--Error Analysis-->
				<?php if((isset($EA) && $id == $EA)) { ?>
				<form method="POST" action="<?php echo base_url().index_page().'new_admin/home/error_analysis/'.$hd.'/'.$order_id.'/'.$EA;?>">
					<div class="portlet box blue-hoki">
						<div class="portlet-title">
							<div class="row static-info  margin-top-10"> 
								<div class="col-md-10 value bold">Error Analysis</div>
							</div>
						</div>
						<div class="portlet-body">
							<div class="row margin-bottom-25">
								<div class="col-md-12 col-sm-12 margin-bottom-5">
									<b>Is this error</b>
								</div>
								<?php $complaint_type = $this->db->get_where('complaint_type')->result_array(); ?>
								<div class="col-md-8 col-sm-12">
									<input type="radio" name="c_error" value="1" <?php if($rev_row['c_error']=='1')echo "checked= 'checked'"; ?>> Yes
									&nbsp; &nbsp; <input type="radio" name="c_error" value="2" <?php if($rev_row['c_error']=='2')echo "checked= 'checked'"; ?>> No
									<input type="text" id="rev_id" name="rev_id" value="<?php echo $rev_row['id']; ?>" readonly  style="display:none;" />
									&nbsp; &nbsp; <button type="submit" name="c_submit" class="btn btn-hover btn-xs">Save</button>
								</div>
							</div>
							<?php if($rev_row['c_error'] != '0') { ?>
							<div class="row margin-bottom-25">
								<div class="col-md-12 col-sm-12 margin-bottom-5">
									<b>Error type</b>
								</div>
								<div class="col-md-4 col-sm-12">
									<select name="complaint" class="form-control input-sm">
										<option value="">Select</option>
										<?php foreach($complaint_type as $c_row){ ?>
										<option value="<?php echo($c_row['id'])?>" <?php if($rev_row['complaint_type']==$c_row['id']){ echo "selected"; } ?> ><?php echo($c_row['name']); ?></option>
										<?php } ?>								
									</select>
								</div>
								<div class="col-md-4 col-sm-12 padding-0">
									<input type="text" id="rev_id" name="rev_id" value="<?php echo $rev_row['id']; ?>" readonly  style="display:none;" />
									<button type="submit" name="submit_error" class="btn btn-hover btn-xs">Save</button>
								</div>
							</div><?php } ?>
							<div class="row margin-bottom-10">
								<div class="col-md-12 col-sm-12 margin-bottom-5">
									<b>Is this complaint</b> 
								</div>
								<div class="col-md-8 col-sm-12">
									<input type="radio" name="c_complaint" value="1" <?php if($rev_row['c_complaint']=='1')echo "checked= 'checked'"; ?>> Yes
									&nbsp; &nbsp; <input type="radio" name="c_complaint" value="2" <?php if($rev_row['c_complaint']=='2')echo "checked= 'checked'"; ?>> No
									<input type="text" id="rev_id" name="rev_id" value="<?php echo $rev_row['id']; ?>" readonly  style="display:none;" />
									&nbsp; &nbsp; <button type="submit" name="submit_complaint" class="btn btn-hover btn-xs">Save</button>
								</div>
							</div>
						</div>
					</div>
				</form>
				<?php } ?>
				<!--Error Analysis-->
	
			</div>
		</div>
	</div>
</div>
<?php } ?>

<div class="portlet light">
<!--- V1 files-->
	<div class="portlet-title">
		<div class="row static-info">
			<div class="col-md-7 col-sm-12 value  margin-top-15 font-grey-gallery">V1 &nbsp;
				<?php if(isset($note_newad)){ ?>
				<span class="margin-right-10 font-yellow tooltips" data-container="body" data-placement="top" data-original-title="<?php echo $note_newad['note']; ?>"><i class="fa fa-warning"></i></span>
				<?php } ?> 
				<?php if(isset($cat) && $cat[0]['pro_status']!='0'){ 
						$status = $this->db->query("SELECT * FROM `production_status` WHERE id='".$cat[0]['pro_status']."'")->result_array();
							if($status) { ?>
				<span class="font-green tooltips" data-container="body" data-placement="top" data-original-title="<?php echo $status[0]['name'] ;?>"><i class="fa fa-check-circle font-lg"></i></span>
				<?php } else { echo " "; } } ?>
			</div>
			
			<?php  if(isset($sourcefile) && file_exists($sourcefile)) { 
					$map2 = glob($sourcefile.'/'.$cat[0]['slug'].'.{indd,psd}',GLOB_BRACE); 
					$map3 = glob($sourcefile.'/'.$cat[0]['slug'].'.{pdf,jpg,gif,png}',GLOB_BRACE); 
					$source_zip_file = $sourcefile.'/'.$cat[0]['slug'].'.zip' ; ?>	
			<div class="col-md-5 col-sm-12 value bold margin-top-10 no-space text-right">
				<!--PDF-->
				<?php if($cat[0]['pdf_path']!='none'){ ?>
				<div class="col-md-3 col-sm-3 col-xs-6 pull-right margin-bottom-5">
					<a href="<?php echo base_url().''.$cat[0]['pdf_path'];?>" target="_Blank" class="btn grey btn-sm btn-block">PDF</a>
				</div>
				<!--PDF-->
				
				<!--Package-->
				<?php } if(file_exists($source_zip_file)){ ?>
				
				<div class="col-md-2 col-sm-3 col-xs-6 pull-right  no-space margin-bottom-5">
					<a href="<?php echo base_url()?><?php echo $source_zip_file ?>" class="btn grey btn-sm  btn-block">Package</a>
				</div>
				
				<?php } else {
					if($map2){ 
						if($map3){ foreach($map3 as $row_map3){ $pdf_file = basename($row_map3); } }
							foreach($map2 as $row_map2){ $source_file = basename($row_map2); } ?>
							
				<div class="col-md-2 col-sm-3 col-xs-6 pull-right  no-space margin-bottom-5">
					<form action="<?php echo base_url().'index.php/new_admin/home/zip_folder_select'?>" method="post">
						<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
						<input name="new_slug" value="<?php echo $cat[0]['slug'];?>" readonly style="display:none;" />
						<input name="source_path" value="<?php echo $sourcefile;?>" readonly style="display:none;" />
						<input name="download" value="download" readonly style="display:none;" />
						<button type="submit" name="SourceDownload" class="btn grey btn-sm  btn-block">Package</button>
					</form>
				</div> 
				<?php } } ?>
				<!--Package-->
				
				<!--Downloads-->
				<?php if(isset($order_form) && file_exists($order_form)) { 
						$order_map = glob($order_form.'/*',GLOB_BRACE);
						if($order_map) { ?>
				<div class="col-md-3 col-sm-3 col-xs-6 pull-right margin-bottom-5">
					<form method="post" action="<?php echo base_url().index_page().'new_admin/home/zip_folder';?>">
						<input name="file_path" value="<?php echo $order_form; ?>" readonly style="display:none;" /> 
						<input name="file_name" value="<?php echo $order_id; ?>" readonly style="display:none;" />
						<button type="submit" name="Submit" class="btn grey btn-sm btn-block">
							Download
						</button>	
					</form>
				</div>
				<?php } } ?>
				<!--Downloads-->
			</div>
			<?php } ?>
			
		 </div>
	</div>
<!--- V1 files-->

<div class="portlet-body">
<div class="row">
<!--------------------------------- Order Info --------------------------------------->
    <div class="col-md-12">
		<div class="portlet box blue-hoki">
			<div class="portlet-title">
				<div class="row static-info margin-top-10">
					<div class="col-md-10 value bold">Order Info</div>
				</div>
			</div>
			<div class="portlet-body">
				<div class="row">
					<div class="col-md-6">
					    <div class="row static-info margin-top-10">
							<div class="col-md-5 col-xs-5 name">Unique Job Name:</div>
							<div class="col-md-7 col-xs-7 value word-break"><?php echo $orders[0]['job_no'];?></div>
						</div>    
					</div>
					<div class="col-md-6">
					    <div class="row static-info margin-top-10">
							<div class="col-md-5 col-xs-5 name">Advertiser:</div>
							<div class="col-md-7 col-xs-7 value word-break"><?php echo $orders[0]['advertiser_name'];?></div>
						</div>    
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
					    <div class="row static-info margin-top-10">
							<div class="col-md-5 col-xs-5 name">Copy/Content:</div>
							<div class="col-md-7 col-xs-7 value word-break"><?php echo nl2br($orders[0]['copy_content_description']);?></div>
						</div>    
					</div>
					<div class="col-md-6">
					    <div class="row static-info margin-top-10">
							<div class="col-md-5 col-xs-5 name">Notes & Instructions:</div>
							<div class="col-md-7 col-xs-7 value word-break"><?php echo nl2br($orders[0]['notes']); ?></div>
						</div>    
					</div>
				</div>
			</div>
		</div>
	</div>
<!--------------------------------- Order Info ENDS ---------------------------------->    
<!--Ad Design Details-->
	<div class="col-md-6">
		<div class="portlet box blue-hoki">
			<div class="portlet-title">
				<div class="row static-info margin-top-10">
					<div class="col-md-10 value bold">Ad Design Details</div>
				</div>
			</div>
			<div class="portlet-body">
				<div class="row">
					<div class="col-md-11 col-md-offset-1">
						<ul class="list-group">
							<li>
								Adrep - <strong><?php echo $adrep_name[0]['first_name']; ?></strong>
							</li>
							<li>
								Publication - <strong><?php if(isset($pub_name[0]['name'])) echo $pub_name[0]['name']; ?></strong>
							</li>
							<?php if(isset($csr)){ ?>
							<li>  
								Ad Categorized by - <strong><?php echo $csr[0]['name']."	";  ?></strong>
							</li>
							<?php } if(isset($designer)){ ?>
							<li>
								Ad Designed by - <strong><?php echo $designer[0]['name']."	";  ?></strong>
							</li>
							<?php } if(isset($tl)){ ?>
							<li>
								Ad TL checked by - <!--<strong><?php echo $tl[0]['first_name']."	";  ?></strong>-->
							</li>
							<?php } if(isset($qa_name)){ ?>
							<li>
								Ad QA checked by - <strong><?php echo $qa_name[0]['name']."	";  ?></strong>
							</li>
							<?php } if(isset($csr_name1[0]['name'])){ ?>
							<li>
								Ad DC checked by - <strong><?php echo $csr_name1[0]['name']."	";  ?></strong>
							</li>
							<?php } ?>
							<li>
								NewAd Received Time - <strong><?php $date = date_create($orders[0]['created_on']); echo date_format($date, 'g:i A jS M, Y');?></strong>
							</li>
							<li>
								NewAd Sent Time - <strong><?php $date = date_create($orders[0]['pdf_timestamp']); echo date_format($date, 'g:i A jS M, Y');?></strong>
							</li>
							<li>
								Time Taken - <strong><?php if($days!='0')echo $days.'day(s)';if($hours!='0')echo ' '.$hours.'hour(s)';if($mins!='0')echo ' '.$mins.'min(s)';if($seconds!='0')echo ' '.$seconds.'second(s)';?></strong>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
<!--Ad Design Details-->
	
<!--Conversations-->	
	<div class="col-md-6">
		<div class="portlet box blue-hoki">
			<div class="portlet-title">
				<div class="row static-info  margin-top-10">
					<div class="col-md-10 value bold">Conversations</div>
				</div>
			</div>
			<div class="portlet-body">
				<div class="row">
					<div class="col-md-12 col-sm-12">
					 <div class="scroller" style="height:200px" data-always-visible="1" data-rail-visible="0">
							<?php
								$qustion = $this->db->query("SELECT * FROM `production_conversation` WHERE `order_id`='".$order_id."' order by `id` desc")->result_array(); 
								
								  if(!isset($qustion[0]['id'])){
									echo '<p class="text-center">'."No Conversations".'</p>';
								}  
								if($qustion) { $i=0; foreach($qustion as $qustion1) { $i++; 
											
							?>
								<!--TL_designer MESSAGE-->
								<?php if(($qustion1['tl_id']!='0') && ($qustion1['operation']=='tl_designer')){ 
											$tl = $this->db->query("SELECT * FROM `team_lead` WHERE `id`='".$qustion1['tl_id']."'")->result_array(); 
								?>
									<div <?php if($i=='1'){ echo'class="note note-danger"'; }else{ echo 'class="note note-grey"'; } ?>>
										<div class="row">
											<div class="col-sm-6">
												<?php echo $qustion1['message']; ?>
												<?php
													if(isset($tl_path)){ 
														$map = glob($tl_path.'/*.{jpg,png,tiff,gif,html,pdf,indd}',GLOB_BRACE);								
														if($map){			
															foreach($map as $row) {  
														?>
												<p class="margin-top-10"> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
												<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a></p>
												<?php } } } ?>
											</div>
											<div class="col-sm-6 text-right">
												<h4><?php   echo $tl[0]['first_name']; ?> (Team Lead) </h4>
												<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
											</div>
										</div>
									</div>
									<!--TL_designer MESSAGE-->
									
									
									<!--QA to designer MESSAGE-->
								<?php } 
										if(($qustion1['csr_id']!='0') && ($qustion1['operation']=='QA_designer')) { 
											$csr = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$qustion1['csr_id']."'")->result_array();   
								?>
									<div <?php if($i=='1'){ echo'class="note note-info"'; }else{ echo 'class="note note-grey"'; } ?>>
									
										<div class="row">
											<div class="col-sm-6">
											<?php echo $qustion1['message']; ?>
											<?php if(isset($csr_path)){ 
														$map = glob($csr_path.'/*.{jpg,png,gif,tiff,html,pdf,indd}',GLOB_BRACE);								
														if($map){			
															foreach($map as $row) {  
												?>
												 <p class="margin-top-10"> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
												<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a></p>
											<?php } } } ?>
											</div>
											<div class="col-sm-6 text-right">
												<h4><?php  echo $csr[0]['name'];  ?> (CSR) </h4>
												<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
											</div>
										</div>
									</div>
									<!--QA to designer MESSAGE-->
									
									<!--DC to designer MESSAGE-->
								<?php } if(($qustion1['dc_id']!='0') && ($qustion1['operation']=='DC_designer')) { $csr = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$qustion1['dc_id']."'")->result_array();   ?>		
									
									<div <?php if($i=='1'){ echo'class="note note-success"'; }else{ echo 'class="note note-grey"'; } ?>>
										<div class="row">
											<div class="col-sm-6">
												<?php echo $qustion1['message']; ?>
												<?php if(isset($dc_csr_path)){ 
												$map = glob($dc_csr_path.'/*.{jpg,png,gif,html,tiff,pdf,indd}',GLOB_BRACE);								
												if($map){			
													foreach($map as $row){  
												?>
												<p class="margin-top-10"> Attached File - <?php echo basename($row) ?> <a href="<?php echo base_url()?><?php echo $row ?>"  target="_Blank" class="btn btn-circle btn-xs"><span class="fa fa-eye"></span></a>
												<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row; ?>" class="btn btn-circle btn-xs"><span class="fa fa-cloud-download"></span></a>
												</p>
												<?php } } } ?>
											</div>
											<div class="col-sm-6 text-right">
												<h4><?php  echo $csr[0]['name'];  ?> (CSR) </h4>
												<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
											</div>
										</div>
									</div>
									<!--DC to designer MESSAGE-->
									
									<!--designer msg-->
							<?php }  if($qustion1['designer_id']!='0') { $designer = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$qustion1['designer_id']."'")->result_array();   ?>		
									<div <?php if($i=='1'){ echo'class="note note-danger"'; }else{ echo 'class="note note-grey"'; } ?>>
										
										<div class="row">
											<div class="col-sm-6"><?php echo $qustion1['message']; ?></div>
											<div class="col-sm-6 text-right">
											<h4><?php echo $designer[0]['name'] ;?> (Designer)</h4>
												<span class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </span>
											</div>
										</div>
									</div>
								<!--designer mesg-->
								
								<!--TL to QA-->
							<?php } if(($qustion1['tl_id']!='0') && ($qustion1['operation']=='tl_QA')) { $tl = $this->db->query("SELECT * FROM `team_lead` WHERE `id`='".$qustion1['tl_id']."'")->result_array();   ?>
									<div <?php if($i=='1'){ echo'class="note note-info"'; }else{ echo 'class="note note-grey"'; } ?>>
										
										<div class="row">
											<div class="col-sm-6">
												<?php echo $qustion1['message']; ?>
											</div>
											<div class="col-sm-6 text-right">
												<h4><?php  echo $tl[0]['first_name'];  ?> (Team Lead) </h4>
												<p class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </p>
											</div>
										</div>
									</div>
								<!--TL to QA -->
								
								<!--TL to DC -->
							<?php }  if(($qustion1['tl_id']!='0') && ($qustion1['operation']=='tl_DC')) { $tl = $this->db->query("SELECT * FROM `team_lead` WHERE `id`='".$qustion1['tl_id']."'")->result_array();   ?>
									<div <?php if($i=='1'){ echo'class="note note-success"'; }else{ echo 'class="note note-grey"'; } ?>>
										<div class="row">
											<div class="col-sm-6"><?php echo $qustion1['message']; ?></div>
											<div class="col-sm-6 text-right">
											<h4><?php  echo $tl[0]['first_name'];  ?> (Team Lead) </h4>
												<span class="font-grey-cascade"> <?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </span>
											</div>
										</div>
									</div>
								<!--TL to DC-->
								
								<!--QA to DC-->
							<?php } if(($qustion1['csr_id']!='0') && ($qustion1['operation']=='QA_DC')) { $csr = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$qustion1['csr_id']."'")->result_array();   ?>
									<div <?php if($i=='1'){ echo'class="note note-danger"'; }else{ echo 'class="note note-grey"'; } ?>>
										
										<div class="row">
											<div class="col-sm-6"><?php echo $qustion1['message']; ?></div>
											<div class="col-sm-6 text-right">
											<h4><?php  echo $csr[0]['name'];  ?> (CSR) </h4>
												<span class="font-grey-cascade"><?php $date = strtotime($qustion1['time']); echo date('d M', $date).' '.'at'.' '.date('g:i a', $date); ?> </span>
											</div>
										</div>
									</div>
								<!--QA to DC-->	
							<?php } } } ?>
					</div>	
					</div>
				</div>
			</div>
		</div>
		<!--Question and Answer starts  -->
<?php foreach($orders as $row)
		if($row['question']=="1" || $row['question']=="2"){ ?>
<div class="row margin-top-20">
	<div class="col-md-12">
		<div class="portlet box blue-hoki">
			<div class="portlet-title">
				<div class="caption static-info">
					<div class="value bold">Question & Answer </div>
				</div>	
				<div class="tools">
					<a href="javascript:;" class="expand" data-original-title="" title=""></a>
				</div>
			</div>
			<div class="portlet-body" style="display: none;">
				  <div class="scroller" style="height:180px" data-always-visible="1" data-rail-visible="0">
				  <?php $question = 	$this->db->query("SELECT * FROM `orders_Q_A` WHERE `order_id` = '$order_id' ORDER BY `id` DESC")->result_array();
					//$this->db->get_where('orders_Q_A',array('order_id' => $order_id))->result_array(); 
					?>
					<?php $iq='0'; foreach($question as $Qrow){ $iq++; ?>
					<?php $csr_name = 	$this->db->get_where('csr',array('id' => $Qrow['csr']))->result_array(); ?>
					<?php $adreps = 	$this->db->get_where('adreps',array('id' => $Qrow['adrep']))->result_array(); ?>
					<?php $Acsr_name = 	$this->db->get_where('csr',array('id' => $Qrow['Acsr']))->result_array(); ?>
					<div class="note note-danger">
						<div class="row">
							<div class="col-md-6"><h4><?php echo $csr_name[0]['name']; ?></h4></div>
							<?php if($Qrow['answer']==''){  ?>
							<div class="col-md-6 text-right">
									<span>
										<a class="btn btn-info btn-xs" id="show_csr_answer">Answer</a>
									</span>
							</div>
							<?php } ?>
						</div>
						<div class="row">
							<div class="col-md-6"><?php echo $Qrow['question']; ?></div>
							<div class="col-md-6 text-right">
								<span class="font-grey-cascade">Sent at - <?php $date = date_create($Qrow['Qtimestamp']); echo date_format($date, 'g:i A \o\n l jS F Y'); ?> </span>
							</div>
						</div>
					</div>
					<?php if($Qrow['answer']==''){  ?> 
					<div class="row" id="csr_answer">
						<form method="POST" action="<?php echo base_url().index_page().'new_csr/home/cshift_answer_v2/'.$order_id;?>" class="form-horizontal" role="form" enctype="multipart/form-data">
							<div class="col-md-6">
								<textarea rows="1" name="answer" class="form-control" placeholder="Answer goes here..."></textarea>
								<input type="file" name="ufile[]" id="ufile[]" class="margin-top-10" />
								<?php if(isset($redirect)){ ?>
								<input type="text" name="redirect" id="redirect" value="<?php echo $redirect; ?>"  readonly style="display:none" />
								<?php } ?>	
								<input type="text" name="qid" id="qid" value="<?php echo $Qrow['id']; ?>"  readonly style="display:none" />
								<button type="submit" class="btn btn-sm btn-primary margin-top-10 margin-bottom-10">Submit</button>
							</div>
						</form>
					</div>
					<?php } ?>
					<?php if(isset($adreps[0]['first_name'])) { ?>
					<div class="note note-success">
						<h4><?php echo $adreps[0]['first_name'] ?></h4>
						<div class="row">
							<div class="col-md-6"><?php echo $Qrow['answer']; ?></div>
							<div class="col-md-6 text-right">
								<span class="font-grey-cascade">Replied at - <?php $date = date_create($Qrow['Atimestamp']); echo date_format($date, 'g:i A \o\n l jS F Y'); ?></span>
							</div>
						</div>
					</div>
					<?php }elseif(isset($Acsr_name[0]['name'])){ ?>
					<div class="note note-warning">
						<h4><?php echo $Acsr_name[0]['name'] ?></h4>
						<div class="row">
							<div class="col-md-6"><?php echo $Qrow['answer']; ?></div>
							<div class="col-md-6 text-right">
								<span class="font-grey-cascade">Replied at - <?php $date = date_create($Qrow['Atimestamp']); echo date_format($date, 'g:i A \o\n l jS F Y'); ?></span>
							</div>
						</div>
					</div>
					<?php } ?>
					<?php } ?>
				  </div>
			</div>
		</div>
	</div>
</div>	
<?php } ?>	
<!--Question and Answer  Ends  -->
	</div>
<!--Conversations-->	
</div>
</div>
</div>
<?php } ?>	
								
							<!-------------Revision Orderview_History Ends----------------->
										
	
<?php $this->load->view('new_admin/footer'); ?>