<?php $this->load->view("new_csr/head.php"); ?>
 <?php 
     $c_orders = $this->db->query("SELECT * FROM `orders` WHERE `help_desk`='".$form."' AND `status`='1' AND `cancel`='0' AND `crequest`!='1' AND (`created_on` BETWEEN '$ystday' AND '$today') ;")->result_array();	
     $inprod = $this->db->query("SELECT * FROM `orders` WHERE `help_desk`='".$form."' AND (`status`='2' OR `status`='3') AND `cancel`='0' AND `crequest`!='1' AND (`created_on` BETWEEN '$ystday' AND '$today') ;")->result_array();	
     $inQA = $this->db->query("SELECT * FROM `cat_result` WHERE `pro_status`='3'  AND (`timestamp` BETWEEN '$ystday' AND '$today') ;")->result_array();	
     $inDC = $this->db->query("SELECT * FROM `cat_result` WHERE `pro_status`='4'  AND (`timestamp` BETWEEN '$ystday' AND '$today') ;")->result_array();	
     $upload = $this->db->query("SELECT * FROM `orders` WHERE `help_desk`='".$form."' AND `status`='4' AND `cancel`='0' AND `crequest`!='1' AND (`created_on` BETWEEN '$ystday' AND '$today') ;")->result_array();
     $All_pending = $this->db->query("SELECT * FROM `orders` WHERE `help_desk`='".$form."' AND `cancel`='0' AND `crequest`!='1' AND (`status` BETWEEN '0' AND '4') AND (`created_on` BETWEEN '$ystday' AND '$today') ;")->result_array();		
 ?>
<!-- BEGIN PAGE CONTAINER -->
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
									<?php  $type = $this->db->get_where('help_desk',array('active'=>'1','id'=>$form))->result_array(); ?>
									<a class="navbar-brand" href="javascript:;">
									<?php echo $type[0]['name']; ?> </a>
								</div>
								<!-- Collect the nav links, forms, and other content for toggling -->
								<div class="collapse navbar-collapse navbar-ex1-collapse">
									
									<ul class="nav navbar-nav">
										<li>
											<a href="<?php echo base_url().index_page().'new_csr/home/cshift/'.$form;?>">
											Category<span class="badge bg-red"><?php echo count($c_orders); ?></span></a>
										</li>
										<!--<li>
											<a href="<?php echo base_url().index_page().'new_csr/home/cshift/'.$form.'/inproduction';?>">
											In-Prod<span class="badge bg-blue"><?php echo count($inprod); ?></span></a>
										</li> -->
										<li>
											<a href="<?php echo base_url().index_page().'new_csr/home/cshift/'.$form.'/QA';?>">
											QA<span class="badge bg-green"><?php echo count($inQA); ?></span></a>
										</li>
										<li>
											<a href="<?php echo base_url().index_page().'new_csr/home/cshift/'.$form.'/DC';?>">
											DC<span class="badge bg-green"><?php echo count($inDC); ?></span></a>
										</li>
										<li class="active"> 
											<a href="<?php echo base_url().index_page().'new_csr/home/cshift/'.$form.'/upload';?>">
										    Upload<span class="badge bg-green"><?php echo count($upload); ?></span></a>
										</li>
									    <!-- <li>
											<a href="<?php echo base_url().index_page().'new_csr/home/cshift/'.$form.'/new_pending';?>">
										    All<span class="badge bg-green"><?php echo count($All_pending); ?></span></a>
										</li>-->
									</ul>
									
									
									<ul class="nav navbar-nav navbar-right">
										<li>
											<a onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/new_cat/'.$form;?>'" href="javascript:;">
											New Ad </a>
										</li>
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
													<a href="<?php echo base_url().index_page().'new_csr/home/cshift/';?><?php echo $type['id']; ?>">
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
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cogs font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold">Upload Pending List</span>
							</div>
							<div class="tools">
							</div>
						</div>
						<div class="portlet-body">
							<table class="table table-striped table-bordered table-hover" id="sample_1">
							 <thead>
            <tr>
				<th style="vertical-align: middle;">Date</th>
				<th style="vertical-align: middle;">Type</th>
                <th style="vertical-align: middle;">Adwit Id</th>
				<th style="vertical-align: middle;">Job Name</th>
				<th style="vertical-align: middle;">Publication</th>											
                <!--<th style="text-align: center;">Category</th>
                <th style="text-align: center;">Design</th>
                <th style="text-align: center;">QA</th>-->
                <th style="text-align: center;">Upload</th>
				<!--<th style="vertical-align: middle;">Actions</th>-->
              </tr>              
            </thead>
            <tbody name="testTable" id="testTable"> 
