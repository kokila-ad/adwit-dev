<?php
	$this->load->view("new_csr/head");
?>
<!-- END HEADER -->
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
									<!--<form class="navbar-form navbar-left"  name="form" method="post" action="<?php echo base_url().index_page().'csr/home/cshift_order_search'; ?>">
										<div class="form-group">
											<input type="text" class="form-control" placeholder="Search"  name="id" autocomplete="off" required/>
										</div>
										<button type="submit" class="btn blue" name="search">Search</button>
									</form>-->
									<ul class="nav navbar-nav navbar-right">
										<li>
											<a onclick="window.location ='<?php echo base_url().index_page().'csr/home/new_cat/'.$form;?>'" href="javascript:;">
											Create New Ad </a>
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
													<a href="<?php echo base_url().index_page().'csr/home/cshift/';?><?php echo $type['id']; ?>">
													<?php echo $type['name']; ?> </a>
												</li>
												<?php } ?>
												<li class="divider">
															</li>
												<!--<li>
													<a href="<?php echo $_SERVER['PHP_SELF'];?>/all">
													All ads </a>
												</li>-->
											</ul>
										</li>
									</ul>
								</div>
								<!-- /.navbar-collapse -->
							</div>
        </div>
        </div>
        <link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/DT_bootstrap.css" rel="stylesheet" media="screen">
<?php if(isset($form)){?>
<meta http-equiv="refresh" content="<?php echo "120"; ?>;URL='<?php echo base_url().index_page().'csr/home/cshift/'.$form; ?>'">
<?php } ?>
<script src="theme001/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
		
<link rel="stylesheet" href="jq-ui/themes/base/jquery.ui.all.css" />
<script src="jq-ui/ui/jquery.ui.core.js"></script>
<script src="jq-ui/ui/jquery.ui.datepicker.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script>
    function Refresh() {
        window.parent.location = window.parent.location.href;
		<?php if (function_exists('date_default_timezone_set'))
				{
				  date_default_timezone_set('America/Chicago');
				}
				$current_time = date("H:i:s"); 
		?>
    }
</script>
<script type="text/javascript">

function flip(id)
{
 if($("#priority-"+id+"").is(':checked') )
   $("#notes-"+id+"").show();
 else
    $("#notes-"+id+"").hide();
	
} 

</script>

<script type="text/javascript">
	$(document).ready(function(e) {
	
        $('#help_desk').change(function(e) {
            window.location = "<?php echo base_url().index_page().'csr/home/cshift/';?>" + $('#help_desk').val() ;
        });
		
		
    });
	
</script>

<script type="text/javascript">	//all pending
	$(document).ready(function(e) {
        $('#display_type').change(function(e) {
		
            window.location = "<?php echo base_url().index_page().'csr/home/cshift/'.$form.'/';?>" + $('#display_type').val() ;
        });
    });
</script>
<?php if(isset($form)):?>
<div class="row">
        <div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cogs font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold uppercase">ALL</span>
							</div>
							<div class="tools">
							</div>
						</div>
						<div class="portlet-body">
							<table class="table table-striped table-bordered table-hover" id="sample_1">
							<thead>
							<tr>
								<th>
									 Date
								</th>
								<th>
									 Type
								</th>
								<th>
									 Adwit Id
								</th>
								<th>
									 Job Name
								</th>
								<th>
									 Publication
								</th>
								 <th>
									Category
								</th>
                                <th>
									 Design
								</th>
								<th>
									 QA
								</th>
								<th>
									 upload
								</th>
                                <th>
									Action
								</th>
								  
							</tr>
							</thead>
							  <tbody name="testTable" id="testTable">
