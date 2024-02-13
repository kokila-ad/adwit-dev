<?php $this->load->view('new_designer/head'); ?>
<style>
.note-grey, .note-grey i {
		  background-color: #f3f5f6 !important;
		  color: #b8b4b4 !important;
		  border-color: #d7d7d7 !important;
  }
.flat-radio div.radio {
		display: none;
}
.light-grey, .light-grey i {
		background-color: #f3f5f6 !important;
		color: #b8b4b4 !important;
		border-color: #d7d7d7 !important;
		}
</style>
<script>
	$(document).ready(function(){
	$("#subrev").hide();

	$("#show_subrev").click(function(){
	$("#subrev").toggle();     
	});
});
</script>
<div class="page-container">
	<div class="page-content">
		<div class="container">
							<!--------------New Ad Orderview_History Starts----------------->
<?php if(!isset($rev_orders)){ ?>

<div class="row margin-top-20">			
	<div class="col-md-12">							
		<div class="portlet light margin-0">
			<div class="portlet-titl no-space margin-top-10">
				<div class="row static-info">
					<div class="col-sm-6 value ">AdwitAds ID: <?php echo $order_id; ?><?php foreach($orders as $row)?><small class="font-grey-cascade"> &nbsp; 
					(<?php $date = strtotime($row['created_on']); echo date('d F', $date).','.date('Y', $date).' '.'at'.' '.date('g:i A', $date).' EDT';?>)</small>
					</div>
					<div class="col-sm-6 text-right">
						<div class="tools">
							<button onclick="goBack()" class="btn btn-default btn-xs">← Back</button>
						</div>
						<?php echo '<h3 style="color:#900;">'.$this->session->flashdata('message2').'</h3>'; ?>
					</div>
				</div>
			<!--	
				<?php if(!isset($order_revision_review['id'])){ ?>
				<div class="row">
					<div class="col-sm-6">
						<form action="<?php echo base_url().'index.php/new_designer/home/orderview_history/'.$hd.'/'.$order_id; ?>" method="post">
							<p><label>This revision is because of my mistake/error.?</label></p>
							<label>
							    <input type="radio" value="yes" name="mistake" class="form-control" required>Yes
							</label>
							<label>
							    <input type="radio" value="no" name="mistake" class="form-control" >No
							</label>
							<br/>
							<p><button type="submit" name="submit_mistake" class="margin-top-10" >Submit</button></p>
						</form>
					</div>
				</div>
				<?php } ?>
			-->
			</div>
		</div>
	</div>
</div>


<div class="portlet light margin-top-20">
<!--V1 Files-->
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
			<?php  if(isset($sourcefile)) { 
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
					<form action="<?php echo base_url().'index.php/new_designer/home/zip_folder_select'?>" method="post">
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
					<form method="post" action="<?php echo base_url().index_page().'new_designer/home/zip_folder';?>">
						<input name="file_path" value="<?php echo $order_form; ?>" readonly style="display:none;" /> 
						<input name="file_name" value="<?php echo $order_id; ?>" readonly style="display:none;" />
						<button type="submit" name="Submit" class="btn grey btn-sm btn-block">
							Download
						</button>	
					</form>
				</div>
				<?php } } ?>
			</div>
			<?php } ?>
		 </div>
	</div>
<!--V1 Files--->

<div class="portlet-body">
<div class="row">
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
							<?php } if(isset($csr_name1)){ ?>
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
								Time Taken - <strong><?php if(isset($days) && $days!='0')echo $days.'day(s)';if(isset($hours) && $hours!='0')echo ' '.$hours.'hour(s)';if(isset($mins) && $mins!='0')echo ' '.$mins.'min(s)';if(isset($seconds) && $seconds!='0')echo ' '.$seconds.'second(s)';?></strong>
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
</div>	
</div>	
</div>
</div>
<?php } ?>	
							<!--------------New Ad Orderview_History Ends----------------->
										
							<!-------------Revision Orderview_History Starts----------------->
<?php $i=0; if(isset($rev_orders)) { ?>

<div class="row margin-top-20">			
	<div class="col-md-12 margin-bottom-20">							
		<div class="portlet light margin-0">
			<div class="portlet-titl no-space margin-top-10 margin-bottom-10">
				<div class="row static-info">
					<div class="col-sm-6 value ">AdwitAds ID: <?php echo $order_id; ?><?php foreach($orders as $row)?><small class="font-grey-cascade"> &nbsp; 
					(<?php $date = strtotime($row['created_on']); echo date('d F', $date).','.date('Y', $date).' '.'at'.' '.date('g:i A', $date).' EDT';?>)</small>
					</div>
					<div class="col-sm-6 text-right">
						<div class="tools">
							<button onclick="goBack()" class="btn btn-default btn-xs">← Back</button>
						</div>
						<?php echo '<h3 style="color:#900;">'.$this->session->flashdata('message2').'</h3>'; ?>
					</div>
				</div>
			
			</div>
		</div>
	</div>
</div>
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
						<?php  if(isset($sourcefile)){
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
								<form action="<?php echo base_url().'index.php/new_designer/home/zip_folder_select'?>" method="post">
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
							<form method="post" action="<?php echo base_url().index_page().'new_designer/home/zip_folder';?>">
								<input name="file_path" value="<?php echo $rev_order_form; ?>" readonly style="display:none;" /> 
								<input name="file_name" value="<?php echo $order_id; ?>" readonly style="display:none;" />
								<button type="submit" name="Submit" class="btn grey btn-sm btn-block">Download</button>
							</form>
						</div>
						<?php } } } ?>
						<!--Downloads-->
						<?php }?>
					</div>
				 </div>
			</div>
