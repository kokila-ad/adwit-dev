<?php 
	$this->load->view("new_designer/head");
?>

<style>
.tabletools-btn-group {
 display:none;
}
</style>
<div class="page-container">
	<!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 margin-top-15">
				
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
						</div>
						<!-- count Tab start -->
					<div class="collapse navbar-collapse navbar-ex1-collapse no-space"> 
						<?php if($designers['designer_role'] == '1'){ ?>
							<ul class="nav navbar-nav">
									<?php if($display_type == 'upload_pending'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/pagination_orders/upload_pending';?>">
									&nbsp; My Q <span class="badge bg-green" id="MyQ"></span></a>
								</li>  
								
								<?php if($display_type == 'design_pending'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/pagination_orders/design_pending';?>">
									&nbsp; Total Q <span class="badge bg-blue" id="TotalQ"></span></a>
								</li>
								
								  <?php if($display_type == 'design_check'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/pagination_orders/design_check';?>">
									&nbsp; Design Check <span class="badge bg-blue" id="DcQ"> </span></a> 
								</li>
								
									<?php if($display_type == 'all_pending'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/pagination_orders/all_pending';?>">
									&nbsp; Pending <span class="badge bg-green" id="DpQ"></span></a> 
								</li>
								
								<?php if($display_type == 'all'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/pagination_orders/all';?>">
									&nbsp; All <span class="badge bg-green" id="AllQ"></span></a> 
								</li>
								
								<?php if($display_type == 'question_sent'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/pagination_orders/question_sent';?>">
									&nbsp; Question Sent <span class="badge bg-green" id="questionSent"></span></a> 
								</li>
							</ul>
						<?php }elseif($designers['designer_role'] == '2'){ ?>
							<ul class="nav navbar-nav">
								<?php if($display_type == 'design_pending'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/pagination_orders/design_pending';?>">
									&nbsp; Total Q <span class="badge bg-blue" id="TotalQ"></span></a>
								</li>
								
								  <?php if($display_type == 'design_check'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/pagination_orders/design_check';?>">
									&nbsp; Design Check <span class="badge bg-blue" id="DcQ"> </span></a> 
								</li>
								
									<?php if($display_type == 'all_pending'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/pagination_orders/all_pending';?>">
									&nbsp; Pending <span class="badge bg-green" id="DpQ"></span></a> 
								</li>
								
								<?php if($display_type == 'all'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/pagination_orders/all';?>">
									&nbsp; All <span class="badge bg-green" id="AllQ"></span></a> 
								</li>
								
								<?php if($display_type == 'question_sent'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/pagination_orders/question_sent';?>">
									&nbsp; Question Sent <span class="badge bg-green" id="questionSent"></span></a> 
								</li>
							</ul>
						<?php }elseif($designers['designer_role'] == '3' || $designers['designer_role'] == '4'){ ?>
							<ul class="nav navbar-nav">
								<?php if($display_type == 'upload_pending'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/pagination_orders/upload_pending';?>">
									&nbsp; My Q <span class="badge bg-green" id="MyQ"></span></a>
								</li>  
								
								<?php if($display_type == 'design_pending'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/pagination_orders/design_pending';?>">
									&nbsp; Total Q <span class="badge bg-blue" id="TotalQ"></span></a>
								</li>
								
							</ul>
						<?php } ?>
					</div>
					<!-- count Tab End -->	
					</div>
					
				</div>
			</div>

<!--Design Pending - TotalQ-->	
<?php if($display_type =='design_pending') { ?> 
<div class="row">
	<div class="col-md-12">
		<form Method="POST" onsubmit="return myFunction(this)">
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption">
						<?php if($designers['designer_role'] == '2') { ?>
						    <span class="caption-subject font-green-sharp bold uppercase">Assign</span>
						<?php }else{ ?>
						    <span class="caption-subject font-green-sharp bold uppercase">Design Pending</span>
						<?php } ?>
					</div>
					<div class="tools">
					    <a class="reload" onclick="myFunction()"></a>
					</div>
					
				</div>
				<div class="portlet-body">
				  <table class="table table-striped table-bordered table-hover" id="sample_6">
					<thead> 
					<tr>
					    <th style="display:none;" ></th>
						<!--<th>Date</th>-->
						<th>AdwitAds ID</th>
						<th>Page Design ID</th>
						<th>Section</th>
						<th>Unique Job Name</th>
						
						<th>Publication</th>
						<!--<th>Category</th>-->
						
						<?php if($designers['designer_role'] != '2') echo '<th>Design</th>'; ?>
						<th>Club</th>
						<th>Priority</th>
					</tr>
					</thead>
					  <tbody name="testTable" id="testTable">
					 
<?php 
//$myq = $MyQcount;

if(isset($TotalQ[0]['category'])) $max_cat = $TotalQ[0]['category']; 
foreach($TotalQ as $data){
	
		//$order_type = 	$this->db->get_where('orders_type', array('id' => $data['order_type_id']))->row_array();
		
		$publication = $this->db->query("SELECT publications.name AS publicationName, time_zone.priority AS time_zone_priority FROM `publications`
		                                    JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
		                                    WHERE publications.id='".$data['publication_id']."'")->row_array();
		                                    
		$club_name = $this->db->query("SELECT `name` FROM `club` WHERE id='".$data['club_id']."'")->row_array();
		
		$adreps = $this->db->query("SELECT adreps.first_name, adreps.last_name , adreps.premium, color_code.code FROM `adreps`
    					                            JOIN color_code ON color_code.id = adreps.color_code
		                                             WHERE adreps.id = '".$data['adrep_id']."' ;")->row_array();
		if(($designers['designer_role'] == '3' ||  $designers['designer_role'] == '4')) 
		{ 
		
?>				
		
			<tr <?php if($adreps['premium']=='1'){ echo'class="bg-yellow"'; }elseif(isset($adreps['code'])){ echo'class="'.$adreps['code'].'"'; } ?> >
	  
						<td style="display:none;"></td>

<!-- Adwit Id -->		<td><?php echo $data['id']; ?></td>

<!-- Type		<td title="<?php echo $order_type['name']; ?>">
                            <span class="badge bg-blue">
                                <?php if($order_type['value']=='print') { echo "P";} elseif($order_type['value']=='web'){ echo "W";} else{ echo "P&W";}?>
                            </span>
                        </td> -->	

<!-- Page Designt Id -->		<td><?php echo $data['page_design_id']; ?></td>

<!-- Section Name -->		<td><?php echo $data['section_name']; ?></td>

<!-- job_name -->		<?php echo '<td>'.$data['advertiser_name'].'/'.$data['job_no'].'</td>'; ?>

<!-- Publication -->	<td><?php echo $publication['publicationName']; ?></td>

<!-- Category 	<td <?php if($data['question']=='1'){ echo'class="danger"'; } if($data['question']=='2'){ echo'class="success"'; } ?>>
							<?php echo $data['category']; ?>
						</td>-->	

<!-- Design -->		    <td>
						    <button type="button" name="confirm_slug" class="btn green-jungle btn-sm" onClick="createSlug(<?php echo $data['id']; ?>);" >Start Design</button>
						</td>
						
						<td><?php echo $club_name['name']; ?></td>
						
<!-- Priority -->		<td><?php echo $publication['time_zone_priority']; ?></td>						
			</tr>
					
<?php   } elseif($designers['designer_role'] == '1' || $designers['designer_role'] == '2') { ?>

			<tr <?php if($adreps['premium']=='1'){ echo'class="bg-yellow"'; } ?> >
	  
					<td style="display:none;"></td>

<!-- Adwit Id -->	<td title="view order details">
						<a <?php if($data['rush']==1){ echo "class='font-grey-cararra'";} ?> href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_designer/home/orderview/'.$data['help_desk'].'/'.$data['id'];?>'" style="cursor:pointer; text-decoration: none;">
						<?php echo $data['id']; ?>
						</a>
					</td>

<!-- Type 		<td title="<?php echo $order_type['name']; ?>"><span class="badge bg-blue"><?php if($order_type['value']=='print') { echo "P"; } elseif($order_type['value']=='web'){ echo "W";} else{ echo "P&W";}?></span></td>-->								

<!--Page Designt Id--><td><?php echo $data['page_design_id']; ?></td>

<!-- Section Name --><td><?php echo $data['section_name']; ?></td>

<!-- job_name -->	<td><?php echo $data['job_no']; ?></td>

<!-- Publication --><td><?php echo $publication['publicationName']; ?></td>

<!-- Category 	<td <?php if($data['question']=='1'){ echo'class="danger"'; } if($data['question']=='2'){ echo'class="success"'; } ?>>
						<?php echo $data['category'];?>
					</td>-->

<?php if($designers['designer_role'] == '1'){ ?>
<!-- Design -->		<td>
						<button type="button" name="confirm_slug" class="btn green-jungle btn-sm" onClick="createSlug(<?php echo $data['id']; ?>);" >Start Design</button>
						
					</td> 
 <?php } ?>	
                    <td><?php echo $club_name['name']; ?></td>
                    
<!-- Priority -->	<td><?php echo $publication['time_zone_priority']; ?></td>	                    
			</tr>
<?php }  } ?>
				
					</tbody>
				</table>
				</div>
			</div>
		</form>
	</div>
</div>
<?php } ?>
<!--Design Pending--> 

<!--Upload Pending - MyQ-->		
<?php if($display_type=='upload_pending') { ?> 
<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="caption">
					<span class="caption-subject font-green-sharp bold uppercase">upload Pending</span>
					
				</div>
				<div class="tools">
				<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()"></a>
				</div>
			</div>
			<div class="portlet-body">
				<table class="table table-striped table-bordered table-hover" id="sample_6">
					<thead>
						<tr>
							<th>Date</th>
							<th>AdwitAds ID</th>
							<th>Page Design ID</th>
						    <th>Section</th>
							<th>Unique Job Name</th>
							<th>Adrep</th>
							<th>Publication</th>
							<!--<th>Category</th>-->
							<th>Status</th>
							<th>Club</th>
							<th>Priority</th>
						</tr>
					</thead>
					<tbody name="testTable" id="testTable">
					
				<?php 
				    foreach($MyQ as $data){
					    $order_id = $data['id'];
					    $publication = $this->db->query("SELECT publications.name AS publicationName, time_zone.priority AS time_zone_priority FROM `publications`
		                                    JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
		                                    WHERE publications.id='".$data['publication_id']."'")->row_array();
		                                    
					    $adreps = $this->db->query("SELECT adreps.first_name, adreps.last_name , adreps.premium, color_code.code FROM `adreps`
    					                            JOIN color_code ON color_code.id = adreps.color_code
		                                             WHERE adreps.id = '".$data['adrep_id']."' ;")->row_array();
		                                             
    					$status = $this->db->query("SELECT `name` FROM `production_status` WHERE id='".$data['pro_status']."'")->row_array();
    					
    					$club_name = $this->db->query("SELECT `name` FROM `club` WHERE id='".$data['club_id']."'")->row_array();
				?>
				
					<tr <?php if($data['rush']=='1'){ echo'class="bg-red-pink"'; }elseif($adreps['premium']=='1'){ echo'class="bg-yellow"'; }elseif(isset($adreps['code'])){ echo'class="'.$adreps['code'].'"'; }else{ echo'class="odd gradeX"'; } ?>>
	<!-- date -->		<td><?php $date = strtotime($data['created_on']); echo date('d-M', $date); ?></td>
	
	<!-- Adwit Id -->	<td><?php if($data['rush']==1){ echo "class='font-grey-cararra'";} ?><?php echo $data['id']; ?></td>
	
<!-- Page Designt Id --><td>
                            <a href="<?php echo base_url().index_page().'new_designer/home/page_design_upload/'.$data['page_design_id']; ?>"><?php echo $data['page_design_id']; ?></a>
                        </td>

<!-- Section Name -->   <td>
                            <a href="<?php echo base_url().index_page().'new_designer/home/page_section_upload/'.$data['sectionId']; ?>"><?php echo $data['section_name']; ?></a>
                        </td>

	<!-- job_name -->	<td><?php 
                            if($data['order_type_id'] == '6'){
                                echo $data['advertiser_name'].'/'.$data['job_no'];
                            }else{
                                echo $data['job_no'];
                            }
                        ?></td>
                        
	<!-- adrep -->		<td><?php echo $adreps['first_name'].' '.$adreps['last_name']; ?></td>
	
	<!-- Publication --><td><?php echo $publication['publicationName']; ?></td>
	
	<!-- Category 	<td <?php if($data['question']=='1') { echo 'class="danger"'; } if($data['question']=='2') { echo 'class="success"'; } ?>>
							<?php  if($data['category']){ echo $data['category']; }else{ echo 'Pending'; } ?>
						</td>-->
						
	<!-- Design -->		<td>
							<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_designer/home/orderview/'.$data['help_desk'].'/'.$data['id'];?>'" style="cursor:pointer; text-decoration: none;">
								<button class="btn blue-sunglo btn-xs"><?php if($status)echo $status['name']; else echo''; ?></button>
							</a>
						</td>
						
	<!-- Club -->		<td><?php echo $club_name['name']; ?></td>
	
<!-- Priority -->		<td><?php echo $publication['time_zone_priority']; ?></td>	
					</tr>
					<?php  } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<!--Upload Pending-->	
	
<!--design check - Design Check-->	
<?php if($display_type=='design_check') { ?>  
<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="caption">
					<?php echo '<span style="color:#900;">'.$this->session->flashdata('ext_message').'</span>'; ?>
				</div>
				<div class="tools">				
				<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()"></a>
				</div>
			</div>
			<div class="portlet-body">
			  <table class="table table-striped table-bordered table-hover" id="sample_6">
				<thead>
					<tr>
						<th>Date</th>
						<th>AdwitAds ID</th>
						<th>Page Design ID</th>
						<th>Section</th>
						<th>Unique Job Name</th>
						<th>Publication</th>
						<!--<th>C</th>-->
						<th>Designer</th>
						<th>Status</th>
						<th>Priority</th>
				   </tr>  
				</thead>
				<tbody>
<?php 
	foreach($DcQ as $data){
		$order_id = $data['order_id'];
		$publication = $this->db->query("SELECT publications.name AS publicationName, time_zone.priority AS time_zone_priority FROM `publications`
		                                    JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
		                                    WHERE publications.id='".$data['publication_id']."'")->row_array();
		                                    
		$adreps = $this->db->query("SELECT adreps.first_name, adreps.last_name , adreps.premium, color_code.code FROM `adreps`
    					                            JOIN color_code ON color_code.id = adreps.color_code
		                                             WHERE adreps.id = '".$data['adrep_id']."' ;")->row_array();
		                                             
		$status = $this->db->get_where('production_status',array('id' => $data['pro_status']))->row_array();
		
		if(isset($data['designer'])){				
			$designer_pending = $this->db->query("SELECT `username` FROM `designers` WHERE `id`='".$data['designer']."' ;")->row_array();
		}
		
?>
				<tr <?php if($data['rush']=='1'){ echo'class="bg-red-pink"'; }elseif($adreps['premium']=='1'){ echo'class="bg-yellow"'; }elseif(isset($adreps['code'])){ echo'class="'.$adreps['code'].'"'; }else{ echo'class="odd gradeX"'; } ?>>
				
					<td><?php $date = strtotime($data['created_on']); echo date('d-M', $date); ?></td>
					
					<td>
    					<a <?php if($data['rush']==1){ echo "class='font-grey-cararra'";} ?> href="<?php echo base_url().index_page().'new_designer/home/orderview/'.$data['help_desk'].'/'.$data['id']; ?>">
    					<?php echo $data['id']; ?></a>
					</td>

<!-- Page Designt Id --><td><?php echo $data['page_design_id']; ?></td>

<!-- Section Name -->   <td><?php echo $data['section_name']; ?></td>

					<td><?php echo $data['job_no']; ?></td>
					
					<!--<td><?php echo $adreps['first_name'].' '.$adreps['last_name'];?></td>-->
					
					<td><?php echo $publication['publicationName'];?></td>
					
					<!--<td <?php if($data['question']=='1') { echo 'class="danger"'; } if($data['question']=='2') { echo 'class="success"'; } ?>>
						<?php echo $data['category']; ?>
					</td>-->
					
<!-- Designer -->	<td><?php if(isset($designer_pending['username'])){ echo $designer_pending['username']; } else { echo ' ' ; }?></td>				
					
<!--Status-->		<td>
						<a  class="btn btn-xs btn-success" <?php if($data['rush']==1){ echo "class='font-grey-cararra'";} ?> href="<?php echo base_url().index_page().'new_designer/home/orderview/'.$data['help_desk'].'/'.$data['id']; ?>">
							<?php if(isset($status['name'])) { echo $status['name']; } else{ echo"None"; } ?>
						</a>
						<!--temp file check in directory
							<?php
							$inddtemp1 = $cat_result['source_path'].'/'.'temp1'.".indd";
							$pdftemp1 = $cat_result['source_path'].'/'.'temp1'.".pdf";
							
							$inddtemp2 = $cat_result['source_path'].'/'.'temp2'.".indd";
							$pdftemp2 = $cat_result['source_path'].'/'.'temp2'.".pdf";
							
							$inddtemp3 = $cat_result['source_path'].'/'.'temp3'.".indd";
							$pdftemp3 = $cat_result['source_path'].'/'.'temp3'.".pdf";
							
							if((file_exists($inddtemp1) && file_exists($pdftemp1)) || (file_exists($inddtemp2) && file_exists($pdftemp2)) ||
							(file_exists($inddtemp3) && file_exists($pdftemp3))) { ?>
								<i class="fa fa-flag"></i>
							<?php } else{ echo ' ';}
							?>
						temp file check in directory-->
					</td>

<!-- Priority -->	<td><?php echo $publication['time_zone_priority']; ?></td>					
				</tr>
			<?php }?>	
				</tbody>
			</table>
			</div>
		</div>
	</div>
</div>	
<?php } ?>
<!--design check-->	
	
<!--All Pending - Pending-->	
<?php if($display_type=='all_pending') { ?>
<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="tools">
				<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()"></a>
				</div>
			</div>
			<div class="portlet-body">
			 <table class="table table-striped table-bordered table-hover" id="sample_6">
				<thead>
					<tr>
						<th>Date</th>
						<th>AdwitAds ID</th>
						<th>Page Design ID</th>
						<th>Section</th>
						<th>Unique Job Name</th>
						<th>Adrep</th>
						<th>Publication</th>
						<!--<th>C</th>-->
						<th>Designer</th>
						<th>Status</th>
						<th>Priority</th>
				   </tr>  
				</thead>
				<tbody>
			<?php 
				foreach($DpQ as $data){
					    $publication = $this->db->query("SELECT publications.name AS publicationName, time_zone.priority AS time_zone_priority FROM `publications`
		                                    JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
		                                    WHERE publications.id='".$data['publication_id']."'")->row_array();
		                                    
						$adreps = $this->db->query("SELECT adreps.first_name, adreps.last_name , adreps.premium, color_code.code FROM `adreps`
    					                            JOIN color_code ON color_code.id = adreps.color_code
		                                             WHERE adreps.id = '".$data['adrep_id']."' ;")->row_array();
						if($data['pro_status']!='0'){
							$status = $this->db->get_where('production_status',array('id' => $data['pro_status']))->row_array();					
						}else{
							$status = 	$this->db->get_where('order_status',array('id' => $data['status']))->row_array();					
						}
						//$design_assign = $this->db->get_where('design_assign')->result_array();
						if(isset($data['designer'])){				
							$designer_pending = $this->db->query("SELECT `username` FROM `designers` WHERE `id`='".$data['designer']."' ;")->row_array();
						}
					
			?>
			    <tr <?php if($data['rush']=='1'){ echo'class="bg-red-pink"'; }elseif($adreps['premium']=='1'){ echo'class="bg-yellow"'; }elseif(isset($adreps['code'])){ echo'class="'.$adreps['code'].'"'; }else{ echo'class="odd gradeX"'; } ?>>
					
					<td><?php $date = strtotime($data['created_on']); echo date('d-M', $date); ?></td>
					
					<td><a <?php if($data['rush']==1){ echo "class='font-grey-cararra'";} ?> href="<?php echo base_url().index_page().'new_designer/home/orderview/'.$data['help_desk'].'/'.$data['id']; ?>"><?php echo $data['id']; ?></a></td>

<!-- Page Designt Id --><td><?php echo $data['page_design_id']; ?></td>

<!-- Section Name -->   <td><?php echo $data['section_name']; ?></td>

					<td><?php echo $data['job_no']; ?></td>
					
					<td><?php echo $adreps['first_name'].' '.$adreps['last_name'];?></td>
					
					<td><?php echo $publication['publicationName'];?></td>
					
					<!--<td <?php if($data['question']=='1') { echo 'class="danger"'; } if($data['question']=='2') { echo 'class="success"'; } ?>><?php echo $data['category']; ?></td>-->
					
<!-- Designer -->	<td><?php if(isset($data['designer']) && isset($designer_pending['username'])){ echo $designer_pending['username']; } else { echo ' ' ; }?></td>

					<td><a class="btn btn-xs btn-success" href="<?php echo base_url().index_page().'new_designer/home/orderview/'.$data['help_desk'].'/'.$data['id']; ?>"><?php if(isset($status['name'])) { echo $status['name']; } else{ echo"None"; } ?></a></td>
					
<!-- Priority -->	<td><?php echo $publication['time_zone_priority']; ?></td>				
				</tr>
				
			<?php  } ?>	
				
				</tbody>
			</table>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<!--All Pending-->	      
			
<!-- all - All-->
<?php if($display_type=='all') { ?> 
<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="tools">
				<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()"></a>
				</div>
			</div>
			<div class="portlet-body">
				<table class="table table-striped table-bordered table-hover" id="sample_6">
					<thead>
						<tr>
							<th>Date</th>
							<!--<th>Type</th>-->
							<th>AdwitAds ID</th>
							<th>Page Design ID</th>
						    <th>Section</th>
							<th>Unique Job Name</th>
							<th>Adrep</th>
							<th>Publication</th>
							<th>Group</th>
							<th>Status</th>
							<th>Club</th>
							<th>Priority</th>
					   </tr>  
					</thead>
					<tbody>
					
				<?php foreach($AllQ as $data){
					
					//$order_type = 	$this->db->get_where('orders_type', array('id' => $data['order_type_id']))->row_array();
					
					$adreps = $this->db->query("SELECT adreps.first_name, adreps.last_name , adreps.premium, color_code.code FROM `adreps`
    					                            JOIN color_code ON color_code.id = adreps.color_code
		                                             WHERE adreps.id = '".$data['adrep_id']."' ;")->row_array();
		                                             
					$status = 	$this->db->get_where('order_status',array('id' => $data['status']))->row_array();					
					
					$group = $this->db->query("SELECT `name` FROM `Group` WHERE `id` = '".$data['group_id']."'")->row_array();
					
					$club_name = $this->db->query("SELECT `name` FROM `club` WHERE id='".$data['club_id']."'")->row_array();
				 ?>
					<tr <?php if($data['rush']=='1'){ echo'class="bg-red-pink"'; }elseif($adreps['premium']=='1'){ echo'class="bg-yellow"'; }elseif(isset($adreps['code'])){ echo'class="'.$adreps['code'].'"'; }else{ echo'class="odd gradeX"'; } ?>>
						<td><?php $date = strtotime($data['created_on']); echo date('d-M', $date); ?></td>
						
						<!--<td title="<?php echo $order_type['name']; ?>"><span class="badge bg-blue"><?php if($order_type['value']=='print') {echo "P";} elseif($order_type['value']=='web'){ echo "W";} else{ echo "P&W";}?></span></td>-->
						
						<td><a <?php if($data['rush']==1){ echo "class='font-grey-cararra'";} ?> href="<?php echo base_url().index_page().'new_designer/home/orderview/'.$data['help_desk'].'/'.$data['id']; ?>" ><?php echo $data['id']; ?></a></td>

<!-- Page Designt Id --><td><?php echo $data['page_design_id']; ?></td>

<!-- Section Name -->   <td><?php echo $data['section_name']; ?></td>

						<td><?php echo $data['job_no']; ?></td>
						
						<td><?php echo $adreps['first_name'].' '.$adreps['last_name'];?></td>
						
						<td><?php echo $data['name'];?></td>
						
						<td><?php echo $group['name'];?></td>
						
						<td>
						<a class="btn btn-xs btn-success" href="<?php echo base_url().index_page().'new_designer/home/orderview/'.$data['help_desk'].'/'.$data['id']; ?>" ><?php if(isset($status['name'])) { echo $status['name']; } else{ echo""; } ?></a>
						</td>
						
						<td><?php echo $club_name['name']; ?></td>
						
<!-- Priority -->		<td><?php echo $data['time_zone_priority']; ?></td>						
					</tr>
				<?php  } ?>	
					
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php } ?>		
<!-- all-->

<!--Question Sent-->	
<?php if($display_type=='question_sent') { ?>
<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="tools">
				<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()"></a>
				</div>
			</div>
			<div class="portlet-body">
			 <table class="table table-striped table-bordered table-hover" id="sample_6">
				<thead>
					<tr>
						<th>Date</th>
						<th>AdwitAds ID</th>
						<th>Unique Job Name</th>
						<th>Adrep</th>
						<th>Publication</th>
						<!--<th>C</th>-->
						<th>Designer</th>
						<th>Status</th>
						<th>Priority</th>
				   </tr>  
				</thead>
				<tbody>
			<?php 
				foreach($question_sent as $data){
					$publication = $this->db->query("SELECT publications.name AS publicationName, time_zone.priority AS time_zone_priority FROM `publications`
		                                    JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
		                                    WHERE publications.id='".$data['publication_id']."'")->row_array();
		                                    
					$adreps = $this->db->query("SELECT adreps.first_name, adreps.last_name , adreps.premium, color_code.code FROM `adreps`
    					                            JOIN color_code ON color_code.id = adreps.color_code
		                                             WHERE adreps.id = '".$data['adrep_id']."' ;")->row_array();
					if($data['pro_status']!='0'){
						$status = $this->db->get_where('production_status',array('id' => $data['pro_status']))->row_array();					
					}else{
						$status = 	$this->db->get_where('order_status',array('id' => $data['status']))->row_array();					
					}
					
					if(isset($data['designer'])){				
						$designer_pending = $this->db->query("SELECT `username` FROM `designers` WHERE `id`='".$data['designer']."' ;")->row_array();
					}
					
			?>
			    <tr <?php if($data['rush']=='1'){ echo'class="bg-red-pink"'; }elseif($adreps['premium']=='1'){ echo'class="bg-yellow"'; }elseif(isset($adreps['code'])){ echo'class="'.$adreps['code'].'"'; }else{ echo'class="odd gradeX"'; } ?>>
			        
					<td><?php $date = strtotime($data['created_on']); echo date('d-M', $date); ?></td>
					
					<td><a <?php if($data['rush']==1){ echo "class='font-grey-cararra'";} ?> href="<?php echo base_url().index_page().'new_designer/home/orderview/'.$data['help_desk'].'/'.$data['id']; ?>"><?php echo $data['id']; ?></a></td>

<!-- Page Designt Id --><td><?php echo $data['page_design_id']; ?></td>

<!-- Section Name -->   <td><?php echo $data['section_name']; ?></td>

					<td><?php echo $data['job_no']; ?></td>
					
					<td><?php echo $adreps['first_name'].' '.$adreps['last_name'];?></td>
					
					<td><?php echo $publication['publicationName'];?></td>
					
					<!--<td <?php if($data['question']=='1') { echo 'class="danger"'; } if($data['question']=='2') { echo 'class="success"'; } ?>><?php echo $data['category']; ?></td>-->
					
<!-- Designer -->	<td><?php if(isset($data['designer']) && isset($designer_pending['username'])){ echo $designer_pending['username']; } else { echo ' ' ; }?></td>

					<td><a class="btn btn-xs btn-success" href="<?php echo base_url().index_page().'new_designer/home/orderview/'.$data['help_desk'].'/'.$data['id']; ?>"><?php if(isset($status['name'])) { echo $status['name']; } else{ echo"None"; } ?></a></td>
					
<!-- Priority -->	<td><?php echo $publication['time_zone_priority']; ?></td>				
				</tr>
				
			<?php } ?>	
				
				</tbody>
			</table>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<!--Question Sent-->

		</div>
	</div>
</div>
<!-- END PAGE CONTENT -->
<!-- END PAGE CONTAINER -->
<!-- BEGIN FOOTER -->

<script type="text/javascript">
    $(document).ready(function(){
    	$.ajax({
    		url: "<?php echo base_url().index_page().'new_designer/home/pagination_tab_count';?>",
    		//cache: false,
    		success: function(data){
    			var myObj = JSON.parse(data);
    			$('#MyQ').html(myObj.MyQCount);
    			$('#TotalQ').html(myObj.TotalQCount);
    			$('#DcQ').html(myObj.DcQCount);
    			$('#DpQ').html(myObj.DpQCount);
    			$('#AllQ').html(myObj.AllQCount);
    			$('#questionSent').html(myObj.questionSentCount);	
    		}
    	});
    	//$('#MyQ').html('110');
    	
    	$('.adwitad_id').on('hover',function(){ var id = $(this).data('adwitad_id'); alert('ID : '+id); });
    });
      function myFunction() {
            var checkbox= document.querySelector('input[name="assign[]"]:checked');
    		var checkbox1= document.querySelector('input[name="assign_designer[]"]:checked');
      if(!checkbox && !checkbox1) {
        alert('Please select!');
        return false;
      }
    
    }
</script>

<script type="text/javascript"> 
    function conf() { var con = alert("Please complete 'My Q' before you take a new ad(Allowed Limit In-Production: 3, In-QA: 10 Ads)."); } 

    function catconf() { var con=confirm("Lower category ads Not allowed.. As You still have higher category ads pending.."); }

    function createSlug(order_id){
	//ajax
			$.ajax({
					url: "<?php echo base_url().index_page();?>new_designer/home/createSlug/"+order_id,
					success: function(data) { 
					    var myObj = JSON.parse(data);
							var slug = myObj.slug;
							var alert_msg = myObj.msg;
							if(alert_msg != ''){
								alert(alert_msg);
								return false;
							}
					   		var X = confirm('Confirm Slug : '+slug);
						    if(X == true && slug != '')	 {
						     	var data_id = myObj.cat_id;
                    			var confirm_slug = 'none';
                    			var help_desk = myObj.help_desk;
                				//ajax
                				$.ajax({
                					url: "<?php echo base_url().index_page();?>new_designer/home/orderview/"+help_desk+"/"+order_id,
                					data:'slug='+slug+'&data_id='+data_id+'&confirm_slug='+confirm_slug,
                					type: "POST",
                					success: function(msg) { window.location.href = "<?php echo base_url().index_page();?>new_designer/home/orderview/"+help_desk+"/"+order_id; }
                				});	
                				return true;  
                			}else { 
								return false;  
                			}
					}
			});	
			return true;  
		
	}
</script>

<?php 
	$this->load->view("new_designer/foot");
?>