<?php 
	foreach($publication as $row)
	{
			if(isset($from) && isset($to))
			{
				$orders = $this->db->query("SELECT * FROM `orders` WHERE `publication_id`='".$row['id']."' AND (`created_on` BETWEEN '$from' AND '$to') ;")->result_array();
			}else{
				$orders = $this->db->query("SELECT * FROM `orders` WHERE `publication_id`='".$row['id']."' AND (`created_on` BETWEEN '$ystday' AND '$today') ;")->result_array();		
			}
		
		$i=1;
		foreach($orders as $row1)
		{	
			$order_type = 	$this->db->get_where('orders_type',array('id' => $row1['order_type_id']))->result_array();
			//$cat_result = $this->db->get_where('cat_result',array('order_no' => $row1['id']))->result_array();
			$cat_result = $this->db->query("SELECT * FROM `csr`,`cat_result` WHERE `order_no`='".$row1['id']."' AND csr.id = cat_result.csr ")->result_array();
			if($cat_result){
				//$cat_csr = $this->db->get_where('csr',array('id' => $cat_result[0]['csr']))->result_array();
				$cat_designer = $this->db->get_where('designers',array('id' => $cat_result[0]['designer']))->result_array();
			}
			//$job_status = $this->db->get_where('cp_tool',array('order_no' => $row1['id']))->result_array();
			$job_status = $this->db->query("SELECT * FROM `csr`,`cp_tool` WHERE `order_no`='".$row1['id']."' AND csr.id = cp_tool.csr ")->result_array();
			/*if($job_status)
			{
			$cp_csr = $this->db->get_where('csr',array('id' => $job_status[0]['csr']))->result_array();
			$upload_csr = $this->db->get_where('csr',array('id' => $job_status[0]['upload_csr']))->result_array();
			}*/
			
			//if((!$job_status || $job_status[0]['upload_csr']=='0')){ 
?>
              <tr <?php if($row1['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="odd gradeX error"'; } ?>>
<!-- date -->			<td><?php $date = strtotime($row1['created_on']); echo date('Y-m-d', $date); ?></td>
<!-- type -->			<td title="<?php echo $order_type[0]['name']; ?>"><span class="badge bg-blue"><?php if($order_type[0]['id']=='1') {echo "W"; } if($order_type[0]['id']=='2') { echo "P"; } if($order_type[0]['id']=='3') { echo "P&W";}?></span></td>
<!-- order_no --> 		<td><?php echo $row1['id']; ?></td>
<!-- job_name -->		<td><?php echo $row1['job_no']; ?></td>
<!-- newspaper -->		<td><?php echo $row['name']; ?></td>
<!-- category -->		<?php if(($cat_result && $cat_result[0]['cancel']!='0') || $row1['cancel']!='0'){ 
								echo'<td></td>';
							}elseif($cat_result && $row1['rush']=='1'){ //rushad
								echo'<td title="'.$cat_result[0]['name'].'">'.$cat_result[0]['category'].'<span style="display:none;">rush</span></td>';
							}elseif($cat_result){  
								echo'<td title="'.$cat_result[0]['name'].'">'.$cat_result[0]['category'].'</td>';
							}else{?>
							<td><a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'csr/home/cshift_category/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;"><button class="btn btn-xs blue" >category</button></a></td>
						 <?php } ?>
<!-- design -->         <?php if($cat_result && $cat_result[0]['slug']!='none'){ 
								echo "<td title='".$cat_designer[0]['username']."'style='cursor:pointer;'>Completed</td>";
							}else{ echo"<td>Pending</td>"; } ?>
				                
<!-- QA -->             <?php if($job_status){ echo "<td title='".$job_status[0]['name']."' style='cursor:pointer;'>".$job_status[0]['job_status']."</td>"; }
							elseif($cat_result && $cat_result[0]['slug']!='none'){
							?>
							<td><a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'csr/home/cshift_cp_tool/'.$form.'/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;"><button class="btn btn-xs blue" >QA</button></a></td>     
						<?php	}else{ echo "<td>Pending</td>"; } ?>
			
<!-- upload -->		 <td>
						<?php if(($cat_result && $cat_result[0]['cancel']!='0') || $row1['cancel']!='0'){ echo "Cancelled" ; }elseif($job_status){
						if($job_status[0]['upload_csr']!='0'){ echo "uploaded" ; }else{  ?>
							<form name="form" method="post" enctype="multipart/form-data">
							<input type="file" name="pdf" id="pdf" value="upload PDF" accept="application/pdf" />
							
							<span style="color:#0000FF">Note</span><input type="checkbox" name="priority" id="priority-<?php echo $i; ?>" onClick="flip(<?php echo $i; ?>);" />
								<div id="notes-<?php echo $i; ?>" hidden >
									<input type="textarea" name="note" id="note"/>
		   
								</div> 
							
							<input type="submit" name="Submit" value="Submit" onclick="return confirm('Are you sure you want to end ?');" />
							<input name="id" value="<?php echo $job_status[0]['id'];?>" readonly style="display:none;" />
							<input name="order_id" value="<?php echo $row1['id'];?>" readonly style="display:none;" />
							<input name="job_slug" value="<?php echo $cat_result[0]['slug'];?>" readonly style="display:none;" />
							</form>
						<?php } } ?>
					</td>
                <!--<td><?php if($job_status && $upload_csr){echo $upload_csr[0]['name'];}else{echo "None";} ?></td>-->
<!--action:cancel -->	<?php if($job_status && $job_status[0]['upload_csr']!='0'){
							if($cat_result[0]['pdf_path']!='none')
							{ $pdf_path = 'http://www.adwitads.com/weborders/'.$cat_result[0]['pdf_path']; 
				?>
								<td><a href="<?php echo $pdf_path;?>" target="_blank" style="cursor:pointer; text-decoration: none;"><img src="<?php echo base_url()?>images/pdf.png" alt="pdf"/></a></td>
				<?php
							}else{ echo "<td>Uploaded</td>";} 
						}elseif(($cat_result && $cat_result[0]['cancel']!='0') || $row1['cancel']!='0')
						{ 
							echo"<td>Cancelled</td>"; 
						}elseif($cat_result && $cat_result[0]['question']!='none' && $cat_result[0]['answer']=='none')
						{ 
				?>
							<td><a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'csr/home/cshift_answer/'.$form.'/'.$cat_result[0]['id'];?>'" style="cursor:pointer; text-decoration: none;"><button class="btn btn-primary btn-mini" >Question Sent</button></a></td>
				<?php	}elseif($cat_result){ ?>
				<td>
				<div class="btn-group">
              <button class="btn yellow btn-xs dropdown-toggle" type="button" data-toggle="dropdown">
              action<i class="fa fa-angle-down"></i>
              </button>
              <ul class="dropdown-menu" role="menu">
               <li>
                <a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'csr/home/cshift_question/'.$cat_result[0]['id'];?>'">
                Question </a>
               </li>
               <li>
                <a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'csr/home/ordercshift_cancel/'.$form.'/'.$cat_result[0]['id'];?>'">
                Cancel</a>
               </li>
               <li>
                <a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'csr/home/delay_msg/'.$form.'/'.$row1['id'];?>'" >
                Delay </a>
               </li>
              </ul>
             </div>

				</td>
				<!--<td><a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'csr/home/ordercshift_cancel/'.$form.'/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;"><button class="btn btn-danger btn-mini" >Cancel</button></a></td>-->
                <?php }else{ echo"<td></td>"; } ?>
			  </tr>
   <?php $i++; 
	//}
   } }?>
            </tbody>
							</table>
						</div>
					</div>
				</div>
                </div>
				<?php endif;?>
		
</div>
</div>
                                  
<?php
	$this->load->view("new_csr/foot");
?>