<div class="portlet-body">
    	<?php 
				    $order_revision_review = $this->db->query("SELECT * FROM order_revision_review WHERE rev_id='".$rev_row['id']."';")->row_array();
			        if(!isset($order_revision_review['id'])){ 
			            $version = substr($rev_row['version'], -1); 
                        if($version == 'a'){
                            $prev_rev_chk = $this->db->query("SELECT `id` FROM cat_result WHERE `order_no`= '$order_id' AND `designer` = '".$this->session->userdata('dId')."'")->row_array(); 
                         }else{
                            $prev_version = --$version;
                            $v = 'V1'.$prev_version;
                            $prev_rev_chk = $this->db->query("SELECT `id` FROM rev_sold_jobs WHERE `order_id`= '$order_id' AND `version` = '$v' AND `designer` = '".$this->session->userdata('dId')."'")->row_array(); 
                         }   
                        if(isset($prev_rev_chk['id'])){
                
				?>
				<div class="row">
					<div class="col-sm-6">
						<form action="<?php echo base_url().'index.php/new_designer/home/orderview_history/'.$hd.'/'.$order_id; ?>" method="post">
							<p><label>This revision is because of my mistake/error?</label></p>
							<label>
							    <input type="radio" value="yes" name="mistake" class="form-control" required>Yes
							</label>
							<label>
							    <input type="radio" value="no" name="mistake" class="form-control" >No
							</label>
							<br/>
							<input type="hidden" name="version" value="<?php echo $rev_row['version']; ?>">
						    <input type="hidden" name="rev_id" value="<?php echo $rev_row['id']; ?>">
							<p><button type="submit" name="submit_mistake" class="margin-top-10" >Submit</button></p>
						</form>
					</div>
				</div>
				<?php } } ?>
<div class="row">
	
		<div class="col-md-6">
			<!--Notes & instructions-->
			<?php if($rev_row['new_slug'] != 'none'){ ?>
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
			<?php } ?>
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
									if(isset($r_days) && $r_days!='0')echo $r_days.'day(s)';if(isset($r_hours) && $r_hours!='0')echo ' '.$r_hours.'hour(s)';if(isset($r_mins) && $r_mins!='0')echo ' '.$r_mins.'min(s)';if(isset($r_seconds) && $r_seconds!='0')echo ' '.$r_seconds.'second(s)'; ?></strong>
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
			
			<?php  if(isset($sourcefile)) { 
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
					<form action="<?php echo base_url().'index.php/new_designer/home/zip_folder_select'?>" method="post">
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
					<form method="post" action="<?php echo base_url().index_page().'new_designer/home/zip_folder';?>">
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
								Ad QA checked by - <strong><?php if(isset($qa_name[0]['name'])) echo $qa_name[0]['name']."	";  ?></strong>
							</li>
							<?php } if(isset($csr_name1)){ ?>
							<li>
								Ad DC checked by - <strong><?php if(isset($csr_name1[0]['name'])) echo $csr_name1[0]['name']."	";  ?></strong>
							</li>
							<?php } ?>
							<li>
								NewAd Received Time - <strong><?php $date = date_create($orders[0]['created_on']); echo date_format($date, 'g:i A jS M, Y');?></strong>
							</li>
							<li>
								NewAd Sent Time - <strong><?php $date = date_create($orders[0]['pdf_timestamp']); echo date_format($date, 'g:i A jS M, Y');?></strong>
							</li>
							<li>
								Time Taken - <strong><?php if(isset($days) && $days!='0')echo $days.'day(s)';if(isset($hours) && $hours!='0')echo ' '.$hours.'hour(s)';if(isset($mins) && $mins!='0')echo ' '.$mins.'min(s)';if(isset($seconds) && $seconds!='0')echo ' '.$seconds.'second(s)';?></strong>
								
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
	</div>
<!--Conversations-->	
</div>
</div>
</div>
<?php } ?>	
								
							<!-------------Revision Orderview_History Ends----------------->
										
		</div>
	</div>
</div>
<?php $this->load->view('new_designer/foot'); ?>