<?php 

		$i=1;
		foreach($upload as $row1)
		{
			$order_type = 	$this->db->get_where('orders_type',array('id' => $row1['order_type_id']))->result_array();
			$publication_name = $this->db->query("SELECT `name` FROM `publications` WHERE `id`='".$row1['publication_id']."' ;")->result_array();		
			$cat_result = $this->db->query("SELECT * FROM `csr`,`cat_result` WHERE `order_no`='".$row1['id']."' AND csr.id = cat_result.csr ")->result_array();
			if($cat_result){ $cat_designer = $this->db->get_where('designers',array('id' => $cat_result[0]['designer']))->result_array(); }
			
			$job_status = $this->db->query("SELECT * FROM `csr`,`cp_tool` WHERE `order_no`='".$row1['id']."' AND csr.id = cp_tool.csr ")->result_array();
			
?>
              <tr <?php if($row1['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="odd gradeX error"'; } ?>>
<!-- date -->			<td><?php $date = strtotime($row1['created_on']); echo date('Y-m-d', $date); ?></td>

<!-- type -->			<td title="<?php echo $order_type[0]['name']; ?>"><span class="badge bg-blue"><?php if($order_type[0]['value']=='print') {echo "P";} elseif($order_type[0]['value']=='web'){ echo "W";} else{ echo "P&W";}?></span></td>

<!-- order_no --> 	<td title="view attachments"><a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;"><?php echo $row1['id']; ?></a></td>

<!-- job_name -->		<td><?php echo $row1['job_no']; ?></td>

<!-- newspaper -->		<td><?php echo $publication_name[0]['name']; ?></td>

<!-- category 		 <?php if(($cat_result && $cat_result[0]['cancel']!='0') || $row1['cancel']!='0'){ 
								echo'<td>Cancelled</td>';
							}elseif($cat_result && $row1['rush']=='1'){ //rushad
								echo'<td title="'.$cat_result[0]['name'].'">'.$cat_result[0]['category'].'<span style="display:none;">rush</span></td>';
							}elseif($cat_result){  
								echo'<td title="'.$cat_result[0]['name'].'">'.$cat_result[0]['category'].'</td>';
							}else{?>
							<td><a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/cshift_category/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;"><button class="btn btn-primary btn-mini" >category</button></a></td>
						 <?php } ?>
-->
<!-- design          <?php if($cat_result && $cat_result[0]['slug']!='none'){ 
								echo "<td title='".$cat_designer[0]['username']."'style='cursor:pointer;'>Completed</td>";
							}else{ echo"<td>Pending</td>"; } ?>
--> 				           
<!-- QA               <?php if($job_status){ echo "<td title='".$job_status[0]['name']."' style='cursor:pointer;'>".$job_status[0]['job_status']."</td>"; }
							elseif($cat_result && $cat_result[0]['slug']!='none'){
							?>
							<td><a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/cshift_cp_tool/'.$form.'/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;"><button class="btn btn-primary btn-mini" >QA</button></a></td>     
						 <?php	}else{ echo "<td>Pending</td>"; } ?>
-->			 
<!-- upload -->		  <td>
						
								<!--<a href="<?php echo base_url().index_page().'new_csr/home/pdf_upload/'.$row1['id'].'/'.$job_status[0]['id'];?>" onclick="javascript:void window.open('<?php echo base_url().index_page().'new_csr/home/pdf_upload/'.$row1['id'].'/'.$job_status[0]['id'];?>','1432728298066','width=800,height=650,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=50,top=20');return false;"><button class="btn blue btn-xs">Upload</button></a>-->
								<a href="<?php echo base_url().index_page().'new_csr/home/pdf_upload/'.$row1['id'];?>" onclick="javascript:void window.open('<?php echo base_url().index_page().'new_csr/home/pdf_upload/'.$row1['id'];?>','1432728298066','width=800,height=650,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=50,top=20');return false;"><button class="btn green btn-xs" >Upload</button></a>
						
					  </td>
				
<!--action:cancel 	<?php if($job_status && $job_status[0]['upload_csr']!='0'){
							if($cat_result[0]['pdf_path']!='none')
							{ $pdf_path = 'http://www.adwitads.com/weborders/'.$cat_result[0]['pdf_path']; 
						?>
							<td><a href="<?php echo $pdf_path;?>" target="_blank" style="cursor:pointer; text-decoration: none;"><img src="images/pdf.png" alt="pdf"/></a></td>
						<?php
							}else{ echo "<td>Uploaded</td>";} 
						}elseif(($cat_result && $cat_result[0]['cancel']!='0') || $row1['cancel']!='0')
						{ 
							echo"<td>Cancelled</td>"; 
						}elseif($cat_result && $cat_result[0]['question']!='none' && $cat_result[0]['answer']=='none')
						{	
						?> 
						<td><a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/cshift_answer/'.$form.'/'.$cat_result[0]['id'];?>'" style="cursor:pointer; text-decoration: none;"><button class="btn btn-primary btn-mini" >Question Sent</button></a></td>
						<?php }elseif($cat_result){ ?>
							<td>
								<div class="btn-group">
								<a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/ordercshift_cancel/'.$form.'/'.$cat_result[0]['id'];?>'" style="cursor:pointer; text-decoration: none;"><button class="btn btn-danger btn-mini" >Cancel</button></a>
								<button data-toggle="dropdown" class="btn btn-danger btn-mini dropdown-toggle"><span class="caret"></span></button>
								<ul class="dropdown-menu">
									<li><a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_csr/home/cshift_question/'.$cat_result[0]['id'];?>'" >Question</a></li>
									<li><a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_csr/home/delay_msg/'.$form.'/'.$row1['id'];?>'" >Delay</a></li>
								</ul>
								</div>
							</td>
						<?php }else{ echo"<td></td>"; } ?>
-->						
			  </tr>
   <?php $i++;  }?>
            </tbody>
          </table>
						</div>
					</div>
				</div>
                </div>
        
		</div>
</div>
</div>
	<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->
<?php $this->load->view("new_csr/foot.php"); ?>